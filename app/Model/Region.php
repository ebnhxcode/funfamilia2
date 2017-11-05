<?php
App::uses('AppModel', 'Model');
/**
 * Region Model
 *
 */
class Region extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'regi_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'regiones';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'regi_nombre';
}
