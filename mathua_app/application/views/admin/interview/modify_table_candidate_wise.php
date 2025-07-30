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
		  		Modify Candidate Table
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Modify Candidate Table</li>
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
                <div class="col-sm-12" style="font-size:20px;">
                <strong>Recruitment For :</strong> <?php echo $appli_details->rm_name; ?><br/>
                <strong>Advertisement No. :</strong> <?php echo $appli_details->adv_no; ?><br/>
                <strong>Apply Discipline :</strong> <?php echo $discip_details->catm_name; ?><br/>
                <strong>Full Name :</strong> <?php echo $appli_details->f_full_name; ?><br/>
                <strong>Application No : </strong><?php echo $appli_details->f_application_no; ?><br/>
                <strong>Interview Date : </strong><?php echo date('d-m-Y',strtotime($sft_detl->shift_date)); ?><br/>
				<strong>Location : </strong><?php foreach($vn_list as $vnss){ 
						if($sft_detl->shift_venue == $vnss->address_id){echo $vnss->address_name;break;}
					} ?><br/>
                <strong>Shift Timing : </strong><?php echo date('h:i A',strtotime($sft_detl->shift_start_time))." To ".date('h:i A',strtotime($sft_detl->shift_end_time)); ?><br/><br/>
                </div>
				<div class="clearfix"></div>
				<div class="col-sm-offset-4 col-sm-4">
					<div class="form-group">
					<label class="control-label">Post Category</label>
					<input type="hidden" class="form-control" name="advno" id="advno" value="<?php echo $appli_details->f_applied_for; ?>" autocomplete="off" />
					<select class="form-control" name="advcat_name" id="advcat_name" autocomplete="off">
						<option value="<?php echo $appli_details->fu_category; ?>"><?php echo $discip_details->catm_name; ?></option>
					</select>
					<small class="text-error advcat_name"><?php echo form_error('advcat_name'); ?></small>		  	
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
				<div class="col-sm-3">
				  <div class="form-group">
					<label>Venue</label>
					  <select class="form-control selectpicker" name="venueno" id="venueno" autocomplete="off" onchange="goto_check_totaltab();">
							<option value="">---Select---</option>
							<?php foreach($vn_list as $vnss){ ?>
								<option value="<?php echo $vnss->address_id; ?>"><?php echo $vnss->address_name; ?></option>
							<?php } ?>
					  </select>
				      <small class="text-error venueno"><?php echo form_error('venueno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
				  	<label class="control-label">Interview Shift</label>
					<select class="form-control" name="shift_name" id="shift_name" autocomplete="off" onchange="goto_check_shiftwisetab();">
						<option value="">---Select---</option>
					</select>
					<small class="text-error shift_name"><?php echo form_error('shift_name'); ?></small>
				    </div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
					<label class="control-label">Select Table No.<font style="color: red;">*</font></label>
				    <select class="form-control" name="table_exactno" id="table_exactno" autocomplete="off">
						<option value="">---Select---</option>
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
				<div class="col-sm-12 text-center" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Update" />
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
	//var slagsetno = 3;
    $(function () {
		$('#u_startdate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		//$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
       // $("#datatable_tab").dataTable();
    });
	  	

	function goto_submit_button(){
		$('.div_roller_total').fadeIn();
		$('#pa_target_submit').prop('disabled', true);
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		
		var u_startdate = $('#u_startdate').val();
		var advno = $("#advno").val();
		var advcat_name = $('#advcat_name option:selected').val();
		var venueno = $('#venueno option:selected').val();
		var shift_name = $('#shift_name option:selected').val();
		var table_exactno = $('#table_exactno option:selected').val();

		if(advno == "" || advcat_name == ""){
			error_message = error_message + '<br/>Advertisement OR Category not Found, Refresh the Page.';
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
		}


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
		var advno = $("#advno").val();
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