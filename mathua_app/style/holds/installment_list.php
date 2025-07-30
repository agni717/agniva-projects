<?php include('common/header.php'); ?>							
	<div class="home pb-5">
		<div class="container">
			<div class="row">						
				<div class="col-lg-10 mx-auto">
					<div class="widget-area-2 proclinic-box-shadow">
						<h3 class="widget-title">Installment List Against the Requisition</h3>
						<form>
							<fieldset class="scheduler-border">
								<legend class="scheduler-border">Add Installment</legend>
								<div class="form-row control-group">
									<div class="form-group col-lg-4">
										<label>Scheme : Demo Scheme</label>
									</div>													
									<div class="form-group col-lg-4">
										<label>Executive Agency : Demo Executive Agency</label>
									</div>
									<div class="form-group col-lg-4">
										<label>Requisition Number : 5432118</label>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Payment Installment</label>
										<select class="form-control">
				                           <option disabled selected>---Select---</option>
				                           <option>Installment 1</option>
				                           <option>Installment 2</option>
				                        </select>
									</div>
									<div class="form-group col-lg-6">
										<label>Ammount Paid</label>
										<input type="text" placeholder="Ammount" class="form-control">
									</div>									
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>How much parcentage of work done</label>
										<input type="text" placeholder="Work Done" class="form-control">
									</div>
									<div class="form-group col-lg-6">
										<label>Description</label>
										<textarea rows="1" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-row control-group">
									<div class="form-group col-lg-6">
										<label>Document upload against the work</label>
										<input type="file" class="form-control">
									</div>
									<div class="form-group col-lg-6">
										<label></label>
										<input type="button" value="Submit" class="btn btn-info d-block ml-lg-auto">
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
