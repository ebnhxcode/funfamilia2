<?php
App::uses('AppModel', 'Model');
/**
 * Programa Model
 *
 */
class Programa extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'prog_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'programas';

	/**
	 * Virtualfields
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'prog_nombre_ano' => 'prog_nombre || \' (\' || prog_ano || \')\''
	);

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'prog_nombre_ano';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'prog_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del programa',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'prog_ano' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el año del programa',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Debe programa debe ser numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
