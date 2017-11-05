<?php
App::uses('AppModel', 'Model');
/**
 * Usuario Model
 *
 */
class Usuario extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'usua_id';
	
/**
 * Campo Tabla
 *
 * @var string
 */
	public $useTable = 'usuarios';
	
	/**
	 * Campo virtualField
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'usua_nombre_completo' => 'usua_nombre || \' \' || usua_apellidos',
		'usua_nombre_completo_usuario' => 'usua_nombre || \' \' || usua_apellidos || \' (\' || usua_username || \')\''
	);
	
	/**
	 * Campo displayField
	 *
	 * @var string
	 */
	public $displayField = 'usua_nombre_completo_usuario';
	
	/**
	 * Reglas hasMany
	 *
	 * @var array
	 */
	public $hasMany = array(
		'PerfilUsuario' => array(
			'className' => 'PerfilUsuario',
			'foreignKey' => 'usua_id',
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
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usua_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'usua_apellidos' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar los apellidos',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'usua_username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de usuario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'El run ya se encuentra registrado.',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'usua_password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la contraseña',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'usua_activo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el check',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usua_fecha_caducidad' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la fecha',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usua_email' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar un correo electrónico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Debe ingresar un correo electrónico válido',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);
	
	/**
	 * Metodo checkPassword
	 *
	 * Permite verificar que ambas contraseñas ingresadas sean iguales.
	 * @return void
	 */
	public function checkPassword() {
		$usua_password = $this->data['Usuario']['usua_password'];
		$usua_password2 = $this->data['Usuario']['usua_password_confirmar'];
		
		if ($usua_password == $usua_password2) {
			return true;
		}
		return false;
	}	
}
