<?php $this->load->view('main/component/header')?>
<style>
.alert-error, .text-error, .redclass,.alert-error h3, .alert-error h5  {
    	color: red !important;
	}
</style>   
        <!-- Presentation -->

  	<div class="container">
    	<div class="row">
	        <div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title text-center mb-5">Event Status</h1>
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
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."event/status_details"; ?>" method="POST" enctype="multipart/form-data">
		  <div class="form-row justify-content-center">
            <div class="form-group col-sm-4 text-center">
				<label class="control-label">Event Number <font class="redclass">*</font></label>
                <input type="text" name="ev_no" id="ev_no" placeholder="Event Number" class="form-control" value="<?php echo set_value('ev_no'); ?>" autocomplete="off">
				<small class="text-error text-left ev_no"><?php echo form_error('ev_no'); ?></small>
            </div>
			
            <div class="form-group col-sm-12">
				<div class="text-center">
					<div align="center">
						<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
            <div class="form-group col-md-12">
              <div class="text-center">
			  <button type="button" onclick="gotoclclickbutton();" class="btn btn-lg btn-primary">Submit</button>
			  <a href="<?php echo base_url('main/home'); ?>" class="btn btn-lg btn-danger">cancel</a>
              </div>
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
		//$('#ev_start_time, #ev_end_time').timepicker({
          //          format: 'LT'
              //  });
	});

	/*function goto_subdiv_check(){
		var ap_subdiv = $("#ap_subdiv option:selected").val();
		if(ap_subdiv != ""){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."main/get_block_police_by_subdiv"; ?>',
				data:{ap_subdiv: ap_subdiv},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg != 0)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('#plot_otherinfo').val('');
						//$('.otherplot_view').fadeOut(500);
						$('#ap_block').html(data.block_set);
						$('#ap_police').html(data.ps_set);
						$('#ap_block, #ap_police').prop('disabled', false);
						$('#ap_gp').html('<option value="">---Select---</option>');
						$('#ap_gp').prop('disabled', 'disabled');
						
					}else{
						$('#ap_block, #ap_police, #ap_gp').html('<option value="">---Select---</option>');
						$('#ap_block, #ap_police, #ap_gp').prop('disabled', 'disabled');
					}
					
				}
			});
		}else{
			$('#ap_block, #ap_police, #ap_gp').html('<option value="">---Select---</option>');
			$('#ap_block, #ap_police, #ap_gp').prop('disabled', 'disabled');
		}	
	}*/


	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = '';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_ext = /^[0-9:]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    
    	//var fu_type = $("#fu_type option:selected").val();
		var ev_no = $('#ev_no').val();
		
		if(ev_no == ""){
			e_error = 1;
			$('.ev_no').html('Event Number is Required.');
		}else{
			if(!ev_no.match(alphanumerics)){
				e_error = 1;
				$('.ev_no').html('Event Number not use special carecters Alphabet and Numerics, Check again.');
			}else{
				$('.ev_no').html('');
			}	
		}
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			if(error_message != ""){
				$('.get_error_total').html(error_message);
				$(".get_error_total").fadeIn();
			}
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."event/get_event_status_from_back"; ?>',
				data:{ev_no: ev_no},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('#plot_otherinfo').val('');
						//$('.otherplot_view').fadeOut(500);
						var suc_msg = '';
						$(".div_roller_total").fadeOut();
						if(data.ev_set.event_approval == 0){
							suc_msg = 'Your Event Application not seen Yet, Please wait for some time.';
						}else if(data.ev_set.event_approval == 1){
							suc_msg = 'Your Event Application is approved successfully, Please contact Administrator for further details.';
						}else if(data.ev_set.event_approval == 2){
							suc_msg = 'Your Event Application is rejected, Please contact Administrator for further details.';
						}else{
							suc_msg = 'Your Event Application not found, check Again.';
						}
						$(".get_success_total").html(suc_msg);
						$(".get_success_total").fadeIn();
						delay = 30000;
						setTimeout(function(){ $('.get_success_total').fadeOut(); $('#ev_no').val(''); }, delay);
										
					}else{
						
						$(".div_roller_total").fadeOut();
						$('.get_error_total').html(data.e_msg);
						$('.get_error_total').fadeIn();	
						delay = 8000;
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);	
						
					}
					
				}
			});
		}

  	}
	
</script>