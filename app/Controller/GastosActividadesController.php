<?php

class GastosActividadesController extends AppController {
	/**
	 * Modelos a usar
	 *
	 * @var array
	 */
	public $uses = array('GastoActividad');

	/**
	 * Método elimina un gasto de actividad
	 *
	 * @author maraya-gómez
	 * @return string
	 */
	public function delete() {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$this->GastoActividad->id = $this->request->data['gaac_id'];
			if ($this->GastoActividad->delete()) {
				$ret = 'ok';
			} else {
				$ret = 'error';
			}

			return json_encode(array('ret' => $ret));
		}
	}
}