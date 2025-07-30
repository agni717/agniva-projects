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
		  		Candidate - Final Panel List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate Final Panel List</li>
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
				<div class="col-sm-3">
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
				<div class="col-sm-3">
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" <?php if(empty($searchlist['advno'])){echo 'disabled';} ?> onchange="gotopanel_candidate_search();">
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['advno'])){ 
							foreach($adv_catg as $cats){ ?>
								<option value="<?php echo $cats->adv_auto_genno; ?>" <?php if($searchlist['advno'] == $cats->adv_auto_genno){echo 'selected="selected"';} ?>><?php echo $cats->adv_no; ?></option>
							<?php }} ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
				  <div class="form-group">
					<label>Category</label>
					  <select class="form-control selectpicker" name="advcat_name" id="advcat_name" autocomplete="off" <?php if(empty($searchlist['advcat_name'])){echo 'disabled';} ?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['advcat_name'])){ 
							foreach($adv_category as $advcats){ ?>
								<option value="<?php echo $advcats->acat_id; ?>" <?php if($searchlist['advcat_name'] == $advcats->acat_id){echo 'selected="selected"';} ?>><?php echo $advcats->catm_name; ?></option>
							<?php }} ?>
					  </select>
				      <small class="text-error advcat_name"><?php echo form_error('advcat_name'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
				  <div class="form-group">
					<label>Listing For</label>
					  <select class="form-control selectpicker" name="gen_set" id="gen_set" autocomplete="off">
						<option value="">---Select---</option>
						<?php foreach($section_list as $secitems){ ?>
						<option value="<?php echo $secitems->vm_id; ?>" <?php if(!empty($searchlist['gen_set'])){ if($searchlist['gen_set'] == $secitems->vm_id){echo 'selected="selected"';}} ?>><?php echo $secitems->caste_name; ?></option>
						<?php } ?>
				      </select>
				      <small class="text-error gen_set"><?php echo form_error('gen_set'); ?></small>
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
				<div class="clearfix"></div>
				<div class="col-sm-12 text-center">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
					<?php if(!empty($meritlist)){ ?>

									<div class="row text-center" style="font-size:20px;">
									<div class="col-sm-12"><a href="<?php echo base_url('admincontrol/finalpanel/partial_finalpanel_setsection_lists/'.$searchlist['advno'].'/'.$searchlist['advcat_name'].'/'.$searchlist['gen_set']); ?>" target="_blank" class="btn btn-lg btn-primary">PRINT Partially</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admincontrol/finalpanel/htmlview_the_finalpanel_set2_section_lsits_sqlsets/'.$searchlist['advno'].'/'.$searchlist['advcat_name'].'/'.$searchlist['gen_set']); ?>" target="_blank" class="btn btn-lg btn-primary">PRINT 2 COPY</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('admincontrol/finalpanel/print_the_finalpanel_set2_section_lsits/'.$searchlist['advno'].'/'.$searchlist['advcat_name'].'/'.$searchlist['gen_set']); ?>" target="_blank" class="btn btn-lg btn-primary">PRINT 2</a>&nbsp;&nbsp;&nbsp;
									<a href="<?php echo base_url('admincontrol/finalpanel/print_the_finalpanel_lsitsets/'.$searchlist['advno'].'/'.$searchlist['advcat_name'].'/'.$searchlist['gen_set']); ?>" target="_blank" class="btn btn-lg btn-primary">PRINT</a></div>
									</div>
									
							<table class="table table-striped" id="datatable_tab123" width="100%">
								<thead style="font-weight: bold;">
										<td>Sl No.</td>
										<td>Full Name</td>
										<td>Registration No.</td>
										<td>Date of Birth</td>
										<td>Caste</td>
										<td>PWD</td>
										<td>Full Marks</td>
								</thead>
								<tbody>
									<?php foreach($meritlist as $keys=>$quaries)
									{ ?>
									<tr>
										<td><?php echo $keys+1; ?></td>
										<td><?php echo $quaries->f_full_name; ?></td>
										<td><?php echo $quaries->f_application_no; ?></td>
										<td><?php echo date('d-F-Y',strtotime($quaries->fu_dob)); ?></td>
										<td><?php echo $quaries->caste_name; ?></td>
										<td><?php echo $quaries->fu_pwd; ?></td>
										<td><?php echo $quaries->cr_total_marks; ?></td>
										<!--<td><?php //echo date('d-m-Y',strtotime($quaries->mr_createdate)); ?></td>-->
									</tr>	
									<?php } ?>
								</tbody>
							</table>

				  	<?php } ?>
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
						$('#advno, #pa_target_submit').prop('disabled', false);
						$('#advcat_name').html('<option value="">---Select---</option>');
						$('#advcat_name').prop('disabled', true);
						
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
			$('#advcat_name, #advcat_table, #venueno').prop('disabled', true);
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
				url: "<?php echo site_url('admincontrol/finalpanel/get_allcandidate_forpanel_setup') ?>",
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
						$('#advcat_name').html(data.category_set);
						//alert(data.category_array[142]);
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
		
		//var has_cand_main = $("input[name='has_cand_main']:checked").val();
		//var intcand_sec = $("input[name='intcand_sec']:checked").val();
		//var cand_selection_no = $('#cand_selection_no').val();
		//var u_startdate = $('#u_startdate').val();
		//var u_starttime = $('#u_starttime').val();
		//var u_endtime = $('#u_endtime').val();
		//var table_stn = $('#table_stn').val();
		//var venueno = $('#venueno option:selected').val();
		var rf_set = $('#rf_set option:selected').val();
		var advno = $("#advno option:selected").val();
		var advcat_name = $('#advcat_name option:selected').val();
		var gen_set = $("#gen_set option:selected").val();
		
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
				$('.advno').html('Advertisement No. only use AlphaNumeric Values, Check again.');
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
		
		if(gen_set == ""){
			e_error = 1;
			$('.gen_set').html('Generate is Required.');
		}else{
			if(!gen_set.match(onlynumerics)){
				e_error = 1;
				$('.gen_set').html('Generate for only use Numeric Values, Check again.');
			}else{
				$('.gen_set').html('');
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

		/*if(u_enddate == ""){
			e_error = 1;
			$('.u_enddate').html('End Date is Required.');
		}else{
			if(isDatecheck_dmY(u_enddate) == false){
				e_error = 1;
				$('.u_enddate').html('End Date Format check properly.');
			}else{
				$('.u_enddate').html('');
			}
		}
		if(u_starttime == ""){
			e_error = 1;
			$('.u_starttime').html('Shift Start Time is Required.');
		}else{
			$('.u_starttime').html('');
		}
		if(u_endtime == ""){
			e_error = 1;
			$('.u_endtime').html('Shift End Time is Required.');
		}else{
			$('.u_endtime').html('');
		}
		
		if(u_startdate != "" && u_starttime != "" && u_endtime != ""){
			var valuestart = check_timeall(u_starttime);
			var valuestop = check_timeall(u_endtime);
			//var task_start_date_update = task_start_date.replace(/-/g, "/");
			//var task_end_date_update = task_end_date.replace(/-/g, "/");
			var newDate = u_startdate.split("-");
			var newDateend = u_startdate.split("-");
			var task_work_date_update = newDate[2] + '-' + newDate[1] + '-' + newDate[0];
			var task_work_date_update_end = newDateend[2] + '-' + newDateend[1] + '-' + newDateend[0];
			var timediff = new Date(task_work_date_update_end + "T" + valuestop) - new Date(task_work_date_update + "T" + valuestart);
			var timediff = (timediff/1000);
			var hourDiff = (timediff/3600);
			var minuteDiff = (timediff - (hourDiff * 3600));
			if(hourDiff < 0){
				e_error = 1;
				error_message = error_message + '<br/>Shift Start Time and Shift End Time have some problem, check Properly.';
			}else if(hourDiff == 0){
				if(minuteDiff <= 0){
					e_error = 1;
					error_message = error_message + '<br/>Shift Start Time and Shift End Time have some problem, check Properly.';
				}
			}else{
				if(minuteDiff < 0){
					hourDiff = hourDiff - 1;
					var totalminutes = (hourDiff * 60) + (60 + minuteDiff);
				}else{
					var totalminutes = (hourDiff * 60) + minuteDiff;
				}
				//alert(totalminutes);
				if(totalminutes <= 0){
					e_error = 1;
					error_message = error_message + '<br/>Check the total Shift timing.';
				}
			}
		}*/
			
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('#pa_target_submit').prop('disabled', false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(task_start_time);exit;
			//alert(rehash);
			$("#form123").submit();
		}
		/*if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('#pa_target_submit').prop('disabled', false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} else {
			var form_data = new FormData();
			//form_data.append('exam_gen',exam_gen);
			form_data.append('has_cand_main', has_cand_main);
			form_data.append('intcand_sec', intcand_sec);
			form_data.append('cand_selection_no', cand_selection_no);
			form_data.append('u_startdate', u_startdate);
			//form_data.append('u_starttime', u_starttime);
			//form_data.append('u_endtime', u_endtime);
			//form_data.append('table_stn', table_stn);
			//form_data.append('venueno', venueno);
			form_data.append('rf_set', rf_set);
			form_data.append('advno', advno);
			form_data.append('adv_temp_intvno', adv_temp_intvno);
			form_data.append('catg_counter', catg_counter);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php //echo base_url() . "admincontrol/interview/new_interviewsets_submission_v2"; ?>',
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
							window.location.replace("<?php //echo site_url('admincontrol/interview/interview_panelcandidate_segrigation') ?>");
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
			
		}*/


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