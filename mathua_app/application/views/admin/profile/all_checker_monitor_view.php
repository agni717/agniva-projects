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
            All Checker's Monitoring Datewise
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">All Checker's Monitoring Datewise</li>
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
				<div class="col-sm-offset-1 col-sm-3">
				  <div class="form-group">
					<label>Checker List</label>
					  <select class="form-control selectpicker" name="chkno" id="chkno" autocomplete="off">
						<option value="ALL">ALL</option>
						<?php
							foreach($usr_list as $uitems){ ?>
								<option value="<?php echo $uitems->u_id; ?>" <?php if(!empty($searchlist['chkno'])){if($searchlist['chkno'] == $uitems->u_id){echo 'selected="selected"';}} ?>><?php echo $uitems->firstname .' '. $uitems->lastname . ' (' .$uitems->mu_name. ')'; ?></option>
							<?php } ?>
					  </select>
				      <small class="text-error chkno"><?php echo form_error('chkno'); ?></small>
				  </div>
				</div>
				
				<div class="col-sm-2">
					<div class="form-group">
				  	<label class="control-label">Start Date</label>
				    <input type="text" class="form-control" name="u_startdate" id="u_startdate" placeholder="Enter Start Date" value="<?php if(!empty(set_value('u_startdate'))){echo set_value('u_startdate');}else{echo date('d-m-Y');} ?>" autocomplete="off" />
				    <small class="text-error u_startdate"><?php echo form_error('u_startdate'); ?></small>
				    </div>
				</div>
				<div class="col-sm-1">
					<div class="form-group bootstrap-timepicker">
					<label class="control-label">Start Time<font style="color: red;">*</font></label>
				    <input type="text" class="form-control timepicker" name="u_starttime" id="u_starttime" placeholder="Start Time" value="<?php echo set_value('u_starttime'); ?>" autocomplete="off" />
				    <small class="text-error u_starttime"><?php echo form_error('u_starttime'); ?></small>
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">End Date<font style="color: red;">*</font></label>
				    <input type="email" class="form-control" name="u_enddate" id="u_enddate" placeholder="Enter End Date" value="<?php if(!empty(set_value('u_enddate'))){echo set_value('u_enddate');}else{echo date('d-m-Y');} ?>" autocomplete="off" />
				      <small class="text-error u_enddate"><?php echo form_error('u_enddate'); ?></small>
				    </div>
				</div>
				<div class="col-sm-1">
					<div class="form-group bootstrap-timepicker">
					<label class="control-label">Close Time<font style="color: red;">*</font></label>
				    <input type="text" class="form-control timepicker" name="u_endtime" id="u_endtime" placeholder="Closing Time" value="<?php echo set_value('u_endtime'); ?>" autocomplete="off" />
				    <small class="text-error u_endtime"><?php echo form_error('u_endtime'); ?></small>
				    </div>
				</div>
				<div class="col-sm-1 text-left" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
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
				
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
			  <div class="box-body">
								<?php if(!empty($appli_list)){ ?>
									<div class="row text-center" style="font-size:20px;">
									<!--<div class="col-sm-12"><a href="" onclick="printData();" class="btn btn-lg btn-primary">PRINT</a></div>-->
									</div>
									
				  <div class="table-responsive" id="psetsss">
				  					
									<hr style="border-color:#999;" />
                  <table class="table table-striped" id="datatable_tab11" width="100%">
	                  <thead style="font-weight: bold;">
					  		<td>Name (Level)</td>
	                  		<td>Approved</td>
	                  		<td>Rejected</td>
	                  		<td>Skipped</td>
	                  		<td>Doubtful</td>
							<td>Return</td>
							<td>Total</td>
	                  </thead>
                  	<tbody>
					  	<tr>
							<td colspan="7"><hr style="border-color:#999;" /></td>
						</tr>
                  		<?php $approv = $reject = $doubt = $skips = $retu = 0;
						  foreach($appli_list as $keys=>$users)
                  		{ 
							$approv = $approv + $users['t_approve'];   
							$reject = $reject + $users['t_reject'];
							$doubt = $doubt + $users['t_doubtful'];
							$skips = $skips + $users['t_skip'];
							if($users['chktype'] != 4){
								$retu = $retu + $users['t_return'];
							}
							?>
                  		<tr>
                  			<td><?php echo "<strong>".($keys + 1).".</strong> ".$users['cheker_name']." | ".$users['type_name']; ?></td>
                  			<td><?php echo $users['t_approve']; ?></td>
                  			<td><?php echo $users['t_reject']; ?></td>
							<td><?php echo $users['t_skip']; ?></td>
                  			<td><?php echo $users['t_doubtful']; ?></td>
							<td><?php echo $users['t_return']; ?></td>
							<td><strong><?php if($users['chktype'] == 4){echo $users['t_total']-$users['t_return'];}else{echo $users['t_total'];} ?></strong></td>
                  		</tr>	
						<?php } ?>
						<?php if(!empty($appli_list)){ ?>
						<tr>
							<td colspan="7"><hr style="border-color:#999;" /></td>
						</tr>
						<tr>
							<td><strong>Total</strong></td>
                  			<td><strong><?php echo $approv; ?></strong></td>
                  			<td><strong><?php echo $reject; ?></strong></td>
                  			<td><strong><?php echo $skips; ?></strong></td>
							<td><strong><?php echo $doubt; ?></strong></td>
							<td><strong><?php echo $retu; ?></strong></td>
							<td><strong><?php echo ($approv + $reject + $doubt + $skips + $retu); ?></strong></td>
						</tr>
						<?php } ?>
                  	</tbody>
                  </table>
				  </div>
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
    $(function () {
		$('#u_startdate, #u_enddate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
        $("#datatable_tab").dataTable();
    });
	  
	function printData()
	{
		var divToPrint=document.getElementById("psetsss");
		newWin= window.open("");
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();
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
						$('#chkno').html('<option value="">---Select---</option>');
						$('#chkno').prop('disabled', true);
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
			$('#chkno').html('<option value="">---Select---</option>');
			$('#chkno').prop('disabled', true);
		}
	}
	
	function goto_checker_search(){
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
		var advno = $("#advno option:selected").val();
		if(rf_set != "" && advno != ""){
			var form_data = new FormData();
			form_data.append("rf_set", rf_set);
			form_data.append("advno", advno);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/dashboard/get_allchecker_against_advertisement') ?>",
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
						$('#chkno').html(data.op_set);
						$('#chkno').prop('disabled', false);
						
					}else{
						//$('.div_roller_total').fadeOut();
						$('#chkno').html('<option value="">---Select---</option>');
						$('#chkno').prop('disabled', true);
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}else{
			//$('.div_roller_total').fadeOut();
			$('#chkno').html('<option value="">---Select---</option>');
			$('#chkno').prop('disabled', true);
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
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
		//var rf_set = $("#rf_set option:selected").val();
		//var advno = $("#advno option:selected").val();
		var chkno = $("#chkno option:selected").val();
		var u_startdate = $('#u_startdate').val();
		var u_starttime = $('#u_starttime').val();
		var u_enddate = $('#u_enddate').val();
		var u_endtime = $('#u_endtime').val();

		/*if(rf_set == ""){
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
		}*/

		if(chkno == ""){
			e_error = 1;
			$('.chkno').html('Checker is Required.');
		}else{
			if(chkno != "ALL"){
				if(!chkno.match(onlynumerics)){
					e_error = 1;
					$('.chkno').html('Checker only use Numeric Values, Check again.');
				}else{
					$('.chkno').html('');
				}
			}else{
				$('.chkno').html('');
			}	
		}

		if(u_startdate == ""){
		e_error = 1;
		$('.u_startdate').html('Start Date is Required.');
		}else{
			if(isDatecheck_dmY(u_startdate) == false){
				e_error = 1;
				$('.u_startdate').html('Start Date Format check properly.');
			}else{
				$('.u_startdate').html('');
			}
		}
		if(u_enddate == ""){
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
			$('.u_starttime').html('Start Time is Required.');
		}else{
			$('.u_starttime').html('');
		}
		if(u_endtime == ""){
			e_error = 1;
			$('.u_endtime').html('End Time is Required.');
		}else{
			$('.u_endtime').html('');
		}
		
		if(u_startdate != "" && u_enddate != "" && u_starttime != "" && u_endtime != ""){
			var valuestart = check_timeall(u_starttime);
			var valuestop = check_timeall(u_endtime);
			//var task_start_date_update = task_start_date.replace(/-/g, "/");
			//var task_end_date_update = task_end_date.replace(/-/g, "/");
			var newDate = u_startdate.split("-");
			var newDateend = u_enddate.split("-");
			var task_work_date_update = newDate[2] + '-' + newDate[1] + '-' + newDate[0];
			var task_work_date_update_end = newDateend[2] + '-' + newDateend[1] + '-' + newDateend[0];
			var timediff = new Date(task_work_date_update_end + "T" + valuestop) - new Date(task_work_date_update + "T" + valuestart);
			var timediff = (timediff/1000);
			var hourDiff = (timediff/3600);
			var minuteDiff = (timediff - (hourDiff * 3600));
			if(hourDiff < 0){
				e_error = 1;
				error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
			}else if(hourDiff == 0){
				if(minuteDiff <= 0){
					e_error = 1;
					error_message = error_message + '<br/>Start DateTime and End DateTime have some problem, check Properly.';
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
					error_message = error_message + '<br/>Check the total timing.';
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
			//alert(task_start_time);exit;
			//alert(rehash);
			$("#form123").submit();
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
		
    </script>