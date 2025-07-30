<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentupload extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
		$this->load->model('member_m');
		$this->load->model('admin_m');
		$this->load->model('candidates_m');
    }
	
	public function index()
	{
		redirect('default404');
	}

	public function specificfile_upload_bycandidate($enctypedata = NULL){
		if($enctypedata == NULL){
			redirect('default404');
		}
		$desctypedata = openssl_decrypt(base64_decode($enctypedata),"AES-128-ECB",config_item('encryption_key'));
		$this->data["maildata"] = $getstring_arr = explode("|",$desctypedata);
		$chkresult = $this->candidates_m->docModification_TimeFieldCheck($getstring_arr);
		if(count((array)$chkresult) > 0){
			$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($getstring_arr[2]);
			if($getstring_arr[3] == 'CO'){
				$this->data["commonname_arr"] = $comname_arr = array('','Picture','Signature','Address Proof','Date of Birth Proof','Caste Proof','PWD Proof','Exempted Category Proof','Ex-Service Category Proof','Sportsman Category Proof','Registration Certificate');
			}elseif($getstring_arr[3] == 'EQ'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenQualification_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'DQ'){
				$this->data['docu_details'] = $this->candidates_m->get_DesireQualification_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'ES'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenExperience_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'DS'){
				$this->data['docu_details'] = $this->candidates_m->get_DesireExperience_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'EA'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenAgeRelax_fromDB($getstring_arr[4]);
			}
			$this->load->view('main/member/upload_specific_document',$this->data);
		}else{
			if($this->candidates_m->docModification_AlreadyUpload_Check($getstring_arr) == TRUE){
				$this->data['fuser_detailset'] = "Document is Already Uploaded";
			}else{
				$this->data['fuser_detailset'] = "The Link You Followed Has Expired";
			}
			$this->load->view('main/member/upload_empty_document',$this->data);
		}
		//print_r($getstring_arr);
		//echo $desctypedata;
	}

	public function specificdocument_modification_uploadbycandidate(){
		if($_POST){
			//echo "hi";exit;
			$refno = $this->input->post("refno");
			
			$this->form_validation->set_rules('refno', 'Reference No.', 'trim|required|is_natural');
			
			if ($this->form_validation->run()) {

				$userdetails = $this->db->get_where('updatedoc_mail_log',array('udm_id'=>$refno))->row();
				//print_r($userdetails);exit;
				$getstring_arr = array();
				if(!empty($userdetails)){
					$getstring_arr = array('', $userdetails->udm_cand_advno, $userdetails->udm_cand_regno, $userdetails->udm_doctype,$userdetails->udm_doc_id, $refno);
				}
				$chkresult = $this->candidates_m->docModification_TimeFieldCheck($getstring_arr);
				if(count((array)$chkresult) > 0){

					if (count($_FILES) > 0) {
						$filename = $_FILES['files']['name'];
						if (!empty($filename)) {
							$this->load->library('upload');
							$this->load->library('image_lib');

							$config['upload_path'] = realpath('upload_file/'.$userdetails->udm_cand_advno.'/candidates/'.$userdetails->udm_cand_regno.'/');
							if($userdetails->udm_doctype == "CO" && ($userdetails->udm_doc_id == 1 || $userdetails->udm_doc_id == 2)){
								$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG';
							}else{
								$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
							}
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '2050';
							$config['file_name'] = $filename;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							if ($this->upload->do_upload('files')) {

								$upload_data = $this->upload->data();
								
								//////////////////////////
								$canddetail = $this->db->get_where('frontend_users',array('f_application_no'=>$userdetails->udm_cand_regno))->row();
								//print_r($canddetail);
								if($userdetails->udm_doctype == "CO"){

									if($userdetails->udm_doc_id == 1){
										$row_arr = array('fu_photo_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 2){
										$row_arr = array('fu_signature_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 3){
										$row_arr = array('fu_address_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 4){
										$row_arr = array('fu_dob_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 5){
										$row_arr = array('fu_caste_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 6){
										$row_arr = array('fu_pwd_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 7){
										$row_arr = array('fu_exc_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 8){
										$row_arr = array('fu_exs_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 9){
										$row_arr = array('fu_ews_doc' => $upload_data['file_name']);
									}elseif($userdetails->udm_doc_id == 10){
										$row_arr = array('fu_ext_council_reg_certificate' => $upload_data['file_name']);
									}
									$resultset = $this->candidates_m->update_frontuser_details_modified($row_arr, $canddetail->f_uid);

								}elseif($userdetails->udm_doctype == "EQ"){
									$row_arr = array('fu_quali_docs' => $upload_data['file_name']);
									$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_qualification', $userdetails->udm_doc_id, $canddetail->f_uid);
								}elseif($userdetails->udm_doctype == "DQ"){
									$row_arr = array('fud_quali_docs' => $upload_data['file_name']);
									$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_des_qualification', $userdetails->udm_doc_id, $canddetail->f_uid);
								}elseif($userdetails->udm_doctype == "ES"){
									$row_arr = array('fues_exp_marksheet_doc' => $upload_data['file_name']);
									$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_ess_experience', $userdetails->udm_doc_id, $canddetail->f_uid);
								}elseif($userdetails->udm_doctype == "DS"){
									$row_arr = array('fu_exp_marksheet_doc' => $upload_data['file_name']);
									$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_experience', $userdetails->udm_doc_id, $canddetail->f_uid);
								}elseif($userdetails->udm_doctype == "EA"){
									$row_arr = array('fu_ext_doc' => $upload_data['file_name']);
									$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_extraage', $userdetails->udm_doc_id, $canddetail->f_uid);
								}

								$row_arr2 = array(
									'udm_new_docname' => $upload_data['file_name'],
									'udm_modifydate' => date('Y-m-d H:i:s'),
									'udm_status' => 2
								);
								$reseuset2 = $this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arr2, $refno);

								if ($resultset == TRUE) {
									if($reseuset2 == TRUE){
										echo json_encode(array('msg' => 1));
									}else{
										echo json_encode(array('msg' => 0, 'e_msg' => 'Final DB Updation Problem, Try again.'));
									}
								} else {
									echo json_encode(array('msg' => 0, 'e_msg' => 'DB Updation Problem, Try again.'));
								}
								//////////////////////////
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File is missing, Try again.'));
					}

				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'File Uploading Time Over.'));
				}

			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	protected function generateRandomString($length = 4)
	{

		$characters = '0123456789';

		$charactersLength = strlen($characters);

		$randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	
	public function modify_qualificationmarks_bycandidate($enctypedata = NULL){
		if($enctypedata == NULL){
			redirect('default404');
		}
		$desctypedata = openssl_decrypt(base64_decode($enctypedata),"AES-128-ECB",config_item('encryption_key'));
		$this->data["maildata"] = $getstring_arr = explode("|",$desctypedata);
		$chkresult = $this->candidates_m->qualifcationModification_TimeFieldCheck($getstring_arr);
		if(count((array)$chkresult) > 0){
			$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($getstring_arr[2]);
			/*if($getstring_arr[3] == 'CO'){
				$this->data["commonname_arr"] = $comname_arr = array('','Picture','Signature','Address Proof','Date of Birth Proof','Caste Proof','PWD Proof','Exempted Proof','Ex-Service Proof','Sportsman Proof','Registration Certificate');
			}else*/
			if($getstring_arr[3] == 'EQ'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenQualification_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'DQ'){
				$this->data['docu_details'] = $this->candidates_m->get_DesireQualification_fromDB($getstring_arr[4]);
			}
			/*elseif($getstring_arr[3] == 'ES'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenExperience_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'DS'){
				$this->data['docu_details'] = $this->candidates_m->get_DesireExperience_fromDB($getstring_arr[4]);
			}elseif($getstring_arr[3] == 'EA'){
				$this->data['docu_details'] = $this->candidates_m->get_EssenAgeRelax_fromDB($getstring_arr[4]);
			}*/
			$this->load->view('main/member/update_specific_qualification',$this->data);
		}else{
			if($this->candidates_m->qualificationModification_AlreadyUpload_Check($getstring_arr) == TRUE){
				$this->data['fuser_detailset'] = "Qualification is Already Updated";
			}else{
				$this->data['fuser_detailset'] = "The Link You Followed Has Expired";
			}
			$this->load->view('main/member/upload_empty_document',$this->data);
		}
	}
	
	public function specificqualification_modification_updatebycandidate(){
		if($_POST){
			//echo "hi";exit;
			$refno = $this->input->post("refno");
			$marks_obtained = $this->input->post("marks_obtained");
			$marks_full = $this->input->post("marks_full");
			$marks_percent = $this->input->post("marks_percent");
			
			$this->form_validation->set_rules('refno', 'Reference No.', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('marks_obtained', 'Obtained Marks', 'trim|required|integer');
			$this->form_validation->set_rules('marks_full', 'Full Marks', 'trim|required|integer');
			$this->form_validation->set_rules('marks_percent', 'Percentage Marks', 'trim|required|numeric');
			
			if ($this->form_validation->run()) {

				$userdetails = $this->db->get_where('updatequali_log',array('udq_id'=>$refno))->row();
				//print_r($userdetails);exit;
				$getstring_arr = array();
				if(!empty($userdetails)){
					$getstring_arr = array('', $userdetails->udq_cand_advno, $userdetails->udq_cand_regno, $userdetails->udq_sectiontype,$userdetails->udq_quali_id, $refno);
				}
				$chkresult = $this->candidates_m->qualificationModification_TimeFieldCheck($getstring_arr);
				if(count((array)$chkresult) > 0){
		
					//////////////////////////
					$canddetail = $this->db->get_where('frontend_users',array('f_application_no'=>$userdetails->udq_cand_regno))->row();
					//print_r($canddetail);
					
					$selectpercent = (($marks_obtained * 100) / $marks_full);
					$percentupdate = number_format((float)$selectpercent, 2, '.', '');

					if($userdetails->udq_sectiontype == "EQ"){
						$row_arr = array(
							'fu_marks_obtained' => $marks_obtained,
							'fu_full_marks' => $marks_full,
							'fu_percent_of_marks' => $percentupdate,
							'fu_obtainmark_ck' => $marks_obtained,
							'fu_fullmark_ck' => $marks_full,
							'fu_percentmark_ck' => $percentupdate
						);
						$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_qualification', $userdetails->udq_quali_id, $canddetail->f_uid);
					}elseif($userdetails->udq_sectiontype == "DQ"){
						$row_arr = array(
							'fud_marks_obtained' => $marks_obtained,
							'fud_full_marks' => $marks_full,
							'fud_percent_of_marks' => $percentupdate,
							'fud_obtainmark_ck' => $marks_obtained,
							'fud_fullmark_ck' => $marks_full,
							'fud_percentmark_ck' => $percentupdate
						);
						$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_des_qualification', $userdetails->udq_quali_id, $canddetail->f_uid);
					}
					/*elseif($userdetails->udm_doctype == "ES"){
						$row_arr = array('fues_exp_marksheet_doc' => $upload_data['file_name']);
						$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_ess_experience', $userdetails->udm_doc_id, $canddetail->f_uid);
					}elseif($userdetails->udm_doctype == "DS"){
						$row_arr = array('fu_exp_marksheet_doc' => $upload_data['file_name']);
						$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_experience', $userdetails->udm_doc_id, $canddetail->f_uid);
					}elseif($userdetails->udm_doctype == "EA"){
						$row_arr = array('fu_ext_doc' => $upload_data['file_name']);
						$resultset = $this->candidates_m->update_Tablewise_Docdetails_modified($row_arr, 'f_user_extraage', $userdetails->udm_doc_id, $canddetail->f_uid);
					}*/

					$row_arr2 = array(
						'udq_cur_fullmarks' => $marks_full,
						'udq_cur_markobtain' => $marks_obtained,
						'udq_cur_percentage' => $percentupdate,
						'udq_modifydate' => date('Y-m-d H:i:s'),
						'udq_status' => 2
					);
					$reseuset2 = $this->candidates_m->addmodify_Qualification_modifymail_ByChecker($row_arr2, $refno);

					if ($resultset == TRUE) {
						if($reseuset2 == TRUE){
							echo json_encode(array('msg' => 1));
						}else{
							echo json_encode(array('msg' => 0, 'e_msg' => 'Final DB Updation Problem, Try again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'DB Updation Problem, Try again.'));
					}
					//////////////////////////
					
				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'Qualification Updation Time Over.'));
				}

			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	/* API LISTS */

	public function showall_advertisement_for_recruitment(){
		if($_POST){
			$hrbid = $_POST['hrbid'];
			if($hrbid != 'WBHRB'){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Data not Match, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			$adv_list = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement();
			if(count((array)$adv_list) > 0){
				$getset_obj['message'] = 1;
				$getset_obj["success_message"] = $adv_list;
				echo json_encode($getset_obj);
			}else{
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Data not Found, Check Again.";
				echo json_encode($getset_obj);
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function showall_category_against_advertisement_forprocess(){
		if($_POST){
			$adv_no = $_POST['adv_no'];
			if($adv_no == '' || $adv_no == NULL){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Number not Found, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			$appli_list = $this->member_m->getAll_list_Advertisement_Category($adv_no);
			if(count((array)$appli_list) > 0){
				$getset_obj['message'] = 1;
				$getset_obj["success_message"] = $appli_list;
				echo json_encode($getset_obj);
			}else{
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Category not Found, Check Again.";
				echo json_encode($getset_obj);
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function showall_candidate_against_category_of_advertisement_forprocess(){
		if($_POST){
			$adv_no = $_POST['adv_no'];
			$adv_category = $_POST['adv_category'];
			if($adv_no == '' || $adv_no == NULL){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Number not Found, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			if($adv_category == '' || $adv_category == NULL){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Category not Found, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			if($adv_category == "ALL"){
				$adv_category = NULL;
			}
			$appli_list = $this->candidates_m->GetDetailsofCandidateApplication_forAPICALL($adv_no, $adv_category);
			if(count((array)$appli_list) > 0){
				$getset_obj['message'] = 1;
				$getset_obj["success_message"] = $appli_list;
				echo json_encode($getset_obj);
			}else{
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Candidate Data not Found, Check Again.";
				echo json_encode($getset_obj);
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function showall_candidate_against_advertisement_recruitment(){
		if($_POST){
			$adv_no = $_POST['adv_no'];
			if($adv_no == '' || $adv_no == NULL){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Advertisement Number not Found, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			$appli_list = $this->candidates_m->GetDetailsofCandidateApplication_forAPICALL($adv_no);
			if(count((array)$appli_list) > 0){
				$getset_obj['message'] = 1;
				$getset_obj["success_message"] = $appli_list;
				echo json_encode($getset_obj);
			}else{
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Candidate Data not Found, Check Again.";
				echo json_encode($getset_obj);
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function checkevery_section_ofcandidate_approvalprocess(){
		if($_POST){
			$candidate_refno = $_POST['candidate_RefNo'];
			if($candidate_refno == '' || $candidate_refno == NULL){
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = "Candidate Reference No. not found, Check Again.";
				echo json_encode($getset_obj);
				exit;
			}
			if($this->candidates_m->getCheck_AllDocument_fromDB($candidate_refno) == TRUE){
				$checking_arr = array(
					'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service'
				);
				$cand_details = $this->candidates_m->GetDetailsofCandidate_Application($candidate_refno);
				$cand_result_tab = $this->db->get_where('candidate_result_tab',array('cr_application_master'=>$candidate_refno))->row();
				$cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$candidate_refno))->result();
				$cand_esExpss = $this->candidates_m->getDetails_Experience_Advertisement_Wise('Essential',$cand_details->f_applied_for);

				$found_reject = 0;
				$found_rejection_error = '';
				for($icnt = 0; $icnt < count($checking_arr); $icnt++){
					if($checking_arr[$icnt] == "fu_dob"){
						if($cand_result_tab->fu_dob_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "DOB is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_address"){
						if($cand_result_tab->fu_address_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Address is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_photo_doc"){
						if($cand_result_tab->fu_photo_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Picture is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_signature_doc"){
						if($cand_result_tab->fu_signature_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Signature is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_caste"){
						if($cand_result_tab->fu_caste_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "CASTE is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_pwd"){
						if($cand_result_tab->fu_pwd_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "PWD is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_exempted"){
						if($cand_result_tab->fu_exempted_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Exempted Category is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_exservice"){
						if($cand_result_tab->fu_exservice_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Ex-Serviceman Category is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_ews"){
						if($cand_result_tab->fu_ews_check == "Rejected"){
							$found_reject = 1;
							$found_rejection_error = "Sportsman Category is Rejected by Administrator.";
							break;
						}
					}elseif($checking_arr[$icnt] == "fu_es_qualification"){
						foreach($cand_checking_rows as $esq_items){
							if($esq_items->chk_type == "fu_es_qualification" && $esq_items->chk2_approve == "Rejected" && $esq_items->chk_final_state == "Rejected"){
								$found_reject = 1;
								$found_rejection_error = "Essential Qualification is Rejected by Administrator.";
								break 2;
							}
						}
					}elseif($checking_arr[$icnt] == "fu_has_es_service"){
						if(count((array)$cand_esExpss) > 0 && $cand_details->fu_has_service == "No"){
							$found_reject = 1;
							$found_rejection_error = "Essential Experience not Submitted, So it is Rejected by Administrator.";
						}else{
							$r_check = $a_check = 0;
							foreach($cand_checking_rows as $essrv_items){
								if($essrv_items->chk_type == "fu_has_es_service" && $essrv_items->chk2_approve == "Rejected" && $essrv_items->chk_final_state == "Rejected"){
									$r_check++;
								}else{
									$a_check++;
								}
							}
							if($cand_details->adv_experience_no > $a_check){
								$found_reject = 1;
								$found_rejection_error = "Essential Experience is Rejected by Administrator.";
								break;
							}
						}
					}elseif($checking_arr[$icnt] == "fu_age_relax"){
						$agereject_arr = array();
						foreach($cand_checking_rows as $esa_items){
							if($esa_items->chk_type == "fu_age_relax" && $esa_items->chk2_approve == "Rejected" && $esa_items->chk_final_state == "Rejected"){
								$agereject_arr[] = $esa_items->chk_sub_typeid;
							}
						}
						if(count($agereject_arr) > 0){

							$existing_limit_update = $cand_details->adv_age_limit;
							$getall_ageset = $this->member_m->gatAll_subscriptionAge_list($cand_details->f_applied_for);
							//$castelists = $this->db->get_where('caste_tab',array('caste_cat'=>2))->result();
							$castelists = $this->db->where('caste_status',1)->where('caste_id != ',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
							$getextraageset = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($candidate_refno, "Yes");
							$castearray = array();
							foreach($castelists as $castesets){
								$castearray[] = $castesets->caste_id;
							}
							$agearray = (array)$getall_ageset;
							$totalage_increment = 0;
							$cur = '';

							$stringmix = '';
							for($dd=0;$dd<count($agearray);$dd++){
								$cur = $agearray[$dd]->advage_type;
								if($dd==0){
									$stringmix = $stringmix.'(||'.$agearray[$dd]->advage_section.'||';
									if($cur == "AND"){
										$stringmix = $stringmix.')'.$cur.'(';
									}elseif($cur == "OR"){
										$stringmix = $stringmix.$cur;
									}elseif($cur == "END"){
										$stringmix = $stringmix.')';
									}
								}else{
									$stringmix = $stringmix.'||'.$agearray[$dd]->advage_section.'||';
									if($cur == "AND"){
										$stringmix = $stringmix.')'.$cur.'(';
									}elseif($cur == "OR"){
										$stringmix = $stringmix.$cur;
									}elseif($cur == "END"){
										$stringmix = $stringmix.')';
									}
								}
							}
							$stringmix = str_replace("||1||",0,$stringmix);
							
							for($dd=0;$dd<count($agearray);$dd++){
								if(in_array($agearray[$dd]->advage_section, $castearray)){
									if($agearray[$dd]->advage_section == $cand_details->fu_caste_type){
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0,$stringmix);
									}
								}
								if($agearray[$dd]->advage_section == 7){
									if($cand_details->fu_pwd == "Yes"){
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}	
								}
								if($agearray[$dd]->advage_section == 8){
									if($cand_details->fu_exempted == "Yes"){
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}	
								}
								if($agearray[$dd]->advage_section == 9){
									if($cand_details->fu_exservice == "Yes"){
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}	
								}
								if($agearray[$dd]->advage_section == 10){
									if($cand_details->fu_ews == "Yes"){
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}	
								}
								if($agearray[$dd]->advage_section > 10 && $agearray[$dd]->caste_cat == 8){
									foreach($getextraageset as $agesets){
										if($agesets->fu_ext_ageid == $agearray[$dd]->advage_section){
											if(!in_array($agearray[$dd]->advage_section, $agereject_arr)){
												$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
											}else{
												$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
											}
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}
								}
							}
							$mixarray = explode("AND",$stringmix);
							for($dd=0;$dd<count($mixarray);$dd++){
								$getstringsets = $mixarray[$dd];
								$getstringsets = str_replace("(","", $getstringsets);
								$getstringsets = str_replace(")","", $getstringsets);
								$mixsub_array = explode("OR",$getstringsets);
								$maxnumber_find = max($mixsub_array);
								$totalage_increment = $totalage_increment + $maxnumber_find;
							}
							//print_r($totalage_increment);
							//exit;
							if($cand_details->adv_age_updown > 0){
								if($totalage_increment > $cand_details->adv_age_updown){
									$totalage_increment = $cand_details->adv_age_updown;
								}
							}
							if($totalage_increment > 0){
								$existing_limit_update = date('Y-m-d', strtotime($cand_details->adv_age_limit. ' -'.$totalage_increment.' years'));
							}
							if($cand_details->adv_min_age_limit >= $cand_details->fu_dob && $existing_limit_update <= $cand_details->fu_dob){

							}else{
								$found_reject = 1;
								$found_rejection_error = "Mismatch of DOB is Rejected by Administrator.";
								break;
							}

						}
					}
				}
				
				if($found_reject == 1){
					//Insert Candidate Result
					$masterupdation_arr = array(
						'cr_approval' => 'Rejected',
						'cr_fprocess_date' => date('Y-m-d H:i:s'),
						'cr_reject_comments' => $found_rejection_error
					);
					if($this->candidates_m->setUpdate_ResultCandidate_Appliwise($masterupdation_arr, $candidate_refno) == TRUE){
						$getset_obj['message'] = 2;
						$getset_obj["error_message"] = $found_rejection_error;
						echo json_encode($getset_obj);
					}else{
						$getset_obj['message'] = 0;
						$getset_obj["error_message"] = 'Final Result Updation Failed of the Reject Candidate.';
						echo json_encode($getset_obj);
					}
					
				}else{
					$total_ac_score = $total_ex_score = 0.00;
					$esq_score = $dsq_score = $eserv_score = $dserv_score = 0;
					// Qualification START
					$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($candidate_refno);
					$eq_cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$candidate_refno,'chk_type'=>'fu_es_qualification'))->result();
					foreach($quali_details as $single_exams){
						foreach($eq_cand_checking_rows as $eq_items){
							if($single_exams->fu_qualifiaction_name == $eq_items->chk_sub_typeid){
								$esq_score = $esq_score + $eq_items->chk_got_marks;
							}
						}
					}
					$total_ac_score = $total_ac_score + $esq_score;
					//$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($candidate_refno);
					$dq_cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$candidate_refno,'chk_type'=>'fu_ds_qualification'))->result();
					

					$allquali_list = $this->member_m->getAll_qualification_exam($cand_details->adv_auto_genno);
					$desire_quali_arr = array();
					foreach($allquali_list as $qs){
						$subset_arr = array();
						if($qs->aquali_examtype == "Desirable"){
							$subset_arr['dq_exam'] = $qs->aquali_exam;
							$subset_arr['dq_relation'] = $qs->aquali_relation;
							$desire_quali_arr[] = $subset_arr;
						}
					}
					$stringmix = '';
					for($dd=0;$dd<count($desire_quali_arr);$dd++){
						$cur = $desire_quali_arr[$dd]['dq_relation'];
						if($dd==0){
							$stringmix = $stringmix.'(||'.$desire_quali_arr[$dd]['dq_exam'].'||';
							if($cur == "AND"){
								$stringmix = $stringmix.')'.$cur.'(';
							}elseif($cur == "OR"){
								$stringmix = $stringmix.$cur;
							}elseif($cur == "END"){
								$stringmix = $stringmix.')';
							}
						}else{
							$stringmix = $stringmix.'||'.$desire_quali_arr[$dd]['dq_exam'].'||';
							if($cur == "AND"){
								$stringmix = $stringmix.')'.$cur.'(';
							}elseif($cur == "OR"){
								$stringmix = $stringmix.$cur;
							}elseif($cur == "END"){
								$stringmix = $stringmix.')';
							}
						}
					}

					for($dd=0;$dd<count($desire_quali_arr);$dd++){
						//foreach($des_quali_details as $single_exams){
						foreach($dq_cand_checking_rows as $dq_items){
							if($desire_quali_arr[$dd]['dq_exam'] == $dq_items->chk_sub_typeid){
								$stringmix = str_replace("||".$desire_quali_arr[$dd]['dq_exam']."||",$dq_items->chk_got_marks, $stringmix);
								break;
								//$dsq_score = $dsq_score + $dq_items->chk_got_marks;
							}
						}
						$stringmix = str_replace("||".$desire_quali_arr[$dd]['dq_exam']."||",0, $stringmix);
					}

					if(trim($stringmix) != ""){
						$mixarray = explode("AND",$stringmix);
						for($dd=0;$dd<count($mixarray);$dd++){
							$getstringsets = $mixarray[$dd];
							$getstringsets = str_replace("(","", $getstringsets);
							$getstringsets = str_replace(")","", $getstringsets);
							$mixsub_array = explode("OR",$getstringsets);
							$maxnumber_find = max($mixsub_array);
							$dsq_score = $dsq_score + $maxnumber_find;
						}
					}
					$total_ac_score = $total_ac_score + $dsq_score;
					if($total_ac_score < 0){
						$total_ac_score = 0.00;
					}else{
						$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$cand_details->f_applied_for))->row();
						if($total_ac_score > $advdetails->amark_academic){
							$total_ac_score = (float)$advdetails->amark_academic;
						}
					}
					// Qualification END

					if($cand_details->adv_has_experience == "Yes" && $cand_details->fu_has_service == "Yes"){
						$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($candidate_refno);
						$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($cand_details->f_applied_for);
						$masterexp_arr = array();
						$desire_exp_arr = array();
						foreach($exp_list as $qs){
							$subset_arr = array();
							if($qs->aexpr_type == "Essential"){
								$subset_arr['exp_mainid'] = $qs->aexpr_id;
								$subset_arr['expname'] = $qs->aexpr_name;
								$subset_arr['exp_rel'] = $qs->aexpr_relation;
								$masterexp_arr[] = $subset_arr;
							}elseif($qs->aexpr_type == "Desirable"){
								$subset_arr['exp_mainid'] = $qs->aexpr_id;
								$subset_arr['expname'] = $qs->aexpr_name;
								$subset_arr['exp_rel'] = $qs->aexpr_relation;
								$desire_exp_arr[] = $subset_arr;
							}
						}
						$es_stringmix = $ds_stringmix = '';
						for($dd=0;$dd<count($masterexp_arr);$dd++){
							$cur = $masterexp_arr[$dd]['exp_rel'];
							if($dd==0){
								$es_stringmix = $es_stringmix.'(||'.$masterexp_arr[$dd]['expname'].'||';
								if($cur == "AND"){
									$es_stringmix = $es_stringmix.')'.$cur.'(';
								}elseif($cur == "OR"){
									$es_stringmix = $es_stringmix.$cur;
								}elseif($cur == "END"){
									$es_stringmix = $es_stringmix.')';
								}
							}else{
								$es_stringmix = $es_stringmix.'||'.$masterexp_arr[$dd]['expname'].'||';
								if($cur == "AND"){
									$es_stringmix = $es_stringmix.')'.$cur.'(';
								}elseif($cur == "OR"){
									$es_stringmix = $es_stringmix.$cur;
								}elseif($cur == "END"){
									$es_stringmix = $es_stringmix.')';
								}
							}
						}

						for($dd=0;$dd<count($desire_exp_arr);$dd++){
							$cur = $desire_exp_arr[$dd]['exp_rel'];
							if($dd==0){
								$ds_stringmix = $ds_stringmix.'(||'.$desire_exp_arr[$dd]['expname'].'||';
								if($cur == "AND"){
									$ds_stringmix = $ds_stringmix.')'.$cur.'(';
								}elseif($cur == "OR"){
									$ds_stringmix = $ds_stringmix.$cur;
								}elseif($cur == "END"){
									$ds_stringmix = $ds_stringmix.')';
								}
							}else{
								$ds_stringmix = $ds_stringmix.'||'.$desire_exp_arr[$dd]['expname'].'||';
								if($cur == "AND"){
									$ds_stringmix = $ds_stringmix.')'.$cur.'(';
								}elseif($cur == "OR"){
									$ds_stringmix = $ds_stringmix.$cur;
								}elseif($cur == "END"){
									$ds_stringmix = $ds_stringmix.')';
								}
							}
						}

						$eserv_cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$candidate_refno,'chk_type'=>'fu_has_es_service'))->result();
						$dserv_cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$candidate_refno,'chk_type'=>'fu_has_ds_service'))->result();

						for($dd=0;$dd<count($masterexp_arr);$dd++){
							foreach($eserv_cand_checking_rows as $esrv_items){
								if($masterexp_arr[$dd]['expname'] == $esrv_items->chk_sub_typeid){
									$es_stringmix = str_replace("||".$masterexp_arr[$dd]['expname']."||",$esrv_items->chk_got_marks, $es_stringmix);
									break;
								}
							}
							$es_stringmix = str_replace("||".$masterexp_arr[$dd]['expname']."||",0, $es_stringmix);
						}

						for($dd=0;$dd<count($desire_exp_arr);$dd++){
							foreach($dserv_cand_checking_rows as $dsrv_items){
								if($desire_exp_arr[$dd]['expname'] == $dsrv_items->chk_sub_typeid){
									$ds_stringmix = str_replace("||".$desire_exp_arr[$dd]['expname']."||",$dsrv_items->chk_got_marks, $ds_stringmix);
									break;
								}
							}
							$ds_stringmix = str_replace("||".$desire_exp_arr[$dd]['expname']."||",0, $ds_stringmix);
						}
						
						if(trim($es_stringmix) != ""){
							$es_mixarray = explode("AND",$es_stringmix);
							for($dd=0;$dd<count($es_mixarray);$dd++){
								$getstringsets = $es_mixarray[$dd];
								$getstringsets = str_replace("(","", $getstringsets);
								$getstringsets = str_replace(")","", $getstringsets);
								$mixsub_array = explode("OR",$getstringsets);
								$maxnumber_find = max($mixsub_array);
								$eserv_score = $eserv_score + $maxnumber_find;
							}
						}
						$total_ex_score = $total_ex_score + $eserv_score;

						if(trim($ds_stringmix) != ""){
							$ds_mixarray = explode("AND",$ds_stringmix);
							for($dd=0;$dd<count($ds_mixarray);$dd++){
								$getstringsets = $ds_mixarray[$dd];
								$getstringsets = str_replace("(","", $getstringsets);
								$getstringsets = str_replace(")","", $getstringsets);
								$mixsub_array = explode("OR",$getstringsets);
								$maxnumber_find = max($mixsub_array);
								$dserv_score = $dserv_score + $maxnumber_find;
							}
						}
						$total_ex_score = $total_ex_score + $dserv_score;

						if($total_ex_score < 0){
							$total_ex_score = 0.00;
						}else{
							$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$cand_details->f_applied_for))->row();
							if($total_ex_score > $advdetails->amark_experience){
								$total_ex_score = (float)$advdetails->amark_experience;
							}
						}

					}
				
					//Insert Candidate Result
					$masterupdation_arr = array(
						'cr_approval' => 'Approved',
						'cr_fprocess_date' => date('Y-m-d H:i:s'),
						'cr_academic' => $total_ac_score,
						'cr_experience' => $total_ex_score,
						'cr_total_marks' => ($total_ac_score + $total_ex_score + $cand_result_tab->cr_interview_1 + $cand_result_tab->cr_interview_2 + $cand_result_tab->cr_written)
					);
					if($this->candidates_m->setUpdate_ResultCandidate_Appliwise($masterupdation_arr, $candidate_refno) == TRUE){
						$getset_obj['message'] = 1;
						$getset_obj["success_message"] = 'Final Result Updated of the Candidate.';
						echo json_encode($getset_obj);
					}else{
						$getset_obj['message'] = 0;
						$getset_obj["error_message"] = 'Final Result Updation Failed of the Candidate.';
						echo json_encode($getset_obj);
					}
					
				}

			}else{
				$getset_obj['message'] = 0;
				$getset_obj["error_message"] = 'Checker Checking Not Complete Yet, Check it Once.';
				echo json_encode($getset_obj);
				
			}
			exit;
		}else{
			redirect('default404');
		}
	}


	/*public function getdata_enc($enctypedata){
		$desctypedata = openssl_decrypt(base64_decode($enctypedata),"AES-128-ECB",config_item('encryption_key'));
		$getstring_arr = explode("|",$desctypedata);
		print_r($getstring_arr);exit;
	}*/
}