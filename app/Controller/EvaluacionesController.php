
<?php

App::uses('CakeTime', 'Utility');

class EvaluacionesController extends AppController {
	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('Evaluacion');

	/**
	 * Método lista todos las evaluaciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'fields' => array(
				'Evaluacion.*',
				'TipoEvaluacion.*',
				'PersonaCentroFamiliar.*',
				'Persona.pers_nombres',
				'Persona.pers_ap_paterno',
				'Persona.pers_ap_materno',
				'Persona.pers_run',
				'Persona.pers_run_dv',
				'CentroFamiliar.cefa_nombre'
			),
			'contain' => array(
				'TipoEvaluacion',
				'PersonaCentroFamiliar'
			),
			'joins' => array(
		        array(
		            'table' => 'personas',
		            'alias' => 'Persona',
		            'type' => 'INNER',
		            'conditions' => array(
		                'PersonaCentroFamiliar.pers_id = Persona.pers_id'
		            )
		        ),
		        array(
		            'table' => 'centros_familiares',
		            'alias' => 'CentroFamiliar',
		            'type' => 'INNER',
		            'conditions' => array(
		                'PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id'
		            )
		        )
		    )
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);

			$paginate['conditions'] = array(
				'LOWER(TipoEvaluacion.tiev_nombre || \' \' || CentroFamiliar.cefa_nombre || \' \' || pers_run || \' \' || pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno) LIKE \'%'. $t .'%\''
			);
		}

		// si viene el filtro de centro familiar
		if (!empty($this->request->query['cefaId'])) {
			$cefa_id = $this->request->query['cefaId'];
			$paginate['conditions'][] = sprintf('CentroFamiliar.cefa_id = %d', $cefa_id);
			$this->set('cefaIdFilter', $cefa_id);
		}

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$paginate['conditions'][] = sprintf('CentroFamiliar.cefa_id = %d', $this->cefa_id);
		}

		$this->paginate = $paginate;

		// buscamos centros familiares para filtro
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('centrosFamiliares', $centrosFamiliares);
		$this->set('evaluaciones', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva evaluación
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Evaluacion->create();
			$this->Evaluacion->set($this->request->data);

			unset($this->request->data['CentroFamiliar']);
			unset($this->request->data['Persona']);

			if ($this->request->data['Evaluacion']['tiev_id'] == 2) {
				unset($this->request->data['EvaluacionFactorRiesgo']);
			}

			if (empty($this->request->data['Evaluacion']['pecf_id'])) {
				$this->Evaluacion->invalidate('tiev_id', __('Debe seleccionar a la persona que desea evaluar'));
			}

			if (empty($this->request->data['EvaluacionFactorProtector'])) {
				$this->Evaluacion->invalidate('tiev_id', __('No existen factores de riesgos asociados al grupo objetivo de la persona'));
			}

			if ($this->Evaluacion->validates()) {
				if ($this->Evaluacion->saveAssociated($this->request->data)) {
					$this->Session->setFlash(__('La evaluación ha sido guardada.'), 'success_alert');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se pudo guardar la evaluación. Por favor inténtelo nuevamente.'), 'error_alert');
				}
			} else {
				$this->Session->setFlash(__('No se pudo guardar la evaluación. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$tiposEvaluaciones = $this->Evaluacion->TipoEvaluacion->find('list');
		$factoresRiesgos = $this->Evaluacion->EvaluacionFactorRiesgo->FactorRiesgo->find('all',
			array(
				'order' => array(
					'FactorRiesgo.fari_descripcion ASC'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => 'CentroFamiliar.cefa_nombre ASC'
				)
			);
		} else {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => 'CentroFamiliar.cefa_nombre ASC'
				)
			);
		}
		
		$this->set(compact('centrosFamiliares', 'tiposEvaluaciones', 'factoresRiesgos'));

	}

	/**
	 * Método edita una evaluación
	 * 
	 * @param int $eval_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($eval_id) {
		if (!$this->Evaluacion->exists($eval_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Evaluacion->EvaluacionFactorProtector->saveMany($this->request->data['EvaluacionFactorProtector'])) {
				if ($this->Evaluacion->EvaluacionFactorRiesgo->saveMany($this->request->data['EvaluacionFactorRiesgo'])) {
					$this->Session->setFlash(__('La evaluación ha sido guardada.'), 'success_alert');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se pudo guardar la evaluación. Por favor inténtelo nuevamente.'), 'error_alert');	
				}
			} else {
				$this->Session->setFlash(__('No se pudo guardar la evaluación. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'contain' => array(
					'PersonaCentroFamiliar' => array(
						'Persona'
					),
					'EvaluacionFactorProtector' => array(
						'IndicadorFactorProtector'
					),
					'EvaluacionFactorRiesgo'
				),
				'conditions' => array(
					'Evaluacion.' . $this->Evaluacion->primaryKey => $eval_id
				)
			);

			$this->request->data = $this->Evaluacion->find('first', $conditions);
			$this->request->data['CentroFamiliar']['cefa_id'] = $this->request->data['PersonaCentroFamiliar']['cefa_id'];
			$this->request->data['Persona']['pers_nombre'] = $this->request->data['PersonaCentroFamiliar']['Persona']['pers_nombre_completo']." (".$this->request->data['PersonaCentroFamiliar']['Persona']['pers_run_completo'].")";
			$this->request->data['Evaluacion']['eval_fecha'] = CakeTime::format($this->request->data['Evaluacion']['eval_fecha'], '%d-%m-%Y');
 		}

		$tiposEvaluaciones = $this->Evaluacion->TipoEvaluacion->find('list');

		/*
		// encontramos niveles segun el grupo objetivo de la persona
		$grob_id = $this->request->data['Evaluacion']['grob_id'];
		$niveles = $this->Evaluacion->EvaluacionFactorProtector->IndicadorFactorProtector->FactorProtector->Nivel->find('all',
			array(
				'conditions' => array(
					'Nivel.grob_id' => $grob_id
				),
				'contain' => array(
					'FactorProtector' => array(
						'IndicadorFactorProtector' => array(
							'order' => 'IndicadorFactorProtector.ifpr_descripcion'
						)
					)
				)
			)
		);
		*/

		$factoresRiesgos = $this->Evaluacion->EvaluacionFactorRiesgo->FactorRiesgo->find('all',
			array(
				'order' => array(
					'FactorRiesgo.fari_descripcion ASC'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => 'CentroFamiliar.cefa_nombre ASC'
				)
			);
		} else {
			$centrosFamiliares = $this->Evaluacion->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => 'CentroFamiliar.cefa_nombre ASC'
				)
			);
		}

		$this->set(compact('centrosFamiliares', 'tiposEvaluaciones', 'niveles', 'factoresRiesgos'));
	}

	/**
	 * Método revisa detalle de una evaluación
	 * 
	 * @param int $eval_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($eval_id) {
		if (!$this->Evaluacion->exists($eval_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$evaluacion = $this->Evaluacion->find('first',
			array(
				'contain' => array(
					'PersonaCentroFamiliar' => array(
						'Persona',
						'CentroFamiliar'
					),
					'GrupoObjetivo',
					'TipoEvaluacion',
					'EvaluacionFactorProtector' => array(
						'IndicadorFactorProtector'
					),
					'EvaluacionFactorRiesgo' => array(
						'FactorRiesgo'
					)
				),
				'conditions' => array(
					'Evaluacion.eval_id' => $eval_id
				)
			)
		);

		// segun el grupo objetivo, obtenemos niveles y factores protectores
		$grob_id = $evaluacion['Evaluacion']['grob_id'];

		// sacamos el año de la evaluación para ir a buscar los factores protectores del mismo año
		$anio = date('Y', strtotime($evaluacion['Evaluacion']['eval_fecha_creacion']));

		$niveles = $this->Evaluacion->EvaluacionFactorProtector->IndicadorFactorProtector->FactorProtector->Nivel->find('all',
			array(
				'conditions' => array(
					'Nivel.grob_id' => $grob_id
				),
				'contain' => array(
					'FactorProtector' => array(
						'conditions' => array(
							'FactorProtector.fapr_ano' => $anio
						),
						'IndicadorFactorProtector' => array(
							'order' => 'IndicadorFactorProtector.ifpr_descripcion'
						)
					)
				)
			)
		);
		
		$this->set(compact('evaluacion', 'niveles'));
	}

	/**
	 * Método elimina una evaluación
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $eval_id
	 * @return void
	 */
	public function delete($eval_id = null) {
		$this->Evaluacion->id = $eval_id;
		if (!$this->Evaluacion->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Evaluacion->delete()) {
			$this->Session->setFlash(__('La evaluación ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la evaluación. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}