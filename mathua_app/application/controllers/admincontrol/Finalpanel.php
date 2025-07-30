<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finalpanel extends Admin_Controller {
	
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
		redirect('admincontrol/finalpanel/finalcandidate_marit_list');
    }

	public function finalcandidate_marit_list(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Listing For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set, 'gen_set'=>$gen_set);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				$chksets = $this->candidates_m->getall_adv_Candidates_Merit_listing_sectionwise($advno, $advcat_name, $gen_set);
				if(count((array)$chksets) > 0){
					$this->data['meritlist'] = $chksets;
				}else{
					$this->data['meritlist'] = array();
					$this->data['error'] = "No Record Found for your search Criteria.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/view_merit_list', $this->data);
	}
	

	public function generate_candidate_maritlist(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Generate For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set, 'gen_set'=>$gen_set);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);

				$this->load->model('member_m');
				if($this->candidates_m->checkall_adv_Candidates_forMerit_listing($advno, $advcat_name, $gen_set) == TRUE){
					$final_exam_arr = array();
					$final_examsets = $this->candidates_m->get_allFinalExam_from_Adv_for_meritlisting($advno);
					foreach($final_examsets as $fexm){
						$final_exam_arr[] = $fexm->aquali_exam;
					}
					if(count($final_exam_arr) == 0){
						//$final_exam_arr = NULL;
						$this->data['error'] = "Final Qualification not Found in the Advertisement. Check Again.";
					}else{
					
						$adv_result_candidates = $this->candidates_m->get_all_advwise_Candidates_forMerit_listing($advno, $advcat_name, $final_exam_arr);
						//$adv_detail = $this->db->get_where('advertisement_master',array('adv_auto_genno'=>$advno))->row();
						$genset_arr = array(NULL, "UR", "UR-EC", "UR-EXS-C", "UR-EXS-D", "UR-MSP", "SC", "SC-EC", "SC-EXS-C", "SC-EXS-D", "ST", "ST-EC", "ST-EXS-D", "OBC", "OBC-A", "OBC-A-EC", "OBC-A-EXS-D", "OBC-B", "OBC-B-EC", "OBC-B-EXS-D", "PWD");
						$res_array = array();
						foreach($adv_result_candidates as $cansets){
							
							if($genset_arr[$gen_set] == "UR" || $genset_arr[$gen_set] == "UR-EC" || $genset_arr[$gen_set] == "UR-EXS-C" || $genset_arr[$gen_set] == "UR-EXS-D" || $genset_arr[$gen_set] == "UR-MSP"){

								if($genset_arr[$gen_set] == "UR-EC" && $cansets->fu_caste_type == 35){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "UR-EXS-C" && $cansets->fu_caste_type == 36){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "UR-EXS-D" && $cansets->fu_caste_type == 37){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "UR-MSP" && $cansets->fu_caste_type == 38){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "UR"){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}elseif($genset_arr[$gen_set] == "SC" || $genset_arr[$gen_set] == "SC-EC" || $genset_arr[$gen_set] == "SC-EXS-C" || $genset_arr[$gen_set] == "SC-EXS-D"){

								if($genset_arr[$gen_set] == "SC" && ($cansets->fu_caste_type == 2 || $cansets->fu_caste_type == 39 || $cansets->fu_caste_type == 40 || $cansets->fu_caste_type == 41)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "SC-EC" && $cansets->fu_caste_type == 39){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-C" && $cansets->fu_caste_type == 40){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-D" && $cansets->fu_caste_type == 41){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}elseif($genset_arr[$gen_set] == "ST" || $genset_arr[$gen_set] == "ST-EC" || $genset_arr[$gen_set] == "ST-EXS-D"){
								
								if($genset_arr[$gen_set] == "ST" && ($cansets->fu_caste_type == 3 || $cansets->fu_caste_type == 42 || $cansets->fu_caste_type == 43)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "SC-EC" && $cansets->fu_caste_type == 42){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-D" && $cansets->fu_caste_type == 43){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}
								
							}elseif($genset_arr[$gen_set] == "OBC"){

								if($cansets->fu_caste_type == 4){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}elseif($genset_arr[$gen_set] == "OBC-A" || $genset_arr[$gen_set] == "OBC-A-EC" || $genset_arr[$gen_set] == "OBC-A-EXS-D"){

								if($genset_arr[$gen_set] == "OBC-A" && ($cansets->fu_caste_type == 5 || $cansets->fu_caste_type == 44 || $cansets->fu_caste_type == 45)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "OBC-A-EC" && $cansets->fu_caste_type == 44){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "OBC-A-EXS-D" && $cansets->fu_caste_type == 45){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}elseif($genset_arr[$gen_set] == "OBC-B" || $genset_arr[$gen_set] == "OBC-B-EC" || $genset_arr[$gen_set] == "OBC-B-EXS-D"){

								if($genset_arr[$gen_set] == "OBC-B" && ($cansets->fu_caste_type == 6 || $cansets->fu_caste_type == 46 || $cansets->fu_caste_type == 47)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "OBC-B-EC" && $cansets->fu_caste_type == 46){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}elseif($genset_arr[$gen_set] == "OBC-B-EXS-D" && $cansets->fu_caste_type == 47){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}elseif($genset_arr[$gen_set] == "PWD"){

								if($cansets->fu_pwd == "Yes"){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no
									);
								}

							}
							
						}
						/*echo "<pre>";
						print_r($res_array);
						exit;*/
						if(count($res_array) > 0){
							
							$chk_counter = 0;
							for($ii=0;$ii<count($res_array);$ii++){

								$row_arrayset = array(
									'mr_adv_master' => $advno,
									'mr_cand_app_no' => $res_array[$ii]['candidate_refno'],
									'mr_category' => $advcat_name,
									'mr_listing' => $gen_set,
									'mr_createdate' => date("Y-m-d H:i:s"),
									'mr_createby' => $this->session->userdata['uid']
								);
								if($this->candidates_m->addmodify_MeritList_ByAdmin($row_arrayset) == FALSE){
									$chk_counter++;
								}
							}
							if($chk_counter == 0){
								$this->session->set_flashdata("success","Merit List is Generated Successfully.");
								redirect('admincontrol/finalpanel/generate_candidate_maritlist');
							}else{
								$this->db->delete('merit_list_tab', array('mr_adv_master' => $advno, 'mr_category' => $advcat_name, 'mr_listing' => $gen_set));
								$this->data['error'] = "There have some Problem to Insert Merit List, Try Again.";
							}
						}else{
							$this->data['error'] = "No Candidate found for Merit List Processing.";
						}
					
					}
					
				}else{
					$this->data['error'] = "Already Merit List Generated for the Advertisement.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/generate_merit_list', $this->data);
	}
	
	public function get_allcandidate_forpanel_setup(){
		if($_POST){
		  $rf_set = $this->input->post("rf_set");
		  $advno = $this->input->post("advno");
  
		  $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
		  $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
  
		  if($this->form_validation->run()){
			$cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
			$cat_details_sets = '';
			//$cat_item_sets = '';
			//$category_arr = array();
			foreach($cat_details as $catg){
			  $cat_details_sets = $cat_details_sets . '<option value="'.$catg->acat_id.'">' .$catg->catm_name. '</option>';
			  //$item_cat_count = $this->candidates_m->checkCandidate_forInterview_sectionset($advno, $catg->acat_id);
			  //$cat_item_sets = $cat_item_sets."<br/>".$item_cat_count." - Record Found For ".$catg->catm_name;
			  //$category_arr[$catg->acat_id] = $item_cat_count;
			}
			//$result_details = $this->candidates_m->checkCandidate_forInterview_sectionset($advno);
			echo json_encode(array('msg' => 1, 'category_set' => $cat_details_sets));
		  }else{
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		  }
		  exit;
		}else{
		  redirect('default404');
		}
  
	}


	public function holdssss_generate_candidate_maritlist242342342367676767(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Generate For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->load->model('member_m');
				if($this->candidates_m->checkall_adv_Candidates_forMerit_listing($advno, $gen_set) == TRUE){

					$adv_result_candidates = $this->candidates_m->get_all_advwise_Candidates_forMerit_listing($advno);
					$adv_detail = $this->db->get_where('advertisement_master',array('adv_auto_genno'=>$advno))->row();
					$getall_ageset = $this->member_m->gatAll_subscriptionAge_list($advno);
					$castelists = $this->db->where('caste_status',1)->where('caste_id != ',1)->where_in('caste_cat',array(2))->get('caste_tab')->result();
					$castearray = array();
					foreach($castelists as $castesets){
						$castearray[] = $castesets->caste_id;
					}
					//print_r($castearray);exit;
					$existing_limit_update = $exact_last = $adv_detail->adv_age_limit;
					$genset_arr = array(NULL, "UR", "UR-EC", "UR-EXS-C", "UR-EXS-D", "UR-MSP", "SC", "SC-EC", "SC-EXS-C", "SC-EXS-D", "ST", "ST-EC", "ST-EXS-D", "OBC", "OBC-A", "OBC-A-EC", "OBC-A-EXS-D", "OBC-B", "OBC-B-EC", "OBC-B-EXS-D", "PWD");
					$res_array = array();
					foreach($adv_result_candidates as $cansets){
						if(count((array)$getall_ageset) > 0){
							
							$cand_checking_rows = $this->db->get_where('checking_tab',array('chk_user_application'=>$cansets->f_application_no))->result();
							$agereject_arr = array();
							foreach($cand_checking_rows as $esa_items){
								if($esa_items->chk_type == "fu_age_relax" && $esa_items->chk2_approve == "Rejected" && $esa_items->chk_final_state == "Rejected"){
									$agereject_arr[] = $esa_items->chk_sub_typeid;
								}
							}
							//$getextraageset = $this->member_m->getAll_Existing_ExtraAgeSets_All_forAdmin($cansets->f_uid);
							$getextraageset = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($cansets->f_application_no, "Yes");
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
									
									if($genset_arr[$gen_set] == "SC"){
										if($agearray[$dd]->advage_section == $cansets->fu_caste_type){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}elseif($genset_arr[$gen_set] == "SC-EC" || $genset_arr[$gen_set] == "SC-EXS-C" || $genset_arr[$gen_set] == "SC-EXS-D"){
										if($agearray[$dd]->advage_section == $agearray[$dd]->caste_parent){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}

									if($genset_arr[$gen_set] == "ST"){
										if($agearray[$dd]->advage_section == $cansets->fu_caste_type){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}elseif($genset_arr[$gen_set] == "ST-EC" || $genset_arr[$gen_set] == "ST-EXS-D"){
										if($agearray[$dd]->advage_section == $agearray[$dd]->caste_parent){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}

									if($genset_arr[$gen_set] == "OBC"){
										if($agearray[$dd]->advage_section == $cansets->fu_caste_type){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}

									if($genset_arr[$gen_set] == "OBC-A"){
										if($agearray[$dd]->advage_section == $cansets->fu_caste_type){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}elseif($genset_arr[$gen_set] == "OBC-A-EC" || $genset_arr[$gen_set] == "OBC-A-EXS-D"){
										if($agearray[$dd]->advage_section == $agearray[$dd]->caste_parent){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}

									if($genset_arr[$gen_set] == "OBC-B"){
										if($agearray[$dd]->advage_section == $cansets->fu_caste_type){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}elseif($genset_arr[$gen_set] == "OBC-B-EC" || $genset_arr[$gen_set] == "OBC-B-EXS-D"){
										if($agearray[$dd]->advage_section == $agearray[$dd]->caste_parent){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}

								}

								if($agearray[$dd]->advage_section == 7){
									if($genset_arr[$gen_set] == "PWD"){
										if($cansets->fu_pwd == "Yes"){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}	
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}
								}

								if($agearray[$dd]->advage_section == 8){
									if($genset_arr[$gen_set] == "UR-EC" || $genset_arr[$gen_set] == "SC-EC" || $genset_arr[$gen_set] == "ST-EC" || $genset_arr[$gen_set] == "OBC-A-EC" || $genset_arr[$gen_set] == "OBC-B-EC"){
										if($cansets->fu_exempted == "Yes"){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}	
								}
								if($agearray[$dd]->advage_section == 9){
									if($genset_arr[$gen_set] == "UR-EXS-C" || $genset_arr[$gen_set] == "UR-EXS-D" || $genset_arr[$gen_set] == "SC-EXS-C" || $genset_arr[$gen_set] == "SC-EXS-D" || $genset_arr[$gen_set] == "ST-EXS-D" || $genset_arr[$gen_set] == "OBC-A-EXS-D" || $genset_arr[$gen_set] == "OBC-B-EXS-D"){
										if($cansets->fu_exservice == "Yes"){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}	
									}else{
										$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
									}
								}
								if($agearray[$dd]->advage_section == 10){
									if($genset_arr[$gen_set] == "UR-MSP"){
										if($cansets->fu_ews == "Yes"){
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",$agearray[$dd]->advage_up, $stringmix);
										}else{
											$stringmix = str_replace("||".$agearray[$dd]->advage_section."||",0, $stringmix);
										}
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
								$totalage_increment = $totalage_increment + (int)$maxnumber_find;
							}

							if($adv_detail->adv_age_updown > 0){
								if($totalage_increment > $adv_detail->adv_age_updown){
									$totalage_increment = $adv_detail->adv_age_updown;
								}
							}
							if($totalage_increment > 0){
								$existing_limit_update = date('Y-m-d', strtotime($adv_detail->adv_age_limit. ' -'.$totalage_increment.' years'));
							}

							/*$res_array[] = array(
								'candidate_refno' => $cansets->f_application_no,
								'candidate_dob' => $cansets->fu_dob,
								'age_discount' => $totalage_increment
							);*/

						}else{
							/*$res_array[] = array(
								'candidate_refno' => $cansets->f_application_no,
								'candidate_dob' => $cansets->fu_dob,
								'age_discount' => 0
							);*/
						}
						$fu_dob = date('Y-m-d',strtotime($cansets->fu_dob));
						if($adv_detail->adv_min_age_limit >= $fu_dob && $existing_limit_update <= $fu_dob){
							if($genset_arr[$gen_set] == "UR" || $genset_arr[$gen_set] == "UR-EC" || $genset_arr[$gen_set] == "UR-EXS-C" || $genset_arr[$gen_set] == "UR-EXS-D" || $genset_arr[$gen_set] == "UR-MSP"){

								if($genset_arr[$gen_set] == "UR-EC" && $cansets->fu_caste_type == 35){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "UR-EXS-C" && $cansets->fu_caste_type == 36){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "UR-EXS-D" && $cansets->fu_caste_type == 37){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "UR-MSP" && $cansets->fu_caste_type == 38){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "UR"){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}elseif($genset_arr[$gen_set] == "SC" || $genset_arr[$gen_set] == "SC-EC" || $genset_arr[$gen_set] == "SC-EXS-C" || $genset_arr[$gen_set] == "SC-EXS-D"){

								if($genset_arr[$gen_set] == "SC" && ($cansets->fu_caste_type == 2 || $cansets->fu_caste_type == 39 || $cansets->fu_caste_type == 40 || $cansets->fu_caste_type == 41)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "SC-EC" && $cansets->fu_caste_type == 39){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-C" && $cansets->fu_caste_type == 40){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-D" && $cansets->fu_caste_type == 41){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}elseif($genset_arr[$gen_set] == "ST" || $genset_arr[$gen_set] == "ST-EC" || $genset_arr[$gen_set] == "ST-EXS-D"){
								
								if($genset_arr[$gen_set] == "ST" && ($cansets->fu_caste_type == 3 || $cansets->fu_caste_type == 42 || $cansets->fu_caste_type == 43)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "SC-EC" && $cansets->fu_caste_type == 42){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "SC-EXS-D" && $cansets->fu_caste_type == 43){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}
								
							}elseif($genset_arr[$gen_set] == "OBC"){

								if($cansets->fu_caste_type == 4){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}elseif($genset_arr[$gen_set] == "OBC-A" || $genset_arr[$gen_set] == "OBC-A-EC" || $genset_arr[$gen_set] == "OBC-A-EXS-D"){

								if($genset_arr[$gen_set] == "OBC-A" && ($cansets->fu_caste_type == 5 || $cansets->fu_caste_type == 44 || $cansets->fu_caste_type == 45)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "OBC-A-EC" && $cansets->fu_caste_type == 44){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "OBC-A-EXS-D" && $cansets->fu_caste_type == 45){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}elseif($genset_arr[$gen_set] == "OBC-B" || $genset_arr[$gen_set] == "OBC-B-EC" || $genset_arr[$gen_set] == "OBC-B-EXS-D"){

								if($genset_arr[$gen_set] == "OBC-B" && ($cansets->fu_caste_type == 6 || $cansets->fu_caste_type == 46 || $cansets->fu_caste_type == 47)){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "OBC-B-EC" && $cansets->fu_caste_type == 46){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}elseif($genset_arr[$gen_set] == "OBC-B-EXS-D" && $cansets->fu_caste_type == 47){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}elseif($genset_arr[$gen_set] == "PWD"){

								if($cansets->fu_pwd == "Yes"){
									$res_array[] = array(
										'candidate_refno' => $cansets->f_application_no,
										'candidate_dob' => $cansets->fu_dob,
										//'candidate_lastdate' => $exact_last,
										'candidate_marks' => $cansets->cr_total_marks,
										'age_discount' => $totalage_increment
									);
								}

							}
						}
					}
					//$res_array_update = array();
					if(count($res_array) > 0){
						foreach ($res_array as $key => $row) {
							$dob_arr[$key]  = $row['candidate_dob'];
							$mark_arr[$key] = $row['candidate_marks'];
						}
						array_multisort($mark_arr, SORT_DESC, $dob_arr, SORT_ASC, $res_array);
						$chk_counter = 0;
						for($ii=0;$ii<count($res_array);$ii++){

							$row_arrayset = array(
								'mr_adv_master' => $advno,
								'mr_cand_app_no' => $res_array[$ii]['candidate_refno'],
								'mr_listing' => $gen_set,
								'mr_createdate' => date("Y-m-d H:i:s"),
								'mr_createby' => $this->session->userdata['uid']
							);
							if($this->candidates_m->addmodify_MeritList_ByAdmin($row_arrayset) == FALSE){
								$chk_counter++;
							}
						}
						if($chk_counter == 0){
							echo "ALL OK";
							exit;
						}else{
							$this->data['error'] = "There have some Problem to Insert Merit List, Try Again.";
						}
					}else{
						$this->data['error'] = "No Candidate found for Merit List Processing.";
					}
					//echo "<pre>";
					//print_r($res_array);
					//exit;
				}else{
					$this->data['error'] = "Already Merit List Generated for the Advertisement.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/generate_merit_list', $this->data);
	}

	protected function alldate_compare($element1, $element2) {
		$datetime1 = strtotime($element1['datetime']);
		$datetime2 = strtotime($element2['datetime']);
		return $datetime1 - $datetime2;
	} 


	public function generate_finalpanel_candidate(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			$vac_total = $this->input->post("vac_total");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Generate For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('vac_total', 'Vacancy', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE){
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set, 'gen_set'=>$gen_set);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);

				$countdownsets = 0;
				$genset_arr = array(NULL, "UR", "UR-EC", "UR-EXS-C", "UR-EXS-D", "UR-MSP", "SC", "SC-EC", "SC-EXS-C", "SC-EXS-D", "ST", "ST-EC", "ST-EXS-D", "OBC", "OBC-A", "OBC-A-EC", "OBC-A-EXS-D", "OBC-B", "OBC-B-EC", "OBC-B-EXS-D", "PWD");
				$vacancy_details = $this->candidates_m->getAll_Vacancy_detaillist_of_Avvertisement($advno, $advcat_name, $genset_arr[$gen_set]);
				$panel_detail = $this->db->where('fpn_advno', $advno)->where('fpn_category', $advcat_name)->where('fpn_section', $gen_set)->get('final_panel_tab')->result();
				if($vacancy_details->totalno > count((array)$panel_detail)){

					$countdownsets = $vacancy_details->totalno - count((array)$panel_detail);
					if($countdownsets >= $vac_total){
						$chksets = $this->candidates_m->getall_adv_Candidates_Merit_listing_sectionwise($advno, $advcat_name, $gen_set, 1);
						if(count((array)$chksets) > 0){
							$paneled_counter = 0;
							foreach($chksets as $keys=>$p_cand){
								if($vac_total > $keys){
									$rows_arr = array(
										'fpn_advno' => $advno,
										'fpn_candref_no' => $p_cand->f_application_no,
										'fpn_category' => $advcat_name,
										'fpn_section' => $gen_set,
										'fpn_createdate' => date("Y-m-d H:i:s"),
										'fpn_createby' => $this->session->userdata['uid']
									);
									if($this->candidates_m->addmodify_FINAL_Panel_ByAdmin($rows_arr, $p_cand->f_application_no) == TRUE){
										$paneled_counter++;
									}
								}else{
									break;
								}
							}
							if($vac_total >= $paneled_counter){
								$this->session->set_flashdata("success","Final Panel List is Generated Successfully.");
								redirect('admincontrol/finalpanel/generate_finalpanel_candidate');
							}else{
								$this->data['error'] = "Panel Generation problem occured, Check Again.";
							}
						}else{
							$this->data['error'] = "Candidate not Available for Panel Generation. Check Again.";
						}
					}else{
						$this->data['error'] = "Vacancy is greater than Existing for generation. Check Again.";
					}

				}else{
					$this->data['error'] = "Vacancy Already Full for Panel Generation. Check Again.";
				}

			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/generate_final_panel', $this->data);
	}

	public function final_panelled_list(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Listing For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set, 'gen_set'=>$gen_set);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise($advno, $advcat_name, $gen_set);
				if(count((array)$chksets) > 0){
					$this->data['meritlist'] = $chksets;
				}else{
					$this->data['meritlist'] = array();
					$this->data['error'] = "No Record Found for your search Criteria.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/final_panel_list', $this->data);
	}

	public function print_meritlist_candidate($advno, $advcat_name, $gen_set){
		ini_set('default_socket_timeout', 6000);
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_Merit_listing_sectionwise($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}
		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'MeritList';
		$obj_pdf->SetTitle('Advertisement - Meritlist');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Merit List');

		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">For ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>";
				if($section_detail->caste_name == "Unreserved"){
					$my_html = $my_html."<span align=\"center\"><b><u>Overall Performance of all eligible candidates including those who are selected in the Panel</u></b></span><br/>";
				}else{
					$my_html = $my_html."<span align=\"center\"><b><u>MERIT LIST (".$section_detail->caste_name.")</u></b></span><br/>";
				}
				$my_html = $my_html."</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 8%\"><b>Sl No.</b></td>
				<td style=\"width: 25%\"><b>Full Name</b></td>
				<td style=\"width: 20%\"><b>Registration No.</b></td>
				<td style=\"width: 12%\"><b>Date of Birth</b></td>
				<td style=\"width: 15%\"><b>Caste</b></td>
				<td style=\"width: 10%\"><b>PWD</b></td>
				<td style=\"width: 10%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
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

	}

	public function htmlview_meritlist_candidate_v2($advno, $advcat_name, $gen_set){
		
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_Merit_listing_sectionwise($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}
		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		

		$my_html = "<div class=\"header321\">
		<table style=\"width: 100%\" style=\"font-size: 16px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 16px;\">
				<tr>
				<td style=\"width:100%;\">
					<div align=\"center\">
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:16px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">For ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>";
				if($section_detail->caste_name == "Unreserved"){
					$my_html = $my_html."<div align=\"center\"><b><u>Overall Performance of all eligible candidates including those who are selected in the Panel</u></b></div><br/>";
				}else{
					$my_html = $my_html."<div align=\"center\"><b><u>MERIT LIST (".$section_detail->caste_name.")</u></b></div><br/>";
				}
				$my_html = $my_html."</td>
		</tr>
		<tr>
			<td class=\"printsethtml\" colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-size: 12px;\">
				<tr style=\"font-size: 12px;\">
				<td style=\"width: 8%\"><b>Sl No.</b></td>
				<td style=\"width: 25%\"><b>Full Name</b></td>
				<td style=\"width: 20%\"><b>Registration No.</b></td>
				<td style=\"width: 12%\"><b>Date of Birth</b></td>
				<td style=\"width: 15%\"><b>Caste</b></td>
				<td style=\"width: 10%\"><b>PWD</b></td>
				<td style=\"width: 10%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 
						$my_html = $my_html."<tr style=\"font-size: 12px;\">
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
				}
				$my_html = $my_html."</table>
			</td>
		</tr>
		</table>
		</div>";
		$this->data['content_all'] = $my_html; //ob_get_contents();
		$this->load->view('admin/f_panel/merit_html_view', $this->data);
	}

	public function print_the_finalpanel_lsitsets($advno, $advcat_name, $gen_set){
		ini_set('default_socket_timeout', 6000);
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}
		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		//print_r($dicipline_detail->catm_name);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Panellist';
		$obj_pdf->SetTitle('Advertisement - Panel');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Panel List');

		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
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
		$obj_pdf->AddPage(); //".date('d.m.Y', strtotime($app_details->adv_start_time. ' -1 day'))."

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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
				<span align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></span><br/>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 8%\"><b>Sl No.</b></td>
				<td style=\"width: 25%\"><b>Full Name</b></td>
				<td style=\"width: 20%\"><b>Registration No.</b></td>
				<td style=\"width: 12%\"><b>Date of Birth</b></td>
				<td style=\"width: 15%\"><b>Caste</b></td>
				<td style=\"width: 8%\"><b>PWD</b></td>
				<td style=\"width: 12%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
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

	}

	public function print_the_finalpanel_set2_section_lsits($advno, $advcat_name, $gen_set){
		ini_set('default_socket_timeout', 6000);
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_v2_listing_sectionwise($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}

		$state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
		$dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

		



		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark_v2('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Panel_V-2';
		$obj_pdf->SetTitle('Advertisement - Panel');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Panel List');

		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
				<span align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></span><br/>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 5%\"><b>Sl No.</b></td>
				<td style=\"width: 10%\"><b>Full Name</b></td>
				<td style=\"width: 10%\"><b>Registration No.</b></td>
				<td style=\"width: 5%\"><b>Date of Birth</b></td>
				<td style=\"width: 7%\"><b>Mobile</b></td>
				<td style=\"width: 11%\"><b>Address</b></td>
				<td style=\"width: 7%\"><b>Caste</b></td>
				<td style=\"width: 4%\"><b>PWD</b></td>
				<td style=\"width: 12%\"><b>Qualification</b></td>
				<td style=\"width: 12%\"><b>Experience</b></td>
				<td style=\"width: 11%\"><b>Spcl. Age Relaxation</b></td>
				<td style=\"width: 6%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 

						$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($quaries->f_application_no);
						$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($quaries->f_application_no);
						$exp_details = $this->candidates_m->goto_Check_Candidate_Ds_Experience_total($quaries->f_application_no);
						//$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($quaries->f_application_no);
						//$essenexp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($quaries->f_application_no);
						$essenexp_details = $this->candidates_m->goto_Check_Candidate_Ess_Experience_total($quaries->f_application_no);
						$spclage_list = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($quaries->f_application_no);
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->f_mobile."</td>
						<td>";
						if ($quaries->fu_district != NULL) {
							$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $quaries->fu_district))->result();
							$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $quaries->fu_district))->result();
						}
						/*if ($quaries->fu_perma_dist != NULL) {
							$per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $quaries->fu_perma_dist))->result();
							$per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $quaries->fu_perma_dist))->result();
						}
						if ($quaries->fu_perma_sub_division != NULL && $quaries->fu_perma_mb_type != NULL) {
							$per_mb_type = $quaries->fu_perma_mb_type;
							$per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $quaries->fu_perma_sub_division, 'block_type' => $quaries->fu_perma_mb_type))->result();
						}*/
						if ($quaries->fu_sub_division != NULL && $quaries->fu_mb_type != NULL) {
							$mb_type = $quaries->fu_mb_type;
							$block_municipality = $this->db->get_where('block_master', array('subd_id' => $quaries->fu_sub_division, 'block_type' => $quaries->fu_mb_type))->result();
						}

						foreach ($state_list as $states) {
							if ($states->state_id == $quaries->fu_state) { $my_html = $my_html . "State : " .$states->state_name;break; }
						}
						if($quaries->fu_state == 28){  
							foreach ($dist_list as $dists) { 
								if ($dists->district_code == $quaries->fu_district) { $my_html = $my_html . ", District : " . $dists->district_name; }
							}
						}else{
							$my_html = $my_html . ", District : ".$quaries->fu_other_district;
						}
	
						if($quaries->fu_state == 28){
							foreach ($sub_division as $sd) {
								if ($quaries->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . ", Sub-Division :" . $sd->subdiv_name; }
							}
							$bmset = '';
							foreach ($block_municipality as $bm) { 
								if ($bm->block_id == $quaries->fu_block_municipality) {$bmset = $bm->block_name;}
							}
							if($bmset != ''){
								$my_html = $my_html . ", Block/ Municipality : " . $quaries->fu_mb_type.' ('.$bmset.')';
							}
						}else{
							$my_html = $my_html . ", Sub-Division : ".$quaries->fu_other_sdiv;
							$my_html = $my_html . ", Block/ Municipality : ".$quaries->fu_other_blockm;
						}
	
						if($quaries->fu_state == 28){
							foreach ($police_station as $ps) {
								if ($quaries->fu_police_station == $ps->ps_id) {$my_html = $my_html .", Police Station : ". $ps->ps_name;}
							}
						}else{
							$my_html = $my_html . ", Police Station : ".$quaries->fu_other_ps;
						}
						$my_html = $my_html . ", Ward/GP : ".$quaries->fu_ward_gp.", Vill / Para / House No / Road : ".$quaries->fu_house_road.", Post Office : ".$quaries->fu_post_office.", Pin : ".$quaries->fu_pincode;
						$my_html = $my_html."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>";
						foreach($quali_details as $keys=>$qips){
							$my_html = $my_html . $qips->qm_name . " (" . $qips->fu_percent_of_marks . "%)<hr/>";
						}
						foreach($des_quali_details as $keyss=>$ddqips){
							$my_html = $my_html . $ddqips->qm_name . " (" . $ddqips->fud_percent_of_marks . "%)<hr/>";
						}
						$my_html = $my_html."</td><td>";
						/*foreach($essenexp_details as $key1=>$expss){
							if($expss->fues_exp_approval == "Approved"){
								if($key1 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $expss->expset_name . " (" . $expss->fues_exp_year." Yr & ".$expss->fues_exp_month . " Month)";
							}
						}
						foreach($exp_details as $key2=>$ddexpss){
							if($expss->fu_exp_approval == "Approved"){
								if($key2 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $ddexpss->expset_name . " (" . $ddexpss->fu_exp_year." Yr & ".$ddexpss->fu_exp_month . " Month)";
							}
						}*/
						foreach($essenexp_details as $expss){
							if($expss->t_month >= 12){
								$ttyear = $expss->t_yr + ($expss->t_month / 12);
								$ttmonth = ($expss->t_month % 12);
							}else{
								$ttyear = $expss->t_yr;
								$ttmonth = $expss->t_month;
							}
							$my_html = $my_html . $expss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						foreach($exp_details as $ddexpss){
							if($ddexpss->t_month >= 12){
								$ttyear = $ddexpss->t_yr + ($ddexpss->t_month / 12);
								$ttmonth = ($ddexpss->t_month % 12);
							}else{
								$ttyear = $ddexpss->t_yr;
								$ttmonth = $ddexpss->t_month;
							}
							$my_html = $my_html . $ddexpss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						$my_html = $my_html."</td><td>";
						foreach($spclage_list as $spageitems){
							if($spageitems->fu_ext_answer == "Yes"){
								$my_html = $my_html . $spageitems->caste_name."<hr/>";
							}
						}
						$my_html = $my_html."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
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

	}

	public function htmlview_the_finalpanel_set2_section_lsits_sqlsets($advno, $advcat_name, $gen_set){
		
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_v2_listing_sectionwise_v2($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}

		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		
		//print_r($chksets);exit;

		$my_html = "<div class=\"header321\">
		<table style=\"width: 100%\" style=\"font-size: 16px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 16px;\">
				<tr>
				<td style=\"width:100%;\">
					<div align=\"center\">
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:16px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
				<div align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></div><br/>
			</td>
		</tr>
		<tr>
			<td class=\"printsethtml\" colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-size: 12px;\">
				<tr style=\"font-size: 12px;\">
				<td style=\"width: 5%\"><b>Sl No.</b></td>
				<td style=\"width: 10%\"><b>Full Name</b></td>
				<td style=\"width: 10%\"><b>Registration No.</b></td>
				<td style=\"width: 5%\"><b>Date of Birth</b></td>
				<td style=\"width: 7%\"><b>Mobile</b></td>
				<td style=\"width: 11%\"><b>Address</b></td>
				<td style=\"width: 7%\"><b>Caste</b></td>
				<td style=\"width: 4%\"><b>PWD</b></td>
				<td style=\"width: 12%\"><b>Qualification</b></td>
				<td style=\"width: 12%\"><b>Experience</b></td>
				<td style=\"width: 11%\"><b>Spcl. Age Relaxation</b></td>
				<td style=\"width: 6%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 

						$exp_details = $this->candidates_m->goto_Check_Candidate_Ds_Experience_total($quaries->f_application_no);
						$essenexp_details = $this->candidates_m->goto_Check_Candidate_Ess_Experience_total($quaries->f_application_no);
						//$spclage_list = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($quaries->f_application_no);
						$my_html = $my_html."<tr>
						<td valign=\"top\">".($keys+1)."</td>
						<td valign=\"top\">".$quaries->f_full_name."</td>
						<td valign=\"top\">".$quaries->f_application_no."</td>
						<td valign=\"top\">".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td valign=\"top\">".$quaries->f_mobile."</td>
						<td valign=\"top\">";
						$my_html = $my_html . "State : " .$quaries->state_name;
						if($quaries->fu_state == 28){ 
							$my_html = $my_html . ", District : " . $quaries->district_name;
						}else{
							$my_html = $my_html . ", District : ".$quaries->fu_other_district;
						}
						if($quaries->fu_state == 28){
							$my_html = $my_html . ", Sub-Division :" . $quaries->subdiv_name;
							$my_html = $my_html . ", Block/ Municipality : " . $quaries->fu_mb_type;
						}else{
							$my_html = $my_html . ", Sub-Division : ".$quaries->fu_other_sdiv;
							$my_html = $my_html . ", Block/ Municipality : ".$quaries->fu_other_blockm;
						}
						if($quaries->fu_state == 28){
							$my_html = $my_html .", Police Station : ". $quaries->ps_name;
						}else{
							$my_html = $my_html . ", Police Station : ".$quaries->fu_other_ps;
						}
						$my_html = $my_html . ", Ward/GP : ".$quaries->fu_ward_gp.", Vill / Para / House No / Road : ".$quaries->fu_house_road.", Post Office : ".$quaries->fu_post_office.", Pin : ".$quaries->fu_pincode;
						$my_html = $my_html."</td>
						<td valign=\"top\">".$quaries->caste_name."</td>
						<td valign=\"top\">".$quaries->fu_pwd."</td>
						<td valign=\"top\">";
						$my_html = $my_html . $quaries->feqname;
						$my_html = $my_html . $quaries->fdqname;
						$my_html = $my_html."</td><td valign=\"top\">";
						
						foreach($essenexp_details as $expss){
							if($expss->t_month >= 12){
								$ttyear = $expss->t_yr + ($expss->t_month / 12);
								$ttmonth = ($expss->t_month % 12);
							}else{
								$ttyear = $expss->t_yr;
								$ttmonth = $expss->t_month;
							}
							$my_html = $my_html . $expss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						foreach($exp_details as $ddexpss){
							if($ddexpss->t_month >= 12){
								$ttyear = $ddexpss->t_yr + ($ddexpss->t_month / 12);
								$ttmonth = ($ddexpss->t_month % 12);
							}else{
								$ttyear = $ddexpss->t_yr;
								$ttmonth = $ddexpss->t_month;
							}
							$my_html = $my_html . $ddexpss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						$my_html = $my_html."</td><td valign=\"top\">".$quaries->agename."</td>
						<td valign=\"top\">".$quaries->cr_total_marks."</td>
						</tr>";
				}
				$my_html = $my_html."</table>
			</td>
		</tr>
		</table>
		</div>";
		$this->data['content_all'] = $my_html; //ob_get_contents();
		
		$this->load->view('admin/f_panel/merit_html_view', $this->data); 

	}


	public function print_the_finalpanel_set2_section_lsits_sql($advno, $advcat_name, $gen_set){
		ini_set('default_socket_timeout', 6000);
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_v2_listing_sectionwise_v2($advno, $advcat_name, $gen_set);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}

		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		
		//print_r($chksets);exit;
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark_v2('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Panel_V-2';
		$obj_pdf->SetTitle('Advertisement - Panel');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Panel List');

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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: ".date('d.m.Y', strtotime($app_details->adv_start_time. ' -1 day'))."</span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
				<span align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></span><br/>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 5%\"><b>Sl No.</b></td>
				<td style=\"width: 10%\"><b>Full Name</b></td>
				<td style=\"width: 10%\"><b>Registration No.</b></td>
				<td style=\"width: 5%\"><b>Date of Birth</b></td>
				<td style=\"width: 7%\"><b>Mobile</b></td>
				<td style=\"width: 11%\"><b>Address</b></td>
				<td style=\"width: 7%\"><b>Caste</b></td>
				<td style=\"width: 4%\"><b>PWD</b></td>
				<td style=\"width: 12%\"><b>Qualification</b></td>
				<td style=\"width: 12%\"><b>Experience</b></td>
				<td style=\"width: 11%\"><b>Spcl. Age Relaxation</b></td>
				<td style=\"width: 6%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 

						//$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($quaries->f_application_no);
						//$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($quaries->f_application_no);
						//$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($quaries->f_application_no);
						//$essenexp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($quaries->f_application_no);
						$exp_details = $this->candidates_m->goto_Check_Candidate_Ds_Experience_total($quaries->f_application_no);
						$essenexp_details = $this->candidates_m->goto_Check_Candidate_Ess_Experience_total($quaries->f_application_no);
						//$spclage_list = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($quaries->f_application_no);
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->f_mobile."</td>
						<td>";
						/*if ($quaries->fu_district != NULL) {
							$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $quaries->fu_district))->result();
							$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $quaries->fu_district))->result();
						}
						if ($quaries->fu_sub_division != NULL && $quaries->fu_mb_type != NULL) {
							$mb_type = $quaries->fu_mb_type;
							$block_municipality = $this->db->get_where('block_master', array('subd_id' => $quaries->fu_sub_division, 'block_type' => $quaries->fu_mb_type))->result();
						}*/
						$my_html = $my_html . "State : " .$quaries->state_name;

						if($quaries->fu_state == 28){ 
							$my_html = $my_html . ", District : " . $quaries->district_name;
						}else{
							$my_html = $my_html . ", District : ".$quaries->fu_other_district;
						}
						if($quaries->fu_state == 28){
							$my_html = $my_html . ", Sub-Division :" . $quaries->subdiv_name;
							$my_html = $my_html . ", Block/ Municipality : " . $quaries->fu_mb_type;
						}else{
							$my_html = $my_html . ", Sub-Division : ".$quaries->fu_other_sdiv;
							$my_html = $my_html . ", Block/ Municipality : ".$quaries->fu_other_blockm;
						}
						if($quaries->fu_state == 28){
							$my_html = $my_html .", Police Station : ". $quaries->ps_name;
						}else{
							$my_html = $my_html . ", Police Station : ".$quaries->fu_other_ps;
						}
						$my_html = $my_html . ", Ward/GP : ".$quaries->fu_ward_gp.", Vill / Para / House No / Road : ".$quaries->fu_house_road.", Post Office : ".$quaries->fu_post_office.", Pin : ".$quaries->fu_pincode;
						$my_html = $my_html."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>";
						$my_html = $my_html . $quaries->feqname;
						$my_html = $my_html . $quaries->fdqname;
						$my_html = $my_html."</td><td>";
						/*foreach($essenexp_details as $key1=>$expss){
							if($expss->fues_exp_approval == "Approved"){
								if($key1 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $expss->expset_name . " (" . $expss->fues_exp_year." Yr & ".$expss->fues_exp_month . " Month)";
							}
						}
						foreach($exp_details as $key2=>$ddexpss){
							if($expss->fu_exp_approval == "Approved"){
								if($key2 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $ddexpss->expset_name . " (" . $ddexpss->fu_exp_year." Yr & ".$ddexpss->fu_exp_month . " Month)";
							}
						}*/
						foreach($essenexp_details as $expss){
							if($expss->t_month >= 12){
								$ttyear = $expss->t_yr + ($expss->t_month / 12);
								$ttmonth = ($expss->t_month % 12);
							}else{
								$ttyear = $expss->t_yr;
								$ttmonth = $expss->t_month;
							}
							$my_html = $my_html . $expss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						foreach($exp_details as $ddexpss){
							if($ddexpss->t_month >= 12){
								$ttyear = $ddexpss->t_yr + ($ddexpss->t_month / 12);
								$ttmonth = ($ddexpss->t_month % 12);
							}else{
								$ttyear = $ddexpss->t_yr;
								$ttmonth = $ddexpss->t_month;
							}
							$my_html = $my_html . $ddexpss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						$my_html = $my_html."</td><td>".$quaries->agename."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
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

	}


	public function partial_finalpanel_setsection_lists($advno, $advcat_name, $gen_set){
		if($_POST){
			$checker_ref_candidate = $this->input->post("checker_ref_candidate");
			$this->form_validation->set_rules('checker_ref_candidate[]', 'Candidate Selection', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				//print_r($checker_ref_candidate);
				//exit;
				$this->load->model('member_m');
				$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise($advno, $advcat_name, $gen_set, $checker_ref_candidate);
			
				if(count((array)$chksets) == 0){
					redirect('default404');
				}
				$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
				if (count((array)$app_details) == 0) {
					redirect('default404');
				}
				$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
				$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		
				//print_r($chksets);exit;

				$my_html = "<div class=\"header321\">
				<table style=\"width: 100%\" style=\"font-size: 16px;\">
				<tr>
					<td colspan=\"2\" style=\"width:100%;\">
						<table style=\"width: 100%\" style=\"font-size: 16px;\">
						<tr>
						<td style=\"width:100%;\">
							<div align=\"center\">
							<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
							<span style=\"font-size:16px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
							<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
							<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
							<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
							<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Dated: </span><br/>
							</div>
						</td>
						</tr>
						</table><br/>
						<div align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></div><br/>
					</td>
				</tr>
				<tr>
					<td class=\"printsethtml\" colspan=\"2\" style=\"width:100%;\">
						<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-size: 12px;\">
						<tr style=\"font-size: 12px;\">
						<td style=\"width: 8%\"><b>Sl No.</b></td>
						<td style=\"width: 25%\"><b>Full Name</b></td>
						<td style=\"width: 20%\"><b>Registration No.</b></td>
						<td style=\"width: 12%\"><b>Date of Birth</b></td>
						<td style=\"width: 15%\"><b>Caste</b></td>
						<td style=\"width: 8%\"><b>PWD</b></td>
						<td style=\"width: 12%\"><b>Total Marks Obtained</b></td>
						</tr>";
						//$countersetss = 1;
						foreach($chksets as $keys=>$quaries){ 
							//if(in_array($quaries->f_application_no, $checker_ref_candidate)){
								$my_html = $my_html."<tr>
								<td valign=\"top\">".($keys+1)."</td>
								<td valign=\"top\">".$quaries->f_full_name."</td>
								<td valign=\"top\">".$quaries->f_application_no."</td>
								<td valign=\"top\">".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
								<td valign=\"top\">".$quaries->caste_name."</td>
								<td valign=\"top\">".$quaries->fu_pwd."</td>
								<td valign=\"top\">".$quaries->cr_total_marks."</td>
								</tr>";
								//$countersetss++;
							//}
						}
						$my_html = $my_html."</table>
						</td>
					</tr>
					</table>
					</div>";
						
				$this->data['content_all'] = $my_html; //ob_get_contents();

				$rowset_arr = array(
					'pr_advno' => $advno,
					'pr_category' => $advcat_name,
					'pr_castegen' => $gen_set,
					'pr_cand_no' => count($checker_ref_candidate),
					'pr_candidates' => implode(",",$checker_ref_candidate),
					'pr_createdate' => date('Y-m-d H:i:s'),
					'pr_createby' => $this->session->userdata['uid']
				);
				$this->candidates_m->addprintLog_PanelListPartial_inDB($rowset_arr);

			}else{
				$this->data['error'] = 'Candidate not Found, Check Again.';
			}
			$this->load->view('admin/f_panel/merit_html_view', $this->data);
		}else{
			$this->load->model('member_m');
			$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise($advno, $advcat_name, $gen_set);
			
			if(count((array)$chksets) == 0){
				redirect('default404');
			}
			$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
			if (count((array)$app_details) == 0) {
				redirect('default404');
			}
			$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
			$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
			$this->data['meritlist'] = $chksets;
			$this->data['app_details'] = $app_details;
			$this->data['section_detail'] = $section_detail;
			$this->data['dicipline_detail'] = $dicipline_detail;
	
			$this->load->view('admin/f_panel/partial_panel_list_view', $this->data); 
		}

	}


	public function final_panelled_list_set2(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			$lim_start = $this->input->post("lim_start");
			$lim_end = $this->input->post("lim_end");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Listing For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('lim_start', 'Limit Start', 'trim|required|is_natural');
			$this->form_validation->set_rules('lim_end', 'Total Count', 'trim|required|is_natural');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set, 'gen_set'=>$gen_set, 'lim_start'=>$lim_start, 'lim_end'=>$lim_end);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise_v2($advno, $advcat_name, $gen_set, $lim_start, $lim_end);
				if(count((array)$chksets) > 0){
					$this->data['meritlist'] = $chksets;
				}else{
					$this->data['meritlist'] = array();
					$this->data['error'] = "No Record Found for your search Criteria.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/final_panel_list_v2', $this->data);
	}

	public function print_the_finalpanel_set2_section_lsits_withlimit($advno, $advcat_name, $gen_set, $lim_start, $lim_end){
		ini_set('default_socket_timeout', 6000);
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_v2_listing_sectionwise($advno, $advcat_name, $gen_set, $lim_start, $lim_end);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}

		$state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
		$dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

		



		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark_v2('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Panel_V-2';
		$obj_pdf->SetTitle('Advertisement - Panel');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Panel List');

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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: ".date('d.m.Y', strtotime($app_details->adv_start_time. ' -1 day'))."</span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
				<span align=\"center\"><b><u>PANEL LIST (".$section_detail->caste_name.")</u></b></span><br/>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 5%\"><b>Sl No.</b></td>
				<td style=\"width: 10%\"><b>Full Name</b></td>
				<td style=\"width: 10%\"><b>Registration No.</b></td>
				<td style=\"width: 5%\"><b>Date of Birth</b></td>
				<td style=\"width: 7%\"><b>Mobile</b></td>
				<td style=\"width: 11%\"><b>Address</b></td>
				<td style=\"width: 7%\"><b>Caste</b></td>
				<td style=\"width: 4%\"><b>PWD</b></td>
				<td style=\"width: 12%\"><b>Qualification</b></td>
				<td style=\"width: 12%\"><b>Experience</b></td>
				<td style=\"width: 11%\"><b>Spcl. Age Relaxation</b></td>
				<td style=\"width: 6%\"><b>Total Marks Obtained</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 

						$quali_details = $this->candidates_m->GetDetail_Qualification_for_Application($quaries->f_application_no);
						$des_quali_details = $this->candidates_m->GetDetail_DesireQualification_for_Application($quaries->f_application_no);
						$exp_details = $this->candidates_m->goto_Check_Candidate_Ds_Experience_total($quaries->f_application_no);
						//$exp_details = $this->candidates_m->GetDetail_Experience_for_Application($quaries->f_application_no);
						//$essenexp_details = $this->candidates_m->GetDetail_Essn_Experience_for_Application($quaries->f_application_no);
						$essenexp_details = $this->candidates_m->goto_Check_Candidate_Ess_Experience_total($quaries->f_application_no);
						$spclage_list = $this->candidates_m->getAll_Spcl_ExtraAgeSets_forCandidate($quaries->f_application_no);
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->f_mobile."</td>
						<td>";
						if ($quaries->fu_district != NULL) {
							$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $quaries->fu_district))->result();
							$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $quaries->fu_district))->result();
						}
						/*if ($quaries->fu_perma_dist != NULL) {
							$per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $quaries->fu_perma_dist))->result();
							$per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $quaries->fu_perma_dist))->result();
						}
						if ($quaries->fu_perma_sub_division != NULL && $quaries->fu_perma_mb_type != NULL) {
							$per_mb_type = $quaries->fu_perma_mb_type;
							$per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $quaries->fu_perma_sub_division, 'block_type' => $quaries->fu_perma_mb_type))->result();
						}*/
						if ($quaries->fu_sub_division != NULL && $quaries->fu_mb_type != NULL) {
							$mb_type = $quaries->fu_mb_type;
							$block_municipality = $this->db->get_where('block_master', array('subd_id' => $quaries->fu_sub_division, 'block_type' => $quaries->fu_mb_type))->result();
						}

						foreach ($state_list as $states) {
							if ($states->state_id == $quaries->fu_state) { $my_html = $my_html . "State : " .$states->state_name;break; }
						}
						if($quaries->fu_state == 28){  
							foreach ($dist_list as $dists) { 
								if ($dists->district_code == $quaries->fu_district) { $my_html = $my_html . ", District : " . $dists->district_name; }
							}
						}else{
							$my_html = $my_html . ", District : ".$quaries->fu_other_district;
						}
	
						if($quaries->fu_state == 28){
							foreach ($sub_division as $sd) {
								if ($quaries->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . ", Sub-Division :" . $sd->subdiv_name; }
							}
							$bmset = '';
							foreach ($block_municipality as $bm) { 
								if ($bm->block_id == $quaries->fu_block_municipality) {$bmset = $bm->block_name;}
							}
							if($bmset != ''){
								$my_html = $my_html . ", Block/ Municipality : " . $quaries->fu_mb_type.' ('.$bmset.')';
							}
						}else{
							$my_html = $my_html . ", Sub-Division : ".$quaries->fu_other_sdiv;
							$my_html = $my_html . ", Block/ Municipality : ".$quaries->fu_other_blockm;
						}
	
						if($quaries->fu_state == 28){
							foreach ($police_station as $ps) {
								if ($quaries->fu_police_station == $ps->ps_id) {$my_html = $my_html .", Police Station : ". $ps->ps_name;}
							}
						}else{
							$my_html = $my_html . ", Police Station : ".$quaries->fu_other_ps;
						}
						$my_html = $my_html . ", Ward/GP : ".$quaries->fu_ward_gp.", Vill / Para / House No / Road : ".$quaries->fu_house_road.", Post Office : ".$quaries->fu_post_office.", Pin : ".$quaries->fu_pincode;
						$my_html = $my_html."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>";
						foreach($quali_details as $keys=>$qips){
							$my_html = $my_html . $qips->qm_name . " (" . $qips->fu_percent_of_marks . "%)<hr/>";
						}
						foreach($des_quali_details as $keyss=>$ddqips){
							$my_html = $my_html . $ddqips->qm_name . " (" . $ddqips->fud_percent_of_marks . "%)<hr/>";
						}
						$my_html = $my_html."</td><td>";
						/*foreach($essenexp_details as $key1=>$expss){
							if($expss->fues_exp_approval == "Approved"){
								if($key1 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $expss->expset_name . " (" . $expss->fues_exp_year." Yr & ".$expss->fues_exp_month . " Month)";
							}
						}
						foreach($exp_details as $key2=>$ddexpss){
							if($expss->fu_exp_approval == "Approved"){
								if($key2 > 0){
									$my_html = $my_html . "<hr/>";
								}
								$my_html = $my_html . $ddexpss->expset_name . " (" . $ddexpss->fu_exp_year." Yr & ".$ddexpss->fu_exp_month . " Month)";
							}
						}*/
						foreach($essenexp_details as $expss){
							if($expss->t_month >= 12){
								$ttyear = $expss->t_yr + ($expss->t_month / 12);
								$ttmonth = ($expss->t_month % 12);
							}else{
								$ttyear = $expss->t_yr;
								$ttmonth = $expss->t_month;
							}
							$my_html = $my_html . $expss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						foreach($exp_details as $ddexpss){
							if($ddexpss->t_month >= 12){
								$ttyear = $ddexpss->t_yr + ($ddexpss->t_month / 12);
								$ttmonth = ($ddexpss->t_month % 12);
							}else{
								$ttyear = $ddexpss->t_yr;
								$ttmonth = $ddexpss->t_month;
							}
							$my_html = $my_html . $ddexpss->expset_name . " (" . $ttyear ." Yr & ". $ttmonth . " Month)<hr/>";
						}
						$my_html = $my_html."</td><td>";
						foreach($spclage_list as $spageitems){
							if($spageitems->fu_ext_answer == "Yes"){
								$my_html = $my_html . $spageitems->caste_name."<hr/>";
							}
						}
						$my_html = $my_html."</td>
						<td>".$quaries->cr_total_marks."</td>
						</tr>";
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

	}

	public function modification_of_meritpanel_sections(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			//$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			//$this->form_validation->set_rules('gen_set', 'Listing For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'rf_setid'=>$rf_set, 'advcat_name'=>$advcat_name);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				//$chksets = $this->candidates_m->getall_adv_Candidates_FinalPanel_listing_sectionwise($advno, $advcat_name, $gen_set);
				
				$panel_detail = $this->db->where('fpn_advno', $advno)->where('fpn_category', $advcat_name)->get('final_panel_tab')->result();
				$merit_detail = $this->db->where('mr_adv_master', $advno)->where('mr_category', $advcat_name)->get('merit_list_tab')->result();
				if(count((array)$panel_detail) == 0 && count((array)$merit_detail) == 0){
					$this->data['error'] = 'Merit and Panel Candidates not found against the Advertisement & Category.';
				}else{
					$row_array = array(
						'fp_log_advno' => $advno,
						'fp_log_cat' => $advcat_name,
						'fp_log_createdate' => date('Y-m-d H:i:s'),
						'fp_log_createby' => $this->session->userdata['uid']
					);
					if($this->admin_m->allcandidate_forDeletion_PanelMerit_asper_Advertisement($advno, $advcat_name) == TRUE){
						$this->admin_m->addmodify_FinalPanelModificationLog_Sets($row_array);
						$this->session->set_flashdata('success','Advertisement Merit and Panel Candidates is Removed Successfully');
						redirect('admincontrol/finalpanel/modification_of_meritpanel_sections','refresh');
					}else{
						$this->data['error'] = 'Merit and Panel Candidates updation Problem in DB. Try Again.';
					}
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/final_panel_modification_view', $this->data);
	}

	public function getvacancy_from_advertisement(){
		if($_POST){
		  	//print_r($_POST);exit;
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('gen_set', 'Generate For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
			
				$genset_arr = array(NULL, "UR", "UR-EC", "UR-EXS-C", "UR-EXS-D", "UR-MSP", "SC", "SC-EC", "SC-EXS-C", "SC-EXS-D", "ST", "ST-EC", "ST-EXS-D", "OBC", "OBC-A", "OBC-A-EC", "OBC-A-EXS-D", "OBC-B", "OBC-B-EC", "OBC-B-EXS-D", "PWD");
				$vacancy_details = $this->candidates_m->getAll_Vacancy_detaillist_of_Avvertisement($advno, $advcat_name, $genset_arr[$gen_set]);
				if(count((array)$vacancy_details) > 0){
					echo json_encode(array('msg' => 1, 'op_set' => $vacancy_details->totalno));
				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'Vacancy Not Available'));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
		  	exit;
		}else{
		  redirect('default404');
		}
	}

	public function combinepanel_list_for_advertisement(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			//$gen_set = $this->input->post("gen_set");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			//$this->form_validation->set_rules('gen_set', 'Listing For', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('advno' => $advno, 'advcat_name'=>$advcat_name, 'rf_setid'=>$rf_set);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_category'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
				$chksets = $this->candidates_m->getall_adv_Candidates_CombinePanel_listing_catwise($advno, $advcat_name);
				if(count((array)$chksets) > 0){
					$this->data['meritlist'] = $chksets;
				}else{
					$this->data['meritlist'] = array();
					$this->data['error'] = "No Record Found for your search Criteria.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		//$this->data['section_list'] = $this->candidates_m->get_all_vacancySection_forCandidates();
		$this->load->view('admin/f_panel/combine_panel_list', $this->data);
	}

	public function print_the_combinepanel_lsitsets($advno, $advcat_name){
		ini_set('default_socket_timeout', 6000);
		ini_set('memory_limit','1024M');
		set_time_limit(0);
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_CombinePanel_listing_catwise($advno, $advcat_name);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}
		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		//print_r($dicipline_detail->catm_name);
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = 'Panellist';
		$obj_pdf->SetTitle('Advertisement - Combine Panel');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Combine Panel List');

		//$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
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
		$obj_pdf->AddPage(); //".date('d.m.Y', strtotime($app_details->adv_start_time. ' -1 day'))."

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
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:18px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellpadding=\"5\" style=\"font-size: 18px;\">
				<tr>
				<td style=\"width: 7%\"><b>Sl No.</b></td>
				<td style=\"width: 18%\"><b>Full Name</b></td>
				<td style=\"width: 20%\"><b>Registration No.</b></td>
				<td style=\"width: 12%\"><b>Date of Birth</b></td>
				<td style=\"width: 14%\"><b>Caste</b></td>
				<td style=\"width: 6%\"><b>PWD</b></td>
				<td style=\"width: 9%\"><b>Total Marks Obtained</b></td>
				<td style=\"width: 14%\"><b>Panelled In</b></td>
				
				</tr>";
				foreach($chksets as $keys=>$quaries){ 
						$my_html = $my_html."<tr>
						<td>".($keys+1)."</td>
						<td>".$quaries->f_full_name."</td>
						<td>".$quaries->f_application_no."</td>
						<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
						<td>".$quaries->caste_name."</td>
						<td>".$quaries->fu_pwd."</td>
						<td>".$quaries->cr_total_marks."</td>
						<td>".$quaries->section_name."</td>
						</tr>";
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

	}

	public function htmlview_the_combinepanel_section_lsits($advno, $advcat_name){
		
		$this->load->model('member_m');
		$chksets = $this->candidates_m->getall_adv_Candidates_CombinePanel_listing_catwise($advno, $advcat_name);
		
		if(count((array)$chksets) == 0){
			redirect('default404');
		}

		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advno);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		//$section_detail = $this->candidates_m->get_all_vacancySection_forCandidates($gen_set);
		$dicipline_detail = $this->member_m->getAll_list_Advertisement_Category($advno, $advcat_name);
		
		//print_r($chksets);exit;

		$my_html = "<div class=\"header321\">
		<table style=\"width: 100%\" style=\"font-size: 16px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 16px;\">
				<tr>
				<td style=\"width:100%;\">
					<div align=\"center\">
					<img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /><br/>
					<span style=\"font-size:16px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Panel for ".$app_details->rm_name."</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Advertisement No.: ".$app_details->adv_no." (".$dicipline_detail->catm_name.")</span><br/>
					<span align=\"center\" style=\"font-size:12px;font-weight:normal;\">Dated: </span><br/>
					</div>
				</td>
				</tr>
				</table><br/>
			</td>
		</tr>
		<tr>
			<td class=\"printsethtml\" colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-size: 12px;\">
				<tr style=\"font-size: 12px;\">
				<td style=\"width: 7%\"><b>Sl No.</b></td>
				<td style=\"width: 18%\"><b>Full Name</b></td>
				<td style=\"width: 20%\"><b>Registration No.</b></td>
				<td style=\"width: 12%\"><b>Date of Birth</b></td>
				<td style=\"width: 14%\"><b>Caste</b></td>
				<td style=\"width: 6%\"><b>PWD</b></td>
				<td style=\"width: 9%\"><b>Total Marks Obtained</b></td>
				<td style=\"width: 14%\"><b>Panelled In</b></td>
				</tr>";
				foreach($chksets as $keys=>$quaries){ 
					$my_html = $my_html."<tr>
					<td>".($keys+1)."</td>
					<td>".$quaries->f_full_name."</td>
					<td>".$quaries->f_application_no."</td>
					<td>".date('d-M-Y',strtotime($quaries->fu_dob))."</td>
					<td>".$quaries->caste_name."</td>
					<td>".$quaries->fu_pwd."</td>
					<td>".$quaries->cr_total_marks."</td>
					<td>".$quaries->section_name."</td>
					</tr>";
				}
				$my_html = $my_html."</table>
			</td>
		</tr>
		</table>
		</div>";
		$this->data['content_all'] = $my_html; //ob_get_contents();
		
		$this->load->view('admin/f_panel/merit_html_view', $this->data); 

	}


}
