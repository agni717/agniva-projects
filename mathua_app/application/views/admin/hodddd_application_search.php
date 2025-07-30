<?php $this->load->view('admin/component/header') ?>

<?php $this->load->view('admin/component/menu') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.js" integrity="sha256-JTH6WxFs/GvXkgGMSYlAXBawtdhTdyYA3+7hhkBG6/o=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div class="content-wrapper">
  <div class="row" style="width: 50%;left:50%;top:100px;position: fixed;transform: translate(-50%,-50%);">
    <div>
      <div class="row">
        <div class="col-md-12">
          <label>Enter application no.</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 m-0 p-0">
          <input class="form-control" type="text" name="search_reg_no" value="C180820210528383175" placeholder="Search">
        </div>
        <div class="col-md-2 m-0 p-0">
          <button class="btn btn-primary m-0 btn-search"><span><i class="fa fa-search"></i></span></button>    
        </div>
      </div>
      <div class="row">
        <div class="col-md-10">
          <!-- <small class="text-error">Hwllo</small>   -->
        </div>
      </div>
      <!-- 
      <div class="row m-0 p-0">
        <div class="col-md-10">
          <h4>Order by</h4>
        </div>
      </div>
       -->
      <!-- 
      <div class="row m-0 p-0">
        <div class="col-md-3">
          <label>Advertisement </label>
          <input type="checkbox" style="width: 20px;height: 20px;margin: 10px;transform: translate(0,20%);" name="">
        </div>
      </div> 
    -->
    </div>
  </div>
  
  <section style="position: absolute;width:90%;top:100px;transform: translateY(20%);height: 50%;overflow-y: scroll;">
    <div>
      <div class="box box-warning search-results" style="margin: 20px;padding: 10px;width: 90%;display: none;">
        
      </div>

    </div>
  </section>

  <section>
    <div class="row">
      <div class="col-md-12 bg-success text-light e-msg" style="display:none;padding:10px;margin:10px;"></div>
      <div class="col-md-12 bg-success text-light e-msg-err" style="display:none;padding:10px;margin:10px;"></div>
    </div>
    </div>
    <div class="card upload-pic-block" style="height:auto;width:500px;position:fixed;left:50%;top:80px;transform:translate(-50%,0);padding:10px;display:none;justify-content:center;z-index: 20;background-color: white;box-shadow: 0px 0px 6px 1px lightgrey;">
      
      <span class="text-light bg-dark btn-close-upload-pic-block" style="cursor: pointer;left: 500px;position: fixed;top: 0;transform: translate(-100%,0%);padding-left: 5px;padding-right: 5px;font-size: 18px;"><i class="fa fa-times"></i></span>
      
      <div style="display:flex;justify-content:center;">
        <div id="my_camera" style="width: 320px;height: 240px;border: 1px solid lightgrey;"></div>
      </div>
      
      <div style="display:flex;justify-content:center;">
        <input class="btn btn-success btn-take-snapshot" type=button value="Take Snapshot" onClick="take_snapshot()" style="margin:10px;">
      </div>
      
      <div id="results" style="display:flex;justify-content:center;"></div> 
      
      <div style="display:flex;justify-content:center;">
        <input class="btn btn-primary btn-save-snapshot" type=button value="Save Snapshot" style="display:none;margin:10px;" onClick="saveSnap()">     
        <input class="btn btn-warning btn-retake-snapshot" type=button value="Retake Snapshot" style="display:none;margin:10px;">    
      </div>
    
    </div>
  </section>

</div>


<script type="text/javascript">

  // $('input[name="search_reg_no"]').on('input',function(event){
  $('.btn-search').on('click',function(event){
    
    let key = $('input[name="search_reg_no"]').val();

    if(key == "") return;

    let form_data = new FormData();

    form_data.append('key',key);

    $.ajax({

      url:'<?= base_url("admincontrol/application_set/get_application_data")?>',
      method:'POST',
      data:form_data,
      dataType:'JSON',
      processData:false,
      contentType:false,
      success: function(data){
        // console.log(data)
        let html = "";
        $('.search-results').css({
          display : 'block'
        });
        $('.search-results').html('');

        if(data.length < 1){
          html = `
            <h3>Application Not Found</h3>
          `;
          $('.search-results').append(html);
        }

        for(let i=0;i<data.length;i++){
          html = `
            <div style="box-shadow: 0px 0px 6px 1px lightgrey;padding: 10px;margin: 20px;">
              <div class="row">
                <h3 style="padding-left: 20px;"><span>Registration No : </span><span><b>${data[i].f_application_no}</b></span></h3>
              </div>  
              <div class="row">
                <h4 style="padding-left: 20px;"><span>Applied By : </span><span><b>${data[i].f_full_name}</b></span></h4>
              </div>
              <div class="row">
                <h4 style="padding-left: 20px;"><span>Applied For : </span><span><b>${data[i].adv_no}|${data[i].rm_name}</b></span></h4>
              </div>
              <div class="row">
                <h4 style="padding-left: 20px;"><span>Mobile : </span><span><b>${data[i].f_mobile}</b></span></h4>
              </div>
              <div>
                <button class="btn btn-primary btn-upload-pic" data-id="${data[i].cr_id}" application-id="${data[i].cr_application_master}">Upload Image</button>
                <a class="btn btn-primary" target="_blank" href="<?= base_url('admincontrol/application_set/add_document/')?>${data[i].cr_application_master}">Upload Document</a>
                <!-- <button class="btn btn-primary btn-upload-doc" data-id="${data[i].cr_id}">Upload Document</button> -->
              </div>
            </div>
          `;

          $('.search-results').append(html);

        }
      }
    });

  })

 
 var applicationId = "";

 Webcam.set({
   width: 320,
   height: 240,
   image_format: 'jpeg',
   jpeg_quality: 90
 });

Webcam.on( 'error', function(){
  alert('Web Cam not found! Check your Camera Connection.');
});

Webcam.on( 'load', function() {
    
 
  

  $('.upload-pic-block').css({
  display:'block'
  });

 $('#my_camera,.btn-take-snapshot').css({
    display:'flex'
  });

 $('#results').html('');
 $('.btn-save-snapshot,.btn-retake-snapshot').css({
    display:'none'
  });
});

 $(document).on('click','.btn-upload-pic',function(event){
   

   applicationId = event.currentTarget.attributes['application-id'].value

   Webcam.attach( '#my_camera' );
    
 });

 $('.btn-close-upload-pic-block').on('click',function(event){

    $('.upload-pic-block').fadeOut();
    Webcam.reset();
    $('#my_camera,.btn-take-snapshot').css({
      display:'none'
    });
 });
 

 // A button for taking snaps
 // preload shutter audio clip
 var shutter = new Audio();
 shutter.autoplay = false;
 shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';
 
 function take_snapshot() {
  
  // take snapshot and get image data
  Webcam.snap(function(data_uri){
  // display results in page
  document.getElementById('results').innerHTML = 
  '<img id="imageprev" style="width:320px;height:240px;" src="'+data_uri+'"/>';
  });
  
  Webcam.reset();

  $('#my_camera,.btn-take-snapshot').css({
    display:'none'
  });

  $('.btn-save-snapshot,.btn-retake-snapshot').css({
    display:'block'
  });
  
 }

 $('.btn-retake-snapshot').on('click',function(event){
  
  $('#my_camera,.btn-take-snapshot').css({
    display:'block'
  });

  Webcam.set({
     width: 320,
     height: 240,
     image_format: 'jpeg',
     jpeg_quality: 90
   });
   Webcam.attach( '#my_camera' );

   $('#results').html('');
   $('.btn-save-snapshot,.btn-retake-snapshot').css({
    display:'none'
  });
 });

function saveSnap(){
  
  // Get base64 value from <img id='imageprev'> source
  var base64image = document.getElementById("imageprev").src;

  var form_data = new FormData();

  form_data.append('base64image',base64image);
  form_data.append('application_id',applicationId);

  $.ajax({
    url: "<?php echo base_url('admincontrol/interview/upload') ?>",
    method: "POST",
    data: form_data,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success:function(data){
      console.log(data)
      if(data.msg){

        $('.upload-pic-block').css({
            display:'none'
         });

         $('.e-msg').html(data.e_msg);
         $('.e-msg').fadeIn();
         setTimeout(function(){ window.location.replace("<?php echo base_url('admincontrol/application_set')?>"); }, 3000);
      }
    }
  });
}

$(document).on('click','.btn-upload-doc',function(event){

  $('.upload-doc-block').css({
    display:'block'
  })
})

$(document).on('click','.btn-doc-add',function(event){

  let html = `
        <div style="display:flex;justify-content:center;margin-top:10px;">
          <label style="margin: 4px;">Document Title</label>
          <input class="doc-title form-control" type="text" name="doc_title[]" placeholder="Document Title">
        </div>
        <div style="display:flex;justify-content:center;">
          <label style="margin: 4px;">Document</label>
          <input class="doc-file form-control" type="file" name="doc_file[]" class="form-control">
        </div>
  `;
  $('.doc-input-block').append(html)
})

$('.btn-close-upload-doc-block').on('click',function(event){

  $('.upload-doc-block').css({
    display:'none'
  })
})
</script>
<?php $this->load->view('admin/component/footer') ?>
