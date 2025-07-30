<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header( "Set-Cookie: name=value; httpOnly" );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>WBHRB | Admin Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/ico" href="<?php echo base_url().'images/favicon.ico'; ?>" />
    
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/themify-icons.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/green.css" id="style_theme">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/css/jquery-jvectormap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/datatable/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
     
	<script src="<?php echo base_url(); ?>style/js/jquery-3.4.1.min.js"></script>
  </head>
	<style>
      .col-sm-6.col-md-4.col-lg-3.item { margin-bottom: 10px; }
      .col-sm-6.col-md-4.col-lg-3.item img { border-radius: 0 20px 0 20px; border: 2px solid #0a7037; }

      .navbar-nav li:hover > ul.dropdown-menu {
      display: block;
      }
      .dropdown-submenu {
      position:relative;
      }
      .dropdown-submenu>.dropdown-menu {
      top:0;
      left:94%;
      margin-top:0px;
      }
      /* rotate caret on hover */
      .dropdown-menu > li > a:hover:after {
      text-decoration: underline;
      transform: rotate(-90deg);
      } 
	  ul.dropdown-menu li a { background: transparent; }
   </style>
<script type="text/javascript">
		$(window).on('load', function(){
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
</script> 
  
  <body>
    <div class="se-pre-con"></div>
    <div class="header">
         <div class="top-brand">
            <nav class="navbar navbar-default">
               <div class="navbar-header">
                  <div class="sidebar-header">
                     <div class="row">
                        <div class="col-lg-1"><a href="<?php echo base_url().'admincontrol/dashboard'; ?>"><img src="<?php echo base_url(); ?>images/logo.png" class="logo" alt="logo"></a></div>
                        <div class="col-lg-11 mt-4"><span class="logo_name" style="padding-top:80px;">The West Bengal Matua Welfare Board</span></div>
                     </div>
                  </div>
               </div>
               <ul class="nav justify-content-end">
                  <li class="nav-item">
                     <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                     <span class="ti-user"></span>
                     </a>
                     <div class="dropdown-menu proclinic-box-shadow2 profile animated flipInY">
                        <h5><?php echo $u_details->firstname.' '.$u_details->lastname; ?></h5>
                        <!--<a class="dropdown-item" href="#">
                        <span class="ti-settings"></span> Settings</a>-->
                        <a class="dropdown-item" href="<?php echo site_url('admincontrol/dashboard/profile')?>">
                        <span class="ti-help-alt"></span> Profile</a>
                        <a class="dropdown-item" href="<?php echo site_url('admincontrol/dashboard/logout')?>">
                        <span class="ti-power-off"></span> Logout</a>
                     </div>
                  </li>
               </ul>
            </nav>
         </div>

		 <?php $utype = $this->session->userdata['utype']; ?>

         <div class="menu-nav">

            <nav class="navbar navbar-expand-lg proclinic-bg text-white">

               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="ti-menu text-white"></span>
               </button>		
               		
               <div class="collapse navbar-collapse" id="navbarSupportedContent">

                  <ul class="navbar-nav">

                     <?php 
                     if($utype < 3){ ?>

                        <li class="nav-item dropdown">

                           <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="ti-id-badge"></span> Master Data </a>
                           <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                              <li class="dropdown-submenu">
                                 <a class="dropdown-item dropdown-toggle" href="#">Implementing Agency</a>
                                 <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo base_url('admincontrol/dashboard/add_administrator'); ?>">Implementing Agency Creation</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('admincontrol/dashboard/administrator'); ?>">Implementing Agency List</a></li>
                                 </ul>
                              </li>

                              <!--<li class="dropdown-submenu">
                                 <a class="dropdown-item dropdown-toggle" href="#">Executive Agency</a>
                                 <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="vendor.php">Executive Agency Creation</a></li>
                                    <li><a class="dropdown-item" href="vendor_list.php">Executive Agency Creation List</a></li>
                                 </ul>
                              </li>-->

                              <li class="dropdown-submenu">
                                 <a class="dropdown-item dropdown-toggle" href="#">Scheme</a>
                                 <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo base_url('admincontrol/scheme_set/add_new_scheme'); ?>">New Scheme Creation</a></li>
                                    <li><a class="dropdown-item" href="<?php echo base_url('admincontrol/scheme_set/all_scheme_list'); ?>">Scheme List</a></li>
                                 </ul>
                              </li>

                           </ul>

                        </li>

                        <!-- <li class="nav-item">
                           <a class="nav-link" href="#"><span class="ti-layout-tab"></span>Stock Verification</a>
                           </li> -->

                        <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><span class="ti-write"></span> Requisition Creation </a>
                           <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <li class="dropdown-submenu">
                                 <a class="nav-link" href="<?php echo base_url('admincontrol/requisition/add_new_requisition'); ?>">Requisition Creation</a>
                                 <a class="nav-link" href="<?php echo base_url('admincontrol/requisition/requisition_list'); ?>">Requisition List</a>
                              </li>
                           </ul>                        
                        </li>

                        <li class="nav-item">
                           <a class="nav-link" href="<?php echo base_url('admincontrol/requisition/requisition_report'); ?>"><span class="ti-files"></span>Scheme Report</a>
                        </li>

                        <?php 
                     } ?>


                     <?php 
                     if($utype == 3){ ?>

                        <!-- <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" href="#">District Executive</a>
                           <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="<?php //echo base_url('admincontrol/dashboard/add_district_executive'); ?>">District Executive Creation</a></li>
                              <li><a class="dropdown-item" href="<?php //echo base_url('admincontrol/dashboard/district_executive_list'); ?>">District Executive List</a></li>
                           </ul>
                        </li> -->

                        <li class="nav-item">
                           <a class="nav-link" href="<?php echo base_url('admincontrol/requisition/requisition_list'); ?>"><span class="ti-files"></span>D.M. Requisition Approval List</a>
                        </li>

                        <?php 
                     } ?>

                     <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><span class="ti-credit-card"></span>Installment</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                           <li class="dropdown-submenu">
                              <a class="nav-link" href="<?php //echo base_url('admincontrol/requisition/installment_list'); ?>">Payment Installment</a>
                              <a class="nav-link" href="payment_list.php">Payment List</a>
                           </li>
                        </ul>
                     </li> -->
                     
					      <!-- <li class="nav-item">
                        <a class="nav-link" href="#"><span class="ti-layout-tab"></span>Stock Expiry Info</a>
                        </li>
						   <li class="nav-item">
                        <a class="nav-link" href="Requsition_approval.php"><span class="ti-agenda"></span> Requisition Approval</a>
                     </li>
					      <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="ti-files"></span>D.M. Requisition Approval List</a>
                        <div class="dropdown-menu">
                           <a class="dropdown-item" href="DM_Requsition_approval.php">D.M. Requsition Approval</a>
                           <a class="dropdown-item" href="DM_office_req_approval_List.php">D.M. Requsition Approval List</a>
                        </div>
                     </li> -->

                  </ul>


               </div>
            </nav>
         </div>
    </div>
	
