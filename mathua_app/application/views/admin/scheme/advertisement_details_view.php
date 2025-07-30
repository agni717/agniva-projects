<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url() . 'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Advertisement No - <span style="color:blue"><?php echo $adv_list->adv_no . ' [' . $adv_list->rm_name . ']'; ?></span>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Advertisement Details</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Main row -->
		<div class="row">
			<section class="col-lg-12"><?php //print_r($adv_list); 
										?>
				<!-- Custom tabs (Charts with tabs)-->

				<?php if ($this->session->flashdata('success')) { ?>
					<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
				<?php $this->session->unset_userdata('success');
				} elseif ($this->session->flashdata('e_error')) { ?>
					<div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
				<?php $this->session->unset_userdata('e_error');
				} ?>

				<!-- TO DO List -->
				<div class="box box-warning">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered">
									<tr>
										<td><strong>Recruitment For</strong></td>
										<td><?php echo $adv_list->rm_name; ?></td>
										<td><strong>Advertisement No.</strong></td>
										<td><?php echo $adv_list->adv_no; ?></td>
									</tr>
									<tr>
										<td><strong>Start Time</strong></td>
										<td><?php echo date('d-m-Y h:i A', strtotime($adv_list->adv_start_time)); ?></td>
										<td><strong>End Time</strong></td>
										<td><?php echo date('d-m-Y h:i A', strtotime($adv_list->adv_end_time)); ?></td>
									</tr>
									<tr>
										<td><strong>Scale of Pay</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_scale_pay; ?></td>
									</tr>

									<tr>
										<td colspan="4">
											<br /><br />
											<strong><u>Anticipate Vacancies:-</u></strong><br />
											<div class="table-responsive">
											<table class="table table-bordered table-striped" style="font-size:12px;">
												<tr>
													<td><b>Post</b></td>
													<td><b>Gender</b></td>
													<td><b>Marital Status</b></td>
													<td><b>UR</b></td>
													<td><b>UR (E.C.)</b></td>
													<td><b>UR (Ex-Service man in Group-C Post)</b></td>
													<td><b>UR (Ex-Servic eman in Group-D Post)</b></td>
													<td><b>UR (Meritorious Sports Person)</b></td>
													<td><b>SC</b></td>
													<td><b>SC (E.C.)</b></td>
													<td><b>SC (Ex-Service man in Group-C Post)</b></td>
													<td><b>SC (Ex-Service man in Group-D Post)</b></td>
													<td><b>ST</b></td>
													<td><b>ST (E.C.)</b></td>
													<td><b>ST (Ex-Service man in Group-D Post)</b></td>
													<td><b>OBC</b></td>
													<td><b>OBC-A</b></td>
													<td><b>OBC-A (E.C.)</b></td>
													<td><b>OBC-A (Ex-Service man in Group-D Post)</b></td>
													<td><b>OBC-B</b></td>
													<td><b>OBC-B (E.C.)</b></td>
													<td><b>OBC-B (Ex-Service man in Group-D Post)</b></td>
													<td><b>PWD</b></td>
													<td><b>TOTAL</b></td>
												</tr>
												<?php
												$total_ur = 0;
												$total_sc = 0;
												$total_st = 0;
												$total_o = 0;
												$total_oa = 0;
												$total_ob = 0;
												$total_ur_ec = $total_ur_sp = $total_ur_es_c = $total_ur_es_d = 0;
												$total_sc_ec = $total_sc_es_c = $total_sc_es_d = 0;
												$total_st_ec = $total_st_es_d = 0;
												$total_oa_ec = $total_oa_es_d = 0;
												$total_ob_ec = $total_ob_es_d = 0;
												$total_pwd = 0;
												$total_of_total = 0;
												foreach ($cat_details as $discips) {
													$gset = str_replace(",",", ", $discips->acat_gender_set);
													$mset = str_replace(",",", ", $discips->acat_marital_set);
													$total_ur = $total_ur + $discips->acat_ur;
													$total_sc = $total_sc + $discips->acat_sc;
													$total_st = $total_st + $discips->acat_st;
													$total_o = $total_o + $discips->acat_obc;
													$total_oa = $total_oa + $discips->acat_obc_a;
													$total_ob = $total_ob + $discips->acat_obc_b;
													$total_pwd = $total_pwd + $discips->acat_pwd;
													$total_ur_ec = $total_ur_ec + $discips->acat_ur_ec;
													$total_ur_sp = $total_ur_sp + $discips->acat_ur_sp;
													$total_ur_es_c = $total_ur_es_c + $discips->acat_ur_g_c;
													$total_ur_es_d = $total_ur_es_d + $discips->acat_ur_g_d;
													$total_sc_ec = $total_sc_ec + $discips->acat_sc_ec;
													$total_sc_es_c = $total_sc_es_c + $discips->acat_sc_g_c;
													$total_sc_es_d = $total_sc_es_d + $discips->acat_sc_g_d;
													$total_st_ec = $total_st_ec + $discips->acat_st_ec;
													$total_st_es_d = $total_st_es_d + $discips->acat_st_g_d;
													$total_oa_ec = $total_oa_ec + $discips->acat_obc_a_ec;
													$total_oa_es_d = $total_oa_es_d + $discips->acat_obc_a_g_d;
													$total_ob_ec = $total_ob_ec + $discips->acat_obc_b_ec;
													$total_ob_es_d = $total_ob_es_d + $discips->acat_obc_b_g_d;
													$total_of_total = $total_of_total + $discips->acat_total; ?>
													<tr>
														<td><?php echo $discips->catm_name; ?></td>
														<td><?php echo $gset; ?></td>
														<td><?php echo $mset; ?></td>
														<td><?php echo $discips->acat_ur; ?></td>
														<td><?php echo $discips->acat_ur_ec; ?></td>
														<td><?php echo $discips->acat_ur_g_c; ?></td>
														<td><?php echo $discips->acat_ur_g_d; ?></td>
														<td><?php echo $discips->acat_ur_sp; ?></td>
														<td><?php echo $discips->acat_sc; ?></td>
														<td><?php echo $discips->acat_sc_ec; ?></td>
														<td><?php echo $discips->acat_sc_g_c; ?></td>
														<td><?php echo $discips->acat_sc_g_d; ?></td>
														<td><?php echo $discips->acat_st; ?></td>
														<td><?php echo $discips->acat_st_ec; ?></td>
														<td><?php echo $discips->acat_st_g_d; ?></td>
														<td><?php echo $discips->acat_obc; ?></td>
														<td><?php echo $discips->acat_obc_a; ?></td>
														<td><?php echo $discips->acat_obc_a_ec; ?></td>
														<td><?php echo $discips->acat_obc_a_g_d; ?></td>
														<td><?php echo $discips->acat_obc_b; ?></td>
														<td><?php echo $discips->acat_obc_b_ec; ?></td>
														<td><?php echo $discips->acat_obc_b_g_d; ?></td>
														<td><?php echo $discips->acat_pwd; ?></td>
														<td><b><?php echo $discips->acat_total; ?></b></td>
													</tr>
												<?php } ?>
												<tr>
													<td colspan="3"><i>Total</i></td>
													<td><i><?php echo $total_ur; ?></i></td>
													<td><i><?php echo $total_ur_ec; ?></i></td>
													<td><i><?php echo $total_ur_es_c; ?></i></td>
													<td><i><?php echo $total_ur_es_d; ?></i></td>
													<td><i><?php echo $total_ur_sp; ?></i></td>
													<td><i><?php echo $total_sc; ?></i></td>
													<td><i><?php echo $total_sc_ec; ?></i></td>
													<td><i><?php echo $total_sc_es_c; ?></i></td>
													<td><i><?php echo $total_sc_es_d; ?></i></td>
													<td><i><?php echo $total_st; ?></i></td>
													<td><i><?php echo $total_st_ec; ?></i></td>
													<td><i><?php echo $total_st_es_d; ?></i></td>
													<td><i><?php echo $total_o; ?></i></td>
													<td><i><?php echo $total_oa; ?></i></td>
													<td><i><?php echo $total_oa_ec; ?></i></td>
													<td><i><?php echo $total_oa_es_d; ?></i></td>
													<td><i><?php echo $total_ob; ?></i></td>
													<td><i><?php echo $total_ob_ec; ?></i></td>
													<td><i><?php echo $total_ob_es_d; ?></i></td>
													<td><i><?php echo $total_pwd; ?></i></td>
													<td><i><b><?php echo $total_of_total; ?></b></i></td>
												</tr>
											</table>
											</div>
										</td>
									</tr>
									<tr>
										<td><strong>Total Vacancies</strong></td>
										<td><?php echo $adv_list->adv_total_recruit; ?></td>
										<td><strong>Fees</strong></td>
										<td><?php echo $adv_list->adv_fees; ?></td>
									</tr>
									<tr>
										<td><strong>Minimum DOB</strong></td>
										<td><?php echo date('d-M-Y', strtotime($adv_list->adv_min_age_limit)); ?></td>
										<td><strong>Maximum DOB</strong></td>
										<td><?php echo date('d-M-Y', strtotime($adv_list->adv_age_limit)); ?></td>
									</tr>
									<tr>
										<td><strong>Maximum Relaxation Year</strong></td>
										<td><?php echo $adv_list->adv_age_updown; ?></td>
										<td><strong>Minimum PWD Percentage</strong></td>
										<td><?php echo $adv_list->adv_pwd_percent.'%'; ?></td>
									</tr>
									<tr>
										<td colspan="4"><?php if (!empty($agefee_list)) { ?>
												<br /><br />
												<strong><u>Fee & Age Relaxation:-</u></strong><br />
												<table class="table table-bordered table-striped">
													<tr>
														<td><b>Section</b></td>
														<td><b>Relation Type</b></td>
														<td><b>Relaxation Year</b></td>
														<td><b>Fee Type</b></td>
														<td><b>Part Fee</b></td>
													</tr>
													<?php
															foreach ($agefee_list as $fages) { ?>
														<tr>
															<td><?php echo $fages->caste_name; ?></td>
															<td><?php echo $fages->advage_type; ?></td>
															<td><?php echo $fages->advage_up; ?></td>
															<td><?php echo $fages->advage_feetype; ?></td>
															<td><?php if ($fages->advage_feetype == "Part") {
																	echo $fages->advage_partfee;
																} else {
																} ?></td>
														</tr>
													<?php } ?>
												</table>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td><strong>Writeup about Age</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_age_writeup; ?></td>
									</tr>
									<!--<tr>
										<td><strong>Gender</strong></td>
										<td><?php //echo $adv_list->adv_gender_set; ?></td>
										<td><strong>Marital Status</strong></td>
										<td><?php //echo $adv_list->adv_marital_set; ?></td>
									</tr>-->
									<tr>
										<td><strong>Has Exampted</strong></td>
										<td><?php echo $adv_list->adv_has_exampted; ?></td>
										<td><strong>Has Ex-Sevice</strong></td>
										<td><?php echo $adv_list->adv_has_exservice; ?></td>
									</tr>
									<tr>
										<td><strong>Has EWS</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_has_ews; ?></td>
									</tr>
									<tr>
										<td colspan="4">
											<br /><br />
											<strong><u>Qualification Setup:-</u></strong><br />
											<table class="table table-bordered table-striped">
												<tr>
													<td><b>Qualification</b></td>
													<td><b>Type</b></td>
													<td><b>Total Marks</b></td>
													<td><b>Relation Type</b></td>
													<td><b>Distribution Category</b></td>
													<td><b>Segregation</b></td>
													<td><b>Additional Attempt</b></td>
													<td><b>Marks</b></td>
												</tr>
												<?php
												foreach ($q_list as $qips) { ?>
													<tr>
														<td><?php echo $qips->qm_name; ?></td>
														<td><?php echo $qips->aquali_examtype; ?></td>
														<td><?php echo $qips->aquali_marks; ?></td>
														<td><?php echo $qips->aquali_relation; ?></td>
														<td><?php echo $qips->aquali_category; ?></td>
														<td><?php if ($qips->aquali_category == "Slab") { ?>
																<table class="table table-striped" style="border:1px #999 solid;">
																	<tr>
																		<th>Upto Section</th>
																		<th>Marks</th>
																	</tr>
																	<?php foreach ($qdetail_list as $qd_sets) {
																		if ($qips->aquali_id == $qd_sets->aq_qualification_ms) { ?>
																			<tr>
																				<td><?php echo $qd_sets->aq_detail_score_lvl; ?></td>
																				<td><?php echo $qd_sets->aq_detail_score_mark; ?></td>
																			</tr>
																	<?php }
																	} ?>
																</table>
															<?php } elseif ($qips->aquali_category == "Percent") {
																echo $qips->aquali_fullpercent;
															} else {
															} ?>
														</td>
														<td><?php echo $qips->aquali_attempt; ?></td>
														<td><?php if ($qips->aquali_attempt == "Full" || $qips->aquali_attempt == "Percent") { ?>
																<?php echo $qips->aquali_fullpercent; ?>
															<?php } elseif($qips->aquali_attempt == "Slab") { ?>
																<table class="table table-striped" style="border:1px #999 solid;">
																	<tr>
																		<th>Upto Section</th>
																		<th>Marks</th>
																	</tr>
																	<?php foreach ($qdeduct_list as $qd_sets) {
																		if ($qips->aquali_id == $qd_sets->aq_deduction_ms) { ?>
																			<tr>
																				<td><?php echo $qd_sets->aq_deduct_lvl; ?></td>
																				<td><?php echo $qd_sets->aq_deduct_mark; ?></td>
																			</tr>
																	<?php }
																	} ?>
																</table>
															<?php } else {
															} ?>
														</td>
													</tr>
												<?php } ?>
											</table>
										</td>
									</tr>
									<tr>
										<td><strong>Writeup Essential Qualification</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_essen_qualification; ?></td>
									</tr>
									<tr>
										<td><strong>Writeup Desirable Qualification</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_desir_qualification; ?></td>
									</tr>
									<tr>
										<td><strong>Has Experience</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_has_experience; ?></td>
									</tr>
									<?php if($adv_list->adv_has_experience == "Yes"){ ?>
									<tr>
										<td colspan="4">
											<br /><br />
											<strong><u>Experience Setup:-</u></strong><br />
											<table class="table table-bordered table-striped">
												<tr>
													<td><b>Category</b></td>
													<td><b>Type</b></td>
													<td><b>Total Marks</b></td>
													<td><b>Relation</b></td>
													<td><b>Minimum Month</b></td>
													<td><b>Distribution Category</b></td>
													<td><b>Segregation</b></td>
												</tr>
												<?php
												foreach ($exp_list as $exps) { ?>
													<tr>
														<td><?php echo $exps->expset_name; ?></td>
														<td><?php echo $exps->aexpr_type; ?></td>
														<td><?php echo $exps->aexpr_marks; ?></td>
														<td><?php echo $exps->aexpr_relation; ?></td>
														<td><?php echo $exps->aexpr_min_month; ?></td>
														<td><?php echo $exps->aexpr_category; ?></td>
														<td><?php if ($exps->aexpr_category == "Slab") { ?>
																<table class="table table-striped" style="border:1px #999 solid;">
																	<tr>
																		<th>Section</th>
																		<th>Months</th>
																		<th>Marks</th>
																	</tr>
																	<?php foreach ($expdetail_list as $exp_sets) {
																		if ($exps->aexpr_id == $exp_sets->ae_experience_ms) { ?>
																			<tr>
																				<td><?php if ($exp_sets->ae_range_words == "GT") {
																					echo 'Greater Than Equal';
																				} else {
																					echo 'Less Than';
																				} ?></td>
																				<td><?php echo $exp_sets->ae_detail_month; ?></td>
																				<td><?php echo $exp_sets->ae_detail_mark; ?></td>
																			</tr>
																	<?php }
																	} ?>
																</table>
															<?php } ?>
														</td>
													</tr>
												<?php } ?>
											</table>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td><strong>Academic Marks</strong></td>
										<td><?php echo $adv_list->amark_academic; ?></td>
										<td><strong>Experience Marks</strong></td>
										<td><?php echo $adv_list->amark_experience; ?></td>
									</tr>
									<tr>
										<td><strong>Interview Marks</strong></td>
										<td><?php echo $adv_list->amark_interview; ?></td>
										<td><strong>Written Marks</strong></td>
										<td><?php echo $adv_list->amark_written; ?></td>
									</tr>
									<tr>
										<td><strong>Writeup about Experience</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_marks_writeup; ?></td>
									</tr>
									<tr>
										<td><strong>Source Document</strong></td>
										<td colspan="3"><a href="<?php echo base_url() . 'upload_file/adv_doc/' . $adv_list->adv_source_doc; ?>" target="_blank">Attached Document</a></td>
									</tr>
									<tr>
										<td><strong>Writeup Miscellenius</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_miscellenius; ?></td>
									</tr>
									<tr>
										<td><strong>Writeup About Disabilities</strong></td>
										<td colspan="3"><?php echo $adv_list->adv_disability; ?></td>
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
						<div class="col-sm-12 text-center">
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

<script src="<?php echo base_url() . 'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$('#alert_msg').delay(6000).fadeOut();
		$("#datatable_tab").dataTable();
	});

	function goto_details_view(q_no) {
		if (q_no != "") {
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/discussion/getinfo_fromquery_no"; ?>',
				data: {
					q_no: q_no
				},
				dataType: 'JSON',
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.q_number_set').html(q_no);
						if (data.info_set.query_is_reply == 0) {
							$('.replytab').fadeOut();
						} else {
							$('.replytab').fadeIn();
							$('.q_reply_set').html(data.info_set.query_reply_details);
							if (data.info_set.query_reply_attach == null) {
								$('.haveAttachment').fadeOut();
							} else {
								$('.haveAttachment').fadeIn();
								$('.q_reply_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/reply/' + data.info_set.query_reply_attach + '" target="_blank" style="color:#111;">Attached Reply Document</a>');
							}
						}
						$('.q_subject_set').html(data.info_set.query_subject);
						$('.q_detail_set').html(data.info_set.query_details);
						if (data.info_set.query_attachment == null) {
							$('.mainAttachment').fadeOut();
						} else {
							$('.mainAttachment').fadeIn();
							$('.q_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/' + data.info_set.query_attachment + '" target="_blank" style="color:#111;">Attached Document</a>');
						}
						$('#myModalView').modal('show');
						//setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						//setTimeout(function(){ window.location.replace("<?php echo site_url('member/testing_list') ?>/"); }, 3000);


					} else {
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

	function goto_reply_view(q_no) {
		if (q_no != "") {

			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/discussion/getinfo_fromquery_no"; ?>',
				data: {
					q_no: q_no
				},
				dataType: 'JSON',
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.q_number_set').html(q_no);
						$('.q_subject_set').html(data.info_set.query_subject);
						$('.q_detail_set').html(data.info_set.query_details);
						if (data.info_set.query_attachment == null) {
							$('.mainAttachment').fadeOut();
						} else {
							$('.mainAttachment').fadeIn();
							$('.q_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/' + data.info_set.query_attachment + '" target="_blank" style="color:#111;">Attached Document</a>');
						}
						$('#files,#reply_comment').val('');
						$('#query_no').val(q_no);
						$('#myModalReply').modal('show');


					} else {
						error_message = data.e_msg;
						$('.alert-error').html(error_message);
						$(".alert-error").fadeIn();
						//setTimeout(function(){ $('.alert-error').fadeOut(); }, delay);
					}

				}
			});

		}
	}

	function goto_clickbutton_administrator() {
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

		if (query_no == "") {
			e_error = 1;
			error_message = error_message + '<br/>There have some problem in page ID, Reload the Page and Try again.';
		}

		if (reply_comment == "") {
			e_error = 1;
			$('.reply_comment').html('Reply is Required.');
		} else {
			reply_comment = reply_comment.replace(/(\r\n|\n|\r)/gm, " ");
			if (!reply_comment.match(alphanumerics_no)) {
				e_error = 1;
				$('.reply_comment').html('Reply not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			} else {
				$('.reply_comment').html('');
			}
		}

		if (document.getElementById("files").files.length != 0) {
			var fileInput = document.getElementById('files');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.files').html('Attachment File type Invalid.');
			} else {
				$('.files').html('');
			}

		}

		//alert(salts);
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
			//alert(task_start_time);exit;
			//alert(rehash);
			//$("#myForm").submit();
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/discussion/update_reply_against_query') ?>",
				dataType: 'json',
				data: form_data,
				contentType: false,
				cache: true,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Reply is updated agasint the Query Successfully.');
						$(".get_success_total").fadeIn();
						$('input, textarea').val('');
						$('input, textarea').html('');
						setTimeout(function() {
							$('.get_success_total').fadeOut();
						}, 3000);
						setTimeout(function() {
							window.location.replace("<?php echo site_url('admincontrol/discussion/all_query_list') ?>");
						}, 3000);

					} else {
						$('.div_roller_total').fadeOut();
						error_message = "There have some problem to Update Data, Try again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function() {
							$('.get_error_total').fadeOut();
						}, delay);
					}

				}
			});
		}
	}
</script>