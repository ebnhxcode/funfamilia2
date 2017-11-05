
<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<i class="clip-pencil"></i>
				<?php echo $this->Html->link(__('Centros Familiares'), array('action' => 'index')); ?>
			</li>
			<li class="active">
				<?php echo __('Detalle Centro Familiar'); ?>
			</li>
		</ol>
		<div class="page-header">
			<h1><?php echo __('Detalle Centro Familiar'); ?> <small><?php echo __('Detalle Centro Familiar'); ?></small></h1>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square"></i>
		<?php echo ('Detalle Centro Familiar'); ?>
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
					<td><?php echo h($centroFamiliar['CentroFamiliar']['cefa_id']); ?></strong></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Nombre'); ?></strong></td>
					<td><?php echo h($centroFamiliar['CentroFamiliar']['cefa_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Dirección'); ?></strong></td>
					<td><?php echo h($centroFamiliar['CentroFamiliar']['cefa_direccion']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Comuna'); ?></strong></td>
					<td><?php echo h($centroFamiliar['Comuna']['comu_nombre']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Fono'); ?></strong></td>
					<td><?php echo h($centroFamiliar['CentroFamiliar']['cefa_nro_fijo']); ?></td>
				</tr>
				<tr>
					<td><strong><?php echo __('Correo Electrónico'); ?></strong></td>
					<td><?php echo h($centroFamiliar['CentroFamiliar']['cefa_email']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
