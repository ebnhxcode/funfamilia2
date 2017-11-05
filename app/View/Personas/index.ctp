
<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Personas'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-6">
		<h1><?php echo __('Personas'); ?> <small><?php echo __('Personas'); ?></small></h1>
	</div>
	<div class="col-xs-4">
	</div>
	<div class="col-xs-2">
		<?php
			if ($perf_id != 8) {
				echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Persona'), array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-success pull-right'));
			}
		?>
	</div>
</div>

<?php
	echo $this->element('search_fino',
		array(
			'tipo' => 'personas',
			'combos' => $combos
		)
	);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Personas Registradas'); ?>
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
						<th><?php echo $this->Paginator->sort('Persona.pers_id', '#'); ?></th>
						<th><?php echo $this->Paginator->sort('CentroFamiliar.cefa_nombre', 'Centro Familiar'); ?></th>
						<th><?php echo $this->Paginator->sort('Persona.pers_run', __('RUN')); ?></th>
						<th><?php echo $this->Paginator->sort('Persona.pers_nombres', __('Nombres')); ?></th>
						<th><?php echo $this->Paginator->sort('Persona.pers_ap_paterno', __('Apellido Paterno')); ?></th>
						<th><?php echo $this->Paginator->sort('Persona.pers_ap_materno', __('Apellido Materno')); ?></th>
						<th><?php echo __('Acciones'); ?></th>
						<th><?php echo __('F/PT/P/FC'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($personas as $pers): ?>
						<tr>
							<td class="center"><?php echo h($pers['Persona']['pers_id']); ?>&nbsp;</td>
							<td><?php echo h($pers['CentroFamiliar']['cefa_nombre']); ?>&nbsp;</td>
							<td><?php echo h($pers['Persona']['pers_run']); ?>-<?php echo $pers['Persona']['pers_run_dv']; ?>&nbsp;</td>
							<td><?php echo h($pers['Persona']['pers_nombres']); ?>&nbsp;</td>
							<td><?php echo h($pers['Persona']['pers_ap_paterno']); ?>&nbsp;</td>
							<td><?php echo h($pers['Persona']['pers_ap_materno']); ?>&nbsp;</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										if ($perf_id == 1) {
											echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'edit', $pers['Persona']['pers_id'], $pers['PersonaCentroFamiliar']['pecf_id']), array('class' => 'btn btn-xs btn-teal tooltips', 'data-original-title' => __('Editar'), 'data-placement' => 'top', 'escape' => false));
										}
									?>
									<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('action' => 'view', $pers['Persona']['pers_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
									<?php
										if ($perf_id == 1) {
											echo $this->Form->postLink('<i class="fa fa-times fa fa-white"></i>', array('action' => 'delete', $pers['Persona']['pers_id']), array('class' => 'btn btn-xs btn-bricky tooltips', 'data-original-title' => __('Eliminar'), 'data-placement' => 'top', 'escape' => false), __('¿Está seguro de eliminar la persona seleccionada?', $pers['Persona']['pers_id']));
										}
									?>
								</div>
							</td>
							<td class="center">
								<div class="visible-md visible-lg visible-sm visible-xs">
									<?php
										// tiene familia?
										$titleTieneFamilia = ($pers['Persona']['fami_id'] != '')? __('Tiene familia'): __('No tiene familia');
										$classTieneFamilia = ($pers['Persona']['fami_id'] != '')? 'btn btn-xs btn-yellow tooltips': 'btn btn-xs btn-light-grey tooltips';
										if (!empty($pers['Persona']['fami_id'])) {
											echo $this->Html->link('<i class="fa"></i>', array('controller' => 'familias', 'action' => 'view', $pers['Persona']['fami_id']), array('target' => '_blank', 'class' => $classTieneFamilia, 'data-original-title' => $titleTieneFamilia, 'data-placement' => 'top', 'escape' => false));	
										} else {
											echo $this->Html->link('<i class="fa"></i>', array('action' => 'edit', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classTieneFamilia, 'data-original-title' => $titleTieneFamilia, 'data-placement' => 'top', 'escape' => false));
										}
									?>

									<?php
										// tiene plan de trabajo?
										$titlePlanTrabajo = (!empty($pers['Persona']['pers_plan_trabajo']))? __('Tiene plan de trabajo'): __('No tiene plan de trabajo');
										$classPlanTrabajo = (!empty($pers['Persona']['pers_plan_trabajo']))? 'btn btn-xs btn-red tooltips': 'btn btn-xs btn-light-grey tooltips';
										
										if (!empty($pers['Persona']['pers_plan_trabajo'])) {
											echo $this->Html->link('<i class="fa"></i>', array('action' => 'view', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classPlanTrabajo, 'data-original-title' => $titlePlanTrabajo, 'data-placement' => 'top', 'escape' => false));	
										} else {
											echo $this->Html->link('<i class="fa"></i>', array('action' => 'edit', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classPlanTrabajo, 'data-original-title' => $titlePlanTrabajo, 'data-placement' => 'top', 'escape' => false));
										}

									?>
									
									<?php
										// es participante?
										$titleEsParticipante = empty($pers[0]['f_participa_en_actividad_del_anyo'])? __('No participa'): __('Participa');
										$classEsParticipante = empty($pers[0]['f_participa_en_actividad_del_anyo'])? 'btn btn-xs btn-light-grey tooltips': 'btn btn-xs btn-purple tooltips';
										echo $this->Html->link('<i class="fa"></i>', array('action' => 'actividades_participantes', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classEsParticipante, 'data-original-title' => $titleEsParticipante, 'data-placement' => 'top', 'escape' => false));
									?>

									<?php
										// tiene ficha completa?
										$titleFichaCompleta = empty($pers[0]['f_persona_tiene_ficha_completa'])? __('Sin ficha completa'): __('Ficha completa');
										$classFichaCompleta = empty($pers[0]['f_persona_tiene_ficha_completa'])? 'btn btn-xs btn-light-grey tooltips': 'btn btn-xs btn-green tooltips';


										if (!empty($pers['Persona']['pers_plan_trabajo'])) {
											echo $this->Html->link('<i class="fa"></i>', array('action' => 'view', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classFichaCompleta, 'data-original-title' => $titleFichaCompleta, 'data-placement' => 'top', 'escape' => false));
										} else {
											echo $this->Html->link('<i class="fa"></i>', array('action' => 'edit', $pers['Persona']['pers_id']), array('target' => '_blank', 'class' => $classFichaCompleta, 'data-original-title' => $titleFichaCompleta, 'data-placement' => 'top', 'escape' => false));
										}


									?>

								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<table id="sample-table-1" class="table table-bordered">
				<tr>
					<td width="25%">
						<span class="btn-xs btn-yellow"><?php echo __('F'); ?></span> <?php echo __('Tiene Familia'); ?>
					</td>
					<td width="25%">
						<span class="btn-xs btn-red"><?php echo __('PT'); ?></span> <?php echo __('Tiene Plan de Trabajo'); ?>
					</td>
					<td width="25%">
						<span class="btn-xs btn-purple"><?php echo __('P'); ?></span> <?php echo __('Participa'); ?>
					</td>
					<td width="25%">
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