<?php
App::uses('AppModel', 'Model');
/**
 * Comuna Model
 *
 */
class Comuna extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'comu_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'comunas';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'comu_nombre';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'regi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
