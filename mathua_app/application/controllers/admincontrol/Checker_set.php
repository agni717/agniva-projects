<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Checker_set extends Admin_Controller {
	
	 public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->data['ssstr_arr'] = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service'
		);
    	$this->load->model('candidates_m');
	}
	
    public function index() {
		redirect('admincontrol/checker_set/mobile_no_verify');
    }
    
    public function mobile_no_verify(){
		if(!empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/candi_application_list'); 
		}
		if($_POST){
			$mobile = $this->input->post('c3_mobileno');
				$otp = $this->input->post('c3_otp');
				$uid = $this->input->post('usetid');
				
				$this->form_validation->set_error_delimiters('<span style="color:#F00;font-size:10px;">', '</span>');
				
				$this->form_validation->set_rules("c3_mobileno", "Mobile", "trim|required|xss_clean");
				$this->form_validation->set_rules("c3_otp", "OTP", "trim|required|xss_clean");
				$this->form_validation->set_rules("usetid", "ID", "trim|required|xss_clean");
					
				if ($this->form_validation->run() == TRUE) {
					if ($this->admin_m->checklogin_forCheker3($uid, $otp, $mobile) == TRUE) {
						//redirect($this->input->server('HTTP_REFERER'));
						
						$now = array(
							'ulog_user' => $this->session->userdata('guestid'),
							'ulog_access_time' => date('Y-m-d H:i:s'),
							'ulog_access_ip' => $this->input->ip_address()
						);
						$now2 = array(
							'otp_verify' => NULL
						);

						$this->admin_m->update_mobiledetails_existence($now2, $this->session->userdata('guestid'));
						$this->admin_m->update_adminuser_log($now);

						redirect('admincontrol/checker_set/candi_application_list');
						
					} else {
						
						$this->data["error"] = 'Sorry Wrong OTP, Try Again';
					}
				}
		}
		$this->load->view('admin/checker3/access_mobile_view', $this->data);
	}
	
	public function candi_application_list(){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");

			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/checker_set/candidate_chk3_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$sub_type);
				}else{
					redirect('admincontrol/checker_set/candidate_chk3_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items);
				}
				$this->data['searchlist'] = array('advno'=>$advno, 'u_accs'=>$acc_items);
				
				//$this->session->userdata['utype'];
				$this->data["guest_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['guestid']);
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				//print_r($udetail_access_arr);exit;
				$appli_list = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				if(count((array)$appli_list) == 0){
					$this->data['error'] = "No Data found for Checking.";
				}else{
					/*$str_arr = array(
						'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
					);*/
					$checker = 1;
					$utypes = $this->session->userdata['utype'];
					//$utypes = $this->session->userdata['guest_utype'];
					if($uaccess == NULL){
						$uaccess = $this->data['ssstr_arr'];
					}
					//foreach($uaccess as $acc_items){
					foreach($appli_list as $applies){
						if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
								
							//UPDATE
							$row_arr = array(
								'chk_createdate' => date('Y-m-d H:i:s')
							);
							if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $applies->f_application_no, $acc_items) == TRUE){
								$this->data['accessarray'] = array($acc_items);
								$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
								$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
								$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
								$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
								$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
								$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
								$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
								$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

								if ($appdetail->fu_district != NULL) {

									$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
									$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
								}
								if ($appdetail->fu_perma_dist != NULL) {

									$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
									$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
								}
								if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

									$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
									$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
								}

								if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

									$this->data['mb_type'] = $appdetail->fu_mb_type;
									$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
								}
								$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
								$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
								if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

									$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
								}
								$checker++;
								break;
							}else{
								$checker++;
								$this->data['error'] = "There have some problem to Update in DB, Check Again.";
								break;
							}
						}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNotNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
							
						}else{

							$chkcuste = 1;
							if($acc_items == "fu_caste"){
								if($applies->fu_caste_type == 1){
									$chkcuste++;
								}
							}
							if($chkcuste == 1){
								//INSERT
								$row_arr = array(
									'chk_user_application' => $applies->f_application_no,
									'chk_type' => $acc_items,
									'chk_create_by_type' => $utypes,
									'chk_createdate' => date('Y-m-d H:i:s')
								);
								if($this->candidates_m->addmodify_CheckTab_Sets($row_arr) == TRUE){
									$this->data['accessarray'] = array($acc_items);
									$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
									$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
									$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
									$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
									$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
									$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
									$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
									if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

										$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
									}
									$checker++;
									break;
								}else{
									$checker++;
									$this->data['error'] = "There have some problem to Insert in DB, Check Again.";
									break;
								}
							}
						}
					}
					
					if($checker == 1){
						$this->data['error'] = "No Data found for Checking.";
					}
				}
			}
		}
		$this->data["guest_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['guestid']);
		/*$str_arr = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
		);*/
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		//$udetail_access = $this->data["guest_details"]->u_access_area;
		$udetail_access = $this->data["u_details"]->u_access_area;
		//print_r($this->data["guest_details"]);exit;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/checker3/checker3_application_list', $this->data);
	}

	public function candidate_chk3_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $sub_type = NULL){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL){
			redirect('admincontrol/checker_set/candi_application_list');
		}
		if($this->admin_m->checkUser_existingAdvertisement_withAccess($advno, $acc_items) == FALSE){
			redirect('admincontrol/checker_set/candi_application_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/checker_set/candi_application_list');
			}
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'sub_type'=>$sub_type);
		$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
		if($sub_type != NULL){
			$this->data['searchsub_type'] = $this->candidates_m->GetDetailsofSub_type_By_Access($advno, $acc_items, $sub_type);
		}
		//$this->session->userdata['utype'];
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		if($adv_post_type == "ALL"){$adv_post_type = NULL;}
		//print_r($udetail_access_arr);exit;
		$checker = 1;
		$utypes = $this->session->userdata['utype'];
		if($uaccess == NULL){
			$uaccess = $this->data['ssstr_arr'];
		}
		$existuserrecord = $this->candidates_m->GetExactCheckerfor_Application_withNULL($advno, $utypes, $acc_items, $sub_type);
		if(count((array)$existuserrecord) > 0){
			$row_arr = array(
				'chk_createdate' => date('Y-m-d H:i:s')
			);
			if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $existuserrecord->f_application_no, $acc_items, $sub_type) == TRUE){
				$this->data['accessarray'] = array($acc_items);
				$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($existuserrecord->f_application_no);
				$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
				$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($existuserrecord->f_application_no);
				$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($existuserrecord->f_application_no);
				$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($existuserrecord->f_application_no);
				$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($existuserrecord->f_application_no);
				$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
				$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

				if ($appdetail->fu_district != NULL) {

					$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
					$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
				}
				if ($appdetail->fu_perma_dist != NULL) {

					$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
					$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
				}
				if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

					$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
					$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
				}else{
					$this->data['per_mb_type'] = NULL;
					$this->data['per_block_municipality'] = array();
				}

				if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

					$this->data['mb_type'] = $appdetail->fu_mb_type;
					$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
				}else{
					$this->data['mb_type'] = NULL;
					$this->data['block_municipality'] = array();
				}
				$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
				$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
				if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

					$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
				}
				if($acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification"){
					$this->data['other_chker_comment'] = $this->candidates_m->GetAll_OtherCheckerComments($existuserrecord->f_application_no, $acc_items, $sub_type);
				}else{
					$this->data['other_chker_comment'] = array();
				}
				$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($existuserrecord->f_application_no);
				$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($existuserrecord->f_application_no, $acc_items, $sub_type);
				$checker++;
			}else{
				$checker++;
				$this->data['error'] = "There have some problem to Update in DB, Check Again.";
			}
		}else{
			$existuserrecord = $this->candidates_m->GetNewCheckerfor_NewApplication_withNULL($advno, $acc_items, $sub_type, $utypes, $adv_post_type);
			if($existuserrecord != FALSE){
				
				$this->data['accessarray'] = array($acc_items);
				$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($existuserrecord->f_application_no);
				$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
				$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($existuserrecord->f_application_no);
				$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($existuserrecord->f_application_no);
				$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($existuserrecord->f_application_no);
				$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($existuserrecord->f_application_no);
				$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
				$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

				if ($appdetail->fu_district != NULL) {

					$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
					$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
				}
				if ($appdetail->fu_perma_dist != NULL) {

					$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
					$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
				}
				if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

					$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
					$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
				}else{
					$this->data['per_mb_type'] = NULL;
					$this->data['per_block_municipality'] = array();
				}

				if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

					$this->data['mb_type'] = $appdetail->fu_mb_type;
					$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
				}else{
					$this->data['mb_type'] = NULL;
					$this->data['block_municipality'] = array();
				}
				$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
				$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
				if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

					$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
				}
				if($acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification"){
					$this->data['other_chker_comment'] = $this->candidates_m->GetAll_OtherCheckerComments($existuserrecord->f_application_no, $acc_items, $sub_type);
				}else{
					$this->data['other_chker_comment'] = array();
				}
				$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($existuserrecord->f_application_no);
				$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($existuserrecord->f_application_no, $acc_items, $sub_type);
				$checker++;
					
			}else{
				$this->data['error'] = "No Data found for Checking.";
			}
		}
		///////////
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_nextforward_list', $this->data);
	}

	public function hold1234234234234234candidate_chk3_nextforwad_list($advno = NULL, $acc_items = NULL, $sub_type = NULL){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($advno == NULL || $acc_items == NULL){
			redirect('admincontrol/checker_set/candi_application_list');
		}
		if($acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/checker_set/candi_application_list');
			}
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'u_accs'=>$acc_items, 'sub_type'=>$sub_type);
		if($sub_type != NULL){
			$this->data['searchsub_type'] = $this->candidates_m->GetDetailsofSub_type_By_Access($advno, $acc_items, $sub_type);
		}
		//$this->session->userdata['utype'];
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		//print_r($udetail_access_arr);exit;
		$appli_list = $this->candidates_m->GetOptimizeCandidate_Application($advno);
		if(count((array)$appli_list) == 0){
			$this->data['error'] = "No Data found for Checking.";
		}else{
			
			$checker = 1;
			$utypes = $this->session->userdata['utype'];
			if($uaccess == NULL){
				$uaccess = $this->data['ssstr_arr'];
			}
			//foreach($uaccess as $acc_items){
			foreach($appli_list as $applies){
				if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($applies->f_application_no, $utypes, $acc_items, $sub_type) == TRUE){
						
					//$get_holddetails = $this->db->get_where('checking_tab',array('chk_user_application'=>$applies->f_application_no,'chk_create_by_type'=>$utypes, 'chk_type'=>$acc_items))->row();
					//UPDATE
					if($this->candidates_m->GetDetails_ExactCheckerfor_Application_withNULL($applies->f_application_no, $utypes, $acc_items, $sub_type) == TRUE){
						$row_arr = array(
							'chk_createdate' => date('Y-m-d H:i:s')
						);
						if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $applies->f_application_no, $acc_items, $sub_type) == TRUE){
							$this->data['accessarray'] = array($acc_items);
							$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
							$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
							$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
							$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
							$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
							$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
							$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
							$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

							if ($appdetail->fu_district != NULL) {

								$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
								$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
							}
							if ($appdetail->fu_perma_dist != NULL) {

								$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
								$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
							}
							if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

								$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
								$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
							}else{
								$this->data['per_mb_type'] = NULL;
								$this->data['per_block_municipality'] = array();
							}

							if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

								$this->data['mb_type'] = $appdetail->fu_mb_type;
								$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
							}else{
								$this->data['mb_type'] = NULL;
								$this->data['block_municipality'] = array();
							}
							$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
							$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
							if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

								$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
							}
							$checker++;
							break;
						}else{
							$checker++;
							$this->data['error'] = "There have some problem to Update in DB, Check Again.";
							break;
						}
					}

				}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNotNULL($applies->f_application_no, $utypes, $acc_items, $sub_type) == TRUE){
					
				}else{
					//INSERT
					$chkcuste = 1;
					if($acc_items == "fu_caste"){
						if($applies->fu_caste_type == 1){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_pwd"){
						if($applies->fu_pwd != 'Yes'){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_exempted"){
						if($applies->fu_exempted != 'Yes'){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_exservice"){
						if($applies->fu_exservice != 'Yes'){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_ews"){
						if($applies->fu_ews != 'Yes'){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_ds_qualification"){
						if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withESQE($applies->f_application_no, $utypes, $acc_items, $sub_type) == FALSE){
							$chkcuste++;
						}
					}elseif($acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
						if($applies->fu_has_service != 'Yes'){
							$chkcuste++;
						}else{
							if($acc_items == "fu_has_ds_service"){
								if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withESQE($applies->f_application_no, $utypes, $acc_items, $sub_type) == FALSE){
									$chkcuste++;
								}
							}
						}
					}

					if($chkcuste == 1){
						$row_arr = array(
							'chk_user_application' => $applies->f_application_no,
							'chk_type' => $acc_items,
							'chk_create_by_type' => $utypes,
							'chk_createby' => $this->session->userdata['uid'],
							'chk_createdate' => date('Y-m-d H:i:s')
						);
						if($sub_type != NULL){
							$row_arr['chk_sub_typeid'] = $sub_type;
						}
						if($this->candidates_m->checkAlready_Exist_ForOtherChecker($applies->f_application_no, $acc_items, $sub_type) == TRUE){
							if($this->candidates_m->addmodify_CheckTab_Sets($row_arr) == TRUE){
								$this->data['accessarray'] = array($acc_items);
								$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
								$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
								$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
								$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
								$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
								$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
								$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
								$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

								if ($appdetail->fu_district != NULL) {

									$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
									$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
								}
								if ($appdetail->fu_perma_dist != NULL) {

									$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
									$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
								}
								if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

									$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
									$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
								}else{
									$this->data['per_mb_type'] = NULL;
									$this->data['per_block_municipality'] = array();
								}

								if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

									$this->data['mb_type'] = $appdetail->fu_mb_type;
									$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
								}else{
									$this->data['mb_type'] = NULL;
									$this->data['block_municipality'] = array();
								}
								$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
								$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
								if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

									$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
								}
								$checker++;
								break;
							}else{
								$checker++;
								$this->data['error'] = "There have some problem to Insert in DB, Check Again.";
								break;
							}
						}
					}

				}
			}
			//}
			
			if($checker == 1){
				$this->data['error'] = "No Data found for Checking.";
			}
		}
		
		
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_nextforward_list', $this->data);
	}


	public function candi_chk3_skipped_list(){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/checker_set/candidate_chk3_skipforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$sub_type);
				}else{
					redirect('admincontrol/checker_set/candidate_chk3_skipforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items);
				}
				$this->data['searchlist'] = array('advno'=>$advno, 'u_accs'=>$acc_items);
				//$this->session->userdata['utype'];
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				//print_r($udetail_access_arr);exit;
				$appli_list = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				if(count((array)$appli_list) == 0){
					$this->data['error'] = "No Data found for Checking.";
				}else{
					/*$str_arr = array(
						'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
					);*/
					$checker = 1;
					$utypes = $this->session->userdata['utype'];
					if($uaccess == NULL){
						$uaccess = $this->data['ssstr_arr'];
					}
					//foreach($uaccess as $acc_items){
					foreach($appli_list as $applies){
						if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
								
							//UPDATE
							$row_arr = array(
								'chk_createdate' => date('Y-m-d H:i:s')
							);
							if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $applies->f_application_no, $acc_items) == TRUE){
								$this->data['accessarray'] = array($acc_items);
								$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
								$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
								$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
								$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
								$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
								$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
								$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
								$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

								if ($appdetail->fu_district != NULL) {

									$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
									$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
								}
								if ($appdetail->fu_perma_dist != NULL) {

									$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
									$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
								}
								if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

									$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
									$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
								}

								if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

									$this->data['mb_type'] = $appdetail->fu_mb_type;
									$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
								}
								$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
								$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
								if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

									$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
								}
								$checker++;
								break;
							}else{
								$checker++;
								$this->data['error'] = "There have some problem to Update in DB, Check Again.";
								break;
							}
						}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNotNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
							
						}else{
							//INSERT
							$chkcuste = 1;
							if($acc_items == "fu_caste"){
								if($applies->fu_caste_type == 1){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_pwd"){
								if($applies->fu_pwd != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_exempted"){
								if($applies->fu_exempted != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_exservice"){
								if($applies->fu_exservice != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_ews"){
								if($applies->fu_ews != 'Yes'){
									$chkcuste++;
								}
							}
							if($chkcuste == 1){
								$row_arr = array(
									'chk_user_application' => $applies->f_application_no,
									'chk_type' => $acc_items,
									'chk_create_by_type' => $utypes,
									'chk_createdate' => date('Y-m-d H:i:s')
								);
								if($this->candidates_m->addmodify_CheckTab_Sets($row_arr) == TRUE){
									$this->data['accessarray'] = array($acc_items);
									$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
									$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
									$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
									$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
									$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
									$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
									$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
									$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

									if ($appdetail->fu_district != NULL) {

										$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
										$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
									}
									if ($appdetail->fu_perma_dist != NULL) {

										$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
										$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
									}
									if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

										$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
										$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
									}

									if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

										$this->data['mb_type'] = $appdetail->fu_mb_type;
										$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
									}
									$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
									$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
									if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

										$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
									}
									$checker++;
									break;
								}else{
									$checker++;
									$this->data['error'] = "There have some problem to Insert in DB, Check Again.";
									break;
								}
							}

						}
					}
					//}
					
					if($checker == 1){
						$this->data['error'] = "No Data found for Checking.";
					}
				}
			}
		}
		/*$str_arr = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
		);*/
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_skip_application_list', $this->data);
	}

	public function candidate_chk3_skipforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $sub_type = NULL){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL){
			redirect('admincontrol/checker_set/candi_chk3_skipped_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/checker_set/candi_chk3_skipped_list');
			}
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'sub_type'=>$sub_type);
		$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
		if($sub_type != NULL){
			$this->data['searchsub_type'] = $this->candidates_m->GetDetailsofSub_type_By_Access($advno, $acc_items, $sub_type);
		}
		//$this->session->userdata['utype'];
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		if($adv_post_type == "ALL"){$adv_post_type = NULL;}
		//print_r($udetail_access_arr);exit;
		$appli_list = $this->candidates_m->GetDetailsofCandidate_Skip_Application($advno, $acc_items, $sub_type, $adv_post_type);
		if(count((array)$appli_list) == 0){
			$this->data['error'] = "No Data found for Checking.";
		}else{
			/*$str_arr = array(
				'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
			);*/
			$checker = 1;
			$utypes = $this->session->userdata['utype'];
			if($uaccess == NULL){
				$uaccess = $this->data['ssstr_arr'];
			}
			//foreach($uaccess as $acc_items){
			foreach($appli_list as $applies){
				
					$this->data['accessarray'] = array($acc_items);
					$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
					$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
					$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
					$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
					$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
					$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
					$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
					$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

					if ($appdetail->fu_district != NULL) {

						$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
						$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
					}
					if ($appdetail->fu_perma_dist != NULL) {

						$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
						$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
					}
					if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

						$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
						$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
					}else{
						$this->data['per_mb_type'] = NULL;
						$this->data['per_block_municipality'] = array();
					}

					if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

						$this->data['mb_type'] = $appdetail->fu_mb_type;
						$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
					}else{
						$this->data['mb_type'] = NULL;
						$this->data['block_municipality'] = array();
					}
					$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
					$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
					if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

						$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
					}
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']);
					if($acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification"){
						$this->data['other_chker_comment'] = $this->candidates_m->GetAll_OtherCheckerComments($applies->f_application_no, $acc_items, $sub_type);
					}else{
						$this->data['other_chker_comment'] = array();
					}
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					//$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$checker++;
					break;
				
			}
			//}
			
			if($checker == 1){
				$this->data['error'] = "No Data found for Checking.";
			}
		}
		
		/*$str_arr = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
		);*/
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_skipforward_list', $this->data);
	}


	public function holddddssss_checking_chk3_section_update(){
		if($_POST){
			$app_no = $this->input->post('app_no');
            $access_no = $this->input->post('access_no');
            $app_status = $this->input->post('app_status');
            $app_comment = $this->input->post('app_comment');
            
			$this->form_validation->set_rules('app_no', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('access_no', 'Access Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('app_status', 'Application Status', 'trim|required|alpha');
			if($app_status != "Approved"){
            	$this->form_validation->set_rules('app_comment', 'Application Comments', 'trim|required');
            }else{
				$this->form_validation->set_rules('app_comment', 'Application Comments', 'trim');
			}
			if($this->form_validation->run() == TRUE){
				
				$utypes = $this->session->userdata['utype'];
				if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($app_no, $utypes, $access_no) == TRUE){
					
					$row_arr = array(
						'chk_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk_comments' => trim($app_comment),
						'chk_appro_date' => date('Y-m-d H:i:s'),
						'chk_createby' => $this->session->userdata('uid')
					);

					//Point Distributions Start
					$totalscore = 0.00;
					if(($access_no == "fu_qualification" || $access_no == "fu_has_service") && ($app_status == "Approved")){
						$adv_no = $this->db->get_where('f_user_views',array('f_application_no'=>$app_no,'fu_step_4'=>1,'fu_final_submit'=>1))->row();
						
						if($access_no == "fu_qualification"){
							$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							foreach($quali_details as $single_exams){
								$singleexams = 0.00;
								$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fu_qualifiaction_name);
								if($adv_qu_set->aquali_category == "Full"){
									$singleexams = (float)$adv_qu_set->aquali_marks;
								}elseif($adv_qu_set->aquali_category == "Percent"){
									$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fu_percentmark_ck) / (100));
								}elseif($adv_qu_set->aquali_category == "Slab"){
									$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
									$iset = 0;
									foreach($adv_qdetail_list as $keys=>$qdetail){
										if($keys == 0){
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}
										}else{
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}	
										}
										$iset = $qdetail->aq_detail_score_lvl;
									}
								}
								$totalscore = $totalscore + $singleexams;
								if($adv_qu_set->aquali_attempt != "No" && $single_exams->fu_is_attempt == "Yes"){
									$singleexams = 0.00;
									if($adv_qu_set->aquali_attempt == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_fullpercent;
									}elseif($adv_qu_set->aquali_attempt == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
									}elseif($adv_qu_set->aquali_attempt == "Slab"){
										$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$jset = 0;
										//$dedcount = count((array)$adv_deduction_list);
										foreach($adv_deduction_list as $keys=>$ded_detail){
											if($keys == 0){
												if($single_exams->fu_attempt_no > 0 && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}else{
												if($single_exams->fu_attempt_no > $jset && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}
											$jset = $ded_detail->aq_deduct_lvl;
										}
									}
									$totalscore = $totalscore - $singleexams;	
								}
							}
							
							foreach($des_quali_details as $single_exams){
								$singleexams = 0.00;
								//echo "hi111";exit;
								//print_r($single_exams);exit;
								$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fud_qualifiaction_name);
								if($adv_qu_set->aquali_category == "Full"){
									$singleexams = (float)$adv_qu_set->aquali_marks;
								}elseif($adv_qu_set->aquali_category == "Percent"){
									$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fud_percentmark_ck) / (100));
								}elseif($adv_qu_set->aquali_category == "Slab"){
									$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
									$iset = 0;
									foreach($adv_qdetail_list as $keys=>$qdetail){
										if($keys == 0){
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}
										}else{
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}	
										}
										$iset = $qdetail->aq_detail_score_lvl;
									}
								}
								$totalscore = $totalscore + $singleexams;
								if($adv_qu_set->aquali_attempt != "No" && $single_exams->fud_is_attempt == "Yes"){
									$singleexams = 0.00;
									if($adv_qu_set->aquali_attempt == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_fullpercent;
									}elseif($adv_qu_set->aquali_attempt == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
									}elseif($adv_qu_set->aquali_attempt == "Slab"){
										$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$jset = 0;
										//$dedcount = count((array)$adv_deduction_list);
										foreach($adv_deduction_list as $keys=>$ded_detail){
											if($keys == 0){
												if($single_exams->fud_attempt_no > 0 && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}else{
												if($single_exams->fud_attempt_no > $jset && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}
											$jset = $ded_detail->aq_deduct_lvl;
										}
									}
									$totalscore = $totalscore - $singleexams;	
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}elseif($access_no == "fu_has_service"){
							if($adv_no->fu_has_service == "Yes"){
								$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								$masterexp_arr = array();
								$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Essential"){
										if($keys == 0){
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}else{
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}
									}elseif($qs->aexpr_type == "Desirable"){
										$subset_arr['exp_mainid'] = $qs->aexpr_id;
										$subset_arr['expname'] = $qs->aexpr_name;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										//$subset_arr['exp_reach'] = 0;
										$desire_exp_arr[] = $subset_arr;
									}
								}
								$cand_ess_muster_array = array();
								$cand_des_muster_array = array();
								$ii = $jj = 0;
								for($ii = 0;$ii < count($masterexp_arr);$ii++){
									$cand_sub_array = array(
										'exp_id' => $masterexp_arr[$ii][0]['exp_mainid'],
										'exp_reach' => 0
									);
									foreach($essen_exp_details as $escan_sets){
										for($jj = 0;$jj < count($masterexp_arr[$ii]);$jj++){
											if($escan_sets->fues_exp_workname == $masterexp_arr[$ii][$jj]['expname']){
												$totalmonth = ($escan_sets->fues_exp_year * 12) + $escan_sets->fues_exp_month;
												$cand_sub_array['exp_reach'] = $cand_sub_array['exp_reach'] + $totalmonth;
												break;
											}
										}
									}
									$cand_ess_muster_array[] = $cand_sub_array;
								}

								for($ii = 0;$ii < count($cand_ess_muster_array);$ii++){
									$single_exps = 0.00;
									$total_gov_exp = $cand_ess_muster_array[$ii]['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_ess_muster_array[$ii]['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}

								if(!empty($exp_details)){
									$ii = 0;
									$cand_des_muster_array = array(
										'exp_id' => $desire_exp_arr[$ii]['exp_mainid'],
										'exp_reach' => 0
									);
									for($ii = 0;$ii < count($desire_exp_arr);$ii++){
										foreach($exp_details as $des_sets){
											if($des_sets->fu_exp_workname == $desire_exp_arr[$ii]['expname']){
												$totalmonth = ($des_sets->fu_exp_year * 12) + $des_sets->fu_exp_month;
												$cand_des_muster_array['exp_reach'] = $cand_des_muster_array['exp_reach'] + $totalmonth;
												break;
											}
										}
									}

									$single_exps = 0.00;
									$total_gov_exp = $cand_des_muster_array['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_des_muster_array['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
					}
					$row_arr['chk_got_marks'] = $totalscore;
					//Point Distributions End
					//exit;
					if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no) == TRUE){
						$rowarray = array(
							'chklog_app_no' => $app_no,
							'chklog_type' => $access_no,
							'chklog_user' => $this->session->userdata('uid'),
							'chklog_approval' => $app_status,
							'chklog_msg' => trim($app_comment),
							'chklog_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->update_adminChecker_user_log($rowarray);
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>''));
					}

				}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withSKIP($app_no, $utypes, $access_no) == TRUE){

					$row_arr = array(
						'chk_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk_comments' => trim($app_comment),
						'chk_appro_date' => date('Y-m-d H:i:s'),
						'chk_createby' => $this->session->userdata('uid')
					);

					//Point Distributions Start
					$totalscore = 0.00;
					if(($access_no == "fu_qualification" || $access_no == "fu_has_service") && ($app_status == "Approved")){
						$adv_no = $this->db->get_where('f_user_views',array('f_application_no'=>$app_no,'fu_step_4'=>1,'fu_final_submit'=>1))->row();
						
						if($access_no == "fu_qualification"){
							$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							foreach($quali_details as $single_exams){
								$singleexams = 0.00;
								$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fu_qualifiaction_name);
								if($adv_qu_set->aquali_category == "Full"){
									$singleexams = (float)$adv_qu_set->aquali_marks;
								}elseif($adv_qu_set->aquali_category == "Percent"){
									$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fu_percentmark_ck) / (100));
								}elseif($adv_qu_set->aquali_category == "Slab"){
									$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
									$iset = 0;
									foreach($adv_qdetail_list as $keys=>$qdetail){
										if($keys == 0){
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}
										}else{
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}	
										}
										$iset = $qdetail->aq_detail_score_lvl;
									}
								}
								$totalscore = $totalscore + $singleexams;
								if($adv_qu_set->aquali_attempt != "No" && $single_exams->fu_is_attempt == "Yes"){
									$singleexams = 0.00;
									if($adv_qu_set->aquali_attempt == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_fullpercent;
									}elseif($adv_qu_set->aquali_attempt == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
									}elseif($adv_qu_set->aquali_attempt == "Slab"){
										$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$jset = 0;
										//$dedcount = count((array)$adv_deduction_list);
										foreach($adv_deduction_list as $keys=>$ded_detail){
											if($keys == 0){
												if($single_exams->fu_attempt_no > 0 && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}else{
												if($single_exams->fu_attempt_no > $jset && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}
											$jset = $ded_detail->aq_deduct_lvl;
										}
									}
									$totalscore = $totalscore - $singleexams;	
								}
							}
							
							foreach($des_quali_details as $single_exams){
								$singleexams = 0.00;
								//echo "hi111";exit;
								//print_r($single_exams);exit;
								$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fud_qualifiaction_name);
								if($adv_qu_set->aquali_category == "Full"){
									$singleexams = (float)$adv_qu_set->aquali_marks;
								}elseif($adv_qu_set->aquali_category == "Percent"){
									$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fud_percentmark_ck) / (100));
								}elseif($adv_qu_set->aquali_category == "Slab"){
									$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
									$iset = 0;
									foreach($adv_qdetail_list as $keys=>$qdetail){
										if($keys == 0){
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}
										}else{
											if($qdetail->aq_detail_score_lvl != 100){
												if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}
											}else{
												if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
													$singleexams = (float)$qdetail->aq_detail_score_mark;
													break;
												}	
											}	
										}
										$iset = $qdetail->aq_detail_score_lvl;
									}
								}
								$totalscore = $totalscore + $singleexams;
								if($adv_qu_set->aquali_attempt != "No" && $single_exams->fud_is_attempt == "Yes"){
									$singleexams = 0.00;
									if($adv_qu_set->aquali_attempt == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_fullpercent;
									}elseif($adv_qu_set->aquali_attempt == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
									}elseif($adv_qu_set->aquali_attempt == "Slab"){
										$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$jset = 0;
										//$dedcount = count((array)$adv_deduction_list);
										foreach($adv_deduction_list as $keys=>$ded_detail){
											if($keys == 0){
												if($single_exams->fud_attempt_no > 0 && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}else{
												if($single_exams->fud_attempt_no > $jset && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
													$singleexams = (float)$ded_detail->aq_deduct_mark;
													break;
												}	
											}
											$jset = $ded_detail->aq_deduct_lvl;
										}
									}
									$totalscore = $totalscore - $singleexams;	
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}elseif($access_no == "fu_has_service"){
							if($adv_no->fu_has_service == "Yes"){
								$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								$masterexp_arr = array();
								$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Essential"){
										if($keys == 0){
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}else{
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}
									}elseif($qs->aexpr_type == "Desirable"){
										$subset_arr['exp_mainid'] = $qs->aexpr_id;
										$subset_arr['expname'] = $qs->aexpr_name;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										//$subset_arr['exp_reach'] = 0;
										$desire_exp_arr[] = $subset_arr;
									}
								}
								$cand_ess_muster_array = array();
								$cand_des_muster_array = array();
								$ii = $jj = 0;
								for($ii = 0;$ii < count($masterexp_arr);$ii++){
									$cand_sub_array = array(
										'exp_id' => $masterexp_arr[$ii][0]['exp_mainid'],
										'exp_reach' => 0
									);
									foreach($essen_exp_details as $escan_sets){
										for($jj = 0;$jj < count($masterexp_arr[$ii]);$jj++){
											if($escan_sets->fues_exp_workname == $masterexp_arr[$ii][$jj]['expname']){
												$totalmonth = ($escan_sets->fues_exp_year * 12) + $escan_sets->fues_exp_month;
												$cand_sub_array['exp_reach'] = $cand_sub_array['exp_reach'] + $totalmonth;
												break;
											}
										}
									}
									$cand_ess_muster_array[] = $cand_sub_array;
								}

								for($ii = 0;$ii < count($cand_ess_muster_array);$ii++){
									$single_exps = 0.00;
									$total_gov_exp = $cand_ess_muster_array[$ii]['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_ess_muster_array[$ii]['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}

								if(!empty($exp_details)){
									$ii = 0;
									$cand_des_muster_array = array(
										'exp_id' => $desire_exp_arr[$ii]['exp_mainid'],
										'exp_reach' => 0
									);
									for($ii = 0;$ii < count($desire_exp_arr);$ii++){
										foreach($exp_details as $des_sets){
											if($des_sets->fu_exp_workname == $desire_exp_arr[$ii]['expname']){
												$totalmonth = ($des_sets->fu_exp_year * 12) + $des_sets->fu_exp_month;
												$cand_des_muster_array['exp_reach'] = $cand_des_muster_array['exp_reach'] + $totalmonth;
												break;
											}
										}
									}

									$single_exps = 0.00;
									$total_gov_exp = $cand_des_muster_array['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_des_muster_array['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
					}
					$row_arr['chk_got_marks'] = $totalscore;
					//Point Distributions End
					//exit;
					if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no) == TRUE){
						$rowarray = array(
							'chklog_app_no' => $app_no,
							'chklog_type' => $access_no,
							'chklog_user' => $this->session->userdata('uid'),
							'chklog_approval' => $app_status,
							'chklog_msg' => trim($app_comment),
							'chklog_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->update_adminChecker_user_log($rowarray);
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>''));
					}

				}else{
					echo json_encode(array('msg'=>2, 'e_msg'=>'Already Action is taken by Other Checker.'));
				}
				
            }else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function candidate_returned_list(){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/checker_set/candidate_chk3_returnforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$sub_type);
				}else{
					redirect('admincontrol/checker_set/candidate_chk3_returnforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items);
				}
				$this->data['searchlist'] = array('advno'=>$advno, 'u_accs'=>$acc_items);
				//$this->session->userdata['utype'];
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				//print_r($udetail_access_arr);exit;
				$appli_list = $this->candidates_m->GetDetailsofCandidate_Application(NULL, $advno);
				if(count((array)$appli_list) == 0){
					$this->data['error'] = "No Data found for Checking.";
				}else{
					/*$str_arr = array(
						'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
					);*/
					$checker = 1;
					$utypes = $this->session->userdata['utype'];
					if($uaccess == NULL){
						$uaccess = $this->data['ssstr_arr'];
					}
					//foreach($uaccess as $acc_items){
					foreach($appli_list as $applies){
						if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
								
							//UPDATE
							$row_arr = array(
								'chk_createdate' => date('Y-m-d H:i:s')
							);
							if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $applies->f_application_no, $acc_items) == TRUE){
								$this->data['accessarray'] = array($acc_items);
								$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
								$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
								$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
								$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
								$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
								$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
								$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
								$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

								if ($appdetail->fu_district != NULL) {

									$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
									$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
								}
								if ($appdetail->fu_perma_dist != NULL) {

									$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
									$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
								}
								if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

									$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
									$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
								}

								if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

									$this->data['mb_type'] = $appdetail->fu_mb_type;
									$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
								}
								$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
								$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
								if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

									$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
								}
								$checker++;
								break;
							}else{
								$checker++;
								$this->data['error'] = "There have some problem to Update in DB, Check Again.";
								break;
							}
						}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNotNULL($applies->f_application_no, $utypes, $acc_items) == TRUE){
							
						}else{
							//INSERT
							$chkcuste = 1;
							if($acc_items == "fu_caste"){
								if($applies->fu_caste_type == 1){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_pwd"){
								if($applies->fu_pwd != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_exempted"){
								if($applies->fu_exempted != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_exservice"){
								if($applies->fu_exservice != 'Yes'){
									$chkcuste++;
								}
							}elseif($acc_items == "fu_ews"){
								if($applies->fu_ews != 'Yes'){
									$chkcuste++;
								}
							}
							if($chkcuste == 1){
								$row_arr = array(
									'chk_user_application' => $applies->f_application_no,
									'chk_type' => $acc_items,
									'chk_create_by_type' => $utypes,
									'chk_createdate' => date('Y-m-d H:i:s')
								);
								if($this->candidates_m->addmodify_CheckTab_Sets($row_arr) == TRUE){
									$this->data['accessarray'] = array($acc_items);
									$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
									$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
									$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
									$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
									$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
									$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
									$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
									$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

									if ($appdetail->fu_district != NULL) {

										$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
										$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
									}
									if ($appdetail->fu_perma_dist != NULL) {

										$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
										$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
									}
									if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

										$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
										$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
									}

									if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

										$this->data['mb_type'] = $appdetail->fu_mb_type;
										$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
									}
									$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
									$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
									if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

										$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
									}
									$checker++;
									break;
								}else{
									$checker++;
									$this->data['error'] = "There have some problem to Insert in DB, Check Again.";
									break;
								}
							}

						}
					}
					//}
					
					if($checker == 1){
						$this->data['error'] = "No Data found for Checking.";
					}
				}
			}
		}
		/*$str_arr = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
		);*/
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_return_application_list', $this->data);
	}

	public function candidate_chk3_returnforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $sub_type = NULL){
		if(empty($this->session->userdata('guestid'))){
			redirect('admincontrol/checker_set/mobile_no_verify'); 
		}
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL){
			redirect('admincontrol/checker_set/candidate_returned_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/checker_set/candidate_returned_list');
			}
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'sub_type'=>$sub_type);
		$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
		if($sub_type != NULL){
			$this->data['searchsub_type'] = $this->candidates_m->GetDetailsofSub_type_By_Access($advno, $acc_items, $sub_type);
		}
		//$this->session->userdata['utype'];
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		if($adv_post_type == "ALL"){$adv_post_type = NULL;}
		//print_r($udetail_access_arr);exit;
		$appli_list = $this->candidates_m->GetDetailsofCandidate_Return_Application($advno, $acc_items, $sub_type, $adv_post_type);
		if(count((array)$appli_list) == 0){
			$this->data['error'] = "No Data found for Checking.";
		}else{
			/*$str_arr = array(
				'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
			);*/
			$checker = 1;
			$utypes = $this->session->userdata['utype'];
			if($uaccess == NULL){
				$uaccess = $this->data['ssstr_arr'];
			}
			//foreach($uaccess as $acc_items){
			foreach($appli_list as $applies){
				
					$this->data['accessarray'] = array($acc_items);
					$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($applies->f_application_no);
					$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
					$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($applies->f_application_no);
					$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($applies->f_application_no);
					$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($applies->f_application_no);
					$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($applies->f_application_no);
					$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
					$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

					if ($appdetail->fu_district != NULL) {

						$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
						$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
					}
					if ($appdetail->fu_perma_dist != NULL) {

						$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
						$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
					}
					if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {

						$this->data['per_mb_type'] = $appdetail->fu_perma_mb_type;
						$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
					}else{
						$this->data['per_mb_type'] = NULL;
						$this->data['per_block_municipality'] = array();
					}

					if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {

						$this->data['mb_type'] = $appdetail->fu_mb_type;
						$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
					}else{
						$this->data['mb_type'] = NULL;
						$this->data['block_municipality'] = array();
					}
					$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
					$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
					if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {

						$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
					}
					$this->data['checker_details'] = $this->candidates_m->getprev_checker2_details($applies->f_application_no, $acc_items);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				
			}
			//}
			
			if($checker == 1){
				$this->data['error'] = "No Data found for Checking.";
			}
		}
		
		/*$str_arr = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
		);*/
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/checker3/candidate_returnforward_list', $this->data);
	}


	public function signout_verify_sdfsdfsdfffff(){
		//$array_items = array('guestid' => '', 'guest_utype' => '');
		//$this->session->unset_userdata($array_items);
		$this->session->unset_userdata('guestid');
		$this->session->unset_userdata('guest_utype');
		redirect('admincontrol/checker_set/mobile_no_verify');
	}
	
	public function get_otp_set_for_cheker(){
		if($_POST){
			$mobileid = $this->input->post('mobile_no');
			$msg = 0;
			if($mobileid != ""){
				$curtime = date('Y-m-d H:i:s');
				if($this->admin_m->check_Checker3_existence($mobileid, $curtime) == TRUE){
					
					$chk_exist = $this->admin_m->get_Checker3_data($mobileid, $curtime);
					//print_r($chk_exist);
					$generate_otp = 999999; //$this->generateRandomString(6);
					$row_arr = array(
						'otp_verify' => $generate_otp,
						'otp_count' => ($chk_exist->otp_count + 1),
						'otp_sendtime' => date('Y-m-d H:i:s')
					);
					if($this->admin_m->update_mobiledetails_existence($row_arr, $chk_exist->u_id) == TRUE){
						
						$msg111 = 'Thank you for login in WBHRB website. Your OTP is '.$generate_otp.'.';
						//$smsreplyset = $this->sendALLSMS($msg111, $mobileid, "otpmsg", '1207163455580746477');
						//$smsarray = explode(',', $smsreplyset);
						$smsarray = array(402);
						if($smsarray[0] == 402){
							echo json_encode(array('msg'=>1, 's_msg' => $chk_exist->u_id, 'adm_msg' => ''));
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>'OTP not Send properly, Try Again'));
						}
						//echo json_encode(array('msg'=>1, 's_msg' => $chk_exist->u_id));
						
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
	
	
	public function checking_chk3_section_update(){
		if($_POST){
			$app_no = $this->input->post('app_no');
            $access_no = $this->input->post('access_no');
			$access_id = $this->input->post('access_id');
            $app_status = $this->input->post('app_status');
            $app_comment = $this->input->post('app_comment');
            
			$this->form_validation->set_rules('app_no', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('access_no', 'Access Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('app_status', 'Application Status', 'trim|required|alpha');
			if($app_status == "Rejected" || $app_status == "Skip"){
            	$this->form_validation->set_rules('app_comment', 'Application Comments', 'trim|required');
            }else{
				$this->form_validation->set_rules('app_comment', 'Application Comments', 'trim');
			}
			if($access_no == "fu_age_relax" || $access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service"){
				$this->form_validation->set_rules('access_id', 'Application Type ID', 'trim|required');
			}
			if($this->form_validation->run() == TRUE){
				if($access_id == ""){$access_id = NULL;}
				$utypes = $this->session->userdata['utype'];
				if($this->candidates_m->GetDetails_Userwise_Candidate_Application_withNULL($app_no, $utypes, $access_no, $access_id) == TRUE){
					
					$row_arr = array(
						'chk_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk_comments' => trim($app_comment),
						'chk_appro_date' => date('Y-m-d H:i:s')
					);
					if($app_status == "Approved" || $app_status == "Rejected"){
						$row_arr['chk2_approve'] = $app_status;
						$row_arr['chk2_comments'] = trim($app_comment);
						$row_arr['chk2_appro_date'] = date('Y-m-d H:i:s');
						$row_arr['chk2_appro_by'] = $this->session->userdata('uid');
					}

					//Point Distributions Start
					$totalscore = 0.00;
					if(($access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service") && $app_status == "Approved"){
						$adv_no = $this->db->get_where('f_user_views',array('f_application_no'=>$app_no,'fu_final_submit'=>1))->row();
						
						if($access_no == "fu_es_qualification"){
							$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							//$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							foreach($quali_details as $single_exams){
								$singleexams = 0.00;
								if($single_exams->fu_qualifiaction_name == $access_id){
									$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fu_qualifiaction_name);
									if($adv_qu_set->aquali_category == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_marks;
									}elseif($adv_qu_set->aquali_category == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fu_percentmark_ck) / (100));
									}elseif($adv_qu_set->aquali_category == "Slab"){
										$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$iset = 0;
										foreach($adv_qdetail_list as $keys=>$qdetail){
											if($keys == 0){
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}
											}else{
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}	
											}
											$iset = $qdetail->aq_detail_score_lvl;
										}
									}
									$totalscore = $totalscore + $singleexams;
									if($adv_qu_set->aquali_attempt != "No" && $single_exams->fu_is_attempt == "Yes"){
										$singleexams = 0.00;
										if($adv_qu_set->aquali_attempt == "Full"){
											$singleexams = (float)$adv_qu_set->aquali_fullpercent;
										}elseif($adv_qu_set->aquali_attempt == "Percent"){
											$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
										}elseif($adv_qu_set->aquali_attempt == "Slab"){
											$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
											$jset = 0;
											//$dedcount = count((array)$adv_deduction_list);
											foreach($adv_deduction_list as $keys=>$ded_detail){
												if($keys == 0){
													if($single_exams->fu_attempt_no > 0 && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}else{
													if($single_exams->fu_attempt_no > $jset && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}
												$jset = $ded_detail->aq_deduct_lvl;
											}
										}
										$totalscore = $totalscore - $singleexams;	
									}
									break;
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}
						elseif($access_no == "fu_ds_qualification"){
							//$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							
							foreach($des_quali_details as $single_exams){
								$singleexams = 0.00;
								if($single_exams->fud_qualifiaction_name == $access_id){
									$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fud_qualifiaction_name);
									if($adv_qu_set->aquali_category == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_marks;
									}elseif($adv_qu_set->aquali_category == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fud_percentmark_ck) / (100));
									}elseif($adv_qu_set->aquali_category == "Slab"){
										$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$iset = 0;
										foreach($adv_qdetail_list as $keys=>$qdetail){
											if($keys == 0){
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}
											}else{
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}	
											}
											$iset = $qdetail->aq_detail_score_lvl;
										}
									}
									$totalscore = $totalscore + $singleexams;
									if($adv_qu_set->aquali_attempt != "No" && $single_exams->fud_is_attempt == "Yes"){
										$singleexams = 0.00;
										if($adv_qu_set->aquali_attempt == "Full"){
											$singleexams = (float)$adv_qu_set->aquali_fullpercent;
										}elseif($adv_qu_set->aquali_attempt == "Percent"){
											$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
										}elseif($adv_qu_set->aquali_attempt == "Slab"){
											$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
											$jset = 0;
											//$dedcount = count((array)$adv_deduction_list);
											foreach($adv_deduction_list as $keys=>$ded_detail){
												if($keys == 0){
													if($single_exams->fud_attempt_no > 0 && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}else{
													if($single_exams->fud_attempt_no > $jset && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}
												$jset = $ded_detail->aq_deduct_lvl;
											}
										}
										$totalscore = $totalscore - $singleexams;	
									}
									break;
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}
						elseif($access_no == "fu_has_es_service"){
							if($adv_no->fu_has_service == "Yes"){
								//$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								$masterexp_arr = array();
								//$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Essential" && $qs->aexpr_name == $access_id){
										if($keys == 0){
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}else{
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}
									}
								}
								$cand_ess_muster_array = array();
								//$cand_des_muster_array = array();
								$ii = $jj = 0;
								for($ii = 0;$ii < count($masterexp_arr);$ii++){
									$cand_sub_array = array(
										'exp_id' => $masterexp_arr[$ii][0]['exp_mainid'],
										'exp_name' => $masterexp_arr[$ii][0]['expname'],
										'exp_reach' => 0
									);
									foreach($essen_exp_details as $escan_sets){
										for($jj = 0;$jj < count($masterexp_arr[$ii]);$jj++){
											if($escan_sets->fues_exp_workname == $masterexp_arr[$ii][$jj]['expname'] && $escan_sets->fues_exp_approval == "Approved"){
												$totalmonth = ($escan_sets->fues_exp_yr_ck * 12) + $escan_sets->fues_exp_mth_ck;
												$cand_sub_array['exp_reach'] = $cand_sub_array['exp_reach'] + $totalmonth;
												//break;
											}
										}
									}
									$cand_ess_muster_array[] = $cand_sub_array;
								}

								for($ii = 0;$ii < count($cand_ess_muster_array);$ii++){
									$single_exps = 0.00;
									if($cand_ess_muster_array[$ii]['exp_name'] == $access_id){
										$total_gov_exp = $cand_ess_muster_array[$ii]['exp_reach'];
										$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_ess_muster_array[$ii]['exp_id']))->row();
										if($expr_sets->aexpr_category == "Full"){
											if($total_gov_exp >= $expr_sets->aexpr_min_month){
												$single_exps = $expr_sets->aexpr_marks;
											}
										}elseif($expr_sets->aexpr_category == "Slab"){
											$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
											$iset = 0;
											//$itype = '';
											foreach($expdetail_list as $keys=>$exdetail_sets){
												if($keys == 0){
													if($exdetail_sets->ae_range_words == "UPTO"){
														if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}elseif($exdetail_sets->ae_range_words == "GT"){
														if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}
												}else{
													if($exdetail_sets->ae_range_words == "UPTO"){
														if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}elseif($exdetail_sets->ae_range_words == "GT"){
														if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}
												}
												//$itype = $exdetail_sets->ae_range_words;
												$iset = $exdetail_sets->ae_detail_month;
											}
										}
										$totalscore = $totalscore + $single_exps;
										break;
									}
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
						elseif($access_no == "fu_has_ds_service"){
							if($adv_no->fu_has_service == "Yes"){
								$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								//$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								//$masterexp_arr = array();
								$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Desirable" && $qs->aexpr_name == $access_id){
										$subset_arr['exp_mainid'] = $qs->aexpr_id;
										$subset_arr['expname'] = $qs->aexpr_name;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										//$subset_arr['exp_reach'] = 0;
										$desire_exp_arr[] = $subset_arr;
									}
								}
								//$cand_ess_muster_array = array();
								$cand_des_muster_array = array();
								$ii = $jj = 0;
								
								if(!empty($exp_details)){
									$ii = 0;
									$cand_des_muster_array = array(
										'exp_id' => $desire_exp_arr[$ii]['exp_mainid'],
										'exp_name' => $desire_exp_arr[$ii]['expname'],
										'exp_reach' => 0
									);
									for($ii = 0;$ii < count($desire_exp_arr);$ii++){
										foreach($exp_details as $des_sets){
											if($des_sets->fu_exp_workname == $desire_exp_arr[$ii]['expname'] && $des_sets->fu_exp_approval == "Approved"){
												$totalmonth = ($des_sets->fu_exp_yr_ck * 12) + $des_sets->fu_exp_mth_ck;
												$cand_des_muster_array['exp_reach'] = $cand_des_muster_array['exp_reach'] + $totalmonth;
												//break;
											}
										}
									}

									$single_exps = 0.00;
									$total_gov_exp = $cand_des_muster_array['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_des_muster_array['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
					}
					$row_arr['chk_got_marks'] = $totalscore;
					//Point Distributions End
					//exit;
					if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no, $access_id) == TRUE){
						$rowarray = array(
							'chklog_app_no' => $app_no,
							'chklog_type' => $access_no,
							'chklog_type_id' => $access_id,
							'chklog_user' => $this->session->userdata('uid'),
							'chklog_approval' => $app_status,
							'chklog_msg' => trim($app_comment),
							'chklog_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->update_adminChecker_user_log($rowarray);
						if($app_status == "Approved" || $app_status == "Rejected"){
							$this->check_chk3_Candidate_Existing_forFinal($app_no);
						}
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>''));
					}

				}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withSKIP($app_no, $utypes, $access_no, $access_id) == TRUE){

					$row_arr = array(
						'chk_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk_comments' => trim($app_comment),
						'chk_appro_date' => date('Y-m-d H:i:s')
					);
					if($app_status == "Approved" || $app_status == "Rejected"){
						$row_arr['chk2_approve'] = $app_status;
						$row_arr['chk2_comments'] = trim($app_comment);
						$row_arr['chk2_appro_date'] = date('Y-m-d H:i:s');
						$row_arr['chk2_appro_by'] = $this->session->userdata('uid');
					}
					//Point Distributions Start
					$totalscore = 0.00;
					if(($access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service") && $app_status == "Approved"){
						$adv_no = $this->db->get_where('f_user_views',array('f_application_no'=>$app_no,'fu_final_submit'=>1))->row();
						
						if($access_no == "fu_es_qualification"){
							$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							//$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							foreach($quali_details as $single_exams){
								$singleexams = 0.00;
								if($single_exams->fu_qualifiaction_name == $access_id){
									$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fu_qualifiaction_name);
									if($adv_qu_set->aquali_category == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_marks;
									}elseif($adv_qu_set->aquali_category == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fu_percentmark_ck) / (100));
									}elseif($adv_qu_set->aquali_category == "Slab"){
										$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$iset = 0;
										foreach($adv_qdetail_list as $keys=>$qdetail){
											if($keys == 0){
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fu_percentmark_ck > 0 && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}
											}else{
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fu_percentmark_ck >= $iset && $single_exams->fu_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}	
											}
											$iset = $qdetail->aq_detail_score_lvl;
										}
									}
									$totalscore = $totalscore + $singleexams;
									if($adv_qu_set->aquali_attempt != "No" && $single_exams->fu_is_attempt == "Yes"){
										$singleexams = 0.00;
										if($adv_qu_set->aquali_attempt == "Full"){
											$singleexams = (float)$adv_qu_set->aquali_fullpercent;
										}elseif($adv_qu_set->aquali_attempt == "Percent"){
											$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
										}elseif($adv_qu_set->aquali_attempt == "Slab"){
											$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
											$jset = 0;
											//$dedcount = count((array)$adv_deduction_list);
											foreach($adv_deduction_list as $keys=>$ded_detail){
												if($keys == 0){
													if($single_exams->fu_attempt_no > 0 && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}else{
													if($single_exams->fu_attempt_no > $jset && $single_exams->fu_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}
												$jset = $ded_detail->aq_deduct_lvl;
											}
										}
										$totalscore = $totalscore - $singleexams;	
									}
									break;
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}
						elseif($access_no == "fu_ds_qualification"){
							//$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
							$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
							
							foreach($des_quali_details as $single_exams){
								$singleexams = 0.00;
								if($single_exams->fud_qualifiaction_name == $access_id){
									$adv_qu_set = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no->f_applied_for, $single_exams->fud_qualifiaction_name);
									if($adv_qu_set->aquali_category == "Full"){
										$singleexams = (float)$adv_qu_set->aquali_marks;
									}elseif($adv_qu_set->aquali_category == "Percent"){
										$singleexams = (($adv_qu_set->aquali_marks * $single_exams->fud_percentmark_ck) / (100));
									}elseif($adv_qu_set->aquali_category == "Slab"){
										$adv_qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
										$iset = 0;
										foreach($adv_qdetail_list as $keys=>$qdetail){
											if($keys == 0){
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fud_percentmark_ck > 0 && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}
											}else{
												if($qdetail->aq_detail_score_lvl != 100){
													if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck < $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}
												}else{
													if($single_exams->fud_percentmark_ck >= $iset && $single_exams->fud_percentmark_ck <= $qdetail->aq_detail_score_lvl){
														$singleexams = (float)$qdetail->aq_detail_score_mark;
														break;
													}	
												}	
											}
											$iset = $qdetail->aq_detail_score_lvl;
										}
									}
									$totalscore = $totalscore + $singleexams;
									if($adv_qu_set->aquali_attempt != "No" && $single_exams->fud_is_attempt == "Yes"){
										$singleexams = 0.00;
										if($adv_qu_set->aquali_attempt == "Full"){
											$singleexams = (float)$adv_qu_set->aquali_fullpercent;
										}elseif($adv_qu_set->aquali_attempt == "Percent"){
											$singleexams = (($adv_qu_set->aquali_marks * $adv_qu_set->aquali_fullpercent) / (100));
										}elseif($adv_qu_set->aquali_attempt == "Slab"){
											$adv_deduction_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no->f_applied_for, $adv_qu_set->aquali_id);
											$jset = 0;
											//$dedcount = count((array)$adv_deduction_list);
											foreach($adv_deduction_list as $keys=>$ded_detail){
												if($keys == 0){
													if($single_exams->fud_attempt_no > 0 && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}else{
													if($single_exams->fud_attempt_no > $jset && $single_exams->fud_attempt_no <= $ded_detail->aq_deduct_lvl){
														$singleexams = (float)$ded_detail->aq_deduct_mark;
														break;
													}	
												}
												$jset = $ded_detail->aq_deduct_lvl;
											}
										}
										$totalscore = $totalscore - $singleexams;	
									}
									break;
								}
							}
							if($totalscore < 0){
								$totalscore = 0.00;
							}else{
								$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
								if($totalscore > $advdetails->amark_academic){
									$totalscore = (float)$advdetails->amark_academic;
								}
							}
						}
						elseif($access_no == "fu_has_es_service"){
							if($adv_no->fu_has_service == "Yes"){
								//$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								$masterexp_arr = array();
								//$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Essential" && $qs->aexpr_name == $access_id){
										if($keys == 0){
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}else{
											$subset_arr['exp_mainid'] = $qs->aexpr_id;
											$subset_arr['expname'] = $qs->aexpr_name;
											$subset_arr['exp_min'] = $qs->aexpr_min_month;
											//$subset_arr['exp_reach'] = 0;
											$masterexp_arr[$iset][$jset] = $subset_arr;
											if($qs->aexpr_relation == "AND"){
												$iset++;
												$jset = 0;
											}elseif($qs->aexpr_relation == "OR"){
												$jset++;
											}
										}
									}
								}
								$cand_ess_muster_array = array();
								//$cand_des_muster_array = array();
								$ii = $jj = 0;
								for($ii = 0;$ii < count($masterexp_arr);$ii++){
									$cand_sub_array = array(
										'exp_id' => $masterexp_arr[$ii][0]['exp_mainid'],
										'exp_name' => $masterexp_arr[$ii][0]['expname'],
										'exp_reach' => 0
									);
									foreach($essen_exp_details as $escan_sets){
										for($jj = 0;$jj < count($masterexp_arr[$ii]);$jj++){
											if($escan_sets->fues_exp_workname == $masterexp_arr[$ii][$jj]['expname'] && $escan_sets->fues_exp_approval == "Approved"){
												$totalmonth = ($escan_sets->fues_exp_yr_ck * 12) + $escan_sets->fues_exp_mth_ck;
												$cand_sub_array['exp_reach'] = $cand_sub_array['exp_reach'] + $totalmonth;
												//break;
											}
										}
									}
									$cand_ess_muster_array[] = $cand_sub_array;
								}

								for($ii = 0;$ii < count($cand_ess_muster_array);$ii++){
									$single_exps = 0.00;
									if($cand_ess_muster_array[$ii]['exp_name'] == $access_id){
										$total_gov_exp = $cand_ess_muster_array[$ii]['exp_reach'];
										$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_ess_muster_array[$ii]['exp_id']))->row();
										if($expr_sets->aexpr_category == "Full"){
											if($total_gov_exp >= $expr_sets->aexpr_min_month){
												$single_exps = $expr_sets->aexpr_marks;
											}
										}elseif($expr_sets->aexpr_category == "Slab"){
											$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
											$iset = 0;
											//$itype = '';
											foreach($expdetail_list as $keys=>$exdetail_sets){
												if($keys == 0){
													if($exdetail_sets->ae_range_words == "UPTO"){
														if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}elseif($exdetail_sets->ae_range_words == "GT"){
														if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}
												}else{
													if($exdetail_sets->ae_range_words == "UPTO"){
														if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}elseif($exdetail_sets->ae_range_words == "GT"){
														if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
															$single_exps = $exdetail_sets->ae_detail_mark;
															break;
														}
													}
												}
												//$itype = $exdetail_sets->ae_range_words;
												$iset = $exdetail_sets->ae_detail_month;
											}
										}
										$totalscore = $totalscore + $single_exps;
										break;
									}
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
						elseif($access_no == "fu_has_ds_service"){
							if($adv_no->fu_has_service == "Yes"){
								$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
								//$essen_exp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
								$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no->f_applied_for);
								$total_gov_exp = 0;
								
								//$masterexp_arr = array();
								$desire_exp_arr = array();
								$iset = $jset = 0;
								foreach($exp_list as $keys=>$qs){
									$subset_arr = array();
									if($qs->aexpr_type == "Desirable" && $qs->aexpr_name == $access_id){
										$subset_arr['exp_mainid'] = $qs->aexpr_id;
										$subset_arr['expname'] = $qs->aexpr_name;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										//$subset_arr['exp_reach'] = 0;
										$desire_exp_arr[] = $subset_arr;
									}
								}
								//$cand_ess_muster_array = array();
								$cand_des_muster_array = array();
								$ii = $jj = 0;
								
								if(!empty($exp_details)){
									$ii = 0;
									$cand_des_muster_array = array(
										'exp_id' => $desire_exp_arr[$ii]['exp_mainid'],
										'exp_name' => $desire_exp_arr[$ii]['expname'],
										'exp_reach' => 0
									);
									for($ii = 0;$ii < count($desire_exp_arr);$ii++){
										foreach($exp_details as $des_sets){
											if($des_sets->fu_exp_workname == $desire_exp_arr[$ii]['expname'] && $des_sets->fu_exp_approval == "Approved"){
												$totalmonth = ($des_sets->fu_exp_yr_ck * 12) + $des_sets->fu_exp_mth_ck;
												$cand_des_muster_array['exp_reach'] = $cand_des_muster_array['exp_reach'] + $totalmonth;
												//break;
											}
										}
									}

									$single_exps = 0.00;
									$total_gov_exp = $cand_des_muster_array['exp_reach'];
									$expr_sets = $this->db->get_where('advertisement_experience',array('aexpr_id'=>$cand_des_muster_array['exp_id']))->row();
									if($expr_sets->aexpr_category == "Full"){
										if($total_gov_exp >= $expr_sets->aexpr_min_month){
											$single_exps = $expr_sets->aexpr_marks;
										}
									}elseif($expr_sets->aexpr_category == "Slab"){
										$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no->f_applied_for, $expr_sets->aexpr_id);
										$iset = 0;
										//$itype = '';
										foreach($expdetail_list as $keys=>$exdetail_sets){
											if($keys == 0){
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $expr_sets->aexpr_min_month || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}else{
												if($exdetail_sets->ae_range_words == "UPTO"){
													if($total_gov_exp >= $iset && $total_gov_exp < $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}elseif($exdetail_sets->ae_range_words == "GT"){
													if($total_gov_exp >= $iset || $total_gov_exp >= $exdetail_sets->ae_detail_month){
														$single_exps = $exdetail_sets->ae_detail_mark;
														break;
													}
												}
											}
											//$itype = $exdetail_sets->ae_range_words;
											$iset = $exdetail_sets->ae_detail_month;
										}
									}
									$totalscore = $totalscore + $single_exps;
								}
								
								if($totalscore < 0){
									$totalscore = 0.00;
								}else{
									$advdetails = $this->db->get_where('advertisement_marks',array('amark_adv_master'=>$adv_no->f_applied_for))->row();
									if($totalscore > $advdetails->amark_experience){
										$totalscore = (float)$advdetails->amark_experience;
									}
								}
								//print_r($totalscore);exit;
							}
						}
					}
					$row_arr['chk_got_marks'] = $totalscore;
					//Point Distributions End
					//exit;
					if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no, $access_id) == TRUE){
						$rowarray = array(
							'chklog_app_no' => $app_no,
							'chklog_type' => $access_no,
							'chklog_type_id' => $access_id,
							'chklog_user' => $this->session->userdata('uid'),
							'chklog_approval' => $app_status,
							'chklog_msg' => trim($app_comment),
							'chklog_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->update_adminChecker_user_log($rowarray);
						if($app_status == "Approved" || $app_status == "Rejected"){
							$this->check_chk3_Candidate_Existing_forFinal($app_no);
						}
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>''));
					}
				
				}else{
					echo json_encode(array('msg'=>2, 'e_msg'=>'Already Action is taken by Other Checker.'));
				}
				
            }else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}

	public function checking_chk3_nextsearch_update(){
		if($_POST){
			$app_no = $this->input->post('app_no');
            $access_no = $this->input->post('access_no');
			$access_id = $this->input->post('access_id');
            $app_status = $this->input->post('app_status');
            
			$this->form_validation->set_rules('app_no', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('access_no', 'Access Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('app_status', 'Application Status', 'trim|required|alpha');
			if($access_no == "fu_age_relax" || $access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service"){
				$this->form_validation->set_rules('access_id', 'Application Type ID', 'trim|required');
			}
			if($this->form_validation->run() == TRUE){
				if($app_status == "NextSearch"){
					if($access_no == "fu_age_relax" || $access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service"){
						$get_chk_details = $this->db->where('chk_user_application',$app_no)->where('chk_type',$access_no)->where('chk_sub_typeid',$access_id)->where('chk_approve is NULL')->where('chk_createby',$this->session->userdata('uid'))->get('checking_tab')->row();
					}else{
						$get_chk_details = $this->db->where('chk_user_application',$app_no)->where('chk_type',$access_no)->where('chk_approve is NULL')->where('chk_createby',$this->session->userdata('uid'))->get('checking_tab')->row();
					}
					if(count((array)$get_chk_details) > 0){
						if($this->db->delete('checking_tab', array('chk_id' => $get_chk_details->chk_id))){
							echo json_encode(array('msg'=>1, 's_msg'=>""));
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>"Checking Data not deleted properly, Try Again."));
						}
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>"Checking Data not found, Try Again."));
					}
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>"Proper Data not found, Try Again."));
				}
			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	protected function check_chk3_Candidate_Existing_forFinal($application_no){
		$cand_alldetails = $this->candidates_m->GetDetailsofCandidate_Application($application_no);
		$allaccess = $this->data['ssstr_arr'];
		$masterupdation_arr = array();
		for($icnt = 0; $icnt < count($allaccess); $icnt++){
			if($allaccess[$icnt] == "fu_dob"){
				$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
				if(count((array)$resdetail) > 0){
					if($resdetail->chk_final_state == 'Approved'){
						$masterupdation_arr['fu_dob_check'] = "Approved";
					}elseif($resdetail->chk_final_state == 'Rejected'){
						$masterupdation_arr['fu_dob_check'] = "Rejected";
					}
				}
			}elseif($allaccess[$icnt] == "fu_address"){
				$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
				if(count((array)$resdetail) > 0){
					if($resdetail->chk_final_state == 'Approved'){
						$masterupdation_arr['fu_address_check'] = "Approved";
					}elseif($resdetail->chk_final_state == 'Rejected'){
						$masterupdation_arr['fu_address_check'] = "Rejected";
					}
				}
			}elseif($allaccess[$icnt] == "fu_photo_doc"){
				$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
				if(count((array)$resdetail) > 0){
					if($resdetail->chk_final_state == 'Approved'){
						$masterupdation_arr['fu_photo_check'] = "Approved";
					}elseif($resdetail->chk_final_state == 'Rejected'){
						$masterupdation_arr['fu_photo_check'] = "Rejected";
					}
				}
			}elseif($allaccess[$icnt] == "fu_signature_doc"){
				$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
				if(count((array)$resdetail) > 0){
					if($resdetail->chk_final_state == 'Approved'){
						$masterupdation_arr['fu_signature_check'] = "Approved";
					}elseif($resdetail->chk_final_state == 'Rejected'){
						$masterupdation_arr['fu_signature_check'] = "Rejected";
					}
				}
			}elseif($allaccess[$icnt] == "fu_caste"){
				if($cand_alldetails->fu_caste_type == 1){
					$masterupdation_arr['fu_caste_check'] = "NotApplicable";
				}else{
					$castetype_details = $this->db->get_where('caste_tab',array('caste_id'=>$cand_alldetails->fu_caste_type))->row();
					if($castetype_details->caste_cat == 2){
						$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
						if(count((array)$resdetail) > 0){
							if($resdetail->chk_final_state == 'Approved'){
								$masterupdation_arr['fu_caste_check'] = "Approved";
							}elseif($resdetail->chk_final_state == 'Rejected'){
								$masterupdation_arr['fu_caste_check'] = "Rejected";
							}
						}
					}else{
						$masterupdation_arr['fu_caste_check'] = "NotApplicable";
					}
				}
			}elseif($allaccess[$icnt] == "fu_pwd"){
				if($cand_alldetails->fu_pwd == "No"){
					$masterupdation_arr['fu_pwd_check'] = "NotApplicable";
				}elseif($cand_alldetails->fu_pwd == "Yes"){
					$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
					if(count((array)$resdetail) > 0){
						if($resdetail->chk_final_state == 'Approved'){
							$masterupdation_arr['fu_pwd_check'] = "Approved";
						}elseif($resdetail->chk_final_state == 'Rejected'){
							$masterupdation_arr['fu_pwd_check'] = "Rejected";
						}
					}
				}
			}elseif($allaccess[$icnt] == "fu_exempted"){
				//if($cand_alldetails->adv_has_exampted == "Yes"){
					if($cand_alldetails->fu_exempted == "No" || $cand_alldetails->fu_exempted == NULL){
						$masterupdation_arr['fu_exempted_check'] = "NotApplicable";
					}elseif($cand_alldetails->fu_exempted == "Yes"){
						$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
						if(count((array)$resdetail) > 0){
							if($resdetail->chk_final_state == 'Approved'){
								$masterupdation_arr['fu_exempted_check'] = "Approved";
							}elseif($resdetail->chk_final_state == 'Rejected'){
								$masterupdation_arr['fu_exempted_check'] = "Rejected";
							}
						}
					}
				/*}else{
					$masterupdation_arr['fu_exempted_check'] = "NotApplicable";
				}*/
			}elseif($allaccess[$icnt] == "fu_exservice"){
				//if($cand_alldetails->adv_has_exservice == "Yes"){
					if($cand_alldetails->fu_exservice == "No" || $cand_alldetails->fu_exservice == NULL){
						$masterupdation_arr['fu_exservice_check'] = "NotApplicable";
					}elseif($cand_alldetails->fu_exservice == "Yes"){
						$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
						if(count((array)$resdetail) > 0){
							if($resdetail->chk_final_state == 'Approved'){
								$masterupdation_arr['fu_exservice_check'] = "Approved";
							}elseif($resdetail->chk_final_state == 'Rejected'){
								$masterupdation_arr['fu_exservice_check'] = "Rejected";
							}
						}
					}
				/*}else{
					$masterupdation_arr['fu_exservice_check'] = "NotApplicable";
				}*/
			}elseif($allaccess[$icnt] == "fu_ews"){
				//if($cand_alldetails->adv_has_ews == "Yes"){
					if($cand_alldetails->fu_ews == "No" || $cand_alldetails->fu_ews == NULL){
						$masterupdation_arr['fu_ews_check'] = "NotApplicable";
					}elseif($cand_alldetails->fu_ews == "Yes"){
						$resdetail = $this->candidates_m->getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $allaccess[$icnt]);
						if(count((array)$resdetail) > 0){
							if($resdetail->chk_final_state == 'Approved'){
								$masterupdation_arr['fu_ews_check'] = "Approved";
							}elseif($resdetail->chk_final_state == 'Rejected'){
								$masterupdation_arr['fu_ews_check'] = "Rejected";
							}
						}
					}
				/*}else{
					$masterupdation_arr['fu_ews_check'] = "NotApplicable";
				}*/
			}elseif($allaccess[$icnt] == "fu_age_relax"){
				$resultage_adv_details = $this->candidates_m->gatAll_Special_subscriptionAge_list($cand_alldetails->f_applied_for);
				if(count((array)$resultage_adv_details) > 0){
					$resYes_detail = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($application_no, "Yes");
					$resdetail = $this->candidates_m->getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $allaccess[$icnt]);
					if(count((array)$resYes_detail) == count((array)$resdetail)){
						$masterupdation_arr['fu_age_relax_check'] = "Yes";
					}
				}else{
					$masterupdation_arr['fu_age_relax_check'] = "Yes";
				}
				
			}elseif($allaccess[$icnt] == "fu_es_qualification"){
				$resdetail = $this->candidates_m->getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $allaccess[$icnt]);
				$candesqualiss = $this->db->get_where('f_user_qualification',array('fu_quali_masteruser'=>$cand_alldetails->f_uid))->result();
				if(count((array)$resdetail) == count((array)$candesqualiss)){
					$masterupdation_arr['fu_es_qualification_check'] = "Yes";
				}
			}elseif($allaccess[$icnt] == "fu_ds_qualification"){
				$resdetail = $this->candidates_m->getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $allaccess[$icnt]);
				$candqualiss = $this->db->get_where('f_user_des_qualification',array('fud_quali_masteruser'=>$cand_alldetails->f_uid))->result();
				if(count((array)$resdetail) == count((array)$candqualiss)){
					$masterupdation_arr['fu_ds_qualification_check'] = "Yes";
				}
			}elseif($allaccess[$icnt] == "fu_has_es_service"){
				if($cand_alldetails->adv_has_experience == "Yes" && $cand_alldetails->fu_has_service == "Yes"){
					$resdetail = $this->candidates_m->getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $allaccess[$icnt]);
					$cand_esExpss = $this->candidates_m->getDetailsof_Es_Experience_ofCandidate_Application($cand_alldetails->f_application_no);
					//if(count((array)$resdetail) == $cand_alldetails->adv_experience_no){
					if(count((array)$resdetail) == count((array)$cand_esExpss)){
						$masterupdation_arr['fu_es_service_check'] = "Yes";
					}
				}else{
					$masterupdation_arr['fu_es_service_check'] = "Yes";
				}
			}elseif($allaccess[$icnt] == "fu_has_ds_service"){
				if($cand_alldetails->adv_has_experience == "Yes" && $cand_alldetails->fu_has_service == "Yes"){
					$resdetail = $this->candidates_m->getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $allaccess[$icnt]);
					//$canddeExpss = $this->db->get_where('f_user_experience',array('fu_exp_masteruser'=>$cand_alldetails->f_uid))->result();
					$canddeExpss = $this->candidates_m->getDetailsof_De_Experience_ofCandidate_Application($cand_alldetails->f_application_no);
					if(count((array)$resdetail) == count((array)$canddeExpss)){
						$masterupdation_arr['fu_ds_service_check'] = "Yes";
					}
				}else{
					$masterupdation_arr['fu_ds_service_check'] = "Yes";
				}
			}
		}
		//print_r($cand_alldetails);exit;
		$this->candidates_m->setUpdate_ResultCandidate_Appliwise($masterupdation_arr, $application_no);		
	}


}
