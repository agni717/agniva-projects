<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
    }
	
	public function index()
	{
		redirect('login');
		/*if($this->input->post('submit') == "Submit"){
			$usertype = $this->input->post('usertype');
			$this->form_validation->set_rules('usertype', 'Choice', 'required');
			if($this->form_validation->run() == TRUE)
            {	
				set_cookie('user_type_set', $usertype, '600');
				redirect('main/home');
				//set_cookie('user_type_set', $usertype, '86400');
				//echo $usertype;exit;
			}
		}elseif($this->input->post('skip') == "Skip"){
			
			set_cookie('user_type_set', 'Others', '600');
			redirect('main/home');
			//set_cookie('user_type_set', 'Others', '86400');
			//echo "ads";exit;
		}
		if(!empty(get_cookie('user_type_set'))) {
			//echo get_cookie('user_type_set');exit;
			redirect('main/home');
		}*/
		$this->load->view('main/main_view');
	}
	
	/*public function home(){
		$cookieval = "";
		if(!empty(get_cookie('user_type_set'))) {
			$cookieval = get_cookie('user_type_set');
		}
		if($cookieval == "Farmer"){
			$this->load->view('main/home_view_farmer', $this->data);
		}elseif($cookieval == "Student"){
			$this->load->view('main/home_view_student', $this->data);
		}elseif($cookieval == "Entrepreneur"){
			$this->load->view('main/home_view_entp', $this->data);
		}else{
			$this->load->view('main/home_view', $this->data);
		}
	}*/
	
	public function new_user_signup(){
		//redirect('login');
		$this->load->model('member_m');
		$member = 'member';
        if($this->member_m->member_loggedin() == TRUE) redirect($member);
		if($_POST){
			$fu_type = $this->input->post('fu_type');
			$fu_name = $this->input->post('fu_name');
			$fu_email = $this->input->post('fu_email');
			$fu_mobile = $this->input->post('fu_mobile');
			$fu_password = $this->input->post('fu_password');
			$fu_re_password = $this->input->post('fu_re_password');
			$fu_address = $this->input->post('fu_address');
			$fu_qualification = $this->input->post('fu_qualification');
			$fu_gender = $this->input->post('fu_gender');
			$fu_city = $this->input->post('fu_city');
			$fu_pincode = $this->input->post('fu_pincode');
			
			$this->form_validation->set_rules('fu_type', 'User Type', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('fu_name', 'Full Name', 'trim|required');
			$this->form_validation->set_rules('fu_email', 'Email', 'trim|valid_email');
            $this->form_validation->set_rules('fu_mobile', 'Mobile', 'trim|required|exact_length[10]|is_natural');
			$this->form_validation->set_rules('fu_password', 'Password', 'trim|required');
            $this->form_validation->set_rules('fu_re_password', 'Re-Password', 'trim|required|matches[fu_password]');
			$this->form_validation->set_rules('fu_address', 'Address', 'trim');
            $this->form_validation->set_rules('fu_qualification', 'Qualification', 'trim');
            $this->form_validation->set_rules('fu_gender', 'Gender', 'trim|required|alpha');
			$this->form_validation->set_rules('fu_city', 'City', 'trim');
			$this->form_validation->set_rules('fu_pincode', 'Pincode', 'trim|is_natural');
			
			if($this->form_validation->run() == TRUE)
            {
				if($this->main_m->checkAll_for_Mobile_Validate($fu_mobile) == TRUE){
					$enc_pass = $this->member_m->hash(trim($fu_password));
					$row_array = array(
						'f_utype' => $fu_type,
						'f_mobile' => $fu_mobile,
						'f_password' => $enc_pass,
						'f_full_name' => trim($fu_name),
						'f_email' => trim($fu_email),
						'f_qualification' => trim($fu_qualification),
						'f_gender' => trim($fu_gender),
						'f_address' => trim($fu_address),
						'f_district' => trim($fu_city),
						'f_pincode' => trim($fu_pincode),
						'f_createdate' => date('Y-m-d H:i:s')
					);
					if($this->main_m->addform_against_user_signup_update($row_array) == TRUE){
						/*$profile_email = $ap_email;
						$e_sub = "Permission Application - Bankura";
						$e_msg = '<h2>Welcome to Portal for Permission to resume works in Bankura District<br/>(During Lockdown period of COVID-19)</h2><p style="font-size:18px;">Dear '.$row_array['appli_name'].',<br/>Your Application Form is submitted Successfully.<br/>Your Application Number :- <strong>'.$random_keys.'</strong></p>';
						$this->sendSMTPEmail($profile_email, $e_sub, $e_msg);*/
						$this->session->set_flashdata("success","User Registration submitted successfully.");
						redirect('login','refresh');
					}else{
						$this->data['error'] = "There have some problem to Update DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Mobile number Already Registered in the System, Try Aanother one.";
				}
			}
		}
		//$this->data['utype_list'] = $this->db->get_where('frontend_user_type',array('ftype_status'=>1))->result();
		$this->data['adv_list'] = $actadv_sets = $this->main_m->getAll_list_of_Active_Advertisement();
		if(count((array)$actadv_sets) == 0){
			redirect('login');
		}
		$this->load->view('main/signup_view', $this->data);
	}
	
	public function get_otp_forlogin_candidates(){
		if($_POST){
			$fu_apply = $this->input->post('fu_apply');
			$fu_mobile = $this->input->post('fu_mobile');
			
			$this->form_validation->set_rules('fu_apply', 'Apply For', 'trim|required');
			$this->form_validation->set_rules('fu_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
			
			$msg = 0;
			if($this->form_validation->run() == TRUE)
            {
				if($this->main_m->check_mobile_existence_forRegistration_confirm($fu_mobile, $fu_apply) == FALSE){
					
					$generate_otp = $this->generateRandomString(6);
					$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile,'f_registered'=>1,'f_status'=>1))->row();
					$row_arr = array(
						'f_otp' => $generate_otp,
						'f_otp_count' => ($detailset->f_otp_count + 1),
						'f_otp_sendtime' => date('Y-m-d H:i:s')
					);
					if($this->main_m->insertRegistration_details_intheDB($row_arr, $detailset->f_uid) == TRUE){
						/*$generate_sms_strings = "YOUR ONE TIME PASSWORD IS - ".$generate_otp.". HRB Candidate Login";
						$sms_feed_recv = $this->sendSMS_via_thirdParty($fu_mobile, $generate_sms_strings);*/
						$htmldataset = '<html><body><h1>Thank you for login in WBHRB website.<br/>Your ONE TIME PASSWORD IS - '.$generate_otp.'</h1></body></html>';
						$msg111 = 'Thank you for login in WBHRB website. Your OTP is '.$generate_otp.'.';
						$smsreplyset = $this->sendALLSMS($msg111, $detailset->f_mobile, "otpmsg", '1207163455580746477');
						$smsarray = explode(',', $smsreplyset);
						$emailset = $this->sendALLSMTPEmail($detailset->f_email,'WBHRB - Login', $htmldataset);
						/*$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_email'=>$fu_mobile))->row();
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => ''));*/
						if($emailset == true || $smsarray[0] == 402){
							//$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile))->row();
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => ''));
							//echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no));
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>'SMS not Send Properly, Try Again.'));
						}
						
					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'DB Updation problem, Try Again'));
					}
					
				}else{
					echo json_encode(array('msg'=>$msg, 'e_msg'=>'Mobile No. Not Register Yet, Check Again.'));
				}
				
			}else{
				echo json_encode(array('msg'=>$msg, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function otp_check_frontend_candidates_login(){
		if($_POST){
			$fu_apply = $this->input->post('fu_apply');
			$fu_mobile = $this->input->post('fu_mobile');
			$otp_sign = $this->input->post('otp_sign');
			$uset_app = $this->input->post('uset_app');
			
			$this->form_validation->set_rules('fu_apply', 'Apply For', 'trim|required');
			$this->form_validation->set_rules('fu_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
            $this->form_validation->set_rules('otp_sign', 'OTP', 'trim|required|is_natural');
            $this->form_validation->set_rules('uset_app', 'Login Data', 'trim|required');
			
			if($this->form_validation->run() == TRUE)
            {
				if($this->main_m->check_mobile_existence_forRegistration_confirm($fu_mobile, $fu_apply) == FALSE){
					
					$detailset = $this->db->get_where('frontend_users',array('f_application_no'=>$uset_app,'f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile,'f_registered'=>1,'f_status'=>1))->row();
					if($detailset->f_otp == $otp_sign){
						$row_arr = array(
							'f_otp' => NULL,
							'f_modifydate' => date('Y-m-d H:i:s')
						);
						if($this->main_m->insertRegistration_details_intheDB($row_arr, $detailset->f_uid) == TRUE){
							if($this->main_m->checkRegister_member($fu_mobile, $fu_apply) == TRUE){
								$pathurl = "upload_file/".$detailset->f_applied_for."/candidates/".$detailset->f_application_no;
								if (!file_exists($pathurl)) {
									//mkdir('path/to/directory', 0777, true);
									mkdir($pathurl);
								}
								$now_arr = array(
									'fu_log_user' => $this->session->userdata('member_id'),
									'fu_log_time' => date('Y-m-d H:i:s'),
									'fu_log_ip' => 'OK' //$_SERVER['HTTP_X_FORWARDED_FOR'] //$this->input->ip_address()
								);
								$this->main_m->update_Candidate_user_log($now_arr);
								echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no));
							}
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>'Login process not Update properly, Try Again'));
						}
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>'OTP Not Matched, Check Again.'));
					}
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>'Mobile No. Not Register Yet, Check Again.'));
				}
				
			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	


	public function get_otp_frontend_candidates(){
		if($_POST){
			$fu_apply = $this->input->post('fu_apply');
			$fu_name = $this->input->post('fu_name');
			$fu_email = $this->input->post('fu_email');
			$fu_mobile = $this->input->post('fu_mobile');
			
			$this->form_validation->set_rules('fu_apply', 'Apply For', 'trim|required');
			$this->form_validation->set_rules('fu_name', 'Full Name', 'trim|required');
			$this->form_validation->set_rules('fu_email', 'Email-ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('fu_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
			
			$msg = 0;
			if($this->form_validation->run() == TRUE)
            {
				
				if($this->main_m->check_mobile_existence_forRegistration($fu_mobile, $fu_apply) == TRUE){
					
					//print_r($chk_exist);
					$email_generate_otp = $this->generateRandomString(6);
					$generate_otp = $this->generateRandomString(6);
					$app_no = 'C'.date('dmYhis').$this->generateRandomString();
					$row_arr = array(
						'f_applied_for' => $fu_apply,
						'f_application_no' => $app_no,
						'f_mobile' => $fu_mobile,
						'f_full_name' => $fu_name,
						'f_email' => $fu_email,
						'f_email_otp' => $email_generate_otp,
						'f_otp' => $generate_otp,
						'f_otp_count' => 1,
						'f_otp_sendtime' => date('Y-m-d H:i:s'),
						'f_createdate' => date('Y-m-d H:i:s')
					);
					if($this->main_m->insertRegistration_details_intheDB($row_arr) == TRUE){
						$htmldataset = '<html><body><h1>Thank you for Registration in WBHRB website.<br/>Your ONE TIME PASSWORD IS - '.$email_generate_otp.'</h1></body></html>';
							
						$msg111 = 'Thank you for login in WBHRB website. Your OTP is '.$email_generate_otp.'.';
						$smsreplyset = $this->sendALLSMS($msg111, $fu_mobile, "otpmsg", '1207163455580746477');
						$smsarray = explode(',', $smsreplyset);
						$emailset = $this->sendALLSMTPEmail($fu_email,'WBHRB - Registration', $htmldataset);
						//if($smsarray[0] == 402){}
						if($emailset == true || $smsarray[0] == 402){
							
							$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile))->row();
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => $generate_otp));
							//echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => $generate_otp, 'mailsms' => $email_generate_otp));
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>'EMAIL Not Send Properly, Check Again.'));
						}
						//Send Email with($fu_email, $email_generate_otp)
						/*$generate_sms_strings = "YOUR ONE TIME PASSWORD IS - ".$generate_otp.". HRB Candidate Login";
						$sms_feed_recv = $this->sendSMS_via_thirdParty($fu_mobile, $generate_sms_strings);*/
						
						//echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no));
					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'Registration not Done properly, Try Again'));
					}
					
				}elseif($this->main_m->check_mobile_existence_forRegistration_confirm($fu_mobile, $fu_apply) == TRUE){
					$email_generate_otp = $this->generateRandomString(6);
					$generate_otp = $this->generateRandomString(6);
					$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile,'f_registered'=>0))->row();
					$row_arr = array(
						'f_full_name' => $fu_name,
						'f_email' => $fu_email,
						'f_email_otp' => $email_generate_otp,
						'f_otp' => $generate_otp,
						'f_otp_count' => ($detailset->f_otp_count + 1),
						'f_otp_sendtime' => date('Y-m-d H:i:s')
					);
					if($this->main_m->insertRegistration_details_intheDB($row_arr, $detailset->f_uid) == TRUE){
						//Send Email with($fu_email, $email_generate_otp)
						/*$generate_sms_strings = "YOUR ONE TIME PASSWORD IS - ".$generate_otp.". HRB Candidate Login";
						$sms_feed_recv = $this->sendSMS_via_thirdParty($fu_mobile, $generate_sms_strings);*/
						$htmldataset = '<html><body><h1>Thank you for Registration in WBHRB website.<br/>Your ONE TIME PASSWORD IS - '.$email_generate_otp.'</h1></body></html>';
						
						if($this->sendALLSMTPEmail($fu_email,'WBHRB - Registration', $htmldataset)== true){
							$detailset = $this->db->get_where('frontend_users',array('f_applied_for'=>$fu_apply,'f_mobile'=>$fu_mobile))->row();
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => $generate_otp));
							//echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no, 'mobsms' => $generate_otp, 'mailsms' => $email_generate_otp));
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>'EMAIL Not Send Properly, Check Again.'));
						}

						//echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no));
					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'Registration not Done properly, Try Again'));
					}
					
				}else{
					echo json_encode(array('msg'=>$msg, 'e_msg'=>'Mobile Number Already Registered, Check Again.'));
				}
				
			}else{
				echo json_encode(array('msg'=>$msg, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function otp_check_frontend_candidates_signup(){
		if($_POST){
			$fu_apply = $this->input->post('fu_apply');
			$fu_name = $this->input->post('fu_name');
			$fu_email = $this->input->post('fu_email');
			$fu_mobile = $this->input->post('fu_mobile');
			$emailotp_sign = $this->input->post('emailotp_sign');
			$otp_sign = $this->input->post('otp_sign');
			$uset_app = $this->input->post('uset_app');
			
			$this->form_validation->set_rules('fu_apply', 'Apply For', 'trim|required');
			$this->form_validation->set_rules('fu_name', 'Full Name', 'trim|required');
			$this->form_validation->set_rules('fu_email', 'Email-ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('fu_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
            $this->form_validation->set_rules('emailotp_sign', 'Email OTP', 'trim|required|is_natural');
            $this->form_validation->set_rules('otp_sign', 'Authenticate Code', 'trim|required|is_natural');
            $this->form_validation->set_rules('uset_app', 'Registration Data', 'trim|required');
			
			if($this->form_validation->run() == TRUE)
            {
				if($this->main_m->check_mobile_existence_forRegistration_confirm($fu_mobile, $fu_apply) == TRUE){
					
					$detailset = $this->db->get_where('frontend_users',array('f_application_no'=>$uset_app,'f_registered'=>0))->row();
					if(($detailset->f_otp == $otp_sign) && ($detailset->f_email_otp == $emailotp_sign)){
						$row_arr = array(
							'f_otp' => NULL,
							'f_registered' => 1,
							'f_modifydate' => date('Y-m-d H:i:s')
						);
						if($this->main_m->insertRegistration_details_intheDB($row_arr, $detailset->f_uid) == TRUE){
							if($this->main_m->checkRegister_member($fu_mobile, $fu_apply) == TRUE){
								//mkdir(base_url()."upload_file/candidates/".$detailset->f_application_no);
								mkdir("upload_file/".$detailset->f_applied_for."/candidates/".$detailset->f_application_no);
								$now_arr = array(
									'fu_log_user' => $this->session->userdata('member_id'),
									'fu_log_time' => date('Y-m-d H:i:s'),
									'fu_log_ip' => 'OK' //$_SERVER['HTTP_X_FORWARDED_FOR'] //$this->input->ip_address()
								);
								$this->main_m->update_Candidate_user_log($now_arr);
								$this->main_m->init_candidate_result_tab($detailset->f_application_no);
								echo json_encode(array('msg'=>1, 's_msg' => $detailset->f_application_no));
							}
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>'Registration not Update properly, Try Again'));
						}
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>'Authenticate Code OR Email OTP Not Matched, Check Again.'));
					}
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>'Mobile Number Already Registered, Check Again.'));
				}
				
			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function backto_login(){
		if(!empty($this->session->userdata('fusr_mob'))){
			$this->session->unset_userdata('fusr_mob');
		}
		if(!empty($this->session->userdata('fusr_OTP'))){
			$this->session->unset_userdata('fusr_mob');
		}
		redirect('login');
	}
	
	public function forgot_password(){
		$this->load->model('member_m');
		$member = 'member';
        if($this->member_m->member_loggedin() == TRUE) redirect($member);
		if($_POST){
			$user_mobile = $this->input->post('user_mobile');
			$this->form_validation->set_rules('user_mobile', 'Registered Mobile', 'trim|required|exact_length[10]|is_natural');
			if($this->form_validation->run() == TRUE)
            {
				$fuser_details = $this->db->get_where('frontend_users',array('f_mobile'=>$user_mobile))->row();
				if(count((array)$fuser_details) > 0){
					
					$counterotp = $fuser_details->f_otp_count + 1;
					if($counterotp < 6){
						$random_no = $this->generateRandomString(6);
						$row_array = array(
							'f_otp' => $random_no,
							'f_otp_count' => $counterotp,
							'f_otp_sendtime' => date('Y-m-d H:i:s')
						);
						if($this->main_m->addform_against_user_signup_update($row_array, $fuser_details->f_uid) == TRUE){
							$this->session->set_userdata('fusr_mob', $user_mobile);
							$this->session->set_userdata('fusr_resend', 1);
							$this->session->set_flashdata("success","OTP is send successfully to the Registered Mobile Number");
							redirect('main/otp_forgot_password','refresh');
						}else{
							$this->data['error'] = "There have some problem to Update DB, Try Again.";
						}
					}else{
						$curent_time = date('Y-m-d H:i:s');
						$otp_update_time = date("Y-m-d H:i:s", strtotime("+24 hours", strtotime($fuser_details->f_otp_sendtime)));
						if(strtotime($curent_time) >= strtotime($otp_update_time)){
							$random_no = $this->generateRandomString(6);
							$row_array = array(
								'f_otp' => $random_no,
								'f_otp_count' => 1,
								'f_otp_sendtime' => date('Y-m-d H:i:s')
							);
							if($this->main_m->addform_against_user_signup_update($row_array, $fuser_details->f_uid) == TRUE){
								$this->session->set_userdata('fusr_mob', $user_mobile);
								$this->session->set_userdata('fusr_resend', 1);
								$this->session->set_flashdata("success","OTP is send successfully to the Registered Mobile Number");
								redirect('main/otp_forgot_password','refresh');
							}else{
								$this->data['error'] = "There have some problem to Update DB, Try Again.";
							}
						}else{
							$timediff = strtotime($otp_update_time) - strtotime($curent_time);
							$timediff_minutes = ceil($timediff / 60);
							$timediff_hours = floor($timediff_minutes / 60);
							$left_minutes = ceil($timediff_minutes % 60);
							$this->data['error'] = "Already send 5 times, Try after ".$timediff_hours." Hours ".($left_minutes)." Minutes";
						}
					}
				}else{
					$this->data['error'] = "Mobile Number Not Registered Yet, Check Again.";
				}
			}
		}
		$this->load->view('main/forgot_pass_view', $this->data);
	}
	
	public function resend_otp_for_forgotpass(){
		$this->load->model('member_m');
		$member = 'member';
        if($this->member_m->member_loggedin() == TRUE) redirect($member);
		
		if(empty($this->session->userdata('fusr_mob'))){
			redirect('main/forgot_password');
		}
		if(empty($this->session->userdata('fusr_resend'))){
			redirect('main/forgot_password');
		}
		$fuser_details = $this->db->get_where('frontend_users',array('f_mobile'=>$this->session->userdata('fusr_mob')))->row();
		if(count((array)$fuser_details) > 0){
			$counterotp = $fuser_details->f_otp_count + 1;
			$random_no = $this->generateRandomString(6);
			$row_array = array(
				'f_otp' => $random_no,
				'f_otp_count' => $counterotp,
				'f_otp_sendtime' => date('Y-m-d H:i:s')
			);
			if($this->main_m->addform_against_user_signup_update($row_array, $fuser_details->f_uid) == TRUE){
				$this->session->unset_userdata('fusr_resend');
				$this->session->set_flashdata("success","OTP is send Again to the Registered Mobile Number");
				redirect('main/otp_forgot_password','refresh');
			}else{
				$this->session->set_flashdata("e_error","There have some problem to Update DB, Try Again.");
				redirect('main/otp_forgot_password','refresh');
			}
		}else{
			$this->session->set_flashdata("e_error","Mobile Number Not Registered Yet, Check Again.");
			redirect('main/otp_forgot_password','refresh');
		}
		
	}
	
	public function otp_forgot_password(){
		$this->load->model('member_m');
		$member = 'member';
        if($this->member_m->member_loggedin() == TRUE) redirect($member);
		
		if(empty($this->session->userdata('fusr_mob'))){
			redirect('main/forgot_password');
		}
		if($_POST){
			$user_otp = $this->input->post('user_otp');
			$this->form_validation->set_rules('user_otp', 'OTP', 'trim|required');
			if($this->form_validation->run() == TRUE)
            {
				$fuser_details = $this->db->get_where('frontend_users',array('f_mobile'=>$this->session->userdata('fusr_mob'), 'f_otp'=>trim($user_otp)))->row();
				if(count((array)$fuser_details) > 0){
					$this->session->set_userdata('fusr_OTP', 'OK');
					$this->session->set_flashdata("success","OTP is checked. Reset Your Password Now");
					redirect('main/reset_password','refresh');
				}else{
					$this->data['error'] = "OTP not matched, Try Again.";
				}
			}
		}
		$this->load->view('main/otp_forgot_pass_view', $this->data);
	}
	
	public function reset_password(){
		$this->load->model('member_m');
		$member = 'member';
        if($this->member_m->member_loggedin() == TRUE) redirect($member);
		
		if(empty($this->session->userdata('fusr_mob')) || empty($this->session->userdata('fusr_OTP'))){
			redirect('main/forgot_password');
		}
		if($_POST){
			$user_pass = $this->input->post('user_pass');
			$user_repass = $this->input->post('user_repass');
			$this->form_validation->set_rules('user_pass', 'Password', 'trim|required');
			$this->form_validation->set_rules('user_repass', 'Re-Password', 'trim|required|matches[user_pass]');
			if($this->form_validation->run() == TRUE)
            {
				$fuser_details = $this->db->get_where('frontend_users',array('f_mobile'=>$this->session->userdata('fusr_mob')))->row();
				$enc_pass = $this->member_m->hash(trim($user_pass));
				$row_array = array(
					'f_otp_count' => 0,
					'f_password' => $enc_pass
				);
				if($this->main_m->addform_against_user_signup_update($row_array, $fuser_details->f_uid) == TRUE){
					$this->session->unset_userdata('fusr_mob');
					$this->session->unset_userdata('fusr_OTP');
					$this->session->set_flashdata("success","Password is reset successfully. Login Now");
					redirect('login','refresh');
				}else{
					$this->data['error'] = "There have some problem to Update DB, Try Again.";
				}
			}
		}
		$this->load->view('main/reset_pass_view', $this->data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	protected function generateRandomString($length = 4){
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function get_block_police_by_subdiv(){
		if($_POST){
			$ap_subdiv = $this->input->post('ap_subdiv');
			$msg = 0;
			if($ap_subdiv != ""){
				$response_block = $this->db->get_where('block_tab',array('master_subdiv'=>$ap_subdiv,'block_status'=>1))->result();
				$response_ps = $this->db->get_where('police_station_tab',array('ps_master_sub'=>$ap_subdiv,'ps_status'=>1))->result();
				$block_list = '<option value="">---Select---</option>';
				$ps_list = '<option value="">---Select---</option>';
				
				if(count((array)$response_block) > 0 && count((array)$response_ps) > 0){
					foreach($response_block as $blocks){
						$block_list = $block_list.'<option value="'.$blocks->block_id.'">'.$blocks->block_name.'</option>';
					}
					foreach($response_ps as $po_set){
						$ps_list = $ps_list.'<option value="'.$po_set->ps_id.'">'.$po_set->ps_name.'</option>';
					}
					echo json_encode(array('msg'=>1, 'block_set' => $block_list, 'ps_set' => $ps_list));
				}else{
					echo json_encode(array('msg'=>$msg));
				}
			}else{
				echo json_encode(array('msg'=>$msg));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function get_gp_by_block_subdiv(){
		if($_POST){
			$ap_subdiv = $this->input->post('ap_subdiv');
			$ap_block = $this->input->post('ap_block');
			$msg = 0;
			if($ap_subdiv != "" && $ap_block != ""){
				$response_gp = $this->db->get_where('gp_tab',array('master_sub'=>$ap_subdiv, 'master_block'=>$ap_block, 'gp_status'=>1))->result();
				$gp_list = '<option value="">---Select---</option>';
				
				if(count((array)$response_gp) > 0){
					foreach($response_gp as $gp_s){
						$gp_list = $gp_list.'<option value="'.$gp_s->gp_id.'">'.$gp_s->gp_name.'</option>';
					}
					echo json_encode(array('msg'=>1, 'gp_set' => $gp_list));
				}else{
					echo json_encode(array('msg'=>$msg));
				}
			}else{
				echo json_encode(array('msg'=>$msg));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function application_status(){
		if($_POST){
			$ap_no = $this->input->post('ap_no');
			$this->form_validation->set_rules('ap_no', 'Application No', 'trim|required|is_natural');
			if($this->form_validation->run() == TRUE)
            {
				$a_detail = $this->db->get_where('full_application',array('app_ucode'=>$ap_no))->row();
				if(count((array)$a_detail) > 0){
					$this->data['doc_detail'] = $a_detail;
				}else{
					$this->data['error'] = "Application Not Found, Check again.";
				}
			}
		}
		$this->load->view('main/status_view', $this->data);
	}

	public function application_receipt($ap_no = NULL){
		$a_detail = $this->db->get_where('full_application',array('app_ucode'=>$ap_no))->row();
		if(count((array)$a_detail) > 0){
			if($a_detail->appli_status != 1){
				redirect('default404');
			}
			$this->data['doc_detail'] = $a_detail;
		}else{
			redirect('default404');
		}
		$this->load->view('main/receipt_view', $this->data);
	}



	public function print_final_permission_sheet($app_no = NULL)
	{
		//print_r($this->session->userdata('uid'));exit;
		if($app_no == "" || $app_no == NULL){
			redirect('default404');
		}
		
		$app_details = $this->db->get_where('full_application',array('app_ucode'=>$app_no))->row();
		
		if(count((array)$app_details) == 0){
			redirect('default404');
		}
		if($app_details->appli_status != 3){
			redirect('default404');
		}
		$copy_arr = explode(",", $app_details->appli_copy_fwd);
		$copy_set = $this->main_m->get_all_conditions_copys_DB($app_details->appli_copy_fwd);
		if(count((array)$copy_set) == 0){
			redirect('default404');
		}
		//echo "hi";exit;
		$this->load->helper("tcpdf_helper");
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $app_no;
		$obj_pdf->SetTitle($title);
		
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		
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
		//ob_start();
		    // we can have any view part here like HTML, PHP etc


		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>".$title."</title>
		</head>
		<body>
		<div class=\"header\">";	
		$my_html = $my_html."<table style=\"width: 100%\" style=\"font-size: 20px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\"><div align=\"center\" style=\"font-size:22px;\"><img src=\"".base_url()."images/wb_logo.png\" /><br/>GOVERNMENT OF WEST BENGAL<br/>
			OFFICE OF THE DISTRICT MAGISTRATE<br/>
			BANKURA</div></td>
		</tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr><td colspan=\"2\"><hr/>
			<table width=\"100%\" style=\"font-size: 20px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
				<tr><td><b>Ph. No.</b> Office: 03242-255450</td>
				<td align=\"right\"><b>E-mail:</b> aeozp-bnk@nic.in, aeozp.bnk@gmail.com</td></tr>
			</table>
			<hr/></td></tr>
		<tr>
			<td align=\"left\"><b>Memo No.</b> ".$app_details->appli_memo_no."</td>
			<td align=\"right\">Date:- <strong>".date('d/m/Y',strtotime($app_details->appli_memo_date))."</strong></td>
		</tr>
		<tr>
			<td colspan=\"2\"><br/><br/>
			<table width=\"100%\" style=\"font-size: 20px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
				<tr>
					<td><b>To,<br/>
					".$app_details->appli_name."<br/>
					".$app_details->appli_mobile."<br/>
					".$app_details->appli_address."<br/>
					".$app_details->app_ucode."<br/></b>
					</td>
					<td colspan=\"2\">&nbsp;</td>
				</tr>
				<tr>
					<td colspan=\"3\" align=\"center\"><b>Sub:</b> Grant of Permission in reference to your application for the work <b>".$app_details->appli_work."</b> and undertaking dated ".date('d/m/Y',strtotime($app_details->appli_createdate))."<br/></td>
				</tr>
				<tr>
					<td colspan=\"3\">
					<p align=\"justify\"><b>Sir,</b><br/>
					In reference to your application for starting operations during the current lockdown period, permission is granted for <b>".$app_details->appli_worker."</b> nos of employees subject to fulfillment of conditions as mentioned in guideline issued vide Memo No. 652/WBSRDA/IE-5/2017 Dated 22/04/2020 issued by P&RD Deptt., Govt. of West Bengal and fulfilling all other statutory obligations as applicable.</p>
					<p>The following conditions are reiterated.</p>
					</td>
				</tr>
				<tr>
					<td colspan=\"3\">";
				foreach($copy_set as $keyset=>$condis){
					$my_html = $my_html.($keyset + 1).". ".$condis->cf_title."<br/>";
				}
				$my_html = $my_html."</td>
				</tr>
				<tr>
					<td colspan=\"3\">
					<p align=\"justify\">Please note that you are liable to be prosecuted as given in above mentioned memo for submitting incorrect
					information or for violation of any lockdown measures.</p>
					</td>
				</tr>
				</table><br/><br/>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align=\"center\"><div align=\"center\"><img src=\"".base_url()."images/signature.jpg\" />
			<br/>Additional District Magistrate (ZP), Bankura</div></td>
		</tr>
		<tr>
			<td colspan=\"2\">&nbsp;</td>
		</tr>
		<tr>
			<td align=\"left\"><b>Memo No.</b> ".$app_details->appli_memo_no."</td>
			<td align=\"right\">Date:- <strong>".date('d/m/Y',strtotime($app_details->appli_memo_date))."</strong></td>
		</tr>
		<tr>
			<td colspan=\"2\">&nbsp;</td>
		</tr>
		<tr>
			<td colspan=\"2\"><p>Copy forwarded for kind information and necessary action to the -</p></td>
		</tr>
		<tr>
			<td colspan=\"2\">
			<p>1. Sub Divisional Officer, ".$app_details->sub_div_name." Sub Division<br/>
			2. SDPO, ".$app_details->sub_div_name." Sub Division<br/>
			3. Block Development Officer, ".$app_details->block_name." Development Block<br/>
			4. IC/OC, ".$app_details->ps_name." Police Station<br/>
			5. Pradhan, ".$app_details->gp_name." Gram Panchayat
			</p></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align=\"center\"><div align=\"center\"><img src=\"".base_url()."images/signature.jpg\" />
			<br/>Additional District Magistrate (ZP), Bankura</div></td>
		</tr>
		</table>
		</div>
		</body>
		</html>";
		
		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($app_no.'.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');
		
		//$this->session->set_flashdata("success","Report is Generated Successfully");
		
	}
	
	public function savestudent_register_details(){
		
		if($_POST){
			$stu_name = $this->input->post('stu_name');
			$stu_email = $this->input->post('stu_email');
			$stu_mobile = $this->input->post('stu_mobile');
			$stu_qualification = $this->input->post('stu_qualification');
			$stu_dob = $this->input->post('stu_dob');
			$stu_caste = $this->input->post('stu_caste');
			$stu_address = $this->input->post('stu_address');
			$stu_interest = $this->input->post('stu_interest');
			$stu_username = $this->input->post('stu_username');
			$stu_pass = $this->input->post('stu_pass');
			$conf_pass = $this->input->post('conf_pass');
			$msg = 0;
			//user.png
			$this->form_validation->set_rules('stu_name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('stu_email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('stu_mobile', 'Mobile', 'trim|required|exact_length[10]|xss_clean|is_natural');
            $this->form_validation->set_rules('stu_qualification', 'Qualification', 'trim|required|xss_clean');
            $this->form_validation->set_rules('stu_dob', 'Date of Birth', 'trim|required|xss_clean');
            $this->form_validation->set_rules('stu_caste', 'Caste', 'trim|xss_clean');
            $this->form_validation->set_rules('stu_address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('stu_interest', 'Interest', 'trim|required|xss_clean');
            $this->form_validation->set_rules('stu_username', 'Username', 'trim|required|xss_clean|alpha_dash|is_unique[student_information.student_username]');
            $this->form_validation->set_rules('stu_pass', 'Password', 'trim|required|min_length[6]|xss_clean|matches[conf_pass]');
            $this->form_validation->set_rules('conf_pass', 'Confirm Password', 'trim|required|xss_clean|matches[stu_pass]');
            
			if($this->form_validation->run() == TRUE)
            {	
            	$random_string = '';
				for ($i = 0; $i<6; $i++) 
				{
				    $random_string .= mt_rand(0,9);
				}
				
				$current_time = date('Y-m-d H:i:s');
				$valid_time = date('Y-m-d H:i:s',strtotime($current_time."+15 minutes"));
				
            	$encrip_pass = $this->main_m->hash($stu_pass);
            	if($_FILES){		 
					if($_FILES["stu_pic"]["name"] != ''){
						
						$config["upload_path"] =  'upload_file/student_pic/';
						$config["allowed_types"] = 'jpg|jpeg|png|JPG|JPEG|PNG';
						$config['remove_spaces'] = TRUE;
						$config['overwrite'] = FALSE;
						$config['max_size'] = '10000';
						
						$this->load->library('image_lib');
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						
						$_FILES["file"]["name"] = $_FILES["stu_pic"]["name"];
						$_FILES["file"]["type"] = $_FILES["stu_pic"]["type"];
						$_FILES["file"]["tmp_name"] = $_FILES["stu_pic"]["tmp_name"];
						$_FILES["file"]["error"] = $_FILES["stu_pic"]["error"];
						$_FILES["file"]["size"] = $_FILES["stu_pic"]["size"];
						
						if($this->upload->do_upload('file'))
						{
							$upload_data = $this->upload->data();
							$up_student_pic = $upload_data['file_name'];
							
							if($upload_data['image_width'] >= $upload_data['image_height'] && $upload_data['image_width'] > 900){
		            		
								$resize_conf = array(
		                            'source_image' => $upload_data['full_path'],
		                            'new_image' => 'upload_file/student_pic/',
		                            'overwrite' => true,
		                            'width' => 900
		                        );
		                        $this->image_lib->initialize($resize_conf);
		                        $this->image_lib->resize();
		                        
							}elseif($upload_data['image_height'] >= $upload_data['image_width'] && $upload_data['image_height'] > 600){
								
								$resize_conf = array(
		                            'source_image' => $upload_data['full_path'],
		                            'new_image' => 'upload_file/student_pic/',
		                            'overwrite' => true,
		                            'width' => 600
		                        );
		                        $this->image_lib->initialize($resize_conf);
		                        $this->image_lib->resize();
		                        
							}
							
							$row_array1 = array(
			            		'student_type' => 2,
			            		'student_username' => $stu_username,
			            		'student_password' => $encrip_pass,
			            		'student_otp' => $random_string,
			            		'student_otp_entry_time' => $valid_time,
			            		'student_otp_count' => 1,
			            		'student_create_time' => date('Y-m-d H:i:s')
			            	);
			            	
			            	$row_array2 = array(
			            		'std_name' => $stu_name,
			            		'std_pic' => $up_student_pic,
			            		'std_phone' => $stu_mobile,
			            		'std_email_id' => $stu_email,
			            		'std_dob' => date('Y-m-d',strtotime($stu_dob)),
			            		'std_address' => $stu_address,
			            		'std_caste' => $stu_caste,
			            		'std_eductaion' => $stu_qualification,
			            		'std_intrested_course' => $stu_interest,
			            		'std_create_date' => date('Y-m-d')
			            	);
			            	
			            	$e_sub = "MOCK TEST - ONE TIME PASSOWRD";
							$e_msg = "<p style='font-size:15px;'>YOUR ONE TIME PASSWORD IS - ".$random_string.".</p>
									  <p style='font-size:15px;'>This OTP expires in 15 Minutes. More Supprot, Please Contact - 1234567890</p>";
			            		
							if($this->sendSMTPEmail($stu_email, $e_sub, $e_msg) == TRUE){
			            	
				            	if($this->main_m->StudentRegistration_SaveUpdate_inDB($row_array1, $row_array2) == TRUE){
				            		$stuid = $this->db->get_where('student_information',array('student_username'=>$stu_username, 'student_status'=>0))->row()->student_id;
									echo json_encode(array('msg'=> 1, 'stuid'=> $stuid));
								}else{
									echo json_encode(array('msg'=>'DB Insertion Failed, Try Again.'));
								}
							
							}else{
								echo json_encode(array('msg'=>'E-Mail not Send Properly. Please try again.'));
							}
							
						}else{
							echo json_encode(array('msg'=> $this->upload->display_errors()));
						}
						
			
					}else{
						echo json_encode(array('msg'=>'Please select a Picture to upload'));
					}
            	}else{
					
					$row_array1 = array(
	            		'student_type' => 2,
	            		'student_username' => $stu_username,
	            		'student_password' => $encrip_pass,
	            		'student_otp' => $random_string,
	            		'student_otp_entry_time' => $valid_time,
	            		'student_otp_count' => 1,
	            		'student_create_time' => date('Y-m-d H:i:s')
	            	);
	            	
	            	$row_array2 = array(
	            		'std_name' => $stu_name,
	            		'std_phone' => $stu_mobile,
	            		'std_email_id' => $stu_email,
	            		'std_dob' => date('Y-m-d',strtotime($stu_dob)),
	            		'std_address' => $stu_address,
	            		'std_caste' => $stu_caste,
	            		'std_eductaion' => $stu_qualification,
	            		'std_intrested_course' => $stu_interest,
	            		'std_create_date' => date('Y-m-d')
	            	);
	            	
	            	$e_sub = "MOCK TEST - ONE TIME PASSOWRD";
					$e_msg = "<p style='font-size:15px;'>YOUR ONE TIME PASSWORD IS - ".$random_string.".</p>
							  <p style='font-size:15px;'>This OTP expires in 15 Minutes. More Supprot, Please Contact - 1234567890</p>";
	            		
					if($this->sendSMTPEmail($stu_email, $e_sub, $e_msg) == TRUE){
	            	
		            	if($this->main_m->StudentRegistration_SaveUpdate_inDB($row_array1, $row_array2) == TRUE){
		            		
		            		$stuid = $this->db->get_where('student_information',array('student_username'=>$stu_username, 'student_status'=>0))->row()->student_id;
							echo json_encode(array('msg'=> 1, 'stuid'=> $stuid));
						}else{
							echo json_encode(array('msg'=>'DB Insertion Failed, Try Again.'));
						}
					
					}else{
						echo json_encode(array('msg'=>'E-Mail not Send Properly. Please try again.'));
					}
				
				
				}
            	
            
            }
            else{
            	echo json_encode(array('msg'=>validation_errors()));
				//$this->data['error'] = validation_errors();
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function testmail(){
		$profile_email = 'completesaha@gmail.com';
		$e_sub = "E-Pass - Permission Application";
		$e_msg = '<h2>Welcome to Portal for Permission to resume works in Bankura District<br/>(During Lockdown period of COVID-19)</h2>
		<p style="font-size:18px;">Dear AMIT,<br/>Your Permission is Approved Successfully.<br/>Your Application Number :- <strong>234352354356345</strong></p><br/><br/>
					<p style="font-size:18px;">Please check the Below Link for your Approval Document -<br/>
					http://test-dev.albatrossoft.com/epass/main/print_final_permission_sheet/010520201348201487</p>
					<br/><br/><br/>
					<p style="font-size:16px;">*For any queries please contact the District Admin.</p>';

		$this->sendSMTPEmail($profile_email, $e_sub, $e_msg);
	}
}