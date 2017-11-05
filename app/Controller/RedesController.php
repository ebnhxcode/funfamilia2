<?php

class RedesController extends AppController {

	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('Red');

	/**
	 * Método lista todos las redes
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(rede_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('redes', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva red
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Red->create();
			
			if ($this->Red->save($this->request->data)) {
				$this->Session->setFlash(__('La red ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la red. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita una red
	 * 
	 * @param int $rede_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($rede_id) {
		if (!$this->Red->exists($rede_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Red->save($this->request->data)) {
				$this->Session->setFlash(__('La red ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la red. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Red.' . $this->Red->primaryKey => $rede_id
				)
			);
			$this->request->data = $this->Red->find('first', $conditions);
		}
	}

	/**
	 * Método elimina una red
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($rede_id = null) {
		$this->Red->id = $rede_id;
		if (!$this->Red->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Red->delete()) {
			$this->Session->setFlash(__('La red ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la red. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}