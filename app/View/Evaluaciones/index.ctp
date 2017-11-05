
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Evaluaciones'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Evaluaciones'); ?> <small><?php echo __('Evaluaciones'); ?></small></h1>
	</div>
	<div class="col-xs-4">
		<form method="GET" id="centroFamiliarFilter">
			<?php
				if (isset($cefaIdFilter)) {
					echo $this->Form->input('centroFamiliarCefaId', array('div' => false, 'name' => 'cefaId', 'class' => 'form-control pull-right', 'options' => $centrosFamiliares, 'empty' => __('-- Filtrar por Centro --'), 'value' => $cefaIdFilter));
				} else {
					echo $this->Form->input('centroFamiliarCefaId', array('div' => false, 'name' => 'cefaId', 'class' => 'form-control pull-right', 'options' => $centrosFamiliares, 'empty' => __('-- Filtrar por Centro --')));
				}
			?>
		</form>
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Evaluación'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Evaluaciones Registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('eval_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('cefa_nombre', __('Centro Familiar')); ?></th>
						<th><?php echo $this->Paginator->sort('tiev_nombre', __('Tipo de Evaluación')); ?></th>
						<th><?php echo $this->Paginator->sort('pers_run', __('RUN')); ?></th>
						<th><?php echo $this->Paginator->sort('(pers_nombres || \' \' || pers_ap_paterno || \' \' || pers_ap_materno)', __('Nombre')); ?></th>
						<th><?php echo $this->Paginator->sort('eval_fecha', __('Fecha')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($evaluaciones as $eval): ?>
						<tr>
							<td class="center"><?php echo h($eval['Evaluacion']['eval_id']); ?>&nbsp;</td>
							<td><?php echo h($eval['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td><?php echo h($eval['TipoEvaluacion']['tiev_nombre']); ?>&nbsp;</td>
							<td><?php echo h($eval['Persona']['pers_run'].'-'.$eval['Persona']['pers_run_dv']); ?>&nbsp;</td>
							<td><?php echo h($eval['Persona']['pers_nombres'].' '.$eval['Persona']['pers_ap_paterno'].' '.$eval['Persona']['pers_ap_materno']); ?>&nbsp;</td>
							<td><?php echo $this->Time->format($eval['Evaluacion']['eval_fecha'], '%d-%m-%Y'); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $eval['Evaluacion']['eval_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $eval['Evaluacion']['eval_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $eval['Evaluacion']['eval_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la evaluación?'));
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

<script>
$(document).ready(function() {
	$('#centroFamiliarCefaId').on('change', function() {
		$('#centroFamiliarFilter').submit();
	});
});
</script>