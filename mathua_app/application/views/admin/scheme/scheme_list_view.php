<?php $this->load->view('admin/component/header') ?>

<?php //$this->load->view('admin/component/menu') ?>

<!-- <link href="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" /> -->


<div class="home pb-5">
		<div class="container-fluid">
			
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                     <h3 class="widget-title">Scheme List</h3>
					 
						<?php 
						if($this->session->flashdata('success')) 
						{ ?>
							<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
							<?php $this->session->unset_userdata('success'); 
						}
						elseif($this->session->flashdata('e_error')) 
						{ ?>                
							<div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
							<?php $this->session->unset_userdata('e_error'); 
						} ?>
			
							<div class="table-responsive mb-3">
								<table id="tableId" class="table table-bordered table-striped">
									<thead>
										<tr>												
											<th>Sl.No.</th>
											<th>Scheme Name</th>
											<th>Scheme Details</th>
											<!-- <th>Scheme Amount</th> -->
											<!-- <th>Number of Installment</th> -->
											<!-- <th>Reference Number</th> -->
											<th>Scheme Created Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach($scm_list as $keys=>$quaries)
										{ ?>
											<tr>
												<td><?php echo $keys+1; ?></td>
												<td><?php echo $quaries->scm_name; ?></td>
												<td><?php echo $quaries->scm_details; ?></td>
												<!-- <td><?php //echo $quaries->scm_amount; ?></td> -->
												<!-- <td><?php //echo $quaries->scm_installment_no; ?></td> -->
												<!-- <td><?php //echo $quaries->scm_ref_no; ?></td> -->
												<td><?php echo date('d-m-Y h:i A',strtotime($quaries->scm_createdate)); ?></td>
												<td><?php 
												if($quaries->scm_status == 1)
												{ ?>
													<span style="color:green;">Active</span>
													<?php 
												}
												else
												{ ?>
													<span style="color:red;">InActive</span>
													<?php 
												} ?>
												</td>
												<td width="100px">
													
													<!-- <a target="_blank" href="<?php //echo base_url().'admincontrol/scheme_set/generate_and_print_advertisement/'.$quaries->scm_id ; ?>" title="Print Record"><i class="fa fa-print text-warning"></i></a>&nbsp;
													<a href="<?php //echo base_url().'admincontrol/scheme_set/modify_advertisement/'.$quaries->scm_id ; ?>" title="Modify Record"><i class="fa fa-edit text-warning"></i></a>&nbsp;
													<a href="<?php //echo base_url().'admincontrol/scheme_set/advertisement_details/'.$quaries->scm_id ; ?>" title="View Record"><i class="fa fa-eye text-warning"></i></a>&nbsp; -->
													
													<a href="<?php echo base_url().'admincontrol/scheme_set/modify_scheme_details/'.$quaries->scm_id; ?>" title="Edit User"><span class="ti-pencil"></span></a>
													<?php 
													if($quaries->scm_status == 1)
													{ ?>	
														<a href="<?php echo base_url().'admincontrol/scheme_set/lock_scheme_set/'.$quaries->scm_id; ?>" title="Lock User"><span class="ti-unlock"></span></a>
														<?php 
													} 
													else 
													{ ?>
														<a href="<?php echo base_url().'admincontrol/scheme_set/unlock_scheme_set/'.$quaries->scm_id; ?>" title="Unock User"><span class="ti-lock"></span></a>
														<?php 
													} ?>

				
												</td>
											</tr>	
											<?php 
										} ?>
									</tbody>
                            	</table>	                                
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>


<?php $this->load->view('admin/component/footer') ?>

<!--<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php //echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>-->
	<script type="text/javascript">
		$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	      //$("#datatable_tab").dataTable();
		});
		
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



<!-- <tbody> -->
<?php 
// foreach($scm_list as $keys=>$quaries)
// { ?>
	<!-- <tr> -->
		<!-- <td><?php //echo $keys+1; ?></td> -->
		<!-- <td><?php //echo $quaries->adv_no; ?></td> -->
		<!--<td><?php //echo $quaries->rm_name; ?></td>-->
		<!-- <td><?php //echo date('d-m-Y h:i A',strtotime($quaries->adv_start_time)); ?></td> -->
		<!-- <td><?php //echo date('d-m-Y h:i A',strtotime($quaries->adv_end_time)); ?></td> -->
		<!-- <td><?php //echo $quaries->adv_total_recruit; ?></td> -->
		<!-- <td><a href="<?php //echo base_url().'upload_file/adv_doc/'.$quaries->adv_source_doc; ?>" target="_blank">Document</a></td> -->
		<!-- <td><?php //echo date('d-m-Y',strtotime($quaries->adv_createdate)); ?></td> -->
		<!-- <td> -->
			<?php 
		// if($quaries->adv_status == 1)
		// { ?>
			<!-- <span style="color:green;">Active</span> -->
			<?php 
		// }
		// else
		// { ?>
			<!-- <span style="color:red;">InActive</span> -->
			<?php 
		// } 
		?>/
		<?php 
		// if($quaries->adv_activated == 1)
		// { 
			?>
			<!-- <span style="color:green;">Public View Active</span> -->
			<?php 
		// }
		// else
		// {
			 ?>
			<!-- <span style="color:red;">Public View Block</span> -->
			<?php 
		// } ?>
		<!-- </td> -->
		<!-- <td width="100px"> -->
			<?php //if($this->session->userdata['utype'] <= 2){ ?>
			<!-- <a target="_blank" href="<?php //echo base_url().'admincontrol/advertisement_set/generate_and_print_advertisement/'.$quaries->adv_auto_genno; ?>" title="Print Record"><i class="fa fa-print text-warning"></i></a>&nbsp; -->
			<!-- <a href="<?php //echo base_url().'admincontrol/advertisement_set/modify_advertisement/'.$quaries->adv_auto_genno; ?>" title="Modify Record"><i class="fa fa-edit text-warning"></i></a>&nbsp; -->
			<!-- <a href="<?php //echo base_url().'admincontrol/advertisement_set/advertisement_details/'.$quaries->adv_auto_genno; ?>" title="View Record"><i class="fa fa-eye text-warning"></i></a>&nbsp; -->
			<?php //if($quaries->adv_status == 1){ ?>
				<!-- <a href="<?php //echo base_url().'admincontrol/advertisement_set/lock_advertisement/'.$quaries->adv_auto_genno; ?>" title="Lock Record"><i class="fa fa-unlock text-warning"></i></a>&nbsp; -->
			<?php //}else{ ?>
				<!-- <a href="<?php //echo base_url().'admincontrol/advertisement_set/unlock_advertisement/'.$quaries->adv_auto_genno; ?>" title="Unlock Record"><i class="fa fa-lock text-warning"></i></a>&nbsp; -->
			<?php //} ?>
			<!--<a onclick="return confirm('You are about to Reject a record. This cannot be undone. Are you sure?');" href="<?php //echo base_url().'admincontrol/advertisement_set/delete_the_event/'.$quaries->adv_auto_genno; ?>" title="Delete Record"><i class="fa fa-trash-o text-warning"></i></a>-->
			<?php //} ?>
				<!-- </td> -->
			<!-- </tr>	 -->
	<?php 
// } ?>
<!-- </tbody> -->