<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_access extends Admin_Controller {
	
	public function index()
	{
		//redirect('login');
		// Redirect a user if he's already logged in
		//echo $_SERVER['REMOTE_ADDR'];echo $_SERVER['HTTP_X_FORWARDED_FOR'];exit;
		
		$dashboard = 'admincontrol/dashboard';
		$this->admin_m->loggedin() == FALSE || redirect($dashboard);
		//$this->load->helper('captcha');
		
		if ($_POST) {
					//redirect('login');
					//$usertype = $this->input->post('usertype');
					$mobile = $this->input->post('username');
					$otp = $this->input->post('password');
					$uid = $this->input->post('usetid');
		            
		            $this->form_validation->set_error_delimiters('<span style="color:#F00;font-size:10px;">', '</span>');
		            
		            //$this->form_validation->set_rules("usertype", "UserType", "trim|required|xss_clean");
		            $this->form_validation->set_rules("username", "Mobile", "trim|required|xss_clean");
		            $this->form_validation->set_rules("password", "OTP", "trim|required|xss_clean");
		            $this->form_validation->set_rules("usetid", "ID", "trim|required|xss_clean");
		            	
					if ($this->form_validation->run() == TRUE) {
					
						if ($this->loginprocess($uid, $otp, $mobile) == true) {
							//redirect($this->input->server('HTTP_REFERER'));
							
							$now = array(
								'ulog_user' => $this->session->userdata('uid'),
								'ulog_access_time' => date('Y-m-d H:i:s'),
								'ulog_access_ip' => $this->input->ip_address() //$_SERVER['HTTP_X_FORWARDED_FOR']
							);
							$now2 = array(
								'otp_verify' => NULL,
								'user_ip_address' => $this->input->ip_address()
							);

							$this->admin_m->update_adminuser_modified($now2);
							$this->admin_m->update_adminuser_log($now);

							redirect($dashboard);
							
						} else {
							
							$this->data["error"] = 'Sorry Wrong OTP, Try Again';
						}
					}
					
		     }
		//$this->data["utype_list"] = $this->db->where('mu_status = 1')->get("master_user_type")->result(); 
		$this->load->view('admin/login', $this->data);
		
	}
	
	public function loginprocess($uid, $otp, $mobile){
		$uid = $this->security->sanitize_filename($uid);
		//$password = $this->security->sanitize_filename($this->admin_m->hash($pwd));
		//$usertype = $utype;
		//var_dump($password);exit;
	
		$boolean = $this->admin_m->checklogin($uid, $otp, $mobile);
			
		return $boolean;
	}
	
	public function check_username_password(){
		
	
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$pwd = $this->admin_m->hash($password);
		
		$pri = $this->db->get_where('user_info',array('username'=>$username,'password'=>$pwd ))->num_rows();
		echo json_encode($pri);
	
	}
	
	public function get_otp_set(){
		if($_POST){
			$mobileid = $this->input->post('mobile_no');
			//$usertype = $this->input->post('usertype');
			$msg = 0;
			if($mobileid != ""){
				//if($mobileid == '7059457070' || $mobileid == '9830260404'){
				$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
				if($chk_exist != FALSE){
					//print_r($chk_exist);
					$generate_otp = $this->generateRandomString(6);
					$row_arr = array(
						'otp_verify' => $generate_otp,
						'otp_count' => ($chk_exist->otp_count + 1),
						'otp_sendtime' => date('Y-m-d H:i:s')
					);
					if($this->admin_m->update_mobiledetails_existence($row_arr, $chk_exist->u_id) == TRUE){
						
						$htmldataset = '<html><body><h1>Welcome to ADMIN portal of Mathua website.<br/>Your ONE TIME PASSWORD IS - '.$generate_otp.'</h1></body></html>';
						$msg111 = 'Thank you for login in Mathua website. Your OTP is '.$generate_otp.'.';
						//$smsreplyset = $this->sendALLSMS($msg111, $mobileid, "otpmsg", '1207163455580746477');
						//$smsarray = explode(',', $smsreplyset);
						$smsarray = array(4020);
						//$emailset = $this->sendALLSMTPEmail($chk_exist->email,'Mathua - Login', $htmldataset);
						$emailset = true;
						if($emailset == true || $smsarray[0] == 402){
							if($smsarray[0] == 402){
								$rowarray = array(
									'motp_no' => $mobileid,
									'motp_otpset' => $generate_otp,
									'motp_accessip' =>  $this->input->ip_address(), //$_SERVER['HTTP_X_FORWARDED_FOR'],
									'motp_accessdate' => date('Y-m-d H:i:s')
								);
								$this->admin_m->update_mobileOTP_log($rowarray);
							}
							echo json_encode(array('msg'=>1, 's_msg' => $chk_exist->u_id, 'adm_msg' => $generate_otp));
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>'OTP not Send Properly, Try Again.'));
						}

					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'OTP not Update properly, Try Again'));
					}
					
				}else{
					echo json_encode(array('msg'=>$msg, 'e_msg'=>'Mobile Number Not Exist'));
				}
				
			}else{
				echo json_encode(array('msg'=>$msg, 'e_msg'=>'Mobile Number is Missing'));
			}
			exit;
		}
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

	public function get_new_capcha_set(){
		if($_POST){
			//$location_set = $this->input->post('location_select');
			$this->load->helper('captcha');
			$this->db->query("DELETE FROM captcha WHERE ip_address = '".$this->input->ip_address()."'");
			$vals = array(
			    'img_path'	=> 'captcha/',
			    'img_url'	=> base_url().'captcha/',
			    'font_path'	=> 'fonts/ARLRDBD.TTF',
			    'word_length'   => 6,
			    'img_width'	=> '170',
			    'img_height' => 40,
			    'expiration' => 900
			    );
		    
	      	/* Generate the captcha */
	      	$caps = create_captcha($vals);
	      
	      	$datas = array(
			    'captcha_time' => $caps['time'],
			    'ip_address' => $this->input->ip_address(),
			    'word' => $caps['word']
			);

		  	$query = $this->db->insert_string('captcha', $datas);
		  	$this->db->query($query);
			$msg = 0;
			if(count((array)$caps) > 0){
				echo json_encode(array('msg'=>1, 'cap_set' => $caps));
			}else{
				echo json_encode(array('msg'=>$msg));
			}
			exit;
		}
	}
	
}