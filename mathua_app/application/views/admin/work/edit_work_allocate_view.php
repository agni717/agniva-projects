<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input {max-width: 500px;}
.box-body textarea { resize: vertical; }
.ui-datepicker table{ border:1px solid #000; }
</style>        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Modify Allocate Work</li>
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
              <div class="box box-warning">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Modify Allocate Work</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart(base_url().'admincontrol/panel/edit_work_allocation/'.$work_detail->work_id,'class="form-horizontal" id="myForm"'); ?>
                 <div class="form-group">
				    <label class="col-sm-2 control-label text-right">Financial Year - </label>
				    <div class="col-sm-2" style="margin-top:7px;">
					<strong class="text-left"><?php echo $work_detail->mw_year; ?></strong>
				    </div>
				    <label class="col-sm-2 control-label text-right">Name of Work - </label>
				    <div class="col-sm-5" style="margin-top:7px;">
					<strong class="text-left"><?php echo $work_detail->mw_name; ?></strong>
				    </div>
				 </div>
				 <div class="form-group">
				  	<label class="col-sm-2 control-label text-right">Assistant Engineer<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="w_ae" id="w_ae">
				      	<option value="">---Select---</option>
				      	<?php foreach($ae_list as $ae_user){ ?>
						<option value="<?php echo $ae_user->u_id; ?>" <?php if($work_detail->work_se_id == $ae_user->u_id){ echo "selected";} ?>><?php echo $ae_user->firstname.' '.$ae_user->lastname.' ('.$ae_user->email.')'; ?></option>
						<?php } ?>
					  </select>
				      <small class="text-error w_ae"><?php echo form_error('w_ae'); ?></small>
				    </div>
					<label class="col-sm-2 control-label text-right">Sub Assistant Engineer<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="w_sae" id="w_sae">
					  	<option value="">---Select---</option>
				      	<?php foreach($sae_list as $sae_user){ ?>
						<option value="<?php echo $sae_user->u_id; ?>" <?php if($work_detail->work_ase_id == $sae_user->u_id){ echo "selected";} ?>><?php echo $sae_user->firstname.' '.$sae_user->lastname.' ('.$sae_user->email.')'; ?></option>
						<?php } ?>
				      </select>
				      <small class="text-error w_sae"><?php echo form_error('w_sae'); ?></small>
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
				    <div class="col-sm-12 text-center">
				      <button type="button" onclick="gotoclclickbutton();" class="btn btn-primary">Submit</button>
                      &nbsp;<a href="<?= site_url('admincontrol/panel/alocate_work_list') ?>" class="btn btn-danger">Cancel</a>
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
		$( "#w_t_date, #w_order_date, #w_com_date, #w_tent_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
	    $('.alert-error, .text-error').delay(6000).fadeOut();

	});

	function goto_check_work(){
		var f_year = $("#f_year option:selected").val();
		if(f_year != ""){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."admincontrol/panel/get_work_against_fyear"; ?>',
				data:{f_year:f_year},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg != 0)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('#plot_otherinfo').val('');
						//$('.otherplot_view').fadeOut(500);
						$('#w_name').html(data.work_set);
						$('#w_name').prop('disabled', false);
						
					}else{
						$('#w_name').html('<option value="">---Select---</option>');
						$('#w_name').prop('disabled', 'disabled');
					}
					
				}
			});
		}else{
			$('#w_name').html('<option value="">---Select---</option>');
			$('#w_name').prop('disabled', 'disabled');
		}
	}

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Z0-9]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var onlynumerics_hypen = /^[0-9\-]+$/;
		var onlynumerics_comma = /^[0-9,.]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
		
    	//var f_year = $('#f_year option:selected').val();
    	//var w_name = $("#w_name option:selected").val();
		var w_ae = $("#w_ae option:selected").val();
		var w_sae = $("#w_sae option:selected").val();
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		
		if(w_ae == ""){
			e_error = 1;
			$('.w_ae').html('Assistant Engineer is Required.');
		}else{
			if(!w_ae.match(onlynumerics)){
				e_error = 1;
				$('.w_ae').html('Assistant Engineer only use Numeric Value, Check again.');
			}else{
				$('.w_ae').html('');
			}	
		}
		if(w_sae == ""){
			e_error = 1;
			$('.w_sae').html('Sub Assistant Engineer is Required.');
		}else{
			if(!w_sae.match(onlynumerics)){
				e_error = 1;
				$('.w_sae').html('Sub Assistant Engineer only use Numeric Value, Check again.');
			}else{
				$('.w_sae').html('');
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
			//alert(newhash);
			//alert(rehash);
			$("#myForm").submit();
		}

  	}

	function isDatecheck(txtDate)
	{
		var currVal = txtDate;
		if(currVal == '')
			return false;
		
		var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
		var dtArray = currVal.match(rxDatePattern); // is format OK?
		
		if (dtArray == null) 
			return false;
		//Checks for dd/mm/yyyy format.
		dtMonth = dtArray[3];
		dtDay= dtArray[1];
		dtYear = dtArray[5];        
		
		if (dtMonth < 1 || dtMonth > 12) 
			return false;
		else if (dtDay < 1 || dtDay> 31) 
			return false;
		else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
			return false;
		else if (dtMonth == 2) 
		{
			var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
			if (dtDay> 29 || (dtDay ==29 && !isleap)) 
					return false;
		}
		return true;
    }

</script>