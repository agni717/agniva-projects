<?php $this->load->view('main/component/login_header') ?>
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style> 
        <!-- Presentation -->
        <div class="presentation-container">
        	<div class="container">
	            		
	            <div class="row">
					
					
				<div class="col-sm-12">
					<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title">Modify Email-ID</h1>
				<?php if($this->session->flashdata('success')) { ?>
    			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    		    <?php $this->session->unset_userdata('success'); }
    		    	elseif($this->session->flashdata('e_error')) { ?>                
    	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
    		    <?php $this->session->unset_userdata('e_error'); } ?>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
					<div class="panel-body">
						<div class="row mt-5 justify-content-center">
							<div class="col-sm-4">
								<div class="form-group">
								<label>Current Email-ID</label>
								<input type="hidden" name="uset_app" id="uset_app" value="" autocomplete="off" />
								<input type="text" class="form-control" name="oldmobile" id="oldmobile" />
								<small class="text-error oldmobile"><?php echo form_error('oldmobile');?></small>
								</div>
								
							</div>
							<div class="col-sm-4">
								<div class="form-group">
								<label>New Email-ID</label>
								<input type="text" class="form-control" name="newmobile" id="newmobile" />
								<small class="text-error newmobile"><?php echo form_error('newmobile');?></small>
								</div>
							</div>
						</div>
						<div class="row justify-content-center otpset" style="display:none;">
							<div class="col-sm-4">
								<div class="form-group">
								<label>OTP</label>
								<input type="text" class="form-control" name="otp_sign" id="otp_sign" />
								<small class="text-error otp_sign"><?php echo form_error('otp_sign');?></small>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="text-center">
								<div align="center">
									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<button type="button" onclick="gotoclclickbutton();" style="display:none;" class="btn btn-primary logset">Update</button>
							<button class="btn btn-primary mobset" onclick="gotootpcheck();" type="button">Submit</button>
						</div>
					</div>
					</div>
	            </div>
	            
	          
        	</div>
        </div>

<?php $this->load->view('main/component/footer'); ?>
<script type="text/javascript">
    $(function(){
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

	});

	function gotootpcheck(){
		//alert("hi");exit();
		$('.div_roller_total').fadeIn();
		var e_error = 0;
		var error_message = '';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
		var oldmobile = $('#oldmobile').val();
		var newmobile = $('#newmobile').val();
		$('.mobset').prop('disabled', true);
		
		if(oldmobile == ""){
			e_error = 1;
			$('.oldmobile').html('Current Email-ID is Required.');
		}else{
			if(!emailpattern.test(oldmobile)){
				e_error = 1;
				$('.oldmobile').html('Current Email-ID not proper format, Check again.');
			}else{
				$('.oldmobile').html('');
			}	
		}

		if(newmobile == ""){
			e_error = 1;
			$('.newmobile').html('New Email-ID is Required.');
		}else{
			if(!emailpattern.test(newmobile)){
				e_error = 1;
				$('.newmobile').html('New Email-ID not proper format, Check again.');
			}else{
				$('.newmobile').html('');
			}	
		}
		
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			if(error_message != ""){
				$('.get_error_total').html(error_message);
				$(".get_error_total").fadeIn();
			}
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			$('.mobset').prop('disabled', false);
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, 5000);
		}else{
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/get_otp_foremail_change_candidates"; ?>',
				data:{oldmobile: oldmobile, newmobile: newmobile},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('OTP send to Your New Email-ID');
						//$('.get_success_total').html('OTP send to Your Registered Email-ID. OTP - ' + data.mobsms);
						$('#uset_app').val(data.s_msg);
						$('#oldmobile, #newmobile').prop('readonly',true);
						$(".get_success_total").fadeIn();
						setTimeout(function(){ 
							//$('.get_success_total').fadeOut();
							$('.mobset').hide();
							$(".otpset, .logset").fadeIn();
						}, 3000);
						
					}else{
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						$('.mobset').prop('disabled', false);
					}
					
				}
			});
		}
	}

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var e_error = 0;
		var error_message = '';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
		var oldmobile = $('#oldmobile').val();
		var newmobile = $('#newmobile').val();
		var otp_sign = $('#otp_sign').val();
		var uset_app = $('#uset_app').val();
		$('.logset').prop('disabled', true);
		
		if(uset_app == ""){
			e_error = 1;
			error_message = error_message + 'Data missing for Modification, Try Again.';
		}

		if(oldmobile == ""){
			e_error = 1;
			$('.oldmobile').html('Current Email-ID is Required.');
		}else{
			if(!emailpattern.test(oldmobile)){
				e_error = 1;
				$('.oldmobile').html('Current Email-ID not proper format, Check again.');
			}else{
				$('.oldmobile').html('');
			}	
		}

		if(newmobile == ""){
			e_error = 1;
			$('.newmobile').html('New Email-ID is Required.');
		}else{
			if(!emailpattern.test(newmobile)){
				e_error = 1;
				$('.newmobile').html('New Email-ID not proper format, Check again.');
			}else{
				$('.newmobile').html('');
			}	
		}
		
		if(otp_sign == ""){
			e_error = 1;
			$('.otp_sign').html('OTP is required.');
		}else{
			if(!otp_sign.match(onlynumerics)){
				e_error = 1;
				$('.otp_sign').html('OTP needs only Numeric digits.');
			}else{
				$('.otp_sign').html('');
			}
		}
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			if(error_message != ""){
				$('.get_error_total').html(error_message);
				$(".get_error_total").fadeIn();
			}
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			$('.logset').prop('disabled', false);
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, 5000);
		}else{
			//alert(newhash);
			//alert(rehash);
			//$("#myForm").submit();
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/email_modifcation_candidates"; ?>',
				data:{newmobile: newmobile, oldmobile:oldmobile, otp_sign:otp_sign, uset_app:uset_app},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Email-ID is Updated Successfully.');
						$('input').prop('');
						$(".get_success_total").fadeIn();
						setTimeout(function(){
							window.location.replace("<?php echo site_url('member/profile')?>");
						}, 2000);
						
					}else{
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						$('.logset').prop('disabled', false);
					}
					
				}
			});
		}

  	}
</script>