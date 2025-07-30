<?php $this->load->view('admin/component/header') ?>
<?php //print_r($requisition_data_arr); ?>
<?php
    // echo '<pre>';
    // print_r($all_active_scheme);
    // echo $all_active_scheme[0]->scm_name;
?>

<style>
	.text-error { color: red;}
</style>

<div class="home pb-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                    <h3 class="widget-title">Requisition List</h3>
						<div class="table-responsive mb-3">
							<table id="tableId" class="table table-bordered table-striped">
								<thead>
									<tr>												
										<th>Sl.No.</th>
										<th>Requisition No</th>
										<th>Scheme Name</th>
										<th>Scheme Details</th>
                                        <th>District</th>
                                        <th>Block/Municipality</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

									<?php

									if(!empty($requisition_data_arr)){
									
									$slno = 1;
                                    foreach($requisition_data_arr as $requisition_data){

                                        ?>

										<tr>												
											<td><?php echo $slno++; ?></td>
											<td><?php echo $requisition_data->req_number; ?></td>
											<td><?php echo $requisition_data->scm_name; ?></td>
											<td><?php echo $requisition_data->req_details; ?></td>
											<td><?php echo $requisition_data->district_name; ?></td>
											<td><?php echo $requisition_data->block_name; ?></td>

											<?php

											$user_typ = $this->session->userdata('utype');

											if($user_typ == 1 || $user_typ == 2){   //=========== ADMIN VIEW =============

												if($requisition_data->req_initiate == 0){
													echo '<td style="color: red;">Not Checked</td>';
													echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
												} 
												else if($requisition_data->req_initiate == 1) {
													echo '<td><span style="color: green;">Estimate Uploaded</span>, <span style="color: #9d9d9d;">Photo Upload Pending</span></td>';
													echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
												}
												else if($requisition_data->req_initiate == 2) {

													if($requisition_data->req_approval == 0){
														echo '<td style="color: green;">Initiated & Photo Uploaded</td>';
														echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>                    <a href="'.base_url('admincontrol/requisition/pay_installment').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button">Pay</a></td>';

													}
													else if($requisition_data->req_approval == 1){

														if($requisition_data->req_progress_flag == 0){
															echo '<td> <span style="color: green;">1st Installment Payment Done </span>, <span style="color: #9d9d9d;">WO Upload Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
															
														}
														elseif($requisition_data->req_progress_flag == 1){
															echo '<td> <span style="color: green;">Work Order Uploaded</span>, <span style="color: #9d9d9d;">Photo Upload Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
														}
														elseif($requisition_data->req_progress_flag == 2){
															echo '<td> <span style="color: green;">Work Order Submitted</span>, <span style="color: red;">Waiting For 2nd Payment</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>                    <a href="'.base_url('admincontrol/requisition/pay_installment').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button">Pay</a></td>';
														}
														
													}
													else if($requisition_data->req_approval == 2){

														if($requisition_data->req_progress_flag == 2){
															echo '<td> <span style="color: green;">2nd Installment Payment Done </span>, <span style="color: #9d9d9d;">Completion Report Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
															
														}
														elseif($requisition_data->req_progress_flag == 3){
															echo '<td> <span style="color: green;">Completion Report Uploaded</span>, <span style="color: #9d9d9d;">Photo Upload Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
														}
														elseif($requisition_data->req_progress_flag == 4){
															echo '<td> <span style="color: green;">Work Completed</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>                    <a href="'.base_url('admincontrol/requisition/pay_installment').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button">Pay</a></td>';
														}
													}
													else if($requisition_data->req_approval == 3){
														if($requisition_data->req_progress_flag == 4){
															echo '<td> <span style="color: green;">Scheme Completed.</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
															
														}
													}
												
												}
												
												


											} 
											else if($user_typ == 3)   //=========== BLOCK OFFICE VIEW =============
											{




												if($requisition_data->req_initiate == 0){
													echo '<td style="color: red;">Action Pending</td>';
													echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>           <a href="javascript:void(0)" onclick="gotoDmModalView('.$requisition_data->req_id.');" class="btn btn-info" data-toggle="modal" type="button">Process Now</a></td>';
												}
												else if($requisition_data->req_initiate == 1){
													echo '<td><span style="color: green;">Estimate Uploaded</span>, <span style="color: red;">Photo Upload Pending</span></td>';
													echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
												}
												else if($requisition_data->req_initiate == 2){
													
													if($requisition_data->req_approval == 0){
														echo '<td style="color: #9d9d9d;">Waiting For Approval</td>';
														echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
													}
													else if($requisition_data->req_approval == 1){

														if($requisition_data->req_progress_flag == 0){
															
															echo '<td> <span style="color: green;">1st Installment Payment Received</span>, <span style="color: red;">Action Pending</span> </td>';

															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>                               <a href="'.base_url('admincontrol/requisition/work_order_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button">WO Upload</a></td>';
														}
														elseif($requisition_data->req_progress_flag == 1){

															echo '<td> <span style="color: green;">Work Order Uploaded</span>, <span style="color: red;">Photo Upload Pending</span> </td>';

															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
														}
														elseif($requisition_data->req_progress_flag == 2){

															echo '<td><span style="color: green;">Work Order Submitted</span>, <span style="color: #9d9d9d;">Waiting For 2nd Payment</span> </td>';

															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
														}
													}
													else if($requisition_data->req_approval == 2){

														if($requisition_data->req_progress_flag == 2){

															echo '<td> <span style="color: green;">2nd Installment Payment Done </span>, <span style="color: red;">Action Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>                               <a href="'.base_url('admincontrol/requisition/work_completion_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button">Completion Report Upload</a></td>';
															
														}
														elseif($requisition_data->req_progress_flag == 3){

															echo '<td> <span style="color: green;">Completion Report Uploaded</span>, <span style="color: red;">Photo Upload Pending</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
														}
														elseif($requisition_data->req_progress_flag == 4){

															echo '<td> <span style="color: green;">Work Completed</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a>';
														}
													}
													else if($requisition_data->req_approval == 3){
														if($requisition_data->req_progress_flag == 4){
															echo '<td> <span style="color: green;">Scheme Completed.</span> </td>';
															echo '<td><a href="'.base_url('admincontrol/requisition/installment_payment_details').'/'.$requisition_data->req_id.'" class="btn btn-info" type="button" target="_blank">Details</a></td>';
															
														}
													}

												}


											}

											

											?>
											
											<!-- <td><a href="javascript:void(0)" onclick="gotoModalView(<?php //echo $requisition_data->req_id; ?>);" class="btn btn-info" data-toggle="modal" type="button"><span class="ti-fullscreen"></span></a></td> -->
											<!-- <td><a href="#approval" class="btn btn-info" data-toggle="modal" type="button"><span class="ti-fullscreen"></span></a></td> -->
	
											
										</tr>

										<?php
                                    }
									}
                                    ?>

								</tbody>
                            </table>	                                
						</div>
					</div>
				</div>
			</div>
		</div>



		<!-- ================================================================== Modal ================================================================= -->
		<div class="modal fade reqModal" id="approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" id="reqModal">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <h3 class="modal-title widget-title">Welfare Board Approval</h3>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
			      	<div class="modal-body">
		               	<!-- <form> -->
						<?php echo form_open_multipart('', 'class="form-horizontal" id="adminForm"'); ?>
					        <?php 
                            if (isset($error)) { ?>
					            <div class="alert alert-error alert-danger">                
						            <h4>Error!</h4>
						            <?php echo $error; ?>
					            </div>
					            <?php 
                            } ?>
		                  	<fieldset class="scheduler-border py-3">
		                     	<div class="col-lg-12">
			                        <div class="row">
			                           <div class="form-group col-lg-4 ">
			                              <label>Requisition No. : </label>
										  <small class="requi_modal_data" id="requi_no"></small>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Scheme Name. : </label>
										  <small class="requi_modal_data" id="requi_scheme_name"></small>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Requisition Details : </label>
										  <small class="requi_modal_data" id="requi_details"></small>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Block : </label>
										  <small class="requi_modal_data" id="requi_block"></small>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Subdivision : </label>
										  <small class="requi_modal_data" id="requi_subdivision"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>District : </label>
										  <small class="requi_modal_data" id="requi_district"></small>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Approx. Amount : </label>
										  <small class="requi_modal_data" id="requi_approx_amount"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Final Amount : </label>
										  <small class="requi_modal_data" id="requi_final_amount"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Executive Agency: </label>
										  <small class="requi_modal_data" id="requi_executive_agency"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Work Start Date: </label>
										  <small class="requi_modal_data" id="requi_work_start_date"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Work End Date: </label>
										  <small class="requi_modal_data" id="requi_work_end_date"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Days Required: </label>
										  <small class="requi_modal_data" id="requi_days_required"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Initiation Date : </label>
										  <small class="requi_modal_data" id="requi_initiation_date"></small>
			                           </div>
									   <div class="form-group col-lg-4 ">
			                              <label>Process Date: </label>
										  <small class="requi_modal_data" id="requi_process_date"></small>
			                           </div>
			                        </div>
		                     	</div>
		                  	</fieldset>
		                  	<div class="form-group col-lg-12 ">
		                     	<div class="row">
			                        <!-- <div class="col-lg-2"><label>Send To DM Office</label></div>
			                        <div class="col-lg-6">
			                           <select class="form-control">
			                              <option disabled selected>---Select---</option>
			                              <option>DM</option>
			                              <option>DM</option>
			                           </select>
			                        </div> -->
			                        <div class="col-lg-12">
			                           <label>Remarks :</label>
			                           <textarea rows="2" class="form-control" id="requi_remarks"></textarea>
									   <small class="text-error requi_remarks"><?php echo form_error('requi_remarks'); ?></small>
			                        </div>
			                        <div class="col-lg-12 text-center" id="approve_reject_btn_div">
										<!-- <button type="button" onclick="approveOnClick();" class="btn btn-info " name="requi_approve" id="requi_approve">Approve</button> -->
										<!-- <button type="button" onclick="rejectOnClick();" class="btn btn-warning " name="requi_reject" id="requi_reject">Reject</button> -->
			                           <!-- <input type="button" value="Approve" class="btn btn-info " name="requi_approve" id="requi_approve"> -->
			                           <!-- <input type="button" value="Reject" class="btn btn-warning " name="requi_reject" id="requi_reject"> -->
			                        </div>
		                     	</div>
		                  	</div>
		               	<!-- </form> -->
						<?php form_close(); ?>
						<div class="form-group">
							<div class="col-sm-12 text-center">
								<div align="center">
									<div class="requi_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="requi_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        	<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			      	</div>
			    </div>
		  	</div>
		</div>
	</div>

	<!-- ============================================================= DM Modal ======================================================= -->
	<div class="modal fade dmModal" id="dmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h3 class="modal-title widget-title">Scheme Initiation for Block/Municipality</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
				<div class="widget-area-2">
					<!-- <h3 class="widget-title">Requisition Approval for D.M. Office</h3> -->
					<!-- <form> -->
					<?php echo form_open_multipart('', 'class="form-horizontal" id="dmForm"'); ?>
					        <?php 
                            if (isset($error)) { ?>
					            <div class="alert alert-error alert-danger">                
						            <h4>Error!</h4>
						            <?php echo $error; ?>
					            </div>
					            <?php 
                            } ?>

						<fieldset class="scheduler-border py-3">
							<div class="col-lg-12">
							<div class="row">
								<div class="form-group col-lg-4 ">
									<label>Scheme No. : </label>
									<small class="requi_modal_data" id="dm_mod_requi_no"></small>
								</div>
								<div class="form-group col-lg-4 ">
									<label>Scheme Name. : </label>
									<small class="requi_modal_data" id="dm_mod_scheme_name"></small>
								</div>
								<div class="form-group col-lg-4 ">
									<label>Scheme Details : </label>
									<small class="requi_modal_data" id="dm_mod_requi_details"></small>
								</div>
								<div class="form-group col-lg-4 ">
									<label>District : </label>
									<small class="requi_modal_data" id="dm_mod_district"></small>
								</div>
								<!-- <div class="form-group col-lg-4 ">
									<label>Subdivision : </label>
									<small class="requi_modal_data" id="dm_mod_subdivision"></small>
								</div> -->
								<div class="form-group col-lg-4 ">
									<label>Block : </label>
									<small class="requi_modal_data" id="dm_mod_block"></small>
								</div>
								<div class="form-group col-lg-4 ">
									<label>Approx Cost : </label>
									<small class="requi_modal_data" id="dm_mod_approx_amount"></small>
								</div>
							</div>
							</div>
						</fieldset>



						<div class="form-row control-group">
							<div class="form-group col-lg-6">
								<label>Initiation Memo No.</label>
								<input type="text" class="form-control" placeholder="Memo Number" id="dm_mod_ini_memo_no" name="dm_mod_ini_memo_no">
								<small class="text-error dm_mod_ini_memo_no"><?php echo form_error('dm_mod_ini_memo_no'); ?></small>
							</div>
							<div class="form-group col-lg-6">
								<label>Initiation Memo Date</label>
								<input type="date" class="form-control" id="dm_mod_ini_memo_date" name="dm_mod_ini_memo_date">
								<small class="text-error dm_mod_ini_memo_date"><?php echo form_error('dm_mod_ini_memo_date'); ?></small>
							</div>
						</div>
				
						<div class="form-row control-group">
							<div class="form-group col-lg-6">
								<label>Vetted Estimated Cost</label>
								<input type="number" class="form-control" id="dm_mod_estimated_cost" name="dm_mod_estimated_cost">
								<small class="text-error dm_mod_estimated_cost"><?php echo form_error('dm_mod_estimated_cost'); ?></small>
							</div>
							<div class="form-group col-lg-6">
								<label>Vetted Estimated Paper Upload</label>
								<input type="file" class="form-control" id="dm_mod_estimate_doc" name="dm_mod_estimate_doc">
								<small class="text-error dm_mod_estimate_doc"><?php echo form_error('dm_mod_estimate_doc'); ?></small>
							</div>
						</div>
					
						<div class="form-row control-group">		                     
							<div class="form-group col-lg-6">
								<label>Initiate Letter Upload</label>
								<input type="file" class="form-control" id="dm_mod_ini_letter_doc" name="dm_mod_ini_letter_doc">
								<small class="text-error dm_mod_ini_letter_doc"><?php echo form_error('dm_mod_ini_letter_doc'); ?></small>
							</div>
							<div class="form-group col-lg-6">
								<label>Bank Passbook Upload</label>
								<input type="file" class="form-control" id="dm_mod_bank_passbook_doc" name="dm_mod_bank_passbook_doc">
								<small class="text-error dm_mod_bank_passbook_doc"><?php echo form_error('dm_mod_bank_passbook_doc'); ?></small>
							</div>
						</div>

						<div class="form-row control-group">
							<div class="form-group col-lg-12 text-right">
								<label></label>
								<!-- <input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto"> -->
								<input type="hidden" class="form-control" id="dm_mod_req_id" name="dm_mod_req_id">
								<button type="button" onclick="gotoDMclickbutton();" class="btn btn-primary gofinalsubmit">Submit</button>
							</div>
						</div>

					<?php form_close(); ?>
					<!-- </form> -->
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<div align="center">
								<div class="dm_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="dm_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
							</div>
						</div>
					</div>
					
				</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>


	<!-- ================================================================== Rejection Reason View Modal ================================================================= -->
	<div class="modal fade rejectionReasonModal" id="approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" id="rejectionReasonModal">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <h3 class="modal-title widget-title">Rejection Reason</h3>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
			      	<div class="modal-body">
						<div class="form-group col-lg-12 ">
							<div class="row">
								<div class="col-lg-12">
									<label>Remarks :</label>
									<div class="col-lg-12" id="rejection_reason_div">
									
									</div>
								</div>
							</div>
						</div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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


	function gotoModalView(requisition_id){
		//============ AJAX POST =================
		$.ajax({
			method: 'POST',
			url: '<?php echo base_url() . "admincontrol/requisition/get_requisition_modal_data"; ?>',
			data: {
				requisition_id: requisition_id
			},
			dataType: 'JSON',
			success: function(data) {
				// alert(data.msg);
				$('.approve_reject_btn_div').remove();
				$('.requi_modal_data').html('');
				if (data.msg == 1) {

					// alert('success');
					// console.log(data);
					//alert(data.msg[0].space_rate);
					// $('.div_roller_total').fadeOut();
					// $('.get_success_total').html('Advertisement is Uploaded Successfully.');
					// $(".get_success_total").fadeIn();
					// $('input, select').val('');
					// $('input').html('');
					// setTimeout(function() {
					// 	$('.get_success_total').fadeOut();
					// }, 3000);
					// setTimeout(function() {
					// 	window.location.replace("<?php //echo site_url('admincontrol/scheme_set/all_scheme_list') ?>");
					// }, 3000);

					$('#requi_no').html(data.req_data.req_number);
					$('#requi_scheme_name').html(data.req_data.scm_name); 
					$('#requi_details').html(data.req_data.req_details); 
					$('#requi_block').html(data.req_data.block_name); 
					$('#requi_subdivision').html(data.req_data.subdiv_name); 
					$('#requi_district').html(data.req_data.district_name); 
					$('#requi_approx_amount').html(data.req_data.req_approx_amount); 
					$('#requi_final_amount').html(data.req_data.req_final_amount); 
					$('#requi_executive_agency').html(data.req_data.vendor_name); 
					$('#requi_work_start_date').html(data.req_data.req_startdate);
					$('#requi_work_end_date').html(data.req_data.req_enddate);

					var date1 = new Date(data.req_data.req_startdate);
					var date2 = new Date(data.req_data.req_enddate);
					var Difference_In_Time = date2.getTime() - date1.getTime();
					var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

					$('#requi_days_required').html(Difference_In_Days);
					$('#requi_initiation_date').html(data.req_data.req_initiate_date); 
					$('#requi_process_date').html(data.req_data.req_process_date); 

					$('#approve_reject_btn_div').append('<button type="button" onclick="approveOnClick('+data.req_data.req_id+');" class="btn btn-info approve_reject_btn_div" name="requi_approve" id="requi_approve">Approve</button>'); 
					$('#approve_reject_btn_div').append('<button type="button" onclick="rejectOnClick('+data.req_data.req_id+');" class="btn btn-warning approve_reject_btn_div" name="requi_reject" id="requi_reject">Reject</button>'); 

					$('.reqModal').modal('show');

				} else {
					alert('error');
					// $('.div_roller_total').fadeOut();
					// $('.gofinalsubmit').attr("disabled", false);
					// error_message = "There have some problem to Store Data, Try after some time.";
					// error_message = error_message + "<br/>" + data.e_msg;
					// $('.get_error_total').html(error_message);
					// $(".get_error_total").fadeIn();
					// setTimeout(function() {
					// 	$('.get_error_total').fadeOut();
					// }, delay);
				}

			}
		});

	}


	function gotoDmModalView(requisition_id){
	
		//============ AJAX POST =================
		$.ajax({
			method: 'POST',
			url: '<?php echo base_url() . "admincontrol/requisition/get_dm_modal_data"; ?>',
			data: {
				requisition_id: requisition_id
			},
			dataType: 'JSON',
			// contentType: false,
			// processData: false,
			success: function(data) {
				// alert(data.msg);
				$('.requi_modal_data').html('');
				if (data.msg == 1) {

					// alert('success');
					// console.log(data);
					//alert(data.msg[0].space_rate);
					// $('.div_roller_total').fadeOut();
					// $('.dm_success_total').html('Advertisement is Uploaded Successfully.');
					// $(".dm_success_total").fadeIn();
					// $('input, select').val('');
					// $('input').html('');
					// setTimeout(function() {
					// 	$('.dm_success_total').fadeOut();
					// }, 3000);
					// setTimeout(function() {
					// 	window.location.replace("<?php //echo site_url('admincontrol/scheme_set/all_scheme_list') ?>");
					// }, 3000);

					$('#dm_mod_req_id').val(data.req_data.req_id);
					$('#dm_mod_requi_no').html(data.req_data.req_number);
					$('#dm_mod_scheme_name').html(data.req_data.scm_name); 
					$('#dm_mod_requi_details').html(data.req_data.req_details); 
					$('#dm_mod_block').html(data.req_data.block_name); 
					// $('#dm_mod_subdivision').html(data.req_data.subdiv_name); 
					$('#dm_mod_district').html(data.req_data.district_name); 
					$('#dm_mod_approx_amount').html(data.req_data.req_approx_amount); 
					// $('#requi_final_amount').html(data.req_data.req_final_amount); 
					// $('#requi_comment').html(data.req_data.req_initiate_msg); 

					$('.dmModal').modal('show');

				} else {
					alert('error');
					// $('.div_roller_total').fadeOut();
					// $('.gofinalsubmit').attr("disabled", false);
					// error_message = "There have some problem to Store Data, Try after some time.";
					// error_message = error_message + "<br/>" + data.e_msg;
					// $('.dm_error_total').html(error_message);
					// $(".dm_error_total").fadeIn();
					// setTimeout(function() {
					// 	$('.dm_error_total').fadeOut();
					// }, delay);
				}

			}
		});
		
	}

	function initiateButton(requisition_id){
		//============ AJAX POST =================
		$.ajax({
			method: 'POST',
			url: '<?php echo base_url() . "admincontrol/requisition/initiate_btn_on_click"; ?>',
			data: {
				requisition_id: requisition_id
			},
			dataType: 'JSON',
			success: function(data) {
				// alert(data.msg);
				
				if (data.msg == 1) {

					// alert('success');
					console.log(data);
					//alert(data.msg[0].space_rate);
					// $('.div_roller_total').fadeOut();
					// $('.get_success_total').html('Advertisement is Uploaded Successfully.');
					// $(".get_success_total").fadeIn();
					// $('input, select').val('');
					// $('input').html('');
					// setTimeout(function() {
					// 	$('.get_success_total').fadeOut();
					// }, 3000);
					// setTimeout(function() {
					window.location.replace("<?php echo site_url('admincontrol/requisition/requisition_list') ?>");
					// }, 3000);

				

				} else {
					alert('error');
					// $('.div_roller_total').fadeOut();
					// $('.gofinalsubmit').attr("disabled", false);
					// error_message = "There have some problem to Store Data, Try after some time.";
					// error_message = error_message + "<br/>" + data.e_msg;
					// $('.get_error_total').html(error_message);
					// $(".get_error_total").fadeIn();
					// setTimeout(function() {
					// 	$('.get_error_total').fadeOut();
					// }, delay);
				}

			}
		});
	}

	function approveOnClick(requisition_id){

		var conf_answer = confirm("Are you sure you want to Approve the Requisition?");
		if (conf_answer) {

			var e_error = 0;
			var requi_remarks = $('#requi_remarks').val().trim();
			// if(requi_remarks == ""){
			// 	e_error = 1;
			// 	$('.requi_remarks').html('Remarks is Required.');
			// 	setTimeout(function() {
			// 		$('.requi_remarks').html('');
			// 	}, 3000);
			// }else{
			// 	$('.requi_remarks').html('');
			// }

			

			if(!e_error){

				$('.div_roller_total').fadeIn();
				$('.approve_reject_btn_div').attr("disabled", true);

				$.ajax({
					method: 'POST',
					url: '<?php echo base_url("admincontrol/requisition/requisition_approve") ; ?>',
					data: {
						requisition_id: requisition_id,
						requi_remarks: requi_remarks
					},
					dataType: 'JSON',
					success: function(data) {
						// alert(data.msg);
						if (data.msg == 1) {
							// alert('success');
							// console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total').fadeOut();
							$('.requi_success_total').html('Approved Successfully.');
							$(".requi_success_total").fadeIn();
							// $('input, select').val('');
							// $('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/requisition/requisition_list') ?>");
							}, 3000);

							$('.reqModal').modal('hide');

						} else {
							// alert('error');
							$('.div_roller_total').fadeOut();
							$('.approve_reject_btn_div').attr("disabled", false);
							error_message = "There have some problem to Store Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.requi_error_total').html(error_message);
							$(".requi_error_total").fadeIn();
							setTimeout(function() {
								$('.requi_error_total').fadeOut();
							}, 3000);
						}

					}
				});
				
			}

			
		}
		
		
	}

	function rejectOnClick(requisition_id){
		var conf_answer = confirm("Are you sure you want to Approve the Requisition?");
		if (conf_answer) {

			var e_error = 0;

			var requi_remarks = $('#requi_remarks').val().trim();
			if(requi_remarks == ""){
				e_error = 1;
				$('.requi_remarks').html('Remarks is Required.');
				setTimeout(function() {
					$('.requi_remarks').html('');
				}, 3000);
			}else{
				$('.requi_remarks').html('');
			}

			if(!e_error){

				$('.div_roller_total').fadeIn();
				$('.approve_reject_btn_div').attr("disabled", true);

				$.ajax({
					method: 'POST',
					url: '<?php echo base_url("admincontrol/requisition/requisition_reject") ; ?>',
					data: {
						requisition_id: requisition_id,
						requi_remarks: requi_remarks
					},
					dataType: 'JSON',
					success: function(data) {
						// alert(data.msg);
						if (data.msg == 1) {
							// alert('success');
							// console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total').fadeOut();
							$('.requi_success_total').html('Approved Successfully.');
							$(".requi_success_total").fadeIn();
							// $('input, select').val('');
							// $('input').html('');
							setTimeout(function() {
								$('.requi_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/requisition/requisition_list') ?>");
							}, 3000);

							$('.reqModal').modal('hide');

						} else {
							// alert('error');
							$('.div_roller_total').fadeOut();
							$('.approve_reject_btn_div').attr("disabled", false);
							error_message = "There have some problem to Store Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.requi_error_total').html(error_message);
							$(".requi_error_total").fadeIn();
							setTimeout(function() {
								$('.requi_error_total').fadeOut();
							}, 3000);
						}

					}
				});
				
			}

			
		}
	}

    $('#district_select').on('change', function() {
        dist_id = this.value;
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "admincontrol/requisition/get_subdivision_list"; ?>',
            data:{
                dist_id: dist_id, 
            },
            dataType: 'JSON',
            success: function(data) {
                $('.subdiv_option').remove();
                $('.block_option').remove();
                if (data.flag == 1) {
                    var subdiv_data_arr = data.subdivision_arr;
                    for(var i=0; i<subdiv_data_arr.length; i++){
                        $('#subdivision_select').append('<option class="subdiv_option" value="'+subdiv_data_arr[i]['subdiv_id']+'">'+subdiv_data_arr[i]['subdiv_name']+'</option>');
                    }
                }
            }
        });
    });

    $('#subdivision_select').on('change', function() {
        subdiv_id = this.value;
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "admincontrol/requisition/get_block_list"; ?>',
            data:{
                subdiv_id: subdiv_id, 
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

    // function gotoclclickbutton() {

	// 	$('.div_roller_total').fadeIn();
	// 	$('.gofinalsubmit').attr("disabled", "disabled");

    //     //===================================================================
	// 	var delay = 8000;
	// 	var e_error = 0;
	// 	var error_message = 'There have some errors plese check above, Try again.';
	// 	var alphaletters_spaces = /^[A-Za-z ]+$/;
	// 	var alphaletters = /^[A-Za-z]+$/;
	// 	var alphanumerics = /^[A-Za-z0-9/() ]+$/;
	// 	var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
	// 	var alphanumerics_no = /^[A-Za-z0-9_/&(@%=<>)\[\]+;:.',\- ]+$/;
	// 	var onlynumerics = /^[0-9]+$/;
	// 	var onlynumerics_withdot = /^[0-9.]+$/;
	// 	var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
	// 	var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
	// 	var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    //     var allowedExtensions_only_pdf = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;

	// 	//========== Scheme Creation Form Input Get Values ===================
	// 	var schm_id = $('#schm_id').val();
	// 	var req_details = $('#req_details').val().trim();
	// 	var req_quantity = $('#req_quantity').val().trim();
	// 	var req_uom = $('#req_uom').val().trim();
	// 	var district_select = $('#district_select').val();
	// 	var block_select = $('#block_select').val();
    //     var subdivision_select = $('#subdivision_select').val();
    //     var req_location = $('#req_location').val().trim();
    //     var files = $('#req_uplo_doc')[0].files;
 
	// 	//========== Choose Scheme Input Validation ===================
	// 	if(schm_id == ""){
	// 		e_error = 1;
	// 		$('.schm_id').html('Choose Scheme is Required.');
	// 	}else{
	// 	    $('.schm_id').html('');
	// 	}

	// 	//========== Requisition Details Input Validation ===================
	// 	if(req_details == ""){
	// 		e_error = 1;
	// 		$('.req_details').html('Requisition Details is Required.');
	// 	}else{
	// 		$('.req_details').html('');	
	// 	}

	// 	//========== Quantity Input Validation ===================
	// 	if(Number(req_quantity) == ""){
	// 		e_error = 1;
	// 		$('.req_quantity').html('Quantity is Required.');
	// 	}else{
	// 		if(!req_quantity.match(onlynumerics)){
	// 			e_error = 1;
	// 			$('.req_quantity').html('Only numbers allwoed, Check again.');
	// 		}else{
	// 			$('.req_quantity').html('');
	// 		}	
	// 	}

	// 	//========== Unit of Measurment Input Validation ===================
	// 	if(req_uom == ""){
	// 		e_error = 1;
	// 		$('.req_uom').html('Unit of Measurment is Required.');
	// 	}else{
	// 		$('.req_uom').html('');
	// 	}

	// 	//========== District Input Validation ===================
	// 	if(district_select == ""){
	// 		e_error = 1;
	// 		$('.district_select').html('District is Required.');
	// 	}else{
	// 		$('.district_select').html('');
				
	// 	}

    //     //========== Block Input Validation ===================
	// 	if(block_select == ""){
	// 		e_error = 1;
	// 		$('.block_select').html('Block is Required.');
	// 	}else{
	// 		$('.block_select').html('');
				
	// 	}

    //     //========== Subdivision Input Validation ===================
	// 	if(subdivision_select == ""){
	// 		e_error = 1;
	// 		$('.subdivision_select').html('Subdivision is Required.');
	// 	}else{
	// 		$('.subdivision_select').html('');
				
	// 	}

    //     //========== Location Input Validation ===================
	// 	if(req_location == ""){
	// 		e_error = 1;
	// 		$('.req_location').html('Location is Required.');
	// 	}else{
    //         // if(!req_location.match(alphaletters_spaces)){
	// 		// 	e_error = 1;
	// 		// 	$('.req_location').html('Only alphaletters and spaces are allwoed, Check again.');
	// 		// }else{
	// 			$('.req_location').html('');
	// 		// }
	// 	}

	// 	//========== Upload Doc. Input Validation ===================
	// 	if(document.getElementById("req_uplo_doc").files.length == 0){
	// 		e_error = 1;
	// 		$('.req_uplo_doc').html('Upload File is Required.');
	// 	}else{
	// 		var fileInput = document.getElementById('req_uplo_doc'); 
	// 		var filePath = fileInput.value;
	// 		if(!allowedExtensions_only_pdf.exec(filePath)){
	// 			e_error = 1;
	// 			$('.req_uplo_doc').html('Upload File type Invalid.(Use PDF only)');
	// 		}else{
	// 			$('.req_uplo_doc').html('');
	// 		}
	// 	}
	

	// 	if (e_error == 1) {
	// 		$('.div_roller_total').fadeOut();
	// 		$('.gofinalsubmit').attr("disabled", false);
	// 		$('.get_error_total').html(error_message);
	// 		$(".get_error_total").fadeIn();
	// 		$(".text-error").fadeIn();
	// 		/*e_error = 0;
	// 		error_message = '';*/
	// 		setTimeout(function() {
	// 			$('.text-error, .get_error_total').fadeOut();
	// 		}, delay);
	// 	} else {
	// 		//alert(newhash);
	// 		//alert(rehash);
	// 		//$("#myForm").submit();
	// 		var conf_answer = confirm("Are you sure you want to Submit the Data for New Scheme?");
	// 		if (conf_answer) {

	// 			var form_data = new FormData();
    //             form_data.append('schm_id',schm_id);
    //             form_data.append('req_details', req_details);
    //             form_data.append('req_quantity', req_quantity);
    //             form_data.append('req_uom', req_uom);
    //             form_data.append('district_select', district_select);
    //             form_data.append('block_select', block_select);
    //             form_data.append('subdivision_select', subdivision_select);
    //             form_data.append('req_location', req_location);
    //             form_data.append("files", files[0]);

    //             console.log(form_data);

	// 			//============ AJAX POST =================
	// 			$.ajax({
	// 				method: 'POST',
    //                 url: '<?php echo base_url() . "admincontrol/requisition/requisition_entry_form_submit"; ?>',
	// 				data: form_data,
	// 				dataType: 'JSON',
	// 				contentType: false,
	// 				processData: false,
	// 				success: function(data) {
	// 					alert(data.msg);
	// 					if (data.msg == 1) {

	// 						alert('success');
	// 						//console.log(data);
	// 						//alert(data.msg[0].space_rate);
	// 						$('.div_roller_total').fadeOut();
	// 						$('.get_success_total').html('Advertisement is Uploaded Successfully.');
	// 						$(".get_success_total").fadeIn();
	// 						$('input, select').val('');
	// 						$('input').html('');
	// 						setTimeout(function() {
	// 							$('.get_success_total').fadeOut();
	// 						}, 3000);
	// 						// setTimeout(function() {
	// 						// 	window.location.replace("<?php echo site_url('admincontrol/scheme_set/all_scheme_list') ?>");
	// 						// }, 3000);


	// 					} else {
	// 						$('.div_roller_total').fadeOut();
	// 						$('.gofinalsubmit').attr("disabled", false);
	// 						error_message = "There have some problem to Store Data, Try after some time.";
	// 						error_message = error_message + "<br/>" + data.e_msg;
	// 						$('.get_error_total').html(error_message);
	// 						$(".get_error_total").fadeIn();
	// 						setTimeout(function() {
	// 							$('.get_error_total').fadeOut();
	// 						}, delay);
	// 					}

	// 				}
	// 			});

	// 		} else {
	// 			$('.div_roller_total').fadeOut();
	// 			$('.gofinalsubmit').attr("disabled", false);
	// 		}
	// 	}

	// }


	function gotoDMclickbutton() {

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
		//========== Requisition Approval for D.M. Office Form Input Get Values ===================
		var dm_mod_req_id = $('#dm_mod_req_id').val().trim();
		var dm_mod_ini_memo_no = $('#dm_mod_ini_memo_no').val().trim();
		var dm_mod_ini_memo_date = $('#dm_mod_ini_memo_date').val().trim();
		var dm_mod_estimated_cost = $('#dm_mod_estimated_cost').val().trim();
		var dm_mod_estimate_doc = $('#dm_mod_estimate_doc')[0].files;
		var dm_mod_ini_letter_doc = $('#dm_mod_ini_letter_doc')[0].files;
		var dm_mod_bank_passbook_doc = $('#dm_mod_bank_passbook_doc')[0].files;
		//========== Requisition Id hidden Input Validation ===================
		if(dm_mod_req_id == ""){
			e_error = 1;
		}
		else if(!dm_mod_req_id.match(onlynumerics)){
			e_error = 1;
		}
		//========== Initiation Memo No. Input Validation ===================
		if(dm_mod_ini_memo_no == ""){
			e_error = 1;
			$('.dm_mod_ini_memo_no').html('Initiation Memo No. is Required.');
		}else{
			if(!dm_mod_ini_memo_no.match(alphanumerics_no)){
				e_error = 1;
				$('.dm_mod_ini_memo_no').html('Initiation Memo No. not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.dm_mod_ini_memo_no').html('');
			}
		}
		//========== Initiation Memo Date Input Validation ===================
		if(dm_mod_ini_memo_date == ""){
			e_error = 1;
			$('.dm_mod_ini_memo_date').html('Initiation Memo Date is Required.');
		}else{
			if(isDatecheck(dm_mod_ini_memo_date)){
				e_error = 1;
				$('.dm_mod_ini_memo_date').html('Invalid Date, Check again.');
			}else{
				$('.dm_mod_ini_memo_date').html('');
			}	
		}
		//========== Estimated Cost Input Validation ===================
		if(dm_mod_estimated_cost == ""){
			e_error = 1;
			$('.dm_mod_estimated_cost').html('Estimated Cost is Required.');
		}else{
			if(!dm_mod_estimated_cost.match(onlynumerics_withdot)){
				e_error = 1;
				$('.dm_mod_estimated_cost').html('Only numbers & dot allwoed, Check again.');
			}else{
				$('.dm_mod_estimated_cost').html('');
			}
		}
		//========== Estimate Upload Input Validation ===================
		if(document.getElementById("dm_mod_estimate_doc").files.length == 0){
			e_error = 1;
			$('.dm_mod_estimate_doc').html('Estimate File is Required.');
		}else{
			var fileInput = document.getElementById('dm_mod_estimate_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.dm_mod_estimate_doc').html('Estimate File type Invalid.');
			}else{
				$('.dm_mod_estimate_doc').html('');
			}
		}
		//========== Initiate Letter Upload Input Validation ===================
		if(document.getElementById("dm_mod_ini_letter_doc").files.length == 0){
			e_error = 1;
			$('.dm_mod_ini_letter_doc').html('Initiate Letter File is Required.');
		}else{
			var fileInput = document.getElementById('dm_mod_ini_letter_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.dm_mod_ini_letter_doc').html('Initiate Letter File type Invalid.');
			}else{
				$('.dm_mod_ini_letter_doc').html('');
			}
		}
		//========== Bank Passbook Upload Input Validation ===================
		if(document.getElementById("dm_mod_bank_passbook_doc").files.length == 0){
			e_error = 1;
			$('.dm_mod_bank_passbook_doc').html('Bank Passbook File is Required.');
		}else{
			var fileInput = document.getElementById('dm_mod_bank_passbook_doc'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.dm_mod_bank_passbook_doc').html('Bank Passbook File type Invalid.');
			}else{
				$('.dm_mod_bank_passbook_doc').html('');
			}
		}


		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.dm_error_total').html(error_message);
			$(".dm_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total, .dm_error_total').fadeOut();
			}, delay);
		} 
		else {
			var conf_answer = confirm("Are you sure you want to Submit the Data for New Scheme?");
			if (conf_answer) {
				var form_data = new FormData();
				form_data.append('dm_mod_req_id',dm_mod_req_id);
				form_data.append('dm_mod_ini_memo_no',dm_mod_ini_memo_no);
				form_data.append('dm_mod_ini_memo_date', dm_mod_ini_memo_date);
				form_data.append('dm_mod_estimated_cost', dm_mod_estimated_cost);
				form_data.append('dm_mod_estimate_doc', dm_mod_estimate_doc[0]);
				form_data.append('dm_mod_ini_letter_doc', dm_mod_ini_letter_doc[0]);
				form_data.append('dm_mod_bank_passbook_doc', dm_mod_bank_passbook_doc[0]);
				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/requisition/requisition_list_dm_modal_form_submit"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						if (data.msg == 1) {
							$('.div_roller_total').fadeOut();
							$('.dm_success_total').html('Requisition is Processed Successfully.');
							$(".dm_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.dm_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/requisition/requisition_list') ?>");
							}, 3000);
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
			} 
			else {
				$('.div_roller_total').fadeOut();
				$('.gofinalsubmit').attr("disabled", false);
			}
		}
	}

	function rejectionReason(requisition_id) {
		// alert('reason');
		$('.rejection_reason_div').remove();
		$.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "admincontrol/requisition/get_rejection_reason"; ?>',
            data:{
                requisition_id: requisition_id, 
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.flag == 1) {
                    $('#rejection_reason_div').append('<p class="rejection_reason_div">'+data.rejection_reason+'</p>');
                }
				else{
					$('#rejection_reason_div').append('<p class="rejection_reason_div">No Remarks Available</p>');
				}

				$('.rejectionReasonModal').modal('show');
            }
        });
	}

	

</script>