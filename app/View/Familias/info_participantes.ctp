<div class="row page-header">
	<div class="col-xs-12">
		<h1><?php echo __('Integrantes del Grupo Familiar'); ?> <small><?php echo __('Integrantes del Grupo Familiar'); ?></small></h1>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo __('Integrantes del Grupo Familiar'); ?>
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
					<th><?php echo __('RUN'); ?></th>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Parentesco'); ?></th>
					<th><?php echo __('Jefatura de Hogar'); ?></th>
					<th></th>
				</tr>
				<?php foreach ($integrantes as $persona): ?>
					<tr>
						<td><?php echo $persona['IntegranteFamiliar']['pers_run_completo']; ?></td>
						<td><?php echo $persona['IntegranteFamiliar']['pers_nombre_completo']; ?></td>
						<td><?php echo !empty($persona['Parentesco']['pare_nombre'])? $persona['Parentesco']['pare_nombre']: null; ?></td>
						<td><?php echo ($persona['IntegranteFamiliar']['pers_id'] == $persona['Familia']['pers_id'])? 'Si': 'No'; ?></td>
						<td class="center">
							<div class="visible-md visible-lg visible-sm visible-xs">
								<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'personas', 'action' => 'edit', $persona['IntegranteFamiliar']['pers_id']), array('target' => '_blank', 'class' => 'btn btn-xs btn-green tooltips', 'data-original-title' => __('Ver'), 'data-placement' => 'top', 'escape' => false)); ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>