<?php
App::uses('AppModel', 'Model');
/**
 * Evaluacion Model
 *
 */
class Evaluacion extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'eval_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'evaluaciones';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'PersonaCentroFamiliar' => array(
			'className' => 'PersonaCentroFamiliar',
			'foreignKey' => 'pecf_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TipoEvaluacion' => array(
			'className' => 'TipoEvaluacion',
			'foreignKey' => 'tiev_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GrupoObjetivo' => array(
			'className' => 'GrupoObjetivo',
			'foreignKey' => 'grob_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Reglas hasMany
	 *
	 * @var array
	 */
	public $hasMany = array(
		'EvaluacionFactorProtector' => array(
			'className' => 'EvaluacionFactorProtector',
			'foreignKey' => 'eval_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EvaluacionFactorRiesgo' => array(
			'className' => 'EvaluacionFactorRiesgo',
			'foreignKey' => 'eval_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'tiev_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el tipo de evaluación',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'eval_fecha' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la fecha de la evaluación',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'eval_observacion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la observación de la evaluación',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}