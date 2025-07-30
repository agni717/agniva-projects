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
            Candidate's Pagewise Application List
			<?php //echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Pagewise Application List</li>
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
				<form id="form123" action="<?php echo base_url('admincontrol/candidates/comp_pagewise_application_list'); ?>" method="GET">
				<div class="box-body">
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
				<?php //echo form_open_multipart('','class="" id="form123"'); ?>
				
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
			  
			  </div>
                <div class="box-body">
				<?php if(!empty($appli_list)){ ?>
				  <div class="table-responsive111">
				  	<div class="col-sm-12 text-right">
                    <input type="text" id="pa_search" name="pa_search" value="<?php if(!empty($searchlist['pasearch'])){echo $searchlist['pasearch'];}else{echo set_value('pa_search');} ?>" autocomplete="OFF"  />
                	</div>
                  <table class="table table-striped" id="datatable_tab123" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<!--<td>Recruitment For</td>
	                  		<td>Advertisement No.</td>-->
	                  		<td>Application No.</td>
	                  		<td>Applicant Name</td>
	                  		<td>Applicant Mobile</td>
	                  		<td>Applicant Email</td>
	                  		<td>Action</td>
	                  </thead>
                  	<tbody>
                  		<?php foreach($appli_list as $keys=>$users)
                  		{ ?>
                  		<tr>
                  			<td><?php echo ($keys + 1 + $pageno); ?></td>
                  			<!--<td><?php //echo $users->rm_name; ?></td>
                  			<td><?php //echo $users->adv_no; ?></td>-->
                  			<td><?php echo $users->f_application_no; ?></td>
                  			<td><?php echo $users->f_full_name; ?></td>
                  			<td><?php echo $users->f_mobile; ?></td>
                  			<td><?php echo $users->f_email; ?></td>
                  			<!--<td><?php //echo date('d-m-Y h:i A',strtotime($users->modify_date)); ?></td>-->
                  			<td>
                  				<a target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_application_details/'.$users->f_application_no; ?>" title="View User"><i class="fa fa-eye text-warning"></i></a>&nbsp;&nbsp;&nbsp;
								  
								  <a target="_blank" href="<?php echo base_url().'admincontrol/candidates/admin_accesswise_checkingset/'.$users->f_application_no; ?>" title="View Access Wise"><i class="fa fa-eye text-info"></i></a>&nbsp;&nbsp;&nbsp;

								  <a target="_blank" href="<?php echo base_url().'admincontrol/dashboard/candidates_checking_details/'.$users->f_application_no; ?>" title="View Checkings"><i class="fa fa-eye text-red"></i></a>&nbsp;&nbsp;&nbsp;
								  
								  <a target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_full_score/'.$users->f_application_no; ?>" title="View Mrks"><i class="fa fa-paste text-info"></i></a>&nbsp;&nbsp;&nbsp;
								  
								  <a class="btn-sm btn-warning" target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_name_modifcation/'.$users->f_application_no; ?>" title="Rename Candidate">Rename</a>&nbsp;&nbsp;&nbsp;

								  <a class="btn-sm btn-warning" target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_dateofbirth_modifcation/'.$users->f_application_no; ?>" title="Candidate DOB Modification">DOB Modily</a>&nbsp;&nbsp;&nbsp;
								  
								  <a class="btn-sm btn-warning" target="_blank" href="<?php echo base_url().'admincontrol/candidates/candidate_qualification_replacing/'.$users->f_application_no; ?>" title="Candidate Qualification Swapping">Swap</a>&nbsp;&nbsp;&nbsp;
								  
								  <a class="btn-sm btn-danger" target="_blank" href="<?php echo base_url().'admincontrol/dashboard/candidate_rejection_approval/'.$users->f_application_no; ?>" title="Reject Candidate">Reject</a>
								
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
				  <div align="right" id="pagination" style="margin-top: 15px;"><?php echo $pagination; ?></div>
				  </div>
				<?php } ?>
                </div><!-- /.box-body -->
				<?php echo form_close(); ?> 
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
        $("#datatable_tab").dataTable({
			/*"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource":{
					url :"<?php echo base_url().'admincontrol/candidate/comp_application_list_v2'; ?>",
					type: "POST",
					"data": {
						"adv_name": "<?php //echo "A301020210823566472"; ?>"
					}
				}*/
		});
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


