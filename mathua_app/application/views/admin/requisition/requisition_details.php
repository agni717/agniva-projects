<?php $this->load->view('admin/component/header') ?>

<style>
	.text-error { color: red;}
    .text-success { color: green;}

    .info-msg,
    .success-msg,
    .warning-msg,
    .error-msg {
    margin: 10px 0;
    padding: 10px;
    border-radius: 3px 3px 3px 3px;
    }
    .info-msg {
    color: #059;
    background-color: #BEF;
    }
    .success-msg {
    color: #270;
    background-color: #DFF2BF;
    }
    .warning-msg {
    color: #9F6000;
    background-color: #FEEFB3;
    }
    .error-msg {
    color: #D8000C;
    background-color: #FFBABA;
    }

</style>


<div class="home pb-5">
	<div class="container-fluid">			
		<div class="row">
			<div class="col-md-12 mt-5">
				<div class="widget-area-2 proclinic-box-shadow mb-3">
                   <h3 class="widget-title">Scheme Requisition Details</h3>
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Scheme Number : <?php echo $requisition_details->req_number; ?></legend>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">Implementation Details</h3>
                                            <label class="d-block text-right">Date & Time: <?php echo $requisition_details->req_createdate; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Scheme Name : <?php echo $requisition_details->scm_name; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>District : <?php echo $requisition_details->district_name; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Block/Municipality : <?php echo $requisition_details->block_name; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Gram Panchayat : <?php echo $requisition_details->req_gram_panchayat_name; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Board Memo No. : <?php echo $requisition_details->req_b_memo_no; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Board Memo Date : <?php echo $requisition_details->req_b_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Recommendation Letter : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$requisition_details->req_recommendation_letter_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Scheme Memo No. : <?php echo $requisition_details->req_s_memo_no; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Scheme Memo Date : <?php echo $requisition_details->req_s_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Implementation Letter : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$requisition_details->req_implementation_letter_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Approx. Amount : ₹<?php echo $requisition_details->req_approx_amount; ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if($requisition_details->req_initiate > 0){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">Initiation Details</h3>
                                            <label class="d-block text-right">Date : <?php echo $requisition_details->req_initiate_date; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Initiation Memo No. : <?php echo $requisition_details->req_initiate_memo_no; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>Initiation Memo Date : <?php echo $requisition_details->req_initiate_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Vetted Estimated Cost : ₹<?php echo $requisition_details->req_final_amount; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Vetted Estimated Paper Document : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$requisition_details->req_estimate_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Initiate Letter : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$requisition_details->req_initiate_letter_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Bank Passbook : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$requisition_details->req_bank_passbook_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Existing Place Picture : <?php if($requisition_details->req_initiate == 1){ echo '<span class="error-msg"><i class="fa fa-times-circle"></i>Pending</span>';}elseif($requisition_details->req_initiate == 2){echo '<span class="success-msg"><a href="'. base_url('admincontrol/requisition/installment_payment_details_gallery1/'.$requisition_details->req_id).'" target="_blank"><i class="fa fa-check"></i>Uploaded</a></span>';} ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($requisition_details->req_approval > 0){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                                <h3 class="widget-title">1st Installment Payment Details</h3>
                                                <label class="d-block text-right">Date : <?php echo $first_payment_details->wpay_createdate; ?></label>
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">1st Installment Memo No. : <?php echo $first_payment_details->wpay_memo_no; ?></legend>
                                                    <div class="form-row control-group">
                                                        <div class="form-group col-lg-4"><label>Memo Date : <?php echo $first_payment_details->wpay_memo_date; ?></label></div>
                                                        <div class="form-group col-lg-4"><label>Amount : ₹<?php echo $first_payment_details->wpay_amount; ?></label></div>
                                                        <div class="form-group col-lg-4"><label>Sanction Order : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$first_payment_details->wpay_san_ord_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                        <div class="form-group col-lg-4"><label>Cheque No : <?php echo $first_payment_details->wpay_cheq_no; ?></label></div>
                                                        <div class="form-group col-lg-4"><label>Cheque Date : <?php echo $first_payment_details->wpay_cheq_date; ?></label></div>
                                                    </div>									
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if($requisition_details->req_progress_flag > 0){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">Work Order Details</h3>
                                            <label class="d-block text-right">Date : <?php echo $progress_details->reqp_createdate; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Work Order No. : <?php echo $progress_details->reqp_wo_no; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>Work Order Date : <?php echo $progress_details->reqp_wo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Work Order : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$progress_details->reqp_wo_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Agency Name : <?php echo $progress_details->reqp_vendor_name; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Work Start Date : <?php echo $progress_details->reqp_work_start_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Start Utilization Certificate : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$progress_details->reqp_start_uc_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Requested Amount : ₹<?php echo $progress_details->reqp_balance_amount_request; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Work Picture : <?php if($requisition_details->req_progress_flag == 1){ echo '<span class="error-msg"><i class="fa fa-times-circle"></i>Pending</span>';}elseif($requisition_details->req_progress_flag >= 2){echo '<span class="success-msg"><a href="'. base_url('admincontrol/requisition/installment_payment_details_gallery2/'.$requisition_details->req_id).'" target="_blank"><i class="fa fa-check"></i>Uploaded</a></span>';} ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($requisition_details->req_approval > 1){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">2nd Installment Payment Details</h3>
                                            <label class="d-block text-right">Date : <?php echo $second_payment_details->wpay_createdate; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">2nd Installment Memo No. : <?php echo $second_payment_details->wpay_memo_no; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>Memo Date : <?php echo $second_payment_details->wpay_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Amount : ₹<?php echo $second_payment_details->wpay_amount; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Sanction Order : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$second_payment_details->wpay_san_ord_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Cheque No : <?php echo $second_payment_details->wpay_cheq_no; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Cheque Date : <?php echo $second_payment_details->wpay_cheq_date; ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($requisition_details->req_progress_flag > 2){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">Work Completion Details</h3>
                                            <label class="d-block text-right">Date : <?php echo $progress_details->reqp_comp_createdate; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Completion Memo No. : <?php echo $progress_details->reqp_comp_memo_no; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>Completion Memo Date : <?php echo $progress_details->reqp_comp_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Final Utilization Certificate : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$progress_details->reqp_final_uc_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Requested Amount : ₹<?php echo $progress_details->reqp_final_amount_request; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Work End Date : <?php echo $progress_details->reqp_work_end_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Finished Work Picture : <?php if($requisition_details->req_progress_flag == 3){ echo '<span class="error-msg"><i class="fa fa-times-circle"></i>Pending</span>';}elseif($requisition_details->req_progress_flag >= 4){echo '<span class="success-msg"><a href="'. base_url('admincontrol/requisition/installment_payment_details_gallery3/'.$requisition_details->req_id).'" target="_blank"><i class="fa fa-check"></i>Uploaded</a></span>';} ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if($requisition_details->req_approval > 2){ ?>
                        <div class="home pb-5">
                            <div class="container">
                                <div class="row">						
                                    <div class="col-lg-10 mx-auto">
                                        <div class="widget-area-2 proclinic-box-shadow">
                                            <h3 class="widget-title">Final Installment Payment Details</h3>
                                            <label class="d-block text-right">Date : <?php echo $final_payment_details->wpay_createdate; ?></label>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Final Installment Memo No. : <?php echo $final_payment_details->wpay_memo_no; ?></legend>
                                                <div class="form-row control-group">
                                                    <div class="form-group col-lg-4"><label>Memo Date : <?php echo $final_payment_details->wpay_memo_date; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Amount : ₹<?php echo $final_payment_details->wpay_amount; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Sanction Order : <a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$final_payment_details->wpay_san_ord_doc; ?>" target="_blank"><i class="ti-file" style="font-size: 20px; color: red;"></i></a></label></div>
                                                    <div class="form-group col-lg-4"><label>Cheque No : <?php echo $final_payment_details->wpay_cheq_no; ?></label></div>
                                                    <div class="form-group col-lg-4"><label>Cheque Date : <?php echo $final_payment_details->wpay_cheq_date; ?></label></div>
                                                </div>									
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/component/footer') ?>