<?php

App::uses('CakeTime', 'Utility');

class PersonasController extends AppController {

	/**
	 * Método lista todos las personas de los centros
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$anyo = date("Y");
		$paginate = array(
			'fields' => array(
				'Persona.pers_id',
				'Persona.pers_run',
				'Persona.pers_run_dv',
				'Persona.pers_nombres',
				'Persona.pers_ap_paterno',
				'Persona.pers_ap_materno',
				'Persona.pers_plan_trabajo',
				'PersonaCentroFamiliar.pecf_id',
				'CentroFamiliar.cefa_nombre',
				'Persona.fami_id',
				'f_participa_en_actividad_del_anyo("Persona".pers_id, '.$anyo.')',
				'f_persona_tiene_ficha_completa("Persona".pers_id)'
			),
			'contain' => array(
				'Persona',
				'CentroFamiliar'
			),
			'conditions' => array(
				'PersonaCentroFamiliar.pecf_habilitada IS TRUE'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = mb_strtolower($this->request->query['t']);
			$paginate['conditions'][] = 'LOWER(pers_run || \' \' || pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno) LIKE \'%'. $t .'%\'';
		}

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			// segun nuevo requerimiento
			// el centro puede ver a las demás personas de los otros centros, pero no los puede modificar
			//$paginate['conditions'][] = sprintf('PersonaCentroFamiliar.cefa_id = %d', $this->cefa_id);
		}

		// filtros de busqueda avanzada
		if (!empty($this->request->query['sf_cefa_id'])) {
			$paginate['conditions'][] = sprintf('PersonaCentroFamiliar.cefa_id = %d', $this->request->query['sf_cefa_id']);
		}

		if (!empty($this->request->query['sf_comu_id'])) {
			$paginate['conditions'][] = sprintf('CentroFamiliar.comu_id = %d', $this->request->query['sf_comu_id']);
		}
		
		if (!empty($this->request->query['sf_participacion'])) {
			$participante = htmlentities($this->request->query['sf_participacion']);
			$paginate['conditions'][] = ($participante == 1)? sprintf('f_participa_en_actividad_del_anyo("Persona".pers_id, %d) IS TRUE', $anyo): sprintf('f_participa_en_actividad_del_anyo("Persona".pers_id, %d) IS FALSE', $anyo);
		}

		if (!empty($this->request->query['sf_sexo_id'])) {
			$paginate['conditions'][] = sprintf('Persona.sexo_id = %d', htmlentities($this->request->query['sf_sexo_id']));
		}

		if (!empty($this->request->query['sf_pers_fecha_nacimiento'])) {
			$persFechaNacimiento = CakeTime::format(htmlentities($this->request->query['sf_pers_fecha_nacimiento']), '%Y-%m-%d');			
			$paginate['conditions'][] = sprintf('Persona.pers_fecha_nacimiento >= \'%s\'', $persFechaNacimiento);
		}

		if (!empty($this->request->query['sf_pers_fecha_nacimiento2'])) {
			$persFechaNacimiento = CakeTime::format(htmlentities($this->request->query['sf_pers_fecha_nacimiento2']), '%Y-%m-%d');			
			$paginate['conditions'][] = sprintf('Persona.pers_fecha_nacimiento <= \'%s\'', $persFechaNacimiento);
		}

		if (!empty($this->request->query['sf_esci_id'])) {		
			$paginate['conditions'][] = sprintf('Persona.esci_id = %d', $this->request->query['sf_esci_id']);
		}

		if (!empty($this->request->query['sf_puor_id'])) {		
			$paginate['conditions'][] = sprintf('Persona.puor_id = %d', $this->request->query['sf_puor_id']);
		}

		if (!empty($this->request->query['sf_grob_id'])) {		
			$paginate['conditions'][] = sprintf('Persona.grob_id = %d', $this->request->query['sf_grob_id']);
		}

		if (!empty($this->request->query['sf_ano'])) {		
			$paginate['conditions'][] = sprintf('DATE_PART(\'YEAR\', Persona.pers_fecha_act) = %d', $this->request->query['sf_ano']);
		}

		if (!empty($this->request->query['sf_tiene_familia'])) {
			$tieneFamilia = $this->request->query['sf_tiene_familia'];
			$paginate['conditions'][] = ($tieneFamilia == 1)? sprintf('Persona.fami_id IS NOT NULL', $this->request->query['sf_tiene_familia']): sprintf('Persona.fami_id IS NULL', $this->request->query['sf_tiene_familia']);
		}

		if (!empty($this->request->query['sf_tiene_plan_trabajo'])) {
			$tienePlanTrabajo = $this->request->query['sf_tiene_plan_trabajo'];
			$paginate['conditions'][] = ($tienePlanTrabajo == 1)? 'Persona.pers_plan_trabajo IS NOT NULL': 'Persona.pers_plan_trabajo IS NULL';
		}

		if (!empty($this->request->query['sf_tiene_ficha'])) {
			$tieneFicha = $this->request->query['sf_tiene_ficha'];
			$paginate['conditions'][] = ($tieneFicha == 1)? 'f_persona_tiene_ficha_completa(Persona.pers_id) IS TRUE': 'f_persona_tiene_ficha_completa(Persona.pers_id) IS FALSE';
		}

		if (!empty($this->request->query['sf_tiac_id'])) {
			$paginate['joins'][] = array(
				'table' => 'v_personas_tipos_actividades',
				'alias' => 'PersonaTipoActividad',
				'type' => 'LEFT',
				'conditions' => array(
            		'PersonaCentroFamiliar.pecf_id = PersonaTipoActividad.pecf_id',
            		'PersonaTipoActividad.tiac_id' => $this->request->query['sf_tiac_id']
        		)
			);	
			$paginate['conditions'][] = sprintf('PersonaTipoActividad.tiac_id = %d', $this->request->query['sf_tiac_id']);
		}

		$this->paginate = $paginate;

		// buscamos centros familiares para filtro
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Persona->PersonaCentroFamiliar->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->Persona->PersonaCentroFamiliar->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('centrosFamiliares', $centrosFamiliares);
		$this->set('personas', $this->Paginator->paginate('PersonaCentroFamiliar'));

		// filtros para búsqueda fina
		$gruposObjetivos = $this->Persona->GrupoObjetivo->find('list');
		$pueblosOriginarios = $this->Persona->PuebloOriginario->find('list');
		$estadosCiviles = $this->Persona->EstadoCivil->find('list');
		$sexos = $this->Persona->Sexo->find('list');
		$centrosFamiliares = $this->Persona->PersonaCentroFamiliar->CentroFamiliar->find('list');
		$tiposActividades = $this->Persona->PersonaCentroFamiliar->CentroFamiliar->Actividad->TipoActividad->find('list');
		$comunas = $this->Persona->PersonaCentroFamiliar->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$combos = array(
			'gruposObjetivos' => $gruposObjetivos,
			'pueblosOriginarios' => $pueblosOriginarios,
			'estadosCiviles' => $estadosCiviles,
			'sexos' => $sexos,
			'centrosFamiliares' => $centrosFamiliares,
			'tiposActividades' => $tiposActividades,
			'comunas' => $comunas
		);
		$this->set('combos', $combos);
	}

	/**
	 * Método agrega una nueva persona
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {

		if ($this->request->is('post')) {
			$this->Persona->create();

			// si es perfil comuna o digitador
			if ($this->perf_id == 3 || $this->perf_id == 10) {
				// arreglamos datos de personas_centros_familiares
				// solo si vienen de un combobox NO multiple
				// (perfil comuna)
				$this->request->data['PersonaCentroFamiliar'] = array(
					array(
						'cefa_id' => $this->request->data['PersonaCentroFamiliar']['cefa_id']
					)
				);
			} else {

				// arreglamos datos de personas_centros_familiares
				// solo si vienen de un combobox múltiple
				$pecfData = array();
				foreach ($this->request->data['PersonaCentroFamiliar']['cefa_id'] as $cefa_id) {
					$pecfData[] = array(
						'cefa_id' => $cefa_id	
					);
				}
				$this->request->data['PersonaCentroFamiliar'] = $pecfData;
			}
			

			// revisamos direccion
			if (!empty($this->request->data['Persona']['comu_id']) && !empty($this->request->data['Persona']['dire_direccion'])) {
				$dire_direccion = str_replace(' ', null, mb_strtolower($this->request->data['Persona']['dire_direccion']));
				$comu_id = $this->request->data['Persona']['comu_id'];

				$direInfo = $this->Persona->Direccion->find('first',
					array(
						'conditions' => array(
							'REPLACE(LOWER(Direccion.dire_direccion), \' \', \'\') = \''.$dire_direccion.'\'',
						)
					)
				);

				if (empty($direInfo)) {
					$dataDireccion = array(
						'Direccion' => array(
							'comu_id' => $this->request->data['Persona']['comu_id'],
							'dire_direccion' => $this->request->data['Persona']['dire_direccion']
						)
					);
					$this->Persona->Direccion->create();
					$this->Persona->Direccion->save($dataDireccion);
					$this->request->data['Persona']['dire_id'] = $this->Persona->Direccion->id;

				} else {
					$this->request->data['Persona']['dire_id'] = $direInfo['Direccion']['dire_id'];
				}
			}

			// si la persona viene con un run vacío, se le tiene que inventar uno
			if (empty($this->request->data['Persona']['pers_run']) && empty($this->request->data['Persona']['pers_run_dv'])) {
				$this->request->data['Persona']['pers_run'] = $this->Persona->generarMaxRun();
				$this->request->data['Persona']['pers_run_dv'] = $this->Persona->getDv($this->request->data['Persona']['pers_run']);
			}

			if ($this->Persona->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La persona ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la persona. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$sexos = $this->Persona->Sexo->find('list');
		$nacionalidades = $this->Persona->Nacionalidad->find('list');
		$estadosCiviles = $this->Persona->EstadoCivil->find('list');
		$pueblosOriginarios = $this->Persona->PuebloOriginario->find('list');
		$estudios = $this->Persona->Estudio->find('list');
		$institucionesSalud = $this->Persona->InstitucionSalud->find('list',
			array(
				'conditions' => array(
					'InstitucionSalud.tiin_id' => 2
				)
			)
		);
		$institucionesPrevision = $this->Persona->InstitucionPrevision->find('list',
			array(
				'conditions' => array(
					'InstitucionPrevision.tiin_id' => 3
				)
			)
		);
		$parentescos = $this->Persona->Parentesco->find('list');	
		$gruposObjetivos = $this->Persona->GrupoObjetivo->find('list');
		$comunas = $this->Persona->Comuna->find('list',
			array(
				'order' => 'Comuna.comu_nombre'
			)
		);

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Persona->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Persona->CentroFamiliar->find('list');
		}

		$this->set(compact('sexos', 'nacionalidades', 'estadosCiviles', 'pueblosOriginarios', 'estudios', 'institucionesSalud', 'institucionesPrevision', 'parentescos', 'comunas', 'centrosFamiliares', 'gruposObjetivos'));
	}

	/**
	 * Método edita una persona
	 * 
	 * @param int $pers_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($pers_id, $pecf_id = null) {
		if (!$this->Persona->exists($pers_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		// chequeamos que la edicion de la persona, pertenezca al centro
		if (!empty($pecf_id)) {
			if ($this->perf_id == 3 || $this->perf_id == 10) {
				$infoPecf = $this->Persona->PersonaCentroFamiliar->find('first',
					array(
						'conditions' => array(
							'PersonaCentroFamiliar.pecf_id' => $pecf_id
						)
					)
				);

				$persCefaId = $infoPecf['PersonaCentroFamiliar']['cefa_id'];
				$usuaCefaId = $this->Auth->user('PerfilUsuario.cefa_id');

				if ($persCefaId != $usuaCefaId) {
					$this->Session->setFlash(__('No tiene privilegios para editar a una persona que se encuentra en otro centro. Esta operación la debe solicitar a Casa Central.'), 'error_alert');
					return $this->redirect(array('action' => 'index'));
				}
			}
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$dataSource = $this->Persona->getDataSource();
			$dataSource->begin();

			// revisamos direccion
			if (!empty($this->request->data['Persona']['comu_id']) && !empty($this->request->data['Persona']['dire_direccion'])) {
				$dire_direccion = str_replace(' ', null, mb_strtolower($this->request->data['Persona']['dire_direccion']));
				$comu_id = $this->request->data['Persona']['comu_id'];

				$direInfo = $this->Persona->Direccion->find('first',
					array(
						'conditions' => array(
							'REPLACE(LOWER(Direccion.dire_direccion), \' \', \'\') = \''.$dire_direccion.'\'',
						)
					)
				);

				if (empty($direInfo)) {
					$dataDireccion = array(
						'Direccion' => array(
							'comu_id' => $this->request->data['Persona']['comu_id'],
							'dire_direccion' => $this->request->data['Persona']['dire_direccion']
						)
					);
					$this->Persona->Direccion->create();
					$this->Persona->Direccion->save($dataDireccion);
					$this->request->data['Persona']['dire_id'] = $this->Persona->Direccion->id;

				} else {
					$this->request->data['Persona']['dire_id'] = $direInfo['Direccion']['dire_id'];
				}
			}

			// si la persona viene con un run vacío, se le tiene que inventar uno
			if (empty($this->request->data['Persona']['pers_run']) && empty($this->request->data['Persona']['pers_run_dv'])) {
				$this->request->data['Persona']['pers_run'] = $this->Persona->generarMaxRun();
				$this->request->data['Persona']['pers_run_dv'] = $this->Persona->generarDigitoVerificador($this->request->data['Persona']['pers_run']);
			}

			// fecha de actualización de dato
			$this->request->data['Persona']['pers_fecha_act'] = date('Y-m-d H:i:s');

			if ($this->Persona->save($this->request->data)) {

				// si el perfil es comuna o digitador, no hay necesidad de upd el dato en personas_centros_familiares
				// ya que siempre va a pertenecer a este centro
				if ($this->perf_id == 3 || $this->perf_id == 10) {
					$dataSource->commit();
					$this->Session->setFlash(__('La persona ha sido guardada.'), 'success_alert');
					return $this->redirect(array('action' => 'index'));

				} else {
					if ($this->Persona->PersonaCentroFamiliar->saveAndUpdate($this->request->data)) {
						$dataSource->commit();
						$this->Session->setFlash(__('La persona ha sido guardada.'), 'success_alert');
						return $this->redirect(array('action' => 'index'));
					} else {
						$dataSource->rollback();
						$this->Session->setFlash(__('No se pudo guardar la persona. Por favor inténtelo nuevamente.'), 'error_alert');
					}
				}
			} else {
				$dataSource->rollback();
				$this->Session->setFlash(__('No se pudo guardar la persona. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'contain' => array(
					'PersonaCentroFamiliar',
					'Direccion',
					'Familia'
				),
				'conditions' => array(
					'Persona.' . $this->Persona->primaryKey => $pers_id
				)
			);
			$this->request->data = $this->Persona->find('first', $conditions);

			if (!empty($this->request->data['Persona']['pers_fecha_nacimiento'])) {
				$this->request->data['Persona']['pers_fecha_nacimiento'] = CakeTime::format($this->request->data['Persona']['pers_fecha_nacimiento'], '%d-%m-%Y');
			}

			// rellenamos datos de centros familiares
			$dataPecf = array();
			foreach($this->request->data['PersonaCentroFamiliar'] as $pecf) {
				$dataPecf['cefa_id'][] = $pecf['cefa_id'];
			}

			$this->request->data['PersonaCentroFamiliar'] = $dataPecf;

			// rellenamos direccion
			$this->request->data['Persona']['dire_direccion'] = $this->request->data['Direccion']['dire_direccion'];
			$this->request->data['Persona']['dire_id'] = $this->request->data['Direccion']['dire_id'];

			// rellenamos familia
			if (!empty($this->request->data['Familia']['fami_nombre_completo'])) {
				$this->request->data['Persona']['fami_nombre'] = sprintf('%s (%s)', $this->request->data['Familia']['fami_nombre_completo'], $this->request->data['Familia']['fami_direccion_completa']);
				$this->request->data['Persona']['fami_id'] = $this->request->data['Familia']['fami_id'];
			}
		}

		$sexos = $this->Persona->Sexo->find('list');
		$nacionalidades = $this->Persona->Nacionalidad->find('list');
		$estadosCiviles = $this->Persona->EstadoCivil->find('list');
		$pueblosOriginarios = $this->Persona->PuebloOriginario->find('list');
		$estudios = $this->Persona->Estudio->find('list');
		$institucionesSalud = $this->Persona->InstitucionSalud->find('list',
			array(
				'conditions' => array(
					'InstitucionSalud.tiin_id' => 2
				)
			)
		);
		$institucionesPrevision = $this->Persona->InstitucionPrevision->find('list',
			array(
				'conditions' => array(
					'InstitucionPrevision.tiin_id' => 3
				)
			)
		);
		$parentescos = $this->Persona->Parentesco->find('list');
		$gruposObjetivos = $this->Persona->GrupoObjetivo->find('list');
		$comunas = $this->Persona->Comuna->find('list',
			array(
				'order' => 'Comuna.comu_nombre'
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Persona->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Persona->CentroFamiliar->find('list');
		}

		$this->set(compact('sexos', 'nacionalidades', 'estadosCiviles', 'pueblosOriginarios', 'estudios', 'institucionesPrevision', 'institucionesSalud', 'parentescos', 'comunas', 'centrosFamiliares', 'gruposObjetivos'));
	}

	/**
	 * Método muestra detalle de una persona
	 * 
	 * @param int $pers_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($pers_id) {
		if (!$this->Persona->exists($pers_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$persona = $this->Persona->find('first',
			array(
				'contain' => array(
					'Comuna',
					'Estudio',
					'Sexo',
					'EstadoCivil',
					'PuebloOriginario',
					'Nacionalidad',
					'Familia',
					'Parentesco',
					'CentroFamiliar',
					'InstitucionPrevision',
					'InstitucionSalud',
					'Direccion',
					'GrupoObjetivo'
				),
				'conditions' => array(
					'Persona.pers_id' => $pers_id
				)
			)
		);

		$this->set(compact('persona'));
	}

	/**
	 * Método elimina una persona
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $pers_id
	 * @return void
	 */
	public function delete($pers_id = null) {
		$this->Persona->id = $pers_id;
		if (!$this->Persona->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Persona->delete()) {
			$this->Session->setFlash(__('La persona ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la persona. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método encuentra a personas según query (typeahead)
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_personas() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$query = mb_strtolower($this->request->query['q']);
			$personas = $this->Persona->find('all',
				array(
					'fields' => array(
						'Persona.pers_id',
						'Persona.pers_nombre_completo'
					),
					'conditions' => array(
						'LOWER(pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno) LIKE \'%'. $query .'%\'' 
					)
				)
			);
			
			return json_encode($personas);
		}
	}

	/**
	 * Método encuentra a personas según query y centro familiar (typeahead)
	 * (tabla personas_centros_familiares)
	 * opcionalmente encuentra solo aquellas personas que hayan participado en alguna actividad (que tengan asistencia)
	 * opcionalmente encuentra personas que tengan un grupo objetivo definido
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_personas_by_cefa() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$query = mb_strtolower($this->request->query['q']);
			$cefa_id = $this->request->query['cefa_id'];
			$grupoObjetivo = isset($this->request->query['grupoObjetivo'])? true: false;
			$participaActividad = isset($this->request->query['participaActividad'])? true: false;

			$conditions = array(
				'fields' => array(
					'PersonaCentroFamiliar.pecf_id',
					'PersonaCentroFamiliar.pers_id',
					'Persona.*'
				),
				'contain' => array(
					'Persona'
				),
				'conditions' => array(
					//'PersonaCentroFamiliar.cefa_id' => $cefa_id,
					//'PersonaCentroFamiliar.pecf_habilitada' => true,
					'LOWER(TRIM(BOTH FROM pers_nombres) || \' \' || TRIM(BOTH FROM pers_ap_paterno) || \' \' || TRIM(BOTH FROM pers_ap_materno) || \' \' || pers_run) LIKE \'%'. $query .'%\''
				)
			);

			// si viene este banderin busca personas que tengan un grupo objetivo definido
			if ($grupoObjetivo == true) {
				$conditions['conditions']['Persona.grob_id IS NOT'] = null;
			}

			// si viene este banderin busca personas que hayan participado en una actividad
			if ($participaActividad == true) {
				$conditions['conditions'][] = 
					'(SELECT COUNT(*)
					  FROM asistencias
					  NATURAL JOIN sesiones
					  NATURAL JOIN actividades
					  WHERE DATE_PART(\'year\', acti_fecha_inicio)::integer = '. date('Y') .'
					  AND pecf_id = "PersonaCentroFamiliar"."pecf_id") > 0';
			}

			$personas = $this->Persona->PersonaCentroFamiliar->find('all', $conditions);

			return json_encode($personas);
		}
	}

	/**
	 * Método encuentra a personas según run
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_personas_por_run() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$pers_run = $this->request->data['pers_run'];

			$persona = $this->Persona->find('first',
				array(
				    'conditions' => array(
				    	'Persona.pers_run' => $pers_run
				    )
				)
			);

			return json_encode($persona);
		}
	}

	/**
	 * Agrega nueva persona y persona al centro familiar con datos básicos (modal de asistencia)
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function guardaPersonaBasica() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$pers_id = isset($this->request->data['pers_id'])? $this->request->data['pers_id']: null;
			$cefa_id = $this->request->data['cefa_id'];

			if ($pers_id == null) { // persona nueva
				$pers_run = isset($this->request->data['pers_run'])? $this->request->data['pers_run']: null;
				$pers_run_dv = isset($this->request->data['pers_run_dv'])? $this->request->data['pers_run_dv']: null;
				$pers_nombres = $this->request->data['pers_nombres'];
				$pers_ap_paterno = $this->request->data['pers_ap_paterno'];
				$pers_ap_materno = $this->request->data['pers_ap_materno'];
				$sexo_id = $this->request->data['sexo_id'];
				$pers_fecha_nacimiento = CakeTime::format($this->request->data['pers_fecha_nacimiento'], '%Y-%m-%d');

				// si la persona viene con un run vacío, se le tiene que inventar uno
				if ($pers_run == null && $pers_run_dv == null) {
					$pers_run = $this->Persona->generarMaxRun();
					$pers_run_dv = $this->Persona->getDv($pers_run);
				}

				$persData = array(
					'Persona' => array(
						'pers_run' => $pers_run,
						'pers_run_dv' => $pers_run_dv,
						'pers_nombres' => $pers_nombres,
						'pers_ap_paterno' => $pers_ap_paterno,
						'pers_ap_materno' => $pers_ap_materno,
						'sexo_id' => $sexo_id,
						'pers_fecha_nacimiento' => $pers_fecha_nacimiento
					)
				);

				$dataSource = $this->Persona->getDataSource();
				$dataSource->begin();

				$this->Persona->create();
				if ($this->Persona->save($persData, array('validate' => false))) {
					$pecfData = array(
						'PersonaCentroFamiliar' => array(
							'pers_id' => $this->Persona->id,
							'cefa_id' => $cefa_id,
				        	'pecf_habilitada' => true
					    )
				    );
				    $this->Persona->PersonaCentroFamiliar->create();
				    if ($this->Persona->PersonaCentroFamiliar->save($pecfData, array('validate' => false))) {
				    	$dataSource->commit();
				    } else {
				    	$dataSource->rollback();
				    }
				} else {
					$dataSource->rollback();
				}

			} else {
				// revisamos si esta persona está inscrita en el centro familiar
				// si no, la inscribimos
				$pecfInfo = $this->Persona->PersonaCentroFamiliar->find('first',
					array(
						'conditions' => array(
							'PersonaCentroFamiliar.pers_id' => $pers_id,
							'PersonaCentroFamiliar.cefa_id' => $cefa_id
						)
					)
				);

				if (sizeof($pecfInfo) > 0) { // la persona existe en el centro familiar
					$this->Persona->PersonaCentroFamiliar->id = $pecfInfo['PersonaCentroFamiliar']['pecf_id'];
					$this->Persona->PersonaCentroFamiliar->saveField('pecf_habilitada', true);

				} else { // la persona no existe en el centro familiar
					$pecfData = array(
						'PersonaCentroFamiliar' => array(
							'pers_id' => $pers_id,
							'cefa_id' => $cefa_id,
							'pecf_habilitada' => true
						)
					);
					$this->Persona->PersonaCentroFamiliar->create();
					$this->Persona->PersonaCentroFamiliar->save($pecfData);
				}

				$this->Persona->id = $pers_id;
			}

			// retornamos pecf_id y pers_run_completo
			echo json_encode(
				array(
					'pecf_id' => $this->Persona->PersonaCentroFamiliar->id,
					'pers_run_completo' => $this->Persona->field('pers_run_completo')
				)
			);
		}
	}

	/**
	 * Lista actividades en las cuales ha participado la persona
	 * 
	 * @author maraya-gómez
	 * @param int $pers_id
	 * @return void
	 */
	public function actividades_participantes($pers_id) {
		$this->Persona->id = $pers_id;
		if (!$this->Persona->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}

		$persona = $this->Persona->find('first',
			array(
				'conditions' => array(
					'Persona.pers_id' => $pers_id
				)
			)
		);

		$actividades = $this->Persona->PersonaCentroFamiliar->Asistencia->find('all',
			array(
				'fields' => array(
					'Actividad.acti_nombre',
					'TipoActividad.tiac_nombre',
					'CentroFamiliar.cefa_nombre',
					'(SELECT COUNT(*)
					  FROM asistencias
					  NATURAL JOIN sesiones
					  NATURAL JOIN actividades
					  WHERE pecf_id = "PersonaCentroFamiliar".pecf_id
					  AND acti_id = "Actividad".acti_id) as total_sesiones',
					'Actividad.acti_fecha_inicio'
				),
				'joins' => array(
					array(
			        	'table' => 'personas_centros_familiares',
			        	'alias' => 'PersonaCentroFamiliar',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id'
			            )
			        ),
					array(
			        	'table' => 'sesiones',
			        	'alias' => 'Sesion',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'Asistencia.sesi_id = Sesion.sesi_id'
			            )
			        ),
			        array(
			        	'table' => 'personas',
			        	'alias' => 'Persona',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'PersonaCentroFamiliar.pers_id = Persona.pers_id'
			            )
			        ),
			        array(
			        	'table' => 'actividades',
			        	'alias' => 'Actividad',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'Sesion.acti_id = Actividad.acti_id'
			            )
			        ),
			        array(
			        	'table' => 'centros_familiares',
			        	'alias' => 'CentroFamiliar',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'Actividad.cefa_id = CentroFamiliar.cefa_id'
			            )
			        ),			        
			        array(
			        	'table' => 'tipos_actividades',
			        	'alias' => 'TipoActividad',
			        	'type'  => 'INNER',
			        	'conditions' => array(
			        		'Actividad.tiac_id = TipoActividad.tiac_id'
			            )
			        )
			    ),
				'conditions' => array(
					'Persona.pers_id' => $pers_id
				),
				'group' => array(
					'Actividad.acti_id',
					'Actividad.acti_nombre',
					'TipoActividad.tiac_nombre',
					'CentroFamiliar.cefa_nombre',
					'Actividad.acti_fecha_inicio',
					'PersonaCentroFamiliar.pecf_id'
				)
			)
		);
		
		$this->set('actividades', $actividades);
		$this->set('persona', $persona);
	}

	/**
	 * Lista los planes de trabajo por persona
	 * 
	 * @author maraya-gómez
	 * @param int $pecf_id
	 * @return void
	 */
	public function planes_trabajos($pecf_id) {
		$this->Persona->PersonaCentroFamiliar->id = $pecf_id;
		if (!$this->Persona->PersonaCentroFamiliar->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}

		$persona = $this->Persona->PersonaCentroFamiliar->find('first',
			array(
				'contain' => array(
					'Persona'
				),
				'conditions' => array(
					'PersonaCentroFamiliar.pecf_id' => $pecf_id
				)
			)
		);

		$planesTrabajos = $this->Persona->PersonaCentroFamiliar->PlanTrabajo->find('all',
			array(
				'contain' => array(
					'GrupoObjetivo'
				),
				'conditions' => array(
					'PlanTrabajo.pecf_id' => $pecf_id
				)
			)
		);

		$this->set(compact('planesTrabajos', 'persona'));
	}
}