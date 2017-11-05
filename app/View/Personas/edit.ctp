<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-user"></i>
				<?php echo $this->Html->link(__('Personas'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Persona'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Persona'); ?> <small><?php echo __('Editar Persona'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Persona'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Persona'); ?>
					<?php
						// si el perfil es comuna o digitador
						if ($perf_id == 3 || $perf_id == 10) {
							echo $this->Form->input('PersonaCentroFamiliar.cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'multiple' => false, 'empty' => __('-- Seleccione Opción --')));
						} else {
							echo $this->Form->input('PersonaCentroFamiliar.cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'multiple' => true));
						}
					?>
					
					<?php echo $this->Form->input('pers_run', array('label' => __('RUN'), 'maxlength' => 10, 'type' => 'text')); ?>
					<?php echo $this->Form->input('pers_run_dv', array('label' => __('DV'), 'maxlenght' => 1)); ?>
					<?php echo $this->Form->input('pers_nombres', array('label' => __('Nombres'))); ?>
					<?php echo $this->Form->input('pers_ap_paterno', array('label' => __('Apellido Paterno'))); ?>
					<?php echo $this->Form->input('pers_ap_materno', array('label' => __('Apellido Materno'))); ?>
					<?php echo $this->Form->input('sexo_id', array('label' => __('Sexo'), 'options' => $sexos, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('pers_fecha_nacimiento', array('type' => 'text', 'label' => __('Fecha de Nacimiento'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years')); ?>

					<?php echo $this->Form->input('comu_id', array('label' => __('Comuna'), 'options' => $comunas, 'empty' => __('-- Seleccione Opción --'))); ?>					
					<?php echo $this->Form->input('dire_direccion', array('label' => __('Dirección'))); ?>
					<?php echo $this->Form->input('dire_id', array('label' => false, 'div' => false, 'type' => 'hidden')); ?>

					<?php echo $this->Form->input('pers_email', array('label' => __('Correo Electrónico'))); ?>
					<?php echo $this->Form->input('pers_nro_movil', array('label' => __('Teléfono Móvil'))); ?>
					<?php echo $this->Form->input('pers_nro_fijo', array('label' => __('Teléfono Fijo'))); ?>
					<?php echo $this->Form->input('pers_ocupacion', array('label' => __('Ocupación'))); ?>
					<?php echo $this->Form->input('esci_id', array('label' => __('Estado Civil'), 'options' => $estadosCiviles, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('puor_id', array('label' => __('Pueblo Originario'), 'options' => $pueblosOriginarios, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('naci_id', array('label' => __('Nacionalidad'), 'options' => $nacionalidades, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('estu_id', array('label' => __('Estudios'), 'options' => $estudios, 'empty' => __('-- Seleccione Opción --'))); ?>
					
					<?php echo $this->Form->input('inst_id', array('label' => __('Salud'), 'options' => $institucionesSalud, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('inst_id2', array('label' => __('Previsión'), 'options' => $institucionesPrevision, 'empty' => __('-- Seleccione Opción --'))); ?>

					<?php echo $this->Form->input('pers_discapacidad', array('label' => __('Tiene Discapacidad'))); ?>
					<?php echo $this->Form->input('fami_nombre', array('label' => __('Familia'), 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('fami_id', array('type' => 'hidden', 'div' => false)); ?>

					<?php echo $this->Form->input('pare_id', array('label' => __('Parentesco (con la familia)'), 'options' => $parentescos, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('grob_id', array('label' => __('Grupo Objetivo'), 'options' => $gruposObjetivos, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('pers_plan_trabajo', array('label' => __('Plan de Trabajo'))); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
				<?php echo $this->Form->input('pers_id'); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	// todo input en mayuscula
	$('input[type=text]').keyup(function() {
		$(this).val($(this).val().toUpperCase());
	});

	var familias = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/familias/find_familias?q=%QUERY',
			filter: function(list) {
				var nList = [];
				$(list).each(function(i, obj) {
					var valFamilia = obj.Familia.fami_nombre_completo +' ('+ obj.Familia.fami_direccion_completa +' - '+ obj.Comuna.comu_nombre +')';
					var id = obj.Familia.fami_id;

					nList.push({
						Familia: {
							id: id,
							nombre: valFamilia
						}
					});
				});

				return $.map(nList, function(familia) {
					return {
						id: familia.Familia.id,
						name: familia.Familia.nombre
					}; 
				});
			}
		}
	});
	familias.initialize();

	$('#PersonaFamiNombre').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'familias',
		displayKey: 'name',
		source: familias.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#PersonaFamiId').val(suggestion.id);
	});

	// typeahead de direcciones
	var direcciones = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/direcciones/find_direcciones?q=%QUERY&comu_id=',
			replace: function () {
				var comu_id = $('#PersonaComuId option:selected').val();
				var query = $('#PersonaDireDireccion').val();
                var q = '/direcciones/find_direcciones?q='+ query +'&comu_id='+ comu_id;
                return q;
            },
			filter: function(list) {
				return $.map(list, function(direccion) {
					return {
						id: direccion.dire_id,
						name: direccion.dire_direccion
					}; 
				});
			}
		}
	});
	direcciones.initialize();

	$('#PersonaDireDireccion').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'direcciones',
		displayKey: 'name',
		source: direcciones.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#PersonaDireId').val(suggestion.id);
	});

	$('#PersonaDireDireccion').on('keyup', function() {
		if ($(this).val().trim() == '') {
			$('#PersonaDireId').val('');
		}
		
	});
});
</script>