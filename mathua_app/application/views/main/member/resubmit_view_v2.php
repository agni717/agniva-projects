<?php $this->load->view('main/component/login_header') ?>



<style>
	.alert-error,
	.text-error,
	.redclass {

		color: red !important;

	}

	.box3 {
		border: 1px solid #4db2ff;
	}
</style>

<?php $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>

<!-- Presentation -->

<div class="container mt-3">

	<div class="row">

		<div class="col-sm-12" style="margin:30px 0;">

			<h3>Your Registration No. - <?php echo $fuser_detailset->f_application_no; ?></h3>

			<h5>Your Re-Submission Form Details -</h5>
			<h4 style="color:red;text-align:center;">*** Please Submit Each Section Individually ***</h4>
			<?php //echo "<pre>";print_r($rejection_list); ?>
			<div class="row">
				<div class="col-sm-12"> <strong>Applied For :</strong> <?php echo $adv_detail->adv_no . ' | Recrutment For - ' . $adv_detail->rm_name; ?></div>
				<div class="col-sm-12"><strong>Full Name :</strong> <?php echo $fuser_detailset->f_full_name; ?></div>

				<div class="col-sm-4"><strong>Mobile No : </strong><?php echo $fuser_detailset->f_mobile; ?></div>
				<div class="col-sm-4"><strong>Email : </strong><?php echo $fuser_detailset->f_email; ?></div>

				<div class="col-sm-4"><strong>Discipline : </strong> <?php echo $adv_category->catm_name; ?></div>
			</div>		

			
			<?php $rejection_arr = $reject_type_arr = array();
			$age1_arr = $es_quali_arr = $ds_quali_arr = $es_serv_arr = $ds_serv_arr = array();
			foreach($rejection_list as $reject_items){
				$rejection_arr[] = array(
					'chk_type' => $reject_items->chk_type,
					'chk_sub_typeid' => $reject_items->chk_sub_typeid
				);
				if(!in_array($reject_items->chk_type, $reject_type_arr)){
					$reject_type_arr[] = $reject_items->chk_type;
				}
				if($reject_items->chk_type == "fu_age_relax"){
					$age1_arr[] = $reject_items->chk_sub_typeid;
				}elseif($reject_items->chk_type == "fu_es_qualification"){
					$es_quali_arr[] = $reject_items->chk_sub_typeid;
				}elseif($reject_items->chk_type == "fu_ds_qualification"){
					$ds_quali_arr[] = $reject_items->chk_sub_typeid;
				}elseif($reject_items->chk_type == "fu_has_es_service"){
					$es_serv_arr[] = $reject_items->chk_sub_typeid;
				}elseif($reject_items->chk_type == "fu_has_ds_service"){
					$ds_serv_arr[] = $reject_items->chk_sub_typeid;
				}
			} 
			//print_r($reject_type_arr); ?>

		</div>

	</div>



	<div class="step-app" id="demo">

		<ul class="step-steps">
			<?php if(in_array("fu_address", $reject_type_arr)){ ?>
			<li data-step-target="step1">Address</li>
			<?php }
			if(in_array("fu_photo_doc", $reject_type_arr)){ ?>
			<li data-step-target="step2">Photo</li>
			<?php }
			if(in_array("fu_signature_doc", $reject_type_arr)){ ?>
			<li data-step-target="step3">Signature</li>
			<?php }
			if(in_array("fu_caste", $reject_type_arr)){ ?>
			<li data-step-target="step4">Caste</li>
			<?php }
			if(in_array("fu_pwd", $reject_type_arr)){ ?>
			<li data-step-target="step5">PWD</li>
			<?php }
			if(in_array("fu_age_relax", $reject_type_arr)){ ?>
			<li data-step-target="step6">Age Relaxation</li>
			<?php }
			if(in_array("fu_es_qualification", $reject_type_arr)){ ?>
			<li data-step-target="step7">Ess. Qualification</li>
			<?php }
			if(in_array("fu_ds_qualification", $reject_type_arr)){ ?>
			<li data-step-target="step8">Des. Qualification</li>
			<?php }
			if(in_array("fu_has_es_service", $reject_type_arr)){ ?>
			<li data-step-target="step9">Ess. Service</li>
			<?php }
			if(in_array("fu_has_ds_service", $reject_type_arr)){ ?>
			<li data-step-target="step10">Des. Service</li>
			<?php }
			if(in_array("fu_exempted", $reject_type_arr)){ ?>
				<li data-step-target="step11">Exempted Category</li>
			<?php }
			if(in_array("fu_exservice", $reject_type_arr)){ ?>
				<li data-step-target="step12">Ex Serviceman Category</li>
			<?php }
			if(in_array("fu_ews", $reject_type_arr)){ ?>
				<li data-step-target="step13">Sports Man Category</li>
			<?php }
			if(in_array("fu_dob", $reject_type_arr)){ ?>
			<li data-step-target="step14">DOB</li>
			<?php } ?>
		</ul>
		<div class="step-content">

		<?php if(in_array("fu_address", $reject_type_arr)){ ?>
			<div class="step-tab-panel" data-step="step1">

				<?php if(in_array("fu_address", $reject_type_arr)){ ?>

					<div class="row">
						<div class="col-sm-12 mt-2">
							<div class="box3">
								<div class="col-sm-12">
									<strong>Present Address</strong>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="row p-2">
											<div class="col-sm-3 pl-4">State :</div>
											<div class="col-sm-9">

												<select name="fu_state" class="form-control" id="exampleFormControlSelect1">


													<option value="">---Select---</option>

													<?php foreach ($state_list as $states) { ?>

														<option value="<?php echo $states->state_id; ?>" <?php if ($states->state_id == $fuser_detailset->fu_state) {echo "selected";} ?>><?php echo $states->state_name; ?></option>

													<?php } ?>


												</select>
												<small class="text-error fu_state"><?php echo form_error('fu_state'); ?></small>
											</div>

										</div>

										<!-- ---------------------------- SUB DIVISION BLOCK ------------------------- -->
										<div class="fu-sub-division-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state != 28 && $fuser_detailset->fu_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-3 pl-4">Sub-Division :</div>
											<div class="col-sm-9">

												<select name="fu_sub_division" class="form-control" id="exampleFormControlSelect1" <?php if ($fuser_detailset->fu_district == NULL) echo "disabled"; ?>>


													<option value="">---Select---</option>
													<?php if ($fuser_detailset->fu_district != NULL) { ?>
														<?php foreach ($sub_division as $sd) { ?>

															<option value="<?= $sd->subdiv_id ?>" <?php if ($fuser_detailset->fu_sub_division == $sd->subdiv_id) echo "selected"; ?>><?= $sd->subdiv_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small class="text-error fu_sub_division"><?php echo form_error('fu_sub_division'); ?></small>
											</div>
										</div>
										<div class="fu-other-sub-division-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state == 28 || $fuser_detailset->fu_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">Sub-Division :</div>
											<div class="col-sm-9">
												<input class="form-control" type="text" name="fu_other_sdiv" value="<?= $fuser_detailset->fu_other_sdiv ?>">
												<small class="text-error fu_other_sdiv"><?php echo form_error('fu_other_sdiv'); ?></small>
											</div>
										</div>

										<!-- ---------------------------- POLICE STATION BLOCK ------------------------- -->
										<div class="fu-police-station-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state != 28 && $fuser_detailset->fu_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-3 pl-4">PoliceStation :</div>
											<div class="col-sm-9">
												<select class="form-control" name="fu_police_station" id="exampleFormControlSelect1" <?php if ($fuser_detailset->fu_district == NULL) echo "disabled"; ?>>
													<option value="">---Select---</option>
													<?php if ($fuser_detailset->fu_district != NULL) { ?>
														<?php foreach ($police_station as $ps) { ?>

															<option value="<?= $ps->ps_id ?>" <?php if ($fuser_detailset->fu_police_station == $ps->ps_id) echo "selected"; ?>><?= $ps->ps_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small>(Select police station as per your address proof document)</small>
												<small class="text-error fu_police_station"><?php echo form_error('fu_police_station'); ?></small>
											</div>
										</div>
										<div class="fu-other-police-station-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state == 28 || $fuser_detailset->fu_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">PoliceStation :</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="fu_other_ps" value="<?= $fuser_detailset->fu_other_ps ?>" />
												<small>(Select police station as per your address proof document)</small>
												<small class="text-error fu_other_ps"><?php echo form_error('fu_other_ps'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Vill / Para / House No / Road :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_house_road" value="<?= $fuser_detailset->fu_house_road ?>" class="form-control" />
												<small class="text-error fu_house_road"><?php echo form_error('fu_house_road'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Pin Code :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_pincode" value="<?= $fuser_detailset->fu_pincode ?>" class="form-control" />
												<small class="text-error fu_pincode"><?php echo form_error('fu_pincode'); ?></small>
											</div>
										</div>
									</div>

									<div class="col-sm-6">

										<!-- ---------------------------- DSITRICT BLOCK ------------------------- -->
										<div class="fu-district-div row p-2" <?php if ($fuser_detailset->fu_state != 28 && $fuser_detailset->fu_state != NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">District :</div>


											<div class="col-sm-9">

												<select class="form-control" name="fu_district" id="fu_district" autocomplete="off" <?php if ($fuser_detailset->fu_state == NULL) {echo "disabled";} ?>>


													<option value="">---Select---</option>

													<?php foreach ($dist_list as $dists) { ?>

														<option value="<?php echo $dists->district_code; ?>" <?php if ($dists->district_code == $fuser_detailset->fu_district) {
																													echo "selected";
																												} ?>><?php echo $dists->district_name; ?></option>

													<?php } ?>

												</select>

												<small class="text-error fu_district"><?php echo form_error('fu_district'); ?></small>

											</div>




										</div>
										<div class="fu-other-district-div row p-2" <?php if ($fuser_detailset->fu_state == 28 || $fuser_detailset->fu_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">District :</div>


											<div class="col-sm-9">

												<input class="form-control" type="text" name="fu_other_district" value="<?= $fuser_detailset->fu_other_district ?>" />

												<small class="text-error fu_district"><?php echo form_error('fu_district'); ?></small>

											</div>




										</div>
										<!-- ---------------------------- BLOCK MUNICIPALITY BLOCK ------------------------- -->
										<div class="fu-block-municipality-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state != 28 && $fuser_detailset->fu_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-4 pl-5">

												<input type="radio" name="fu_mb_type" class="form-check-input" id="exampleCheck1" <?php if ($fuser_detailset->fu_sub_division == NULL) echo "disabled"; ?> <?php if ($fuser_detailset->fu_sub_division != NULL && $fuser_detailset->fu_mb_type != NULL) {
																																																													if ($mb_type == "Municipality") echo "checked";
																																																												} ?> value="Municipality"> Municipality
											</div>

											<div class="col-sm-4">

												<input type="radio" name="fu_mb_type" class="form-check-input" id="exampleCheck1" <?php if ($fuser_detailset->fu_sub_division == NULL) echo "disabled"; ?> <?php if ($fuser_detailset->fu_sub_division != NULL && $fuser_detailset->fu_mb_type != NULL) {
																																																													if ($mb_type == "Block") echo "checked";
																																																												} ?> value="Block"> Block
												<br>
												<small class="text-error fu_mb_type"><?php echo form_error('fu_mb_type'); ?></small>
											</div>

											<div class="col-sm-4">

												<select class="form-control" name="fu_block_municipality" id="exampleFormControlSelect1">

													<option value="">---Select---</option>

													<?php if (isset($block_municipality) && !empty($block_municipality)) { ?>
														<?php foreach ($block_municipality as $bm) { ?>

															<option value="<?= $bm->block_id ?>" <?php if ($bm->block_id == $fuser_detailset->fu_block_municipality) echo "selected" ?>><?= $bm->block_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small class="text-error fu_block_municipality"><?php echo form_error('fu_block_municipality'); ?></small>
											</div>
										</div>
										<div class="fu-other-block-municipality-div row p-2 mt-2" <?php if ($fuser_detailset->fu_state == 28 || $fuser_detailset->fu_state == NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-4">
												Block/ Municipality
											</div>
											<div class="col-sm-4">
												<input class="form-control" name="fu_other_blockm" value="<?= $fuser_detailset->fu_other_blockm ?>" />
												<small class="text-error fu_other_blockm"><?php echo form_error('fu_other_blockm'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Ward/GP :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_ward_gp" value="<?= $fuser_detailset->fu_ward_gp ?>" class="form-control" />
												<small class="text-error fu_ward_gp"><?php echo form_error('fu_ward_gp'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Post Office :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_post_office" value="<?= $fuser_detailset->fu_post_office ?>" class="form-control" />

												<small class="text-error fu_post_office"><?php echo form_error('fu_post_office'); ?></small>
											</div>
										</div>
										<!--<div class="row p-2 mt-2">
										<div class="col-sm-3 pl-4">Address :</div>
									<div class="col-sm-9"> 
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
										</div>
										</div>-->
									</div>

								</div>



							</div>
						</div>
					</div>

					<div class="row mt-3">

						<div class="col-sm-1"><input type="checkbox" class="form-control" name="all_same_address" id="all_same_address" <?php if(!empty($fuser_detailset->fu_same_address)){if($fuser_detailset->fu_same_address == "Yes"){echo "checked";}}else{echo "checked";} ?>  onchange="address_tick_check();" />
						</div>

						<div class="col-sm-5">Permanent Address is same as Present Address

							<small class="text-error all_same_address"><?php echo form_error('all_same_address'); ?></small>

						</div>
						<div class="col-sm-2 per_address_class" <?php if(!empty($fuser_detailset->fu_same_address)){if($fuser_detailset->fu_same_address == "Yes"){echo 'style="display:none;"';}}else{echo 'style="display:none;"';} ?>>Communication Address :</div>

						<div class="col-sm-4 per_address_class" <?php if(!empty($fuser_detailset->fu_same_address)){if($fuser_detailset->fu_same_address == "Yes"){echo 'style="display:none;"';}}else{echo 'style="display:none;"';} ?>>

							<label class="radio-inline"><input type="radio" name="com_address" id="com_address_1" autocomplete="off" value="Present" <?php if ($fuser_detailset->fu_comunication_address == "Present") echo "checked" ?> /> Present Address</label>&nbsp;&nbsp;&nbsp;

							<label class="radio-inline"><input type="radio" name="com_address" id="com_address_2" autocomplete="off" value="Permanent" <?php if ($fuser_detailset->fu_comunication_address == "Permanent") echo "checked" ?> /> Permanent Address</label><br>

							<small class="text-error com_address"><?php echo form_error('com_address'); ?></small>

						</div>

					</div>

					<div class="row per_address_class" <?php if(!empty($fuser_detailset->fu_same_address)){if($fuser_detailset->fu_same_address == "Yes"){echo 'style="display:none;"';}}else{echo 'style="display:none;"';} ?>>
						<div class="col-sm-12 mt-2">
							<div class="box3">
								<div class="col-sm-12">
									<strong>Permanent Address</strong>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="row p-2">
											<div class="col-sm-3 pl-4">State :</div>
											<div class="col-sm-9">

												<select name="fu_per_state" class="form-control" id="exampleFormControlSelect1">


													<option value="">---Select---</option>

													<?php foreach ($state_list as $states) { ?>

														<option value="<?php echo $states->state_id; ?>" <?php if ($states->state_id == $fuser_detailset->fu_perma_state) {echo "selected";} ?>><?php echo $states->state_name; ?></option>

													<?php } ?>


												</select>
												<small class="text-error fu_per_state"><?php echo form_error('fu_per_state'); ?></small>
											</div>

										</div>

										<!-- ---------------------------- SUB DIVISION BLOCK ------------------------- -->
										<div class="fu-per-sub-division-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state != 28 && $fuser_detailset->fu_perma_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-3 pl-4">Sub-Division :</div>
											<div class="col-sm-9">

												<select name="fu_per_sub_division" class="form-control" id="exampleFormControlSelect1" <?php if ($fuser_detailset->fu_perma_dist == NULL) echo "disabled"; ?>>


													<option value="">---Select---</option>
													<?php if ($fuser_detailset->fu_perma_dist != NULL) { ?>
														<?php foreach ($per_sub_division as $sd) { ?>

															<option value="<?= $sd->subdiv_id ?>" <?php if ($fuser_detailset->fu_perma_sub_division == $sd->subdiv_id) echo "selected"; ?>><?= $sd->subdiv_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small class="text-error fu_per_sub_division"><?php echo form_error('fu_per_sub_division'); ?></small>
											</div>
										</div>
										<div class="fu-per-other-sub-division-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state == 28 || $fuser_detailset->fu_perma_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">Sub-Division :</div>
											<div class="col-sm-9">
												<input class="form-control" type="text" name="fu_per_other_sdiv" value="<?= $fuser_detailset->fu_perma_other_sdiv ?>" />
												<small class="text-error fu_per_other_sdiv"><?php echo form_error('fu_per_other_sdiv'); ?></small>
											</div>
										</div>

										<!-- ---------------------------- POLICE STATION BLOCK ------------------------- -->
										<div class="fu-per-police-station-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state != 28 && $fuser_detailset->fu_perma_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-3 pl-4">PoliceStation :</div>
											<div class="col-sm-9">
												<select class="form-control" name="fu_per_police_station" id="exampleFormControlSelect1" <?php if ($fuser_detailset->fu_perma_dist == NULL) echo "disabled"; ?>>
													<option value="">---Select---</option>
													<?php if ($fuser_detailset->fu_perma_dist != NULL) { ?>
														<?php foreach ($per_police_station as $ps) { ?>

															<option value="<?= $ps->ps_id ?>" <?php if ($fuser_detailset->fu_perma_police_station == $ps->ps_id) echo "selected"; ?>><?= $ps->ps_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small class="text-error fu_per_police_station"><?php echo form_error('fu_per_police_station'); ?></small>
											</div>
										</div>
										<div class="fu-per-other-police-station-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state == 28 || $fuser_detailset->fu_perma_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">PoliceStation :</div>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="fu_per_other_ps" value="<?= $fuser_detailset->fu_perma_other_ps ?>" />
												<small class="text-error fu_per_other_ps"><?php echo form_error('fu_per_other_ps'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Vill / Para / House No / Road :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_per_house_road" value="<?= $fuser_detailset->fu_perma_house_road ?>" class="form-control" />
												<small class="text-error fu_per_house_road"><?php echo form_error('fu_per_house_road'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Pin Code :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_per_pincode" value="<?= $fuser_detailset->fu_perma_pincode ?>" class="form-control" />
												<small class="text-error fu_per_pincode"><?php echo form_error('fu_per_pincode'); ?></small>
											</div>
										</div>
									</div>

									<div class="col-sm-6">

										<!-- ---------------------------- DSITRICT BLOCK ------------------------- -->
										<div class="fu-per-district-div row p-2" <?php if ($fuser_detailset->fu_perma_state != 28 && $fuser_detailset->fu_perma_state != NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">District :</div>

											<div class="col-sm-9">

												<select class="form-control" name="fu_per_district" id="fu_per_district" autocomplete="off" <?php if ($fuser_detailset->fu_perma_state == NULL) {echo "disabled";} ?>>


													<option value="">---Select---</option>

													<?php foreach ($dist_list as $dists) { ?>

														<option value="<?php echo $dists->district_code; ?>" <?php if ($dists->district_code == $fuser_detailset->fu_perma_dist) {echo "selected";} ?>><?php echo $dists->district_name; ?></option>

													<?php } ?>

												</select>

												<small class="text-error fu_per_district"><?php echo form_error('fu_per_district'); ?></small>

											</div>

										</div>
										<div class="fu-per-other-district-div row p-2" <?php if ($fuser_detailset->fu_perma_state == 28 || $fuser_detailset->fu_perma_state == NULL) { ?> style="display: none;" <?php } ?>>
											<div class="col-sm-3 pl-4">District :</div>

											<div class="col-sm-9">

												<input class="form-control" type="text" name="fu_per_other_district" value="<?= $fuser_detailset->fu_perma_other_district ?>" />

												<small class="text-error fu_per_other_district"><?php echo form_error('fu_per_other_district'); ?></small>

											</div>

										</div>
										<!-- ---------------------------- BLOCK MUNICIPALITY BLOCK ------------------------- -->
										<div class="fu-per-block-municipality-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state != 28 && $fuser_detailset->fu_perma_state != NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-4 pl-5">

												<input type="radio" name="fu_per_mb_type" class="form-check-input" id="exampleCheck11" <?php if ($fuser_detailset->fu_perma_sub_division == NULL) echo "disabled"; ?> <?php if ($fuser_detailset->fu_perma_sub_division != NULL && $fuser_detailset->fu_perma_mb_type != NULL) {if ($per_mb_type == "Municipality") echo "checked";} ?> value="Municipality"> Municipality
											</div>

											<div class="col-sm-4">

												<input type="radio" name="fu_per_mb_type" class="form-check-input" id="exampleCheck22" <?php if ($fuser_detailset->fu_perma_sub_division == NULL) echo "disabled"; ?> <?php if ($fuser_detailset->fu_perma_sub_division != NULL && $fuser_detailset->fu_perma_mb_type != NULL) {if ($per_mb_type == "Block") echo "checked";} ?> value="Block"> Block
												<br>
												<small class="text-error fu_per_mb_type"><?php echo form_error('fu_per_mb_type'); ?></small>
											</div>

											<div class="col-sm-4">

												<select class="form-control" name="fu_per_block_municipality" id="exampleFormControlSelect1">

													<option value="">---Select---</option>

													<?php if (isset($per_block_municipality) && !empty($per_block_municipality)) { ?>
														<?php foreach ($per_block_municipality as $bm) { ?>

															<option value="<?= $bm->block_id ?>" <?php if ($bm->block_id == $fuser_detailset->fu_perma_block_municipality) echo "selected" ?>><?= $bm->block_name ?></option>

														<?php } ?>
													<?php } ?>
												</select>
												<small class="text-error fu_per_block_municipality"><?php echo form_error('fu_per_block_municipality'); ?></small>
											</div>
										</div>
										<div class="fu-per-other-block-municipality-div row p-2 mt-2" <?php if ($fuser_detailset->fu_perma_state == 28 || $fuser_detailset->fu_perma_state == NULL) { ?> style="display: none;" <?php } ?>>

											<div class="col-sm-4">
												Block/ Municipality
											</div>
											<div class="col-sm-4">
												<input class="form-control" name="fu_per_other_blockm" value="<?= $fuser_detailset->fu_perma_other_blockm ?>" />
												<small class="text-error fu_per_other_blockm"><?php echo form_error('fu_per_other_blockm'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Ward/GP :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_per_ward_gp" value="<?= $fuser_detailset->fu_perma_ward_gp ?>" class="form-control" />
												<small class="text-error fu_per_ward_gp"><?php echo form_error('fu_per_ward_gp'); ?></small>
											</div>
										</div>
										<div class="row p-2 mt-2">
											<div class="col-sm-3 pl-4">Post Office :</div>
											<div class="col-sm-9">
												<input type="text" name="fu_per_post_office" value="<?= $fuser_detailset->fu_perma_post_office ?>" class="form-control" />

												<small class="text-error fu_per_post_office"><?php echo form_error('fu_per_post_office'); ?></small>
											</div>
										</div>
										
									</div>

								</div>

							</div>
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-sm-2">Address Proof Document :</div>
						<div class="col-sm-4">
							<input type="file" name="fu_address_doc" id="fu_address_doc" class="form-control" autocomplete="off" />
							<small class="">File format should be in .png/.jpg/.jpeg/.pdf format</small>
							<small class="">Maximum file size is 2 MB </small>
							<small class="text-error fu_address_doc"><?php echo form_error('fu_address_doc'); ?></small>

							<?php if (isset($fuser_detailset->fu_address_doc) && !empty($fuser_detailset->fu_address_doc)) { ?>
								<div class="fu_uploaded_address">
									<a href="<?= base_url($pathurl . $fuser_detailset->fu_address_doc) ?>" target="_blank">Address Proof Document</a>
								</div>
							<?php } ?>
						</div>
					</div>
				
					<div class="row mt-1">

						<div class="col-sm-12 text-center">

							<div align="center">

								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

							</div>

						</div>

					</div>

					<div class="row mt-5 mb-5">

						<div class="col-sm-12 text-center">

							<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_address');">Submit</button>

						</div>

					</div>

				<?php } ?>
				
			</div>
		<?php }
		if(in_array("fu_photo_doc", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step2">
				
				<div class="row mt-3">
					<?php if(in_array("fu_photo_doc", $reject_type_arr)){ ?>							
						<div class="col-sm-2">Photo Upload : </div>
						<div class="col-sm-4">
							<input type="file" name="fu_pic_doc" id="fu_pic_doc" class="form-control" autocomplete="off" />
							<small class="">File format should be in .png/.jpg/.jpeg format </small>
							<small class="">Maximum file size is 2 MB</small>
							<small class="text-error fu_pic_doc"><?php echo form_error('fu_pic_doc'); ?></small>

							<?php if (isset($fuser_detailset->fu_photo_doc) && !empty($fuser_detailset->fu_photo_doc)) { ?>
								<div class="fu_uploaded_photo">
									<a href="<?= base_url($pathurl . $fuser_detailset->fu_photo_doc) ?>" target="_blank">Photo</a>
								</div>
							<?php } ?>
						</div>

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

							<div class="col-sm-12 text-center mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_photo_doc');">Submit</button>

							</div>

						
					<?php } ?>
				</div>

			</div>
		<?php }
		if(in_array("fu_signature_doc", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step3">
				
				<div class="row mt-3">
					<?php if(in_array("fu_signature_doc", $reject_type_arr)){ ?>
						<div class="col-sm-2">Signature Upload :</div>
						<div class="col-sm-4">
							<input type="file" name="fu_sign_doc" id="fu_sign_doc" class="form-control" autocomplete="off" />
							<small class="">File format should be in .png/.jpg/.jpeg format</small>
							<small class="">Maximum file size is 2 MB </small>
							<small class="text-error fu_sign_doc"><?php echo form_error('fu_sign_doc'); ?></small>

							<?php if (isset($fuser_detailset->fu_signature_doc) && !empty($fuser_detailset->fu_signature_doc)) { ?>
								<div class="fu_uploaded_sign">
									<a href="<?= base_url($pathurl . $fuser_detailset->fu_signature_doc) ?>" target="_blank">Signature</a>
								</div>
							<?php } ?>
						</div>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mt-5 mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_signature_doc');">Submit</button>

							</div>

					<?php } ?>
				</div>

			</div>
		<?php }
		if(in_array("fu_caste", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step4">
					<div class="row mt-3">
						<?php if(in_array("fu_caste", $reject_type_arr)){ ?>
						<div class="col-sm-2">Caste :</div>

						<div class="col-sm-10">
								<select class="form-control" id="acc" name="fu_caste_type" onchange="yesnoCheck();">
								<?php $excattype = $extraattach = '';
								foreach ($caste_tab as $caste) : 
									if(!in_array($caste->caste_id,$allzero_vacancy)){ ?>

									<option value="<?= $caste->caste_id ?>" <?php if (!empty($fuser_detailset->fu_caste_type)){if ($fuser_detailset->fu_caste_type == $caste->caste_id) {echo 'selected';$excattype = $caste->caste_cat;$extraattach = $caste->caste_attach;}} ?>><?= $caste->caste_name ?></option>

								<?php }
								endforeach; ?>
								</select>
								<small class="text-error fu_caste_type"><?php echo form_error('fu_caste_type'); ?></small>

							<div id="ifYes" <?php if (!empty($fuser_detailset->fu_caste_type)){if($fuser_detailset->fu_caste_type == 1){echo 'style="display:none;"';}else{if($excattype == 1){echo 'style="display:none;"';}}}else{echo 'style="display:none;"';} ?>>
								
								<input type="hidden" name="com_castetypeset" id="com_castetypeset" value="<?php echo $excattype; ?>" autocomplete="off" />
								<input type="hidden" name="com_attachdoc_set" id="com_attachdoc_set" value="<?php echo $extraattach; ?>" autocomplete="off" />

								<div class="row mt-3 community_casteset" <?php if($excattype != 2){ ?>style="display:none;"<?php } ?>>
									<div class="col-sm-2">
										Caste/ Tribe/ Community
									</div>
									<div class="col-sm-4">

										<select class="form-control" name="fu_caste_community">
											<option value="">--SELECT--</option>
											<?php if ($fuser_detailset->fu_caste_type != NULL && $fuser_detailset->fu_caste_community != NULL) { ?>
												<option value="<?= $caste_community->csdetail_id ?>" selected><?= $caste_community->csdetail_name ?></option>
											<?php }else{
												if ($fuser_detailset->fu_caste_type != NULL && $fuser_detailset->fu_caste_type > 1){
												foreach($caste_communi_set as $castcom){ ?>
													<option value="<?= $castcom->csdetail_id ?>"><?= $castcom->csdetail_name ?></option>
											<?php }
												}
											} ?>
										</select>

										<small class="text-error fu_caste_community"><?php echo form_error('fu_caste_community'); ?></small>

									</div>
								</div>

								<div class="row mt-2">

									<div class="col-sm-2">Certification No :</div>

									<div class="col-sm-4">

										<input type="text" class="form-control" placeholder="Certification No" name="fu_caste_number" value="<?= $fuser_detailset->fu_caste_number ?>" />

										<small class="text-error fu_caste_number"><?php echo form_error('fu_caste_number'); ?></small>

									</div>

									<div class="col-sm-2">Issued By Whom </div>

									<div class="col-sm-4">
										<select class="form-control" name="fu_caste_issue_whom">
											<option value="">--SELECT--</option>
											<?php foreach ($caste_issuing_auth as $auth) { ?>
												<option value="<?= $auth->cia_id ?>" <?php if ($fuser_detailset->fu_caste_issue_whom == $auth->cia_id) echo "selected" ?>><?= $auth->cia_name ?></option>
											<?php } ?>
										</select>
										
										<small class="text-error fu_caste_issue_whom"><?php echo form_error('fu_caste_issue_whom'); ?></small>

									</div>

								</div>

								<div class="row mt-2">

									<div class="col-sm-2"> Issued by Date :</div>

									<div class="col-sm-4">

										<input type="date" class="form-control" name="fu_caste_issue_date" value="<?= $fuser_detailset->fu_caste_issue_date ?>" />
										<small class="text-error fu_caste_issue_date"><?php echo form_error('fu_caste_issue_date'); ?></small>

									</div>

									<div class="col-sm-2"> Doc Upload:</div>

									<div class="col-sm-4">

										<input type="file" name="fu_caste_doc" class="form-control" />

										<small class="text-error fu_caste_doc"><?php echo form_error('fu_caste_doc'); ?></small>
										<?php if (isset($fuser_detailset->fu_caste_doc) && !empty($fuser_detailset->fu_caste_doc)) { ?>
											<div class="fu_uploaded_caste">
												<a href="<?= base_url($pathurl . $fuser_detailset->fu_caste_doc) ?>" target="_blank">Caste Document</a>
											</div>
										<?php } ?>

									</div>

								</div>

							</div>

						</div>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mt-5 mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_caste');">Submit</button>

							</div>

						
						<?php } ?>
					</div>
			</div>
		<?php }
		if(in_array("fu_pwd", $reject_type_arr)){ ?>
			
			<div class="step-tab-panel" data-step="step5">
					<div class="row mt-3">
						<?php if(in_array("fu_pwd", $reject_type_arr)){ ?>
						<div class="col-sm-2">PWD :</div>

						<div class="col-sm-10"> Yes



							<input type="radio" onclick="javascript:yesnoCheck2();" name="yesno_pwd" id="yesCheck2" <?php if ($fuser_detailset->fu_pwd == 'Yes') echo 'checked' ?> value="Yes"> No



							<input type="radio" onclick="javascript:yesnoCheck2();" name="yesno_pwd" id="noCheck2" <?php if ($fuser_detailset->fu_pwd == 'No') echo 'checked' ?> value="No"><br>

							<small class="text-error fu_pwd"><?php echo form_error('yesno_pwd'); ?></small>



							<div class="row mt-2" id="ifyespwd" <?php if ($fuser_detailset->fu_pwd == 'Yes') echo 'style="display:block"';
																else echo 'style="display:none"'; ?>>

								<div class="row ">

									<div class="col-sm-2 pl-4">Percentage of Disability :</div>



									<div class="col-sm-4">

										<input type="text" class="form-control" name="fu_pwd_percent" value="<?= $fuser_detailset->fu_pwd_percent ?>" />

										<small class="text-error fu_pwd_percent"><?php echo form_error('fu_pwd_percent'); ?></small>

									</div>



									<div class="col-sm-2 ">Issuing Authority:</div>



									<div class="col-sm-3">

										<input type="text" class="form-control" name="fu_pwd_issue_whom" value="<?= $fuser_detailset->fu_pwd_issue_whom ?>" />

										<small class="text-error fu_pwd_issue_whom"><?php echo form_error('fu_pwd_issue_whom'); ?></small>

									</div>

								</div>



								<div class="row mt-2">

									<div class="col-sm-2 pl-4">Issued by Date :</div>

									<div class="col-sm-4">

										<input type="date" class="form-control" name="fu_pwd_issue_date" value="<?= $fuser_detailset->fu_pwd_issue_date ?>" />

										<small class="text-error fu_pwd_issue_date"><?php echo form_error('fu_pwd_issue_date'); ?></small>

									</div>

									<div class="col-sm-2">Doc Upload:</div>

									<div class="col-sm-3">

										<input type="file" name="fu_pwd_doc" class="form-control" />

										<small class="text-error fu_pwd_doc"><?php echo form_error('fu_pwd_doc'); ?></small>

										<?php if (isset($fuser_detailset->fu_pwd_doc) && !empty($fuser_detailset->fu_pwd_doc)) { ?>

											<div class="fu_uploaded_pwd">

												<a href="<?= base_url($pathurl . $fuser_detailset->fu_pwd_doc) ?>" target="_blank">PWD Document</a>

											</div>

										<?php } ?>

									</div>



								</div>

							</div>

						</div>

						<div class="col-sm-12 text-center">

							<div align="center">

								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

							</div>

						</div>

						<div class="col-sm-12 text-center mt-5 mb-5">

							<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_pwd');">Submit</button>

						</div>

						

						<?php } ?>
					</div>
			</div>
		<?php }
		if(in_array("fu_age_relax", $reject_type_arr)){ ?>
			
			<div class="step-tab-panel" data-step="step6">


					<div class="row mt-3" <?php if ($adv_detail->adv_has_exampted == "No") {echo 'style="display:none;"';} ?>>

						<?php if(in_array("fu_exempted", $reject_type_arr)){ ?>				
						<div class="col-sm-2">Exempted :</div>

						<div class="col-sm-10"> Yes

							<input type="radio" onclick="javascript:yesnoCheck3();" name="yesno_exempted" id="yesCheck3" <?php if ($fuser_detailset->fu_exempted == 'Yes') echo 'checked' ?> value="Yes"> No



							<input type="radio" onclick="javascript:yesnoCheck3();" name="yesno_exempted" id="noCheck3" <?php if ($fuser_detailset->fu_exempted == 'No') echo 'checked' ?> value="No"><br>

							<small class="text-error fu_exempted"><?php echo form_error('yesno_exempted'); ?></small>



							<div class="row mt-2" id="ifyesexem" <?php if ($fuser_detailset->fu_exempted == 'Yes') echo 'style="display:block"';
																	else echo 'style="display:none"'; ?>>

								<div class="row pl-2">

									<div class="col-sm-2 pl-4">Reason :</div>

									<div class="col-sm-4">

										<select class="form-control" rows="3" name="fu_exc_reason" id="reason">

											<option value="option_1" <?php if ($fuser_detailset->fu_exc_reason == "option_1") echo "selected"; ?>>Option 1</option>
											<option value="option_2" <?php if ($fuser_detailset->fu_exc_reason == "option_2") echo "selected"; ?>>Option 2</option>
											<option value="option_3" <?php if ($fuser_detailset->fu_exc_reason == "option_3") echo "selected"; ?>>Option 3</option>

										</select>
										<!-- <textarea ><?= $fuser_detailset->fu_exc_reason ?></textarea> -->

										<small class="text-error fu_exc_reason"><?php echo form_error('fu_exc_reason'); ?></small>

									</div>

									<div class="col-sm-2">Upload Doc :</div>

									<div class="col-sm-3">

										<input type="file" name="fu_exc_doc" class="form-control" />

										<small class="text-error fu_exc_doc"><?php echo form_error('fu_exc_doc'); ?></small>

										<?php if (isset($fuser_detailset->fu_exc_doc) && !empty($fuser_detailset->fu_exc_doc)) { ?>

											<div class="fu_uploaded_exc">

												<a href="<?= base_url($pathurl . $fuser_detailset->fu_exc_doc) ?>" target="_blank"> Document</a>

											</div>

										<?php } ?>

									</div>

								</div>





							</div>

						</div>
						<?php } ?>
					</div>


					<div class="row mt-3" <?php if ($adv_detail->adv_has_exservice == "No") {echo 'style="display:none;"';} ?>>

						<?php if(in_array("fu_exservice", $reject_type_arr)){ ?>	
						<div class="col-sm-2">Ex Serviceman :</div>

						<div class="col-sm-10"> Yes

							<input type="radio" onclick="javascript:yesnoCheck4();" name="yesno_exservice" id="yesCheck4" <?php if ($fuser_detailset->fu_exservice == 'Yes') echo 'checked' ?> value="Yes"> No

							<input type="radio" onclick="javascript:yesnoCheck4();" name="yesno_exservice" id="noCheck4" <?php if ($fuser_detailset->fu_exservice == 'No') echo 'checked' ?> value="No"><br>

							<small class="text-error fu_exservice"><?php echo form_error('yesno_exservice'); ?></small>



							<div class="row mt-2" id="ifyesex" <?php if ($fuser_detailset->fu_exservice == 'Yes') echo 'style="display:block"';
																else echo 'style="display:none"'; ?>>

								<div class="row pl-2">

									<div class="col-sm-2 pl-4">Description :</div>

									<div class="col-sm-4">

										<textarea class="form-control" rows="2" id="reason" name="fu_exs_reason"><?= $fuser_detailset->fu_exs_reason ?></textarea>

										<small class="text-error fu_exs_reason"><?php echo form_error('fu_exs_reason'); ?></small>

									</div>

									<div class="col-sm-2">Upload Doc :</div>

									<div class="col-sm-3">

										<input type="file" name="fu_exs_doc" class="form-control" />

										<small class="text-error fu_exs_doc"><?php echo form_error('fu_exs_doc'); ?></small>

										<?php if (isset($fuser_detailset->fu_exs_doc) && !empty($fuser_detailset->fu_exs_doc)) { ?>

											<div class="fu_uploaded_exservice">

												<a href="<?= base_url($pathurl . $fuser_detailset->fu_exs_doc) ?>" target="_blank">Ex Service Document</a>

											</div>

										<?php } ?>

									</div>

								</div>





							</div>

						</div>
						<?php } ?>
					</div>


					<div class="row mt-3" <?php if ($adv_detail->adv_has_ews == "No") {echo 'style="display:none;"';} ?>>
						
						<?php if(in_array("fu_ews", $reject_type_arr)){ ?>
						<div class="col-sm-2">EWS :</div>

						<div class="col-sm-10"> Yes

							<input type="radio" onclick="javascript:yesnoCheck5();" name="yesno_ews" id="yesCheck5" <?php if ($fuser_detailset->fu_ews == 'Yes') echo 'checked' ?> value="Yes"> No

							<input type="radio" onclick="javascript:yesnoCheck5();" name="yesno_ews" id="noCheck5" <?php if ($fuser_detailset->fu_ews == 'No') echo 'checked' ?> value="No"><br>

							<small class="text-error yesno_ews"><?php echo form_error('yesno_ews'); ?></small>



							<div class="row mt-2" id="ifyesews" <?php if ($fuser_detailset->fu_ews == 'Yes') echo 'style="display:block"';
																else echo 'style="display:none"'; ?>>

								<div class="row pl-2">

									<div class="col-sm-2 pl-4">Description :</div>

									<div class="col-sm-4">

										<textarea class="form-control" rows="2" id="fu_ews_reason" name="fu_ews_reason"><?= $fuser_detailset->fu_ews_reason ?></textarea>

										<small class="text-error fu_ews_reason"><?php echo form_error('fu_ews_reason'); ?></small>

									</div>

									<div class="col-sm-2">Upload Doc :</div>

									<div class="col-sm-3">

										<input type="file" name="fu_ews_doc" class="form-control">

										<small class="text-error fu_ews_doc"><?php echo form_error('fu_ews_doc'); ?></small>

										<?php if (isset($fuser_detailset->fu_ews_doc) && !empty($fuser_detailset->fu_ews_doc)) { ?>

											<div class="fu_uploaded_ews">

												<a href="<?= base_url($pathurl . $fuser_detailset->fu_ews_doc) ?>" target="_blank">EWS Document</a>

											</div>

										<?php } ?>

									</div>

								</div>





							</div>

						</div>
						<?php } ?>
					</div>

					<?php if(in_array("fu_age_relax", $reject_type_arr)){ ?>

					<?php if(!empty($extraage_set)){ ?>
						<?php $agecounter = 1; 
							$alreadyagetexist = array();
						foreach($extraage_set as $ageitems){ ?>
						<?php if(!empty($extraage_list)){
							foreach($extraage_list as $etaitem){

								if($ageitems->advage_section == $etaitem->fu_ext_ageid && in_array($ageitems->advage_section,$age1_arr)){
									//$alreadyagetexist[] = $etaitem->fu_ext_ageid; ?>

								<div class="row mt-3">
									<div class="col-sm-2"><?php echo $ageitems->caste_name; ?> :</div>
									<div class="col-sm-10"> Yes
										<input type="radio" onclick="javascript:yesnoExtraage_Check(<?php echo $agecounter; ?>);" name="yesno_extage_<?php echo $agecounter; ?>" <?php if ($etaitem->fu_ext_answer == 'Yes') echo 'checked' ?> value="Yes"> No
										<input type="radio" onclick="javascript:yesnoExtraage_Check(<?php echo $agecounter; ?>);" name="yesno_extage_<?php echo $agecounter; ?>" <?php if ($etaitem->fu_ext_answer == 'No') echo 'checked' ?> value="No"><br>
										<small class="text-error yesno_extage_<?php echo $agecounter; ?>"><?php echo form_error('yesno_extage_'.$agecounter); ?></small>
										
										<div class="row mt-2" id="ifyesextage_<?php echo $agecounter; ?>" <?php if ($etaitem->fu_ext_answer == 'Yes'){ echo 'style="display:block"';} else {echo 'style="display:none"';} ?>>
											<div class="row pl-2">
												<div class="col-sm-2 pl-4">Detail Description :</div>
												<div class="col-sm-4">
													<textarea class="form-control" rows="2" id="fu_extage_reason_<?php echo $agecounter; ?>" name="fu_extage_reason_<?php echo $agecounter; ?>"><?= $etaitem->fu_ext_reason ?></textarea>
													<small class="text-error fu_extage_reason_<?php echo $agecounter; ?>"><?php echo form_error('fu_extage_reason_'.$agecounter); ?></small>
												</div>
												<div class="col-sm-2">Upload Doc :</div>
												<div class="col-sm-3">
													<input type="file" name="fu_extage_doc_<?php echo $agecounter; ?>" class="form-control">
													<small class="text-error fu_extage_doc_<?php echo $agecounter; ?>"><?php echo form_error('fu_extage_doc_'.$agecounter); ?></small>
													<?php if (isset($etaitem->fu_ext_doc) && !empty($etaitem->fu_ext_doc)) { ?>
														<div class="fu_uploaded_extage_<?php echo $agecounter; ?>">
															<a href="<?= base_url($pathurl . $etaitem->fu_ext_doc) ?>" target="_blank">Attach Document</a>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							
							<?php $agecounter++;}

							}
						} ?>
						<?php 
							} ?>

							<div class="row mt-1">

								<div class="col-sm-12 text-center">

									<div align="center">

										<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

										<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

										<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

									</div>

								</div>

							</div>

							<div class="row mt-5 mb-5">

								<div class="col-sm-12 text-center">

									<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_age_relax');">Submit</button>

								</div>

							</div>
					<?php } ?>

					<?php } ?>


			</div>
		<?php }
		if(in_array("fu_es_qualification", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step7">

				<?php if(in_array("fu_es_qualification", $reject_type_arr)){ ?>
					<?php if($adv_detail->adv_qualification_no > 0){ ?>
					<h3>Essential Qualification</h3>
					<div class="quali">
						
						<div class="row">
							<div class="col-sm-12">
								<table class="table">
									<thead>
										<th>Examination Name</th>
										<th>Board/ Council/ University/ Journal</th>
										<th>State Name</th>
										<th>Marks Obtained</th>
										<th>Full Marks</th>
										<th>Percentage(%) of Marks</th>
										<th>Additional Attempt</th>
										<th>No. of Additional Attempt</th>
										<th>Upload Marksheet</th>
									</thead>
									
									<tbody>
									<?php $secarr = (array)$quali_list;
										//print_r($quali_list);exit;
										$qchk = 0;
										for($q=0; $q<$adv_detail->adv_qualification_no;$q++){ 
											if(in_array($secarr[$q]->fu_qualifiaction_name,$es_quali_arr)){ ?>

											<tr>
												<td>
												<input type="hidden" id="examid_<?php echo $qchk; ?>" name="examid_<?php echo $qchk; ?>" value="<?php echo $secarr[$q]->fu_quali_id; ?>" />
												<input type="hidden" id="exam_rej_id_<?php echo $qchk; ?>" name="exam_rej_id_<?php echo $qchk; ?>" value="<?php echo $secarr[$q]->fu_qualifiaction_name; ?>" />

												<select class="form-control exam-name-input" name="exam_name_<?php echo $qchk; ?>" id="exam_name_<?php echo $qchk; ?>">
													<?php foreach ($quali_exam[$q] as $exam) { ?>
													<option value="<?= $exam['aquali_exam'] ?>" <?php if(!empty($secarr[$q]->fu_qualifiaction_name)){if($secarr[$q]->fu_qualifiaction_name == $exam['aquali_exam']){echo "selected";}} ?>><?= $exam['qm_name'] ?></option>
													<?php } ?>
												</select>
												<small class="text-error exam_name_<?php echo $qchk; ?>"><?php echo form_error('exam_name_'.$qchk); ?></small>

												<?php /*foreach ($quali_exam[$q] as $exam) { ?>
												<?php if(!empty($secarr[$q]->fu_qualifiaction_name)){if($secarr[$q]->fu_qualifiaction_name == $exam['aquali_exam']){echo $exam['qm_name'];
												}} ?>
												<?php }*/ ?>
												<small class="text-error examid_<?php echo $qchk; ?>"><?php echo form_error('examid_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control univ-input" id="univ_<?php echo $qchk; ?>" name="univ_<?php echo $qchk; ?>" placeholder="Enter Name" value="<?php if(!empty($secarr[$q]->fu_council_board)){echo $secarr[$q]->fu_council_board;} ?>" />
													<small class="text-error univ_<?php echo $qchk; ?>"><?php echo form_error('univ_'.$qchk); ?></small>
												</td>
												<td>
													<select class="form-control state-input" name="state_<?php echo $qchk; ?>" id="state_<?php echo $qchk; ?>">
														<option value="">---Select---</option>
														<?php foreach ($state_list as $states) { ?>
														<option value="<?php echo $states->state_id; ?>" <?php if(!empty($secarr[$q]->fu_state_of_passing)){if($secarr[$q]->fu_state_of_passing == $states->state_id){echo "selected";}} ?>><?php echo $states->state_name; ?></option>
														<?php } ?>
													</select>
													<small class="text-error state_<?php echo $qchk; ?>"><?php echo form_error('state_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-obtained-input" name="marks_obtained_<?php echo $qchk; ?>" id="marks_obtained_<?php echo $qchk; ?>" placeholder="Marks Obtained" onkeyup="percentcheck_exm();" value="<?php if(!empty($secarr[$q]->fu_marks_obtained)){echo $secarr[$q]->fu_marks_obtained;} ?>" />
													<small class="text-error marks_obtained_<?php echo $qchk; ?>"><?php echo form_error('marks_obtained_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-full-input" id="marks_full_<?php echo $qchk; ?>" name="marks_full_<?php echo $qchk; ?>" placeholder="Full Marks" onkeyup="percentcheck_exm();" value="<?php if(!empty($secarr[$q]->fu_full_marks)){echo $secarr[$q]->fu_full_marks;} ?>" />
													<small class="text-error marks_full_<?php echo $qchk; ?>"><?php echo form_error('marks_full_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-percent-input" id="marks_percent_<?php echo $qchk; ?>" name="marks_percent_<?php echo $qchk; ?>" readonly="" value="<?php if(!empty($secarr[$q]->fu_percent_of_marks)){echo $secarr[$q]->fu_percent_of_marks;} ?>" />
													<small class="text-error marks_percent_<?php echo $qchk; ?>"><?php echo form_error('marks_percent_'.$qchk); ?></small>
												</td>
												<td>
													<select class="form-control state-input" name="add_attempt_<?php echo $qchk; ?>" id="add_attempt_<?php echo $qchk; ?>">
														<option value="No" <?php if(!empty($secarr[$q]->fu_is_attempt)){if($secarr[$q]->fu_is_attempt == "No"){echo "selected";}} ?>>No</option>
														<option value="Yes" <?php if(!empty($secarr[$q]->fu_is_attempt)){if($secarr[$q]->fu_is_attempt == "Yes"){echo "selected";}} ?>>Yes</option>
													</select>
													<small class="text-error add_attempt_<?php echo $qchk; ?>"><?php echo form_error('add_attempt_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-percent-input" id="add_attempt_no_<?php echo $qchk; ?>" name="add_attempt_no_<?php echo $qchk; ?>" value="<?php if(!empty($secarr[$q]->fu_attempt_no)){echo $secarr[$q]->fu_attempt_no;} ?>" />
													<small class="text-error add_attempt_no_<?php echo $qchk; ?>"><?php echo form_error('add_attempt_no_'.$qchk); ?></small>
												</td>
												<td>
													<input type="file" name="marksheet_<?php echo $qchk; ?>" id="marksheet_<?php echo $qchk; ?>" class="form-control marksheet">
													<small class="text-error marksheet_<?php echo $qchk; ?>"><?php echo form_error('marksheet_'.$qchk); ?></small>
													<div class="attach_marks_<?php echo $qchk; ?>"><?php if(!empty($secarr[$q]->fu_quali_docs)){ ?><a href="<?php echo base_url($pathurl).$secarr[$q]->fu_quali_docs; ?>" target="_blank">Attached Marksheet</a><?php } ?></div>
												</td>
											</tr>
										
									<?php $qchk++; }
									} ?>
									</tbody>
									
								</table>
							</div>
						</div>
						
						<!-- ---------------------------------------------------------------------- -->

					</div>

					<div class="row mt-1">

						<div class="col-sm-12 text-center">

							<div align="center">

								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

							</div>

						</div>

					</div>

					<div class="row mt-5 mb-5">

						<div class="col-sm-12 text-center">

							<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_es_qualification');">Submit</button>

						</div>

					</div>
					<?php } ?>
				<?php } ?>

			</div>
		<?php }
		if(in_array("fu_ds_qualification", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step8">

				<input type="hidden" name="des_q_counter" id="des_q_counter" value="<?php echo count((array)$desquali_list); ?>" />
				<?php if(in_array("fu_ds_qualification", $reject_type_arr)){ ?>
					<?php if(count($desire_quali_exam) > 0){ ?>
					<div class="row mt-2">
						<div class="col-sm-12">
							<h3>Desirable Qualification</h3>
							<table class="table">
								<thead>
									<th>Examination Name</th>
									<th>Board/ Council/ University/ Journal</th>
									<th>State Name</th>
									<th>Marks Obtained</th>
									<th>Full Marks</th>
									<th>Percentage(%) of Marks</th>
									<th>Additional Attempt</th>
									<th>No. of Additional Attempt</th>
									<th>Upload Marksheet</th>
									<th>&nbsp;</th>
								</thead>
								<tbody>
									<?php $qchk = 0; 
									foreach($desquali_list as $ds_qitems){ 
										if(in_array($ds_qitems->fud_qualifiaction_name, $ds_quali_arr)){ ?>

											<tr>
												<td>
												<input type="hidden" id="dexamid_<?php echo $qchk; ?>" name="dexamid_<?php echo $qchk; ?>" value="<?php echo $ds_qitems->fud_quali_id; ?>" />
												<input type="hidden" id="dexam_rej_id_<?php echo $qchk; ?>" name="dexam_rej_id_<?php echo $qchk; ?>" value="<?php echo $ds_qitems->fud_qualifiaction_name; ?>" />
												<?php foreach ($desire_quali_exam as $exam) { ?>
												<?php if(!empty($ds_qitems->fud_qualifiaction_name)){if($ds_qitems->fud_qualifiaction_name == $exam['aquali_exam']){echo $exam['qm_name'];}} ?>
												<?php } ?>
												<small class="text-error dexamid_<?php echo $qchk; ?>"><?php echo form_error('dexamid_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control univ-input" id="duniv_<?php echo $qchk; ?>" name="duniv_<?php echo $qchk; ?>" placeholder="Enter Name" value="<?php if(!empty($ds_qitems->fud_council_board)){echo $ds_qitems->fud_council_board;} ?>" />
													<small class="text-error duniv_<?php echo $qchk; ?>"><?php echo form_error('duniv_'.$qchk); ?></small>
												</td>
												<td>
													<select class="form-control state-input" name="dstate_<?php echo $qchk; ?>" id="dstate_<?php echo $qchk; ?>">
														<option value="">---Select---</option>
														<?php foreach ($state_list as $states) { ?>
														<option value="<?php echo $states->state_id; ?>" <?php if(!empty($ds_qitems->fud_state_of_passing)){if($ds_qitems->fud_state_of_passing == $states->state_id){echo "selected";}} ?>><?php echo $states->state_name; ?></option>
														<?php } ?>
													</select>
													<small class="text-error dstate_<?php echo $qchk; ?>"><?php echo form_error('dstate_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-obtained-input" name="dmarks_obtained_<?php echo $qchk; ?>" id="dmarks_obtained_<?php echo $qchk; ?>" placeholder="Marks Obtained" onkeyup="dpercentcheck_exm();" value="<?php if(!empty($ds_qitems->fud_marks_obtained)){echo $ds_qitems->fud_marks_obtained;} ?>" />
													<small class="text-error dmarks_obtained_<?php echo $qchk; ?>"><?php echo form_error('dmarks_obtained_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-full-input" id="dmarks_full_<?php echo $qchk; ?>" name="dmarks_full_<?php echo $qchk; ?>" placeholder="Full Marks" onkeyup="dpercentcheck_exm();" value="<?php if(!empty($ds_qitems->fud_full_marks)){echo $ds_qitems->fud_full_marks;} ?>" />
													<small class="text-error dmarks_full_<?php echo $qchk; ?>"><?php echo form_error('dmarks_full_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-percent-input" id="dmarks_percent_<?php echo $qchk; ?>" name="dmarks_percent_<?php echo $qchk; ?>" readonly="" value="<?php if(!empty($ds_qitems->fud_percent_of_marks)){echo $ds_qitems->fud_percent_of_marks;} ?>" />
													<small class="text-error dmarks_percent_<?php echo $qchk; ?>"><?php echo form_error('dmarks_percent_'.$qchk); ?></small>
												</td>
												<td>
													<select class="form-control state-input" name="dadd_attempt_<?php echo $qchk; ?>" id="dadd_attempt_<?php echo $qchk; ?>">
														<option value="No" <?php if(!empty($ds_qitems->fud_is_attempt)){if($ds_qitems->fud_is_attempt == "No"){echo "selected";}} ?>>No</option>
														<option value="Yes" <?php if(!empty($ds_qitems->fud_is_attempt)){if($ds_qitems->fud_is_attempt == "Yes"){echo "selected";}} ?>>Yes</option>
													</select>
													<small class="text-error dadd_attempt_<?php echo $qchk; ?>"><?php echo form_error('dadd_attempt_'.$qchk); ?></small>
												</td>
												<td>
													<input type="text" class="form-control marks-percent-input" id="dadd_attempt_no_<?php echo $qchk; ?>" name="dadd_attempt_no_<?php echo $qchk; ?>" value="<?php if(!empty($ds_qitems->fud_attempt_no)){echo $ds_qitems->fud_attempt_no;} ?>" />
													<small class="text-error dadd_attempt_no_<?php echo $qchk; ?>"><?php echo form_error('dadd_attempt_no_'.$qchk); ?></small>
												</td>
												<td>
													<input type="file" name="dmarksheet_<?php echo $qchk; ?>" id="dmarksheet_<?php echo $qchk; ?>" class="form-control dmarksheet">
													<small class="text-error dmarksheet_<?php echo $qchk; ?>"><?php echo form_error('dmarksheet_'.$qchk); ?></small>
													<div class="dattach_marks_<?php echo $qchk; ?>"><?php if(!empty($ds_qitems->fud_quali_docs)){ ?><a href="<?php echo base_url($pathurl).$ds_qitems->fud_quali_docs; ?>" target="_blank">Attached Marksheet</a><?php } ?></div>
												</td>
											</tr>

									<?php $qchk++; }
									} ?>
								</tbody>
							</table>
							<input type="hidden" name="dsq_total_rej" id="dsq_total_rej" value="<?php echo $qchk; ?>" />
						</div>
					</div>

					<div class="row mt-1">

						<div class="col-sm-12 text-center">

							<div align="center">

								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

							</div>

						</div>

					</div>

					<div class="row mt-5 mb-5">

						<div class="col-sm-12 text-center">

							<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_ds_qualification');">Submit</button>

						</div>

					</div>

					<?php } ?>	
				<?php } ?>

			</div>
		<?php }
		if(in_array("fu_has_es_service", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step9">
				
				<?php if($adv_detail->adv_has_experience == "Yes"){ ?>
					<div class="row mt-3">
						<?php if(in_array("fu_has_es_service", $reject_type_arr)){ ?>
						<?php if($adv_detail->adv_experience_no > 0){ ?>
							<div class="col-sm-12">
							<div class="row mt-2" id="ifyesservice">
							<div class="col-sm-12">
								<h3>Essential Experience</h3>
								<div class="row">
									<div class="col-sm-12">
											
									<?php if(!empty($essenexp_list)){ ?>
										<table class="table table-bordered">
										<thead>
											<th>Experience Category</th>
											<th>Organization</th>
											<th colspan="2">Period<br/>(Year & Month)</th>
											<th>Upload Certificate</th>
										</thead>
										<tbody>
										<?php $qchk = 0;
											foreach($essenexp_list as $expss){ 
											if(in_array($expss->fues_exp_workname, $es_serv_arr) && ($expss->fues_exp_approval == "Rejected")){ ?>
											<tr>
												<td><input type="hidden" id="expid_<?php echo $qchk; ?>" name="expid_<?php echo $qchk; ?>" value="<?php echo $expss->fues_exp_id; ?>" />
												<input type="hidden" id="exp_rej_id_<?php echo $qchk; ?>" name="exp_rej_id_<?php echo $qchk; ?>" value="<?php echo $expss->fues_exp_workname; ?>" />
												<?php echo $expss->expset_name; ?></td>
												<small class="text-error expid_<?php echo $qchk; ?>"><?php echo form_error('expid_'.$qchk); ?></small>
												<td>
												<input type="text" class="form-control univ-input" id="exporg_<?php echo $qchk; ?>" name="exporg_<?php echo $qchk; ?>" placeholder="Organization Name" value="<?php if(!empty($expss->fues_exp_org_name)){echo $expss->fues_exp_org_name;} ?>" />
												<small class="text-error exporg_<?php echo $qchk; ?>"><?php echo form_error('exporg_'.$qchk); ?></small>
												</td>
												<td>
												<input type="text" class="form-control univ-input" id="expyear_<?php echo $qchk; ?>" name="expyear_<?php echo $qchk; ?>" placeholder="Enter Year" value="<?php if(!empty($expss->fues_exp_year)){echo $expss->fues_exp_year;} ?>" />
												<small class="text-error expyear_<?php echo $qchk; ?>"><?php echo form_error('expyear_'.$qchk); ?></small>
												</td>
												<td>
												<input type="text" class="form-control univ-input" id="expmonth_<?php echo $qchk; ?>" name="expmonth_<?php echo $qchk; ?>" placeholder="Enter Month" value="<?php if(!empty($expss->fues_exp_month)){echo $expss->fues_exp_month;} ?>" />
												<small class="text-error expmonth_<?php echo $qchk; ?>"><?php echo form_error('expmonth_'.$qchk); ?></small>
												</td>
												<td>
												<input type="file" name="expmarksheet_<?php echo $qchk; ?>" id="expmarksheet_<?php echo $qchk; ?>" class="form-control dmarksheet">
												<small class="text-error expmarksheet_<?php echo $qchk; ?>"><?php echo form_error('expmarksheet_'.$qchk); ?></small>
												<div class="expattach_marks_<?php echo $qchk; ?>"><?php if(!empty($expss->fues_exp_marksheet_doc)){ ?><a href="<?php echo base_url($pathurl).$expss->fues_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a><?php } ?></div>
												</td>
											</tr>
										<?php $qchk++; }} ?>
											</tbody>
										</table>
									<?php } ?>
									<input type="hidden" name="esexp_total_rej" id="esexp_total_rej" value="<?php echo $qchk; ?>" />
									</div>
								</div>
							</div>
							</div>
							</div>
							<?php } ?>

							

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_has_es_service');">Submit</button>

							</div>

							

						<?php } ?>

					</div>

					
				<?php } ?>

			</div>
		<?php }
		if(in_array("fu_has_ds_service", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step10">
				
				<?php if($adv_detail->adv_has_experience == "Yes"){ ?>
					<div class="row mt-3">
						

						<?php if(in_array("fu_has_ds_service", $reject_type_arr)){ ?>
							<?php if(count($desire_expr) > 0){ ?>

							<div class="col-sm-12">
								
								<div class="row mt-2" id="ifyesservice_des">
									<div class="col-sm-12">
										<h3>Desirable Experience</h3>
										<?php if(!empty($exp_list)){ ?>
											<table class="table table-bordered">
											<thead>
												<th>Experience Category</th>
												<th>Organization</th>
												<th colspan="2">Period<br/>(Year & Month)</th>
												<th>Upload Certificate</th>
											</thead>
											<tbody class="exp_setvalue">
											<?php $qchk = 0;
											foreach($exp_list as $expss){
												if(in_array($expss->fu_exp_workname, $ds_serv_arr) && ($expss->fu_exp_approval == "Rejected")){ ?>
												<tr>
													<td><input type="hidden" id="dexpid_<?php echo $qchk; ?>" name="dexpid_<?php echo $qchk; ?>" value="<?php echo $expss->fu_exp_id; ?>" />
													<input type="hidden" id="dexp_rej_id_<?php echo $qchk; ?>" name="dexp_rej_id_<?php echo $qchk; ?>" value="<?php echo $expss->fu_exp_workname; ?>" />
													<?php echo $expss->expset_name; ?></td>
													<small class="text-error dexpid_<?php echo $qchk; ?>"><?php echo form_error('dexpid_'.$qchk); ?></small>
													<td>
													<input type="text" class="form-control univ-input" id="dexporg_<?php echo $qchk; ?>" name="dexporg_<?php echo $qchk; ?>" placeholder="Organization Name" value="<?php if(!empty($expss->fu_exp_org_name)){echo $expss->fu_exp_org_name;} ?>" />
													<small class="text-error dexporg_<?php echo $qchk; ?>"><?php echo form_error('dexporg_'.$qchk); ?></small>
													</td>
													<td>
													<input type="text" class="form-control univ-input" id="dexpyear_<?php echo $qchk; ?>" name="dexpyear_<?php echo $qchk; ?>" placeholder="Enter Year" value="<?php if(!empty($expss->fu_exp_year)){echo $expss->fu_exp_year;}else{ echo "0";} ?>" />
													<small class="text-error dexpyear_<?php echo $qchk; ?>"><?php echo form_error('dexpyear_'.$qchk); ?></small>
													</td>
													<td>
													<input type="text" class="form-control univ-input" id="dexpmonth_<?php echo $qchk; ?>" name="dexpmonth_<?php echo $qchk; ?>" placeholder="Enter Month" value="<?php if(!empty($expss->fu_exp_month)){echo $expss->fu_exp_month;}else{ echo "0";} ?>" />
													<small class="text-error dexpmonth_<?php echo $qchk; ?>"><?php echo form_error('dexpmonth_'.$qchk); ?></small>
													</td>
													<td>
													<input type="file" name="dexpmarksheet_<?php echo $qchk; ?>" id="dexpmarksheet_<?php echo $qchk; ?>" class="form-control dmarksheet">
													<small class="text-error dexpmarksheet_<?php echo $qchk; ?>"><?php echo form_error('dexpmarksheet_'.$qchk); ?></small>
													<div class="dexpattach_marks_<?php echo $qchk; ?>"><?php if(!empty($expss->fu_exp_marksheet_doc)){ ?><a href="<?php echo base_url($pathurl).$expss->fu_exp_marksheet_doc; ?>" target="_blank">Attached Certificate</a><?php } ?></div>
													</td>
												</tr>
											<?php $qchk++; }
											} ?>
											</tbody>
											</table>
										<?php } ?>
										<input type="hidden" name="dexp_total_rej" id="dexp_total_rej" value="<?php echo $qchk; ?>" />	
									</div>
								</div>
							</div>
							<?php } ?>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_has_ds_service');">Submit</button>

							</div>

						


						<?php } ?>

					</div>

					
				<?php } ?>

			</div>
		<?php }
		if(in_array("fu_exempted", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step11">
					<div class="row mt-3">
						<?php if(in_array("fu_exempted", $reject_type_arr)){ ?>
						<div class="col-sm-2">Exempted Category :</div>

						<div class="col-sm-10">

							<div class="row pl-2">

								<div class="col-sm-2 pl-4">Description :</div>

								<div class="col-sm-4">

									<textarea class="form-control" rows="3" name="fu_exc_reason" id="fu_exc_reason"><?= $fuser_detailset->fu_exc_reason ?></textarea>

									<small class="text-error fu_exc_reason"><?php echo form_error('fu_exc_reason'); ?></small>

								</div>

								<div class="col-sm-2">Upload Doc :</div>

								<div class="col-sm-4">

									<input type="file" name="fu_exc_doc" class="form-control">

									<small class="text-error fu_exc_doc"><?php echo form_error('fu_exc_doc'); ?></small>

									<?php if (isset($fuser_detailset->fu_exc_doc) && !empty($fuser_detailset->fu_exc_doc)) { ?>

										<div class="fu_uploaded_exc">

											<a href="<?= base_url($pathurl . $fuser_detailset->fu_exc_doc) ?>" target="_blank"> Document</a>

										</div>

									<?php } ?>

								</div>

							</div>

						</div>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mt-5 mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_exempted');">Submit</button>

							</div>

						
						<?php } ?>
					</div>
			</div>
		<?php }
		if(in_array("fu_exservice", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step12">
					<div class="row mt-3">
						<?php if(in_array("fu_exservice", $reject_type_arr)){ ?>
						<div class="col-sm-2">Ex Serviceman Category :</div>

						<div class="col-sm-10">
							<div class="row pl-2">

								<div class="col-sm-2 pl-4">Description :</div>

								<div class="col-sm-4">

									<textarea class="form-control" rows="2" id="fu_exs_reason" name="fu_exs_reason"><?= $fuser_detailset->fu_exs_reason ?></textarea>

									<small class="text-error fu_exs_reason"><?php echo form_error('fu_exs_reason'); ?></small>

								</div>

								<div class="col-sm-2">Upload Doc :</div>

								<div class="col-sm-4">

									<input type="file" name="fu_exs_doc" class="form-control">

									<small class="text-error fu_exs_doc"><?php echo form_error('fu_exs_doc'); ?></small>

									<?php if (isset($fuser_detailset->fu_exs_doc) && !empty($fuser_detailset->fu_exs_doc)) { ?>

										<div class="fu_uploaded_exservice">

											<a href="<?= base_url($pathurl . $fuser_detailset->fu_exs_doc) ?>" target="_blank">Ex Service Document</a>

										</div>

									<?php } ?>

								</div>

							</div>


						</div>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mt-5 mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_exservice');">Submit</button>

							</div>

						
						<?php } ?>
					</div>
			</div>
		<?php }
		if(in_array("fu_ews", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step13">
					<div class="row mt-3">
						<?php if(in_array("fu_ews", $reject_type_arr)){ ?>
						<div class="col-sm-2">Sports Man Category :</div>

						<div class="col-sm-10">

							<div class="row pl-2">

								<div class="col-sm-2 pl-4">Description :</div>

								<div class="col-sm-4">

									<textarea class="form-control" rows="2" id="fu_ews_reason" name="fu_ews_reason"><?= $fuser_detailset->fu_ews_reason ?></textarea>

									<small class="text-error fu_ews_reason"><?php echo form_error('fu_ews_reason'); ?></small>

								</div>

								<div class="col-sm-2">Upload Doc :</div>

								<div class="col-sm-4">

									<input type="file" name="fu_ews_doc" class="form-control">

									<small class="text-error fu_ews_doc"><?php echo form_error('fu_ews_doc'); ?></small>

									<?php if (isset($fuser_detailset->fu_ews_doc) && !empty($fuser_detailset->fu_ews_doc)) { ?>

										<div class="fu_uploaded_ews">

											<a href="<?= base_url($pathurl . $fuser_detailset->fu_ews_doc) ?>" target="_blank">Sports Man Document</a>

										</div>

									<?php } ?>

								</div>

							</div>


						</div>

						

							<div class="col-sm-12 text-center">

								<div align="center">

									<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

								</div>

							</div>

						

							<div class="col-sm-12 text-center mt-5 mb-5">

								<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_ews');">Submit</button>

							</div>

						
						<?php } ?>
					</div>
			</div>
		<?php }
		if(in_array("fu_dob", $reject_type_arr)){ ?>

			<div class="step-tab-panel" data-step="step14">
					<div class="row mt-3">
						<?php if(in_array("fu_dob", $reject_type_arr)){ ?>
							<div class="col-sm-2">Date of Birth :</div>
							<div class="col-sm-4">
								<input type="date" class="form-control" name="fu_dob" id="fu_dob" autocomplete="off" value="<?= $fuser_detailset->fu_dob ?>" />
								<small class="text-error fu_dob"><?php echo form_error('fu_dob'); ?></small>
							</div>
							<div class="col-sm-2">Date of Birth Proof Document :</div>
							<div class="col-sm-4">
								<input type="file" name="fu_dob_doc" id="fu_dob_doc" class="form-control" autocomplete="off" />
								<small class="">File format should be in .png/.jpg/.jpeg/.pdf format</small>
								<small class="">Maximum file size is 2 MB </small>
								<small class="text-error fu_dob_doc"><?php echo form_error('fu_dob_doc'); ?></small>
								<?php if (isset($fuser_detailset->fu_dob_doc) && !empty($fuser_detailset->fu_dob_doc)) { ?>
								<div class="fu_uploaded_dob">
									<a href="<?= base_url($pathurl . $fuser_detailset->fu_dob_doc) ?>" target="_blank">Birth Proof Document</a>
								</div>
								<?php } ?>
							</div>
						
							

								<div class="col-sm-12 text-center">

									<div align="center">

										<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

										<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

										<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

									</div>

								</div>

							

								<div class="col-sm-12 text-center mt-5 mb-5">

									<button class="btn btn-primary step-btn button_submit" onclick="all_resubmit_step('fu_dob');">Submit</button>

								</div>

							
						
						
						<?php } ?>
					</div>

					
			</div>
		<?php } ?>

		</div>


	</div>

</div>

<?php $this->load->view('main/component/footer'); ?>

<script src="<?php echo base_url(); ?>frontend/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>frontend/js/jquery-steps.js"></script>

<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
		$('.alert-error, .text-error').delay(8000).fadeOut();
		$('[data-toggle="tooltip"]').tooltip();
	});

	const delay = 8000;

	var error_message = 'There have some errors please check above, Try again.';

	const alphaletters_spaces = /^[A-Za-z ]+$/;

	const alphaletters = /^[A-Za-z]+$/;

	const alphanumerics = /^[A-Za-z0-9]+$/;

	const alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;

	const alphanumerics_no = /^[A-Za-z0-9_/&(@):.,%\- \n\r]+$/;

	const onlynumerics = /^[0-9]+$/;

	const onlynumerics_withdot = /^[0-9. ]+$/;

	const specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;

	const emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

	const allowedPic_Extensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;

	const allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;



	const imageFileMaxSize = 512000 // 500 KB

	const docFileMaxSize = 2097152 //2 MB
	
	$('#demo').steps({

		/*onFinish: function () {

		finisher_step();

		}*/

		startAt: 0

	});

	

		// ################################################################

		$('select[name="fu_state"]').on('change', function(event) {

			let fu_state = event.target.value;

			if (fu_state == 28) {


				$('.fu-district-div').show();
				$('select[name="fu_district"').prop('disabled', false);
				$('.fu-other-district-div').hide();

				$('.fu-sub-division-div').show();
				$('.fu-other-sub-division-div').hide();

				$('.fu-police-station-div').show();
				$('.fu-other-police-station-div').hide();

				$('.fu-block-municipality-div').show();
				$('.fu-other-block-municipality-div').hide();

			} else if (fu_state == "") {


				$('.fu-district-div').show();
				$('.fu-other-district-div').hide();

				$('.fu-sub-division-div').show();
				$('.fu-other-sub-division-div').hide();

				$('.fu-police-station-div').show();
				$('.fu-other-police-station-div').hide();

				$('.fu-block-municipality-div').show();
				$('.fu-other-block-municipality-div').hide();


				let sub_div_html = "<option value=''>---Select---</option>";
				let ps_html = "<option value=''>---Select---</option>";

				$('select[name="fu_district"]').val('');
				$('select[name="fu_sub_division"]').html(sub_div_html);
				$('select[name="fu_police_station"]').html(ps_html);

				$('select[name="fu_block_municipality"]').html("<option value=''>---Select---</option>");

				$('input[name="fu_mb_type"]').prop('disabled', true);
				$('select[name="fu_district"').prop('disabled', true);
				$('select[name="fu_sub_division"]').prop('disabled', true);
				$('select[name="fu_police_station"]').prop('disabled', true);

				$('input[name="fu_mb_type"]:checked').prop('checked', false);
			} else {

				$('.fu-district-div').hide();
				$('.fu-other-district-div').show();

				$('.fu-sub-division-div').hide();
				$('.fu-other-sub-division-div').show();

				$('.fu-police-station-div').hide();
				$('.fu-other-police-station-div').show();

				$('.fu-block-municipality-div').hide();
				$('.fu-other-block-municipality-div').show();
			}
		})

		$('select[name="fu_district"').on('change', function(event) {

			let fu_district = event.target.value;

			if (fu_district == '') {

				$('select[name="fu_sub_division"]').prop('disabled', true);
				$('select[name="fu_police_station"]').prop('disabled', true);

				$('select[name="fu_sub_division"]').html('');
				$('select[name="fu_police_station"]').html('');
				$('select[name="fu_block_municipality"]').html("<option value=''>---Select---</option>");

				let sub_div_html = "<option value=''>---Select---</option>";
				let ps_html = "<option value=''>---Select---</option>";

				$('select[name="fu_sub_division"]').html(sub_div_html);
				$('select[name="fu_police_station"]').html(ps_html);

				$('input[name="fu_mb_type"]').prop('disabled', true);
				$('input[name="fu_mb_type"]:checked').prop('checked', false);
			} else {
				if(fu_district == 342){
					$('select[name="fu_sub_division"]').prop('disabled', true);
					$('select[name="fu_police_station"]').prop('disabled', false);

					$('input[name="fu_mb_type"]').prop('disabled', true);
					$('input[name="fu_mb_type"]:checked').prop('checked', false);
				}else{
					$('select[name="fu_sub_division"]').prop('disabled', false);
					$('select[name="fu_police_station"]').prop('disabled', false);

					$('input[name="fu_mb_type"]').prop('disabled', true);
					$('input[name="fu_mb_type"]:checked').prop('checked', false);
				}
				$('select[name="fu_block_municipality"]').html("<option value=''>---Select---</option>");

				let form_data = new FormData();

				form_data.append('fu_district', fu_district);

				$.ajax({
					url: '<?= base_url("member/get_sub_div_ps") ?>',
					method: "POST",
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {

						//console.log(data);
						$('select[name="fu_sub_division"]').html('');
						$('select[name="fu_police_station"]').html('');

						let sub_div_html = "<option value=''>---Select---</option>";
						let ps_html = "<option value=''>---Select---</option>";

						for (let i = 0; i < data.sub_division.length; i++) {

							sub_div_html += ` 
              <option value="${data.sub_division[i].subdiv_id}">${data.sub_division[i].subdiv_name}</option>
            `;
						}

						$('select[name="fu_sub_division"]').html(sub_div_html);

						for (let i = 0; i < data.police_station.length; i++) {

							ps_html += ` 
              <option value="${data.police_station[i].ps_id}">${data.police_station[i].ps_name}</option>
            `;
						}

						$('select[name="fu_police_station"]').html(ps_html);
					}
				});
			}

		});

		$('select[name="fu_sub_division"]').on('change', function(event) {

			let fu_sub_division = event.target.value;

			if (fu_sub_division == '') {

				$('input[name="fu_mb_type"]').prop('disabled', true);
				$('select[name="fu_block_municipality"]').html('');
			} else {

				$('input[name="fu_mb_type"]').prop('disabled', false);
				$('input[name="fu_mb_type"]:checked').prop('checked', false);
				$('select[name="fu_block_municipality"]').html("<option value=''>---Select---</option>");
			}


		})

		$('input[name="fu_mb_type"]').on('click', function(event) {


			let fu_mb_type = event.target.value;

			let fu_sub_division = $('select[name="fu_sub_division"]').val();

			let form_data = new FormData();

			form_data.append('fu_mb_type', fu_mb_type);

			form_data.append('fu_sub_division', fu_sub_division);

			$.ajax({
				url: '<?= base_url("member/get_block_municipality") ?>',
				method: "POST",
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {


					$('select[name="fu_block_municipality"]').html("<option value=''>---Select---</option>");

					let block_html = "<option value=''>---Select---</option>";

					for (let i = 0; i < data.length; i++) {

						block_html += ` 
              <option value="${data[i].block_id}">${data[i].block_name}</option>
            `;
					}

					$('select[name="fu_block_municipality"]').html(block_html);;
				}
			});
		});

		function address_tick_check(){
			//alert('ok');
			if($('#all_same_address').is(":checked"))
				$(".per_address_class").fadeOut();
			else
				$(".per_address_class").fadeIn();
		}
		
		// ################################################################
		$('select[name="fu_per_state"]').on('change', function(event) {

			let fu_state = event.target.value;

			if (fu_state == 28) {
				
				$('.fu-per-district-div').show();
				$('select[name="fu_per_district"').prop('disabled', false);
				$('.fu-per-other-district-div').hide();

				$('.fu-per-sub-division-div').show();
				$('.fu-per-other-sub-division-div').hide();

				$('.fu-per-police-station-div').show();
				$('.fu-per-other-police-station-div').hide();

				$('.fu-per-block-municipality-div').show();
				$('.fu-per-other-block-municipality-div').hide();

			} else if (fu_state == "") {

				$('.fu-per-district-div').show();
				$('.fu-per-other-district-div').hide();

				$('.fu-per-sub-division-div').show();
				$('.fu-per-other-sub-division-div').hide();

				$('.fu-per-police-station-div').show();
				$('.fu-per-other-police-station-div').hide();

				$('.fu-per-block-municipality-div').show();
				$('.fu-per-other-block-municipality-div').hide();

				let sub_div_html = "<option value=''>---Select---</option>";
				let ps_html = "<option value=''>---Select---</option>";

				$('select[name="fu_per_district"]').val('');
				$('select[name="fu_per_sub_division"]').html(sub_div_html);
				$('select[name="fu_per_police_station"]').html(ps_html);

				$('select[name="fu_per_block_municipality"]').html("<option value=''>---Select---</option>");

				$('input[name="fu_per_mb_type"]').prop('disabled', true);
				$('select[name="fu_per_district"').prop('disabled', true);
				$('select[name="fu_per_sub_division"]').prop('disabled', true);
				$('select[name="fu_per_police_station"]').prop('disabled', true);

				$('input[name="fu_per_mb_type"]:checked').prop('checked', false);
			
			} else {

				$('.fu-per-district-div').hide();
				$('.fu-per-other-district-div').show();

				$('.fu-per-sub-division-div').hide();
				$('.fu-per-other-sub-division-div').show();

				$('.fu-per-police-station-div').hide();
				$('.fu-per-other-police-station-div').show();

				$('.fu-per-block-municipality-div').hide();
				$('.fu-per-other-block-municipality-div').show();
			}
		});

		$('select[name="fu_per_district"').on('change', function(event) {

			let fu_district = event.target.value;

			if (fu_district == '') {

				$('select[name="fu_per_sub_division"]').prop('disabled', true);
				$('select[name="fu_per_police_station"]').prop('disabled', true);

				$('select[name="fu_per_sub_division"]').html('');
				$('select[name="fu_per_police_station"]').html('');
				$('select[name="fu_per_block_municipality"]').html("<option value=''>---Select---</option>");

				let sub_div_html = "<option value=''>---Select---</option>";
				let ps_html = "<option value=''>---Select---</option>";

				$('select[name="fu_per_sub_division"]').html(sub_div_html);
				$('select[name="fu_per_police_station"]').html(ps_html);

				$('input[name="fu_per_mb_type"]').prop('disabled', true);
				$('input[name="fu_per_mb_type"]:checked').prop('checked', false);
			} else {

				if(fu_district == 342){
					$('select[name="fu_per_sub_division"]').prop('disabled', true);
					$('select[name="fu_per_police_station"]').prop('disabled', false);
					$('input[name="fu_per_mb_type"]').prop('disabled', true);
					$('input[name="fu_per_mb_type"]:checked').prop('checked', false);
				}else{
					$('select[name="fu_per_sub_division"]').prop('disabled', false);
					$('select[name="fu_per_police_station"]').prop('disabled', false);

					$('input[name="fu_per_mb_type"]').prop('disabled', true);
					$('input[name="fu_per_mb_type"]:checked').prop('checked', false);
				}
				

				$('select[name="fu_per_block_municipality"]').html("<option value=''>---Select---</option>");

				let form_data = new FormData();

				form_data.append('fu_district', fu_district);

				$.ajax({
					url: '<?= base_url("member/get_sub_div_ps") ?>',
					method: "POST",
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {

						//console.log(data);
						$('select[name="fu_per_sub_division"]').html('');
						$('select[name="fu_per_police_station"]').html('');

						let sub_div_html = "<option value=''>---Select---</option>";
						let ps_html = "<option value=''>---Select---</option>";

						for (let i = 0; i < data.sub_division.length; i++) {

											sub_div_html += ` 
							<option value="${data.sub_division[i].subdiv_id}">${data.sub_division[i].subdiv_name}</option>
							`;
						}

						$('select[name="fu_per_sub_division"]').html(sub_div_html);

						for (let i = 0; i < data.police_station.length; i++) {

											ps_html += ` 
							<option value="${data.police_station[i].ps_id}">${data.police_station[i].ps_name}</option>
							`;
						}

						$('select[name="fu_per_police_station"]').html(ps_html);
					}
				});
			}

		});

		$('select[name="fu_per_sub_division"]').on('change', function(event) {

			let fu_sub_division = event.target.value;

			if (fu_sub_division == '') {

				$('input[name="fu_per_mb_type"]').prop('disabled', true);
				$('select[name="fu_per_block_municipality"]').html('');
			} else {

				$('input[name="fu_per_mb_type"]').prop('disabled', false);
				$('input[name="fu_per_mb_type"]:checked').prop('checked', false);
				$('select[name="fu_per_block_municipality"]').html("<option value=''>---Select---</option>");
			}


		});

		$('input[name="fu_per_mb_type"]').on('click', function(event) {


			let fu_mb_type = event.target.value;

			let fu_sub_division = $('select[name="fu_per_sub_division"]').val();

			let form_data = new FormData();

			form_data.append('fu_mb_type', fu_mb_type);

			form_data.append('fu_sub_division', fu_sub_division);

			$.ajax({
				url: '<?= base_url("member/get_block_municipality") ?>',
				method: "POST",
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {


					$('select[name="fu_per_block_municipality"]').html("<option value=''>---Select---</option>");

					let block_html = "<option value=''>---Select---</option>";

					for (let i = 0; i < data.length; i++) {

						block_html += ` 
						<option value="${data[i].block_id}">${data[i].block_name}</option>
						`;
					}

					$('select[name="fu_per_block_municipality"]').html(block_html);
				}
			});
		});

		//$('input[name="fu_caste_type"]').on('input', function(event) {
		$('select[name="fu_caste_type"]').on('change', function(event) {

			//$('select[name="fu_caste_community"]').prop('disabled', false);

			let caste_type = event.target.value;

			let form_data = new FormData();

			form_data.append('caste_type', caste_type);

			$.ajax({
				url: '<?= base_url("member/get_caste_details_v2") ?>',
				method: 'POST',
				data: form_data,
				dataType: 'JSON',
				processData: false,
				contentType: false,
				success: function(data) {

					//console.log(data);
					if(data.msg == 1){

						$('#com_castetypeset').val(data.castetype.caste_cat);
						$('#com_attachdoc_set').val(data.castetype.caste_attach);
						if(data.castetype.caste_cat == 2){

							let options = `<option value="">--SELECT--</option>`;

							for (let i = 0; i < data.castesets.length; i++) {

								options += `
									<option value=${data.castesets[i].csdetail_id}>${data.castesets[i].csdetail_name}</option>
								`;
							}

							$('select[name="fu_caste_community"]').html(options);
							$('select[name="fu_caste_community"]').prop('disabled', false);
							$('.community_casteset').fadeIn();

						}else{

							let options = `<option value="">--SELECT--</option>`;
							$('select[name="fu_caste_community"]').html(options);
							$('select[name="fu_caste_community"]').prop('disabled', true);
							$('.community_casteset').fadeOut();

						}

					}else{

						$('#com_castetypeset').val('');
						let options = `<option value="">--SELECT--</option>`;
						$('select[name="fu_caste_community"]').html(options);
						$('select[name="fu_caste_community"]').prop('disabled', true);
						$('.community_casteset').fadeOut();

					}

				}
			});

		});


		var examsID = [];

		var examsName = [];

		var usersQuali = [];

		var exam = [];

		var states = [];

		var quali = <?php echo count($fuser_quali) ?>;

		<?php foreach ($state_list as $states) { ?>

			states["<?php echo $states->state_id; ?>"] = '<?php echo $states->state_name; ?>'

		<?php } ?>

		$('input[name="marks_obtained"]').on('input', function(event) {

			let full_marks = $('input[name="marks_full"').val();
			let obtained_marks = $('input[name="marks_obtained"]').val();


			if ((full_marks != "" && obtained_marks != "")) {

				if (obtained_marks != NaN && full_marks != NaN) {

					if (parseInt(full_marks) < parseInt(obtained_marks)) {
						// show error
						$('.text-error').fadeIn();
						$('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
						$('input[name="marks_percent"').val('');
						return;
					} else {
						$('.marks_obtained').html('');
					}
					var percentchk = ((parseInt(obtained_marks) / parseInt(full_marks)) * 100);
					var percent_update = percentchk.toFixed(2);
					$('input[name="marks_percent"').val(percent_update);
				}
			} else {
				$('input[name="marks_percent"').val('');
			}
		});

		$('input[name="marks_full"]').on('input', function(event) {

			let full_marks = $('input[name="marks_full"').val();
			let obtained_marks = $('input[name="marks_obtained"]').val();


			if ((full_marks != "" && obtained_marks != "")) {

				if (obtained_marks != NaN && full_marks != NaN) {

					if (parseInt(full_marks) < parseInt(obtained_marks)) {
						// show error
						$('.text-error').fadeIn();
						$('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
						$('input[name="marks_percent"').val('');
						return;
					} else {
						$('.marks_obtained').html('');
					}
					var percentchk = ((parseInt(obtained_marks) / parseInt(full_marks)) * 100);
					var percent_update = percentchk.toFixed(2);
					$('input[name="marks_percent"').val(percent_update);
				}
			} else {
				$('input[name="marks_percent"').val('');
			}
		});

		var totalexam = parseInt('<?php echo count($es_quali_arr); ?>');
		var totalds_exam = parseInt('<?php echo count($ds_quali_arr); ?>');
		var totalexp = parseInt('<?php echo count($es_serv_arr); ?>');
		var totalds_exp = parseInt('<?php echo count($ds_serv_arr); ?>');

		function des_percentcheck_exm(){
			var des_marks_obtained_set = $("input[name='des_marks_obtained_set']").val();
			var des_marks_full_set = $("input[name='des_marks_full_set']").val();
			var des_marks_percent_set = $("input[name='des_marks_percent_set']").val();
			
			if(des_marks_obtained_set != "" && des_marks_full_set != ""){
				if(!isNaN(des_marks_obtained_set) && !isNaN(des_marks_full_set)){
					if(parseInt(des_marks_full_set) >= parseInt(des_marks_obtained_set)){
						var updatemarks_percent = parseFloat((parseInt(des_marks_obtained_set) * 100)/ parseInt(des_marks_full_set)).toFixed(2);
						$("input[name='des_marks_percent_set']").val(updatemarks_percent);
					}else{
						$("input[name='des_marks_percent_set']").val('');
					}
				}else{
					$("input[name='des_marks_percent_set']").val('');
				}
			}else{
				$("input[name='des_marks_percent_set']").val('');
			}	
		}

		function gotosubmit_desquali_set(){
			$('.div_roller_total55').fadeIn();
			var delay = 5000;
			var e_error = 0;
			var error_message = '';
			var des_exam_name = $("select[name='des_exam_name'] option:selected").val();
			var des_univ_set = $("input[name='des_univ_set']").val();
			var des_state_set = $("select[name='des_state_set'] option:selected").val();
			var des_marks_obtained_set = $("input[name='des_marks_obtained_set']").val();
			var des_marks_full_set = $("input[name='des_marks_full_set']").val();
			var des_marks_percent_set = $("input[name='des_marks_percent_set']").val();
			var des_add_attempt_set = $("select[name='des_add_attempt_set'] option:selected").val();
			var des_add_attempt_no_set = $("input[name='des_add_attempt_no_set']").val();
			var des_marksheet_set = $("input[name='des_marksheet_set']")[0].files;

			if(des_exam_name == ""){
				e_error = 1;
				$('.des_exam_name').html('Exam is Required');
			}else{
				$('.des_exam_name').html('');
			}
			if(des_univ_set == ""){
				e_error = 1;
				$('.des_univ_set').html('Field is Required');
			}else{
				$('.des_univ_set').html('');
			}
			if(des_state_set == ""){
				e_error = 1;
				$('.des_state_set').html('State is Required');
			}else{
				$('.des_state_set').html('');
			}
			if(des_marks_obtained_set == ""){
				e_error = 1;
				$('.des_marks_obtained_set').html('Marks Obtained is Required');
			}else{
				if (!des_marks_obtained_set.match(onlynumerics)) {
					e_error = 1;
					$('.des_marks_obtained_set').html('Marks Obtained use only Numeric Value');
				}else if(parseInt(des_marks_obtained_set) <= 0){
					e_error = 1;
					$('.des_marks_obtained_set').html('Marks Obtained always greater than 0');
				}else{
					$('.des_marks_obtained_set').html('');
				}
			}
			if(des_marks_full_set == ""){
				e_error = 1;
				$('.des_marks_full_set').html('Full Marks is Required');
			}else{
				if (!des_marks_full_set.match(onlynumerics)) {
					e_error = 1;
					$('.des_marks_full_set').html('Full Marks use only Numeric Value');
				}else if(parseInt(des_marks_full_set) <= 0){
					e_error = 1;
					$('.des_marks_full_set').html('Full Marks always greater than 0');
				}else{
					$('.des_marks_full_set').html('');
				}
			}
			if(des_marks_percent_set == ""){
				e_error = 1;
				$('.des_marks_percent_set').html('Percentage Marks is Required');
			}else{
				if (!des_marks_percent_set.match(onlynumerics_withdot)) {
					e_error = 1;
					$('.des_marks_percent_set').html('Percentage Marks use only Numeric Value');
				}else if(parseFloat(des_marks_percent_set) <= 0){
					e_error = 1;
					$('.des_marks_percent_set').html('Percentage Marks always greater than 0');
				}else{
					$('.des_marks_percent_set').html('');
				}
			}
			if(des_add_attempt_set == ""){
				e_error = 1;
				$('.des_add_attempt_set').html('Additional Attempt is Required');
			}else{
				$('.des_add_attempt_set').html('');
				if(des_add_attempt_set == "Yes"){
					if(des_add_attempt_no_set == ""){
						e_error = 1;
						$('.des_add_attempt_no_set').html('Attempt Number is Required');
					}else{
						if (!des_add_attempt_no_set.match(onlynumerics)) {
							e_error = 1;
							$('.des_add_attempt_no_set').html('Attempt Number use only Numeric Value');
						}else if(parseInt(des_add_attempt_no_set) <= 0){
							e_error = 1;
							$('.des_add_attempt_no_set').html('Attempt Number always greater than 0');
						}else{
							$('.des_add_attempt_no_set').html('');
						}
					}
				}else{
					$('.des_add_attempt_no_set').html('');
				}
			}
			if(!isNaN(des_marks_obtained_set) && !isNaN(des_marks_full_set) && des_marks_obtained_set != "" && des_marks_full_set != ""){
				if(parseInt(des_marks_obtained_set) > parseInt(des_marks_full_set)){
					e_error = 1;
					$('.des_marks_obtained_set').html('Marks Obtained never cross the full Marks');
				}else{
					$('.des_marks_obtained_set').html('');
				}
			}
			if (document.getElementById("des_marksheet_set").files.length == 0) {
				e_error = 1;
				$('.des_marksheet_set').html('Upload Certificate is Required.');
			} else {
				var fileInput = document.getElementById('des_marksheet_set');
				var filePath = fileInput.value;
				if (!allowedExtensions.exec(filePath)) {
					e_error = 1;
					$('.des_marksheet_set').html('Upload Certificate type Invalid.(Use PDF/Image)');
				} else {
					$('.des_marksheet_set').html('');
				}
			}
			
			if (e_error == 1) {
				$('.div_roller_total55').fadeOut();
				$('.get_error_total55').html(error_message);
				if(error_message != ""){
					$(".get_error_total55").fadeIn();
				}
				$(".text-error").fadeIn();
				/*e_error = 0;
				error_message = '';*/
				setTimeout(function() {
					$('.text-error, .get_error_total55').fadeOut();
				}, delay);
			} else {
				var form_data = new FormData();
				form_data.append('des_exam_name', des_exam_name);
				form_data.append('des_univ_set', des_univ_set);
				form_data.append('des_state_set', des_state_set);
				form_data.append('des_marks_obtained_set', des_marks_obtained_set);
				form_data.append('des_marks_full_set', des_marks_full_set);
				form_data.append('des_marks_percent_set', des_marks_percent_set);
				form_data.append('des_add_attempt_set', des_add_attempt_set);
				form_data.append('des_add_attempt_no_set', des_add_attempt_no_set);
				form_data.append("files", des_marksheet_set[0]);
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "member/add_desirequalification_update"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total55').fadeOut();
							$('.get_success_total55').html('Desirable Qualification is added Successfully.');
							$(".get_success_total55").fadeIn();
							var urlset = '<?php echo base_url($pathurl); ?>';
							var exp_string = '<tr class="desq_set_' + data.cat_set.fud_quali_id + '"><td>' + data.cat_set.qm_name + '</td><td>' + data.cat_set.fud_council_board + '</td><td>' + data.cat_set.state_name + '</td><td>' + data.cat_set.fud_marks_obtained + '</td><td>' + data.cat_set.fud_full_marks + '</td><td>' + data.cat_set.fud_percent_of_marks + '</td><td>' + data.cat_set.fud_is_attempt + '</td><td>' + data.cat_set.fud_attempt_no + '</td><td><a href="'+urlset+data.cat_set.fud_quali_docs+'" target="_blank">Attached Certificate</a></td><td><a href="javascript:;" onclick="gotodelete_des_quali(' + data.cat_set.fud_quali_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
							$('.desquali_setvalue').append(exp_string);
							var des_q_counter = $('#des_q_counter').val();
							des_q_counter = Number(des_q_counter) + 1;
							$('#des_q_counter').val(des_q_counter);
							$('#des_exam_name, #des_univ_set, #des_state_set, #des_marks_obtained_set, #des_marks_full_set, #des_marks_percent_set, #des_add_attempt_no_set, #des_marksheet_set').val('');
							setTimeout(function() {
								$('.get_success_total55').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total55').fadeOut();
							//error_message = "There have some problem to Update Data, Try again.";
							error_message = data.e_msg;
							$('.get_error_total55').html(error_message);
							$(".get_error_total55").fadeIn();
							setTimeout(function() {
								$('.get_error_total55').fadeOut();
							}, 3000);
						}

					}
				});
			}
		}

		function gotosubmit_exp_set(){
			$('.div_roller_total5').fadeIn();
			var delay = 5000;
			var e_error = 0;
			var error_message = '';
			var regno = '<?php echo $fuser_detailset->f_application_no; ?>';
			var exp_name = $('#exp_name option:selected').val();
			var exp_org = $('#exp_org').val();
			var exp_year = $('#exp_year').val();
			var exp_month = $('#exp_month').val();
			var exp_docs = $('#exp_docs')[0].files;
			if (regno == "") {
				error_message = error_message + "<br/>ID missing, Refresh the page";
			}
			if (exp_name == "") {
				e_error = 1;
				$('.exp_name').html('Experience Category is Required.');
			} else {
				if (!exp_name.match(onlynumerics)) {
					e_error = 1;
					$('.exp_name').html('Experience Category only use Numeric values, Check again.');
				} else {
					$('.exp_name').html('');
				}
			}
			if (exp_org == "") {
				e_error = 1;
				$('.exp_org').html('Organization is Required.');
			} else {
				if (!exp_org.match(alphanumerics_spaces)) {
					e_error = 1;
					$('.exp_org').html('Organization only use Alphanumeric values with [ _ , - ], Check again.');
				} else {
					$('.exp_org').html('');
				}
			}
			if (exp_year == "") {
				e_error = 1;
				$('.exp_year').html('Year is Required.');
			} else {
				if (!exp_year.match(onlynumerics)) {
					e_error = 1;
					$('.exp_year').html('Year only use numeric values, Check again.');
				} else {
					$('.exp_year').html('');
				}
			}
			if (exp_month == "") {
				e_error = 1;
				$('.exp_month').html('Month is Required.');
			} else {
				if (!exp_month.match(onlynumerics)) {
					e_error = 1;
					$('.exp_month').html('Month only use numeric values, Check again.');
				} else {
					$('.exp_month').html('');
				}
			}
			if(exp_year != "" && exp_month != ""){
				if(parseInt(exp_year) == 0 && parseInt(exp_month) == 0){
					e_error = 1;
					error_message = error_message + "<br/>Period Both 0 not Allowed here, Check Again.";
				}
			}
			if (document.getElementById("exp_docs").files.length == 0) {
				e_error = 1;
				$('.exp_docs').html('Upload Certificate is Required.');
			} else {
				var fileInput = document.getElementById('exp_docs');
				var filePath = fileInput.value;
				if (!allowedExtensions.exec(filePath)) {
					e_error = 1;
					$('.exp_docs').html('Upload Certificate type Invalid.(Use PDF/Image)');
				} else {
					$('.exp_docs').html('');
				}
			}
			
			if (e_error == 1) {
				$('.div_roller_total5').fadeOut();
				$('.get_error_total5').html(error_message);
				if(error_message != ""){
					$(".get_error_total5").fadeIn();
				}
				$(".text-error").fadeIn();
				/*e_error = 0;
				error_message = '';*/
				setTimeout(function() {
					$('.text-error, .get_error_total5').fadeOut();
				}, delay);
			} else {
				var form_data = new FormData();
				form_data.append('regno', regno);
				form_data.append('exp_name', exp_name);
				form_data.append('exp_org', exp_org);
				form_data.append('exp_year', exp_year);
				form_data.append('exp_month', exp_month);
				form_data.append("files", exp_docs[0]);
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "member/add_experience_update"; ?>',
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
							$('.get_success_total5').html('Desirable Experience is added Successfully.');
							$(".get_success_total5").fadeIn();
							var urlset = '<?php echo base_url($pathurl); ?>';
							var exp_string = '<tr class="catset_' + data.cat_set.fu_exp_id + '"><td>' + data.cat_set.expset_name + '</td><td>' + data.cat_set.fu_exp_org_name + '</td><td>' + data.cat_set.fu_exp_year + ' Year & ' + data.cat_set.fu_exp_month + ' Month</td><td><a href="'+urlset+data.cat_set.fu_exp_marksheet_doc+'" target="_blank">Attached Certificate</a></td><td><a href="javascript:;" onclick="gotodelete_exp(' + data.cat_set.fu_exp_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
							$('.exp_setvalue').append(exp_string);
							var exp_counter = $('#exp_counter').val();
							exp_counter = Number(exp_counter) + 1;
							$('#exp_counter').val(exp_counter);
							//month calculation
							var cur_monthset = $('#desireexp_reach_month_'+data.cat_set.fu_exp_workname).val();
							cur_monthset = parseInt(cur_monthset) + parseInt(data.cat_set.fu_exp_year * 12) + parseInt(data.cat_set.fu_exp_month);
							$('#desireexp_reach_month_'+data.cat_set.fu_exp_workname).val(cur_monthset);
							//month calculation
							$('#exp_name, #exp_org, #exp_year, #exp_month, #exp_docs').val('');
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

		function gotosubmit_ess_exp_set(srno){
			//alert(srno);
			if(srno != ""){
				var slno = parseInt(srno);
				$('.div_roller_total05_'+slno).fadeIn();
				var delay = 5000;
				var e_error = 0;
				var error_message = '';
				var regno = '<?php echo $fuser_detailset->f_application_no; ?>';
				var exp_name = $('#ess_exp_name_'+slno+' option:selected').val();
				var exp_org = $('#ess_exp_org_'+slno).val();
				var exp_year = $('#ess_exp_year_'+slno).val();
				var exp_month = $('#ess_exp_month_'+slno).val();
				var exp_docs = $('#ess_exp_docs_'+slno)[0].files;
				if (regno == "") {
					error_message = error_message + "<br/>ID missing, Refresh the page";
				}
				if (exp_name == "") {
					e_error = 1;
					$('.ess_exp_name_'+slno).html('Experience Category is Required.');
				} else {
					if (!exp_name.match(onlynumerics)) {
						e_error = 1;
						$('.ess_exp_name_'+slno).html('Experience Category only use Numeric values, Check again.');
					} else {
						$('.ess_exp_name_'+slno).html('');
					}
				}
				if (exp_org == "") {
					e_error = 1;
					$('.ess_exp_org_'+slno).html('Organization is Required.');
				} else {
					if (!exp_org.match(alphanumerics_spaces)) {
						e_error = 1;
						$('.ess_exp_org_'+slno).html('Organization only use Alphanumeric values with [ _ , - ], Check again.');
					} else {
						$('.ess_exp_org_'+slno).html('');
					}
				}
				if (exp_year == "") {
					e_error = 1;
					$('.ess_exp_year_'+slno).html('Year is Required.');
				} else {
					if (!exp_year.match(onlynumerics)) {
						e_error = 1;
						$('.ess_exp_year_'+slno).html('Year only use numeric values, Check again.');
					} else {
						$('.ess_exp_year_'+slno).html('');
					}
				}
				if (exp_month == "") {
					e_error = 1;
					$('.ess_exp_month_'+slno).html('Month is Required.');
				} else {
					if (!exp_month.match(onlynumerics)) {
						e_error = 1;
						$('.ess_exp_month_'+slno).html('Month only use numeric values, Check again.');
					} else {
						$('.ess_exp_month_'+slno).html('');
					}
				}
				if(exp_year != "" && exp_month != ""){
					if(parseInt(exp_year) == 0 && parseInt(exp_month) == 0){
						e_error = 1;
						error_message = error_message + "<br/>Period Both 0 not Allowed here, Check Again.";
					}
				}
				if (document.getElementById('ess_exp_docs_'+slno).files.length == 0) {
					e_error = 1;
					$('.ess_exp_docs_'+slno).html('Upload Certificate is Required.');
				} else {
					var fileInput = document.getElementById('ess_exp_docs_'+slno);
					var filePath = fileInput.value;
					if (!allowedExtensions.exec(filePath)) {
						e_error = 1;
						$('.ess_exp_docs_'+slno).html('Upload Certificate type Invalid.(Use PDF/Image)');
					} else {
						$('.ess_exp_docs_'+slno).html('');
					}
				}
				
				if (e_error == 1) {
					$('.div_roller_total05_'+slno).fadeOut();
					$('.get_error_total05_'+slno).html(error_message);
					if(error_message != ""){
						$(".get_error_total05_"+slno).fadeIn();
					}
					$(".text-error").fadeIn();
					/*e_error = 0;
					error_message = '';*/
					setTimeout(function() {
						$('.text-error, .get_error_total05_'+slno).fadeOut();
					}, delay);
				} else {
					var form_data = new FormData();
					form_data.append('regno', regno);
					form_data.append('exp_serial', slno);
					form_data.append('exp_name', exp_name);
					form_data.append('exp_org', exp_org);
					form_data.append('exp_year', exp_year);
					form_data.append('exp_month', exp_month);
					form_data.append("files", exp_docs[0]);
					$.ajax({
						method: 'POST',
						url: '<?php echo base_url() . "member/add_ess_experience_update"; ?>',
						data: form_data,
						dataType: 'JSON',
						contentType: false,
						processData: false,
						success: function(data) {
							//alert(data.msg);
							if (data.msg == 1) {
								//console.log(data);
								//alert(data.msg[0].option_set);
								$('.div_roller_total05_'+slno).fadeOut();
								$('.get_success_total05_'+slno).html('Essential Experience is added Successfully.');
								$(".get_success_total05_"+slno).fadeIn();
								var urlset = '<?php echo base_url($pathurl); ?>';
								var exp_string = '<tr class="essexp_set_' + data.cat_set.fues_exp_id + '"><td>' + data.cat_set.expset_name + '</td><td>' + data.cat_set.fues_exp_org_name + '</td><td>' + data.cat_set.fues_exp_year + ' Year & ' + data.cat_set.fues_exp_month + ' Month</td><td><a href="'+urlset+data.cat_set.fues_exp_marksheet_doc+'" target="_blank">Attached Certificate</a></td><td><a href="javascript:;" onclick="gotodelete_ess_exp(' + data.cat_set.fues_exp_id + ','+ slno +');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
								$('.exp_ess_set_'+slno).append(exp_string);
								var ess_exp_counter = $('#ess_exp_counter').val();
								ess_exp_counter = Number(ess_exp_counter) + 1;
								$('#ess_exp_counter').val(ess_exp_counter);
								//month calculation
								var cur_monthset = $('#ess_reach_month_'+slno).val();
								cur_monthset = parseInt(cur_monthset) + parseInt(data.cat_set.fues_exp_year * 12) + parseInt(data.cat_set.fues_exp_month);
								$('#ess_reach_month_'+slno).val(cur_monthset);
								//month calculation
								$('#ess_exp_name_'+slno+', #ess_exp_org_'+slno+', #ess_exp_year_'+slno+', #ess_exp_month_'+slno+', #ess_exp_docs_'+slno).val('');
								setTimeout(function() {
									$('.get_success_total05_'+slno).fadeOut();
								}, 3000);

							} else {
								$('.div_roller_total05_'+slno).fadeOut();
								//error_message = "There have some problem to Update Data, Try again.";
								error_message = data.e_msg;
								$('.get_error_total05_'+slno).html(error_message);
								$(".get_error_total05_"+slno).fadeIn();
								setTimeout(function() {
									$('.get_error_total05_'+slno).fadeOut();
								}, delay);
							}

						}
					});
				}
			}else{
				alert("ID not found, refresh the Page.");
			}
		}

		function gotodelete_ess_exp(expid, srno){
			if (expid != "" && srno != "") {
				var slno = parseInt(srno);
				var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
				if (conf_answer) {
					$('.div_roller_total05_'+slno).fadeIn();
					$.ajax({
						method: 'POST',
						url: '<?php echo base_url() . "member/delete_ess_experience_update"; ?>',
						data: {
							expid: expid, expslno: slno
						},
						dataType: 'JSON',
						success: function(data) {
							//alert(data.msg);
							if (data.msg == 1) {
								//console.log(data);
								//alert(data.msg[0].option_set);
								$('.div_roller_total05_'+slno).fadeOut();
								$('.get_success_total05_'+slno).html('Essential Experience is Deleted Successfully.');
								$(".get_success_total05_"+slno).fadeIn();
								var ess_exp_counter = $('#ess_exp_counter').val();
								ess_exp_counter = Number(ess_exp_counter) - 1;
								$('#ess_exp_counter').val(ess_exp_counter);
								//month calculation
								var cur_monthset = $('#ess_reach_month_'+slno).val();
								cur_monthset = parseInt(cur_monthset) - ((parseInt(data.cat_set.fues_exp_year) * 12) + parseInt(data.cat_set.fues_exp_month));
								$('#ess_reach_month_'+slno).val(cur_monthset);
								//month calculation
								$(".essexp_set_" + expid).remove();
								$('#ess_exp_name_'+slno+', #ess_exp_org_'+slno+', #ess_exp_year_'+slno+', #ess_exp_month_'+slno+', #ess_exp_docs_'+slno).val('');
								setTimeout(function() {
									$('.get_success_total05_'+slno).fadeOut();
								}, 3000);
							} else {
								$('.div_roller_total05_'+slno).fadeOut();
								error_message = "There have some problem to Update Data, Try again.";
								error_message = error_message + "<br/>" + data.e_msg;
								$('.get_error_total05_'+slno).html(error_message);
								$(".get_error_total05_"+slno).fadeIn();
								setTimeout(function() {
									$('.get_error_total05_'+slno).fadeOut();
								}, delay);
							}

						}
					});
				}
			}else{
				alert("Delete ID not found, refresh the Page.");
			}
		}

		function gotodelete_exp(expid){
			if (expid != "") {
				var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
				if (conf_answer) {
					$('.div_roller_total5').fadeIn();
					$.ajax({
						method: 'POST',
						url: '<?php echo base_url() . "member/delete_experience_update"; ?>',
						data: {
							expid: expid
						},
						dataType: 'JSON',
						success: function(data) {
							//alert(data.msg);
							if (data.msg == 1) {
								//console.log(data);
								//alert(data.msg[0].option_set);
								$('.div_roller_total5').fadeOut();
								$('.get_success_total5').html('Desirable Experience is Deleted Successfully.');
								$(".get_success_total5").fadeIn();
								var exp_counter = $('#exp_counter').val();
								exp_counter = Number(exp_counter) - 1;
								$('#exp_counter').val(exp_counter);
								//month calculation
								var cur_monthset = $('#desireexp_reach_month_'+data.cat_set.fu_exp_workname).val();
								cur_monthset = parseInt(cur_monthset) - (parseInt(data.cat_set.fu_exp_year * 12) + parseInt(data.cat_set.fu_exp_month));
								$('#desireexp_reach_month_'+data.cat_set.fu_exp_workname).val(cur_monthset);
								//month calculation
								$(".catset_" + expid).remove();
								$('#exp_name, #exp_org, #exp_year, #exp_month, #exp_docs').val('');
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
								}, delay);
							}

						}
					});
				}
			}
		}

		function gotodelete_des_quali(desqid){
			if (desqid != "") {
				var conf_answer = confirm("You are about to Delete a record. This cannot be undone. Are you sure?")
				if (conf_answer) {
					$('.div_roller_total55').fadeIn();
					$.ajax({
						method: 'POST',
						url: '<?php echo base_url() . "member/delete_desirequalification_update"; ?>',
						data: {
							desqid: desqid
						},
						dataType: 'JSON',
						success: function(data) {
							//alert(data.msg);
							if (data.msg == 1) {
								//console.log(data);
								//alert(data.msg[0].option_set);
								$('.div_roller_total55').fadeOut();
								$('.get_success_total55').html('Desirable Qualification is Deleted Successfully.');
								$(".get_success_total55").fadeIn();
								var des_q_counter = $('#des_q_counter').val();
								des_q_counter = Number(des_q_counter) - 1;
								$('#des_q_counter').val(des_q_counter);
								$(".desq_set_" + desqid).remove();
								$('#des_exam_name, #des_univ_set, #des_state_set, #des_marks_obtained_set, #des_marks_full_set, #des_marks_percent_set, #des_add_attempt_no_set, #des_marksheet_set').val('');
								setTimeout(function() {
									$('.get_success_total55').fadeOut();
								}, 3000);
							} else {
								$('.div_roller_total55').fadeOut();
								error_message = "There have some problem to Update Data, Try again.";
								error_message = error_message + "<br/>" + data.e_msg;
								$('.get_error_total55').html(error_message);
								$(".get_error_total55").fadeIn();
								setTimeout(function() {
									$('.get_error_total55').fadeOut();
								}, 3000);
							}

						}
					});
				}
			}
		}

		$(document).on('click','.btn-add-row', function(event) {



			$('.div_roller_qualification_4').fadeIn();

			var e_error = 0;

			error_message = '';



			var exam_name_input = $('.exam-name-input').val();

			var univ_input = $('.univ-input').val();

			var state_input = $('.state-input').val();

			var marks_obtained_input = $('.marks-obtained-input').val();

			var marks_full_input = $('.marks-full-input').val();

			var marks_percent_input = $('.marks-percent-input').val();

			//var marksheet_issue_date_input = $('.marksheet-issue-date').val();

			var marksheet = $('.marksheet')[0].files;





			if (exam_name_input == '') {

				$('.exam_name').html('Qualification is Required')

				e_error = 1

			} else {



				if (is_qualification_already_added(exam_name_input)) {

					e_error = 1;

					// error_message = 'This qualification is already added!'

					$('.exam_name').html('Already Added!')

				} else $('.exam_name').html('')

			}



			if (univ_input == '') {

				$('.univ').html('University is Required')

				e_error = 1

			} else {

				$('.univ').html('')

			}

			if (state_input == '') {

				$('.state').html('State is Required')

				e_error = 1

			} else {

				$('.state').html('')

			}

			if (marks_obtained_input == '') {

				$('.marks_obtained').html('Marks Obtained is Required')

				e_error = 1

			} else {



				if (!marks_obtained_input.match(onlynumerics)) {

					e_error = 1

					$('.marks_obtained').html('Non numeric value is not allowed')

				} else $('.marks_obtained').html('')

			}



			if (marks_full_input == '') {

				$('.marks_full').html('Full Marks is Required')

				e_error = 1

			} else {



				if (!marks_full_input.match(onlynumerics)) {

					e_error = 1

					$('.marks_full').html('Non numeric value is not allowed')

				} else $('.marks_full').html('')

			}



			if (marks_percent_input == '') {

				$('.marks_percent').html('Percentage is Required')

				e_error = 1

			} else {



				if (!marks_percent_input.match(onlynumerics_withdot)) {

					e_error = 1

					$('.marks_percent').html('Non numeric value is not allowed')

				} else $('.marks_percent').html('')

			}



			/*if (marksheet_issue_date_input == '') {

				$('.marksheet_issue_date').html('Issue date is Required')

				e_error = 1

			} else if (isDateTodayset(marksheet_issue_date_input) == false) {

				e_error = 1;

				$('.marksheet_issue_date').html('Advance Date Not Allow Here.');

			} else {

				$('.marksheet_issue_date').html('')

			}*/





			fileInput = document.querySelector('input[name="marksheet"]')

			filePath = fileInput.value



			if ($('.marksheet').val() == '') {



				$('.marksheet').html('Marksheet is Required')

				e_error = 1

			} else {

				if (fileInput.value != "" && !allowedExtensions.exec(filePath)) {

					e_error = 1;

					$('.marksheet').html('Document File type Invalid.(Use Image File or PDF)');

				} else {

					if (fileInput.files[0].size > docFileMaxSize) {

						e_error = 1;

						$('.marksheet').html('File size must be less than or equal to 2 MB');

					} else $('.marksheet').html('')

				}

			}






			$('.btn-add-row').prop('disabled', true);

			if (e_error == 1) {

				error_message = "There have some problem to Store Data, Try after some time.";

				$('.div_roller_qualification_4').fadeOut();

				$('.get_error_qualification_4').html(error_message);

				$(".get_error_qualification_4").fadeIn();

				$(".text-error").fadeIn();



				setTimeout(function() {
					$('.text-error, .get_error_qualification_4').fadeOut();
					$('.text-error').html('');
					$('.btn-add-row').prop('disabled', false);
				}, delay);

			} else {



				var form_data = new FormData();



				form_data.append('exam_name', exam_name_input);

				form_data.append('university', univ_input);

				form_data.append('state', state_input);

				form_data.append('marks_obtained', marks_obtained_input);

				form_data.append('marks_full', marks_full_input);

				form_data.append('marks_percent', marks_percent_input);

				//form_data.append('marksheet_issue_date', marksheet_issue_date_input);



				form_data.append("marksheet", marksheet[0]);


				$.ajax({

					method: 'POST',

					url: '<?php echo base_url() . "member/add_qualification"; ?>',

					data: form_data,

					dataType: 'JSON',

					contentType: false,

					processData: false,

					success: function(data) {

						//console.log(data)



						if (data.msg == 1)

						{



							$('.div_roller_qualification_4').fadeOut();

							$('.get_success_qualification_4').html('Data Saved Successfully.');

							$(".get_success_qualification_4").fadeIn();

							// setTimeout(function(){ window.location.replace("<?php //echo site_url('member') ?>"); }, 3000);

							// ---------------
							let html = `
								<div class="row " style="margin: 10px;">

								<div class="col">

								<div class="row pl-2 pr-2 ">

									${exam[`${exam_name_input}`]}

								</div>

								</div>

								<div class="col">

								

								<div class="row  pl-2 pr-2">

									${univ_input}

								</div>
								</div>



								<div class="col">

								<div class="row  pl-2 pr-2">

									${states[`${state_input}`]}

								</div>

								</div>



								<div class="col">

								<div class="row  pl-2 pr-2">

									${marks_obtained_input}

								</div>

								</div>

								<div class="col">

								<div class="row  pl-2 pr-2">

								${marks_full_input}

								</div>

								</div>

								

								<div class="col">

								<div class="row  pl-2 pr-2">

								${marks_percent_input}

								</div>

								</div>

								<div class="col">

								<div class="row  pl-2 pr-2">

								<a href="<?php echo base_url($pathurl); ?>${data.marksheet}" target="_blank">Marksheet</a>

								</div>

								</div>
								<div class="col">

								<div class="row  pl-2">

									<span class="btn btn-danger btn-delete-row" data-id='${data.quali_id}'><i class="fa fa-trash"></i></span>

								</div>
								</div>
								</div>
								`


							setTimeout(function() {
								$('.get_success_qualification_4').fadeOut();
								$('.btn-add-row').prop('disabled', false);
								usersQuali.push(exam_name_input)

								$('.qualification').append(html)

								$('.univ-input').val('');
								$('.state-input').val('');
								$('.marks-obtained-input').val('');
								$('.marks-full-input').val('');
								$('.marks-percent-input').val('');
								//$('.marksheet-issue-date').val('');
								$('.marksheet').val('');
								quali++;

								if(examsID.length == quali){
									$('.btn-add-row').hide();
								}

							}, 2000);

						} else {



							$('.div_roller_qualification_4').fadeOut();

							error_message = "There have some problem to Store Data, Try after some time.";

							error_message = error_message + "<br/>" + data.e_msg;

							$('.get_error_qualification_4').html(error_message);

							$(".get_error_qualification_4").fadeIn();

							setTimeout(function() {
								$('.get_error_total_4').fadeOut();
								$('.btn-add-row').prop('disabled', false);
							}, delay);

						}





					}



				});



			}



		});

		
		function percentcheck_exm(){
			for(var cntset = 0; cntset<totalexam; cntset++){

				var marks_obtained = $("input[name='marks_obtained_"+cntset+"']").val();
				var marks_full = $("input[name='marks_full_"+cntset+"']").val();
				var marks_percent = $("input[name='marks_percent_"+cntset+"']").val();
				
				if(marks_obtained != "" && marks_full != ""){
					if(!isNaN(marks_obtained) && !isNaN(marks_full)){
						if(parseInt(marks_full) >= parseInt(marks_obtained)){
							var updatemarks_percent = parseFloat((parseInt(marks_obtained) * 100)/ parseInt(marks_full)).toFixed(2);
							$("input[name='marks_percent_"+cntset+"']").val(updatemarks_percent);
						}else{
							$("input[name='marks_percent_"+cntset+"']").val('');
						}
					}else{
						$("input[name='marks_percent_"+cntset+"']").val('');
					}
				}else{
					$("input[name='marks_percent_"+cntset+"']").val('');
				}
				
			}
		}

		function dpercentcheck_exm(){
			var dsq_total_rej = parseInt($("#dsq_total_rej").val());
			for(var cntset = 0; cntset<dsq_total_rej; cntset++){

				var marks_obtained = $("input[name='dmarks_obtained_"+cntset+"']").val();
				var marks_full = $("input[name='dmarks_full_"+cntset+"']").val();
				var marks_percent = $("input[name='dmarks_percent_"+cntset+"']").val();
				
				if(marks_obtained != "" && marks_full != ""){
					if(!isNaN(marks_obtained) && !isNaN(marks_full)){
						if(parseInt(marks_full) >= parseInt(marks_obtained)){
							var updatemarks_percent = parseFloat((parseInt(marks_obtained) * 100)/ parseInt(marks_full)).toFixed(2);
							$("input[name='dmarks_percent_"+cntset+"']").val(updatemarks_percent);
						}else{
							$("input[name='dmarks_percent_"+cntset+"']").val('');
						}
					}else{
						$("input[name='dmarks_percent_"+cntset+"']").val('');
					}
				}else{
					$("input[name='dmarks_percent_"+cntset+"']").val('');
				}
				
			}
		}
		

		function all_resubmit_step(checktype) {

			
			var delay = 3000;
			var e_error = 0;
			error_message = 'There have some errors please check above, Try again.';
			$('.div_roller_total').fadeIn();
			$('.button_submit').prop('disabled', true);
			//alert(checktype);exit;
			if(checktype == "fu_dob"){

				var fu_dob = $('#fu_dob').val();
				var fu_dob_doc = $('#fu_dob_doc')[0].files;

				if (fu_dob == "") {
					e_error = 1;
					$('.fu_dob').html('Date of Birth is Required.');
				} else if (isDatecheck(fu_dob) == false) {
					e_error = 1;
					$('.fu_dob').html('Incorrect date of birth format, check properly.');
				} else if (isDateTodayset(fu_dob) == false) {
					e_error = 1;
					$('.fu_dob').html('Advance Date Not Allow Here.');
				} else {
					$('.fu_dob').html('');
				}

				if ($('.fu_uploaded_dob').text() == '') {
					if (document.getElementById("fu_dob_doc").files.length == 0) {
						e_error = 1;
						$('.fu_dob_doc').html('Document is Required.');
					} else {
						var fileInput = document.getElementById('fu_dob_doc');
						var filePath = fileInput.value;
						if (!allowedExtensions.exec(filePath)) {
							e_error = 1;
							$('.fu_dob_doc').html('Document File type Invalid.(Use PDF/Image)');
						} else {
							if (fileInput.files[0].size > docFileMaxSize) {
								$('.fu_dob_doc').html('File size must be less than or equal to 2 MB');
							} else $('.fu_dob_doc').html('');
						}
					}

				}

				if (e_error == 1) {
					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append('fu_dob', fu_dob);
						form_data.append("fu_dob_doc", fu_dob_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_dob_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_address"){

				var fu_state = $('select[name="fu_state"]').val();
				var fu_district = $('select[name="fu_district"]').val();
				var fu_sub_division = $('select[name="fu_sub_division"]').val();
				var fu_police_station = $('select[name="fu_police_station"]').val();
				var fu_mb_type = $('input[name="fu_mb_type"]:checked').val();
				var fu_block_municipality = $('select[name="fu_block_municipality"]').val();
				var fu_other_sdiv = $('input[name="fu_other_sdiv"]').val();
				var fu_other_ps = $('input[name="fu_other_ps"]').val();
				var fu_other_district = $('input[name="fu_other_district"]').val();
				var fu_other_blockm = $('input[name="fu_other_blockm"]').val();
				var fu_house_road = $('input[name="fu_house_road"]').val();
				var fu_pincode = $('input[name="fu_pincode"]').val();
				var fu_ward_gp = $('input[name="fu_ward_gp"]').val();
				var fu_post_office = $('input[name="fu_post_office"]').val();

				//var fu_dom_state = $('#fu_dom_state option:selected').val();
				var com_address = $('input[name="com_address"]:checked').val();
				var fu_per_state = $('select[name="fu_per_state"]').val();
				var fu_per_district = $('select[name="fu_per_district"]').val();
				var fu_per_sub_division = $('select[name="fu_per_sub_division"]').val();
				var fu_per_police_station = $('select[name="fu_per_police_station"]').val();
				var fu_per_mb_type = $('input[name="fu_per_mb_type"]:checked').val();
				var fu_per_block_municipality = $('select[name="fu_per_block_municipality"]').val();
				var fu_per_other_sdiv = $('input[name="fu_per_other_sdiv"]').val();
				var fu_per_other_ps = $('input[name="fu_per_other_ps"]').val();
				var fu_per_other_district = $('input[name="fu_per_other_district"]').val();
				var fu_per_other_blockm = $('input[name="fu_per_other_blockm"]').val();
				var fu_per_house_road = $('input[name="fu_per_house_road"]').val();
				var fu_per_pincode = $('input[name="fu_per_pincode"]').val();
				var fu_per_ward_gp = $('input[name="fu_per_ward_gp"]').val();
				var fu_per_post_office = $('input[name="fu_per_post_office"]').val();

				var fu_address_doc = $('#fu_address_doc')[0].files;

				var same_address = '';
				if($("#all_same_address").prop('checked') == true){
					same_address = 'Yes';
				}else{
					same_address = 'No';
				}

				if (fu_state == '') {

					e_error = 1;

					$('.fu_state').html('State is Required.');
				} else {
					$('.fu_state').html('');
				}


				if (fu_state == 28 || fu_state == '') {
					if (fu_district == "") {

						e_error = 1;

						$('.fu_district').html('District is Required.');

					} else {

						if (!fu_district.match(alphanumerics_spaces)) {

							e_error = 1;

							$('.fu_district').html('District is not numeric, Check again.');

						} else {

							$('.fu_district').html('');

						}

					}
				} else {
					if (fu_other_district == "") {

						e_error = 1;

						$('.fu_district').html('District is Required.');

					} else {

						$('.fu_district').html('');

					}
				}

				if (fu_state == 28 || fu_state == '') {

					if(fu_district != 342){
						if (fu_sub_division == "") {

							e_error = 1;

							$('.fu_sub_division').html('Sub Division is Required.');

							} else {

							if (!fu_sub_division.match(alphanumerics_spaces)) {

								e_error = 1;

								$('.fu_sub_division').html('District is not numeric, Check again.');

							} else {

								$('.fu_sub_division').html('');

							}

						}
					}else{
						$('.fu_sub_division').html('');
					}


				} else {
					if (fu_other_sdiv == "") {

						e_error = 1;

						$('.fu_other_sdiv').html('Sub Division is Required.');

					} else {

						$('.fu_other_sdiv').html('');

					}
				}

				if (fu_state == 28 || fu_state == '') {
					if (fu_police_station == "") {

						e_error = 1;

						$('.fu_police_station').html('Police Station is Required.');

					} else {

						if (!fu_police_station.match(alphanumerics_spaces)) {

							e_error = 1;

							$('.fu_police_station').html('Police station is not numeric, Check again.');

						} else {

							$('.fu_police_station').html('');

						}

					}
				} else {
					if (fu_other_ps == "") {

						e_error = 1;

						$('.fu_other_ps').html('Police station is Required.');

					} else {

						$('.fu_other_ps').html('');

					}
				}

				if (fu_state == 28 || fu_state == '') {
					if(fu_district != 342){
						if (fu_mb_type == undefined) {

							e_error = 1;

							$('.fu_mb_type').html('Select Block or Municipality');

						} else {

							if (fu_mb_type != "Block" && fu_mb_type != "Municipality") {

								e_error = 1;

								$('.fu_mb_type').html('Value should be either Block or Municipality');

							} else {

								$('.fu_mb_type').html('');

							}

						}
					}else{
						$('.fu_mb_type').html('');
					}
				}

				if (fu_state == 28 || fu_state == '') {
					if(fu_district != 342){
						if (fu_block_municipality == "") {

							e_error = 1;

							$('.fu_block_municipality').html('Block/Municipality is Required.');

						} else {

							if (!fu_block_municipality.match(onlynumerics)) {

								e_error = 1;

								$('.fu_block_municipality').html('District is not numeric, Check again.');

							} else {

								$('.fu_block_municipality').html('');

							}

						}
					}else{
						$('.fu_block_municipality').html('');
					}
				} else {
					if (fu_other_blockm == "") {

						e_error = 1;

						$('.fu_other_blockm').html('Block/Municipality is Required.');

					} else {

						$('.fu_other_blockm').html('');

					}
				}

				if (fu_house_road == '') {

					e_error = 1;

					$('.fu_house_road').html('House no. is Required.');
				} else {

					$('.fu_house_road').html('');
				}

				if (fu_pincode == '') {

					e_error = 1;

					$('.fu_pincode').html('Pincode is Required.');
				} else {
					if (!fu_pincode.match(onlynumerics)) {

						e_error = 1;

						$('.fu_pincode').html('Pincode need numeric value, Check again.');

					} else {

						$('.fu_pincode').html('');

					}
				}

				if (fu_ward_gp == '') {

					e_error = 1;

					$('.fu_ward_gp').html('Ward is Required.');
				} else {

					$('.fu_ward_gp').html('');
				}

				if (fu_post_office == '') {

					e_error = 1;

					$('.fu_post_office').html('Post Office is Required.');
				} else {

					$('.fu_post_office').html('');
				}
					// --------------------------------------------------

				if(same_address == "No"){

					if (com_address == undefined || com_address == "") {
							e_error = 1;
							$('.com_address').html('Select Communication Addresss properly');
						} else {
						if (com_address != "Present" && com_address != "Permanent") {
							e_error = 1;
							$('.com_address').html('Value should be either Present or Permanent');
						} else {
							$('.com_address').html('');
						}
					}

					if (fu_per_state == '') {
						e_error = 1;
						$('.fu_per_state').html('State is Required.');
					} else {
						$('.fu_per_state').html('');
					}

					if (fu_per_state == 28 || fu_per_state == '') {
						if (fu_per_district == "") {
							e_error = 1;
							$('.fu_per_district').html('District is Required.');
						} else {
							if (!fu_per_district.match(alphanumerics_spaces)) {
								e_error = 1;
								$('.fu_per_district').html('District is not numeric, Check again.');
							} else {
								$('.fu_per_district').html('');
							}
						}
					} else {
						if (fu_per_other_district == "") {
							e_error = 1;
							$('.fu_per_other_district').html('District is Required.');
						} else {
							$('.fu_per_other_district').html('');
						}
					}

					if (fu_per_state == 28 || fu_per_state == '') {
						if (fu_per_district != 342) {
							if (fu_per_sub_division == "") {
								e_error = 1;
								$('.fu_per_sub_division').html('Sub Division is Required.');
							} else {
								if (!fu_per_sub_division.match(alphanumerics_spaces)) {
									e_error = 1;
									$('.fu_per_sub_division').html('District is not numeric, Check again.');
								} else {
									$('.fu_per_sub_division').html('');
								}
							}
						}else{
							$('.fu_per_sub_division').html('');
						}
					} else {
						if (fu_per_other_sdiv == "") {
							e_error = 1;
							$('.fu_per_other_sdiv').html('Sub Division is Required.');
						} else {
							$('.fu_per_other_sdiv').html('');

						}
					}

					if (fu_per_state == 28 || fu_per_state == '') {
						if (fu_per_police_station == "") {
							e_error = 1;
							$('.fu_per_police_station').html('Police Station is Required.');
						} else {
							if (!fu_per_police_station.match(alphanumerics_spaces)) {
								e_error = 1;
								$('.fu_per_police_station').html('Police station is not numeric, Check again.');
							} else {
								$('.fu_per_police_station').html('');
							}
						}
					} else {
						if (fu_per_other_ps == "") {
							e_error = 1;
							$('.fu_per_other_ps').html('Police station is Required.');
						} else {
							$('.fu_per_other_ps').html('');
						}
					}

					if (fu_per_state == 28 || fu_per_state == '') {
						if (fu_per_district != 342) {
							if (fu_per_mb_type == undefined) {
								e_error = 1;
								$('.fu_per_mb_type').html('Select Block or Municipality');
							} else {
								if (fu_per_mb_type != "Block" && fu_per_mb_type != "Municipality") {
									e_error = 1;
									$('.fu_per_mb_type').html('Value should be either Block or Municipality');
								} else {
									$('.fu_per_mb_type').html('');
								}
							}
						}else{
							$('.fu_per_mb_type').html('');
						}
					}

					if (fu_per_state == 28 || fu_per_state == '') {
						if (fu_per_district != 342) {
							if (fu_per_block_municipality == "") {
								e_error = 1;
								$('.fu_per_block_municipality').html('Block/Municipality is Required.');
							} else {
								if (!fu_per_block_municipality.match(onlynumerics)) {
									e_error = 1;
									$('.fu_per_block_municipality').html('Block/Municipality is not numeric, Check again.');
								} else {
									$('.fu_per_block_municipality').html('');
								}
							}
						}else{
							$('.fu_per_block_municipality').html('');
						}
					} else {
						if (fu_per_other_blockm == "") {
							e_error = 1;
							$('.fu_per_other_blockm').html('Block/Municipality is Required.');
						} else {
							$('.fu_per_other_blockm').html('');
						}
					}

					if (fu_per_house_road == '') {
						e_error = 1;
						$('.fu_per_house_road').html('House no. is Required.');
					} else {
						$('.fu_per_house_road').html('');
					}

					if (fu_per_pincode == '') {
						e_error = 1;
						$('.fu_per_pincode').html('Pincode is Required.');
					} else {
						if (!fu_per_pincode.match(onlynumerics)) {
							e_error = 1;
							$('.fu_per_pincode').html('Pincode need numeric value, Check again.');
						} else {
							$('.fu_per_pincode').html('');
						}
					}

					if (fu_per_ward_gp == '') {
						e_error = 1;
						$('.fu_per_ward_gp').html('Ward is Required.');
					} else {
						$('.fu_per_ward_gp').html('');
					}

					if (fu_per_post_office == '') {
						e_error = 1;
						$('.fu_per_post_office').html('Post Office is Required.');
					} else {
						$('.fu_per_post_office').html('');
					}
				}

				if ($('.fu_uploaded_address').text() == '') {

					if (document.getElementById("fu_address_doc").files.length == 0) {

						e_error = 1;

						$('.fu_address_doc').html('Document is Required.');

					} else {

						var fileInput = document.getElementById('fu_address_doc');

						var filePath = fileInput.value;

						if (!allowedExtensions.exec(filePath)) {

							e_error = 1;

							$('.fu_address_doc').html('Document File type Invalid.(Use PDF/Image)');

						} else {

							if (fileInput.files[0].size > docFileMaxSize) {

								e_error = 1;

								$('.fu_address_doc').html('File size must be less than or equal to 2 MB');

							} else $('.fu_address_doc').html('');

						}

					}

				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {
					
					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append('fu_state', fu_state);
						form_data.append('fu_district', fu_district);
						form_data.append('fu_sub_division', fu_sub_division);
						form_data.append('fu_police_station', fu_police_station);
						form_data.append('fu_mb_type', fu_mb_type);
						form_data.append('fu_block_municipality', fu_block_municipality);
						form_data.append('fu_other_sdiv', fu_other_sdiv);
						form_data.append('fu_other_ps', fu_other_ps);
						form_data.append('fu_other_district', fu_other_district);
						form_data.append('fu_other_blockm', fu_other_blockm);
						form_data.append('fu_house_road', fu_house_road);
						form_data.append('fu_pincode', fu_pincode);
						form_data.append('fu_ward_gp', fu_ward_gp);
						form_data.append('fu_post_office', fu_post_office);
						form_data.append('same_address', same_address);
						form_data.append('com_address', com_address);
						// form_data.append('fu_address',fu_addresss);
						// --------------------------
						form_data.append('fu_per_state', fu_per_state);
						form_data.append('fu_per_district', fu_per_district);
						form_data.append('fu_per_sub_division', fu_per_sub_division);
						form_data.append('fu_per_police_station', fu_per_police_station);
						form_data.append('fu_per_mb_type', fu_per_mb_type);
						form_data.append('fu_per_block_municipality', fu_per_block_municipality);
						form_data.append('fu_per_other_sdiv', fu_per_other_sdiv);
						form_data.append('fu_per_other_ps', fu_per_other_ps);
						form_data.append('fu_per_other_district', fu_per_other_district);
						form_data.append('fu_per_other_blockm', fu_per_other_blockm);
						form_data.append('fu_per_house_road', fu_per_house_road);
						form_data.append('fu_per_pincode', fu_per_pincode);
						form_data.append('fu_per_ward_gp', fu_per_ward_gp);
						form_data.append('fu_per_post_office', fu_per_post_office);

						form_data.append("fu_address_doc", fu_address_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_address_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}


			}else if(checktype == "fu_photo_doc"){

				var fu_pic_doc = $('#fu_pic_doc')[0].files;
				if ($('.fu_uploaded_photo').text() == '') {

					if (document.getElementById("fu_pic_doc").files.length == 0) {

						e_error = 1;

						$('.fu_pic_doc').html('Candidate Picture is Required.');

					} else {

						var fileInput = document.getElementById('fu_pic_doc');

						var filePath = fileInput.value;

						if (!allowedPic_Extensions.exec(filePath)) {

							e_error = 1;

							$('.fu_pic_doc').html('Candidate Picture File type Invalid.(Use Image File)');

						} else {



							if (fileInput.files[0].size > docFileMaxSize) {

								e_error = 1;

								$('.fu_pic_doc').html('File size must be less than or equal to 500 KB');

							} else $('.fu_pic_doc').html('');

						}

					}

				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append("fu_type", 'PHOTO');
						form_data.append("fu_pic_doc", fu_pic_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_photo_sign_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}
				
			}else if(checktype == "fu_signature_doc"){

				var fu_sign_doc = $('#fu_sign_doc')[0].files;
				if ($('.fu_uploaded_sign').text() == '') {

					if (document.getElementById("fu_sign_doc").files.length == 0) {

						e_error = 1;

						$('.fu_sign_doc').html('Signature is Required.');

					} else {

						var fileInput = document.getElementById('fu_sign_doc');

						var filePath = fileInput.value;

						if (!allowedPic_Extensions.exec(filePath)) {

							e_error = 1;

							$('.fu_sign_doc').html('Document File type Invalid.(Use Image File)');

						} else {



							if (fileInput.files[0].size > docFileMaxSize) {

								e_error = 1;

								$('.fu_sign_doc').html('File size must be less than or equal to 2 MB');

							} else $('.fu_sign_doc').html('');

						}

					}

				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append("fu_type", 'SIGN');
						form_data.append("fu_sign_doc", fu_sign_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_photo_sign_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_caste"){

				//var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();
				var fu_caste_type = $('select[name="fu_caste_type"] option:selected').val();
				var com_castetypeset = $('input[name="com_castetypeset"]').val();
				var fu_caste_community = $('select[name="fu_caste_community"]').val();
				var fu_caste_number = $('input[name="fu_caste_number"]').val();
				var fu_caste_issue_whom = $('select[name="fu_caste_issue_whom"]').val();
				var fu_caste_issue_date = $('input[name="fu_caste_issue_date"]').val();
				var fu_caste_doc = $('input[name="fu_caste_doc"]')[0].files;

				if (fu_caste_type == "") {
					e_error = 1;
					$('.fu_caste_type').html('Caste is Required');
				} else if (!fu_caste_type.match(onlynumerics)) {
					e_error = 1;
					$('.fu_caste_type').html('Illegal character(s) used, Check again.');
				} else {
					$('.fu_caste_type').html('');
				}

				if (fu_caste_type != 1) {

					if(com_castetypeset == ""){
						e_error = 1;
						error_message = error_message + "<br/>Caste Type Not Selected Properly, Refresh the Page.";
					}else if(com_castetypeset == 2){
						if (fu_caste_community == "") {
							e_error = 1;
							$('.fu_caste_community').html('Caste Community is Required');
						} else if (!fu_caste_community.match(alphanumerics_no)) {
							e_error = 1;
							$('.fu_caste_community').html('Illegal character(s) used, Check again.');
						} else {
							$('.fu_caste_community').html('');
						}
						if (fu_caste_number == "") {
							e_error = 1;
							$('.fu_caste_number').html('Caste Certificate No. is Required');
						} else if (!fu_caste_number.match(alphanumerics_no)) {
							e_error = 1;
							$('.fu_caste_number').html('Illegal character(s) used, Check again.');
						} else {
							$('.fu_caste_number').html('');
						}

						if (fu_caste_issue_whom == "") {
							e_error = 1;
							$('.fu_caste_issue_whom').html('Issued By Whom is Required');
						} else if (!fu_caste_issue_whom.match(alphanumerics_no)) {
							e_error = 1;
							$('.fu_caste_issue_whom').html('Illegal character(s) used, Check again.');
						} else {
							$('.fu_caste_issue_whom').html('');
						}

						if (fu_caste_issue_date == "") {
							e_error = 1;
							$('.fu_caste_issue_date').html('Issued By Date is Required');
						} else if (isDatecheck(fu_caste_issue_date) == false) {
							e_error = 1;
							$('.fu_caste_issue_date').html('Date of Issue Format check properly.');
						} else if (isDateTodayset(fu_caste_issue_date) == false) {
							e_error = 1;
							$('.fu_caste_issue_date').html('Advance Date Not Allow Here.');
						} else {
							$('.fu_caste_issue_date').html('');
						}
					}else{
						$('.fu_caste_community, .fu_caste_issue_date, .fu_caste_issue_whom, .fu_caste_number').html('');
					}

				}

				var fileInput;

				var filePath;

				fileInput = document.querySelector('input[name="fu_caste_doc"]');

				filePath = fileInput.value;

				if (fu_caste_type != 1) {
					if(com_castetypeset == 2){
						if (document.querySelector('input[name="fu_caste_doc"]').files.length == 0) {

							if ($('.fu_uploaded_caste').text() == '') {
								e_error = 1;
								$('.fu_caste_doc').html('Document is Required.');
							}
						} else if (!allowedExtensions.exec(filePath)) {
							e_error = 1;
							$('.fu_caste_doc').html('Caste Document File type Invalid.(Use Image File or PDF)');
						} else {
							$('.fu_caste_doc').html('');
						}
					}else{
						$('.fu_caste_doc').html('');
					}
				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append('fu_caste_type', fu_caste_type);
						form_data.append('com_castetypeset', com_castetypeset);
						form_data.append('fu_caste_community', fu_caste_community);
						form_data.append('fu_caste_number', fu_caste_number);
						form_data.append('fu_caste_issue_whom', fu_caste_issue_whom);
						form_data.append('fu_caste_issue_date', fu_caste_issue_date);
						form_data.append("fu_caste_doc", fu_caste_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_caste_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_pwd"){
				var fu_pwd = $('input[name="yesno_pwd"]:checked').val();
				var fu_pwd_percent = $('input[name="fu_pwd_percent"]').val();
				var fu_pwd_issue_whom = $('input[name="fu_pwd_issue_whom"]').val();
				var fu_pwd_issue_date = $('input[name="fu_pwd_issue_date"]').val();
				var fu_pwd_doc = $('input[name="fu_pwd_doc"]')[0].files;
				var fupwd_givepercent = '<?php echo $adv_detail->adv_pwd_percent; ?>';

				if (fu_pwd != 'Yes' && fu_pwd != 'No') {
					e_error = 1;
					$('.fu_pwd').html('Required');
				} else {
					$('.fu_pwd').html('');
				}

				if (fu_pwd == "Yes") {
					if (fu_pwd_percent == "") {
						e_error = 1;
						$('.fu_pwd_percent').html('Percentage of Disability is Required');
					} else if (!fu_pwd_percent.match(onlynumerics)) {
						e_error = 1;
						$('.fu_pwd_percent').html('Only numeric value, Check again.');
					} else {
						if((parseInt(fupwd_givepercent) > parseInt(fu_pwd_percent)) || (parseInt(fu_pwd_percent) == 0)){
							e_error = 1;
							$('.fu_pwd_percent').html('PWD Minimum Percentage not Reached, Check again.');
						}else if(parseInt(fu_pwd_percent) > 100){
							e_error = 1;
							$('.fu_pwd_percent').html('PWD Maximum Percentage crossed, Check again.');
						}else{
							$('.fu_pwd_percent').html('');
						}
					}
				
					if (fu_pwd_issue_whom == "") {
						e_error = 1;
						$('.fu_pwd_issue_whom').html('Required');
					} else if (!fu_pwd_issue_whom.match(alphanumerics_no)) {
						e_error = 1;
						$('.fu_pwd_issue_whom').html('Illegal character(s) used, Check again.');
					} else {
						$('.fu_pwd_issue_whom').html('');
					}
				
					if (fu_pwd_issue_date == "") {
						$('.fu_pwd_issue_date').html('Date of issue is required');
					} else if (isDatecheck(fu_pwd_issue_date) == false) {
						e_error = 1;
						$('.fu_pwd_issue_date').html('Date of issue Format check properly.');
					} else if (isDateTodayset(fu_pwd_issue_date) == false) {
						e_error = 1;
						$('.fu_pwd_issue_date').html('Advance Date Not Allow Here.');
					} else {
						$('.fu_pwd_issue_date').html('');
					}
				}

				fileInput = document.querySelector('input[name="fu_pwd_doc"]');

				filePath = fileInput.value;

				if (fu_pwd == "Yes") {
					if (document.querySelector('input[name="fu_pwd_doc"]').files.length == 0) {
						if ($('.fu_uploaded_pwd').text() == '') {
							e_error = 1;
							$('.fu_pwd_doc').html('Document is Required.');
						}
					} else if (!allowedExtensions.exec(filePath)) {
						e_error = 1;
						$('.fu_pwd_doc').html('Document File type Invalid.(Use Image File or PDF)');
					} else {
						$('.fu_pwd_doc').html('');
					}
				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append('fu_pwd', fu_pwd);
						form_data.append('fu_pwd_percent', fu_pwd_percent);
						form_data.append('fu_pwd_issue_whom', fu_pwd_issue_whom);
						form_data.append('fu_pwd_issue_date', fu_pwd_issue_date);
						form_data.append("fu_pwd_doc", fu_pwd_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_pwd_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_age_relax"){

				var agecnt = 1;
				<?php if(!empty($extraage_set)){
					foreach($extraage_set as $ageitems){ 
						if(in_array($ageitems->advage_section,$age1_arr)){ ?>
						
						var fu_extage = $('input[name="yesno_extage_'+agecnt+'"]:checked').val();
						var fu_extage_reason = $('textarea[name="fu_extage_reason_'+agecnt+'"]').val();
						var fu_extage_doc = $('input[name="fu_extage_doc_'+agecnt+'"]')[0].files;

						if (fu_extage != 'Yes' && fu_extage != 'No') {
							e_error = 1;
							$('.yesno_extage_'+agecnt).html('Field is Required');
						} else {
							$('.yesno_extage_'+agecnt).html('');
						}

						if (fu_extage == "Yes") {
							if (fu_extage_reason == "") {
								e_error = 1;
								$('.fu_extage_reason_'+agecnt).html('Detail Description is Required');
							} else if (!fu_extage_reason.match(alphanumerics_no)) {
								e_error = 1;
								$('.fu_extage_reason_'+agecnt).html('Illegal Special character(s) used, Check again.');
							} else {
								$('.fu_extage_reason_'+agecnt).html('');
							}
						}

						fileInput = document.querySelector('input[name="fu_extage_doc_'+agecnt+'"]');
						filePath = fileInput.value;

						if (fu_extage == "Yes") {
							if (document.querySelector('input[name="fu_extage_doc_'+agecnt+'"]').files.length == 0) {
								if ($('.fu_uploaded_extage_'+agecnt).text() == '') {
									e_error = 1;
									$('.fu_extage_doc_'+agecnt).html('Document is Required.');
								}
							} else if (fileInput.value != "" && !allowedExtensions.exec(filePath)) {
								e_error = 1;
								$('.fu_extage_doc_'+agecnt).html('Document File type Invalid.(Use Image File or PDF)');
							} else {
								$('.fu_extage_doc_'+agecnt).html('');
							}
						}
						agecnt++;
				<?php }
					}
				} ?>
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						agecnt = 1;
						<?php if(!empty($extraage_set)){
						foreach($extraage_set as $ageitems){
							if(in_array($ageitems->advage_section,$age1_arr)){ ?>
							
							var fu_extage_ids = '<?php echo $ageitems->advage_section; ?>';
							var fu_extage = $('input[name="yesno_extage_'+agecnt+'"]:checked').val();
							var fu_extage_reason = $('textarea[name="fu_extage_reason_'+agecnt+'"]').val();
							var fu_extage_doc = $('input[name="fu_extage_doc_'+agecnt+'"]')[0].files;

							form_data.append('fu_extage[]', fu_extage);
							form_data.append('fu_extage_ids[]', fu_extage_ids);
							form_data.append('fu_extage_reason[]', fu_extage_reason);
							if($("input[name='fu_extage_doc_"+agecnt+"']").val() != ""){
								form_data.append('files['+agecnt+']', fu_extage_doc[0]);
							}else{
								form_data.append('files['+agecnt+']', '');
							}
							agecnt++;
						<?php }
							}
						} ?>

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_agerelax_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_es_qualification"){

				for(var cntset = 0; cntset<totalexam; cntset++){

					var exam_name = $("select[name='exam_name_"+cntset+"'] option:selected").val();
					var examid = $("input[name='examid_"+cntset+"']").val();
					var exam_rej_id = $("input[name='exam_rej_id_"+cntset+"']").val();
					var univ = $("input[name='univ_"+cntset+"']").val();
					var state = $("select[name='state_"+cntset+"'] option:selected").val();
					var marks_obtained = $("input[name='marks_obtained_"+cntset+"']").val();
					var marks_full = $("input[name='marks_full_"+cntset+"']").val();
					var marks_percent = $("input[name='marks_percent_"+cntset+"']").val();
					var add_attempt = $("select[name='add_attempt_"+cntset+"'] option:selected").val();
					var add_attempt_no = $("input[name='add_attempt_no_"+cntset+"']").val();
					var marksheet = $("input[name='marksheet_"+cntset+"']")[0].files;
					//var files = $('#advice_doc')[0].files;

					if(examid == "" || exam_rej_id == ""){
						e_error = 1;
						$('.examid_'+cntset).html('Exam is Required');
					}else{
						$('.examid_'+cntset).html('');
					}
					if(univ == ""){
						e_error = 1;
						$('.univ_'+cntset).html('Value is Required');
					}else{
						$('.univ_'+cntset).html('');
					}
					if(state == ""){
						e_error = 1;
						$('.state_'+cntset).html('State is Required');
					}else{
						$('.state_'+cntset).html('');
					}
					if(marks_obtained == ""){
						e_error = 1;
						$('.marks_obtained_'+cntset).html('Marks Obtained is Required');
					}else{
						if (!marks_obtained.match(onlynumerics_withdot)) {
							e_error = 1;
							$('.marks_obtained_'+cntset).html('Marks Obtained use only Numeric Value');
						}else if(parseInt(marks_obtained) <= 0){
							e_error = 1;
							$('.marks_obtained_'+cntset).html('Marks Obtained always greater than 0');
						}else{
							$('.marks_obtained_'+cntset).html('');
						}
					}
					if(marks_full == ""){
						e_error = 1;
						$('.marks_full_'+cntset).html('Full Marks is Required');
					}else{
						if (!marks_full.match(onlynumerics)) {
							e_error = 1;
							$('.marks_full_'+cntset).html('Full Marks use only Numeric Value');
						}else if(parseInt(marks_full) <= 0){
							e_error = 1;
							$('.marks_full_'+cntset).html('Full Marks always greater than 0');
						}else{
							$('.marks_full_'+cntset).html('');
						}
					}
					if(marks_percent == ""){
						e_error = 1;
						$('.marks_percent_'+cntset).html('Percentage Marks is Required');
					}else{
						if (!marks_percent.match(onlynumerics_withdot)) {
							e_error = 1;
							$('.marks_percent_'+cntset).html('Percentage Marks use only Numeric Value');
						}else if(parseFloat(marks_percent) <= 0){
							e_error = 1;
							$('.marks_percent_'+cntset).html('Percentage Marks always greater than 0');
						}else{
							$('.marks_percent_'+cntset).html('');
						}
					}
					if(add_attempt == ""){
						e_error = 1;
						$('.add_attempt_'+cntset).html('Additional Attempt is Required');
					}else{
						$('.add_attempt_'+cntset).html('');
						if(add_attempt == "Yes"){
							if(add_attempt_no == ""){
								e_error = 1;
								$('.add_attempt_no_'+cntset).html('Attempt Number is Required');
							}else{
								if (!add_attempt_no.match(onlynumerics)) {
									e_error = 1;
									$('.add_attempt_no_'+cntset).html('Attempt Number use only Numeric Value');
								}else if(parseInt(add_attempt_no) <= 0){
									e_error = 1;
									$('.add_attempt_no_'+cntset).html('Attempt Number always greater than 0');
								}else{
									$('.add_attempt_no_'+cntset).html('');
								}
							}
						}else{
							$('.add_attempt_no_'+cntset).html('');
						}
					}
					if($('.attach_marks_'+cntset).html() == ""){
						if (document.getElementById("marksheet_"+cntset).files.length == 0) {
							e_error = 1;
							$('.marksheet_'+cntset).html('Marksheet is Required.');
						} else {
							var fileInput = document.getElementById('marksheet_'+cntset);
							var filePath = fileInput.value;
							//alert(fileInput.files[0].size);
							if (!allowedExtensions.exec(filePath)) {
								e_error = 1;
								$('.marksheet_'+cntset).html('Marksheet type Invalid.(Use PDF/Image)');
							}else if (fileInput.files[0].size > docFileMaxSize) {
								e_error = 1;
								$('.marksheet_'+cntset).html('Marksheet Size must be less than or equal to 2 MB');
							} else {
								$('.marksheet_'+cntset).html('');
							}
						}
					}
					if(!isNaN(marks_obtained) && !isNaN(marks_full) && marks_obtained != "" && marks_full != ""){
						if(parseInt(marks_obtained) > parseInt(marks_full)){
							e_error = 1;
							$('.marks_obtained_'+cntset).html('Marks Obtained never cross the full Marks');
						}else{
							$('.marks_obtained_'+cntset).html('');
						}
					}
				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();	
						form_data.append('total_exam', totalexam);
						for(var cntsetss = 0; cntsetss<totalexam; cntsetss++){
							var examid = $("input[name='examid_"+cntsetss+"']").val();
							var exam_name = $("select[name='exam_name_"+cntsetss+"'] option:selected").val();
							var exam_rej_id = $("input[name='exam_rej_id_"+cntsetss+"']").val();
							var univ = $("input[name='univ_"+cntsetss+"']").val();
							var state = $("select[name='state_"+cntsetss+"'] option:selected").val();
							var marks_obtained = $("input[name='marks_obtained_"+cntsetss+"']").val();
							var marks_full = $("input[name='marks_full_"+cntsetss+"']").val();
							var marks_percent = $("input[name='marks_percent_"+cntsetss+"']").val();
							var add_attempt = $("select[name='add_attempt_"+cntsetss+"'] option:selected").val();
							var add_attempt_no = $("input[name='add_attempt_no_"+cntsetss+"']").val();
							//alert($("input[name='marksheet_"+cntsetss+"']").val());
							var marksheet = $("input[name='marksheet_"+cntsetss+"']")[0].files;

							form_data.append('examid[]', examid);
							form_data.append('exam_name[]', exam_name);
							form_data.append('exam_rej_id[]', exam_rej_id);
							form_data.append('univ[]', univ);
							form_data.append('state[]', state);
							form_data.append('marks_obtained[]', parseInt(marks_obtained));
							form_data.append('marks_full[]', marks_full);
							form_data.append('marks_percent[]', marks_percent);
							form_data.append('add_attempt[]', add_attempt);
							form_data.append('add_attempt_no[]', add_attempt_no);
							if($("input[name='marksheet_"+cntsetss+"']").val() != ""){
								form_data.append('files['+cntsetss+']', marksheet[0]);
							}else{
								form_data.append('files['+cntsetss+']', '');
							}
						}

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_es_qualification_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_ds_qualification"){

				var dsq_total_rej = parseInt($("#dsq_total_rej").val());
				for(var cntset = 0; cntset<dsq_total_rej; cntset++){

					//var exam_name = $("select[name='exam_name_"+cntset+"'] option:selected").val();
					var dexamid = $("input[name='dexamid_"+cntset+"']").val();
					var dexam_rej_id = $("input[name='dexam_rej_id_"+cntset+"']").val();
					var duniv = $("input[name='duniv_"+cntset+"']").val();
					var dstate = $("select[name='dstate_"+cntset+"'] option:selected").val();
					var dmarks_obtained = $("input[name='dmarks_obtained_"+cntset+"']").val();
					var dmarks_full = $("input[name='dmarks_full_"+cntset+"']").val();
					var dmarks_percent = $("input[name='dmarks_percent_"+cntset+"']").val();
					var dadd_attempt = $("select[name='dadd_attempt_"+cntset+"'] option:selected").val();
					var dadd_attempt_no = $("input[name='dadd_attempt_no_"+cntset+"']").val();
					var dmarksheet = $("input[name='dmarksheet_"+cntset+"']")[0].files;
					//var files = $('#advice_doc')[0].files;

					if(dexamid == "" || dexam_rej_id == ""){
						e_error = 1;
						$('.dexamid_'+cntset).html('Exam is Required');
					}else{
						$('.dexamid_'+cntset).html('');
					}
					if(duniv == ""){
						e_error = 1;
						$('.duniv_'+cntset).html('Value is Required');
					}else{
						$('.duniv_'+cntset).html('');
					}
					if(dstate == ""){
						e_error = 1;
						$('.dstate_'+cntset).html('State is Required');
					}else{
						$('.dstate_'+cntset).html('');
					}
					if(dmarks_obtained == ""){
						e_error = 1;
						$('.dmarks_obtained_'+cntset).html('Marks Obtained is Required');
					}else{
						if (!dmarks_obtained.match(onlynumerics_withdot)) {
							e_error = 1;
							$('.dmarks_obtained_'+cntset).html('Marks Obtained use only Numeric Value');
						}else if(parseInt(dmarks_obtained) <= 0){
							e_error = 1;
							$('.dmarks_obtained_'+cntset).html('Marks Obtained always greater than 0');
						}else{
							$('.dmarks_obtained_'+cntset).html('');
						}
					}
					if(dmarks_full == ""){
						e_error = 1;
						$('.dmarks_full_'+cntset).html('Full Marks is Required');
					}else{
						if (!dmarks_full.match(onlynumerics)) {
							e_error = 1;
							$('.dmarks_full_'+cntset).html('Full Marks use only Numeric Value');
						}else if(parseInt(dmarks_full) <= 0){
							e_error = 1;
							$('.dmarks_full_'+cntset).html('Full Marks always greater than 0');
						}else{
							$('.dmarks_full_'+cntset).html('');
						}
					}
					if(dmarks_percent == ""){
						e_error = 1;
						$('.dmarks_percent_'+cntset).html('Percentage Marks is Required');
					}else{
						if (!dmarks_percent.match(onlynumerics_withdot)) {
							e_error = 1;
							$('.dmarks_percent_'+cntset).html('Percentage Marks use only Numeric Value');
						}else if(parseFloat(dmarks_percent) <= 0){
							e_error = 1;
							$('.dmarks_percent_'+cntset).html('Percentage Marks always greater than 0');
						}else{
							$('.dmarks_percent_'+cntset).html('');
						}
					}
					if(dadd_attempt == ""){
						e_error = 1;
						$('.dadd_attempt_'+cntset).html('Additional Attempt is Required');
					}else{
						$('.dadd_attempt_'+cntset).html('');
						if(dadd_attempt == "Yes"){
							if(dadd_attempt_no == ""){
								e_error = 1;
								$('.dadd_attempt_no_'+cntset).html('Attempt Number is Required');
							}else{
								if (!dadd_attempt_no.match(onlynumerics)) {
									e_error = 1;
									$('.dadd_attempt_no_'+cntset).html('Attempt Number use only Numeric Value');
								}else if(parseInt(dadd_attempt_no) <= 0){
									e_error = 1;
									$('.dadd_attempt_no_'+cntset).html('Attempt Number always greater than 0');
								}else{
									$('.dadd_attempt_no_'+cntset).html('');
								}
							}
						}else{
							$('.dadd_attempt_no_'+cntset).html('');
						}
					}
					if($('.dattach_marks_'+cntset).html() == ""){
						if (document.getElementById("dmarksheet_"+cntset).files.length == 0) {
							e_error = 1;
							$('.dmarksheet_'+cntset).html('Marksheet is Required.');
						} else {
							var fileInput = document.getElementById('dmarksheet_'+cntset);
							var filePath = fileInput.value;
							//alert(fileInput.files[0].size);
							if (!allowedExtensions.exec(filePath)) {
								e_error = 1;
								$('.dmarksheet_'+cntset).html('Marksheet type Invalid.(Use PDF/Image)');
							}else if (fileInput.files[0].size > docFileMaxSize) {
								e_error = 1;
								$('.dmarksheet_'+cntset).html('Marksheet Size must be less than or equal to 2 MB');
							} else {
								$('.dmarksheet_'+cntset).html('');
							}
						}
					}
					if(!isNaN(dmarks_obtained) && !isNaN(dmarks_full) && dmarks_obtained != "" && dmarks_full != ""){
						if(parseInt(dmarks_obtained) > parseInt(dmarks_full)){
							e_error = 1;
							$('.dmarks_obtained_'+cntset).html('Marks Obtained never cross the full Marks');
						}else{
							$('.dmarks_obtained_'+cntset).html('');
						}
					}
				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();	
						form_data.append('total_exam', dsq_total_rej);
						for(var cntsetss = 0; cntsetss<dsq_total_rej; cntsetss++){
							var dexamid = $("input[name='dexamid_"+cntsetss+"']").val();
							var dexam_rej_id = $("input[name='dexam_rej_id_"+cntsetss+"']").val();
							var duniv = $("input[name='duniv_"+cntsetss+"']").val();
							var dstate = $("select[name='dstate_"+cntsetss+"'] option:selected").val();
							var dmarks_obtained = $("input[name='dmarks_obtained_"+cntsetss+"']").val();
							var dmarks_full = $("input[name='dmarks_full_"+cntsetss+"']").val();
							var dmarks_percent = $("input[name='dmarks_percent_"+cntsetss+"']").val();
							var dadd_attempt = $("select[name='dadd_attempt_"+cntsetss+"'] option:selected").val();
							var dadd_attempt_no = $("input[name='dadd_attempt_no_"+cntsetss+"']").val();
							//alert($("input[name='marksheet_"+cntsetss+"']").val());
							var dmarksheet = $("input[name='dmarksheet_"+cntsetss+"']")[0].files;

							form_data.append('examid[]', dexamid);
							form_data.append('exam_rej_id[]', dexam_rej_id);
							form_data.append('univ[]', duniv);
							form_data.append('state[]', dstate);
							form_data.append('marks_obtained[]', parseInt(dmarks_obtained));
							form_data.append('marks_full[]', dmarks_full);
							form_data.append('marks_percent[]', dmarks_percent);
							form_data.append('add_attempt[]', dadd_attempt);
							form_data.append('add_attempt_no[]', dadd_attempt_no);
							if($("input[name='dmarksheet_"+cntsetss+"']").val() != ""){
								form_data.append('files['+cntsetss+']', dmarksheet[0]);
							}else{
								form_data.append('files['+cntsetss+']', '');
							}
						}

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_ds_qualification_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_has_es_service"){

				var esexp_total_rej = parseInt($("#esexp_total_rej").val());
				for(var cntset = 0; cntset<esexp_total_rej; cntset++){

					//var exam_name = $("select[name='exam_name_"+cntset+"'] option:selected").val();
					var expid = $("input[name='expid_"+cntset+"']").val();
					var exp_rej_id = $("input[name='exp_rej_id_"+cntset+"']").val();
					var exporg = $("input[name='exporg_"+cntset+"']").val();
					var expyear = $("input[name='expyear_"+cntset+"']").val();
					var expmonth = $("input[name='expmonth_"+cntset+"']").val();
					var expmarksheet = $("input[name='expmarksheet_"+cntset+"']")[0].files;
					//var files = $('#advice_doc')[0].files;

					if(expid == "" || exp_rej_id == ""){
						e_error = 1;
						$('.expid_'+cntset).html('Experience is Required');
					}else{
						$('.expid_'+cntset).html('');
					}
					if (exporg == "") {
						e_error = 1;
						$('.exporg_'+cntset).html('Organization is Required.');
					} else {
						if (!exporg.match(alphanumerics_spaces)) {
							e_error = 1;
							$('.exporg_'+cntset).html('Organization only use Alphanumeric values with [ _ , - ], Check again.');
						} else {
							$('.exporg_'+cntset).html('');
						}
					}
					if (expyear == "") {
						e_error = 1;
						$('.expyear_'+cntset).html('Year is Required.');
					} else {
						if (!expyear.match(onlynumerics)) {
							e_error = 1;
							$('.expyear_'+cntset).html('Year only use numeric values, Check again.');
						} else {
							$('.expyear_'+cntset).html('');
						}
					}
					if (expmonth == "") {
						e_error = 1;
						$('.expmonth_'+cntset).html('Month is Required.');
					} else {
						if (!expmonth.match(onlynumerics)) {
							e_error = 1;
							$('.expmonth_'+cntset).html('Month only use numeric values, Check again.');
						} else {
							$('.expmonth_'+cntset).html('');
						}
					}
					if(expyear != "" && expmonth != ""){
						if(parseInt(expyear) == 0 && parseInt(expmonth) == 0){
							e_error = 1;
							error_message = error_message + "<br/>Period Both 0 not Allowed here, Check Again.";
						}
					}
					if($('.expattach_marks_'+cntset).html() == ""){
						if (document.getElementById("expmarksheet_"+cntset).files.length == 0) {
							e_error = 1;
							$('.expmarksheet_'+cntset).html('Certificate is Required.');
						} else {
							var fileInput = document.getElementById('expmarksheet_'+cntset);
							var filePath = fileInput.value;
							//alert(fileInput.files[0].size);
							if (!allowedExtensions.exec(filePath)) {
								e_error = 1;
								$('.expmarksheet_'+cntset).html('Certificate type Invalid.(Use PDF/Image)');
							}else if (fileInput.files[0].size > docFileMaxSize) {
								e_error = 1;
								$('.expmarksheet_'+cntset).html('Certificate Size must be less than or equal to 2 MB');
							} else {
								$('.expmarksheet_'+cntset).html('');
							}
						}
					}
					
				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();	
						form_data.append('total_exp', esexp_total_rej);
						for(var cntsetss = 0; cntsetss<esexp_total_rej; cntsetss++){

							var expid = $("input[name='expid_"+cntsetss+"']").val();
							var exp_rej_id = $("input[name='exp_rej_id_"+cntsetss+"']").val();
							var exporg = $("input[name='exporg_"+cntsetss+"']").val();
							var expyear = $("input[name='expyear_"+cntsetss+"']").val();
							var expmonth = $("input[name='expmonth_"+cntsetss+"']").val();
							//alert($("input[name='marksheet_"+cntsetss+"']").val());
							var expmarksheet = $("input[name='expmarksheet_"+cntsetss+"']")[0].files;

							form_data.append('expid[]', expid);
							form_data.append('exp_rej_id[]', exp_rej_id);
							form_data.append('exporg[]', exporg);
							form_data.append('expyear[]', parseInt(expyear));
							form_data.append('expmonth[]', parseInt(expmonth));
							if($("input[name='expmarksheet_"+cntsetss+"']").val() != ""){
								form_data.append('files['+cntsetss+']', expmarksheet[0]);
							}else{
								form_data.append('files['+cntsetss+']', '');
							}
						}

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_es_service_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_has_ds_service"){

				var dexp_total_rej = parseInt($("#dexp_total_rej").val());
				for(var cntset = 0; cntset<dexp_total_rej; cntset++){

					//var exam_name = $("select[name='exam_name_"+cntset+"'] option:selected").val();
					var dexpid = $("input[name='dexpid_"+cntset+"']").val();
					var dexp_rej_id = $("input[name='dexp_rej_id_"+cntset+"']").val();
					var dexporg = $("input[name='dexporg_"+cntset+"']").val();
					var dexpyear = $("input[name='dexpyear_"+cntset+"']").val();
					var dexpmonth = $("input[name='dexpmonth_"+cntset+"']").val();
					var dexpmarksheet = $("input[name='dexpmarksheet_"+cntset+"']")[0].files;
					//var files = $('#advice_doc')[0].files;
					
					if(dexpid == "" || dexp_rej_id == ""){
						e_error = 1;
						$('.dexpid_'+cntset).html('Experience is Required');
					}else{
						$('.dexpid_'+cntset).html('');
					}
					if (dexporg == "") {
						e_error = 1;
						$('.dexporg_'+cntset).html('Organization is Required.');
					} else {
						if (!dexporg.match(alphanumerics_spaces)) {
							e_error = 1;
							$('.dexporg_'+cntset).html('Organization only use Alphanumeric values with [ _ , - ], Check again.');
						} else {
							$('.dexporg_'+cntset).html('');
						}
					}
					if (dexpyear == "") {
						e_error = 1;
						$('.dexpyear_'+cntset).html('Year is Required.');
					} else {
						if (!dexpyear.match(onlynumerics)) {
							e_error = 1;
							$('.dexpyear_'+cntset).html('Year only use numeric values, Check again.');
						} else {
							$('.dexpyear_'+cntset).html('');
						}
					}
					if (dexpmonth == "") {
						e_error = 1;
						$('.dexpmonth_'+cntset).html('Month is Required.');
					} else {
						if (!dexpmonth.match(onlynumerics)) {
							e_error = 1;
							$('.dexpmonth_'+cntset).html('Month only use numeric values, Check again.');
						} else {
							$('.dexpmonth_'+cntset).html('');
						}
					}
					if(dexpyear != "" && dexpmonth != ""){
						if(parseInt(dexpyear) == 0 && parseInt(dexpmonth) == 0){
							e_error = 1;
							error_message = error_message + "<br/>Period Both 0 not Allowed here, Check Again.";
						}
					}
					if($('.dexpattach_marks_'+cntset).html() == ""){
						if (document.getElementById("dexpmarksheet_"+cntset).files.length == 0) {
							e_error = 1;
							$('.dexpmarksheet_'+cntset).html('Certificate is Required.');
						} else {
							var fileInput = document.getElementById('dexpmarksheet_'+cntset);
							var filePath = fileInput.value;
							//alert(fileInput.files[0].size);
							if (!allowedExtensions.exec(filePath)) {
								e_error = 1;
								$('.dexpmarksheet_'+cntset).html('Certificate type Invalid.(Use PDF/Image)');
							}else if (fileInput.files[0].size > docFileMaxSize) {
								e_error = 1;
								$('.dexpmarksheet_'+cntset).html('Certificate Size must be less than or equal to 2 MB');
							} else {
								$('.dexpmarksheet_'+cntset).html('');
							}
						}
					}
					
				}
				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();	
						form_data.append('total_exp', dexp_total_rej);
						for(var cntsetss = 0; cntsetss<dexp_total_rej; cntsetss++){

							var dexpid = $("input[name='dexpid_"+cntsetss+"']").val();
							var dexp_rej_id = $("input[name='dexp_rej_id_"+cntsetss+"']").val();
							var dexporg = $("input[name='dexporg_"+cntsetss+"']").val();
							var dexpyear = $("input[name='dexpyear_"+cntsetss+"']").val();
							var dexpmonth = $("input[name='dexpmonth_"+cntsetss+"']").val();
							//alert($("input[name='marksheet_"+cntsetss+"']").val());
							var dexpmarksheet = $("input[name='dexpmarksheet_"+cntsetss+"']")[0].files;

							form_data.append('expid[]', dexpid);
							form_data.append('exp_rej_id[]', dexp_rej_id);
							form_data.append('exporg[]', dexporg);
							form_data.append('expyear[]', parseInt(dexpyear));
							form_data.append('expmonth[]', parseInt(dexpmonth));
							if($("input[name='dexpmarksheet_"+cntsetss+"']").val() != ""){
								form_data.append('files['+cntsetss+']', dexpmarksheet[0]);
							}else{
								form_data.append('files['+cntsetss+']', '');
							}
						}

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_ds_service_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_exempted"){

				//var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();
				var fu_exc_reason = $('textarea[name="fu_exc_reason"]').val();
				var fu_exc_doc = $('input[name="fu_exc_doc"]')[0].files;

				if (fu_exc_reason == "") {
					e_error = 1;
					$('.fu_exc_reason').html('Description is Required');
				} else if (!fu_exc_reason.match(alphanumerics_no)) {
					e_error = 1;
					$('.fu_exc_reason').html('Illegal character(s) used, Check again.');
				} else {
					$('.fu_exc_reason').html('');
				}

				fileInput = document.querySelector('input[name="fu_exc_doc"]');

				filePath = fileInput.value;

				if (document.querySelector('input[name="fu_exc_doc"]').files.length == 0) {
					if ($('.fu_uploaded_exc').text() == '') {
						e_error = 1;
						$('.fu_exc_doc').html('Document is Required.');
					}
				} else if (fileInput.value != "" && !allowedExtensions.exec(filePath)) {
					e_error = 1;
					$('.fu_exc_doc').html('Document File type Invalid.(Use Image File or PDF)');
				} else {
					$('.fu_exc_doc').html('');
				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append("fu_exc_reason", fu_exc_reason);
						form_data.append("fu_exc_doc", fu_exc_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_exempted_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}
			}else if(checktype == "fu_exservice"){

				//var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();
				var fu_exs_reason = $('textarea[name="fu_exs_reason"]').val();
				var fu_exs_doc = $('input[name="fu_exs_doc"]')[0].files;

				if (fu_exs_reason == "") {
					e_error = 1;
					$('.fu_exs_reason').html('Description is Required');
				} else if (!fu_exs_reason.match(alphanumerics_no)) {
					e_error = 1;
					$('.fu_exs_reason').html('Illegal character(s) used, Check again.');
				} else {
					$('.fu_exs_reason').html('');
				}

				fileInput = document.querySelector('input[name="fu_exs_doc"]');

				filePath = fileInput.value;

				if (document.querySelector('input[name="fu_exs_doc"]').files.length == 0) {
					if ($('.fu_uploaded_exservice').text() == '') {
						e_error = 1;
						$('.fu_exs_doc').html('Document is Required.');
					}
				} else if (fileInput.value != "" && !allowedExtensions.exec(filePath)) {
					e_error = 1;
					$('.fu_exs_doc').html('Document File type Invalid.(Use Image File or PDF)');
				} else {
					$('.fu_exs_doc').html('');
				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append("fu_exs_reason", fu_exs_reason);
						form_data.append("fu_exs_doc", fu_exs_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_exservice_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else if(checktype == "fu_ews"){

				//var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();
				var fu_ews_reason = $('textarea[name="fu_ews_reason"]').val();
				var fu_ews_doc = $('input[name="fu_ews_doc"]')[0].files;

				if (fu_ews_reason == "") {
					e_error = 1;
					$('.fu_ews_reason').html('Description is Required');
				} else if (!fu_ews_reason.match(alphanumerics_no)) {
				e_error = 1;
					$('.fu_ews_reason').html('Illegal character(s) used, Check again.');
				} else {
					$('.fu_ews_reason').html('');
				}

				fileInput = document.querySelector('input[name="fu_ews_doc"]');

				filePath = fileInput.value;

				if (document.querySelector('input[name="fu_ews_doc"]').files.length == 0) {
					if ($('.fu_uploaded_ews').text() == '') {
						e_error = 1;
						$('.fu_ews_doc').html('Document is Required.');
					}
				} else if (fileInput.value != "" && !allowedExtensions.exec(filePath)) {
					e_error = 1;
					$('.fu_ews_doc').html('Document File type Invalid.(Use Image File or PDF)');
				} else {
					$('.fu_ews_doc').html('');
				}

				if (e_error == 1) {

					$('.div_roller_total').fadeOut();
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					$(".text-error").fadeIn();
					$('.button_submit').prop('disabled', false);

					setTimeout(function() {
						$('.text-error, .get_error_total').fadeOut();
					}, delay);

				} else {

					var conf_answer = confirm("Are you sure you want to Submit the Data?")
					if (conf_answer) {

						var form_data = new FormData();
						form_data.append("fu_ews_reason", fu_ews_reason);
						form_data.append("fu_ews_doc", fu_ews_doc[0]);

						$.ajax({
							method: 'POST',
							url: '<?php echo base_url() . "revised_data/resubmit_sprotsews_processing"; ?>',
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
									$('.get_success_total').html('Data Updation Successfully completed.');
									$(".get_success_total").fadeIn();
									$('input, select').val('');
									$('input').html('');
									setTimeout(function() {
										$('.get_success_total').fadeOut();
									}, 3000);

									setTimeout(function() {
										window.location.replace("<?php echo site_url('revised_data/form_fillup') ?>");
									}, 3000);

								} else {
									$('.div_roller_total').fadeOut();
									error_message = "There have some problem to Update Data, Try Again.";
									error_message = error_message + "<br/>" + data.e_msg;
									$('.get_error_total').html(error_message);
									$('.button_submit').prop('disabled', false);
									$(".get_error_total").fadeIn();
									setTimeout(function() {
										$('.get_error_total').fadeOut();
									}, delay);
								}
							}
						});
					}else{
						$('.div_roller_total').fadeOut();
						$('.button_submit').prop('disabled', false);
					}
				}

			}else{
				$('.div_roller_total').fadeOut();
				$('.get_error_total').html(error_message+ "<br/>Please Choose the Section properly.");
				$(".get_error_total").fadeIn();
				$(".text-error").fadeIn();
				$('.button_submit').prop('disabled', false);

				setTimeout(function() {
					$('.text-error, .get_error_total').fadeOut();
				}, delay);
			}
			return false;
			

			

			/*var fu_has_service = $('input[name="service_yesno"]:checked').val();

			var exp_counter = $('#exp_counter').val();
			var ess_exp_counter = $('#ess_exp_counter').val();*/

			<?php if($adv_detail->adv_has_experience == "Yes111111"){ ?>
			
				if (fu_has_service == '' || fu_has_service == undefined) {

					$('.service_yesno').html('Required')

					e_error = 1

				} else if (fu_has_service != 'Yes' && fu_has_service != 'No') {

					$('.service_yesno').html('Value should be between Yes or No')

					e_error = 1

				} else {

					$('.service_yesno').html('')

				}

				if (fu_has_service == 'Yes') {

					if((parseInt(exp_counter) == 0) && (parseInt(ess_exp_counter) == 0)){
						e_error = 1;
						error_message = error_message + "<br/>Experience is Required, insert It.";
					}else if(parseInt(ess_exp_counter) == 0 && totalexp != 0){
						e_error = 1;
						error_message = error_message + "<br/>Essential Experience is Required, insert It.";
					}

					
					for(var cntexset = 0; cntexset<totalexp; cntexset++){
						var sr_cntno = parseInt(cntexset)+1;
						var ess_minmonth = $('#ess_minmonth_'+sr_cntno).val();
						var ess_reach_month = $('#ess_reach_month_'+sr_cntno).val();
						if(parseInt(ess_reach_month) === 0){
							e_error = 1;
							error_message = error_message + "<br/>" + sr_cntno + " No. Essential Experience is Missing, Insert it.";
						}else{
							if(parseInt(ess_minmonth) > parseInt(ess_reach_month)){
								e_error = 1;
								error_message = error_message + "<br/>" + sr_cntno + " No. Essential Experience not Reached Minimum Criteria, Check Again.";
							}
						}
					}

					<?php foreach ($desire_expr as $des_exhids) { ?>
						var ds_minmonth = $('#desireexp_min_'+'<?php echo $des_exhids['expid']; ?>').val();
						var ds_reach_month = $('#desireexp_reach_month_'+'<?php echo $des_exhids['expid']; ?>').val();
						if((parseInt(ds_minmonth) > parseInt(ds_reach_month)) && (parseInt(ds_reach_month) != 0)){
							e_error = 1;
							error_message = error_message + "<br/>" + "<?php echo $des_exhids['exp_name']; ?>" + "(Desirable Exp.) not Reached Minimum Criteria, Check Again.";
						}
					<?php } ?>	


					var fileInput;

					var filePath;

				}
			
			<?php } ?>
			
			


				/*var form_data = new FormData();

				form_data.append('fu_has_service', fu_has_service);
				form_data.append('exp_counter', exp_counter);
				form_data.append('ess_exp_counter', ess_exp_counter);
				form_data.append('total_exam', totalexam);*/

			

		}




	function isDateTodayset(curdate) {
		var currVal = curdate;

		if (currVal == '')

			return false;

		var CurrentDate = new Date();
		var SelectedDate = new Date(currVal);
		//alert(CurrentDate);
		//alert(SelectedDate);
		if (CurrentDate > SelectedDate) {
			//alert(currVal);
			return true;
		} else {
			return false;
		}
	}

	function isDatecheck_dmY(txtDate) {

		var currVal = txtDate;

		if (currVal == '')

			return false;



		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex

		var dtArray = currVal.match(rxDatePattern); // is format OK?



		if (dtArray == null)

			return false;

		//Checks for dd/mm/yyyy format.

		dtMonth = dtArray[3];

		dtDay = dtArray[1];

		dtYear = dtArray[5];



		if (dtMonth < 1 || dtMonth > 12)

			return false;

		else if (dtDay < 1 || dtDay > 31)

			return false;

		else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)

			return false;

		else if (dtMonth == 2)

		{

			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));

			if (dtDay > 29 || (dtDay == 29 && !isleap))

				return false;

		}

		return true;

	}



	function isDatecheck(txtDate)
	{

		var currVal = txtDate;

		if (currVal == '')

			return false;



		var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex

		var dtArray = currVal.match(rxDatePattern); // is format OK?



		if (dtArray == null)

			return false;



		//Checks for mm/dd/yyyy format.

		dtMonth = dtArray[3];

		dtDay = dtArray[5];

		dtYear = dtArray[1];



		if (dtMonth < 1 || dtMonth > 12)

			return false;

		else if (dtDay < 1 || dtDay > 31)

			return false;

		else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)

			return false;

		else if (dtMonth == 2)

		{

			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));

			if (dtDay > 29 || (dtDay == 29 && !isleap))

				return false;

		}

		return true;

	}
</script>



<script type="text/javascript">
	function yesnoCheck() {
		//var fu_caste_type = $("input[name='fu_caste_type']:checked").val();
		var fu_caste_type = $("select[name='fu_caste_type'] option:selected").val();

		if (fu_caste_type != 1)
		{
			document.getElementById('ifYes').style.display = 'block';
		} 
		else{
			document.getElementById('ifYes').style.display = 'none';
		}

	}



	function yesnoCheck2() {

		if (document.getElementById('yesCheck2').checked)

		{

			document.getElementById('ifyespwd').style.display = 'block';



		} else document.getElementById('ifyespwd').style.display = 'none';



	}



	function yesnoCheck3() {

		if (document.getElementById('yesCheck3').checked)

		{

			document.getElementById('ifyesexem').style.display = 'block';



		} else document.getElementById('ifyesexem').style.display = 'none';



	}



	function yesnoCheck4() {

		if (document.getElementById('yesCheck4').checked)

		{

			document.getElementById('ifyesex').style.display = 'block';



		} else document.getElementById('ifyesex').style.display = 'none';



	}



	function yesnoCheck5() {

		if (document.getElementById('yesCheck5').checked)

		{

			document.getElementById('ifyesews').style.display = 'block';



		} else document.getElementById('ifyesews').style.display = 'none';



	}

	function yesnoExtraage_Check(ageid) {
		//alert(ageid);
		var getageval = $('input[name="yesno_extage_'+ageid+'"]:checked').val();
		if (getageval == 'Yes')
		{
			$('#ifyesextage_'+ageid).show();
		} else{
			$('#ifyesextage_'+ageid).hide();
		}

	}



	function yesnoCheck6() {

		
		var getageval = $('input[name="service_yesno"]:checked').val();
		if (getageval == 'Yes')

		{
			$('#ifyesservice').show();
			$('#ifyesservice_des').show();
			//document.getElementById('ifyesservice').style.display = 'block';
			//document.getElementById('ifyesservice_des').style.display = 'block';


		} else{
			$('#ifyesservice').hide();
			$('#ifyesservice_des').hide();
			//document.getElementById('ifyesservice').style.display = 'none';
			//document.getElementById('ifyesservice_des').style.display = 'none';
		} 



	}



	function yesnoCheck7() {

		if (document.getElementById('yesCheck7').checked)

		{

			document.getElementById('ifyesemp').style.display = 'block';



		} else document.getElementById('ifyesemp').style.display = 'none';



	}


	
</script>
