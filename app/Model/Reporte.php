<?php
App::uses('AppModel', 'Model');
/**
 * Reporte Model
 *
 */
class Reporte extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var boolean
	 */
	public $useTable = false;

	/**
	 * Retorna datos de reporte de cobertura
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @param int $cefa_id
	 * @param int $regi_id
	 * @param int $comu_id
	 * @param int $grob_id
	 * @param int $tipo_cobertura
	 * @param int $acti_id
	 * @param int $mes
	 * @return array
	 */
	public function coberturaPersonas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}

		$filtroGrob = null;
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(' AND GrupoObjetivo.grob_id = %d ', $grob_id);
		}

		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND Actividad.acti_individual IS FALSE ': ' AND Actividad.acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND Actividad.acti_id = %d ', $acti_id);
		}

		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', Actividad.acti_fecha_inicio) = %d ', $mes);
		}
		$filtroProg = null;
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
					  	WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
					  	AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
					  	". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_personas
					  ,(SELECT COALESCE(SUM(Actividad.acti_cobertura_estimada), 0)
					  	FROM actividades AS Actividad
					  	NATURAL JOIN tipos_actividades AS tiposActividades
						NATURAL JOIN areas as Area
						NATURAL JOIN programas as Programa
					  	LEFT JOIN comunas AS Comuna ON (Actividad.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	WHERE Actividad.acti_individual IS FALSE
					  	AND Actividad.cefa_id = CentroFamiliar.cefa_id
					  	". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroProg ."
					  	) AS total_cobertura_estimada
					  ,(SELECT COUNT(*) FROM (
					  		SELECT Familia.fami_id
							FROM personas_centros_familiares AS PersonaCentroFamiliar
							JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
							JOIN familias AS Familia ON (Persona.fami_id = Familia.fami_id)
							LEFT JOIN comunas AS Comuna ON (Familia.comu_id = Comuna.comu_id)
					  		LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  		LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
							WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
							AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
							AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
							". $filtroRegi ."
					  		". $filtroComu ."
					  		". $filtroGrob ."
							GROUP BY Familia.fami_id) AS tab
					   ) AS total_familias
					  ,(SELECT COUNT(*)
					  	FROM familias AS Familia
					  	LEFT JOIN comunas AS Comuna ON (Familia.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)					  	
					  	WHERE Familia.cefa_id = CentroFamiliar.cefa_id
					  	AND Familia.fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND Familia.fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_familias2
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 1
						AND Persona.pers_fecha_nacimiento IS NULL
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_hombres_sin_info
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 2
						AND Persona.pers_fecha_nacimiento IS NULL
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_mujeres_sin_info
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 1
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 15
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_hombres_0_15
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 1
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 16
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 24
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_hombres_16_24
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 1
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 25
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 60
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_hombres_25_60
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 1
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 61
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_hombres_61_mas
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 2
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 15
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_mujeres_0_15
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 2
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 16
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 24
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_mujeres_16_24
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 2
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 25
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) <= 60
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_mujeres_25_60
					  ,(SELECT COUNT(*)
						FROM personas_centros_familiares as PersonaCentroFamiliar
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						LEFT JOIN comunas AS Comuna ON (Persona.comu_id = Comuna.comu_id)
					  	LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
					  	LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
						WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Persona.sexo_id = 2
						AND EXTRACT(YEAR from AGE(NOW(), Persona.pers_fecha_nacimiento)) >= 61
						AND f_participa_en_actividad(PersonaCentroFamiliar.pecf_id, CentroFamiliar.cefa_id, '".$desde." 00:00:00', '".$hasta." 23:59:59') IS TRUE
						". $filtroRegi ."
					  	". $filtroComu ."
					  	". $filtroGrob .") AS total_mujeres_61_mas
				FROM centros_familiares AS CentroFamiliar
				WHERE 1 = 1
				". $filtroCefa ."
				ORDER BY CentroFamiliar.cefa_orden ASC";

		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de actividades
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function actividades($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		// sacamos los tipos de actividades
		$tiposActividades = ClassRegistry::init('TipoActividad')->find('all',
			array(
				'order' => array(
					'TipoActividad.tiac_orden ASC'
				)
			)
		);

		// sacamos los tipos de actividades
		$areas = ClassRegistry::init('Area')->find('all',
			array(
				'order' => array(
					'Area.area_orden ASC'
				)
			)
		);

		// filtros especiales (en subquerys)
		$filtroTipoCobertura = null;
		if (!empty($tipo_cobertura)) {
			$filtroTipoCobertura = ($tipo_cobertura == 1)? "AND Actividad.acti_individual IS FALSE\n": "AND Actividad.acti_individual IS TRUE\n";
		}
		
		$filtroActiId = null;
		if (!empty($acti_id)) {
			$filtroActiId = "AND Actividad.acti_id = ". $acti_id . "\n";
		}
		
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes .= "AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = ". $mes . "\n";
		}
		$filtroProgId = null;
		if (!empty($prog_id)) {
			$filtroProgId = "AND p.prog_id = ". $prog_id . "\n";
		}
		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
					  	FROM actividades AS Actividad
					  	INNER JOIN tipos_actividades ta 
					  	ON Actividad.tiac_id = ta.tiac_id
					  	INNER JOIN areas a 
					  	ON ta.area_id = a.area_id
					  	INNER JOIN programas p
					  	ON p.prog_id = a.prog_id
					  	WHERE Actividad.cefa_id = CentroFamiliar.cefa_id
					  	AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
					  	AND Actividad.acti_fecha_inicio >= '".$desde."'
					  	AND Actividad.acti_fecha_inicio <= '".$hasta."'
					  	". $filtroTipoCobertura ."
					  	". $filtroActiId ."
					  	". $filtroMes ."
					  	". $filtroProgId."
					  	) AS total_actividades\n";
			
		// fields de tipos de actividades
		foreach ($tiposActividades as $tiac) {
			$tiac_id = $tiac['TipoActividad']['tiac_id'];
			$tiac_nombre = preg_replace('/(\s|\:|\-|\,|\/|\+)+/', '_', $tiac['TipoActividad']['tiac_nombre']);
			$sql .= sprintf(",COALESCE(tiac_tab_%d.total, 0) AS tiac_%s\n", $tiac_id, $tiac_nombre);
		}

		// fields de areas
		foreach ($areas as $area) {
			$area_id = $area['Area']['area_id'];
			$area_nombre = preg_replace('/(\s|\:|\-|\,|\/|\+)+/', '_', $area['Area']['area_nombre']);
			$sql .= sprintf(",COALESCE(area_tab_%d.total, 0) AS area_%s\n", $area_id, $area_nombre);
		}
	
		$sql .= "FROM centros_familiares AS CentroFamiliar\n";
		
		// left joins de tipos de actividad
		foreach ($tiposActividades as $tiac) {
			$tiac_id = $tiac['TipoActividad']['tiac_id'];
			$sql .= sprintf("LEFT JOIN (
								SELECT COUNT(*) AS total,
									   Actividad.cefa_id
								FROM actividades AS Actividad
								WHERE Actividad.tiac_id = %d
								AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7) 
								AND Actividad.acti_fecha_inicio >= '%s'
								AND Actividad.acti_fecha_inicio <= '%s'
								". $filtroTipoCobertura ."
					  			". $filtroActiId ."
					  			". $filtroMes ."
								GROUP BY Actividad.cefa_id
							) AS tiac_tab_%d ON (tiac_tab_%d.cefa_id = CentroFamiliar.cefa_id)\n", $tiac_id, $desde, $hasta, $tiac_id, $tiac_id);
		}

		// left joins de areas
		foreach ($areas as $area) {
			$area_id = $area['Area']['area_id'];
			$sql .= sprintf("LEFT JOIN (
								SELECT COUNT(*) AS total,
									   Actividad.cefa_id
								FROM actividades AS Actividad
								NATURAL JOIN tipos_actividades AS TipoActividad
								WHERE TipoActividad.area_id = %d
								AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
								AND Actividad.acti_fecha_inicio >= '%s'
								AND Actividad.acti_fecha_inicio <= '%s'
								". $filtroTipoCobertura ."
					  			". $filtroActiId ."
					  			". $filtroMes ."
								GROUP BY Actividad.cefa_id
							) AS area_tab_%d ON (area_tab_%d.cefa_id = CentroFamiliar.cefa_id)\n", $area_id, $desde, $hasta, $area_id, $area_id);
		}
		
		// filtros
		$sql .= "LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				 LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				 WHERE 1 = 1\n";
		
		if (!empty($cefa_id)) {
			$sql .= "AND CentroFamiliar.cefa_id = ". $cefa_id ."\n";
		}
		
		if (!empty($regi_id)) {
			$sql .= "AND Region.regi_id = ". $regi_id ."\n";
		}
		
		if (!empty($comu_id)) {
			$sql .= "AND Comuna.comu_id = ". $comu_id ."\n";
		}
		
		$sql .= "ORDER BY CentroFamiliar.cefa_orden ASC";

		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de coberturas de personas por area y tipo de actividad
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
		public function coberturasPersonasAreasTiposActividad($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		// sacamos los tipos de actividades
		$tiposActividades = ClassRegistry::init('TipoActividad')->find('all',
			array(
				'order' => array(
					'TipoActividad.tiac_orden ASC'
				)
			)
		);

		// sacamos los tipos de actividades
		$areas = ClassRegistry::init('Area')->find('all',
			array(
				'order' => array(
					'Area.area_orden ASC'
				)
			)
		);

		// filtros especiales (en subquerys)
		$filtroTipoCobertura = null;
		if (!empty($tipo_cobertura)) {
			$filtroTipoCobertura = ($tipo_cobertura == 1)? "AND Actividad.acti_individual IS FALSE\n": "AND Actividad.acti_individual IS TRUE\n";
		}
		
		$filtroActiId = null;
		if (!empty($acti_id)) {
			$filtroActiId = "AND Actividad.acti_id = ". $acti_id . "\n";
		}
		
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes .= "AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = ". $mes . "\n";
		}
		$filtroProgId = null;
		if (!empty($prog_id)) {
			$filtroProgId = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		$sql = "SELECT CentroFamiliar.cefa_nombre\n";

		// fields de tipos de actividades
		foreach ($tiposActividades as $tiac) {
			$tiac_id = $tiac['TipoActividad']['tiac_id'];
			$tiac_nombre = preg_replace('/(\s|\:|\-|\,|\/|\+)+/', '_', $tiac['TipoActividad']['tiac_nombre']);
			$sql .= sprintf(",COALESCE(tiac_tab_%d.total, 0) AS tiac_%s\n", $tiac_id, $tiac_nombre);
		}

		// fields de areas
		foreach ($areas as $area) {
			$area_id = $area['Area']['area_id'];
			$area_nombre = preg_replace('/(\s|\:|\-|\,|\/|\+)+/', '_', $area['Area']['area_nombre']);
			$sql .= sprintf(",COALESCE(area_tab_%d.total, 0) AS area_%s\n", $area_id, $area_nombre);
		}

		$sql .= "FROM centros_familiares AS CentroFamiliar\n";

		// left joins de tipos de actividad
		foreach ($tiposActividades as $tiac) {
			$tiac_id = $tiac['TipoActividad']['tiac_id'];

			$sql .= sprintf("LEFT JOIN
								(SELECT COUNT(*) AS total
									   ,tab.cefa_id FROM (
											SELECT DISTINCT Asistencia.pecf_id
      											  ,Actividad.cefa_id 
											FROM asistencias AS Asistencia
											JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
											JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
											NATURAL JOIN tipos_actividades AS tiposActividades
											NATURAL JOIN areas as Area
											NATURAL JOIN programas as Programa
											JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
											JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
											WHERE Actividad.tiac_id = %d
											AND Asistencia.asis_fecha >= '%s 00:00:00'
											AND Asistencia.asis_fecha <= '%s 23:59:59'
											AND Actividad.esac_id = 2
											". $filtroTipoCobertura ."
											". $filtroActiId ."
											". $filtroProgId ."
											". $filtroMes ."
										) AS tab
										GROUP BY tab.cefa_id
								) AS tiac_tab_%d ON (tiac_tab_%d.cefa_id = CentroFamiliar.cefa_id)\n", $tiac_id, $desde, $hasta, $tiac_id, $tiac_id);
		}

		// left joins de areas
		foreach ($areas as $area) {
			$area_id = $area['Area']['area_id'];
			$sql .= sprintf("LEFT JOIN
								(SELECT COUNT(*) AS total
									   ,tab.cefa_id FROM (
											SELECT DISTINCT Asistencia.pecf_id
      											  ,Actividad.cefa_id 
											FROM asistencias AS Asistencia
											JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
											JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
											JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
											JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
											JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
											NATURAL JOIN areas as Area
											NATURAL JOIN programas as Programa

											WHERE TipoActividad.area_id = %d
											AND Asistencia.asis_fecha >= '%s 00:00:00'
											AND Asistencia.asis_fecha <= '%s 23:59:59'
											AND Actividad.esac_id = 2
											". $filtroTipoCobertura ."
											". $filtroActiId ."
											". $filtroProgId ."
											". $filtroMes ."
										) AS tab
										GROUP BY tab.cefa_id
								) AS area_tab_%d ON (area_tab_%d.cefa_id = CentroFamiliar.cefa_id)\n", $area_id, $desde, $hasta, $area_id, $area_id);
		}

		// filtros
		$sql .= "LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				 LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				 WHERE 1 = 1\n";

		if (!empty($cefa_id)) {
			$sql .= "AND CentroFamiliar.cefa_id = ". $cefa_id ."\n";
		}
		
		if (!empty($regi_id)) {
			$sql .= "AND Region.regi_id = ". $regi_id ."\n";
		}
		
		if (!empty($comu_id)) {
			$sql .= "AND Comuna.comu_id = ". $comu_id ."\n";
		}

		$sql .= "ORDER BY CentroFamiliar.cefa_orden ASC";
		$res = $this->query($sql);

		return $res;
	}

	/**
	 * Retorna datos de reporte de actividades individuales y masivas (ex prestaciones I)
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function actividadesIndividualesMasivas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		// filtros especiales (en subquerys)
		$filtroTipoCobertura = null;
		if (!empty($tipo_cobertura)) {
			$filtroTipoCobertura = ($tipo_cobertura == 1)? "AND Actividad.acti_individual IS FALSE\n": "AND Actividad.acti_individual IS TRUE\n";
		}
		
		$filtroActiId = null;
		if (!empty($acti_id)) {
			$filtroActiId = "AND Actividad.acti_id = ". $acti_id . "\n";
		}
		
		$filtroProg = null;
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
		}
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes .= "AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = ". $mes . "\n";
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
					  	FROM actividades AS Actividad
					  	NATURAL JOIN tipos_actividades AS tiposActividades
						NATURAL JOIN areas as Area
						NATURAL JOIN programas as Programa
					  	WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
					  	AND Actividad.acti_individual IS TRUE
					  	AND Actividad.cefa_id = CentroFamiliar.cefa_id
					  	AND Actividad.acti_fecha_inicio >= '".$desde."'
					  	AND Actividad.acti_fecha_inicio <= '".$hasta."'
					  	". $filtroTipoCobertura ."
					  	". $filtroActiId ."
					  	". $filtroProg ."
					  	". $filtroMes .") AS total_individuales
					  ,(SELECT COUNT(*)
					  	FROM actividades AS Actividad
					  	NATURAL JOIN tipos_actividades AS tiposActividades
						NATURAL JOIN areas as Area
						NATURAL JOIN programas as Programa
					  	WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
					  	AND Actividad.acti_individual IS FALSE
					  	AND Actividad.cefa_id = CentroFamiliar.cefa_id
					  	AND Actividad.acti_fecha_inicio >= '".$desde."'
					  	AND Actividad.acti_fecha_inicio <= '".$hasta."'
					  	". $filtroTipoCobertura ."
					  	". $filtroActiId ."
					  	". $filtroProg ."
					  	". $filtroMes .") AS total_masivas
				FROM centros_familiares as CentroFamiliar\n";

		// filtros
		$sql .= "LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				 LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				 WHERE 1 = 1\n";

		if (!empty($cefa_id)) {
			$sql .= "AND CentroFamiliar.cefa_id = ". $cefa_id ."\n";
		}
		
		if (!empty($regi_id)) {
			$sql .= "AND Region.regi_id = ". $regi_id ."\n";
		}
		
		if (!empty($comu_id)) {
			$sql .= "AND Comuna.comu_id = ". $comu_id ."\n";
		}

		$sql .= "ORDER BY CentroFamiliar.cefa_orden ASC";		

		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de prestaciones II
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function prestacionesII($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		$filtroProg ="";
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND p.prog_id = %d ', $prog_id);
		}
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}
		
		$filtroTipoCobertura = "";
		if (!empty($tipo_cobertura)) {			
			$filtroTipoCobertura = ($tipo_cobertura == 1)? " AND Actividad.acti_individual IS FALSE ": " AND Actividad.acti_individual IS TRUE ";
		}
		
		$filtroActi = "";
		if (!empty($acti_id)) {
			$filtroActi = sprintf(" AND Actividad.acti_id = %d ", $acti_id);
		}
		
		$filtroMes = "";
		if (!empty($mes)) {
			$filtroMes = sprintf(" AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = %d ", $mes);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,Familia.fami_ap_paterno
					  ,Familia.fami_ap_materno
					  ,Persona.pers_ap_paterno
					  ,Persona.pers_ap_materno
					  ,Persona.pers_nombres
					  ,Sexo.sexo_nombre
					  ,(SELECT COUNT(*) FROM (
							SELECT PersonaCentroFamiliar2.pecf_id
      							  ,PersonaCentroFamiliar2.cefa_id
      							  ,Actividad.acti_id
      							  ,COUNT(*)
							FROM personas_centros_familiares AS PersonaCentroFamiliar2
							JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar2.pecf_id = Asistencia.pecf_id)
							JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
							JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
							NATURAL JOIN tipos_actividades AS tiposActividades
							NATURAL JOIN areas as Area
							NATURAL JOIN programas as Programa
							JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
							WHERE PersonaCentroFamiliar2.pecf_habilitada IS TRUE
							AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
							AND PersonaCentroFamiliar2.cefa_id = PersonaCentroFamiliar.cefa_id
							AND PersonaCentroFamiliar2.pecf_id = PersonaCentroFamiliar.pecf_id
							AND Actividad.acti_fecha_inicio >= '". $desde ."'
							AND Actividad.acti_fecha_inicio <= '". $hasta ."'
							". $filtroGrob ."
							". $filtroSexo ."
							". $filtroTipoCobertura ."
							". $filtroActi ."
							". $filtroProg ."
							". $filtroMes ."
							GROUP BY Actividad.acti_id
									,PersonaCentroFamiliar2.pecf_id
									,PersonaCentroFamiliar2.cefa_id
							) AS tab	
						WHERE tab.pecf_id = PersonaCentroFamiliar.pecf_id
						AND tab.cefa_id = PersonaCentroFamiliar.cefa_id) AS nro_actividades
					  ,(SELECT COUNT(*)
					  	FROM asistencias AS Asistencia
					  	JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
					  	JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
					  	JOIN personas_centros_familiares AS PersonaCentroFamiliar3 ON (PersonaCentroFamiliar3.pecf_id = Asistencia.pecf_id)
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar3.pers_id = Persona.pers_id)
					  	WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
					  	AND Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id
					  	AND Actividad.cefa_id = CentroFamiliar.cefa_id
					  	AND Actividad.acti_fecha_inicio >= '". $desde ."'
						AND Actividad.acti_fecha_inicio <= '". $hasta ."'
						". $filtroGrob ."
						". $filtroSexo ."
						". $filtroTipoCobertura ."
						". $filtroActi ."
						". $filtroMes .") AS nro_prestaciones
				FROM personas_centros_familiares as PersonaCentroFamiliar
				JOIN centros_familiares as CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN familias AS Familia ON (Persona.fami_id = Familia.fami_id)
				JOIN sexos AS Sexo ON (Persona.sexo_id = Sexo.sexo_id)
				LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroGrob ."
				". $filtroSexo ."
				ORDER BY CentroFamiliar.cefa_orden
						,Persona.pers_ap_paterno
						,Persona.pers_ap_materno
						,Persona.pers_nombres";

		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de participantes I
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function participantesI($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}
		$filtroProg = "";
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		$filtroTipoCobertura = "";
		if (!empty($tipo_cobertura)) {			
			$filtroTipoCobertura = ($tipo_cobertura == 1)? " AND Actividad.acti_individual IS FALSE ": " AND Actividad.acti_individual IS TRUE ";
		}
		
		$filtroActi = "";
		if (!empty($acti_id)) {
			$filtroActi = sprintf(" AND Actividad.acti_id = %d ", $acti_id);
		}
		
		$filtroMes = "";
		if (!empty($mes)) {
			$filtroMes = sprintf(" AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = %d ", $mes);
		}

		// pero mejor se deja como una vista materializada (no mejor no)
		/*
		$sql = "SELECT *
				FROM m_detalle_actividades_x_participantes				
				WHERE pecf_fecha_creacion >= '". $desde ." 00:00:00'
				AND pecf_fecha_creacion <= '". $hasta ." 23:59:59'
				ORDER BY cefa_orden
						,fami_ap_paterno
						,fami_ap_materno";
		*/

		// se agrega información solicitada por Natalia Obilinovic
		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,Persona.pers_run
					  ,Persona.pers_run_dv
					  ,Persona.pers_nombres
					  ,Persona.pers_ap_paterno
					  ,Persona.pers_ap_materno
					  ,Sexo.sexo_nombre
					  ,Familia.fami_ap_paterno
					  ,Familia.fami_ap_materno
					  ,Actividad.acti_nombre
					  ,Sesion.sesi_nombre
					  ,DATE_PART('YEAR', Asistencia.asis_fecha) AS anyo_prestacion
				FROM personas_centros_familiares AS PersonaCentroFamiliar
				JOIN centros_familiares AS CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN familias AS Familia ON (Persona.fami_id = Familia.fami_id)
				JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
				JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
				JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
				NATURAL JOIN tipos_actividades AS tiposActividades
				NATURAL JOIN areas as Area
				NATURAL JOIN programas as Programa
				LEFT JOIN sexos AS Sexo ON (Persona.sexo_id = Sexo.sexo_id)
				LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
				AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
				AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroGrob ."
				". $filtroSexo ."
				". $filtroTipoCobertura ."
				". $filtroActi ."
				". $filtroMes ."
				". $filtroProg ."
				ORDER BY CentroFamiliar.cefa_orden
						,Familia.fami_ap_paterno
						,Familia.fami_ap_materno";

		/*
		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,Persona.pers_run
					  ,Persona.pers_run_dv
					  ,Familia.fami_ap_paterno
					  ,Familia.fami_ap_materno
					  ,Actividad.acti_nombre
				FROM personas_centros_familiares AS PersonaCentroFamiliar
				JOIN centros_familiares AS CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN familias AS Familia ON (Persona.fami_id = Familia.fami_id)
				JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
				JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
				JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
				WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
				AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
				AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
				ORDER BY CentroFamiliar.cefa_orden
						,Familia.fami_ap_paterno
						,Familia.fami_ap_materno";
		*/
		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de participantes II
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function participantesII($desde, $hasta) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
				      ,Area.area_nombre
				      ,TipoActividad.tiac_nombre
				      ,Actividad.acti_nombre
				      ,Persona.pers_nombres
				      ,Persona.pers_ap_paterno
				      ,Persona.pers_ap_materno
				      ,Sexo.sexo_nombre
				      ,(SELECT COUNT(*)
				      	FROM asistencias AS Asistencia2
				      	JOIN sesiones AS Sesion2 ON (Asistencia2.sesi_id = Sesion2.sesi_id)
				      	WHERE Sesion2.acti_id = Actividad.acti_id
				      	AND Asistencia2.pecf_id = PersonaCentroFamiliar.pecf_id
				      	) AS nro_sesiones
				FROM actividades AS Actividad
				JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
				JOIN areas AS Area ON (TipoActividad.area_id = Area.area_id)
				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				JOIN sesiones AS Sesion ON (Actividad.acti_id = Sesion.acti_id)
				JOIN asistencias AS Asistencia ON (Sesion.sesi_id = Asistencia.sesi_id)
				JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN sexos AS Sexo ON (Persona.sexo_id = Sexo.sexo_id)
				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
				AND Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'
				GROUP BY Persona.pers_nombres
						,Persona.pers_ap_paterno
						,Persona.pers_ap_materno
						,CentroFamiliar.cefa_orden
						,Area.area_orden
						,CentroFamiliar.cefa_nombre
						,Area.area_nombre
						,TipoActividad.tiac_nombre
						,TipoActividad.tiac_orden
						,Actividad.acti_nombre
						,Actividad.acti_id
						,PersonaCentroFamiliar.pecf_id
						,Sexo.sexo_nombre
						,CentroFamiliar.cefa_id
				ORDER BY CentroFamiliar.cefa_orden
				        ,Area.area_orden
				        ,TipoActividad.tiac_orden
				        ,Actividad.acti_nombre ASC";

		// Persona.pers_fecha_nacimiento IS NOT NULL ---> OJO		       
	    // ojo con este filtro AND PersonaCentroFamiliar.pecf_habilitada IS TRUE <-- REVISAR
		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de consulta HH
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function consultaHH($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroTipoCobertura = "";
		if (!empty($tipo_cobertura)) {			
			$filtroTipoCobertura = ($tipo_cobertura == 1)? " AND Actividad.acti_individual IS FALSE ": " AND Actividad.acti_individual IS TRUE ";
		}
		
		$filtroActi = "";
		if (!empty($acti_id)) {
			$filtroActi = sprintf(" AND Actividad.acti_id = %d ", $acti_id);
		}

		$filtroProg = "";
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		
		$filtroMes = "";
		if (!empty($mes)) {
			$filtroMes = sprintf(" AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = %d ", $mes);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
				      ,Area.area_nombre
				      ,TipoActividad.tiac_nombre
				      ,Actividad.acti_nombre
				      ,(Usuario.usua_nombre || ' ' || Usuario.usua_apellidos) AS monitor
				      ,(Actividad.acti_nro_sesiones)*1.5 AS horas_monitor
				FROM actividades AS Actividad
				JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)

				JOIN areas AS Area ON (TipoActividad.area_id = Area.area_id)
				JOIN programas as Programa ON Programa.prog_id = Area.prog_id
				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				LEFT JOIN usuarios AS Usuario ON (Actividad.usua_id = Usuario.usua_id)
				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroTipoCobertura ."
				". $filtroActi ."
				". $filtroProg ."
				". $filtroMes ."
				ORDER BY CentroFamiliar.cefa_orden
				        ,Area.area_orden
				        ,TipoActividad.tiac_orden
				        ,Actividad.acti_nombre ASC";

		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de redes II
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function redesII($desde, $hasta, $cefa_id, $regi_id, $comu_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
				      ,Red.rede_nombre
				      ,COUNT(*) AS total
				FROM familias AS Familia
				JOIN centros_familiares AS CentroFamiliar ON (Familia.cefa_id = CentroFamiliar.cefa_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				JOIN redes AS Red ON (Familia.rede_id = Red.rede_id)
				WHERE Familia.fami_fecha_creacion >= '". $desde ." 00:00:00'
				AND Familia.fami_fecha_creacion <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				GROUP BY CentroFamiliar.cefa_id
						,CentroFamiliar.cefa_nombre
						,Red.rede_nombre";
						
		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de instituciones
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function instituciones($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}
		
		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND Actividad.acti_individual IS FALSE ': ' AND Actividad.acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND Actividad.acti_id = %d ', $acti_id);
		}
		$filtroProg = null;
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', Actividad.acti_fecha_inicio) = %d ', $mes);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
				      ,Institucion.inst_nombre
				      ,COUNT(*) AS total
				FROM actividades AS Actividad
				INNER JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
				INNER JOIN areas as Area ON TipoActividad.area_id = Area.area_id
				INNER JOIN programas as Programa ON Programa.prog_id = Area.prog_id

				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				JOIN instituciones AS Institucion ON (Actividad.inst_id = Institucion.inst_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND acti_fecha_inicio >= '".$desde." 00:00:00'
				AND acti_fecha_inicio <= '".$hasta." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroCobertura ."
				". $filtroActi ."
				". $filtroProg ."
				". $filtroMes ."
				GROUP BY CentroFamiliar.cefa_id
						,Institucion.inst_id
				ORDER BY CentroFamiliar.cefa_orden
				        ,Institucion.inst_nombre ASC";

		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de sesiones ejecutadas
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function sesionesEjecutadas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}
		
		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND Actividad.acti_individual IS FALSE ': ' AND Actividad.acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND Actividad.acti_id = %d ', $acti_id);
		}
		$filtroProg = null;
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', Actividad.acti_fecha_inicio) = %d ', $mes);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,Actividad.acti_nombre
					  ,Actividad.acti_nro_sesiones
					  ,(SELECT COUNT(*)
						FROM sesiones
						WHERE acti_id = Actividad.acti_id) AS sesiones_ejecutadas
				FROM actividades AS Actividad
				NATURAL JOIN tipos_actividades AS tiposActividades
				NATURAL JOIN areas as Area
				NATURAL JOIN programas as Programa
				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				AND (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND acti_fecha_inicio >= '".$desde." 00:00:00'
				AND acti_fecha_inicio <= '".$hasta." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroCobertura ."
				". $filtroActi ."
				". $filtroProg ."
				". $filtroMes ."
				ORDER BY CentroFamiliar.cefa_orden
						,Actividad.acti_nombre";
						
		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de cantidad de fichas
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function cantidadFichas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}
		
		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
						FROM (
							SELECT PersonaCentroFamiliar.pers_id
							      ,COUNT(*) AS total
							FROM asistencias AS Asistencia
							JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
							JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
							JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id)
							JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
							AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
							AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
							AND Actividad.cefa_id = CentroFamiliar.cefa_id
							AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
							AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
							". $filtroGrob ."
							". $filtroSexo ."
							GROUP BY PersonaCentroFamiliar.pers_id
						) AS tab) AS total_personas
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1, 2)
						AND Evaluacion.grob_id = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_ninos_diag_final
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1)
						AND Evaluacion.grob_id = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_ninos_diag
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1, 2)
						AND Evaluacion.grob_id = 2
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_jovenes_diag_final
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1)
						AND Evaluacion.grob_id = 2
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_jovenes_diag
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1, 2)
						AND Evaluacion.grob_id = 3
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_adultos_diag_final
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1)
						AND Evaluacion.grob_id = 3
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_adultos_diag
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1, 2)
						AND Evaluacion.grob_id = 4
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_mayores_diag_final
					  ,(SELECT COUNT(*)
						FROM evaluaciones AS Evaluacion
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id IN (1)
						AND Evaluacion.grob_id = 4
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS total_mayores_diag
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de tipos de familia
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function tiposFamilias($desde, $hasta, $cefa_id, $regi_id, $comu_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}

		$sql = "SELECT CentroFamiliar.comu_id
					  ,CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,(SELECT COALESCE(AVG(tab.total), 0)
						FROM (
							SELECT Familia.fami_id
							      ,COUNT(*) AS total
							FROM familias AS Familia
							JOIN personas AS Persona ON (Familia.fami_id = Persona.fami_id)
							WHERE Familia.tifa_id IN (5, 6, 4, 7, 8, 9, 11, 10)
							AND Familia.cefa_id = CentroFamiliar.cefa_id
							AND Familia.fami_fecha_creacion >= '". $desde ." 00:00:00'
							AND Familia.fami_fecha_creacion <= '". $hasta ." 23:59:59'
							GROUP BY Familia.fami_id
							)
						AS tab) AS promedio
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 5
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_unipersonal
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 6
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_nuclear_simple
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 4
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_nuclear_biparental
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 7
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_monoparental_madre
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 8
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_monoparental_padre
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 9
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_monoparental_abuelo
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 11
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_extendida
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND tifa_id = 10
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_otros
					  ,(SELECT COUNT(*)
					  	FROM familias
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_familias
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de relación familia
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function relacionFamilia($desde, $hasta, $cefa_id, $regi_id, $comu_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE cefa_id = CentroFamiliar.cefa_id
					  	AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_familias
					  ,(SELECT COUNT(*)
						FROM familias AS Familia
						WHERE (SELECT COUNT(*)
						       FROM personas
						       WHERE puor_id IS NOT NULL
						       AND fami_id = Familia.fami_id) > 0
							   AND Familia.cefa_id = CentroFamiliar.cefa_id
						AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_pueblos_originarios
					  ,(SELECT COUNT(*)
						FROM familias AS Familia
						WHERE (SELECT COUNT(*)
						       FROM personas
						       WHERE naci_id IS NOT NULL
						       AND naci_id != 1
						       AND fami_id = Familia.fami_id) > 0
						AND Familia.cefa_id = CentroFamiliar.cefa_id
						AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59') AS total_inmigrantes
					  ,(SELECT COUNT(*)
						FROM (
							SELECT Familia.fami_ap_paterno
						    	  ,(SELECT COUNT(*)
						       		FROM personas
						        	WHERE pers_discapacidad IS TRUE
						        	AND fami_id = Familia.fami_id) AS total_discapacitados
							FROM familias AS Familia
							WHERE Familia.cefa_id = CentroFamiliar.cefa_id
							AND Familia.fami_fecha_creacion >= '". $desde ." 00:00:00'
							AND Familia.fami_fecha_creacion <= '". $hasta ." 23:59:59'
						) AS tab
						WHERE tab.total_discapacitados > 0) AS total_discapacitados
					  ,(SELECT COUNT(*)
						FROM familias AS Familia
						JOIN personas AS Persona ON (Familia.pers_id = Persona.pers_id)
						AND Persona.sexo_id = 2
						AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59'
						AND Familia.cefa_id = CentroFamiliar.cefa_id) AS total_familias_jefe_mujer
					  ,(SELECT COUNT(*)
						FROM familias AS Familia
						JOIN personas AS Persona ON (Familia.pers_id = Persona.pers_id)
						AND Persona.sexo_id = 1
						AND fami_fecha_creacion >= '". $desde ." 00:00:00'
						AND fami_fecha_creacion <= '". $hasta ." 23:59:59'
						AND Familia.cefa_id = CentroFamiliar.cefa_id) AS total_familias_jefe_hombre
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";

		$res = $this->query($sql);
		return $res;
	}

	/**
	 * Retorna datos de reporte de relación familia
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function relacionFicha($desde, $hasta, $cefa_id, $regi_id, $comu_id, $sexo_id) {
		// el 100% es la totalidad de personas en el centro independiente si estan asociadas a un grupo objetivo o no
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	WHERE PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						". $filtroSexo .") AS total_fichas
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
					  	AND Persona.grob_id = 1
					  	AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						". $filtroSexo .") AS total_fichas_ninos
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
					  	AND Persona.grob_id = 2
					  	AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						". $filtroSexo .") AS total_fichas_jovenes
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
					  	AND Persona.grob_id = 3
					  	AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						". $filtroSexo .") AS total_fichas_adultos
					  ,(SELECT COUNT(*)
					  	FROM personas_centros_familiares AS PersonaCentroFamiliar
					  	JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					  	WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
					  	AND Persona.grob_id = 4
					  	AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
					  	AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						". $filtroSexo .") AS total_fichas_adultos_mayores
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna datos para el reporte de evaluación diagnóstica
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function evaluacionDiagnostica($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1
						AND Persona.grob_id = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ninos
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1
						AND Persona.grob_id = 2
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_jovenes
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1
						AND Persona.grob_id = 3
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_adultos
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1
						AND Persona.grob_id = 4
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_adultos_mayores
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";
		return $this->query($sql);
	}

	/**
	 * Retorna datos para el reporte de evaluación final
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function evaluacionFinal($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 2
						AND Persona.grob_id = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ninos
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 2
						AND Persona.grob_id = 2
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_jovenes
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 2
						AND Persona.grob_id = 3
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_adultos
					  ,(SELECT AVG(EvaluacionFactorProtector.evfp_valor)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 2
						AND Persona.grob_id = 4
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_adultos_mayores
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";
		return $this->query($sql);
	}

	/**
	 * Retorna datos para el reporte de evaluación de factores de riesgos
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function evaluacionFactoresRiesgos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = "";
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(" AND CentroFamiliar.cefa_id = %d ", $cefa_id);	
		}
		
		$filtroRegi = "";
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(" AND Region.regi_id = %d ", $regi_id);	
		}
		
		$filtroComu = "";
		if (!empty($comu_id)) {
			$filtroRegi = sprintf(" AND Comuna.comu_id = %d ", $comu_id);	
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 1
						AND EvaluacionFactorRiesgo.evfr_presente = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_presentes_ninos
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 2
						AND EvaluacionFactorRiesgo.evfr_presente = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_presentes_jovenes
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 3
						AND EvaluacionFactorRiesgo.evfr_presente = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_presentes_adultos
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 4
						AND EvaluacionFactorRiesgo.evfr_presente = 1
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_presentes_adultos_mayores
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 1
						AND EvaluacionFactorRiesgo.evfr_presente = 0
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ausentes_ninos
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 2
						AND EvaluacionFactorRiesgo.evfr_presente = 0
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ausentes_jovenes
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 3
						AND EvaluacionFactorRiesgo.evfr_presente = 0
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ausentes_adultos
					  ,(SELECT AVG(EvaluacionFactorRiesgo.evfr_presente::int)
						FROM personas_centros_familiares AS PersonaCentroFamiliar
						JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
						JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
						JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND Evaluacion.tiev_id = 1 
						AND Persona.grob_id = 4
						AND EvaluacionFactorRiesgo.evfr_presente = 0
						AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
						AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
						AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
						". $filtroGrob ."
						". $filtroSexo .") AS promedio_ausentes_adultos_mayores
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";
		return $this->query($sql);
	}

	/**
	 * Retorna datos para el reporte de redes I
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function redesI($desde, $hasta, $cefa_id, $regi_id, $comu_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,Red.rede_nombre
					  ,Familia.fami_ap_paterno
					  ,Familia.fami_ap_materno
					  ,Familia.fami_acciones
				FROM centros_familiares AS CentroFamiliar
				JOIN familias AS Familia ON (CentroFamiliar.cefa_id = Familia.cefa_id)
				JOIN redes AS Red ON (Familia.rede_id = Red.rede_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE Familia.fami_acciones IS NOT NULL
				AND Familia.fami_fecha_creacion >= '". $desde ." 00:00:00'
				AND Familia.fami_fecha_creacion <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden
						,Familia.fami_ap_materno
						,Familia.fami_ap_materno";

		return $this->query($sql);
	}

	/**
	 * Retorna reporte de evaluación de factores protectores
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function evaluacionFactoresProtectores($desde, $hasta, $tipo, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND Persona.grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND Persona.sexo_id = %d ", $sexo_id);
		}
		
		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,Persona.pers_run
					  ,Persona.pers_run_dv
					  ,Persona.pers_nombres
					  ,Persona.pers_ap_paterno
					  ,Persona.pers_ap_materno
					  ,FactorProtector.fapr_nombre
					  ,IndicadorFactorProtector.ifpr_descripcion
					  ,EvaluacionFactorProtector.evfp_valor
					  ,Evaluacion.eval_observacion
				FROM evaluaciones AS Evaluacion
				JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN centros_familiares AS CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
				JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (EvaluacionFactorProtector.ifpr_id = IndicadorFactorProtector.ifpr_id)
				JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
				WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroGrob ."
				". $filtroSexo ."
				AND Evaluacion.eval_fecha >= '". $desde ."'
				AND Evaluacion.eval_fecha <= '". $hasta ."'
				AND Evaluacion.tiev_id = ". $tipo ."
				ORDER BY CentroFamiliar.cefa_orden
						,Persona.pers_ap_paterno
						,Persona.pers_ap_materno
						,FactorProtector.fapr_nombre
					  	,IndicadorFactorProtector.ifpr_descripcion";

		return $this->query($sql);
	}

	/**
	 * Retorna información de reporte acumulado
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function reporteAcumulado($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		ini_set('memory_limit', '2048M');

		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND comu_id = %d ', $comu_id);
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND sexo_id = %d ", $sexo_id);
		}

		// este reporte se cambia a vista materializada por temas de performance
		$sql = "SELECT pers_run
					  ,pers_run_dv
					  ,pers_nombres
					  ,pers_ap_paterno
					  ,pers_ap_materno
					  ,sexo_nombre
					  ,cefa_nombre
				FROM m_reporte_acumulado
				WHERE pecf_fecha_creacion >= '". $desde ." 00:00:00'
				AND pecf_fecha_creacion <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroGrob ."
				". $filtroSexo;

		/*		
		$sql = "SELECT Persona.pers_run
					  ,Persona.pers_run_dv
					  ,Persona.pers_nombres
					  ,Persona.pers_ap_paterno
					  ,Persona.pers_ap_materno
					  ,Sexo.sexo_nombre
					  ,CentroFamiliar.cefa_nombre
				FROM personas_centros_familiares AS PersonaCentroFamiliar
				JOIN centros_familiares AS CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				JOIN sexos AS Sexo ON (Persona.sexo_id = Sexo.sexo_id)
				AND PersonaCentroFamiliar.pecf_habilitada IS TRUE
				AND PersonaCentroFamiliar.pecf_fecha_creacion >= '". $desde ." 00:00:00'
				AND PersonaCentroFamiliar.pecf_fecha_creacion <= '". $hasta ." 23:59:59'
				ORDER BY CentroFamiliar.cefa_orden
						,Persona.pers_ap_paterno
						,Persona.pers_ap_materno";
		*/
		return $this->query($sql);
	}

	/**
	 * Retorna información de reporte acumulado
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function reporteFuentesFinanciamientos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}
		$filtroProg = null;
		if (!empty($prog_id)) {
			$filtroProg = sprintf(' AND Programa.prog_id = %d ', $prog_id);
			
		}
		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND Actividad.acti_individual IS FALSE ': ' AND Actividad.acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND Actividad.acti_id = %d ', $acti_id);
		}

		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', Actividad.acti_fecha_inicio) = %d ', $mes);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
      				  ,FuenteFinanciamiento.fufi_nombre
      				  ,COALESCE(Total.cant_personas, 0) AS total_personas
      				  ,SUM(GastoActividad.gaac_total) AS total
				FROM gastos_actividades AS GastoActividad
				JOIN fuentes_financiamientos AS FuenteFinanciamiento ON (GastoActividad.fufi_id = FuenteFinanciamiento.fufi_id)
				JOIN actividades AS Actividad ON (GastoActividad.acti_id = Actividad.acti_id)
				INNER JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
				INNER JOIN areas as Area ON TipoActividad.area_id = Area.area_id

				INNER JOIN programas as Programa ON Programa.prog_id = Area.prog_id
				JOIN centros_familiares AS CentroFamiliar ON (Actividad.cefa_id = CentroFamiliar.cefa_id)
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				LEFT JOIN (
    				SELECT COUNT(DISTINCT pecf_id) AS cant_personas
	  					  ,GastoActividad.fufi_id
          				  ,Actividad.cefa_id
    				FROM gastos_actividades AS GastoActividad
    				JOIN actividades AS Actividad ON (GastoActividad.acti_id = Actividad.acti_id)
    				JOIN sesiones AS Sesion ON (Actividad.acti_id = Sesion.acti_id)
    				JOIN asistencias AS Asistencia ON (Sesion.sesi_id = Asistencia.sesi_id)
    				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
    				AND Actividad.acti_fecha_inicio >= '". $desde ."'
					AND Actividad.acti_fecha_inicio <= '". $hasta ."'
    				GROUP BY GastoActividad.fufi_id
            				,Actividad.cefa_id) AS Total ON (FuenteFinanciamiento.fufi_id = Total.fufi_id AND Actividad.cefa_id = Total.cefa_id)
				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND Actividad.acti_fecha_inicio >= '". $desde ."'
				AND Actividad.acti_fecha_inicio <= '". $hasta ."'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroCobertura ."
				". $filtroActi ."
				". $filtroMes ."
				GROUP BY CentroFamiliar.cefa_nombre
        				,CentroFamiliar.cefa_orden
						,FuenteFinanciamiento.fufi_nombre
						,Total.cant_personas
						,CentroFamiliar.cefa_id
				ORDER BY CentroFamiliar.cefa_orden
        				,FuenteFinanciamiento.fufi_nombre";

		return $this->query($sql);
	}

	/**
	 * Retorna información reporte de prestaciones generales
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function prestacionesGenerales($desde, $hasta) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		$sql = "SELECT CentroFamiliar.cefa_id
					  ,CentroFamiliar.cefa_nombre
					  ,(SELECT COUNT(*)
						FROM asistencias AS Asistencia
						JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
						JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
						WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
						AND Actividad.cefa_id = CentroFamiliar.cefa_id
						AND Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
						AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59') AS nro_prestaciones
				FROM centros_familiares AS CentroFamiliar
				ORDER BY CentroFamiliar.cefa_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna información de reporte de prestaciones por area
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function prestacionesPorArea($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		$sql = "SELECT  Area.area_nombre
				       ,TipoActividad.tiac_nombre
				       ,COUNT(*) AS nro_prestaciones
				FROM asistencias AS Asistencia
				JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
				JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
				JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
				JOIN areas AS Area ON (TipoActividad.area_id = Area.area_id)
				INNER JOIN programas p ON (p.prog_id = Area.prog_id)
				JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Asistencia.pecf_id = PersonaCentroFamiliar.pecf_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				LEFT JOIN comunas AS Comuna ON (Actividad.comu_id = Comuna.comu_id)
				LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				WHERE (Actividad.esac_id = 2 OR Actividad.esac_id = 7)
				AND Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'\n";

		if (!empty($cefa_id)) {
			$sql .= "AND Actividad.cefa_id = ". $cefa_id."\n";
		}

		if (!empty($regi_id)) {
			$sql .= "AND Region.regi_id = ". $regi_id."\n";
		}

		if (!empty($comu_id)) {
			$sql .= "AND Comuna.comu_id = ". $comu_id."\n";
		}

		if (!empty($grob_id)) {
			$sql .= "AND Persona.grob_id = ". $grob_id."\n";
		}

		if (!empty($sexo_id)) {
			$sql .= "AND Persona.sexo_id = ". $sexo_id."\n";
		}

		if (!empty($tipo_cobertura)) {
			$sql .= ($tipo_cobertura == 1)? "AND Actividad.acti_individual IS FALSE\n": "AND Actividad.acti_individual IS TRUE\n";
		}

		if (!empty($acti_id)) {
			$sql .= "AND Actividad.acti_id = ". $acti_id."\n";
		}

		if (!empty($mes)) {
			$sql .= "AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = ". $mes."\n";
		}
		if (!empty($prog_id)) {
			$sql .= sprintf(' AND p.prog_id = %d ', $prog_id);
			
		}
		$sql .= "GROUP BY TipoActividad.tiac_nombre
						 ,Area.area_nombre
						 ,Area.area_orden
						 ,TipoActividad.tiac_orden
				 ORDER BY Area.area_orden
						 ,TipoActividad.tiac_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna información de reporte consolidado (completo)
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function reporteConsolidado($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes, $prog_nombre) {
	
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND comu_id = %d ', $comu_id);
		}
		
		$filtroGrob = "";
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(" AND grob_id = %d ", $grob_id);
		}
		
		$filtroSexo = "";
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(" AND sexo_id = %d ", $sexo_id);
		}
		
		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND acti_individual IS FALSE ': ' AND acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND acti_id = %d ', $acti_id);
		}
		$filtroProg = null;
		if (!empty($prog_nombre)) {
			$filtroProg = sprintf(" AND prog_nombre ='%s' ", $prog_nombre);
			
		}
		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', acti_fecha_inicio) = %d ', $mes);
		}

		// este reporte se cambia a vista materializada por temas de performance
		$sql = "SELECT cefa_nombre
				      ,cefa_direccion
				      ,comuna_centro_familiar
				      ,cefa_nro_fijo
				      ,cefa_email
				      ,pers_run
				      ,pers_run_dv
				      ,pers_nombres
				      ,pers_ap_paterno
				      ,pers_ap_materno
				      ,pers_email
				      ,pers_ocupacion
				      ,discapacidad
				      ,pers_fecha_nacimiento
				      ,pers_nro_movil
				      ,pers_nro_fijo
				      ,sexo_nombre
				      ,esci_nombre
				      ,naci_nombre
				      ,dire_direccion
				      ,comuna_persona
				      ,puor_nombre
				      ,estu_nombre
				      ,pare_nombre
				      ,inst_salud
				      ,inst_prevision
				      ,grob_nombre
				      ,fami_ap_paterno
				      ,fami_ap_materno
				      ,fami_direccion_calle
				      ,fami_direccion_nro
				      ,fami_direccion_depto
				      ,fami_direccion_block
				      ,comuna_familia
				      ,fami_nro_movil
				      ,fami_nro_fijo
				      ,fami_observacion
				      ,fami_obs_coordinacion
				      ,fami_otras_observaciones
				      ,tifa_nombre
				      ,rede_nombre
				      ,siha_nombre
				      ,jefe_familia
				      ,asis_fecha
				      ,sesi_nombre
				      ,acti_nombre
				      ,acti_descripcion
				      ,acti_frecuencia
				      ,actividad_individual
				      ,acti_fecha_inicio
				      ,acti_fecha_termino
				      ,actividad_comunicacional
				      ,acti_direccion
				      ,comuna_actividad
				      ,acti_poblacion
				      ,acti_nro_sesiones
				      ,acti_observaciones
				      ,acti_cobertura_esperada
				      ,tiac_nombre
				      ,area_nombre
				      ,prog_nombre
				      ,inst_actividad
				      ,eval_fecha
				      ,eval_observacion
				      ,tiev_nombre
				      ,ifpr_descripcion
				      ,evfp_valor
				      ,fapr_nombre
				      ,fapr_objetivos
				      ,fapr_ano
				      ,nive_nombre
				      ,factor_riesgo_presente
				      ,fari_descripcion
				      ,plan_trabajo
				      ,dept_observaciones
				      ,plan_trabajo_acti_nombre
				FROM m_reporte_consolidado
				WHERE acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND acti_fecha_inicio <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroGrob ."
				". $filtroSexo ."
				". $filtroCobertura ."
				". $filtroActi ."
				". $filtroProg ."
				". $filtroMes;
				
		/*
		$sql = "SELECT CentroFamiliar.cefa_nombre
				      ,CentroFamiliar.cefa_direccion
				      ,ComunaCentroFamiliar.comu_nombre AS comuna_centro_familiar
				      ,CentroFamiliar.cefa_nro_fijo
				      ,CentroFamiliar.cefa_email
				      ,Persona.pers_run
				      ,Persona.pers_run_dv
				      ,Persona.pers_nombres
				      ,Persona.pers_ap_paterno
				      ,Persona.pers_ap_materno
				      ,Persona.pers_email
				      ,Persona.pers_ocupacion
				      ,CASE WHEN Persona.pers_discapacidad IS TRUE THEN 'SI' ELSE 'NO' END AS discapacidad
				      ,Persona.pers_fecha_nacimiento
				      ,Persona.pers_nro_movil
				      ,Persona.pers_nro_fijo
				      ,SexoPersona.sexo_nombre
				      ,EstadoCivil.esci_nombre
				      ,Nacionalidad.naci_nombre
				      ,Direccion.dire_direccion
				      ,ComunaPersona.comu_nombre AS comuna_persona
				      ,PuebloOriginario.puor_nombre
				      ,Estudio.estu_nombre
				      ,Parentesco.pare_nombre
				      ,InstitucionSalud.inst_nombre AS inst_salud
				      ,InstitucionPrevision.inst_nombre AS inst_prevision
				      ,GrupoObjetivo.grob_nombre
				      ,Familia.fami_ap_paterno
				      ,Familia.fami_ap_materno
				      ,Familia.fami_direccion_calle
				      ,Familia.fami_direccion_nro
				      ,Familia.fami_direccion_depto
				      ,Familia.fami_direccion_block
				      ,ComunaFamilia.comu_nombre AS comuna_familia
				      ,Familia.fami_nro_movil
				      ,Familia.fami_nro_fijo
				      ,Familia.fami_observacion
				      ,Familia.fami_obs_coordinacion
				      ,Familia.fami_otras_observaciones
				      ,TipoFamilia.tifa_nombre
				      ,Red.rede_nombre
				      ,SituacionHabitacional.siha_nombre
				      ,JefeFamiliar.pers_nombres || ' '  || JefeFamiliar.pers_ap_paterno || ' ' || JefeFamiliar.pers_ap_materno AS jefe_familia
				      ,Asistencia.asis_fecha
				      ,Sesion.sesi_nombre
				      ,Actividad.acti_nombre
				      ,Actividad.acti_descripcion
				      ,Actividad.acti_frecuencia
				      ,CASE WHEN Actividad.acti_individual IS TRUE THEN 'SI' ELSE 'NO' END AS actividad_individual
				      ,Actividad.acti_fecha_inicio
				      ,Actividad.acti_fecha_termino
				      ,CASE WHEN Actividad.acti_es_comunicacional IS TRUE THEN 'SI' ELSE 'NO' END AS actividad_comunicacional
				      ,Actividad.acti_direccion
				      ,ComunaActividad.comu_nombre AS comuna_actividad
				      ,Actividad.acti_poblacion
				      ,Actividad.acti_nro_sesiones
				      ,Actividad.acti_observaciones
				      ,Actividad.acti_cobertura_esperada
				      ,TipoActividad.tiac_nombre
				      ,Area.area_nombre
				      ,Programa.prog_nombre
				      ,InstitucionActividad.inst_nombre AS inst_actividad
				      ,Evaluacion.eval_fecha
				      ,Evaluacion.eval_observacion
				      ,TipoEvaluacion.tiev_nombre
				      ,IndicadorFactorProtector.ifpr_descripcion
				      ,EvaluacionFactorProtector.evfp_valor
				      ,FactorProtector.fapr_nombre
				      ,FactorProtector.fapr_objetivos
				      ,FactorProtector.fapr_ano
				      ,Nivel.nive_nombre
				      ,CASE WHEN EvaluacionFactorRiesgo.evfr_presente = 1 THEN 'SI' ELSE 'NO' END AS factor_riesgo_presente
				      ,FactorRiesgo.fari_descripcion
				      ,PlanTrabajo.plan_trabajo
				      ,DetallePlanTrabajo.dept_observaciones
				      ,ActividadPlanTrabajo.acti_nombre AS plan_trabajo_acti_nombre
				FROM personas_centros_familiares AS PersonaCentroFamiliar
				JOIN centros_familiares AS CentroFamiliar ON (PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id)
				JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
				LEFT JOIN comunas AS ComunaCentroFamiliar ON (CentroFamiliar.comu_id = ComunaCentroFamiliar.comu_id)
				LEFT JOIN familias AS Familia ON (Persona.fami_id = Familia.fami_id)
				LEFT JOIN comunas AS ComunaFamiliar ON (Familia.comu_id = ComunaFamiliar.comu_id)
				LEFT JOIN personas AS PersonaJefeHogar ON (Familia.pers_id = PersonaJefeHogar.pers_id)
				LEFT JOIN tipos_familias AS TipoFamilia ON (Familia.tifa_id = TipoFamilia.tifa_id)
				LEFT JOIN redes AS Red ON (Familia.rede_id = Red.rede_id)
				LEFT JOIN situaciones_habitacionales AS SituacionHabitacional ON (Familia.siha_id = SituacionHabitacional.siha_id)

				JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
				LEFT JOIN sesiones AS Sesion ON (Asistencia.sesi_id = Sesion.sesi_id)
				LEFT JOIN actividades AS Actividad ON (Sesion.acti_id = Actividad.acti_id)
				LEFT JOIN tipos_actividades AS TipoActividad ON (Actividad.tiac_id = TipoActividad.tiac_id)
				LEFT JOIN areas AS Area ON (TipoActividad.area_id = Area.area_id)
				LEFT JOIN programas AS Programa ON (Area.prog_id = Programa.prog_id)
				LEFT JOIN estados_actividades AS EstadoActividad ON (Actividad.esac_id = EstadoActividad.esac_id)
				LEFT JOIN comunas AS ComunaActividad ON (Actividad.comu_id = ComunaActividad.comu_id)
				LEFT JOIN instituciones AS InstitucionActividad ON (Actividad.inst_id = InstitucionActividad.inst_id)
				LEFT JOIN sexos AS SexoPersona ON (Persona.sexo_id = SexoPersona.sexo_id)
				LEFT JOIN estados_civiles AS EstadoCivil ON (Persona.esci_id = EstadoCivil.esci_id)
				LEFT JOIN nacionalidades AS Nacionalidad ON (Persona.naci_id = Nacionalidad.naci_id)
				LEFT JOIN direcciones AS Direccion ON (Persona.dire_id = Direccion.dire_id)
				LEFT JOIN comunas AS ComunaPersona ON (Direccion.comu_id = ComunaPersona.comu_id)
				LEFT JOIN pueblos_originarios AS PuebloOriginario ON (Persona.puor_id = PuebloOriginario.puor_id)
				LEFT JOIN estudios AS Estudio ON (Persona.estu_id = Estudio.estu_id)
				LEFT JOIN parentescos AS Parentesco ON (Persona.pare_id = Parentesco.pare_id)
				LEFT JOIN instituciones AS InstitucionSalud ON (Persona.inst_id = InstitucionSalud.inst_id)
				LEFT JOIN instituciones AS InstitucionPrevision ON (Persona.inst_id2 = InstitucionPrevision.inst_id)
				LEFT JOIN grupos_objetivos AS GrupoObjetivo ON (Persona.grob_id = GrupoObjetivo.grob_id)
				LEFT JOIN comunas AS ComunaFamilia ON (Familia.comu_id = ComunaFamilia.comu_id)
				LEFT JOIN personas AS JefeFamiliar ON (Familia.pers_id = JefeFamiliar.pers_id)

				LEFT JOIN evaluaciones AS Evaluacion ON (PersonaCentroFamiliar.pecf_id = Evaluacion.pecf_id)
				LEFT JOIN tipos_evaluaciones AS TipoEvaluacion ON (Evaluacion.tiev_id = TipoEvaluacion.tiev_id)
				LEFT JOIN evaluaciones_factores_protectores AS EvaluacionFactorProtector ON (Evaluacion.eval_id = EvaluacionFactorProtector.eval_id)
				LEFT JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (EvaluacionFactorProtector.ifpr_id = IndicadorFactorProtector.ifpr_id)
				LEFT JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
				LEFT JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id)
				LEFT JOIN evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo ON (Evaluacion.eval_id = EvaluacionFactorRiesgo.eval_id)
				LEFT JOIN factores_riesgos AS FactorRiesgo ON (EvaluacionFactorRiesgo.fari_id = FactorRiesgo.fari_id)

				LEFT JOIN planes_trabajos AS PlanTrabajo ON (PersonaCentroFamiliar.pecf_id = PlanTrabajo.pecf_id)
				LEFT JOIN detalles_planes_trabajos AS DetallePlanTrabajo ON (PlanTrabajo.pltr_id = DetallePlanTrabajo.pltr_id)
				LEFT JOIN actividades AS ActividadPlanTrabajo ON (DetallePlanTrabajo.acti_id = ActividadPlanTrabajo.acti_id)
				WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
				AND Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'
				ORDER BY CentroFamiliar.cefa_orden ASC
						,Persona.pers_ap_paterno ASC
						,Persona.pers_ap_materno ASC
						,Persona.pers_nombres ASC";
		*/
		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de actividades MASIVAS
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function actividadesMasivas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $acti_id, $mes,$prog_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}

		$sql = "SELECT CentroFamiliar.cefa_nombre
					  ,Actividad.acti_nombre
					  ,Area.area_nombre
					  ,TipoActividad.tiac_nombre
					  ,Actividad.acti_cobertura_esperada
					  ,Actividad.acti_fecha_inicio
					  ,Actividad.acti_fecha_termino
				FROM centros_familiares AS CentroFamiliar
				NATURAL JOIN actividades AS Actividad
				NATURAL JOIN tipos_actividades AS TipoActividad
				NATURAL JOIN areas AS Area 
				INNER  JOIN programas AS Programa
				ON Area.prog_id = Programa.prog_id \n";

		// filtros
		$sql .= "LEFT JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				 LEFT JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				 WHERE Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				 AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'
				 AND Actividad.acti_individual IS FALSE
				 AND Actividad.esac_id = 7\n";
		
		if (!empty($cefa_id)) {
			$sql .= "AND CentroFamiliar.cefa_id = ". $cefa_id ."\n";
		}

		
		if (!empty($regi_id)) {
			$sql .= "AND Region.regi_id = ". $regi_id ."\n";
		}
		
		if (!empty($comu_id)) {
			$sql .= "AND Comuna.comu_id = ". $comu_id ."\n";
		}
		
		if (!empty($acti_id)) {
			$sql .= "AND Actividad.acti_id = ". $acti_id ."\n";
		}
		if (!empty($prog_id)) {
			$sql .= "AND Programa.prog_id = ". $prog_id ."\n";
		}
		if (!empty($mes)) {
			$sql .= "AND DATE_PART('MONTH', Actividad.acti_fecha_inicio) = ". $mes ."\n";
		}

		$sql .= "ORDER BY CentroFamiliar.cefa_orden ASC
						 ,Actividad.acti_fecha_inicio DESC";


		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de planes de trabajos
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function planesTrabajos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}

		$filtroGrob = null;
		if (!empty($grob_id)) {
			$filtroGrob = sprintf(' AND Persona.grob_id = %d ', $grob_id);
		}
		
		$filtroSexo = null;
		if (!empty($sexo_id)) {
			$filtroSexo = sprintf(' AND Persona.sexo_id = %d ', $sexo_id);
		}

		$sql = "SELECT CentroFamiliar.cefa_id
      				  ,CentroFamiliar.cefa_nombre
      				  ,COALESCE(T.total, 0) AS total
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				LEFT JOIN (
					SELECT COUNT(*) AS total
	      				  ,PersonaCentroFamiliar.cefa_id
					FROM personas_centros_familiares AS PersonaCentroFamiliar
					JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
					WHERE Persona.pers_plan_trabajo != ''
					AND Persona.pers_fecha_act >= '". $desde ." 00:00:00'
					AND Persona.pers_fecha_act <= '". $hasta ." 23:59:59'
					". $filtroGrob ."
					". $filtroSexo ."
					GROUP BY PersonaCentroFamiliar.cefa_id
				) AS T ON (CentroFamiliar.cefa_id = T.cefa_id)
				WHERE 1 = 1
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				ORDER BY CentroFamiliar.cefa_orden";

		return $this->query($sql);
	}

	/**
	 * Retorna datos de reporte de actividades por fuente de financiamiento
	 * 
	 * @author maraya-gómez
	 * @param string $desde
	 * @param string $hasta
	 * @return array
	 */
	public function actividadesFuentesFinanciamientos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes) {
		if ($desde == null) {
			$desde = '2000-01-01';
		}

		if ($hasta == null) {
			$hasta = date('Y-m-d');
		}
		
		$filtroCefa = null;
		if (!empty($cefa_id)) {
			$filtroCefa = sprintf(' AND CentroFamiliar.cefa_id = %d ', $cefa_id);
		}

		$filtroRegi = null;
		if (!empty($regi_id)) {
			$filtroRegi = sprintf(' AND Region.regi_id = %d ', $regi_id);
		}

		$filtroComu = null;
		if (!empty($comu_id)) {
			$filtroComu = sprintf(' AND Comuna.comu_id = %d ', $comu_id);
		}
		
		$filtroCobertura = null;
		if (!empty($tipo_cobertura)) {			
			$filtroCobertura = ($tipo_cobertura == 1)? ' AND Actividad.acti_individual IS FALSE ': ' AND Actividad.acti_individual IS TRUE ';
		}

		$filtroActi = null;
		if (!empty($acti_id)) {
			$filtroActi = sprintf(' AND Actividad.acti_id = %d ', $acti_id);
		}

		// revisar bien este filtro
		$filtroMes = null;
		if (!empty($mes)) {
			$filtroMes = sprintf(' AND DATE_PART(\'MONTH\', Actividad.acti_fecha_inicio) = %d ', $mes);
		}

		
		$sql = "SELECT CentroFamiliar.cefa_id
				      ,CentroFamiliar.cefa_nombre
				      ,Actividad.acti_nombre
				      ,EstadoActividad.esac_nombre
				      ,FuenteFinanciamiento.fufi_nombre
				      ,t.total_prestaciones
				FROM centros_familiares AS CentroFamiliar
				JOIN comunas AS Comuna ON (CentroFamiliar.comu_id = Comuna.comu_id)
				JOIN regiones AS Region ON (Comuna.regi_id = Region.regi_id)
				JOIN actividades AS Actividad ON (CentroFamiliar.cefa_id = Actividad.cefa_id)
				JOIN (
					SELECT Sesion.acti_id	
					      ,COUNT(*) AS total_prestaciones
					FROM sesiones AS Sesion
					JOIN asistencias AS Asistencia ON (Sesion.sesi_id = Asistencia.sesi_id)
					GROUP BY Sesion.acti_id
				) AS t ON (t.acti_id = Actividad.acti_id)
				LEFT JOIN estados_actividades AS EstadoActividad ON (Actividad.esac_id = EstadoActividad.esac_id)
				LEFT JOIN gastos_actividades AS GastoActividad ON (Actividad.acti_id = GastoActividad.acti_id)
				LEFT JOIN fuentes_financiamientos AS FuenteFinanciamiento ON (GastoActividad.fufi_id = FuenteFinanciamiento.fufi_id)
				WHERE Actividad.acti_fecha_inicio >= '". $desde ." 00:00:00'
				AND Actividad.acti_fecha_inicio <= '". $hasta ." 23:59:59'
				". $filtroCefa ."
				". $filtroRegi ."
				". $filtroComu ."
				". $filtroCobertura ."
				". $filtroActi ."
				". $filtroMes ."
				GROUP BY CentroFamiliar.cefa_id
				        ,CentroFamiliar.cefa_nombre
				        ,Actividad.acti_nombre
				        ,EstadoActividad.esac_nombre
				        ,FuenteFinanciamiento.fufi_nombre
				        ,t.total_prestaciones
				ORDER BY CentroFamiliar.cefa_orden
						,Actividad.acti_nombre";

		return $this->query($sql);
	}

	/**
	 * Refresca vistas materializadas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function refreshMaterializedViews() {
		$this->query("REFRESH MATERIALIZED VIEW m_reporte_acumulado WITH DATA");
		$this->query("REFRESH MATERIALIZED VIEW m_reporte_consolidado WITH DATA");
		$this->query("REFRESH MATERIALIZED VIEW m_detalle_actividades_x_participantes WITH DATA");
	}
}
