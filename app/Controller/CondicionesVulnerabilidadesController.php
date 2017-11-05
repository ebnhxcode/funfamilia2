<?php

class CondicionesVulnerabilidadesController extends AppController {

	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('CondicionVulnerabilidad');

	/**
	 * Método lista todos los tipos de condiciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(covu_nomnre || \' \' || covu_indicador) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('condiciones', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo tipo de condición
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CondicionVulnerabilidad->create();
			
			if ($this->CondicionVulnerabilidad->save($this->request->data)) {
				$this->Session->setFlash(__('La condición ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la condición. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un tipo de condición
	 * 
	 * @param int $covu_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($covu_id) {
		if (!$this->CondicionVulnerabilidad->exists($covu_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->CondicionVulnerabilidad->save($this->request->data)) {
				$this->Session->setFlash(__('La condición ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la condición. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'CondicionVulnerabilidad.' . $this->CondicionVulnerabilidad->primaryKey => $covu_id
				)
			);
			$this->request->data = $this->CondicionVulnerabilidad->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un tipo de familia
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param int $covu_id
	 * @return void
	 */
	public function delete($covu_id = null) {
		$this->CondicionVulnerabilidad->id = $covu_id;
		if (!$this->CondicionVulnerabilidad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->CondicionVulnerabilidad->delete()) {
			$this->Session->setFlash(__('La condición ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la condición. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}