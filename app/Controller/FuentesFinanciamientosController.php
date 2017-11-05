<?php
class FuentesFinanciamientosController extends AppController {
	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('FuenteFinanciamiento');

	/**
	 * Método lista todos las fuentes de financiamiento
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(fufi_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		
		$this->set('fuentesFinanciamientos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva fuente de financiamiento
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FuenteFinanciamiento->create();
			
			if ($this->FuenteFinanciamiento->save($this->request->data)) {
				$this->Session->setFlash(__('La fuente de financiamiento ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la fuente de financiamiento. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita una fuente de financiamiento
	 * 
	 * @param int $fufi_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($fufi_id) {
		if (!$this->FuenteFinanciamiento->exists($fufi_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->FuenteFinanciamiento->save($this->request->data)) {
				$this->Session->setFlash(__('La fuente de financiamiento ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la fuente de financiamiento. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'FuenteFinanciamiento.' . $this->FuenteFinanciamiento->primaryKey => $fufi_id
				)
			);
			$this->request->data = $this->FuenteFinanciamiento->find('first', $conditions);
		}
	}

	/**
	 * Método elimina una fuente de financiamiento
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $fufi_id
	 * @return void
	 */
	public function delete($fufi_id = null) {
		$this->FuenteFinanciamiento->id = $fufi_id;
		if (!$this->FuenteFinanciamiento->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->FuenteFinanciamiento->delete()) {
			$this->Session->setFlash(__('La fuente de financiamiento ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la fuente de financiamiento. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}