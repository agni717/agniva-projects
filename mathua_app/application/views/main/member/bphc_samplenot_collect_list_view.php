<?php $this->load->view('main/component/header')?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css">
<link href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()."js/dtable/buttons.dataTables.min.css"; ?>" rel="stylesheet" type="text/css">
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
				<h1 class="panel-title">Sample Not Collected List</h1>
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
				<div class="">
				<?php echo form_open_multipart('','class="form-horizontal" id="form123"'); ?>

					<div  class="form-group">
						<div class="col-md-4">
                          <label class="bmd-label-floating">Start Date</label>
						  <input type="text" class="form-control" id="s_date" name="s_date" autocomplete="off" value="<?php if(!empty($datelist['sdate'])){ echo date('d-m-Y',strtotime($datelist['sdate'])); }else{echo date('d-m-Y');} ?>" placeholder="DD-MM-YYYY" />
						  <small class="text-error s_date"><?php echo form_error('s_date'); ?></small>						  
                        </div>
						<div class="col-md-4">
                          <label class="bmd-label-floating">End Date</label>
						  <input type="text" class="form-control" id="e_date" name="e_date" autocomplete="off" value="<?php if(!empty($datelist['edate'])){ echo date('d-m-Y',strtotime($datelist['edate'])); }else{echo date('d-m-Y');} ?>" placeholder="DD-MM-YYYY" />
						  <small class="text-error e_date"><?php echo form_error('e_date'); ?></small>						  
                        </div>
						<div class="col-md-4">
					      <label class="bmd-label-floating">Select Block</label>
                          <select class="form-control" name="s_block" id="s_block">
                          <option value="">ALL</option>
							<?php foreach($block_list as $s_blocks){ ?>
								<option value="<?php echo $s_blocks->block_id; ?>" <?php if(!empty($datelist['sblock'])){ if($datelist['sblock'] == $s_blocks->block_id){echo 'selected="selected"';}} ?>><?php echo $s_blocks->block_name; ?></option>
							<?php } ?>
						  </select>	
                          <small class="text-error s_block"><?php echo form_error('s_block'); ?></small>				
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
                    </div>
                    <div class="col-sm-12 text-center">
                     	<input type="button" id="pa_target_submit"  onclick="goto_submit_button()" class="btn btn-primary pull-center"  value="Submit" />                     				   
                    </div>
                    <div class="clearfix"></div>
                <?php echo form_close(); ?>
				</div>
		<?php if(!empty($formlist)){ ?>
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
				<?php if($this->session->userdata('member_utype') <= 2){ ?>
					<th>Center</th>
				<?php }else{ ?>
					<th>Sl No</th>
				<?php } ?>
					<th>Date</th>
					<th>SRF-ID</th>
					<th>Name</th>
					<th>Mobile</th>
					<th>Migrant Workers</th>
					<th>Outside State</th>
					<th>Outside District</th>
					<th>Resident Bankura</th>
					<th>Block</th>
					<th>GP-Name</th>
					<th>Municipality</th>
					<th>State</th>
					<th>Swab Collected</th>
					<th>Pooling</th>
					<th>Standalone</th>
					<th>Quarantine</th>
					<?php if($this->session->userdata('member_utype') != 1){ ?>
					<th>Action</th>
					<?php } ?>
				</thead>
				<tbody>
				<?php foreach($formlist as $keys=>$forms){ ?>
					<tr>
						
						<?php if($this->session->userdata('member_utype') <= 2){ ?>
							<td><?php echo $forms->fuser_name; ?></td>
						<?php }else{ ?>
							<td><?php echo $keys+1; ?></td>
						<?php } ?>
						<td><?php echo date('d/m/Y',strtotime($forms->collect_date)); ?></td>
						<td><?php echo $forms->collect_srf; ?></td>
						<td><?php echo $forms->collect_name; ?></td>
						<td><?php echo $forms->collect_mobile; ?></td>
						<td><?php echo $forms->collect_worker; ?></td>
						<td><?php echo $forms->outstate_name; ?></td>
						<td><?php echo $forms->dist_name; ?></td>
						<td><?php echo $forms->collect_resident; ?></td>
						<td><?php echo $forms->block_name; ?></td>
						<td><?php echo $forms->gp_name; ?></td>
						<td><?php echo $forms->collect_munici; ?></td>
						<td><?php echo $forms->state_name; ?></td>
						<td><?php echo $forms->collect_swap; ?></td>
						<td><?php echo $forms->collect_pool; ?></td>
						<td><?php echo $forms->collect_stand; ?></td>
						<td><?php if($forms->collect_q_home == "Yes"){echo "Home";}
								elseif($forms->collect_q_inst == "Yes"){echo "Institutional";}
								elseif($forms->collect_q_semi_inst == "Yes"){echo "Semi Institutional";} ?></td>
						<?php if($this->session->userdata('member_utype') != 1){ ?>
						<td>
							<?php  
							if($this->session->userdata('member_id') == $forms->collect_createby){ ?>
						<a class="btn btn-xs btn-danger" href="<?php echo base_url()."member/new_bphc_form_update_submission/".$forms->collect_id; ?>" style="margin-bottom:5px;">Update Form</a>
						<?php } ?>
						</td>
						<?php } ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<?php } ?>
        </div>
		</div>
	    
	            
			</div>
		</div>
	</div>
</div>


<?php $this->load->view('main/component/footer'); ?>
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.bootstrap.min.js"></script>
<script>
	$(function(){
		$( "#report_date, #memo_date, #s_date, #e_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		$('#d_table_show').DataTable({
			//"order": []
			//"order": [[ 0, "asc" ]]
			dom: 'lBfrtip',
        	buttons: [
            {
                extend: 'pdf',
                footer: true,
				orientation: 'landscape',
				title: 'Portal for District Administration' + '\n' + 'BANKURA',
				customize: function(doc) {
					doc.styles.title = {
					fontSize: '20',
					alignment: 'center'
					}   
				},  
				pageSize: 'A2', //'LEGAL',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '<br/>' + 'BANKURA',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
                    }
            }  
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            //'pdfHtml5',
            //'print'
        ]
		});
	});

	function goto_submit_button(){
	
		$('.div_roller_total').fadeIn();
		var delay = 8000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var onlynumerics = /^[0-9]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		//var applicant_type = $("input[name='applicant_type']:checked").val();
		//var b_category = $("#b_category option:selected").val();
	
		var s_date = $('#s_date').val();
		var e_date = $('#e_date').val();
		//var t_division = $("#t_division option:selected").val();
		
		//goto_datecheck_book();
		if(s_date == ""){
			e_error = 1;
			$('.s_date').html('Start Date is Required.');
		}else{
			if(isDatecheck(s_date) == false){
				e_error = 1;
				$('.s_date').html('Start Date Format check properly and Try Again.');
			}else{
				$('.s_date').html('');
			}	
		}

		if(e_date == ""){
			e_error = 1;
			$('.e_date').html('End Date is Required.');
		}else{
			if(isDatecheck(e_date) == false){
				e_error = 1;
				$('.e_date').html('End Date Format check properly and Try Again.');
			}else{
				$('.e_date').html('');
			}	
		}
	
		//alert(fname);
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
			
		}else{
			//alert("ALL CLEAR");exit;
			$('#form123').submit();
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
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jquery.dataTables.min.js"; ?>"></script>  
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.buttons.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jszip.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/pdfmake.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/vfs_fonts.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.html5.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.print.min.js"; ?>"></script>