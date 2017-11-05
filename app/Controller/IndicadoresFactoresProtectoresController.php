<?php
class IndicadoresFactoresProtectoresController extends AppController {
	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('IndicadorFactorProtector');

	/**
	 * Método lista todos los indicadores de factores protectores
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		$paginate = array(
			'contain' => array(
				'FactorProtector' => array(
					'Nivel'
				)
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(ifpr_descripcion || \' \' || fapr_nombre) LIKE \'%'. $t .'%\''
			);
		}
		$this->paginate = $paginate;
		$this->set('indicadoresFactoresProtectores', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo indicador de factor protector
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->IndicadorFactorProtector->create();
			
			if ($this->IndicadorFactorProtector->save($this->request->data)) {
				$this->Session->setFlash(__('El indicador ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el indiciador. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$niveles = $this->IndicadorFactorProtector->FactorProtector->Nivel->find('list');
		$this->set(compact('niveles'));
	}

	/**
	 * Método edita un factor protector
	 * 
	 * @param int $ifpr_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($ifpr_id) {
		if (!$this->IndicadorFactorProtector->exists($ifpr_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->IndicadorFactorProtector->save($this->request->data)) {
				$this->Session->setFlash(__('El indicador ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el indiciador. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'contain' => array(
					'FactorProtector'
				),
				'conditions' => array(
					'IndicadorFactorProtector.' . $this->IndicadorFactorProtector->primaryKey => $ifpr_id
				)
			);
			$this->request->data = $this->IndicadorFactorProtector->find('first', $conditions);
			$this->request->data['Nivel']['nive_id'] = $this->request->data['FactorProtector']['nive_id'];
		}

		$niveles = $this->IndicadorFactorProtector->FactorProtector->Nivel->find('list');
		$factoresProtectores = $this->IndicadorFactorProtector->FactorProtector->find('list');
		$this->set(compact('niveles', 'factoresProtectores'));
	}

	/**
	 * Método elimina un indicador de factor protector
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $ifpr_id
	 * @return void
	 */
	public function delete($ifpr_id = null) {
		$this->IndicadorFactorProtector->id = $ifpr_id;
		if (!$this->IndicadorFactorProtector->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->IndicadorFactorProtector->delete()) {
			$this->Session->setFlash(__('El indicador ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el indicador. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}