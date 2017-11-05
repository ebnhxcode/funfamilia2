<?php

class DireccionesController extends AppController {
	/**
	 * Modelos a usar
	 *
	 * @var array
	 */
	public $uses = array('Direccion');

	/**
	 * Método encuentra direcciones según query (typeahead)
	 * 
	 * @author maraya-gómez
	 * @return string
	 */
	public function find_direcciones() {
		$this->autoRender = false;

		if ($this->request->is('get')) {
			$query = strtolower($this->request->query['q']);
			$comu_id = $this->request->query['comu_id'];

			$options = array(
				'fields' => array(
					'Direccion.dire_id',
					'Direccion.dire_direccion'
				),
				'conditions' => array(
					'LOWER(dire_direccion) LIKE \'%'. $query .'%\'' 
				)
			);

			if (!empty($comu_id)) {
				$options['conditions']['Direccion.comu_id'] = $comu_id;
			}

			$direcciones = $this->Direccion->find('first', $options);
			
			return json_encode($direcciones);
		}
	}
}