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
            Candidate's Application Re-Check
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Application Re-Check</li>
          </ol>
        </section>

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
					<h3>Checking For - <?php 
					$str_arr = array(
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
							'fu_ews' => 'EWS',
							'fu_qualification' => 'Qualification',
							'fu_has_service' => 'Service Experience'
						); echo $str_arr[$accessarray[0]]; ?></h3>
				<?php $urllink = base_url().'upload_file/'.$appli_details->f_applied_for.'/candidates/'.$appli_details->f_application_no.'/'; ?>  
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
										<td><strong>Address</strong></td>
										<td><?php echo $appli_details->fu_address; ?></td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_district", $accessarray)){ ?>
									<tr>
										<td><strong>District</strong></td>
										<td><?php echo $appli_details->district_name; ?></td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_domicile_state", $accessarray)){ ?>
									<tr>
										<td><strong>Domicile State</strong></td>
										<td><?php echo $appli_details->state_name; ?></td>
									</tr>
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
									<tr>
										<td colspan="2">
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
												<td><?php echo $qips->fu_percent_of_marks; ?></td>
												<td><?php echo $qips->fu_percent_of_marks; ?></td>
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php } ?>
									<?php if($accessarray[0] == "ALL" || in_array("fu_has_service", $accessarray)){ ?>
									<tr>
										<td><strong>Has Service Experience</strong></td>
										<td><?php echo $appli_details->fu_has_service; ?></td>
									</tr>
									<?php if($appli_details->fu_has_service == "Yes"){ ?>
										<tr>
										<td colspan="2">
										<table class="table table-bordered table-striped">
											<tr>
											<td><strong>Work</strong></td>
											<td><strong>Organization</strong></td>
											<td><strong>Work Type</strong></td>
											<td><strong>Time Period</strong></td>
											</tr>
											<?php foreach($exp_details as $expss){ ?>
											<tr>
											<td><?php echo $expss->fu_exp_workname; ?></td>
											<td><?php echo $expss->fu_exp_org_name; ?></td>
											<td><?php echo $expss->fu_exp_worktype; ?></td>
											<td><?php echo $expss->fu_exp_year.' Year & '.$expss->fu_exp_month.' Month'; ?></td>
											</tr>
											<?php } ?>
										</table>
										</td>
									</tr>
									<?php }} ?>
									<tr>
										<td colspan="2">
											<div>
											  <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Give Your Approval</a>
											  <!--<a href="#" class="btn btn-danger">Reject</a>
											  <a href="#" class="btn btn-warning">Doubtful</a>-->
										  	</div>
										</td>
									</tr>
								</table>
							</td>
							<td width="50%" align="left">
								<?php if($accessarray[0] == "ALL" || in_array("fu_photo_doc", $accessarray)){ ?>
								<strong>Candidate Photograph</strong><br/>
								<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_photo_doc; ?>"></iframe><br/>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_dob", $accessarray)){ ?>
								<strong>DOB Document</strong><br/>
								<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_dob_doc; ?>"></iframe><br/>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_address", $accessarray)){ ?>
								<strong>Address Proof</strong><br/>
								<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_address_doc; ?>"></iframe><br/>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_signature_doc", $accessarray)){ ?>
								<strong>Signature Document</strong><br/>
								<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_signature_doc; ?>"></iframe><br/>
								<?php } ?>
								
								<?php if($accessarray[0] == "ALL" || in_array("fu_caste", $accessarray)){
								if($appli_details->fu_caste_type != 1){ ?>
									<strong>Caste Document</strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_caste_doc; ?>"></iframe><br/>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_pwd", $accessarray)){
								if($appli_details->fu_pwd == "Yes"){ ?>
									<strong>PWD Document</strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_pwd_doc; ?>"></iframe><br/>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exempted", $accessarray)){
								if($appli_details->fu_exempted == "Yes"){ ?>
									<strong>Document of Exempted</strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_exc_doc; ?>"></iframe><br/>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_exservice", $accessarray)){
								if($appli_details->fu_exservice == "Yes"){ ?>
									<strong>Document of ExService</strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_exs_doc; ?>"></iframe><br/>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_ews", $accessarray)){
								if($appli_details->fu_ews == "Yes"){ ?>
									<strong>Document of Relaxation</strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$appli_details->fu_ews_doc; ?>"></iframe><br/>
								<?php }} ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_qualification", $accessarray)){ ?>
									<table class="table table-bordered table-striped">
										<tr>
											<td><b>Qualification Attachment</b></td>
										</tr>
										<?php foreach($quali_details as $qips){ ?>
										<tr>
											<td><?php echo $qips->qm_name; ?><br/>
											<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$qips->fu_quali_docs; ?>"></iframe></td>
										</tr>
										<?php } ?>
									</table>
								<?php } ?>
								<?php if($accessarray[0] == "ALL" || in_array("fu_has_service", $accessarray)){
								if($appli_details->fu_has_service == "Yes"){ ?>
									<?php foreach($exp_details as $keys=>$exps){ ?> 
									<strong><?php echo $keys+1; ?>. <?php echo $exps->fu_exp_workname; ?></strong><br/>
									<iframe id="dcopy_frameset" width="100%" height="500px;" src="<?php echo $urllink.$exps->fu_exp_marksheet_doc; ?>"></iframe><br/>
									<?php } ?>
								<?php }} ?>
							</td>
						</tr>
						
						
						<!--<tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_father_name", $accessarray)){ ?>
							<td><strong>Father's Name</strong></td>
							<td><?php echo $appli_details->fu_father_name; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_mother_name", $accessarray)){ ?>
							<td><strong>Mother's Name</strong></td>
							<td><?php echo $appli_details->fu_mother_name; ?></td>
							<?php } ?>
						</tr>-->
						
						
						
						<!--<tr>
							<?php if($accessarray[0] == "ALL" || in_array("fu_gender", $accessarray)){ ?>
							<td><strong>Gender</strong></td>
							<td><?php echo $appli_details->fu_gender; ?></td>
							<?php } ?>
							<?php if($accessarray[0] == "ALL" || in_array("fu_marital_status", $accessarray)){ ?>
							<td><strong>Marital Status</strong></td>
							<td><?php echo $appli_details->fu_marital_status; ?></td>
							<?php } ?>
						</tr>-->
						
						
                  	</tbody>
                  </table>
				  
				  </div>
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
        //$("#datatable_tab").dataTable();
      });
	
	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
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
		
    	var app_status = $('#app_status option:selected').val();
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
			}else{
				$('.app_comment').html('');
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
				url:'<?php echo base_url()."admincontrol/candidates/checking_section_modify_by_chker_two"; ?>',
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
						<?php if($p_detail == "A"){ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_approve_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
						<?php }elseif($p_detail == "R"){ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_reject_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
						<?php }else{ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_doubtful_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
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
						<?php if($p_detail == "A"){ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_approve_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
						<?php }elseif($p_detail == "R"){ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_reject_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
						<?php }else{ ?>
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_doubtful_application_details/'.$appli_details->f_application_no)?>"); }, 3000);
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
	  
    </script>