<?php $this->load->view('admin/component/header') ?>

<div class="home pb-5">
		<div class="container">
			<div class="row">						
				<div class="col-lg-10 m-auto" >
					<div class="widget-area-2 proclinic-box-shadow">
						<h3 class="widget-title">Gallery caption Creation</h3>
						<div class="row photos">

                        <?php
                        foreach($progress_photos2 as $pic){
                        ?>
							<div class="col-sm-6 col-md-4 col-lg-3 item">
								<a href="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$pic->wpt_doc; ?>" data-lightbox="photos" target="_blank">
									<img class="img-fluid" src="<?php echo base_url('uploads/'.$requisition_details->req_number).'/'.$pic->wpt_doc; ?>">
								</a>
							</div>

                        <?php
                        }
                        ?>

						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>


<?php $this->load->view('admin/component/footer') ?>