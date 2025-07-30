<?php $this->load->view('main/component/header')?>
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style>        

        <!-- Presentation -->
<div class="presentation-container">
  	<div class="container">
    	<div class="row">
	        <div class="col-sm-12 text-center">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title">Check Your Application</h1>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
		<?php if(empty($doc_detail)){ ?>
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."main/application_status"; ?>" method="POST">
            <div class="form-group">
              <label class="col-md-12">Application Number <font class="redclass">*</font></label>
              <div class="col-sm-offset-3 col-md-6">
                <input type="text" name="ap_no" id="ap_no" placeholder="Application Number" class="form-control" autocomplete="off">
				<small class="text-error text-left ap_no"><?php echo form_error('ap_no'); ?></small>
              </div>
            </div>
            <div class="form-group">
				<div  class="col-sm-12 text-center">
					<div align="center">
						<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
						<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
					</div>
				</div>
			</div>
            <div class="form-group">
              <div class="col-md-12 text-center">
			  <button type="button" onclick="gotoclclickbutton();" class="btn btn-lg btn-primary">Submit</button>
			  <a href="<?php echo base_url(); ?>" class="btn btn-lg btn-danger">cancel</a>
              </div>
            </div>
          </form>
		<?php }
		    if(!empty($doc_detail)){ ?>
		  		<div class="box-body table-responsive text-left">
				  	<div>
					  	<h2>Status: 
						<?php if($doc_detail->appli_status == 1){ ?>
							<span style="color:blue;">Submitted</span>
						<?php }elseif($doc_detail->appli_status == 2){ ?>
							<span style="color:#b28b0c;">Processed</span>
						<?php }elseif($doc_detail->appli_status == 3){ ?>
							<span style="color:green;">Approved</span>
						<?php }elseif($doc_detail->appli_status == 4){ ?>
							<span style="color:red;">Rejected</span>
						<?php } ?>
						</h2>
						<?php if($doc_detail->appli_status == 4){ ?>
						<h4>Reason - <span style="color:red;"><?php echo  $doc_detail->appli_admin_msg; ?></span></h4>
						<?php } ?>
					</div>
					<div class="text-right">
					<?php if($doc_detail->appli_status == 3){ ?>
					<a href="<?php echo base_url()."main/print_final_permission_sheet/".$doc_detail->app_ucode; ?>" class="btn btn-success" target="_blank">Approval Print</a>
					<?php } ?>
					</div>
                  <table class="table table-bordered" id="datatable_tab" width="100%">
	                <tbody>
						<tr>
							<td width="25%"><strong>Application Number</strong></td>
							<td><strong><?php echo $doc_detail->app_ucode; ?></strong></td>
							<td><strong>Application Date</strong></td>
							<td><?php echo date('d/m/Y',strtotime($doc_detail->appli_createdate)); ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_name; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Address</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_address; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Email</strong></td>
							<td><?php echo $doc_detail->appli_email; ?></td>
							<td><strong>Applicant/Agency Mobile</strong></td>
							<td><?php echo $doc_detail->appli_mobile; ?></td>
						</tr>
						<tr>
							<td><strong>Work Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_work; ?></td>
						</tr>
						<tr>
							<td><strong>Work Location</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_work_loc; ?></td>
						</tr>
						<tr>
							<td><strong>Sub Division</strong></td>
							<td><?php echo $doc_detail->sub_div_name; ?></td>
							<td><strong>Block</strong></td>
							<td><?php echo $doc_detail->block_name; ?></td>
						</tr>
						<tr>
							<td><strong>GP Name</strong></td>
							<td><?php echo $doc_detail->gp_name; ?></td>
							<td><strong>Police Station</strong></td>
							<td><?php echo $doc_detail->ps_name; ?></td>
						</tr>
						<tr>
							<td><strong>Number of Workers</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_worker; ?></td>
						</tr>
						<tr>
							<td><strong>Workers are local/ from outside</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_worker_loc; ?></td>
						</tr>
						<tr>
							<td><strong>Work Order Copy</strong></td>
							<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/workorder/'.$doc_detail->appli_workorder; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
							<td><strong>Details of Workers Copy</strong></td>
							<td><a target="_blank" title="File" href="<?php echo base_url().'upload_file/worker/'.$doc_detail->appli_worker_detail; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
                  	</tbody>
                  </table>
				    <div class="text-center">
						<a href="<?php echo base_url(); ?>" class="btn btn-warning">Back to Home</a>
					</div>
                </div><!-- /.box-body -->
			<?php } ?>
        </div>
		</div>
	            
	            
	            
	            
			</div>
		</div>
	</div>
</div>

        

<?php $this->load->view('main/component/footer'); ?>

<script type="text/javascript">
    $(function(){
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();
	});

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 6000;
		var e_error = 0;
		var error_message = '';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		
    	var ap_no = $('#ap_no').val();

		if(ap_no == ""){
			e_error = 1;
			$('.ap_no').html('Appliaction No. is Required.');
		}else{
			if(!ap_no.match(onlynumerics)){
				e_error = 1;
				$('.ap_no').html('Appliaction No. needs only Digit, Check again.');
			}else{
				$('.ap_no').html('');
			}	
		}
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			//alert(newhash);
			//alert(rehash);
			$("#myForm").submit();
		}

  	}

</script>