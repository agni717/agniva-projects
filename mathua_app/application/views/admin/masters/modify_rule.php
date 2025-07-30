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
      <?php echo "Modify InterView Rule"; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> <?php echo "Modify InterView Rule"; ?></li>
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
              <label class="col-sm-3 control-label text-right">Rule Details<font style="color: red;">*</font></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="rule_name" name="rule_name" placeholder="Enter Rule Details" value="<?php echo $rule_detail->rm_details; ?>" autocomplete="off" required />
                <small class="text-error"><?php echo form_error('rule_name'); ?></small>
              </div>
              </div>
            <div class="form-group">
              <label class="col-sm-3 control-label text-right">Select District</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="rule_order" name="rule_order" placeholder="Enter Rule Order" value="<?php echo $rule_detail->rm_order; ?>" autocomplete="off" required />
                <small>(Enter 0 for the First Position)</small><br/>
                <small class="text-error"><?php echo form_error('rule_order'); ?></small>
              </div>
              
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-2">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit" width="60px;" />
                &nbsp;<a href="<?= site_url('admincontrol/masterdata/interviewrules_list') ?>" class="btn btn-danger">Cancel</a>
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
    //$( "#lv_start_date, #lv_end_date" ).datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
    //Timepicker
    /*$(".timepicker").timepicker({
          showInputs: false
        });*/
  });
</script>
</script>

<?php $this->load->view('admin/component/footer') ?>