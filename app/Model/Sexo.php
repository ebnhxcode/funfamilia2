<?php
App::uses('AppModel', 'Model');
/**
 * Sexo Model
 *
 */
class Sexo extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'sexo_id';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'sexo_nombre';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'sexos';
}
