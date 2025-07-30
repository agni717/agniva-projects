<?php $this->load->view('admin/component/header') ?>

<?php //$this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('.alert-error, .text-error').delay(6000).fadeOut();
	});
</script>
<style>
.text-error { color: red;}
</style>

<div class="home pb-5">
						<div class="container">
							<div class="row">						
								<div class="col-lg-10 m-auto" >
									<div class="widget-area-2 proclinic-box-shadow">
										<h3 class="widget-title">Edit Profile</h3>
										<?php echo form_open_multipart('','class="form-horizontal"'); ?>
										<?php //echo form_open_multipart(base_url().'admincontrol/dashboard/edit_user/'.$data_list->u_id,'class="form-horizontal" id="myForm"'); ?>
											<?php if (isset($error)) { ?>
											<div class="alert alert-error alert-danger">                
												<h4>Error!</h4>
												<?php echo $error; ?>
											</div>
											<?php } ?>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>First Name</label>
													<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" value="<?php echo $profile_list->firstname; ?>" autocomplete="off" />
													<small class="text-error fname"><?php echo form_error('fname'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Last Name</label>
													<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" value="<?php echo $profile_list->lastname; ?>" autocomplete="off" />
													<small class="text-error lname"><?php echo form_error('lname'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Mobile No.</label>
													<input type="text" class="form-control" name="u_mobile" id="u_mobile" placeholder="Enter Mobile" value="<?php echo $profile_list->mobile; ?>" autocomplete="off" disabled="" />
													<small class="text-error u_mobile"><?php echo form_error('u_mobile'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Email</label>
													<input type="email" class="form-control" name="emailid" id="emailid" placeholder="Enter Email" value="<?php echo $profile_list->email; ?>" autocomplete="off" disabled="" />
													<small class="text-error emailid"><?php echo form_error('emailid'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												
												<div class="form-group col-lg-12">
													<label>Address</label>
													<textarea class="form-control" name="u_address" id="u_address" placeholder="Enter Full Address"><?php echo $profile_list->address; ?></textarea>
													<small class="text-error u_address"><?php echo form_error('u_address'); ?></small>
												</div>
											</div>
											<!--<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Account No.</label>
													<input type="text" name="u_account_no" id="u_account_no" placeholder="Enter Account No." class="form-control" value="<?php //echo $data_list->u_account_no; ?>" autocomplete="off" />
													<small class="text-error u_account_no"><?php //echo form_error('u_account_no'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>Bank Name</label>
													<input type="text" name="u_bankname" id="u_bankname" placeholder="Enter Bank Name" class="form-control" value="<?php //echo $data_list->u_bank_name; ?>" autocomplete="off" />
													<small class="text-error u_bankname"><?php //echo form_error('u_bankname'); ?></small>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-6">
													<label>Branch Name</label>
													<input type="text" name="u_branch_name" id="u_branch_name" placeholder="Enter Branch Name" class="form-control" value="<?php //echo $data_list->u_branch_name; ?>" autocomplete="off" />
													<small class="text-error u_branch_name"><?php //echo form_error('u_branch_name'); ?></small>
												</div>
												<div class="form-group col-lg-6">
													<label>IFSC Code</label>
													<input type="text" name="u_ifsc" id="u_ifsc" placeholder="Enter IFSC Code" class="form-control" value="<?php //echo $data_list->u_ifsc_code; ?>" autocomplete="off" />
													<small class="text-error u_ifsc"><?php //echo form_error('u_ifsc'); ?></small>
												</div>
											</div>-->
											<div class="form-row control-group">
												<div  class="col-lg-12 text-center">
													<div align="center">
														<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
														<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
													</div>
												</div>
											</div>
											<div class="form-row control-group">
												<div class="form-group col-lg-12">
													<input type="submit" class="btn btn-success" name="submit" value="Submit" />
													&nbsp;<a href="<?php echo site_url('admincontrol/dashboard/profile'); ?>" class="btn btn-danger">Cancel</a>
												</div>
											</div>
										<?php echo form_close(); ?>								
									</div>
								</div>
							</div>
							
						</div>
					</div>



<?php $this->load->view('admin/component/footer') ?>