<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>

<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Candidate's Skip Application
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Skip Application</li>
          </ol>
        </section>
		<?php $str_arr = array(
							//'f_mobile' => 'Mobile',
							//'f_email' => 'Email-ID',
							'fu_dob' => 'Date of Birth',
							'fu_address' => 'Address',
							'fu_photo_doc' => 'Photo',
							'fu_signature_doc' => 'Signature',
							'fu_caste' => 'Caste',
							'fu_pwd' => 'PWD',
							'fu_exempted' => 'Exempted',
							'fu_exservice' => 'Ex-Service',
							'fu_ews' => 'Sportsman',
							'fu_age_relax' => 'Age Relax',
							'fu_es_qualification' => 'Essential Qualification',
							'fu_ds_qualification' => 'Desirable Qualification',
							'fu_has_es_service' => 'Essential Experience',
							'fu_has_ds_service' => 'Desirable Experience'
						); ?>
        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12">
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
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
				<?php echo form_open_multipart('','class="" id="form123"'); ?>
				<div class="row">
				<div class="col-sm-offset-1 col-sm-4">
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" onchange="check_advaction_type();">
							<option value="">---Select---</option>
							<?php foreach($rec_list as $advitems){ ?>
								<option value="<?php echo $advitems->adv_auto_genno; ?>" <?php if(!empty($searchlist['advno'])){if($searchlist['advno'] == $advitems->adv_auto_genno){echo 'selected="selected"';}} ?>><?php echo $advitems->adv_no.' ('.$advitems->rm_name.')'; ?></option>
							<?php } ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
					<label>Discipline Type</label>
				    	<select class="form-control selectpicker" name="adv_post_type" id="adv_post_type" autocomplete="off">
							<option value="ALL">ALL</option>
					  	</select>
				      	<small class="text-error adv_post_type"><?php echo form_error('adv_post_type'); ?></small>
				    </div>
				</div>
				<div class="col-sm-3 subtype_sets" style="display:none;">
					<div class="form-group">
					<label>Sub Type</label>
				    	<select class="form-control selectpicker" name="sub_type" id="sub_type" autocomplete="off">
							<option value="">---Select---</option>
					  	</select>
				      	<small class="text-error sub_type"><?php echo form_error('sub_type'); ?></small>
				    </div>
				</div>
				<div class="col-sm-offset-1 col-sm-9">
				  <div class="form-group">
					<label>Access Type</label>
					<div>
						<?php foreach($uaccess as $accitems){ ?>
							<label class="radio-inline"><input type="radio" name="u_accs" value="<?php echo $accitems; ?>" <?php if(!empty($searchlist['u_accs'])){ if($searchlist['u_accs'] == $accitems){echo 'checked';}} ?> onchange="check_advaction_type();"><?php echo $str_arr[$accitems]; ?></label>
						<?php } ?>
					</div>
				      	<small class="text-error u_accs"><?php echo form_error('u_accs'); ?></small>
				  </div>
				</div>
				<div class="col-sm-2 text-left" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="col-sm-12">
       				 <div class="form-group">	
					    <div align="center">
								<div class="get_error_total1" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total1" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total1" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						  </div>
				    </div>
                </div>
				
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body"><?php if(!empty($appli_details)){
					//print_r($u_details);
					//print_r($appli_details); ?>
					<?php $urllink = base_url().'upload_file/'.$appli_details->f_applied_for.'/candidates/'.$appli_details->f_application_no.'/'; ?>
					<h3>Checking For - <?php echo $str_arr[$accessarray[0]]; ?></h3>
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab123" style="border:1px solid #000" width="100%">
                  	<tbody>
						<tr>
							<td width="50%">
								<table>
									<tr>
										<td><strong>Recruitment For</strong></td>
										<td><?php echo $appli_details->rm_name; ?></td>
									</tr>
									<tr>
										<td><strong>Application No.</strong></td>
										<td><?php echo $appli_details->f_application_no; ?></td>
									</tr>
									<tr>
										<td><strong>Advertisement No.</strong></td>
										<td><?php echo $appli_details->adv_no; ?></td>
									</tr>
									<tr>
										<td><strong>Full Name</strong></td>
										<td><?php echo $appli_details->f_full_name; ?></td>
									</tr>
									<tr>
										<td><strong>Apply Discipline</strong></td>
										<td><?php echo $discip_details->catm_name; ?></td>
									</tr>
									<?php if($accessarray[0] == "ALL" || in_array("f_mobile", $accessarray)){ ?>
									<tr>
										<td><strong>Mobile</strong></td>
										<td><?php echo $appli_details->f_mobile; ?></td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("f_email", $accessarray)){ ?>
									<tr>
										<td><strong>Email</strong></td>
										<td><?php echo $appli_details->f_email; ?></td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_dob", $accessarray)){ ?>
									<tr>
										<td><strong>Date of Birth</strong></td>
										<td><?php echo date('d-m-Y',strtotime($appli_details->fu_dob)); ?></td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_address", $accessarray)){ ?>
										<tr>
											<td colspan="5"><strong>Present Address</strong></td>
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
											<td colspan="3"><label><strong>Block/ Municipality :</strong>:</label>  
											<?php foreach ($block_municipality as $bm) { 
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
											<td colspan="3"><label><strong>Block/ Municipality :</strong>:</label>  
											<?php foreach ($per_block_municipality as $bm) { 
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
											<td colspan="5"><label><strong>Permanenet Address is Same as Present Address</strong></label></td>
											</tr>
										<?php } ?>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){ ?>
									<tr>
										<td><strong>Has Caste</strong></td>
										<td><?php echo $appli_details->caste_name; ?></td>
									</tr>
									
									<?php if($appli_details->fu_caste_type != 1){ ?>
									<tr>
										<td><strong>Caste Number</strong></td>
										<td><?php echo $appli_details->fu_caste_number; ?></td>
									</tr>
									<tr>
										<td><strong>Caste/ Tribe/ Community</strong></td>
										<td><?php echo $caste_community->csdetail_name; ?></td>
									</tr>
									<tr>
										<td><strong>Caste (Issue By)</strong></td>
										<td><?php foreach ($caste_issuing_auth as $auth){
            								if ($appli_details->fu_caste_issue_whom == $auth->cia_id) {echo $auth->cia_name;break;}} ?></td>
									</tr>
									<tr>
										<td><strong>Caste (Issue Date)</strong></td>
										<td><?php echo date('d-m-Y',strtotime($appli_details->fu_caste_issue_date)); ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_pwd", $accessarray)){ ?>
									<tr>
										<td><strong>Is PWD</strong></td>
										<td><?php echo $appli_details->fu_pwd; ?></td>
									</tr>
									<?php if($appli_details->fu_pwd == "Yes"){ ?>
									<tr>
										<td><strong>Percent of PWD</strong></td>
										<td><?php echo $appli_details->fu_pwd_percent; ?></td>
									</tr>
									<tr>
										<td><strong>PWD (Issue By)</strong></td>
										<td><?php echo $appli_details->fu_pwd_issue_whom; ?></td>
									</tr>
									<tr>
										<td><strong>PWD (Issue Date)</strong></td>
										<td><?php echo date('d-m-Y',strtotime($appli_details->fu_pwd_issue_date)); ?></td>
									</tr>
									
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_exempted", $accessarray)){ ?>
									<tr>
										<td><strong>Is Exempted</strong></td>
										<td><?php echo $appli_details->fu_exempted; ?></td>
									</tr>
									<?php if($appli_details->fu_exempted == "Yes"){ ?>
									<tr>
										<td><strong>Reason of Exempted</strong></td>
										<td><?php echo $appli_details->fu_exc_reason; ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){ ?>
									<tr>
										<td><strong>Is ExService</strong></td>
										<td colspan="4"><?php echo $appli_details->fu_exservice; ?></td>
									</tr>
									<?php if($appli_details->fu_exservice == "Yes"){ ?>
									<tr>
										<td><strong>Reason of ExService</strong></td>
										<td><?php echo $appli_details->fu_exs_reason; ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){ ?>
									<tr>
										<td><strong>Has EWS</strong></td>
										<td colspan="4"><?php echo $appli_details->fu_ews; ?></td>
									</tr>
									<?php if($appli_details->fu_ews == "Yes"){ ?>
									<tr>
										<td><strong>Reason of Relaxation</strong></td>
										<td><?php echo $appli_details->fu_ews_reason; ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_qualification", $accessarray)){ ?>
									<?php if(!empty($quali_details)){ ?>
									<tr>
										<td colspan="2">
										<strong>Essential Qualification</strong>
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
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php } ?>
									<?php if(!empty($des_quali_details)){ ?>
									<tr>
										<td colspan="2">
										<strong>Dessirable Qualification</strong>
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
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php } ?>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_has_service", $accessarray)){ ?>
									<tr>
										<td><strong>Has Service Experience</strong></td>
										<td><?php echo $appli_details->fu_has_service; ?></td>
									</tr>
									<?php if($appli_details->fu_has_service == "Yes"){ ?>
									<tr>
										<td colspan="2">
										<strong>Essential Experience</strong>
										<table class="table table-bordered table-striped">
											<tr>
											<td><strong>Sl No.</strong></td>
											<td><strong>Experience Category</strong></td>
											<td><strong>Organization</strong></td>
											<td><strong>Time Period</strong></td>
											</tr>
											<?php foreach($essenexp_details as $keys=>$expss){ ?>
											<tr>
											<td><?php echo ($keys+1); ?></td>
											<td><?php echo $expss->expset_name; ?></td>
											<td><?php echo $expss->fues_exp_org_name; ?></td>
											<td><?php echo $expss->fues_exp_year.' Year & '.$expss->fues_exp_month.' Month'; ?></td>
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php if(!empty($exp_details)){ ?>
									<tr>
										<td colspan="2">
										<strong>Desireable Experience</strong>
										<table class="table table-bordered table-striped">
											<tr>
											<td><strong>Sl No.</strong></td>
											<td><strong>Experience Category</strong></td>
											<td><strong>Organization</strong></td>
											<td><strong>Time Period</strong></td>
											</tr>
											<?php foreach($exp_details as $keys=>$expss){ ?>
											<tr>
											<td><?php echo ($keys+1); ?></td>
											<td><?php echo $expss->expset_name; ?></td>
											<td><?php echo $expss->fu_exp_org_name; ?></td>
											<td><?php echo $expss->fu_exp_year.' Year & '.$expss->fu_exp_month.' Month'; ?></td>
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php } ?>
									<?php }} ?>
									<tr>
										<td colspan="2">
											<div>
											  <!--<a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-lg btn-primary">Give Your Approval</a>-->
												<div style="clear:both;">&nbsp;</div>
													<div class="form-group">
														<label class="col-sm-3 control-label text-right">Your Comments <!--<font style="color: red;">*</font>--></label>
														<div class="col-sm-9">
														<textarea class="form-control" name="app_comment" style="resize:none;" id="app_comment" autocomplete="off"></textarea>
														<small class="text-error app_comment"><?php echo form_error('app_comment'); ?></small>
													</div>
												</div>
											    <div  class="col-sm-12 text-center">
													<div align="center">
														<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
													</div>
												</div>
												<div  class="col-sm-12 text-center">
											  	<button type="button" class="btn btn-primary" onclick="gotoclclickbutton('Approved');">Approve</button>
												<button type="button" class="btn btn-danger" onclick="gotoclclickbutton('Rejected');">Reject</button>
												<button type="button" class="btn btn-warning" onclick="gotoclclickbutton('Doubtful');">Mark as Doubtful</button>
												<button type="button" class="btn btn-info" onclick="gotoclclickbutton('Skip');">Skip</button>
												</div>
											  <!--<a href="#" class="btn btn-danger">Reject</a>
											  <a href="#" class="btn btn-warning">Doubtful</a>-->
										  	</div>
										</td>
									</tr>
								</table>
							</td>
							<td width="50%" align="left">
								<?php if($accessarray[0] == "ALL" || in_array("fu_photo_doc", $accessarray)){ ?>
								<strong>Candidate Photograph -<a href="<?php echo $urllink.$appli_details->fu_photo_doc; ?>" target="_blank">Check Here</a></strong><br/>
								<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_photo_doc; ?>"></iframe><br/>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_dob", $accessarray)){ ?>
								<strong>DOB Document -<a href="<?php echo $urllink.$appli_details->fu_dob_doc; ?>" target="_blank">Check Here</a></strong><br/>
								<?php if(strtolower(substr($appli_details->fu_dob_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_dob_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_dob_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_address", $accessarray)){ ?>
								<strong>Address Proof -<a href="<?php echo $urllink.$appli_details->fu_address_doc; ?>" target="_blank">Check Here</a></strong><br/>
								<?php if(strtolower(substr($appli_details->fu_address_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_address_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_address_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_signature_doc", $accessarray)){ ?>
								<strong>Signature Document -<a href="<?php echo $urllink.$appli_details->fu_signature_doc; ?>" target="_blank">Check Here</a></strong><br/>
								<?php if(strtolower(substr($appli_details->fu_signature_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){
								if($appli_details->fu_caste_type != 1){ ?>
									<strong>Caste Document -<a href="<?php echo $urllink.$appli_details->fu_caste_doc; ?>" target="_blank">Check Here</a></strong><br/>
									<?php if(strtolower(substr($appli_details->fu_caste_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_caste_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_caste_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_pwd", $accessarray)){
								if($appli_details->fu_pwd == "Yes"){ ?>
									<strong>PWD Document -<a href="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>" target="_blank">Check Here</a></strong><br/>
									<?php if(strtolower(substr($appli_details->fu_pwd_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exempted", $accessarray)){
								if($appli_details->fu_exempted == "Yes"){ ?>
									<strong>Document of Exempted -<a href="<?php echo $urllink.$appli_details->fu_exc_doc; ?>" target="_blank">Check Here</a></strong><br/>
									<?php if(strtolower(substr($appli_details->fu_exc_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_exc_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_exc_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){
								if($appli_details->fu_exservice == "Yes"){ ?>
									<strong>Document of ExService -<a href="<?php echo $urllink.$appli_details->fu_exs_doc; ?>" target="_blank">Check Here</a></strong><br/>
									<?php if(strtolower(substr($appli_details->fu_exs_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_exs_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_exs_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){
								if($appli_details->fu_ews == "Yes"){ ?>
									<strong>Document of Relaxation -<a href="<?php echo $urllink.$appli_details->fu_ews_doc; ?>" target="_blank">Check Here</a></strong><br/>
									<?php if(strtolower(substr($appli_details->fu_ews_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$appli_details->fu_ews_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_ews_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_qualification", $accessarray)){ ?>
									<?php if(!empty($quali_details)){ ?>
									<table class="table table-bordered table-striped">
										<tr>
											<td><b>Essential Qualification Attachment</b></td>
										</tr>
										<?php foreach($quali_details as $keys=>$qips){ ?>
										<tr>
											<td><?php echo ($keys+1).'. '.$qips->qm_name; ?> -<a href="<?php echo $urllink.$qips->fu_quali_docs; ?>" target="_blank">Check Here</a><br/>
											<?php if(strtolower(substr($qips->fu_quali_docs, -4)) == '.pdf'){ ?>
												<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$qips->fu_quali_docs; ?>"></iframe></td>
											<?php }else{ ?>
												<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$qips->fu_quali_docs; ?>" /></div></td>
											<?php } ?>
										</tr>
										<?php } ?>
									</table>
									<?php } ?>
									<?php if(!empty($des_quali_details)){ ?>
									<table class="table table-bordered table-striped">
										<tr>
											<td><b>Dessirable Qualification Attachment</b></td>
										</tr>
										<?php foreach($des_quali_details as $keys=>$qips){ ?>
										<tr>
											<td><?php echo ($keys+1).'. '.$qips->qm_name; ?> -<a href="<?php echo $urllink.$qips->fud_quali_docs; ?>" target="_blank">Check Here</a><br/>
											<?php if(strtolower(substr($qips->fud_quali_docs, -4)) == '.pdf'){ ?>
												<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$qips->fud_quali_docs; ?>"></iframe></td>
											<?php }else{ ?>
												<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$qips->fud_quali_docs; ?>" /></div></td>
											<?php } ?>
										</tr>
										<?php } ?>
									</table>
									<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_service", $accessarray)){
								if($appli_details->fu_has_service == "Yes"){ ?>
									<strong>Essential Experience</strong><br/>
									<?php foreach($essenexp_details as $keys=>$exps){ ?>
										<strong><?php echo $keys+1; ?>. <?php echo $exps->expset_name." (".$exps->fues_exp_org_name.")"; ?></strong> -<a href="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>" target="_blank">Check Here</a><br/>
										<?php if(strtolower(substr($exps->fues_exp_marksheet_doc, -4)) == '.pdf'){ ?>
											<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>"></iframe><br/>
										<?php }else{ ?>
											<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>" /></div><br/>
										<?php } ?>
										
									<?php } ?>
									<?php if(!empty($exp_details)){ ?>
									<strong>Desireable Experience</strong><br/>
									<?php foreach($exp_details as $keys=>$exps){ ?> 
									<strong><?php echo $keys+1; ?>. <?php echo $exps->expset_name." (".$exps->fu_exp_org_name.")"; ?></strong> -<a href="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>" target="_blank">Check Here</a><br/>
									<?php if(strtolower(substr($exps->fu_exp_marksheet_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="max-width:100%;500px;" src="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>" /></div><br/>
									<?php } ?>
									<?php }} ?>

								<?php }} ?>
							</td>
						</tr>
						
						
						<!--<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_father_name", $accessarray)){ ?>
							<td><strong>Father's Name</strong></td>
							<td><?php //echo $appli_details->fu_father_name; ?></td>
							<?php //} ?>
						</tr>
						<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_mother_name", $accessarray)){ ?>
							<td><strong>Mother's Name</strong></td>
							<td><?php //echo $appli_details->fu_mother_name; ?></td>
							<?php //} ?>
						</tr>-->
						
						
						
						<!--<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_gender", $accessarray)){ ?>
							<td><strong>Gender</strong></td>
							<td><?php //echo $appli_details->fu_gender; ?></td>
							<?php //} ?>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_marital_status", $accessarray)){ ?>
							<td><strong>Marital Status</strong></td>
							<td><?php //echo $appli_details->fu_marital_status; ?></td>
							<?php //} ?>
						</tr>-->
						
						
                  	</tbody>
                  </table>
				  
				  </div>
				<?php } ?>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 


<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">

<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">Comment Against Checking</h4>
  </div>
  <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="form-group">
				  	<label class="col-sm-3 control-label text-right">Select Action <font style="color: red;">*</font></label>
				    <div class="col-sm-6">
					  <input type="hidden" name="app_no" id="app_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
					  <input type="hidden" name="access_no" id="access_no" value="<?php echo $accessarray[0]; ?>" autocomplete="off" />
				      <select class="form-control" name="app_status" id="app_status" autocomplete="off">
				      	<option value="">---Select---</option>
                      	<option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Doubtful">Doubtful</option>
				      </select>
				      <small class="text-error app_status"><?php echo form_error('app_status'); ?></small>
				    </div>
				</div>
				<div style="clear:both;">&nbsp;</div>
                <div class="form-group">
				  	<label class="col-sm-3 control-label text-right">Your Comments <!--<font style="color: red;">*</font>--></label>
				    <div class="col-sm-9">
				      <textarea class="form-control" name="app_comment" style="resize:none;" id="app_comment" autocomplete="off"></textarea>
				      <small class="text-error app_comment"><?php echo form_error('app_comment'); ?></small>
				    </div>
				</div>
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
	<button type="button" class="btn btn-primary" onclick="gotoclclickbutton();">Submit</button>
  </div>
</div>

</div>
</div>

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
      $(function () {
        $("#datatable_tab").dataTable();
      });

	function check_advaction_type(){
		var advno = $("#advno option:selected").val();
		var u_accs = $("input[name='u_accs']:checked").val();
		if(advno != "" & (u_accs != undefined && u_accs != "")){
			if(u_accs == "fu_age_relax" || u_accs == "fu_es_qualification" || u_accs == "fu_ds_qualification" || u_accs == "fu_has_es_service" || u_accs == "fu_has_ds_service"){
				var form_data = new FormData();
				form_data.append("advno", advno);
				form_data.append("u_accs", u_accs);
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admincontrol/candidates/goto_get_allthe_data_specific') ?>",
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
							$('#sub_type').html(data.op_set);
							$('.subtype_sets').show('200');
							
						}else{
							//$('.div_roller_total').fadeOut();
							$('#sub_type').html('<option value="">---Select---</option>');
							$('.subtype_sets').hide('200');
							error_message = data.e_msg;
							$('.get_error_total').html(error_message);
							$(".get_error_total").fadeIn();
							setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
						}
						
					}
				});
			}else{
				$('#sub_type').html('<option value="">---Select---</option>');
				$('.subtype_sets').hide('200');
			}
		}else{
			$('#sub_type').html('<option value="">---Select---</option>');
			$('.subtype_sets').hide('200');
		}
	}
	
	$('#advno').on('change', function() {
		var advno = $("#advno option:selected").val();
		if(advno != ""){
			var form_data = new FormData();
			form_data.append("advno", advno);
			form_data.append("rf_set", 1);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_alltableno_fromadv_section') ?>",
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
						$('#adv_post_type').html('<option value="ALL">ALL</option>'+data.category_set);
						
					}else{
						//$('.div_roller_total').fadeOut();
						$('#adv_post_type').html('<option value="ALL">ALL</option>');
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
					}
					
				}
			});
		}else{
			$('#adv_post_type').html('<option value="ALL">ALL</option>');
		}
	});
	
	function gotoclclickbutton(app_status){
		$('.div_roller_total').fadeIn();
		//alert(app_status);
		//exit;
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9'"_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	//var app_status = $('#app_status option:selected').val();
    	var app_no = '<?php if(!empty($appli_details->f_application_no)){echo $appli_details->f_application_no;} ?>';
    	//var app_no = $('#app_no').val();
    	var access_no = '<?php if(!empty($accessarray[0])){echo $accessarray[0];} ?>';
    	//var access_no = $('#access_no').val();
    	var app_comment = $('#app_comment').val();
		
		
		
		//alert(minuteDiff);
		
		if(app_no == "" || access_no == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page ID not found.';
		}
		
		if(app_status == ""){
			e_error = 1;
			$('.app_status').html('Action is Required.');
		}else{
			if(!app_status.match(alphaletters)){
				e_error = 1;
				$('.app_status').html('Action only use Alphabet Values, Check again.');
			}else{
				$('.app_status').html('');
			}
			if(app_status != "Approved"){
				if(app_status != "Skip"){
					if(app_comment == ""){
						e_error = 1;
						$('.app_comment').html('Comments is Required.');
					}else{
						comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
						if(!comment1.match(alphanumerics_no)){
							e_error = 1;
							$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
						}else{
							$('.app_comment').html('');
						}	
					}
				}
			}else{
				$('.app_comment').html('');
			}			
		}
		
		/*if(app_comment == ""){
			e_error = 1;
			$('.app_comment').html('Comments is Required.');
		}else{
			comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
			if(!comment1.match(alphanumerics_no)){
				e_error = 1;
				$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
			}else{
				$('.app_comment').html('');
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
			//alert(task_start_time);exit;
			//alert(rehash);
			//$("#myForm").submit();
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/checking_section_update"; ?>',
				data:{app_no: app_no, access_no: access_no, app_status: app_status, app_comment: app_comment},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Checking Status is updated Successfully.');
						$(".get_success_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_app_list')?>"); }, 3000);
						
					}else if(data.msg == 2){
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 4000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_app_list')?>"); }, 4000);
						
					}else{
						$('.div_roller_total').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}

  	}
	  
		
		function goto_rec_search(){
			//$('.div_roller_total').fadeIn();
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
			
			var rf_set = $("#rf_set option:selected").val();
			if(rf_set != ""){
				var form_data = new FormData();
				form_data.append("rf_set", rf_set);
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admincontrol/advertisement_set/get_advisement_against_recruitment') ?>",
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
							$('#advno').html(data.op_set);
							$('#advno').prop('disabled', false);
							
						}else{
							//$('.div_roller_total').fadeOut();
							$('#advno').html('<option value="">---Select---</option>');
							$('#advno').prop('disabled', true);
							error_message = data.e_msg;
							$('.get_error_total').html(error_message);
							$(".get_error_total").fadeIn();
							setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
						}
						
					}
				});
			}else{
				//$('.div_roller_total').fadeOut();
				$('#advno').html('<option value="">---Select---</option>');
				$('#advno').prop('disabled', true);
			}
		}
		
		function goto_submit_button(){
			$('.div_roller_total1').fadeIn();
			var delay = 8000;
			var e_error = 0;
			var error_message = 'There have some errors plese check above, Try again.';
			var alphaletters_spaces = /^[A-Za-z ]+$/;
			var alphaletters = /^[A-Za-z]+$/;
			var alphanumerics = /^[A-Za-z0-9]+$/;
			var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
			var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
			var onlynumerics = /^[0-9]+$/;
			var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
			
			//var rf_set = $("#rf_set option:selected").val();
			var advno = $("#advno option:selected").val();
			var u_accs = $("input[name='u_accs']:checked").val();
			var sub_type = $("#sub_type option:selected").val();
			/*if(rf_set == ""){
				e_error = 1;
				$('.rf_set').html('Recruitment For is Required.');
			}else{
				if(!rf_set.match(onlynumerics)){
					e_error = 1;
					$('.rf_set').html('Recruitment For only use Numeric Values, Check again.');
				}else{
					$('.rf_set').html('');
				}	
			}*/
			
			if(advno == ""){
				e_error = 1;
				$('.advno').html('Advertisement No. is Required.');
			}else{
				if(!advno.match(alphanumerics)){
					e_error = 1;
					$('.advno').html('Advertisement No. only use AlphaNumeric Values, Check again.');
				}else{
					$('.advno').html('');
				}	
			}


			
			if(u_accs == undefined || u_accs == ""){
				e_error = 1;
				$('.u_accs').html('Access Type is Required.');
			}else{
				if(!u_accs.match(alphanumerics_spaces)){
					e_error = 1;
					$('.u_accs').html('Access Type only use AlphaNumeric Values with [_], Check again.');
				}else{
					$('.u_accs').html('');
				}	
			}
			
			if(advno != "" & (u_accs != undefined && u_accs != "")){
				if(u_accs == "fu_age_relax" || u_accs == "fu_es_qualification" || u_accs == "fu_ds_qualification" || u_accs == "fu_has_es_service" || u_accs == "fu_has_ds_service"){
					if(sub_type == ""){
						e_error = 1;
						$('.sub_type').html('Sub Type is Required.');
					}else{
						if(!sub_type.match(onlynumerics)){
							e_error = 1;
							$('.sub_type').html('Sub Type only use Numeric Values, Check again.');
						}else{
							$('.sub_type').html('');
						}	
					}
				}else{
					$('.sub_type').html('');
				}
			}else{
				$('.sub_type').html('');
			}
			
			//alert(salts);
			if(e_error == 1){
				$('.div_roller_total1').fadeOut();
				$('.get_error_total1').html(error_message);
				$(".get_error_total1").fadeIn();
				$(".text-error").fadeIn();
				/*e_error = 0;
				error_message = '';*/
				setTimeout(function(){ $('.text-error, .get_error_total1').fadeOut(); }, delay);
			}else{
				//alert(task_start_time);exit;
				//alert(rehash);
				$("#form123").submit();
			}
		}
		
    </script>