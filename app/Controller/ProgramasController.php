<?php

class ProgramasController extends AppController {

	/**
	 * Método lista todos los programas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(prog_nombre || \' \' || prog_ano) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('programas', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo programa
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Programa->create();
			
			if ($this->Programa->save($this->request->data)) {
				$this->Session->setFlash(__('El programa ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el programa. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un programa
	 * 
	 * @param int $prog_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($prog_id) {
		if (!$this->Programa->exists($prog_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Programa->save($this->request->data)) {
				$this->Session->setFlash(__('El programa ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el programa. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Programa.' . $this->Programa->primaryKey => $prog_id
				)
			);
			$this->request->data = $this->Programa->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un programa
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $prog_id
	 * @return void
	 */
	public function delete($prog_id = null) {
		$this->Programa->id = $prog_id;
		if (!$this->Programa->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Programa->delete()) {
			$this->Session->setFlash(__('El programa ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el programa. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}