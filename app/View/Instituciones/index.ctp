
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Instituciones'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Instituciones'); ?> <small><?php echo __('Instituciones'); ?></small></h1>
	</div>
	<div class="col-xs-6">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Institución'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Instituciones Registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('inst_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('inst_nombre', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('tiin_nombre', __('Tipo de Institución')); ?></th>
						<th><?php echo $this->Paginator->sort('cefa_nombre', __('Centro Familiar')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($instituciones as $inst): ?>
						<tr>
							<td class="center"><?php echo h($inst['Institucion']['inst_id']); ?>&nbsp;</td>
							<td><?php echo h($inst['Institucion']['inst_nombre']); ?>&nbsp;</td>
							<td><?php echo h($inst['TipoInstitucion']['tiin_nombre']); ?>&nbsp;</td>
							<td><?php echo h($inst['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $inst['Institucion']['inst_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false)); 
										}
									?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $inst['Institucion']['inst_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la institución?', $inst['Institucion']['inst_id']));
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