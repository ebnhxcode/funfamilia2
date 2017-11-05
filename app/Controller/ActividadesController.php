<?php

App::uses('CakeTime', 'Utility');

class ActividadesController extends AppController {
	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('Actividad');

	/**
	 * Método lista todos las actividades según perfil de usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'TipoActividad',
				'EstadoActividad',
				'CentroFamiliar',
				'TipoActividad.Area.Programa'
			),
			'joins'=>array(
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
			'order' => 'Actividad.acti_id DESC'
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(CentroFamiliar.cefa_nombre || \' \' || TipoActividad.tiac_nombre || \' \' || Actividad.acti_nombre || TO_CHAR(acti_fecha_inicio, \'DD-MM-YYYY\') || TO_CHAR(acti_fecha_termino, \'DD-MM-YYYY\')) LIKE \'%'. $t .'%\''
			);	
		}
				
		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$paginate['conditions'][] = sprintf('Actividad.cefa_id = %d', $this->cefa_id);
		}

		// filtros de busqueda avanzada
		if (!empty($this->request->query['sf_cefa_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.cefa_id = %d', $this->request->query['sf_cefa_id']);
		}
		if (!empty($this->request->query['sf_pro_id'])) {
			$paginate['conditions'][] = sprintf('Programa.prog_id = %d', $this->request->query['sf_pro_id']);
		}

		if (!empty($this->request->query['sf_tiac_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.tiac_id = %d', $this->request->query['sf_tiac_id']);
		}

		if (!empty($this->request->query['sf_fecha_inicio'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_fecha_inicio >= \'%s\'', $this->request->query['sf_fecha_inicio']);
		}

		if (!empty($this->request->query['sf_fecha_termino'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_fecha_termino <= \'%s\'', $this->request->query['sf_fecha_termino']);
		}

		if (!empty($this->request->query['sf_esac_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.esac_id = %d', $this->request->query['sf_esac_id']);
		}

		if (!empty($this->request->query['sf_acti_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_id = %d', $this->request->query['sf_acti_id']);
		}

		if (!empty($this->request->query['sf_tipo_cobertura'])) {
			$tipoCobertura = $this->request->query['sf_tipo_cobertura'];
			$paginate['conditions'][] = ($tipoCobertura == 1)? 'Actividad.acti_individual IS FALSE': 'Actividad.acti_individual IS TRUE';
		}

		if (!empty($this->request->query['sf_nro_sesiones'])) {
			$paginate['conditions'][] = sprintf('Actividad.acti_nro_sesiones = %d', $this->request->query['sf_nro_sesiones']);
		}

		if (!empty($this->request->query['sf_ano'])) {
			$paginate['conditions'][] = sprintf('DATE_PART(\'YEAR\', Actividad.acti_fecha_inicio) = %d', $this->request->query['sf_ano']);
		}

		$this->paginate = $paginate;
		
		// buscamos centros familiares para filtro
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		// seteamos el filtro si es que viene
		$this->Session->write('filter_q', $this->request->query);
		$this->set('centrosFamiliares', $centrosFamiliares);
		//print_r($this->Paginator->paginate()); exit();
		$this->set('actividades', $this->Paginator->paginate());
		//print_r( $this->Paginator->paginate()); exit;
		// filtros para búsqueda fina
		$tiposActividades = $this->Actividad->TipoActividad->find('list');
		$estadosActividades = $this->Actividad->EstadoActividad->find('list');
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		
		$combos = array(
			'centrosFamiliares' => $centrosFamiliares,
			'tiposActividades' => $tiposActividades,
			'estadosActividades' => $estadosActividades,
			'programas'=>$programas
		);
		$this->set('combos', $combos);
	}

	/**
	 * Método agrega una nueva actividad
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {			
			$this->Actividad->create();
			if ($this->Actividad->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La actividad ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la actividad. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$comunas = $this->Actividad->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$conceptos = $this->Actividad->GastoActividad->Concepto->find('all',
			array(
				'order' => array(
					'Concepto.conc_nombre'
				)
			)
		);
		$fuentesFinanciamientos = $this->Actividad->GastoActividad->FuenteFinanciamiento->find('all',
			array(
				'order' => array(
					'FuenteFinanciamiento.fufi_nombre'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list');
		}

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$estadosActividades = $this->Actividad->EstadoActividad->find('list',
				array(
					'conditions' => array(
						'EstadoActividad.esac_id' => 1 // siempre nueva
					)
				)
			);
		} else {
			$estadosActividades = $this->Actividad->EstadoActividad->find('list');
		}


		$programas = $this->Actividad->TipoActividad->Area->Programa->find('list');
		$this->set(compact('comunas', 'centrosFamiliares', 'tiposActividades', 'estadosActividades', 'areas', 'conceptos', 'fuentesFinanciamientos', 'programas'));
	}

	/**
	 * Método edita una actividad
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($acti_id) {
		if (!$this->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			// si la actividad es masiva y además se agrega el campo cobertura estimada
			// el estado de la actividad pasa de inmediato a "ejecutada"
			if ($this->request->data['Actividad']['acti_individual'] == 0 &&
				!empty($this->request->data['Actividad']['acti_cobertura_estimada'])) {
				$this->request->data['Actividad']['esac_id'] = 7; // ejecutada
			}			
			
			if ($this->Actividad->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La actividad ha sido guardada.'), 'success_alert');
				$filter_q = $this->Session->read('filter_q');

				// devolvemos al index, según filtro
				if (!empty($filter_q)) {

					unset($filter_q['q']);
					return $this->redirect(
						array(
							'controller' => 'actividades',
							'action' => 'index',
							'?' => $filter_q
						)
					);
					
 				} else {
					return $this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('No se pudo guardar la actividad. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'contain' => array(
					'TipoActividad' => array(
						'Area'
					),
					'Usuario',
					'GastoActividad',
				),
				'conditions' => array(
					'Actividad.' . $this->Actividad->primaryKey => $acti_id
				)
			);
			$this->request->data = $this->Actividad->find('first', $conditions);

			$this->request->data['Actividad']['acti_fecha_inicio'] = CakeTime::format($this->request->data['Actividad']['acti_fecha_inicio'], '%d-%m-%Y');
			$this->request->data['Actividad']['acti_fecha_termino'] = CakeTime::format($this->request->data['Actividad']['acti_fecha_termino'], '%d-%m-%Y');
			$this->request->data['Actividad']['area_id'] = $this->request->data['TipoActividad']['area_id'];
			$this->request->data['Actividad']['usua_nombre'] = $this->request->data['Usuario']['usua_nombre_completo'];
			$this->request->data['Actividad']['usua_id'] = $this->request->data['Usuario']['usua_id'];
			$this->request->data['Actividad']['prog_id'] = $this->request->data['TipoActividad']['Area']['prog_id'];
		}

		$areas = $this->Actividad->TipoActividad->Area->find('list');
		$programas = $this->Actividad->TipoActividad->Area->Programa->find('list');
		$instituciones = $this->Actividad->Institucion->find('list',
			array(
				'conditions' => array(
					'Institucion.tiin_id !=' => array(2, 3)
				)
			)
		);
		$comunas = $this->Actividad->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		if (!empty($this->request->data['Actividad']['area_id'])) {
			$tiposActividades = $this->Actividad->TipoActividad->find('list', 
				array(
					'conditions' => array(
						'TipoActividad.area_id' => $this->request->data['Actividad']['area_id']
					)
				)
			);
		}

		$conceptos = $this->Actividad->GastoActividad->Concepto->find('all',
			array(
				'order' => array(
					'Concepto.conc_nombre'
				)
			)
		);

		$fuentesFinanciamientos = $this->Actividad->GastoActividad->FuenteFinanciamiento->find('all',
			array(
				'order' => array(
					'FuenteFinanciamiento.fufi_nombre'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Actividad->CentroFamiliar->find('list');
		}

		$estadosActividades = $this->Actividad->EstadoActividad->find('list');

		// seteamos actividad individual o masiva
		$actiIndividual = empty($this->request->data['Actividad']['acti_individual'])? false: true;

		$this->set(compact('comunas', 'centrosFamiliares', 'tiposActividades', 'estadosActividades', 'areas', 'instituciones', 'conceptos', 'fuentesFinanciamientos', 'actiIndividual', 'programas'));
	}

	/**
	 * Método detalle de una actividad
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($acti_id) {
		if (!$this->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$actividad = $this->Actividad->find('first',
			array(
				'contain' => array(
					'EstadoActividad',
					'TipoActividad' => array(
						'Area' => array(
							'Programa'
						)
					),
					'CentroFamiliar',
					'Comuna',
					'GastoActividad' => array(
						'Concepto',
						'FuenteFinanciamiento'
					),
					'Institucion',
					'Usuario'
				),
				'conditions' => array(
					'Actividad.acti_id' => $acti_id
				)
			)
		);

		$this->set(compact('actividad'));
	}

	/**
	 * Método elimina una actividad
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $acti_id
	 * @return void
	 */
	public function delete($acti_id = null) {
		$this->Actividad->id = $acti_id;

		if ($this->Actividad->DetallePlanTrabajo->hasAny(array('DetallePlanTrabajo.acti_id' => $acti_id))) {
			$this->Session->setFlash(__('No se pudo eliminar la actividad. Existen planes de trabajos asociados a ella, por favor elimínelos y vuelta a intentarlo.'), 'error_alert');
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->Actividad->PersonaActividad->hasAny(array('PersonaActividad.acti_id' => $acti_id))) {
			$this->Session->setFlash(__('No se pudo eliminar la actividad. Existen personas inscritas a ella, por favor elimínelas y vuelta a intentarlo.'), 'error_alert');
			return $this->redirect(array('action' => 'index'));
		}

		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Actividad->delete()) {
			$this->Session->setFlash(__('La actividad ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la actividad. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método encuentra actividades individuales por centro familiar (en caso de venir filtro)
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_actividades_individuales_by_cefa() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$cefa_id = empty($this->request->query['cefa_id'])? null: $this->request->query['cefa_id'];
			$query = strtolower($this->request->query['q']);

			$conditions = array(
				'conditions' => array(
					'Actividad.acti_individual' => true,
					'Actividad.esac_id' => 2, // actividades aprobadas
					'LOWER(acti_nombre || TO_CHAR(acti_fecha_inicio, \'DD-MM-YYYY\') || TO_CHAR(acti_fecha_termino, \'DD-MM-YYYY\')) LIKE \'%'. $query .'%\''
				)
			);

			if (!empty($cefa_id)) {
				$conditions['conditions']['Actividad.cefa_id'] = $cefa_id;
			}

			$actividades = $this->Actividad->find('all', $conditions);
			return json_encode($actividades);
		}
	}

	/**
	 * Método encuentra actividades individuales aprobadas por centro familiar (individuales/masivas)
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_actividades() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$cefa_id = $this->request->data['cefa_id'];

			$actividades = $this->Actividad->find('all',
				array(
					'conditions' => array(
						'Actividad.cefa_id' => $cefa_id,
						'Actividad.esac_id' => array(1, 2), // actividades nuevas y aprobadas
						'Actividad.acti_individual' => true // actividades individuales
					),
					'order' => array(
						'Actividad.acti_fecha_inicio DESC'
					)
				)
			);

			return json_encode($actividades);
		}

	}

	/**
	 * Método lista todos las actividades aprobadas, segun perfil comunicaciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function comunicaciones() {
		$paginate = array(
			'contain' => array(
				'TipoActividad',
				'EstadoActividad',
				'CentroFamiliar',
				'Usuario'
			),
			'conditions' => array(
				'Actividad.esac_id' => 2
			),
			'order' => 'Actividad.acti_fecha_creacion DESC'
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(Usuario.usua_nombre || \' \' || Usuario.usua_apellidos || \' \' || CentroFamiliar.cefa_nombre || \' \' || tiac_nombre || \' \' || acti_nombre || TO_CHAR(acti_fecha_inicio, \'DD-MM-YYYY\') || TO_CHAR(acti_fecha_termino, \'DD-MM-YYYY\')) LIKE \'%'. $t .'%\''
			);	
		}

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$paginate['conditions'][] = sprintf('Actividad.cefa_id = %d', $this->cefa_id);
		}

		$this->paginate = $paginate;
		$this->set('actividades', $this->Paginator->paginate());
	}

	/**
	 * Método detalle de una actividad para perfil comunicaciones
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function comunicaciones_view($acti_id) {
		if (!$this->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post')) {
			$this->Actividad->id = $this->request->data['Actividad']['acti_id'];
			$this->Actividad->saveField('acti_es_comunicacional', $this->request->data['Actividad']['acti_es_comunicacional']);

			$this->Session->setFlash(__('La actividad ha sido marcada.'), 'success_alert');	
			return $this->redirect(array('action' => 'comunicaciones'));
		}

		$actividad = $this->Actividad->find('first',
			array(
				'contain' => array(
					'EstadoActividad',
					'TipoActividad' => array(
						'Area'
					),
					'CentroFamiliar',
					'Comuna',
					'Institucion',
					'Usuario'
				),
				'conditions' => array(
					'Actividad.acti_id' => $acti_id
				)
			)
		);

		$this->set(compact('actividad'));
	}

	/**
	 * Método detalle de una actividad (sesiones)
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function info_sesiones($acti_id) {
		if (!$this->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$actividad = $this->Actividad->find('first',
			array(
				'fields' => array(
					'Actividad.acti_id',
					'Actividad.acti_nro_sesiones',
					'Actividad.acti_nombre',
					'Actividad.acti_cobertura_estimada',
					'(SELECT COUNT(*)
					  FROM sesiones
					  WHERE acti_id = "Actividad".acti_id) AS total_ejecutadas',
					'(SELECT AVG(total_asistentes)
					  FROM (
					      SELECT COUNT(*) AS total_asistentes
      							,Sesion.sesi_id
						  FROM sesiones AS Sesion
						  NATURAL JOIN asistencias
						  WHERE Sesion.acti_id = "Actividad".acti_id
						  GROUP BY Sesion.sesi_id
					 ) t) AS promedio_asistencia'
				),
				'conditions' => array(
					'Actividad.acti_id' => $acti_id
				)
			)
		);

		$sesiones = $this->Actividad->Sesion->find('all',
			array(
				'fields' => array(
					'Sesion.sesi_nombre',
					'Sesion.sesi_fecha_ejecucion',
					'(SELECT COUNT(*) AS total_asistentes
					  FROM asistencias
					  WHERE sesi_id = "Sesion".sesi_id)'
				),
				'conditions' => array(
					'Sesion.acti_id' => $acti_id
				)
			)
		);
		
		$this->set(compact('actividad', 'sesiones'));
	}


	/**
	 * Método edita el campo cobertura estimada de una actividad
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit_cobertura_estimada($acti_id) {
		if (!$this->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			
			if ($this->Actividad->save($this->request->data)) {
				$this->Session->setFlash(__('La cobertura estimada ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo actualizar la cobertura estimada. Por favor inténtelo nuevamente.'), 'error_alert');
			}

		} else {
			$conditions = array(
				'conditions' => array(
					'Actividad.' . $this->Actividad->primaryKey => $acti_id
				)
			);
			$this->request->data = $this->Actividad->find('first', $conditions);
		}


	}
}