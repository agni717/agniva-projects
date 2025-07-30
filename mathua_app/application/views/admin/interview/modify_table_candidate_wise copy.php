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
                <strong>Shift Timing : </strong><?php echo date('h:i A',strtotime($sft_detl->shift_start_time))." To ".date('h:i A',strtotime($sft_detl->shift_end_time)); ?><br/><br/>
                </div>
				
				<div class="clearfix"></div>
				<div class="col-sm-offset-4 col-sm-4">
					<div class="form-group">
					<label class="control-label">Select Table No.<font style="color: red;">*</font></label>
				    <select class="form-control" name="table_exactno" id="table_exactno" autocomplete="off">
						<option value="">---Select---</option>
						<?php foreach($shifttab_details as $tabsets){ ?>
                            <option value="<?php echo $tabsets->utable_name; ?>" <?php if($intv_detl->invw_tableno == $tabsets->utable_name){echo 'selected="selected"';} ?>><?php echo $tabsets->utable_name. ' No. Table'; ?></option>
                        <?php } ?>
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
		//$('#u_startdate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
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
		
		var table_exactno = $('#table_exactno option:selected').val();

		
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

    </script>