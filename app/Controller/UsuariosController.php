<?php
App::uses('CakeTime', 'Utility');

class UsuariosController extends AppController {
	
	/**
	 * Método lista todos los usuarios del sistema
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function index() {
		if (!empty($this->request->query['t'])) {
			$t = strtolower($this->request->query['t']);
			$this->paginate = array(
				'conditions' => array(
					'LOWER(usua_nombre || \' \' || usua_apellidos) LIKE \'%'. $t .'%\''
				)
			);
		}
		$this->set('usuarios', $this->Paginator->paginate());
	}

	/**
	 * Método agrega un nuevo usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Usuario->create();
			$this->request->data['Usuario']['usua_password'] = AuthComponent::password($this->request->data['Usuario']['usua_password']);

			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash(__('El usuario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el usuario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		}
	}

	/**
	 * Método edita un usuario
	 * 
	 * @param int $usua_id
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @return void
	 */
	public function edit($usua_id) {
		if (!$this->Usuario->exists($usua_id)) {
			throw new NotFoundException(__('Id inválido.'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Usuario']['usua_password'] = AuthComponent::password($this->request->data['Usuario']['usua_password']);

			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash(__('El usuario ha sido guardado.'), 'success_alert');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('No se pudo guardar el usuario. Por favor inténtelo nuevamente.'), 'error_alert');
			}
		} else {
			$conditions = array(
				'conditions' => array(
					'Usuario.' . $this->Usuario->primaryKey => $usua_id
				)
			);
			$this->request->data = $this->Usuario->find('first', $conditions);
			$this->request->data['Usuario']['usua_fecha_caducidad'] =  CakeTime::format($this->request->data['Usuario']['usua_fecha_caducidad'], '%d-%m-%Y');
			$this->request->data['Usuario']['usua_password'] = null;
		}
	}

	/**
	 * Método elimina a un usuario
	 *
	 * @author maraya-gómez
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($usua_id = null) {
		$this->Usuario->id = $usua_id;
		if (!$this->Usuario->exists()) {
			throw new NotFoundException(__('Id Inválido.'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->Usuario->delete()) {
			$this->Session->setFlash(__('El usuario ha sido eliminado.'), 'success_alert');
		} else {
			$this->Session->setFlash(__('No se pudo eliminar el usuario. Por favor, inténtelo nuevamente.'), 'error_alert');
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Login de usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function login() {
		
		/*
		#if (!$this->Usuario->exists($usua_id)) {
		if (!$this->Usuario->exists(127)) {
		      throw new NotFoundException(__('Id inválido.'));
		}

		$user = $this->Usuario->find('first',
	      array(
				'conditions' => array(
					'Usuario.usua_id' => 127
				)
	      )
		);

		echo "<pre>";
		var_dump($user);
		echo "</pre>";

		$user['Usuario']['usua_password'] = AuthComponent::password('abcdefgh');

		$this->Usuario->save($user);

		echo "<pre>";
		var_dump($user['Usuario']['usua_password']);
		echo "</pre>";
		die;
		*/






		$this->layout = 'login';

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {


				$perfilUsuario = $this->Usuario->PerfilUsuario->find('all',
					array(
						'contain' => array(
							'Usuario'
							),
							'conditions' => array(
								'PerfilUsuario.usua_id' => $this->Auth->user('usua_id'),
								'PerfilUsuario.perf_id !=' => 6 // NO MONITOR
							)
					)
				);


				/*
				echo "<pre>";
				var_dump($this->Auth->user('usua_activo'));
				echo "</pre>";
				die;
				*/

				// verificamos si está activo
				#if (empty($perfilUsuario[0]['Usuario']['usua_activo'])) {
				if (false) {
					$this->Session->setFlash(__('El usuario se encuentra desactivado. Por favor, contactar al administrador del sistema'), 'error_alert');
					return $this->redirect($this->Auth->logout());
				}

				// verificamos si está caducado
				#if (strtotime($perfilUsuario[0]['Usuario']['usua_fecha_caducidad']) <= time()) {
				if (strtotime($this->Auth->user('usua_fecha_caducidad')) <= time()) {
					$this->Session->setFlash(__('El usuario se encuentra caducado. Por favor, contactar al administrador del sistema'), 'error_alert');
					return $this->redirect($this->Auth->logout());
				}

				if (sizeof($perfilUsuario) == 0) {
					$this->Session->setFlash(__('El usuario no tiene aún ningún perfil asociado. Por favor, contactar al administrador del sistema'), 'error_alert');
					return $this->redirect($this->Auth->logout());

				} else { /*if (sizeof($perfilUsuario) == 1)*/
					// cargamos algunas vars
					$perfilUsuario = array_pop($perfilUsuario);
					$this->Session->write('Auth.User.PerfilUsuario.peus_id', $perfilUsuario['PerfilUsuario']['peus_id']);
					$this->Session->write('Auth.User.PerfilUsuario.perf_id', $perfilUsuario['PerfilUsuario']['perf_id']);
					$this->Session->write('Auth.User.PerfilUsuario.cefa_id', $perfilUsuario['PerfilUsuario']['cefa_id']);

					return $this->redirect(array('action' => 'main'));
				} /*else {
					return $this->redirect(array('action' => 'seleccion_perfil'));
				}*/
			} else {
				$this->Session->setFlash(__('Usuario y/o contraseña incorrecta.'), 'error_alert');
			}
		}
	}

	/**
	 * Pantalla de selección de perfil
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function seleccion_perfil() {
		$this->layout = 'login';

		if ($this->request->is('post')) {
			$peus_id = $this->request->data['PerfilUsuario']['peus_id'];

			$perfilUsuario = $this->Usuario->PerfilUsuario->find('first',
				array(
					'conditions' => array(
						'PerfilUsuario.peus_id' => $peus_id
					)
				)
			);

			$this->Session->write('Auth.User.PerfilUsuario.peus_id', $peus_id);
			$this->Session->write('Auth.User.PerfilUsuario.perf_id', $perfilUsuario['PerfilUsuario']['perf_id']);
			$this->Session->write('Auth.User.PerfilUsuario.cefa_id', $perfilUsuario['PerfilUsuario']['cefa_id']);
			return $this->redirect(array('action' => 'main'));
		}

		$perfiles = $this->Usuario->PerfilUsuario->find('list',
			array(
				'fields' => array(
					'PerfilUsuario.peus_id',
					'centros.cefa_nombre',
					'Perfil.perf_nombre'
					
				),
				'contain' => array(
					'Perfil'
				),
				'conditions' => array(
					'PerfilUsuario.usua_id' => $this->Auth->user('usua_id'),
					'PerfilUsuario.perf_id !=' => 6 // NO MONITOR
				),
				'order' => array(
					'Perfil.perf_nombre' => 'ASC'
				),
				'joins' => array(
							    array('table' => 'centros_familiares',
							        'alias' => 'centros',
							        'type' => 'LEFT',
							        'conditions' => array(
							        'centros.cefa_id = PerfilUsuario.cefa_id',
							        )
							    )
							)
			)
		);	
		if(!is_null($perfiles['Administrador'])){
			foreach ($perfiles['Administrador'] as $key => $value) {
				$perfiles[$key] = 'Administrador';
				unset($perfiles['Administrador']);	
			}
		};
		$this->set(compact('perfiles'));
	}

	/**
	 * Logout de usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function logout() {
		$this->autoRender = false;
		return $this->redirect($this->Auth->logout());
	}
	
	/**
	 * Encuentra usuarios por perfil
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_usuarios_by_perfil() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$perf_id = $this->request->query['perf_id'];

			$usuarios = $this->Usuario->PerfilUsuario->find('all',
				array(
					'contain' => array(
						'Usuario'
					),
					'conditions' => array(
						'PerfilUsuario.perf_id' => $perf_id
					)
				)
			);

			return json_encode($usuarios);
		}
	}

	/**
	 * Main de usuario
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function main() {
		$peus_id = $this->Auth->user('PerfilUsuario.peus_id');

		$persona = $this->Usuario->PerfilUsuario->find('first',
			array(
				'contain' => array(
					'Usuario',
					'Perfil',
					'CentroFamiliar'
				),
				'conditions' => array(
					'PerfilUsuario.peus_id' => $peus_id
				)
			)
		);



		$perfiles = $this->Usuario->PerfilUsuario->find('list',
			array(
				'fields' => array(
					'PerfilUsuario.peus_id',
					'centros.cefa_nombre',
					'Perfil.perf_nombre'
					
				),
				'contain' => array(
					'Perfil'
				),
				'conditions' => array(
					'PerfilUsuario.usua_id' => $this->Auth->user('usua_id'),
					'PerfilUsuario.perf_id !=' => 6 // NO MONITOR
				),
				'order' => array(
					'Perfil.perf_nombre' => 'ASC'
				),
				'joins' => array(
							    array('table' => 'centros_familiares',
							        'alias' => 'centros',
							        'type' => 'LEFT',
							        'conditions' => array(
							        'centros.cefa_id = PerfilUsuario.cefa_id',
							        )
							    )
							)
			)
		);	
		if(!is_null($perfiles['Administrador'])){
			foreach ($perfiles['Administrador'] as $key => $value) {
				$perfiles[$key] = 'Administrador';
				unset($perfiles['Administrador']);	
			}
		};
		$this->Session->write('perfiles', $perfiles);
		$this->Session->write('title', $persona['Perfil']['perf_nombre']."-".$persona['CentroFamiliar']['cefa_nombre']);

		$this->set(compact('persona'));
	}
}