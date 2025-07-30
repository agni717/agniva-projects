<?php $this->load->view('admin/component/header') ?>

<?php
$total_paid = 0;
for($i=0; $i<count($payment_details); $i++){
	$total_paid = $total_paid + $payment_details[$i]->wpay_amount;
}

$approv_amt = number_format($requisition_details->req_final_amount, 2, '.', '');
$paid_amt = number_format($total_paid, 2, '.', '');
$paid_amt_percentage = number_format(($total_paid/$requisition_details->req_final_amount)*100);
$balanc_amt = number_format(($requisition_details->req_final_amount - $total_paid), 2, '.', '');
$balanc_amt_percentage = number_format((($requisition_details->req_final_amount - $total_paid)/$requisition_details->req_final_amount)*100);
?>

<style>
	.text-error { color: red;}

    .text-success { color: green;}
</style>


    <div class="home pb-5">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                        <h3 class="widget-title">Payment Process List Against the Requisition</h3>
                        <!-- <a href="javascript:void(0);" onclick="gotoPaymentModal(<?php //echo $requisition_details->req_id; ?>);" class="btn btn-warning d-table ml-auto">Give Installment</a> -->

                        <?php

                            // $total_paid = 0;
                            // for($i=0; $i<count($payment_details); $i++){
                            //     $total_paid = $total_paid + $payment_details[$i]->wpay_amount;
                            // }
                            // $approv_amt = number_format($requisition_details->req_final_amount, 2, '.', '');

                            // if( ((float)$total_paid < (float)$approv_amt) && (count((array)$installment_details) > count((array)$payment_details)) ){
                            if ((float)$total_paid < (float)$approv_amt) {

                                $user_typ = $this->session->userdata('utype');

                                if($user_typ == 1 || $user_typ == 2){

                                    echo '<a href="'.base_url('admincontrol/requisition/installment_payment/').$requisition_details->req_id.'" class="btn btn-warning d-table ml-auto">Give Installment</a>';
                                }
                            }
                            
                        ?>
                    
                
                    
	                    <fieldset class="scheduler-border">
							<legend class="scheduler-border">Requisition Number : <?php echo $requisition_details->req_number; ?></legend>
                            <div class="table-responsive mb-3">
                                <div class="scheduler-border">Scheme Name : <?php echo $requisition_details->scm_name; ?></div>
                                <div class="scheduler-border">District : <?php echo $requisition_details->district_name; ?></div>
                                <div class="scheduler-border">Subdivision : <?php echo $requisition_details->subdiv_name; ?></div>
                                <div class="scheduler-border">Block : <?php echo $requisition_details->block_name; ?></div>
                                <div class="scheduler-border">Approved Amount : ₹<?php echo $approv_amt; ?></div>
                                <div class="scheduler-border">Paid Amount : ₹<?php echo $paid_amt .' ('. $paid_amt_percentage .'%)'; if(!((float)$total_paid<(float)$approv_amt)){echo '<strong class="text-success"> ✓ full payment done.</strong>';}?></div>
                                <div class="scheduler-border">Balance Amount : ₹<?php echo $balanc_amt .' ('. $balanc_amt_percentage .'%)'; ?></div>
                            </div>
							<div class="table-responsive mb-3">
								<table id="tableId" class="table table-bordered table-striped">
									<thead>
										<tr>												
											<th>Sl.No.</th>
											<th>Installment Number</th>
											<th>Installment Ammount</th>
											<th>Work Progress</th>
										</tr>
									</thead>
									<tbody>

                                        <?php
                                        // $i = 1;
                                        // foreach($installment_details as $installment_row){ 
                                            ?>
                                            <!-- <tr>												 -->
                                                <!-- <td><?php //echo $i++; ?></td> -->
                                                <!-- <td><?php //echo $installment_row->scd_inst_no; ?></td> -->
                                                <!-- <td><?php //echo number_format((($installment_row->scd_percent_amount)*($requisition_details->req_final_amount)/100), 2, '.', ''); ?></td> -->
                                                <!-- <td><?php //echo $installment_row->scd_percent_work; ?>% </td> -->
                                            <!-- </tr> -->
                                            <?php 
                                        // } 
                                        ?>

                                        <?php
                                        $i = 1;
                                        foreach($payment_details as $payment_row){ 
                                            ?>
                                            <tr>												
                                                <td><?php echo $i++; ?></td>
                                                <td>Installment <?php echo $payment_row->wpay_installment_no; ?></td>
                                                <td>₹<?php echo number_format($payment_row->wpay_amount, 2, '.', ''); ?></td>
                                                <td><?php echo $payment_row->wpay_percent_work; ?>% Done </td>
                                            </tr>
                                            <?php 
                                        } 
                                        ?>

									</tbody>
	                            </table>	                                
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>


    <!-- ================================================================== Modal ================================================================= -->
		<!-- <div class="modal fade paymentModal" id="approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" id="paymentModal">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <h3 class="modal-title widget-title">Installment List Against the Requisition</h3>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
			      	<div class="modal-body">
						<?php echo form_open_multipart('', 'class="form-horizontal" id="paymentForm"'); ?>
					        <?php 
                            if (isset($error)) { ?>
					            <div class="alert alert-error alert-danger">                
						            <h4>Error!</h4>
						            <?php echo $error; ?>
					            </div>
					            <?php 
                            } ?>
                            <form>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Add Installment</legend>
                                    <div class="form-row control-group">
                                        <div class="form-group col-lg-4">
                                            <label>Scheme : Demo Scheme</label>
                                        </div>													
                                        <div class="form-group col-lg-4">
                                            <label>Executive Agency : Demo Executive Agency</label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Requisition Number : 5432118</label>
                                        </div>
                                    </div>
                                    <div class="form-row control-group">
                                        <div class="form-group col-lg-6">
                                            <label>Payment Installment</label>
                                            <select class="form-control">
                                            <option disabled selected>---Select---</option>
                                            <option>Installment 1</option>
                                            <option>Installment 2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Ammount Paid</label>
                                            <input type="text" placeholder="Ammount" class="form-control">
                                        </div>									
                                    </div>
                                    <div class="form-row control-group">
                                        <div class="form-group col-lg-6">
                                            <label>How much parcentage of work done</label>
                                            <input type="text" placeholder="Work Done" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Description</label>
                                            <textarea rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row control-group">
                                        <div class="form-group col-lg-6">
                                            <label>Document upload against the work</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label></label>
                                            <input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto">
                                        </div>
                                    </div>										
                                </fieldset>
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
			      	</div>
			    </div>
		  	</div>
		</div>
	</div> -->



<?php $this->load->view('admin/component/footer') ?>



<!-- <script>
    function gotoPaymentModal(requisition_id){
        $('.paymentModal').modal('show');
    }
</script> -->