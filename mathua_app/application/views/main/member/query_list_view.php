<?php $this->load->view('main/component/header')?>
<!--<link rel="stylesheet" href="<?php //echo base_url(); ?>assets/datepicker/jquery-ui.css">-->
<link href="<?php echo base_url(); ?>css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!--<link href="<?php //echo base_url()."js/dtable/buttons.dataTables.min.css"; ?>" rel="stylesheet" type="text/css">-->
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
				<h1 class="panel-title">Query List</h1>
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
			<table id="d_table_show" class="table table-bordered table-striped">
				<thead>
					<th>Sl No</th>
					<th>Query No.</th>
					<th>Date</th>
					<th>Subject</th>
					<th>Is Reply</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php foreach($formlist as $keys=>$forms){ ?>
					<tr>
						
						<td><?php echo $keys+1; ?></td>
						<td><?php echo $forms->query_no; ?></td>
						<td><?php echo date('d/m/Y',strtotime($forms->query_createdate)); ?></td>
						<td><?php echo $forms->query_subject; ?></td>
						<td><?php if($forms->query_is_reply == 0){ echo '<span style="color:red">Not Given Yet</span>';}else{echo '<span style="color:green">Replied</span>';} ?></td>
						<td><a class="btn btn-xs btn-warning" onclick="detailsview('<?php echo $forms->query_no; ?>');" style="margin-bottom:5px;">Details</a>
						</td>
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

        
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="text-decoration:none;">Query Number : <span class="q_number_set"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <div class="container-fluid">
			<div class="row">
			  <div class="col-sm-12 pb-2">
				<strong class="">Subject : <span class="q_subject_set"></span></strong>
			  </div>
			  <div class="col-md-7">
				<div class="alert-info p-2" role="alert">
					<div class="q_detail_set mb-2"></div>
					<div class="font-weight-bold mainAttachment">Attachment : <span class="q_attach_set"></span></div>
				</div>
			  </div>
			</div>
			<div>&nbsp;</div>
			  
			<div class="row replytab">
			  <div class="col-md-7 ml-auto">
				<div class="pb-2">
					<strong class="">Administrator Reply:-</strong>
				</div>
				<div class="alert-warning p-2" role="alert">
					<div class="q_reply_set mb-2"></div>
					<div class="font-weight-bold haveAttachment">Attachment : <span class="q_reply_attach_set"></span></div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>-->
    </div>
  </div>
</div>



<?php $this->load->view('main/component/footer'); ?>
<!--<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables4.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.bootstrap4.min.js"></script>
<script>
	$(function(){
		//$( "#report_date, #memo_date, #s_date, #e_date" ).datepicker({autoclose: true,dateFormat: 'dd-mm-yy',setDate: new Date()});
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();

		$('#d_table_show').DataTable({
			 
		});
	});

	function detailsview(q_no){
		if(q_no != ""){
			$.ajax({
				method:'POST',
				url:'<?php echo base_url()."member/getallinfo_fromquery_number"; ?>',
				data:{q_no: q_no},
				dataType:'JSON',
				success:function(data){
					//alert(data.msg);
					if(data.msg == 1)
					{
						//console.log(data);
						//alert(data.msg[0].space_rate);
						$('.q_number_set').html(q_no);
						if(data.info_set[0].query_is_reply == 0){
							$('.replytab').fadeOut();
						}else{
							$('.replytab').fadeIn();
							$('.q_reply_set').html(data.info_set[0].query_reply_details);
							if(data.info_set[0].query_reply_attach == null){
								$('.haveAttachment').fadeOut();
							}else{
								$('.haveAttachment').fadeIn();
								$('.q_reply_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/reply/' + data.info_set[0].query_reply_attach + '" target="_blank">Attached Reply Document</a>');
							}
						}
						$('.q_subject_set').html(data.info_set[0].query_subject);
						$('.q_detail_set').html(data.info_set[0].query_details);
						if(data.info_set[0].query_attachment == null){
							$('.mainAttachment').fadeOut();
						}else{
							$('.mainAttachment').fadeIn();
							$('.q_attach_set').html('<a href="<?php echo base_url(); ?>upload_file/forum_doc/' + data.info_set[0].query_attachment + '" target="_blank">Attached Document</a>');
						}
						$('#myModal').modal('show');
						//setTimeout(function(){ $('.get_success_total').fadeOut(); }, 3000);
						//setTimeout(function(){ window.location.replace("<?php echo site_url('member/testing_list')?>/"); }, 3000);
						
						
					}else{
						error_message = data.e_msg;
						$('.alert-error').html(error_message);
						$(".alert-error").fadeIn();
						//setTimeout(function(){ $('.alert-error').fadeOut(); }, delay);
					}
					
				}
			});
			
		}else{
			alert('Query Number Not Found. Chcek Again.');
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
<!--<script type="text/javascript" src="<?php //echo base_url()."js/dtable/jquery.dataTables.min.js"; ?>"></script>  
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/dataTables.bootstrap.min.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/dataTables.buttons.min.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/jszip.min.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/pdfmake.min.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/vfs_fonts.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/buttons.html5.min.js"; ?>"></script>
<script type="text/javascript" src="<?php //echo base_url()."js/dtable/buttons.print.min.js"; ?>"></script>-->