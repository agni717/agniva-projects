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
				<h1 class="panel-title">Update Positive Case</h1>
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
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/positive_form_details_entryupdate/".$collect_detail->collect_id; ?>" method="POST" enctype="multipart/form-data">
		  	<div class="form-group" style="font-size:18px;">
			  <label class="col-md-8">Sample collection/ Screening Date :- <?php echo date('d-m-Y',strtotime($collect_detail->collect_date)); ?></label>
			  <label class="col-md-4">Swab Collected :- <?php if($collect_detail->collect_swap == "Yes"){echo 'Yes';}elseif($collect_detail->collect_swap == "No"){echo 'No';} ?></label>
			  <input type="hidden" name="ap_date" value="<?php echo date('d-m-Y',strtotime($collect_detail->collect_date)); ?>" />
			  <input type="hidden" name="ap_swap" value="<?php echo $collect_detail->collect_swap; ?>" />
			</div>
			<div class="form-group" style="display: block;font-size:18px;">
				<label class="col-md-6">SRF ID :- <?php echo $collect_detail->collect_srf; ?></label>
				<label class="col-md-6">Testing Lab :- <?php echo $collect_detail->collect_lab; ?></label>
				<label class="col-md-6">Pooling  :- <?php echo $collect_detail->collect_pool; ?></label>
				<label class="col-md-6">Standalone  :- <?php echo $collect_detail->collect_stand; ?></label>
				<label class="col-md-6">Name  :- <?php echo $collect_detail->collect_name; ?></label>
				<label class="col-md-6">Mobile No.  :- <?php echo $collect_detail->collect_mobile; ?></label>
				<label class="col-md-6">Quarantine  :- <?php if($collect_detail->collect_q_home == "Yes"){echo 'Home Quarantine';}elseif($collect_detail->collect_q_inst == "Yes"){echo 'Institutional Quarantine';}elseif($collect_detail->collect_q_semi_inst == "Yes"){echo 'Semi Institutional Quarantine';} ?></label>
			</div>
			
			<div class="col-md-12 text-left"><strong style="font-size:16px;color:blue;text-decoration:underline;">Postive Case Information:-</strong></div>
			<div class="form-group">
              <label class="col-md-2 control-label" style="margin-top:5px;">Admission Date <font class="redclass">*</font></label>
              <div class="col-md-4" style="margin-top:5px;">
                <input type="text" name="admit_date" id="admit_date" placeholder="DD-MM-YYYY" autocomplete="off" class="form-control">
				<small class="text-error admit_date"><?php echo form_error('admit_date'); ?></small>
			  </div>
			  <label class="col-md-2 control-label">Admitted at <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="admit_loc" id="admit_loc" onchange="goto_check_admit();">
				<option value="">---Select---</option>
				<option value="Onda Super Speciality Hospital">Onda Super Speciality Hospital</option>
             	<option value="Sanka Hospital">Sanka Hospital</option>
             	<option value="Safe Home">Safe Home</option>
             	</select>
             	<small class="text-error admit_loc"><?php echo form_error('admit_loc'); ?></small>
			  </div>
            </div>
			<div class="form-group safehome_tab" style="display:none;">
			  <label class="col-md-2 control-label">Safe Home <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="admit_home" id="admit_home" onchange="goto_check_home();">
				<option value="">---Select---</option>
				<?php foreach($safe_list as $safe_s){ ?>
				<option value="<?php echo $safe_s->safe_name; ?>"><?php echo $safe_s->safe_name; ?></option>
				<?php } ?> 
             	<option value="Others">Others</option>
             	</select>
             	<small class="text-error admit_home"><?php echo form_error('admit_home'); ?></small>
			  </div>
			  <div class="home_name_entrytab" style="display:none;">
				<label class="col-md-2 control-label">Name of Home <font class="redclass">*</font></label>
				<div class="col-md-4">
					<input type="text" name="admit_home_name" id="admit_home_name" placeholder="Enter Name of Home" class="form-control">
					<small class="text-error admit_home_name"><?php echo form_error('admit_home_name'); ?></small>
				</div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-md-2 control-label">Release Date</label>
              <div class="col-md-4">
                <input type="text" name="release_date" id="release_date" placeholder="DD-MM-YYYY" autocomplete="off" class="form-control">
				<small class="text-error release_date"><?php echo form_error('release_date'); ?></small>
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
			  <a href="<?php echo base_url()."member/dashboard"; ?>" class="btn btn-lg btn-danger">cancel</a>
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
		$( "#admit_date, #release_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();
	});

	function goto_check_admit(){
		var admit_loc = $("#admit_loc option:selected").val();
		if(admit_loc == "Safe Home"){
			$('#admit_home').val('');
			$('.safehome_tab').show(500);
			$('#admit_home_name').val('');
			$('.home_name_entrytab').fadeOut(500);
		}else{
			$('#admit_home').val('');
			$('.safehome_tab').fadeOut(500);
			$('#admit_home_name').val('');
			$('.home_name_entrytab').fadeOut(500);
		}
	}

	function goto_check_home(){
		var admit_home = $("#admit_home option:selected").val();
		if(admit_home == "Others"){
			$('#admit_home_name').val('');
			$('.home_name_entrytab').show(500);
		}else{
			$('#admit_home_name').val('');
			$('.home_name_entrytab').fadeOut(500);
		}
	}

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
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

		var admit_date = $('#admit_date').val();
		var admit_loc = $("#admit_loc option:selected").val();
		var admit_home = $("#admit_home option:selected").val();
		var admit_home_name = $('#admit_home_name').val();
		var release_date = $('#release_date').val();
		//var s_jobcard = $("input[name='s_jobcard']:checked").val();
		//var s_rationcard = $("input[name='s_rationcard']:checked").val();
		
		if(admit_date == ""){
			e_error = 1;
			$('.admit_date').html('Admit Date is Required.');
		}else{
			if(isDatecheck(admit_date) == false){
				e_error = 1;
				$('.admit_date').html('Admit Date Format check properly and Try Again.');
			}else{
				$('.admit_date').html('');
			}	
		}

		if(release_date != ""){
			if(isDatecheck(release_date) == false){
				e_error = 1;
				$('.release_date').html('Release Date Format check properly and Try Again.');
			}else{
				$('.release_date').html('');
			}	
		}

		if(admit_loc == ""){
			e_error = 1;
			$('.admit_loc').html('Admitted At is Required.');
		}else{
			if(!admit_loc.match(alphanumerics_no)){
				e_error = 1;
				$('.admit_loc').html('Admitted At not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.admit_loc').html('');
				if(admit_loc == "Safe Home"){
					if(admit_home == ""){
						e_error = 1;
						$('.admit_home').html('Select Home is Required.');
					}else{
						if(!admit_home.match(alphanumerics_no)){
							e_error = 1;
							$('.admit_home').html('Select Home not use special carecters [without _ / & : ( . ) , -], Check again.');
						}else{
							$('.admit_home').html('');
							if(admit_home == "Others"){
								if(admit_home_name == ""){
									e_error = 1;
									$('.admit_home_name').html('Home Name is Required.');
								}else{
									if(!admit_home_name.match(alphanumerics_no)){
										e_error = 1;
										$('.admit_home_name').html('Home Name not use special carecters [without _ / & : ( . ) , -], Check again.');
									}else{
										$('.admit_home_name').html('');
									}	
								}
							}else{
								$('.admit_home_name').html('');
							}
						}	
					}
				}else{
					$('.admit_home').html('');
					$('.admit_home_name').html('');
				}
			}	
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

	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		//Checks for dd/mm/yyyy format.
		dtMonth = dtArray[3];
		dtDay= dtArray[1];
		dtYear = dtArray[5];        
		
		if (dtMonth < 1 || dtMonth > 12) 
			return false;
		else if (dtDay < 1 || dtDay> 31) 
			return false;
		else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
			return false;
		else if (dtMonth == 2) 
		{
			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if (dtDay> 29 || (dtDay ==29 && !isleap)) 
					return false;
		}
		return true;
  	}

</script>