<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Inscripciones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Clonar Participantes'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Clonar Participantes'); ?> <small><?php echo __('Clonar Participantes'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Nivel'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Actividad'); ?>
					<?php echo $this->Form->input('acti_id1', array('label' => __('Actividad'), 'options' => $actividades)); ?>
					<?php echo $this->Form->input('acti_id2', array('label' => __('Actividad Destino'), 'options' => $actividades)); ?>
					
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

<script>
$(document).ready(function() {
	$('#ActividadClonarForm').on('submit', function() {
		var c = confirm('La acción clonará todos los participantes de la actividad, hacia la actividad destino. ¿está seguro que desea continuar?');
		
		if (c) {
			return true;
		}

		return false;
	});
});
</script>