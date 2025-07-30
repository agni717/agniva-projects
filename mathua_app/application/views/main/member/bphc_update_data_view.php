<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style>        

        <!-- Presentation -->
<div class="presentation-container">
  	<div class="container">
    	<div class="row">
			<?php $this->load->view('main/member/left_menu')?>
			
	        <div class="col-sm-10">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title">Update Collection Data</h1>
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
       
        <div class="panel-body">
          <form class="form-horizontal row-border" id="myForm" action="<?php echo base_url()."member/new_bphc_form_update_submission/".$collect_detail->collect_id; ?>" method="POST" enctype="multipart/form-data">
		  	<div class="form-group">
              <label class="col-md-3 control-label">Sample collection/ Screening Date <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_date" id="ap_date" placeholder="DD-MM-YYYY" class="form-control" value="<?php echo date('d-m-Y',strtotime($collect_detail->collect_date)); ?>" autocomplete="off">
				<small class="text-error text-left ap_date"><?php echo form_error('ap_date'); ?></small>
			  </div>
			  <label class="col-md-2 control-label">Swab Collected <font class="redclass">*</font></label>
				<div class="col-md-3">
					<label class="radio-inline">
						<input type="radio" name="ap_swap" id="ap_swap1" value="Yes" <?php if($collect_detail->collect_swap == "Yes"){echo 'checked';} ?>> Yes
					</label>
					<label class="radio-inline">
						<input type="radio" name="ap_swap" id="ap_swap2" value="No" <?php if($collect_detail->collect_swap == "No"){echo 'checked';} ?>> No
					</label><br/>
					<small class="text-error ap_swap"><?php echo form_error('ap_swap'); ?></small>
				</div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Name <font class="redclass">*</font></label>
              <div class="col-md-10">
                <input type="text" name="ap_name" id="ap_name" placeholder="Name" class="form-control" autocomplete="off" value="<?php echo $collect_detail->collect_name; ?>">
				<small class="text-error text-left ap_name"><?php echo form_error('ap_name'); ?></small>
              </div>
            </div>
            <div class="form-group">
			  <label class="col-md-2 control-label">Mobile No. <font class="redclass">*</font></label>
              <div class="col-md-4">
                <input type="text" name="ap_mobile" id="ap_mobile" placeholder="Mobile No." class="form-control" autocomplete="off" value="<?php echo $collect_detail->collect_mobile; ?>">
				<small class="text-error text-left ap_mobile"><?php echo form_error('ap_mobile'); ?></small>
              </div>
			  <label class="col-md-3 control-label">Migrant Workers <font class="redclass">*</font></label>
              <div class="col-md-3">
			  	<label class="radio-inline">
					<input type="radio" name="mi_worker" id="mi_worker1" value="Yes" <?php if($collect_detail->collect_worker == "Yes"){echo 'checked';} ?>> Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="mi_worker" id="mi_worker2" value="No" <?php if($collect_detail->collect_worker == "No"){echo 'checked';} ?>> No
				</label><br/>
				<small class="text-error mi_worker"><?php echo form_error('mi_worker'); ?></small>
              </div>
            </div>
			<div class="form-group mi_worker_tab" <?php if($collect_detail->collect_worker == "Yes"){echo 'style="display: block;"';}else{echo 'style="display: none;"';} ?>>
              <label class="col-md-2 control-label">Coming form Outside State <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="out_state" id="out_state" onchange="check_state();">
             	<option value="" selected="">---Select---</option>
             	<?php foreach($state_list as $s_states){ ?>
				<option value="<?php echo $s_states->state_id; ?>" <?php if($collect_detail->collect_outstate == $s_states->state_id){echo 'selected';} ?>><?php echo $s_states->state_name; ?></option>
				<?php } ?>
             	</select>
             	<small class="text-error out_state"><?php echo form_error('out_state'); ?></small>
			  </div>
			  <label class="col-md-2 control-label">Outside District</label>
              <div class="col-md-4">
			  	<select class="form-control" name="out_dist" id="out_dist" <?php if($collect_detail->collect_outstate != 26){ echo 'disabled';} ?>>
             	<option value="" selected="">---Select---</option>
             	<?php foreach($dist_list as $s_dists){ ?>
				<option value="<?php echo $s_dists->dist_id; ?>" <?php if($collect_detail->collect_outdist == $s_dists->dist_id){echo 'selected';} ?>><?php echo $s_dists->dist_name; ?></option>
				<?php } ?>
             	</select>
             	<small class="text-error out_dist"><?php echo form_error('out_dist'); ?></small>
              </div>
            </div>
			<div class="form-group">
			  <label class="col-md-4 control-label">Residing at Bankura District <font class="redclass">*</font></label>
              <div class="col-md-3">
			  	<label class="radio-inline">
					<input type="radio" name="mig_labour" id="mig_labour1" value="Yes" <?php if($collect_detail->collect_resident == "Yes"){echo 'checked';} ?>> Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="mig_labour" id="mig_labour2" value="No" <?php if($collect_detail->collect_resident == "No"){echo 'checked';} ?>> No
				</label><br/>
				<small class="text-error mig_labour"><?php echo form_error('mig_labour'); ?></small>
			  </div>
			  <label class="col-md-2 control-label">Quarantine <font class="redclass">*</font></label>
              <div class="col-md-3">
			  	<select class="form-control" name="ap_quaran" id="ap_quaran">
					<option value="">---Select---</option>
					<option value="Home"<?php if($collect_detail->collect_q_home == "Yes"){echo 'selected';} ?>>Home Quarantine</option>
					<option value="Inst"<?php if($collect_detail->collect_q_inst == "Yes"){echo 'selected';} ?>>Institutional Quarantine</option>
					<option value="SemiInst"<?php if($collect_detail->collect_q_semi_inst == "Yes"){echo 'selected';} ?>>Semi Institutional Quarantine</option>
				</select>
				<small class="text-error ap_quaran"><?php echo form_error('ap_quaran'); ?></small>
              </div>
			</div>
			<div class="form-group mig_labour_tab" <?php if($collect_detail->collect_resident == "Yes"){echo 'style="display: block;"';}else{echo 'style="display: none;"';} ?>>
              <label class="col-md-2 control-label">Block <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="ap_block" id="ap_block" onchange="goto_block_check();">
             	<option value="" selected="">---Select---</option>
             	<?php foreach($block_list as $s_blocks){ ?>
				<option value="<?php echo $s_blocks->block_id; ?>" <?php if($collect_detail->collect_block == $s_blocks->block_id){echo 'selected';} ?>><?php echo $s_blocks->block_name; ?></option>
				<?php } ?>
             	</select>
             	<small class="text-error ap_block"><?php echo form_error('ap_block'); ?></small>
              </div>
			  <label class="col-md-2 control-label">GP Name <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="ap_gp" id="ap_gp" <?php if(empty($collect_detail->collect_block)){echo 'disabled=""';} ?>>
             	<option value="" selected="">---Select---</option>
				<?php foreach($gp_list as $gp_s){ ?>
				<option value="<?php echo $gp_s->gp_id; ?>" <?php if($collect_detail->collect_gp == $gp_s->gp_id){echo 'selected';} ?>><?php echo $gp_s->gp_name; ?></option>
				<?php } ?>
             	</select>
             	<small class="text-error ap_gp"><?php echo form_error('ap_gp'); ?></small>
              </div>
			  <label class="col-md-2 control-label" style="margin-top:5px;">Minicipality <font class="redclass">*</font></label>
              <div class="col-md-4" style="margin-top:5px;">
			  	<select class="form-control" name="ap_muni" id="ap_muni">
             	<option value="" selected="">---Select---</option>
             	<option value="Bankura Municipality" <?php if($collect_detail->collect_munici == "Bankura Municipality"){echo 'selected';} ?>>Bankura Municipality</option>
             	<option value="Bishnupur Municipality" <?php if($collect_detail->collect_munici == "Bishnupur Municipality"){echo 'selected';} ?>>Bishnupur Municipality</option>
             	<option value="Sonamukhi Municipality" <?php if($collect_detail->collect_munici == "Sonamukhi Municipality"){echo 'selected';} ?>>Sonamukhi Municipality</option>
             	</select>
             	<small class="text-error ap_muni"><?php echo form_error('ap_muni'); ?></small>
              </div>
            </div>
			<div class="form-group mig_labour_none" <?php if($collect_detail->collect_resident == "No"){echo 'style="display: block;"';}else{echo 'style="display: none;"';} ?>>
              <label class="col-md-2 control-label">State <font class="redclass">*</font></label>
              <div class="col-md-4">
			  	<select class="form-control" name="ap_state" id="ap_state">
             	<option value="" selected="">---Select---</option>
             	<?php foreach($state_list as $s_states){ ?>
				<option value="<?php echo $s_states->state_id; ?>" <?php if($collect_detail->collect_state == $s_states->state_id){echo 'selected';} ?>><?php echo $s_states->state_name; ?></option>
				<?php } ?>
             	</select>
             	<small class="text-error ap_state"><?php echo form_error('ap_state'); ?></small>
              </div>
            </div>
			<div class="form-group swab_collect_tab" <?php if($collect_detail->collect_swap == "Yes"){echo 'style="display: block;"';}else{echo 'style="display: none;"';} ?>>
				<label class="col-md-2 control-label">SRF ID <font class="redclass">*</font></label>
				<div class="col-md-4">
					<input type="text" name="ap_srfid" id="ap_srfid" placeholder="SRF ID" class="form-control" autocomplete="off" value="<?php echo $collect_detail->collect_srf; ?>">
					<small class="text-error text-left ap_srfid"><?php echo form_error('ap_srfid'); ?></small>
				</div>
				<label class="col-md-2 control-label">Testing Lab <font class="redclass">*</font></label>
				<div class="col-md-4">
					<select class="form-control" name="ap_lab" id="ap_lab">	
					<option value="">---Select---</option>
					<?php foreach($lab_list as $a_labs){ ?>
					<option value="<?php echo $a_labs->lab_name; ?>"<?php if($collect_detail->collect_lab == $a_labs->lab_name){echo 'selected';} ?>><?php echo $a_labs->lab_name; ?></option>
					<?php } ?>
					</select>
					<small class="text-error ap_lab"><?php echo form_error('ap_lab'); ?></small>
				</div>
				<label class="col-md-2 control-label">Pooling <font class="redclass">*</font></label>
				<div class="col-md-4">
					<label class="radio-inline">
						<input type="radio" name="ap_pool" id="ap_pool1" value="Yes" <?php if($collect_detail->collect_pool == "Yes"){echo 'checked';} ?>> Yes
					</label>
					<label class="radio-inline">
						<input type="radio" name="ap_pool" id="ap_pool2" value="No" <?php if($collect_detail->collect_pool == "No"){echo 'checked';} ?>> No
					</label><br/>
					<small class="text-error ap_pool"><?php echo form_error('ap_pool'); ?></small>
				</div>
			</div>
			
			<!-- <div class="form-group">
			  <div class="col-md-12 text-left"><strong style="font-size:16px;color:blue;text-decoration:underline;">Local Address:-</strong></div>
			  <label class="col-md-4 control-label">Villege <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="text" name="ap_villege" id="ap_villege" placeholder="Villege Name" class="form-control">
				<small class="text-error text-left ap_villege"><?php //echo form_error('ap_villege'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Swab Collected <font class="redclass">*</font></label>
              <div class="col-md-8">
			  	<label class="radio-inline">
					<input type="radio" name="s_collect" id="s_collect1" value="Yes"> Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="s_collect" id="s_collect2" value="No"> No
				</label><br/>
				<small class="text-error s_collect"><?php //echo form_error('s_collect'); ?></small>
              </div>
            </div>
			<div class="form-group collect_type_tab" style="display:none;">
              <label class="col-md-4 control-label">Type of Collection <font class="redclass">*</font></label>
              <div class="col-md-8">
			  	<label class="radio-inline">
					<input type="radio" name="s_type" id="s_type1" value="Pooling"> Pooling
				</label>
				<label class="radio-inline">
					<input type="radio" name="s_type" id="s_type2" value="Standalone"> Standalone
				</label><br/>
				<small class="text-error s_type"><?php //echo form_error('s_type'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Symptomatic <font class="redclass">*</font></label>
              <div class="col-md-8">
			  	<label class="radio-inline">
					<input type="radio" name="ap_symptom" id="ap_symptom1" value="Yes"> Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="ap_symptom" id="ap_symptom2" value="No"> No
				</label><br/>
				<small class="text-error ap_symptom"><?php //echo form_error('ap_symptom'); ?></small>
              </div>
            </div> -->
			
			<!-- <div class="form-group">
              <label class="col-md-4 control-label">Upload Work Order Copy (File name must contain Agency Name) <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="userworkorder" id="userworkorder" class="form-control">
				<small class="text-error text-left userworkorder"><?php //echo form_error('userworkorder'); ?></small>
              </div>
            </div>
			<div class="form-group">
              <label class="col-md-4 control-label">Upload Details of Workers (File name must contain Agency Name) <font class="redclass">*</font></label>
              <div class="col-md-8">
                <input type="file" name="userworker" id="userworker" class="form-control">
				<small class="text-error text-left userworker"><?php //echo form_error('userworker'); ?></small>
              </div>
            </div> -->
			
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
			  <a href="<?php echo base_url()."member/dashboard"; ?>" class="btn btn-lg btn-danger">cancel</a>
              </div>
            </div>
          </form>
        </div>
		</div>
	            
	            
	            
	            
			</div>
		</div>
	</div>
</div>

        

<?php $this->load->view('main/component/footer'); ?>
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>

<script type="text/javascript">
    $(function(){
		$( "#ap_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		$('input:radio[name="mig_labour"]').change(function() {
			goto_mig_labour_check();
		});
		$('input:radio[name="mi_worker"]').change(function() {
			goto_out_collect_check();
		});
		$('input:radio[name="ap_swap"]').change(function() {
			goto_swap_collect_check();
		});
	});

	function goto_mig_labour_check(){
		var mig_labour = $("input[name='mig_labour']:checked").val();
		if(mig_labour == "Yes"){
			$('#ap_state').val('');
			$('.mig_labour_none').fadeOut(500);
			$('#ap_block, #ap_gp, #ap_muni').val('');
			$('.mig_labour_tab').show(500);
		}else{
			$('#ap_block, #ap_gp, #ap_muni').val('');
			$('.mig_labour_tab').fadeOut(500);
			$('#ap_state').val('');
			$('.mig_labour_none').show(500);
		}
	}

	function goto_out_collect_check(){
		var mi_worker = $("input[name='mi_worker']:checked").val();
		if(mi_worker == "Yes"){
			$('#out_state').val('');
			$('.mi_worker_tab').show(500);
		}else{
			$('#out_state').val('');
			//$('input:radio[name=s_collect]:checked').prop('checked', false).checkboxradio("refresh");
			$('.mi_worker_tab').fadeOut(500);
		}
	}

	function goto_swap_collect_check(){
		var ap_swap = $("input[name='ap_swap']:checked").val();
		if(ap_swap == "Yes"){
			$('#ap_lab, #ap_srfid').val('');
			$('input:radio[name=ap_pool]:checked').prop('checked', false);
			$('.swab_collect_tab').show(500);
		}else{
			$('#ap_lab, #ap_srfid').val('');
			$('input:radio[name=ap_pool]:checked').prop('checked', false);
			$('.swab_collect_tab').fadeOut(500);
		}
	}

	function goto_block_check(){
		var ap_block = $("#ap_block option:selected").val();
		if(ap_block != ""){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/get_gp_by_block"; ?>',
				data:{ap_block: ap_block},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg != 0)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						//$('#plot_otherinfo').val('');
						//$('.otherplot_view').fadeOut(500);
						$('#ap_gp').html(data.gp_set);
						$('#ap_gp').prop('disabled', false);
						
					}else{
						$('#ap_gp').html('<option value="">---Select---</option>');
						$('#ap_gp').prop('disabled', 'disabled');
					}
					
				}
			});
		}else{
			$('#ap_gp').html('<option value="">---Select---</option>');
			$('#ap_gp').prop('disabled', 'disabled');
		}	
	}

	function check_state(){
		var out_state = $("#out_state option:selected").val();
		if(out_state == 26){
			$('#out_dist').prop('disabled', false);
		}else{
			$('#out_dist').val('');
			$('#out_dist').prop('disabled', 'disabled');
		}
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
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		var specials_char = /[~`!#$%\^&*+=\[\]\\';./{}()|\\":<>\?]/g;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		
    	var ap_date = $('#ap_date').val();
    	var ap_srfid = $('#ap_srfid').val();
    	var ap_name = $('#ap_name').val();
		var mig_labour = $("input[name='mig_labour']:checked").val();
		var ap_state = $('#ap_state option:selected').val();
		var mi_worker = $("input[name='mi_worker']:checked").val();
		var out_state = $('#out_state option:selected').val();
		var out_dist = $('#out_dist option:selected').val();
		//var ap_city = $('#ap_city').val();
		var ap_mobile = $('#ap_mobile').val();
		var ap_pool = $("input[name='ap_pool']:checked").val();
		var ap_lab = $("#ap_lab option:selected").val();
		var ap_block = $("#ap_block option:selected").val();
		var ap_gp = $("#ap_gp option:selected").val();
		var ap_muni = $("#ap_muni option:selected").val();
		var ap_swap = $("input[name='ap_swap']:checked").val();
		/*var s_type = $("input[name='s_type']:checked").val();
		var ap_symptom = $("input[name='ap_symptom']:checked").val();*/
		var ap_quaran = $("#ap_quaran option:selected").val();
		
		if(mig_labour == "" || mig_labour == undefined){
			e_error = 1;
			$('.mig_labour').html('Residing at Bankura is Required.');
		}else{
			if(!mig_labour.match(alphaletters)){
				e_error = 1;
				$('.mig_labour').html('Residing at Bankura only Alphabet value, Check again.');
			}else{
				$('.mig_labour').html('');
			}
		}

		if(mig_labour == "Yes"){

			if(ap_block != ""){
				if(!ap_block.match(onlynumerics)){
					e_error = 1;
					$('.ap_block').html('Block needs only Numeric value, Check again');
				}else{
					$('.ap_block').html('');
				}
			}

			if(ap_gp != ""){
				if(!ap_gp.match(onlynumerics)){
					e_error = 1;
					$('.ap_gp').html('GP Name needs only Numeric value, Check again');
				}else{
					$('.ap_gp').html('');
				}
			}

			if(ap_muni != ""){
				if(!ap_muni.match(alphanumerics_no)){
					e_error = 1;
					$('.ap_muni').html('Municipality not use special carecters [without _ / & : ( . ) , -], Check again.');
				}else{
					$('.ap_muni').html('');
				}
			}

			if(ap_block == "" && ap_gp == "" && ap_muni == ""){
				e_error = 1;
				error_message = error_message + '<br/>Block and GP OR Municipality is required. Check again';
			}else if(ap_block != "" && ap_gp == "" && ap_muni == ""){
				e_error = 1;
				error_message = error_message + '<br/>GP is required. Check again';
			}else if(ap_block == "" && ap_gp != "" && ap_muni == ""){
				e_error = 1;
				error_message = error_message + '<br/>Block is required. Check again';
			}else if(ap_block != "" && ap_gp == "" && ap_muni != ""){
				e_error = 1;
				error_message = error_message + '<br/>GP is required. Check again';
			}else if(ap_block == "" && ap_gp != "" && ap_muni != ""){
				e_error = 1;
				error_message = error_message + '<br/>GP is required. Check again';
			}

		}

		if(mig_labour == "No"){
			if(ap_state == ""){
				e_error = 1;
				$('.ap_state').html('State is required.');
			}else{
				if(!ap_state.match(onlynumerics)){
					e_error = 1;
					$('.ap_state').html('State Name needs only Numeric value, Check again');
				}else{
					$('.ap_state').html('');
				}
			}
		}

		if(mi_worker == "" || mi_worker == undefined){
			e_error = 1;
			$('.mi_worker').html('Migrant Workers is Required.');
		}else{
			if(!mi_worker.match(alphaletters)){
				e_error = 1;
				$('.mi_worker').html('Migrant Workers only Alphabet value, Check again.');
			}else{
				$('.mi_worker').html('');
			}
		}

		if(mi_worker == "Yes"){
			if(out_state == ""){
				e_error = 1;
				$('.out_state').html('Outside State is required.');
			}else{
				if(!out_state.match(onlynumerics)){
					e_error = 1;
					$('.out_state').html('Outside State Name needs only Numeric value, Check again');
				}else{
					$('.out_state').html('');
					if(out_state == 26){
						if(out_dist == ""){
							e_error = 1;
							$('.out_dist').html('Outside District is required.');
						}else{
							if(!out_dist.match(onlynumerics)){
								e_error = 1;
								$('.out_dist').html('Outside District Name needs only Numeric value, Check again');
							}else{
								$('.out_dist').html('');
								
							}
						}	
					}else{
						$('.out_dist').html('');
					}
				}
			}
		}

		if(ap_swap == "" || ap_swap == undefined){
			e_error = 1;
			$('.ap_swap').html('Swab Collected is Required.');
		}else{
			if(!ap_swap.match(alphaletters)){
				e_error = 1;
				$('.ap_swap').html('Swab Collected only Alphabet value, Check again.');
			}else{
				$('.ap_swap').html('');
			}
		}

		if(ap_swap == "Yes"){
			if(ap_srfid == ""){
				e_error = 1;
				$('.ap_srfid').html('SRF-ID is Required.');
			}else{
				if(!ap_srfid.match(alphanumerics_no)){
					e_error = 1;
					$('.ap_srfid').html('SRF-ID not use special carecters [without _ / & : ( . ) , -], Check again.');
				}else{
					$('.ap_srfid').html('');
				}	
			}
			if(ap_pool == "" || ap_pool == undefined){
				e_error = 1;
				$('.ap_pool').html('Pooling is Required.');
			}else{
				if(!ap_pool.match(alphaletters)){
					e_error = 1;
					$('.ap_pool').html('Pooling only Alphabet value, Check again.');
				}else{
					$('.ap_pool').html('');
				}
			}
			if(ap_lab == ""){
				e_error = 1;
				$('.ap_lab').html('Testing Lab is Required.');
			}else{
				if(!ap_lab.match(alphanumerics_no)){
					e_error = 1;
					$('.ap_lab').html('Lab not use special carecters [without _ / & : ( . ) , -], Check again.');
				}else{
					$('.ap_lab').html('');
				}	
			}
		}

		if(ap_date == ""){
			e_error = 1;
			$('.ap_date').html('Date is Required.');
		}else{
			if(isDatecheck(ap_date) == false){
				e_error = 1;
				$('.ap_date').html('Date Format check properly and Try Again.');
			}else{
				$('.ap_date').html('');
			}	
		}
		
		if(ap_name == ""){
			e_error = 1;
			$('.ap_name').html('Name is Required.');
		}else{
			if(!ap_name.match(alphanumerics_no)){
				e_error = 1;
				$('.ap_name').html('Name not use special carecters [without _ / & : ( . ) , -], Check again.');
			}else{
				$('.ap_name').html('');
			}	
		}
		
		if(ap_quaran == ""){
			e_error = 1;
			$('.ap_quaran').html('Quarantine is Required.');
		}else{
			if(!ap_quaran.match(alphaletters)){
				e_error = 1;
				$('.ap_quaran').html('Quarantine only Alphabet value, Check again.');
			}else{
				$('.ap_quaran').html('');
			}
		}
		
		if(ap_mobile == ""){
			e_error = 1;
			$('.ap_mobile').html('Mobile No. is required.');
		}else{
			if(!ap_mobile.match(onlynumerics)){
				e_error = 1;
				$('.ap_mobile').html('Mobile No. needs only 10 digit.');
			}else if(ap_mobile.length != 10){
				e_error = 1;
				$('.ap_mobile').html('Mobile No. needs only 10 digit.');
			}else{
				$('.ap_mobile').html('');
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