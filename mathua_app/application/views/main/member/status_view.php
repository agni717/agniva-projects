<?php $this->load->view('main/component/login_header') ?>
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style> 
        <!-- Presentation -->
        <div class="presentation-container">
        	<div class="container">
	            		
	            <div class="row">
					
					
				<div class="col-sm-12">
					<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title text-center"><u>Candidate Status</u></h1>
				<?php if($this->session->flashdata('success')) { ?>
    			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    		    <?php $this->session->unset_userdata('success'); }
    		    	elseif($this->session->flashdata('e_error')) { ?>                
    	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
    		    <?php $this->session->unset_userdata('e_error'); } ?>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
					<div class="panel-body"><?php //print_r($fuser_detailset); 
					//$usertype = $this->session->userdata('member_utype'); ?>
						<div class="row">
							<div class="col-sm-12 text-center">
								<?php if($detail_result->cr_approval == "Approved"){ ?>
									<p style="color:green;font-size:30px;">Your Application is Successfully Approved.</p>
									<?php if(count((array)$detail_interview) > 0){ ?>
										<p>Your Call Letter is generated from the HRB. please click the button below -</p>
										<a href="<?php echo base_url()."member/print_callletter_for_candidateinterview"; ?>" class="btn btn-warning" target="_blank">Print Call Letter</a>
									<?php }else{ ?>
										<p>Please wait for further process.</p>
									<?php } ?>
								<?php }elseif($detail_result->cr_approval == "Rejected"){ ?>
									<p style="color:red;font-size:30px;">Your Application is Rejected.</p>
									<p style="">Reason of Rejection : <?php echo $detail_result->cr_reject_comments; ?></p>
								<?php }else{ ?>
									<?php if($detail_cand_status == TRUE){ ?>
										<p style="font-size:30px;">Your Application has been submitted successfully.<br/>
										Please wait for Further Processing</p>
									<?php }elseif($detail_cand_status == FALSE){ ?>
										<!--<p style="font-size:30px;color:red;">Your Application has not been submitted.</p>-->
									<?php } ?>
								<?php } ?>	
							</div>
							<div class="col-sm-12">
							<?php if($detail_result->cr_approval == "Rejected"){ ?>
								<strong style="font-size:20px;">Detailed Reasons :-</strong><br/>
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
									'fu_ews' => 'EWS',
									'fu_age_relax' => 'Age Relax',
									'fu_es_qualification' => 'Essential Qualification',
									'fu_ds_qualification' => 'Desirable Qualification',
									'fu_has_es_service' => 'Essential Experience',
									'fu_has_ds_service' => 'Desirable Experience'
								); ?>
								<?php if(!empty($rejection_list)){
									foreach($rejection_list as $reject_items){
										if($reject_items->chk_type == "fu_age_relax"){
											foreach($extraage_list as $extage_items){
												if($reject_items->chk_sub_typeid == $extage_items->fu_ext_ageid){
													echo "<p><strong>".$str_arr[$reject_items->chk_type]." || ".$extage_items->caste_name."</strong> - Rejected by the HRB Administrator<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
													break;
												}
											}
										}elseif($reject_items->chk_type == "fu_es_qualification" || $reject_items->chk_type == "fu_ds_qualification"){
											foreach($allquali_list as $quali_items){
												if($reject_items->chk_sub_typeid == $quali_items->aquali_exam){
													echo "<p><strong>".$str_arr[$reject_items->chk_type]." || ".$quali_items->qm_name."</strong> - Rejected by the HRB Administrator<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
													break;
												}
											}
										}elseif($reject_items->chk_type == "fu_has_es_service" || $reject_items->chk_type == "fu_has_ds_service"){
											foreach($allexp_list as $exp_items){
												if($reject_items->chk_sub_typeid == $exp_items->aexpr_name){
													echo "<p><strong>".$str_arr[$reject_items->chk_type]." || ".$exp_items->expset_name."</strong> - Rejected by the HRB Administrator<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
													break;
												}
											}
										}else{
											echo "<p><strong>".$str_arr[$reject_items->chk_type]."</strong> - Rejected by the HRB Administrator<br/>
											<strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
										}
									} 
								} ?>
							<?php } ?>
							</div>
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
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphanumerics_no = /^[A-Za-z0-9_!@#$%&:.,\-]+$/;
		
    	var c_pass = $('#c_pass').val();
    	var n_pass = $('#n_pass').val();
    	var re_pass = $('#re_pass').val();
		
		if(c_pass == ""){
			e_error = 1;
			$('.c_pass').html('Current Password is Required.');
		}else{
			if(!c_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.c_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.c_pass').html('');
			}	
		}
		if(n_pass == ""){
			e_error = 1;
			$('.n_pass').html('New Password is Required.');
		}else{
			if(!n_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.n_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.n_pass').html('');
			}	
		}
		if(re_pass == ""){
			e_error = 1;
			$('.re_pass').html('Re-Enter Password is Required.');
		}else{
			if(!re_pass.match(alphanumerics_no)){
				e_error = 1;
				$('.re_pass').html('Password not use special carecters [without _ ! @ # $ % & : . , -], Check again.');
			}else{
				$('.re_pass').html('');
			}	
		}

		if(n_pass != re_pass){
			e_error = 1;
			error_message = error_message + '<br/>New Password and Re-Password not Matched, Check Again.';
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
			//alert(newhash);
			//alert(rehash);
			$("#myForm").submit();
		}

  	}

</script>