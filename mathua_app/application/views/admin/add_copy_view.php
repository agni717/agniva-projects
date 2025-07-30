<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('.alert-error').delay(6000).fadeOut();
	  });
</script>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input,select {max-width: 500px;}
.box-body textarea { resize: vertical; }
.box-body input[type="file"] { padding-bottom: 40px; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add New Terms & Conditions
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">New Terms & Conditions</li>
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
			
			<?php if (isset($error)) { ?>
            <div class="alert alert-error">                
                <h4>Error!</h4>
                <?php echo $error; ?>
            </div>
        	<?php } ?>
			
              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open('','id="myForm" class="form-horizontal"'); ?>
                  
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Terms & Conditions Title</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" name="cf_details" id="cf_details" placeholder="Enter Terms & Conditions Details"></textarea>
				      <small class="text-error cf_details"><?php echo form_error('cf_details'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
		              <div class="col-sm-12 text-center">
			              <div align="center">
		             		    <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
		                        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
		             		<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
		             	</div>
		              </div>
		            </div>
                  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				      <input type="button" onclick="get_copy_submit();" class="btn btn-danger" value="Submit" />
                      &nbsp;<a href="<?= site_url('admincontrol/panel/cpy_fwd_list') ?>" class="btn btn-warning">Cancel</a>
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
      

<?php $this->load->view('admin/component/footer') ?>

<script type="text/javascript">
$(function(){
      $('#alert_msg, .text-error').delay(6000).fadeOut();
      /*$('#from_date, #to_date').datepicker({
	  		format: 'dd/mm/yyyy',
	  		autoclose: true
      })
      .change(dateChanged)
      .on('changeDate', dateChanged);*/
      
  });

function get_copy_submit(){
  var delay = 6000;
	var cf_details = $('#cf_details').val();
	if(cf_details != ""){
		$('.div_roller_total').fadeIn();
		$('#myForm').submit();
	}else{
		$('.cf_details').html("Enter some Content.");
    $(".text-error").fadeIn();
    setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
	}
}

</script>