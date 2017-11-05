<?php

class PueblosOriginariosController extends AppController {
		
	/**
	 * Modelos a usar
	 *
	 * @var array
	 */
	public $uses = array('PuebloOriginario');

	/**
	 * Método lista todas los pueblos originarios
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		$paginate = array(
			'contain' => array(
				'Pais'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			
			$paginate['conditions'] = array(
				'LOWER(puor_nombre) LIKE \'%'. $t .'%\''
			);
			
		}

		$this->paginate = $paginate;
		$this->set('pueblosOriginarios', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo pueblo originario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {

		if ($this->request->is('post')) {
			$this->PuebloOriginario->create();

			if ($this->PuebloOriginario->save($this->request->data)) {
				$this->Session->setFlash(__('El pueblo originario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el pueblo originario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$paises = $this->PuebloOriginario->Pais->find('list');
		$this->set(compact('paises'));
	}

	/**
	 * Método edita un pueblo originario
	 * 
	 * @param int $puor_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($puor_id) {
		if (!$this->PuebloOriginario->exists($puor_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->PuebloOriginario->save($this->request->data)) {
				$this->Session->setFlash(__('El pueblo originario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el pueblo originario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'PuebloOriginario.' . $this->PuebloOriginario->primaryKey => $puor_id
				)
			);
			$this->request->data = $this->PuebloOriginario->find('first', $conditions);
		}

		$paises = $this->PuebloOriginario->Pais->find('list');
		$this->set(compact('paises'));
	}

	/**
	 * Método elimina un pueblo originario
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $puor_id
	 * @return void
	 */
	public function delete($puor_id = null) {
		$this->PuebloOriginario->id = $puor_id;
		if (!$this->PuebloOriginario->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->PuebloOriginario->delete()) {
			$this->Session->setFlash(__('El pueblo originario ha sido guardado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el pueblo originario. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}