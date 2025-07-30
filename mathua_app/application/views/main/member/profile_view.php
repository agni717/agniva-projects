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
				<h1 class="panel-title">Candidate Profile</h1>
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
       
					<div class="panel-body"><?php //print_r($fuser_detailset); 
					//$usertype = $this->session->userdata('member_utype'); ?>
					<table class="table table-bordered table-striped" style="font-size:16px;">
						<tbody>
							<tr>
								<td><strong>Full Name :</strong></td>
								<td colspan="2"><?php echo $fuser_detailset->f_full_name; ?></td>
							</tr>
							<tr>
								<td><strong>Mobile :</strong></td>
								<td><?php echo $fuser_detailset->f_mobile; ?></td>
								<td><a href="<?php echo base_url()."member/change_mobile_modfication"; ?>" class="btn btn-warning">Change Mobile No.</a></td>
							</tr>
							<tr>
								<td><strong>Email :</strong></td>
								<td><?php echo $fuser_detailset->f_email; ?></td>
								<td><a href="<?php echo base_url()."member/change_email_modfication"; ?>" class="btn btn-warning">Change Email-ID</a></td>
							</tr>
						</tbody>
					</table>
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