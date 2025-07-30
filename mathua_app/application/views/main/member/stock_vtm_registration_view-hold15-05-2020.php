<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<style>
.alert-error, .text-error, .redclass {
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
				<h1 class="panel-title">Stock VTM Form</h1>
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
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/new_stock_vtm_form"; ?>" method="POST" enctype="multipart/form-data">
		  	<div class="form-group">
              <label class="col-md-2 control-label">Date <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_date" id="ap_date" placeholder="DD-MM-YYYY" class="form-control" value="<?php echo date('d-m-Y'); ?>" autocomplete="off">
				<small class="text-error text-left ap_date"><?php echo form_error('ap_date'); ?></small>
              </div>
			  <label class="col-md-2 control-label">Existing Stock <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ex_stock" id="ex_stock" placeholder="Existing Stock" value="<?php echo $xstock; ?>" class="form-control" onkeyup="chk_bal_calculation();" autocomplete="off">
				<small class="text-error text-left ex_stock"><?php echo form_error('ex_stock'); ?></small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Utilized VTM <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_utilize" id="ap_utilize" placeholder="Utilized VTM" class="form-control" onkeyup="chk_bal_calculation();" autocomplete="off">
				<small class="text-error text-left ap_utilize"><?php echo form_error('ap_utilize'); ?></small>
              </div>
              <label class="col-md-2 control-label">Received VTM <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_receive" id="ap_receive" placeholder="Received VTM" class="form-control"onkeyup="chk_bal_calculation();" autocomplete="off">
				<small class="text-error text-left ap_receive"><?php echo form_error('ap_receive'); ?></small>
              </div>
            </div>
			<div class="form-group">
			  <label class="col-md-2 control-label">Sub-Alloted VTM <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_alloted" id="ap_alloted" placeholder="Sub-Alloted VTM" class="form-control" onkeyup="chk_bal_calculation();" autocomplete="off" value="0">
				<small class="text-error text-left ap_alloted"><?php echo form_error('ap_alloted'); ?></small>
              </div>
			  <label class="col-md-2 control-label">Balance VTM <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_balance" id="ap_balance" value="<?php echo $xstock; ?>" class="form-control" readonly>
				<small class="text-error text-left ap_balance"><?php echo form_error('ap_balance'); ?></small>
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
              <div class="col-md-12 text-center">
			  <button type="button" onclick="gotoclclickbutton();" class="btn btn-lg btn-primary">Submit</button>
			  <a href="<?php echo base_url()."member/dashboard"; ?>" class="btn btn-lg btn-danger">cancel</a>
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
		$( "#ap_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		/*$('input:radio[name="mig_labour"]').change(function() {
			goto_mig_labour_check();
		});
		$('input:radio[name="s_collect"]').change(function() {
			goto_s_collect_check();
		});*/
	});

	function chk_bal_calculation(){
		var ex_stock = $('#ex_stock').val();
    	var ap_utilize = $('#ap_utilize').val();
		var ap_receive = $('#ap_receive').val();
		var ap_alloted = $('#ap_alloted').val();
		var ap_balance = $('#ap_balance').val();

		if(ex_stock != ""){
			ex_stock = parseInt(ex_stock);
		}else{
			ex_stock = 0;
		}
		if(ap_utilize != ""){
			ap_utilize = parseInt(ap_utilize);
		}else{
			ap_utilize = 0;
		}
		if(ap_receive != ""){
			ap_receive = parseInt(ap_receive);
		}else{
			ap_receive = 0;
		}
		if(ap_alloted != ""){
			ap_alloted = parseInt(ap_alloted);
		}else{
			ap_alloted = 0;
		}
		if(ap_balance != ""){
			ap_balance = parseInt(ap_balance);
		}else{
			ap_balance = 0;
		}
		var t_balance = (ex_stock + ap_receive) - (ap_utilize + ap_alloted);
		$('#ap_balance').val(t_balance);
		
	}

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
		
    	var ap_date = $('#ap_date').val();
    	var ex_stock = $('#ex_stock').val();
    	var ap_utilize = $('#ap_utilize').val();
		/*var mig_labour = $("input[name='mig_labour']:checked").val();
		var ap_state = $('#ap_state option:selected').val();
		var ap_city = $('#ap_city').val();*/
		var ap_receive = $('#ap_receive').val();
		var ap_alloted = $('#ap_alloted').val();
		var ap_balance = $('#ap_balance').val();
		/*var ap_pool = $("input[name='ap_pool']:checked").val();
		var ap_lab = $("#ap_lab option:selected").val();
		var ap_gp = $("#ap_gp option:selected").val();
		var s_collect = $("input[name='s_collect']:checked").val();
		var s_type = $("input[name='s_type']:checked").val();
		var ap_symptom = $("input[name='ap_symptom']:checked").val();
		var ap_quaran = $("input[name='ap_quaran']:checked").val();*/
		
		if(ap_date == ""){
			e_error = 1;
			$('.ap_date').html('Date is Required.');
		}else{
			if(isDatecheck(ap_date) == false){
				e_error = 1;
				$('.ap_date').html('Date Format check properly and Try Again.');
			}else{
				$('.ap_date').html('');
			}	
		}
		if(ex_stock == ""){
			e_error = 1;
			$('.ex_stock').html('Existing Stock is Required.');
		}else{
			if(!ex_stock.match(onlynumerics)){
				e_error = 1;
				$('.ex_stock').html('Existing Stock is only Numeric value, Check again.');
			}else{
				$('.ex_stock').html('');
			}	
		}
		if(ap_utilize == ""){
			e_error = 1;
			$('.ap_utilize').html('VTM Utilize is Required.');
		}else{
			if(!ap_utilize.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_utilize').html('VTM Utilize is only Numeric value, Check again.');
			}else{
				$('.ap_utilize').html('');
			}	
		}

		if(ap_receive == ""){
			e_error = 1;
			$('.ap_receive').html('VTM Receive is Required.');
		}else{
			if(!ap_receive.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_receive').html('VTM Receive is only Numeric value, Check again.');
			}else{
				$('.ap_receive').html('');
			}	
		}

		if(ap_alloted == ""){
			e_error = 1;
			$('.ap_alloted').html('VTM Sub-alloted is Required.');
		}else{
			if(!ap_alloted.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_alloted').html('VTM Sub-alloted is only Numeric value, Check again.');
			}else{
				$('.ap_alloted').html('');
			}	
		}

		if(ap_balance == ""){
			e_error = 1;
			$('.ap_balance').html('VTM Balance is Required.');
		}else{
			if(!ap_balance.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_balance').html('VTM Balance is only Numeric value, Check again.');
			}else{
				if(ap_balance < 0){
					e_error = 1;
					$('.ap_balance').html('VTM Balance never less than 0, Check again.');
				}else{
					$('.ap_balance').html('');
				}
			}	
		}
		
		if(ap_utilize != "" && ap_receive != "" && ex_stock != "" && ap_alloted != ""){
			if(ap_utilize == 0 && ap_receive == 0 && ap_alloted == 0){
				e_error = 1;
				error_message = error_message + '<br/>Sub-alloted, Utilize and Receive is 0 value, Change it.';
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