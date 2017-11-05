
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Factores Protectores'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Factores Protectores'); ?> <small><?php echo __('Factores Protectores'); ?></small></h1>
	</div>
	<div class="col-xs-4">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa clip-cog-2"></i> '. __('Clonar'), array('action' => 'clonar'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nuevo Factor'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-left'));
			}
		?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Factores Protectores Registrados'); ?>
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
						<th><?php echo $this->Paginator->sort('fapr_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('fapr_nombre', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('nive_nombre', __('Nivel')); ?></th>
						<th><?php echo $this->Paginator->sort('grob_nombre', __('Grupo Objetivo')); ?></th>
						<th><?php echo $this->Paginator->sort('fapr_ano', __('Año')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($factoresProtectores as $fapr): ?>
						<tr>
							<td class="center"><?php echo h($fapr['FactorProtector']['fapr_id']); ?>&nbsp;</td>
							<td><?php echo h($fapr['FactorProtector']['fapr_nombre']); ?>&nbsp;</td>
							<td><?php echo h($fapr['Nivel']['nive_nombre']); ?>&nbsp;</td>
							<td><?php echo h($fapr['Nivel']['GrupoObjetivo']['grob_nombre']); ?>&nbsp;</td>
							<td><?php echo h($fapr['FactorProtector']['fapr_ano']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $fapr['FactorProtector']['fapr_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $fapr['FactorProtector']['fapr_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar el factor protector?', $fapr['FactorProtector']['fapr_id']));
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