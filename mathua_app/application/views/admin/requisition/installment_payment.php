<?php $this->load->view('admin/component/header') ?>


<?php

// echo "<pre>";
// print_r($payment_details);
// exit;

// if(count($installment_details) == count($payment_details)){
	// redirect('admincontrol/requisition/installment_payment_details/'.$requisition_details->req_id);
	// exit();
// }

$user_typ = $this->session->userdata('utype');

if($user_typ < 1 || $user_typ > 2){
	
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


if(count((array)$installment_details) > count((array)$payment_details)){
	$next_work_percentage = $installment_details[count($payment_details)]->scd_percent_work;
}
else{
	$next_work_percentage = null;
}

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
						<h3 class="widget-title">Payment Against the Requisition No <?php echo $requisition_details->req_number; ?></h3>

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

								<?php 
									if(count($payment_details) + 1 == 1){
										$inst_no = "1st ";
									}
									elseif(count($payment_details) + 1 == 2){
										$inst_no = "2nd ";
									}
									else{
										$inst_no = "Final ";
									}
									// elseif(count($payment_details) + 1 == 3){
									// 	$inst_no = "3rd ";
									// }
									// else{
									// 	$inst_no = (count($payment_details) + 1)."th ";
									// }
								?>
								<legend class="scheduler-border"><?php echo $inst_no; ?>Installment</legend>
								<div class="form-row control-group">
									<div class="form-group col-lg-4">
										<label>Scheme : <?php echo $requisition_details->scm_name; ?></label>
									</div>													
									<div class="form-group col-lg-4">
										<label>Executive Agency : <?php echo $requisition_details->vendor_name; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>Requisition Number : <?php echo $requisition_details->req_number; ?></label>
									</div>
									<div class="form-group col-lg-4">
										<label>District : <?php echo $requisition_details->district_name; ?></label>
									</div>
									<!-- <div class="form-group col-lg-4">
										<label>Subdivision : <?php //echo $requisition_details->subdiv_name; ?></label>
									</div> -->
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

									<?php
									// if(!empty($requisition_progress_details)){
									if($requisition_details->req_approval == 1){
										?>

										<div class="form-group col-lg-4">
										<label>Request Amount: <?php echo $requisition_progress_details->reqp_balance_amount_request;  ?></label>
										</div>

										<?php
									}
									elseif($requisition_details->req_approval == 2){?>
								
										<div class="form-group col-lg-4">
											<label>Request Amount: <?php echo $requisition_progress_details->reqp_final_amount_request;  ?></label>
										</div>
								
										<?php
									}
									?>

								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Memo No.</label>
										<input type="text" placeholder="Memo Number" class="form-control " id="paymnt_memo_no">
										<small class="text-error paymnt_memo_no"><?php echo form_error('paymnt_memo_no'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Memo Date</label>
										<input type="date" class="form-control " id="paymnt_memo_date" >
										<small class="text-error paymnt_memo_date"><?php echo form_error('paymnt_memo_date'); ?></small>
									</div>									
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label><?php echo $inst_no; ?> Installment Amount (₹)</label>
										<!-- <input type="text" placeholder="Ammount" class="form-control " id="paymnt_amount" value="<?php //echo number_format((($installment_details[count($payment_details)-1]->scd_percent_amount)*($requisition_details->req_final_amount)/100), 2, '.', ''); ?>"> -->
										<input type="number" placeholder="Amount(₹)" class="form-control " id="paymnt_amount" >
										<small class="text-error paymnt_amount"><?php echo form_error('paymnt_amount'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Sanction Order</label>
										<input type="file" class="form-control " id="paymnt_sanction_order_doc">
										<small class="text-error paymnt_sanction_order_doc"><?php echo form_error('paymnt_sanction_order_doc'); ?></small>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Cheque No.</label>
										<input type="text" placeholder="Cheque Number" class="form-control " id="paymnt_cheque_no" >
										<small class="text-error paymnt_cheque_no"><?php echo form_error('paymnt_cheque_no'); ?></small>
									</div>
									<div class="form-group col-lg-6">
										<label>Cheque Date</label>
										<input type="date" class="form-control " id="paymnt_cheque_date" >
										<small class="text-error paymnt_cheque_date"><?php echo form_error('paymnt_cheque_date'); ?></small>
									</div>
								</div>
								<div class="form-row control-group">
									
									<div class="form-group col-lg-6">
										<label></label>
										<input type="hidden" class="form-control paymnt_req_id" id="paymnt_req_id" value="<?php echo $requisition_details->req_id; ?>">
										<input type="hidden" class="form-control paymnt_installment_no" id="paymnt_installment_no" value="<?php echo (count($payment_details) + 1); ?>">
										<input type="hidden" class="form-control paymnt_balanc_amt" id="paymnt_balanc_amt" value="<?php echo $balanc_amt; ?>">
		
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
		var paymnt_req_id = $('#paymnt_req_id').val().trim();
		var paymnt_installment_no = $('#paymnt_installment_no').val().trim();
		var paymnt_memo_no = $('#paymnt_memo_no').val().trim();
		var paymnt_memo_date = $('#paymnt_memo_date').val().trim();
		var paymnt_amount = $('#paymnt_amount').val().trim();
		var paymnt_balanc_amt = $('#paymnt_balanc_amt').val().trim();
		var paymnt_cheque_no = $('#paymnt_cheque_no').val().trim();
        var paymnt_cheque_date = $('#paymnt_cheque_date').val().trim();
        var files = $('#paymnt_sanction_order_doc')[0].files;


		//========== Req Id Input Validation ===================
		if(paymnt_req_id == ""){
			e_error = 1;
		}
 
		//========== Payment Installment Input Validation ===================
		if(paymnt_installment_no == ""){
			e_error = 1;
		}
		// else if(paymnt_installment_no > paymnt_installment_total){
		//     e_error = 1;
		// }

		//========== Memo Number Input Validation ===================
		if(paymnt_memo_no == ""){
			e_error = 1;
			$('.paymnt_memo_no').html('Memo Number is Required.');
		}
		else{
			if(!paymnt_memo_no.match(alphanumerics_no)){
				e_error = 1;
				$('.paymnt_memo_no').html('Memo Number not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.paymnt_memo_no').html('');
			}
		}

		//========== Memo Date Input Validation ===================
		if(paymnt_memo_date == ""){
			e_error = 1;
			$('.paymnt_memo_date').html('Memo Date is Required.');
		}
		else{
			$('.paymnt_memo_date').html('');
		}

		//========== Payment Ammount Validation ===================
		if(paymnt_amount == ""){
			e_error = 1;
			$('.paymnt_amount').html('Ammount is Required.');
		}
		else if(!paymnt_amount.match(onlynumerics_withdot)){
			e_error = 1;
			$('.paymnt_amount').html('Only Numerics and Dot are allowed.');
		}
		else if(parseFloat(paymnt_amount) > parseFloat(paymnt_balanc_amt)){
			e_error = 1;
			$('.paymnt_amount').html('Amount should not more than '+ parseFloat(paymnt_balanc_amt) +'.');
		}
		else{
			$('.paymnt_amount').html('');	
		}

		//========== Cheque Number Input Validation ===================
		if(paymnt_cheque_no == ""){
			e_error = 1;
			$('.paymnt_cheque_no').html('Cheque Number is Required.');
		}
		else{
			if(!paymnt_cheque_no.match(alphanumerics_no)){
				e_error = 1;
				$('.paymnt_cheque_no').html('Cheque Number not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.paymnt_cheque_no').html('');
			}
		}

		//========== Cheque Date Input Validation ===================
		if(paymnt_cheque_date == ""){
			e_error = 1;
			$('.paymnt_cheque_date').html('Cheque Date is Required.');
		}
		else{
			$('.paymnt_cheque_date').html('');
		}

		//========== Sanction Order Doc. Input Validation ===================
		if(document.getElementById("paymnt_sanction_order_doc").files.length == 0){
			e_error = 1;
			$('.paymnt_sanction_order_doc').html('Sanction Order is Required.');
		}
		else{
			var fileInput = document.getElementById('paymnt_sanction_order_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.paymnt_sanction_order_doc').html('Upload File type Invalid.(Use PDF/JPEG/JPG/PNG only)');
			}
			else{
				$('.paymnt_sanction_order_doc').html('');
			}
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
			
			var conf_answer = confirm("Are you sure you want to Submit?");
			if (conf_answer) {

				var form_data = new FormData();
                form_data.append('paymnt_installment_no',paymnt_installment_no);
                form_data.append('paymnt_amount', paymnt_amount);
                form_data.append('paymnt_memo_no', paymnt_memo_no);
                form_data.append('paymnt_memo_date', paymnt_memo_date);
				form_data.append('paymnt_cheque_no', paymnt_cheque_no);
                form_data.append('paymnt_cheque_date', paymnt_cheque_date);
                form_data.append('paymnt_req_id', paymnt_req_id);
                form_data.append("files", files[0]);

				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
                    url: '<?php echo base_url() . "admincontrol/requisition/requisition_installment_payment"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						if (data.msg == 1) {
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Installment Payment is Processed Successfully.');
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