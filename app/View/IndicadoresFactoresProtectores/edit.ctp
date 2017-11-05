<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Preguntas'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Pregunta'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Pregunta'); ?> <small><?php echo __('Editar Pregunta'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Pregunta'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('IndicadorFactorProtector'); ?>
					<?php echo $this->Form->input('Nivel.nive_id', array('label' => __('Nivel'), 'options' => $niveles, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('fapr_id', array('label' => __('Factor Protector'), 'options' => $factoresProtectores, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('ifpr_descripcion', array('label' => __('Pregunta'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->input('ifpr_id'); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#NivelNiveId').on('change', function() {
		var nive_id = $(this).val();

		if (nive_id != '') {
			$.ajax({
				type: 'POST',
				url: '/factores_protectores/find_factores_by_nivel',
				data: {
					nive_id: nive_id
				},
				cache: false,
				dataType: 'json',
				beforeSend: function() {
					$('#IndicadorFactorProtectorFaprId').html('').append('<option>-- Seleccione Opción --</option>');
				},
				success: function(data) {
					var htmlStr = '';
					$.each(data, function(i, obj) {
						htmlStr += '<option value="'+ obj.FactorProtector.fapr_id +'">'+ obj.FactorProtector.fapr_nombre +'</option>';
					});

					$('#IndicadorFactorProtectorFaprId').append(htmlStr);
				},
				error: function() {
					alert('Ha ocurrido un error al procesar su petición');
				}
			});
		}
	});
});
</script>