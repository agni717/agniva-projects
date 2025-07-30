<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />


        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Advertisement Resubmission Application List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Advertisement Resubmission Application List</li>
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
				<div class="col-sm-offset-1 col-sm-5">
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
				<div class="col-sm-5">
				  <div class="form-group">
					<label>Advertisement No.</label>
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" <?php if(empty($searchlist['advno'])){echo 'disabled';} ?>>
						<option value="">---Select---</option>
						<?php if(!empty($searchlist['advno'])){ 
							foreach($adv_catg as $cats){ ?>
								<option value="<?php echo $cats->adv_auto_genno; ?>" <?php if($searchlist['advno'] == $cats->adv_auto_genno){echo 'selected="selected"';} ?>><?php echo $cats->adv_no; ?></option>
							<?php }} ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				<div class="clearfix"></div>
				<div class="col-sm-12 text-center" style="margin-top:25px;">
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
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Advertisement</td>
	                  		<!--<td>Recruitment For</td>-->
	                  		<td>Resubmission Start Time</td>
	                  		<td>Resubmission End Time</td>
							<td>Reason of Submission</td>
	                  		<td>Action</td>
					  </thead>
                  	<tbody>
                  		<?php foreach($adv_list as $keys=>$quaries)
                  		{ ?>
                  		<tr>
                  			<td><?php echo $keys+1; ?></td>
                  			<td><?php echo $quaries->adv_no; ?></td>
                  			<!--<td><?php //echo $quaries->rm_name; ?></td>-->
                  			<td><?php echo date('d-m-Y h:i A',strtotime($quaries->adv_resub_starttime)); ?></td>
                  			<td><?php echo date('d-m-Y h:i A',strtotime($quaries->adv_resub_endtime)); ?></td>
							<td><?php echo $quaries->adv_resub_reasons; ?></td>
                  			<td width="100px">
                  				<!--<?php //if($quaries->adv_status == 1){ ?>
									<a href="<?php //echo base_url().'admincontrol/advertisement_set/lock_advertisement/'.$quaries->adv_auto_genno; ?>" title="Lock Record"><i class="fa fa-unlock text-warning"></i></a>&nbsp;
								<?php //}else{ ?>
									<a href="<?php //echo base_url().'admincontrol/advertisement_set/unlock_advertisement/'.$quaries->adv_auto_genno; ?>" title="Unlock Record"><i class="fa fa-lock text-warning"></i></a>&nbsp;
								<?php //} ?>-->
								<?php if(strtotime(date('Y-m-d H:i:s')) > strtotime($quaries->adv_resub_endtime) && $quaries->adv_resub_chk_stat != 1){ ?>
								<a onclick="return confirm('You are about to Process all Advertisement records. This cannot be undone. Are you sure?');" href="<?php echo base_url().'admincontrol/advertisement_set/processall_the_resubmit_data_of_adv/'.$quaries->adv_resub_id.'/'.$searchlist['advno']; ?>" title="Process Record" class="btn-sm btn-warning"><i class="fa fa-list"></i> Process Now</a>
								<?php } ?>
                  			</td>
						</tr>	
                  		<?php } ?>
                  	</tbody>
                  </table>
				  </div>
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
		$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
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
			
			var rf_set = $("#rf_set option:selected").val();
			//var advno = $("#advno option:selected").val();
			
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
			
			/*if(advno == ""){
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
		
    </script>