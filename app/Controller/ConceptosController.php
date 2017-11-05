<?php
class ConceptosController extends AppController {
	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('Concepto');

	/**
	 * Método lista todos los conceptos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(conc_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		
		$this->set('conceptos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo concepto
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Concepto->create();
			
			if ($this->Concepto->save($this->request->data)) {
				$this->Session->setFlash(__('El concepto ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el concepto. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un concepto
	 * 
	 * @param int $conc_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($conc_id) {
		if (!$this->Concepto->exists($conc_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Concepto->save($this->request->data)) {
				$this->Session->setFlash(__('El concepto ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el concepto. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Concepto.' . $this->Concepto->primaryKey => $conc_id
				)
			);
			$this->request->data = $this->Concepto->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un concepto
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $conc_id
	 * @return void
	 */
	public function delete($conc_id = null) {
		$this->Concepto->id = $conc_id;
		if (!$this->Concepto->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Concepto->delete()) {
			$this->Session->setFlash(__('El concepto ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el concepto. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}