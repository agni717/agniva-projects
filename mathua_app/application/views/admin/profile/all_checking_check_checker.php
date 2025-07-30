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
            Candidate's Doc Check Pending
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Doc Check Pending</li>
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
						<div class="row text-center" style="font-size:20px;">
							<form action="<?php echo base_url('admincontrol/dashboard/checker_remaining_pdfprint'); ?>" target="_blank" method="post" id="form_1">
								<input type="hidden" name="div_data" id="div_data" />
								<input type="hidden" name="advno_data" id="advno_data" value="<?php echo $searchlist['advno']; ?>" />
								<input type="button" class="btn btn-lg btn-primary" value="PDF" onclick="submit_data();" />
							</form><br/>
						</div>
				  <div class="table-responsive" id="psetsss">
                  <table class="" id="datatable_tab111" width="100%" cellpadding="3" border="1">
				  		<thead style="font-weight: bold;">
	                  		<td>Categoty</td>  
	                  		<td>Section</td>
							<td>C1 & C3</td>
							<td>C2</td>
					  	</thead>
                  		<tbody>
							<tr>
								<td><strong>Date of Birth</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_dob']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_dob']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Address</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_address']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_address']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Photo</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_photo_doc']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_photo_doc']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Signature</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_signature_doc']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_signature_doc']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Caste</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_caste']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_caste']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>PWD</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_pwd']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_pwd']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Exempted</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_exempted']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_exempted']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Ex-Service</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_exservice']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_exservice']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>EWS</strong></td>
								<td>NIL</td>
								<td><?php echo $appli_list['fu_ews']['C-13']; ?></td>
								<td><?php echo $appli_list['fu_ews']['C-2']; ?></td>
							</tr>
							<tr>
								<td><strong>Age Relax</strong></td>
								<td><?php if(count((array)$ext_age_set) > 0){ ?>
										<table width="100%" border="1">
											<thead style="font-weight: bold;">
												<?php foreach($ext_age_set as $keys=>$r_items){ ?>
													<tr><td><?php echo $r_items->caste_name; ?></td></tr>
												<?php } ?>
											</thead>
										</table>
									<?php }else{ echo "NIL";} ?>
								</td>
								<?php if(count((array)$ext_age_set) > 0){ ?>
								<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_age_relax']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_age_relax'][$iset]['C-13']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
									<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_age_relax']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_age_relax'][$iset]['C-2']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
								<?php }else{ ?>
									<td><?php echo $appli_list['fu_age_relax']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_age_relax']['C-2']; ?> </td>
								<?php } ?>
							</tr>
							<tr>
								<td><strong>Essential Qualification</strong></td>
								<td><?php if(count((array)$es_quali_set) > 0){ ?>
										<table width="100%" border="1">
											<thead style="font-weight: bold;">
												<?php foreach($es_quali_set as $keys=>$r_items){ ?>
													<tr><td><?php echo $r_items->qm_name; ?></td></tr>
												<?php } ?>
											</thead>
										</table>
									<?php }else{ echo "NIL";} ?>
								</td>
								<?php if(count((array)$es_quali_set) > 0){ ?>
								<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_es_qualification']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_es_qualification'][$iset]['C-13']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
									<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_es_qualification']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_es_qualification'][$iset]['C-2']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
								<?php }else{ ?>
									<td><?php echo $appli_list['fu_es_qualification']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_es_qualification']['C-2']; ?> </td>
								<?php } ?>
							</tr>
							<tr>
								<td><strong>Desirable Qualification</strong></td>
								<td><?php if(count((array)$ds_quali_set) > 0){ ?>
										<table width="100%" border="1">
											<thead style="font-weight: bold;">
												<?php foreach($ds_quali_set as $keys=>$r_items){ ?>
													<tr><td><?php echo $r_items->qm_name; ?></td></tr>
												<?php } ?>
											</thead>
										</table>
									<?php }else{ echo "NIL";} ?>
								</td>
								<?php if(count((array)$ds_quali_set) > 0){ ?>
								<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_ds_qualification']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_ds_qualification'][$iset]['C-13']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
									<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_ds_qualification']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_ds_qualification'][$iset]['C-2']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
								<?php }else{ ?>
									<td><?php echo $appli_list['fu_ds_qualification']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_ds_qualification']['C-2']; ?> </td>
								<?php } ?>
							</tr>
							<tr>
								<td><strong>Essential Experience</strong></td>
								<td><?php if(!empty($es_serv_set)){
									if(count((array)$es_serv_set) > 0){ ?>
										<table width="100%" border="1">
											<thead style="font-weight: bold;">
												<?php foreach($es_serv_set as $keys=>$r_items){ ?>
													<tr><td><?php echo $r_items->expset_name; ?></td></tr>
												<?php } ?>
											</thead>
										</table>
									<?php }else{ echo "NIL";} 
									}else{ echo "NIL";} ?>
								</td>
								<?php if(!empty($es_serv_set)){
								if(count((array)$es_serv_set) > 0){ ?>
								<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_has_es_service']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_has_es_service'][$iset]['C-13']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
									<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_has_es_service']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_has_es_service'][$iset]['C-2']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
								<?php }else{ ?>
									<td><?php echo $appli_list['fu_has_es_service']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_has_es_service']['C-2']; ?> </td>
								<?php }
								}else{ ?>
									<td><?php echo $appli_list['fu_has_es_service']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_has_es_service']['C-2']; ?> </td>
								<?php } ?>
							</tr>
							<tr>
								<td><strong>Desirable Experience</strong></td>
								<td><?php if(!empty($ds_serv_set)){
									if(count((array)$ds_serv_set) > 0){ ?>
										<table width="100%" border="1">
											<thead style="font-weight: bold;">
												<?php foreach($ds_serv_set as $keys=>$r_items){ ?>
													<tr><td><?php echo $r_items->expset_name; ?></td></tr>
												<?php } ?>
											</thead>
										</table>
									<?php }else{ echo "NIL";} 
									}else{ echo "NIL";} ?>
								</td>
								<?php if(!empty($ds_serv_set)){
								if(count((array)$ds_serv_set) > 0){ ?>
								<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_has_ds_service']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_has_ds_service'][$iset]['C-13']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
									<td><table width="100%" border="1">
										<tbody>
											<?php for($iset = 0; $iset<count($appli_list['fu_has_ds_service']); $iset++){ ?>
												<tr><td><?php echo $appli_list['fu_has_ds_service'][$iset]['C-2']; ?></td></tr>
											<?php } ?>
										</tbody>
									</table></td>
								<?php }else{ ?>
									<td><?php echo $appli_list['fu_has_ds_service']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_has_ds_service']['C-2']; ?> </td>
								<?php }
								}else{ ?>
									<td><?php echo $appli_list['fu_has_ds_service']['C-13']; ?> </td>
									<td><?php echo $appli_list['fu_has_ds_service']['C-2']; ?> </td>
								<?php } ?>
							</tr>
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
	  
	function submit_data(){
		var table_data = $('#psetsss').html();
		$('#div_data').val(table_data);
		//alert(table_data);
		$('#form_1').submit();
		
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