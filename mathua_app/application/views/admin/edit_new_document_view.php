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
            Edit Document
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Document</li>
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
				    <label class="col-sm-3 control-label text-right">Select Section<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="section_type" id="section_type">
				      	<option value="">---Select---</option>
				      	<?php foreach($section_list as $sections){ ?>
				      		<option <?php if($doc_detail->file_section == $sections->section_id){ echo 'selected=""'; }?> value="<?php echo $sections->section_id; ?>"><?php echo $sections->section_name; ?></option>
				      	<?php } ?>
				      </select>
				      <small class="text-error section_type"><?php echo form_error('section_type'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Voucher Date<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="v_date" id="v_date" placeholder="Select Voucher Date" value="<?php echo $doc_detail->file_date; ?>" />
				      <small class="text-error v_date"><?php echo form_error('v_date'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Voucher Number<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="v_number" id="v_number" placeholder="Enter Voucher Number" value="<?php echo $doc_detail->file_voucher_no; ?>" />
				      <small class="text-error v_number"><?php echo form_error('v_number'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Voucher Year<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="text" class="form-control" name="v_year" id="v_year" placeholder="Enter Voucher Year" value="<?php echo $doc_detail->file_year; ?>" />
				      <small class="text-error v_year"><?php echo form_error('v_year'); ?></small>
				    </div>
				  </div>
				  <!--<div class="form-group">
				    <label class="col-sm-3 control-label text-right">HTML File Upload<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input class="form-control" type="file" name="html_files" id="html_files" />
				      <small class="text-error html_files"><?php echo form_error('html_files'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">PDF File Upload<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input class="form-control" type="file" name="pdf_files" id="pdf_files" />
				      <small class="text-error pdf_files"><?php echo form_error('pdf_files'); ?></small>
				    </div>
				  </div>-->
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Party Name<font style="color: red;">*</font></label>
				    <div class="col-sm-9 bootstrap-timepicker">
				      <input type="text" class="form-control" name="party_name" id="party_name" placeholder="Enter Party Name" value="<?php echo $doc_detail->file_party_name; ?>" />
				      <small class="text-error party_name"><?php echo form_error('party_name'); ?></small>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">File Details</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" name="f_details" id="f_details" placeholder="Enter File Details"><?php echo $doc_detail->file_title; ?></textarea>
				      <small class="text-error f_details"><?php echo form_error('f_details'); ?></small>
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
				      <input type="button" onclick="get_document_submit();" class="btn btn-danger" name="submit" value="Submit" />
                      &nbsp;<a href="<?= site_url('admincontrol/panel/document_list') ?>" class="btn btn-warning">Cancel</a>
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
      $('#v_date').datepicker({dateFormat:'yy-mm-dd',changeMonth: true,
      changeYear: true});
      /*.change(dateChanged)
      .on('changeDate', dateChanged);*/
      
  });

function get_document_submit(){
	$('.div_roller_total').fadeIn();
	var delay = 8000;
	var e_error = 0;
	var error_message = 'There have some errors plese check above, Try again.';
	var docid = '<?php echo $doc_detail->file_id; ?>';
	var section_type = $("#section_type").val();
	var voucher_date = $("#v_date").val();
	var voucher_no = $("#v_number").val();
	var voucher_year = $("#v_year").val();
	var party_name = $("#party_name").val();
	var file_details = $("#f_details").val();
	//var html_file = $('#html_files')[0].files;
	//var pdf_file = $('#pdf_files')[0].files;
	//alert(html_file[0].name);
	//alert(pdf_file[0].name);     form_data.append("files[]", files[count]);
	var form_data = new FormData();
	if(section_type == ""){
		e_error = 1;
		$('.section_type').html('Section Type is Required');
	}else{
		$('.section_type').html('');
	}
	if(voucher_date == ""){
		e_error = 1;
		$('.v_date').html('Voucher Date is Required');
	}else{
		$('.v_date').html('');
	}
	if(voucher_no == ""){
		e_error = 1;
		$('.v_number').html('Voucher Number is Required');
	}else{
		$('.v_number').html('');
	}
	if(voucher_year == ""){
		e_error = 1;
		$('.v_year').html('Voucher Year is Required');
	}else{
		$('.v_year').html('');
	}
	if(party_name == ""){
		e_error = 1;
		$('.party_name').html('Party Name is Required');
	}else{
		$('.party_name').html('');
	}
	/*if(html_file[0] != undefined){
		if(html_file[0].name == ""){
			e_error = 1;
			$('.html_files').html('HTML File is Required');
		}else{
			var h_files_name = html_file[0].name;
			var html_file_ext = h_files_name.split('.').pop().toLowerCase();
			if(jQuery.inArray(html_file_ext, ['html','HTML']) == -1)
			{
				e_error = 1;
				$('.html_files').html('Invalid File Type');
			}else{
				$('.html_files').html('');
			}
		}
	}else{
		e_error = 1;
		$('.html_files').html('HTML File is Required');
	}
	
	if(pdf_file[0] != undefined){
		if(pdf_file[0].name == ""){
			e_error = 1;
			$('.pdf_files').html('PDF File is Required');
		}else{
			var p_files_name = pdf_file[0].name;
			var pdf_file_ext = p_files_name.split('.').pop().toLowerCase();
			if(jQuery.inArray(pdf_file_ext, ['pdf','PDF']) == -1)
			{
				e_error = 1;
				$('.pdf_files').html('Invalid File Type');
			}else{
				$('.pdf_files').html('');
			}
		}
	}else{
		e_error = 1;
		$('.pdf_files').html('PDF File is Required');
	}*/
	
	if(e_error == 1){
		$('.div_roller_total').fadeOut();
		$('.get_error_total').html(error_message);
		$(".text-error").fadeIn();
		$(".get_error_total").fadeIn();
		setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		
	}else{
		
		form_data.append('docid',docid);
		form_data.append('section_type',section_type);
		form_data.append('voucher_date',voucher_date);
		form_data.append('voucher_no',voucher_no);
		form_data.append('voucher_year',voucher_year);
		form_data.append('party_name',party_name);
		form_data.append('file_details',file_details);
		//form_data.append('html_file',html_file[0]);
		//form_data.append('pdf_file',pdf_file[0]);
		$.ajax({
			method:'POST',
			url:'<?php echo base_url()."admincontrol/panel/edit_new_document"; ?>',
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
					$('#section_type, #v_date, #v_number, #v_year, #party_name, #f_details').val('');
					$('#section_type, #v_date, #v_number, #v_year, #party_name, #f_details').html('');
					setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
					setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/panel/document_list')?>/"); }, 3000);
					
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