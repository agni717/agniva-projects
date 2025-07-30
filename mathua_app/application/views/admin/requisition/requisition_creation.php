<?php $this->load->view('admin/component/header') ?>

<style>
	.text-error { color: red;}
</style>

<div class="home pb-5">
	<div class="container">
		<div class="row">						
			<div class="col-lg-10 m-auto" >
				<div class="widget-area-2 proclinic-box-shadow">
					<h3 class="widget-title">Scheme Requisition Create By Chairperson/Admin</h3>
					<!-- <form> -->
                    <?php echo form_open_multipart('', 'class="form-horizontal" id="reqForm"'); ?>
					<?php 
                    if (isset($error)) { ?>
					    <div class="alert alert-error alert-danger">                
						    <h4>Error!</h4>
						    <?php echo $error; ?>
					    </div>
					    <?php 
                    } ?>

					<div class="form-row control-group">
                        <div class="form-group col-lg-12">
							<label>Choose Scheme</label>
							<select class="form-control" id="schm_id">
								<option value="">---Select---</option>
								<?php
								foreach($all_active_scheme as $active_scheme){?>
									<option value="<?php echo $active_scheme->scm_id; ?>"><?php echo $active_scheme->scm_name; ?></option>
									<?php
								}?>
							</select>
                            <small class="text-error schm_id"><?php echo form_error('schm_id'); ?></small>
						</div>
						<!-- <div class="form-group col-lg-6">
							<label>Requisition Details</label>
							<textarea class="form-control" rows="1" id="req_details"></textarea>
							<small class="text-error req_details"><?php //echo form_error('req_details'); ?></small>
						</div> -->
					</div>
					<div class="form-row control-group">
						<div class="form-group col-lg-6">
							<label>Board Memo No.</label>
							<input type="text" placeholder="Board Memo Number" class="form-control" name="req_board_memo_no" id="req_board_memo_no">
							<small class="text-error req_board_memo_no"><?php echo form_error('req_board_memo_no'); ?></small>
						</div>
						<div class="form-group col-lg-6">
							<label>Board Memo Date</label>
							<input type="date" class="form-control" name="req_board_memo_date" id="req_board_memo_date">
							<small class="text-error req_board_memo_date"><?php echo form_error('req_board_memo_date'); ?></small>
						</div>								
					</div>
					<div class="form-row control-group">
						<div class="form-group col-lg-6">
							<label>Approx. Amount</label>
							<input type="number" placeholder="Approx. Amount" class="form-control" name="req_approx_amount" id="req_approx_amount">
							<small class="text-error req_approx_amount"><?php echo form_error('req_approx_amount'); ?></small>
						</div>
						<div class="form-group col-lg-6">
							<label>Recommendation Letter Upload</label>
							<input type="file" class="form-control" name="req_recom_lettr_uplo_doc" id="req_recom_lettr_uplo_doc">
							<small class="text-error req_recom_lettr_uplo_doc"><?php echo form_error('req_recom_lettr_uplo_doc'); ?></small>
						</div>								
					</div>
					<div class="form-row control-group">
						<div class="form-group col-lg-4">
							<label>District</label>
							<select class="form-control" id="district_select">
								<option value="">---Select---</option>
								<?php
								foreach($all_active_district as $active_district){?>
									<option value="<?php echo $active_district->district_code ; ?>"><?php echo $active_district->district_name; ?></option>
									<?php
								}?>
							</select>
							<small class="text-error district_select"><?php echo form_error('district_select'); ?></small>
						</div>
						<!-- <div class="form-group col-lg-6">
							<label>Subdivision</label>
							<select class="form-control" id="subdivision_select">
								<option value="">---Select---</option>
							</select>
							<small class="text-error subdivision_select"><?php //echo form_error('subdivision_select'); ?></small>
						</div> -->
						<div class="form-group col-lg-4">
							<label>Block/Municipality</label>
							<select class="form-control" id="block_select">
								<option value="">---Select---</option>
							</select>
							<small class="text-error block_select"><?php echo form_error('block_select'); ?></small>
						</div>
						<div class="form-group col-lg-4">
							<label>Gram Panchayat</label>
							<input type="text" placeholder="Gram Panchayat Name" class="form-control" name="req_gram_panchayat_name" id="req_gram_panchayat_name">
							<small class="text-error req_gram_panchayat_name"><?php echo form_error('req_gram_panchayat_name'); ?></small>
						</div>
					</div>
					<div class="form-row control-group">
						<div class="form-group col-lg-6">
							<label>Scheme Memo No.</label>
							<input type="text" placeholder="Scheme Memo Number" class="form-control" name="req_scheme_memo_no" id="req_scheme_memo_no">
							<small class="text-error req_scheme_memo_no"><?php echo form_error('req_scheme_memo_no'); ?></small>
						</div>
						<div class="form-group col-lg-6">
							<label>Scheme Memo Date</label>
							<input type="date" placeholder="Board Memo Date" class="form-control" name="req_scheme_memo_date" id="req_scheme_memo_date">
							<small class="text-error req_scheme_memo_date"><?php echo form_error('req_scheme_memo_date'); ?></small>
						</div>								
					</div>
					<!-- <div class="form-row control-group">
						<div class="form-group col-lg-6">
							<label>Quantity</label>
							<input type="text" placeholder="contact" class="form-control" name="req_quantity" id="req_quantity">
							<small class="text-error req_quantity"><?php //echo form_error('req_quantity'); ?></small>
						</div>
						<div class="form-group col-lg-6">
							<label>Unit of Measurment</label>
							<input type="text" placeholder="Unit of Measurment" class="form-control" name="req_uom" id="req_uom">
							<small class="text-error req_uom"><?php //echo form_error('req_uom'); ?></small>
						</div>								
					</div> -->
					<!-- <div class="form-row control-group"> -->

						<!-- <div class="form-group col-lg-6">
							<label>Block</label>
							<select class="form-control" id="block_select">
								<option value="">---Select---</option>
							</select>
							<small class="text-error block_select"><?php //echo form_error('block_select'); ?></small>
						</div>	 -->
						<!-- <div class="form-group col-lg-6">
							<label>Location</label>
							<input type="text" placeholder="Location" class="form-control" name="req_location" id="req_location">
							<small class="text-error req_location"><?php //echo form_error('req_location'); ?></small>
						</div>	 -->
					<!-- </div> -->
					<div class="form-row control-group">	
						<!-- <div class="form-group col-lg-6">
							<label>Amount</label>
							<input type="number" placeholder="amount" class="form-control" name="req_amount" id="req_amount" value="">
							<small class="text-error req_amount"><?php //echo form_error('req_amount'); ?></small>
						</div> -->
						<div class="form-group col-lg-6">
							<label>Scheme Details</label>
							<textarea class="form-control" rows="1" id="req_scheme_details"></textarea>
							<small class="text-error req_scheme_details"><?php echo form_error('req_scheme_details'); ?></small>
						</div>
						<div class="form-group col-lg-6">
							<label>Implementation Letter Upload</label>
							<input type="file" class="form-control" name="req_imple_lettr_uplo_doc" id="req_imple_lettr_uplo_doc">
							<small class="text-error req_imple_lettr_uplo_doc"><?php echo form_error('req_imple_lettr_uplo_doc'); ?></small>
						</div>
					</div>	
					<div class="form-row control-group">
						<div class="form-group col-lg-6 text-right">
							<label></label>
							<!-- <input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto"> -->
							<button type="button" onclick="gotoclclickbutton();" class="btn btn-primary gofinalsubmit">Submit</button>
						</div>
					</div>
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

	$('#district_select').on('change', function() {
		dist_id = this.value;
		$.ajax({
			method: 'POST',
			url: '<?php echo base_url() . "admincontrol/requisition/get_block_list_by_district_id"; ?>',
			data:{
				dist_id: dist_id, 
			},
			dataType: 'JSON',
			success: function(data) {
				$('.block_option').remove();
				if (data.flag == 1) {
					var block_data_arr = data.block_arr;
					for(var i=0; i<block_data_arr.length; i++){
						$('#block_select').append('<option class="block_option" value="'+block_data_arr[i]['block_id']+'">'+block_data_arr[i]['block_name']+'</option>');
					}
				}
			}
		});
	});

    function gotoclclickbutton() {
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
		//========== Scheme Creation Form Input Get Values ===================
		var schm_id = $('#schm_id').val();
		var req_board_memo_no = $('#req_board_memo_no').val().trim();
		var req_board_memo_date = $('#req_board_memo_date').val().trim();
		var req_approx_amount = $('#req_approx_amount').val().trim();
		var files = $('#req_recom_lettr_uplo_doc')[0].files;
		var district_select = $('#district_select').val().trim();
		var block_select = $('#block_select').val().trim();
		var req_gram_panchayat_name = $('#req_gram_panchayat_name').val().trim();
		var req_scheme_memo_no = $('#req_scheme_memo_no').val().trim();
		var req_scheme_memo_date = $('#req_scheme_memo_date').val().trim();
		var req_scheme_details = $('#req_scheme_details').val().trim();
		var files2 = $('#req_imple_lettr_uplo_doc')[0].files;
		//========== Choose Scheme Input Validation ===================
		if(schm_id == ""){
			e_error = 1;
			$('.schm_id').html('Choose Scheme is Required.');
		}else{
		    $('.schm_id').html('');
		}
		//========== Board Memo No. Input Validation ===================
		if(req_board_memo_no == ""){
			e_error = 1;
			$('.req_board_memo_no').html('Board Memo No. is Required.');
		}else{
			if(!req_board_memo_no.match(alphanumerics_no)){
				e_error = 1;
				$('.req_board_memo_no').html('Board Memo No. not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.req_board_memo_no').html('');
			}
		}
		//========== Board Memo Date Input Validation ===================
		if(req_board_memo_date == ""){
			e_error = 1;
			$('.req_board_memo_date').html('Board Memo Date is Required.');
		}else{
			$('.req_board_memo_date').html('');	
		}
		//========== Approx. Amount Input Validation ===================
		if(Number(req_approx_amount) == ""){
			e_error = 1;
			$('.req_approx_amount').html('Approx. Amount is Required.');
		}else{
			if(!req_approx_amount.match(onlynumerics_withdot)){
				e_error = 1;
				$('.req_approx_amount').html('Only numbers & dot allwoed, Check again.');
			}else{
				$('.req_approx_amount').html('');
			}	
		}
		//========== Recommendation Letter Upload Input Validation ===================
		if(document.getElementById("req_recom_lettr_uplo_doc").files.length == 0){
			e_error = 1;
			$('.req_recom_lettr_uplo_doc').html('Recommendation Letter Upload is Required.');
		}else{
			var fileInput = document.getElementById('req_recom_lettr_uplo_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.req_recom_lettr_uplo_doc').html('Upload File type Invalid.');
			}else{
				$('.req_recom_lettr_uplo_doc').html('');
			}
		}
		//========== District Input Validation ===================
		if(district_select == ""){
			e_error = 1;
			$('.district_select').html('District is Required.');
		}else{
			$('.district_select').html('');
		}
        //========== Block/Municipality Input Validation ===================
		if(block_select == ""){
			e_error = 1;
			$('.block_select').html('Block/Municipality is Required.');
		}else{
			$('.block_select').html('');	
		}
        //========== Gram Panchayat Input Validation ===================
		if(req_gram_panchayat_name != ""){
            if(!req_gram_panchayat_name.match(alphanumerics_spaces)){
				e_error = 1;
				$('.req_gram_panchayat_name').html('Only alphaletters and spaces are allwoed, Check again.');
			}else{
				$('.req_gram_panchayat_name').html('');
			}
		}
		//========== Scheme Memo No. Input Validation ===================
		if(req_scheme_memo_no == ""){
			e_error = 1;
			$('.req_scheme_memo_no').html('Scheme Memo No. is Required.');
		}else{
			if(!req_scheme_memo_no.match(alphanumerics_no)){
				e_error = 1;
				$('.req_scheme_memo_no').html('Board Memo No. not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.req_scheme_memo_no').html('');
			}	
		}
		//========== Scheme Memo Date Input Validation ===================
		if(req_scheme_memo_date == ""){
			e_error = 1;
			$('.req_scheme_memo_date').html('Scheme Memo Date is Required.');
		}else{
			$('.req_scheme_memo_date').html('');	
		}
		//========== Scheme Details Input Validation ===================
		if(req_scheme_details == ""){
			e_error = 1;
			$('.req_scheme_details').html('Scheme Details is Required.');
		}else{
			$('.req_scheme_details').html('');	
		}

		//========== Upload Doc. Input Validation ===================
		if(document.getElementById("req_imple_lettr_uplo_doc").files.length == 0){
			e_error = 1;
			$('.req_imple_lettr_uplo_doc').html('Implementation Letter Upload is Required.');
		}else{
			var fileInput = document.getElementById('req_imple_lettr_uplo_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.req_imple_lettr_uplo_doc').html('Upload File type Invalid.');
			}else{
				$('.req_imple_lettr_uplo_doc').html('');
			}
		}
	

		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} 
		else {
			//alert(newhash);
			//alert(rehash);
			//$("#myForm").submit();
			var conf_answer = confirm("Are you sure you want to Submit the Data for New Scheme?");
			if (conf_answer) {

				var form_data = new FormData();
                form_data.append('schm_id',schm_id);
                form_data.append('req_board_memo_no', req_board_memo_no);
                form_data.append('req_board_memo_date', req_board_memo_date);
                form_data.append('req_approx_amount', req_approx_amount);
				form_data.append("files", files[0]);
                form_data.append('district_select', district_select);
                form_data.append('block_select', block_select);
                form_data.append('req_gram_panchayat_name', req_gram_panchayat_name);
				form_data.append('req_scheme_memo_no', req_scheme_memo_no);
				form_data.append('req_scheme_memo_date', req_scheme_memo_date);
				form_data.append('req_scheme_details', req_scheme_details);
                form_data.append("files2", files2[0]);

				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
                    url: '<?php echo base_url() . "admincontrol/requisition/requisition_entry_form_submit"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						if (data.msg == 1) {
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Requisition is Uploaded Successfully.');
							$(".get_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
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



	// $('#schm_id').on('change', function() {
    //     var scheme_id = this.value;
    //     $.ajax({
    //         method: 'POST',
    //         url: '<?php //echo base_url() . "admincontrol/requisition/get_scheme_amount"; ?>',
    //         data:{
    //             scheme_id: scheme_id, 
    //         },
    //         dataType: 'JSON',
    //         success: function(data) {
	// 			// console.log(data);
    //             // $('.subdiv_option').remove();
    //             // $('.block_option').remove();
    //             if (data.flag == 1) {
    //                 $('#req_amount').val(data.scheme_amount.scm_amount);
    //             }
    //         }
    //     });
    // });

    // $('#district_select').on('change', function() {
    //     dist_id = this.value;
    //     $.ajax({
    //         method: 'POST',
    //         url: '<?php //echo base_url() . "admincontrol/requisition/get_subdivision_list"; ?>',
    //         data:{
    //             dist_id: dist_id, 
    //         },
    //         dataType: 'JSON',
    //         success: function(data) {
    //             $('.subdiv_option').remove();
    //             $('.block_option').remove();
    //             if (data.flag == 1) {
    //                 var subdiv_data_arr = data.subdivision_arr;
    //                 for(var i=0; i<subdiv_data_arr.length; i++){
    //                     $('#subdivision_select').append('<option class="subdiv_option" value="'+subdiv_data_arr[i]['subdiv_id']+'">'+subdiv_data_arr[i]['subdiv_name']+'</option>');
    //                 }
    //             }
    //         }
    //     });
    // });


    // $('#subdivision_select').on('change', function() {
    //     subdiv_id = this.value;
    //     $.ajax({
    //         method: 'POST',
    //         url: '<?php //echo base_url() . "admincontrol/requisition/get_block_list"; ?>',
    //         data:{
    //             subdiv_id: subdiv_id, 
    //         },
    //         dataType: 'JSON',
    //         success: function(data) {
        
    //             $('.block_option').remove();
    //             if (data.flag == 1) {
    //                 var block_data_arr = data.block_arr;
    //                 for(var i=0; i<block_data_arr.length; i++){
    //                     $('#block_select').append('<option class="block_option" value="'+block_data_arr[i]['block_id']+'">'+block_data_arr[i]['block_name']+'</option>');
    //                 }

    //             }
    //         }
    //     });
    // });

	

</script>