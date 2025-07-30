<?php

class Candidates_m extends MY_Model {

    function __construct() {
        parent::__construct();
    }

	public function GetDetailsofCandidate_Application_v2($appli_id = NULL, $adv_no = NULL){
		if($appli_id != NULL){
			$this->db->select('f_user_views.*, advertisement_master.*, recruitment_master_tab.rm_name, district_master.district_name, state_master.state_name, caste_tab.caste_name');
			$this->db->from('f_user_views');
			$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
			$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
			$this->db->join('state_master','state_master.state_id = f_user_views.fu_state','LEFT');
			//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
			$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
			$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		}else{
			$this->db->select('f_user_views.f_application_no, f_user_views.f_full_name, f_user_views.f_email, f_user_views.f_mobile');
			$this->db->from('f_user_views');
			$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		}
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		}
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
			$query = $this->db->get();
			return $query->row();
		}else{
			/*if($this->session->userdata['utype'] != 1){
				$this->db->limit(1);
				$query = $this->db->get();
				return $query->row();
			}else{*/
				$this->db->order_by('f_user_views.f_full_name','ASC');
				$query = $this->db->get();
				return $query->result();
			//}
		}
	}

    public function GetDetailsofCandidate_Application($appli_id = NULL, $adv_no = NULL){
		if($appli_id != NULL){
			$this->db->select('f_user_views.*, advertisement_master.*, recruitment_master_tab.rm_name, district_master.district_name, state_master.state_name, caste_tab.caste_name');
		}else{
			$this->db->select('f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name, district_master.district_name, state_master.state_name, caste_tab.caste_name');
		}
		$this->db->from('f_user_views');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		$this->db->join('state_master','state_master.state_id = f_user_views.fu_state','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		}
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
			$query = $this->db->get();
			return $query->row();
		}else{
			/*if($this->session->userdata['utype'] != 1){
				$this->db->limit(1);
				$query = $this->db->get();
				return $query->row();
			}else{*/
				$this->db->order_by('f_user_views.fu_final_createdate','DESC');
				$query = $this->db->get();
				return $query->result();
			//}
		}
	}

	public function GetOptimizeCandidate_Application($adv_no = NULL){
		$this->db->select('f_user_views.f_application_no, f_user_views.fu_caste_type, f_user_views.fu_pwd, f_user_views.fu_exempted, f_user_views.fu_exservice, f_user_views.fu_ews, f_user_views.fu_has_service, f_user_views.f_applied_for');
		$this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		//$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function GetDetail_Discipline_for_Application($catid){
		$this->db->select('advertisement_categoty.*, category_master.catm_name');
		$this->db->from('advertisement_categoty');
		$this->db->join('f_user_views','f_user_views.fu_category = advertisement_categoty.acat_id');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('f_user_views.fu_category', $catid);
		$query = $this->db->get();
		return $query->row();
	}	
	
	public function GetDetail_Qualification_for_Application($appli_id = NULL){
		$this->db->select('f_user_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_qualification');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_qualification.fu_quali_masteruser');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_qualification.fu_qualifiaction_name');
		$this->db->join('state_master','state_master.state_id = f_user_qualification.fu_state_of_passing','LEFT');
		$this->db->where('f_user_views.f_application_no', $appli_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetail_DesireQualification_for_Application($appli_id = NULL){
		$this->db->select('f_user_des_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_des_qualification');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_des_qualification.fud_quali_masteruser');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_des_qualification.fud_qualifiaction_name');
		$this->db->join('state_master','state_master.state_id = f_user_des_qualification.fud_state_of_passing','LEFT');
		$this->db->where('f_user_views.f_application_no', $appli_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetail_Experience_for_Application($appli_id = NULL){
		$this->db->select('f_user_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_experience');
		$this->db->join('experience_master_tab', 'experience_master_tab.expset_id = f_user_experience.fu_exp_workname');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_experience.fu_exp_masteruser');
		$this->db->where('f_user_views.f_application_no', $appli_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetail_Essn_Experience_for_Application($appli_id = NULL){
		$this->db->select('f_user_ess_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_ess_experience');
		$this->db->join('experience_master_tab', 'experience_master_tab.expset_id = f_user_ess_experience.fues_exp_workname');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_ess_experience.fues_exp_masteruser');
		$this->db->where('f_user_views.f_application_no', $appli_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_caste_communitySet(){
		$this->db->select('caste_details_tab.*, caste_tab.caste_name');
		$this->db->from('caste_details_tab');
		$this->db->join('caste_tab','caste_tab.caste_id = caste_details_tab.csdetail_master');
		$this->db->where('caste_tab.caste_cat', 2);
		$this->db->order_by('caste_details_tab.csdetail_name','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function addmodify_CasteCommunity_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('csdetail_id', $cdid);
			if($this->db->update("caste_details_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("caste_details_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function GetDetailsofCandidate_Skip_Application($adv_no = NULL, $uaccess = NULL, $acc_id = NULL, $adv_post = NULL){
		$this->db->select('f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_state','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		if($acc_id != NULL){
			$this->db->where('checking_tab.chk_sub_typeid', $acc_id);
		}
		$this->db->where('checking_tab.chk_approve', 'Skip');
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$this->db->order_by('checking_tab.chk_appro_date ASC'); //checking_tab.chk_id ASC
		$query = $this->db->get();
		return $query->result();
		
	}

	public function checkName_MasterIssuingAuthority_Set($cianame, $cdid = NULL){
		$this->db->select('*');
		$this->db->from('caste_issuing_auth_tab');
		$this->db->where('cia_name', $cianame);
		if($cdid != NULL)
        	$this->db->where('cia_id != ', $cdid);
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}
	
	public function addmodify_CasteIssuingAuthority_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('cia_id', $cdid);
			if($this->db->update("caste_issuing_auth_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("caste_issuing_auth_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function GetDetailsofCandidate_Return_Application($adv_no = NULL, $uaccess = NULL, $acc_id = NULL, $adv_post = NULL){
		$this->db->select('f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_state','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		if($acc_id != NULL){
			$this->db->where('checking_tab.chk_sub_typeid', $acc_id);
		}
		$this->db->where('checking_tab.chk2_approve', 'Return');
		$this->db->where('checking_tab.chk_final_state', 'Return');
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$this->db->order_by('checking_tab.chk_id','ASC');
		$query = $this->db->get();
		return $query->result();
		
	}

	public function getAll_disciplineSet(){
		$this->db->select('category_master.*, recruitment_master_tab.rm_name');
		$this->db->from('category_master');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = category_master.catm_master','LEFT');
		//$this->db->where('f_user_views.f_application_no', $appli_id);
		$this->db->order_by('category_master.catm_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAll_ExaminationeSet(){
		$this->db->select('qualification_master.*, recruitment_master_tab.rm_name');
		$this->db->from('qualification_master');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = qualification_master.qm_r_master','LEFT');
		//$this->db->where('f_user_views.f_application_no', $appli_id);
		$this->db->order_by('qualification_master.qm_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function addmodify_Discipline_Sets($rows, $did = NULL){
		$this->db->set($rows);
		if($did != NULL){
			$this->db->where('catm_id', $did);
			if($this->db->update("category_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("category_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function checkName_MasterRecruitment_Set($rname, $rid = NULL){
		$this->db->select('*');
		$this->db->from('recruitment_master_tab');
		$this->db->where('rm_name', $rname);
		if($rid != NULL)
        	$this->db->where('rm_id != ', $rid);
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}
	
	public function addmodify_Recruitment_Sets($rows, $rid = NULL){
		$this->db->set($rows);
		if($rid != NULL){
			$this->db->where('rm_id', $rid);
			if($this->db->update("recruitment_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("recruitment_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function checkName_MasterExamination_Set($rname, $rid = NULL){
		$this->db->select('*');
		$this->db->from('qualification_master');
		$this->db->where('qm_name', $rname);
		if($rid != NULL)
        	$this->db->where('qm_id != ', $rid);
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function checkName_AgeRelaxation_Set($rname, $rid = NULL){
		$this->db->select('*');
		$this->db->from('caste_tab');
		$this->db->where('caste_name', $rname);
		if($rid != NULL)
        	$this->db->where('caste_id != ', $rid);
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function addmodify_AgeRelax_Sets($rows, $did = NULL){
		$this->db->set($rows);
		if($did != NULL){
			$this->db->where('caste_id', $did);
			if($this->db->update("caste_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("caste_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function addmodify_Examination_Sets($rows, $did = NULL){
		$this->db->set($rows);
		if($did != NULL){
			$this->db->where('qm_id', $did);
			if($this->db->update("qualification_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("qualification_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function addmodify_Experience_Sets($rows, $exid = NULL){
		$this->db->set($rows);
		if($exid != NULL){
			$this->db->where('expset_id', $exid);
			if($this->db->update("experience_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("experience_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function getAll_PoliceStation_list(){
		$this->db->select('police_station_tab.*, district_master.district_name');
		$this->db->from('police_station_tab');
		$this->db->join('district_master','district_master.district_code = police_station_tab.ps_dist_master');
		$this->db->order_by('police_station_tab.ps_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function checkName_MasterPoliceStation_Set($d_name, $p_name, $bmid = NULL){
		$this->db->select('police_station_tab.*');
		$this->db->from('police_station_tab');
		$this->db->join('district_master','district_master.district_code = police_station_tab.ps_dist_master');
		$this->db->where('district_master.district_code', $d_name);
		$this->db->where('police_station_tab.ps_name', $p_name);
		if($bmid != NULL){
			$this->db->where('police_station_tab.ps_id != ', $bmid);
		}	
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function addmodify_PoliceStation_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('ps_id', $cdid);
			if($this->db->update("police_station_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("police_station_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function getAllUser_WorkingonAdvertisement($advno = NULL, $ss_datetime = NULL, $ee_datetime = NULL){
		$this->db->select("checking_tab.chk_createby as chk_user");
		$this->db->distinct();
		$this->db->from("checking_tab");
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		if($advno != NULL){
			$this->db->where("frontend_users.f_applied_for",$advno);
		}
		if($ss_datetime != NULL && $ee_datetime != NULL){
			$this->db->where("(checking_tab.chk_appro_date >= '".$ss_datetime."' AND checking_tab.chk_appro_date <= '".$ee_datetime."')");
		}
		$this->db->where("checking_tab.chk_createby !=", NULL);
		$query1 = $this->db->get_compiled_select(); // It resets the query just like a get()

		$this->db->select("checking_tab.chk2_appro_by as chk_user");
		$this->db->distinct();
		$this->db->from("checking_tab");
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		if($advno != NULL){
			$this->db->where("frontend_users.f_applied_for",$advno);
		}
		if($ss_datetime != NULL && $ee_datetime != NULL){
			$this->db->where("(checking_tab.chk2_appro_date >= '".$ss_datetime."' AND checking_tab.chk2_appro_date <= '".$ee_datetime."')");
		}
		$this->db->where("checking_tab.chk2_appro_by !=", NULL);
		$query2 = $this->db->get_compiled_select(); 

		$query = $this->db->query("SELECT * from user_views where u_id IN (".$query1." UNION ".$query2.") ORDER BY u_type ASC, firstname ASC");
		//$query = $this->db->query($query1." UNION ".$query2);

		return $query->result();
	}

	public function getAll_SubDivision_list(){
		$this->db->select('subdivision_tab.*, district_master.district_name');
		$this->db->from('subdivision_tab');
		$this->db->join('district_master','district_master.district_code = subdivision_tab.subdiv_district');
		$this->db->order_by('subdivision_tab.subdiv_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function checkName_MasterSubDiv_Set($d_name, $s_name, $bmid = NULL){
		$this->db->select('subdivision_tab.*');
		$this->db->from('subdivision_tab');
		$this->db->join('district_master','district_master.district_code = subdivision_tab.subdiv_district');
		$this->db->where('district_master.district_code', $d_name);
		$this->db->where('subdivision_tab.subdiv_name', $s_name);
		if($bmid != NULL){
			$this->db->where('subdivision_tab.subdiv_id != ', $bmid);
		}	
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function addmodify_SubDiv_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('subdiv_id', $cdid);
			if($this->db->update("subdivision_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("subdivision_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function getAllBlock_municipality_list(){
		$this->db->select('block_master.*, district_master.district_name, subdivision_tab.subdiv_name');
		$this->db->from('block_master');
		$this->db->join('district_master','district_master.district_code = block_master.district_id');
		$this->db->join('subdivision_tab','subdivision_tab.subdiv_id = block_master.subd_id','LEFT');
		$this->db->order_by('block_master.block_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function checkName_MasterBlockMunicipality_Set($d_name, $s_name = NULL, $bm_name, $bmid = NULL){
		$this->db->select('block_master.*');
		$this->db->from('block_master');
		$this->db->join('district_master','district_master.district_code = block_master.district_id');
		$this->db->join('subdivision_tab','subdivision_tab.subdiv_id = block_master.subd_id','LEFT');
		$this->db->where('district_master.district_code', $d_name);
		if($s_name != NULL){
			$this->db->where('subdivision_tab.subdiv_id', $s_name);
		}
		$this->db->where('block_master.block_name', $bm_name);
		if($bmid != NULL){
			$this->db->where('block_master.block_id != ', $bmid);
		}	
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function addmodify_BlockMuni_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('block_id', $cdid);
			if($this->db->update("block_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("block_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function checkName_MasterExperience_Set($e_name, $exid = NULL){
		$this->db->select('*');
		$this->db->from('experience_master_tab');
		$this->db->where('expset_name', $e_name);
		//$this->db->where('expset_type', $etype);
		if($exid != NULL)
        	$this->db->where('expset_id != ', $exid);
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}
	
	public function GetDetails_Userwise_Candidate_Application_withNotNULL($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}
		}
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		//$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
			if($uaccess == 'fu_caste'){
				$this->db->where('f_user_views.fu_caste_type != ', 1);
			}elseif($uaccess == 'fu_pwd'){
				$this->db->where('f_user_views.fu_pwd', 'Yes');
			}elseif($uaccess == 'fu_exempted'){
				$this->db->where('f_user_views.fu_exempted', 'Yes');
			}elseif($uaccess == 'fu_exservice'){
				$this->db->where('f_user_views.fu_exservice', 'Yes');
			}elseif($uaccess == 'fu_ews'){
				$this->db->where('f_user_views.fu_ews', 'Yes');
			}elseif($uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('f_user_views.fu_has_service', 'Yes');
			}
		}
		$this->db->where('checking_tab.chk_approve != ', NULL);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}
	
	public function GetDetailsofSub_type_By_Access($advno, $uaccess, $acc_id){
		if($uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification'){
			$this->db->select('qualification_master.qm_name as typeset_name');
			$this->db->from('advertisement_master');
			$this->db->join('advertisement_qualification','advertisement_qualification.aquali_adv_master = advertisement_master.adv_auto_genno');
			$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
			$this->db->where('advertisement_qualification.aquali_exam', $acc_id);
		}elseif($uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
			$this->db->select('experience_master_tab.expset_name as typeset_name');
			$this->db->from('advertisement_master');
			$this->db->join('advertisement_experience','advertisement_experience.aexpr_adv_master = advertisement_master.adv_auto_genno');
			$this->db->join('experience_master_tab','experience_master_tab.expset_id = advertisement_experience.aexpr_name');
			$this->db->where('advertisement_experience.aexpr_name', $acc_id);
		}elseif($uaccess == 'fu_age_relax'){
			$this->db->select('caste_tab.caste_name as typeset_name');
			$this->db->from('advertisement_master');
			$this->db->join('advertisement_age_set','advertisement_age_set.advage_adv_master = advertisement_master.adv_auto_genno');
			$this->db->join('caste_tab','caste_tab.caste_id = advertisement_age_set.advage_section');
			$this->db->where('advertisement_age_set.advage_section', $acc_id);
		}
		$this->db->where('advertisement_master.adv_auto_genno', $advno);
		$query = $this->db->get();
		return $query->row();
	}

	public function GetDetails_Userwise_Candidate_Application_withSKIP($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $acc_id);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
			}
		}
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		//$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
			if($uaccess == 'fu_caste'){
				$this->db->where('f_user_views.fu_caste_type != ', 1);
			}elseif($uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('f_user_views.fu_has_service', 'Yes');
			}
		}
		$this->db->where('checking_tab.chk_approve', 'Skip');
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetDetails_Userwise_Candidate_Application_withReturn($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $acc_id);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
			}
		}
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		//$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		$this->db->where('checking_tab.chk_final_state', 'Return');
		$this->db->where('checking_tab.chk2_approve', 'Return');
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetDetails_Userwise_Candidate_Application_withESQE($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('f_user_views.*');
		$this->db->from('f_user_views');
		if($acc_id != NULL){
			if($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}
		}
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($uaccess != NULL){
			if($uaccess == 'fu_has_ds_service'){
				$this->db->where('f_user_views.fu_has_service', 'Yes');
			}
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}
	
	public function checkAlready_Exist_ForOtherChecker($appli_id = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $acc_id);
			}
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		$query->free_result();
	}

	public function GetDetails_ExactCheckerfor_Application_withNULL($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}
		}
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
			if($uaccess == 'fu_caste'){
				$this->db->where('f_user_views.fu_caste_type != ', 1);
			}elseif($uaccess == 'fu_pwd'){
				$this->db->where('f_user_views.fu_pwd', 'Yes');
			}elseif($uaccess == 'fu_exempted'){
				$this->db->where('f_user_views.fu_exempted', 'Yes');
			}elseif($uaccess == 'fu_exservice'){
				$this->db->where('f_user_views.fu_exservice', 'Yes');
			}elseif($uaccess == 'fu_ews'){
				$this->db->where('f_user_views.fu_ews', 'Yes');
			}elseif($uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('f_user_views.fu_has_service', 'Yes');
			}
		}
		$this->db->where('checking_tab.chk_approve', NULL);
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetExactCheckerfor_Application_withNULL($adv_no, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('f_user_views.f_application_no,checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_age_relax' || $uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $acc_id);
			}
		}
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		$this->db->where('checking_tab.chk_approve', NULL);
		$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$query = $this->db->get();
		return $query->row();
	}

	public function GetNewCheckerfor_NewApplication_withNULL($adv_no, $uaccess = NULL, $acc_id = NULL, $utypes = NULL, $adv_post = NULL){
		
		//$this->db->select('f_user_views.f_application_no,'.$uaccess.',NULL,NULL,NULL,NOW(),'.$this->session->userdata['uid'].','.$utypes.',');
		$this->db->select('f_user_views.*');
		$this->db->from('f_user_views');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $acc_id);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
			}
		}
		if($uaccess == "fu_caste"){
			$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type');
			$this->db->where('f_user_views.fu_caste_type > ', 1);
			$this->db->where('caste_tab.caste_cat', 2);
		}elseif($uaccess == "fu_pwd"){
			$this->db->where('f_user_views.fu_pwd', "Yes");
		}elseif($uaccess == "fu_exempted"){
			$this->db->where('f_user_views.fu_exempted', "Yes");
		}elseif($uaccess == "fu_exservice"){
			$this->db->where('f_user_views.fu_exservice', "Yes");
		}elseif($uaccess == "fu_ews"){
			$this->db->where('f_user_views.fu_ews', "Yes");
		}elseif($uaccess == 'fu_has_es_service'){
			$this->db->where('f_user_views.fu_has_service', 'Yes');
		}elseif($uaccess == 'fu_has_ds_service'){
			$this->db->where('f_user_views.fu_has_service', 'Yes');
		}
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		if($acc_id != NULL){
			$this->db->where('f_user_views.f_application_no NOT IN (SELECT checking_tab.chk_user_application from checking_tab,frontend_users where checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = "'.$adv_no.'" AND checking_tab.chk_type = "'.$uaccess.'" and checking_tab.chk_sub_typeid = '.$acc_id.')', NULL, FALSE);
		}else{
			$this->db->where('f_user_views.f_application_no NOT IN (SELECT checking_tab.chk_user_application from checking_tab,frontend_users where checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = "'.$adv_no.'" AND checking_tab.chk_type = "'.$uaccess.'")', NULL, FALSE);
		}
		//$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$this->db->order_by('rand()');
		$this->db->limit(1, 0);
		$query = $this->db->get();
		//print_r($this->db->last_query());
		//exit;
		if ($query->num_rows() > 0) {
			//$insert = $this->db->insert('california_authors', $select->result_array());
            $isdata = $query->row();
			$rowarray = array(
				'chk_user_application' => $isdata->f_application_no,
				'chk_type' => $uaccess,
				'chk_create_by_type' => $utypes,
				'chk_createby' => $this->session->userdata['uid'],
				'chk_createdate' => date('Y-m-d H:i:s')
			);
			if($acc_id != NULL){
				$rowarray['chk_sub_typeid'] = $acc_id;
			}else{
				$rowarray['chk_sub_typeid'] = 0;
			}
			$this->db->set($rowarray);
            if($this->db->insert("checking_tab", $rowarray)){
				return $isdata;
			}else{
				return FALSE;
			}
        } else {
            return FALSE;
        }
		//return $query->row();		
	}

	public function GetDetails_Cheker2ExactCheckerfor_Application($appli_id = NULL, $uaccess = NULL, $acc_id = NULL, $userid = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		if($acc_id != NULL){
			if($uaccess == 'fu_age_relax' || $uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $acc_id);
			}
		}
		$this->db->where('checking_tab.chk2_approve', NULL);
		if($userid != NULL){
			$this->db->where('checking_tab.chk2_appro_by', $userid);
		}else{
			$this->db->where('checking_tab.chk2_appro_by', NULL);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetDetails_Userwise_Candidate_Application_withNULL($appli_id = NULL, $utype = NULL, $uaccess = NULL, $acc_id = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($acc_id != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $acc_id);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $acc_id);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $acc_id);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
			}
		}
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('district_master','district_master.district_id = f_user_views.fu_district','LEFT');
		//$this->db->join('state_master','state_master.state_id = f_user_views.fu_domicile_state','LEFT');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		//$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
			if($uaccess == 'fu_caste'){
				$this->db->where('f_user_views.fu_caste_type != ', 1);
			}elseif($uaccess == 'fu_pwd'){
				$this->db->where('f_user_views.fu_pwd', 'Yes');
			}elseif($uaccess == 'fu_exempted'){
				$this->db->where('f_user_views.fu_exempted', 'Yes');
			}elseif($uaccess == 'fu_exservice'){
				$this->db->where('f_user_views.fu_exservice', 'Yes');
			}elseif($uaccess == 'fu_ews'){
				$this->db->where('f_user_views.fu_ews', 'Yes');
			}elseif($uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('f_user_views.fu_has_service', 'Yes');
			}
		}
		$this->db->where('checking_tab.chk_approve', NULL);
		//$this->db->where('checking_tab.chk_createby', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}
	
	public function GetAll_OtherCheckerComments($appli_id, $accesstype, $access_id = NULL){
		$this->db->select('checking_tab.*,master_user_type.mu_name, user_info.firstname, user_info.lastname');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('master_user_type','master_user_type.mu_id = checking_tab.chk_create_by_type');
		$this->db->join('user_info','user_info.u_id = checking_tab.chk_createby');
		$this->db->where('checking_tab.chk_user_application', $appli_id);
		$this->db->where('checking_tab.chk_type', $accesstype);
		if($access_id != NULL){
			$this->db->where('checking_tab.chk_sub_typeid != ', $access_id);
		}
		$this->db->order_by('checking_tab.chk_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getprev_checker_details($appli_id, $accesstype, $access_id = NULL, $userid = NULL){
		$this->db->select('checking_tab.*,master_user_type.mu_name, user_info.firstname, user_info.lastname, user_info.mobile, user_info.email');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('master_user_type','master_user_type.mu_id = checking_tab.chk_create_by_type');
		$this->db->join('user_info','user_info.u_id = checking_tab.chk_createby');
		$this->db->where('checking_tab.chk_user_application', $appli_id);
		$this->db->where('checking_tab.chk_type', $accesstype);
		if($access_id != NULL){
			$this->db->where('checking_tab.chk_sub_typeid', $access_id);
		}
		if($userid != NULL){
			$this->db->where('checking_tab.chk_createby', $userid);
		}
		$query = $this->db->get();
		return $query->row();
	}

	public function getdouble_prev_checkerdetails($appli_id, $accesstype, $access_id = NULL, $userid = NULL){
		$this->db->select('checker_log.*,master_user_type.mu_name, user_info.firstname, user_info.lastname, user_info.mobile, user_info.email');
		$this->db->from('checker_log');
		$this->db->join('f_user_views','f_user_views.f_application_no = checker_log.chklog_app_no');
		$this->db->join('user_info','user_info.u_id = checker_log.chklog_user');
		$this->db->join('master_user_type','master_user_type.mu_id = user_info.u_type');
		$this->db->where('checker_log.chklog_app_no', $appli_id);
		$this->db->where('checker_log.chklog_type', $accesstype);
		if($access_id != NULL){
			$this->db->where('checker_log.chklog_type_id', $access_id);
		}
		if($userid != NULL){
			$this->db->where('checker_log.chklog_user', $userid);
		}
		$this->db->order_by('checker_log.chklog_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getcurrent_checker_details($appli_id, $accesstype, $access_id = NULL, $userid = NULL){
		$this->db->select('checking_tab.*,master_user_type.mu_name, user_info.firstname, user_info.lastname, user_info.mobile, user_info.email');
		$this->db->from('checking_tab');
		//$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('user_info','user_info.u_id = checking_tab.chk2_appro_by');
		$this->db->join('master_user_type','master_user_type.mu_id = user_info.u_type');
		$this->db->where('checking_tab.chk_user_application', $appli_id);
		$this->db->where('checking_tab.chk_type', $accesstype);
		if($access_id != NULL){
			$this->db->where('checking_tab.chk_sub_typeid', $access_id);
		}
		if($userid != NULL){
			$this->db->where('checking_tab.chk2_appro_by', $userid);
		}
		$query = $this->db->get();
		return $query->row();
	}

	public function getprev_checker2_details($appli_id, $accesstype){
		$this->db->select('checking_tab.*,master_user_type.mu_name, user_info.firstname, user_info.lastname');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('user_info','user_info.u_id = checking_tab.chk2_appro_by');
		$this->db->join('master_user_type','master_user_type.mu_id = user_info.u_type');
		$this->db->where('checking_tab.chk_user_application', $appli_id);
		$this->db->where('checking_tab.chk_type', $accesstype);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_adminChecker_user_log($rows) {
        $this->db->set($rows);
        $this->db->insert('checker_log',$rows);
    }

	public function addmodify_CheckTab_Sets($rows, $cid = NULL, $appno = NULL, $accessarea = NULL, $accessid = NULL, $finalapprove_arr = NULL){
		$this->db->set($rows);
		if($cid != NULL){
			$this->db->where('chk_id', $cid);
			if($this->db->update("checking_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}elseif($appno != NULL && $accessarea != NULL){
			$this->db->trans_start();
			$this->db->set($rows);
			$this->db->where('chk_user_application', $appno);
			$this->db->where('chk_type', $accessarea);
			if($accessid != NULL){
				$this->db->where('chk_sub_typeid', $accessid);
			}
			$this->db->update("checking_tab", $rows);
			
			if($finalapprove_arr != NULL){
				//$this->db->set($finalapprove_arr);
				//$this->db->where('cr_application_master', $appno);
				//$this->db->update("candidate_result_tab", $finalapprove_arr);
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === TRUE) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("checking_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function getDetails_SlaveUser_Advertisement_Wise($advno){
		$this->db->select('user_views.*');
		$this->db->from('user_views');
		$this->db->where('user_views.u_adv_access like "%'.$advno.'%"');
		$this->db->where_in('user_views.u_type',array(2,4));
		$this->db->order_by('user_views.u_type ASC, user_views.firstname ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetailsof_Approve_Candidate_Application($stat, $adv_no, $uaccess, $slaveuserid = NULL, $accessid = NULL, $adv_post = NULL){
		$this->db->select('checking_tab.*, f_user_views.f_application_no');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		if($accessid != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $accessid);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		$this->db->where('checking_tab.chk_approve', $stat);
		$this->db->where('checking_tab.chk_final_state', $stat);
		$this->db->where('checking_tab.chk2_approve', NULL);
		
		//$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		$this->db->where('checking_tab.chk_type', $uaccess);
		//$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		//$this->db->where_in('checking_tab.chk_type', $uaccess);
		if($slaveuserid != NULL){
			$this->db->where('checking_tab.chk_createby', $slaveuserid);
		}
		/*if($uaccess == 'fu_caste'){
			$this->db->where('candidate_result_tab.fu_caste_check', NULL);
		}elseif($uaccess == 'fu_pwd'){
			$this->db->where('candidate_result_tab.fu_pwd_check', NULL);
		}elseif($uaccess == 'fu_exempted'){
			$this->db->where('candidate_result_tab.fu_exempted_check', NULL);
		}elseif($uaccess == 'fu_exservice'){
			$this->db->where('candidate_result_tab.fu_exservice_check', NULL);
		}elseif($uaccess == 'fu_ews'){
			$this->db->where('candidate_result_tab.fu_ews_check', NULL);*/

		/*}elseif($uaccess == 'fu_es_qualification'){
			$this->db->where('candidate_result_tab.fu_es_qualification_check', NULL);
		}elseif($uaccess == 'fu_ds_qualification'){
			$this->db->where('candidate_result_tab.fu_ds_qualification_check', NULL);
		}elseif($uaccess == 'fu_has_es_service'){
			$this->db->where('candidate_result_tab.fu_es_service_check', NULL);
		}elseif($uaccess == 'fu_has_ds_service'){
			$this->db->where('candidate_result_tab.fu_ds_service_check', NULL);*/

		/*}elseif($uaccess == 'fu_address'){
			$this->db->where('candidate_result_tab.fu_address_check', NULL);
		}elseif($uaccess == 'fu_photo_doc'){
			$this->db->where('candidate_result_tab.fu_photo_check', NULL);
		}elseif($uaccess == 'fu_signature_doc'){
			$this->db->where('candidate_result_tab.fu_signature_check', NULL);
		}elseif($uaccess == 'fu_dob'){
			$this->db->where('candidate_result_tab.fu_dob_check', NULL);
		}*/
		$this->db->order_by('checking_tab.chk_id','ASC');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	public function GetDetailsof_Approve_Candidate_Application_withSkip($stat, $adv_no, $uaccess, $slaveuserid = NULL, $accessid = NULL, $adv_post = NULL){
		$this->db->select('checking_tab.*, f_user_views.f_application_no');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		if($accessid != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $accessid);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		$this->db->where('checking_tab.chk_approve', $stat);
		$this->db->where('checking_tab.chk2_approve', 'Skip');
		$this->db->where('checking_tab.chk_final_state', 'Skip');
		
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		//$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		$this->db->where('checking_tab.chk_type', $uaccess);
		$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		if($slaveuserid != NULL){
			$this->db->where('checking_tab.chk_createby', $slaveuserid);
		}
		//$this->db->where_in('checking_tab.chk_type', $uaccess);
		/*if($uaccess == 'fu_caste'){
			$this->db->where('candidate_result_tab.fu_caste_check', NULL);
		}elseif($uaccess == 'fu_pwd'){
			$this->db->where('candidate_result_tab.fu_pwd_check', NULL);
		}elseif($uaccess == 'fu_exempted'){
			$this->db->where('candidate_result_tab.fu_exempted_check', NULL);
		}elseif($uaccess == 'fu_exservice'){
			$this->db->where('candidate_result_tab.fu_exservice_check', NULL);
		}elseif($uaccess == 'fu_ews'){
			$this->db->where('candidate_result_tab.fu_ews_check', NULL);*/

		/*}elseif($uaccess == 'fu_es_qualification'){
			$this->db->where('candidate_result_tab.fu_es_qualification_check', NULL);
		}elseif($uaccess == 'fu_ds_qualification'){
			$this->db->where('candidate_result_tab.fu_ds_qualification_check', NULL);
		}elseif($uaccess == 'fu_has_es_service'){
			$this->db->where('candidate_result_tab.fu_es_service_check', NULL);
		}elseif($uaccess == 'fu_has_ds_service'){
			$this->db->where('candidate_result_tab.fu_ds_service_check', NULL);*/
		
		/*}elseif($uaccess == 'fu_address'){
			$this->db->where('candidate_result_tab.fu_address_check', NULL);
		}elseif($uaccess == 'fu_photo_doc'){
			$this->db->where('candidate_result_tab.fu_photo_check', NULL);
		}elseif($uaccess == 'fu_signature_doc'){
			$this->db->where('candidate_result_tab.fu_signature_check', NULL);
		}elseif($uaccess == 'fu_dob'){
			$this->db->where('candidate_result_tab.fu_dob_check', NULL);
		}*/
		$this->db->order_by('checking_tab.chk2_appro_date','ASC'); //chk_id
		$query = $this->db->get();
		return $query->result();
		
	}

	public function GetDetailsof_Approve_Candidate_Application_withReturn($stat, $adv_no, $uaccess, $slaveuserid = NULL, $accessid = NULL, $adv_post = NULL){
		$this->db->select('checking_tab.*, f_user_views.f_application_no');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		//$this->db->join('caste_tab','caste_tab.caste_id = f_user_views.fu_caste_type','LEFT');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		if($accessid != NULL){
			if($uaccess == 'fu_es_qualification'){
				$this->db->join('f_user_qualification','f_user_qualification.fu_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_qualification.fu_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_ds_qualification'){
				$this->db->join('f_user_des_qualification','f_user_des_qualification.fud_quali_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_es_service'){
				$this->db->join('f_user_ess_experience','f_user_ess_experience.fues_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_ess_experience.fues_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_has_ds_service'){
				$this->db->join('f_user_experience','f_user_experience.fu_exp_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_experience.fu_exp_workname', $accessid);
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}elseif($uaccess == 'fu_age_relax'){
				$this->db->join('f_user_extraage','f_user_extraage.fu_ext_masteruser = f_user_views.f_uid');
				$this->db->where('f_user_extraage.fu_ext_ageid', $accessid);
				$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		$this->db->where('checking_tab.chk_approve', $stat);
		$this->db->where('checking_tab.chk2_approve', 'Return');
		$this->db->where('checking_tab.chk_final_state != "Return"');
		if($slaveuserid != NULL){
			$this->db->where('checking_tab.chk_createby', $slaveuserid);
		}
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		//$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		if($adv_post != NULL){
			$this->db->where('f_user_views.fu_category', $adv_post);
		}
		$this->db->where('checking_tab.chk_type', $uaccess);
		$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		//$this->db->where_in('checking_tab.chk_type', $uaccess);

		/*if($uaccess == 'fu_caste'){
			$this->db->where('candidate_result_tab.fu_caste_check', NULL);
		}elseif($uaccess == 'fu_pwd'){
			$this->db->where('candidate_result_tab.fu_pwd_check', NULL);
		}elseif($uaccess == 'fu_exempted'){
			$this->db->where('candidate_result_tab.fu_exempted_check', NULL);
		}elseif($uaccess == 'fu_exservice'){
			$this->db->where('candidate_result_tab.fu_exservice_check', NULL);
		}elseif($uaccess == 'fu_ews'){
			$this->db->where('candidate_result_tab.fu_ews_check', NULL);*/

		/*}elseif($uaccess == 'fu_es_qualification'){
			$this->db->where('candidate_result_tab.fu_es_qualification_check', NULL);
		}elseif($uaccess == 'fu_ds_qualification'){
			$this->db->where('candidate_result_tab.fu_ds_qualification_check', NULL);
		}elseif($uaccess == 'fu_has_es_service'){
			$this->db->where('candidate_result_tab.fu_es_service_check', NULL);
		}elseif($uaccess == 'fu_has_ds_service'){
			$this->db->where('candidate_result_tab.fu_ds_service_check', NULL);*/

		/*}elseif($uaccess == 'fu_address'){
			$this->db->where('candidate_result_tab.fu_address_check', NULL);
		}elseif($uaccess == 'fu_photo_doc'){
			$this->db->where('candidate_result_tab.fu_photo_check', NULL);
		}elseif($uaccess == 'fu_signature_doc'){
			$this->db->where('candidate_result_tab.fu_signature_check', NULL);
		}elseif($uaccess == 'fu_dob'){
			$this->db->where('candidate_result_tab.fu_dob_check', NULL);
		}*/
		$this->db->order_by('checking_tab.chk_id','ASC');
		$query = $this->db->get();
		return $query->result();
		
	}

	public function GetDetails_Userwise_CHK2_Candidate_Application_withNULL($appli_id = NULL, $uaccess = NULL, $accessid = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($accessid != NULL){
			if($uaccess == 'fu_age_relax' || $uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		/*if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}*/
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		$this->db->where('checking_tab.chk_approve != ', NULL);
		$this->db->where('checking_tab.chk2_approve', NULL);
		$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetDetails_Userwise_CHK2_Candidate_Application_withSKIP($appli_id = NULL, $uaccess = NULL, $accessid = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($accessid != NULL){
			if($uaccess == 'fu_age_relax' || $uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		/*if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}*/
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		$this->db->where('checking_tab.chk_approve != ', NULL);
		$this->db->where('checking_tab.chk2_approve', 'Skip');
		$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function GetDetails_Userwise_CHK2_Candidate_Application_withRETURN($appli_id = NULL, $uaccess = NULL, $accessid = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		if($appli_id != NULL){
			$this->db->where('f_user_views.f_application_no', $appli_id);
		}
		if($accessid != NULL){
			if($uaccess == 'fu_age_relax' || $uaccess == 'fu_es_qualification' || $uaccess == 'fu_ds_qualification' || $uaccess == 'fu_has_es_service' || $uaccess == 'fu_has_ds_service'){
				$this->db->where('checking_tab.chk_sub_typeid', $accessid);
			}
		}
		/*if($utype != NULL){
			$this->db->where('checking_tab.chk_create_by_type', $utype);
		}*/
		if($uaccess != NULL){
			$this->db->where('checking_tab.chk_type', $uaccess);
		}
		$this->db->where('checking_tab.chk_approve != ', NULL);
		$this->db->where('checking_tab.chk2_approve', 'Return');
		$this->db->where('checking_tab.chk_final_state != ', 'Return');
		$this->db->where('checking_tab.chk2_appro_by', $this->session->userdata['uid']);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}
	
	public function GetDetailsof_Approvae_Candidate_Application($rf_set = NULL, $advno = NULL, $existregno = NULL){
		$this->db->distinct('checking_tab.chk_user_application');
		$this->db->select('checking_tab.chk_user_application');
		$this->db->select('f_user_views.f_full_name');
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		//$this->db->where('(checking_tab.chk_final_state IS NOT NULL OR checking_tab.chk_final_state != "Rejected" OR checking_tab.chk_final_state != "Doubtful")');
		$this->db->where('checking_tab.chk_user_application NOT IN (select distinct(chk_user_application) from checking_tab where chk_final_state != "Approved")',NULL, FALSE);
		if($existregno != NULL){
			$this->db->where_not_in('checking_tab.chk_user_application', $existregno);
		}
		if($rf_set != NULL){
			$this->db->where('advertisement_master.adv_recruit_master', $rf_set);
		}
		if($advno != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $advno);
		}
		$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getExisting_AdmitcardCandidate_Application($rf_set = NULL, $advno = NULL){
		$this->db->select('candidate_result_tab.cr_application_master');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('candidate_result_tab.cr_admitcard_issued', 1);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		if($rf_set != NULL){
			$this->db->where('advertisement_master.adv_recruit_master', $rf_set);
		}
		if($advno != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $advno);
		}
		$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_CompleteExam_Candidate_Application($rf_set = NULL, $advno = NULL){
		$this->db->select('candidate_result_tab.*, f_user_views.*');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('candidate_result_tab.cr_admitcard_issued', 1);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		if($rf_set != NULL){
			$this->db->where('advertisement_master.adv_recruit_master', $rf_set);
		}
		if($advno != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $advno);
		}
		$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function setUpdate_ResultCandidate_Appliwise($rows, $appid = NULL){
		$this->db->set($rows);
		$this->db->where('cr_application_master', $appid);
		if($this->db->update("candidate_result_tab", $rows)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getDetails_of_SectionWise_Commondata_forFinalCheck($application_no, $accessarea){
		$this->db->select('*');
		$this->db->from('checking_tab');
		$this->db->where('chk_user_application', $application_no);
		$this->db->where('chk_type', $accessarea);
		$this->db->where('((chk2_approve = "Approved" AND chk_final_state = "Approved") OR (chk2_approve = "Rejected" AND chk_final_state = "Rejected"))');
		//$this->db->where_in('chk2_approve', array('Approved','Rejected'));
		//$this->db->where_in('chk_final_state', array('Approved','Rejected'));
		$query = $this->db->get();
		return $query->row();
	}

	public function getDetails_of_SpecialSectionWisedata_forFinalCheck($application_no, $accessarea){
		$this->db->select('*');
		$this->db->from('checking_tab');
		$this->db->where('chk_user_application', $application_no);
		$this->db->where('chk_type', $accessarea);
		$this->db->where('((chk2_approve = "Approved" AND chk_final_state = "Approved") OR (chk2_approve = "Rejected" AND chk_final_state = "Rejected"))');
		//$this->db->where_in('chk2_approve', array('Approved','Rejected'));
		//$this->db->where_in('chk_final_state', array('Approved','Rejected'));
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getTotal_AdmitGeneration_against_Advertisement($advno = NULL){
		$this->db->select('candidate_result_tab.cr_application_master');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->where('candidate_result_tab.cr_admitcard_issued', 1);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		if($advno != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $advno);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getExisting_AdmitcardCandidate_List($rf_set = NULL, $advno = NULL){
		$this->db->select('candidate_result_tab.*,f_user_views.f_full_name');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('candidate_result_tab.cr_admitcard_issued', 1);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		if($rf_set != NULL){
			$this->db->where('advertisement_master.adv_recruit_master', $rf_set);
		}
		if($advno != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $advno);
		}
		$this->db->order_by('candidate_result_tab.cr_admitcard_date','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function addmodify_ExperienceSets_ByChecker($rows, $cdid, $ctype){
		$this->db->set($rows);
		if($ctype == "E"){
			$this->db->where('fues_exp_id', $cdid);
			if($this->db->update("f_user_ess_experience", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}elseif($ctype == "D"){
			$this->db->where('fu_exp_id', $cdid);
			if($this->db->update("f_user_experience", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function addmodify_ExamSets_ByChecker($rows, $cdid, $ctype){
		$this->db->set($rows);
		if($ctype == "E"){
			$this->db->where('fu_quali_id', $cdid);
			if($this->db->update("f_user_qualification", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}elseif($ctype == "D"){
			$this->db->where('fud_quali_id', $cdid);
			if($this->db->update("f_user_des_qualification", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	public function addmodify_EmailDocReplace_ByChecker($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('udm_id', $cdid);
			if($this->db->update("updatedoc_mail_log", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("updatedoc_mail_log", $rows)){
				$emailset_id = $this->db->insert_id();
				return $emailset_id;
			}else{
				return FALSE;
			}
		}
	}

	public function docModification_TimeFieldCheck($rowarray){
		$curenttime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->from('updatedoc_mail_log');
		$this->db->where('udm_id', $rowarray[5]);
		$this->db->where('udm_cand_advno', $rowarray[1]);
		$this->db->where('udm_cand_regno', $rowarray[2]);
		$this->db->where('udm_doctype', $rowarray[3]);
		$this->db->where('udm_doc_id', $rowarray[4]);
		$this->db->where('udm_s_datetime <= "'.$curenttime.'"');
		$this->db->where('udm_e_datetime >= "'.$curenttime.'"');
		$this->db->where('udm_status', 1);
		$query = $this->db->get();
		return $query->row();
	}

	public function docModification_AlreadyUpload_Check($rowarray){
		$curenttime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->from('updatedoc_mail_log');
		$this->db->where('udm_id', $rowarray[5]);
		$this->db->where('udm_cand_advno', $rowarray[1]);
		$this->db->where('udm_cand_regno', $rowarray[2]);
		$this->db->where('udm_doctype', $rowarray[3]);
		$this->db->where('udm_doc_id', $rowarray[4]);
		$this->db->where('udm_s_datetime <= "'.$curenttime.'"');
		$this->db->where('udm_e_datetime >= "'.$curenttime.'"');
		$this->db->where('udm_new_docname != ""');
		$this->db->where('udm_status', 2);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_EssenQualification_fromDB($rows_id) {
        $this->db->select('f_user_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_qualification.fu_qualifiaction_name');
        $this->db->join('state_master','state_master.state_id = f_user_qualification.fu_state_of_passing');
        $this->db->where('f_user_qualification.fu_quali_id', $rows_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function get_DesireQualification_fromDB($rows_id) {
        $this->db->select('f_user_des_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_des_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_des_qualification.fud_qualifiaction_name');
        $this->db->join('state_master','state_master.state_id = f_user_des_qualification.fud_state_of_passing');
        $this->db->where('f_user_des_qualification.fud_quali_id', $rows_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function get_EssenExperience_fromDB($rows_id) {
        $this->db->select('f_user_ess_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_ess_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_ess_experience.fues_exp_workname');
        $this->db->where('f_user_ess_experience.fues_exp_id', $rows_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function get_DesireExperience_fromDB($rows_id) {
        $this->db->select('f_user_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_experience.fu_exp_workname');
        $this->db->where('f_user_experience.fu_exp_id', $rows_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function get_EssenAgeRelax_fromDB($rows_id) {
        $this->db->select('f_user_extraage.*, caste_tab.caste_name');
		$this->db->from('f_user_extraage');
		$this->db->join('caste_tab','caste_tab.caste_id = f_user_extraage.fu_ext_ageid');
        $this->db->where('f_user_extraage.fu_ext_id', $rows_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function update_frontuser_details_modified($now, $id = NULL) {
        $this->db->set($now);
        $this->db->where('fu_master', $id);
        if($this->db->update('f_user_details', $now)){
			return TRUE;
        }else{
            return FALSE;
		}
    }

	public function update_Tablewise_Docdetails_modified($row, $tabname, $rowid, $cand_id){
		$this->db->set($row);
		if($tabname == "f_user_qualification"){
			$this->db->where('fu_quali_id', $rowid);
			$this->db->where('fu_quali_masteruser', $cand_id);
		}elseif($tabname == "f_user_des_qualification"){
			$this->db->where('fud_quali_id', $rowid);
			$this->db->where('fud_quali_masteruser', $cand_id);
		}elseif($tabname == "f_user_ess_experience"){
			$this->db->where('fues_exp_id', $rowid);
			$this->db->where('fues_exp_masteruser', $cand_id);
		}elseif($tabname == "f_user_experience"){
			$this->db->where('fu_exp_id', $rowid);
			$this->db->where('fu_exp_masteruser', $cand_id);
		}elseif($tabname == "f_user_extraage"){
			$this->db->where('fu_ext_id', $rowid);
			$this->db->where('fu_ext_masteruser', $cand_id);
		}
		if($this->db->update($tabname, $row)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getDetails_Qualification_Advertisement_Wise($type, $advno){
		$this->db->select('advertisement_qualification.*,qualification_master.qm_name');
		$this->db->from('advertisement_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
		$this->db->where('advertisement_qualification.aquali_examtype', $type);
		$this->db->where('advertisement_qualification.aquali_adv_master', $advno);
		$this->db->order_by('advertisement_qualification.aquali_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function gatAll_Special_subscriptionAge_list($advno){
        $this->db->select('advertisement_age_set.*,caste_tab.caste_name, caste_tab.caste_cat');
        $this->db->from('advertisement_age_set');
        $this->db->join('caste_tab', 'caste_tab.caste_id = advertisement_age_set.advage_section');
		$this->db->where('advertisement_age_set.advage_section >', 10);
        $this->db->where('advertisement_age_set.advage_adv_master', $advno);
        $this->db->order_by("advertisement_age_set.advage_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

	public function getAll_Spcl_ExtraAgeSets_forCandidate($cand_no, $ysechk = NULL){
        $this->db->select('f_user_extraage.*,caste_tab.caste_name');
        $this->db->from('f_user_extraage');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_extraage.fu_ext_masteruser');
        $this->db->join('caste_tab', 'caste_tab.caste_id = f_user_extraage.fu_ext_ageid');
        $this->db->where('f_user_views.f_application_no', $cand_no);
		if($ysechk != NULL){
			$this->db->where('f_user_extraage.fu_ext_answer', $ysechk);
		}
        $this->db->order_by("f_user_extraage.fu_ext_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

	public function getDetails_Experience_Advertisement_Wise($type, $advno){
		$this->db->select('advertisement_experience.*, experience_master_tab.expset_name');
		$this->db->from('advertisement_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = advertisement_experience.aexpr_name');
		$this->db->where('advertisement_experience.aexpr_type', $type);
		$this->db->where('advertisement_experience.aexpr_adv_master', $advno);
		$this->db->order_by('advertisement_experience.aexpr_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_AllDocument_bySendMail_fromDB($candidate_ref, $doctype, $docid){
		$this->db->select('updatedoc_mail_log.*');
		$this->db->from('updatedoc_mail_log');
		$this->db->where('udm_cand_regno', $candidate_ref);
		$this->db->where('udm_doctype', $doctype);
		$this->db->where('udm_doc_id', $docid);
		$this->db->where('udm_status', 2);
		$this->db->order_by('udm_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetailsofCandidateApplication_forAPICALL($adv_no){
		$this->db->select('f_user_views.f_uid,f_user_views.f_application_no,f_user_views.f_mobile,f_user_views.f_full_name,f_user_views.f_email');
		$this->db->from('f_user_views');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('candidate_result_tab.cr_approval', 'NotChecked');
		$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		//$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();
	
	}
	
	public function getCheck_AllDocument_fromDB($candidate_ref){
		$this->db->select('candidate_result_tab.*');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->where('f_user_views.f_application_no', $candidate_ref);
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('candidate_result_tab.fu_dob_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_address_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_photo_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_signature_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_caste_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_pwd_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_exempted_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_exservice_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_ews_check != ', NULL);
		$this->db->where('candidate_result_tab.fu_age_relax_check', 'Yes');
		$this->db->where('candidate_result_tab.fu_es_qualification_check', 'Yes');
		$this->db->where('candidate_result_tab.fu_es_service_check', 'Yes');
		$this->db->where('candidate_result_tab.fu_ds_qualification_check', 'Yes');
		$this->db->where('candidate_result_tab.fu_ds_service_check', 'Yes');
        $query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		$query->free_result();
	}

	public function getDetailsof_Es_Experience_ofCandidate_Application($candidate_refno){
		$this->db->distinct('f_user_ess_experience.fues_exp_workname as eserv_name');
		$this->db->from('f_user_ess_experience');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_ess_experience.fues_exp_masteruser');
		$this->db->where('f_user_views.f_application_no', $candidate_refno);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getDetailsof_De_Experience_ofCandidate_Application($candidate_refno){
		$this->db->distinct('f_user_experience.fu_exp_workname as dserv_name');
		$this->db->from('f_user_experience');
		$this->db->join('f_user_views','f_user_views.f_uid = f_user_experience.fu_exp_masteruser');
		$this->db->where('f_user_views.f_application_no', $candidate_refno);
		$query = $this->db->get();
		return $query->result();
	}

	public function sectionmodify_subExperience_Sets($rows, $expid, $typeset){
		$this->db->set($rows);
		if($typeset == "ES"){
			$this->db->where('fues_exp_id', $expid);
			if($this->db->update("f_user_ess_experience", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}elseif($typeset == "DS"){
			$this->db->where('fu_exp_id', $expid);
			if($this->db->update("f_user_experience", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
	}

	public function getAll_Venue_list(){
		$this->db->select('address_tab.*, district_master.district_name');
		$this->db->from('address_tab');
		$this->db->join('district_master','district_master.district_code = address_tab.address_district');
		$this->db->order_by('address_tab.address_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function addmodify_VenueAddress_Sets($rows, $addid = NULL){
		$this->db->set($rows);
		if($addid != NULL){
			$this->db->where('address_id', $addid);
			if($this->db->update("address_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("address_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function addmodify_InterviewRules_Sets($rows, $addid = NULL){
		$this->db->set($rows);
		if($addid != NULL){
			$this->db->where('rm_id', $addid);
			if($this->db->update("rules_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("rules_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function checkCandidate_forInterview_sectionset($advno, $category = NULL){
		$this->db->select('candidate_result_tab.*');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->where('f_user_views.f_applied_for',$advno);
		if($category != NULL){
			$this->db->where('f_user_views.fu_category',$category);
		}
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		$this->db->where('f_user_views.f_application_no NOT IN (SELECT interview_tab.invw_cand_regno from interview_tab,frontend_users where interview_tab.invw_cand_regno = frontend_users.f_application_no and interview_tab.invw_status = 1 and frontend_users.f_applied_for = "'.$advno.'")', NULL, FALSE);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function check_Existing_CategoryAdv_asperAUTOGEN_inDB($adv_no, $cat_name, $autogenid){
		$this->db->select('*');
		$this->db->from('intv_data_manipulate');
		$this->db->where('idm_adv_no', $adv_no);
		$this->db->where('idm_autogen_code', $autogenid);
		$this->db->where('idm_adv_category', $cat_name);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function addupdate_tempInterview_category_inDB($rows, $genid = NULL) {
        $this->db->set($rows);
		if($genid != NULL){
			$this->db->where('idm_autogen_code', $genid);
			if($this->db->update('intv_data_manipulate', $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert('intv_data_manipulate', $rows)){
				$q_id = $this->db->insert_id();
				return $q_id;
			}else{
				return FALSE;
			}
		}
    }

	public function addupdate_FinalInterview_categorywise_inDB($rows, $intvid = NULL) {
        $this->db->set($rows);
		if($intvid != NULL){
			$this->db->where('invw_id', $intvid);
			if($this->db->update('interview_tab', $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert('interview_tab', $rows)){
				//$q_id = $this->db->insert_id();
				return TRUE;
			}else{
				return FALSE;
			}
		}
    }

	public function getDetails_ADV_Category_forInterview($intv_no){
		$this->db->select('intv_data_manipulate.*, advertisement_categoty.*, category_master.catm_name');
		$this->db->from('intv_data_manipulate');
		$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('intv_data_manipulate.idm_id', $intv_no);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAllResult_ofIndividual_POSTS_ofADV($advno, $adv_temp_intvno){
		$this->db->select('intv_data_manipulate.*, advertisement_categoty.*, category_master.catm_name');
		$this->db->from('intv_data_manipulate');
		$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('intv_data_manipulate.idm_adv_no', $advno);
		$this->db->where('intv_data_manipulate.idm_autogen_code', $adv_temp_intvno);
		$this->db->where('intv_data_manipulate.idm_status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function getAll_interview_Segrigation_search_candidate($total_stenth, $advno, $category, $cand_main, $cand_sec, $cand_sec_no){
		$this->db->select('candidate_result_tab.*, (sum(candidate_result_tab.cr_academic) + sum(candidate_result_tab.cr_experience)) as t_marks');
		$this->db->from('candidate_result_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = candidate_result_tab.cr_application_master');
		$this->db->where('f_user_views.f_applied_for',$advno);
		$this->db->where('f_user_views.fu_category',$category);
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		if($cand_main == "EC"){
			$this->db->where('f_user_views.fu_court_ref_no is NULL');
		}elseif($cand_main == "IC"){
			$this->db->where('(f_user_views.fu_court_ref_no is not NULL AND f_user_views.fu_court_ref_no != "")');
		}
		if($cand_sec == "MM"){
			$this->db->where('t_marks >= ',$cand_sec_no);
		}
		$this->db->where('f_user_views.f_application_no NOT IN (SELECT interview_tab.invw_cand_regno from interview_tab,frontend_users where interview_tab.invw_cand_regno = frontend_users.f_application_no and interview_tab.invw_status = 1 and frontend_users.f_applied_for = "'.$advno.'")', NULL, FALSE);
		$this->db->group_by('candidate_result_tab.cr_application_master');
		$this->db->order_by('f_user_views.fu_dob DESC, f_user_views.f_full_name ASC');
		if($cand_sec == "MV"){
			$this->db->limit($cand_sec_no, 0);
		}else{
			$this->db->limit($total_stenth, 0);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function getAll_Table_detaillist_of_Interview_Avvertisement($advno, $venueno, $ss_datetime, $ee_datetime){
		$this->db->select('interview_tab.*,frontend_users.*');
		$this->db->from('interview_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = interview_tab.invw_cand_regno');
		$this->db->where('f_user_views.f_applied_for',$advno);
		$this->db->where('interview_tab.invw_venuemaster',$venueno);
		$this->db->where("(interview_tab.invw_shift_starttime == '".$ss_datetime."' AND interview_tab.invw_shift_endtime == '".$ee_datetime."')");
		
		$query = $this->db->get();
		return $query->result();
	}

	public function addmodify_Qualification_modifymail_ByChecker($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('udq_id', $cdid);
			if($this->db->update("updatequali_log", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("updatequali_log", $rows)){
				$qualiset_id = $this->db->insert_id();
				return $qualiset_id;
			}else{
				return FALSE;
			}
		}
	}

	public function qualifcationModification_TimeFieldCheck($rowarray){
		$curenttime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->from('updatequali_log');
		$this->db->where('udq_id', $rowarray[5]);
		$this->db->where('udq_cand_advno', $rowarray[1]);
		$this->db->where('udq_cand_regno', $rowarray[2]);
		$this->db->where('udq_sectiontype', $rowarray[3]);
		$this->db->where('udq_quali_id', $rowarray[4]);
		$this->db->where('udq_s_datetime <= "'.$curenttime.'"');
		$this->db->where('udq_e_datetime >= "'.$curenttime.'"');
		$this->db->where('udq_status', 1);
		$query = $this->db->get();
		return $query->row();
	}

	public function qualificationModification_AlreadyUpload_Check($rowarray){
		$curenttime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->from('updatequali_log');
		$this->db->where('udq_id', $rowarray[5]);
		$this->db->where('udq_cand_advno', $rowarray[1]);
		$this->db->where('udq_cand_regno', $rowarray[2]);
		$this->db->where('udq_sectiontype', $rowarray[3]);
		$this->db->where('udq_quali_id', $rowarray[4]);
		$this->db->where('udq_s_datetime <= "'.$curenttime.'"');
		$this->db->where('udq_e_datetime >= "'.$curenttime.'"');
		$this->db->where('udq_cur_fullmarks != ""');
		$this->db->where('udq_cur_markobtain != ""');
		$this->db->where('udq_cur_percentage != ""');
		$this->db->where('udq_status', 2);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function qualificationModification_TimeFieldCheck($rowarray){
		$curenttime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->from('updatequali_log');
		$this->db->where('udq_id', $rowarray[5]);
		$this->db->where('udq_cand_advno', $rowarray[1]);
		$this->db->where('udq_cand_regno', $rowarray[2]);
		$this->db->where('udq_sectiontype', $rowarray[3]);
		$this->db->where('udq_quali_id', $rowarray[4]);
		$this->db->where('udq_s_datetime <= "'.$curenttime.'"');
		$this->db->where('udq_e_datetime >= "'.$curenttime.'"');
		$this->db->where('udq_status', 1);
		$query = $this->db->get();
		return $query->row();
	}

	public function addmodify_ShiftMaster_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('shift_id', $cdid);
			if($this->db->update("shift_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("shift_master_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function getAll_Shift_list(){
		$this->db->select('shift_master_tab.*,address_tab.address_name');
		$this->db->from('shift_master_tab');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
		$this->db->order_by('shift_master_tab.shift_id DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAll_FindShift_Interview_list($venueno = NULL, $u_startdate = NULL){
		$this->db->select('shift_master_tab.*,address_tab.address_name');
		$this->db->from('shift_master_tab');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
		if($venueno != NULL){
			$this->db->where('shift_master_tab.shift_venue',$venueno);
		}
		if($u_startdate != NULL){
			$this->db->where('shift_master_tab.shift_date',date('Y-m-d',strtotime($u_startdate)));
		}
		$this->db->where('shift_master_tab.shift_status',1);
		$this->db->order_by('shift_master_tab.shift_start_time ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDetails_ADV_Category_with_shift_venueforInterview($intv_no){
		$this->db->select('intv_data_manipulate.*, advertisement_categoty.*, shift_master_tab.*,address_tab.address_name, category_master.catm_name');
		$this->db->from('intv_data_manipulate');
		$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->join('shift_master_tab','shift_master_tab.shift_id = intv_data_manipulate.idm_shift_no');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
		$this->db->where('intv_data_manipulate.idm_id', $intv_no);
		$query = $this->db->get();
		return $query->row();
	}

	public function getDetails_with_shift_Interview_segrigation_check($intv_shift_no, $adv_temp_intvno){
		$this->db->select('intv_data_manipulate.*, shift_master_tab.*');
		$this->db->from('intv_data_manipulate');
		//$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('shift_master_tab','shift_master_tab.shift_id = intv_data_manipulate.idm_shift_no');
		$this->db->where('intv_data_manipulate.idm_shift_no', $intv_shift_no);
		$this->db->where('intv_data_manipulate.idm_autogen_code', $adv_temp_intvno);
		$this->db->where('intv_data_manipulate.idm_status', 1);
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select('intv_data_manipulate.*, shift_master_tab.*');
		$this->db->from('intv_data_manipulate');
		//$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('shift_master_tab','shift_master_tab.shift_id = intv_data_manipulate.idm_shift_no');
		$this->db->where('intv_data_manipulate.idm_shift_no', $intv_shift_no);
		$this->db->where('intv_data_manipulate.idm_status', 2);
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1." UNION ".$query2);
		//$query = $this->db->query("SELECT * from user_views where u_id IN (".$query1." UNION ".$query2.")");
		return $query->result();
	}

	public function getAllResult_ofIndividual_POSTS_shift_ofADV($advno, $adv_temp_intvno){
		$this->db->select('intv_data_manipulate.*, shift_master_tab.*, advertisement_categoty.*, category_master.catm_name');
		$this->db->from('intv_data_manipulate');
		$this->db->join('advertisement_categoty','advertisement_categoty.acat_id = intv_data_manipulate.idm_adv_category');
		$this->db->join('shift_master_tab','shift_master_tab.shift_id = intv_data_manipulate.idm_shift_no');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('intv_data_manipulate.idm_adv_no', $advno);
		$this->db->where('intv_data_manipulate.idm_autogen_code', $adv_temp_intvno);
		$this->db->where('intv_data_manipulate.idm_status', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function shiftdown_AllSection_MasterShift_TableStart($idsetarray, $tab_count){
		$this->db->set('idm_tab_start_count', 'idm_tab_start_count-'.$tab_count, false);
    	$this->db->where_in('idm_id' , $idsetarray);
    	if($this->db->update('intv_data_manipulate')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getDetails_forAllTable_shiftwise_check($advno, $advcat_name, $shift_name){
		//$this->db->distinct('interview_tab.invw_tableno as utable_name');
		$this->db->select("interview_tab.invw_tableno as utable_name");
		$this->db->distinct();
		$this->db->from('interview_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = interview_tab.invw_cand_regno');
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('f_user_views.fu_category', $advcat_name);
		$this->db->where('interview_tab.invw_venuemaster', $shift_name);
		$this->db->order_by('interview_tab.invw_tableno ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getDetails_forInterviewPanel_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno){
		$this->db->select('interview_tab.*, f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        $this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('f_user_views.fu_category', $advcat_name);
		$this->db->where('interview_tab.invw_venuemaster', $shift_name);
		$this->db->where('interview_tab.invw_tableno', $table_exactno);
		$this->db->order_by('f_user_views.f_full_name ASC, f_user_views.f_application_no ASC');
        $query = $this->db->get();
        return $query->result();
	}

	public function getDetails_forInterviewPanel_Candidate_shiftwise_forADV($advno, $shift_name){
		$this->db->select('interview_tab.*, f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        $this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('interview_tab.invw_venuemaster', $shift_name);
		$this->db->order_by('f_user_views.f_full_name ASC');
		$query = $this->db->get();
        return $query->result();
	}

	public function GetDetail_CategorywiseAdvertisement_for_Application($advno, $catid){
		$this->db->select('advertisement_categoty.*, advertisement_master.adv_no, category_master.catm_name, recruitment_master_tab.rm_name');
		$this->db->from('advertisement_categoty');
		$this->db->join('f_user_views','f_user_views.fu_category = advertisement_categoty.acat_id');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('f_user_views.fu_category', $catid);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAllDetails_forShift($shift_no){
		$this->db->select('shift_master_tab.*,address_tab.address_name');
		$this->db->from('shift_master_tab');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
		$this->db->where('shift_master_tab.shift_id', $shift_no);
		$query = $this->db->get();
		return $query->row();
	} 

	public function getDetails_forInterviewNo_insert_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno){
		$this->db->select('interview_tab.*, f_user_views.f_uid, f_user_views.f_full_name, f_user_views.f_mobile, f_user_views.f_email');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        //$this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        //$this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('f_user_views.fu_category', $advcat_name);
		$this->db->where('interview_tab.invw_venuemaster', $shift_name);
		$this->db->where('interview_tab.invw_tableno', $table_exactno);
		$this->db->where('interview_tab.invw_status', 1);
		$this->db->where('interview_tab.invw_attendance is NULL');
		$this->db->order_by('f_user_views.f_full_name ASC, f_user_views.f_application_no ASC');
        $query = $this->db->get();
        return $query->result();
	}

	public function getDetails_forInterviewNo_insert_Candidate_tablewise_chk2($advno, $advcat_name, $shift_name, $table_exactno){
		$this->db->select('interview_tab.*, f_user_views.f_uid, f_user_views.f_full_name, f_user_views.f_mobile, f_user_views.f_email');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        //$this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        //$this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
		$this->db->where('candidate_result_tab.cr_approval', "Approved");
		$this->db->where('f_user_views.f_applied_for', $advno);
		$this->db->where('f_user_views.fu_category', $advcat_name);
		$this->db->where('interview_tab.invw_venuemaster', $shift_name);
		$this->db->where('interview_tab.invw_tableno', $table_exactno);
		$this->db->where('interview_tab.invw_status', 1);
		$this->db->where('interview_tab.invw_attendance is not NULL');
		$this->db->order_by('f_user_views.f_full_name ASC');
        $query = $this->db->get();
        return $query->result();
	}

	public function getUpdates_forInterviewmarks_insertions($rows, $row1, $rowid, $row_regno){
		$this->db->trans_start();
		$this->db->set($rows);
		$this->db->where('invw_id', $rowid);
		$this->db->where('invw_cand_regno', $row_regno);
        $this->db->update('interview_tab', $rows);
        
        $this->db->set($row1);
        $this->db->where('cr_application_master', $row_regno);
        $this->db->update("candidate_result_tab", $row1);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }
	}

	public function getAll_returnMarks_Candidates_interview($checktype, $checker_id){
		$this->db->select('interview_tab.*, f_user_views.f_uid, f_user_views.f_full_name, f_user_views.f_mobile, f_user_views.f_email');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('interview_tab.invw_attendance is not NULL');
		$this->db->where('interview_tab.invw_status', 1);
        if($checktype == "C1"){
			$this->db->where('interview_tab.invw_approval', "Return");
			$this->db->where('interview_tab.invw_mark_createby', $checker_id);
		}elseif($checktype == "C2"){
			$this->db->where('interview_tab.invw_approval', "Revert");
			$this->db->where('interview_tab.invw_approve_by', $checker_id);
		}
		$this->db->order_by('f_user_views.f_full_name ASC');
		$query = $this->db->get();
        return $query->result();
	}

	public function getdetails_formodify_Candidates_interview_marks($checktype, $intvid, $checker_id){
		$this->db->select('interview_tab.*, f_user_views.f_uid, f_user_views.f_full_name, f_user_views.f_mobile, f_user_views.f_email, advertisement_master.adv_no, recruitment_master_tab.rm_name, category_master.catm_name,shift_master_tab.*, address_tab.address_name');
        $this->db->from('interview_tab');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
		$this->db->join('shift_master_tab','shift_master_tab.shift_id = interview_tab.invw_venuemaster');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
		$this->db->join('advertisement_categoty','advertisement_categoty.acat_adv_master = advertisement_master.adv_auto_genno');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
		$this->db->where('interview_tab.invw_attendance is not NULL');
		$this->db->where('interview_tab.invw_status', 1);
		$this->db->where('interview_tab.invw_id', $intvid);
		if($checktype == "C1"){
			$this->db->where('interview_tab.invw_approval', "Return");
			$this->db->where('interview_tab.invw_mark_createby', $checker_id);
		}elseif($checktype == "C2"){
			$this->db->where('interview_tab.invw_approval', "Revert");
			$this->db->where('interview_tab.invw_approve_by', $checker_id);
		}
		$query = $this->db->get();
        return $query->row();
	}


}
