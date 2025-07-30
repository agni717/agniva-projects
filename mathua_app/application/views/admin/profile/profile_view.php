<?php $this->load->view('admin/component/header') ?>

<?php //$this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>


<div class="home pb-5">
		<div class="container-fluid">
			
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                     <h3 class="widget-title">Profile</h3>
					 
						<?php if($this->session->flashdata('success')) { ?>
						<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
						<?php $this->session->unset_userdata('success'); }
							elseif($this->session->flashdata('e_error')) { ?>                
						<div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
						<?php $this->session->unset_userdata('e_error'); } ?>
			
						<div class="table-responsive mb-3">
							<table class="table table-bordered table-striped">
								<tr>
									<td><strong>First Name :</strong></td>
									<td><?php echo $usr_detail->firstname; ?></td>
								</tr>
								<tr>
									<td><strong>Last Name :</strong></td>
									<td><?php echo $usr_detail->lastname; ?></td>
								</tr>
								<tr>
									<td><strong>User Type :</strong></td>
									<td><?php echo $usr_detail->mu_name; ?></td>
								</tr>
								<tr>
									<td><strong>Mobile :</strong></td>
									<td><?php echo $usr_detail->mobile; ?></td>
								</tr>
								<tr>
									<td><strong>Registered Email :</strong></td>
									<td><?php echo $usr_detail->email; ?></td>
								</tr>
								<tr>
									<td><strong>Address :</strong></td>
									<td><?php echo $usr_detail->address; ?></td>
								</tr>
								</table>	
									
								<div><span><a href="<?= site_url('admincontrol/dashboard/editprofile') ?>" class="btn btn-info">Edit Profile</a></span>
								</div>
							</table>	                                
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 

<?php $this->load->view('admin/component/footer') ?>