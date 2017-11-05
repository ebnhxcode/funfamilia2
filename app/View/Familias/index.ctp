
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Familias'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Familias'); ?> <small><?php echo __('Familias'); ?></small></h1>
	</div>
	<div class="col-xs-4">		
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Familia'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<?php
	echo $this->element('search_fino',
		array(
			'tipo' => 'familias',
			'combos' => $combos
		)
	);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Familias Registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('fami_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('CentroFamiliar.cefa_nombre', __('Centro Familiar')); ?></th>
						<th><?php echo $this->Paginator->sort('fami_ap_paterno', __('Apellido Paterno')); ?></th>
						<th><?php echo $this->Paginator->sort('fami_ap_materno', __('Apellido Materno')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
						<th><?php echo __('TP/P/FC'); ?></th>
						<th><?php echo __('Info. Actividades'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($familias as $fami): ?>
						<tr>
							<td class="center"><?php echo h($fami['Familia']['fami_id']); ?>&nbsp;</td>
							<td><?php echo h($fami['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td><?php echo h($fami['Familia']['fami_ap_paterno']); ?>&nbsp;</td>
							<td><?php echo h($fami['Familia']['fami_ap_materno']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id != 8) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $fami['Familia']['fami_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>	
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $fami['Familia']['fami_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									<?php
										if ($perf_id != 8) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $fami['Familia']['fami_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la familia seleccionada?', $fami['Familia']['fami_id']));
										}
									?>
								</div>
							</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										// tiene personas asociadas?
										$titleTienePersonas = !empty($fami['IntegranteFamiliar'])? __('Tiene personas'): __('No tiene personas');
										$classTienePersonas = !empty($fami['IntegranteFamiliar'])? 'btn btn-xs btn-yellow tooltips': 'btn btn-xs btn-light-grey tooltips';
										echo $this->Html->link('<i class="fa"></i>', array('action' => 'info_participantes', $fami['Familia']['fami_id']), array('target' => '_blank', 'class' => $classTienePersonas, 'data-original-title' => $titleTienePersonas, 'data-placement' => 'top', 'escape' => false));
									?>

									<?php
										// familia participa?
										$titleEsParticipante = empty($fami[0]['f_familia_participa_en_actividad_del_anyo'])? __('No participa'): __('Participa');
										$classEsParticipante = empty($fami[0]['f_familia_participa_en_actividad_del_anyo'])? 'btn btn-xs btn-light-grey tooltips': 'btn btn-xs btn-purple tooltips';
										echo $this->Html->link('<i class="fa"></i>', array('action' => 'actividades_participantes', $fami['Familia']['fami_id']), array('target' => '_blank', 'class' => $classEsParticipante, 'data-original-title' => $titleEsParticipante, 'data-placement' => 'top', 'escape' => false));
									?>

									<?php
										// tiene ficha completa?
										$titleFichaCompleta = empty($fami[0]['f_familia_tiene_ficha_completa'])? __('Sin ficha completa'): __('Ficha completa');
										$classFichaCompleta = empty($fami[0]['f_familia_tiene_ficha_completa'])? 'btn btn-xs btn-light-grey tooltips': 'btn btn-xs btn-green tooltips';
										echo $this->Html->link('<i class="fa"></i>', array('action' => 'edit', $fami['Familia']['fami_id']), array('target' => '_blank', 'class' => $classFichaCompleta, 'data-original-title' => $titleFichaCompleta, 'data-placement' => 'top', 'escape' => false));
									?>
								</div>
							</td>
							<td class="center">
								<?php echo $this->Html->link('<i class="fa fa-users"></i>', array('action' => 'actividades_participantes', $fami['Familia']['fami_id']), array('target' => '_blank', 'class' => 'btn btn-xs btn-yellow tooltips', 'data-original-title' => __('Información de actividades'), 'data-placement' => 'top', 'escape' => false)); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<table id="sample-table-1" class="table table-bordered">
				<tr>
					<td width="33%">
						<span class="btn-xs btn-yellow"><?php echo __('TP'); ?></span> <?php echo __('Tiene Personas'); ?>
					</td>
					<td width="33%">
						<span class="btn-xs btn-purple"><?php echo __('P'); ?></span> <?php echo __('Participa'); ?>
					</td>
					<td width="33%">
						<span class="btn-xs btn-green"><?php echo __('FC'); ?></span> <?php echo __('Ficha Completa'); ?>
					</td>
				</tr>
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