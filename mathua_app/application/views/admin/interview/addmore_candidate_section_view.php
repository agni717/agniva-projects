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
		  		ADD - Interview Candidate
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">ADD - Interview Candidate</li>
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
					<div class="col-sm-offset-1 col-sm-4">
						<label>Advertisement No. :</label><br/>
						<strong><?php echo $section_details->idm_adv_no; ?></strong>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Advertisement Category :</label><br/>
						<strong><?php echo $section_details->catm_name; ?></strong>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Shift Venue :</label><br/>
						<strong><?php echo $section_details->address_name; ?></strong>
					</div>
				</div>
				<div class="row" style="margin-top:20px;">	
					<div class="col-sm-offset-1 col-sm-4">
						<label>Interview Date :</label><br/>
						<strong><?php echo date('d-m-Y',strtotime($section_details->shift_date)); ?></strong>
					</div>
					<div class="col-sm-3">
						<label class="control-label">Shift Start time :</label><br/>
						<strong><?php echo date('h:i A',strtotime($section_details->shift_start_time)); ?></strong>
					</div>
					<div class="col-sm-2">
						<label class="control-label">Shift Start time :</label><br/>
						<strong><?php echo date('h:i A',strtotime($section_details->shift_end_time)); ?></strong>
					</div>
				</div>
				<div class="row" style="margin:20px 0;">	
					<div class="col-sm-4">
						<div class="text-center" style="font-size:20px;">
						<?php echo $addcand_no; ?> - Candidate Found For <?php echo $section_details->catm_name; ?>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="text-center" style="font-size:20px;">
							Total Table - <?php echo $section_details->idm_cat_tableno; ?>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="text-center" style="font-size:20px;">
						<?php $avlb_seat = (($section_details->idm_cat_tableno * $section_details->idm_shift_tab_each) - $cand_exist); ?>
						Available Seat - <?php echo $avlb_seat; ?>
						</div>
					</div>
				</div>
				<div class="row" style="margin:20px 0;">
				<div class="clearfix"></div>
				<div class="col-sm-offset-4 col-sm-4">
					<label>Total No. of Candidate for Interview</label>
					<input type="text" class="form-control" name="table_candidate" id="table_candidate" value="<?php echo $addcand_no; ?>" placeholder="No. of Candidate ADD" autocomplete="off" />
					<small class="text-error table_candidate"><?php echo form_error('table_candidate'); ?></small>
				</div>
				<div class="col-sm-12">
       				 <div class="form-group">	
					    <div align="center">
								<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						  </div>
				    </div>
                </div>
				<div class="col-sm-12 text-center">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
								<?php //if(!empty($total_checkinglist)){ ?>
									<!--<div class="row text-center" style="font-size:20px;">
									<div class="col-sm-12"><a href="" onclick="printData();" class="btn btn-lg btn-primary">PRINT</a></div>
									</div>-->
									
				  
				  <?php 
				//} ?>
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
	var allcategoryset = '';
    $(function () {
		$('#u_startdate, #u_enddate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
        $("#datatable_tab").dataTable();
    });

	function check_inv_cand(){
		var intcand_sec = $("input[name='intcand_sec']:checked").val();
		if(intcand_sec == "MM"){
            $(".second_cand_input").fadeIn();
			$(".cand_selection_no_lvl").html('Enter Minimum Marks');
		}else if(intcand_sec == "MV"){
			$(".second_cand_input").fadeIn();
			$(".cand_selection_no_lvl").html('Enter Multiply Number');
		}else{
            $(".second_cand_input").fadeOut();
			$("#cand_selection_no").val('');
		}
	}
	  
	function gotosubmit_catset() {
		$('.div_roller_total9').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		
		var venueno = $('#venueno option:selected').val();
		var shift_name = $('#shift_name option:selected').val();
		var advcat_name = $('#advcat_name option:selected').val();
		var advcat_table = $('#advcat_table').val();
		var table_stn = $('#table_stn').val();
		var advno = $("#advno option:selected").val();
		var adv_temp_intvno = $('#adv_temp_intvno').val();
		var tempo_candidate = 0;
		
		if (advno == "") {
			error_message = error_message + "<br/>Advertiment ID missing, Refresh the page";
		}
		if (adv_temp_intvno == "") {
			error_message = error_message + "<br/>AUTOGEN ID missing, Refresh the page";
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
		if (advcat_table == "") {
			e_error = 1;
			$('.advcat_table').html('Total Table is Required.');
		} else {
			if (!advcat_table.match(onlynumerics)) {
				e_error = 1;
				$('.advcat_table').html('Total Table only use numeric values, Check again.');
			} else if (parseInt(advcat_table) <= 0) {
				e_error = 1;
				$('.advcat_table').html('Total Table always greater than 0, Check again.');
			} else {
				$('.advcat_table').html('');
			}
		}

		if(table_stn == ""){
			e_error = 1;
			$('.table_stn').html('Each Table Strength is Required.');
		}else{
			if(!table_stn.match(onlynumerics)){
				e_error = 1;
				$('.table_stn').html('Each Table Strength only use Numeric Values, Check again.');
			} else if (parseInt(table_stn) <= 0) {
				e_error = 1;
				$('.table_stn').html('Each Table Strength always greater than 0, Check again.');
			}else{
				$('.table_stn').html('');
			}	
		}
		
		var alertcounter = 0;
		if(table_stn != "" && advcat_table != "" && advcat_name != ""){
			tempo_candidate = parseInt(table_stn) * parseInt(advcat_table);
			if(allcategoryset[advcat_name] > tempo_candidate){
				alertcounter++;
				if (confirm("There have Some Candidate Left for Call letter Generation. Do you want to Continue...?")) {
					alertcounter = 0;
				}
			}
		}

		if (alertcounter == 0) {
			
			if (e_error == 1) {
				$('.div_roller_total9').fadeOut();
				$('.get_error_total9').html(error_message);
				$(".get_error_total9").fadeIn();
				$(".text-error").fadeIn();
				setTimeout(function() {
					$('.text-error, .get_error_total9').fadeOut();
				}, delay);
			} else {
				//alert("Reached");exit();
				var form_data = new FormData();
				form_data.append('advno', advno);
				form_data.append('adv_temp_intvno', adv_temp_intvno);
				form_data.append('venueno', venueno);
				form_data.append('shift_name', shift_name);
				form_data.append('advcat_name', advcat_name);
				form_data.append('advcat_table', advcat_table);
				form_data.append('table_stn', table_stn);
				//form_data.append("files", files[0]);
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/interview/new_category_submission_adv_v2"; ?>',
					data: form_data,
					dataType: 'JSON',
					contentType: false,
					processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total9').fadeOut();
							$('.get_success_total9').html('Post is Added in the List Successfully.');
							$(".get_success_total9").fadeIn();
							var expr_string = '<tr class="expset_' + data.cat_set.idm_id + '"><td>' + data.cat_set.address_name + '</td><td>' + data.cat_set.shift_date + ' (' +data.cat_set.shift_start_time+' To '+data.cat_set.shift_end_time+ ')</td><td>' + data.cat_set.catm_name + '</td><td>' + data.cat_set.idm_cat_tableno + '</td><td>' + data.cat_set.idm_shift_tab_each + '</td><td><a href="javascript:;" onclick="gotodelete_cats(' + data.cat_set.idm_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
							$('.expr_setvalue').append(expr_string);
							var category_counter = $('#catg_counter').val();
							category_counter = Number(category_counter) + 1;
							$('#catg_counter').val(category_counter);
							$('#advcat_table, #table_stn, #venueno').val('');
							$('#shift_name').html('<option value="">---Select---</option>');
							$('#shift_name').prop('disabled', true);
							setTimeout(function() {
								$('.get_success_total9').fadeOut();
							}, 3000);

						} else {
							$('.div_roller_total9').fadeOut();
							//error_message = "There have some problem to Store Data, Try after some time.";
							error_message = data.e_msg;
							$('.get_error_total9').html(error_message);
							$(".get_error_total9").fadeIn();
							setTimeout(function() {
								$('.get_error_total9').fadeOut();
							}, delay);
						}

					}
				});
			}

		}else{
			$('.div_roller_total9').fadeOut();
		}
	}

	function gotodelete_cats(exid) {
		if (exid != "") {
			var conf_answer = confirm("You are about to Delete a record. Are you sure?")
			if (conf_answer) {
				$('.div_roller_total9').fadeIn();
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/interview/delete_catset_update"; ?>',
					data: {
						qid: exid
					},
					dataType: 'JSON',
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {
							//console.log(data);
							//alert(data.msg[0].option_set);
							$('.div_roller_total9').fadeOut();
							$('.get_success_total9').html('Category is Deleted Successfully.');
							$(".get_success_total9").fadeIn();
							var category_counter = $('#catg_counter').val();
							category_counter = Number(category_counter) - 1;
							$('#catg_counter').val(category_counter);
							$(".expset_" + exid).remove();
							setTimeout(function() {
								$('.get_success_total9').fadeOut();
							}, 3000);
						} else {
							$('.div_roller_total9').fadeOut();
							error_message = "There have some problem to Update Data, Try again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total9').html(error_message);
							$(".get_error_total9").fadeIn();
							setTimeout(function() {
								$('.get_error_total9').fadeOut();
							}, 3000);
						}

					}
				});
			}
		}
	}
		
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
						$(".gotocand_chcek").fadeOut();
						$('#advcat_table').val('');
						$('#advcat_name').html('<option value="">---Select---</option>');
						$('#advcat_name, #advcat_table, #pa_target_submit, #venueno').prop('disabled', true);
						$('#catsetbutton').attr('disabled', true);
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
			$(".gotocand_chcek").fadeOut();
			$('#advcat_table').val('');
			$('#advcat_name').html('<option value="">---Select---</option>');
			$('#advcat_name, #advcat_table, #pa_target_submit, #venueno').prop('disabled', true);
			$('#catsetbutton').attr('disabled', true);
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
		
		var rf_set = $("#rf_set option:selected").val();
		var advno = $("#advno option:selected").val();
		if(rf_set != "" && advno != ""){
			var form_data = new FormData();
			form_data.append("rf_set", rf_set);
			form_data.append("advno", advno);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_allcandidate_forpanel_setup') ?>",
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
						if(parseInt(data.op_set) > 0){
							$('#advcat_name').html(data.category_set);
							allcategoryset = data.category_array;
							//alert(data.category_array[142]);
							$('#advcat_table, #table_stn').val('');
							$('.gotocand_chcek').html("Total - " + data.op_set + " - Record Found For Interview Call Letter" + data.item_set);
							$(".gotocand_chcek").fadeIn();
							$('#advcat_name, #advcat_table, #table_stn, #pa_target_submit, #venueno').prop('disabled', false);
							$('#catsetbutton').attr('disabled', false);
						}else{
							$('#advcat_name').html('<option value="">---Select---</option>');
							$('#advcat_table, #table_stn').val('');
							$('.gotocand_chcek').html("No Record Found For Interview Call Letter");
							$(".gotocand_chcek").fadeIn();
							$('#advcat_name, #advcat_table, #table_stn, #pa_target_submit, #venueno, #shift_name').prop('disabled', true);
							$('#catsetbutton').attr('disabled', true);
						}
					}else{
						$('.div_roller_total').fadeOut();
						$('#advcat_name').html('<option value="">---Select---</option>');
						$('#advcat_table, #table_stn').val('');
						$('.gotocand_chcek').html("");
						$(".gotocand_chcek").fadeOut();
						$('#advcat_name, #advcat_table, #table_stn, #pa_target_submit, #venueno, #shift_name').prop('disabled', true);
						$('#catsetbutton').attr('disabled', true);
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}else{
			$('.div_roller_total').fadeOut();
			$(".gotocand_chcek").fadeOut();
			$('#advcat_table, #table_stn').val('');
			$('#advcat_name').html('<option value="">---Select---</option>');
			$('#advcat_name, #advcat_table, #table_stn, #pa_target_submit, #venueno, #shift_name').prop('disabled', true);
			$('#catsetbutton').attr('disabled', true);
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
		
		var section_id = '<?php echo $section_details->idm_id; ?>';
		var advno = '<?php echo $section_details->idm_adv_no; ?>';
		var addmore_cand = '<?php echo $addcand_no; ?>';
		var availble_seat = '<?php echo $avlb_seat; ?>';
		var table_candidate = $('#table_candidate').val();
	
		if (addmore_cand == "" || parseInt(addmore_cand) <= 0) {
			e_error = 1;
			error_message = error_message + "<br/>Candidate Count is missing, Check Again.";
		}
		if (availble_seat == "" || parseInt(availble_seat) <= 0) {
			e_error = 1;
			error_message = error_message + "<br/>Candidate Seat Availability is not found, Check Again.";
		}
		if (section_id == "") {
			e_error = 1;
			error_message = error_message + "<br/>TABLE ID missing, Refresh the page";
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

		if(table_candidate == ""){
			e_error = 1;
			$('.table_candidate').html('Candidate for Interview is Required.');
		}else{
			if(!table_candidate.match(onlynumerics)){
				e_error = 1;
				$('.table_candidate').html('Candidate for Interview only use Numeric Values, Check again.');
			}else if(parseInt(table_candidate) <= 0){
				e_error = 1;
				$('.table_candidate').html('Candidate for Interview always greater than 0, Check again.');
			}else{
				$('.table_candidate').html('');
			}	
		}

		if(table_candidate != "" && addmore_cand != "" && availble_seat != ""){
			//var addcand_set = parseInt(addmore_cand);
			//var addcand_new = parseInt(table_candidate);
			if(parseInt(table_candidate) > parseInt(addmore_cand)){
				e_error = 1;
				error_message = error_message + "<br/>Candidate for Interview never cross the Existing No. of Candidate, Check Again.";
			}else if(parseInt(table_candidate) > parseInt(availble_seat)){
				e_error = 1;
				error_message = error_message + "<br/>Candidate Seat not Available for this Shift, Check Again.";
			}
		}

		/*if(venueno == ""){
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
		}*/
			
		//alert(salts);
		/*if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			$("#form123").submit();
		}*/
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
			//form_data.append('exam_gen',exam_gen);
			form_data.append('section_id', section_id);
			form_data.append('advno', advno);
			form_data.append('table_candidate', table_candidate);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/interview/addmore_interviewsets_submission"; ?>',
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
							window.location.replace("<?php echo site_url('admincontrol/interview/addmore_candidates_forexisting') ?>");
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
						$('#shift_name').html(data.op_set);
						$('#shift_name').prop('disabled', false);

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

	function goto_check_totaltab222222222222222(){
		var venueno = $('#venueno option:selected').val();
		if(venueno != ""){
			var form_data = new FormData();
			form_data.append("venueno", venueno);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/interview/get_venue_details') ?>",
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
						$('#max_table_set').val(data.op_set);
						$('.gototable_chcek').html(data.op_set + " - Table Available in the Venue");
						$(".gototable_chcek").fadeIn();
					}else{
						//$('.div_roller_total').fadeOut();
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
						$('#max_table_set').val('');
						$('.gototable_chcek').html('');
						$(".gototable_chcek").fadeOut();
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#max_table_set').val('');
			$('.gototable_chcek').html('');
			$(".gototable_chcek").fadeOut();
		}
	}
    </script>