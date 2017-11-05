<?php
App::uses('AppModel', 'Model');
/**
 * Parentesco Model
 *
 */
class Parentesco extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pare_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'parentescos';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'pare_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'pare_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del parentesco',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
