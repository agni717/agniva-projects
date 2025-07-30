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
				<h1 class="panel-title">Check Your Inter District Movement Application</h1>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
		<?php if(empty($doc_detail)){ ?>
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."idm/idm_application_status"; ?>" method="POST">
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
						<?php if($doc_detail->idm_status == 1){ ?>
							<span style="color:blue;">Submitted</span>
						<?php }elseif($doc_detail->idm_status == 2){ ?>
							<span style="color:#b28b0c;">Processed</span>
						<?php }elseif($doc_detail->idm_status == 3){ ?>
							<span style="color:green;">Approved</span>
						<?php }elseif($doc_detail->idm_status == 4){ ?>
							<span style="color:red;">Rejected</span>
						<?php } ?>
						</h2>
						<?php if($doc_detail->idm_status == 4){ ?>
						<h4>Reason - <span style="color:red;"><?php echo  $doc_detail->idm_admin_msg; ?></span></h4>
						<?php } ?>
					</div>
					<div class="text-right">
					<?php if($doc_detail->idm_status == 3){ ?>
					<a href="<?php echo base_url()."idm/print_final_idm_permission_sheet/".$doc_detail->idm_ucode; ?>" class="btn btn-success" target="_blank">Approval Print</a>
					<?php } ?>
					</div>
                  <table class="table table-bordered" id="datatable_tab" width="100%">
	                <tbody>
						<tr>
							<td width="25%"><strong>Application Number</strong></td>
							<td><strong><?php echo $doc_detail->idm_ucode; ?></strong></td>
							<td><strong>Application Date</strong></td>
							<td><?php echo date('d/m/Y',strtotime($doc_detail->idm_createdate)); ?></td>
						</tr>
						<tr>
							<td><strong>Applicant Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_name; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant Email</strong></td>
							<td width="30%"><?php echo $doc_detail->idm_email; ?></td>
							<td width="25%"><strong>Applicant Mobile</strong></td>
							<td><?php echo $doc_detail->idm_mobile; ?></td>
						</tr>
						<tr>
							<td colspan="4"><strong style="color:blue;">Present Address :-</strong></td>
						</tr>
						<tr>
							<td><strong>Village/Street Name</strong></td>
							<td><?php echo $doc_detail->idm_s_villege; ?></td>
							<td><strong>GP Name/Word No.</strong></td>
							<td><?php echo $doc_detail->idm_s_gp; ?></td>
						</tr>
						<tr>
							<td><strong>Block/Municipality</strong></td>
							<td><?php echo $doc_detail->idm_s_block; ?></td>
							<td><strong>District</strong></td>
							<td><?php echo $doc_detail->s_dist_name; ?></td>
						</tr>
						<tr>
							<td colspan="4"><strong style="color:blue;">Permanent Address (Destination) :-</strong></td>
						</tr>
						<tr>
							<td><strong>Village/Street Name</strong></td>
							<td><?php echo $doc_detail->idm_d_villege; ?></td>
							<td><strong>GP Name/Word No.</strong></td>
							<td><?php echo $doc_detail->idm_d_gp; ?></td>
						</tr>
						<tr>
							<td><strong>Block/Municipality</strong></td>
							<td><?php echo $doc_detail->idm_d_block; ?></td>
							<td><strong>District</strong></td>
							<td><?php echo $doc_detail->d_dist_name; ?></td>
						</tr>
						<tr>
							<td><strong>No. of people moving</strong></td>
							<td><?php echo $doc_detail->idm_people; ?></td>
							<td><strong>Date of Travel</strong></td>
							<td><?php echo date('d/m/Y',strtotime($doc_detail->idm_traveldate)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><strong>Identity proof of the applicant and others( ID card issued by Govt./Voter ID/AADHAR/Passport/Driving License etc)<br/>** This identity card is to be carried during the journey</strong></td>
							<td colspan="2"><a target="_blank" title="File" href="<?php echo base_url().'upload_file/idcard/'.$doc_detail->idm_identity_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<tr>
							<td><strong>Identity card no. of the Applicant</strong></td>
							<td><?php echo $doc_detail->idm_id_cardno; ?></td>
							<td><strong>Identity card Type of the Applicant</strong></td>
							<td><?php echo $doc_detail->idm_id_cardtype; ?></td>
						</tr>
						<tr>
							<td><strong>Vehicle No.</strong></td>
							<td><?php echo $doc_detail->idm_vehicle_no; ?></td>
							<td><strong>Vehicle Type</strong></td>
							<td><?php echo $doc_detail->idm_vehicle_type; ?></td>
						</tr>
						<tr>
							<td><strong>Reason for movement</strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_reason; ?></td>
						</tr>
						
						<tr>
							<td colspan="2"><strong>Medical/Emergency supporting documents</strong></td>
							<td colspan="2"><a target="_blank" title="File" href="<?php echo base_url().'upload_file/medical/'.$doc_detail->idm_medical_doc; ?>"><img src="<?php echo base_url().'images/file-doc.png'; ?>" /></a></td>
						</tr>
						<tr>
							<td><strong>Declaration </strong></td>
							<td colspan="3"><?php echo $doc_detail->idm_declaration; ?></td>
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