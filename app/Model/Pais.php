<?php
App::uses('AppModel', 'Model');
/**
 * Pais Model
 *
 */
class Pais extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pais_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'paises';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'pais_nombre';
}
