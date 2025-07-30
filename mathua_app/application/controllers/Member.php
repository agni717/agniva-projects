<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Member extends Member_Controller
{



	function __construct()
	{

		parent::__construct();

		$this->load->model('main_m');

		$this->load->model('member_m');

		date_default_timezone_set('Asia/Kolkata');


		$this->data["fuser_detailset"] = $this->db->get_where('f_user_views', array('f_uid' => $this->session->userdata['member_id']))->row();

		$this->data["detail_result"] = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $this->data["fuser_detailset"]->f_application_no))->row();
		//$this->member_m->gotoDetails_SearchforInterview_Set($this->data["fuser_detailset"]->f_application_no);

		$this->data["fuser_quali"] = $this->member_m->get_fuser_qualification();

		$this->data["get_reject_access"] = $this->member_m->get_all_access_forReject_User_inthe_Advertisement($this->data["fuser_detailset"]->f_applied_for);
		//print_r($this->data["get_reject_access"]);exit;

		$this->data['adv_detail'] = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($this->data["fuser_detailset"]->f_applied_for);
		if(count((array)$this->data['adv_detail']) == 0){
			$this->member_m->logout();
			$this->session->set_userdata('entry', TRUE);
			redirect('login');
		}

		$this->data['old_detail'] = $this->member_m->getAll_list_of_OLDData_for_PrevApplication($this->data["fuser_detailset"]->f_applied_for, $this->data["fuser_detailset"]->f_application_no);
		if(!empty($this->data['old_detail'])){
			if(trim($this->data['old_detail']->Category) != "" && $this->data["fuser_detailset"]->f_applied_for == 'AA031120211259004685'){
				$castarr = array('UR'=>1,'SC'=>2,'ST'=>3,'OBC'=>4,'OBC-A'=>5,'OBC-B'=>6);
				$cstype = trim($this->data['old_detail']->Category);
				$this->data["oldcaste_communi_set"] = $this->member_m->get_caste_details($castarr[$cstype]);
			}else{
				$this->data["oldcaste_communi_set"] = array();
			}
		}
		 //print_r($this->data["old_detail"]);		



	}


	public function index()
	{
		redirect('member/dashboard');
	}

	public function dashboard()
	{

		//print_r($this->data["fuser_detailset"]);

		$userdetails = $this->data["fuser_detailset"];

		//$this->data['adv_detail'] = $this->main_m->getAll_list_of_Active_Advertisement($userdetails->f_applied_for);

		$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();

		$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();

		if ($userdetails->fu_step_1 == 1) {

			$this->data['adv_category'] = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
		} else {

			$this->data['adv_category'] = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for);
		}

		if ($userdetails->fu_step_2 == 1) {

			$this->data['dist_list'] = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();

			if ($userdetails->fu_district != NULL) {

				$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district, 'subdiv_status'=>1))->result();
				$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district, 'ps_status'=>1))->result();
			}
			if ($userdetails->fu_perma_dist != NULL) {

				$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist, 'subdiv_status'=>1))->result();
				$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist, 'ps_status'=>1))->result();
			}
			if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
	
				$this->data['per_mb_type'] = $userdetails->fu_perma_mb_type;
				$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type, 'block_status'=>1))->result();
			}
	
			if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
	
				$this->data['mb_type'] = $userdetails->fu_mb_type;
				$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type, 'block_status'=>1))->result();
			}
			//$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
		} else {

			if ($userdetails->fu_step_1 == 1) {

				$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();
				if ($userdetails->fu_district != NULL) {

					$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district, 'subdiv_status'=>1))->result();
					$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district, 'ps_status'=>1))->result();
				}
				if ($userdetails->fu_perma_dist != NULL) {
	
					$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist, 'subdiv_status'=>1))->result();
					$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist, 'ps_status'=>1))->result();
				}
				if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
		
					$this->data['per_mb_type'] = $userdetails->fu_perma_mb_type;
					$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type, 'block_status'=>1))->result();
				}
		
				if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
		
					$this->data['mb_type'] = $userdetails->fu_mb_type;
					$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type, 'block_status'=>1))->result();
				}
			}
		}


		if ($userdetails->fu_step_3 == 1) {
			
			//$this->db->where('fu_ext_masteruser',$this->session->userdata['member_id'])->get('f_user_extraage')->result();
			//$this->data['quali_exam'] = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$allquali_list = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$masterset_arr = array();
			$desire_quali_arr = array();
			$iset = $jset = 0;
			$persunig_chk = 0;
			foreach($allquali_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aquali_examtype == "Essential"){
					if($qs->aquali_pursuing_chk == "Yes"){
						$persunig_chk = 1;
					}
					if($keys == 0){
						$subset_arr['qm_name'] = $qs->qm_name;
						$subset_arr['aquali_exam'] = $qs->aquali_exam;
						$subset_arr['aquali_marks'] = $qs->aquali_marks;
						$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
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
						$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
						$masterset_arr[$iset][$jset] = $subset_arr;
						if($qs->aquali_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aquali_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aquali_examtype == "Desirable"){
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$desire_quali_arr[] = $subset_arr;
				}
			}
			$this->data['quali_exam'] = $masterset_arr;
			$this->data['quali_persu_check'] = $persunig_chk;
			$this->data['desire_quali_exam'] = $desire_quali_arr;
			$allexp_list = $this->member_m->getAll_Experience_section($this->data['adv_detail']->adv_auto_genno);
			$masterexp_arr = array();
			$desire_exp_arr = array();
			$iset = $jset = 0;
			foreach($allexp_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aexpr_type == "Essential"){
					if($keys == 0){
						$subset_arr['exp_name'] = $qs->expset_name;
						$subset_arr['expid'] = $qs->aexpr_name;
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
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
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
						$masterexp_arr[$iset][$jset] = $subset_arr;
						if($qs->aexpr_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aexpr_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aexpr_type == "Desirable"){
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					$subset_arr['exp_marks'] = $qs->aexpr_marks;
					$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$desire_exp_arr[] = $subset_arr;
				}
			}
			$this->data['ess_expr'] = $masterexp_arr;
			$this->data['desire_expr'] = $desire_exp_arr;
			$this->data['exp_list'] = $this->member_m->gotoDesire_Experience_listSet($this->session->userdata['member_id']);
			$this->data['essenexp_list'] = $this->member_m->gotoEssential_Experience_listSet($this->session->userdata['member_id']);
			$this->data['desquali_list'] = $this->member_m->gotoDesire_Qualification_listSet($this->session->userdata['member_id']);
			//echo "<pre>";
			//print_r($this->data['extraage_list']);exit;
		}else{
			if($userdetails->fu_step_3 == 2){
				if($this->data["fuser_detailset"]->fu_caste_type > 1){
					$this->data["caste_communi_set"] = $this->member_m->get_caste_details($this->data["fuser_detailset"]->fu_caste_type);
				}
			}
		}

		if ($userdetails->fu_step_4 == 1) {
			redirect('member/finalcheck_up');
		}

		$nonzero_vacancy = $this->member_m->getAll_notavailable_vacancies_in_ADV($userdetails->f_applied_for);
		$all_vacancy = array(
			'acat_ur_ec' => 35,
			'acat_ur_g_c' => 36,
			'acat_ur_g_d' => 37,
			'acat_ur_sp' => 38,
			'acat_sc_ec' => 39,
			'acat_sc_g_c' => 40,
			'acat_sc_g_d' => 41,
			'acat_st_ec' => 42,
			'acat_st_g_d' => 43,
			'acat_obc_a_ec' => 44,
			'acat_obc_a_g_d' => 45,
			'acat_obc_b_ec' => 46,
			'acat_obc_b_g_d' => 47
		);
		$all_zero_vacancy = array();
		if($nonzero_vacancy->acat_ur_ec == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_ur_ec'];
		}
		if($nonzero_vacancy->acat_ur_g_c == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_ur_g_c'];
		}
		if($nonzero_vacancy->acat_ur_g_d == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_ur_g_d'];
		}
		if($nonzero_vacancy->acat_ur_sp == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_ur_sp'];
		}
		if($nonzero_vacancy->acat_sc_ec == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_sc_ec'];
		}
		if($nonzero_vacancy->acat_sc_g_c == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_sc_g_c'];
		}
		if($nonzero_vacancy->acat_sc_g_d == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_sc_g_d'];
		}
		if($nonzero_vacancy->acat_st_ec == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_st_ec'];
		}
		if($nonzero_vacancy->acat_st_g_d == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_st_g_d'];
		}
		if($nonzero_vacancy->acat_obc_a_ec == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_obc_a_ec'];
		}
		if($nonzero_vacancy->acat_obc_a_g_d == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_obc_a_g_d'];
		}
		if($nonzero_vacancy->acat_obc_b_ec == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_obc_b_ec'];
		}
		if($nonzero_vacancy->acat_obc_b_g_d == 0){
			$all_zero_vacancy[] = $all_vacancy['acat_obc_b_g_d'];
		}
		$this->data['allzero_vacancy'] = $all_zero_vacancy;
		//echo "<pre>";
		//print_r($all_zero_vacancy);exit;

		// print_r($this->data["caste_tab"]);

		//print_r($this->data['adv_category']);exit;

		// print_r($this->data['state_list']);

		// print_r($this->data['adv_detail']);
		$this->data['quali_list'] = $this->member_m->get_fuser_qualification();

		$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All();
		$this->data['extraage_set'] = $allage_arr = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);
		$masterage_arr = array();
		$iiiset = $jjjset = 0;
		foreach($allage_arr as $keys=>$aggggs){
			$masterage_arr[$iiiset][$jjjset] = $aggggs->advage_section;
			if($aggggs->advage_type == "AND"){
				$iiiset++;
				$jjjset = 0;
			}elseif($aggggs->advage_type == "OR"){
				$jjjset++;
			}
			/*if($keys == 0){
				$ageset_arr['ages_name'] = $aggggs->caste_name;
				$ageset_arr['ages_ids'] = $aggggs->advage_section;
				$masterage_arr[$iiiset][$jjjset] = $ageset_arr;
				if($aggggs->advage_type == "AND"){
					$iiiset++;
					$jjjset = 0;
				}elseif($aggggs->advage_type == "OR"){
					$jjjset++;
				}
				
			}else{
				$ageset_arr['exp_name'] = $aggggs->caste_name;
				$ageset_arr['expid'] = $aggggs->advage_section;
				$masterage_arr[$iiiset][$jjjset] = $ageset_arr;
				if($aggggs->advage_type == "AND"){
					$iiiset++;
					$jjjset = 0;
				}elseif($aggggs->advage_type == "OR"){
					$jjjset++;
				}

			}*/
		}
		$this->data['arrextraage_set'] = $masterage_arr;
		//echo "<pre>";
		//print_r($this->data['arrextraage_set']);exit;

		$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();

		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();


		if ($userdetails->fu_caste_type != NULL && $userdetails->fu_caste_community != NULL) {

			$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $userdetails->fu_caste_community, 'csdetail_status' => 1))->row();
		}

		


		$this->load->view("main/member/dashboard_view_v2", $this->data);
	}

	public function finalcheck_up(){
		if($_POST){
			//echo "hi";exit;
		}
		//print_r($this->data["fuser_detailset"]);

		$userdetails = $this->data["fuser_detailset"];
		if ($userdetails->fu_step_4 != 1){
			redirect('member/dashboard');
		}
		/*if ($userdetails->fu_final_submit == 1 && $userdetails->fu_payment_stat == 0) {
			redirect('member/payment_summery');
		}*/
		//$this->data['adv_detail'] = $this->main_m->getAll_list_of_Active_Advertisement($userdetails->f_applied_for);

		$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();

		$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();

		if ($userdetails->fu_step_1 == 1) {

			$this->data['adv_category'] = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
		}

		if ($userdetails->fu_step_2 == 1) {

			$this->data['dist_list'] = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();

			if ($userdetails->fu_district != NULL) {

				$this->data['sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district))->result();
				$this->data['police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district))->result();
			}
			if ($userdetails->fu_perma_dist != NULL) {

				$this->data['per_sub_division'] = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist))->result();
				$this->data['per_police_station'] = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist))->result();
			}
			if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
	
				$this->data['per_mb_type'] = $userdetails->fu_perma_mb_type;
				$this->data['per_block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type))->result();
			}else{
				$this->data['per_mb_type'] = NULL;
				$this->data['per_block_municipality'] = array();
			}
	
			if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
	
				$this->data['mb_type'] = $userdetails->fu_mb_type;
				$this->data['block_municipality'] = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type))->result();
			}else{
				$this->data['mb_type'] = NULL;
				$this->data['block_municipality'] = array();
			}
			//$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
		}


		if ($userdetails->fu_step_3 == 1) {
			//$this->data['quali_exam'] = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$allquali_list = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$masterset_arr = array();
			$desire_quali_arr = array();
			$iset = $jset = 0;
			$persunig_chk = 0;
			foreach($allquali_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aquali_examtype == "Essential"){
					if($qs->aquali_pursuing_chk == "Yes"){
						$persunig_chk = 1;
					}
					if($keys == 0){
						$subset_arr['qm_name'] = $qs->qm_name;
						$subset_arr['aquali_exam'] = $qs->aquali_exam;
						$subset_arr['aquali_marks'] = $qs->aquali_marks;
						$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
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
						$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
						$masterset_arr[$iset][$jset] = $subset_arr;
						if($qs->aquali_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aquali_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aquali_examtype == "Desirable"){
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					$subset_arr['aquali_persuing'] = $qs->aquali_pursuing_chk;
					$desire_quali_arr[] = $subset_arr;
				}
			}
			
			$this->data['quali_exam'] = $masterset_arr;
			$this->data['quali_persu_check'] = $persunig_chk;
			$this->data['desire_quali_exam'] = $desire_quali_arr;
			$allexp_list = $this->member_m->getAll_Experience_section($this->data['adv_detail']->adv_auto_genno);
			$masterexp_arr = array();
			$desire_exp_arr = array();
			$iset = $jset = 0;
			foreach($allexp_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aexpr_type == "Essential"){
					if($keys == 0){
						$subset_arr['exp_name'] = $qs->expset_name;
						$subset_arr['expid'] = $qs->aexpr_name;
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
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
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
						$masterexp_arr[$iset][$jset] = $subset_arr;
						if($qs->aexpr_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aexpr_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aexpr_type == "Desirable"){
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					$subset_arr['exp_marks'] = $qs->aexpr_marks;
					$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$desire_exp_arr[] = $subset_arr;
				}
			}
			$this->data['ess_expr'] = $masterexp_arr;
			$this->data['desire_expr'] = $desire_exp_arr;
			$this->data['exp_list'] = $this->member_m->gotoDesire_Experience_listSet($this->session->userdata['member_id']);
			$this->data['essenexp_list'] = $this->member_m->gotoEssential_Experience_listSet($this->session->userdata['member_id']);
			$this->data['desquali_list'] = $this->member_m->gotoDesire_Qualification_listSet($this->session->userdata['member_id']);
			//print_r($this->data['exp_list']);exit;
		}

		
		$this->data['quali_list'] = $this->member_m->get_fuser_qualification();

		$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All();
		//$this->data['extraage_set'] = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);

		$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();

		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();


		if ($userdetails->fu_caste_type != NULL && $userdetails->fu_caste_community != NULL) {

			$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $userdetails->fu_caste_community, 'csdetail_status' => 1))->row();
		}
		$this->load->view("main/member/finalset_privew_v2", $this->data);
	}

	public function editmode_processing(){
		if ($_POST) {
			$refno = $this->input->post('refno');
			$msg = 0;
			$this->form_validation->set_rules('refno', 'Registration Number', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$row_arr = array(
					'fu_step_1' => 2,
					'fu_step_2' => 2,
					'fu_step_3' => 2,
					'fu_step_4' => 2,
					'fu_final_submit' => 2
				);

				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
					$row2_arr = array(
						'fmod_usermaster' => $this->session->userdata('member_id'),
						'fmod_datetime' => date('Y-m-d H:i:s')
					);
					$this->member_m->addUpdateform_Modify_LOG_inDB($row2_arr);
					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to Update DB, Try again.'));
				}
			}else{
				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function finalsubmitmode_processing(){
		if ($_POST) {
			$refno = $this->input->post('refno');
			$msg = 0;
			$this->form_validation->set_rules('refno', 'Registration Number', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$total_fee = $this->data['adv_detail']->adv_fees;
				$userdetails = $this->data["fuser_detailset"];
				$fee_list = $this->db->get_where('advertisement_age_set',array('advage_adv_master'=>$userdetails->f_applied_for))->result();
				if(count((array)$fee_list) > 0){
					/*$casteset = $this->db->where('caste_status',1)->where_in('caste_cat',array(2))->get('caste_tab')->result();
					foreach($casteset as $castesss){
						$castearr[] = $castesss->caste_id;
					}*/
					$pwdset = $exampted = $exservice = $ewsset = $experienceset = 0;
					//$userdetails->fu_caste_type;
					if($userdetails->fu_pwd == "Yes"){
						$pwdset = 7;
					}
					if($userdetails->fu_exempted == "Yes"){
						$exampted = 8;
					}
					if($userdetails->fu_exservice == "Yes"){
						$exservice = 9;
					}
					if($userdetails->fu_ews == "Yes"){
						$ewsset = 10;
					}
					
					//$experienceset = 11;
					foreach($fee_list as $feess){
						if($feess->advage_section == $userdetails->fu_caste_type){
							if($feess->advage_feetype == "Part"){
								$total_fee = $feess->advage_partfee;
							}elseif($feess->advage_feetype == "No"){
								$total_fee = 0.00;
								break;
							}
						}
						if($total_fee != 0.00){
							if($feess->advage_section == $exampted){
								if($feess->advage_feetype == "Part"){
									$total_fee = $feess->advage_partfee;
								}elseif($feess->advage_feetype == "No"){
									$total_fee = 0.00;
									break;
								}
							}
							if($feess->advage_section == $exservice){
								if($feess->advage_feetype == "Part"){
									$total_fee = $feess->advage_partfee;
								}elseif($feess->advage_feetype == "No"){
									$total_fee = 0.00;
									break;
								}
							}
							if($feess->advage_section == $ewsset){
								if($feess->advage_feetype == "Part"){
									$total_fee = $feess->advage_partfee;
								}elseif($feess->advage_feetype == "No"){
									$total_fee = 0.00;
									break;
								}
							}
						}
						if($feess->advage_section == $pwdset){
							if($feess->advage_feetype == "Part"){
								$total_fee = $feess->advage_partfee;
							}elseif($feess->advage_feetype == "No"){
								$total_fee = 0.00;
								break;
							}
						}
					}
				}
				//print_r($userdetails);
				//exit;

				$row_arr = array(
					'fu_final_submit' => 1,
					'fu_finalsubmit_date' => date('Y-m-d H:i:s'),
					'fu_pay_amount' => $total_fee
				);
				if($total_fee == 0.00 && (strtotime($this->data['adv_detail']->adv_end_time) > strtotime(date('Y-m-d H:i:s')))){
					$row_arr['fu_payment_stat'] = 1;
					$row_arr['fu_payment_date'] = date('Y-m-d H:i:s');
				}elseif($total_fee > 0.00 && (strtotime($this->data['adv_detail']->adv_end_time) > strtotime(date('Y-m-d H:i:s')))){
					$row_arr['fu_payment_stat'] = 0;
					$row_arr['fu_payment_date'] = NULL;
				}
				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
					if($total_fee == 0.00 && (strtotime($this->data['adv_detail']->adv_end_time) > strtotime(date('Y-m-d H:i:s')))){
						$htmldataset = '<html><body><h1>Thank you for Apply in WBHRB Application portal.</h1>
						<br/>
						<p>Your Application Registration Number is - <strong>'.$userdetails->f_application_no.'</strong></p>
						<p>For Any Further Queries, Please use this number.</p>
						</body></html>';
						$this->sendALLSMTPEmail($userdetails->f_email,'WBHRB - Application Submission', $htmldataset);
					}
					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to Update DB, Try again.'));
				}
			}else{
				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function cancellationmode_processing(){
		if ($_POST) {
			$refno = $this->input->post('refno');
			$msg = 0;
			$this->form_validation->set_rules('refno', 'Registration Number', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				
				$row_arr = array(
					'fu_cancel_stat' => 1,
					'fu_canceldate' => date('Y-m-d H:i:s')
				);
				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to Update DB, Try again.'));
				}
			}else{
				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function first_step_save()
	{

		if ($_POST) {

			$adv_no = $this->input->post('adv_no');

			$fu_fullname = $this->input->post('fu_fullname');

			$fu_mobile_no = $this->input->post('fu_mobile_no');

			$fu_emailid = $this->input->post('fu_emailid');

			$adv_cat = $this->input->post('adv_cat');

			$msg = 0;

			$this->form_validation->set_rules('adv_no', 'Applied For', 'trim|required');

			$this->form_validation->set_rules('fu_fullname', 'Full Name', 'trim|required');

			$this->form_validation->set_rules('fu_mobile_no', 'Mobile Number', 'trim|required|exact_length[10]|is_natural');

			$this->form_validation->set_rules('fu_emailid', 'Email-ID', 'trim|required|valid_email');

			$this->form_validation->set_rules('adv_cat', 'Discipline', 'trim|is_natural_no_zero');



			if ($this->form_validation->run() == TRUE) {

				/*$row_arr2 = array(

					'f_full_name' => trim($fu_fullname)

				);

				$this->main_m->insertRegistration_details_intheDB($row_arr2, $this->session->userdata('member_id'));*/

				$row_arr = array(

					'fu_category' => $adv_cat,

					'fu_step_1' => 2,

					'fu_step1_datetime' => date('Y-m-d H:i:s')

				);

				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {

					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
				}
			} else {

				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}

			exit;
		} else {

			redirect('default404');
		}
	}


	public function first_step_processing()
	{

		if ($_POST) {

			$adv_no = $this->input->post('adv_no');

			$fu_fullname = $this->input->post('fu_fullname');

			$fu_mobile_no = $this->input->post('fu_mobile_no');

			$fu_emailid = $this->input->post('fu_emailid');

			$adv_cat = $this->input->post('adv_cat');

			$msg = 0;

			$this->form_validation->set_rules('adv_no', 'Applied For', 'trim|required');

			$this->form_validation->set_rules('fu_fullname', 'Full Name', 'trim|required');

			$this->form_validation->set_rules('fu_mobile_no', 'Mobile Number', 'trim|required|exact_length[10]|is_natural');

			$this->form_validation->set_rules('fu_emailid', 'Email-ID', 'trim|required|valid_email');

			$this->form_validation->set_rules('adv_cat', 'Discipline', 'trim|required|is_natural_no_zero');



			if ($this->form_validation->run() == TRUE) {

				/*$row_arr2 = array(

					'f_full_name' => trim($fu_fullname)

				);

				$this->main_m->insertRegistration_details_intheDB($row_arr2, $this->session->userdata('member_id'));*/

				$row_arr = array(

					'fu_category' => $adv_cat,

					'fu_step_1' => 1,

					'fu_step1_datetime' => date('Y-m-d H:i:s')

				);

				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {

					$pathurl = 'upload_file/'. $this->data["fuser_detailset"]->f_applied_for .'/candidates/' . $this->data["fuser_detailset"]->f_application_no;
					if (!file_exists($pathurl)) {
						//mkdir('path/to/directory', 0777, true);
						mkdir($pathurl);
					}

					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
				}
			} else {

				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}

			exit;
		} else {

			redirect('default404');
		}
	}

	// ---------------------------------

	// STEP 2 SAVE

	// ---------------------------------

	public function second_step_save()
	{

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$error_section = 1;
			$error_received = '';

			$this->load->helper('file_upload');

			// echo json_encode($_FILES);

			$fu_pic_doc = $userdetails->fu_photo_doc;

			if (isset($_FILES['fu_pic_doc']) && !empty($_FILES['fu_pic_doc'])) {

				$upload_info = upload_file($_FILES['fu_pic_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PHOTO_'), array('jpg', 'jpeg', 'png'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Picture - '.$upload_info['status'].'<br/>';
					//$fu_pic_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_photo_doc);
					$fu_pic_doc = $upload_info['result_path'];
				}
			}

			$fu_sign_doc = $userdetails->fu_signature_doc;

			if (isset($_FILES['fu_sign_doc']) && !empty($_FILES['fu_sign_doc'])) {

				$upload_info = upload_file($_FILES['fu_sign_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('SIGN_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Signature - '.$upload_info['status'].'<br/>';
					//$fu_sign_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_signature_doc);
					$fu_sign_doc = $upload_info['result_path'];
				}
			}

			$fu_address_doc = $userdetails->fu_address_doc;

			if (isset($_FILES['fu_address_doc']) && !empty($_FILES['fu_address_doc'])) {

				$upload_info = upload_file($_FILES['fu_address_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('ADDR_PROOF_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Address Proof - '.$upload_info['status'].'<br/>';
					//$fu_address_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_address_doc);
					$fu_address_doc = $upload_info['result_path'];
				}
			}

		
			if($error_section == 1){

				$mother_name = $this->input->post('mother_name');

				$father_name = $this->input->post('father_name');

				$fu_gender = $this->input->post('fu_gender');

				$fu_mt_status = $this->input->post('fu_mt_status');

				$fu_state = $this->input->post('fu_state');

				$fu_district = $this->input->post('fu_district');

				$fu_sub_division = $this->input->post('fu_sub_division');

				$fu_police_station = $this->input->post('fu_police_station');

				$fu_mb_type = $this->input->post('fu_mb_type');

				$fu_block_municipality = $this->input->post('fu_block_municipality');

				$fu_other_sdiv = $this->input->post('fu_other_sdiv');

				$fu_other_ps = $this->input->post('fu_other_ps');

				$fu_other_district = $this->input->post('fu_other_district');

				$fu_other_blockm = $this->input->post('fu_other_blockm');

				$fu_house_road = $this->input->post('fu_house_road');

				$fu_pincode = $this->input->post('fu_pincode');

				$fu_ward_gp = $this->input->post('fu_ward_gp');

				$fu_post_office = $this->input->post('fu_post_office');

				// $fu_address = $this->input->post('fu_address');

				//$fu_dom_state = $this->input->post('fu_dom_state');
				//$fu_dom_state = $this->input->post('fu_dom_state');
				$same_address = $this->input->post('same_address');
				$com_address = $this->input->post('com_address');

				$fu_per_state = $this->input->post('fu_per_state');

				$fu_per_district = $this->input->post('fu_per_district');

				$fu_per_sub_division = $this->input->post('fu_per_sub_division');

				$fu_per_police_station = $this->input->post('fu_per_police_station');

				$fu_per_mb_type = $this->input->post('fu_per_mb_type');

				$fu_per_block_municipality = $this->input->post('fu_per_block_municipality');

				$fu_per_other_sdiv = $this->input->post('fu_per_other_sdiv');

				$fu_per_other_ps = $this->input->post('fu_per_other_ps');

				$fu_per_other_district = $this->input->post('fu_per_other_district');

				$fu_per_other_blockm = $this->input->post('fu_per_other_blockm');

				$fu_per_house_road = $this->input->post('fu_per_house_road');

				$fu_per_pincode = $this->input->post('fu_per_pincode');

				$fu_per_ward_gp = $this->input->post('fu_per_ward_gp');

				$fu_per_post_office = $this->input->post('fu_per_post_office');

				

				$msg = 0;



				$this->form_validation->set_rules('mother_name', 'Mother Name', 'alpha_numeric_spaces');

				$this->form_validation->set_rules('father_name', 'Father Name', 'alpha_numeric_spaces');

				$this->form_validation->set_rules('fu_gender', 'Gender', 'alpha');

				$this->form_validation->set_rules('fu_mt_status', 'Marital Satatus', 'alpha');

				//$this->form_validation->set_rules('fu_district', 'District', 'numeric');

				$this->form_validation->set_rules('same_address', 'Same Address', 'alpha|required');
				//$this->form_validation->set_rules('fu_dom_state', 'Domicile State', 'numeric');

				$this->form_validation->set_rules('fu_state', 'Present State', 'numeric');
				$this->form_validation->set_rules('fu_district', 'Present District', 'numeric');
				$this->form_validation->set_rules('fu_sub_division', 'Present Sub-Division', 'numeric');
				$this->form_validation->set_rules('fu_police_station', 'Present Police Station', 'numeric');
				$this->form_validation->set_rules('fu_mb_type', 'Municipality /Block Type', 'alpha');
				$this->form_validation->set_rules('fu_block_municipality', 'Block/ Municipality', 'numeric');
				$this->form_validation->set_rules('fu_pincode', 'Pincode', 'numeric');
				if($same_address == "No"){
					$this->form_validation->set_rules('com_address', 'Communication Address', 'alpha');
					$this->form_validation->set_rules('fu_per_state', 'Permanent State', 'numeric');
					$this->form_validation->set_rules('fu_per_district', 'Permanent District', 'numeric');
					$this->form_validation->set_rules('fu_per_sub_division', 'Permanent Sub-Division', 'numeric');
					$this->form_validation->set_rules('fu_per_police_station', 'Permanent Police Station', 'numeric');
					$this->form_validation->set_rules('fu_per_block_municipality', 'Block/ Municipality', 'numeric');
					$this->form_validation->set_rules('fu_per_pincode', 'Pincode', 'numeric');
				}



				// upload_file($_FILES[])



				if ($this->form_validation->run() == TRUE) {

					if ($fu_state == '') {
						$fu_state = NULL;
					}
		
					if ($fu_district == '') {
						$fu_district = NULL;
					}
		
					if ($fu_sub_division == '') {
						$fu_sub_division = NULL;
					}
		
					if ($fu_police_station == '') {
						$fu_police_station = NULL;
					}
		
					if ($fu_mb_type == 'undefined') {
						$fu_mb_type = NULL;
					}
					if ($fu_gender == 'undefined') {
						$fu_gender = NULL;
					}
					if ($fu_mt_status == 'undefined') {
						$fu_mt_status = NULL;
					}
		
					if ($fu_block_municipality == '') {
						$fu_block_municipality = NULL;
					}	

					if ($fu_per_state == '') {
						$fu_per_state = NULL;
					}
		
					if ($fu_per_district == '') {
						$fu_per_district = NULL;
					}
		
					if ($fu_per_sub_division == '') {
						$fu_per_sub_division = NULL;
					}
		
					if ($fu_per_police_station == '') {
						$fu_per_police_station = NULL;
					}
		
					if ($fu_per_mb_type == 'undefined') {
						$fu_per_mb_type = NULL;
					}

					if ($com_address == 'undefined') {
						$com_address = NULL;
					}
		
					if ($fu_per_block_municipality == '') {
						$fu_per_block_municipality = NULL;
					}	

					$row_arr = array(

						'fu_father_name' => trim($father_name),

						'fu_mother_name' => trim($mother_name),

						'fu_gender' => $fu_gender,

						'fu_marital_status' => $fu_mt_status,

						'fu_district' => $fu_district,

						'fu_state' => $fu_state,

						'fu_sub_division' => $fu_sub_division,

						'fu_police_station' => $fu_police_station,

						'fu_mb_type' => $fu_mb_type,

						'fu_block_municipality' => $fu_block_municipality,

						'fu_other_sdiv' => $fu_other_sdiv,

						'fu_other_ps' => $fu_other_ps,

						'fu_other_district' => $fu_other_district,

						'fu_other_blockm' => $fu_other_blockm,

						'fu_house_road' => $fu_house_road,

						'fu_pincode' => $fu_pincode,

						'fu_ward_gp' => $fu_ward_gp,

						'fu_post_office' => $fu_post_office,
						
						'fu_same_address' => $same_address,
						//'fu_domicile_state' => $fu_dom_state,

						'fu_photo_doc' => $fu_pic_doc,

						'fu_signature_doc' => $fu_sign_doc,

						'fu_address_doc' => $fu_address_doc,

						'fu_step_2' => 2,

						'fu_step2_submitdate' => date('Y-m-d H:i:s')

					);

					if($same_address == "Yes"){
						$row_arr['fu_perma_state'] = $fu_state;
						$row_arr['fu_perma_dist'] = $fu_district;
						$row_arr['fu_perma_sub_division'] = $fu_sub_division;
						$row_arr['fu_perma_mb_type'] = $fu_mb_type;
						$row_arr['fu_perma_block_municipality'] = $fu_block_municipality;
						$row_arr['fu_perma_police_station'] = $fu_police_station;
						$row_arr['fu_perma_other_sdiv'] = $fu_other_sdiv;
						$row_arr['fu_perma_other_ps'] = $fu_other_ps;
						$row_arr['fu_perma_other_district'] = $fu_other_district;
						$row_arr['fu_perma_other_blockm'] = $fu_other_blockm;
						$row_arr['fu_perma_ward_gp'] = $fu_ward_gp;
						$row_arr['fu_perma_house_road'] = $fu_house_road;
						$row_arr['fu_perma_post_office'] = $fu_post_office;
						$row_arr['fu_perma_pincode'] = $fu_pincode;
						$row_arr['fu_comunication_address'] = "Present";
					}else{
						$row_arr['fu_perma_state'] = $fu_per_state;
						$row_arr['fu_perma_dist'] = $fu_per_district;
						$row_arr['fu_perma_sub_division'] = $fu_per_sub_division;
						$row_arr['fu_perma_mb_type'] = $fu_per_mb_type;
						$row_arr['fu_perma_block_municipality'] = $fu_per_block_municipality;
						$row_arr['fu_perma_police_station'] = $fu_per_police_station;
						$row_arr['fu_perma_other_sdiv'] = $fu_per_other_sdiv;
						$row_arr['fu_perma_other_ps'] = $fu_per_other_ps;
						$row_arr['fu_perma_other_district'] = $fu_per_other_district;
						$row_arr['fu_perma_other_blockm'] = $fu_per_other_blockm;
						$row_arr['fu_perma_ward_gp'] = $fu_per_ward_gp;
						$row_arr['fu_perma_house_road'] = $fu_per_house_road;
						$row_arr['fu_perma_post_office'] = $fu_per_post_office;
						$row_arr['fu_perma_pincode'] = $fu_per_pincode;
						$row_arr['fu_comunication_address'] = $com_address;
					}

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {



						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
					}
				} else echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}

		} else redirect('default404');
	}

	// ---------------------------------

	// STEP 2 PROCESSING

	// ---------------------------------

	public function second_step_processing()
	{


		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$error_section = 1;
			$error_received = '';
			$this->load->helper('file_upload');

			// echo json_encode($_FILES);

			$fu_pic_doc = $userdetails->fu_photo_doc;

			if (isset($_FILES['fu_pic_doc']) && !empty($_FILES['fu_pic_doc'])) {
				$upload_info = upload_file($_FILES['fu_pic_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PHOTO_'), array('jpg', 'jpeg', 'png'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Picture - '.$upload_info['status'].'<br/>';
					//$fu_pic_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_photo_doc);
					$fu_pic_doc = $upload_info['result_path'];
				}
			}


			$fu_sign_doc = $userdetails->fu_signature_doc;

			if (isset($_FILES['fu_sign_doc']) && !empty($_FILES['fu_sign_doc'])) {
				$upload_info = upload_file($_FILES['fu_sign_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('SIGN_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Signature - '.$upload_info['status'].'<br/>';
					//$fu_sign_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_signature_doc);
					$fu_sign_doc = $upload_info['result_path'];
				}
			}


			$fu_address_doc = $userdetails->fu_address_doc;

			if (isset($_FILES['fu_address_doc']) && !empty($_FILES['fu_address_doc'])) {
				$upload_info = upload_file($_FILES['fu_address_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('ADDR_PROOF_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Address Proof - '.$upload_info['status'].'<br/>';
					//$fu_address_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_address_doc);
					$fu_address_doc = $upload_info['result_path'];
				}
			}


			if($error_section == 1){

				$mother_name = $this->input->post('mother_name');

				$father_name = $this->input->post('father_name');

				$fu_gender = $this->input->post('fu_gender');

				$fu_mt_status = $this->input->post('fu_mt_status');

				$fu_state = $this->input->post('fu_state');

				$fu_district = $this->input->post('fu_district');

				$fu_sub_division = $this->input->post('fu_sub_division');

				$fu_police_station = $this->input->post('fu_police_station');

				$fu_mb_type = $this->input->post('fu_mb_type');

				$fu_block_municipality = $this->input->post('fu_block_municipality');

				$fu_other_sdiv = $this->input->post('fu_other_sdiv');

				$fu_other_ps = $this->input->post('fu_other_ps');

				$fu_other_district = $this->input->post('fu_other_district');

				$fu_other_blockm = $this->input->post('fu_other_blockm');

				$fu_house_road = $this->input->post('fu_house_road');

				$fu_pincode = $this->input->post('fu_pincode');

				$fu_ward_gp = $this->input->post('fu_ward_gp');

				$fu_post_office = $this->input->post('fu_post_office');

				//$fu_dom_state = $this->input->post('fu_dom_state');
				$same_address = $this->input->post('same_address');
				$com_address = $this->input->post('com_address');

				$fu_per_state = $this->input->post('fu_per_state');

				$fu_per_district = $this->input->post('fu_per_district');

				$fu_per_sub_division = $this->input->post('fu_per_sub_division');

				$fu_per_police_station = $this->input->post('fu_per_police_station');

				$fu_per_mb_type = $this->input->post('fu_per_mb_type');

				$fu_per_block_municipality = $this->input->post('fu_per_block_municipality');

				$fu_per_other_sdiv = $this->input->post('fu_per_other_sdiv');

				$fu_per_other_ps = $this->input->post('fu_per_other_ps');

				$fu_per_other_district = $this->input->post('fu_per_other_district');

				$fu_per_other_blockm = $this->input->post('fu_per_other_blockm');

				$fu_per_house_road = $this->input->post('fu_per_house_road');

				$fu_per_pincode = $this->input->post('fu_per_pincode');

				$fu_per_ward_gp = $this->input->post('fu_per_ward_gp');

				$fu_per_post_office = $this->input->post('fu_per_post_office');

				$msg = 0;



				$this->form_validation->set_rules('mother_name', 'Mother Name', 'alpha_numeric_spaces|required');

				$this->form_validation->set_rules('father_name', 'Father Name', 'alpha_numeric_spaces|required');

				$this->form_validation->set_rules('fu_gender', 'Gender', 'alpha|required');

				$this->form_validation->set_rules('fu_mt_status', 'Marital Satatus', 'alpha|required');

				$this->form_validation->set_rules('same_address', 'Same Address', 'alpha|required');
				

				// $this->form_validation->set_rules('fu_district', 'District', 'numeric|required');
				
				$this->form_validation->set_rules('fu_state', 'Present State', 'numeric|required');
				$this->form_validation->set_rules('fu_mb_type', 'Municipality /Block Type', 'alpha');
				$this->form_validation->set_rules('fu_block_municipality', 'Block/ Municipality', 'numeric');
				$this->form_validation->set_rules('fu_house_road', 'Vill / Para / House No / Road', 'required');
				$this->form_validation->set_rules('fu_ward_gp', 'Ward/GP', 'required');
				$this->form_validation->set_rules('fu_post_office', 'Post Office', 'required');
				$this->form_validation->set_rules('fu_pincode', 'Pincode', 'numeric|required');
				if($fu_state != 28){
					$this->form_validation->set_rules('fu_other_district', 'Present District', 'required');
					$this->form_validation->set_rules('fu_other_sdiv', 'Present Sub-Division', 'required');
					$this->form_validation->set_rules('fu_other_blockm', 'Present Municipality /Block', 'required');
					$this->form_validation->set_rules('fu_other_ps', 'Present Police Station', 'required');
				}else{
					$this->form_validation->set_rules('fu_district', 'Present District', 'numeric|required');
					if ($fu_district != 342) {
						$this->form_validation->set_rules('fu_sub_division', 'Present Sub-Division', 'numeric|required');
					}
					$this->form_validation->set_rules('fu_police_station', 'Present Police Station', 'numeric|required');
				}
				if($same_address == "No"){
					$this->form_validation->set_rules('com_address', 'Communication Address', 'alpha|required');
					$this->form_validation->set_rules('fu_per_state', 'Permanent State', 'numeric|required');
					$this->form_validation->set_rules('fu_per_mb_type', 'Municipality /Block Type', 'alpha');
					$this->form_validation->set_rules('fu_per_block_municipality', 'Block/ Municipality', 'numeric');
					$this->form_validation->set_rules('fu_per_house_road', 'Vill / Para / House No / Road', 'required');
					$this->form_validation->set_rules('fu_per_ward_gp', 'Ward/GP', 'required');
					$this->form_validation->set_rules('fu_per_post_office', 'Post Office', 'required');
					$this->form_validation->set_rules('fu_per_pincode', 'Pincode', 'numeric|required');
					if($fu_per_state != 28){
						$this->form_validation->set_rules('fu_per_other_district', 'Permanent District', 'required');
						$this->form_validation->set_rules('fu_per_other_sdiv', 'Permanent Sub-Division', 'required');
						$this->form_validation->set_rules('fu_per_other_blockm', 'Permanent Municipality /Block', 'required');
						$this->form_validation->set_rules('fu_per_other_ps', 'Permanent Police Station', 'required');
					}else{
						$this->form_validation->set_rules('fu_per_district', 'Permanent District', 'numeric|required');
						if ($fu_per_district != 342) {
							$this->form_validation->set_rules('fu_per_sub_division', 'Permanent Sub-Division', 'numeric|required');
						}
						$this->form_validation->set_rules('fu_per_police_station', 'Permanent Police Station', 'numeric|required');
					}
				}
				// upload_file($_FILES[])

				if ($this->form_validation->run() == TRUE) {

					if($fu_state != 28){
						$fu_district = NULL;
						$fu_sub_division = NULL;
						$fu_mb_type = NULL;
						$fu_block_municipality = NULL;
						$fu_police_station = NULL;
					}else{
						if ($fu_district == 342) {
							$fu_sub_division = NULL;
							$fu_mb_type = NULL;
							$fu_block_municipality = NULL;
						}
					}

					$row_arr = array(

						'fu_father_name' => trim($father_name),

						'fu_mother_name' => trim($mother_name),

						'fu_gender' => $fu_gender,

						'fu_marital_status' => $fu_mt_status,

						'fu_state' => $fu_state,

						'fu_district' => $fu_district,

						'fu_sub_division' => $fu_sub_division,

						'fu_police_station' => $fu_police_station,

						'fu_mb_type' => $fu_mb_type,

						'fu_block_municipality' => $fu_block_municipality,

						'fu_other_sdiv' => $fu_other_sdiv,

						'fu_other_ps' => $fu_other_ps,

						'fu_other_district' => $fu_other_district,

						'fu_other_blockm' => $fu_other_blockm,

						'fu_ward_gp' => $fu_ward_gp,

						'fu_house_road' => $fu_house_road,

						'fu_post_office' => $fu_post_office,

						'fu_pincode' => $fu_pincode,

						'fu_same_address' => $same_address,
						//'fu_comunication_address' => $com_address,
						//'fu_domicile_state' => $fu_dom_state,

						'fu_photo_doc' => $fu_pic_doc,

						'fu_signature_doc' => $fu_sign_doc,

						'fu_address_doc' => $fu_address_doc,

						'fu_step_2' => 1,

						'fu_step2_submitdate' => date('Y-m-d H:i:s')

					);

					if($same_address == "Yes"){
						$row_arr['fu_perma_state'] = $fu_state;
						$row_arr['fu_perma_dist'] = $fu_district;
						$row_arr['fu_perma_sub_division'] = $fu_sub_division;
						$row_arr['fu_perma_mb_type'] = $fu_mb_type;
						$row_arr['fu_perma_block_municipality'] = $fu_block_municipality;
						$row_arr['fu_perma_police_station'] = $fu_police_station;
						$row_arr['fu_perma_other_sdiv'] = $fu_other_sdiv;
						$row_arr['fu_perma_other_ps'] = $fu_other_ps;
						$row_arr['fu_perma_other_district'] = $fu_other_district;
						$row_arr['fu_perma_other_blockm'] = $fu_other_blockm;
						$row_arr['fu_perma_ward_gp'] = $fu_ward_gp;
						$row_arr['fu_perma_house_road'] = $fu_house_road;
						$row_arr['fu_perma_post_office'] = $fu_post_office;
						$row_arr['fu_perma_pincode'] = $fu_pincode;
						$row_arr['fu_comunication_address'] = "Present";
					}else{
						if($fu_per_state != 28){
							$fu_per_district = NULL;
							$fu_per_sub_division = NULL;
							$fu_per_mb_type = NULL;
							$fu_per_block_municipality = NULL;
							$fu_per_police_station = NULL;
						}else{
							if ($fu_per_district == 342) {
								$fu_per_sub_division = NULL;
								$fu_per_mb_type = NULL;
								$fu_per_block_municipality = NULL;
							}
						}
						$row_arr['fu_perma_state'] = $fu_per_state;
						$row_arr['fu_perma_dist'] = $fu_per_district;
						$row_arr['fu_perma_sub_division'] = $fu_per_sub_division;
						$row_arr['fu_perma_mb_type'] = $fu_per_mb_type;
						$row_arr['fu_perma_block_municipality'] = $fu_per_block_municipality;
						$row_arr['fu_perma_police_station'] = $fu_per_police_station;
						$row_arr['fu_perma_other_sdiv'] = $fu_per_other_sdiv;
						$row_arr['fu_perma_other_ps'] = $fu_per_other_ps;
						$row_arr['fu_perma_other_district'] = $fu_per_other_district;
						$row_arr['fu_perma_other_blockm'] = $fu_per_other_blockm;
						$row_arr['fu_perma_ward_gp'] = $fu_per_ward_gp;
						$row_arr['fu_perma_house_road'] = $fu_per_house_road;
						$row_arr['fu_perma_post_office'] = $fu_per_post_office;
						$row_arr['fu_perma_pincode'] = $fu_per_pincode;
						$row_arr['fu_comunication_address'] = $com_address;
					}

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
					}
				} else echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}

		} else redirect('default404');
	}



	// ---------------------------------

	// STEP 3 SAVE

	// ---------------------------------

	public function third_step_save()
	{

		if (isset($_POST) && !empty($_POST)) {
		
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';

			// echo json_encode($_FILES);


			$fu_caste_doc = $userdetails->fu_caste_doc;

			if (isset($_FILES['fu_caste_doc']) && !empty($_FILES['fu_caste_doc'])) {
				$upload_info = upload_file($_FILES['fu_caste_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Caste_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Caste - '.$upload_info['status'].'<br/>';
					//$fu_caste_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_caste_doc);
					$fu_caste_doc = $upload_info['result_path'];
				}
			}

			$fu_pwd_doc = $userdetails->fu_pwd_doc;

			if (isset($_FILES['fu_pwd_doc']) && !empty($_FILES['fu_pwd_doc'])) {
				$upload_info = upload_file($_FILES['fu_pwd_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PWD_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'PWD - '.$upload_info['status'].'<br/>';
					//$fu_pwd_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_pwd_doc);
					$fu_pwd_doc = $upload_info['result_path'];
				}
			}

			$fu_exc_doc = $userdetails->fu_exc_doc;

			if (isset($_FILES['fu_exc_doc']) && !empty($_FILES['fu_exc_doc'])) {
				$upload_info = upload_file($_FILES['fu_exc_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exempted_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Exempted - '.$upload_info['status'].'<br/>';
					//$fu_exc_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exc_doc);
					$fu_exc_doc = $upload_info['result_path'];
				}
			}

			$fu_exs_doc = $userdetails->fu_exs_doc;

			if (isset($_FILES['fu_exs_doc']) && !empty($_FILES['fu_exs_doc'])) {
				$upload_info = upload_file($_FILES['fu_exs_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exservice_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Exservice - '.$upload_info['status'].'<br/>';
					//$fu_exs_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exs_doc);
					$fu_exs_doc = $upload_info['result_path'];
				}
			}

			$fu_ews_doc = $userdetails->fu_ews_doc;

			if (isset($_FILES['fu_ews_doc']) && !empty($_FILES['fu_ews_doc'])) {
				$upload_info = upload_file($_FILES['fu_ews_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('EWS_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'EWS - '.$upload_info['status'].'<br/>';
					//$fu_ews_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_ews_doc);
					$fu_ews_doc = $upload_info['result_path'];
				}
			}


			if($error_section == 1){

				$fu_caste_type = $this->input->post('fu_caste_type');

				$com_castetypeset = $this->input->post('com_castetypeset');

				$com_attachdoc_set = $this->input->post('com_attachdoc_set');

				$fu_caste_community = $this->input->post('fu_caste_community');

				$fu_caste_number = $this->input->post('fu_caste_number');

				$fu_caste_issue_whom = $this->input->post('fu_caste_issue_whom');

				$fu_caste_issue_date = $this->input->post('fu_caste_issue_date');


				$fu_pwd = $this->input->post('fu_pwd');

				$fu_pwd_percent = $this->input->post('fu_pwd_percent');

				$fu_pwd_issue_whom = $this->input->post('fu_pwd_issue_whom');

				$fu_pwd_issue_date = $this->input->post('fu_pwd_issue_date');


				$fu_exempted = $this->input->post('fu_exempted');

				$fu_exc_reason = $this->input->post('fu_exc_reason');

				$fu_exservice = $this->input->post('fu_exservice');

				$fu_exs_reason = $this->input->post('fu_exs_reason');

				$fu_ews = $this->input->post('fu_ews');

				$fu_ews_reason = $this->input->post('fu_ews_reason');

				$this->form_validation->set_rules('fu_caste_type', 'Caste', 'numeric|required');

				$msg = 0;
				
				if($com_attachdoc_set != 1){
					$fu_exempted = NULL;
				}
				if($com_attachdoc_set != 2){
					$fu_exservice = NULL;
				}
				if($com_attachdoc_set != 3){
					$fu_ews = NULL;
				}


				if($this->form_validation->run() == TRUE){

					//if ($fu_caste_type == "undefined"){ $fu_caste_type = NULL; }

					if ($fu_pwd == "undefined"){ $fu_pwd = NULL; }

					if ($fu_caste_type == 1) {
						$fu_caste_community = NULL;
						$fu_caste_number = NULL;
						$fu_caste_issue_whom = NULL;
						$fu_caste_issue_date = NULL;
						$fu_caste_doc = NULL;
					}else{
						if($com_castetypeset == 1){
							$fu_caste_community = NULL;
							$fu_caste_number = NULL;
							$fu_caste_issue_whom = NULL;
							$fu_caste_issue_date = NULL;
							$fu_caste_doc = NULL;
						}else{
							if($fu_caste_community == ""){$fu_caste_community = NULL;}
							if($fu_caste_number == ""){$fu_caste_number = NULL;}
							if($fu_caste_issue_whom == ""){$fu_caste_issue_whom = NULL;}
							if(!empty($fu_caste_issue_date)){
								$fu_caste_issue_date = date('Y-m-d',strtotime($fu_caste_issue_date));
							}
						}
					}
					if ($fu_pwd == "No") {
						$fu_pwd_percent = NULL;
						$fu_pwd_issue_whom = NULL;
						$fu_pwd_issue_date = NULL;
						$fu_pwd_doc = NULL;
					}else{
						if($fu_pwd_percent == ""){$fu_pwd_percent = NULL;}
						if($fu_pwd_issue_whom == ""){$fu_pwd_issue_whom = NULL;}
						if(!empty($fu_pwd_issue_date)){
							$fu_pwd_issue_date = date('Y-m-d',strtotime($fu_pwd_issue_date));
						}
					}
					if ($fu_exempted == "No" || $fu_exempted == NULL) {
						$fu_exc_reason = NULL;
						$fu_exc_doc = NULL;
					}
					if ($fu_exservice == "No" || $fu_exservice == NULL) {
						$fu_exs_reason = NULL;
						$fu_exs_doc = NULL;
					}
					if ($fu_ews == "No" || $fu_ews == NULL) {
						$fu_ews_reason = NULL;
						$fu_ews_doc = NULL;
					}


					$row_arr = array(
						'fu_caste_type' => $fu_caste_type,
						'fu_caste_community' => $fu_caste_community,
						'fu_caste_number' => $fu_caste_number,
						'fu_caste_issue_whom' => $fu_caste_issue_whom,
						'fu_caste_issue_date' => $fu_caste_issue_date,
						'fu_caste_doc' => $fu_caste_doc,
						'fu_pwd' => $fu_pwd,
						'fu_pwd_percent' => $fu_pwd_percent,
						'fu_pwd_issue_whom' => $fu_pwd_issue_whom,
						'fu_pwd_issue_date' => $fu_pwd_issue_date,
						'fu_pwd_doc' => $fu_pwd_doc,
						'fu_exempted' => $fu_exempted,
						'fu_exc_reason' => $fu_exc_reason,
						'fu_exc_doc' => $fu_exc_doc,
						'fu_exservice' => $fu_exservice,
						'fu_exs_reason' => $fu_exs_reason,
						'fu_exs_doc' => $fu_exs_doc,
						'fu_ews' => $fu_ews,
						'fu_ews_reason' => $fu_ews_reason,
						'fu_ews_doc' => $fu_ews_doc,
						'fu_step_3' => 2,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					$extage_list = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);
					$errorcounter = 0;
					$errormsg = '';
					if(count((array)$extage_list) > 0){
						$fu_extage = $this->input->post('fu_extage');
						$fu_extage_reason = $this->input->post('fu_extage_reason');
						//print_r($fu_extage);
						//print_r($fu_extage_reason);
						//print_r($_FILES);exit;
						foreach($extage_list as $keys=>$extageitem){
							//echo $fu_extage[$keys];exit;
							if($fu_extage[$keys] == '' || $fu_extage[$keys] == "undefined"){
								$fu_extage[$keys] = NULL;
							}
							if($fu_extage[$keys] != "Yes"){
								$fu_extage_reason[$keys] = NULL;
							}

							if (!empty($_FILES['files']['name'][$keys+1])) {
								$filename = $_FILES['files']['name'][$keys+1];
								$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
								$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
								$config['overwrite'] = FALSE;
								$config['remove_spaces'] = TRUE;
								$config['max_size'] = '2050';
								$config['file_name'] = $filename;

								$this->load->library('upload', $config);
								$this->upload->initialize($config);

								$_FILES['attachments']['name']= $_FILES['files']['name'][$keys+1];
								$_FILES['attachments']['type']= $_FILES['files']['type'][$keys+1];
								$_FILES['attachments']['tmp_name']= $_FILES['files']['tmp_name'][$keys+1];
								$_FILES['attachments']['error']= $_FILES['files']['error'][$keys+1];
								$_FILES['attachments']['size']= $_FILES['files']['size'][$keys+1];

								if ($this->upload->do_upload('attachments')) {
									$upload_data = $this->upload->data();
									
									$row_arr2 = array(
										'fu_ext_masteruser' => $this->session->userdata('member_id'),
										'fu_ext_ageid' => $extageitem->advage_section,
										'fu_ext_answer' => $fu_extage[$keys],
										'fu_ext_reason' => $fu_extage_reason[$keys],
										'fu_ext_doc' => $upload_data['file_name']
									);

									$resurnset = $this->member_m->checkExistense_of_ExtraAgeset($extageitem->advage_section);
									if($resurnset != FALSE){
										$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
										if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
											break;
										}else{
											if(!empty($resurnset->fu_ext_doc)){
												unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$resurnset->fu_ext_doc);
											}
										}
									}else{
										$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
										if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
											break;
										}
									}
								}else{
									$errorcounter++;
									$errormsg = $errormsg.$extageitem->caste_name.': File Not Upload Properly';
									break;
								}
							}else{
								$resurnset = $this->member_m->checkExistense_of_ExtraAgeset($extageitem->advage_section);
								if(!empty($resurnset)){
									if($fu_extage[$keys] == "Yes"){
										if($resurnset->fu_ext_doc == "" || $resurnset->fu_ext_doc == "NULL"){
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': File Not Upload Properly';
											break;
										}else{
											$row_arr2 = array(
												'fu_ext_masteruser' => $this->session->userdata('member_id'),
												'fu_ext_ageid' => $extageitem->advage_section,
												'fu_ext_answer' => $fu_extage[$keys],
												'fu_ext_reason' => $fu_extage_reason[$keys]
											);
											if($resurnset != FALSE){
												$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}else{
												$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}
										}
									}else{
										$row_arr2 = array(
											'fu_ext_masteruser' => $this->session->userdata('member_id'),
											'fu_ext_ageid' => $extageitem->advage_section,
											'fu_ext_answer' => $fu_extage[$keys],
											'fu_ext_reason' => $fu_extage_reason[$keys]
										);
										if($resurnset != FALSE){
											$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}else{
											$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}
									}
								}else{
									if($fu_extage[$keys] == "No"){
										$row_arr2 = array(
											'fu_ext_masteruser' => $this->session->userdata('member_id'),
											'fu_ext_ageid' => $extageitem->advage_section,
											'fu_ext_answer' => $fu_extage[$keys],
											'fu_ext_reason' => $fu_extage_reason[$keys]
										);
										if($resurnset != FALSE){
											$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}else{
											$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}
									}elseif($fu_extage[$keys] == "Yes"){
										$row_arr2 = array(
											'fu_ext_masteruser' => $this->session->userdata('member_id'),
											'fu_ext_ageid' => $extageitem->advage_section,
											'fu_ext_answer' => $fu_extage[$keys],
											'fu_ext_reason' => $fu_extage_reason[$keys]
										);
										if($resurnset != FALSE){
											$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}else{
											$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}
									}
								}
							}
						}
						//echo $errormsg;
						//exit;
					}

					if($errorcounter == 0){
						if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {

							echo json_encode(array('msg' => 1, 's_msg' => ''));
						} else {
		
							echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
						}
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => $errormsg));
					}

					

				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}

		} else redirect('default404');
	}



	public function third_step_processing()
	{

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_caste_doc = $userdetails->fu_caste_doc;

			if (isset($_FILES['fu_caste_doc']) && !empty($_FILES['fu_caste_doc'])) {
				$upload_info = upload_file($_FILES['fu_caste_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Caste_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Caste - '.$upload_info['status'].'<br/>';
					//$fu_caste_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_caste_doc);
					$fu_caste_doc = $upload_info['result_path'];
				}
			}


			$fu_pwd_doc = $userdetails->fu_pwd_doc;

			if (isset($_FILES['fu_pwd_doc']) && !empty($_FILES['fu_pwd_doc'])) {
				$upload_info = upload_file($_FILES['fu_pwd_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PWD_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'PWD - '.$upload_info['status'].'<br/>';
					//$fu_pwd_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_pwd_doc);
					$fu_pwd_doc = $upload_info['result_path'];
				}
			}


			$fu_exc_doc = $userdetails->fu_exc_doc;

			if (isset($_FILES['fu_exc_doc']) && !empty($_FILES['fu_exc_doc'])) {
				$upload_info = upload_file($_FILES['fu_exc_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exempted_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Exempted - '.$upload_info['status'].'<br/>';
					//$fu_exc_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exc_doc);
					$fu_exc_doc = $upload_info['result_path'];
				}
			}


			$fu_exs_doc = $userdetails->fu_exs_doc;

			if (isset($_FILES['fu_exs_doc']) && !empty($_FILES['fu_exs_doc'])) {
				$upload_info = upload_file($_FILES['fu_exs_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exservice_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Exservice - '.$upload_info['status'].'<br/>';
					//$fu_exs_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exs_doc);
					$fu_exs_doc = $upload_info['result_path'];
				}
			}

			$fu_ews_doc = $userdetails->fu_ews_doc;

			if (isset($_FILES['fu_ews_doc']) && !empty($_FILES['fu_ews_doc'])) {
				$upload_info = upload_file($_FILES['fu_ews_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('EWS_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'EWS - '.$upload_info['status'].'<br/>';
					//$fu_ews_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_ews_doc);
					$fu_ews_doc = $upload_info['result_path'];
				}
			}

			
			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');

				$fu_caste_type = $this->input->post('fu_caste_type');

				$com_castetypeset = $this->input->post('com_castetypeset');
				$com_attachdoc_set = $this->input->post('com_attachdoc_set');

				$fu_caste_community = $this->input->post('fu_caste_community');

				$fu_caste_number = $this->input->post('fu_caste_number');

				$fu_caste_issue_whom = $this->input->post('fu_caste_issue_whom');

				$fu_caste_issue_date = $this->input->post('fu_caste_issue_date');


				$fu_pwd = $this->input->post('fu_pwd');

				$fu_pwd_percent = $this->input->post('fu_pwd_percent');

				$fu_pwd_issue_whom = $this->input->post('fu_pwd_issue_whom');

				$fu_pwd_issue_date = $this->input->post('fu_pwd_issue_date');


				$fu_exempted = $this->input->post('fu_exempted');

				$fu_exc_reason = $this->input->post('fu_exc_reason');

				$fu_exservice = $this->input->post('fu_exservice');

				$fu_exs_reason = $this->input->post('fu_exs_reason');

				$fu_ews = $this->input->post('fu_ews');

				$fu_ews_reason = $this->input->post('fu_ews_reason');

				$msg = 0;

				$this->form_validation->set_rules('fu_caste_type', 'Caste', 'numeric|required');
				if($fu_caste_type != 1){
					$this->form_validation->set_rules('com_castetypeset', 'Caste Type Set', 'numeric|required');
					if($com_castetypeset == 2){
						$this->form_validation->set_rules('fu_caste_community', 'Caste/ Tribe/ Community', 'numeric|required');
						$this->form_validation->set_rules('fu_caste_number', 'Caste Certification No.', 'required');
						$this->form_validation->set_rules('fu_caste_issue_whom', 'Caste Issued By Whom', 'numeric|required');
						$this->form_validation->set_rules('fu_caste_issue_date', 'Caste Issued Date', 'required');
					}
				}
				$this->form_validation->set_rules('fu_pwd', 'PWD', 'alpha|required');
				if($fu_pwd == "Yes"){
					$this->form_validation->set_rules('fu_pwd_percent', 'PWD Percent', 'numeric|required');
					$this->form_validation->set_rules('fu_pwd_issue_whom', 'PWD Issued By Whom', 'required');
					$this->form_validation->set_rules('fu_pwd_issue_date', 'PWD Issued Date', 'required');
				}

				if($com_attachdoc_set == 1){
					$this->form_validation->set_rules('fu_exempted', 'Exempted', 'alpha|required');
					$this->form_validation->set_rules('fu_exc_reason', 'Exempted Reason', 'required');
				}else{
					$fu_exempted = NULL;
				}
				if($com_attachdoc_set == 2){
					$this->form_validation->set_rules('fu_exservice', 'Ex Serviceman', 'alpha|required');
					$this->form_validation->set_rules('fu_exs_reason', 'Ex Serviceman Description', 'required');
				}else{
					$fu_exservice = NULL;
				}
				if($com_attachdoc_set == 3){
					$this->form_validation->set_rules('fu_ews', 'Sprots Man', 'alpha|required');
					$this->form_validation->set_rules('fu_ews_reason', 'Sprots Description', 'required');
				}else{
					$fu_ews = NULL;
				}

				// upload_file($_FILES[])

				if($this->form_validation->run() == TRUE){
					//echo "hi";exit;
					if ($fu_caste_type == 1) {
						$fu_caste_community = NULL;
						$fu_caste_number = NULL;
						$fu_caste_issue_whom = NULL;
						$fu_caste_issue_date = NULL;
						$fu_caste_doc = NULL;
					}else{
						if($com_castetypeset == 1){
							$fu_caste_community = NULL;
							$fu_caste_number = NULL;
							$fu_caste_issue_whom = NULL;
							$fu_caste_issue_date = NULL;
							$fu_caste_doc = NULL;
						}else{
							$fu_caste_issue_date = date('Y-m-d',strtotime($fu_caste_issue_date));
						}
					}
					if ($fu_pwd == "No") {
						$fu_pwd_percent = NULL;
						$fu_pwd_issue_whom = NULL;
						$fu_pwd_issue_date = NULL;
						$fu_pwd_doc = NULL;
					}else{
						$fu_pwd_issue_date = date('Y-m-d',strtotime($fu_pwd_issue_date));
					}
					if($com_attachdoc_set != 1){
						//if ($fu_exempted == "No" || $fu_exempted == NULL) {
							$fu_exempted == NULL;
							$fu_exc_reason = NULL;
							$fu_exc_doc = NULL;
						//}
					}
					if($com_attachdoc_set != 2){
						//if ($fu_exservice == "No" || $fu_exservice == NULL) {
							$fu_exservice == NULL;
							$fu_exs_reason = NULL;
							$fu_exs_doc = NULL;
						//}
					}
					if($com_attachdoc_set != 3){
						//if ($fu_ews == "No" || $fu_ews == NULL) {
							$fu_ews == NULL;
							$fu_ews_reason = NULL;
							$fu_ews_doc = NULL;
						//}
					}

					$row_arr = array(
						//'fu_caste' => $fu_caste,
						'fu_caste_type' => $fu_caste_type,
						'fu_caste_community' => $fu_caste_community,
						'fu_caste_number' => $fu_caste_number,
						'fu_caste_issue_whom' => $fu_caste_issue_whom,
						'fu_caste_issue_date' => $fu_caste_issue_date,
						'fu_caste_doc' => $fu_caste_doc,
						'fu_pwd' => $fu_pwd,
						'fu_pwd_percent' => $fu_pwd_percent,
						'fu_pwd_issue_whom' => $fu_pwd_issue_whom,
						'fu_pwd_issue_date' => $fu_pwd_issue_date,
						'fu_pwd_doc' => $fu_pwd_doc,
						'fu_exempted' => $fu_exempted,
						'fu_exc_reason' => $fu_exc_reason,
						'fu_exc_doc' => $fu_exc_doc,
						'fu_exservice' => $fu_exservice,
						'fu_exs_reason' => $fu_exs_reason,
						'fu_exs_doc' => $fu_exs_doc,
						'fu_ews' => $fu_ews,
						'fu_ews_reason' => $fu_ews_reason,
						'fu_ews_doc' => $fu_ews_doc,
						'fu_step_3' => 1,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					$extage_list = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);
					$errorcounter = 0;
					$errormsg = '';
					if(count((array)$extage_list) > 0){
						$fu_extage = $this->input->post('fu_extage');
						$fu_extage_reason = $this->input->post('fu_extage_reason');
						foreach($extage_list as $keys=>$extageitem){
							//echo $fu_extage[$keys];exit;
							if($fu_extage[$keys] == '' || $fu_extage[$keys] == "undefined"){
								$errorcounter++;
								$errormsg = $errormsg.$extageitem->caste_name.': Field Required';
								break;
							}
							if($fu_extage[$keys] == "Yes"){
								if($fu_extage_reason[$keys] == ''){
									$errorcounter++;
									$errormsg = $errormsg.$extageitem->caste_name.': Detail Description Required';
									break;
								}
							}

							if($fu_extage[$keys] == "Yes"){
								if (!empty($_FILES['files']['name'][$keys+1])) {
									$filename = $_FILES['files']['name'][$keys+1];
									$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
									$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
									$config['overwrite'] = FALSE;
									$config['remove_spaces'] = TRUE;
									$config['max_size'] = '2050';
									$config['file_name'] = $filename;

									$this->load->library('upload', $config);
									$this->upload->initialize($config);

									$_FILES['attachments']['name']= $_FILES['files']['name'][$keys+1];
									$_FILES['attachments']['type']= $_FILES['files']['type'][$keys+1];
									$_FILES['attachments']['tmp_name']= $_FILES['files']['tmp_name'][$keys+1];
									$_FILES['attachments']['error']= $_FILES['files']['error'][$keys+1];
									$_FILES['attachments']['size']= $_FILES['files']['size'][$keys+1];

									if ($this->upload->do_upload('attachments')) {
										$upload_data = $this->upload->data();
										
										$row_arr2 = array(
											'fu_ext_masteruser' => $this->session->userdata('member_id'),
											'fu_ext_ageid' => $extageitem->advage_section,
											'fu_ext_answer' => $fu_extage[$keys],
											'fu_ext_reason' => $fu_extage_reason[$keys],
											'fu_ext_doc' => $upload_data['file_name']
										);

										$resurnset = $this->member_m->checkExistense_of_ExtraAgeset($extageitem->advage_section);
										if($resurnset != FALSE){
											$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}else{
												if(!empty($resurnset->fu_ext_doc)){
													unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$resurnset->fu_ext_doc);
												}
											}
										}else{
											$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
											if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
											}
										}
									}else{
										$errorcounter++;
										$errormsg = $errormsg.$extageitem->caste_name.': File Not Upload Properly';
										break;
									}
								}else{
									$resurnset = $this->member_m->checkExistense_of_ExtraAgeset($extageitem->advage_section);
									if(!empty($resurnset)){
										if($fu_extage[$keys] == "Yes"){
											if($resurnset->fu_ext_doc == "" || $resurnset->fu_ext_doc == "NULL"){
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': File Not Upload Properly';
												break;
											}else{
												$row_arr2 = array(
													'fu_ext_masteruser' => $this->session->userdata('member_id'),
													'fu_ext_ageid' => $extageitem->advage_section,
													'fu_ext_answer' => $fu_extage[$keys],
													'fu_ext_reason' => $fu_extage_reason[$keys]
												);
												if($resurnset != FALSE){
													$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
													if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
														$errorcounter++;
														$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
														break;
													}
												}else{
													$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
													if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
														$errorcounter++;
														$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
														break;
													}
												}
											}
										}else{
											$row_arr2 = array(
												'fu_ext_masteruser' => $this->session->userdata('member_id'),
												'fu_ext_ageid' => $extageitem->advage_section,
												'fu_ext_answer' => $fu_extage[$keys],
												'fu_ext_reason' => $fu_extage_reason[$keys]
											);
											if($resurnset != FALSE){
												$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}else{
												$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}
										}
									}else{
										if($fu_extage[$keys] == "No"){
											$row_arr2 = array(
												'fu_ext_masteruser' => $this->session->userdata('member_id'),
												'fu_ext_ageid' => $extageitem->advage_section,
												'fu_ext_answer' => $fu_extage[$keys],
												'fu_ext_reason' => $fu_extage_reason[$keys]
											);
											if($resurnset != FALSE){
												$row_arr2['fu_ext_modifydate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}else{
												$row_arr2['fu_ext_createdate'] = date('Y-m-d H:i:s');
												if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
													$errorcounter++;
													$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
													break;
												}
											}
										}else{
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': Data Not Found';
											break;
										}
									}
								}
							}elseif($fu_extage[$keys] == "No"){
								$resurnset = $this->member_m->checkExistense_of_ExtraAgeset($extageitem->advage_section);
								if(!empty($resurnset)){
									$row_arr2 = array(
										'fu_ext_masteruser' => $this->session->userdata('member_id'),
										'fu_ext_ageid' => $extageitem->advage_section,
										'fu_ext_answer' => $fu_extage[$keys],
										'fu_ext_reason' => NULL,
										'fu_ext_doc' => NULL,
										'fu_ext_modifydate' => date('Y-m-d H:i:s')
									);
									if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2, $resurnset->fu_ext_id) == FALSE) {
										$errorcounter++;
										$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
										break;
									}
								}else{
									$row_arr2 = array(
										'fu_ext_masteruser' => $this->session->userdata('member_id'),
										'fu_ext_ageid' => $extageitem->advage_section,
										'fu_ext_answer' => $fu_extage[$keys],
										'fu_ext_reason' => NULL,
										'fu_ext_doc' => NULL,
										'fu_ext_createdate' => date('Y-m-d H:i:s')
									);
									if ($this->member_m->addUpdateform_ExtraAgeSets_inDB($row_arr2) == FALSE) {
										$errorcounter++;
										$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
										break;
									}
								}
							}else{
								$errorcounter++;
								$errormsg = $errormsg.$extageitem->caste_name.': Data Fetching Problem Occured';
								break;
							}

						}
						//echo $errormsg;
						//exit;
					}
					
					if(($fu_pwd == "Yes") && (($adv_detail->adv_pwd_percent > $fu_pwd_percent) || ($fu_pwd_percent == 0))){
						$errorcounter++;
						$errormsg = $errormsg.'<br/>PWD Minimum Percentage Check Properly';
					}
					if($errorcounter == 0){
						if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
							echo json_encode(array('msg' => 1, 's_msg' => ''));
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
						}
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => $errormsg));
					}

				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
	}



	// ---------------------------------

	// STEP 4 SAVE

	// ---------------------------------

	public function final_step_save()
	{

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_dob_doc = $userdetails->fu_dob_doc;

			if (isset($_FILES['fu_dob_doc']) && !empty($_FILES['fu_dob_doc'])) {
				$upload_info = upload_file($_FILES['fu_dob_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('DOB_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'DOB - '.$upload_info['status'].'<br/>';
					//$fu_dob_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_dob_doc);
					$fu_dob_doc = $upload_info['result_path'];
				}
			}

			/*
			$fu_gov_exp_doc = $userdetails->fu_gov_exp_doc;

			if (isset($_FILES['fu_gov_exp_doc']) && !empty($_FILES['fu_gov_exp_doc'])) {



				delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_gov_exp_doc);



				$upload_info = upload_file($_FILES['fu_gov_exp_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('gov_exp_'), array('jpg', 'jpeg', 'png', 'pdf'));



				if ($upload_info['error']) {



					$fu_gov_exp_doc = '';
				} else {

					$fu_gov_exp_doc = $upload_info['result_path'];
				}
			}



			$fu_nongov_exp_doc = $userdetails->fu_nongov_exp_doc;

			if (isset($_FILES['fu_nongov_exp_doc']) && !empty($_FILES['fu_nongov_exp_doc'])) {



				delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_nongov_exp_doc);



				$upload_info = upload_file($_FILES['fu_nongov_exp_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('non_gov_exp_'), array('jpg', 'jpeg', 'png', 'pdf'));



				if ($upload_info['error']) {



					$fu_nongov_exp_doc = '';
				} else {

					$fu_nongov_exp_doc = $upload_info['result_path'];
				}
			}
			*/


			// print_r($_POST);



			if($error_section == 1){

				$fu_has_service = $this->input->post('fu_has_service');

				$fu_dob = $this->input->post('fu_dob');

				$total_exam = $this->input->post('total_exam');

				$exp_counter = $this->input->post('exp_counter');
				$ess_exp_counter = $this->input->post('ess_exp_counter');

				$examid = $this->input->post('examid');
				$exam_name = $this->input->post('exam_name');
				$univ = $this->input->post('univ');
				$state = $this->input->post('state');
				$marks_obtained = $this->input->post('marks_obtained');
				$marks_full = $this->input->post('marks_full');
				$marks_percent = $this->input->post('marks_percent');
				$exam_persuing = $this->input->post('exam_persuing');
				$add_attempt = $this->input->post('add_attempt');
				$add_attempt_no = $this->input->post('add_attempt_no');
				//$files = $this->input->post('files'); $filename = $_FILES['files']['name'];
				//print_r($_FILES);exit;

				$msg = 0;

				//$this->form_validation->set_rules('fu_dob', 'Date of Birth', 'required');
				//$this->form_validation->set_rules('fu_has_service', 'Has Experience', 'required|Alpha');
				$this->form_validation->set_rules('total_exam', 'Total Exam', 'is_natural');
				if($fu_has_service == "Yes"){
					$this->form_validation->set_rules('exp_counter', 'No. of Desirable Exp', 'is_natural');
					$this->form_validation->set_rules('ess_exp_counter', 'No. of Essential Exp', 'is_natural');
				}

				
				if ($fu_has_service == "undefined") $fu_has_service = NULL;
				
				/*
				if ($fu_current_gov_service == "undefined") $fu_current_gov_service = NULL;

				if ($fu_has_service == "No") {

				}
				*/


				// upload_file($_FILES[])
				//print_r($fu_dob);
				if($this->form_validation->run() == TRUE){
					//echo "<pre>";
					//print_r($_FILES);exit;

						$this->load->library('upload');
						$this->load->library('image_lib');
						$chk_exm_set = 0;
						
						for($jk = 0; $jk < $total_exam; $jk++){
							if($examid[$jk] != ""){
								$getqualidata = $this->db->get_where('f_user_qualification',array('fu_quali_id'=> $examid[$jk]))->row();
							}
							
							//$filename = $_FILES['files']['name'][$jk];
							if (!empty($_FILES['files']['name'][$jk])) {
								$filename = $_FILES['files']['name'][$jk];
								$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
								$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
								$config['overwrite'] = FALSE;
								$config['remove_spaces'] = TRUE;
								$config['max_size'] = '2050';
								$config['file_name'] = $filename;

								$this->load->library('upload', $config);
								$this->upload->initialize($config);

								$_FILES['attachments']['name']= $_FILES['files']['name'][$jk];
								$_FILES['attachments']['type']= $_FILES['files']['type'][$jk];
								$_FILES['attachments']['tmp_name']= $_FILES['files']['tmp_name'][$jk];
								$_FILES['attachments']['error']= $_FILES['files']['error'][$jk];
								$_FILES['attachments']['size']= $_FILES['files']['size'][$jk];

								if ($this->upload->do_upload('attachments')) {
									$upload_data = $this->upload->data();
									if($exam_persuing[$jk] == ""){$exam_persuing[$jk] = NULL;}
									if(empty($state[$jk]) || $state[$jk] == ''){$state[$jk] = NULL;}
									if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
									if((int)$marks_full[$jk] == 0){
										$selectpercent = ((int)$marks_obtained[$jk] * 100);
									}else{
										$selectpercent = (((int)$marks_obtained[$jk] * 100) / (int)$marks_full[$jk]);
									}
									if($selectpercent != 0){
										$percentupdate = number_format((float)$selectpercent, 2, '.', '');
									}else{
										$percentupdate = NULL;
									}
									
									//$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
									//$percentupdate = number_format((float)$selectpercent, 2, '.', '');
									$row_arr2 = array(
										'fu_quali_masteruser' => $this->session->userdata('member_id'),
										'fu_qualifiaction_name' => $exam_name[$jk],
										'fu_state_of_passing' => $state[$jk],
										'fu_council_board' => $univ[$jk],
										'fu_full_marks' => $marks_full[$jk],
										'fu_marks_obtained' => $marks_obtained[$jk],
										'fu_percent_of_marks' => $percentupdate,
										'fu_fullmark_ck' => $marks_full[$jk],
										'fu_obtainmark_ck' => $marks_obtained[$jk],
										'fu_percentmark_ck' => $percentupdate,
										'fu_is_pursuing' => $exam_persuing[$jk],
										'fu_is_attempt' => $add_attempt[$jk],
										'fu_attempt_no' => $add_attempt_no[$jk],
										'fu_quali_docs' => $upload_data['file_name'],
										'fu_quali_createdate' => date('Y-m-d H:i:s')
									);
									if($examid[$jk] != ""){
										if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
											$chk_exm_set++;
											break;
										}else{
											if(!empty($getqualidata->fu_quali_docs)){
												unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$getqualidata->fu_quali_docs);
											}
										}
									}else{
										if ($this->member_m->add_fuser_qualification($row_arr2) == FALSE) {
											$chk_exm_set++;
											break;
										}
									}
								}else{
									$chk_exm_set++;
									break;
								}
							}else{
								if($exam_persuing[$jk] == ""){$exam_persuing[$jk] = NULL;}
								if(empty($state[$jk]) || $state[$jk] == ''){$state[$jk] = NULL;}
								if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
								if((int)$marks_full[$jk] == 0){
									$selectpercent = ((int)$marks_obtained[$jk] * 100);
								}else{
									$selectpercent = (((int)$marks_obtained[$jk] * 100) / (int)$marks_full[$jk]);
								}
								if($selectpercent != 0){
									$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								}else{
									$percentupdate = NULL;
								}
									
								$row_arr2 = array(
									'fu_quali_masteruser' => $this->session->userdata('member_id'),
									'fu_qualifiaction_name' => $exam_name[$jk],
									'fu_state_of_passing' => $state[$jk],
									'fu_council_board' => $univ[$jk],
									'fu_full_marks' => $marks_full[$jk],
									'fu_marks_obtained' => $marks_obtained[$jk],
									'fu_percent_of_marks' => $percentupdate,
									'fu_fullmark_ck' => $marks_full[$jk],
									'fu_obtainmark_ck' => $marks_obtained[$jk],
									'fu_percentmark_ck' => $percentupdate,
									'fu_is_pursuing' => $exam_persuing[$jk],
									'fu_is_attempt' => $add_attempt[$jk],
									'fu_attempt_no' => $add_attempt_no[$jk],
									'fu_quali_createdate' => date('Y-m-d H:i:s')
								);
								if($examid[$jk] != ""){
									if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
										$chk_exm_set++;
										break;
									}
								}else{
									if ($this->member_m->add_fuser_qualification($row_arr2) == FALSE) {
										$chk_exm_set++;
										break;
									}
								}
									
							}

						}
						if($chk_exm_set == 0){

							$row_arr = array(

								'fu_has_service' => $fu_has_service,
								'fu_qualification_total' => $total_exam,
								'fu_experience_total' => $exp_counter,
								'fu_dob' => $fu_dob,
								'fu_dob_doc' => $fu_dob_doc,
								'fu_step_4' => 2,
								'fu_step4_submitdate' => date('Y-m-d H:i:s')

							);

							if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {

								//$this->member_m->init_candidate_result_tab($this->data["fuser_detailset"]->f_application_no);

								// $this->data['adv_detail']->adv_auto_genno;

								echo json_encode(array('msg' => 1, 's_msg' => ''));
							} else {

								echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
							}

						}else{
							/*$resultrow = $this->db->get_where('f_user_qualification', array('fu_quali_masteruser' => $this->session->userdata('member_id')))->result();
							if (count((array)$resultrow) > 0) {
								foreach($resultrow as $quali){
									if ($this->db->delete('f_user_qualification', array('fu_exp_id' => $quali->fu_quali_id))) {
										unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$quali->fu_quali_docs);
									}
								}
							}*/
							echo json_encode(array('msg' => 0, 'e_msg' => 'Qualification section Problem Occured, Check Again.'));
						}

				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}

		} else redirect('default404');
	}



	public function add_qualification()
	{



		$userdetails = $this->data["fuser_detailset"];

		$this->load->helper('file_upload');



		$fu_quali_docs = '';

		if (isset($_FILES['marksheet']) && !empty($_FILES['marksheet'])) {



			$upload_info = upload_file($_FILES['marksheet'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('marksheet_'), array('jpg', 'jpeg', 'png', 'pdf'));



			if ($upload_info['error']) {



				$fu_quali_docs = '';
			} else {

				$fu_quali_docs = $upload_info['result_path'];
			}
		}



		if (empty($fu_quali_docs) || $fu_quali_docs == '') {



			echo json_encode(array('msg' => 0, 'e_msg' => 'Marksheet document not found'));

			return;
		}



		if (isset($_POST) && !empty($_POST)) {

			$exam_name = $this->input->post('exam_name');

			$marks_full = $this->input->post('marks_full');

			$marks_obtained = $this->input->post('marks_obtained');

			$marks_percent = $this->input->post('marks_percent');

			//$marksheet_issue_date = $this->input->post('marksheet_issue_date');

			$university = $this->input->post('university');

			$state = $this->input->post('state');
		} else redirect('default404');



		$this->form_validation->set_rules('exam_name', 'Exam Name', 'numeric|required');

		$this->form_validation->set_rules('marks_full', 'Full Marks', 'numeric|required');

		$this->form_validation->set_rules('marks_obtained', 'MArks Obtained', 'numeric|required');

		$this->form_validation->set_rules('marks_percent', 'Percentage', 'numeric|required');

		//$this->form_validation->set_rules('marksheet_issue_date', 'Marksheet Issue Date', 'required');

		$this->form_validation->set_rules('university', 'University', 'required');

		$this->form_validation->set_rules('state', 'State', 'numeric|required');



		if ($this->form_validation->run() == TRUE) {



			$quali = array(

				'fu_quali_masteruser' => $this->session->userdata('member_id'),

				'fu_qualifiaction_name' => $exam_name,

				'fu_state_of_passing' => $state,

				'fu_council_board' => $university,

				'fu_full_marks' => $marks_full,

				'fu_marks_obtained' => $marks_obtained,

				'fu_percent_of_marks' => $marks_percent,

				'fu_fullmark_ck' => $marks_full,
				
				'fu_obtainmark_ck' => $marks_obtained,
				
				'fu_percentmark_ck' => $marks_percent,

				//'fu_marksheet_issuedate' => $marksheet_issue_date,

				'fu_quali_docs' => $fu_quali_docs,

				'fu_quali_createdate' => date('Y-m-d H:i:s')

			);

			$id = $this->member_m->add_fuser_qualification($quali);

			echo json_encode(array('msg' => 1, 's_msg' => '', 'marksheet' => $fu_quali_docs, 'quali_id' => $id));
		} else echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
	}



	// ---------------------------------

	// STEP 4 PROCESSING

	// ---------------------------------

	public function final_step_processing()
	{

		if (isset($_POST) && !empty($_POST)) {
			set_time_limit(0);
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_dob_doc = $userdetails->fu_dob_doc;

			if (isset($_FILES['fu_dob_doc']) && !empty($_FILES['fu_dob_doc'])) {
				$upload_info = upload_file($_FILES['fu_dob_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('DOB_'), array('jpg', 'jpeg', 'png', 'pdf'));
				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'DOB - '.$upload_info['status'].'<br/>';
					//$fu_dob_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_dob_doc);
					$fu_dob_doc = $upload_info['result_path'];
				}
			}

			/*
			$fu_gov_exp_doc = $userdetails->fu_gov_exp_doc;

			if (isset($_FILES['fu_gov_exp_doc']) && !empty($_FILES['fu_gov_exp_doc'])) {



				delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_gov_exp_doc);



				$upload_info = upload_file($_FILES['fu_gov_exp_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('gov_exp_'), array('jpg', 'jpeg', 'png', 'pdf'));



				if ($upload_info['error']) {



					$fu_gov_exp_doc = '';
				} else {

					$fu_gov_exp_doc = $upload_info['result_path'];
				}
			}


			$fu_nongov_exp_doc = $userdetails->fu_nongov_exp_doc;

			if (isset($_FILES['fu_nongov_exp_doc']) && !empty($_FILES['fu_nongov_exp_doc'])) {



				delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_nongov_exp_doc);



				$upload_info = upload_file($_FILES['fu_nongov_exp_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('non_gov_exp_'), array('jpg', 'jpeg', 'png', 'pdf'));



				if ($upload_info['error']) {



					$fu_nongov_exp_doc = '';
				} else {

					$fu_nongov_exp_doc = $upload_info['result_path'];
				}
			}

			*/
			// print_r($_POST);


			if($error_section == 1){

				//print_r($_REQUEST);exit;

				$fu_has_service = $this->input->post('fu_has_service');

				$fu_dob = $this->input->post('fu_dob');

				$total_exam = $this->input->post('total_exam');

				$exp_counter = $this->input->post('exp_counter');
				$ess_exp_counter = $this->input->post('ess_exp_counter');

				$examid = $this->input->post('examid');
				$exam_name = $this->input->post('exam_name');
				$univ = $this->input->post('univ');
				$state = $this->input->post('state');
				$marks_obtained = $this->input->post('marks_obtained');
				$marks_full = $this->input->post('marks_full');
				$marks_percent = $this->input->post('marks_percent');
				$exam_persuing = $this->input->post('exam_persuing');
				$add_attempt = $this->input->post('add_attempt');
				$add_attempt_no = $this->input->post('add_attempt_no');
				//$files = $this->input->post('files'); $filename = $_FILES['files']['name'];
				//print_r($_FILES);exit;

				$msg = 0;

				$this->form_validation->set_rules('fu_dob', 'Date of Birth', 'required');
				if($adv_detail->adv_has_experience == "Yes"){
					$this->form_validation->set_rules('fu_has_service', 'Has Experience', 'required|Alpha');
				}else{
					$fu_has_service = NULL;
				}
				$this->form_validation->set_rules('total_exam', 'Total Exam', 'required|is_natural');
				if($fu_has_service == "Yes"){
					$this->form_validation->set_rules('exp_counter', 'No. of Desirable Exp', 'required|is_natural');
					$this->form_validation->set_rules('ess_exp_counter', 'No. of Essential Exp', 'required|is_natural');
				}

				if($fu_has_service == "Yes" && $exp_counter == 0 && $ess_exp_counter == 0){
					echo json_encode(array('msg'=>0, 'e_msg'=>'Experience is Missing, Check Again.'));
				}else{
					// upload_file($_FILES[])
					//print_r($fu_dob);exit;
					if($this->form_validation->run() == TRUE){

						$expchecker_cnt = 0;
						$expchecker_error = '';
						if($fu_has_service == "Yes" && $adv_detail->adv_has_experience == "Yes"){
							$allexp_list = $this->member_m->getAll_Experience_section($this->data['adv_detail']->adv_auto_genno);
							$masterexp_arr = array();
							$desire_exp_arr = array();
							$iset = $jset = 0;
							foreach($allexp_list as $keys=>$qs){
								$subset_arr = array();
								if($qs->aexpr_type == "Essential"){
									if($keys == 0){
										$subset_arr['exp_name'] = $qs->expset_name;
										$subset_arr['expid'] = $qs->aexpr_name;
										$subset_arr['exp_marks'] = $qs->aexpr_marks;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
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
										$subset_arr['exp_marks'] = $qs->aexpr_marks;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										$masterexp_arr[$iset][$jset] = $subset_arr;
										if($qs->aexpr_relation == "AND"){
											$iset++;
											$jset = 0;
										}elseif($qs->aexpr_relation == "OR"){
											$jset++;
										}
									}
									/*$subset_arr['exp_name'] = $qs->expset_name;
									$subset_arr['expid'] = $qs->aexpr_name;
									$subset_arr['exp_marks'] = $qs->aexpr_marks;
									$subset_arr['exp_min'] = $qs->aexpr_min_month;
									$masterexp_arr[] = $subset_arr;*/
								}elseif($qs->aexpr_type == "Desirable"){
									$subset_arr['exp_name'] = $qs->expset_name;
									$subset_arr['expid'] = $qs->aexpr_name;
									$subset_arr['exp_marks'] = $qs->aexpr_marks;
									$subset_arr['exp_min'] = $qs->aexpr_min_month;
									$desire_exp_arr[] = $subset_arr;
								}
							}
							$get_ess_expdata = $this->member_m->gotoEssential_Experience_listSet($this->session->userdata['member_id']);
							$get_ds_expdata = $this->member_m->gotoDesire_Experience_listSet($this->session->userdata['member_id']);

							if(count((array)$get_ess_expdata) == 0 && count((array)$get_ds_expdata) == 0){
								$expchecker_cnt = 1;
								$expchecker_error = $expchecker_error . 'Experience is Missing, All Check Again.';
							}else{
								if(count($masterexp_arr) > 0 && count((array)$get_ess_expdata) == 0){
									$expchecker_cnt = 1;
									$expchecker_error = $expchecker_error . 'Essential Experience is Missing, All Check Again.';
								}else{
									if(count((array)$get_ds_expdata) > 0){
										foreach($desire_exp_arr as $ds_espitem){
											$ds_chk_month = 0;
											foreach($get_ds_expdata as $cand_ds_item){
												if($cand_ds_item->fu_exp_workname == $ds_espitem['expid']){
													$ds_chk_month = $ds_chk_month + ($cand_ds_item->fu_exp_year * 12) +  $cand_ds_item->fu_exp_month;
												}
											}
											if($ds_chk_month > 0 && $ds_espitem['exp_min'] > $ds_chk_month){
												$expchecker_cnt = 1;
												$expchecker_error = $expchecker_error .'<br/>'. $ds_espitem['exp_name'] .'(Desirable Exp.) not reached Minimum Criteria, Check Again.';
											}
										}
									}
									
									if(count($masterexp_arr) > 0){
										
										for($q=0;$q<count($masterexp_arr);$q++){

											if(count($masterexp_arr[$q]) > 1){
												
												$subset_exparr = 0;
												for($jj=0;$jj<count($masterexp_arr[$q]);$jj++){
													$es_chk_month = 0;
													foreach($get_ess_expdata as $cand_es_item){
														if($cand_es_item->fues_exp_workname == $masterexp_arr[$q][$jj]['expid']){
															$es_chk_month = $es_chk_month + ($cand_es_item->fues_exp_year * 12) +  $cand_es_item->fues_exp_month;
														}
													}
													if($es_chk_month > 0){
														$subset_exparr = 1;
													}
													if($es_chk_month > 0 && $masterexp_arr[$q][$jj]['exp_min'] > $es_chk_month){
														$expchecker_cnt = 1;
														$expchecker_error = $expchecker_error .'<br/>'. $masterexp_arr[$q][$jj]['exp_name'] .'(Essential Exp.) not reached Minimum Criteria, Check Again.';
													}
												}
												if($subset_exparr == 0){
													$expchecker_cnt = 1;
													$expchecker_error = $expchecker_error . '<br/>Some of Essential Experience is Missing, All Check Again.';
												}
											}else{
												
												$es_chk_month = 0;
												foreach($get_ess_expdata as $cand_es_item){
													if($cand_es_item->fues_exp_workname == $masterexp_arr[$q][0]['expid']){
														$es_chk_month = $es_chk_month + ($cand_es_item->fues_exp_year * 12) +  $cand_es_item->fues_exp_month;
													}
												}
												if($es_chk_month == 0 || $masterexp_arr[$q][0]['exp_min'] > $es_chk_month){
													$expchecker_cnt = 1;
													$expchecker_error = $expchecker_error .'<br/>'. $masterexp_arr[$q][0]['exp_name'] .'(Essential Exp.) not reached Minimum Criteria, Check Again.';
												}
											}
										}
									}
								}
							}
							
						}else{
							$allexp_list = $this->member_m->getAll_Experience_section($this->data['adv_detail']->adv_auto_genno);
							$masterexp_arr = array();
							$iset = $jset = 0;
							foreach($allexp_list as $keys=>$qs){
								$subset_arr = array();
								if($qs->aexpr_type == "Essential"){
									if($keys == 0){
										$subset_arr['exp_name'] = $qs->expset_name;
										$subset_arr['expid'] = $qs->aexpr_name;
										$subset_arr['exp_marks'] = $qs->aexpr_marks;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
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
										$subset_arr['exp_marks'] = $qs->aexpr_marks;
										$subset_arr['exp_min'] = $qs->aexpr_min_month;
										$masterexp_arr[$iset][$jset] = $subset_arr;
										if($qs->aexpr_relation == "AND"){
											$iset++;
											$jset = 0;
										}elseif($qs->aexpr_relation == "OR"){
											$jset++;
										}
									}
									break;
								}
							}
							if(count($masterexp_arr) > 0 && $fu_has_service == "No"){
								$expchecker_cnt = 1;
								$expchecker_error = $expchecker_error . 'Essential Experience is Missing, All Check Again.';
							}
						}

						if($expchecker_cnt == 0){
						//echo "<pre>";
						//print_r($_FILES);exit;
						$existing_limit_update = $adv_detail->adv_age_limit;
						$getall_ageset = $this->member_m->gatAll_subscriptionAge_list($userdetails->f_applied_for);
						if(count((array)$getall_ageset) > 0){
							
							//$castelists = $this->db->get_where('caste_tab',array('caste_cat'=>2))->result();
							$castelists = $this->db->where('caste_status',1)->where('caste_id != ',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
							$getextraageset = $this->member_m->getAll_Existing_ExtraAgeSets_All();
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
								$maxnumber_find = max($mixsub_array);
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

						$fu_dob = date('Y-m-d',strtotime($fu_dob));
						if($adv_detail->adv_min_age_limit >= $fu_dob && $existing_limit_update <= $fu_dob){
							$this->load->library('upload');
							$this->load->library('image_lib');
							$chk_exm_set = 0;
							
							for($jk = 0; $jk < $total_exam; $jk++){
								if($examid[$jk] != ""){
									$getqualidata = $this->db->get_where('f_user_qualification',array('fu_quali_id'=> $examid[$jk]))->row();
								}
								if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $state[$jk] == NULL || $state[$jk] == "" || $univ[$jk] == NULL || $univ[$jk] == "" || $marks_full[$jk] == NULL || $marks_full[$jk] == "" || $marks_obtained[$jk] == NULL || $marks_obtained[$jk] == "" || $marks_percent[$jk] == NULL || $marks_percent[$jk] == "" || $add_attempt[$jk] == NULL || $add_attempt[$jk] == ""){
									$chk_exm_set++;
									break;
								}
								if($add_attempt[$jk] == "Yes"){
									if($add_attempt_no[$jk] == "" || $add_attempt_no[$jk] == NULL){
										$chk_exm_set++;
										break;
									}
								}
								if($chk_exm_set == 0){
									//$filename = $_FILES['files']['name'][$jk];
									if (!empty($_FILES['files']['name'][$jk])) {
										$filename = $_FILES['files']['name'][$jk];
										$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
										$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
										$config['overwrite'] = FALSE;
										$config['remove_spaces'] = TRUE;
										$config['max_size'] = '2050';
										$config['file_name'] = $filename;

										$this->load->library('upload', $config);
										$this->upload->initialize($config);

										$_FILES['attachments']['name']= $_FILES['files']['name'][$jk];
										$_FILES['attachments']['type']= $_FILES['files']['type'][$jk];
										$_FILES['attachments']['tmp_name']= $_FILES['files']['tmp_name'][$jk];
										$_FILES['attachments']['error']= $_FILES['files']['error'][$jk];
										$_FILES['attachments']['size']= $_FILES['files']['size'][$jk];

										if ($this->upload->do_upload('attachments')) {
											$upload_data = $this->upload->data();
											if($add_attempt[$jk] == "No"){$add_attempt_no[$jk] = NULL;}
											if($exam_persuing[$jk] == ""){$exam_persuing[$jk] = NULL;}
											$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
											$percentupdate = number_format((float)$selectpercent, 2, '.', '');
											if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
											$row_arr2 = array(
												'fu_quali_masteruser' => $this->session->userdata('member_id'),
												'fu_qualifiaction_name' => $exam_name[$jk],
												'fu_state_of_passing' => $state[$jk],
												'fu_council_board' => $univ[$jk],
												'fu_full_marks' => $marks_full[$jk],
												'fu_marks_obtained' => $marks_obtained[$jk],
												'fu_percent_of_marks' => $percentupdate,
												'fu_fullmark_ck' => $marks_full[$jk],
												'fu_obtainmark_ck' => $marks_obtained[$jk],
												'fu_percentmark_ck' => $percentupdate,
												'fu_is_pursuing' => $exam_persuing[$jk],
												'fu_is_attempt' => $add_attempt[$jk],
												'fu_attempt_no' => $add_attempt_no[$jk],
												'fu_quali_docs' => $upload_data['file_name'],
												'fu_quali_createdate' => date('Y-m-d H:i:s')
											);
											if($examid[$jk] != ""){
												if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
													$chk_exm_set++;
													break;
												}else{
													if(!empty($getqualidata->fu_quali_docs)){
														unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$getqualidata->fu_quali_docs);
													}
												}
											}else{
												if ($this->member_m->add_fuser_qualification($row_arr2) == FALSE) {
													$chk_exm_set++;
													break;
												}
											}
										}else{
											$chk_exm_set++;
											break;
										}
									}else{
										if(!empty($getqualidata)){
											if($getqualidata->fu_quali_docs == "" || $getqualidata->fu_quali_docs == "NULL"){
												$chk_exm_set++;
												break;
											}else{
												if($add_attempt[$jk] == "No"){$add_attempt_no[$jk] = NULL;}
												if($exam_persuing[$jk] == ""){$exam_persuing[$jk] = NULL;}
												$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
												$percentupdate = number_format((float)$selectpercent, 2, '.', '');
												if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
												$row_arr2 = array(
													'fu_quali_masteruser' => $this->session->userdata('member_id'),
													'fu_qualifiaction_name' => $exam_name[$jk],
													'fu_state_of_passing' => $state[$jk],
													'fu_council_board' => $univ[$jk],
													'fu_full_marks' => $marks_full[$jk],
													'fu_marks_obtained' => $marks_obtained[$jk],
													'fu_percent_of_marks' => $percentupdate,
													'fu_fullmark_ck' => $marks_full[$jk],
													'fu_obtainmark_ck' => $marks_obtained[$jk],
													'fu_percentmark_ck' => $percentupdate,
													'fu_is_pursuing' => $exam_persuing[$jk],
													'fu_is_attempt' => $add_attempt[$jk],
													'fu_attempt_no' => $add_attempt_no[$jk],
													'fu_quali_createdate' => date('Y-m-d H:i:s')
												);
												if($examid[$jk] != ""){
													if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
														$chk_exm_set++;
														break;
													}
												}else{
													if ($this->member_m->add_fuser_qualification($row_arr2) == FALSE) {
														$chk_exm_set++;
														break;
													}
												}
											}
										}else{
											$chk_exm_set++;
											break;
										}
									}
								}
							}
							if($chk_exm_set == 0){

								$row_arr = array(

									'fu_has_service' => $fu_has_service,
									'fu_qualification_total' => $total_exam,
									'fu_experience_total' => $exp_counter,
									'fu_dob' => $fu_dob,
									'fu_dob_doc' => $fu_dob_doc,
									'fu_step_4' => 1,
									'fu_step4_submitdate' => date('Y-m-d H:i:s')

								);

								if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {

									//$this->member_m->init_candidate_result_tab($this->data["fuser_detailset"]->f_application_no);

									// $this->data['adv_detail']->adv_auto_genno;

									echo json_encode(array('msg' => 1, 's_msg' => ''));
								} else {

									echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
								}

							}else{
								/*$resultrow = $this->db->get_where('f_user_qualification', array('fu_quali_masteruser' => $this->session->userdata('member_id')))->result();
								if (count((array)$resultrow) > 0) {
									foreach($resultrow as $quali){
										if ($this->db->delete('f_user_qualification', array('fu_exp_id' => $quali->fu_quali_id))) {
											unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$quali->fu_quali_docs);
										}
									}
								}*/
								echo json_encode(array('msg' => 0, 'e_msg' => 'Qualification section Problem Occured, Check Again.'));
							}

						}else{
							echo json_encode(array('msg' => 0, 'e_msg' => 'DOB is Mismatch, check Again.'));
						}

						}else{
							echo json_encode(array('msg' => 0, 'e_msg' => $expchecker_error));
						}

					}else{
						echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
					}
				}
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
	}

	public function remove_qualification()
	{



		if (isset($_POST) && !empty($_POST)) {

			$id = $this->input->post('quali_id');
		} else redirect('default404');

		$this->member_m->remove_fuser_qualification($id);

		echo json_encode(array('msg' => 1, 's_msg' => ''));
	}

	public function get_caste_details()
	{

		if (isset($_POST) && !empty($_POST)) {
			$caste = $this->input->post('caste_type');

			$this->load->model('member_m');
			$caste_details_list = $this->member_m->get_caste_details($caste);

			if (count($caste_details_list) > 0) {
				echo json_encode($caste_details_list);
			} else {
				echo json_encode(false);
			}
		} else {
			redirect('default404');
		}
	}

	public function get_caste_details_v2()
	{

		if (isset($_POST) && !empty($_POST)) {

			$caste = $this->input->post('caste_type');
			$msg = 0;

			if($caste != ""){
				$this->load->model('member_m');
			
				$caste_sets_type = $this->db->get_where('caste_tab',array('caste_id'=>$caste,'caste_status'=>1))->row();
				if($caste_sets_type->caste_id < 7){
					$caste_details_list = $this->member_m->get_caste_details($caste);
				}else{
					$caste_details_list = $this->member_m->get_caste_details($caste_sets_type->caste_parent);
				}
				
	
				if($caste_sets_type->caste_cat != ""){
					echo json_encode(array('msg' => 1, 'castetype' => $caste_sets_type, 'castesets' => $caste_details_list));
					//echo json_encode($caste_details_list);
				} else {
					echo json_encode(array('msg' => $msg, 'e_msg' => 'Caste Section Not Found, check again.'));
				}
			}else{
				echo json_encode(array('msg' => $msg, 'e_msg' => 'Caste Type Not Found, check again.'));
			}

		} else {
			redirect('default404');
		}
	}

	public function get_caste_details_v3()
	{

		if (isset($_POST) && !empty($_POST)) {

			$caste = $this->input->post('fu_caste_type');
			$msg = 0;

			if($caste != ""){
				$this->load->model('member_m');
			
				$caste_sets_type = $this->db->get_where('caste_tab',array('caste_id'=>$caste,'caste_status'=>1))->row()->caste_cat;
				
				if($caste_sets_type != 1){
					echo json_encode(array('msg' => 1));
					//echo json_encode($caste_details_list);
				} else {
					echo json_encode(array('msg' => $msg));
				}
			}else{
				echo json_encode(array('msg' => $msg, 'e_msg' => 'Caste Type Not Found, check again.'));
			}

		} else {
			redirect('default404');
		}
	}

	public function get_sub_div_ps()
	{

		if (isset($_POST) && !empty($_POST)) {
			$fu_district = $this->input->post('fu_district');

			$this->load->model('member_m');
			$data['sub_division'] = $this->member_m->get_sub_div($fu_district);
			$data['police_station'] = $this->member_m->get_police_station($fu_district);

			if (count($data) > 0) {
				echo json_encode($data);
			} else {
				echo json_encode(false);
			}
		} else {
			redirect('default404');
		}
	}

	public function get_block_municipality()
	{
		if (isset($_POST) && !empty($_POST)) {
			$fu_mb_type = $this->input->post('fu_mb_type');
			$fu_sub_division = $this->input->post('fu_sub_division');

			$this->load->model('member_m');
			$data = $this->member_m->get_block($fu_sub_division, $fu_mb_type);

			if (count($data) > 0) {
				echo json_encode($data);
			} else {
				echo json_encode(false);
			}
		} else {
			redirect('default404');
		}
	}

	public function query_form_submission()
	{

		if ($_POST) {

			$apli_title = $this->input->post('apli_title');

			$apli_details = $this->input->post('apli_details');



			$this->form_validation->set_rules('apli_title', 'Subject', 'trim|required');

			$this->form_validation->set_rules('apli_details', 'Details', 'trim|required');



			if ($this->form_validation->run() == TRUE) {

				$random_keys = "H" . date('dmYHis') . $this->generateRandomString();

				$row_array = array(

					'query_no' => $random_keys,

					'query_user' => $this->session->userdata('member_id'),

					'query_subject' => trim($apli_title),

					'query_details' => trim($apli_details),

					'query_createdate' => date('Y-m-d H:i:s')

				);



				if ($_FILES["apli_attach"]["name"] != '') {

					$config["upload_path"] =  'upload_file/forum_doc/';

					$config["allowed_types"] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF|txt|doc|docx|xls|xlsx|ppt|pptx|mp4|MP4';

					$config['remove_spaces'] = TRUE;

					$config['overwrite'] = FALSE;

					$config['max_size'] = '11000';



					$this->load->library('upload', $config);

					$this->upload->initialize($config);



					$_FILES["file"]["name"] = $_FILES["apli_attach"]["name"];

					$_FILES["file"]["type"] = $_FILES["apli_attach"]["type"];

					$_FILES["file"]["tmp_name"] = $_FILES["apli_attach"]["tmp_name"];

					$_FILES["file"]["error"] = $_FILES["apli_attach"]["error"];

					$_FILES["file"]["size"] = $_FILES["apli_attach"]["size"];



					if ($this->upload->do_upload('file')) {

						$upload_data = $this->upload->data();

						$row_array['query_attachment'] = $upload_data['file_name'];



						if ($this->member_m->addform_against_UserQuery_inDB($row_array) == TRUE) {

							$this->session->set_flashdata("success", "Query Form is submitted successfully.");

							redirect('member/query_list', 'refresh');
						} else {

							$this->data['error'] = "There have some problem to Update DB, Try Again.";
						}
					} else {

						$this->data['error'] = "Attachment not Upload Properly, Try Again.";
					}
				} else {

					if ($this->member_m->addform_against_UserQuery_inDB($row_array) == TRUE) {

						$this->session->set_flashdata("success", "Query Form is submitted successfully.");

						redirect('member/query_list', 'refresh');
					} else {

						$this->data['error'] = "There have some problem to Update DB, Try Again.";
					}
				}
			}
		}



		$this->load->view('main/member/query_registration_view', $this->data);
	}

	public function add_experience_update(){
		if ($_POST) {

			$regno = $this->input->post("regno");
			$exp_name = $this->input->post("exp_name");
			$exp_org = $this->input->post("exp_org");
			//$exp_type = $this->input->post("exp_type");
			$exp_year = $this->input->post("exp_year");
			$exp_month = $this->input->post('exp_month');

			$this->form_validation->set_rules('regno', 'Registration No.', 'trim|required');
			$this->form_validation->set_rules('exp_name', 'Experience Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('exp_org', 'Organization', 'trim|required');
			//$this->form_validation->set_rules('exp_type', 'Work Type', 'trim|required');
			$this->form_validation->set_rules('exp_year', 'Year', 'trim|required|is_natural');
			$this->form_validation->set_rules('exp_month', 'Month', 'trim|required|is_natural');

			if ($this->form_validation->run()) {
				$userdetails = $this->data["fuser_detailset"];

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '2050';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();

							$row_arr = array(
								'fu_exp_masteruser' => $this->session->userdata['member_id'],
								'fu_exp_workname' => $exp_name,
								'fu_exp_org_name' => trim($exp_org),
								//'fu_exp_worktype' => $exp_type,
								'fu_exp_year' => $exp_year,
								'fu_exp_month' => $exp_month,
								'fu_exp_yr_ck' => $exp_year,
								'fu_exp_mth_ck' => $exp_month,
								'fu_exp_marksheet_doc' => $upload_data['file_name'],
								'fu_exp_createdate' => date('Y-m-d H:i:s')
							);

							$resultset = $this->member_m->addupdate_CandidateExperience_inDB($row_arr);
							if (count((array)$resultset) > 0) {
								echo json_encode(array('msg' => 1, 'cat_set' => $resultset));
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Certificate is missing, Try again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function add_ess_experience_update(){
		if ($_POST) {

			$regno = $this->input->post("regno");
			$exp_serial = $this->input->post("exp_serial");
			$exp_name = $this->input->post("exp_name");
			$exp_org = $this->input->post("exp_org");
			//$exp_type = $this->input->post("exp_type");
			$exp_year = $this->input->post("exp_year");
			$exp_month = $this->input->post('exp_month');

			$this->form_validation->set_rules('regno', 'Registration No.', 'trim|required');
			$this->form_validation->set_rules('exp_serial', 'Experience SRID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('exp_name', 'Experience Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('exp_org', 'Organization', 'trim|required');
			//$this->form_validation->set_rules('exp_type', 'Work Type', 'trim|required');
			$this->form_validation->set_rules('exp_year', 'Year', 'trim|required|is_natural');
			$this->form_validation->set_rules('exp_month', 'Month', 'trim|required|is_natural');

			if ($this->form_validation->run()) {
				$userdetails = $this->data["fuser_detailset"];

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '2050';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();

							$row_arr = array(
								'fues_exp_masteruser' => $this->session->userdata['member_id'],
								'fues_exp_workname' => $exp_name,
								'fues_exp_org_name' => trim($exp_org),
								//'fu_exp_worktype' => $exp_type,
								'fues_exp_year' => $exp_year,
								'fues_exp_month' => $exp_month,
								'fues_exp_yr_ck' => $exp_year,
								'fues_exp_mth_ck' => $exp_month,
								'fues_exp_serial' => $exp_serial,
								'fues_exp_marksheet_doc' => $upload_data['file_name'],
								'fues_exp_createdate' => date('Y-m-d H:i:s')
							);

							$resultset = $this->member_m->addupdate_Candidate_Ess_Experience_inDB($row_arr);
							if (count((array)$resultset) > 0) {
								echo json_encode(array('msg' => 1, 'cat_set' => $resultset));
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Certificate is missing, Try again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_ess_experience_update()
	{
		if ($_POST) {
			$expid = $this->input->post("expid");
			$expslno = $this->input->post("expslno");
			$this->form_validation->set_rules('expid', 'Experience ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('expslno', 'Experience SR-NO', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('f_user_ess_experience', array('fues_exp_id' => $expid))->row();
				if (count((array)$resultrow) > 0) {
					if ($this->db->delete('f_user_ess_experience', array('fues_exp_id' => $expid))) {
						$userdetails = $this->data["fuser_detailset"];
						unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$resultrow->fues_exp_marksheet_doc);
						echo json_encode(array('msg' => 1, 'cat_set' => $resultrow));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_experience_update()
	{
		if ($_POST) {
			$expid = $this->input->post("expid");
			$this->form_validation->set_rules('expid', 'Experience ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('f_user_experience', array('fu_exp_id' => $expid))->row();
				if (count((array)$resultrow) > 0) {
					if ($this->db->delete('f_user_experience', array('fu_exp_id' => $expid))) {
						$userdetails = $this->data["fuser_detailset"];
						unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$resultrow->fu_exp_marksheet_doc);
						echo json_encode(array('msg' => 1, 'cat_set' => $resultrow));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function add_desirequalification_update(){
		if ($_POST) {

			$des_exam_name = $this->input->post("des_exam_name");
			$des_univ_set = $this->input->post("des_univ_set");
			$des_state_set = $this->input->post("des_state_set");
			$des_marks_obtained_set = $this->input->post("des_marks_obtained_set");
			$des_marks_full_set = $this->input->post("des_marks_full_set");
			$des_marks_percent_set = $this->input->post('des_marks_percent_set');
			$des_add_attempt_set = $this->input->post('des_add_attempt_set');
			$des_add_attempt_no_set = $this->input->post('des_add_attempt_no_set');

			$this->form_validation->set_rules('des_exam_name', 'Qualification', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('des_univ_set', 'Board/ Council/ University', 'trim|required');
			$this->form_validation->set_rules('des_state_set', 'State', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('des_marks_obtained_set', 'Marks Obtained', 'trim|required|numeric');
			$this->form_validation->set_rules('des_marks_full_set', 'Full Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('des_marks_percent_set', 'Percentage of Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('des_add_attempt_set', 'Additional Attempt', 'trim|required|alpha');
			if($des_add_attempt_set == "Yes"){
				$this->form_validation->set_rules('des_add_attempt_no_set', 'No. of Attempt', 'trim|required|is_natural_no_zero');
			}
			if ($this->form_validation->run()) {
				$userdetails = $this->data["fuser_detailset"];
				if($this->member_m->checkDesire_Qualification_forInsert($des_exam_name, $this->session->userdata['member_id']) == TRUE){
					if (count($_FILES) > 0) {
						$filename = $_FILES['files']['name'];
						if (!empty($filename)) {
							$this->load->library('upload');
							$this->load->library('image_lib');

							$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
							$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '2050';
							$config['file_name'] = $filename;

							$this->load->library('upload', $config);
							$this->upload->initialize($config);

							if ($this->upload->do_upload('files')) {

								$upload_data = $this->upload->data();
								if($des_add_attempt_set == "No"){$des_add_attempt_no_set = NULL;}
								$selectpercent = (($des_marks_obtained_set * 100) / $des_marks_full_set);
								$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								$row_arr = array(
									'fud_quali_masteruser' => $this->session->userdata['member_id'],
									'fud_qualifiaction_name' => $des_exam_name,
									'fud_council_board' => trim($des_univ_set),
									'fud_state_of_passing' => $des_state_set,
									'fud_full_marks' => $des_marks_full_set,
									'fud_marks_obtained' => $des_marks_obtained_set,
									'fud_percent_of_marks' => $percentupdate,
									'fud_fullmark_ck' => $des_marks_full_set,
									'fud_obtainmark_ck' => $des_marks_obtained_set,
									'fud_percentmark_ck' => $percentupdate,
									'fud_is_attempt' => $des_add_attempt_set,
									'fud_attempt_no' => $des_add_attempt_no_set,
									'fud_quali_docs' => $upload_data['file_name'],
									'fud_quali_createdate' => date('Y-m-d H:i:s')
								);

								$resultset = $this->member_m->addupdate_DesireQualification_inDB($row_arr);
								if (count((array)$resultset) > 0) {
									echo json_encode(array('msg' => 1, 'cat_set' => $resultset));
								} else {
									echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
								}
								//////////////////////////
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Certificate is missing, Try again.'));
					}
				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'Desirable Qualification already added, Check again.'));
				}

			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_desirequalification_update()
	{
		if ($_POST) {
			$desqid = $this->input->post("desqid");
			$this->form_validation->set_rules('desqid', 'Desirable Qualification ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('f_user_des_qualification', array('fud_quali_id' => $desqid))->row();
				if (count((array)$resultrow) > 0) {
					if ($this->db->delete('f_user_des_qualification', array('fud_quali_id' => $desqid))) {
						$userdetails = $this->data["fuser_detailset"];
						unlink('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/'.$resultrow->fud_quali_docs);
						echo json_encode(array('msg' => 1, 'cat_set' => $resultrow));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function query_list()
	{

		$this->data['formlist'] = $this->db->order_by('query_id', 'DESC')->get_where('query_tab', array('query_user' => $this->session->userdata['member_id'], 'query_status' => 1))->result();

		$this->load->view("main/member/query_list_view", $this->data);
	}



	public function getallinfo_fromquery_number()
	{

		if ($_POST) {

			$q_no = $this->input->post('q_no');

			$msg = 0;

			$this->form_validation->set_rules('q_no', 'Query Number', 'trim|required');



			if ($this->form_validation->run() == TRUE) {

				$response_info = $this->db->get_where('query_tab', array('query_no' => $q_no, 'query_status' => 1))->result();



				if (count((array)$response_info) > 0) {

					echo json_encode(array('msg' => 1, 'info_set' => $response_info));
				} else {

					echo json_encode(array('msg' => $msg, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
				}
			} else {

				echo json_encode(array('msg' => $msg, 'e_msg' => validation_errors()));
			}

			exit;
		} else {

			redirect('default404');
		}
	}



	public function new_bphc_form_update_submission($cid = NULL)

	{

		if ($cid == NULL) {

			redirect('member/dashboard');
		}



		if ($_POST) {

			$ap_date = $this->input->post('ap_date');

			$ap_srfid = $this->input->post('ap_srfid');

			$mig_labour = $this->input->post('mig_labour');

			$ap_block = $this->input->post('ap_block');

			$ap_gp = $this->input->post('ap_gp');

			$ap_name = $this->input->post('ap_name');

			$ap_mobile = $this->input->post('ap_mobile');

			$ap_pool = $this->input->post('ap_pool');

			$ap_quaran = $this->input->post('ap_quaran');

			$ap_lab = $this->input->post('ap_lab');

			$ap_state = $this->input->post('ap_state');

			$mi_worker = $this->input->post('mi_worker');

			$out_state = $this->input->post('out_state');

			$out_dist = $this->input->post('out_dist');

			$ap_muni = $this->input->post('ap_muni');

			$ap_swap = $this->input->post('ap_swap');



			$this->form_validation->set_rules('ap_date', 'Date', 'trim|required');

			$this->form_validation->set_rules('ap_name', 'Name', 'trim|required');

			$this->form_validation->set_rules('ap_quaran', 'Quarantine', 'trim|required|alpha');

			$this->form_validation->set_rules('ap_mobile', 'Mobile', 'trim|required|exact_length[10]|is_natural');

			$this->form_validation->set_rules('mig_labour', 'Residing at Bankura', 'trim|required|alpha');

			$this->form_validation->set_rules('mi_worker', 'Migrant Workers', 'trim|required|alpha');

			$this->form_validation->set_rules('ap_swap', 'Swab Collected', 'trim|required|alpha');



			if ($mig_labour == "Yes" && $ap_muni == "") {

				$this->form_validation->set_rules('ap_block', 'Block', 'trim|required|is_natural');

				$this->form_validation->set_rules('ap_gp', 'GP Name', 'trim|required|is_natural');

				$ap_state = NULL;

				$ap_muni = NULL;
			} elseif ($mig_labour == "No") {

				$this->form_validation->set_rules('ap_state', 'State', 'trim|required|is_natural');

				$ap_muni = $ap_block = $ap_gp = NULL;
			}



			if ($mig_labour == "Yes" && $ap_block == "" && $ap_gp == "") {

				$this->form_validation->set_rules('ap_muni', 'Municipality Name', 'trim|required');

				$ap_state = NULL;

				$ap_block = $ap_gp = NULL;
			}



			if ($mi_worker == "Yes") {

				$this->form_validation->set_rules('out_state', 'Outside State', 'trim|required|is_natural');

				if ($out_state == 26) {

					$this->form_validation->set_rules('out_dist', 'Outside District', 'trim|required|is_natural');
				}
			}



			if ($ap_swap == "Yes") {

				$this->form_validation->set_rules('ap_srfid', 'SRF-ID', 'trim|required');

				$this->form_validation->set_rules('ap_pool', 'Pooling', 'trim|required|alpha');

				$this->form_validation->set_rules('ap_lab', 'Lab Name', 'trim|required');
			} else {

				$ap_lab = $ap_srfid = NULL;
			}



			if ($this->form_validation->run() == TRUE) {

				if ($ap_pool == "Yes") {

					$ap_stand = "No";
				} elseif ($ap_pool == "No") {

					$ap_stand = "Yes";
				} else {

					$ap_pool = $ap_stand = NULL;
				}

				if ($ap_quaran == "Inst") {

					$ap_semi_inst = "No";

					$ap_inst = "Yes";

					$ap_home = "No";
				} elseif ($ap_quaran == "Home") {

					$ap_semi_inst = "No";

					$ap_inst = "No";

					$ap_home = "Yes";
				} elseif ($ap_quaran == "SemiInst") {

					$ap_semi_inst = "Yes";

					$ap_inst = "No";

					$ap_home = "No";
				}



				$row_array = array(

					'collect_name' => trim($ap_name),

					'collect_date' => date('Y-m-d', strtotime($ap_date)),

					'collect_srf' => $ap_srfid,

					'collect_resident' => $mig_labour,

					'collect_block' => $ap_block,

					'collect_gp' => $ap_gp,

					'collect_munici' => $ap_muni,

					'collect_state' => $ap_state,

					'collect_worker' => $mi_worker,

					'collect_outstate' => $out_state,

					'collect_outdist' => $out_dist,

					'collect_swap' => $ap_swap,

					'collect_pool' => $ap_pool,

					'collect_stand' => $ap_stand,

					'collect_q_home' => $ap_home,

					'collect_q_inst' => $ap_inst,

					'collect_q_semi_inst' => $ap_semi_inst,

					'collect_mobile' => $ap_mobile,

					'collect_lab' => $ap_lab

					//'collect_modifydate' => date('Y-m-d H:i:s'),

					//'collect_modifyby' => $this->session->userdata('member_id')

				);



				if ($this->main_m->addform_against_LabourResult_covid($row_array, $cid) == TRUE) {

					$this->session->set_flashdata("success", "Collection Data is updated successfully.");

					redirect('member/new_bphc_form_update_submission/' . $cid, 'refresh');
				} else {

					$this->data['error'] = "There have some problem to Update DB, Try Again.";
				}
			}

			//exit;

		}



		if ($this->session->userdata('member_utype') == 1) {

			$this->data['collect_detail'] = $c_detail = $this->db->get_where('collection_application_tab', array('collect_id' => $cid, 'collect_status' => 1))->row();
		} else {

			$this->data['collect_detail'] = $c_detail = $this->db->get_where('collection_application_tab', array('collect_id' => $cid, 'collect_createby' => $this->session->userdata('member_id'), 'collect_status' => 1))->row();
		}

		if (count((array)$c_detail) == 0) {

			redirect('member/dashboard');
		}

		$this->data['state_list'] = $this->db->order_by('state_name', 'ASC')->get_where('state_tab', array('state_status' => 1))->result();

		$this->data['dist_list'] = $this->db->order_by('dist_name', 'ASC')->get_where('district_tab', array('dist_status' => 1))->result();

		$this->data['block_list'] = $this->db->get_where('block_tab', array('block_status' => 1))->result();

		$this->data['lab_list'] = $this->db->get_where('laboratory_tab', array('lab_status' => 1))->result();

		$this->data['gp_list'] = $this->db->get_where('gp_tab', array('master_block' => $c_detail->collect_block, 'gp_status' => 1))->result();

		$this->load->view('main/member/bphc_update_data_view', $this->data);
	}



	public function get_gp_by_block()
	{

		if ($_POST) {

			$ap_block = $this->input->post('ap_block');

			$msg = 0;

			if ($ap_block != "") {

				$response_gp = $this->db->get_where('gp_tab', array('master_block' => $ap_block, 'gp_status' => 1))->result();

				$gp_list = '<option value="">---Select---</option>';



				if (count((array)$response_gp) > 0) {

					foreach ($response_gp as $gp_s) {

						$gp_list = $gp_list . '<option value="' . $gp_s->gp_id . '">' . $gp_s->gp_name . '</option>';
					}

					echo json_encode(array('msg' => 1, 'gp_set' => $gp_list));
				} else {

					echo json_encode(array('msg' => $msg));
				}
			} else {

				echo json_encode(array('msg' => $msg));
			}

			exit;
		} else {

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


	public function payment_summery(){
		$userdetails = $this->data["fuser_detailset"];
		if ($userdetails->fu_step_4 != 1) {
			redirect('member/dashboard');
		}
		if ($userdetails->fu_final_submit != 1 || $userdetails->fu_pay_amount == 0) {
			redirect('member/finalcheck_up');
		}
		if ($userdetails->fu_payment_stat == 1) {
			redirect('member/finalcheck_up');
		}
		$this->data['trans_list'] = $this->db->get_where('f_user_transaction_tab', array('fu_appno_master'=>$userdetails->f_application_no))->result();
		$this->load->view("main/member/pay_summery_privew", $this->data);
	}

	public function final_payment_submission(){
		if($_POST){

			$userdetails = $this->data["fuser_detailset"];
			$paidamount = $userdetails->fu_pay_amount;
			$key = '6314263687426345';
			$iv = 'jbsfkhuhjgsdgasd';
			$algo = 'aes-128-cbc';
			$identifiaction_No = date('dmYhis').$this->generateRandomString(6);
			
			$updated_address = str_replace(";",".",$userdetails->fu_house_road);
			//$updated_address = str_replace(' ', '-', $updated_address); // Replaces all spaces with hyphens.
			$updated_address = preg_replace('/[^A-Za-z0-9\- ]/', '', $updated_address); // Removes special chars.
			$responseurl = base_url().'payments/response_from_grips';
			$xmlstring_set = '<GRIPS_DEPT_EPAYMENT_REQ>
			<DEPT_CD>033</DEPT_CD>
			<SERVICE_CD>303</SERVICE_CD>
			<DEPT_REF_NO>'.$userdetails->f_application_no.'</DEPT_REF_NO>
			<IDENTIFICATION_NO>'.$identifiaction_No.'</IDENTIFICATION_NO>
			<DEPOSITED_BY>'.$userdetails->f_full_name.'</DEPOSITED_BY>
			<DEPOSITOR_MOBILE_NO>'.$userdetails->f_mobile.'</DEPOSITOR_MOBILE_NO>
			<DEPOSITOR_EMIL_ID>'.$userdetails->f_email.'</DEPOSITOR_EMIL_ID>
			<DEPOSITOR_ADDRESS>'.$updated_address.'</DEPOSITOR_ADDRESS>
			<IN_FAVOR_OF>WBHRB</IN_FAVOR_OF>
			<RTN_PRD_FRM>'.date("dmY").'</RTN_PRD_FRM>
			<RTN_PRD_TO>'.date("dmY").'</RTN_PRD_TO>
			<TOTAL_AMOUNT>'.$paidamount.'</TOTAL_AMOUNT>
			<REMARKS>RECRUITMENT PAYMENT</REMARKS>
			<RESPONSE_URL>'.$responseurl.'</RESPONSE_URL>
			<REPEATED_HEAD ROW="1">
				<HEAD_OF_ACCOUNT>0051-00-104-002-16</HEAD_OF_ACCOUNT>
				<AMOUNT>'.$paidamount.'</AMOUNT>
			</REPEATED_HEAD>
			</GRIPS_DEPT_EPAYMENT_REQ>'; //|CHECKSUM='.$chksum_value;
			$chksumvalue_set = $this->hash256($xmlstring_set);
			$udated_with_chksum = $xmlstring_set.'|CHECKSUM='.$chksumvalue_set;
			$ENCDATA = $this->encrypt($udated_with_chksum, $algo, $key, $iv);
			$this->data['senddata'] = $ENCDATA;
			$this->data['senddpt'] = '033';

			$rowarray = array(
				'fu_appno_master'=> $userdetails->f_application_no,
				'fu_transaction_no' => $identifiaction_No,
				'fu_trans_amount' => $paidamount,
				'fu_pay_mode' => 'Online',
				'fu_trans_createdate' => date('Y-m-d H:i:s')
			);
			if($this->main_m->insertUpdate_Payment_candidateSet($rowarray) == TRUE){
				$this->load->view("main/member/pay_finalset_privew", $this->data);
			}else{
				$this->session->set_flashdata("e_error","Payment-ID Insertion Problem. Please Try Again.");
				redirect('member/finalcheck_up','refresh');
			}
		}else{
			redirect('default404');
		}

	}

	public function verify_payment_submission($trans_no = NULL){
		if($trans_no == NULL){
			redirect('member/finalcheck_up');
		}
		$userdetails = $this->data["fuser_detailset"];
		//$paidamount = $userdetails->fu_pay_amount;
		$key = '6314263687426345';
		$iv = 'jbsfkhuhjgsdgasd';
		$algo = 'aes-128-cbc';

		$c_year = date('Y');
		$current_month = date("m");
		$p_yr = date('Y', strtotime('-1 year'));
		if($current_month > 0 && $current_month < 4){
			$f_year = $p_yr;
		}else{
			$f_year = $c_year;
		}
		//$identifiaction_No = date('dmYhis').$this->generateRandomString(6);
		//$ENCDATA = encrypt("I Love My India!", $algo, $key, $iv);
		//$chksum_value = 'asdasdasd2342342sdfsdfsdf';
		//$responseurl = base_url().'payments/response_from_grips';
		$xmlstring_set = '<GRIPS_DEPT_DV_REQ>
		<DEPT_CD>033</DEPT_CD>
		<SERVICE_CD>303</SERVICE_CD>
		<DEPT_REF_NO>'.$userdetails->f_application_no.'</DEPT_REF_NO>
		<IDENTIFICATION_NO>'.$trans_no.'</IDENTIFICATION_NO>
		<FIN_YEAR>'.$f_year.'</FIN_YEAR>
		</GRIPS_DEPT_DV_REQ>'; //|CHECKSUM='.$chksum_value;
		$chksumvalue_set = $this->hash256($xmlstring_set);
		$udated_with_chksum = $xmlstring_set.'|CHECKSUM='.$chksumvalue_set;
		$ENCDATA = $this->encrypt($udated_with_chksum, $algo, $key, $iv);
		
		$postdata = http_build_query(
			array(
				'ENCDATA' => $ENCDATA,
				'DEPT_CD' => '033'
			)
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		
		//$result = file_get_contents('http://202.61.117.90/GRIPS/dept/dv/rest/WBHealth.do', false, $context);
		$result = file_get_contents('https://www.wbifms.gov.in/GRIPS/dept/dv/rest/WBHealth.do', false, $context);
		//print_r(htmlentities($result));
		$xmlstring = simplexml_load_string($result);
		$xmlarray = json_decode(json_encode((array) $xmlstring), true);
		if(count($xmlarray) > 0){
			if(!empty($xmlarray['ENCDATA'])){
				$decryptstring_updates = $this->decrypt($xmlarray['ENCDATA'], $algo, $key, $iv);
				$decryptstring_updates = strstr($decryptstring_updates, '|', true);
				$v_xmlstring = simplexml_load_string($decryptstring_updates);
				$v_xmlarray = json_decode(json_encode((array) $v_xmlstring), true);
				if(count($v_xmlarray) > 0){
					if($v_xmlarray['BANKTRANSACTIONSTATUS'] == "S"){
						$getcandidateid = $this->db->get_where('frontend_users', array('f_application_no'=>$v_xmlarray['DEPT_REF_NO']))->row();
						$row_arr = array(
							'fu_challan_no' => $v_xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $v_xmlarray['BANKTRANSACTIONID'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 1
						);
						if($this->main_m->updateSuccess_Payment_candidateSet($row_arr, $trans_no, $getcandidateid->f_uid) == TRUE){
							$htmldataset = '<html><body><h1>Thank you for Apply in WBHRB Application portal.</h1>
							<br/>
							<p>Your Application Registration Number is - <strong>'.$getcandidateid->f_application_no.'</strong></p>
							<p>For Any Further Queries, Please use this number.</p>
							</body></html>';
							$this->sendALLSMTPEmail($getcandidateid->f_email,'WBHRB - Application Submission', $htmldataset);
							$this->session->set_flashdata("success","Payment Successfully completed and Application submitted Successfully, Thank you.");
							redirect('member/finalcheck_up','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Database Updation Error. Please Contact Technical Team.");
							redirect('member/finalcheck_up','refresh');
						}

					}elseif($v_xmlarray['BANKTRANSACTIONSTATUS'] == "F"){
						$row_arr = array(
							'fu_challan_no' => $v_xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $v_xmlarray['BANKTRANSACTIONMESSAGE'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 2
						);
						if($this->main_m->insertUpdate_Payment_candidateSet($row_arr, $trans_no) == TRUE){
							$this->session->set_flashdata("e_error","Payment Transaction Failure. Need to Pay for Submission properly.");
							redirect('member/finalcheck_up','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Failure Updation Error. Please Contact Technical Team.");
							redirect('member/finalcheck_up','refresh');
						}
					}else{
						$this->session->set_flashdata("e_error","Payment not Updated yet. Please try after sometime.");
						redirect('member/finalcheck_up','refresh');
					}
				}
			}else{
				$this->session->set_flashdata("e_error","Payment not Updated yet. Please try after sometime.");
				redirect('member/finalcheck_up','refresh');
			}
		}else{
			$this->session->set_flashdata("e_error","Payment not Updated yet. Please try after sometime.");
			redirect('member/finalcheck_up','refresh');
		}
		/*echo "<pre>";
		//print_r(htmlentities($decryptstring_updates));
		print_r($v_xmlarray);
		exit;*/
		//$this->load->view("main/member/verify_payment_privew", $this->data);

	}

	protected function hash256($input) 
	{
		$hash = hash("sha256", utf8_encode($input));
		$output = "";
		foreach(str_split($hash, 2) as $key => $value) {
			if (strpos($value, "0") === 0) {
				$output .= str_replace("0", "", $value);
			} else {
				$output .= $value;
			}
		}
		return $output;
	}
	protected function encrypt($data, $algo, $key, $iv)
	{
		$cipherText = openssl_encrypt(
				$data,
				$algo,
				$key,
				OPENSSL_RAW_DATA,
				$iv
			);
		$cipherText = base64_encode($cipherText);
		return $cipherText;
		//$this->printData("ENCDATA : $cipherText");
	}
	protected function decrypt($data, $algo, $key, $iv)
    {
        $cipherText = base64_decode($data);
        $plaintext = openssl_decrypt(
                    $cipherText,
                    $algo,
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );
		return $plaintext;
		//$this->printData("PLAINTEXT  : $plaintext");
    }
    protected function printData($obj)
    {
		print_r($obj);
	}

	

	public function uploadregistration_certificate_set(){
		
		if($this->data["fuser_detailset"]->fu_cancel_stat == 1 || $this->data['adv_detail']->adv_reg_certificate != "Yes"){
			redirect('member/dashboard');
		}
		$this->load->view("main/member/upload_certificate", $this->data);
	}

	public function upload_all_certificates_set(){
		
		if($this->data["fuser_detailset"]->fu_payment_stat != 1 || $this->data["fuser_detailset"]->fu_cancel_stat == 1){
			redirect('member/dashboard');
		}
		$this->load->view("main/member/upload_missing_certificate", $this->data);
	}

	public function all_attachments_processing(){
		if($_POST){
			//echo "hi";exit;
			$refno = $this->input->post("refno");
			$docutype = $this->input->post("docutype");

			$this->form_validation->set_rules('refno', 'Registration No.', 'trim|required');
			$this->form_validation->set_rules('docutype', 'Type of Document', 'trim|required');

			if ($this->form_validation->run()) {

				$userdetails = $this->data["fuser_detailset"];

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
						if($docutype == "PIC" || $docutype == "SIGN"){
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
							if($docutype == "PIC"){
								$row_arr = array(
									'fu_photo_doc' => $upload_data['file_name']
								);
							}elseif($docutype == "SIGN"){
								$row_arr = array(
									'fu_signature_doc' => $upload_data['file_name']
								);
							}elseif($docutype == "ADDRESS"){
								$row_arr = array(
									'fu_address_doc' => $upload_data['file_name']
								);
							}elseif($docutype == "DOB"){
								$row_arr = array(
									'fu_dob_doc' => $upload_data['file_name']
								);
							}elseif($docutype == "CASTE"){
								$row_arr = array(
									'fu_caste_doc' => $upload_data['file_name']
								);
							}elseif($docutype == "PWD"){
								$row_arr = array(
									'fu_pwd_doc' => $upload_data['file_name']
								);
							}

							if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
								echo json_encode(array('msg' => 1));
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => 'DB Updation Problem, Try again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $docutype.'-->'.$this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {

					echo json_encode(array('msg' => 0, 'e_msg' => $docutype.' is missing, Try again.'));
				}

			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function reg_certificate_processing(){
		if($_POST){
			//echo "hi";exit;
			$refno = $this->input->post("refno");

			$this->form_validation->set_rules('refno', 'Registration No.', 'trim|required');

			if ($this->form_validation->run()) {
				$userdetails = $this->data["fuser_detailset"];

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/'.$userdetails->f_applied_for.'/candidates/'.$userdetails->f_application_no.'/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '2050';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();

							$row_arr = array(
								'fu_ext_council_reg_certificate' => $upload_data['file_name']
							);

							if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
								echo json_encode(array('msg' => 1));
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
					echo json_encode(array('msg' => 0, 'e_msg' => 'Certificate is missing, Try again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}


	public function finalsubmission_printout(){
		$userdetails = $this->data["fuser_detailset"];
		if ($userdetails->fu_step_4 != 1) {
			redirect('member/dashboard');
		}
		if ($userdetails->fu_final_submit != 1) {
			redirect('member/finalcheck_up');
		}

		if ($userdetails->fu_payment_stat != 1) {
			redirect('member/finalcheck_up');
		}
		
		$caste_issuing_auth = $this->db->get('caste_issuing_auth_tab')->result();

		$caste_tab = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();

		if ($userdetails->fu_step_1 == 1) {

			$adv_category = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
		}

		if ($userdetails->fu_step_2 == 1) {

			$dist_list = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();

			if ($userdetails->fu_district != NULL) {

				$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district))->result();
				$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district))->result();
			}
			if ($userdetails->fu_perma_dist != NULL) {

				$per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist))->result();
				$per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist))->result();
			}
			if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
	
				$per_mb_type = $userdetails->fu_perma_mb_type;
				$per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type))->result();
			}else{
				$per_mb_type = NULL;
				$per_block_municipality = array();
			}
	
			if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
	
				$mb_type = $userdetails->fu_mb_type;
				$block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type))->result();
			}else{
				$mb_type = NULL;
				$block_municipality = array();
			}
			//$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
		}


		if ($userdetails->fu_step_3 == 1) {
			//$this->data['quali_exam'] = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$allquali_list = $this->member_m->getAll_qualification_exam($this->data['adv_detail']->adv_auto_genno);
			$masterset_arr = array();
			$desire_quali_arr = array();
			$iset = $jset = 0;
			foreach($allquali_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aquali_examtype == "Essential"){
					if($keys == 0){
						$subset_arr['qm_name'] = $qs->qm_name;
						$subset_arr['aquali_exam'] = $qs->aquali_exam;
						$subset_arr['aquali_marks'] = $qs->aquali_marks;
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
						$masterset_arr[$iset][$jset] = $subset_arr;
						if($qs->aquali_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aquali_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aquali_examtype == "Desirable"){
					$subset_arr['qm_name'] = $qs->qm_name;
					$subset_arr['aquali_exam'] = $qs->aquali_exam;
					$subset_arr['aquali_marks'] = $qs->aquali_marks;
					$desire_quali_arr[] = $subset_arr;
				}
			}
			
			$quali_exam = $masterset_arr;
			$desire_quali_exam = $desire_quali_arr;
			$allexp_list = $this->member_m->getAll_Experience_section($this->data['adv_detail']->adv_auto_genno);
			$masterexp_arr = array();
			$desire_exp_arr = array();
			$iset = $jset = 0;
			foreach($allexp_list as $keys=>$qs){
				$subset_arr = array();
				if($qs->aexpr_type == "Essential"){
					if($keys == 0){
						$subset_arr['exp_name'] = $qs->expset_name;
						$subset_arr['expid'] = $qs->aexpr_name;
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
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
						$subset_arr['exp_marks'] = $qs->aexpr_marks;
						$subset_arr['exp_min'] = $qs->aexpr_min_month;
						$masterexp_arr[$iset][$jset] = $subset_arr;
						if($qs->aexpr_relation == "AND"){
							$iset++;
							$jset = 0;
						}elseif($qs->aexpr_relation == "OR"){
							$jset++;
						}
					}
				}elseif($qs->aexpr_type == "Desirable"){
					$subset_arr['exp_name'] = $qs->expset_name;
					$subset_arr['expid'] = $qs->aexpr_name;
					$subset_arr['exp_marks'] = $qs->aexpr_marks;
					$subset_arr['exp_min'] = $qs->aexpr_min_month;
					$desire_exp_arr[] = $subset_arr;
				}
			}
			$ess_expr = $masterexp_arr;
			$desire_expr = $desire_exp_arr;
			$exp_list = $this->member_m->gotoDesire_Experience_listSet($this->session->userdata['member_id']);
			$essenexp_list = $this->member_m->gotoEssential_Experience_listSet($this->session->userdata['member_id']);
			$desquali_list = $this->member_m->gotoDesire_Qualification_listSet($this->session->userdata['member_id']);
			//print_r($this->data['exp_list']);exit;
		}

		
		$quali_list = $this->member_m->get_fuser_qualification();

		$extraage_list = $this->member_m->getAll_Existing_ExtraAgeSets_All();

		$state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();

		$dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();


		if ($userdetails->fu_caste_type != NULL && $userdetails->fu_caste_community != NULL) {

			$caste_community = $this->db->get_where('caste_details_tab', array('csdetail_id' => $userdetails->fu_caste_community, 'csdetail_status' => 1))->row();
		}
		$pathurl = 'upload_file/'. $userdetails->f_applied_for .'/candidates/' . $userdetails->f_application_no . '/';
		$adv_detail = $this->data['adv_detail'];
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $userdetails->f_application_no;
		$obj_pdf->SetTitle('Advertisement');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Advertisement Notice');

		$obj_pdf->SetPrintHeader(false);
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
		<div class=\"header\">";
		$my_html = $my_html . "<table style=\"width: 100%\" style=\"font-size: 20px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 22px;\">
				<tr>
				<td style=\"width:10%;\">&nbsp;</td>
				<td style=\"width:80%;\">
					<div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:100px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor)</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span style=\"font-size:18px;font-weight:bold;\"><i>Registration No.: " . $userdetails->f_application_no . "</i></span>
					</div>
				</td>
				<td style=\"width:10%;\">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
		<td colspan=\"2\" style=\"width:100%;\">
			<table style=\"width:100%;\" border=\"1\">
				<tr>
					<td>
						<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
							<tr>
								<td width=\"75%\"><label><strong>Applied For :</strong>".$adv_detail->rm_name."</label></td>
								<td width=\"25%\" rowspan=\"3\" valign=\"top\"><strong>Applicant's Photograph</strong><br>
								<img src=\"".base_url().$pathurl.$userdetails->fu_photo_doc."\" style=\"max-width:180px;\" /><br/>
								<strong>Applicant's Signature</strong><br>
								<img src=\"".base_url().$pathurl.$userdetails->fu_signature_doc."\" style=\"max-width:180px;\" />
								<span></span>
								</td>
							</tr>
							<tr>
								<td><label><strong>Name :</strong>".$userdetails->f_full_name."</label></td>
							</tr>
							<tr>
								<td>
									<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
										<tr>
											<td><label><strong>Mobile No :</strong>".$userdetails->f_mobile."</label></td>
											<td><label><strong>Email :</strong>".$userdetails->f_email."</label></td>
										</tr>
										<tr>
											<td><label><strong>Discipline :</strong>".$adv_category->catm_name."</label></td>
											<td><label><strong>Father's Name :</strong></label>".$userdetails->fu_father_name."</td>
										</tr>
										<tr>
											<td><label><strong>Mother's Name :</strong>".$userdetails->fu_mother_name."</label></td>
											<td><label><strong>Gender :</strong></label>".$userdetails->fu_gender."</td>
										</tr>
										<tr>
											<td><label><strong>Date Of Birth :</strong>".date('d-m-Y',strtotime($userdetails->fu_dob))."</label></td>
											<td><label><strong>Marital Status :</strong>".$userdetails->fu_marital_status."</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
					<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
						<tr>
							<td colspan=\"2\"><strong>Present Address</strong></td>
						</tr>
						<tr>
							<td><label><strong>State :</strong></label>";
							foreach ($state_list as $states) {
								if ($states->state_id == $userdetails->fu_state) { $my_html = $my_html . $states->state_name;break; }
							}
							$my_html = $my_html . "</td>";
							if($userdetails->fu_state == 28){  
								$my_html = $my_html . "<td><label><strong>District :</strong></label>";
								foreach ($dist_list as $dists) { 
									if ($dists->district_code == $userdetails->fu_district) { $my_html = $my_html . $dists->district_name; }
								}
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>District :</strong></label>".$userdetails->fu_other_district."</td>";
							}
						$my_html = $my_html . "</tr>
						<tr>";
							if($userdetails->fu_state == 28){
								$my_html = $my_html . "<td><label><strong>Sub-Division :</strong></label>";
								foreach ($sub_division as $sd) {
									if ($userdetails->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . $sd->subdiv_name; }
								}
								$my_html = $my_html . "</td>
								<td><label><strong>Block/ Municipality :</strong></label>:"; 
								$bmset = '';
								foreach ($block_municipality as $bm) { 
									if ($bm->block_id == $userdetails->fu_block_municipality) {$bmset = $bm->block_name;}
								}
								$my_html = $my_html . $userdetails->fu_mb_type.' ('.$bmset.')';
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>Sub-Division :</strong></label>".$userdetails->fu_other_sdiv."</td>";
								$my_html = $my_html . "<td><label><strong>Block/ Municipality :</strong></label>".$userdetails->fu_other_blockm."</td>";
							}
						$my_html = $my_html . "</tr>
						<tr>";
							if($userdetails->fu_state == 28){
								$my_html = $my_html . "<td><label><strong>Police Station :</strong></label>";
								foreach ($police_station as $ps) {
									if ($userdetails->fu_police_station == $ps->ps_id) {$my_html = $my_html . $ps->ps_name;}
								}
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>Police Station :</strong></label>".$userdetails->fu_other_ps."</td>";
							}
							$my_html = $my_html . "<td><label><strong>Ward/GP : </strong></label>".$userdetails->fu_ward_gp."</td>
						</tr>
						<tr>
							<td><label><strong>Vill / Para / House No / Road :</strong></label>".$userdetails->fu_house_road."</td>
							<td><label><strong>Post Office : </strong></label>".$userdetails->fu_post_office."</td>
						</tr>
						<tr>
							<td colspan=\"2\"><label><strong>Pin :</strong></label>".$userdetails->fu_pincode."</td>
						</tr>";
						if($userdetails->fu_same_address == "No"){
						$my_html = $my_html . "<tr>
							<td colspan=\"2\"><strong>Permanenet Address</strong></td>
						</tr>
						<tr>
							<td><label><strong>State :</strong></label>";
							foreach ($state_list as $states) {
								if ($states->state_id == $userdetails->fu_perma_state) { $my_html = $my_html . $states->state_name;break; }
							}
							$my_html = $my_html . "</td>";
							if($userdetails->fu_perma_state == 28){  
								$my_html = $my_html . "<td><label><strong>District :</strong></label>";
								foreach ($dist_list as $dists) { 
									if ($dists->district_code == $userdetails->fu_perma_dist) {$my_html = $my_html . $dists->district_name;break; }
								}
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>District :</strong></label>".$userdetails->fu_perma_other_district."</td>";
							}
						$my_html = $my_html . "</tr>
						<tr>";
							if($userdetails->fu_perma_state == 28){
								$my_html = $my_html . "<td><label><strong>Sub-Division :</strong></label>";
								foreach ($per_sub_division as $sd) { 
									if ($userdetails->fu_perma_sub_division == $sd->subdiv_id){$my_html = $my_html . $sd->subdiv_name; }
								}
								$my_html = $my_html . "</td>
								<td><label><strong>Block/ Municipality :</strong></label>:";
								$bmset = '';
								foreach ($per_block_municipality as $bm) { 
									if ($bm->block_id == $userdetails->fu_perma_block_municipality) {$bmset = $bm->block_name;}
								}
								$my_html = $my_html . $userdetails->fu_perma_mb_type.' ('.$bmset.')';
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>Sub-Division :</strong></label>".$userdetails->fu_perma_other_sdiv."</td>";
								$my_html = $my_html . "<td><label><strong>Block/ Municipality :</strong></label>".$userdetails->fu_perma_other_blockm."</td>";
							}
						$my_html = $my_html . "</tr>
						<tr>";
							if($userdetails->fu_perma_state == 28){
								$my_html = $my_html . "<td><label><strong>Police Station :</strong></label>";
								foreach ($per_police_station as $ps) { 
									if ($userdetails->fu_perma_police_station == $ps->ps_id) {$my_html = $my_html . $ps->ps_name;}
								}
								$my_html = $my_html . "</td>";
							}else{
								$my_html = $my_html . "<td><label><strong>Police Station :</strong></label>".$userdetails->fu_perma_other_ps."</td>";
							}
							$my_html = $my_html . "<td><label><strong>Ward/GP : </strong></label>".$userdetails->fu_perma_ward_gp."</td>
						</tr>
						<tr>
							<td><label><strong>Vill / Para / House No / Road :</strong></label>".$userdetails->fu_perma_house_road."</td>
							<td><label><strong>Post Office : </strong></label>".$userdetails->fu_perma_post_office."</td>
						</tr>
						<tr>
							<td colspan=\"2\"><label><strong>Pin :</strong></label>".$userdetails->fu_perma_pincode."</td>
						</tr>
						<tr>
							<td colspan=\"2\"><label><strong>Comunication Address :</strong></label>".$userdetails->fu_comunication_address." Address </td>
						</tr>";
						}else{
						$my_html = $my_html . "<tr>
							<td colspan=\"2\"><strong>Permanenet Address is Same as Present Address</strong></td>
						</tr>";
						}
						$my_html = $my_html . "<tr>
							<td><label><strong>DOB Proof  :</strong></label> Attached Document</td>
							<td><label><strong>Address Proof :</strong> </label> Attached Document</td>
						</tr>
						<tr>
							<td colspan=\"2\"><label><strong>Caste : </strong></label>";
							$castesetschk = '';
							foreach ($caste_tab as $caste){
								if ($userdetails->fu_caste_type == $caste->caste_id){ $my_html = $my_html . $caste->caste_name; $castesetschk = $caste->caste_cat;}
							};
							if($userdetails->fu_caste_type != 1){
								if($castesetschk == 2){
								$my_html = $my_html . "<br/><table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
									<tr>";
										$my_html = $my_html . "<td><label><strong>Caste/ Tribe/ Community</strong></label> :".$caste_community->csdetail_name."</td>
										<td><label><strong>Certification No :</strong></label> ".$userdetails->fu_caste_number."</td>
									</tr>
									<tr>
									<td><label><strong>Issued By Whom</strong></label> :";
									foreach ($caste_issuing_auth as $auth){
										if ($userdetails->fu_caste_issue_whom == $auth->cia_id){$my_html = $my_html . $auth->cia_name;}
									}
									$my_html = $my_html . "</td>
									<td><label><strong>Issued by Date :</strong></label>".date('d-m-Y',strtotime($userdetails->fu_caste_issue_date))."</td>
									</tr>
									<tr>
									<td colspan=\"2\"><label><strong>Doc Upload:</strong></label> Attached Document<span></span></td>
									</tr>
								</table>";
								}
							}
							$my_html = $my_html . "</td>
						</tr>
						<tr>
							<td colspan=\"2\"><label><strong>PWD  :</strong></label>".$userdetails->fu_pwd."<br>";
						if($userdetails->fu_pwd == "Yes"){
							$my_html = $my_html . "<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
								<tr>
								<td><label><strong>Percentage of Disability  :</strong></label>". $userdetails->fu_pwd_percent."%</td>
								<td><label><strong>Issuing Authority :</strong></label>". $userdetails->fu_pwd_issue_whom."</td>
								</tr>
								<tr>
								<td><label><strong>Issued by Date :</strong></label>".date('d-m-Y',strtotime($userdetails->fu_pwd_issue_date))."</td>
								<td><label><strong>Doc Upload:</strong></label> Attached Document<span></span></td>
								</tr>
							</table>";
						}
						$my_html = $my_html . "</td>
						</tr>";
						if ($userdetails->fu_exempted == "Yes") {
						$my_html = $my_html . "<tr>
							<td colspan=\"2\"><label><strong>Exempted Category :</strong></label>".$userdetails->fu_exempted."<br>";
							$my_html = $my_html . "<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
							<tr>
							<td><label><strong>Description  :</strong></label>".$userdetails->fu_exc_reason."</td>
							<td><label><strong>Upload Doc :</strong> Attached Document</label> <span></span></td>
							</tr>
							</table>";
							$my_html = $my_html . "</td>
						</tr>";
						}
						if ($userdetails->fu_exservice == "Yes") {
						$my_html = $my_html . "<tr>
							<td colspan=\"2\"><label><strong>Ex-Serviceman Category :</strong></label>".$userdetails->fu_exservice."<br>";
							$my_html = $my_html . "<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
							<tr>
							<td><label><strong>Description  :</strong></label>".$userdetails->fu_exs_reason."</td>
							<td><label><strong>Upload Doc :</strong> Attached Document</label> <span></span></td>
							</tr>
							</table>";
							$my_html = $my_html . "</td>
						</tr>";
						}
						if ($userdetails->fu_ews == "Yes") {
						$my_html = $my_html . "<tr>
							<td colspan=\"2\"><label><strong>Sportsman Category :</strong></label>".$userdetails->fu_ews."<br>";
								$my_html = $my_html . "<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
								<tr>
								<td><label><strong>Description  :</strong></label>".$userdetails->fu_ews_reason."</td>
								<td><label><strong>Upload Doc :</strong> Attached Document</label> <span></span></td>
								</tr>
								</table>";
							$my_html = $my_html . "</td>
						</tr>";
						}
						if (count((array)$extraage_list) > 0) {
							foreach($extraage_list as $eageitem){
								$my_html = $my_html . "<tr>
									<td colspan=\"2\"><label><strong>".$eageitem->caste_name."  :</strong></label>".$eageitem->fu_ext_answer."<br>";
									if($eageitem->fu_ext_answer == "Yes"){
										$my_html = $my_html . "<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
										<tr>
										<td><label><strong>Detail Description :</strong></label>".$eageitem->fu_ext_reason."</td>
										<td><label><strong>Upload Doc :</strong> Attached Document</label> <span></span></td>
										</tr>
										</table>";
									}
									$my_html = $my_html . "</td>
								</tr>";
							}
						}
					$my_html = $my_html . "</table></td>
				</tr>
				<tr>
					<td>
					<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">";
					if ($adv_detail->adv_qualification_no > 0) {
						$my_html = $my_html . "<tr>
							<td colspan=\"9\"><strong>Essential Qualification</strong> </td>
						</tr>
						<tr>
							<td><strong>Examination Name</strong></td>
							<td><strong>Board/ Council/ University/ Journal</strong></td>
							<td><strong>State Name</strong></td>
							<td><strong>Marks Obtained</strong></td>
							<td><strong>Full Marks</strong></td>
							<td><strong>Percentage(%) of Marks</strong></td>
							<td><strong>Additional Attempt</strong></td>
							<td><strong>No. of Attempt</strong></td>
							<td><strong>Upload Marksheet</strong></td>
						</tr>";
						foreach($quali_list as $qualiss){
							$my_html = $my_html . "<tr>
							<td>".$qualiss->qm_name."</td>
							<td>".$qualiss->fu_council_board."</td>
							<td>".$qualiss->state_name."</td>
							<td>".$qualiss->fu_marks_obtained."</td>
							<td>".$qualiss->fu_full_marks."</td>
							<td>".$qualiss->fu_percent_of_marks."</td>
							<td>".$qualiss->fu_is_attempt."</td>
							<td>".$qualiss->fu_attempt_no."</td>
							<td>Attached Marksheet</td>
							</tr>";
						}
					}
					if(count((array)$desquali_list) > 0){
						$my_html = $my_html . "<tr>
							<td colspan=\"9\"><strong>Desirable Qualification</strong> </td>
						</tr>
						<tr>
							<td><strong>Examination Name</strong></td>
							<td><strong>Board/ Council/ University/ Journal</strong></td>
							<td><strong>State Name</strong></td>
							<td><strong>Marks Obtained</strong></td>
							<td><strong>Full Marks</strong></td>
							<td><strong>Percentage(%) of Marks</strong></td>
							<td><strong>Additional Attempt</strong></td>
							<td><strong>No. of Attempt</strong></td>
							<td><strong>Upload Marksheet</strong></td>
						</tr>";
						foreach($desquali_list as $qualiss){
							$my_html = $my_html . "<tr>
							<td>".$qualiss->qm_name."</td>
							<td>".$qualiss->fud_council_board."</td>
							<td>".$qualiss->state_name."</td>
							<td>".$qualiss->fud_marks_obtained."</td>
							<td>".$qualiss->fud_full_marks."</td>
							<td>".$qualiss->fud_percent_of_marks."</td>
							<td>".$qualiss->fud_is_attempt."</td>
							<td>".$qualiss->fud_attempt_no."</td>
							<td>Attached Marksheet</td>
							</tr>";
						}
					}
					if ($adv_detail->adv_has_experience == "Yes") {
						$my_html = $my_html . "<tr>
						<td colspan=\"9\">
						<label><strong>Experience in concerned field :</strong></label>".$userdetails->fu_has_service."<br/>";
						if ($userdetails->fu_has_service == "Yes") {
							if(count((array)$essenexp_list) > 0){
								$my_html = $my_html . "<strong>Essential Experience</strong><br/>
								<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
									<tr>
									<td><strong>Experience Category</strong></td>
									<td><strong>Organization</strong></td>
									<td><strong>Time Period</strong></td>
									<td><strong>Upload Certificate</strong></td>
									</tr>";
									foreach($essenexp_list as $expss){
										$my_html = $my_html . "<tr>
										<td>".$expss->expset_name."</td>
										<td>".$expss->fues_exp_org_name."</td>
										<td>".$expss->fues_exp_year." Year & ".$expss->fues_exp_month." Month</td>
										<td>Attached Certificate</td>
										</tr>";
									}
								$my_html = $my_html . "</table><br/>";
							}
							if(count((array)$exp_list) > 0){
								$my_html = $my_html . "<strong>Desirable Experience</strong><br/>
								<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
								<tr>
								<td><strong>Experience Category</strong></td>
								<td><strong>Organization</strong></td>
								<td><strong>Time Period</strong></td>
								<td><strong>Upload Certificate</strong></td>
								</tr>";
								foreach($exp_list as $expss){
									$my_html = $my_html . "<tr>
									<td>".$expss->expset_name."</td>
									<td>".$expss->fu_exp_org_name."</td>
									<td>".$expss->fu_exp_year." Year & ".$expss->fu_exp_month." Month</td>
									<td>Attached Certificate</td>
									</tr>";
								}
								$my_html = $my_html . "</table>";
							}
						}
						$my_html = $my_html . "</td>
						</tr>";
					} 
					$my_html = $my_html . "</table>
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


	public function profile()
	{
		$this->load->view("main/member/profile_view", $this->data);
	}

	public function change_mobile_modfication(){
		$this->load->view("main/member/change_mobile_view", $this->data);
	}

	public function get_otp_formobile_change_candidates(){
		if($_POST){
			$oldmobile = $this->input->post('oldmobile');
			$newmobile = $this->input->post('newmobile');
			$this->form_validation->set_rules('oldmobile', 'Old Mobile No.', 'trim|required|exact_length[10]|is_natural');
			$this->form_validation->set_rules('newmobile', 'New Mobile No.', 'trim|required|exact_length[10]|is_natural');
			if ($this->form_validation->run()) {

				if($this->main_m->check_mobile_existence_forUpdation($newmobile, $this->data["fuser_detailset"]->f_applied_for) == TRUE){
					$generate_otp = $this->generateRandomString(6);
					$curtime = date("Y-m-d H:i:s");
					$newTime = date("Y-m-d H:i:s",strtotime($curtime." +10 minutes"));
					$row_arr = array(
						'mbe_type' => 'Mobile',
						'mbe_mob_email' => $oldmobile,
						'mbe_new_mob_email' => $newmobile,
						'mbe_otp' => $generate_otp,
						'mbe_otp_time' => $curtime,
						'mbe_otp_time_end' => $newTime,
						'mbe_created_by' => $this->session->userdata['member_id']
					);
					if($this->main_m->storeSet_MobileUpdation_Candidate($row_arr) == TRUE){
						$msg111 = 'Thank you for login in WBHRB website. Your OTP is '.$generate_otp.'.';
						$smsreplyset = $this->sendALLSMS($msg111, $newmobile, "otpmsg", '1207163455580746477');
						$smsarray = explode(',', $smsreplyset);
						if($smsarray[0] == 402){
							$detailset = $this->main_m->getLastRow_ofinsertionin_Table('Mobile',$oldmobile,$newmobile,$generate_otp);
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->mbe_id));
						}else{
							echo json_encode(array('msg'=> 0, 'e_msg'=>'OTP Not Send Properly, Check Again.'));
						}
					}else{
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Data Insertion Problem, Try Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'Mobile Number Already Registered, Check Again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function mobileno_modifcation_candidates(){
		if($_POST){
			$oldmobile = $this->input->post('oldmobile');
			$newmobile = $this->input->post('newmobile');
			$otp_sign = $this->input->post('otp_sign');
			$uset_app = $this->input->post('uset_app');
			$this->form_validation->set_rules('oldmobile', 'Old Mobile No.', 'trim|required|exact_length[10]|is_natural');
			$this->form_validation->set_rules('newmobile', 'New Mobile No.', 'trim|required|exact_length[10]|is_natural');
			$this->form_validation->set_rules('otp_sign', 'OTP Code', 'trim|required|is_natural');
            $this->form_validation->set_rules('uset_app', 'Modification Data', 'trim|required|is_natural');
			if ($this->form_validation->run()) {

				if($this->main_m->check_mobile_OTP_forUpdation('Mobile',$oldmobile,$newmobile,$otp_sign,$uset_app) == TRUE){
					$row_arr = array(
						'f_mobile' => $newmobile
					);
					if($this->main_m->insertRegistration_details_intheDB($row_arr, $this->session->userdata['member_id']) == TRUE){
						$row_arr2 = array('mbe_status' => 2);
						$this->main_m->storeSet_MobileUpdation_Candidate($row_arr2, $uset_app);
						echo json_encode(array('msg'=> 1));
					}else{
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Mobile No. not Update properly, Try Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'OTP not Matched, Try Again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function change_email_modfication(){
		$this->load->view("main/member/change_email_view", $this->data);
	}

	public function get_otp_foremail_change_candidates(){
		if($_POST){
			$oldmobile = $this->input->post('oldmobile');
			$newmobile = $this->input->post('newmobile');
			$this->form_validation->set_rules('oldmobile', 'Old Email-ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('newmobile', 'New Email-ID', 'trim|required|valid_email');
			if ($this->form_validation->run()) {

				if($this->main_m->check_Email_existence_forUpdation($newmobile, $this->data["fuser_detailset"]->f_applied_for) == TRUE){
					$generate_otp = $this->generateRandomString(6);
					$curtime = date("Y-m-d H:i:s");
					$newTime = date("Y-m-d H:i:s",strtotime($curtime." +10 minutes"));
					$row_arr = array(
						'mbe_type' => 'Email',
						'mbe_mob_email' => $oldmobile,
						'mbe_new_mob_email' => $newmobile,
						'mbe_otp' => $generate_otp,
						'mbe_otp_time' => $curtime,
						'mbe_otp_time_end' => $newTime,
						'mbe_created_by' => $this->session->userdata['member_id']
					);
					if($this->main_m->storeSet_MobileUpdation_Candidate($row_arr) == TRUE){
						$htmldataset = '<html><body><h1>Thank you for login in WBHRB website.<br/>Your ONE TIME PASSWORD IS - '.$generate_otp.'</h1></body></html>';
						$emailset = $this->sendALLSMTPEmail($newmobile,'WBHRB - Email Modification', $htmldataset);
						if($emailset == true){
							$detailset = $this->main_m->getLastRow_ofinsertionin_Table('Email',$oldmobile,$newmobile,$generate_otp);
							echo json_encode(array('msg'=>1, 's_msg' => $detailset->mbe_id));
						}else{
							echo json_encode(array('msg'=> 0, 'e_msg'=>'OTP Not Send Properly, Check Again.'));
						}
					}else{
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Data Insertion Problem, Try Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'Email-ID Already Registered, Check Again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function email_modifcation_candidates(){
		if($_POST){
			$oldmobile = $this->input->post('oldmobile');
			$newmobile = $this->input->post('newmobile');
			$otp_sign = $this->input->post('otp_sign');
			$uset_app = $this->input->post('uset_app');
			$this->form_validation->set_rules('oldmobile', 'Old Email-ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('newmobile', 'New Email-ID', 'trim|required|valid_email');
			$this->form_validation->set_rules('otp_sign', 'OTP Code', 'trim|required|is_natural');
            $this->form_validation->set_rules('uset_app', 'Modification Data', 'trim|required|is_natural');
			if ($this->form_validation->run()) {

				if($this->main_m->check_mobile_OTP_forUpdation('Email',$oldmobile,$newmobile,$otp_sign,$uset_app) == TRUE){
					$row_arr = array(
						'f_email' => $newmobile
					);
					if($this->main_m->insertRegistration_details_intheDB($row_arr, $this->session->userdata['member_id']) == TRUE){
						$row_arr2 = array('mbe_status' => 2);
						$this->main_m->storeSet_MobileUpdation_Candidate($row_arr2, $uset_app);
						echo json_encode(array('msg'=> 1));
					}else{
						echo json_encode(array('msg'=> 0, 'e_msg'=>'Email-ID not Update properly, Try Again.'));
					}
				}else{
					echo json_encode(array('msg'=> 0, 'e_msg'=>'OTP not Matched, Try Again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}


	public function change_password()
	{

		if ($_POST) {

			$c_pass = $this->input->post('c_pass');

			$n_pass = $this->input->post('n_pass');

			$re_pass = $this->input->post('re_pass');



			$this->form_validation->set_rules('c_pass', 'Current Password', 'trim|required');

			$this->form_validation->set_rules('n_pass', 'New Password', 'trim|required');

			$this->form_validation->set_rules('re_pass', 'Re-Enter Password', 'trim|required|matches[n_pass]');



			if ($this->form_validation->run() == TRUE) {

				$c_password = $this->member_m->hash($c_pass);

				if ($c_password == $this->data["fuser_detailset"]->f_password) {

					$n_password = $this->member_m->hash($n_pass);

					$row_array = array(

						'f_password' => $n_password,

						'f_modifydate' => date('Y-m-d H:i:s')

					);

					if ($this->member_m->change_existingUser_password($row_array, $this->session->userdata('member_id')) == TRUE) {

						$this->session->set_flashdata("success", "Password is Changed successfully.");

						redirect('member/profile', 'refresh');
					} else {

						$this->data['error'] = "There have some problem to Update DB, Try Again.";
					}
				} else {

					$this->data['error'] = "Current Password not Matched, Check Again.";
				}
			}
		}

		$this->load->view("main/member/bphc_changepass_view", $this->data);
	}



	public function edit_account()
	{



		$this->load->view("front/account_edit_view", $this->data);
	}



	public function logout()
	{

		$this->member_m->logout();

		$this->session->set_userdata('entry', TRUE);

		redirect('login');
	}

	public function check_candidate_status(){
		//echo "<pre>";
		//$this->data['allaccess_arr'] = array('fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service');
		$userdetails = $this->data["fuser_detailset"];
		$this->data["detail_cand_status"] = $candstat = $this->member_m->gotoCheck_CurrentStatus_ofCandidate($userdetails->f_applied_for, $userdetails->f_application_no);
		if($candstat == TRUE){
			$this->data["detail_interview"] = $this->member_m->gotoDetails_SearchforInterview_Set($userdetails->f_application_no);
			$this->data["rejection_list"] = $this->member_m->gotocollect_AllRejection_Set($userdetails->f_application_no);
			$this->data['allquali_list'] = $this->member_m->getAll_qualification_exam($userdetails->f_applied_for);
			$this->data['allexp_list'] = $this->member_m->getAll_Experience_section($userdetails->f_applied_for);
			$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All();
		}
		//print_r($this->data['allquali_list']);
		//exit;
		$this->load->view('main/member/status_view',$this->data);
	}

	public function print_callletter_for_candidateinterview(){

		$userdetails = $this->data["fuser_detailset"];
		//print_r($userdetails->f_application_no);exit;
		if ($userdetails->fu_step_4 != 1) {
			redirect('member/dashboard');
		}
		if ($userdetails->fu_final_submit != 1) {
			redirect('member/finalcheck_up');
		}

		if ($userdetails->fu_payment_stat != 1) {
			redirect('member/finalcheck_up');
		}
		$adv_detail = $this->data['adv_detail'];
		$getdetails_interview = $this->member_m->gotoDetails_SearchforInterview_Set($userdetails->f_application_no);
		$caste_tab = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
		if(count((array)$getdetails_interview) == 0){
			redirect('member/finalcheck_up');
		}

		if ($userdetails->fu_step_1 == 1) {

			$adv_category = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
		}

		if ($userdetails->fu_step_2 == 1) {

			$dist_list = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();

			if ($userdetails->fu_district != NULL) {

				$sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district))->result();
				$police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district))->result();
			}
			if ($userdetails->fu_perma_dist != NULL) {

				$per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist))->result();
				$per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist))->result();
			}
			if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
	
				$per_mb_type = $userdetails->fu_perma_mb_type;
				$per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type))->result();
			}else{
				$per_mb_type = NULL;
				$per_block_municipality = array();
			}
	
			if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
	
				$mb_type = $userdetails->fu_mb_type;
				$block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type))->result();
			}else{
				$mb_type = NULL;
				$block_municipality = array();
			}
			//$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
		}

		$exp_list = $this->member_m->gotoDesire_Experience_listSet($this->session->userdata['member_id']);
		$essenexp_list = $this->member_m->gotoEssential_Experience_listSet($this->session->userdata['member_id']);
		$desquali_list = $this->member_m->gotoDesire_Qualification_listSet($this->session->userdata['member_id']);
		$quali_list = $this->member_m->get_fuser_qualification();

		$state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();

		$dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();

		$rules_list = $this->db->order_by('rm_order ASC, rm_id ASC')->get_where('rules_master', array('rm_status' => 1))->result();

		$pathurl = 'upload_file/'. $userdetails->f_applied_for .'/candidates/' . $userdetails->f_application_no . '/';
		error_reporting(0);
		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $userdetails->f_application_no;
		$obj_pdf->SetTitle('Interview');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Interview CallLetter');

		$obj_pdf->SetPrintHeader(false);
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
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => false,
			'font' => 'helvetica',
			'fontsize' => 12,
			'stretchtext' => 10
		);

		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		</head>
		<body>
		<div class=\"header\">";
		$obj_pdf->write1DBarcode($userdetails->f_application_no, 'C93', 250, 20, '', 35, 0.7, $style, 'Y').$obj_pdf->Ln();
		//$obj_pdf->write2DBarcode($userdetails->f_application_no, 'QRCODE,H', 15, 15, 25, 25, NULL, '');
		$my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%;font-size: 22px;\">
				<tr>
				<td style=\"width:10%;\">&nbsp;</td>
				<td style=\"width:80%;\">
					<div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:100px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">Tele Fax No 23570085 & Tele. no. (033)-2340-5200</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\"><i>Email: wbhealthrecruitmentboard@gmail.com</i></span><br/>
					<span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter</u></span>
					</div>
				</td>
				<td style=\"width:10%;\">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%;font-size: 22px;\">
				<tr>
					<td style=\"width:80%;\" colspan=\"3\">
						<table style=\"width: 100%;font-size: 20px;\">
							<tr>
								<td colspan=\"2\">&nbsp;</td>
							</tr>
							<tr>
								<td align=\"center\">Advt. No. : ".$adv_detail->adv_no."</td>
								<td align=\"center\">Dated : ".date('d/m/Y',strtotime($adv_detail->adv_start_time))."</td>
							</tr>
							<tr>
								<td colspan=\"2\" style=\"width:100%;\"><br/><br/>
									<table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 20px;\">
										<tr>
											<td colspan=\"2\">NAME : ".$userdetails->f_full_name."</td>
										</tr>
										<tr>
											<td colspan=\"2\">ADDRESS : "; 
											
											foreach ($state_list as $states) {
												if ($states->state_id == $userdetails->fu_state) { $my_html = $my_html . "State : " .$states->state_name;break; }
											}
											if($userdetails->fu_state == 28){  
												foreach ($dist_list as $dists) { 
													if ($dists->district_code == $userdetails->fu_district) { $my_html = $my_html . ", District : " . $dists->district_name; }
												}
											}else{
												$my_html = $my_html . ", District : ".$userdetails->fu_other_district;
											}
						
											if($userdetails->fu_state == 28){
												foreach ($sub_division as $sd) {
													if ($userdetails->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . ", Sub-Division :" . $sd->subdiv_name; }
												}
												$bmset = '';
												foreach ($block_municipality as $bm) { 
													if ($bm->block_id == $userdetails->fu_block_municipality) {$bmset = $bm->block_name;}
												}
												$my_html = $my_html . ", Block/ Municipality : " . $userdetails->fu_mb_type.' ('.$bmset.')';
											}else{
												$my_html = $my_html . ", Sub-Division : ".$userdetails->fu_other_sdiv;
												$my_html = $my_html . ", Block/ Municipality : ".$userdetails->fu_other_blockm;
											}
						
											if($userdetails->fu_state == 28){
												foreach ($police_station as $ps) {
													if ($userdetails->fu_police_station == $ps->ps_id) {$my_html = $my_html .", Police Station : ". $ps->ps_name;}
												}
											}else{
												$my_html = $my_html . ", Police Station : ".$userdetails->fu_other_ps;
											}
											$my_html = $my_html . ", Ward/GP : ".$userdetails->fu_ward_gp.", Vill / Para / House No / Road : ".$userdetails->fu_house_road.", Post Office : ".$userdetails->fu_post_office.", Pin : ".$userdetails->fu_pincode;
											$my_html = $my_html."</td>
										</tr>
										<tr>
											<td colspan=\"2\">POST : ".$adv_detail->rm_name."</td>
										</tr>
										<tr>
											<td>CATEGORY : ";
											foreach ($caste_tab as $caste){
												if($userdetails->fu_caste_type == $caste->caste_id){ 
													$my_html = $my_html . $caste->caste_name;break;
												}
											}
											//$adv_category->catm_name
											$my_html = $my_html."</td>
											<td>PH STATUS : ".$userdetails->fu_pwd."</td>
										</tr>
										<tr>
											<td colspan=\"2\">REGISTRATION NO : ".$userdetails->f_application_no."</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td style=\"width:20%;\" valign=\"top\">
						<table border=\"1\" style=\"width: 100%;padding:5px;\">
							<tr>
								<td>
								<img src=\"".base_url().$pathurl.$userdetails->fu_photo_doc."\" style=\"max-width:150px;\" />
								</td>
							</tr>
						</table>
						<br>
						<table border=\"1\" style=\"width: 100%;padding:5px;\">
							<tr>
								<td>
								<img src=\"".base_url().$pathurl.$userdetails->fu_signature_doc."\" style=\"max-width:180px;\" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\"><br/><br/>
			<table style=\"width: 100%;font-size: 20px;\" border=\"0\" cellpadding=\"5\">";
				if ($adv_detail->adv_qualification_no > 0) {
					$my_html = $my_html . "<tr>
						<td><strong>Essential Qualification</strong><br/>
						<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
						<tr>
							<td width=\"25%\"><strong>Examination Name</strong></td>
							<td width=\"13%\"><strong>Board/ Council/ University/ Journal</strong></td>
							<td width=\"12%\"><strong>State Name</strong></td>
							<td width=\"10%\"><strong>Marks Obtained</strong></td>
							<td width=\"10%\"><strong>Full Marks</strong></td>
							<td width=\"11%\"><strong>Percentage(%) of Marks</strong></td>
							<td width=\"10%\"><strong>Additional Attempt</strong></td>
							<td width=\"9%\"><strong>No. of Attempt</strong></td>
						</tr>";
						foreach($quali_list as $qualiss){
							$my_html = $my_html . "<tr>
							<td>".$qualiss->qm_name."</td>
							<td>".$qualiss->fu_council_board."</td>
							<td>".$qualiss->state_name."</td>
							<td>".$qualiss->fu_marks_obtained."</td>
							<td>".$qualiss->fu_full_marks."</td>
							<td>".$qualiss->fu_percent_of_marks."</td>
							<td>".$qualiss->fu_is_attempt."</td>
							<td>".$qualiss->fu_attempt_no."</td>
							</tr>";
						}
						$my_html = $my_html . "</table></td>
						</tr>";
				}
			if(count((array)$desquali_list) > 0){
				$my_html = $my_html . "<tr>
					<td><strong>Desirable Qualification</strong><br/>
					<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
					<tr>
						<td width=\"25%\"><strong>Examination Name</strong></td>
						<td width=\"13%\"><strong>Board/ Council/ University/ Journal</strong></td>
						<td width=\"12%\"><strong>State Name</strong></td>
						<td width=\"10%\"><strong>Marks Obtained</strong></td>
						<td width=\"10%\"><strong>Full Marks</strong></td>
						<td width=\"11%\"><strong>Percentage(%) of Marks</strong></td>
						<td width=\"10%\"><strong>Additional Attempt</strong></td>
						<td width=\"9%\"><strong>No. of Attempt</strong></td>
					</tr>";
					foreach($desquali_list as $qualiss){
						$my_html = $my_html . "<tr>
						<td>".$qualiss->qm_name."</td>
						<td>".$qualiss->fud_council_board."</td>
						<td>".$qualiss->state_name."</td>
						<td>".$qualiss->fud_marks_obtained."</td>
						<td>".$qualiss->fud_full_marks."</td>
						<td>".$qualiss->fud_percent_of_marks."</td>
						<td>".$qualiss->fud_is_attempt."</td>
						<td>".$qualiss->fud_attempt_no."</td>
						</tr>";
					}
					$my_html = $my_html . "</table></td>
					</tr>";
			}
			if ($adv_detail->adv_has_experience == "Yes") {
				$my_html = $my_html . "<tr>
				<td>
				<label><strong>Experience in concerned field :</strong></label>".$userdetails->fu_has_service."<br/>";
				if ($userdetails->fu_has_service == "Yes") {
					if(count((array)$essenexp_list) > 0){
						$my_html = $my_html . "<strong>Essential Experience</strong><br/>
						<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
							<tr>
							<td width=\"45%\"><strong>Experience Category</strong></td>
							<td width=\"35%\"><strong>Organization</strong></td>
							<td width=\"20%\"><strong>Time Period</strong></td>
							</tr>";
							foreach($essenexp_list as $expss){
								$my_html = $my_html . "<tr>
								<td>".$expss->expset_name."</td>
								<td>".$expss->fues_exp_org_name."</td>
								<td>".$expss->fues_exp_year." Year & ".$expss->fues_exp_month." Month</td>
								</tr>";
							}
						$my_html = $my_html . "</table><br/>";
					}
					if(count((array)$exp_list) > 0){
						$my_html = $my_html . "<strong>Desirable Experience</strong><br/>
						<table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
						<tr>
						<td width=\"45%\"><strong>Experience Category</strong></td>
						<td width=\"35%\"><strong>Organization</strong></td>
						<td width=\"20%\"><strong>Time Period</strong></td>
						</tr>";
						foreach($exp_list as $expss){
							$my_html = $my_html . "<tr>
							<td>".$expss->expset_name."</td>
							<td>".$expss->fu_exp_org_name."</td>
							<td>".$expss->fu_exp_year." Year & ".$expss->fu_exp_month." Month</td>
							</tr>";
						}
						$my_html = $my_html . "</table>";
					}
				}
				$my_html = $my_html . "</td>
				</tr>";
			} 
			$my_html = $my_html . "</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table cellpadding=\"5\" border=\"0\" style=\"width: 100%;font-size: 20px;\">
					<tr>
						<td colspan=\"2\"><p align=\"justify\">Dear Candidate,<br/>
						With reference to the advertisement mentioned above for recruitment to the posts as mentioned above under Health & Family Welfare Department, Government of West Bengal, you are being called for interview on the venue, date, time and shift scheduled below. You are allowed to appear at the interview in West Bengal Health Recruitment Board.</p>
						</td>
					</tr>
					<tr>
						<td colspan=\"2\" style=\"font-size: 18px;\">
							<table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 18px;\">
								<tr>
									<td align=\"center\" style=\"width:50%;\"><strong>PLACE OF REPORTING</strong></td>
									<td align=\"center\" style=\"width:13%;\"><strong>DATE OF INTERVIEW</strong></td>
									<td align=\"center\" style=\"width:13%;\"><strong>REPORTING TIME</strong></td>
									<td align=\"center\" style=\"width:24%;\"><strong>SHIFT</strong></td>
								</tr>
								<tr>
									<td>".$getdetails_interview->address_name."</td>
									<td>".date('d-m-Y',strtotime($getdetails_interview->shift_date))."</td>
									<td>".date('h:i A',strtotime($getdetails_interview->invw_reporting_time))."</td>
									<td>".date('h:i A',strtotime($getdetails_interview->shift_start_time))." to ".date('h:i A',strtotime($getdetails_interview->shift_end_time))."</td>
								</tr>
							</table>
							<br/><br/><br/>
							<strong style=\"padding:10px;\">";
							foreach($rules_list as $ruleitem){
								$my_html = $my_html . "*" . $ruleitem->rm_details . "<br/>";
							}
							$my_html = $my_html . "</strong>
						</td>
					</tr>
					<tr>
						<td style=\"width:50%;\">&nbsp;</td>
						<td style=\"width:50%;font-size: 18px;\">
						<div align=\"center\" style=\"overflow:hidden;\">
						<b>Sd/-</b>
						<hr  style=\"width:63%;\" />
						<b>Secretary & Controller of Examinations<br/>
						West Bengal Health Recruitment Board</b>
						</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>";
		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');

		if($adv_detail->adv_dictation_set == "Yes"){

		$obj_pdf->AddPage();
		
		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		</head>
		<body>
		<div class=\"header\">";
		$obj_pdf->write1DBarcode($userdetails->f_application_no, 'C93', 250, 30, '', 35, 0.7, $style, 'Y').$obj_pdf->Ln();
		$my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%;font-size: 22px;\">
				<tr>
				<td style=\"width:10%;\">&nbsp;</td>
				<td style=\"width:80%;\">
					<div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:100px;\" /><br/>
					<span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\">Tele Fax No 23570085 & Tele. no. (033)-2340-5200</span><br/>
					<span align=\"center\" style=\"font-size:16px;font-weight:normal;\"><i>Email: wbhealthrecruitmentboard@gmail.com</i></span><br/>
					<span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter</u></span>
					</div>
				</td>
				<td style=\"width:10%;\">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%;font-size: 22px;\">
				<tr>
					<td style=\"width:80%;\" colspan=\"3\">
						<table style=\"width: 100%;font-size: 20px;\">
							<tr>
								<td colspan=\"2\">&nbsp;</td>
							</tr>
							<tr>
								<td align=\"center\">Advt. No. : ".$adv_detail->adv_no."</td>
								<td align=\"center\">Dated : ".date('d/m/Y',strtotime($adv_detail->adv_start_time))."</td>
							</tr>
							<tr>
								<td colspan=\"2\" style=\"width:100%;\"><br/><br/>
									<table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 20px;\">
										<tr>
											<td colspan=\"2\">NAME : ".$userdetails->f_full_name."</td>
										</tr>
										<tr>
											<td colspan=\"2\">ADDRESS : "; 
											
											foreach ($state_list as $states) {
												if ($states->state_id == $userdetails->fu_state) { $my_html = $my_html . "State : " .$states->state_name;break; }
											}
											if($userdetails->fu_state == 28){  
												foreach ($dist_list as $dists) { 
													if ($dists->district_code == $userdetails->fu_district) { $my_html = $my_html . ", District : " . $dists->district_name; }
												}
											}else{
												$my_html = $my_html . ", District : ".$userdetails->fu_other_district;
											}
						
											if($userdetails->fu_state == 28){
												foreach ($sub_division as $sd) {
													if ($userdetails->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . ", Sub-Division :" . $sd->subdiv_name; }
												}
												$bmset = '';
												foreach ($block_municipality as $bm) { 
													if ($bm->block_id == $userdetails->fu_block_municipality) {$bmset = $bm->block_name;}
												}
												$my_html = $my_html . ", Block/ Municipality : " . $userdetails->fu_mb_type.' ('.$bmset.')';
											}else{
												$my_html = $my_html . ", Sub-Division : ".$userdetails->fu_other_sdiv;
												$my_html = $my_html . ", Block/ Municipality : ".$userdetails->fu_other_blockm;
											}
						
											if($userdetails->fu_state == 28){
												foreach ($police_station as $ps) {
													if ($userdetails->fu_police_station == $ps->ps_id) {$my_html = $my_html .", Police Station : ". $ps->ps_name;}
												}
											}else{
												$my_html = $my_html . ", Police Station : ".$userdetails->fu_other_ps;
											}
											$my_html = $my_html . ", Ward/GP : ".$userdetails->fu_ward_gp.", Vill / Para / House No / Road : ".$userdetails->fu_house_road.", Post Office : ".$userdetails->fu_post_office.", Pin : ".$userdetails->fu_pincode;
											$my_html = $my_html."</td>
										</tr>
										<tr>
											<td colspan=\"2\">POST : ".$adv_detail->rm_name."</td>
										</tr>
										<tr>
											<td>CATEGORY : ";
											foreach ($caste_tab as $caste){
												if($userdetails->fu_caste_type == $caste->caste_id){ 
													$my_html = $my_html . $caste->caste_name;break;
												}
											}
											//$adv_category->catm_name
											$my_html = $my_html."</td>
											<td>PH STATUS : ".$userdetails->fu_pwd."</td>
										</tr>
										<tr>
											<td colspan=\"2\">REGISTRATION NO : ".$userdetails->f_application_no."</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td style=\"width:20%;\" valign=\"top\">
						<table border=\"1\" style=\"width: 100%;padding:5px;\">
							<tr>
								<td>
								<img src=\"".base_url().$pathurl.$userdetails->fu_photo_doc."\" style=\"max-width:150px;\" />
								</td>
							</tr>
						</table>
						<br>
						<table border=\"1\" style=\"width: 100%;padding:5px;\">
							<tr>
								<td>
								<img src=\"".base_url().$pathurl.$userdetails->fu_signature_doc."\" style=\"max-width:180px;\" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;font-size: 22px;\">
			<strong>SPACE FOR DICTATION WHERE APPLICABLE<br/>
			(ON THE SCHEDULED VENUE & DATE)</strong><br/>
			</td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
		</tr>
		<tr>
			<td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><br/><br/>&nbsp;</td>
		</tr>
		<tr>
			<td style=\"width:65%;\">
			Signature of the lnterviewer<br/><br/>
			Date :
			</td>
			<td align=\"left\" style=\"width:35%;\">
			Signature of the candidate after dictation<br/><br/>
			Date :
			</td>
		</tr>
		</table>
		</div>
		</body>
		</html>";

		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');

		}
		$obj_pdf->Output($title . '.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');

		//$this->session->set_flashdata("success","Report is Generated Successfully");

	}

	public function test4534347676756765765763333()
	{



		//$this->load->view('main/webcam-test');
	}


}
