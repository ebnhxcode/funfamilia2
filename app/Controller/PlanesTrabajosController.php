<?php
class PlanesTrabajosController extends AppController {
	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('PlanTrabajo');

	/**
	 * Método lista todos los planes de trabajos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'fields' => array(
				'PlanTrabajo.*',
				'PersonaCentroFamiliar.pers_id',
				'PersonaCentroFamiliar.pecf_id',
				'Persona.pers_nombres',
				'Persona.pers_ap_paterno',
				'Persona.pers_ap_materno',
				'CentroFamiliar.cefa_nombre'
			),
			'contain' => array(
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
			),
			'order' => array(
				'PlanTrabajo.pltr_fecha_creacion DESC'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);

			$paginate['conditions'] = array(
				'LOWER(cefa_nombre || \' \' || pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno) LIKE \'%'. $t .'%\''
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
			$centrosFamiliares = $this->PlanTrabajo->PersonaCentroFamiliar->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->PlanTrabajo->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('centrosFamiliares', $centrosFamiliares);
		$this->set('planesTrabajos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo plan de trabajo
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PlanTrabajo->create();

			// quitamos los vacios
			$infoDept = array();
			foreach($this->request->data['DetallePlanTrabajo'] as $dept) {
				if (!empty($dept['acti_id'])) {
					$infoDept[] = $dept;
				}
			}

			unset($this->request->data['Persona']);
			unset($this->request->data['CentroFamiliar']);
			$this->request->data['DetallePlanTrabajo'] = $infoDept;

			if ($this->PlanTrabajo->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('El plan de trabajo ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el plan de trabajo. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->PlanTrabajo->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => array(
						'CentroFamiliar.cefa_nombre'
					)
				)
			);
		} else {
			$centrosFamiliares = $this->PlanTrabajo->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre'
					)
				)
			);
		}
		$this->set(compact('niveles', 'centrosFamiliares'));
	}

	/**
	 * Método edita un plan de trabajo
	 * 
	 * @param int $pltr_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($pltr_id) {
		if (!$this->PlanTrabajo->exists($pltr_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			// quitamos los vacios
			$infoDept = array();
			foreach($this->request->data['DetallePlanTrabajo'] as $dept) {
				if (!empty($dept['acti_id'])) {
					$dept['pltr_id'] = $this->request->data['PlanTrabajo']['pltr_id'];
					$infoDept[] = $dept;
				}
			}

			unset($this->request->data['Persona']);
			unset($this->request->data['CentroFamiliar']);
			$this->request->data['DetallePlanTrabajo'] = $infoDept;

			if ($this->PlanTrabajo->save($this->request->data)) {
				if (!empty($infoDept)) {
					$this->PlanTrabajo->DetallePlanTrabajo->deleteAll(array('DetallePlanTrabajo.pltr_id' => $this->request->data['PlanTrabajo']['pltr_id']));

					if ($this->PlanTrabajo->DetallePlanTrabajo->saveMany($this->request->data['DetallePlanTrabajo'])) {
						$this->Session->setFlash(__('El plan de trabajo ha sido guardado.'), 'success_alert');
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('No se pudo guardar el plan de trabajo. Por favor inténtelo nuevamente.'), 'error_alert');
					}
				} else {
					$this->Session->setFlash(__('El plan de trabajo ha sido guardado.'), 'success_alert');
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('No se pudo guardar el plan de trabajo. Por favor inténtelo nuevamente.'), 'error_alert');

			}
		} else {
			$conditions = array(
				'fields' => array(
					'PlanTrabajo.*',
					'PersonaCentroFamiliar.*',
					'Persona.pers_nombres',
					'Persona.pers_ap_paterno',
					'Persona.pers_ap_materno',
					'Persona.pers_run',
					'Persona.pers_run_dv',
					'Persona.grob_id',
					'CentroFamiliar.cefa_id'
				),
				'conditions' => array(
					'PlanTrabajo.' . $this->PlanTrabajo->primaryKey => $pltr_id
				),
				'contain' => array(
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

			$this->request->data = $this->PlanTrabajo->find('first', $conditions);
			$this->request->data['Persona']['pers_nombre'] = $this->request->data['Persona']['pers_nombres'].' '.$this->request->data['Persona']['pers_ap_paterno'].' '.$this->request->data['Persona']['pers_ap_materno'].' ('.$this->request->data['Persona']['pers_run'].'-'.$this->request->data['Persona']['pers_run_dv'].')';

			$detallesPlanesTrabajosInfo = $this->PlanTrabajo->DetallePlanTrabajo->find('all',
				array(
					'conditions' => array(
						'DetallePlanTrabajo.pltr_id' => $pltr_id
					),
					'contain' => array(
						'FactorProtector'
					)
				)
			);

			$detallePlanTrabajo = array();
			foreach ($detallesPlanesTrabajosInfo as $row) {
				$fapr_id = $row['FactorProtector']['fapr_id'];
				$detallePlanTrabajo[$fapr_id] = $row;
			}

			$this->set('detallePlanTrabajo', $detallePlanTrabajo);			
		}

		// se supone que la persona pertenece a un grupo objetivo, por lo tanto filtramos niveles con ese dato
		$grob_id = $this->request->data['Persona']['grob_id'];
		$niveles = $this->PlanTrabajo->DetallePlanTrabajo->FactorProtector->Nivel->find('all',
			array(
				'contain' => array(
					'FactorProtector'
				),
				'conditions' => array(
					'Nivel.grob_id' => $grob_id
				)
			)
		);

		// buscamos todas las actividades individuales aprobadas para este centro familiar
		$cefa_id = $this->request->data['CentroFamiliar']['cefa_id'];
		$actividades = $this->PlanTrabajo->DetallePlanTrabajo->Actividad->find('list',
			array(
				'fields' => array(
					'Actividad.acti_id',
					'Actividad.acti_nombre'
				),
				'conditions' => array(
					'Actividad.esac_id' => 2,
					'Actividad.acti_individual' => true,
					'Actividad.cefa_id' => $cefa_id
				),
				'order' => array(
					'Actividad.acti_fecha_inicio DESC'
				)
			)
		);

		$centrosFamiliares = $this->PlanTrabajo->PersonaCentroFamiliar->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_nombre'
				)
			)
		);

		$this->set(compact('niveles', 'centrosFamiliares', 'actividades'));
	}

	/**
	 * Método revisa detalle de un plan de trabajo
	 * 
	 * @param int $pltr_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($pltr_id) {
		if (!$this->PlanTrabajo->exists($pltr_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$planTrabajo = $this->PlanTrabajo->find('first',
			array(
				'conditions' => array(
					'PlanTrabajo.pltr_id' => $pltr_id
				),
				'contain' => array(
					'PersonaCentroFamiliar' => array(
						'Persona',
						'CentroFamiliar'
					),
					'DetallePlanTrabajo' => array(
						'FactorProtector' => array(
							'Nivel'
						),
						'Actividad' => array(
							'fields' => array(
								'Actividad.acti_nombre',
								'Actividad.acti_fecha_inicio',
								'Actividad.acti_fecha_termino'
							)
						)
					)
				)
			)
		);

		$this->set(compact('planTrabajo'));
	}

	/**
	 * Método elimina un plan de trabajo
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $pltr_id
	 * @return void
	 */
	public function delete($pltr_id = null) {
		$this->PlanTrabajo->id = $pltr_id;
		if (!$this->PlanTrabajo->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->PlanTrabajo->delete()) {
			$this->Session->setFlash(__('El plan de trabajo ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el plan de trabajo. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

}