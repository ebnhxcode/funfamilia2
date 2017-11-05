<?php
class PerfilesUsuariosController extends AppController {
	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array('PerfilUsuario');

	/**
	 * Método lista todos los perfiles de los usuarios
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		$paginate = array(
			'contain' => array(
				'Usuario',
				'Perfil',
				'CentroFamiliar'
			)
		);

		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$paginate['conditions'] = array(
				'LOWER(Usuario.usua_nombre || \' \' || Usuario.usua_apellidos || \' \' || Perfil.perf_nombre || \' \' || (CASE WHEN CentroFamiliar.cefa_id IS NOT NULL THEN CentroFamiliar.cefa_nombre ELSE \'\' END)) LIKE \'%'. $t .'%\''
			);
		}

		$this->paginate = $paginate;
		$this->set('perfilesUsuarios', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo perfil de usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PerfilUsuario->create();

			if ($this->request->data['PerfilUsuario']['perf_id'] == 1) {
				unset($this->request->data['PerfilUsuario']['cefa_id']);
			}
			
			if ($this->PerfilUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('El perfil de usuario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el perfil de usuario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}

		$usuarios = $this->PerfilUsuario->Usuario->find('list',
			array(
				'order' => 'usua_nombre_completo ASC'
			)
		);

		$perfiles = $this->PerfilUsuario->Perfil->find('list',
			array(
				'order' => 'perf_nombre ASC'
			)
		);

		$centrosFamiliares = $this->PerfilUsuario->CentroFamiliar->find('list',
			array(
				'order' => 'cefa_nombre ASC'
			)
		);

		$this->set(compact('usuarios', 'perfiles', 'centrosFamiliares'));
	}

	/**
	 * Método edita un perfil de usuario
	 * 
	 * @param int $peus_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($peus_id) {
		if (!$this->PerfilUsuario->exists($peus_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->request->data['PerfilUsuario']['perf_id'] == 1) {
				unset($this->request->data['PerfilUsuario']['cefa_id']);
			}
			
			if ($this->PerfilUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('El perfil de usuario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el perfil de usuario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'PerfilUsuario.' . $this->PerfilUsuario->primaryKey => $peus_id
				)
			);
			$this->request->data = $this->PerfilUsuario->find('first', $conditions);
		}

		$usuarios = $this->PerfilUsuario->Usuario->find('list',
			array(
				'order' => 'usua_nombre_completo ASC'
			)
		);

		$perfiles = $this->PerfilUsuario->Perfil->find('list',
			array(
				'order' => 'perf_nombre ASC'
			)
		);

		$centrosFamiliares = $this->PerfilUsuario->CentroFamiliar->find('list',
			array(
				'order' => 'cefa_nombre ASC'
			)
		);

		$this->set(compact('usuarios', 'perfiles', 'centrosFamiliares'));
	}

	/**
	 * Método elimina un perfil de usuario
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $peus_id
	 * @return void
	 */
	public function delete($peus_id = null) {
		$this->PerfilUsuario->id = $peus_id;
		if (!$this->PerfilUsuario->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->PerfilUsuario->delete()) {
			$this->Session->setFlash(__('El perfil de usuario ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el perfil de usuario. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}
}