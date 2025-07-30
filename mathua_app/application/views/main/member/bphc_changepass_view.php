<?php $this->load->view('main/component/header')?>
<style>
.alert-error, .text-error, .redclass,.alert-error h3, .alert-error h5  {
    	color: red !important;
	}
</style> 
        <!-- Presentation -->
        <div class="presentation-container">
        	<div class="container">
	            		
	            <div class="row">
					
					<?php $this->load->view('main/member/left_menu')?>
					<div class="col-sm-10">
					<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title">Change Password</h1>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/change_password"; ?>" method="POST" enctype="multipart/form-data">
		  	<div class="form-group">
              <label class="col-md-4 control-label">Current Password <font class="redclass">*</font></label>
              <div class="col-md-6">
                <input type="password" name="c_pass" id="c_pass" placeholder="Curent Password" class="form-control" autocomplete="off">
				<small class="text-error text-left c_pass"><?php echo form_error('c_pass'); ?></small>
              </div>
			</div>
			<div class="form-group">
			  <label class="col-md-4 control-label">New Password <font class="redclass">*</font></label>
              <div class="col-md-6">
                <input type="password" name="n_pass" id="n_pass" placeholder="New Password" class="form-control" autocomplete="off">
				<small class="text-error text-left n_pass"><?php echo form_error('n_pass'); ?></small>
              </div>
            </div>
            <div class="form-group">
			  <label class="col-md-4 control-label">Re-Enter Password <font class="redclass">*</font></label>
              <div class="col-md-6">
                <input type="password" name="re_pass" id="re_pass" placeholder="Re-Enter Password" class="form-control" autocomplete="off">
				<small class="text-error text-left re_pass"><?php echo form_error('re_pass'); ?></small>
              </div>
            </div>
            
			<div class="form-group">
				<div  class="col-sm-12 text-center">
					<div align="center">
						<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
            <div class="form-group">
              <div class="col-md-12 text-center">
			  <button type="button" onclick="gotoclclickbutton();" class="btn btn-lg btn-primary">Submit</button>
			  <a href="<?php echo base_url()."member/profile"; ?>" class="btn btn-lg btn-danger">cancel</a>
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

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphanumerics_no = /^[A-Za-z0-9_!@#$%&:.,\-]+$/;
		
    	var c_pass = $('#c_pass').val();
    	var n_pass = $('#n_pass').val();
    	var re_pass = $('#re_pass').val();
		
		if(c_pass == ""){
			e_error = 1;
			$('.c_pass').html('Current Password is Required.');
		}else{
			if(!c_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.c_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.c_pass').html('');
			}	
		}
		if(n_pass == ""){
			e_error = 1;
			$('.n_pass').html('New Password is Required.');
		}else{
			if(!n_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.n_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.n_pass').html('');
			}	
		}
		if(re_pass == ""){
			e_error = 1;
			$('.re_pass').html('Re-Enter Password is Required.');
		}else{
			if(!re_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.re_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.re_pass').html('');
			}	
		}

		if(n_pass != re_pass){
			e_error = 1;
			error_message = error_message + '<br/>New Password and Re-Password not Matched, Check Again.';
		}
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(newhash);
			//alert(rehash);
			$("#myForm").submit();
		}

  	}

</script>