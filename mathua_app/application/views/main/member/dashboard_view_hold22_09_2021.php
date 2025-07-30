<?php $this->load->view('main/component/login_header')?>

 

<style>

.alert-error, .text-error, .redclass{

    	color: red !important;

	}
	
.box3 {
    border: 1px solid #4db2ff;
}
</style>

<?php $pathurl = 'upload_file/candidates/'.$fuser_detailset->f_application_no.'/';?>

 <!-- Presentation -->

	<div class="container mt-3">

	<div class="row">

		<div class="col-sm-12" style="margin:30px 0;">

			<h3>Your Registration No. - <?php echo $fuser_detailset->f_application_no; ?></h3>

			<?php if($fuser_detailset->fu_final_submit == 0){ ?><h5>Complete Your Form Submission below -</h5>

			<?php }else{ ?><h5>Your Submission Form Details -</h5><?php } ?>

			

		</div>

	</div>



<div class="step-app" id="demo">

    <ul class="step-steps">

      <li data-step-target="step1" onclick="one_goto();">Step 1</li>

      <li <?php if($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 <= 2){ ?> data-step-target="step2" onclick="two_goto();" <?php } ?>>Step 2</li>

      <li <?php if($fuser_detailset->fu_step_2 == 1 && $fuser_detailset->fu_step_3 <= 2){ ?> data-step-target="step3" onclick="three_goto();" <?php } ?>>Step 3</li>

      <li <?php if($fuser_detailset->fu_step_3 == 1 && $fuser_detailset->fu_step_4 <= 2){ ?> data-step-target="step4" onclick="four_goto();" <?php } ?>>Step 4</li>

    </ul>

    

    <div class="step-content">

    

         

      <div class="step-tab-panel" data-step="step1">

        

       

        <div class="row">

		      <div class="col-sm-2 pr-0"> Applied For :</div>

            <div class="col-sm-4"> 

				      <select class="form-control" name="adv_no" id="adv_no" autocomplete="off" disabled>

                <option value="<?php echo $fuser_detailset->f_applied_for; ?>"><?php echo $adv_detail->adv_no.' | Recrutment For - '.$adv_detail->rm_name; ?></option>

              </select> 

				      <small class="text-error adv_no"><?php echo form_error('adv_no'); ?></small>

            </div>

            <div class="col-sm-2 pr-0">Full Name :</div>

      			<div class="col-sm-4"> 

      				<input type="text" name="fu_fullname" id="fu_fullname" autocomplete="off" class="form-control" placeholder="Full Name" value="<?php echo $fuser_detailset->f_full_name; ?>" <?php //if($fuser_detailset->fu_step_1 == 1){ echo "readonly";}?> readonly />

      				<small class="text-error fu_fullname"><?php echo form_error('fu_fullname'); ?></small>

      			</div>

        </div>

        <div class="row mt-3">

            <div class="col-sm-2 pr-0">Mobile No :</div>

            <div class="col-sm-4">

				      <input type="text" name="fu_mobile_no" id="fu_mobile_no" autocomplete="off" class="form-control" placeholder="Mobile" value="<?php echo $fuser_detailset->f_mobile; ?>" readonly />

				      <small class="text-error fu_mobile_no"><?php echo form_error('fu_mobile_no'); ?></small>

		        </div>

            <div class="col-sm-2 pr-0">Email :</div>

            <div class="col-sm-4">

      				<input type="text" name="fu_emailid" id="fu_emailid" autocomplete="off" class="form-control" placeholder="Email" value="<?php echo $fuser_detailset->f_email; ?>" readonly />

      				<small class="text-error fu_emailid"><?php echo form_error('fu_emailid'); ?></small>

		        </div>

        </div>

		<div class="row mt-3">

			<div class="col-sm-2 pr-0">Discipline :</div>

			<div class="col-sm-4"> 

				<select class="form-control" name="adv_cat" id="adv_cat" autocomplete="off" <?php if($fuser_detailset->fu_step_1 == 1){ echo "disabled";}?>>

					<?php if($fuser_detailset->fu_step_1 != 1){ ?>

					<option value="">---Select---</option>

					<?php foreach($adv_category as $cats){ ?>

					<option value="<?php echo $cats->acat_id; ?>" <?php if(!empty($fuser_detailset->fu_category)){if($cats->acat_id == $fuser_detailset->fu_category){echo "selected";}}?>><?php echo $cats->catm_name; ?></option>

					<?php }

					}else{ ?>

					<option value="<?php echo $adv_category->acat_id; ?>" selected="selected"><?php echo $adv_category->catm_name; ?></option>

					<?php } ?>

				</select>

				<small class="text-error adv_cat"><?php echo form_error('adv_cat'); ?></small>

			</div>

		</div>

		<div class="row mt-1">

			<div  class="col-sm-12 text-center">

				<div align="center">

					<div class="get_error_total_1" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

					<div class="get_success_total_1" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

					<div class="div_roller_total_1" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

				</div>

			</div>

		</div>

		<div class="row mt-1">

			<div class="col-sm-12 text-center">

			<?php if($fuser_detailset->fu_step_1 == 0 || $fuser_detailset->fu_step_1 == 2){ ?>

			<button class="btn btn-primary" onclick="one_step_save();">Save</button>

			<button class="btn btn-primary" onclick="one_step_process();">Procceed</button>

			<?php } ?>

			</div>

		</div>

      </div>

     

      <div class="step-tab-panel" data-step="step2">

   

			<div class="row">

				<div class="col-sm-2">Father's Name :</div>

				<div class="col-sm-4">

					<input type="text" class="form-control" data-toggle="tooltip" data-placement="top" title="Please enter your father's name" placeholder="Father's Name" id="father_name" name="father_name" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> value="<?= $fuser_detailset->fu_father_name ?>" /> 

					<small class="text-error father_name"><?php echo form_error('father_name'); ?></small>

				</div>

                <div class="col-sm-2">Mother's Name :</div>

                <div class="col-sm-4">

					<input type="text" class="form-control" data-toggle="tooltip" data-placement="top" title="Please enter your mother's name" placeholder="Mother's Name" id="mother_name" name="mother_name" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> value="<?= $fuser_detailset->fu_mother_name ?>" />

					<small class="text-error mother_name"><?php echo form_error('mother_name'); ?></small>

				</div>

            </div>

            <div class="row mt-3">

                <div class="col-sm-2">Gender :</div>

                <div class="col-sm-4">

					<label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_1" autocomplete="off" value="Male" <?php if($fuser_detailset->fu_gender == "Male") echo "checked" ?> <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Male</label>

                    <label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_2" autocomplete="off" value="Female" <?php if($fuser_detailset->fu_gender == "Female") echo "checked" ?> <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Female</label> 

                    <label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_3" autocomplete="off" value="Others" <?php if($fuser_detailset->fu_gender == "Others") echo "checked" ?> <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Others</label><br>

					<small class="text-error fu_gender"><?php echo form_error('fu_gender'); ?></small>

                </div>

                <div class="col-sm-2">Date of Birth :</div>

                <div class="col-sm-4">

					<input type="date" class="form-control" name="fu_dob" id="fu_dob" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> value="<?= $fuser_detailset->fu_dob ?>" />

					<small class="text-error fu_dob"><?php echo form_error('fu_dob'); ?></small>

				</div>

            </div>                      

            <div class="row mt-3">

				<div class="col-sm-2">Marital  Status :</div>

                <div class="col-sm-4">

                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_1" autocomplete="off" value="Single" <?php if($fuser_detailset->fu_marital_status == "Single") echo "checked" ?> <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Single</label>

                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_2" autocomplete="off" <?php if($fuser_detailset->fu_marital_status == "Married") echo "checked" ?> value="Married" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Married</label> 

                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_3" autocomplete="off" <?php if($fuser_detailset->fu_marital_status == "Widow") echo "checked" ?> value="Widow" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Widow</label> 

                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_4" autocomplete="off" <?php if($fuser_detailset->fu_marital_status == "Divorced") echo "checked" ?> value="Divorced" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Divorced</label><br>

					<small class="text-error fu_mt_status"><?php echo form_error('fu_mt_status'); ?></small>

                </div>

                <!--<div class="col-sm-2">Address :</div>

                <div class="col-sm-4">

					<textarea class="form-control" name="fu_address" id="fu_address" rows="3" autocomplete="off" <?php //if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?>><?= $fuser_detailset->fu_address?></textarea>

					<small class="text-error fu_address"><?php //echo form_error('fu_address'); ?></small>

				</div>-->

            </div>                     

            <div class="row">
				  
                  
                   
				<div class="col-sm-12 mt-2">
                                     <div class="box3">
                                      <div class="col-sm-12">
                                      <strong>Present Address</strong></div>
                                      <div class="row">
                                      <div class="col-sm-6">
                                      <div class="row p-2">
                                       <div class="col-sm-3 pl-4">State :</div>
                                 <div class="col-sm-9"> 
                                 <select class="form-control" id="exampleFormControlSelect1">
                                      <?php if($fuser_detailset->fu_step_2 != 1){ ?>

										<option value="">---Select---</option>

										<?php foreach($state_list as $states){ ?>

										<option value="<?php echo $states->state_id; ?>" <?php if(!empty($fuser_detailset->fu_domicile_state)){if($states->state_id == $fuser_detailset->fu_domicile_state){echo "selected";}}?>><?php echo $states->state_name; ?></option>

										<?php }

										}else{ ?>

										<option value="<?php echo $state_list[0]->state_id; ?>" selected="selected"><?php echo $state_list[0]->state_name; ?></option>

										<?php } ?>
                                       </select>
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">Sub-Division :</div>
                                 <div class="col-sm-9"> 
                                 <select class="form-control" id="exampleFormControlSelect1">
                                      <option>1</option>
                                      <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                        <option>5</option>
                                       </select>
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">PoliceStation :</div>
                                 <div class="col-sm-9"> 
                                 <select class="form-control" id="exampleFormControlSelect1">

                                      <option>1</option>
                                      <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                        <option>5</option>
                                       </select>
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">Vill / Para / House No /                                      Road :</div>
                                 <div class="col-sm-9"> 
                                 <input type="text" class="form-control">
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">Pin Code :</div>
                                 <div class="col-sm-9"> 
                                 <input type="text" class="form-control">
                                     </div>
                                     </div>
                                      </div>
                                      <div class="col-sm-6">
                                      <div class="row p-2">
                                       <div class="col-sm-3 pl-4">District :</div>
                                 

									<div class="col-sm-9"> 

										<select class="form-control" name="fu_district" id="fu_district" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){echo "disabled";}?>>

											<?php if($fuser_detailset->fu_step_2 != 1){ ?>

											<option value="">---Select---</option>

											<?php foreach($dist_list as $dists){ ?>

											<option value="<?php echo $dists->district_id; ?>" <?php if(!empty($fuser_detailset->fu_district)){if($dists->district_id == $fuser_detailset->fu_district){echo "selected";}}?>><?php echo $dists->district_name; ?></option>

											<?php }

											}else{ ?>

											<option value="<?php echo $dist_list->district_id; ?>" selected="selected"><?php echo $dist_list->district_name; ?></option>

											<?php } ?>              

										</select>

										<small class="text-error fu_district"><?php echo form_error('fu_district'); ?></small>

									</div>
									 
									 
									 
									 
                                     </div>
                                     <div class="row p-2 mt-2">
                                      
                                 <div class="col-sm-4 pl-5"> 
                                 <input type="radio" name="block_muni" class="form-check-input" 
                                 id="exampleCheck1"> Municipality
                                     </div>
                                      <div class="col-sm-4"> 
                                 <input type="radio" name="block_muni" class="form-check-input" 
                                 id="exampleCheck1"> Block
                                     </div>
                                      <div class="col-sm-4"> 
                                <select class="form-control" id="exampleFormControlSelect1">
                                      <option>1</option>
                                      <option>2</option>
                                       <option>3</option>
                                       <option>4</option>
                                        <option>5</option>
                                       </select>
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">Ward/GP :</div>
                                 <div class="col-sm-9"> 
                                 <input type="text" class="form-control">
                                     </div>
                                     </div>
                                     <div class="row p-2 mt-2">
                                       <div class="col-sm-3 pl-4">Post Office :</div>
                                 <div class="col-sm-9"> 
                                 <input type="text" class="form-control">
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

                

				<div class="col-sm-2 pr-0">Domicile State :</div>

                <div class="col-sm-4">

					<select class="form-control" name="fu_dom_state" id="fu_dom_state" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){echo "disabled";}?>>

						<?php if($fuser_detailset->fu_step_2 != 1){ ?>

						<option value="">---Select---</option>

						<?php foreach($state_list as $states){ ?>

						<option value="<?php echo $states->state_id; ?>" <?php if(!empty($fuser_detailset->fu_domicile_state)){if($states->state_id == $fuser_detailset->fu_domicile_state){echo "selected";}}?>><?php echo $states->state_name; ?></option>

						<?php }

						}else{ ?>

						<option value="<?php echo $state_list[0]->state_id; ?>" selected="selected"><?php echo $state_list[0]->state_name; ?></option>

						<?php } ?>

                    </select>

					<small class="text-error fu_dom_state"><?php echo form_error('fu_dom_state'); ?></small>

				</div>

            </div>                     

                                

			<div class="row mt-3">

                <div class="col-sm-2">Photo Upload :</div>

                <div class="col-sm-4">
                 
					<input type="file" name="fu_pic_doc" id="fu_pic_doc" class="form-control" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> />
          <small class="">File format should be in .png/.jpg/.jpeg format </small>        
          <small class="">Maximum file size is 500 KB</small> 
					<small class="text-error fu_pic_doc"><?php echo form_error('fu_pic_doc'); ?></small>

				

					<?php if(isset($fuser_detailset->fu_photo_doc) && !empty($fuser_detailset->fu_photo_doc)){?>

						<div class="fu_uploaded_photo">

						<a href="<?= base_url($pathurl.$fuser_detailset->fu_photo_doc)?>" target="_blank">Photo</a>

						</div>

					<?php }?>

				</div>

                <div class="col-sm-2">Signature Upload :</div>

                <div class="col-sm-4">

                 
					<input type="file" name="fu_sign_doc" id="fu_sign_doc" class="form-control" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> />
          <small class="">File format should be in .png/.jpg/.jpeg/.pdf format</small>        
          <small class="">Maximum file size is 2 MB </small>
					<small class="text-error fu_sign_doc"><?php echo form_error('fu_sign_doc'); ?></small>



					<?php if(isset($fuser_detailset->fu_signature_doc) && !empty($fuser_detailset->fu_signature_doc)){?>

						<div class="fu_uploaded_sign">

						<a href="<?= base_url($pathurl.$fuser_detailset->fu_signature_doc)?>" target="_blank">Signature</a>

						</div>

					<?php }?>

				</div>

            </div>

			<div class="row mt-3">

				<div class="col-sm-2">Date of Birth Proof Document :</div>

                <div class="col-sm-4">
                  
					<input type="file" name="fu_dob_doc" id="fu_dob_doc" class="form-control" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> />
          <small class="">File format should be in .png/.jpg/.jpeg/.pdf format</small>        
          <small class="">Maximum file size is 2 MB </small>
					<small class="text-error fu_dob_doc"><?php echo form_error('fu_dob_doc'); ?></small>



					<?php if(isset($fuser_detailset->fu_dob_doc) && !empty($fuser_detailset->fu_dob_doc)){?>

						<div class="fu_uploaded_dob">

						<a href="<?= base_url($pathurl.$fuser_detailset->fu_dob_doc)?>" target="_blank">Birth Proof Document</a>

						</div>

					<?php }?>

				</div>

                <div class="col-sm-2">Address Proof Document :</div>

                <div class="col-sm-4">
                
					<input type="file" name="fu_address_doc" id="fu_address_doc" class="form-control" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> />
          <small class="">File format should be in .png/.jpg/.jpeg/.pdf format</small>        
          <small class="">Maximum file size is 2 MB </small>  
					<small class="text-error fu_address_doc"><?php echo form_error('fu_address_doc'); ?></small>



					<?php if(isset($fuser_detailset->fu_address_doc) && !empty($fuser_detailset->fu_address_doc)){?>

						<div class="fu_uploaded_address">

						<a href="<?= base_url($pathurl.$fuser_detailset->fu_address_doc)?>" target="_blank">Address Proof Document</a>

						</div>

					<?php }?>

				</div>

            </div>

			<div class="row mt-1">

				<div  class="col-sm-12 text-center">

					<div align="center">

						<div class="get_error_total_2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="get_success_total_2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="div_roller_total_2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

					</div>

				</div>

			</div>

			<div class="row mt-1">

				<div class="col-sm-12 text-center">

				<?php if(($fuser_detailset->fu_step_1 == 1)&&($fuser_detailset->fu_step_2 == 0 || $fuser_detailset->fu_step_2 == 2)){ ?>

				<button class="btn btn-primary" onclick="two_step_save();">Save</button>

				<button class="btn btn-primary" onclick="two_step_process();">Procceed</button>

				<?php } ?>

				</div>

			</div>

      </div>

	  

      <div class="step-tab-panel" data-step="step3">

        

        <div class="row mt-3">

            <div class="col-sm-2">Caste :</div>

         	<div class="col-sm-10"> Yes 

         		

         		<input type="radio" onclick="javascript:yesnoCheck();" name="yesno_caste" id="yesCheck" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_caste == 'Yes') echo 'checked'?> value="Yes"> No 



         		<input type="radio" onclick="javascript:yesnoCheck();" name="yesno_caste" id="noCheck" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_caste == 'No') echo 'checked'?> value="No">

         		<br>

         		<small class="text-error fu_caste"><?php echo form_error('yesno_caste'); ?></small>

      			<div id="ifYes" <?php if($fuser_detailset->fu_caste == 'Yes') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>

            <?php foreach($caste_tab as $caste):?>
            
              <input type='radio' id='acc' name='fu_caste_type' value="<?= $caste->caste_id ?>" <?php if($fuser_detailset->fu_caste_type == $caste->caste_id) echo 'checked'?> <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>> <?= $caste->caste_name?>  
            
            <?php endforeach;?>

            <!-- 
  					<input type='radio' id='acc' name='fu_caste_type' value="2" <?php if($fuser_detailset->fu_caste_type == 2) echo 'checked'?> <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>> SC

  					<input type='radio' id='acc' name='fu_caste_type' value="3" <?php if($fuser_detailset->fu_caste_type == 3) echo 'checked'?> <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>> ST

       				<input type='radio' id='acc' name='fu_caste_type' value="4" <?php if($fuser_detailset->fu_caste_type == 4) echo 'checked'?> <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>> OBC A

        			<input type='radio' id='acc' name='fu_caste_type' value="5" <?php if($fuser_detailset->fu_caste_type == 5) echo 'checked'?> <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>> OBC B
            -->
        			<br>

        			<small class="text-error fu_caste_type"><?php echo form_error('fu_caste_type'); ?></small>

              <div class="row mt-2">
                <div class="col-sm-2" >
                  Community
                </div>
                <div class="col-sm-4" >

                    <select class="form-control" name="fu_caste_community" <?php if($fuser_detailset->fu_caste_type == NULL || $fuser_detailset->fu_step_3 == 1) echo "disabled" ?>>
                      <option value="">--SELECT--</option>
                      <?php if($fuser_detailset->fu_caste_type != NULL && $fuser_detailset->fu_caste_community != NULL){?>
                        <option value="<?= $caste_community->csdetail_id ?>" selected><?= $caste_community->csdetail_name ?></option>  
                      <?php }?>  
                    </select>

                    <small class="text-error fu_caste_community"><?php echo form_error('fu_caste_community'); ?></small>

                </div>
              </div>

        			<div class="row mt-2">

            			<div class="col-sm-2" >Certification No :</div>

            			<div class="col-sm-4" >

            				<input type="text" class="form-control" placeholder="Certification No" name="fu_caste_number" value="<?= $fuser_detailset->fu_caste_number ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?>/>

            				<small class="text-error fu_caste_number"><?php echo form_error('fu_caste_number'); ?></small>

            			</div>

            			<div class="col-sm-2">Issued By Whom </div>

            			<div class="col-sm-4" >
                    <select class="form-control" name="fu_caste_issue_whom" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>
                      <option value="">--SELECT--</option>
                      <?php foreach($caste_issuing_auth as $auth){?>
                        <option value="<?= $auth->cia_id ?>" <?php if($fuser_detailset->fu_caste_issue_whom == $auth->cia_id) echo "selected" ?> ><?= $auth->cia_name ?></option>
                      <?php } ?>
                    </select>
            				<!-- 
                    <input type="text" class="form-control" placeholder="name" type="text" name="fu_caste_issue_whom" value="<?= $fuser_detailset->fu_caste_issue_whom ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?> />
                    -->
            				<small class="text-error fu_caste_issue_whom"><?php echo form_error('fu_caste_issue_whom'); ?></small>

            			</div>

        

        			</div>

            

		            <div class="row mt-2">

		            	<div class="col-sm-2" > Issued by Date :</div>

		            	<div class="col-sm-4" > 

		            		<input type="date" class="form-control" name="fu_caste_issue_date" value="<?= $fuser_detailset->fu_caste_issue_date ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?>>

		            		<small class="text-error fu_caste_issue_date"><?php echo form_error('fu_caste_issue_date'); ?></small>

		            	</div>

		            	<div class="col-sm-2" > Doc Upload:</div>

		            	<div class="col-sm-4" > 

		            		<input type="file" name="fu_caste_doc" class="form-control" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

		            		<small class="text-error fu_caste_doc"><?php echo form_error('fu_caste_doc'); ?></small>

		            		<?php if(isset($fuser_detailset->fu_caste_doc) && !empty($fuser_detailset->fu_caste_doc)){?>

								<div class="fu_uploaded_caste">

								<a href="<?= base_url($pathurl.$fuser_detailset->fu_caste_doc)?>" target="_blank">Caste Document</a>

								</div>

							<?php }?>

		            	</div>

		            </div>

              

         		</div>

                 

			</div>

                 

                

        </div>

                                

                                

         <div class="row mt-3">

            <div class="col-sm-2">PWD :</div>

             <div class="col-sm-10"> Yes 

              

              <input type="radio" onclick="javascript:yesnoCheck2();" name="yesno_pwd" id="yesCheck2" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_pwd == 'Yes') echo 'checked'?> value="Yes"> No 

              

              <input type="radio" onclick="javascript:yesnoCheck2();" name="yesno_pwd" id="noCheck2" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_pwd == 'No') echo 'checked'?> value="No"><br> 

              <small class="text-error fu_pwd"><?php echo form_error('yesno_pwd'); ?></small>

             

                 <div class="row mt-2" id="ifyespwd" <?php if($fuser_detailset->fu_pwd == 'Yes') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>

                         <div class="row ">

                        <div class="col-sm-2 pl-4">Percentage of Disability :</div>

                        

                        <div class="col-sm-4">

                        	<input type="text" class="form-control" name="fu_pwd_percent" value="<?= $fuser_detailset->fu_pwd_percent ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?>>

                        	<small class="text-error fu_pwd_percent"><?php echo form_error('fu_pwd_percent'); ?></small>

                        </div>

                        

                        <div class="col-sm-2 ">Issuing Authority:</div>

                        

                        <div class="col-sm-3">

                        	<input type="text" class="form-control" name="fu_pwd_issue_whom" value="<?= $fuser_detailset->fu_pwd_issue_whom ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?> >

                        	<small class="text-error fu_pwd_issue_whom"><?php echo form_error('fu_pwd_issue_whom'); ?></small>

                        </div>

                        </div>

                                

         	            <div class="row mt-2">

                        <div class="col-sm-2 pl-4" >Issued by Date :</div>

                        <div class="col-sm-4" >

                        	<input type="date" class="form-control" name="fu_pwd_issue_date" value="<?=$fuser_detailset->fu_pwd_issue_date ?>" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?>>

                        	<small class="text-error fu_pwd_issue_date"><?php echo form_error('fu_pwd_issue_date'); ?></small>

                        </div>

                        <div class="col-sm-2" >Doc Upload:</div>

                        <div class="col-sm-3" >

                        	<input type="file" name="fu_pwd_doc" class="form-control" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                        	<small class="text-error fu_pwd_doc"><?php echo form_error('fu_pwd_doc'); ?></small>

                        	<?php if(isset($fuser_detailset->fu_pwd_doc) && !empty($fuser_detailset->fu_pwd_doc)){?>

								<div class="fu_uploaded_pwd">

								<a href="<?= base_url($pathurl.$fuser_detailset->fu_pwd_doc)?>" target="_blank">PWD Document</a>

								</div>

							<?php }?>



                        </div>

                        

                        </div>

                        </div>

                     </div>

                                     

                                    

                </div>  

                                

           <?php if($adv_detail->adv_has_exampted == "Yes"){?>               

           <div class="row mt-3">

                                <div class="col-sm-2">Exempted :</div>

                                 <div class="col-sm-10"> Yes 

                                  

                                  <input type="radio" onclick="javascript:yesnoCheck3();" name="yesno_exempted" id="yesCheck3" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_exempted == 'Yes') echo 'checked'?> value="Yes"> No 



                                  <input type="radio" onclick="javascript:yesnoCheck3();" name="yesno_exempted" id="noCheck3" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_exempted == 'No') echo 'checked'?> value="No"><br> 

                                  <small class="text-error fu_exempted"><?php echo form_error('yesno_exempted'); ?></small>

                                 

                                     <div class="row mt-2" id="ifyesexem" <?php if($fuser_detailset->fu_exempted == 'Yes') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>

                                     <div class="row pl-2">

                                <div class="col-sm-2 pl-4">Reason :</div>

                                <div class="col-sm-4">

                                	<select class="form-control" rows="3" name="fu_exc_reason" id="reason" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                                		<option value="option_1" <?php if($fuser_detailset->fu_exc_reason == "option_1") echo "selected";?>>Option 1</option>



                                		<option value="option_2" <?php if($fuser_detailset->fu_exc_reason == "option_2") echo "selected";?>>Option 2</option>

                                		<option value="option_3" <?php if($fuser_detailset->fu_exc_reason == "option_3") echo "selected";?>>Option 3</option>

                                	</select >

                                	<!-- <textarea ><?= $fuser_detailset->fu_exc_reason ?></textarea> -->

                                	<small class="text-error fu_exc_reason"><?php echo form_error('fu_exc_reason'); ?></small>

                                </div>

                                <div class="col-sm-2">Upload Doc :</div>

                                <div class="col-sm-3">

                                	<input type="file" name="fu_exc_doc" class="form-control" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                                	<small class="text-error fu_exc_doc"><?php echo form_error('fu_exc_doc'); ?></small>

                                	<?php if(isset($fuser_detailset->fu_exc_doc) && !empty($fuser_detailset->fu_exc_doc)){?>

										<div class="fu_uploaded_exc">

										<a href="<?= base_url($pathurl.$fuser_detailset->fu_exc_doc)?>" target="_blank"> Document</a>

										</div>

									<?php }?>

                                </div>

                                </div>

                                

                                      

                                </div>

                                     </div>

                                     

                                    

                                </div>

			<?php }?>  

            

             <?php if($adv_detail->adv_has_exservice == "Yes"){?>                     

            <div class="row mt-3">

                                <div class="col-sm-2">Ex Serviceman :</div>

                                 <div class="col-sm-10"> Yes 

                                  

                                  <input type="radio" onclick="javascript:yesnoCheck4();" name="yesno_exservice" id="yesCheck4" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_exservice == 'Yes') echo 'checked'?> value="Yes"> No 



                                  <input type="radio" onclick="javascript:yesnoCheck4();" name="yesno_exservice" id="noCheck4" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_exservice == 'No') echo 'checked'?> value="No"><br> 

                                  <small class="text-error fu_exservice"><?php echo form_error('yesno_exservice'); ?></small>

                                 

                                     <div class="row mt-2" id="ifyesex" <?php if($fuser_detailset->fu_exservice == 'Yes') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>

                                     <div class="row pl-2">

                                <div class="col-sm-2 pl-4">Reason :</div>

                                <div class="col-sm-4">

                                	<select class="form-control" rows="3" id="reason" name="fu_exs_reason" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                                		<option value="option_1" <?php if($fuser_detailset->fu_exs_reason == "option_1") echo "selected";?>>Option 1</option>



                                		<option value="option_2" <?php if($fuser_detailset->fu_exs_reason == "option_2") echo "selected";?>>Option 2</option>

                                		<option value="option_3" <?php if($fuser_detailset->fu_exs_reason == "option_3") echo "selected";?>>Option 3</option>

                                	</select >

                                	<!-- <textarea ><?= $fuser_detailset->fu_exs_reason?></textarea> -->

                                	<small class="text-error fu_exs_reason"><?php echo form_error('fu_exs_reason'); ?></small>

                                </div>

                                <div class="col-sm-2">Upload Doc :</div>

                                <div class="col-sm-3">

                                	<input type="file" name="fu_exs_doc" class="form-control" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                                	<small class="text-error fu_exs_doc"><?php echo form_error('fu_exs_doc'); ?></small>

                                	<?php if(isset($fuser_detailset->fu_exs_doc) && !empty($fuser_detailset->fu_exs_doc)){?>

										<div class="fu_uploaded_exservice">

										<a href="<?= base_url($pathurl.$fuser_detailset->fu_exs_doc)?>" target="_blank">Ex Service Document</a>

										</div>

									<?php }?>

                                </div>

                                </div>

                                

                                      

                                </div>

                                     </div>

                                     

                                    

                                </div> 

            <?php }?>            

            

            <?php if($adv_detail->adv_has_age_relax == "Yes"){?>                    

            <div class="row mt-3">

                                <div class="col-sm-2">Age Relaxion:</div>

                                 <div class="col-sm-10"> Yes 

                                 

                                  <input type="radio" onclick="javascript:yesnoCheck5();" name="yesno_age_relax" id="yesCheck5" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_age_relax == 'Yes') echo 'checked'?> value="Yes"> No 



                                  <input type="radio" onclick="javascript:yesnoCheck5();" name="yesno_age_relax" id="noCheck4" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_age_relax == 'No') echo 'checked'?> value="No"><br> 

                                  <small class="text-error fu_age_relax"><?php echo form_error('yesno_age_relax'); ?></small>

                                 

                                     <div class="row mt-2" id="ifyesage" <?php if($fuser_detailset->fu_age_relax == 'Yes') echo 'style="display:block"'; else echo 'style="display:none"'; ?>>

                                     <div class="row pl-2">

                                <div class="col-sm-2 pl-4">Reason :</div>

                                <div class="col-sm-4">

                                	<textarea class="form-control" rows="3" id="reason" name="fu_age_relax_reason" <?php if($fuser_detailset->fu_step_3 == 1){ echo "readonly";}?>><?= $fuser_detailset->fu_age_relax_reason ?></textarea>

                                	<small class="text-error fu_age_relax_reason"><?php echo form_error('fu_age_relax_reason'); ?></small>

                                </div>

                                <div class="col-sm-2">Upload Doc :</div>

                                <div class="col-sm-3">

                                	<input type="file" name="fu_age_relax_doc" class="form-control" <?php if($fuser_detailset->fu_step_3 == 1){ echo "disabled";}?>>

                                	<small class="text-error fu_age_relax_doc"><?php echo form_error('fu_age_relax_doc'); ?></small>

                                	<?php if(isset($fuser_detailset->fu_age_relax_doc) && !empty($fuser_detailset->fu_age_relax_doc)){?>

										<div class="fu_uploaded_age_relax">

										<a href="<?= base_url($pathurl.$fuser_detailset->fu_age_relax_doc)?>" target="_blank">Document</a>

										</div>

									<?php }?>

                                </div>

                                </div>

                                

                                      

                                </div>

                                     </div>

                                     

                                    

                                </div> 

            <?php }?>			                                      

                                                                        

            <div class="row mt-1">

				<div  class="col-sm-12 text-center">

					<div align="center">

						<div class="get_error_total_3" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="get_success_total_3" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="div_roller_total_3" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

					</div>

				</div>

			</div>

			<div class="row mt-1">

				<div class="col-sm-12 text-center">

				<?php 

				if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1)&&($fuser_detailset->fu_step_3 == 0 || $fuser_detailset->fu_step_3 == 2)){ ?>

					<button class="btn btn-primary" onclick="three_step_save();">Save</button>

					<button class="btn btn-primary" onclick="three_step_process();">Procceed</button>

				<?php } ?>

				</div>

			</div>

      </div>

	  

      <div class="step-tab-panel" data-step="step4">

        <h3>Qualification</h3>



<div class="quali">

<div class="row " >

  <div class="col">

  <div class="row pl-2 pr-2"><label>Examination<br>

 Name </label></div>

	  <div class="row pl-2 pr-2 ">

	   <select class="form-control exam-name-input" name="exam_name" id="exampleFormControlSelect1" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?>>

	   	<?php foreach($quali_exam as $exam){?>

            <option value="<?= $exam->qm_id?>"><?= $exam->qm_name?></option>

	    <?php }?>

		</select>

	  </div>

	  <small class="text-error exam_name"><?php echo form_error('exam_name'); ?></small>

  </div>

  <div class="col">

  <div class="row  pl-2 pr-2"><label>University<br>

 Name </label>

  </div>

  <div class="row  pl-2 pr-2"><input type="text" class="form-control univ-input" name="univ" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?>></div>

  <small class="text-error univ"><?php echo form_error('univ'); ?></small>

  </div>

   <div class="col">

  <div class="row  pl-2 pr-2"><label>State<br>

 Name </label>

  </div>

  <div class="row  pl-2 pr-2">

    <!-- <input type="text" class="form-control state-input" name="state"> -->

    <select class="form-control state-input" name="state" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?>>

      <option value="">---Select---</option>

      <?php foreach($state_list_quali as $states){ ?>

      <option value="<?php echo $states->state_id; ?>"><?php echo $states->state_name; ?></option>

      <?php }?>

    </select>

  </div>

  <small class="text-error state"><?php echo form_error('state'); ?></small>

  </div>

  <div class="col">

  <div class="row  pl-2 pr-2"><label>Marks<br> Obtained</label></div>

   <div class="row  pl-2 pr-2">

   <input type="text" class="form-control marks-obtained-input" name="marks_obtained" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?>></div>

   <small class="text-error marks_obtained"><?php echo form_error('marks_obtained'); ?></small>

   </div>

  <div class="col">

   <div class="row  pl-2 pr-2"><label>Full<br> Marks <br></label> </div>

   <div class="row  pl-2 pr-2"><input type="text" class="form-control marks-full-input" name="marks_full" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?>></div>

   <small class="text-error marks_full"><?php echo form_error('marks_full'); ?></small>

   </div>

 

  <div class="col">

  <div class="row  pl-2 pr-2">

  <label>% of<br>

 Marks <br></label></div>

  <div class="row  pl-2 pr-2">

  <input type="text" class="form-control marks-percent-input" name="marks_percent" readonly="">

  </div>

  <small class="text-error marks_percent"><?php echo form_error('marks_percent'); ?></small>

  </div>

  <div class="col">

  <div class="row  pl-2 pr-2"><label>Marksheet <br>Issued Date </label></div>

  <div class="row  pl-2 pr-2">

  <input type="date" class="form-control marksheet-issue-date" name="marksheet_issue_date" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?>></div>

  <small class="text-error marksheet_issue_date"><?php echo form_error('marksheet_issue_date'); ?></small>

  </div>

  

  <div class="col">

  <div class="row  pl-2 pr-2"><label>Upload<br> Marksheet <br></label></div>

 <div class="row  pl-2 pr-2"><input type="file" name="marksheet" class="form-control marksheet" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?>></div>

 <small class="text-error marksheet"><?php echo form_error('marksheet'); ?></small>

</div>

 <?php if($fuser_detailset->fu_step_4 != 1){ ?>

 <div class="col" style="margin-top:55px;">

  

 <div class="row  pl-2"><button class="btn btn-primary btn-sm btn-add-row">Add Row</button>

 </div>

</div>

<?php } ?>

</div>



<div class="row mt-1">

  <div  class="col-sm-12 text-center">

    <div align="center">

      <div class="get_error_qualification_4" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

      <div class="get_success_qualification_4" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

      <div class="div_roller_qualification_4" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

    </div>

  </div>

</div>

<!-- ---------------------------------------------------------------------- -->

<div class="qualification">
<?php foreach($fuser_quali as $quali):?>

<div class="row " style="margin: 10px;">

  <div class="col">

	  <div class="row pl-2 pr-2 ">

	   <?= $quali->qm_name ?>

	  </div>

  </div>

  <div class="col">

  

  <div class="row  pl-2 pr-2">

  	<?= $quali->fu_council_board ?>

  </div>

  

  



  </div>



  <div class="col">

    <div class="row  pl-2 pr-2">

      <?= $quali->state_name ?>

    </div>

  </div>



  <div class="col">

  

   <div class="row  pl-2 pr-2">

   <?= $quali->fu_marks_obtained ?>

	</div>

   

   </div>

  <div class="col">

   <div class="row  pl-2 pr-2">

   	<?= $quali->fu_full_marks?>

   </div>

   </div>

 

  <div class="col">

  <div class="row  pl-2 pr-2">

  	<?= $quali->fu_percent_of_marks?>

  </div>

  </div>

  <div class="col">

  <div class="row  pl-2 pr-2">

  <?= $quali->fu_marksheet_issuedate?>

  </div>

  </div>

  

  <div class="col">

 <div class="row  pl-2 pr-2">

 	<a href="<?= base_url($pathurl.$quali->fu_quali_docs)?>" target="_blank">Marksheet</a>

 </div>

</div>

 <?php if($fuser_detailset->fu_step_4 != 1){ ?>

 <div class="col">

  <div class="row  pl-2">

  	<span class="btn btn-danger btn-delete-row" data-id='<?= $quali->fu_quali_id?>'><i class="fa fa-trash"></i></span>

  </div>

 

</div>

<?php }?>

</div>

<?php endforeach;?>
</div>

</div> 



           

            

            

        <div class="row mt-3">

                                <div class="col-sm-2">Service Experience :</div>

                                 <div class="col-sm-10"> Yes 

                                  <input type="radio" onclick="javascript:yesnoCheck6();" name="service_yesno" id="yesCheck6" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_has_service == 'Yes') echo "checked" ?> value="Yes"> No 

                                  <input type="radio" onclick="javascript:yesnoCheck6();" name="service_yesno" id="noCheck4" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_has_service == 'No') echo "checked" ?> value="No">

                                  <br>

                                  

                                  <small class="text-error service_yesno"><?php echo form_error('service_yesno'); ?></small><br> 

                                 	

                                     <div class="row mt-2" id="ifyesservice" style="display:none;">

                                     <div class="row pl-2">

                                <div class="col-sm-3 pl-4">Are you Govt employee ?</div>

                                <div class="col-sm-4">  <label class="radio-inline">

                                  <input type="radio" name="fu_current_gov_service" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_current_gov_service == 'Yes') echo "checked" ?> value="Yes"> Yes

                                </label>

                               <label class="radio-inline">

                                <input type="radio" name="fu_current_gov_service" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?> <?php if($fuser_detailset->fu_current_gov_service == 'No') echo "checked" ?> value="No"> No

                                  </label value="No"><br>

                                <small class="text-error fu_current_gov_service"><?php echo form_error('fu_current_gov_service'); ?></small><br>

                                

                                </div>

                                 

                                

                                </div>

                                    <div class="row mt-2" >

                                     <div class="row pl-4">

                                <div class="col-sm-2 pl-4">Designation :</div>

                                <div class="col-sm-3">

                                	<input type="text" name="fu_service_designation" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> class="form-control" value=<?= $fuser_detailset->fu_service_designation?>>

                                	<small class="text-error fu_service_designation"><?php echo form_error('fu_service_designation'); ?></small><br>

                                </div>

                                <div class="col-sm-2" style="padding-left:0px;">Experience :</div>

                                <div class="col-sm-2" >

                                	<input type="text" name="fu_service_exp_year" class="form-control" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> placeholder="Year" value="<?= $fuser_detailset->fu_service_exp_year?>" style="margin-left:30px;" >

                                	<small  style="margin-left:30px;"  class="text-error fu_service_exp_year"><?php echo form_error('fu_service_exp_year'); ?></small><br>

                                </div>

                                <div class="col-sm-2">

                                	<input type="text" name="fu_service_exp_month" class="form-control" placeholder="Month" style="margin-left:5px;" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?>  value="<?= $fuser_detailset->fu_service_exp_month?>" >

                                	<small class="text-error fu_service_exp_month"><?php echo form_error('fu_service_exp_month'); ?></small>

                                </div>

                                </div>

                                

                                      

                                </div>





                                <div class="col-sm-12 mt-2" >

                                     <div class="row ">



                                <div class="col-sm-2 p-0">Total Govt Experience :</div>

                                <div class="col-sm-2 p-0">

                                	<input type="text" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> name="fu_total_gov_exp_year" class="form-control" placeholder="year" value="<?= $fuser_detailset->fu_toal_gov_exp_year?>" >

                                	<small class="text-error fu_total_gov_exp_year"><?php echo form_error('fu_total_gov_exp_year'); ?></small>

                                </div>

                                 <div class="col-sm-2">

                                 	<input type="text" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> name="fu_total_gov_exp_month" class="form-control" placeholder="month" value="<?= $fuser_detailset->fu_toal_gov_exp_month?>">

                                 	<small class="text-error fu_total_gov_exp_month"><?php echo form_error('fu_total_gov_exp_month'); ?></small>

                                 </div>

                                  <div class="col-sm-2 p-0 fu_gov_exp_doc_div">Upload Doc:</div>

                                  <div class="col-sm-3 fu_gov_exp_doc_div">

                                  	<input type="file" name="fu_gov_exp_doc" class="form-control" placeholder="month" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?>>

                                  	<small class="text-error fu_gov_exp_doc"><?php echo form_error('fu_gov_exp_doc'); ?></small>

                                  	<?php if(isset($fuser_detailset->fu_gov_exp_doc) && !empty($fuser_detailset->fu_gov_exp_doc)){?>

										<div class="fu_uploaded_gov_exp_doc">

										<a href="<?= base_url($pathurl.$fuser_detailset->fu_gov_exp_doc)?>" target="_blank">Document</a>

										</div>

									<?php }?>

                                  </div>

                                

                                </div>

                                

                                      

                                </div>

                                

                                

                                <div class="col-sm-12 mt-4" >

                                     <div class="row ">

                                <div class="col-sm-2 p-0">Total Non Govt Experience </div>

                                <div class="col-sm-2 p-0">

                                	<input type="text" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> name="fu_total_nongov_exp_year" class="form-control" placeholder="year" value="<?= $fuser_detailset->fu_toal_nongov_exp_year?>" >

                                	<small class="text-error fu_total_nongov_exp_year"><?php echo form_error('fu_total_nongov_exp_year'); ?></small>

                                </div>

                                 <div class="col-sm-2">

                                 	<input type="text" <?php if($fuser_detailset->fu_step_4 == 1){ echo "readonly";}?> name="fu_total_nongov_exp_month" class="form-control" placeholder="month"value="<?= $fuser_detailset->fu_toal_nongov_exp_month?>" >

                                 	<small class="text-error fu_total_nongov_exp_month"><?php echo form_error('fu_total_nongov_exp_month'); ?></small>

                                 </div>

                                 

                                  <div class="col-sm-2 p-0 fu_nongov_exp_doc_div">Upload Doc:</div>

                                  <div class="col-sm-3 fu_nongov_exp_doc_div">

                                  	<input type="file" name="fu_nongov_exp_doc" class="form-control" placeholder="month" <?php if($fuser_detailset->fu_step_4 == 1){ echo "disabled";}?>>

                                  	<small class="text-error fu_nongov_exp_doc"><?php echo form_error('fu_nongov_exp_doc'); ?></small>



                                  	<?php if(isset($fuser_detailset->fu_nongov_exp_doc) && !empty($fuser_detailset->fu_nongov_exp_doc)){?>

										<div class="fu_uploaded_nongov_exp_doc">

										<a href="<?= base_url($pathurl.$fuser_detailset->fu_nongov_exp_doc)?>" target="_blank">Document</a>

										</div>

									<?php }?>

                                  </div>

                                </div>

                                </div>
                                </div>

                              </div>

                            </div> 

                                

                                

                                

                                

                                

                                                    

      <div class="row mt-1">

				<div  class="col-sm-12 text-center">

					<div align="center">

						<div class="get_error_total_4" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="get_success_total_4" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>

						<div class="div_roller_total_4" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>

					</div>

				</div>

			</div>



   <!-- <div class="step-footer"> 

    <button data-step-action="" class="step-btn" onclick="four_step_save();">Save</button>

    <button data-step-action="next" class="step-btn">Procceed</button>

   <button data-step-action="finish" class="step-btn" style="">Submit</button>

     	

           

       </div> --> 

       <?php 

				if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1 && $fuser_detailset->fu_step_3 == 1)&&( $fuser_detailset->fu_step_4 == 0 || $fuser_detailset->fu_step_4 == 2)){ ?>

       <div class="row mt-1">

			<div class="col-sm-12 text-center">

				<button data-step-action="" class="btn btn-primary step-btn" onclick="four_step_save();">Save</button>

			    <!-- <button data-step-action="next" class="step-btn">Procceed</button> -->

			    <button data-step-action="finish" class="btn btn-primary step-btn" onclick="finisher_step();" style="">Submit</button>

			</div>

		</div>

		<?php }?>                    

      

      </div>

     

    </div>



    

    

</div>





  </div>



<?php $this->load->view('main/component/footer'); ?>



<!--<script src="<?php //echo base_url(); ?>frontend/js/jquery.validate.min.js"></script>-->

<script src="<?php echo base_url(); ?>frontend/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>frontend/js/jquery-steps.js"></script>
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>-->


<script type="text/javascript">

	

	$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

	})



</script>



<script type="text/javascript">

	$(function(){

		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
	    $('.alert-error, .text-error').delay(8000).fadeOut();

	});



	const delay = 8000;

	var error_message = 'There have some errors please check above, Try again.';

	const alphaletters_spaces = /^[A-Za-z ]+$/;

	const alphaletters = /^[A-Za-z]+$/;

	const alphanumerics = /^[A-Za-z0-9]+$/;

	const alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;

	const alphanumerics_no = /^[A-Za-z0-9_/&(@):.,%\- \n\r]+$/;

	const onlynumerics = /^[0-9. ]+$/;

	const specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;

	const emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

	const allowedPic_Extensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;

	const allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;	



  const imageFileMaxSize = 512000 // 500 KB

  const docFileMaxSize =  2097152 //2 MB



  let govExpYear = parseInt($('input[name="fu_total_gov_exp_year"]').val()) | 0

  let govExpMonth = parseInt($('input[name="fu_total_gov_exp_month"]').val()) | 0

  let nongovExpYear = parseInt($('input[name="fu_total_nongov_exp_year"]').val()) | 0

  let nongovExpMonth = parseInt($('input[name="fu_total_nongov_exp_month"]').val()) | 0



  

    $('#demo').steps({

      /*onFinish: function () {

        finisher_step();

      }*/

	  <?php if($fuser_detailset->fu_step_1 != 1){ ?>

	  startAt: 0

	  <?php }elseif($fuser_detailset->fu_step_2 != 1){ ?>

	  startAt: 1

	  <?php }elseif($fuser_detailset->fu_step_3 != 1){ ?>

	  startAt: 2

	  <?php }elseif($fuser_detailset->fu_step_4 != 1){ ?>

	  startAt: 3

	  <?php } ?>

    });

	

	function one_goto(){

		//alert('Hit One');

	}

	function two_goto(){

		//alert('Hit Two');

		//return false;

	}

	function three_goto(){

		//alert('Hit Three');

	}

	function four_goto(){

		//alert('Hit Four');

	}

	

	<?php if($fuser_detailset->fu_step_1 == 0 || $fuser_detailset->fu_step_1 == 2){ ?>

	function one_step_save(){

		//alert('Hit One step Save');

		$('.div_roller_total_1').fadeIn();

		

		var e_error = 0;

		

    	var adv_no = $('#adv_no option:selected').val();

    	var fu_fullname = $('#fu_fullname').val();

    	var fu_mobile_no = $('#fu_mobile_no').val();

    	var fu_emailid = $('#fu_emailid').val();

    	var adv_cat = $('#adv_cat option:selected').val();

		

		if(adv_no == ""){

			e_error = 1;

			$('.adv_no').html('Applied For is Required.');

		}else{

			if(!adv_no.match(alphanumerics)){

				e_error = 1;

				$('.adv_no').html('Applied For not use special carecters, Check again.');

			}else{

				$('.adv_no').html('');

			}	

		}

		if(fu_fullname == ""){

			e_error = 1;

			$('.fu_fullname').html('Full Name is Required.');

		}else{

			if(!fu_fullname.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_fullname').html('Full Name not use special carecters [without _ / & : ( . ) , -], Check again.');

			}else{

				$('.fu_fullname').html('');

			}	

		}

		if(fu_emailid == ""){

			e_error = 1;

			$('.fu_emailid').html('Email-ID is Required.');

		}else{

			if(!emailpattern.test(fu_emailid)){

				e_error = 1;

				$('.fu_emailid').html('Email-ID not proper format, Check again.');

			}else{

				$('.fu_emailid').html('');

			}	

		}

		if(fu_mobile_no == ""){

			e_error = 1;

			$('.fu_mobile_no').html('Mobile No. is required.');

		}else{

			if(!fu_mobile_no.match(onlynumerics)){

				e_error = 1;

				$('.fu_mobile_no').html('Mobile No. needs only 10 digit.');

			}else if(fu_mobile_no.length != 10){

				e_error = 1;

				$('.fu_mobile_no').html('Mobile No. needs only 10 digit.');

			}else{

				$('.fu_mobile_no').html('');

			}

		}

		if(adv_cat != ""){

			if(!adv_cat.match(onlynumerics)){

				e_error = 1;

				$('.adv_cat').html('Discipline only use numeric carecters, Check again.');

			}else{

				$('.adv_cat').html('');

			}	

		}else{

			$('.adv_cat').html('');

		}

		

		//alert(salts);

		if(e_error == 1){

			$('.div_roller_total_1').fadeOut();

			$('.get_error_total_1').html(error_message);

			$(".get_error_total_1").fadeIn();

			$(".text-error").fadeIn();

			/*e_error = 0;

			error_message = '';*/

			setTimeout(function(){ $('.text-error, .get_error_total_1').fadeOut(); }, delay);

		}else{

			//alert(newhash);

			//alert(rehash);

			//$("#myForm").submit();

			var form_data = new FormData();

			//form_data.append('exam_gen',exam_gen);

			form_data.append('adv_no',adv_no);

			form_data.append('fu_fullname',fu_fullname);

			form_data.append('fu_mobile_no',fu_mobile_no);

			form_data.append('fu_emailid',fu_emailid);

			form_data.append('adv_cat',adv_cat);

			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/first_step_save"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					//alert(data.msg);

					if(data.msg == 1)

					{

						//console.log(data);

						//alert(data.msg[0].space_rate);

						$('.div_roller_total_1').fadeOut();

						$('.get_success_total_1').html('All Data Saved Successfully.');

						$(".get_success_total_1").fadeIn();

						setTimeout(function(){ $('.get_success_total_1').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

						$('.div_roller_total_1').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_1').html(error_message);

						$(".get_error_total_1").fadeIn();

						setTimeout(function(){ $('.get_error_total_1').fadeOut(); }, delay);

					}

					

				}

			});

			

		}

	}

	

	function one_step_process(){

		//alert('Hit One step Process');

		$('.div_roller_total_1').fadeIn();

		var e_error = 0;

		

    	var adv_no = $('#adv_no option:selected').val();

    	var fu_fullname = $('#fu_fullname').val();

    	var fu_mobile_no = $('#fu_mobile_no').val();

    	var fu_emailid = $('#fu_emailid').val();

    	var adv_cat = $('#adv_cat option:selected').val();

		

		if(adv_no == ""){

			e_error = 1;

			$('.adv_no').html('Applied For is Required.');

		}else{

			if(!adv_no.match(alphanumerics)){

				e_error = 1;

				$('.adv_no').html('Applied For not use special carecters, Check again.');

			}else{

				$('.adv_no').html('');

			}	

		}

		if(fu_fullname == ""){

			e_error = 1;

			$('.fu_fullname').html('Full Name is Required.');

		}else{

			if(!fu_fullname.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_fullname').html('Full Name not use special carecters [without _ / & : ( . ) , -], Check again.');

			}else{

				$('.fu_fullname').html('');

			}	

		}

		if(fu_emailid == ""){

			e_error = 1;

			$('.fu_emailid').html('Email-ID is Required.');

		}else{

			if(!emailpattern.test(fu_emailid)){

				e_error = 1;

				$('.fu_emailid').html('Email-ID not proper format, Check again.');

			}else{

				$('.fu_emailid').html('');

			}	

		}

		if(fu_mobile_no == ""){

			e_error = 1;

			$('.fu_mobile_no').html('Mobile No. is required.');

		}else{

			if(!fu_mobile_no.match(onlynumerics)){

				e_error = 1;

				$('.fu_mobile_no').html('Mobile No. needs only 10 digit.');

			}else if(fu_mobile_no.length != 10){

				e_error = 1;

				$('.fu_mobile_no').html('Mobile No. needs only 10 digit.');

			}else{

				$('.fu_mobile_no').html('');

			}

		}

		if(adv_cat == ""){

			e_error = 1;

			$('.adv_cat').html('Discipline is Required.');

		}else{

			if(!adv_cat.match(onlynumerics)){

				e_error = 1;

				$('.adv_cat').html('Discipline only use numeric carecters, Check again.');

			}else{

				$('.adv_cat').html('');

			}	

		}

		

		//alert(salts);

		if(e_error == 1){

			$('.div_roller_total_1').fadeOut();

			$('.get_error_total_1').html(error_message);

			$(".get_error_total_1").fadeIn();

			$(".text-error").fadeIn();

			/*e_error = 0;

			error_message = '';*/

			setTimeout(function(){ $('.text-error, .get_error_total_1').fadeOut(); }, delay);

		}else{

			//alert(newhash);

			//alert(rehash);

			//$("#myForm").submit();

			var conf_answer = confirm("Warning! You can not edit information after process ! Are you sure you want to Submit the Data for Process Further?")

			if(conf_answer){

				var form_data = new FormData();

				//form_data.append('exam_gen',exam_gen);

				form_data.append('adv_no',adv_no);

				form_data.append('fu_fullname',fu_fullname);

				form_data.append('fu_mobile_no',fu_mobile_no);

				form_data.append('fu_emailid',fu_emailid);

				form_data.append('adv_cat',adv_cat);

				$.ajax({

					method:'POST',

					url:'<?php echo base_url()."member/first_step_processing"; ?>',

					data:form_data,

					dataType:'JSON',

					contentType: false,

					processData: false,

					success:function(data){

						//alert(data.msg);

						if(data.msg == 1)

						{

							//console.log(data);

							//alert(data.msg[0].space_rate);

							$('.div_roller_total_1').fadeOut();

							$('.get_success_total_1').html('Data Updation Successfully completed.');

							$(".get_success_total_1").fadeIn();

							$('input, select').val('');

							$('input').html('');

							setTimeout(function(){ $('.get_success_total_1').fadeOut(); }, 3000);

							setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

							

							

						}else{

							$('.div_roller_total_1').fadeOut();

							error_message = "There have some problem to Store Data, Try after some time.";

							error_message = error_message + "<br/>" + data.e_msg;

							$('.get_error_total_1').html(error_message);

							$(".get_error_total_1").fadeIn();

							setTimeout(function(){ $('.get_error_total_1').fadeOut(); }, delay);

						}

						

					}

				});

			}else{

				$('.div_roller_total_1').fadeOut();

			}

		}

	}

	<?php } ?>

	

	<?php if(($fuser_detailset->fu_step_1 == 1) && ($fuser_detailset->fu_step_2 == 0 || $fuser_detailset->fu_step_2 == 2)){ ?>

	

	function two_step_save(){

		// alert('Hit Two step Save');

		$('.div_roller_total_2').fadeIn();	

		var e_error=0;



		var father_name = $('#father_name').val();

		var mother_name = $('#mother_name').val();

		

		var fu_gender_1 = $('#fu_gender_1')

		var fu_gender_2 = $('#fu_gender_2')

		var fu_gender_3 = $('#fu_gender_3')

		

		var fu_gender;

		if(fu_gender_1[0].checked){

			fu_gender = $('#fu_gender_1').val()

		}

		if(fu_gender_2[0].checked){

			fu_gender = $('#fu_gender_2').val()

		}

		if(fu_gender_3[0].checked){

			fu_gender = $('#fu_gender_3').val()

		}



		var fu_dob = $('#fu_dob').val();



		var fu_mt_status_1 = $('#fu_mt_status_1');

		var fu_mt_status_2 = $('#fu_mt_status_2');

		var fu_mt_status_3 = $('#fu_mt_status_3');

		var fu_mt_status_4 = $('#fu_mt_status_4');



		var fu_mt_status;

		if(fu_mt_status_1[0].checked){

			fu_mt_status = $('#fu_mt_status_1').val();

		}

		if(fu_mt_status_2[0].checked){

			fu_mt_status = $('#fu_mt_status_2').val();

		}

		if(fu_mt_status_3[0].checked){

			fu_mt_status = $('#fu_mt_status_3').val();

		}

		if(fu_mt_status_4[0].checked){

			fu_mt_status = $('#fu_mt_status_4').val();

		}



		var fu_address = $('#fu_address').val();

		var fu_district = $('#fu_district').val();

		var fu_dom_state = $('#fu_dom_state').val();

		var fu_pic_doc = $('#fu_pic_doc')[0].files;

		var fu_sign_doc = $('#fu_sign_doc')[0].files;

		var fu_dob_doc = $('#fu_dob_doc')[0].files;

		var fu_address_doc = $('#fu_address_doc')[0].files;





		if(!father_name.match(alphaletters_spaces) && father_name != ""){

			e_error = 1;

			$('.father_name').html('Only alphabet can be used, Check again.');

		}else{

			$('.father_name').html('');

		}



		if(!mother_name.match(alphaletters_spaces) && mother_name != ""){

			e_error = 1;

			$('.mother_name').html('Only alphabet can be used, Check again.');

		}else{

			$('.mother_name').html('');

		}



		

		if(fu_gender != undefined && !fu_gender.match(alphaletters)){

			e_error = 1;

			$('.fu_gender').html('Gender only Alphabet value, Check again.');

		}else{

			$('.fu_gender').html('');

		}

		if(fu_mt_status != undefined && !fu_mt_status.match(alphaletters)){

			e_error = 1;

			$('.fu_mt_status').html('Marital Status only Alphabet value, Check again.');

		}else{

			$('.fu_mt_status').html('');

		}



		if(isDatecheck(fu_dob) == false && fu_dob != ""){

			e_error = 1;

			$('.fu_dob').html('Date of Birth Format check properly.');

		}else{

			$('.fu_dob').html('');

		}



		if(!fu_address.match(alphanumerics_no) && fu_address != ""){

			e_error = 1;

			$('.fu_address').html('Special characters [without _ / & : ( . ) , -] can not be used, Check again.');

		}else{

			$('.fu_address').html('');

		}



		if(fu_district != "" && !fu_district.match(onlynumerics)){

			e_error = 1;

			$('.fu_district').html('District only use numeric value, Check again.');

		}else{

			$('.fu_district').html('');

		}



		if(!fu_dom_state.match(onlynumerics) && fu_dom_state != ""){

			e_error = 1;

			$('.fu_dom_state').html('Domicile State only use numeric value, Check again.');

		}else{

			$('.fu_dom_state').html('');

		}



		var fileInput;

		var filePath;



		// Picture checking

		fileInput = document.getElementById('fu_pic_doc'); 

		filePath = fileInput.value;

   

    if(fileInput.value == ""){

      $('.fu_pic_doc').html('');

    }

		else if(!allowedPic_Extensions.exec(filePath)){

			e_error = 1;

      

			$('.fu_pic_doc').html('Candidate Picture File type Invalid.(Use Image File)');

		}else{

      if(fileInput.files[0].size > imageFileMaxSize){

        e_error = 1;

        $('.fu_pic_doc').html('File size must be less than or equal to 500 KB');

      }

			else $('.fu_pic_doc').html('');

		}





		fileInput = document.getElementById('fu_sign_doc'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_sign_doc').html('');      

    }

    else if(!allowedExtensions.exec(filePath)){

			e_error = 1;

			$('.fu_sign_doc').html('Document File type Invalid.(Use Image File)');

		}else{



      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_sign_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_sign_doc').html('');

		}

		

		fileInput = document.getElementById('fu_dob_doc'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_dob_doc').html('');

    }

    else if(!allowedExtensions.exec(filePath)){

			e_error = 1;

			$('.fu_dob_doc').html('Document File type Invalid.(Use PDF/Image)');

		}else{

       

      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_dob_doc').html('File size must be less than or equal to 2 MB');

      }

			else $('.fu_dob_doc').html('');

		}

		

		

		fileInput = document.getElementById('fu_address_doc'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_address_doc').html('');

    }

    else if(!allowedExtensions.exec(filePath)){

			e_error = 1;

			$('.fu_address_doc').html('Document File type Invalid.(Use PDF/Image)');

		}else{



      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_address_doc').html('File size must be less than or equal to 2 MB');

      }

			

      else $('.fu_address_doc').html('');

		}





		if(e_error == 1){

			$('.div_roller_total_2').fadeOut();

			$('.get_error_total_2').html(error_message);

			$(".get_error_total_2").fadeIn();

			$(".text-error").fadeIn();

			/*e_error = 0;

			error_message = '';*/

			setTimeout(function(){ $('.text-error, .get_error_total_2').fadeOut(); }, delay);

		}

		else{

			//alert(newhash);

			//alert(rehash);

			//$("#myForm").submit();



			var form_data = new FormData();

			//form_data.append('exam_gen',exam_gen);

			form_data.append('mother_name',mother_name);

			form_data.append('father_name',father_name);

			form_data.append('fu_gender',fu_gender);

			form_data.append('fu_mt_status',fu_mt_status);

			form_data.append('fu_dob',fu_dob);

			form_data.append('fu_address',fu_address);

			form_data.append('fu_district',fu_district);

			form_data.append('fu_dom_state',fu_dom_state);

			form_data.append("fu_pic_doc", fu_pic_doc[0]);

			form_data.append("fu_sign_doc", fu_sign_doc[0]);

			form_data.append("fu_dob_doc", fu_dob_doc[0]);

			form_data.append("fu_address_doc", fu_address_doc[0]);

			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/second_step_save"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

						// console.log(data);

						//alert(data.msg[0].space_rate);

						$('.div_roller_total_2').fadeOut();

						$('.get_success_total_2').html('All Data Saved Successfully.');

						$(".get_success_total_2").fadeIn();

						setTimeout(function(){ $('.get_success_total_1').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

						$('.div_roller_total_2').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_2').html(error_message);

						$(".get_error_total_2").fadeIn();

						setTimeout(function(){ $('.get_error_total_2').fadeOut(); }, delay);

					}

					



				}

				

			});

		}

	

	}

	

	function two_step_process(){

		//alert('Hit Two step Process');

		$('.div_roller_total_2').fadeIn();

		var e_error = 0;

		

    	var father_name = $('#father_name').val();

    	var mother_name = $('#mother_name').val();

		var fu_gender = $("input[name='fu_gender']:checked").val();

		var fu_mt_status = $("input[name='fu_mt_status']:checked").val();

    	var fu_dob = $('#fu_dob').val();

    	var fu_address = $('#fu_address').val();

    	var fu_district = $('#fu_district option:selected').val();

    	var fu_dom_state = $('#fu_dom_state option:selected').val();

		var fu_pic_doc = $('#fu_pic_doc')[0].files;

		var fu_sign_doc = $('#fu_sign_doc')[0].files;

		var fu_dob_doc = $('#fu_dob_doc')[0].files;

		var fu_address_doc = $('#fu_address_doc')[0].files;



		if(father_name == ""){

			e_error = 1;

			$('.father_name').html('Father Name is Required.');

		}else{

			if(!father_name.match(alphaletters_spaces)){

				e_error = 1;

				$('.father_name').html('Illegal character used!');

			}else{

				$('.father_name').html('');

			}	

		}

		if(mother_name == ""){

			e_error = 1;

			$('.mother_name').html('Mother Name is Required.');

		}else{

			if(!mother_name.match(alphaletters_spaces)){

				e_error = 1;

				$('.mother_name').html('Illegal character used!');

			}else{

				$('.mother_name').html('');

			}	

		}

		if(fu_gender == "" || fu_gender == undefined){

			e_error = 1;

			$('.fu_gender').html('Gender is Required.');

		}else{

			if(!fu_gender.match(alphaletters)){

				e_error = 1;

				$('.fu_gender').html('Gender is not Alphabet, Check again.');

			}else{

				$('.fu_gender').html('');

			}

		}

		if(fu_mt_status == "" || fu_mt_status == undefined){

			e_error = 1;

			$('.fu_mt_status').html('Marital Status is Required.');

		}else{

			if(!fu_mt_status.match(alphaletters)){

				e_error = 1;

				$('.fu_mt_status').html('Marital Status is not Alphabet, Check again.');

			}else{

				$('.fu_mt_status').html('');

			}

		}

		if(fu_dob == ""){

			e_error = 1;

			$('.fu_dob').html('Date of Birth is Required.');

		}else{

			if(isDatecheck(fu_dob) == false){

				e_error = 1;

				$('.fu_dob').html('Incorrect date of birth format, check properly.');

			}else{

				$('.fu_dob').html('');

			}	

		}

		if(fu_address == ""){

			e_error = 1;

			$('.fu_address').html('Address is Required.');

		}else{

			var fu_address1 = fu_address.replace(/(\r\n|\n|\r)/gm, " ");

			if(!fu_address1.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_address').html('Illegal character used, Check again.');

			}else{

				$('.fu_address').html('');

			}	

		}

		if(fu_district == ""){

			e_error = 1;

			$('.fu_district').html('District is Required.');

		}else{

			if(!fu_district.match(onlynumerics)){

				e_error = 1;

				$('.fu_district').html('District is not numeric, Check again.');

			}else{

				$('.fu_district').html('');

			}	

		}

		if(fu_dom_state == ""){

			e_error = 1;

			$('.fu_dom_state').html('Domicile State is Required.');

		}else{

			if(!fu_dom_state.match(onlynumerics)){

				e_error = 1;

				$('.fu_dom_state').html('Domicile State is not numeric, Check again.');

			}else{

				$('.fu_dom_state').html('');

			}	

		}

		if($('.fu_uploaded_photo').text() == ''){

			if(document.getElementById("fu_pic_doc").files.length == 0){

				e_error = 1;

				$('.fu_pic_doc').html('Candidate Picture is Required.');

			}else{

				var fileInput = document.getElementById('fu_pic_doc'); 

				var filePath = fileInput.value;

				if(!allowedPic_Extensions.exec(filePath)){

					e_error = 1;

					$('.fu_pic_doc').html('Candidate Picture File type Invalid.(Use Image File)');

				}else{



          if(fileInput.files[0].size >  imageFileMaxSize){

            e_error = 1;

            $('.fu_pic_doc').html('File size must be less than or equal to 500 KB');

          }

					else $('.fu_pic_doc').html('');

				}

			}

		}

		if($('.fu_uploaded_sign').text() == ''){

			if(document.getElementById("fu_sign_doc").files.length == 0){

				e_error = 1;

				$('.fu_sign_doc').html('Signature is Required.');

			}else{

				var fileInput = document.getElementById('fu_sign_doc'); 

				var filePath = fileInput.value;

				if(!allowedExtensions.exec(filePath)){

					e_error = 1;

					$('.fu_sign_doc').html('Document File type Invalid.(Use Image File)');

				}else{



          if(fileInput.files[0].size >  docFileMaxSize){

            e_error = 1;

            $('.fu_sign_doc').html('File size must be less than or equal to 2 MB');

          }

					else $('.fu_sign_doc').html('');

				}

			}

		}

		if($('.fu_uploaded_dob').text() == ''){

			if(document.getElementById("fu_dob_doc").files.length == 0){

				e_error = 1;

				$('.fu_dob_doc').html('Document is Required.');

			}else{

				var fileInput = document.getElementById('fu_dob_doc'); 

				var filePath = fileInput.value;

				if(!allowedExtensions.exec(filePath)){

					e_error = 1;

					$('.fu_dob_doc').html('Document File type Invalid.(Use PDF/Image)');

				}else{



          if(fileInput.files[0].size >  docFileMaxSize){

            $('.fu_dob_doc').html('File size must be less than or equal to 2 MB');

          }

					else $('.fu_dob_doc').html('');

				}

			}

		}

		

		if($('.fu_uploaded_address').text() == ''){

			if(document.getElementById("fu_address_doc").files.length == 0){

				e_error = 1;

				$('.fu_address_doc').html('Document is Required.');

			}else{

				var fileInput = document.getElementById('fu_address_doc'); 

				var filePath = fileInput.value;

				if(!allowedExtensions.exec(filePath)){

					e_error = 1;

					$('.fu_address_doc').html('Document File type Invalid.(Use PDF/Image)');

				}else{



          if(fileInput.files[0].size >  docFileMaxSize){

            e_error = 1;

            $('.fu_address_doc').html('File size must be less than or equal to 2 MB');

          }

					else $('.fu_address_doc').html('');

				}

			}

		}

		

		//alert(salts);

		if(e_error == 1){

			$('.div_roller_total_2').fadeOut();

			$('.get_error_total_2').html(error_message);

			$(".get_error_total_2").fadeIn();

			$(".text-error").fadeIn();

			/*e_error = 0;

			error_message = '';*/

			setTimeout(function(){ $('.text-error, .get_error_total_2').fadeOut(); }, delay);

		}else{

			//alert(newhash);

			//alert(rehash);

			//$("#myForm").submit();

			var conf_answer = confirm("Warning! You can not edit information after process ! Are you sure you want to Submit the Data for Process Further?")

			if(conf_answer){

				var form_data = new FormData();

				form_data.append('father_name',father_name);

				form_data.append('mother_name',mother_name);

				form_data.append('fu_gender',fu_gender);

				form_data.append('fu_mt_status',fu_mt_status);

				form_data.append('fu_dob',fu_dob);

				form_data.append('fu_address',fu_address);

				form_data.append('fu_district',fu_district);

				form_data.append('fu_dom_state',fu_dom_state);

				form_data.append("fu_pic_doc", fu_pic_doc[0]);

				form_data.append("fu_sign_doc", fu_sign_doc[0]);

				form_data.append("fu_dob_doc", fu_dob_doc[0]);

				form_data.append("fu_address_doc", fu_address_doc[0]);

				$.ajax({

					method:'POST',

					url:'<?php echo base_url()."member/second_step_processing"; ?>',

					data:form_data,

					dataType:'JSON',

					contentType: false,

					processData: false,

					success:function(data){

						//alert(data.msg);

						if(data.msg == 1)

						{

							//console.log(data);

							//alert(data.msg[0].space_rate);

							$('.div_roller_total_2').fadeOut();

							$('.get_success_total_2').html('Data Updation Successfully completed.');

							$(".get_success_total_2").fadeIn();

							$('input, select').val('');

							$('input').html('');

							setTimeout(function(){ $('.get_success_total_2').fadeOut(); }, 3000);

							setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

							

							

						}else{

							$('.div_roller_total_2').fadeOut();

							error_message = "There have some problem to Store Data, Try after some time.";

							error_message = error_message + "<br/>" + data.e_msg;

							$('.get_error_total_2').html(error_message);

							$(".get_error_total_2").fadeIn();

							setTimeout(function(){ $('.get_error_total_2').fadeOut(); }, delay);

						}

						

					}

				});

			}else{

				$('.div_roller_total_2').fadeOut();

			}

		}

	}

	<?php } ?>

	

	<?php if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1) && ($fuser_detailset->fu_step_3 == 0 || $fuser_detailset->fu_step_3 == 2)){ ?>

   
	$('input[name="fu_caste_type"]').on('input',function(event){
    
    $('select[name="fu_caste_community"]').prop('disabled',false);

    let caste_type = event.target.value;

    let form_data = new FormData();

    form_data.append('caste_type',caste_type);

    $.ajax({
      url:'<?= base_url("member/get_caste_details")?>',
      method:'POST',
      data:form_data,
      dataType:'JSON',
      processData:false,
      contentType:false,
      success:function(data){
        console.log(data);
        let options = `<option value="">--SELECT--</option>`;

        for(let i=0;i<data.length;i++){

          options += `
            <option value=${data[i].csdetail_id}>${data[i].csdetail_name}</option>
          `;  
        }
        
        $('select[name="fu_caste_community"]').html(options);
      }
    });
    
  });

	function three_step_save(){

		// alert('Hit Three step Save');



		$('.div_roller_total_3').fadeIn();	

		var e_error=0;



		var fu_caste = $('input[name="yesno_caste"]:checked').val();

		var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();

    var fu_caste_community = $('select[name="fu_caste_community"]').val();

		var fu_caste_number = $('input[name="fu_caste_number"]').val();

		var fu_caste_issue_whom = $('select[name="fu_caste_issue_whom"]').val();

		var fu_caste_issue_date = $('input[name="fu_caste_issue_date"]').val();

		var fu_caste_doc = $('input[name="fu_caste_doc"]')[0].files;



		var fu_pwd = $('input[name="yesno_pwd"]:checked').val();

		var fu_pwd_percent = $('input[name="fu_pwd_percent"]').val();

		var fu_pwd_issue_whom = $('input[name="fu_pwd_issue_whom"]').val();

		var fu_pwd_issue_date = $('input[name="fu_pwd_issue_date"]').val();

		var fu_pwd_doc = $('input[name="fu_pwd_doc"]')[0].files;



		var fu_exempted = $('input[name="yesno_exempted"]:checked').val();

		var fu_exc_reason = $('select[name="fu_exc_reason"]').val();

		var fu_exc_doc = $('input[name="fu_exc_doc"]')[0].files;



		var fu_exservice = $('input[name="yesno_exservice"]:checked').val();

		var fu_exs_reason = $('select[name="fu_exs_reason"]').val();

		var fu_exs_doc = $('input[name="fu_exs_doc"]')[0].files;





		var fu_age_relax = $('input[name="yesno_age_relax"]:checked').val();

		var fu_age_relax_reason = $('textarea[name="fu_age_relax_reason"]').val();

		var fu_age_relax_doc = $('input[name="fu_age_relax_doc"]')[0].files;



		if(fu_caste != 'Yes' && fu_caste != 'No' && fu_caste != undefined){

			e_error = 1;

			$('.fu_caste').html('Required');

		}else{

			$('.fu_caste').html('');

		}



    /*

    if(fu_caste == 'No'){



      fu_caste_type = '';

      fu_caste_number = '';

      fu_caste_issue_whom = '';

      fu_caste_issue_date = '';

    }

    */



		if(fu_caste_type != undefined && !fu_caste_type.match(onlynumerics) ){

			e_error = 1;

			$('.fu_caste_type').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_caste_type').html('');

		}



		if(!fu_caste_number.match(alphanumerics_no) && fu_caste_number != ""){

			e_error = 1;

			$('.fu_caste_number').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_caste_number').html('');

		}

		

		if(!fu_caste_issue_whom.match(alphanumerics_no) && fu_caste_issue_whom != ""){

			e_error = 1;

			$('.fu_caste_issue_whom').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_caste_issue_whom').html('');

		}

		

		if(isDatecheck(fu_caste_issue_date) == false && fu_caste_issue_date != ""){

			e_error = 1;

			$('.fu_caste_issue_date').html('Incorrect Date of Issue Format, check properly.');

		}else{

			$('.fu_caste_issue_date').html('');

		}



		var fileInput;

		var filePath;



		fileInput = document.querySelector('input[name="fu_caste_doc"]'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_caste_doc').html('')

    }

    else if(!allowedExtensions.exec(filePath)){

			e_error = 1;

			$('.fu_caste_doc').html('Caste Document File type Invalid.(Use Image File or PDF)');

		}else{

      

      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_caste_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_caste_doc').html('');

		}



		if(fu_pwd != 'Yes' && fu_pwd != 'No' && fu_pwd != undefined){

			e_error = 1;

			$('.fu_pwd').html('Required');

		}else{

			$('.fu_pwd').html('');

		}



		if(!fu_pwd_percent.match(alphanumerics_no) && fu_pwd_percent != ""){

			e_error = 1;

			$('.fu_pwd_percent').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_pwd_percent').html('');

		}



		if(!fu_pwd_issue_whom.match(alphanumerics_no) && fu_pwd_issue_whom != ""){

			e_error = 1;

			$('.fu_pwd_issue_whom').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_pwd_issue_whom').html('');

		}



		if(isDatecheck(fu_pwd_issue_date) == false && fu_pwd_issue_date != ""){

			e_error = 1;

			$('.fu_pwd_issue_date').html('Incorrect Date of issue Format, check properly.');

		}else{

			$('.fu_pwd_issue_date').html('');

		}



		fileInput = document.querySelector('input[name="fu_pwd_doc"]'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_pwd_doc').html('')

    }

    else if(!allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_pwd_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}else{

      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_pwd_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_pwd_doc').html('');

		}



		

		if(fu_exempted != 'Yes' && fu_exempted != 'No' && fu_exempted != undefined){

			e_error = 1;

			$('.fu_exempted').html('Required');

		}else{

			$('.fu_exempted').html('');

		}



		if(!fu_exc_reason.match(alphanumerics_no) && fu_exc_reason != ""){

			e_error = 1;

			$('.fu_exc_reason').html('Illegal character(s) used, Check again.');

		}else{



			$('.fu_exc_reason').html('');

		}



		fileInput = document.querySelector('input[name="fu_exc_doc"]'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_exc_doc').html('')

    }

    else if(!allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_exc_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}else{



       if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_exc_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_exc_doc').html('');

		}



		if(fu_exservice != 'Yes' && fu_exservice != 'No' && fu_exservice != undefined){

			e_error = 1;

			$('.fu_exservice').html('Required');

		}else{

			$('.fu_exservice').html('');

		}



		if(!fu_exs_reason.match(alphanumerics_no) && fu_exs_reason != ""){

			e_error = 1;

			$('.fu_exs_reason').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_exs_reason').html('');

		}



		fileInput = document.querySelector('input[name="fu_exs_doc"]'); 

		filePath = fileInput.value;



    if(fileInput.value == ""){

      $('.fu_exs_doc').html('')

    }

		else if(!allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_exs_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}else{

       

      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_exs_doc').html('File size must be less than or equal to 2 MB');

      }

			else $('.fu_exs_doc').html('');

		}



		if(fu_age_relax != 'Yes' && fu_age_relax != 'No' && fu_age_relax != undefined){

			e_error = 1;

			$('.fu_age_relax').html('Required');

		}else{

			$('.fu_age_relax').html('');

		}



		if(!fu_age_relax_reason.match(alphanumerics_no) && fu_age_relax_reason != ""){

			e_error = 1;

			$('.fu_age_relax_reason').html('Illegal character(s) used, Check again.');

		}else{

			$('.fu_age_relax_reason').html('');

		}



		fileInput = document.querySelector('input[name="fu_age_relax_doc"]'); 

		filePath = fileInput.value;

		

    if(fileInput.value == ""){

      $('.fu_age_relax_doc').html('')

    }

    else if(!allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_age_relax_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}else{



      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_age_relax_doc').html('File size must be less than or equal to 2 MB');

      }

			else $('.fu_age_relax_doc').html('');

		}



		if(e_error == 1){

			$('.div_roller_total_3').fadeOut();

			$('.get_error_total_3').html(error_message);

			$(".get_error_total_3").fadeIn();

			$(".text-error").fadeIn();

			

			setTimeout(function(){ $('.text-error, .get_error_total_3').fadeOut(); }, delay);

		}

		else{



			var form_data = new FormData();

			

			form_data.append('fu_caste',fu_caste);

			form_data.append('fu_caste_type',fu_caste_type);

      form_data.append('fu_caste_community',fu_caste_community);      

			form_data.append('fu_caste_number',fu_caste_number);

			form_data.append('fu_caste_issue_whom',fu_caste_issue_whom);

			form_data.append('fu_caste_issue_date',fu_caste_issue_date);

			form_data.append('fu_pwd',fu_pwd);

			form_data.append('fu_pwd_percent',fu_pwd_percent);

			form_data.append('fu_pwd_issue_whom',fu_pwd_issue_whom);

			form_data.append('fu_pwd_issue_date',fu_pwd_issue_date);

			form_data.append("fu_exempted", fu_exempted);

			form_data.append("fu_exc_reason", fu_exc_reason);

			form_data.append("fu_exservice", fu_exservice);

			form_data.append("fu_exs_reason", fu_exs_reason);

			form_data.append("fu_age_relax", fu_age_relax);

			form_data.append("fu_age_relax_reason", fu_age_relax_reason);





			form_data.append("fu_caste_doc", fu_caste_doc[0]);

			form_data.append("fu_pwd_doc", fu_pwd_doc[0]);

			form_data.append("fu_exc_doc", fu_exc_doc[0]);

			form_data.append("fu_exs_doc", fu_exs_doc[0]);

			form_data.append("fu_age_relax_doc", fu_age_relax_doc[0]);

			

			

			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/third_step_save"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					// console.log(data)

					

					if(data.msg == 1)

					{

						$('.div_roller_total_3').fadeOut();

						$('.get_success_total_3').html('All Data Saved Successfully.');

						$(".get_success_total_3").fadeIn();

						setTimeout(function(){ $('.get_success_total_3').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{	

						$('.div_roller_total_3').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_3').html(error_message);

						$(".get_error_total_3").fadeIn();

						setTimeout(function(){ $('.get_error_total_3').fadeOut(); }, delay);

					}

					



				}

				

			});

			

		}



	}

	

	function three_step_process(){

		// alert('Hit Three step Process');

		$('.div_roller_total_3').fadeIn();	

		var e_error=0;



		var fu_caste = $('input[name="yesno_caste"]:checked').val();

		var fu_caste_type = $('input[name="fu_caste_type"]:checked').val();

    var fu_caste_community = $('select[name="fu_caste_community"]').val();

		var fu_caste_number = $('input[name="fu_caste_number"]').val();

		var fu_caste_issue_whom = $('select[name="fu_caste_issue_whom"]').val();

		var fu_caste_issue_date = $('input[name="fu_caste_issue_date"]').val();

		var fu_caste_doc = $('input[name="fu_caste_doc"]')[0].files;



		var fu_pwd = $('input[name="yesno_pwd"]:checked').val();

		var fu_pwd_percent = $('input[name="fu_pwd_percent"]').val();

		var fu_pwd_issue_whom = $('input[name="fu_pwd_issue_whom"]').val();

		var fu_pwd_issue_date = $('input[name="fu_pwd_issue_date"]').val();

		var fu_pwd_doc = $('input[name="fu_pwd_doc"]')[0].files;



		var fu_exempted = $('input[name="yesno_exempted"]:checked').val();

		var fu_exc_reason = $('select[name="fu_exc_reason"]').val();

		var fu_exc_doc = $('input[name="fu_exc_doc"]')[0].files;



		var fu_exservice = $('input[name="yesno_exservice"]:checked').val();

		var fu_exs_reason = $('select[name="fu_exs_reason"]').val();

		var fu_exs_doc = $('input[name="fu_exs_doc"]')[0].files;





		var fu_age_relax = $('input[name="yesno_age_relax"]:checked').val();

		var fu_age_relax_reason = $('textarea[name="fu_age_relax_reason"]').val();

		var fu_age_relax_doc = $('input[name="fu_age_relax_doc"]')[0].files;





		if(fu_caste != 'Yes' && fu_caste != 'No'){

			e_error = 1;

			$('.fu_caste').html('Required');

		}else{

			$('.fu_caste').html('');

		}


    
		if(fu_caste == "Yes"){

      
			if(fu_caste_type == undefined){
        
				e_error = 1;

				$('.fu_caste_type').html('Caste Type is Required');

			}

			else if(!fu_caste_type.match(onlynumerics) ){

				e_error = 1;

				$('.fu_caste_type').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_caste_type').html('');

			}


		}

		else{

			$('.fu_caste_type').html('');

		}

    if(fu_caste == "Yes"){

      if(fu_caste_community == ""){



        e_error = 1;

        $('.fu_caste_community').html('Caste Community is Required');

      }

      else if(!fu_caste_community.match(alphanumerics_no)){

        e_error = 1;

        $('.fu_caste_community').html('Illegal character(s) used, Check again.');

      }else{

        $('.fu_caste_community').html('');

      }

    }

		if(fu_caste == "Yes"){

			if(fu_caste_number == ""){



				e_error = 1;

				$('.fu_caste_number').html('Caste Certificate No. is Required');

			}

			else if(!fu_caste_number.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_caste_number').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_caste_number').html('');

			}

		}



		if(fu_caste == "Yes"){

			if(fu_caste_issue_whom == ""){



				e_error = 1;

				$('.fu_caste_issue_whom').html('Issued By Whom is Required');

			}

			else if(!fu_caste_issue_whom.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_caste_issue_whom').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_caste_issue_whom').html('');

			}

		}





		if(fu_caste == "Yes"){

			if(fu_caste_issue_date == ""){

				e_error = 1;

				$('.fu_caste_issue_date').html('Issued By Date is Required');	

			}

			else if(isDatecheck(fu_caste_issue_date) == false){

				e_error = 1;

				$('.fu_caste_issue_date').html('Date of Issue Format check properly.');

			}else{

				$('.fu_caste_issue_date').html('');

			}

		}



		var fileInput;

		var filePath;



		fileInput = document.querySelector('input[name="fu_caste_doc"]'); 

		filePath = fileInput.value;



		if(fu_caste == "Yes"){

			

			if(document.querySelector('input[name="fu_caste_doc"]').files.length == 0){

				

				if($('.fu_uploaded_caste').text() == ''){

					e_error = 1;

					$('.fu_caste_doc').html('Document is Required.');

				}

			}

			else if(!allowedExtensions.exec(filePath)){

				e_error = 1;

				$('.fu_caste_doc').html('Caste Document File type Invalid.(Use Image File or PDF)');

			}

		

			else{





				$('.fu_caste_doc').html('');

			}

		}



		if(fu_pwd != 'Yes' && fu_pwd != 'No'){

			e_error = 1;

			$('.fu_pwd').html('Required');

		}else{

			$('.fu_pwd').html('');

		}



		if(fu_pwd == "Yes"){

			if(fu_pwd_percent == ""){

				e_error = 1;

				$('.fu_pwd_percent').html('Percentage of Disability is Required');

			}

			else if(!fu_pwd_percent.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_pwd_percent').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_pwd_percent').html('');

			}

		}



		if(fu_pwd == "Yes"){

			if(fu_pwd_issue_whom == ""){

				e_error = 1;

				$('.fu_pwd_issue_whom').html('Required');

			}

			else if(!fu_pwd_issue_whom.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_pwd_issue_whom').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_pwd_issue_whom').html('');

			}

		}



		if(fu_pwd == "Yes"){

			if(fu_pwd_issue_date == ""){

				$('.fu_pwd_issue_date').html('Date of issue is required');

			}

			else if(isDatecheck(fu_pwd_issue_date) == false){

				e_error = 1;

				$('.fu_pwd_issue_date').html('Date of issue Format check properly.');

			}else{

				$('.fu_pwd_issue_date').html('');

			}

		}



		fileInput = document.querySelector('input[name="fu_pwd_doc"]'); 

		filePath = fileInput.value;

		

		if(fu_pwd == "Yes"){



			if(document.querySelector('input[name="fu_pwd_doc"]').files.length == 0){

				

				if($('.fu_uploaded_pwd').text() == ''){

					e_error = 1;

					$('.fu_pwd_doc').html('Document is Required.');

				}	

			}

			else if(!allowedExtensions.exec(filePath)){

				e_error = 1;

				$('.fu_pwd_doc').html('Document File type Invalid.(Use Image File or PDF)');

			}

			

			else{

				$('.fu_pwd_doc').html('');

			}

		}



		

		if(fu_exempted != 'Yes' && fu_exempted != 'No'){

			e_error = 1;

			$('.fu_exempted').html('Required');

		}else{

			$('.fu_exempted').html('');

		}



		if(fu_exempted == "Yes"){

			if(fu_exc_reason == ""){

				e_error = 1;

				$('.fu_exc_reason').html('Reason is Required');

			}

			else if(!fu_exc_reason.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_exc_reason').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_exc_reason').html('');

			}

		}



		fileInput = document.querySelector('input[name="fu_exc_doc"]'); 

		filePath = fileInput.value;



		if(fu_exempted == "Yes"){

			if(document.querySelector('input[name="fu_exc_doc"]').files.length == 0){

				

				if($('.fu_uploaded_exc').text() == ''){

					e_error = 1;

					$('.fu_exc_doc').html('Document is Required.');

				}	

			}

			else if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

				e_error = 1;

				$('.fu_exc_doc').html('Document File type Invalid.(Use Image File or PDF)');

			}else{

				$('.fu_exc_doc').html('');

			}

		}



		if(fu_exservice != 'Yes' && fu_exservice != 'No'){

			e_error = 1;

			$('.fu_exservice').html('Required');

		}else{

			$('.fu_exservice').html('');

		}





		if(fu_exservice == "Yes"){

			if(fu_exs_reason == ""){

				e_error = 1;

				$('.fu_exs_reason').html('Reason is Required');

			}

			else if(!fu_exs_reason.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_exs_reason').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_exs_reason').html('');

			}

		}



		fileInput = document.querySelector('input[name="fu_exs_doc"]'); 

		filePath = fileInput.value;



		if(fu_exservice == "Yes"){

			if(document.querySelector('input[name="fu_exs_doc"]').files.length == 0){

				

				if($('.fu_uploaded_exservice').text() == ''){

					e_error = 1;

					$('.fu_exs_doc').html('Document is Required.');

				}	

			}

			else if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

				e_error = 1;

				$('.fu_exs_doc').html('Document File type Invalid.(Use Image File or PDF)');

			}else{

				$('.fu_exs_doc').html('');

			}

		}





		if(fu_age_relax != 'Yes' && fu_age_relax != 'No'){

			e_error = 1;

			$('.fu_age_relax').html('Required');

		}else{

			$('.fu_age_relax').html('');

		}



		if(fu_age_relax == "Yes"){

			if(fu_age_relax_reason == ""){

				e_error = 1;

				$('.fu_age_relax_reason').html('Reason is Required');

			}

			else if(!fu_age_relax_reason.match(alphanumerics_no)){

				e_error = 1;

				$('.fu_age_relax_reason').html('Illegal character(s) used, Check again.');

			}else{

				$('.fu_age_relax_reason').html('');

			}

		}



		fileInput = document.querySelector('input[name="fu_age_relax_doc"]'); 

		filePath = fileInput.value;



		if(fu_age_relax == "Yes"){



			if(document.querySelector('input[name="fu_age_relax_doc"]').files.length == 0){

				

				if($('.fu_uploaded_age_relax').text() == ''){

					e_error = 1;

					$('.fu_age_relax_doc').html('Document is Required.');

				}	

			}

			else if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

				e_error = 1;

				$('.fu_age_relax_doc').html('Document File type Invalid.(Use Image File or PDF)');

			}else{

				$('.fu_age_relax_doc').html('');

			}

		}



		if(e_error == 1){

			$('.div_roller_total_3').fadeOut();

			$('.get_error_total_3').html(error_message);

			$(".get_error_total_3").fadeIn();

			$(".text-error").fadeIn();

			

			setTimeout(function(){ $('.text-error, .get_error_total_3').fadeOut(); }, delay);

		}

		else{



      let c = confirm('Warning! You can not edit information after process ! Are you sure you want to Submit the Data for Process Further?');

      if(!c){ 

        $('.div_roller_total_3').fadeOut();

        return;

      }



			var form_data = new FormData();

			

			form_data.append('fu_caste',fu_caste);

			form_data.append('fu_caste_type',fu_caste_type);

      form_data.append('fu_caste_community',fu_caste_community);      

			form_data.append('fu_caste_number',fu_caste_number);

			form_data.append('fu_caste_issue_whom',fu_caste_issue_whom);

			form_data.append('fu_caste_issue_date',fu_caste_issue_date);

			form_data.append('fu_pwd',fu_pwd);

			form_data.append('fu_pwd_percent',fu_pwd_percent);

			form_data.append('fu_pwd_issue_whom',fu_pwd_issue_whom);

			form_data.append('fu_pwd_issue_date',fu_pwd_issue_date);

			form_data.append("fu_exempted", fu_exempted);

			form_data.append("fu_exc_reason", fu_exc_reason);

			form_data.append("fu_exservice", fu_exservice);

			form_data.append("fu_exs_reason", fu_exs_reason);

			form_data.append("fu_age_relax", fu_age_relax);

			form_data.append("fu_age_relax_reason", fu_age_relax_reason);





			form_data.append("fu_caste_doc", fu_caste_doc[0]);

			form_data.append("fu_pwd_doc", fu_pwd_doc[0]);

			form_data.append("fu_exc_doc", fu_exc_doc[0]);

			form_data.append("fu_exs_doc", fu_exs_doc[0]);

			form_data.append("fu_age_relax_doc", fu_age_relax_doc[0]);

			

			

			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/third_step_processing"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

					

						$('.div_roller_total_3').fadeOut();

						$('.get_success_total_3').html('Data Updation Successfully completed.');

						$(".get_success_total_3").fadeIn();

						setTimeout(function(){ $('.get_success_total_3').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

							

						$('.div_roller_total_3').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_3').html(error_message);

						$(".get_error_total_3").fadeIn();

						setTimeout(function(){ $('.get_error_total_3').fadeOut(); }, delay);

					}

					



				}

				

			});

			

		}

	}

	<?php } ?>

	

	<?php if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1 && $fuser_detailset->fu_step_3 == 1) && ($fuser_detailset->fu_step_4 == 0 || $fuser_detailset->fu_step_4 == 2)){ ?>

	

  var examsID = [];

  var examsName = [];

  var usersQuali = [];

  var exam = [];

  var states = [];

  var quali = <?php echo count($fuser_quali) ?>;

  <?php foreach($fuser_quali as $quali){?>

    usersQuali.push('<?= $quali->qm_id?>');

  <?php }?>

  

  <?php foreach($quali_exam as $exam){?>

    examsID.push('<?= $exam->qm_id ?>');

    examsName.push('<?= $exam->qm_name?>');

    exam['<?= $exam->qm_id ?>'] = '<?= $exam->qm_name?>'

  <?php }?>

  <?php foreach($state_list_quali as $states){ ?>

      states["<?php echo $states->state_id; ?>"] = '<?php echo $states->state_name; ?>'

  <?php }?>
  function is_qualification_already_added(quali){



    if(quali == '' || quali == undefined) return true;



    let examQuali;



    // Parse quali to Int

    try {

      examQuali = parseInt(quali);

    

    } catch(e) {

      

      return true;

    }



    // If quali is already in the list usersQuali

    for(let i=0;i<usersQuali.length;i++){



      try {

        if(parseInt(usersQuali[i]) == examQuali) return true;

      } catch(e) {

        

        return true;

      }

      

    }



    return false;

  } 



  function are_all_qualifications_added(){



    // console.log(usersQuali);

    // console.log(examsID);



    for(let i=0;i<examsID.length;i++){

      

      if(!usersQuali.includes(examsID[i])) return false;

    }

    return true;

  }

  $('input[name="marks_obtained"]').on('input',function(event){

    let full_marks = $('input[name="marks_full"').val();
    let obtained_marks = $('input[name="marks_obtained"]').val();
    
    
    if((full_marks != "" && obtained_marks != "")){
      
      if(obtained_marks != NaN && full_marks != NaN){
        
        if(parseInt(full_marks) < parseInt(obtained_marks)){
          // show error
          $('.text-error').fadeIn();
          $('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
          $('input[name="marks_percent"').val('');
          return;
        }
        else{
          $('.marks_obtained').html('');
        }

        $('input[name="marks_percent"').val((parseInt(obtained_marks)/parseInt(full_marks))*100);
      }
    }
    else{
      $('input[name="marks_percent"').val('');
    }
  })

  $('input[name="marks_full"]').on('input',function(event){

    let full_marks = $('input[name="marks_full"').val();
    let obtained_marks = $('input[name="marks_obtained"]').val();
    
    
    if((full_marks != "" && obtained_marks != "")){
      
      if(obtained_marks != NaN && full_marks != NaN){
        
        if(parseInt(full_marks) < parseInt(obtained_marks)){
          // show error
          $('.text-error').fadeIn();
          $('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
          $('input[name="marks_percent"').val('');
          return;
        }
        else{
          $('.marks_obtained').html('');
        }

      
        $('input[name="marks_percent"').val((parseInt(obtained_marks)/parseInt(full_marks))*100);
      }
    }
    else{
      $('input[name="marks_percent"').val('');
    }
  })


  if( govExpYear < 1 && govExpMonth < 1){

    $('.fu_gov_exp_doc_div').css({

      display:'none'

    })

  }

    

  if(nongovExpYear < 1 && nongovExpMonth < 1){

    $('.fu_nongov_exp_doc_div').css({

      display:'none'

    })

  }

  



  function four_step_save(){

		// alert('Hit Four step Save');

		$('.div_roller_total_4').fadeIn();	

		var e_error=0;



		var fu_has_service = $('input[name="service_yesno"]:checked').val()

		var fu_current_gov_service = $('input[name="fu_current_gov_service"]:checked').val()

		var fu_service_designation = $('input[name="fu_service_designation"]').val()

		var fu_service_exp_year = $('input[name="fu_service_exp_year"]').val()

		var fu_service_exp_month = $('input[name="fu_service_exp_month"]').val()



		var fu_total_gov_exp_year = $('input[name="fu_total_gov_exp_year"]').val()

		var fu_total_gov_exp_month = $('input[name="fu_total_gov_exp_month"]').val()

		var fu_gov_exp_doc = $('input[name="fu_gov_exp_doc"]')[0].files



		var fu_total_nongov_exp_year = $('input[name="fu_total_nongov_exp_year"]').val()

		var fu_total_nongov_exp_month = $('input[name="fu_total_nongov_exp_month"]').val()

		var fu_nongov_exp_doc = $('input[name="fu_nongov_exp_doc"]')[0].files



		

		

		if(!fu_service_designation.match(alphaletters_spaces) && fu_service_designation != ''){

			$('.fu_service_designation').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_service_designation').html('')	

		}



		if(!fu_service_exp_year.match(onlynumerics) && fu_service_exp_year != ''){

			$('.fu_service_exp_year').html('Requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_service_exp_year').html('')	

		}



		if(!fu_service_exp_month.match(onlynumerics) && fu_service_exp_month != ''){

			$('.fu_service_exp_month').html('Requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_service_exp_month').html('')	

		}



		if(!fu_total_gov_exp_year.match(onlynumerics) && fu_total_gov_exp_year != ''){

			$('.fu_total_gov_exp_year').html('Requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_total_gov_exp_year').html('')	

		}



		if(!fu_total_gov_exp_month.match(onlynumerics) && fu_total_gov_exp_month != ''){

			$('.fu_total_gov_exp_month').html('Requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_total_gov_exp_month').html('')	

		}



		var fileInput;

		var filePath;



		fileInput = document.querySelector('input[name="fu_gov_exp_doc"]')

		filePath = fileInput.value



    if(fileInput.value == ""){

      $('.fu_gov_exp_doc').html('')      

    }

		else if( !allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_gov_exp_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}

		else{



      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_gov_exp_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_gov_exp_doc').html('')

		}



		if(!fu_total_nongov_exp_year.match(onlynumerics) && fu_total_nongov_exp_year != ''){

			$('.fu_total_nongov_exp_year').html('requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_total_nongov_exp_year').html('')	

		}



		if(!fu_total_nongov_exp_month.match(onlynumerics) && fu_total_nongov_exp_month != ''){

			$('.fu_total_nongov_exp_month').html('Requires numeric value')	

			e_error = 1

		}

		else{

			$('.fu_total_nongov_exp_month').html('')	

		}

		

		fileInput = document.querySelector('input[name="fu_nongov_exp_doc"]')

		filePath = fileInput.value

		

    if(fileInput.value == ""){

      $('.fu_nongov_exp_doc').html('')      

    }  

		else if(!allowedExtensions.exec(filePath)  ){

			e_error = 1;

			$('.fu_nongov_exp_doc').html('Document File type Invalid.(Use Image File or PDF)');

		}

		else{

      if(fileInput.files[0].size >  docFileMaxSize){

        e_error = 1;

        $('.fu_nongov_exp_doc').html('File size must be less than or equal to 2 MB');

      }



			else $('.fu_nongov_exp_doc').html('')

		}



		if(e_error == 1){

			$('.div_roller_total_4').fadeOut();

			$('.get_error_total_4').html(error_message);

			$(".get_error_total_4").fadeIn();

			$(".text-error").fadeIn();

			

			setTimeout(function(){ $('.text-error, .get_error_total_4').fadeOut();$('.text-error').html('') }, delay);

		}



		else{



			var form_data = new FormData();

			

			form_data.append('fu_has_service',fu_has_service);

			form_data.append('fu_service_designation',fu_service_designation);

			form_data.append('fu_service_exp_year',fu_service_exp_year);

			form_data.append('fu_service_exp_month',fu_service_exp_month);

			form_data.append('fu_current_gov_service',fu_current_gov_service);

			form_data.append('fu_total_gov_exp_year',fu_total_gov_exp_year);

			form_data.append('fu_total_gov_exp_month',fu_total_gov_exp_month);

			form_data.append('fu_total_nongov_exp_year',fu_total_nongov_exp_year);

			form_data.append('fu_total_nongov_exp_month',fu_total_nongov_exp_month);

			

			form_data.append("fu_gov_exp_doc", fu_gov_exp_doc[0]);

			form_data.append("fu_nongov_exp_doc", fu_nongov_exp_doc[0]);



			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/final_step_save"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

					

						$('.div_roller_total_4').fadeOut();

						$('.get_success_total_4').html('All Data Saved Successfully.');

						$(".get_success_total_4").fadeIn();

						setTimeout(function(){ $('.get_success_total_4').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

							

						$('.div_roller_total_4').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_4').html(error_message);

						$(".get_error_total_4").fadeIn();

						setTimeout(function(){ $('.get_error_total_4').fadeOut(); }, delay);

					}

					



				}

				

			});

			

		}

	}



	$('.btn-add-row').on('click',function(event){

		

		$('.div_roller_qualification_4').fadeIn();	

		var e_error=0;

    error_message = '';



		// let c = confirm('Are you sure, do you want to add a row ?')

		

		// if(!c) return;

		

		var exam_name_input = $('.exam-name-input').val();

		var univ_input = $('.univ-input').val();

    var state_input = $('.state-input').val();

		var marks_obtained_input = $('.marks-obtained-input').val();

		var marks_full_input = $('.marks-full-input').val();

		var marks_percent_input = $('.marks-percent-input').val();

		var marksheet_issue_date_input = $('.marksheet-issue-date').val();	

		var marksheet = $('.marksheet')[0].files;

		



		if(exam_name_input == ''){

			$('.exam_name').html('Qualification is Required')		

			e_error = 1

		}

		else{



      if(is_qualification_already_added(exam_name_input)){

        e_error = 1;

        // error_message = 'This qualification is already added!'

        $('.exam_name').html('Already Added!')   

      }

			

      else $('.exam_name').html('')		

		}



		if(univ_input == ''){

			$('.univ').html('University is Required')		

			e_error = 1

		}

		else{

			$('.univ').html('')		

		}



    if(state_input == ''){

      $('.state').html('State is Required')   

      e_error = 1

    }

    else{

      $('.state').html('')   

    }

		

		if(marks_obtained_input == ''){

			$('.marks_obtained').html('Marks Obtained is Required')		

			e_error = 1

		}

		else{

      

      if(!marks_obtained_input.match(onlynumerics)){

        e_error = 1

        $('.marks_obtained').html('Non numeric value is not allowed')   

      }



			else $('.marks_obtained').html('')		

		}

		

		if(marks_full_input == ''){

			$('.marks_full').html('Full Marks is Required')		

			e_error = 1

		}

		else{



      if(!marks_full_input.match(onlynumerics)){

        e_error = 1

        $('.marks_full').html('Non numeric value is not allowed')   

      }

			else $('.marks_full').html('')		

		}

		

		if(marks_percent_input == ''){

			$('.marks_percent').html('Percentage is Required')		

			e_error = 1

		}	

		else{



      if(!marks_percent_input.match(onlynumerics)){

        e_error = 1

        $('.marks_percent').html('Non numeric value is not allowed')   

      }

			else $('.marks_percent').html('')		

		}



		if(marksheet_issue_date_input == ''){

			$('.marksheet_issue_date').html('Issue date is Required')		

			e_error = 1

		}

		else{

			$('.marksheet_issue_date').html('')		

		}





    fileInput = document.querySelector('input[name="marksheet"]')

    filePath = fileInput.value

    

    if($('.marksheet').val() == ''){



      $('.marksheet').html('Marksheet is Required')   

      e_error = 1

    }

    else{

      if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

        e_error = 1;

        $('.marksheet').html('Document File type Invalid.(Use Image File or PDF)');

      }

      else{

        if(fileInput.files[0].size >  docFileMaxSize){

          e_error = 1;

          $('.marksheet').html('File size must be less than or equal to 2 MB');

        }



        else $('.marksheet').html('')

      }

    }



    


    $('.btn-add-row').prop('disabled',true);

		if(e_error == 1){

      error_message = "There have some problem to Store Data, Try after some time.";

			$('.div_roller_qualification_4').fadeOut();

			$('.get_error_qualification_4').html(error_message);

			$(".get_error_qualification_4").fadeIn();

			$(".text-error").fadeIn();

			

			setTimeout(function(){ $('.text-error, .get_error_qualification_4').fadeOut();$('.text-error').html('');$('.btn-add-row').prop('disabled',false); }, delay);

		}

		else{



			var form_data = new FormData();

			

			form_data.append('exam_name',exam_name_input);

			form_data.append('university',univ_input);

      form_data.append('state',state_input);

			form_data.append('marks_obtained',marks_obtained_input);

			form_data.append('marks_full',marks_full_input);

			form_data.append('marks_percent',marks_percent_input);

			form_data.append('marksheet_issue_date',marksheet_issue_date_input);



			form_data.append("marksheet", marksheet[0]);

			

			

			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/add_qualification"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

						

						$('.div_roller_qualification_4').fadeOut();

						$('.get_success_qualification_4').html('Data Saved Successfully.');

						$(".get_success_qualification_4").fadeIn();

						// setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

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

              ${marksheet_issue_date_input}

            </div>

            </div>  

            <div class="col">

            <div class="row  pl-2 pr-2">

              <a href="${data.marksheet}?>" target="_blank">Marksheet</a>

            </div>

            </div>
            <div class="col">

              <div class="row  pl-2">

                <span class="btn btn-danger btn-delete-row" data-id='${data.quali_id}'><i class="fa fa-trash"></i></span>

              </div>
            </div>
            </div>
            `

            
            setTimeout(function(){ 
              $('.get_success_qualification_4').fadeOut();
              $('.btn-add-row').prop('disabled',false); 
              usersQuali.push(exam_name_input)

              $('.qualification').append(html)

              $('.univ-input').val('');
              $('.state-input').val('');
              $('.marks-obtained-input').val('');
              $('.marks-full-input').val('');
              $('.marks-percent-input').val('');
              $('.marksheet-issue-date').val(''); 
              $('.marksheet').val('');
              quali++;
              
            }, 2000);						

					}else{

							

						$('.div_roller_qualification_4').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_qualification_4').html(error_message);

						$(".get_error_qualification_4").fadeIn();

						setTimeout(function(){ $('.get_error_total_4').fadeOut();$('.btn-add-row').prop('disabled',false);  }, delay);

					}

					



				}

				

			});

			

		}



	});



	$(document).on('click','.btn-delete-row',function(event){



		// console.dir(event.target.parentElement.parentElement);

		// event.target.parentElement.parentElement.parentElement.remove();

		

		$('.div_roller_qualification_4').fadeIn();	

		var e_error=0;



		let c = confirm('Are you sure, do you want to delete ?');

		if(!c) return;

		

		let data_id = event.currentTarget.attributes['data-id'].value;



		var form_data = new FormData();

			

		form_data.append('quali_id',data_id);



		$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/remove_qualification"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

						

						$('.div_roller_qualification_4').fadeOut();

						$('.get_success_qualification_4').html('Data removed Successfully.');

						$(".get_success_qualification_4").fadeIn();

						setTimeout(function(){ $('.get_success_qualification_4').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

							

						$('.div_roller_qualification_4').fadeOut();

						error_message = "There have some problem to Delete Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_qualification_4').html(error_message);

						$(".get_error_qualification_4").fadeIn();

						setTimeout(function(){ $('.get_error_qualification_4').fadeOut(); }, delay);

					}

					



				}

				

			});

	})



  $('input[name="fu_total_gov_exp_year"],input[name="fu_total_gov_exp_month"]').on('input',function(event){

    

    let expYear = 0;

    try{

      expYear = parseInt($('input[name="fu_total_gov_exp_year"]').val());

      expMonth = parseInt($('input[name="fu_total_gov_exp_month"]').val());



    }catch(e){

      return;

    }



    if(expYear > 0 || expMonth > 0){



      $('.fu_gov_exp_doc_div').css({

        display:'block'

      });

    }

    else{

      $('.fu_gov_exp_doc_div').css({

        display:'none'

      });  

    }

    

  })



  $('input[name="fu_total_nongov_exp_year"],input[name="fu_total_nongov_exp_month"]').on('input',function(event){

    let expYear = 0;

    let expMonth = 0;

    try{

      expYear = parseInt($('input[name="fu_total_nongov_exp_year"]').val());

      expMonth = parseInt($('input[name="fu_total_nongov_exp_month"]').val());



    }catch(e){

      return;

    }



    if(expYear > 0 || expMonth > 0){



      $('.fu_nongov_exp_doc_div').css({

        display:'block'

      });

    }

    else{

      $('.fu_nongov_exp_doc_div').css({

        display:'none'

      });  

    }

    

  })

	

	function finisher_step(){

		// alert('Final reached');



		$('.div_roller_total_4').fadeIn();	

		var e_error=0;



		var fu_has_service = $('input[name="service_yesno"]:checked').val()

		var fu_current_gov_service = $('input[name="fu_current_gov_service"]:checked').val()

		var fu_service_designation = $('input[name="fu_service_designation"]').val()

		var fu_service_exp_year = $('input[name="fu_service_exp_year"]').val()

		var fu_service_exp_month = $('input[name="fu_service_exp_month"]').val()



		var fu_total_gov_exp_year = $('input[name="fu_total_gov_exp_year"]').val()

		var fu_total_gov_exp_month = $('input[name="fu_total_gov_exp_month"]').val()

		var fu_gov_exp_doc = $('input[name="fu_gov_exp_doc"]')[0].files



		var fu_total_nongov_exp_year = $('input[name="fu_total_nongov_exp_year"]').val()

		var fu_total_nongov_exp_month = $('input[name="fu_total_nongov_exp_month"]').val()

		var fu_nongov_exp_doc = $('input[name="fu_nongov_exp_doc"]')[0].files



		if(fu_has_service == '' || fu_has_service == undefined){



			$('.service_yesno').html('Required')

			e_error = 1

		}

		else if(fu_has_service != 'Yes' && fu_has_service != 'No'){

			$('.service_yesno').html('Value should be between Yes or No')

			e_error = 1	

		}

		else{

			$('.service_yesno').html('')	

		}



		if(fu_has_service == 'Yes'){



		if(fu_current_gov_service == '' || fu_current_gov_service == undefined){



			$('.fu_current_gov_service').html('Required')

			e_error = 1

		}

		else if(fu_current_gov_service != 'Yes' && fu_current_gov_service != 'No'){

			$('.fu_current_gov_service').html('Value should be between Yes or No')

			e_error = 1	

		}

		else{

			$('.fu_current_gov_service').html('')	

		}

		



		if(fu_service_designation == ''){



			$('.fu_service_designation').html('Designation is Required')

			e_error = 1

		}

		else if(!fu_service_designation.match(alphaletters_spaces)){

			$('.fu_service_designation').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_service_designation').html('')	

		}



		if(fu_service_exp_year == ''){



			$('.fu_service_exp_year').html('Experience is Required')

			e_error = 1

		}

		else if(!fu_service_exp_year.match(onlynumerics)){

			$('.fu_service_exp_year').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_service_exp_year').html('')	

		}



		if(fu_service_exp_month == ''){



			$('.fu_service_exp_month').html('Experience is Required')

			e_error = 1

		}

		else if(!fu_service_exp_month.match(onlynumerics)){

			$('.fu_service_exp_month').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_service_exp_month').html('')	

		}



		if(fu_total_gov_exp_year == ''){



			$('.fu_total_gov_exp_year').html('Goverment Experience is Required')

			e_error = 1

		}

		else if(!fu_total_gov_exp_year.match(onlynumerics)){

			$('.fu_total_gov_exp_year').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_total_gov_exp_year').html('')	

		}



		if(fu_total_gov_exp_month == ''){



			$('.fu_total_gov_exp_month').html('Goverment Experience is Required')

			e_error = 1

		}

		else if(!fu_total_gov_exp_month.match(onlynumerics)){

			$('.fu_total_gov_exp_month').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_total_gov_exp_month').html('')	

		}



		var fileInput;

		var filePath;



    if($('input[name="fu_total_gov_exp_year"]').val() > 0 || $('input[name="fu_total_gov_exp_month"]').val() > 0){

  		fileInput = document.querySelector('input[name="fu_gov_exp_doc"]')

  		filePath = fileInput.value



  		if($('input[name="fu_gov_exp_doc"]').val() == ''){



  			if($('.fu_uploaded_gov_exp_doc').text() == ''){



  				$('.fu_gov_exp_doc').html('Document is Required')

  				e_error = 1		

  			}

  			else $('.fu_gov_exp_doc').html('')

  		}

  		else if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

  			e_error = 1;

  			$('.fu_gov_exp_doc').html('Document File type Invalid.(Use Image File or PDF)');

  		}

  		else{



        if(fileInput.files[0].size >  docFileMaxSize){

          e_error = 1;

          $('.fu_gov_exp_doc').html('File size must be less than or equal to 2 MB');

        }



  			else $('.fu_gov_exp_doc').html('')

  		}

    }




		if(fu_total_nongov_exp_year == ''){



			$('.fu_total_nongov_exp_year').html('Non-goverment experience is Required')

			e_error = 1

		}

		else if(!fu_total_nongov_exp_year.match(onlynumerics)){

			$('.fu_total_nongov_exp_year').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_total_nongov_exp_year').html('')	

		}



		if(fu_total_nongov_exp_month == ''){



			$('.fu_total_nongov_exp_month').html('Non-goverment experience is Required')

			e_error = 1

		}

		else if(!fu_total_nongov_exp_month.match(onlynumerics)){

			$('.fu_total_nongov_exp_month').html('Illegal character used!')	

			e_error = 1

		}

		else{

			$('.fu_total_nongov_exp_month').html('')	

		}

		

    if($('input[name="fu_total_nongov_exp_year"]').val() > 0 || $('input[name="fu_total_nongov_exp_month"]').val() > 0){

  		fileInput = document.querySelector('input[name="fu_nongov_exp_doc"]')

  		filePath = fileInput.value

  		

  		if($('input[name="fu_nongov_exp_doc"]').val() == ''){



  			if($('.fu_uploaded_nongov_exp_doc').text() == ''){

  				$('.fu_nongov_exp_doc').html('Document is Required')

  				e_error = 1		

  			}

  			else $('.fu_nongov_exp_doc').html('')

  		}



  		else if(fileInput.value != "" && !allowedExtensions.exec(filePath)  ){

  			e_error = 1;

  			$('.fu_nongov_exp_doc').html('Document File type Invalid.(Use Image File or PDF)');

  		}

  		else{



        if(fileInput.files[0].size >  docFileMaxSize){

          e_error = 1;

          $('.fu_nongov_exp_doc').html('File size must be less than or equal to 2 MB');

        }



  			else $('.fu_nongov_exp_doc').html('')

  		}

    }

		}



		if(quali <= 0){

			e_error = 1;

			error_message = "Qualification is missing";

		}



    if(!are_all_qualifications_added()){

      e_error = 1;

      error_message = "All Qualifications are not added! Please fill up all qualification related data";  

    }



		if(e_error == 1){

			$('.div_roller_total_4').fadeOut();

			$('.get_error_total_4').html(error_message);

			$(".get_error_total_4").fadeIn();

			$(".text-error").fadeIn();

			

			setTimeout(function(){ $('.text-error, .get_error_total_4').fadeOut();$('.text-error').html('') }, delay);

		}

		else{



      let c = confirm('Are you sure, do you want to submit the form ?');

      if(!c){

        $('.div_roller_total_4').fadeOut();

        return;

      } 



			var form_data = new FormData();

			

			form_data.append('fu_has_service',fu_has_service);

			form_data.append('fu_service_designation',fu_service_designation);

			form_data.append('fu_service_exp_year',fu_service_exp_year);

			form_data.append('fu_service_exp_month',fu_service_exp_month);

			form_data.append('fu_current_gov_service',fu_current_gov_service);

			form_data.append('fu_total_gov_exp_year',fu_total_gov_exp_year);

			form_data.append('fu_total_gov_exp_month',fu_total_gov_exp_month);
      // if($('input[name="fu_total_gov_exp_year"]').val() > 0 || $('input[name="fu_total_gov_exp_month"]').val() > 0)
			form_data.append('fu_total_nongov_exp_year',fu_total_nongov_exp_year);

			form_data.append('fu_total_nongov_exp_month',fu_total_nongov_exp_month);

			

			form_data.append("fu_gov_exp_doc", fu_gov_exp_doc[0]);

			form_data.append("fu_nongov_exp_doc", fu_nongov_exp_doc[0]);



			$.ajax({

				method:'POST',

				url:'<?php echo base_url()."member/final_step_processing"; ?>',

				data:form_data,

				dataType:'JSON',

				contentType: false,

				processData: false,

				success:function(data){

					console.log(data)

					

					if(data.msg == 1)

					{

					

						$('.div_roller_total_4').fadeOut();

						$('.get_success_total_4').html('Form Submitted Successfully.');

						$(".get_success_total_4").fadeIn();

						setTimeout(function(){ $('.get_success_total_4').fadeOut(); }, 3000);

						setTimeout(function(){ window.location.replace("<?php echo site_url('member')?>"); }, 3000);

						

					}else{

							

						$('.div_roller_total_4').fadeOut();

						error_message = "There have some problem to Store Data, Try after some time.";

						error_message = error_message + "<br/>" + data.e_msg;

						$('.get_error_total_4').html(error_message);

						$(".get_error_total_4").fadeIn();

						setTimeout(function(){ $('.get_error_total_4').fadeOut(); }, delay);

					}

					



				}

				

			});

			

		}

	}

	<?php } ?>

	

	function isDatecheck_dmY(txtDate){

		var currVal = txtDate;

		if(currVal == '')

			return false;

		

		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex

		var dtArray = currVal.match(rxDatePattern); // is format OK?

		

		if (dtArray == null) 

			return false;

		//Checks for dd/mm/yyyy format.

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

	

	function isDatecheck(txtDate)

	{

		var currVal = txtDate;

		if(currVal == '')

			return false;



		var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex

		var dtArray = currVal.match(rxDatePattern); // is format OK?



		if (dtArray == null) 

			return false;



		//Checks for mm/dd/yyyy format.

		dtMonth = dtArray[3];

		dtDay= dtArray[5];

		dtYear = dtArray[1];        



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

  

<script type="text/javascript">



	function yesnoCheck() {

		if (document.getElementById('yesCheck').checked)

		 {

			document.getElementById('ifYes').style.display = 'block';

			

		}

		else document.getElementById('ifYes').style.display = 'none';

		

	}



	function yesnoCheck2() {

		if (document.getElementById('yesCheck2').checked)

		 {

			document.getElementById('ifyespwd').style.display = 'block';

			

		}

		else document.getElementById('ifyespwd').style.display = 'none';

		

	}



	function yesnoCheck3() {

		if (document.getElementById('yesCheck3').checked)

		 {

			document.getElementById('ifyesexem').style.display = 'block';

			

		}

		else document.getElementById('ifyesexem').style.display = 'none';

		

	}



	function yesnoCheck4() {

		if (document.getElementById('yesCheck4').checked)

		 {

			document.getElementById('ifyesex').style.display = 'block';

			

		}

		else document.getElementById('ifyesex').style.display = 'none';

		

	}



	function yesnoCheck5() {

		if (document.getElementById('yesCheck5').checked)

		 {

			document.getElementById('ifyesage').style.display = 'block';

			

		}

		else document.getElementById('ifyesage').style.display = 'none';

		

	}



	function yesnoCheck6() {

		if (document.getElementById('yesCheck6').checked)

		 {

			document.getElementById('ifyesservice').style.display = 'block';

			

		}

		else document.getElementById('ifyesservice').style.display = 'none';

		

	}



	function yesnoCheck7() {

		if (document.getElementById('yesCheck7').checked)

		 {

			document.getElementById('ifyesemp').style.display = 'block';

			

		}

		else document.getElementById('ifyesemp').style.display = 'none';

		

	}



	if (document.getElementById('yesCheck6').checked)

	 {

		document.getElementById('ifyesservice').style.display = 'block';

		

	}

	else document.getElementById('ifyesservice').style.display = 'none';



</script>

