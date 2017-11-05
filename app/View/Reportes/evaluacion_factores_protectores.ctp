<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Reportes'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Evaluación de Factores Protectores'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Evaluación de Factores Protectores'); ?> <small><?php echo __('Evaluación de Factores Protectores'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Evaluación de Factores Protectores'); ?>

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
					<?php echo $this->Form->input('tipo', array('label' => __('Tipo de Evaluación'), 'class' => 'form-control', 'options' => array(1 => 'Diagnóstica', 2 => 'Final'))); ?>
					<?php echo $this->Form->input('desde', array('label' => __('Desde'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => '01-01-'.date('Y'))); ?>
					<?php echo $this->Form->input('hasta', array('label' => __('Hasta'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'value' => date('d-m-Y'))); ?>
					
					<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'empty' => '', 'options' => $centrosFamiliares)); ?>
					<?php echo $this->Form->input('regi_id', array('label' => __('Región'), 'empty' => '', 'options' => $regiones)); ?>
					<?php echo $this->Form->input('comu_id', array('label' => __('Comuna'), 'empty' => '', 'options' => $comunas)); ?>
					<?php echo $this->Form->input('grob_id', array('label' => __('Grupo Objetivo'), 'empty' => '', 'options' => $gruposObjetivos)); ?>
					<?php echo $this->Form->input('sexo_id', array('label' => __('Sexo'), 'empty' => '', 'options' => $sexos)); ?>	
					
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