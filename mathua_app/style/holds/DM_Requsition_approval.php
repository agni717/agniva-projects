<!-- <h1 style="font-size: 4em; font-weight: bold; background: #ff0; text-align: center; margin: 10px 0; letter-spacing: 0;">Requisition Approval for D.M. Office</h1> -->
<?php include('common/header.php'); ?>
<div class="home pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-10 m-auto" >
            <div class="widget-area-2 proclinic-box-shadow">
               <h3 class="widget-title">Requisition Approval for D.M. Office</h3>
               <form>
                  <fieldset class="scheduler-border py-3">
                     <div class="col-lg-12">
                        <div class="row">
                           <div class="form-group col-lg-4 ">
                              <label>Requisition No. : 123456789</label>
                           </div>
                           <div class="form-group col-lg-4 ">
                              <label>Scheme No. : 14569</label>
                           </div>
                           <div class="form-group col-lg-4 ">
                              <label>Scheme Details : Scheme Details</label>
                           </div>
                           <div class="form-group col-lg-4 ">
                              <label>District : Kolkata</label>
                           </div>
                           <div class="form-group col-lg-4 ">
                              <label>Block : Block 1</label>
                           </div>
                           <div class="form-group col-lg-4 ">
                              <label>Approx. Amount : 356</label>
                           </div>
                        </div>
                     </div>
                  </fieldset>
                  <div class="form-row control-group">
                     <div class="form-group col-lg-6">
                        <label>Choose Vendor</label>
                        <select class="form-control">
                           <option disabled selected>---Select---</option>
                           <option>Vendor 1</option>
                           <option>Vendor 2</option>
                        </select>
                     </div>
                     <div class="form-group col-lg-6">
                        <label>Final Project Amount</label>
                        <input type="text" class="form-control" placeholder="Final Amount">
                     </div>
                  </div>
                  <div class="form-row control-group">
                     <div class="form-group col-lg-6">
                        <label>Work Start Date</label>
                        <input type="date" class="form-control">
                     </div>
                     <div class="form-group col-lg-6">
                        <label>Work End Date</label>
                        <input type="date" class="form-control">
                     </div>
                  </div>
                  <div class="form-row control-group">
                     <div class="form-group col-lg-6">
                        <label>Upload Document</label>
                        <input type="file" class="form-control">
                     </div>
                     <div class="form-group col-lg-6 text-right">
                        <label></label>
                        <input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto">
                     </div>
                  </div>
                  <div class="form-row control-group">
                     <div class="form-group col-lg-6">
                        <label>Note Sheet No</label>
                        <input type="number" class="form-control" placeholder="1234567890">
                     </div>
                     <div class="form-group col-lg-6">
                        <label>Date</label>
                        <input type="text" class="form-control" placeholder="Date">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include('common/footer.php'); ?>