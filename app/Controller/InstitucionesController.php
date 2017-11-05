<?php
class InstitucionesController extends AppController {

	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('Institucion');

	/**
	 * Método lista todos las instituciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'TipoInstitucion',
				'CentroFamiliar'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(inst_nombre || \' \' || tiin_nombre || \' \' || cefa_nombre) LIKE \'%'. $t .'%\''
			);
		}

		// instituciones que no sean de salud ni previsión
		$paginate['conditions'][] = 'TipoInstitucion.tiin_id NOT IN (2, 3)';

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$paginate['conditions'][] = sprintf('Institucion.cefa_id = %d', $this->cefa_id);
		}

		$this->paginate = $paginate;
		$this->set('instituciones', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva institucion
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Institucion->create();
			
			if ($this->Institucion->save($this->request->data)) {
				$this->Session->setFlash(__('La institución ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la institución. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$tiposInstituciones = $this->Institucion->TipoInstitucion->find('list',
			array(
				'conditions' => array(
					'TipoInstitucion.tiin_id NOT IN (2, 3)'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Institucion->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => array(
						'CentroFamiliar.cefa_orden'
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Institucion->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_orden'
					)
				)
			);
		}

		$this->set(compact('tiposInstituciones', 'centrosFamiliares'));
	}

	/**
	 * Método edita una institucion
	 * 
	 * @param int $inst_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($inst_id) {
		if (!$this->Institucion->exists($inst_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Institucion->save($this->request->data)) {
				$this->Session->setFlash(__('La institución ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la institución. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Institucion.' . $this->Institucion->primaryKey => $inst_id
				)
			);
			$this->request->data = $this->Institucion->find('first', $conditions);
		}

		$tiposInstituciones = $this->Institucion->TipoInstitucion->find('list',
			array(
				'conditions' => array(
					'TipoInstitucion.tiin_id NOT IN (2, 3)'
				)
			)
		);

		// si el perfil es comuna
		if ($this->perf_id == 3) {
			$centrosFamiliares = $this->Institucion->CentroFamiliar->find('list',
				array(
					'conditions' => array(
						'CentroFamiliar.cefa_id' => $this->cefa_id
					),
					'order' => array(
						'CentroFamiliar.cefa_orden'
					)
				)
			);
		} else {
			$centrosFamiliares = $this->Institucion->CentroFamiliar->find('list',
				array(
					'order' => array(
						'CentroFamiliar.cefa_orden'
					)
				)
			);
		}

		$this->set(compact('tiposInstituciones', 'centrosFamiliares'));
	}

	/**
	 * Método elimina una institucion
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $inst_id
	 * @return void
	 */
	public function delete($inst_id = null) {
		$this->Institucion->id = $inst_id;
		if (!$this->Institucion->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Institucion->delete()) {
			$this->Session->setFlash(__('La institución ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la institución. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método retorna instituciones por centro familiar
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_by_cefa() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$cefa_id = $this->request->data['cefa_id'];

			$instituciones = $this->Institucion->find('all',
				array(
					'conditions' => array(
						'Institucion.cefa_id' => $cefa_id,
						'Institucion.tiin_id NOT IN (2, 3)'
					),
					'order' => array(
						'Institucion.inst_nombre' => 'ASC'
					)
				)
			);
			return json_encode($instituciones);
		}
	}
}