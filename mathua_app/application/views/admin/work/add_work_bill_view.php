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
				 <div class="col-sm-12 text-center" style="font-size:20px;margin-bottom:10px;">Financial Year - <strong><?php echo $work_detail->mw_year; ?></strong>, Work Name - <strong><?php echo $work_detail->mw_name; ?></strong><br/>Current Work Progress - <strong><?php echo $work_detail->mw_progress_stat." %"; ?></strong><br/>RA Bill No. - <strong><?php echo $bill_count+1; ?></strong></div>
				 </div>
                 <div class="form-group">
				 	<label class="col-sm-3 control-label text-right">Is it Final Bill<font style="color: red;">*</font></label>
					<div class="col-sm-2">
						<div class="radio">
							<label>
							<input type="radio" name="b_final" id="b_final1" value="Yes"> Yes
							</label>
							&nbsp;&nbsp;&nbsp;
							<label>
							<input type="radio" name="b_final" id="b_final2" value="No"> No
							</label>
						</div>
						<small class="text-error b_final"><?php echo form_error('b_final'); ?></small>
					</div>
				    <label class="col-sm-3 control-label">Date of submission<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="hidden" name="b_count" id="b_count" value="<?php echo $bill_count+1; ?>" />
					  <input type="text" class="form-control" name="b_submission" id="b_submission" autocomplete="off" placeholder="DD-MM-YYYY" />
				      <small class="text-error b_submission"><?php echo form_error('b_submission'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				    <label class="col-sm-3 control-label">Amount Released <font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="text" class="form-control" name="b_amount" id="b_amount" autocomplete="off" placeholder="Enter Amount Released" onkeyup="check_progress();" />
				      <small class="text-error b_amount"><?php echo form_error('b_amount'); ?></small>
				    </div>
					<label class="col-sm-2 control-label">Released Date<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
					  <input type="text" class="form-control" name="b_amt_release" id="b_amt_release" autocomplete="off" placeholder="DD-MM-YYYY" />
				      <small class="text-error b_amt_release"><?php echo form_error('b_amt_release'); ?></small>
				    </div>
				 </div>
				 <div class="final_bill_tab" style="display:none;">
					<div class="form-group">
						<label class="col-sm-3 control-label">Date of claim of EMD<font style="color: red;">*</font></label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="b_claim_emd" id="b_claim_emd" autocomplete="off" placeholder="DD-MM-YYYY" />
						<small class="text-error b_claim_emd"><?php echo form_error('b_claim_emd'); ?></small>
						</div>
						<label class="col-sm-2 control-label">Date of release of EMD<font style="color: red;">*</font></label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="b_release_emd" id="b_release_emd" autocomplete="off" placeholder="DD-MM-YYYY" />
						<small class="text-error b_release_emd"><?php echo form_error('b_release_emd'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Any revised Estimate<font style="color: red;">*</font></label>
						<div class="col-sm-3">
							<div class="radio">
								<label>
								<input type="radio" name="b_revised" id="b_revised1" value="Yes"> Yes
								</label>
								&nbsp;&nbsp;&nbsp;
								<label>
								<input type="radio" name="b_revised" id="b_revised2" value="No"> No
								</label>
							</div>
							<small class="text-error b_revised"><?php echo form_error('b_revised'); ?></small>
						</div>
						<div class="revised_tab" style="display:none;">
							<label class="col-sm-2 control-label">Additional Amount<font style="color: red;">*</font></label>
							<div class="col-sm-3">
							<input type="text" class="form-control" name="b_add_amount" id="b_add_amount" autocomplete="off" placeholder="Enter Additional Amount" />
							<small class="text-error b_add_amount"><?php echo form_error('b_add_amount'); ?></small>
							</div>
						</div>
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
		$( "#b_submission, #b_amt_release, #b_claim_emd, #b_release_emd" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
	    $('.alert-error, .text-error').delay(6000).fadeOut();

		$('input:radio[name="b_final"]').change(function() {
			goto_final_check();
		});

		$('input:radio[name="b_revised"]').change(function() {
			goto_revised_check();
		});
	});

	function goto_final_check(){
		var b_final = $("input[name='b_final']:checked").val();
		if(b_final == "Yes"){
			$('#b_add_amount, #b_claim_emd, #b_release_emd').val('');
			$('input:radio[name=b_revised]:checked').prop('checked', false);
			$('.revised_tab').fadeOut(500);
			$('.final_bill_tab').show(500);
		}else{
			$('#b_add_amount, #b_claim_emd, #b_release_emd').val('');
			$('input:radio[name=b_revised]:checked').prop('checked', false);
			$('.final_bill_tab, .revised_tab').fadeOut(500);
		}
	}

	function goto_revised_check(){
		var b_revised = $("input[name='b_revised']:checked").val();
		if(b_revised == "Yes"){
			$('#b_add_amount').val('');
			$('.revised_tab').show(500);
		}else{
			$('#b_add_amount').val('');
			$('.revised_tab').fadeOut(500);
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
		
    	var b_final = $("input[name='b_final']:checked").val();
		var b_count = $('#b_count').val();
    	var b_submission = $('#b_submission').val();
    	var b_amount = $('#b_amount').val();
		var b_amt_release = $('#b_amt_release').val();
    	var b_claim_emd = $('#b_claim_emd').val();
    	var b_release_emd = $('#b_release_emd').val();
		var b_revised = $("input[name='b_revised']:checked").val();
		var b_add_amount = $('#b_add_amount').val();
		//var w_sae = $("#w_sae option:selected").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(b_final == "" || b_final == undefined){
			e_error = 1;
			$('.b_final').html('Is it Final Bill is Required.');
		}else{
			if(!b_final.match(alphaletters)){
				e_error = 1;
				$('.b_final').html('Is it Final Bill only Alphabet value, Check again.');
			}else{
				$('.b_final').html('');
			}
		}
		if(b_submission == ""){
			e_error = 1;
			$('.b_submission').html('Date of submission is Required.');
		}else{
			if(isDatecheck(b_submission) == false){
				e_error = 1;
				$('.b_submission').html('Date of submission Format check properly and Try Again.');
			}else{
				$('.b_submission').html('');
			}	
		}
		if(b_count == ""){
			e_error = 1;
			error_message = error_message + '<br/>ID not found properly, Refresh the page and Try Again.';
		}

		if(b_amount == ""){
			e_error = 1;
			$('.b_amount').html('Amount Released is Required.');
		}else{
			if(!b_amount.match(onlynumerics_comma)){
				e_error = 1;
				$('.b_amount').html('Amount Released only numeric value and Try Again.');
			}else{
				$('.b_amount').html('');
			}	
		}
		if(b_amt_release == ""){
			e_error = 1;
			$('.b_amt_release').html('Released Date is Required.');
		}else{
			if(isDatecheck(b_amt_release) == false){
				e_error = 1;
				$('.b_amt_release').html('Released Date Format check properly and Try Again.');
			}else{
				$('.b_amt_release').html('');
			}	
		}

		if(b_final == "Yes"){
			if(b_claim_emd == ""){
				e_error = 1;
				$('.b_claim_emd').html('Date of claim of EMD is Required.');
			}else{
				if(isDatecheck(b_claim_emd) == false){
					e_error = 1;
					$('.b_claim_emd').html('Date of claim of EMD Format check properly and Try Again.');
				}else{
					$('.b_claim_emd').html('');
				}	
			}
			if(b_release_emd == ""){
				e_error = 1;
				$('.b_release_emd').html('Date of release of EMD is Required.');
			}else{
				if(isDatecheck(b_release_emd) == false){
					e_error = 1;
					$('.b_release_emd').html('Date of release of EMD Format check properly and Try Again.');
				}else{
					$('.b_release_emd').html('');
				}	
			}
			if(b_revised == "" || b_revised == undefined){
				e_error = 1;
				$('.b_revised').html('Any revised Estimate is Required.');
			}else{
				if(!b_revised.match(alphaletters)){
					e_error = 1;
					$('.b_revised').html('Any revised Estimate only Alphabet value, Check again.');
				}else{
					$('.b_revised').html('');
				}
			}
			if(b_revised == "Yes"){
				if(b_add_amount == ""){
					e_error = 1;
					$('.b_add_amount').html('Additional Amount is Required.');
				}else{
					if(!b_add_amount.match(onlynumerics_comma)){
						e_error = 1;
						$('.b_add_amount').html('Additional Amount only numeric value and Try Again.');
					}else{
						$('.b_add_amount').html('');
					}	
				}
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