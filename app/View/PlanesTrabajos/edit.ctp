<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Plan de Acompañamiento'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Editar Plan de Acompañamiento'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Editar Plan de Acompañamiento'); ?> <small><?php echo __('Editar Plan de Acompañamiento'); ?></small></h1>
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
				<?php echo $this->Form->input('CentroFamiliar.cefa_id', array('label' => __('Centro Familiar'), 'disabled' => 'disabled', 'options' => $centrosFamiliares, 'empty' => __('-- Seleccione Opción --'))); ?>
				<?php echo $this->Form->input('Persona.pers_nombre', array('label' => __('Persona'), 'disabled' => 'disabled')); ?>
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
		<?php $index = 0; ?>
		<?php foreach ($niveles as $nive): ?>
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
										<?php foreach($nive['FactorProtector'] as $fapr): ?>
											<tr>
												<td>
													<?php echo trim($fapr['fapr_objetivos']); ?>
													<?php echo $this->Form->input('DetallePlanTrabajo.'. $index .'.fapr_id', array('div' => false, 'type' => 'hidden', 'label' => false, 'value' => $fapr['fapr_id'])); ?>
												</td>
												<td>
													<?php
														if (isset($detallePlanTrabajo[$fapr['fapr_id']])) {
															$valueActi = $detallePlanTrabajo[$fapr['fapr_id']]['DetallePlanTrabajo']['acti_id'];
															echo $this->Form->input('DetallePlanTrabajo.'. $index .'.acti_id', array('value' => $valueActi, 'label' => false, 'options' => $actividades, 'class' => 'form-control actividades-combo', 'empty' => __('-- Seleccione Opción --'), 'div' => false));
														} else {
															echo $this->Form->input('DetallePlanTrabajo.'. $index .'.acti_id', array('label' => false, 'options' => $actividades, 'class' => 'form-control actividades-combo', 'empty' => __('-- Seleccione Opción --'), 'div' => false));
														}
													?>
												</td>		
												<td>
													<?php
														if (isset($detallePlanTrabajo[$fapr['fapr_id']])) {
															$valueObs = $detallePlanTrabajo[$fapr['fapr_id']]['DetallePlanTrabajo']['dept_observaciones'];
															echo $this->Form->input('DetallePlanTrabajo.'. $index .'.dept_observaciones', array('value' => $valueObs, 'label' => false, 'type' => 'textarea', 'style' => 'height:70px; width: 100%', 'div' => false));
														} else {
															echo $this->Form->input('DetallePlanTrabajo.'. $index .'.dept_observaciones', array('label' => false, 'type' => 'textarea', 'style' => 'height:70px; width: 100%', 'div' => false));
														}
													?>
												</td>
											</tr>
										<?php $index++; ?>
										<?php endforeach; ?>
									</tbody>
								</table>
						  	</div>
						  	
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="col-sm-2 col-sm-offset-10">
	<br />
	<button class="btn btn-yellow btn-block" type="submit"><?php echo __('Guardar'); ?> <i class="fa fa-arrow-circle-right"></i></button>
	<br />
</div>

<?php echo $this->Form->input('pltr_id', array('div' => false)); ?>
<?php echo $this->Form->end(); ?>