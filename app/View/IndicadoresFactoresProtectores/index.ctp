
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Preguntas'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-md-9">
		<h1><?php echo __('Preguntas'); ?> <small><?php echo __('Preguntas'); ?></small></h1>
	</div>
	<div class="col-md-3">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Pregunta'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Pregunas Registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('ifpr_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('ifpr_descripcion', __('Descripcion')); ?></th>
						<th><?php echo $this->Paginator->sort('fapr_nombre', __('Factor Protector')); ?></th>
						<th><?php echo $this->Paginator->sort('nive_nombre', __('Nivel')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($indicadoresFactoresProtectores as $ifpr): ?>
						<tr>
							<td class="center"><?php echo h($ifpr['IndicadorFactorProtector']['ifpr_id']); ?>&nbsp;</td>
							<td><?php echo h($ifpr['IndicadorFactorProtector']['ifpr_descripcion']); ?>&nbsp;</td>
							<td><?php echo h($ifpr['FactorProtector']['fapr_nombre']); ?>&nbsp;</td>
							<td><?php echo h($ifpr['FactorProtector']['Nivel']['nive_nombre']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $ifpr['IndicadorFactorProtector']['ifpr_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $ifpr['IndicadorFactorProtector']['ifpr_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar el indicador?', $ifpr['IndicadorFactorProtector']['ifpr_id']));
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