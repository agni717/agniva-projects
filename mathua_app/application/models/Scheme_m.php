<?php

class Scheme_M extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function scheme_creation_add_form_submit($rows)
    {
        if($this->db->insert("scheme_master", $rows))
        {
            $scheme_id = $this->db->insert_id();
            return $scheme_id;
        }
        
    }

    public function scheme_creation_installment_allotment_add($installment_row_array)
    {
        if($this->db->insert("scheme_details", $installment_row_array))
        {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function update_scheme_status_to_lock_deactivated($rows, $rows2 = NULL, $scm_id){
        $this->db->set($rows);
		$this->db->where('scm_id', $scm_id);
		if($this->db->update("scheme_master",$rows)){
			
			// if($rows2 != NULL){
			// 	$this->db->set($rows2);
			// 	$this->db->where('amark_adv_master', $advno);
			// 	if($this->db->update("advertisement_marks",$rows2)){
			// 		return TRUE;
			// 	}else{
			// 		return FALSE;
			// 	}
			// }else{
				return TRUE;
			// }
		}else{
			return FALSE;
		}
    }

    public function update_scheme_status_to_unlock_activated($rows, $rows2 = NULL, $scm_id){
        $this->db->set($rows);
		$this->db->where('scm_id', $scm_id);
		if($this->db->update("scheme_master",$rows)){
			return TRUE;
		}else{
			return FALSE;
		}
    }

    public function get_scheme_details($scm_no){
        $this->db->select('*');
		$this->db->from('scheme_details');
		$this->db->where('scd_master_scm', $scm_no);
		$query = $this->db->get();
		return $query->result();
    }

    public function get_scheme_master($scm_no){
        $this->db->select('*');
		$this->db->from('scheme_master');
		$this->db->where('scm_id ', $scm_no);
		$query = $this->db->get();
		return $query->row();
    }

    public function get_all_active_scheme(){
        $this->db->select('*');
		$this->db->from('scheme_master');
		$this->db->where('scm_status', 1);
        $this->db->order_by('scm_name','ASC');
		$query = $this->db->get();
		return $query->result();
    }

}


?>