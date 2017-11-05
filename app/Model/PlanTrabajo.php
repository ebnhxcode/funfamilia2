<?php
App::uses('AppModel', 'Model');
/**
 * PlanTrabajo Model
 *
 */
class PlanTrabajo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pltr_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'planes_trabajos';

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
		'DetallePlanTrabajo' => array(
			'className' => 'DetallePlanTrabajo',
			'foreignKey' => 'pltr_id',
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
		'plan_trabajo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'El plan de trabajo no puede ser vacío',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);
}