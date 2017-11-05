<?php
App::uses('AppModel', 'Model');
/**
 * Prevision Model
 *
 */
class Prevision extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'prev_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'previsiones';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'prev_nombre';
}
