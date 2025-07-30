<?php $this->load->view('main/component/header')?>

<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style>       
<body class="login_bg">
<div class="container mt-5" >

<div class="col-sm-4 p-0 mt-5">

<div class="box" style="margin-top:180px;">
<div class="col-sm-12 ">
		<div class="col-sm-12 ">
		    <h2 class="text-center">Login</h2>
					  <?php if($this->session->flashdata('success')) { ?>
					  <div id="alert_msg" class="alert bg-success lead"><?php echo $this->session->flashdata('success'); ?></div>
					  <?php $this->session->unset_userdata('success'); }
					  elseif($this->session->flashdata('e_error')) { ?>                
					  <div id="alert_msg" class="alert bg-danger lead"><?php echo $this->session->flashdata('e_error'); ?></div>
					  <?php $this->session->unset_userdata('e_error'); } ?>
			<?php if(isset($error)) :?>
			  <div align="center" style="color:red;">
				  <?php 
					echo $error;
				  ?>
			  </div>
			<?php endif;?>
		    <form class="login-form form-horizontal" method="POST">
  <div class="form-group">
    <label class="text-uppercase">Applied For</label>
   
    <select class="form-control" name="fu_apply" id="fu_apply" autocomplete="off">
      <option value="">---Select---</option>
      <?php foreach($adv_list as $advises){ ?>
		<option value="<?php echo $advises->adv_auto_genno; ?>"><?php echo $advises->adv_no.' | Recruitment For - '.$advises->rm_name.''; ?></option>
	  <?php } ?>
    </select>
	<small class="text-error text-left fu_apply"><?php echo form_error('fu_apply'); ?></small>
  </div>
  <div class="form-group">
    <label class="text-uppercase">Mobile</label>
	<input type="hidden" name="uset_app" id="uset_app" value="" autocomplete="off" />
    <input type="text" class="form-control" id="fu_mobile" placeholder="Enter Mobile No." name="fu_mobile" required="" value="<?php echo set_value('fu_mobile'); ?>" autocomplete="off">
	<small class="text-error fu_mobile"><?php echo form_error('fu_mobile');?></small>
  </div>
	<div class="form-group otpset" style="display:none;">
		<label class="text-uppercase">OTP</label>
		<input type="text" class="form-control" placeholder="OTP" id="otp_sign" name="otp_sign" class="form-control" autocomplete="off" />
		<small class="text-error text-left otp_sign"><?php echo form_error('otp_sign'); ?></small>
	</div>
	<div class="form-group">
		<div class="text-center">
			<div align="center">
				<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
				<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
				<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
			</div>
		</div>
	</div>
	<div class="row">
	<div class="col-sm-8 text-right">
		<a href="<?php echo base_url('main/new_user_signup'); ?>" style="line-height: 32px;">Register Now</a>
	</div>
	<div class="col-sm-4 text-right">
		<button type="button" onclick="gotoclclickbutton();" style="display:none;" class="btn btn-primary logset">Log in</button>
		<button class="btn btn-primary mobset" onclick="gotootpcheck();" type="button">Submit</button>
	</div>
	</div>
</form>
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
		
		var fu_apply = $('#fu_apply option:selected').val();
		var fu_mobile = $('#fu_mobile').val();
		$('.mobset').prop('disabled', true);
		
		if(fu_apply == ""){
			e_error = 1;
			$('.fu_apply').html('Apply For is Required.');
		}else{
			if(!fu_apply.match(alphanumerics)){
				e_error = 1;
				$('.fu_apply').html('Apply For not use special carecters, Check again.');
			}else{
				$('.fu_apply').html('');
			}	
		}
		if(fu_mobile == ""){
			e_error = 1;
			$('.fu_mobile').html('Mobile No. is required.');
		}else{
			if(!fu_mobile.match(onlynumerics)){
				e_error = 1;
				$('.fu_mobile').html('Mobile No. needs only 10 digit.');
			}else if(fu_mobile.length != 10){
				e_error = 1;
				$('.fu_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.fu_mobile').html('');
			}
		}
		/*if(fu_mobile == ""){
			e_error = 1;
			$('.fu_mobile').html('Email-ID is Required.');
		}else{
			if(!emailpattern.test(fu_mobile)){
				e_error = 1;
				$('.fu_mobile').html('Email-ID not proper format, Check again.');
			}else{
				$('.fu_mobile').html('');
			}	
		}*/
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
				url:'<?php echo base_url()."main/get_otp_forlogin_candidates"; ?>',
				data:{fu_apply: fu_apply, fu_mobile:fu_mobile},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('OTP send to Your Registered Email-ID or SMS');
						//$('.get_success_total').html('OTP send to Your Registered Email-ID. OTP - ' + data.mobsms);
						$('#uset_app').val(data.s_msg);
						$('#fu_name, #fu_email, #fu_mobile').prop('readonly',true);
						$('#fu_apply').attr("disabled", true);
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
		
		var fu_apply = $('#fu_apply option:selected').val();
		var fu_mobile = $('#fu_mobile').val();
		var otp_sign = $('#otp_sign').val();
		var uset_app = $('#uset_app').val();
		$('.logset').prop('disabled', true);
		
		if(uset_app == ""){
			e_error = 1;
			error_message = error_message + 'Data missing for Login, Refreash the Page.';
		}
		if(fu_apply == ""){
			e_error = 1;
			$('.fu_apply').html('Apply For is Required.');
		}else{
			if(!fu_apply.match(alphanumerics)){
				e_error = 1;
				$('.fu_apply').html('Apply For not use special carecters, Check again.');
			}else{
				$('.fu_apply').html('');
			}	
		}
		/*if(fu_mobile == ""){
			e_error = 1;
			$('.fu_mobile').html('Email-ID is Required.');
		}else{
			if(!emailpattern.test(fu_mobile)){
				e_error = 1;
				$('.fu_mobile').html('Email-ID not proper format, Check again.');
			}else{
				$('.fu_mobile').html('');
			}	
		}*/
		if(fu_mobile == ""){
			e_error = 1;
			$('.fu_mobile').html('Mobile No. is required.');
		}else{
			if(!fu_mobile.match(onlynumerics)){
				e_error = 1;
				$('.fu_mobile').html('Mobile No. needs only 10 digit.');
			}else if(fu_mobile.length != 10){
				e_error = 1;
				$('.fu_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.fu_mobile').html('');
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
				url:'<?php echo base_url()."main/otp_check_frontend_candidates_login"; ?>',
				data:{fu_apply: fu_apply, fu_mobile:fu_mobile, otp_sign:otp_sign, uset_app:uset_app},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Login Process Done Successfully.');
						$('input, select').prop('');
						$(".get_success_total").fadeIn();
						setTimeout(function(){
							window.location.replace("<?php echo site_url('member')?>");
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