<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

<?php //$urllink = base_url().'upload_file/'.$fuser_detailset->f_applied_for.'/candidates/'.$fuser_detailset->f_application_no.'/'; ?>
        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Application No - <span style="color:blue"><?php echo $fuser_detailset->f_application_no; ?></span>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Application Details</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12"><?php $utype = $this->session->userdata['utype'];
			$accessarray = explode(",",$u_details->u_access_area);
			//print_r($accessarray);
			//print_r($appli_details); ?>
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
					<div class="row">
						<div class="col-sm-12 text-center">
							<p style="font-size:25px;font-weight:bold;">Name :- <?php echo $fuser_detailset->f_full_name; ?><br/>
							Mobile :- <?php echo $fuser_detailset->f_mobile; ?> | Email :- <?php echo $fuser_detailset->f_email; ?></p>	
							<p style="font-size:20px;font-weight:bold;">Recruitment For :- <?php echo $fuser_detailset->rm_name; ?><br/>
							Advertisement No. :- <?php echo $fuser_detailset->adv_no; ?></p>	
						</div>
						<div class="col-sm-12">
						<?php //print_r($fuser_detailset); ?>
						<?php echo form_open_multipart('','class="" id="form123"'); ?>
				<div class="row">
				<div class="col-sm-offset-1 col-sm-5">
				  <div class="form-group">
					<label>Candiate Name for Modifcation</label>
					  <input class="form-control" name="main_rename" id="main_rename" value="<?php echo $fuser_detailset->f_full_name; ?>" autocomplete="off" />
				      <small class="text-error main_rename"><?php echo form_error('main_rename'); ?></small>
				  </div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
					<label>Candiate Mobile for Modifcation</label>
					  <input class="form-control" name="main_mobile" id="main_mobile" value="<?php echo $fuser_detailset->f_mobile; ?>" autocomplete="off" />
				      <small class="text-error main_mobile"><?php echo form_error('main_mobile'); ?></small>
				  </div>
				</div>
				<div class="col-sm-offset-3 col-sm-6">
				  <div class="form-group">
					<label>Candiate Email for Modifcation</label>
					  <input class="form-control" name="main_email" id="main_email" value="<?php echo $fuser_detailset->f_email; ?>" autocomplete="off" />
				      <small class="text-error main_email"><?php echo form_error('main_email'); ?></small>
				  </div>
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
				<div class="col-sm-12 text-center" style="margin:5px 0;">
                    <input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />
                </div>
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
						</div>
					</div>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 



<div id="myModalView" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title">Query Number : <span class="q_number_set"></span></h4>
	  </div>
	  <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
				  <div class="col-sm-12" style="padding-bottom:5px;">
					<strong class="">Subject : <span class="q_subject_set"></span></strong>
				  </div>
				  <div class="col-md-7">
					<div class="alert-info" role="alert" style="padding:5px;">
						<div class="q_detail_set" style="margin-bottom:5px;"></div>
						<div class="text-bold mainAttachment">Attachment : <span class="q_attach_set"></span></div>
					</div>
				  </div>
				</div>
				<div>&nbsp;</div>
				<div class="row replytab">
				  <div class="col-md-7 col-md-offset-5">
					<div class="" style="padding:5px;">
						<strong class="">Administrator Reply:-</strong>
					</div>
					<div class="alert-warning" role="alert" style="padding:5px;">
						<div class="q_reply_set" style="margin-bottom:5px;"></div>
						<div class="text-bold haveAttachment">Attachment : <span class="q_reply_attach_set"></span></div>
					</div>
				  </div>
				</div>
			</div>
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
	  </div>
	</div>

</div>
</div>


<div id="myModalReply" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title">Query Number : <span class="q_number_set"></span></h4>
	  </div>
	  <div class="modal-body">
			<div class="container-fluid">
				<div class="row">
				  <div class="col-sm-12" style="padding-bottom:5px;">
					<strong class="">Subject : <span class="q_subject_set"></span></strong>
				  </div>
				  <div class="col-md-7">
					<div class="alert-info" role="alert" style="padding:5px;">
						<div class="q_detail_set" style="margin-bottom:5px;"></div>
						<div class="text-bold mainAttachment">Attachment : <span class="q_attach_set"></span></div>
					</div>
				  </div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<h3>Administrator Reply</h3>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label text-right">Reply in Details <span style="color:red">*</span></label>
						<div class="col-sm-9">
						  <input type="hidden" name="query_no" id="query_no" autocomplete="off" />
						  <textarea class="form-control" name="reply_comment" style="resize:none;" id="reply_comment" autocomplete="off"></textarea>
						  <small class="text-error reply_comment"><?php echo form_error('reply_comment'); ?></small>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
					<div class="form-group">
						<label class="col-md-3 text-right" style="margin-top: 7px;">Upload Attachment</label>
						<div class="col-md-6">
							<input type="file" class="form-control" name="files" id="files" autocomplete="off" />
							<small class="text-error files"><?php echo form_error('files'); ?></small>
						</div>
					</div>
					<div style="clear:both;">&nbsp;</div>
					<div  class="col-sm-12 text-center">
						<div align="center">
							<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
							<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
						</div>
					</div>
				</div>
			</div>
		
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="goto_clickbutton_administrator();">Submit</button>
	  </div>
	</div>

</div>
</div>
<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	      //$("#datatable_tab").dataTable();
		});
		
		function goto_submit_button(){
			$('.div_roller_total').fadeIn();
			$('#pa_target_submit').attr("disabled", true);
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
			var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
			
			var main_refid = '<?php echo $fuser_detailset->f_application_no ?>';
			var main_rename = $("#main_rename").val();
			var main_mobile = $("#main_mobile").val();
			var main_email = $("#main_email").val();
			
			if(main_refid == ""){
				e_error = 1;
				error_message = "Refresh the Page ID not found.";
			}
			if(main_rename == ""){
				e_error = 1;
				$('.main_rename').html('Full Name is Required.');
			}else{
				if(!main_rename.match(alphanumerics_no)){
					e_error = 1;
					$('.main_rename').html('Reason not use special charecters [without _ / : ( @ & . ) , -], Check again.');
				}else{
					$('.main_rename').html('');
				}	
			}
			if(main_mobile == ""){
				e_error = 1;
				$('.main_mobile').html('Mobile number is Required.');
			}else{
				if(!main_mobile.match(onlynumerics)){
					e_error = 1;
					$('.main_mobile').html('Mobile number is only Numeric Value, Check again.');
				}else{
					$('.main_mobile').html('');
				}	
			}

			if(main_email == ""){
				e_error = 1;
				$('.main_email').html('Email-ID is Required.');
			}else{
				$('.main_email').html('');	
			}

			//alert(salts);
			if(e_error == 1){
				$('.div_roller_total').fadeOut();
				$('#pa_target_submit').attr("disabled", false);
				$('.get_error_total').html(error_message);
				$(".get_error_total").fadeIn();
				$(".text-error").fadeIn();
				/*e_error = 0;
				error_message = '';*/
				setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
			}else{
				//alert(task_start_time);exit;
				//alert(rehash);
				var conf_answer = confirm("Are you sure you want to modify Candidate Name, Mobile OR Email..?")
				if (conf_answer){
					var form_data = new FormData();
					form_data.append('main_refid', main_refid);
					form_data.append('main_rename', main_rename);
					form_data.append('main_mobile', main_mobile);
					form_data.append('main_email', main_email);
					$.ajax({
						method: 'POST',
						url: '<?php echo base_url() . "admincontrol/candidates/cand_rename_set_submission"; ?>',
						data: form_data,
						dataType: 'JSON',
						contentType: false,
						processData: false,
						success: function(data) {
							//alert(data.msg);
							if (data.msg == 1) {
								//console.log(data);
								//alert(data.msg[0].space_rate);
								$('.div_roller_total').fadeOut();
								$('.get_success_total').html('Candidate Name, Mobile OR Email is Updated Successfully.');
								$(".get_success_total").fadeIn();
								$('input, select').val('');
								$('input').html('');
								setTimeout(function() {
									$('.get_success_total').fadeOut();
								}, 3000);
								setTimeout(function() {
									window.location.replace("<?php echo site_url('admincontrol/candidates/comp_application_list') ?>");
								}, 3000);


							} else {
								$('.div_roller_total').fadeOut();
								$('#pa_target_submit').attr("disabled", false);
								error_message = "There have some problem to Update Data, Try after some time.";
								error_message = error_message + "<br/>" + data.e_msg;
								$('.get_error_total').html(error_message);
								$(".get_error_total").fadeIn();
								setTimeout(function() {
									$('.get_error_total').fadeOut();
								}, delay);
							}

						}
					});
				}else{
					$('.div_roller_total').fadeOut();
					$('#pa_target_submit').attr("disabled", false);
				}
			}
		}
		
    </script>