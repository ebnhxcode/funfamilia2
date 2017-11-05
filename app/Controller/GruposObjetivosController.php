<?php
class GruposObjetivosController extends AppController {

	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('GrupoObjetivo');

	/**
	 * Método lista todos los grupos objetivos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(grob_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('gruposObjetivos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo grupo objetivo
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->GrupoObjetivo->create();
			
			if ($this->GrupoObjetivo->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo objetivo ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el grupo objetivo. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un grupo objetivo
	 * 
	 * @param int $grob_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($grob_id) {
		if (!$this->GrupoObjetivo->exists($grob_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->GrupoObjetivo->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo objetivo ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el grupo objetivo. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'GrupoObjetivo.' . $this->GrupoObjetivo->primaryKey => $grob_id
				)
			);
			$this->request->data = $this->GrupoObjetivo->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un grupo objetivo
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $grob_id
	 * @return void
	 */
	public function delete($grob_id = null) {
		$this->GrupoObjetivo->id = $grob_id;
		if (!$this->GrupoObjetivo->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->GrupoObjetivo->delete()) {
			$this->Session->setFlash(__('El grupo objetivo ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el grupo objetivo. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

}