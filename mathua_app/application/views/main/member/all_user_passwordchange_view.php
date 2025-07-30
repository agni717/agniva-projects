<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<style>
.alert-error, .text-error, .redclass {
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
				<h1 class="panel-title">Change User Password</h1>
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
			<div class="col-md-12 text-center" style="font-size:20px;">	
			Name : - <?php echo $user_detail->fuser_name; ?><br/>
			Email : - <?php echo $user_detail->fuser_username; ?><br/><br/>
			</div>	
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/user_password_change/".$user_detail->fuser_id; ?>" method="POST" enctype="multipart/form-data">
		  	<div class="form-group">
              <label class="col-md-5 control-label">New Password <font class="redclass">*</font></label>
              <div class="col-md-5">
                <input type="password" name="n_pass" id="n_pass" placeholder="New Password" class="form-control" autocomplete="off">
				<small class="text-error text-left n_pass"><?php echo form_error('n_pass'); ?></small>
			  </div>
			</div>
			<div class="form-group">
              <label class="col-md-5 control-label">Confirm Password <font class="redclass">*</font></label>
              <div class="col-md-5">
			  <input type="password" name="re_pass" id="re_pass" placeholder="Confirm Password" class="form-control" autocomplete="off">
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
			  <a href="<?php echo base_url()."member/all_activeuser_list"; ?>" class="btn btn-lg btn-danger">cancel</a>
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
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>

<script type="text/javascript">
    $(function(){
		//$( "#ap_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();
	});

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		
    	var n_pass = $('#n_pass').val();
    	var re_pass = $('#re_pass').val();
		
		if(n_pass == ""){
			e_error = 1;
			$('.n_pass').html('New Password is Required.');
		}else{
			if(!n_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.n_pass').html('New Password not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.n_pass').html('');
			}	
		}

		if(re_pass == ""){
			e_error = 1;
			$('.re_pass').html('Confirm-Password is Required.');
		}else{
			if(!re_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.re_pass').html('Confirm-Password not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.re_pass').html('');
			}	
		}

		if(n_pass != re_pass){
			e_error = 1;
			error_message = error_message + '<br/>New Password not matched with Confirm Password, Check again.';
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