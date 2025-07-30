<?php $this->load->view('main/component/login_header') ?>
<style>
/*.container_area {
    min-height: 1600px;
}*/

</style>
<?php $pathurl = 'upload_file/'. $fuser_detailset->f_applied_for .'/candidates/' . $fuser_detailset->f_application_no . '/'; ?>

<div class="container mt-3 container_area">
  <div class="text-center"><h3>Registration No. - <?php echo $fuser_detailset->f_application_no; ?></h3>
  <p style="font-size:30px;">Total Payable Amount is <?php echo $fuser_detailset->fu_pay_amount; ?></p>
  
  </div>


<div class="mt-3 mb-5 text-center">
      <div align="center">
        <div class="get_error_total" align="center" style="background-color: #bf0000;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="get_success_total" align="center" style="background-color: #174b10;color: #fff;max-width: 500px;margin: 0 auto;padding: 10px 20px;display: none;"></div>
        <div class="div_roller_total" align="center" style="display: none;"><img src="<?php echo base_url(); ?>images/ajax_loader.gif" style="max-width: 60px;" /></div>
      </div>
      <?php if($fuser_detailset->fu_final_submit == 1 && $fuser_detailset->fu_payment_stat == 0 && $fuser_detailset->fu_pay_amount != 0){ ?>
        <?php echo form_open_multipart('member/final_payment_submission'); ?>
      <input type="hidden" name="refno" id="refno" value="<?php echo $fuser_detailset->f_application_no; ?>" />
      <input type="submit" class="btn btn-primary btn-lg submitbutton" value="PAY" />
      <?php if(!empty($trans_list)){ ?>
        <br/>
      <div style="font-size:20px;">If you have pending Transaction in the list, then please verify your transaction first to validate your pending payment. <br/>Verify after 20 minutes from transaction</div>
      <?php } ?>
      <?php echo form_close(); ?>
        
      <?php } ?>
</div>
    <div class="mt-3 mb-5"> 
        
        <?php if(!empty($trans_list)){ ?>
          <h3>Transaction List</h3>
          <table class="table table-bordered">
          <tr>
            <th>Sl No.</th>
            <th>Transaction No.</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          <?php foreach($trans_list as $keys=>$tansset){ ?>
          <tr>
            <td><?php echo $keys+1; ?></td>
            <td><?php echo $tansset->fu_transaction_no; ?></td>
            <td><?php if($tansset->fu_pay_approval == 0){
              echo "<span style='color:blue'>Pending</span>";
            }elseif($tansset->fu_pay_approval == 1){
              echo "<span style='color:green'>Success</span>";
            }elseif($tansset->fu_pay_approval == 2){
              echo "<span style='color:red'>Failure</span>";
            } ?></td>
            <td><?php if($tansset->fu_pay_approval == 0){ ?>
              <a href="<?php echo base_url('member/verify_payment_submission/'.$tansset->fu_transaction_no); ?>" class="btn btn-warning">Verify Now</a>
            <?php }else{echo "Verified";} ?></td>
          </tr>
          <?php } ?>
          </table>
        <?php } ?>
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


<?php if($fuser_detailset->fu_final_submit != 1){ ?>
<script type="text/javascript">

function gotoedit_mode_on(){
  $('.editbutton, .submitbutton').prop('disabled', true);
  $('.div_roller_total').fadeIn();
  var e_error = 0;
  //alert(salts);
  var refno = $('#refno').val();

  if(refno == ""){
    e_error = 1;
    error_message = error_message + 'Registration Number not Found, Refresh the Page.';
  }
  if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      $('.get_error_total').html(error_message);
      $(".get_error_total").fadeIn();
      $(".text-error").fadeIn();
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, delay);

      } else {
        var conf_answer = confirm("Warning! You are going to edit all information! Are you sure you want to Process for Edit?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/editmode_processing"; ?>',
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
                $('.get_success_total').html('Edit Mode is Processing. Please Wait...');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/dashboard') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.editbutton, .submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total').html(error_message);
                $(".get_error_total").fadeIn();
                setTimeout(function() {
                  $('.get_error_total').fadeOut();
                }, delay);

              }



            }

          });

        } else {
          $('.div_roller_total').fadeOut();
          $('.editbutton, .submitbutton').prop('disabled', false);
        }

      }
}

function goto_finalsubmit_on(){
    //alert('Working to Process for Payment Clearence');
    $('.editbutton, .submitbutton').prop('disabled', true);
    $('.div_roller_total').fadeIn();
    var e_error = 0;
    //alert(salts);
    var refno = $('#refno').val();

    if(refno == ""){
      e_error = 1;
      error_message = error_message + 'Registration Number not Found, Refresh the Page.';
    }
    if (e_error == 1) {

      $('.div_roller_total').fadeOut();
      $('.get_error_total').html(error_message);
      $(".get_error_total").fadeIn();
      $(".text-error").fadeIn();
      /*e_error = 0;
      error_message = '';*/
      setTimeout(function() {
        $('.text-error, .get_error_total').fadeOut();
      }, delay);

      } else {
        var conf_answer = confirm("Warning! You are going to final submission of all information! Are you sure you want to Process?")

        if (conf_answer) {
          var form_data = new FormData();
          form_data.append('refno', refno);
          $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . "member/finalsubmitmode_processing"; ?>',
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
                $('.get_success_total').html('Final Submission is Done. Thank You.');
                $(".get_success_total").fadeIn();
                $('input, select').val('');
                $('input').html('');
                setTimeout(function() {
                  $('.get_success_total').fadeOut();
                }, 3000);
                setTimeout(function() {
                  window.location.replace("<?php echo site_url('member/payment_summery') ?>");
                }, 3000);

              } else {

                $('.div_roller_total').fadeOut();
                $('.editbutton, .submitbutton').prop('disabled', false);
                error_message = "There have some problem to Update Data, Try after some time.";
                error_message = error_message + "<br/>" + data.e_msg;
                $('.get_error_total').html(error_message);
                $(".get_error_total").fadeIn();
                setTimeout(function() {
                  $('.get_error_total').fadeOut();
                }, delay);

              }



            }

          });

        } else {
          $('.div_roller_total').fadeOut();
          $('.editbutton, .submitbutton').prop('disabled', false);
        }

      }
}
</script>
<?php } ?>