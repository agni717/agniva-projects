<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Masterdata extends Admin_Controller {
	
	public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->data["all_userlistset"] = array(25,27,151,154);
        $this->load->model('candidates_m');
    }
	
    public function index() {
		redirect('admincontrol/masterdata/recruitment_list');
    }
	
	public function recruitment_list(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->get('recruitment_master_tab')->result();
		$this->load->view('admin/masters/recruitment_for_list', $this->data);
	}
	
	public function add_master_recruitment(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('r_name', 'Recruitment Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterRecruitment_Set($r_name) == TRUE){
					$row_array = array(
						'rm_name' => trim($r_name),
						'rm_createdate' => date('Y-m-d H:i:s'),
						'rm_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Recruitment_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Recruitment Name added successfully');
						redirect('admincontrol/masterdata/recruitment_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}
			}
		}
		$this->load->view('admin/masters/new_recruitment_for_view', $this->data);
	}
	
	public function lock_recruitment_for_set($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/recruitment_list');
		}
		$row_arr = array(
			'rm_status' => 0
		);
		if($this->candidates_m->addmodify_Recruitment_Sets($row_arr, $rid) == TRUE)
		{
			$this->session->set_flashdata("success","Recruitment Name is Locked successfully");
		    redirect('admincontrol/masterdata/recruitment_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/recruitment_list','refresh');
		}
	}
	
	public function unlock_recruitment_for_set($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/recruitment_list');
		}
		$row_arr = array(
			'rm_status' => 1
		);
		if($this->candidates_m->addmodify_Recruitment_Sets($row_arr, $rid) == TRUE)
		{
			$this->session->set_flashdata("success","Recruitment Name is Unlocked successfully");
		    redirect('admincontrol/masterdata/recruitment_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/recruitment_list','refresh');
		}
	}
	
	public function edit_master_recruitment($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/recruitment_list');
		}
		if($_POST){
			$r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('r_name', 'Recruitment Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterRecruitment_Set($r_name, $rid) == TRUE){
					$row_array = array(
						'rm_name' => trim($r_name)
						/*'rm_createdate' => date('Y-m-d H:i:s'),
						'rm_createby' => $this->session->userdata('uid')*/
					);
					if($this->candidates_m->addmodify_Recruitment_Sets($row_array, $rid) == TRUE){
						$this->session->set_flashdata('success','Recruitment Name Updated successfully');
						redirect('admincontrol/masterdata/recruitment_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}
			}
		}
		$this->data['rec_detail'] = $this->db->where('rm_id',$rid)->get('recruitment_master_tab')->row();
		$this->load->view('admin/masters/edit_recruitment_for_view', $this->data);
	}
	
	
	public function caste_community_list(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		$this->data['disp_list'] = $this->candidates_m->getAll_caste_communitySet();
		$this->load->view('admin/masters/caste_community_list', $this->data);
	}
	
	public function add_master_caste_community(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$cdtl_name = $this->input->post('cdtl_name');
			$c_name = $this->input->post('c_name');
            
			$this->form_validation->set_rules('cdtl_name', 'Community Name', 'trim|required');
			$this->form_validation->set_rules('c_name', 'Caste Name', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run()) {
				//if($this->candidates_m->checkName_MasterRecruitment_Set($r_name) == TRUE){
					$row_array = array(
						'csdetail_name' => trim($cdtl_name),
						'csdetail_master' => $c_name,
						'csdetail_createdate' => date('Y-m-d H:i:s'),
						'csdetail_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_CasteCommunity_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Community is added successfully');
						redirect('admincontrol/masterdata/caste_community_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				/*}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}*/
			}
		}
		$this->data['caste_list'] = $this->db->order_by('caste_name','ASC')->where('caste_cat',2)->where('caste_parent',NULL)->where('caste_status',1)->get('caste_tab')->result();
		$this->load->view('admin/masters/new_caste_community_view', $this->data);
	}
	
	public function lock_community_for_set($cdid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($cdid == NULL){
			redirect('admincontrol/masterdata/caste_community_list');
		}
		$row_arr = array(
			'csdetail_status' => 0
		);
		if($this->candidates_m->addmodify_CasteCommunity_Sets($row_arr, $cdid) == TRUE)
		{
			$this->session->set_flashdata("success","Community Name is Locked successfully");
		    redirect('admincontrol/masterdata/caste_community_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/caste_community_list','refresh');
		}
	}
	
	public function unlock_community_for_set($cdid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($cdid == NULL){
			redirect('admincontrol/masterdata/caste_community_list');
		}
		$row_arr = array(
			'csdetail_status' => 1
		);
		if($this->candidates_m->addmodify_CasteCommunity_Sets($row_arr, $cdid) == TRUE)
		{
			$this->session->set_flashdata("success","Community Name is Unlocked successfully");
		    redirect('admincontrol/masterdata/caste_community_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/caste_community_list','refresh');
		}
	}
	
	public function edit_master_community($cdid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($cdid == NULL){
			redirect('admincontrol/masterdata/caste_community_list');
		}
		if($_POST){
			$cdtl_name = $this->input->post('cdtl_name');
			$c_name = $this->input->post('c_name');
            
			$this->form_validation->set_rules('cdtl_name', 'Community Name', 'trim|required');
			$this->form_validation->set_rules('c_name', 'Caste Name', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run()) {
				//if($this->candidates_m->checkName_MasterRecruitment_Set($r_name) == TRUE){
					$row_array = array(
						'csdetail_name' => trim($cdtl_name),
						'csdetail_master' => $c_name,
						'csdetail_modifydate' => date('Y-m-d H:i:s'),
						'csdetail_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_CasteCommunity_Sets($row_array, $cdid) == TRUE){
						$this->session->set_flashdata('success','Community Name Updated successfully');
						redirect('admincontrol/masterdata/caste_community_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				/*}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}*/
			}
		}
		$this->data['caste_list'] = $this->db->order_by('caste_name','ASC')->where('caste_cat',2)->where('caste_parent',NULL)->where('caste_status',1)->get('caste_tab')->result();
		$this->data['caste_detail'] = $this->db->where('csdetail_id',$cdid)->get('caste_details_tab')->row();
		$this->load->view('admin/masters/edit_caste_community_view', $this->data);
	}
	
	
	public function discipline_list(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		$this->data['disp_list'] = $this->candidates_m->getAll_disciplineSet();
		$this->load->view('admin/masters/discipline_list', $this->data);
	}
	
	public function add_master_discipline(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
			$r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('d_name', 'Discipline Name', 'trim|required');
			$this->form_validation->set_rules('r_name', 'Category of Post Name', 'trim|is_natural_no_zero');
			
			if($this->form_validation->run()) {
				//if($this->candidates_m->checkName_MasterRecruitment_Set($r_name) == TRUE){
					if($r_name == ''){$r_name = NULL;}
					$row_array = array(
						'catm_name' => trim($d_name),
						'catm_master' => $r_name,
						'catm_createdate' => date('Y-m-d H:i:s'),
						'catm_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Discipline_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Discipline Name added successfully');
						redirect('admincontrol/masterdata/discipline_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				/*}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}*/
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/masters/new_discipline_view', $this->data);
	}
	
	public function lock_discipline_set($did = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/discipline_list');
		}
		$row_arr = array(
			'catm_status' => 0
		);
		if($this->candidates_m->addmodify_Discipline_Sets($row_arr, $did) == TRUE)
		{
			$this->session->set_flashdata("success","Discipline Name is Locked successfully");
		    redirect('admincontrol/masterdata/discipline_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/discipline_list','refresh');
		}
	}
	
	public function unlock_discipline_set($did = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/discipline_list');
		}
		$row_arr = array(
			'catm_status' => 1
		);
		if($this->candidates_m->addmodify_Discipline_Sets($row_arr, $did) == TRUE)
		{
			$this->session->set_flashdata("success","Discipline Name is Unlocked successfully");
		    redirect('admincontrol/masterdata/discipline_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/discipline_list','refresh');
		}
	}
	
	public function edit_master_discipline($did = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/discipline_list');
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
			$r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('d_name', 'Discipline Name', 'trim|required');
			$this->form_validation->set_rules('r_name', 'Category of Post Name', 'trim|is_natural_no_zero');
			
			if($this->form_validation->run()) {
				//if($this->candidates_m->checkName_MasterRecruitment_Set($r_name) == TRUE){
					if($r_name == ''){$r_name = NULL;}
					$row_array = array(
						'catm_name' => trim($d_name),
						'catm_master' => $r_name
						//'catm_createdate' => date('Y-m-d H:i:s'),
						//'catm_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Discipline_Sets($row_array, $did) == TRUE){
						$this->session->set_flashdata('success','Discipline Name Updated successfully');
						redirect('admincontrol/masterdata/discipline_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				/*}else{
					$this->data['error'] = "Recruitment Name already exist in DB, Check Again.";
				}*/
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->data['disp_detail'] = $this->db->where('catm_id',$did)->get('category_master')->row();
		$this->load->view('admin/masters/edit_discipline_view', $this->data);
	}
	
	
	public function caste_issuing_authority_list(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		$this->data['cia_list'] = $this->db->order_by('cia_name','ASC')->get('caste_issuing_auth_tab')->result();
		$this->load->view('admin/masters/ci_authority_list', $this->data);
	}
	
	public function add_master_ci_authority(){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($_POST){
			$cia_name = $this->input->post('cia_name');
            
			$this->form_validation->set_rules('cia_name', 'Issuing Authority Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterIssuingAuthority_Set($cia_name) == TRUE){
					$row_array = array(
						'cia_name' => trim($cia_name),
						'cia_createdate' => date('Y-m-d H:i:s'),
						'cia_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_CasteIssuingAuthority_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Caste Issuing Authority is added successfully');
						redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Caste Issuing Authority Name already exist in DB, Check Again.";
				}
			}
		}
		$this->load->view('admin/masters/new_ci_authority_view', $this->data);
	}
	
	public function lock_ci_authority_set($did = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/caste_issuing_authority_list');
		}
		$row_arr = array(
			'cia_status' => 0
		);
		if($this->candidates_m->addmodify_CasteIssuingAuthority_Sets($row_arr, $did) == TRUE)
		{
			$this->session->set_flashdata("success","Caste Issuing Authority is Locked successfully");
		    redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
		}
	}
	
	public function unlock_ci_authority_set($did = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/caste_issuing_authority_list');
		}
		$row_arr = array(
			'cia_status' => 1
		);
		if($this->candidates_m->addmodify_CasteIssuingAuthority_Sets($row_arr, $did) == TRUE)
		{
			$this->session->set_flashdata("success","Caste Issuing Authority is Unlocked successfully");
		    redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
		}
	}
	
	public function edit_master_ci_authority($did = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($did == NULL){
			redirect('admincontrol/masterdata/caste_issuing_authority_list');
		}
		if($_POST){
			$cia_name = $this->input->post('cia_name');
            
			$this->form_validation->set_rules('cia_name', 'Issuing Authority Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterIssuingAuthority_Set($cia_name, $did) == TRUE){
					$row_array = array(
						'cia_name' => trim($cia_name),
						'cia_modifydate' => date('Y-m-d H:i:s'),
						'cia_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_CasteIssuingAuthority_Sets($row_array, $did) == TRUE){
						$this->session->set_flashdata('success','Caste Issuing Authority is Updated successfully');
						redirect('admincontrol/masterdata/caste_issuing_authority_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Caste Issuing Authority already exist in DB, Check Again.";
				}
			}
		}
		$this->data['cia_detail'] = $this->db->where('cia_id',$did)->get('caste_issuing_auth_tab')->row();
		$this->load->view('admin/masters/edit_ci_authority_view', $this->data);
	}
	
	
	public function examination_list(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		$this->data['rec_list'] = $this->candidates_m->getAll_ExaminationeSet();
		$this->load->view('admin/masters/examination_list', $this->data);
	}
	
	public function add_master_examination(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$ex_name = $this->input->post('ex_name');
            $r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('r_name', 'Category of Post Name', 'trim|is_natural_no_zero');
			$this->form_validation->set_rules('ex_name', 'Qualification Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterExamination_Set($ex_name) == TRUE){
					if($r_name == ''){$r_name = NULL;}
					$row_array = array(
						'qm_name' => trim($ex_name),
						'qm_r_master' => $r_name,
						'qm_createdate' => date('Y-m-d H:i:s'),
						'qm_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Examination_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Qualification Name added successfully');
						redirect('admincontrol/masterdata/examination_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Qualification Name already exist in DB, Check Again.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/masters/new_examination_view', $this->data);
	}
	
	public function lock_examination_set($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/examination_list');
		}
		$row_arr = array(
			'qm_status' => 0
		);
		if($this->candidates_m->addmodify_Examination_Sets($row_arr, $rid) == TRUE)
		{
			$this->session->set_flashdata("success","Qualification is Locked successfully");
		    redirect('admincontrol/masterdata/examination_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/examination_list','refresh');
		}
	}
	
	public function unlock_examination_set($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/examination_list');
		}
		$row_arr = array(
			'qm_status' => 1
		);
		if($this->candidates_m->addmodify_Examination_Sets($row_arr, $rid) == TRUE)
		{
			$this->session->set_flashdata("success","Qualification is Unlocked successfully");
		    redirect('admincontrol/masterdata/examination_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/examination_list','refresh');
		}
	}
	
	public function edit_master_examination($rid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($rid == NULL){
			redirect('admincontrol/masterdata/examination_list');
		}
		if($_POST){
			$ex_name = $this->input->post('ex_name');
			$r_name = $this->input->post('r_name');
            
			$this->form_validation->set_rules('r_name', 'Category of Post Name', 'trim|is_natural_no_zero');
			$this->form_validation->set_rules('ex_name', 'Qualification Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterExamination_Set($ex_name, $rid) == TRUE){
					if($r_name == ''){$r_name = NULL;}
					$row_array = array(
						'qm_name' => trim($ex_name),
						'qm_r_master' => $r_name,
						'qm_createdate' => date('Y-m-d H:i:s'),
						'qm_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Examination_Sets($row_array, $rid) == TRUE){
						$this->session->set_flashdata('success','Qualification Name Updated successfully');
						redirect('admincontrol/masterdata/examination_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Examination Name already exist in DB, Check Again.";
				}
			}
		}
		$this->data['rec_detail'] = $this->db->where('qm_id',$rid)->get('qualification_master')->row();
		$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/masters/edit_examination_view', $this->data);
	}
	
	
	public function age_relaxation_list(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		//$this->data['ages_list'] = $this->db->order_by('caste_id','DESC')->where('caste_id > 1')->get('caste_tab')->result();
		$this->data['ages_list'] = $this->db->order_by('caste_id','DESC')->where('caste_status = 1')->get('caste_tab')->result();
		$this->load->view('admin/masters/ageset_list', $this->data);
	}
	
	public function add_age_relaxation(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			$ageset_name = $this->input->post('ageset_name');
            
			$this->form_validation->set_rules('ageset_name', 'Age Relaxation Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_AgeRelaxation_Set($ageset_name) == TRUE){
					$row_array = array(
						'caste_name' => trim($ageset_name),
						'caste_cat' => 8,
						'caste_createdate' => date('Y-m-d H:i:s'),
						'caste_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_AgeRelax_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Age Relaxation Name added successfully');
						redirect('admincontrol/masterdata/age_relaxation_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Age Relaxation Name already exist in DB, Check Again.";
				}
			}
		}
		$this->load->view('admin/masters/new_ageset_view', $this->data);
	}

	public function edit_master_age_relax($aid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($aid == NULL){
			redirect('admincontrol/masterdata/age_relaxation_list');
		}
		if($_POST){
			$ageset_name = $this->input->post('ageset_name');
            
			$this->form_validation->set_rules('ageset_name', 'Age Relaxation Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_AgeRelaxation_Set($ageset_name, $aid) == TRUE){
					$row_array = array(
						'caste_name' => trim($ageset_name)
					);
					if($this->candidates_m->addmodify_AgeRelax_Sets($row_array, $aid) == TRUE){
						$this->session->set_flashdata('success','Age Relaxation Name Updated successfully');
						redirect('admincontrol/masterdata/age_relaxation_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Update in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Age Relaxation Name already exist in DB, Check Again.";
				}
			}
		}
		$this->data['age_detail'] = $this->db->where('caste_id',$aid)->get('caste_tab')->row();
		$this->load->view('admin/masters/edit_ageset_view', $this->data);
	}
	
	
	public function experience_section_list(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		$this->data['rec_list'] = $this->db->order_by('expset_id','DESC')->get('experience_master_tab')->result();
		$this->load->view('admin/masters/experience_section_list', $this->data);
	}
	
	public function add_master_experience_section(){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($_POST){
			//$e_type = $this->input->post('e_type');
            $e_name = $this->input->post('e_name');
            
			$this->form_validation->set_rules('e_name', 'Name of Experience', 'trim|required');
			//$this->form_validation->set_rules('e_type', 'Experience Type', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterExperience_Set($e_name) == TRUE){
					$row_array = array(
						'expset_name' => trim($e_name),
						//'expset_type' => $e_type,
						'expset_createdate' => date('Y-m-d H:i:s'),
						'expset_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Experience_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Experience Name is added successfully');
						redirect('admincontrol/masterdata/experience_section_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Experience Name already exist in DB, Check Again.";
				}
			}
		}
		
		$this->load->view('admin/masters/new_experience_section', $this->data);
	}

	public function edit_master_experience_section($exid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($exid == NULL){
			redirect('admincontrol/masterdata/experience_section_list');
		}
		if($_POST){
			//$e_type = $this->input->post('e_type');
            $e_name = $this->input->post('e_name');
            
			$this->form_validation->set_rules('e_name', 'Name of Experience', 'trim|required');
			//$this->form_validation->set_rules('e_type', 'Experience Type', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterExperience_Set($e_name, $exid) == TRUE){
					$row_array = array(
						'expset_name' => trim($e_name),
						//'expset_type' => $e_type,
						'expset_modifydate' => date('Y-m-d H:i:s'),
						'expset_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_Experience_Sets($row_array, $exid) == TRUE){
						$this->session->set_flashdata('success','Experience Name is Updated successfully');
						redirect('admincontrol/masterdata/experience_section_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Experience Name already exist in DB, Check Again.";
				}
			}
		}
		$this->data['exp_detail'] = $this->db->where('expset_id',$exid)->get('experience_master_tab')->row();
		$this->load->view('admin/masters/edit_experience_section', $this->data);
	}
	
	public function lock_experience_section_set($exid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($exid == NULL){
			redirect('admincontrol/masterdata/experience_section_list');
		}
		$row_arr = array(
			'expset_status' => 0
		);
		if($this->candidates_m->addmodify_Experience_Sets($row_arr, $exid) == TRUE)
		{
			$this->session->set_flashdata("success","Experience Name is Locked successfully");
		    redirect('admincontrol/masterdata/experience_section_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/experience_section_list','refresh');
		}
	}
	
	public function unlock_experience_section_set($exid = NULL){
		if($this->session->userdata['utype'] > 1){
			if(!in_array($this->session->userdata['uid'], $this->data["all_userlistset"])){
				redirect('admincontrol/dashboard');
			}
		}
		if($exid == NULL){
			redirect('admincontrol/masterdata/experience_section_list');
		}
		$row_arr = array(
			'expset_status' => 1
		);
		if($this->candidates_m->addmodify_Experience_Sets($row_arr, $exid) == TRUE)
		{
			$this->session->set_flashdata("success","Experience Name is Unlocked successfully");
		    redirect('admincontrol/masterdata/experience_section_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/experience_section_list','refresh');
		}
	}
	

	Public function block_muni_list(){
		$this->data['bm_list'] = $this->candidates_m->getAllBlock_municipality_list();
		$this->load->view('admin/masters/block_muni_list', $this->data);
	}

	Public function add_new_block_muni(){
		if($_POST){
			$d_name = $this->input->post('d_name');
            $s_name = $this->input->post('s_name');
			$bm_name = $this->input->post('bm_name');
			$bm_type = $this->input->post('bm_type');
            
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('s_name', 'Name of Sub-Division', 'trim|is_natural');
			$this->form_validation->set_rules('bm_type', 'Block/ Municipality Type', 'trim|required');
			$this->form_validation->set_rules('bm_name', 'Block/ Municipality Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($s_name == ""){$s_name = NULL;}
				if($this->candidates_m->checkName_MasterBlockMunicipality_Set($d_name, $s_name, $bm_name) == TRUE){
					
					$row_array = array(
						'district_id' => $d_name,
						'subd_id' => $s_name,
						'block_name' => $bm_name,
						'block_type' => $bm_type,
						'block_createdate' => date('Y-m-d H:i:s'),
						'block_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_BlockMuni_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Block/ Municipality is added successfully');
						redirect('admincontrol/masterdata/block_muni_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Block/ Municipality Name already exist in District, Check Again.";
				}
			}
		}
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->data['subdiv_list'] = $this->db->get_where('subdivision_tab',array('subdiv_status'=>1))->result();
		$this->load->view('admin/masters/add_block_muni', $this->data);
	}

	Public function modify_block_muni($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/block_muni_list');
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
            $s_name = $this->input->post('s_name');
			$bm_name = $this->input->post('bm_name');
			$bm_type = $this->input->post('bm_type');
            
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('s_name', 'Name of Sub-Division', 'trim|is_natural');
			$this->form_validation->set_rules('bm_type', 'Block/ Municipality Type', 'trim|required');
			$this->form_validation->set_rules('bm_name', 'Block/ Municipality Name', 'trim|required');
			
			if($this->form_validation->run()) {
				if($s_name == ""){$s_name = NULL;}
				if($this->candidates_m->checkName_MasterBlockMunicipality_Set($d_name, $s_name, $bm_name, $bmid) == TRUE){
					
					$row_array = array(
						'district_id' => $d_name,
						'subd_id' => $s_name,
						'block_name' => $bm_name,
						'block_type' => $bm_type,
						'block_modifydate' => date('Y-m-d H:i:s'),
						'block_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_BlockMuni_Sets($row_array, $bmid) == TRUE){
						$this->session->set_flashdata('success','Block/ Municipality is Updated successfully');
						redirect('admincontrol/masterdata/block_muni_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Block/ Municipality Name already exist in District, Check Again.";
				}
			}
		}
		$this->data['bm_detail'] = $this->db->get_where('block_master',array('block_id'=>$bmid))->row();
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->data['subdiv_list'] = $this->db->get_where('subdivision_tab',array('subdiv_status'=>1))->result();
		$this->load->view('admin/masters/modify_block_muni', $this->data);
	}
	
	public function lock_block_muni($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/block_muni_list');
		}
		$row_arr = array(
			'block_status' => 0
		);
		if($this->candidates_m->addmodify_BlockMuni_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Block/ Municipality is Locked successfully");
		    redirect('admincontrol/masterdata/block_muni_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/block_muni_list','refresh');
		}
	}
	
	public function unlock_block_muni($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/block_muni_list');
		}
		$row_arr = array(
			'block_status' => 1
		);
		if($this->candidates_m->addmodify_BlockMuni_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Block/ Municipality is Unlocked successfully");
		    redirect('admincontrol/masterdata/block_muni_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/block_muni_list','refresh');
		}
	}
	

	Public function subdivision_list(){
		$this->data['sdiv_list'] = $this->candidates_m->getAll_SubDivision_list();
		$this->load->view('admin/masters/subdiv_list', $this->data);
	}
	
	Public function add_new_subdivision(){
		if($_POST){
			$d_name = $this->input->post('d_name');
            $s_name = $this->input->post('s_name');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('s_name', 'Name of Sub-Division', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterSubDiv_Set($d_name, $s_name) == TRUE){
					
					$row_array = array(
						'subdiv_district' => $d_name,
						'subdiv_name' => $s_name,
						'subdiv_createdate' => date('Y-m-d H:i:s'),
						'subdiv_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_SubDiv_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Sub-Division is added successfully');
						redirect('admincontrol/masterdata/subdivision_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Sub-Division Name already exist in District, Check Again.";
				}
			}
		}
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/add_subdiv', $this->data);
	}

	Public function modify_subdivision($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/subdivision_list');
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
            $s_name = $this->input->post('s_name');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('s_name', 'Name of Sub-Division', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterSubDiv_Set($d_name, $s_name, $bmid) == TRUE){
					
					$row_array = array(
						'subdiv_district' => $d_name,
						'subdiv_name' => $s_name,
						'subdiv_createdate' => date('Y-m-d H:i:s'),
						'subdiv_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_SubDiv_Sets($row_array, $bmid) == TRUE){
						$this->session->set_flashdata('success','Sub-Division is Updated successfully');
						redirect('admincontrol/masterdata/subdivision_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Sub-Division Name already exist in District, Check Again.";
				}
			}
		}
		$this->data['s_detail'] = $this->db->get_where('subdivision_tab',array('subdiv_id'=>$bmid))->row();
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/modify_subdiv', $this->data);
	}
	
	public function lock_subdivision($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/subdivision_list');
		}
		$row_arr = array(
			'subdiv_status' => 0
		);
		if($this->candidates_m->addmodify_SubDiv_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Sub-Division is Locked successfully");
		    redirect('admincontrol/masterdata/subdivision_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/subdivision_list','refresh');
		}
	}
	
	public function unlock_subdivision($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/subdivision_list');
		}
		$row_arr = array(
			'subdiv_status' => 1
		);
		if($this->candidates_m->addmodify_SubDiv_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Sub-Division is Unlocked successfully");
		    redirect('admincontrol/masterdata/subdivision_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/subdivision_list','refresh');
		}
	}

	
	Public function policestation_list(){
		$this->data['sdiv_list'] = $this->candidates_m->getAll_PoliceStation_list();
		$this->load->view('admin/masters/ps_list', $this->data);
	}
	
	Public function add_new_policestation(){
		if($_POST){
			$d_name = $this->input->post('d_name');
            $p_name = $this->input->post('p_name');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('p_name', 'Name of Police Station', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterPoliceStation_Set($d_name, $p_name) == TRUE){
					
					$row_array = array(
						'ps_dist_master' => $d_name,
						'ps_name' => $p_name,
						'ps_createdate' => date('Y-m-d H:i:s'),
						'ps_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_PoliceStation_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','Police Station is added successfully');
						redirect('admincontrol/masterdata/policestation_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Police Station Name already exist in District, Check Again.";
				}

			}
		}
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/add_ps', $this->data);
	}

	Public function modify_policestation($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/policestation_list');
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
            $p_name = $this->input->post('p_name');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			$this->form_validation->set_rules('p_name', 'Name of Police Station', 'trim|required');
			
			if($this->form_validation->run()) {
				if($this->candidates_m->checkName_MasterPoliceStation_Set($d_name, $p_name, $bmid) == TRUE){
					
					$row_array = array(
						'ps_dist_master' => $d_name,
						'ps_name' => $p_name,
						'ps_modifydate' => date('Y-m-d H:i:s'),
						'ps_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_PoliceStation_Sets($row_array, $bmid) == TRUE){
						$this->session->set_flashdata('success','Police Station is Updated successfully');
						redirect('admincontrol/masterdata/policestation_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Police Station Name already exist in District, Check Again.";
				}

			}
		}
		$this->data['ps_detail'] = $this->db->get_where('police_station_tab',array('ps_id'=>$bmid))->row();
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/modify_ps', $this->data);
	}

	public function lock_policestation($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/policestation_list');
		}
		$row_arr = array(
			'ps_status' => 0
		);
		if($this->candidates_m->addmodify_PoliceStation_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Police Station is Locked successfully");
		    redirect('admincontrol/masterdata/policestation_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/policestation_list','refresh');
		}
	}
	
	public function unlock_policestation($bmid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($bmid == NULL){
			redirect('admincontrol/masterdata/policestation_list');
		}
		$row_arr = array(
			'ps_status' => 1
		);
		if($this->candidates_m->addmodify_PoliceStation_Sets($row_arr, $bmid) == TRUE)
		{
			$this->session->set_flashdata("success","Police Station is Unlocked successfully");
		    redirect('admincontrol/masterdata/policestation_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/policestation_list','refresh');
		}
	}
	
	
	public function venue_list(){
		$this->data['vdiv_list'] = $this->candidates_m->getAll_Venue_list();
		$this->load->view('admin/masters/venue_list', $this->data);
	}
	
	public function add_new_venueset(){
		if($_POST){
			$d_name = $this->input->post('d_name');
            $v_name = $this->input->post('v_name');
			//$t_no = $this->input->post('t_no');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			//$this->form_validation->set_rules('t_no', 'No. of Table', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('v_name', 'Address of Venue', 'trim|required');
			
			if($this->form_validation->run()) {
				$row_array = array(
					'address_district' => $d_name,
					'address_name' => $v_name,
					//'address_tableno' => $t_no,
					'address_createdate' => date('Y-m-d H:i:s'),
					'address_createby' => $this->session->userdata('uid')
				);
				if($this->candidates_m->addmodify_VenueAddress_Sets($row_array) == TRUE){
					$this->session->set_flashdata('success','Venue is added successfully');
					redirect('admincontrol/masterdata/venue_list','refresh');
				}else{
					$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
				}
			}
		}
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/add_new_venue', $this->data);
	}
	
	Public function modify_venueset($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/policestation_list');
		}
		if($_POST){
			$d_name = $this->input->post('d_name');
            $v_name = $this->input->post('v_name');
			//$t_no = $this->input->post('t_no');
			
			$this->form_validation->set_rules('d_name', 'Name of District', 'trim|required|is_natural');
			//$this->form_validation->set_rules('t_no', 'No. of Table', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('v_name', 'Address of Venue', 'trim|required');
			
			if($this->form_validation->run()) {
					
				$row_array = array(
					'address_district' => $d_name,
					'address_name' => $v_name,
					//'address_tableno' => $t_no,
					'address_modifydate' => date('Y-m-d H:i:s'),
					'address_modifyby' => $this->session->userdata('uid')
				);
				if($this->candidates_m->addmodify_VenueAddress_Sets($row_array, $vnid) == TRUE){
					$this->session->set_flashdata('success','Venue is Updated successfully');
					redirect('admincontrol/masterdata/venue_list','refresh');
				}else{
					$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
				}

			}
		}
		$this->data['vn_detail'] = $this->db->get_where('address_tab',array('address_id'=>$vnid))->row();
		$this->data['dist_list'] = $this->db->get_where('district_master',array('district_status'=>1))->result();
		$this->load->view('admin/masters/modify_venue', $this->data);
	}

	public function lock_venueset($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/venue_list');
		}
		$row_arr = array(
			'address_status' => 0
		);
		if($this->candidates_m->addmodify_VenueAddress_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Venue is Locked successfully");
		    redirect('admincontrol/masterdata/venue_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/venue_list','refresh');
		}
	}

	public function unlock_venueset($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/venue_list');
		}
		$row_arr = array(
			'address_status' => 1
		);
		if($this->candidates_m->addmodify_VenueAddress_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Venue is Unlocked successfully");
		    redirect('admincontrol/masterdata/venue_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/venue_list','refresh');
		}
	}

	
	public function interviewrules_list(){
		$this->data['rule_list'] = $this->db->order_by('rm_id DESC')->get('rules_master')->result();
		$this->load->view('admin/masters/rules_list', $this->data);
	}
	
	public function add_new_rules(){
		if($_POST){
			$rule_name = $this->input->post('rule_name');
            $rule_order = $this->input->post('rule_order');
			
			$this->form_validation->set_rules('rule_name', 'Rule Details', 'trim|required');
			$this->form_validation->set_rules('rule_order', 'Rule order', 'trim|required|is_natural');
			
			if($this->form_validation->run()) {
				$row_array = array(
					'rm_details' => $rule_name,
					'rm_order' => $rule_order,
					'rm_createdate' => date('Y-m-d H:i:s'),
					'rm_create_by' => $this->session->userdata('uid')
				);
				if($this->candidates_m->addmodify_InterviewRules_Sets($row_array) == TRUE){
					$this->session->set_flashdata('success','Rule is added successfully');
					redirect('admincontrol/masterdata/interviewrules_list','refresh');
				}else{
					$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
				}
			}
		}
		
		$this->load->view('admin/masters/add_new_rule', $this->data);
	}

	public function lock_interviewrules($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/interviewrules_list');
		}
		$row_arr = array(
			'rm_status' => 0
		);
		if($this->candidates_m->addmodify_InterviewRules_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Rule is Locked successfully");
		    redirect('admincontrol/masterdata/interviewrules_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/interviewrules_list','refresh');
		}
	}

	public function unlock_interviewrules($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/interviewrules_list');
		}
		$row_arr = array(
			'rm_status' => 1
		);
		if($this->candidates_m->addmodify_InterviewRules_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Rule is Unlocked successfully");
		    redirect('admincontrol/masterdata/interviewrules_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/interviewrules_list','refresh');
		}
	}

	public function modify_interviewrule($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/interviewrules_list');
		}
		if($_POST){
			$rule_name = $this->input->post('rule_name');
            $rule_order = $this->input->post('rule_order');
			
			$this->form_validation->set_rules('rule_name', 'Rule Details', 'trim|required');
			$this->form_validation->set_rules('rule_order', 'Rule order', 'trim|required|is_natural');
			
			if($this->form_validation->run()) {
					
				$row_array = array(
					'rm_details' => $rule_name,
					'rm_order' => $rule_order,
					'rm_modifydate' => date('Y-m-d H:i:s'),
					'rm_modify_by' => $this->session->userdata('uid')
				);
				if($this->candidates_m->addmodify_InterviewRules_Sets($row_array, $vnid) == TRUE){
					$this->session->set_flashdata('success','Rule is Updated successfully');
					redirect('admincontrol/masterdata/interviewrules_list','refresh');
				}else{
					$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
				}

			}
		}
		$this->data['rule_detail'] = $this->db->get_where('rules_master',array('rm_id'=>$vnid))->row();
		$this->load->view('admin/masters/modify_rule', $this->data);
	}

	
	public function all_shift_list(){
		$this->data['sft_list'] = $this->candidates_m->getAll_Shift_list();
		$this->load->view('admin/masters/shift_list', $this->data);
	}
	
	Public function add_new_shift(){
		if($_POST){
			$venueno = $this->input->post('venueno');
            $sf_name = $this->input->post('sf_name');
			$u_startdate = $this->input->post('u_startdate');
			$t_no = $this->input->post('t_no');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			
			$this->form_validation->set_rules('venueno', 'Name of Venue', 'trim|required|is_natural|is_natural_no_zero');
			$this->form_validation->set_rules('sf_name', 'Name of Shift', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Date of Shift', 'trim|required');
			$this->form_validation->set_rules('t_no', 'Shift Total Table', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_starttime', 'Shift Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'Shift End Time', 'trim|required');
			
			if($this->form_validation->run()) {
				//if($this->candidates_m->checkName_MasterPoliceStation_Set($d_name, $p_name) == TRUE){
					
					$row_array = array(
						'shift_venue' => $venueno,
						'shift_name' => $sf_name,
						'shift_date' => date('Y-m-d',strtotime($u_startdate)),
						'shift_start_time' => date('H:i:s',strtotime($u_starttime)),
						'shift_end_time' => date('H:i:s',strtotime($u_endtime)),
						'shift_table_no' => $t_no,
						'shift_createdate' => date('Y-m-d H:i:s'),
						'shift_createby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_ShiftMaster_Sets($row_array) == TRUE){
						$this->session->set_flashdata('success','New Shift is added successfully');
						redirect('admincontrol/masterdata/all_shift_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				/*}else{
					$this->data['error'] = "Police Station Name already exist in District, Check Again.";
				}*/

			}
		}
		$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
		$this->load->view('admin/masters/add_new_shift', $this->data);
	}

	public function lock_shift($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/all_shift_list');
		}
		$row_arr = array(
			'shift_status' => 0
		);
		if($this->candidates_m->addmodify_ShiftMaster_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Shift is Locked successfully");
		    redirect('admincontrol/masterdata/all_shift_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/all_shift_list','refresh');
		}
	}

	public function unlock_shift($vnid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($vnid == NULL){
			redirect('admincontrol/masterdata/all_shift_list');
		}
		$row_arr = array(
			'shift_status' => 1
		);
		if($this->candidates_m->addmodify_ShiftMaster_Sets($row_arr, $vnid) == TRUE)
		{
			$this->session->set_flashdata("success","Shift is Unlocked successfully");
		    redirect('admincontrol/masterdata/all_shift_list','refresh');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/masterdata/all_shift_list','refresh');
		}
	}
	/*public function delete_fuser3454354534534534534577($uid = NULL){
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
	}*/

	Public function modify_shift($sfid = NULL){
		if($this->session->userdata['utype'] > 1){
			redirect('admincontrol/dashboard');
		}
		if($sfid == NULL){
			redirect('admincontrol/masterdata/all_shift_list');
		}
		if($_POST){
			//$venueno = $this->input->post('venueno');
            $sf_name = $this->input->post('sf_name');
			//$u_startdate = $this->input->post('u_startdate');
			$t_no = $this->input->post('t_no');
			//$u_starttime = $this->input->post('u_starttime');
			//$u_endtime = $this->input->post('u_endtime');
			
			//$this->form_validation->set_rules('venueno', 'Name of Venue', 'trim|required|is_natural');
			$this->form_validation->set_rules('sf_name', 'Name of Shift', 'trim|required');
			//$this->form_validation->set_rules('u_startdate', 'Date of Shift', 'trim|required');
			$this->form_validation->set_rules('t_no', 'Shift Total Table', 'trim|required|is_natural_no_zero');
			//$this->form_validation->set_rules('u_starttime', 'Shift Start Time', 'trim|required');
			//$this->form_validation->set_rules('u_endtime', 'Shift End Time', 'trim|required');
			
			if($this->form_validation->run()) {

				$sf_item = $this->db->where('shift_id',$sfid)->get('shift_master_tab')->row();
				if($t_no >= $sf_item->shift_table_no){
					
					$row_array = array(
						//'shift_venue' => $venueno,
						'shift_name' => $sf_name,
						//'shift_date' => date('Y-m-d',strtotime($u_startdate)),
						//'shift_start_time' => date('H:i:s',strtotime($u_starttime)),
						//'shift_end_time' => date('H:i:s',strtotime($u_endtime)),
						'shift_table_no' => $t_no,
						'shift_modifydate' => date('Y-m-d H:i:s'),
						'shift_modifyby' => $this->session->userdata('uid')
					);
					if($this->candidates_m->addmodify_ShiftMaster_Sets($row_array, $sfid) == TRUE){
						$this->session->set_flashdata('success','New Shift is added successfully');
						redirect('admincontrol/masterdata/all_shift_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data['error'] = "Total Table no. Always greater than Current Table No. Check Again.";
				}

			}
		}
		$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
		$this->data['sf_detail'] = $this->db->where('shift_id',$sfid)->get('shift_master_tab')->row();
		$this->load->view('admin/masters/modify_shift', $this->data);
	}
	
	
}
