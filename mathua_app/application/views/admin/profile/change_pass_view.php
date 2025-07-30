<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('.alert-error, .text-error').delay(6000).fadeOut();
	});
</script>
<style>
.box-body input[type="password"] { width: 100%;max-width: 500px;}
</style>  
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Change Password
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">change password</li>
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
			
              <!-- TO DO List -->
              <div class="box box-warning">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Change Your Password</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal"'); ?>
                  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Current Password<font style="color: red;">*</font></label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" name="c_pass" id="c_pass" placeholder="Enter Current Password" required>
				      <small class="text-error"><?php echo form_error('c_pass'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">New Password<font style="color: red;">*</font></label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" name="n_pass" id="n_pass" placeholder="Enter New Password" required> <small>only use this special charecters(!,@,#,$,%,*)</small>
				      <small class="text-error"><?php echo form_error('n_pass'); ?></small>
				    </div>
				  </div>
                  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">New Password Again<font style="color: red;">*</font></label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" name="n_repass" id="n_repass" placeholder="Enter New Password Again" required>
				      <small class="text-error"><?php echo form_error('n_repass'); ?></small>
				    </div>
				  </div>
                  
                  <br/><br/>
                  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				      <input type="submit" class="btn btn-success" name="submit" value="Submit" />
                      &nbsp;<a href="<?= site_url('admincontrol/dashboard/profile') ?>" class="btn btn-danger">Cancel</a>
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