<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="es" class="no-js">
	<!--<![endif]-->
	<head>
		<title><?php echo __('Fundación de la Familia'); ?></title>
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />

		<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/assets/fonts/style.css">
		<link rel="stylesheet" href="/assets/css/main.css">
		<link rel="stylesheet" href="/assets/css/main-responsive.css">
		<link rel="stylesheet" href="/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="/assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="/assets/css/print.css" type="text/css" media="print"/>
		<link rel="stylesheet" href="/assets/plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="/assets/plugins/typeaheadjs/lib/typeahead.js-bootstrap.css">
		<link rel="stylesheet" href="/css/style.css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<link rel="shortcut icon" href="/favicon.ico" />

		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
			<script src="/assets/plugins/respond.min.js"></script>
			<script src="/assets/plugins/excanvas.min.js"></script>
			<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="/js/jquery.min.js"></script>
		<!--<![endif]-->
		<script src="/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
		<script src="/assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="/assets/js/main.js"></script>
		<script src="/assets/js/form-elements.js"></script>
		<script src="/assets/plugins/typeaheadjs/lib/typeahead.js"></script>
		<script src="/js/typeahead.bundle.js"></script>
		<script src="/js/handlebars-v2.0.0.js"></script>
		<script src="/js/global.js"></script>
		<script src="/js/jquery.number.min.js"></script>
		<script src="/assets/plugins/moment/moment.min.js"></script>
		<script src="/assets/plugins/flot/jquery.flot.min.js"></script>
		<script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
		<script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
		<script src="/assets/plugins/flot/jquery.flot.pie.min.js"></script>
		<script src="/assets/plugins/flot//jquery.flot.orderBars.js"></script>
		
		<!--
		<script src="/assets/plugins/moment/lib/moment.min.js"></script>
		-->

		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();

				// todo input en mayuscula
				$('input').keyup(function(){
   					this.value = this.value.toUpperCase();
				});
			});
		</script>
	</head>
	<body>
		
		<!-- start: MAIN CONTAINER -->
		<div class="main-container">
			<?php echo $this->element('header'); ?>
			<?php echo $this->element('menu'); ?>

			<!-- start: PAGE -->
			<div class="main-content">
				<!-- start: PANEL CONFIGURATION MODAL FORM -->
				<div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
									&times;
								</button>
								<h4 class="modal-title">Panel Configuration</h4>
							</div>
							<div class="modal-body">
								Here will be a configuration form
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-primary">
									Save changes
								</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- end: SPANEL CONFIGURATION MODAL FORM -->
				<div class="container">

					<div class="row">
						<div class="col-sm-12">
							<?php echo $this->fetch('content'); ?>

							<?php
								//echo $this->element('style_selector');
							?>
							
						</div>
					</div>
				</div>
			</div>
			<!-- end: PAGE -->
		</div>
		<!-- end: MAIN CONTAINER -->
		
		<?php echo $this->element('footer'); ?>
	</body>
	<!-- end: BODY -->
</html>