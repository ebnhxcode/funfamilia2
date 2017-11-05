<?php
App::uses('AppModel', 'Model');
/**
 * FactorRiesgoFamilia Model
 *
 */
class FactorRiesgoFamilia extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'frfa_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'factores_riesgos_familias';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Familia' => array(
			'className' => 'Familia',
			'foreignKey' => 'fami_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FactorRiesgo' => array(
			'className' => 'FactorRiesgo',
			'foreignKey' => 'fari_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}