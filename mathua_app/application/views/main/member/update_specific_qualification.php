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
<?php //$pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>


<div class="container mt-3 container_area">
  <div class="text-center"><h3>Registration No. - <?php echo $fuser_detailset->f_application_no; ?></h3>
  </div>


<div class="mt-3 mb-5 text-center">
    <input type="hidden" name="refno" id="refno" value="<?php echo $maildata[5]; ?>" />
    
      <!-- Picture -->
      <label>Candidate Update - <strong><?php 
      /*if($maildata[3] == 'CO'){
        echo $commonname_arr[$maildata[4]];
      }else*/
      if($maildata[3] == 'EQ'){
        echo $docu_details->qm_name.' Marks';
        $fmarks = $docu_details->fu_full_marks;
        $obmarks = $docu_details->fu_marks_obtained;
        $permarks = $docu_details->fu_percent_of_marks;
      }elseif($getstring_arr[3] == 'DQ'){
        echo $docu_details->qm_name.' Marks';
        $fmarks = $docu_details->fud_full_marks;
        $obmarks = $docu_details->fud_marks_obtained;
        $permarks = $docu_details->fud_percent_of_marks;
      }
      /*elseif($getstring_arr[3] == 'ES'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'DS'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }elseif($getstring_arr[3] == 'EA'){
        echo $docu_details->expset_name.' Marksheet/ Centificate';
      }*/
      ?></strong>: </label>
      <div class="row mt-3 pt-2 table table-bordered">
        <div class="col-sm-4 text-left">
        <label>Given Full Marks : <strong><?php echo $fmarks; ?></strong></label>
        </div>
        <div class="col-sm-4 text-left">
        <label>Given Obtained Marks : <strong><?php echo $obmarks; ?></strong></label>
        </div>
        <div class="col-sm-4 text-left">
        <label>Given Percentage Marks : <strong><?php echo $permarks; ?></strong></label>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4 text-left">
        <label>New Full Marks</label>
        <input type="text" class="form-control" name="marks_full" id="marks_full" placeholder="Enter Full Marks" autocomplete="off" />
        <small class="text-error marks_full"><?php echo form_error('marks_full'); ?></small>
        </div>
        <div class="col-sm-4 text-left">
        <label>New Obtained Marks</label>
        <input type="text" class="form-control" name="marks_obtained" id="marks_obtained" placeholder="Enter Obtained Marks" autocomplete="off" />
        <small class="text-error marks_obtained"><?php echo form_error('marks_obtained'); ?></small>
        </div>
        <div class="col-sm-4 text-left">
        <label>New Percentage Marks</label>
        <input type="text" class="form-control" name="marks_percent" id="marks_percent" placeholder="Percentage Marks" readonly />
        <small class="text-error marks_percent"><?php echo form_error('marks_percent'); ?></small>
        </div>
      </div>
      <br/>
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on();">Update</button>
        
      

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
    //var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    //var allowedExtensions2 = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    var onlynumerics = /^[0-9]+$/;
    var onlynumerics_withdot = /^[0-9.]+$/;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var marks_full = $('#marks_full').val();
    var marks_obtained = $('#marks_obtained').val();
    var marks_percent = $('#marks_percent').val();
    //var files = $('#pic_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if(marks_obtained == ""){
					e_error = 1;
					$('.marks_obtained').html('Marks Obtained is Required');
				}else{
					if (!marks_obtained.match(onlynumerics)) {
						e_error = 1;
						$('.marks_obtained').html('Marks Obtained use only Numeric Value');
					}else if(parseInt(marks_obtained) <= 0){
						e_error = 1;
						$('.marks_obtained').html('Marks Obtained always greater than 0');
					}else{
						$('.marks_obtained').html('');
					}
				}
				if(marks_full == ""){
					e_error = 1;
					$('.marks_full').html('Full Marks is Required');
				}else{
					if (!marks_full.match(onlynumerics)) {
						e_error = 1;
						$('.marks_full').html('Full Marks use only Numeric Value');
					}else if(parseInt(marks_full) <= 0){
						e_error = 1;
						$('.marks_full').html('Full Marks always greater than 0');
					}else{
						$('.marks_full').html('');
					}
				}
				if(marks_percent == ""){
					e_error = 1;
					$('.marks_percent').html('Percentage Marks is Required');
				}else{
					if (!marks_percent.match(onlynumerics_withdot)) {
						e_error = 1;
						$('.marks_percent').html('Percentage Marks use only Numeric Value');
					}else if(parseFloat(marks_percent) <= 0){
						e_error = 1;
						$('.marks_percent').html('Percentage Marks always greater than 0');
					}else{
						$('.marks_percent').html('');
					}
				}

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
        var conf_answer = confirm("Warning! You are going to Update Qualification Marks! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append('marks_obtained', marks_obtained);
          form_data.append('marks_full', marks_full);
          form_data.append('marks_percent', marks_percent);
          //form_data.append("files", files[0]);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "documentupload/specificqualification_modification_updatebycandidate"; ?>',
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
                $('.get_success_total').html('Qualification is Updated Successfully. Thank You.');
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

  $('input[name="marks_obtained"]').on('input', function(event) {

    let full_marks = $('input[name="marks_full"').val();
    let obtained_marks = $('input[name="marks_obtained"]').val();


    if ((full_marks != "" && obtained_marks != "")) {

      if (obtained_marks != NaN && full_marks != NaN) {

        if (parseInt(full_marks) < parseInt(obtained_marks)) {
          // show error
          $('.text-error').fadeIn();
          $('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
          $('input[name="marks_percent"').val('');
          return;
        } else {
          $('.marks_obtained').html('');
        }
        var percentchk = ((parseInt(obtained_marks) / parseInt(full_marks)) * 100);
        var percent_update = percentchk.toFixed(2);
        $('input[name="marks_percent"').val(percent_update);
      }
    } else {
      $('input[name="marks_percent"').val('');
    }
  });

  $('input[name="marks_full"]').on('input', function(event) {

    let full_marks = $('input[name="marks_full"').val();
    let obtained_marks = $('input[name="marks_obtained"]').val();


    if ((full_marks != "" && obtained_marks != "")) {

      if (obtained_marks != NaN && full_marks != NaN) {

        if (parseInt(full_marks) < parseInt(obtained_marks)) {
          // show error
          $('.text-error').fadeIn();
          $('.marks_obtained').html('Marks obtained should be less than or eual to full marks');
          $('input[name="marks_percent"').val('');
          return;
        } else {
          $('.marks_obtained').html('');
        }
        var percentchk = ((parseInt(obtained_marks) / parseInt(full_marks)) * 100);
        var percent_update = percentchk.toFixed(2);
        $('input[name="marks_percent"').val(percent_update);
      }
    } else {
      $('input[name="marks_percent"').val('');
    }
  });
</script>