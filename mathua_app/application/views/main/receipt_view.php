<?php $this->load->view('main/component/header')?>
<style>
.alert-error, .text-error, .redclass {
    	color: red !important;
	}
</style>        

        <!-- Presentation -->
<div class="presentation-container">
  	<div class="container">
    	<div class="row">
	        <div class="col-sm-12 text-center">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
				<i class="icon-calendar"></i>
				<h1 class="panel-title bg-success">Your Application is submitted Successfully</h1>
				<?php if (isset($error)) { ?>
				<div class="alert alert-error">                
					<h3>Error!</h3>
					<h5><?php echo $error; ?></h5>
				</div>
				<?php } ?>
				</div>
       
        <div class="panel-body">
					
				<div class="box-body table-responsive text-left">
				  	
                  <table class="table table-bordered" width="100%">
	                <tbody>
						<tr>
							<td width="25%"><strong>Application Number</strong></td>
							<td><strong><?php echo $doc_detail->app_ucode; ?></strong></td>
							<td><strong>Application Date</strong></td>
							<td><?php echo date('d/m/Y',strtotime($doc_detail->appli_createdate)); ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_name; ?></td>
						</tr>
						<tr>
							<td><strong>Applicant/Agency Email</strong></td>
							<td><?php echo $doc_detail->appli_email; ?></td>
							<td><strong>Applicant/Agency Mobile</strong></td>
							<td><?php echo $doc_detail->appli_mobile; ?></td>
						</tr>
						<tr>
							<td><strong>Work Name</strong></td>
							<td colspan="3"><?php echo $doc_detail->appli_work; ?></td>
						</tr>
					</tbody>
                  </table>
				  <div class="text-center">
					<?php if($doc_detail->appli_status == 1){ ?>
						<a href="javascript:;" onclick="window.print()" class="btn btn-primary">Print</a>
						<a href="<?php echo base_url(); ?>" class="btn btn-warning">Back to Home</a>
					<?php } ?>
					</div>
                </div><!-- /.box-body -->
			
        </div>
		</div>
	            
	            
	            
	            
			</div>
		</div>
	</div>
</div>

        

<?php $this->load->view('main/component/footer'); ?>

<script type="text/javascript">
    $(function(){
		$('#text-danger, .alert, .text-error').delay(10000).fadeOut();
	});

</script>