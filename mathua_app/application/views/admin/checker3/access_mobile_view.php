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
		  Witness - Mobile Verification
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Mobile Verification</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-sm-offset-4 col-sm-4">
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
				<div class="col-sm-12">
				  <div class="form-group">
					<!--<label>Mobile Number</label>-->
					  <input type="hidden" id="usetid" name="usetid" autocomplete="off">
					  <input type="hidden" class="form-control" name="c3_mobileno" id="c3_mobileno" value="<?php echo $u_details->u_invitey_mobile; ?>" required>
					  <small class="text-error c3_mobileno"><?php echo form_error('c3_mobileno'); ?></small>
				  </div>
				</div>
				<div class="col-sm-12 otpset" style="display:none;">
				  <div class="form-group">
					<label>OTP</label>
					  <input type="text" class="form-control" name="c3_otp" id="c3_otp" autocomplete="off" required>
				      <small class="text-error c3_otp"><?php echo form_error('c3_otp'); ?></small>
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
				<div class="col-sm-12 text-center">
                    <!--<input type="button" id="pa_target_submit" onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />-->
					<button class="btn btn-primary mobset" onclick="gotootpcheck();" type="button">Send OTP</button>
                    <button class="btn btn-primary logset" style="display:none;" type="submit">Verify</button>
                </div>
				
				
				<div class="clearfix"></div>
              </div>
			  <?php echo form_close(); ?>
			  </div>
                <div class="box-body">
					
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
	  
	function gotootpcheck(){
		//alert("hi");
		$(".div_roller_total").fadeIn();
		$('.mobset').prop('disabled', true);
		var mobile_no = $('#c3_mobileno').val();
		if(mobile_no != ""){
			if(mobile_no.length == 10){
				$.ajax({
					method:'POST',
					url:'<?php echo base_url()."admincontrol/checker_set/get_otp_set_for_cheker"; ?>',
					data:{mobile_no: mobile_no},
					dataType:'JSON',
					success:function(data){
						//alert(data.msg);
						if(data.msg == 1)
						{
							//console.log(data);
							$(".div_roller_total").fadeOut();
							//$('.get_success_total').html('OTP send to Your Registered Mobile No. - OTP - '+ data.adm_msg);
							$('.get_success_total').html('OTP send to Your Registered Mobile No.');
							$('#usetid').val(data.s_msg);
							$('#c3_mobileno').prop('readonly',true);
							$(".get_success_total").fadeIn();
							setTimeout(function(){ 
								//$('.get_success_total').fadeOut();
								$('.mobset').hide();
								$(".otpset, .logset").fadeIn();
							}, 2000);
							
						}else{
							$(".div_roller_total").fadeOut();
							$('.get_error_total').html(data.e_msg);
							$(".get_error_total").fadeIn();
							setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
							$('.mobset').prop('disabled', false);
						}
						
					}
				});
			}
			/*else{
				$(".div_roller_total").fadeOut();
				$('.get_error_total').html('Please Insert 10 Digit Mobile Number');
				$(".get_error_total").fadeIn();
				setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
				$('.mobset').prop('disabled', false);
			}*/
		}
		/*else{
			$(".div_roller_total").fadeOut();
			$('.get_error_total').html('Please insert Mobile Number');
			$(".get_error_total").fadeIn();
			setTimeout(function(){ $('.get_error_total').fadeOut(); }, 3000);
			$('.mobset').prop('disabled', false);
		}*/
	}

	
	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
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
		
    	var app_status = $('#app_status option:selected').val();
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
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_app_list')?>"); }, 3000);
						
					}else if(data.msg == 2){
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_error_total').html(data.e_msg);
						$(".get_error_total").fadeIn();
						$('select, textarea').val('');
						$('select, textarea').html('');
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, 4000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/candidates/candidate_app_list')?>"); }, 4000);
						
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
			
			var rf_set = $("#rf_set option:selected").val();
			var advno = $("#advno option:selected").val();
			var u_accs = $("input[name='u_accs']:checked").val();
			
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