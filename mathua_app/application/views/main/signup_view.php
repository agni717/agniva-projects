<?php $this->load->view('main/component/header')?>
<style>
.alert-error, .text-error, .redclass{
    	color: red !important;
	}
</style>        

<body class="bg">
<div class="container mt-5" >

<div class="row p-0 mt-5">
<div class="col-sm-7 p-0 mt-5">
	<p style="color: black;font-weight:bold;font-size: 1.2em;"><img src="<?php echo base_url('images/blinking_red_star.gif') ?>" />Attention: All candidates who haven't completed are requested to complete the application. Candidates except valid SC/ ST / PWD candidates are required to complete payment of fees before completion of the application process, otherwise candidature will be rejected. <img src="<?php echo base_url('images/blinking_red_star.gif') ?>" /></p>
	<p style="color: black;font-weight:bold;font-size: 1.2em;"><img src="<?php echo base_url('images/blinking_red_star.gif') ?>" /> Attention to all the candidates: Registration Certificate, where applicable, must be scanned with marksheet and upload in the relevant section. Without Registration Certificate, wherever applicable, candidature is liable to be rejected.<br/>
	Those who have already applied without Registration Certificate will be allowed to attach scanned copy of Registration Certificate after logging in during 10th to 18th November,21(1pm). <img src="<?php echo base_url('images/blinking_red_star.gif') ?>" /></p>
</div>
<div class="col-sm-5 mt-5" style="margin-top:50px;">
<div class="box">
<div class="row ">
		<div class="col ">
		    <h2 class="text-center">Registration</h2>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
		    <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."main/new_user_signup"; ?>" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1" class="text-uppercase">Apply For</label>
   
    <select class="form-control" name="fu_apply" id="fu_apply" autocomplete="off">
      <option value="">---Select---</option>
      <?php foreach($adv_list as $advises){ ?>
		<option value="<?php echo $advises->adv_auto_genno; ?>"><?php echo $advises->adv_no.' | Recrutment For - '.$advises->rm_name.''; ?></option>
	  <?php } ?>
    </select>
	<small class="text-error text-left fu_apply"><?php echo form_error('fu_apply'); ?></small>
  </div>
	<div class="form-group">
		<label class="text-uppercase">Full Name</label>
		<input type="hidden" name="uset_app" id="uset_app" value="" autocomplete="off" />
		<input type="text" name="fu_name" id="fu_name" placeholder="Full Name" class="form-control" value="<?php echo set_value('fu_name'); ?>" autocomplete="off" />
		<small class="text-error text-left fu_name"><?php echo form_error('fu_name'); ?></small>
	</div>
	<div class="form-group">
		<label class="text-uppercase">Mobile No</label>
		<input type="text" name="fu_mobile" id="fu_mobile" placeholder="Mobile Number" class="form-control" value="<?php echo set_value('fu_mobile'); ?>" autocomplete="off" />
		<small class="text-error text-left fu_mobile"><?php echo form_error('fu_mobile'); ?></small>
	</div>
  
	<div class="form-group">
		<label class="text-uppercase">Email</label>
		<input type="text" name="fu_email" id="fu_email" placeholder="Email" class="form-control" value="<?php echo set_value('fu_email'); ?>" autocomplete="off" />
		<small class="text-error text-left fu_email"><?php echo form_error('fu_email'); ?></small>
	</div>
	<div class="authsetview" style="display:none;">
	<h1>Auth Code: <span class="authcodeset"></span></h1>
	</div>
    <div class="form-group otpset" style="display:none;">
		<label class="text-uppercase">Authenticate Code</label>
		<input type="text" class="form-control" placeholder="Authenticate Code" id="otp_sign" name="otp_sign" class="form-control" autocomplete="off" />
		<small class="text-error text-left otp_sign"><?php echo form_error('otp_sign'); ?></small>
		<br/>
		<label class="text-uppercase">Email OTP</label>
		<input type="text" class="form-control" placeholder="Email OTP" id="emailotp_sign" name="emailotp_sign" class="form-control" autocomplete="off" />
		<small class="text-error text-left emailotp_sign"><?php echo form_error('emailotp_sign'); ?></small>
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
		<a href="<?php echo base_url('login'); ?>" style="line-height: 45px;">Back To Login</a>
	</div>	
    <div class="col-sm-4 text-right">
    <button type="button" onclick="gotoclclickbutton();" style="display:none;" class="btn btn-lg btn-primary logset">Sign Up</button>
    <button class="btn btn-lg btn-primary mobset" onclick="gotootpcheck();" type="button">Submit</button>
     <!--<button class="btn btn-primary logset" style="display:none;" type="submit">Log in</button>-->
	</div>
	</div>
  
</form>
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
		
		var fu_apply = $('#fu_apply option:selected').val();
		var fu_name = $('#fu_name').val();
		var fu_email = $('#fu_email').val();
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
		if(fu_name == ""){
			e_error = 1;
			$('.fu_name').html('Full Name is Required.');
		}else{
			if(!fu_name.match(alphanumerics_no)){
				e_error = 1;
				$('.fu_name').html('Full Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.fu_name').html('');
			}	
		}
		if(fu_email == ""){
			e_error = 1;
			$('.fu_email').html('Email-ID is Required.');
		}else{
			if(!emailpattern.test(fu_email)){
				e_error = 1;
				$('.fu_email').html('Email-ID not proper format, Check again.');
			}else{
				$('.fu_email').html('');
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
			var conf_answer = confirm("Are you sure? all data will access for Process Further, and it will not changeable.")
			if(conf_answer){
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."main/get_otp_frontend_candidates"; ?>',
					data:{fu_apply: fu_apply, fu_name:fu_name, fu_email:fu_email, fu_mobile:fu_mobile},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							$('.div_roller_total').fadeOut();
							$(".authcodeset").html(data.mobsms);
							$(".authsetview").fadeIn();
							$('.get_success_total').html('OTP send to Your Registered Email or SMS And an Authenticate Code Appeared');
							// E-OTP - ' + data.mailsms + ', M-OTP - ' + data.mobsms
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
			}else{
				$('.div_roller_total').fadeOut();
				$('.mobset').prop('disabled', false);
			}
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
		var fu_name = $('#fu_name').val();
		var fu_email = $('#fu_email').val();
		var fu_mobile = $('#fu_mobile').val();
		var emailotp_sign = $('#emailotp_sign').val();
		var otp_sign = $('#otp_sign').val();
		var uset_app = $('#uset_app').val();
		$('.logset').prop('disabled', true);
		
		if(uset_app == ""){
			e_error = 1;
			error_message = error_message + 'Data missing for Registration, Refreash the Page.';
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
		if(fu_name == ""){
			e_error = 1;
			$('.fu_name').html('Full Name is Required.');
		}else{
			if(!fu_name.match(alphanumerics_no)){
				e_error = 1;
				$('.fu_name').html('Full Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.fu_name').html('');
			}	
		}
		if(fu_email == ""){
			e_error = 1;
			$('.fu_email').html('Email-ID is Required.');
		}else{
			if(!emailpattern.test(fu_email)){
				e_error = 1;
				$('.fu_email').html('Email-ID not proper format, Check again.');
			}else{
				$('.fu_email').html('');
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
		if(emailotp_sign == ""){
			e_error = 1;
			$('.emailotp_sign').html('Email OTP is required.');
		}else{
			if(!emailotp_sign.match(onlynumerics)){
				e_error = 1;
				$('.emailotp_sign').html('Email OTP needs only Numeric digits.');
			}else{
				$('.emailotp_sign').html('');
			}
		}
		if(otp_sign == ""){
			e_error = 1;
			$('.otp_sign').html('Authenticate Code is required.');
		}else{
			if(!otp_sign.match(onlynumerics)){
				e_error = 1;
				$('.otp_sign').html('Authenticate Code needs only Numeric digits.');
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
				url:'<?php echo base_url()."main/otp_check_frontend_candidates_signup"; ?>',
				data:{fu_apply: fu_apply, fu_name:fu_name, fu_email:fu_email, fu_mobile:fu_mobile, emailotp_sign:emailotp_sign, otp_sign:otp_sign, uset_app:uset_app},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('SignUp Process Done Successfully.');
						$('input, select').prop('');
						$(".get_success_total").fadeIn();
						setTimeout(function(){
							window.location.replace("<?php echo site_url('member')?>");
						}, 3000);
						
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