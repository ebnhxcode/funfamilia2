
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Personas'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle Persona'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle Persona'); ?> <small><?php echo __('Detalle Persona'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle Persona'); ?>
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
					<td width="25%"><strong>#</strong></td>
					<td><?php echo h($persona['Persona']['pers_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('RUN'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_run_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombres'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_nombres']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Apellido Paterno'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_ap_paterno']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Apellido Materno'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_ap_materno']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha de Nacimiento'); ?></strong></td>
					<td><?php echo !empty($persona['Persona']['pers_fecha_nacimiento'])? $this->Time->format(h($persona['Persona']['pers_fecha_nacimiento']), '%d-%m-%Y'): null; ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Dirección'); ?></strong></td>
					<td><?php echo h($persona['Direccion']['dire_direccion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($persona['Comuna']['comu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Correo Electrónico'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_email']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fono Fijo'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_nro_fijo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fono Móvil'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_nro_movil']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Ocupación'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_ocupacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Estado Civil'); ?></strong></td>
					<td><?php echo h($persona['EstadoCivil']['esci_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Pueblo Originario'); ?></strong></td>
					<td><?php echo h($persona['PuebloOriginario']['puor_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nacionalidad'); ?></strong></td>
					<td><?php echo h($persona['Nacionalidad']['naci_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Estudios'); ?></strong></td>
					<td><?php echo h($persona['Estudio']['estu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Salud'); ?></strong></td>
					<td><?php echo h($persona['InstitucionSalud']['inst_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Previsión'); ?></strong></td>
					<td><?php echo h($persona['InstitucionPrevision']['inst_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('¿Tiene Discapacidad?'); ?></strong></td>
					<td><?php echo empty(h($persona['Persona']['pers_discapacidad']))? 'No': 'Si'; ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Familia'); ?></strong></td>
					<td><?php echo h($persona['Familia']['fami_nombre_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Parentesco'); ?></strong></td>
					<td><?php echo h($persona['Parentesco']['pare_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Grupo Objetivo'); ?></strong></td>
					<td><?php echo h($persona['GrupoObjetivo']['grob_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Plan de Trabajo'); ?></strong></td>
					<td><?php echo h($persona['Persona']['pers_plan_trabajo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Ultima actualización'); ?></strong></td>
					<td><?php echo empty($persona['Persona']['pers_fecha_act'])? null: $this->Time->format($persona['Persona']['pers_fecha_act'], '%d-%m-%Y %H:%M:%S'); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Centros Familiares en los que la persona participa'); ?>
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
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Dirección'); ?></th>
				</tr>
				<?php foreach($persona['CentroFamiliar'] as $centroFamiliar): ?>
					<tr>
						<td><?php echo $centroFamiliar['cefa_nombre']; ?></td>
						<td><?php echo $centroFamiliar['cefa_direccion']; ?></td>
					</tr>	
				<?php endforeach;?>
			</table>
		</tr>
	</div>
</div>