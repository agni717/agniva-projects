<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<div class="content-wrapper">
    <section class="content-header">
	  <h1>
    Candidate - Interview Details
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Candidate - Interview Details</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
      <div class="row">
        <div class="col-sm-offset-4 col-md-4">
          <label>Enter Registration No.</label>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-offset-4 col-md-4 m-0 p-0">
          <input class="form-control" type="text" id="search_reg_no" name="search_reg_no" value="" placeholder="Search" autocomplete="off" />
		  <small class="text-error search_reg_no"><?php echo form_error('search_reg_no'); ?></small>
        </div>
        <div class="col-md-2 m-0 p-0">
          <button class="btn btn-primary m-0 btn-search"><span><i class="fa fa-search"></i></span></button>    
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">&nbsp;
          <!-- <small class="text-error">Hwllo</small>   -->
        </div>
      </div>
      <!-- 
      <div class="row m-0 p-0">
        <div class="col-md-10">
          <h4>Order by</h4>
        </div>
      </div>
       -->
      <!-- 
      <div class="row m-0 p-0">
        <div class="col-md-3">
          <label>Advertisement </label>
          <input type="checkbox" style="width: 20px;height: 20px;margin: 10px;transform: translate(0,20%);" name="">
        </div>
      </div> 
    -->
  <div class="row">
	<div align="center">
		<div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
		<div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
		<div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
	</div>
  </div>
	
	<div>
      <div class="box box-warning search-results" style="margin: 20px;padding: 10px;width: 97%;display: none;">
      </div>
  </div>
  </section>

</div>


<script type="text/javascript">

  var applicationId = "";
	$(function() {
	  $("#search_reg_no").focus();
	});

  $('.btn-search').on('click',function(event){
    $('.div_roller_total').fadeIn();
    let key = $('input[name="search_reg_no"]').val();

		var delay = 5000;
		var e_error = 0;
		var error_message = '';
		var alphanumerics = /^[A-Za-z0-9]+$/;
		if(key == ""){
			e_error = 1;
			$('.search_reg_no').html('Candidate Registration No. is Required.');
		}else{
			if(!key.match(alphanumerics)){
				e_error = 1;
				$('.search_reg_no').html('Candidate Registration No. only use AlphaNumeric Values');
			}else{
				$('.search_reg_no').html('');
			}	
		}
		if (e_error == 1) {
			$('.div_roller_total').fadeOut();
      $('.search-results').fadeOut();
			//$('.get_error_total').html(error_message);
			//$(".get_error_total").fadeIn();
			$(".text-error").fadeIn();
      $("#search_reg_no").focus();
			setTimeout(function() {
				$('.text-error, .get_error_total').fadeOut();
			}, delay);
		} else {
			
			let form_data = new FormData();

			form_data.append('key',key);

			$.ajax({

			  url:'<?= base_url("admincontrol/application_set/get_application_data_v2")?>',
			  method:'POST',
			  data:form_data,
			  dataType:'JSON',
			  processData:false,
			  contentType:false,
			  success: function(data){
				// console.log(data)
				
				if(data.msg == 1){
					$('.div_roller_total').fadeOut();
					let html = "";
					$('.search-results').css({
					  display : 'block'
					});
					$('.search-results').html('');
					/*if(data.length < 1){
					  html = '<h3>Application Not Found</h3>';
					  $('.search-results').append(html);
					}
          <div class="row"><h3 style="padding-left: 20px;"><span>Registration No : </span><span><b>'+data.resdata_set.f_application_no+'</b></span></h3></div>*/

					html = '<div style="box-shadow: 0px 0px 6px 1px lightgrey;padding: 10px;margin: 20px;"><div class="row"><h4 style="padding-left: 20px;"><span>Candidate Name : </span><span><b>'+data.resdata_set.f_full_name+' ('+data.resdata_set.f_application_no+')</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Applied For : </span><span><b>'+data.resdata_set.adv_no+'|'+data.resdata_set.rm_name+'</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Mobile : </span><span><b>'+data.resdata_set.f_mobile+'</b> | Email - <b>'+data.resdata_set.f_email+'</b></span></h4><h4 style="padding-left: 20px;"><span>Date : </span><span><b>'+data.resdata_set.shift_date+'</b> | Timing - <b>'+data.resdata_set.shift_start_time+' To '+data.resdata_set.shift_end_time+'</b></span></h4><h4 style="padding-left: 20px;"><span>Venue : </span><span><b>'+data.resdata_set.address_name+'</b></span></h4><h4 style="padding-left: 20px;"><span>Table No. : </span><span><b>'+data.resdata_set.invw_tableno+'</b></span></h4></div>';
          
          html = html + '<div class="row"><div class="col-sm-12"><br/><br/><strong>Attachments ---</strong><br/>';
          for(var ii=0;ii<data.intv_data.length;ii++){
            html = html + '<div>'+(ii + 1)+'. <a href="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.intv_data[ii].fattach_doc_source+'" target="_blank">'+data.intv_data[ii].fattach_doc_title+'</a></div>';
          }
          html = html + '</div></div>';
          html = html + '<div class="row"><div class="col-sm-6"><strong><br/><br/>Current Webcam Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.cr_interview_pic+'" style="max-width:350px;" /></div><div class="col-sm-6"><strong><br/><br/>Previous Application Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" /></div></div></div>';
          
          
					$('.search-results').append(html);
					
          $('#my_old_pic').html('<img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" />');

				}else{
					$('.div_roller_total').fadeOut();
          $('.search-results').fadeOut();
					//error_message = "There have some problem to Store Data, Try after some time.";
					error_message = data.e_msg;
					$('.get_error_total').html(error_message);
					$(".get_error_total").fadeIn();
					setTimeout(function() {
						$('.get_error_total').fadeOut();
					}, delay);
				}
				
			  }
			});
		}
    
  });

</script>

<?php $this->load->view('admin/component/footer') ?>
