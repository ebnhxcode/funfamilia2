<?php
App::uses('AppModel', 'Model');
/**
 * PersonaActividad Model
 *
 */
class PersonaActividad extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'peac_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'personas_actividades';

	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'PersonaCentroFamiliar' => array(
			'className' => 'PersonaCentroFamiliar',
			'foreignKey' => 'pecf_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Actividad' => array(
			'className' => 'Actividad',
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
		'pecf_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la persona',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'acti_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la actividad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

	/**
	 * Sobrescritura de saveMany
	 * 
	 * @author maraya-gómez
	 * @param array $data
	 * @param boolean $validate
	 * @param array $fieldList
	 * @return boolean
	 */
	public function saveMany($data = null, $options = array()) {
		$acti_id = isset($data['PersonaActividad']['acti_id'])? $data['PersonaActividad']['acti_id']: $data['Actividad']['acti_id'];
		unset($data['PersonaActividad']['acti_id']);
		unset($data['PersonaActividad']['pecf_id']);
		unset($data['PersonaActividad']['pers_run']);
		$data_ = array();

		foreach ($data['PersonaActividad'] as $peac) {
			$data_[] = array(
				'acti_id' => $acti_id,
				'pecf_id' => $peac['pecf_id']
			);
		}
		
		if (empty($data_)) {
			return true;
		}

		return parent::saveMany($data_, $options);
	}

	/**
	 * Alternativa de saveMany
	 * 
	 * @author maraya-gómez
	 * @param array $data
	 * @param boolean $validate
	 * @param array $fieldList
	 * @return boolean
	 */
	public function saveMany2($data = null, $options = array()) {
		return parent::saveMany($data, $options);
	}
}
