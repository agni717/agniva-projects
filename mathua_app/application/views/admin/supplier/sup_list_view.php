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
            Supplier List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Supplier List</li>
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
              <div class="box box-danger">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Supplier Name</td>
	                  		<td>Company</td>
	                  		<td>Mobile</td>
	                  		<td>Bank</td>
	                  		<td>A/C No.</td>
	                  		<td>IFSC</td>
	                  		<td>Status</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($sp_list as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo $keys + 1; ?></td>
                  			<td><?php echo $users->supp_name; ?></td>
                  			<td><?php echo $users->supp_company; ?></td>
                  			<td><?php echo $users->supp_mobile; ?></td>
                  			<td><?php echo $users->supp_bank; ?></td>
                  			<td><?php echo $users->supp_account_no; ?></td>
                  			<td><?php echo $users->supp_ifsc_code; ?></td>
                  			<td><?php if($users->supp_status == 1){ echo '<font style="color:green;">Active</font>'; }else{ echo '<font style="color:red;">InActive</font>'; } ?></td>
                  			<td>
                  				<a href="<?php echo base_url().'admincontrol/suppliers/edit_supplier/'.$users->supp_id; ?>" title="Edit Record"><i class="fa fa-edit text-danger"></i></a>
                  				<?php if($users->supp_status == 1){ ?>	
                  				<a href="<?php echo base_url().'admincontrol/suppliers/lock_supplier/'.$users->supp_id; ?>" title="Lock Record"><i class="fa fa-unlock text-danger"></i></a>
                  				<?php } else { ?>
								<a href="<?php echo base_url().'admincontrol/suppliers/unlock_supplier/'.$users->supp_id; ?>" title="Unock Record"><i class="fa fa-lock text-danger"></i></a>
								<?php } ?>
								<!--<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/suppliers/delete_frontend_user/'.$users->supp_id; ?>" title="Delete Record"><i class="fa fa-trash-o text-danger"></i></a>-->
                  				
                  			</td>
                  		</tr>	
                  		<?php } ?>
                  	</tbody>
                  </table>
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