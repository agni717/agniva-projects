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
            <li class="active">Add New Work</li>
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
                  <h3 class="box-title">Add New Work</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
                 <div class="form-group">
				    <label class="col-sm-2 control-label text-right">Financial Year<font style="color: red;">*</font></label>
				    <div class="col-sm-2">
						<select class="form-control" name="f_year" id="f_year">
							<option value="">---Select---</option>
							<?php $prev_yr = date("y",strtotime("-2 year"));
							$adv_yr = date("y",strtotime("+1 year")); 
							for($i=$prev_yr;$i<$adv_yr;$i++){ 
								$tmp = $i + 1; 
								$tmpname = "20".$i."-".$tmp; ?>
								<option value="<?php echo $tmpname; ?>"><?php echo $tmpname; ?></option>
							<?php }	?>
				      	</select>
				      <small class="text-error f_year"><?php echo form_error('f_year'); ?></small>
				    </div>
				    <label class="col-sm-2 control-label text-right">Name of Work<font style="color: red;">*</font></label>
				    <div class="col-sm-5">
						<input type="text" class="form-control" name="w_name" id="w_name" placeholder="Enter Name of Work" autocomplete="off">
						<small class="text-error w_name"><?php echo form_error('w_name'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				 	<label class="col-sm-2 control-label text-right">Location of the scheme<font style="color: red;">*</font></label>
				    <div class="col-sm-4">
						<input type="text" class="form-control" name="w_loc" id="w_loc" placeholder="Enter Location of the scheme" autocomplete="off">
						<small class="text-error w_loc"><?php echo form_error('w_loc'); ?></small>
				    </div>
				 </div>
				 <div class="form-group">
				  	<label class="col-sm-2 control-label text-right">Sources of fund<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="w_fund" id="w_fund" onchange="goto_check_fund();">
				      	<option value="">---Select---</option>
				      	<?php foreach($fund_list as $funds){ ?>
						<option value="<?php echo $funds->fs_id; ?>"><?php echo $funds->fs_name; ?></option>
						<?php } ?>
						<option value="Others">Others</option>
				      </select>
				      <small class="text-error w_fund"><?php echo form_error('w_fund'); ?></small>
				    </div>
					<div class="fund_name_entrytab" style="display:none;">
						<label class="col-sm-2 control-label text-right">Enter Sources of fund<font style="color: red;">*</font></label>
						<div class="col-sm-3">
						<input type="email" class="form-control" name="w_fund_name" id="w_fund_name" placeholder="Enter Sources of fund" autocomplete="off">
						<small class="text-error w_fund_name"><?php echo form_error('w_fund_name'); ?></small>
						</div>
				    </div>
				  </div>
                  <div class="form-group">
				  	<label class="col-sm-2 control-label text-right">Work Sector<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="w_sector" id="w_sector" onchange="goto_check_sector();">
				      	<option value="">---Select---</option>
				      	<?php foreach($sector_list as $sectors){ ?>
						<option value="<?php echo $sectors->ws_id; ?>"><?php echo $sectors->ws_name; ?></option>
						<?php } ?>
						<option value="Others">Others</option>
				      </select>
				      <small class="text-error w_sector"><?php echo form_error('w_sector'); ?></small>
				    </div>
					<div class="sector_name_entrytab" style="display:none;">
						<label class="col-sm-2 control-label text-right">Enter Work Sector<font style="color: red;">*</font></label>
						<div class="col-sm-3">
						<input type="email" class="form-control" name="w_sector_name" id="w_sector_name" placeholder="Enter Work Sector" autocomplete="off">
						<small class="text-error w_sector_name"><?php echo form_error('w_sector_name'); ?></small>
						</div>
				    </div>
				  </div>
                  <div class="form-group">
				  	<label class="col-sm-2 control-label text-right">Tender floated<font style="color: red;">*</font></label>
				  	<div class="col-sm-3">
						<div class="radio">
							<label>
							<input type="radio" name="w_t_float" id="w_t_float1" value="Yes"> Yes
							</label>
							&nbsp;&nbsp;&nbsp;
							<label>
							<input type="radio" name="w_t_float" id="w_t_float2" value="No"> No
							</label>
						</div>
						<small class="text-error w_t_float"><?php echo form_error('w_t_float'); ?></small>
                    </div>
				  </div>

				  <div class="float_tender_tab" style="display:none;">
					<div class="form-group">
						<label class="col-sm-2 control-label text-right">Amount of Tender</label>
						<div class="col-sm-2">
						<input type="text" class="form-control" name="w_t_amount" id="w_t_amount" placeholder="Enter Amount of Tender" autocomplete="off">
						<small class="text-error w_t_amount"><?php echo form_error('w_t_amount'); ?></small>
						</div>
						<label class="col-sm-2 control-label text-right">Tender Date</label>
						<div class="col-sm-2">
						<input type="text" class="form-control" name="w_t_date" id="w_t_date" placeholder="DD-MM-YYYY" autocomplete="off">
						<small class="text-error w_t_date"><?php echo form_error('w_t_date'); ?></small>
						</div>
						<label class="col-sm-2 control-label text-right">Tender Mode</label>
						<div class="col-sm-2">
						<select class="form-control" name="w_t_mode" id="w_t_mode">
						<option value="">---Select---</option>
						<option value="E-tender">E-tender</option>
						<option value="Offline">Offline</option>
						</select>
						<small class="text-error w_t_mode"><?php echo form_error('w_t_mode'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">NIT No.</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_nitno" id="w_nitno" placeholder="Enter NIT No." autocomplete="off">
						<small class="text-error w_nitno"><?php echo form_error('w_nitno'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">Upload NIT Document</label>
						<div class="col-sm-3">
						<input type="file" class="form-control" name="w_nit_doc" id="w_nit_doc">
						<small class="text-error w_nit_doc"><?php echo form_error('w_nit_doc'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Tender matured</label>
						<div class="col-sm-3">
							<div class="radio">
								<label>
								<input type="radio" name="w_t_mature" id="w_t_mature1" value="Yes"> Yes
								</label>
								&nbsp;&nbsp;&nbsp;
								<label>
								<input type="radio" name="w_t_mature" id="w_t_mature2" value="No"> No
								</label>
							</div>
							<small class="text-error w_t_mature"><?php echo form_error('w_t_mature'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">Workorder Date</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_order_date" id="w_order_date" placeholder="DD-MM-YYYY" autocomplete="off">
						<small class="text-error w_order_date"><?php echo form_error('w_order_date'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Awarded Cost</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_award_amount" id="w_award_amount" placeholder="Enter Amount of Awarded Cost" autocomplete="off">
						<small class="text-error w_award_amount"><?php echo form_error('w_award_amount'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">Upload WorkOrder Copy</label>
						<div class="col-sm-3">
						<input type="file" class="form-control" name="w_order_doc" id="w_order_doc">
						<small class="text-error w_order_doc"><?php echo form_error('w_order_doc'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Name of the Agency/contractor</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_agency_name" id="w_agency_name" placeholder="Enter Name of Agency/contractor" autocomplete="off">
						<small class="text-error w_agency_name"><?php echo form_error('w_agency_name'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">Mobile No. of the Agency/constrictor</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_agency_mobile" id="w_agency_mobile" placeholder="Enter Mobile No." autocomplete="off">
						<small class="text-error w_agency_mobile"><?php echo form_error('w_agency_mobile'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">GST No. of the Agency/constrictor</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_agency_gst" id="w_agency_gst" placeholder="Enter GST No." autocomplete="off">
						<small class="text-error w_agency_gst"><?php echo form_error('w_agency_gst'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">EMD Amount</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_emd_amount" id="w_emd_amount" placeholder="Enter EMD Amount" autocomplete="off">
						<small class="text-error w_emd_amount"><?php echo form_error('w_emd_amount'); ?></small>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Date of commencement</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_com_date" id="w_com_date" placeholder="DD-MM-YYYY" autocomplete="off">
						<small class="text-error w_com_date"><?php echo form_error('w_com_date'); ?></small>
						</div>
						<label class="col-sm-3 control-label text-right">Tentative date of completion</label>
						<div class="col-sm-3">
						<input type="text" class="form-control" name="w_tent_date" id="w_tent_date" placeholder="DD-MM-YYYY" autocomplete="off">
						<small class="text-error w_tent_date"><?php echo form_error('w_tent_date'); ?></small>
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
                      &nbsp;<a href="<?= site_url('admincontrol/panel/work_list') ?>" class="btn btn-danger">Cancel</a>
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
		$( "#w_t_date, #w_order_date, #w_com_date, #w_tent_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
	    $('.alert-error, .text-error').delay(6000).fadeOut();

		$('input:radio[name="w_t_float"]').change(function() {
			goto_float_check();
		});
	});

	function goto_float_check(){
		var w_t_float = $("input[name='w_t_float']:checked").val();
		if(w_t_float == "Yes"){
			//$('#out_state').val('');
			$('.float_tender_tab').show(500);
		}else{
			//$('#out_state').val('');
			//$('input:radio[name=ap_pool]:checked').prop('checked', false);
			$('.float_tender_tab').fadeOut(500);
		}
	}

	function goto_check_fund(){
		var w_fund = $("#w_fund option:selected").val();
		if(w_fund == "Others"){
			$('#w_fund_name').val('');
			$('.fund_name_entrytab').show(500);
		}else{
			$('#w_fund_name').val('');
			$('.fund_name_entrytab').fadeOut(500);
		}
	}

	function goto_check_sector(){
		var w_sector = $("#w_sector option:selected").val();
		if(w_sector == "Others"){
			$('#w_sector_name').val('');
			$('.sector_name_entrytab').show(500);
		}else{
			$('#w_sector_name').val('');
			$('.sector_name_entrytab').fadeOut(500);
		}
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
		var onlynumerics_hypen = /^[0-9\-]+$/;
		var onlynumerics_comma = /^[0-9,.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
    	var f_year = $('#f_year option:selected').val();
    	var w_name = $('#w_name').val();
    	var w_loc = $('#w_loc').val();
		var w_fund = $("#w_fund option:selected").val();
		var w_fund_name = $('#w_fund_name').val();
		var w_sector = $("#w_sector option:selected").val();
		var w_sector_name = $('#w_sector_name').val();
		var w_t_float = $("input[name='w_t_float']:checked").val();

    	var w_t_amount = $('#w_t_amount').val();
    	var w_t_date = $('#w_t_date').val();
    	var w_t_mode = $("#w_t_mode option:selected").val();
    	var w_nitno = $('#w_nitno').val();
		var w_t_mature = $("input[name='w_t_mature']:checked").val();
		var w_order_date = $('#w_order_date').val();
    	var w_award_amount = $('#w_award_amount').val();
		var w_agency_name = $('#w_agency_name').val();
		var w_agency_mobile = $('#w_agency_mobile').val();
		var w_agency_gst = $('#w_agency_gst').val();
		var w_emd_amount = $('#w_emd_amount').val();
		var w_com_date = $('#w_com_date').val();
		var w_tent_date = $('#w_tent_date').val();
		
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(f_year == ""){
			e_error = 1;
			$('.f_year').html('Financial Year is Required.');
		}else{
			if(!f_year.match(onlynumerics_hypen)){
				e_error = 1;
				$('.f_year').html('Financial Year user only Numeric and [-] sign, Check again.');
			}else{
				$('.f_year').html('');
			}	
		}
		if(w_name == ""){
			e_error = 1;
			$('.w_name').html('Name of Work is Required.');
		}else{
			if(!w_name.match(alphanumerics_no)){
				e_error = 1;
				$('.w_name').html('Name of Work not use special carecters [without _ / : ( . & ) , -], Check again.');
			}else{
				$('.w_name').html('');
			}	
		}
		if(w_loc == ""){
			e_error = 1;
			$('.w_loc').html('Location of the scheme is Required.');
		}else{
			if(!w_loc.match(alphanumerics_no)){
				e_error = 1;
				$('.w_loc').html('Location of the scheme not use special carecters [without _ / : ( . & ) , -], Check again.');
			}else{
				$('.w_loc').html('');
			}	
		}
		if(w_fund == ""){
			e_error = 1;
			$('.w_fund').html('Sources of fund is Required.');
		}else{
			if(!w_fund.match(alphanumerics_spaces)){
				e_error = 1;
				$('.w_fund').html('Sources of fund not use special carecters [without _ , -], Check again.');
			}else{
				$('.w_fund').html('');
				if(w_fund == "Others"){
					if(w_fund_name == ""){
						e_error = 1;
						$('.w_fund_name').html('Sources of fund Name is Required.');
					}else{
						if(!w_fund_name.match(alphanumerics_no)){
							e_error = 1;
							$('.w_fund_name').html('Sources of fund Name not use special carecters [without _ / & : ( . ) , -], Check again.');
						}else{
							$('.w_fund_name').html('');
						}	
					}
				}else{
					$('.w_fund_name').html('');
				}
			}	
		}
		if(w_sector == ""){
			e_error = 1;
			$('.w_sector').html('Work Sector is Required.');
		}else{
			if(!w_sector.match(alphanumerics_spaces)){
				e_error = 1;
				$('.w_sector').html('Work Sector not use special carecters [without _ , -], Check again.');
			}else{
				$('.w_sector').html('');
				if(w_sector == "Others"){
					if(w_sector_name == ""){
						e_error = 1;
						$('.w_sector_name').html('Work Sector Name is Required.');
					}else{
						if(!w_sector_name.match(alphanumerics_no)){
							e_error = 1;
							$('.w_sector_name').html('Work Sector Name not use special carecters [without _ / & : ( . ) , -], Check again.');
						}else{
							$('.w_sector_name').html('');
						}	
					}
				}else{
					$('.w_sector_name').html('');
				}
			}	
		}
		if(w_t_float == "" || w_t_float == undefined){
			e_error = 1;
			$('.w_t_float').html('Tender floated is Required.');
		}else{
			if(!w_t_float.match(alphaletters)){
				e_error = 1;
				$('.w_t_float').html('Tender floated only Alphabet value, Check again.');
			}else{
				$('.w_t_float').html('');
			}
		}
		if(w_t_float == "Yes"){
			if(w_t_amount == ""){
				e_error = 1;
				$('.w_t_amount').html('Amount of Tender is Required.');
			}else{
				if(!w_t_amount.match(onlynumerics_comma)){
					e_error = 1;
					$('.w_t_amount').html('Amount of Tender use only Numeric and [, .], Check again.');
				}else{
					$('.w_t_amount').html('');
				}	
			}
			if(w_t_date == ""){
				e_error = 1;
				$('.w_t_date').html('Tender Date is Required.');
			}else{
				if(isDatecheck(w_t_date) == false){
					e_error = 1;
					$('.w_t_date').html('Tender Date Format check properly and Try Again.');
				}else{
					$('.w_t_date').html('');
				}	
			}
			if(w_t_mode == ""){
				e_error = 1;
				$('.w_t_mode').html('Tender Mode is Required.');
			}else{
				if(!w_t_mode.match(alphanumerics_spaces)){
					e_error = 1;
					$('.w_t_mode').html('Tender Mode not use special carecters [without _ , -], Check again.');
				}else{
					$('.w_t_mode').html('');
				}	
			}
			if(w_nitno == ""){
				e_error = 1;
				$('.w_nitno').html('NIT No. is Required.');
			}else{
				if(!w_nitno.match(alphanumerics_spaces)){
					e_error = 1;
					$('.w_nitno').html('NIT No. not use special carecters [without _ , -], Check again.');
				}else{
					$('.w_nitno').html('');
				}	
			}
			if(w_t_mature == "" || w_t_mature == undefined){
				e_error = 1;
				$('.w_t_mature').html('Tender matured is Required.');
			}else{
				if(!w_t_mature.match(alphaletters)){
					e_error = 1;
					$('.w_t_mature').html('Tender matured only Alphabet value, Check again.');
				}else{
					$('.w_t_mature').html('');
				}
			}
			if(w_order_date == ""){
				e_error = 1;
				$('.w_order_date').html('Workorder Date is Required.');
			}else{
				if(isDatecheck(w_order_date) == false){
					e_error = 1;
					$('.w_order_date').html('Workorder Date Format check properly and Try Again.');
				}else{
					$('.w_order_date').html('');
				}	
			}
			if(w_award_amount == ""){
				e_error = 1;
				$('.w_award_amount').html('Awarded Cost is Required.');
			}else{
				if(!w_award_amount.match(onlynumerics_comma)){
					e_error = 1;
					$('.w_award_amount').html('Awarded Cost use only Numeric and [, .], Check again.');
				}else{
					$('.w_award_amount').html('');
				}	
			}
			if(w_agency_name == ""){
				e_error = 1;
				$('.w_agency_name').html('Name of the Agency/contractor is Required.');
			}else{
				if(!w_agency_name.match(alphanumerics_no)){
					e_error = 1;
					$('.w_agency_name').html('Name of the Agency/contractor not use special carecters [without _ / : ( . & ) , -], Check again.');
				}else{
					$('.w_agency_name').html('');
				}	
			}
			if(w_agency_mobile == ""){
				e_error = 1;
				$('.w_agency_mobile').html('Mobile No. of Agency/contractor is Required.');
			}else{
				if(!w_agency_mobile.match(onlynumerics)){
					e_error = 1;
					$('.w_agency_mobile').html('Mobile No. needs only 10 digit.');
				}else if(w_agency_mobile.length != 10){
					e_error = 1;
					$('.w_agency_mobile').html('Mobile No. needs only 10 digit.');
				}else{
					$('.w_agency_mobile').html('');
				}
			}
			if(w_agency_gst == ""){
				e_error = 1;
				$('.w_agency_gst').html('GST No. of Agency/contractor is Required.');
			}else{
				if(!w_agency_gst.match(alphanumerics_spaces)){
					e_error = 1;
					$('.w_agency_gst').html('GST No. of Agency/contractor not use special carecters [without _ , -], Check again.');
				}else{
					$('.w_agency_gst').html('');
				}	
			}
			if(w_emd_amount == ""){
				e_error = 1;
				$('.w_emd_amount').html('EMD Amount is Required.');
			}else{
				if(!w_emd_amount.match(onlynumerics_comma)){
					e_error = 1;
					$('.w_emd_amount').html('EMD Amount use only Numeric and [, .], Check again.');
				}else{
					$('.w_emd_amount').html('');
				}	
			}
			if(w_com_date == ""){
				e_error = 1;
				$('.w_com_date').html('Date of commencement is Required.');
			}else{
				if(isDatecheck(w_com_date) == false){
					e_error = 1;
					$('.w_com_date').html('Date of commencement Format check properly and Try Again.');
				}else{
					$('.w_com_date').html('');
				}	
			}
			if(w_tent_date == ""){
				e_error = 1;
				$('.w_tent_date').html('Tentative date of completion is Required.');
			}else{
				if(isDatecheck(w_tent_date) == false){
					e_error = 1;
					$('.w_tent_date').html('Tentative date of completion Format check properly and Try Again.');
				}else{
					$('.w_tent_date').html('');
				}	
			}

			if(document.getElementById("w_nit_doc").files.length == 0){
				e_error = 1;
				$('.w_nit_doc').html('NIT Document is Required.');
			}else{
				var fileInput = document.getElementById('w_nit_doc'); 
				var filePath = fileInput.value;
				if(!allowedExtensions.exec(filePath)){
					e_error = 1;
					$('.w_nit_doc').html('NIT Document type Invalid.(Use PDF/JPG)');
				}else{
					$('.w_nit_doc').html('');
				}
				
			}
			if(document.getElementById("w_order_doc").files.length == 0){
				e_error = 1;
				$('.w_order_doc').html('WorkOrder Copy is Required.');
			}else{
				var fileInput = document.getElementById('w_order_doc'); 
				var filePath = fileInput.value;
				if(!allowedExtensions.exec(filePath)){
					e_error = 1;
					$('.w_order_doc').html('WorkOrder Copy type Invalid.(Use PDF/JPG)');
				}else{
					$('.w_order_doc').html('');
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