<?php
App::uses('AppModel', 'Model');
/**
 * Usuario Model
 *
 */
class Persona extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pers_id';
	
	/**
	 * Campo Tabla
	 *
	 * @var string
	 */
	public $useTable = 'personas';
	
	/**
	 * Campo virtualField
	 *
	 * @var string
	 */
	public $virtualFields = array(
		'pers_nombre_completo' => 'pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno',
		'pers_run_completo' => 'pers_run || \'-\' || pers_run_dv'
	);
	
	/**
	 * Reglas belongsTo
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Direccion' => array(
			'className' => 'Direccion',
			'foreignKey' => 'dire_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sexo' => array(
			'className' => 'Sexo',
			'foreignKey' => 'sexo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstadoCivil' => array(
			'className' => 'EstadoCivil',
			'foreignKey' => 'esci_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Nacionalidad' => array(
			'className' => 'Nacionalidad',
			'foreignKey' => 'naci_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Comuna' => array(
			'className' => 'Comuna',
			'foreignKey' => 'comu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PuebloOriginario' => array(
			'className' => 'PuebloOriginario',
			'foreignKey' => 'puor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estudio' => array(
			'className' => 'Estudio',
			'foreignKey' => 'estu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InstitucionSalud' => array(
			'className' => 'Institucion',
			'foreignKey' => 'inst_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InstitucionPrevision' => array(
			'className' => 'Institucion',
			'foreignKey' => 'inst_id2',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Familia' => array(
			'className' => 'Familia',
			'foreignKey' => 'fami_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Parentesco' => array(
			'className' => 'Parentesco',
			'foreignKey' => 'pare_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GrupoObjetivo' => array(
			'className' => 'GrupoObjetivo',
			'foreignKey' => 'grob_id',
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
        'PersonaCentroFamiliar' => array(
            'className' => 'PersonaCentroFamiliar',
			'foreignKey' => 'pers_id',
			'conditions' => 'PersonaCentroFamiliar.pecf_habilitada IS TRUE',
			'fields' => '',
			'order' => ''
        )
    );

	/**
	 * Reglas hasAndBelongsToMany
	 *
	 * @var array
	 */
 	public $hasAndBelongsToMany = array(
        'CentroFamiliar' => array(
            'className' => 'CentroFamiliar',
            'with' => 'PersonaCentroFamiliar',
            'joinTable' => 'personas_centros_familiares',
            'foreignKey' => 'pers_id',
			'associationForeignKey' => 'cefa_id',
			'conditions' => 'PersonaCentroFamiliar.pecf_habilitada IS TRUE'
        )
    );

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'pers_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sexo_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el sexo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'grob_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar el grupo objetivo',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'pers_run' => array(
			/*
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el RUN',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			*/
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El run debe ser numérico.',
				'allowEmpty' => true,
				'required' => false
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'El run ya se encuentra registrado.',
				'allowEmpty' => true,
				'required' => false
			),
			'validarRut' => array(
				'rule' => array('validarRut'),
				'message' => 'El RUN ingresado es incorrecto'
			)
		),
		'pers_run_dv' => array(
			/*
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el dígito verificador del RUN',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
			*/
		),
		'pers_nombres' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar los nombres',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'pers_ap_paterno' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar el apellido paterno',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pers_email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Debe ingresar un correo electrónico válido',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'covu_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe seleccionar la condición de vulnerabilidad',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'dire_direccion' => array(
			'checkDireccion' => array(
				'rule' => array('checkDireccion'),
				'message' => 'La direccion ingresada ya se encuentra registrada, por favor, seleccione una de la lista',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'pers_fecha_nacimiento' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Debe ingresar la fecha de nacimiento',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'formato' => array(
				'rule' => '/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/',
				'message' => 'El formato debe ser dd-mm-aaaa',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		)
	);

	/**
	 * Método que valida el rut de forma que el digito verificador sea el resultado de los otros numeros.
	 * 
	 * @param string $cadena
	 * @return boolean
	 */
	public function validarRut() {
		$run = $this->data['Persona']['pers_run'];
		$run = str_replace(".", "", $run);
		$dv = $this->data['Persona']['pers_run_dv'];

		if (strtolower($this->getDv($run, true)) != strtolower($dv)) {
			return false;		
		} else {
			return true;
		}
	}

	/**
	 * Método que genera el digito verificador en un numero dado por rut.
	 * 
	 * @param int $rut
	 * @return string
	 */
	public function getDv($rut) {
		$rut = strrev($rut);
		$aux = 1;
		$s = 0;

		for($i=0;$i<strlen($rut);$i++) {
			$aux++;
			$s += intval($rut[$i])*$aux;
			
			if($aux == 7) {
				$aux=1;
			}
		}	
		
		$digit = 11 - $s%11;
		if($digit == 11) {
			$d = 0;
		} elseif ($digit == 10) {
			$d = "K";
		} else {
			$d = $digit;
		}
		return $d;
	}

	/**
	 * Método que genera el máximo RUN dentro del sistema
	 * (para personas que aun no tengan documento Chileno de identificación)
	 * 
	 * @author maraya-gómez
	 * @return int
	 */
	public function generarMaxRun() {
		$info = $this->find('first',
			array(
				'fields' => array(
					'CASE WHEN MAX(Persona.pers_run) < 70000000 THEN 70000000 ELSE MAX(Persona.pers_run)+1 END AS max'
				)
			)
		);
		
		return $info[0]['max'];
	}

	/**
	 * Método chequea la existencia de una dirección
	 * 
	 * @author maraya-gómez
	 * @return boolean
	 */
	public function checkDireccion() {
		/*
		if (!empty($this->data['Persona']['dire_direccion']) && !empty($this->data['Persona']['comu_id'])) {
			$dire_direccion = str_replace(' ', null, strtolower($this->data['Persona']['dire_direccion']));
			$comu_id = $this->data['Persona']['comu_id'];

			$count = $this->Direccion->find('count',
				array(
					'conditions' => array(
						'REPLACE(LOWER(Direccion.dire_direccion), \' \', \'\') = \''.$dire_direccion.'\'',
					)
				)
			);

			if ($count == 1) {
				return false;
			}
		}
		*/

		return true;
	}
}
