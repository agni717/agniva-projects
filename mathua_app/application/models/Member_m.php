<?php

class Member_M extends MY_Model {

    function __construct() {
        parent::__construct();
    }
	
	public function checklogin_member($username, $password) {
        //$sql = $this->db->select('*')->from('frontend_users')->where('f_mobile', $username)->where('f_password', $password)->where('f_status', 1)->where('f_active', 1);
        $sql = $this->db->select('*')->from('frontend_users')->where('f_mobile', $username)->where('f_password', $password)->where('f_status', 1);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            $data = $res->row_array();
            $this->session->set_userdata('member_id', $data["f_uid"]);
            $this->session->set_userdata('member_uname', $data["f_mobile"]);
            $this->session->set_userdata('member_fname', $data["f_full_name"]);
            $this->session->set_userdata('member_utype', $data["f_utype"]);
            $this->session->set_userdata('member_loggedin', TRUE);
            return TRUE;
        } else {
            return FALSE;
        }

        $res->free_result();
    }
	
    public function member_loggedin() {

        return (bool) $this->session->userdata('member_loggedin');
    }
    
    public function update_user_modified($now, $id = NULL) {
        $id = $this->session->userdata('member_id');

        $this->db->set($now);
        $this->db->where('f_uid', $id);
        $this->db->update('frontend_users', $now);
    }
	
	public function update_frontuser_details_modified($now, $id = NULL) {
        $id = $this->session->userdata('member_id');

        $this->db->set($now);
        $this->db->where('fu_master', $id);
        if($this->db->update('f_user_details', $now)){
			return TRUE;
        }else{
            return FALSE;
		}
    }
    
    public function member_loggedin_check() {
		
		$this->db->select('*');
		$this->db->from('student_information');
		$this->db->where('student_id', $this->session->userdata('member_id'));
		$this->db->where('student_username', $this->session->userdata('member_uname'));
		$this->db->where('student_login_ip', $this->session->userdata('member_loginip'));
		$this->db->where('student_session_id', $this->session->userdata('member_uniquedevice_ip'));
		$this->db->where('student_status', 1);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
    }
    
    public function logout() {

        $this->session->sess_destroy();
    }
    
    public function Show_StudentDetailsIDwise($member_id, $member_uname){
		$this->db->select('*');
		$this->db->from('student_information');
		$this->db->join('student_details', 'student_details.std_master_id = student_information.student_id');
		$this->db->where('student_information.student_id', $member_id);
		$this->db->where('student_information.student_username', $member_uname);
		$this->db->where('student_status', 1);
		$query = $this->db->get();
		return $query->row();
    }
    
    public function change_existingUser_password($rows, $fid) {
		
		$this->db->set($rows);
        $this->db->where('f_uid', $fid);
        if($this->db->update("frontend_users", $rows)){
            return TRUE;
        }else{
            return FALSE;
        }
		
    }
	
	public function addform_against_UserQuery_inDB($rows, $qid = NULL){
		$this->db->set($rows);
		if($qid != NULL){
			$this->db->where('query_no', $qid);
			if($this->db->update("query_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("query_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}


	
	public function getAll_list_Advertisement_Category($advid, $catid = NULL){
		$this->db->select('advertisement_categoty.*,category_master.catm_name');
		$this->db->from('advertisement_categoty');
		$this->db->join('advertisement_master', 'advertisement_master.adv_auto_genno = advertisement_categoty.acat_adv_master');
		$this->db->join('category_master', 'category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('advertisement_categoty.acat_adv_master', $advid);
		if($catid != NULL){
			$this->db->where('advertisement_categoty.acat_id', $catid);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by("category_master.catm_name", "ASC");
			$query = $this->db->get();
			return $query->result();
		}
	}

    public function getAll_qualification_exam($adv){

        $this->db->select('advertisement_qualification.*,qualification_master.qm_name');
        $this->db->from('advertisement_qualification');
        $this->db->join('qualification_master', 'advertisement_qualification.aquali_exam = qualification_master.qm_id');
        $this->db->where('advertisement_qualification.aquali_adv_master', $adv);
        $this->db->order_by("advertisement_qualification.aquali_id", "ASC");

        $query = $this->db->get();
        
        return $query->result();
        
    }

    public function getAll_Experience_section($adv){

        $this->db->select('advertisement_experience.*,experience_master_tab.expset_name');
        $this->db->from('advertisement_experience');
        $this->db->join('experience_master_tab', 'experience_master_tab.expset_id = advertisement_experience.aexpr_name');
        $this->db->where('advertisement_experience.aexpr_adv_master', $adv);
        $this->db->order_by("advertisement_experience.aexpr_id", "ASC");
        $query = $this->db->get();
        return $query->result();
        
    }
    public function get_fuser_qualification_v2($fid){
        $this->db->select('f_user_qualification.*,qualification_master.qm_id,qualification_master.qm_name,state_master.state_id,state_master.state_name');
        $this->db->from('f_user_qualification');
        $this->db->join('qualification_master', 'f_user_qualification.fu_qualifiaction_name = qualification_master.qm_id');
        $this->db->join('state_master', 'f_user_qualification.fu_state_of_passing = state_master.state_id','LEFT');
        $this->db->where('f_user_qualification.fu_quali_masteruser', $fid);
        $this->db->order_by("f_user_qualification.fu_quali_id", "ASC");

        $query = $this->db->get();
        
        return $query->result();
    }

    public function get_fuser_qualification(){
        $this->db->select('f_user_qualification.*,qualification_master.qm_id,qualification_master.qm_name,state_master.state_id,state_master.state_name');
        $this->db->from('f_user_qualification');
        $this->db->join('qualification_master', 'f_user_qualification.fu_qualifiaction_name = qualification_master.qm_id');
        $this->db->join('state_master', 'f_user_qualification.fu_state_of_passing = state_master.state_id','LEFT');
        $this->db->where('f_user_qualification.fu_quali_masteruser', $this->session->userdata['member_id']);
        $this->db->order_by("f_user_qualification.fu_quali_id", "ASC");

        $query = $this->db->get();
        
        return $query->result();
    }

    public function gatAll_subscriptionAge_list($advno){
        $this->db->select('advertisement_age_set.*,caste_tab.caste_name, caste_tab.caste_cat, caste_tab.caste_parent');
        $this->db->from('advertisement_age_set');
        $this->db->join('caste_tab', 'caste_tab.caste_id = advertisement_age_set.advage_section');
        $this->db->where('advertisement_age_set.advage_adv_master', $advno);
        $this->db->order_by("advertisement_age_set.advage_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function add_fuser_qualification($quali, $qid = NULL){
        $this->db->set($quali);
        if($qid != NULL){
            $this->db->where('fu_quali_id', $qid);
            if($this->db->update('f_user_qualification', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }else{
            if($this->db->insert('f_user_qualification', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }
        
        //$insert_id = $this->db->insert_id();

        //return  $insert_id;
    }

    public function add_dsQuali_fuser_qualification($quali, $qid = NULL){
        $this->db->set($quali);
        if($qid != NULL){
            $this->db->where('fud_quali_id', $qid);
            if($this->db->update('f_user_des_qualification', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }else{
            if($this->db->insert('f_user_des_qualification', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }
        
        //$insert_id = $this->db->insert_id();

        //return  $insert_id;
    }

    public function add_essExp_fuser_Experience($quali, $qid = NULL){
        $this->db->set($quali);
        if($qid != NULL){
            $this->db->where('fues_exp_id', $qid);
            if($this->db->update('f_user_ess_experience', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }else{
            if($this->db->insert('f_user_ess_experience', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }
    }

    public function add_desExp_fuser_Experience($quali, $qid = NULL){
        $this->db->set($quali);
        if($qid != NULL){
            $this->db->where('fu_exp_id', $qid);
            if($this->db->update('f_user_experience', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }else{
            if($this->db->insert('f_user_experience', $quali)){
                return TRUE;  
            }else{
                return FALSE;
            }
        }
    }

    public function remove_fuser_qualification($id){

        $this->db->where('fu_quali_id', $id);
        $this->db->delete('f_user_qualification');
    }

    public function init_candidate_result_tab($adv){

        $this->db->insert('candidate_result_tab', array('cr_application_master'=>$adv));   
    }

    public function get_candidate_details($key){

        $curtime = date('Y-m-d H:i:s');
        /*if(date('Y-m-d') == '2022-08-04'){
            $curtime = date('Y-m-d H:i:s', strtotime($curtime.' -74 hours'));
        }*/

        $this->db->select('candidate_result_tab.*, f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name, DATE_FORMAT(shift_master_tab.shift_date,"%d-%m-%Y") as shift_date, DATE_FORMAT(shift_master_tab.shift_start_time,"%r") as shift_start_time, DATE_FORMAT(shift_master_tab.shift_end_time,"%r") as shift_end_time, address_tab.address_name');
        $this->db->from('candidate_result_tab');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        $this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
        $this->db->join('interview_tab','interview_tab.invw_cand_regno = candidate_result_tab.cr_application_master');
        $this->db->join('shift_master_tab','shift_master_tab.shift_id = interview_tab.invw_venuemaster');
        $this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
        $this->db->where('interview_tab.invw_reporting_time <= ', $curtime);
        $this->db->where('interview_tab.invw_reporting_endtime >= ', $curtime);
		$this->db->where('interview_tab.invw_status', 1);
        $this->db->where('candidate_result_tab.cr_approval', "Approved");
        $this->db->where('candidate_result_tab.cr_application_master', $key);
        $query = $this->db->get();
        return $query->row();

        /*$this->db->select('candidate_result_tab.*,f_user_views.*,advertisement_master.*,recruitment_master_tab.*');
        $this->db->from('candidate_result_tab');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        $this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
        // $this->db->like('candidate_result_tab.cr_application_master', $key);
        $this->db->where('candidate_result_tab.cr_application_master', $key);
        
        $query = $this->db->get();
        
        return $query->result(); */  

    }

    public function get_interViewuploaded_details($candreg_no){
        $this->db->select('fuser_interview_attachments.*');
        $this->db->from('fuser_interview_attachments');
        $this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = fuser_interview_attachments.fattach_application');
        $this->db->join('interview_tab','interview_tab.invw_cand_regno = candidate_result_tab.cr_application_master');
        $this->db->join('f_user_views', 'f_user_views.f_application_no = candidate_result_tab.cr_application_master');
        $this->db->where('fuser_interview_attachments.fattach_application', $candreg_no);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAll_ExtraAgeSets_checkingall($adv_no){
        $this->db->select('advertisement_age_set.*,caste_tab.caste_name');
        $this->db->from('advertisement_age_set');
        $this->db->join('caste_tab', 'caste_tab.caste_id = advertisement_age_set.advage_section');
        $this->db->where('advertisement_age_set.advage_adv_master', $adv_no);
        $this->db->where('caste_tab.caste_id >', 10);
        $this->db->where('caste_tab.caste_cat', 8);
        $this->db->order_by("advertisement_age_set.advage_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getAll_Existing_ExtraAgeSets_All(){
        $this->db->select('f_user_extraage.*,caste_tab.caste_name');
        $this->db->from('f_user_extraage');
        $this->db->join('caste_tab', 'caste_tab.caste_id = f_user_extraage.fu_ext_ageid');
        $this->db->where('f_user_extraage.fu_ext_masteruser', $this->session->userdata('member_id'));
        $this->db->order_by("f_user_extraage.fu_ext_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getAll_Existing_ExtraAgeSets_All_forAdmin($ref_id){
        $this->db->select('f_user_extraage.*,caste_tab.caste_name');
        $this->db->from('f_user_extraage');
        $this->db->join('caste_tab', 'caste_tab.caste_id = f_user_extraage.fu_ext_ageid');
        $this->db->where('f_user_extraage.fu_ext_masteruser', $ref_id);
        $this->db->order_by("f_user_extraage.fu_ext_id", "ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function checkExistense_of_ExtraAgeset($agecasteid){
        $this->db->select('*');
		$this->db->from('f_user_extraage');
		$this->db->where('fu_ext_masteruser', $this->session->userdata('member_id'));
		$this->db->where('fu_ext_ageid', $agecasteid);
		$this->db->where('fu_ext_status', 1);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
    }

    public function addUpdateform_ExtraAgeSets_inDB($rows, $qid = NULL){
		$this->db->set($rows);
		if($qid != NULL){
			$this->db->where('fu_ext_id', $qid);
			if($this->db->update("f_user_extraage", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("f_user_extraage", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

    public function get_candidate_applied_for($reg_no){

        return $this->db->get_where('f_user_views',array('f_application_no'=>$reg_no))->row();   

    }

    public function insert_into_interview_attachment($data){

        $this->db->insert(
            'fuser_interview_attachments', 
            $data
        );      
        return true;
    }

    public function get_caste_details($caste_id){

        return $this->db->get_where('caste_details_tab',array('csdetail_master'=>$caste_id,'csdetail_status'=>1))->result();
    }

    public function get_sub_div($district_code){


        $this->db->select('district_master.*,subdivision_tab.*');
        
        $this->db->from('district_master');
        
        $this->db->join('subdivision_tab','district_code = subdiv_district');
        
        $this->db->where('district_code',$district_code);

        $this->db->where('subdivision_tab.subdiv_status',1);

        $query = $this->db->get();
        
        return $query->result();

    }    

    public function get_police_station($district_code){


        $this->db->select('district_master.*,police_station_tab.*');
        
        $this->db->from('district_master');
        
        $this->db->join('police_station_tab','district_code = ps_dist_master');

        $this->db->where('district_code',$district_code);

        $this->db->where('police_station_tab.ps_status',1);

        $this->db->order_by('police_station_tab.ps_name','ASC');

        $query = $this->db->get();
        
        return $query->result();

    }    

    public function get_block($sub_div_id,$type){

        return $this->db->get_where('block_master',array('subd_id'=>$sub_div_id,'block_type'=>$type,'block_status'=>1))->result();
    }

	public function getAll_list_of_OLDData_for_PrevApplication($advno, $registration_no){
        $this->db->select('pharmasist2_tbl_for_migrate.*');
        $this->db->from('pharmasist2_tbl_for_migrate');
        $this->db->join('f_user_views', 'f_user_views.f_application_no = pharmasist2_tbl_for_migrate.update_regno');
        $this->db->where("pharmasist2_tbl_for_migrate.adv_genno", $advno);
        $this->db->where("pharmasist2_tbl_for_migrate.update_regno", $registration_no);
        $query = $this->db->get();
        return $query->row();
    }

    /*public function getMembers($id = NULL) {

        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $method = 'row';
            $this->db->join('users', 'userdetails.userid = users.id and users.utype >= 3 and users.id =' . $id);
        } else {
            $this->db->join('users', 'userdetails.userid = users.id and users.utype >= 3');
            $method = 'result';
        }

        $this->db->select('*');
        $this->db->from('userdetails');
        $this->db->order_by("users.id", "desc");
        $query = $this->db->get();
        return $query->$method();
    }*/

    public function hash($string) {

        return hash('sha512', $string . config_item('encryption_key'));
    }

    public function updateUserDetails($firstname, $lastname, $s_question, $s_answer, $pwd, $arr, $id) {
        $this->db->trans_start();
        if ($pwd != "") {
            $row = array(
                "password" => $this->hash($pwd),
            );
            $this->db->where("u_id", $id);
            $this->db->update("user_info", $row);
        }
        $rows = array(
            "firstname" => $firstname,
            "lastname" => $lastname,
            "security_question" => $s_question,
            "security_answer" => $s_answer
        );
        $this->db->where("u_id", $id);
        $this->db->update("user_info", $rows);
        
        //////////////////////////////////
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where("uid", $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
        	$this->db->where("uid", $id);
        	$this->db->update("user_details", $arr);
        } else {
			$arr['uid'] = $id;
			$this->db->set($arr);
			$this->db->insert("user_details");
		}
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    public function addupdate_CandidateExperience_inDB($rows) {
        $this->db->set($rows);
		$this->db->insert('f_user_experience', $rows);
        $exp_id = $this->db->insert_id();
        
		$this->db->select('f_user_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_experience.fu_exp_workname');
        $this->db->where('f_user_experience.fu_exp_masteruser', $this->session->userdata('member_id'));
		$this->db->where('f_user_experience.fu_exp_id', $exp_id);
		$query = $this->db->get();
		return $query->row();
    }

    public function addupdate_Candidate_Ess_Experience_inDB($rows) {
        $this->db->set($rows);
		$this->db->insert('f_user_ess_experience', $rows);
        $exp_id = $this->db->insert_id();
        
		$this->db->select('f_user_ess_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_ess_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_ess_experience.fues_exp_workname');
        $this->db->where('f_user_ess_experience.fues_exp_masteruser', $this->session->userdata('member_id'));
		$this->db->where('f_user_ess_experience.fues_exp_id', $exp_id);
		$query = $this->db->get();
		return $query->row();
    }

    public function addupdate_DesireQualification_inDB($rows) {
        $this->db->set($rows);
		$this->db->insert('f_user_des_qualification', $rows);
        $desq_id = $this->db->insert_id();
        
		$this->db->select('f_user_des_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_des_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_des_qualification.fud_qualifiaction_name');
        $this->db->join('state_master','state_master.state_id = f_user_des_qualification.fud_state_of_passing');
        $this->db->where('f_user_des_qualification.fud_quali_masteruser', $this->session->userdata('member_id'));
		$this->db->where('f_user_des_qualification.fud_quali_id', $desq_id);
		$query = $this->db->get();
		return $query->row();
    }

    public function gotoDesire_Qualification_listSet($candidate_id){
        $this->db->select('f_user_des_qualification.*, qualification_master.qm_name, state_master.state_name');
		$this->db->from('f_user_des_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = f_user_des_qualification.fud_qualifiaction_name');
        $this->db->join('state_master','state_master.state_id = f_user_des_qualification.fud_state_of_passing');
        $this->db->where('f_user_des_qualification.fud_quali_masteruser', $candidate_id);
		$query = $this->db->get();
		return $query->result();
    }

    public function gotoDesire_Experience_listSet($candidate_id){
        $this->db->select('f_user_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_experience.fu_exp_workname');
        $this->db->where('f_user_experience.fu_exp_masteruser', $candidate_id);
        $this->db->order_by('f_user_experience.fu_exp_id','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function gotoEssential_Experience_listSet($candidate_id){
        $this->db->select('f_user_ess_experience.*, experience_master_tab.expset_name');
		$this->db->from('f_user_ess_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = f_user_ess_experience.fues_exp_workname');
        $this->db->where('f_user_ess_experience.fues_exp_masteruser', $candidate_id);
        $this->db->order_by('f_user_ess_experience.fues_exp_id','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function checkDesire_Qualification_forInsert($quali_id, $candidate_id){
        $this->db->select('*');
		$this->db->from('f_user_des_qualification');
		$this->db->where('fud_quali_masteruser', $candidate_id);
		$this->db->where('fud_qualifiaction_name', $quali_id);
		$this->db->where('fud_quali_status', 1);
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

    public function gotoDetails_SearchforInterview_Set($candreg_no){
		$this->db->select('interview_tab.*, shift_master_tab.*, address_tab.address_name');
		$this->db->from('interview_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = interview_tab.invw_cand_regno');
        $this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = interview_tab.invw_cand_regno');
        $this->db->join('shift_master_tab','shift_master_tab.shift_id = interview_tab.invw_venuemaster');
		$this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
		$this->db->where('interview_tab.invw_cand_regno', $candreg_no);
		$this->db->where('interview_tab.invw_status', 1);
        $this->db->where('candidate_result_tab.cr_approval', "Approved");
		$query = $this->db->get();
		return $query->row();
	}

    public function gotocollect_AllRejection_Set($candreg_no, $chk_all = NULL){
        if($chk_all != NULL){
		    $this->db->select('checking_tab.*, user_info.firstname, user_info.lastname');
        }else{
            $this->db->select('checking_tab.*');
        }
		$this->db->from('checking_tab');
		$this->db->join('f_user_views','f_user_views.f_application_no = checking_tab.chk_user_application');
        $this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = checking_tab.chk_user_application');
        if($chk_all != NULL){
            //$this->db->join('user_info','user_info.u_id = checking_tab.chk_createby');
            $this->db->join('user_info','user_info.u_id = checking_tab.chk2_appro_by');
            $this->db->where('((checking_tab.chk2_approve = "Approved" AND checking_tab.chk_final_state = "Approved") OR (checking_tab.chk2_approve = "Rejected" AND checking_tab.chk_final_state = "Rejected"))');
            //$this->db->where_in('checking_tab.chk2_approve', array("Approved","Rejected"));
            //$this->db->where_in('checking_tab.chk_final_state', array("Approved","Rejected"));
            //$this->db->where('checking_tab.chk2_approve = checking_tab.chk_final_state');
        }else{
            $this->db->where('candidate_result_tab.cr_approval', "Rejected");
            $this->db->where('checking_tab.chk2_approve', "Rejected");
            $this->db->where('checking_tab.chk_final_state', "Rejected");
        }
        $this->db->where('checking_tab.chk_user_application', $candreg_no);
		$query = $this->db->get();
		return $query->result();
	}

    public function gotocheck_log_AllChecking_Set($candreg_no){
        $this->db->select('checker_log.*, user_info.firstname, user_info.lastname');
		$this->db->from('checker_log');
		//$this->db->join('f_user_views','f_user_views.f_application_no = checker_log.chklog_app_no');
        $this->db->join('user_info','user_info.u_id = checker_log.chklog_user');
        $this->db->where('checker_log.chklog_app_no', $candreg_no);
        $this->db->order_by('checker_log.chklog_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}

    public function get_all_access_forReject_User_inthe_Advertisement($advno){

        $curtime = date('Y-m-d H:i:s');

        $this->db->select('advertisement_resubmit_tab.*');
		$this->db->from('advertisement_resubmit_tab');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = advertisement_resubmit_tab.adv_resub_master');
        $this->db->where('advertisement_resubmit_tab.adv_resub_starttime <= ', $curtime);
        $this->db->where('advertisement_resubmit_tab.adv_resub_endtime >= ', $curtime);
        $this->db->where('advertisement_master.adv_auto_genno', $advno);
        $this->db->where('advertisement_resubmit_tab.adv_resub_status', 1);
        $this->db->where('advertisement_resubmit_tab.adv_resub_chk_stat', 0);
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

	public function update_rejectApplication_timeofInterview($chk_arr, $chk_arr2, $regno){
		$this->db->trans_start();
		$this->db->set($chk_arr);
		$this->db->where('cr_application_master', $regno);
		$this->db->update('candidate_result_tab', $chk_arr);
        
		$this->db->set($chk_arr2);
		$this->db->where('chk_user_application', $regno);
		$this->db->where('chk_type', 'fu_photo_doc');
        $this->db->update("checking_tab",$chk_arr2);
        
		$chk_arr3 = array(
			'invw_status' => 2
		);
		$this->db->set($chk_arr3);
		$this->db->where('invw_cand_regno', $regno);
		$this->db->update('interview_tab', $chk_arr3);

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }
	}

    public function gotoCheck_CurrentStatus_ofCandidate($advno, $regno){
        $this->db->select('f_user_views.*');
        $this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
        $this->db->where('f_user_views.f_applied_for', $advno);
        $this->db->where('f_user_views.f_application_no', $regno);
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

    public function addUpdateform_Modify_LOG_inDB($rows, $fid = NULL){
		$this->db->set($rows);
		if($fid != NULL){
			$this->db->where('fmod_id', $fid);
			if($this->db->update("formmodify_log", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("formmodify_log", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

    public function getAll_notavailable_vacancies_in_ADV($advno){

        $this->db->select('advertisement_categoty.acat_adv_master, SUM(acat_ur_ec) as acat_ur_ec, SUM(acat_ur_g_c) as acat_ur_g_c, SUM(acat_ur_g_d) as acat_ur_g_d, SUM(acat_ur_sp) as acat_ur_sp, SUM(acat_sc_ec) as acat_sc_ec, SUM(acat_sc_g_c) as acat_sc_g_c, SUM(acat_sc_g_d) as acat_sc_g_d, SUM(acat_st_ec) as acat_st_ec, SUM(acat_st_g_d) as acat_st_g_d, SUM(acat_obc_a_ec) as acat_obc_a_ec, SUM(acat_obc_a_g_d) as acat_obc_a_g_d, SUM(acat_obc_b_ec) as acat_obc_b_ec, SUM(acat_obc_b_g_d) as acat_obc_b_g_d');
        $this->db->from('advertisement_categoty');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = advertisement_categoty.acat_adv_master');
		$this->db->where('advertisement_master.adv_auto_genno', $advno);
        $this->db->group_by("advertisement_categoty.acat_adv_master");
        $query = $this->db->get();
		return $query->row();

		$query->free_result();
    }

}
