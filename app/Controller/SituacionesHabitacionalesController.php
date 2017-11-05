<?php
class SituacionesHabitacionalesController extends AppController {
	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('SituacionHabitacional');

	/**
	 * Método lista todos las situaciones habitacionales
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(siha_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('situacionesHabitacionales', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva situacion habitacional
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SituacionHabitacional->create();
			
			if ($this->SituacionHabitacional->save($this->request->data)) {
				$this->Session->setFlash(__('La situación habitacional ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la situación habitacional. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita una situacion habitacional
	 * 
	 * @param int $rede_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($rede_id) {
		if (!$this->SituacionHabitacional->exists($rede_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->SituacionHabitacional->save($this->request->data)) {
				$this->Session->setFlash(__('La situación habitacional ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la situación habitacional. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'SituacionHabitacional.' . $this->SituacionHabitacional->primaryKey => $rede_id
				)
			);
			$this->request->data = $this->SituacionHabitacional->find('first', $conditions);
		}
	}

	/**
	 * Método elimina una situacion habitacional
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $siha_id
	 * @return void
	 */
	public function delete($siha_id = null) {
		$this->SituacionHabitacional->id = $siha_id;
		if (!$this->SituacionHabitacional->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->SituacionHabitacional->delete()) {
			$this->Session->setFlash(__('La situación habitacional ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la situación habitacional. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}