<?php $this->load->view('admin/component/header') ?>

<!--<link rel="stylesheet" href="<?php //echo base_url('bootstrap-admin/bootstrap/css/bootstrap-multiselect.css'); ?>">-->

<?php //$this->load->view('admin/component/menu') ?>

<?php
	// echo '<pre>';
	// print_r($scheme_details_data);
	// echo $scheme_master_data->scm_name;
?>
<style>
	.text-error { color: red;}
</style>


<div class="home pb-5">
   <div class="container">
      <div class="row">
         <div class="col-lg-10 m-auto" >
            <div class="widget-area-2 proclinic-box-shadow">
               <h3 class="widget-title">Scheme Creation</h3>
               <?php echo form_open_multipart('', 'class="form-horizontal" id="myForm"'); ?>
					<?php if (isset($error)) { ?>
					<div class="alert alert-error alert-danger">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
                  <fieldset class="scheduler-border">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-row control-group">
                              <div class="form-group col-lg-12">
                                 <label>Scheme Name</label>
                                 <input type="text" class="form-control" name="sc_name" id="sc_name" placeholder="Enter Scheme Name" autocomplete="off" value="<?php echo $scheme_master_data->scm_name; ?>"/>
								 <small class="text-error sc_name"><?php echo form_error('sc_name'); ?></small>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Scheme Details</label>
                                 <textarea class="form-control" name="sc_detail" id="sc_detail" rows="2" placeholder="Enter Scheme Details" autocomplete="off"><?php echo $scheme_master_data->scm_details; ?></textarea>
								 <small class="text-error sc_detail"><?php echo form_error('sc_detail'); ?></small>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Scheme Amount</label>
                                 <input type="text" class="form-control" name="sc_amount" id="sc_amount" placeholder="Enter Scheme Amount" autocomplete="off" value="<?php echo $scheme_master_data->scm_amount; ?>"/>
								 <small class="text-error sc_amount"><?php echo form_error('sc_amount'); ?></small>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Number of Installment</label>
                                 <input type="text" class="form-control" name="sc_installment_no" id="sc_installment_no" placeholder="Enter Scheme Amount" autocomplete="off" value="<?php echo $scheme_master_data->scm_installment_no; ?>"/>
								 <small class="text-error sc_installment_no"><?php echo form_error('sc_installment_no'); ?></small>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Reference Number</label>
                                 <input type="text" class="form-control" name="sc_ref_no" id="sc_ref_no" placeholder="Enter Scheme Reference Number" autocomplete="off" value="<?php echo $scheme_master_data->scm_ref_no; ?>"/>
								 <small class="text-error sc_ref_no"><?php echo form_error('sc_ref_no'); ?></small>
                              </div>
                              <div class="form-group col-lg-12">
                                 <label>Date</label>
                                 <input type="date" class="form-control" name="sc_date" id="sc_date" autocomplete="off" value="<?php echo $scheme_master_data->scm_date; ?>"/>
								 <small class="text-error sc_date"><?php echo form_error('sc_date'); ?></small>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="col-lg-12 form-group"><label>Scheme Wise Amount Allotment </label></div>
                           <div class="col-lg-12">
                              <div class="row">
								<div class="col-lg-12">
									<div style="padding:15px;border: #aaa 1px solid;">
										<table class="slav_tabs">
											<tr>
												<th></th>
												<th class="form-group"><label>Percentage Work</label></th>
												<th class="form-group"><label>Percentage Pay</label></th>
												<th>&nbsp;</th>
											</tr>
											<?php
											foreach($scheme_details_data as $details_data)
											{
												?>
												<tr class="slav_set_1">
													<td><input type="hidden" class="form-control" name="q_slnum[]" id="q_slnum1" value="<?php echo $details_data->scd_inst_no ?>" /><?php echo $details_data->scd_inst_no ?></td>
													<td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" value="<?php echo $details_data->scd_percent_work ?>"/></td>
													<td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" value="<?php echo $details_data->scd_percent_amount ?>"/></td>
													<!-- <td>&nbsp;</td> -->
												</tr>
												<?php	
											}
											?>
										</table>
										<div class="row">
											<small class="text-error sc_percentage_error"><?php echo form_error('sc_percentage_error'); ?></small>
										</div>
										<div class="row">
											<div class="col-sm-2">
												<!-- <a href="javascript:;" class="btn btn-warning" id="quali_slavbutton" onclick="gotoadd_slav();">Add More</a> -->
											</div>
										</div>
									</div>
								</div>
                                 <!--<div class="col-lg-3">
                                    <div class="col-lg-12">
                                       <label>Percentage</label>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-9 col-sm-9">
                                          <div class="box_area text-center">10</div>
                                       </div>
                                       <div class="col-lg-3 col-sm-3">%</div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="row">
                                       <label>Details</label>
                                    </div>
                                    <div class="row">
                                       <input type="text" placeholder="Advance" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-lg-3 mt-2">
                                    <label></label>
                                    <input type="button" value="Add More" class="btn btn-info">
                                 </div>-->
                              </div>
                           </div>
                           <!--<div class="col-lg-12">
                              <div class="row">
                                 <div class="col-lg-3">
                                    <div class="col-lg-12">
                                       <label>Percentage</label>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-9 col-sm-9">
                                          <div class="box_area text-center">40</div>
                                       </div>
                                       <div class="col-lg-3 col-sm-3">%</div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="row">
                                       <label>Details</label>
                                    </div>
                                    <div class="row">
                                       <input type="text" placeholder="Advance" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-lg-3 mt-2">
                                    <label></label>
                                    <input type="button" value="Add More" class="btn btn-info">
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="row">
                                 <div class="col-lg-3">
                                    <div class="col-lg-12">
                                       <label>Percentage</label>
                                    </div>
                                    <div class="row">
                                       <div class="col-lg-9 col-sm-9">
                                          <div class="box_area text-center">100</div>
                                       </div>
                                       <div class="col-lg-3 col-sm-3">%</div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="row">
                                       <label>Details</label>
                                    </div>
                                    <div class="row">
                                       <input type="text" placeholder="Advance" class="form-control">
                                    </div>
                                 </div>
                              </div>
                           </div>-->
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
							<!-- <div class="col-sm-12">
								<button type="button" onclick="gotoclclickbutton();" class="btn btn-primary gofinalsubmit">Submit</button>
								&nbsp;<a href="<?php //site_url('admincontrol/advertisement_set/all_advertisement_list') ?>" class="btn btn-danger">Cancel</a>
							</div> -->
						</div>
                     </div>
                  </fieldset>
                <?php form_close(); ?>
            </div>
         </div>
      </div>
   </div>
</div>


<?php $this->load->view('admin/component/footer') ?>
<!--<script src="<?php //echo base_url('bootstrap-admin/bootstrap/js/bootstrap-multiselect.js'); ?>"></script>-->
<script type="text/javascript">
	var slagno = 2;
	//var deductno = 2;
	//var slagsetno = 3;
	$(function() {
		$('.alert-error, .text-error').delay(8000).fadeOut();
		/*$('#u_startdate, #u_enddate, #old_startdate, #old_enddate, #minimum_age, #total_age').datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true
		});
		$(".timepicker").timepicker({
			showInputs: false,
			minuteStep: 30
		});*/
	});
	
	/*function goto_qlali_cat_check() {
		var quali_category = $('#quali_category option:selected').val();
		if (quali_category == "Slab") {
			slagno = 2;
			$('#percent_marks').val('');
			$('.fullmarks_cls, .percentmarks_cls').fadeOut();
			$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('.slavmarks_cls').fadeIn();
		} else {
			slagno = 2;
			$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
			$('#percent_marks').val('');
			$('.percentmarks_cls, .slavmarks_cls').fadeOut();
			$('.fullmarks_cls').fadeIn();
		}
	}*/

	function gotoadd_slav() {
		var FieldCount_set = $('.slav_tabs').find($("input"));
		var slnum = (FieldCount_set.length/3)+1;
		slagno = FieldCount_set.length + Number(slagno);
		$('.remove-btn').remove();
		// alert(slagno);
		// $('.slav_tabs').append('<tr class="slav_set_' + slagno + '"><td><input type="hidden" class="form-control slnum-cls" name="q_slnum[]" id="q_slnum' + slnum + '" value="' + slnum + '" />' + slnum + '</td><td><input type="text" class="form-control" name="q_slap[]" id="q_slap' + slagno + '" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark' + slagno + '" autocomplete="off" /></td><td class="remove-td" id="remove_' + slnum + '"><a href="javascript:;" onclick="delspav(' + slagno + ');" class="btn btn-sm btn-danger remove-btn">Remove</a></td></tr>');

		$('.slav_tabs').append('<tr class="slav_set_' + slnum + '"><td><input type="hidden" class="form-control slnum-cls" name="q_slnum[]" id="q_slnum' + slnum + '" value="' + slnum + '" />' + slnum + '</td><td><input type="text" class="form-control" name="q_slap[]" id="q_slap' + slnum + '" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark' + slnum + '" autocomplete="off" /></td><td class="remove-td" id="remove_' + slnum + '"><a href="javascript:;" onclick="delspav(' + slnum + ');" class="btn btn-sm btn-danger remove-btn">Remove</a></td></tr>');
	}

	function delspav(slvid) {
		if (slvid != "") {
			$('.slav_set_' + slvid).remove();
		}
		var remove_td_num = $('.slav_tabs').find($(".remove-td"));
		var next_remove_td = remove_td_num.length + 1;
		// alert(next_remove_td);
		$('#remove_' + next_remove_td).append('<a href="javascript:;" onclick="delspav(' + next_remove_td + ');" class="btn btn-sm btn-danger remove-btn">Remove</a>');
	}

	function gotosubmit_qualification() {
		$('.div_roller_total7').fadeIn();
		var delay = 5000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var adv_no = $('#adv_no').val();
		var quali_name = $('#quali_name option:selected').val();
		var quali_type = $('#quali_type option:selected').val();
		var quali_final_set = $('#quali_final_set option:selected').val();
		var quali_parsuing = $('#quali_parsuing option:selected').val();
		var quali_fullmark = $('#quali_fullmark').val();
		var exam_rtype = $('#exam_rtype option:selected').val();
		var quali_category = $('#quali_category option:selected').val();
		var attempt_type = $('#attempt_type option:selected').val();
		var attempt_marks = $('#attempt_marks').val();
		var adv_prev_quali = $('#adv_prev_quali').val();
		var q_slap = $("input[name='q_slap[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var q_mark = $("input[name='q_mark[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		
		var FieldCount_set = $('.slav_tabs').find($("input"));
		var totalval = q_slap.length + q_mark.length;
		if (totalval != FieldCount_set.length) {
			e_error = 1;
			error_message = error_message + "<br/>Fill-Up All Fields properly.";
		} else if (q_slap.length != q_mark.length) {
			e_error = 1;
			error_message = error_message + "<br/>Fill-Up All Fields properly.";
		} else {
			if (q_slap[q_slap.length - 1] != 100) {
				e_error = 1;
				error_message = error_message + "<br/>Upto Section Last Value always 100, check again.";
			} else {
				for (var i = 0; i < q_slap.length; i++) {
					if (isNaN(q_slap[i])) {
						e_error = 1;
						error_message = error_message + "<br/>Upto Section always use Numeric Value, check again.";
						break;
					} else {
						if(i > 0){
							if (parseFloat(q_slap[i]) <= parseFloat(q_slap[i - 1])) {
								e_error = 1;
								error_message = error_message + "<br/>Upto Section always maintain Asending Numeric Value, check again.";
								break;
							}
						}
					}
				}
			}
			if (q_mark[q_mark.length - 1] != parseFloat(quali_fullmark)) {
				e_error = 1;
				error_message = error_message + "<br/>Slab Last Marks always equal to Total Marks of Qualification, check again.";
			} else {
				for (var j = 0; j < q_mark.length; j++) {
					if (isNaN(q_mark[j])) {
						e_error = 1;
						error_message = error_message + "<br/>Slab Marks always use Numeric Value, check again.";
						break;
					} else {
						if(j > 0){
							if (parseFloat(q_mark[j]) <= parseFloat(q_mark[j - 1])) {
								e_error = 1;
								error_message = error_message + "<br/>Slab Marks always maintain Asending Numeric Value, check again.";
								break;
							}
						}
					}
				}
			}
		}

		if (e_error == 1) {
			$('.div_roller_total7').fadeOut();
			$('.get_error_total7').html(error_message);
			$(".get_error_total7").fadeIn();
			$(".text-error").fadeIn();
			setTimeout(function() {
				$('.text-error, .get_error_total7').fadeOut();
			}, delay);
		} else {
			var form_data = new FormData();
			form_data.append('adv_no', adv_no);
			form_data.append('quali_name', quali_name);
			form_data.append('quali_type', quali_type);
			form_data.append('quali_final_set', quali_final_set);
			form_data.append('quali_parsuing', quali_parsuing);
			form_data.append('quali_fullmark', quali_fullmark);
			form_data.append('exam_rtype', exam_rtype);
			form_data.append('quali_category', quali_category);
			form_data.append('attempt_type', attempt_type);
			form_data.append('attempt_marks', attempt_marks);
			form_data.append('q_slap', q_slap);
			form_data.append('q_mark', q_mark);
			form_data.append('deduct_slap', deduct_slap);
			form_data.append('deduct_mark', deduct_mark);
			//form_data.append("files", files[0]);
			$.ajax({
				method: 'POST',
				url: '<?php echo base_url() . "admincontrol/advertisement_set/new_qualification_submission"; ?>',
				data: form_data,
				dataType: 'JSON',
				contentType: false,
				processData: false,
				success: function(data) {
					//alert(data.msg);
					if (data.msg == 1) {
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total7').fadeOut();
						$('.get_success_total7').html('Qualification is Added Successfully.');
						$(".get_success_total7").fadeIn();
						var quali_string = '<tr class="qset_' + data.cat_set.aquali_id + '"><td>' + data.cat_set.qm_name + '</td><td>' + data.cat_set.aquali_examtype + '</td><td>' + data.cat_set.aquali_finalexam + '</td><td>' + data.cat_set.aquali_pursuing_chk + '</td><td>' + data.cat_set.aquali_marks + '</td><td>' + data.cat_set.aquali_relation + '</td><td>' + data.cat_set.aquali_category + ' Marks</td><td>';
						if (data.cat_set.aquali_category == "Slab") {
							quali_string = quali_string + '<table class="table" style="border:1px #999 solid;"><tr><th>Upto Section</th><th>Marks</th></tr>';
							for (var k = 0; k < data.detail_set.length; k++) {
								quali_string = quali_string + '<tr><td>' + data.detail_set[k].aq_detail_score_lvl + '</td><td>' + data.detail_set[k].aq_detail_score_mark + '</td></tr>';
							}
							quali_string = quali_string + '</table>';
						} else {
							quali_string = quali_string + '&nbsp;';
						}
						quali_string = quali_string + '</td><td>' + data.cat_set.aquali_attempt + '</td><td>';
						if (data.cat_set.aquali_attempt == "Full" || data.cat_set.aquali_attempt == "Percent") {
							quali_string = quali_string + data.cat_set.aquali_fullpercent;
						}else if(data.cat_set.aquali_attempt == "Slab"){
							quali_string = quali_string + '<table class="table" style="border:1px #999 solid;"><tr><th>Upto Section</th><th>Marks</th></tr>';
							for (var kk = 0; kk < data.deduct_set.length; kk++) {
								quali_string = quali_string + '<tr><td>' + data.deduct_set[kk].aq_deduct_lvl + '</td><td>' + data.deduct_set[kk].aq_deduct_mark + '</td></tr>';
							}
							quali_string = quali_string + '</table>';
						}else{
							quali_string = quali_string + '&nbsp;';
						}
						quali_string = quali_string + '</td><td><a href="javascript:;" onclick="gotodelete_quali(' + data.cat_set.aquali_id + ');"><i class="fa fa-trash-o text-danger"></i></a></td></tr>';
						$('.quali_setvalue').append(quali_string);
						var qualification_counter = $('#adv_qualification').val();
						var adv_exact_exams = $('#adv_exact_exams').val();
						//auto no add
						var academic_marks = $('#academic_marks').val();
						if(parseInt(qualification_counter) > 0){
							var aquali_relation = $('#adv_prev_quali').val();
							if(aquali_relation == "AND"){
								academic_marks = parseFloat(academic_marks) + parseFloat(data.cat_set.aquali_marks);
								if(data.cat_set.aquali_examtype == "Essential"){
									adv_exact_exams = Number(adv_exact_exams) + 1;
								}
							}
							$('#adv_prev_quali').val(data.cat_set.aquali_relation);
						}else{
							academic_marks = parseFloat(academic_marks) + parseFloat(data.cat_set.aquali_marks);
							if(data.cat_set.aquali_examtype == "Essential"){
								adv_exact_exams = Number(adv_exact_exams) + 1;
							}
							$('#adv_prev_quali').val(data.cat_set.aquali_relation);
						}
						$('#academic_marks').val(academic_marks);
						//auto no end
						qualification_counter = Number(qualification_counter) + 1;
						$('#adv_qualification').val(qualification_counter);
						$('#adv_exact_exams').val(adv_exact_exams);
						$('#quali_fullmark').val('');
						$('#quali_name, #quali_type').val('');
						$('#quali_category').val('Full');
						$('#attempt_type').val('No');
						$('.deduction_cls').fadeOut();
						$('#attempt_marks').val('');
						slagno = 2;
						$('.slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="slav_set_1"><td><input type="text" class="form-control" name="q_slap[]" id="q_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="q_mark[]" id="q_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
						$('.slavmarks_cls').fadeOut();
						deductno = 2;
						$('.deduct_slav_tabs').html('<tr><th><label>Section<font style="color: red;">*</font></label></th><th><label>Marks<font style="color: red;">*</font></label></th></tr><tr class="dedslav_set_1"><td><input type="text" class="form-control" name="deduct_slap[]" id="deduct_slap1" autocomplete="off" /></td><td><input type="text" class="form-control" name="deduct_mark[]" id="deduct_mark1" autocomplete="off" /></td><td>&nbsp;</td></tr>');
						$('.slav_deduction_cls').fadeOut();
						$('.fullmarks_cls').fadeIn();
						setTimeout(function() {
							$('.get_success_total7').fadeOut();
						}, 3000);

					} else {
						$('.div_roller_total7').fadeOut();
						//error_message = "There have some problem to Store Data, Try after some time.";
						error_message = data.e_msg;
						$('.get_error_total7').html(error_message);
						$(".get_error_total7").fadeIn();
						setTimeout(function() {
							$('.get_error_total7').fadeOut();
						}, delay);
					}

				}
			});
		}
	}

	function check_timeall(timeset) {
		var hours = Number(timeset.match(/^(\d+)/)[1]);
		var minutes = Number(timeset.match(/:(\d+)/)[1]);
		var AMPM = timeset.match(/\s(.*)$/)[1];
		if (AMPM == "PM" && hours < 12) hours = hours + 12;
		if (AMPM == "AM" && hours == 12) hours = hours - 12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if (hours < 10) sHours = "0" + sHours;
		if (minutes < 10) sMinutes = "0" + sMinutes;
		//alert(sHours + ":" + sMinutes);
		var time_all = sHours + ':' + sMinutes;
		return time_all;
	}

	// function check_ord_asc(arr){

		// for(var i=0; i<=arr.length; i++){
		// 	if(i == arr.length){
		// 		console.log('true');
		// 		return true;
		// 	}
		// 	else if(i<=arr.length && i!=0){
				
		// 		if(arr[i] > arr[i-1]){
		// 			// console.log(arr[i]);
		// 		}
		// 		else{
		// 			console.log(arr[i]);
		// 			console.log('false');
		// 			break;
		// 		}
		// 	}	
		// }
	// }

	function check_num_numeric(arr){
		for (var i = 0; i < arr.length; i++) {
			if (isNaN(arr[i])) {
				// e_error = 1;
				// error_message = error_message + "<br/>Upto Section always use Numeric Value, check again.";
				return true;
				break;
			} 
		}
	}

	function check_ord_asc(arr){
		for (var i = 0; i < arr.length; i++) {
			if(i > 0){
				if (parseFloat(arr[i]) <= parseFloat(arr[i - 1])) {
					// e_error = 1;
					// error_message = error_message + "<br/>Upto Section always maintain Asending Numeric Value, check again.";
					return true;
					break;
				}
			}
			
		}
	}

	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		//var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		
		//Checks for mm/dd/yyyy format.
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

	// function empty_check(arr, sl_arr){
	// 	for (var i = 0; i < arr.length; i++) {
	// 		if (arr[i] == "") {
	// 			alert('inside');
	// 			return false;
	// 			break;
	// 		}
	// 	}
	// }

	function gotoclclickbutton() {
		$('.div_roller_total').fadeIn();
		$('.gofinalsubmit').attr("disabled", "disabled");
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@%=<>)\[\]+;:.',\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_withdot = /^[0-9.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;

		//========== Scheme Creation Form Input Get Values ===================
		var sc_name = $('#sc_name').val().trim();
		var sc_detail = $('#sc_detail').val().trim();
		var sc_amount = $('#sc_amount').val().trim();
		var sc_installment_no = $('#sc_installment_no').val().trim();
		var sc_ref_no = $('#sc_ref_no').val().trim();
		var sc_date = $('#sc_date').val();
		var q_slnum = $("input[name='q_slnum[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var q_slap = $("input[name='q_slap[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();
		var q_mark = $("input[name='q_mark[]']").map(function() {
			if ($(this).val() != "") {
				return $(this).val();
			}
		}).get();

		//========== Percentage Work Input Validation ===================
		if (q_slap.length < 1)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Empty input 1, check again.');
		}
		else if (q_slap.length < q_slnum.length)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Empty input 2, check again.');
		}
		else if (parseFloat(q_slap[q_slap.length - 1]) != 100)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Last percentage should be 100, check again.');
		}
		else if(check_num_numeric(q_slap))
		{
			e_error = 1;
			$('.sc_percentage_error').html('Always use Numeric Value, check again.');
		}
		else if(check_ord_asc(q_slap))
		{
			e_error = 1;
			$('.sc_percentage_error').html('Always maintain Asending Numeric Value, check again.');
		}
		else
		{
			$('.sc_percentage_error').html('');
		}

		//========== Percentage Pay Input Validation ===================
		if (q_mark.length < 1)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Empty input 1, check again.');
		}
		else if (q_mark.length < q_slnum.length)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Empty input 2, check again.');
		}
		else if (parseFloat(q_mark[q_mark.length - 1]) != 100)
		{
			e_error = 1;
			$('.sc_percentage_error').html('Last percentage should be 100, check again.');
		}
		else if(check_num_numeric(q_mark))
		{
			e_error = 1;
			$('.sc_percentage_error').html('Always use Numeric Value, check again.');
		}
		else if(check_ord_asc(q_mark))
		{
			e_error = 1;
			$('.sc_percentage_error').html('Always maintain Asending Numeric Value, check again.');
		}
		else
		{
			$('.sc_percentage_error').html('');
		}

		//========== Scheme Name Input Validation ===================
		if(sc_name == "")
		{
			e_error = 1;
			$('.sc_name').html('Scheme Name is Required.');
		}
		else
		{
			if(!sc_name.match(alphanumerics_spaces))
			{
				e_error = 1;
				$('.sc_name').html('Scheme Name not use special carecters [without _ . , -], Check again.');
			}
			else
			{
				$('.sc_name').html('');
			}	
		}

		//========== Scheme Details Input Validation ===================
		if(sc_detail == "")
		{
			e_error = 1;
			$('.sc_detail').html('Scheme Details is Required.');
		}
		else
		{
			$('.sc_detail').html('');	
		}

		//========== Scheme Amount Input Validation ===================
		if(Number(sc_amount) == "")
		{
			e_error = 1;
			$('.sc_amount').html('Scheme Amount is Required.');
		}
		else
		{
			if(!sc_amount.match(onlynumerics))
			{
				e_error = 1;
				$('.sc_amount').html('Only numbers allwoed, Check again.');
			}
			else
			{
				$('.sc_amount').html('');
			}	
		}

		//========== Number of Installment Input Validation ===================
		if(sc_installment_no == "")
		{
			e_error = 1;
			$('.sc_installment_no').html('Number of Installment is Required.');
		}
		else
		{
			if(!sc_installment_no.match(onlynumerics))
			{
				e_error = 1;
				$('.sc_installment_no').html('Only numbers allwoed, Check again.');
			}
			else if (parseFloat(sc_installment_no) != q_slnum.length)
			{
				e_error = 1;
				$('.sc_installment_no').html('Allotment List and Number of Installment should be same, check again.');
			}
			else
			{
				$('.sc_installment_no').html('');
			}	
		}

		//========== Reference Number Input Validation ===================
		if(sc_ref_no == "")
		{
			e_error = 1;
			$('.sc_ref_no').html('Reference Number is Required.');
		}
		else
		{
			if(!sc_ref_no.match(onlynumerics))
			{
				e_error = 1;
				$('.sc_ref_no').html('Only numbers allwoed, Check again.');
			}
			else
			{
				$('.sc_ref_no').html('');
			}	
		}

		//========== Date Input Validation ===================
		if(sc_date == "")
		{
			e_error = 1;
			$('.sc_date').html('Date is Required.');
		}
		else if(isDatecheck(sc_date))
		{
			e_error = 1;
			$('.sc_date').html('Invalid Date.');
		}
		else
		{
			$('.sc_date').html('');	
		}
	

		//=== cmt 1 === ******



		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
			$('.gofinalsubmit').attr("disabled", false);
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} else {
			//alert(newhash);
			//alert(rehash);
			//$("#myForm").submit();
			var conf_answer = confirm("Are you sure you want to Submit the Data for New Scheme?");
			if (conf_answer) {

				// data['sc_name'] = sc_name;
				// data['sc_detail'] = sc_detail;
				// data['sc_amount'] = sc_amount;
				// data['sc_installment_no'] = sc_installment_no;
				// data['sc_ref_no'] = sc_ref_no;
				// data['sc_date'] = sc_date;
				// data['q_slnum'] = q_slnum;
				// data['q_slap'] = q_slap;
				// data['q_mark'] = q_mark;


				//=== cmt 2 === ******


				//============ AJAX POST =================
				$.ajax({
					method: 'POST',
					url: '<?php echo base_url() . "admincontrol/scheme_set/new_scheme_submission"; ?>',
					// data: data,
					data:{
						sc_name: sc_name, 
						sc_detail: sc_detail, 
						sc_amount: sc_amount,
						sc_installment_no: sc_installment_no,
						sc_ref_no: sc_ref_no,
						sc_date: sc_date,
						q_slnum: q_slnum,
						q_slap: q_slap,
						q_mark: q_mark
					},
					dataType: 'JSON',
					// contentType: false,
					// processData: false,
					success: function(data) {
						//alert(data.msg);
						if (data.msg == 1) {

							alert('success');
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total').fadeOut();
							$('.get_success_total').html('Advertisement is Uploaded Successfully.');
							$(".get_success_total").fadeIn();
							$('input, select').val('');
							$('input').html('');
							setTimeout(function() {
								$('.get_success_total').fadeOut();
							}, 3000);
							setTimeout(function() {
								window.location.replace("<?php echo site_url('admincontrol/scheme_set/all_scheme_list') ?>");
							}, 3000);


						} else {
							$('.div_roller_total').fadeOut();
							$('.gofinalsubmit').attr("disabled", false);
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
			} else {
				$('.div_roller_total').fadeOut();
				$('.gofinalsubmit').attr("disabled", false);
			}
		}

	}

	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		//var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		
		//Checks for mm/dd/yyyy format.
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







	//== cmt 1 ==

	// var adv_no = $('#adv_no').val();
	// var adv_category = $('#adv_category').val();
	// var adv_qualification = $('#adv_qualification').val();
	// var adv_exact_exams = $('#adv_exact_exams').val();
	// var adv_experience = $('#adv_experience').val();
	// var exact_exp_counter = $('#exact_exp_counter').val();
	// var adv_prev_quali = $('#adv_prev_quali').val();
	// var adv_prev_agetype = $('#adv_prev_agetype').val();
	// var adv_prev_expr = $('#adv_prev_expr').val();
	// var adv_agecounter = $('#adv_agecounter').val();
	// var r_for = $('#r_for option:selected').val();
	// var adv_name = $('#adv_name').val();
	// var u_startdate = $('#u_startdate').val();
	// var u_starttime = $('#u_starttime').val();
	// var u_enddate = $('#u_enddate').val();
	// var u_endtime = $('#u_endtime').val();
	// var adv_typeset = $('#adv_typeset option:selected').val();
	// var adv_dicta = $('#adv_dicta option:selected').val();
	// var old_startdate = $('#old_startdate').val();
	// var old_starttime = $('#old_starttime').val();
	// var old_enddate = $('#old_enddate').val();
	// var old_endtime = $('#old_endtime').val();
	// var scale_pay = $('#scale_pay').val();
	// var total_vacency = $('#total_vacen').val();
	// var minimum_age = $('#minimum_age').val();
	// var total_age = $('#total_age').val();
	// var age_relax_yr = $('#age_relax_yr').val();
	// var age_writeup = $('#age_writeup').val();
	// var u_pwd_percent = $('#u_pwd_percent').val();

	//var has_examted = $("input[name='has_examted']:checked").val();
	//var has_ex_service = $("input[name='has_ex_service']:checked").val();
	//var has_ews = $("input[name='has_ews']:checked").val();
	// var has_exp = $("input[name='has_exp']:checked").val();
	// var total_fees = $('#total_fees').val();
	//var u_paymode = $('#u_paymode').val();
	// var academic_marks = $('#academic_marks').val();
	// var experience_marks = $('#experience_marks').val();
	// var interview_marks = $('#interview_marks').val();
	// var written_marks = $('#written_marks').val();
	// var marks_writeup = $('#marks_writeup').val();
	// var miscellenius_writeup = $('#miscellenius_writeup').val();
	// var disabality_writeup = $('#disabality_writeup').val();
	//var exam_counter = $('input[name="exam_lvl[]"]:checked').length;
	// var essen_writeup = $('#essen_writeup').val();
	// var desir_writeup = $('#desir_writeup').val();
	// var files = $('#advice_doc')[0].files;

	/*var exam_gen = [];
	$.each($("input[name='exam_lvl']:checked"), function(){
		exam_gen.push($(this).val());
	});
	//user_address = user_address.replace(/(\r\n|\n|\r)/gm, " ");
	//var ap_symptom = $("input[name='ap_symptom']:checked").val();
	//var ap_quaran = $("input[name='ap_quaran']:checked").val();
	
	if(exam_gen.length == 0){
		e_error = 1;
		$('.exam_lvl').html('Qualification is Required.');
	}*/
	// if (adv_no == "") {
	// 	e_error = 1;
	// 	error_message = error_message + "<br/>ID is missing, Refresh the page";
	// }
	// if (Number(adv_category) === 0) {
	// 	e_error = 1;
	// 	error_message = error_message + "<br/>Post is missing, Enter some Discipline";
	// }
	// if (Number(adv_qualification) === 0) {
	// 	e_error = 1;
	// 	error_message = error_message + "<br/>Qualification is missing, Enter some Qualification";
	// }else{
	// 	if(adv_prev_quali != "END"){
	// 		e_error = 1;
	// 		error_message = error_message + "<br/>Qualification END is missing, Enter yuor END Qualification";
	// 	}
	// }
	// if (Number(adv_agecounter) > 0) {
	// 	if(adv_prev_agetype != "END"){
	// 		e_error = 1;
	// 		error_message = error_message + "<br/>Age Relaxation END is missing, Enter yuor END Age Relaxation";
	// 	}
	// }
	
	// if (adv_name == "") {
	// 	e_error = 1;
	// 	$('.adv_name').html('Advertisement No. is Required.');
	// } else {
		/*if (!adv_name.match(alphanumerics_no)) {
			e_error = 1;
			$('.adv_name').html('Advertisement No. not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
		} else {
			$('.adv_name').html('');
		}*/
	// 	$('.adv_name').html('');
	// }

	// if (r_for == "") {
	// 	e_error = 1;
	// 	$('.r_for').html('Recruitment For is Required.');
	// } else {
	// 	if (!r_for.match(onlynumerics)) {
	// 		e_error = 1;
	// 		$('.r_for').html('Recruitment For only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.r_for').html('');
	// 	}
	// }

	// if (u_startdate == "") {
	// 	e_error = 1;
	// 	$('.u_startdate').html('Start Date is Required.');
	// } else {
	// 	$('.u_startdate').html('');
	// }
	// if (u_enddate == "") {
	// 	e_error = 1;
	// 	$('.u_enddate').html('End Date is Required.');
	// } else {
	// 	$('.u_enddate').html('');
	// }
	// if (u_starttime == "") {
	// 	e_error = 1;
	// 	$('.u_starttime').html('Start Time is Required.');
	// } else {
	// 	$('.u_starttime').html('');
	// }
	// if (u_endtime == "") {
	// 	e_error = 1;
	// 	$('.u_endtime').html('End Time is Required.');
	// } else {
	// 	$('.u_endtime').html('');
	// }

	// if (u_startdate != "" && u_enddate != "" && u_starttime != "" && u_endtime != "") {
	// 	var valuestart = check_timeall(u_starttime);
	// 	var valuestop = check_timeall(u_endtime);
	// 	//var task_start_date_update = task_start_date.replace(/-/g, "/");
	// 	//var task_end_date_update = task_end_date.replace(/-/g, "/");
	// 	var newDate = u_startdate.split("-");
	// 	var newDateend = u_enddate.split("-");
	// 	var task_work_date_update = newDate[2] + '-' + newDate[1] + '-' + newDate[0];
	// 	var task_work_date_update_end = newDateend[2] + '-' + newDateend[1] + '-' + newDateend[0];
	// 	var timediff = new Date(task_work_date_update_end + "T" + valuestop) - new Date(task_work_date_update + "T" + valuestart);
	// 	var timediff = (timediff / 1000);
	// 	var hourDiff = (timediff / 3600);
	// 	var minuteDiff = (timediff - (hourDiff * 3600));
	// 	if (hourDiff < 0) {
	// 		e_error = 1;
	// 		error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
	// 	} else if (hourDiff == 0) {
	// 		if (minuteDiff <= 0) {
	// 			e_error = 1;
	// 			error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
	// 		}
	// 	} else {
	// 		if (minuteDiff < 0) {
	// 			hourDiff = hourDiff - 1;
	// 			var totalminutes = (hourDiff * 60) + (60 + minuteDiff);
	// 		} else {
	// 			var totalminutes = (hourDiff * 60) + minuteDiff;
	// 		}
	// 		//alert(totalminutes);
	// 		if (totalminutes <= 0) {
	// 			e_error = 1;
	// 			error_message = error_message + '<br/>Check the total timing.';
	// 		}
	// 	}
	// }

	// if (adv_dicta == "") {
	// 	e_error = 1;
	// 	$('.adv_dicta').html('Dictation is Required.');
	// } else {
	// 	if (!adv_dicta.match(alphaletters)) {
	// 		e_error = 1;
	// 		$('.adv_dicta').html('Dictation only use Alphabet Values, Check again.');
	// 	} else {
	// 		$('.adv_dicta').html('');
	// 	}
	// }

	// if (adv_typeset == "") {
	// 	e_error = 1;
	// 	$('.adv_typeset').html('Advertisement Type is Required.');
	// } else {
	// 	if (!adv_typeset.match(alphaletters)) {
	// 		e_error = 1;
	// 		$('.adv_typeset').html('Advertisement Type only use Alphabet Values, Check again.');
	// 	} else {
	// 		$('.adv_typeset').html('');
	// 	}
	// }

	// if(adv_typeset == "Old"){
	// 	if (old_startdate == "") {
	// 		e_error = 1;
	// 		$('.old_startdate').html('Old Start Date is Required.');
	// 	} else {
	// 		$('.old_startdate').html('');
	// 	}
	// 	if (old_enddate == "") {
	// 		e_error = 1;
	// 		$('.old_enddate').html('Old End Date is Required.');
	// 	} else {
	// 		$('.old_enddate').html('');
	// 	}
	// 	if (old_starttime == "") {
	// 		e_error = 1;
	// 		$('.old_starttime').html('Old Start Time is Required.');
	// 	} else {
	// 		$('.old_starttime').html('');
	// 	}
	// 	if (old_endtime == "") {
	// 		e_error = 1;
	// 		$('.old_endtime').html('Old End Time is Required.');
	// 	} else {
	// 		$('.old_endtime').html('');
	// 	}
	// }else{
	// 	$('.old_startdate, .old_enddate, .old_starttime, .old_endtime').html('');
	// }

	// if (scale_pay == "") {
	// 	e_error = 1;
	// 	$('.scale_pay').html('Scale of Pay is Required.');
	// } else {
	// 	//var scale_pay1 = scale_pay.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!scale_pay1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.scale_pay').html('Scale of Pay not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.scale_pay').html('');
	// 	}*/
	// 	$('.scale_pay').html('');
	// }
	// if (total_vacency == "") {
	// 	e_error = 1;
	// 	$('.total_vacen').html('Total Vacency is Required.');
	// } else {
	// 	if (!total_vacency.match(onlynumerics)) {
	// 		e_error = 1;
	// 		$('.total_vacen').html('Total Vacency only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.total_vacen').html('');
	// 	}
	// }
	// if (minimum_age == "") {
	// 	e_error = 1;
	// 	$('.minimum_age').html('Minimum DOB is Required.');
	// } else {
	// 	if(isDatecheck(minimum_age) == false){
	// 		e_error = 1;
	// 		$('.minimum_age').html('Minimum DOB Format check properly and Try Again.');
	// 	} else {
	// 		$('.minimum_age').html('');
	// 	}
	// }
	// if (total_age == "") {
	// 	e_error = 1;
	// 	$('.total_age').html('Maximum DOB is Required.');
	// } else {
	// 	if(isDatecheck(total_age) == false){
	// 		e_error = 1;
	// 		$('.total_age').html('Maximum DOB Format check properly and Try Again.');
	// 	} else {
	// 		$('.total_age').html('');
	// 	}
	// }
	// if (age_relax_yr == "") {
	// 	e_error = 1;
	// 	$('.age_relax_yr').html('Max Relaxation Year is Required.');
	// } else {
	// 	if (!age_relax_yr.match(onlynumerics)) {
	// 		e_error = 1;
	// 		$('.age_relax_yr').html('Max Relaxation Year only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.age_relax_yr').html('');
	// 	}
	// }

	// if (u_pwd_percent == "") {
	// 	e_error = 1;
	// 	$('.u_pwd_percent').html('PWD Percentage is Required.');
	// } else {
	// 	if (!u_pwd_percent.match(onlynumerics)) {
	// 		e_error = 1;
	// 		$('.u_pwd_percent').html('PWD Percentage only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.u_pwd_percent').html('');
	// 	}
	// }

	// if (age_writeup != "") {
	// 	//var age_writeup1 = age_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!age_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.age_writeup').html('Writeup about Age not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.age_writeup').html('');
	// 	}*/
	// 	$('.age_writeup').html('');
	// }

	/*if (has_examted == "" || has_examted == undefined) {
		e_error = 1;
		$('.has_examted').html('Has Exempted is Required.');
	} else {
		if (!has_examted.match(alphaletters)) {
			e_error = 1;
			$('.has_examted').html('Has Exempted only Alphabet value, Check again.');
		} else {
			$('.has_examted').html('');
		}
	}
	if (has_ex_service == "" || has_ex_service == undefined) {
		e_error = 1;
		$('.has_ex_service').html('Has Ex Service is Required.');
	} else {
		if (!has_ex_service.match(alphaletters)) {
			e_error = 1;
			$('.has_ex_service').html('Has Ex Service only Alphabet value, Check again.');
		} else {
			$('.has_ex_service').html('');
		}
	}
	if (has_ews == "" || has_ews == undefined) {
		e_error = 1;
		$('.has_ews').html('Has EWS is Required.');
	} else {
		if (!has_ews.match(alphaletters)) {
			e_error = 1;
			$('.has_ews').html('Has EWS only Alphabet value, Check again.');
		} else {
			$('.has_ews').html('');
		}
	}*/
	// if (has_exp == "" || has_exp == undefined) {
	// 	e_error = 1;
	// 	$('.has_exp').html('Has Experience is Required.');
	// } else {
	// 	if (!has_exp.match(alphaletters)) {
	// 		e_error = 1;
	// 		$('.has_exp').html('Has Experience only Alphabet value, Check again.');
	// 	} else {
	// 		$('.has_exp').html('');
	// 		if (has_exp == "Yes") {
	// 			if (Number(adv_experience) === 0) {
	// 				e_error = 1;
	// 				error_message = error_message + "<br/>Experience is missing, Enter some Experience";
	// 			}else{
	// 				if(adv_prev_expr != "END"){
	// 					e_error = 1;
	// 					error_message = error_message + "<br/>Experience END is missing, Enter yuor END Experience";
	// 				}
	// 			}
	// 		}else if(has_exp == "No"){
	// 			if (Number(experience_marks) != 0) {
	// 				e_error = 1;
	// 				error_message = error_message + "<br/>Experience Marks should be 0, check again.";
	// 			}
	// 		}
	// 	}
	// }
	// if (total_fees == "") {
	// 	e_error = 1;
	// 	$('.total_fees').html('Total Fees is Required.');
	// } else {
	// 	if (!total_fees.match(onlynumerics)) {
	// 		e_error = 1;
	// 		$('.total_fees').html('Total Fees only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.total_fees').html('');
	// 	}
	// }
	
	/*if (u_paymode == "") {
		e_error = 1;
		$('.u_paymode').html('Payment Mode is Required.');
	} else {
		if (!u_paymode.match(alphanumerics_no)) {
			e_error = 1;
			$('.u_paymode').html('Payment Mode not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
		} else {
			$('.u_paymode').html('');
		}
	}*/
	// if (essen_writeup != "") {
	// 	//var essen_writeup1 = essen_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!essen_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.essen_writeup').html('Writeup Essential Qualification not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.essen_writeup').html('');
	// 	}*/
	// 	$('.essen_writeup').html('');
	// }
	// if (desir_writeup != "") {
	// 	//var desir_writeup1 = desir_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!desir_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.desir_writeup').html('Writeup Desirable Qualification not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.desir_writeup').html('');
	// 	}*/
	// 	$('.desir_writeup').html('');
	// }
	// if (academic_marks == "") {
	// 	e_error = 1;
	// 	$('.academic_marks').html('Academic Marks is Required.');
	// } else {
	// 	if (!academic_marks.match(onlynumerics_withdot)) {
	// 		e_error = 1;
	// 		$('.academic_marks').html('Academic Marks only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.academic_marks').html('');
	// 	}
	// }
	// if (experience_marks == "") {
	// 	e_error = 1;
	// 	$('.experience_marks').html('Experience Marks is Required.');
	// } else {
	// 	if (!experience_marks.match(onlynumerics_withdot)) {
	// 		e_error = 1;
	// 		$('.experience_marks').html('Experience Marks only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.experience_marks').html('');
	// 	}
	// }
	// if (interview_marks == "") {
	// 	e_error = 1;
	// 	$('.interview_marks').html('Interview Marks is Required.');
	// } else {
	// 	if (!interview_marks.match(onlynumerics_withdot)) {
	// 		e_error = 1;
	// 		$('.interview_marks').html('Interview Marks only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.interview_marks').html('');
	// 	}
	// }
	// if (written_marks == "") {
	// 	e_error = 1;
	// 	$('.written_marks').html('Written Marks is Required.');
	// } else {
	// 	if (!written_marks.match(onlynumerics_withdot)) {
	// 		e_error = 1;
	// 		$('.written_marks').html('Written Marks only use Numeric Values, Check again.');
	// 	} else {
	// 		$('.written_marks').html('');
	// 	}
	// }
	// if (marks_writeup != "") {
	// 	//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!marks_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.marks_writeup').html('');
	// 	}*/
	// 	$('.marks_writeup').html('');
	// }
	// if (miscellenius_writeup != "") {
	// 	//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!marks_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.marks_writeup').html('');
	// 	}*/
	// 	$('.miscellenius_writeup').html('');
	// }
	// if (disabality_writeup != "") {
	// 	//var marks_writeup1 = marks_writeup.replace(/(\r\n|\n|\r)/gm, " ");
	// 	/*if (!marks_writeup1.match(alphanumerics_no)) {
	// 		e_error = 1;
	// 		$('.marks_writeup').html('Writeup about Marks not use special charecters [without _ / : ( [ + ; % = < > ] @ \' & . ) , -], Check again.');
	// 	} else {
	// 		$('.marks_writeup').html('');
	// 	}*/
	// 	$('.disabality_writeup').html('');
	// }
	// if (document.getElementById("advice_doc").files.length == 0) {
	// 	e_error = 1;
	// 	$('.advice_doc').html('Source File is Required.');
	// } else {
	// 	var fileInput = document.getElementById('advice_doc');
	// 	var filePath = fileInput.value;
	// 	if (!allowedExtensions.exec(filePath)) {
	// 		e_error = 1;
	// 		$('.advice_doc').html('Source File type Invalid.(Use PDF/JPG)');
	// 	} else {
	// 		$('.advice_doc').html('');
	// 	}
	// }

	/*if (u_startdate != "") {
		cur_date = '<?php //echo date("d-m-Y"); ?>';
		cur_set_date = cur_date.split('-');
		start_set_date = u_startdate.split('-');
		
		var new_start_date = new Date(start_set_date[2],(parseInt(start_set_date[1]) - 1),start_set_date[0]);
		var cur_new_date = new Date(cur_set_date[2],(parseInt(cur_set_date[1]) - 1),cur_set_date[0]);
		
		if(cur_new_date >= new_start_date){
			e_error = 1;
			error_message = error_message + '<br/>Problem in Advertisement Start Date, Check Again.';
		}
	}*/

	// if (minimum_age != "" && total_age != "") {
	// 	cur_date = '<?php //echo date("d-m-Y"); ?>';
	// 	cur_dob_date = cur_date.split('-');
	// 	start_dob_date = minimum_age.split('-');
	// 	end_dob_date = total_age.split('-');
		
	// 	var new_start_date = new Date(start_dob_date[2],(parseInt(start_dob_date[1]) - 1),start_dob_date[0]);
	// 	var new_end_date = new Date(end_dob_date[2],(parseInt(end_dob_date[1]) - 1),end_dob_date[0]);
	// 	var cur_new_date = new Date(cur_dob_date[2],(parseInt(cur_dob_date[1]) - 1),cur_dob_date[0]);
		
	// 	if(new_end_date >= new_start_date) {
	// 		e_error = 1;
	// 		error_message = error_message + '<br/>Problem in DOB Dates, Check Again.';
	// 	}else if(new_start_date >= cur_new_date){
	// 		e_error = 1;
	// 		error_message = error_message + '<br/>Problem in DOB Minimum Date, Check Again.';
	// 	}
	// }

	// if(academic_marks != "" && experience_marks != "" && interview_marks != "" && written_marks != ""){
	// 	if(!isNaN(academic_marks) && !isNaN(experience_marks) && !isNaN(interview_marks) && !isNaN(written_marks)){
	// 		var totalmarks = 0.00;
	// 		totalmarks = parseFloat(academic_marks) + parseFloat(experience_marks) + parseFloat(interview_marks) + parseFloat(written_marks);
	// 		if(totalmarks != 100.00){
	// 			e_error = 1;
	// 			error_message = error_message + '<br/>Marks Districution need to set always 100, Check Again.';
	// 		}
	// 	}
	// }
	//return false;
	//alert(salts);


	//=== cmt 2 ===

	// var form_data = new FormData();
	//form_data.append('exam_gen',exam_gen);
	// form_data.append('adv_no', adv_no);
	// form_data.append('adv_category', adv_category);
	// form_data.append('adv_qualification', adv_exact_exams);
	// form_data.append('adv_experience', exact_exp_counter);
	// form_data.append('r_for', r_for);
	// form_data.append('adv_name', adv_name);
	// form_data.append('u_startdate', u_startdate);
	// form_data.append('u_starttime', u_starttime);
	// form_data.append('u_enddate', u_enddate);
	// form_data.append('u_endtime', u_endtime);
	// form_data.append('adv_dicta', adv_dicta);
	// form_data.append('adv_typeset', adv_typeset);
	// form_data.append('old_startdate', old_startdate);
	// form_data.append('old_starttime', old_starttime);
	// form_data.append('old_enddate', old_enddate);
	// form_data.append('old_endtime', old_endtime);
	// form_data.append('scale_pay', scale_pay);
	// form_data.append('total_vacency', total_vacency);
	// form_data.append('minimum_age', minimum_age);
	// form_data.append('total_age', total_age);
	// form_data.append('age_relax_yr', age_relax_yr);
	// form_data.append('age_writeup', age_writeup);
	// //form_data.append('has_examted', has_examted);
	// //form_data.append('has_ex_service', has_ex_service);
	// //form_data.append('has_ews', has_ews);
	// form_data.append('has_exp', has_exp);
	// form_data.append('total_fees', total_fees);
	// form_data.append('u_pwd_percent', u_pwd_percent);
	// //form_data.append('u_paymode', u_paymode);
	// form_data.append('academic_marks', academic_marks);
	// form_data.append('experience_marks', experience_marks);
	// form_data.append('interview_marks', interview_marks);
	// form_data.append('written_marks', written_marks);
	// form_data.append('marks_writeup', marks_writeup);
	// form_data.append('miscellenius_writeup', miscellenius_writeup);
	// form_data.append('disabality_writeup', disabality_writeup);
	// form_data.append('essen_writeup', essen_writeup);
	// form_data.append('desir_writeup', desir_writeup);
	// form_data.append("files", files[0]);

</script>