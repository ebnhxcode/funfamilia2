<?php

App::uses('AppModel', 'Model');
/**
 * CentroFamiliar Model
 *
 */
class CentroFamiliar extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'cefa_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'centros_familiares';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'cefa_nombre';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Comuna' => array(
			'className' => 'Comuna',
			'foreignKey' => 'comu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Reglas hasMany
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Actividad' => array(
			'className' => 'Actividad',
			'foreignKey' => 'cefa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PersonaCentroFamiliar' => array(
			'className' => 'PersonaCentroFamiliar',
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
		'cefa_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmptyMany'),
				'message' => 'Debe seleccionar el centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_direccion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la dirección del centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'comu_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la comuna',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_email' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el correo electrónico del centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'El correo electrónico ingresado es inválido',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_nro_fijo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el teléfono fijo del centro',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_orden' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar orden del centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El orden debe ser numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
	
	/**
     * Método chequea si existe al menos un cefa_id ingresado cuando son mas de uno los que entran
     *
     * @author maraya-gómez
     * @return boolean
     */
	public function notEmptyMany() {
		$cefa_id = $this->data['CentroFamiliar']['cefa_id'];

		if (is_array($cefa_id)) {
			if (empty($cefa_id)) {
				return false;
			}
			return true;
		} else {

			return !empty($cefa_id);
		}
	}
}
