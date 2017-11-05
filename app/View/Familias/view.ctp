
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Familias'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle de Familia'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle de Familia'); ?> <small><?php echo __('Detalle de Familia'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Familia'); ?>
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
					<td><?php echo h($familia['Familia']['fami_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($familia['CentroFamiliar']['cefa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Apellido Paterno'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_ap_paterno']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Apellido Materno'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_ap_materno']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Dirección'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_direccion_completa']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($familia['Comuna']['comu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fono Fijo'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_nro_fijo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fono móvil'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_nro_movil']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Observación'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_observacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Jefatura de Hogar'); ?></strong></td>
					<td><?php echo h($familia['Persona']['pers_nombre_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Tipo de Familia'); ?></strong></td>
					<td><?php echo h($familia['TipoFamilia']['tifa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Red'); ?></strong></td>
					<td><?php echo h($familia['Red']['rede_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Acciones'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_acciones']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Situación Habitacional'); ?></strong></td>
					<td><?php echo h($familia['SituacionHabitacional']['siha_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Observación de Coordinación'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_obs_coordinacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Otras Observaciones'); ?></strong></td>
					<td><?php echo h($familia['Familia']['fami_otras_observaciones']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Ultima actualización'); ?></strong></td>
					<td><?php echo empty($familia['Familia']['fami_fecha_act'])? null: $this->Time->format($familia['Familia']['fami_fecha_act'], '%d-%m-%Y %H:%M:%S'); ?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<!-- SE SACA A PEDIDO DE XIMENA ARRIAGADA 22-12-2014 -->
<!--
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Factores de Riesgos'); ?>
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
					<th><?php echo __('Factor'); ?></th>
					<th><?php echo __('Presente/Ausente'); ?></th>
					<th><?php echo __('Comentarios'); ?></th>
				</tr>
				<?php foreach ($familia['FactorRiesgoFamilia'] as $frfa): ?>
					<tr>
						<td><?php echo $frfa['FactorRiesgo']['fari_descripcion']; ?></td>
						<td><?php echo empty($frfa['frfa_aplica'])? 'No': 'Si'; ?></td>
						<td><?php echo $frfa['frfa_observaciones']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
-->

<!-- SE SACA A PEDIDO DE XIMENA ARRIAGADA 02-12-2014 -->
<!--
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Condiciones de Vulnerabilidad'); ?>
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
					<th><?php echo __('Condición'); ?></th>
					<th><?php echo __('Presente/Ausente'); ?></th>
					<th><?php echo __('Comentarios'); ?></th>
				</tr>
				<?php foreach ($familia['CondicionVulnerabilidadFamilia'] as $cvfa): ?>
					<tr>
						<td><?php echo $cvfa['CondicionVulnerabilidad']['covu_nombre']; ?></td>
						<td><?php echo empty($cvfa['cvfa_aplica'])? 'No': 'Si'; ?></td>
						<td><?php echo $cvfa['cvfa_observaciones']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
-->

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Otros Integrantes'); ?>
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
					<th><?php echo __('Parentesco'); ?></th>
					<th></th>
				</tr>
				<?php foreach ($familia['IntegranteFamiliar'] as $persona): ?>
					<tr>
						<td><?php echo $persona['pers_run_completo']; ?></td>
						<td><?php echo $persona['pers_nombre_completo']; ?></td>
						<td><?php echo !empty($persona['Parentesco']['pare_nombre'])? $persona['Parentesco']['pare_nombre']: null; ?></td>
						<td class="center">
							<div class="visible-md visible-lg visible-sm visible-xs">
								<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'personas', 'action' => 'view', $persona['pers_id']), array('class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
