<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input {max-width: 500px;}
.box-body textarea { resize: vertical; }
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
            <li class="active">Visit for Work Progress</li>
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
                  <h3 class="box-title">Visit for Work Progress</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
				 <div class="form-group">
				 <div class="col-sm-12 text-center" style="font-size:20px;margin-bottom:10px;">Financial Year - <strong><?php echo $work_detail->mw_year; ?></strong>, Work Name - <strong><?php echo $work_detail->mw_name; ?></strong><br/>Current Work Progress - <strong><?php echo $work_detail->mw_progress_stat." %"; ?></strong><br/>Visit No. - <strong><?php echo $visit_count+1; ?></strong></div>
				 </div>
                 <div class="form-group">
				    <label class="col-sm-3 control-label">Visit Date<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="hidden" name="v_count" id="v_count" value="<?php echo $visit_count+1; ?>" />
					  <input type="text" class="form-control" name="v_date" id="v_date" autocomplete="off" placeholder="DD-MM-YYYY" />
				      <small class="text-error v_date"><?php echo form_error('v_date'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				    <label class="col-sm-3 control-label">Upload Photographs of Project<font style="color: red;">*</font></label>
				    <div class="col-sm-6">
					  <input type="file" class="form-control" name="proj_pics[]" id="proj_pics" autocomplete="off" multiple />
				      <small class="text-error proj_pics"><?php echo form_error('proj_pics'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				    <label class="col-sm-3 control-label">Physical Progress <font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="text" class="form-control" name="p_progress" id="p_progress" autocomplete="off" placeholder="Enter Progress Number" onkeyup="check_progress();" />
				      <small class="text-error p_progress"><?php echo form_error('p_progress'); ?></small>
				    </div>
					<div class="complete_tab" style="display:none;">
					<label class="col-sm-2 control-label">Completion Date<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="text" class="form-control" name="c_date" id="c_date" autocomplete="off" placeholder="DD-MM-YYYY" />
				      <small class="text-error c_date"><?php echo form_error('c_date'); ?></small>
				    </div>
					</div>
				 </div>
				 <div class="form-group">
				    <label class="col-sm-3 control-label">Description of Work Progress</label>
				    <div class="col-sm-6">
						<textarea class="form-control" name="w_descrip" id="w_descrip"></textarea>
						<small class="text-error w_descrip"><?php echo form_error('w_descrip'); ?></small>
				    </div>
				 </div>
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
				    <div class="col-sm-12 text-center">
				      <button type="button" onclick="gotoclclickbutton();" class="btn btn-primary">Submit</button>
                      &nbsp;<a href="<?= site_url('admincontrol/panel/allocaded_work_progress_list') ?>" class="btn btn-danger">Cancel</a>
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
		$( "#v_date, #c_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
	    $('.alert-error, .text-error').delay(6000).fadeOut();

	});

	function check_progress(){
		var p_progress = $("#p_progress").val();
		if(p_progress != ""){
			var prog = parseFloat(p_progress);
			if(prog == 100.00){
				$('#c_date').val('');
				$('.complete_tab').show(500);
			}else{
				$('#c_date').val('');
				$('.complete_tab').fadeOut(500);
			}
		}else{
			$('#c_date').val('');
			$('.complete_tab').fadeOut(500);
		}
	}

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Z0-9]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_hypen = /^[0-9\-]+$/;
		var onlynumerics_comma = /^[0-9.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
    	var v_count = $('#v_count').val();
    	var v_date = $('#v_date').val();
		var p_progress = $("#p_progress").val();
    	var c_date = $('#c_date').val();
    	var w_descrip = $('#w_descrip').val();
		var current_prog = '<?php echo $work_detail->mw_progress_stat; ?>';
    	
		//var w_sae = $("#w_sae option:selected").val();
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(v_date == ""){
			e_error = 1;
			$('.v_date').html('Visiting Date is Required.');
		}else{
			if(isDatecheck(v_date) == false){
				e_error = 1;
				$('.v_date').html('Visiting Date Format check properly and Try Again.');
			}else{
				$('.v_date').html('');
			}	
		}
		if(v_count == ""){
			e_error = 1;
			error_message = error_message + '<br/>ID not found properly, Refresh the page and Try Again.';
		}
		if(p_progress == ""){
			e_error = 1;
			$('.p_progress').html('Physical Progress is Required.');
		}else{
			if(!p_progress.match(onlynumerics_comma)){
				e_error = 1;
				$('.p_progress').html('Physical Progress only numeric value and Try Again.');
			}else if(parseFloat(p_progress) > 100.00 || parseFloat(p_progress) < parseFloat(current_prog)){
				e_error = 1;
				$('.p_progress').html('Physical Progress Dont Cross the 100% and Never lower than Current Progress.');
			}else{
				$('.p_progress').html('');
				if(parseFloat(p_progress) == 100.00){
					if(c_date == ""){
						e_error = 1;
						$('.c_date').html('Completion Date is Required.');
					}else{
						if(isDatecheck(c_date) == false){
							e_error = 1;
							$('.c_date').html('Completion Date Format check properly and Try Again.');
						}else{
							$('.c_date').html('');
						}	
					}
				}else{
					$('.c_date').html('');
				}
			}	
		}

		if(w_descrip != ""){
			if(!w_descrip.match(alphanumerics_no)){
				e_error = 1;
				$('.w_descrip').html('Description of Work Progress not use special carecters [without _ / : ( . & ) , -], Check again.');
			}else{
				$('.w_descrip').html('');
			}	
		}
		
		if(document.getElementById("proj_pics").files.length == 0){
			e_error = 1;
			$('.proj_pics').html('Project Photographs is Required.');
		}else{
			var fileInput = document.getElementById('proj_pics'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.proj_pics').html('Project Photographs type Invalid.(Use JPEG/PNG/JPG)');
			}else{
				$('.proj_pics').html('');
			}
			
		}
		
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