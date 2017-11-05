<?php
App::uses('AppModel', 'Model');
/**
 * GrupoObjetivo Model
 *
 */
class GrupoObjetivo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'grob_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'grupos_objetivos';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'grob_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'grob_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del grupo objetivo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
