<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Movement extends Admin_Controller {
	
	 public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->data['ssstr_arr'] = array(
			'fu_dob','fu_address','fu_photo_doc','fu_signature_doc','fu_caste','fu_pwd','fu_exempted','fu_exservice','fu_ews','fu_age_relax','fu_es_qualification','fu_ds_qualification','fu_has_es_service','fu_has_ds_service'
		);
        $this->load->model('candidates_m');
    }
	
    public function index() {
		redirect('admincontrol/movement/gotoset_candidate_marks_tablewise');
    }

	public function gotoset_candidate_marks_tablewise(){
		if($_POST){
			
			//print_r($_POST);exit;
			/*$advno = $this->input->post("advno");
			$rf_set = $this->input->post("rf_set");
			$advcat_name = $this->input->post("advcat_name");
			$u_startdate = $this->input->post('u_startdate');
			$venueno = $this->input->post("venueno");
			$shift_name = $this->input->post("shift_name");
			$table_exactno = $this->input->post("table_exactno");
			
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
			$this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
			  $this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'venueno'=>$venueno, 'advcat_name'=>$advcat_name, 'shift_name'=>$shift_name, 'table_exactno'=>$table_exactno);
					  $this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
			  $this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
			  $this->data['shift_details'] = $this->candidates_m->getAll_FindShift_Interview_list($venueno, $u_startdate);
			  $this->data['shifttab_details'] = $this->candidates_m->getDetails_forAllTable_shiftwise_check($advno, $advcat_name, $shift_name);
			  $this->data['total_checkinglist'] = $this->candidates_m->getDetails_forInterviewPanel_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno);
			  if(count($this->data['total_checkinglist']) == 0){
				$this->data['error'] = "No Candidate Found as per Searching. Check Again.";
			  }
			}*/
			
		}
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
      	$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
		//print_r($this->data['shifttab_details']);exit;
		$this->load->view('admin/move/inteview_marks_insert_list', $this->data);
	}

	public function get_tablecandidates_details(){
		if($_POST){
		  	//print_r($_POST);exit;
			$advno = $this->input->post("advno");
			$advcat_name = $this->input->post("advcat_name");
			$u_startdate = $this->input->post('u_startdate');
			$venueno = $this->input->post("venueno");
			$shift_name = $this->input->post("shift_name");
			$table_exactno = $this->input->post("table_exactno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
			$this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
			
				$result_details = $this->candidates_m->getDetails_forInterviewNo_insert_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno);
				if(count((array)$result_details) > 0){
					$exact_adv_detail = $this->db->where('adv_auto_genno',$advno)->get('advertisement_master')->row()->adv_dictation_set;
				echo json_encode(array('msg' => 1, 'op_set' => $result_details, 'adv_check' => $exact_adv_detail));
				}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Candidates Not Found'));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
		  	exit;
		}else{
		  redirect('default404');
		}
	}

	public function get_tablecandidates_details_chk2(){
		if($_POST){
		  	//print_r($_POST);exit;
			$advno = $this->input->post("advno");
			$advcat_name = $this->input->post("advcat_name");
			$u_startdate = $this->input->post('u_startdate');
			$venueno = $this->input->post("venueno");
			$shift_name = $this->input->post("shift_name");
			$table_exactno = $this->input->post("table_exactno");
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
			$this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
			
			if($this->form_validation->run() == TRUE) {
			
				$result_details = $this->candidates_m->getDetails_forInterviewNo_insert_Candidate_tablewise_chk2($advno, $advcat_name, $shift_name, $table_exactno);
				if(count((array)$result_details) > 0){
				echo json_encode(array('msg' => 1, 'op_set' => $result_details));
				}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Candidates Not Found for Approval'));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
		  	exit;
		}else{
		  redirect('default404');
		}
	}

	public function update_tablecandidates_marks(){
		if($_POST){
			//print_r($_POST);exit;
			$advno = $this->input->post("advno");
			$advcat_name = $this->input->post("advcat_name");
			$u_startdate = $this->input->post('u_startdate');
			$venueno = $this->input->post("venueno");
			$shift_name = $this->input->post("shift_name");
			$table_exactno = $this->input->post("table_exactno");

			$intvsetid = $this->input->post('intvsetid');
			$intvregno = $this->input->post('intvregno');
			$invw_atten = $this->input->post('invw_atten');
			$invw_lang = $this->input->post('invw_lang');
			$invw1 = $this->input->post('invw1');
			$invw2 = $this->input->post('invw2');
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
			$this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');

			$this->form_validation->set_rules('intvsetid[]', 'Interview ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('intvregno[]', 'Interview RagNo.', 'trim|required');
			$this->form_validation->set_rules('invw_atten[]', 'Interview Attendance', 'trim|required');
			$this->form_validation->set_rules('invw_lang[]', 'Language Knowledge', 'trim|required');
			$this->form_validation->set_rules('invw1[]', 'Interview 1 Marks', 'trim|required');
			$this->form_validation->set_rules('invw2[]', 'Interview 2 Marks', 'trim|required');
			
			if($this->form_validation->run() == TRUE) {
				$result_details = $this->candidates_m->getDetails_forInterviewNo_insert_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno);
				if(count((array)$result_details) > 0){
					$error_finder = 0;
					$error_string = '';
					for($i=0;$i<count((array)$result_details);$i++){
						$row_array = array(
							'invw_attendance' => $invw_atten[$i],
							'invw_mark_createdate' => date('Y-m-d H:i:s'),
							'invw_mark_createby' => $this->session->userdata('uid')
						);
						$row_array2 = array(
							'cr_language_known' => NULL,
							'cr_interview_2_date' => date('Y-m-d H:i:s')
						);

						if($invw_atten[$i] == 'Yes'){
							$row_array['invw_language'] = $invw_lang[$i];
							$row_array['invw_marks_1'] = $invw1[$i];
							$row_array['invw_marks_2'] = $invw2[$i];

							$row_array2['cr_language_known'] = $invw_lang[$i];
							$row_array2['cr_interview_1'] = $invw1[$i];
							$row_array2['cr_interview_2'] = $invw2[$i];
						}
						if($this->candidates_m->getUpdates_forInterviewmarks_insertions($row_array, $row_array2, $intvsetid[$i], $intvregno[$i]) == FALSE){
							$error_finder++;
							$error_string = $error_string.'Problem to Update in Candidate RegNo - '.$intvregno[$i].'<br/>';
						}
					}
					if($error_finder == 0){
						echo json_encode(array('msg' => 1, 'op_set' => ''));
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => $error_string));
					}
				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidates Not Found'));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
				exit;
		}else{
			redirect('default404');
		}
	}

	public function finalcheck_for_interviewmarks_bychecker(){
		if($_POST){
			
		}
		$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
      	$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
		//print_r($this->data['shifttab_details']);exit;
		$this->load->view('admin/move/inteview_marks_approval_list', $this->data);
	}
	
	public function checker2_approvalsection_modification(){
		if($_POST){
			//print_r($_POST);exit;
			$canddoc_id = $this->input->post("canddoc_id");
			$canddoc_type = $this->input->post("canddoc_type");
			$canddoc_regno = $this->input->post("canddoc_regno");
			$retn_comment = $this->input->post("retn_comment");

			$this->form_validation->set_rules('canddoc_id', 'Interview ID', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('canddoc_type', 'Approval Type', 'trim|required');
			$this->form_validation->set_rules('canddoc_regno', 'Candidate RegNo.', 'trim|required');
			if($canddoc_type == "R"){
				$this->form_validation->set_rules('retn_comment', 'Comments', 'trim|required');
			}

			if($this->form_validation->run() == TRUE) {
				$result_details = $this->db->get_where('candidate_result_tab',array('cr_application_master'=>$canddoc_regno))->row();
				if(count((array)$result_details) > 0){
					//$error_finder = 0;
					//$error_string = '';
					$row_array = array(
						'invw_approve_date' => date('Y-m-d H:i:s'),
						'invw_approve_by' => $this->session->userdata('uid')
					);
					$row_array2 = array(
						'cr_interview_2_date' => date('Y-m-d H:i:s')
					);
					
					if($canddoc_type == "R"){
						$canddoc_type = "Return";
						$row_array['invw_approval'] = $canddoc_type;
						$row_array['invw_msg_return'] = $retn_comment;
					}else{
						$result_intw = $this->db->get_where('interview_tab',array('invw_id'=>$canddoc_id,'invw_cand_regno'=>$canddoc_regno))->row();
						$canddoc_type = "Yes";
						$row_array['invw_approval'] = $canddoc_type;
						$row_array2['cr_total_marks'] = $result_details->cr_academic + $result_details->cr_experience + $result_details->cr_interview_1 + $result_details->cr_interview_2;
						if($result_intw->invw_attendance == "No"){
							$row_array2['cr_approval'] = 'Rejected';
							$row_array2['cr_reject_comments'] = 'Candidate was Absent at the time of Interview.';
						}else{
							if($result_intw->invw_attendance == "Yes" && $result_intw->invw_language == "No"){
								$row_array2['cr_approval'] = 'Rejected';
								$row_array2['cr_reject_comments'] = 'Candidate does not know required language(s).';
							}
						}
					}						
					if($this->candidates_m->getUpdates_forInterviewmarks_insertions($row_array, $row_array2, $canddoc_id, $canddoc_regno) == TRUE){
						echo json_encode(array('msg' => 1, 'op_set' => ''));
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => 'Problem to Update in Candidate Interview Marks, try Again'));
					}
				}else{
					echo json_encode(array('msg' => 0, 'e_msg' => 'Candidates Data Not Found'));
				}
				
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}else{
			redirect('default404');
		}
	}

	public function getall_return_marksmodification_list(){
		if($_POST){
			
		}
		/*$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
      	$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();*/
		//print_r($this->data['shifttab_details']);exit;
		$this->data['return_listset'] = $this->candidates_m->getAll_returnMarks_Candidates_interview('C1', $this->session->userdata['uid']);
		//print_r($this->data['return_listset']);exit;
		$this->load->view('admin/move/inteview_marks_return_list', $this->data);
	}

	public function modify_returndata_inthecheckerend($intv_id = NULL){
		if($intv_id == NULL){
			redirect('admincontrol/movement/getall_return_marksmodification_list');
		}
		if($_POST){
			$intv_regno = $this->input->post('intv_regno');
			$atten_intv = $this->input->post('atten_intv');
			$intv_lang = $this->input->post('intv_lang');
			$intv1_mark = $this->input->post('intv1_mark');
			$intv2_mark = $this->input->post('intv2_mark');
			
			$this->form_validation->set_rules('intv_regno', 'Interview RagNo.', 'trim|required');
			$this->form_validation->set_rules('atten_intv', 'Interview Attendance', 'trim|required');
			$this->form_validation->set_rules('intv_lang', 'Language Knowledge', 'trim|required');
			$this->form_validation->set_rules('intv1_mark', 'Interview 1 Marks', 'trim|required');
			$this->form_validation->set_rules('intv2_mark', 'Interview 2 Marks', 'trim|required');
			
			if($this->form_validation->run() == TRUE) {

				//$result_details = $this->candidates_m->getDetails_forInterviewNo_insert_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno);
				
				$row_array = array(
					'invw_attendance' => $atten_intv,
					'invw_approval' => "Revert",
					'invw_mark_createdate' => date('Y-m-d H:i:s'),
					'invw_mark_createby' => $this->session->userdata('uid')
				);
				$row_array2 = array(
					'cr_language_known' => NULL,
					'cr_interview_2_date' => date('Y-m-d H:i:s')
				);

				if($atten_intv == 'Yes'){
					$row_array['invw_language'] = $intv_lang;
					$row_array['invw_marks_1'] = $intv1_mark;
					$row_array['invw_marks_2'] = $intv2_mark;

					$row_array2['cr_language_known'] = $intv_lang;
					$row_array2['cr_interview_1'] = $intv1_mark;
					$row_array2['cr_interview_2'] = $intv2_mark;
				}else if($atten_intv == 'No'){
					$row_array['invw_language'] = NULL;
					$row_array['invw_marks_1'] = NULL;
					$row_array['invw_marks_2'] = NULL;

					$row_array2['cr_language_known'] = NULL;
					$row_array2['cr_interview_1'] = NULL;
					$row_array2['cr_interview_2'] = NULL;
				}
				if($this->candidates_m->getUpdates_forInterviewmarks_insertions($row_array, $row_array2, $intv_id, $intv_regno) == TRUE){
					$this->session->set_flashdata("success","Candidate Interview Marks Updation is done Successfully.");
					redirect('admincontrol/movement/getall_return_marksmodification_list');
				}else{
					$this->session->set_flashdata("e_error","Candidate Marks Updation Failed, Try Again.");
					redirect('admincontrol/movement/getall_return_marksmodification_list');
				}
			}
		}
		$this->data['return_marks_detail'] = $marksdetail = $this->candidates_m->getdetails_formodify_Candidates_interview_marks('C1', $intv_id, $this->session->userdata['uid']);
		//$cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
		if(count((array)$marksdetail) == 0){
			$this->session->set_flashdata("e_error","Candidate Marks Data Not Found, Check Again.");
			redirect('admincontrol/movement/getall_return_marksmodification_list');
		}
		//$this->data['exact_adv_detail'] = $this->db->where('adv_auto_genno',$marksdetail->f_applied_for)->get('advertisement_master')->row()->adv_dictation_set;
		$this->load->view('admin/move/inteview_marks_return_modify', $this->data);
	}

	public function getall_revertset_marksmodification_list(){
		if($_POST){
			
		}
		/*$udetail_access = $this->data["u_details"]->u_access_area;
		$udetail_access_arr = explode(",",$udetail_access);
		if($udetail_access_arr[0] == "ALL"){$this->data['uaccess'] = $this->data['ssstr_arr'];}else{$this->data['uaccess'] = $udetail_access_arr;}
		$udetail_adv_access = $this->data["u_details"]->u_adv_access;
		$udetail_adv_access_arr = explode(",",$udetail_adv_access);
		$this->data['rec_list'] = $this->admin_m->getAll_CheckerAdv_ofActive_Advertisement($udetail_adv_access_arr);
      	$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();*/
		//print_r($this->data['shifttab_details']);exit;
		$this->data['return_listset'] = $this->candidates_m->getAll_returnMarks_Candidates_interview('C2', $this->session->userdata['uid']);
		//print_r($this->data['return_listset']);exit;
		$this->load->view('admin/move/inteview_marks_revert_list', $this->data);
	}

	public function modify_chk2_revertdata_inthecheckerend($intv_id = NULL){
		if($intv_id == NULL){
			redirect('admincontrol/movement/getall_revertset_marksmodification_list');
		}
		$this->data['return_marks_detail'] = $this->candidates_m->getdetails_formodify_Candidates_interview_marks('C2', $intv_id, $this->session->userdata['uid']);
		//$cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
		if(count($this->data['return_marks_detail']) == 0){
			$this->session->set_flashdata("e_error","Candidate Marks Data Not Found, Check Again.");
			redirect('admincontrol/movement/getall_revertset_marksmodification_list');
		}
		$this->load->view('admin/move/inteview_marks_revert_approval', $this->data);
	}

}
