
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Sesiones'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Sesiones'); ?> <small><?php echo __('Sesiones'); ?></small></h1>
	</div>
	<div class="col-xs-4">		
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Sesión'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<?php
	echo $this->element('search_fino',
		array(
			'tipo' => 'sesiones',
			'combos' => $combos
		)
	);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Sesiones registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('sesi_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('acti_nombre', __('Actividad')); ?></th>
						<th><?php echo $this->Paginator->sort('sesi_nombre', __('Sesión N°')); ?></th>
						<th><?php echo $this->Paginator->sort('AsistenciaSesion.total_asistencias', __('N° Asistentes')); ?></th>
						<th><?php echo $this->Paginator->sort('sesi_fecha_ejecucion', __('Fecha de Ejecución')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($sesiones as $sesi): ?>
						<tr>
							<td class="center"><?php echo h($sesi['Sesion']['sesi_id']); ?>&nbsp;</td>
							<td><?php echo h($sesi['Actividad']['acti_nombre']); ?>&nbsp;</td>
							<td><?php echo h($sesi['Sesion']['sesi_nombre']); ?>&nbsp;</td>
							<td><?php echo h($sesi['AsistenciaSesion']['total_asistencias']); ?>&nbsp;</td>
							<td><?php echo !empty($sesi['Sesion']['sesi_fecha_ejecucion'])? $this->Time->format($sesi['Sesion']['sesi_fecha_ejecucion'], '%d-%m-%Y'): null; ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										// para perfil comuna y DAF
										if ($perf_id == 3) {
										} else {
											if ($perf_id != 8) {
												echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $sesi['Sesion']['sesi_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
											}
										}
									?>
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $sesi['Sesion']['sesi_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $sesi['Sesion']['sesi_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la sesión seleccionada?', $sesi['Sesion']['sesi_id']));
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