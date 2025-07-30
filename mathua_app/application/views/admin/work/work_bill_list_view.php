<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />


        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Project Bill Detailed List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Project Bill Detailed List</li>
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
					<div class="row">
					<div class="col-sm-12" style="margin-bottom:10px;font-size:20px;">
					Financial Year - <strong><?php echo $work_detail->mw_year; ?></strong>, Work Name - <strong><?php echo $work_detail->mw_name; ?></strong>
					<hr style="border-color:#ccc;" />
					</div>
					</div>
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab">
	                  <thead style="font-weight: bold;">
	                  		<!-- <td>Sl No.</td> -->
							<td>Bill Number</td>  
							<td>Is it Final</td>
	                  		<td>Date of submission</td>
	                  		<td>Amount Released</td>
	                  		<td>Released Date</td>
	                  		<td>Date of claim of EMD</td>
	                  		<td>Date of release of EMD</td>
	                  		<td>Any revised Estimate</td>
	                  		<td>Additional Amount</td>
	                  		<?php //if($this->session->userdata['utype'] == 8 || $this->session->userdata['utype'] == 9){ ?>
	                  		<!-- <td>Action</td> -->
							<?php //} ?>
	                  </thead>
                  	<tbody>
                  		<?php foreach($work_bill_list as $keys=>$works)
                  		{ ?>
                  		<tr>
							<!-- <td><?php //echo $keys+1; ?></td> -->
							<td><?php echo $works->wb_ra_no; ?></td>
							<td><?php if($works->wb_bill_final == "Yes"){echo "Final Bill";}else{echo "RA Bill";} ?></td>
                  			<td><?php echo date('d-m-Y',strtotime($works->wb_submission)); ?></td>
                  			<td><?php echo $works->wb_amount; ?></td>
                  			<td><?php echo date('d-m-Y',strtotime($works->wb_release)); ?></td>
                  			<td><?php if(!empty($works->wb_claim_emd)){echo date('d-m-Y',strtotime($works->wb_claim_emd));} ?></td>
                  			<td><?php if(!empty($works->wb_claim_emd)){echo date('d-m-Y',strtotime($works->wb_release_emd));} ?></td>
                  			<td><?php echo $works->wb_revised_estimate; ?></td>
                  			<td><?php echo $works->wb_additional_amt; ?></td>
                  			<?php //if($this->session->userdata['utype'] == 8 || $this->session->userdata['utype'] == 9){ ?>
                  			<!-- <td>
								<a href="<?php //echo base_url().'admincontrol/panel/work_progress_photographs/'.$works->wb_id; ?>" title="Edit Record" class="btn btn-xs btn-primary">Photographs</a>
								<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/panel/delete_work/'.$works->wb_id; ?>" title="Delete Record"><i class="fa fa-trash-o text-warning"></i></a>
                  			</td> -->
							<?php //} ?>
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
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	      $("#datatable_tab").dataTable();
      });
    </script>