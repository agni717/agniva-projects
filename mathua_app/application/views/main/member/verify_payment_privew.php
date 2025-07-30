<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WB - Health Recruitment Board</title>
</head>

<body>
<?php //$this->load->view('main/component/login_header') ?>

<div>
<?php echo form_open('http://202.61.117.90/GRIPS/dept/dv/rest/WBHealth.do','id="frm1"'); ?>
<input type="hidden" name="ENCDATA" id="ENCDATA" value="<?php echo $senddata; ?>" />
<input type="hidden" name="DEPT_CD" id="DEPT_CD" value="<?php echo $senddpt; ?>" />
<?php echo form_close(); ?>
</div>
</body>
<?php //$this->load->view('main/component/footer'); ?>

<script src="<?php echo base_url('js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript">
	$(function() {
		//$("#fu_dob").datepicker({autoclose: true,dateFormat: 'dd-mm-yy',changeMonth: true, changeYear: true ,setDate: new Date()});
		//$('#fu_dob').datepicker({ maxDate: '-18Y' });
    $("#frm1").submit();
		//$('.alert-error, .text-error').delay(8000).fadeOut();
		//$('[data-toggle="tooltip"]').tooltip();
	});
</script>
</html>