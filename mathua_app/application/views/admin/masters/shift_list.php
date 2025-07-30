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
		  Shift List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Shift List</li>
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
                  <a href="<?php //site_url('admincontrol/dashboard/add_administrator') ?>" class="btn btn-primary pull-right"><i class="fa fa-user"></i>&nbsp; Add New Block</a>
                </div> -->
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Shift Name</td>
							<td>Shift Venue</td>
							<td>Shift Date</td>
							<td>Shift Timming</td>
							<td>Shift Table No.</td>
							<td>Status</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($sft_list as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo ($keys + 1); ?></td>
                  			<td><?php echo $users->shift_name; ?></td>
							<td><?php echo $users->address_name; ?></td>
							<td><?php echo date('d-m-Y',strtotime($users->shift_date)); ?></td>
							<td><?php echo date('h:i A',strtotime($users->shift_start_time))." To ".date('h:i A',strtotime($users->shift_end_time)); ?></td>
							<td><?php echo $users->shift_table_no; ?></td>
							<td><?php if($users->shift_status == 1){ ?>
								  <span style="color:green;">Active</span>
							  <?php }elseif($users->shift_status == 0){ ?>
								<span style="color:red;">InActive</span>
							  <?php } ?></td>
                  			<td>
                  				<a href="<?php echo base_url().'admincontrol/masterdata/modify_shift/'.$users->shift_id; ?>" title="Edit Record"><i class="fa fa-edit text-warning"></i></a>
                  				<?php if($users->shift_status == 1){ ?>	
                  				<a href="<?php echo base_url().'admincontrol/masterdata/lock_shift/'.$users->shift_id; ?>" title="Lock Record"><i class="fa fa-unlock text-warning"></i></a>
                  				<?php } else { ?>
								<a href="<?php echo base_url().'admincontrol/masterdata/unlock_shift/'.$users->shift_id; ?>" title="Unock Record"><i class="fa fa-lock text-warning"></i></a>
								<?php } ?>
								<!--<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/masterdata/delete_user/'.$users->address_id; ?>" title="Delete Record"><i class="fa fa-trash-o text-warning"></i></a>-->
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