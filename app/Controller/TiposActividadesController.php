<?php

class TiposActividadesController extends AppController {
	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('TipoActividad');

	/**
	 * Método lista todos los tipos de actividades
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'Area'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(area_nombre || \' \' || tiac_nombre) LIKE \'%'. $t .'%\''
			);
		}

		$this->paginate = $paginate;
		$this->set('tiposActividades', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo tipo de actividad
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoActividad->create();
			
			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de actividad ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el eje. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$areas = $this->TipoActividad->Area->find('list');
		$this->set(compact('areas'));
	}

	/**
	 * Método edita un tipo de actividad
	 * 
	 * @param int $tiac_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($tiac_id) {
		if (!$this->TipoActividad->exists($tiac_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de actividad ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el eje. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'TipoActividad.' . $this->TipoActividad->primaryKey => $tiac_id
				)
			);
			$this->request->data = $this->TipoActividad->find('first', $conditions);
		}

		$areas = $this->TipoActividad->Area->find('list');
		$this->set(compact('areas'));
	}

	/**
	 * Método elimina un tipo de actividad
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $tiac_id
	 * @return void
	 */
	public function delete($tiac_id = null) {
		$this->TipoActividad->id = $tiac_id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->TipoActividad->delete()) {
			$this->Session->setFlash(__('El tipo de actividad ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el tipo de actividad. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Retorna tipos de actividades por area
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_by_areas() {
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			$area_id = $this->request->data['area_id'];
			$tiposActividades = $this->TipoActividad->find('all',
				array(
					'conditions' => array(
						'TipoActividad.area_id' => $area_id
					)
				)
			);

			return json_encode($tiposActividades);
		}
	}
}