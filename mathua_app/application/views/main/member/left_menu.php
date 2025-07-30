    
    <?php if(!empty($this->session->userdata('member_id'))){ 
					$usertype = $this->session->userdata('member_utype'); ?>
        <div class="col-sm-9 text-left">
            <div style="text-align: left;">
                <p>Welcome, <strong><?php echo $fuser_detailset->f_full_name; ?></strong></p>
            </div>
        </div>
        <div class="col-sm-3 text-right">
            <div style="text-align: right;margin-right: 2px;">
                <p><a href="<?php echo base_url().'member/profile'; ?>" class="btn btn-md btn-primary">Profile</a>&nbsp;&nbsp;<a href="<?php echo base_url().'member/logout'; ?>" class="btn btn-md btn-danger">Logout</a></p>
            </div>
        </div>
            <hr/>
    <?php } ?>
    <div class="col-sm-2 text-left" style="border-right:2px #000 dotted;">
        <nav>
            <ul class="nav nav-pills nav-stacked span2">
                <li><a href="<?php echo base_url().'member/dashboard'; ?>" class="btn btn-primary">Dash Board</a></li>
                <?php //if($usertype > 1 && $usertype < 4){ ?>
                <li><a href="<?php echo base_url()."member/query_form_submission"; ?>" class="btn btn-primary">Query Form</a></li>
                <li><a href="<?php echo base_url()."member/query_list"; ?>" class="btn btn-primary">Query List</a></li>
                <?php //} ?>
            </ul>
        </nav>
    </div>