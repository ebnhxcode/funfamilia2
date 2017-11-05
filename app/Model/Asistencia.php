<?php
App::uses('AppModel', 'Model');
/**
 * Asistencia Model
 *
 */
class Asistencia extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'asis_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'asistencias';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Sesion' => array(
			'className' => 'Sesion',
			'foreignKey' => 'sesi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PersonaCentroFamiliar' => array(
			'className' => 'PersonaCentroFamiliar',
			'foreignKey' => 'pecf_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
