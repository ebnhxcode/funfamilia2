
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Evaluaciones'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle de Evaluación'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle de Evaluación'); ?> <small><?php echo __('Detalle de Evaluación'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Detalle de Evaluación'); ?>
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
			<table id="sample-table-1" class="table table-bordered table-hover">
				<tr>
					<td><strong>#</strong></td>
					<td><?php echo h($evaluacion['Evaluacion']['eval_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
					<td><?php echo h($evaluacion['PersonaCentroFamiliar']['CentroFamiliar']['cefa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('RUN'); ?></strong></td>
					<td><?php echo h($evaluacion['PersonaCentroFamiliar']['Persona']['pers_run_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($evaluacion['PersonaCentroFamiliar']['Persona']['pers_nombre_completo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Tipo de Evaluación'); ?></strong></td>
					<td><?php echo h($evaluacion['TipoEvaluacion']['tiev_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Grupo Objetivo'); ?></strong></td>
					<td><?php echo h($evaluacion['GrupoObjetivo']['grob_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha'); ?></strong></td>
					<td><?php echo $this->Time->format($evaluacion['Evaluacion']['eval_fecha'], '%d-%m-%Y'); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Observaciones'); ?></strong></td>
					<td><?php echo h($evaluacion['Evaluacion']['eval_observacion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fecha de Creación'); ?></strong></td>
					<td><?php echo $this->Time->format($evaluacion['Evaluacion']['eval_fecha_creacion'], '%d-%m-%Y %H:%M:%S'); ?></td>
				</tr>
			</table>
		</div>	
	</div>
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li id="fProtectoresTab" class="active"><a href="#fProtectores" role="tab" data-toggle="tab"><?php echo __('Evaluación de Factores Protectores'); ?></a></li>
  	
  	<?php if ($evaluacion['Evaluacion']['tiev_id'] == 1): // solo diagnostica ?>
  		<li id="fRiesgosTab"><a href="#fRiesgos" role="tab" data-toggle="tab"><?php echo __('Evaluación de Factores de Riesgo'); ?></a></li>
  	<?php endif; ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="fProtectores">
		<?php
			// creamos matriz de ev de factores protectores
			$evfpMatrix = array();
			foreach ($evaluacion['EvaluacionFactorProtector'] as $evfp) {
				$fapr_id = $evfp['IndicadorFactorProtector']['fapr_id'];
				$ifpr_id = $evfp['IndicadorFactorProtector']['ifpr_id'];
				$evfpMatrix[$fapr_id][$ifpr_id] = $evfp['evfp_valor'];
			}

			//pr($evfpMatrix);
		?>

		<!-- CAMBIOS SOLICITADOS POR XIMENA ARRIAGADA EL 22-12-2014 -->
		<!--
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
					<?php foreach($niveles as $nive): ?>
						<?php foreach($nive['FactorProtector'] as $fapr): ?>
							<?php foreach($fapr['IndicadorFactorProtector'] as $ifpr): ?>
								<tr>
									<td><?php echo $ifpr['ifpr_descripcion']; ?></td>
									<?php for ($i=1; $i<=5; $i++): ?>
										<td>
											<label class="radio-inline">
												<?php if (isset($evfpMatrix[$ifpr['fapr_id']][$ifpr['ifpr_id']]) && $evfpMatrix[$ifpr['fapr_id']][$ifpr['ifpr_id']] == $i): ?>
													<input name="opt_<?php echo $ifpr['ifpr_id']; ?>" checked="checked" type="radio" value="-1" class="grey">
												<?php else: ?>
													<input name="opt_<?php echo $ifpr['ifpr_id']; ?>" type="radio" value="-1" class="grey">
												<?php endif; ?>
											</label>
										</td>
									<?php endfor; ?>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		-->

		<?php foreach($niveles as $nive): ?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
							<?php echo $nive['Nivel']['nive_nombre']; ?>
							<div class="panel-tools">
								<a href="javascript:;" class="btn btn-xs btn-link expand" data-toggle="collapse" data-target="#nive<?php echo $nive['Nivel']['nive_id']; ?>"></a>
							</div>
						</div>
						<div class="panel-body collapse out" id="nive<?php echo $nive['Nivel']['nive_id']; ?>">
							<?php foreach($nive['FactorProtector'] as $fapr): ?>
								<h3><?php echo $fapr['fapr_nombre']; ?></h3>
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<tbody>
											<?php foreach($fapr['IndicadorFactorProtector'] as $ifpr): ?>
												<tr>
													<td width="70%"><?php echo $ifpr['ifpr_descripcion']; ?></td>
													<td>
														<?php
															$valor = $evfpMatrix[$ifpr['fapr_id']][$ifpr['ifpr_id']];

															if ($valor == 1) {
																echo __('Totalmente en desacuerdo'); 
															} elseif ($valor == 2) {
																echo __('En desacuerdo');
															} elseif ($valor == 3) {
																echo __('Ni de acuerdo ni en desacuerdo');
															} elseif ($valor == 4) {
																echo __('De acuerdo');
															} elseif ($valor == 5) {
																echo __('Totalmente de acuerdo');
															}
														?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
							  	</div>
						  	<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
	<?php if ($evaluacion['Evaluacion']['tiev_id'] == 1): // solo diagnostica ?>
		<div class="tab-pane" id="fRiesgos">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th><?php echo __('Factor'); ?></th>
							<th><?php echo __('Presente/Ausente/No Aplica'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($evaluacion['EvaluacionFactorRiesgo'] as $evfr): ?>
							<tr>
								<td><?php echo $evfr['FactorRiesgo']['fari_descripcion'] ?></td>
								<td>
									<?php
										if ($evfr['evfr_presente'] == 1) {
											echo 'Presente';
										} elseif ($evfr['evfr_presente'] == 0) {
											echo 'Ausente';
										} elseif ($evfr['evfr_presente'] == -1) {
											echo 'No Aplica';
										}
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>