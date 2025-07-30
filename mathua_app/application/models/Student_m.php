<?php



class Student_m extends CI_Model {


	public function student_list($id = NULL){
		$this->db->select('student_details.*');
		$this->db->select('student_information.*');
		$this->db->from('student_information');
		$this->db->join('student_details','student_information.student_id  = student_details.std_master_id');
		if($id != NULL){
			$this->db->where('student_information.student_id ',$id);
			$pri =$this->db->get()->row();
			
		}else{

			$this->db->Order_by('student_create_time','desc');
			$this->db->where('student_information.student_status',1);
			$pri =$this->db->get()->result();
		}
		return $pri;
		
	}


}

