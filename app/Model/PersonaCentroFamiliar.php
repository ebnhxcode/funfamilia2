<?php
App::uses('AppModel', 'Model');
/**
 * PersonaCentroFamiliar Model
 *
 */
class PersonaCentroFamiliar extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pecf_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'personas_centros_familiares';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'CentroFamiliar' => array(
			'className' => 'CentroFamiliar',
			'foreignKey' => 'cefa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'pers_id',
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
			'foreignKey' => 'pecf_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PlanTrabajo' => array(
			'className' => 'PlanTrabajo',
			'foreignKey' => 'pecf_id',
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
		'pers_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'cefa_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar un centro familiar',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

	/**
	 * Metodo revisa si existen personas asociadas a un centro para no eliminarlas
	 * si no, dejarlas deshabilitadas (por cascada a otras tablas)
	 *
	 * @author maraya-gómez
	 * @return boolean
	 */
	public function saveAndUpdate($data) {
		if (empty($data['Persona']['pers_id'])) {
			return false;
		}

		$pers_id = $data['Persona']['pers_id'];

		// revisamos en cuantos centros está la persona
		$pecfInfo = $this->find('all',
			array(
				'conditions' => array(
					'PersonaCentroFamiliar.pers_id' => $pers_id
				)
			)
		);

		// sacamos los centros familiares
		$cefaInfo = array();
		foreach ($pecfInfo as $row) {
			$cefaInfo[] = $row['PersonaCentroFamiliar']['cefa_id'];
		}

		$pecfData = array();
		foreach ($data['PersonaCentroFamiliar']['cefa_id'] as $cefa_id) {
			// si el ingresado por formulario no se encuentra en la lista, significa que es nuevo
			if (!in_array($cefa_id, $cefaInfo)) {	
				$pecfData[] = array(
					'pers_id' => $pers_id,
					'cefa_id' => $cefa_id,
					'pecf_habilitada' => 1
				);
			}

		}

		// guardamos los que son nuevos
		if (!empty($pecfData)) {
			$this->saveMany($pecfData);
		}

		$this->updateAll(
    		array(
    			'PersonaCentroFamiliar.pecf_habilitada' => 0
    		),
    		array(
    			'PersonaCentroFamiliar.pers_id' => $pers_id,
    			'PersonaCentroFamiliar.cefa_id NOT IN ('. implode(',', $data['PersonaCentroFamiliar']['cefa_id']) .')'
    		)
		);

		return true;
	}
}
