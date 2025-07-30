<?php $this->load->view('admin/component/header') ?>

<?php //$this->load->view('admin/component/menu') ?>

<!-- <link href="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" /> -->

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
                     <h3 class="widget-title">Implementing Agency (DM Office) List</h3>
					 
						<?php if($this->session->flashdata('success')) { ?>
						<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
						<?php $this->session->unset_userdata('success'); }
							elseif($this->session->flashdata('e_error')) { ?>                
						<div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
						<?php $this->session->unset_userdata('e_error'); } ?>
			
						<div class="table-responsive mb-3">
							<table id="tableId" class="table table-bordered table-striped">
								<thead>
									<tr>												
										<th>Sl.No.</th>
										<th>Name</th>
										<th>User type</th>
										<th>District</th>
										<th>Block/Municipality</th>
										<th>Mobile No.</th>
                                        <th>Email Id</th>
                                        <th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($userlist as $keys=>$users){ ?>
									<tr>												
										<td><?php echo ($keys + 1); ?></td>
										<td><?php echo $users->firstname.' '.$users->lastname; ?></td>
										<td><?php echo $users->parent_type; ?></td>
										<td><?php echo $users->district_name; ?></td>
										<td><?php echo $users->block_name; ?></td>
										<td><?php echo $users->mobile; ?></td>
										<td><?php echo $users->email; //mu_name; ?></td>
										<td><?php if($users->user_status == 1){ ?>
											  <span style="color:green;">Active</span>
										  <?php }elseif($users->user_status == 0){ ?>
											<span style="color:red;">InActive</span>
										  <?php } ?></td>
										<td>
											<a href="<?php echo base_url().'admincontrol/dashboard/edit_user/'.$users->u_id; ?>" title="Edit User"><span class="ti-pencil"></span></a>
											<?php if($users->user_status == 1){ ?>	
											<a href="<?php echo base_url().'admincontrol/dashboard/lock_user/'.$users->u_id; ?>" title="Lock User"><span class="ti-unlock"></span></a>
											<?php } else { ?>
											<a href="<?php echo base_url().'admincontrol/dashboard/unlock_user/'.$users->u_id; ?>" title="Unlock User"><span class="ti-lock"></span></a>
											<?php } ?>
											<!--<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/dashboard/delete_user/'.$users->u_id; ?>" title="Delete User"><i class="fa fa-trash-o text-warning"></i></a>-->
											
										</td>
									</tr>		
									<?php } ?>
								</tbody>
                            </table>	                                
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 

<?php $this->load->view('admin/component/footer') ?>

<!--<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
      $(function () {
        $("#datatable_tab").dataTable();
      });
    </script>-->