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
		  IDM Application Details
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">IDM Application Details</li>
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
					<?php if($doc_detail->idm_status != 3){ ?>
					<a class="btn btn-success" href="<?php echo base_url().'admincontrol/movement/approve_idm_application/'.$doc_detail->idm_id; ?>" title="Approve Record"><i class="fa fa-edit"></i> Approve</a>
					<?php } ?>
					<?php if($doc_detail->idm_status != 4){ ?>
					<a class="btn btn-danger" href="<?php echo base_url().'admincontrol/movement/reject_idm_application/'.$doc_detail->idm_id; ?>" title="Reject Record"><i class="fa fa-trash-o"></i> Reject</a>
					<?php } ?>

					<?php if($doc_detail->idm_status == 3){ ?>
					<a href="<?php echo base_url()."admincontrol/movement/print_final_idm_application/".$doc_detail->idm_ucode; ?>" class="btn btn-success" target="_blank">Approval Print</a>
					<?php } ?>
					<a href="<?php echo base_url()."admincontrol/movement/print_idm_application/".$doc_detail->idm_ucode; ?>" class="btn btn-primary" target="_blank">Print</a>
					</div>
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                <tbody>
						<tr>
							<td width="25%"><strong>Application Number</strong></td>
							<td colspan="3"><strong><?php echo $doc_detail->idm_ucode; ?></strong></td>
						</tr>
						<tr>
							<td><strong>Applicant Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_name; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant Email</strong></td>
							<td width="30%"><?php echo $doc_detail->idm_email; ?></td>
							<td width="25%"><strong>Applicant Mobile</strong></td>
							<td><?php echo $doc_detail->idm_mobile; ?></td>
						</tr>
						<tr>
							<td colspan="4"><strong style="color:blue;">Present Address :-</strong></td>
						</tr>
						<tr>
							<td><strong>Village/Street Name</strong></td>
							<td><?php echo $doc_detail->idm_s_villege; ?></td>
							<td><strong>GP Name/Word No.</strong></td>
							<td><?php echo $doc_detail->idm_s_gp; ?></td>
						</tr>
						<tr>
							<td><strong>Block/Municipality</strong></td>
							<td><?php echo $doc_detail->idm_s_block; ?></td>
							<td><strong>District</strong></td>
							<td><?php echo $doc_detail->s_dist_name; ?></td>
						</tr>
						<tr>
							<td colspan="4"><strong style="color:blue;">Permanent Address (Destination) :-</strong></td>
						</tr>
						<tr>
							<td><strong>Village/Street Name</strong></td>
							<td><?php echo $doc_detail->idm_d_villege; ?></td>
							<td><strong>GP Name/Word No.</strong></td>
							<td><?php echo $doc_detail->idm_d_gp; ?></td>
						</tr>
						<tr>
							<td><strong>Block/Municipality</strong></td>
							<td><?php echo $doc_detail->idm_d_block; ?></td>
							<td><strong>District</strong></td>
							<td><?php echo $doc_detail->d_dist_name; ?></td>
						</tr>
						<tr>
							<td><strong>No. of people moving</strong></td>
							<td><?php echo $doc_detail->idm_people; ?></td>
							<td><strong>Date of Travel</strong></td>
							<td><?php echo date('d/m/Y',strtotime($doc_detail->idm_traveldate)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Identity proof of the applicant and others( ID card issued by Govt./Voter ID/AADHAR/Passport/Driving License etc)<br/>** This identity card is to be carried during the journey</strong></td>
							<td colspan="2"><a target="_blank" title="File" href="<?php echo base_url().'upload_file/idcard/'.$doc_detail->idm_identity_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<tr>
							<td><strong>Identity card no. of the Applicant</strong></td>
							<td><?php echo $doc_detail->idm_id_cardno; ?></td>
							<td><strong>Identity card Type of the Applicant</strong></td>
							<td><?php echo $doc_detail->idm_id_cardtype; ?></td>
						</tr>
						<tr>
							<td><strong>Vehicle No.</strong></td>
							<td><?php echo $doc_detail->idm_vehicle_no; ?></td>
							<td><strong>Vehicle Type</strong></td>
							<td><?php echo $doc_detail->idm_vehicle_type; ?></td>
						</tr>
						<tr>
							<td><strong>Reason for movement</strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_reason; ?></td>
						</tr>
						
						<tr>
							<td colspan="2"><strong>Medical/Emergency supporting documents</strong></td>
							<td colspan="2"><a target="_blank" title="File" href="<?php echo base_url().'upload_file/medical/'.$doc_detail->idm_medical_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<tr>
							<td><strong>Declaration </strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_declaration; ?></td>
						</tr>
						<?php if($doc_detail->idm_status == 4){ ?>
						<tr>
							<td><strong>Status : <span style="color:red;">Rejected</span></strong></td>
							<td colspan="3">Reason - <?php echo $doc_detail->idm_admin_msg; ?></td>
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