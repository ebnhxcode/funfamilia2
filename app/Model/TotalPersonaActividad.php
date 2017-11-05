<?php
App::uses('AppModel', 'Model');
/**
 * TotalPersonaActividad Model
 *
 */
class TotalPersonaActividad extends AppModel {
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
	public $useTable = 'v_total_personas_actividades';
}
