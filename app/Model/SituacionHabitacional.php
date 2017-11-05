<?php
App::uses('AppModel', 'Model');
/**
 * SituacionHabitacional Model
 *
 */
class SituacionHabitacional extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'siha_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'situaciones_habitacionales';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'siha_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'siha_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de la situación',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}
