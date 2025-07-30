<?php include('common/header.php'); ?>

	<div class="home pb-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                    <h3 class="widget-title">DM Office Requisition Approval List</h3>
						<div class="table-responsive mb-3">
							<table id="tableId" class="table table-bordered table-striped">
								<thead>
									<tr>												
										<th>Sl.No.</th>
										<th>Requisition No</th>
										<th>Scheme Name</th>
										<th>Approx. Amount</th>										
										<th>Application Start Date</th>
										<th>Application End Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>												
										<td>1</td>
										<td>854329</td>
										<td>Scheme Name 1</td>
										<td>200</td>                                        
                                        <td>25-02-22</td>
                                        <td>27-02-22</td>
                                        <td>
                                        	<a href="#dmModal" type="button" class="btn btn-info btn-sm" data-toggle="modal"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>
									<tr>												
										<td>2</td>
										<td>575433</td>
										<td>Scheme Name 2</td>
										<td>300</td>                                        
                                        <td>28-02-22</td>
                                        <td>03-03-22</td>
                                        <td>
                                        	<a href="#" type="button" class="btn btn-info btn-sm"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>
									<tr>												
										<td>3</td>
										<td>233789</td>
										<td>Scheme Name 3</td>
										<td>200</td>                                        
                                        <td>02-03-22</td>
                                        <td>05-03-22</td>
                                        <td>
                                        	<a href="#" type="button" class="btn btn-info btn-sm"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>
									<tr>												
										<td>4</td>
										<td>659743</td>
										<td>Scheme Name 4</td>
										<td>300</td>                                        
                                        <td>20-03-22</td>
                                        <td>22-03-22</td>
                                        <td>
                                        	<a href="#" type="button" class="btn btn-info btn-sm"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>
									<tr>												
										<td>5</td>
										<td>521987</td>
										<td>Scheme Name 5</td>
										<td>400</td>                                        
                                        <td>23-03-22</td>
                                        <td>26-03-22</td>
                                        <td>
                                        	<a href="#" type="button" class="btn btn-info btn-sm"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>
									<tr>												
										<td>6</td>
										<td>731198</td>
										<td>Scheme Name 6</td>
										<td>500</td>                                        
                                        <td>27-03-22</td>
                                        <td>30-03-22</td>
                                        <td>
                                        	<a href="#" type="button" class="btn btn-info btn-sm"><span class="ti-fullscreen"></span></a>
                                        </td>
									</tr>									                                  
								</tbody>
                            </table>	                                
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ----Modal---- -->
		<div class="modal fade" id="dmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h3 class="modal-title widget-title">Requisition Approval for D.M. Office</h3>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <div class="widget-area-2">
		               <!-- <h3 class="widget-title">Requisition Approval for D.M. Office</h3> -->
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
		                              <label>Estimated Cost : 356</label>
		                           </div>
		                        </div>
		                     </div>
		                  </fieldset>
		                  <div class="form-row control-group">
		                     <div class="form-group col-lg-6">
		                        <label>Choose Executive Agency</label>
		                        <select class="form-control">
		                           <option disabled selected>---Select---</option>
		                           <option>Executive Agency 1</option>
		                           <option>Executive Agency 2</option>
		                        </select>
		                     </div>
		                     <div class="form-group col-lg-6">
		                        <label>Vetted Cost</label>
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
		                     <div class="form-group col-lg-6">
		                        <label>Note Sheet No</label>
		                        <input type="number" class="form-control" placeholder="1234567890">
		                     </div>
		                  </div>
		                  <div class="form-row control-group">		                     
		                     <div class="form-group col-lg-6">
		                        <label>Date</label>
		                        <input type="Date" class="form-control" placeholder="Date">
		                     </div>
		                     <div class="form-group col-lg-6 text-right">
		                        <label></label>
		                        <input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto">
		                     </div>
		                  </div>
		               </form>
		            </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			      </div>
			    </div>
		  	</div>
		</div>
	</div>
	<?php include('common/footer.php'); ?>

