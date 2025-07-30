<?php $this->load->view('main/component/login_header') ?>
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
      
    <?php if($adv_detail->adv_reg_certificate == "Yes"){
        if(strtotime($adv_detail->adv_end_time) > strtotime(date('Y-m-d H:i:s'))){
        if($fuser_detailset->fu_ext_council_reg_certificate == NULL || $fuser_detailset->fu_ext_council_reg_certificate == ''){ ?>
        <?php echo form_open_multipart(''); ?>
      <label>Upload Registration Certificate: </label>
      <input type="hidden" name="refno" id="refno" value="<?php echo $fuser_detailset->f_application_no; ?>" />
      <input type="file" class="form-control" name="reg_doc" id="reg_doc" />
      <small class="text-error reg_doc"><?php echo form_error('reg_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on();">Upload Document</button>
      <?php echo form_close(); ?>
        
      <?php }else{
        $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>
        <div class="mt-5" style="font-size:1.2em;">
          Registration Certificate :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_ext_council_reg_certificate; ?>" target="_blank">Attached Document</a>
        </div>
      <?php }
        }else{
          if($fuser_detailset->fu_ext_council_reg_certificate == NULL || $fuser_detailset->fu_ext_council_reg_certificate == ''){ ?>
            <div class="mt-5" style="font-size:1.2em;">
              Registration Certificate :- Not Uploaded
            </div>
          <?php }else{ 
            $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>
            <div class="mt-5" style="font-size:1.2em;">
              Registration Certificate :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_ext_council_reg_certificate; ?>" target="_blank">Attached Document</a>
            </div>
          <?php }
        }


    } ?>
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
    var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#reg_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("reg_doc").files.length == 0) {
			e_error = 1;
			$('.reg_doc').html('Registration Certificate is Required.');
		} else {
			var fileInput = document.getElementById('reg_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.reg_doc').html('Registration Certificate type Invalid.(Use PDF/JPG)');
			} else {
				$('.reg_doc').html('');
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
        var conf_answer = confirm("Warning! You are going to Upload Registration Certificate! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/reg_certificate_processing"; ?>',
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
                $('.get_success_total').html('Registration Certificate Upload done Successfully. Thank You.');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/uploadregistration_certificate_set') ?>");
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