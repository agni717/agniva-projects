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
            <li class="active">Modify Guideline-Instruction</li>
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
                  <h3 class="box-title">Modify Guideline-Instruction</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
                 <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Type of Record<font style="color: red;">*</font></label>
				    <div class="col-sm-6">
						<label class="radio-inline"><input class="form-check-input" type="radio" name="rec_type" id="rec_type_1" value="1" <?php if($gi_detail->gi_type == 1){echo 'checked="checked"';} ?> autocomplete="off">Guideline</label>
						<label class="radio-inline"><input class="form-check-input" type="radio" name="rec_type" id="rec_type_2" value="2" <?php if($gi_detail->gi_type == 2){echo 'checked="checked"';} ?> autocomplete="off">Instruction</label>
						<br/><small class="text-error rec_type"><?php echo form_error('rec_type'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Record Title<font style="color: red;">*</font></label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="rec_title" id="rec_title" placeholder="Enter Record Title" value="<?php echo $gi_detail->gi_title; ?>" autocomplete="off" />
				      <small class="text-error rec_title"><?php echo form_error('rec_title'); ?></small>
				    </div>
				 </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Record Details</label>
				    <div class="col-sm-8">
				      <textarea class="form-control" name="rec_details" id="rec_details" placeholder="Enter Record Details"><?php echo $gi_detail->gi_details; ?></textarea>
				      <small class="text-error rec_details"><?php echo form_error('rec_details'); ?></small>
				    </div>
				  </div>
                  <div class="form-group">
					<label class="col-sm-6 control-label text-right">Current Document : <a href="<?php echo base_url().'upload_file/guide_doc/'.$gi_detail->gi_source; ?>" target="_blank"><?php echo $gi_detail->gi_source; ?></a></label>
					<label class="col-sm-2 control-label text-right">Upload New Document</label>
				    <div class="col-sm-3">
						<input type="file" class="form-control" id="userfile" name="userfile" placeholder="Upload Document"> 
						<small class="text-error userfile"><?php echo form_error('userfile'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Record Order</label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="rec_order" id="rec_order" placeholder="Enter Record Order" value="<?php echo $gi_detail->gi_order; ?>" autocomplete="off" />
				      <small>(Leave Blank or Enter 0 for 1st position)</small>
				      <br/><small class="text-error rec_order"><?php echo form_error('rec_order'); ?></small>
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
                      &nbsp;<a href="<?= site_url('admincontrol/guideline/guide_instruction_list') ?>" class="btn btn-danger">Cancel</a>
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
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG|\.doc|\.docx|\.ppt|\.pptx|\.mp4|\.MP4)$/i;
		
    	var rec_type = $("input[name='rec_type']:checked").val();
    	var rec_order = $('#rec_order').val();
    	var rec_title = $('#rec_title').val();
    	var rec_details = $('#rec_details').val();
		
		//var u_type = $('#u_type option:selected').val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(rec_type == "" || rec_type == undefined){
			e_error = 1;
			$('.rec_type').html('Type need to Select.');
		}else{
			if(!rec_type.match(onlynumerics)){
				e_error = 1;
				$('.rec_type').html('Type Value not proper Format.');
			}else{
				$('.rec_type').html('');
			}
		}
		
		if(rec_title == ""){
			e_error = 1;
			$('.rec_title').html('Title is Required.');
		}else{
			if(!rec_title.match(alphanumerics_no)){
				e_error = 1;
				$('.rec_title').html('Title not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.rec_title').html('');
			}	
		}
		if(rec_details != ""){
			rec_details = rec_details.replace(/(\r\n|\n|\r)/gm, " ");
			if(!rec_details.match(alphanumerics_no)){
				e_error = 1;
				$('.rec_details').html('Details not use special carecters [without _ / : ( @ . & ) , -], Check again.');
			}else{
				$('.rec_details').html('');
			}	
		}else{
			$('.rec_details').html('');
		}
		
		if(document.getElementById("userfile").files.length != 0){
			var fileInput = document.getElementById('userfile'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userfile').html('Document type Invalid.(Use PDF/Images/Doc/MP4)');
			}else{
				$('.userfile').html('');
			}
		}
		
		if(rec_order != ""){
			if(!rec_order.match(onlynumerics)){
				e_error = 1;
				$('.rec_order').html('Order only use Numeric Value.');
			}else{
				$('.rec_order').html('');
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