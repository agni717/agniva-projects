<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<link href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
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
				<h1 class="panel-title">Stock VTM List</h1>
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
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
					<th>Sl No</th>
					<?php if($this->session->userdata('member_utype') <= 2){ ?>
						<th>Center</th>
					<?php } ?>
					<th>Date</th>
					<th>VTM Existing</th>
					<th>VTM Sub-Alloted</th>
					<th>VTM Utilize</th>
					<th>VTM Receive</th>
					<th>VTM Balance</th>
				</thead>
				<tbody>
				<?php foreach($vtmlist as $keys=>$forms){ ?>
					<tr>
						<td><?php echo $keys+1; ?></td>
						<?php if($this->session->userdata('member_utype') <= 2){ ?>
							<td><?php echo $forms->hd_name; ?></td>
						<?php } ?>
						<td><?php echo date('d/m/Y',strtotime($forms->vtm_date)); ?></td>
						<td><?php echo $forms->vtm_exist; ?></td>
						<td><?php echo $forms->vtm_allot; ?></td>
						<td><?php echo $forms->vtm_utilize; ?></td>
						<td><?php echo $forms->vtm_receive; ?></td>
						<td><?php echo $forms->vtm_balance; ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
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
				<select type="text" class="form-control" name="report_stat" id="report_stat">
				<option value="">---Select---</option>
				<option value="Positive">Positive</option>
				<option value="Negative">Negative</option>
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
		$( "#report_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		$('#d_table_show').DataTable({
			//"order": []
			//"order": [[ 0, "asc" ]]
		});
	});

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
						setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('member/testing_list')?>/"); }, 3000);
						
						
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