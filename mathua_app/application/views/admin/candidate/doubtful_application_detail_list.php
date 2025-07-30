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
            Application - <?php echo $appli_details->f_application_no; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Application - Doubtful List</li>
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
					<?php }
						$str_arr = array(
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
							'fu_age_relax' => 'Age Relaxation',
							'fu_qualification' => 'Qualification',
							'fu_has_service' => 'Service Experience'
						);	?>
				</div>
                <div class="box-body">
					<div>
						<table width="100%">
							<tr>
								<td width="25%"><strong>Recruitment For</strong></td>
								<td width="25%"><?php echo $appli_details->rm_name; ?></td>
								<td width="25%"><strong>Advertisement No.</strong></td>
								<td width="25%"><?php echo $appli_details->adv_no; ?></td>
							</tr>
							<tr>
								<td><strong>Full Name</strong></td>
								<td colspan="3"><?php echo $appli_details->f_full_name; ?></td>
							</tr>
							<tr>
						</table>
					</div>
					<hr/>
				  <div class="table-responsive">
                  <table class="table table-striped" id="" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Checking For</td>
	                  		<td>Checking Status</td>
	                  		<td>Checking Comments</td>
	                  		<td>Checking Date</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php if(!empty($approv_list)){
							foreach($approv_list as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo ($keys + 1); ?></td>
                  			<td><?php echo $str_arr[$users->chk_type]; ?></td>
                  			<td><?php echo $users->chk_approve; ?></td>
                  			<td><?php echo $users->chk_comments; ?></td>
                  			<td><?php echo date('d-m-Y h:i A',strtotime($users->chk_appro_date)); ?></td>
                  			<td>
                  				<?php if($users->chk2_approve == NULL){ ?>
								<a href="<?php echo base_url().'admincontrol/candidates/candidate_application_modify/'.$users->f_application_no.'/'.$users->chk_id.'/D'; ?>" title="Modify" class="btn btn-warning">Modify Approval</a>
								<?php }else{ ?>
								<?php echo 'Taken as '.$users->chk2_approve; ?>
                  				<?php } //if($users->f_status == 1){ ?>	
                  				<!--<a href="#<?php //echo base_url().'admincontrol/front_user/lock_fuser/'.$users->f_uid; ?>" title="Lock User"><i class="fa fa-eye text-warning"></i></a>
                  				<?php //} else { ?>
								<a href="#<?php //echo base_url().'admincontrol/front_user/unlock_fuser/'.$users->f_uid; ?>" title="Unock User"><i class="fa fa-lock text-warning"></i></a>
								<?php //} ?>
								<a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/front_user/delete_fuser/'.$users->f_uid; ?>" title="Delete User"><i class="fa fa-trash-o text-warning"></i></a>-->
                  				
                  			</td>
                  		</tr>	
                  		<?php }}else{ ?>
						<tr>
							<td colspan="6" style="color:blue;">No Data Available for Checking</td>
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
      $(function () {
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
					$('.advno').html('Advertisement No. only use Numeric Values, Check again.');
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