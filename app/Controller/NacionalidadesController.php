<?php

class NacionalidadesController extends AppController {
		
	/**
	 * Modelos a usar
	 *
	 * @var array
	 */
	public $uses = array('Nacionalidad');

	/**
	 * Método lista todas las nacionalidades
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		$paginate = array(
			'contain' => array(
				'Pais'
			),
			'conditions' => array(
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			
			$paginate['conditions'] = array(
				'LOWER(naci_nombre) LIKE \'%'. $t .'%\''
			);
		}

		$this->paginate = $paginate;
		$this->set('nacionalidades', $this->Paginator->paginate());
	}

	/**
	 * Método agrega una nueva nacionalidad
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {

		if ($this->request->is('post')) {
			$this->Nacionalidad->create();

			if ($this->Nacionalidad->save($this->request->data)) {
				$this->Session->setFlash(__('La nacionalidad ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la nacionalidad. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$paises = $this->Nacionalidad->Pais->find('list');
		$this->set(compact('paises'));
	}

	/**
	 * Método edita una nacionalidad
	 * 
	 * @param int $naci_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($naci_id) {
		if (!$this->Nacionalidad->exists($naci_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Nacionalidad->save($this->request->data)) {
				$this->Session->setFlash(__('La nacionalidad ha sido guardada.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar la nacionalidad. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Nacionalidad.' . $this->Nacionalidad->primaryKey => $naci_id
				)
			);
			$this->request->data = $this->Nacionalidad->find('first', $conditions);
		}

		$paises = $this->Nacionalidad->Pais->find('list');
		$this->set(compact('paises'));
	}

	/**
	 * Método elimina una nacionalidad
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $naci_id
	 * @return void
	 */
	public function delete($naci_id = null) {
		$this->Nacionalidad->id = $naci_id;
		if (!$this->Nacionalidad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Nacionalidad->delete()) {
			$this->Session->setFlash(__('La nacionalidad ha sido guardada.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar la nacionalidad. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}