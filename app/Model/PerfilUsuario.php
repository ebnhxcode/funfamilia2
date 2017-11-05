<?php
App::uses('AppModel', 'Model');
/**
 * PerfilUsuario Model
 *
 */
class PerfilUsuario extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'peus_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'perfiles_usuarios';
	
	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usua_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Perfil' => array(
			'className' => 'Perfil',
			'foreignKey' => 'perf_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CentroFamiliar' => array(
			'className' => 'CentroFamiliar',
			'foreignKey' => 'cefa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'usua_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'perf_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el perfil',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkUnique' => array(
				'rule' => array('checkUnique'),
				'message' => 'El perfil seleccionado para este usuario ya se encuentra registrado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkPerfil' => array(
				'rule' => array('checkPerfil'),
				'message' => 'El perfil seleccionado debe tener asociado un centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
	
	/**
	 * Método chequea repetidos
	 *
	 * @return boolean
	 */
	public function checkUnique() {
		$peus_id = !empty($this->data['PerfilUsuario']['peus_id'])? $this->data['PerfilUsuario']['peus_id']: null;
		$perf_id = $this->data['PerfilUsuario']['perf_id'];
		$cefa_id = !empty($this->data['PerfilUsuario']['cefa_id'])? $this->data['PerfilUsuario']['cefa_id']: null;
		$usua_id = $this->data['PerfilUsuario']['usua_id'];

		$conditions = array(
			'conditions' => array(
				'PerfilUsuario.perf_id' => $perf_id,
				'PerfilUsuario.cefa_id' => $cefa_id,
				'PerfilUsuario.usua_id' => $usua_id
			)
		);

		if ($peus_id != null) {
			$conditions['conditions']['PerfilUsuario.peus_id !='] = $peus_id;
		}

		$count = $this->find('count', $conditions);
		if ($count > 0) {
			return false;
		}

		return true;
	}

	/**
	 * Método chequea coḿbinación de perfil
	 *
	 * @return boolean
	 */
	public function checkPerfil() {
		$perf_id = $this->data['PerfilUsuario']['perf_id'];
		$cefa_id = $this->data['PerfilUsuario']['cefa_id'];

		if (!in_array($perf_id, array(1, 7, 8, 9)) && empty($cefa_id)) {
			return false;
		}

		return true;
	}
}
