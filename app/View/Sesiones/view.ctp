
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Sesiones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle de Sesión'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle de Sesión'); ?> <small><?php echo __('Detalle de Sesión'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Sesión'); ?>
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
					<td><strong>#</strong></td>
					<td><?php echo h($sesion['Sesion']['sesi_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Actividad'); ?></strong></td>
					<td><?php echo h($sesion['Actividad']['acti_nombre']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($sesion['Actividad']['CentroFamiliar']['cefa_nombre']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('N° de Sesión'); ?></strong></td>
					<td><?php echo h($sesion['Sesion']['sesi_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha de Ejecución'); ?></strong></td>
					<td><?php echo !empty($sesion['Sesion']['sesi_fecha_ejecucion'])? $this->Time->format($sesion['Sesion']['sesi_fecha_ejecucion'], '%d-%m-%Y'): null; ?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Asistentes'); ?>
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
					<th><?php echo __('RUN'); ?></th>
					<th><?php echo __('Nombre'); ?></th>
				</tr>
				<?php foreach ($asistencias as $asis): ?>
					<tr>
						<td><?php echo $asis['Persona']['pers_run']; ?>-<?php echo $asis['Persona']['pers_run_dv']; ?></td>
						<td><?php echo $asis['Persona']['pers_ap_paterno']; ?> <?php echo $asis['Persona']['pers_ap_materno']; ?> <?php echo $asis['Persona']['pers_nombres']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>