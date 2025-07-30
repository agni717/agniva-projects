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
				<h1 class="panel-title">Final Report</h1>
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
						
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped" data-page-length='50'>
				<thead>
					<tr>
						<th rowspan="2">Sl No</th>
						<th rowspan="2">Name of Health District/ Medical College Hospital/DH/SDH/SSH,RH/BPHC</th>
						<th rowspan="2">VTM Available as on <?php echo date('d-m-Y'); ?></th>
						<th rowspan="2">Sample collected as on <?php echo date('d-m-Y'); ?></th>
						<th rowspan="2">Cumulative Sample collected as on <?php echo date('d-m-Y'); ?></th>
						<th rowspan="2">Pooling as on <?php echo date('d-m-Y'); ?> (Cumulative)</th>
						<th rowspan="2">Stand Alone as on <?php echo date('d-m-Y'); ?> (Cumulative)</th>
						<th colspan="7">Sample sent for testing upto <?php echo date('d-m-Y'); ?> (Cumulative)</th>
						<th colspan="7">Test Result Pending as on <?php echo date('d-m-Y'); ?></th>
					</tr>
					<tr>
						<th>Sample sent to Mednipur MCH</th>
						<th>Sample sent to Dr. Lal Pathlab</th>
						<th>Sample sent to NICED</th>
						<th>Sample sent to School of Tropical Medicine</th>
						<th>Sample sent to BSMC&H</th>
						<th>Sample sent to Sanaka Hospital</th>
						<th>Total Sent</th>
						<th>Test Result Pending on Mednipur MCH</th>
						<th>Test Result Pending on Dr. Lal Pathlab</th>
						<th>Test Result Pending on NICED</th>
						<th>Test Result Pending on School of Tropical Medicine</th>
						<th>Test Result Pending on BSMC&H</th>
						<th>Test Result Pending on Sanaka Hospital</th>
						<th>Total Pending</th>
					</tr>
				</thead>
				<tbody>
				<?php $t_vtm = $today_col = $total_col = $total_p = $total_out = 0;
					$tl_1 = $tl_2 = $tl_3 = $tl_4 = $tl_5 = $tl_6 = $tl_7_total = 0;
					$tp_1 = $tp_2 = $tp_3 = $tp_4 = $tp_5 = $tp_6 = $tp_7_total = 0;
					foreach($user_list as $keys=>$users){ 
					$t_vtm = $t_vtm + $users['total_vtm'];
					$today_col = $today_col + $users['today_collect'];
					$total_col = $total_col + $users['total_collect'];
					$total_p = $total_p + $users['total_pool'];
					$total_out = $total_out + $users['total_stand'];
					$tl_1 = $tl_1 + $users['total_lab1'];
					$tl_2 = $tl_2 + $users['total_lab2'];
					$tl_3 = $tl_3 + $users['total_lab3'];
					$tl_4 = $tl_4 + $users['total_lab4'];
					$tl_5 = $tl_5 + $users['total_lab5'];
					$tl_6 = $tl_6 + $users['total_lab6'];
					$tl_7_total = $tl_7_total + $users['total_lab_sent'];
					$tp_1 = $tp_1 + $users['total_pending_1'];
					$tp_2 = $tp_2 + $users['total_pending_2'];
					$tp_3 = $tp_3 + $users['total_pending_3'];
					$tp_4 = $tp_4 + $users['total_pending_4'];
					$tp_5 = $tp_5 + $users['total_pending_5'];
					$tp_6 = $tp_6 + $users['total_pending_6'];
					$tp_7_total = $tp_7_total + $users['total_lab_pending'];
					?>
					<tr>
						<td><?php echo $keys+1; ?></td>
						<td><?php echo $users['user_name']; ?></td>
						<td><?php echo $users['total_vtm']; ?></td>
						<td><?php echo $users['today_collect']; ?></td>
						<td><?php echo $users['total_collect']; ?></td>
						<td><?php echo $users['total_pool']; ?></td>
						<td><?php echo $users['total_stand']; ?></td>
						<td><?php echo $users['total_lab1']; ?></td>
						<td><?php echo $users['total_lab2']; ?></td>
						<td><?php echo $users['total_lab3']; ?></td>
						<td><?php echo $users['total_lab4']; ?></td>
						<td><?php echo $users['total_lab5']; ?></td>
						<td><?php echo $users['total_lab6']; ?></td>
						<td><?php echo $users['total_lab_sent']; ?></td>
						<td><?php echo $users['total_pending_1']; ?></td>
						<td><?php echo $users['total_pending_2']; ?></td>
						<td><?php echo $users['total_pending_3']; ?></td>
						<td><?php echo $users['total_pending_4']; ?></td>
						<td><?php echo $users['total_pending_5']; ?></td>
						<td><?php echo $users['total_pending_6']; ?></td>
						<td><?php echo $users['total_lab_pending']; ?></td>	
					</tr>
				<?php } ?>
					<tr>
						<td>31</td>
						<td><strong>Total</strong></td>
						<td><strong><?php echo $t_vtm; ?></strong></td>
						<td><strong><?php echo $today_col; ?></strong></td>
						<td><strong><?php echo $total_col; ?></strong></td>
						<td><strong><?php echo $total_p; ?></strong></td>
						<td><strong><?php echo $total_out; ?></strong></td>
						<td><strong><?php echo $tl_1; ?></strong></td>
						<td><strong><?php echo $tl_2; ?></strong></td>
						<td><strong><?php echo $tl_3; ?></strong></td>
						<td><strong><?php echo $tl_4; ?></strong></td>
						<td><strong><?php echo $tl_5; ?></strong></td>
						<td><strong><?php echo $tl_6; ?></strong></td>
						<td><strong><?php echo $tl_7_total; ?></strong></td>
						<td><strong><?php echo $tp_1; ?></strong></td>
						<td><strong><?php echo $tp_2; ?></strong></td>
						<td><strong><?php echo $tp_3; ?></strong></td>
						<td><strong><?php echo $tp_4; ?></strong></td>
						<td><strong><?php echo $tp_5; ?></strong></td>
						<td><strong><?php echo $tp_6; ?></strong></td>
						<td><strong><?php echo $tp_7_total; ?></strong></td>
					</tr>
				</tbody>
			</table>
		</div>
				
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
				title: 'Portal for District Administration' + '\n' + 'BANKURA' + '\n' + '<?php echo date("d-m-Y h:i A"); ?>',
				customize: function(doc) {
					doc.styles.title = {
					fontSize: '20',
					alignment: 'center'
					}   
				},  
				pageSize: 'A2',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '\n' + 'BANKURA' + '\n' + '<?php echo date("d-m-Y h:i A"); ?>',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]
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
  
	//var p_date = $('#p_date').val();
	//var hd_set = $("#hd_set option:selected").val();
	var s_id = $("#s_id option:selected").val();

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
</script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jquery.dataTables.min.js"; ?>"></script>  
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.buttons.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jszip.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/pdfmake.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/vfs_fonts.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.html5.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.print.min.js"; ?>"></script>