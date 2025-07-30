<?php

class Admin_M extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function check_mobile_existence($mobileno, $ctime = NULL){
		if($ctime == NULL){
			$this->db->select('*');
			$this->db->from($this->_adminusers);
			$this->db->where('mobile', $mobileno);
			//$this->db->where('u_type', $usertype);
			$this->db->where('user_status', 1);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return FALSE;
			}
		}else{
			$cur_time = date('H:i:s',strtotime($ctime));
			$cur_day = date('Y-m-d',strtotime($ctime));
			$this->db->select('*');
			$this->db->from($this->_adminusers);
			$this->db->where('mobile', $mobileno);
			//$this->db->where('u_type', $usertype);
			//$this->db->where('user_mac_address', $macaddress);
			$this->db->where('user_status', 1);
			$this->db->where("(entry_startdate <= '".$cur_day."' AND entry_enddate >= '".$cur_day."')");
			$this->db->where("(entry_starttime <= '".$cur_time."' AND entry_endtime >= '".$cur_time."')");
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
	}
	
	public function checklogin($uid, $otp, $mobile) {

		$srttime = strtotime(date('Y-m-d H:i:s'));
		$endTime = date("Y-m-d H:i:s", strtotime('-5 minutes', $srttime));

        $sql = $this->db->select('*')->from($this->_adminusers)->where('u_id', $uid)->where('mobile', $mobile)->where('otp_verify', $otp)->where('user_status', 1)->where('otp_sendtime > "'.$endTime.'"');
        $res = $this->db->get();
        //var_dump($sql);


        if ($res->num_rows() > 0) {
            $data = $res->row_array();
		
            $this->session->set_userdata('uid', $data["u_id"]);
            $this->session->set_userdata('username', $data["mobile"]);
            $this->session->set_userdata('utype', $data["u_type"]);
			if($data["u_dist"] != NULL){
				$this->session->set_userdata('udistcode', $data["u_dist"]);
			}else{
				$this->session->set_userdata('udistcode', 0);
			}
            //$this->session->set_userdata('uaccess', $data["u_access"]);
            $this->session->set_userdata('loggedin', TRUE);
			//$this->session->set_userdata('log_type','1');
            return true;
        } else {
            return false;
        }

        $res->free_result();
    }
	
	
    public function checklogin_get_userid_for_app_api($otp, $mobile) {
		$srttime = strtotime(date('Y-m-d H:i:s'));
		$endTime = date("Y-m-d H:i:s", strtotime('-5 minutes', $srttime));
        $sql = $this->db->select('*')->from($this->_adminusers)->where('mobile', $mobile)->where('otp_verify', $otp)->where('user_status', 1)->where('otp_sendtime > "'.$endTime.'"');
        $res = $this->db->get();
        //var_dump($sql);
        if ($res->num_rows() > 0) {
            $data = $res->row_array();
            return $data["u_id"];
        } else {
            return false;
        }
    }

	public function get_userid_by_mobile_for_app_api($mobile) {
        $sql = $this->db->select('*')->from($this->_adminusers)->where('mobile', $mobile)->where('user_status', 1);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $data = $res->row_array();
            return $data["u_id"];
        } else {
            return false;
        }
    }


	public function checklogin_forCheker3($uid, $otp, $mobile) {

        $sql = $this->db->select('*')->from('user_views')->where('u_id', $uid)->where('u_invitey_mobile', $mobile)->where('otp_verify', $otp)->where('user_status', 1);
        $res = $this->db->get();
        //var_dump($sql);


        if ($res->num_rows() > 0) {
            $data = $res->row_array();
			
            $this->session->set_userdata('guestid', $data["u_id"]);
            $this->session->set_userdata('guest_utype', $data["u_type"]);
			$this->session->set_userdata('guest_mobile', $data["u_invitey_mobile"]);
            return TRUE;
        } else {
            return FALSE;
        }

        $res->free_result();
    }

    public function update_mobiledetails_existence($rows, $uid){
		$this->db->set($rows);
        $this->db->where('u_id', $uid);
        if($this->db->update($this->_adminusers, $rows)){
			return TRUE;
        }else{
            return FALSE;
		}
	}
	
	public function loggedin() {

        return (bool) $this->session->userdata('loggedin');
    }

    public function hash($string) {

        return hash('sha512', $string . config_item('encryption_key'));
    }

	public function get_ALLdocument_for_DMS($id = NULL) {

        $this->db->select('*');
        $this->db->from('content_files_tab');
        $this->db->join('section_tab','section_tab.section_id = content_files_tab.file_section');
        //$this->db->where('content_files_tab.f_status','1');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function update_adminuser_log($rows) {
        $this->db->set($rows);
        $this->db->insert('user_log_tab',$rows);
    }

	public function update_adminuser_log_for_app_api($rows) {
        $this->db->set($rows);
		if($this->db->insert('user_log_tab',$rows)){
			return TRUE;
        }else{
            return FALSE;
		}
    }

	public function update_mobileOTP_log($rows) {
        $this->db->set($rows);
        $this->db->insert('mobile_otp_log',$rows);
    }
	
    public function update_adminuser_modified($now) {
        $id = $this->session->userdata('uid');

        $this->db->set($now);
        $this->db->where('u_id', $id);
        $this->db->update($this->_adminusers);
    }

	public function update_adminuser_modified_for_app_api($now, $u_id) {
        $this->db->set($now);
        $this->db->where('u_id', $u_id);
		if($this->db->update($this->_adminusers)){
			return TRUE;
        }else{
            return FALSE;
		}
		
    }
    
    public function GetDetailsofUsers($uid)
    {
		$this->db->select('user_views.*');
		$this->db->from('user_views');
		//$this->db->join('master_user_type','master_user_type.mu_id = user_info.u_type');
		$this->db->where('u_id', $uid);
		$query = $this->db->get();
		return $query->row();
	}
    
	public function getAll_Userwise_Count_asperMonitorChecker($ss_datetime, $ee_datetime, $chktype, $chkuser_id, $chkuser_type = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		
		//$this->db->where('frontend_users.f_applied_for', $advno);
		if($chkuser_type != NULL){
			if($chktype == "Return"){
				$this->db->where('checking_tab.chk_final_state', $chktype);
			}else{
				$this->db->where('checking_tab.chk_approve', $chktype);
			}
			$this->db->where('checking_tab.chk_createby', $chkuser_id);
			$this->db->where('checking_tab.chk_create_by_type', $chkuser_type);
			$this->db->where("(checking_tab.chk_appro_date >= '".$ss_datetime."' AND checking_tab.chk_appro_date <= '".$ee_datetime."')");
		}else{
			$this->db->where('checking_tab.chk2_approve', $chktype);
			$this->db->where('checking_tab.chk2_appro_by', $chkuser_id);
			$this->db->where("(checking_tab.chk2_appro_date >= '".$ss_datetime."' AND checking_tab.chk2_appro_date <= '".$ee_datetime."')");
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function getAllCount_asperMonitorChecker($advno, $chktype, $chkuser_id, $chkuser_type = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		$this->db->where('frontend_users.f_applied_for', $advno);
		if($chkuser_type != NULL){
			if($chktype == "Return"){
				$this->db->where('checking_tab.chk_final_state', $chktype);
			}else{
				$this->db->where('checking_tab.chk_approve', $chktype);
			}
			$this->db->where('checking_tab.chk_createby', $chkuser_id);
			$this->db->where('checking_tab.chk_create_by_type', $chkuser_type);
		}else{
			$this->db->where('checking_tab.chk2_approve', $chktype);
			$this->db->where('checking_tab.chk2_appro_by', $chkuser_id);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function getAllReverse_Count_asperChecker($advno, $chktype_1, $chktype_2, $chkuser_id, $chkuser_type = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		$this->db->where('frontend_users.f_applied_for', $advno);
		$this->db->where('checking_tab.chk_approve', $chktype_1);
		$this->db->where('checking_tab.chk_createby', $chkuser_id);
		$this->db->where('checking_tab.chk_create_by_type', $chkuser_type);
		$this->db->where('checking_tab.chk2_approve', $chktype_2);
		$this->db->where('checking_tab.chk_final_state', $chktype_2);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function removeAll_CheckerAction_statusinDB($rowsets, $chkid){
		$this->db->set($rowsets);
        $this->db->where('chk_id', $chkid);
        if($this->db->update('checking_tab', $rowsets)){
			return TRUE;
        }else{
            return FALSE;
		}
	}

    public function searchallAdminUser()
    {
		$this->db->select('user_views.*, master_user_type.mu_name as parent_type');
		// $this->db->select('user_views.*');
		$this->db->from('user_views');
		$this->db->join('master_user_type','master_user_type.mu_id = user_views.u_type','LEFT');
		//$this->db->where('u_id !=', 1);
		$this->db->where('u_type !=', 1);
		$this->db->order_by('u_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAllExecutiveByDistrictCode($dist_code){
		$this->db->select('*');
		$this->db->from('user_views');
		$this->db->where('u_type', 4);
		$this->db->where('u_dist', $dist_code);
		$this->db->order_by('u_id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function checkUser_existingAdvertisement_withAccess($advno, $uaccess){
		$this->db->select('*');
		$this->db->from('user_views');
		$this->db->where('u_id', $this->session->userdata['uid']);
		$this->db->where('u_adv_access LIKE "%'.$advno.'%"');
		$this->db->where('(u_access_area LIKE "%'.$uaccess.'%" OR u_access_area LIKE "ALL")');
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

	public function checkUser_AdvertisementWise_withAccess($advno, $utype = NULL){
		$this->db->select('*');
		$this->db->from('user_views');
		if($utype == NULL){
			$this->db->where_in('u_type', array(2,4));
		}else{
			$this->db->where_in('u_type', array(2,3,4));
		}
		$this->db->where('u_adv_access LIKE "%'.$advno.'%"');
		$this->db->order_by('u_type', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function cehckfor_freeup_All_theSkipsection_user($advno, $chkno, $deloption){
		if($deloption == "SKIP"){
			$sqlquery = "SELECT checking_tab.* FROM checking_tab WHERE checking_tab.chk_user_application IN (SELECT f_user_views.f_application_no FROM f_user_views WHERE f_user_views.f_applied_for = '".$advno."') AND checking_tab.chk_final_state = 'Skip' AND checking_tab.chk_approve = 'Skip' AND checking_tab.chk_createby = ".$chkno;
		}else{
			$currentdate = date('Y-m-d H:i:s', strtotime('-1 hour'));
			$sqlquery = "SELECT checking_tab.* FROM checking_tab WHERE checking_tab.chk_user_application IN (SELECT f_user_views.f_application_no FROM f_user_views WHERE f_user_views.f_applied_for = '".$advno."') AND checking_tab.chk_final_state is NULL AND checking_tab.chk_approve is NULL AND checking_tab.chk_createdate < '".$currentdate."'";
		}
		$query = $this->db->query($sqlquery);
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function freeup_All_theSkipsection_Asper_user($advno, $chkno, $deloption){
		if($deloption == "SKIP"){
			$sqlquery = "DELETE FROM checking_tab WHERE checking_tab.chk_user_application IN (SELECT f_user_views.f_application_no FROM f_user_views WHERE f_user_views.f_applied_for = '".$advno."') AND checking_tab.chk_final_state = 'Skip' AND checking_tab.chk_approve = 'Skip' AND checking_tab.chk_createby = ".$chkno;
		}else{
			$currentdate = date('Y-m-d H:i:s', strtotime('-1 hour'));
			$sqlquery = "DELETE FROM checking_tab WHERE checking_tab.chk_user_application IN (SELECT f_user_views.f_application_no FROM f_user_views WHERE f_user_views.f_applied_for = '".$advno."') AND checking_tab.chk_final_state is NULL AND checking_tab.chk_approve is NULL AND checking_tab.chk_createdate < '".$currentdate."'";
		}
		if($this->db->query($sqlquery)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function GetDetailsofCandidateChecking_ByChecker($advno, $userid, $ss_datetime, $ee_datetime, $utype = NULL){
		$this->db->select('checking_tab.*,frontend_users.*,user_views.firstname,user_views.lastname,user_views.mu_name');
		$this->db->from('checking_tab');
		$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		$this->db->join('user_views','user_views.u_id = checking_tab.chk_createby');
		$this->db->where('frontend_users.f_applied_for', $advno);
		if($utype != NULL){
			$this->db->where('checking_tab.chk2_appro_by', $userid);
			$this->db->where("(checking_tab.chk2_appro_date >= '".$ss_datetime."' AND checking_tab.chk2_appro_date <= '".$ee_datetime."')");
			$this->db->order_by('checking_tab.chk2_appro_date', 'ASC');
		}else{
			$this->db->where('checking_tab.chk_createby', $userid);
			$this->db->where("(checking_tab.chk_appro_date >= '".$ss_datetime."' AND checking_tab.chk_appro_date <= '".$ee_datetime."')");
			$this->db->order_by('checking_tab.chk_appro_date', 'ASC');
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetailsofCandidateMail_sendByChecker($advno, $userid, $ss_datetime, $ee_datetime){
		$this->db->select('updatedoc_mail_log.*,frontend_users.*, user_views.firstname,user_views.lastname,user_views.mu_name');
		$this->db->from('updatedoc_mail_log');
		$this->db->join('frontend_users','frontend_users.f_application_no = updatedoc_mail_log.udm_cand_regno');
		$this->db->join('user_views','user_views.u_id = updatedoc_mail_log.udm_createby');
		$this->db->where('frontend_users.f_applied_for', $advno);
		$this->db->where('updatedoc_mail_log.udm_createby', $userid);
		$this->db->where("(updatedoc_mail_log.udm_createdate >= '".$ss_datetime."' AND updatedoc_mail_log.udm_createdate <= '".$ee_datetime."')");
		$this->db->order_by('updatedoc_mail_log.udm_createdate', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function checkwhitelistIPss($ipset){
		$this->db->select('*');
		$this->db->from('whitelistip_tab');
		$this->db->where('wip_ipset', $ipset);
		$this->db->where('wip_status', 1);
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

	public function get_Checker3_data($mobileNo, $ctime){
		$cur_time = date('H:i:s',strtotime($ctime));
		$cur_day = date('Y-m-d',strtotime($ctime));
		$this->db->select('*');
		$this->db->from('user_views');
		$this->db->where('u_invitey_mobile', $mobileNo);
		$this->db->where('u_type', 4);
		$this->db->where('user_status', 1);
		$this->db->where("(entry_startdate <= '".$cur_day."' AND entry_enddate >= '".$cur_day."')");
		$this->db->where("(entry_starttime <= '".$cur_time."' AND entry_endtime >= '".$cur_time."')");
		$query = $this->db->get();
		return $query->row();
	}
	
	public function check_Checker3_existence($mobileNo, $ctime){
		$cur_time = date('H:i:s',strtotime($ctime));
		$cur_day = date('Y-m-d',strtotime($ctime));
		$this->db->select('*');
		$this->db->from('user_views');
		$this->db->where('u_invitey_mobile', $mobileNo);
		$this->db->where('u_type', 4);
		$this->db->where('user_status', 1);
		$this->db->where("(entry_startdate <= '".$cur_day."' AND entry_enddate >= '".$cur_day."')");
		$this->db->where("(entry_starttime <= '".$cur_time."' AND entry_endtime >= '".$cur_time."')");
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
	
	public function check_Existing_qualification_inDB($adv_no, $quali_name){
		$this->db->select('*');
		$this->db->from('advertisement_qualification');
		$this->db->where('aquali_adv_master', $adv_no);
		$this->db->where('aquali_exam', $quali_name);
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
	
	public function check_Existing_Experience_inDB($adv_no, $expr_name){
		$this->db->select('*');
		$this->db->from('advertisement_experience');
		$this->db->where('aexpr_adv_master', $adv_no);
		$this->db->where('aexpr_name', $expr_name);
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
	
	public function check_category_exist_inDB($adv_no, $cat_id){
        $this->db->select('*');
		$this->db->from('advertisement_categoty');
		$this->db->where('acat_adv_master', $adv_no);
		$this->db->where('acat_name', $cat_id);
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
	
	public function addupdate_category_inDB($rows) {
        $this->db->set($rows);
		$this->db->insert('advertisement_categoty', $rows);
        $cat_id = $this->db->insert_id();
        
		$this->db->select('advertisement_categoty.*, category_master.catm_name');
		$this->db->from('advertisement_categoty');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('advertisement_categoty.acat_id', $cat_id);
		$query = $this->db->get();
		return $query->row();
    }

	public function check_Ageset_exist_inDB($adv_no, $age_id){
        $this->db->select('*');
		$this->db->from('advertisement_age_set');
		$this->db->where('advage_adv_master', $adv_no);
		$this->db->where('advage_section', $age_id);
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

	public function addupdate_AgeSet_inDB($rows) {
        $this->db->set($rows);
		$this->db->insert('advertisement_age_set', $rows);
        $age_id = $this->db->insert_id();
        
		$this->db->select('advertisement_age_set.*, caste_tab.caste_name');
		$this->db->from('advertisement_age_set');
		$this->db->join('caste_tab','caste_tab.caste_id = advertisement_age_set.advage_section');
		$this->db->where('advertisement_age_set.advage_id', $age_id);
		$query = $this->db->get();
		return $query->row();
    }
	
	public function addupdate_Experience_inDB($rows) {
        $this->db->set($rows);
		if($this->db->insert('advertisement_experience', $rows)){
			$q_id = $this->db->insert_id();
			return $q_id;
		}else{
			return FALSE;
		}
    }
	
	public function addupdate_Experience_details_inDB($rows) {
        $this->db->set($rows);
		if($this->db->insert('advertisement_exp_details', $rows)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

	public function checkUpperdata_Exist_forQualification($qid, $advno){
        $this->db->select('*');
		$this->db->from('advertisement_qualification');
		$this->db->where('aquali_adv_master', $advno);
		$this->db->where('aquali_id >', $qid);
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

	public function checkUpperdata_Exist_forExperience($qid, $advno){
        $this->db->select('*');
		$this->db->from('advertisement_experience');
		$this->db->where('aexpr_adv_master', $advno);
		$this->db->where('aexpr_id >', $qid);
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

	public function getAll_prevRecord_forExperience($advno){
		$this->db->select('*');
		$this->db->from('advertisement_experience');
		$this->db->where('aexpr_adv_master', $advno);
		$this->db->order_by('aexpr_id','DESC');
		$this->db->limit(1, 0);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAll_CheckerAdv_ofActive_Advertisement($applyads = NULL){
		$this->db->select('advertisement_master.*, recruitment_master_tab.rm_name');
		$this->db->from('advertisement_master');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($applyads != NULL){
			$this->db->where_in('advertisement_master.adv_auto_genno', $applyads);
		}
		$this->db->order_by('advertisement_master.adv_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAlllist_ofActive_Advertisement($applyid = NULL){
		//$cur_time = date('Y-m-d H:i:s');
		
		$this->db->select('advertisement_master.*, recruitment_master_tab.rm_name');
		$this->db->from('advertisement_master');
		//$this->db->join('advertisement_marks','advertisement_marks.amark_adv_master = advertisement_master.adv_auto_genno');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		//$this->db->where('advertisement_master.adv_start_time < ', $cur_time);
		//$this->db->where('advertisement_master.adv_end_time > ', $cur_time);
		$this->db->where('advertisement_master.adv_status', 1);
		if($applyid != NULL){
			$this->db->where('advertisement_master.adv_auto_genno',$applyid);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('advertisement_master.adv_id','DESC');
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function getAlllist_ofInactive_Active_Advertisement(){
		
		$this->db->select('advertisement_master.*, recruitment_master_tab.rm_name');
		$this->db->from('advertisement_master');
		//$this->db->join('advertisement_marks','advertisement_marks.amark_adv_master = advertisement_master.adv_auto_genno');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	public function getAll_prevRecord_forQualification($advno){
		//$sql = 'SELECT * FROM advertisement_qualification WHERE aquali_id = (SELECT MAX(aquali_id) FROM advertisement_qualification WHERE aquali_adv_master = "'.$advno.'")';
		$this->db->select('*');
		$this->db->from('advertisement_qualification');
		$this->db->where('aquali_adv_master', $advno);
		$this->db->order_by('aquali_id','DESC');
		$this->db->limit(1, 0);
		$query = $this->db->get();
		return $query->row();
	}

	public function getAll_prevRecord_forAge_FeeSet($advno){
		$this->db->select('*');
		$this->db->from('advertisement_age_set');
		$this->db->where('advage_adv_master', $advno);
		$this->db->order_by('advage_id','DESC');
		$this->db->limit(1, 0);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function addupdate_qualification_inDB($rows) {
        $this->db->set($rows);
		if($this->db->insert('advertisement_qualification', $rows)){
			$q_id = $this->db->insert_id();
			return $q_id;
		}else{
			return FALSE;
		}
    }
	
	public function addupdate_qualification_details_inDB($rows) {
        $this->db->set($rows);
		if($this->db->insert('advertisement_quali_details', $rows)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

	public function addupdate_deduction_details_inDB($rows) {
        $this->db->set($rows);
		if($this->db->insert('advertisement_deduct_details', $rows)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

	public function getDetails_Expr_of_Advertisement($expr_no){
		$this->db->select('advertisement_experience.*, experience_master_tab.expset_name');
		$this->db->from('advertisement_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = advertisement_experience.aexpr_name');
		$this->db->where('advertisement_experience.aexpr_id', $expr_no);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_Experience_slav_details_fromDB($exid){
		$this->db->select('advertisement_experience.*, experience_master_tab.expset_name, advertisement_exp_details.ae_range_words, advertisement_exp_details.ae_detail_month, advertisement_exp_details.ae_detail_mark');
		$this->db->from('advertisement_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = advertisement_experience.aexpr_name');
		$this->db->join('advertisement_exp_details','advertisement_exp_details.ae_experience_ms = advertisement_experience.aexpr_id');
		$this->db->where('advertisement_experience.aexpr_id', $exid);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_qualification_details_fromDB($qid){
		$this->db->select('advertisement_qualification.*,qualification_master.qm_name');
		$this->db->from('advertisement_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
		//$this->db->join('advertisement_quali_details','advertisement_quali_details.aq_qualification_ms = advertisement_qualification.aquali_id','LEFT');
		$this->db->where('advertisement_qualification.aquali_id', $qid);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_qualification_slav_details_fromDB($qid){
		$this->db->select('advertisement_qualification.*,qualification_master.qm_name, advertisement_quali_details.aq_detail_score_lvl, advertisement_quali_details.aq_detail_score_mark');
		$this->db->from('advertisement_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
		$this->db->join('advertisement_quali_details','advertisement_quali_details.aq_qualification_ms = advertisement_qualification.aquali_id');
		$this->db->where('advertisement_qualification.aquali_id', $qid);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_qualification_slav_deductdetails_fromDB($qid){
		$this->db->select('advertisement_qualification.*,qualification_master.qm_name, advertisement_deduct_details.aq_deduct_lvl, advertisement_deduct_details.aq_deduct_mark');
		$this->db->from('advertisement_deduct_details');
		$this->db->join('advertisement_qualification','advertisement_qualification.aquali_id = advertisement_deduct_details.aq_deduction_ms');
		$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
		$this->db->where('advertisement_qualification.aquali_id', $qid);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_detaillist_of_Advertisement_byRA($rf_set = NULL, $adv_no = NULL){
		$this->db->select('advertisement_master.*,advertisement_marks.*,recruitment_master_tab.rm_name');
		$this->db->from('advertisement_master');
		$this->db->join('advertisement_marks','advertisement_marks.amark_adv_master = advertisement_master.adv_auto_genno');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($rf_set != NULL){
			$this->db->where('advertisement_master.adv_recruit_master', $rf_set);
		}
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
		}
		$this->db->order_by('advertisement_master.adv_id','DESC');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	public function getAll_detaillist_of_Avvertisement($adv_no = NULL){
		$this->db->select('advertisement_master.*,advertisement_marks.*,recruitment_master_tab.rm_name');
		$this->db->from('advertisement_master');
		$this->db->join('advertisement_marks','advertisement_marks.amark_adv_master = advertisement_master.adv_auto_genno');
		$this->db->join('recruitment_master_tab','recruitment_master_tab.rm_id = advertisement_master.adv_recruit_master');
		if($adv_no != NULL){
			$this->db->where('advertisement_master.adv_auto_genno', $adv_no);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('advertisement_master.adv_id','DESC');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	public function getAll_Cat_detaillist_of_Avvertisement($adv_no = NULL){
		$this->db->select('advertisement_categoty.*, category_master.catm_name');
		$this->db->from('advertisement_categoty');
		$this->db->join('category_master','category_master.catm_id = advertisement_categoty.acat_name');
		$this->db->where('advertisement_categoty.acat_adv_master', $adv_no);
		$this->db->order_by('category_master.catm_name','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAllCount_asperADV_Categorywise_Candidates($advno, $catgoryset, $pwdset = NULL){
		if($pwdset != NULL){
			$sqlquery = "SELECT count(f_user_views.f_application_no) as cnt FROM f_user_views WHERE f_user_views.f_applied_for = '".$advno."' AND f_user_views.fu_category = ".$catgoryset." AND f_user_views.fu_step_1 = 1 AND f_user_views.fu_step_2 = 1 AND f_user_views.fu_step_3 = 1 AND f_user_views.fu_step_4 = 1 AND f_user_views.fu_final_submit = 1 AND f_user_views.fu_payment_stat = 1 AND f_user_views.fu_cancel_stat = 0 AND f_user_views.fu_pwd = 'Yes'";
			$query = $this->db->query($sqlquery);
			return $query->row();
		}else{
			$sqlquery = "SELECT f_user_views.fu_caste_type, caste_tab.caste_cat, caste_tab.caste_parent, count(f_user_views.fu_caste_type) as cnt FROM f_user_views, caste_tab WHERE caste_tab.caste_id = f_user_views.fu_caste_type AND f_user_views.f_applied_for = '".$advno."' AND f_user_views.fu_category = ".$catgoryset." AND f_user_views.fu_step_1 = 1 AND f_user_views.fu_step_2 = 1 AND f_user_views.fu_step_3 = 1 AND f_user_views.fu_step_4 = 1 AND f_user_views.fu_final_submit = 1 AND f_user_views.fu_payment_stat = 1 AND f_user_views.fu_cancel_stat = 0 group by f_user_views.fu_caste_type";
			$query = $this->db->query($sqlquery);
			return $query->result();
		}
	}

	public function getAll_AgeFee_detaillist_of_Advertisement($adv_no = NULL, $ageno = NULL){
		$this->db->select('advertisement_age_set.*, caste_tab.caste_name');
		$this->db->from('advertisement_age_set');
		$this->db->join('caste_tab','caste_tab.caste_id = advertisement_age_set.advage_section');
		$this->db->where('advertisement_age_set.advage_adv_master', $adv_no);
		if($ageno != NULL){
			$this->db->where('advertisement_age_set.advage_id', $ageno);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('advertisement_age_set.advage_id','ASC');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	public function getAll_Quali_detaillist_of_Advertisement($adv_no = NULL, $examno = NULL){
		$this->db->select('advertisement_qualification.*, qualification_master.qm_name');
		$this->db->from('advertisement_qualification');
		$this->db->join('qualification_master','qualification_master.qm_id = advertisement_qualification.aquali_exam');
		$this->db->where('advertisement_qualification.aquali_adv_master', $adv_no);
		if($examno != NULL){
			$this->db->where('advertisement_qualification.aquali_exam', $examno);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('advertisement_qualification.aquali_id','ASC');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	public function getAll_DetailsQuali_of_Advertisement($adv_no = NULL, $qid = NULL){
		$this->db->select('advertisement_quali_details.*');
		$this->db->from('advertisement_quali_details');
		$this->db->join('advertisement_qualification','advertisement_qualification.aquali_id = advertisement_quali_details.aq_qualification_ms','LEFT');
		$this->db->where('advertisement_qualification.aquali_adv_master', $adv_no);
		if($qid != NULL){
			$this->db->where('advertisement_quali_details.aq_qualification_ms', $qid);
		}
		$this->db->order_by('advertisement_quali_details.aq_detail_score_lvl','ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function getAll_DeductionDetailsQuali_of_Advertisement($adv_no = NULL, $qid = NULL){
		$this->db->select('advertisement_deduct_details.*');
		$this->db->from('advertisement_deduct_details');
		$this->db->join('advertisement_qualification','advertisement_qualification.aquali_id = advertisement_deduct_details.aq_deduction_ms','LEFT');
		$this->db->where('advertisement_qualification.aquali_adv_master', $adv_no);
		if($qid != NULL){
			$this->db->where('advertisement_deduct_details.aq_deduction_ms', $qid);
		}
		$this->db->order_by('advertisement_deduct_details.aq_deduct_lvl','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_Expr_detaillist_of_Advertisement($adv_no = NULL){
		$this->db->select('advertisement_experience.*, experience_master_tab.expset_name');
		$this->db->from('advertisement_experience');
		$this->db->join('experience_master_tab','experience_master_tab.expset_id = advertisement_experience.aexpr_name');
		$this->db->where('advertisement_experience.aexpr_adv_master', $adv_no);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_DetailsExpr_of_Advertisement($adv_no = NULL, $expdetail_id = NULL){
		$this->db->select('advertisement_exp_details.*');
		$this->db->from('advertisement_exp_details');
		$this->db->join('advertisement_experience','advertisement_experience.aexpr_id = advertisement_exp_details.ae_experience_ms','LEFT');
		$this->db->where('advertisement_experience.aexpr_adv_master', $adv_no);
		if($expdetail_id != NULL){
			$this->db->where('advertisement_exp_details.ae_experience_ms', $expdetail_id);
		}
		$this->db->order_by('advertisement_exp_details.ae_detail_id','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function addform_against_Advertisement_inDB($rows, $row1){
        $this->db->set($rows);
		if($this->db->insert('advertisement_master', $rows)){
			$this->db->set($row1);
			if($this->db->insert("advertisement_marks",$row1)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
    }
	
	public function upDateform_against_Advertisement_inDB($rows, $rows2 = NULL, $advno){
        $this->db->set($rows);
		$this->db->where('adv_auto_genno', $advno);
		if($this->db->update("advertisement_master",$rows)){
			
			if($rows2 != NULL){
				$this->db->set($rows2);
				$this->db->where('amark_adv_master', $advno);
				if($this->db->update("advertisement_marks",$rows2)){
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				return TRUE;
			}
		}else{
			return FALSE;
		}
    }
	
	public function saveNewUser($rows, $row1) {
        $this->db->trans_start();
		$this->db->set($rows);
		$this->db->insert($this->_adminusers, $rows);
        $user_id = $this->db->insert_id();
        
        $row1['uid'] = $user_id;
        $this->db->set($row1);
        $this->db->insert("user_details",$row1);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }	
    }

	public function saveNewUpdate_User_log($rows){
		$this->db->set($rows);
		$this->db->insert('user_modify_log', $rows);
	}
	
	public function get_user_data_by_id($uid){
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('u_id', $uid);
		$query = $this->db->get();
		return $query->row();
	}

	public function check_Checker_District_exist($dist, $sid = NULL, $utype = NULL)
	{
		$this->db->select('*');
		$this->db->from($this->_adminusers);
		$this->db->where('u_dist', $dist);
		if($utype != NULL){
			$this->db->where('u_type', $utype);
		}
		if($sid != NULL){
			$this->db->where('u_id != ', $sid);
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
	}
	
	public function check_Checker_mobile_exist($mobileno, $sid = NULL)
	{
		$this->db->select('*');
		$this->db->from($this->_adminusers);
		$this->db->where('mobile', $mobileno);
		//$this->db->where('u_type', $utype);
		if($sid != NULL)
        	$this->db->where('u_id != ', $sid);
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
	public function check_Checker_email_exist($email, $utype, $sid = NULL)
	{
		$this->db->select('*');
		$this->db->from($this->_adminusers);
		$this->db->where('email', $email);
		$this->db->where('u_type', $utype);
		if($sid != NULL)
        	$this->db->where('u_id != ', $sid);
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
	
	public function allSuppliers_InsertUpdate($rows, $s_id = NULL){
		$this->db->set($rows);
		if($s_id != NULL){
			$this->db->where('supp_id', $s_id);
			if($this->db->update("supplier_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("supplier_master", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function check_supplier_mobile_exist($mobileno, $sid = NULL)
	{
		$this->db->select('*');
		$this->db->from('supplier_master');
		$this->db->where('supp_mobile', $mobileno);
		if($sid != NULL)
        	$this->db->where('supp_id != ', $sid);
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
	
	public function allGuideline_Instruction_InsertUpdate($rows, $g_id = NULL){
		$this->db->set($rows);
		if($g_id != NULL){
			$this->db->where('gi_id', $g_id);
			if($this->db->update("gudie_instruct_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("gudie_instruct_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function check_email_exist($emailid, $uid = NULL)
	{
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('email', $emailid);
		if($uid != NULL)
        	$this->db->where('u_id != ', $uid);
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
	
	public function check_password_exist($passward, $uid)
	{
		$this->db->select('*');
		$this->db->from($this->_adminusers);
		$this->db->where('u_id', $uid);
		$this->db->where('password', $passward);
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
	
	public function check_username_exist($username, $uid = NULL)
	{
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('username', $username);
		if($uid != NULL)
        	$this->db->where('u_id != ', $uid);
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

	public function check_usertype_Already_exist($utype, $uid = NULL)
	{
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('u_type', $utype);
		if($uid != NULL)
        	$this->db->where('u_id != ', $uid);
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

	public function check_usertype_Already_existinDistrict($p_utype, $dist, $uid = NULL)
	{
		$this->db->select('*');
		$this->db->from('user_info');
		$this->db->where('u_masteruser', $p_utype);
		$this->db->where('u_dist', $dist);
		if($uid != NULL)
        	$this->db->where('u_id != ', $uid);
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
	
	public function change_user_status($uid, $cng_status)
	{
		$data = array(
		               'user_status' => $cng_status
		            );
		$this->db->where('u_id', $uid);
		if($this->db->update($this->_adminusers, $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function getAlllist_ofPrev_log_UserSections($uid){
		$this->db->select('user_modify_log.*, master_user_type.mu_name');
		$this->db->from('user_modify_log');
		$this->db->join('master_user_type','master_user_type.mu_id = user_modify_log.usr_md_type');
		$this->db->where('user_modify_log.usr_md_masterid', $uid);
		$this->db->order_by('user_modify_log.usr_md_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_all_permitApplication_details($uid){
		$this->db->select('user_permission_tab.*, permit_application.papp_name');
		$this->db->from('user_permission_tab');
		$this->db->join('permit_application','permit_application.papp_id = user_permission_tab.up_application');
		$this->db->where('user_permission_tab.up_master_user', $uid);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function permission_Inserted_DB($rows, $p_id = NULL){
		$this->db->set($rows);
		if($p_id != NULL){
			$this->db->where('up_id', $p_id);
			if($this->db->update("user_permission_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("user_permission_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}
	
	public function permission_Exist_inDB_forUser($p_app, $users){
		$this->db->select('*');
		$this->db->from('user_permission_tab');
		$this->db->where('up_master_user', $users);
		$this->db->where('up_application', $p_app);
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
	
	/*public function UpdateSavedUser($rows, $uid)
	{
		$this->db->set($rows);
        $this->db->where('u_id', $uid);
        if($this->db->update($this->_adminusers))
        	return TRUE;
        else
        	return FALSE;
	}*/
	
	public function getAll_discussion_byUser_fromDB($q_no = NULL){
		$this->db->select('query_tab.*, f_user_views.*');
		$this->db->from('query_tab');
		$this->db->join('f_user_views','f_user_views.f_uid = query_tab.query_user');
		if($q_no != NULL){
			$this->db->where('query_tab.query_no', $q_no);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('query_tab.query_id','DESC');
			$query = $this->db->get();
			return $query->result();
		}
	}
	
	public function UpdateSavedUser_Password($rows, $uid){
		$this->db->set($rows);
		$this->db->where('u_id', $uid);
        if($this->db->update($this->_adminusers, $rows)){
		    return TRUE;
        }else{
            return FALSE;
        }	
	}
	
	public function UpdateSavedUser($rows, $row1, $uid)
	{
		$this->db->trans_start();
		$this->db->set($rows);
		$this->db->where('u_id', $uid);
        $this->db->update($this->_adminusers, $rows);
        
        $this->db->set($row1);
        $this->db->where('uid', $uid);
        $this->db->update("user_details", $row1);
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }	
	}
	
	public function common_Insertion_in_DB($row_arrary, $table_name){
		$this->db->set($row_arrary);
        if($this->db->insert($table_name, $row_arrary)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function common_Updation_in_DB($row_arrary, $table_name, $table_column, $column_value){
		$this->db->set($row_arrary);
		$this->db->where($table_column, $column_value);
        if($this->db->update($table_name, $row_arrary)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	public function FindSubAdminName()
	{
		$this->db->select('u_id, username');
		$this->db->from('user_views');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_ALL_FrontEnduser_DMS($fuid = NULL){
		$this->db->select('*');
        $this->db->from('frontend_users');
        if($fuid != NULL){
			$this->db->where('fuser_id', $fuid);
			$query = $this->db->get();
        	return $query->row();
		}else{
			$query = $this->db->get();
        	return $query->result();
		}   
	}

	public function getAll_work_fromDB(){
		$this->db->select('main_work_tab.*, work_sector_tab.ws_name, fund_source_tab.fs_name');
		$this->db->from('main_work_tab');
		$this->db->join('fund_source_tab','fund_source_tab.fs_id = main_work_tab.mw_fund_source');
		$this->db->join('work_sector_tab','work_sector_tab.ws_id = main_work_tab.mw_sector');
		$this->db->order_by('main_work_tab.mw_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function addUpdateform_ofWork_inDB($row1, $row2 = NULL, $row3 = NULL, $workid = NULL){
		$this->db->trans_start();

		if($row2 != NULL){
			$this->db->set($row2);
			$this->db->insert('fund_source_tab', $row2);
			$fund_id = $this->db->insert_id();
			$row1['mw_fund_source'] = $fund_id;
		}
		if($row3 != NULL){
			$this->db->set($row3);
			$this->db->insert('work_sector_tab', $row3);
			$sector_id = $this->db->insert_id();
			$row1['mw_sector'] = $sector_id;
		}
		$this->db->set($row1);
		if($workid != NULL){
			$this->db->where('mw_id', $workid);
			$this->db->update('main_work_tab', $row1);
		}else{
			$this->db->insert('main_work_tab', $row1);
		}
		
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
	}

	public function addUpdateform_of_WorkAllocation_inDB($rows, $wid = NULL){
		$this->db->set($rows);
		if($wid != NULL){
			$this->db->where('work_id', $wid);
			if($this->db->update("work_allocate_details", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("work_allocate_details", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function get_all_NewWork_for_Allocate($f_year){
		$this->db->select('main_work_tab.mw_name, main_work_tab.mw_unique_id, work_allocate_details.work_id');
		$this->db->from('main_work_tab');
		$this->db->join('work_allocate_details','work_allocate_details.work_master_id = main_work_tab.mw_unique_id','LEFT');
		$this->db->where('main_work_tab.mw_year', $f_year);
		$this->db->where('main_work_tab.mw_tender_float', 'Yes');
		$this->db->where('work_allocate_details.work_id IS NULL');
		$this->db->order_by('main_work_tab.mw_id','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_workAllocation_fromDB($workallocid = NULL){
		$this->db->select('work_allocate_details.*,main_work_tab.mw_name, main_work_tab.mw_year, uv1.username as ae_name, uv2.username as sae_name');
		$this->db->from('work_allocate_details');
		$this->db->join('main_work_tab','main_work_tab.mw_unique_id = work_allocate_details.work_master_id');
		$this->db->join('user_views uv1','uv1.u_id = work_allocate_details.work_se_id');
		$this->db->join('user_views uv2','uv2.u_id = work_allocate_details.work_ase_id');
		if($workallocid != NULL){
			$this->db->where('work_allocate_details.work_id', $workallocid);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('work_allocate_details.work_id','DESC');
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function getAll_workAllocation_fromDB_byProgress($workuid = NULL){
		$this->db->select('work_allocate_details.*,main_work_tab.mw_name, main_work_tab.mw_year, main_work_tab.mw_unique_id, main_work_tab.mw_progress_stat, main_work_tab.mw_finalbill_put');
		$this->db->from('work_allocate_details');
		$this->db->join('main_work_tab','main_work_tab.mw_unique_id = work_allocate_details.work_master_id');
		//$this->db->join('user_views uv1','uv1.u_id = work_allocate_details.work_se_id');
		//$this->db->join('user_views uv2','uv2.u_id = work_allocate_details.work_ase_id');
		if($workuid != NULL){
			$this->db->where('main_work_tab.mw_unique_id', $workuid);
			$query = $this->db->get();
			return $query->row();
		}else{
			$this->db->order_by('work_allocate_details.work_id','DESC');
			$query = $this->db->get();
			return $query->result();
		}
	}

	public function addUpdate_WorkProgress_inDB($row1, $row2, $pic_row = NULL, $wpid = NULL){
		$this->db->trans_start();

		$this->db->set($row1);
		$this->db->insert('work_progress_tab', $row1);
		$w_progress_id = $this->db->insert_id();

		$this->db->set($row2);
		$this->db->where('mw_unique_id', $wpid);
		$this->db->update('main_work_tab', $row2);

		if($pic_row != NULL){
			foreach($pic_row as $pics){
				$pic_arr = array(
					'wpp_master_progrid' => $w_progress_id,
					'wpp_pic_source' => $pics,
					'wpp_createdate' => date('Y-m-d H:i:s')
				);
				$this->db->set($pic_arr);
				$this->db->insert('work_prog_pictures', $pic_arr);
			}	
		}
		
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
	}

	public function addUpdate_WorkProgress_Bill_inDB($row1, $row2, $wpid){
		$this->db->trans_start();

		$this->db->set($row1);
		$this->db->insert('work_bill_tab', $row1);
		
		$this->db->set($row2);
		$this->db->where('mw_unique_id', $wpid);
		$this->db->update('main_work_tab', $row2);

		$this->db->trans_complete();
        if ($this->db->trans_status() === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	public function getAll_workProgress_fromDB_byVisit($workuid){
		$this->db->select('work_progress_tab.*,main_work_tab.mw_name, main_work_tab.mw_year, main_work_tab.mw_progress_stat, main_work_tab.mw_finalbill_put');
		$this->db->from('work_progress_tab');
		$this->db->join('main_work_tab','main_work_tab.mw_unique_id = work_progress_tab.wp_masterid');
		$this->db->join('user_views','user_views.u_id = work_progress_tab.wp_createby');
		$this->db->where('main_work_tab.mw_unique_id', $workuid);
		$this->db->order_by('work_progress_tab.wp_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getAll_workProgress_Bill_fromDB($workuid){
		$this->db->select('work_bill_tab.*,main_work_tab.mw_name, main_work_tab.mw_year, main_work_tab.mw_progress_stat, main_work_tab.mw_finalbill_put');
		$this->db->from('work_bill_tab');
		$this->db->join('main_work_tab','main_work_tab.mw_unique_id = work_bill_tab.wb_master_id');
		$this->db->join('user_views','user_views.u_id = work_bill_tab.wb_createby');
		$this->db->where('main_work_tab.mw_unique_id', $workuid);
		$this->db->order_by('work_bill_tab.wb_id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function GetDetailsofCandidate_monitoring_Application($adv_no){
		$this->db->select('f_user_views.f_applied_for,f_user_views.f_application_no,f_user_views.f_mobile,f_user_views.f_full_name,f_user_views.f_full_name,candidate_result_tab.*');
		$this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		$this->db->order_by('f_user_views.fu_final_createdate','DESC');
		$query = $this->db->get();
		return $query->result();

		$query->free_result();
	}

	public function GetDetailsofCandidate_afterFinal_Process_Application($adv_no, $candstatus = NULL, $categoryset = NULL){
		$this->db->select('f_user_views.f_applied_for,f_user_views.f_application_no,f_user_views.f_mobile,f_user_views.f_full_name,f_user_views.f_full_name,candidate_result_tab.*');
		$this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($candstatus != NULL){
			$this->db->where('candidate_result_tab.cr_approval', $candstatus);
			if($categoryset != NULL){
				$this->db->where('f_user_views.fu_category', $categoryset);
			}
			$this->db->order_by('f_user_views.f_full_name','ASC');
			$query = $this->db->get();
			return $query->num_rows();

			$query->free_result();
		}else{
			$this->db->where('candidate_result_tab.cr_approval != "NotChecked"');
			$this->db->order_by('f_user_views.f_full_name','ASC');
			$query = $this->db->get();
			return $query->result();

			$query->free_result();
		}
	}

	public function GetDetailsofCandidate_afterFinal_Process_Application_v2($adv_no, $candstatus = NULL, $pageno = 0, $searchtext = NULL){
		$this->db->select('f_user_views.f_applied_for,f_user_views.f_application_no,f_user_views.f_mobile,f_user_views.f_full_name,f_user_views.f_full_name,candidate_result_tab.*');
		$this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($searchtext != NULL){
			$this->db->where('(f_user_views.f_full_name like "%'.$searchtext.'%" OR f_user_views.f_application_no like "%'.$searchtext.'%" OR candidate_result_tab.cr_approval like "%'.$searchtext.'%" OR candidate_result_tab.cr_reject_comments like "%'.$searchtext.'%")');
			/*$this->db->like('f_user_views.f_full_name', $searchtext);
			$this->db->or_like('f_user_views.f_application_no', $searchtext);
			$this->db->or_like('f_user_views.f_mobile', $searchtext);
			$this->db->or_like('f_user_views.f_email', $searchtext);*/
		}
		if($candstatus != NULL){
			$this->db->where('candidate_result_tab.cr_approval', $candstatus);
			$this->db->order_by('f_user_views.f_full_name','ASC');
			$query = $this->db->get();
			return $query->num_rows();

			$query->free_result();
		}else{
			$this->db->where('candidate_result_tab.cr_approval != "NotChecked"');
			$this->db->order_by('f_user_views.f_full_name','ASC');
			$this->db->limit(20, $pageno);
			$query = $this->db->get();
			return $query->result();

			$query->free_result();
		}
	}

	public function count_AllFinalProcessDone_Candidate($adv_no, $searchtext = NULL){
		$this->db->select('f_user_views.f_applied_for,f_user_views.f_application_no,f_user_views.f_mobile,f_user_views.f_full_name,f_user_views.f_full_name,candidate_result_tab.*');
		$this->db->from('f_user_views');
		//$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = f_user_views.f_applied_for');
		$this->db->join('candidate_result_tab','candidate_result_tab.cr_application_master = f_user_views.f_application_no');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		$this->db->where('candidate_result_tab.cr_approval != "NotChecked"');
		if($searchtext != NULL){
			$this->db->where('(f_user_views.f_full_name like "%'.$searchtext.'%" OR f_user_views.f_application_no like "%'.$searchtext.'%" OR candidate_result_tab.cr_approval like "%'.$searchtext.'%" OR candidate_result_tab.cr_reject_comments like "%'.$searchtext.'%")');
			/*$this->db->like('f_user_views.f_full_name', $searchtext);
			$this->db->or_like('f_user_views.f_application_no', $searchtext);
			$this->db->or_like('f_user_views.f_mobile', $searchtext);
			$this->db->or_like('f_user_views.f_email', $searchtext);*/
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function checkUpdate_AllcheckingFree_aftersignoff($utypeset, $userid){
		if($utypeset == 1){
			
			$this->db->where('chk_approve', NULL);
			$this->db->where('chk_comments', NULL);
			$this->db->where('chk_final_state', NULL);
			$this->db->where('chk2_approve', NULL);
			$this->db->where('chk2_comments', NULL);
			$this->db->where('chk2_appro_by', NULL);
			$this->db->where('chk2_appro_date', NULL);
			$this->db->where('chk_createby', $userid);
    		$this->db->delete('checking_tab');

		}elseif($utypeset == 2){
			$rowarray = array(
				'chk2_appro_by' => NULL,
				'chk2_appro_date' => NULL
			);
			$this->db->where('chk2_approve', NULL);
			$this->db->where('chk2_comments', NULL);
			$this->db->where('chk2_appro_by', $userid);
			$this->db->update('checking_tab', $rowarray);
		}
	}

	public function getAll_Datewise_UserCount_asperChecking($ss_datetime, $ee_datetime, $chkuser_id, $chkuser_type = NULL){
		$this->db->select('checking_tab.*');
		$this->db->from('checking_tab');
		//$this->db->join('frontend_users','frontend_users.f_application_no = checking_tab.chk_user_application');
		$this->db->where('(checking_tab.chk_createby', $chkuser_id);
		$this->db->where('checking_tab.chk_approve != ', NULL);
		$this->db->where("date(checking_tab.chk_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk_appro_date) <= '".$ee_datetime."')");
		$this->db->or_where('(checking_tab.chk2_appro_by', $chkuser_id);
		$this->db->where('checking_tab.chk2_approve != ', NULL);
		$this->db->where("date(checking_tab.chk2_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk2_appro_date) <= '".$ee_datetime."')");
		//$this->db->where('frontend_users.f_applied_for', $advno);
		/*if($chkuser_type != NULL){
			if($chktype == "Return"){
				$this->db->where('checking_tab.chk_final_state', $chktype);
			}else{
				$this->db->where('checking_tab.chk_approve', $chktype);
			}
			$this->db->where('(checking_tab.chk_createby', $chkuser_id);
			$this->db->where('checking_tab.chk_create_by_type', $chkuser_type);
			$this->db->where("date(checking_tab.chk_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk_appro_date) <= '".$ee_datetime."')");
			$this->db->or_where('(checking_tab.chk2_appro_by', $chkuser_id);
			$this->db->where("date(checking_tab.chk2_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk2_appro_date) <= '".$ee_datetime."')");
		}else{
			$this->db->where('checking_tab.chk2_approve', $chktype);
			$this->db->where('(checking_tab.chk2_appro_by', $chkuser_id);
			$this->db->where("(date(checking_tab.chk2_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk2_appro_date) <= '".$ee_datetime."'))");
		}*/
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function getAll_Datewise_GroupingUserCount_asper_MarksEntry($ss_datetime, $ee_datetime, $chkuser_id = NULL){
		if($chkuser_id != NULL){
			$sqlquery = "SELECT u.u_id,u.u_type,u.firstname,u.lastname,u.mu_name, chekers, dates, count(invw_id) as totals from (SELECT interview_tab.invw_id, interview_tab.invw_mark_createby as chekers,substring(interview_tab.invw_mark_createdate,1,10) as dates FROM interview_tab where date(interview_tab.invw_mark_createdate) >= '".$ss_datetime."' AND date(interview_tab.invw_mark_createdate) <= '".$ee_datetime."' UNION SELECT interview_tab.invw_id, interview_tab.invw_approve_by as chekers,substring(interview_tab.invw_approve_date,1,10) as dates FROM interview_tab where date(interview_tab.invw_approve_date) >= '".$ss_datetime."' AND date(interview_tab.invw_approve_date) <= '".$ee_datetime."') a inner join user_views u on a.chekers = u.u_id  where u.u_id = ".$chkuser_id." group by chekers, dates order by dates, chekers ASC";
		}else{
			$sqlquery = "SELECT u.u_id,u.u_type,u.firstname,u.lastname,u.mu_name, chekers, dates, count(invw_id) as totals from (SELECT interview_tab.invw_id, interview_tab.invw_mark_createby as chekers,substring(interview_tab.invw_mark_createdate,1,10) as dates FROM interview_tab where date(interview_tab.invw_mark_createdate) >= '".$ss_datetime."' AND date(interview_tab.invw_mark_createdate) <= '".$ee_datetime."' UNION SELECT interview_tab.invw_id, interview_tab.invw_approve_by as chekers,substring(interview_tab.invw_approve_date,1,10) as dates FROM interview_tab where date(interview_tab.invw_approve_date) >= '".$ss_datetime."' AND date(interview_tab.invw_approve_date) <= '".$ee_datetime."') a inner join user_views u on a.chekers = u.u_id group by chekers, dates order by dates, chekers ASC";
		}
		$query = $this->db->query($sqlquery);
    	return $query->result();
	}
	
	public function getAll_Datewise_GroupingUserCount_asperChecking($ss_datetime, $ee_datetime, $chkuser_id = NULL){
		if($chkuser_id != NULL){
			$sqlquery = "SELECT u.u_id,u.u_type,u.firstname,u.lastname,u.mu_name, chekers, dates, count(chk_id) as totals from (SELECT checking_tab.chk_id, checking_tab.chk_createby as chekers,substring(checking_tab.chk_appro_date,1,10) as dates FROM checking_tab where date(checking_tab.chk_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk_appro_date) <= '".$ee_datetime."' UNION SELECT checking_tab.chk_id, checking_tab.chk2_appro_by as chekers,substring(checking_tab.chk2_appro_date,1,10) as dates FROM checking_tab where date(checking_tab.chk2_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk2_appro_date) <= '".$ee_datetime."') a inner join user_views u on a.chekers = u.u_id  where u.u_id = ".$chkuser_id." group by chekers, dates order by dates, chekers ASC";
		}else{
			$sqlquery = "SELECT u.u_id,u.u_type,u.firstname,u.lastname,u.mu_name, chekers, dates, count(chk_id) as totals from (SELECT checking_tab.chk_id, checking_tab.chk_createby as chekers,substring(checking_tab.chk_appro_date,1,10) as dates FROM checking_tab where date(checking_tab.chk_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk_appro_date) <= '".$ee_datetime."' UNION SELECT checking_tab.chk_id, checking_tab.chk2_appro_by as chekers,substring(checking_tab.chk2_appro_date,1,10) as dates FROM checking_tab where date(checking_tab.chk2_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk2_appro_date) <= '".$ee_datetime."') a inner join user_views u on a.chekers = u.u_id group by chekers, dates order by dates, chekers ASC";
		}
		$query = $this->db->query($sqlquery);
    	return $query->result();
		
		/*$this->db->select('checking_tab.chk_createby as creates, COUNT(checking_tab.chk_id) as totals, substring(checking_tab.chk_appro_date,1,10) as dates');
		$this->db->from('checking_tab');
		if($chkuser_id != NULL){
			$this->db->where('checking_tab.chk_createby', $chkuser_id);
		}
		$this->db->where('checking_tab.chk_approve is not NULL');
		$this->db->where("date(checking_tab.chk_appro_date) >= '".$ss_datetime."' AND date(checking_tab.chk_appro_date) <= '".$ee_datetime."'");
		$this->db->group_by(array("substring(checking_tab.chk_appro_date,1,10)", "checking_tab.chk_createby"));
		$this->db->having('dates is not NULL'); 
		$this->db->order_by('dates','ASC');
		$query = $this->db->get();
		return $query->result();*/
	}

	public function goto_checkAllchcekertype_wise_Countersection($advno, $chktype, $subtype_id = NULL){
		if($subtype_id != NULL){
			$sqlquery = "SELECT count(checking_tab.chk_id) as totals, 'C1' as checkers FROM checking_tab, frontend_users WHERE checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = '".$advno."' AND checking_tab.chk_type = '".$chktype."' AND checking_tab.chk_sub_typeid = '".$subtype_id."' AND (checking_tab.chk_approve = 'Approved' OR checking_tab.chk_approve = 'Rejected' OR checking_tab.chk_approve = 'Doubtful')
			UNION
			SELECT count(checking_tab.chk_id) as totals, 'C2' as checkers FROM checking_tab, frontend_users WHERE checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = '".$advno."' AND checking_tab.chk_type = '".$chktype."' AND checking_tab.chk_sub_typeid = '".$subtype_id."' AND (checking_tab.chk2_approve = 'Approved' OR checking_tab.chk2_approve = 'Rejected')";
		}else{
			$sqlquery = "SELECT count(checking_tab.chk_id) as totals, 'C1' as checkers FROM checking_tab, frontend_users WHERE checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = '".$advno."' AND checking_tab.chk_type = '".$chktype."' AND (checking_tab.chk_approve = 'Approved' OR checking_tab.chk_approve = 'Rejected' OR checking_tab.chk_approve = 'Doubtful')
			UNION
			SELECT count(checking_tab.chk_id) as totals, 'C2' as checkers FROM checking_tab, frontend_users WHERE checking_tab.chk_user_application = frontend_users.f_application_no AND frontend_users.f_applied_for = '".$advno."' AND checking_tab.chk_type = '".$chktype."' AND (checking_tab.chk2_approve = 'Approved' OR checking_tab.chk2_approve = 'Rejected')";
		}
		$query = $this->db->query($sqlquery);
    	return $query->result();

		$query->free_result();
	}

	public function getcount_DetailsofCandidate_Application($adv_no, $typeset = NULL){
		$this->db->select('f_user_views.*');
		$this->db->from('f_user_views');
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$this->db->where('f_user_views.f_applied_for', $adv_no);
		if($typeset != NULL){
			if($typeset == "fu_caste"){
				$this->db->where('f_user_views.fu_caste_type', 1);
			}elseif($typeset == "fu_pwd"){
				$this->db->where('f_user_views.fu_pwd', "No");
			}elseif($typeset == "fu_exempted"){
				$this->db->where('f_user_views.fu_exempted', "No");
			}elseif($typeset == "fu_exservice"){
				$this->db->where('f_user_views.fu_exservice', "No");
			}elseif($typeset == "fu_ews"){
				$this->db->where('f_user_views.fu_ews', "No");
			}
		}
		$query = $this->db->get();
		return $query->num_rows();

		$query->free_result();
	}

	public function getcount_Detailsofspcl_chk_Application($advno, $chktype, $subtype_id){
		if($chktype == "fu_age_relax"){
			$this->db->select('f_user_extraage.*');
			$this->db->from('f_user_extraage');
			$this->db->join('f_user_views','f_user_views.f_uid = f_user_extraage.fu_ext_masteruser');
			$this->db->where('f_user_views.f_applied_for', $advno);
			$this->db->where('f_user_extraage.fu_ext_ageid', $subtype_id);
			$this->db->where('f_user_extraage.fu_ext_answer', "Yes");
		}elseif($chktype == "fu_es_qualification"){
			$this->db->select('f_user_qualification.*');
			$this->db->from('f_user_qualification');
			$this->db->join('f_user_views','f_user_views.f_uid = f_user_qualification.fu_quali_masteruser');
			$this->db->join('state_master','state_master.state_id = f_user_qualification.fu_state_of_passing');
			$this->db->where('f_user_views.f_applied_for', $advno);
			$this->db->where('f_user_qualification.fu_qualifiaction_name', $subtype_id);
		}elseif($chktype == "fu_ds_qualification"){
			//$this->db->select('f_user_des_qualification.*');
			$this->db->select("f_user_des_qualification.fud_quali_masteruser");
			$this->db->distinct();
			$this->db->from('f_user_des_qualification');
			$this->db->join('f_user_views','f_user_views.f_uid = f_user_des_qualification.fud_quali_masteruser');
			$this->db->join('state_master','state_master.state_id = f_user_des_qualification.fud_state_of_passing');
			$this->db->where('f_user_views.f_applied_for', $advno);
			$this->db->where('f_user_des_qualification.fud_qualifiaction_name', $subtype_id);
		}elseif($chktype == "fu_has_es_service"){
			//$this->db->select('f_user_ess_experience.*');
			$this->db->select("f_user_ess_experience.fues_exp_masteruser");
			$this->db->distinct();
			$this->db->from('f_user_ess_experience');
			$this->db->join('f_user_views','f_user_views.f_uid = f_user_ess_experience.fues_exp_masteruser');
			$this->db->where('f_user_views.f_applied_for', $advno);
			$this->db->where('f_user_views.fu_has_service', 'Yes');
			$this->db->where('f_user_ess_experience.fues_exp_workname', $subtype_id);
		}elseif($chktype == "fu_has_ds_service"){
			//$this->db->select('f_user_experience.*');
			$this->db->select("f_user_experience.fu_exp_masteruser");
			$this->db->distinct();
			$this->db->from('f_user_experience');
			$this->db->join('f_user_views','f_user_views.f_uid = f_user_experience.fu_exp_masteruser');
			$this->db->where('f_user_views.f_applied_for', $advno);
			$this->db->where('f_user_views.fu_has_service', 'Yes');
			$this->db->where('f_user_experience.fu_exp_workname', $subtype_id);
		}
		$this->db->where('f_user_views.fu_step_1', 1);
		$this->db->where('f_user_views.fu_step_2', 1);
		$this->db->where('f_user_views.fu_step_3', 1);
		$this->db->where('f_user_views.fu_step_4', 1);
		$this->db->where('f_user_views.fu_final_submit', 1);
		$this->db->where('f_user_views.fu_payment_stat', 1);
		$this->db->where('f_user_views.fu_cancel_stat', 0);
		$query = $this->db->get();
		return $query->num_rows();

		$query->free_result();
	}

	public function getAll_ResubmitList_Advertisementwise($advno = NULL){
		$this->db->select('advertisement_resubmit_tab.*, advertisement_master.adv_no');
		$this->db->from('advertisement_resubmit_tab');
		$this->db->join('advertisement_master','advertisement_master.adv_auto_genno = advertisement_resubmit_tab.adv_resub_master');
		if($advno != NULL){
			$this->db->where('advertisement_resubmit_tab.adv_resub_master', $advno);
		}
		$this->db->order_by('advertisement_resubmit_tab.adv_resub_id','DESC');
		$query = $this->db->get();
		return $query->result();

		$query->free_result();
	}

	public function addmodify_ResubmitAdvertisement_Sets($rows, $cdid = NULL){
		$this->db->set($rows);
		if($cdid != NULL){
			$this->db->where('adv_resub_id', $cdid);
			if($this->db->update("advertisement_resubmit_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			if($this->db->insert("advertisement_resubmit_tab", $rows)){
				return TRUE;
			}else{
				return FALSE;
			}
	    }
	}

	public function shiftto_history_allthe_RejectCandidate_asper_Advertisement($advno){
		$this->db->trans_start();
		
		$sqlquery1 = "INSERT history_f_users SELECT frontend_users.* FROM frontend_users,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query1 = $this->db->query($sqlquery1);

		$sqlquery2 = "INSERT history_f_user_details SELECT f_user_details.* FROM frontend_users,f_user_details,candidate_result_tab where  frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_details.fu_master
		AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query2 = $this->db->query($sqlquery2);

		$sqlquery3 = "INSERT history_cand_result_tab SELECT candidate_result_tab.* FROM frontend_users,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query3 = $this->db->query($sqlquery3);

		$sqlquery4 = "INSERT history_f_extraage SELECT f_user_extraage.* FROM frontend_users,f_user_extraage,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_extraage.fu_ext_masteruser AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query4 = $this->db->query($sqlquery4);

		$sqlquery5 = "INSERT history_f_es_qualification SELECT f_user_qualification.* FROM frontend_users,f_user_qualification,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_qualification.fu_quali_masteruser AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query5 = $this->db->query($sqlquery5);

		$sqlquery6 = "INSERT history_f_ds_qualification SELECT f_user_des_qualification.* FROM frontend_users,f_user_des_qualification,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_des_qualification.fud_quali_masteruser AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query6 = $this->db->query($sqlquery6);

		$sqlquery7 = "INSERT history_f_es_experience SELECT f_user_ess_experience.* FROM frontend_users,f_user_ess_experience,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_ess_experience.fues_exp_masteruser AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query7 = $this->db->query($sqlquery7);

		$sqlquery8 = "INSERT history_f_ds_experience SELECT f_user_experience.* FROM frontend_users,f_user_experience,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_uid = f_user_experience.fu_exp_masteruser
		AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query8 = $this->db->query($sqlquery8);

		$sqlquery9 = "INSERT history_checking_tab SELECT checking_tab.* FROM checking_tab,frontend_users,candidate_result_tab where frontend_users.f_application_no = candidate_result_tab.cr_application_master AND frontend_users.f_application_no = checking_tab.chk_user_application AND checking_tab.chk_final_state = 'Rejected' AND checking_tab.chk2_approve = 'Rejected' AND candidate_result_tab.cr_approval = 'Rejected' AND frontend_users.f_applied_for = '".$advno."'";
		$query9 = $this->db->query($sqlquery9);

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }
	}
	
	public function allprocess_forChecking_and_delete_asper_Advertisement($advno){
		$this->db->trans_start();
		
		$sqlquery1 = "DELETE checking_tab.* from checking_tab
		INNER JOIN f_user_views ON checking_tab.chk_user_application = f_user_views.f_application_no
		INNER JOIN candidate_result_tab ON f_user_views.f_application_no = candidate_result_tab.cr_application_master
		WHERE checking_tab.chk_final_state = 'Rejected' AND checking_tab.chk2_approve = 'Rejected' AND candidate_result_tab.cr_approval = 'Rejected' AND f_user_views.fu_step_1 = 1 AND f_user_views.fu_step_2 = 1 AND f_user_views.fu_step_3 = 1 AND f_user_views.fu_step_4 = 1 AND f_user_views.fu_final_submit = 1 AND f_user_views.fu_payment_stat = 1 AND f_user_views.fu_cancel_stat = 0 AND f_user_views.f_applied_for = '".$advno."'";
		$query1 = $this->db->query($sqlquery1);

		$sqlquery2 = "UPDATE candidate_result_tab SET cr_approval='NotChecked',cr_reject_comments= NULL, fu_dob_check=NULL, fu_address_check=NULL, fu_photo_check=NULL,fu_signature_check=NULL, fu_caste_check=NULL, fu_pwd_check=NULL, fu_exempted_check = NULL, fu_exservice_check = NULL, fu_ews_check=NULL, fu_age_relax_check='No', fu_es_qualification_check='No', fu_es_service_check='No', fu_ds_qualification_check='No', fu_ds_service_check='No' WHERE cr_application_master IN (SELECT fv.f_application_no from f_user_views as fv where fv.f_applied_for = '".$advno."' AND fv.fu_step_1 = 1 AND fv.fu_step_2 = 1 AND fv.fu_step_3 = 1 AND fv.fu_step_4 = 1 AND fv.fu_final_submit = 1 AND fv.fu_payment_stat = 1 AND fv.fu_cancel_stat = 0) AND cr_approval = 'Rejected'";
		$query2 = $this->db->query($sqlquery2);

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }
	}

	public function allcandidate_forDeletion_PanelMerit_asper_Advertisement($advno, $advcategory){
		$this->db->trans_start();
		
		$sqlquery1 = "INSERT backset_finalpanel_tab SELECT final_panel_tab.* FROM final_panel_tab where fpn_category = ".$advcategory." AND fpn_advno = '".$advno."'";
		$query1 = $this->db->query($sqlquery1);

		$sqlquery2 = "DELETE final_panel_tab.* FROM final_panel_tab where fpn_category = ".$advcategory." AND fpn_advno = '".$advno."'";
		$query2 = $this->db->query($sqlquery2);

		$sqlquery3 = "INSERT backset_merit_tab SELECT merit_list_tab.* FROM merit_list_tab where mr_category = ".$advcategory." AND mr_adv_master = '".$advno."'";
		$query3 = $this->db->query($sqlquery3);

		$sqlquery4 = "DELETE merit_list_tab.* FROM merit_list_tab where mr_category = ".$advcategory." AND mr_adv_master = '".$advno."'";
		$query4 = $this->db->query($sqlquery4);

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return TRUE;
        }else{
            return FALSE;
        }
	}

	public function addmodify_FinalPanelModificationLog_Sets($rows){
		$this->db->set($rows);
		if($this->db->insert("fpanel_log", $rows)){
			return TRUE;
		}else{
			return FALSE;
		}
	    
	}

	public function get_interviewcandidate_details($key){

        //$curtime = date('Y-m-d H:i:s');
        $this->db->select('candidate_result_tab.*, f_user_views.*, advertisement_master.adv_no, recruitment_master_tab.rm_name, DATE_FORMAT(shift_master_tab.shift_date,"%d-%m-%Y") as shift_date, DATE_FORMAT(shift_master_tab.shift_start_time,"%r") as shift_start_time, DATE_FORMAT(shift_master_tab.shift_end_time,"%r") as shift_end_time, address_tab.address_name, interview_tab.invw_tableno');
        $this->db->from('candidate_result_tab');
        $this->db->join('f_user_views', 'candidate_result_tab.cr_application_master = f_user_views.f_application_no');
        $this->db->join('advertisement_master','f_user_views.f_applied_for = advertisement_master.adv_auto_genno');
        $this->db->join('recruitment_master_tab','advertisement_master.adv_recruit_master = recruitment_master_tab.rm_id');
        $this->db->join('interview_tab','interview_tab.invw_cand_regno = candidate_result_tab.cr_application_master');
        $this->db->join('shift_master_tab','shift_master_tab.shift_id = interview_tab.invw_venuemaster');
        $this->db->join('address_tab','address_tab.address_id = shift_master_tab.shift_venue');
        //$this->db->where('interview_tab.invw_reporting_time <= ', $curtime);
        //$this->db->where('interview_tab.invw_reporting_endtime >= ', $curtime);
		$this->db->where('interview_tab.invw_status', 1);
        //$this->db->where('candidate_result_tab.cr_approval', "Approved");
        $this->db->where('candidate_result_tab.cr_application_master', $key);
        $query = $this->db->get();
        return $query->row();

    }

}
