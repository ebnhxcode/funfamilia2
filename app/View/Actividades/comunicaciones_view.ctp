
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Actividades'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle de Actividad'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle de Actividad'); ?> <small><?php echo __('Detalle de Actividad'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Form->create('Actividad'); ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Actividad'); ?>
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
					<td><?php echo h($actividad['Actividad']['acti_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($actividad['CentroFamiliar']['cefa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Estado de Actividad'); ?></strong></td>
					<td><?php echo h($actividad['EstadoActividad']['esac_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Area'); ?></strong></td>
					<td><?php echo h($actividad['TipoActividad']['Area']['area_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Tipo de Actividad'); ?></strong></td>
					<td><?php echo h($actividad['TipoActividad']['tiac_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Descripción'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_descripcion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Población'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_poblacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Frecuencia'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_frecuencia']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Dirección'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_direccion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($actividad['Comuna']['comu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('¿Es Individual?'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_individual']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Institución'); ?></strong></td>
					<td><?php echo h($actividad['Institucion']['inst_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Monitor'); ?></strong></td>
					<td><?php echo h($actividad['Usuario']['usua_nombre_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('N° de Sesiones'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_nro_sesiones']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Permiso de edición'); ?></strong></td>
					<td><?php echo empty($actividad['Actividad']['acti_editable'])? 'No': 'Si'; ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha de inicio'); ?></strong></td>
					<td><?php echo $this->Time->format($actividad['Actividad']['acti_fecha_inicio'], '%d-%m-%Y'); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha de término'); ?></strong></td>
					<td><?php echo $this->Time->format($actividad['Actividad']['acti_fecha_termino'], '%d-%m-%Y'); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Observaciones'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_observaciones']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('¿Es Comunicacional?'); ?></strong></td>
					<td>
						<?php
							echo $this->Form->input('acti_id', array('div' => false, 'value' => $actividad['Actividad']['acti_id']));

							if ($actividad['Actividad']['acti_es_comunicacional'] == true) {
								echo $this->Form->input('acti_es_comunicacional', array('div' => false, 'checked' => true));
							} else {
								echo $this->Form->input('acti_es_comunicacional', array('div' => false));
							}
						?>
					</td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<div class="row">	
	<div class="col-sm-2 col-sm-offset-10">
		<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</div>
<br />
<?php echo $this->Form->end(); ?>