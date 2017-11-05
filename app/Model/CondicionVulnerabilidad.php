<?php
App::uses('AppModel', 'Model');
/**
 * CondicionVulnerabilidad Model
 *
 */
class CondicionVulnerabilidad extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'covu_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'condiciones_vulnerabilidades';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'covu_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'covu_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la condición',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'covu_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de la condición',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'covu_indicador' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del indicador',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}