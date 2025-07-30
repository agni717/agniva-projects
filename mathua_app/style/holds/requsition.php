<!-- <h1 style="font-size: 4em; font-weight: bold; background: #ff0; text-align: center; margin: 10px 0; letter-spacing: 0;">Requisition Entry By Chairperson</h1> -->
<?php include('common/header.php'); ?>
			
	<div class="home pb-5">
		<div class="container">
			<div class="row">						
				<div class="col-lg-10 m-auto" >
					<div class="widget-area-2 proclinic-box-shadow">
						<h3 class="widget-title">Requisition Entry By Chairperson</h3>
						<form>
							<div class="form-row control-group">
                            	<div class="form-group col-lg-6">
									<label>Choose Scheme</label>
									<select class="form-control">
										<option disabled selected>---Select---</option>
										<option>Scheme 1</option>
										<option>Scheme 2</option>
									</select>
								</div>									
								<div class="form-group col-lg-6">
									<label>Requisition Details</label>
									<textarea class="form-control" rows="1"></textarea>
								</div>
							</div>
							<div class="form-row control-group">
								<div class="form-group col-lg-6">
									<label>Quantity</label>
									<input type="text" placeholder="contact" class="form-control">
								</div>
								<div class="form-group col-lg-6">
									<label>Unit of Measurment</label>
									<input type="text" placeholder="Unit of Measurment" class="form-control">
								</div>								
							</div>
							<div class="form-row control-group">
								<div class="form-group col-lg-6">
									<label>District</label>
									<select class="form-control">
										<option disabled selected>---Select---</option>
										<option>District 1</option>
										<option>District 2</option>
									</select>
								</div>
								<div class="form-group col-lg-6">
									<label>Block</label>
									<select class="form-control">
										<option disabled selected>---Select---</option>
										<option>Block 1</option>
										<option>District 2</option>
									</select>
								</div>								
							</div>
							<div class="form-row control-group">
								<div class="form-group col-lg-6">
									<label>Subdivision</label>
									<select class="form-control">
										<option disabled selected>---Select---</option>
										<option>Sub Div 1</option>
										<option>District 2</option>
									</select>
								</div>
								<div class="form-group col-lg-6">
									<label>Location</label>
									<input type="text" placeholder="Location" class="form-control">
								</div>								
							</div>
							<div class="form-row control-group">								
								<div class="form-group col-lg-6">
									<label>Upload Doc.</label>
									<input type="file" class="form-control">
								</div>
								<div class="form-group col-lg-6 text-right">
									<label></label>
									<input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto">
								</div>
							</div>	
						</form>									
					</div>
				</div>
			</div>			
		</div>
	</div>
	<?php include('common/footer.php'); ?>
