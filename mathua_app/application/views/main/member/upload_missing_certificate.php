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
    <input type="hidden" name="refno" id="refno" value="<?php echo $fuser_detailset->f_application_no; ?>" />
    
      <!-- Picture -->
      <?php if($fuser_detailset->fu_photo_doc == NULL || $fuser_detailset->fu_photo_doc == ''){ ?>
      <label>Upload Candidate Picture: </label>
      <input type="file" class="form-control" name="pic_doc" id="pic_doc" />
      <small class="text-error pic_doc"><?php echo form_error('pic_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on();">Upload</button>
        
      <?php }else{ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate Picture :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_photo_doc; ?>" target="_blank">Attached Picture</a>
        </div>
      <?php } ?>

      <!-- Signature -->
      <?php if($fuser_detailset->fu_signature_doc == NULL || $fuser_detailset->fu_signature_doc == ''){ ?>
      <label>Upload Candidate Signature: </label>
      <input type="file" class="form-control" name="sign_doc" id="sign_doc" />
      <small class="text-error sign_doc"><?php echo form_error('sign_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total2" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total2" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total2" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on2();">Upload</button>
        
      <?php }else{ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate Signature :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_signature_doc; ?>" target="_blank">Attached Signature</a>
        </div>
      <?php } ?>

      <!-- Address -->
      <?php if($fuser_detailset->fu_address_doc == NULL || $fuser_detailset->fu_address_doc == ''){ ?>
      <label>Upload Candidate Address Proof: </label>
      <input type="file" class="form-control" name="address_doc" id="address_doc" />
      <small class="text-error address_doc"><?php echo form_error('address_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total3" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total3" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total3" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on3();">Upload</button>
        
      <?php }else{ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate Address Proof :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_address_doc; ?>" target="_blank">Attached Address Proof</a>
        </div>
      <?php } ?>

      <!-- DOB -->
      <?php if($fuser_detailset->fu_dob_doc == NULL || $fuser_detailset->fu_dob_doc == ''){ ?>
      <label>Upload Candidate DOB Proof: </label>
      <input type="file" class="form-control" name="dob_doc" id="dob_doc" />
      <small class="text-error dob_doc"><?php echo form_error('dob_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total4" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total4" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total4" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on4();">Upload</button>
        
      <?php }else{ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate DOB Proof :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_dob_doc; ?>" target="_blank">Attached DOB Proof</a>
        </div>
      <?php } ?>

      <!-- CASTE -->
      <?php if(($fuser_detailset->fu_caste_doc == NULL || $fuser_detailset->fu_caste_doc == '') && $fuser_detailset->fu_caste_type > 1){ ?>
      <label>Upload Candidate Caste Proof: </label>
      <input type="file" class="form-control" name="caste_doc" id="caste_doc" />
      <small class="text-error caste_doc"><?php echo form_error('caste_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total5" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total5" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total5" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on5();">Upload</button>
        
      <?php }else{ 
        if($fuser_detailset->fu_caste_type > 1){ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate Caste Proof :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_caste_doc; ?>" target="_blank">Attached Caste Proof</a>
        </div>
      <?php }
      } ?>

      <!-- PWD -->
      <?php if(($fuser_detailset->fu_pwd_doc == NULL || $fuser_detailset->fu_pwd_doc == '') && $fuser_detailset->fu_pwd == "Yes"){ ?>
      <label>Upload Candidate PWD Proof: </label>
      <input type="file" class="form-control" name="pwd_doc" id="pwd_doc" />
      <small class="text-error pwd_doc"><?php echo form_error('pwd_doc'); ?></small>
      <br/>
      <div align="center">
        <div class="get_error_total6" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total6" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total6" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <button type="button" class="btn btn-lg btn-primary submitbutton" onclick="goto_finalsubmit_on6();">Upload</button>
        
      <?php }else{ 
        if($fuser_detailset->fu_pwd == "Yes"){ ?>
        <div class="m-3" style="font-size:1.2em;">
        Candidate PWD Proof :- <a href="<?php echo base_url().$pathurl.$fuser_detailset->fu_pwd_doc; ?>" target="_blank">Attached PWD Proof</a>
        </div>
      <?php }
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
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
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

    if (document.getElementById("pic_doc").files.length == 0) {
			e_error = 1;
			$('.pic_doc').html('Candidate Picture is Required.');
		} else {
			var fileInput = document.getElementById('pic_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.pic_doc').html('Picture type Invalid.(Use JPG)');
			} else {
				$('.pic_doc').html('');
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
        var conf_answer = confirm("Warning! You are going to Upload Picture! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'PIC');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.get_success_total').html('Picture is Uploaded Successfully.');
                $(".get_success_total").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

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

function goto_finalsubmit_on2(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total2').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#sign_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("sign_doc").files.length == 0) {
			e_error = 1;
			$('.sign_doc').html('Candidate Signature is Required.');
		} else {
			var fileInput = document.getElementById('sign_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.sign_doc').html('Signature type Invalid.(Use JPG)');
			} else {
				$('.sign_doc').html('');
			}
		}

    if (e_error == 1) {

      $('.div_roller_total2').fadeOut();
      if(error_message != ''){
        $('.get_error_total2').html(error_message);
        $(".get_error_total2").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total2').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload Signature! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'SIGN');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.div_roller_total2').fadeOut();
                $('.get_success_total2').html('Signature is Uploaded Successfully.');
                $(".get_success_total2").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total2').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

              } else {

                $('.div_roller_total2').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total2').html(error_message);
                $(".get_error_total2").fadeIn();
                setTimeout(function() {
                  $('.get_error_total2').fadeOut();
                }, 5000);

              }



            }

          });

        } else {
          $('.div_roller_total2').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on3(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total3').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#address_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("address_doc").files.length == 0) {
			e_error = 1;
			$('.address_doc').html('Candidate Address is Required.');
		} else {
			var fileInput = document.getElementById('address_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.address_doc').html('Address type Invalid.(Use PDF/JPG)');
			} else {
				$('.address_doc').html('');
			}
		}

    if (e_error == 1) {

      $('.div_roller_total3').fadeOut();
      if(error_message != ''){
        $('.get_error_total3').html(error_message);
        $(".get_error_total3").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total3').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload Address! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'ADDRESS');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.div_roller_total3').fadeOut();
                $('.get_success_total3').html('Address Doc is Uploaded Successfully.');
                $(".get_success_total3").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total3').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

              } else {

                $('.div_roller_total3').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total3').html(error_message);
                $(".get_error_total3").fadeIn();
                setTimeout(function() {
                  $('.get_error_total3').fadeOut();
                }, 5000);

              }



            }

          });

        } else {
          $('.div_roller_total3').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on4(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total4').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#dob_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("dob_doc").files.length == 0) {
			e_error = 1;
			$('.dob_doc').html('Candidate DOB is Required.');
		} else {
			var fileInput = document.getElementById('dob_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.dob_doc').html('DOB type Invalid.(Use PDF/JPG)');
			} else {
				$('.dob_doc').html('');
			}
		}

    if (e_error == 1) {

      $('.div_roller_total4').fadeOut();
      if(error_message != ''){
        $('.get_error_total4').html(error_message);
        $(".get_error_total4").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total4').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload DOB! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'DOB');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.div_roller_total4').fadeOut();
                $('.get_success_total4').html('DOB Doc is Uploaded Successfully.');
                $(".get_success_total4").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total4').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

              } else {

                $('.div_roller_total4').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total4').html(error_message);
                $(".get_error_total4").fadeIn();
                setTimeout(function() {
                  $('.get_error_total4').fadeOut();
                }, 5000);

              }



            }

          });

        } else {
          $('.div_roller_total4').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on5(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total5').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#caste_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("caste_doc").files.length == 0) {
			e_error = 1;
			$('.caste_doc').html('Candidate Caste is Required.');
		} else {
			var fileInput = document.getElementById('caste_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.caste_doc').html('Caste type Invalid.(Use PDF/JPG)');
			} else {
				$('.caste_doc').html('');
			}
		}

    if (e_error == 1) {

      $('.div_roller_total5').fadeOut();
      if(error_message != ''){
        $('.get_error_total5').html(error_message);
        $(".get_error_total5").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total5').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload Caste! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'CASTE');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.div_roller_total5').fadeOut();
                $('.get_success_total5').html('Caste Doc is Uploaded Successfully.');
                $(".get_success_total5").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total5').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

              } else {

                $('.div_roller_total5').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total5').html(error_message);
                $(".get_error_total5").fadeIn();
                setTimeout(function() {
                  $('.get_error_total5').fadeOut();
                }, 5000);

              }



            }

          });

        } else {
          $('.div_roller_total5').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on6(){
    //alert('Working to Process for Payment Clearence');
    //exit;
    var allowedExtensions = /(\.pdf|\.PDF|\.jpg|\.jpeg|\.png|\.JPG|\.JPEG|\.PNG)$/i;
    $('.submitbutton').prop('disabled', true);
    $('.div_roller_total6').fadeIn();
    var e_error = 0;
    var error_message = '';
    //alert(salts);
    var refno = $('#refno').val();
    var files = $('#pwd_doc')[0].files;

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }

    if (document.getElementById("pwd_doc").files.length == 0) {
			e_error = 1;
			$('.pwd_doc').html('Candidate PWD is Required.');
		} else {
			var fileInput = document.getElementById('pwd_doc');
			var filePath = fileInput.value;
			if (!allowedExtensions.exec(filePath)) {
				e_error = 1;
				$('.pwd_doc').html('PWD type Invalid.(Use PDF/JPG)');
			} else {
				$('.pwd_doc').html('');
			}
		}

    if (e_error == 1) {

      $('.div_roller_total6').fadeOut();
      if(error_message != ''){
        $('.get_error_total6').html(error_message);
        $(".get_error_total6").fadeIn();
      }
      $(".text-error").fadeIn();
      $('.submitbutton').prop('disabled', false);
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total6').fadeOut();
      }, 5000);

    } else {
        var conf_answer = confirm("Warning! You are going to Upload PWD! Are you sure?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          form_data.append("files", files[0]);
          form_data.append('docutype', 'PWD');
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/all_attachments_processing"; ?>',
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
                $('.div_roller_total6').fadeOut();
                $('.get_success_total6').html('PWD Doc is Uploaded Successfully.');
                $(".get_success_total6").fadeIn();
                $('input').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total6').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/upload_all_certificates_set') ?>");
                }, 1000);

              } else {

                $('.div_roller_total6').fadeOut();
                $('.submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total6').html(error_message);
                $(".get_error_total6").fadeIn();
                setTimeout(function() {
                  $('.get_error_total6').fadeOut();
                }, 5000);

              }



            }

          });

        } else {
          $('.div_roller_total6').fadeOut();
          $('.submitbutton').prop('disabled', false);
        }

      }
}

</script>