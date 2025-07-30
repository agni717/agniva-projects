<?php $this->load->view("admin/login_comp/header"); ?>

		<div class="row position-relative">
			<div class="col-md-5 ml-md-2">
				<div class="proclinic-box-shadow">
					<div class="login-heading">
						<img src="images/logo.png" alt="">
						<h3 class="widget-title">The West Bengal Matua Welfare Board Login</h3>
					</div>
					<form class="widget-form" method="POST" action="">
						<?php if(isset($error)) :?>
				        
						        <div id="alert_msg" style="color:red; margin:0 0 10px 0px;">
						            <?php 
							            echo $error;
						            ?>
								</div>
								
						<?php endif; ?>
						<div class="form-row">
							<div class="col-sm-12">
								<div class="input-group">
									<div class="input-group-prepend">
							          <div class="input-group-text"><span class="ti-mobile"></span></div>
							        </div>
									<input type="hidden" id="usetid" name="usetid" autocomplete="off">
									<input type="text" placeholder="Enter Mobile Number" id="username" name="username" class="form-control" autocomplete="off" required="">
									<small class="text-error"><?php echo form_error('username');?></small>
								</div>
							</div>
						</div>
						<div class="form-row otpset" style="display:none;">
							<div class="col-sm-12">
								<div class="input-group">
									<div class="input-group-prepend">
							          <div class="input-group-text"><span class="ti-key"></span></div>
							        </div>
									<input type="text" id="password" name="password" placeholder="OTP" name="pass_confirmation" autocomplete="off" class="form-control">
									<small class="text-error"><?php echo form_error('password');?></small>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-sm-12 text-center">
								<div align="center">
									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>						
						<div class="button-btn-block">
							<button class="btn btn-primary btn-lg btn-block mobset" onclick="gotootpcheck();" type="button">Submit</button>
                            <button class="btn btn-primary btn-lg btn-block logset" style="display:none;" type="submit">Log in</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6">
				<div class="proclinic-box-shadow h-100">
					<!-- <h1 class="text-white">Welcome to Matua Community</h1> -->
					<h1 class="text-white">The West Bengal Matua Welfare Board</h1>
				</div>
			</div>
		</div>
	





 
    
<?php $this->load->view('admin/login_comp/footer'); ?>

<script>
	$(function(){
		//history.go(1); // disable the browser's back button
		//var Backlen=history.length;   
		//history.go(-Backlen);   
		//window.location.href=page url
		
      $('#alert_msg, .text-error').delay(8000).fadeOut();
     
	});

function gotootpcheck(){
	//alert("hi");
	$(".div_roller_total").fadeIn();
	$('.mobset').prop('disabled', true);
	var mobile_no = $('#username').val();
	
	if(mobile_no != ""){
		if(mobile_no.length == 10){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admin_access/get_otp_set"; ?>',
				data:{mobile_no: mobile_no},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						$(".div_roller_total").fadeOut();
						$('.get_success_total').html('OTP send to Your Registered Mobile OR E-Mail - '+ data.adm_msg);
						$('#usetid').val(data.s_msg);
						$('#username').prop('readonly',true);
						//$('#usertype').attr('disabled',true);
						$("#usr_required").attr("disabled", true);
						$(".get_success_total").fadeIn();
						setTimeout(function(){ 
							//$('.get_success_total').fadeOut();
							$('.mobset').hide();
							$(".otpset, .logset").fadeIn();
						}, 2000);
						
					}else{
						$(".div_roller_total").fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						$('.mobset').prop('disabled', false);
					}
					
				}
			});
		}else{
			$(".div_roller_total").fadeOut();
			$('.get_error_total').html('Please Insert 10 Digit Mobile Number');
			$(".get_error_total").fadeIn();
			setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
			$('.mobset').prop('disabled', false);
		}
	}else{
		$(".div_roller_total").fadeOut();
		$('.get_error_total').html('Please Insert Mobile Number');
		$(".get_error_total").fadeIn();
		setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
		$('.mobset').prop('disabled', false);
	}
	
	
}

function reload_capcha_img(){
	//alert("hi");
	var pm = '';
	$.ajax({
		method:'POST',
		url:'<?php echo base_url()."admin_access/get_new_capcha_set"; ?>',
		data:{pm: pm},
		dataType:'JSON',
		success:function(data){
			//alert(data.msg);
			if(data.msg == 1)
			{
				console.log(data);
				//alert(data.cap_set.word);
				//$('#plot_otherinfo').val('');
				//$('.otherplot_view').fadeOut(500);
				$('#capcha_pic').html(data.cap_set.image);
				
			}else{
				$('.captcha').html('Problem to Generate Captcha, Refresh the Page');
				//$('#plot_otherinfo').val('');
				$('.captcha').fadeOut(500);
			}
			
		}
	});
}
</script>
