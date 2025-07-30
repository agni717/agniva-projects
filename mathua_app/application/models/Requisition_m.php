<?php

class Requisition_M extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_all_active_district(){
        $this->db->select('*');
		$this->db->from('district_master');
		$this->db->where('district_status', 1);
        $this->db->order_by('district_name','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_scheme_amount_by_district_id($scheme_id){
        $this->db->select('*');
		$this->db->from('scheme_master');
		$this->db->where('scm_id ', $scheme_id);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_all_block_by_district_code($dist_code){
        // $this->db->select('district_code');
		// $this->db->from('district_master');
		// $this->db->where('district_id', $dist_id);
		// $query = $this->db->get();
		// $dist_code_row = $query->row();
        //========================
        $this->db->select('*');
		$this->db->from('block_master');
		$this->db->where('district_id', $dist_code);
        $this->db->order_by('block_name','ASC');
		$query1 = $this->db->get();
		return $query1->result();
    }

    public function get_all_subdivision_by_district_id($dist_id){
        $this->db->select('district_code');
		$this->db->from('district_master');
		$this->db->where('district_id', $dist_id);
		$query = $this->db->get();
		$dist_code_row = $query->row();
        //========================
        $this->db->select('*');
		$this->db->from('subdivision_tab');
		$this->db->where('subdiv_district', $dist_code_row->district_code);
        $this->db->order_by('subdiv_name','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_all_block_by_subdiv_id($subdiv_id){
        // $this->db->select('district_code');
		// $this->db->from('district_master');
		// $this->db->where('district_id ', $subdiv_id);
		// $query = $this->db->get();
		// $dist_code_row = $query->row();
        //========================
        $this->db->select('*');
		$this->db->from('block_master');
		$this->db->where('subd_id', $subdiv_id);
        $this->db->order_by('block_name','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function insert_requisition_data($row_arr){
        if($this->db->insert("requisition_master", $row_arr))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function insert_work_progress_details($rows_array){
        if($this->db->insert("work_progress_tab", $rows_array))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function update_work_progress_flag($req_id, $flag){
        if($flag == 1){
            $this->db->set('req_initiate', 2);
        }
        elseif($flag == 2){
            $this->db->set('req_progress_flag', 2);
        }
        elseif($flag == 3){
            $this->db->set('req_progress_flag', 4);
        }
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master")){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function get_previous_req_number(){
        $this->db->select_max('req_number');
        // $this->db->where('bedrijf_id', $bedrijf_id);
        $res = $this->db->get('requisition_master');

        if ($res->num_rows() > 0){
            $qry = $res->result_array();
            $req_num = $qry[0]['req_number'];
            return $req_num;
        }
        else{
            return false;
        }
    }

    public function get_all_from_requisition_master(){
        $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
        $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
        $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
		$this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_all_from_requisition_master_with_payment_tab(){
        $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name, work_payment_tab.*');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
        $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
        $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
        $this->db->join('work_payment_tab', 'work_payment_tab.wpay_master_req = requisition_master.req_id');
		$this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
        // echo '<pre>';
        // print_r($query->result());
        // exit;
		return $query->result();
    }


    public function get_all_from_requisition_master_with_condition($rpot_from_date, $rpot_to_date, $rpot_schm_id, $rpot_dist){
        $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
        $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
        $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
        if($rpot_schm_id != NULL){
            $this->db->where('req_scheme', $rpot_schm_id);
        }
        if($rpot_dist != NULL){
            $this->db->where('req_district', $rpot_dist);
        }
        $this->db->where('req_s_memo_date >=', $rpot_from_date);
        $this->db->where('req_s_memo_date <=', $rpot_to_date);
		$this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_all_from_requisition_master_with_payment_tab_with_condition($rpot_from_date, $rpot_to_date, $rpot_schm_id, $rpot_dist){
        $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name, work_payment_tab.*');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
        $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
        $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
        $this->db->join('work_payment_tab', 'work_payment_tab.wpay_master_req = requisition_master.req_id');
        if($rpot_schm_id != 0){
            $this->db->where('req_scheme', $rpot_schm_id);
        }
        if($rpot_dist != 0){
            $this->db->where('req_district', $rpot_dist);
        }
        $this->db->where('req_s_memo_date >=', $rpot_from_date);
        $this->db->where('req_s_memo_date <=', $rpot_to_date);
		$this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
		return $query->result();
    }


    public function check_for_valid_scheme($req_id){
        $this->db->select('req_number');
        $this->db->from('requisition_master');
        $this->db->where('req_id', $req_id);
        $query = $this->db->get();
        if(!empty($query->result())){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function get_photos1_by_id_from_work_progress_table($req_id){
        $this->db->select('wpt_doc');
		$this->db->from('work_progress_tab');
		$this->db->where('wpt_req_master', $req_id);
        $this->db->where('wpt_flag', 1);
        $this->db->order_by('wpt_id','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_photos2_by_id_from_work_progress_table($req_id){
        $this->db->select('wpt_doc');
		$this->db->from('work_progress_tab');
		$this->db->where('wpt_req_master', $req_id);
        $this->db->where('wpt_flag', 2);
        $this->db->order_by('wpt_id','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function get_photos3_by_id_from_work_progress_table($req_id){
        $this->db->select('wpt_doc');
		$this->db->from('work_progress_tab');
		$this->db->where('wpt_req_master', $req_id);
        $this->db->where('wpt_flag', 3);
        $this->db->order_by('wpt_id','ASC');
		$query = $this->db->get();
		return $query->result();
    }

    public function check_userdistcode_schemedistcode_isequal($user_id, $req_id){
        $this->db->select('u_dist');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        //=========================================
        if(!empty($user_dist_code->u_dist)){
            $this->db->select('req_number');
            $this->db->from('requisition_master');
            $this->db->where('req_id', $req_id);
            $this->db->where('req_district', $user_dist_code->u_dist);
            $query = $this->db->get();
            if(!empty($query->result())){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    public function check_atleast_one_photo_existence($req_id, $upload_flag, $user_id){
        $this->db->select('u_dist');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        //=========================================
        if(!empty($user_dist_code->u_dist)){
            $this->db->select('wpt_id');
            $this->db->from('work_progress_tab');
            $this->db->where('wpt_req_master', $req_id);
            $this->db->where('wpt_flag', $upload_flag);
            // $this->db->where('req_district', $user_dist_code->u_dist);
            $query = $this->db->get();
            if(!empty($query->result())){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    public function get_work_progress_details($req_id, $upload_flag, $user_id){
        $this->db->select('u_dist');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        //=========================================
        if(!empty($user_dist_code->u_dist)){
            $this->db->select('wpt_id,wpt_req_master,wpt_doc,wpt_flag,wpt_title,wpt_latitude,wpt_longitude,wpt_createby,wpt_createdate,wpt_status');
            $this->db->from('work_progress_tab');
            $this->db->where('wpt_req_master', $req_id);
            $this->db->where('wpt_flag', $upload_flag);
            // $this->db->where('req_district', $user_dist_code->u_dist);
            $query = $this->db->get();
            if(!empty($query->result())){
                return $query->result();
            }
            else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }
    }

    public function get_all_scheme_id_array($user_id){
        $this->db->select('u_block');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_block_code = $query1->row();
        //=========================================
        if(!empty($user_block_code->u_block)){
            $this->db->select('req_id');
            $this->db->from('requisition_master');
            $this->db->where('req_block', $user_block_code->u_block);
            $query = $this->db->get();
            return $query->result();
        }
        else{
            return FALSE;
        }
    }

    public function delete_work_progress_by_id($scm_req_id, $scm_upload_flag, $scm_work_progress_id){
        $this->db->delete('work_progress_tab', array('wpt_req_master' => $scm_req_id, 'wpt_flag' => $scm_upload_flag, 'wpt_id' => $scm_work_progress_id));
        if($this->db->affected_rows()){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function check_userblockcode_schemeblockcode_isequal($user_id, $req_id){
        $this->db->select('u_block');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        // echo $user_dist_code->u_block;
        // exit;
        //=========================================
        if(!empty($user_dist_code->u_block)){
            $this->db->select('req_number');
            $this->db->from('requisition_master');
            $this->db->where('req_id', $req_id);
            $this->db->where('req_block', $user_dist_code->u_block);
            $query = $this->db->get();
            if(!empty($query->result())){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    public function get_all_from_requisition_master_by_user_id($user_id){
        $this->db->select('u_dist, u_block');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        //=========================================
        if(!empty($user_dist_code->u_dist) && !empty($user_dist_code->u_block)){
            $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name');
            $this->db->from('requisition_master');
            $this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
            $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
            $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
            $this->db->where('requisition_master.req_district', $user_dist_code->u_dist);
            $this->db->where('requisition_master.req_block', $user_dist_code->u_block);
            $this->db->order_by('requisition_master.req_id DESC');
            $query = $this->db->get();
            return $query->result();
        }
    }


    public function get_all_from_requisition_master_by_user_id_for_app_api($user_id){
        $this->db->select('u_dist, u_block');
		$this->db->from('user_info');
        $this->db->where('u_id', $user_id);
		$query1 = $this->db->get();
		$user_dist_code = $query1->row();
        //=========================================
        if(!empty($user_dist_code->u_dist) && !empty($user_dist_code->u_block)){
            $this->db->select('requisition_master.req_id, requisition_master.req_number, requisition_master.req_initiate, requisition_master.req_progress_flag, scheme_master.scm_name');
            $this->db->from('requisition_master');
            $this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
            $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
            $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
            $this->db->where('requisition_master.req_district', $user_dist_code->u_dist);
            $this->db->where('requisition_master.req_block', $user_dist_code->u_block);
            $this->db->order_by('requisition_master.req_id DESC');
            $query = $this->db->get();
            return $query->result();
        }
    }



    public function get_data_by_id_from_requisition_table($requisition_id){
        $this->db->select('requisition_master.*, scheme_master.scm_name, district_master.district_name, block_master.block_name');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'scheme_master.scm_id = requisition_master.req_scheme');
        $this->db->join('district_master', 'district_master.district_code = requisition_master.req_district');
        // $this->db->join('subdivision_tab', 'subdivision_tab.subdiv_id = requisition_master.req_s_division');
        $this->db->join('block_master', 'block_master.block_id = requisition_master.req_block');
		$this->db->where('requisition_master.req_id', $requisition_id);
		// $this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
		return $query->row();
    }

    public function get_last_row_by_id_from_requisition_progress_table($requisition_id){
        $this->db->select('*');
		$this->db->from('requisition_progress');
		$this->db->where('reqp_master_req', $requisition_id);
		$this->db->order_by('reqp_id DESC');
        $this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_requisition_number_by_req_id($req_id){
        $this->db->select('req_number');
		$this->db->from('requisition_master');
        $this->db->where('req_id', $req_id);
		$query = $this->db->get();
		$req_number_row = $query->row();
        return $req_number_row->req_number;
    }

    public function dm_initiate_data_update($row_arr, $req_id){
        $this->db->set($row_arr);
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master",$row_arr)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function update_initiate_status($req_id){
        $this->db->set('req_initiate', 1);
        $this->db->set('req_initiate_date', date('Y-m-d H:i:s'));
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master")){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function update_requisition_approval($req_id, $req_approval, $req_approval_msg){
        $this->db->set('req_approval', $req_approval);
        $this->db->set('req_approval_date', date('Y-m-d H:i:s'));
        $this->db->set('req_approval_msg', $req_approval_msg);
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master")){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function select_rejection_reason($req_id){
        $this->db->select('req_approval_msg');
		$this->db->from('requisition_master');
        $this->db->where('req_id', $req_id);
		$query = $this->db->get();
		$user_dist_code = $query->row();
        if(!empty($user_dist_code->req_approval_msg)){
            return $user_dist_code->req_approval_msg;
        }
        else{
            return false;
        }
    }

   
    public function get_installment_details($req_id){
        $this->db->select('scheme_details.scd_inst_no, scheme_details.scd_percent_work, scheme_details.scd_percent_amount');
		$this->db->from('requisition_master');
		$this->db->join('scheme_master', 'requisition_master.req_scheme = scheme_master.scm_id', 'left');
        $this->db->join('scheme_details', 'requisition_master.req_scheme = scheme_details.scd_master_scm', 'left');
		$this->db->where('requisition_master.req_id', $req_id);
		$this->db->order_by('requisition_master.req_id DESC');
		$query = $this->db->get();
        // echo '<pre>';
        // print_r($query->result());
        // exit;
		return $query->result();
    }

    public function get_payment_details($req_id){
        $this->db->select('*');
		$this->db->from('work_payment_tab');
		$this->db->where('wpay_master_req', $req_id);
        $this->db->order_by('wpay_master_req','ASC');
		$query = $this->db->get();
        // echo '<pre>';
        // print_r($query->result());
        // echo count($query->result());
        // exit;
		return $query->result();
    }

    public function get_1st_payment_details($req_id){
        $this->db->select('*');
		$this->db->from('work_payment_tab');
		$this->db->where('wpay_master_req', $req_id);
        $this->db->where('wpay_installment_no', 1);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_2nd_payment_details($req_id){
        $this->db->select('*');
		$this->db->from('work_payment_tab');
		$this->db->where('wpay_master_req', $req_id);
        $this->db->where('wpay_installment_no', 2);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_final_payment_details($req_id){
        $this->db->select('*');
		$this->db->from('work_payment_tab');
		$this->db->where('wpay_master_req', $req_id);
        $this->db->where('wpay_installment_no', 3);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_requisition_progress_details($req_id){
        $this->db->select('*');
		$this->db->from('requisition_progress');
		$this->db->where('reqp_master_req', $req_id);
		$query = $this->db->get();
		return $query->row();
    }

    public function installment_payment_insert($row_arr){
        if($this->db->insert("work_payment_tab", $row_arr))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function work_order_submit_insert($row_arr){
        if($this->db->insert("requisition_progress", $row_arr))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function work_completion_submit_update($row_arr, $req_id){
        $this->db->set($row_arr);
		$this->db->where('reqp_master_req', $req_id);
		if($this->db->update("requisition_progress", $row_arr)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function update_progress_flag($progress_flag, $req_id){
        $this->db->set('req_progress_flag', $progress_flag);
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master")){
			return TRUE;
		}else{
			return FALSE;
		}
    }
    
    public function update_payment_approval_flag($approval_status, $req_id){
        $this->db->set('req_approval', $approval_status);
		$this->db->where('req_id', $req_id);
		if($this->db->update("requisition_master")){
			return TRUE;
		}else{
			return FALSE;
		}
    }


}


