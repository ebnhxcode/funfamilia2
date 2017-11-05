<?php
App::uses('AppModel', 'Model');
/**
 * TipoInstitucion Model
 *
 */
class TipoInstitucion extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'tiin_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'tipos_instituciones';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'tiin_nombre';


	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'tiin_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre del tipo de institución',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'El tipo de institución ingresado ya existe',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}