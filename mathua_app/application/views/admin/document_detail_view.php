<?php $this->load->view('admin/component/header') ?>
<?php $this->load->view('admin/component/menu') ?>

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
		  Application Details
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Application Details</li>
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
					<div class="text-right">
					<?php if($doc_detail->appli_status != 3){ ?>
					<a class="btn btn-success" href="<?php echo base_url().'admincontrol/panel/approve_application/'.$doc_detail->app_id; ?>" title="Approve Record"><i class="fa fa-edit"></i> Approve</a>
					<?php } ?>
					<?php if($doc_detail->appli_status != 4){ ?>
					<a class="btn btn-danger" href="<?php echo base_url().'admincontrol/panel/reject_application/'.$doc_detail->app_id; ?>" title="Reject Record"><i class="fa fa-trash-o"></i> Reject</a>
					<?php } ?>

					<?php if($doc_detail->appli_status == 3){ ?>
					<a href="<?php echo base_url()."admincontrol/panel/print_final_application/".$doc_detail->app_ucode; ?>" class="btn btn-success" target="_blank">Approval Print</a>
					<?php } ?>
					<a href="<?php echo base_url()."admincontrol/panel/print_application/".$doc_detail->app_ucode; ?>" class="btn btn-primary" target="_blank">Print</a>
					</div>
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                <tbody>
						<tr>
							<td width="25%"><strong>Application Number</strong></td>
							<td><strong><?php echo $doc_detail->app_ucode; ?></strong></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Name</strong></td>
							<td><?php echo $doc_detail->appli_name; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Address</strong></td>
							<td><?php echo $doc_detail->appli_address; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Email</strong></td>
							<td><?php echo $doc_detail->appli_email; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Mobile</strong></td>
							<td><?php echo $doc_detail->appli_mobile; ?></td>
						</tr>
						<tr>
							<td><strong>Work Name</strong></td>
							<td><?php echo $doc_detail->appli_work; ?></td>
						</tr>
						<tr>
							<td><strong>Work Location</strong></td>
							<td><?php echo $doc_detail->appli_work_loc; ?></td>
						</tr>
						<tr>
							<td><strong>Sub Division</strong></td>
							<td><?php echo $doc_detail->sub_div_name; ?></td>
						</tr>
						<tr>
							<td><strong>Block</strong></td>
							<td><?php echo $doc_detail->block_name; ?></td>
						</tr>
						<tr>
							<td><strong>GP Name</strong></td>
							<td><?php echo $doc_detail->gp_name; ?></td>
						</tr>
						<tr>
							<td><strong>Police Station</strong></td>
							<td><?php echo $doc_detail->ps_name; ?></td>
						</tr>
						<tr>
							<td><strong>Number of Workers</strong></td>
							<td><?php echo $doc_detail->appli_worker; ?></td>
						</tr>
						<tr>
							<td><strong>Workers are local/ from outside</strong></td>
							<td><?php echo $doc_detail->appli_worker_loc; ?></td>
						</tr>
						<tr>
							<td><strong>Work Order Copy</strong></td>
							<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/workorder/'.$doc_detail->appli_workorder; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<tr>
							<td><strong>Details of Workers Copy</strong></td>
							<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/worker/'.$doc_detail->appli_worker_detail; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<?php if($doc_detail->appli_status == 4){ ?>
						<tr>
							<td><strong>Status : <span style="color:red;">Rejected</span></strong></td>
							<td>Reason - <?php echo $doc_detail->appli_admin_msg; ?></td>
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