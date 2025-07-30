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
            Approve Application List
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Approve Application List</li>
          </ol>
        </section>
		<?php $str_arr = array(
							//'f_mobile' => 'Mobile',
							//'f_email' => 'Email-ID',
							'fu_dob' => 'Date of Birth',
							'fu_address' => 'Address',
							'fu_photo_doc' => 'Photo',
							'fu_signature_doc' => 'Signature',
							'fu_caste' => 'Caste',
							'fu_pwd' => 'PWD',
							'fu_exempted' => 'Exempted',
							'fu_exservice' => 'Ex-Service',
							'fu_ews' => 'Sportsman',
							'fu_age_relax' => 'Age Relax',
							'fu_es_qualification' => 'Essential Qualification',
							'fu_ds_qualification' => 'Desirable Qualification',
							'fu_has_es_service' => 'Essential Experience',
							'fu_has_ds_service' => 'Desirable Experience'
						); ?>
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
					  <select class="form-control selectpicker" name="advno" id="advno" autocomplete="off" onchange="check_slaveuser();">
							<option value="">---Select---</option>
							<?php foreach($rec_list as $advitems){ ?>
								<option value="<?php echo $advitems->adv_auto_genno; ?>" <?php if(!empty($searchlist['advno'])){if($searchlist['advno'] == $advitems->adv_auto_genno){echo 'selected="selected"';}} ?>><?php echo $advitems->adv_no.' ('.$advitems->rm_name.')'; ?></option>
							<?php } ?>
					  </select>
				      <small class="text-error advno"><?php echo form_error('advno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Discipline Type</label>
				    	<select class="form-control selectpicker" name="adv_post_type" id="adv_post_type" autocomplete="off">
							<option value="ALL">ALL</option>
					  	</select>
				      	<small class="text-error adv_post_type"><?php echo form_error('adv_post_type'); ?></small>
				    </div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
					<label>Checker</label>
				    	<select class="form-control selectpicker" name="subuser_type" id="subuser_type" autocomplete="off">
							<option value="All">All</option>
					  	</select>
				      	<small class="text-error subuser_type"><?php echo form_error('subuser_type'); ?></small>
				    </div>
				</div>
				<div class="col-sm-offset-1 col-sm-7">
				  <div class="form-group">
					<label>Access Type</label>
					<div>
						<?php foreach($uaccess as $accitems){ ?>
							<label class="radio-inline"><input type="radio" name="u_accs" value="<?php echo $accitems; ?>" <?php if(!empty($searchlist['u_accs'])){ if($searchlist['u_accs'] == $accitems){echo 'checked';}} ?> onchange="check_advaction_type();"><?php echo $str_arr[$accitems]; ?></label>
						<?php } ?>
					</div>
				      	<small class="text-error u_accs"><?php echo form_error('u_accs'); ?></small>
				  </div>
				</div>
				<div class="col-sm-3 subtype_sets" style="display:none;">
					<div class="form-group">
					<label>Sub Type</label>
				    	<select class="form-control selectpicker" name="sub_type" id="sub_type" autocomplete="off">
							<option value="">---Select---</option>
					  	</select>
				      	<small class="text-error sub_type"><?php echo form_error('sub_type'); ?></small>
				    </div>
				</div>
				<div class="col-sm-12 text-center" style="margin-top:25px;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="col-sm-12">
       				 <div class="form-group">	
					    <div align="center">
								<div class="get_error_total1" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="get_success_total1" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
								<div class="div_roller_total1" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						  </div>
				    </div>
                </div>
				
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
					<?php if(!empty($appli_list)){ ?>
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<!--<td>Recruitment For</td>
	                  		<td>Advertisement No.</td>-->
	                  		<td>Application No.</td>
	                  		<td>Applicant Name</td>
	                  		<!--<td>Applicant Mobile</td>-->
	                  		<td>Applicant Email</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($appli_list as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo ($keys + 1); ?></td>
                  			<!--<td><?php //echo $users->rm_name; ?></td>
                  			<td><?php //echo $users->adv_no; ?></td>-->
                  			<td><?php echo $users->f_application_no; ?></td>
                  			<td><?php echo $users->f_full_name; ?></td>
                  			<!--<td><?php //echo $users->f_mobile; ?></td>-->
                  			<td><?php echo $users->f_email; ?></td>
                  			<!--<td><?php //echo date('d-m-Y h:i A',strtotime($users->modify_date)); ?></td>-->
                  			<td>
                  				<a target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_approve_application_details/'.$users->f_application_no; ?>" title="View Details"><i class="fa fa-eye text-warning"></i></a>
                  				<?php //if($users->f_status == 1){ ?>	
                  				<!--<a href="#<?php //echo base_url().'admincontrol/front_user/lock_fuser/'.$users->f_uid; ?>" title="Lock User"><i class="fa fa-eye text-warning"></i></a>
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
      $(function () {
        $("#datatable_tab").dataTable();
      });

	function check_advaction_type(){
		var advno = $("#advno option:selected").val();
		var u_accs = $("input[name='u_accs']:checked").val();
		if(advno != "" & (u_accs != undefined && u_accs != "")){
			if(u_accs == "fu_age_relax" || u_accs == "fu_es_qualification" || u_accs == "fu_ds_qualification" || u_accs == "fu_has_es_service" || u_accs == "fu_has_ds_service"){
				var form_data = new FormData();
				form_data.append("advno", advno);
				form_data.append("u_accs", u_accs);
				$.ajax({
					type: "POST",
					url: "<?php echo site_url('admincontrol/candidates/goto_get_allthe_data_specific') ?>",
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
							$('#sub_type').html(data.op_set);
							$('.subtype_sets').show('200');
							
						}else{
							//$('.div_roller_total').fadeOut();
							$('#sub_type').html('<option value="">---Select---</option>');
							$('.subtype_sets').hide('200');
							error_message = data.e_msg;
							$('.get_error_total').html(error_message);
							$(".get_error_total").fadeIn();
							setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
						}
						
					}
				});
			}else{
				$('#sub_type').html('<option value="">---Select---</option>');
				$('.subtype_sets').hide('200');
			}
		}else{
			$('#sub_type').html('<option value="">---Select---</option>');
			$('.subtype_sets').hide('200');
		}
	}

	function check_slaveuser(){
		var advno = $("#advno option:selected").val();
		if(advno != ""){
			var form_data = new FormData();
			form_data.append("advno", advno);
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('admincontrol/candidates/goto_get_allslaveuser_specific') ?>",
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
						$('#subuser_type').html(data.op_set);
						
					}else{
						//$('.div_roller_total').fadeOut();
						$('#subuser_type').html('<option value="All">All</option>');
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}else{
			$('#subuser_type').html('<option value="All">All</option>');
		}
		check_advaction_type();
	}
	  
	$('#advno').on('change', function() {
		var advno = $("#advno option:selected").val();
		if(advno != ""){
			var form_data = new FormData();
			form_data.append("advno", advno);
			form_data.append("rf_set", 1);
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
						$('#adv_post_type').html('<option value="ALL">ALL</option>'+data.category_set);
						
					}else{
						//$('.div_roller_total').fadeOut();
						$('#adv_post_type').html('<option value="ALL">ALL</option>');
						error_message = data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
					}
					
				}
			});
		}else{
			$('#adv_post_type').html('<option value="ALL">ALL</option>');
		}
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
			$('.div_roller_total1').fadeIn();
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
			var advno = $("#advno option:selected").val();
			var u_accs = $("input[name='u_accs']:checked").val();
			var sub_type = $("#sub_type option:selected").val();
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
			}*/
			
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



			if(u_accs == undefined || u_accs == ""){
				e_error = 1;
				$('.u_accs').html('Access Type is Required.');
			}else{
				if(!u_accs.match(alphanumerics_spaces)){
					e_error = 1;
					$('.u_accs').html('Access Type only use AlphaNumeric Values with [_], Check again.');
				}else{
					$('.u_accs').html('');
				}	
			}
			
			if(advno != "" & (u_accs != undefined && u_accs != "")){
				if(u_accs == "fu_age_relax" || u_accs == "fu_es_qualification" || u_accs == "fu_ds_qualification" || u_accs == "fu_has_es_service" || u_accs == "fu_has_ds_service"){
					if(sub_type == ""){
						e_error = 1;
						$('.sub_type').html('Sub Type is Required.');
					}else{
						if(!sub_type.match(onlynumerics)){
							e_error = 1;
							$('.sub_type').html('Sub Type only use Numeric Values, Check again.');
						}else{
							$('.sub_type').html('');
						}	
					}
				}else{
					$('.sub_type').html('');
				}
			}else{
				$('.sub_type').html('');
			}
			
			//alert(salts);
			if(e_error == 1){
				$('.div_roller_total1').fadeOut();
				$('.get_error_total1').html(error_message);
				$(".get_error_total1").fadeIn();
				$(".text-error").fadeIn();
				/*e_error = 0;
				error_message = '';*/
				setTimeout(function(){ $('.text-error, .get_error_total1').fadeOut(); }, delay);
			}else{
				//alert(task_start_time);exit;
				//alert(rehash);
				$("#form123").submit();
			}
		}
		
    </script>