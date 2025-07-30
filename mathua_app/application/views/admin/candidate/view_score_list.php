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
		  Application No - <span style="color:blue"><?php echo $appli_details->f_application_no; ?></span>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Candidate's Score List</li>
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
					<div class="row">
						<div class="col-sm-12 text-center">
							<p style="font-size:30px;font-weight:bold;">Name :- <?php echo $appli_details->f_full_name; ?><br/>
							Mobile :- <?php echo $appli_details->f_mobile; ?> | Email :- <?php echo $appli_details->f_email; ?></p>	
							<div align="center"><a href="<?php echo base_url().'admincontrol/candidates/candidates_marks_printsets/'.$appli_details->f_application_no; ?>" target="_blank" class="btn btn-lg btn-primary">Print</a></div>
						</div>
					</div>
				<?php if (isset($error)) { ?>
					<div class="alert alert-error" style="color:red;">                
						<h4>Error!</h4>
						<?php echo $error; ?>
					</div>
					<?php } ?>
			  </div>
			  
                <div class="box-body">
				  <div class="table-responsive">
                  <table class="table table-striped" id="" width="100%">
					  	<thead style="font-weight: bold;">
	                  		<td>Academic Marks</td>
	                  		<td>Experience Marks</td>
							<td>Interview Marks 1</td>
							<td>Interview Marks 2</td>
	                  		<td>Total Marks</td>
	                  	</thead>
						<tbody>
							<td><?php echo $appli_result->cr_academic; ?></td>
							<td><?php echo $appli_result->cr_experience; ?></td>
							<td><?php echo $appli_result->cr_interview_1; ?></td>
							<td><?php echo $appli_result->cr_interview_2; ?></td>
							<td><?php $foo = ($appli_result->cr_academic + $appli_result->cr_experience + $appli_result->cr_interview_1 + $appli_result->cr_interview_2);echo number_format((float)$foo, 2, '.', ''); ?></td>
						</tbody>
					    
                  </table>
				  <hr style="border-color:#AAA;" />
				  <table class="table table-striped" id="" width="100%">
	                  <thead style="font-weight: bold;">
	                  		<td>Sl No.</td>
	                  		<td>Section</td>
							<td>Marks</td>
	                  </thead>
                  	<tbody>
                  		<?php $keys=1;
						foreach($appli_list as $users){ 
							if($users->chk_type == "fu_es_qualification" || $users->chk_type == "fu_ds_qualification" || $users->chk_type == "fu_has_es_service" || $users->chk_type == "fu_has_ds_service"){ ?>
                  		<tr>
                  			<td><?php echo $keys; ?></td>
                  			<td width="80%"><?php if($users->chk_type == "fu_es_qualification" || $users->chk_type == "fu_ds_qualification"){
									foreach($q_list as $qitems){
										if($users->chk_sub_typeid == $qitems->aquali_exam){
											echo $qitems->qm_name;
											break;
										}
									}
								}elseif($users->chk_type == "fu_has_es_service" || $users->chk_type == "fu_has_ds_service"){
									foreach($exp_list as $exitems){
										if($users->chk_sub_typeid == $exitems->aexpr_name){
											echo $exitems->expset_name;
											break;
										}
									}
								} 
								?></td>
							<td><?php echo $users->chk_got_marks; ?></td>
                  		</tr>	
                  		<?php $keys++;}
					} ?>
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