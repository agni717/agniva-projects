<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<!--<link href="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />-->

<?php $pathurl = base_url().'upload_file/'.$fuser_detailset->f_applied_for.'/candidates/'.$fuser_detailset->f_application_no.'/'; ?>
        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Application No - <span style="color:blue"><?php echo $fuser_detailset->f_application_no; ?></span>
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
						<div class="col-sm-12 text-center">
							<p style="font-size:25px;font-weight:bold;">Name :- <?php echo $fuser_detailset->f_full_name; ?><br/>
							Mobile :- <?php echo $fuser_detailset->f_mobile; ?> | Email :- <?php echo $fuser_detailset->f_email; ?></p>	
							<p style="font-size:20px;font-weight:bold;">Recruitment For :- <?php echo $fuser_detailset->rm_name; ?><br/>
							Advertisement No. :- <?php echo $fuser_detailset->adv_no; ?></p><br/><br/>
						</div>
						<div class="col-sm-12">
						<?php //print_r($fuser_detailset); ?>
						<?php echo form_open_multipart('','class="" id="form123"'); ?>
						<div class="row">
						<div class="col-sm-offset-1 col-sm-8">
							<div class="form-group">
								<label>Choose Section</label>&nbsp;&nbsp;&nbsp;
								<input type="radio" name="sectiontype" id="sectiontype1" value="EQ" autocomplete="off" onchange="check_typeset();" checked /> Essential Qualification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="sectiontype" id="sectiontype2" value="DQ" autocomplete="off" onchange="check_typeset();" /> Dessirable Qualification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="sectiontype" id="sectiontype3" value="ES" autocomplete="off" onchange="check_typeset();" /> Essential Experience &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="sectiontype" id="sectiontype4" value="DS" autocomplete="off" onchange="check_typeset();" /> Dessirable Experience 
							</div>
						</div>
						</div>
						<div class="row typeset_1">
							<?php $secarr = (array)$quali_list;
							//echo "<pre>";//print_r($quali_list);exit;
							for($q=0; $q<$adv_detail->adv_qualification_no;$q++){ 
								//if(count((array)$quali_exam[$q]) > 1){ ?>
							
							<div class="col-sm-offset-1 col-sm-6">
							<div class="form-group">
							<label>Candidate Essential Qualification <?php echo ($q+1); ?></label>
							<input type="hidden" id="examid_<?php echo $q; ?>" name="examid_<?php echo $q; ?>" value="<?php if(!empty($secarr[$q]->fu_quali_id)){echo $secarr[$q]->fu_quali_id;} ?>" />
							<select class="form-control exam-name-input" name="exam_name_<?php echo $q; ?>" id="exam_name_<?php echo $q; ?>">
								<?php 
								$cheq = 0;
								while(count($quali_exam) > 0){
									$eq_arr = array();
									foreach($quali_exam[$cheq] as $eqexam){
										$eq_arr[] = $eqexam['aquali_exam'];
									}
									if(in_array($secarr[$q]->fu_qualifiaction_name, $eq_arr)){
										break;
									}else{
										$cheq++;
									}
								}
								foreach ($quali_exam[$cheq] as $exam) { ?>
								<option value="<?= $exam['aquali_exam'] ?>" <?php if(!empty($secarr[$q]->fu_qualifiaction_name)){if($secarr[$q]->fu_qualifiaction_name == $exam['aquali_exam']){echo "selected";}} ?>><?= $exam['qm_name'] ?></option>
								<?php } ?>
							</select>
							<small class="text-error exam_name_<?php echo $q; ?>"><?php echo form_error('exam_name_'.$q); ?></small>
							</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Candidate Document <?php echo ($q+1); ?></label><br/>
									<a href="<?php echo $pathurl.$secarr[$q]->fu_quali_docs; ?>" target="_blank">Attached Document</a>
								</div>
							</div>
							<?php //}
							} ?>
							<div class="col-sm-12">
								<div class="form-group">	
									<div align="center">
											<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 text-center" style="margin:5px 0;">
								<input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="row typeset_2" style="display:none;">
							<?php $secarr2 = (array)$des_quali_list;
							//echo "<pre>";//print_r($des_quali_list);exit;
							if(count($secarr2) > 0){
							for($q=0; $q<count($secarr2);$q++){ ?>
							<div class="col-sm-offset-1 col-sm-6">
							<div class="form-group">
							<label>Candidate Dessirable Qualification <?php echo ($q+1); ?></label>
							<input type="hidden" id="dexamid_<?php echo $q; ?>" name="dexamid_<?php echo $q; ?>" value="<?php if(!empty($secarr2[$q]->fud_quali_id)){echo $secarr2[$q]->fud_quali_id;} ?>" />
							<select class="form-control exam-name-input" name="dexam_name_<?php echo $q; ?>" id="dexam_name_<?php echo $q; ?>">
								<?php 
								$chdq = 0;
								while(count($desire_quali_exam) > 0){
									$dq_arr = array();
									foreach($desire_quali_exam[$chdq] as $dqexam){
										$dq_arr[] = $dqexam['aquali_exam'];
									}
									if(in_array($secarr2[$q]->fud_qualifiaction_name, $dq_arr)){
										break;
									}else{
										$chdq++;
									}
								}
								foreach ($desire_quali_exam[$chdq] as $exam) { ?>
								<option value="<?= $exam['aquali_exam'] ?>" <?php if(!empty($secarr2[$q]->fud_qualifiaction_name)){if($secarr2[$q]->fud_qualifiaction_name == $exam['aquali_exam']){echo "selected";}} ?>><?= $exam['qm_name'] ?></option>
								<?php } ?>
							</select>
							<small class="text-error dexam_name_<?php echo $q; ?>"><?php echo form_error('dexam_name_'.$q); ?></small>
							</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Candidate Document <?php echo ($q+1); ?></label><br/>
									<a href="<?php echo $pathurl.$secarr2[$q]->fud_quali_docs; ?>" target="_blank">Attached Document</a>
								</div>
							</div>
							<?php
							} 
							
							?>
							<div class="col-sm-12">
								<div class="form-group">	
									<div align="center">
											<div class="get_error_total2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="get_success_total2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="div_roller_total2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 text-center" style="margin:5px 0;">
								<input type="button" id="pa_target_submit2"  onclick="goto_submit_button2()" class="btn btn-primary pull-center"  value="Submit" />
							</div>
							<div class="clearfix"></div>
							<?php }else{echo "<div align='center' style='font-size:20px;padding:30px 0;'>No Record Found.</div>";} ?>
						</div>
						<div class="row typeset_3" style="display:none;">
							<?php $secarr3 = (array)$essenexp_detail_list;
							//echo "<pre>";//print_r($des_quali_list);exit;
							if(count($secarr3) > 0){
							for($q=0; $q<count($secarr3);$q++){ ?>
							<div class="col-sm-offset-1 col-sm-6">
							<div class="form-group">
							<label>Candidate Essential Experience <?php echo ($q+1); ?></label>
							<input type="hidden" id="esexamid_<?php echo $q; ?>" name="esexamid_<?php echo $q; ?>" value="<?php if(!empty($secarr3[$q]->fues_exp_id)){echo $secarr3[$q]->fues_exp_id;} ?>" />
							<select class="form-control exam-name-input" name="esexam_name_<?php echo $q; ?>" id="esexam_name_<?php echo $q; ?>">
								<?php 
								$chdq = 0;
								while(count($ess_expr) > 0){
									$es_arr = array();
									foreach($ess_expr[$chdq] as $esqexam){
										$es_arr[] = $esqexam['expid'];
									}
									if(in_array($secarr3[$q]->fues_exp_workname, $es_arr)){
										break;
									}else{
										$chdq++;
									}
								}
								foreach ($ess_expr[$chdq] as $exam) { ?>
								<option value="<?= $exam['expid'] ?>" <?php if(!empty($secarr3[$q]->fues_exp_workname)){if($secarr3[$q]->fues_exp_workname == $exam['expid']){echo "selected";}} ?>><?= $exam['exp_name'] ?></option>
								<?php } ?>
							</select>
							<small class="text-error esexam_name_<?php echo $q; ?>"><?php echo form_error('esexam_name_'.$q); ?></small>
							</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Candidate Document <?php echo ($q+1); ?></label><br/>
									<a href="<?php echo $pathurl.$secarr3[$q]->fues_exp_marksheet_doc; ?>" target="_blank">Attached Document</a>
								</div>
							</div>
							<?php
							} 
							
							?>
							<div class="col-sm-12">
								<div class="form-group">	
									<div align="center">
											<div class="get_error_total3" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="get_success_total3" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="div_roller_total3" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 text-center" style="margin:5px 0;">
								<input type="button" id="pa_target_submit3"  onclick="goto_submit_button3()" class="btn btn-primary pull-center"  value="Submit" />
							</div>
							<div class="clearfix"></div>
							<?php }else{echo "<div align='center' style='font-size:20px;padding:30px 0;'>No Record Found.</div>";} ?>
						</div>
						<div class="row typeset_4" style="display:none;">
							<?php $secarr4 = (array)$exp_detail_list;
							//echo "<pre>";//print_r($exp_detail_list);exit;
							if(count($secarr4) > 0){
							for($q=0; $q<count($secarr4);$q++){ ?>
							<div class="col-sm-offset-1 col-sm-6">
							<div class="form-group">
							<label>Candidate Dessirable Experience <?php echo ($q+1); ?></label>
							<input type="hidden" id="dsexamid_<?php echo $q; ?>" name="dsexamid_<?php echo $q; ?>" value="<?php if(!empty($secarr4[$q]->fu_exp_id)){echo $secarr4[$q]->fu_exp_id;} ?>" />
							<select class="form-control exam-name-input" name="dsexam_name_<?php echo $q; ?>" id="dsexam_name_<?php echo $q; ?>">
								<?php 
								$chdq = 0;
								while(count($desire_expr) > 0){
									$es_arr = array();
									foreach($desire_expr[$chdq] as $dsqexam){
										$es_arr[] = $dsqexam['expid'];
									}
									if(in_array($secarr4[$q]->fu_exp_workname, $es_arr)){
										break;
									}else{
										$chdq++;
									}
								}
								foreach ($desire_expr[$chdq] as $exam) { ?>
								<option value="<?= $exam['expid'] ?>" <?php if(!empty($secarr4[$q]->fu_exp_workname)){if($secarr4[$q]->fu_exp_workname == $exam['expid']){echo "selected";}} ?>><?= $exam['exp_name'] ?></option>
								<?php } ?>
							</select>
							<small class="text-error dsexam_name_<?php echo $q; ?>"><?php echo form_error('dsexam_name_'.$q); ?></small>
							</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<label>Candidate Document <?php echo ($q+1); ?></label><br/>
									<a href="<?php echo $pathurl.$secarr4[$q]->fu_exp_marksheet_doc; ?>" target="_blank">Attached Document</a>
								</div>
							</div>
							<?php } ?>
							<div class="col-sm-12">
								<div class="form-group">	
									<div align="center">
											<div class="get_error_total4" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="get_success_total4" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
											<div class="div_roller_total4" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 text-center" style="margin:5px 0;">
								<input type="button" id="pa_target_submit4"  onclick="goto_submit_button4()" class="btn btn-primary pull-center"  value="Submit" />
							</div>
							<div class="clearfix"></div>
							<?php }else{echo "<div align='center' style='font-size:20px;padding:30px 0;'>No Record Found.</div>";} ?>
						</div>
						<?php echo form_close(); ?>
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

<!--<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>-->
	<script type="text/javascript">
		$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	      //$("#datatable_tab").dataTable();
		});
	
	function check_typeset(){
		var sectiontype = $("input[name='sectiontype']:checked").val();
		if(sectiontype == "EQ"){
			$(".typeset_2, .typeset_3, .typeset_4").fadeOut();
            $(".typeset_1").fadeIn();
		}else if(sectiontype == "DQ"){
            $(".typeset_1, .typeset_3, .typeset_4").fadeOut();
            $(".typeset_2").fadeIn();
		}else if(sectiontype == "ES"){
            $(".typeset_1, .typeset_2, .typeset_4").fadeOut();
            $(".typeset_3").fadeIn();
		}else if(sectiontype == "DS"){
            $(".typeset_1, .typeset_2, .typeset_3").fadeOut();
            $(".typeset_4").fadeIn();
		}
	}

	function goto_submit_button(){
		
		$('.div_roller_total').fadeIn();
		$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", true);
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
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
		var main_refid = '<?php echo $fuser_detailset->f_application_no ?>';
		var totalexam = parseInt('<?php echo $adv_detail->adv_qualification_no; ?>');
		//alert(totalexam);
		
		if(main_refid == ""){
			e_error = 1;
			error_message = "Refresh the Page ID not found.";
		}

		for(var cntset = 0; cntset<totalexam; cntset++){

			var examid = $("input[name='examid_"+cntset+"']").val();
			var exam_name = $("select[name='exam_name_"+cntset+"'] option:selected").val();

			if(examid == ""){
				e_error = 1;
				error_message = "Refresh the Page Qualification-ID not found.";
			}
			if(exam_name == ""){
				e_error = 1;
				$('.exam_name_'+cntset).html('Qualification is Required');
			}else{
				$('.exam_name_'+cntset).html('');
			}
		}

		
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			var conf_answer = confirm("Are you sure you want to modify Candidate Qualification?")
			if (conf_answer){
				var form_data = new FormData();
				form_data.append('main_refid', main_refid);
				form_data.append('total_exam', totalexam);
				for(var cntsetss = 0; cntsetss<totalexam; cntsetss++){
					var examid = $("input[name='examid_"+cntsetss+"']").val();
					var exam_name = $("select[name='exam_name_"+cntsetss+"'] option:selected").val();

					form_data.append('examid[]', examid);
					form_data.append('exam_name[]', exam_name);
				}
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/candidates/cand_qualification_swapping_submission"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Candidate Essential Qualification is Updated Successfully.');
							$(".get_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/candidates/comp_application_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total').fadeOut();
							$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
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
			}else{
				$('.div_roller_total').fadeOut();
				$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			}
		}
	}
	
	function goto_submit_button2(){
		
		$('.div_roller_total2').fadeIn();
		$('##pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", true);
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
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
		var main_refid = '<?php echo $fuser_detailset->f_application_no ?>';
		var totalexam = parseInt('<?php echo count($secarr2); ?>');
		//alert(totalexam);
		
		if(main_refid == ""){
			e_error = 1;
			error_message = "Refresh the Page ID not found.";
		}

		for(var cntset = 0; cntset<totalexam; cntset++){

			var examid = $("input[name='dexamid_"+cntset+"']").val();
			var exam_name = $("select[name='dexam_name_"+cntset+"'] option:selected").val();

			if(examid == ""){
				e_error = 1;
				error_message = "Refresh the Page Qualification-ID not found.";
			}
			if(exam_name == ""){
				e_error = 1;
				$('.dexam_name_'+cntset).html('Qualification is Required');
			}else{
				$('.dexam_name_'+cntset).html('');
			}
		}

		
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total2').fadeOut();
			$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			$('.get_error_total2').html(error_message);
			$(".get_error_total2").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total2').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			var conf_answer = confirm("Are you sure you want to modify Candidate Qualification?")
			if (conf_answer){
				var form_data = new FormData();
				form_data.append('main_refid', main_refid);
				form_data.append('total_exam', totalexam);
				for(var cntsetss = 0; cntsetss<totalexam; cntsetss++){
					var examid = $("input[name='dexamid_"+cntsetss+"']").val();
					var exam_name = $("select[name='dexam_name_"+cntsetss+"'] option:selected").val();

					form_data.append('examid[]', examid);
					form_data.append('exam_name[]', exam_name);
				}
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/candidates/cand_desire_qualification_swapping_submission"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total2').fadeOut();
							$('.get_success_total2').html('Candidate Dessirable Qualification is Updated Successfully.');
							$(".get_success_total2").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total2').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/candidates/comp_application_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total2').fadeOut();
							$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
							error_message = "There have some problem to Update Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total2').html(error_message);
							$(".get_error_total2").fadeIn();
							setTimeout(function() {
								$('.get_error_total2').fadeOut();
							}, delay);
						}

					}
				});
			}else{
				$('.div_roller_total2').fadeOut();
				$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			}
		}
	}

	function goto_submit_button3(){
		
		$('.div_roller_total3').fadeIn();
		$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", true);
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
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
		var main_refid = '<?php echo $fuser_detailset->f_application_no ?>';
		var totalexam = parseInt('<?php echo count($secarr3); ?>');
		//alert(totalexam);
		
		if(main_refid == ""){
			e_error = 1;
			error_message = "Refresh the Page ID not found.";
		}

		for(var cntset = 0; cntset<totalexam; cntset++){

			var examid = $("input[name='esexamid_"+cntset+"']").val();
			var exam_name = $("select[name='esexam_name_"+cntset+"'] option:selected").val();

			if(examid == ""){
				e_error = 1;
				error_message = "Refresh the Page Experience-ID not found.";
			}
			if(exam_name == ""){
				e_error = 1;
				$('.esexam_name_'+cntset).html('Experience is Required');
			}else{
				$('.esexam_name_'+cntset).html('');
			}
		}

		
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total3').fadeOut();
			$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			$('.get_error_total3').html(error_message);
			$(".get_error_total3").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total3').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			var conf_answer = confirm("Are you sure you want to modify Candidate Experience?")
			if (conf_answer){
				var form_data = new FormData();
				form_data.append('main_refid', main_refid);
				form_data.append('total_exam', totalexam);
				for(var cntsetss = 0; cntsetss<totalexam; cntsetss++){
					var examid = $("input[name='esexamid_"+cntsetss+"']").val();
					var exam_name = $("select[name='esexam_name_"+cntsetss+"'] option:selected").val();

					form_data.append('examid[]', examid);
					form_data.append('exam_name[]', exam_name);
				}
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/candidates/cand_ess_experience_swapping_submission"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total3').fadeOut();
							$('.get_success_total3').html('Candidate Essential Experience is Updated Successfully.');
							$(".get_success_total3").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total3').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/candidates/comp_application_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total3').fadeOut();
							$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
							error_message = "There have some problem to Update Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total3').html(error_message);
							$(".get_error_total3").fadeIn();
							setTimeout(function() {
								$('.get_error_total3').fadeOut();
							}, delay);
						}

					}
				});
			}else{
				$('.div_roller_total3').fadeOut();
				$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			}
		}
	}

	function goto_submit_button4(){
		
		$('.div_roller_total4').fadeIn();
		$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", true);
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
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
		var main_refid = '<?php echo $fuser_detailset->f_application_no ?>';
		var totalexam = parseInt('<?php echo count($secarr4); ?>');
		//alert(totalexam);
		
		if(main_refid == ""){
			e_error = 1;
			error_message = "Refresh the Page ID not found.";
		}

		for(var cntset = 0; cntset<totalexam; cntset++){

			var examid = $("input[name='dsexamid_"+cntset+"']").val();
			var exam_name = $("select[name='dsexam_name_"+cntset+"'] option:selected").val();

			if(examid == ""){
				e_error = 1;
				error_message = "Refresh the Page Experience-ID not found.";
			}
			if(exam_name == ""){
				e_error = 1;
				$('.dsexam_name_'+cntset).html('Experience is Required');
			}else{
				$('.dsexam_name_'+cntset).html('');
			}
		}

		
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total4').fadeOut();
			$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			$('.get_error_total4').html(error_message);
			$(".get_error_total4").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total3').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			var conf_answer = confirm("Are you sure you want to modify Candidate Experience?")
			if (conf_answer){
				var form_data = new FormData();
				form_data.append('main_refid', main_refid);
				form_data.append('total_exam', totalexam);
				for(var cntsetss = 0; cntsetss<totalexam; cntsetss++){
					var examid = $("input[name='dsexamid_"+cntsetss+"']").val();
					var exam_name = $("select[name='dsexam_name_"+cntsetss+"'] option:selected").val();

					form_data.append('examid[]', examid);
					form_data.append('exam_name[]', exam_name);
				}
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/candidates/cand_desire_experience_swapping_submission"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total4').fadeOut();
							$('.get_success_total4').html('Candidate Dessirable Experience is Updated Successfully.');
							$(".get_success_total4").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total4').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/candidates/comp_application_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total4').fadeOut();
							$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
							error_message = "There have some problem to Update Data, Try after some time.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total4').html(error_message);
							$(".get_error_total4").fadeIn();
							setTimeout(function() {
								$('.get_error_total4').fadeOut();
							}, delay);
						}

					}
				});
			}else{
				$('.div_roller_total4').fadeOut();
				$('#pa_target_submit, #pa_target_submit2, #pa_target_submit3, #pa_target_submit4').attr("disabled", false);
			}
		}
	}

    </script>