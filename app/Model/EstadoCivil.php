<?php
App::uses('AppModel', 'Model');
/**
 * EstadoCivil Model
 *
 */
class EstadoCivil extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'esci_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'estados_civiles';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'esci_nombre';
}
