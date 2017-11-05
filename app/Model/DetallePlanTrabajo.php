<?php
App::uses('AppModel', 'Model');
/**
 * DetallePlanTrabajo Model
 *
 */
class DetallePlanTrabajo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'dept_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'detalles_planes_trabajos';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'FactorProtector' => array(
			'className' => 'FactorProtector',
			'foreignKey' => 'fapr_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Actividad' => array(
			'className' => 'Actividad',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PlanTrabajo' => array(
			'className' => 'PlanTrabajo',
			'foreignKey' => 'pltr_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}