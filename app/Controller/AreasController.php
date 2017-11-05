<?php

class AreasController extends AppController {

	/**
	 * Método lista todos las areas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'Programa'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);

			$paginate['conditions'] = array(
				'LOWER(area_nombre || \' \' || prog_nombre) LIKE \'%'. $t .'%\''
			);
		}

		$this->paginate = $paginate;
		$this->set('areas', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva area
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Area->create();
			
			if ($this->Area->save($this->request->data)) {
				$this->Session->setFlash(__('El área ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el área. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$programas = $this->Area->Programa->find('list',
			array(
				'order' => 'Programa.prog_nombre_ano DESC'
			)
		);
		$this->set(compact('programas'));

	}

	/**
	 * Método edita un área
	 * 
	 * @param int $area_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($area_id) {
		if (!$this->Area->exists($area_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Area->save($this->request->data)) {
				$this->Session->setFlash(__('El área ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el área. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Area.' . $this->Area->primaryKey => $area_id
				)
			);
			$this->request->data = $this->Area->find('first', $conditions);
		}

		$programas = $this->Area->Programa->find('list',
			array(
				'order' => 'Programa.prog_nombre_ano DESC'
			)
		);
		$this->set(compact('programas'));
	}

	/**
	 * Método elimina un área
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($area_id = null) {
		$this->Area->id = $area_id;
		if (!$this->Area->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Area->delete()) {
			$this->Session->setFlash(__('El área ha sido eliminada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el área. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Retorna areas por programacion
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_by_prog() {
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			$prog_id = $this->request->data['prog_id'];
			$areas = $this->Area->find('all',
				array(
					'conditions' => array(
						'Area.prog_id' => $prog_id
					)
				)
			);

			return json_encode($areas);
		}
	}
}