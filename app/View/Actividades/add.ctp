<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Actividades'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Nueva Actividad'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Nueva Actividad'); ?> <small><?php echo __('Nueva Actividad'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->create('Actividad'); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Actividad'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="col-sm-11">
					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('cefa_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Centro Familiar')), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('esac_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Estado de Actividad')), 'options' => $estadosActividades, 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6">
								<?php echo $this->Form->input('prog_id', array('options' => $programas, 'empty' => '-- Seleccione Opción --', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Programa')), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">

						</div>
					</div>	

					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('area_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Area')), 'options' => array(), 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('tiac_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Tipo de Actividad')), 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_nombre', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Nombre')), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_descripcion', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Descripción')), 'divClass' => 'col-sm-8', 'style' => 'height: 80px;')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_cobertura_esperada', array('type' => 'text', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Cobertura Esperada')), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_poblacion', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Cobertura y Público')), 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_frecuencia', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Frecuencia')), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_direccion', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Lugar de ejecución y dirección')), 'type' => 'text', 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->input('comu_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Comuna')), 'options' => $comunas, 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_individual', array('type' => 'checkbox', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('¿Es Individual?')), 'checked' => true, 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>
					<div class="form-group">						
						<div class="col-sm-6">
							<?php echo $this->Form->input('inst_id', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Institución')), 'empty' => __('-- Seleccione Opción --'), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
							<?php
								echo $this->Form->input('usua_nombre', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Monitor Encargado')), 'divClass' => 'col-sm-8'));
								echo $this->Form->input('usua_id', array('type' => 'hidden', 'div' => false));
							?>
						</div>
					</div>
					<div class="form-group">						
						<div class="col-sm-6">
							<?php echo $this->Form->input('acti_nro_sesiones', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('N° de Sesiones')), 'divClass' => 'col-sm-8')); ?>
						</div>
						<div class="col-sm-6">
								<?php echo $this->Form->input('acti_editable', array('label' => array('class' => 'col-sm-4 control-label', 'text' => __('Permiso de edición')), 'divClass' => 'col-sm-8')); ?>
						</div>
					</div>

					<?php if ($perf_id == 3): ?>
						<div class="form-group">
							<div class="col-sm-6">
								<?php echo $this->Form->input('acti_fecha_inicio', array('type' => 'text', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Fecha de Inicio')), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'divClass' => 'col-sm-8')); ?>
							</div>
							<div class="col-sm-6">
								<?php echo $this->Form->input('acti_fecha_termino', array('type' => 'text', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Fecha de Término')), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'divClass' => 'col-sm-8')); ?>
							</div>
						</div>
					<?php else: ?>

						<div class="form-group">
							
							<div class="col-sm-6">
								<?php echo $this->Form->input('acti_fecha_inicio', array('type' => 'text', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Fecha de Inicio')), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'divClass' => 'col-sm-8')); ?>
							</div>
							<div class="col-sm-6">
								<?php echo $this->Form->input('acti_fecha_termino', array('type' => 'text', 'label' => array('class' => 'col-sm-4 control-label', 'text' => __('Fecha de Término')), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'divClass' => 'col-sm-8')); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php echo $this->Form->input('acti_observaciones', array('label' => __('Observaciones'), 'divClass' => 'col-sm-10', 'style' => 'height: 80px;')); ?>
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
				<?php echo __('Horario de Actividad'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<?php
							$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
							echo $this->Form->input('acti_dia', array('label' => 'Día 1', 'options' => $dias, 'empty' => __('-- Seleccione Opción --')));
						?>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="ActividadActiHora" class="col-sm-2 control-label">Hora 1</label>
								<div class="col-sm-9">
									<input name="data[Actividad][acti_hora]" maxlength="255" class="form-control" type="time" value="00:00" id="ActividadActiHora">
								</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?php
							$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
							echo $this->Form->input('acti_dia2', array('label' => 'Día 2', 'options' => $dias, 'empty' => __('-- Seleccione Opción --')));
						?>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="ActividadActiHora2" class="col-sm-2 control-label">Hora 2</label>
								<div class="col-sm-9">
									<input name="data[Actividad][acti_hora2]" maxlength="255" class="form-control" type="time" value="00:00" id="ActividadActiHora2">
								</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<?php
							$dias = array(1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo');
							echo $this->Form->input('acti_dia3', array('label' => 'Día 3', 'options' => $dias, 'empty' => __('-- Seleccione Opción --')));
						?>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="ActividadActiHora3" class="col-sm-2 control-label">Hora 3</label>
								<div class="col-sm-9">
									<input name="data[Actividad][acti_hora3]" maxlength="255" class="form-control" type="time" value="00:00" id="ActividadActiHora3">
								</div>
						</div>
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
				<?php echo __('Presupuesto'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> '. __('Nuevo Gasto'), 'javascript:;', array('escape' => false, 'id' => 'btnNuevoGasto', 'class' => 'btn btn-success pull-right')); ?>
					</div>
					<div class="col-sm-12">
						<br />
						<table class="table table-bordered table-hover" id="tablaGastos">
							<thead>
								<tr>
									<th><?php echo __('Concepto'); ?></th>
									<th><?php echo __('Fuente'); ?></th>
									<th><?php echo __('Detalle'); ?></th>
									<th><?php echo __('Cantidad'); ?></th>
									<th><?php echo __('Valor Unitario'); ?></th>
									<th><?php echo __('Total'); ?></th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>	
								<tr>
									<td>
										<?php
											$conceptos_ = array();
											foreach ($conceptos as $conc) {
												$conceptos_[$conc['Concepto']['conc_id']] = $conc['Concepto']['conc_nombre'];
											}
											echo $this->Form->input('GastoActividad.0.conc_id', array('div' => false, 'options' => $conceptos_));
										?>
									</td>
									<td>
										<?php
											$fuentesFinanciamientos_ = array();
											foreach ($fuentesFinanciamientos as $fufi) {
												$fuentesFinanciamientos_[$fufi['FuenteFinanciamiento']['fufi_id']] = $fufi['FuenteFinanciamiento']['fufi_nombre'];
											}
											echo $this->Form->input('GastoActividad.0.fufi_id', array('div' => false, 'options' => $fuentesFinanciamientos_));
										?>
									</td>
									<td>
										<?php echo $this->Form->input('GastoActividad.0.gaac_detalle', array('required' => 'required', 'type' => 'text', 'div' => false)); ?>
									</td>
									<td>
										<?php echo $this->Form->input('GastoActividad.0.gaac_cantidad', array('required' => 'required', 'type' => 'number', 'div' => false, 'class' => 'form-control cantidadRow', 'onkeypress' => 'javascript:return validchars(event, num);', 'onkeyup' => 'javascript:updTotal(this);', 'onclick' => 'javascript:updTotal(this);')); ?>
									</td>
									<td>
										<?php echo $this->Form->input('GastoActividad.0.gaac_valor_unitario', array('required' => 'required', 'type' => 'number', 'div' => false, 'class' => 'form-control valorUnitarioRow', 'onkeypress' => 'javascript:return validchars(event, num);', 'onkeyup' => 'javascript:updTotal(this);', 'onclick' => 'javascript:updTotal(this);')); ?>
									</td>
									<td>
										<?php echo $this->Form->input('GastoActividad.0.gaac_total', array('readonly' => 'readonly', 'required' => 'required', 'div' => false, 'class' => 'form-control totalRow', 'onkeypress' => 'javascript:return validchars(event, num);')); ?>
									</td>
									<td>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-sm-12">
						<p id="totalGastos" class="label label-default pull-right"><strong>Total: $0</strong></p>
					</div>
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

<script id="gastos-template" type="text/x-handlebars-template">
	<tr>
		<td>
			<select class="form-control" required="required" name="data[GastoActividad][{{index}}][conc_id]">
				{{#each conceptos}}
					<option value="{{this.Concepto.conc_id}}">{{this.Concepto.conc_nombre}}</option>
				{{/each}}
			</select>
		</td>
		<td>
			<select class="form-control" required="required" name="data[GastoActividad][{{index}}][fufi_id]">
				{{#each fuentesFinanciamientos}}
					<option value="{{this.FuenteFinanciamiento.fufi_id}}">{{this.FuenteFinanciamiento.fufi_nombre}}</option>
				{{/each}}
			</select>
		</td>
		<td>
			<input required="required" name="data[GastoActividad][{{index}}][gaac_detalle]" type="text" class="form-control" />
		</td>
		<td>
			<input required="required" onkeypress="javascript:return validchars(event, num);" onkeyup="javascript:updTotal(this);" onclick="javascript:updTotal(this);" name="data[GastoActividad][{{index}}][gaac_cantidad]" class="form-control cantidadRow" type="number" />
		</td>
		<td>
			<input required="required" onkeypress="javascript:return validchars(event, num);" onkeyup="javascript:updTotal(this);" onclick="javascript:updTotal(this);" name="data[GastoActividad][{{index}}][gaac_valor_unitario]" class="form-control valorUnitarioRow" type="number" />
		</td>
		<td>
			<input readonly="readonly" required="required" onkeypress="javascript:return validchars(event, num);" name="data[GastoActividad][{{index}}][gaac_total]" class="totalRow form-control totalRow" type="number" />
		</td>
		<td>
			<a data-placement="top" data-original-title="Eliminar" class="btnEliminaGasto btn btn-xs btn-bricky tooltips" href="javascript:;">
				<i class="fa fa-times fa fa-white"></i>
			</a>
		</td>
	</tr>
</script>

<script>

var updTotal = function(t) {
	var cantidad = $(t).parent().parent().find('.cantidadRow').val();
	var valorUnitario = $(t).parent().parent().find('.valorUnitarioRow').val();

	if (!isNaN(cantidad) && !isNaN(valorUnitario)) {
		var total = cantidad * valorUnitario;
		$(t).parent().parent().find('.totalRow').val(total);

		var total = 0;
		$('.totalRow').each(function() {
			if ($(this).val().trim() != '') {
				total += parseInt($(this).val());
			}
		});

		$('#totalGastos').html('<strong>Total: $'+ $.number(total, 0, ',', '.') +'</strong>');
	}
}

var datePickers = function() {
	$('.date-picker') .each(function() {
		$(this).datepicker({autoclose: true});
	});
};

$(document).on('click', '.btnEliminaGasto', function() {
	$(this).parent().parent().remove();
});

$(document).ready(function() {
	var index = 1;
	var conceptos = JSON.parse('<?php echo json_encode($conceptos); ?>');
	var fuentesFinanciamientos = JSON.parse('<?php echo json_encode($fuentesFinanciamientos); ?>');

	$('#btnNuevoGasto').on('click', function() {
		var source = $("#gastos-template").html();
		var template = Handlebars.compile(source);
		var html = template({
			index: index,
			conceptos: conceptos,
			fuentesFinanciamientos: fuentesFinanciamientos
		});

		$('#tablaGastos > tbody').append(html);
		index++;
		datePickers();
	});

	$('#ActividadProgId').on('change', function() {
		var prog_id = $(this).val();
		$('#ActividadAreaId').html('<option>-- Seleccione Opción --</option>');
		$('#ActividadTiacId').html('<option>-- Seleccione Opción --</option>');

		if (prog_id != null) {
			$.ajax({
				type: 'POST',
				url: '/areas/find_by_prog',
				data: {
					prog_id: prog_id
				},
				dataType: 'json',
				cache: false,
				beforeSend: function() {
					$('#ActividadAreaId').html('<option>-- Seleccione Opción --</option>');
				},
				success: function(data) {
					var htmlStr = '';
					$.each(data, function(i, obj) {
						htmlStr += '<option value='+ obj.Area.area_id +'>'+ obj.Area.area_nombre +'</option>';
					});
					$('#ActividadAreaId').append(htmlStr);
				},
				error: function() {
					alert('Ha ocurrido un error al procesar la petición');
				}
			});
		}
	});

	$('#ActividadAreaId').on('change', function() {
		var area_id = $(this).val();
		$('#ActividadTiacId').html('<option>-- Seleccione Opción --</option>');

		if (area_id != '') {
			$.ajax({
				type: 'POST',
				url: '/tipos_actividades/find_by_areas',
				data: {
					area_id: area_id
				},
				dataType: 'json',
				cache: false,
				beforeSend: function() {
					$('#ActividadTiacId').html('<option>-- Seleccione Opción --</option>');
				},
				success: function(data) {
					var htmlStr = '';
					$.each(data, function(i, obj) {
						htmlStr += '<option value='+ obj.TipoActividad.tiac_id +'>'+ obj.TipoActividad.tiac_nombre +'</option>';
					});
					$('#ActividadTiacId').append(htmlStr);
				},
				error: function() {
					alert('Ha ocurrido un error al procesar la petición');
				}
			});
		}
	});

	var usuarios = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: '/usuarios/find_usuarios_by_perfil?q=%QUERY&perf_id=6',
			filter: function(list) {
				return $.map(list, function(usuario) {
					return {
						id: usuario.Usuario.usua_id,
						name: usuario.Usuario.usua_nombre_completo
					}; 
				});
			}
		}
	});
	usuarios.initialize();

	$('#ActividadUsuaNombre').typeahead({
		hint: true,
		highlight: true,
		minLength: 3
	},
	{
		name: 'usuarios',
		displayKey: 'name',
		source: usuarios.ttAdapter()
	}).on('typeahead:selected', function(event, suggestion, name) {	
		$('#ActividadUsuaId').val(suggestion.id);
	});

	$('#ActividadCefaId').on('change', function() {
		var cefa_id = $(this).val();
		
		if (cefa_id != '') {
			$.ajax({
				type: 'POST',
				url: '/instituciones/find_by_cefa',
				data: {
					cefa_id: cefa_id
				},
				cache: false,
				dataType: 'json',
				beforeSend: function() {
					
				},
				success: function(data) {
					$('#ActividadInstId').html('');
					var html_str = '<option value="">-- Seleccione Opción --</option>';

					$.each(data, function(i, obj) {
						html_str += '<option value="'+ obj.Institucion.inst_id +'">'+ obj.Institucion.inst_nombre +'</option>';
					});
					$('#ActividadInstId').append(html_str);
				},
				error: function() {
					alert('Ha ocurrido un error al procesar su petición');
				}
			});
		}
	});
});
</script>
