<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WB - Health Recruitment Board</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url("images/favicon.ico") ?>" type="image/x-icon" />
        
        <link href="https://fonts.googleapis.com/css?family=Playball&display=swap" rel="stylesheet">
		<!-- Bootstrap CSS File -->
		<link href="<?php echo base_url(); ?>frontend/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>frontend/css/style.css" rel="stylesheet" type="text/css" />
		<!-- Libraries CSS Files -->
		<link href="<?php echo base_url(); ?>frontend/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>frontend/css/jquery-steps.css">
</head>

<body>
	<div class="header">

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<img src="<?php echo base_url(); ?>frontend/img/WBHRB_Logo.png">
				</div>
        <div class="col-sm-9 text-left mt-3" style="font-size: 35px;color: #fff;font-weight: bold;word-spacing: 5px;">
				  WEST BENGAL HEALTH RECRUITMENT BOARD
        </div>
			</div>
		</div>
	</div>

<style>
	.alert-error,
	.text-error,
	.redclass {

		color: red !important;

	}

</style>
<?php $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>


<div class="container mt-3 container_area">
  <div class="text-center"><h3>Registration No. - <?php echo $fuser_detailset->f_application_no; ?></h3>
  </div>


<div class="mt-3 mb-5 text-center">
    <input type="hidden" name="refno" id="refno" value="<?php echo $maildata[5]; ?>" />
    
      <!-- Picture -->
      <label>Upload Candidate <strong><?php 
      if($maildata[3] == 'CO'){
        echo $commonname_arr[$maildata[4]];
      }elseif($maildata[3] == 'EQ'){
        echo $docu_details->qm_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'DQ'){
        echo $docu_details->qm_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'ES'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'DS'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'EA'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }
      ?></strong>: </label>
      <input type="file" class="form-control" name="pic_doc" id="pic_doc" />
      <small class="text-error pic_doc"><?php echo form_error('pic_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on();">Upload</button>
        
      

      <!-- Address -->
      <!--<div class="m-3" style="font-size:1.2em;">
      Candidate Address Proof :- <a href="<?php //echo base_url().$pathurl.$fuser_detailset->fu_address_doc; ?>" target="_blank">Attached Address Proof</a>
      </div>-->
      

      

</div> 
</div>
<?php $this->load->view('main/component/footer'); ?>

<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
		$('.alert-error, .text-error').delay(8000).fadeOut();
		//$('[data-toggle="tooltip"]').tooltip();
	});
</script>



<script type="text/javascript">

function goto_finalsubmit_on(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    var allowedExtensions2 = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#pic_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    <?php if($maildata[3] == 'CO' && ($maildata[4] == 1 || $maildata[4] == 1)){ ?>
    if (document.getElementById("pic_doc").files.length == 0) {
			e_error = 1;
			$('.pic_doc').html('Candidate File is Required.');
		} else {
			var fileInput = document.getElementById('pic_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.pic_doc').html('File type Invalid.(Use JPG)');
			} else {
				$('.pic_doc').html('');
			}
		}
    <?php }else{ ?>
    if (document.getElementById("pic_doc").files.length == 0) {
			e_error = 1;
			$('.pic_doc').html('Candidate File is Required.');
		} else {
			var fileInput = document.getElementById('pic_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions2.exec(filePath)) {
				e_error = 1;
				$('.pic_doc').html('File type Invalid.(Use PDF/IMAGE)');
			} else {
				$('.pic_doc').html('');
			}
		}
    <?php } ?>

    if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      if(error_message != ''){
        $('.get_error_total').html(error_message);
        $(".get_error_total").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload File! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "documentupload/specificdocument_modification_uploadbycandidate"; ?>',
            data: form_data,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
              //alert(data.msg);
              if (data.msg == 1)
              {
                //console.log(data);
                //alert(data.msg[0].space_rate);
                $('.div_roller_total').fadeOut();
                $('.get_success_total').html('Document is Uploaded Successfully. Thank You.');
                $(".get_success_total").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('login') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total').html(error_message);
                $(".get_error_total").fadeIn();
                setTimeout(function() {
                  $('.get_error_total').fadeOut();
                }, 5000);

              }

            }

          });

        } else {
          $('.div_roller_total').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

</script>