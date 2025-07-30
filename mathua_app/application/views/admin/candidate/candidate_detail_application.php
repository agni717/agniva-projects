<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

<?php $urllink = base_url().'upload_file/'.$appli_details->f_applied_for.'/candidates/'.$appli_details->f_application_no.'/'; ?>
        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Application No - <span style="color:blue"><?php echo $appli_details->f_application_no; ?></span>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Application Details</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12"><?php $utype = $this->session->userdata['utype'];
			$accessarray = explode(",",$u_details->u_access_area);
			//print_r($accessarray);
			//print_r($appli_details); ?>
              <!-- Custom tabs (Charts with tabs)-->
			
			<?php if($this->session->flashdata('success')) { ?>
			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php $this->session->unset_userdata('success'); }
		    	elseif($this->session->flashdata('e_error')) { ?>                
	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
		    <?php $this->session->unset_userdata('e_error'); } ?>
			
              <!-- TO DO List -->
              <div class="box box-warning">
                <!-- /.box-header -->
                <div class="box-body">
				  <div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered">
							<tr>
								<td><strong>Recruitment For :</strong></td>
								<td><?php echo $appli_details->rm_name; ?></td>
								<td><strong>Advertisement No. :</strong></td>
								<td><?php echo $appli_details->adv_no; ?></td>
								<td align="center" rowspan="6">
									<?php if($accessarray[0] == "ALL" || in_array("fu_photo_doc", $accessarray)){ ?>
									<img src="<?php echo $urllink.$appli_details->fu_photo_doc; ?>" style="max-width:200px;" />
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_signature_doc", $accessarray)){ ?>
									<br/><strong>Signature Document</strong><br/>
									<img src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>" style="max-width:200px;" />
									<?php } ?>
								</td>
							</tr>
							<tr>
								<td><strong>Full Name :</strong></td>
								<td><?php echo $appli_details->f_full_name; ?></td>
								<td><strong>Apply Discipline :</strong></td>
								<td><?php echo $discip_details->catm_name; ?></td>
							</tr>
							<tr>
								<?php if($accessarray[0] == "ALL" || in_array("f_mobile", $accessarray)){ ?>
								<td><strong>Mobile :</strong></td>
								<td><?php echo $appli_details->f_mobile; ?></td>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("f_email", $accessarray)){ ?>
								<td><strong>Email :</strong></td>
								<td><?php echo $appli_details->f_email; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($accessarray[0] == "ALL" || in_array("fu_father_name", $accessarray)){ ?>
								<td><strong>Father's Name :</strong></td>
								<td><?php echo $appli_details->fu_father_name; ?></td>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_mother_name", $accessarray)){ ?>
								<td><strong>Mother's Name :</strong></td>
								<td><?php echo $appli_details->fu_mother_name; ?></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($accessarray[0] == "ALL" || in_array("fu_dob", $accessarray)){ ?>
								<td><strong>Date of Birth :</strong></td>
								<td><?php echo date('d-m-Y',strtotime($appli_details->fu_dob)); ?></td>
								<td><strong>DOB Document :</strong></td>
								<td><a href="<?php echo $urllink.$appli_details->fu_dob_doc; ?>" target="_blank">Attached Document</a></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($accessarray[0] == "ALL" || in_array("fu_gender", $accessarray)){ ?>
								<td><strong>Gender :</strong></td>
								<td><?php echo $appli_details->fu_gender; ?></td>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_marital_status", $accessarray)){ ?>
								<td><strong>Marital Status :</strong></td>
								<td><?php echo $appli_details->fu_marital_status; ?></td>
								<?php } ?>
							</tr>
							<tr><td colspan="5"><hr style="border-color:#ccc" /></td></tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_address", $accessarray)){ ?>
								<tr>
									<td colspan="5"><strong><u>Present Address</u></strong></td>
								</tr>
								<tr>
									<td colspan="2"><label><strong>State :</strong></label> <?php foreach ($state_list as $states) {
										if ($states->state_id == $appli_details->fu_state) { echo $states->state_name;break; }
									} ?></td>
									<?php if($appli_details->fu_state == 28){ ?>  
									<td colspan="3"><label><strong>District :</strong></label> <?php foreach ($dist_list as $dists) { 
									if ($dists->district_code == $appli_details->fu_district) { echo $dists->district_name; }
									} ?></td>
									<?php }else{ ?>
									<td colspan="3"><label><strong>District :</strong></label> <?php echo $appli_details->fu_other_district; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<?php if($appli_details->fu_state == 28){ ?>
									<td colspan="2"><label><strong>Sub-Division :</strong></label> <?php foreach ($sub_division as $sd) { 
									if ($appli_details->fu_sub_division == $sd->subdiv_id){ echo $sd->subdiv_name; }
									} ?></td>
									<td colspan="3"><label><strong>Block/ Municipality :</strong></label>  
									<?php $bmset = '';
									foreach ($block_municipality as $bm) { 
										if ($bm->block_id == $appli_details->fu_block_municipality) {$bmset = $bm->block_name;}
									} ?>
									<?php echo $appli_details->fu_mb_type.' ('.$bmset.')'; ?></td>
									<?php }else{ ?>
									<td colspan="2"><label><strong>Sub-Division :</strong></label> <?php echo $appli_details->fu_other_sdiv; ?></td>
									<td colspan="3"><label><strong>Block/ Municipality :</strong></label> <?php echo $appli_details->fu_other_blockm; ?></td>
									<?php } ?>
								</tr>
								<tr>
									<?php if($appli_details->fu_state == 28){ ?>
									<td colspan="2"><label><strong>Police Station :</strong></label> <?php foreach ($police_station as $ps) { 
										if ($appli_details->fu_police_station == $ps->ps_id) {echo $ps->ps_name;}
									} ?></td>
									<?php }else{ ?>
									<td colspan="2"><label><strong>Police Station :</strong></label> <?php echo $appli_details->fu_other_ps; ?></td>
									<?php } ?>
									<td colspan="3"><label><strong>Ward/GP : </strong></label> <?php echo $appli_details->fu_ward_gp; ?></td>
								</tr>
								<tr>
									<td colspan="2"><label><strong>Vill / Para / House No / Road :</strong></label> <?php echo $appli_details->fu_house_road; ?></td>
									<td colspan="3"><label><strong>Post Office : </strong></label> <?php echo $appli_details->fu_post_office; ?> </td>
								</tr>
								<tr>
									<td colspan="5"><label><strong>Pin :</strong></label> <?php echo $appli_details->fu_pincode; ?></td>
								</tr>
								<?php if($appli_details->fu_same_address == "No"){ ?>
									<tr>
									<td colspan="5"><strong>Permanenet Address</strong></td>
									</tr>
									<tr>
									<td colspan="2"><label><strong>State :</strong></label> <?php foreach ($state_list as $states) {
										if ($states->state_id == $appli_details->fu_perma_state) { echo $states->state_name;break; }
										} ?></td>
									<?php if($appli_details->fu_perma_state == 28){ ?>  
									<td colspan="3"><label><strong>District :</strong></label> <?php foreach ($dist_list as $dists) { 
										if ($dists->district_code == $appli_details->fu_perma_dist) { echo $dists->district_name;break; }
										} ?></td>
									<?php }else{ ?>
										<td colspan="3"><label><strong>District :</strong></label> <?php echo $appli_details->fu_perma_other_district; ?></td>
									<?php } ?>
									</tr>
									<tr>
									<?php if($appli_details->fu_perma_state == 28){ ?>
									<td colspan="2"><label><strong>Sub-Division :</strong></label> <?php foreach ($per_sub_division as $sd) { 
										if ($appli_details->fu_perma_sub_division == $sd->subdiv_id){ echo $sd->subdiv_name; }
										} ?></td>
									<td colspan="3"><label><strong>Block/ Municipality :</strong></label>  
									<?php $bmset = '';
									foreach ($per_block_municipality as $bm) { 
										if ($bm->block_id == $appli_details->fu_perma_block_municipality) {$bmset = $bm->block_name;}
										} ?>
									<?php echo $appli_details->fu_perma_mb_type.' ('.$bmset.')'; ?></td>
									<?php }else{ ?>
										<td colspan="2"><label><strong>Sub-Division :</strong></label> <?php echo $appli_details->fu_perma_other_sdiv; ?></td>
										<td colspan="3"><label><strong>Block/ Municipality :</strong></label> <?php echo $appli_details->fu_perma_other_blockm; ?></td>
									<?php } ?>
									</tr>
									<tr>
									<?php if($appli_details->fu_perma_state == 28){ ?>
									<td colspan="2"><label><strong>Police Station :</strong></label> <?php foreach ($per_police_station as $ps) { 
										if ($appli_details->fu_perma_police_station == $ps->ps_id) {echo $ps->ps_name;}
										} ?></td>
									<?php }else{ ?>
										<td colspan="2"><label><strong>Police Station :</strong></label> <?php echo $appli_details->fu_perma_other_ps; ?></td>
									<?php } ?>
									<td colspan="3"><label><strong>Ward/GP : </strong></label> <?php echo $appli_details->fu_perma_ward_gp; ?></td>
									</tr>
									<tr>
									<td colspan="2"><label><strong>Vill / Para / House No / Road :</strong></label> <?php echo $appli_details->fu_perma_house_road; ?></td>
									<td colspan="3"><label><strong>Post Office : </strong></label> <?php echo $appli_details->fu_perma_post_office; ?> </td>
									</tr>
									<tr>
									<td colspan="5"><label><strong>Pin :</strong></label> <?php echo $appli_details->fu_perma_pincode; ?></td>
									</tr>
									<tr>
									<td colspan="5"><label><strong>Comunication Address :</strong></label> <?php echo $appli_details->fu_comunication_address; ?> Address </td>
									</tr>
								<?php }else{ ?>
									<tr>
									<td colspan="5"><label><strong>(Permanenet Address is Same as Present Address)</strong></label></td>
									</tr>
								<?php } ?>
							
								<?php //echo $appli_details->fu_address; ?>
							
							<tr>
								<td><strong>Address Proof :</strong></td>
								<td colspan="4"><a href="<?php echo $urllink.$appli_details->fu_address_doc; ?>" target="_blank">Attached Document</a></td>
								<!--<?php //if($accessarray[0] == "ALL" || in_array("fu_signature_doc", $accessarray)){ ?>
								<td><strong>Signature Document</strong></td>
								<td colspan="2"><a href="<?php //echo $urllink.$appli_details->fu_signature_doc; ?>" target="_blank">Attached Document</a></td>
								<?php //} ?>-->
							</tr>
							<?php } ?>
							<tr><td colspan="5"><hr style="border-color:#ccc" /></td></tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){ ?>
							<tr>
								<td><strong>Caste :</strong></td>
								<td colspan="4"><?php $excattype = '';
								foreach ($caste_tab as $caste) : ?>
								<?php if ($appli_details->fu_caste_type == $caste->caste_id){ echo $caste->caste_name;$excattype = $caste->caste_cat; } ?>
								<?php endforeach; ?></td>
							</tr>
							<?php if($appli_details->fu_caste_type != 1){ ?>
								<?php if($excattype == 2){ ?>
							<tr>
								<td><strong>Caste/ Tribe/ Community :</strong></td>
								<td><?php echo $caste_community->csdetail_name; ?></td>
								<td><strong>Caste Number :</strong></td>
								<td colspan="2"><?php echo $appli_details->fu_caste_number; ?></td>
							</tr>
							<tr>
								<td><strong>Caste (Issue By) :</strong></td>
								<td><?php foreach ($caste_issuing_auth as $auth){
            					if ($appli_details->fu_caste_issue_whom == $auth->cia_id) {echo $auth->cia_name;break;}} ?></td>
								<td><strong>Caste (Issue Date) :</strong></td>
								<td colspan="2"><?php echo date('d-m-Y',strtotime($appli_details->fu_caste_issue_date)); ?></td>
							</tr>
							<tr>
								<td><strong>Caste Document :</strong></td>
								<td colspan="4"><a href="<?php echo $urllink.$appli_details->fu_caste_doc; ?>" target="_blank">Attached Document</a></td>
							</tr>
							<?php } ?>
							<?php }} ?>
							<?php if($accessarray[0] == "ALL" || in_array("fu_pwd", $accessarray)){ ?>
							<tr>
								<td><strong>Is PWD :</strong></td>
								<td colspan="4"><?php echo $appli_details->fu_pwd; ?></td>
							</tr>
							<?php if($appli_details->fu_pwd == "Yes"){ ?>
							<tr>
								<td><strong>Percent of PWD :</strong></td>
								<td><?php echo $appli_details->fu_pwd_percent."%"; ?></td>
								<td><strong>PWD (Issue By) :</strong></td>
								<td colspan="2"><?php echo $appli_details->fu_pwd_issue_whom; ?></td>
							</tr>
							<tr>
								<td><strong>PWD (Issue Date) :</strong></td>
								<td><?php echo date('d-m-Y',strtotime($appli_details->fu_pwd_issue_date)); ?></td>
								<td><strong>PWD Document :</strong></td>
								<td colspan="2"><a href="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>" target="_blank">Attached Document</a></td>
							</tr>
							<?php }} ?>
							<?php if($appli_details->fu_exempted == "Yes"){
								if($accessarray[0] == "ALL" || in_array("fu_exempted", $accessarray)){ ?>
							<tr>
								<td><strong>Exempted Category :</strong></td>
								<td colspan="4"><?php echo $appli_details->fu_exempted; ?></td>
							</tr>
							<tr>
								<td><strong>Description of Exempted :</strong></td>
								<td><?php echo $appli_details->fu_exc_reason; ?></td>
								<td><strong>Document of Exempted :</strong></td>
								<td colspan="2"><a href="<?php echo $urllink.$appli_details->fu_exc_doc; ?>" target="_blank">Attached Document</a></td>
							</tr>
							<?php }} ?>
							<?php if($appli_details->fu_exservice == "Yes"){
								if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){ ?>
							<tr>
								<td><strong>Ex-Serviceman Category :</strong></td>
								<td colspan="4"><?php echo $appli_details->fu_exservice; ?></td>
							</tr>
							<tr>
								<td><strong>Description of Ex-Serviceman :</strong></td>
								<td><?php echo $appli_details->fu_exs_reason; ?></td>
								<td><strong>Document of ExService :</strong></td>
								<td colspan="2"><a href="<?php echo $urllink.$appli_details->fu_exs_doc; ?>" target="_blank">Attached Document</a></td>
							</tr>
							<?php }} ?>
							<?php if($appli_details->fu_ews == "Yes"){
								if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){ ?>
							<tr>
								<td><strong>Sportsman Category :</strong></td>
								<td colspan="4"><?php echo $appli_details->fu_ews; ?></td>
							</tr>
							<tr>
								<td><strong>Description of Sportsman :</strong></td>
								<td><?php echo $appli_details->fu_ews_reason; ?></td>
								<td><strong>Document of Sportsman :</strong></td>
								<td colspan="2"><a href="<?php echo $urllink.$appli_details->fu_ews_doc; ?>" target="_blank">Attached Document</a></td>
							</tr>
							<?php }} ?>
							<?php if($accessarray[0] == "ALL" || in_array("fu_age_relax", $accessarray)){ ?>
								<?php foreach($spclage_list as $spageitems){ ?>
									<tr>
										<td><strong><?php echo $spageitems->caste_name; ?> :</strong></td>
										<td colspan="4"><?php echo $spageitems->fu_ext_answer; ?></td>
									</tr>
									<?php if($spageitems->fu_ext_answer == "Yes"){ ?>
									<tr>
										<td><strong>Reason :</strong></td>
										<td><?php echo $spageitems->fu_ext_reason; ?></td>
										<td><strong>Document :</strong></td>
										<td colspan="2"><a href="<?php echo $urllink.$spageitems->fu_ext_doc; ?>" target="_blank">Attached Document</a></td>
									</tr>
								<?php }
								} ?>
							<?php } ?>
							<tr><td colspan="5"><hr style="border-color:#ccc" /></td></tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_qualification", $accessarray)){ ?>
							<?php if(!empty($quali_details)){ ?>
							<tr>
								<td colspan="5">
								<strong><u>Essential Qualification</u></strong>
								<table class="table table-bordered table-striped">
									<tr>
									<td><b>Qualification</b></td>
									<td><b>Council/ Univercity</b></td>
									<td><b>State of Passing</b></td>
									<td><b>Full Marks</b></td>
									<td><b>Marks Obtained</b></td>
									<td><b>Percentage of Marks</b></td>
									<td><b>Additional Attempt</b></td>
									<td><b>No. of Attempt</b></td>
									<td><b>Attachment</b></td>
									</tr>
									<?php foreach($quali_details as $qips){ ?>
									<tr>
										<td><?php echo $qips->qm_name; ?></td>
										<td><?php echo $qips->fu_council_board; ?></td>
										<td><?php echo $qips->state_name; ?></td>
										<td><?php echo $qips->fu_full_marks; ?></td>
										<td><?php echo $qips->fu_marks_obtained; ?></td>
										<td><?php echo $qips->fu_percent_of_marks; ?></td>
										<td><?php echo $qips->fu_is_attempt; ?></td>
										<td><?php echo $qips->fu_attempt_no; ?></td>
										<td><a href="<?php echo $urllink.$qips->fu_quali_docs; ?>" target="_blank">Attached Document</a></td>
									</tr>
									<?php } ?>
								</table>
								</td>
							</tr>
							<?php }
							if(!empty($des_quali_details)){ ?>
							<tr>
								<td colspan="5">
								<strong><u>Desirable Qualification</u></strong>
								<table class="table table-bordered table-striped">
									<tr>
									<td><b>Qualification</b></td>
									<td><b>Council/ Univercity</b></td>
									<td><b>State of Passing</b></td>
									<td><b>Full Marks</b></td>
									<td><b>Marks Obtained</b></td>
									<td><b>Percentage of Marks</b></td>
									<td><b>Additional Attempt</b></td>
									<td><b>No. of Attempt</b></td>
									<td><b>Attachment</b></td>
									</tr>
									<?php foreach($des_quali_details as $qips){ ?>
									<tr>
										<td><?php echo $qips->qm_name; ?></td>
										<td><?php echo $qips->fud_council_board; ?></td>
										<td><?php echo $qips->state_name; ?></td>
										<td><?php echo $qips->fud_full_marks; ?></td>
										<td><?php echo $qips->fud_marks_obtained; ?></td>
										<td><?php echo $qips->fud_percent_of_marks; ?></td>
										<td><?php echo $qips->fud_is_attempt; ?></td>
										<td><?php echo $qips->fud_attempt_no; ?></td>
										<td><a href="<?php echo $urllink.$qips->fud_quali_docs; ?>" target="_blank">Attached Document</a></td>
									</tr>
									<?php } ?>
								</table>
								</td>
							</tr>
							<?php }} ?>
							<tr><td colspan="5"><hr style="border-color:#ccc" /></td></tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_has_service", $accessarray)){ ?>
							<tr>
								<td><strong>Has Service Experience :</strong></td>
								<td colspan="4"><?php echo $appli_details->fu_has_service; ?></td>
							</tr>
							<?php if($appli_details->fu_has_service == "Yes"){ ?>
							<tr>
								<td colspan="5">
								<strong><u>Essential Experience</u></strong>
								<table class="table table-bordered table-striped">
									<tr>
									<td><strong>Category</strong></td>
									<td><strong>Organization</strong></td>
									<td><strong>Time Period</strong></td>
									<td><strong>Upload Certificate</strong></td>
									</tr>
									<?php foreach($essenexp_details as $expss){ ?>
									<tr>
									<td><?php echo $expss->expset_name; ?></td>
									<td><?php echo $expss->fues_exp_org_name; ?></td>
									<td><?php echo $expss->fues_exp_year.' Year & '.$expss->fues_exp_month.' Month'; ?></td>
									<td><a href="<?php echo $urllink.$expss->fues_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a></td>
									</tr>
									<?php } ?>
								</table>
								</td>
							</tr>
							<?php if(!empty($exp_details)){ ?>
							<tr>
								<td colspan="5">
								<strong><u>Desirable Experience</u></strong>
								<table class="table table-bordered table-striped">
									<tr>
									<td><strong>Category</strong></td>
									<td><strong>Organization</strong></td>
									<td><strong>Time Period</strong></td>
									<td><strong>Upload Certificate</strong></td>
									</tr>
									<?php foreach($exp_details as $expss){ ?>
									<tr>
									<td><?php echo $expss->expset_name; ?></td>
									<td><?php echo $expss->fu_exp_org_name; ?></td>
									<td><?php echo $expss->fu_exp_year.' Year & '.$expss->fu_exp_month.' Month'; ?></td>
									<td><a href="<?php echo $urllink.$expss->fu_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a></td>
									</tr>
									<?php } ?>
								</table>
								</td>
							</tr>
							<?php } ?>
							<?php }} ?>
							<tr><td colspan="5"><hr style="border-color:#ccc" /></td></tr>
							<tr>
								<td><strong>Payment Amount :</strong></td>
								<td colspan="3"><?php echo $appli_details->fu_pay_amount; ?></td>
							</tr>
						</table>
					</div>
				  </div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 



<div id="myModalView" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title">Query Number : <span class="q_number_set"></span></h4>
	  </div>
	  <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
				  <div class="col-sm-12" style="padding-bottom:5px;">
					<strong class="">Subject : <span class="q_subject_set"></span></strong>
				  </div>
				  <div class="col-md-7">
					<div class="alert-info" role="alert" style="padding:5px;">
						<div class="q_detail_set" style="margin-bottom:5px;"></div>
						<div class="text-bold mainAttachment">Attachment : <span class="q_attach_set"></span></div>
					</div>
				  </div>
				</div>
				<div>&nbsp;</div>
				<div class="row replytab">
				  <div class="col-md-7 col-md-offset-5">
					<div class="" style="padding:5px;">
						<strong class="">Administrator Reply:-</strong>
					</div>
					<div class="alert-warning" role="alert" style="padding:5px;">
						<div class="q_reply_set" style="margin-bottom:5px;"></div>
						<div class="text-bold haveAttachment">Attachment : <span class="q_reply_attach_set"></span></div>
					</div>
				  </div>
				</div>
			</div>
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
	  </div>
	</div>

</div>
</div>


<div id="myModalReply" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title">Query Number : <span class="q_number_set"></span></h4>
	  </div>
	  <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
				  <div class="col-sm-12" style="padding-bottom:5px;">
					<strong class="">Subject : <span class="q_subject_set"></span></strong>
				  </div>
				  <div class="col-md-7">
					<div class="alert-info" role="alert" style="padding:5px;">
						<div class="q_detail_set" style="margin-bottom:5px;"></div>
						<div class="text-bold mainAttachment">Attachment : <span class="q_attach_set"></span></div>
					</div>
				  </div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<h3>Administrator Reply</h3>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Reply in Details <span style="color:red">*</span></label>
						<div class="col-sm-9">
						  <input type="hidden" name="query_no" id="query_no" autocomplete="off" />
						  <textarea class="form-control" name="reply_comment" style="resize:none;" id="reply_comment" autocomplete="off"></textarea>
						  <small class="text-error reply_comment"><?php echo form_error('reply_comment'); ?></small>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
					<div class="form-group">
						<label class="col-md-3 text-right" style="margin-top: 7px;">Upload Attachment</label>
						<div class="col-md-6">
							<input type="file" class="form-control" name="files" id="files" autocomplete="off" />
							<small class="text-error files"><?php echo form_error('files'); ?></small>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
					<div  class="col-sm-12 text-center">
						<div align="center">
							<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						</div>
					</div>
				</div>
			</div>
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="goto_clickbutton_administrator();">Submit</button>
	  </div>
	</div>

</div>
</div>
<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	      $("#datatable_tab").dataTable();
		});
		
		function goto_details_view(q_no){
			if(q_no != ""){
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/discussion/getinfo_fromquery_no"; ?>',
					data:{q_no: q_no},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.q_number_set').html(q_no);
							if(data.info_set.query_is_reply == 0){
								$('.replytab').fadeOut();
							}else{
								$('.replytab').fadeIn();
								$('.q_reply_set').html(data.info_set.query_reply_details);
								if(data.info_set.query_reply_attach == null){
									$('.haveAttachment').fadeOut();
								}else{
									$('.haveAttachment').fadeIn();
									$('.q_reply_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/reply/' + data.info_set.query_reply_attach + '" target="_blank" style="color:#111;">Attached Reply Document</a>');
								}
							}
							$('.q_subject_set').html(data.info_set.query_subject);
							$('.q_detail_set').html(data.info_set.query_details);
							if(data.info_set.query_attachment == null){
								$('.mainAttachment').fadeOut();
							}else{
								$('.mainAttachment').fadeIn();
								$('.q_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/' + data.info_set.query_attachment + '" target="_blank" style="color:#111;">Attached Document</a>');
							}
							$('#myModalView').modal('show');
							//setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
							//setTimeout(function(){ window.location.replace("<?php echo site_url('member/testing_list')?>/"); }, 3000);
							
							
						}else{
							error_message = data.e_msg;
							$('.alert-error').html(error_message);
							$(".alert-error").fadeIn();
							//setTimeout(function(){ $('.alert-error').fadeOut(); }, delay);
						}
						
					}
				});
				/*$('#given_by').val(<?php echo $this->session->userdata['utype']; ?>);
				$('#work_no').val(tid);
				*/
			}
		}
		
		function goto_reply_view(q_no){
			if(q_no != ""){
				
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/discussion/getinfo_fromquery_no"; ?>',
					data:{q_no: q_no},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.q_number_set').html(q_no);
							$('.q_subject_set').html(data.info_set.query_subject);
							$('.q_detail_set').html(data.info_set.query_details);
							if(data.info_set.query_attachment == null){
								$('.mainAttachment').fadeOut();
							}else{
								$('.mainAttachment').fadeIn();
								$('.q_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/' + data.info_set.query_attachment + '" target="_blank" style="color:#111;">Attached Document</a>');
							}
							$('#files,#reply_comment').val('');
							$('#query_no').val(q_no);
							$('#myModalReply').modal('show');
							
							
						}else{
							error_message = data.e_msg;
							$('.alert-error').html(error_message);
							$(".alert-error").fadeIn();
							//setTimeout(function(){ $('.alert-error').fadeOut(); }, delay);
						}
						
					}
				});
				
			}
		}
		
		function goto_clickbutton_administrator(){
			$('.div_roller_total').fadeIn();
			var delay = 8000;
			var e_error = 0;
			var error_message = 'There have some errors plese check above, Try again.';
			var alphaletters_spaces = /^[A-Za-z ]+$/;
			var alphaletters = /^[A-Za-z]+$/;
			var alphanumerics = /^[A-Za-z0-9/() ]+$/;
			var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
			var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
			var onlynumerics = /^[0-9]+$/;
			var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
			var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG|\.txt|\.doc|\.docx|\.xls|\.xlsx|\.ppt|\.pptx|\.mp4|\.MP4)$/i;
			
			var form_data = new FormData();
			//var stat_type = $('#stat_type option:selected').val();
			//var work_no = $('#work_no').val();
			//var given_by = $('#given_by').val();
			var reply_comment = $('#reply_comment').val();
			var query_no = $('#query_no').val();
			
			var upload = $('#files').val();
			var files = $('#files')[0].files;
			
			form_data.append("files", files[0]);
			form_data.append("reply_comment", reply_comment);
			form_data.append("query_no", query_no);
			
			if(query_no == ""){
				e_error = 1;
				error_message = error_message + '<br/>There have some problem in page ID, Reload the Page and Try again.';
			}
			
			if(reply_comment == ""){
				e_error = 1;
				$('.reply_comment').html('Reply is Required.');
			}else{
				reply_comment = reply_comment.replace(/(\r\n|\n|\r)/gm, " ");
				if(!reply_comment.match(alphanumerics_no)){
					e_error = 1;
					$('.reply_comment').html('Reply not use special carecters [without _ / : ( @ . & ) , -], Check again.');
				}else{
					$('.reply_comment').html('');
				}	
			}
			
			if(document.getElementById("files").files.length != 0){
				var fileInput = document.getElementById('files'); 
				var filePath = fileInput.value;
				if(!allowedExtensions.exec(filePath)){
					e_error = 1;
					$('.files').html('Attachment File type Invalid.');
				}else{
					$('.files').html('');
				}
				
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
				//alert(task_start_time);exit;
				//alert(rehash);
				//$("#myForm").submit();
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admincontrol/discussion/update_reply_against_query') ?>",
					dataType: 'json',
					data: form_data,
					contentType:false,
					cache:true,
					processData:false,
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Reply is updated agasint the Query Successfully.');
							$(".get_success_total").fadeIn();
							$('input, textarea').val('');
							$('input, textarea').html('');
							setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
							setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/discussion/all_query_list')?>"); }, 3000);
							
						}else{
							$('.div_roller_total').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total').html(error_message);
							$(".get_error_total").fadeIn();
							setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
						}
						
					}
				});
			}
		}
		
    </script>