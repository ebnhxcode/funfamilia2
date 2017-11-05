
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
					<td><strong><?php echo __('Programa'); ?></strong></td>
					<td><?php echo h($actividad['TipoActividad']['Area']['Programa']['prog_nombre']); ?></td>
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
					<td><strong><?php echo __('Cobertura Esperada'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_cobertura_esperada']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Día 1/Hora 1'); ?></strong></td>
					<td>
						<?php
							if (isset($actividad['Actividad']['acti_dia']) && isset($actividad['Actividad']['acti_hora'])) {
								$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
								echo h($dias[$actividad['Actividad']['acti_dia']]); ?> - <?php echo h($actividad['Actividad']['acti_hora']);
							}
						?>
					</td>
				</tr>
				<tr>
					<td><strong><?php echo __('Día 2/Hora 2'); ?></strong></td>
					<td>
						<?php
							if (isset($actividad['Actividad']['acti_dia2']) && isset($actividad['Actividad']['acti_hora2'])) {
								$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
								echo h($dias[$actividad['Actividad']['acti_dia2']]); ?> - <?php echo h($actividad['Actividad']['acti_hora2']);
							}
						?>
					</td>
				</tr>
				<tr>
					<td><strong><?php echo __('Día 3/Hora 3'); ?></strong></td>
					<td>
						<?php
							if (isset($actividad['Actividad']['acti_dia3']) && isset($actividad['Actividad']['acti_hora3'])) {
								$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
								echo h($dias[$actividad['Actividad']['acti_dia3']]); ?> - <?php echo h($actividad['Actividad']['acti_hora3']);
							}
						?>
					</td>
				</tr>
				<tr>
					<td><strong><?php echo __('Cobertura y Público'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_poblacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Frecuencia'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_frecuencia']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Lugar de ejecución y dirección'); ?></strong></td>
					<td><?php echo h($actividad['Actividad']['acti_direccion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($actividad['Comuna']['comu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('¿Es Individual?'); ?></strong></td>
					<td><?php echo ($actividad['Actividad']['acti_individual'] == 1)? 'Si': 'No'; ?></td>
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
					<td><strong><?php echo __('¿Es Comunicacional?'); ?></strong></td>
					<td><?php echo empty($actividad['Actividad']['acti_es_comunicacional'])? 'No': 'Si'; ?></td>
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
			</table>
		</div>	
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Presupuesto'); ?>
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
					<th><?php echo __('Concepto'); ?></th>
					<th><?php echo __('Fuente de Financiamiento'); ?></th>
					<th><?php echo __('Detalle'); ?></th>
					<th><?php echo __('Cantidad'); ?></th>
					<th><?php echo __('Valor Unitario'); ?></th>
					<th><?php echo __('Total'); ?></th>
				</tr>
				<?php $sumaTotal = 0; ?>
				<?php foreach ($actividad['GastoActividad'] as $gaac): ?>
					<tr>
						<td><?php echo $gaac['Concepto']['conc_nombre']; ?></td>
						<td><?php echo $gaac['FuenteFinanciamiento']['fufi_nombre']; ?></td>
						<td><?php echo $gaac['gaac_detalle'] ?></td>
						<td><?php echo $gaac['gaac_cantidad'] ?></td>
						<td>$<?php echo number_format($gaac['gaac_valor_unitario'], 0, ',', '.'); ?></td>
						<td>$<?php echo number_format($gaac['gaac_total'], 0, ',', '.'); ?></td>
					</tr>
				<?php $sumaTotal += $gaac['gaac_total']; ?>
				<?php endforeach; ?>
				<tr>
					<th colspan="6">
						<span class="pull-right">Total: $<?php echo number_format($sumaTotal, 0, ',', '.'); ?></span>
					</th>
				</tr>
			</table>
		</div>
	</div>
</div>
