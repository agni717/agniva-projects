<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />


        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Project Progress Photograph
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Project Progress Photograph</li>
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
					<br/>Visit Date : <strong><?php echo date('d-m-Y',strtotime($prog_detail->wp_visit_date)); ?></strong>, Visit Number - <strong><?php echo $prog_detail->wp_visitno; ?></strong>
					<hr style="border-color:#ccc;" />
					</div>
                  	<?php foreach($photo_list as $keys=>$photos)
                  	{ ?>
                  	<div class="col-sm-3"><a href="<?php echo base_url().'upload_file/proj_photo/'.$photos->wpp_pic_source; ?>" target="_blank"><img src="<?php echo base_url().'upload_file/proj_photo/'.$photos->wpp_pic_source; ?>" style="max-width:200px;width:100%;" /></a></div>
                  	<?php } ?>
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