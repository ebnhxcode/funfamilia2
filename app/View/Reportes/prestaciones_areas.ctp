<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Reportes'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Reporte de Prestaciones por Area'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Reporte de Prestaciones por Area'); ?> <small><?php echo __('Reporte de Prestaciones por Area'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Prestaciones por Area'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Reporte'); ?>
					<?php echo $this->Form->input('desde', array('label' => __('Desde'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => '01-01-'.date('Y'))); ?>
					<?php echo $this->Form->input('hasta', array('label' => __('Hasta'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => date('d-m-Y'))); ?>
					<?php
						$prog_id = !empty($this->request->query['pro_id'])? $this->request->query['prog_id']: null;
						echo $this->Form->input('prog_id', array('label' => __('Programas'), 'options' => $programas, 'empty' => '', 'class' => 'form-control input-sm', 'selected' => $prog_id));
					?>
					<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'empty' => '', 'options' => $centrosFamiliares)); ?>
					<?php echo $this->Form->input('regi_id', array('label' => __('Región'), 'empty' => '', 'options' => $regiones)); ?>
					<?php echo $this->Form->input('comu_id', array('label' => __('Comuna'), 'empty' => '', 'options' => $comunas)); ?>
					<?php echo $this->Form->input('grob_id', array('label' => __('Grupo Objetivo'), 'empty' => '', 'options' => $gruposObjetivos)); ?>
					<?php echo $this->Form->input('sexo_id', array('label' => __('Sexo'), 'empty' => '', 'options' => $sexos)); ?>
					<?php echo $this->Form->input('tipo_cobertura', array('label' => __('Tipo de Cobertura'), 'empty' => '', 'options' => array(1 => 'Masiva', 2 => 'Individual'))); ?>
					<?php echo $this->Form->input('acti_id', array('label' => __('N° de Actividad'), 'type' => 'number')); ?>

					<?php
						$meses = array(
							1 => 'Enero',
							2 => 'Febrero',
							3 => 'Marzo',
							4 => 'Abril',
							5 => 'Mayo',
							6 => 'Junio',
							7 => 'Julio',
							8 => 'Agosto',
							9 => 'Septiembre',
							10 => 'Octubre',
							11 => 'Noviembre',
							12 => 'Diciembre'
						);
						echo $this->Form->input('mes', array('label' => __('Mes'), 'options' => $meses, 'empty' => ''));
					?>
					
					<div class="form-group">
							<div class="col-sm-2 col-sm-offset-9">
								<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Generar Reporte'); ?> <i class="fa fa-arrow-circle-right"></i></button>
							</div>
						</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>