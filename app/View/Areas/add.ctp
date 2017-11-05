<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Area'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nueva Area'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nueva Area'); ?> <small><?php echo __('Nueva Area'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Area'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Area'); ?>
					<?php echo $this->Form->input('prog_id', array('label' => __('Programa'), 'options' => $programas, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('area_nombre', array('label' => __('Nombre'))); ?>
					<?php echo $this->Form->input('area_orden', array('label' => __('Orden'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
