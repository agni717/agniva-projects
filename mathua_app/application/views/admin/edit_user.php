<?php $this->load->view('admin/component/header') ?>

<!--<link rel="stylesheet" href="<?php //echo base_url('bootstrap-admin/bootstrap/css/bootstrap-multiselect.css'); ?>">-->

<?php //$this->load->view('admin/component/menu') ?>
<style>
.text-error { color: red;}
</style>

<div class="home pb-5">
						<div class="container">
							<div class="row">						
								<div class="col-lg-10 m-auto" >
									<div class="widget-area-2 proclinic-box-shadow">
										<h3 class="widget-title">Implementing Agency (DM Office) Modification</h3>
										<?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
										<?php //echo form_open_multipart(base_url().'admincontrol/dashboard/edit_user/'.$data_list->u_id,'class="form-horizontal" id="myForm"'); ?>
											<?php if (isset($error)) { ?>
											<div class="alert alert-error alert-danger">                
												<h4>Error!</h4>
												<?php echo $error; ?>
											</div>
											<?php } ?>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>First Name</label>
													<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" value="<?php echo $data_list->firstname; ?>" autocomplete="off" />
													<small class="text-error fname"><?php echo form_error('fname'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Last Name</label>
													<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" value="<?php echo $data_list->lastname; ?>" autocomplete="off" />
													<small class="text-error lname"><?php echo form_error('lname'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>User type</label>
													<select class="form-control" name="u_type" id="u_type" autocomplete="off">
														<option value="">---Select---</option>
														<?php foreach($utype_list as $usertypes){ ?>
														<option value="<?php echo $usertypes->mu_id; ?>" <?php if($usertypes->mu_id == $data_list->u_type){echo "selected";} ?>><?php echo $usertypes->mu_name; ?></option>
														<?php } ?>
													</select>
													<small class="text-error u_type"><?php echo form_error('u_type'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>District</label>
													<select class="form-control" name="u_district" id="u_district" autocomplete="off">
														<option value="">---Select---</option>
														<?php foreach($dist_list as $dist_item){ ?>
														<option value="<?php echo $dist_item->district_code; ?>" <?php if($dist_item->district_code == $data_list->u_dist){echo "selected";} ?>><?php echo $dist_item->district_name; ?></option>
														<?php } ?>
													</select>
													<small class="text-error u_district"><?php echo form_error('u_district'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Mobile No.</label>
													<input type="text" class="form-control" name="u_mobile" id="u_mobile" placeholder="Enter Mobile" value="<?php echo $data_list->mobile; ?>" autocomplete="off" />
													<small class="text-error u_mobile"><?php echo form_error('u_mobile'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Email</label>
													<input type="email" class="form-control" name="emailid" id="emailid" placeholder="Enter Email" value="<?php echo $data_list->email; ?>" autocomplete="off" />
													<small class="text-error emailid"><?php echo form_error('emailid'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												
												<div class="form-group col-lg-12">
													<label>Address</label>
													<textarea class="form-control" name="u_address" id="u_address" placeholder="Enter Full Address"><?php echo $data_list->address; ?></textarea>
													<small class="text-error u_address"><?php echo form_error('u_address'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Account No.</label>
													<input type="text" name="u_account_no" id="u_account_no" placeholder="Enter Account No." class="form-control" value="<?php echo $data_list->u_account_no; ?>" autocomplete="off" />
													<small class="text-error u_account_no"><?php echo form_error('u_account_no'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Bank Name</label>
													<input type="text" name="u_bankname" id="u_bankname" placeholder="Enter Bank Name" class="form-control" value="<?php echo $data_list->u_bank_name; ?>" autocomplete="off" />
													<small class="text-error u_bankname"><?php echo form_error('u_bankname'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Branch Name</label>
													<input type="text" name="u_branch_name" id="u_branch_name" placeholder="Enter Branch Name" class="form-control" value="<?php echo $data_list->u_branch_name; ?>" autocomplete="off" />
													<small class="text-error u_branch_name"><?php echo form_error('u_branch_name'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>IFSC Code</label>
													<input type="text" name="u_ifsc" id="u_ifsc" placeholder="Enter IFSC Code" class="form-control" value="<?php echo $data_list->u_ifsc_code; ?>" autocomplete="off" />
													<small class="text-error u_ifsc"><?php echo form_error('u_ifsc'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div  class="col-lg-12 text-center">
													<div align="center">
														<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
													</div>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-12">
													<button type="button" onclick="gotoclclickbutton();" class="btn btn-info">Update</button>
													&nbsp;<a href="<?= site_url('admincontrol/dashboard/administrator') ?>" class="btn btn-danger">Cancel</a>
												</div>
											</div>
										<?php echo form_close(); ?>								
									</div>
								</div>
							</div>
							
						</div>
					</div>



<?php $this->load->view('admin/component/footer') ?>
<!--<script src="<?php //echo base_url('bootstrap-admin/bootstrap/js/bootstrap-multiselect.js'); ?>"></script>
<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>-->

<script type="text/javascript">
	$(function(){
		//$("#datatable_tab").dataTable();
	    $('.alert-error, .text-error').delay(6000).fadeOut();
		//$('#u_startdate, #u_enddate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		//$(".timepicker").timepicker({showInputs: false, minuteStep: 30});
	});
	
	function check_timeall(timeset){
		var hours = Number(timeset.match(/^(\d+)/)[1]);
		var minutes = Number(timeset.match(/:(\d+)/)[1]);
		var AMPM = timeset.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if(hours<10) sHours = "0" + sHours;
		if(minutes<10) sMinutes = "0" + sMinutes;
		//alert(sHours + ":" + sMinutes);
		var time_all = sHours + ':' + sMinutes;
		return time_all;
	}
	
	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,.\- ]+$/;
		var alphanumerics_withspaces = /^[A-Za-z0-9\-]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	var fname = $('#fname').val();
    	var lname = $('#lname').val();
    	var u_district = $('#u_district option:selected').val();
    	var u_type = $('#u_type option:selected').val();
    	var u_mobile = $('#u_mobile').val();
		var emailid = $('#emailid').val();
    	//var username = $('#username').val();
    	//var password = $('#password').val();
    	//var re_password = $('#re_password').val();
    	var u_address = $('#u_address').val();
		
		/*var u_startdate = $('#u_startdate').val();
		var u_starttime = $('#u_starttime').val();
		var u_enddate = $('#u_enddate').val();
		var u_endtime = $('#u_endtime').val();
		var chk_counter = $('input[name="pr_lvl[]"]:checked').length;*/
		var u_account_no = $('#u_account_no').val();
		var u_bankname = $('#u_bankname').val();
		var u_branch_name = $('#u_branch_name').val();
		var u_ifsc = $('#u_ifsc').val();
		
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(fname == ""){
			e_error = 1;
			$('.fname').html('First Name is Required.');
		}else{
			if(!fname.match(alphanumerics_spaces)){
				e_error = 1;
				$('.fname').html('First Name not use special carecters [without _ . , -], Check again.');
			}else{
				$('.fname').html('');
			}	
		}
		if(lname == ""){
			e_error = 1;
			$('.lname').html('Last Name is Required.');
		}else{
			if(!lname.match(alphanumerics_spaces)){
				e_error = 1;
				$('.lname').html('Last Name not use special carecters [without _ . , -], Check again.');
			}else{
				$('.lname').html('');
			}	
		}
		if(u_district == ""){
			e_error = 1;
			$('.u_district').html('User District is Required.');
		}else{
			if(!u_district.match(onlynumerics)){
				e_error = 1;
				$('.u_district').html('User District only use Numeric Values, Check again.');
			}else{
				$('.u_district').html('');
			}	
		}
		if(u_type == ""){
			e_error = 1;
			$('.u_type').html('User Type is Required.');
		}else{
			if(!u_type.match(onlynumerics)){
				e_error = 1;
				$('.u_type').html('User Type only use Numeric Values, Check again.');
			}else{
				$('.u_type').html('');
			}	
		}
		if(emailid == ""){
			e_error = 1;
			$('.emailid').html('Email ID is Required.');
		}else{
			if(!emailid.match(emailpattern)){
				e_error = 1;
				$('.emailid').html('Email ID not valid Format, Check again.');
			}else{
				$('.emailid').html('');
			}	
		}
		if(u_address != ""){
			if(!u_address.match(alphanumerics_no)){
				e_error = 1;
				$('.u_address').html('Address not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.u_address').html('');
			}	
		}
		if(u_mobile == ""){
			e_error = 1;
			$('.u_mobile').html('Mobile No. is Required.');
		}else{
			if(!u_mobile.match(onlynumerics)){
				e_error = 1;
				$('.u_mobile').html('Mobile No. needs only 10 digit.');
			}else if(u_mobile.length != 10){
				e_error = 1;
				$('.u_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.u_mobile').html('');
			}
		}
		
		if(u_account_no != ""){
			if(!u_account_no.match(onlynumerics)){
				e_error = 1;
				$('.u_account_no').html('Account Number only use Numeric Values, Check again.');
			}else{
				$('.u_account_no').html('');
			}	
		}
		if(u_bankname != ""){
			if(!u_bankname.match(alphanumerics_spaces)){
				e_error = 1;
				$('.u_bankname').html('Bank Name not use special carecters [without _ . , -], Check again.');
			}else{
				$('.u_bankname').html('');
			}	
		}
		if(u_branch_name != ""){
			if(!u_branch_name.match(alphanumerics_spaces)){
				e_error = 1;
				$('.u_branch_name').html('Bank Branch Name not use special carecters [without _ . , -], Check again.');
			}else{
				$('.u_branch_name').html('');
			}	
		}
		if(u_ifsc != ""){
			if(!u_ifsc.match(alphanumerics)){
				e_error = 1;
				$('.u_ifsc').html('Bank IFSC Code only use Capital Letters and Numbers, Check again.');
			}else{
				$('.u_ifsc').html('');
			}	
		}
		
		/*if(document.getElementById("userworkorder").files.length == 0){
			e_error = 1;
			$('.userworkorder').html('Work-Order File is Required.');
		}else{
			var fileInput = document.getElementById('userworkorder'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworkorder').html('Work-Order File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworkorder').html('');
			}
			
		}
		if(document.getElementById("userworker").files.length == 0){
			e_error = 1;
			$('.userworker').html('Worker Details File is Required.');
		}else{
			var fileInput = document.getElementById('userworker'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworker').html('Worker Details File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworker').html('');
			}
		}*/
		
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
	
	function isDatecheck_dmY(txtDate)
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