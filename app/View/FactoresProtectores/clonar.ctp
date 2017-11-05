<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Factores Protectores'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Clonar Factores Protectores'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Clonar Factores Protectores'); ?> <small><?php echo __('Clonar Factores Protectores'); ?></small></h1>
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
					<?php echo $this->Form->input('fapr_ano_desde', array('label' => __('Desde'), 'options' => $anos, 'required' => 'required', 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php
						$postAnos = array();
						for ($i=date('Y'); $i<=date('Y')+3; $i++) {
							$postAnos[$i] = $i;
						}
						echo $this->Form->input('fapr_ano_hasta', array('label' => __('A'), 'options' => $postAnos, 'required' => 'required', 'empty' => __('-- Seleccione Opción --')));
					?>
					
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
	$('#FactorProtectorClonarForm').on('submit', function() {
		var desde = $('#FactorProtectorFaprAnoDesde').val();
		var a = $('#FactorProtectorFaprAnoHasta').val(); 

		if (desde != '' && a != '') {
			var c = confirm('La acción clonará los factores protectores y sus indicadores desde el año '+ desde + ' al año '+ a + '. ¿Está seguro que desea continuar?');
			if (c) {
				return true;
			}
		}

		return false;
	});
});
</script>