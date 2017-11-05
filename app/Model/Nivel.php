<?php
App::uses('AppModel', 'Model');
/**
 * Nivel Model
 *
 */
class Nivel extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'nive_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'niveles';

	/**
	 * Virtualfields
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'nive_nombre_grupo' => 'nive_nombre || \' (\' || (SELECT grob_nombre FROM grupos_objetivos WHERE grob_id = Nivel.grob_id) || \')\''
	);

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'nive_nombre_grupo';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'GrupoObjetivo' => array(
			'className' => 'GrupoObjetivo',
			'foreignKey' => 'grob_id',
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
		'FactorProtector' => array(
			'className' => 'FactorProtector',
			'foreignKey' => 'nive_id',
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
		'nive_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del nivel',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'grob_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el grupo objetivo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
	);
}
