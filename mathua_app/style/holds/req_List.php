<!-- <h1 style="font-size: 4em; font-weight: bold; background: #ff0; text-align: center; margin: 10px 0; letter-spacing: 0;">Requisition List</h1> -->
<?php include('common/header.php'); ?>

	<div class="home pb-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 mt-5">
					<div class="widget-area-2 proclinic-box-shadow mb-3">
                    <h3 class="widget-title">Requisition List</h3>
						<div class="table-responsive mb-3">
							<table id="tableId" class="table table-bordered table-striped">
								<thead>
									<tr>												
										<th>Sl.No.</th>
										<th>Requisition No</th>
										<th>Scheme Name</th>
										<th>Req Details</th>
										<th>Quantity</th>
                                        <th>District</th>
                                        <th>Block</th>
                                        <th>Subdivision</th>
                                        <th>Docs.</th>
                                        <th>Unit of Measurment</th>
										<th>Action</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>												
										<td>1</td>
										<td>5335</td>
										<td>Scheme Name 1</td>
										<td>Req Details 1</td>
										<td>200</td>
                                        <td>Kolkata</td>
                                        <td>Block 1</td>
                                        <td>Divi 1</td>
                                        <td>Docs 1</td>
                                       <td>Measurment 1</td>
                                       <td><a href="#approval" class="btn btn-info" data-toggle="modal" type="button"><span class="ti-fullscreen"></span></a></td>
                                       <td style="color: green;">Approve</td>
									</tr>
									<tr>												
										<td>2</td>
										<td>3578</td>
										<td>Scheme Name 2</td>
										<td>Req Details 2</td>
										<td>300</td>
                                        <td>Bardhaman</td>
                                        <td>Block 2</td>
                                        <td>Divi 2</td>
                                        <td>Docs 2</td>
                                       <td>Measurment 2</td>
                                       <td><a href="#" class="ti-fullscreen btn btn-info"></a></td>
                                       <td style="color: red;">Reject</td>
									</tr>
									<tr>												
										<td>3</td>
										<td>7975</td>
										<td>Scheme Name 3</td>
										<td>Req Details 3</td>
										<td>400</td>
                                        <td>Murshidabad</td>
                                        <td>Block 4</td>
                                        <td>Divi 5</td>
                                        <td>Docs 6</td>
                                       <td>Measurment 3</td>
                                       <td><a href="#" class="ti-fullscreen btn btn-info"></a></td>
                                       <td style="color: green;">Approve</td>
									</tr>									             
								</tbody>
                            </table>	                                
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		  	<div class="modal-dialog" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
				        <h3 class="modal-title widget-title">Welfare Board Approval</h3>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
			      	</div>
			      	<div class="modal-body">
		               	<form>
		                  	<fieldset class="scheduler-border py-3">
		                     	<div class="col-lg-12">
			                        <div class="row">
			                           <div class="form-group col-lg-4 ">
			                              <label>Requsition No. : 123456789</label>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Scheme No. : 14569</label>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Scheme Details : Scheme Details</label>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Block : Block 1</label>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>District : Kolkata</label>
			                           </div>
			                           <div class="form-group col-lg-4 ">
			                              <label>Approx. Amount : 356</label>
			                           </div>
			                        </div>
		                     	</div>
		                  	</fieldset>
		                  	<div class="form-group col-lg-12 ">
		                     	<div class="row">
			                        <!-- <div class="col-lg-2"><label>Send To DM Office</label></div>
			                        <div class="col-lg-6">
			                           <select class="form-control">
			                              <option disabled selected>---Select---</option>
			                              <option>DM</option>
			                              <option>DM</option>
			                           </select>
			                        </div> -->
			                        <div class="col-lg-12">
			                           <label>Remarks :</label>
			                           <textarea rows="2" class="form-control"></textarea>
			                        </div>
			                        <div class="col-lg-12 text-center">
			                           <input type="button" value="Approve" class="btn btn-info ">
			                           <input type="button" value="Reject" class="btn btn-warning ">
			                        </div>
		                     	</div>
		                  	</div>
		               	</form>
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

