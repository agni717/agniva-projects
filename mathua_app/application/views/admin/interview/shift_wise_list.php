<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input {max-width: 500px;}
.box-body textarea { resize: vertical; }
.ui-datepicker table{ border:1px solid #000; }
</style>
<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>
        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Interview Shiftwise Candidate list
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Interview Shiftwise Candidate list</li>
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
				<div class="box-body">
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
					<?php echo form_open_multipart('','class="" id="form123"'); ?>
				<div class="row">
				<div class="col-sm-offset-1 col-sm-5">
				  <div class="form-group">
					<label>Recruitment For</label>
					  <select class="form-control selectpicker" name="rf_set" id="rf_set" autocomplete="off" onchange="goto_rec_search();">
						<option value="">---Select---</option>
						<?php foreach($rec_list as $recs){ ?>
						<option value="<?php echo $recs->rm_id; ?>" <?php if(!empty($searchlist['rf_setid'])){ if($searchlist['rf_setid'] == $recs->rm_id){echo 'selected="selected"';}} ?>><?php echo $recs->rm_name; ?></option>
						<?php } ?>
				      </select>
				      <small class="text-error rf_set"><?php echo form_error('rf_set'); ?></small>
				  </div>
				</div>
				<div class="col-sm-5">
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" <?php if(empty($searchlist['advno'])){echo 'disabled';} ?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['advno'])){ 
							foreach($adv_catg as $cats){ ?>
								<option value="<?php echo $cats->adv_auto_genno; ?>" <?php if($searchlist['advno'] == $cats->adv_auto_genno){echo 'selected="selected"';} ?>><?php echo $cats->adv_no; ?></option>
							<?php }} ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				
				<div class="clearfix"></div>
				<div class="col-sm-offset-1 col-sm-2">
					<div class="form-group">
					<label class="control-label">Interview Date</label>
				    <input type="text" class="form-control" name="u_startdate" id="u_startdate" placeholder="Enter Start Date" value="<?php if(!empty(set_value('u_startdate'))){echo set_value('u_startdate');}else{echo date('d-m-Y');} ?>" autocomplete="off" onchange="goto_check_totaltab();" />
				    <small class="text-error u_startdate"><?php echo form_error('u_startdate'); ?></small>
					</div>
				</div>
				<div class="col-sm-4">
				  <div class="form-group">
					<label>Venue</label>
					  <select class="form-control selectpicker" name="venueno" id="venueno" autocomplete="off" onchange="goto_check_totaltab();">
							<option value="">---Select---</option>
							<?php foreach($vn_list as $vnss){ ?>
								<option value="<?php echo $vnss->address_id; ?>" <?php if(!empty($searchlist['venueno'])){if($searchlist['venueno'] == $vnss->address_id){echo 'selected="selected"';}} ?>><?php echo $vnss->address_name; ?></option>
							<?php } ?>
					  </select>
				      <small class="text-error venueno"><?php echo form_error('venueno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
				  	<label class="control-label">Interview Shift</label>
					<select class="form-control" name="shift_name" id="shift_name" autocomplete="off" <?php if(empty($searchlist['shift_name'])){echo "disabled";}?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['shift_name'])){ 
							foreach($shift_details as $sfsets){ ?>
								<option value="<?php echo $sfsets->shift_id; ?>" <?php if($searchlist['shift_name'] == $sfsets->shift_id){echo 'selected="selected"';} ?>><?php echo $sfsets->shift_name.' ('.date('h:i A',strtotime($sfsets->shift_start_time)).' To '.date('h:i A',strtotime($sfsets->shift_end_time)).')'; ?></option>
							<?php }} ?>
					</select>
					<small class="text-error shift_name"><?php echo form_error('shift_name'); ?></small>
				    </div>
				</div>
				<div class="clearfix"></div>
				
				<div class="col-sm-12">
       				 <div class="form-group">	
					    <div align="center">
								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						  </div>
				    </div>
                </div>
				<div class="col-sm-12 text-center" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
								<?php if(!empty($total_checkinglist)){ ?>
									<div class="row text-right" style="font-size:20px;">
									<div class="col-sm-12"><a href="<?php echo base_url().'admincontrol/interview/candidate_attendancce_shiftwise_printdata_set/'.$searchlist['advno'].'/'.$searchlist['shift_name']; ?>" target="_blank" class="btn btn-primary">PRINT Data</a></div>
									</div>
									
				  <div class="table-responsive" id="psetsss">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
					  		<td>Sl. No.</td>
					  		<td>Candidate Reg No.</td>
							<td>Candidate Name</td>
							<td>Candidate Email</td>
					  </thead>
                  	<tbody>
                  		<?php
						  foreach($total_checkinglist as $keys=>$users)
                  		{ ?>
                  		<tr>
						  	<td><?php echo ($keys + 1); ?></td>
                  			<td><?php echo $users->f_application_no; ?></td>
							<td><?php echo $users->f_full_name; ?></td>
							<td><?php echo $users->f_email; ?></td>
                  		</tr>	
						<?php } ?>
                  	</tbody>
                  </table>
				  </div>
				  <?php 
				} ?>
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
	//var slagsetno = 3;
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

	function goto_submit_button(){
		$('.div_roller_total').fadeIn();
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
		
		var u_startdate = $('#u_startdate').val();
		var rf_set = $('#rf_set option:selected').val();
		var advno = $("#advno option:selected").val();
		//var advcat_name = $('#advcat_name option:selected').val();
		var venueno = $('#venueno option:selected').val();
		var shift_name = $('#shift_name option:selected').val();
		//var table_exactno = $('#table_exactno option:selected').val();

		if(rf_set == ""){
			e_error = 1;
			$('.rf_set').html('Recruitment For is Required.');
		}else{
			if(!rf_set.match(onlynumerics)){
				e_error = 1;
				$('.rf_set').html('Recruitment For only use Numeric Values, Check again.');
			}else{
				$('.rf_set').html('');
			}	
		}
		
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
		/*if (advcat_name == "") {
			e_error = 1;
			$('.advcat_name').html('Adv. category is Required.');
		} else {
			if (!advcat_name.match(onlynumerics)) {
				e_error = 1;
				$('.advcat_name').html('Adv. category only use Numeric values, Check again.');
			} else {
				$('.advcat_name').html('');
			}
		}*/

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
		/*if (table_exactno == "") {
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
		if(table_stn == ""){
			e_error = 1;
			$('.table_stn').html('Each Table Strength is Required.');
		}else{
			if(!table_stn.match(onlynumerics)){
				e_error = 1;
				$('.table_stn').html('Each Table Strength only use Numeric Values, Check again.');
			}else{
				$('.table_stn').html('');
			}	
		}*/

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
			//alert("reached");
			//exit;
			$("#form123").submit();
			/*var form_data = new FormData();
			//form_data.append('exam_gen',exam_gen);
			form_data.append('has_cand_main', has_cand_main);
			form_data.append('intcand_sec', intcand_sec);
			form_data.append('cand_selection_no', cand_selection_no);
			form_data.append('u_startdate', u_startdate);
			form_data.append('u_starttime', u_starttime);
			form_data.append('u_endtime', u_endtime);
			form_data.append('table_stn', table_stn);
			form_data.append('venueno', venueno);
			form_data.append('rf_set', rf_set);
			form_data.append('advno', advno);
			form_data.append('adv_temp_intvno', adv_temp_intvno);
			form_data.append('catg_counter', catg_counter);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/interview/new_interviewsets_submission"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Interview Panel is Generated Successfully.');
						$(".get_success_total").fadeIn();
						$('input, select').val('');
						$('input').html('');
						setTimeout(function() {
							$('.get_success_total').fadeOut();
						}, 3000);
						setTimeout(function() {
							window.location.replace("<?php echo site_url('admincontrol/interview/interview_panelcandidate_segrigation') ?>");
						}, 3000);

					} else {
						$('.div_roller_total').fadeOut();
						$('#pa_target_submit').prop('disabled', false);
						error_message = "There have some problem to Store Data, Try after some time.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function() {
							$('.get_error_total').fadeOut();
						}, delay);
					}

				}
			});
			*/
		}


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
						//$('#table_exactno').html('<option value="">---Select---</option>');
						//$('#table_exactno').prop('disabled', true);

					}else{
						//$('.div_roller_total').fadeOut();
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						$('#shift_name').html('<option value="">---Select---</option>');
						$('#shift_name').prop('disabled', true);
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
						
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#shift_name').html('<option value="">---Select---</option>');
			$('#shift_name').prop('disabled', true);
		}
	}


    </script>