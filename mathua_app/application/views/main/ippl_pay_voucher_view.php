<?php $this->load->view('main/component/header')?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-datepicker3.css"/>
<link href="<?php echo base_url(); ?>css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Presentation -->
        <div class="presentation-container">
        	<div class="container">
	            		
	            <div class="row">
	            	<div class="col-sm-12 text-center">
        				<h1 class="header_search"><?php echo $section_detail->section_name; ?> Search</h1>
        			</div>

					<div class="col-sm-4">
						<div class="form-group">	
							<label>Year:</label>
							<select name="search_year" id="search_year" class="form-control">
							<option value="">All</option>
							<?php foreach($dist_year as $years){ ?>
							<option value="<?php echo $years->file_year; ?>"><?php echo $years->file_year; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">	
							<label>Start Date:</label>
							<input type="text" name="search_date" id="search_date" class="form-control" placeholder="Select StartDate (DD/MM/YYYY)" autocomplete="off" />
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">	
							<label>End Date:</label>
							<input type="text" name="search_date_end" id="search_date_end" class="form-control" placeholder="Select EndDate (DD/MM/YYYY)" autocomplete="off" />
						</div>
					</div>
					<!--<div class="col-sm-2">&nbsp;</div>-->
					<div class="col-sm-offset-2 col-sm-4">
						<div class="form-group">	
							<label>Voucher No:</label>
							<input type="text" name="search_voucher" id="search_voucher" class="form-control" placeholder="Enter Voucher Number" />
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">	
							<label>Party Name:</label>
							<input type="text" name="search_party" id="search_party" class="form-control" placeholder="Enter Party Name" />
						</div>
					</div>
					<div class="col-sm-2">&nbsp;</div>
					<div style="clear: both;"></div>
					<p align="center">OR</p>
					<div class="col-sm-offset-2 col-sm-8">
						<div class="form-group">	
							<label>File Content:</label>
							<input type="text" name="search_content" id="search_content" class="form-control" placeholder="Enter File Content Name" />
						</div>
					</div>
					
					
					<div class="col-sm-offset-2 col-sm-8 text-center">
		              <div align="center">
	             		    <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
	                        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
	             		<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>assets/img/ajax_loader.gif" style="max-width: 60px;" /></div>
	             	</div>
	              </div>
					
					<div class="form-group">        
				      <div class="col-sm-12 text-center">
				        <button onclick="gotosearch_file();" class="btn btn-lg btn-primary">Search</button>
				      </div>
				    </div>
				    
				    <div class="col-sm-12">
				    <div class="serach_result">
				    	
				    </div>
				    </div>
				    
				    
				    
	            </div>
	            
	          
        	</div>
        </div>

<?php $this->load->view('main/component/footer'); ?>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url(); ?>js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">
$(function(){
      $('#alert_msg, .text-error').delay(8000).fadeOut();
      /*$('#b_category, #r_office').val('');
      $('#bsub_category, #plot_apply').prop('disabled', 'disabled');*/
      $('#search_date, #search_date_end').datepicker({
	  		format: 'dd/mm/yyyy',
	  		autoclose: true
      });
      //$('#d_table_show').DataTable({
	      //"order": []
	      //"order": [[ 0, "asc" ]]
      //});
      $('#search_year, #search_date, #search_voucher, #search_party, #search_content').keypress(function(e) {
	    var key = e.which;
	    if (key == 13) // the enter key code
	    {
	      gotosearch_file();
	      //return false;
	    }
	  });
  });
  
function gotosearch_file(){
	$('.div_roller_total').fadeIn();
	var delay = 8000;
	var e_error = 0;
	var sec_id = '<?php echo $section_detail->section_id; ?>';
	var s_year = $('#search_year').val();
	var s_date = $('#search_date').val();
	var s_date_end = $('#search_date_end').val();
	var s_voucher = $('#search_voucher').val();
	var s_party = $('#search_party').val();
	var s_content = $('#search_content').val();
	var form_data = new FormData();
	//alert(sec_id);exit;
	form_data.append('sec_id',sec_id);
	form_data.append('s_year',s_year);
	form_data.append('s_date',s_date);
	form_data.append('s_date_end',s_date_end);
	form_data.append('s_voucher',s_voucher);
	form_data.append('s_party',s_party);
	form_data.append('s_content',s_content);
	
	$.ajax({
		method:'POST',
		url:'<?php echo base_url()."member/check_serching_data"; ?>',
		data:form_data,
		dataType:'JSON',
		contentType: false,
		processData: false,
		success:function(data){
			//alert(data.msg);
			if(data.msg == 1)
			{
				//console.log(data);
				//alert(data.msg[0].space_rate);
				$('.div_roller_total').fadeOut();
				$('.get_error_total').fadeOut();
				//$('.get_success_total').html('');
				$('.serach_result').html(data.response_set);
				$('#d_table_show').DataTable({
				      //"order": []
				      //"order": [[ 0, "asc" ]]
			      });
				
				
			}else{
				$('.div_roller_total').fadeOut();
				$('.serach_result').html('');
				error_message = "No Data Found, Try again.";
				if(data.seterror != ''){
					$('.get_error_total').html(data.seterror + '<br/>' + error_message);
				}else{
					$('.get_error_total').html(error_message);
				}
				$(".get_error_total").fadeIn();
				setTimeout(function(){ $('.get_error_total').fadeOut(); }, delay);
			}
			
		}
	});
}
</script>

