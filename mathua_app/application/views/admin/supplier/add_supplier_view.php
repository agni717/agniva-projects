<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body input {max-width: 500px;}
.box-body textarea { resize: none; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add New Supplier</li>
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
                  <h3 class="box-title">Add New Supplier</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
                 <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Supplier Name<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_name" id="sp_name" placeholder="Enter Full Name" value="<?php echo set_value('sp_name'); ?>" autocomplete="off" />
				      <small class="text-error sp_name"><?php echo form_error('sp_name'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Company Name</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_com_name" id="sp_com_name" placeholder="Enter Company Name" value="<?php echo set_value('sp_com_name'); ?>" autocomplete="off" />
				      <small class="text-error sp_com_name"><?php echo form_error('sp_com_name'); ?></small>
				    </div>
				 </div>
                  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Supplier Mobile<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_mobile" id="sp_mobile" placeholder="Enter Mobile No." value="<?php echo set_value('sp_mobile'); ?>" autocomplete="off" />
				      <small class="text-error sp_mobile"><?php echo form_error('sp_mobile'); ?></small>
				    </div>
					<label class="col-sm-2 control-label text-right">Supplier Email</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_email" id="sp_email" placeholder="Enter Email-ID" value="<?php echo set_value('sp_email'); ?>" autocomplete="off" />
				      <small class="text-error sp_email"><?php echo form_error('sp_email'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Address<font style="color: red;">*</font></label>
				    <div class="col-sm-8">
				      <textarea class="form-control" name="sp_address" id="sp_address" placeholder="Enter Full Address"><?php echo set_value('sp_address'); ?></textarea>
				      <small class="text-error sp_address"><?php echo form_error('sp_address'); ?></small>
				    </div>
				  </div>
                  <div class="form-group">
				  	<label class="col-sm-3 control-label text-right">Bank Name<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_bank" id="sp_bank" placeholder="Enter Bank Name" value="<?php echo set_value('sp_bank'); ?>" autocomplete="off" />
				      <small class="text-error sp_bank"><?php echo form_error('sp_bank'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Account No.<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_ac_no" id="sp_ac_no" placeholder="Enter Account Number" value="<?php echo set_value('sp_ac_no'); ?>" autocomplete="off" />
				      <small class="text-error sp_ac_no"><?php echo form_error('sp_ac_no'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				  	<label class="col-sm-3 control-label text-right">IFSC Code<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="sp_ifsc" id="sp_ifsc" placeholder="Enter Branch IFSC Code" value="<?php echo set_value('sp_ifsc'); ?>" autocomplete="off" />
				      <small class="text-error sp_ifsc"><?php echo form_error('sp_ifsc'); ?></small>
				    </div>
				  </div>
                  
				  
				  <!--<div class="form-group">
				    <label class="col-sm-3 control-label text-right">City</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="u_city" id="u_city" placeholder="Enter City" autocomplete="off" />
				      <small class="text-error u_city"><?php //echo form_error('u_city'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Pincode</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="u_pincode" id="u_pincode" placeholder="Enter Pincode" autocomplete="off" />
				      <small class="text-error u_pincode"><?php //echo form_error('u_pincode'); ?></small>
				    </div>
				  </div>-->
				  	<div class="form-group">
						<div  class="col-sm-12 text-center">
							<div align="center">
								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
							</div>
						</div>
					</div>
                  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				      <button type="button" onclick="gotoclclickbutton();" class="btn btn-primary">Submit</button>
                      &nbsp;<a href="<?= site_url('admincontrol/suppliers/supplier_list') ?>" class="btn btn-danger">Cancel</a>
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
	      $('.alert-error, .text-error').delay(8000).fadeOut();
	});
	
	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	//var u_type = $('#u_type option:selected').val();
    	var sp_name = $('#sp_name').val();
    	var sp_com_name = $('#sp_com_name').val();
    	var sp_mobile = $('#sp_mobile').val();
    	var sp_email = $('#sp_email').val();
    	var sp_address = $('#sp_address').val();
		var sp_bank = $('#sp_bank').val();
		var sp_ac_no = $('#sp_ac_no').val();
		var sp_ifsc = $('#sp_ifsc').val();
		
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(sp_name == ""){
			e_error = 1;
			$('.sp_name').html('Full Name is Required.');
		}else{
			if(!sp_name.match(alphanumerics_no)){
				e_error = 1;
				$('.sp_name').html('Full Name not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.sp_name').html('');
			}	
		}
		if(sp_com_name != ""){
			if(!sp_com_name.match(alphanumerics_no)){
				e_error = 1;
				$('.sp_com_name').html('Company Name not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.sp_com_name').html('');
			}	
		}else{
			$('.sp_com_name').html('');
		}
		if(sp_mobile == ""){
			e_error = 1;
			$('.sp_mobile').html('Mobile No. is Required.');
		}else{
			if(!sp_mobile.match(onlynumerics)){
				e_error = 1;
				$('.sp_mobile').html('Mobile No. needs only 10 digit.');
			}else if(sp_mobile.length != 10){
				e_error = 1;
				$('.sp_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.sp_mobile').html('');
			}
		}
		if(sp_email != ""){
			if(!sp_email.match(emailpattern)){
				e_error = 1;
				$('.sp_email').html('Email ID not valid Format, Check again.');
			}else{
				$('.sp_email').html('');
			}	
		}else{
			$('.sp_email').html('');
		}
		if(sp_address == ""){
			e_error = 1;
			$('.sp_address').html('Address is Required.');
		}else{
			sp_address = sp_address.replace(/(\r\n|\n|\r)/gm, " ");
			if(!sp_address.match(alphanumerics_no)){
				e_error = 1;
				$('.sp_address').html('Address not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.sp_address').html('');
			}	
		}
		if(sp_bank == ""){
			e_error = 1;
			$('.sp_bank').html('Bank Name is Required.');
		}else{
			if(!sp_bank.match(alphanumerics_no)){
				e_error = 1;
				$('.sp_bank').html('Bank Name not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.sp_bank').html('');
			}	
		}
		if(sp_ac_no == ""){
			e_error = 1;
			$('.sp_ac_no').html('Account Number is Required.');
		}else{
			if(!sp_ac_no.match(onlynumerics)){
				e_error = 1;
				$('.sp_ac_no').html('Account Number only use Numeric Values, Check again.');
			}else{
				$('.sp_ac_no').html('');
			}	
		}
		if(sp_ifsc == ""){
			e_error = 1;
			$('.sp_ifsc').html('IFSC Code is Required.');
		}else{
			if(!sp_ifsc.match(alphanumerics)){
				e_error = 1;
				$('.sp_ifsc').html('IFSC Code only use Numeric and Alphabet Values, Check again.');
			}else{
				$('.sp_ifsc').html('');
			}	
		}
		
		/*if(document.getElementById("userworkorder").files.length == 0){
			e_error = 1;
			$('.userworkorder').html('Work-Order File is Required.');
		}else{
			var fileInput = document.getElementById('userworkorder'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworkorder').html('Work-Order File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworkorder').html('');
			}
			
		}
		if(document.getElementById("userworker").files.length == 0){
			e_error = 1;
			$('.userworker').html('Worker Details File is Required.');
		}else{
			var fileInput = document.getElementById('userworker'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworker').html('Worker Details File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworker').html('');
			}
		}*/
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(newhash);
			//alert(rehash);
			$("#myForm").submit();
		}

  	}
</script>