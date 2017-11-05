<?php
class TiposInstitucionesController extends AppController {
	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('TipoInstitucion');

	/**
	 * Método lista todos los tipos de instituciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array();

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate = array(
				'conditions' => array(
					'LOWER(tiin_nombre) LIKE \'%'. $t .'%\''
				)
			);
		}
		
		// tipos de instituciones que no sean de salud ni previsión
		$paginate['conditions'][] = 'TipoInstitucion.tiin_id NOT IN (2, 3)';
		$this->paginate = $paginate;

		$this->set('tiposInstituciones', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo tipo de institución
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoInstitucion->create();
			
			if ($this->TipoInstitucion->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de institución ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el tipo de institución. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un tipo de institución
	 * 
	 * @param int $tiin_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($tiin_id) {
		if (!$this->TipoInstitucion->exists($tiin_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->TipoInstitucion->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo de institución ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el tipo de institución. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'TipoInstitucion.' . $this->TipoInstitucion->primaryKey => $tiin_id
				)
			);
			$this->request->data = $this->TipoInstitucion->find('first', $conditions);
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
	public function delete($tiin_id = null) {
		$this->TipoInstitucion->id = $tiin_id;
		if (!$this->TipoInstitucion->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->TipoInstitucion->delete()) {
			$this->Session->setFlash(__('El tipo de institución ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el tipo de institución. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}