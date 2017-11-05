<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-user"></i>
				<?php echo $this->Html->link(__('Usuarios'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Usuario'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Usuario'); ?> <small><?php echo __('Editar Usuario'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Usuario'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Usuario'); ?>
					<?php echo $this->Form->input('usua_nombre', array('label' => __('Nombre'))); ?>
					<?php echo $this->Form->input('usua_apellidos', array('label' => __('Apellidos'))); ?>
					<?php echo $this->Form->input('usua_username', array('label' => __('Nombre de Usuario'))); ?>
					<?php echo $this->Form->input('usua_password', array('label' => __('Contraseña'), 'type' => 'password')); ?>
					<?php echo $this->Form->input('usua_email', array('label' => __('Correo Electrónico'))); ?>
					<?php echo $this->Form->input('usua_fecha_caducidad', array('label' => __('Fecha de Caducidad'), 'type' => 'text', 'class' => 'form-control date-picker', 'data-date-viewmode' => 'years', 'data-date-format' => 'dd-mm-yyyy')); ?>
					<?php echo $this->Form->input('usua_activo', array('label' => __('¿Activo?'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->input('usua_id'); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
