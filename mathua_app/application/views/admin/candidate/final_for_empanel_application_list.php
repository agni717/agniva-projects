<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

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
            Candidate's Exam Complition List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Exam Complition List</li>
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
				<div class="col-sm-2 text-left" style="margin-top:25px;">
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
					<div class="row">
						<div class="col-sm-9">
							<label class="checkbox-inline"><input type="checkbox" name="setall_lvl" id="setall_lvl" value="ALL" autocomplete="off" onclick="gotoselectall();">SELECT ALL</label>
							<hr/>
							<div class="row">
								<input type="hidden" name="adv_setno" id="adv_setno" value="<?php if(!empty($searchlist['advno'])){echo $searchlist['advno'];} ?>" autocomplete="off" />
								<!--<?php //foreach($appli_list as $appsets){ ?>
								<div class="col-sm-4">
									<label class="checkbox-inline"></label>
								</div>
								<?php //} ?>-->
							</div>
							<br/><small class="text-error app_lvl"><?php //echo form_error('app_lvl'); ?></small>
							<div align="center">
								<div class="get_error_total7" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total7" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total7" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
							</div>
							<!--<div align="left">
								<input type="button" id="app_target_submit" onclick="goto_approve_button()" class="btn btn-primary pull-center"  value="Approve" />
							</div>-->
						</div>
					</div>
					
					<div class="table-responsive">
					  <table class="table table-striped" id="datatable_tab" width="100%">
						  <thead style="font-weight: bold;">
								<td>Sl No.</td>
								<!--<td>Recruitment For</td>
								<td>Advertisement No.</td>-->
								<td>Application No.</td>
								<td>Applicant Name</td>
								<td>AdmitCard No.</td>
								<td>Academic Marks</td>
								<td>Experience Marks</td>
								<td>Interview Marks</td>
								<td>Action</td>
						  </thead>
						<tbody>
							<?php foreach($appli_list as $keys=>$users)
							{ ?>
							<tr>
								<td><?php echo ($keys + 1); ?></td>
								<!--<td><?php //echo $users->rm_name; ?></td>
								<td><?php //echo $users->adv_no; ?></td>-->
								<td><?php echo $users->cr_application_master; ?></td>
								<td><?php echo $users->f_full_name; ?></td>
								<td><?php echo $users->cr_admitcard_no; ?></td>
								<td><?php echo $users->cr_academic; ?></td>
								<td><?php echo $users->cr_experience; ?></td>
								<td><?php echo $users->cr_interview_1; ?></td>
								<!--<td><?php //echo date('d-m-Y h:i A',strtotime($users->modify_date)); ?></td>-->
								<td>
									<input type="checkbox" name="app_lvl" value="<?php echo $users->cr_application_master; ?>" autocomplete="off">&nbsp;
									<a target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_application_details/'.$users->cr_application_master; ?>" title="View User"><i class="fa fa-eye text-warning"></i></a>&nbsp;
									<!--<a target="_blank" href="<?php //echo base_url().'admincontrol/candidates/print_candidate_admin_card/'.$users->cr_application_master; ?>" title="Print AdmitCard"><i class="fa fa-print text-warning"></i></a>
									<?php //if($users->f_status == 1){ ?>	
									<a href="#<?php //echo base_url().'admincontrol/front_user/lock_fuser/'.$users->f_uid; ?>" title="Lock User"><i class="fa fa-eye text-warning"></i></a>
									<?php //} else { ?>
									<a href="#<?php //echo base_url().'admincontrol/front_user/unlock_fuser/'.$users->f_uid; ?>" title="Unock User"><i class="fa fa-lock text-warning"></i></a>
									<?php //} ?>
									<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/front_user/delete_fuser/'.$users->f_uid; ?>" title="Delete User"><i class="fa fa-trash-o text-warning"></i></a>-->
									
								</td>
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
    $(function(){
		$('.alert-error, .text-error').delay(8000).fadeOut();

	<?php if(!empty($appli_list)){
	$allsets = count((array)$appli_list);	?>	
	$('input[name="app_lvl"]').change(function() {
			var allchecked = $('input[name="app_lvl"]:checked').length;
			//alert(allchecked);
			var countall = parseInt('<?php echo $allsets; ?>');
			if(allchecked == countall){
				$("#setall_lvl").prop('checked',true);
			}else{
				$("#setall_lvl").prop('checked',false);
			}
		});
	<?php } ?>
	
	});
	function gotoselectall(){
		if($('#setall_lvl').prop('checked')){
			$("input:checkbox").prop('checked',true);
		}
		else{
			$("input:checkbox").prop('checked',false);
		}
	}
	
	function goto_approve_button(){
		$('.div_roller_total7').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_withspaces = /^[A-Za-z0-9\-]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
		//var chk_counter = $('input[name="app_lvl[]"]:checked').length;
		var adv_setno = $("#adv_setno").val();
		var app_gen = [];
		$.each($("input[name='app_lvl']:checked"), function(){            
			app_gen.push($(this).val());
		});
		
		if(app_gen.length == 0){
			e_error = 1;
			$('.app_lvl').html('No Application is Selected, please check again.');
		}else{
			$('.app_lvl').html('');
		}
		
		if(adv_setno == ""){
			e_error = 1;
			error_message = error_message + '<br/>Advertisement No. is Missing. Refresh the Page.';
		}
		
		if(e_error == 1){
			$('.div_roller_total7').fadeOut();
			$('.get_error_total7').html(error_message);
			$(".get_error_total7").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total7').fadeOut(); }, delay);
		}else{
			//alert(newhash);
			//alert(rehash);
			var form_data = new FormData();
			form_data.append('app_gen',app_gen);
			form_data.append('advno',adv_setno);
			$.ajax({
				method:'POST',
				url:'<?php echo site_url("admincontrol/candidates/update_application_final_approval"); ?>',
				data:form_data,
				dataType:'JSON',
				contentType: false,
				processData: false,
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total7').fadeOut();
						$('.get_success_total7').html('Admit Card is issued against the Applications Successfully.');
						$(".get_success_total7").fadeIn();
						$('input, select').val('');
						$('input, select').html('');
						setTimeout(function(){ $('.get_success_total7').fadeOut(); }, 3000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/final_approval_list')?>"); }, 3000);
						
						
					}else{
						$('.div_roller_total7').fadeOut();
						error_message = "There have some problem, Try again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total7').html(error_message);
						$(".get_error_total7").fadeIn();
						setTimeout(function(){ $('.get_error_total7').fadeOut(); }, delay);
					}
					
				}
			});
		}
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
			var advno = $("#advno option:selected").val();
			
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
					$('.advno').html('Advertisement No. only use AlphaNumeric Values, Check again.');
				}else{
					$('.advno').html('');
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
		
    </script>