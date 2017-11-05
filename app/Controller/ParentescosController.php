<?php

class ParentescosController extends AppController {

	/**
	 * Método lista todos los parentescos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(pare_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('parentescos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo parentesco
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Parentesco->create();
			
			if ($this->Parentesco->save($this->request->data)) {
				$this->Session->setFlash(__('El parentesco ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el parentesco. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un parentesco
	 * 
	 * @param int $ejes_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($pare_id) {
		if (!$this->Parentesco->exists($pare_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Parentesco->save($this->request->data)) {
				$this->Session->setFlash(__('El parentesco ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el parentesco. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Parentesco.' . $this->Parentesco->primaryKey => $pare_id
				)
			);
			$this->request->data = $this->Parentesco->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un parentesco
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($pare_id = null) {
		$this->Parentesco->id = $pare_id;
		if (!$this->Parentesco->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Parentesco->delete()) {
			$this->Session->setFlash(__('El parentesco ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el parentesco. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}