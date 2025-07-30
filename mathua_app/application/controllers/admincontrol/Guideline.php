<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guideline extends Admin_Controller {
	
	 public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
    
	}
	
    public function index() {
		redirect('admincontrol/guideline/guide_instruction_list');
    }
    
    public function guide_instruction_list(){
		$this->data['gi_list'] = $this->db->order_by('gi_id','DESC')->get_where('gudie_instruct_tab')->result();
		$this->load->view('admin/guideline/gi_list_view', $this->data);
	}
	
	public function add_new_guide_instruction(){
		if($_POST){
			$rec_type = $this->input->post("rec_type");
			$rec_order = $this->input->post("rec_order");
            $rec_title = $this->input->post("rec_title");
            $rec_details = $this->input->post("rec_details");
			
            $this->form_validation->set_rules('rec_type', 'Type', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('rec_order', 'Type', 'trim|is_natural');
			$this->form_validation->set_rules('rec_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('rec_details', 'Details', 'trim');
            
			if ($this->form_validation->run() == TRUE) {
                
				$filename = $_FILES['userfile']['name'];
				if(!empty($filename)){
					$this->load->library('upload');
					$this->load->library('image_lib');

					$config['upload_path'] =realpath('upload_file/guide_doc/'); 
					$config['allowed_types'] = 'pdf|PDF|docx|doc|jpg|png|jpeg|JPG|JPEG|PNG|mp4|MP4';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$config['file_name'] = $filename;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
				   
					if($this->upload->do_upload()){
						$upload_data = $this->upload->data();
						$newfile_name = $upload_data['file_name'];
						if(empty($rec_order)){$rec_order = 0;}
						$row = array(
							'gi_type' => $rec_type,
							'gi_title' => trim($rec_title),
							'gi_details' => trim($rec_details),
							'gi_source' => $newfile_name,
							'gi_order' => trim($rec_order),
							'gi_createdate' => date('Y-m-d H:i:s'),
							'gi_createby' => $this->session->userdata['uid']
						);
						
						if ($this->admin_m->allGuideline_Instruction_InsertUpdate($row) == TRUE)
						{
							$this->session->set_flashdata("success","Record is Inserted successfully.");
							redirect('admincontrol/guideline/guide_instruction_list','refresh');
						}
						else{
							$this->data["error"] = "There is an error to Insert DB. Please try again";
						}
					}else{
						$this->data['error']=$this->upload->display_errors();
					}

				}else{
					$this->data['error']= 'Please Select a Document, Chcek Agian.';
				}
				
            }
		}
		$this->load->view('admin/guideline/add_gi_view', $this->data);
	}
	
	public function lock_guide_instruction($gid = NULL){
		if($gid == NULL){
			redirect('admincontrol/guideline/guide_instruction_list');
		}
		$row_arr = array(
			'gi_status' => 0
		);
		if($this->admin_m->allGuideline_Instruction_InsertUpdate($row_arr, $gid) == TRUE)
		{
			$this->session->set_flashdata("success","Record is Locked successfully");
		    redirect('admincontrol/guideline/guide_instruction_list');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/guideline/guide_instruction_list');
		}
	}
	
	public function unlock_guide_instruction($gid = NULL){
		if($gid == NULL){
			redirect('admincontrol/guideline/guide_instruction_list');
		}
		$row_arr = array(
			'gi_status' => 1
		);
		if($this->admin_m->allGuideline_Instruction_InsertUpdate($row_arr, $gid) == TRUE)
		{
			$this->session->set_flashdata("success","Record is Unlocked successfully");
		    redirect('admincontrol/guideline/guide_instruction_list');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/guideline/guide_instruction_list');
		}
	}

	public function edit_guide_instruction($gid = NULL){
		if($gid == NULL){
			redirect('admincontrol/guideline/supplier_list');
		}
		if($_POST){
			$rec_type = $this->input->post("rec_type");
			$rec_order = $this->input->post("rec_order");
            $rec_title = $this->input->post("rec_title");
            $rec_details = $this->input->post("rec_details");
			
            $this->form_validation->set_rules('rec_type', 'Type', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('rec_order', 'Type', 'trim|is_natural');
			$this->form_validation->set_rules('rec_title', 'Title', 'trim|required');
            $this->form_validation->set_rules('rec_details', 'Details', 'trim');
			
			if ($this->form_validation->run() == TRUE) {
                	
				$filename = $_FILES['userfile']['name'];
				if(!empty($filename)){
					$this->load->library('upload');
					$this->load->library('image_lib');

					$config['upload_path'] =realpath('upload_file/guide_doc/'); 
					$config['allowed_types'] = 'pdf|PDF|docx|doc|jpg|png|jpeg|JPG|JPEG|PNG|mp4|MP4';
					$config['overwrite'] = FALSE;
					$config['remove_spaces'] = TRUE;
					$config['file_name'] = $filename;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
				   
					if($this->upload->do_upload()){
						$upload_data = $this->upload->data();
						$newfile_name = $upload_data['file_name'];
						if(empty($rec_order)){$rec_order = 0;}
						$exist_doc = $this->db->get_where('gudie_instruct_tab',array('gi_id'=>$gid))->row();
						$row = array(
							'gi_type' => $rec_type,
							'gi_title' => trim($rec_title),
							'gi_details' => trim($rec_details),
							'gi_source' => $newfile_name,
							'gi_order' => trim($rec_order),
							'gi_modifydate' => date('Y-m-d H:i:s'),
							'gi_modifyby' => $this->session->userdata['uid']
						);
						
						if($this->admin_m->allGuideline_Instruction_InsertUpdate($row, $gid) == TRUE)
						{
							unlink('upload_file/guide_doc/'.$exist_doc->gi_source);
							$this->session->set_flashdata("success","Record is Updated successfully.");
							redirect('admincontrol/guideline/guide_instruction_list','refresh');
						}
						else{
							$this->data["error"] = "There is an error to Update DB. Please try again";
						}
					}else{
						$this->data['error']=$this->upload->display_errors();
					}

				}else{
					
					if(empty($rec_order)){$rec_order = 0;}
					$row = array(
						'gi_type' => $rec_type,
						'gi_title' => trim($rec_title),
						'gi_details' => trim($rec_details),
						//'gi_source' => $newfile_name,
						'gi_order' => trim($rec_order),
						'gi_modifydate' => date('Y-m-d H:i:s'),
						'gi_modifyby' => $this->session->userdata['uid']
					);
					
					if($this->admin_m->allGuideline_Instruction_InsertUpdate($row, $gid) == TRUE)
					{
						$this->session->set_flashdata("success","Record is Updated successfully.");
						redirect('admincontrol/guideline/guide_instruction_list','refresh');
					}
					else{
						$this->data["error"] = "There is an error to Update DB. Please try again";
					}
						
				}	
					
				
				
            }
		}
		$this->data['gi_detail'] = $this->db->get_where('gudie_instruct_tab',array('gi_id'=>$gid))->row();
		$this->load->view('admin/guideline/edit_gi_view', $this->data);
	}
	

	
}
