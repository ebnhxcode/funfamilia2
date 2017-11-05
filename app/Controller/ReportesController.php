<?php

App::import('Vendor', 'PHPExcel/PHPExcel');
App::uses('CakeTime', 'Utility');
set_time_limit(0);

class ReportesController extends AppController {

	/**
	 * Modelos a usar
	 * 
	 * @var array
	 */
	public $uses = array(
		'CentroFamiliar',
		'Reporte'
	);

	/**
	 * Pinta reporte en excel de cobertura de personas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function coberturas_personas() {
		
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];

			$info = $this->Reporte->coberturaPersonas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cobertura personas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', sprintf('Reporte Coberturas de Personas'));

			$sheet->getColumnDimension('A')->setAutoSize(true);
			
			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:O8')->applyFromArray($cabStyle);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Total Personas');
			$sheet->SetCellValue('C8', 'Total Cobertura Actividades Masivas');
			$sheet->SetCellValue('D8', 'Total Familias Participantes');
			$sheet->SetCellValue('E8', 'Total Familias');
			$sheet->SetCellValue('F8', 'Total Hombres (0-15)');
			$sheet->SetCellValue('G8', 'Total Hombres (16-24)');
			$sheet->SetCellValue('H8', 'Total Hombres (25-60)');
			$sheet->SetCellValue('I8', 'Total Hombres (61-+)');
			$sheet->SetCellValue('J8', 'Total Mujeres (0-15)');
			$sheet->SetCellValue('K8', 'Total Mujeres (16-24)');
			$sheet->SetCellValue('L8', 'Total Mujeres (25-60)');
			$sheet->SetCellValue('M8', 'Total Mujeres (61-+)');
			$sheet->SetCellValue('N8', 'Total Hombres (sin información)');
			$sheet->SetCellValue('O8', 'Total Mujeres (sin información)');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:O8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('J4', date('d-m-Y H:i:s'));

			$totalPersonas = 0;
			$totalFamilias = 0;
			$totalFamilias2 = 0;
			$totalHombres0_15 = 0;
			$totalHombres16_24 = 0;
			$totalHombres25_60 = 0;
			$totalHombres61_ = 0;
			$totalMujeres0_15 = 0;
			$totalMujeres16_24 = 0;
			$totalMujeres25_60 = 0;
			$totalMujeres61_ = 0;
			$totalHombresSinInfo = 0;
			$totalMujeresSinInfo = 0;
			$totalCoberturaActividadesMasivas = 0;

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['total_personas']);
				$sheet->SetCellValue('C'.$row_count, $row['total_cobertura_estimada']);
				$sheet->SetCellValue('D'.$row_count, $row['total_familias']);
				$sheet->SetCellValue('E'.$row_count, $row['total_familias2']);
				$sheet->SetCellValue('F'.$row_count, $row['total_hombres_0_15']);
				$sheet->SetCellValue('G'.$row_count, $row['total_hombres_16_24']);
				$sheet->SetCellValue('H'.$row_count, $row['total_hombres_25_60']);
				$sheet->SetCellValue('I'.$row_count, $row['total_hombres_61_mas']);
				$sheet->SetCellValue('J'.$row_count, $row['total_mujeres_0_15']);
				$sheet->SetCellValue('K'.$row_count, $row['total_mujeres_16_24']);
				$sheet->SetCellValue('L'.$row_count, $row['total_mujeres_25_60']);
				$sheet->SetCellValue('M'.$row_count, $row['total_mujeres_61_mas']);
				$sheet->SetCellValue('N'.$row_count, $row['total_hombres_sin_info']);
				$sheet->SetCellValue('O'.$row_count, $row['total_mujeres_sin_info']);

				// sacamos los totales
				$totalPersonas += $row['total_personas'];
				$totalFamilias += $row['total_familias'];
				$totalFamilias2 += $row['total_familias2'];
				$totalHombres0_15 += $row['total_hombres_0_15'];
				$totalHombres16_24 += $row['total_hombres_16_24'];
				$totalHombres25_60 += $row['total_hombres_25_60'];
				$totalHombres61_ += $row['total_hombres_61_mas'];
				$totalMujeres0_15 += $row['total_mujeres_0_15'];
				$totalMujeres16_24 += $row['total_mujeres_16_24'];
				$totalMujeres25_60 += $row['total_mujeres_25_60'];
				$totalMujeres61_ += $row['total_mujeres_61_mas'];
				$totalHombresSinInfo += $row['total_hombres_sin_info'];
				$totalMujeresSinInfo += $row['total_mujeres_sin_info'];
				$totalCoberturaActividadesMasivas += $row['total_cobertura_estimada'];

				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			$sheet->getStyle('A8:N'.($row_count-1))->applyFromArray($bodyStyle);

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalPersonas);
			$sheet->SetCellValue('C'.($row_count+1), $totalCoberturaActividadesMasivas);
			$sheet->SetCellValue('D'.($row_count+1), $totalFamilias);
			$sheet->SetCellValue('E'.($row_count+1), $totalFamilias2);
			$sheet->SetCellValue('F'.($row_count+1), $totalHombres0_15);
			$sheet->SetCellValue('G'.($row_count+1), $totalHombres16_24);
			$sheet->SetCellValue('H'.($row_count+1), $totalHombres25_60);
			$sheet->SetCellValue('I'.($row_count+1), $totalHombres61_);
			$sheet->SetCellValue('J'.($row_count+1), $totalMujeres0_15);
			$sheet->SetCellValue('K'.($row_count+1), $totalMujeres16_24);
			$sheet->SetCellValue('L'.($row_count+1), $totalMujeres25_60);
			$sheet->SetCellValue('M'.($row_count+1), $totalMujeres61_);
			$sheet->SetCellValue('N'.($row_count+1), $totalHombresSinInfo);
			$sheet->SetCellValue('O'.($row_count+1), $totalMujeresSinInfo);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_cobertura_personas.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');

		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte en excel de actividades
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function actividades() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id =  empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->actividades($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte actividades");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', sprintf('Reporte de Actividades'));

			$sheet->getColumnDimension('A')->setAutoSize(true);

			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Total Actividades');
			$sheet->getStyle('A8:B8')->applyFromArray($cabStyle);
			//$sheet->setAutoFilter('A8:B8');

			// tomamos el total de tipos de actividades para pintar las cabeceras
			$countCol = 2;
			foreach ($info[0][0] as $key => $val) {
				if (preg_match('/^tiac_/', $key)) {
					$key = ucwords(str_replace('_', ' ', substr($key, 5)));
					$sheet->setCellValueByColumnAndRow($countCol, 8, $key)->getStyleByColumnAndRow($countCol, 8)->applyFromArray($cabStyle);
					$countCol++;
				}
			}

			// tomamos el total de areas para pintar las cabeceras
			foreach ($info[0][0] as $key => $val) {
				if (preg_match('/^area_/', $key)) {
					$key = ucwords(str_replace('_', ' ', substr($key, 5)));
					$sheet->setCellValueByColumnAndRow($countCol, 8, $key)->getStyleByColumnAndRow($countCol, 8)->applyFromArray($cabStyle);
					$countCol++;
				}
			}
		
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {
				$row = array_pop($row);
				$countCol = 0;

				foreach ($row as $key => $val) {
					$sheet->setCellValueByColumnAndRow($countCol, $row_count, $val)->getStyleByColumnAndRow($countCol, $row_count)->applyFromArray($bodyStyle);
					$countCol++;
				}

				$row_count++;				
			}

			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_de_actividades.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de personas por areas y tipos de actividad
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function coberturas_personas_areas_tipos_actividad() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id =  empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->coberturasPersonasAreasTiposActividad($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);
			
			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte cobertura personas area tipo actividad");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', sprintf('Reporte de Cobertura de Personas por área y tipo de actividad'));

			$sheet->getColumnDimension('A')->setAutoSize(true);

			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->getStyle('A8:A8')->applyFromArray($cabStyle);
			//$sheet->setAutoFilter('A8:A8');

			// tomamos el total de tipos de actividades para pintar las cabeceras
			$countCol = 1;
			foreach ($info[0][0] as $key => $val) {
				if (preg_match('/^tiac_/', $key)) {
					$key = ucwords(str_replace('_', ' ', substr($key, 5)));
					$sheet->setCellValueByColumnAndRow($countCol, 8, $key)->getStyleByColumnAndRow($countCol, 8)->applyFromArray($cabStyle);
					$countCol++;
				}
			}

			// tomamos el total de areas para pintar las cabeceras
			foreach ($info[0][0] as $key => $val) {
				if (preg_match('/^area_/', $key)) {
					$key = ucwords(str_replace('_', ' ', substr($key, 5)));
					$sheet->setCellValueByColumnAndRow($countCol, 8, $key)->getStyleByColumnAndRow($countCol, 8)->applyFromArray($cabStyle);
					$countCol++;
				}
			}
		
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F1', date('d-m-Y H:i:s'));

			foreach ($info as $row) {
				$row = array_pop($row);
				$countCol = 0;

				foreach ($row as $key => $val) {
					$sheet->setCellValueByColumnAndRow($countCol, $row_count, $val)->getStyleByColumnAndRow($countCol, $row_count)->applyFromArray($bodyStyle);
					$countCol++;
				}

				$row_count++;				
			}

			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_cobertura_personas_area_tipo_actividad.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));

	}

	/**
	 * Pinta reporte de actividades individuales y masivas (ex prestaciones I)
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function actividades_individuales_masivas() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->actividadesIndividualesMasivas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cobertura personas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', sprintf('Reporte de Actividadas individuales y masivas'));

			$sheet->getColumnDimension('A')->setAutoSize(true);
			
			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:C8')->applyFromArray($cabStyle);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Individuales');
			$sheet->SetCellValue('C8', 'Masivas');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:C8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			$totalIndividuales = 0;
			$totalMasivas = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['total_individuales']);
				$sheet->SetCellValue('C'.$row_count, $row['total_masivas']);

				// sumamos totales
				$totalIndividuales += $row['total_individuales'];
				$totalMasivas += $row['total_masivas'];

				$row_count++;
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalIndividuales);
			$sheet->SetCellValue('C'.($row_count+1), $totalMasivas);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:C'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_actividades_individuales_masivas.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);

		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de prestaciones II
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function prestaciones_II() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];			
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->prestacionesII($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml prestaciones II");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', sprintf('Reporte de Prestaciones II'));

			$sheet->getColumnDimension('A')->setAutoSize(true);
			
			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:I8')->applyFromArray($cabStyle);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Familia (Apellido Paterno)');
			$sheet->SetCellValue('C8', 'Familia (Apellido Materno)');
			$sheet->SetCellValue('D8', 'Apellido Paterno');
			$sheet->SetCellValue('E8', 'Apellido Materno');
			$sheet->SetCellValue('F8', 'Nombres');
			$sheet->SetCellValue('G8', 'Sexo');
			$sheet->SetCellValue('H8', 'N° Actividades');
			$sheet->SetCellValue('I8', 'N° Prestaciones');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:I8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			$totalActividades = 0;
			$totalPrestaciones = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				// perfil_comuna
				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['fami_ap_paterno']);
						$sheet->SetCellValue('C'.$row_count, $row['fami_ap_materno']);
						$sheet->SetCellValue('D'.$row_count, $row['pers_ap_paterno']);
						$sheet->SetCellValue('E'.$row_count, $row['pers_ap_materno']);
						$sheet->SetCellValue('F'.$row_count, $row['pers_nombres']);
						$sheet->SetCellValue('G'.$row_count, $row['sexo_nombre']);
						$sheet->SetCellValue('H'.$row_count, $row['nro_actividades']);
						$sheet->SetCellValue('I'.$row_count, $row['nro_prestaciones']);
						$row_count++;
					}

				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['fami_ap_paterno']);
					$sheet->SetCellValue('C'.$row_count, $row['fami_ap_materno']);
					$sheet->SetCellValue('D'.$row_count, $row['pers_ap_paterno']);
					$sheet->SetCellValue('E'.$row_count, $row['pers_ap_materno']);
					$sheet->SetCellValue('F'.$row_count, $row['pers_nombres']);
					$sheet->SetCellValue('G'.$row_count, $row['sexo_nombre']);
					$sheet->SetCellValue('H'.$row_count, $row['nro_actividades']);
					$sheet->SetCellValue('I'.$row_count, $row['nro_prestaciones']);
					$row_count++;
				}

				// suma de totales
				$totalActividades += $row['nro_actividades'];
				$totalPrestaciones += $row['nro_prestaciones'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('H'.($row_count+1), $totalActividades);
			$sheet->SetCellValue('I'.($row_count+1), $totalPrestaciones);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:I'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_prestaciones_II.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de participantes I
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function participantes_I() {
		if ($this->request->is('post')) {
			ini_set('memory_limit', '1024M');
			set_time_limit(0);
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->participantesI($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '16MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cobertura personas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Detalle Actividades por Participantes');

			$sheet->getColumnDimension('A')->setAutoSize(true);
			
			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:L8')->applyFromArray($cabStyle);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'RUN');
			$sheet->SetCellValue('C8', 'DV');
			$sheet->SetCellValue('D8', 'Nombres');
			$sheet->SetCellValue('E8', 'Apellido Paterno');
			$sheet->SetCellValue('F8', 'Apellido Materno');
			$sheet->SetCellValue('G8', 'Sexo');			
			$sheet->SetCellValue('H8', 'Familia (Apellido Paterno)');
			$sheet->SetCellValue('I8', 'Familia (Apellido Materno)');
			$sheet->SetCellValue('J8', 'Actividad');
			$sheet->SetCellValue('K8', 'N° Sesión');
			$sheet->SetCellValue('L8', 'Año Prestación');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:F8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['pers_run']);
						$sheet->SetCellValue('C'.$row_count, $row['pers_run_dv']);
						$sheet->SetCellValue('D'.$row_count, $row['pers_nombres']);
						$sheet->SetCellValue('E'.$row_count, $row['pers_ap_paterno']);
						$sheet->SetCellValue('F'.$row_count, $row['pers_ap_materno']);
						$sheet->SetCellValue('G'.$row_count, $row['sexo_nombre']);
						$sheet->SetCellValue('H'.$row_count, $row['fami_ap_paterno']);
						$sheet->SetCellValue('I'.$row_count, $row['fami_ap_materno']);
						$sheet->SetCellValue('J'.$row_count, $row['acti_nombre']);
						$sheet->SetCellValue('K'.$row_count, $row['sesi_nombre']);
						$sheet->SetCellValue('L'.$row_count, $row['anyo_prestacion']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['pers_run']);
					$sheet->SetCellValue('C'.$row_count, $row['pers_run_dv']);
					$sheet->SetCellValue('D'.$row_count, $row['pers_nombres']);
					$sheet->SetCellValue('E'.$row_count, $row['pers_ap_paterno']);
					$sheet->SetCellValue('F'.$row_count, $row['pers_ap_materno']);
					$sheet->SetCellValue('G'.$row_count, $row['sexo_nombre']);
					$sheet->SetCellValue('H'.$row_count, $row['fami_ap_paterno']);
					$sheet->SetCellValue('I'.$row_count, $row['fami_ap_materno']);
					$sheet->SetCellValue('J'.$row_count, $row['acti_nombre']);
					$sheet->SetCellValue('K'.$row_count, $row['sesi_nombre']);
					$sheet->SetCellValue('L'.$row_count, $row['anyo_prestacion']);
					$row_count++;
				}
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:L'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=detalle_actividades_x_participantes.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
				$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);

		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de participantes II
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function participantes_II() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$info = $this->Reporte->participantesII($desde, $hasta);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cobertura personas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de participantes II');

			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			
			// cabeceras	
			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:I8')->applyFromArray($cabStyle);
			
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Area');
			$sheet->SetCellValue('C8', 'Tipo de Actividad');
			$sheet->SetCellValue('D8', 'Actividad');
			$sheet->SetCellValue('E8', 'Apellido Paterno');
			$sheet->SetCellValue('F8', 'Apellido Materno');
			$sheet->SetCellValue('G8', 'Nombres');
			$sheet->SetCellValue('H8', 'Sexo');
			$sheet->SetCellValue('I8', 'N° de Sesiones');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:I8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			$totalSesiones = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['area_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['tiac_nombre']);
						$sheet->SetCellValue('D'.$row_count, $row['acti_nombre']);
						$sheet->SetCellValue('E'.$row_count, $row['pers_ap_paterno']);
						$sheet->SetCellValue('F'.$row_count, $row['pers_ap_materno']);
						$sheet->SetCellValue('G'.$row_count, $row['pers_nombres']);
						$sheet->SetCellValue('H'.$row_count, $row['sexo_nombre']);
						$sheet->SetCellValue('I'.$row_count, $row['nro_sesiones']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['area_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['tiac_nombre']);
					$sheet->SetCellValue('D'.$row_count, $row['acti_nombre']);
					$sheet->SetCellValue('E'.$row_count, $row['pers_ap_paterno']);
					$sheet->SetCellValue('F'.$row_count, $row['pers_ap_materno']);
					$sheet->SetCellValue('G'.$row_count, $row['pers_nombres']);
					$sheet->SetCellValue('H'.$row_count, $row['sexo_nombre']);
					$sheet->SetCellValue('I'.$row_count, $row['nro_sesiones']);
					$row_count++;
				}

				// suma de totales
				$totalSesiones += $row['nro_sesiones'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('I'.($row_count+1), $totalSesiones);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:I'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_participantes_II.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
	}

	/**
	 * Pinta reporte de consulta HH
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function consulta_hh() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];			
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];			
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->consultaHH($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml instituciones");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Consulta HH');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:F8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Area');
			$sheet->SetCellValue('C8', 'Tipo de Actividad');
			$sheet->SetCellValue('D8', 'Actividad');
			$sheet->SetCellValue('E8', 'Monitor');
			$sheet->SetCellValue('F8', 'Horas Monitor');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:F8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			$totalHorasMonitor = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['area_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['tiac_nombre']);
						$sheet->SetCellValue('D'.$row_count, $row['acti_nombre']);
						$sheet->SetCellValue('E'.$row_count, $row['monitor']);
						$sheet->SetCellValue('F'.$row_count, $row['horas_monitor']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['area_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['tiac_nombre']);
					$sheet->SetCellValue('D'.$row_count, $row['acti_nombre']);
					$sheet->SetCellValue('E'.$row_count, $row['monitor']);
					$sheet->SetCellValue('F'.$row_count, $row['horas_monitor']);
					$row_count++;
				}

				// sumamos totales
				$totalHorasMonitor += $row['horas_monitor'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('F'.($row_count+1), $totalHorasMonitor);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:F'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=consulta_hh.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);

		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));

	}

	/**
	 * Pinta reporte de redes II
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function redes_II() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];			
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];	
			
			$info = $this->Reporte->redesII($desde, $hasta, $cefa_id, $regi_id, $comu_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml instituciones");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Redes II');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:C8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Red');
			$sheet->SetCellValue('C8', 'N° de Familias');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:C8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			$totalRedes = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['rede_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['total']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['rede_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['total']);
					$row_count++;
				}

				// suma de totales
				$totalRedes += $row['total'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('C'.($row_count+1), $totalRedes);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:C'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_redes_II.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de instituciones
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function instituciones() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->instituciones($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml instituciones");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Instituciones');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:C8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Institución');
			$sheet->SetCellValue('C8', 'N° de Actividades');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:C8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			$totalInstituciones = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['inst_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['total']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['inst_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['total']);
					$row_count++;
				}
				// suma de totales
				$totalInstituciones += $row['total'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('C'.($row_count+1), $totalInstituciones);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:C'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_instituciones.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de sesiones ejecutadas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function sesiones_ejecutadas() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];			
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];			
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->sesionesEjecutadas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);
			
			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml sesiones ejecutadas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

			// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Consulta de Sesiones Ejecutadas');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:D8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Actividad');
			$sheet->SetCellValue('C8', 'N° de Sesiones Planificadas');
			$sheet->SetCellValue('D8', 'N° de Sesiones Ejecutadas');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:D8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			$totalNroSesiones = 0;
			$totalSesiEjecutadas = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['acti_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['acti_nro_sesiones']);
						$sheet->SetCellValue('D'.$row_count, $row['sesiones_ejecutadas']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['acti_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['acti_nro_sesiones']);
					$sheet->SetCellValue('D'.$row_count, $row['sesiones_ejecutadas']);
					$row_count++;
				}

				// suma de totales
				$totalNroSesiones += $row['acti_nro_sesiones'];
				$totalSesiEjecutadas += $row['sesiones_ejecutadas'];
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('C'.($row_count+1), $totalNroSesiones);
			$sheet->SetCellValue('D'.($row_count+1), $totalSesiEjecutadas);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:D'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=consulta_sesiones_ejecutadas.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de cantidad de fichas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function cantidad_fichas() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->cantidadFichas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cantidad fichas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Cantidad de Fichas');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:J8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Total personas con ficha');
			$sheet->SetCellValue('C8', 'Total niños con ficha de evaluación diagnóstica y final');
			$sheet->SetCellValue('D8', 'Total niños con ficha de evaluación diagnóstica');
			$sheet->SetCellValue('E8', 'Total jóvenes con ficha de evaluación diagnóstica y final');
			$sheet->SetCellValue('F8', 'Total jóvenes con ficha de evaluación diagnóstica');
			$sheet->SetCellValue('G8', 'Total adultos con ficha de evaluación diagnóstica y final');
			$sheet->SetCellValue('H8', 'Total adultos con ficha de evaluación diagnóstica');
			$sheet->SetCellValue('I8', 'Total personas mayores con ficha de evaluación diagnóstica y final');
			$sheet->SetCellValue('J8', 'Total personas mayores con ficha de evaluación diagnóstica');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:J8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			$totalPersonas = 0;
			$totalNinosDiagFinal = 0;
			$totalNinosDiag = 0;
			$totalJovenesDiagFinal = 0;
			$totalJovenesDiag = 0;
			$totalAdultosDiagFinal = 0;
			$totalAdultosDiag = 0;
			$totalMayoresDiagFinal = 0;
			$totalMayoresDiag = 0;

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['total_personas']);
				$sheet->SetCellValue('C'.$row_count, $row['total_ninos_diag_final']);
				$sheet->SetCellValue('D'.$row_count, $row['total_ninos_diag']);
				$sheet->SetCellValue('E'.$row_count, $row['total_jovenes_diag_final']);
				$sheet->SetCellValue('F'.$row_count, $row['total_jovenes_diag']);
				$sheet->SetCellValue('G'.$row_count, $row['total_adultos_diag_final']);
				$sheet->SetCellValue('H'.$row_count, $row['total_adultos_diag']);
				$sheet->SetCellValue('I'.$row_count, $row['total_mayores_diag_final']);
				$sheet->SetCellValue('J'.$row_count, $row['total_mayores_diag']);

				// suma de totales
				$totalPersonas += $row['total_personas'];
				$totalNinosDiagFinal += $row['total_ninos_diag_final'];
				$totalNinosDiag += $row['total_ninos_diag'];
				$totalJovenesDiagFinal += $row['total_jovenes_diag_final'];
				$totalJovenesDiag += $row['total_jovenes_diag'];
				$totalAdultosDiagFinal += $row['total_adultos_diag_final'];
				$totalAdultosDiag += $row['total_adultos_diag'];
				$totalMayoresDiagFinal += $row['total_mayores_diag_final'];
				$totalMayoresDiag += $row['total_mayores_diag'];

				$row_count++;
			}

			// calculo de porcentajes totales
			$totalPorcNinosDiagFinal = ($totalPersonas == 0)? 0: ($totalNinosDiagFinal*100)/$totalPersonas;
			$totalPorcNinosDiag = ($totalPersonas == 0)? 0: ($totalNinosDiag*100)/$totalPersonas;
			$totalPorcJovenesDiagFinal = ($totalPersonas == 0)? 0: ($totalJovenesDiagFinal*100)/$totalPersonas;
			$totalPorcJovenesDiag = ($totalPersonas == 0)? 0: ($totalJovenesDiag*100)/$totalPersonas;
			$totalPorcAdultosDiagFinal = ($totalPersonas == 0)? 0: ($totalAdultosDiagFinal*100)/$totalPersonas;
			$totalPorcAdultosDiag = ($totalPersonas == 0)? 0: ($totalAdultosDiag*100)/$totalPersonas;
			$totalPorcMayoresDiagFinal = ($totalPersonas == 0)? 0: ($totalMayoresDiagFinal*100)/$totalPersonas;
			$totalPorcMayoresDiag = ($totalPersonas == 0)? 0: ($totalMayoresDiag*100)/$totalPersonas;

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('A'.($row_count+2), 'Porcentajes');
			$sheet->SetCellValue('B'.($row_count+1), $totalPersonas);
			$sheet->SetCellValue('B'.($row_count+2), '100%');
			$sheet->SetCellValue('C'.($row_count+1), $totalNinosDiagFinal);
			$sheet->SetCellValue('C'.($row_count+2), $totalPorcNinosDiagFinal .'%');
			$sheet->SetCellValue('D'.($row_count+1), $totalNinosDiag);
			$sheet->SetCellValue('D'.($row_count+2), $totalPorcNinosDiag .'%');
			$sheet->SetCellValue('E'.($row_count+1), $totalJovenesDiagFinal);
			$sheet->SetCellValue('E'.($row_count+2), $totalPorcJovenesDiagFinal .'%');
			$sheet->SetCellValue('F'.($row_count+1), $totalJovenesDiag);
			$sheet->SetCellValue('F'.($row_count+2), $totalPorcJovenesDiag .'%');
			$sheet->SetCellValue('G'.($row_count+1), $totalAdultosDiagFinal);
			$sheet->SetCellValue('G'.($row_count+2), $totalPorcAdultosDiagFinal .'%');
			$sheet->SetCellValue('H'.($row_count+1), $totalAdultosDiag);
			$sheet->SetCellValue('H'.($row_count+2), $totalPorcAdultosDiag .'%');
			$sheet->SetCellValue('I'.($row_count+1), $totalMayoresDiagFinal);
			$sheet->SetCellValue('I'.($row_count+2), $totalPorcMayoresDiagFinal .'%');
			$sheet->SetCellValue('J'.($row_count+1), $totalMayoresDiag);
			$sheet->SetCellValue('J'.($row_count+2), $totalPorcMayoresDiag .'%');

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:J'.($row_count-1))->applyFromArray($bodyStyle);
			//fix alignment for fields
			$sheet->getStyle('B9:J'.($row_count+2))->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=cantidad_fichas.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de tipos de familias
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function tipos_familias() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			
			$info = $this->Reporte->tiposFamilias($desde, $hasta, $cefa_id, $regi_id, $comu_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml cantidad fichas");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Tipos de Familias');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:Q8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Porcentaje familias unipersonal');
			$sheet->SetCellValue('C8', 'Total familias unipersonal');
			$sheet->SetCellValue('D8', 'Porcentaje familias nuclear simple (sin hijos)'); //fix from here
			$sheet->SetCellValue('E8', 'Total familias nuclear simple (sin hijos)');
			$sheet->SetCellValue('F8', 'Porcentaje familias nuclear biparental (con hijos)');
			$sheet->SetCellValue('G8', 'Total familias nuclear biparental (con hijos)');
			$sheet->SetCellValue('H8', 'Porcentaje familias monoparental (madre)');
			$sheet->SetCellValue('I8', 'Total familias monoparental (madre)');
			$sheet->SetCellValue('J8', 'Porcentaje familias monoparental (padre)');
			$sheet->SetCellValue('K8', 'Total familias monoparental (padre)');
			$sheet->SetCellValue('L8', 'Porcentaje familias monoparental (abuelo/a)');
			$sheet->SetCellValue('M8', 'Total familias monoparental (abuelo/a)');
			$sheet->SetCellValue('N8', 'Porcentaje familias extendida');
			$sheet->SetCellValue('O8', 'Porcentaje familias extendida');
			$sheet->SetCellValue('P8', 'Otras (porcentaje');
			$sheet->SetCellValue('Q8', 'Otras (total)');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:Q8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			$totalPromPersonas = 0;
			$totalUnipersonal = 0;
			$totalNuclearSimple = 0;
			$totalNuclearBiparental = 0;
			$totalMonoparentalMadre = 0;
			$totalMonoParentalPadre = 0;
			$totalMonoParentalAbuelo = 0;
			$totalExtendida = 0;
			$totalOtros = 0;

			$totalUnipersonal = 0;
			$totalPorcNuclearSimple = 0;
			$totalPorcUnipersonal = 0;
			$totalPorcNuclearBiparental = 0;
			$totalPorcMonoparentalMadre = 0;
			$totalPorcMonoParentalPadre = 0;
			$totalPorcMonoParentalAbuelo = 0;
			$totalPorcExtendida = 0;
			$totalPorcOtros = 0;

			foreach ($info as $row) {			
				$row = array_pop($row);

				$total_familias = $row['total_familias'];
				$porc_unipersonal = ($total_familias == 0)? 0: ($row['total_unipersonal']*100)/$total_familias;
				$porc_nuclear_simple = ($total_familias == 0)? 0: ($row['total_nuclear_simple']*100)/$total_familias;
				$porc_nuclear_biparental = ($total_familias == 0)? 0: ($row['total_nuclear_biparental']*100)/$total_familias;
				$porc_monoparental_madre = ($total_familias == 0)? 0: ($row['total_monoparental_madre']*100)/$total_familias;
				$porc_monoparental_padre = ($total_familias == 0)? 0: ($row['total_monoparental_padre']*100)/$total_familias;
				$porc_monoparental_abuelo = ($total_familias == 0)? 0: ($row['total_monoparental_abuelo']*100)/$total_familias;
				$porc_extendida = ($total_familias == 0)? 0: ($row['total_extendida']*100)/$total_familias;
				$porc_otros = ($total_familias == 0)? 0: ($row['total_otros']*100)/$total_familias;

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $porc_unipersonal.'%');
				$sheet->SetCellValue('C'.$row_count, $row['total_unipersonal']);
				$sheet->SetCellValue('D'.$row_count, $porc_nuclear_simple.'%');
				$sheet->SetCellValue('E'.$row_count, $row['total_nuclear_simple']);
				$sheet->SetCellValue('F'.$row_count, $porc_nuclear_biparental.'%');
				$sheet->SetCellValue('G'.$row_count, $row['total_nuclear_biparental']);
				$sheet->SetCellValue('H'.$row_count, $porc_monoparental_madre.'%');
				$sheet->SetCellValue('I'.$row_count, $row['total_monoparental_madre']);
				$sheet->SetCellValue('J'.$row_count, $porc_monoparental_padre.'%');
				$sheet->SetCellValue('K'.$row_count, $row['total_monoparental_padre']);
				$sheet->SetCellValue('L'.$row_count, $porc_monoparental_abuelo.'%');
				$sheet->SetCellValue('M'.$row_count, $row['total_monoparental_abuelo']);
				$sheet->SetCellValue('N'.$row_count, $porc_extendida.'%');
				$sheet->SetCellValue('O'.$row_count, $row['total_extendida']);
				$sheet->SetCellValue('P'.$row_count, $porc_otros.'%');
				$sheet->SetCellValue('Q'.$row_count, $row['total_otros']);

				// suma de totales
				$totalUnipersonal += $row['total_unipersonal'];
				$totalNuclearSimple += $row['total_nuclear_simple'];
				$totalNuclearBiparental += $row['total_nuclear_biparental'];
				$totalMonoparentalMadre += $row['total_monoparental_madre'];
				$totalMonoParentalPadre += $row['total_monoparental_padre'];
				$totalMonoParentalAbuelo += $row['total_monoparental_abuelo'];
				$totalExtendida += $row['total_extendida'];
				$totalOtros += $row['total_otros'];

				// suma de totales (porcentajes)
				$totalPorcUnipersonal += $porc_unipersonal;
				$totalPorcNuclearSimple += $porc_nuclear_simple;
				$totalPorcNuclearBiparental += $porc_nuclear_biparental;
				$totalPorcMonoparentalMadre += $porc_monoparental_madre;
				$totalPorcMonoParentalPadre += $porc_monoparental_padre;
				$totalPorcMonoParentalAbuelo += $porc_monoparental_abuelo;
				$totalPorcExtendida += $porc_extendida;
				$totalPorcOtros += $porc_otros;

				$row_count++;
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalPorcUnipersonal .'%');
			$sheet->SetCellValue('C'.($row_count+1), $totalUnipersonal);
			$sheet->SetCellValue('D'.($row_count+1), $totalPorcNuclearSimple .'%');
			$sheet->SetCellValue('E'.($row_count+1), $totalNuclearSimple);
			$sheet->SetCellValue('F'.($row_count+1), $totalPorcNuclearBiparental .'%');
			$sheet->SetCellValue('G'.($row_count+1), $totalNuclearBiparental);
			$sheet->SetCellValue('H'.($row_count+1), $totalPorcMonoparentalMadre .'%');
			$sheet->SetCellValue('I'.($row_count+1), $totalMonoparentalMadre);
			$sheet->SetCellValue('J'.($row_count+1), $totalPorcMonoParentalPadre .'%');
			$sheet->SetCellValue('K'.($row_count+1), $totalMonoParentalPadre);
			$sheet->SetCellValue('L'.($row_count+1), $totalPorcMonoParentalAbuelo .'%');
			$sheet->SetCellValue('M'.($row_count+1), $totalPorcMonoParentalAbuelo);
			$sheet->SetCellValue('N'.($row_count+1), $totalPorcExtendida .'%');
			$sheet->SetCellValue('O'.($row_count+1), $totalExtendida);
			$sheet->SetCellValue('P'.($row_count+1), $totalPorcOtros .'%');
			$sheet->SetCellValue('Q'.($row_count+1), $totalOtros);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:Q'.($row_count-1))->applyFromArray($bodyStyle);
			//fix alignment for fields
			$sheet->getStyle('B9:Q'.($row_count+1))->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=tipos_familias.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de relación familia
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function relacion_familia() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			
			$info = $this->Reporte->relacionFamilia($desde, $hasta, $cefa_id, $regi_id, $comu_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml relacion familia categorias diferentes");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Otros tipos de Familia');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:K8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Porcentaje familias pueblos originarios');
			$sheet->SetCellValue('C8', 'Total familias pueblos originarios');
			$sheet->SetCellValue('D8', 'Porcentaje familias inmigrantes');
			$sheet->SetCellValue('E8', 'Total familias inmigrantes');
			$sheet->SetCellValue('F8', 'Porcentaje familias integrantes con discapacidad');
			$sheet->SetCellValue('G8', 'Total familias integrantes con discapacidad');
			$sheet->SetCellValue('H8', 'Porcentaje familias jefatura de hogar femenino');
			$sheet->SetCellValue('I8', 'Total familias jefatura de hogar femenino');
			$sheet->SetCellValue('J8', 'Porcentaje familias jefatura de hogar masculino');
			$sheet->SetCellValue('K8', 'Total familias jefatura de hogar masculino');
			//skip a letter
			$sheet->SetCellValue('M8', 'Total Porcentajes');
			$sheet->SetCellValue('N8', 'Total Totales');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:K8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			$totalPueblosOriginarios = 0;
			$totalInmigrantes = 0;
			$totalDiscapacitados = 0;
			$totalJefeMujer = 0;
			$totalJefeHombre = 0;

			$totalPorcPueblosOriginarios = 0;
			$totalPorcInmigrantes = 0;
			$totalPorcDiscapacitados = 0;
			$totalPorcJefeMujer = 0;
			$totalPorcJefeHombre = 0;	

			foreach ($info as $row) {			
				$row = array_pop($row);
				
				$total_familias = $row['total_familias'];
				$porc_pueblos_originarios = ($total_familias == 0)? 0: ($row['total_pueblos_originarios']*100)/$total_familias;
				$porc_inmigrantes = ($total_familias == 0)? 0: ($row['total_inmigrantes']*100)/$total_familias;
				$porc_discapacitados = ($total_familias == 0)? 0: ($row['total_discapacitados']*100)/$total_familias;
				$porc_familias_jefe_mujer = ($total_familias == 0)? 0: ($row['total_familias_jefe_mujer']*100)/$total_familias;
				$porc_familias_jefe_hombre = ($total_familias == 0)? 0: ($row['total_familias_jefe_hombre']*100)/$total_familias;

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $porc_pueblos_originarios.'%');
				$sheet->SetCellValue('C'.$row_count, $row['total_pueblos_originarios']);
				$sheet->SetCellValue('D'.$row_count, $porc_inmigrantes.'%');
				$sheet->SetCellValue('E'.$row_count, $row['total_inmigrantes']);
				$sheet->SetCellValue('F'.$row_count, $porc_discapacitados.'%');
				$sheet->SetCellValue('G'.$row_count, $row['total_discapacitados']);
				$sheet->SetCellValue('H'.$row_count, $porc_familias_jefe_mujer.'%');
				$sheet->SetCellValue('I'.$row_count, $row['total_familias_jefe_mujer']);
				$sheet->SetCellValue('J'.$row_count, $porc_familias_jefe_hombre.'%');
				$sheet->SetCellValue('K'.$row_count, $row['total_familias_jefe_hombre']);

				// suma de totales
				$totalPueblosOriginarios += $row['total_pueblos_originarios'];
				$totalInmigrantes += $row['total_inmigrantes'];
				$totalDiscapacitados += $row['total_discapacitados'];
				$totalJefeMujer += $row['total_familias_jefe_mujer'];
				$totalJefeHombre += $row['total_familias_jefe_hombre'];

				// suma de totales (porcentajes)
				$totalPorcPueblosOriginarios += $porc_pueblos_originarios;
				$totalPorcInmigrantes += $porc_inmigrantes;
				$totalPorcDiscapacitados += $porc_discapacitados;
				$totalPorcJefeMujer += $porc_familias_jefe_mujer;
				$totalPorcJefeHombre += $porc_familias_jefe_hombre;

				$totalHorizontal = $row['total_pueblos_originarios'] + $row['total_inmigrantes'] + $row['total_discapacitados'] + $row['total_familias_jefe_mujer'] + $row['total_familias_jefe_hombre'];
				$totalPorcHorizontal = $porc_pueblos_originarios + $porc_inmigrantes + $porc_discapacitados + $porc_familias_jefe_mujer + $porc_familias_jefe_hombre;
				//Imprimir Totales x Fila
				$sheet->SetCellValue('M'.$row_count, $totalPorcHorizontal.'%');
				$sheet->SetCellValue('N'.$row_count, $totalHorizontal);

				$row_count++;
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalPorcPueblosOriginarios . '%');
			$sheet->SetCellValue('C'.($row_count+1), $totalPueblosOriginarios);
			$sheet->SetCellValue('D'.($row_count+1), $totalPorcInmigrantes . '%');
			$sheet->SetCellValue('E'.($row_count+1), $totalInmigrantes);
			$sheet->SetCellValue('F'.($row_count+1), $totalPorcDiscapacitados . '%');
			$sheet->SetCellValue('G'.($row_count+1), $totalDiscapacitados);
			$sheet->SetCellValue('H'.($row_count+1), $totalPorcJefeMujer . '%');
			$sheet->SetCellValue('I'.($row_count+1), $totalJefeMujer);
			$sheet->SetCellValue('J'.($row_count+1), $totalPorcJefeHombre . '%');
			$sheet->SetCellValue('K'.($row_count+1), $totalJefeHombre);

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:K'.($row_count-1))->applyFromArray($bodyStyle);
			//fix alignment for fields
			$sheet->getStyle('B9:K'.($row_count+1))->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=relacion_familia_categorias_diferentes.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de relación ficha/grupo objetivo
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function relacion_ficha() {

		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];			
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->relacionFicha($desde, $hasta, $cefa_id, $regi_id, $comu_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml relacion familia categorias diferentes");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Relación Fichas/Grupo Objetivo');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:I8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Total fichas niños(as)');
			$sheet->SetCellValue('C8', 'Porcentajes fichas niños(as)');
			$sheet->SetCellValue('D8', 'Total fichas jóvenes');
			$sheet->SetCellValue('E8', 'Porcentajes fichas jóvenes');
			$sheet->SetCellValue('F8', 'Total fichas adultos');
			$sheet->SetCellValue('G8', 'Porcentajes fichas adultos');
			$sheet->SetCellValue('H8', 'Total fichas adultos mayores');
			$sheet->SetCellValue('I8', 'Porcentajes fichas adultos mayores');
			//skip a column
			$sheet->SetCellValue('K8', 'Total Totales');
			$sheet->SetCellValue('L8', 'Total Porcentajes');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:I8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			$totalFichasNinos = 0;
			$totalFichasJovenes = 0;
			$totalFichasAdultos = 0;
			$totalFichasAdultosMayores = 0;

			$totalPorcFichasNinos = 0;
			$totalPorcFichasJovenes = 0;
			$totalPorcFichasAdultos = 0;
			$totalPorcFichasAdultosMayores = 0;

			foreach ($info as $row) {			
				$row = array_pop($row);

				$total_fichas = $row['total_fichas'];
				$porc_fichas_ninos = ($total_fichas == 0)? 0: ($row['total_fichas_ninos']*100)/$total_fichas;
				$porc_fichas_jovenes = ($total_fichas == 0)? 0: ($row['total_fichas_jovenes']*100)/$total_fichas;
				$porc_fichas_adultos = ($total_fichas == 0)? 0: ($row['total_fichas_adultos']*100)/$total_fichas;
				$porc_fichas_adultos_mayores = ($total_fichas == 0)? 0: ($row['total_fichas_adultos_mayores']*100)/$total_fichas;

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['total_fichas_ninos']);
				$sheet->SetCellValue('C'.$row_count, $porc_fichas_ninos.'%');
				$sheet->SetCellValue('D'.$row_count, $row['total_fichas_jovenes']);
				$sheet->SetCellValue('E'.$row_count, $porc_fichas_jovenes.'%');
				$sheet->SetCellValue('F'.$row_count, $row['total_fichas_adultos']);
				$sheet->SetCellValue('G'.$row_count, $porc_fichas_adultos.'%');
				$sheet->SetCellValue('H'.$row_count, $row['total_fichas_adultos_mayores']);
				$sheet->SetCellValue('I'.$row_count, $porc_fichas_adultos_mayores.'%');
				
				// total x centro
				$totalHorizontal = $row['total_fichas_ninos']+$row['total_fichas_jovenes']+$row['total_fichas_adultos']+$row['total_fichas_adultos_mayores'];
				$totalPorcHorizontal = $porc_fichas_ninos+$porc_fichas_jovenes+$porc_fichas_adultos+$porc_fichas_adultos_mayores;
				//Imprimir Totales x Fila
				$sheet->SetCellValue('K'.$row_count, $totalHorizontal);
				$sheet->SetCellValue('L'.$row_count, $totalPorcHorizontal .'%');

				// suma de totales
				$totalFichasNinos += $row['total_fichas_ninos'];
				$totalFichasJovenes += $row['total_fichas_jovenes'];
				$totalFichasAdultos += $row['total_fichas_adultos'];
				$totalFichasAdultosMayores += $row['total_fichas_adultos_mayores'];

				// suma de totales (porcentaje)
				$totalPorcFichasNinos += $porc_fichas_ninos;
				$totalPorcFichasJovenes += $porc_fichas_jovenes;
				$totalPorcFichasAdultos += $porc_fichas_adultos;
				$totalPorcFichasAdultosMayores += $porc_fichas_adultos_mayores;

				$row_count++;
			}

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalFichasNinos);
			$sheet->SetCellValue('C'.($row_count+1), $totalPorcFichasNinos .'%');
			$sheet->SetCellValue('D'.($row_count+1), $totalFichasJovenes);
			$sheet->SetCellValue('E'.($row_count+1), $totalPorcFichasJovenes .'%');
			$sheet->SetCellValue('F'.($row_count+1), $totalFichasAdultos);
			$sheet->SetCellValue('G'.($row_count+1), $totalPorcFichasAdultos .'%');
			$sheet->SetCellValue('H'.($row_count+1), $totalFichasAdultosMayores);
			$sheet->SetCellValue('I'.($row_count+1), $totalPorcFichasAdultosMayores .'%');

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:I'.($row_count-1))->applyFromArray($bodyStyle);
			//fix alignment for fields :D
			$sheet->getStyle('B9:L'.($row_count+1))->getAlignment()
		    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=relacion_fichas_grupo_objetivo.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'sexos'));
	}

	/**
	 * Pinta reporte de evaluación diagnóstica
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function evaluacion_diagnostica() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->evaluacionDiagnostica($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion diagnostica");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Resultados Evaluación Diagnóstica');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:E8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Niños(as)');
			$sheet->SetCellValue('C8', 'Jóvenes');
			$sheet->SetCellValue('D8', 'Adultos');
			$sheet->SetCellValue('E8', 'Personas Mayores');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:E8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('G1', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['promedio_ninos']);
				$sheet->SetCellValue('C'.$row_count, $row['promedio_jovenes']);
				$sheet->SetCellValue('D'.$row_count, $row['promedio_adultos']);
				$sheet->SetCellValue('E'.$row_count, $row['promedio_adultos_mayores']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:E'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=resultados_evaluacion_diagnostica.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de evaluación final
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function evaluacion_final() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->evaluacionFinal($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion final");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Resultados Evaluación Final');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:E8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Niños(as)');
			$sheet->SetCellValue('C8', 'Jóvenes');
			$sheet->SetCellValue('D8', 'Adultos');
			$sheet->SetCellValue('E8', 'Personas Mayores');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:E8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('G1', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['promedio_ninos']);
				$sheet->SetCellValue('C'.$row_count, $row['promedio_jovenes']);
				$sheet->SetCellValue('D'.$row_count, $row['promedio_adultos']);
				$sheet->SetCellValue('E'.$row_count, $row['promedio_adultos_mayores']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:E'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=resultados_evaluacion_final.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de evaluación de factores de riesgos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function factores_riesgos() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->evaluacionFactoresRiesgos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion final");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Resultados Factores Riesgos');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:I8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Niños(as) (presente)');
			$sheet->SetCellValue('C8', 'Jóvenes (presente)');
			$sheet->SetCellValue('D8', 'Adultos (presente)');
			$sheet->SetCellValue('E8', 'Personas Mayores (presente)');
			$sheet->SetCellValue('F8', 'Niños(as) (ausente)');
			$sheet->SetCellValue('G8', 'Jóvenes (ausente)');
			$sheet->SetCellValue('H8', 'Adultos (ausente)');
			$sheet->SetCellValue('I8', 'Personas Mayores (ausente)');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:I8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('G4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['promedio_presentes_ninos']);
				$sheet->SetCellValue('C'.$row_count, $row['promedio_presentes_jovenes']);
				$sheet->SetCellValue('D'.$row_count, $row['promedio_presentes_adultos']);
				$sheet->SetCellValue('E'.$row_count, $row['promedio_presentes_adultos_mayores']);
				$sheet->SetCellValue('F'.$row_count, $row['promedio_ausentes_ninos']);
				$sheet->SetCellValue('G'.$row_count, $row['promedio_ausentes_jovenes']);
				$sheet->SetCellValue('H'.$row_count, $row['promedio_ausentes_adultos']);
				$sheet->SetCellValue('I'.$row_count, $row['promedio_ausentes_adultos_mayores']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:I'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=resultados_factores_riesgos.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de evaluación de redes I
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function redes_I() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');			
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];			
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];	
			
			$info = $this->Reporte->redesI($desde, $hasta, $cefa_id, $regi_id, $comu_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion final");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte Redes I');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:E8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Red');
			$sheet->SetCellValue('C8', 'Familia Apellido Paterno');
			$sheet->SetCellValue('D8', 'Familia Apellido Materno');
			$sheet->SetCellValue('E8', 'Acción');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:E8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['rede_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['fami_ap_paterno']);
						$sheet->SetCellValue('D'.$row_count, $row['fami_ap_materno']);
						$sheet->SetCellValue('E'.$row_count, $row['fami_acciones']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['rede_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['fami_ap_paterno']);
					$sheet->SetCellValue('D'.$row_count, $row['fami_ap_materno']);
					$sheet->SetCellValue('E'.$row_count, $row['fami_acciones']);
					$row_count++;
				}
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:E'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=redes_I.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de evaluación de factores protectores
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function evaluacion_factores_protectores() {
		if ($this->request->is('post')) {
			$tipo = $this->request->data['Reporte']['tipo'];
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->evaluacionFactoresProtectores($desde, $hasta, $tipo, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion factores protectores");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Evaluación de Factores Protectores');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:J8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'RUN');
			$sheet->SetCellValue('C8', 'DV');
			$sheet->SetCellValue('D8', 'Nombres');
			$sheet->SetCellValue('E8', 'Apellido Paterno');
			$sheet->SetCellValue('F8', 'Apellido Materno');
			$sheet->SetCellValue('G8', 'Factor Protector');
			$sheet->SetCellValue('H8', 'Indicador');
			$sheet->SetCellValue('I8', 'Valor');
			$sheet->SetCellValue('J8', 'Observación');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:J8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('I4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['pers_run']);
				$sheet->SetCellValue('C'.$row_count, $row['pers_run_dv']);
				$sheet->SetCellValue('D'.$row_count, $row['pers_nombres']);
				$sheet->SetCellValue('E'.$row_count, $row['pers_ap_paterno']);
				$sheet->SetCellValue('F'.$row_count, $row['pers_ap_materno']);
				$sheet->SetCellValue('G'.$row_count, $row['fapr_nombre']);
				$sheet->SetCellValue('H'.$row_count, $row['ifpr_descripcion']);
				$sheet->SetCellValue('I'.$row_count, $row['evfp_valor']);
				$sheet->SetCellValue('J'.$row_count, $row['eval_observacion']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:J'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=evaluacion_factores_protectores.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte acumulado
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function acumulado() {

		if ($this->request->is('post')) {
			set_time_limit(0);
			ini_set('memory_limit', '2048M');

			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->reporteAcumulado($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '32MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion reporte acumulado");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('D4')->applyFromArray($titStyle);
			$sheet->SetCellValue('D4', 'Resultado Acumulado');

			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:G8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'RUN');
			$sheet->SetCellValue('B8', 'DV');
			$sheet->SetCellValue('C8', 'Nombres');
			$sheet->SetCellValue('D8', 'Apellido Paterno');
			$sheet->SetCellValue('E8', 'Apellido Materno');
			$sheet->SetCellValue('F8', 'Sexo');
			$sheet->SetCellValue('G8', 'Centro Familiar');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:G8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('G4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);
				$sheet->SetCellValue('A'.$row_count, $row['pers_run']);
				$sheet->SetCellValue('B'.$row_count, $row['pers_run_dv']);
				$sheet->SetCellValue('C'.$row_count, $row['pers_nombres']);
				$sheet->SetCellValue('D'.$row_count, $row['pers_ap_paterno']);
				$sheet->SetCellValue('E'.$row_count, $row['pers_ap_materno']);
				$sheet->SetCellValue('F'.$row_count, $row['sexo_nombre']);
				$sheet->SetCellValue('G'.$row_count, $row['cefa_nombre']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:G'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_acumulado.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de fuentes de financiamientos
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function fuentes_financiamientos() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];		
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];
			
			$info = $this->Reporte->reporteFuentesFinanciamientos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml evaluacion reporte acumulado");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Fuentes de Financiamiento');

			$sheet->getColumnDimension('A')->setAutoSize(true);

				$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:D8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Fuente de Financiamiento');
			$sheet->SetCellValue('C8', 'Total Personas');
			$sheet->SetCellValue('D8', 'Total');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:D8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);

				if ($this->perf_id == 3) {
					if ($this->cefa_id == $row['cefa_id']) {
						$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
						$sheet->SetCellValue('B'.$row_count, $row['fufi_nombre']);
						$sheet->SetCellValue('C'.$row_count, $row['total_personas']);
						$sheet->SetCellValue('D'.$row_count, $row['total']);
						$row_count++;
					}
				} else {
					$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
					$sheet->SetCellValue('B'.$row_count, $row['fufi_nombre']);
					$sheet->SetCellValue('C'.$row_count, $row['total_personas']);
					$sheet->SetCellValue('D'.$row_count, $row['total']);
					$row_count++;
				}
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:D'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=fuentes_financiamientos.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Pinta reporte de prestaciones generales
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function prestaciones_generales() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');

			$info = $this->Reporte->prestacionesGenerales($desde, $hasta);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte prestaciones");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Prestaciones');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:B8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'N° de Prestaciones');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:B8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('E4', date('d-m-Y H:i:s'));

			$totalPrestaciones = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['nro_prestaciones']);
				$totalPrestaciones += $row['nro_prestaciones'];
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:B'.($row_count-1))->applyFromArray($bodyStyle);

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('B'.($row_count+1), $totalPrestaciones);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_de_prestaciones.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
	}

	/**
	 * Pinta reporte de prestaciones por area
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function prestaciones_areas() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');

			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			$prog_id =  empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];

			$info = $this->Reporte->prestacionesPorArea($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte prestaciones areas tipos actividades");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Prestaciones por Area/Tipo de Actividad');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:C8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Areas de Desarrollo');
			$sheet->SetCellValue('B8', 'Tipos de Actividades');
			$sheet->SetCellValue('C8', 'N° (cantidad de prestaciones)');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:C8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('G4', date('d-m-Y H:i:s'));

			$totalPrestaciones = 0;
			foreach ($info as $row) {			
				$row = array_pop($row);

				$sheet->SetCellValue('A'.$row_count, $row['area_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['tiac_nombre']);
				$sheet->SetCellValue('C'.$row_count, $row['nro_prestaciones']);

				$totalPrestaciones += $row['nro_prestaciones'];
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:C'.($row_count-1))->applyFromArray($bodyStyle);

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('C'.($row_count+1), $totalPrestaciones);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_de_prestaciones_por_area.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte consolidado
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function consolidado() {

		if ($this->request->is('post')) {
			ini_set('memory_limit', '2048M');
			set_time_limit(0);

			header("Content-type: text/csv");
			header("Content-Disposition: attachment;filename=reporte_consolidado.csv");
			header("Pragma: no-cache");
			header("Expires: 0");

			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['hasta'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');

			$prog_nombre = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
			
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];			
			$info = $this->Reporte->reporteConsolidado($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id, $tipo_cobertura, $acti_id, $mes,$prog_nombre);
	

			$cabeceras = array(
				'Centro Familiar',
				'Dirección',
				'Comuna',
				'Telédono',
				'Correo Electrónico',
				'RUN',
				'DV',
				'Nombres',
				'Apellido Paterno',
				'Apellido Materno',
				'Correo Electrónico',
				'Ocupación',
				'Discapacidad',
				'Fecha de Nacimiento',
				'Nro Movil',
				'Nro Fijo',
				'Sexo',
				'Estado Civil',
				'Nacionalidad',
				'Dirección',
				'Comuna',
				'Pueblo Originario',
				'Estudios',
				'Parentesco con la Familia',
				'Salud',
				'Previsión',
				'Grupo Objetivo',
				'Familia Apellido Paterno',
				'Familia Apellido Materno',
				'Dirección',
				'Número',
				'Departamento',
				'Block',
				'Comuna',
				'Nro Movil',
				'Nro Fijo',
				'Observación',
				'Observación de Coordinación',
				'Otras Observaciones',
				'Tipo de Familia',
				'Red',
				'Situación Habitacional',
				'Jefe de Familia',
				'Fecha de Asistencia',
				'Sesión Nro',
				'Actividad',
				'Descripción Actividad',
				'Frecuencia',
				'Actividad Individual',
				'Fecha de Inicio',
				'Fecha de Término',
				'Actividad Comunicacional',
				'Dirección',
				'Comuna',
				'Población',
				'Nro Sesiones',
				'Observaciones',
				'Cobertura Esperada',
				'Tipo de Actividad',
				'Area',
				'Programa',
				'Institución Ejecutora',
				'Fecha de Evaluación',
				'Observación de Evaluación',
				'Tipo de Evaluación',
				'Indicador',
				'Valor',
				'Factor Protector',
				'Objetivos',
				'Año',
				'Nivel',
				'Factor de Riesgo (Presente/Ausente)',
				'Factor de Riesgo',
				'Plan de Trabajo',
				'Observaciones',
				'Actividad'
			);

			$cabeceras = array_map(function($val) {
				if (!is_numeric($val)) {
					return '"'.$val.'"';
				}
				return $val;
			}, $cabeceras);
			echo implode(';', $cabeceras) . chr(13) . chr(10);
			
			foreach ($info as $row) {
				$row = array_pop($row);
				$row = array_values($row);
				$row = array_map(function($val) {
					if (!is_numeric($val)) {
						return '"'.$val.'"';
					}
					return $val;
				}, $row);

				echo implode(';', $row) . chr(13) . chr(10);
			}

			exit;

			// version Excel
			/*
			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
			$cacheSettings = array('memoryCacheSize' => '1024MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');

			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte consolidado");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('C4')->applyFromArray($titStyle);
			$sheet->SetCellValue('C4', 'Reporte Consolidado');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:BX8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Dirección');
			$sheet->SetCellValue('C8', 'Comuna');
			$sheet->SetCellValue('D8', 'Telédono');
			$sheet->SetCellValue('E8', 'Correo Electrónico');
			$sheet->SetCellValue('F8', 'RUN');
			$sheet->SetCellValue('G8', 'DV');
			$sheet->SetCellValue('H8', 'Nombres');
			$sheet->SetCellValue('I8', 'Apellido Paterno');
			$sheet->SetCellValue('J8', 'Apellido Materno');
			$sheet->SetCellValue('K8', 'Correo Electrónico');
			$sheet->SetCellValue('L8', 'Ocupación');
			$sheet->SetCellValue('M8', 'Discapacidad');
			$sheet->SetCellValue('N8', 'Fecha de Nacimiento');
			$sheet->SetCellValue('O8', 'Nro Movil');
			$sheet->SetCellValue('P8', 'Nro Fijo');
			$sheet->SetCellValue('Q8', 'Sexo');
			$sheet->SetCellValue('R8', 'Estado Civil');
			$sheet->SetCellValue('S8', 'Nacionalidad');
			$sheet->SetCellValue('T8', 'Dirección');
			$sheet->SetCellValue('U8', 'Comuna');
			$sheet->SetCellValue('V8', 'Pueblo Originario');
			$sheet->SetCellValue('W8', 'Estudios');
			$sheet->SetCellValue('X8', 'Parentesco con la Familia');
			$sheet->SetCellValue('Y8', 'Salud');
			$sheet->SetCellValue('Z8', 'Previsión');
			$sheet->SetCellValue('AA8', 'Grupo Objetivo');
			$sheet->SetCellValue('AB8', 'Familia Apellido Paterno');
			$sheet->SetCellValue('AC8', 'Familia Apellido Materno');
			$sheet->SetCellValue('AD8', 'Dirección');
			$sheet->SetCellValue('AE8', 'Número');
			$sheet->SetCellValue('AF8', 'Departamento');
			$sheet->SetCellValue('AG8', 'Block');
			$sheet->SetCellValue('AH8', 'Comuna');
			$sheet->SetCellValue('AI8', 'Nro Movil');
			$sheet->SetCellValue('AJ8', 'Nro Fijo');
			$sheet->SetCellValue('AK8', 'Observación');
			$sheet->SetCellValue('AL8', 'Observación de Coordinación');
			$sheet->SetCellValue('AM8', 'Otras Observaciones');
			$sheet->SetCellValue('AN8', 'Tipo de Familia');
			$sheet->SetCellValue('AO8', 'Red');
			$sheet->SetCellValue('AP8', 'Situación Habitacional');
			$sheet->SetCellValue('AQ8', 'Jefe de Familia');
			$sheet->SetCellValue('AR8', 'Fecha de Asistencia');
			$sheet->SetCellValue('AS8', 'Sesión Nro');
			$sheet->SetCellValue('AT8', 'Actividad');
			$sheet->SetCellValue('AU8', 'Descripción Actividad');
			$sheet->SetCellValue('AV8', 'Frecuencia');
			$sheet->SetCellValue('AW8', 'Actividad Individual');
			$sheet->SetCellValue('AX8', 'Fecha de Inicio');
			$sheet->SetCellValue('AY8', 'Fecha de Término');
			$sheet->SetCellValue('AZ8', 'Actividad Comunicacional');
			$sheet->SetCellValue('BA8', 'Dirección');
			$sheet->SetCellValue('BB8', 'Comuna');
			$sheet->SetCellValue('BC8', 'Población');
			$sheet->SetCellValue('BD8', 'Nro Sesiones');
			$sheet->SetCellValue('BE8', 'Observaciones');
			$sheet->SetCellValue('BF8', 'Cobertura Esperada');
			$sheet->SetCellValue('BG8', 'Tipo de Actividad');
			$sheet->SetCellValue('BH8', 'Area');
			$sheet->SetCellValue('BI8', 'Programa');
			$sheet->SetCellValue('BJ8', 'Institución Ejecutora');
			$sheet->SetCellValue('BK8', 'Fecha de Evaluación');
			$sheet->SetCellValue('BL8', 'Observación de Evaluación');
			$sheet->SetCellValue('BM8', 'Tipo de Evaluación');
			$sheet->SetCellValue('BN8', 'Indicador');
			$sheet->SetCellValue('BO8', 'Valor');
			$sheet->SetCellValue('BP8', 'Factor Protector');
			$sheet->SetCellValue('BQ8', 'Objetivos');
			$sheet->SetCellValue('BR8', 'Año');
			$sheet->SetCellValue('BS8', 'Nivel');
			$sheet->SetCellValue('BT8', 'Factor de Riesgo (Presente/Ausente)');
			$sheet->SetCellValue('BU8', 'Factor de Riesgo');
			$sheet->SetCellValue('BV8', 'Plan de Trabajo');
			$sheet->SetCellValue('BW8', 'Observaciones');
			$sheet->SetCellValue('BX8', 'Actividad');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:BX8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);

				$sheet->SetCellValue('A'. $row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'. $row_count, $row['cefa_direccion']);
				$sheet->SetCellValue('C'. $row_count, $row['comuna_centro_familiar']);
				$sheet->SetCellValue('D'. $row_count, $row['cefa_nro_fijo']);
				$sheet->SetCellValue('E'. $row_count, $row['cefa_email']);
				$sheet->SetCellValue('F'. $row_count, $row['pers_run']);
				$sheet->SetCellValue('G'. $row_count, $row['pers_run_dv']);
				$sheet->SetCellValue('H'. $row_count, $row['pers_nombres']);
				$sheet->SetCellValue('I'. $row_count, $row['pers_ap_paterno']);
				$sheet->SetCellValue('J'. $row_count, $row['pers_ap_materno']);
				$sheet->SetCellValue('K'. $row_count, $row['pers_email']);
				$sheet->SetCellValue('L'. $row_count, $row['pers_ocupacion']);
				$sheet->SetCellValue('M'. $row_count, $row['discapacidad']);
				$sheet->SetCellValue('N'. $row_count, $row['pers_fecha_nacimiento']);
				$sheet->SetCellValue('O'. $row_count, $row['pers_nro_movil']);
				$sheet->SetCellValue('P'. $row_count, $row['pers_nro_fijo']);
				$sheet->SetCellValue('Q'. $row_count, $row['sexo_nombre']);
				$sheet->SetCellValue('R'. $row_count, $row['esci_nombre']);
				$sheet->SetCellValue('S'. $row_count, $row['naci_nombre']);
				$sheet->SetCellValue('T'. $row_count, $row['dire_direccion']);
				$sheet->SetCellValue('U'. $row_count, $row['comuna_persona']);
				$sheet->SetCellValue('V'. $row_count, $row['puor_nombre']);
				$sheet->SetCellValue('W'. $row_count, $row['estu_nombre']);
				$sheet->SetCellValue('X'. $row_count, $row['pare_nombre']);
				$sheet->SetCellValue('Y'. $row_count, $row['inst_salud']);
				$sheet->SetCellValue('Z'. $row_count, $row['inst_prevision']);
				$sheet->SetCellValue('AA'. $row_count, $row['grob_nombre']);
				$sheet->SetCellValue('AB'. $row_count, $row['fami_ap_paterno']);
				$sheet->SetCellValue('AC'. $row_count, $row['fami_ap_materno']);
				$sheet->SetCellValue('AD'. $row_count, $row['fami_direccion_calle']);
				$sheet->SetCellValue('AE'. $row_count, $row['fami_direccion_nro']);
				$sheet->SetCellValue('AF'. $row_count, $row['fami_direccion_depto']);
				$sheet->SetCellValue('AG'. $row_count, $row['fami_direccion_block']);
				$sheet->SetCellValue('AH'. $row_count, $row['comuna_familia']);
				$sheet->SetCellValue('AI'. $row_count, $row['fami_nro_movil']);
				$sheet->SetCellValue('AJ'. $row_count, $row['fami_nro_fijo']);
				$sheet->SetCellValue('AK'. $row_count, $row['fami_observacion']);
				$sheet->SetCellValue('AL'. $row_count, $row['fami_obs_coordinacion']);
				$sheet->SetCellValue('AM'. $row_count, $row['fami_otras_observaciones']);
				$sheet->SetCellValue('AN'. $row_count, $row['tifa_nombre']);
				$sheet->SetCellValue('AO'. $row_count, $row['rede_nombre']);
				$sheet->SetCellValue('AP'. $row_count, $row['siha_nombre']);
				$sheet->SetCellValue('AQ'. $row_count, $row['jefe_familia']);
				$sheet->SetCellValue('AR'. $row_count, $row['asis_fecha']);
				$sheet->SetCellValue('AS'. $row_count, $row['sesi_nombre']);
				$sheet->SetCellValue('AT'. $row_count, $row['acti_nombre']);
				$sheet->SetCellValue('AU'. $row_count, $row['acti_descripcion']);
				$sheet->SetCellValue('AV'. $row_count, $row['acti_frecuencia']);
				$sheet->SetCellValue('AW'. $row_count, $row['actividad_individual']);
				$sheet->SetCellValue('AX'. $row_count, $row['acti_fecha_inicio']);
				$sheet->SetCellValue('AY'. $row_count, $row['acti_fecha_termino']);
				$sheet->SetCellValue('AZ'. $row_count, $row['actividad_comunicacional']);
				$sheet->SetCellValue('BA'. $row_count, $row['acti_direccion']);
				$sheet->SetCellValue('BB'. $row_count, $row['comuna_actividad']);
				$sheet->SetCellValue('BC'. $row_count, $row['acti_poblacion']);
				$sheet->SetCellValue('BD'. $row_count, $row['acti_nro_sesiones']);
				$sheet->SetCellValue('BE'. $row_count, $row['acti_observaciones']);
				$sheet->SetCellValue('BF'. $row_count, $row['acti_cobertura_esperada']);
				$sheet->SetCellValue('BG'. $row_count, $row['tiac_nombre']);
				$sheet->SetCellValue('BH'. $row_count, $row['area_nombre']);
				$sheet->SetCellValue('BI'. $row_count, $row['prog_nombre']);
				$sheet->SetCellValue('BJ'. $row_count, $row['inst_actividad']);
				$sheet->SetCellValue('BK'. $row_count, $row['eval_fecha']);
				$sheet->SetCellValue('BL'. $row_count, $row['eval_observacion']);
				$sheet->SetCellValue('BM'. $row_count, $row['tiev_nombre']);
				$sheet->SetCellValue('BN'. $row_count, $row['ifpr_descripcion']);
				$sheet->SetCellValue('BO'. $row_count, $row['evfp_valor']);
				$sheet->SetCellValue('BP'. $row_count, $row['fapr_nombre']);
				$sheet->SetCellValue('BQ'. $row_count, $row['fapr_objetivos']);
				$sheet->SetCellValue('BR'. $row_count, $row['fapr_ano']);
				$sheet->SetCellValue('BS'. $row_count, $row['nive_nombre']);
				$sheet->SetCellValue('BT'. $row_count, $row['factor_riesgo_presente']);
				$sheet->SetCellValue('BU'. $row_count, $row['fari_descripcion']);
				$sheet->SetCellValue('BV'. $row_count, $row['plan_trabajo']);
				$sheet->SetCellValue('BW'. $row_count, $row['dept_observaciones']);
				$sheet->SetCellValue('BX'. $row_count, $row['plan_trabajo_acti_nombre']);
				
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);

			$sheet->getStyle('A8:BX'.($row_count-1))->applyFromArray($bodyStyle);

			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_consolidado.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
			*/
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		foreach($programas as $key => $value){
			$programa = substr($value, 0, -7);
			$programas2[$programa] = $value;
		}

		$this->set('programas', $programas2);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Pinta reporte de actividades masivas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function actividades_masivas() {

		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['hasta'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');

			//PROGRAMA
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
	
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];

			$info = $this->Reporte->actividadesMasivas($desde, $hasta, $cefa_id, $regi_id, $comu_id, $acti_id, $mes, $prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');

			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte prestaciones areas tipos actividades");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Actividades Masivas');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:G8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Actividad');
			$sheet->SetCellValue('C8', 'Area');
			$sheet->SetCellValue('D8', 'Tipo de Actividad');
			$sheet->SetCellValue('E8', 'Cobertura');
			$sheet->SetCellValue('F8', 'Fecha de Inicio');
			$sheet->SetCellValue('G8', 'Fecha de Término');

			// filtros a cabeceras
			$sheet->setAutoFilter('A8:G8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('H4', date('d-m-Y H:i:s'));

			$totalCobertura = 0;
			foreach ($info as $row) {
				$row = array_pop($row);

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['acti_nombre']);
				$sheet->SetCellValue('C'.$row_count, $row['area_nombre']);
				$sheet->SetCellValue('D'.$row_count, $row['tiac_nombre']);
				$sheet->SetCellValue('E'.$row_count, $row['acti_cobertura_esperada']);
				$sheet->SetCellValue('F'.$row_count, $row['acti_fecha_inicio']);
				$sheet->SetCellValue('G'.$row_count, $row['acti_fecha_termino']);

				$totalCobertura += is_numeric($row['acti_cobertura_esperada'])? $row['acti_cobertura_esperada']: 0;
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:C'.($row_count-1))->applyFromArray($bodyStyle);

			// totales
			$sheet->SetCellValue('A'.($row_count+1), 'Totales');
			$sheet->SetCellValue('E'.($row_count+1), $totalCobertura);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_actividades_masivas.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}

		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Reporte de nuevos planes de trabajos (en ficha de persona)
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function planes_trabajos() {

		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['hasta'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];
			$grob_id = empty($this->request->data['Reporte']['grob_id'])? null : $this->request->data['Reporte']['grob_id'];
			$sexo_id = empty($this->request->data['Reporte']['sexo_id'])? null : $this->request->data['Reporte']['sexo_id'];
			
			$info = $this->Reporte->planesTrabajos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $grob_id, $sexo_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte plan trabajo");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	// titulo
			$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Reporte de Planes de Trabajo');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:B8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Personas con Plan de Trabajo');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:B8');			
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['total']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:B'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=reporte_planes_trabajos.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;			
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);

		$gruposObjetivos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->GrupoObjetivo->find('list');
		$sexos = $this->CentroFamiliar->PersonaCentroFamiliar->Persona->Sexo->find('list');
		
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas', 'gruposObjetivos', 'sexos'));
	}

	/**
	 * Reporte de actividades por fuente de financiamiento
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function actividades_fuentes_financiamientos() {
		if ($this->request->is('post')) {
			$desde = empty($this->request->data['Reporte']['desde'])? null : CakeTime::format($this->request->data['Reporte']['desde'], '%Y-%m-%d');
			$hasta = empty($this->request->data['Reporte']['hasta'])? null : CakeTime::format($this->request->data['Reporte']['hasta'], '%Y-%m-%d');
			$cefa_id = empty($this->request->data['Reporte']['cefa_id'])? null : $this->request->data['Reporte']['cefa_id'];
			$regi_id = empty($this->request->data['Reporte']['regi_id'])? null : $this->request->data['Reporte']['regi_id'];
			$comu_id = empty($this->request->data['Reporte']['comu_id'])? null : $this->request->data['Reporte']['comu_id'];	
			$prog_id = empty($this->request->data['Reporte']['prog_id'])? null : $this->request->data['Reporte']['prog_id'];
	
			$tipo_cobertura = empty($this->request->data['Reporte']['tipo_cobertura'])? null : $this->request->data['Reporte']['tipo_cobertura'];
			$acti_id = empty($this->request->data['Reporte']['acti_id'])? null : $this->request->data['Reporte']['acti_id'];
			$mes = empty($this->request->data['Reporte']['mes'])? null : $this->request->data['Reporte']['mes'];

			$info = $this->Reporte->actividadesFuentesFinanciamientos($desde, $hasta, $cefa_id, $regi_id, $comu_id, $tipo_cobertura, $acti_id, $mes,$prog_id);

			$excel = new PHPExcel();
			$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
			$cacheSettings = array('memoryCacheSize' => '8MB');
			PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
			PHPExcel_Settings::setLocale('es_cl');
			
			$props = $excel->getProperties();
			$props->setCreator("Fundación de la Familia");
			$props->setLastModifiedBy("Fundación de la Familia");
			$props->setKeywords("office 2007 openxml reporte plan trabajo");

			$excel->setActiveSheetIndex(0);
			$sheet = $excel->getActiveSheet();

			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setPath(WWW_ROOT . DS . 'img' . DS . 'funfamilia.PNG');
			$objDrawing->setCoordinates('A2');
        	$objDrawing->setWorksheet($excel->getActiveSheet());

        	$titStyle = array(
				'font' => array(
					'bold' => true
				)
			);

			$sheet->getStyle('B4')->applyFromArray($titStyle);
			$sheet->SetCellValue('B4', 'Actividades por Fuente de Financiamiento');

			$sheet->getColumnDimension('A')->setAutoSize(true);

			$cabStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'FFFF00')
				)
			);

			$sheet->getStyle('A8:E8')->applyFromArray($cabStyle);
			$sheet->SetCellValue('A8', 'Centro Familiar');
			$sheet->SetCellValue('B8', 'Actividad');
			$sheet->SetCellValue('C8', 'Estado Actividad');
			$sheet->SetCellValue('D8', 'Fuente de Financiamiento');
			$sheet->SetCellValue('E8', 'Total Prestaciones');
			
			// filtros a cabeceras
			$sheet->setAutoFilter('A8:E8');
			$row_count = 9;

			// hora de generación	
			$sheet->SetCellValue('F4', date('d-m-Y H:i:s'));

			foreach ($info as $row) {			
				$row = array_pop($row);

				$sheet->SetCellValue('A'.$row_count, $row['cefa_nombre']);
				$sheet->SetCellValue('B'.$row_count, $row['acti_nombre']);
				$sheet->SetCellValue('C'.$row_count, $row['esac_nombre']);
				$sheet->SetCellValue('D'.$row_count, $row['fufi_nombre']);
				$sheet->SetCellValue('E'.$row_count, $row['total_prestaciones']);
				$row_count++;
			}

			// formato a body
			$bodyStyle = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000'),
					)
				)
			);
			
			$sheet->getStyle('A8:E'.($row_count-1))->applyFromArray($bodyStyle);
			
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=actividades_x_fuente_financiamiento.xlsx');
			
			ob_clean();
			$writer = new PHPExcel_Writer_Excel2007($excel);
			$writer->save('php://output');
			exit;
		}
		
		$centrosFamiliares = $this->CentroFamiliar->find('list',
			array(
				'order' => array(
					'CentroFamiliar.cefa_orden'
				)
			)
		);
		$regiones = $this->CentroFamiliar->Comuna->Region->find('list',
			array(
				'order' => array(
					'Region.regi_id'
				)
			)
		);
		$comunas = $this->CentroFamiliar->Comuna->find('list',
			array(
				'order' => array(
					'Comuna.comu_nombre'
				)
			)
		);
		$this->loadModel("Programa");
		$programas = $this->Programa->find('list');
		$this->set('programas', $programas);
		$this->set(compact('centrosFamiliares', 'regiones', 'comunas'));
	}

	/**
	 * Refresca vistas materializadas
	 * 
	 * @author maraya-gómez
	 * @return void
	 */
	public function refreshMaterializedViews() {
		// curl -i http://maraya.funfamilia.devel:81/reportes/refreshMaterializedViews
		set_time_limit(0);
		$this->layout = 'ajax';
		$this->Reporte->refreshMaterializedViews();
	}
}
	
