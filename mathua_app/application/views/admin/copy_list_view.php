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
		  Terms & Conditions List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Terms & Conditions List</li>
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
	                  		<td>Terms & Conditions Title</td>
	                  		<td>Create Date</td>
	                  		<td>Status</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($fwd_list as $keys=>$docs)
                  		{ ?>
                  		<tr>
                  			<td><?php echo $keys + 1; ?></td>
                  			<td style="max-width:400px;"><?php echo $docs->cf_title; ?></td>
                  			<td><?php echo date('d-m-Y',strtotime($docs->cf_createdate)); ?></td>
							  <td><?php if($docs->cf_status == 1){ echo '<font style="color:green;">Active</font>'; }
							  else{ echo '<font style="color:red;">In-Active</font>'; } ?></td>
                  			<td>
                  			  <?php if($docs->cf_status == 1){ ?>
							  <a class="btn-sm btn-warning" href="<?php echo base_url().'admincontrol/panel/lock_cpy_fwd/'.$docs->cf_id; ?>" title="Lock Record"><i class="fa fa-unlock"></i> Lock</a>
							  <?php }else{ ?>
							  <a class="btn-sm btn-warning" href="<?php echo base_url().'admincontrol/panel/unlock_cpy_fwd/'.$docs->cf_id; ?>" title="Unlock Record"><i class="fa fa-unlock"></i> Lock</a>
							  <?php } ?>
							  <a onclick="return confirm('You are about to Delete a record. This cannot be undone. Are you sure?');" class="btn-sm btn-danger" href="<?php echo base_url().'admincontrol/panel/delete_cpy_fwd/'.$docs->cf_id; ?>" title="Delete Record"><i class="fa fa-trash-o"></i> Delete</a>
							</td>
                  		</tr>	
                  		<?php } ?>
                  	</tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer clearfix no-border">
                  <a href="<?= site_url('admincontrol/panel/add_cpy_fwd') ?>" class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Add Copy</a>
                </div>
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