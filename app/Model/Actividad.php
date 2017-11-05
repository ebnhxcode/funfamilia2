<?php

App::uses('AppModel', 'Model');
/**
 * Actividad Model
 *
 */
class Actividad extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'acti_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'actividades';

	/**
	 * Displayfield
	 *
	 * @var string
	 */
	public $displayField = 'acti_nombre';

	/**
	 * Campo virtualField
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'acti_anio' => 'DATE_PART(\'YEAR\', Actividad.acti_fecha_inicio)'
	);

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Comuna' => array(
			'className' => 'Comuna',
			'foreignKey' => 'comu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TipoActividad' => array(
			'className' => 'TipoActividad',
			'foreignKey' => 'tiac_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstadoActividad' => array(
			'className' => 'EstadoActividad',
			'foreignKey' => 'esac_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CentroFamiliar' => array(
			'className' => 'CentroFamiliar',
			'foreignKey' => 'cefa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Institucion' => array(
			'className' => 'Institucion',
			'foreignKey' => 'inst_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usua_id',
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
		'GastoActividad' => array(
			'className' => 'GastoActividad',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PersonaActividad' => array(
			'className' => 'PersonaActividad',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DetallePlanTrabajo' => array(
			'className' => 'DetallePlanTrabajo',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sesion' => array(
			'className' => 'Sesion',
			'foreignKey' => 'acti_id',
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
		'TotalPersonaActividad' => array(
			'className' => 'TotalPersonaActividad',
			'foreignKey' => 'acti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'tiac_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el tipo de actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'esac_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el estado de la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_nombre' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el nombre de la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_descripcion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la descripcion de la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_poblacion' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la población',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_nro_sesiones' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el número de sesiones',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'La número de sesiones debe ser numérico',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_andiv_masivo' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe indicar si la actividad es individual o masiva',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_fecha_inicio' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la fecha de inicio de la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_fecha_termino' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la fecha de término de la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_hora' => array(
			'regexp' => array(
				'rule' => '/^[0-9]{2}\:[0-9]{2}$/',
				'message' => 'Formato de hora incorrecta',
				'allowEmpty' => true,
				'required' => false
			)
		)
	);
}
