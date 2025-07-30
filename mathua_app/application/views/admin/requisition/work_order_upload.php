<?php $this->load->view('admin/component/header') ?>


<?php

$user_typ = $this->session->userdata('utype');

if($user_typ > 3 || $user_typ < 3){
	
	redirect('http://localhost/mathua_app/admincontrol/dashboard');
	exit();
}

$total_paid = 0;
for($i=0; $i<count($payment_details); $i++){
	$total_paid = $total_paid + $payment_details[$i]->wpay_amount;
}

$approv_amt = number_format($requisition_details->req_final_amount, 2, '.', '');

// if (!((float)$total_paid < (float)$approv_amt)) {

// 	redirect('admincontrol/requisition/installment_payment_details/'.$requisition_details->req_id);
	
// }


// if(count((array)$installment_details) > count((array)$payment_details)){
// 	$next_work_percentage = $installment_details[count($payment_details)]->scd_percent_work;
// }
// else{
// 	$next_work_percentage = null;
// }

// $total_paid = 0;
// for($i=0; $i<count($payment_details); $i++){
// 	$total_paid = $total_paid + $payment_details[$i]->wpay_amount;
// }
// $approv_amt = number_format($requisition_details->req_final_amount, 2, '.', '');

$paid_amt = number_format($total_paid, 2, '.', '');
$paid_amt_percentage = number_format(($total_paid/$requisition_details->req_final_amount)*100);
$balanc_amt = number_format(($requisition_details->req_final_amount - $total_paid), 2, '.', '');
$balanc_amt_percentage = number_format((($requisition_details->req_final_amount - $total_paid)/$requisition_details->req_final_amount)*100);
if(count($payment_details) > 0) { 
	$work_done_percentage = $payment_details[count($payment_details) - 1]->wpay_percent_work; 
} 
else { 
	$work_done_percentage = 0; 
}


// if((float)$total_paid >= (float)$approv_amt){
// 	redirect('admincontrol/requisition/installment_payment_details/'.$requisition_details->req_id);
// }


?>

<style>
	.text-error { color: red;}
</style>


<div class="home pb-5">
		<div class="container">
			<div class="row">						
				<div class="col-lg-10 mx-auto">
					<div class="widget-area-2 proclinic-box-shadow">
						<h3 class="widget-title">Work Order Against the Scheme</h3>

						<!-- <form> -->
						<?php echo form_open_multipart('', 'class="form-horizontal" id="paymentForm"'); ?>
					        <?php 
                            if (isset($error)) { ?>
					            <div class="alert alert-error alert-danger">                
						            <h4>Error!</h4>
						            <?php echo $error; ?>
					            </div>
					            <?php 
                            } ?>

							<fieldset class="scheduler-border">
								<legend class="scheduler-border"><?php echo $requisition_details->req_number; ?></legend>
								<div class="form-row control-group">
									<div class="form-group col-lg-4">
										<label>Scheme : <?php echo $requisition_details->scm_name; ?></label>
									</div>													
									<div class="form-group col-lg-4">
										<label>District : <?php echo $requisition_details->district_name; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>Block : <?php echo $requisition_details->block_name; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>Approved Amount : ₹<?php echo $approv_amt; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>Amount Paid : ₹<?php echo $paid_amt." (".$paid_amt_percentage."%)"; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>Balance Amount : ₹<?php echo $balanc_amt." (".$balanc_amt_percentage."%)"; ?></label>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Work Order No.</label>
										<input type="text" placeholder="Work Order Number" class="form-control " id="wo_no">
										<small class="text-error wo_no"><?php echo form_error('wo_no'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Work Order Date</label>
										<input type="date" class="form-control " id="wo_date" >
										<small class="text-error wo_date"><?php echo form_error('wo_date'); ?></small>
									</div>									
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Work Order</label>
										<input type="file" class="form-control " id="wo_doc">
										<small class="text-error wo_doc"><?php echo form_error('wo_doc'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Agency Name</label>
										<input type="text" placeholder="Agency Name" class="form-control " id="wo_agency_name" >
										<small class="text-error wo_agency_name"><?php echo form_error('wo_agency_name'); ?></small>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Work Start Date</label>
										<input type="date" class="form-control " id="wo_work_start_date" >
										<small class="text-error wo_work_start_date"><?php echo form_error('wo_work_start_date'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Start Utilization Certificate</label>
										<input type="file" class="form-control " id="wo_utilization_certificate_doc">
										<small class="text-error wo_utilization_certificate_doc"><?php echo form_error('wo_utilization_certificate_doc'); ?></small>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Balance Amount (₹)</label>
										<input type="number" placeholder="Balance Amount(₹)" class="form-control " id="wo_balance_amount" >
										<small class="text-error wo_balance_amount"><?php echo form_error('wo_balance_amount'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label></label>
										<input type="hidden" class="form-control wo_req_id" id="wo_req_id" value="<?php echo $requisition_details->req_id; ?>">
										<input type="hidden" class="form-control balance_amount" id="balance_amount" value="<?php echo $balanc_amt; ?>">
										<button type="button" onclick="gotoFinalPaymentClickButton();" class="btn btn-primary d-block ml-lg-auto gofinalsubmit">Submit</button>
									</div>
								</div>										
							</fieldset>
							<div class="form-group">
                                <div class="col-sm-12 text-center">
                                    <div align="center">
                                        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
                                        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
                                        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
                                    </div>
                                </div>
                            </div>
						<?php form_close(); ?>
						<!-- </form> -->
					</div>
				</div>
			</div>
		</div>
	</div>


<?php $this->load->view('admin/component/footer') ?>

<script>

	function isDatecheck(txtDate){
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		//var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		
		//Checks for mm/dd/yyyy format.
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

	function gotoFinalPaymentClickButton(){
		
		$('.div_roller_total').fadeIn();
		$('.gofinalsubmit').attr("disabled", "disabled");

        //===================================================================
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@%=<>)\[\]+;:.',\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
        var allowedExtensions_only_pdf = /(\.pdf|\.PDF)$/i;

		//========== Payment Form Input Get Values ===================
		var wo_req_id = $('#wo_req_id').val().trim();
		var balance_amount = $('#balance_amount').val().trim();
		var wo_no = $('#wo_no').val().trim();
		var wo_date = $('#wo_date').val().trim();
		var wo_doc = $('#wo_doc')[0].files;
		var wo_agency_name = $('#wo_agency_name').val().trim();
        var wo_work_start_date = $('#wo_work_start_date').val().trim();
		var wo_utilization_certificate_doc = $('#wo_utilization_certificate_doc')[0].files;
		var wo_balance_amount = $('#wo_balance_amount').val().trim();

		//========== Hidden Input Validation ===================
		if(wo_req_id == ""){
			e_error = 1;
		}
 
		if(balance_amount == ""){
			e_error = 1;
		}

		//========== Work Order Number Input Validation ===================
		if(wo_no == ""){
			e_error = 1;
			$('.wo_no').html('Work Order Number is Required.');
		}
		else{
			if(!wo_no.match(alphanumerics_no)){
				e_error = 1;
				$('.wo_no').html('Work Order Number not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.wo_no').html('');
			}
		}

		//========== Work Order Date Input Validation ===================
		if(wo_date == ""){
			e_error = 1;
			$('.wo_date').html('Work Order Date is Required.');
		}
		else{
			if(isDatecheck(wo_date)){
				e_error = 1;
				$('.wo_date').html('Invalid Date, Check again.');
			}else{
				$('.wo_date').html('');
			}
		}

		//========== Work Order Doc. Input Validation ===================
		if(document.getElementById("wo_doc").files.length == 0){
			e_error = 1;
			$('.wo_doc').html('Work Order is Required.');
		}
		else{
			var fileInput = document.getElementById('wo_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.wo_doc').html('Upload File type Invalid.(Use PDF/JPEG/JPG/PNG only)');
			}
			else{
				$('.wo_doc').html('');
			}
		}

		//========== Agency Name Input Validation ===================
		if(wo_agency_name == ""){
			e_error = 1;
			$('.wo_agency_name').html('Agency Name is Required.');
		}
		else{
			if(!wo_agency_name.match(alphanumerics_no)){
				e_error = 1;
				$('.wo_agency_name').html('Agency Name not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.wo_agency_name').html('');
			}
		}

		//========== Work Start Date Input Validation ===================
		if(wo_work_start_date == ""){
			e_error = 1;
			$('.wo_work_start_date').html('Work Start Date is Required.');
		}
		else{
			if(isDatecheck(wo_work_start_date)){
				e_error = 1;
				$('.wo_work_start_date').html('Invalid Date, Check again.');
			}else{
				$('.wo_work_start_date').html('');
			}
		}

		//========== Start Utilization Certificate Doc. Input Validation ===================
		if(document.getElementById("wo_utilization_certificate_doc").files.length == 0){
			e_error = 1;
			$('.wo_utilization_certificate_doc').html('Start Utilization Certificate is Required.');
		}
		else{
			var fileInput = document.getElementById('wo_utilization_certificate_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.wo_utilization_certificate_doc').html('Upload File type Invalid.(Use PDF/JPEG/JPG/PNG only)');
			}
			else{
				$('.wo_utilization_certificate_doc').html('');
			}
		}

		//========== Balance Ammount Validation ===================
		if(wo_balance_amount == ""){
			e_error = 1;
			$('.wo_balance_amount').html('Balance Ammount is Required.');
		}
		else if(!wo_balance_amount.match(onlynumerics_withdot)){
			e_error = 1;
			$('.wo_balance_amount').html('Only Numerics and Dot are allowed.');
		}
		else if(parseFloat(wo_balance_amount) > parseFloat(balance_amount)){
			e_error = 1;
			$('.wo_balance_amount').html('Balance Amount should not more than '+ parseFloat(balance_amount) +'.');
		}
		else{
			$('.wo_balance_amount').html('');	
		}

		


		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} 
		else {
			
			var conf_answer = confirm("Are you sure you want to Submit the Data for New Scheme?");
			if (conf_answer) {

				var form_data = new FormData();
                form_data.append('wo_req_id', wo_req_id);
                form_data.append('wo_no', wo_no);
                form_data.append('wo_date', wo_date);
                form_data.append('wo_doc', wo_doc[0]);
				form_data.append('wo_agency_name', wo_agency_name);
                form_data.append('wo_work_start_date', wo_work_start_date);
                form_data.append('wo_utilization_certificate_doc', wo_utilization_certificate_doc[0]);
				form_data.append('wo_balance_amount', wo_balance_amount);

				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
                    url: '<?php echo base_url() . "admincontrol/requisition/work_order_submit"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						if (data.msg == 1) {
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Work Order is Submitted Successfully.');
							$(".get_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								// window.location.replace("<?php //echo site_url('admincontrol/requisition/installment_payment_details/'.$requisition_details->req_id) ?>");
								window.location.replace("<?php echo site_url('admincontrol/requisition/requisition_list') ?>");
							}, 3000);
						} else {
							$('.div_roller_total').fadeOut();
							$('.gofinalsubmit').attr("disabled", false);
							error_message = "There have some problem to Store Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total').html(error_message);
							$(".get_error_total").fadeIn();
							setTimeout(function() {
								$('.get_error_total').fadeOut();
							}, delay);
						}
					}
				});

			} else {
				$('.div_roller_total').fadeOut();
				$('.gofinalsubmit').attr("disabled", false);
			}
		}

	}
</script>