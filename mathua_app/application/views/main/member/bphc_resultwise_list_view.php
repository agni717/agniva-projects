<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<link href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()."js/dtable/buttons.dataTables.min.css"; ?>" rel="stylesheet" type="text/css">
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
				<h1 class="panel-title">Testing Results</h1>
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
				<div class="">
				<?php echo form_open_multipart('','class="form-horizontal" id="form123"'); ?>

					<div  class="form-group">
                        <div class="col-md-4">
					      <label class="bmd-label-floating">Select Result Type</label>
                          <select class="form-control" name="r_set" id="r_set" onchange="goto_resulttype_check();">
                          <option value="">--- Select ---</option>
                          <option value="Received" <?php if(!empty($datelist['rset'])){ if($datelist['rset'] == "Received"){echo 'selected="selected"';}} ?>>Report Received</option>
             			  <option value="Pending" <?php if(!empty($datelist['rset'])){ if($datelist['rset'] == "Pending"){echo 'selected="selected"';}} ?>>Report Pending</option>
						  </select>	
                          <small class="text-error r_set"><?php echo form_error('r_set'); ?></small>				
						</div>
						<div class="col-md-4">
					      <label class="bmd-label-floating">Select Result</label>
                          <select class="form-control" name="r_report" id="r_report" <?php if(!empty($datelist['rset'])){ if($datelist['rset'] != "Received"){echo 'disabled=""';}}else{echo 'disabled=""';} ?>>
                          <option value="">---Select---</option>
						  <option value="Positive" <?php if(!empty($datelist['rreport'])){ if($datelist['rreport'] == "Positive"){echo 'selected="selected"';}} ?>>Positive</option>
						  <option value="Negative" <?php if(!empty($datelist['rreport'])){ if($datelist['rreport'] == "Negative"){echo 'selected="selected"';}} ?>>Negative</option>
						  <option value="Rejected" <?php if(!empty($datelist['rreport'])){ if($datelist['rreport'] == "Rejected"){echo 'selected="selected"';}} ?>>Rejected</option>
						  </select>	
                          <small class="text-error r_report"><?php echo form_error('r_report'); ?></small>				
                        </div>
						<div class="col-md-4">
						  <label class="bmd-label-floating">Select Testing Lab</label>
                          <select class="form-control" name="lab_set" id="lab_set">
                          <option value="">--- Select ---</option>
						  	<?php foreach($lab_list as $a_labs){ ?>
							<option value="<?php echo $a_labs->lab_name; ?>" <?php if(!empty($datelist['labset'])){ if($datelist['labset'] == $a_labs->lab_name){echo 'selected="selected"';}} ?>><?php echo $a_labs->lab_name; ?></option>
							<?php } ?>
                          </select>	
                          <small class="text-error lab_set"><?php echo form_error('lab_set'); ?></small>			
                        </div>
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
                    </div>
                    <div class="col-sm-12 text-center">
                     	<input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />                     				   
                    </div>
                    <div class="clearfix"></div>
                   <?php echo form_close(); ?>
				</div>

		<?php if(!empty($formlist)){ ?>		
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
					<th>Sl No</th>
					<?php if($this->session->userdata('member_utype') <= 5){ ?>
					<th>Action</th>
					<?php } ?>
					<th>Health Dist.</th>
					<th>Date</th>
					<th>SRF-ID</th>
					<th>Name</th>
					<th>Mobile</th>
					<th>Migrant Workers</th>
					<th>Outside State</th>
					<th>Outside District</th>
					<th>Resident Bankura</th>
					<th>Block</th>
					<th>GP-Name</th>
					<th>Municipality</th>
					<th>State</th>
					<th>Swab Collected</th>
					<th>Pooling</th>
					<th>Standalone</th>
					<th>Quarantine</th>
					<th>Lab</th>
					<th>Memo No</th>
					<th>Memo Date</th>
					<th>Report Status</th>
					<th>Report Date</th>
					
					<th>Update By</th>
				</thead>
				<tbody>
				<?php foreach($formlist as $keys=>$forms){ ?>
					<tr>
						<td><?php echo $keys+1; ?></td>
						<?php if($this->session->userdata('member_utype') <= 5){ ?>
						
						<td><?php if(empty($forms->collect_result)){
						
						if($this->session->userdata('member_utype') == 3){
						if($this->session->userdata('member_id') == $forms->collect_createby){ ?>
						<a class="btn btn-xs btn-warning" onclick="reportupdate('<?php echo $forms->collect_srf; ?>', '<?php echo $forms->collect_name; ?>', <?php echo $forms->collect_id; ?>);" style="margin-bottom:5px;">Update Result</a>
						<?php }}
						elseif($this->session->userdata('member_utype') == 1 || $this->session->userdata('member_utype') == 2){ ?>
						<a class="btn btn-xs btn-warning" onclick="reportupdate('<?php echo $forms->collect_srf; ?>', '<?php echo $forms->collect_name; ?>', <?php echo $forms->collect_id; ?>);" style="margin-bottom:5px;">Update Result</a>
						<?php }}else{ echo '<span style="color:green">Report Received</span>'; 
							if($this->session->userdata('member_utype') == 1){
								if($this->session->userdata('member_id') == 35){ ?>
									<a onclick="return confirm('You are about to Delete the Result. This cannot be undone. Are you sure?');" class="btn btn-xs btn-danger" href="<?php echo base_url()."member/new_bphc_form_report_deletion/".$forms->collect_id; ?>">Delete Report</a>
							<?php }
							}
						} ?>
						</td>
						
						<?php } ?>
						<td><?php echo $forms->fuser_name; ?></td>
						<td><?php echo date('d/m/Y',strtotime($forms->collect_date)); ?></td>
						<td><?php echo $forms->collect_srf; ?></td>
						<td><?php echo $forms->collect_name; ?></td>
						<td><?php echo $forms->collect_mobile; ?></td>
						<td><?php echo $forms->collect_worker; ?></td>
						<td><?php echo $forms->outstate_name; ?></td>
						<td><?php echo $forms->dist_name; ?></td>
						<td><?php echo $forms->collect_resident; ?></td>
						<td><?php echo $forms->block_name; ?></td>
						<td><?php echo $forms->gp_name; ?></td>
						<td><?php echo $forms->collect_munici; ?></td>
						<td><?php echo $forms->state_name; ?></td>
						<td><?php echo $forms->collect_swap; ?></td>
						<td><?php echo $forms->collect_pool; ?></td>
						<td><?php echo $forms->collect_stand; ?></td>
						<td><?php if($forms->collect_q_home == "Yes"){echo "Home";}
								elseif($forms->collect_q_inst == "Yes"){echo "Institutional";}
								elseif($forms->collect_q_semi_inst == "Yes"){echo "Semi Institutional";} ?></td>
						<td><?php echo $forms->collect_lab; ?></td>
						<td><?php echo $forms->collect_memo; ?></td>
						<td><?php if(!empty($forms->collect_m_date)){ echo date('d/m/Y',strtotime($forms->collect_m_date));} ?></td>
						<td><?php echo $forms->collect_result; ?></td>
						<td><?php if(!empty($forms->collect_reportdate)){ echo date('d/m/Y',strtotime($forms->collect_reportdate));} ?></td>
						
						<td><?php if(!empty($forms->collect_modifyby)){
							echo $forms->update_user;
						} ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
				<?php } ?>
        </div>
		</div>
	    
	            
			</div>
		</div>
	</div>
</div>

 
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Report</h4>
      </div>
      <div class="modal-body">
	  	<div class="row">
		  <div class="col-sm-12 text-center"><h5><strong>SRF ID : </strong><spna class="collectsrf"></span></h5></div>
		  <div class="col-sm-12 text-center"><h5><strong>NAME : </strong><spna class="collectname"></span></h5></div>
        </div>
		<div class="row">
		  <div class="col-sm-6">
		  	<div class="form-group">
				<label class="control-label">Test Result:</label>
				<input type="hidden" id="report_formid" name="report_formid" />
				<select class="form-control" name="report_stat" id="report_stat">
				<option value="">---Select---</option>
				<option value="Positive">Positive</option>
				<option value="Negative">Negative</option>
				<option value="Rejected">Rejected</option>
				</select>
				<small class="text-error report_stat"><?php echo form_error('report_stat'); ?></small>
        	</div>
		  </div>
          <div class="col-sm-6">
		  	<div class="form-group">
				<label class="control-label">Report Receive Date:</label>
				<input type="text" class="form-control" name="report_date" id="report_date" Placeholder="DD-MM-YYYY">
				<small class="text-error report_date"><?php echo form_error('report_date'); ?></small>
        	</div>
		  </div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<div align="center">
					<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
					<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
					<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-offset-4">
				<button onclick="gotoclclickbutton();" class="form-control btn btn-warning">Submit</button>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('main/component/footer'); ?>
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.bootstrap.min.js"></script>
<script>
	$(function(){
		$( "#report_date, #p_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		$('#d_table_show').DataTable({
			//"order": []
			//"order": [[ 0, "asc" ]]
			dom: 'lBfrtip',
        	buttons: [
            {
                extend: 'pdf',
                footer: true,
				orientation: 'landscape',
				title: 'Portal for District Administration' + '\n' + 'BANKURA',
				customize: function(doc) {
					doc.styles.title = {
					fontSize: '20',
					alignment: 'center'
					}   
				},  
				pageSize: 'A2',
                exportOptions: {
                        columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
						columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                        columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '<br/>' + 'BANKURA',
                footer: true,
                exportOptions: {
                        columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                    }
            }  
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            //'pdfHtml5',
            //'print'
        	]
		});
	});

	function goto_resulttype_check(){
		var r_set = $("#r_set option:selected").val();
		if(r_set == "Received"){
			$('#r_report').val('');
			$('#r_report').prop('disabled', false);
		}else{
			$('#r_report').val('');
			$('#r_report').prop('disabled', 'disabled');
		}
	}

function goto_submit_button(){
	
	$('.div_roller_total').fadeIn();
	var delay = 8000;
	var e_error = 0;
	var error_message = 'There have some errors plese check above, Try again.';
	var onlynumerics = /^[0-9]+$/;
    var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
	//var applicant_type = $("input[name='applicant_type']:checked").val();
    //var b_category = $("#b_category option:selected").val();
  
	//var p_date = $('#p_date').val();
	//var hd_set = $("#hd_set option:selected").val();
	var r_set = $("#r_set option:selected").val();
	var r_report = $("#r_report option:selected").val();
	var lab_set = $("#lab_set option:selected").val();
	
	//goto_datecheck_book();
	if(r_set == "" && lab_set == "" && r_report == ""){
		e_error = 1;
		error_message = 'Atleast 1 input needed, Check again.';
	}else if(r_set == "" && lab_set == "" && r_report != ""){
		e_error = 1;
		error_message = 'Atleast 1 input needed, Check again.';
	}else if(r_set == "" && lab_set != "" && r_report != ""){
		e_error = 1;
		error_message = 'Report Type input needed, Check again.';
	}
  
	//alert(fname);
	if(e_error == 1){
		$('.div_roller_total').fadeOut();
		$('.get_error_total').html(error_message);
		$(".get_error_total").fadeIn();
		$(".text-error").fadeIn();
		/*e_error = 0;
		error_message = '';*/
		setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		
	}else{
		//alert("ALL CLEAR");exit;
      	$('#form123').submit();
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

	function reportupdate(srf, name, rid){
		if((srf != "") && (name != "") && (rid != "")){
			$('.collectsrf').html(srf);
			$('.collectname').html(name);
			$('#report_formid').val(rid);
			$('#myModal').modal('show');
		}	
	}

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 6000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		
    	/*var ap_date = $('#ap_date').val();
    	var ap_srfid = $('#ap_srfid').val();
    	var ap_name = $('#ap_name').val();
		var mig_labour = $("input[name='mig_labour']:checked").val();
		var ap_state = $('#ap_state option:selected').val();*/
		var report_formid = $('#report_formid').val();
		var report_date = $('#report_date').val();
		var report_stat = $("#report_stat option:selected").val();
		/*var ap_gp = $("#ap_gp option:selected").val();
		var s_collect = $("input[name='s_collect']:checked").val();
		var s_type = $("input[name='s_type']:checked").val();
		var ap_symptom = $("input[name='ap_symptom']:checked").val();
		var ap_quaran = $("input[name='ap_quaran']:checked").val();*/
		
		if(report_date == ""){
			e_error = 1;
			$('.report_date').html('Date is Required.');
		}else{
			if(isDatecheck(report_date) == false){
				e_error = 1;
				$('.report_date').html('Date Format check properly and Try Again.');
			}else{
				$('.report_date').html('');
			}	
		}
		if(report_stat == ""){
			e_error = 1;
			$('.report_stat').html('Result is Required.');
		}else{
			if(!report_stat.match(alphaletters)){
				e_error = 1;
				$('.report_stat').html('Result only use Alphabets, Check Again.');
			}else{
				$('.report_stat').html('');
			}	
		}

		if(report_formid == ""){
			e_error = 1;
			error_message = 'There have some ID problem, Refresh and Try again.';
		}
		
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/update_reportvalue_inform"; ?>',
				data:{report_date: report_date, report_stat: report_stat, report_formid: report_formid},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Report is Updated Successfully.');
						$(".get_success_total").fadeIn();
						$('#report_formid, #report_date, #report_stat').val('');
						//$('#plot_otherinfo, #ifsc_code_sd').html('');
						setTimeout(function(){ $('.get_success_total').fadeOut();$('#myModal').modal('hide'); }, 3000);
						//setTimeout(function(){ window.location.replace("<?php //echo site_url('member/testing_result_list')?>/"); }, 3000);
						
						
					}else{
						$('.div_roller_total').fadeOut();
						error_message = "There have some problem to Store Data, Try after some time.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});

		}

  	}	
</script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jquery.dataTables.min.js"; ?>"></script>  
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.buttons.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jszip.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/pdfmake.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/vfs_fonts.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.html5.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.print.min.js"; ?>"></script>