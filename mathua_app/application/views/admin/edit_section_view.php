<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script type="text/javascript">
	$(function(){
	      $('.alert-error, .text-error').delay(6000).fadeOut();
	  });
</script>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input,select {max-width: 500px;}
.box-body textarea { resize: vertical; }
.box-body input[type="file"] { padding-bottom: 40px; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Section
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Section</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <section class="col-lg-12">
              <!-- Custom tabs (Charts with tabs)-->
			
			<?php if (isset($error)) { ?>
            <div class="alert alert-error">                
                <h4>Error!</h4>
                <?php echo $error; ?>
            </div>
        	<?php } ?>
			
              <!-- TO DO List -->
              <div class="box box-primary">
                <div class="box-header">
                  &nbsp;
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal"'); ?>
                  
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Section Name<font style="color: red;">*</font></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" name="s_name" id="s_name" placeholder="Enter Section Name" value="<?php echo $section_detail->section_name; ?>" />
				      <small class="text-error s_name"><?php echo form_error('s_name'); ?></small>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <label class="col-sm-3 control-label text-right">Section Details</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" name="s_details" id="s_details" placeholder="Enter Section Details"><?php echo $section_detail->section_details; ?></textarea>
				      <small class="text-error s_details"><?php echo form_error('s_details'); ?></small>
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
				    <div class="col-sm-offset-3 col-sm-9">
				      <input type="button" onclick="get_sanction_submit();" class="btn btn-danger" name="submit" value="Submit" />
                      &nbsp;<a href="<?= site_url('admincontrol/panel/section_list') ?>" class="btn btn-warning">Cancel</a>
				    </div>
				  </div>
				  
               <?php form_close(); ?>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                &nbsp;
                </div>
              </div><!-- /.box -->

            </section>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 
      

<?php $this->load->view('admin/component/footer') ?>

<script type="text/javascript">
$(function(){
      $('#alert_msg, .text-error').delay(8000).fadeOut();
      /*$('#from_date, #to_date').datepicker({
	  		format: 'dd/mm/yyyy',
	  		autoclose: true
      })
      .change(dateChanged)
      .on('changeDate', dateChanged);*/
      
  });

function get_sanction_submit(){
	var delay = 8000;
	$('.div_roller_total').fadeIn();
	var e_error = 0;
	var san_id = '<?php echo $section_detail->section_id; ?>';
	var san_name = $("#s_name").val();
	var san_detail = $("#s_details").val();
	var form_data = new FormData();
	if(san_name != ""){
		form_data.append('san_id',san_id);
		form_data.append('san_name',san_name);
		form_data.append('san_detail',san_detail);
		$.ajax({
		method:'POST',
		url:'<?php echo base_url()."admincontrol/panel/edit_new_section"; ?>',
		data:form_data,
		dataType:'JSON',
		contentType: false,
		processData: false,
		success:function(data){
			//alert(data.msg);
			if(data.msg == 1)
			{
				$('.div_roller_total').fadeOut();
				//console.log(data);
				//alert(data.msg[0].space_rate);
				/*$("#sd_type").val(data.msg[0].sd_active);
				//$("#total_day").val(1);
				$("#net_amount").val(data.msg[0].space_rate);
				$("#total_amount").val(data.msg[0].space_rate);
				$("#sd_amount").val(data.msg[0].sd_amount);
				$('#other_subcat_info').val('');*/
				$('.get_success_total').html(data.e_msg);
				$(".get_success_total").fadeIn();
				$('#s_name, #s_details').val('');
				$('#s_name, #s_details').html('');
				setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
				setTimeout(function(){ window.location.replace("<?php echo site_url('admincontrol/panel/section_list')?>/"); }, 3000);
				
			}else{
				$('.div_roller_total').fadeOut();
				//error_message = data.e_msg;
				$('.get_error_total').html(data.e_msg);
				$(".get_error_total").fadeIn();
				setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
			}
			
		}
	});
	}else{
		$('.div_roller_total').fadeOut();
		$(".s_name").html('Enter the Sanction Name');
		$(".text-error").fadeIn();
		setTimeout(function(){ $('.text-error').fadeOut(); }, delay);
	}
}

</script>