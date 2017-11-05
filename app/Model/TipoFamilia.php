<?php
App::uses('AppModel', 'Model');
/**
 * TipoFamilia Model
 *
 */
class TipoFamilia extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'tifa_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'tipos_familias';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'tifa_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'tifa_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del tipo de familia',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
