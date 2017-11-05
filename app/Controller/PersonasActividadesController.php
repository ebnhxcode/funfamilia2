<?php
class PersonasActividadesController extends AppController {
	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('PersonaActividad');

	/**
	 * Método lista todos las actividades con sus inscripciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'fields' => array(
				'TipoActividad.tiac_nombre',
				'Actividad.acti_id',
				'Actividad.acti_nombre',
				'Actividad.acti_fecha_inicio',
				'Actividad.acti_fecha_termino',
				'Actividad.acti_anio',
				//'(SELECT COUNT(*) FROM personas_actividades WHERE acti_id = "Actividad"."acti_id") as total_personas',
				'TotalPersonaActividad.total_personas',
				'Programa.prog_nombre'
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
			'contain' => array(
				'TipoActividad',
				'CentroFamiliar',
				'TotalPersonaActividad',
				'TipoActividad.Area.Programa'
			),
			'conditions' => array(
				'Actividad.acti_individual' => true
			),
			'group' => array(
				'CentroFamiliar.cefa_id',
				'TipoActividad.tiac_id',
				'TipoActividad.tiac_nombre',
				'Actividad.acti_id',
				'Actividad.acti_nombre',
				'Actividad.acti_fecha_inicio',
				'Actividad.acti_anio',
				'Programa.prog_nombre',
				//'Actividad.acti_fecha_termino HAVING (SELECT COUNT(*) FROM personas_actividades WHERE acti_id = "Actividad"."acti_id") > 0'
				'TotalPersonaActividad.total_personas'
    		),
    		'order' => array(
    			'Actividad.acti_id' => 'DESC',
    			'DATE_PART(\'YEAR\', Actividad.acti_fecha_inicio)'
    		)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(tiac_nombre || \' \' || acti_nombre || TO_CHAR(acti_fecha_inicio, \'DD-MM-YYYY\') || TO_CHAR(acti_fecha_termino, \'DD-MM-YYYY\')) LIKE \'%'. $t .'%\''
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

		if (!empty($this->request->query['sf_tiac_id'])) {
			$paginate['conditions'][] = sprintf('Actividad.tiac_id = %d', $this->request->query['sf_tiac_id']);
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

		if (!empty($this->request->query['sf_nro_inscripciones'])) {
			$paginate['conditions'][] = sprintf('(SELECT COUNT(*) FROM personas_actividades WHERE acti_id = "Actividad"."acti_id") = %d', $this->request->query['sf_nro_inscripciones']);
		}

		$this->paginate = $paginate;

		// buscamos centros familiares para filtro
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->PersonaActividad->Actividad->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->PersonaActividad->Actividad->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('centrosFamiliares', $centrosFamiliares);
		$actividades = $this->Paginator->paginate($this->PersonaActividad->Actividad);
		$this->set('actividades', $actividades);

		// filtros para búsqueda fina
		$tiposActividades = $this->PersonaActividad->Actividad->TipoActividad->find('list');
			$this->loadModel("Programa");
		$programas = $this->Programa->find('list');

		$combos = array(
			'centrosFamiliares' => $centrosFamiliares,
			'tiposActividades' => $tiposActividades,
			'programas'=>$programas
		);
		$this->set('combos', $combos);	
	}

	/**
	 * Método agrega una nueva inscripción
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PersonaActividad->create();

			if ($this->PersonaActividad->saveMany($this->request->data)) {
				$this->Session->setFlash(__('La inscripción ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la inscripción. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->PersonaActividad->Actividad->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->PersonaActividad->Actividad->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre ASC'
					)
				)
			);
		}

		$this->set(compact('centrosFamiliares'));
	}

	/**
	 * Método edita una inscripción
	 * 
	 * @param int $acti_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($acti_id) {
		if (!$this->PersonaActividad->Actividad->exists($acti_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post')) {
			if ($this->PersonaActividad->saveMany($this->request->data)) {
				$this->Session->setFlash(__('La inscripción ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la inscripción. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$this->request->data = $this->PersonaActividad->Actividad->find('first',
				array(
					'conditions' => array(
						'Actividad.acti_id' => $acti_id
					),
					'contain' => array(
						'CentroFamiliar',
						'PersonaActividad' => array(
							'PersonaCentroFamiliar' => array(
								'Persona' => array(
									'order' => 'Persona.pers_nombre_completo'
								)
							)
						)
					)
				)
			);
		}

		$centrosFamiliares = $this->PersonaActividad->Actividad->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_nombre ASC'
				)
			)
		);

		$this->set(compact('centrosFamiliares'));
	}

	/**
	 * Método muestra detalle de la actividad junto con sus asistentes
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param int $acti_id
	 * @return void
	 */
	public function view($acti_id) {
		$this->PersonaActividad->Actividad->id = $acti_id;
		if (!$this->PersonaActividad->Actividad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}

		$actividad = $this->PersonaActividad->Actividad->find('first',
			array(
				'contain' => array(
					'PersonaActividad' => array(
						'PersonaCentroFamiliar' => array(
							'Persona' => array(
								'order' => 'Persona.pers_nombre_completo ASC'
							)
						)
					),
					'CentroFamiliar',
					'EstadoActividad',
					'TipoActividad' => array(
						'Area'
					),
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
	 * Método elimina las inscripciones de una actividad
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param int $acti_id
	 * @return void
	 */
	public function delete($acti_id = null) {
		$this->PersonaActividad->Actividad->id = $acti_id;
		if (!$this->PersonaActividad->Actividad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->PersonaActividad->deleteAll(array('PersonaActividad.acti_id' => $acti_id))) {
			$this->Session->setFlash(__('El inscripción ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la inscripción. Por favor, inténtelo nuevamente.'), 'error_alert');
		}

		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método elimina una inscripción
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function deleteInscripcion() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$peac_id = $this->request->data['peac_id'];
			$this->PersonaActividad->id = $peac_id;

			if ($this->PersonaActividad->delete()) {
				$ret = 'ok';
			} else {
				$ret = 'error';
			}

			echo json_encode(array('ret' => $ret));
		}
	}

	/**
	 * Retorna todas las inscripciones por actividad
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function inscripciones_por_actividad() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$acti_id = $this->request->data['acti_id'];

			$inscripciones = $this->PersonaActividad->find('all',
				array(
					'fields' => array(
						'PersonaActividad.*',
						'PersonaCentroFamiliar.*',
						'Persona.pers_id',
						'Persona.pers_nombres',
						'Persona.pers_ap_paterno',
						'Persona.pers_ap_materno',
						'Persona.pers_run',
						'Persona.pers_run_dv'
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
					'conditions' => array(
						'PersonaActividad.acti_id' => $acti_id
					),
					'order' => array(
						'Persona.pers_ap_paterno' => 'ASC',
						'Persona.pers_ap_materno' => 'ASC',
						'Persona.pers_nombres' => 'ASC'
					)
				)
			);

			return json_encode($inscripciones);
		}
	}

	/**
	 * Método clona participantes de una actividad a otra
	 * solo para perfil comuna y digitador
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function clonar() {

		if ($this->request->is('post')) {
			$acti_id1 = $this->request->data['Actividad']['acti_id1'];
			$acti_id2 = $this->request->data['Actividad']['acti_id2'];
			
			$infoFrom = $this->PersonaActividad->find('all',
				array(
					'conditions' => array(
						'PersonaActividad.acti_id' => $acti_id1
					)
				)
			);

			$infoTo = array();
			foreach ($infoFrom as $peac) {
				$infoTo[] = array(
					'pecf_id' => $peac['PersonaActividad']['pecf_id'],
					'acti_id' => $acti_id2
				);
			}

			if ($this->PersonaActividad->saveMany2($infoTo)) {
				$this->Session->setFlash(__('Las inscripciones han sido clonadas.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));

			} else {
				$this->Session->setFlash(__('No se pudieron clonar las inscripciones. Por favor, inténtelo nuevamente.'), 'error_alert');
			}
		}

		$actividades = $this->PersonaActividad->Actividad->find('all',
			array(
				'contain' => array(
					'CentroFamiliar'
				),
				'conditions' => array(
					'Actividad.esac_id' => 2,
					'Actividad.cefa_id' => $this->cefa_id
				),
				'order' => array(
					'CentroFamiliar.cefa_orden' => 'ASC',
					'Actividad.acti_nombre' => 'ASC'
				)
			)
		);

		$actividades_ = array();
		foreach ($actividades as $acti) {
			$actividades_[$acti['Actividad']['acti_id']] = $acti['Actividad']['acti_nombre'];
		}

		$this->set('actividades', $actividades_);
	}
}
