<?php
class FamiliasController extends AppController {

	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('Familia');

	/**
	 * Método lista todas las familias
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$anyo = date('Y');
		$paginate = array(
			'fields' => array(
				'Familia.fami_id',
				'Familia.fami_ap_paterno',
				'Familia.fami_ap_materno',
				'CentroFamiliar.cefa_nombre',
				'f_familia_participa_en_actividad_del_anyo("Familia".fami_id, '.$anyo.')',
				'f_familia_tiene_ficha_completa("Familia".fami_id)'
			),
			'contain' => array(
				'Comuna',
				'CentroFamiliar',
				'IntegranteFamiliar'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = mb_strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(fami_ap_paterno || \' \' || fami_ap_materno || \' \' || fami_direccion_calle || \' \' || fami_direccion_nro) LIKE \'%'. $t .'%\''
			);	
		}

		
		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$paginate['conditions'][] = sprintf('Familia.cefa_id = %d', $this->cefa_id);
		}

		// filtros de busqueda avanzada
		if (!empty($this->request->query['sf_cefa_id'])) {		
			$paginate['conditions'][] = sprintf('Familia.cefa_id = %d', $this->request->query['sf_cefa_id']);
		}

		if (!empty($this->request->query['sf_tifa_id'])) {		
			$paginate['conditions'][] = sprintf('Familia.tifa_id = %d', $this->request->query['sf_tifa_id']);
		}

		if (!empty($this->request->query['sf_participacion'])) {
			$participante = htmlentities($this->request->query['sf_participacion']);
			$paginate['conditions'][] = ($participante == 1)? sprintf('f_familia_participa_en_actividad_del_anyo("Familia".fami_id, %d) IS TRUE', $anyo): sprintf('f_familia_participa_en_actividad_del_anyo("Familia".fami_id, %d) IS FALSE', $anyo);
		}

		if (!empty($this->request->query['sf_ano'])) {		
			$paginate['conditions'][] = sprintf('DATE_PART(\'YEAR\', Familia.fami_fecha_creacion) = %d', $this->request->query['sf_ano']);
		}

		if (!empty($this->request->query['sf_tiene_personas'])) {
			$tienePersonas = $this->request->query['sf_tiene_personas'];
			$paginate['conditions'][] = ($tienePersonas == 1)? '(SELECT COUNT(*) FROM personas WHERE fami_id = "Familia".fami_id) > 0': '(SELECT COUNT(*) FROM personas WHERE fami_id = "Familia".fami_id) = 0';
		}

		if (!empty($this->request->query['sf_tiene_ficha'])) {
			$tieneFicha = $this->request->query['sf_tiene_ficha'];
			$paginate['conditions'][] = ($tieneFicha == 1)? 'f_familia_tiene_ficha_completa("Familia".fami_id) IS TRUE': 'f_familia_tiene_ficha_completa("Familia".fami_id) IS FALSE';
		}

		$this->paginate = $paginate;

		// buscamos centros familiares para filtro
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list',
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
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_nombre' => 'ASC'
					)
				)
			);
		}

		$this->set('familias', $this->Paginator->paginate());

		$tiposFamilias = $this->Familia->TipoFamilia->find('list');
		$combos = array(
			'centrosFamiliares' => $centrosFamiliares,
			'tiposFamilias' => $tiposFamilias
		);
		$this->set('combos', $combos);
	}

	/**
	 * Método agrega una nueva familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Familia->create();

			if ($this->Familia->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La familia ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la familia. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$comunas = $this->Familia->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$tiposFamilias = $this->Familia->TipoFamilia->find('list');
		$redes = $this->Familia->Red->find('list');
		$situacionesHabitacionales = $this->Familia->SituacionHabitacional->find('list');
		$condicionesVulnerabilidad = $this->Familia->CondicionVulnerabilidadFamilia->CondicionVulnerabilidad->find('all',
			array(
				'CondicionVulnerabilidad.covu_nombre ASC'
			)
		);

		$factoresRiesgos = $this->Familia->FactorRiesgoFamilia->FactorRiesgo->find('all',
			array(
				'FactorRiesgo.fari_descripcion ASC'
			)
		);

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list');
		}

		$this->set(compact('factoresRiesgos', 'centrosFamiliares', 'comunas', 'tiposFamilias', 'condicionesVulnerabilidad', 'situacionesHabitacionales', 'redes'));
	}

	/**
	 * Método edita una familia
	 * 
	 * @param int $fami_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($fami_id) {
		if (!$this->Familia->exists($fami_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			// fecha de actualización de dato
			$this->request->data['Familia']['fami_fecha_act'] = date('Y-m-d H:i:s');

			if ($this->Familia->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('La familia ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la familia. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'contain' => array(
					'Persona' => array(
						'fields' => array(
							'Persona.pers_id',
							'Persona.pers_nombre_completo'
						)
					),
					'CondicionVulnerabilidadFamilia',
					'FactorRiesgoFamilia'
				),
				'conditions' => array(
					'Familia.' . $this->Familia->primaryKey => $fami_id
				)
			);
			$this->request->data = $this->Familia->find('first', $conditions);
			$this->request->data['Familia']['pers_nombre'] = $this->request->data['Persona']['pers_nombre_completo'];
		}

		$comunas = $this->Familia->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$tiposFamilias = $this->Familia->TipoFamilia->find('list');
		$redes = $this->Familia->Red->find('list');
		$situacionesHabitacionales = $this->Familia->SituacionHabitacional->find('list');
		$condicionesVulnerabilidad = $this->Familia->CondicionVulnerabilidadFamilia->CondicionVulnerabilidad->find('all',
			array(
				'CondicionVulnerabilidad.covu_nombre ASC'
			)
		);

		$factoresRiesgos = $this->Familia->FactorRiesgoFamilia->FactorRiesgo->find('all',
			array(
				'FactorRiesgo.fari_descripcion ASC'
			)
		);

		// informacion de los integrantes de la familia
		$integrantes = $this->Familia->IntegranteFamiliar->find('all',
			array(
				'contain' => array(
					'Parentesco'
				),
				'conditions' => array(
					'IntegranteFamiliar.fami_id' => $fami_id
				)
			)
		);

		// si el perfil es comuna o digitador
		if ($this->perf_id == 3 || $this->perf_id == 10) {
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Familia->CentroFamiliar->find('list');
		}

		$this->set(compact('integrantes', 'factoresRiesgos', 'centrosFamiliares', 'comunas', 'tiposFamilias', 'condicionesVulnerabilidad', 'situacionesHabitacionales', 'redes'));
	}

	/**
	 * Método muestra detalle de una familia
	 * 
	 * @param int $fami_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($fami_id) {
		if (!$this->Familia->exists($fami_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$familia = $this->Familia->find('first',
			array(
				'contain' => array(
					'Comuna',
					'Persona',
					'TipoFamilia',
					'Red',
					'IntegranteFamiliar' => array(
						'Parentesco'
					),
					'CondicionVulnerabilidadFamilia' => array(
						'CondicionVulnerabilidad'
					),
					'FactorRiesgoFamilia' => array(
						'FactorRiesgo'
					),
					'SituacionHabitacional',
					'CentroFamiliar'
				),
				'conditions' => array(
					'Familia.fami_id' => $fami_id
				)
			)
		);
		
		$this->set(compact('familia'));
	}

	/**
	 * Método elimina una familia
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $fami_id
	 * @return void
	 */
	public function delete($fami_id = null) {
		$this->Familia->id = $fami_id;
		if (!$this->Familia->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Familia->delete()) {
			$this->Session->setFlash(__('La familia ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la familia familiar. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método encuentra a familias según query (typeahead)
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_familias() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$query = strtolower($this->request->query['q']);
			$familias = $this->Familia->find('all',
				array(
					'contain' => array(
						'Comuna'
					),
					'conditions' => array(
						'LOWER(fami_ap_paterno || \' \' || fami_ap_materno) LIKE \'%'. $query .'%\'' 
					)
				)
			);
			
			return json_encode($familias);
		}
	}


	/**
	 * Método lista todas las actividades participantes de los integrantes de la familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function actividades_participantes($fami_id) {
		if (!$this->Familia->exists($fami_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$familia = $this->Familia->find('first',
			array(
				'contain' => array(
					'Comuna',
					'CentroFamiliar'
				),
				'conditions' => array(
					'Familia.fami_id' => $fami_id
				)
			)
		);

		// buscamos a los integrantes de esta familia que hayan participado
		// de al menos una actividad del año
		$anyo = date('Y');
		$integrantes = $this->Familia->buscaIntegrantesParticipantes($fami_id, $anyo);
		$this->set(compact('familia', 'integrantes'));
	}

	/**
	 * Método lista todas los participantes de una familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function info_participantes($fami_id) {
		if (!$this->Familia->exists($fami_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		// informacion de los integrantes de la familia
		$integrantes = $this->Familia->IntegranteFamiliar->find('all',
			array(
				'contain' => array(
					'Parentesco',
					'Familia'
				),
				'conditions' => array(
					'IntegranteFamiliar.fami_id' => $fami_id
				)
			)
		);
		
		$this->set(compact('integrantes'));
	}

}