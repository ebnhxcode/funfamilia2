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
				<?php echo __('Gráfico de Factores de Riesgos'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Gráfico de Factores de Riesgos'); ?> <small><?php echo __('Gráfico de Factores de Riesgos'); ?></small></h1>
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
					<?php echo $this->Form->input('cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
					<?php echo $this->Form->input('fari_id', array('label' => __('Factor de Riesgo'), 'options' => $factoresRiesgos, 'empty' => __('-- Seleccione Opción --'))); ?>

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
	$('#GraficoFactoresRiesgosForm').on('submit', function() {
		var cefa_id = $('#GraficoCefaId').val();
		var fari_id = $('#GraficoFariId').val();

		if (cefa_id == '') {
			alert('Debe seleccionar el centro familiar');
			return false;
		}

		if (fari_id == '') {
			alert('Debe seleccionar el factor de riesgo');
			return false;
		}
		return true;
	});
});
</script>

<?php if (isset($info)): ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i>
					<?php echo __('Gráfico de Factores de Riesgo'); ?>

					<div class="panel-tools">
						<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
						</a>
						<a href="#" class="btn btn-xs btn-link panel-expand">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<h5>Factores de Riesgo</h5>
					<div id="grafico">
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
		// preparamos datos
		$jsonInfo = array(
			array(
				'label' => 'Presente',
				'data' => $info[0][0]['presente']
			),
			array(
				'label' => 'Ausente',
				'data' => $info[0][0]['ausente']
			),
			array(
				'label' => 'No Aplica',
				'data' => $info[0][0]['no_aplica']
			)
		);

		$muestraGrafico = true;
		if ($info[0][0]['presente'] == 0 && $info[0][0]['ausente'] == 0 && $info[0][0]['no_aplica'] == 0) {
			$muestraGrafico = false;
		}
	?>

	<?php if ($muestraGrafico): ?>
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

				/*
				//Categories 
			    var data_category = [
			        ["January", 10],
			        ["February", 8],
			        ["March", 4],
			        ["April", 13],
			        ["May", 17],
			        ["June", 9]
			    ];
			    $.plot("#grafico", [data_category], {
			        series: {
			            bars: {
			                show: true,
			                barWidth: 0.6,
			                align: "center",
			                fillColor: "#4DBEF4",
			                lineWidth: 0,
			            }
			        },
			        xaxis: {
			            mode: "categories",
			            tickLength: 0
			        }
			    });
				*/
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
