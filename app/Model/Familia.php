<?php
App::uses('AppModel', 'Model');
/**
 * Familia Model
 *
 */
class Familia extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'fami_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'familias';

	/**
	 * VirtualFields
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'fami_nombre_completo' => 'fami_ap_paterno || \' \' || fami_ap_materno',
		'fami_direccion_completa' => 'fami_direccion_calle || \' \' || fami_direccion_nro || (CASE WHEN fami_direccion_depto = \'\' THEN \'\' ELSE \' - Depto. \' || fami_direccion_depto || (CASE WHEN fami_direccion_block = \'\' THEN \'\' ELSE \'/Block \' || fami_direccion_block END) END)'
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
		'TipoFamilia' => array(
			'className' => 'TipoFamilia',
			'foreignKey' => 'tifa_id',
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
		),
		'Red' => array(
			'className' => 'Red',
			'foreignKey' => 'rede_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SituacionHabitacional' => array(
			'className' => 'SituacionHabitacional',
			'foreignKey' => 'siha_id',
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
		)
	);

	/**
	 * Reglas hasMany
	 *
	 * @var array
	 */
	public $hasMany = array(
		'IntegranteFamiliar' => array(
			'className' => 'Persona',
			'foreignKey' => 'fami_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CondicionVulnerabilidadFamilia' => array(
			'className' => 'CondicionVulnerabilidadFamilia',
			'foreignKey' => 'fami_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FactorRiesgoFamilia' => array(
			'className' => 'FactorRiesgoFamilia',
			'foreignKey' => 'fami_id',
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
		'fami_ap_paterno' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el apellido paterno de la familia',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fami_ap_materno' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el apellido materno de la familia',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'comu_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la comuna',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'tifa_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el tipo de familia',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fami_direccion_calle' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la calle en donde vive la familia',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'checkUniqueFamilia' => array(
				'rule' => array('checkUniqueFamilia'),
				'message' => 'Dirección ya registrada, indique por favor situacion habitacional y llene campo "Otras Observaciones"'
			)
		),
		'fami_direccion_nro' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el número de la dirección',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'fami_es_allegada' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe indicar si la familia es allegada o no',
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
		)
	);

	/**
	 * Método chequea que no exista una familia repetida
	 * combinación: comuna, calle, nro, depto, block, allegada, otras obs
	 *
	 * @author maraya-gómez
	 * @return boolean
	 */ 
	public function checkUniqueFamilia() {
		$comu_id = $this->data['Familia']['comu_id'];
		$fami_direccion_calle = str_replace(' ', null, strtolower($this->data['Familia']['fami_direccion_calle']));
		$fami_direccion_nro = str_replace(' ', null, strtolower($this->data['Familia']['fami_direccion_nro']));
		$fami_direccion_depto = str_replace(' ', null, strtolower($this->data['Familia']['fami_direccion_depto']));
		$fami_direccion_block = str_replace(' ', null, strtolower($this->data['Familia']['fami_direccion_block']));
		$siha_id = $this->data['Familia']['siha_id'];
		$fami_otras_observaciones = $this->data['Familia']['fami_otras_observaciones'];

		$conditions = array(
			'conditions' => array(
				'Familia.comu_id' => $comu_id,
				'REPLACE(LOWER(Familia.fami_direccion_calle), \' \', \'\') = \''.$fami_direccion_calle.'\'',
				'REPLACE(LOWER(Familia.fami_direccion_nro), \' \', \'\') = \''.$fami_direccion_nro.'\'',
				'REPLACE(LOWER(Familia.fami_direccion_depto), \' \', \'\') = \''.$fami_direccion_depto.'\'',
				'REPLACE(LOWER(Familia.fami_direccion_block), \' \', \'\') = \''.$fami_direccion_block.'\'',
				'Familia.siha_id' => $siha_id,
				'Familia.fami_otras_observaciones' => $fami_otras_observaciones
			)
		);

		if (!empty($this->data['Familia']['fami_id'])) {
			$conditions['conditions']['Familia.fami_id != '] = $this->data['Familia']['fami_id'];
		}

		$count = $this->find('count', $conditions);

		if ($count > 0) {
			return false;
		}

		return true;
	}

	/**
	 * Método retorna información de los participantes de actividades
	 * por familia
	 *
	 * @author maraya-gómez
	 * @param int $fami_id
	 * @param int $anyo
	 * @return array
	 */ 
	public function buscaIntegrantesParticipantes($fami_id, $anyo) {
		$sql = "SELECT Persona.pers_run
					  ,Persona.pers_run_dv
					  ,Persona.pers_nombres
					  ,Persona.pers_ap_paterno
					  ,Persona.pers_ap_materno
					  ,Actividad.acti_nombre
					  ,CentroFamiliar.cefa_nombre
				FROM familias AS Familia
				JOIN personas AS Persona ON (Familia.fami_id = Persona.fami_id)
				JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN asistencias AS Asistencia ON (Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id)
				JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
				JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				WHERE f_participa_en_actividad_del_anyo(Persona.pers_id, ". $anyo .") IS TRUE
				AND Familia.fami_id = ". htmlentities($fami_id) ."
				GROUP BY Persona.pers_run
					  	,Persona.pers_run_dv
					  	,Persona.pers_nombres
					  	,Persona.pers_ap_paterno
					  	,Persona.pers_ap_materno
					  	,Actividad.acti_nombre
					  	,CentroFamiliar.cefa_nombre
				ORDER BY Persona.pers_ap_paterno
						,Persona.pers_ap_materno
						,Persona.pers_nombres
						,Actividad.acti_nombre
						,CentroFamiliar.cefa_nombre";
		$res = $this->query($sql);
		return $res;
	}
}
