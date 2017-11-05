<?php

App::uses('CakeTime', 'Utility');

class SesionesController extends AppController {
	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('Sesion');

	/**
	 * Método lista todos las sesiones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'fields' => array(
				'Actividad.*',
				'Sesion.*',
				'AsistenciaSesion.total_asistencias',
				'Programa.prog_nombre'
			),
			'joins'=>array(
				array('table'=>'tipos_actividades',
				'alias'=>'TipoActividad',
				'type'=>'inner',
				'conditions'=>array('Actividad.tiac_id = TipoActividad.tiac_id ')
				),
				array('table'=>'areas',
				'alias'=>'Area',
				'type'=>'inner',
				'conditions'=>array('Area.area_id = TipoActividad.area_id ')
				),
				array('table'=>'programas',
				'alias'=>'Programa',
				'type'=>'inner',
				'conditions'=>array('Programa.prog_id = Area.prog_id ')
				),
				
			),
			'contain' => array(
				'Actividad',
				'Actividad.TipoActividad',
				
				'AsistenciaSesion',
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);

			$paginate['conditions'] = array(
				'LOWER(acti_nombre || \' \' || sesi_nombre) LIKE \'%'. $t .'%\''
			);
		}

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$paginate['conditions'][] = sprintf('Actividad.cefa_id = %d', $this->cefa_id);
		}

		// filtros de busqueda avanzada
		if (!empty($this->request->query['sf_cefa_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.cefa_id = %d', $this->request->query['sf_cefa_id']);
		}
		if (!empty($this->request->query['sf_pro_id'])) {
			$paginate['conditions'][] = sprintf('Programa.prog_id = %d', $this->request->query['sf_pro_id']);
		}

		if (!empty($this->request->query['sf_nro_sesiones'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_nro_sesiones = %d', $this->request->query['sf_nro_sesiones']);
		}

		if (!empty($this->request->query['sf_ano'])) {
			$paginate['conditions'][] = sprintf('DATE_PART(\'YEAR\', Sesion.sesi_fecha_ejecucion) = %d', $this->request->query['sf_ano']);
		}

		if (!empty($this->request->query['sf_fecha_ejec'])) {
			$paginate['conditions'][] = sprintf('Sesion.sesi_fecha_ejecucion = \'%s\'', $this->request->query['sf_fecha_ejec']);
		}

		if (!empty($this->request->query['sf_tiac_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.tiac_id = %d', $this->request->query['sf_tiac_id']);
		}

		if (!empty($this->request->query['sf_acti_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_id = %d', $this->request->query['sf_acti_id']);
		}

		if (!empty($this->request->query['sf_sesi_id'])) {
			$paginate['conditions'][] = sprintf('Sesion.sesi_id = %d', $this->request->query['sf_sesi_id']);
		}

		if (!empty($this->request->query['sf_tipo_cobertura'])) {
			$tipoCobertura = $this->request->query['sf_tipo_cobertura'];
			$paginate['conditions'][] = ($tipoCobertura == 1)? 'Actividad.acti_individual IS FALSE': 'Actividad.acti_individual IS TRUE';
		}

		if (!empty($this->request->query['sf_nro_asistentes'])) {
			$nroAsistentes = $this->request->query['sf_nro_asistentes'];
			$paginate['conditions'][] = sprintf('(SELECT COUNT(*) FROM asistencias WHERE sesi_id = "Sesion".sesi_id) = %d', $nroAsistentes);
		}

		$this->paginate = $paginate;

		// buscamos centros familiares para filtro
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Sesion->Actividad->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->Sesion->Actividad->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('centrosFamiliares', $centrosFamiliares);
		$this->set('sesiones', $this->Paginator->paginate());

		// filtros para búsqueda fina
		$tiposActividades = $this->Sesion->Actividad->TipoActividad->find('list');
			$this->loadModel("Programa");
		$programas = $this->Programa->find('list');

		$combos = array(
			'centrosFamiliares' => $centrosFamiliares,
			'tiposActividades' => $tiposActividades,
			'programas'=>$programas		);
		$this->set('combos', $combos);
	}

	/**
	 * Método agrega una nueva sesion
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Sesion->create();


			// limpiamos datitos
			unset($this->request->data['CentroFamiliar']);
			unset($this->request->data['Actividad']);

			// si el total de sesiones hace match con el total de sesiones de la actividad
			// el estado de la actividad pasa de inmediato a "ejecutada"
			$acti_id = $this->request->data['Sesion']['acti_id'];
			$sesi_nombre = $this->request->data['Sesion']['sesi_nombre'];
			if ($this->Sesion->checkTotalSesiones($acti_id, $sesi_nombre)) {
				$this->Sesion->Actividad->save(
					array(
						'Actividad' => array(
							'acti_id' => $acti_id,
							'esac_id' => 7 // ejecutada
						)
					)
				);
			}

			if ($this->Sesion->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La sesión ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la sesión. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Sesion->Actividad->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => array(
						'CentroFamiliar.cefa_nombre ASC'
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Sesion->Actividad->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre ASC'
					)
				)
			);
		}
		$sexos = $this->Sesion->Asistencia->PersonaCentroFamiliar->Persona->Sexo->find('list');
		$this->set(compact('centrosFamiliares', 'sexos'));

	}

	/**
	 * Método edita una sesión
	 * 
	 * @param int $sesi_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($sesi_id) {
		if (!$this->Sesion->exists($sesi_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			// si el total de sesiones hace match con el total de sesiones de la actividad
			// el estado de la actividad pasa de inmediato a "ejecutada"
			$acti = $this->Sesion->find('first',
				array(
					'conditions' => array(
						'Sesion.sesi_id' => $sesi_id
					)
				)
			); 
			$acti_id = $acti['Sesion']['acti_id'];
			$sesi_nombre = $acti['Sesion']['sesi_nombre'];
			if ($this->Sesion->checkTotalSesiones($acti_id, $sesi_nombre)) {
				$this->Sesion->Actividad->save(
					array(
						'Actividad' => array(
							'acti_id' => $acti_id,
							'esac_id' => 7 // ejecutada
						)
					)
				);
			}
			
			// borramos todo
			$this->Sesion->Asistencia->deleteAll(array('Asistencia.sesi_id' => $sesi_id));

			// agregamos el sesi_id a cada fila
			$infoAsis = array();
			$index = 0;


			foreach ($this->request->data['Asistencia'] as $asis) {
				$infoAsis[$index] = $asis;
				$infoAsis[$index]['sesi_id'] = $sesi_id;
				$index++;
			}

			$infoSesi = array(
				'Sesion' => array(
					'sesi_id' => $sesi_id,
					'sesi_fecha_ejecucion' => $this->request->data['Sesion']['sesi_fecha_ejecucion']
				)
			);
		
			if ($this->Sesion->save($infoSesi)) {
				if ($this->Sesion->Asistencia->saveMany($infoAsis)) {
					$this->Session->setFlash(__('La sesión ha sido guardada.'), 'success_alert');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('No se pudo guardar la sesión. Por favor inténtelo nuevamente.'), 'error_alert');
				}
			} else {
				$this->Session->setFlash(__('No se pudo guardar la sesión. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Sesion.' . $this->Sesion->primaryKey => $sesi_id
				),
				'contain' => array(
					'Actividad'
				)
			);
			$this->request->data = $this->Sesion->find('first', $conditions);
			$this->request->data['CentroFamiliar']['cefa_id'] = $this->request->data['Actividad']['cefa_id'];
			$this->request->data['Sesion']['sesi_fecha_ejecucion'] = !empty($this->request->data['Sesion']['sesi_fecha_ejecucion'])? CakeTime::format($this->request->data['Sesion']['sesi_fecha_ejecucion'], '%d-%m-%Y'): null;
		}

		$centrosFamiliares = $this->Sesion->Actividad->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_nombre ASC'
				)
			)
		);

		$asistencias = $this->Sesion->Asistencia->find('all',
			array(
				'fields' => array(
					'Asistencia.*',
					'PersonaCentroFamiliar.*',
					'Persona.pers_nombres',
					'Persona.pers_ap_paterno',
					'Persona.pers_ap_materno',
					'Persona.pers_run',
					'Persona.pers_run_dv'
				),
				'conditions' => array(
					'Asistencia.sesi_id' => $sesi_id
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
					)
				),
				'order' => array(
					'Persona.pers_ap_paterno' => 'ASC',
					'Persona.pers_ap_materno' => 'ASC',
					'Persona.pers_nombres' => 'ASC'
				)
			)
		);

		$sexos = $this->Sesion->Asistencia->PersonaCentroFamiliar->Persona->Sexo->find('list');
		$this->set(compact('centrosFamiliares', 'sexos', 'asistencias'));
	}

	/**
	 * Método muestra detalle de una sesión
	 * 
	 * @param int $sesi_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($sesi_id) {
		if (!$this->Sesion->exists($sesi_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$sesion = $this->Sesion->find('first',
			array(
				'contain' => array(
					'Actividad' => array(
						'CentroFamiliar'
					)
				),
				'conditions' => array(
					'Sesion.sesi_id' => $sesi_id
				)
			)
		);

		$asistencias = $this->Sesion->Asistencia->find('all',
			array(
				'fields' => array(
					'Asistencia.*',
					'PersonaCentroFamiliar.*',
					'Persona.pers_id',
					'Persona.pers_ap_paterno',
					'Persona.pers_ap_materno',
					'Persona.pers_nombres',
					'Persona.pers_run',
					'Persona.pers_run_dv'
				),
				'joins' => array(
					array(
			            'table' => 'personas_centros_familiares',
			            'alias' => 'PersonaCentroFamiliar',
			            'type' => 'INNER',
			            'conditions' => array(
			                'Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id'
			            )
			        ),
			        array(
			            'table' => 'personas',
			            'alias' => 'Persona',
			            'type' => 'INNER',
			            'conditions' => array(
			                'PersonaCentroFamiliar.pers_id = Persona.pers_id'
			            )
			        )
				),
				'conditions' => array(
					'Asistencia.sesi_id' => $sesi_id
				),
				'order' => array(
					'Persona.pers_ap_paterno' => 'ASC',
					'Persona.pers_ap_materno' => 'ASC',
					'Persona.pers_nombres' => 'ASC'
				)
			)
		);
		
		$this->set(compact('sesion', 'asistencias'));
	}

	/**
	 * Método elimina una sesión
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $sesi_id
	 * @return void
	 */
	public function delete($sesi_id = null) {
		$this->Sesion->id = $sesi_id;
		if (!$this->Sesion->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Sesion->delete()) {
			$this->Session->setFlash(__('La sesión ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la sesión. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método encuentra el correlativo maximo de una sesión, según actividad
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function findMaxSesion() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$acti_id = $this->request->data['acti_id'];
			$max = $this->Sesion->maxSesion($acti_id);
			return json_encode(array('max' => $max));
		}
	}
}
