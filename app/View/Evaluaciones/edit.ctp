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
				<?php echo $this->Form->input('CentroFamiliar.cefa_id', array('label' => __('Centro Familiar'), 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'), 'disabled' => 'disabled')); ?>
				<?php echo $this->Form->input('Persona.pers_nombre', array('label' => __('Persona'), 'disabled' => 'disabled')); ?>
				<?php echo $this->Form->input('Evaluacion.tiev_id', array('label' => __('Tipo de Evaluación'), 'options' => $tiposEvaluaciones, 'empty' => __('-- Seleccione Opción --'), 'disabled' => 'disabled')); ?>
				<?php echo $this->Form->input('Evaluacion.eval_fecha', array('label' => __('Fecha'), 'class' => 'form-control date-picker', 'data-date-format' => 'dd-mm-yyyy', 'data-date-viewmode' => 'years', 'type' => 'text', 'disabled' => 'disabled')); ?>
				<?php echo $this->Form->input('Evaluacion.eval_observacion', array('label' => __('Observaciones'), 'class' => 'form-control', 'disabled' => 'disabled')); ?>
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
					<?php $index = 0; ?>
					<?php foreach($this->request->data['EvaluacionFactorProtector'] as $evfp): ?>
						<?php $ifpr = $evfp['IndicadorFactorProtector']; ?>
						<tr>
							<td>
								<?php echo $ifpr['ifpr_descripcion']; ?>
								<?php echo $this->Form->input('EvaluacionFactorProtector.'.$index.'.evfp_id', array('type' => 'hidden', 'div' => false)); ?>
								<?php echo $this->Form->input('EvaluacionFactorProtector.'.$index.'.ifpr_id', array('type' => 'hidden', 'div' => false)); ?>
							</td>

							<?php for($i=1; $i<=5; $i++): ?>
								<td>
									
									<label class="radio-inline">
										<?php if (isset($this->request->data['EvaluacionFactorProtector'][$index]['evfp_valor']) && $this->request->data['EvaluacionFactorProtector'][$index]['evfp_valor'] == $i): ?>
											<input checked="checked" type="radio" value="<?php echo $i; ?>" name="data[EvaluacionFactorProtector][<?php echo $index; ?>][evfp_valor]">
										<?php else: ?>
											<input type="radio" value="<?php echo $i; ?>" name="data[EvaluacionFactorProtector][<?php echo $index; ?>][evfp_valor]">
										<?php endif; ?>
									</label>
								</td>
							<?php endfor; ?>
						</tr>
						<?php $index++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- SE SACA A PEDIDO DE LA GENTE DE FUNFAMILIA REUNION 19-11-2014 -->
		<!--
		<?php $index = 0; ?>
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
													<td>
														<?php echo $ifpr['ifpr_descripcion']; ?>
														<?php echo $this->Form->input('EvaluacionFactorProtector.'.$index.'.evfp_id', array('type' => 'hidden', 'div' => false)); ?>
														<?php echo $this->Form->input('EvaluacionFactorProtector.'.$index.'.ifpr_id', array('type' => 'hidden', 'div' => false)); ?>
													</td>
													<td>
														<?php for($i=1; $i<=5; $i++): ?>
															<label class="radio-inline">
																<?php if ($this->request->data['EvaluacionFactorProtector'][$index]['evfp_valor'] == $i): ?>
																	<input checked="checked" type="radio" value="<?php echo $i; ?>" name="data[EvaluacionFactorProtector][<?php echo $index; ?>][evfp_valor]">
																<?php else: ?>
																	<input type="radio" value="<?php echo $i; ?>" name="data[EvaluacionFactorProtector][<?php echo $index; ?>][evfp_valor]">
																<?php endif; ?>
																<?php echo $i; ?>
															</label>
														<?php endfor; ?>
													</td>
												</tr>
												<?php $index++; ?>
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
		-->
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
									echo $this->Form->input('EvaluacionFactorRiesgo.'. $index .'.evfr_id', array('type' => 'hidden', 'div' => false));
									echo $this->Form->input('EvaluacionFactorRiesgo.'. $index .'.fari_id', array('type' => 'hidden', 'div' => false, 'value' => $fari['FactorRiesgo']['fari_id']));
								?>
								<label class="radio-inline">
									<input <?php if(isset($this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente']) && $this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente'] == 1) echo 'checked="checked"'; ?> type="radio" value="1" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
									<?php echo __('Presente'); ?>
								</label>
								<label class="radio-inline">
									<input <?php if(isset($this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente']) && $this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente'] == 0) echo 'checked="checked"'; ?> type="radio" value="0" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
									<?php echo __('Ausente'); ?>
								</label>
								<label class="radio-inline">
									<input <?php if(isset($this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente']) && $this->request->data['EvaluacionFactorRiesgo'][$index]['evfr_presente'] == -1) echo 'checked="checked"'; ?> type="radio" value="-1" name="data[EvaluacionFactorRiesgo][<?php echo $index; ?>][evfr_presente]">
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
<?php echo $this->Form->input('eval_id', array('type' => 'hidden', 'div' => false)); ?>
<?php echo $this->Form->end(); ?>
<br />
