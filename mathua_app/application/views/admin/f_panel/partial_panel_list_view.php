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
        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <div class="col-lg-12">
				<!--<div class="text-center"><a href="javascript:;" onclick="printData();" class="btn btn-lg btn-primary">PRINT</a></div>
              <div id="psetsss">
				<?php //echo $content_all; ?>
			  </div>-->
			  <!-- TO DO List -->
              <div class="box box-warning">
                <!-- /.box-header -->
				<div class="box-body">
				<div align="center">
					<span align="center" style="font-size:25px;font-weight:normal;">Panel for <?php echo $app_details->rm_name; ?></span><br/>
					<span align="center" style="font-size:22px;font-weight:normal;">Advertisement No.: <?php echo $app_details->adv_no." (".$dicipline_detail->catm_name; ?>)</span><br/>
					<span align="center" style="font-size:22px;font-weight:normal;"><b><u>PANEL LIST (<?php echo $section_detail->caste_name; ?>)</u></b></span>
					</div>
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
				<?php echo form_open_multipart('','class="" id="form123"'); ?>
				
              
					<?php if(!empty($meritlist)){ ?>
		
							<table class="table table-striped" id="datatable_tab123" width="100%">
								<thead style="font-weight: bold;">
										<td>Action.</td>
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
										<td><input type="checkbox" name="checker_ref_candidate[]" id="checker_ref_candidate_<?php echo $keys+1; ?>" value="<?php echo $quaries->f_application_no; ?>" checked /></td>
										<td><?php echo $keys+1; ?></td>
										<td><?php echo $quaries->f_full_name; ?></td>
										<td><?php echo $quaries->f_application_no; ?></td>
										<td><?php echo date('d-F-Y',strtotime($quaries->fu_dob)); ?></td>
										<td><?php echo $quaries->caste_name; ?></td>
										<td><?php echo $quaries->fu_pwd; ?></td>
										<td><?php echo $quaries->cr_total_marks; ?></td>
									</tr>	
									<?php } ?>
								</tbody>
							</table>

				  	<?php } ?>
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
                </div><!-- /.box-body -->
				<?php echo form_close(); ?>
                </div>
              </div><!-- /.box -->
			</div>
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

	function printData()
	{
		var divToPrint=document.getElementById("psetsss");
		newWin= window.open("");
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();
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
		var chk_counter = $('input[name="checker_ref_candidate[]"]:checked').length;
			
		if(chk_counter == 0){
			e_error = 1;
			error_message = 'No Candidate is Selected, please check again.';
		}
		//return;
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

	}

    </script>