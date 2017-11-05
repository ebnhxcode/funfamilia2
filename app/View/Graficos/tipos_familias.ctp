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
				<?php echo __('Gráfico de Tipos de Familia'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Gráfico de Tipos de Familia'); ?> <small><?php echo __('Gráfico de Tipos de Familia'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Gráfico de Tipos de Familia'); ?>

				<div class="panel-tools">
					<a href="#" class="btn btn-xs btn-link panel-collapse collapses">
					</a>
					<a href="#" class="btn btn-xs btn-link panel-expand">
						<i class="fa fa-expand"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
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
			'label' => 'Unipersonal',
			'data' => $info[0][0]['total_unipersonal']
		),
		array(
			'label' => 'Nuclear Simple',
			'data' => $info[0][0]['total_nuclear_simple']
		),
		array(
			'label' => 'Nuclear Biparenteal',
			'data' => $info[0][0]['total_nuclear_biparental']
		),
		array(
			'label' => 'Monoparental Madre',
			'data' => $info[0][0]['total_monoparental_madre']
		),
		array(
			'label' => 'Monoparental Padre',
			'data' => $info[0][0]['total_monoparental_padre']
		),
		array(
			'label' => 'Monoparental Abuelo',
			'data' => $info[0][0]['total_monoparental_abuelo']
		),
		array(
			'label' => 'Monoparental Otro',
			'data' => $info[0][0]['total_monoparental_otro']
		),
		array(
			'label' => 'Extendida',
			'data' => $info[0][0]['total_extendida']
		)
	);
?>

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