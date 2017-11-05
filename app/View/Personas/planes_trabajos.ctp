<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Planes de Trabajo'); ?> <small><?php echo __('Planes de Trabajo'); ?></small></h1>
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
		<?php echo __('Planes de Trabajo'); ?>
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
					<th><?php echo __('Grupo Objetivo'); ?></th>
					<th><?php echo __('Fecha de creación'); ?></th>
					<th><?php echo __('Acciones'); ?></th>
				</tr>
				<?php foreach ($planesTrabajos as $pltr): ?>
					<tr>
						<td><?php echo $pltr['GrupoObjetivo']['grob_nombre']; ?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($pltr['PlanTrabajo']['pltr_fecha_creacion'])); ?></td>
						<td>							
							<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'planes_trabajos', 'action' => 'view', $pltr['PlanTrabajo']['pltr_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
							<?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('controller' => 'planes_trabajos', 'action' => 'edit', $pltr['PlanTrabajo']['pltr_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false)); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>