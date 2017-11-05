<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Sesiones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nueva Sesión'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nueva Sesión'); ?> <small><?php echo __('Nueva Sesión'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Sesion'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Sesiones'); ?>

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
				<?php echo $this->Form->input('Actividad.acti_nombre', array('label' => __('Actividad'))); ?>
				<?php echo $this->Form->input('Sesion.acti_id', array('type' => 'hidden', 'div' => false)); ?>
				<?php echo $this->Form->input('Sesion.sesi_nombre', array('label' => __('Sesión N°'), 'type' => 'number')); ?>
				<?php echo $this->Form->input('Sesion.sesi_fecha_ejecucion', array('type' => 'text', 'label' => __('Fecha de Ejecución'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Asistentes'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body" id="asistentes">

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

<!-- Modal -->
<div class="modal fade" id="modelNuevaPersona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        		<h4 class="modal-title" id="myModalLabel"><?php echo __('Nuevo Asistente'); ?></h4>
      		</div>
      		<div class="modal-body">
        		<div class="row">
        			<div class="col-md-6">
						<label class="control-label"><?php echo __('RUN'); ?></label>
						<?php echo $this->Form->input('Persona.pers_run', array('label' => null, 'div' => false, 'type' => 'text', 'maxlength' => 10, 'autocomplete' => 'off', 'onkeypress' => 'javascript:return validchars(event, num);')); //, 'onpaste' => 'return false;')); ?>
						<?php echo $this->Form->input('Persona.pers_id', array('label' => null, 'div' => false, 'type' => 'hidden')); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label"><?php echo __('DV'); ?></label>
						<?php echo $this->Form->input('Persona.pers_run_dv', array('label' => null, 'div' => false, 'maxlength' => 1, 'autocomplete' => 'off', 'onkeypress' => 'javascript:return validchars(event, nums);')); //, 'onpaste' => 'return false;')); ?>
					</div>
        			<div class="col-md-12">
        				<br />
						<label class="control-label"><?php echo __('Nombre'); ?>&nbsp;<span class="symbol required"></span></label>
						<?php echo $this->Form->input('Persona.pers_nombres', array('label' => null, 'div' => false)); ?>
					</div>
					<div class="col-md-12">
						<br />
						<label class="control-label"><?php echo __('Apellido Paterno'); ?>&nbsp;<span class="symbol required"></span></label>
						<?php echo $this->Form->input('Persona.pers_ap_paterno', array('label' => null, 'div' => false)); ?>
					</div>
					<div class="col-md-12">
						<br />
						<label class="control-label"><?php echo __('Apellido Materno'); ?></label>
						<?php echo $this->Form->input('Persona.pers_ap_materno', array('label' => null, 'div' => false)); ?>
					</div>
					<div class="col-md-12">
						<br />
						<label class="control-label"><?php echo __('Sexo'); ?>&nbsp;<span class="symbol required"></span></label>
						<?php echo $this->Form->input('Persona.sexo_id', array('label' => null, 'div' => false, 'options' => $sexos, 'empty' => __('-- Seleccione Opción --'))); ?>
					</div>
					<div class="col-md-12">
						<br />
						<label class="control-label"><?php echo __('Fecha de Nacimiento'); ?>&nbsp;<span class="symbol required"></span></label>
						<?php echo $this->Form->input('Persona.pers_fecha_nacimiento', array('label' => null, 'type' => 'text', 'div' => false, 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years')); ?>
					</div>
				</div>
      		</div>
      		<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-light-grey">
					<?php echo __('Cerrar'); ?>
				</button>
				<button type="button" class="btn btn-blue" id="btnNuevaPersona">
					<?php echo __('Guardar'); ?>
				</button>
			</div>
  		</div>
  	</div>
</div>

<script id="asistentes-template" type="text/x-handlebars-template">
	<div class="row">
		<div class="col-xs-6">
			<?php echo $this->Html->link(__('Marcar/desmarcar asistentes') . ' <i class="fa fa-check-square"></i> ', 'javascript:;', array('escape' => false, 'class' => 'marcarAll btn btn-info pull-left')); ?>
		</div>

		<div class="col-xs-6">
			<?php echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nueva Persona'), 'javascript:;', array('escape' => false, 'class' => 'nuevaPersona btn btn-success pull-right')); ?>
		</div>
	</div>
	<br />
	<div class="table-responsive">
		<table id="asistentesTable" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __('RUN'); ?></th>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Presente/Ausente'); ?></th>
				</tr>
			</thead>
			<tbody>
				{{#each data}}
					<tr data-pers-run="{{this.Persona.pers_run}}">
						<td>{{this.Persona.pers_run}}-{{this.Persona.pers_run_dv}}</td>
						<td>{{this.Persona.pers_ap_paterno}} {{this.Persona.pers_ap_materno}} {{this.Persona.pers_nombres}}</td>
						<td>
							<input name="data[Asistencia][{{@index}}][pecf_id]" value="{{this.PersonaCentroFamiliar.pecf_id}}" type="checkbox" class="grey checkAsistencia">
						</td>
					</tr>
				{{/each}}
			</tbody>
		</table>
	</div>
</script>

<script id="asistentesTr-template" type="text/x-handlebars-template">
	<tr data-pers-run="{{pers_run}}">
		<td>{{pers_run_completo}}</th>
		<td>{{pers_nombre_completo}}</th>
		<td>
			<input checked="checked" name="data[Asistencia][{{index}}][pecf_id]" value="{{pecf_id}}" type="checkbox" class="grey">
		</td>
	</tr>
</script>

<script>
var index = 0;

$(document).on('click', '#btnNuevaPersona', function() {
	// verificamos algunos datos
	var pers_nombres = $('#PersonaPersNombres').val().trim();
	var pers_ap_paterno = $('#PersonaPersApPaterno').val().trim();
	var pers_ap_materno = $('#PersonaPersApMaterno').val().trim();
	var pers_fecha_nacimiento = $('#PersonaPersFechaNacimiento').val().trim();
	var sexo_id = $('#PersonaSexoId').val();

	if (pers_nombres == '') {
		alert('Debe ingresar el nombre de la persona');
		return false;
	}

	if (pers_ap_paterno == '') {
		alert('Debe ingresar el apellido paterno de la persona');
		return false;
	}

	if (sexo_id == '') {
		alert('Debe seleccionar el sexo de la persona');
		return false;
	}

	if (pers_fecha_nacimiento == '') {
		alert('Debe seleccionar la fecha de nacimiento de la persona');
		return false;
	}

	var pers_run = $('#PersonaPersRun').val();
	var pers_nombre_completo = $('#PersonaPersNombres').val() + ' ' + $('#PersonaPersApPaterno').val() + ' ' + $('#PersonaPersApMaterno').val();
	var cefa_id = $('#CentroFamiliarCefaId').val();

	// verificamos RUN
	if (!verificaRut(pers_run, $('#PersonaPersRunDv').val())) {
		alert('RUN incorrecto');
		return;
	}

	if (estaRepetido($('#PersonaPersRun').val())) {
		alert('La persona ingresada ya se encuentra en la lista');
	} else {
		// si la persona es nueva la guardamos y retornamos los datos
		// de todas formas mandamos el ajax
		var postData = {
			pers_run: $('#PersonaPersRun').val(),
			pers_run_dv: $('#PersonaPersRunDv').val(),
			pers_nombres: pers_nombres,
			pers_ap_paterno: pers_ap_paterno,
			pers_ap_materno: pers_ap_materno,
			pers_fecha_nacimiento: pers_fecha_nacimiento,
			sexo_id: sexo_id,
			cefa_id: cefa_id
		};

		if ($('#PersonaPersId').val() != '') {
			postData.pers_id = $('#PersonaPersId').val();
		}
			
			postData.acti_id = $('#SesionActiId').val();

		$.ajax({
			type: 'POST',
			url: '/personas/guardaPersonaBasica',
			data: postData,
			cache: false,
			async: false,
			dataType: 'json',
			success: function(data) {
				var pecf_id = data.pecf_id;
				var pers_run_completo = data.pers_run_completo;

				var source = $("#asistentesTr-template").html();
				var template = Handlebars.compile(source);
				var context = {
					pers_run: pers_run,
					pers_run_completo: pers_run_completo,
					pers_nombre_completo: pers_nombre_completo,
					pecf_id: pecf_id,
					index: (index+1)
				};
				var html = template(context);
				$('#asistentesTable > tbody').append(html);
				$('#modelNuevaPersona').modal('hide');
			},
			error: function() {
				alert('Ha ocurrido un error al procesar su petición');
			}
		});
	}
});

var estaRepetido = function(pers_run) {
	var estaRepetido = false;

	// si viene vacio es porque es una persona sin RUN
	if (pers_run == '') {
		return estaRepetido;
	}

	$('#asistentesTable > tbody > tr').each(function() {
		if ($(this).attr('data-pers-run').trim() == pers_run) {
			estaRepetido = true;
		}
	});

	return estaRepetido;
}

var pintaAsistentes = function(acti_id) {
	$.ajax({
		type: 'POST',
		url: '/personas_actividades/inscripciones_por_actividad',
		data: {
			acti_id: acti_id
		},
		cache: false,
		async: false,
		dataType: 'json',
		beforeSend: function() {
			$('#asistentes').hide();
		},
		success: function(data) {
			index = (data.length)-1;
			var source = $("#asistentes-template").html();
			var template = Handlebars.compile(source);
			var context = {
				data: data
			};

			$('#asistentes').html(template(context)).slideDown('slow');
		},
		error: function() {
			alert('Ha ocurrido un error al procesar su petición');
		}
	});
}

$(document).on('click', '.nuevaPersona', function() {
	$('#PersonaPersId').val('');
	$('#PersonaPersRun').val('').removeAttr('readonly', 'readonly');
	$('#PersonaPersRunDv').val('').removeAttr('readonly', 'readonly');
	$('#PersonaPersNombres').val('').removeAttr('readonly', 'readonly');
	$('#PersonaPersApPaterno').val('').removeAttr('readonly', 'readonly');
	$('#PersonaPersApMaterno').val('').removeAttr('readonly', 'readonly');
	$('#PersonaSexoId').val('').removeAttr('readonly', 'readonly');
	$('#PersonaPersFechaNacimiento').val('').removeAttr('readonly', 'readonly');	
	$('#modelNuevaPersona').modal('show');
});

$(document).on('blur', '#PersonaPersRun', function() {
	// levanta datos de persona en caso de existir el RUN
	var pers_run = $(this).val();

	$.ajax({
		type: 'POST',
		url: '/personas/find_personas_por_run',
		data: {
			pers_run: pers_run
		},
		cache: false,
		async: true,
		dataType: 'json',
		success: function(data) {
			// si la persona ya existe en el sistema escondemos todo
			if (typeof data.Persona != 'undefined') {
				$('#PersonaPersId').val(data.Persona.pers_id);
				$('#PersonaPersRun').val(data.Persona.pers_run).attr('readonly', 'readonly');
				$('#PersonaPersRunDv').val(data.Persona.pers_run_dv).attr('readonly', 'readonly');
				$('#PersonaPersNombres').val(data.Persona.pers_nombres).attr('readonly', 'readonly');
				$('#PersonaPersApPaterno').val(data.Persona.pers_ap_paterno).attr('readonly', 'readonly');
				$('#PersonaPersApMaterno').val(data.Persona.pers_ap_materno).attr('readonly', 'readonly');
				$('#PersonaSexoId').val(data.Persona.sexo_id).attr('readonly', 'readonly');

				if (data.Persona.pers_fecha_nacimiento != null) {
					$('#PersonaPersFechaNacimiento').val(moment(data.Persona.pers_fecha_nacimiento).format('DD-MM-YYYY'));
				}
				$('#PersonaPersFechaNacimiento').attr('readonly', 'readonly');
			}
		},
		error: function() {
			alert('Ha ocurrido un error al procesar su petición.');
		}
	});
})

$(document).on('click', '.marcarAll', function() {
	$('.checkAsistencia').each(function(i, obj) {		
		$(this).prop('checked', 'checked');
	});

	$(this).removeClass('marcarAll').addClass('desmarcarAll');
});

$(document).on('click', '.desmarcarAll', function() {
	$('.checkAsistencia').each(function(i, obj) {		
		$(this).removeAttr('checked');
	});

	$(this).removeClass('desmarcarAll').addClass('marcarAll');
});

$(document).ready(function() {
	// typeahead de actividades
	var actividades = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/actividades/find_actividades_individuales_by_cefa?q=%QUERY&cefa_id=',
			replace: function () {
				var cefa_id = $('#CentroFamiliarCefaId option:selected').val();
				var query = $('#ActividadActiNombre').val();
                var q = '/actividades/find_actividades_individuales_by_cefa?q='+ query +'&cefa_id='+ cefa_id;
                return q;
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
		$('#SesionActiId').val(suggestion.id);

		// llena nro de sesion
		$.ajax({
			type: 'POST',
			url: '/sesiones/findMaxSesion',
			data: {
				acti_id: suggestion.id
			},
			cache: false,
			async: true,
			dataType: 'json',
			success: function(data) {
				if (isNaN(data.max)) {
					alert('Ha ocurrido un error al procesar su petición');
				} else {
					$('#SesionSesiNombre').val(data.max).attr('readonly', 'readonly');
				}
			},
			error: function() {
				alert('Ha ocurrido un error al procesar su petición');
			}
		});

		// logica para pintar todos los asistentes por actividad
		pintaAsistentes(suggestion.id);
	});
});
</script>