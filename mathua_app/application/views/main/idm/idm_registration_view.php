<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
input[type="date"] {
	line-height:normal;
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
				<h1 class="panel-title">Inter District Movement Application Form</h1>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."idm/idm_form_submission"; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-md-4 control-label">Name of the Applicant <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_name" id="ap_name" placeholder="Name of the Applicant" class="form-control">
				<small class="text-error text-left ap_name"><?php echo form_error('ap_name'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Mobile No. of the Applicant <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_mobile" id="ap_mobile" placeholder="Mobile No. of the Applicant" class="form-control">
				<small class="text-error text-left ap_mobile"><?php echo form_error('ap_mobile'); ?></small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label">Email ID of the Applicant <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_email" id="ap_email" placeholder="Email ID of the Applicant" class="form-control">
				<small class="text-error text-left ap_email"><?php echo form_error('ap_email'); ?></small>
              </div>
            </div>
			<div class="form-group">
			<div class="col-md-12 text-left"><strong style="font-size:16px;color:blue;text-decoration:underline;">Present Address:-</strong></div>
			</div>
			<div class="form-group">
              <label class="col-md-2 control-label">Village/Street Name <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_village" id="ap_village" placeholder="Name of the Village/Street Name" class="form-control">
				<small class="text-error text-left ap_village"><?php echo form_error('ap_village'); ?></small>
              </div>
              <label class="col-md-2 control-label">GP Name/Ward No. <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_gp" id="ap_gp" placeholder="Name of the GP Name/Ward No." class="form-control">
				<small class="text-error text-left ap_gp"><?php echo form_error('ap_gp'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-2 control-label">Block/Municipality <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_block" id="ap_block" placeholder="Name of the Block/Municipality" class="form-control">
				<small class="text-error text-left ap_block"><?php echo form_error('ap_block'); ?></small>
              </div>
              <label class="col-md-2 control-label">District <font class="redclass">*</font></label>
              <div class="col-md-4">
                <select class="form-control" name="ap_district" id="ap_district">
             	<option value="" selected="">---Select---</option>
             	<?php foreach($dist_list as $s_dist){ ?>
				<option value="<?php echo $s_dist->dist_id; ?>"><?php echo $s_dist->dist_name; ?></option>
				<?php } ?>
             	</select>
				<small class="text-error text-left ap_district"><?php echo form_error('ap_district'); ?></small>
              </div>
            </div>
			<div class="form-group">
			<div class="col-md-12 text-left"><strong style="font-size:16px;color:blue;text-decoration:underline;">Permanent Address (Destination):-</strong></div>
			</div>
			<div class="form-group">
              <label class="col-md-2 control-label">Village/Street Name <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_village_dest" id="ap_village_dest" placeholder="Name of the Village/Street Name" class="form-control">
				<small class="text-error text-left ap_village_dest"><?php echo form_error('ap_village_dest'); ?></small>
              </div>
              <label class="col-md-2 control-label">GP Name/Ward No. <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_gp_dest" id="ap_gp_dest" placeholder="Name of the GP Name/Ward No." class="form-control">
				<small class="text-error text-left ap_gp_dest"><?php echo form_error('ap_gp_dest'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-2 control-label">Block/Municipality <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_block_dest" id="ap_block_dest" placeholder="Name of the Block/Municipality" class="form-control">
				<small class="text-error text-left ap_block_dest"><?php echo form_error('ap_block_dest'); ?></small>
              </div>
              <label class="col-md-2 control-label">District <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="ap_district_dest" id="ap_district_dest">
             	<option value="" selected="">---Select---</option>
             	<?php foreach($dist_list as $s_dist){ ?>
				<option value="<?php echo $s_dist->dist_id; ?>"><?php echo $s_dist->dist_name; ?></option>
				<?php } ?>
             	</select>
				<small class="text-error text-left ap_district_dest"><?php echo form_error('ap_district_dest'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-2 control-label">No. of people moving <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<input type="text" name="ap_pep_move" id="ap_pep_move" placeholder="No. of people moving" class="form-control">
				<small class="text-error ap_pep_move"><?php echo form_error('ap_pep_move'); ?></small>
              </div>
			  <label class="col-md-2 control-label">Date of Travel <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_movedate" id="ap_movedate" placeholder="DD-MM-YYYY" class="form-control">
				<small class="text-error ap_movedate"><?php echo form_error('ap_movedate'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Identity proof of the applicant and others( ID card issued by Govt./Voter ID/AADHAR/Passport/Driving License etc)<font class="redclass">*</font><br/>** This identity card is to be carried during the journey </label>
              <div class="col-md-8">
                <input type="file" name="useridentity" id="useridentity" class="form-control">
				<small class="text-error text-left useridentity"><?php echo form_error('useridentity'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-2 control-label">Identity card no. of the Applicant <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_idcard" id="ap_idcard" placeholder="Identity card no. of the Applicant" class="form-control">
				<small class="text-error text-left ap_idcard"><?php echo form_error('ap_idcard'); ?></small>
              </div>
			  <label class="col-md-2 control-label">Applicant Identity card Type <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_idtype" id="ap_idtype" placeholder="Applicant Identity card Type" class="form-control">
				<small class="text-error text-left ap_idtype"><?php echo form_error('ap_idtype'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-2 control-label">Vehicle No. <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_vno" id="ap_vno" placeholder="Vehicle No." class="form-control">
				<small class="text-error text-left ap_vno"><?php echo form_error('ap_vno'); ?></small>
              </div>
			  <label class="col-md-2 control-label">Vehicle Type <font class="redclass">*</font></label>
              <div class="col-md-4">
                <select class="form-control" name="ap_vtype" id="ap_vtype">
				<option value="" selected="">---Select---</option>
				<option value="Motorbike">Motorbike</option>
				<option value="4 Wheeler">4 Wheeler</option>
				<option value="Hatchback">Hatchback</option>
				<option value="SUV">SUV</option>
				<option value="Mini Bus">Mini Bus</option>
				<option value="Bus">Bus</option>
				</select>
				<small class="text-error text-left ap_vtype"><?php echo form_error('ap_vtype'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Reason for movement <font class="redclass">*</font></label>
              <div class="col-md-8">
			  <textarea name="ap_move_reason" id="ap_move_reason" placeholder="Reason for movement" class="form-control"></textarea>
				<small class="text-error text-left ap_move_reason"><?php echo form_error('ap_move_reason'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Medical/Emergency supporting documents <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="medicaldoc" id="medicaldoc" class="form-control">
				<small class="text-error text-left medicaldoc"><?php echo form_error('medicaldoc'); ?></small>
              </div>
            </div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
						<input type="checkbox" name="idm_declar" id="idm_declar" value="1"> We shall not travel to or from a red zone/containment zone or any prohibited zone as per government orders.
						</label><br/>
						<small class="text-error text-left idm_declar"><?php echo form_error('idm_declar'); ?></small>
					</div>
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
			  <a href="<?php echo base_url(); ?>" class="btn btn-lg btn-danger">cancel</a>
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
		$( "#ap_movedate" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
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
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    
    	var ap_name = $('#ap_name').val();
		var ap_mobile = $('#ap_mobile').val();
		var ap_email = $('#ap_email').val();

		var ap_village = $('#ap_village').val();
		var ap_gp = $('#ap_gp').val();
		var ap_block = $('#ap_block').val();
		var ap_district = $('#ap_district option:selected').val();
		var ap_village_dest = $('#ap_village_dest').val();
		var ap_gp_dest = $('#ap_gp_dest').val();
		var ap_block_dest = $('#ap_block_dest').val();
		var ap_district_dest = $('#ap_district_dest option:selected').val();
		
		var ap_pep_move = $('#ap_pep_move').val();
		var ap_movedate = $('#ap_movedate').val();
		var ap_idcard = $('#ap_idcard').val();
		var ap_idtype = $('#ap_idtype').val();
		var ap_vno = $('#ap_vno').val();
		var ap_vtype = $('#ap_vtype option:selected').val();
		var ap_move_reason = $('#ap_move_reason').val();

		if(ap_name == ""){
			e_error = 1;
			$('.ap_name').html('Name is Required.');
		}else{
			if(!ap_name.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_name').html('Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_name').html('');
			}	
		}
		if(ap_mobile == ""){
			e_error = 1;
			$('.ap_mobile').html('Mobile No. is required.');
		}else{
			if(!ap_mobile.match(onlynumerics)){
				e_error = 1;
				$('.ap_mobile').html('Mobile No. needs only 10 digit.');
			}else if(ap_mobile.length != 10){
				e_error = 1;
				$('.ap_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.ap_mobile').html('');
			}
		}
		if(ap_email == ""){
			e_error = 1;
			$('.ap_email').html('Email is Required.');
		}else{
			if(!emailpattern.test(ap_email)){
				e_error = 1;
				$('.ap_email').html('Email-ID not proper format, Check again.');
			}else{
				$('.ap_email').html('');
			}	
		}
		if(ap_village == ""){
			e_error = 1;
			$('.ap_village').html('Village/Street Name is Required.');
		}else{
			if(!ap_village.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_village').html('Village/Street Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_village').html('');
			}	
		}
		if(ap_gp == ""){
			e_error = 1;
			$('.ap_gp').html('GP Name/Ward No. is Required.');
		}else{
			if(!ap_gp.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_gp').html('GP Name/Ward No. not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_gp').html('');
			}	
		}
		if(ap_block == ""){
			e_error = 1;
			$('.ap_block').html('Block/Municipality Name is Required.');
		}else{
			if(!ap_block.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_block').html('Block/Municipality Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_block').html('');
			}	
		}
		if(ap_district == ""){
			e_error = 1;
			$('.ap_district').html('District Name is Required.');
		}else{
			if(!ap_district.match(onlynumerics)){
				e_error = 1;
				$('.ap_district').html('District Name need to check properly, Check again.');
			}else{
				$('.ap_district').html('');
			}	
		}
		
		if(ap_village_dest == ""){
			e_error = 1;
			$('.ap_village_dest').html('Village/Street Name is Required.');
		}else{
			if(!ap_village_dest.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_village_dest').html('Village/Street Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_village_dest').html('');
			}	
		}
		if(ap_gp_dest == ""){
			e_error = 1;
			$('.ap_gp_dest').html('GP Name/Ward No. is Required.');
		}else{
			if(!ap_gp_dest.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_gp_dest').html('GP Name/Ward No. not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_gp_dest').html('');
			}	
		}
		if(ap_block_dest == ""){
			e_error = 1;
			$('.ap_block_dest').html('Block/Municipality Name is Required.');
		}else{
			if(!ap_block_dest.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_block_dest').html('Block/Municipality Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_block_dest').html('');
			}	
		}
		if(ap_district_dest == ""){
			e_error = 1;
			$('.ap_district_dest').html('District Name is Required.');
		}else{
			if(!ap_district_dest.match(onlynumerics)){
				e_error = 1;
				$('.ap_district_dest').html('District Name need to check properly, Check again.');
			}else{
				$('.ap_district_dest').html('');
			}	
		}
		
		if(ap_pep_move == ""){
			e_error = 1;
			$('.ap_pep_move').html('Number of People is Required.');
		}else{
			if(!ap_pep_move.match(onlynumerics)){
				e_error = 1;
				$('.ap_pep_move').html('Number of People needs only Digit, Check again.');
			}else{
				$('.ap_pep_move').html('');
			}	
		}
		if(ap_movedate == ""){
			e_error = 1;
			$('.ap_movedate').html('Travel Date is Required.');
		}else{
				if(isDatecheck(ap_movedate) == false){
					e_error = 1;
					$('.ap_movedate').html('Travel Date Format check properly and Try Again.');
				}else{
					$('.ap_movedate').html('');
				}	
		}
		if(ap_idcard == ""){
			e_error = 1;
			$('.ap_idcard').html('Identity Card No. is Required.');
		}else{
			if(!ap_idcard.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_idcard').html('Identity Card No. not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_idcard').html('');
			}	
		}
		if(ap_idtype == ""){
			e_error = 1;
			$('.ap_idtype').html('Identity Card Type is Required.');
		}else{
			if(!ap_idtype.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_idtype').html('Identity Card Type not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_idtype').html('');
			}	
		}
		if(ap_vno == ""){
			e_error = 1;
			$('.ap_vno').html('Vehicle No. is Required.');
		}else{
			if(!ap_vno.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_vno').html('Vehicle No. not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_vno').html('');
			}	
		}
		if(ap_vtype == ""){
			e_error = 1;
			$('.ap_vtype').html('Vehicle Type is Required.');
		}else{
			if(!ap_vtype.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_vtype').html('Vehicle Type not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_vtype').html('');
			}	
		}
		if(ap_move_reason == ""){
			e_error = 1;
			$('.ap_move_reason').html('Reason for movement is Required.');
		}else{
			if(!ap_move_reason.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_move_reason').html('Reason for movement not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_move_reason').html('');
			}	
		}

		if(document.getElementById("useridentity").files.length == 0){
			e_error = 1;
			$('.useridentity').html('Users Identity File is Required.');
		}else{
			var fileInput = document.getElementById('useridentity'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.useridentity').html('Users Identity File type Invalid.(Use PDF/JPG)');
			}else{
				$('.useridentity').html('');
			}
			
		}
		if(document.getElementById("medicaldoc").files.length == 0){
			e_error = 1;
			$('.medicaldoc').html('Medical/Emergency File is Required.');
		}else{
			var fileInput = document.getElementById('medicaldoc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.medicaldoc').html('Medical/Emergency Details File type Invalid.(Use PDF/JPG)');
			}else{
				$('.medicaldoc').html('');
			}
		}
		
		if($('input#idm_declar').is(':checked')){
			$('.idm_declar').html('');
		}else{
			e_error = 1;
			$('.idm_declar').html('Declaration need to checked.');
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