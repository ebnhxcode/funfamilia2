<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Perfiles de Usuario'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Perfil de Usuario'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Perfil de Usuario'); ?> <small><?php echo __('Editar Perfil de Usuario'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Perfil de Usuario'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('PerfilUsuario'); ?>
					<?php echo $this->Form->input('usua_id', array('label' => __('Usuario'), 'options' => $usuarios, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('perf_id', array('label' => __('Perfil'), 'options' => $perfiles, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->input('peus_id'); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#PerfilUsuarioPerfId').on('change', function() {
		var perf_id = $(this).val();

		if (perf_id == 1) {
			$('#PerfilUsuarioCefaId').val('').attr('disabled', 'disabled');
		} else {
			$('#PerfilUsuarioCefaId').removeAttr('disabled');
		}
	});
});
</script>