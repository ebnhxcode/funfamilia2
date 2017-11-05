<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Inscripciones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nueva Inscripción'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nueva Inscripción'); ?> <small><?php echo __('Nueva Inscripción'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('PersonaActividad'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Inscripciones'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
					<?php echo $this->Form->input('CentroFamiliar.cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('Actividad.acti_nombre', array('label' => __('Actividad'), 'required' => 'required')); ?>
					<?php echo $this->Form->input('PersonaActividad.acti_id', array('type' => 'hidden', 'div' => false)); ?>
					<?php echo $this->Form->input('Persona.pers_nombre', array('label' => __('Persona'))); ?>
					<?php echo $this->Form->input('PersonaActividad.pers_run', array('type' => 'hidden', 'div' => false)); ?>
					<?php echo $this->Form->input('PersonaActividad.pecf_id', array('type' => 'hidden', 'div' => false)); ?>
					
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-9">
							<button class="btn btn-yellow btn-block" id="agregarInscripcion" type="button"><?php echo __('Agregar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Personas Inscritas'); ?>

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
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><?php echo __('RUN'); ?></th>
								<th><?php echo __('Nombre'); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody id="inscritos">
						</tbody>
					</table>
				</div>
			</div>
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

<script id="inscritos-template" type="text/x-handlebars-template">
	<tr>
		<td>
			{{run}}
		</td>
		<td>
			{{nombre}}
			<input type="hidden" name="data[PersonaActividad][{{index}}][pecf_id]" value="{{pecf_id}}" />
		</td>
		<td>
			<a data-pecf-id="{{pecf_id}}" data-placement="top" data-original-title="Eliminar" class="btnEliminaInscripcion btn btn-xs btn-bricky tooltips" href="javascript:;">
				<i class="fa fa-times fa fa-white"></i>
			</a>
		</td>
	</tr>
</script>

<script>
$(document).on('click', '.btnEliminaInscripcion', function() {
	$(this).parent().parent().remove();
});

var estaRepetido = function(pecf_id) {
	var encontrado = false;

	$('#inscritos > tr').each(function() {
		var trPecf_id = $(this).find('.btnEliminaInscripcion').attr('data-pecf-id');
		if (trPecf_id == pecf_id) {
			encontrado = true;
		} 
	});

	if (encontrado) {
		return true;
	}

	return false;
}

$(document).ready(function() {
	var index = 0;

	$('#agregarInscripcion').on('click', function() {
		var pecf_id = $('#PersonaActividadPecfId').val();
		var nombre = $('#PersonaPersNombre').val();
		var run = $('#PersonaActividadPersRun').val();

		if (pecf_id != '' && nombre != '') {

			if (!estaRepetido(pecf_id)) {
				var source = $("#inscritos-template").html();
				var template = Handlebars.compile(source);
				var html = template({
					index: index,
					pecf_id: pecf_id,
					nombre: nombre,
					run: run
				});
				$('#inscritos').append(html);
				index++;
			} else {
				alert('La persona ya se encuentra en la lista');
			}

			// eliminamos busqueda
			$('#PersonaPersNombre').typeahead('val', '');
			$('#PersonaPersNombre').removeAttr('value');
			$('#PersonaActividadPecfId').removeAttr('value');
		} else {
			alert('Debe seleccioanar primero centro familiar, actividad y persona');
		}
	});

	// typeahead de actividades
	var actividades = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/actividades/find_actividades_individuales_by_cefa?q=%QUERY&cefa_id=',
			replace: function () {
				var cefa_id = $('#CentroFamiliarCefaId option:selected').val();

				if (cefa_id != '') {
					var query = $('#ActividadActiNombre').val();
                	var q = '/actividades/find_actividades_individuales_by_cefa?q='+ query +'&cefa_id='+ cefa_id;
                	return q;
            	} else {
            		return null;
            	}
            },
			filter: function(list) {
				return $.map(list, function(actividad) {
					return {
						id: actividad.Actividad.acti_id,
						name: actividad.Actividad.acti_nombre
					}; 
				});
			}
		}
	});
	actividades.initialize();

	$('#ActividadActiNombre').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'actividades',
		displayKey: 'name',
		source: actividades.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#PersonaActividadActiId').val(suggestion.id);
	});

	// typeahead de personas
	var personas = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/personas/find_personas_by_cefa?q=%QUERY&cefa_id=',
			replace: function () {
				var cefa_id = $('#CentroFamiliarCefaId option:selected').val();

				if (cefa_id != '') {
					var query = $('#PersonaPersNombre').val();
                	var q = '/personas/find_personas_by_cefa?q='+ query +'&cefa_id='+ cefa_id;
                	return q;
            	} else {
            		return null;
            	}
            },
			filter: function(list) {
				return $.map(list, function(persona) {
					var pers_nombre_completo = persona.Persona.pers_nombres +' '+ persona.Persona.pers_ap_paterno +' '+ persona.Persona.pers_ap_materno;
					var pers_run_completo = persona.Persona.pers_run +'-'+ persona.Persona.pers_run_dv;
					
					return {
						id: persona.PersonaCentroFamiliar.pecf_id,
						name: pers_nombre_completo,
						run: pers_run_completo
					}; 
				});
			}
		}
	});
	personas.initialize();

	$('#PersonaPersNombre').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'personas',
		displayKey: 'name',
		source: personas.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#PersonaActividadPecfId').val(suggestion.id);
		$('#PersonaActividadPersRun').val(suggestion.run);
	});

	$('#CentroFamiliarCefaId').on('change', function() {
		// eliminamos busqueda
		$('#ActividadActiNombre').typeahead('val', '');
		$('#ActividadActiNombre').removeAttr('value');
		$('#PersonaPersNombre').typeahead('val', '');
		$('#PersonaPersNombre').removeAttr('value');
		$('#PersonaActividadPecfId').removeAttr('value');
		$('#PersonaActividadActiId').removeAttr('value');
	});
});
</script>