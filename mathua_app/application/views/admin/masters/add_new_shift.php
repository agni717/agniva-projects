<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link rel="stylesheet" href="<?php echo base_url() ?>dist/select_style/chosen.css">
<script type="text/javascript">
  $(function() {
    $('.alert-error, .text-error').delay(6000).fadeOut();
  });
</script>

<style>
  select {
    color: #555555;
    height: 25px;
    line-height: 30px;
  }

  .box-body textarea,
  input,
  select {
    max-width: 800px;
  }

  .box-body textarea {
    resize: vertical;
  }

  .box-body input[type="file"] {
    padding-bottom: 0px;
  }

  .ui-datepicker table {
    border: 1px solid #000;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo "Add New Shift"; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> <?php echo "Add New Shift"; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <section class="col-lg-12">
        <!-- Custom tabs (Charts with tabs)-->

        <?php if (isset($error)) { ?>
          <div class="alert alert-error">
            <h4>Error!</h4>
            <?php echo $error; ?>
          </div>
        <?php } ?>

        <?php if ($this->session->flashdata('error')) { ?>
          <div id="alert_msg" class="alert alert-error"><?php echo $this->session->flashdata('error'); ?></div>
        <?php $this->session->unset_userdata('error');
        } ?>
        <?php if ($this->session->flashdata('success')) { ?>
          <div id="alert_msg" class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php $this->session->unset_userdata('success');
        } ?>

        <!-- TO DO List -->
        <div class="box box-primary">
          <div class="box-header">
            &nbsp;
          </div><!-- /.box-header -->
          <div class="box-body">

            <?php echo form_open_multipart('', 'class="form-horizontal"'); ?>
            
            <div class="form-group">
              <label class="col-sm-3 control-label text-right">Select Venue<font style="color: red;">*</font></label>
              <div class="col-sm-3">
                <select class="form-control selectpicker" name="venueno" id="venueno" autocomplete="off">
                <option value="">---Select---</option>
                <?php foreach($vn_list as $vnss){ ?>
                  <option value="<?php echo $vnss->address_id; ?>" <?php if(!empty($searchlist['advno'])){if($searchlist['advno'] == $vnss->address_id){echo 'selected="selected"';}} ?>><?php echo $vnss->address_name; ?></option>
                <?php } ?>
                </select>
				        <small class="text-error venueno"><?php echo form_error('venueno'); ?></small>
              </div>
              <label class="col-sm-2 control-label text-right">Shift Name<font style="color: red;">*</font></label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="sf_name" name="sf_name" placeholder="Enter Shift Name" value="<?php echo set_value('sf_name'); ?>" autocomplete="off" required />
                <small class="text-error"><?php echo form_error('sf_name'); ?></small>
              </div>
              </div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right">Interview Date<font style="color: red;">*</font></label>
              <div class="col-sm-3">
              <input type="text" class="form-control" name="u_startdate" id="u_startdate" placeholder="Enter Start Date" value="<?php if(!empty(set_value('u_startdate'))){echo set_value('u_startdate');}else{echo date('d-m-Y');} ?>" autocomplete="off" />
              <small class="text-error u_startdate"><?php echo form_error('u_startdate'); ?></small>
              </div>
              <label class="col-sm-2 control-label text-right">Total Table No.<font style="color: red;">*</font></label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="t_no" id="t_no" placeholder="Enter Total Table no." autocomplete="off" value="<?php echo set_value('t_no'); ?>" required />
                <small class="text-error t_no"><?php echo form_error('t_no'); ?></small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right">Shift Start Time<font style="color: red;">*</font></label>
              <div class="col-sm-3 bootstrap-timepicker">
                <input type="text" class="form-control timepicker" name="u_starttime" id="u_starttime" placeholder="Start Time" value="<?php echo set_value('u_starttime'); ?>" autocomplete="off" />
                <small class="text-error u_starttime"><?php echo form_error('u_starttime'); ?></small>
              </div>
              <label class="col-sm-2 control-label text-right">Shift End Time<font style="color: red;">*</font></label>
              <div class="col-sm-3 bootstrap-timepicker">
                <input type="text" class="form-control timepicker" name="u_endtime" id="u_endtime" placeholder="Start Time" value="<?php echo set_value('u_endtime'); ?>" autocomplete="off" />
                <small class="text-error u_endtime"><?php echo form_error('u_endtime'); ?></small>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-2">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit" width="60px;" />
                &nbsp;<a href="<?= site_url('admincontrol/masterdata/all_shift_list') ?>" class="btn btn-danger">Cancel</a>
              </div>
            </div>

            <?php form_close(); ?>

          </div><!-- /.box-body -->
          <div class="box-footer clearfix">
            &nbsp;
          </div>
        </div><!-- /.box -->

      </section>
    </div><!-- /.row (main row) -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->



<script src="<?php echo base_url() ?>dist/select_style/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>dist/select_style/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
<script>
  $(function() {
    $('#u_startdate, #u_enddate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
        //$("#datatable_tab").dataTable();
    //$( "#lv_start_date, #lv_end_date" ).datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
    //Timepicker
    /*$(".timepicker").timepicker({
          showInputs: false
        });*/
  });
</script>
</script>

<?php $this->load->view('admin/component/footer') ?>