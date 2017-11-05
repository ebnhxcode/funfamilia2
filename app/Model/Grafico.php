<?php
App::uses('AppModel', 'Model');
/**
 * Grafico Model
 *
 */
class Grafico extends AppModel {
	/**
	 * Primary key field
	 *
	 * @var boolean
	 */
	public $useTable = false;

	/**
	 * Retorna datos del gráfico tipos de familia
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function tiposFamilias() {
		$sql = "SELECT (SELECT COUNT(*)
						FROM familias) AS total_familias
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 5) AS total_unipersonal
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 6) AS total_nuclear_simple
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 4) AS total_nuclear_biparental
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 7) AS total_monoparental_madre
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 8) AS total_monoparental_padre
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 9) AS total_monoparental_abuelo
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 10) AS total_monoparental_otro
					  ,(SELECT COUNT(*)
					  	FROM familias 
					  	WHERE tifa_id = 11) AS total_extendida";
		return $this->query($sql);
	}

	/**
	 * Retorna datos del gráfico familias allegadas
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function familiasAllegadas() {
		$sql = "SELECT COUNT(*) AS total
				      ,CASE WHEN SituacionHabitacional.siha_nombre IS NULL THEN
				      		'Sin Información'
				       ELSE
				       		SituacionHabitacional.siha_nombre
				       END AS siha_nombre
				FROM familias as Familia
				LEFT JOIN situaciones_habitacionales AS SituacionHabitacional ON (Familia.siha_id = SituacionHabitacional.siha_id)
				GROUP BY SituacionHabitacional.siha_nombre";
		return $this->query($sql);		
	}

	/**
	 * Retorna datos de cantidad de hombres y mujeres por centro
	 * 
	 * @author maraya-gómez
	 * @return array
	 */
	public function cantHombresMujeresPorCentro() {
		$sql = "SELECT CentroFamiliar.cefa_id
     				  ,(SELECT COUNT(*) FROM (
							SELECT COUNT(*),PersonaCentroFamiliar.pecf_id
							FROM personas_centros_familiares AS PersonaCentroFamiliar
							JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
							JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
							WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
							AND Persona.sexo_id = 1
							AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
							GROUP BY PersonaCentroFamiliar.pecf_id
							)
						AS tab ) AS total_hombres
       				  ,(SELECT COUNT(*) FROM (
							SELECT COUNT(*),PersonaCentroFamiliar.pecf_id
							FROM personas_centros_familiares AS PersonaCentroFamiliar
							JOIN personas AS Persona ON (PersonaCentroFamiliar.pers_id = Persona.pers_id)
							JOIN asistencias AS Asistencia ON (PersonaCentroFamiliar.pecf_id = Asistencia.pecf_id)
							WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
							AND Persona.sexo_id = 2
							AND PersonaCentroFamiliar.cefa_id = CentroFamiliar.cefa_id
							GROUP BY PersonaCentroFamiliar.pecf_id
							)
						AS tab ) AS total_mujeres
				FROM centros_familiares AS CentroFamiliar
				ORDER BY CentroFamiliar.cefa_orden ASC";

		return $this->query($sql);
	}

	/**
	 * Retorna datos del gráfico de cantidad de factores de riesgos
	 * 
	 * @author maraya-gómez
	 * @return array
	 */	
	public function cantFactoresRiesgos($cefa_id, $fari_id) {
		$sql = "SELECT (SELECT COUNT(*)
						FROM evaluaciones_factores_riesgos  AS EvaluacionFactorRiesgo
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorRiesgo.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						WHERE EvaluacionFactorRiesgo.evfr_presente = 1
						AND EvaluacionFactorRiesgo.fari_id = ". $fari_id ."
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id .") AS presente
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorRiesgo.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						WHERE EvaluacionFactorRiesgo.evfr_presente = 0
						AND EvaluacionFactorRiesgo.fari_id = ". $fari_id ."
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id .") AS ausente
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_riesgos AS EvaluacionFactorRiesgo
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorRiesgo.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						WHERE EvaluacionFactorRiesgo.evfr_presente = -1
						AND EvaluacionFactorRiesgo.fari_id = ". $fari_id ."
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id .") AS no_aplica";
		return $this->query($sql);
	}

	/**
	 * Retorna información para el gráfico de factores protectores
	 * 
	 * @param int $cefa_id
	 * @param int $grob_id
	 * @param int $nive_id
	 * @param int $fapr_id
	 * @param int $ano_id
	 * @author maraya-gómez
	 * @return array
	 */
	public function factoresProtectores($cefa_id, $grob_id, $nive_id, $fapr_id, $ano_id) {
		$sql = "SELECT (SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_evaluaciones
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND EvaluacionFactorProtector.evfp_valor = 1
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_muy_negativa
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND EvaluacionFactorProtector.evfp_valor = 2
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_negativa
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND EvaluacionFactorProtector.evfp_valor = 3
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_intermedia
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND EvaluacionFactorProtector.evfp_valor = 4
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_positiva
					  ,(SELECT COUNT(*)
						FROM evaluaciones_factores_protectores AS EvaluacionFactorProtector
						JOIN indicadores_factores_protectores AS IndicadorFactorProtector ON (IndicadorFactorProtector.ifpr_id = EvaluacionFactorProtector.ifpr_id)
						JOIN evaluaciones AS Evaluacion ON (EvaluacionFactorProtector.eval_id = Evaluacion.eval_id)
						JOIN personas_centros_familiares AS PersonaCentroFamiliar ON (Evaluacion.pecf_id = PersonaCentroFamiliar.pecf_id)
						JOIN factores_protectores AS FactorProtector ON (IndicadorFactorProtector.fapr_id = FactorProtector.fapr_id)
						JOIN niveles AS Nivel ON (FactorProtector.nive_id = Nivel.nive_id) 
						WHERE PersonaCentroFamiliar.pecf_habilitada IS TRUE
						AND EvaluacionFactorProtector.evfp_valor = 5
						AND PersonaCentroFamiliar.cefa_id = ". $cefa_id ."
						AND FactorProtector.fapr_ano = ". $ano_id ."
						AND Nivel.grob_id = ". $grob_id ."
						AND FactorProtector.nive_id = ". $nive_id ."
						AND FactorProtector.fapr_id = ". $fapr_id .") AS total_muy_positiva";
		return $this->query($sql);
	}
}