<?php
App::uses('AppModel', 'Model');
/**
 * Estudio Model
 *
 */
class Estudio extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'estu_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'estudios';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'estu_nombre';
}
