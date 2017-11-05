<?php
class FactoresRiesgosController extends AppController {
	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('FactorRiesgo');

	/**
	 * Método lista todos los factores de riesgo
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);

			$this->paginate = array(
				'conditions' => array(
					'LOWER(fari_descripcion) LIKE \'%'. $t .'%\''
				)
			);
		}

		$this->set('factoresRiesgos', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo factor de riesgo
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FactorRiesgo->create();
			
			if ($this->FactorRiesgo->save($this->request->data)) {
				$this->Session->setFlash(__('El factor de riesgo ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el factor de riesgo. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un factor de riesgo
	 * 
	 * @param int $fari_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($fari_id) {
		if (!$this->FactorRiesgo->exists($fari_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->FactorRiesgo->save($this->request->data)) {
				$this->Session->setFlash(__('El factor de riesgo ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el factor de riesgo. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'FactorRiesgo.' . $this->FactorRiesgo->primaryKey => $fari_id
				)
			);
			$this->request->data = $this->FactorRiesgo->find('first', $conditions);
		}
	}

	/**
	 * Método elimina un factor de riesgo
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $fari_id
	 * @return void
	 */
	public function delete($fari_id = null) {
		$this->FactorRiesgo->id = $fari_id;
		if (!$this->FactorRiesgo->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->FactorRiesgo->delete()) {
			$this->Session->setFlash(__('El factor de riesgo ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el factor de riesgo. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
