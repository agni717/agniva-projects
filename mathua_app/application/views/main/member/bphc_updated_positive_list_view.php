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
				<h1 class="panel-title">Updated Positive Case List</h1>
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
		<?php if(!empty($formlist)){ ?>		
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
					<th>Sl No</th>
					<?php if($this->session->userdata('member_utype') == 4 || $this->session->userdata('member_utype') == 1){ ?>
					<th>Action</th>
					<?php } ?>
					<th>Health Dist.</th>
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
					<th>Lab</th>
					<th>Memo No</th>
					<th>Memo Date</th>
					<th>Report Status</th>
					<th>Report Date</th>
					<th>Update By</th>
					<th>Admit Date</th>
					<th>Admitted At</th>
					<th>Safe Home</th>
					<th>Release Date</th>
				</thead>
				<tbody>
				<?php foreach($formlist as $keys=>$forms){ ?>
					<tr>
						<td><?php echo $keys+1; ?></td>
						<?php if($this->session->userdata('member_utype') == 4 || $this->session->userdata('member_utype') == 1){ ?>
						
						<td><?php if($this->session->userdata('member_utype') == 4){ if(empty($forms->pcase_release)){ ?>
						<a class="btn btn-xs btn-warning" href="javascript:;" onclick="dateupdate('<?php echo $forms->collect_name; ?>', <?php echo $forms->collect_id; ?>);">Update Release Date</a>
						<?php }else{ echo '<span style="color:green">Record Updated</span>'; } } ?>
						</td>
						<?php } ?>
						<td><?php echo $forms->fuser_name; ?></td>
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
						<td><?php echo $forms->collect_lab; ?></td>
						<td><?php echo $forms->collect_memo; ?></td>
						<td><?php if(!empty($forms->collect_m_date)){ echo date('d/m/Y',strtotime($forms->collect_m_date));} ?></td>
						<td><?php echo $forms->collect_result; ?></td>
						<td><?php if(!empty($forms->collect_reportdate)){ echo date('d/m/Y',strtotime($forms->collect_reportdate));} ?></td>
						<td><?php if(!empty($forms->collect_modifyby)){
							echo $forms->update_user;
						} ?></td>
						<td><?php echo date('d/m/Y',strtotime($forms->pcase_admit)); ?></td>
						<td><?php echo $forms->pcase_location; ?></td>
						<td><?php echo $forms->pcase_home; ?></td>
						<td><?php if(!empty($forms->pcase_release)){ echo date('d/m/Y',strtotime($forms->pcase_release));} ?></td>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Release Date</h4>
      </div>
      <div class="modal-body">
	  	<div class="row">
		  <div class="col-sm-12 text-center"><h5><strong>NAME : </strong><spna class="collectname"></span></h5></div>
        </div>
		<div class="row">
		  <div class="col-sm-6 col-sm-offset-3">
		  	<div class="form-group">
				<div class="control-label text-center">Release Date:</div>
				<input type="hidden" id="r_formid" name="r_formid" />
				<input type="text" class="form-control" name="r_date" id="r_date" Placeholder="DD-MM-YYYY">
				<small class="text-error r_date"><?php echo form_error('r_date'); ?></small>
        	</div>
		  </div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<div align="center">
					<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
					<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
					<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-offset-4">
				<button onclick="gotoclclickbutton();" class="form-control btn btn-warning">Submit</button>
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
		$( "#r_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
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
					columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '<br/>' + 'BANKURA',
                footer: true,
                exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]
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

	function dateupdate(name, rid){
		if((name != "") && (rid != "")){
			$('.collectname').html(name);
			$('#r_formid').val(rid);
			$('#myModal').modal('show');
		}	
	}

	function gotoclclickbutton(){
		$('.div_roller_total').fadeIn();
		var delay = 6000;
		var e_error = 0;
		var error_message = 'There have some errors plese check above, Try again.';
		var alphaletters_spaces = /^[A-Za-z ]+$/;
		var alphaletters = /^[A-Za-z]+$/;
		var alphanumerics = /^[A-Za-z0-9/() ]+$/;
		var alphanumerics_spaces = /^[A-Za-z0-9_,\- ]+$/;
		var alphanumerics_no = /^[A-Za-z0-9_/&():.,\- ]+$/;
		var onlynumerics = /^[0-9]+$/;
		
    	/*var ap_date = $('#ap_date').val();
    	var ap_srfid = $('#ap_srfid').val();
    	var ap_name = $('#ap_name').val();
		var mig_labour = $("input[name='mig_labour']:checked").val();
		var ap_state = $('#ap_state option:selected').val();*/
		var r_formid = $('#r_formid').val();
		var r_date = $('#r_date').val();
		
		if(r_date == ""){
			e_error = 1;
			$('.r_date').html('Date is Required.');
		}else{
			if(isDatecheck(r_date) == false){
				e_error = 1;
				$('.r_date').html('Date Format check properly and Try Again.');
			}else{
				$('.r_date').html('');
			}	
		}

		if(r_formid == ""){
			e_error = 1;
			error_message = 'There have some ID problem, Refresh and Try again.';
		}
		
		if(e_error == 1){
			$('.div_roller_total').fadeOut();
			$('.get_error_total').html(error_message);
			$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
			/*e_error = 0;
			error_message = '';*/
			setTimeout(function(){ $('.text-error, .get_error_total').fadeOut(); }, delay);
		}else{
			
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/update_releasedate_inpositive_form"; ?>',
				data:{r_date: r_date, r_formid: r_formid},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.div_roller_total').fadeOut();
						$('.get_success_total').html('Release Date is Updated Successfully.');
						$(".get_success_total").fadeIn();
						$('#r_formid, #r_date').val('');
						//$('#plot_otherinfo, #ifsc_code_sd').html('');
						setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						setTimeout(function(){ window.location.replace("<?php echo site_url('member/positive_case_update_list')?>"); }, 3000);
						
						
					}else{
						$('.div_roller_total').fadeOut();
						error_message = "There have some problem to Store Data, Try after some time.";
						error_message = error_message + "<br/>" + data.e_msg;
						$('.get_error_total').html(error_message);
						$(".get_error_total").fadeIn();
						setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
					}
					
				}
			});

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