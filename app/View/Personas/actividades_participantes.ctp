<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Actividades'); ?> <small><?php echo __('Actividades'); ?></small></h1>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Persona'); ?>
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
				<tr>
					<td><strong><?php echo __('RUT'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_run_completo']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_nombre_completo']); ?></strong></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

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
				<tr>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Tipo de Actividad'); ?></th>
					<th><?php echo __('Centro Familiar'); ?></th>
					<th><?php echo __('N° de sesiones en las que participó'); ?></th>
					<th><?php echo __('Año'); ?></th>
				</tr>
				<?php foreach ($actividades as $acti): ?>
					<tr>
						<td><?php echo $acti['Actividad']['acti_nombre']; ?></td>
						<td><?php echo $acti['TipoActividad']['tiac_nombre']; ?></td>
						<td><?php echo $acti['CentroFamiliar']['cefa_nombre']; ?></td>
						<td><?php echo $acti[0]['total_sesiones']; ?></td>
						<td><?php echo date('Y', strtotime($acti['Actividad']['acti_fecha_inicio'])); ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>