<?php 
header( "Set-Cookie: name=value; httpOnly" );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="SHORTCUT ICON" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon" /> 

        <title>Health Recruitment Board - Portal</title>
		
		<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/themify-icons.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/green.css" id="style_theme">
		<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/responsive.css">
		<script src="<?php echo base_url(); ?>style/js/modernizr.min.js"></script>
		<script src="<?php echo base_url(); ?>style/js/jquery-3.4.1.min.js"></script>
    </head>
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url("images/loading.gif") center no-repeat #fff;
}
</style>
<script type="text/javascript">
		$(window).on('load', function(){
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
</script> 
    <body class="auth-bg vh-100">
		<div class="se-pre-con"></div>
        <div class="circle1"></div>
		<div class="circle2"></div>
		<div class="container v-middle">
		