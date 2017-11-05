<?php
App::uses('AppModel', 'Model');
/**
 * Nacionalidad Model
 *
 */
class Nacionalidad extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'naci_id';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'naci_nombre';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'nacionalidades';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey' => 'pais_id',
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
		'pais_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el pais',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'naci_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de la nacionalidad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
