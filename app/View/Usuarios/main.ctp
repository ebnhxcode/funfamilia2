<?php
	$nombre = AuthComponent::user('usua_nombre_completo');
?>

<ol class="breadcrumb">
	<li>
		<i class="clip-file"></i>
		<a href="#">
			Pages
		</a>
	</li>
	<li class="active">
		<?php echo __('Usuarios'); ?>
	</li>
	<?php echo $this->element('search'); ?>
</ol>

<?php echo $this->Session->flash(); ?>

<div class="row page-header">
	<div class="col-xs-12">
		<h1><?php echo __('Bienvenido %s', $nombre); ?> <small><?php echo __('Bienvenido %s', $nombre); ?></small></h1>
	</div>

</div>

<div class="table-responsive">
	<table id="sample-table-1" class="table table-bordered table-hover">
		<tr>
			<td><strong><?php echo __('Nombre'); ?></strong></td>
			<td><?php echo h($persona['Usuario']['usua_nombre_completo']); ?></td>
		</tr>
		<tr>
			<td><strong><?php echo __('Usuario'); ?></strong></td>
			<td><?php echo h($persona['Usuario']['usua_username']); ?></td>
		</tr>
		<tr>
			<td><strong><?php echo __('Correo Electrónico'); ?></strong></td>
			<td><?php echo h($persona['Usuario']['usua_email']); ?></td>
		</tr>
		<tr>
			<td><strong><?php echo __('Perfil'); ?></strong></td>
			<td><?php echo h($persona['Perfil']['perf_nombre']); ?></td>
		</tr>

		<?php if (!empty($cefa_id)): ?>
			<tr>
				<td><strong><?php echo __('Centro Familiar'); ?></strong></td>
				<td><?php echo h($persona['CentroFamiliar']['cefa_nombre']); ?></td>
			</tr>
		<?php endif; ?>
		<tr>
			<td><strong><?php echo __('Fecha de Ingreso'); ?></strong></td>
			<td><?php echo $this->Time->format(time(), '%d-%m-%Y %H:%M:%S'); ?></td>
		</tr>
	</table>
</div>
