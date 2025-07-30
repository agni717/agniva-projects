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
		  Interview Marks Checking
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Interview Marks Checking</li>
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
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" onchange="gotopanel_candidate_search();">
					  		<option value="">---Select---</option>
							<?php foreach($rec_list as $advitems){ ?>
								<option value="<?php echo $advitems->adv_auto_genno; ?>" <?php if(!empty($searchlist['advno'])){if($searchlist['advno'] == $advitems->adv_auto_genno){echo 'selected="selected"';}} ?>><?php echo $advitems->adv_no.' ('.$advitems->rm_name.')'; ?></option>
							<?php } ?>
							<?php 
							//foreach($adv_catg as $cats){ ?>
								<!--<option value="<?php //echo $cats->adv_auto_genno; ?>" <?php //if($searchlist['advno'] == $cats->adv_auto_genno){echo 'selected="selected"';} ?>><?php //echo $cats->adv_no; ?></option>-->
							<?php //} ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
					<label class="control-label">Post Category</label>
					<select class="form-control" name="advcat_name" id="advcat_name" autocomplete="off" <?php if(empty($searchlist['advcat_name'])){echo "disabled";}?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['advcat_name'])){ 
							foreach($cat_details as $catsets){ ?>
								<option value="<?php echo $catsets->acat_id; ?>" <?php if($searchlist['advcat_name'] == $catsets->acat_id){echo 'selected="selected"';} ?>><?php echo $catsets->catm_name; ?></option>
							<?php }} ?>
					</select>
					<small class="text-error advcat_name"><?php echo form_error('advcat_name'); ?></small>		  	
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">Interview Date</label>
				    <input type="text" class="form-control" name="u_startdate" id="u_startdate" placeholder="Enter Start Date" value="<?php if(!empty(set_value('u_startdate'))){echo set_value('u_startdate');}else{echo date('d-m-Y');} ?>" autocomplete="off" onchange="goto_check_totaltab();" />
				    <small class="text-error u_startdate"><?php echo form_error('u_startdate'); ?></small>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-offset-1 col-sm-4">
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
					<select class="form-control" name="shift_name" id="shift_name" autocomplete="off" onchange="goto_check_shiftwisetab();" <?php if(empty($searchlist['shift_name'])){echo "disabled";}?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['shift_name'])){ 
							foreach($shift_details as $sfsets){ ?>
								<option value="<?php echo $sfsets->shift_id; ?>" <?php if($searchlist['shift_name'] == $sfsets->shift_id){echo 'selected="selected"';} ?>><?php echo $sfsets->shift_name.' ('.date('h:i A',strtotime($sfsets->shift_start_time)).' To '.date('h:i A',strtotime($sfsets->shift_end_time)).')'; ?></option>
							<?php }} ?>
					</select>
					<small class="text-error shift_name"><?php echo form_error('shift_name'); ?></small>
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">Select Table No.<font style="color: red;">*</font></label>
				    <select class="form-control" name="table_exactno" id="table_exactno" autocomplete="off" <?php if(empty($searchlist['table_exactno'])){echo "disabled";}?> onchange="goto_search_table_candidates();">
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['table_exactno'])){ 
							foreach($shifttab_details as $tabsets){ ?>
								<option value="<?php echo $tabsets->utable_name; ?>" <?php if($searchlist['table_exactno'] == $tabsets->utable_name){echo 'selected="selected"';} ?>><?php echo $tabsets->utable_name. ' No. Table'; ?></option>
							<?php }} ?>
					</select>
				    <small class="text-error table_exactno"><?php echo form_error('table_exactno'); ?></small>
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
              </div>


			  <div class="row all_candidates_set" style="display:none;">
				 
			  	<div class="col-sm-12">
				  <hr style="border-color:#aaa;" />
					<table width="100%">
						<thead>
							<th>Sl No.</th>
							<th>Candidate Name (Reg. No.)</th>
							<th>Attend Interview</th>
							<th>Language Knowledge</th>
							<th>Interview Marks(10)</th>
							<th>Interview Marks(5)</th>
							<th>Action</th>
						</thead>
						<tbody class="cand_items">
							
						</tbody>
					</table>
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
				<!--<div class="col-sm-12 text-center" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>-->
				<div class="clearfix"></div>
			  </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
								<?php if(!empty($total_checkinglist)){ ?>
			
				  <div class="table-responsive" id="psetsss">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
					  		<td>Sl. No.</td>
					  		<td>Candidate Reg No.</td>
							<td>Candidate Name</td>
							<td>Candidate Mobile</td>
							<td>Action</td>
					  </thead>
                  	<tbody>
                  		<?php
						  foreach($total_checkinglist as $keys=>$users)
                  		{ ?>
                  		<tr>
						  	<td><?php echo ($keys + 1); ?></td>
                  			<td><?php echo $users->f_application_no; ?></td>
							<td><?php echo $users->f_full_name; ?></td>
							<td><?php echo $users->f_mobile; ?></td>
                  			<!--<td><?php //if($result_utypes == 3){echo date('d-m-Y h:i:s A',strtotime($users->chk2_appro_date));}else{echo date('d-m-Y h:i:s A',strtotime($users->chk_appro_date));} ?></td>-->
							<td style="width:100px;"><a class="btn-sm btn-danger" href="<?php echo base_url().'admincontrol/interview/interview_panelcandidate_table_modify/'.$users->invw_id; ?>" title="Edit Table No."><i class="fa fa-edit text-default"></i></a></td>
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

	<div id="myModal2" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title text-center">Marks Approval - Processing<br/><strong><span class="head_regno"></span></strong></h4>
			</div>
			<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div style="clear:both;">&nbsp;</div>
							<input type="hidden" name="canddoc_type" id="canddoc_type" value="" autocomplete="off" />
							<input type="hidden" name="canddoc_regno" id="canddoc_regno" value="" autocomplete="off" />
							<input type="hidden" name="canddoc_id" id="canddoc_id" value="" autocomplete="off" />
							<div class="col-sm-12 textareabox_set" style="display: none;">
								<div class="form-group">
									<label class="col-sm-3 control-label text-right">Return Comments</label>
									<div class="col-sm-9">
										<textarea class="form-control" name="retn_comment" style="resize:none;" id="retn_comment" autocomplete="off"></textarea>
										<small class="text-error retn_comment"><?php echo form_error('retn_comment'); ?></small>
									</div>
								</div>
							</div>
							<div class="col-sm-12 text-center">
								<div align="center">
									<div class="get_error_total_22" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="get_success_total_22" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total_22" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
							<div style="clear:both;">&nbsp;</div>
							<div class="col-sm-12 text-center">
							<button type="button" class="btn btn-warning ss_btn" onclick="gotoclclickbutton();"></button>
							</div>
							<div style="clear:both;">&nbsp;</div>
						</div>
					</div>
			</div>
			</div>
		</div>
	</div>

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
				url: "<?php echo site_url('admincontrol/movement/get_tablecandidates_details_chk2') ?>",
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
							genstring = genstring + '<tr class="candset_no_'+data.op_set[ic].invw_id+'"><td><strong>'+candcounter+'.</strong></td><td>'+data.op_set[ic].f_full_name+' ('+data.op_set[ic].invw_cand_regno+')</td><td><div><input type="hidden" name="intv_id_'+ic+'" id="intv_id_'+ic+'" value="'+data.op_set[ic].invw_id+'" /><input type="hidden" name="intv_regno_'+ic+'" id="intv_regno_'+ic+'" value="'+data.op_set[ic].invw_cand_regno+'" />'+data.op_set[ic].invw_attendance+'</div></td>';
							if(data.op_set[ic].invw_attendance == "Yes"){
								genstring = genstring + '<td><div>'+data.op_set[ic].invw_language+'</div></td><td><div>'+data.op_set[ic].invw_marks_1+'</div></td><td><div>'+data.op_set[ic].invw_marks_2+'</div></td>';
							}else{
								genstring = genstring + '<td><div>&nbsp;-&nbsp;</div></td><td><div>&nbsp;-&nbsp;</div></td><td><div>&nbsp;-&nbsp;</div></td>';
							}
							if(!data.op_set[ic].invw_approval){
								genstring = genstring + '<td><div><a href="javascript:;" class="btn-sm btn-success" onclick="gotocandidate_marks_check(\'A\','+data.op_set[ic].invw_id+',\''+data.op_set[ic].invw_cand_regno+'\');">Approve</a>&nbsp;<a href="javascript:;" class="btn-sm btn-danger" onclick="gotocandidate_marks_check(\'R\','+data.op_set[ic].invw_id+',\''+data.op_set[ic].invw_cand_regno+'\');">Return</a></div></td></tr>';
							}else{
								if(data.op_set[ic].invw_approval == "Yes"){
									genstring = genstring + '<td><div><strong>Approved</strong></div></td></tr>';
								}else{
									genstring = genstring + '<td><div><strong>Returned</strong></div></td></tr>';
								}
							}
							
							
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

	function gotocandidate_marks_check(doctype, intvid, intv_regno){
		$('#canddoc_type').val(doctype);
		$('#canddoc_id').val(intvid);
		$('#canddoc_regno').val(intv_regno);
		$('.head_regno').html(intv_regno);
		$('#retn_comment').val('');
		if(doctype == "R"){
			$('.textareabox_set').fadeIn();
			$('.ss_btn').html('Return');
		}else{
			
			$('.textareabox_set').fadeOut();
			$('.ss_btn').html('Approve');
		}
		$('#myModal2').modal('show');
	}

	function gotoclclickbutton(){
		//alert(extfilename);
		//$('#canddoc_type').val(doctype);
		//$('#canddoc_id').val(docid);
		//$('#canddoc_name').val(extfilename);
		$('.div_roller_total_22').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9'"_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

		var canddoc_type = $('#canddoc_type').val();
		var canddoc_id = $('#canddoc_id').val();
		var canddoc_regno = $('#canddoc_regno').val();
		var retn_comment = $('#retn_comment').val();
		
		if(canddoc_type == "" || canddoc_id == "" || canddoc_regno == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(canddoc_type == "R"){
			if(retn_comment == ""){
				e_error = 1;
				$('.retn_comment').html('Return Comments is Required.');
			}else{
				var comment1 = retn_comment.replace(/(\r\n|\n|\r)/gm, " ");
				if(!comment1.match(alphanumerics_no)){
					e_error = 1;
					$('.retn_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
				}else{
					$('.retn_comment').html('');
				}	
			}
		}else{
			$('.retn_comment').html('');
		}
		

		if(e_error == 1){
			$('.div_roller_total_22').fadeOut();
			$('.get_error_total_22').html(error_message);
			$(".get_error_total_22").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_22').fadeOut(); }, delay);
		}else{

			if(retn_comment != ""){
				var conf_answer = confirm("Are you sure you want to Return...?")
			}else{
				var conf_answer = confirm("Are you sure you want to Approve...?")
			}
			
			if (conf_answer) {

				//$('#myModal2').modal('show');
				
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/movement/checker2_approvalsection_modification"; ?>',
					data:{canddoc_type: canddoc_type, canddoc_id:canddoc_id, canddoc_regno: canddoc_regno, retn_comment: retn_comment},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							//alert(data.msg[0].space_rate);
							$('.div_roller_total_22').fadeOut();
							$('.get_success_total_22').html('Candidate Marks checking is Done Successfully.');
							$(".get_success_total_22").fadeIn();
							//$('input').val('');
							setTimeout(function(){ $('.get_success_total_22').fadeOut(); }, 2000);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 1000);
							setTimeout(function(){ $('.candset_no_'+canddoc_id).fadeOut(); }, 1000);
							//setTimeout(function(){ location.reload(); }, 1000);
							
						}else{

							$('.div_roller_total_22').fadeOut();
							error_message = "There have some Problem to Update in DB, Try Again.";
							error_message = error_message + "<br/>" + data.e_msg;
							$('.get_error_total_22').html(error_message);
							$(".get_error_total_22").fadeIn();
							setTimeout(function(){ $('.get_error_total_22').fadeOut(); }, delay);
							setTimeout(function(){ $('#myModal2').modal('hide'); }, 2000);

						}
						
					}
				});

			}else{
				$('.div_roller_total_22').fadeOut();
				$('#myModal2').modal('hide');
			}
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
		
		var u_startdate = $('#u_startdate').val();
		var advno = $("#advno option:selected").val();
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

		//alert(candset_all.length);
		for(var cntset = 0; cntset<candset_all.length; cntset++){
			var intv_id = $('input[name="intv_id_'+cntset+'"]').val();
			var intv_regno = $('input[name="intv_regno_'+cntset+'"]').val();
			var atten_intv = $('input[name="atten_intv_'+candset_all[cntset].invw_id+'"]:checked').val();
			var intv_lang = $('input[name="intv_lang_'+candset_all[cntset].invw_id+'"]:checked').val();
			var intv1_mark = $('input[name="intv1_mark_'+candset_all[cntset].invw_id+'"]').val();
			var intv2_mark = $('input[name="intv2_mark_'+candset_all[cntset].invw_id+'"]').val();

			if(intv_id == '' || intv_regno == ''){
				error_message = error_message + '<br/>ID Not Found, refresh the Page.';
			}
			if (atten_intv == '' || atten_intv == undefined) {
				$('.atten_intv_'+candset_all[cntset].invw_id).html('Attend Interview is Required');
				e_error = 1;
			} else if (atten_intv != 'Yes' && atten_intv != 'No') {
				$('.atten_intv_'+candset_all[cntset].invw_id).html('Value should be between Yes or No');
				e_error = 1;
			} else {
				$('.atten_intv_'+candset_all[cntset].invw_id).html('');
			}

			if(atten_intv == 'Yes'){

				if (intv_lang == '' || intv_lang == undefined) {
					$('.intv_lang_'+candset_all[cntset].invw_id).html('Language Knowledge is Required');
					e_error = 1;
				} else if (intv_lang != 'Yes' && intv_lang != 'No' && intv_lang != 'Not Applicable') {
					$('.intv_lang_'+candset_all[cntset].invw_id).html('Value should be between Yes or No or Not Applicable');
					e_error = 1;
				} else {
					$('.intv_lang_'+candset_all[cntset].invw_id).html('');
				}

				if(intv1_mark == ""){
					e_error = 1;
					$('.intv1_mark_'+candset_all[cntset].invw_id).html('Interview 1 Marks is Required');
				}else{
					if (!intv1_mark.match(onlynumerics_withdot)) {
						e_error = 1;
						$('.intv1_mark_'+candset_all[cntset].invw_id).html('Interview 1 Marks use only Numeric Value');
					}else if(parseFloat(intv1_mark) < 0.00){
						e_error = 1;
						$('.intv1_mark_'+candset_all[cntset].invw_id).html('Interview 1 Marks never lower than 0');
					}else if(parseFloat(intv1_mark) > 10.00){
						e_error = 1;
						$('.intv1_mark_'+candset_all[cntset].invw_id).html('Interview 1 Marks never greater than 10');
					}else{
						$('.intv1_mark_'+candset_all[cntset].invw_id).html('');
					}
				}

				if(intv2_mark == ""){
					e_error = 1;
					$('.intv2_mark_'+candset_all[cntset].invw_id).html('Interview 2 Marks is Required');
				}else{
					if (!intv2_mark.match(onlynumerics_withdot)) {
						e_error = 1;
						$('.intv2_mark_'+candset_all[cntset].invw_id).html('Interview 2 Marks use only Numeric Value');
					}else if(parseFloat(intv2_mark) < 0.00){
						e_error = 1;
						$('.intv2_mark_'+candset_all[cntset].invw_id).html('Interview 2 Marks never lower than 0');
					}else if(parseFloat(intv2_mark) > 5.00){
						e_error = 1;
						$('.intv2_mark_'+candset_all[cntset].invw_id).html('Interview 2 Marks never greater than 5');
					}else{
						$('.intv2_mark_'+candset_all[cntset].invw_id).html('');
					}
				}

			}else{
				$('.intv_lang_'+candset_all[cntset].invw_id).html('');
				$('.intv1_mark_'+candset_all[cntset].invw_id).html('');
				$('.intv2_mark_'+candset_all[cntset].invw_id).html('');
			}
			
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
			//$("#form123").submit();
			var form_data = new FormData();
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
				url: '<?php echo base_url() . "admincontrol/movement/update_tablecandidates_marks"; ?>',
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
			});

		}


	}

    </script>