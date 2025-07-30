<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />


        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Project Progress Detailed List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Project Progress Detailed List</li>
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
	                  		<td>Visit Date</td>
	                  		<td>Visit Number</td>
	                  		<td>Progress Status</td>
	                  		<td>Description of Work Progress</td>
	                  		<td>Completion Date</td>
	                  		<?php if($this->session->userdata['utype'] == 8 || $this->session->userdata['utype'] == 9){ ?>
	                  		<td>Action</td>
							<?php } ?>
	                  </thead>
                  	<tbody>
                  		<?php foreach($work_prog_list as $keys=>$works)
                  		{ ?>
                  		<tr>
                  			<!-- <td><?php //echo $keys+1; ?></td> -->
                  			<td><?php echo date('d-m-Y',strtotime($works->wp_visit_date)); ?></td>
                  			<td><?php echo $works->wp_visitno; ?></td>
                  			<td><?php echo $works->wp_progstatus." %"; ?></td>
                  			<td><?php echo $works->wp_comment; ?></td>
                  			<td><?php if(!empty($works->wp_completion)){ echo date('d-m-Y',strtotime($works->wp_visit_date)); } ?></td>
                  			<?php if($this->session->userdata['utype'] == 8 || $this->session->userdata['utype'] == 9){ ?>
                  			<td>
								<a href="<?php echo base_url().'admincontrol/panel/work_progress_photographs/'.$works->wp_id; ?>" title="Edit Record" class="btn btn-xs btn-primary">Photographs</a>
								<!-- <a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/panel/delete_work/'.$works->wp_id; ?>" title="Delete Record"><i class="fa fa-trash-o text-warning"></i></a> -->
                  			</td>
							<?php } ?>
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