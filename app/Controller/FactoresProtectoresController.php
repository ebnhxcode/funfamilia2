<?php
class FactoresProtectoresController extends AppController {

	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('FactorProtector');

	/**
	 * Método lista todos los factores protectores
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		$paginate = array(
			'contain' => array(
				'Nivel' => array(
					'GrupoObjetivo'
				)
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(nive_nombre || \' \' || fapr_nombre) LIKE \'%'. $t .'%\''
			);
		}
		$this->paginate = $paginate;
		$this->set('factoresProtectores', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo factor protector
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->FactorProtector->create();
			
			if ($this->FactorProtector->save($this->request->data)) {
				$this->Session->setFlash(__('El factor protector ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el factor protector. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$niveles = $this->FactorProtector->Nivel->find('list');
		$this->set(compact('niveles'));
	}

	/**
	 * Método edita un factor protector
	 * 
	 * @param int $fapr_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($fapr_id) {
		if (!$this->FactorProtector->exists($fapr_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->FactorProtector->save($this->request->data)) {
				$this->Session->setFlash(__('El factor protector ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el factor protector. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'FactorProtector.' . $this->FactorProtector->primaryKey => $fapr_id
				)
			);
			$this->request->data = $this->FactorProtector->find('first', $conditions);
		}

		$niveles = $this->FactorProtector->Nivel->find('list');
		$this->set(compact('niveles'));
	}

	/**
	 * Método elimina un factor protector
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $fapr_id
	 * @return void
	 */
	public function delete($fapr_id = null) {
		$this->FactorProtector->id = $fapr_id;
		if (!$this->FactorProtector->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->FactorProtector->delete()) {
			$this->Session->setFlash(__('El factor protector ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el factor protector. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Método retorna todos los factores protectores de un nivel
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_factores_by_nivel() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$nive_id = $this->request->data['nive_id'];

			$factoresProtectores = $this->FactorProtector->find('all',
				array(
					'conditions' => array(
						'FactorProtector.nive_id' => $nive_id
					),
					'order' => array(
						'FactorProtector.fapr_nombre ASC'
					)
				)
			);

			echo json_encode($factoresProtectores);
		}
	}

	/**
	 * Método retorna todos los factores protectores filtrados por nivel y año
	 *
	 * @author ][V][arcel
	 * @return string
	 */
	public function find_factores_by_nivel_y_ano() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$nive_id = $this->request->data['nive_id'];
			$fapr_ano = $this->request->data['fapr_ano'];

			$factoresProtectores = $this->FactorProtector->find('all',
				array(
					'conditions' => array(
						'FactorProtector.nive_id' => $nive_id,
						'FactorProtector.fapr_ano' => $fapr_ano
					),
					'order' => array(
						'FactorProtector.fapr_nombre ASC'
					)
				)
			);

			echo json_encode($factoresProtectores);
		}
	}

	/**
	 * Método clona factores protectores
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function clonar() {
		if ($this->request->is('post')) {
			$dataDesde = $this->FactorProtector->find('all',
				array(
					'conditions' => array(
						'FactorProtector.fapr_ano' => $this->request->data['FactorProtector']['fapr_ano_desde']
					),
					'contain' => array(
						'IndicadorFactorProtector'
					)
				)
			);
						
			$info = array();
			$i = 0;
			foreach ($dataDesde as $desde) {
				unset($desde['FactorProtector']['fapr_id']);
				$desde['FactorProtector']['fapr_ano'] = $this->request->data['FactorProtector']['fapr_ano_hasta'];
				$info[$i]['FactorProtector'] = $desde['FactorProtector'];
				$j = 0;

				foreach ($desde['IndicadorFactorProtector'] as $indicador) {
					unset($indicador['ifpr_id']);
					unset($indicador['fapr_id']);
					$info[$i]['IndicadorFactorProtector'][$j] = $indicador;
					$j++;					
				}
				$i++;
			}

			if ($this->FactorProtector->saveMany($info, array('validate' => false, 'atomic' => true, 'deep' => true))) {
				$this->Session->setFlash(__('Factores protectores clonados al año %d.', $this->request->data['FactorProtector']['fapr_ano_hasta']), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudieron clonar los factores protectores. Por favor, inténtelo nuevamente.'), 'error_alert');
			}
		}

		$anos = $this->FactorProtector->find('list',
			array(
				'fields' => array(
					'FactorProtector.fapr_ano',
					'FactorProtector.fapr_ano'
				),
				'group' => array(
					'FactorProtector.fapr_ano',
				)
			)
		);

		$this->set(compact('anos'));
	}
}