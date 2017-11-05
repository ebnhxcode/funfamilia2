<?php
App::uses('AppModel', 'Model');
/**
 * AsistenciaSesion Model
 *
 */
class AsistenciaSesion extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'sesi_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'v_asistencias_sesiones';
}