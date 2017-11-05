<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionFactorRiesgo Model
 *
 */
class EvaluacionFactorRiesgo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'evfr_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'evaluaciones_factores_riesgos';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Evaluacion' => array(
			'className' => 'Evaluacion',
			'foreignKey' => 'eval_id',
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