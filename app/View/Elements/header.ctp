<!-- start: HEADER -->
<div class="navbar navbar-inverse navbar-fixed-top">
	<!-- start: TOP NAVIGATION CONTAINER -->
	<div class="container">
		<div class="navbar-header">
			<!-- start: RESPONSIVE MENU TOGGLER -->
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="clip-list-2"></span>
			</button>
			<!-- end: RESPONSIVE MENU TOGGLER -->
			
			<a class="navbar-brand" href="/">
				<!--CLIP<i class="clip-clip"></i>ONE-->
				<img src="/img/rsz_1funfamilia.png" />
			</a>
		</div>
		<div class="navbar-tools">
			<ul class="nav navbar-right">
				<!-- start: USER DROPDOWN -->
				<li class="dropdown current-user">
					<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
						<img src="/img/rsz_user-icon.png" class="circle-img" alt="">
						<span class="username"><?php echo AuthComponent::user('usua_nombre_completo'); ?></span>
						<i class="clip-chevron-down"></i>
					</a>
					<ul class="dropdown-menu">
						<!--
						<li>
							<?php echo $this->Html->link('<i class="clip-user-2"></i> ' . __('Mi Cuenta'), array('controller' => 'usuarios', 'action' => 'mi_cuenta'), array('escape' => false)); ?>
							</a>
						</li>
						<li>
							<a href="pages_calendar.html">
								<i class="clip-calendar"></i>
								&nbsp;My Calendar
							</a>
						<li>
							<a href="pages_messages.html">
								<i class="clip-bubble-4"></i>
								&nbsp;My Messages (3)
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="utility_lock_screen.html"><i class="clip-locked"></i>
								&nbsp;Lock Screen </a>
						</li>
						-->
						<li>
							<?php echo $this->Html->link('<i class="clip-exit"></i> ' . __('Salir'), array('controller' => 'usuarios', 'action' => 'logout'), array('escape' => false)); ?>
						</li>
					</ul>
				</li>
				<!-- end: USER DROPDOWN -->
			</ul>
			<!-- end: TOP NAVIGATION MENU -->

			<!-- start: TOP NAVIGATION MENU -->
			<ul class="nav navbar-right">
				<!-- start: USER DROPDOWN -->
				<li class="dropdown current-user">
					<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
						<span class="username"><?php echo $this->Session->read('title'); ?></span>
					</a>
					<ul class="dropdown-menu">

					<?php $perfiles = $this->Session->read('perfiles');
						foreach($perfiles as $key => $value){
							if(is_array($value)){
								foreach($value as $key => $val){
									print_r("
									<form action='/usuarios/seleccion_perfil' id='".$key."' method='post' accept-charset='utf-8'>
										<input type='hidden' name='_method' value='POST'>
										<input type='hidden' name='data[PerfilUsuario][peus_id]' value='".$key."'>
									</form>	
									<li>
										<a href='#' onclick='document.getElementById(".$key.").submit();'>".$val."</a>
									</li>");
								}
							}else{
									print_r("
									<form action='/usuarios/seleccion_perfil' id='".$key."' method='post' accept-charset='utf-8'>
										<input type='hidden' name='_method' value='POST'>
										<input type='hidden' name='data[PerfilUsuario][peus_id]' value='".$key."'>
									</form>	
									<li>
										<a href='#' onclick='document.getElementById(".$key.").submit();'>".$value."</a>
									</li>");
							}
						}
					?>
					</ul>
				</li>
				<!-- end: USER DROPDOWN -->
			</ul>
			<script>
				function changePerfil(id) {
				    
				}
				</script>
			<!-- end: TOP NAVIGATION MENU -->










		</div>
	</div>
	<!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->