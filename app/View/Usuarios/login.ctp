<div class="main-login col-sm-4 col-sm-offset-4">
	<div class="logo">
		<img src="/img/funfamilia.PNG" />
	</div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<h3><?php echo __('Sistema de Gestión de Fichas y Actividades'); ?></h3>
		<p>
			<?php echo __('Ingrese su usuario y contraseña'); ?>
			<!--Please enter your name and password to log in.-->
		</p>
		<?php echo $this->Form->create('Usuario', array('class' => 'form-login')); ?>
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> <?php echo __('Tiene algunos errores. Por favor revíselos.'); ?>
			</div>
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<?php echo $this->Form->input('usua_username', array('div' => false, 'label' => false, 'placeholder' => __('Usuario')) ); ?>
						<i class="fa fa-user"></i>
					</span>
				</div>
				<div class="form-group form-actions">
					<span class="input-icon">
						<?php echo $this->Form->input('usua_password', array('type' => 'password', 'div' => false, 'label' => false, 'placeholder' => __('Contraseña')) ); ?>
						<i class="fa fa-lock"></i>
						<!--
						<a class="forgot" href="#">
							<?php echo ('Olvidé mi contraseña'); ?>
						</a>
						-->
					</span>
				</div>
				<div class="form-actions">
					<!--
					<label for="remember" class="checkbox-inline">
						<input type="checkbox" class="grey remember" id="remember" name="remember">
						<?php echo __('Recordarme'); ?>
					</label>
					-->
					<button type="submit" class="btn btn-bricky pull-right">
						<?php echo __('Ingresar'); ?> <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		<?php echo $this->Form->end(); ?>
	</div>
	<!-- end: LOGIN BOX -->
	<!-- start: FORGOT BOX -->
	<div class="box-forgot">
		<h3>Forget Password?</h3>
		<p>
			Enter your e-mail address below to reset your password.
		</p>
		<form class="form-forgot">
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
			</div>
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="email" class="form-control" name="email" placeholder="Email">
						<i class="fa fa-envelope"></i> </span>
				</div>
				<div class="form-actions">
					<button class="btn btn-light-grey go-back">
						<i class="fa fa-circle-arrow-left"></i> Back
					</button>
					<button type="submit" class="btn btn-bricky pull-right">
						Submit <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: FORGOT BOX -->
	<!-- start: REGISTER BOX -->
	<div class="box-register">
		<h3>Sign Up</h3>
		<p>
			Enter your personal details below:
		</p>
		<form class="form-register">
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
			</div>
			<fieldset>
				<div class="form-group">
					<input type="text" class="form-control" name="full_name" placeholder="Full Name">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="address" placeholder="Address">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="city" placeholder="City">
				</div>
				<div class="form-group">
					<div>
						<label class="radio-inline">
							<input type="radio" class="grey" value="F" name="gender">
							Female
						</label>
						<label class="radio-inline">
							<input type="radio" class="grey" value="M" name="gender">
							Male
						</label>
					</div>
				</div>
				<p>
					Enter your account details below:
				</p>
				<div class="form-group">
					<span class="input-icon">
						<input type="email" class="form-control" name="email" placeholder="Email">
						<i class="fa fa-envelope"></i> </span>
				</div>
				<div class="form-group">
					<span class="input-icon">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						<i class="fa fa-lock"></i> </span>
				</div>
				<div class="form-group">
					<span class="input-icon">
						<input type="password" class="form-control" name="password_again" placeholder="Password Again">
						<i class="fa fa-lock"></i> </span>
				</div>
				<div class="form-group">
					<div>
						<label for="agree" class="checkbox-inline">
							<input type="checkbox" class="grey agree" id="agree" name="agree">
							I agree to the Terms of Service and Privacy Policy
						</label>
					</div>
				</div>
				<div class="form-actions">
					<button class="btn btn-light-grey go-back">
						<i class="fa fa-circle-arrow-left"></i> Back
					</button>
					<button type="submit" class="btn btn-bricky pull-right">
						Submit <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: REGISTER BOX -->
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		2014 &copy; <?php echo __('Fundación de las Familias'); ?>.
	</div>
	<!-- end: COPYRIGHT -->
</div>
		