<style>
.form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
    margin-bottom: 0;
    margin-top: 0;
    padding-top: 0px;
}

.radio-inline, .radio-inline + .radio-inline, .checkbox-inline, .checkbox-inline + .checkbox-inline {
    margin: 0 10px 10px 0 !important;
}
</style>

<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Evaluaciones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nueva Evaluación'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nueva Evaluación'); ?> <small><?php echo __('Nueva Evaluación'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Evaluacion'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Evaluación'); ?>

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
				<?php echo $this->Form->input('Evaluacion.pecf_id', array('type' => 'hidden', 'div' => false)); ?>
				<?php echo $this->Form->input('Evaluacion.grob_id', array('type' => 'hidden', 'div' => false)); ?>
				<?php echo $this->Form->input('Evaluacion.tiev_id', array('label' => __('Tipo de Evaluación'), 'options' => $tiposEvaluaciones, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('Evaluacion.eval_fecha', array('label' => __('Fecha'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'type' => 'text')); ?>
				<?php echo $this->Form->input('Evaluacion.eval_observacion', array('label' => __('Observaciones'), 'class' => 'form-control')); ?>
			</div>
		</div>
	</div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li id="fProtectoresTab" class="active"><a href="#fProtectores" role="tab" data-toggle="tab"><?php echo __('Evaluación de Factores Protectores'); ?></a></li>
  	<li id="fRiesgosTab"><a href="#fRiesgos" role="tab" data-toggle="tab"><?php echo __('Evaluación de Factores de Riesgo'); ?></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="fProtectores">

	</div>
	<div class="tab-pane" id="fRiesgos">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><?php echo __('Factor'); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $index = 0; ?>
					<?php foreach ($factoresRiesgos as $fari): ?>
						<tr>
							<td><?php echo $fari['FactorRiesgo']['fari_descripcion'] ?></td>
							<td>
								<?php
									echo $this->Form->input('EvaluacionFactorRiesgo.'. $index .'.fari_id', array('type' => 'hidden', 'div' => false, 'value' => $fari['FactorRiesgo']['fari_id']));
								?>
								<label class="radio-inline">
									<input checked="checked" type="radio" value="1" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
									<?php echo __('Presente'); ?>
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
									<?php echo __('Ausente'); ?>
								</label>
								<label class="radio-inline">
									<input type="radio" value="-1" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
									<?php echo __('No Aplica'); ?>
								</label>
							</td>
						</tr>
						<?php $index++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<br />
<div class="row">	
	<div class="col-sm-2 col-sm-offset-10">
		<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<br />

<!-- SE SACA A PEDIDO DE LA GENTE DE FUNFAMILIA REUNION 19-11-2014 -->
<!--
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
						{{#each this.FactorProtector}}
							<h3>{{this.fapr_nombre}}</h3>
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tbody>
										{{#each this.IndicadorFactorProtector}}
											<tr>
												<td>
													{{this.ifpr_descripcion}}
													<input type="hidden" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][ifpr_id]" value="{{this.ifpr_id}}" />
												</td>
												<td>
													<label class="radio-inline">
														<input type="radio" value="1" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
															1
														</label>
													<label class="radio-inline">
														<input type="radio" value="2" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
															2
													</label>
													<label class="radio-inline">
														<input checked="checked" type="radio" value="3" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
															3
													</label>
													<label class="radio-inline">
														<input type="radio" value="4" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
															4
													</label>
													<label class="radio-inline">
														<input type="radio" value="5" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
															5
													</label>
												</td>
											</tr>
										{{/each}}
									</tbody>
								</table>
						  	</div>
					  	{{/each}}
					</div>
				</div>
			</div>
		</div>
  	{{/each}}
</script>
-->

<!-- SE PIDIO ESTO A PEDIDO DE LA GENTE DE FUNFAMILIA REUNION 19-11-2014 -->
<script id="fProtectores-template" type="text/x-handlebars-template">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i>
					<?php echo __('Ejemplo'); ?>
					<div class="panel-tools">
						<a href="javascript:;" class="btn btn-xs btn-link expand" data-toggle="collapse" data-target="#ejemploBody"></a>
					</div>
				</div>
				<div class="panel-body collapse out" id="ejemploBody">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<th><?php echo __('Indicador'); ?></th>
								<th><?php echo __('Totalmente en desacuerdo'); ?></th>
								<th><?php echo __('En desacuerdo'); ?></th>
								<th><?php echo __('Ni de acuerdo ni en desacuerdo'); ?></th>
								<th><?php echo __('De acuerdo'); ?></th>
								<th><?php echo __('Totalmente de acuerdo'); ?></th>
							</thead>
							<tbody>
								<td><?php echo ('Cuando tengo que hacer un trabajo complejo, puedo contar con la ayuda de mis compañeros o colegas'); ?></td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="1" name="test" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="2" name="test" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input checked="checked" type="radio" value="3" name="test" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="4" name="test" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="5" name="test" class="grey">
									</label>
								</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<th><?php echo __('Indicador'); ?></th>
				<th><?php echo __('Totalmente en desacuerdo'); ?></th>
				<th><?php echo __('En desacuerdo'); ?></th>
				<th><?php echo __('Ni de acuerdo ni en desacuerdo'); ?></th>
				<th><?php echo __('De acuerdo'); ?></th>
				<th><?php echo __('Totalmente de acuerdo'); ?></th>
			</thead>
			<tbody>
				{{#each data}}
					{{#each this.FactorProtector}}
						{{#each this.IndicadorFactorProtector}}
							<tr>
								<td>
									{{this.ifpr_descripcion}}
									<input type="hidden" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][ifpr_id]" value="{{this.ifpr_id}}" />
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="1" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="2" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input checked="checked" type="radio" value="3" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="4" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
									</label>
								</td>
								<td>
									<label class="radio-inline">
										<input type="radio" value="5" name="data[EvaluacionFactorProtector][{{this.ifpr_id}}][evfp_valor]" class="grey">
									</label>
								</td>
							</tr>
						{{/each}}
					{{/each}}
  				{{/each}}
  			</tbody>
		</table>
	</div>
</script>

<script>
$(document).ready(function() {

	var acordiones = function() {
    	$('.panel-collapse2').each(function () {
        	$(this).collapse();    
        });
	}

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
					var html = template({data: data});
					$('#fProtectores').html(html);

					// para nuevos accordions
					//acordiones();
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
			url: '/personas/find_personas_by_cefa?q=%QUERY&cefa_id=',
			replace: function () {
				var cefa_id = $('#CentroFamiliarCefaId option:selected').val();
				var query = $('#PersonaPersNombre').val();
                var q = '/personas/find_personas_by_cefa?q='+ query +'&cefa_id='+ cefa_id +'&grupoObjetivo=true&participaActividad=true';
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
		$('#EvaluacionPecfId').val(suggestion.id);
		$('#EvaluacionGrobId').val(suggestion.grob_id);

		// aqui se ejecuta el gatillo para la busqueda de los indicadores de factores protectores
		// según grupo objetivo
		pintaFactoresProtectores(suggestion.grob_id);
	});

	$('#EvaluacionTievId').on('change', function() {
		var tiev_id = $(this).val();

		// si es final, se esconde pestaña de factores de riesgo
		if (tiev_id == 2) {
			$('#fRiesgosTab').hide();
			$('#fProtectoresTab a').tab('show');
		} else {
			$('#fRiesgosTab').show();
		}
	});
});
</script>
