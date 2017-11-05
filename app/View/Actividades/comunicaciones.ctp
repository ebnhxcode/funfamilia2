
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
	<div class="col-xs-12">
		<h1><?php echo __('Actividades'); ?> <small><?php echo __('Actividades'); ?></small></h1>
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
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('cefa_nombre', __('Centro Familiar')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('acti_nombre', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('tiac_nombre', __('Tipo de Actividad')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_inicio', __('Inicio')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_fecha_termino', __('Término')); ?></th>
						<th><?php echo $this->Paginator->sort('acti_es_comunicacional', __('¿Comunicacional?')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($actividades as $acti): ?>
						<tr>
							<td><?php echo h($acti['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td class="center"><?php echo h($acti['Actividad']['acti_id']); ?>&nbsp;</td>
							<td><?php echo h($acti['Actividad']['acti_nombre']); ?>&nbsp;</td>
							<td><?php echo h($acti['TipoActividad']['tiac_nombre']); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_inicio'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($acti['Actividad']['acti_fecha_termino'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td><?php echo ($acti['Actividad']['acti_es_comunicacional'] == 1)? 'Si': 'No'; ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'comunicaciones_view', $acti['Actividad']['acti_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
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