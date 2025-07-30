<?php $this->load->view('admin/component/header') ?>
<?php $this->load->view('admin/component/menu') ?>

<div class="content-wrapper">
  <section class="content-header">
	  <h1>
			Interview Candidate Document Upload
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Interview Candidate Document Upload</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
    <div class="row"><h4 style="padding-left: 20px;"><span>Candidate Name : </span><span><b><?php echo $canddata->f_full_name; ?></b></span></h4></div>
    <div class="row"><h4 style="padding-left: 20px;"><span>Applied For : </span><span><b><?php echo $canddata->adv_no; ?> | <?php echo $canddata->rm_name; ?></b></span></h4></div>
    <div class="row"><h4 style="padding-left: 20px;"><span>Mobile : </span><span><b><?php echo $canddata->f_mobile; ?></b> | Email - <b><?php echo $canddata->f_email; ?></b></span></h4><h4 style="padding-left: 20px;"><span>Date : </span><span><b><?php echo $canddata->shift_date; ?></b> | Timing - <b><?php echo $canddata->shift_start_time; ?> To <?php echo $canddata->shift_end_time; ?></b></span></h4><h4 style="padding-left: 20px;"><span>Venue : </span><span><b><?php echo $canddata->address_name; ?></b></span></h4></div>
    <div class="row">
      <div class="col-md-12 bg-success text-light e-msg" style="display:none;padding:10px;margin:10px;"></div>
      <div class="col-md-12 bg-danger text-light e-msg-err" style="display:none;padding:10px;margin:10px;"></div>
    </div>
    <div class="card upload-doc-block" style="height:480px;width:1000px;position:relative;left:50%;top:10px;transform:translate(-50%,0);padding:10px;justify-content:center;z-index: 20;background-color: white;box-shadow: 0px 0px 6px 1px lightgrey;overflow-y:auto;">
      <form class="doc-upload-form" action="<?= base_url("admincontrol/application_set/upload_doc")?>" method='post' enctype="multipart/form-data">
      <!-- <span class="text-light bg-dark btn-close-upload-doc-block" style="cursor: pointer;left: 100%;position: sticky;top: 0;transform: translate(-40px,0%);padding-left: 5px;padding-right: 5px;font-size: 18px;z-index: 30;"><i class="fa fa-times"></i></span> -->
      <div style="text-align:center">
        <!--<input class="btn btn-primary btn-doc-add" type=button value="Add Document">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
        <input class="btn btn-success btn-doc-upload" type=button value="Upload">
      </div>
      <div class="doc-input-block" style="top:50px;position: relative;height:80%;">  
        <div class="row">
			<div class="col-md-5">
			<label>Document Title</label>
			<input class="doc-title form-control" type="text" value="Interview Call Letter" name="doc_title[]" placeholder="Document Title">
			<small class="text-error title-error title-error-0"></small>
			</div>
			<div class="col-md-5">
			  <label>Document</label>
			  <input class="doc-file form-control" type="file" name="doc_file[]" class="form-control">
			  <small class="text-error file-error file-error-0"></small>
			</div>
		</div>
      </form>

    </div>
  </section>
</div>

<script type="text/javascript">
  var doc_count = 0;
  $(document).on('click','.btn-upload-doc',function(event){

  $('.upload-doc-block').css({
    display:'block'
  })
})

$(document).on('click','.btn-doc-add',function(event){

  doc_count++;

  let html = `
        <div class="row">
        <div class="col-md-5">
          <input class="doc-title form-control" type="text" name="doc_title[]" value="Interview Call Letter" placeholder="Document Title">
          <small class="text-error title-error title-error-${doc_count}"></small>
        </div>
        <div class="col-md-5">
          <input class="doc-file form-control" type="file" name="doc_file[]" class="form-control">
          <small class="text-error file-error file-error-${doc_count}"></small>
        </div>
        <div class="col-md-2">
          <button class="btn btn-danger btn-remove">Remove</button>
        </div>
        </div>
  `;
  $('.doc-input-block').append(html)
})

$('.btn-close-upload-doc-block').on('click',function(event){

  $('.upload-doc-block').css({
    display:'none'
  })
})

$(document).on('click','.btn-doc-upload',function(event){

  //$('.doc-upload-form').submit();
  ///*
  let doc_titles = [];
  let doc_files = [];
  
  for(let i=0;i<$('input[name="doc_title[]"]').length;i++){
    
    doc_titles.push($('input[name="doc_title[]"]')[i].value);
    doc_files.push($('input[name="doc_file[]"]')[i].files[0] ? $('input[name="doc_file[]"]')[i].files[0] : '');
  }

  // console.log(doc_titles);
  // console.log(doc_files);
  let form_data = new FormData($(this).parents('form')[0]);

  // form_data.append('doc_titles',doc_titles);
  // form_data.append('doc_files',doc_files);
  form_data.append('reg_no','<?= $application_id ?>')

  $.ajax({
    url:'<?= base_url("admincontrol/application_set/upload_doc")?>',
    method:'POST',
    data:form_data,
    dataType:'JSON',
    processData:false,
    contentType:false,
    cache:false,
    xhr: function() {
        var myXhr = $.ajaxSettings.xhr();
        return myXhr;
    },
    success:function(data){
      if(data.msg){
        $('.e-msg').fadeIn();
        $('.e-msg').html(data.e_msg);
        
        setTimeout(function(){ 
          $('.e-msg').fadeOut();
        }
        , 4000);
        setTimeout(function(){ window.location.replace("<?php echo base_url('admincontrol/application_set/upload_webcam_picture/'.$application_id)?>"); }, 1000);
      }
      else{

        $('.e-msg-err').fadeIn();
        $('.e-msg-err').html(data.e_msg);
        
        setTimeout(function(){ 
          $('.e-msg-err').fadeOut();
        }
        , 4000); 
      }

      $('.doc-title').val('Interview Call Letter');
      $('.doc-file').val('');
    }

  });
  //*/
})

$(document).on('click','.btn-remove',function(event){

  // console.dir(event.currentTarget.parentElement.parentElement)
  event.currentTarget.parentElement.parentElement.innerHTML = ''
})
</script>
<?php $this->load->view('admin/component/footer') ?>
