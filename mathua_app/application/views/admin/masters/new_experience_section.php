<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link rel="stylesheet" href="<?php echo base_url() ?>dist/select_style/chosen.css">
<script type="text/javascript">
	$(function(){
	      $('.alert-error, .text-error').delay(6000).fadeOut();
	  });
</script>

<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input,select {max-width: 500px;}
.box-body textarea { resize: vertical; }
.box-body input[type="file"] { padding-bottom: 0px; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             <?php echo "Add New Experience Section"; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> <?php echo "Add New Experience Section"; ?></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12">
              <!-- Custom tabs (Charts with tabs)-->
			
			<?php if (isset($error)) { ?>
            <div class="alert alert-error">                
                <h4>Error!</h4>
                <?php echo $error; ?>
            </div>
        	<?php } ?>
          
			<?php if($this->session->flashdata('error')) { ?>
			<div id="alert_msg" class="alert alert-error"><?php echo $this->session->flashdata('error'); ?></div>
		    <?php $this->session->unset_userdata('error'); } ?>
					<?php if($this->session->flashdata('success')) { ?>
			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php $this->session->unset_userdata('success'); } ?>
			
              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal"'); ?>
                <div class="form-group" >
                  <label class="col-sm-3 control-label text-right">Name of Experience<font style="color: red;">*</font></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="e_name" name="e_name" placeholder="Enter Name of Experience" value="<?php echo set_value('e_name'); ?>" autocomplete="off" required />
                    <small class="text-error"><?php echo form_error('e_name'); ?></small>
                  </div>
                  <!--<label class="col-sm-2 control-label text-right">Experience Type<font style="color: red;">*</font></label>
                  <div class="col-sm-3">
                    <select class="form-control" id="e_type" name="e_type" autocomplete="off" required>
                      <option value="">---Select---</option>
                      <option value="Government" <?php //if(!empty(set_value('e_type'))){if(set_value('e_type') == "Government"){echo "selected";}} ?>>Government</option>
                      <option value="Private" <?php //if(!empty(set_value('e_type'))){if(set_value('e_type') == "Private"){echo "selected";}} ?>>Private</option>
                    </select>
                    <small class="text-error"><?php //echo form_error('e_type'); ?></small>
                  </div>-->
				        </div>  
                  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-3">
						<input type="submit" class="btn btn-primary" name="submit" value="Submit" width="60px;" />
						&nbsp;<a href="<?= site_url('admincontrol/masterdata/experience_section_list') ?>" class="btn btn-danger">Cancel</a>
				    </div>
				  </div>
				  
               <?php form_close(); ?>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                &nbsp;
                </div>
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 
              


<script src="<?php echo base_url() ?>dist/select_style/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>dist/select_style/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
<script>
  $( function() {
    //$( "#lv_start_date, #lv_end_date" ).datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
    //Timepicker
    /*$(".timepicker").timepicker({
          showInputs: false
        });*/
	});
   
  </script>

<?php $this->load->view('admin/component/footer') ?>