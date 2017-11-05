<?php
App::uses('AppModel', 'Model');
/**
 * FactorRiesgo Model
 *
 */
class FactorRiesgo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'fari_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'factores_riesgos';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'fari_descripcion';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'fari_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el factor de riesgo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fari_descripcion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el factor',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
