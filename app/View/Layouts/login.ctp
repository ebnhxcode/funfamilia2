<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.2.3 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title><?php echo __('Fundación de la Familia'); ?></title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="/assets/fonts/style.css">
		<link rel="stylesheet" href="/assets/css/main.css">
		<link rel="stylesheet" href="/assets/css/main-responsive.css">
		<link rel="stylesheet" href="/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
		<link rel="stylesheet" href="/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="/assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="/assets/css/print.css" type="text/css" media="print"/>
		<!--[if IE 7]>
		<link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login example2">
		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</body>
	<!-- end: BODY -->

	<!-- start: MAIN JAVASCRIPTS -->
	<!--[if lt IE 9]>
	<script src="/assets/plugins/respond.min.js"></script>
	<script src="/assets/plugins/excanvas.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<![endif]-->
	<!--[if gte IE 9]><!-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<!--<![endif]-->
	<script src="/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
	<script src="/assets/plugins/blockUI/jquery.blockUI.js"></script>
	<script src="/assets/plugins/iCheck/jquery.icheck.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
	<script src="/assets/plugins/less/less-1.5.0.min.js"></script>
	<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
	<script src="/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
	<script src="/assets/js/main.js"></script>
	<!-- end: MAIN JAVASCRIPTS -->
	<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
	<script src="/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="/assets/js/login.js"></script>
	<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
	<script>
		jQuery(document).ready(function() {
			//Main.init();
			//Login.init();
		});
	</script>
</html>
