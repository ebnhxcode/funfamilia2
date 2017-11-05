<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Familias'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Familia'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Familia'); ?> <small><?php echo __('Editar Familia'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Familia'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Familia'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('fami_ap_paterno', array('label' => __('Apellido Paterno'))); ?>
				<?php echo $this->Form->input('fami_ap_materno', array('label' => __('Apellido Materno'))); ?>
				<?php echo $this->Form->input('fami_direccion_calle', array('label' => __('Calle'), 'type' => 'text')); ?>
				<?php echo $this->Form->input('fami_direccion_nro', array('label' => __('Número'))); ?>
				<?php echo $this->Form->input('fami_direccion_block', array('label' => __('Block'))); ?>
				<?php echo $this->Form->input('fami_direccion_depto', array('label' => __('Departamento'))); ?>
				<?php echo $this->Form->input('comu_id', array('label' => __('Comuna'), 'options' => $comunas, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('fami_nro_fijo', array('label' => __('Teléfono Fijo'))); ?>
				<?php echo $this->Form->input('fami_nro_movil', array('label' => __('Teléfono Móvil'))); ?>
				<?php echo $this->Form->input('fami_observacion', array('label' => __('Observación'))); ?>
				
				<?php echo $this->Form->input('pers_nombre', array('label' => __('Jefatura de Hogar'), 'type' => 'text')); ?>
				<?php echo $this->Form->input('pers_id', array('type' => 'hidden', 'div' => false)); ?>

				<?php echo $this->Form->input('tifa_id', array('label' => __('Tipo de Familia'), 'options' => $tiposFamilias, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('rede_id', array('label' => __('Red'), 'options' => $redes, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('fami_acciones', array('label' => __('Acciones'))); ?>
				<?php echo $this->Form->input('siha_id', array('label' => __('Situacion Habitacional'), 'options' => $situacionesHabitacionales, 'empty' => __('-- Seleccione Opción --'))); ?>
				
				<?php echo $this->Form->input('fami_obs_coordinacion', array('label' => __('Observación de Coordinación'))); ?>
				<?php echo $this->Form->input('fami_otras_observaciones', array('label' => __('Otras observaciones'))); ?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Integrantes del grupo familiar'); ?>
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
					<th><?php echo __('Jefatura de Hogar'); ?></th>
					<th></th>
				</tr>
				<?php foreach ($integrantes as $persona): ?>
					<tr>
						<td><?php echo $persona['IntegranteFamiliar']['pers_run_completo']; ?></td>
						<td><?php echo $persona['IntegranteFamiliar']['pers_nombre_completo']; ?></td>
						<td><?php echo !empty($persona['Parentesco']['pare_nombre'])? $persona['Parentesco']['pare_nombre']: null; ?></td>
						<td><?php echo ($persona['IntegranteFamiliar']['pers_id'] == $this->data['Familia']['pers_id'])? 'Si': 'No'; ?></td>
						<td class="center">
							<div class="visible-md visible-lg visible-sm visible-xs">
								<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'personas', 'action' => 'edit', $persona['IntegranteFamiliar']['pers_id']), array('target' => '_blank', 'class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

<!-- SE SACA A PEDIDO DE XIMENA ARRIAGADA 22-12-2014 -->
<!--
<div class="row">
	<div class="col-sm-12">
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
						<thead>
							<tr>
								<th><?php echo __('Factor'); ?></th>
								<th><?php echo __('Presente/Ausente'); ?></th>
								<th><?php echo __('Comentarios'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 0; ?>
							<?php foreach($factoresRiesgos as $fari): ?>
								<tr>
									<td><?php echo h($fari['FactorRiesgo']['fari_descripcion']); ?>&nbsp;</td>
									<td class="center"><?php echo $this->Form->input('FactorRiesgoFamilia.'.$index.'.frfa_aplica', array('label' => false, 'type' => 'checkbox')); ?>&nbsp;</td>
									<td>
										<?php echo $this->Form->input('FactorRiesgoFamilia.'.$index.'.fari_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => $fari['FactorRiesgo']['fari_id'])); ?>
										<?php echo $this->Form->input('FactorRiesgoFamilia.'.$index.'.frfa_id', array('label' => false, 'div' => false)); ?>
										<?php echo $this->Form->input('FactorRiesgoFamilia.'.$index.'.frfa_observaciones', array('label' => false, 'div' => false, 'type' => 'text')); ?>
									</td>
								</tr>
								<?php $index++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
-->

<!-- SE SACA A PEDIDO DE XIMENA ARRIAGADA 02-12-2014 -->
<!-- 
<div class="row">
	<div class="col-sm-12">
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
						<thead>
							<tr>
								<th><?php echo __('Condición'); ?></th>
								<th><?php echo __('Presente/Ausente'); ?></th>
								<th><?php echo __('Comentarios'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $index = 0; ?>
							<?php foreach($condicionesVulnerabilidad as $covu): ?>
								<tr>
									<td><?php echo h($covu['CondicionVulnerabilidad']['covu_nombre']); ?>&nbsp;</td>
									<td class="center"><?php echo $this->Form->input('CondicionVulnerabilidadFamilia.'.$index.'.cvfa_aplica', array('label' => false, 'type' => 'checkbox')); ?>&nbsp;</td>
									<td>
										<?php echo $this->Form->input('CondicionVulnerabilidadFamilia.'.$index.'.covu_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'value' => $covu['CondicionVulnerabilidad']['covu_id'])); ?>
										<?php echo $this->Form->input('CondicionVulnerabilidadFamilia.'.$index.'.cvfa_id', array('label' => false, 'div' => false)); ?>
										<?php echo $this->Form->input('CondicionVulnerabilidadFamilia.'.$index.'.cvfa_observaciones', array('label' => false, 'div' => false, 'type' => 'text')); ?>
									</td>
								</tr>
								<?php $index++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
-->

<div class="row">	
	<div class="col-sm-2 col-sm-offset-10">
		<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</div>
<br />
<?php echo $this->Form->input('fami_id'); ?>
<?php echo $this->Form->end(); ?>



<script>
$(document).ready(function() {

	// todo input en mayuscula
	$('input[type=text]').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});

	var personas = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/personas/find_personas?q=%QUERY',
			filter: function(list) {
				return $.map(list, function(persona) {
					return {
						id: persona.Persona.pers_id,
						name: persona.Persona.pers_nombre_completo
					}; 
				});
			}
		}
	});
	personas.initialize();

	$('#FamiliaPersNombre').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'personas',
		displayKey: 'name',
		source: personas.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#FamiliaPersId').val(suggestion.id);
	});

});
</script>