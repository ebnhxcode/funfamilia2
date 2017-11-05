<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Actividades'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Actividades'); ?> <small><?php echo __('Actividades'); ?></small></h1>
	</div>
	<div class="col-xs-4">		
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Actividad'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<?php
	echo $this->element('search_fino',
		array(
			'tipo' => 'actividades',
			'combos' => $combos
		)
	);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Actividades'); ?>
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
						<th><?php echo $this->Paginator->sort('prog_id', 'Programa'); ?></th>
						<th><?php echo $this->Paginator->sort('cefa_nombre', __('Centro Familiar')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_nombre', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('TipoActividad.tiac_nombre', __('Tipo de Actividad')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_inicio', __('Inicio')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_termino', __('Término')); ?></th>
						<th><?php echo $this->Paginator->sort('EstadoActividad.esac_nombre', __('Estado')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
						<th><?php echo __('Info. Sesiones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($actividades as $acti): ?>
						<tr>
							<td class="center"><?php echo h($acti['Actividad']['acti_id']); ?>&nbsp;</td>
							<td class="center"><?php echo h($acti['TipoActividad']['Area']['Programa']['prog_nombre']); ?>&nbsp;</td>
							<td><?php echo h($acti['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td><?php echo h($acti['Actividad']['acti_nombre']); ?>&nbsp;</td>
							<td><?php echo h($acti['TipoActividad']['tiac_nombre']); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_inicio'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_termino'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo h($acti['EstadoActividad']['esac_nombre']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										// para perfil comuna
										if ($perf_id == 3) {
											if ($acti['Actividad']['acti_editable'] == true) {
												echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
											} else {
												// permiso para editar solo la cobertura estimada (solo masivas)
												if ($acti['Actividad']['acti_individual'] == false) {
													echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit_cobertura_estimada', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-orange tooltips', 'data-original-title' => __('Editar Cobertura Estimada'), 'data-placement' => 'top', 'escape' => false));
												}
											}
										} else {
											if ($perf_id != 8) {
												echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
											}
										}
									?>

									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la actividad seleccionada?', $acti['Actividad']['acti_id']));
										}
									?>
								</div>
							</td>
							<td class="center">
								<?php echo $this->Html->link('<i class="fa fa-users"></i>', array('action' => 'info_sesiones', $acti['Actividad']['acti_id']), array('target' => '_blank', 'class' => 'btn btn-xs btn-yellow tooltips', 'data-original-title' => __('Información de sesiones'), 'data-placement' => 'top', 'escape' => false)); ?>
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