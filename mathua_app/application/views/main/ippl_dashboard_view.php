<?php $this->load->view('main/component/header')?>
        <!-- Presentation -->
        <div class="presentation-container">
        	<div class="container">
	            		
	            <div class="row">
					<div class="col-sm-12 text-right">
						<?php if(!empty($this->session->userdata('member_id'))){ ?>
					
							<div style="text-align: right;font-weight: bold;margin-right: 10px;font-size: 1.2em;">
								<p>Welcome, <a href="<?php echo base_url().'member/dashboard'; ?>"><?php echo $this->session->userdata('member_uname'); ?></a> | <a href="<?php echo base_url().'member/logout'; ?>">Logout</a><hr/></p>
								
							</div>
						<?php } ?>
					</div>
	            	<div class="col-sm-12 text-center">
        				<h1 class="header_search">Hospital Dashboard</h1>
        			</div>


					<div class="col-sm-12">
						<h3>All Sections</h3>
					</div>
					
					
					
					
					
	            </div>
	            
	          
        	</div>
        </div>

<?php $this->load->view('main/component/footer'); ?>