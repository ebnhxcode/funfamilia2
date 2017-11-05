<?php
App::uses('AppModel', 'Model');
/**
 * EvaluacionFactorProtector Model
 *
 */
class EvaluacionFactorProtector extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'evfp_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'evaluaciones_factores_protectores';

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
		'IndicadorFactorProtector' => array(
			'className' => 'IndicadorFactorProtector',
			'foreignKey' => 'ifpr_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}