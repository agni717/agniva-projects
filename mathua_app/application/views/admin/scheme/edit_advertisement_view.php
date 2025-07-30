<?php $this->load->view('admin/component/header') ?>

<link rel="stylesheet" href="<?php echo base_url('bootstrap-admin/bootstrap/css/bootstrap-multiselect.css'); ?>">

<?php $this->load->view('admin/component/menu') ?>
<style>
	select {
		color: #555555;
		height: 25px;
		line-height: 30px;
	}

	/*.box-body textarea,input {max-width: 500px;}*/
	.box-body textarea {
		resize: vertical;
	}

	.ui-datepicker table {
		border: 1px solid #000;
	}

	.cat_textbox {
		width: 100px;
	}

	.table-bordered {
		border: 1px solid #999;
	}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Modify Advertisement<span style="color:blue"><?php //echo $adv_list->adv_no.' ['.$adv_list->rm_name.']'; ?></span>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Modify Advertisement</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<!-- Main row -->
		<div class="row">
			<section class="col-lg-12">
				<!-- Custom tabs (Charts with tabs)-->

				<?php if (isset($error)) { ?>
					<div class="alert alert-error">
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
				<?php } ?>

				<!-- TO DO List -->
				<div class="box box-warning">
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body">

						<?php echo form_open_multipart('', 'class="form-horizontal" id="myForm"'); ?>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Recruitment For<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="hidden" class="form-control" name="adv_no" id="adv_no" value="<?php echo $adv_list->adv_auto_genno; ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_category" id="adv_category" value="<?php echo count((array)$cat_details); ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_qualification" id="adv_qualification" value="<?php echo count((array)$q_list); ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_exact_exams" id="adv_exact_exams" value="<?php echo $adv_list->adv_qualification_no; ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_experience" id="adv_experience" value="<?php echo count((array)$exp_list); ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="exact_exp_counter" id="exact_exp_counter" value="<?php echo $adv_list->adv_experience_no; ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_agecounter" id="adv_agecounter" value="<?php echo count((array)$agefee_list); ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_prev_agetype" id="adv_prev_agetype" value="<?php if(count((array)$agefee_list) > 0){echo $endage_detail->advage_type;} ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_prev_quali" id="adv_prev_quali" value="<?php if(count((array)$q_list) > 0){echo $endquali_detail->aquali_relation;} ?>" autocomplete="off" />
								<input type="hidden" class="form-control" name="adv_prev_expr" id="adv_prev_expr" value="<?php if(count((array)$exp_list) > 0){echo $endexpr_detail->aexpr_relation;} ?>" autocomplete="off" />
								<select class="form-control" name="r_for" id="r_for" onchange="check_rec_type();">
									<option value="">---Select---</option>
									<?php foreach ($rec_list as $recruitments) { ?>
										<option value="<?php echo $recruitments->rm_id; ?>" <?php if ($adv_list->adv_recruit_master == $recruitments->rm_id) { echo "selected"; } ?>><?php echo $recruitments->rm_name; ?></option>
									<?php } ?>
								</select>
								<small class="text-error r_for"><?php echo form_error('r_for'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Advertisement No.<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="adv_name" id="adv_name" placeholder="Enter Advertisement No." value="<?php echo $adv_list->adv_no; ?>" autocomplete="off" />
								<small class="text-error adv_name"><?php echo form_error('adv_name'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Start Date-Time<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="u_startdate" id="u_startdate" placeholder="Enter Start Date" value="<?php echo date('d-m-Y', strtotime($adv_list->adv_start_time)); ?>" autocomplete="off" />
								<small class="text-error u_startdate"><?php echo form_error('u_startdate'); ?></small>
							</div>
							<div class="col-sm-1 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" name="u_starttime" id="u_starttime" placeholder="Enter Start Time" value="<?php echo date('h:i A', strtotime($adv_list->adv_start_time)); ?>" autocomplete="off" />
								<small class="text-error u_starttime"><?php echo form_error('u_starttime'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">End Date-Time<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<input type="email" class="form-control" name="u_enddate" id="u_enddate" placeholder="Enter End Date" value="<?php echo date('d-m-Y', strtotime($adv_list->adv_end_time)); ?>" autocomplete="off" />
								<small class="text-error u_enddate"><?php echo form_error('u_enddate'); ?></small>
							</div>
							<div class="col-sm-1 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" name="u_endtime" id="u_endtime" placeholder="Enter End Time" value="<?php echo date('h:i A', strtotime($adv_list->adv_end_time)); ?>" autocomplete="off" />
								<small class="text-error u_endtime"><?php echo form_error('u_endtime'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Advertisement Type<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<select class="form-control" name="adv_typeset" id="adv_typeset" autocomplete="off" onchange="gotocheck_oldset();">
									<option value="New" <?php if ($adv_list->adv_type == "New") { echo "selected"; } ?>>New</option>
									<option value="Old" <?php if ($adv_list->adv_type == "Old") { echo "selected"; } ?>>Old</option>
								</select>
								<small class="text-error adv_typeset"><?php echo form_error('adv_typeset'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Dictation Space<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<select class="form-control" name="adv_dicta" id="adv_dicta" autocomplete="off">
									<option value="Yes" <?php if ($adv_list->adv_dictation_set == "Yes") { echo "selected"; } ?>>Yes</option>
									<option value="No" <?php if ($adv_list->adv_dictation_set == "No") { echo "selected"; } ?>>No</option>
								</select>
								<small class="text-error adv_dicta"><?php echo form_error('adv_dicta'); ?></small>
							</div>
						</div>
						<div class="form-group oldtime_set" <?php if ($adv_list->adv_type != "Old") { echo 'style="display:none;"'; } ?>>
							<label class="col-sm-3 control-label text-right">Start Date-Time<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="old_startdate" id="old_startdate" placeholder="Enter Start Date"  value="<?php if(!empty($adv_list->adv_old_starttime)){echo date('d-m-Y', strtotime($adv_list->adv_old_starttime));} ?>" autocomplete="off" />
								<small class="text-error old_startdate"><?php echo form_error('old_startdate'); ?></small>
							</div>
							<div class="col-sm-1 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" name="old_starttime" id="old_starttime" placeholder="Enter Start Time" value="<?php if(!empty($adv_list->adv_old_starttime)){echo date('h:i A', strtotime($adv_list->adv_old_starttime));} ?>" autocomplete="off" />
								<small class="text-error old_starttime"><?php echo form_error('old_starttime'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">End Date-Time<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<input type="email" class="form-control" name="old_enddate" id="old_enddate" placeholder="Enter End Date" value="<?php if(!empty($adv_list->adv_old_endtime)){echo date('d-m-Y', strtotime($adv_list->adv_old_endtime));} ?>" autocomplete="off" />
								<small class="text-error old_enddate"><?php echo form_error('old_enddate'); ?></small>
							</div>
							<div class="col-sm-1 bootstrap-timepicker">
								<input type="text" class="form-control timepicker" name="old_endtime" id="old_endtime" placeholder="Enter End Time" value="<?php if(!empty($adv_list->adv_old_endtime)){echo date('h:i A', strtotime($adv_list->adv_old_endtime));} ?>" autocomplete="off" />
								<small class="text-error old_endtime"><?php echo form_error('old_endtime'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Scale of Pay<font style="color: red;">*</font></label>
							<div class="col-sm-8">
								<textarea class="form-control" name="scale_pay" id="scale_pay" placeholder="Enter Scale of Pay" autocomplete="off"><?php echo $adv_list->adv_scale_pay; ?></textarea>
								<small class="text-error scale_pay"><?php echo form_error('scale_pay'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-10">
								<h4><u>Anticipate Vacancies</u>
									<font style="color: red;">*</font>
								</h4>
								<div class="table-responsive">
								<table width="100%" class="table">
									<thead>
										<tr>
											<th>Post</th>
											<th>Gender</th>
											<th>Marital Status</th>
											<?php foreach ($cats_list as $cats) {if($cats->caste_cat >= 1 && $cats->caste_cat <= 3){ ?>
												<th><?php echo $cats->caste_name; ?></th>
											<?php }} ?>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<select class="form-control cat_textbox" name="cat_for" id="cat_for">
													<option value="">---Select---</option>
													<?php foreach ($desp_list as $dsps) { ?>
														<option value="<?php echo $dsps->catm_id; ?>"><?php echo $dsps->catm_name; ?></option>
													<?php } ?>
												</select>
												<small class="text-error cat_for"><?php echo form_error('cat_for'); ?></small>
											</td>
											<td>
												<select class="form-control" name="gender_set" id="gender_set" multiple>
													<option value="Male">Male</option>
													<option value="Female">Female</option>
													<option value="Others">Others</option>
												</select>
												<small class="text-error gender_set"><?php echo form_error('gender_set'); ?></small>
											</td>
											<td>
												<select class="form-control" name="marital_set" id="marital_set" multiple>
													<option value="Single">Single</option>
													<option value="Married">Married</option>
													<option value="Widow">Widow</option>
													<option value="Divorced">Divorced</option>
													<option value="Separated">Separated</option>
												</select>
												<small class="text-error marital_set"><?php echo form_error('marital_set'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="un_no" id="un_no" placeholder="Enter Number" />
												<small class="text-error un_no"><?php echo form_error('un_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="un_no2" id="un_no2" placeholder="Enter Number" />
												<small class="text-error un_no2"><?php echo form_error('un_no2'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="un_no3" id="un_no3" placeholder="Enter Number" />
												<small class="text-error un_no3"><?php echo form_error('un_no3'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="un_no4" id="un_no4" placeholder="Enter Number" />
												<small class="text-error un_no4"><?php echo form_error('un_no4'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="un_no5" id="un_no5" placeholder="Enter Number" />
												<small class="text-error un_no5"><?php echo form_error('un_no5'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="sc_no" id="sc_no" placeholder="Enter Number" />
												<small class="text-error sc_no"><?php echo form_error('sc_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="st_no" id="st_no" placeholder="Enter Number" />
												<small class="text-error st_no"><?php echo form_error('st_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obc_no" id="obc_no" placeholder="Enter Number" />
												<small class="text-error obc_no"><?php echo form_error('obc_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obca_no" id="obca_no" placeholder="Enter Number" />
												<small class="text-error obca_no"><?php echo form_error('obca_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obcb_no" id="obcb_no" placeholder="Enter Number" />
												<small class="text-error obcb_no"><?php echo form_error('obcb_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="sc_no2" id="sc_no2" placeholder="Enter Number" />
												<small class="text-error sc_no2"><?php echo form_error('sc_no2'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="sc_no3" id="sc_no3" placeholder="Enter Number" />
												<small class="text-error sc_no3"><?php echo form_error('sc_no3'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="sc_no4" id="sc_no4" placeholder="Enter Number" />
												<small class="text-error sc_no4"><?php echo form_error('sc_no4'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="st_no2" id="st_no2" placeholder="Enter Number" />
												<small class="text-error st_no2"><?php echo form_error('st_no2'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="st_no3" id="st_no3" placeholder="Enter Number" />
												<small class="text-error st_no3"><?php echo form_error('st_no3'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obca_no2" id="obca_no2" placeholder="Enter Number" />
												<small class="text-error obca_no2"><?php echo form_error('obca_no2'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obca_no3" id="obca_no3" placeholder="Enter Number" />
												<small class="text-error obca_no3"><?php echo form_error('obca_no3'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obcb_no2" id="obcb_no2" placeholder="Enter Number" />
												<small class="text-error obcb_no2"><?php echo form_error('obcb_no2'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="obcb_no3" id="obcb_no3" placeholder="Enter Number" />
												<small class="text-error obcb_no3"><?php echo form_error('obcb_no3'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="pwd_no" id="pwd_no" placeholder="Enter Number" />
												<small class="text-error pwd_no"><?php echo form_error('pwd_no'); ?></small>
											</td>
											<!--<td>
												<input type="text" class="form-control cat_textbox" name="exc_no" id="exc_no" placeholder="Enter Number" />
												<small class="text-error exc_no"><?php //echo form_error('exc_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="exs_no" id="exs_no" placeholder="Enter Number" />
												<small class="text-error exs_no"><?php //echo form_error('exs_no'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control cat_textbox" name="ews_no" id="ews_no" placeholder="Enter Number" />
												<small class="text-error ews_no"><?php //echo form_error('ews_no'); ?></small>
											</td>-->
											<td>
												<a href="javascript:;" class="btn btn-primary" id="catbutton" onclick="gotosubmit_category();">ADD</a>
											</td>
										</tr>
									</tbody>
								</table>
								</div>
								<div class="table-responsive">
								<table width="100%" class="table table-bordered">
									<thead>
										<tr>
											<th>Post</th>
											<th>Gender</th>
											<th>Marital Status</th>
											<?php foreach ($cats_list as $cats) { if($cats->caste_cat >= 1 && $cats->caste_cat <= 3){ ?>
												<th><?php echo $cats->caste_name; ?></th>
											<?php }} ?>
											<th>Total</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="category_setvalue">
										<?php foreach ($cat_details as $discips) { 
											$gset = str_replace(",",", ", $discips->acat_gender_set);
											$mset = str_replace(",",", ", $discips->acat_marital_set); ?>
											<tr class="catset_<?php echo $discips->acat_id; ?>">
												<td><?php echo $discips->catm_name; ?></td>
												<td><?php echo $gset; ?></td>
												<td><?php echo $mset; ?></td>
												<td><?php echo $discips->acat_ur; ?></td>
												<td><?php echo $discips->acat_ur_ec; ?></td>
												<td><?php echo $discips->acat_ur_g_c; ?></td>
												<td><?php echo $discips->acat_ur_g_d; ?></td>
												<td><?php echo $discips->acat_ur_sp; ?></td>
												<td><?php echo $discips->acat_sc; ?></td>
												<td><?php echo $discips->acat_st; ?></td>
												<td><?php echo $discips->acat_obc; ?></td>
												<td><?php echo $discips->acat_obc_a; ?></td>
												<td><?php echo $discips->acat_obc_b; ?></td>
												<td><?php echo $discips->acat_sc_ec; ?></td>
												<td><?php echo $discips->acat_sc_g_c; ?></td>
												<td><?php echo $discips->acat_sc_g_d; ?></td>
												<td><?php echo $discips->acat_st_ec; ?></td>
												<td><?php echo $discips->acat_st_g_d; ?></td>
												<td><?php echo $discips->acat_obc_a_ec; ?></td>
												<td><?php echo $discips->acat_obc_a_g_d; ?></td>
												<td><?php echo $discips->acat_obc_b_ec; ?></td>
												<td><?php echo $discips->acat_obc_b_g_d; ?></td>
												<td><?php echo $discips->acat_pwd; ?></td>
												<!--<td><?php //echo $discips->acat_exc; ?></td>
												<td><?php //echo $discips->acat_exs; ?></td>
												<td><?php //echo $discips->acat_ews; ?></td>-->
												<td><b><?php echo $discips->acat_total; ?></b></td>
												<td><a href="javascript:;" onclick="gotodelete_cat('<?php echo $discips->acat_id; ?>');"><i class="fa fa-trash-o text-danger"></i></a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
								<div align="center">
									<div class="get_error_total5" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="get_success_total5" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total5" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Total Vacancies<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="total_vacen" id="total_vacen" placeholder="0" value="<?php echo $adv_list->adv_total_recruit; ?>" readonly autocomplete="off" />
								<small class="text-error total_vacen"><?php echo form_error('total_vacen'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Fees<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="total_fees" id="total_fees" placeholder="Enter Fee" value="<?php echo (int)$adv_list->adv_fees; ?>" autocomplete="off" />
								<small class="text-error total_fees"><?php echo form_error('total_fees'); ?></small>
							</div>

						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">First Date of DOB<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="minimum_age" id="minimum_age" placeholder="Enter Near Date of DOB" value="<?php echo date('d-m-Y', strtotime($adv_list->adv_min_age_limit)); ?>" autocomplete="off" />
								<small class="text-error minimum_age"><?php echo form_error('minimum_age'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Last Date of DOB<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="total_age" id="total_age" placeholder="Enter Long date of DOB" value="<?php echo date('d-m-Y', strtotime($adv_list->adv_age_limit)); ?>" autocomplete="off" />
								<small class="text-error total_age"><?php echo form_error('total_age'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Max Relaxation Year<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="age_relax_yr" id="age_relax_yr" placeholder="Enter Max Relaxation Year"  value="<?php echo $adv_list->adv_age_updown; ?>" autocomplete="off" />
								<small class="text-error age_relax_yr"><?php echo form_error('age_relax_yr'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">PWD Percent<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="u_pwd_percent" id="u_pwd_percent" placeholder="Enter PWD Percent" value="<?php echo $adv_list->adv_pwd_percent; ?>" autocomplete="off" />
								<small class="text-error u_pwd_percent"><?php echo form_error('u_pwd_percent'); ?></small>
							</div>
							<!--<label class="col-sm-2 control-label text-right">Payment Mode<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="u_paymode" id="u_paymode" placeholder="Enter Payment Mode" value="<?php //echo $adv_list->adv_payment_mode; ?>" autocomplete="off" />
								<small class="text-error u_paymode"><?php //echo form_error('u_paymode'); ?></small>
							</div>-->
						</div>
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-10">
								<h4><u>Fee & Age Relaxation</u>
									<font style="color: red;">*</font>
								</h4>
								<table width="100%" class="table">
									<thead>
										<tr>
											<th>Section</th>
											<th>Relation Type</th>
											<th>Relaxation Year</th>
											<th>Fee Type</th>
											<th class="partfees_cls" style="display:none;">Part Fee</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<select class="form-control" name="age_for" id="age_for">
													<option value="">---Select---</option>
													<?php foreach ($allcats_list as $cats) { ?>
														<option value="<?php echo $cats->caste_id; ?>"><?php echo $cats->caste_name; ?></option>
													<?php } ?>
												</select>
												<small class="text-error age_for"><?php echo form_error('age_for'); ?></small>
											</td>
											<td>
												<select class="form-control" name="age_type" id="age_type">
													<option value="AND">AND</option>
													<option value="OR">OR</option>
													<option value="END">END</option>
												</select>
												<small class="text-error age_type"><?php echo form_error('age_type'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control" name="age_no" id="age_no" placeholder="Enter Number" />
												<small class="text-error age_no"><?php echo form_error('age_no'); ?></small>
											</td>
											<td>
												<select class="form-control" name="fee_for" id="fee_for" onchange="goto_fees_check();">
													<option value="Full">Not Exempted</option>
													<option value="Part">Partly Exempted</option>
													<option value="No">Exempted</option>
													<option value="NA">Not Applicable</option>
												</select>
												<small class="text-error fee_for"><?php echo form_error('fee_for'); ?></small>
											</td>
											<td class="partfees_cls" style="display:none;">
												<input type="text" class="form-control" name="partfee_amt" id="partfee_amt" placeholder="Enter Amount" />
												<small class="text-error partfee_amt"><?php echo form_error('partfee_amt'); ?></small>
											</td>
											<td>
												<a href="javascript:;" class="btn btn-primary" id="age_button" onclick="gotosubmit_age_sets();">ADD</a>
											</td>
										</tr>
										<tr>
											<td colspan="5">
												<div align="center">
													<div class="get_error_total6" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="get_success_total6" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="div_roller_total6" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<table width="100%" class="table table-bordered">
									<thead>
										<tr>
											<th>Section</th>
											<th>Relaxation Type</th>
											<th>Relaxation Year</th>
											<th>Fee Type</th>
											<th>Part Fee</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="age_setvalue">
										<?php foreach ($agefee_list as $fages) { ?>
											<tr class="ageset_<?php echo $fages->advage_id; ?>">
												<td><?php echo $fages->caste_name; ?></td>
												<td><?php echo $fages->advage_type; ?></td>
												<td><?php echo $fages->advage_up; ?></td>
												<td><?php if($fages->advage_feetype == "Full"){
													echo "Not Exempted";
												}elseif($fages->advage_feetype == "Part"){
													echo "Partly Exempted";
												}elseif($fages->advage_feetype == "No"){
													echo "Exempted";
												}elseif($fages->advage_feetype == "NA"){
													echo "Not Applicable";
												} ?></td>
												<td><?php if ($fages->advage_feetype == "Part") {
														echo $fages->advage_partfee;
													} ?>
												</td>
												<td><a href="javascript:;" onclick="gotodelete_ageset('<?php echo $fages->advage_id; ?>');"><i class="fa fa-trash-o text-danger"></i></a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup about Age</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="age_writeup" id="age_writeup" placeholder="Writeup about Age" autocomplete="off"><?php echo $adv_list->adv_age_writeup; ?></textarea>
								<small class="text-error age_writeup"><?php echo form_error('age_writeup'); ?></small>
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-sm-3 control-label text-right">Gender<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<?php /*$gender_arr = explode(',', $adv_list->adv_gender_set); ?>
								<select class="form-control" name="gender_set" id="gender_set" multiple>
									<!--<option value="ALL">ALL</option>-->
									<option value="Male" <?php if(in_array("Male", $gender_arr)) { echo "selected"; } ?>>Male</option>
									<option value="Female" <?php if(in_array("Female", $gender_arr)) { echo "selected"; } ?>>Female</option>
									<option value="Others" <?php if(in_array("Others", $gender_arr)) { echo "selected"; } ?>>Others</option>
								</select>
								<small class="text-error gender_set"><?php echo form_error('gender_set');*/ ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Marital Status<font style="color: red;">*</font></label>
							<div class="col-sm-3">
								<?php /*$marital_arr = explode(',', $adv_list->adv_marital_set); ?>
								<select class="form-control" name="marital_set" id="marital_set" multiple>
									<!--<option value="ALL">ALL</option>-->
									<option value="Single" <?php if(in_array("Single", $marital_arr)) { echo "selected"; } ?>>Single</option>
									<option value="Married" <?php if(in_array("Married", $marital_arr)) { echo "selected"; } ?>>Married</option>
									<option value="Widow" <?php if(in_array("Widow", $marital_arr)) { echo "selected"; } ?>>Widow</option>
									<option value="Divorced" <?php if(in_array("Divorced", $marital_arr)) { echo "selected"; } ?>>Divorced</option>
								</select>
								<small class="text-error marital_set"><?php echo form_error('marital_set');*/ ?></small>
							</div>
						</div>-->
						<!--<div class="form-group">
							<label class="col-sm-2 control-label text-right">Has Exempted<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<div class="radio">
									<label>
										<input type="radio" name="has_examted" id="has_examted1" value="Yes" autocomplete="off" <?php if ($adv_list->adv_has_exampted == "Yes") {echo "checked";} ?>> Yes
									</label>
									&nbsp;
									<label>
										<input type="radio" name="has_examted" id="has_examted2" value="No" autocomplete="off" <?php if ($adv_list->adv_has_exampted == "No") {echo "checked";} ?>> No
									</label>
								</div>
								<small class="text-error has_examted"><?php //echo form_error('has_examted'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Has Ex-Sevice<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<div class="radio">
									<label>
										<input type="radio" name="has_ex_service" id="has_ex_service1" value="Yes" autocomplete="off" <?php if ($adv_list->adv_has_exservice == "Yes") {echo "checked";} ?>> Yes
									</label>
									&nbsp;
									<label>
										<input type="radio" name="has_ex_service" id="has_ex_service2" value="No" autocomplete="off" <?php if ($adv_list->adv_has_exservice == "No") {echo "checked";} ?>> No
									</label>
								</div>
								<small class="text-error has_ex_service"><?php //echo form_error('has_ex_service'); ?></small>
							</div>
							<label class="col-sm-2 control-label text-right">Has EWS<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<div class="radio">
									<label>
										<input type="radio" name="has_ews" id="has_ews1" value="Yes" autocomplete="off" <?php if ($adv_list->adv_has_ews == "Yes") {echo "checked";} ?>> Yes
									</label>
									&nbsp;
									<label>
										<input type="radio" name="has_ews" id="has_ews2" value="No" autocomplete="off" <?php if ($adv_list->adv_has_ews == "No") {echo "checked";} ?>> No
									</label>
								</div>
								<small class="text-error has_ews"><?php //echo form_error('has_ews'); ?></small>
							</div>
						</div>-->
						
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-10">
								<h4><u>Qualification Setup</u>
									<font style="color: red;">*</font>
								</h4>
								<div class="table-responsive">
								<table width="100%" class="table">
									<thead>
										<tr>
											<th>Qualification</th>
											<th>Type</th>
											<th>Is Final</th>
											<th>Take Pursuing</th>
											<th>Total Marks</th>
											<th>Relation Type</th>
											<th>Distribution Category</th>
											<th>&nbsp;</th>
											<th>Additional Attempt</th>
											<th class="deduction_cls deducttype_set dedslab_set" style="display:none;">&nbsp;</th>
										</tr>
									</thead>
									<tbody class="setall_qualifications">
										<tr>
											<td style="min-width:200px;">
												<select class="form-control" name="quali_name" id="quali_name" autocomplete="off">
													<option value="">---Select---</option>
													<?php foreach ($qualification_list as $qualis) { ?>
														<option value="<?php echo $qualis->qm_id; ?>"><?php echo $qualis->qm_name; ?></option>
													<?php } ?>
												</select>
												<small class="text-error quali_name"><?php echo form_error('quali_name'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="quali_type" id="quali_type" autocomplete="off">
													<option value="">---Select---</option>
													<option value="Essential">Essential</option>
													<option value="Desirable">Desirable</option>
												</select>
												<small class="text-error quali_type"><?php echo form_error('quali_type'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="quali_final_set" id="quali_final_set" autocomplete="off">
													<option value="No">No</option>
													<option value="Yes">Yes</option>
												</select>
												<small class="text-error quali_final_set"><?php echo form_error('quali_final_set'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="quali_parsuing" id="quali_parsuing" autocomplete="off">
													<option value="No">No</option>
													<option value="Yes">Yes</option>
												</select>
												<small class="text-error quali_parsuing"><?php echo form_error('quali_parsuing'); ?></small>
											</td>
											<td style="min-width:120px;">
												<input type="text" class="form-control" name="quali_fullmark" id="quali_fullmark" placeholder="Enter Full Marks" autocomplete="off" />
												<small class="text-error quali_fullmark"><?php echo form_error('quali_fullmark'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="exam_rtype" id="exam_rtype">
													<option value="AND">AND</option>
													<option value="OR">OR</option>
													<option value="END">END</option>
												</select>
												<small class="text-error exam_rtype"><?php echo form_error('exam_rtype'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="quali_category" id="quali_category" autocomplete="off" onchange="goto_qlali_cat_check();">
													<option value="Full">Full Marks</option>
													<option value="Percent">Percent Marks</option>
													<option value="Slab">Slab Marks</option>
												</select>
												<small class="text-error quali_category"><?php echo form_error('quali_category'); ?></small>
											</td>
											<td class="fullmarks_cls">&nbsp;</td>
											<td class="slavmarks_cls" style="display:none;min-width:300px;">
												<div style="padding:15px;border: #aaa 1px solid;">
													<table class="slav_tabs">
														<tr>
															<th><label>Upto Section<font style="color: red;">*</font></label></th>
															<th><label>Marks<font style="color: red;">*</font></label></th>
														</tr>
														<tr class="slav_set_1">
															<td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td>
															<td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td>
															<td>&nbsp;</td>
														</tr>
													</table>
													<div class="row">
														<div class="col-sm-2">
															<a href="javascript:;" class="btn btn-warning" id="quali_slavbutton" onclick="gotoadd_slav();">Add More</a>
														</div>
													</div>
												</div>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="attempt_type" id="attempt_type" autocomplete="off" onchange="goto_attempt_check();">
													<option value="No">Not Available</option>
													<option value="Full">Deduct Full Marks</option>
													<option value="Percent">Deduct Percent Marks</option>
													<option value="Slab">Deduct Slab Marks</option>
												</select>
												<small class="text-error attempt_type"><?php echo form_error('attempt_type'); ?></small>
											</td>
											<td class="deduction_cls" style="display:none;min-width:120px;">
												<input type="text" class="form-control" name="attempt_marks" id="attempt_marks" autocomplete="off" />
												<small class="text-error attempt_marks"><?php echo form_error('attempt_marks'); ?></small>
											</td>
											<td class="slav_deduction_cls" style="display:none;min-width:300px;">
												<div style="padding:15px;border: #aaa 1px solid;">
													<table class="deduct_slav_tabs">
														<tr>
															<th><label>Upto Section<font style="color: red;">*</font></label></th>
															<th><label>Marks<font style="color: red;">*</font></label></th>
														</tr>
														<tr class="dedslav_set_1">
															<td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td>
															<td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td>
															<td>&nbsp;</td>
														</tr>
													</table>
													<div class="row">
														<div class="col-sm-2">
															<a href="javascript:;" class="btn btn-warning" id="deduct_slavbutton" onclick="gotoadd_deduct_slav();">Add More</a>
														</div>
													</div>
												</div>
											</td>
											<td>
												<a href="javascript:;" class="btn btn-primary" id="qualibutton" onclick="gotosubmit_qualification();">ADD</a>
											</td>
										</tr>
										<tr>
											<td colspan="10">
												<div align="center">
													<div class="get_error_total7" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="get_success_total7" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="div_roller_total7" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								</div>
								<div class="table-responsive">
								<table width="100%" class="table table-bordered">
									<thead>
										<tr>
											<th>Qualification</th>
											<th>Type</th>
											<th>Is Final</th>
											<th>Take Pursuing</th>
											<th>Total Marks</th>
											<th>Relation Type</th>
											<th>Distribution Category</th>
											<th>Segregation</th>
											<th>Additional Attempt</th>
											<th>Deduct Marks</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="quali_setvalue">

										<?php foreach ($q_list as $qips) { ?>
											<tr class="qset_<?php echo $qips->aquali_id; ?>">
												<td><?php echo $qips->qm_name; ?></td>
												<td><?php echo $qips->aquali_examtype; ?></td>
												<td><?php echo $qips->aquali_finalexam; ?></td>
												<td><?php echo $qips->aquali_pursuing_chk; ?></td>
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
													<?php } ?>
												</td>
												<td><?php echo $qips->aquali_attempt; ?></td>
												<td><?php if ($qips->aquali_attempt == "Full" || $qips->aquali_attempt == "Percent") {
														echo $qips->aquali_fullpercent;
													}elseif($qips->aquali_attempt == "Slab"){ ?>
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
													<?php } ?>
												</td>
												<td><a href="javascript:;" onclick="gotodelete_quali('<?php echo $qips->aquali_id; ?>');"><i class="fa fa-trash-o text-danger"></i></a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup Essential Qualification</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="essen_writeup" id="essen_writeup" placeholder="Writeup Essential Qualification" autocomplete="off"><?php echo $adv_list->adv_essen_qualification; ?></textarea>
								<small class="text-error essen_writeup"><?php echo form_error('essen_writeup'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup Desirable Qualification</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="desir_writeup" id="desir_writeup" placeholder="Writeup Desirable Qualification" autocomplete="off"><?php echo $adv_list->adv_desir_qualification; ?></textarea>
								<small class="text-error desir_writeup"><?php echo form_error('desir_writeup'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label text-right">Has Experience<font style="color: red;">*</font></label>
							<div class="col-sm-2">
								<div class="radio">
									<label>
										<input type="radio" name="has_exp" id="has_exp1" value="Yes" autocomplete="off" onchange="check_exp();" <?php if ($adv_list->adv_has_experience == "Yes") {echo "checked";} ?>> Yes
									</label>
									&nbsp;
									<label>
										<input type="radio" name="has_exp" id="has_exp2" value="No" autocomplete="off" onchange="check_exp();" <?php if ($adv_list->adv_has_experience == "No") {echo "checked";} ?>> No
									</label>
								</div>
								<small class="text-error has_exp"><?php echo form_error('has_exp'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-10 exp_divset" <?php if($adv_list->adv_has_experience == "No"){echo 'style="display:none;"';} ?>>
								<h4><u>Experience Setup</u>
									<font style="color: red;">*</font>
								</h4>
								<div class="table-responsive">
								<table width="100%" class="table">
									<thead>
										<tr>
											<th>Exp Category</th>
											<th>Exp Type</th>
											<th>Total Marks</th>
											<th>Exp Relation</th>
											<th>Minimum Month</th>
											<th>Distribution Category</th>
										</tr>
									</thead>
									<tbody class="setall_experiences">
										<tr>
											<td style="min-width:200px;">
												<select class="form-control" name="expr_name" id="expr_name" autocomplete="off">
													<option value="">---Select---</option>
													<?php foreach($expr_list as $expss){ ?>
														<option value="<?php echo $expss->expset_id; ?>"><?php echo $expss->expset_name; ?></option>
													<?php } ?>
												</select>
												<small class="text-error expr_name"><?php echo form_error('expr_name'); ?></small>
											</td>
											<td style="min-width:150px;">
												<select class="form-control" name="expr_type" id="expr_type" autocomplete="off">
													<option value="">---Select---</option>
													<option value="Essential">Essential</option>
													<option value="Desirable">Desirable</option>
												</select>
												<small class="text-error expr_type"><?php echo form_error('expr_type'); ?></small>
											</td>
											<td style="min-width:120px;">
												<input type="text" class="form-control" name="expr_fullmark" id="expr_fullmark" placeholder="Enter Full Marks" autocomplete="off" />
												<small class="text-error expr_fullmark"><?php echo form_error('expr_fullmark'); ?></small>
											</td>
											<td style="min-width:120px;">
												<select class="form-control" name="expr_retn" id="expr_retn">
													<option value="AND">AND</option>
													<option value="OR">OR</option>
													<option value="END">END</option>
												</select>
												<small class="text-error expr_retn"><?php echo form_error('expr_retn'); ?></small>
											</td>
											<td style="min-width:120px;">
												<input type="text" class="form-control" name="expr_min_month" id="expr_min_month" placeholder="Enter Minimum Month" autocomplete="off" />
												<small class="text-error expr_min_month"><?php echo form_error('expr_min_month'); ?></small>
											</td>
											<td style="min-width:150px;">
												<select class="form-control" name="expr_category" id="expr_category" autocomplete="off" onchange="goto_expr_cat_check();">
													<option value="Full">Full Marks</option>
													<option value="Slab">Slab Marks</option>
													<small class="text-error expr_category"><?php echo form_error('expr_category'); ?></small>
											</td>
											<td class="fullexpr_cls">&nbsp;</td>
											<td class="slavexpr_cls" style="display:none;min-width:500px;">
												<div style="padding:15px;border: #aaa 1px solid;">
													<table class="slav_exprs">
														<tr>
															<th><label>Section<font style="color: red;">*</font></label></th>
															<th><label>Months<font style="color: red;">*</font></label></th>
															<th><label>Marks<font style="color: red;">*</font></label></th>
														</tr>
														<tr class="slav_expr_1">
															<td>
																<select class="form-control" name="ex_section[]" id="ex_section1" autocomplete="off">
																	<option value="UPTO">Less Than</option>
																	<option value="GT">Greater Than Equal</option>
																</select>
															</td>
															<td><input type="text" class="form-control" name="ex_months[]" id="ex_months1" autocomplete="off" /></td>
															<td><input type="text" class="form-control" name="ex_marks[]" id="ex_marks1" autocomplete="off" /></td>
															<td>&nbsp;</td>
														</tr>
													</table>
													<div class="row">
														<div class="col-sm-2">
															<a href="javascript:;" class="btn btn-warning" id="expr_slavbutton" onclick="gotoadd_expr_slav();">Add More</a>
														</div>
													</div>
												</div>
											</td>
											<td>
												<a href="javascript:;" class="btn btn-primary" id="exprbutton" onclick="gotosubmit_experience();">ADD</a>
											</td>
										</tr>
										<tr>
											<td colspan="8">
												<div align="center">
													<div class="get_error_total9" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="get_success_total9" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
													<div class="div_roller_total9" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								</div>
								<div class="table-responsive">
								<table width="100%" class="table table-bordered">
									<thead>
										<tr>
											<th>Exp Category</th>
											<th>Exp Type</th>
											<th>Total Marks</th>
											<th>Exp Relation</th>
											<th>Minimum Month</th>
											<th>Distribution Categoty</th>
											<th>Segregation</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody class="expr_setvalue">
										<?php foreach ($exp_list as $exps) { ?>
											<tr class="expset_<?php echo $exps->aexpr_id; ?>">
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
												<td><a href="javascript:;" onclick="gotodelete_expr('<?php echo $exps->aexpr_id; ?>');"><i class="fa fa-trash-o text-danger"></i></a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-10">
								<h4><u>Marks Distribution</u>
									<font style="color: red;">*</font>
								</h4>
							</div>
							<div class="col-sm-offset-2 col-sm-8">
								<table width="100%" class="table">
									<thead>
										<tr>
											<th>Academic</th>
											<th>Experience</th>
											<th>Interview</th>
											<th>Written</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input type="text" class="form-control" name="academic_marks" id="academic_marks" placeholder="Enter Academic points" value="<?php echo $adv_list->amark_academic; ?>" autocomplete="off" />
												<small class="text-error academic_marks"><?php echo form_error('academic_marks'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control" name="experience_marks" id="experience_marks" placeholder="Enter Experience points" value="<?php echo $adv_list->amark_experience; ?>" autocomplete="off" />
												<small class="text-error experience_marks"><?php echo form_error('experience_marks'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control" name="interview_marks" id="interview_marks" placeholder="Enter Interview points" value="<?php echo $adv_list->amark_interview; ?>" autocomplete="off" />
												<small class="text-error interview_marks"><?php echo form_error('interview_marks'); ?></small>
											</td>
											<td>
												<input type="text" class="form-control" name="written_marks" id="written_marks" placeholder="Enter Written points" value="<?php echo $adv_list->amark_written; ?>" autocomplete="off" />
												<small class="text-error written_marks"><?php echo form_error('written_marks'); ?></small>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup about Experience</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="marks_writeup" id="marks_writeup" placeholder="Writeup about Experience" autocomplete="off"><?php echo $adv_list->adv_marks_writeup; ?></textarea>
								<small class="text-error marks_writeup"><?php echo form_error('marks_writeup'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Current Document<font style="color: red;">*</font></label>
							<label class="col-sm-2 control-label text-left"><a href="<?php echo base_url() . 'upload_file/adv_doc/' . $adv_list->adv_source_doc; ?>" target="_blank">Attached Document</a></label>
							<label class="col-sm-3 control-label text-right">Source Document<font style="color: red;"></font></label>
							<div class="col-sm-3">
								<input type="file" class="form-control" name="advice_doc" id="advice_doc" autocomplete="off" />
								<small class="text-error advice_doc"><?php echo form_error('advice_doc'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup Miscellenius</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="miscellenius_writeup" id="miscellenius_writeup" placeholder="Writeup Miscellenius" autocomplete="off"><?php echo $adv_list->adv_miscellenius; ?></textarea>
								<small class="text-error miscellenius_writeup"><?php echo form_error('miscellenius_writeup'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label text-right">Writeup About Disabilities</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="disabality_writeup" id="disabality_writeup" placeholder="Writeup About Disabilities" autocomplete="off"><?php echo $adv_list->adv_disability; ?></textarea>
								<small class="text-error disabality_writeup"><?php echo form_error('disabality_writeup'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-center">
								<div align="center">
									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="button" onclick="gotoclclickbutton();" class="btn btn-primary gofinalsubmit">Submit</button>
								<!--&nbsp;<a href="<?php //echo site_url('admincontrol/advertisement_set/all_advertisement_list'); ?>" class="btn btn-danger">Cancel</a>-->
							</div>
						</div>
						<?php form_close(); ?>

					</div><!-- /.box-body -->
					<div class="box-footer clearfix">
						&nbsp;
					</div>
				</div><!-- /.box -->

			</section>
		</div><!-- /.row (main row) -->

	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('admin/component/footer') ?>
<script src="<?php echo base_url('bootstrap-admin/bootstrap/js/bootstrap-multiselect.js'); ?>"></script>
<script type="text/javascript">
	var slagno = 2;
	var deductno = 2;
	var slagsetno = 3;
	$(function() {
		$('.alert-error, .text-error').delay(8000).fadeOut();
		$('#u_startdate, #u_enddate, #old_startdate, #old_enddate, #minimum_age, #total_age').datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true
		});
		$(".timepicker").timepicker({
			showInputs: false,
			minuteStep: 30
		});
		$('#gender_set, #marital_set').multiselect({
			allSelectedText: 'All',
			maxHeight: 200,
      		includeSelectAllOption: true
		});
	});

	function gotocheck_oldset(){
		var adv_typeset = $('#adv_typeset option:selected').val();
		if(adv_typeset == "Old"){
			$('.oldtime_set').fadeIn();
		}else{
			$('.oldtime_set').fadeOut();
		}
	}

	function check_exp(){
		var has_exp = $("input[name='has_exp']:checked").val();
		if(has_exp == "Yes"){
            $(".exp_divset").fadeIn();
		}else{
            $(".exp_divset").fadeOut();
			$("#experience_marks").val(0);
		}
	}

	function goto_attempt_check() {
		var attempt_type = $('#attempt_type option:selected').val();
		if (attempt_type == "Full" || attempt_type == "Percent") {
			$('#attempt_marks').val('');
			deductno = 2;
			$('.deduct_slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="dedslav_set_1"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slav_deduction_cls').fadeOut();
			if (attempt_type == "Full")
				$('.deducttype_set').html('Full Marks');
			else
				$('.deducttype_set').html('Percent Marks');
			$('.deduction_cls').fadeIn();
		} else if(attempt_type == "Slab"){
			deductno = 2;
			$('#attempt_marks').val('');
			$('.deducttype_set').html('Slab Marks');
			$('.deduction_cls').fadeOut();
			$('.dedslab_set').fadeIn();
			$('.deduct_slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="dedslav_set_1"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slav_deduction_cls').fadeIn();
		} else {
			$('#attempt_marks').val('');
			$('.deducttype_set').html('&nbsp;');
			$('.deduction_cls').fadeOut();
			deductno = 2;
			$('.deduct_slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="dedslav_set_1"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slav_deduction_cls').fadeOut();
		}
	}

	function goto_fees_check() {
		var fee_for = $('#fee_for option:selected').val();
		if (fee_for == "Part") {
			$('#partfee_amt').val('');
			$('.partfees_cls').fadeIn();
		} else {
			$('#partfee_amt').val('');
			$('.partfees_cls').fadeOut();
		}
	}

	function goto_expr_cat_check() {
		var expr_category = $('#expr_category option:selected').val();
		if (expr_category == "Slab") {
			slagsetno = 3;
			$('.fullexpr_cls').fadeOut();
			$('.slav_exprs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Months<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_expr_1"><td><select class="form-control" name="ex_section[]" id="ex_section1" autocomplete="off"><option value="UPTO">Less Than</option><option value="GT">Greater Than Equal</option></select></td><td><input type="text" class="form-control" name="ex_months[]" id="ex_months1" autocomplete="off" /></td><td><input type="text" class="form-control" name="ex_marks[]" id="ex_marks1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slavexpr_cls').fadeIn();
		} else {
			slagsetno = 3;
			$('.slav_exprs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Months<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_expr_1"><td><select class="form-control" name="ex_section[]" id="ex_section1" autocomplete="off"><option value="UPTO">Less Than</option><option value="GT">Greater Than Equal</option></select></td><td><input type="text" class="form-control" name="ex_months[]" id="ex_months1" autocomplete="off" /></td><td><input type="text" class="form-control" name="ex_marks[]" id="ex_marks1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slavexpr_cls').fadeOut();
			$('.fullexpr_cls').fadeIn();
		}
	}

	function gotoadd_expr_slav() {
		var FieldCount_set1 = $('.slav_exprs').find($("input"));
		var FieldCount_set2 = $('.slav_exprs').find($("select"));
		slagsetno = FieldCount_set1.length + FieldCount_set2.length + Number(slagsetno);
		$('.slav_exprs').append('<tr class="slav_expr_' + slagsetno + '"><td><select class="form-control" name="ex_section[]" id="ex_section' + slagsetno + '" autocomplete="off">><option value="UPTO">Less Than</option><option value="GT">Greater Than Equal</option></select></td><td><input type="text" class="form-control" name="ex_months[]" id="ex_months' + slagsetno + '" autocomplete="off" /></td><td><input type="text" class="form-control" name="ex_marks[]" id="ex_marks' + slagsetno + '" autocomplete="off" /></td><td><a href="javascript:;" onclick="del_expr_spav(' + slagsetno + ');">Remove</a></td></tr>');
	}

	function del_expr_spav(slvid) {
		if (slvid != "") {
			$('.slav_expr_' + slvid).remove();
		}
	}

	function gotosubmit_experience() {
		$('.div_roller_total9').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var adv_no = $('#adv_no').val();
		var expr_name = $('#expr_name option:selected').val();
		var expr_type = $('#expr_type option:selected').val();
		var expr_min_month = $('#expr_min_month').val();
		var expr_fullmark = $('#expr_fullmark').val();
		var expr_retn = $('#expr_retn option:selected').val();
		var expr_category = $('#expr_category option:selected').val();
		var adv_prev_expr = $('#adv_prev_expr').val();
		var ex_section = $("select[name='ex_section[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var ex_months = $("input[name='ex_months[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var ex_marks = $("input[name='ex_marks[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		if (adv_no == "") {
			error_message = error_message + "<br/>ID missing, Refresh the page";
		}
		if(adv_prev_expr == "END"){
			e_error = 1;
			error_message = error_message + "<br/>Already Experience END inserted, Check Again.";
		}
		if (expr_name == "") {
			e_error = 1;
			$('.expr_name').html('Exp category is Required.');
		} else {
			if (!expr_name.match(onlynumerics)) {
				e_error = 1;
				$('.expr_name').html('Exp category only use Numeric values, Check again.');
			} else {
				$('.expr_name').html('');
			}
		}
		if (expr_type == "") {
			e_error = 1;
			$('.expr_type').html('Exp Type is Required.');
		} else {
			if (!expr_type.match(alphaletters)) {
				e_error = 1;
				$('.expr_type').html('Exp Type only use Alphabet values, Check again.');
			} else {
				$('.expr_type').html('');
			}
		}
		if (expr_retn == "") {
			e_error = 1;
			$('.expr_retn').html('Exp Relation is Required.');
		} else {
			if (!expr_retn.match(alphaletters)) {
				e_error = 1;
				$('.expr_retn').html('Exp Relation only use Alphabet values, Check again.');
			} else {
				$('.expr_retn').html('');
			}
		}
		if (expr_fullmark == "") {
			e_error = 1;
			$('.expr_fullmark').html('Total Marks is Required.');
		} else {
			if (!expr_fullmark.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.expr_fullmark').html('Total Marks only use numeric values, Check again.');
			} else if (parseFloat(expr_fullmark) < 0.00) {
				e_error = 1;
				$('.expr_fullmark').html('Total Marks always greater than or Equal 0, Check again.');
			} else {
				$('.expr_fullmark').html('');
			}
		}
		if (expr_min_month == "") {
			e_error = 1;
			$('.expr_min_month').html('Minimum Month is Required.');
		} else {
			if (!expr_min_month.match(onlynumerics)) {
				e_error = 1;
				$('.expr_min_month').html('Minimum Month only use numeric values, Check again.');
			} else {
				$('.expr_min_month').html('');
			}
		}
		if (expr_category == "") {
			e_error = 1;
			$('.expr_category').html('Distribution Categoty is Required.');
		} else {
			if (!expr_category.match(alphaletters)) {
				e_error = 1;
				$('.expr_category').html('Distribution Categoty only use Alphabets, Check again.');
			} else {
				$('.expr_category').html('');
				if (expr_category == "Slab") {
					var FieldCount_set1 = $('.slav_exprs').find($("input"));
					var FieldCount_set2 = $('.slav_exprs').find($("select"));
					var totalval = ex_section.length + ex_months.length + ex_marks.length;
					var totalvalex = FieldCount_set1.length + FieldCount_set2.length;
					if (totalval != totalvalex) {
						e_error = 1;
						error_message = error_message + "<br/>Fill-Up All Fields properly.";
					} else if ((ex_section.length != ex_months.length) || (ex_section.length != ex_marks.length) || (ex_months.length != ex_marks.length)) {
						e_error = 1;
						error_message = error_message + "<br/>Fill-Up All Fields properly.";
					} else if (parseFloat(ex_marks[ex_marks.length - 1]) != parseFloat(expr_fullmark)) {
						e_error = 1;
						error_message = error_message + "<br/>Slab Final Marks always equal to Total Marks, check again.";
					} else {
						for (var i = 0; i < ex_months.length; i++) {
							if (isNaN(ex_months[i])) {
								e_error = 1;
								error_message = error_message + "<br/>Months always use Numeric Value, check again.";
								break;
							} else if(expr_min_month > Number(ex_months[i])) {
								e_error = 1;
								error_message = error_message + "<br/>Minimum Month always lower than Slab Month, check again.";
								break;
							} else {
								if(i > 0){
									if (Number(ex_months[i]) < Number(ex_months[i - 1])) {
										e_error = 1;
										error_message = error_message + "<br/>Months always maintain Asending Numeric Value, check again.";
										break;
									}
								}
							}
						}
						for (var j = 0; j < ex_marks.length; j++) {
							if (isNaN(ex_marks[j])) {
								e_error = 1;
								error_message = error_message + "<br/>Slab Marks always use Numeric Value, check again.";
								break;
							} else {
								if(j > 0){
									if (parseFloat(ex_marks[j]) <= parseFloat(ex_marks[j - 1])) {
										e_error = 1;
										error_message = error_message + "<br/>Slab Marks always maintain Asending Numeric Value, check again.";
										break;
									}
								}
							}
						}
					}
				}
			}
		}
		if (e_error == 1) {
			$('.div_roller_total9').fadeOut();
			$('.get_error_total9').html(error_message);
			$(".get_error_total9").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total9').fadeOut();
			}, delay);
		} else {
			//alert("Reached");exit();
			var form_data = new FormData();
			form_data.append('adv_no', adv_no);
			form_data.append('expr_name', expr_name);
			form_data.append('expr_type', expr_type);
			form_data.append('expr_retn', expr_retn);
			form_data.append('expr_min_month', expr_min_month);
			form_data.append('expr_fullmark', expr_fullmark);
			form_data.append('expr_category', expr_category);
			form_data.append('ex_section', ex_section);
			form_data.append('ex_months', ex_months);
			form_data.append('ex_marks', ex_marks);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/new_experience_submission"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total9').fadeOut();
						$('.get_success_total9').html('Experience is Added Successfully.');
						$(".get_success_total9").fadeIn();
						var expr_string = '<tr class="expset_' + data.cat_set.aexpr_id + '"><td>' + data.cat_set.expset_name + '</td><td>' + data.cat_set.aexpr_type + '</td><td>' + data.cat_set.aexpr_marks + '</td><td>' + data.cat_set.aexpr_relation + '</td><td>' + data.cat_set.aexpr_min_month + '</td><td>' + data.cat_set.aexpr_category + ' Marks</td><td>';
						if (data.cat_set.aexpr_category == "Slab") {
							expr_string = expr_string + '<table class="table" style="border:1px #999 solid;"><tr><th>Section</th><th>Months</th><th>Marks</th></tr>';
							for (var k = 0; k < data.detail_set.length; k++) {
								var textwordset = '';
								if (data.detail_set[k].ae_range_words == "GT") {
									textwordset = 'Greater Than Equal';
								} else {
									textwordset = 'Less Than';
								}
								expr_string = expr_string + '<tr><td>' + textwordset + '</td><td>' + data.detail_set[k].ae_detail_month + '</td><td>' + data.detail_set[k].ae_detail_mark + '</td></tr>';
							}
							expr_string = expr_string + '</table>';
						} else {
							expr_string = expr_string + '&nbsp;';
						}
						expr_string = expr_string + '</td><td><a href="javascript:;" onclick="gotodelete_expr(' + data.cat_set.aexpr_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
						$('.expr_setvalue').append(expr_string);
						var experience_counter = $('#adv_experience').val();
						var exact_exp_counter = $('#exact_exp_counter').val();
						//auto no add
						var experience_marks = $('#experience_marks').val();
						//experience_marks = parseInt(experience_marks) + parseInt(data.cat_set.aexpr_marks);
						//$('#experience_marks').val(experience_marks);
						if(parseInt(experience_counter) > 0){
							var exp_relation = $('#adv_prev_expr').val();
							if(exp_relation == "AND"){
								experience_marks = parseFloat(experience_marks) + parseFloat(data.cat_set.aexpr_marks);
								if(data.cat_set.aexpr_type == "Essential"){
									exact_exp_counter = Number(exact_exp_counter) + 1;
								}
							}
							$('#adv_prev_expr').val(data.cat_set.aexpr_relation);
						}else{
							experience_marks = parseFloat(experience_marks) + parseFloat(data.cat_set.aexpr_marks);
							if(data.cat_set.aexpr_type == "Essential"){
								exact_exp_counter = Number(exact_exp_counter) + 1;
							}
							$('#adv_prev_expr').val(data.cat_set.aexpr_relation);
						}
						//auto no end
						$('#exact_exp_counter').val(exact_exp_counter);
						$('#experience_marks').val(experience_marks);
						experience_counter = Number(experience_counter) + 1;
						$('#adv_experience').val(experience_counter);
						$('#expr_fullmark').val('');
						$('#expr_min_month').val('');
						$('#expr_name').val('');
						$('#expr_category').val('Full');
						slagsetno = 3;
						$('.slav_exprs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Months<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_expr_1"><td><select class="form-control" name="ex_section[]" id="ex_section1" autocomplete="off"><option value="UPTO">Less Than</option><option value="GT">Greater Than Equal</option></select></td><td><input type="text" class="form-control" name="ex_months[]" id="ex_months1" autocomplete="off" /></td><td><input type="text" class="form-control" name="ex_marks[]" id="ex_marks1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
						$('.slavexpr_cls').fadeOut();
						$('.fullexpr_cls').fadeIn();
						
						/*var marks_writeup = $('#marks_writeup').val();
						var stringsetup = data.cat_set.aexpr_type + ' Experience Total marks is ' + data.cat_set.aexpr_marks +' and Minimum month is ' + data.cat_set.aexpr_min_month + ' and Distribution Type is ' + data.cat_set.aexpr_category;
						if (data.cat_set.aexpr_category == "Slab") {
							stringsetup = stringsetup + ' [ ';
							for (var k = 0; k < data.detail_set.length; k++) {
								var textwordset = '';
								if (data.detail_set[k].ae_range_words == "GT") {
									textwordset = 'Greater Than Equal';
								} else {
									textwordset = 'Less Than';
								}
								stringsetup = stringsetup + textwordset + data.detail_set[k].ae_detail_month + ' month marks is ' + data.detail_set[k].ae_detail_mark + ', ';
							}
							stringsetup = stringsetup + ' ] ';
						}
						stringsetup = stringsetup + ' AND ';
						marks_writeup = marks_writeup + stringsetup;
						$('#marks_writeup').val(marks_writeup);*/

						setTimeout(function() {
							$('.get_success_total9').fadeOut();
						}, 3000);

					} else {
						$('.div_roller_total9').fadeOut();
						//error_message = "There have some problem to Store Data, Try after some time.";
						error_message = data.e_msg;
						$('.get_error_total9').html(error_message);
						$(".get_error_total9").fadeIn();
						setTimeout(function() {
							$('.get_error_total9').fadeOut();
						}, delay);
					}

				}
			});
		}
	}

	function gotodelete_expr(exid) {
		if (exid != "") {
			var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
			if (conf_answer) {
				$('.div_roller_total9').fadeIn();
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/advertisement_set/delete_expr_update"; ?>',
					data: {
						qid: exid
					},
					dataType: 'JSON',
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total9').fadeOut();
							$('.get_success_total9').html('Experience is Deleted Successfully.');
							$(".get_success_total9").fadeIn();
							var experience_counter = $('#adv_experience').val();
							var exact_exp_counter = $('#exact_exp_counter').val();
							//auto no minus
							//var experience_marks = $('#experience_marks').val();
							//experience_marks = parseInt(experience_marks) - parseInt(data.expmarks);
							//$('#experience_marks').val(experience_marks);
							var experience_marks = $('#experience_marks').val();
							if(parseInt(experience_counter) > 1){
								if(data.prev_pos.aexpr_relation != "OR"){
									experience_marks = parseFloat(experience_marks) - parseFloat(data.expmarks.aexpr_marks);
									if(data.expmarks.aexpr_type == "Essential"){
										exact_exp_counter = Number(exact_exp_counter) - 1;
									}
								}
								$('#adv_prev_expr').val(data.prev_pos.aexpr_relation);
							}else{
								experience_marks = parseFloat(experience_marks) - parseFloat(data.expmarks.aexpr_marks);
								if(data.expmarks.aexpr_type == "Essential"){
									exact_exp_counter = Number(exact_exp_counter) - 1;
								}
								$('#adv_prev_expr').val('');
							}
							$('#experience_marks').val(experience_marks);
							//auto no minus
							experience_counter = Number(experience_counter) - 1;
							$('#adv_experience').val(experience_counter);
							$('#exact_exp_counter').val(exact_exp_counter);
							$(".expset_" + exid).remove();
							setTimeout(function() {
								$('.get_success_total9').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total9').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total9').html(error_message);
							$(".get_error_total9").fadeIn();
							setTimeout(function() {
								$('.get_error_total9').fadeOut();
							}, 3000);
						}

					}
				});
			}
		}
	}

	function goto_qlali_cat_check() {
		var quali_category = $('#quali_category option:selected').val();
		if (quali_category == "Slab") {
			slagno = 2;
			$('#percent_marks').val('');
			$('.fullmarks_cls, .percentmarks_cls').fadeOut();
			$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slavmarks_cls').fadeIn();
		} else {
			slagno = 2;
			$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('#percent_marks').val('');
			$('.percentmarks_cls, .slavmarks_cls').fadeOut();
			$('.fullmarks_cls').fadeIn();
		}
	}

	function gotoadd_deduct_slav() {
		var FieldCount_set = $('.deduct_slav_tabs').find($("input"));
		deductno = FieldCount_set.length + Number(deductno);
		$('.deduct_slav_tabs').append('<tr class="dedslav_set_' + deductno + '"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap' + deductno + '" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark' + deductno + '" autocomplete="off" /></td><td><a href="javascript:;" onclick="del_ded_slav(' + deductno + ');">Remove</a></td></tr>');
	}

	function del_ded_slav(slvid) {
		if (slvid != "") {
			$('.dedslav_set_' + slvid).remove();
		}
	}

	function gotoadd_slav() {
		var FieldCount_set = $('.slav_tabs').find($("input"));
		slagno = FieldCount_set.length + Number(slagno);
		$('.slav_tabs').append('<tr class="slav_set_' + slagno + '"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap' + slagno + '" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark' + slagno + '" autocomplete="off" /></td><td><a href="javascript:;" onclick="delspav(' + slagno + ');">Remove</a></td></tr>');
	}

	function delspav(slvid) {
		if (slvid != "") {
			$('.slav_set_' + slvid).remove();
		}
	}

	function gotosubmit_qualification() {
		$('.div_roller_total7').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var adv_no = $('#adv_no').val();
		var quali_name = $('#quali_name option:selected').val();
		var quali_type = $('#quali_type option:selected').val();
		var quali_final_set = $('#quali_final_set option:selected').val();
		var quali_parsuing = $('#quali_parsuing option:selected').val();
		var quali_fullmark = $('#quali_fullmark').val();
		var exam_rtype = $('#exam_rtype option:selected').val();
		var quali_category = $('#quali_category option:selected').val();
		var attempt_type = $('#attempt_type option:selected').val();
		var attempt_marks = $('#attempt_marks').val();
		var adv_prev_quali = $('#adv_prev_quali').val();
		var q_slap = $("input[name='q_slap[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var q_mark = $("input[name='q_mark[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var deduct_slap = $("input[name='deduct_slap[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var deduct_mark = $("input[name='deduct_mark[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		if (adv_no == "") {
			error_message = error_message + "<br/>ID missing, Refresh the page";
		}
		if(adv_prev_quali == "END"){
			e_error = 1;
			error_message = error_message + "<br/>Already Qualification END inserted, Check Again.";
		}
		if (quali_name == "") {
			e_error = 1;
			$('.quali_name').html('Qualification is Required.');
		} else {
			if (!quali_name.match(onlynumerics)) {
				e_error = 1;
				$('.quali_name').html('Qualification only use numeric values, Check again.');
			} else {
				$('.quali_name').html('');
			}
		}
		if (quali_type == "") {
			e_error = 1;
			$('.quali_type').html('Type is Required.');
		} else {
			if (!quali_type.match(alphaletters)) {
				e_error = 1;
				$('.quali_type').html('Type only use Alphabet values, Check again.');
			} else {
				$('.quali_type').html('');
			}
		}
		if (quali_final_set == "") {
			e_error = 1;
			$('.quali_final_set').html('Final Qualification is Required.');
		} else {
			if (!quali_final_set.match(alphaletters)) {
				e_error = 1;
				$('.quali_final_set').html('Final Qualification only use Alphabet values, Check again.');
			} else {
				$('.quali_final_set').html('');
			}
		}
		if (quali_parsuing == "") {
			e_error = 1;
			$('.quali_parsuing').html('Take Parsuing is Required.');
		} else {
			if (!quali_parsuing.match(alphaletters)) {
				e_error = 1;
				$('.quali_parsuing').html('Take Parsuing only use Alphabet values, Check again.');
			} else {
				$('.quali_parsuing').html('');
			}
		}
		if (quali_fullmark == "") {
			e_error = 1;
			$('.quali_fullmark').html('Total Marks is Required.');
		} else {
			if (!quali_fullmark.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.quali_fullmark').html('Total Marks only use numeric values, Check again.');
			} else if (parseFloat(quali_fullmark) < 0.00) {
				e_error = 1;
				$('.quali_fullmark').html('Total Marks always greater than or Equal 0, Check again.');
			} else {
				$('.quali_fullmark').html('');
			}
		}
		if (exam_rtype == "") {
			e_error = 1;
			$('.exam_rtype').html('Relation Type is Required.');
		} else {
			if (!exam_rtype.match(alphaletters)) {
				e_error = 1;
				$('.exam_rtype').html('Relation Type only use Alphabet values, Check again.');
			} else {
				$('.exam_rtype').html('');
			}
		}
		if (quali_category == "") {
			e_error = 1;
			$('.quali_category').html('Distribution Categoty is Required.');
		} else {
			if (!quali_category.match(alphaletters)) {
				e_error = 1;
				$('.quali_category').html('Distribution Categoty only use Alphabets, Check again.');
			} else {
				$('.quali_category').html('');
				if (quali_category == "Slab") {
					var FieldCount_set = $('.slav_tabs').find($("input"));
					var totalval = q_slap.length + q_mark.length;
					if (totalval != FieldCount_set.length) {
						e_error = 1;
						error_message = error_message + "<br/>Fill-Up All Fields properly.";
					} else if (q_slap.length != q_mark.length) {
						e_error = 1;
						error_message = error_message + "<br/>Fill-Up All Fields properly.";
					} else {
						if (q_slap[q_slap.length - 1] != 100) {
							e_error = 1;
							error_message = error_message + "<br/>Upto Section Last Value always 100, check again.";
						} else {
							for (var i = 0; i < q_slap.length; i++) {
								if (isNaN(q_slap[i])) {
									e_error = 1;
									error_message = error_message + "<br/>Upto Section always use Numeric Value, check again.";
									break;
								} else {
									if(i > 0){
										if (parseFloat(q_slap[i]) <= parseFloat(q_slap[i - 1])) {
											e_error = 1;
											error_message = error_message + "<br/>Upto Section always maintain Asending Numeric Value, check again.";
											break;
										}
									}
								}
							}
						}
						if (q_mark[q_mark.length - 1] != parseFloat(quali_fullmark)) {
							e_error = 1;
							error_message = error_message + "<br/>Slab Last Marks always equal to Total Marks of Qualification, check again.";
						} else {
							for (var j = 0; j < q_mark.length; j++) {
								if (isNaN(q_mark[j])) {
									e_error = 1;
									error_message = error_message + "<br/>Slab Marks always use Numeric Value, check again.";
									break;
								} else {
									if(j > 0){
										if (parseFloat(q_mark[j]) <= parseFloat(q_mark[j - 1])) {
											e_error = 1;
											error_message = error_message + "<br/>Slab Marks always maintain Asending Numeric Value, check again.";
											break;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if (attempt_type == "") {
			e_error = 1;
			$('.attempt_type').html('Additinal Attempt is Required.');
		} else {
			if (!attempt_type.match(alphaletters)) {
				e_error = 1;
				$('.attempt_type').html('Additinal Attempt only use Alphabets, Check again.');
			} else {
				$('.attempt_type').html('');
				if(attempt_type == "Full" || attempt_type == "Percent"){
					if (attempt_marks == "") {
						e_error = 1;
						if(attempt_type == "Full")
							$('.attempt_marks').html('Full Marks is Required.');
						else
							$('.attempt_marks').html('Percent Marks is Required.');
					} else {
						if (!attempt_marks.match(onlynumerics_withdot)) {
							e_error = 1;
							if(attempt_type == "Full")
								$('.attempt_marks').html('Full Marks only use numeric values, Check again.');
							else
								$('.attempt_marks').html('Percent Marks only use numeric values, Check again.');
							
						} else {
							$('.attempt_marks').html('');
						}
					}
				}else if(attempt_type == "Slab"){
					var FieldCount_set = $('.deduct_slav_tabs').find($("input"));
					var totalval = deduct_slap.length + deduct_mark.length;
					if (totalval != FieldCount_set.length) {
						e_error = 1;
						error_message = error_message + "<br/>Deduction Section Fill-Up All Fields properly.";
					} else if (deduct_slap.length != deduct_mark.length) {
						e_error = 1;
						error_message = error_message + "<br/>Deduction Section Fill-Up All Fields properly.";
					} else {
						for (var i = 0; i < deduct_slap.length; i++) {
							if (isNaN(deduct_slap[i])) {
								e_error = 1;
								error_message = error_message + "<br/>Deduction Section always use Numeric Value, check again.";
								break;
							} else {
								if(i > 0){
									if (parseFloat(deduct_slap[i]) <= parseFloat(deduct_slap[i - 1])) {
										e_error = 1;
										error_message = error_message + "<br/>Deduction Section always maintain Asending Numeric Value, check again.";
										break;
									}
								}
							}
						}
						if (deduct_mark[deduct_mark.length - 1] > parseFloat(quali_fullmark)) {
							e_error = 1;
							error_message = error_message + "<br/>Deduction Slab Last Marks always lower than Total Marks of Qualification, check again.";
						} else {
							for (var j = 0; j < deduct_mark.length; j++) {
								if (isNaN(deduct_mark[j])) {
									e_error = 1;
									error_message = error_message + "<br/>Deduction Marks always use Numeric Value, check again.";
									break;
								} else {
									if(j > 0){
										if (parseFloat(deduct_mark[j]) <= parseFloat(deduct_mark[j - 1])) {
											e_error = 1;
											error_message = error_message + "<br/>Deduction Marks always maintain Asending Numeric Value, check again.";
											break;
										}
									}
								}
							}
						}
					}
				}else{
					$('.attempt_marks').html('');
				}
			}
		}
		if (e_error == 1) {
			$('.div_roller_total7').fadeOut();
			$('.get_error_total7').html(error_message);
			$(".get_error_total7").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total7').fadeOut();
			}, delay);
		} else {
			var form_data = new FormData();
			form_data.append('adv_no', adv_no);
			form_data.append('quali_name', quali_name);
			form_data.append('quali_type', quali_type);
			form_data.append('quali_final_set', quali_final_set);
			form_data.append('quali_parsuing', quali_parsuing);
			form_data.append('quali_fullmark', quali_fullmark);
			form_data.append('exam_rtype', exam_rtype);
			form_data.append('quali_category', quali_category);
			form_data.append('attempt_type', attempt_type);
			form_data.append('attempt_marks', attempt_marks);
			form_data.append('q_slap', q_slap);
			form_data.append('q_mark', q_mark);
			form_data.append('deduct_slap', deduct_slap);
			form_data.append('deduct_mark', deduct_mark);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/new_qualification_submission"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total7').fadeOut();
						$('.get_success_total7').html('Qualification is Added Successfully.');
						$(".get_success_total7").fadeIn();
						var quali_string = '<tr class="qset_' + data.cat_set.aquali_id + '"><td>' + data.cat_set.qm_name + '</td><td>' + data.cat_set.aquali_examtype + '</td><td>' + data.cat_set.aquali_finalexam + '</td><td>' + data.cat_set.aquali_pursuing_chk + '</td><td>' + data.cat_set.aquali_marks + '</td><td>' + data.cat_set.aquali_relation + '</td><td>' + data.cat_set.aquali_category + ' Marks</td><td>';
						if (data.cat_set.aquali_category == "Slab") {
							quali_string = quali_string + '<table class="table" style="border:1px #999 solid;"><tr><th>Upto Section</th><th>Marks</th></tr>';
							for (var k = 0; k < data.detail_set.length; k++) {
								quali_string = quali_string + '<tr><td>' + data.detail_set[k].aq_detail_score_lvl + '</td><td>' + data.detail_set[k].aq_detail_score_mark + '</td></tr>';
							}
							quali_string = quali_string + '</table>';
						} else {
							quali_string = quali_string + '&nbsp;';
						}
						quali_string = quali_string + '</td><td>' + data.cat_set.aquali_attempt + '</td><td>';
						if (data.cat_set.aquali_attempt == "Full" || data.cat_set.aquali_attempt == "Percent") {
							quali_string = quali_string + data.cat_set.aquali_fullpercent;
						}else if(data.cat_set.aquali_attempt == "Slab"){
							quali_string = quali_string + '<table class="table" style="border:1px #999 solid;"><tr><th>Upto Section</th><th>Marks</th></tr>';
							for (var kk = 0; kk < data.deduct_set.length; kk++) {
								quali_string = quali_string + '<tr><td>' + data.deduct_set[kk].aq_deduct_lvl + '</td><td>' + data.deduct_set[kk].aq_deduct_mark + '</td></tr>';
							}
							quali_string = quali_string + '</table>';
						}else{
							quali_string = quali_string + '&nbsp;';
						}
						quali_string = quali_string + '</td><td><a href="javascript:;" onclick="gotodelete_quali(' + data.cat_set.aquali_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
						$('.quali_setvalue').append(quali_string);
						var qualification_counter = $('#adv_qualification').val();
						var adv_exact_exams = $('#adv_exact_exams').val();
						//auto no add
						var academic_marks = $('#academic_marks').val();
						if(parseInt(qualification_counter) > 0){
							var aquali_relation = $('#adv_prev_quali').val();
							if(aquali_relation == "AND"){
								academic_marks = parseFloat(academic_marks) + parseFloat(data.cat_set.aquali_marks);
								if(data.cat_set.aquali_examtype == "Essential"){
									adv_exact_exams = Number(adv_exact_exams) + 1;
								}
							}
							$('#adv_prev_quali').val(data.cat_set.aquali_relation);
						}else{
							academic_marks = parseFloat(academic_marks) + parseFloat(data.cat_set.aquali_marks);
							if(data.cat_set.aquali_examtype == "Essential"){
								adv_exact_exams = Number(adv_exact_exams) + 1;
							}
							$('#adv_prev_quali').val(data.cat_set.aquali_relation);
						}
						$('#academic_marks').val(academic_marks);
						//auto no end
						qualification_counter = Number(qualification_counter) + 1;
						$('#adv_qualification').val(qualification_counter);
						$('#adv_exact_exams').val(adv_exact_exams);
						$('#quali_fullmark').val('');
						$('#quali_name, #quali_type').val('');
						$('#quali_category').val('Full');
						$('#attempt_type').val('No');
						$('.deduction_cls').fadeOut();
						$('#attempt_marks').val('');
						slagno = 2;
						$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
						$('.slavmarks_cls').fadeOut();
						deductno = 2;
						$('.deduct_slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="dedslav_set_1"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
						$('.slav_deduction_cls').fadeOut();
						$('.fullmarks_cls').fadeIn();
						/*var essen_writeup = $('#essen_writeup').val();
						var desir_writeup = $('#desir_writeup').val();
						var essen_stringsetup = "";
						var desir_stringsetup = "";
						if(data.cat_set.aquali_examtype == "Essential"){
							essen_stringsetup = data.cat_set.qm_name + ' - Total Marks is ' + data.cat_set.aquali_marks +' and Marks Distribution is ' + data.cat_set.aquali_category;
							if(data.cat_set.aquali_category == "Slab"){
								essen_stringsetup = essen_stringsetup + ' [ ';
								for (var k = 0; k < data.detail_set.length; k++) {
									essen_stringsetup = essen_stringsetup + ' Less Than ' + data.detail_set[k].aq_detail_score_lvl + '% will get ' + data.detail_set[k].aq_detail_score_mark + ' marks, ';
								}
								essen_stringsetup = essen_stringsetup + ' ] ';
							}
							if(data.cat_set.aquali_relation != "END"){
								essen_stringsetup = essen_stringsetup + ' ' + data.cat_set.aquali_relation + ' ';
							}
							essen_writeup = essen_writeup + essen_stringsetup;
						}else{
							desir_stringsetup = data.cat_set.qm_name + ' - Total Marks is ' + data.cat_set.aquali_marks +' and Marks Distribution is ' + data.cat_set.aquali_category;
							if(data.cat_set.aquali_category == "Slab"){
								desir_stringsetup = desir_stringsetup + ' [ ';
								for (var k = 0; k < data.detail_set.length; k++) {
									desir_stringsetup = desir_stringsetup + ' Less Than ' + data.detail_set[k].aq_detail_score_lvl + '% will get ' + data.detail_set[k].aq_detail_score_mark + ' marks, ';
								}
								desir_stringsetup = desir_stringsetup + ' ] ';
							}
							if(data.cat_set.aquali_relation != "END"){
								desir_stringsetup = desir_stringsetup + ' ' + data.cat_set.aquali_relation + ' ';
							}
							desir_writeup = desir_writeup + desir_stringsetup;
						}
						$('#essen_writeup').val(essen_writeup);
						$('#desir_writeup').val(desir_writeup);*/
						setTimeout(function() {
							$('.get_success_total7').fadeOut();
						}, 3000);

					} else {
						$('.div_roller_total7').fadeOut();
						//error_message = "There have some problem to Store Data, Try after some time.";
						error_message = data.e_msg;
						$('.get_error_total7').html(error_message);
						$(".get_error_total7").fadeIn();
						setTimeout(function() {
							$('.get_error_total7').fadeOut();
						}, delay);
					}

				}
			});
		}
	}

	function gotodelete_quali(qid) {
		if (qid != "") {
			var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
			if (conf_answer) {
				$('.div_roller_total7').fadeIn();
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/advertisement_set/delete_quali_update"; ?>',
					data: {
						qid: qid
					},
					dataType: 'JSON',
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total7').fadeOut();
							$('.get_success_total7').html('Qualification is Deleted Successfully.');
							$(".get_success_total7").fadeIn();
							var qualification_counter = $('#adv_qualification').val();
							var adv_exact_exams = $('#adv_exact_exams').val();
							//auto no minus
							var academic_marks = $('#academic_marks').val();
							if(parseInt(qualification_counter) > 1){
								if(data.prev_pos.aquali_relation != "OR"){
									academic_marks = parseFloat(academic_marks) - parseFloat(data.qualimark.aquali_marks);
									if(data.qualimark.aquali_examtype == "Essential"){
										adv_exact_exams = Number(adv_exact_exams) - 1;
									}
								}
								/*if(data.qualimark.aquali_relation != "OR"){
									academic_marks = parseInt(academic_marks) - parseInt(data.qualimark.aquali_marks);
									adv_exact_exams = Number(adv_exact_exams) - 1;
								}*/
								$('#adv_prev_quali').val(data.prev_pos.aquali_relation);
							}else{
								academic_marks = parseFloat(academic_marks) - parseFloat(data.qualimark.aquali_marks);
								if(data.qualimark.aquali_examtype == "Essential"){
									adv_exact_exams = Number(adv_exact_exams) - 1;
								}
								$('#adv_prev_quali').val('');
							}
							$('#academic_marks').val(academic_marks);
							//auto no minus
							qualification_counter = Number(qualification_counter) - 1;
							$('#adv_qualification').val(qualification_counter);
							$('#adv_exact_exams').val(adv_exact_exams);
							$(".qset_" + qid).remove();
							setTimeout(function() {
								$('.get_success_total7').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total7').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total7').html(error_message);
							$(".get_error_total7").fadeIn();
							setTimeout(function() {
								$('.get_error_total7').fadeOut();
							}, 3000);
						}

					}
				});
			}
		}
	}

	function check_rec_type() {
		var r_for = $('#r_for option:selected').val();
		if (r_for != "") {
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/getcat_update"; ?>',
				data: {
					r_for: r_for
				},
				dataType: 'JSON',
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].option_set);
						$('#cat_for').html('<option value="">---Select---</option>' + data.option_set);
						$('#quali_name').html('<option value="">---Select---</option>' + data.ex_set);
						$('#cat_for, #un_no, #sc_no, #st_no, #obc_no, #obca_no, #obcb_no, #pwd_no, #exc_no, #exs_no, #ews_no').prop('disabled', false);
						$('#un_no2, #un_no3, #un_no4, #un_no5, #sc_no2, #sc_no3, #sc_no4, #st_no2, #st_no3, #obca_no2, #obca_no3, #obcb_no2, #obcb_no3').prop('disabled', false);
						$('#gender_set, #marital_set').multiselect('enable');
						$('#catbutton').attr('disabled', false);

					} else {
						$('#cat_for, #quali_name').html('<option value="">---Select---</option>');
						$('#cat_for, #un_no, #sc_no, #st_no, #obc_no, #obca_no, #obcb_no, #pwd_no, #exc_no, #exs_no, #ews_no').prop('disabled', true);
						$('#un_no2, #un_no3, #un_no4, #un_no5, #sc_no2, #sc_no3, #sc_no4, #st_no2, #st_no3, #obca_no2, #obca_no3, #obcb_no2, #obcb_no3').prop('disabled', true);
						$('#gender_set, #marital_set').multiselect('disable');
						$('#catbutton').attr("disabled", "disabled");
					}

				}
			});
		} else {
			$('#cat_for, #quali_name').html('<option value="">---Select---</option>');
			$('#cat_for, #un_no, #sc_no, #st_no, #obc_no, #obca_no, #obcb_no, #pwd_no, #exc_no, #exs_no, #ews_no').prop('disabled', true);
			$('#un_no2, #un_no3, #un_no4, #un_no5, #sc_no2, #sc_no3, #sc_no4, #st_no2, #st_no3, #obca_no2, #obca_no3, #obcb_no2, #obcb_no3').prop('disabled', true);
			$('#gender_set, #marital_set').multiselect('disable');
			$('#catbutton').attr("disabled", "disabled");
		}
	}

	function gotosubmit_category() {
		$('.div_roller_total5').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var cat_for = $('#cat_for option:selected').val();
		var adv_no = $('#adv_no').val();
		var un_no = $('#un_no').val();
		var sc_no = $('#sc_no').val();
		var st_no = $('#st_no').val();
		var obc_no = $('#obc_no').val();
		var obca_no = $('#obca_no').val();
		var obcb_no = $('#obcb_no').val();
		var pwd_no = $('#pwd_no').val();
		//var exc_no = $('#exc_no').val();
		//var exs_no = $('#exs_no').val();
		//var ews_no = $('#ews_no').val();
		var gender_set = $('#gender_set').val();
		var marital_set = $('#marital_set').val();
		var un_no2 = $('#un_no2').val();
		var un_no3 = $('#un_no3').val();
		var un_no4 = $('#un_no4').val();
		var un_no5 = $('#un_no5').val();
		var sc_no2 = $('#sc_no2').val();
		var sc_no3 = $('#sc_no3').val();
		var sc_no4 = $('#sc_no4').val();
		var st_no2 = $('#st_no2').val();
		var st_no3 = $('#st_no3').val();
		var obca_no2 = $('#obca_no2').val();
		var obca_no3 = $('#obca_no3').val();
		var obcb_no2 = $('#obcb_no2').val();
		var obcb_no3 = $('#obcb_no3').val();

		if (adv_no == "") {
			error_message = error_message + "<br/>ID missing, Refresh the page";
		}
		//////////////////////////////
		if (un_no2 == "") {
			e_error = 1;
			$('.un_no2').html('Unreserved (E.C.) is Required.');
		} else {
			if (!un_no2.match(onlynumerics)) {
				e_error = 1;
				$('.un_no2').html('Unreserved (E.C.) only use numeric values, Check again.');
			} else {
				$('.un_no2').html('');
			}
		}
		if (un_no3 == "") {
			e_error = 1;
			$('.un_no3').html('Unreserved (Ex-Serviceman in Group-C Post) is Required.');
		} else {
			if (!un_no3.match(onlynumerics)) {
				e_error = 1;
				$('.un_no3').html('Unreserved (Ex-Serviceman in Group-C Post) only use numeric values, Check again.');
			} else {
				$('.un_no3').html('');
			}
		}
		if (un_no4 == "") {
			e_error = 1;
			$('.un_no4').html('Unreserved (Ex-Serviceman in Group-D Post) is Required.');
		} else {
			if (!un_no4.match(onlynumerics)) {
				e_error = 1;
				$('.un_no4').html('Unreserved (Ex-Serviceman in Group-D Post) only use numeric values, Check again.');
			} else {
				$('.un_no4').html('');
			}
		}
		if (un_no5 == "") {
			e_error = 1;
			$('.un_no5').html('Unreserved (Meritorious Sports Person) is Required.');
		} else {
			if (!un_no5.match(onlynumerics)) {
				e_error = 1;
				$('.un_no5').html('Unreserved (Meritorious Sports Person) only use numeric values, Check again.');
			} else {
				$('.un_no5').html('');
			}
		}
		if (sc_no2 == "") {
			e_error = 1;
			$('.sc_no2').html('Scheduled Caste (E.C.) is Required.');
		} else {
			if (!sc_no2.match(onlynumerics)) {
				e_error = 1;
				$('.sc_no2').html('Scheduled Caste (E.C.) only use numeric values, Check again.');
			} else {
				$('.sc_no2').html('');
			}
		}
		if (sc_no3 == "") {
			e_error = 1;
			$('.sc_no3').html('Scheduled Caste (Ex-Serviceman in Group-C Post) is Required.');
		} else {
			if (!sc_no3.match(onlynumerics)) {
				e_error = 1;
				$('.sc_no3').html('Scheduled Caste (Ex-Serviceman in Group-C Post) only use numeric values, Check again.');
			} else {
				$('.sc_no3').html('');
			}
		}
		if (sc_no4 == "") {
			e_error = 1;
			$('.sc_no4').html('Scheduled Caste (Ex-Serviceman in Group-D Post) is Required.');
		} else {
			if (!sc_no4.match(onlynumerics)) {
				e_error = 1;
				$('.sc_no4').html('Scheduled Caste (Ex-Serviceman in Group-D Post) only use numeric values, Check again.');
			} else {
				$('.sc_no4').html('');
			}
		}
		if (st_no2 == "") {
			e_error = 1;
			$('.st_no2').html('Schedule Tribe (E.C.) is Required.');
		} else {
			if (!st_no2.match(onlynumerics)) {
				e_error = 1;
				$('.st_no2').html('Schedule Tribe (E.C.) only use numeric values, Check again.');
			} else {
				$('.st_no2').html('');
			}
		}
		if (st_no3 == "") {
			e_error = 1;
			$('.st_no3').html('Schedule Tribe (Ex-Serviceman in Group-D Post) is Required.');
		} else {
			if (!st_no3.match(onlynumerics)) {
				e_error = 1;
				$('.st_no3').html('Schedule Tribe (Ex-Serviceman in Group-D Post) only use numeric values, Check again.');
			} else {
				$('.st_no3').html('');
			}
		}
		if (obca_no2 == "") {
			e_error = 1;
			$('.obca_no2').html('OBC Category-A (E.C.) is Required.');
		} else {
			if (!obca_no2.match(onlynumerics)) {
				e_error = 1;
				$('.obca_no2').html('OBC Category-A (E.C.) only use numeric values, Check again.');
			} else {
				$('.obca_no2').html('');
			}
		}
		if (obca_no3 == "") {
			e_error = 1;
			$('.obca_no3').html('OBC Category-A (Ex-Serviceman in Group-D Post) is Required.');
		} else {
			if (!obca_no3.match(onlynumerics)) {
				e_error = 1;
				$('.obca_no3').html('OBC Category-A (Ex-Serviceman in Group-D Post) only use numeric values, Check again.');
			} else {
				$('.obca_no3').html('');
			}
		}
		if (obcb_no2 == "") {
			e_error = 1;
			$('.obcb_no2').html('OBC Category-B (E.C.) is Required.');
		} else {
			if (!obcb_no2.match(onlynumerics)) {
				e_error = 1;
				$('.obcb_no2').html('OBC Category-B (E.C.) only use numeric values, Check again.');
			} else {
				$('.obcb_no2').html('');
			}
		}
		if (obcb_no3 == "") {
			e_error = 1;
			$('.obcb_no3').html('OBC Category-B (Ex-Serviceman in Group-D Post) is Required.');
		} else {
			if (!obcb_no3.match(onlynumerics)) {
				e_error = 1;
				$('.obcb_no3').html('OBC Category-B (Ex-Serviceman in Group-D Post) only use numeric values, Check again.');
			} else {
				$('.obcb_no3').html('');
			}
		}
		//////////////////////////////
		if (cat_for == "") {
			e_error = 1;
			$('.cat_for').html('Post is Required.');
		} else {
			if (!cat_for.match(onlynumerics)) {
				e_error = 1;
				$('.cat_for').html('Post only use numeric values, Check again.');
			} else {
				$('.cat_for').html('');
			}
		}
		if (un_no == "") {
			e_error = 1;
			$('.un_no').html('Unreserved is Required.');
		} else {
			if (!un_no.match(onlynumerics)) {
				e_error = 1;
				$('.un_no').html('Unreserved only use numeric values, Check again.');
			} else {
				$('.un_no').html('');
			}
		}
		if (sc_no == "") {
			e_error = 1;
			$('.sc_no').html('Scheduled Caste is Required.');
		} else {
			if (!sc_no.match(onlynumerics)) {
				e_error = 1;
				$('.sc_no').html('Scheduled Caste only use numeric values, Check again.');
			} else {
				$('.sc_no').html('');
			}
		}
		if (st_no == "") {
			e_error = 1;
			$('.st_no').html('Scheduled Tribe is Required.');
		} else {
			if (!st_no.match(onlynumerics)) {
				e_error = 1;
				$('.st_no').html('Scheduled Tribe only use numeric values, Check again.');
			} else {
				$('.st_no').html('');
			}
		}
		if (obc_no == "") {
			e_error = 1;
			$('.obc_no').html('OBC is Required.');
		} else {
			if (!obc_no.match(onlynumerics)) {
				e_error = 1;
				$('.obc_no').html('OBC only use numeric values, Check again.');
			} else {
				$('.obc_no').html('');
			}
		}
		if (obca_no == "") {
			e_error = 1;
			$('.obca_no').html('OBC-A is Required.');
		} else {
			if (!obca_no.match(onlynumerics)) {
				e_error = 1;
				$('.obca_no').html('OBC-A only use numeric values, Check again.');
			} else {
				$('.obca_no').html('');
			}
		}
		if (obcb_no == "") {
			e_error = 1;
			$('.obcb_no').html('OBC-B is Required.');
		} else {
			if (!obcb_no.match(onlynumerics)) {
				e_error = 1;
				$('.obcb_no').html('OBC-B only use numeric values, Check again.');
			} else {
				$('.obcb_no').html('');
			}
		}
		if (pwd_no == "") {
			e_error = 1;
			$('.pwd_no').html('PWD is Required.');
		} else {
			if (!pwd_no.match(onlynumerics)) {
				e_error = 1;
				$('.pwd_no').html('PWD only use numeric values, Check again.');
			} else {
				$('.pwd_no').html('');
			}
		}
		/*if (exc_no == "") {
			e_error = 1;
			$('.exc_no').html('Exempted is Required.');
		} else {
			if (!exc_no.match(onlynumerics)) {
				e_error = 1;
				$('.exc_no').html('Exempted only use numeric values, Check again.');
			} else {
				$('.exc_no').html('');
			}
		}
		if (exs_no == "") {
			e_error = 1;
			$('.exs_no').html('Ex Service is Required.');
		} else {
			if (!exs_no.match(onlynumerics)) {
				e_error = 1;
				$('.exs_no').html('Ex Service only use numeric values, Check again.');
			} else {
				$('.exs_no').html('');
			}
		}
		if (ews_no == "") {
			e_error = 1;
			$('.ews_no').html('EWS is Required.');
		} else {
			if (!ews_no.match(onlynumerics)) {
				e_error = 1;
				$('.ews_no').html('EWS only use numeric values, Check again.');
			} else {
				$('.ews_no').html('');
			}
		}*/

		if (gender_set == null) {
			e_error = 1;
			$('.gender_set').html('Gender is Required.');
		} else {
			/*if (!gender_set.match(alphaletters)) {
				e_error = 1;
				$('.gender_set').html('Gender only use Alphabet Values, Check again.');
			} else {
				$('.gender_set').html('');
			}*/
			$('.gender_set').html('');
		}
		if (marital_set == null) {
			e_error = 1;
			$('.marital_set').html('Marital Status is Required.');
		} else {
			/*if (!marital_set.match(alphaletters)) {
				e_error = 1;
				$('.marital_set').html('Marital Status only use Alphabet Values, Check again.');
			} else {
				$('.marital_set').html('');
			}*/
			$('.marital_set').html('');
		}
		
			
		if (e_error == 1) {
			$('.div_roller_total5').fadeOut();
			$('.get_error_total5').html(error_message);
			$(".get_error_total5").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total5').fadeOut();
			}, delay);
		} else {
			var form_data = new FormData();
			form_data.append('gender_set', gender_set);
			form_data.append('marital_set', marital_set);
			form_data.append('adv_no', adv_no);
			form_data.append('cat_for', cat_for);
			form_data.append('un_no', un_no);
			form_data.append('sc_no', sc_no);
			form_data.append('st_no', st_no);
			form_data.append('obc_no', obc_no);
			form_data.append('obca_no', obca_no);
			form_data.append('obcb_no', obcb_no);
			form_data.append('pwd_no', pwd_no);
			//form_data.append('exc_no', exc_no);
			//form_data.append('exs_no', exs_no);
			//form_data.append('ews_no', ews_no);
			
			form_data.append('un_no2', un_no2);
			form_data.append('un_no3', un_no3);
			form_data.append('un_no4', un_no4);
			form_data.append('un_no5', un_no5);
			form_data.append('sc_no2', sc_no2);
			form_data.append('sc_no3', sc_no3);
			form_data.append('sc_no4', sc_no4);
			form_data.append('st_no2', st_no2);
			form_data.append('st_no3', st_no3);
			form_data.append('obca_no2', obca_no2);
			form_data.append('obca_no3', obca_no3);
			form_data.append('obcb_no2', obcb_no2);
			form_data.append('obcb_no3', obcb_no3);

			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/add_category_update"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].option_set);
						$('.div_roller_total5').fadeOut();
						$('.get_success_total5').html('Post is added Successfully.');
						$(".get_success_total5").fadeIn();
						var genStr = data.cat_set.acat_gender_set.replace(/,/g, ", ");
						var matStr = data.cat_set.acat_marital_set.replace(/,/g, ", ");
						var cat_string = '<tr class="catset_' + data.cat_set.acat_id + '"><td>' + data.cat_set.catm_name + '</td><td>' + genStr + '</td><td>' + matStr + '</td><td>' + data.cat_set.acat_ur + '</td><td>' + data.cat_set.acat_ur_ec + '</td><td>' + data.cat_set.acat_ur_g_c + '</td><td>' + data.cat_set.acat_ur_g_d + '</td><td>' + data.cat_set.acat_ur_sp + '</td><td>' + data.cat_set.acat_sc + '</td><td>' + data.cat_set.acat_st + '</td><td>' + data.cat_set.acat_obc + '</td><td>' + data.cat_set.acat_obc_a + '</td><td>' + data.cat_set.acat_obc_b + '</td><td>' + data.cat_set.acat_sc_ec + '</td><td>' + data.cat_set.acat_sc_g_c + '</td><td>' + data.cat_set.acat_sc_g_d + '</td><td>' + data.cat_set.acat_st_ec + '</td><td>' + data.cat_set.acat_st_g_d + '</td><td>' + data.cat_set.acat_obc_a_ec + '</td><td>' + data.cat_set.acat_obc_a_g_d + '</td><td>' + data.cat_set.acat_obc_b_ec + '</td><td>' + data.cat_set.acat_obc_b_g_d + '</td><td>' + data.cat_set.acat_pwd + '</td><td>' + data.cat_set.acat_total + '</td><td><a href="javascript:;" onclick="gotodelete_cat(' + data.cat_set.acat_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
						$('.category_setvalue').append(cat_string);
						var cur_value = $('#total_vacen').val();
						var category_counter = $('#adv_category').val();
						cur_value = Number(cur_value) + Number(data.cat_set.acat_total);
						category_counter = Number(category_counter) + 1;
						$('#total_vacen').val(cur_value);
						$('#adv_category').val(category_counter);
						$('#cat_for, #un_no, #sc_no, #st_no, #obc_no, #obca_no, #obcb_no, #pwd_no').val('');
						$('#un_no2, #un_no3, #un_no4, #un_no5, #sc_no2, #sc_no3, #sc_no4, #st_no2, #st_no3, #obca_no2, #obca_no3, #obcb_no2, #obcb_no3').val('');
						setTimeout(function() {
							$('.get_success_total5').fadeOut();
						}, 3000);

					} else {
						$('.div_roller_total5').fadeOut();
						//error_message = "There have some problem to Update Data, Try again.";
						error_message = data.e_msg;
						$('.get_error_total5').html(error_message);
						$(".get_error_total5").fadeIn();
						setTimeout(function() {
							$('.get_error_total5').fadeOut();
						}, delay);
					}

				}
			});
		}

	}

	function gotodelete_cat(catid) {
		if (catid != "") {
			var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
			if (conf_answer) {
				$('.div_roller_total5').fadeIn();
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/advertisement_set/delete_category_update"; ?>',
					data: {
						catid: catid
					},
					dataType: 'JSON',
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total5').fadeOut();
							$('.get_success_total5').html('Post is Deleted Successfully.');
							$(".get_success_total5").fadeIn();
							var cur_value = $('#total_vacen').val();
							var category_counter = $('#adv_category').val();
							cur_value = Number(cur_value) - Number(data.cat_set.acat_total);
							category_counter = Number(category_counter) - 1;
							$('#total_vacen').val(cur_value);
							$('#adv_category').val(category_counter);
							$(".catset_" + catid).remove();
							$('#cat_for, #un_no, #sc_no, #st_no, #obc_no, #obca_no, #obcb_no, #pwd_no').val('');
							$('#un_no2, #un_no3, #un_no4, #un_no5, #sc_no2, #sc_no3, #sc_no4, #st_no2, #st_no3, #obca_no2, #obca_no3, #obcb_no2, #obcb_no3').val('');
							setTimeout(function() {
								$('.get_success_total5').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total5').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total5').html(error_message);
							$(".get_error_total5").fadeIn();
							setTimeout(function() {
								$('.get_error_total5').fadeOut();
							}, 3000);
						}

					}
				});
			}
		}
	}

	function gotosubmit_age_sets() {
		$('.div_roller_total6').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var age_for = $('#age_for option:selected').val();
		var age_type = $('#age_type option:selected').val();
		var adv_no = $('#adv_no').val();
		var age_no = $('#age_no').val();
		var fee_for = $('#fee_for option:selected').val();
		var partfee_amt = $('#partfee_amt').val();
		var adv_prev_agetype = $('#adv_prev_agetype').val();
		if (adv_no == "") {
			error_message = error_message + "<br/>ID missing, Refresh the page";
		}
		if(adv_prev_agetype == "END"){
			e_error = 1;
			error_message = error_message + "<br/>Already Age Relaxation END inserted, Check Again.";
		}
		if (age_for == "") {
			e_error = 1;
			$('.age_for').html('Section is Required.');
		} else {
			if (!age_for.match(onlynumerics)) {
				e_error = 1;
				$('.age_for').html('Section only use numeric values, Check again.');
			} else {
				$('.age_for').html('');
			}
		}
		if (age_type == "") {
			e_error = 1;
			$('.age_type').html('Relation Type is Required.');
		} else {
			if (!age_type.match(alphaletters)) {
				e_error = 1;
				$('.age_type').html('Relation Type only use Alphabet values, Check again.');
			} else {
				$('.age_type').html('');
			}
		}
		if (age_no == "") {
			e_error = 1;
			$('.age_no').html('Number of Year is Required.');
		} else {
			if (!age_no.match(onlynumerics)) {
				e_error = 1;
				$('.age_no').html('Number of Year only use numeric values, Check again.');
			} else {
				$('.age_no').html('');
			}
		}
		if (fee_for == "") {
			e_error = 1;
			$('.fee_for').html('Fee Type is Required.');
		} else {
			if (!fee_for.match(alphaletters)) {
				e_error = 1;
				$('.fee_for').html('Fee Type only use Alphabet values, Check again.');
			} else {
				$('.fee_for').html('');
				if (fee_for == "Part") {
					if (partfee_amt == "") {
						e_error = 1;
						$('.partfee_amt').html('Part Amount is Required.');
					} else {
						if (!partfee_amt.match(onlynumerics)) {
							e_error = 1;
							$('.partfee_amt').html('Part Amount only use numeric values, Check again.');
						} else {
							$('.partfee_amt').html('');
						}
					}
				}else{
					$('.partfee_amt').html('');
				}
			}
		}
		if (e_error == 1) {
			$('.div_roller_total6').fadeOut();
			$('.get_error_total6').html(error_message);
			$(".get_error_total6").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total6').fadeOut();
			}, delay);
		} else {
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/add_ageset_update"; ?>',
				data: {
					adv_no: adv_no,
					age_for: age_for,
					age_type: age_type,
					fee_for: fee_for,
					partfee_amt: partfee_amt,
					age_no: age_no
				},
				dataType: 'JSON',
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].option_set);
						$('.div_roller_total6').fadeOut();
						$('.get_success_total6').html('Fee & Age Relaxation is added Successfully.');
						$(".get_success_total6").fadeIn();
						var age_string = '<tr class="ageset_' + data.cat_set.advage_id + '"><td>' + data.cat_set.caste_name + '</td><td>' + data.cat_set.advage_type + '</td><td>' + data.cat_set.advage_up + '</td><td>';
						if (data.cat_set.advage_feetype == "Full") {
							age_string = age_string + 'Not Exempted</td><td>' + '&nbsp;';
						}else if(data.cat_set.advage_feetype == "Part"){
							age_string = age_string + 'Partly Exempted</td><td>' + data.cat_set.advage_partfee;
						}else if(data.cat_set.advage_feetype == "No"){
							age_string = age_string + 'Exempted</td><td>' + '&nbsp;';
						}else if(data.cat_set.advage_feetype == "NA"){
							age_string = age_string + 'Not Applicable</td><td>' + '&nbsp;';
						}
						age_string = age_string + '</td><td><a href="javascript:;" onclick="gotodelete_ageset(' + data.cat_set.advage_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
						$('.age_setvalue').append(age_string);
						$('#age_for, #age_no, #partfee_amt').val('');
						$('#age_type').val('AND');
						$('#fee_for').val('Full');
						$('.partfees_cls').fadeOut();
						$('#adv_prev_agetype').val(data.cat_set.advage_type);
						var age_counter = $('#adv_agecounter').val();
						age_counter = Number(age_counter) + 1;
						$('#adv_agecounter').val(age_counter);
						/*var age_writeup = $('#age_writeup').val();
						var stringsetup = data.cat_set.caste_name + ' Candidate Relaxation Year is ' + data.cat_set.advage_up +' and Fees amount is ' + data.cat_set.advage_feetype;
						if (data.cat_set.advage_feetype == "Part") {
							stringsetup = stringsetup + '(Amount is ' + data.cat_set.advage_partfee + ')';
						}
						if(data.cat_set.advage_type != 'END'){
							stringsetup = stringsetup + ' ' + data.cat_set.advage_type + ' ';
						}
						age_writeup = age_writeup + stringsetup;
						$('#age_writeup').val(age_writeup);*/
						setTimeout(function() {
							$('.get_success_total6').fadeOut();
						}, 3000);

					} else {
						$('.div_roller_total6').fadeOut();
						//error_message = "There have some problem to Update Data, Try again.";
						error_message = data.e_msg;
						$('.get_error_total6').html(error_message);
						$(".get_error_total6").fadeIn();
						setTimeout(function() {
							$('.get_error_total6').fadeOut();
						}, delay);
					}

				}
			});
		}

	}

	function gotodelete_ageset(ageid) {
		if (ageid != "") {
			var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
			if (conf_answer) {
				$('.div_roller_total6').fadeIn();
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/advertisement_set/delete_ageset_update"; ?>',
					data: {
						ageid: ageid
					},
					dataType: 'JSON',
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total6').fadeOut();
							$('.get_success_total6').html('Fee & Age Relaxation is Deleted Successfully.');
							$(".get_success_total6").fadeIn();
							$(".ageset_" + ageid).remove();
							$('#age_for, #age_no, #partfee_amt').val('');
							$('#age_type').val('AND');
							$('#fee_for').val('Full');
							$('.partfees_cls').fadeOut();
							var age_counter = $('#adv_agecounter').val();
							if(parseInt(age_counter) > 1){
								$('#adv_prev_agetype').val(data.prev_pos.advage_type);
							}else{
								$('#adv_prev_agetype').val('');
							}
							age_counter = Number(age_counter) - 1;
							$('#adv_agecounter').val(age_counter);
							setTimeout(function() {
								$('.get_success_total6').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total6').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total6').html(error_message);
							$(".get_error_total6").fadeIn();
							setTimeout(function() {
								$('.get_error_total6').fadeOut();
							}, delay);
						}

					}
				});
			}
		}
	}

	function check_timeall(timeset) {
		var hours = Number(timeset.match(/^(\d+)/)[1]);
		var minutes = Number(timeset.match(/:(\d+)/)[1]);
		var AMPM = timeset.match(/\s(.*)$/)[1];
		if (AMPM == "PM" && hours < 12) hours = hours + 12;
		if (AMPM == "AM" && hours == 12) hours = hours - 12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if (hours < 10) sHours = "0" + sHours;
		if (minutes < 10) sMinutes = "0" + sMinutes;
		//alert(sHours + ":" + sMinutes);
		var time_all = sHours + ':' + sMinutes;
		return time_all;
	}

	function gotoclclickbutton() {
		$('.div_roller_total').fadeIn();
		$('.gofinalsubmit').attr("disabled", "disabled");
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

		var adv_no = $('#adv_no').val();
		var adv_category = $('#adv_category').val();
		var adv_qualification = $('#adv_qualification').val();
		var adv_exact_exams = $('#adv_exact_exams').val();
		var adv_experience = $('#adv_experience').val();
		var exact_exp_counter = $('#exact_exp_counter').val();
		var adv_prev_quali = $('#adv_prev_quali').val();
		var adv_prev_agetype = $('#adv_prev_agetype').val();
		var adv_prev_expr = $('#adv_prev_expr').val();
		var adv_agecounter = $('#adv_agecounter').val();
		var r_for = $('#r_for option:selected').val();
		var adv_name = $('#adv_name').val();
		var u_startdate = $('#u_startdate').val();
		var u_starttime = $('#u_starttime').val();
		var u_enddate = $('#u_enddate').val();
		var u_endtime = $('#u_endtime').val();
		var adv_typeset = $('#adv_typeset option:selected').val();
		var adv_dicta = $('#adv_dicta option:selected').val();
		var old_startdate = $('#old_startdate').val();
		var old_starttime = $('#old_starttime').val();
		var old_enddate = $('#old_enddate').val();
		var old_endtime = $('#old_endtime').val();
		var scale_pay = $('#scale_pay').val();
		var total_vacency = $('#total_vacen').val();
		var minimum_age = $('#minimum_age').val();
		var total_age = $('#total_age').val();
		var age_relax_yr = $('#age_relax_yr').val();
		var age_writeup = $('#age_writeup').val();
		var u_pwd_percent = $('#u_pwd_percent').val();
		
		//var has_examted = $("input[name='has_examted']:checked").val();
		//var has_ex_service = $("input[name='has_ex_service']:checked").val();
		//var has_ews = $("input[name='has_ews']:checked").val();
		var has_exp = $("input[name='has_exp']:checked").val();
		var total_fees = $('#total_fees').val();
		//var u_paymode = $('#u_paymode').val();
		var academic_marks = $('#academic_marks').val();
		var experience_marks = $('#experience_marks').val();
		var interview_marks = $('#interview_marks').val();
		var written_marks = $('#written_marks').val();
		var marks_writeup = $('#marks_writeup').val();
		var miscellenius_writeup = $('#miscellenius_writeup').val();
		var disabality_writeup = $('#disabality_writeup').val();
		//var exam_counter = $('input[name="exam_lvl[]"]:checked').length;
		var essen_writeup = $('#essen_writeup').val();
		var desir_writeup = $('#desir_writeup').val();
		var files = $('#advice_doc')[0].files;

		/*var exam_gen = [];
		$.each($("input[name='exam_lvl']:checked"), function(){
			exam_gen.push($(this).val());
		});
		//user_address = user_address.replace(/(\r\n|\n|\r)/gm, " ");
    	//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(exam_gen.length == 0){
			e_error = 1;
			$('.exam_lvl').html('Qualification is Required.');
		}*/
		if (adv_no == "") {
			e_error = 1;
			error_message = error_message + "<br/>ID is missing, Refresh the page";
		}
		if (Number(adv_category) === 0) {
			e_error = 1;
			error_message = error_message + "<br/>Post is missing, Enter some Discipline";
		}
		if (Number(adv_qualification) === 0) {
			e_error = 1;
			error_message = error_message + "<br/>Qualification is missing, Enter some Qualification";
		}else{
			if(adv_prev_quali != "END"){
				e_error = 1;
				error_message = error_message + "<br/>Qualification END is missing, Enter yuor END Qualification";
			}
		}
		if (Number(adv_agecounter) > 0) {
			if(adv_prev_agetype != "END"){
				e_error = 1;
				error_message = error_message + "<br/>Age Relaxation END is missing, Enter yuor END Age Relaxation";
			}
		}
		
		if (adv_name == "") {
			e_error = 1;
			$('.adv_name').html('Advertisement No. is Required.');
		} else {
			/*if (!adv_name.match(alphanumerics_no)) {
				e_error = 1;
				$('.adv_name').html('Advertisement No. not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.adv_name').html('');
			}*/
			$('.adv_name').html('');
		}

		if (r_for == "") {
			e_error = 1;
			$('.r_for').html('Recruitment For is Required.');
		} else {
			if (!r_for.match(onlynumerics)) {
				e_error = 1;
				$('.r_for').html('Recruitment For only use Numeric Values, Check again.');
			} else {
				$('.r_for').html('');
			}
		}

		if (u_startdate == "") {
			e_error = 1;
			$('.u_startdate').html('Start Date is Required.');
		} else {
			$('.u_startdate').html('');
		}
		if (u_enddate == "") {
			e_error = 1;
			$('.u_enddate').html('End Date is Required.');
		} else {
			$('.u_enddate').html('');
		}
		if (u_starttime == "") {
			e_error = 1;
			$('.u_starttime').html('Start Time is Required.');
		} else {
			$('.u_starttime').html('');
		}
		if (u_endtime == "") {
			e_error = 1;
			$('.u_endtime').html('End Time is Required.');
		} else {
			$('.u_endtime').html('');
		}

		if (u_startdate != "" && u_enddate != "" && u_starttime != "" && u_endtime != "") {
			var valuestart = check_timeall(u_starttime);
			var valuestop = check_timeall(u_endtime);
			//var task_start_date_update = task_start_date.replace(/-/g, "/");
			//var task_end_date_update = task_end_date.replace(/-/g, "/");
			var newDate = u_startdate.split("-");
			var newDateend = u_enddate.split("-");
			var task_work_date_update = newDate[2] + '-' + newDate[1] + '-' + newDate[0];
			var task_work_date_update_end = newDateend[2] + '-' + newDateend[1] + '-' + newDateend[0];
			var timediff = new Date(task_work_date_update_end + "T" + valuestop) - new Date(task_work_date_update + "T" + valuestart);
			var timediff = (timediff / 1000);
			var hourDiff = (timediff / 3600);
			var minuteDiff = (timediff - (hourDiff * 3600));
			if (hourDiff < 0) {
				e_error = 1;
				error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
			} else if (hourDiff == 0) {
				if (minuteDiff <= 0) {
					e_error = 1;
					error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
				}
			} else {
				if (minuteDiff < 0) {
					hourDiff = hourDiff - 1;
					var totalminutes = (hourDiff * 60) + (60 + minuteDiff);
				} else {
					var totalminutes = (hourDiff * 60) + minuteDiff;
				}
				//alert(totalminutes);
				if (totalminutes <= 0) {
					e_error = 1;
					error_message = error_message + '<br/>Check the total timing.';
				}
			}
		}

		if (adv_dicta == "") {
			e_error = 1;
			$('.adv_dicta').html('Dictation is Required.');
		} else {
			if (!adv_dicta.match(alphaletters)) {
				e_error = 1;
				$('.adv_dicta').html('Dictation only use Alphabet Values, Check again.');
			} else {
				$('.adv_dicta').html('');
			}
		}

		if (adv_typeset == "") {
			e_error = 1;
			$('.adv_typeset').html('Advertisement Type is Required.');
		} else {
			if (!adv_typeset.match(alphaletters)) {
				e_error = 1;
				$('.adv_typeset').html('Advertisement Type only use Alphabet Values, Check again.');
			} else {
				$('.adv_typeset').html('');
			}
		}

		if(adv_typeset == "Old"){
			if (old_startdate == "") {
				e_error = 1;
				$('.old_startdate').html('Old Start Date is Required.');
			} else {
				$('.old_startdate').html('');
			}
			if (old_enddate == "") {
				e_error = 1;
				$('.old_enddate').html('Old End Date is Required.');
			} else {
				$('.old_enddate').html('');
			}
			if (old_starttime == "") {
				e_error = 1;
				$('.old_starttime').html('Old Start Time is Required.');
			} else {
				$('.old_starttime').html('');
			}
			if (old_endtime == "") {
				e_error = 1;
				$('.old_endtime').html('Old End Time is Required.');
			} else {
				$('.old_endtime').html('');
			}
		}else{
			$('.old_startdate, .old_enddate, .old_starttime, .old_endtime').html('');
		}

		if (scale_pay == "") {
			e_error = 1;
			$('.scale_pay').html('Scale of Pay is Required.');
		} else {
			//var scale_pay1 = scale_pay.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!scale_pay1.match(alphanumerics_no)) {
				e_error = 1;
				$('.scale_pay').html('Scale of Pay not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.scale_pay').html('');
			}*/
			$('.scale_pay').html('');
		}
		if (total_vacency == "") {
			e_error = 1;
			$('.total_vacen').html('Total Vacency is Required.');
		} else {
			if (!total_vacency.match(onlynumerics)) {
				e_error = 1;
				$('.total_vacen').html('Total Vacency only use Numeric Values, Check again.');
			} else {
				$('.total_vacen').html('');
			}
		}
		if (minimum_age == "") {
			e_error = 1;
			$('.minimum_age').html('Minimum DOB is Required.');
		} else {
			if(isDatecheck(minimum_age) == false){
				e_error = 1;
				$('.minimum_age').html('Minimum DOB Format check properly and Try Again.');
			} else {
				$('.minimum_age').html('');
			}
		}
		if (total_age == "") {
			e_error = 1;
			$('.total_age').html('Maximum DOB is Required.');
		} else {
			if(isDatecheck(total_age) == false){
				e_error = 1;
				$('.total_age').html('Maximum DOB Format check properly and Try Again.');
			} else {
				$('.total_age').html('');
			}
		}
		if (age_relax_yr == "") {
			e_error = 1;
			$('.age_relax_yr').html('Max Relaxation Year is Required.');
		} else {
			if (!age_relax_yr.match(onlynumerics)) {
				e_error = 1;
				$('.age_relax_yr').html('Max Relaxation Year only use Numeric Values, Check again.');
			} else {
				$('.age_relax_yr').html('');
			}
		}

		if (u_pwd_percent == "") {
			e_error = 1;
			$('.u_pwd_percent').html('PWD Percentage is Required.');
		} else {
			if (!u_pwd_percent.match(onlynumerics)) {
				e_error = 1;
				$('.u_pwd_percent').html('PWD Percentage only use Numeric Values, Check again.');
			} else {
				$('.u_pwd_percent').html('');
			}
		}

		if (age_writeup != "") {
			//var age_writeup1 = age_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!age_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.age_writeup').html('Writeup about Age not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.age_writeup').html('');
			}*/
			$('.age_writeup').html('');
		}

		/*if (has_examted == "" || has_examted == undefined) {
			e_error = 1;
			$('.has_examted').html('Has Exempted is Required.');
		} else {
			if (!has_examted.match(alphaletters)) {
				e_error = 1;
				$('.has_examted').html('Has Exempted only Alphabet value, Check again.');
			} else {
				$('.has_examted').html('');
			}
		}
		if (has_ex_service == "" || has_ex_service == undefined) {
			e_error = 1;
			$('.has_ex_service').html('Has Ex Service is Required.');
		} else {
			if (!has_ex_service.match(alphaletters)) {
				e_error = 1;
				$('.has_ex_service').html('Has Ex Service only Alphabet value, Check again.');
			} else {
				$('.has_ex_service').html('');
			}
		}
		if (has_ews == "" || has_ews == undefined) {
			e_error = 1;
			$('.has_ews').html('Has EWS is Required.');
		} else {
			if (!has_ews.match(alphaletters)) {
				e_error = 1;
				$('.has_ews').html('Has EWS only Alphabet value, Check again.');
			} else {
				$('.has_ews').html('');
			}
		}*/
		if (has_exp == "" || has_exp == undefined) {
			e_error = 1;
			$('.has_exp').html('Has Experience is Required.');
		} else {
			if (!has_exp.match(alphaletters)) {
				e_error = 1;
				$('.has_exp').html('Has Experience only Alphabet value, Check again.');
			} else {
				$('.has_exp').html('');
				if (has_exp == "Yes") {
					if (Number(adv_experience) === 0) {
						e_error = 1;
						error_message = error_message + "<br/>Experience is missing, Enter some Experience";
					}else{
						if(adv_prev_expr != "END"){
							e_error = 1;
							error_message = error_message + "<br/>Experience END is missing, Enter yuor END Experience";
						}
					}
				}else if(has_exp == "No"){
					if (Number(experience_marks) != 0) {
						e_error = 1;
						error_message = error_message + "<br/>Experience Marks should be 0, check again.";
					}
				}
			}
		}
		if (total_fees == "") {
			e_error = 1;
			$('.total_fees').html('Total Fees is Required.');
		} else {
			if (!total_fees.match(onlynumerics)) {
				e_error = 1;
				$('.total_fees').html('Total Fees only use Numeric Values, Check again.');
			} else {
				$('.total_fees').html('');
			}
		}

		/*if (u_paymode == "") {
			e_error = 1;
			$('.u_paymode').html('Payment Mode is Required.');
		} else {
			if (!u_paymode.match(alphanumerics_no)) {
				e_error = 1;
				$('.u_paymode').html('Payment Mode not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.u_paymode').html('');
			}
		}*/
		if (essen_writeup != "") {
			//var essen_writeup1 = essen_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!essen_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.essen_writeup').html('Writeup Essential Qualification not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.essen_writeup').html('');
			}*/
			$('.essen_writeup').html('');
		}
		if (desir_writeup != "") {
			//var desir_writeup1 = desir_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!desir_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.desir_writeup').html('Writeup Desirable Qualification not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.desir_writeup').html('');
			}*/
			$('.desir_writeup').html('');
		}
		if (academic_marks == "") {
			e_error = 1;
			$('.academic_marks').html('Academic Marks is Required.');
		} else {
			if (!academic_marks.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.academic_marks').html('Academic Marks only use Numeric Values, Check again.');
			} else {
				$('.academic_marks').html('');
			}
		}
		if (experience_marks == "") {
			e_error = 1;
			$('.experience_marks').html('Experience Marks is Required.');
		} else {
			if (!experience_marks.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.experience_marks').html('Experience Marks only use Numeric Values, Check again.');
			} else {
				$('.experience_marks').html('');
			}
		}
		if (interview_marks == "") {
			e_error = 1;
			$('.interview_marks').html('Interview Marks is Required.');
		} else {
			if (!interview_marks.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.interview_marks').html('Interview Marks only use Numeric Values, Check again.');
			} else {
				$('.interview_marks').html('');
			}
		}
		if (written_marks == "") {
			e_error = 1;
			$('.written_marks').html('Written Marks is Required.');
		} else {
			if (!written_marks.match(onlynumerics_withdot)) {
				e_error = 1;
				$('.written_marks').html('Written Marks only use Numeric Values, Check again.');
			} else {
				$('.written_marks').html('');
			}
		}
		if (marks_writeup != "") {
			//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!marks_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.marks_writeup').html('');
			}*/
			$('.marks_writeup').html('');
		}
		if (miscellenius_writeup != "") {
			//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!marks_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.marks_writeup').html('');
			}*/
			$('.miscellenius_writeup').html('');
		}
		if (disabality_writeup != "") {
			//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
			/*if (!marks_writeup1.match(alphanumerics_no)) {
				e_error = 1;
				$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
			} else {
				$('.marks_writeup').html('');
			}*/
			$('.disabality_writeup').html('');
		}
		if (document.getElementById("advice_doc").files.length != 0) {
			var fileInput = document.getElementById('advice_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.advice_doc').html('Source File type Invalid.(Use PDF/JPG)');
			} else {
				$('.advice_doc').html('');
			}
		}

		/*if (u_startdate != "") {
			cur_date = '<?php //echo date("d-m-Y"); ?>';
			cur_set_date = cur_date.split('-');
			start_set_date = u_startdate.split('-');
			
			var new_start_date = new Date(start_set_date[2],(parseInt(start_set_date[1]) - 1),start_set_date[0]);
			var cur_new_date = new Date(cur_set_date[2],(parseInt(cur_set_date[1]) - 1),cur_set_date[0]);
			
			if(cur_new_date >= new_start_date){
				e_error = 1;
				error_message = error_message + '<br/>Problem in Advertisement Start Date, Check Again.';
			}
		}*/

		if (minimum_age != "" && total_age != "") {
			cur_date = '<?php echo date("d-m-Y"); ?>';
			cur_dob_date = cur_date.split('-');
			start_dob_date = minimum_age.split('-');
			end_dob_date = total_age.split('-');

			var new_start_date = new Date(start_dob_date[2],(parseInt(start_dob_date[1]) - 1),start_dob_date[0]);
			var new_end_date = new Date(end_dob_date[2],(parseInt(end_dob_date[1]) - 1),end_dob_date[0]);
			var cur_new_date = new Date(cur_dob_date[2],(parseInt(cur_dob_date[1]) - 1),cur_dob_date[0]);
			
			if(new_end_date >= new_start_date) {
				e_error = 1;
				error_message = error_message + '<br/>Problem in DOB Dates, Check Again.';
			}else if(new_start_date >= cur_new_date){
				e_error = 1;
				error_message = error_message + '<br/>Problem in DOB Minimum Date, Check Again.';
			}
		}

		if(academic_marks != "" && experience_marks != "" && interview_marks != "" && written_marks != ""){
			if(!isNaN(academic_marks) && !isNaN(experience_marks) && !isNaN(interview_marks) && !isNaN(written_marks)){
				var totalmarks = 0.00;
				totalmarks = parseFloat(academic_marks) + parseFloat(experience_marks) + parseFloat(interview_marks) + parseFloat(written_marks);
				if(totalmarks != 100.00){
					e_error = 1;
					error_message = error_message + '<br/>Marks Districution need to set always 100, Check Again.';
				}
			}
		}
		//return false;
		//alert(salts);
		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} else {
			//alert(newhash);
			//alert(rehash);
			//$("#myForm").submit();
			var conf_answer = confirm("Are you sure you want to Update the Data for the Advertisement?")
			if (conf_answer) {
				var form_data = new FormData();
				//form_data.append('exam_gen',exam_gen);
				form_data.append('adv_no', adv_no);
				form_data.append('adv_category', adv_category);
				form_data.append('adv_qualification', adv_exact_exams);
				form_data.append('adv_experience', exact_exp_counter);
				form_data.append('r_for', r_for);
				form_data.append('adv_name', adv_name);
				form_data.append('u_startdate', u_startdate);
				form_data.append('u_starttime', u_starttime);
				form_data.append('u_enddate', u_enddate);
				form_data.append('u_endtime', u_endtime);
				form_data.append('adv_dicta', adv_dicta);
				form_data.append('adv_typeset', adv_typeset);
				form_data.append('old_startdate', old_startdate);
				form_data.append('old_starttime', old_starttime);
				form_data.append('old_enddate', old_enddate);
				form_data.append('old_endtime', old_endtime);
				form_data.append('scale_pay', scale_pay);
				form_data.append('total_vacency', total_vacency);
				form_data.append('minimum_age', minimum_age);
				form_data.append('total_age', total_age);
				form_data.append('age_relax_yr', age_relax_yr);
				form_data.append('age_writeup', age_writeup);
				//form_data.append('has_examted', has_examted);
				//form_data.append('has_ex_service', has_ex_service);
				//form_data.append('has_ews', has_ews);
				form_data.append('has_exp', has_exp);
				form_data.append('total_fees', total_fees);
				form_data.append('u_pwd_percent', u_pwd_percent);
				//form_data.append('u_paymode', u_paymode);
				form_data.append('academic_marks', academic_marks);
				form_data.append('experience_marks', experience_marks);
				form_data.append('interview_marks', interview_marks);
				form_data.append('written_marks', written_marks);
				form_data.append('marks_writeup', marks_writeup);
				form_data.append('miscellenius_writeup', miscellenius_writeup);
				form_data.append('disabality_writeup', disabality_writeup);
				form_data.append('essen_writeup', essen_writeup);
				form_data.append('desir_writeup', desir_writeup);
				form_data.append("files", files[0]);
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/advertisement_set/update_advertisement_submission"; ?>',
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
							$('.get_success_total').html('Advertisement is Updated Successfully.');
							$(".get_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/advertisement_set/all_advertisement_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total').fadeOut();
							$('.gofinalsubmit').attr("disabled", false);
							error_message = "There have some problem to Store Data, Try after some time.";
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
				$('.gofinalsubmit').attr("disabled", false);
			}
		}

	}

	function isDatecheck(txtDate)
	{
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

</script>