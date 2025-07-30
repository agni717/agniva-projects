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
            Candidate's Document History
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Document History</li>
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
				<div class="col-sm-6">
				  
				</div>
				
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body"><?php if(!empty($appli_details)){
					//print_r($u_details);
					//print_r($appli_details); ?>
					<?php $urllink = base_url().'upload_file/'.$appli_details->f_applied_for.'/candidates/'.$appli_details->f_application_no.'/'; ?>
					
				  <div class="table-responsive">
                  <table class="table table-striped" id="datatable_tab123" style="border:1px solid #000" width="100%">
                  	<tbody>
						<tr>
							<td width="100%">
								<table width="100%">
									<tr>
										<td><strong>Recruitment For</strong></td>
										<td><?php echo $appli_details->rm_name; ?></td>
									</tr>
									<tr>
										<td><strong>Application No.</strong></td>
										<td><?php echo $appli_details->f_application_no; ?></td>
									</tr>
									<tr>
										<td><strong>Advertisement No.</strong></td>
										<td><?php echo $appli_details->adv_no; ?></td>
									</tr>
									<tr>
										<td><strong>Full Name</strong></td>
										<td><?php echo $appli_details->f_full_name; ?></td>
									</tr>
									<tr>
										<td colspan="2">	
											<h3><?php echo $titleset; ?></h3>
										</td>
									</tr>
									
									<?php if(!empty($all_documentlist)){ ?>
									<tr>
										<td colspan="2">
										<div class="table-responsive">
										<table class="table table-bordered table-striped text-center">
											<tr>
											<td><b>Documents List</b></td>
											</tr>
											<?php $counters = 1; 
											foreach($all_documentlist as $key=>$qips){ 
											if($key == 0){ ?>
											<tr>
												<td><?php echo '<strong>'.$counters.'.</strong> <a href="'.$urllink.$qips->udm_old_docname.'" target="_blank">Document</a>';if(empty($urllink.$qips->udm_old_docname)){echo '(Document Missing)';}
												$counters++; ?></td>
											</tr>
											<tr>
												<td><?php echo '<strong>'.$counters.'.</strong> <a href="'.$urllink.$qips->udm_new_docname.'" target="_blank">Document</a>';$counters++; ?></td>
											</tr>
											<?php }else{ ?>
											<tr>
												<td><?php echo '<strong>'.$counters.'.</strong> <a href="'.$urllink.$qips->udm_new_docname.'" target="_blank">Document</a>';$counters++; ?></td>
											</tr>
											<?php }} ?>
										</table>
										</div>
										</td>
									</tr>
									<?php }else{ ?>
									<tr>
										<td colspan="2" align="center">	
											<h3>History Document Not Available</h3>
										</td>
									</tr>
									<?php } ?>
								</table>
							</td>
						</tr>
						
						
						<!--<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_father_name", $accessarray)){ ?>
							<td><strong>Father's Name</strong></td>
							<td><?php //echo $appli_details->fu_father_name; ?></td>
							<?php //} ?>
						</tr>
						<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_mother_name", $accessarray)){ ?>
							<td><strong>Mother's Name</strong></td>
							<td><?php //echo $appli_details->fu_mother_name; ?></td>
							<?php //} ?>
						</tr>-->
						
						
						
						<!--<tr>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_gender", $accessarray)){ ?>
							<td><strong>Gender</strong></td>
							<td><?php //echo $appli_details->fu_gender; ?></td>
							<?php //} ?>
							<?php //if($accessarray[0] == "ALL" || in_array("fu_marital_status", $accessarray)){ ?>
							<td><strong>Marital Status</strong></td>
							<td><?php //echo $appli_details->fu_marital_status; ?></td>
							<?php //} ?>
						</tr>-->
						
						
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


<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">

<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">Update Marks</h4>
  </div>
  <div class="modal-body">
		<div class="container-fluid">
			<div class="row">
				<div class="form-group">
				  	<div class="col-sm-4">
					  <label class="text-right">Full Marks <font style="color: red;">*</font></label>
					  <input type="hidden" name="app_no" id="app_no" value="<?php echo $appli_details->f_application_no; ?>" autocomplete="off" />
					  <input type="hidden" name="qid" id="qid" value="" autocomplete="off" />
					  <input type="hidden" name="qtype" id="qtype" value="" autocomplete="off" />
					  <input type="text" name="q_fullmark" id="q_fullmark" value="" autocomplete="off" onkeyup="percentcheck_exm();" />
					  <small class="text-error q_fullmark"><?php echo form_error('q_fullmark'); ?></small>
				    </div>
					<div class="col-sm-4">
					  <label class="text-right">Obtained Marks <font style="color: red;">*</font></label>
					  <input type="text" name="q_obtainmark" id="q_obtainmark" value="" autocomplete="off" onkeyup="percentcheck_exm();" />
					  <small class="text-error q_obtainmark"><?php echo form_error('q_obtainmark'); ?></small>
				    </div>
					<div class="col-sm-4">
					  <label class="text-right">Percent Marks <font style="color: red;">*</font></label>
					  <input type="text" name="q_percentmark" id="q_percentmark" value="" autocomplete="off" readonly />
					  <small class="text-error q_percentmark"><?php echo form_error('q_percentmark'); ?></small>
				    </div>
				</div>
				<div style="clear:both;">&nbsp;</div>
				<div  class="col-sm-12 text-center">
					<div align="center">
						<div class="get_error_total_2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total_2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total_2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
		</div>
  </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="gotoUpdate_checkerMarks();">Update</button>
  </div>
</div>

</div>
</div>

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'js/zoom.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
      $(function () {
        $("#datatable_tab").dataTable();
      });
	
	function gotoclclickbutton(app_status){
		$('.div_roller_total').fadeIn();
		//alert(app_status);
		//exit;
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9'"_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	//var app_status = $('#app_status option:selected').val();
    	var app_no = '<?php if(!empty($appli_details->f_application_no)){echo $appli_details->f_application_no;} ?>';
    	//var app_no = $('#app_no').val();
    	var access_no = '<?php if(!empty($accessarray[0])){echo $accessarray[0];} ?>';
    	//var access_no = $('#access_no').val();
    	var app_comment = $('#app_comment').val();
		
		
		
		//alert(minuteDiff);
		
		if(app_no == "" || access_no == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page ID not found.';
		}
		
		if(app_status == ""){
			e_error = 1;
			$('.app_status').html('Action is Required.');
		}else{
			if(!app_status.match(alphaletters)){
				e_error = 1;
				$('.app_status').html('Action only use Alphabet Values, Check again.');
			}else{
				$('.app_status').html('');
			}
			if(app_status != "Approved"){
				if(app_status != "Skip"){
					if(app_comment == ""){
						e_error = 1;
						$('.app_comment').html('Comments is Required.');
					}else{
						comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
						if(!comment1.match(alphanumerics_no)){
							e_error = 1;
							$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
						}else{
							$('.app_comment').html('');
						}	
					}
				}
			}else{
				$('.app_comment').html('');
			}			
		}
		
		/*if(app_comment == ""){
			e_error = 1;
			$('.app_comment').html('Comments is Required.');
		}else{
			comment1 = app_comment.replace(/(\r\n|\n|\r)/gm, " ");
			if(!comment1.match(alphanumerics_no)){
				e_error = 1;
				$('.app_comment').html('Comments not use special carecters [without _ / : ( @ " . & ) , -], Check again.');
			}else{
				$('.app_comment').html('');
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
			//$("#myForm").submit();
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/checking_section_update"; ?>',
				data:{app_no: app_no, access_no: access_no, app_status: app_status, app_comment: app_comment},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Checking Status is updated Successfully.');
						$(".get_success_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['u_accs'])?>"); }, 3000);
						
					}else if(data.msg == 2){
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 4000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_nextforwad_list/'.$searchlist['advno'].'/'.$searchlist['u_accs'])?>"); }, 4000);
						
					}else{
						$('.div_roller_total').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});
		}

  	}
	  
	
	function gotomark_update_by_checker(chkid, full, obtained, percent, tabletype){
		//alert(chkid);
		//alert(tabletype);
		$('#qid').val(chkid);
		$('#qtype').val(tabletype);
		$('#q_fullmark').val(full);
		$('#q_obtainmark').val(obtained);
		$('#q_percentmark').val(percent);
		$('#myModal').modal('show');
		//$('#myModal').modal('hide');
		
	}

	function percentcheck_exm(){
		var marks_obtained = $("#q_obtainmark").val();
		var marks_full = $("#q_fullmark").val();
		var marks_percent = $("#q_percentmark").val();
		
		if(marks_obtained != "" && marks_full != ""){
			if(!isNaN(marks_obtained) && !isNaN(marks_full)){
				if(parseInt(marks_full) >= parseInt(marks_obtained)){
					var updatemarks_percent = parseFloat((parseInt(marks_obtained) * 100)/ parseInt(marks_full)).toFixed(2);
					$("#q_percentmark").val(updatemarks_percent);
				}else{
					$("#q_percentmark").val('');
				}
			}else{
				$("#q_percentmark").val('');
			}
		}else{
			$("#q_percentmark").val('');
		}
	}

	function gotoUpdate_checkerMarks(){
		$('.div_roller_total_2').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9'"_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

		var app_no = $('#app_no').val();
		var qid = $('#qid').val();
		var qtype = $('#qtype').val();
		var q_fullmark = $('#q_fullmark').val();
		var q_obtainmark = $('#q_obtainmark').val();
		var q_percentmark = $('#q_percentmark').val();

		if(app_no == "" || qid == "" || qtype == ""){
			e_error = 1;
			error_message = error_message + '<br/>Referesh the Page, ID not found.';
		}

		if(q_fullmark == ""){
			e_error = 1;
			$('.q_fullmark').html('Full Marks is Required.');
		}else{
			if(!q_fullmark.match(onlynumerics)){
				e_error = 1;
				$('.q_fullmark').html('Full Marks only use Numeric Values, Check again.');
			}else{
				$('.q_fullmark').html('');
			}	
		}

		if(q_obtainmark == ""){
			e_error = 1;
			$('.q_obtainmark').html('Full Marks is Required.');
		}else{
			if(!q_obtainmark.match(onlynumerics)){
				e_error = 1;
				$('.q_obtainmark').html('Full Marks only use Numeric Values, Check again.');
			}else{
				$('.q_obtainmark').html('');
			}	
		}

		if(q_percentmark == ""){
			e_error = 1;
			$('.q_percentmark').html('Percent Marks is Required.');
		} else {
			$('.q_percentmark').html('');
		}

		if(e_error == 1){
			$('.div_roller_total_2').fadeOut();
			$('.get_error_total_2').html(error_message);
			$(".get_error_total_2").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total_2').fadeOut(); }, delay);
		}else{
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/candidates/update_checker_examdata"; ?>',
				data:{app_no: app_no, qid: qid, qtype: qtype, q_fullmark: q_fullmark, q_obtainmark: q_obtainmark, q_percentmark: q_percentmark},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total_2').fadeOut();
						$('.get_success_total_2').html('Marks is updated Successfully.');
						$(".get_success_total_2").fadeIn();
						$('input').val('');
						setTimeout(function(){ $('.get_success_total_2').fadeOut(); }, 2000);
						setTimeout(function(){ location.reload(); }, 1000);
						
					}else{
						$('.div_roller_total_2').fadeOut();
						error_message = "There have some Problem to Update in DB, Try Again.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total_2').html(error_message);
						$(".get_error_total_2").fadeIn();
						setTimeout(function(){ $('.get_error_total_2').fadeOut(); }, delay);
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