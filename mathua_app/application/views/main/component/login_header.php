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
				<div class="col-sm-2">
					<img src="<?php echo base_url(); ?>frontend/img/WBHRB_Logo.png">
				</div>
				<div class="col-sm-10 text-right mt-3" style="color:#fff;">
				<a style="color:white" href="<?php echo base_url().'member/dashboard'; ?>">Home</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				<?php if($detail_result->cr_approval == "Rejected" && $get_reject_access == TRUE){ ?>
					<a style="color:white" href="<?php echo base_url().'revised_data/form_fillup'; ?>">Resubmit Form</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				<?php } ?>
				<?php //if($detail_result->cr_approval != "NotChecked"){ ?>
					<a style="color:white" href="<?php echo base_url().'member/check_candidate_status'; ?>">Status Report</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				<?php //} ?>
				<?php if($fuser_detailset->fu_cancel_stat != 1 && $adv_detail->adv_reg_certificate == "Yes"){ ?>
				<a style="color:white" href="<?php echo base_url().'member/uploadregistration_certificate_set'; ?>">Upload Certificate</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
				<?php } ?>
				
				<?php //if($fuser_detailset->fu_cancel_stat != 1 && $fuser_detailset->fu_payment_stat == 1){
					if($fuser_detailset->fu_cancel_stat != 1){ ?>
					<a style="color:white" href="<?php echo base_url().'member/profile'; ?>">Welcome, <strong><?php echo $fuser_detailset->f_full_name; ?></strong></a>
				<?php }else{ ?>
					Welcome, <strong><?php echo $fuser_detailset->f_full_name; ?></strong>
				<?php } ?>
				&nbsp;&nbsp;&nbsp;<a class="btn btn-info" href="<?php echo base_url().'member/logout'; ?>" role="button">Logout</a></div>
			</div>
		</div>
	</div>
