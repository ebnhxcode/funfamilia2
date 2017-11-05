<div class="row page-header">
	<div class="col-xs-12">
		<h1><?php echo __('Sesiones'); ?> <small><?php echo __('Sesiones'); ?></small></h1>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Sesiones'); ?>
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
					<td><strong><?php echo __('Actividad'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_nombre']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Sesiones Planificadas'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_nro_sesiones']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Sesiones Ejecutadas'); ?></strong></td>
					<td><?php echo h($actividad[0]['total_ejecutadas']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Promedio de Asistencia por taller'); ?></strong></td>
					<td><?php echo number_format($actividad[0]['promedio_asistencia'], 2, ',', '.'); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Cobertura estimada final'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_cobertura_estimada']); ?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Sesiones'); ?>
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
					<th><?php echo __('Sesión'); ?></th>
					<th><?php echo __('Fecha de Ejecución'); ?></th>
					<th><?php echo __('N° de Participantes'); ?></th>
				</tr>
				<?php foreach ($sesiones as $sesi): ?>
					<tr>
						<td><?php echo $sesi['Sesion']['sesi_nombre']; ?></td>
						<td><?php echo !empty($sesi['Sesion']['sesi_fecha_ejecucion'])? CakeTime::format($sesi['Sesion']['sesi_fecha_ejecucion'], '%d-%m-%Y'): null; ?></td>
						<td><?php echo $sesi[0]['total_asistentes']; ?></td>						
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>