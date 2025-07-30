<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Candidates extends Admin_Controller {
	
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
		redirect('admincontrol/candidates/comp_application_list');
    }
	
	public function comp_application_list(){
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
				$this->data['appli_list'] = $this->candidates_m->GetDetailsofCandidate_Application_v2(NULL, $advno);
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/complete_application_list', $this->data);
	}

	public function comp_pagewise_application_list(){
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
				$this->data['appli_list'] = $this->candidates_m->GetDetailsofCandidate_Application_v3($advno, 0, $pa_search);
			else
				$this->data['appli_list'] = $this->candidates_m->GetDetailsofCandidate_Application_v3($advno, $page, $pa_search);

			if(empty($pa_search)){
				$config['base_url'] = base_url('admincontrol/candidates/comp_pagewise_application_list?rf_set='.$rf_set.'&advno='.$advno);
				$config['total_rows'] = $this->candidates_m->count_Alladvwise_Candidate($advno);
			}else{
				$config['base_url'] = base_url('admincontrol/candidates/comp_pagewise_application_list?rf_set='.$rf_set.'&advno='.$advno.'&pa_search='.$pa_search);
				$config['total_rows'] = $this->candidates_m->count_Alladvwise_Candidate($advno, $pa_search);
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
		$this->load->view('admin/candidate/complete_pagewise_application_list', $this->data);
	}

	public function candidate_dateofbirth_modifcation($candno){
		if($candno == NULL || $candno == ""){
			redirect('default404');
		}
		$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candno);
		//$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		
		$this->load->view('admin/candidate/candidate_dob_view', $this->data);
	}

	public function cand_dobset_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
            $age_dob = $this->input->post('age_dob');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('age_dob', 'Date of Birth', 'trim|required');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				
				if (count((array)$userdetails) > 0) {
				
					//print_r($_FILES);exit;
					$this->load->model('main_m');
					$this->load->model('member_m');
					$adv_detail = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($userdetails->f_applied_for);
					$existing_limit_update = $adv_detail->adv_age_limit;
					$getall_ageset = $this->member_m->gatAll_subscriptionAge_list($userdetails->f_applied_for);
					if(count((array)$getall_ageset) > 0){
						
						//$castelists = $this->db->get_where('caste_tab',array('caste_cat'=>2))->result();
						$castelists = $this->db->where('caste_status',1)->where('caste_id != ',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
						$getextraageset = $this->member_m->getAll_Existing_ExtraAgeSets_All_forAdmin($userdetails->f_uid);
						$castearray = array();
						foreach($castelists as $castesets){
							$castearray[] = $castesets->caste_id;
						}
						$agearray = (array)$getall_ageset;
						$totalage_increment = 0;
						$casteincrement = 0;
						$pwdincrement = 0;
						$expincrement = 0;
						$pwdtype = $exptype = $ocaste = '';
						$prv = $cur = '';
						$catcheck = '';

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
								//$prv = $agearray[$dd - 1]->advage_type;
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
								if($agearray[$dd]->advage_section == $userdetails->fu_caste_type){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0,$stringmix);
								}
							}
							if($agearray[$dd]->advage_section == 7){
								if($userdetails->fu_pwd == "Yes"){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
								}	
							}
							if($agearray[$dd]->advage_section == 8){
								if($userdetails->fu_exempted == "Yes"){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
								}	
							}
							if($agearray[$dd]->advage_section == 9){
								if($userdetails->fu_exservice == "Yes"){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
								}	
							}
							if($agearray[$dd]->advage_section == 10){
								if($userdetails->fu_ews == "Yes"){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
								}	
							}
							/*if($agearray[$dd]->advage_section == 11){
								if($fu_has_service == "Yes"){
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
								}else{
									$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
								}	
							}*/
							if($agearray[$dd]->advage_section > 10 && $agearray[$dd]->caste_cat == 8){
								foreach($getextraageset as $agesets){
									if($agesets->fu_ext_ageid == $agearray[$dd]->advage_section){
										if($agesets->fu_ext_answer == "Yes"){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
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
							$maxnumber_find = (int)max($mixsub_array);
							$totalage_increment = $totalage_increment + $maxnumber_find;
						}
						//print_r($totalage_increment);
						//exit;

						if($adv_detail->adv_age_updown > 0){
							if($totalage_increment > $adv_detail->adv_age_updown){
								$totalage_increment = $adv_detail->adv_age_updown;
							}
						}
						if($totalage_increment > 0){
							$existing_limit_update = date('Y-m-d', strtotime($adv_detail->adv_age_limit. ' -'.$totalage_increment.' years'));
						}
					}

					$age_dob = date('Y-m-d',strtotime($age_dob));
					if($adv_detail->adv_min_age_limit >= $age_dob && $existing_limit_update <= $age_dob){
						//echo "Reached DOB OK";
						//////////////////////////
						$row_arr = array(
							'fu_dob' => $age_dob
						);
						if ($this->candidates_m->update_frontuser_details_modified($row_arr, $userdetails->f_uid) == TRUE) {
							echo json_encode(array('msg' => 1));
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
						}
						//////////////////////////
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => 'DOB is Mismatch, check Again.'));
					}
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing, Try again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function candidate_qualification_replacing($candno){
		if($candno == NULL || $candno == ""){
			redirect('default404');
		}
		$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candno);
		$this->data['quali_list'] = $this->candidates_m->GetDetail_Qualification_for_Application($candno);
		$this->data['des_quali_list'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($candno);
		$this->data['exp_detail_list'] = $this->candidates_m->GetDetail_Experience_for_Application($candno);
		$this->data['essenexp_detail_list'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($candno);
		$this->load->model('main_m');
		$this->data['adv_detail'] = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($appdetail->f_applied_for);
		$this->load->model('member_m');
		$allquali_list = $this->member_m->getAll_qualification_exam($appdetail->f_applied_for);
		$masterset_arr = array();
		$desire_quali_arr = array();
		$iset = $jset = 0;
		$pset = $qset = 0;
		foreach($allquali_list as $keys=>$qs){
			$subset_arr = array();
			if($qs->aquali_examtype == "Essential"){
				if($keys == 0){
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					//$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$masterset_arr[$iset][$jset] = $subset_arr;
					if($qs->aquali_relation == "AND"){
						$iset++;
						$jset = 0;
					}elseif($qs->aquali_relation == "OR"){
						$jset++;
					}
				}else{
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					//$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$masterset_arr[$iset][$jset] = $subset_arr;
					if($qs->aquali_relation == "AND"){
						$iset++;
						$jset = 0;
					}elseif($qs->aquali_relation == "OR"){
						$jset++;
					}
				}
			}elseif($qs->aquali_examtype == "Desirable"){
				/*$subset_arr['qm_name'] = $qs->qm_name;
				$subset_arr['aquali_exam'] = $qs->aquali_exam;
				$subset_arr['aquali_marks'] = $qs->aquali_marks;
				//$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
				$desire_quali_arr[] = $subset_arr;*/
				if($keys == 0){
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					//$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$desire_quali_arr[$pset][$qset] = $subset_arr;
					if($qs->aquali_relation == "AND"){
						$pset++;
						$qset = 0;
					}elseif($qs->aquali_relation == "OR"){
						$qset++;
					}
				}else{
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					//$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$desire_quali_arr[$pset][$qset] = $subset_arr;
					if($qs->aquali_relation == "AND"){
						$pset++;
						$qset = 0;
					}elseif($qs->aquali_relation == "OR"){
						$qset++;
					}
				}
			}
		}
		$this->data['quali_exam'] = $masterset_arr;
		$this->data['desire_quali_exam'] = $desire_quali_arr;
		$allexp_list = $this->member_m->getAll_Experience_section($appdetail->f_applied_for);
		$masterexp_arr = array();
		$desire_exp_arr = array();
		$iset = $jset = 0;
		$pset = $qset = 0;
		foreach($allexp_list as $keys=>$qs){
			$subset_arr = array();
			if($qs->aexpr_type == "Essential"){
				if($keys == 0){
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					//$subset_arr['exp_marks'] = $qs->aexpr_marks;
					//$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$masterexp_arr[$iset][$jset] = $subset_arr;
					if($qs->aexpr_relation == "AND"){
						$iset++;
						$jset = 0;
					}elseif($qs->aexpr_relation == "OR"){
						$jset++;
					}
				}else{
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					//$subset_arr['exp_marks'] = $qs->aexpr_marks;
					//$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$masterexp_arr[$iset][$jset] = $subset_arr;
					if($qs->aexpr_relation == "AND"){
						$iset++;
						$jset = 0;
					}elseif($qs->aexpr_relation == "OR"){
						$jset++;
					}
				}
			}elseif($qs->aexpr_type == "Desirable"){
				/*$subset_arr['exp_name'] = $qs->expset_name;
				$subset_arr['expid'] = $qs->aexpr_name;
				//$subset_arr['exp_marks'] = $qs->aexpr_marks;
				//$subset_arr['exp_min'] = $qs->aexpr_min_month;
				$desire_exp_arr[] = $subset_arr;*/
				if($keys == 0){
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					//$subset_arr['exp_marks'] = $qs->aexpr_marks;
					//$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$desire_exp_arr[$pset][$qset] = $subset_arr;
					if($qs->aexpr_relation == "AND"){
						$pset++;
						$qset = 0;
					}elseif($qs->aexpr_relation == "OR"){
						$qset++;
					}
				}else{
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					//$subset_arr['exp_marks'] = $qs->aexpr_marks;
					//$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$desire_exp_arr[$pset][$qset] = $subset_arr;
					if($qs->aexpr_relation == "AND"){
						$pset++;
						$qset = 0;
					}elseif($qs->aexpr_relation == "OR"){
						$qset++;
					}
				}
			}
		}
		$this->data['ess_expr'] = $masterexp_arr;
		$this->data['desire_expr'] = $desire_exp_arr;
		//$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		
		$this->load->view('admin/candidate/candidate_swap_qualification_view', $this->data);
	}

	public function cand_qualification_swapping_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
			$total_exam = $this->input->post('total_exam');
			$examid = $this->input->post('examid');
			$exam_name = $this->input->post('exam_name');
            //$main_rename = $this->input->post('main_rename');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
			$this->form_validation->set_rules('total_exam', 'Total Exam', 'trim|required|is_natural_no_zero');
            //$this->form_validation->set_rules('main_rename', 'Full Name', 'trim|required');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				$resdetail = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $main_refid))->row();

				if (count((array)$userdetails) > 0 && $resdetail->cr_approval == "NotChecked") {
				
					$chk_exm_set = 0;
					for($jk = 0; $jk < $total_exam; $jk++){
						if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $examid[$jk] == NULL || $examid[$jk] == ""){
							$chk_exm_set++;
							break;
						}
						if($chk_exm_set == 0){
							$getqualidata = $this->db->get_where('f_user_qualification',array('fu_quali_id'=> $examid[$jk]))->row();
							if(!empty($getqualidata)){
								if($getqualidata->fu_qualifiaction_name != $exam_name[$jk]){
									$row_arr2 = array(
										'fu_qualifiaction_name' => $exam_name[$jk]
									);
									if($this->candidates_m->addmodify_ExamSets_ByChecker($row_arr2, $examid[$jk], "E") == FALSE){
									//if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
										$chk_exm_set++;
										break;
									}else{
										$this->db->delete('checking_tab', array('chk_user_application' => $main_refid, 'chk_type' => 'fu_es_qualification', 'chk_sub_typeid' => $getqualidata->fu_qualifiaction_name));
										$rowarr_sets = array(
											'qes_type' => 'EQ',
											'qes_prev_set' => $getqualidata->fu_qualifiaction_name,
											'qes_new_set' => $exam_name[$jk],
											'qes_createdate' => date('Y-m-d H:i:s'),
											'qes_createby' => $this->session->userdata['uid']
										);
										$this->candidates_m->addmodify_Swip_Creation($rowarr_sets);
									}
								}
							}else{
								$chk_exm_set++;
								break;
							}
						}
					}
					
					if ($chk_exm_set == 0) {
						echo json_encode(array('msg' => 1));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
					}
					//////////////////////////
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing OR Final processing is Done for the Candidate, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function cand_desire_qualification_swapping_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
			$total_exam = $this->input->post('total_exam');
			$examid = $this->input->post('examid');
			$exam_name = $this->input->post('exam_name');
            //$main_rename = $this->input->post('main_rename');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
			$this->form_validation->set_rules('total_exam', 'Total Exam', 'trim|required|is_natural_no_zero');
            //$this->form_validation->set_rules('main_rename', 'Full Name', 'trim|required');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				$resdetail = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $main_refid))->row();

				if (count((array)$userdetails) > 0 && $resdetail->cr_approval == "NotChecked") {
				
					$chk_exm_set = 0;
					for($jk = 0; $jk < $total_exam; $jk++){
						if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $examid[$jk] == NULL || $examid[$jk] == ""){
							$chk_exm_set++;
							break;
						}
						if($chk_exm_set == 0){
							$getqualidata = $this->db->get_where('f_user_des_qualification',array('fud_quali_id'=> $examid[$jk]))->row();
							if(!empty($getqualidata)){
								if($getqualidata->fud_qualifiaction_name != $exam_name[$jk]){
									$row_arr2 = array(
										'fud_qualifiaction_name' => $exam_name[$jk]
									);
									if($this->candidates_m->addmodify_ExamSets_ByChecker($row_arr2, $examid[$jk], "D") == FALSE){
									//if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
										$chk_exm_set++;
										break;
									}else{
										$this->db->delete('checking_tab', array('chk_user_application' => $main_refid, 'chk_type' => 'fu_ds_qualification', 'chk_sub_typeid' => $getqualidata->fud_qualifiaction_name));
										$rowarr_sets = array(
											'qes_type' => 'DQ',
											'qes_prev_set' => $getqualidata->fud_qualifiaction_name,
											'qes_new_set' => $exam_name[$jk],
											'qes_createdate' => date('Y-m-d H:i:s'),
											'qes_createby' => $this->session->userdata['uid']
										);
										$this->candidates_m->addmodify_Swip_Creation($rowarr_sets);
									}
								}
							}else{
								$chk_exm_set++;
								break;
							}
						}
					}
					
					if ($chk_exm_set == 0) {
						echo json_encode(array('msg' => 1));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
					}
					//////////////////////////
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing OR Final processing is Done for the Candidate, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function cand_ess_experience_swapping_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
			$total_exam = $this->input->post('total_exam');
			$examid = $this->input->post('examid');
			$exam_name = $this->input->post('exam_name');
            //$main_rename = $this->input->post('main_rename');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
			$this->form_validation->set_rules('total_exam', 'Total Exam', 'trim|required|is_natural_no_zero');
            //$this->form_validation->set_rules('main_rename', 'Full Name', 'trim|required');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				$resdetail = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $main_refid))->row();

				if (count((array)$userdetails) > 0 && $resdetail->cr_approval == "NotChecked") {
				
					$chk_exm_set = 0;
					for($jk = 0; $jk < $total_exam; $jk++){
						if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $examid[$jk] == NULL || $examid[$jk] == ""){
							$chk_exm_set++;
							break;
						}
						if($chk_exm_set == 0){
							$getqualidata = $this->db->get_where('f_user_ess_experience',array('fues_exp_id'=> $examid[$jk]))->row();
							if(!empty($getqualidata)){
								if($getqualidata->fues_exp_workname != $exam_name[$jk]){
									$row_arr2 = array(
										'fues_exp_workname' => $exam_name[$jk]
									);
									if($this->candidates_m->addmodify_ExperienceSets_ByChecker($row_arr2, $examid[$jk], "E") == FALSE){
									//if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
										$chk_exm_set++;
										break;
									}else{
										$this->db->delete('checking_tab', array('chk_user_application' => $main_refid, 'chk_type' => 'fu_has_es_service', 'chk_sub_typeid' => $getqualidata->fues_exp_workname));
										$rowarr_sets = array(
											'qes_type' => 'ES',
											'qes_prev_set' => $getqualidata->fues_exp_workname,
											'qes_new_set' => $exam_name[$jk],
											'qes_createdate' => date('Y-m-d H:i:s'),
											'qes_createby' => $this->session->userdata['uid']
										);
										$this->candidates_m->addmodify_Swip_Creation($rowarr_sets);
									}
								}
							}else{
								$chk_exm_set++;
								break;
							}
						}
					}
					
					if ($chk_exm_set == 0) {
						echo json_encode(array('msg' => 1));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
					}
					//////////////////////////
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing OR Final processing is Done for the Candidate, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function cand_desire_experience_swapping_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
			$total_exam = $this->input->post('total_exam');
			$examid = $this->input->post('examid');
			$exam_name = $this->input->post('exam_name');
            //$main_rename = $this->input->post('main_rename');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
			$this->form_validation->set_rules('total_exam', 'Total Exam', 'trim|required|is_natural_no_zero');
            //$this->form_validation->set_rules('main_rename', 'Full Name', 'trim|required');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				$resdetail = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $main_refid))->row();

				if (count((array)$userdetails) > 0 && $resdetail->cr_approval == "NotChecked") {
				
					$chk_exm_set = 0;
					for($jk = 0; $jk < $total_exam; $jk++){
						if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $examid[$jk] == NULL || $examid[$jk] == ""){
							$chk_exm_set++;
							break;
						}
						if($chk_exm_set == 0){
							$getqualidata = $this->db->get_where('f_user_experience',array('fu_exp_id'=> $examid[$jk]))->row();
							if(!empty($getqualidata)){
								if($getqualidata->fu_exp_workname != $exam_name[$jk]){
									$row_arr2 = array(
										'fu_exp_workname' => $exam_name[$jk]
									);
									if($this->candidates_m->addmodify_ExperienceSets_ByChecker($row_arr2, $examid[$jk], "D") == FALSE){
									//if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
										$chk_exm_set++;
										break;
									}else{
										$this->db->delete('checking_tab', array('chk_user_application' => $main_refid, 'chk_type' => 'fu_has_ds_service', 'chk_sub_typeid' => $getqualidata->fu_exp_workname));
										$rowarr_sets = array(
											'qes_type' => 'DS',
											'qes_prev_set' => $getqualidata->fu_exp_workname,
											'qes_new_set' => $exam_name[$jk],
											'qes_createdate' => date('Y-m-d H:i:s'),
											'qes_createby' => $this->session->userdata['uid']
										);
										$this->candidates_m->addmodify_Swip_Creation($rowarr_sets);
									}
								}
							}else{
								$chk_exm_set++;
								break;
							}
						}
					}
					
					if ($chk_exm_set == 0) {
						echo json_encode(array('msg' => 1));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
					}
					//////////////////////////
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing OR Final processing is Done for the Candidate, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function candidate_name_modifcation($candno){
		if($candno == NULL || $candno == ""){
			redirect('default404');
		}
		$this->data['fuser_detailset'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candno);
		//$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($candno);
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		
		$this->load->view('admin/candidate/candidate_rename_view', $this->data);
	}

	public function cand_rename_set_submission(){
		if($_POST){
			$main_refid = $this->input->post('main_refid');
            $main_rename = $this->input->post('main_rename');
            $main_mobile = $this->input->post('main_mobile');
            $main_email = $this->input->post('main_email');
            
			$this->form_validation->set_rules('main_refid', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('main_rename', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('main_mobile', 'Mobile', 'trim|required|numeric|exact_length[10]');
            $this->form_validation->set_rules('main_email', 'Email', 'trim|required|valid_email');

			if($this->form_validation->run() == TRUE){
				$userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $main_refid))->row();
				
				if (count((array)$userdetails) > 0) {
				
					$row_arr = array(
						'f_full_name' => $main_rename,
						'f_mobile' => $main_mobile,
						'f_email' => $main_email
					);
					if ($this->candidates_m->update_frontuserName_set_modified($row_arr, $main_refid) == TRUE) {
						echo json_encode(array('msg' => 1));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB updation Problem, Try again.'));
					}
					//////////////////////////
						
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidate Details is missing, Try again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function comp_application_list_v2(){

		if($_POST){
			$fetch_data = $this->candidates_m->make_candidate_list_datatables();  
			$data = array();  
			foreach($fetch_data as $keys=>$rows)
			{  
				$edit_btn = '<a type="submit" class="btn-sm btn-success" href="'.base_url().'admincontrol/holding_files/holding_edit_view/'.$rows->f_application_no.'"><i class="fa fa-fw fa-edit"></i> Edit</a>';
				
				$sub_array = array(
					$keys + 1 + intval($this->input->post("start")),
					$rows->f_application_no,
					$rows->f_mobile,
					$rows->holding_name,
					$rows->f_email,
					$edit_btn
				);  
				$data[] = $sub_array;
			}  
			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $this->candidates_m->get_all_candidate_list_data(),
				"recordsFiltered" => $this->candidates_m->get_filtered_candidate_list_data(),
				"data" => $data
			);
			echo json_encode($output);
		}

	}
	
	public function goto_get_allthe_data_specific(){
		if($_POST){
			$advno = $this->input->post('advno');
            $u_accs = $this->input->post('u_accs');
			if($advno != "" && $u_accs != ""){
				if($u_accs == "fu_age_relax"){
					$result_details = $this->candidates_m->gatAll_Special_subscriptionAge_list($advno);
				}elseif($u_accs == "fu_es_qualification"){
					$result_details = $this->candidates_m->getDetails_Qualification_Advertisement_Wise('Essential',$advno);
				}elseif($u_accs == "fu_ds_qualification"){
					$result_details = $this->candidates_m->getDetails_Qualification_Advertisement_Wise('Desirable',$advno);
				}elseif($u_accs == "fu_has_es_service"){
					$result_details = $this->candidates_m->getDetails_Experience_Advertisement_Wise('Essential',$advno);
				}elseif($u_accs == "fu_has_ds_service"){
					$result_details = $this->candidates_m->getDetails_Experience_Advertisement_Wise('Desirable',$advno);
				}				
				if (count((array)$result_details) > 0) {
					$totalall = '<option value="">---Select---</option>';
					if($u_accs == "fu_es_qualification" || $u_accs == "fu_ds_qualification"){
						foreach ($result_details as $results) {
							$totalall = $totalall . '<option value="' . $results->aquali_exam . '">' . $results->qm_name . '</option>';
						}
					}elseif($u_accs == "fu_has_es_service" || $u_accs == "fu_has_ds_service"){
						foreach ($result_details as $results) {
							$totalall = $totalall . '<option value="' . $results->aexpr_name . '">' . $results->expset_name . '</option>';
						}
					}elseif($u_accs == "fu_age_relax"){
						foreach ($result_details as $results) {
							$totalall = $totalall . '<option value="' . $results->advage_section . '">' . $results->caste_name . '</option>';
						}
					}
					echo json_encode(array('msg' => 1, 'op_set' => $totalall));
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Found, check again.'));
				}
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Field Data Not Found, Check Again.'));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function goto_get_allslaveuser_specific(){
		if($_POST){
			$advno = $this->input->post('advno');
            if($advno != ""){
				$result_details = $this->candidates_m->getDetails_SlaveUser_Advertisement_Wise($advno);				
				if (count((array)$result_details) > 0) {
					$totalall = '<option value="All">All</option>';
					foreach ($result_details as $results) {
						$totalall = $totalall . '<option value="' . $results->u_id . '">' . $results->firstname .' '. $results->lastname .' - '. $results->mu_name . '</option>';
					}
					echo json_encode(array('msg' => 1, 'op_set' => $totalall));
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Found, check again.'));
				}
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Field Data Not Found, Check Again.'));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function candidate_application_details($app_no = NULL){
		if($app_no == NULL){
			redirect('admincontrol/candidates/comp_application_list');
		}
		$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($app_no);
		$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
		$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($app_no);
		$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($app_no);
		$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($app_no);
		$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($app_no);
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
		$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($app_no);
		$this->load->view('admin/candidate/candidate_detail_application', $this->data);
	}
	
	public function holdsss_candidate_app_list(){
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
					redirect('admincontrol/candidates/candidate_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items);
				}
			}
		}
		
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/candidate/candidate_application_list', $this->data);
	}

	public function chktest(){
		
			$arrrset = array(
				'chk_user_application' => 'C061120211110131709',
				'chk_type' => 'fu_address',
				'chk_sub_typeid' => 0
			);
			$chkset = $this->db->insert("checking_tab", $arrrset);
			//print_r($this->db->error());
			if (!$chkset){
				$esets = $this->db->error();
				if($esets['code'] == 1062) {
					echo "go ahead";
				}
			}
		
	}

	public function holdsss_candidate_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL){
			redirect('admincontrol/candidates/candidate_app_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_app_list');
			}
		}
		if($this->admin_m->checkUser_existingAdvertisement_withAccess($advno, $acc_items) == FALSE){
			redirect('admincontrol/candidates/candidate_app_list');
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
				$checker++;
					
			}else{
				$this->data['error'] = "No Data found for Checking.";
			}
		}
		///////////
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/candidate/candidate_nextforward_list', $this->data);
	}

	public function hold234234324324candidate_nextforwad_list($advno = NULL, $acc_items = NULL, $sub_type = NULL){
		if($advno == NULL || $acc_items == NULL){
			redirect('admincontrol/candidates/candidate_app_list');
		}
		if($acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_app_list');
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
		
		
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/candidate/candidate_nextforward_list', $this->data);
	}
	
	public function holdsss_candidate_skipped_list(){
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
					redirect('admincontrol/candidates/candidate_skipforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_skipforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items);
				}
				
			}
		}
		
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//print_r($this->data);exit;
		$this->load->view('admin/candidate/candidate_skip_application_list', $this->data);
	}

	public function holdsss_candidate_skipforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL){
			redirect('admincontrol/candidates/candidate_skipped_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_app_list');
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
		$this->load->view('admin/candidate/candidate_skipforward_list', $this->data);
	}

	public function holdsss_checking_section_update(){
		if($_POST){
			$app_no = $this->input->post('app_no');
            $access_no = $this->input->post('access_no');
			$access_id = $this->input->post('access_id');
            $app_status = $this->input->post('app_status');
            $app_comment = $this->input->post('app_comment');
            
			$this->form_validation->set_rules('app_no', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('access_no', 'Access Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('app_status', 'Application Status', 'trim|required|alpha');
			if($app_status == "Rejected" || $app_status == "Return" || $app_status == "Doubtful" || $app_status == "Skip"){
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
												break;
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
												break;
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
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>''));
					}
				
				}elseif($this->candidates_m->GetDetails_Userwise_Candidate_Application_withReturn($app_no, $utypes, $access_no, $access_id) == TRUE){

					$row_arr = array(
						'chk_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk_comments' => trim($app_comment),
						'chk_appro_date' => date('Y-m-d H:i:s')
					);

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
												break;
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
	

	/*----Checker 2-----*/

	public function candidate_approve_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_approve_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_approve_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/approve_application_list', $this->data);
	}

	public function candidate_chk2_approve_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_approve_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_app_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				
				if($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type) == TRUE){
					$row_arr = array(
						'chk2_appro_by' => $this->session->userdata['uid'],
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
					}

				}elseif($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']) == TRUE){
					$row_arr = array(
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
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
		$this->load->view('admin/candidate/chk2_candidate_approve_nextforward_list', $this->data);
	}
	
	public function candidate_approve_application_details($appli_id = NULL){
		if($appli_id == NULL){
			redirect('default404');	
		}
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($appli_id);
		if($uaccess != NULL){
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", NULL, NULL, $uaccess, $appli_id);
		}else{
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", NULL, NULL, NULL, $appli_id);
		}
		//echo "<pre>";
		//print_r($this->data['approv_list']);exit;
		$this->load->view('admin/candidate/approve_application_detail_list', $this->data);
	}
	
	public function candidate_application_modify($appli_id = NULL, $chkid = NULL, $pages = NULL){
		if($appli_id == NULL || $chkid == NULL || $pages == NULL){
			redirect('default404');	
		}
		$this->data['chk_detail'] = $chkdetail = $this->db->where('chk_id',$chkid)->get('checking_tab')->row();
		$this->data['accessarray'] = array($chkdetail->chk_type);
		$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($appli_id);
		$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
		$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($appli_id);
		$this->data['p_detail'] = $pages;
		$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($appli_id);
		$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($appli_id);
		$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($appli_id);
		$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();
		$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
		if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {
			$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
		}
		
		$this->load->view('admin/candidate/doubtful_application_detail_modify', $this->data);
	}
	
	public function checking_section_modify_by_chker_two(){
		if($_POST){
			$app_no = $this->input->post('app_no');
            $access_no = $this->input->post('access_no');
			$access_id = $this->input->post('access_id');
            $app_status = $this->input->post('app_status');
            $app_comment = $this->input->post('app_comment');
            
			$this->form_validation->set_rules('app_no', 'Application No.', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('access_no', 'Access Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('app_status', 'Application Status', 'trim|required|alpha');
            if($app_status == "Rejected" || $app_status == "Return"){
            	$this->form_validation->set_rules('app_comment', 'Application Comments', 'trim|required');
            }
			if($access_no == "fu_age_relax" || $access_no == "fu_es_qualification" || $access_no == "fu_ds_qualification" || $access_no == "fu_has_es_service" || $access_no == "fu_has_ds_service"){
				$this->form_validation->set_rules('access_id', 'Application Type ID', 'trim|required');
			}
			if($this->form_validation->run() == TRUE){
				if($access_id == ""){$access_id = NULL;}
				
				if($this->candidates_m->GetDetails_Userwise_CHK2_Candidate_Application_withNULL($app_no, $access_no, $access_id) == TRUE){

						$row_arr = array(
							'chk2_approve' => $app_status,
							'chk_final_state' => $app_status,
							'chk2_comments' => trim($app_comment),
							'chk2_appro_date' => date('Y-m-d H:i:s'),
							'chk2_appro_by' => $this->session->userdata('uid')
						);

						$row_arr2 = NULL;
						/*$row_arr2 = array();
						if($access_no == 'fu_caste'){
							$row_arr2['fu_caste_check'] = $app_status;
						}elseif($access_no == 'fu_pwd'){
							$row_arr2['fu_pwd_check'] = $app_status;
						}elseif($access_no == 'fu_exempted'){
							$row_arr2['fu_exempted_check'] = $app_status;
						}elseif($access_no == 'fu_exservice'){
							$row_arr2['fu_exservice_check'] = $app_status;
						}elseif($access_no == 'fu_ews'){
							$row_arr2['fu_ews_check'] = $app_status;
						}elseif($access_no == 'fu_address'){
							$row_arr2['fu_address_check'] = $app_status;
						}elseif($access_no == 'fu_photo_doc'){
							$row_arr2['fu_photo_check'] = $app_status;
						}elseif($access_no == 'fu_signature_doc'){
							$row_arr2['fu_signature_check'] = $app_status;
						}elseif($access_no == 'fu_dob'){
							$row_arr2['fu_dob_check'] = $app_status;
						}*/
						 
						if($app_status == "Approved" || $app_status == "Rejected"){

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
							
							if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no, $access_id, $row_arr2) == TRUE){
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
								$this->check_Candidate_Existing_forFinal($app_no);
								echo json_encode(array('msg'=>1));
							}else{
								echo json_encode(array('msg'=>0, 'e_msg'=>''));
							}

						}else{

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
								if($app_status == "Return"){
									$checker_details = $this->candidates_m->getprev_checker_details($app_no, $access_no, $access_id);
									$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($app_no);
									$htmldataset = '<html><body><p>Hello Sir/Madam,<br/>
									You are requested by Checker Level 2 to re-check the documents and re-clarify your view accordingly in connection with the post of '.$appdetail->rm_name.' vide Advertisement No '.$appdetail->adv_no.' Dated - '.date("d/m/Y",strtotime("-1 day", strtotime($appdetail->adv_start_time))).'
									</p></body></html>';
									$emailset = $this->sendALLSMTPEmail($checker_details->email,'WBHRB - Return for Document Verification', $htmldataset);
									$msg111 = 'Dear Sir / Madam, You are hereby requested to re-check the documents you have already checked at WBHRB. Please check the mail sent in your registered e-mail id. Regards';
									$smsreplyset = $this->sendALLSMS($msg111, $checker_details->mobile, "singlemsg", '1207163851255900021'); //otpmsg
									$smsarray = explode(',', $smsreplyset);
									if($emailset == true || $smsarray[0] == 402){
										$this->sendALLSMTPEmail('naren_datta@yahoo.co.in','WBHRB - Return for Document Verification', $htmldataset);
									}
								}
								echo json_encode(array('msg'=>1));
							}else{
								echo json_encode(array('msg'=>0, 'e_msg'=>''));
							}
								
						}
						
				}elseif($this->candidates_m->GetDetails_Userwise_CHK2_Candidate_Application_withSKIP($app_no, $access_no, $access_id) == TRUE){

					$row_arr = array(
						'chk2_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk2_comments' => trim($app_comment),
						'chk2_appro_date' => date('Y-m-d H:i:s'),
						'chk2_appro_by' => $this->session->userdata('uid')
					);

					$row_arr2 = NULL;
					/*$row_arr2 = array();
					if($access_no == 'fu_caste'){
						$row_arr2['fu_caste_check'] = $app_status;
					}elseif($access_no == 'fu_pwd'){
						$row_arr2['fu_pwd_check'] = $app_status;
					}elseif($access_no == 'fu_exempted'){
						$row_arr2['fu_exempted_check'] = $app_status;
					}elseif($access_no == 'fu_exservice'){
						$row_arr2['fu_exservice_check'] = $app_status;
					}elseif($access_no == 'fu_ews'){
						$row_arr2['fu_ews_check'] = $app_status;
					}elseif($access_no == 'fu_address'){
						$row_arr2['fu_address_check'] = $app_status;
					}elseif($access_no == 'fu_photo_doc'){
						$row_arr2['fu_photo_check'] = $app_status;
					}elseif($access_no == 'fu_signature_doc'){
						$row_arr2['fu_signature_check'] = $app_status;
					}elseif($access_no == 'fu_dob'){
						$row_arr2['fu_dob_check'] = $app_status;
					}*/

					
					if($app_status == "Approved" || $app_status == "Rejected"){

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
						
						if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no, $access_id, $row_arr2) == TRUE){
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
							$this->check_Candidate_Existing_forFinal($app_no);
							echo json_encode(array('msg'=>1));
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>''));
						}

					}else{

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
							if($app_status == "Return"){
								$checker_details = $this->candidates_m->getprev_checker_details($app_no, $access_no, $access_id);
								$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($app_no);
								$htmldataset = '<html><body><p>Hello Sir/Madam,<br/>
								You are requested by Checker Level 2 to re-check the documents and re-clarify your view accordingly in connection with the post of '.$appdetail->rm_name.' vide Advertisement No '.$appdetail->adv_no.' Dated - '.date("d/m/Y",strtotime("-1 day", strtotime($appdetail->adv_start_time))).'
								</p></body></html>';
								$emailset = $this->sendALLSMTPEmail($checker_details->email,'WBHRB - Return for Document Verification', $htmldataset);
								$msg111 = 'Dear Sir / Madam, You are hereby requested to re-check the documents you have already checked at WBHRB. Please check the mail sent in your registered e-mail id. Regards';
								$smsreplyset = $this->sendALLSMS($msg111, $checker_details->mobile, "singlemsg", '1207163851255900021'); //otpmsg
								$smsarray = explode(',', $smsreplyset);
								if($emailset == true || $smsarray[0] == 402){
									$this->sendALLSMTPEmail('naren_datta@yahoo.co.in','WBHRB - Return for Document Verification', $htmldataset);
								}
							}
							echo json_encode(array('msg'=>1));
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>''));
						}
							
					}

				}elseif($this->candidates_m->GetDetails_Userwise_CHK2_Candidate_Application_withRETURN($app_no, $access_no, $access_id) == TRUE){

					$row_arr = array(
						'chk2_approve' => $app_status,
						'chk_final_state' => $app_status,
						'chk2_comments' => trim($app_comment),
						'chk2_appro_date' => date('Y-m-d H:i:s'),
						'chk2_appro_by' => $this->session->userdata('uid')
					);

					$row_arr2 = NULL;
					/*$row_arr2 = array();
					if($access_no == 'fu_caste'){
						$row_arr2['fu_caste_check'] = $app_status;
					}elseif($access_no == 'fu_pwd'){
						$row_arr2['fu_pwd_check'] = $app_status;
					}elseif($access_no == 'fu_exempted'){
						$row_arr2['fu_exempted_check'] = $app_status;
					}elseif($access_no == 'fu_exservice'){
						$row_arr2['fu_exservice_check'] = $app_status;
					}elseif($access_no == 'fu_ews'){
						$row_arr2['fu_ews_check'] = $app_status;
					}elseif($access_no == 'fu_address'){
						$row_arr2['fu_address_check'] = $app_status;
					}elseif($access_no == 'fu_photo_doc'){
						$row_arr2['fu_photo_check'] = $app_status;
					}elseif($access_no == 'fu_signature_doc'){
						$row_arr2['fu_signature_check'] = $app_status;
					}elseif($access_no == 'fu_dob'){
						$row_arr2['fu_dob_check'] = $app_status;
					}*/

					
					if($app_status == "Approved" || $app_status == "Rejected"){

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
						
						if($this->candidates_m->addmodify_CheckTab_Sets($row_arr, NULL, $app_no, $access_no, $access_id, $row_arr2) == TRUE){
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
							$this->check_Candidate_Existing_forFinal($app_no);
							echo json_encode(array('msg'=>1));
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>''));
						}

					}else{

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
							if($app_status == "Return"){
								$checker_details = $this->candidates_m->getprev_checker_details($app_no, $access_no, $access_id);
								$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($app_no);
								$htmldataset = '<html><body><p>Hello Sir/Madam,<br/>
								You are requested by Checker Level 2 to re-check the documents and re-clarify your view accordingly in connection with the post of '.$appdetail->rm_name.' vide Advertisement No '.$appdetail->adv_no.' Dated - '.date("d/m/Y",strtotime("-1 day", strtotime($appdetail->adv_start_time))).'
								</p></body></html>';
								$emailset = $this->sendALLSMTPEmail($checker_details->email,'WBHRB - Return for Document Verification', $htmldataset);
								$msg111 = 'Dear Sir / Madam, You are hereby requested to re-check the documents you have already checked at WBHRB. Please check the mail sent in your registered e-mail id. Regards';
								$smsreplyset = $this->sendALLSMS($msg111, $checker_details->mobile, "singlemsg", '1207163851255900021'); //otpmsg
								$smsarray = explode(',', $smsreplyset);
								if($emailset == true || $smsarray[0] == 402){
									$this->sendALLSMTPEmail('naren_datta@yahoo.co.in','WBHRB - Return for Document Verification', $htmldataset);
								}
							}
							echo json_encode(array('msg'=>1));
						}else{
							echo json_encode(array('msg'=>0, 'e_msg'=>''));
						}
							
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
	
	protected function check_Candidate_Existing_forFinal($application_no){
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

	public function candidate_reject_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_reject_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_reject_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/reject_application_list', $this->data);
	}

	public function candidate_chk2_reject_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_reject_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_reject_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Rejected", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
			
				if($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type) == TRUE){
					$row_arr = array(
						'chk2_appro_by' => $this->session->userdata['uid'],
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
					}

				}elseif($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']) == TRUE){
					$row_arr = array(
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
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
		$this->load->view('admin/candidate/chk2_candidate_reject_nextforward_list', $this->data);
	}

	public function candidate_doubtful_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_doubtful_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_doubtful_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/doubtful_application_list', $this->data);
	}

	public function candidate_chk2_doubtful_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_doubtful_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_doubtful_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Doubtful", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
			
				if($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type) == TRUE){
					$row_arr = array(
						'chk2_appro_by' => $this->session->userdata['uid'],
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
					}

				}elseif($this->candidates_m->GetDetails_Cheker2ExactCheckerfor_Application($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']) == TRUE){
					$row_arr = array(
						'chk2_appro_date' => date('Y-m-d H:i:s')
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
						$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
						$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
						$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
						$checker++;
						break;
					}else{
						$checker++;
						$this->data['error'] = "There have some problem to Update in DB, Check Again.";
						break;
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
		$this->load->view('admin/candidate/chk2_candidate_doubtful_nextforward_list', $this->data);
	}



	public function candidate_reject_skip_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_reject_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_reject_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/reject_skip_application_list', $this->data);
	}

	public function candidate_chk2_reject_skip_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_reject_skip_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_reject_skip_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withSkip("Rejected", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['cur_checker_details'] = $this->candidates_m->getcurrent_checker_details($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_reject_skip_nextforward_list', $this->data);
	}

	public function candidate_approve_skip_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_approve_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_approve_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/approve_skip_application_list', $this->data);
	}

	public function candidate_chk2_approve_skip_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_approve_skip_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_approve_skip_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withSkip("Approved", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['cur_checker_details'] = $this->candidates_m->getcurrent_checker_details($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_approve_skip_nextforward_list', $this->data);
	}

	public function candidate_doubtful_skip_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_doubtful_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_doubtful_skip_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/doubtful_skip_application_list', $this->data);
	}

	public function candidate_chk2_doubtful_skip_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_doubtful_skip_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_doubtful_skip_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withSkip("Doubtful", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['cur_checker_details'] = $this->candidates_m->getcurrent_checker_details($applies->f_application_no, $acc_items, $sub_type, $this->session->userdata['uid']);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_doubtful_skip_nextforward_list', $this->data);
	}



	public function candidate_reject_return_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_reject_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_reject_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/reject_return_application_list', $this->data);
	}

	public function candidate_chk2_reject_return_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_reject_return_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_reject_return_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withReturn("Rejected", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_reject_return_nextforward_list', $this->data);
	}

	public function candidate_approve_return_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_approve_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_approve_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/approve_return_application_list', $this->data);
	}

	public function candidate_chk2_approve_return_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_approve_return_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_approve_return_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withReturn("Approved", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_approve_return_nextforward_list', $this->data);
	}

	public function candidate_doubtful_return_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$adv_post_type = $this->input->post("adv_post_type");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			$subuser_type = $this->input->post("subuser_type");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('adv_post_type', 'Discipline Type', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->form_validation->set_rules('subuser_type', 'Checker User', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				if($sub_type != ""){
					redirect('admincontrol/candidates/candidate_chk2_doubtful_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type.'/'.$sub_type);
				}else{
					redirect('admincontrol/candidates/candidate_chk2_doubtful_return_nextforwad_list/'.$advno.'/'.$adv_post_type.'/'.$acc_items.'/'.$subuser_type);
				}
				//$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				//$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno, $uaccess);
				}else{
					//$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Approved", $rf_set, $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		$this->load->view('admin/candidate/doubtful_return_application_list', $this->data);
	}

	public function candidate_chk2_doubtful_return_nextforwad_list($advno = NULL, $adv_post_type = NULL, $acc_items = NULL, $subuser_type = NULL, $sub_type = NULL){
		if($advno == NULL || $adv_post_type == NULL || $acc_items == NULL || $subuser_type == NULL){
			redirect('admincontrol/candidates/candidate_doubtful_return_list');
		}
		if($acc_items == "fu_age_relax" || $acc_items == "fu_es_qualification" || $acc_items == "fu_ds_qualification" || $acc_items == "fu_has_es_service" || $acc_items == "fu_has_ds_service"){
			if($sub_type == NULL){
				redirect('admincontrol/candidates/candidate_doubtful_return_list');
			}
		}
		$subuser_name = "";
		if($subuser_type != "All"){
			$slaveuserdetail = $this->db->get_where('user_views',array('u_id'=>$subuser_type))->row();
			$update_subuser_type = $subuser_type;
			$subuser_name = $slaveuserdetail->firstname." ".$slaveuserdetail->lastname." - ".$slaveuserdetail->mu_name;
		}else{
			$update_subuser_type = "All";
			$subuser_type = NULL;
		}
		$this->data['searchlist'] = array('advno'=>$advno, 'adv_post_type'=>$adv_post_type, 'u_accs'=>$acc_items, 'subuser_type'=>$update_subuser_type, 'subuser_name'=>$subuser_name, 'sub_type'=>$sub_type);
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
		$appli_list = $this->candidates_m->GetDetailsof_Approve_Candidate_Application_withReturn("Doubtful", $advno, $acc_items, $subuser_type, $sub_type, $adv_post_type);
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
				$row_arr = array(
					'chk2_appro_by' => $this->session->userdata['uid'],
					'chk2_appro_date' => date('Y-m-d H:i:s')
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
					$this->data['checker_details'] = $this->candidates_m->getprev_checker_details($applies->f_application_no, $acc_items, $sub_type);
					$this->data['alllog_comments'] = $this->candidates_m->getdouble_prev_checkerdetails($applies->f_application_no, $acc_items, $sub_type);
					$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($applies->f_application_no);
					$checker++;
					break;
				}else{
					$checker++;
					$this->data['error'] = "There have some problem to Update in DB, Check Again.";
					break;
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
		$this->load->view('admin/candidate/chk2_candidate_doubtful_return_nextforward_list', $this->data);
	}










	public function holddddddddddd_candidate_reject_list(){
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Rejected", $rf_set, $advno, $uaccess);
				}else{
					$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Rejected", $rf_set, $advno);
				}
				//echo "<pre>";
				//print_r($this->data['approv_list']);exit;
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/reject_application_list', $this->data);
	}
	
	public function candidate_reject_application_details($appli_id = NULL){
		if($appli_id == NULL){
			redirect('default404');	
		}
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($appli_id);
		if($uaccess != NULL){
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Rejected", NULL, NULL, $uaccess, $appli_id);
		}else{
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Rejected", NULL, NULL, NULL, $appli_id);
		}
		//echo "<pre>";
		//print_r($this->data['approv_list']);exit;
		$this->load->view('admin/candidate/reject_application_detail_list', $this->data);
	}
    
	public function holddddddddddd_candidate_doubtful_list(){
		if($_POST){
			//$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			//$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno'=>$advno);
				
				$udetail_access = $this->data["u_details"]->u_access_area;
				$udetail_access_arr = explode(",",$udetail_access);
				if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
				if($uaccess != NULL){
					$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Doubtful", $advno, $uaccess);
				}else{
					$this->data['appli_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Doubtful", $advno);
				}
				if(count((array)$this->data['appli_list']) == 0){
					$this->data['error'] = "No Data found for Checking.";	
				}
			}
		}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
		//$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/doubtful_application_list', $this->data);
	}
	
	public function candidate_doubtful_application_details($appli_id = NULL){
		if($appli_id == NULL){
			redirect('default404');	
		}
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$uaccess = NULL;}else{$uaccess = $udetail_access_arr;}
		$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($appli_id);
		if($uaccess != NULL){
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Doubtful", NULL, $uaccess, $appli_id);
		}else{
			$this->data['approv_list'] = $this->candidates_m->GetDetailsof_Approve_Candidate_Application("Doubtful", NULL, NULL, $appli_id);
		}
		//echo "<pre>";
		//print_r($this->data['approv_list']);exit;
		$this->load->view('admin/candidate/doubtful_application_detail_list', $this->data);
	}
	
	public function final_approval_list(){
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
				echo "Working progress";exit;
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				/*$str_arr = array(
					'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_qualification','fu_has_service'
				);*/
				$getall_existreg_result = $this->candidates_m->getExisting_AdmitcardCandidate_Application($rf_set, $advno);
				$getall_existreg_arr = array();
				foreach($getall_existreg_result as $resultsets){
					$getall_existreg_arr[] = $resultsets->cr_application_master;
				}
				//print_r($getall_existreg_arr);exit;
				$this->data['appli_list'] = $applist = $this->candidates_m->GetDetailsof_Approvae_Candidate_Application($rf_set, $advno, $getall_existreg_arr);
				if(count((array)$applist) == 0){
					$this->data['error'] = "No Data Found for Processing.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/final_approval_application_list', $this->data);
	}
	
	public function update_application_final_approval(){
		if($_POST){
			$app_gen = $this->input->post('app_gen');
			$advno = $this->input->post("advno");
            $this->form_validation->set_rules('app_gen', 'Application No.', 'trim|required');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			
			if($this->form_validation->run() == TRUE){
				
				//print_r($app_gen);exit;
				$app_arr = explode(",", $app_gen);
				$total_counter = count($app_arr);
				$setcounter = 0;
				$errorarr = array();
				foreach($app_arr as $appsid){
					$getresult = $this->db->where('chk_user_application',$appsid)->where('chk_final_state = "Approved"')->where('(chk_type = "fu_qualification" OR chk_type = "fu_has_service")')->get('checking_tab')->result();
					$totalmarks = 0.00;
					$examnumber = 0.00;
					$servicenumber = 0.00;
					foreach($getresult as $itemresults){
						if($itemresults->chk_type == "fu_qualification"){
							$examnumber = $itemresults->chk_got_marks;
						}elseif($itemresults->chk_type == "fu_has_service"){
							$servicenumber = $itemresults->chk_got_marks;
						}
					}
					$existing_counter = $this->candidates_m->getTotal_AdmitGeneration_against_Advertisement($advno);
					$totalmarks = $examnumber + $servicenumber;
					$admitgenno = 'AT/'.$advno.'/'.($existing_counter + 1);
					$row_arr = array(
						'cr_approval' => "Approved",
						'cr_academic' => $examnumber,
						'cr_experience' => $servicenumber,
						'cr_total_marks' => $totalmarks,
						'cr_admitcard_issued' => 1,
						'cr_admitcard_no' => $admitgenno,
						'cr_admitcard_date' => date('Y-m-d H:i:s')
					);
					if($this->candidates_m->setUpdate_ResultCandidate_Appliwise($row_arr, $appsid) == TRUE){
						$setcounter++;
					}else{
						$errorarr[] = $appsid;
					}
				}
				if($setcounter == $total_counter){
					echo json_encode(array('msg'=>1));
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>$errorarr));
				}
				
            }else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}

	public function candidate_full_score($application_no = NULL){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		$this->data['appli_details'] = $apdetail = $this->candidates_m->GetDetailsofCandidate_Application($application_no);
		$this->data['appli_result'] = $this->db->get_where('candidate_result_tab',array('cr_application_master'=>$application_no))->row();
		$this->data['appli_list'] = $this->db->get_where('checking_tab',array('chk_user_application'=>$application_no))->result();
		$this->data['q_list'] = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($apdetail->f_applied_for);
		$this->data['exp_list'] = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($apdetail->f_applied_for);
		//$this->data['appli_list'] = array();
		//echo "<pre>";
		//print_r($this->data['exp_list']);exit;
		$this->load->view('admin/candidate/view_score_list', $this->data);
	}

	public function candidates_marks_printsets($candno){
		$appli_result = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $candno))->row();
		$fuser_detailset = $this->db->get_where('f_user_views', array('f_application_no' => $candno))->row();

		$appli_list = $this->db->get_where('checking_tab',array('chk_user_application'=>$candno))->result();
		$q_list = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($fuser_detailset->f_applied_for);
		$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($fuser_detailset->f_applied_for);
		
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Marks Details';
		$obj_pdf->SetTitle('Marks Details');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Candidate - Marks Details');

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
				$foo = ($appli_result->cr_academic + $appli_result->cr_experience + $appli_result->cr_interview_1 + $appli_result->cr_interview_2);
				$my_html = $my_html."</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<br/><br/>
				<table style=\"width: 100%\" cellpadding=\"5\" style=\"font-size: 20px;\">
				<tr>
					<td><div align=\"left\">
					<strong>Candidate Mark Details :-</strong><br/>
					<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 20px;\">
					<thead>
						<tr>
							<td><strong>Academic Marks</strong></td>
	                  		<td><strong>Experience Marks</strong></td>
							<td><strong>Interview Marks 1</strong></td>
							<td><strong>Interview Marks 2</strong></td>
	                  		<td><strong>Total Marks</strong></td>
						</tr>
					</thead>
					<tbody>
						<tr>
						<td>".$appli_result->cr_academic."</td>
						<td>".$appli_result->cr_experience."</td>
						<td>".$appli_result->cr_interview_1."</td>
						<td>".$appli_result->cr_interview_2."</td>
						<td>".number_format((float)$foo, 2, '.', '')."</td>
						</tr>
					</tbody>
					</table>";
					$my_html = $my_html."</div>
					</td>
				</tr>
				<tr>
					<td><div align=\"left\">
					<strong>Individual Mark Details :-</strong><br/>
					<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 20px;\">
					<thead>
						<tr>
							<td width=\"10%\"><strong>Sl No.</strong></td>
	                  		<td width=\"80%\"><strong>Section</strong></td>
							<td width=\"10%\"><strong>Marks</strong></td>
						</tr>
					</thead>
					<tbody>";
						$keys=1;
						foreach($appli_list as $users){ 
							if($users->chk_type == "fu_es_qualification" || $users->chk_type == "fu_ds_qualification" || $users->chk_type == "fu_has_es_service" || $users->chk_type == "fu_has_ds_service"){
							$my_html = $my_html."<tr>
                  			<td width=\"10%\">".$keys."</td>
                  			<td width=\"80%\">";
							if($users->chk_type == "fu_es_qualification" || $users->chk_type == "fu_ds_qualification"){
								foreach($q_list as $qitems){
									if($users->chk_sub_typeid == $qitems->aquali_exam){
										$my_html = $my_html.$qitems->qm_name;
										break;
									}
								}
							}elseif($users->chk_type == "fu_has_es_service" || $users->chk_type == "fu_has_ds_service"){
								foreach($exp_list as $exitems){
									if($users->chk_sub_typeid == $exitems->aexpr_name){
										$my_html = $my_html.$exitems->expset_name;
										break;
									}
								}
							}
							$my_html = $my_html."</td>
							<td width=\"10%\">".$users->chk_got_marks."</td>
							</tr>";	
							$keys++;}
						}
						$my_html = $my_html."</tbody>
					</table>";
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
	
	public function admit_card_issued_list(){
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
				echo "Working progress";exit;
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				
				$this->data['appli_list'] = $applist = $this->candidates_m->getExisting_AdmitcardCandidate_List($rf_set, $advno);
				if(count((array)$applist) == 0){
					$this->data['error'] = "No Application Found for Processing.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/admitcard_application_list', $this->data);
	}
	
	public function print_candidate_admin_card($regno = NULL){
		if($this->session->userdata['utype'] != 1){
			redirect('admincontrol/dashboard');
		}
		if($regno == NULL){
			redirect('admincontrol/dashboard');
		}
		
		$get_app_detail = $this->candidates_m->GetDetailsofCandidate_Application($regno);
		$get_result_detail = $this->db->get_where('candidate_result_tab',array('cr_application_master'=>$regno, 'cr_approval'=>'Approved', 'cr_admitcard_issued'=>1))->row();
		
		if((count((array)$get_app_detail) == 0) || (count((array)$get_result_detail) == 0)){
			redirect('admincontrol/dashboard');
		}
		$regno_update = ltrim($regno, 'C');
		$randomnumber = rand(7, 15);
		$get_urcode = $this->generateRandomString(17).$regno_update.$this->generateRandomString($randomnumber);
		
		
		//$get_urcode = $this->encryption->encrypt($get_urcodeset);
		// Outputs: This is a plain-text message!
		//echo $ciphertext.'<br/>';
		//echo $this->encryption->decrypt($get_urcode);exit;
		//$resultno = 'C'.substr($get_urcode, 17, 18);
		//$get_urcode = $this->admin_m->hash($regno);
		//print_r($get_app_detail);exit;
		$this->load->helper("tcpdf_helper");
		tcpdf();
		$obj_pdf = new TCPDF('L', 'mm', array(210, 170), true, 'UTF-8', false);
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $regno;
		$obj_pdf->SetTitle('ADMIT CARD');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Admit Card Generation');

		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		//$obj_pdf->setFooterData(array(0,64,0), array(0,64,128));
		$obj_pdf->SetMargins(10, 10, 10, true);
		//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//$obj_pdf->SetDefaultMonospacedFont('helvetica');
		//$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		//$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
		//$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//$obj_pdf->SetFont('helvetica', '', 9);
		//$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		
		
		$my_html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		</head>
		<body>
		<div class="header">';	
		$obj_pdf->write2DBarcode($get_urcode, 'QRCODE,H', 165, 16, 30, 30, NULL, '');
		$my_html = $my_html.'<table style="width: 100%" style="font-size: 12px;">
		<tr>
			<td colspan="2" style="width:100%;"><div align="center">
			<span style="font-size:14px;font-weight:bold;">West Bengal Health Recruitment Board</span><br/>
			<span align="center" style="font-size:10px;font-weight:normal;">BENFISH TOWER, (1st, 2nd & 3rd Floor)</span><br/>
			<span align="center" style="font-size:10px;font-weight:normal;">GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
			<span align="center" style="font-size:10px;font-weight:normal;"><u>www.wbhrb.in</u>, Phone : 2357-0085</span></div>
			<div align="center" style="font-size:12px;font-weight:bold;"><u>ADMIT CARD</u><br/>
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="width:100%;">
			<table style="width: 100%" border="1" cellpadding="3" style="font-size: 10px;">
				<tr>
					<td width="20%">Name</td>
					<td width="80%">'.$get_app_detail->f_full_name.'</td>
				</tr>
				<tr>
					<td>Recruitment For</td>
					<td>'.$get_app_detail->rm_name.'</td>
				</tr>
				<tr>
					<td>Advertisement No.</td>
					<td>'.$get_app_detail->adv_no.'</td>
				</tr>
				<tr>
					<td>Registration No.</td>
					<td>'.$get_app_detail->f_application_no.'</td>
				</tr>
				<tr>
					<td>Admit Card No.</td>
					<td>'.$get_result_detail->cr_admitcard_no.'</td>
				</tr>
				<tr>
					<td>Mobile No.</td>
					<td>'.$get_app_detail->f_mobile.'</td>
				</tr>
				<tr>
					<td>Email-ID</td>
					<td>'.$get_app_detail->f_email.'</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>'.$get_app_detail->fu_address.'</td>
				</tr>
				
			</table>
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td>&nbsp;</td>
					<td align="center"><div style="border:1px solid #000;font-weight:bold;font-size:9px;"><br/>This document has been digitally generated.<br/>No Signature is required.<br/>
				WEST BENGAL HEALTH RECRUITMENT BOARD<br/></div></td>
				  </tr>
		</table>
		</div>
		</body>
		</html>';
		
		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(date("dmYHis").'.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');
		
		//$this->session->set_flashdata("success","Report is Generated Successfully");
		
	}
	
	public function final_for_empanel_list(){
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
				echo "Working progress";exit;
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->get('advertisement_master')->result();
				$this->data['appli_list'] = $applist = $this->candidates_m->get_CompleteExam_Candidate_Application($rf_set, $advno);
				if(count((array)$applist) == 0){
					$this->data['error'] = "No Data Found for Processing.";
				}
			}
		}else{
			$this->data['appli_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/candidate/final_for_empanel_application_list', $this->data);
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
	
	
	public function updateset_subsection_experience(){
		if($_POST){
			$candadv_no = $this->input->post('candadv_no');
			$candapp_no = $this->input->post("candapp_no");
			$chkid = $this->input->post("chkid");
			$appro_type = $this->input->post("appro_type");
			$exptype = $this->input->post("exptype");
			
            $this->form_validation->set_rules('candapp_no', 'Candidate Application No.', 'trim|required');
			$this->form_validation->set_rules('candadv_no', 'Candidate Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('chkid', 'Experience ID', 'trim|required|is_natural');
			$this->form_validation->set_rules('appro_type', 'Status', 'trim|required');
			$this->form_validation->set_rules('exptype', 'Exp. Type', 'trim|required');

			if($this->form_validation->run() == TRUE){
				if($exptype == "ES"){
					$row_arr = array(
						'fues_exp_approval' => $appro_type
					);
				}elseif($exptype == "DS"){
					$row_arr = array(
						'fu_exp_approval' => $appro_type
					);
				}
				
				if($this->candidates_m->sectionmodify_subExperience_Sets($row_arr,$chkid,$exptype) == TRUE){
					$rowarray = array(
						'chklog_app_no' => $candapp_no,
						'chklog_type' => 'SubExperience-'.$exptype,
						'chklog_type_id' => $chkid,
						'chklog_user' => $this->session->userdata('uid'),
						'chklog_approval' => $appro_type,
						'chklog_msg' => '',
						'chklog_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->update_adminChecker_user_log($rowarray);
					echo json_encode(array('msg'=>1, 's_msg' => ''));
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'Data Updation Error in DB, Try Again.'));
				}
			}else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}

	public function update_checker_examdata(){
		if($_POST){
			$qid = $this->input->post("qid");
			$qtype = $this->input->post("qtype");
			$q_fullmark = $this->input->post("q_fullmark");
			$q_obtainmark = $this->input->post("q_obtainmark");
			$q_percentmark = $this->input->post("q_percentmark");
			
			$this->form_validation->set_rules('qid', 'ID', 'trim|required');
			$this->form_validation->set_rules('qtype', 'Type', 'trim|required');
			$this->form_validation->set_rules('q_fullmark', 'Full Marks', 'trim|required');
			$this->form_validation->set_rules('q_obtainmark', 'Obtained Marks', 'trim|required');
			$this->form_validation->set_rules('q_percentmark', 'Percent Marks', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				if($qtype == "E"){
					$row_arr = array(
						'fu_fullmark_ck' => $q_fullmark,
						'fu_obtainmark_ck' => $q_obtainmark,
						'fu_percentmark_ck' => trim($q_percentmark),
						'fu_mark_modifydate' => date('Y-m-d H:i:s'),
						'fu_mark_modifyby' => $this->session->userdata('uid')
					);
				}elseif($qtype == "D"){
					$row_arr = array(
						'fud_fullmark_ck' => $q_fullmark,
						'fud_obtainmark_ck' => $q_obtainmark,
						'fud_percentmark_ck' => trim($q_percentmark),
						'fud_mark_modifydate' => date('Y-m-d H:i:s'),
						'fud_mark_modifyby' => $this->session->userdata('uid')
					);
				}
				
				if($this->candidates_m->addmodify_ExamSets_ByChecker($row_arr, $qid, $qtype) == TRUE){
					echo json_encode(array('msg'=>1));
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>''));
				}
			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
		}else{
			redirect('default404');
		}
	}
	
	public function update_checker_experiencedata(){
		if($_POST){
			$expid = $this->input->post("expid");
			$expsettype = $this->input->post("expsettype");
			$exp_fullyear = $this->input->post("exp_fullyear");
			$exp_fullmonth = $this->input->post("exp_fullmonth");
			
			$this->form_validation->set_rules('expid', 'Exp ID', 'trim|required');
			$this->form_validation->set_rules('expsettype', 'Type', 'trim|required');
			$this->form_validation->set_rules('exp_fullyear', 'Year', 'trim|required|is_natural');
			$this->form_validation->set_rules('exp_fullmonth', 'Month', 'trim|required|is_natural');

			if($this->form_validation->run() == TRUE) {
				if($expsettype == "E"){
					$row_arr = array(
						'fues_exp_yr_ck' => $exp_fullyear,
						'fues_exp_mth_ck' => $exp_fullmonth,
						'fues_exp_modifydate' => date('Y-m-d H:i:s'),
						'fues_exp_modifyby' => $this->session->userdata('uid')
					);
				}elseif($expsettype == "D"){
					$row_arr = array(
						'fu_exp_yr_ck' => $exp_fullyear,
						'fu_exp_mth_ck' => $exp_fullmonth,
						'fu_exp_modifydate' => date('Y-m-d H:i:s'),
						'fu_exp_modifyby' => $this->session->userdata('uid')
					);
				}
				
				if($this->candidates_m->addmodify_ExperienceSets_ByChecker($row_arr, $expid, $expsettype) == TRUE){
					echo json_encode(array('msg'=>1));
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>''));
				}
			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}
		}else{
			redirect('default404');
		}
	}

	public function fuser_list234234234344(){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		$this->data['userlist'] = $this->db->order_by('f_uid','DESC')->get('f_user_views')->result();
		$this->load->view('admin/front_user_list', $this->data);
	}
	
	public function lock_fuser4345435345345345($uid = NULL){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($uid == NULL){
			redirect('admincontrol/front_user/fuser_list');
		}
		$row_arr = array(
			'f_status' => 0
		);
		if($this->main_m->addform_against_user_signup_update($row_arr, $uid) == TRUE)
		{
			$this->session->set_flashdata("success","User is Locked successfully");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
	}
	
	public function unlock_fuser76877685634523($uid = NULL){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($uid == NULL){
			redirect('admincontrol/front_user/fuser_list');
		}
		$row_arr = array(
			'f_status' => 1
		);
		if($this->main_m->addform_against_user_signup_update($row_arr, $uid) == TRUE)
		{
			$this->session->set_flashdata("success","User is Unlocked successfully");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
	}
	
	public function delete_fuser3454354534534534534577($uid = NULL){
		if($this->session->userdata['utype'] > 2){
			redirect('admincontrol/dashboard');
		}
		if($uid == NULL){
			redirect('admincontrol/front_user/fuser_list');
		}
		if($this->db->delete('frontend_users', array('f_uid' => $uid)))
		{
			$this->session->set_flashdata("success","User is Deleted successfully");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/front_user/fuser_list','refresh');
		}
	}
	
	public function forwardmail_doc_modification(){
		if($_POST){
			$candadv_no = $this->input->post('candadv_no');
			$candapp_no = $this->input->post("candapp_no");
			$doctype = $this->input->post("doctype");
			$docid = $this->input->post("docid");
			$extfilename = $this->input->post("extfilename");
			$app_comment = $this->input->post("app_comment");

            $this->form_validation->set_rules('candapp_no', 'Candidate Application No.', 'trim|required');
			$this->form_validation->set_rules('candadv_no', 'Candidate Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('doctype', 'Document Type', 'trim|required');
			$this->form_validation->set_rules('docid', 'Document ID', 'trim|required|is_natural');
			$this->form_validation->set_rules('extfilename', 'Document Name', 'trim');
			$this->form_validation->set_rules('app_comment', 'Comments', 'trim');
			
			if($this->form_validation->run() == TRUE){
				
				//$de_res = openssl_decrypt(base64_decode($resutsetssss),"AES-128-ECB",config_item('encryption_key'));
				//print_r($resutsetssss);exit;
				$curtime = date("Y-m-d H:i:s");
				$addtime = date("Y-m-d H:i:s",strtotime($curtime." +168 hours"));
				$row_arr = array(
					'udm_createby' => $this->session->userdata['uid'],
					'udm_cand_advno' => $candadv_no,
					'udm_cand_regno' => $candapp_no,
					'udm_s_datetime' => $curtime,
					'udm_e_datetime' => $addtime,
					'udm_doctype' => $doctype,
					'udm_old_docname' => $extfilename,
					'udm_doc_id' => $docid,
					'udm_createdate' => date('Y-m-d H:i:s')
				);
				$resultset_id = $this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arr);
				if($resultset_id != FALSE){
					$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candapp_no);
					$stringset = strtotime(date("YmdHis")).'|'.$candadv_no.'|'.$candapp_no.'|'.$doctype.'|'.$docid.'|'.$resultset_id;
					$encstring = base64_encode(openssl_encrypt($stringset,"AES-128-ECB",config_item('encryption_key')));
					$makeurl = base_url().'documentupload/specificfile_upload_bycandidate/'.$encstring;
					$htmldataset = '<html><body><p>Dear Candidate,<br/>
					You have applied for the post of '.$appdetail->rm_name.' vide advt. no '.$appdetail->adv_no.' dated: '.date("d/m/Y",strtotime("-1 day", strtotime($appdetail->adv_start_time))).' During verification of application, it is observed that following documents which are not visible/ readable/uploaded properly:</p>';
					if($doctype == 'CO'){
						$comname_arr = array('','Picture','Signature','Address Proof','Date of Birth Proof','Caste Proof','PWD Proof','Exempted Category Proof','Ex-Serviceman Category Proof','Sportsman Category Proof','Registration Certificate');
						$htmldataset = $htmldataset.'<p>1. --- '.$comname_arr[$docid].'</p>';
					}elseif($doctype == 'EQ'){
						$docu_details = $this->candidates_m->get_EssenQualification_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'DQ'){
						$docu_details = $this->candidates_m->get_DesireQualification_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'ES'){
						$docu_details = $this->candidates_m->get_EssenExperience_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->expset_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'DS'){
						$docu_details = $this->candidates_m->get_DesireExperience_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->expset_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'EA'){
						$docu_details = $this->candidates_m->get_EssenAgeRelax_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->caste_name.' Marksheet/ Centificate</p>';
					}
					$htmldataset = $htmldataset.'<p>So, you are requested to upload the proper images/pdfs, as applicable, of the above mentioned documents within 7 days of receiving this email in the following link:-<br/>'.$makeurl.'</p>';
					if($app_comment != ""){
						$htmldataset = $htmldataset.'<p><strong>Further Information:</strong><br/>'.$app_comment.'</p>';
					}
					$htmldataset = $htmldataset.'</body></html>';
					//$mailid_candidate = $this->db->get_where('frontend_users',array('f_application_no'=>$candapp_no))->row()->f_email;
					$emailset = $this->sendALLSMTPEmail($appdetail->f_email,'WBHRB - Resubmission of Document', $htmldataset);
					$msg111 = 'For re-uploading all the relevant documents for the post of '.$appdetail->rm_name.', please login the link sent by WBHRB in your registered Email- Id. Regards';
					$smsreplyset = $this->sendALLSMS($msg111, $appdetail->f_mobile, "singlemsg", '1207163853007809851'); //otpmsg
					$smsarray = explode(',', $smsreplyset);
					if($emailset == true && $smsarray[0] == 402){
					//if(empty($htmldataset)){
						echo json_encode(array('msg'=>1, 's_msg' => ''));
					}else{
						$this->db->delete('updatedoc_mail_log', array('udm_id' => $resultset_id));
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Email Not Send Properly, Check Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'Data Insertion Error in DB, Try Again.'));
				}
            }else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}

	public function forwardmail_qualification_modification(){
		if($_POST){
			$candadv_no = $this->input->post('candadv_no');
			$candapp_no = $this->input->post("candapp_no");
			$doctype = $this->input->post("doctype");
			$docid = $this->input->post("docid");
			$app_comment = $this->input->post("app_comment");

            $this->form_validation->set_rules('candapp_no', 'Candidate Application No.', 'trim|required');
			$this->form_validation->set_rules('candadv_no', 'Candidate Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('doctype', 'Qualification Type', 'trim|required');
			$this->form_validation->set_rules('docid', 'Qualification ID', 'trim|required|is_natural');
			$this->form_validation->set_rules('app_comment', 'Comments', 'trim');
			
			if($this->form_validation->run() == TRUE){
				
				//$de_res = openssl_decrypt(base64_decode($resutsetssss),"AES-128-ECB",config_item('encryption_key'));
				//print_r($resutsetssss);exit;
				
				$curtime = date("Y-m-d H:i:s");
				$addtime = date("Y-m-d H:i:s",strtotime($curtime." +168 hours"));
				$row_arr = array(
					'udq_createby' => $this->session->userdata['uid'],
					'udq_cand_advno' => $candadv_no,
					'udq_cand_regno' => $candapp_no,
					'udq_s_datetime' => $curtime,
					'udq_e_datetime' => $addtime,
					'udq_sectiontype' => $doctype,
					'udq_quali_id' => $docid,
					'udq_createdate' => date('Y-m-d H:i:s')
				);
				if($doctype == 'EQ'){
					$quali_details = $this->candidates_m->get_EssenQualification_fromDB($docid);
					$row_arr['udq_old_fullmarks'] = $quali_details->fu_full_marks;
					$row_arr['udq_old_markobtain'] = $quali_details->fu_marks_obtained;
					$row_arr['udq_old_percentage'] = $quali_details->fu_percent_of_marks;
				}elseif($doctype == 'DQ'){
					$quali_details = $this->candidates_m->get_DesireQualification_fromDB($docid);
					$row_arr['udq_old_fullmarks'] = $quali_details->fud_full_marks;
					$row_arr['udq_old_markobtain'] = $quali_details->fud_marks_obtained;
					$row_arr['udq_old_percentage'] = $quali_details->fud_percent_of_marks;
				}
				$resultset_id = $this->candidates_m->addmodify_Qualification_modifymail_ByChecker($row_arr);
				if($resultset_id != FALSE){
					$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candapp_no);
					$stringset = strtotime(date("YmdHis")).'|'.$candadv_no.'|'.$candapp_no.'|'.$doctype.'|'.$docid.'|'.$resultset_id;
					$encstring = base64_encode(openssl_encrypt($stringset,"AES-128-ECB",config_item('encryption_key')));
					$makeurl = base_url().'documentupload/modify_qualificationmarks_bycandidate/'.$encstring;
					if($doctype == 'EQ'){
						$docu_details = $this->candidates_m->get_EssenQualification_fromDB($docid);
						//$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marks</p>';
					}elseif($doctype == 'DQ'){
						$docu_details = $this->candidates_m->get_DesireQualification_fromDB($docid);
						//$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marks</p>';
					}
					$htmldataset = '<html><body><p>Dear Applicant/Candidate,<br/>
					You are hereby informed that you are allowed to edit "Full marks" and "Marks obtained" in '.$docu_details->qm_name.' in the post of '.$appdetail->rm_name.' vide advt. no '.$appdetail->adv_no.' dated: '.date("d/m/Y",strtotime("-1 day", strtotime($appdetail->adv_start_time))).' in the link provided below. Please remember that your information should tally with the documents uploaded.</p>';
					if($app_comment != ""){
						$htmldataset = $htmldataset.'<p><strong>Further Information:</strong><br/>'.$app_comment.'</p>';
					}
					/*if($doctype == 'CO'){
						$comname_arr = array('','Picture','Signature','Address Proof','Date of Birth Proof','Caste Proof','PWD Proof','Exempted Proof','Ex-Service Proof','Sportsman Proof','Registration Certificate');
						$htmldataset = $htmldataset.'<p>1. --- '.$comname_arr[$docid].'</p>';
					}elseif($doctype == 'EQ'){
						$docu_details = $this->candidates_m->get_EssenQualification_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'DQ'){
						$docu_details = $this->candidates_m->get_DesireQualification_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->qm_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'ES'){
						$docu_details = $this->candidates_m->get_EssenExperience_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->expset_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'DS'){
						$docu_details = $this->candidates_m->get_DesireExperience_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->expset_name.' Marksheet/ Centificate</p>';
					}elseif($doctype == 'EA'){
						$docu_details = $this->candidates_m->get_EssenAgeRelax_fromDB($docid);
						$htmldataset = $htmldataset.'<p>1. --- '.$docu_details->caste_name.' Marksheet/ Centificate</p>';
					}*/
					$htmldataset = $htmldataset.'<p><strong>Link :-</strong> '.$makeurl.'</p>';
					$htmldataset = $htmldataset.'<p>This link is valid for 7 days only. So you are requested to do the needful positively within 7 days. No further link will be sent.</p>';
					
					$htmldataset = $htmldataset.'<p>Regards,<br/>
					<strong>Secretary & Controller of the Examinations<br/>West Bengal Health Recruitment Board</strong><p>
					<p>Note: - This is a system generated Email please DO NOT reply to it.</p>
					</body></html>';
					//$mailid_candidate = $this->db->get_where('frontend_users',array('f_application_no'=>$candapp_no))->row()->f_email;
					//$emailset = $this->sendALLSMTPEmail($appdetail->f_email,'WBHRB - Edit information regarding Qualification', $htmldataset);
					$msg111 = 'For re-uploading all the relevant documents for the post of '.$appdetail->rm_name.', please login the link sent by WBHRB in your registered Email- Id. Regards';
					//$smsreplyset = $this->sendALLSMS($msg111, $appdetail->f_mobile, "singlemsg", '1207163853007809851'); //otpmsg
					//$smsarray = explode(',', $smsreplyset);
					//if($emailset == true && $smsarray[0] == 402){
					if(empty($htmldataset)){
						echo json_encode(array('msg'=>1, 's_msg' => ''));
					}else{
						$this->db->delete('updatedoc_mail_log', array('udm_id' => $resultset_id));
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Email Not Send Properly, Check Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'Data Insertion Error in DB, Try Again.'));
				}
            }else{
                echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
            }
			exit;
		}else{
			redirect('default404');
		}
	}

	public function document_history_checking($candidate_ref = NULL, $doctype = NULL, $docid = NULL){
		if($candidate_ref == NULL || $doctype == NULL || $docid == NULL){
			redirect('admincontrol/dashboard');
		}
		if($doctype == 'CO'){
			$comname_arr = array('','Picture','Signature','Address Proof','Date of Birth Proof','Caste Proof','PWD Proof','Exempted Category Proof','Ex-Serviceman Category Proof','Sportsman Category Proof','Registration Certificate');
			$this->data['titleset'] = $comname_arr[$docid].' List - ';
		}elseif($doctype == 'EQ'){
			$docu_details = $this->candidates_m->get_EssenQualification_fromDB($docid);
			$this->data['titleset'] = $docu_details->qm_name.' Marksheet/ Centificate List - ';
		}elseif($doctype == 'DQ'){
			$docu_details = $this->candidates_m->get_DesireQualification_fromDB($docid);
			$this->data['titleset'] = $docu_details->qm_name.' Marksheet/ Centificate List - ';
		}elseif($doctype == 'ES'){
			$docu_details = $this->candidates_m->get_EssenExperience_fromDB($docid);
			$this->data['titleset'] = $docu_details->expset_name.' Marksheet/ Centificate List - ';
		}elseif($doctype == 'DS'){
			$docu_details = $this->candidates_m->get_DesireExperience_fromDB($docid);
			$this->data['titleset'] = $docu_details->expset_name.' Marksheet/ Centificate List - ';
		}elseif($doctype == 'EA'){
			$docu_details = $this->candidates_m->get_EssenAgeRelax_fromDB($docid);
			$this->data['titleset'] = $docu_details->caste_name.' Marksheet/ Centificate List - ';
		}
		$this->data['appli_details'] = $this->candidates_m->GetDetailsofCandidate_Application($candidate_ref);
		$this->data['all_documentlist'] = $this->candidates_m->get_AllDocument_bySendMail_fromDB($candidate_ref, $doctype, $docid);
		
		$this->load->view('admin/candidate/doc_history_list', $this->data);
	}

	public function admin_accesswise_checkingset($application_no = NULL){
		if($application_no == NULL){
			redirect('admincontrol/candidates/comp_application_list');
		}
		if($_POST){
			$candid = $this->input->post("candid");
			$advno = $this->input->post("advno");
			$acc_items = $this->input->post("u_accs");
			$sub_type = $this->input->post("sub_type");
			
			$this->form_validation->set_rules('candid', 'Candidate Ref No.', 'trim|required');
			$this->form_validation->set_rules('u_accs', 'Access Type', 'trim|required');
			$this->data['searchlist'] = array('u_accs'=>$acc_items, 'sub_type'=>$sub_type);
			if($this->form_validation->run() == TRUE) {
				if($sub_type != NULL){
					$this->data['searchsub_type'] = $this->candidates_m->GetDetailsofSub_type_By_Access($advno, $acc_items, $sub_type);
				}
				$this->data['accessarray'] = array($acc_items);
				$this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candid);
				$this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
				$this->data['quali_details'] = $this->candidates_m->GetDetail_Qualification_for_Application($candid);
				$this->data['des_quali_details'] = $this->candidates_m->GetDetail_DesireQualification_for_Application($candid);
				$this->data['exp_details'] = $this->candidates_m->GetDetail_Experience_for_Application($candid);
				$this->data['essenexp_details'] = $this->candidates_m->GetDetail_Essn_Experience_for_Application($candid);
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
				$this->data['searchfor'] = 1;			
				$this->data['spclage_list'] = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($candid);
				//print_r($this->data['spclage_list']);
			}
		}else{
			$this->data['searchfor'] = 2;
		}
		$this->data['uaccess'] = $this->data['ssstr_arr'];
		$this->data['cur_appno'] = $application_no;
		$this->data['canddetail'] = $this->db->get_where('frontend_users',array('f_application_no'=>$application_no))->row();
		$this->load->view('admin/candidate/admin_access_application_list', $this->data);
	}
	
	public function printwatermark_accesswise($candid, $uaccess, $access_id = NULL){

		if($candid == NULL || $uaccess == NULL){
			redirect('admincontrol/candidates/comp_application_list');
		}
		$searchlist = array('u_accs'=>$uaccess, 'sub_type'=>$access_id);
		$appdetail = $this->candidates_m->GetDetailsofCandidate_Application($candid);
		$discip_details = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
		$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($candid);
		$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($candid);
		$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($candid);
		$essenexp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($candid);
		$state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
		$dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

		if ($appdetail->fu_district != NULL) {
			$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_district))->result();
			$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_district))->result();
		}
		if ($appdetail->fu_perma_dist != NULL) {
			$per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $appdetail->fu_perma_dist))->result();
			$per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $appdetail->fu_perma_dist))->result();
		}
		if ($appdetail->fu_perma_sub_division != NULL && $appdetail->fu_perma_mb_type != NULL) {
			$per_mb_type = $appdetail->fu_perma_mb_type;
			$per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_perma_sub_division, 'block_type' => $appdetail->fu_perma_mb_type))->result();
		}
		if ($appdetail->fu_sub_division != NULL && $appdetail->fu_mb_type != NULL) {
			$mb_type = $appdetail->fu_mb_type;
			$block_municipality = $this->db->get_where('block_master', array('subd_id' => $appdetail->fu_sub_division, 'block_type' => $appdetail->fu_mb_type))->result();
		}
		$caste_issuing_auth = $this->db->get('caste_issuing_auth_tab')->result();
		$caste_tab = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
		if ($appdetail->fu_caste_type != NULL && $appdetail->fu_caste_community != NULL) {
			$caste_community = $this->db->get_where('caste_details_tab', array('csdetail_id' => $appdetail->fu_caste_community, 'csdetail_status' => 1))->row();
		}
		$spclage_list = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($candid);

		/*$this->load->helper("fpdi_helper");
		fpdi();
		$pdf = new Fpdi();
		$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(true, 40);

		// add a page
		$pdf->AddPage();

		// get external file content
		$utf8text = file_get_contents('tcpdf/examples/data/utf8test.txt', true);

		$pdf->SetFont('freeserif', '', 12);
		// now write some text above the imported page
		$pdf->Write(5, $utf8text);

		$pdf->Output('generated.pdf', 'I');*/

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
					<td><strong>Recruitment For</strong></td>
					<td>".$appdetail->rm_name."</td>
				</tr>
				<tr>
					<td><strong>Application No.</strong></td>
					<td>".$appdetail->f_application_no."</td>
				</tr>
				<tr>
					<td><strong>Advertisement No.</strong></td>
					<td>".$appdetail->adv_no."</td>
				</tr>
				<tr>
					<td><strong>Full Name</strong></td>
					<td>".$appdetail->f_full_name."</td>
				</tr>
				<tr>
					<td><strong>Father's Name</strong></td>
					<td>".$appdetail->fu_father_name."</td>
				</tr>
				<tr>
					<td><strong>Mother's Name</strong></td>
					<td>".$appdetail->fu_mother_name."</td>
				</tr>
				<tr>
					<td><strong>Apply Post</strong></td>
					<td>".$discip_details->catm_name."</td>
				</tr>
				<tr>
					<td><strong>Gender</strong></td>
					<td>".$appdetail->fu_gender."</td>
				</tr>";
				if($uaccess == "fu_dob"){
					$my_html = $my_html."<tr>
						<td><strong>Date of Birth</strong></td>
						<td>".date('d-m-Y',strtotime($appdetail->fu_dob))."</td>
					</tr>";
				}
				elseif($uaccess == "fu_address"){
					$my_html = $my_html."<tr>
					<td colspan=\"2\" style=\"width:100%;\">
						<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">

					<tr>
						<td colspan=\"5\"><strong>Present Address</strong></td>
					</tr>
					<tr>
					<td colspan=\"2\"><label><strong>State :</strong></label>";
					foreach ($state_list as $states) {
						if ($states->state_id == $appdetail->fu_state) { $my_html = $my_html.$states->state_name;break; }
					}
					$my_html = $my_html."</td>";
					if($appdetail->fu_state == 28){  
						$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>";
						foreach ($dist_list as $dists) { 
							if ($dists->district_code == $appdetail->fu_district) { $my_html = $my_html.$dists->district_name; }
						}
						$my_html = $my_html."</td>";
					}else{
						$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>".$appdetail->fu_other_district."</td>";
					}
					$my_html = $my_html."</tr>
					<tr>";
					if($appdetail->fu_state == 28){
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>";
						foreach ($sub_division as $sd) { 
							if ($appdetail->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html.$sd->subdiv_name; }
							}
							$my_html = $my_html."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong>:</label>"; 
						$bmset = '';
						foreach ($block_municipality as $bm) { 
							if ($bm->block_id == $appdetail->fu_block_municipality) {$bmset = $bm->block_name;}
						}
						$my_html = $my_html.$appdetail->fu_mb_type." (".$bmset.")</td>";
					}else{
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>". $appdetail->fu_other_sdiv."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong></label>".$appdetail->fu_other_blockm."</td>";
					}
					$my_html = $my_html."</tr>
						<tr>";
					if($appdetail->fu_state == 28){
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>";
						foreach ($police_station as $ps) { 
							if ($appdetail->fu_police_station == $ps->ps_id) {$my_html = $my_html.$ps->ps_name;}
						}
						$my_html = $my_html."</td>";
					}else{
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>".$appdetail->fu_other_ps."</td>";
					}
					$my_html = $my_html."<td colspan=\"3\"><label><strong>Ward/GP : </strong></label>".$appdetail->fu_ward_gp."</td>
					</tr>
					<tr>
						<td colspan=\"2\"><label><strong>Vill / Para / House No / Road :</strong></label>".$appdetail->fu_house_road."</td>
						<td colspan=\"3\"><label><strong>Post Office : </strong></label>".$appdetail->fu_post_office."</td>
					</tr>
					<tr>
						<td colspan=\"5\"><label><strong>Pin :</strong></label>".$appdetail->fu_pincode."</td>
					</tr>";
					if($appdetail->fu_same_address == "No"){
						$my_html = $my_html."<tr>
						<td colspan=\"5\"><strong>Permanenet Address</strong></td>
						</tr>
						<tr>
						<td colspan=\"2\"><label><strong>State :</strong></label>";
						foreach ($state_list as $states) {
							if ($states->state_id == $appdetail->fu_perma_state) { $my_html = $my_html.$states->state_name;break; }
							}
							$my_html = $my_html."</td>";
						if($appdetail->fu_perma_state == 28){  
							$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>";
							foreach ($dist_list as $dists) { 
							if ($dists->district_code == $appdetail->fu_perma_dist) { $my_html = $my_html.$dists->district_name;break; }
							}
							$my_html = $my_html."</td>";
						}else{
							$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>".$appdetail->fu_perma_other_district."</td>";
						}
						$my_html = $my_html."</tr>
						<tr>";
						if($appdetail->fu_perma_state == 28){
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>";
							foreach ($per_sub_division as $sd) { 
							if ($appdetail->fu_perma_sub_division == $sd->subdiv_id){ $my_html = $my_html.$sd->subdiv_name; }
							}
							$my_html = $my_html."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong>:</label>";
						$bmset = '';
						foreach ($per_block_municipality as $bm) { 
							if ($bm->block_id == $appdetail->fu_perma_block_municipality) {$bmset = $bm->block_name;}
							}
							$my_html = $my_html.$appdetail->fu_perma_mb_type." (".$bmset.")</td>";
						}else{
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>".$appdetail->fu_perma_other_sdiv."</td>
							<td colspan=\"3\"><label><strong>Block/ Municipality :</strong></label>".$appdetail->fu_perma_other_blockm."</td>";
						}
						$my_html = $my_html."</tr>
						<tr>";
						if($appdetail->fu_perma_state == 28){
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>";
							foreach ($per_police_station as $ps) { 
							if ($appdetail->fu_perma_police_station == $ps->ps_id) {$my_html = $my_html.$ps->ps_name;}
							}
							$my_html = $my_html."</td>";
						}else{
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>".$appdetail->fu_perma_other_ps."</td>";
						}
						$my_html = $my_html."<td colspan=\"3\"><label><strong>Ward/GP : </strong></label>".$appdetail->fu_perma_ward_gp."</td>
						</tr>
						<tr>
						<td colspan=\"2\"><label><strong>Vill / Para / House No / Road :</strong></label>".$appdetail->fu_perma_house_road."</td>
						<td colspan=\"3\"><label><strong>Post Office : </strong></label>".$appdetail->fu_perma_post_office."</td>
						</tr>
						<tr>
						<td colspan=\"5\"><label><strong>Pin :</strong></label>".$appdetail->fu_perma_pincode."</td>
						</tr>
						<tr>
						<td colspan=\"5\"><label><strong>Comunication Address :</strong></label>".$appdetail->fu_comunication_address." Address </td>
						</tr>";
					}else{
						$my_html = $my_html."<tr>
						<td colspan=\"5\"><label><strong>Permanenet Address is Same as Present Address</strong></label></td>
						</tr>";
					}
					$my_html = $my_html."</table></td></tr>";
				}
				elseif($uaccess == "fu_photo_doc"){

				}
				elseif($uaccess == "fu_signature_doc"){
					
				}
				elseif($uaccess == "fu_caste"){
					$my_html = $my_html."<tr>
						<td><strong>Has Caste</strong></td>
						<td>".$appdetail->caste_name."</td>
					</tr>";
					if($appdetail->fu_caste_type != 1){
						$castetypeset = '';
						foreach($caste_tab as $casitems){
							if($casitems->caste_id == $appdetail->fu_caste_type){
								$castetypeset = $casitems->caste_cat;
							}
						}
						if($castetypeset == 2){
							$my_html = $my_html."<tr>
								<td><strong>Caste Number</strong></td>
								<td>".$appdetail->fu_caste_number."</td>
							</tr>";
							$my_html = $my_html."<tr>
								<td><strong>Caste/ Tribe/ Community</strong></td>
								<td>".$caste_community->csdetail_name."</td>
							</tr>";
							
							$my_html = $my_html."<tr>
								<td><strong>Caste (Issue By)</strong></td>
								<td>";
									foreach ($caste_issuing_auth as $auth){
										if ($appdetail->fu_caste_issue_whom == $auth->cia_id) {$my_html = $my_html.$auth->cia_name;break;}
									}
									$my_html = $my_html."</td>
							</tr>
							<tr>
								<td><strong>Caste (Issue Date)</strong></td>
								<td>".date('d-m-Y',strtotime($appdetail->fu_caste_issue_date))."</td>
							</tr>";
						}
					}
					$my_html = $my_html."<tr>
					<td colspan=\"2\" style=\"width:100%;\">
						<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">

					<tr>
						<td colspan=\"5\"><strong>Present Address</strong></td>
					</tr>
					<tr>
					<td colspan=\"2\"><label><strong>State :</strong></label>";
					foreach ($state_list as $states) {
						if ($states->state_id == $appdetail->fu_state) { $my_html = $my_html.$states->state_name;break; }
					}
					$my_html = $my_html."</td>";
					if($appdetail->fu_state == 28){  
						$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>";
						foreach ($dist_list as $dists) { 
							if ($dists->district_code == $appdetail->fu_district) { $my_html = $my_html.$dists->district_name; }
						}
						$my_html = $my_html."</td>";
					}else{
						$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>".$appdetail->fu_other_district."</td>";
					}
					$my_html = $my_html."</tr>
					<tr>";
					if($appdetail->fu_state == 28){
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>";
						foreach ($sub_division as $sd) { 
							if ($appdetail->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html.$sd->subdiv_name; }
							}
							$my_html = $my_html."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong>:</label>"; 
						$bmset = '';
						foreach ($block_municipality as $bm) { 
							if ($bm->block_id == $appdetail->fu_block_municipality) {$bmset = $bm->block_name;}
						}
						$my_html = $my_html.$appdetail->fu_mb_type." (".$bmset.")</td>";
					}else{
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>". $appdetail->fu_other_sdiv."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong></label>".$appdetail->fu_other_blockm."</td>";
					}
					$my_html = $my_html."</tr>
						<tr>";
					if($appdetail->fu_state == 28){
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>";
						foreach ($police_station as $ps) { 
							if ($appdetail->fu_police_station == $ps->ps_id) {$my_html = $my_html.$ps->ps_name;}
						}
						$my_html = $my_html."</td>";
					}else{
						$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>".$appdetail->fu_other_ps."</td>";
					}
					$my_html = $my_html."<td colspan=\"3\"><label><strong>Ward/GP : </strong></label>".$appdetail->fu_ward_gp."</td>
					</tr>
					<tr>
						<td colspan=\"2\"><label><strong>Vill / Para / House No / Road :</strong></label>".$appdetail->fu_house_road."</td>
						<td colspan=\"3\"><label><strong>Post Office : </strong></label>".$appdetail->fu_post_office."</td>
					</tr>
					<tr>
						<td colspan=\"5\"><label><strong>Pin :</strong></label>".$appdetail->fu_pincode."</td>
					</tr>";
					if($appdetail->fu_same_address == "No"){
						$my_html = $my_html."<tr>
						<td colspan=\"5\"><strong>Permanenet Address</strong></td>
						</tr>
						<tr>
						<td colspan=\"2\"><label><strong>State :</strong></label>";
						foreach ($state_list as $states) {
							if ($states->state_id == $appdetail->fu_perma_state) { $my_html = $my_html.$states->state_name;break; }
							}
							$my_html = $my_html."</td>";
						if($appdetail->fu_perma_state == 28){  
							$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>";
							foreach ($dist_list as $dists) { 
							if ($dists->district_code == $appdetail->fu_perma_dist) { $my_html = $my_html.$dists->district_name;break; }
							}
							$my_html = $my_html."</td>";
						}else{
							$my_html = $my_html."<td colspan=\"3\"><label><strong>District :</strong></label>".$appdetail->fu_perma_other_district."</td>";
						}
						$my_html = $my_html."</tr>
						<tr>";
						if($appdetail->fu_perma_state == 28){
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>";
							foreach ($per_sub_division as $sd) { 
							if ($appdetail->fu_perma_sub_division == $sd->subdiv_id){ $my_html = $my_html.$sd->subdiv_name; }
							}
							$my_html = $my_html."</td>
						<td colspan=\"3\"><label><strong>Block/ Municipality :</strong>:</label>";
						$bmset = '';
						foreach ($per_block_municipality as $bm) { 
							if ($bm->block_id == $appdetail->fu_perma_block_municipality) {$bmset = $bm->block_name;}
							}
							$my_html = $my_html.$appdetail->fu_perma_mb_type." (".$bmset.")</td>";
						}else{
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Sub-Division :</strong></label>".$appdetail->fu_perma_other_sdiv."</td>
							<td colspan=\"3\"><label><strong>Block/ Municipality :</strong></label>".$appdetail->fu_perma_other_blockm."</td>";
						}
						$my_html = $my_html."</tr>
						<tr>";
						if($appdetail->fu_perma_state == 28){
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>";
							foreach ($per_police_station as $ps) { 
							if ($appdetail->fu_perma_police_station == $ps->ps_id) {$my_html = $my_html.$ps->ps_name;}
							}
							$my_html = $my_html."</td>";
						}else{
							$my_html = $my_html."<td colspan=\"2\"><label><strong>Police Station :</strong></label>".$appdetail->fu_perma_other_ps."</td>";
						}
						$my_html = $my_html."<td colspan=\"3\"><label><strong>Ward/GP : </strong></label>".$appdetail->fu_perma_ward_gp."</td>
						</tr>
						<tr>
						<td colspan=\"2\"><label><strong>Vill / Para / House No / Road :</strong></label>".$appdetail->fu_perma_house_road."</td>
						<td colspan=\"3\"><label><strong>Post Office : </strong></label>".$appdetail->fu_perma_post_office."</td>
						</tr>
						<tr>
						<td colspan=\"5\"><label><strong>Pin :</strong></label>".$appdetail->fu_perma_pincode."</td>
						</tr>
						<tr>
						<td colspan=\"5\"><label><strong>Comunication Address :</strong></label>".$appdetail->fu_comunication_address." Address </td>
						</tr>";
					}else{
						$my_html = $my_html."<tr>
						<td colspan=\"5\"><label><strong>Permanenet Address is Same as Present Address</strong></label></td>
						</tr>";
					}
					$my_html = $my_html."</table></td></tr>";
				}
				elseif($uaccess == "fu_pwd"){
					$my_html = $my_html."<tr>
						<td><strong>Is PWD</strong></td>
						<td>".$appdetail->fu_pwd."</td>
					</tr>";
					if($appdetail->fu_pwd == "Yes"){
						$my_html = $my_html."<tr>
							<td><strong>Percent of PWD</strong></td>
							<td>".$appdetail->fu_pwd_percent."</td>
						</tr>
						<tr>
							<td><strong>PWD (Issue By)</strong></td>
							<td>".$appdetail->fu_pwd_issue_whom."</td>
						</tr>
						<tr>
							<td><strong>PWD (Issue Date)</strong></td>
							<td>".date('d-m-Y',strtotime($appdetail->fu_pwd_issue_date))."</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_exempted"){
					if($appdetail->fu_exempted == "Yes"){
						$my_html = $my_html."<tr>
							<td><strong>Has Caste</strong></td>
							<td>".$appdetail->caste_name."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>Exempted Category</strong></td>
							<td>".$appdetail->fu_exempted."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>Description of Exempted</strong></td>
							<td>".$appdetail->fu_exc_reason."</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_exservice"){
					if($appdetail->fu_exservice == "Yes"){
						$my_html = $my_html."<tr>
							<td><strong>Has Caste</strong></td>
							<td>".$appdetail->caste_name."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>ExService Category</strong></td>
							<td>".$appdetail->fu_exservice."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>Description of ExService</strong></td>
							<td>".$appdetail->fu_exs_reason."</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_ews"){
					if($appdetail->fu_ews == "Yes"){
						$my_html = $my_html."<tr>
							<td><strong>Has Caste</strong></td>
							<td>".$appdetail->caste_name."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>Sportsman Category</strong></td>
							<td>".$appdetail->fu_ews."</td>
						</tr>";
						$my_html = $my_html."<tr>
							<td><strong>Description of Sportsman</strong></td>
							<td>".$appdetail->fu_ews_reason."</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_age_relax"){
					foreach($spclage_list as $spageitems){
						if($searchlist['sub_type'] == $spageitems->fu_ext_ageid){
							$my_html = $my_html."<tr>
								<td><strong>".$spageitems->caste_name."</strong></td>
								<td>".$spageitems->fu_ext_answer."</td>
							</tr>";
							if($spageitems->fu_ext_answer == "Yes"){
								$my_html = $my_html."<tr>
									<td><strong>Reason</strong></td>
									<td>".$spageitems->fu_ext_reason."</td>
								</tr>";
							}
						}
					}
				}
				elseif($uaccess == "fu_es_qualification"){
					if(!empty($quali_details)){
						$my_html = $my_html."<tr>
							<td colspan=\"2\">
							<div class=\"table-responsive\">
							<strong>Essential Qualification</strong><br/>
							<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">
								<tr>
								<td><b>Qualification</b></td>
								<td><b>Board/ Council/ University/ Journal</b></td>
								<td><b>State of Passing</b></td>
								<td><b>Full Marks</b></td>
								<td><b>Marks Obtained</b></td>
								<td><b>Percentage of Marks</b></td>";
								if($appdetail->adv_qualification_modify == "Yes"){
								$my_html = $my_html."<td><b>CHK Full Marks</b></td>
								<td><b>CHK Marks Obtained</b></td>
								<td><b>CHK Percentage of Marks</b></td>";
								}
								$my_html = $my_html."<td><b>Additional Attempt</b></td>
								<td><b>No. of Attempt</b></td>
								</tr>";
								foreach($quali_details as $qips){
									if($searchlist['sub_type'] == $qips->fu_qualifiaction_name){
								$my_html = $my_html."<tr>
									<td>".$qips->qm_name."</td>
									<td>".$qips->fu_council_board."</td>
									<td>".$qips->state_name."</td>
									<td>".$qips->fu_full_marks."</td>
									<td>".$qips->fu_marks_obtained."</td>
									<td>".$qips->fu_percent_of_marks."</td>";
									if($appdetail->adv_qualification_modify == "Yes"){
									$my_html = $my_html."<td>".$qips->fu_fullmark_ck."</td>
									<td>".$qips->fu_obtainmark_ck."</td>
									<td>".$qips->fu_percentmark_ck."</td>";
									}
									$my_html = $my_html."<td>".$qips->fu_is_attempt."</td>
									<td>".$qips->fu_attempt_no."</td>
								</tr>";
								break;}}
								$my_html = $my_html."</table>
							</div>
							</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_ds_qualification"){
					if(!empty($des_quali_details)){
						$my_html = $my_html."<tr>
							<td colspan=\"2\">
							<div class=\"table-responsive\">
							<strong>Desirable Qualification</strong><br/>
							<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">
								<tr>
								<td><b>Qualification</b></td>
								<td><b>Board/ Council/ University/ Journal</b></td>
								<td><b>State of Passing</b></td>
								<td><b>Full Marks</b></td>
								<td><b>Marks Obtained</b></td>
								<td><b>Percentage of Marks</b></td>";
								if($appdetail->adv_qualification_modify == "Yes"){
									$my_html = $my_html."<td><b>CHK Full Marks</b></td>
								<td><b>CHK Marks Obtained</b></td>
								<td><b>CHK Percentage of Marks</b></td>";
								}
								$my_html = $my_html."<td><b>Additional Attempt</b></td>
								<td><b>No. of Attempt</b></td>
								</tr>";
								foreach($des_quali_details as $qips){
									if($searchlist['sub_type'] == $qips->fud_qualifiaction_name){
									$my_html = $my_html."<tr>
									<td>".$qips->qm_name."</td>
									<td>".$qips->fud_council_board."</td>
									<td>".$qips->state_name."</td>
									<td>".$qips->fud_full_marks."</td>
									<td>".$qips->fud_marks_obtained."</td>
									<td>".$qips->fud_percent_of_marks."</td>";
									if($appdetail->adv_qualification_modify == "Yes"){
									$my_html = $my_html."<td>".$qips->fud_fullmark_ck."</td>
									<td>".$qips->fud_obtainmark_ck."</td>
									<td>".$qips->fud_percentmark_ck."</td>";
									}
									$my_html = $my_html."<td>".$qips->fud_is_attempt."</td>
									<td>".$qips->fud_attempt_no."</td>
									</tr>";
								break;}}
								$my_html = $my_html."</table>
							</div>
							</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_has_es_service"){
					$my_html = $my_html."<tr>
						<td><strong>Has Service Experience</strong></td>
						<td>".$appdetail->fu_has_service."</td>
					</tr>";
					if($appdetail->fu_has_service == "Yes"){
						$my_html = $my_html."<tr>
							<td colspan=\"2\">
							<strong>Essential Experience</strong><br/>
							<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">
								<tr>
								<td><strong>Sl No.</strong></td>
								<td><strong>Experience Category</strong></td>
								<td><strong>Organization</strong></td>
								<td><strong>Time Period</strong></td>
								</tr>";
								foreach($essenexp_details as $keys=>$expss){ 
									if($searchlist['sub_type'] == $expss->fues_exp_workname){
										$my_html = $my_html."<tr>
										<td>".($keys+1)."</td>
										<td>".$expss->expset_name."</td>
										<td>".$expss->fues_exp_org_name."</td>
										<td>".$expss->fues_exp_year." Year & ".$expss->fues_exp_month." Month</td>
										</tr>";
								break;}}
								$my_html = $my_html."</table>
							</td>
						</tr>";
					}
				}
				elseif($uaccess == "fu_has_ds_service"){
					$my_html = $my_html."<tr>
						<td><strong>Has Service Experience</strong></td>
						<td>".$appdetail->fu_has_service."</td>
					</tr>";
					if($appdetail->fu_has_service == "Yes"){
						if(!empty($exp_details)){
							$my_html = $my_html."<tr>
								<td colspan=\"2\">
								<strong>Desireable Experience</strong><br/>
								<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 22px;\">
									<tr>
									<td><strong>Sl No.</strong></td>
									<td><strong>Experience Category</strong></td>
									<td><strong>Organization</strong></td>
									<td><strong>Time Period</strong></td>
									</tr>";
									foreach($exp_details as $keys=>$expss){ 
										if($searchlist['sub_type'] == $expss->fu_exp_workname){
											$my_html = $my_html."<tr>
											<td>".($keys+1)."</td>
											<td>".$expss->expset_name."</td>
											<td>".$expss->fu_exp_org_name."</td>
											<td>".$expss->fu_exp_year." Year & ".$expss->fu_exp_month." Month</td>
											</tr>";
									}}
									$my_html = $my_html."</table>
								</td>
							</tr>";
						}
					}
				}
				$my_html = $my_html."</table>
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

	
	
}
