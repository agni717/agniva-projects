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
				<h1 class="panel-title">Duplicate SRF-ID List</h1>
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
					<th>Lab</th>
					<th>Memo No</th>
					<th>Memo Date</th>
					<th>Report Status</th>
					<th>Report Date</th>
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
						<td><?php echo $forms->collect_lab; ?></td>
						<td><?php echo $forms->collect_memo; ?></td>
						<td><?php if(!empty($forms->collect_m_date)){ echo date('d/m/Y',strtotime($forms->collect_m_date));} ?></td>
						<td><?php echo $forms->collect_result; ?></td>
						<td><?php if(!empty($forms->collect_reportdate)){ echo date('d/m/Y',strtotime($forms->collect_reportdate));} ?></td>
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
		//$( "#report_date, #memo_date, #s_date, #e_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
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
		
</script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jquery.dataTables.min.js"; ?>"></script>  
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/dataTables.buttons.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/jszip.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/pdfmake.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/vfs_fonts.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.html5.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url()."js/dtable/buttons.print.min.js"; ?>"></script>