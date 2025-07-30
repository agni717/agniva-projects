<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WB - Health Recruitment Board</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url("images/x-icon.png") ?>" type="image/x-icon" />
        
        <link href="https://fonts.googleapis.com/css?family=Playball&display=swap" rel="stylesheet">
		<!-- Bootstrap CSS File -->
		<link href="<?php echo base_url(); ?>frontend/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>frontend/css/style.css" rel="stylesheet" type="text/css" />
		<!-- Libraries CSS Files -->
		<link href="<?php echo base_url(); ?>frontend/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>frontend/css/jquery-steps.css">
</head>

<body>
	<div class="header">

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<img src="<?php echo base_url(); ?>frontend/img/WBHRB_Logo.png">
				</div>
        <div class="col-sm-9 text-left mt-3" style="font-size: 35px;color: #fff;font-weight: bold;word-spacing: 5px;">
				  WEST BENGAL HEALTH RECRUITMENT BOARD
        </div>
			</div>
		</div>
	</div>

<style>
	.alert-error,
	.text-error,
	.redclass {

		color: red !important;

	}

</style>


<div class="mt-5 container_area">
  <div class="text-center"><h2><?php echo $fuser_detailset; ?></h2>
  </div> 
</div>
<?php $this->load->view('main/component/footer'); ?>

<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
		$('.alert-error, .text-error').delay(8000).fadeOut();
		//$('[data-toggle="tooltip"]').tooltip();
	});
</script>
