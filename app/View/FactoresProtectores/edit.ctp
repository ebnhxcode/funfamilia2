<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Factores Protectores'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Factor Protector'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Factor Protector'); ?> <small><?php echo __('Editar Factor Protector'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Factor Protector'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('FactorProtector'); ?>
					<?php echo $this->Form->input('nive_id', array('label' => __('Nivel'), 'options' => $niveles, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('fapr_ano', array('label' => __('Año'))); ?>
					<?php echo $this->Form->input('fapr_nombre', array('label' => __('Nombre'))); ?>
					<?php echo $this->Form->input('fapr_objetivos', array('label' => __('Objetivos'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->input('fapr_id'); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
