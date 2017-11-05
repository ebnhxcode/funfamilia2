
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Plane de Acompañamiento'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle de Plan de Acompañamiento'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle de Plan de Acompañamiento'); ?> <small><?php echo __('Detalle de Plan de Acompañamiento'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Plan de Acompañamiento'); ?>
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
					<td><?php echo h($planTrabajo['PlanTrabajo']['pltr_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($planTrabajo['PersonaCentroFamiliar']['CentroFamiliar']['cefa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('RUN'); ?></strong></td>
					<td><?php echo h($planTrabajo['PersonaCentroFamiliar']['Persona']['pers_run_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($planTrabajo['PersonaCentroFamiliar']['Persona']['pers_nombre_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha'); ?></strong></td>
					<td><?php echo $this->Time->format($planTrabajo['PlanTrabajo']['pltr_fecha_creacion'], '%d-%m-%Y'); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Plan de Acompañamiento'); ?></strong></td>
					<td><?php echo h($planTrabajo['PlanTrabajo']['plan_trabajo']); ?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Plan de Acompañamiento'); ?>
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
					<th><?php echo __('Nivel'); ?></th>
					<th><?php echo __('Factor Protector'); ?></th>
					<th><?php echo __('Actividad'); ?></th>
					<th><?php echo __('Observaciones'); ?></th>
				</tr>
				<?php foreach ($planTrabajo['DetallePlanTrabajo'] as $dept): ?>
					<tr>
						<td><?php echo $dept['FactorProtector']['Nivel']['nive_nombre']; ?></td>
						<td><?php echo trim($dept['FactorProtector']['fapr_objetivos']); ?></td>
						<td><?php echo trim($dept['Actividad']['acti_nombre']); ?></td>
						<td><?php echo $dept['dept_observaciones']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>