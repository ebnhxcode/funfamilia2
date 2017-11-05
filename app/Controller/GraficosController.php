<?php
class GraficosController extends AppController {
	/**
	 * Modelos a usar
	 *
	 * @var array
	 */
	public $uses = array('Grafico', 'CentroFamiliar', 'FactorRiesgo', 'GrupoObjetivo');

	/**
	 * Gráfico de tipos de familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function tipos_familias() {
		$info = $this->Grafico->tiposFamilias();
		$this->set(compact('info'));
	}

	/**
	 * Gráfico de familias allegadas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function familias_allegadas() {
		$info = $this->Grafico->familiasAllegadas();
		$this->set(compact('info'));
	}

	/**
	 * Gráfico de factores protectores
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function factores_protectores() {
		if ($this->request->is('post')) {
			$cefa_id = $this->request->data['Grafico']['cefa_id'];
			$ano_id = $this->request->data['Grafico']['ano_id'];
			$grob_id = $this->request->data['Grafico']['grob_id'];
            $nive_id = $this->request->data['Grafico']['nive_id'];
            $fapr_id = $this->request->data['Grafico']['fapr_id'];

			$info = $this->Grafico->factoresProtectores($cefa_id, $grob_id, $nive_id, $fapr_id, $ano_id);
			$this->set(compact('info'));
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_nombre' => 'ASC'
				)
			)
		);

		$gruposObjetivos = $this->GrupoObjetivo->find('list',
			array(
				'order' => array(
					'GrupoObjetivo.grob_nombre' => 'ASC'
				)
			)
		);

		$this->set(compact('centrosFamiliares', 'gruposObjetivos'));
	}

	/**
	 * Gráfico de cantidad de hombres y mujeres por centro
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function cantidad_hombres_mujeres() {
		$centrosFamiliares = $this->CentroFamiliar->find('all',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden' => 'ASC'
				)
			)
		);

		$info = $this->Grafico->cantHombresMujeresPorCentro();
		$this->set(compact('centrosFamiliares', 'info'));
	}

	/**
	 * Gráfico de factores de riesgos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function factores_riesgos() {
		if ($this->request->is('post')) {
			$cefa_id = $this->request->data['Grafico']['cefa_id'];
			$fari_id = $this->request->data['Grafico']['fari_id'];

			$info = $this->Grafico->cantFactoresRiesgos($cefa_id, $fari_id);
			$this->set(compact('info'));
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);

		$factoresRiesgos = $this->FactorRiesgo->find('list',
			array(
				'order' => array(
					'FactorRiesgo.fari_descripcion'
				)
			)
		);		
		$this->set(compact('centrosFamiliares', 'factoresRiesgos'));
	}
}