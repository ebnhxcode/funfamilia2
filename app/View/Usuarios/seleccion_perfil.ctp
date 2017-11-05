<div class="main-login col-sm-4 col-sm-offset-4">
	<div class="logo">
		<img src="/img/funfamilia.PNG" />
	</div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<h3><?php echo __('Seleccione Perfil'); ?></h3>
		<p>
			<?php echo __('Por favor, seleccione perfil con el cual trabajará dentro de la plataforma.'); ?>
		</p>
		<?php echo $this->Form->create('PerfilUsuario', array('class' => 'form-login')); ?>
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> <?php echo __('Tiene algunos errores. Por favor revíselos.'); ?>
			</div>
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<?php echo $this->Form->input('peus_id', array('div' => false, 'required' => true, 'label' => false, 'options' => $perfiles, 'empty' => __('-- Seleccione Opción --'))); ?>
					</span>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-bricky pull-right">
						<?php echo __('Ingresar'); ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		<?php echo $this->Form->end(); ?>
	</div>
	<!-- end: LOGIN BOX -->
	
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		2014 &copy; <?php echo __('Fundación de la Familia'); ?>.
	</div>
	<!-- end: COPYRIGHT -->
</div>
		