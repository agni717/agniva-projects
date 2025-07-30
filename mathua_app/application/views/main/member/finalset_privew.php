<?php $this->load->view('main/component/login_header') ?>
<style>
/*.container_area {
    min-height: 1600px;
}*/

</style>
<?php $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>

<div class="container mt-3 container_area">
  
            <?php if($this->session->flashdata('success')) { ?>
					  <div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
				    <?php $this->session->unset_userdata('success'); }
				    elseif($this->session->flashdata('e_error')) { ?>                
			      <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
				    <?php $this->session->unset_userdata('e_error'); } ?>

  <div><h3>Registration No. - <?php echo $fuser_detailset->f_application_no; ?>
  <?php if($fuser_detailset->fu_cancel_stat == 1){ ?><span style="color:red;"> (Application is Cancelled by Candidate)</span><?php } ?>
  </h3></div>
<table width="100%" border="0">
  <tr>
    <td>
    <table width="100%" border="1" cellpadding="5" cellspacing="5" >

  <tr>
    <td width="70%"><label><strong>Applied For :</strong> <?php echo $adv_detail->rm_name; ?></label></td>
    <td width="30%" rowspan="2" valign="top"><strong>Applicant's Photograph</strong><br>
    <img src="<?php echo base_url().$pathurl.$fuser_detailset->fu_photo_doc; ?>" style="max-width:180px;" /><br/>
    <strong>Applicant's Signature</strong><br>
    <img src="<?php echo base_url().$pathurl.$fuser_detailset->fu_signature_doc; ?>" style="max-width:180px;" />
    <span></span>
    </td>
  </tr>
  <tr>
    <td><label><strong>Name :</strong> <?php echo $fuser_detailset->f_full_name; ?></label></td>
    </tr>
    
</table>
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellpadding="5" cellspacing="5" >
  <tr>
    <td><label><strong>Mobile No :</strong> <?php echo $fuser_detailset->f_mobile; ?></label></td>
    <td><label><strong>Email :</strong> <?php echo $fuser_detailset->f_email; ?></label></td>
  </tr>
  <tr>
    <td><label><strong>Discipline :</strong> <?php echo $adv_category->catm_name; ?></label></td>
    <td><label><strong>Father's Name :</strong></label> <?php echo $fuser_detailset->fu_father_name; ?></td>
  </tr>
  <tr>
    <td><label><strong>Mother's Name :</strong> <?php echo $fuser_detailset->fu_mother_name; ?></label></td>
    <td><label><strong>Gender :</strong></label> <?php echo $fuser_detailset->fu_gender; ?></td>
  </tr>
  <tr>
    <td><label><strong>Date Of Birth :</strong> <?php echo date('d-m-Y',strtotime($fuser_detailset->fu_dob)); ?></label></td>
    <td><label><strong>Marital Status :</strong> <?php echo $fuser_detailset->fu_marital_status; ?></label></td>
  </tr>
  
  <tr>
    <td colspan="2"><strong>Present Address</strong></td>
    </tr>
  <tr>
    <td><label><strong>State :</strong></label> <?php foreach ($state_list as $states) {
        if ($states->state_id == $fuser_detailset->fu_state) { echo $states->state_name;break; }
      } ?></td>
    <?php if($fuser_detailset->fu_state == 28){ ?>  
    <td><label><strong>District :</strong> <?php foreach ($dist_list as $dists) { 
      if ($dists->district_code == $fuser_detailset->fu_district) { echo $dists->district_name; }
      } ?></label></td>
    <?php }else{ ?>
      <td><label><strong>District :</strong> <?php echo $fuser_detailset->fu_other_district; ?></label></td>
    <?php } ?>
  </tr>
  <tr>
    <?php if($fuser_detailset->fu_state == 28){ ?>
    <td><label><strong>Sub-Division :</strong></label> <?php foreach ($sub_division as $sd) { 
      if ($fuser_detailset->fu_sub_division == $sd->subdiv_id){ echo $sd->subdiv_name; }
      } ?></td>
    <td><label><strong>Block/ Municipality :</strong>: 
    <?php $bmset = '';
    foreach ($block_municipality as $bm) { 
        if ($bm->block_id == $fuser_detailset->fu_block_municipality) {$bmset = $bm->block_name;}
      } ?>
    <?php if($fuser_detailset->fu_mb_type != NULL){echo $fuser_detailset->fu_mb_type.' ('.$bmset.')';} ?></label></td>
    <?php }else{ ?>
      <td><label><strong>Sub-Division :</strong> <?php echo $fuser_detailset->fu_other_sdiv; ?></label></td>
      <td><label><strong>Block/ Municipality :</strong> <?php echo $fuser_detailset->fu_other_blockm; ?></label></td>
    <?php } ?>
  </tr>
   <tr>
    <?php if($fuser_detailset->fu_state == 28){ ?>
    <td><label><strong>Police Station :</strong></label> <?php foreach ($police_station as $ps) { 
        if ($fuser_detailset->fu_police_station == $ps->ps_id) {echo $ps->ps_name;}
      } ?></td>
    <?php }else{ ?>
      <td><label><strong>Police Station :</strong> <?php echo $fuser_detailset->fu_other_ps; ?></label></td>
    <?php } ?>
    <td><label><strong>Ward/GP : </strong> <?php echo $fuser_detailset->fu_ward_gp; ?></label></td>
  </tr>
   <tr>
    <td><label><strong>Vill / Para / House No / Road :</strong></label> <?php echo $fuser_detailset->fu_house_road; ?></td>
    <td><label><strong>Post Office : </strong> <?php echo $fuser_detailset->fu_post_office; ?> </label></td>
  </tr>
   <tr>
    <td colspan="2"><label><strong>Pin :</strong></label> <?php echo $fuser_detailset->fu_pincode; ?></td>
  </tr>
  <?php if($fuser_detailset->fu_same_address == "No"){ ?>
    <tr>
    <td colspan="2"><strong>Permanent Address</strong></td>
    </tr>
    <tr>
      <td><label><strong>State :</strong></label> <?php foreach ($state_list as $states) {
          if ($states->state_id == $fuser_detailset->fu_perma_state) { echo $states->state_name;break; }
        } ?></td>
      <?php if($fuser_detailset->fu_perma_state == 28){ ?>  
      <td><label><strong>District :</strong> <?php foreach ($dist_list as $dists) { 
        if ($dists->district_code == $fuser_detailset->fu_perma_dist) { echo $dists->district_name;break; }
        } ?></label></td>
      <?php }else{ ?>
        <td><label><strong>District :</strong> <?php echo $fuser_detailset->fu_perma_other_district; ?></label></td>
      <?php } ?>
    </tr>
    <tr>
      <?php if($fuser_detailset->fu_perma_state == 28){ ?>
      <td><label><strong>Sub-Division :</strong></label> <?php foreach ($per_sub_division as $sd) { 
        if ($fuser_detailset->fu_perma_sub_division == $sd->subdiv_id){ echo $sd->subdiv_name; }
        } ?></td>
      <td><label><strong>Block/ Municipality :</strong>: 
      <?php $bmset='';
      foreach ($per_block_municipality as $bm) { 
          if ($bm->block_id == $fuser_detailset->fu_perma_block_municipality) {$bmset = $bm->block_name;}
        } ?>
      <?php if($fuser_detailset->fu_perma_mb_type != NULL){echo $fuser_detailset->fu_perma_mb_type.' ('.$bmset.')';} ?></label></td>
      <?php }else{ ?>
        <td><label><strong>Sub-Division :</strong> <?php echo $fuser_detailset->fu_perma_other_sdiv; ?></label></td>
        <td><label><strong>Block/ Municipality :</strong> <?php echo $fuser_detailset->fu_perma_other_blockm; ?></label></td>
      <?php } ?>
    </tr>
    <tr>
      <?php if($fuser_detailset->fu_perma_state == 28){ ?>
      <td><label><strong>Police Station :</strong></label> <?php foreach ($per_police_station as $ps) { 
          if ($fuser_detailset->fu_perma_police_station == $ps->ps_id) {echo $ps->ps_name;}
        } ?></td>
      <?php }else{ ?>
        <td><label><strong>Police Station :</strong> <?php echo $fuser_detailset->fu_perma_other_ps; ?></label></td>
      <?php } ?>
      <td><label><strong>Ward/GP : </strong> <?php echo $fuser_detailset->fu_perma_ward_gp; ?></label></td>
    </tr>
    <tr>
      <td><label><strong>Vill / Para / House No / Road :</strong></label> <?php echo $fuser_detailset->fu_perma_house_road; ?></td>
      <td><label><strong>Post Office : </strong> <?php echo $fuser_detailset->fu_perma_post_office; ?> </label></td>
    </tr>
    <tr>
      <td colspan="2"><label><strong>Pin :</strong></label> <?php echo $fuser_detailset->fu_perma_pincode; ?></td>
    </tr>
    <tr>
    <td colspan="2"><label><strong>Comunication Address :</strong> <?php echo $fuser_detailset->fu_comunication_address; ?> Address</label> </td>
    </tr>
  <?php }else{ ?>
    <tr>
      <td colspan="2"><label><strong>Permanent Address is Same as Present Address</strong></td>
    </tr>
  <?php } ?>
  
  <tr>
    <td><label><strong>DOB Proof  :</strong></label> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_dob_doc; ?>" target="_blank">Attached Document</a>
   </td>
    <td><label><strong>Address Proof :</strong> </label> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_address_doc; ?>" target="_blank">Attached Document</a>
    <span></span>
   </td>
  </tr>
  <tr>
    <td colspan="2"><label><strong>Caste :</strong></label> <?php foreach ($caste_tab as $caste) : ?>
      <?php if ($fuser_detailset->fu_caste_type == $caste->caste_id){ echo $caste->caste_name; } ?>
    <?php endforeach; ?>
    <?php if($fuser_detailset->fu_caste_type != 1){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5" >
        <tr>
          <td><label><strong>Caste/ Tribe/ Community</strong></label> : <?php echo $caste_community->csdetail_name; ?></td>
          <td><label><strong>Certification No :</strong> <?php echo $fuser_detailset->fu_caste_number; ?></label></td>
        </tr>
        <tr>
          <td><label><strong>Issued By Whom</strong></label> : <?php foreach ($caste_issuing_auth as $auth){
            if ($fuser_detailset->fu_caste_issue_whom == $auth->cia_id) echo $auth->cia_name;} ?></td>
          <td><label><strong>Issued by Date :</strong></label> <?php echo date('d-m-Y',strtotime($fuser_detailset->fu_caste_issue_date)); ?></td>
        </tr>
        <tr>
          <td><label><strong>Doc Upload:</strong> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_caste_doc; ?>" target="_blank">Attached Document</a></label><span></span></td>
        </tr>
      </table>
    <?php } ?>
    </td>
    </tr>
    
    <tr>
    <td colspan="2"><label><strong>PWD  :</strong></label> <?php echo $fuser_detailset->fu_pwd; ?><br>
    <?php if($fuser_detailset->fu_pwd == "Yes"){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5" >
        <tr>
          <td><label><strong>Percentage of Disability  :</strong> <?php echo $fuser_detailset->fu_pwd_percent; ?>%</label></td>
          <td><label><strong>Issuing Authority :</strong></label> <?php echo $fuser_detailset->fu_pwd_issue_whom; ?></td>
        </tr>
        <tr>
          <td><label><strong>Issued by Date :</strong></label> <?php echo date('d-m-Y',strtotime($fuser_detailset->fu_pwd_issue_date)); ?></td>
          <td><label><strong>Doc Upload:</strong> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_pwd_doc; ?>" target="_blank">Attached Document</a></label><span></span></td>
        </tr>
        
      </table>
    <?php } ?>
    </td>
    </tr>
    <?php if ($adv_detail->adv_has_exampted == "Yes") { ?>
    <tr>
    <td colspan="2"><label><strong>Exempted  :</strong></label> <?php echo $fuser_detailset->fu_exempted; ?><br>
    <?php if($fuser_detailset->fu_exempted == "Yes"){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5" >
        <tr>
          <td><label><strong>Reason  :</strong><?php echo $fuser_detailset->fu_exc_reason; ?></label></td>
          <td><label><strong>Upload Doc :</strong> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_exc_doc; ?>" target="_blank">Attached Document</a></label> <span></span></td>
        </tr>
      </table>
      <?php } ?>
    </td>
    </tr>
    <?php } ?>
    <?php if ($adv_detail->adv_has_exservice == "Yes") { ?>
    <tr>
    <td colspan="2"><label><strong>Ex Serviceman  :</strong></label> <?php echo $fuser_detailset->fu_exservice; ?><br>
      <?php if($fuser_detailset->fu_exservice == "Yes"){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5" >
        <tr>
          <td><label><strong>Reason  :</strong><?php echo $fuser_detailset->fu_exs_reason; ?></label></td>
          <td><label><strong>Upload Doc :</strong> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_exs_doc; ?>" target="_blank">Attached Document</a></label> <span></span></td>
        </tr>
      </table>
      <?php } ?>
    </td>
    </tr>
    <?php } ?>
    <?php if ($adv_detail->adv_has_ews == "Yes") { ?>
    <tr>
    <td colspan="2"><label><strong>EWS  :</strong></label> <?php echo $fuser_detailset->fu_ews; ?><br>
      <?php if($fuser_detailset->fu_ews == "Yes"){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5" >
        <tr>
          <td><label><strong>Reason  :</strong><?php echo $fuser_detailset->fu_ews_reason; ?></label></td>
          <td><label><strong>Upload Doc :</strong> <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_ews_doc; ?>" target="_blank">Attached Document</a></label> <span></span></td>
        </tr>
      </table>
      <?php } ?>
    </td>
    </tr>
    <?php } ?>
    <?php if (count((array)$extraage_list) > 0) {
      foreach($extraage_list as $eageitem){ ?>
    <tr>
    <td colspan="2"><label><strong><?php echo $eageitem->caste_name; ?>  :</strong></label> <?php echo $eageitem->fu_ext_answer; ?><br>
      <?php if($eageitem->fu_ext_answer == "Yes"){ ?>
      <table width="100%" border="1" cellpadding="5" cellspacing="5">
        <tr>
          <td><label><strong>Detail Description  :</strong><?php echo $eageitem->fu_ext_reason; ?></label></td>
          <td><label><strong>Upload Doc :</strong> <a href="<?php echo base_url().$pathurl.$eageitem->fu_ext_doc; ?>" target="_blank">Attached Document</a></label> <span></span></td>
        </tr>
      </table>
      <?php } ?>
    </td>
    </tr>
    <?php }
    } ?>
    
</table>
<tr>
    <td>
    
    <table width="100%"  border="1" cellpadding="5" cellspacing="5">
    <?php if ($adv_detail->adv_qualification_no > 0) { ?>
  <tr>
    <td colspan="9"><strong>Essential Qualification</strong> </td>
    </tr>
  <tr>
    <td><strong>Examination Name</strong></td>
    <td><strong>Board/ Council/ University/ Journal</strong></td>
    <td><strong>State Name</strong></td>
    <td><strong>Marks Obtained</strong></td>
    <td><strong>Full Marks</strong></td>
    <td><strong>Percentage(%) of Marks</strong></td>
    <td><strong>Additional Attempt</strong></td>
    <td><strong>No. of Attempt</strong></td>
    <td><strong>Upload Marksheet</strong></td>
  </tr>
  
  <?php foreach($quali_list as $qualiss){ ?>
    <tr>
      <td><?php echo $qualiss->qm_name; ?></td>
      <td><?php echo $qualiss->fu_council_board; ?></td>
      <td><?php echo $qualiss->state_name; ?></td>
      <td><?php echo $qualiss->fu_marks_obtained; ?></td>
      <td><?php echo $qualiss->fu_full_marks; ?></td>
      <td><?php echo $qualiss->fu_percent_of_marks; ?></td>
      <td><?php echo $qualiss->fu_is_attempt; ?></td>
      <td><?php echo $qualiss->fu_attempt_no; ?></td>
      <td><a href="<?php echo base_url($pathurl).$qualiss->fu_quali_docs; ?>" target="_blank">Attached Marksheet</a></td>
    </tr>
  <?php }} ?>
  <?php if(count((array)$desquali_list) > 0){ ?>
  <tr>
    <td colspan="9"><strong>Desirable Qualification</strong> </td>
    </tr>
  <tr>
    <td><strong>Examination Name</strong></td>
    <td><strong>Board/ Council/ University/ Journal</strong></td>
    <td><strong>State Name</strong></td>
    <td><strong>Marks Obtained</strong></td>
    <td><strong>Full Marks</strong></td>
    <td><strong>Percentage(%) of Marks</strong></td>
    <td><strong>Additional Attempt</strong></td>
    <td><strong>No. of Attempt</strong></td>
    <td><strong>Upload Marksheet</strong></td>
  </tr>
  <?php foreach($desquali_list as $qualiss){ ?>
    <tr>
      <td><?php echo $qualiss->qm_name; ?></td>
      <td><?php echo $qualiss->fud_council_board; ?></td>
      <td><?php echo $qualiss->state_name; ?></td>
      <td><?php echo $qualiss->fud_marks_obtained; ?></td>
      <td><?php echo $qualiss->fud_full_marks; ?></td>
      <td><?php echo $qualiss->fud_percent_of_marks; ?></td>
      <td><?php echo $qualiss->fud_is_attempt; ?></td>
      <td><?php echo $qualiss->fud_attempt_no; ?></td>
      <td><a href="<?php echo base_url($pathurl).$qualiss->fud_quali_docs; ?>" target="_blank">Attached Marksheet</a></td>
    </tr>
  <?php } ?>
  <?php } ?>


  <?php if ($adv_detail->adv_has_experience == "Yes") { ?>
  <tr>
    <td colspan="9">
    <label><strong>Experience in concerned field :</strong></label> <?php echo $fuser_detailset->fu_has_service; ?><br>
    <?php if ($fuser_detailset->fu_has_service == "Yes") { ?>
      <?php if(count((array)$essenexp_list) > 0){ ?>
      <strong>Essential Experience</strong>
      <table width="100%" border="1" cellpadding="5" cellspacing="5">
        <tr>
        <td><strong>Experience Category</strong></td>
        <td><strong>Organization</strong></td>
        <td><strong>Time Period</strong></td>
        <td><strong>Upload Certificate</strong></td>
        </tr>
        <?php foreach($essenexp_list as $expss){ ?>
          <tr>
          <td><?php echo $expss->expset_name; ?></td>
          <td><?php echo $expss->fues_exp_org_name; ?></td>
          <td><?php echo $expss->fues_exp_year.' Year & '.$expss->fues_exp_month.' Month'; ?></td>
          <td><a href="<?php echo base_url($pathurl).$expss->fues_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a></td>
          </tr>
        <?php } ?>
      </table>
      <?php } ?>
      <?php if(count((array)$exp_list) > 0){ ?>
      <strong>Desirable Experience</strong>
      <table width="100%" border="1" cellpadding="5" cellspacing="5">
        <tr>
        <td><strong>Experience Category</strong></td>
        <td><strong>Organization</strong></td>
        <td><strong>Time Period</strong></td>
        <td><strong>Upload Certificate</strong></td>
        </tr>
        <?php foreach($exp_list as $expss){ ?>
          <tr>
          <td><?php echo $expss->expset_name; ?></td>
          <td><?php echo $expss->fu_exp_org_name; ?></td>
          <td><?php echo $expss->fu_exp_year.' Year & '.$expss->fu_exp_month.' Month'; ?></td>
          <td><a href="<?php echo base_url($pathurl).$expss->fu_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a></td>
          </tr>
        <?php } ?>
      </table>
      <?php } ?>
      
      <?php } ?>
     </td>
    </tr>
  <?php } ?>  
</table>

    
    </td>
    </tr>
    
    </td>
  </tr>
</table>


<div class="mt-3 mb-5 text-center">
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <input type="hidden" name="refno" id="refno" value="<?php echo $fuser_detailset->f_application_no; ?>" />
      <?php if(strtotime($adv_detail->adv_end_time) > strtotime(date('Y-m-d H:i:s'))){ 
        if($fuser_detailset->fu_cancel_stat != 1){ ?>
        <button type="button" class="btn btn-danger cancelbutton" onclick="gotocancel_mode_on();">Cancel Application</button>
        <?php } ?>
        <?php if($fuser_detailset->fu_final_submit != 1 && $fuser_detailset->fu_cancel_stat != 1){ ?>
        <?php //echo form_open_multipart(); ?>
        <button type="button" class="btn btn-warning editbutton" onclick="gotoedit_mode_on();">Edit Previous Data</button>
        <button type="button" class="btn btn-primary submitbutton" onclick="goto_finalsubmit_on();">Final Submission</button>
        <?php //echo form_close(); ?>
        <?php }else{ ?>
          <?php if($fuser_detailset->fu_pay_amount != 0.00 && $fuser_detailset->fu_payment_stat != 1 && $fuser_detailset->fu_cancel_stat != 1){ ?>
          <a href="<?php echo base_url('member/payment_summery') ?>" class="btn btn-primary">Pay Now</a>
        <?php }else{
            if($fuser_detailset->fu_payment_stat == 1 && $fuser_detailset->fu_cancel_stat != 1){ ?>
          <a href="<?php echo base_url('member/finalsubmission_printout') ?>" class="btn btn-success" target="_blank">Print Form</a>
        <?php  }}
        } ?>
      <?php }else{ ?>
        <?php if($fuser_detailset->fu_payment_stat == 1 && $fuser_detailset->fu_cancel_stat != 1){ ?>
          <a href="<?php echo base_url('member/finalsubmission_printout') ?>" class="btn btn-success" target="_blank">Print Form</a>
        <?php  } ?>
      <?php } ?>
</div>
 
 
  
</div>
<?php $this->load->view('main/component/footer'); ?>

<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
		$('.alert-error, .text-error').delay(8000).fadeOut();
		//$('[data-toggle="tooltip"]').tooltip();
	});
</script>


<?php if((strtotime($adv_detail->adv_end_time) > strtotime(date('Y-m-d H:i:s'))) && $fuser_detailset->fu_final_submit != 1 && $fuser_detailset->fu_cancel_stat != 1){ ?>
<script type="text/javascript">

function gotoedit_mode_on(){
  $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', true);
  $('.div_roller_total').fadeIn();
  var e_error = 0;
  //alert(salts);
  var refno = $('#refno').val();

  if(refno == ""){
    e_error = 1;
    error_message = error_message + 'Registration Number not Found, Refresh the Page.';
  }
  if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      $('.get_error_total').html(error_message);
      $(".get_error_total").fadeIn();
      $(".text-error").fadeIn();
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, delay);

      } else {
        var conf_answer = confirm("Warning! You are going to edit all information! Are you sure you want to Process for Edit?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/editmode_processing"; ?>',
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
              //alert(data.msg);
              if (data.msg == 1)
              {
                //console.log(data);
                //alert(data.msg[0].space_rate);
                $('.div_roller_total').fadeOut();
                $('.get_success_total').html('Edit Mode is Processing. Please Wait...');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/dashboard') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
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
          $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on(){
    //alert('Working to Process for Payment Clearence');
    $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    //alert(salts);
    var refno = $('#refno').val();

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }
    if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      $('.get_error_total').html(error_message);
      $(".get_error_total").fadeIn();
      $(".text-error").fadeIn();
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, delay);

      } else {
        var conf_answer = confirm("Warning! You are going to final submission of all information! Are you sure you want to Process?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/finalsubmitmode_processing"; ?>',
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
              //alert(data.msg);
              if (data.msg == 1)
              {
                //console.log(data);
                //alert(data.msg[0].space_rate);
                $('.div_roller_total').fadeOut();
                $('.get_success_total').html('Final Submission is Done. Waiting for Payment Calculation.');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/payment_summery') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
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
          $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
        }

      }
}


</script>
<?php } ?>
<script type="text/javascript">
function gotocancel_mode_on(){
    //alert('Working to Process for Payment Clearence');
    $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    //alert(salts);
    var refno = $('#refno').val();

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }
    if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      $('.get_error_total').html(error_message);
      $(".get_error_total").fadeIn();
      $(".text-error").fadeIn();
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, delay);

      } else {
        var conf_answer = confirm("Warning! You are going to Cancel the Application! Are you sure you want to Process?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/cancellationmode_processing"; ?>',
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
              //alert(data.msg);
              if (data.msg == 1)
              {
                //console.log(data);
                //alert(data.msg[0].space_rate);
                $('.div_roller_total').fadeOut();
                $('.get_success_total').html('Your Application is Successfully Cancelled. Thank You.');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/dashboard') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
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
          $('.cancelbutton, .editbutton, .submitbutton').prop('disabled', false);
        }

      }
}
</script>