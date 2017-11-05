<?php

class TiposFamiliasController extends AppController {

	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('TipoFamilia');

	/**
	 * Método lista todos los tipos de familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(tifa_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('tiposFamilias', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo tipo de familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoFamilia->create();
			
			if ($this->TipoFamilia->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de familia ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el tipo de familia. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un tipo de familia
	 * 
	 * @param int $tifa_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($tifa_id) {
		if (!$this->TipoFamilia->exists($tifa_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->TipoFamilia->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de familia ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el tipo de familia. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'TipoFamilia.' . $this->TipoFamilia->primaryKey => $tifa_id
				)
			);
			$this->request->data = $this->TipoFamilia->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un tipo de familia
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param int $tifa_id
	 * @return void
	 */
	public function delete($tifa_id = null) {
		$this->TipoFamilia->id = $tifa_id;
		if (!$this->TipoFamilia->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->TipoFamilia->delete()) {
			$this->Session->setFlash(__('El tipo de familia ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el tipo de familia. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}