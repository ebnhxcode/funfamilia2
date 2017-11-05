<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Actividades'); ?> <small><?php echo __('Actividades'); ?></small></h1>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Familia'); ?>
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
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_nombre_completo']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Dirección'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_direccion_completa']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($familia['Comuna']['comu_nombre']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($familia['CentroFamiliar']['cefa_nombre']); ?></strong></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Actividades que participan sus integrantes'); ?>
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
					<th><?php echo __('RUT'); ?></th>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Actividad'); ?></th>
					<th><?php echo __('Centro Familiar'); ?></th>
				</tr>
				<?php foreach ($integrantes as $inte): ?>
					<?php $inte = array_pop($inte); ?>
					<tr>
						<td><?php echo $inte['pers_run']; ?>-<?php echo $inte['pers_run_dv']; ?></td>
						<td><?php echo $inte['pers_nombres']; ?> <?php echo $inte['pers_ap_paterno']; ?> <?php echo $inte['pers_ap_materno']; ?></td>
						<td><?php echo $inte['acti_nombre']; ?></td>
						<td><?php echo $inte['cefa_nombre']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>