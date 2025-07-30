<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Discussion extends Admin_Controller {
	
	 public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
        $this->load->model('main_m');
        $this->load->model('admin_m');
    }
	
    public function index() {
		redirect('admincontrol/discussion/all_query_list');
    }
    
    public function all_query_list(){
		$this->data['q_list'] = $this->admin_m->getAll_discussion_byUser_fromDB();
		$this->load->view('admin/forum/query_list_view', $this->data);
	}
	
	public function getinfo_fromquery_no(){
		if($_POST){
			$q_no = $this->input->post('q_no');
			$msg = 0;
			$this->form_validation->set_rules('q_no', 'Query Number', 'trim|required');
			
			if($this->form_validation->run() == TRUE)
            {
				$response_info = $this->admin_m->getAll_discussion_byUser_fromDB($q_no);

				if(count((array)$response_info) > 0){
					echo json_encode(array('msg'=>1, 'info_set' => $response_info));
				}else{
					echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some problem to retrieve Data, Try again.'));
				}
			}else{
				echo json_encode(array('msg'=>$msg, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	public function update_reply_against_query(){
		if($_POST){
			$this->load->model('member_m');
			$reply_comment = $this->input->post('reply_comment');
			$query_no = $this->input->post('query_no');
			$msg = 0;
			$this->form_validation->set_rules('reply_comment', 'Reply', 'trim|required');
			$this->form_validation->set_rules('query_no', 'Query No', 'trim|required');
			
			if($this->form_validation->run() == TRUE)
            {
				
				$row_array = array(
					'query_reply_details' => $reply_comment,
					'query_is_reply' => 1,
					'query_reply_date' => date('Y-m-d H:i:s')
				);
				if(count($_FILES) > 0){
					$filename = $_FILES['files']['name'];
					if(!empty($filename)){
						$this->load->library('upload');
						$this->load->library('image_lib');
						
						$config['upload_path'] = realpath('upload_file/forum_doc/reply/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF|txt|doc|docx|xls|xlsx|ppt|pptx|mp4|MP4';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '11000';
						$config['file_name'] = $filename;
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						
						if($this->upload->do_upload('files')){
						
							$upload_data = $this->upload->data();
							$row_array['query_reply_attach'] = $upload_data['file_name'];
							
							if($this->member_m->addform_against_UserQuery_inDB($row_array, $query_no) == TRUE){
								echo json_encode(array('msg'=>1));
							}else{
								echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some problem to Update Data, Try again.'));
							}
							
						}else{
							echo json_encode(array('msg'=>$msg, 'e_msg'=>$this->upload->display_errors()));
						}
					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'File Not Upload properly, Check again.'));
					}
				}else{
					if($this->member_m->addform_against_UserQuery_inDB($row_array, $query_no) == TRUE){
						echo json_encode(array('msg'=>1));
					}else{
						echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some problem to Update Data, Try again.'));
					}
				}
			}else{
				echo json_encode(array('msg'=>$msg, 'e_msg'=>validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function publish_toall($query_no = NULL){
		if($query_no == NULL){
			redirect('admincontrol/discussion/all_query_list');
		}
		$this->load->model('member_m');
		$row_array = array(
			'query_publish' => 1
		);
		if($this->member_m->addform_against_UserQuery_inDB($row_array, $query_no) == TRUE){
			$this->session->set_flashdata("success","Query is published successfully.");
			redirect('admincontrol/discussion/all_query_list');
		}else{
			$this->session->set_flashdata("e_error","There have some problem to Update DB, Try Again.");
			redirect('admincontrol/discussion/all_query_list');
		}
	}
	
	public function hide_toall($query_no = NULL){
		if($query_no == NULL){
			redirect('admincontrol/discussion/all_query_list');
		}
		$this->load->model('member_m');
		$row_array = array(
			'query_publish' => 0
		);
		if($this->member_m->addform_against_UserQuery_inDB($row_array, $query_no) == TRUE){
			$this->session->set_flashdata("success","Query is hidden successfully.");
			redirect('admincontrol/discussion/all_query_list');
		}else{
			$this->session->set_flashdata("e_error","There have some problem to Update DB, Try Again.");
			redirect('admincontrol/discussion/all_query_list');
		}
	}
	
	
	protected function generateRandomString($length = 4){
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	



}
