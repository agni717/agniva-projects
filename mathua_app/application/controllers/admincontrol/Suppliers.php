<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suppliers extends Admin_Controller {
	
	 public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
    
	}
	
    public function index() {
		redirect('admincontrol/suppliers/supplier_list');
    }
    
    public function supplier_list(){
		$this->data['sp_list'] = $this->db->order_by('supp_id','DESC')->get_where('supplier_master')->result();
		$this->load->view('admin/supplier/sup_list_view', $this->data);
	}
	
	public function add_new_supplier(){
		if($_POST){
			$sp_name = $this->input->post("sp_name");
            $sp_com_name = $this->input->post("sp_com_name");
            $sp_mobile = $this->input->post("sp_mobile");
            $sp_email = $this->input->post("sp_email");
            $sp_address = $this->input->post("sp_address");
            $sp_bank = $this->input->post("sp_bank");
            $sp_ac_no = $this->input->post("sp_ac_no");
            $sp_ifsc = $this->input->post("sp_ifsc");
            
            $this->form_validation->set_rules('sp_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('sp_com_name', 'Company Name', 'trim');
			$this->form_validation->set_rules('sp_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
            $this->form_validation->set_rules('sp_email', 'Email ID', 'trim|valid_email');
            $this->form_validation->set_rules('sp_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('sp_bank', 'Bank Name', 'trim|required');
            $this->form_validation->set_rules('sp_ac_no', 'Account No.', 'trim|required|is_natural');
            $this->form_validation->set_rules('sp_ifsc', 'IFSC Code', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
                	//echo "1st";
				if($this->admin_m->check_supplier_mobile_exist($sp_mobile) == TRUE)
				{			
					date_default_timezone_set("Asia/Kolkata");
					
					$row = array(
							'supp_name' => trim($sp_name),
							'supp_company' => trim($sp_com_name),
							'supp_mobile' => $sp_mobile,
							'supp_email' => trim($sp_email),
							'supp_address' => trim($sp_address),
							'supp_bank' => trim($sp_bank),
							'supp_account_no' => trim($sp_ac_no),
							'supp_ifsc_code' => trim($sp_ifsc),
							'supp_createdate' => date('Y-m-d H:i:s'),
							'supp_createby' => $this->session->userdata['uid']
						);
						
					if ($this->admin_m->allSuppliers_InsertUpdate($row) == TRUE)
					{
						$this->session->set_flashdata("success","Supplier is Added successfully.");
						redirect('admincontrol/suppliers/supplier_list','refresh');
					}
					else{
						$this->data["error"] = "There is an error to Insert DB. Please try again";
					}
				}
				else
				{
					$this->data["error"] = "Mobile Number already Exist, please check it.";
				}
            }
		}
		$this->load->view('admin/supplier/add_supplier_view', $this->data);
	}
	
	public function lock_supplier($uid = NULL){
		if($uid == NULL){
			redirect('admincontrol/suppliers/supplier_list');
		}
		$row_arr = array(
			'supp_status' => 0
		);
		if($this->admin_m->allSuppliers_InsertUpdate($row_arr, $uid) == TRUE)
		{
			$this->session->set_flashdata("success","Supplier is Locked successfully");
		    redirect('admincontrol/suppliers/supplier_list');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/suppliers/supplier_list');
		}
	}
	
	public function unlock_supplier($uid = NULL){
		if($uid == NULL){
			redirect('admincontrol/suppliers/supplier_list');
		}
		$row_arr = array(
			'supp_status' => 1
		);
		if($this->admin_m->allSuppliers_InsertUpdate($row_arr, $uid) == TRUE)
		{
			$this->session->set_flashdata("success","Supplier is Unlocked successfully");
		    redirect('admincontrol/suppliers/supplier_list');
		}
		else
		{
			$this->session->set_flashdata("e_error","There is some Problem. Please try again.");
		    redirect('admincontrol/suppliers/supplier_list');
		}
	}

	public function edit_supplier($uid = NULL){
		if($uid == NULL){
			redirect('admincontrol/suppliers/supplier_list');
		}
		if($_POST){
			$sp_name = $this->input->post("sp_name");
            $sp_com_name = $this->input->post("sp_com_name");
            $sp_mobile = $this->input->post("sp_mobile");
            $sp_email = $this->input->post("sp_email");
            $sp_address = $this->input->post("sp_address");
            $sp_bank = $this->input->post("sp_bank");
            $sp_ac_no = $this->input->post("sp_ac_no");
            $sp_ifsc = $this->input->post("sp_ifsc");
            
            $this->form_validation->set_rules('sp_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('sp_com_name', 'Company Name', 'trim');
			$this->form_validation->set_rules('sp_mobile', 'Mobile No.', 'trim|required|exact_length[10]|is_natural');
            $this->form_validation->set_rules('sp_email', 'Email ID', 'trim|valid_email');
            $this->form_validation->set_rules('sp_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('sp_bank', 'Bank Name', 'trim|required');
            $this->form_validation->set_rules('sp_ac_no', 'Account No.', 'trim|required|is_natural');
            $this->form_validation->set_rules('sp_ifsc', 'IFSC Code', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
                	//echo "1st";
				if($this->admin_m->check_supplier_mobile_exist($sp_mobile, $uid) == TRUE)
				{			
					date_default_timezone_set("Asia/Kolkata");
					
					$row = array(
							'supp_name' => trim($sp_name),
							'supp_company' => trim($sp_com_name),
							'supp_mobile' => $sp_mobile,
							'supp_email' => trim($sp_email),
							'supp_address' => trim($sp_address),
							'supp_bank' => trim($sp_bank),
							'supp_account_no' => trim($sp_ac_no),
							'supp_ifsc_code' => trim($sp_ifsc),
							'supp_modifydate' => date('Y-m-d H:i:s'),
							'supp_modifyby' => $this->session->userdata['uid']
						);
						
					if($this->admin_m->allSuppliers_InsertUpdate($row, $uid) == TRUE)
					{
						$this->session->set_flashdata("success","Supplier Details is Updated successfully.");
						redirect('admincontrol/suppliers/supplier_list','refresh');
					}
					else{
						$this->data["error"] = "There is an error to Insert DB. Please try again";
					}
				}
				else
				{
					$this->data["error"] = "Mobile Number already Exist, please check it.";
				}
            }
		}
		$this->data['sp_detail'] = $this->db->get_where('supplier_master',array('supp_id'=>$uid))->row();
		$this->load->view('admin/supplier/edit_supplier_view', $this->data);
	}
	

	
}
