<?php include('common/header.php'); ?>
			
	<div class="home pb-5">
		<div class="container">
			<div class="row">						
				<div class="col-md-10 m-auto" >
					<div class="widget-area-2 proclinic-box-shadow">
						<h3 class="widget-title">Requisition</h3>
						<form>
							<fieldset class="scheduler-border">
								
								<div class="form-row control-group">
                                <div class="col-lg-6">
                                 <div class="form-group col-lg-12 ">
										<label>Choose Scheme :</label>
										<select class="form-control">
											<option disabled>---Select---</option>
											<option>District 1</option>
											<option>District 2</option>
										</select>
									</div>
									<div class="form-group col-lg-12">
										<label>Requisition Details :</label>
										<textarea class="form-control" id="textAreaExample1" rows="2"></textarea>
									</div>
									
									<div class="form-group col-lg-12 ">
										<label>Quantity</label>
										<input type="text" placeholder="contact" class="form-control">
									</div>
									<div class="form-group col-lg-12 ">
										<label>District</label>
										<select class="form-control">
											<option disabled>---Select---</option>
											<option>District 1</option>
											<option>District 2</option>
										</select>
									</div>
                                </div>
									  <div class="col-lg-6">
									<div class="form-group col-lg-12 ">
										<label>Block</label>
										<select class="form-control">
											<option disabled>---Select---</option>
											<option>Block 1</option>
											<option>District 2</option>
										</select>
									</div>
                                    <div class="form-group col-lg-12 ">
										<label>Subdivision</label>
										<select class="form-control">
											<option disabled>---Select---</option>
											<option>Sub Div 1</option>
											<option>District 2</option>
										</select>
									</div>
                                    <div class="form-group col-lg-12 ">
										<label>Location</label>
										<textarea class="form-control" id="textAreaExample1" rows="2"></textarea>
									</div>
                                    <div class="form-group col-lg-12 ">
										<label>Upload Doc.</label>
										<input type="file" class="form-control">
									</div>
									<div class="form-group col-lg-12 text-right">
										<input type="button" value="Submit" class="btn btn-info label-btn">
									</div>
								</div>	
                                </div>
                                									
							</fieldset>
							
						</form>									
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<?php include('common/footer.php'); ?>
