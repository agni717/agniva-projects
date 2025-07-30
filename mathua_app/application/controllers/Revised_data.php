<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Revised_data extends Member_Controller
{



	function __construct()
	{

		parent::__construct();

		$this->load->model('main_m');
		$this->load->model('candidates_m');
		$this->load->model('member_m');

		date_default_timezone_set('Asia/Kolkata');


		$this->data["fuser_detailset"] = $this->db->get_where('f_user_views', array('f_uid' => $this->session->userdata['member_id']))->row();

		$this->data["detail_result"] = $this->db->get_where('candidate_result_tab', array('cr_application_master' => $this->data["fuser_detailset"]->f_application_no))->row();
		//$this->member_m->gotoDetails_SearchforInterview_Set($this->data["fuser_detailset"]->f_application_no);

		$this->data["fuser_quali"] = $this->member_m->get_fuser_qualification();

		$this->data["get_reject_access"] = $this->member_m->get_all_access_forReject_User_inthe_Advertisement($this->data["fuser_detailset"]->f_applied_for);

		$this->data['adv_detail'] = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($this->data["fuser_detailset"]->f_applied_for);
		if(count((array)$this->data['adv_detail']) == 0){
			$this->member_m->logout();
			$this->session->set_userdata('entry', TRUE);
			redirect('login');
		}

		$this->data['ssstr_arr'] = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service'
		);

		//$this->data['old_detail'] = $this->member_m->getAll_list_of_OLDData_for_PrevApplication($this->data["fuser_detailset"]->f_applied_for, $this->data["fuser_detailset"]->f_application_no);

		 //print_r($this->data["old_detail"]);		

	}


	public function index()
	{
		redirect('revised_data/form_fillup');
	}

	public function form_fillup()
	{

		if($this->data["get_reject_access"] == FALSE){
			redirect('member/dashboard');
		}

		//print_r($this->data["fuser_detailset"]);

		$userdetails = $this->data["fuser_detailset"];

		//$this->data['adv_detail'] = $this->main_m->getAll_list_of_Active_Advertisement($userdetails->f_applied_for);

		$this->data['caste_issuing_auth'] = $this->db->get('caste_issuing_auth_tab')->result();

		$this->data['caste_tab'] = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();

		if ($userdetails->fu_step_1 == 1) {

			$this->data['adv_category'] = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
		
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
			$this->data['quali_exam'] = $masterset_arr;
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
		// print_r($this->data["fuser_detailset"]);

		// print_r($this->data["caste_tab"]);

		//print_r($this->data['adv_category']);exit;

		// print_r($this->data['state_list']);

		// print_r($this->data['adv_detail']);
		$this->data['quali_list'] = $this->member_m->get_fuser_qualification();

		$this->data['extraage_list'] = $this->member_m->getAll_Existing_ExtraAgeSets_All();
		$this->data['extraage_set'] = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);
		//echo "<pre>";
		//print_r($this->data['extraage_set']);exit;

		$this->data['state_list'] = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();

		$this->data['dist_list'] = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();


		if ($userdetails->fu_caste_type != NULL && $userdetails->fu_caste_community != NULL) {

			$this->data['caste_community'] = $this->db->get_where('caste_details_tab', array('csdetail_id' => $userdetails->fu_caste_community, 'csdetail_status' => 1))->row();
		}

		$this->data["rejection_list"] = $this->member_m->gotocollect_AllRejection_Set($userdetails->f_application_no);
		$this->data['allquali_list'] = $this->member_m->getAll_qualification_exam($userdetails->f_applied_for);
		$this->data['allexp_list'] = $this->member_m->getAll_Experience_section($userdetails->f_applied_for);
		if(count((array)$this->data["rejection_list"]) == 0){
			redirect('member/dashboard');
		}
		$this->load->view("main/member/resubmit_view_v2", $this->data);
	}

	public function resubmit_address_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$error_section = 1;
			$error_received = '';
			$this->load->helper('file_upload');

			// echo json_encode($_FILES);
			$fu_address_doc = $userdetails->fu_address_doc;

			if (isset($_FILES['fu_address_doc']) && !empty($_FILES['fu_address_doc'])) {
				$upload_info = upload_file($_FILES['fu_address_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('ADDR_PROOF_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Address Proof - '.$upload_info['status'].'<br/>';
					//$fu_address_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_address_doc);
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_address_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 3,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_address_doc = $upload_info['result_path'];
				}
			}


			if($error_section == 1){

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
						'fu_address_doc' => $fu_address_doc,
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

	public function resubmit_photo_sign_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$error_section = 1;
			$error_received = '';
			$this->load->helper('file_upload');

			// echo json_encode($_FILES);
			$fu_type = $this->input->post('fu_type');

			if($fu_type != "" && $fu_type == "PHOTO"){

				$fu_pic_doc = $userdetails->fu_photo_doc;

				if (isset($_FILES['fu_pic_doc']) && !empty($_FILES['fu_pic_doc'])) {
					$upload_info = upload_file($_FILES['fu_pic_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PHOTO_'), array('jpg', 'jpeg', 'png'));

					if ($upload_info['error']) {
						$error_section++;
						$error_received = $error_received.'Picture - '.$upload_info['status'].'<br/>';
						//$fu_pic_doc = '';
					} else {
						//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_photo_doc);
						$row_arrdoc_up = array(
							'udm_cand_advno' => $userdetails->f_applied_for,
							'udm_cand_regno' => $userdetails->f_application_no,
							'udm_s_datetime' => date("Y-m-d H:i:s"),
							'udm_e_datetime' => date("Y-m-d H:i:s"),
							'udm_doctype' => 'CO',
							'udm_old_docname' => $userdetails->fu_photo_doc,
							'udm_new_docname' => $upload_info['result_path'],
							'udm_doc_id' => 1,
							'udm_status' => 2,
							'udm_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
						$fu_pic_doc = $upload_info['result_path'];
					}
				}

			}elseif($fu_type != "" && $fu_type == "SIGN"){

				$fu_sign_doc = $userdetails->fu_signature_doc;

				if (isset($_FILES['fu_sign_doc']) && !empty($_FILES['fu_sign_doc'])) {
					$upload_info = upload_file($_FILES['fu_sign_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('SIGN_'), array('jpg', 'jpeg', 'png', 'pdf'));

					if ($upload_info['error']) {
						$error_section++;
						$error_received = $error_received.'Signature - '.$upload_info['status'].'<br/>';
						//$fu_sign_doc = '';
					} else {
						//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_signature_doc);
						$row_arrdoc_up = array(
							'udm_cand_advno' => $userdetails->f_applied_for,
							'udm_cand_regno' => $userdetails->f_application_no,
							'udm_s_datetime' => date("Y-m-d H:i:s"),
							'udm_e_datetime' => date("Y-m-d H:i:s"),
							'udm_doctype' => 'CO',
							'udm_old_docname' => $userdetails->fu_signature_doc,
							'udm_new_docname' => $upload_info['result_path'],
							'udm_doc_id' => 2,
							'udm_status' => 2,
							'udm_createdate' => date('Y-m-d H:i:s')
						);
						$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
						$fu_sign_doc = $upload_info['result_path'];
					}
				}
			}

			if($error_section == 1){

				$msg = 0;

				//$this->form_validation->set_rules('same_address', 'Same Address', 'alpha|required');

				//if ($this->form_validation->run() == TRUE) {
				if($fu_type == "PHOTO"){
					$row_arr = array(
						'fu_photo_doc' => $fu_pic_doc,
						'fu_step2_submitdate' => date('Y-m-d H:i:s')
					);
				}elseif($fu_type == "SIGN"){
					$row_arr = array(
						'fu_signature_doc' => $fu_sign_doc,
						'fu_step2_submitdate' => date('Y-m-d H:i:s')
					);
				}

				if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
					echo json_encode(array('msg' => 1, 's_msg' => ''));
				} else {

					echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
				}

				//} else echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}

		} else redirect('default404');
	}

	public function resubmit_caste_processing(){

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
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_caste_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 5,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_caste_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');
				$fu_caste_type = $this->input->post('fu_caste_type');
				$com_castetypeset = $this->input->post('com_castetypeset');
				$fu_caste_community = $this->input->post('fu_caste_community');
				$fu_caste_number = $this->input->post('fu_caste_number');
				$fu_caste_issue_whom = $this->input->post('fu_caste_issue_whom');
				$fu_caste_issue_date = $this->input->post('fu_caste_issue_date');

				$msg = 0;

				$this->form_validation->set_rules('fu_caste_type', 'Caste', 'numeric|required');
				if($fu_caste_type != 1){
					if($com_castetypeset == 2){
						$this->form_validation->set_rules('fu_caste_community', 'Caste/ Tribe/ Community', 'numeric|required');
						$this->form_validation->set_rules('fu_caste_number', 'Caste Certification No.', 'required');
						$this->form_validation->set_rules('fu_caste_issue_whom', 'Caste Issued By Whom', 'numeric|required');
						$this->form_validation->set_rules('fu_caste_issue_date', 'Caste Issued Date', 'required');
					}
					//$this->form_validation->set_rules('fu_caste_community', 'Caste/ Tribe/ Community', 'numeric|required');
				}
				
				if($this->form_validation->run() == TRUE){

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

					$row_arr = array(
						//'fu_caste' => $fu_caste,
						'fu_caste_type' => $fu_caste_type,
						'fu_caste_community' => $fu_caste_community,
						'fu_caste_number' => $fu_caste_number,
						'fu_caste_issue_whom' => $fu_caste_issue_whom,
						'fu_caste_issue_date' => $fu_caste_issue_date,
						'fu_caste_doc' => $fu_caste_doc,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to Update Data, Try again.'));
					}
					
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
	}

	public function resubmit_pwd_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_pwd_doc = $userdetails->fu_pwd_doc;

			if (isset($_FILES['fu_pwd_doc']) && !empty($_FILES['fu_pwd_doc'])) {
				$upload_info = upload_file($_FILES['fu_pwd_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('PWD_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'PWD - '.$upload_info['status'].'<br/>';
					//$fu_pwd_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_pwd_doc);
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_pwd_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 6,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_pwd_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');
				$fu_pwd = $this->input->post('fu_pwd');
				$fu_pwd_percent = $this->input->post('fu_pwd_percent');
				$fu_pwd_issue_whom = $this->input->post('fu_pwd_issue_whom');
				$fu_pwd_issue_date = $this->input->post('fu_pwd_issue_date');

				$msg = 0;

				$this->form_validation->set_rules('fu_pwd', 'PWD', 'alpha|required');
				if($fu_pwd == "Yes"){
					$this->form_validation->set_rules('fu_pwd_percent', 'PWD Percent', 'numeric|required');
					$this->form_validation->set_rules('fu_pwd_issue_whom', 'PWD Issued By Whom', 'required');
					$this->form_validation->set_rules('fu_pwd_issue_date', 'PWD Issued Date', 'required');
				}
				
				if($this->form_validation->run() == TRUE){

					if ($fu_pwd == "No") {
						$fu_pwd_percent = NULL;
						$fu_pwd_issue_whom = NULL;
						$fu_pwd_issue_date = NULL;
						$fu_pwd_doc = NULL;
					}else{
						$fu_pwd_issue_date = date('Y-m-d',strtotime($fu_pwd_issue_date));
					}

					$row_arr = array(
						'fu_pwd' => $fu_pwd,
						'fu_pwd_percent' => $fu_pwd_percent,
						'fu_pwd_issue_whom' => $fu_pwd_issue_whom,
						'fu_pwd_issue_date' => $fu_pwd_issue_date,
						'fu_pwd_doc' => $fu_pwd_doc,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					$errorcounter = 0;
					$errormsg = '';
					
					if(($fu_pwd == "Yes") && (($adv_detail->adv_pwd_percent > $fu_pwd_percent) || ($fu_pwd_percent == 0))){
						$errorcounter++;
						$errormsg = $errormsg.'<br/>PWD Minimum Percentage Check Properly';
					}elseif($fu_pwd_percent > 100){
						$errorcounter++;
						$errormsg = $errormsg.'<br/>PWD Maximum Percentage Crossed, Check Properly';
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

	public function resubmit_agerelax_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			//$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$row_arr = array(
				'fu_step3_submitdate' => date('Y-m-d H:i:s')
			);

			$extage_list = $this->member_m->getAll_ExtraAgeSets_checkingall($this->data['adv_detail']->adv_auto_genno);
			$errorcounter = 0;
			$errormsg = '';
			if(count((array)$extage_list) > 0){
				$fu_extage = $this->input->post('fu_extage');
				$fu_extage_ids = $this->input->post('fu_extage_ids');
				$fu_extage_reason = $this->input->post('fu_extage_reason');
				for($keys = 0;$keys<count($fu_extage);$keys++){
					foreach($extage_list as $extageitem){
							//print_r($extage_list);
							//echo $fu_extage[$keys];exit;
						if($extageitem->advage_section == $fu_extage_ids[$keys]){
							
							if($fu_extage_ids[$keys] == ''){
								$errorcounter++;
								$errormsg = $errormsg.$extageitem->caste_name.': ID Field Required';
								break;
							}
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
											$row_arrdoc_up = array(
												'udm_cand_advno' => $userdetails->f_applied_for,
												'udm_cand_regno' => $userdetails->f_application_no,
												'udm_s_datetime' => date("Y-m-d H:i:s"),
												'udm_e_datetime' => date("Y-m-d H:i:s"),
												'udm_doctype' => 'EA',
												'udm_old_docname' => $resurnset->fu_ext_doc,
												'udm_new_docname' => $upload_data['file_name'],
												'udm_doc_id' => $resurnset->fu_ext_id,
												'udm_status' => 2,
												'udm_createdate' => date('Y-m-d H:i:s')
											);
											$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
										}
									}else{
										$errorcounter++;
										$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
										break;
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
												$errorcounter++;
												$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
												break;
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
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
											break;
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
											$errorcounter++;
											$errormsg = $errormsg.$extageitem->caste_name.': Data Update Problem Occured';
											break;
										}
									}else{
										$errorcounter++;
										$errormsg = $errormsg.$extageitem->caste_name.': Data Not Found';
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

		} else redirect('default404');
	}

	public function resubmit_es_qualification_processing(){
		
		if (isset($_POST) && !empty($_POST)) {
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');

			$total_exam = $this->input->post('total_exam');

			$examid = $this->input->post('examid');
			$exam_name = $this->input->post('exam_name');
			$exam_rej_id = $this->input->post('exam_rej_id');
			$univ = $this->input->post('univ');
			$state = $this->input->post('state');
			$marks_obtained = $this->input->post('marks_obtained');
			$marks_full = $this->input->post('marks_full');
			$marks_percent = $this->input->post('marks_percent');
			$add_attempt = $this->input->post('add_attempt');
			$add_attempt_no = $this->input->post('add_attempt_no');

			$this->form_validation->set_rules('total_exam', 'Total Exam', 'required|is_natural_no_zero');

			if($this->form_validation->run() == TRUE){

				$this->load->library('upload');
				$this->load->library('image_lib');
				$chk_exm_set = 0;
				$chk_exm_error = '';
				
				for($jk = 0; $jk < $total_exam; $jk++){
					
					if($exam_name[$jk] == NULL || $exam_name[$jk] == "" || $examid[$jk] == NULL || $examid[$jk] == "" || $exam_rej_id[$jk] == NULL || $exam_rej_id[$jk] == "" || $state[$jk] == NULL || $state[$jk] == "" || $univ[$jk] == NULL || $univ[$jk] == "" || $marks_full[$jk] == NULL || $marks_full[$jk] == "" || $marks_obtained[$jk] == NULL || $marks_obtained[$jk] == "" || $marks_percent[$jk] == NULL || $marks_percent[$jk] == "" || $add_attempt[$jk] == NULL || $add_attempt[$jk] == ""){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Some Fields are Missing, Check Again<br/>";
						break;
					}
					if($add_attempt[$jk] == "Yes"){
						if($add_attempt_no[$jk] == "" || $add_attempt_no[$jk] == NULL){
							$chk_exm_set++;
							$chk_exm_error = $chk_exm_error."Additional Attempt No. is Required, Check Again<br/>";
							break;
						}
					}

					$getqualidata = $this->db->get_where('f_user_qualification',array('fu_quali_id'=> $examid[$jk], 'fu_qualifiaction_name' => $exam_rej_id[$jk], 'fu_quali_masteruser' => $this->session->userdata("member_id")))->row();
					if(count((array)$getqualidata) == 0){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Qualification is Missing, Check Again<br/>";
						break;
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
								$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
								$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
								$row_arr2 = array(
									//'fu_quali_masteruser' => $this->session->userdata('member_id'),
									'fu_qualifiaction_name' => $exam_name[$jk],
									'fu_state_of_passing' => $state[$jk],
									'fu_council_board' => $univ[$jk],
									'fu_full_marks' => $marks_full[$jk],
									'fu_marks_obtained' => $marks_obtained[$jk],
									'fu_percent_of_marks' => $percentupdate,
									'fu_fullmark_ck' => $marks_full[$jk],
									'fu_obtainmark_ck' => $marks_obtained[$jk],
									'fu_percentmark_ck' => $percentupdate,
									'fu_is_attempt' => $add_attempt[$jk],
									'fu_attempt_no' => $add_attempt_no[$jk],
									'fu_quali_docs' => $upload_data['file_name'],
									'fu_quali_createdate' => date('Y-m-d H:i:s')
								);
								

								if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Qualification not update properly, Try Again<br/>";
									break;
								}else{
									$row_arrdoc_up = array(
										'udm_cand_advno' => $userdetails->f_applied_for,
										'udm_cand_regno' => $userdetails->f_application_no,
										'udm_s_datetime' => date("Y-m-d H:i:s"),
										'udm_e_datetime' => date("Y-m-d H:i:s"),
										'udm_doctype' => 'EQ',
										'udm_old_docname' => $getqualidata->fu_quali_docs,
										'udm_new_docname' => $upload_data['file_name'],
										'udm_doc_id' => $examid[$jk],
										'udm_status' => 2,
										'udm_createdate' => date('Y-m-d H:i:s')
									);
									$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
								}
								
							}else{
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document not Upload properly, Try Again<br/>";
								break;
							}
						}else{
							if($getqualidata->fu_quali_docs == "" || $getqualidata->fu_quali_docs == "NULL"){
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document is Missing, Check Again<br/>";
								break;
							}else{
								$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
								$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
								$row_arr2 = array(
									//'fu_quali_masteruser' => $this->session->userdata('member_id'),
									'fu_qualifiaction_name' => $exam_name[$jk],
									'fu_state_of_passing' => $state[$jk],
									'fu_council_board' => $univ[$jk],
									'fu_full_marks' => $marks_full[$jk],
									'fu_marks_obtained' => $marks_obtained[$jk],
									'fu_percent_of_marks' => $percentupdate,
									'fu_fullmark_ck' => $marks_full[$jk],
									'fu_obtainmark_ck' => $marks_obtained[$jk],
									'fu_percentmark_ck' => $percentupdate,
									'fu_is_attempt' => $add_attempt[$jk],
									'fu_attempt_no' => $add_attempt_no[$jk],
									'fu_quali_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->member_m->add_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Qualification not update properly, Try Again<br/>";
									break;
								}
							}
							
						}
					}
				}
				if($chk_exm_set == 0){

					$row_arr = array(
						'fu_step4_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
					}

				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => $chk_exm_error.'<br/>Qualification section Problem Occured, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}


		} else redirect('default404');
	}

	public function resubmit_ds_qualification_processing(){
		
		if (isset($_POST) && !empty($_POST)) {
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');

			$total_exam = $this->input->post('total_exam');

			$examid = $this->input->post('examid');
			$exam_rej_id = $this->input->post('exam_rej_id');
			$univ = $this->input->post('univ');
			$state = $this->input->post('state');
			$marks_obtained = $this->input->post('marks_obtained');
			$marks_full = $this->input->post('marks_full');
			$marks_percent = $this->input->post('marks_percent');
			$add_attempt = $this->input->post('add_attempt');
			$add_attempt_no = $this->input->post('add_attempt_no');

			$this->form_validation->set_rules('total_exam', 'Total Exam', 'required|is_natural_no_zero');

			if($this->form_validation->run() == TRUE){

				$this->load->library('upload');
				$this->load->library('image_lib');
				$chk_exm_set = 0;
				$chk_exm_error = '';
				
				for($jk = 0; $jk < $total_exam; $jk++){
					
					if($examid[$jk] == NULL || $examid[$jk] == "" || $exam_rej_id[$jk] == NULL || $exam_rej_id[$jk] == "" || $state[$jk] == NULL || $state[$jk] == "" || $univ[$jk] == NULL || $univ[$jk] == "" || $marks_full[$jk] == NULL || $marks_full[$jk] == "" || $marks_obtained[$jk] == NULL || $marks_obtained[$jk] == "" || $marks_percent[$jk] == NULL || $marks_percent[$jk] == "" || $add_attempt[$jk] == NULL || $add_attempt[$jk] == ""){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Some Fields are Missing, Check Again<br/>";
						break;
					}
					if($add_attempt[$jk] == "Yes"){
						if($add_attempt_no[$jk] == "" || $add_attempt_no[$jk] == NULL){
							$chk_exm_set++;
							$chk_exm_error = $chk_exm_error."Additional Attempt No. is Required, Check Again<br/>";
							break;
						}
					}

					$getqualidata = $this->db->get_where('f_user_des_qualification',array('fud_quali_id'=> $examid[$jk], 'fud_qualifiaction_name' => $exam_rej_id[$jk], 'fud_quali_masteruser' => $this->session->userdata("member_id")))->row();
					if(count((array)$getqualidata) == 0){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Qualification is Missing, Check Again<br/>";
						break;
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
								$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
								$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
								$row_arr2 = array(
									//'fud_quali_masteruser' => $this->session->userdata('member_id'),
									//'fud_qualifiaction_name' => $exam_name[$jk],
									'fud_state_of_passing' => $state[$jk],
									'fud_council_board' => $univ[$jk],
									'fud_full_marks' => $marks_full[$jk],
									'fud_marks_obtained' => $marks_obtained[$jk],
									'fud_percent_of_marks' => $percentupdate,
									'fud_fullmark_ck' => $marks_full[$jk],
									'fud_obtainmark_ck' => $marks_obtained[$jk],
									'fud_percentmark_ck' => $percentupdate,
									'fud_is_attempt' => $add_attempt[$jk],
									'fud_attempt_no' => $add_attempt_no[$jk],
									'fud_quali_docs' => $upload_data['file_name'],
									'fud_quali_createdate' => date('Y-m-d H:i:s')
								);
								
								if ($this->member_m->add_dsQuali_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Qualification not update properly, Try Again<br/>";
									break;
								}else{
									$row_arrdoc_up = array(
										'udm_cand_advno' => $userdetails->f_applied_for,
										'udm_cand_regno' => $userdetails->f_application_no,
										'udm_s_datetime' => date("Y-m-d H:i:s"),
										'udm_e_datetime' => date("Y-m-d H:i:s"),
										'udm_doctype' => 'DQ',
										'udm_old_docname' => $getqualidata->fud_quali_docs,
										'udm_new_docname' => $upload_data['file_name'],
										'udm_doc_id' => $examid[$jk],
										'udm_status' => 2,
										'udm_createdate' => date('Y-m-d H:i:s')
									);
									$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
								}
								
							}else{
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document not Upload properly, Try Again<br/>";
								break;
							}
						}else{
							if($getqualidata->fud_quali_docs == "" || $getqualidata->fud_quali_docs == "NULL"){
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document is Missing, Check Again<br/>";
								break;
							}else{
								$selectpercent = (($marks_obtained[$jk] * 100) / $marks_full[$jk]);
								$percentupdate = number_format((float)$selectpercent, 2, '.', '');
								if(empty($add_attempt_no[$jk]) || $add_attempt_no[$jk] == ''){$add_attempt_no[$jk] = NULL;}
								$row_arr2 = array(
									//'fud_quali_masteruser' => $this->session->userdata('member_id'),
									//'fud_qualifiaction_name' => $exam_name[$jk],
									'fud_state_of_passing' => $state[$jk],
									'fud_council_board' => $univ[$jk],
									'fud_full_marks' => $marks_full[$jk],
									'fud_marks_obtained' => $marks_obtained[$jk],
									'fud_percent_of_marks' => $percentupdate,
									'fud_fullmark_ck' => $marks_full[$jk],
									'fud_obtainmark_ck' => $marks_obtained[$jk],
									'fud_percentmark_ck' => $percentupdate,
									'fud_is_attempt' => $add_attempt[$jk],
									'fud_attempt_no' => $add_attempt_no[$jk],
									'fud_quali_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->member_m->add_dsQuali_fuser_qualification($row_arr2, $examid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Qualification not update properly, Try Again<br/>";
									break;
								}
							}
							
						}
					}
				}
				if($chk_exm_set == 0){

					$row_arr = array(
						'fu_step4_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to retrieve Data, Try again.'));
					}

				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => $chk_exm_error.'<br/>Qualification section Problem Occured, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}


		} else redirect('default404');
	}
	
	public function resubmit_es_service_processing(){
		
		if (isset($_POST) && !empty($_POST)) {
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');

			$total_exp = $this->input->post('total_exp');

			$expid = $this->input->post('expid');
			$exp_rej_id = $this->input->post('exp_rej_id');
			$exporg = $this->input->post('exporg');
			$expyear = $this->input->post('expyear');
			$expmonth = $this->input->post('expmonth');

			$this->form_validation->set_rules('total_exp', 'Total Exp.', 'required|is_natural_no_zero');

			if($this->form_validation->run() == TRUE){

				/*$expchecker_cnt = 0;
				$expchecker_error = '';
				if($adv_detail->adv_has_experience == "Yes"){
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
										for($jj=0;$jj<count($masterexp_arr[$q]);$jj){
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
					
				}*/

				$this->load->library('upload');
				$this->load->library('image_lib');
				$chk_exm_set = 0;
				$chk_exm_error = '';
				
				for($jk = 0; $jk < $total_exp; $jk++){
					
					if($expid[$jk] == NULL || $expid[$jk] == "" || $exp_rej_id[$jk] == NULL || $exp_rej_id[$jk] == "" || $exporg[$jk] == NULL || $exporg[$jk] == "" || $expyear[$jk] == NULL || $expyear[$jk] == "" || $expmonth[$jk] == NULL || $expmonth[$jk] == ""){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Some Fields are Missing, Check Again<br/>";
						break;
					}
					
					$getqualidata = $this->db->get_where('f_user_ess_experience',array('fues_exp_id'=> $expid[$jk], 'fues_exp_workname' => $exp_rej_id[$jk], 'fues_exp_masteruser' => $this->session->userdata("member_id")))->row();
					if(count((array)$getqualidata) == 0){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Experience is Missing, Check Again<br/>";
						break;
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
								$row_arr2 = array(
									//'fues_exp_masteruser' => $this->session->userdata('member_id'),
									//'fues_exp_workname' => $exam_name[$jk],
									'fues_exp_org_name' => $exporg[$jk],
									'fues_exp_year' => $expyear[$jk],
									'fues_exp_month' => $expmonth[$jk],
									'fues_exp_yr_ck' => $expyear[$jk],
									'fues_exp_mth_ck' => $expmonth[$jk],
									'fues_exp_marksheet_doc' => $upload_data['file_name'],
									'fues_exp_createdate' => date('Y-m-d H:i:s')
								);
								
								if ($this->member_m->add_essExp_fuser_Experience($row_arr2, $expid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Experience not update properly, Try Again<br/>";
									break;
								}else{
									$row_arrdoc_up = array(
										'udm_cand_advno' => $userdetails->f_applied_for,
										'udm_cand_regno' => $userdetails->f_application_no,
										'udm_s_datetime' => date("Y-m-d H:i:s"),
										'udm_e_datetime' => date("Y-m-d H:i:s"),
										'udm_doctype' => 'ES',
										'udm_old_docname' => $getqualidata->fues_exp_marksheet_doc,
										'udm_new_docname' => $upload_data['file_name'],
										'udm_doc_id' => $expid[$jk],
										'udm_status' => 2,
										'udm_createdate' => date('Y-m-d H:i:s')
									);
									$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
								}
								
							}else{
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document not Upload properly, Try Again<br/>";
								break;
							}
						}else{
							if($getqualidata->fues_exp_marksheet_doc == "" || $getqualidata->fues_exp_marksheet_doc == "NULL"){
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document is Missing, Check Again<br/>";
								break;
							}else{
								$row_arr2 = array(
									//'fues_exp_masteruser' => $this->session->userdata('member_id'),
									//'fues_exp_workname' => $exam_name[$jk],
									'fues_exp_org_name' => $exporg[$jk],
									'fues_exp_year' => $expyear[$jk],
									'fues_exp_month' => $expmonth[$jk],
									'fues_exp_yr_ck' => $expyear[$jk],
									'fues_exp_mth_ck' => $expmonth[$jk],
									'fues_exp_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->member_m->add_essExp_fuser_Experience($row_arr2, $expid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Experience not update properly, Try Again<br/>";
									break;
								}
							}
							
						}
					}
				}
				if($chk_exm_set == 0){

					$row_arr = array(
						'fu_step4_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to update Data, Try again.'));
					}

				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => $chk_exm_error.'<br/>Experience section Problem Occured, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}


		} else redirect('default404');
	}

	public function resubmit_ds_service_processing(){
		
		if (isset($_POST) && !empty($_POST)) {
			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');

			$total_exp = $this->input->post('total_exp');

			$expid = $this->input->post('expid');
			$exp_rej_id = $this->input->post('exp_rej_id');
			$exporg = $this->input->post('exporg');
			$expyear = $this->input->post('expyear');
			$expmonth = $this->input->post('expmonth');

			$this->form_validation->set_rules('total_exp', 'Total Exp.', 'required|is_natural_no_zero');

			if($this->form_validation->run() == TRUE){

				/*$expchecker_cnt = 0;
				$expchecker_error = '';
				if($adv_detail->adv_has_experience == "Yes"){
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
										for($jj=0;$jj<count($masterexp_arr[$q]);$jj){
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
					
				}*/

				$this->load->library('upload');
				$this->load->library('image_lib');
				$chk_exm_set = 0;
				$chk_exm_error = '';
				
				for($jk = 0; $jk < $total_exp; $jk++){
					
					if($expid[$jk] == NULL || $expid[$jk] == "" || $exp_rej_id[$jk] == NULL || $exp_rej_id[$jk] == "" || $exporg[$jk] == NULL || $exporg[$jk] == "" || $expyear[$jk] == NULL || $expyear[$jk] == "" || $expmonth[$jk] == NULL || $expmonth[$jk] == ""){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Some Fields are Missing, Check Again<br/>";
						break;
					}
					
					$getqualidata = $this->db->get_where('f_user_experience',array('fu_exp_id'=> $expid[$jk], 'fu_exp_workname' => $exp_rej_id[$jk], 'fu_exp_masteruser' => $this->session->userdata("member_id")))->row();
					if(count((array)$getqualidata) == 0){
						$chk_exm_set++;
						$chk_exm_error = $chk_exm_error."Experience is Missing, Check Again<br/>";
						break;
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
								$row_arr2 = array(
									//'fu_exp_masteruser' => $this->session->userdata('member_id'),
									//'fu_exp_workname' => $exam_name[$jk],
									'fu_exp_org_name' => $exporg[$jk],
									'fu_exp_year' => $expyear[$jk],
									'fu_exp_month' => $expmonth[$jk],
									'fu_exp_yr_ck' => $expyear[$jk],
									'fu_exp_mth_ck' => $expmonth[$jk],
									'fu_exp_marksheet_doc' => $upload_data['file_name'],
									'fu_exp_createdate' => date('Y-m-d H:i:s')
								);
								
								if ($this->member_m->add_desExp_fuser_Experience($row_arr2, $expid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Experience not update properly, Try Again<br/>";
									break;
								}else{
									$row_arrdoc_up = array(
										'udm_cand_advno' => $userdetails->f_applied_for,
										'udm_cand_regno' => $userdetails->f_application_no,
										'udm_s_datetime' => date("Y-m-d H:i:s"),
										'udm_e_datetime' => date("Y-m-d H:i:s"),
										'udm_doctype' => 'DS',
										'udm_old_docname' => $getqualidata->fu_exp_marksheet_doc,
										'udm_new_docname' => $upload_data['file_name'],
										'udm_doc_id' => $expid[$jk],
										'udm_status' => 2,
										'udm_createdate' => date('Y-m-d H:i:s')
									);
									$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
								}
								
							}else{
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document not Upload properly, Try Again<br/>";
								break;
							}
						}else{
							if($getqualidata->fu_exp_marksheet_doc == "" || $getqualidata->fu_exp_marksheet_doc == "NULL"){
								$chk_exm_set++;
								$chk_exm_error = $chk_exm_error."Document is Missing, Check Again<br/>";
								break;
							}else{
								$row_arr2 = array(
									//'fu_exp_masteruser' => $this->session->userdata('member_id'),
									//'fu_exp_workname' => $exam_name[$jk],
									'fu_exp_org_name' => $exporg[$jk],
									'fu_exp_year' => $expyear[$jk],
									'fu_exp_month' => $expmonth[$jk],
									'fu_exp_yr_ck' => $expyear[$jk],
									'fu_exp_mth_ck' => $expmonth[$jk],
									'fu_exp_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->member_m->add_desExp_fuser_Experience($row_arr2, $expid[$jk]) == FALSE) {
									$chk_exm_set++;
									$chk_exm_error = $chk_exm_error."Experience not update properly, Try Again<br/>";
									break;
								}
							}
							
						}
					}
				}
				if($chk_exm_set == 0){

					$row_arr = array(
						'fu_step4_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {

						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to update Data, Try again.'));
					}

				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => $chk_exm_error.'<br/>Experience section Problem Occured, Check Again.'));
				}

			}else{
				echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
			}


		} else redirect('default404');
	}

	public function resubmit_dob_processing(){

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
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_dob_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 4,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_dob_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){

				//print_r($_REQUEST);exit;

				//$fu_has_service = $this->input->post('fu_has_service');

				$fu_dob = $this->input->post('fu_dob');

				//$total_exam = $this->input->post('total_exam');

				//$exp_counter = $this->input->post('exp_counter');
				//$ess_exp_counter = $this->input->post('ess_exp_counter');

				$msg = 0;

				$this->form_validation->set_rules('fu_dob', 'Date of Birth', 'required');
				/*if($adv_detail->adv_has_experience == "Yes"){
					$this->form_validation->set_rules('fu_has_service', 'Has Experience', 'required|Alpha');
				}else{
					$fu_has_service = NULL;
				}
				$this->form_validation->set_rules('total_exam', 'Total Exam', 'required|is_natural');
				if($fu_has_service == "Yes"){
					$this->form_validation->set_rules('exp_counter', 'No. of Desirable Exp', 'required|is_natural');
					$this->form_validation->set_rules('ess_exp_counter', 'No. of Essential Exp', 'required|is_natural');
				}*/

				//print_r($fu_dob);
				if($this->form_validation->run() == TRUE){

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
						
						$row_arr = array(
							//'fu_has_service' => $fu_has_service,
							//'fu_qualification_total' => $total_exam,
							//'fu_experience_total' => $exp_counter,
							'fu_dob' => $fu_dob,
							'fu_dob_doc' => $fu_dob_doc,
							'fu_step4_submitdate' => date('Y-m-d H:i:s')
						);

						if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
							echo json_encode(array('msg' => 1, 's_msg' => ''));
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to Update Data, Try again.'));
						}

					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => 'DOB is Mismatch, check Again.'));
					}

				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}


		} else redirect('default404');
	}

	public function resubmit_exempted_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_exc_doc = $userdetails->fu_exc_doc;

			if (isset($_FILES['fu_exc_doc']) && !empty($_FILES['fu_exc_doc'])) {
				$upload_info = upload_file($_FILES['fu_exc_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exampted_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Exempted Category - '.$upload_info['status'].'<br/>';
					//$fu_exc_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exc_doc);
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_exc_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 7,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_exc_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');
				$fu_exc_reason = $this->input->post('fu_exc_reason');

				$msg = 0;

				$this->form_validation->set_rules('fu_exc_reason', 'Description', 'required');
				
				if($this->form_validation->run() == TRUE){

					$row_arr = array(
						//'fu_caste' => $fu_caste,
						'fu_exc_reason' => $fu_exc_reason,
						'fu_exc_doc' => $fu_exc_doc,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to Update Data, Try again.'));
					}
					
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
	}

	public function resubmit_exservice_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_exs_doc = $userdetails->fu_exs_doc;

			if (isset($_FILES['fu_exs_doc']) && !empty($_FILES['fu_exs_doc'])) {
				$upload_info = upload_file($_FILES['fu_exs_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Exservice_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Ex-Service Category - '.$upload_info['status'].'<br/>';
					//$fu_exs_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_exs_doc);
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_exs_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 8,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_exs_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');
				$fu_exs_reason = $this->input->post('fu_exs_reason');

				$msg = 0;

				$this->form_validation->set_rules('fu_exs_reason', 'Description', 'required');
				
				if($this->form_validation->run() == TRUE){

					$row_arr = array(
						//'fu_caste' => $fu_caste,
						'fu_exs_reason' => $fu_exs_reason,
						'fu_exs_doc' => $fu_exs_doc,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to Update Data, Try again.'));
					}
					
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
	}

	public function resubmit_sprotsews_processing(){

		if (isset($_POST) && !empty($_POST)) {

			$userdetails = $this->data["fuser_detailset"];
			$adv_detail = $this->data['adv_detail'];
			$this->load->helper('file_upload');
			$error_section = 1;
			$error_received = '';
			// echo json_encode($_FILES);

			$fu_ews_doc = $userdetails->fu_ews_doc;

			if (isset($_FILES['fu_ews_doc']) && !empty($_FILES['fu_ews_doc'])) {
				$upload_info = upload_file($_FILES['fu_ews_doc'], "upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no, uniqid('Sportsman_'), array('jpg', 'jpeg', 'png', 'pdf'));

				if ($upload_info['error']) {
					$error_section++;
					$error_received = $error_received.'Sportsman Category - '.$upload_info['status'].'<br/>';
					//$fu_ews_doc = '';
				} else {
					//delete_file("upload_file/" . $userdetails->f_applied_for . "/candidates/" . $userdetails->f_application_no . "/" . $userdetails->fu_ews_doc);
					$row_arrdoc_up = array(
						'udm_cand_advno' => $userdetails->f_applied_for,
						'udm_cand_regno' => $userdetails->f_application_no,
						'udm_s_datetime' => date("Y-m-d H:i:s"),
						'udm_e_datetime' => date("Y-m-d H:i:s"),
						'udm_doctype' => 'CO',
						'udm_old_docname' => $userdetails->fu_ews_doc,
						'udm_new_docname' => $upload_info['result_path'],
						'udm_doc_id' => 9,
						'udm_status' => 2,
						'udm_createdate' => date('Y-m-d H:i:s')
					);
					$this->candidates_m->addmodify_EmailDocReplace_ByChecker($row_arrdoc_up);
					$fu_ews_doc = $upload_info['result_path'];
				}
			}

			if($error_section == 1){
				//$fu_caste = $this->input->post('fu_caste');
				$fu_ews_reason = $this->input->post('fu_ews_reason');

				$msg = 0;

				$this->form_validation->set_rules('fu_ews_reason', 'Description', 'required');
				
				if($this->form_validation->run() == TRUE){

					$row_arr = array(
						//'fu_caste' => $fu_caste,
						'fu_ews_reason' => $fu_ews_reason,
						'fu_ews_doc' => $fu_ews_doc,
						'fu_step3_submitdate' => date('Y-m-d H:i:s')
					);

					if ($this->member_m->update_frontuser_details_modified($row_arr) == TRUE) {
						echo json_encode(array('msg' => 1, 's_msg' => ''));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some problem to Update Data, Try again.'));
					}
					
				}else{
					echo json_encode(array('msg'=>0, 'e_msg'=>validation_errors()));
				}

			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'File Upload Problem occured, Check Again.<br/>'.$error_received));
			}
		} else redirect('default404');
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

				$this->form_validation->set_rules('fu_caste_type', 'Caste', 'numeric');

				$msg = 0;

				if($adv_detail->adv_has_exampted == "No"){
					$fu_exempted = NULL;
				}
				if($adv_detail->adv_has_exservice == "No"){
					$fu_exservice = NULL;
				}
				if($adv_detail->adv_has_ews == "No"){
					$fu_ews = NULL;
				}


				if($this->form_validation->run() == TRUE){

					if ($fu_caste_type == "undefined"){ $fu_caste_type = NULL; }

					if ($fu_pwd == "undefined"){ $fu_pwd = NULL; }

					if ($fu_caste_type == 1) {
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
					$this->form_validation->set_rules('fu_caste_community', 'Caste/ Tribe/ Community', 'numeric|required');
					$this->form_validation->set_rules('fu_caste_number', 'Caste Certification No.', 'required');
					$this->form_validation->set_rules('fu_caste_issue_whom', 'Caste Issued By Whom', 'numeric|required');
					$this->form_validation->set_rules('fu_caste_issue_date', 'Caste Issued Date', 'required');
				}
				$this->form_validation->set_rules('fu_pwd', 'PWD', 'alpha|required');
				if($fu_pwd == "Yes"){
					$this->form_validation->set_rules('fu_pwd_percent', 'PWD Percent', 'numeric|required');
					$this->form_validation->set_rules('fu_pwd_issue_whom', 'PWD Issued By Whom', 'required');
					$this->form_validation->set_rules('fu_pwd_issue_date', 'PWD Issued Date', 'required');
				}

				if($adv_detail->adv_has_exampted == "Yes"){
					$this->form_validation->set_rules('fu_exempted', 'Exempted', 'alpha|required');
					if($fu_exempted == "Yes"){
						$this->form_validation->set_rules('fu_exc_reason', 'Exempted Reason', 'required');
					}
				}else{
					$fu_exempted = NULL;
				}
				if($adv_detail->adv_has_exservice == "Yes"){
					$this->form_validation->set_rules('fu_exservice', 'Ex Serviceman', 'alpha|required');
					if($fu_exservice == "Yes"){
						$this->form_validation->set_rules('fu_exs_reason', 'Ex Serviceman Description', 'required');
					}
				}else{
					$fu_exservice = NULL;
				}
				if($adv_detail->adv_has_ews == "Yes"){
					$this->form_validation->set_rules('fu_ews', 'EWS', 'alpha|required');
					if($fu_ews == "Yes"){
						$this->form_validation->set_rules('fu_ews_reason', 'EWS Description', 'required');
					}
				}else{
					$fu_ews = NULL;
				}

				

				// upload_file($_FILES[])

				if($this->form_validation->run() == TRUE){

					if ($fu_caste_type == 1) {
						$fu_caste_community = NULL;
						$fu_caste_number = NULL;
						$fu_caste_issue_whom = NULL;
						$fu_caste_issue_date = NULL;
						$fu_caste_doc = NULL;
					}else{
						$fu_caste_issue_date = date('Y-m-d',strtotime($fu_caste_issue_date));
					}
					if ($fu_pwd == "No") {
						$fu_pwd_percent = NULL;
						$fu_pwd_issue_whom = NULL;
						$fu_pwd_issue_date = NULL;
						$fu_pwd_doc = NULL;
					}else{
						$fu_pwd_issue_date = date('Y-m-d',strtotime($fu_pwd_issue_date));
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
					//print_r($fu_dob);
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
												for($jj=0;$jj<count($masterexp_arr[$q]);$jj){
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
							
						}
						
						if($expchecker_cnt == 0){
						//echo "<pre>";
						//print_r($_FILES);exit;
						$existing_limit_update = $adv_detail->adv_age_limit;
						$getall_ageset = $this->member_m->gatAll_subscriptionAge_list($userdetails->f_applied_for);
						if(count((array)$getall_ageset) > 0){
							
							$castelists = $this->db->get_where('caste_tab',array('caste_cat'=>2))->result();
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
								if($agearray[$dd]->advage_section > 10){
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
    

	
}
