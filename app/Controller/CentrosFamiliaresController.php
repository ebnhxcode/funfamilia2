<?php
class CentrosFamiliaresController extends AppController {

	/**
	 * Modelos
	 *
	 * @var array
	 */
	public $uses = array('CentroFamiliar');

	/**
	 * Método lista todos los centros familiares
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'Comuna'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(cefa_nombre || \' \' || comu_nombre) LIKE \'%'. $t .'%\''
			);	
		}

		$this->paginate = $paginate;
		$this->set('centrosFamiliares', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo centro familiar
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CentroFamiliar->create();

			if ($this->CentroFamiliar->save($this->request->data)) {
				$this->Session->setFlash(__('El centro familiar ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el centro familiar. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$comunas = $this->CentroFamiliar->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$this->set(compact('comunas'));
	}

	/**
	 * Método edita un centro familiar
	 * 
	 * @param int $cefa_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($cefa_id) {
		if (!$this->CentroFamiliar->exists($cefa_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CentroFamiliar->save($this->request->data)) {
				$this->Session->setFlash(__('El centro familiar ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el centro familiar. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'CentroFamiliar.' . $this->CentroFamiliar->primaryKey => $cefa_id
				)
			);
			$this->request->data = $this->CentroFamiliar->find('first', $conditions);
		}

		$comunas = $this->CentroFamiliar->Comuna->find('list', 
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$this->set(compact('comunas'));
	}

	/**
	 * Método detalle de un centro familiar
	 * 
	 * @param int $cefa_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function view($cefa_id) {
		if (!$this->CentroFamiliar->exists($cefa_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		$centroFamiliar = $this->CentroFamiliar->find('first',
			array(
				'contain' => array(
					'Comuna'
				),
				'conditions' => array(
					'CentroFamiliar.cefa_id' => $cefa_id
				)
			)
		);

		$this->set(compact('centroFamiliar'));
	}

	/**
	 * Método elimina un centro familiar
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $cefa_id
	 * @return void
	 */
	public function delete($cefa_id = null) {
		$this->CentroFamiliar->id = $cefa_id;
		if (!$this->CentroFamiliar->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->CentroFamiliar->delete()) {
			$this->Session->setFlash(__('El centro familiar ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el centro familiar. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}