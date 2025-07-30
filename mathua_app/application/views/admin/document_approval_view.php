<?php $this->load->view('admin/component/header') ?>
<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>
<style>
.box-body textarea,input,select {max-width: 500px;}
</style>         
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
		  Application Number - <?php echo $doc_detail->app_ucode; ?>
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
            <section class="col-lg-12">
              <!-- Custom tabs (Charts with tabs)-->
			
			<?php if($this->session->flashdata('success')) { ?>
			<div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
		    <?php $this->session->unset_userdata('success'); }
		    	elseif($this->session->flashdata('e_error')) { ?>                
	        <div id="alert_msg" class="alert alert-danger"><?php echo $this->session->flashdata('e_error'); ?></div>
		    <?php $this->session->unset_userdata('e_error'); } ?>
			
              <!-- TO DO List -->
              <div class="box box-danger">
			  	<div class="box-header">
                  &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="row">
					<div class="col-sm-12">
					<?php echo form_open('','id="myForm" class="form-horizontal"'); ?>
                  
						<div class="form-group">
							<label class="col-sm-4 control-label text-right">Number of Workers</label>
							<div class="col-sm-8">
							<input class="form-control" type="text" name="w_number" id="w_number" placeholder="Total Worker Number" value="<?php echo $doc_detail->appli_worker; ?>" />
							<small class="text-error w_number"><?php echo form_error('w_number'); ?></small>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12" style="text-align: right">
                            <div class="checkbox">
							  <label><input name="checkall" id="checkall" type="checkbox" value="">Select All</label>
							</div>
                            </div>

                            <label class="col-sm-4 control-label text-right">Terms & Conditions List</label>
							<div class="col-sm-8">
							<?php foreach($fwd_list as $key=>$copys){ ?>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="copyfwd" value="<?php echo $copys->cf_id; ?>">
										<?php echo $copys->cf_title; ?>
									</label>
								</div>
							<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-center">
								<div align="center">
										<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
										<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
									<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<input type="button" onclick="final_generate_btn();" class="btn btn-primary" value="Submit" />
								&nbsp;<a href="<?= site_url('admincontrol/panel/application_list') ?>" class="btn btn-warning">Cancel</a>
							</div>
						</div>
						<?php form_close(); ?>						
					</div>
				</div>
				</div>

              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 

<?php $this->load->view('admin/component/footer') ?>

<script type="text/javascript">

$(function(){
      //$('#alert_msg, .text-error').delay(6000).fadeOut();
      $(".show_all_rent_checkbox").css("display", "none");
      
      $('#checkall').change(function() {
	        if ($(this).prop('checked')) {
	            $("input:checkbox").prop('checked',this.checked);
	        }
	        else {
	            $("input:checkbox").removeAttr('checked');
	        }
	    });
      
});

function final_generate_btn(){
	
	$('.div_roller_total').show();
	var delay = 6000;
	var e_error = 0;
	var error_message = 'There have some errors plese check above, Check again.';
	var onlynumerics = /^[0-9]+$/;
	var copy_gen = [];
	var gen_id = "<?php echo $doc_detail->app_id; ?>";
	var w_number = $('#w_number').val();
    $.each($("input[name='copyfwd']:checked"), function(){            
        copy_gen.push($(this).val());
    });
	/*for (var i = 0; i < copy_gen.length; i++) {
	    alert(copy_gen[i]);
	} 
	exit;*/	
	if(w_number == ""){
		e_error = 1;
		$('.w_number').html('Worker Number is Required.');
	}else{
		if(!w_number.match(onlynumerics)){
			e_error = 1;
			$('.w_number').html('Worker Number needs only Digit, Check again.');
		}else{
			$('.w_number').html('');
		}	
	}
	if(gen_id == ""){
		e_error = 1;
	}
	if(copy_gen.length == 0){
		e_error = 1;
		error_message = error_message + '<br/>No Terms & Conditions is Selected, please check again.';
	}
	
	if(e_error == 1)
	{
		$('.div_roller_total').hide();
		$(".get_error_total").html(error_message);
		$(".get_error_total").fadeIn();
		setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
	}else{
		$.ajax({
			method:'POST',
			url:'<?php echo base_url()."admincontrol/panel/application_form_approval"; ?>',
			data:{gen_id: gen_id, w_number: w_number, copy_set: copy_gen},
			dataType:'JSON',
			success:function(data){
				//alert(data.msg);
				if(data.msg == 1)
				{
					//console.log(data);
					//alert(data.msg);
					//$('.view_all_rent_file').html(data.msg);
					//$('.show_all_rent_checkbox').show(500);
					$(".get_success_total").html('Admin Approval is done successfully.');
					$(".get_success_total").fadeIn();
					$('.div_roller_total').hide();
					$("input:checkbox").removeAttr('checked');
					delay = 3000;
					setTimeout(function(){ $('.get_success_total').fadeOut(); }, delay);
					setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/panel/application_list')?>"); }, delay);
					
				}else{
					//$('.view_all_rent_file').html(data.msg);
					//$('.show_all_rent_checkbox').show(500);
					delay = 6000;
					$('.div_roller_total').hide();
					$(".get_error_total").html(data.e_msg);
					$(".get_error_total").fadeIn();
					setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
				}
				
			}
		});
	}
	
}

</script>