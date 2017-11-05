<?php
App::uses('AppModel', 'Model');
/**
 * TipoEvaluacion Model
 *
 */
class TipoEvaluacion extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'tiev_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'tipos_evaluaciones';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'tiev_nombre';
}
