<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Api_uploadphotos extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		//$this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->load->model('admin_m');
        $this->load->model('scheme_m');
		$this->load->model('requisition_m');
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

	public function upload_scheme_picture(){
		$data_array = json_decode(file_get_contents('php://input'), true);

		$mobileid = $data_array['mobile'];
		$scm_req_id = $data_array['schemeId'];
		// $scm_userid = $data_array['userId'];
		$scm_upload_flag = $data_array['flag'];
		$scm_photo_lat = $data_array['latitude'];
		$scm_photo_long = $data_array['longitude'];
		$scm_photo_title = $data_array['title'];
		$scm_pic = $data_array['photo'];
		
		if($scm_req_id == "" || $scm_req_id == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Scheme Id Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		// if($scm_userid == "" || $scm_userid == NULL){
		// 	$send_obj['message'] = 0;
		// 	$send_obj['success_message'] = "User Id Not Found";
		// 	$send_obj['mobile_number'] = $mobileid;
		// 	echo json_encode($send_obj);
		// 	exit;
		// }
		// if($this->requisition_m->check_userdistcode_schemedistcode_isequal($scm_userid, $scm_req_id) == FALSE || $this->requisition_m->check_userblockcode_schemeblockcode_isequal($scm_userid, $scm_req_id) == FALSE){
		// 	$send_obj['message'] = 0;
		// 	$send_obj['success_message'] = "User Id Invalid";
		// 	$send_obj['mobile_number'] = $mobileid;
		// 	echo json_encode($send_obj);
		// 	exit;
		// }
		if($scm_upload_flag == "" || $scm_upload_flag == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Upload Flag Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		if($scm_photo_lat == "" || $scm_photo_lat == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Photo Latitude Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		if($scm_photo_long == "" || $scm_photo_long == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Photo Longitude Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		// if($scm_photo_title == "" || $scm_photo_title == NULL){
		// 	$send_obj['message'] = 0;
		// 	$send_obj['success_message'] = "Photo Title Not Found";
		// 	$send_obj['mobile_number'] = $mobileid;
		// 	echo json_encode($send_obj);
		// 	exit;
		// }
		if($scm_pic == "" || $scm_pic == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Picture Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		/*=========== START User existance check ============*/
		$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
		if($chk_exist == FALSE){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		$user_id = $this->admin_m->get_userid_by_mobile_for_app_api($mobileid);
		if ($user_id == false) {
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		/*=========== END User existance check ============*/
		/*=========== START Unauthorized access blocking ============*/
		$schm_id_arr = $this->requisition_m->get_all_scheme_id_array($user_id);
		if($schm_id_arr != FALSE){
			$temp_schm_id_arr = array();
			foreach($schm_id_arr as $schm_id){
				$temp_schm_id_arr[] = $schm_id->req_id;
			}
			// echo '<pre>'; print_r($temp_schm_id_arr); die;
			if (!in_array($scm_req_id, $temp_schm_id_arr)) {
				$send_obj['message'] = 0;
				$send_obj['success_message'] = "Unauthorized access denied";
				$send_obj['mobile_number'] = $mobileid;
				echo json_encode($send_obj);
				exit;
			}
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "No scheme available";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		/*=========== END Unauthorized access blocking ===============*/

		$req_num = $this->requisition_m->get_requisition_number_by_req_id($scm_req_id);
		
		/* File Uploads */
		$new_attach_name = date("YmdHis").'-'.$this->generateRandomString().'.jpg';
		//$this->base64_to_jpeg($d_pic_64, $out_pic);
		file_put_contents('uploads/'.$req_num.'/'.$new_attach_name, base64_decode($scm_pic));
		/* File Uploads */

		$rows_array = array(
			'wpt_req_master' => $scm_req_id,
			'wpt_flag' => $scm_upload_flag,
			'wpt_latitude' => $scm_photo_lat,
			'wpt_longitude' => $scm_photo_long,
			'wpt_title' => $scm_photo_title,
			'wpt_doc' => $new_attach_name,
			'wpt_createby' => $user_id,
			'wpt_createdate' => date('Y-m-d H:i:s')
		);

		if($this->requisition_m->insert_work_progress_details($rows_array) == TRUE)
		{	
			// if($this->requisition_m->update_work_progress_flag($scm_req_id, $scm_upload_flag) == TRUE)
			// {
			// 	$send_obj['message'] = 1;
			// 	$send_obj['success_message'] = "Photo Uploaded Successfully.";
			// 	$send_obj['mobile_number'] = $mobileid;
			// 	echo json_encode($send_obj);
			// 	exit;
			// }

			$data_arr = $this->requisition_m->get_work_progress_details($scm_req_id, $scm_upload_flag, $user_id);
			if($data_arr != FALSE){
				$send_arr = array();
				foreach($data_arr as $data){
					$temp_arr = array();
					$wpt_id = $data->wpt_id;
					if($wpt_id > 0){
						$temp_arr = array(
							'pic_id' => $data->wpt_id,
							'pic_scheme_id' => $data->wpt_req_master,
							'pic_name' => $data->wpt_doc,
							'pic_scheme_flag' => $data->wpt_flag,
							'pic_title' => $data->wpt_title,
							'pic_lat' => $data->wpt_latitude,
							'pic_long' => $data->wpt_longitude,
							'pic_upload_by' => $data->wpt_createby,
							'pic_upload_date' => $data->wpt_createdate,
							'pic_status' => $data->wpt_status
						);
						$send_arr[] = $temp_arr;
					}
				}
				$send_obj['message'] = 1;
				$send_obj['success_message'] = "Data Retrieve.";
				$send_obj['mobile_number'] = $mobileid;
				$send_obj['data_message'] = $send_arr;
				echo json_encode($send_obj);
				exit;
			}

		}else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "There is an error to Insert in DB";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
	}


	public function get_all_photo_if_available(){
		$data_array = json_decode(file_get_contents('php://input'), true);

		$mobileid = $data_array['mobile'];
		$scm_req_id = $data_array['schemeId'];
		$scm_upload_flag = $data_array['flag'];

		if($scm_req_id == "" || $scm_req_id == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Scheme Id Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		if($scm_upload_flag == "" || $scm_upload_flag == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Upload Flag Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
		if($chk_exist == FALSE){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$user_id = $this->admin_m->get_userid_by_mobile_for_app_api($mobileid);
		if ($user_id == false) {
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$schm_id_arr = $this->requisition_m->get_all_scheme_id_array($user_id);
		if($schm_id_arr != FALSE){
			$temp_schm_id_arr = array();
			foreach($schm_id_arr as $schm_id){
				$temp_schm_id_arr[] = $schm_id->req_id;
			}
			// echo '<pre>'; print_r($temp_schm_id_arr); die;
			if (!in_array($scm_req_id, $temp_schm_id_arr)) {
				$send_obj['message'] = 0;
				$send_obj['success_message'] = "Unauthorized access denied";
				$send_obj['mobile_number'] = $mobileid;
				echo json_encode($send_obj);
				exit;
			}
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "No scheme available";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$data_arr = $this->requisition_m->get_work_progress_details($scm_req_id, $scm_upload_flag, $user_id);
		if($data_arr != FALSE){
			$send_arr = array();
			foreach($data_arr as $data){
				$temp_arr = array();
				$wpt_id = $data->wpt_id;
				if($wpt_id > 0){
					$temp_arr = array(
						'pic_id' => $data->wpt_id,
						'pic_scheme_id' => $data->wpt_req_master,
						'pic_name' => $data->wpt_doc,
						'pic_scheme_flag' => $data->wpt_flag,
						'pic_title' => $data->wpt_title,
						'pic_lat' => $data->wpt_latitude,
						'pic_long' => $data->wpt_longitude,
						'pic_upload_by' => $data->wpt_createby,
						'pic_upload_date' => $data->wpt_createdate,
						'pic_status' => $data->wpt_status
					);
					$send_arr[] = $temp_arr;
				}
			}
			$send_obj['message'] = 1;
			$send_obj['success_message'] = "Data Retrieve.";
			$send_obj['mobile_number'] = $mobileid;
			$send_obj['data_message'] = $send_arr;
			echo json_encode($send_obj);
			exit;
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "No photos available";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}


	}


	public function delete_scheme_picture(){
		$data_array = json_decode(file_get_contents('php://input'), true);

		$mobileid = $data_array['mobile'];
		$scm_req_id = $data_array['schemeId'];
		$scm_upload_flag = $data_array['flag'];
		$scm_work_progress_id = $data_array['work_progress_id'];

		if($scm_req_id == "" || $scm_req_id == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Scheme Id Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		if($scm_upload_flag == "" || $scm_upload_flag == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Upload Flag Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		if($scm_work_progress_id == "" || $scm_work_progress_id == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Work Progress Id Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
		if($chk_exist == FALSE){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$user_id = $this->admin_m->get_userid_by_mobile_for_app_api($mobileid);
		if ($user_id == false) {
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$schm_id_arr = $this->requisition_m->get_all_scheme_id_array($user_id);
		if($schm_id_arr != FALSE){
			$temp_schm_id_arr = array();
			foreach($schm_id_arr as $schm_id){
				$temp_schm_id_arr[] = $schm_id->req_id;
			}
			// echo '<pre>'; print_r($temp_schm_id_arr); die;
			if (!in_array($scm_req_id, $temp_schm_id_arr)) {
				$send_obj['message'] = 0;
				$send_obj['success_message'] = "Unauthorized access denied";
				$send_obj['mobile_number'] = $mobileid;
				echo json_encode($send_obj);
				exit;
			}
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "No scheme available";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		if($this->requisition_m->delete_work_progress_by_id($scm_req_id, $scm_upload_flag, $scm_work_progress_id) == TRUE){
			$send_obj['message'] = 1;
			$send_obj['success_message'] = "Photo Deleted Successfully.";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "There is an error to Delete from DB";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

	}


	public function submit_uploaded_photo(){
		$data_array = json_decode(file_get_contents('php://input'), true);

		$mobileid = $data_array['mobile'];
		$scm_req_id = $data_array['schemeId'];
		$scm_upload_flag = $data_array['flag'];

		if($scm_req_id == "" || $scm_req_id == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Scheme Id Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		if($scm_upload_flag == "" || $scm_upload_flag == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Upload Flag Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
		if($chk_exist == FALSE){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

		$user_id = $this->admin_m->get_userid_by_mobile_for_app_api($mobileid);
		if ($user_id == false) {
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
			
		if($this->requisition_m->check_atleast_one_photo_existence($scm_req_id, $scm_upload_flag, $user_id) == FALSE){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "You should upload atleast one photo before submission.";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		else{
			if($this->requisition_m->update_work_progress_flag($scm_req_id, $scm_upload_flag) == TRUE)
			{
				$send_obj['message'] = 1;
				$send_obj['success_message'] = "Photo Submitted Successfully.";
				$send_obj['mobile_number'] = $mobileid;
				echo json_encode($send_obj);
				exit;
			}
		}
	}



	public function send_otp_to_app(){
		$data_array = json_decode(file_get_contents('php://input'), true);
		$mobileid = $data_array['mobile'];
		if($mobileid == "" || $mobileid == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		$chk_exist = $this->admin_m->check_mobile_existence($mobileid);
		if($chk_exist != FALSE){
			//$generate_otp = $this->generateRandomString(6);
					

			//$generate_otp = $this->generateRandomString(6);
            $generate_otp = '123456';
			$row_arr = array(
				'otp_verify' => $generate_otp,
				'otp_count' => ($chk_exist->otp_count + 1),
				'otp_sendtime' => date('Y-m-d H:i:s')
			);
			if($this->admin_m->update_mobiledetails_existence($row_arr, $chk_exist->u_id) == TRUE){
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
					else{
						$send_obj['message'] = 1;
						$send_obj['success_message'] = "OTP Sent Successfully";
						$send_obj['mobile_number'] = $mobileid;
						echo json_encode($send_obj);
						exit;
					}
				}
				else{
					$send_obj['message'] = 0;
					$send_obj['success_message'] = "OTP not Send Properly, Try Again.";
					$send_obj['mobile_number'] = $mobileid;
					echo json_encode($send_obj);
					exit;
				}
			}
		}
		else{
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Exists";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}

	}

	// public function app_loginprocess(){

	// }


	public function login_with_otp(){
		$data_array = json_decode(file_get_contents('php://input'), true);
		$mobileid = $data_array['mobile'];
		$ot_pass = $data_array['otp'];
			
		if($mobileid == "" || $mobileid == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		if($ot_pass == "" || $ot_pass == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "OTP Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		$user_id = $this->admin_m->checklogin_get_userid_for_app_api($ot_pass, $mobileid);
		if ($user_id != false) {
			
			$now = array(
				'ulog_user' => $user_id,
				'ulog_access_time' => date('Y-m-d H:i:s'),
				'ulog_access_ip' => $this->input->ip_address() //$_SERVER['HTTP_X_FORWARDED_FOR']
			);
			$now2 = array(
				'otp_verify' => NULL,
				'user_ip_address' => $this->input->ip_address()
			);

			if($this->admin_m->update_adminuser_log_for_app_api($now) == TRUE && $this->admin_m->update_adminuser_modified_for_app_api($now2, $user_id) == TRUE){

				$data_arr = $this->requisition_m->get_all_from_requisition_master_by_user_id_for_app_api($user_id);

				$send_arr = array();
			
				foreach($data_arr as $data){
					$pic_flag = 0;
					$pic_msg = "";
					$temp_arr = array();
					$req_initiate = $data->req_initiate;
					$req_progress_flag = $data->req_progress_flag;
					if($req_initiate == 1){
						$pic_flag = 1;
						$pic_msg = "Upload Existing Place Picture";
					}
					elseif($req_initiate == 2){
						if($req_progress_flag == 1){
							$pic_flag = 2;
							$pic_msg = "Upload Work Picture";
						}
						elseif($req_progress_flag == 3){
							$pic_flag = 3;
							$pic_msg = "Upload Finished Work Picture";
						}
					}
					if($pic_flag > 0){
						$temp_arr = array(
							's_id' => $data->req_id,
							's_number' => $data->req_number,
							's_name' => $data->scm_name,
							's_flag' => $pic_flag,
							's_msg' => $pic_msg
						);
						$send_arr[] = $temp_arr;
					}
				}
				
				$send_obj['message'] = 1;
				$send_obj['success_message'] = "Login Successfully.";
				$send_obj['mobile_number'] = $mobileid;
				$send_obj['data_message'] = $send_arr;
				echo json_encode($send_obj);
				exit;
			}	
			else {	
				$send_obj['message'] = 0;
				$send_obj['success_message'] = "Login Error, Try Again";
				$send_obj['mobile_number'] = $mobileid;
				echo json_encode($send_obj);
				exit;
			}
		}
		else {	
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Sorry Wrong OTP, Try Again";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		
	}


	public function get_data_with_mobile_number(){
		$data_array = json_decode(file_get_contents('php://input'), true);
		$mobileid = $data_array['mobile'];
		if($mobileid == "" || $mobileid == NULL){
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Mobile Number Not Found";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
		$user_id = $this->admin_m->get_userid_by_mobile_for_app_api($mobileid);
		if ($user_id != false) {
			$data_arr = $this->requisition_m->get_all_from_requisition_master_by_user_id_for_app_api($user_id);
			$send_arr = array();
			foreach($data_arr as $data){
				$pic_flag = 0;
				$pic_msg = "";
				$temp_arr = array();
				$req_initiate = $data->req_initiate;
				$req_progress_flag = $data->req_progress_flag;
				if($req_initiate == 1){
					$pic_flag = 1;
					$pic_msg = "Upload Existing Place Picture";
				}
				elseif($req_initiate == 2){
					if($req_progress_flag == 1){
						$pic_flag = 2;
						$pic_msg = "Upload Work Picture";
					}
					elseif($req_progress_flag == 3){
						$pic_flag = 3;
						$pic_msg = "Upload Finished Work Picture";
					}
				}
				if($pic_flag > 0){
					$temp_arr = array(
						's_id' => $data->req_id,
						's_number' => $data->req_number,
						's_name' => $data->scm_name,
						's_flag' => $pic_flag,
						's_msg' => $pic_msg
					);
					$send_arr[] = $temp_arr;
				}
			}
			$send_obj['message'] = 1;
			$send_obj['success_message'] = "Data Retrieve.";
			$send_obj['mobile_number'] = $mobileid;
			$send_obj['data_message'] = $send_arr;
			echo json_encode($send_obj);
			exit;
		}
		else {	
			$send_obj['message'] = 0;
			$send_obj['success_message'] = "Sorry Wrong OTP, Try Again";
			$send_obj['mobile_number'] = $mobileid;
			echo json_encode($send_obj);
			exit;
		}
			
	}

}

