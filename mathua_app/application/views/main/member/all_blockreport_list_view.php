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
				<h1 class="panel-title">Blockwise Active Case Report</h1>
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
						<th>Sl No</th>
						<th>Block/ Municipality</th>
						<th>Total Sample Collected</th>
						<th>Total Report Negative</th>
						<th>Total report Positive</th>
						<th>Total Active Cases</th>
						<th>Total Released</th>
					</tr>
				</thead>
				<tbody>
				<?php $t_vtm = $today_col = $total_col = $total_p = $total_out = 0;
					$tl_1 = $tl_2 = $tl_3 = $tl_4 = $tl_5 = $tl_6 = $tl_7_total = 0;
					$tp_1 = $tp_2 = $tp_3 = $tp_4 = $tp_5 = $tp_6 = $tp_7_total = 0;
					foreach($block_list as $keys=>$blocks){ 
					
					?>
					<tr>
						<td><?php echo $keys+1; ?></td>
						<td><?php echo $blocks['name']; ?></td>
						<td><?php echo $blocks['t_sample']; ?></td>
						<td><?php echo $blocks['t_negetive']; ?></td>
						<td><?php echo $blocks['t_positive']; ?></td>
						<td><?php echo $blocks['t_active']; ?></td>
						<td><?php echo $blocks['t_release']; ?></td>
					</tr>
				<?php } ?>
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
				//orientation: 'landscape',
				title: 'Portal for District Administration' + '\n' + 'BANKURA' + '\n' + '<?php echo date("d-m-Y h:i A"); ?>',
				customize: function(doc) {
					doc.styles.title = {
					fontSize: '20',
					alignment: 'center'
					}   
				},  
				pageSize: 'A4',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
						columns: [0,1,2,3,4,5,6]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '\n' + 'BANKURA' + '\n' + '<?php echo date("d-m-Y h:i A"); ?>',
                footer: true,
                exportOptions: {
                        columns: [0,1,2,3,4,5,6]
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