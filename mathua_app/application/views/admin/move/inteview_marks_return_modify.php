<?php $this->load->view('admin/component/header') ?>
<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input {max-width: 250px;}
.box-body textarea { resize: vertical; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Interview Marks Modification
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Interview Marks Modification</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12">
              <!-- Custom tabs (Charts with tabs)-->
			
			<?php if($this->session->flashdata('success')) { ?>
			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php $this->session->unset_userdata('success'); }
		    	elseif($this->session->flashdata('e_error')) { ?>                
	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
		    <?php $this->session->unset_userdata('e_error'); } ?>
			
              <!-- TO DO List -->
              <div class="box box-warning">
                <!-- /.box-header -->
				<div class="box-body"><?php //print_r($return_marks_detail); ?>
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
					<?php echo form_open_multipart('','class="" id="form123"'); ?>
				<div class="row">
				<div class="col-sm-offset-1 col-sm-4">
				  <div class="form-group">
					<label>Advertisement No. : <?php echo $return_marks_detail->adv_no.' ('.$return_marks_detail->rm_name.')'; ?></label>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
					<label class="control-label">Post Category : <?php echo $return_marks_detail->catm_name; ?></label>		  	
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">Interview Date : <?php echo date('d-m-Y',strtotime($return_marks_detail->shift_date)); ?></label>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-offset-1 col-sm-4">
				  <div class="form-group">
					<label>Interview Venue : <?php echo $return_marks_detail->address_name; ?></label>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
				  	<label class="control-label">Interview Shift : <?php echo date('h:i A',strtotime($return_marks_detail->shift_start_time)).' to '.date('h:i A',strtotime($return_marks_detail->shift_end_time)); ?></label>
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">Interview Table No. : <?php echo $return_marks_detail->invw_tableno; ?></label>
				    </div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-12 text-center">
					<div class="form-group">
					<label class="control-label" style="font-size:20px;">Candidate Name (Reg. No.) : <?php echo $return_marks_detail->f_full_name.' ('.$return_marks_detail->invw_cand_regno.')'; ?></label><br/>
					<label class="control-label" style="font-size:18px;">Reason of Return : <?php echo $return_marks_detail->invw_msg_return; ?></label><br/>
				    </div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-offset-1 col-sm-2">
					<div class="form-group">
						<label class="control-label">Interview Attendance</label>
						<input type="hidden" name="intv_regno" id="intv_regno" value="<?php echo $return_marks_detail->invw_cand_regno; ?>" autocomplete="off" />
						<div class="radio">
							<label>
								<input type="radio" name="atten_intv" id="atten_intv1" value="Yes" autocomplete="off" <?php if($return_marks_detail->invw_attendance == "Yes"){echo "Checked";} ?>> Yes
							</label>
							&nbsp;&nbsp;&nbsp;
							<label>
								<input type="radio" name="atten_intv" id="atten_intv2" value="No" autocomplete="off" <?php if($return_marks_detail->invw_attendance == "No"){echo "Checked";} ?>> No
							</label>
						</div>
						<small class="text-error atten_intv"><?php echo form_error('atten_intv'); ?></small>
				    </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Language Knowledge</label>
						<div class="radio">
							<?php if($return_marks_detail->adv_dictation_set == "Yes"){ ?>
							<label>
								<input type="radio" name="intv_lang" id="intv_lang1" value="Yes" autocomplete="off" <?php if($return_marks_detail->invw_language == NULL){echo "Checked";}else{if($return_marks_detail->invw_language == "Yes"){echo "Checked";}} ?>> Yes
							</label>
							&nbsp;&nbsp;&nbsp;
							<label>
								<input type="radio" name="intv_lang" id="intv_lang2" value="No" autocomplete="off" <?php if($return_marks_detail->invw_language == "No"){echo "Checked";} ?>> No
							</label>
							&nbsp;&nbsp;&nbsp;
							<label>
								<input type="radio" name="intv_lang" id="intv_lang3" value="Not Applicable" autocomplete="off" <?php if($return_marks_detail->invw_language == "Not Applicable"){echo "Checked";} ?>> Not Applicable
							</label>
							<?php }else{ ?>
							<label>
								<input type="radio" name="intv_lang" id="intv_lang1" value="Not Applicable" autocomplete="off" Checked> Not Applicable
							</label>
							<?php } ?>
						</div>
						<small class="text-error intv_lang"><?php echo form_error('intv_lang'); ?></small>
				    </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Interview Marks(10)</label>
						<input type="text" class="form-control" name="intv1_mark" id="intv1_mark" value="<?php echo $return_marks_detail->invw_marks_1; ?>" autocomplete="off" />
						<small class="text-error intv1_mark"><?php echo form_error('intv1_mark'); ?></small>
				    </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Interview Marks(5)</label>
						<input type="text" class="form-control" name="intv2_mark" id="intv2_mark" value="<?php echo $return_marks_detail->invw_marks_2; ?>" autocomplete="off" />
						<small class="text-error intv2_mark"><?php echo form_error('intv2_mark'); ?></small>
				    </div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-12">
       				 <div class="form-group">	
					    <div align="center">
								<div class="get_error_total_2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total_2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total_2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						  </div>
				    </div>
                </div>
				<div class="col-sm-12 text-center" style="margin-top:5px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
					&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admincontrol/movement/getall_return_marksmodification_list'); ?>" class="btn btn-primary">Cancel</a>
                </div>
				<div class="clearfix"></div>
              </div>

			  <?php echo form_close(); ?>
			  </div><!-- /.box-body -->
                
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
	var candset_all;
    $(function () {
		$('#u_startdate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		//$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
        $("#datatable_tab").dataTable();
    });
	  	
	function goto_rec_search(){
		//$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
		var rf_set = $("#rf_set option:selected").val();
		if(rf_set != ""){
			var form_data = new FormData();
			form_data.append("rf_set", rf_set);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/advertisement_set/get_advisement_against_recruitment') ?>",
				dataType: 'json',
				data: form_data,
				contentType:false,
				cache:true,
				processData:false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('#advno').html(data.op_set);
						$('#advno').prop('disabled', false);
						
					}else{
						//$('.div_roller_total').fadeOut();
						$('#advno').html('<option value="">---Select---</option>');
						$('#advno').prop('disabled', true);
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#advno').html('<option value="">---Select---</option>');
			$('#advno').prop('disabled', true);
		}
	}
		
	function gotopanel_candidate_search(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
		var rf_set = 1;
		var advno = $("#advno option:selected").val();
		/*var venueno = $('#venueno option:selected').val();
		var u_startdate = $('#u_startdate').val();
		var u_starttime = $('#u_starttime').val();
		var u_endtime = $('#u_endtime').val();*/

		if(rf_set != "" && advno != ""){
			var form_data = new FormData();
			form_data.append("rf_set", 1);
			form_data.append("advno", advno);
			/*form_data.append("venueno", venueno);
			form_data.append("u_startdate", u_startdate);
			form_data.append("u_starttime", u_starttime);
			form_data.append("u_endtime", u_endtime);*/
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_alltableno_fromadv_section') ?>",
				dataType: 'json',
				data: form_data,
				contentType:false,
				cache:true,
				processData:false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('#advcat_name').html('<option value="">---Select---</option>'+ data.category_set);
						$('#advcat_name').prop('disabled', false);
					}else{
						$('.div_roller_total').fadeOut();
						$('#advcat_name').html('<option value="">---Select---</option>');
						$('#advcat_name').prop('disabled', true);
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}else{
			$('.div_roller_total').fadeOut();
			$('#advcat_name').html('<option value="">---Select---</option>');
			$('#advcat_name').prop('disabled', true);
		}
	}

	function check_timeall(timeset){
		var hours = Number(timeset.match(/^(\d+)/)[1]);
		var minutes = Number(timeset.match(/:(\d+)/)[1]);
		var AMPM = timeset.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if(hours<10) sHours = "0" + sHours;
		if(minutes<10) sMinutes = "0" + sMinutes;
		//alert(sHours + ":" + sMinutes);
		var time_all = sHours + ':' + sMinutes;
		return time_all;
	}	



	function isDatecheck_dmY(txtDate)
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
		
	function goto_check_totaltab(){
		var venueno = $('#venueno option:selected').val();
		var u_startdate = $('#u_startdate').val();
		if(venueno != "" && u_startdate != ""){
			var form_data = new FormData();
			form_data.append("venueno", venueno);
			form_data.append('u_startdate', u_startdate);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_venue_details_v2') ?>",
				dataType: 'json',
				data: form_data,
				contentType:false,
				cache:true,
				processData:false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('.div_roller_total').fadeOut();
						$('#shift_name').html('<option value="">---Select---</option>'+ data.op_set);
						$('#shift_name').prop('disabled', false);
						$('#table_exactno').html('<option value="">---Select---</option>');
						$('#table_exactno').prop('disabled', true);

					}else{
						//$('.div_roller_total').fadeOut();
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						$('#shift_name, #table_exactno').html('<option value="">---Select---</option>');
						$('#shift_name, #table_exactno').prop('disabled', true);
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#shift_name, #table_exactno').html('<option value="">---Select---</option>');
			$('#shift_name, #table_exactno').prop('disabled', true);
		}
	}

	function goto_check_shiftwisetab(){
		var advno = $("#advno option:selected").val();
		var shift_name = $('#shift_name option:selected').val();
		var advcat_name = $('#advcat_name option:selected').val();
		if(advno != "" && shift_name != "" && advcat_name != ""){
			var form_data = new FormData();
			form_data.append("advno", advno);
			form_data.append('shift_name', shift_name);
			form_data.append('advcat_name', advcat_name);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_allexact_tabledetails') ?>",
				dataType: 'json',
				data: form_data,
				contentType:false,
				cache:true,
				processData:false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('.div_roller_total').fadeOut();
						$('#table_exactno').html('<option value="">---Select---</option>'+ data.untab_set);
						$('#table_exactno').prop('disabled', false);

					}else{
						//$('.div_roller_total').fadeOut();
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						$('#table_exactno').html('<option value="">---Select---</option>');
						$('#table_exactno').prop('disabled', true);
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#table_exactno').html('<option value="">---Select---</option>');
			$('#table_exactno').prop('disabled', true);
		}
	}

	function goto_search_table_candidates(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
		var advno = $("#advno option:selected").val();
		var u_startdate = $('#u_startdate').val();
		var advcat_name = $('#advcat_name option:selected').val();
		var venueno = $('#venueno option:selected').val();
		var shift_name = $('#shift_name option:selected').val();
		var table_exactno = $('#table_exactno option:selected').val();

		if(advno == ""){
			e_error = 1;
			$('.advno').html('Advertisement No. is Required.');
		}else{
			if(!advno.match(alphanumerics)){
				e_error = 1;
				$('.advno').html('Advertisement No. only use Numeric Values, Check again.');
			}else{
				$('.advno').html('');
			}	
		}
		if (advcat_name == "") {
			e_error = 1;
			$('.advcat_name').html('Adv. category is Required.');
		} else {
			if (!advcat_name.match(onlynumerics)) {
				e_error = 1;
				$('.advcat_name').html('Adv. category only use Numeric values, Check again.');
			} else {
				$('.advcat_name').html('');
			}
		}

		if(venueno == ""){
			e_error = 1;
			$('.venueno').html('Interview Venue is Required.');
		}else{
			if(!venueno.match(onlynumerics)){
				e_error = 1;
				$('.venueno').html('Interview Venue only use Numeric Values, Check again.');
			}else{
				$('.venueno').html('');
			}	
		}
		if (shift_name == "") {
			e_error = 1;
			$('.shift_name').html('Shift is Required.');
		} else {
			if (!shift_name.match(onlynumerics)) {
				e_error = 1;
				$('.shift_name').html('Shift only use Numeric values, Check again.');
			} else {
				$('.shift_name').html('');
			}
		}
		if (table_exactno == "") {
			e_error = 1;
			$('.table_exactno').html('Table No. is Required.');
		} else {
			if (!table_exactno.match(onlynumerics)) {
				e_error = 1;
				$('.table_exactno').html('Table No. only use Numeric values, Check again.');
			} else {
				$('.table_exactno').html('');
			}
		}

		if(u_startdate == ""){
			e_error = 1;
			$('.u_startdate').html('Interview Date is Required.');
		}else{
			if(isDatecheck_dmY(u_startdate) == false){
				e_error = 1;
				$('.u_startdate').html('Interview Date Format check properly.');
			}else{
				$('.u_startdate').html('');
			}
		}

		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('#pa_target_submit').prop('disabled', false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} else {
			var form_data = new FormData();
			form_data.append("advno", advno);
			form_data.append("advcat_name", advcat_name);
			form_data.append("venueno", venueno);
			form_data.append("u_startdate", u_startdate);
			form_data.append("shift_name", shift_name);
			form_data.append("table_exactno", table_exactno);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/movement/get_tablecandidates_details') ?>",
				dataType: 'json',
				data: form_data,
				contentType:false,
				cache:true,
				processData:false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						var genstring = '';
						var candcounter = 1;
						candset_all = data.op_set;
						for(var ic = 0;ic<data.op_set.length;ic++){
							genstring = genstring + '<tr><td><strong>'+candcounter+'.</strong></td><td>'+data.op_set[ic].f_full_name+' ('+data.op_set[ic].invw_cand_regno+')</td><td><div><input type="hidden" name="intv_id_'+ic+'" id="intv_id_'+ic+'" value="'+data.op_set[ic].invw_id+'" /><input type="hidden" name="intv_regno_'+ic+'" id="intv_regno_'+ic+'" value="'+data.op_set[ic].invw_cand_regno+'" /><div class="radio"><label><input type="radio" name="atten_intv_'+data.op_set[ic].invw_id+'" id="atten_intv_'+data.op_set[ic].invw_id+'_1" value="Yes" autocomplete="off" checked> Yes</label>&nbsp;&nbsp;&nbsp;<label><input type="radio" name="atten_intv_'+data.op_set[ic].invw_id+'" id="atten_intv_'+data.op_set[ic].invw_id+'_2" value="No" autocomplete="off"> No</label></div><small class="text-error atten_intv_'+data.op_set[ic].invw_id+'"></small></div></td><td><div><div class="radio"><label><input type="radio" name="intv_lang_'+data.op_set[ic].invw_id+'" id="intv_lang_'+data.op_set[ic].invw_id+'_1" value="Yes" autocomplete="off" checked> Yes</label>&nbsp;&nbsp;&nbsp;<label><input type="radio" name="intv_lang_'+data.op_set[ic].invw_id+'" id="intv_lang_'+data.op_set[ic].invw_id+'_2" value="No" autocomplete="off"> No</label>&nbsp;&nbsp;&nbsp;<label><input type="radio" name="intv_lang_'+data.op_set[ic].invw_id+'" id="intv_lang_'+data.op_set[ic].invw_id+'_3" value="Not Applicable" autocomplete="off"> Not Applicable</label></div><small class="text-error intv_lang_'+data.op_set[ic].invw_id+'"></small></div></td><td><div><input type="text" class="form-control" name="intv1_mark_'+data.op_set[ic].invw_id+'" id="intv1_mark_'+data.op_set[ic].invw_id+'" /><small class="text-error intv1_mark_'+data.op_set[ic].invw_id+'"></small></div></td><td><div><input type="text" class="form-control" name="intv2_mark_'+data.op_set[ic].invw_id+'" id="intv2_mark_'+data.op_set[ic].invw_id+'" /><small class="text-error intv2_mark_'+data.op_set[ic].invw_id+'"></small></div></td></tr>';
							candcounter++;
						}
						$('.cand_items').html(genstring);
						$(".all_candidates_set").fadeIn();
						//$('#advcat_name').html('<option value="">---Select---</option>'+ data.category_set);
						//$('#advcat_name').prop('disabled', false);
					}else{
						$('.div_roller_total').fadeOut();
						//$('#advcat_name').prop('disabled', true);
						$('.cand_items').html('');
						$(".all_candidates_set").fadeOut();
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}
	}


	function goto_submit_button(){
		$('.div_roller_total_2').fadeIn();
		$('#pa_target_submit').prop('disabled', true);
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
		var intv_regno = $('input[name="intv_regno"]').val();
		var atten_intv = $('input[name="atten_intv"]:checked').val();
		var intv_lang = $('input[name="intv_lang"]:checked').val();
		var intv1_mark = $('input[name="intv1_mark"]').val();
		var intv2_mark = $('input[name="intv2_mark"]').val();

		if(intv_regno == ''){
			error_message = error_message + '<br/>Reg ID Not Found, refresh the Page.';
		}
		if (atten_intv == '' || atten_intv == undefined) {
			$('.atten_intv').html('Attend Interview is Required');
			e_error = 1;
		} else if (atten_intv != 'Yes' && atten_intv != 'No') {
			$('.atten_intv').html('Value should be between Yes or No');
			e_error = 1;
		} else {
			$('.atten_intv').html('');
		}

		if(atten_intv == 'Yes'){

			if (intv_lang == '' || intv_lang == undefined) {
				$('.intv_lang').html('Language Knowledge is Required');
				e_error = 1;
			} else if (intv_lang != 'Yes' && intv_lang != 'No' && intv_lang != 'Not Applicable') {
				$('.intv_lang').html('Value should be between Yes or No or Not Applicable');
				e_error = 1;
			} else {
				$('.intv_lang').html('');
			}

			if(intv1_mark == ""){
				e_error = 1;
				$('.intv1_mark').html('Interview 1 Marks is Required');
			}else{
				if (!intv1_mark.match(onlynumerics_withdot)) {
					e_error = 1;
					$('.intv1_mark').html('Interview 1 Marks use only Numeric Value');
				}else if(parseFloat(intv1_mark) < 0.00){
					e_error = 1;
					$('.intv1_mark').html('Interview 1 Marks never lower than 0');
				}else if(parseFloat(intv1_mark) > 10.00){
					e_error = 1;
					$('.intv1_mark').html('Interview 1 Marks never greater than 10');
				}else{
					$('.intv1_mark').html('');
				}
			}

			if(intv2_mark == ""){
				e_error = 1;
				$('.intv2_mark').html('Interview 2 Marks is Required');
			}else{
				if (!intv2_mark.match(onlynumerics_withdot)) {
					e_error = 1;
					$('.intv2_mark').html('Interview 2 Marks use only Numeric Value');
				}else if(parseFloat(intv2_mark) < 0.00){
					e_error = 1;
					$('.intv2_mark').html('Interview 2 Marks never lower than 0');
				}else if(parseFloat(intv2_mark) > 5.00){
					e_error = 1;
					$('.intv2_mark').html('Interview 2 Marks never greater than 5');
				}else{
					$('.intv2_mark').html('');
				}
			}

		}else{
			$('.intv_lang').html('');
			$('.intv1_mark').html('');
			$('.intv2_mark').html('');
		}
			
		
		if (e_error == 1) {
			$('.div_roller_total_2').fadeOut();
			$('#pa_target_submit').prop('disabled', false);
			$('.get_error_total_2').html(error_message);
			$(".get_error_total_2").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total_2').fadeOut();
			}, delay);
		} else {
			//alert("reached");
			//exit;
			$("#form123").submit();
			/*var form_data = new FormData();
			form_data.append("advno", advno);
			form_data.append("advcat_name", advcat_name);
			form_data.append("venueno", venueno);
			form_data.append("u_startdate", u_startdate);
			form_data.append("shift_name", shift_name);
			form_data.append("table_exactno", table_exactno);
			//form_data.append("files", files[0]);
			for(var iicntset = 0; iicntset<candset_all.length; iicntset++){
				var zintv_id = $('input[name="intv_id_'+iicntset+'"]').val();
				var zintv_regno = $('input[name="intv_regno_'+iicntset+'"]').val();
				var zatten_intv = $('input[name="atten_intv_'+candset_all[iicntset].invw_id+'"]:checked').val();
				var zintv_lang = $('input[name="intv_lang_'+candset_all[iicntset].invw_id+'"]:checked').val();
				var zintv1_mark = $('input[name="intv1_mark_'+candset_all[iicntset].invw_id+'"]').val();
				var zintv2_mark = $('input[name="intv2_mark_'+candset_all[iicntset].invw_id+'"]').val();
				form_data.append('intvsetid[]', zintv_id);
				form_data.append('intvregno[]', zintv_regno);
				form_data.append('invw_atten[]', zatten_intv);
				form_data.append('invw_lang[]', zintv_lang);
				if(zatten_intv == 'Yes'){
					form_data.append('invw1[]', zintv1_mark);
					form_data.append('invw2[]', zintv2_mark);
				}else{
					form_data.append('invw1[]', 0);
					form_data.append('invw2[]', 0);
				}
				
			}
			
			$.ajax({
				method: 'POST',
				url: '<?php //echo base_url() . "admincontrol/movement/update_tablecandidates_marks"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total_2').fadeOut();
						$('.get_success_total_2').html('Interview Marks is Updated Successfully.');
						$(".get_success_total_2").fadeIn();
						$('input, select').val('');
						$('input').html('');
						setTimeout(function() {
							$('.get_success_total_2').fadeOut();
						}, 3000);
						setTimeout(function() {
							window.location.replace("<?php echo site_url('admincontrol/movement/gotoset_candidate_marks_tablewise') ?>");
						}, 3000);

					} else {
						$('.div_roller_total_2').fadeOut();
						$('#pa_target_submit').prop('disabled', false);
						error_message = "There have some problem to Store Data, Try after some time.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total_2').html(error_message);
						$(".get_error_total_2").fadeIn();
						setTimeout(function() {
							$('.get_error_total_2').fadeOut();
						}, delay);
					}

				}
			});*/

		}


	}

    </script>