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
            Cleanup Checker's Checking - Skip Section
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cleanup Checker's Checking - Skip Section</li>
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
				<div class="col-sm-2">
				  <div class="form-group">
					<label>Cleaning For</label>
					  <select class="form-control selectpicker" name="deloption" id="deloption" autocomplete="off">
						<option value="SKIP">SKIP</option>
						<option value="HOLD">HOLD</option>
				      </select>
				      <small class="text-error deloption"><?php echo form_error('deloption'); ?></small>
				  </div>
				</div>
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
				<div class="col-sm-4">
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" <?php if(empty($searchlist['advno'])){echo 'disabled';} ?> onchange="goto_checker_search();">
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
					<label>Checker List</label>
					  <select class="form-control selectpicker" name="chkno" id="chkno" autocomplete="off" <?php if(empty($searchlist['chkno'])){echo 'disabled';} ?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['chkno'])){ 
							foreach($usr_list as $uitems){ ?>
								<option value="<?php echo $uitems->u_id; ?>" <?php if($searchlist['chkno'] == $uitems->u_id){echo 'selected="selected"';} ?>><?php echo $uitems->firstname .' '. $uitems->lastname . ' (' .$uitems->mu_name. ')'; ?></option>
							<?php }} ?>
					  </select>
				      <small class="text-error chkno"><?php echo form_error('chkno'); ?></small>
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
				<div class="col-sm-12 text-center">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Cleanup Checking" />
                </div>
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
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
						$('#chkno').html('<option value="">---Select---</option>');
						$('#chkno').prop('disabled', true);
						
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
		
		var deloption = $("#deloption option:selected").val();
		var rf_set = $("#rf_set option:selected").val();
		var advno = $("#advno option:selected").val();
		var chkno = $("#chkno option:selected").val();

		if(deloption == ""){
			e_error = 1;
			$('.deloption').html('Cleaning ID is Required.');
		}

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

		if(chkno == ""){
			e_error = 1;
			$('.chkno').html('Checker is Required.');
		}else{
			if(!chkno.match(onlynumerics)){
				e_error = 1;
				$('.chkno').html('Checker only use Numeric Values, Check again.');
			}else{
				$('.chkno').html('');
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
			var conf_answer = confirm("Are you sure you want to Free the Checking against the Checker ?")
			if (conf_answer){
				$("#form123").submit();
			}else{
				$('.div_roller_total').fadeOut();
			}
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