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
            Frontend User List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Frontend User List</li>
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
				<!-- <div class="box-footer clearfix no-border">
                  <a href="<?php //site_url('admincontrol/dashboard/add_administrator') ?>" class="btn btn-primary pull-right"><i class="fa fa-user"></i>&nbsp; Add New User</a>
                </div> -->
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Name</td>
	                  		<td>Mail-ID</td>
	                  		<td>Mobile</td>
	                  		<td>User Type</td>
	                  		<td>Last Access IP</td>
	                  		<td>Last Login</td>
	                  		<td>Status</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($userlist as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo ($keys + 1); ?></td>
                  			<td><?php echo $users->f_full_name; ?></td>
                  			<td><?php echo $users->f_email; ?></td>
                  			<td><?php echo $users->f_mobile; ?></td>
                  			<td><?php echo $users->ftype_name; ?></td>
                  			<!--<td><?php //echo date('d-m-Y h:i A',strtotime($users->modify_date)); ?></td>
                  			<td><?php echo $users->district_name; ?></td>-->
                  			<td><?php echo $users->f_last_accessip; ?></td>
                  			<td><?php echo $users->f_last_aceesstime; ?></td>
                  			<td><?php if($users->f_status == 1){ ?>
								  <span style="color:green;">Active</span>
							  <?php }elseif($users->f_status == 0){ ?>
								<span style="color:red;">InActive</span>
							  <?php } ?></td>
                  			<td>
                  				<a href="<?php echo base_url().'admincontrol/front_user/edit_fuser/'.$users->f_uid; ?>" title="Edit User"><i class="fa fa-edit text-warning"></i></a>
                  				<?php if($users->f_status == 1){ ?>	
                  				<a href="<?php echo base_url().'admincontrol/front_user/lock_fuser/'.$users->f_uid; ?>" title="Lock User"><i class="fa fa-unlock text-warning"></i></a>
                  				<?php } else { ?>
								<a href="<?php echo base_url().'admincontrol/front_user/unlock_fuser/'.$users->f_uid; ?>" title="Unock User"><i class="fa fa-lock text-warning"></i></a>
								<?php } ?>
								<!--<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/front_user/delete_fuser/'.$users->f_uid; ?>" title="Delete User"><i class="fa fa-trash-o text-warning"></i></a>-->
                  				
                  			</td>
                  		</tr>	
                  		<?php } ?>
                  	</tbody>
                  </table>
				  </div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
      $(function () {
        $("#datatable_tab").dataTable();
      });
    </script>