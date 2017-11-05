<?php
class NivelesController extends AppController {

	/**
	 * Modelos
	 * 
	 * @var array
	 */
	public $uses = array('Nivel');

	/**
	 * Método lista todos los niveles
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		
		$paginate = array(
			'contain' => array(
				'GrupoObjetivo'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(nive_nombre || \' \' || grob_nombre) LIKE \'%'. $t .'%\''
			);
		}
		$this->paginate = $paginate;
		$this->set('niveles', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo nivel
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Nivel->create();
			
			if ($this->Nivel->save($this->request->data)) {
				$this->Session->setFlash(__('El nivel ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el nivel. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$gruposObjetivos = $this->Nivel->GrupoObjetivo->find('list');
		$this->set(compact('gruposObjetivos'));
	}

	/**
	 * Método edita un nivel
	 * 
	 * @param int $nive_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($nive_id) {
		if (!$this->Nivel->exists($nive_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->Nivel->save($this->request->data)) {
				$this->Session->setFlash(__('El nivel ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el nivel. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Nivel.' . $this->Nivel->primaryKey => $nive_id
				)
			);
			$this->request->data = $this->Nivel->find('first', $conditions);
		}

		$gruposObjetivos = $this->Nivel->GrupoObjetivo->find('list');
		$this->set(compact('gruposObjetivos'));
	}

	/**
	 * Método elimina un nivel
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $nive_id
	 * @return void
	 */
	public function delete($nive_id = null) {
		$this->Nivel->id = $nive_id;
		if (!$this->Nivel->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Nivel->delete()) {
			$this->Session->setFlash(__('El nivel ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el nivel. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Entrega niveles y sus detalles según grupo objetivo (de la persona)
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_niveles_by_grob() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$grob_id = $this->request->data['grob_id'];
			$niveles = $this->Nivel->find('all',
				array(
					'contain' => array(
						'FactorProtector' => array(
							'conditions' => array(
								'FactorProtector.fapr_ano' => date('Y') // segun funfamilia deben ser los factores protectores del año que arroja el SO
							),
							'IndicadorFactorProtector' => array(
								'order' => 'IndicadorFactorProtector.ifpr_descripcion'
							)
						)
					),
					'conditions' => array(
						'Nivel.grob_id' => $grob_id
					)
				)
			);
			
			return json_encode($niveles);
		}
	}

}