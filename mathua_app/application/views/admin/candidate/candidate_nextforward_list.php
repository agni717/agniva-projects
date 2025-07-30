<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

<style>
.magnify{
  border-radius: 50%;
  border: 2px solid black;
  position: absolute;
  z-index: 20;
  background-repeat: no-repeat;
  background-color: white;
  box-shadow: inset 0 0 20px rgba(0,0,0,.5);
  display: none;
  cursor: none;
}
</style>
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
            Candidate's Application
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Application</li>
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
				<div class="col-sm-6">
				  <div class="form-group">
					<label>Advertisement No. :
						<?php foreach($rec_list as $advitems){ ?>
								<?php if($searchlist['advno'] == $advitems->adv_auto_genno){echo $advitems->adv_no.' ('.$advitems->rm_name.')';} ?>
						<?php } ?>
					</label>
				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
					<label>Discipline Type :
						<?php if($searchlist['adv_post_type'] != "ALL"){
							foreach($cat_details as $catitems){ ?>
							<?php if($searchlist['adv_post_type'] == $catitems->acat_id){echo $catitems->catm_name;} ?>
						<?php }
						}else{
							echo "ALL";
						} ?>
					</label>
				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
					<label>Access Type :
						<?php foreach($uaccess as $accitems){ ?>
							<?php if($searchlist['u_accs'] == $accitems){echo $str_arr[$accitems];} ?>
						<?php } ?>
					</label>
				  </div>
				</div>
				<?php if(!empty($searchlist['sub_type'])){ ?>
				<div class="col-sm-6">
				  <div class="form-group">
					<label>Access Section :
						<?php echo $searchsub_type->typeset_name; ?>
					</label>
				  </div>
				</div>
				<?php } ?>
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
								<table width="100%">
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
										<td><strong>Father's Name</strong></td>
										<td><?php echo $appli_details->fu_father_name; ?></td>
									</tr>
									<tr>
										<td><strong>Mother's Name</strong></td>
										<td><?php echo $appli_details->fu_mother_name; ?></td>
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
											<td colspan="3"><label><strong>Block/ Municipality :</strong>:</label>  
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
											<td colspan="5"><label><strong>Permanenet Address is Same as Present Address</strong></label></td>
											</tr>
										<?php } ?>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){ ?>
									<tr>
										<td><strong>Caste</strong></td>
										<td><?php echo $appli_details->caste_name; ?></td>
									</tr>
									
									<?php if($appli_details->fu_caste_type != 1){ ?>
									<?php $castetypeset = '';
									foreach($caste_tab as $casitems){
										if($casitems->caste_id == $appli_details->fu_caste_type){
											$castetypeset = $casitems->caste_cat;break;
										}
									} ?>
									<?php if($castetypeset == 2){ ?>
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
											<td colspan="3"><label><strong>Block/ Municipality :</strong>:</label>  
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
											<td colspan="5"><label><strong>Permanenet Address is Same as Present Address</strong></label></td>
											</tr>
										<?php } ?>
									<?php }}} ?>
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
									<?php if($appli_details->fu_exempted == "Yes"){ ?>
									<tr>
										<td><strong>Caste</strong></td>
										<td><?php echo $appli_details->caste_name; ?></td>
									</tr>
									<tr>
										<td><strong>Exempted Category</strong></td>
										<td><?php echo $appli_details->fu_exempted; ?></td>
									</tr>
									<tr>
										<td><strong>Description of Exempted</strong></td>
										<td><?php echo $appli_details->fu_exc_reason; ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){ ?>
									<?php if($appli_details->fu_exservice == "Yes"){ ?>
									<tr>
										<td><strong>Caste</strong></td>
										<td><?php echo $appli_details->caste_name; ?></td>
									</tr>
									<tr>
										<td><strong>Ex-Serviceman Category</strong></td>
										<td colspan="4"><?php echo $appli_details->fu_exservice; ?></td>
									</tr>
									<tr>
										<td><strong>Description of Ex-Serviceman</strong></td>
										<td><?php echo $appli_details->fu_exs_reason; ?></td>
									</tr>
									<?php }} ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){ ?>
									<?php if($appli_details->fu_ews == "Yes"){ ?>
									<tr>
										<td><strong>Caste</strong></td>
										<td><?php echo $appli_details->caste_name; ?></td>
									</tr>
									<tr>
										<td><strong>Sportsman Category</strong></td>
										<td colspan="4"><?php echo $appli_details->fu_ews; ?></td>
									</tr>
									<tr>
										<td><strong>Description of Sportsman</strong></td>
										<td><?php echo $appli_details->fu_ews_reason; ?></td>
									</tr>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_age_relax", $accessarray)){ ?>
									<?php foreach($spclage_list as $spageitems){
										if($searchlist['sub_type'] == $spageitems->fu_ext_ageid){ ?>
										<tr>
											<td><strong><?php echo $spageitems->caste_name; ?></strong></td>
											<td colspan="4"><?php echo $spageitems->fu_ext_answer; ?></td>
										</tr>
										<?php if($spageitems->fu_ext_answer == "Yes"){ ?>
										<tr>
											<td><strong>Reason</strong></td>
											<td><?php echo $spageitems->fu_ext_reason; ?></td>
										</tr>
									<?php }
									break;}} ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_es_qualification", $accessarray)){ ?>
									<?php if(!empty($quali_details)){ ?>
									<tr>
										<td colspan="2">
										<div class="table-responsive" style="max-width:700px;">
										<strong>Essential Qualification</strong>
										<table class="table table-bordered table-striped">
											<tr>
											<td><b>Qualification</b></td>
											<td><b>Board/ Council/ University/ Journal</b></td>
											<td><b>State of Passing</b></td>
											<td><b>Full Marks</b></td>
											<td><b>Marks Obtained</b></td>
											<td><b>Percentage of Marks</b></td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><b>CHK Full Marks</b></td>
											<td><b>CHK Marks Obtained</b></td>
											<td><b>CHK Percentage of Marks</b></td>
											<?php } ?>
											<td><b>Additional Attempt</b></td>
											<td><b>No. of Attempt</b></td>
											<?php //if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><b>Action</b></td>
											<?php //} ?>
											</tr>
											<?php foreach($quali_details as $qips){ 
												if($searchlist['sub_type'] == $qips->fu_qualifiaction_name){ ?>
											<tr>
												<td><?php echo $qips->qm_name; ?></td>
												<td><?php echo $qips->fu_council_board; ?></td>
												<td><?php echo $qips->state_name; ?></td>
												<td><?php echo $qips->fu_full_marks; ?></td>
												<td><?php echo $qips->fu_marks_obtained; ?></td>
												<td><?php echo $qips->fu_percent_of_marks; ?></td>
												<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<td><?php echo $qips->fu_fullmark_ck; ?></td>
												<td><?php echo $qips->fu_obtainmark_ck; ?></td>
												<td><?php echo $qips->fu_percentmark_ck; ?></td>
												<?php } ?>
												<td><?php echo $qips->fu_is_attempt; ?></td>
												<td><?php echo $qips->fu_attempt_no; ?></td>
												<td>
												<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<a href="javascript:;" class="btn btn-danger" onclick="gotomark_update_by_checker(<?php echo $qips->fu_quali_id; ?>,<?php echo $qips->fu_fullmark_ck; ?>,<?php echo $qips->fu_obtainmark_ck; ?>,<?php echo $qips->fu_percentmark_ck; ?>,'E');">Modify</a>
												<?php } ?>
												<a class="btn btn-sm btn-danger" onclick="gotoqualification_send_check('EQ','<?php echo $qips->fu_quali_id; ?>');">Send Modify Marks</a>
												</td>
											</tr>
											<?php break;}} ?>
										</table>
										</div>
										</td>
									</tr>
									<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_ds_qualification", $accessarray)){ ?>
									<?php if(!empty($des_quali_details)){ ?>
									<tr>
										<td colspan="2">
										<div class="table-responsive" style="max-width:700px;">
										<strong>Desirable Qualification</strong>
										<table class="table table-bordered table-striped">
											<tr>
											<td><b>Qualification</b></td>
											<td><b>Board/ Council/ University/ Journal</b></td>
											<td><b>State of Passing</b></td>
											<td><b>Full Marks</b></td>
											<td><b>Marks Obtained</b></td>
											<td><b>Percentage of Marks</b></td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><b>CHK Full Marks</b></td>
											<td><b>CHK Marks Obtained</b></td>
											<td><b>CHK Percentage of Marks</b></td>
											<?php } ?>
											<td><b>Additional Attempt</b></td>
											<td><b>No. of Attempt</b></td>
											<?php //if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><b>Action</b></td>
											<?php //} ?>
											</tr>
											<?php foreach($des_quali_details as $qips){
												if($searchlist['sub_type'] == $qips->fud_qualifiaction_name){ ?>
											<tr>
												<td><?php echo $qips->qm_name; ?></td>
												<td><?php echo $qips->fud_council_board; ?></td>
												<td><?php echo $qips->state_name; ?></td>
												<td><?php echo $qips->fud_full_marks; ?></td>
												<td><?php echo $qips->fud_marks_obtained; ?></td>
												<td><?php echo $qips->fud_percent_of_marks; ?></td>
												<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<td><?php echo $qips->fud_fullmark_ck; ?></td>
												<td><?php echo $qips->fud_obtainmark_ck; ?></td>
												<td><?php echo $qips->fud_percentmark_ck; ?></td>
												<?php } ?>
												<td><?php echo $qips->fud_is_attempt; ?></td>
												<td><?php echo $qips->fud_attempt_no; ?></td>
												<td>
												<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<a href="javascript:;" class="btn btn-danger" onclick="gotomark_update_by_checker(<?php echo $qips->fud_quali_id; ?>,<?php echo $qips->fud_fullmark_ck; ?>,<?php echo $qips->fud_obtainmark_ck; ?>,<?php echo $qips->fud_percentmark_ck; ?>,'D');">Modify</a>
												<?php } ?>
												<a class="btn btn-sm btn-danger" onclick="gotoqualification_send_check('DQ','<?php echo $qips->fud_quali_id; ?>');">Send Modify Marks</a>
												</td>
											</tr>
											<?php break;}} ?>
										</table>
										</div>
										</td>
									</tr>
									<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_es_service", $accessarray)){ ?>
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
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><strong>CHK Time Period</strong></td>
											<?php } ?>
											<td><strong>Status</strong></td>
											<td><strong>Action</strong></td>
											</tr>
											<?php foreach($essenexp_details as $keys=>$expss){ 
												if($searchlist['sub_type'] == $expss->fues_exp_workname){ ?>
											<tr>
											<td><?php echo ($keys+1); ?></td>
											<td><?php echo $expss->expset_name; ?></td>
											<td><?php echo $expss->fues_exp_org_name; ?></td>
											<td><?php echo $expss->fues_exp_year.' Year & '.$expss->fues_exp_month.' Month'; ?></td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<td><?php echo $expss->fues_exp_yr_ck.' Year & '.$expss->fues_exp_mth_ck.' Month'; ?></td>
											<?php } ?>
											<td><?php if($expss->fues_exp_approval == NULL){echo "Not Check";}else{echo $expss->fues_exp_approval;} ?></td>
											<td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<a href="javascript:;" class="btn btn-warning" onclick="gotoexp_update_by_checker(<?php echo $expss->fues_exp_id; ?>,<?php echo $expss->fues_exp_yr_ck; ?>,<?php echo $expss->fues_exp_mth_ck; ?>,'E');">Modify</a>
											<?php } ?>	
											<a href="javascript:;" class="btn btn-success" onclick="gotoexp_idvidualupdate_by_checker('ES',<?php echo $expss->fues_exp_id; ?>,'Approved');">Approve</a>&nbsp;<a href="javascript:;" class="btn btn-danger" onclick="gotoexp_idvidualupdate_by_checker('ES',<?php echo $expss->fues_exp_id; ?>,'Rejected');">Reject</a></td>
											</tr>
											<?php }} ?>
										</table>
										<?php $ccchk = 0;
											foreach($essenexp_details as $keys=>$expss){ 
												if($searchlist['sub_type'] == $expss->fues_exp_workname){ ?>
													<?php if($expss->fues_exp_approval == NULL){$ccchk = 1;break;} ?>
										<?php } } ?>
										<input type="hidden" id="esds_exp_chknull" name="esds_exp_chknull" value="<?php echo $ccchk; ?>" />
										</td>
									</tr>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_ds_service", $accessarray)){ ?>
									<tr>
										<td><strong>Has Service Experience</strong></td>
										<td><?php echo $appli_details->fu_has_service; ?></td>
									</tr>
									<?php if($appli_details->fu_has_service == "Yes"){ ?>
									<?php if(!empty($exp_details)){ ?>
									<tr>
										<td colspan="2">
										<strong>Desirable Experience</strong>
										<table class="table table-bordered table-striped">
											<tr>
											<td><strong>Sl No.</strong></td>
											<td><strong>Experience Category</strong></td>
											<td><strong>Organization</strong></td>
											<td><strong>Time Period</strong></td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
											<td><strong>CHK Time Period</strong></td>
											<?php } ?>
											<td><strong>Status</strong></td>
											<td><strong>Action</strong></td>
											</tr>
											<?php foreach($exp_details as $keys=>$expss){ 
												if($searchlist['sub_type'] == $expss->fu_exp_workname){ ?>
											<tr>
											<td><?php echo ($keys+1); ?></td>
											<td><?php echo $expss->expset_name; ?></td>
											<td><?php echo $expss->fu_exp_org_name; ?></td>
											<td><?php echo $expss->fu_exp_year.' Year & '.$expss->fu_exp_month.' Month'; ?></td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<td><?php echo $expss->fu_exp_yr_ck.' Year & '.$expss->fu_exp_mth_ck.' Month'; ?></td>
											<?php } ?>
											<td><?php if($expss->fu_exp_approval == NULL){echo "Not Check";}else{echo $expss->fu_exp_approval;} ?></td>
											<td>
											<?php if($appli_details->adv_qualification_modify == "Yes"){ ?>
												<a href="javascript:;" class="btn btn-warning" onclick="gotoexp_update_by_checker(<?php echo $expss->fu_exp_id; ?>,<?php echo $expss->fu_exp_yr_ck; ?>,<?php echo $expss->fu_exp_mth_ck; ?>,'D');">Modify</a>
											<?php } ?>
											<a href="javascript:;" class="btn btn-success" onclick="gotoexp_idvidualupdate_by_checker('DS',<?php echo $expss->fu_exp_id; ?>,'Approved');">Approve</a>&nbsp;<a href="javascript:;" class="btn btn-danger" onclick="gotoexp_idvidualupdate_by_checker('DS',<?php echo $expss->fu_exp_id; ?>,'Rejected');">Reject</a></td>
											</tr>
											<?php }} ?>
										</table>
										<?php $ccchk = 0;
											foreach($exp_details as $keys=>$expss){ 
												if($searchlist['sub_type'] == $expss->fu_exp_workname){ ?>
													<?php if($expss->fu_exp_approval == NULL){$ccchk = 1;break;} ?>
										<?php } } ?>
										<input type="hidden" id="esds_exp_chknull" name="esds_exp_chknull" value="<?php echo $ccchk; ?>" /> 
										</td>
									</tr>
									<?php } ?>
								<?php }} ?>
									<tr>
										<td colspan="5">
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
											  	<button type="button" class="btn btn-primary" onclick="gotoclclickbutton('Approved');">Approve</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<button type="button" class="btn btn-danger" onclick="gotoclclickbutton('Rejected');">Reject</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<button type="button" class="btn btn-info" onclick="gotoclclickbutton('Skip');">Skip</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<button type="button" class="btn btn-warning" onclick="gotoclclickbutton('Doubtful');">Mark as Doubtful</button>
												</div>
											  <!--<a href="#" class="btn btn-danger">Reject</a>
											  <a href="#" class="btn btn-warning">Doubtful</a>-->
										  	</div>
										</td>
									</tr>
									<?php if($accessarray[0] == "ALL" || in_array("fu_es_qualification", $accessarray) || in_array("fu_ds_qualification", $accessarray) || in_array("fu_has_es_service", $accessarray) || in_array("fu_has_ds_service", $accessarray)){ ?>
										<tr>
											<td colspan="2"><strong><u>Other Checker Comments </u>:-</strong></td>
										</tr>
										<?php if(!empty($other_chker_comment)){ //print_r($other_chker_comment);exit;
											foreach($other_chker_comment as $ocitems){ ?>
										<tr>
											<td>Checked By: <strong><?php echo $ocitems->firstname.' '.$ocitems->lastname.' ('.$ocitems->mu_name.')'; ?></strong></td>
											<td>Checking Status: <strong><?php echo $ocitems->chk_approve; ?></strong></td>
										</tr>
										<tr>
											<td colspan="2">Checking Comments: <?php echo $ocitems->chk_comments; ?></td>
										</tr>
										<?php }}else{ ?>
										<tr>
											<td colspan="2">No Comments Available</td>
										</tr>
									<?php }} ?>
								</table>
							</td>
							<td width="50%" align="left">
								<?php if($accessarray[0] == "ALL" || in_array("fu_photo_doc", $accessarray)){ ?>
								<strong>Candidate Photograph -<a href="<?php echo $urllink.$appli_details->fu_photo_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','1','<?php echo $appli_details->fu_photo_doc; ?>');">Send Mail</a><br/>
								<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_photo_doc; ?>" /></div><br/>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_dob", $accessarray)){ ?>
								<strong>DOB Document -<a href="<?php echo $urllink.$appli_details->fu_dob_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','4','<?php echo $appli_details->fu_dob_doc; ?>');">Send Mail</a><br/>
								<?php if(strtolower(substr($appli_details->fu_dob_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_dob_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_dob_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_address", $accessarray)){ ?>
								<strong>Address Proof -<a href="<?php echo $urllink.$appli_details->fu_address_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','3','<?php echo $appli_details->fu_address_doc; ?>');">Send Mail</a><br/>
								<?php if(strtolower(substr($appli_details->fu_address_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_address_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_address_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_signature_doc", $accessarray)){ ?>
								<strong>Signature Document -<a href="<?php echo $urllink.$appli_details->fu_signature_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','2','<?php echo $appli_details->fu_signature_doc; ?>');">Send Mail</a><br/>
								<?php if(strtolower(substr($appli_details->fu_signature_doc, -4)) == '.pdf'){ ?>
									<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>"></iframe><br/>
								<?php }else{ ?>
									<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>" /></div><br/>
								<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){
								if($appli_details->fu_caste_type != 1){ ?>
								<?php $excattype = '';
								foreach ($caste_tab as $caste) :
									if ($appli_details->fu_caste_type == $caste->caste_id){$excattype = $caste->caste_cat; }
								endforeach; ?>
								<?php if($excattype == 2){ ?>
									<strong>Caste Document -<a href="<?php echo $urllink.$appli_details->fu_caste_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','5','<?php echo $appli_details->fu_caste_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($appli_details->fu_caste_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_caste_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_caste_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }}} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_pwd", $accessarray)){
								if($appli_details->fu_pwd == "Yes"){ ?>
									<strong>PWD Document -<a href="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','6','<?php echo $appli_details->fu_pwd_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($appli_details->fu_pwd_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exempted", $accessarray)){
								if($appli_details->fu_exempted == "Yes"){ ?>
									<strong>Document of Exempted -<a href="<?php echo $urllink.$appli_details->fu_exc_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','7','<?php echo $appli_details->fu_exc_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($appli_details->fu_exc_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_exc_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_exc_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){
								if($appli_details->fu_exservice == "Yes"){ ?>
									<strong>Document of ExServiceman -<a href="<?php echo $urllink.$appli_details->fu_exs_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','8','<?php echo $appli_details->fu_exs_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($appli_details->fu_exs_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_exs_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_exs_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){
								if($appli_details->fu_ews == "Yes"){ ?>
									<strong>Document of Sportsman -<a href="<?php echo $urllink.$appli_details->fu_ews_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','9','<?php echo $appli_details->fu_ews_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($appli_details->fu_ews_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_ews_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_ews_doc; ?>" /></div><br/>
									<?php } ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_age_relax", $accessarray)){ ?>
									<?php foreach($spclage_list as $spageitems){
										if($searchlist['sub_type'] == $spageitems->fu_ext_ageid){ ?>
										<?php if($spageitems->fu_ext_answer == "Yes"){ ?>
										<strong>Document of Relaxation -<a href="<?php echo $urllink.$spageitems->fu_ext_doc; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('EA','<?php echo $spageitems->fu_ext_id; ?>','<?php echo $spageitems->fu_ext_doc; ?>');">Send Mail</a><br/>
										<?php if(strtolower(substr($spageitems->fu_ext_doc, -4)) == '.pdf'){ ?>
											<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$spageitems->fu_ext_doc; ?>"></iframe><br/>
										<?php }else{ ?>
											<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$spageitems->fu_ext_doc; ?>" /></div><br/>
										<?php } ?>
									<?php }
									break;}} ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_es_qualification", $accessarray)){ ?>
									<?php if(!empty($quali_details)){ ?>
									<table class="table table-bordered table-striped">
										<tr>
											<td><b>Essential Qualification Attachment</b></td>
										</tr>
										<?php foreach($quali_details as $keys=>$qips){ 
											if($searchlist['sub_type'] == $qips->fu_qualifiaction_name){ ?>
										<tr>
											<td><?php echo ($keys+1).'. '.$qips->qm_name; ?> -<a href="<?php echo $urllink.$qips->fu_quali_docs; ?>" target="_blank">Check Here</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('EQ','<?php echo $qips->fu_quali_id; ?>','<?php echo $qips->fu_quali_docs; ?>');">Send Mail</a><br/>
											<?php if(strtolower(substr($qips->fu_quali_docs, -4)) == '.pdf'){ ?>
												<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$qips->fu_quali_docs; ?>"></iframe></td>
											<?php }else{ ?>
												<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$qips->fu_quali_docs; ?>" /></div></td>
											<?php } ?>
										</tr>
										<?php break;}} ?>
									</table>
									<?php } ?>
									<?php if(!empty($appli_details->fu_ext_council_reg_certificate)){ ?>
										<strong>Registration Certificate -<a href="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','10','<?php echo $appli_details->fu_ext_council_reg_certificate; ?>');">Send Mail</a><br/>
										<?php if(strtolower(substr($appli_details->fu_ext_council_reg_certificate, -4)) == '.pdf'){ ?>
											<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>"></iframe><br/>
										<?php }else{ ?>
											<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>" /></div><br/>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_ds_qualification", $accessarray)){ ?>
									<?php if(!empty($des_quali_details)){ ?>
									<table class="table table-bordered table-striped">
										<tr>
											<td><b>Desirable Qualification Attachment</b></td>
										</tr>
										<?php foreach($des_quali_details as $keys=>$qips){
											if($searchlist['sub_type'] == $qips->fud_qualifiaction_name){ ?>
										<tr>
											<td><?php echo ($keys+1).'. '.$qips->qm_name; ?> -<a href="<?php echo $urllink.$qips->fud_quali_docs; ?>" target="_blank">Check Here</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('DQ','<?php echo $qips->fud_quali_id; ?>','<?php echo $qips->fud_quali_docs; ?>');">Send Mail</a><br/>
											<?php if(strtolower(substr($qips->fud_quali_docs, -4)) == '.pdf'){ ?>
												<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$qips->fud_quali_docs; ?>"></iframe></td>
											<?php }else{ ?>
												<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$qips->fud_quali_docs; ?>" /></div></td>
											<?php } ?>
										</tr>
										<?php break;}} ?>
									</table>
									<?php } ?>
									<?php if(!empty($appli_details->fu_ext_council_reg_certificate)){ ?>
										<strong>Registration Certificate -<a href="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>" target="_blank">Check Here</a></strong>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('CO','10','<?php echo $appli_details->fu_ext_council_reg_certificate; ?>');">Send Mail</a><br/>
										<?php if(strtolower(substr($appli_details->fu_ext_council_reg_certificate, -4)) == '.pdf'){ ?>
											<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>"></iframe><br/>
										<?php }else{ ?>
											<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$appli_details->fu_ext_council_reg_certificate; ?>" /></div><br/>
										<?php } ?>
									<?php } ?>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_es_service", $accessarray)){
								if($appli_details->fu_has_service == "Yes"){ ?>
									<strong>Essential Experience</strong><br/>
									<?php foreach($essenexp_details as $keys=>$exps){
										if($searchlist['sub_type'] == $exps->fues_exp_workname){ ?>
										<strong><?php echo $keys+1; ?>. <?php echo $exps->expset_name." (".$exps->fues_exp_org_name.")"; ?></strong> -<a href="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>" target="_blank">Check Here</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('ES','<?php echo $exps->fues_exp_id; ?>','<?php echo $exps->fues_exp_marksheet_doc; ?>');">Send Mail</a><br/>
										<?php if(strtolower(substr($exps->fues_exp_marksheet_doc, -4)) == '.pdf'){ ?>
											<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>"></iframe><br/>
										<?php }else{ ?>
											<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$exps->fues_exp_marksheet_doc; ?>" /></div><br/>
										<?php } ?>
										
									<?php }} ?>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_ds_service", $accessarray)){
								if($appli_details->fu_has_service == "Yes"){ ?>
									<?php if(!empty($exp_details)){ ?>
									<strong>Desirable Experience</strong><br/>
									<?php foreach($exp_details as $keys=>$exps){
										if($searchlist['sub_type'] == $exps->fu_exp_workname){ ?> 
									<strong><?php echo $keys+1; ?>. <?php echo $exps->expset_name." (".$exps->fu_exp_org_name.")"; ?></strong> -<a href="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>" target="_blank">Check Here</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" onclick="gotomailsend_check('DS','<?php echo $exps->fu_exp_id; ?>','<?php echo $exps->fu_exp_marksheet_doc; ?>');">Send Mail</a><br/>
									<?php if(strtolower(substr($exps->fu_exp_marksheet_doc, -4)) == '.pdf'){ ?>
										<iframe id="dcopy_frameset" width="100%" height="500px;" style="max-width:100%;" src="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>"></iframe><br/>
									<?php }else{ ?>
										<div><img id="dcopy_frameset" style="width:100%;max-width:550px;" src="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>" /></div><br/>
									<?php } ?>
									<?php }
									}} ?>

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
	<h4 class="modal-title">Update Marks</h4>
  </div>
  <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="form-group">
				  	<div class="col-sm-4">
					  <label class="text-right">Full Marks <font style="color: red;">*</font></label>
					  <input type="hidden" name="app_no" id="app_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
					  <input type="hidden" name="qid" id="qid" value="" autocomplete="off" />
					  <input type="hidden" name="qtype" id="qtype" value="" autocomplete="off" />
					  <input type="text" name="q_fullmark" id="q_fullmark" value="" autocomplete="off" onkeyup="percentcheck_exm();" />
					  <small class="text-error q_fullmark"><?php echo form_error('q_fullmark'); ?></small>
				    </div>
					<div class="col-sm-4">
					  <label class="text-right">Obtained Marks <font style="color: red;">*</font></label>
					  <input type="text" name="q_obtainmark" id="q_obtainmark" value="" autocomplete="off" onkeyup="percentcheck_exm();" />
					  <small class="text-error q_obtainmark"><?php echo form_error('q_obtainmark'); ?></small>
				    </div>
					<div class="col-sm-4">
					  <label class="text-right">Percent Marks <font style="color: red;">*</font></label>
					  <input type="text" name="q_percentmark" id="q_percentmark" value="" autocomplete="off" readonly />
					  <small class="text-error q_percentmark"><?php echo form_error('q_percentmark'); ?></small>
				    </div>
				</div>
				<div style="clear:both;">&nbsp;</div>
				<div  class="col-sm-12 text-center">
					<div align="center">
						<div class="get_error_total_2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total_2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total_2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
		</div>
  </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="gotoUpdate_checkerMarks();">Update</button>
  </div>
</div>

</div>
</div>

<div id="myModal2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title text-center">Send Email for Update</h4>
	</div>
	<div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<div style="clear:both;">&nbsp;</div>
					<div  class="col-sm-12 text-center">
						<input type="hidden" name="cand_no" id="cand_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
						<input type="hidden" name="cand_adv_no" id="cand_adv_no" value="<?php echo $appli_details->f_applied_for; ?>" autocomplete="off" />
						<input type="hidden" name="canddoc_type" id="canddoc_type" value="" autocomplete="off" />
						<input type="hidden" name="canddoc_name" id="canddoc_name" value="" autocomplete="off" />
						<input type="hidden" name="canddoc_id" id="canddoc_id" value="" autocomplete="off" />
						<div align="center">
							<div class="get_error_total_22" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="get_success_total_22" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="div_roller_total_22" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
				</div>
			</div>
	</div>
	</div>
</div>
</div>


<div id="myModal3" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title text-center">Experience Sub Section Updation</h4>
	</div>
	<div class="modal-body">
			<div class="container-fluid">
				<div class="row">
					<div style="clear:both;">&nbsp;</div>
					<div  class="col-sm-12 text-center">
						<input type="hidden" name="cand_no" id="cand_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
						<input type="hidden" name="cand_adv_no" id="cand_adv_no" value="<?php echo $appli_details->f_applied_for; ?>" autocomplete="off" />
						<div align="center">
							<div class="get_error_total_33" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="get_success_total_33" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="div_roller_total_33" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
				</div>
			</div>
	</div>
	</div>
</div>
</div>

<div id="myModal4" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">

<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">Update Experience</h4>
  </div>
  <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="form-group">
				  	<div class="col-sm-6">
					  <label class="text-right">Year <font style="color: red;">*</font></label>
					  <input type="hidden" name="exp_app_no" id="exp_app_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
					  <input type="hidden" name="expid" id="expid" value="" autocomplete="off" />
					  <input type="hidden" name="expsettype" id="expsettype" value="" autocomplete="off" />
					  <input type="text" name="exp_fullyear" id="exp_fullyear" value="" autocomplete="off" />
					  <small class="text-error exp_fullyear"><?php echo form_error('exp_fullyear'); ?></small>
				    </div>
					<div class="col-sm-6">
					  <label class="text-right">Month <font style="color: red;">*</font></label>
					  <input type="text" name="exp_fullmonth" id="exp_fullmonth" value="" autocomplete="off" />
					  <small class="text-error exp_fullmonth"><?php echo form_error('exp_fullmonth'); ?></small>
				    </div>
				</div>
				<div style="clear:both;">&nbsp;</div>
				<div  class="col-sm-12 text-center">
					<div align="center">
						<div class="get_error_total_02" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total_02" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total_02" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
		</div>
  </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="gotoUpdate_checkerExp();">Update</button>
  </div>
</div>

</div>
</div>

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'js/zoom.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
      $(function () {
        $("#datatable_tab").dataTable();
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
		var access_id = '<?php if(!empty($searchlist['sub_type'])){echo $searchlist['sub_type'];} ?>';
    	//var access_no = $('#access_no').val();
    	var app_comment = $('#app_comment').val();
		
		
		
		//alert(minuteDiff);
		
		if(app_no == "" || access_no == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page ID not found.';
		}

		if(access_no != ""){
			if(access_no == "fu_es_qualification" || access_no == "fu_ds_qualification" || access_no == "fu_has_es_service" || access_no == "fu_has_ds_service"){
				if(access_id == ""){
					e_error = 1;
					error_message = error_message + '<br/>Referesh the Page Type ID not found.';
				}
			}
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
				//if(app_status != "Skip"){
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
				//}
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
		if((access_no == "fu_has_es_service" || access_no == "fu_has_ds_service") && (app_status == "Approved" || app_status == "Rejected")){
			var ccchk_exp = $('#esds_exp_chknull').val();
			//alert(ccchk_exp);exit();
			if(parseInt(ccchk_exp) == 1){
				e_error = 1;
				error_message = error_message + '<br/>Need to Approve OR Reject All the Experience individually.';
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
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/checking_section_update"; ?>',
				data:{app_no: app_no, access_no: access_no, access_id: access_id, app_status: app_status, app_comment: app_comment},
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
						<?php if(!empty($searchlist['sub_type'])){ ?>
							setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['adv_post_type'].'/'.$searchlist['u_accs'].'/'.$searchlist['sub_type'])?>"); }, 1000);
						<?php }else{ ?>
							setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['adv_post_type'].'/'.$searchlist['u_accs'])?>"); }, 1000);
						<?php } ?>
						
					}else if(data.msg == 2){
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 4000);
						<?php if(!empty($searchlist['sub_type'])){ ?>
							setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['adv_post_type'].'/'.$searchlist['u_accs'].'/'.$searchlist['sub_type'])?>"); }, 1000);
						<?php }else{ ?>
							setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['adv_post_type'].'/'.$searchlist['u_accs'])?>"); }, 1000);
						<?php } ?>
						
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
	
	function gotoexp_update_by_checker(chkid, year, month, tabletype){
		//alert(chkid);
		//alert(tabletype);
		$('#expid').val(chkid);
		$('#expsettype').val(tabletype);
		$('#exp_fullyear').val(year);
		$('#exp_fullmonth').val(month);
		$('#myModal4').modal('show');
		//$('#myModal').modal('hide');
		
	}
	
	function gotomark_update_by_checker(chkid, full, obtained, percent, tabletype){
		//alert(chkid);
		//alert(tabletype);
		$('#qid').val(chkid);
		$('#qtype').val(tabletype);
		$('#q_fullmark').val(full);
		$('#q_obtainmark').val(obtained);
		$('#q_percentmark').val(percent);
		$('#myModal').modal('show');
		//$('#myModal').modal('hide');
		
	}

	function percentcheck_exm(){
		var marks_obtained = $("#q_obtainmark").val();
		var marks_full = $("#q_fullmark").val();
		var marks_percent = $("#q_percentmark").val();
		
		if(marks_obtained != "" && marks_full != ""){
			if(!isNaN(marks_obtained) && !isNaN(marks_full)){
				if(parseInt(marks_full) >= parseInt(marks_obtained)){
					var updatemarks_percent = parseFloat((parseInt(marks_obtained) * 100)/ parseInt(marks_full)).toFixed(2);
					$("#q_percentmark").val(updatemarks_percent);
				}else{
					$("#q_percentmark").val('');
				}
			}else{
				$("#q_percentmark").val('');
			}
		}else{
			$("#q_percentmark").val('');
		}
	}

	function gotoUpdate_checkerMarks(){
		$('.div_roller_total_2').fadeIn();
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

		var app_no = $('#app_no').val();
		var qid = $('#qid').val();
		var qtype = $('#qtype').val();
		var q_fullmark = $('#q_fullmark').val();
		var q_obtainmark = $('#q_obtainmark').val();
		var q_percentmark = $('#q_percentmark').val();

		if(app_no == "" || qid == "" || qtype == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(q_fullmark == ""){
			e_error = 1;
			$('.q_fullmark').html('Full Marks is Required.');
		}else{
			if(!q_fullmark.match(onlynumerics)){
				e_error = 1;
				$('.q_fullmark').html('Full Marks only use Numeric Values, Check again.');
			}else{
				$('.q_fullmark').html('');
			}	
		}

		if(q_obtainmark == ""){
			e_error = 1;
			$('.q_obtainmark').html('Full Marks is Required.');
		}else{
			if(!q_obtainmark.match(onlynumerics)){
				e_error = 1;
				$('.q_obtainmark').html('Full Marks only use Numeric Values, Check again.');
			}else{
				$('.q_obtainmark').html('');
			}	
		}

		if(q_percentmark == ""){
			e_error = 1;
			$('.q_percentmark').html('Percent Marks is Required.');
		} else {
			$('.q_percentmark').html('');
		}

		if(e_error == 1){
			$('.div_roller_total_2').fadeOut();
			$('.get_error_total_2').html(error_message);
			$(".get_error_total_2").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_2').fadeOut(); }, delay);
		}else{
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/update_checker_examdata"; ?>',
				data:{app_no: app_no, qid: qid, qtype: qtype, q_fullmark: q_fullmark, q_obtainmark: q_obtainmark, q_percentmark: q_percentmark},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total_2').fadeOut();
						$('.get_success_total_2').html('Marks is updated Successfully.');
						$(".get_success_total_2").fadeIn();
						//$('input').val('');
						setTimeout(function(){ $('.get_success_total_2').fadeOut(); }, 2000);
						setTimeout(function(){ location.reload(); }, 1000);
						
					}else{
						$('.div_roller_total_2').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total_2').html(error_message);
						$(".get_error_total_2").fadeIn();
						setTimeout(function(){ $('.get_error_total_2').fadeOut(); }, delay);
					}
					
				}
			});
		}


	}

	function gotoUpdate_checkerExp(){
		$('.div_roller_total_02').fadeIn();
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

		var exp_app_no = $('#exp_app_no').val();
		var expid = $('#expid').val();
		var expsettype = $('#expsettype').val();
		var exp_fullyear = $('#exp_fullyear').val();
		var exp_fullmonth = $('#exp_fullmonth').val();

		if(exp_app_no == "" || expid == "" || expsettype == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(exp_fullyear == ""){
			e_error = 1;
			$('.exp_fullyear').html('Year is Required.');
		}else{
			if(!exp_fullyear.match(onlynumerics)){
				e_error = 1;
				$('.exp_fullyear').html('Year only use Numeric Values, Check again.');
			}else{
				$('.exp_fullyear').html('');
			}	
		}

		if(exp_fullmonth == ""){
			e_error = 1;
			$('.exp_fullmonth').html('Month is Required.');
		}else{
			if(!exp_fullmonth.match(onlynumerics)){
				e_error = 1;
				$('.exp_fullmonth').html('Month only use Numeric Values, Check again.');
			}else{
				$('.exp_fullmonth').html('');
			}	
		}

		if(e_error == 1){
			$('.div_roller_total_02').fadeOut();
			$('.get_error_total_02').html(error_message);
			$(".get_error_total_02").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_02').fadeOut(); }, delay);
		}else{
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/update_checker_experiencedata"; ?>',
				data:{exp_app_no: exp_app_no, expid: expid, expsettype: expsettype, exp_fullyear: exp_fullyear, exp_fullmonth: exp_fullmonth},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total_02').fadeOut();
						$('.get_success_total_02').html('Experience is updated Successfully.');
						$(".get_success_total_02").fadeIn();
						//$('input').val('');
						setTimeout(function(){ $('.get_success_total_02').fadeOut(); }, 2000);
						setTimeout(function(){ location.reload(); }, 1000);
						
					}else{
						$('.div_roller_total_02').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total_02').html(error_message);
						$(".get_error_total_02").fadeIn();
						setTimeout(function(){ $('.get_error_total_02').fadeOut(); }, delay);
					}
					
				}
			});
		}


	}

	function gotoexp_idvidualupdate_by_checker(exptype, chkid, appro_type){
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

		var candadv_no = '<?php echo $appli_details->f_applied_for; ?>';
		var candapp_no = '<?php echo $appli_details->f_application_no; ?>';
		if(candadv_no == "" || candapp_no == "" || chkid == "" || appro_type == "" || exptype == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(e_error == 1){
			$('.div_roller_total_33').fadeOut();
			$('.get_error_total_33').html(error_message);
			$(".get_error_total_33").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function(){ $('.text-error, .get_error_total_33').fadeOut(); }, delay);
		}else{

			$('#myModal3').modal('show');
			$('.div_roller_total_33').fadeIn();
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/updateset_subsection_experience"; ?>',
				data:{candadv_no: candadv_no, candapp_no: candapp_no, chkid: chkid, appro_type: appro_type, exptype: exptype},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total_33').fadeOut();
						$('.get_success_total_33').html('Experience Status is updated Successfully.');
						$(".get_success_total_33").fadeIn();
						//$('input').val('');
						setTimeout(function(){ $('.get_success_total_33').fadeOut(); }, 2000);
						setTimeout(function(){ $('#myModal3').modal('hide'); }, 2000);
						setTimeout(function(){ location.reload(); }, 1000);
						
					}else{

						$('.div_roller_total_33').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total_33').html(error_message);
						$(".get_error_total_33").fadeIn();
						setTimeout(function(){ $('.get_error_total_33').fadeOut(); }, delay);
						setTimeout(function(){ $('#myModal3').modal('hide'); }, 2000);

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
	
	function gotomailsend_check(doctype, docid, extfilename){
		//alert(extfilename);
		//$('#canddoc_type').val(doctype);
		//$('#canddoc_id').val(docid);
		//$('#canddoc_name').val(extfilename);
		
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

		var candadv_no = '<?php echo $appli_details->f_applied_for; ?>';
		var candapp_no = '<?php echo $appli_details->f_application_no; ?>';
		var app_comment = $('#app_comment').val();
		if(candadv_no == "" || candapp_no == "" || doctype == "" || docid == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(app_comment != ""){
			comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
			if(!comment1.match(alphanumerics_no)){
				e_error = 1;
				$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
			}else{
				$('.app_comment').html('');
			}	
		}

		if(e_error == 1){
			$('.div_roller_total_22').fadeOut();
			$('.get_error_total_22').html(error_message);
			$(".get_error_total_22").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_22').fadeOut(); }, delay);
		}else{

			if(app_comment != ""){
				var conf_answer = confirm("Are you sure you want to Send the Mail with Text Box Comments...?")
			}else{
				var conf_answer = confirm("Are you sure you want to Send the Mail...?")
			}
			
			if (conf_answer) {

				$('#myModal2').modal('show');
				$('.div_roller_total_22').fadeIn();
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/candidates/forwardmail_doc_modification"; ?>',
					data:{candadv_no: candadv_no, app_comment:app_comment, candapp_no: candapp_no, doctype: doctype, docid: docid, extfilename: extfilename},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total_22').fadeOut();
							$('.get_success_total_22').html('Email Send Successfully to the Candidate.');
							$(".get_success_total_22").fadeIn();
							//$('input').val('');
							setTimeout(function(){ $('.get_success_total_22').fadeOut(); }, 2000);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 1000);
							//setTimeout(function(){ location.reload(); }, 1000);
							
						}else{

							$('.div_roller_total_22').fadeOut();
							error_message = "There have some Problem to Update in DB, Try Again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total_22').html(error_message);
							$(".get_error_total_22").fadeIn();
							setTimeout(function(){ $('.get_error_total_22').fadeOut(); }, delay);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 2000);

						}
						
					}
				});

			}else{
				$('.div_roller_total_22').fadeOut();
				$('#myModal2').modal('hide');
			}
		}
		
	}	
	
	function gotoqualification_send_check(doctype, docid){
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

		var candadv_no = '<?php echo $appli_details->f_applied_for; ?>';
		var candapp_no = '<?php echo $appli_details->f_application_no; ?>';
		var app_comment = $('#app_comment').val();
		if(candadv_no == "" || candapp_no == "" || doctype == "" || docid == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(app_comment != ""){
			comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
			if(!comment1.match(alphanumerics_no)){
				e_error = 1;
				$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
			}else{
				$('.app_comment').html('');
			}	
		}

		if(e_error == 1){
			$('.div_roller_total_22').fadeOut();
			$('.get_error_total_22').html(error_message);
			$(".get_error_total_22").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_22').fadeOut(); }, delay);
		}else{

			if(app_comment != ""){
				var conf_answer = confirm("Are you sure you want to Send the Mail for Qualification Modification with Text Box Comments...?")
			}else{
				var conf_answer = confirm("Are you sure you want to Send the Mail for Qualification Modification...?")
			}
			
			if (conf_answer) {

				$('#myModal2').modal('show');
				$('.div_roller_total_22').fadeIn();
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/candidates/forwardmail_qualification_modification"; ?>',
					data:{candadv_no: candadv_no, app_comment:app_comment, candapp_no: candapp_no, doctype: doctype, docid: docid},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total_22').fadeOut();
							$('.get_success_total_22').html('Email Send Successfully to the Candidate.');
							$(".get_success_total_22").fadeIn();
							//$('input').val('');
							setTimeout(function(){ $('.get_success_total_22').fadeOut(); }, 2000);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 1000);
							//setTimeout(function(){ location.reload(); }, 1000);
							
						}else{

							$('.div_roller_total_22').fadeOut();
							error_message = "There have some Problem to Update in DB, Try Again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total_22').html(error_message);
							$(".get_error_total_22").fadeIn();
							setTimeout(function(){ $('.get_error_total_22').fadeOut(); }, delay);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 2000);

						}
						
					}
				});

			}else{
				$('.div_roller_total_22').fadeOut();
				$('#myModal2').modal('hide');
			}
		}
	}
    </script>