<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	
	public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
        
    }
	
    public function index() {
		
        $this->load->view('admin/main', $this->data);
    }
    
	public function logout() {
		$this->session->sess_destroy();
        redirect('Admin_access');
    }
	
	//========================================= Implementing Agency (DM Office) List =====================================
	public function administrator(){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		$this->data['userlist'] = $this->admin_m->searchallAdminUser();
		$this->load->view('admin/subadmin_list', $this->data);
	}

	//============================================ Implementing Agency Creation (Block/Municipality) ==================================
	public function add_administrator(){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if ($_POST){
			$user_type = $this->input->post("user_type");
            $f_name = $this->input->post("fname");
            $l_name = $this->input->post("lname");
            $u_district = $this->input->post("u_district");
            $u_block = $this->input->post("u_block");
            $email_id = $this->input->post("emailid");
            $address = $this->input->post('u_address');
			$mobile = $this->input->post('u_mobile');
			//================================================
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('u_district', 'District', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('u_block', 'Block', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|valid_email');
            //$this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|is_unique[user_info.email]', array('is_unique' => 'You must provide a Proper Unique Email Id.'));
            $this->form_validation->set_rules('u_address', 'Address', 'trim');
			$this->form_validation->set_rules('u_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
            if ($this->form_validation->run() == TRUE) {
				$mob_chk = $this->admin_m->check_Checker_mobile_exist($mobile);
				// $dist_chk = $this->admin_m->check_Checker_District_exist($u_district);
				//$email_chk = $this->admin_m->check_Checker_email_exist($email_id);
				// if($mob_chk == TRUE && $dist_chk == TRUE){
				if($mob_chk == TRUE){  //========================== Duplicate Mobile Number Checking ==================
					date_default_timezone_set("Asia/Kolkata");
					$row = array(
						'u_type' => $user_type,
						'mobile' => $mobile,
						'email' => $email_id,
						'firstname' => $f_name,
						'lastname' => $l_name,
						'u_dist' => $u_district,
						'u_block' => $u_block,
						'user_createdate' => date('Y-m-d H:i:s'),
						'modify_date' => date('Y-m-d H:i:s')
					);
					if(trim($address) == ""){
						$address = NULL;
					}
					$row1 = array(
						'address' => $address,
					);
					if ($this->admin_m->saveNewUser($row, $row1)){
						$this->session->set_flashdata("success","User is Created successfully.");
						redirect('admincontrol/dashboard/administrator','refresh');
					}else{
						$this->data["error"] = "There is an error. Please try again";
					}
				}else{
					// $this->data["error"] = "Mobile Number OR District already Exist, Check it again.";
					$this->data["error"] = "Mobile Number already Exist, Check it again.";
				}
            }
		}
		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->where('district_status = 1')->get("district_master")->result();
		$this->data["utype_list"] = $this->db->where('mu_id > 2 AND mu_status = 1')->get("master_user_type")->result();
		$this->load->view('admin/add_subadmin_user', $this->data);
	}

	public function district_executive_list(){
		if($this->session->userdata['utype'] < 4){		
			if($this->session->userdata['udistcode'] != 0){
				$this->data['dist_executive_list'] = $this->admin_m->getAllExecutiveByDistrictCode($this->session->userdata['udistcode']);
			}
		}else{
			redirect('admincontrol/dashboard');
		}
		$this->load->view('admin/district_executive_list', $this->data);
	}

	public function add_district_executive(){
		if($this->session->userdata['utype'] > 3){
			redirect('admincontrol/dashboard');
		}
		if ($_POST)
		{
            $f_name = $this->input->post("fname");
            $l_name = $this->input->post("lname");
            $u_district = $this->input->post("u_district");
            $user_type = $this->input->post("u_type");
            $email_id = $this->input->post("emailid");
            $address = $this->input->post('u_address');
			$mobile = $this->input->post('u_mobile');
			
			$u_account_no = $this->input->post("u_account_no");
			$u_bankname = $this->input->post("u_bankname");
			$u_branch_name = $this->input->post("u_branch_name");
			$u_ifsc = $this->input->post("u_ifsc");
			/*$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			$pr_lvl = $this->input->post("pr_lvl");
			$setall_lvl = $this->input->post("setall_lvl");
			$u_adv = $this->input->post("u_adv[]");
			$invitey_mobile = $this->input->post('invitey_mobile');
			$state = $this->input->post('u_state');
			$city = $this->input->post('u_city');
			$pincode = $this->input->post('u_pincode');*/
			
			//$this->form_validation->set_rules('u_adv[]', 'Advertisement', 'trim|required');
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('u_district', 'District', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('u_type', 'User Type', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|valid_email');
            //$this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|is_unique[user_info.email]', array('is_unique' => 'You must provide a Proper Unique Email Id.'));
            $this->form_validation->set_rules('u_address', 'Address', 'trim');
			$this->form_validation->set_rules('u_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
			/*$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');
			if($user_type >= 2 && $user_type <= 4){
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim|required');
				if($user_type == 4){
					$this->form_validation->set_rules('invitey_mobile', 'Witness Mobile No.', 'trim|required|exact_length[10]|is_natural');
				}
			}else{
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim');
			}
			$this->form_validation->set_rules('setall_lvl', 'Select All Permit Level', 'trim');
			
            $this->form_validation->set_rules('u_state', 'State', 'trim');
            $this->form_validation->set_rules('u_city', 'City', 'trim');
            $this->form_validation->set_rules('u_pincode', 'Pincode', 'trim');*/
            //print_r($setall_lvl);
			//echo "22222";exit;
            if ($this->form_validation->run() == TRUE) {
						
				$mob_chk = $this->admin_m->check_Checker_mobile_exist($mobile);
				if($this->session->userdata['utype'] < 3){
					$dist_chk = $this->admin_m->check_Checker_District_exist($u_district);
				}
				elseif($this->session->userdata['utype'] > 3){
					$dist_chk = FALSE;
				}
				elseif($this->session->userdata['utype'] == 3){
					$dist_chk = TRUE;
				}
				//$email_chk = $this->admin_m->check_Checker_email_exist($email_id);
				if($mob_chk == TRUE && $dist_chk == TRUE){
				
					date_default_timezone_set("Asia/Kolkata");
					$row = array(
						'u_type' => $user_type,
						'mobile' => $mobile,
						'email' => $email_id,
						'firstname' => $f_name,
						'lastname' => $l_name,
						'u_dist' => $u_district,
						'user_createdate' => date('Y-m-d H:i:s'),
						'modify_date' => date('Y-m-d H:i:s')
					);
					if(trim($address) == ""){$address = NULL;}
					if(trim($u_account_no) == ""){$u_account_no = NULL;}
					if(trim($u_bankname) == ""){$u_bankname = NULL;}
					if(trim($u_branch_name) == ""){$u_branch_name = NULL;}
					if(trim($u_ifsc) == ""){$u_ifsc = NULL;}
					$row1 = array(
						'address' => $address,
						'u_account_no' => $u_account_no,
						'u_bank_name' => $u_bankname,
						'u_branch_name' => $u_branch_name,
						'u_ifsc_code' => $u_ifsc
					);
					
					if ($this->admin_m->saveNewUser($row, $row1))
					{
						/*$getcreateusr_id = $this->db->get_where('user_info',array('u_type'=>$user_type, 'mobile'=>$mobile, 'email' => $email_id, 'user_status'=>1))->row()->u_id;
						$row3 = array(
							'usr_md_masterid' => $getcreateusr_id,
							'usr_md_type' => $user_type,
							'usr_md_mobile' => $mobile,
							'usr_md_email' => $email_id,
							'usr_full_name' => ($f_name.' '.$l_name),
							'usr_s_date' => $ss_date,
							'usr_e_date' => $ee_date,
							'usr_s_time' => $ss_time,
							'usr_e_time' => $ee_time,
							'usr_md_post' => $advlist,
							'usr_md_access' => $permissionstring,
							'usr_md_invity' => $invitey_mobile,
							'usr_md_crdate' => date('Y-m-d H:i:s')
						);
						$this->admin_m->saveNewUpdate_User_log($row3);

						$this->sendmailtemplates($getcreateusr_id);*/

						$this->session->set_flashdata("success","User is Created successfully.");
						redirect('admincontrol/dashboard/district_executive_list','refresh');
					}
					else{
						$this->data["error"] = "There is an error. Please try again";
					}
					
				}else{
					$this->data["error"] = "Mobile Number already Exist, Check it again.";
				}

            }
		}
		
		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->where('district_status = 1')->where('district_code', $this->session->userdata['udistcode'])->get("district_master")->result();
		$this->data["utype_list"] = $this->db->where('mu_id = 4 AND mu_status = 1')->get("master_user_type")->result();
		$this->load->view('admin/add_district_executive', $this->data);
	}
	
	public function lock_user($uid){
		if($this->session->userdata['utype'] > 2){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		$cng_status = 0;
		if($this->admin_m->change_user_status($uid, $cng_status) == TRUE)
		{
			$this->session->set_flashdata("success","User is Locked successfully");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
	}

	public function lock_district_executive($uid){
		if($this->session->userdata['utype'] > 3){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		$cng_status = 0;
		if($this->admin_m->change_user_status($uid, $cng_status) == TRUE)
		{
			$this->session->set_flashdata("success","User is Locked successfully");
		    redirect('admincontrol/dashboard/district_executive_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/dashboard/district_executive_list','refresh');
		}
	}
	
	public function unlock_user($uid){
		if($this->session->userdata['utype'] > 2){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		$cng_status = 1;
		if($this->admin_m->change_user_status($uid, $cng_status) == TRUE)
		{
			$this->session->set_flashdata("success","User is Unlocked successfully");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
	}

	public function unlock_district_executive($uid){
		if($this->session->userdata['utype'] > 3){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		$cng_status = 1;
		if($this->admin_m->change_user_status($uid, $cng_status) == TRUE)
		{
			$this->session->set_flashdata("success","User is Unlocked successfully");
		    redirect('admincontrol/dashboard/district_executive_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/dashboard/district_executive_list','refresh');
		}
	}
	
	public function delete_userddddasdasd($uid){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($this->db->delete('user_info', array('u_id' => $uid)))
		{
			$this->db->delete('user_details', array('uid' => $uid));
			$this->session->set_flashdata("success","User is Removed successfully");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/dashboard/administrator','refresh');
		}
	}
	
	public function edit_user($uid = NULL){

		if($this->session->userdata['utype'] > 2){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		if($uid == NULL){
			redirect('admincontrol/dashboard/administrator');
		}

		if ($_POST)
		{
            $f_name = $this->input->post("fname");
            $l_name = $this->input->post("lname");
            $u_district = $this->input->post("u_district");
            $user_type = $this->input->post("u_type");
            $email_id = $this->input->post("emailid");
            $address = $this->input->post('u_address');
			$mobile = $this->input->post('u_mobile');
			
			$u_account_no = $this->input->post("u_account_no");
			$u_bankname = $this->input->post("u_bankname");
			$u_branch_name = $this->input->post("u_branch_name");
			$u_ifsc = $this->input->post("u_ifsc");
			/*$state = $this->input->post('u_state');
			$city = $this->input->post('u_city');
			$pincode = $this->input->post('u_pincode');*/
			
			//$this->form_validation->set_rules('u_adv[]', 'Advertisement', 'trim|required');
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('u_district', 'District', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('u_type', 'User Type', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|valid_email');
            //$this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|is_unique[user_info.email]', array('is_unique' => 'You must provide a Proper Unique Email Id.'));
            $this->form_validation->set_rules('u_address', 'Address', 'trim');
			$this->form_validation->set_rules('u_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
			/*$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');
			if($user_type >= 2 && $user_type <= 4){
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim|required');
				if($user_type == 4){
					$this->form_validation->set_rules('invitey_mobile', 'Witness Mobile No.', 'trim|required|exact_length[10]|is_natural');
				}
			}else{
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim');
			}
			$this->form_validation->set_rules('setall_lvl', 'Select All Permit Level', 'trim');
			
            $this->form_validation->set_rules('u_state', 'State', 'trim');
            $this->form_validation->set_rules('u_city', 'City', 'trim');
            $this->form_validation->set_rules('u_pincode', 'Pincode', 'trim');*/
            
			
            if ($this->form_validation->run() == TRUE) {

				if($uid != NULL){
					$udata = $this->admin_m->get_user_data_by_id($uid);
				}

				if($udata->u_type == 3){
					$dist_chk = $this->admin_m->check_Checker_District_exist($u_district, $uid, $udata->u_type);
				}
				else{
					$dist_chk = TRUE;
				}

				$mob_chk = $this->admin_m->check_Checker_mobile_exist($mobile, $uid);
				
				if($mob_chk == TRUE && $dist_chk == TRUE){
					
						date_default_timezone_set("Asia/Kolkata");
						$row = array(
							'u_type' => $user_type,
							'mobile' => $mobile,
							'email' => $email_id,
							'firstname' => $f_name,
							'lastname' => $l_name,
							'u_dist' => $u_district,
							'modify_date' => date('Y-m-d H:i:s')
						);
						if(trim($address) == ""){$address = NULL;}
						if(trim($u_account_no) == ""){$u_account_no = NULL;}
						if(trim($u_bankname) == ""){$u_bankname = NULL;}
						if(trim($u_branch_name) == ""){$u_branch_name = NULL;}
						if(trim($u_ifsc) == ""){$u_ifsc = NULL;}
						$row1 = array(
							'address' => $address,
							'u_account_no' => $u_account_no,
							'u_bank_name' => $u_bankname,
							'u_branch_name' => $u_branch_name,
							'u_ifsc_code' => $u_ifsc
						);
									
						if ($this->admin_m->UpdateSavedUser($row, $row1, $uid) == TRUE)
						{
							/*$row3 = array(
								'usr_md_masterid' => $uid,
								'usr_md_type' => $user_type,
								'usr_md_mobile' => $mobile,
								'usr_md_email' => $email_id,
								'usr_full_name' => ($f_name.' '.$l_name),
								'usr_s_date' => $ss_date,
								'usr_e_date' => $ee_date,
								'usr_s_time' => $ss_time,
								'usr_e_time' => $ee_time,
								'usr_md_post' => $advlist,
								'usr_md_access' => $permissionstring,
								'usr_md_invity' => $invitey_mobile,
								'usr_md_crdate' => date('Y-m-d H:i:s')
							);
							$this->admin_m->saveNewUpdate_User_log($row3);

							$this->sendmailtemplates($uid);*/
							
							$this->session->set_flashdata("success","User Details is Updated successfully");
							redirect('admincontrol/dashboard/administrator');
						}else{
							$this->data["error"] = "There is an error. Please try again";
						}	
						
					
				}else{
					$this->data["error"] = "Mobile Number Or District already Exist, Check it again.";
				}
            }
		}
		
		//$this->data["branchlist"] = $this->db->get_where("govorder_branch", array("b_status" => '1'))->result();
		//$this->data['adv_list'] = $this->admin_m->getAlllist_ofActive_Advertisement();
		//$this->data['prevlog_list'] = $this->admin_m->getAlllist_ofPrev_log_UserSections($uid);
		//$this->data['all_adv_list'] = $this->admin_m->getAlllist_ofInactive_Active_Advertisement();
		$this->data["data_list"] = $this->db->get_where("user_views", array("u_id" => $uid))->row();
		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->where('district_status = 1')->get("district_master")->result();
		$this->data["utype_list"] = $this->db->where('mu_id > 2 AND mu_status = 1')->get("master_user_type")->result();
		$this->load->view('admin/edit_user', $this->data);
	}

	public function edit_district_executive($uid = NULL){
		if($this->session->userdata['utype'] > 3){
			//if($this->session->userdata['uid'] != 37){
				redirect('admincontrol/dashboard');
			//}
		}
		if($uid == NULL){
			redirect('admincontrol/dashboard/district_executive_list');
		}
		
		$udata = $this->admin_m->get_user_data_by_id($uid);
		if($this->session->userdata['udistcode'] != $udata->u_dist){
			redirect('admincontrol/dashboard/district_executive_list');
		}
		if ($_POST)
		{
            $f_name = $this->input->post("fname");
            $l_name = $this->input->post("lname");
            $u_district = $this->input->post("u_district");
            $user_type = $this->input->post("u_type");
            $email_id = $this->input->post("emailid");
            $address = $this->input->post('u_address');
			$mobile = $this->input->post('u_mobile');
			
			$u_account_no = $this->input->post("u_account_no");
			$u_bankname = $this->input->post("u_bankname");
			$u_branch_name = $this->input->post("u_branch_name");
			$u_ifsc = $this->input->post("u_ifsc");
			/*$state = $this->input->post('u_state');
			$city = $this->input->post('u_city');
			$pincode = $this->input->post('u_pincode');*/
			
			//$this->form_validation->set_rules('u_adv[]', 'Advertisement', 'trim|required');
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('u_district', 'District', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('u_type', 'User Type', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|valid_email');
            //$this->form_validation->set_rules('emailid', 'Email ID', 'trim|required|is_unique[user_info.email]', array('is_unique' => 'You must provide a Proper Unique Email Id.'));
            $this->form_validation->set_rules('u_address', 'Address', 'trim');
			$this->form_validation->set_rules('u_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
			/*$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');
			if($user_type >= 2 && $user_type <= 4){
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim|required');
				if($user_type == 4){
					$this->form_validation->set_rules('invitey_mobile', 'Witness Mobile No.', 'trim|required|exact_length[10]|is_natural');
				}
			}else{
				$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim');
			}
			$this->form_validation->set_rules('setall_lvl', 'Select All Permit Level', 'trim');
			
            $this->form_validation->set_rules('u_state', 'State', 'trim');
            $this->form_validation->set_rules('u_city', 'City', 'trim');
            $this->form_validation->set_rules('u_pincode', 'Pincode', 'trim');*/
            
            if ($this->form_validation->run() == TRUE) {

				$mob_chk = $this->admin_m->check_Checker_mobile_exist($mobile, $uid);

				if($this->session->userdata['utype'] < 3){
					$dist_chk = $this->admin_m->check_Checker_District_exist($u_district, $uid);
				}
				elseif($this->session->userdata['utype'] > 3){
					$dist_chk = FALSE;
				}
				elseif($this->session->userdata['utype'] == 3){
					$dist_chk = TRUE;
				}

				if($mob_chk == TRUE && $dist_chk == TRUE){
					
						date_default_timezone_set("Asia/Kolkata");
						$row = array(
							'u_type' => $user_type,
							'mobile' => $mobile,
							'email' => $email_id,
							'firstname' => $f_name,
							'lastname' => $l_name,
							'u_dist' => $u_district,
							'modify_date' => date('Y-m-d H:i:s')
						);
						if(trim($address) == ""){$address = NULL;}
						if(trim($u_account_no) == ""){$u_account_no = NULL;}
						if(trim($u_bankname) == ""){$u_bankname = NULL;}
						if(trim($u_branch_name) == ""){$u_branch_name = NULL;}
						if(trim($u_ifsc) == ""){$u_ifsc = NULL;}
						$row1 = array(
							'address' => $address,
							'u_account_no' => $u_account_no,
							'u_bank_name' => $u_bankname,
							'u_branch_name' => $u_branch_name,
							'u_ifsc_code' => $u_ifsc
						);
									
						if ($this->admin_m->UpdateSavedUser($row, $row1, $uid) == TRUE)
						{
							/*$row3 = array(
								'usr_md_masterid' => $uid,
								'usr_md_type' => $user_type,
								'usr_md_mobile' => $mobile,
								'usr_md_email' => $email_id,
								'usr_full_name' => ($f_name.' '.$l_name),
								'usr_s_date' => $ss_date,
								'usr_e_date' => $ee_date,
								'usr_s_time' => $ss_time,
								'usr_e_time' => $ee_time,
								'usr_md_post' => $advlist,
								'usr_md_access' => $permissionstring,
								'usr_md_invity' => $invitey_mobile,
								'usr_md_crdate' => date('Y-m-d H:i:s')
							);
							$this->admin_m->saveNewUpdate_User_log($row3);

							$this->sendmailtemplates($uid);*/
							
							$this->session->set_flashdata("success","User Details is Updated successfully");
							redirect('admincontrol/dashboard/district_executive_list');
						}else{
							$this->data["error"] = "There is an error. Please try again";
						}	
						
					
				}else{
					$this->data["error"] = "Mobile Number Exist, Check it again.";
				}
            }
		}
		
		//$this->data["branchlist"] = $this->db->get_where("govorder_branch", array("b_status" => '1'))->result();
		//$this->data['adv_list'] = $this->admin_m->getAlllist_ofActive_Advertisement();
		//$this->data['prevlog_list'] = $this->admin_m->getAlllist_ofPrev_log_UserSections($uid);
		//$this->data['all_adv_list'] = $this->admin_m->getAlllist_ofInactive_Active_Advertisement();
		
		$this->data["data_list"] = $this->db->get_where("user_views", array("u_id" => $uid))->row();
		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->where('district_status = 1')->where('district_code', $this->session->userdata['udistcode'])->get("district_master")->result();
		$this->data["utype_list"] = $this->db->where('mu_id = 4 AND mu_status = 1')->get("master_user_type")->result();
		
		$this->load->view('admin/edit_district_executive', $this->data);
	}

	public function permit_user6568767868($uid = NULL){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($uid == NULL){
			redirect('admincontrol/dashboard/administrator');
		}
		if($_POST){
			$p_type = $this->input->post("p_type");
            $pr_lvl = $this->input->post("pr_lvl");
			$this->form_validation->set_rules('p_type', 'Permit Application', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim|required');
			
            if($this->form_validation->run() == TRUE) {
				$row = array(
					'up_master_user' => $uid,
					'up_application' => $p_type,
					'up_createdate' => date('Y-m-d H:i:s'),
					'up_createby' => $this->session->userdata['uid']
				);
				foreach($pr_lvl as $per_lvls){
					if($per_lvls == "View"){$row['up_view'] = 1;}
					if($per_lvls == "Add"){$row['up_add'] = 1;}
					if($per_lvls == "Edit"){$row['up_edit'] = 1;}
					if($per_lvls == "Delete"){$row['up_delete'] = 1;}
				}
				
				if ($this->admin_m->permission_Inserted_DB($row) == TRUE)
				{
					$this->session->set_flashdata("success","Permission is Added successfully.");
					redirect('admincontrol/dashboard/permit_user/'.$uid,'refresh');
				}
				else{
					$this->data["error"] = "There is an error to insert DB. Please try again";
				}
			}
		}
		$u_permit = $this->db->distinct()->select('up_application')->get_where("user_permission_tab",array("up_master_user"=>$uid))->result();
		if(count($u_permit) > 0){
			$app_array = array();
			foreach($u_permit as $pers){
				$app_array[] = $pers->up_application;
			}
			$this->data["per_appli"] = $this->db->order_by('papp_name','ASC')->where_not_in("papp_id",$app_array)->where("papp_status",1)->get("permit_application")->result();
		}else{
			$this->data["per_appli"] = $this->db->order_by('papp_name','ASC')->get_where("permit_application", array("papp_status" => 1))->result();
		}
		$this->data["current_permit"] = $this->admin_m->get_all_permitApplication_details($uid);
		$this->data["current_user"] = $this->db->get_where("user_views", array("u_id" => $uid))->row();
		//echo "<pre>";
		//print_r($this->data["current_permit"]);exit;
		$this->load->view('admin/permission_user', $this->data);
	}
	
	public function delete_permit345346454576457($uid = NULL, $pid = NULL){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($uid == NULL || $pid == NULL){
			redirect('admincontrol/dashboard/administrator');
		}
		if($this->db->delete('user_permission_tab', array('up_master_user' => $uid, 'up_id' => $pid)))
		{
			$this->session->set_flashdata("success","Permission is Removed successfully");
		    redirect('admincontrol/dashboard/permit_user/'.$uid,'refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem to Delete from DB. Please try again.");
		    redirect('admincontrol/dashboard/permit_user/'.$uid,'refresh');
		}
	}

	public function all_user_permit45645457567567(){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$user_sets = $this->input->post("user_sets");
			$p_type = $this->input->post("p_type");
            $pr_lvl = $this->input->post("pr_lvl");
			
			$this->form_validation->set_rules('user_sets[]', 'User List', 'trim|required');
			$this->form_validation->set_rules('p_type', 'Permit Application', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('pr_lvl[]', 'Permit Level', 'trim|required');
			
            if($this->form_validation->run() == TRUE) {
				$all_check = 0;
				foreach($user_sets as $users){
					if($this->admin_m->permission_Exist_inDB_forUser($p_type, $users) == TRUE){
						$permit_id = $this->db->get_where("user_permission_tab", array("up_master_user" => $users, "up_application" => $p_type))->row()->up_id;
						$row = array(
							'up_modifydate' => date('Y-m-d H:i:s'),
							'up_modifyby' => $this->session->userdata['uid']
						);
						foreach($pr_lvl as $per_lvls){
							if($per_lvls == "View"){$row['up_view'] = 1;}
							if($per_lvls == "Add"){$row['up_add'] = 1;}
							if($per_lvls == "Edit"){$row['up_edit'] = 1;}
							if($per_lvls == "Delete"){$row['up_delete'] = 1;}
						}
						if(empty($row['up_view'])){$row['up_view'] = 0;}
						if(empty($row['up_add'])){$row['up_add'] = 0;}
						if(empty($row['up_edit'])){$row['up_edit'] = 0;}
						if(empty($row['up_delete'])){$row['up_delete'] = 0;}
						if ($this->admin_m->permission_Inserted_DB($row, $permit_id) == FALSE)
						{
							$all_check++;
						}
					}else{
						$row2 = array(
							'up_master_user' => $users,
							'up_application' => $p_type,
							'up_createdate' => date('Y-m-d H:i:s'),
							'up_createby' => $this->session->userdata['uid']
						);
						foreach($pr_lvl as $per_lvls){
							if($per_lvls == "View"){$row2['up_view'] = 1;}
							if($per_lvls == "Add"){$row2['up_add'] = 1;}
							if($per_lvls == "Edit"){$row2['up_edit'] = 1;}
							if($per_lvls == "Delete"){$row2['up_delete'] = 1;}
						}
						
						if ($this->admin_m->permission_Inserted_DB($row2) == FALSE)
						{
							$all_check++;
						}
					}
				}
				if($all_check == 0){
					$this->session->set_flashdata("success","Permission is Added or Updated successfully.");
					redirect('admincontrol/dashboard/all_user_permit','refresh');
				}else{
					$this->data["error"] = "There is an error to insert or update DB. Total ".$all_check." error occured.";
				}
			}
		}
		$this->data["per_appli"] = $this->db->order_by('papp_name','ASC')->get_where("permit_application", array("papp_status" => 1))->result();
		$this->data["user_lsit"] = $this->db->order_by('firstname','ASC')->get_where("user_views", array("u_id != " => 1, "status" => '1'))->result();
		//echo "<pre>";
		//print_r($this->data["current_permit"]);exit;
		$this->load->view('admin/permission_all_user', $this->data);
	}

	public function profile(){
		$this->data["usr_detail"] = $this->db->get_where("user_views", array("u_id" => $this->session->userdata['uid']))->row();
		$this->data["utype_list"] = $this->db->where('mu_id != 1 AND mu_status = 1')->get("master_user_type")->result();
		$this->load->view('admin/profile/profile_view', $this->data);
	}
	
	public function editprofile(){
		if ($this->input->post("submit"))
		{
            $f_name = $this->input->post("fname");
            $l_name = $this->input->post("lname");
            
            $address = $this->input->post('u_address');
			/*$mobile = $this->input->post('u_mobile');
			$country = $this->input->post('u_country');
			$state = $this->input->post('u_state');
			$city = $this->input->post('u_city');
			$pincode = $this->input->post('u_pincode');*/
            
            $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
            
            $this->form_validation->set_rules('u_address', 'Address', 'trim');
            /*$this->form_validation->set_rules('u_mobile', 'Phone/Mobile', 'trim');
            $this->form_validation->set_rules('u_country', 'Country', 'trim');
            $this->form_validation->set_rules('u_state', 'State', 'trim');
            $this->form_validation->set_rules('u_city', 'City', 'trim');
            $this->form_validation->set_rules('u_pincode', 'Pincode', 'trim');*/
            
            if ($this->form_validation->run() == TRUE) {
                	
						date_default_timezone_set("Asia/Kolkata");
						$rows = array(
			                    'firstname' => $f_name,
			                    'lastname' => $l_name,
			                    'modify_date' => date('Y-m-d H:i:s')
			                    //'access_ip' => $this->input->ip_address()
			                );
			            
			            $row1 = array(
			            		'address' => $address
			            		/*'country' => $country,
			            		'state' => $state,
			            		'city' => $city,
			            		'pincode' => $pincode,
			            		'phone' => $mobile*/
			            	);
			                
						if ($this->admin_m->UpdateSavedUser($rows, $row1, $this->session->userdata['uid']))
						{
		                    $this->session->set_flashdata("success","Profile is Updated successfully");
		                    redirect('admincontrol/dashboard/profile');
		                }
		                else
		                    $this->data["error"] = "There is an error. Please try again";
					
            }
		}
		$this->data["profile_list"] = $this->db->get_where("user_views", array("u_id" => $this->session->userdata['uid']))->row();
		$this->load->view('admin/profile/edit_profile_view', $this->data);
	}
	
	public function changepassword4578768978978987(){
		if ($this->input->post("submit"))
		{
            $c_pass = $this->input->post("c_pass");
            $n_pass = $this->input->post("n_pass");
            $n_repass = $this->input->post("n_repass");
            
            $this->form_validation->set_rules('c_pass', 'Current Password', 'trim|required');
            $this->form_validation->set_rules('n_pass', 'New Password', 'trim|required|matches[n_repass]');
            $this->form_validation->set_rules('n_repass', 'Re-Password', 'trim|required');
            
            if((preg_match('/[\^£(&;)?\-}\/:{~\[\]\"\',.><>`|=+¬]/', $c_pass)==1) || (preg_match('/[\^£(&;)?\-}\/:{~\[\]\"\',.><>`|=+¬]/', $n_pass)==1) || (preg_match('/[\^£(&;)?\-}\/:{~\[\]\"\',.><>`|=+¬]/', $n_repass)==1))
            {
				$this->data["error"] = "Some Special Charecters not allow, Please try again.";
			}
			else
			{
            	if ($this->form_validation->run() == TRUE) {
                	
					$encrip_pass = $this->admin_m->hash($c_pass);
					
					if($this->admin_m->check_password_exist($encrip_pass, $this->session->userdata['uid']) == TRUE)
					{
						$encrip_newpass = $this->admin_m->hash($n_pass);
						$rows = array(
			                    'password' => $encrip_newpass,
			                    'modify_date' => date('Y-m-d H:i:s'),
			                    'access_ip' => $this->input->ip_address()
			                );
						if ($this->admin_m->UpdateSavedUser_Password($rows, $this->session->userdata['uid']))
						{
		                    $this->session->set_flashdata("success","Password is changed successfully");
		                    redirect('admincontrol/dashboard/profile');
		                }
		                else
		                    $this->data["error"] = "There is an error. Please try again";
		            }
		            else
		            {
						$this->data["error"] = "Old Password not Matched. Please try again";
					}
			}
			}
		}
		$this->load->view('admin/profile/change_pass_view', $this->data);
	}

	protected function sendmailtemplates($uid){

		$udetails = $this->db->get_where('user_views',array('u_id'=>$uid))->row();
		$adv_list = $this->admin_m->getAlllist_ofActive_Advertisement();
		$strset_arr = array(
			'f_mobile' => 'Mobile',
			'f_email' => 'Email-ID',
			'fu_dob' => 'Date of Birth',
			'fu_address' => 'Address',
			'fu_photo_doc' => 'Photo',
			'fu_signature_doc' => 'Signature',
			'fu_caste' => 'Caste',
			'fu_pwd' => 'PWD',
			'fu_exempted' => 'Exempted',
			'fu_exservice' => 'Ex-Service',
			'fu_age_relax' => 'Age Relaxation',
			'fu_qualification' => 'Qualification',
			'fu_has_service' => 'Service Experience'
		);

		$msg111 = 'Dear Sir / Madam, You are hereby assigned to check the documents produced by the candidates. For details, please check your registered e-mail Id '.$udetails->email.' Regards WBHRB';
		$this->sendALLSMS($msg111, $udetails->mobile, "singlemsg", '1207163844155004334');
		//$smsreplyset = $this->sendALLSMS($msg111, $udetails->mobile, "singlemsg", '1207163844155004334'); //otpmsg
		//$smsarray = explode(',', $smsreplyset);

		if($udetails->u_type == 2 || $udetails->u_type == 3){

			$htmldataset = '<html><body>
			<div>
			<p>Dear '.$udetails->firstname.' '.$udetails->lastname.',<br/>
			You are assigned to check the documents produced by the candidates as '.$udetails->mu_name.' in connection with the recruitment to the following post(s) :</p>
			<p>';
			$strlist111 = explode(",",$udetails->u_adv_access);
			$keys=1;
			foreach($adv_list as $adv_items){
				if(in_array($adv_items->adv_auto_genno, $strlist111)){
					$htmldataset = $htmldataset.$keys.'. '.$adv_items->adv_no.' ('.$adv_items->rm_name.')<br/>';
					$keys++;
				}
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to check the following fields of the candidates :</p>
			<p>';
			$setssss_arr = explode(",",$udetails->u_access_area);
			$keys=1;
			if($setssss_arr[0] != "ALL"){
				foreach($setssss_arr as $gk=>$sets123){
					$htmldataset = $htmldataset.$keys.'. '.$strset_arr[$sets123].'<br/>';
					$keys++;
				}
			}else{
				$htmldataset = $htmldataset.$keys.'. ALL';
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to log in through your registered mobile number('.$udetails->mobile.') from the given URL from ('.date("d-m-Y",strtotime($udetails->entry_startdate)).') to ('.date("d-m-Y",strtotime($udetails->entry_enddate)).') during ('.date("h:i A",strtotime($udetails->entry_starttime)).') to ('.date("h:i A",strtotime($udetails->entry_endtime)).') everyday physically staying at the designated room for verification.</p>
			<p>URL is - <a href="https://www.wbhrb.in/hrb_app/admin_access" target="_blank">https://www.wbhrb.in/hrb_app/admin_access</a></p>
			<p>Your attendance will be recorded in the designated verification centre at the office of the WBHRB.</p>';
			$htmldataset = $htmldataset.'</div>
			</body></html>';
			$this->sendALLSMTPEmail($udetails->email,'WBHRB - Checker Information', $htmldataset);
		
		}elseif($udetails->u_type == 4){

			$htmldataset = '<html><body>
			<div>
			<p>Dear '.$udetails->firstname.' '.$udetails->lastname.',<br/>
			You are assigned to check the documents produced by the candidates as '.$udetails->mu_name.' in presence of Checker Level 1 in connection with the recruitment to the following post(s) :</p>
			<p>';
			$strlist111 = explode(",",$udetails->u_adv_access);
			$keys=1;
			foreach($adv_list as $adv_items){
				if(in_array($adv_items->adv_auto_genno, $strlist111)){
					$htmldataset = $htmldataset.$keys.'. '.$adv_items->adv_no.' ('.$adv_items->rm_name.')<br/>';
					$keys++;
				}
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to check the following fields of the candidates :</p>
			<p>';
			$setssss_arr = explode(",",$udetails->u_access_area);
			$keys=1;
			if($setssss_arr[0] != "ALL"){
				foreach($setssss_arr as $gk=>$sets123){
					$htmldataset = $htmldataset.$keys.'. '.$strset_arr[$sets123].'<br/>';
					$keys++;
				}
			}else{
				$htmldataset = $htmldataset.$keys.'. ALL';
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to log in through your registered mobile number('.$udetails->mobile.') from the given URL from ('.date("d-m-Y",strtotime($udetails->entry_startdate)).') to ('.date("d-m-Y",strtotime($udetails->entry_enddate)).') during ('.date("h:i A",strtotime($udetails->entry_starttime)).') to ('.date("h:i A",strtotime($udetails->entry_endtime)).') everyday physically staying at the designated room for verification.</p>
			<p>URL is - <a href="https://www.wbhrb.in/hrb_app/admin_access" target="_blank">https://www.wbhrb.in/hrb_app/admin_access</a></p>
			<p>Your attendance will be recorded in the designated verification centre at the office of the WBHRB.</p>';
			$htmldataset = $htmldataset.'</div>
			</body></html>';
			$this->sendALLSMTPEmail($udetails->email,'WBHRB - Checker Information', $htmldataset);

		}else{
			$htmldataset = '<html><body>
			<div>
			<p>Dear '.$udetails->firstname.' '.$udetails->lastname.',<br/>
			You are assigned to check the documents produced by the candidates as '.$udetails->mu_name.' in connection with the recruitment to the following post(s) :</p>
			<p>';
			$strlist111 = explode(",",$udetails->u_adv_access);
			$keys=1;
			foreach($adv_list as $adv_items){
				if(in_array($adv_items->adv_auto_genno, $strlist111)){
					$htmldataset = $htmldataset.$keys.'. '.$adv_items->adv_no.' ('.$adv_items->rm_name.')<br/>';
					$keys++;
				}
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to check the following fields of the candidates :</p>
			<p>';
			$setssss_arr = explode(",",$udetails->u_access_area);
			$keys=1;
			if($setssss_arr[0] != "ALL"){
				foreach($setssss_arr as $gk=>$sets123){
					$htmldataset = $htmldataset.$keys.'. '.$strset_arr[$sets123].'<br/>';
					$keys++;
				}
			}else{
				$htmldataset = $htmldataset.$keys.'. ALL';
			}
			$htmldataset = $htmldataset.'</p>
			<p>You are requested to log in through your registered mobile number('.$udetails->mobile.') from the given URL from ('.date("d-m-Y",strtotime($udetails->entry_startdate)).') to ('.date("d-m-Y",strtotime($udetails->entry_enddate)).') during ('.date("h:i A",strtotime($udetails->entry_starttime)).') to ('.date("h:i A",strtotime($udetails->entry_endtime)).') everyday physically staying at the designated room for verification.</p>
			<p>URL is - <a href="https://www.wbhrb.in/hrb_app/admin_access" target="_blank">https://www.wbhrb.in/hrb_app/admin_access</a></p>
			<p>Your attendance will be recorded in the designated verification centre at the office of the WBHRB.</p>';
			$htmldataset = $htmldataset.'</div>
			</body></html>';
			$this->sendALLSMTPEmail($udetails->email,'WBHRB - Checker Information', $htmldataset);
		}

	}

	public function categorywise_candidate_section(){
		if($this->session->userdata['utype'] != 1){
			if($this->session->userdata['utype'] != 4){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();

				$this->load->model('candidates_m');
				$this->data['appli_list'] = array();
				//$get_alluser = $this->db->order_by('u_type','ASC')->where_in('u_type',array(2,3,4))->get('user_views')->result();
				$catg_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				//echo "<pre>";
				//print_r($get_alluser);exit;
				$totaladvcandlist = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				$this->data['total_cand'] = count((array)$totaladvcandlist);
				$icnt = 0;
				
				foreach($catg_details as $keys=>$catgoryitem){

					/*$otercat_arr[$icnt] = array(
						'URSET' => 0,
						'SCSET' => 0,
						'STSET' => 0,
						'OBC-ASET' => 0,
						'OBC-BSET' => 0
					);*/
					$totalcat_candidate = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application($advno, 'Approved', $catgoryitem->acat_id);
					$this->data['appli_list'][$icnt] = array(
						'type_name' => $catgoryitem->catm_name,
						'UR' => 0,
						'SC' => 0,
						'ST' => 0,
						'OBC' => 0,
						'OBC-A' => 0,
						'OBC-B' => 0,
						'PWD' => 0,
						'allvac' => $catgoryitem->acat_total,
						'alltotal' => 0,
						'URSET' => 0,
						'SCSET' => 0,
						'STSET' => 0,
						'OBC-ASET' => 0,
						'OBC-BSET' => 0,
						'allapprove' => $totalcat_candidate
					);
					
					$getcount_total = 0;
					$getcount_castes = $this->admin_m->getAllCount_asperADV_Categorywise_Candidates($advno, $catgoryitem->acat_id);
					$getcount_pwd = $this->admin_m->getAllCount_asperADV_Categorywise_Candidates($advno, $catgoryitem->acat_id, 'PWD');
					
					foreach($getcount_castes as $castesets){
						$getcount_total = $getcount_total + $castesets->cnt;
						if($castesets->fu_caste_type == 1){
							$this->data['appli_list'][$icnt]['UR'] = $castesets->cnt;
						}elseif($castesets->fu_caste_type == 2){
							$this->data['appli_list'][$icnt]['SC'] = $castesets->cnt;
						}elseif($castesets->fu_caste_type == 3){
							$this->data['appli_list'][$icnt]['ST'] = $castesets->cnt;
						}elseif($castesets->fu_caste_type == 4){
							$this->data['appli_list'][$icnt]['OBC'] = $castesets->cnt;
						}elseif($castesets->fu_caste_type == 5){
							$this->data['appli_list'][$icnt]['OBC-A'] = $castesets->cnt;
						}elseif($castesets->fu_caste_type == 6){
							$this->data['appli_list'][$icnt]['OBC-B'] = $castesets->cnt;
						}else{
							if($castesets->fu_caste_type > 10){
								if($castesets->fu_caste_type == 35 || $castesets->fu_caste_type == 36 || $castesets->fu_caste_type == 37 || $castesets->fu_caste_type == 38){
									$this->data['appli_list'][$icnt]['URSET'] = $this->data['appli_list'][$icnt]['URSET'] + $castesets->cnt;
								}elseif($castesets->fu_caste_type == 39 || $castesets->fu_caste_type == 40 || $castesets->fu_caste_type == 41){
									$this->data['appli_list'][$icnt]['SCSET'] = $this->data['appli_list'][$icnt]['SCSET'] + $castesets->cnt;
								}elseif($castesets->fu_caste_type == 42 || $castesets->fu_caste_type == 43){
									$this->data['appli_list'][$icnt]['STSET'] = $this->data['appli_list'][$icnt]['STSET'] + $castesets->cnt;
								}elseif($castesets->fu_caste_type == 44 || $castesets->fu_caste_type == 45){
									$this->data['appli_list'][$icnt]['OBC-ASET'] = $this->data['appli_list'][$icnt]['OBC-ASET'] + $castesets->cnt;
								}elseif($castesets->fu_caste_type == 46 || $castesets->fu_caste_type == 47){
									$this->data['appli_list'][$icnt]['OBC-BSET'] = $this->data['appli_list'][$icnt]['OBC-BSET'] + $castesets->cnt;
								}
							}
						}
					}
					$this->data['appli_list'][$icnt]['PWD'] = $getcount_pwd->cnt;
					$this->data['appli_list'][$icnt]['alltotal'] = $getcount_total;
					$icnt++;

				}
				//echo "<pre>";
				//print_r($this->data['appli_list']);exit;
				//$this->data['extraappli_list'] = $otercat_arr;
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/category_wise_candidate_view', $this->data);
	}

	public function checker_monitoring_section(){
		if($this->session->userdata['utype'] != 1){
			if($this->session->userdata['utype'] != 4){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();

				$this->load->model('candidates_m');
				$this->data['appli_list'] = array();
				//$get_alluser = $this->db->order_by('u_type','ASC')->where_in('u_type',array(2,3,4))->get('user_views')->result();
				$get_alluser = $this->candidates_m->getAllUser_WorkingonAdvertisement($advno);
				//echo "<pre>";
				//print_r($get_alluser);exit;
				$totaladvcandlist = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				$this->data['total_cand'] = count((array)$totaladvcandlist);
				$icnt = 0;
				foreach($get_alluser as $keys=>$users){
					//$advlists_arr = explode(",",$users->u_adv_access);
					//if(in_array($advno, $advlists_arr)){

						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($users->firstname.' '.$users->lastname),
							'type_name' => $users->mu_name,
							'chktype' => $users->u_type
						);
						$getcount_approve = $getcount_reject = $getcount_doubtful = $getcount_skip = $getcount_return = 0;
						if($users->u_type == 2 || $users->u_type == 4){
							$getcount_approve = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Approved',$users->u_id, $users->u_type);
							$getcount_reject = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Rejected',$users->u_id, $users->u_type);
							$getcount_doubtful = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Doubtful',$users->u_id, $users->u_type);
							$getcount_skip = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Skip',$users->u_id, $users->u_type);
							$getcount_return = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Return',$users->u_id, $users->u_type);
						}elseif($users->u_type == 3){
							$getcount_approve = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Approved',$users->u_id);
							$getcount_reject = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Rejected',$users->u_id);
							$getcount_doubtful = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Doubtful',$users->u_id);
							$getcount_skip = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Skip',$users->u_id);
							$getcount_return = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Return',$users->u_id);
						}
						$this->data['appli_list'][$icnt]['t_approve'] = $getcount_approve;
						$this->data['appli_list'][$icnt]['t_reject'] = $getcount_reject;
						$this->data['appli_list'][$icnt]['t_doubtful'] = $getcount_doubtful;
						$this->data['appli_list'][$icnt]['t_skip'] = $getcount_skip;
						$this->data['appli_list'][$icnt]['t_return'] = $getcount_return;
						$this->data['appli_list'][$icnt]['t_total'] = $getcount_approve + $getcount_reject + $getcount_doubtful + $getcount_skip + $getcount_return;
						$icnt++;
					//}
				}
				//echo "<pre>";
				//print_r($this->data['appli_list']);exit;
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/checker_monitor_list', $this->data);
	}
	
	public function get_allchecker_against_advertisement(){
		if ($_POST) {
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");

			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');

			if ($this->form_validation->run()) {

				$result_details = $this->admin_m->checkUser_AdvertisementWise_withAccess($advno,'ALL');
				if (count((array)$result_details) > 0) {
					$totalall = '<option value="">---Select---</option>';
					foreach ($result_details as $results) {
						$totalall = $totalall . '<option value="' . $results->u_id . '">' . $results->firstname .' '. $results->lastname . ' (' .$results->mu_name. ')' . '</option>';
					}
					echo json_encode(array('msg' => 1, 'op_set' => $totalall));
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function get_allcheckermail_against_advertisement(){
		if ($_POST) {
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");

			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');

			if ($this->form_validation->run()) {

				$result_details = $this->admin_m->checkUser_AdvertisementWise_withAccess($advno, 'ALL');
				if (count((array)$result_details) > 0) {
					$totalall = '<option value="">---Select---</option>';
					foreach ($result_details as $results) {
						$totalall = $totalall . '<option value="' . $results->u_id . '">' . $results->firstname .' '. $results->lastname . ' (' .$results->mu_name. ')' . '</option>';
					}
					echo json_encode(array('msg' => 1, 'op_set' => $totalall));
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function checker_checking_section(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'chkno'=>$chkno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['usr_list'] = $this->admin_m->checkUser_AdvertisementWise_withAccess($advno,'ALL');
				if(strtotime($u_enddate.' '.$u_endtime) > strtotime($u_startdate.' '.$u_starttime)){
					$ss_datetime = date('Y-m-d H:i:s',strtotime($u_startdate.' '.$u_starttime));
					$ee_datetime = date('Y-m-d H:i:s',strtotime($u_enddate.' '.$u_endtime));
					$this->data['result_utypes'] = $getresult_utypes = $this->db->get_where('user_info',array('u_id'=>$chkno))->row()->u_type;
					if($getresult_utypes == 3){
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($advno,$chkno,$ss_datetime,$ee_datetime,$getresult_utypes);
					}else{
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($advno,$chkno,$ss_datetime,$ee_datetime);
					}
				}else{
					$this->data["error"] = "Start Date/Time is bigger than End Date/Time, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/checker_checking_view', $this->data);
	}

	public function removeall_action_against_check($chkid = NULL){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($chkid == NULL){
			redirect('admincontrol/dashboard/checker_checking_section');
		}
		
		$arr_sets = array(
			'chk_approve' => NULL,
			'chk_comments' => NULL,
			'chk_appro_date' => NULL,
			'chk2_approve' => NULL,
			'chk2_comments' => NULL,
			'chk2_appro_date' => NULL,
			'chk2_appro_by' => NULL,
			'chk_final_state' => NULL,
			'chk_got_marks' => 0.00,
			'chkadm_comments' => "ADMIN DELETE THE ACTIONS",
			'chkadm_appro_date' => date('Y-m-d H:i:s')
		);
		$detail_checkingsets = $this->db->get_where('checking_tab', array('chk_id' => $chkid))->row();
		$resdetail = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $detail_checkingsets->chk_user_application))->row();
		if($resdetail->cr_approval == "NotChecked"){
			if($this->admin_m->removeAll_CheckerAction_statusinDB($arr_sets, $chkid) == TRUE)
			{
				$ssstr_arr = array(
					'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews'
				);
				if(in_array($detail_checkingsets->chk_type, $ssstr_arr)){
					$this->load->model('candidates_m');
					if($detail_checkingsets->chk_type == "fu_dob"){
						$rowsarr = array('fu_dob_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_address"){
						$rowsarr = array('fu_address_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_photo_doc"){
						$rowsarr = array('fu_photo_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_signature_doc"){
						$rowsarr = array('fu_signature_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_caste"){
						$rowsarr = array('fu_caste_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_pwd"){
						$rowsarr = array('fu_pwd_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_exempted"){
						$rowsarr = array('fu_exempted_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_exservice"){
						$rowsarr = array('fu_exservice_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}elseif($detail_checkingsets->chk_type == "fu_ews"){
						$rowsarr = array('fu_ews_check'=> NULL);
						$this->candidates_m->setUpdate_ResultCandidate_Appliwise($rowsarr, $detail_checkingsets->chk_user_application);
					}
				}
				$this->session->set_flashdata("success","Checker Action is Removed successfully");
				redirect('admincontrol/dashboard/checker_checking_section','refresh');
			}
			else
			{
				$this->session->set_flashdata("e_error","There have some Problem. Please try again.");
				redirect('admincontrol/dashboard/checker_checking_section','refresh');
			}
		}else{
			$this->session->set_flashdata("e_error","Permission Denied, Final processing is Done for the Candidate.");
			redirect('admincontrol/dashboard/checker_checking_section','refresh');
		}
	}

	public function all_checker_monitoring_section(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('chkno'=>$chkno);
				
				if(strtotime($u_enddate.' '.$u_endtime) > strtotime($u_startdate.' '.$u_starttime)){
					$ss_datetime = date('Y-m-d H:i:s',strtotime($u_startdate.' '.$u_starttime));
					$ee_datetime = date('Y-m-d H:i:s',strtotime($u_enddate.' '.$u_endtime));
					$icnt = 0;

					if($chkno != "ALL"){

						$get_finduser = $this->db->where('u_id',$chkno)->get('user_views')->row();
						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($get_finduser->firstname.' '.$get_finduser->lastname),
							'type_name' => $get_finduser->mu_name,
							'chktype' => $get_finduser->u_type
						);
						if($get_finduser->u_type == 2 || $get_finduser->u_type == 4){
							$getcount_approve = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Approved',$get_finduser->u_id, $get_finduser->u_type);
							$getcount_reject = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Rejected',$get_finduser->u_id, $get_finduser->u_type);
							$getcount_doubtful = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Doubtful',$get_finduser->u_id, $get_finduser->u_type);
							$getcount_skip = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Skip',$get_finduser->u_id, $get_finduser->u_type);
							$getcount_return = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Return',$get_finduser->u_id, $get_finduser->u_type);
						}elseif($get_finduser->u_type == 3){
							$getcount_approve = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Approved',$get_finduser->u_id);
							$getcount_reject = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Rejected',$get_finduser->u_id);
							$getcount_doubtful = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Doubtful',$get_finduser->u_id);
							$getcount_skip = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Skip',$get_finduser->u_id);
							$getcount_return = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Return',$get_finduser->u_id);
						}
						$this->data['appli_list'][$icnt]['t_approve'] = $getcount_approve;
						$this->data['appli_list'][$icnt]['t_reject'] = $getcount_reject;
						$this->data['appli_list'][$icnt]['t_doubtful'] = $getcount_doubtful;
						$this->data['appli_list'][$icnt]['t_skip'] = $getcount_skip;
						$this->data['appli_list'][$icnt]['t_return'] = $getcount_return;
						$this->data['appli_list'][$icnt]['t_total'] = $getcount_approve + $getcount_reject + $getcount_doubtful + $getcount_skip + $getcount_return;

					}else{

						$get_alluser = $this->db->order_by('u_type','ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
						$icnt = 0;
						foreach($get_alluser as $keys=>$users){
							//$advlists_arr = explode(",",$users->u_adv_access);
							//if(in_array($advno, $advlists_arr)){

								$this->data['appli_list'][$icnt] = array(
									'cheker_name' => ($users->firstname.' '.$users->lastname),
									'type_name' => $users->mu_name,
									'chktype' => $users->u_type
								);
								if($users->u_type == 2 || $users->u_type == 4){
									$getcount_approve = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Approved',$users->u_id, $users->u_type);
									$getcount_reject = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Rejected',$users->u_id, $users->u_type);
									$getcount_doubtful = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Doubtful',$users->u_id, $users->u_type);
									$getcount_skip = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Skip',$users->u_id, $users->u_type);
									$getcount_return = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Return',$users->u_id, $users->u_type);
								}elseif($users->u_type == 3){
									$getcount_approve = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Approved',$users->u_id);
									$getcount_reject = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Rejected',$users->u_id);
									$getcount_doubtful = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Doubtful',$users->u_id);
									$getcount_skip = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Skip',$users->u_id);
									$getcount_return = $this->admin_m->getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime,'Return',$users->u_id);
								}
								$this->data['appli_list'][$icnt]['t_approve'] = $getcount_approve;
								$this->data['appli_list'][$icnt]['t_reject'] = $getcount_reject;
								$this->data['appli_list'][$icnt]['t_doubtful'] = $getcount_doubtful;
								$this->data['appli_list'][$icnt]['t_skip'] = $getcount_skip;
								$this->data['appli_list'][$icnt]['t_return'] = $getcount_return;
								$this->data['appli_list'][$icnt]['t_total'] = $getcount_approve + $getcount_reject + $getcount_doubtful + $getcount_skip + $getcount_return;
								$icnt++;
							//}
						}
					}
					/*if($getresult_utypes == 3){
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime,$getresult_utypes);
					}else{
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime);
					}*/
				}else{
					$this->data["error"] = "Start Date/Time is bigger than End Date/Time, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['usr_list'] = $this->db->order_by('u_type ASC, firstname ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
		$this->load->view('admin/profile/all_checker_monitor_view', $this->data);
	}

	public function checker_mail_sending_section(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'chkno'=>$chkno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['usr_list'] = $this->admin_m->checkUser_AdvertisementWise_withAccess($advno,'ALL');
				if(strtotime($u_enddate.' '.$u_endtime) > strtotime($u_startdate.' '.$u_starttime)){
					$ss_datetime = date('Y-m-d H:i:s',strtotime($u_startdate.' '.$u_starttime));
					$ee_datetime = date('Y-m-d H:i:s',strtotime($u_enddate.' '.$u_endtime));
					$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateMail_sendByChecker($advno,$chkno,$ss_datetime,$ee_datetime);
				}else{
					$this->data["error"] = "Start Date/Time is bigger than End Date/Time, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/checker_mailsend_view', $this->data);
	}

	public function checker_reversing_check_section(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();

				$this->data['appli_list'] = array();
				$get_alluser = $this->db->order_by('u_type','ASC')->where_in('u_type',array(2,4))->get('user_views')->result();
				$this->load->model('candidates_m');
				$totaladvcandlist = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				$this->data['total_cand'] = count((array)$totaladvcandlist);
				$icnt = 0;
				foreach($get_alluser as $keys=>$users){
					$advlists_arr = explode(",",$users->u_adv_access);
					if(in_array($advno, $advlists_arr)){

						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($users->firstname.' '.$users->lastname),
							'type_name' => $users->mu_name,
							'chktype' => $users->u_type
						);
						if($users->u_type == 2 || $users->u_type == 4){
							$getcount_approve = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Approved',$users->u_id, $users->u_type);
							$getcount_reject = $this->admin_m->getAllCount_asperMonitorChecker($advno,'Rejected',$users->u_id, $users->u_type);
							$getcount_rev_approve = $this->admin_m->getAllReverse_Count_asperChecker($advno,'Approved','Rejected',$users->u_id, $users->u_type);
							$getcount_rev_reject = $this->admin_m->getAllReverse_Count_asperChecker($advno,'Rejected','Approved',$users->u_id, $users->u_type);
						}
						$this->data['appli_list'][$icnt]['t_approve'] = $getcount_approve;
						$this->data['appli_list'][$icnt]['t_reject'] = $getcount_reject;
						$this->data['appli_list'][$icnt]['t_rev_approve'] = $getcount_rev_approve;
						$this->data['appli_list'][$icnt]['t_rev_reject'] = $getcount_rev_reject;
						$icnt++;
					}
				}
				//echo "<pre>";
				//print_r($this->data['appli_list']);exit;
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/checker_rev_view', $this->data);
	}

	public function holdssssssssssssssss_checker_datewise_total_checking(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('chkno'=>$chkno);
				
				if(strtotime($u_enddate) > strtotime($u_startdate)){
					$ss_datetime = date('Y-m-d',strtotime($u_startdate));
					$ee_datetime = date('Y-m-d',strtotime($u_enddate));
					$this->data['all_dates'] = $datesets_all = $this->date_range_collect($ss_datetime, $ee_datetime);
					//print_r($datesets_all);exit;
					$icnt = 0;

					if($chkno != "ALL"){

						$get_finduser = $this->db->where('u_id',$chkno)->get('user_views')->row();
						$getcount_dayall_counter = 0;
						$getcount_dayavg_counter = 0;
						$getcount_daywork_counter = 0;
						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($get_finduser->firstname.' '.$get_finduser->lastname),
							'type_name' => $get_finduser->mu_name,
							'chktype' => $get_finduser->u_type
						);
						$this->data['appli_list'][$icnt]['t_days'] = array();
						for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
							$getcount_dayall = 0;
							if($get_finduser->u_type == 2 || $get_finduser->u_type == 4){
								$getcount_dayall = $this->admin_m->getAll_Datewise_UserCount_asperChecking($datesets_all[$daycnt], $datesets_all[$daycnt],$get_finduser->u_id, $get_finduser->u_type);
							}elseif($get_finduser->u_type == 3){
								$getcount_dayall = $this->admin_m->getAll_Datewise_UserCount_asperChecking($datesets_all[$daycnt], $datesets_all[$daycnt],$get_finduser->u_id);
							}
							$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
							$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
							if($getcount_dayall > 0){
								$getcount_daywork_counter++;
							}
						}
						if($getcount_daywork_counter == 0){
							$getcount_dayavg_counter = 0;
						}else{
							$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
						}
						$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
						$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
						$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
						
					}else{

						$get_alluser = $this->db->order_by('u_type','ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
						$icnt = 0;
						foreach($get_alluser as $keys=>$users){
							
							$getcount_dayall_counter = 0;
							$getcount_dayavg_counter = 0;
							$getcount_daywork_counter = 0;
							$this->data['appli_list'][$icnt] = array(
								'cheker_name' => ($users->firstname.' '.$users->lastname),
								'type_name' => $users->mu_name,
								'chktype' => $users->u_type
							);
							$this->data['appli_list'][$icnt]['t_days'] = array();
							for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
								$getcount_dayall = 0;
								if($users->u_type == 2 || $users->u_type == 4){
									$getcount_dayall = $this->admin_m->getAll_Datewise_UserCount_asperChecking($datesets_all[$daycnt], $datesets_all[$daycnt],$users->u_id, $users->u_type);
								}elseif($users->u_type == 3){
									$getcount_dayall = $this->admin_m->getAll_Datewise_UserCount_asperChecking($datesets_all[$daycnt], $datesets_all[$daycnt],$users->u_id);
								}
								$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
								$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
								if($getcount_dayall > 0){
									$getcount_daywork_counter++;
								}
							}
							if($getcount_daywork_counter == 0){
								$getcount_dayavg_counter = 0;
							}else{
								$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
							}
							$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
							$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
							$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
							$icnt++;
						}
					}
					/*if($getresult_utypes == 3){
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime,$getresult_utypes);
					}else{
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime);
					}*/
				}else{
					$this->data["error"] = "Start Date is bigger than End Date, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['usr_list'] = $this->db->order_by('u_type ASC, firstname ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
		$this->load->view('admin/profile/datewise_checker_monitor_view', $this->data);
	}
	
	public function checker_datewise_total_checking(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('chkno'=>$chkno);
				
				if(strtotime($u_enddate) > strtotime($u_startdate)){
					$ss_datetime = date('Y-m-d',strtotime($u_startdate));
					$ee_datetime = date('Y-m-d',strtotime($u_enddate));
					$this->data['all_dates'] = $datesets_all = $this->date_range_collect($ss_datetime, $ee_datetime);
					//print_r($datesets_all);exit;
					$icnt = 0;

					if($chkno != "ALL"){

						$get_finduser = $this->db->where('u_id',$chkno)->get('user_views')->row();
						$get_findall_dates = $this->admin_m->getAll_Datewise_GroupingUserCount_asperChecking($ss_datetime, $ee_datetime, $chkno);
						$getcount_dayall_counter = 0;
						$getcount_dayavg_counter = 0;
						$getcount_daywork_counter = 0;
						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($get_finduser->firstname.' '.$get_finduser->lastname),
							'type_name' => $get_finduser->mu_name,
							'chktype' => $get_finduser->u_type
						);
						$this->data['appli_list'][$icnt]['t_days'] = array();
						for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
							$getcount_dayall = 0;
							foreach($get_findall_dates as $dateitems){
								if($dateitems->dates == $datesets_all[$daycnt]){
									$getcount_dayall = $dateitems->totals;
									break;
								}
							}
							$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
							$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
							if($getcount_dayall > 0){
								$getcount_daywork_counter++;
							}
						}
						if($getcount_daywork_counter == 0){
							$getcount_dayavg_counter = 0;
						}else{
							$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
						}
						$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
						$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
						$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
						
					}else{

						$get_findall_dates = $this->admin_m->getAll_Datewise_GroupingUserCount_asperChecking($ss_datetime, $ee_datetime);
						$get_alluser = $this->db->order_by('u_type','ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
						$icnt = 0;
						foreach($get_alluser as $keys=>$users){
							
							$getcount_dayall_counter = 0;
							$getcount_dayavg_counter = 0;
							$getcount_daywork_counter = 0;
							$this->data['appli_list'][$icnt] = array(
								'cheker_name' => ($users->firstname.' '.$users->lastname),
								'type_name' => $users->mu_name,
								'chktype' => $users->u_type
							);
							$this->data['appli_list'][$icnt]['t_days'] = array();
							for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
								$getcount_dayall = 0;
								foreach($get_findall_dates as $dateitems){
									if($dateitems->dates == $datesets_all[$daycnt] && $users->u_id == $dateitems->chekers){
										$getcount_dayall = $dateitems->totals;
										break;
									}
								}
								$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
								$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
								if($getcount_dayall > 0){
									$getcount_daywork_counter++;
								}
							}
							if($getcount_daywork_counter == 0){
								$getcount_dayavg_counter = 0;
							}else{
								$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
							}
							$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
							$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
							$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
							$icnt++;
						}
					}
					/*if($getresult_utypes == 3){
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime,$getresult_utypes);
					}else{
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime);
					}*/
				}else{
					$this->data["error"] = "Start Date is bigger than End Date, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['usr_list'] = $this->db->order_by('u_type ASC, firstname ASC')->where('user_status',1)->where_in('u_type',array(2,3,4))->get('user_views')->result();
		$this->load->view('admin/profile/datewise_checker_monitor_view', $this->data);
	}

	public function checker_monitoring_pdf_sets(){
		if($_POST){
			$data_result = $this->input->post('div_data');
			error_reporting(0);
			$this->load->helper("tcpdf_helper");
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Checker Report";//$advice_detail->advice_name;
			//$obj_pdf->SetTitle($title);
			
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
			//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			//$obj_pdf->SetDefaultMonospacedFont('helvetica');
			//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			//$obj_pdf->SetFont('helvetica', '', 9);
			//$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();

			$html = '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
			<html xmlns=\"http://www.w3.org/1999/xhtml\">
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
			<meta charset=\"utf-8\" />
			<title>Checker Report</title>
			</head>
			<body>';
										

			$html.='<div style="font-size:20px;">'.$data_result.'</div>';
			$html.= '</body></html>';			

			$obj_pdf->writeHTML($html, true, false, true, false, '');
					
			$obj_pdf->Output("Print_Report_".date('dmYHis').".pdf", "I");
		}
	}


	public function final_checking_complition_check(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->load->model('candidates_m');
				$this->data['total_cand'] = $totalsets_cand = $this->admin_m->getcount_DetailsofCandidate_Application($advno);
				//echo $totalsets_cand;

				$adv_detail = $this->db->where('adv_auto_genno',$advno)->get('advertisement_master')->row();
				$this->data['ssstr_arr'] = $accessall = array(
					'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service'
				);
				//echo "<pre>";
				//print_r($this->data['adv_catg']);
				$appli_list = array();
				for($icnt = 0;$icnt<count($accessall); $icnt++){

					if($accessall[$icnt] == "fu_dob"){
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_dob'] = array(
							'C-13' => ($totalsets_cand - $allcounter_set[0]->totals),
							'C-2' => ($totalsets_cand - $allcounter_set[1]->totals)
						);
					}elseif($accessall[$icnt] == "fu_address"){
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_address'] = array(
							'C-13' => ($totalsets_cand - $allcounter_set[0]->totals),
							'C-2' => ($totalsets_cand - $allcounter_set[1]->totals)
						);
					}elseif($accessall[$icnt] == "fu_photo_doc"){
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_photo_doc'] = array(
							'C-13' => ($totalsets_cand - $allcounter_set[0]->totals),
							'C-2' => ($totalsets_cand - $allcounter_set[1]->totals)
						);
					}elseif($accessall[$icnt] == "fu_signature_doc"){
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_signature_doc'] = array(
							'C-13' => ($totalsets_cand - $allcounter_set[0]->totals),
							'C-2' => ($totalsets_cand - $allcounter_set[1]->totals)
						);
					}elseif($accessall[$icnt] == "fu_caste"){
						$notin_set = $this->admin_m->getcount_DetailsofCandidate_Application($advno, $accessall[$icnt]);
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_caste'] = array(
							'C-13' => ($totalsets_cand - ($allcounter_set[0]->totals + $notin_set)),
							'C-2' => ($totalsets_cand - ($allcounter_set[1]->totals + $notin_set))
						);
					}elseif($accessall[$icnt] == "fu_pwd"){
						$notin_set = $this->admin_m->getcount_DetailsofCandidate_Application($advno, $accessall[$icnt]);
						$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
						$appli_list['fu_pwd'] = array(
							'C-13' => ($totalsets_cand - ($allcounter_set[0]->totals + $notin_set)),
							'C-2' => ($totalsets_cand - ($allcounter_set[1]->totals + $notin_set))
						);
					}elseif($accessall[$icnt] == "fu_exempted"){
						if($adv_detail->adv_has_exampted == "Yes"){
							$notin_set = $this->admin_m->getcount_DetailsofCandidate_Application($advno, $accessall[$icnt]);
							$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
							$appli_list['fu_exempted'] = array(
								'C-13' => ($totalsets_cand - ($allcounter_set[0]->totals + $notin_set)),
								'C-2' => ($totalsets_cand - ($allcounter_set[1]->totals + $notin_set))
							);
						}else{
							$appli_list['fu_exempted'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_exservice"){
						if($adv_detail->adv_has_exservice == "Yes"){
							$notin_set = $this->admin_m->getcount_DetailsofCandidate_Application($advno, $accessall[$icnt]);
							$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
							$appli_list['fu_exservice'] = array(
								'C-13' => ($totalsets_cand - ($allcounter_set[0]->totals + $notin_set)),
								'C-2' => ($totalsets_cand - ($allcounter_set[1]->totals + $notin_set))
							);
						}else{
							$appli_list['fu_exservice'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_ews"){
						if($adv_detail->adv_has_ews == "Yes"){
							$notin_set = $this->admin_m->getcount_DetailsofCandidate_Application($advno, $accessall[$icnt]);
							$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt]);
							$appli_list['fu_ews'] = array(
								'C-13' => ($totalsets_cand - ($allcounter_set[0]->totals + $notin_set)),
								'C-2' => ($totalsets_cand - ($allcounter_set[1]->totals + $notin_set))
							);
						}else{
							$appli_list['fu_ews'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_age_relax"){
						$this->data['ext_age_set'] = $result_details = $this->candidates_m->gatAll_Special_subscriptionAge_list($advno);
						if(count((array)$result_details) > 0){
							foreach($result_details as $keys=>$r_items){
								$yesin_set = $this->admin_m->getcount_Detailsofspcl_chk_Application($advno, $accessall[$icnt], $r_items->advage_section);
								$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt], $r_items->advage_section);
								$appli_list['fu_age_relax'][$keys] = array(
									'C-13' => ($yesin_set - $allcounter_set[0]->totals),
									'C-2' => ($yesin_set - $allcounter_set[1]->totals)
								);
							}
						}else{
							$appli_list['fu_age_relax'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}

					}elseif($accessall[$icnt] == "fu_es_qualification"){
						$this->data['es_quali_set'] = $result_details = $this->candidates_m->getDetails_Qualification_Advertisement_Wise('Essential',$advno);
						if(count((array)$result_details) > 0){
							foreach($result_details as $keys=>$r_items){
								$yesin_set = $this->admin_m->getcount_Detailsofspcl_chk_Application($advno, $accessall[$icnt], $r_items->aquali_exam);
								$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt], $r_items->aquali_exam);
								$appli_list['fu_es_qualification'][$keys] = array(
									'C-13' => ($yesin_set - $allcounter_set[0]->totals),
									'C-2' => ($yesin_set - $allcounter_set[1]->totals)
								);
							}
						}else{
							$appli_list['fu_es_qualification'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_ds_qualification"){
						$this->data['ds_quali_set'] = $result_details = $this->candidates_m->getDetails_Qualification_Advertisement_Wise('Desirable',$advno);
						if(count((array)$result_details) > 0){
							foreach($result_details as $keys=>$r_items){
								$yesin_set = $this->admin_m->getcount_Detailsofspcl_chk_Application($advno, $accessall[$icnt], $r_items->aquali_exam);
								$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt], $r_items->aquali_exam);
								$appli_list['fu_ds_qualification'][$keys] = array(
									'C-13' => ($yesin_set - $allcounter_set[0]->totals),
									'C-2' => ($yesin_set - $allcounter_set[1]->totals)
								);
							}
						}else{
							$appli_list['fu_ds_qualification'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_has_es_service"){
						if($adv_detail->adv_has_experience == "Yes"){
							$this->data['es_serv_set'] = $result_details = $this->candidates_m->getDetails_Experience_Advertisement_Wise('Essential',$advno);
							if(count((array)$result_details) > 0){
								foreach($result_details as $keys=>$r_items){
									$yesin_set = $this->admin_m->getcount_Detailsofspcl_chk_Application($advno, $accessall[$icnt], $r_items->aexpr_name);
									$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt], $r_items->aexpr_name);
									$appli_list['fu_has_es_service'][$keys] = array(
										'C-13' => ($yesin_set - $allcounter_set[0]->totals),
										'C-2' => ($yesin_set - $allcounter_set[1]->totals)
									);
								}
							}else{
								$appli_list['fu_has_es_service'] = array(
									'C-13' => "Not Applicable",
									'C-2' => "Not Applicable"
								);
							}
						}else{
							$appli_list['fu_has_es_service'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}elseif($accessall[$icnt] == "fu_has_ds_service"){
						if($adv_detail->adv_has_experience == "Yes"){
							$this->data['ds_serv_set'] = $result_details = $this->candidates_m->getDetails_Experience_Advertisement_Wise('Desirable',$advno);
							if(count((array)$result_details) > 0){
								foreach($result_details as $keys=>$r_items){
									$yesin_set = $this->admin_m->getcount_Detailsofspcl_chk_Application($advno, $accessall[$icnt], $r_items->aexpr_name);
									$allcounter_set = $this->admin_m->goto_checkAllchcekertype_wise_Countersection($advno, $accessall[$icnt], $r_items->aexpr_name);
									$appli_list['fu_has_ds_service'][$keys] = array(
										'C-13' => ($yesin_set - $allcounter_set[0]->totals),
										'C-2' => ($yesin_set - $allcounter_set[1]->totals)
									);
								}
							}else{
								$appli_list['fu_has_ds_service'] = array(
									'C-13' => "Not Applicable",
									'C-2' => "Not Applicable"
								);
							}
						}else{
							$appli_list['fu_has_ds_service'] = array(
								'C-13' => "Not Applicable",
								'C-2' => "Not Applicable"
							);
						}
					}

				}
				$this->data['appli_list'] = $appli_list;
				//print_r($appli_list);
				
				//exit;
				//$this->data['appli_list'] = $this->admin_m->GetDetailsofCandidate_monitoring_Application($advno);

			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/all_checking_check_checker', $this->data);
	}

	public function checker_remaining_pdfprint(){
		if($_POST){
			$data_result = $this->input->post('div_data');
			$adv_data = $this->input->post('advno_data');
			if($adv_data == "" || $data_result == ""){
				redirect('admincontrol/dashboard/final_checking_complition_check');
			}
			$adv_listset = $this->admin_m->getAll_detaillist_of_Avvertisement($adv_data);
			error_reporting(0);
			$this->load->helper("tcpdf_helper");
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Checker Remaining Checking Report";//$advice_detail->advice_name;
			//$obj_pdf->SetTitle($title);
			
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
			//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			//$obj_pdf->SetDefaultMonospacedFont('helvetica');
			//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			//$obj_pdf->SetFont('helvetica', '', 9);
			//$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();

			$html = '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
			<html xmlns=\"http://www.w3.org/1999/xhtml\">
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
			<meta charset=\"utf-8\" />
			<title>Checker Remaining Checking Report</title>
			</head>
			<body>';
			$html.='<p align="center" style="font-size:24px;"><b>'.$adv_listset->rm_name.' | '.$adv_listset->adv_no.'</b></p>
			<p align="center" style="font-size:22px;"><b>STATUS REPORT</b> | Date : '.date('d-m-Y').'</p>';							
			$html.='<div style="font-size:20px;">'.$data_result.'</div>';
			$html.= '</body></html>';			

			$obj_pdf->writeHTML($html, true, false, true, false, '');
					
			$obj_pdf->Output("Print_RemainingReport_".date('dmYHis').".pdf", "I");
		}
	}

	public function final_checklist_monitoring(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['appli_list'] = $this->admin_m->GetDetailsofCandidate_monitoring_Application($advno);
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/final_check_application_list', $this->data);
	}

	public function after_finalprocess_candidatestatus_list(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['appli_list'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application($advno);
				$this->data['appli_approve'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application($advno, 'Approved');
				$this->data['appli_reject'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application($advno, 'Rejected');
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/afterfinal_process_application_list', $this->data);
	}

	public function after_finalprocess_pagewise_candidatestatus_list(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_GET){
			$this->load->library('pagination');
			$rf_set = $this->input->get("rf_set");
			$advno = $this->input->get("advno");
			$page = $this->input->get("per_page");
			$pa_search = $this->input->get("pa_search");

			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');

			$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'pasearch'=>$pa_search);
			$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
			if(empty($pa_search)){
				$pa_search = NULL;
			}
			if($page == NULL)
				$this->data['appli_list'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application_v2($advno, NULL, 0, $pa_search);
			else
				$this->data['appli_list'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application_v2($advno, NULL, $page, $pa_search);

			$this->data['appli_approve'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application_v2($advno, 'Approved');
			$this->data['appli_reject'] = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application_v2($advno, 'Rejected');
			if(empty($pa_search)){
				$config['base_url'] = base_url('admincontrol/dashboard/after_finalprocess_pagewise_candidatestatus_list?rf_set='.$rf_set.'&advno='.$advno);
				$config['total_rows'] = $this->admin_m->count_AllFinalProcessDone_Candidate($advno);
			}else{
				$config['base_url'] = base_url('admincontrol/dashboard/after_finalprocess_pagewise_candidatestatus_list?rf_set='.$rf_set.'&advno='.$advno.'&pa_search='.$pa_search);
				$config['total_rows'] = $this->admin_m->count_AllFinalProcessDone_Candidate($advno, $pa_search);
			}
			$config['page_query_string'] = TRUE;
			//$config['use_page_numbers'] = TRUE;
			
			$config['per_page'] = 20;
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);

			$this->data['pagination'] = $this->pagination->create_links();

			if($page == NULL)
				$this->data['pageno'] = 0;
			else
				$this->data['pageno'] = $page;
		}

		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/afterfinal_process_pagewise_application_list', $this->data);
	}

	public function candidates_checking_details($candno = NULL){
		if($candno == NULL){
			redirect('default404');
		}
		$this->data['detail_result'] = $detail_result = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $candno))->row();
		$this->load->model('member_m');
		$this->data["fuser_detailset"] = $userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $candno))->row();
		//$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		$this->data["rejection_list"] = $this->member_m->gotocollect_AllRejection_Set($candno, "ALL");
		$this->data["check_log_list"] = $this->member_m->gotocheck_log_AllChecking_Set($candno);
		$this->data['allquali_list'] = $this->member_m->getAll_qualification_exam($userdetails->f_applied_for);
		$this->data['allexp_list'] = $this->member_m->getAll_Experience_section($userdetails->f_applied_for);
		$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All_forAdmin($userdetails->f_uid);
		$this->load->view('admin/profile/candidate_checking_details', $this->data);
		
	}

	public function candidates_checkingdetails_printsets($candno){
		$detail_result = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $candno))->row();
		$this->load->model('member_m');
		$fuser_detailset = $this->db->get_where('f_user_views', array('f_application_no' => $candno))->row();
		$rejection_list = $this->member_m->gotocollect_AllRejection_Set($candno, "ALL");
		$allquali_list = $this->member_m->getAll_qualification_exam($fuser_detailset->f_applied_for);
		$allexp_list = $this->member_m->getAll_Experience_section($fuser_detailset->f_applied_for);
		$extraage_list = $this->member_m->getAll_Existing_ExtraAgeSets_All_forAdmin($fuser_detailset->f_uid);
		
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = '';
		$obj_pdf->SetTitle('Advertisement');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Advertisement Notice');

		//$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		//$obj_pdf->setFooterData(array(0,64,0), array(0,64,128));

		//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//$obj_pdf->SetFont('helvetica', '', 9);
		//$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		</head>
		<body>
		<div class=\"header\">
		<table style=\"width: 100%\" style=\"font-size: 22px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 22px;\">
				<tr>
				<td style=\"width:100%;\">
					<div align=\"center\">
					<span style=\"font-size:28px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:24px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor)</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\">GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\"><u>www.wbhrb.in</u>, Phone : 2357-0085</span><br/></div>
				</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">
				<tr>
					<td><div align=\"center\">
					Registration No :- <strong>".$fuser_detailset->f_application_no."</strong><br/>
					Name :- <strong>".$fuser_detailset->f_full_name."</strong><br/>
					Mobile :- <strong>".$fuser_detailset->f_mobile."</strong> | Email :- <strong>".$fuser_detailset->f_email."</strong>
					</div>
					</td>
				</tr>";
				$my_html = $my_html."</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<br/><br/>
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 20px;\">
				<tr>
					<td><div align=\"left\">
					<strong>Checking Details :-</strong>";
					$str_arr = array(
						'fu_dob' => 'Date of Birth',
						'fu_address' => 'Address',
						'fu_photo_doc' => 'Photo',
						'fu_signature_doc' => 'Signature',
						'fu_caste' => 'Caste',
						'fu_pwd' => 'PWD',
						'fu_exempted' => 'Exempted',
						'fu_exservice' => 'Ex-Service',
						'fu_ews' => 'EWS',
						'fu_age_relax' => 'Age Relax',
						'fu_es_qualification' => 'Essential Qualification',
						'fu_ds_qualification' => 'Desirable Qualification',
						'fu_has_es_service' => 'Essential Experience',
						'fu_has_ds_service' => 'Desirable Experience'
					);
					foreach($rejection_list as $keys=>$reject_items){
						if($reject_items->chk_type == "fu_age_relax"){
							foreach($extraage_list as $extage_items){
								if($reject_items->chk_sub_typeid == $extage_items->fu_ext_ageid){
									$my_html = $my_html."<p><strong>".($keys+1).". ".$str_arr[$reject_items->chk_type]." || ".$extage_items->caste_name."</strong> - ".$reject_items->chk2_approve." by the HRB Administrator (Final Checked by ".$reject_items->firstname." ".$reject_items->lastname." on ".date('d/m/Y h:i A',strtotime($reject_items->chk2_appro_date)).")<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
									break;
								}
							}
						}elseif($reject_items->chk_type == "fu_es_qualification" || $reject_items->chk_type == "fu_ds_qualification"){
							foreach($allquali_list as $quali_items){
								if($reject_items->chk_sub_typeid == $quali_items->aquali_exam){
									$my_html = $my_html."<p><strong>".($keys+1).". ".$str_arr[$reject_items->chk_type]." || ".$quali_items->qm_name."</strong> - ".$reject_items->chk2_approve." by the HRB Administrator (Final Checked by ".$reject_items->firstname." ".$reject_items->lastname." on ".date('d/m/Y h:i A',strtotime($reject_items->chk2_appro_date)).")<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
									break;
								}
							}
						}elseif($reject_items->chk_type == "fu_has_es_service" || $reject_items->chk_type == "fu_has_ds_service"){
							foreach($allexp_list as $exp_items){
								if($reject_items->chk_sub_typeid == $exp_items->aexpr_name){
									$my_html = $my_html."<p><strong>".($keys+1).". ".$str_arr[$reject_items->chk_type]." || ".$exp_items->expset_name."</strong> - ".$reject_items->chk2_approve." by the HRB Administrator (Final Checked by ".$reject_items->firstname." ".$reject_items->lastname." on ".date('d/m/Y h:i A',strtotime($reject_items->chk2_appro_date)).")<br/><strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
									break;
								}
							}
						}else{
							$my_html = $my_html."<p><strong>".($keys+1).". ".$str_arr[$reject_items->chk_type]."</strong> - ".$reject_items->chk2_approve." by the HRB Administrator (Final Checked by ".$reject_items->firstname." ".$reject_items->lastname." on ".date('d/m/Y h:i A',strtotime($reject_items->chk2_appro_date)).")<br/>
							<strong>Detail Reason :</strong> ".$reject_items->chk2_comments."</p><hr/>";
						}
					} 
					$my_html = $my_html."</div>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		</div>
		</body>
		</html>";
		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($title . '.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');

		//$this->session->set_flashdata("success","Report is Generated Successfully");
		
	}

	public function resons_of_rejections($candno = NULL){
		if($candno == NULL){
			redirect('default404');
		}
		$this->data['detail_result'] = $detail_result = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $candno))->row();
		if($detail_result->cr_approval != "Rejected"){
			redirect('default404');
		}
		$this->load->model('member_m');
		$this->data["fuser_detailset"] = $userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $candno))->row();
		$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		$this->data["rejection_list"] = $this->member_m->gotocollect_AllRejection_Set($candno);
		$this->data['allquali_list'] = $this->member_m->getAll_qualification_exam($userdetails->f_applied_for);
		$this->data['allexp_list'] = $this->member_m->getAll_Experience_section($userdetails->f_applied_for);
		$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All_forAdmin($userdetails->f_uid);
		$this->load->view('admin/profile/candidate_rejection_details', $this->data);
		
	}

	public function candidate_rejection_approval($candno){
		if($candno == NULL || $candno == ""){
			redirect('default404');
		}
		$this->data['detail_result'] = $detail_result = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $candno))->row();
		if($detail_result->cr_approval == "Rejected"){
			$this->session->set_flashdata("e_error","Candidate is Already Rejected.");
		    redirect('admincontrol/candidates/comp_application_list','refresh');
		}
		$this->load->model('member_m');
		$this->load->model('candidates_m');
		$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candno);
		//$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		
		$this->load->view('admin/profile/candidate_rejection_view', $this->data);
	}

	public function cand_rejection_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
            $main_reason = $this->input->post('main_reason');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('main_reason', 'Reason', 'trim');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				
				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '5000';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();
							if($main_reason == ""){
								$main_reason = "HRB Administrator Reject the Application.";
							}
							$row_arr = array(
								'cr_approval' => "Rejected",
								'cr_reject_comments' => $main_reason,
								'cr_reject_document' => $upload_data['file_name'],
								'cr_admitcard_date' => date('Y-m-d H:i:s')
							);
							$this->load->model('candidates_m');
							if ($this->candidates_m->setUpdate_ResultCandidate_Appliwise($row_arr, $main_refid) == TRUE) {
								echo json_encode(array('msg' => 1));
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Advertisement Document is missing, Try again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
		}else{
			redirect('default404');
		}
	}

	public function print_finalprocess_dataset_afterallcheck($advno = NULL){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($advno == NULL){

		}
		$appli_list = $this->admin_m->GetDetailsofCandidate_afterFinal_Process_Application($advno);
		if(count((array)$appli_list) == 0){
			redirect('admincontrol/dashboard/after_finalprocess_candidatestatus_list');
		}
		$adv_listset = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Final Process Report";//$advice_detail->advice_name;
		//$obj_pdf->SetTitle($title);
		
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//$obj_pdf->SetDefaultMonospacedFont('helvetica');
		//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//$obj_pdf->SetFont('helvetica', '', 9);
		//$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		$html = '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<meta charset=\"utf-8\" />
		<title>Final Process Report</title>
		</head>
		<body>';
		$html.='<p align="center" style="font-size:24px;"><b>'.$adv_listset->rm_name.' | '.$adv_listset->adv_no.'</b></p>
		<p align="center" style="font-size:22px;"><b>FINAL PROCESS REPORT</b> | Date : '.date('d-m-Y').'</p>';							
		$html.='<div>
		<table style="width: 100%;font-size: 16px;" border="1" cellpadding="5">
		<tr>
		<td width="6%"><strong>Sl No.</strong></td>
		<td width="17%"><strong>Application No.</strong></td>
		<td width="21%"><strong>Applicant Name</strong></td>
		<td width="8%"><strong>Status</strong></td>
		<td width="21%"><strong>Reason of Rejection</strong></td>
		<td width="13%"><strong>Academic Marks</strong></td>
		<td width="14%"><strong>Experience Marks</strong></td>
		</tr>';
		foreach($appli_list as $keys=>$users){
			$html.='<tr>
			<td>'.($keys + 1).'</td>
			<td>'.$users->f_application_no.'</td>
			<td>'.$users->f_full_name.' ('.$users->f_mobile.')</td>
			<td>'.$users->cr_approval.'</td>
			<td>'.$users->cr_reject_comments.'</td>
			<td>'.$users->cr_academic.'</td>
			<td>'.$users->cr_experience.'</td>
			</tr>';
		}
		$html.='</table></div>';
		$html.= '</body></html>';			

		$obj_pdf->writeHTML($html, true, false, true, false, '');
				
		$obj_pdf->Output("Print_FinalProcessReport_".date('dmYHis').".pdf", "I");

	}

	public function freechecking_data_asper_advertisement(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$chkno = $this->input->post("chkno");
			$deloption = $this->input->post("deloption");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('deloption', 'ID', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'chkno'=>$chkno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['usr_list'] = $this->admin_m->checkUser_AdvertisementWise_withAccess($advno,'ALL');
				
				if($this->admin_m->cehckfor_freeup_All_theSkipsection_user($advno, $chkno, $deloption) == TRUE){
					//echo "reached";exit;
					if($this->admin_m->freeup_All_theSkipsection_Asper_user($advno, $chkno, $deloption) == TRUE){
						$this->session->set_flashdata("success","All Skip Data is Cleaned-Up successfully");
						redirect('admincontrol/dashboard/freechecking_data_asper_advertisement','refresh');
					}else{
						$this->data['error'] = "There have some problem to Update Data, Please try Again.";
					}
					//$this->data['result_utypes'] = $getresult_utypes = $this->db->get_where('user_info',array('u_id'=>$chkno))->row()->u_type;	
					//$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($advno, $chkno);
				}else{
					$this->data['error'] = "No Skip Data Available for Checker, Please try Again.";
				}	
				
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/profile/free_checking_view', $this->data);
	}

	public function marksentry_datewise_total_segrigation(){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$chkno = $this->input->post("chkno");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			
			$this->form_validation->set_rules('chkno', 'Checker', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('chkno'=>$chkno, 'sdate'=>$u_startdate, 'edate'=>$u_enddate);
				
				if(strtotime($u_enddate) > strtotime($u_startdate)){
					$ss_datetime = date('Y-m-d',strtotime($u_startdate));
					$ee_datetime = date('Y-m-d',strtotime($u_enddate));
					$this->data['all_dates'] = $datesets_all = $this->date_range_collect($ss_datetime, $ee_datetime);
					//print_r($datesets_all);exit;
					$icnt = 0;

					if($chkno != "ALL"){

						$get_finduser = $this->db->where('u_id',$chkno)->get('user_views')->row();
						$get_findall_dates = $this->admin_m->getAll_Datewise_GroupingUserCount_asper_MarksEntry($ss_datetime, $ee_datetime, $chkno);
						$getcount_dayall_counter = 0;
						$getcount_dayavg_counter = 0;
						$getcount_daywork_counter = 0;
						$this->data['appli_list'][$icnt] = array(
							'cheker_name' => ($get_finduser->firstname.' '.$get_finduser->lastname),
							'type_name' => $get_finduser->mu_name,
							'chktype' => $get_finduser->u_type
						);
						$this->data['appli_list'][$icnt]['t_days'] = array();
						for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
							$getcount_dayall = 0;
							foreach($get_findall_dates as $dateitems){
								if($dateitems->dates == $datesets_all[$daycnt]){
									$getcount_dayall = $dateitems->totals;
									break;
								}
							}
							$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
							$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
							if($getcount_dayall > 0){
								$getcount_daywork_counter++;
							}
						}
						if($getcount_daywork_counter == 0){
							$getcount_dayavg_counter = 0;
						}else{
							$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
						}
						$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
						$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
						$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
						
					}else{

						$get_findall_dates = $this->admin_m->getAll_Datewise_GroupingUserCount_asper_MarksEntry($ss_datetime, $ee_datetime);
						$get_alluser = $this->db->order_by('u_type','ASC')->where('user_status',1)->where_in('u_type',array(2,3))->get('user_views')->result();
						$icnt = 0;
						foreach($get_alluser as $keys=>$users){
							
							$getcount_dayall_counter = 0;
							$getcount_dayavg_counter = 0;
							$getcount_daywork_counter = 0;
							$this->data['appli_list'][$icnt] = array(
								'cheker_name' => ($users->firstname.' '.$users->lastname),
								'type_name' => $users->mu_name,
								'chktype' => $users->u_type
							);
							$this->data['appli_list'][$icnt]['t_days'] = array();
							for($daycnt = 0;$daycnt<count($datesets_all); $daycnt++){
								$getcount_dayall = 0;
								foreach($get_findall_dates as $dateitems){
									if($dateitems->dates == $datesets_all[$daycnt] && $users->u_id == $dateitems->chekers){
										$getcount_dayall = $dateitems->totals;
										break;
									}
								}
								$this->data['appli_list'][$icnt]['t_days'][$daycnt] = $getcount_dayall;
								$getcount_dayall_counter = $getcount_dayall_counter + $getcount_dayall;
								if($getcount_dayall > 0){
									$getcount_daywork_counter++;
								}
							}
							if($getcount_daywork_counter == 0){
								$getcount_dayavg_counter = 0;
							}else{
								$getcount_dayavg_counter = ceil($getcount_dayall_counter / $getcount_daywork_counter);
							}
							$this->data['appli_list'][$icnt]['t_all'] = $getcount_dayall_counter;
							$this->data['appli_list'][$icnt]['t_avg'] = $getcount_dayavg_counter;
							$this->data['appli_list'][$icnt]['t_work'] = $getcount_daywork_counter;
							$icnt++;
						}

						/*$this->data['total_list'] = array(
							'all_total' => 0,
							'all_days' => 0,
							'all_avg' => 0
						);*/
					}
					/*if($getresult_utypes == 3){
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime,$getresult_utypes);
					}else{
						$this->data['total_checkinglist'] = $this->admin_m->GetDetailsofCandidateChecking_ByChecker($ss_datetime,$ee_datetime);
					}*/
				}else{
					$this->data["error"] = "Start Date is bigger than End Date, Check it again.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['usr_list'] = $this->db->order_by('u_type ASC, firstname ASC')->where('user_status',1)->where_in('u_type',array(2,3))->get('user_views')->result();
		$this->load->view('admin/profile/datewise_marksentry_monitor_view', $this->data);
	}

	public function marksentry_monitoring_pdf_sets(){
		if($_POST){
			$data_result = $this->input->post('div_data');
			error_reporting(0);
			$this->load->helper("tcpdf_helper");
			tcpdf();
			$obj_pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "Marks Entry - Report";//$advice_detail->advice_name;
			//$obj_pdf->SetTitle($title);
			
			$obj_pdf->SetPrintHeader(false);
			$obj_pdf->SetPrintFooter(false);
			//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
			//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			//$obj_pdf->SetDefaultMonospacedFont('helvetica');
			//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			//$obj_pdf->SetFont('helvetica', '', 9);
			//$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();

			$html = '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
			<html xmlns=\"http://www.w3.org/1999/xhtml\">
			<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
			<meta charset=\"utf-8\" />
			<title>Marks Entry - Report</title>
			</head>
			<body>';
			
			$html.='<div style="font-size:20px;">'.$data_result.'</div>';
			$html.= '</body></html>';			

			$obj_pdf->writeHTML($html, true, false, true, false, '');
					
			$obj_pdf->Output("Print_Report_".date('dmYHis').".pdf", "I");
		}
	}

	protected function date_range_collect($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {

		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);
	
		while( $current <= $last ) {
	
			$dates[] = date($output_format, $current);
			$current = strtotime($step, $current);
		}
	
		return $dates;
	}

}
