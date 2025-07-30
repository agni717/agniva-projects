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
		  IDM Application List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">IDM Application List</li>
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
	                  		<td>Application No.</td>
	                  		<td>Applicant Name</td>
	                  		<td>Applicant Identity Doc</td>
	                  		<td>Applicant Medical/Emergency Doc</td>
	                  		<td>Application Date</td>
	                  		<td>Status</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($doc_list as $keys=>$docs)
                  		{ ?>
                  		<tr>
                  			<td><?php echo $keys + 1; ?></td>
                  			<td><?php echo $docs->idm_ucode; ?></td>
                  			<td><?php echo $docs->idm_name; ?></td>
                  			<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/idcard/'.$docs->idm_identity_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
                  			<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/medical/'.$docs->idm_medical_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
                  			<td><?php echo date('d-m-Y',strtotime($docs->idm_createdate)); ?></td>
							  <td><?php if($docs->idm_status == 1){ echo '<font style="color:blue;">Submitted</font>'; }
							  elseif($docs->idm_status == 2){ echo '<font style="color:#b28b0c;">Processed</font>'; }
							  elseif($docs->idm_status == 3){ echo '<font style="color:green;">Approved</font>'; }
							  elseif($docs->idm_status == 4){ echo '<font style="color:red;">Rejected</font>'; } ?></td>
                  			<td>
                  				<a class="btn btn-primary" href="<?php echo base_url().'admincontrol/movement/view_idm_application/'.$docs->idm_id; ?>" title="View Record"><i class="fa fa-list"></i> View</a>
								<!-- <?php //if($docs->idm_status != 3){ ?>
								<a class="btn btn-success" href="<?php //echo base_url().'admincontrol/movement/approve_idm_application/'.$docs->idm_id; ?>" title="Approve Record"><i class="fa fa-edit"></i> Approve</a>
								<?php //} ?>
								<?php //if($docs->idm_status != 4){ ?>
								<a class="btn btn-danger" href="<?php //echo base_url().'admincontrol/movement/reject_idm_application/'.$docs->idm_id; ?>" title="Reject Record"><i class="fa fa-trash-o"></i> Reject</a>
								<?php //} ?> -->
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