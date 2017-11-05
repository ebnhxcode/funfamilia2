<?php
App::uses('AppModel', 'Model');
/**
 * EstadoActividad Model
 *
 */
class EstadoActividad extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'esac_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'estados_actividades';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'esac_nombre';
}
