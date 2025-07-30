<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WB - Health Recruitment Board</title>
		<!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url() ?>images/favicon.ico">
        
        <link href="https://fonts.googleapis.com/css?family=Playball&display=swap" rel="stylesheet">
		<!-- Bootstrap CSS File -->
		<link href="<?php echo base_url(); ?>frontend/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>frontend/css/style.css" rel="stylesheet" type="text/css" />
		<!-- Libraries CSS Files -->
		<link href="<?php echo base_url(); ?>frontend/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>

<body>
<?php //$this->load->view('main/component/login_header') ?>
<div class="container-fluid">
			<div class="row">
<div class="col-sm-12 text-center">
					<?php if($this->session->flashdata('success')) { ?>
					  <div id="alert_msg" class="alert alert-success"><h1><?php echo $this->session->flashdata('success'); ?></h1></div>
					  <div><a href="<?php base_url('login'); ?>" class="btn btn-primary btn-lg">Login</a></div>
				    <?php $this->session->unset_userdata('success'); }
				    elseif($this->session->flashdata('e_error')) { ?>                
			      <div id="alert_msg" class="alert alert-danger"><h1><?php echo $this->session->flashdata('e_error'); ?></h1></div>
				  	<div><a href="<?php base_url('login'); ?>" class="btn btn-primary btn-lg">Login</a></div>
				    <?php $this->session->unset_userdata('e_error'); } ?>
</div>
			</div></div>
</body>
<?php //$this->load->view('main/component/footer'); ?>

<!-- Javascript -->
		<script src="<?php echo base_url(); ?>js/jquery-3.4.1.min.js"></script>
		<script src="<?php echo base_url(); ?>frontend/js/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>frontend/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
    	//$("#frm1").submit();
		//$('.alert-error, .text-error').delay(8000).fadeOut();
		//$('[data-toggle="tooltip"]').tooltip();
	});
</script>

</html>