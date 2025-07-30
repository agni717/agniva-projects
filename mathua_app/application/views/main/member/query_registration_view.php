<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<style>
.alert-error, .text-error, .redclass,.alert-error h3, .alert-error h5  {
    	color: red !important;
	}
</style>        

        <!-- Presentation -->
<div class="presentation-container">
  	<div class="container">
    	<div class="row">
			<?php $this->load->view('main/member/left_menu')?>
			
	        <div class="col-sm-10">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title">Query Form</h1>
				<?php if($this->session->flashdata('success')) { ?>
    			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    		    <?php $this->session->unset_userdata('success'); }
    		    	elseif($this->session->flashdata('e_error')) { ?>                
    	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
    		    <?php $this->session->unset_userdata('e_error'); } ?>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/query_form_submission"; ?>" method="POST" enctype="multipart/form-data">
		  	
            <div class="form-group">
              <label class="col-md-3 control-label">Subject <font class="redclass">*</font></label>
              <div class="col-md-12">
                <input type="text" name="apli_title" id="apli_title" placeholder="Subject" class="form-control" autocomplete="off">
				<small class="text-error text-left apli_title"><?php echo form_error('apli_title'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-3 control-label">Mention in Details <font class="redclass">*</font></label>
              <div class="col-md-12">
                <textarea name="apli_details" id="apli_details" placeholder="Details Query" class="form-control" autocomplete="off"></textarea>
				<small class="text-error text-left apli_details"><?php echo form_error('apli_details'); ?></small>
              </div>
            </div>
           
			
			<div class="form-group">
              <label class="col-md-6 control-label">Attachment</label>
              <div class="col-md-8">
                <input type="file" name="apli_attach" id="apli_attach" class="form-control">
				<small class="text-error text-left apli_attach"><?php echo form_error('apli_attach'); ?></small>
              </div>
            </div>
			<!-- <div class="form-group">
              <label class="col-md-4 control-label">Upload Details of Workers (File name must contain Agency Name) <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="userworker" id="userworker" class="form-control">
				<small class="text-error text-left userworker"><?php //echo form_error('userworker'); ?></small>
              </div>
            </div> -->
			
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
              <div class="col-md-12 text-center">
			  <button type="button" onclick="gotoclclickbutton();" class="btn btn-lg btn-primary">Submit</button>
			  <a href="<?php echo base_url()."member/query_list"; ?>" class="btn btn-lg btn-danger">cancel</a>
              </div>
            </div>
          </form>
        </div>
		</div>
	            
	            
	            
	            
			</div>
		</div>
	</div>
</div>

        

<?php $this->load->view('main/component/footer'); ?>
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>

<script type="text/javascript">
    $(function(){
		//$( "#ap_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		/*$('input:radio[name="mig_labour"]').change(function() {
			goto_mig_labour_check();
		});
		$('input:radio[name="mi_worker"]').change(function() {
			goto_out_collect_check();
		});
		$('input:radio[name="ap_swap"]').change(function() {
			goto_swap_collect_check();
		});*/
	});

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG|\.txt|\.doc|\.docx|\.xls|\.xlsx|\.ppt|\.pptx|\.mp4|\.MP4)$/i;
		
    	var apli_title = $('#apli_title').val();
    	var apli_details = $('#apli_details').val();
		
		//var ap_quaran = $("#ap_quaran option:selected").val();
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();

		
		if(apli_title == ""){
			e_error = 1;
			$('.apli_title').html('Subject is Required.');
		}else{
			if(!apli_title.match(alphanumerics_no)){
				e_error = 1;
				$('.apli_title').html('Subject not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.apli_title').html('');
			}	
		}
		
		if(apli_details == ""){
			e_error = 1;
			$('.apli_details').html('Details Query is Required.');
		}else{
			apli_details = apli_details.replace(/(\r\n|\n|\r)/gm, " ");
			if(!apli_details.match(alphanumerics_no)){
				e_error = 1;
				$('.apli_details').html('Details Query not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.apli_details').html('');
			}	
		}
		
		if(document.getElementById("apli_attach").files.length != 0){
			var fileInput = document.getElementById('apli_attach'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.apli_attach').html('Attachment File type Invalid.');
			}else{
				$('.apli_attach').html('');
			}
			
		}
		/*if(document.getElementById("userworker").files.length == 0){
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

	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		//Checks for dd/mm/yyyy format.
		dtMonth = dtArray[3];
		dtDay= dtArray[1];
		dtYear = dtArray[5];        
		
		if (dtMonth < 1 || dtMonth > 12) 
			return false;
		else if (dtDay < 1 || dtDay> 31) 
			return false;
		else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
			return false;
		else if (dtMonth == 2) 
		{
			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if (dtDay> 29 || (dtDay ==29 && !isleap)) 
					return false;
		}
		return true;
  }

</script>