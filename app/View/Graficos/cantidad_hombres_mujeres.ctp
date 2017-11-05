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
				<?php echo __('Gráfico de Cantidad de Hombres y Mujeres'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Gráfico de Cantidad de Hombres y Mujeres'); ?> <small><?php echo __('Gráfico de Cantidad de Hombres y Mujeres'); ?></small></h1>
		</div>
	</div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				<?php echo __('Gráfico de Cantidad de Hombres y Mujeres'); ?>

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

	// preparamos datos y ejes
	$ejeX = array();
	$i = 0;
	foreach ($centrosFamiliares as $cefa) {
		$ejeX[] = array(
			$i,
			$cefa['CentroFamiliar']['cefa_nombre'],
		);
		$i++;
	}

	$totalHombres = array();
	$i = 0;
	foreach ($info as $row) {
		$row = array_pop($row);
		$totalHombres[] = array(
			$i,
			$row['total_hombres']
		);
		$i++;
	}

	$totalMujeres = array();
	$i = 0;
	foreach ($info as $row) {
		$row = array_pop($row);
		$totalMujeres[] = array(
			$i,
			$row['total_mujeres']
		);
		$i++;
	}
?>

<script>
$(document).ready(function() {
    var dataTotalHombres = <?php echo json_encode($totalHombres); ?>;
    var dataTotalMujeres = <?php echo json_encode($totalMujeres); ?>;

    var data1 = [
        {
            label: "Hombres",
            data: dataTotalHombres,
            bars: {
                show: true,
                barWidth: 0.2,
                fill: true,
                lineWidth: 1,
                order: 2,
                fillColor:  "#89A54E"
            },
            color: "#89A54E"
        },
        {
            label: "Mujeres",
            data: dataTotalMujeres,
            bars: {
                show: true,
                barWidth: 0.2,
                fill: true,
                lineWidth: 1,
                order: 3,
                fillColor:  "#4572A7"
            },
            color: "#4572A7"
        }
    ];

    $.plot($('#grafico'), data1, {
        xaxis: {
            ticks: <?php echo json_encode($ejeX); ?>,
            tickLength: 0, // hide gridlines
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        grid: {
            hoverable: true,
            clickable: false,
            borderWidth: 1
        },
        series: {
        	shadowSize: 1,
            valueLabels: {
                show: false,
                showAsHtml: false, // Set to true if you wanna switch back to DIV usage (you need plot.css for this)
                showLastValue: false, // Use this to show the label only for the last value in the series
                labelFormatter: function (v) {
                    return v;
                }, // Format the label value to what you want
                align: 'start', // can also be 'center', 'left' or 'right'
                plotAxis: 'y', // Set to the axis values you wish to plot
                hideZero: false
            }
        }
    });

	$('#grafico').bind("plothover", function (event, pos, item) {
		/*
		if (item) {
			console.log(item);
			console.log(item.pageX);
			console.log(item.pageY);
			console.log(item.series.label);
		}
		*/
	});
});
</script>