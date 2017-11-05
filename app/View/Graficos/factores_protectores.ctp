<style>
#grafico {
    width: 100%;
    height: 400px;
}
#pie {
    width: 100%;
	height: 400px;
}
#barmonth {
    max-width: none;
    height: 400px;
}
#baryear {
    max-width: none;
    height: 400px;
}
</style>

<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Gráficos'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Gráfico de Factores Protectores'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Gráfico de Factores Protectores'); ?> <small><?php echo __('Gráfico de Factores Protectores'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Centros Familiares'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Grafico'); ?>
				<?php echo $this->Form->input('ano_id', array('label' => __('Año'), 'options' => array(), 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('grob_id', array('label' => __('Grupo Objetivo'), 'options' => $gruposObjetivos, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('nive_id', array('label' => __('Nivel'), 'options' => array(), 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('fapr_id', array('label' => __('Factor Protector'), 'options' => array(), 'empty' => __('-- Seleccione Opción --'))); ?>

				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-9">
						<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Generar Gráfico'); ?> <i class="fa fa-arrow-circle-right"></i></button>
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#GraficoFactoresProtectoresForm').on('submit', function() {
		var ano_id  = $('#GraficoAnoId').val();
		var cefa_id = $('#GraficoCefaId').val();
		var grob_id = $('#GraficoGrobId').val();
		var nive_id = $('#GraficoNiveId').val();
		var fapr_id = $('#GraficoFaprId').val();

		if (ano_id == '') {
			alert('Debe seleccionar un año');
			return false;
		}
		if (cefa_id == '') {
			alert('Debe seleccionar un centro familiar');
			return false;
		}
		if (grob_id == '') {
			alert('Debe seleccionar un grupo objetivo');
			return false;
		}
		if (nive_id == '') {
			alert('Debe seleccionar un nivel');
			return false;
		}
		if (fapr_id == '') {
			alert('Debe seleccionar un factor protector');
			return false;
		}
		return true;
	});

	function setearAnioCombobox(){
		var	anioActual = new Date;

		anioActual = anioActual.getFullYear();
		for(var i = anioActual; i >= 2014; i--){
			$('#GraficoAnoId').append('<option value="'+i+'">'+i+'</option>');
		}

	}
	setearAnioCombobox();

	$('#GraficoAnoId').change(function(){
		$('#GraficoGrobId').val("");
		$('#GraficoNiveId').val("");
		$('#GraficoFaprId').val("");
	});

    //  GraficoGrobId
    $('#GraficoGrobId').change(function() {
    	var insertarA = $('#GraficoNiveId');
    	var insertarFapr = $('#GraficoFaprId');
    	insertarFapr.empty();
    	insertarA.empty();
    	insertarA.html('<option value="">-- Seleccione Opción --</option>');
    	insertarFapr.html('<option value="">-- Seleccione Opción --</option>');
    	var grob_id = $(this).val();
    	$.post('/niveles/find_niveles_by_grob', {grob_id : grob_id}, function(data){
    		//alert(data);
    		var temp = JSON.parse(data);
    		$.each(temp, function(n, elem){
    			//console.log(elem.Nivel.nive_nombre);
    			insertarA.append('<option value="'+elem.Nivel.nive_id+'">'+elem.Nivel.nive_nombre+'</option>');
    		});
    	});
    });
    //  GraficoNiveId
    $('#GraficoNiveId').change(function(){
    	var insertarFapr = $('#GraficoFaprId');
    	insertarFapr.empty();
    	insertarFapr.html('<option value="">-- Seleccione Opción --</option>');
    	var nive_id = $(this).val();
    	var fapr_ano = $('#GraficoAnoId').val();
    	$.post('/factoresProtectores/find_factores_by_nivel_y_ano', {'nive_id' : nive_id, 'fapr_ano' : fapr_ano}, function(moreData){
    		//alert(moreData);
    		temp = JSON.parse(moreData);
    		$.each(temp, function(n, elem){
    			//console.log(elem.Nivel.nive_nombre);
    			insertarFapr.append('<option value="'+elem.FactorProtector.fapr_id+'">'+elem.FactorProtector.fapr_nombre+'</option>');
    		});

    	});
    });

    //  GraficoFaprId
    $('#GraficoFaprId').change(function(){
    	//alert('test3!');
    });

});
</script>

<?php if (isset($info)): ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i>
					<?php echo __('Gráfico de Factores Protectores'); ?>

					<div class="panel-tools">
						<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
						</a>
						<a href="#" class="btn btn-xs btn-link panel-expand">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<h5>Factores Protectores</h5>
					<div id="grafico">
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		// preparamos datos
		$info = array_pop($info);
		$info = array_pop($info);

		$jsonInfo = array(
			array(
				'label' => 'Muy Negativo',
				'data' => $info['total_muy_negativa']
 			),
 			array(
				'label' => 'Negativo',
				'data' => $info['total_negativa']
 			),
 			array(
				'label' => 'Intermedio',
				'data' => $info['total_intermedia']
 			),
 			array(
				'label' => 'Positivo',
				'data' => $info['total_positiva']
 			),
 			array(
				'label' => 'Muy Positivo',
				'data' => $info['total_muy_positiva']
 			)
		);

		$mostrarGrafico = true;
		// vemos si mostramos el grafico o no
		//if ($info['total_muy_negativa'] == 0 && $info['total_negativa'] == 0 && $info['total_intermedia']
		//	&& $info['total_positiva'] == 0 && $info['total_muy_positiva'] == 0) {
		//	$mostrarGrafico = false;
		//}
	?>

	<?php if ($mostrarGrafico): ?>	
		<script>
			$(document).ready(function() {
			    $.plot('#grafico', <?php echo json_encode($jsonInfo); ?>, {
			        series: {
			            pie: {
			                show: true
			            }
			        },
			    	legend: {
			        	show: false
			    	}
			    });
			});
		</script>
	<?php else: ?>
		<script>
			$(document).ready(function() {
			    $('#grafico').html('No existe información para mostrar');
			});
		</script>
	<?php endif; ?>	
<?php endif; ?>