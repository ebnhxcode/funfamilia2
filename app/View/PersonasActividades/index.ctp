
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Inscripciones'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-7">
		<h1><?php echo __('Inscripciones'); ?> <small><?php echo __('Inscripciones'); ?></small></h1>
	</div>
	<div class="col-xs-3">
		<!--
		<?php if ($perf_id == 1 || $perf_id == 8 || $perf_id == 9): ?>
			<form method="GET" id="centroFamiliarFilter">
				<?php
					if (isset($cefaIdFilter)) {
						echo $this->Form->input('centroFamiliarCefaId', array('div' => false, 'name' => 'cefaId', 'class' => 'form-control pull-right', 'options' => $centrosFamiliares, 'empty' => __('-- Filtrar por Centro --'), 'value' => $cefaIdFilter));
					} else {
						echo $this->Form->input('centroFamiliarCefaId', array('div' => false, 'name' => 'cefaId', 'class' => 'form-control pull-right', 'options' => $centrosFamiliares, 'empty' => __('-- Filtrar por Centro --')));
					}
				?>
			</form>
		<?php endif; ?>
		-->
		<?php
			if ($perf_id != 8) {
				if ($perf_id == 3 || $perf_id == 10) {
					echo $this->Html->link('<i class="fa clip-cog-2"></i> '. __('Clonar Participantes'), array('action' => 'clonar'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
				}
			}
		?>
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Inscripción'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<?php
	echo $this->element('search_fino',
		array(
			'tipo' => 'inscripciones',
			'combos' => $combos
		)
	);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Inscripciones'); ?>
		<div class="panel-tools">
			<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
			</a>
			<a href="#" class="btn btn-xs btn-link panel-expand">
				<i class="fa fa-expand"></i>
			</a>
		</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table id="sample-table-1" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('acti_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('acti_nombre', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('tiac_nombre', __('Tipo de Actividad')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_inicio', __('Inicio')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_termino', __('Término')); ?></th>
						<th><?php echo $this->Paginator->sort('TotalPersonaActividad.total_personas', __('N° de Inscripciones')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_anio', __('Año')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($actividades as $acti): ?>
						<tr>
							<td class="center"><?php echo h($acti['Actividad']['acti_id']); ?>&nbsp;</td>
							<td><?php echo h($acti['Actividad']['acti_nombre']); ?>&nbsp;</td>
							<td><?php echo h($acti['TipoActividad']['tiac_nombre']); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_inicio'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_termino'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo h($acti['TotalPersonaActividad']['total_personas']); ?>&nbsp;</td>
							<td><?php echo h($acti['Actividad']['acti_anio']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									
									<?php
										if ($perf_id != 3 && $perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la inscripción seleccionada junto con todos sus asistentes?', $acti['Actividad']['acti_id']));
										}
									?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php echo $this->element('paginator'); ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#centroFamiliarCefaId').on('change', function() {
		$('#centroFamiliarFilter').submit();
	});
});
</script>