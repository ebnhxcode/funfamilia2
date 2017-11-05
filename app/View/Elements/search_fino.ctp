<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Búsqueda Avanzada'); ?>
		<div class="panel-tools">
			<a href="#" class="btn btn-xs btn-link panel-collapse expand">
			</a>
		</div>
	</div>
	<div class="panel-body" style="display:none;">
	<?php if ($tipo == 'personas'): ?>
		<?php echo $this->Form->create('BusquedaAvanzada', array('type' => 'get')); ?>

		<?php
			$sf_cefa_id = !empty($this->request->query['sf_cefa_id'])? $this->request->query['sf_cefa_id']: null;
			echo $this->Form->input('sf_cefa_id', array('label' => __('Centro Familiar'), 'options' => $combos['centrosFamiliares'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_cefa_id));
		?>
		<?php
			$sf_pro_id = !empty($this->request->query['sf_pro_id'])? $this->request->query['sf_pro_id']: null;
			echo $this->Form->input('sf_pro_id', array('label' => __('Programas'), 'options' => $combos['programas'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_pro_id));
		?>
		<?php
			$sf_comu_id = !empty($this->request->query['sf_comu_id'])? $this->request->query['sf_comu_id']: null;
			echo $this->Form->input('sf_comu_id', array('label' => __('Comuna'), 'options' => $combos['comunas'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_comu_id));
		?>		
		<?php
			$sf_tiac_id = !empty($this->request->query['sf_tiac_id'])? $this->request->query['sf_tiac_id']: null;
			echo $this->Form->input('sf_tiac_id', array('label' => __('Tipo de Actividad'), 'options' => $combos['tiposActividades'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiac_id));
		?>		
		<?php
			$participaOptions = array(
				1 => __('Si'),
				2 => __('No')
			);
			$sf_participacion = !empty($this->request->query['sf_participacion'])? $this->request->query['sf_participacion']: null;
			echo $this->Form->input('sf_participacion', array('label' => __('¿Es Participante?'), 'options' => $participaOptions, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_participacion));
		?>
		<?php
			$sf_sexo_id = !empty($this->request->query['sf_sexo_id'])? $this->request->query['sf_sexo_id']: null;
			echo $this->Form->input('sf_sexo_id', array('label' => __('Sexo'), 'options' => $combos['sexos'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_sexo_id));
		?>
		<?php
			$sf_pers_fecha_nacimiento = !empty($this->request->query['sf_pers_fecha_nacimiento'])? $this->request->query['sf_pers_fecha_nacimiento']: null;
			echo $this->Form->input('sf_pers_fecha_nacimiento', array('label' => __('Fecha de Nacimiento (desde)'), 'class' => 'form-control date-picker input-sm', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_pers_fecha_nacimiento)); ?>
		<?php
			$sf_pers_fecha_nacimiento2 = !empty($this->request->query['sf_pers_fecha_nacimiento2'])? $this->request->query['sf_pers_fecha_nacimiento2']: null;
			echo $this->Form->input('sf_pers_fecha_nacimiento2', array('label' => __('Fecha de Nacimiento (hasta)'), 'class' => 'form-control date-picker input-sm', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_pers_fecha_nacimiento2)); ?>
		<?php
			$sf_esci_id = !empty($this->request->query['sf_esci_id'])? $this->request->query['sf_esci_id']: null;
			echo $this->Form->input('sf_esci_id', array('label' => __('Estado Civil'), 'options' => $combos['estadosCiviles'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_esci_id));
		?>
		<?php
			$sf_puor_id = !empty($this->request->query['sf_puor_id'])? $this->request->query['sf_puor_id']: null;
			echo $this->Form->input('sf_puor_id', array('label' => __('Pueblo Originario'), 'options' => $combos['pueblosOriginarios'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_puor_id));
		?>
		<?php
			$sf_grob_id = !empty($this->request->query['sf_grob_id'])? $this->request->query['sf_grob_id']: null;
			echo $this->Form->input('sf_grob_id', array('label' => __('Grupo Objetivo'), 'options' => $combos['gruposObjetivos'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_grob_id));
		?>
		<?php
			$anyos = array();
			for($i=date('Y')-2; $i<=date('Y'); $i++) {
				$anyos[$i] = $i;
			}
			$sf_ano = !empty($this->request->query['sf_ano'])? $this->request->query['sf_ano']: null;
			echo $this->Form->input('sf_ano', array('label' => __('Año de Ingreso'), 'options' => $anyos, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_ano));
		?>
		<?php
			$sf_tiene_familia = !empty($this->request->query['sf_tiene_familia'])? $this->request->query['sf_tiene_familia']: null;
			echo $this->Form->input('sf_tiene_familia', array('label' => __('¿Pertenece a Familia?'), 'options' => array(1 => __('Si'), 2 => __('No')), 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiene_familia));
		?>

		<?php
			$sf_tiene_plan_trabajo = !empty($this->request->query['sf_tiene_plan_trabajo'])? $this->request->query['sf_tiene_plan_trabajo']: null;
			echo $this->Form->input('sf_tiene_plan_trabajo', array('label' => __('¿Tiene Plan de Trabajo?'), 'options' => array(1 => __('Si'), 2 => __('No')), 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiene_plan_trabajo));
		?>

		<?php
			$sf_tiene_ficha = !empty($this->request->query['sf_tiene_ficha'])? $this->request->query['sf_tiene_ficha']: null;
			echo $this->Form->input('sf_tiene_ficha', array('label' => __('¿Tiene Ficha Completa?'), 'options' => array(1 => __('Si'), 2 => __('No')), 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiene_ficha));
		?>

		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-9">
				<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Buscar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	
	<?php elseif ($tipo == 'familias'): ?>
		<?php echo $this->Form->create('BusquedaAvanzada', array('type' => 'get')); ?>

		<?php
			$sf_cefa_id = !empty($this->request->query['sf_cefa_id'])? $this->request->query['sf_cefa_id']: null;
			echo $this->Form->input('sf_cefa_id', array('label' => __('Centro Familiar'), 'options' => $combos['centrosFamiliares'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_cefa_id));
		?>
		<?php
			$sf_tifa_id = !empty($this->request->query['sf_tifa_id'])? $this->request->query['sf_tifa_id']: null;
			echo $this->Form->input('sf_tifa_id', array('label' => __('Tipo de Familia'), 'options' => $combos['tiposFamilias'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tifa_id));
		?>
		<?php
			$participaOptions = array(
				1 => __('Si'),
				2 => __('No')
			);
			$sf_participacion = !empty($this->request->query['sf_participacion'])? $this->request->query['sf_participacion']: null;
			echo $this->Form->input('sf_participacion', array('label' => __('¿Es Participante?'), 'options' => $participaOptions, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_participacion));
		?>
		<?php
			$anyos = array();
			for($i=date('Y')-2; $i<=date('Y'); $i++) {
				$anyos[$i] = $i;
			}
			$sf_ano = !empty($this->request->query['sf_ano'])? $this->request->query['sf_ano']: null;
			echo $this->Form->input('sf_ano', array('label' => __('Año de Ingreso'), 'options' => $anyos, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_ano));
		?>

		<?php
			$personasOptions = array(
				1 => __('Si'),
				2 => __('No')
			);
			$sf_tiene_personas = !empty($this->request->query['sf_tiene_personas'])? $this->request->query['sf_tiene_personas']: null;
			echo $this->Form->input('sf_tiene_personas', array('label' => __('¿Tiene Personas?'), 'options' => $personasOptions, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiene_personas));
		?>
		<?php
			$sf_tiene_ficha = !empty($this->request->query['sf_tiene_ficha'])? $this->request->query['sf_tiene_ficha']: null;
			echo $this->Form->input('sf_tiene_ficha', array('label' => __('¿Tiene Ficha Completa?'), 'options' => array(1 => __('Si'), 2 => __('No')), 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiene_ficha));
		?>

		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-9">
				<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Buscar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>

	<?php elseif ($tipo == 'actividades'): ?>
		<?php echo $this->Form->create('BusquedaAvanzada', array('type' => 'get')); ?>
		<?php
			$sf_cefa_id = !empty($this->request->query['sf_cefa_id'])? $this->request->query['sf_cefa_id']: null;
			echo $this->Form->input('sf_cefa_id', array('label' => __('Centro Familiar'), 'options' => $combos['centrosFamiliares'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_cefa_id));
		?>
		<?php
			$sf_pro_id = !empty($this->request->query['sf_pro_id'])? $this->request->query['sf_pro_id']: null;
			echo $this->Form->input('sf_pro_id', array('label' => __('Programas'), 'options' => $combos['programas'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_pro_id));
		?>
		<?php
			$sf_tiac_id = !empty($this->request->query['sf_tiac_id'])? $this->request->query['sf_tiac_id']: null;
			echo $this->Form->input('sf_tiac_id', array('label' => __('Tipo de Actividad'), 'options' => $combos['tiposActividades'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiac_id));
		?>
		<?php
			$sf_fecha_inicio = !empty($this->request->query['sf_fecha_inicio'])? $this->request->query['sf_fecha_inicio']: null;
			echo $this->Form->input('sf_fecha_inicio', array('label' => __('Fecha de Inicio'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_fecha_inicio));
		?>
		<?php
			$sf_fecha_termino = !empty($this->request->query['sf_fecha_termino'])? $this->request->query['sf_fecha_termino']: null;
			echo $this->Form->input('sf_fecha_termino', array('label' => __('Fecha de Término'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_fecha_termino));
		?>
		<?php
			$sf_esac_id = !empty($this->request->query['sf_esac_id'])? $this->request->query['sf_esac_id']: null;
			echo $this->Form->input('sf_esac_id', array('label' => __('Estado de Actividad'), 'options' => $combos['estadosActividades'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_esac_id));
		?>
		<?php
			$sf_acti_id = !empty($this->request->query['sf_acti_id'])? $this->request->query['sf_acti_id']: null;
			echo $this->Form->input('sf_acti_id', array('label' => __('N° de Actividad'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_acti_id));
		?>
		<?php
			$tiposCoberturas = array(
				1 => 'Masiva',
				2 => 'Individual'
			);
			$sf_tipo_cobertura = !empty($this->request->query['sf_tipo_cobertura'])? $this->request->query['sf_tipo_cobertura']: null;
			echo $this->Form->input('sf_tipo_cobertura', array('label' => __('Tipo de Cobertura'), 'options' => $tiposCoberturas, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tipo_cobertura));
		?>
		<?php
			$sf_nro_sesiones = !empty($this->request->query['sf_nro_sesiones'])? $this->request->query['sf_nro_sesiones']: null;
			echo $this->Form->input('sf_nro_sesiones', array('label' => __('N° de Sesiones'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_nro_sesiones));
		?>
		<?php
			$anyos = array();
			for($i=date('Y')-2; $i<=date('Y'); $i++) {
				$anyos[$i] = $i;
			}
			$sf_ano = !empty($this->request->query['sf_ano'])? $this->request->query['sf_ano']: null;
			echo $this->Form->input('sf_ano', array('label' => __('Año'), 'options' => $anyos, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_ano));
		?>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-9">
				<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Buscar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>

	<?php elseif ($tipo == 'sesiones'): ?>
		<?php echo $this->Form->create('BusquedaAvanzada', array('type' => 'get')); ?>
		<?php
			$sf_cefa_id = !empty($this->request->query['sf_cefa_id'])? $this->request->query['sf_cefa_id']: null;
			echo $this->Form->input('sf_cefa_id', array('label' => __('Centro Familiar'), 'options' => $combos['centrosFamiliares'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_cefa_id));
		?>
		<?php
			$sf_pro_id = !empty($this->request->query['sf_pro_id'])? $this->request->query['sf_pro_id']: null;
			echo $this->Form->input('sf_pro_id', array('label' => __('Programas'), 'options' => $combos['programas'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_pro_id));
		?>
		<?php
			$sf_tiac_id = !empty($this->request->query['sf_tiac_id'])? $this->request->query['sf_tiac_id']: null;
			echo $this->Form->input('sf_tiac_id', array('label' => __('Tipo de Actividad'), 'options' => $combos['tiposActividades'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiac_id));
		?>
		<?php
			$sf_acti_id = !empty($this->request->query['sf_acti_id'])? $this->request->query['sf_acti_id']: null;
			echo $this->Form->input('sf_acti_id', array('label' => __('N° de Actividad'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_acti_id));
		?>
		<?php
			$sf_sesi_id = !empty($this->request->query['sf_sesi_id'])? $this->request->query['sf_sesi_id']: null;
			echo $this->Form->input('sf_sesi_id', array('label' => __('N° de Sesión'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_sesi_id));
		?>
		<?php
			$sf_nro_sesiones = !empty($this->request->query['sf_nro_sesiones'])? $this->request->query['sf_nro_sesiones']: null;
			echo $this->Form->input('sf_nro_sesiones', array('label' => __('N° de Usuarios por Sesión'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_nro_sesiones));
		?>
		<?php
			$sf_nro_asistentes = !empty($this->request->query['sf_nro_asistentes'])? $this->request->query['sf_nro_asistentes']: null;
			echo $this->Form->input('sf_nro_asistentes', array('label' => __('N° de Asistentes'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_nro_asistentes));
		?>
		<?php
			$tiposCoberturas = array(
				1 => 'Masiva',
				2 => 'Individual'
			);
			$sf_tipo_cobertura = !empty($this->request->query['sf_tipo_cobertura'])? $this->request->query['sf_tipo_cobertura']: null;
			echo $this->Form->input('sf_tipo_cobertura', array('label' => __('Tipo de Cobertura'), 'options' => $tiposCoberturas, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tipo_cobertura));
		?>
		<?php
			$anyos = array();
			for($i=date('Y')-2; $i<=date('Y'); $i++) {
				$anyos[$i] = $i;
			}
			$sf_ano = !empty($this->request->query['sf_ano'])? $this->request->query['sf_ano']: null;
			echo $this->Form->input('sf_ano', array('label' => __('Año'), 'options' => $anyos, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_ano));
		?>
		<?php
			$sf_fecha_ejec = !empty($this->request->query['sf_fecha_ejec'])? $this->request->query['sf_fecha_ejec']: null;
			echo $this->Form->input('sf_fecha_ejec', array('label' => __('Fecha de Ejecución'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_fecha_ejec));
		?>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-9">
				<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Buscar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>

	<?php elseif ($tipo == 'inscripciones'): ?>
		<?php echo $this->Form->create('BusquedaAvanzada', array('type' => 'get')); ?>
		<?php
			$sf_cefa_id = !empty($this->request->query['sf_cefa_id'])? $this->request->query['sf_cefa_id']: null;
			echo $this->Form->input('sf_cefa_id', array('label' => __('Centro Familiar'), 'options' => $combos['centrosFamiliares'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_cefa_id));
		?>
		<?php
			$sf_pro_id = !empty($this->request->query['sf_pro_id'])? $this->request->query['sf_pro_id']: null;
			echo $this->Form->input('sf_pro_id', array('label' => __('Programas'), 'options' => $combos['programas'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_pro_id));
		?>
		<?php
			$sf_tiac_id = !empty($this->request->query['sf_tiac_id'])? $this->request->query['sf_tiac_id']: null;
			echo $this->Form->input('sf_tiac_id', array('label' => __('Tipo de Actividad'), 'options' => $combos['tiposActividades'], 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tiac_id));
		?>
		<?php
			$sf_fecha_inicio = !empty($this->request->query['sf_fecha_inicio'])? $this->request->query['sf_fecha_inicio']: null;
			echo $this->Form->input('sf_fecha_inicio', array('label' => __('Fecha de Inicio'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_fecha_inicio));
		?>
		<?php
			$sf_fecha_termino = !empty($this->request->query['sf_fecha_termino'])? $this->request->query['sf_fecha_termino']: null;
			echo $this->Form->input('sf_fecha_termino', array('label' => __('Fecha de Término'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => $sf_fecha_termino));
		?>
		<?php
			$sf_acti_id = !empty($this->request->query['sf_acti_id'])? $this->request->query['sf_acti_id']: null;
			echo $this->Form->input('sf_acti_id', array('label' => __('N° de Actividad'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_acti_id));
		?>
		<?php
			// este filtro es absurdo
			/*
			$tiposCoberturas = array(
				1 => 'Masiva',
				2 => 'Individual'
			);
			$sf_tipo_cobertura = !empty($this->request->query['sf_tipo_cobertura'])? $this->request->query['sf_tipo_cobertura']: null;
			echo $this->Form->input('sf_tipo_cobertura', array('label' => __('Tipo de Cobertura'), 'options' => $tiposCoberturas, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $sf_tipo_cobertura));
			*/
		?>
		<?php
			$sf_nro_sesiones = !empty($this->request->query['sf_nro_sesiones'])? $this->request->query['sf_nro_sesiones']: null;
			echo $this->Form->input('sf_nro_sesiones', array('label' => __('N° de Sesiones'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_nro_sesiones));
		?>
		<?php
			$sf_nro_inscripciones = !empty($this->request->query['sf_nro_inscripciones'])? $this->request->query['sf_nro_inscripciones']: null;
			echo $this->Form->input('sf_nro_inscripciones', array('label' => __('N° de Inscripciones'), 'type' => 'number', 'class' => 'form-control input-sm', 'value' => $sf_nro_inscripciones));
		?>		
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-9">
				<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Buscar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>

	<?php endif; ?>
	</div>
</div>
