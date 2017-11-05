<?php
App::uses('AppModel', 'Model');
/**
 * Perfil Model
 *
 */
class Perfil extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'perf_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'perfiles';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'perf_nombre';
}
