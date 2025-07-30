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
				<h1 class="panel-title">Event Registration Form</h1>
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
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."event/registration"; ?>" method="POST" enctype="multipart/form-data">
		  <div class="form-row">
            <div class="form-group col-sm-12">
				<label class="control-label">Event Name <font class="redclass">*</font></label>
                <input type="text" name="ev_name" id="ev_name" placeholder="Event Name" class="form-control" value="<?php echo set_value('ev_name'); ?>" autocomplete="off">
				<small class="text-error text-left ev_name"><?php echo form_error('ev_name'); ?></small>
            </div>
			<div class="form-group col-sm-3">
              <label class="control-label">Start Date <font class="redclass">*</font></label>
              <input type="date" name="ev_start_date" id="ev_start_date" placeholder="" class="form-control" value="<?php echo set_value('ev_start_date'); ?>" autocomplete="off">
			  <small class="text-error text-left ev_start_date"><?php echo form_error('ev_start_date'); ?></small>
            </div>
			<div class="form-group col-sm-2">
				<label class="control-label">Start Time <font class="redclass">*</font></label>
                <input type="time" name="ev_start_time" id="ev_start_time" placeholder="" class="form-control" value="<?php echo set_value('ev_start_time'); ?>" autocomplete="off">
				<small class="text-error text-left ev_start_time"><?php echo form_error('ev_start_time'); ?></small>
            </div>
			<div class="form-group col-sm-1">&nbsp;</div>
			<div class="form-group col-sm-3">
              <label class="control-label">End Date<font class="redclass">*</font></label>
              <input type="date" name="ev_end_date" id="ev_end_date" placeholder="" class="form-control" value="<?php echo set_value('ev_end_date'); ?>" autocomplete="off">
			  <small class="text-error text-left ev_end_date"><?php echo form_error('ev_end_date'); ?></small>
            </div>
			<div class="form-group col-sm-2">
              <label class="control-label">End Time <font class="redclass">*</font></label>
              <input type="time" name="ev_end_time" id="ev_end_time" placeholder="" class="form-control" value="<?php echo set_value('ev_end_time'); ?>" autocomplete="off">
			  <small class="text-error text-left ev_end_time"><?php echo form_error('ev_end_time'); ?></small>
            </div>
			
			<div class="form-group col-sm-6">
				<label class="control-label">Contact Person Name <font class="redclass">*</font></label>
                <input type="text" name="ev_person" id="ev_person" placeholder="Contact Person Name" class="form-control" value="<?php echo set_value('ev_person'); ?>" autocomplete="off">
				<small class="text-error text-left ev_person"><?php echo form_error('ev_person'); ?></small>
            </div>
			<div class="form-group col-sm-6">
              <label class="control-label">Mobile No. <font class="redclass">*</font></label>
              <input type="text" name="ev_mobile" id="ev_mobile" placeholder="Mobile Number" class="form-control" value="<?php echo set_value('ev_mobile'); ?>" autocomplete="off">
			  <small class="text-error text-left ev_mobile"><?php echo form_error('ev_mobile'); ?></small>
            </div>
            
			<div class="form-group col-sm-12">
              <label class="control-label">Address</label>
              <textarea name="ev_address" id="ev_address" placeholder="Address" class="form-control" autocomplete="off"><?php echo set_value('ev_address'); ?></textarea>
			  <small class="text-error text-left ev_address"><?php echo form_error('ev_address'); ?></small>
            </div>
			
			<!--<div class="form-group">
              <label class="col-md-4 control-label">No. of workers to be engaged <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_worker_no" id="ap_worker_no" placeholder="No. of workers to be engaged" class="form-control">
				<small class="text-error text-left ap_worker_no"><?php //echo form_error('ap_worker_no'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Whether workers are local/ from outside <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_worker_loc" id="ap_worker_loc" placeholder="Whether workers are local/ from outside" class="form-control">
				<small class="text-error text-left ap_worker_loc"><?php //echo form_error('ap_worker_loc'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Upload Work Order Copy (File name must contain Agency Name) <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="userworkorder" id="userworkorder" class="form-control">
				<small class="text-error text-left userworkorder"><?php //echo form_error('userworkorder'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Upload Details of Workers (File name must contain Agency Name) <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="userworker" id="userworker" class="form-control">
				<small class="text-error text-left userworker"><?php //echo form_error('userworker'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-12 text-left">Agree with the following terms and conditions? <font class="redclass">*</font><br/>(a) No activity will be taken up in containment zones/ areas.<br/>(b) Minimum numbers of labourers will be engaged, work mostly will be done through mechanical implements.<br/>(c) Social distancing will be maintained.<br/>(d) Soap and water will be supplying for sufficient hand washing.<br/>(e) Mask will be supplied at site for workers.<br/>(f) All these arrangements will be photographed for record.<br/>(g) All other norms as specified by the State Govt. from time to time will be followed.</label>
              <div class="col-md-12 text-left">
			  	
              </div>
            </div>-->
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
	}

	function goto_block_check(){
		var ap_subdiv = $("#ap_subdiv option:selected").val();
		var ap_block = $("#ap_block option:selected").val();
		if(ap_block != "" && ap_subdiv != ""){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."main/get_gp_by_block_subdiv"; ?>',
				data:{ap_subdiv:ap_subdiv, ap_block: ap_block},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg != 0)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('#plot_otherinfo').val('');
						//$('.otherplot_view').fadeOut(500);
						$('#ap_gp').html(data.gp_set);
						$('#ap_gp').prop('disabled', false);
						
					}else{
						$('#ap_gp').html('<option value="">---Select---</option>');
						$('#ap_gp').prop('disabled', 'disabled');
					}
					
				}
			});
		}else{
			$('#ap_gp').html('<option value="">---Select---</option>');
			$('#ap_gp').prop('disabled', 'disabled');
		}	
	}*/


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
		var onlynumerics_ext = /^[0-9:]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    
    	//var fu_type = $("#fu_type option:selected").val();
		var ev_name = $('#ev_name').val();
		var ev_start_date = $('#ev_start_date').val();
		var ev_start_time = $('#ev_start_time').val();
		var ev_end_date = $('#ev_end_date').val();
		var ev_end_time = $('#ev_end_time').val();
		var ev_person = $('#ev_person').val();
		var ev_mobile = $('#ev_mobile').val();
		var ev_address = $('#ev_address').val();
		
		if(ev_name == ""){
			e_error = 1;
			$('.ev_name').html('Event Name is Required.');
		}else{
			if(!ev_name.match(alphanumerics_no)){
				e_error = 1;
				$('.ev_name').html('Event Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ev_name').html('');
			}	
		}
		
		if(ev_start_date == ""){
			e_error = 1;
			$('.ev_start_date').html('Start Date is Required.');
		}else{
			if(isDatecheck(ev_start_date) == false){
				e_error = 1;
				$('.ev_start_date').html('Start Date Format check properly and Try Again.');
			}else{
				var TodayDate = new Date();
				//alert(TodayDate.setHours(0,0,0,0));
				var startDate = new Date(Date.parse(ev_start_date));
				//alert(startDate.setHours(0,0,0,0));
				if (TodayDate.setHours(0,0,0,0) > startDate.setHours(0,0,0,0)) {
					e_error = 1;
					$('.ev_start_date').html('Start Date Always Same or Greater Than Today and Try Again.');
				}else{	
					$('.ev_start_date').html('');
				}
			}	
		}
		
		if(ev_end_date == ""){
			e_error = 1;
			$('.ev_end_date').html('End Date is Required.');
		}else{
			if(isDatecheck(ev_end_date) == false){
				e_error = 1;
				$('.ev_end_date').html('End Date Format check properly and Try Again.');
			}else{
				var TodayDate = new Date();
				//alert(TodayDate.setHours(0,0,0,0));
				var endDate = new Date(Date.parse(ev_end_date));
				//alert(endDate.setHours(0,0,0,0));
				if (TodayDate.setHours(0,0,0,0) > endDate.setHours(0,0,0,0)) {
					e_error = 1;
					$('.ev_end_date').html('End Date Always Same or Greater Than Today and Try Again.');
				}else{	
					$('.ev_end_date').html('');
				}
			}	
		}
		
		if(ev_start_time == ""){
			e_error = 1;
			$('.ev_start_time').html('Event Start Time is Required.');
		}else{
			if(!ev_start_time.match(onlynumerics_ext)){
				e_error = 1;
				$('.ev_start_time').html('Event Start Time not match proper format, Check again.');
			}else{
				if(ev_start_date != ""){
					var TodayDate = new Date();
					//alert(TodayDate.setHours(0,0,0,0));
					var startDate = new Date(Date.parse(ev_start_date));
					//alert(startDate.setHours(0,0,0,0));
					if (TodayDate.setHours(0,0,0,0) == startDate.setHours(0,0,0,0)) {
						var dt = new Date();
						dt.setHours( dt.getHours() + 1 );
						var todayTime = dt.getTime();
						ev_start_time = ev_start_time + ":00";
						var startTime = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + ev_start_time);
						startTime = startTime.getTime();
						
						if(todayTime > startTime){
							e_error = 1;
							$('.ev_start_time').html('Event Start Time always Greater than 1 hour from Today Time, Check again.');
						}else{
							$('.ev_start_time').html('');
						}
					}else{
						$('.ev_start_time').html('');
					}
				}else{
					$('.ev_start_time').html('');
				}
			}	
		}
		
		if(ev_end_time == ""){
			e_error = 1;
			$('.ev_end_time').html('Event End Time is Required.');
		}else{
			if(!ev_end_time.match(onlynumerics_ext)){
				e_error = 1;
				$('.ev_end_time').html('Event End Time not match proper format, Check again.');
			}else{
				if(ev_end_date != ""){
					var TodayDate = new Date();
					var endDate = new Date(Date.parse(ev_end_date));
					if (TodayDate.setHours(0,0,0,0) == endDate.setHours(0,0,0,0)) {
						var dt = new Date();
						dt.setHours( dt.getHours() + 2 );
						var todayTime = dt.getTime();
						ev_end_time = ev_end_time + ":00";
						var endTime = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + ev_end_time);
						endTime = endTime.getTime();
						
						if(todayTime > endTime){
							e_error = 1;
							$('.ev_end_time').html('Event End Time always Greater than 2 hour from Today Time, Check again.');
						}else{
							$('.ev_end_time').html('');
						}
					}else{
						$('.ev_end_time').html('');
					}
				}else{
					$('.ev_end_time').html('');
				}
			}	
		}
		
		if(ev_start_date != "" && ev_end_date != ""){
			var startDate = new Date(Date.parse(ev_start_date));
			var endDate = new Date(Date.parse(ev_end_date));
			if (startDate.setHours(0,0,0,0) > endDate.setHours(0,0,0,0)) {
				e_error = 1;
				error_message = error_message + '<br/>End Date Always same or Greater than Start Date, Try again.';
			}else if(startDate.setHours(0,0,0,0) == endDate.setHours(0,0,0,0)){
				if(ev_start_time != "" && ev_end_time != ""){
					var dt = new Date();
					//dt.setHours( dt.getHours() + 1 );
					//var todayTime = dt.getTime();
					ev_start_time = ev_start_time + ":00";
					ev_end_time = ev_end_time + ":00";
					var startTime = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + ev_start_time);
					var endTime = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + ev_end_time);
					startTime.setHours(startTime.getHours() + 1);
					startTime = startTime.getTime();
					endTime = endTime.getTime();
					if(startTime > endTime){
						e_error = 1;
						error_message = error_message + '<br/>Event End Time always Greater than Event Start Time and Minimun 1 Hour Difference, Check again.';
					}
				}
			}
		}
		
		if(ev_person == ""){
			e_error = 1;
			$('.ev_person').html('Contact Person Name is Required.');
		}else{
			if(!ev_person.match(alphanumerics_no)){
				e_error = 1;
				$('.ev_person').html('Contact Person Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ev_person').html('');
			}	
		}
		
		if(ev_mobile == ""){
			e_error = 1;
			$('.ev_mobile').html('Mobile No. is required.');
		}else{
			if(!ev_mobile.match(onlynumerics)){
				e_error = 1;
				$('.ev_mobile').html('Mobile No. needs only 10 digit.');
			}else if(ev_mobile.length != 10){
				e_error = 1;
				$('.ev_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.ev_mobile').html('');
			}
		}
		
		if(ev_address != ""){
			if(!ev_address.match(alphanumerics_no)){
				e_error = 1;
				$('.ev_address').html('Address not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ev_address').html('');
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
		}
		
		if(fu_gender == "" || fu_gender == undefined){
			e_error = 1;
			$('.fu_gender').html('Gender is Required.');
		}else{
			if(!fu_gender.match(alphaletters)){
				e_error = 1;
				$('.fu_gender').html('Gender not use Numeric values, Check again.');
			}else{
				$('.fu_gender').html('');
			}
		}
		if(fu_pincode != ""){
			if(!fu_pincode.match(onlynumerics)){
				e_error = 1;
				$('.fu_pincode').html('Pincode needs only Digit, Check again.');
			}else{
				$('.fu_pincode').html('');
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
	
	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		
		//Checks for mm/dd/yyyy format.
		dtMonth = dtArray[3];
		dtDay= dtArray[5];
		dtYear = dtArray[1];        
		
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