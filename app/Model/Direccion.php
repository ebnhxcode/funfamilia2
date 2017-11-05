<?php
App::uses('AppModel', 'Model');
/**
 * Direccion Model
 *
 */
class Direccion extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'dire_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'direcciones';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'dire_direccion';
}
