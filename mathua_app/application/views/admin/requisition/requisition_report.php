<?php $this->load->view('admin/component/header') ?>

<style>
	.text-error { color: red;}
</style>

<div class="home pb-5">			
	<div class="container-fluid">	
		<div class="row">
			<div class="col-md-12 mt-5">
				<div class="widget-area-2 proclinic-box-shadow mb-3">
                    <h3 class="widget-title">Scheme Requisition Report</h3>

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
						<div class="form-row control-group">
							<div class="form-group col-lg-2">
								<label>From Date</label>
								<input type="date" class="form-control " id="rpot_from_date" >
								<small class="text-error rpot_from_date"><?php echo form_error('rpot_from_date'); ?></small>
							</div>
							<div class="form-group col-lg-2">
								<label>To Date</label>
								<input type="date" class="form-control " id="rpot_to_date" >
								<small class="text-error rpot_to_date"><?php echo form_error('rpot_to_date'); ?></small>
							</div>
							<div class="form-group col-lg-2">
								<label>Choose Scheme</label>
								<select class="form-control" id="rpot_schm_id">
									<option value="ALL">---All---</option>
									<?php
									foreach($all_active_scheme as $active_scheme){?>
										<option value="<?php echo $active_scheme->scm_id; ?>"><?php echo $active_scheme->scm_name; ?></option>
										<?php
									}?>
								</select>
								<small class="text-error rpot_schm_id"><?php echo form_error('rpot_schm_id'); ?></small>
							</div>	
							<div class="form-group col-lg-2">
								<label>District</label>
								<select class="form-control" name="u_district" id="rpot_dist" autocomplete="off">
									<option value="ALL">---All---</option>
									<?php foreach($dist_list as $dist_item){ ?>
									<option value="<?php echo $dist_item->district_code; ?>" <?php echo  set_select('u_district', $dist_item->district_code); ?>><?php echo $dist_item->district_name; ?></option>
									<?php } ?>
								</select>
								<small class="text-error rpot_dist"><?php echo form_error('rpot_dist'); ?></small>
							</div>	
							<div class="form-group col-lg-2">
								<label></label>
								<button type="button" onclick="gotoReportClickButton();" class="btn btn-primary d-block ml-lg-auto gofinalsubmit">Get Report</button>
							</div>								
						</div>
					</fieldset>
						
					<?php
					// if(!empty($requisition_report_data_arr)){
					?>
						<div class="table-responsive mb-3" id="table_div" style="display:none">
							<table id="tableId" class="table table-bordered table-striped">
								<thead>
									<tr>												
										<th>Sl.No.</th>
										<th>Requisition No.</th>
										<th>Scheme Memo No & Date</th>
										<th>Name of the schemes with location</th>
                                        <th>Executive Agency</th>
                                        <th>Approval (Yes/No)</th>
										<th>Estimated Cost</th>
										<th>Vetted Cost</th>
										<th>Sub-alloted amount part-I</th>
										<th>To whom sub-alloted</th>
										<th>Cheque no & date</th>
										<th>Residual amount</th>
										<th>Sub-alloted amount part-II</th>
										<th>Cheque no & date</th>
										<th>Sub-alloted amount part-III</th>
										<th>Cheque no & date</th>
										<th>Details</th>
									</tr>
								</thead>
								<tbody id="report_table_body">
									<?php
                                    // foreach($requisition_report_data_arr as $requisition_data){
                                        ?>
										<!-- <tr>												
											<td><?php //echo $requisition_data['slno']; ?></td>
											<td><?php //echo $requisition_data['req_number']; ?></td>
											<td><?php //echo $requisition_data['req_s_memo_no'] .'<br>'.$requisition_data['req_s_memo_date']; ?></td>
											<td><?php //echo $requisition_data['scm_name']; ?></td>
											<td><?php //echo $requisition_data['block_name'] .'<br>'. $requisition_data['district_name']; ?></td>
											<td><?php //if($requisition_data['req_approval'] > 0){ echo 'Yes'; }else{ echo 'No'; } ?></td>
											<td><?php //echo $requisition_data['req_approx_amount']; ?></td>
											<td><?php //echo $requisition_data['req_final_amount']; ?></td>
											<td><?php //echo $requisition_data['pay_1_amount']; ?></td>
											<td><?php //echo $requisition_data['block_name'] .'<br>'. $requisition_data['district_name']; ?></td>
											<td><?php //echo $requisition_data['pay_1_chq_no'] .'<br>'. $requisition_data['pay_1_chq_dt']; ?></td>
											<td><?php //echo $requisition_data['req_final_amount'] - $requisition_data['pay_1_amount']; ?></td>
											<td><?php //echo $requisition_data['pay_2_amount']; ?></td>
											<td><?php //echo $requisition_data['pay_2_chq_no'] .'<br>'. $requisition_data['pay_2_chq_dt']; ?></td>
											<td><?php //echo $requisition_data['pay_3_amount']; ?></td>
											<td><?php //echo $requisition_data['pay_3_chq_no'] .'<br>'. $requisition_data['pay_3_chq_dt']; ?></td>
											<td><?php //echo '<a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data['req_id'].'" class="btn btn-info" type="button" target="_blank">Details</a>'; ?></td>
											
										</tr> -->
										<?php
                                    // }
                                    ?>
								</tbody>
                            </table>	                                
						</div>
					<?php
					// }
					?>
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

	function gotoReportClickButton() {

		// $('.div_roller_total').fadeIn();
		// $('.gofinalsubmit').attr("disabled", "disabled");
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
		//========== Requisition Approval for D.M. Office Form Input Get Values ===================
		var rpot_from_date = $('#rpot_from_date').val().trim();
		var rpot_to_date = $('#rpot_to_date').val().trim();
		var rpot_schm_id = $('#rpot_schm_id').val().trim();
		var rpot_dist = $('#rpot_dist').val().trim();
		
		//========== From Date Input Validation ===================
		if(rpot_from_date == ""){
			e_error = 1;
			$('.rpot_from_date').html('From Date is Required.');
		}else{
			if(isDatecheck(rpot_from_date)){
				e_error = 1;
				$('.rpot_from_date').html('Invalid Date, Check again.');
			}else{
				$('.rpot_from_date').html('');
			}	
		}
		//========== To Date Input Validation ==================
		if(rpot_to_date == ""){
			e_error = 1;
			$('.rpot_to_date').html('To Date is Required.');
		}else{
			if(isDatecheck(rpot_to_date)){
				e_error = 1;
				$('.rpot_to_date').html('Invalid Date, Check again.');
			}else{
				$('.rpot_to_date').html('');
			}	
		}
		//========== Scheme Input Validation ===================
		if(rpot_schm_id != ""){
			if(!rpot_schm_id.match(alphanumerics)){
				e_error = 1;
				$('.rpot_schm_id').html('Invalid Scheme');
			}else{
				$('.rpot_schm_id').html('');
			}
		}
		//========== Scheme Input Validation ===================
		if(rpot_dist != ""){
			if(!rpot_dist.match(alphanumerics)){
				e_error = 1;
				$('.rpot_dist').html('Invalid District');
			}else{
				$('.rpot_dist').html('');
			}
		}
	

		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.dm_error_total').html(error_message);
			$(".dm_error_total").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total, .dm_error_total').fadeOut();
			}, delay);
		} 
		else {
			// var conf_answer = confirm("Are you sure you want to Get Report?");
			// if (conf_answer) {
				function buildSelectLists() {
  
					$('#example').DataTable().columns().every(function() {
						var column = this;

						var select = $('<select><option value=""></option></select>')
						.appendTo($(column.footer()).empty())
						.on('change', function() {

							var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
							);
							column
							.search(val ? '^' + val + '$' : '', true, false)
							.draw();
						});

						column.data().unique().sort().each(function(d, j) {
						select.append('<option value="' + d + '">' + d + '</option>')
						});
					});
				}
				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/requisition/requisition_report"; ?>',
					data: {
						rpot_from_date: rpot_from_date,
						rpot_to_date: rpot_to_date,
						rpot_schm_id: rpot_schm_id,
						rpot_dist: rpot_dist
					},
					dataType: 'JSON',
					success: function(data) {
						$('#report_table_body').empty();
						if (data.msg == 1) {
							// $('.div_roller_total').fadeOut();
							// $('.dm_success_total').html('Requisition is Processed Successfully.');
							// $(".dm_success_total").fadeIn();
							// $('input, select').val('');
							// $('input').html('');
							// let t_row = "";
							// let total_data_arr = data.data_arr;
							// for(var i=0; i<=total_data_arr.length; i++){
							// 	let req_apprv = "";
							// 	if(total_data_arr[i].req_approval > 0){
							// 		req_apprv = 'Yes';
							// 	}else{
							// 		req_apprv = 'No';
							// 	}
							// 	t_row = "";
							// 	t_row = '<tr class="report_table_row"><td>'+total_data_arr[i].slno+'</td><td>'+total_data_arr[i].req_number+'</td><td>'+total_data_arr[i].req_s_memo_no+'<br>'+total_data_arr[i].req_s_memo_date+'</td><td>'+total_data_arr[i].scm_name+'</td><td>'+total_data_arr[i].block_name+'<br>'+total_data_arr[i].district_name+'</td><td>'+req_apprv+'</td><td>'+total_data_arr[i].req_approx_amount+'</td><td>'+total_data_arr[i].req_final_amount+'</td><td>'+total_data_arr[i].pay_1_amount+'</td><td>'+total_data_arr[i].block_name+'<br>'+total_data_arr[i].district_name+'</td><td>'+total_data_arr[i].pay_1_chq_no+'<br>'+total_data_arr[i].pay_1_chq_dt+'</td><td>'+(total_data_arr[i].req_final_amount - total_data_arr[i].pay_1_amount)+'</td><td>'+total_data_arr[i].pay_2_amount+'</td><td>'+total_data_arr[i].pay_2_chq_no+'<br>'+total_data_arr[i].pay_2_chq_dt+'</td><td>'+total_data_arr[i].pay_3_amount+'</td><td>'+total_data_arr[i].pay_3_chq_no+'<br>'+total_data_arr[i].pay_3_chq_dt+'</td><td><a href="'+'<?php //base_url("admincontrol/requisition/installment_payment_details")?>'+'/'+total_data_arr[i].req_id+'" class="btn btn-info" type="button" target="_blank">Details</a></td></tr>';
							// 	$('#report_table_body').append(t_row);
							// }

							// if ($.fn.DataTable.isDataTable('#report_table_body')) {
                            // 	$('#report_table_body').DataTable().destroy();
							// }

							// $('#report_table_body tbody').empty();

							// $('#tableId').DataTable({ 
							// 	"destroy": true, //use for reinitialize datatable
							// 	"pagingType": "full_numbers",
							// 	"searching": true
							// });

							// var table = $('#tableId').DataTable();
							// table.clear();

							$('#report_table_body').append(data.data_arr);

							// buildSelectLists();
							// table.draw();

							//$('#tableId').DataTable('REFRESH');
							// $('#tableId').DataTable();
							

							$("#table_div").show();
							
						} 
						else {
							$('.div_roller_total').fadeOut();
							$('.gofinalsubmit').attr("disabled", false);
							error_message = "There have some problem to Store Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.dm_error_total').html(error_message);
							$(".dm_error_total").fadeIn();
							setTimeout(function() {
								$('.dm_error_total').fadeOut();
							}, delay);
						}
					}
				});

			// } 
			// else {
			// 	$('.div_roller_total').fadeOut();
			// 	$('.gofinalsubmit').attr("disabled", false);
			// }
		}
	}


	

</script>