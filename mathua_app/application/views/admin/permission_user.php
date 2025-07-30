<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />

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
            User Permission - <?php echo $current_user->firstname." ".$current_user->lastname."(".$current_user->username.")"; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Permission</li>
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
                  <h3 class="box-title">User Permission - <?php echo $current_user->firstname." ".$current_user->lastname."(".$current_user->username.")"; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <?php echo form_open_multipart('','class="form-horizontal" id="myForm"'); ?>
                 <div class="form-group">
				  	<label class="col-sm-2 control-label text-right">Permit Application<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <select class="form-control" name="p_type" id="p_type" autocomplete="off">
				      	<option value="">---Select---</option>
				      	<?php foreach($per_appli as $appli_s){ ?>
						<option value="<?php echo $appli_s->papp_id; ?>"><?php echo $appli_s->papp_name; ?></option>
						<?php } ?>
				      </select>
				      <small class="text-error p_type"><?php echo form_error('p_type'); ?></small>
				    </div>
					<label class="col-sm-2 control-label text-right">Permit Level<font style="color: red;">*</font></label>
				    <div class="col-sm-3" id="all_checks">
						<label class="checkbox-inline"><input type="checkbox" name="pr_lvl[]" value="View" autocomplete="off">View</label>
						<label class="checkbox-inline"><input type="checkbox" name="pr_lvl[]" value="Add" autocomplete="off">Add</label>
						<label class="checkbox-inline"><input type="checkbox" name="pr_lvl[]" value="Edit" autocomplete="off">Edit</label>
						<label class="checkbox-inline"><input type="checkbox" name="pr_lvl[]" value="Delete" autocomplete="off">Delete</label>
						<br/><small class="text-error pr_lvl"><?php echo form_error('pr_lvl[]'); ?></small>
					</div>
				  </div>
				  <div class="form-group usertype_choose" style="display:block;">
				  	
					<!--<label class="col-sm-2 control-label text-right">Email Address<font style="color: red;">*</font></label>
				    <div class="col-sm-3">
				      <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Enter Email" autocomplete="off" />
				      <small class="text-error emailid"><?php //echo form_error('emailid'); ?></small>
				    </div>-->
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
                      &nbsp;<a href="<?= site_url('admincontrol/dashboard/administrator') ?>" class="btn btn-danger">Cancel</a>
				    </div>
				  </div>
                  <?php form_close(); ?>
				  
					
					<div class="table-responsive">
						<table class="table table-striped" id="datatable_tab" width="100%">
							<thead style="font-weight: bold;">
								<td>Name</td>
								<td>View</td>
								<td>Add</td>
								<td>Edit</td>
								<td>Delete</td>
								<td>Action</td>
							</thead>
							<tbody>
								<?php foreach($current_permit as $users)
								{ ?>
								<tr>
									<td><?php echo $users->papp_name; ?></td>
									<td><?php if($users->up_view == 1){ ?>
										  <span style="color:green;">Yes</span>
									  <?php }else{ ?>
										<span style="color:red;">No</span>
									  <?php } ?></td>
									<td><?php if($users->up_add == 1){ ?>
										  <span style="color:green;">Yes</span>
									  <?php }else{ ?>
										<span style="color:red;">No</span>
									  <?php } ?></td>
									<td><?php if($users->up_edit == 1){ ?>
										  <span style="color:green;">Yes</span>
									  <?php }else{ ?>
										<span style="color:red;">No</span>
									  <?php } ?></td>
									<td><?php if($users->up_delete == 1){ ?>
										  <span style="color:green;">Yes</span>
									  <?php }else{ ?>
										<span style="color:red;">No</span>
									  <?php } ?></td>
									<td><a onclick="return confirm('You are about to delete a record. This cannot be undone. Are you sure?');" href="<?php echo base_url().'admincontrol/dashboard/delete_permit/'.$current_user->u_id.'/'.$users->up_id; ?>" title="Delete Permission"><i class="fa fa-trash-o text-warning"></i></a></td>
								</tr>	
								<?php } ?>
							</tbody>
						</table>
					</div>
                  
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
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$("#datatable_tab").dataTable();
	      $('.alert-error, .text-error').delay(8000).fadeOut();
	});
	
	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = '';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&(@):.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	var p_type = $('#p_type option:selected').val();
    	/*var permit_gen = [];
	
		$.each($("input[name='pr_lvl']:checked"), function(){            
			permit_gen.push($(this).val());
		});
		
		if(permit_gen.length == 0){
			e_error = 1;
			error_message = 'No Permit Level is Selected, please check again.';
		}*/
		
		//var ap_symptom = $("input[name='ap_symptom']:checked").val();
		//var ap_quaran = $("input[name='ap_quaran']:checked").val();
		var chk_counter = $('input[name="pr_lvl[]"]:checked').length;
		if(chk_counter == 0){
			e_error = 1;
			error_message = 'No Permit Level is Selected, please check again.';
		}
		
		if(p_type == ""){
			e_error = 1;
			$('.p_type').html('Permit Application is Required.');
		}else{
			if(!p_type.match(onlynumerics)){
				e_error = 1;
				$('.p_type').html('Permit Application only use Numeric Values, Check again.');
			}else{
				$('.p_type').html('');
			}	
		}
		
		/*if(document.getElementById("userworkorder").files.length == 0){
			e_error = 1;
			$('.userworkorder').html('Work-Order File is Required.');
		}else{
			var fileInput = document.getElementById('userworkorder'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworkorder').html('Work-Order File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworkorder').html('');
			}
			
		}
		if(document.getElementById("userworker").files.length == 0){
			e_error = 1;
			$('.userworker').html('Worker Details File is Required.');
		}else{
			var fileInput = document.getElementById('userworker'); 
			var filePath = fileInput.value;
			if(!allowedExtensions.exec(filePath)){
				e_error = 1;
				$('.userworker').html('Worker Details File type Invalid.(Use PDF/JPG)');
			}else{
				$('.userworker').html('');
			}
		}*/
		
		//alert(salts);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			if(error_message != ''){
				$('.get_error_total').html(error_message);
				$(".get_error_total").fadeIn();
			}
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