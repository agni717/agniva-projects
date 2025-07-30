<script>
	//$(".treeview-menu a").click(function() {
    //$('a').removeClass('active');
    //$(".treeview").addClass("active");
    //$(this).addClass("active");
//});
$(function(){
	$('#backto_module_select').click(function(){
      	$( "#form_backmadule" ).submit();
     });
});
</script>

<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url().'bootstrap-admin/dist/img/administrator.png'; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $u_details->firstname.' '.$u_details->lastname; ?></p>

              <a href="javascript:;"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <?php $utype = $this->session->userdata['utype']; ?>
		  
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo site_url('admincontrol/dashboard'); ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <?php if($utype == 1 || $utype == 3 || $this->session->userdata['uid'] == 37) 
            { ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i> <span>Administrator</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php if($utype == 1 || $this->session->userdata['uid'] == 37){ ?>
                <li><a href="<?= site_url('admincontrol/dashboard/administrator') ?>"><i class="fa fa-circle-o text-warning"></i>User List</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/add_administrator') ?>"><i class="fa fa-circle-o text-warning"></i>Add New User</a></li>
              <?php } 
                if($utype == 1 || $utype == 3){ ?>
                <li><a href="<?= site_url('admincontrol/dashboard/checker_monitoring_section') ?>"><i class="fa fa-circle-o text-warning"></i>Checker Monitoring</a></li>
                <?php }
                if($utype == 1){ ?>
                <li><a href="<?= site_url('admincontrol/dashboard/checker_checking_section') ?>"><i class="fa fa-circle-o text-warning"></i>Checker Checking</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/checker_mail_sending_section') ?>"><i class="fa fa-circle-o text-warning"></i>Checker Mail Send</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/checker_reversing_check_section') ?>"><i class="fa fa-circle-o text-warning"></i>Checker Reverse Monitor</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/all_checker_monitoring_section') ?>"><i class="fa fa-circle-o text-warning"></i>All Checker Datewise Monitor</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/checker_datewise_total_checking') ?>"><i class="fa fa-circle-o text-warning"></i>Datewise Work Monitor</a></li>
                <li><a href="<?= site_url('admincontrol/dashboard/final_checking_complition_check') ?>"><i class="fa fa-circle-o text-warning"></i>Pending Checking List</a></li>
                <?php } ?>
              </ul>
            </li>
            <?php }
            if($utype == 1){ ?>

			<li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Master Data</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/masterdata/recruitment_list') ?>"><i class="fa fa-circle-o text-warning"></i> Recruitment List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_recruitment') ?>"><i class="fa fa-circle-o text-warning"></i> Add Recruitment</a></li>
				<li><a href="<?= site_url('admincontrol/masterdata/discipline_list') ?>"><i class="fa fa-circle-o text-warning"></i> Discipline List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_discipline') ?>"><i class="fa fa-circle-o text-warning"></i> Add Discipline</a></li>
				<li><a href="<?= site_url('admincontrol/masterdata/examination_list') ?>"><i class="fa fa-circle-o text-warning"></i> Qualification List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_examination') ?>"><i class="fa fa-circle-o text-warning"></i> Add Qualification</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/caste_community_list') ?>"><i class="fa fa-circle-o text-warning"></i> Caste Community List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_caste_community') ?>"><i class="fa fa-circle-o text-warning"></i> Add Caste Community</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/caste_issuing_authority_list') ?>"><i class="fa fa-circle-o text-warning"></i> Caste Isuue Authority List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_ci_authority') ?>"><i class="fa fa-circle-o text-warning"></i> Add Caste Isuue Authority</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/age_relaxation_list') ?>"><i class="fa fa-circle-o text-warning"></i> Age Relaxation List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_age_relaxation') ?>"><i class="fa fa-circle-o text-warning"></i> Add Age Relaxation</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/experience_section_list') ?>"><i class="fa fa-circle-o text-warning"></i> Experience List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_master_experience_section') ?>"><i class="fa fa-circle-o text-warning"></i> Add Experience</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/subdivision_list') ?>"><i class="fa fa-circle-o text-warning"></i> Sub-Division List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_subdivision') ?>"><i class="fa fa-circle-o text-warning"></i> Add Sub-Division</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/block_muni_list') ?>"><i class="fa fa-circle-o text-warning"></i> Block/ Muni List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_block_muni') ?>"><i class="fa fa-circle-o text-warning"></i> Add Block/ Muni</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/policestation_list') ?>"><i class="fa fa-circle-o text-warning"></i> Police Station List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_policestation') ?>"><i class="fa fa-circle-o text-warning"></i> Add Police Station</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/venue_list') ?>"><i class="fa fa-circle-o text-warning"></i> Venue List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_venueset') ?>"><i class="fa fa-circle-o text-warning"></i> Add Venue</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/all_shift_list') ?>"><i class="fa fa-circle-o text-warning"></i> Shift List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_shift') ?>"><i class="fa fa-circle-o text-warning"></i> Add Shift</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/interviewrules_list') ?>"><i class="fa fa-circle-o text-warning"></i> Rule List</a></li>
                <li><a href="<?= site_url('admincontrol/masterdata/add_new_rules') ?>"><i class="fa fa-circle-o text-warning"></i> Add Rule</a></li>
              </ul>
            </li>
            <?php }
            $userlistset = array(25,26,27,28,151,153,154,155);
            if($utype == 1 || in_array($this->session->userdata['uid'], $userlistset)){ ?>
			<li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Advertisement</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/advertisement_set/all_advertisement_list') ?>"><i class="fa fa-circle-o text-warning"></i> Advertisement List</a></li>
                <li><a href="<?= site_url('admincontrol/advertisement_set/add_new_advertisement') ?>"><i class="fa fa-circle-o text-warning"></i> Add Advertisement</a></li>
                <?php if($utype == 1){ ?>
                <li><a href="<?= site_url('admincontrol/advertisement_set/resubmit_process_list') ?>"><i class="fa fa-circle-o text-warning"></i> Re-Submission Process List</a></li>
                <li><a href="<?= site_url('admincontrol/advertisement_set/resubmit_process_for_advertisement') ?>"><i class="fa fa-circle-o text-warning"></i> Add New Re-Submission</a></li>
                <?php } ?>
              </ul>
            </li>
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-paste"></i>
                <span>CMS</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				<li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> List of Menu</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Add New Menu</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> List of Page</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Add New Page</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> List of Document</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Add New Doc</a></li>
              </ul>
            </li>-->
            <?php } ?>
            <?php if($utype >= 1 && $utype <= 3){ ?>
			<li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Candidates</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if($utype == 1){ ?>
                <li><a href="<?= site_url('admincontrol/candidates/comp_application_list') ?>"><i class="fa fa-circle-o text-warning"></i> Application List</a></li>
                <!--<li><a href="<?= site_url('admincontrol/candidates/final_approval_list') ?>"><i class="fa fa-circle-o text-warning"></i> Approval List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/admit_card_issued_list') ?>"><i class="fa fa-circle-o text-warning"></i> AdmitCard List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/final_for_empanel_list') ?>"><i class="fa fa-circle-o text-warning"></i> Complition List</a></li>-->
                <?php }elseif($utype == 2){ ?>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_app_list') ?>"><i class="fa fa-circle-o text-warning"></i> Application List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_skipped_list') ?>"><i class="fa fa-circle-o text-warning"></i> Skip Application List</a></li>
                <?php }elseif($utype == 3){ ?>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_approve_list') ?>"><i class="fa fa-circle-o text-warning"></i> Approve List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_approve_skip_list') ?>"><i class="fa fa-circle-o text-warning"></i> Approve Skip List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_approve_return_list') ?>"><i class="fa fa-circle-o text-warning"></i> Approve Return List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_reject_list') ?>"><i class="fa fa-circle-o text-warning"></i> Reject List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_reject_skip_list') ?>"><i class="fa fa-circle-o text-warning"></i> Reject Skip List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_reject_return_list') ?>"><i class="fa fa-circle-o text-warning"></i> Reject Return List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_doubtful_list') ?>"><i class="fa fa-circle-o text-warning"></i> Doubtful List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_doubtful_skip_list') ?>"><i class="fa fa-circle-o text-warning"></i> Doubtful Skip List</a></li>
                <li><a href="<?= site_url('admincontrol/candidates/candidate_doubtful_return_list') ?>"><i class="fa fa-circle-o text-warning"></i> Doubtful Return List</a></li>
                <?php } ?>
              </ul>
            </li>
            <?php } ?>
            <?php if($utype == 4){ ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i>
                <span>Candidates</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/checker_set/mobile_no_verify') ?>"><i class="fa fa-circle-o text-warning"></i> Application List</a></li>
                <li><a href="<?= site_url('admincontrol/checker_set/candi_chk3_skipped_list') ?>"><i class="fa fa-circle-o text-warning"></i> Skip Application List</a></li>
                <li><a href="<?= site_url('admincontrol/checker_set/candidate_returned_list') ?>"><i class="fa fa-circle-o text-warning"></i> Return Application List</a></li>
                
              </ul>
            </li>
            <?php } ?>
            <?php if($utype == 1){ ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pencil"></i>
                <span>Interview</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/dashboard/after_finalprocess_candidatestatus_list') ?>"><i class="fa fa-circle-o text-warning"></i> FinalCheck Complition List</a></li>
                <li><a href="<?= site_url('admincontrol/interview/interview_panelcandidate_segrigation') ?>"><i class="fa fa-circle-o text-warning"></i> InterView Panel Creation</a></li>
                <li><a href="<?= site_url('admincontrol/interview/interview_panelcandidate_tablewise_list') ?>"><i class="fa fa-circle-o text-warning"></i> Tablewise Candidate list</a></li>
                <li><a href="<?= site_url('admincontrol/interview/interview_attendance_shiftwise_list') ?>"><i class="fa fa-circle-o text-warning"></i> Shiftwise Attendance list</a></li>
              </ul>
            </li>
            <?php } ?>
            <?php if($utype == 1 || $utype == 5){ ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-paste"></i>
                <span>Candidate Registration</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/application_set') ?>"><i class="fa fa-circle-o text-warning"></i> Search Candidate</a></li>
              </ul>
            </li>
            <?php } ?>
            <?php if($utype == 2){ ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pencil"></i>
                <span>Interview Marks</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/movement/gotoset_candidate_marks_tablewise') ?>"><i class="fa fa-circle-o text-warning"></i>Insert Interview Marks</a></li>
                <li><a href="<?= site_url('admincontrol/movement/getall_return_marksmodification_list') ?>"><i class="fa fa-circle-o text-warning"></i>Return Interview Mark List</a></li>
              </ul>
            </li>
            <?php } ?>
            <?php if($utype == 3){ ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pencil"></i>
                <span>Interview Marks</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('admincontrol/movement/finalcheck_for_interviewmarks_bychecker') ?>"><i class="fa fa-circle-o text-warning"></i>Check Interview Marks</a></li>
                <li><a href="<?= site_url('admincontrol/movement/getall_revertset_marksmodification_list') ?>"><i class="fa fa-circle-o text-warning"></i>Return Interview Mark List</a></li>
              </ul>
            </li>
            <?php } ?>
			<!--<li class="treeview">
              <a href="#">
                <i class="fa fa-comments-o"></i>
                <span>Forum</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Query List</a></li>
              </ul>
            </li>-->
			
			
            <?php //if($this->session->userdata['utype'] <= 10){ ?>
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-book"></i>
                <span>Works</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> List of Work</a></li>
                <?php if($this->session->userdata['utype'] == 10){ ?>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Add New Work</a></li>
                <?php } ?>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Work Allocate</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <?php if($utype == 6){ ?>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Allocate Work</a></li>
              <?php } ?>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Work List</a></li>
              </ul>
            </li>
            <?php //} ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-paste"></i>
                <span>Work Progress</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-warning"></i> Work Progress List</a></li>
              </ul>
            </li>-->
            
            
            
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Report</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Advice List</a></li>
              	<li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Cheque List</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Advice List Datewise</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Bank Reports Datewise</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Client Paymnet History</a></li>
                <li><a href="<?= site_url('') ?>"><i class="fa fa-circle-o text-danger"></i> Search Payment</a></li>
              </ul>
            </li>-->
            
            
            
            
            
            
            
        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
