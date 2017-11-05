<?php
App::uses('AppModel', 'Model');
/**
 * FactorProtector Model
 *
 */
class FactorProtector extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'fapr_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'factores_protectores';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'fapr_nombre';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Nivel' => array(
			'className' => 'Nivel',
			'foreignKey' => 'nive_id',
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
		'IndicadorFactorProtector' => array(
			'className' => 'IndicadorFactorProtector',
			'foreignKey' => 'fapr_id',
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
		'fapr_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del factor protector',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkUnique' => array(
				'rule' => array('checkUnique'),
				'message' => 'Factor protector ya ingresado para el año seleccionado',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fapr_objetivos' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el objetivo del factor protector',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'nive_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el nivel',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fapr_ano' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el año del factor protector',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El año debe ser numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

	/**
	 * Revisa si está repetido un factor protector
	 *
	 * @author maraya-gómez
	 * @return boolean
	 */
	public function checkUnique() {
		$nive_id = $this->data['FactorProtector']['nive_id'];
		$fapr_ano = $this->data['FactorProtector']['fapr_ano'];
		$fapr_nombre = trim($this->data['FactorProtector']['fapr_nombre']);

		$count = $this->find('count',
			array(
				'conditions' => array(
					'FactorProtector.nive_id' => $nive_id,
					'FactorProtector.fapr_ano' => $fapr_ano,
					'FactorProtector.fapr_nombre' => $fapr_nombre
				)
			)
		);

		if ($count == 1) {
			return false;
		}

		return true;
	}
}
