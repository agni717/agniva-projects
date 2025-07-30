<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      //$('.alert-error, .text-error').delay(6000).fadeOut();
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
            Edit Frontend User
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Frontend User</li>
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
              <div class="box box-primary">
                <div class="box-header">
                  &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal"'); ?>
                  
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Full name<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Enter Full Name" value="<?php echo $fuser_detail->fuser_name; ?>">
				      <small class="text-error full_name"><?php echo form_error('full_name'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Designation</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="f_designation" id="f_designation" placeholder="Enter Designation" value="<?php echo $fuser_detail->fuser_desig; ?>">
				      <small class="text-error f_designation"><?php echo form_error('f_designation'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Username<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="f_username" id="f_username" placeholder="Enter Username" value="<?php echo $fuser_detail->fuser_username; ?>" disabled="">
				      <small class="text-error f_username"><?php echo form_error('f_username'); ?></small>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Other Details</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" name="f_details" id="f_details" placeholder="Enter Details"><?php echo $fuser_detail->fuser_details; ?></textarea>
				      <small class="text-error f_details"><?php echo form_error('f_details'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				  	<div class="col-sm-12"><strong>If you want to change password, then fillup below section -</strong></div><br/><br/>
				    <label class="col-sm-3 control-label text-right">Pasword<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="f_pass" id="f_pass" placeholder="Enter Password">
				      <small class="text-error f_pass"><?php echo form_error('f_pass'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Re-Password<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="f_re_pass" id="f_re_pass" placeholder="Enter Re-Password">
				      <small class="text-error f_re_pass"><?php echo form_error('f_re_pass'); ?></small>
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
				      <input type="button" onclick="frontenduser_update_submit();" class="btn btn-danger" name="submit" value="Submit" />
                      &nbsp;<a href="<?= site_url('admincontrol/panel/frontend_user_list') ?>" class="btn btn-warning">Cancel</a>
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
      $('#alert_msg, .text-error').delay(8000).fadeOut();
      /*$('#v_date').datepicker({dateFormat:'yy-mm-dd',changeMonth: true,
      changeYear: true});
      .change(dateChanged)
      .on('changeDate', dateChanged);*/
      
  });

function frontenduser_update_submit(){
	$('.div_roller_total').fadeIn();
	var delay = 8000;
	var e_error = 0;
	var error_message = 'There have some errors plese check above, Try again.';
	var fuser_id = '<?php echo $fuser_detail->fuser_id; ?>';
	var full_name = $("#full_name").val();
	var f_designation = $("#f_designation").val();
	var f_username = $("#f_username").val();
	var f_pass = $("#f_pass").val();
	var f_re_pass = $("#f_re_pass").val();
	var f_details = $("#f_details").val();
	//alert(html_file[0].name);
	//alert(pdf_file[0].name);     form_data.append("files[]", files[count]);
	var form_data = new FormData();
	if(fuser_id == ""){
		e_error = 1;
		error_message = error_message + "<br/>User ID not Found, Refresh the Page.";
	}
	if(full_name == ""){
		e_error = 1;
		$('.full_name').html('Full Name is Required');
	}else{
		$('.full_name').html('');
	}
	if(f_username == ""){
		e_error = 1;
		$('.f_username').html('Username is Required');
	}else{
		$('.f_username').html('');
	}
	
	if(f_pass == "" && f_re_pass != ""){
		e_error = 1;
		$('.f_pass').html('Password is Required');
	}else{
		$('.f_pass').html('');
	}
	if(f_pass != "" && f_re_pass == ""){
		e_error = 1;
		$('.f_re_pass').html('Re-Password is Required');
	}else{
		$('.f_re_pass').html('');
	}
	/*if(/^[a-zA-Z0-9]*$/.test(f_username) == false) {
		e_error = 1;
	    error_message = error_message + '<br/>Username contains Special characters OR Space, Remove it.';
	}*/
	
	if(f_pass != "" && f_re_pass != ""){
		if(f_pass != f_re_pass){
			e_error = 1;
			error_message = error_message + "<br/>Password and Re-Password not Match, check Again";
		}
	}
	
	if(e_error == 1){
		$('.div_roller_total').fadeOut();
		$('.get_error_total').html(error_message);
		$(".text-error").fadeIn();
		$(".get_error_total").fadeIn();
		setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		
	}else{
		
		form_data.append('fuser_id',fuser_id);
		form_data.append('full_name',full_name);
		form_data.append('f_username',f_username);
		form_data.append('f_pass',f_pass);
		form_data.append('f_re_pass',f_re_pass);
		form_data.append('f_designation',f_designation);
		form_data.append('f_details',f_details);
		$.ajax({
			method:'POST',
			url:'<?php echo base_url()."admincontrol/panel/update_frontuser_submit"; ?>',
			data:form_data,
			dataType:'JSON',
			contentType: false,
			processData: false,
			success:function(data){
				//alert(data.msg);
				if(data.msg == 1)
				{
					$('.div_roller_total').fadeOut();
					$('.get_success_total').html(data.e_msg);
					$(".get_success_total").fadeIn();
					$('#full_name, #f_username, #f_pass, #f_re_pass, #f_designation, #f_details').val('');
					$('#full_name, #f_username, #f_pass, #f_re_pass, #f_designation, #f_details').html('');
					setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
					setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/panel/frontend_user_list')?>/"); }, 3000);
					
				}else{
					$('.div_roller_total').fadeOut();
					//error_message = data.e_msg;
					$('.get_error_total').html(data.e_msg);
					$(".get_error_total").fadeIn();
					setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
				}
				
			}
		});
	
	
	
	
	}
	
}

</script>