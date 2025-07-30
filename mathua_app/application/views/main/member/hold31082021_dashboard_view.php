<?php $this->load->view('main/component/login_header')?>
 
<style>
.alert-error, .text-error, .redclass{
    	color: red !important;
	}
</style>
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
					<input type="text" class="form-control" placeholder="Father's Name" id="father_name" name="father_name" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> /> 
					<small class="text-error father_name"><?php echo form_error('father_name'); ?></small>
				</div>
                <div class="col-sm-2">Mother's Name :</div>
                <div class="col-sm-4">
					<input type="text" class="form-control" placeholder="Mother's Name" id="mother_name" name="mother_name" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> />
					<small class="text-error mother_name"><?php echo form_error('mother_name'); ?></small>
				</div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-2">Gender :</div>
                <div class="col-sm-4">
					<label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_1" autocomplete="off" value="Male" checked <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Male</label>
                    <label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_2" autocomplete="off" value="Female" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Female</label> 
                    <label class="radio-inline"><input type="radio" name="fu_gender" id="fu_gender_3" autocomplete="off" value="Others" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Others</label>
					<small class="text-error fu_gender"><?php echo form_error('fu_gender'); ?></small>
                </div>
                <div class="col-sm-2">Date of Birth :</div>
                <div class="col-sm-4">
					<input type="date" class="form-control" name="fu_dob" id="fu_dob" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?> />
					<small class="text-error fu_dob"><?php echo form_error('fu_dob'); ?></small>
				</div>
            </div>                      
            <div class="row mt-3">
				<div class="col-sm-2">Marital  Status :</div>
                <div class="col-sm-4">
                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_1" autocomplete="off" value="Single" checked <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Single</label>
                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_2" autocomplete="off" value="Married" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Married</label> 
                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_3" autocomplete="off" value="Widow" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Widow</label> 
                    <label class="radio-inline"><input type="radio" name="fu_mt_status" id="fu_mt_status_4" autocomplete="off" value="Divorced" <?php if($fuser_detailset->fu_step_2 == 1){ echo "disabled";}?> /> Divorced</label>
					<small class="text-error fu_mt_status"><?php echo form_error('fu_mt_status'); ?></small>
                </div>
                <div class="col-sm-2">Address :</div>
                <div class="col-sm-4">
					<textarea class="form-control" name="fu_address" id="fu_address" rows="3" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){ echo "readonly";}?>></textarea>
					<small class="text-error fu_address"><?php echo form_error('fu_address'); ?></small>
				</div>
            </div>                     
                                
            <div class="row mt-3">
                <div class="col-sm-2 ">District :</div>
                <div class="col-sm-4"> 
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
				<div class="col-sm-2 pr-0">Domicile State :</div>
                <div class="col-sm-4">
					<select class="form-control" name="fu_dom_state" id="fu_dom_state" autocomplete="off" <?php if($fuser_detailset->fu_step_2 == 1){echo "disabled";}?>>
						<?php if($fuser_detailset->fu_step_2 != 1){ ?>
						<option value="">---Select---</option>
						<?php foreach($state_list as $states){ ?>
						<option value="<?php echo $states->state_id; ?>" <?php if(!empty($fuser_detailset->fu_domicile_state)){if($states->state_id == $fuser_detailset->fu_domicile_state){echo "selected";}}?>><?php echo $states->state_name; ?></option>
						<?php }
						}else{ ?>
						<option value="<?php echo $state_list->state_id; ?>" selected="selected"><?php echo $state_list->state_name; ?></option>
						<?php } ?>
                    </select>
					<small class="text-error fu_dom_state"><?php echo form_error('fu_dom_state'); ?></small>
				</div>
            </div>                     
                                
			<div class="row mt-3">
                <div class="col-sm-2">Photo Upload :</div>
                <div class="col-sm-4">
					<input type="file" name="fu_pic_doc" id="fu_pic_doc" class="form-control" autocomplete="off" />
					<small class="text-error fu_pic_doc"><?php echo form_error('fu_pic_doc'); ?></small>
				</div>
                <div class="col-sm-2">Signature Upload :</div>
                <div class="col-sm-4">
					<input type="file" name="fu_sign_doc" id="fu_sign_doc" class="form-control" autocomplete="off" />
					<small class="text-error fu_sign_doc"><?php echo form_error('fu_sign_doc'); ?></small>
				</div>
            </div>
			<div class="row mt-3">
				<div class="col-sm-2">Date of Birth Proof Document :</div>
                <div class="col-sm-4">
					<input type="file" name="fu_dob_doc" id="fu_dob_doc" class="form-control" autocomplete="off" />
					<small class="text-error fu_dob_doc"><?php echo form_error('fu_dob_doc'); ?></small>
				</div>
                <div class="col-sm-2">Address Proof Document :</div>
                <div class="col-sm-4">
					<input type="file" name="fu_address_doc" id="fu_address_doc" class="form-control" autocomplete="off" />
					<small class="text-error fu_address_doc"><?php echo form_error('fu_address_doc'); ?></small>
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
                                 <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck"> No <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" 
                                 id="noCheck"><br>
                               <div id="ifYes" style="display:none">
                               <input type='radio' id='yes' name='yes'> SC
                              <input type='radio' id='acc' name='acc'> ST
                               <input type='radio' id='acc' name='acc'> OBC A
                                <input type='radio' id='acc' name='acc'> OBC B
                                <div class="row mt-2">
                                <div class="col-sm-2" >Certification No :</div>
                                <div class="col-sm-4" ><input type="text" class="form-control" placeholder="Certification No"/></div>
                                <div class="col-sm-2" >Issued By Whom </div>
                                <div class="col-sm-4" ><input type="text" class="form-control" placeholder="name"/></div>
                                
                                </div>
                                
                                <div class="row mt-2">
                                <div class="col-sm-2" > Issued by Date :</div>
                                <div class="col-sm-4" > <input type="date" class="form-control"></div>
                                <div class="col-sm-2" > Doc Upload:</div>
                                <div class="col-sm-4" > <input type="file" class="form-control" ></div>
                                
                                </div>
                                  
                                     </div>
                                     
                                     </div>
                                     
                                    
                                </div>
                                
                                
         <div class="row mt-3">
                                <div class="col-sm-2">PWD :</div>
                                 <div class="col-sm-10"> Yes 
                                  <input type="radio" onclick="javascript:yesnoCheck2();" name="yesno" id="yesCheck2"> No <input type="radio" onclick="javascript:yesnoCheck2();" name="yesno" 
                                 id="noCheck2"><br> 
                                 
                                     <div class="row mt-2" id="ifyespwd" style="display:none;">
                                     <div class="row ">
                                <div class="col-sm-2 pl-4">Percentage of Disability :</div>
                                <div class="col-sm-4"><input type="text" class="form-control"></div>
                                <div class="col-sm-2 ">Issuing Authority:</div>
                                <div class="col-sm-3"><input type="text" class="form-control" ></div>
                                </div>
                                
                                      <div class="row mt-2">
                                <div class="col-sm-2 pl-4" >Issued by Date :</div>
                                <div class="col-sm-4" ><input type="date" class="form-control"></div>
                                <div class="col-sm-2" >Doc Upload:</div>
                                <div class="col-sm-3" ><input type="file" class="form-control" ></div>
                                
                                </div>
                                </div>
                                     </div>
                                     
                                    
                                </div>  
                                
                                
           <div class="row mt-3">
                                <div class="col-sm-2">Exempted :</div>
                                 <div class="col-sm-10"> Yes 
                                  <input type="radio" onclick="javascript:yesnoCheck3();" name="yesno" id="yesCheck3"> No <input type="radio" onclick="javascript:yesnoCheck3();" name="yesno" 
                                 id="noCheck3"><br> 
                                 
                                     <div class="row mt-2" id="ifyesexem" style="display:none;">
                                     <div class="row pl-2">
                                <div class="col-sm-2 pl-4">Reason :</div>
                                <div class="col-sm-4"><textarea class="form-control" rows="3" id="reason"></textarea></div>
                                <div class="col-sm-2">Upload Doc :</div>
                                <div class="col-sm-3"><input type="file" class="form-control" ></div>
                                </div>
                                
                                      
                                </div>
                                     </div>
                                     
                                    
                                </div>  
                                
            <div class="row mt-3">
                                <div class="col-sm-2">Ex Serviceman :</div>
                                 <div class="col-sm-10"> Yes 
                                  <input type="radio" onclick="javascript:yesnoCheck4();" name="yesno" id="yesCheck4"> No <input type="radio" onclick="javascript:yesnoCheck4();" name="yesno" 
                                 id="noCheck4"><br> 
                                 
                                     <div class="row mt-2" id="ifyesex" style="display:none;">
                                     <div class="row pl-2">
                                <div class="col-sm-2 pl-4">Reason :</div>
                                <div class="col-sm-4"><textarea class="form-control" rows="3" id="reason"></textarea></div>
                                <div class="col-sm-2">Upload Doc :</div>
                                <div class="col-sm-3"><input type="file" class="form-control" ></div>
                                </div>
                                
                                      
                                </div>
                                     </div>
                                     
                                    
                                </div> 
                                
                                
            <div class="row mt-3">
                                <div class="col-sm-2">Age Relaxion:</div>
                                 <div class="col-sm-10"> Yes 
                                  <input type="radio" onclick="javascript:yesnoCheck5();" name="yesno" id="yesCheck5"> No <input type="radio" onclick="javascript:yesnoCheck5();" name="yesno" 
                                 id="noCheck4"><br> 
                                 
                                     <div class="row mt-2" id="ifyesage" style="display:none;">
                                     <div class="row pl-2">
                                <div class="col-sm-2 pl-4">Reason :</div>
                                <div class="col-sm-4"><textarea class="form-control" rows="3" id="reason"></textarea></div>
                                <div class="col-sm-2">Upload Doc :</div>
                                <div class="col-sm-3"><input type="file" class="form-control" ></div>
                                </div>
                                
                                      
                                </div>
                                     </div>
                                     
                                    
                                </div>                                       
                                                                        
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
					<button onclick="two_step_save();">Save</button>
					<button onclick="two_step_process();">Procceed</button>
				<?php } ?>
				</div>
			</div>
      </div>
	  
      <div class="step-tab-panel" data-step="step4">
        <h3>Qualification</h3>
        <div class="row mt-3">
                                <div class="col-sm-2 ">Examination Name :</div>
                                 <div class="col-sm-4"> <input type="text" class="form-control">
                                    
                                     </div>
                                 <div class="col-sm-2 ">University Name : </div>
                                  <div class="col-sm-4"> <input type="text" class="form-control"></div>
                                 
                                </div>
        <div class="row mt-3">
                                <div class="col-sm-2 ">Marks Obtain :</div>
                                 <div class="col-sm-4"> <input type="text" class="form-control">
                                    
                                     </div>
                                 <div class="col-sm-2 ">Full Marks : </div>
                                  <div class="col-sm-4"> <input type="text" class="form-control"></div>
                                 
                                </div> 
                                
       <div class="row mt-3">
                                <div class="col-sm-2 ">Percentage of Marks :</div>
                                 <div class="col-sm-4"> <input type="text" class="form-control">
                                    
                                     </div>
                                 <div class="col-sm-2 ">Marksheet Issued Date: </div>
                                  <div class="col-sm-4"> <input type="date" class="form-control"></div>
                                 
                                </div>  
        <div class="row mt-3">
              <div class="col-sm-2">Upload Marksheet :</div>
             <div class="col-sm-3"><input type="file" class="form-control" ></div>
                                
           
            </div>     
            
            
        <div class="row mt-3">
                                <div class="col-sm-2">Service Person :</div>
                                 <div class="col-sm-10"> Yes 
                                  <input type="radio" onclick="javascript:yesnoCheck6();" name="yesno" id="yesCheck6"> No <input type="radio" onclick="javascript:yesnoCheck6();" name="yesno" 
                                 id="noCheck4"><br> 
                                 
                                     <div class="row mt-2" id="ifyesservice" style="display:none;">
                                     <div class="row pl-2">
                                <div class="col-sm-3 pl-4">Are you Govt employee ?</div>
                                <div class="col-sm-4">  <label class="radio-inline">
                                  <input type="radio" name="optradio" checked> Yes
                                </label>
                               <label class="radio-inline">
                                <input type="radio" name="optradio"> No
                                  </label>
                                
                                
                                </div>
                                
                                
                                </div>
                                    <div class="row mt-2" >
                                     <div class="row pl-4">
                                <div class="col-sm-2 pl-4">Designation :</div>
                                <div class="col-sm-3"><input type="text" class="form-control" ></div>
                                <div class="col-sm-2">Experiance :</div>
                                <div class="col-sm-2"><input type="text" class="form-control" placeholder="Year" ></div>
                                <div class="col-sm-2"><input type="text" class="form-control" placeholder="Month" ></div>
                                </div>
                                
                                      
                                </div>
                                      
                                </div>
                                     </div>
                                     
                                    
                                </div> 
                                
                                
                                
                                
                                
                                <div class="col-sm-12 mt-2" >
                                     <div class="row ">
                                <div class="col-sm-2 p-0">Total Govt Experiance :</div>
                                <div class="col-sm-2 p-0"><input type="text" class="form-control" placeholder="year" ></div>
                                 <div class="col-sm-2"><input type="text" class="form-control" placeholder="month" ></div>
                                  <div class="col-sm-2 p-0">Upload Doc:</div>
                                  <div class="col-sm-3"><input type="file" class="form-control" placeholder="month" ></div>
                                
                                </div>
                                
                                      
                                </div>
                                
                                
                                <div class="col-sm-12 mt-4" >
                                     <div class="row ">
                                <div class="col-sm-2 p-0">Total Non Govt Experiance :</div>
                                <div class="col-sm-2 p-0"><input type="text" class="form-control" placeholder="year" ></div>
                                 <div class="col-sm-2"><input type="text" class="form-control" placeholder="month" ></div>
                                  <div class="col-sm-2 p-0">Upload Doc:</div>
                                  <div class="col-sm-3"><input type="file" class="form-control" placeholder="month" ></div>
                                
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
				<?php 
				if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1 && $fuser_detailset->fu_step_3 == 1)&&($fuser_detailset->fu_step_4 == 0 || $fuser_detailset->fu_step_4 == 2)){ ?>
				<button onclick="four_step_save();">Save</button>
				<button onclick="finisher_step();">Submit</button>
				<?php } ?>
				</div>
			</div>
      </div>
     
    </div>
   
    
</div>


  </div>

<?php $this->load->view('main/component/footer'); ?>

<!--<script src="<?php //echo base_url(); ?>frontend/js/jquery.validate.min.js"></script>-->
<script src="<?php echo base_url(); ?>frontend/js/jquery-steps.js"></script>

<script type="text/javascript">
	$(function(){
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
	    $('.alert-error, .text-error').delay(8000).fadeOut();
	});
	
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
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
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
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
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
			var conf_answer = confirm("Are you sure you want to Submit the Data for Process Further?")
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
		alert('Hit Two step Save');
	}
	
	function two_step_process(){
		//alert('Hit Two step Process');
		$('.div_roller_total_2').fadeIn();
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
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedPic_Extensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
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
		alert(fu_dob);
		if(father_name == ""){
			e_error = 1;
			$('.father_name').html('Father Name is Required.');
		}else{
			if(!father_name.match(alphanumerics_no)){
				e_error = 1;
				$('.father_name').html('Father Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.father_name').html('');
			}	
		}
		if(mother_name == ""){
			e_error = 1;
			$('.mother_name').html('Mother Name is Required.');
		}else{
			if(!mother_name.match(alphanumerics_no)){
				e_error = 1;
				$('.mother_name').html('Mother Name not use special carecters [without _ / & : ( . ) , -], Check again.');
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
				$('.fu_gender').html('Gender only Alphabet value, Check again.');
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
				$('.fu_mt_status').html('Marital Status only Alphabet value, Check again.');
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
				$('.fu_dob').html('Date of Birth Format check properly.');
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
				$('.fu_address').html('Address not use special charecters [without _ / : ( @ & . ) , -], Check again.');
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
				$('.fu_district').html('District only use numeric value, Check again.');
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
				$('.fu_dom_state').html('Domicile State only use numeric value, Check again.');
			}else{
				$('.fu_dom_state').html('');
			}	
		}
		
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
				$('.fu_pic_doc').html('');
			}
		}
		if(document.getElementById("fu_sign_doc").files.length == 0){
			e_error = 1;
			$('.fu_sign_doc').html('Candidate Signature Picture is Required.');
		}else{
			var fileInput = document.getElementById('fu_sign_doc'); 
			var filePath = fileInput.value;
			if(!allowedPic_Extensions.exec(filePath)){
				e_error = 1;
				$('.fu_sign_doc').html('Candidate Signature File type Invalid.(Use Image File)');
			}else{
				$('.fu_sign_doc').html('');
			}
		}
		if(document.getElementById("fu_dob_doc").files.length == 0){
			e_error = 1;
			$('.fu_dob_doc').html('Date of Birth Document is Required.');
		}else{
			var fileInput = document.getElementById('fu_dob_doc'); 
			var filePath = fileInput.value;
			if(!allowedPic_Extensions.exec(filePath)){
				e_error = 1;
				$('.fu_dob_doc').html('Date of Birth File type Invalid.(Use PDF/Image)');
			}else{
				$('.fu_dob_doc').html('');
			}
		}
		
		if(document.getElementById("fu_address_doc").files.length == 0){
			e_error = 1;
			$('.fu_address_doc').html('Address Proof Document is Required.');
		}else{
			var fileInput = document.getElementById('fu_address_doc'); 
			var filePath = fileInput.value;
			if(!allowedPic_Extensions.exec(filePath)){
				e_error = 1;
				$('.fu_address_doc').html('Address Proof File type Invalid.(Use PDF/Image)');
			}else{
				$('.fu_address_doc').html('');
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
			var conf_answer = confirm("Are you sure you want to Submit the Data for Process Further?")
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
	function three_step_save(){
		alert('Hit Three step Save');
	}
	
	function three_step_process(){
		alert('Hit Three step Process');
	}
	<?php } ?>
	
	<?php if(($fuser_detailset->fu_step_1 == 1 && $fuser_detailset->fu_step_2 == 1 && $fuser_detailset->fu_step_3 == 1) && ($fuser_detailset->fu_step_4 == 0 || $fuser_detailset->fu_step_4 == 2)){ ?>
	function four_step_save(){
		alert('Hit Four step Save');
	}
	
	function finisher_step(){
		alert('Final reached');
	}
	<?php } ?>
	
	function isDatecheck_dmY(txtDate)
	{
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

</script>
