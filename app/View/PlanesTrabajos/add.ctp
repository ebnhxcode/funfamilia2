<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Plan de Acompañamiento'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nuevo Plan de Acompañamiento'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nuevo Plan de Acompañamiento'); ?> <small><?php echo __('Nuevo Plan de Acompañamiento'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('PlanTrabajo'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Plan de Acompañamiento'); ?>

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
				<?php echo $this->Form->input('Persona.pers_nombre', array('label' => __('Persona'))); ?>
				<?php echo $this->Form->input('PlanTrabajo.pecf_id', array('type' => 'hidden', 'div' => false)); ?>
				<?php echo $this->Form->input('PlanTrabajo.grob_id', array('type' => 'hidden', 'div' => false)); ?>
				<?php echo $this->Form->input('PlanTrabajo.plan_trabajo', array('label' => __('Plan de Acompañamiento'), 'type' => 'textarea')); ?>
			</div>
		</div>
	</div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li class="active"><a href="#pTrabajo" role="tab" data-toggle="tab"><?php echo __('Propuesta de Trabajo'); ?></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="pTrabajo">
	</div>
</div>

<div class="col-sm-2 col-sm-offset-10">
	<br />
	<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
	<br />
</div>

<?php echo $this->Form->end(); ?>

<script id="fProtectores-template" type="text/x-handlebars-template">
	{{#each data}}
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-external-link-square"></i>
						{{this.Nivel.nive_nombre}}
						<div class="panel-tools">
							<a href="javascript:;" class="btn btn-xs btn-link expand" data-toggle="collapse" data-target="#nive{{this.Nivel.nive_id}}"></a>
						</div>
					</div>
					<div class="panel-body collapse out" id="nive{{this.Nivel.nive_id}}">						
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th><?php echo __('Objetivo Factor Protector'); ?></th>
										<th><?php echo __('Actividad'); ?></th>
										<th><?php echo __('Observaciones'); ?></th>
									</tr>
								</thead>
								<tbody>
									{{#each this.FactorProtector}}
										<tr>
											<td>
												{{this.fapr_objetivos}}
												<input type="hidden" name="data[DetallePlanTrabajo][{{this.fapr_id}}][fapr_id]" value="{{this.fapr_id}}" />
											</td>
											<td>
												<select class="form-control" name="data[DetallePlanTrabajo][{{this.fapr_id}}][acti_id]">
													<option value=""><?php echo __('-- Seleccione Opción --'); ?></option>
													{{#each ../../actividades}}
														<option value="{{this.Actividad.acti_id}}">{{this.Actividad.acti_nombre}} ({{momentJsFormat this.Actividad.acti_fecha_inicio this.Actividad.acti_fecha_termino}})</option>
													{{/each}}
												</select>
											</td>		
											<td>
												<textarea class="form-control" name="data[DetallePlanTrabajo][{{this.fapr_id}}][dept_observaciones]" style="height:70px; width: 100%"></textarea>
											</td>
										</tr>
									{{/each}}
								</tbody>
							</table>
					  	</div>
					</div>
				</div>
			</div>
		</div>
  	{{/each}}
</script>

<script>
$(document).ready(function() {

	Handlebars.registerHelper('momentJsFormat', function(inicio, termino) {
		return new Handlebars.SafeString(moment(inicio).format('DD-MM-YYYY') +' / '+ moment(termino).format('DD-MM-YYYY'));
	});

	var actividades = [];
	var faprIndex = 0;

	// datos a 0
	$('#CentroFamiliarCefaId').val('');
	$('#PersonaPersNombre').val('');

	var pintaFactoresProtectores = function(grob_id) {
		$.ajax({
			type: 'POST',
			url: '/niveles/find_niveles_by_grob',
			data: {
				grob_id: grob_id
			},
			cache: false,
			dataType: 'json',
			beforeSend: function() {

			},
			success: function(data) {
				if (data.lenght == 0) {

				} else {
					var source = $("#fProtectores-template").html();
					var template = Handlebars.compile(source);
					var dataObj = {
						actividades: actividades,
						data: data
					};

					var html = template(dataObj);
					$('#pTrabajo').html(html);
				}	
			},
			error: function() {
				alert('Ha ocurrido un error al procesar su petición');
			}
		});
	}

	// typeahead de personas
	var personas = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/personas/find_personas_by_cefa?q=%QUERY&cefa_id=&grupoObjetivo=true',
			replace: function () {
				var cefa_id = $('#CentroFamiliarCefaId option:selected').val();
				var query = $('#PersonaPersNombre').val();
                var q = '/personas/find_personas_by_cefa?q='+ query +'&cefa_id='+ cefa_id +'&grupoObjetivo=true';
                return q;
            },
			filter: function(list) {
				return $.map(list, function(persona) {
					return {
						id: persona.PersonaCentroFamiliar.pecf_id,
						name: persona.Persona.pers_nombres + ' ' + persona.Persona.pers_ap_paterno + ' ' + persona.Persona.pers_ap_materno + ' ('+ persona.Persona.pers_run +'-'+ persona.Persona.pers_run_dv +')',
						nombre: persona.Persona.pers_nombre_completo,
						grob_id: persona.Persona.grob_id

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
		$('#PlanTrabajoPecfId').val(suggestion.id);
		$('#PlanTrabajoGrobId').val(suggestion.grob_id);

		// aqui se ejecuta el gatillo para la busqueda de los indicadores de factores protectores
		// según grupo objetivo
		pintaFactoresProtectores(suggestion.grob_id);
	});

	// buscamos actividades individuales por centro familiar
	$('#CentroFamiliarCefaId').on('change', function() {
		var cefa_id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '/actividades/find_actividades',
			data: {
				cefa_id: cefa_id
			},
			cache: false,
			dataType: 'json',
			success: function(data) {
				actividades = data;
			},
			error: function() {
				alert('Ha ocurrido un error al procesar su petición');
			}
		});
	});
});
</script>
