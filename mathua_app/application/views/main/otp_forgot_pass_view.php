<?php $this->load->view('main/component/header')?>

 <style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style>      

        <!-- Presentation -->
        <div class="presentation-container">
        	  <div class="container">
	            		
	            <div class="row">
	            	<div class="col-sm-12 text-center">
						<h1 class="header_search"> Forgot Password - OTP</h1><br/>
						<?php if(isset($error)) :?>
						  <div align="center" style="color:red; margin:0 0 10px 20px;">
							  <?php 
								echo $error;
							  ?>
						  </div>
						<?php endif;?>
						
						<?php if($this->session->flashdata('success')) { ?>
							<div id="alert_msg" class="alert bg-success lead"><?php echo $this->session->flashdata('success'); ?></div>
					  <?php $this->session->unset_userdata('success'); }
					  elseif($this->session->flashdata('e_error')) { ?>                
					  <div id="alert_msg" class="alert bg-danger lead"><?php echo $this->session->flashdata('e_error'); ?></div>
					  <?php $this->session->unset_userdata('e_error'); } ?>
				</div>
				</div>
				<div class="row justify-content-center">
				<div class="col-sm-4">
				<form class="form-horizontal" method="POST">
					<div class="form-group">
					  <label class="control-label col-sm-12" for="user_mobile">Registered Mobile No:</label>
					  <div class="col-sm-12">
						<input type="text" class="form-control" id="user_mobile" placeholder="Enter Registered Mobile No." name="user_mobile" disabled value="<?php echo $this->session->userdata('fusr_mob'); ?>" autocomplete="off">
						<small class="text-error"><?php echo form_error('user_mobile');?></small>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-12" for="user_mobile">OTP:</label>
					  <div class="col-sm-12">
						<input type="text" class="form-control" id="user_otp" placeholder="Enter OTP" name="user_otp" required="" autocomplete="off">
						<small class="text-error"><?php echo form_error('user_otp');?></small>
					  </div>
					  <?php if($this->session->userdata('fusr_resend') == 1){ ?><div class="col-sm-12 mt-1"><a href="<?php echo base_url('main/resend_otp_for_forgotpass'); ?>"><img src="<?php echo base_url('images/reload.png'); ?>" /> Resend OTP</a></div><?php } ?>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12 text-center">
						<button type="submit" class="btn btn-lg btn-info">Submit</button>
					  </div>
					  <div class="col-sm-12 mt-3 text-center">
						<a href="<?php echo base_url('main/backto_login'); ?>" class="btn btn-outline-secondary">Back to Login</a>
					  </div>
					</div>
				</form>
      

      </div>

	            </div>
	            
	          
        	</div>
        </div>

<?php $this->load->view('main/component/footer'); ?>