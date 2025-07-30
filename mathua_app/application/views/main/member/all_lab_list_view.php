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
				<h1 class="panel-title">Laboratory List</h1>
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
		<div align="right"><a href="<?php echo base_url().'member/add_new_lab'; ?>" class="btn btn-md btn-warning">Add New Lab</a></div>
		<?php if(!empty($lab_list)){ ?>
		<div class="table-responsive">
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
					<th>Serial No.</th>
					<?php if($this->session->userdata('member_utype') == 1){ ?>
					
					<?php } ?>
					<th>Laboratory Name</th>
				</thead>
				<tbody>
				<?php foreach($lab_list as $keys=>$labs){ ?>
					<tr>
						<?php if($this->session->userdata('member_utype') == 1){ ?>
						
						<?php } ?>
						<td><?php echo $keys+1; ?></td>
						<td><?php echo $labs->lab_name; ?></td>
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
				//orientation: 'landscape',
				title: 'Portal for District Administration' + '\n' + 'BANKURA',
				customize: function(doc) {
					doc.styles.title = {
					fontSize: '20',
					alignment: 'center'
					}   
				},  
				pageSize: 'A4', //'LEGAL',
                exportOptions: {
                        columns: [0,1]
                    }
            },
            {
                extend: 'csv',
                footer: false,
                exportOptions: {
					columns: [0,1]
                    }
                
            },
            {
                extend: 'excel',
                footer: false,
                exportOptions: {
					columns: [0,1]
                    }
            },
            {
                extend: 'copy',
                footer: true,
                exportOptions: {
					columns: [0,1]
                    }
            },
            {
                extend: 'print',
				title: 'Portal for District Administration' + '<br/>' + 'BANKURA',
                footer: true,
                exportOptions: {
					columns: [0,1]
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
	
		//var s_date = $('#s_date').val();
		//var e_date = $('#e_date').val();
		var s_block = $("#s_block option:selected").val();
		var s_muni = $("#s_muni option:selected").val();
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

		if(s_date != "" && e_date == ""){
			e_error = 1;
			error_message = 'Start Date and End Date both is required, Check again.';
		}else if(s_date == "" && e_date != ""){
			e_error = 1;
			error_message = 'Start Date and End Date both is required, Check again.';
		}
		//goto_datecheck_book();
		if(s_block == "" && s_muni == ""){
			e_error = 1;
			error_message = 'Atleast 1 input needed, Check again.';
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