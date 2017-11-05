<?php
App::uses('AppModel', 'Model');
/**
 * Sesion Model
 *
 */
class Sesion extends AppModel {
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
	public $useTable = 'sesiones';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Actividad' => array(
			'className' => 'Actividad',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Reglas hasMany
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Asistencia' => array(
			'className' => 'Asistencia',
			'foreignKey' => 'sesi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Reglas hasOne
	 *
	 * @var array
	 */
	public $hasOne = array(
		'AsistenciaSesion' => array(
			'className' => 'AsistenciaSesion',
			'foreignKey' => 'sesi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'sesi_nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'sesi_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la sesión',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'sesi_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de la sesión',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El nombre de la sesión debe ser numérica',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkNroSesion' => array(
				'rule' => array('checkNroSesion'),
				'message' => 'El número de sesión supera los registrados por la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'sesi_fecha_ejecucion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la fecha de ejecucíón de la sesión',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

	/**
	 * Método retorna maximo número de sesión por actividad
	 *
	 * @author maraya-gómez
	 * @param int $acti_id
	 * @return int
	 */
	public function maxSesion($acti_id) {
		$sql = "SELECT COALESCE(MAX(sesi_nombre::int), 0) + 1 AS max_sesion
				FROM sesiones
				WHERE acti_id = ". $acti_id;
		$res = $this->query($sql);
		return $res[0][0]['max_sesion'];
	}

	/**
	 * Método chequea número de sesiones por actividad
	 *
	 * @author maraya-gómez
	 * @return boolean
	 */
	public function checkNroSesion() {
		$sesi_nombre = $this->data['Sesion']['sesi_nombre'];
		$acti_id = $this->data['Sesion']['acti_id'];

		$infoSesion = $this->Actividad->find('first',
			array(
				'conditions' => array(
					'Actividad.acti_id' => $acti_id
				),
			)
		);

		if ($sesi_nombre > $infoSesion['Actividad']['acti_nro_sesiones']) {
			return false;
		}

		return true;
	}

	/**
	 * Método chequea si se cumplieron el total de las sesiones por actividad
	 *
	 * @author maraya-gómez
	 * @return boolean
	 */
	public function checkTotalSesiones($acti_id, $sesi_nombre) {
		$acti = $this->Actividad->find('first',
			array(
				'fields' => array(
					'Actividad.acti_nro_sesiones'
				),
				'conditions' => array(
					'Actividad.acti_id' => $acti_id
				)
			)
		);

		if ($acti['Actividad']['acti_nro_sesiones'] == (int) $sesi_nombre) {
			return true;
		}

		return false;
	}
}
