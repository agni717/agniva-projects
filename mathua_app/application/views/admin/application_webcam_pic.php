<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script src="<?php echo base_url(); ?>js/webcam.js"></script>

<div class="content-wrapper">
    <section class="content-header">
	  <h1>
			Interview Candidate Registration
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Interview Candidate Registration</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
    <div class="row"><h4 style="padding-left: 20px;"><span>Candidate Name : </span><span><b><?php echo $canddata->f_full_name; ?></b></span></h4></div>
    <div class="row"><h4 style="padding-left: 20px;"><span>Applied For : </span><span><b><?php echo $canddata->adv_no; ?> | <?php echo $canddata->rm_name; ?></b></span></h4></div>
    <div class="row"><h4 style="padding-left: 20px;"><span>Mobile : </span><span><b><?php echo $canddata->f_mobile; ?></b> | Email - <b><?php echo $canddata->f_email; ?></b></span></h4><h4 style="padding-left: 20px;"><span>Date : </span><span><b><?php echo $canddata->shift_date; ?></b> | Timing - <b><?php echo $canddata->shift_start_time; ?> To <?php echo $canddata->shift_end_time; ?></b></span></h4><h4 style="padding-left: 20px;"><span>Venue : </span><span><b><?php echo $canddata->address_name; ?></b></span></h4></div>

    <div class="row"><div class="col-sm-12"><br/><br/><strong>Attachments ---</strong><br/>
    <div><a href="<?php echo base_url('upload_file/'.$canddata->f_applied_for.'/candidates/'.$canddata->f_application_no.'/'.$intvw_data[0]->fattach_doc_source); ?>" target="_blank"><?php echo $intvw_data[0]->fattach_doc_title; ?></a></div>
    </div>
    </div>

    <div><br/><br/><button class="btn btn-primary btn-upload-pic" data-id="<?php echo $canddata->cr_id; ?>" application-id="<?php echo $canddata->f_application_no; ?>">Collect Webcam Image</button></div>
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

  <section>
    <div class="row">
      <div class="col-md-12 bg-success text-light e-msg" style="display:none;padding:10px;margin:10px;"></div>
      <div class="col-md-12 bg-success text-light e-msg-err" style="display:none;padding:10px;margin:10px;"></div>
    </div>
    </div>
    <div class="card upload-pic-block" style="height:auto;width:900px;position:fixed;left:50%;top:80px;transform:translate(-50%,0);padding:10px;display:none;justify-content:center;z-index: 20;background-color: white;box-shadow: 0px 0px 6px 1px lightgrey;">
      
      <span class="text-light bg-dark btn-close-upload-pic-block" style="cursor: pointer;position: fixed;top: -25px;right:-15px;padding: 5px;font-size: 25px;"><i class="fa fa-times"></i></span>
      
      <div id="my_camera_outer" class="col-sm-6" style="display:flex;justify-content:left;">
        <div id="my_camera" style="border: 1px solid lightgrey;"></div>
        
      </div>
      <div class="col-sm-6" style="display:flex;justify-content:left;">
        <div id="my_old_pic" style="border: 1px solid lightgrey;"><img src="<?php echo base_url('upload_file/'.$canddata->f_applied_for.'/candidates/'.$canddata->f_application_no.'/'.$canddata->fu_photo_doc); ?>" style="max-width:250px;" /></div>
      </div>
      
      <div class="col-sm-12 btn-take-snapshot" style="display:flex;justify-content:center;">
        <input class="btn btn-success" type=button value="Take Snapshot" onClick="take_snapshot()" style="margin:10px;">
      </div>
      
      <div  class="col-sm-6" id="results" style="display:flex;justify-content:left;"></div> 
      
      <div class="col-sm-12" style="display:flex;justify-content:center;">
        <input class="btn btn-primary btn-save-snapshot" type=button value="Save Snapshot" style="display:none;margin:10px;" onClick="saveSnap()">     
        <input class="btn btn-warning btn-retake-snapshot" type=button value="Retake Snapshot" style="display:none;margin:10px;">    

				<input class="btn btn-danger btn-cancel-snapshot" type=button value="Cancel Application" style="display:none;margin:10px;" onClick="cancelSnap()">    
      </div>
      <div class="col-sm-12">
        <div align="center">
          <div class="get_error_total2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
          <div class="get_success_total2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
          <div class="div_roller_total2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
        </div>
      </div>
    
    </div>
  </section>

</div>


<script type="text/javascript">

  var applicationId = "";
	$(function() {
	  $("#search_reg_no").focus();
	});

  $('input[name="search_reg_no"]').on('change',function(event){
    //$('.btn-search').on('click',function(event){
    
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

			  url:'<?= base_url("admincontrol/application_set/get_application_data")?>',
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

          html = '<div style="box-shadow: 0px 0px 6px 1px lightgrey;padding: 10px;margin: 20px;"><div class="row"><h4 style="padding-left: 20px;"><span>Candidate Name : </span><span><b>'+data.resdata_set.f_full_name+'</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Applied For : </span><span><b>'+data.resdata_set.adv_no+'|'+data.resdata_set.rm_name+'</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Mobile : </span><span><b>'+data.resdata_set.f_mobile+'</b> | Email - <b>'+data.resdata_set.f_email+'</b></span></h4><h4 style="padding-left: 20px;"><span>Date : </span><span><b>'+data.resdata_set.shift_date+'</b> | Timing - <b>'+data.resdata_set.shift_start_time+' To '+data.resdata_set.shift_end_time+'</b></span></h4><h4 style="padding-left: 20px;"><span>Venue : </span><span><b>'+data.resdata_set.address_name+'</b></span></h4></div>';
          
          if(parseInt(data.intv_data.length) > 0){
              html = html + '<div class="row"><div class="col-sm-12"><br/><br/><strong>Attachments ---</strong><br/>';
              for(var ii=0;ii<data.intv_data.length;ii++){
                html = html + '<div>'+(ii + 1)+'. <a href="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.intv_data[ii].fattach_doc_source+'" target="_blank">'+data.intv_data[ii].fattach_doc_title+'</a></div>';
              }
              html = html + '</div></div>';
              if(!data.resdata_set.cr_interview_pic){
                html = html + '<div><br/><br/><button class="btn btn-primary btn-upload-pic" data-id="'+data.resdata_set.cr_id+'" application-id="'+data.resdata_set.f_application_no+'">Collect Webcam Image</button></div></div>';
              }else{
                html = html + '<div class="row"><div class="col-sm-6"><strong><br/><br/>Current Webcam Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.cr_interview_pic+'" style="max-width:350px;" /></div><div class="col-sm-6"><strong><br/><br/>Previous Application Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" /></div></div><div class="row"><div class="col-sm-12 text-center"><a href="<?php echo base_url(); ?>admincontrol/application_set/printwatermark_withinterview_callletter/'+data.resdata_set.f_application_no+'" class="btn btn-lg btn-primary" target="_blank">Print</a></div></div></div>';
              }
          }else{
            html = html + '<div><a class="btn btn-primary" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a></div></div>';
          }


          /*if(!data.resdata_set.cr_interview_pic){
            html = html + '<div><button class="btn btn-primary btn-upload-pic" data-id="'+data.resdata_set.cr_id+'" application-id="'+data.resdata_set.f_application_no+'">Upload Image</button><a class="btn btn-primary" target="_blank" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a></div></div>';
          }else{
            html = html + '<div class="row"><div class="col-sm-6"><strong><br/><br/>Current Webcam Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.cr_interview_pic+'" style="max-width:350px;" /></div><div class="col-sm-6"><strong><br/><br/>Previous Application Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" /></div></div><div class="row"><div class="col-sm-12">';
            if(parseInt(data.intv_data.length) > 0){
              html = html + '<br/><br/><strong>Attachments ---</strong><br/>';
              for(var ii=0;ii<data.intv_data.length;ii++){
                html = html + '<div>'+(ii + 1)+'. <a href="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.intv_data[ii].fattach_doc_source+'" target="_blank">'+data.intv_data[ii].fattach_doc_title+'</a></div>';
              }
            }else{
              html = html + '<br/><br/><a class="btn btn-primary" target="_blank" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a>';
            }
            
            html = html + '</div></div></div>';
          }*/
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

			  url:'<?= base_url("admincontrol/application_set/get_application_data")?>',
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

					html = '<div style="box-shadow: 0px 0px 6px 1px lightgrey;padding: 10px;margin: 20px;"><div class="row"><h4 style="padding-left: 20px;"><span>Candidate Name : </span><span><b>'+data.resdata_set.f_full_name+'</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Applied For : </span><span><b>'+data.resdata_set.adv_no+'|'+data.resdata_set.rm_name+'</b></span></h4></div><div class="row"><h4 style="padding-left: 20px;"><span>Mobile : </span><span><b>'+data.resdata_set.f_mobile+'</b> | Email - <b>'+data.resdata_set.f_email+'</b></span></h4><h4 style="padding-left: 20px;"><span>Date : </span><span><b>'+data.resdata_set.shift_date+'</b> | Timing - <b>'+data.resdata_set.shift_start_time+' To '+data.resdata_set.shift_end_time+'</b></span></h4><h4 style="padding-left: 20px;"><span>Venue : </span><span><b>'+data.resdata_set.address_name+'</b></span></h4></div>';
          
          if(parseInt(data.intv_data.length) > 0){
              html = html + '<div class="row"><div class="col-sm-12"><br/><br/><strong>Attachments ---</strong><br/>';
              for(var ii=0;ii<data.intv_data.length;ii++){
                html = html + '<div>'+(ii + 1)+'. <a href="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.intv_data[ii].fattach_doc_source+'" target="_blank">'+data.intv_data[ii].fattach_doc_title+'</a></div>';
              }
              html = html + '</div></div>';
              if(!data.resdata_set.cr_interview_pic){
                html = html + '<div><br/><br/><button class="btn btn-primary btn-upload-pic" data-id="'+data.resdata_set.cr_id+'" application-id="'+data.resdata_set.f_application_no+'">Collect Webcam Image</button></div></div>';
              }else{
                html = html + '<div class="row"><div class="col-sm-6"><strong><br/><br/>Current Webcam Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.cr_interview_pic+'" style="max-width:350px;" /></div><div class="col-sm-6"><strong><br/><br/>Previous Application Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" /></div></div><div class="row"><div class="col-sm-12 text-center"><a href="<?php echo base_url(); ?>admincontrol/application_set/printwatermark_withinterview_callletter/'+data.resdata_set.f_application_no+'" class="btn btn-lg btn-primary" target="_blank">Print</a></div></div></div>';
              }
          }else{
            html = html + '<div><a class="btn btn-primary" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a></div></div>';
          }


          /*if(!data.resdata_set.cr_interview_pic){
            html = html + '<div><button class="btn btn-primary btn-upload-pic" data-id="'+data.resdata_set.cr_id+'" application-id="'+data.resdata_set.f_application_no+'">Upload Image</button><a class="btn btn-primary" target="_blank" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a></div></div>';
          }else{
            html = html + '<div class="row"><div class="col-sm-6"><strong><br/><br/>Current Webcam Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.cr_interview_pic+'" style="max-width:350px;" /></div><div class="col-sm-6"><strong><br/><br/>Previous Application Upload ---</strong><br/><img src="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.resdata_set.fu_photo_doc+'" style="max-width:250px;" /></div></div><div class="row"><div class="col-sm-12">';
            if(parseInt(data.intv_data.length) > 0){
              html = html + '<br/><br/><strong>Attachments ---</strong><br/>';
              for(var ii=0;ii<data.intv_data.length;ii++){
                html = html + '<div>'+(ii + 1)+'. <a href="<?php echo base_url(); ?>upload_file/'+data.resdata_set.f_applied_for+'/candidates/'+data.resdata_set.f_application_no+'/'+data.intv_data[ii].fattach_doc_source+'" target="_blank">'+data.intv_data[ii].fattach_doc_title+'</a></div>';
              }
            }else{
              html = html + '<br/><br/><a class="btn btn-primary" target="_blank" href="<?php echo base_url("admincontrol/application_set/add_document/")?>'+data.resdata_set.f_application_no+'">Upload Document</a>';
            }
            
            html = html + '</div></div></div>';
          }*/
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

  /*Webcam.on( 'error', function(){
    alert('Web Cam not found! Check your Camera Connection.');
  });

  Webcam.on( 'load', function() {
    
  });*/

  $(document).on('click','.btn-upload-pic',function(event){
    applicationId = event.currentTarget.attributes['application-id'].value;
    //alert(applicationId);
    $('.upload-pic-block').css({
      display:'block'
    });

    $('#my_camera,.btn-take-snapshot, #my_camera_outer').css({
      display:'flex'
    });

    $('#results').html('');
    $('.btn-save-snapshot, .btn-retake-snapshot, .btn-cancel-snapshot').css({
      display:'none'
    });

    Webcam.set({
      width: 415,
      height: 310,
      image_format: 'jpg',
      jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );
    //Webcam.attach( '#webcam' );
  });

  $('.btn-close-upload-pic-block').on('click',function(event){
    //alert('hi');
    $('.upload-pic-block').fadeOut();
    Webcam.reset();
    $('#my_camera,.btn-take-snapshot').css({
      display:'none'
    });
  });
 

  // A button for taking snaps
  // preload shutter audio clip
  
  /*var shutter = new Audio();
  shutter.autoplay = false;
  shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';*/
 
  function take_snapshot() {
  
    // take snapshot and get image data
    Webcam.snap(function(data_uri){
    // display results in page
    document.getElementById('results').innerHTML = 
    '<img id="imageprev" style="max-width:415px;" src="'+data_uri+'"/>';
    });
    
    Webcam.reset();

    $('#my_camera,.btn-take-snapshot, #my_camera_outer').css({
      display:'none'
    });

    $('.btn-save-snapshot,.btn-retake-snapshot,.btn-cancel-snapshot').css({
      display:'block'
    });
    
  }

  $('.btn-retake-snapshot').on('click',function(event){
  
    $('#my_camera,.btn-take-snapshot, #my_camera_outer').css({
      display:'block'
    });

    Webcam.set({
      width: 415,
      height: 310,
      image_format: 'jpg',
      jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );

    $('#results').html('');
    $('.btn-save-snapshot,.btn-retake-snapshot,.btn-cancel-snapshot').css({
      display:'none'
    });

  });
	
  function saveSnap(){
    $('.div_roller_total2').fadeIn();
    var delay = 5000;
		var e_error = 0;
		var error_message = '';
    // Get base64 value from <img id='imageprev'> source
    var base64image = document.getElementById("imageprev").src;
    if(base64image == ""){
			e_error = 1;
			error_message = "Image not Click Properly, Take it Again.";
		}

		if (e_error == 1) {
			$('.div_roller_total2').fadeOut();
      $('.get_error_total2').html(error_message);
			$(".get_error_total2").fadeIn();
			setTimeout(function() {
				$('.get_error_total2').fadeOut();
			}, delay);
		} else {
      
      var form_data = new FormData();

      form_data.append('base64image',base64image);
      form_data.append('application_id',applicationId);

      $.ajax({
        url: "<?php echo base_url('admincontrol/interview/uploadwebcam_shot') ?>",
        method: "POST",
        data: form_data,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success:function(data){
          //console.log(data)
          if(data.msg == 1){
            $('.div_roller_total2').fadeOut();
            /*$('.upload-pic-block').css({
                display:'none'
            });*/
            $('.get_success_total2').html(data.e_msg);
            $('.get_success_total2').fadeIn();
            setTimeout(function() {
              $('.get_error_total2').fadeOut();
            }, delay);
            window.open('<?php echo base_url('admincontrol/application_set/printwatermark_withinterview_callletter/'); ?>'+applicationId,'newwindow',
             config='height=700,width=1000,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no');
            setTimeout(function(){ window.location.replace("<?php echo base_url('admincontrol/application_set')?>"); }, 1000);
          }else{
            $('.div_roller_total2').fadeOut();
            error_message = data.e_msg;
            $('.get_error_total2').html(error_message);
            $(".get_error_total2").fadeIn();
            setTimeout(function() {
              $('.get_error_total2').fadeOut();
            }, delay);
          }
        }
      });

    }
  }

	function cancelSnap(){
    $('.div_roller_total2').fadeIn();
    var delay = 5000;
		var e_error = 0;
		var error_message = '';
    // Get base64 value from <img id='imageprev'> source
    var base64image = document.getElementById("imageprev").src;
    if(base64image == ""){
			e_error = 1;
			error_message = "Image not Click Properly, Take it Again.";
		}

		if (e_error == 1) {
			$('.div_roller_total2').fadeOut();
      $('.get_error_total2').html(error_message);
			$(".get_error_total2").fadeIn();
			setTimeout(function() {
				$('.get_error_total2').fadeOut();
			}, delay);
		} else {
      
      var form_data = new FormData();

      form_data.append('base64image',base64image);
      form_data.append('application_id',applicationId);

      $.ajax({
        url: "<?php echo base_url('admincontrol/interview/uploadwebcam_with_cancelapplication_shot') ?>",
        method: "POST",
        data: form_data,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success:function(data){
          //console.log(data)
          if(data.msg == 1){
            $('.div_roller_total2').fadeOut();
            /*$('.upload-pic-block').css({
                display:'none'
            });*/
            $('.get_success_total2').html(data.e_msg);
            $('.get_success_total2').fadeIn();
            setTimeout(function() {
              $('.get_error_total2').fadeOut();
            }, delay);
            setTimeout(function(){ window.location.replace("<?php echo base_url('admincontrol/application_set')?>"); }, 3000);
          }else{
            $('.div_roller_total2').fadeOut();
            error_message = data.e_msg;
            $('.get_error_total2').html(error_message);
            $(".get_error_total2").fadeIn();
            setTimeout(function() {
              $('.get_error_total2').fadeOut();
            }, delay);
          }
        }
      });

    }
  }

</script>

<?php $this->load->view('admin/component/footer') ?>
