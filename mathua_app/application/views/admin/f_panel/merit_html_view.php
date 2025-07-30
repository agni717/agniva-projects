<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<link href="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />
<style>
select { color: #555555;height: 25px;line-height: 30px;}
.box-body textarea,input {max-width: 500px;}
.box-body textarea { resize: vertical; }
.ui-datepicker table{ border:1px solid #000; }
.printsethtml
    {
        background-image:url('<?php echo base_url("images/WBHRB_Logo_marker.png"); ?>');
        background-repeat:repeat-y;
        background-position: center;
        background-attachment:fixed;
        background-size:80%;
    }
</style>
<style type="text/css">
	@media print {
		.printsethtml
		{
			background-image:url('<?php echo base_url("images/WBHRB_Logo_marker.png"); ?>');
			background-repeat:repeat-y;
			background-position: center;
			background-attachment:fixed;
			background-size:80%;
		}
	}
</style>
<script type="text/javascript">
	$(function(){
	      $('#alert_msg').delay(6000).fadeOut();
	});
</script>
        
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <div class="col-lg-12">
				<div class="text-center"><a href="javascript:;" onclick="printData();" class="btn btn-lg btn-primary">PRINT</a></div>
              <div id="psetsss">
				<?php echo $content_all; ?>
			  </div>
			</div>
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper --> 

<?php $this->load->view('admin/component/footer') ?>

<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url().'bootstrap-admin/plugins/datatables/dataTables.bootstrap.js'; ?>" type="text/javascript"></script>
<script type="text/javascript">
	//var slagsetno = 3;
	var allcategoryset = '';
    $(function () {
		$('#u_startdate, #u_enddate').datepicker({dateFormat:'dd-mm-yy',changeMonth: true,changeYear: true});
		$(".timepicker").timepicker({showInputs: false, minuteStep: 15});
        $("#datatable_tab").dataTable();
    });

	function printData()
	{
		var imageset = "<?php echo base_url("images/WBHRB_Logo_marker.png"); ?>";
		var divToPrint=document.getElementById("psetsss");
		newWin= window.open("");
		newWin.document.write('<html><head><title>PRINT</title>');
		newWin.document.write('<style type="text/css">@media print{.printsethtml{background-image:url('+imageset+');background-repeat:repeat-y;background-position: center;background-attachment:fixed;background-size:80%;}@page {margin-top: 0;}@page :header{display: none;}}</style>');
		newWin.document.write('</head><body>');
		newWin.document.write(divToPrint.outerHTML);
		newWin.document.write('</body></html>');
		newWin.document.close();
		newWin.print();
		newWin.close();
	}

    </script>