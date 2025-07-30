<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Scheme_set extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->load->model('admin_m');
		$this->load->model('scheme_m');
	}

	public function index()
	{
		redirect('admincontrol/scheme_set/all_scheme_list');
	}

	public function all_scheme_list()
	{
		if($this->data["u_details"]->u_type > 2){
			redirect('admincontrol/dashboard');
		}
		// $this->data['scm_list'] = $this->db->order_by('scm_id', 'DESC')->where('scm_status', 1)->get('scheme_master')->result();
		$this->data['scm_list'] = $this->db->order_by('scm_id', 'DESC')->get('scheme_master')->result();
		$this->load->view('admin/scheme/scheme_list_view', $this->data);
	}

	public function scheme_details($scm_no = NULL)
	{
		if($this->data["u_details"]->u_type != 1){
			if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
				redirect('admincontrol/dashboard');
			}
		}
		if ($adv_no == "" || $adv_no == NULL) {
			redirect('admincontrol/advertisement_set/all_advertisement_list');
		}
		//$this->data['adv_list'] = $this->db->order_by('adv_id','DESC')->get('advertisement_master')->result();
		$this->data['adv_list'] = $this->admin_m->getAll_detaillist_of_Avvertisement($adv_no);
		$this->data['cats_list'] = $this->db->order_by('caste_cat ASC, caste_id ASC')->where_in('caste_cat',array(1,2,3,4,5,6))->get('caste_tab')->result();
		$this->data['allcats_list'] = $this->db->order_by('caste_name ASC')->get('caste_tab')->result();
		$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($adv_no);
		$this->data['q_list'] = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no);
		$this->data['qdetail_list'] = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no);
		$this->data['qdeduct_list'] = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no);
		$this->data['exp_list'] = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no);
		$this->data['expdetail_list'] = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no);
		$this->data['agefee_list'] = $this->admin_m->getAll_AgeFee_detaillist_of_Advertisement($adv_no);
		$this->load->view('admin/adv/advertisement_details_view', $this->data);
	}

	// public function lock_scheme_set($scm_no = NULL)
	// {
	// 	if($this->data["u_details"]->u_type != 1){
	// 		if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
	// 			redirect('admincontrol/dashboard');
	// 		}
	// 	}
	// 	if ($scm_no == "" || $scm_no == NULL) {
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list');
	// 	}
	// 	$row_arr = array(
	// 		'adv_status' => 0,
	// 		'adv_activated' => 0
	// 	);
	// 	if ($this->admin_m->upDateform_against_Advertisement_inDB($row_arr, NULL, $scm_no) == TRUE) {
	// 		$this->session->set_flashdata("success", "Advertisement is Locked & Deactivated successfully.");
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list', 'refresh');
	// 	} else {
	// 		$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list', 'refresh');
	// 	}
	// }

	// public function unlock_scheme_set($scm_no = NULL)
	// {
	// 	if($this->data["u_details"]->u_type != 1){
	// 		if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
	// 			redirect('admincontrol/dashboard');
	// 		}
	// 	}
	// 	if ($scm_no == "" || $scm_no == NULL) {
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list');
	// 	}
	// 	$row_arr = array(
	// 		'adv_status' => 1
	// 	);
	// 	if ($this->admin_m->upDateform_against_Advertisement_inDB($row_arr, NULL, $scm_no) == TRUE) {
	// 		$this->session->set_flashdata("success", "Advertisement is Unlocked successfully.");
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list', 'refresh');
	// 	} else {
	// 		$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
	// 		redirect('admincontrol/advertisement_set/all_advertisement_list', 'refresh');
	// 	}
	// }

	public function modify_scheme($adv_no = NULL)
	{
		if($this->data["u_details"]->u_type != 1){
			if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
				redirect('admincontrol/dashboard');
			}
		}
		if ($adv_no == "" || $adv_no == NULL) {
			redirect('admincontrol/advertisement_set/all_advertisement_list');
		}
		$this->data['adv_list'] = $this->admin_m->getAll_detaillist_of_Avvertisement($adv_no);
		$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($adv_no);
		$this->data['q_list'] = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($adv_no);
		//$this->data['last_q_detail'] = $this->admin_m->getAll_prevRecord_forQualification($adv_no);
		$this->data['qdetail_list'] = $this->admin_m->getAll_DetailsQuali_of_Advertisement($adv_no);
		$this->data['qdeduct_list'] = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($adv_no);
		$this->data['exp_list'] = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($adv_no);
		$this->data['expdetail_list'] = $this->admin_m->getAll_DetailsExpr_of_Advertisement($adv_no);
		$this->data['agefee_list'] = $this->admin_m->getAll_AgeFee_detaillist_of_Advertisement($adv_no);
		$this->data['rec_list'] = $this->db->order_by('rm_name', 'ASC')->get('recruitment_master_tab')->result();
		$this->data['desp_list'] = $results = $this->db->order_by('catm_name', 'ASC')->where('catm_master', $this->data['adv_list']->adv_recruit_master)->where('catm_status', 1)->get('category_master')->result();
		if (count((array)$results) == 0) {
			$this->data['desp_list'] = $this->db->order_by('catm_name', 'ASC')->where('catm_master', NULL)->where('catm_status', 1)->get('category_master')->result();
		}
		//$this->data['cats_list'] = $this->db->order_by('caste_id', 'ASC')->get('caste_tab')->result();
		$this->data['cats_list'] = $this->db->order_by('caste_cat ASC, caste_id ASC')->where_in('caste_cat',array(1,2,3,4,5,6))->get('caste_tab')->result();
		$this->data['allcats_list'] = $this->db->order_by('caste_name ASC')->get('caste_tab')->result();
		$this->data['expr_list'] = $this->db->order_by('expset_name', 'ASC')->where('expset_status', 1)->get('experience_master_tab')->result();
		$this->data['qualification_list'] = $this->db->order_by('qm_name', 'ASC')->where('(qm_r_master = ', $this->data['adv_list']->adv_recruit_master)->or_where('qm_r_master is NULL)')->where('qm_status', 1)->get('qualification_master')->result();

		$this->data['endage_detail'] = $this->db->order_by('advage_id', 'DESC')->where('advage_adv_master',$adv_no)->get('advertisement_age_set')->row();
		$this->data['endquali_detail'] = $this->db->order_by('aquali_id', 'DESC')->where('aquali_adv_master',$adv_no)->get('advertisement_qualification')->row();
		$this->data['endexpr_detail'] = $this->db->order_by('aexpr_id', 'DESC')->where('aexpr_adv_master',$adv_no)->get('advertisement_experience')->row();
		$this->load->view('admin/adv/edit_advertisement_view', $this->data);
	}

	public function update_advertisement_submission()
	{
		if ($_POST) {

			//$exam_gen = $this->input->post("exam_gen");
			$adv_no = $this->input->post("adv_no");
			$adv_category = $this->input->post("adv_category");
			$adv_qualification = $this->input->post("adv_qualification");
			$adv_experience = $this->input->post("adv_experience");
			$r_for = $this->input->post("r_for");
			$adv_name = $this->input->post("adv_name");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			$adv_dicta = $this->input->post("adv_dicta");
			$adv_typeset = $this->input->post("adv_typeset");
			$old_startdate = $this->input->post('old_startdate');
			$old_enddate = $this->input->post('old_enddate');
			$old_starttime = $this->input->post('old_starttime');
			$old_endtime = $this->input->post('old_endtime');

			$scale_pay = $this->input->post('scale_pay');
			$total_vacency = $this->input->post('total_vacency');
			$minimum_age = $this->input->post('minimum_age');
			$total_age = $this->input->post('total_age');
			$age_relax_yr = $this->input->post('age_relax_yr');
			$age_writeup = $this->input->post('age_writeup');
			$u_pwd_percent = $this->input->post('u_pwd_percent');
			
			//$has_examted = $this->input->post('has_examted');
			//$has_ex_service = $this->input->post('has_ex_service');
			//$has_ews = $this->input->post('has_ews');
			$has_exp = $this->input->post('has_exp');
			$total_fees = $this->input->post('total_fees');
			//$u_paymode = $this->input->post('u_paymode');
			$academic_marks = $this->input->post('academic_marks');
			$experience_marks = $this->input->post('experience_marks');
			$interview_marks = $this->input->post('interview_marks');
			$written_marks = $this->input->post('written_marks');
			$marks_writeup = $this->input->post('marks_writeup');
			$miscellenius_writeup = $this->input->post('miscellenius_writeup');
			$disabality_writeup = $this->input->post('disabality_writeup');
			$essen_writeup = $this->input->post('essen_writeup');
			$desir_writeup = $this->input->post('desir_writeup');

			//$this->form_validation->set_rules('exam_gen', 'Qualification', 'trim|required');
			$this->form_validation->set_rules('adv_no', 'Advertisement ID', 'trim|required');
			$this->form_validation->set_rules('r_for', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('adv_category', 'Discipline', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('adv_qualification', 'Qualification', 'trim|is_natural');
			$this->form_validation->set_rules('adv_experience', 'Experience', 'trim|is_natural');
			$this->form_validation->set_rules('adv_name', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');
			$this->form_validation->set_rules('adv_dicta', 'Adv. Dictation', 'trim|required');
			$this->form_validation->set_rules('adv_typeset', 'Advertisement Type', 'trim|required');

			$this->form_validation->set_rules('scale_pay', 'Scale of Pay', 'trim|required');
			$this->form_validation->set_rules('total_vacency', 'Total Vacency', 'trim|required|is_natural_no_zero');
			//$this->form_validation->set_rules('has_examted', 'Has Examted', 'trim|required');
			//$this->form_validation->set_rules('has_ex_service', 'Has Ex-Service', 'trim|required');
			//$this->form_validation->set_rules('has_ews', 'Has EWS', 'trim|required');
			$this->form_validation->set_rules('has_exp', 'Has Experience', 'trim|required');
			$this->form_validation->set_rules('minimum_age', 'Minimum DOB', 'trim|required');
			$this->form_validation->set_rules('total_age', 'Maximum DOB', 'trim|required');
			$this->form_validation->set_rules('age_relax_yr', 'Age Relaxation', 'trim|required|is_natural');
			$this->form_validation->set_rules('age_writeup', 'Writeup about Age', 'trim');
			
			$this->form_validation->set_rules('total_fees', 'Total Fees', 'trim|required|is_natural');
			$this->form_validation->set_rules('u_pwd_percent', 'PWD Percentage', 'trim|required|is_natural');
			//$this->form_validation->set_rules('u_paymode', 'Payment Mode', 'trim|required');
			$this->form_validation->set_rules('academic_marks', 'Academic Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('experience_marks', 'Experience Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('interview_marks', 'Interview Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('written_marks', 'Written Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('marks_writeup', 'Writeup about Experience', 'trim');
			$this->form_validation->set_rules('miscellenius_writeup', 'Writeup Miscellenius', 'trim');
			$this->form_validation->set_rules('disabality_writeup', 'Writeup About Disabilities', 'trim');
			$this->form_validation->set_rules('essen_writeup', 'Writeup Essential Qualification', 'trim');
			$this->form_validation->set_rules('desir_writeup', 'Writeup Desirable Qualification', 'trim');
			if($adv_typeset == "Old"){
				$this->form_validation->set_rules('old_startdate', 'Old Start Date', 'trim|required');
				$this->form_validation->set_rules('old_enddate', 'Old End Date', 'trim|required');
				$this->form_validation->set_rules('old_starttime', 'Old Start Time', 'trim|required');
				$this->form_validation->set_rules('old_endtime', 'Old End Time', 'trim|required');
			}

			if ($this->form_validation->run()) {

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/adv_doc/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '11000';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();

							////////////////
							$ss_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_starttime));
							$ee_datetime = date('Y-m-d H:i:s', strtotime($u_enddate . ' ' . $u_endtime));
							if($adv_typeset == "Old"){
								$old_ss_datetime = date('Y-m-d H:i:s', strtotime($old_startdate . ' ' . $old_starttime));
								$old_ee_datetime = date('Y-m-d H:i:s', strtotime($old_enddate . ' ' . $old_endtime));
							}else{
								$old_ss_datetime = $old_ee_datetime = NULL;
							}

							$row_arr = array(
								'adv_no' => $adv_name,
								'adv_type' => $adv_typeset,
								'adv_dictation_set' => $adv_dicta,
								'adv_old_starttime' => $old_ss_datetime,
								'adv_old_endtime' => $old_ee_datetime,
								'adv_recruit_master' => $r_for,
								'adv_start_time' => $ss_datetime,
								'adv_end_time' => $ee_datetime,
								'adv_scale_pay' => $scale_pay,
								'adv_total_recruit' => $total_vacency,
								'adv_category_no' => $adv_category,
								'adv_min_age_limit' => date('Y-m-d',strtotime($minimum_age)),
								'adv_age_limit' => date('Y-m-d',strtotime($total_age)),
								'adv_age_updown' => $age_relax_yr,
								'adv_age_writeup' => $age_writeup,
								//'adv_gender_set' => $gender_set,
								//'adv_marital_set' => $marital_set,
								//'adv_has_exampted' => $has_examted,
								//'adv_has_exservice' => $has_ex_service,
								//'adv_has_ews' => $has_ews,
								'adv_has_experience' => $has_exp,
								'adv_fees' => $total_fees,
								'adv_pwd_percent' => $u_pwd_percent,
								//'adv_payment_mode' => $u_paymode,
								'adv_marks_writeup' => $marks_writeup,
								'adv_miscellenius' => $miscellenius_writeup,
								'adv_disability' => $disabality_writeup,
								'adv_qualification_no' => $adv_qualification,
								'adv_experience_no' => $adv_experience,
								'adv_essen_qualification' => $essen_writeup,
								'adv_desir_qualification' => $desir_writeup,
								'adv_source_doc' => $upload_data['file_name'],
								'adv_modifydate' => date('Y-m-d H:i:s'),
								'adv_modify_by' => $this->session->userdata['uid']
							);
							$row_arr2 = array(
								'amark_academic' => $academic_marks,
								'amark_experience' => $experience_marks,
								'amark_interview' => $interview_marks,
								'amark_written' => $written_marks
							);
							$get_existdoc = $this->db->where('adv_auto_genno', $adv_no)->get('advertisement_master')->row()->adv_source_doc;
							if ($this->admin_m->upDateform_against_Advertisement_inDB($row_arr, $row_arr2, $adv_no) == TRUE) {
								unlink('upload_file/adv_doc/' . $get_existdoc);
								echo json_encode(array('msg' => 1));
							} else {
								//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
								echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					$ss_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_starttime));
					$ee_datetime = date('Y-m-d H:i:s', strtotime($u_enddate . ' ' . $u_endtime));
					if($adv_typeset == "Old"){
						$old_ss_datetime = date('Y-m-d H:i:s', strtotime($old_startdate . ' ' . $old_starttime));
						$old_ee_datetime = date('Y-m-d H:i:s', strtotime($old_enddate . ' ' . $old_endtime));
					}else{
						$old_ss_datetime = $old_ee_datetime = NULL;
					}
					$row_arr = array(
						'adv_no' => $adv_name,
						'adv_type' => $adv_typeset,
						'adv_dictation_set' => $adv_dicta,
						'adv_old_starttime' => $old_ss_datetime,
						'adv_old_endtime' => $old_ee_datetime,
						'adv_recruit_master' => $r_for,
						'adv_start_time' => $ss_datetime,
						'adv_end_time' => $ee_datetime,
						'adv_scale_pay' => $scale_pay,
						'adv_total_recruit' => $total_vacency,
						'adv_category_no' => $adv_category,
						'adv_min_age_limit' => date('Y-m-d',strtotime($minimum_age)),
						'adv_age_limit' => date('Y-m-d',strtotime($total_age)),
						'adv_age_updown' => $age_relax_yr,
						'adv_age_writeup' => $age_writeup,
						//'adv_gender_set' => $gender_set,
						//'adv_marital_set' => $marital_set,
						//'adv_has_exampted' => $has_examted,
						//'adv_has_exservice' => $has_ex_service,
						//'adv_has_ews' => $has_ews,
						'adv_has_experience' => $has_exp,
						'adv_fees' => $total_fees,
						'adv_pwd_percent' => $u_pwd_percent,
						//'adv_payment_mode' => $u_paymode,
						'adv_marks_writeup' => $marks_writeup,
						'adv_miscellenius' => $miscellenius_writeup,
						'adv_disability' => $disabality_writeup,
						'adv_qualification_no' => $adv_qualification,
						'adv_experience_no' => $adv_experience,
						'adv_essen_qualification' => $essen_writeup,
						'adv_desir_qualification' => $desir_writeup,
						'adv_modifydate' => date('Y-m-d H:i:s'),
						'adv_modify_by' => $this->session->userdata['uid']
					);
					$row_arr2 = array(
						'amark_academic' => $academic_marks,
						'amark_experience' => $experience_marks,
						'amark_interview' => $interview_marks,
						'amark_written' => $written_marks
					);

					if ($this->admin_m->upDateform_against_Advertisement_inDB($row_arr, $row_arr2, $adv_no) == TRUE) {
						echo json_encode(array('msg' => 1));
					} else {
						//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
						echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
					}
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function add_new_scheme()
	{
		if($this->data["u_details"]->u_type > 2){
			redirect('admincontrol/dashboard');
		}
		//$this->data['adv_uno'] = 'R' . date('dmYhis') . $this->generateRandomString();
		$this->load->view('admin/scheme/add_scheme_view', $this->data);
	}

	public function new_qualification_submission()
	{
		if ($_POST) {
			$adv_no = $this->input->post("adv_no");
			$quali_name = $this->input->post("quali_name");
			$quali_type = $this->input->post("quali_type");
			$quali_final_set = $this->input->post("quali_final_set");
			$quali_parsuing = $this->input->post("quali_parsuing");
			$quali_fullmark = $this->input->post("quali_fullmark");
			$exam_rtype = $this->input->post("exam_rtype");
			$quali_category = $this->input->post("quali_category");
			$attempt_type = $this->input->post("attempt_type");
			$attempt_marks = $this->input->post("attempt_marks");
			$q_slap = $this->input->post("q_slap");
			$q_mark = $this->input->post("q_mark");
			$deduct_slap = $this->input->post("deduct_slap");
			$deduct_mark = $this->input->post("deduct_mark");

			$this->form_validation->set_rules('adv_no', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('quali_name', 'Qualification', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('quali_type', 'Type', 'trim|required');
			$this->form_validation->set_rules('quali_final_set', 'Final Qualication', 'trim|required');
			$this->form_validation->set_rules('quali_parsuing', 'Take Pursuing', 'trim|required');
			$this->form_validation->set_rules('quali_fullmark', 'Total Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('exam_rtype', 'Relation Type', 'trim|required');
			$this->form_validation->set_rules('quali_category', 'Distribution Category', 'trim|required');
			$this->form_validation->set_rules('attempt_type', 'Additional Attempt', 'trim|required');
			if ($quali_category == "Slab") {
				$this->form_validation->set_rules('q_slap', 'Upto Section', 'trim|required');
				$this->form_validation->set_rules('q_mark', 'Slabwise Marks', 'trim|required');
			}
			if ($attempt_type == "Full" || $attempt_type == "Percent") {
				$this->form_validation->set_rules('attempt_marks', 'Attempt Marks', 'trim|required|numeric');
			}elseif($attempt_type == "Slab"){
				$this->form_validation->set_rules('deduct_slap', 'Deduction Section', 'trim|required');
				$this->form_validation->set_rules('deduct_mark', 'Deduction Marks', 'trim|required');
			}
			if ($this->form_validation->run()) {

				if ($this->admin_m->check_Existing_qualification_inDB($adv_no, $quali_name) == TRUE) {

					if($attempt_type == "No"){
						$attempt_marks = NULL;
					}
					$row_arr = array(
						'aquali_adv_master' => $adv_no,
						'aquali_exam' => $quali_name,
						'aquali_examtype' => $quali_type,
						'aquali_finalexam' => $quali_final_set,
						'aquali_pursuing_chk' => $quali_parsuing,
						'aquali_marks' => $quali_fullmark,
						'aquali_relation' => $exam_rtype,
						'aquali_category' => $quali_category,
						'aquali_attempt' => $attempt_type,
						'aquali_fullpercent' => $attempt_marks,
						'aquali_createdate' => date('Y-m-d H:i:s')
					);
					if ($quali_category == "Slab") {
						$q_slap_arr = explode(",", $q_slap);
						$q_mark_arr = explode(",", $q_mark);
					}
					if ($attempt_type == "Slab") {
						$deduct_slap_arr = explode(",", $deduct_slap);
						$deduct_mark_arr = explode(",", $deduct_mark);
					}

					$resultset = $this->admin_m->addupdate_qualification_inDB($row_arr);
					if ($resultset != FALSE) {

						$detail_counter = 0;
						$deduct_counter = 0;
						if ($quali_category == "Slab") {
							for ($i = 0; $i < count($q_slap_arr); $i++) {
								$row1 = array(
									'aq_qualification_ms' => $resultset,
									'aq_detail_score_lvl' => $q_slap_arr[$i],
									'aq_detail_score_mark' => $q_mark_arr[$i],
									'aq_detail_crdate' => date('Y-m-d H:i:s')
								);
								if ($this->admin_m->addupdate_qualification_details_inDB($row1) == FALSE) {
									$detail_counter++;
								}
							}
						}
						if ($attempt_type == "Slab") {
							for ($i = 0; $i < count($deduct_slap_arr); $i++) {
								$row2 = array(
									'aq_deduction_ms' => $resultset,
									'aq_deduct_lvl' => $deduct_slap_arr[$i],
									'aq_deduct_mark' => $deduct_mark_arr[$i],
									'aq_deduct_crdate' => date('Y-m-d H:i:s')
								);
								if ($this->admin_m->addupdate_deduction_details_inDB($row2) == FALSE) {
									$deduct_counter++;
								}
							}
						}
						if ($detail_counter == 0 && $deduct_counter == 0) {
							$resultbunch = $this->admin_m->get_qualification_details_fromDB($resultset);
							if ($quali_category == "Slab") {
								$resultdetail_slav = $this->admin_m->get_qualification_slav_details_fromDB($resultset);
							}else{
								$resultdetail_slav = array();
							}
							if ($attempt_type == "Slab") {
								$resultdeduct_slav = $this->admin_m->get_qualification_slav_deductdetails_fromDB($resultset);
							}else{
								$resultdeduct_slav = array();
							}
							echo json_encode(array('msg' => 1, 'cat_set' => $resultbunch, 'detail_set' => $resultdetail_slav, 'deduct_set' => $resultdeduct_slav));
						} else {
							$this->db->delete('advertisement_qualification', array('aquali_id' => $resultset));
							$this->db->delete('advertisement_quali_details', array('aq_qualification_ms' => $resultset));
							$this->db->delete('advertisement_deduct_details', array('aq_deduction_ms' => $resultset));
							echo json_encode(array('msg' => 0, 'e_msg' => 'DB Details insertion Problem, check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Qualification already inserted in the section, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function new_experience_submission()
	{
		if ($_POST) {
			$adv_no = $this->input->post("adv_no");
			$expr_name = $this->input->post("expr_name");
			$expr_type = $this->input->post("expr_type");
			$expr_retn = $this->input->post("expr_retn");
			$expr_min_month = $this->input->post("expr_min_month");
			$expr_fullmark = $this->input->post("expr_fullmark");
			$expr_category = $this->input->post("expr_category");

			$ex_section = $this->input->post("ex_section");
			$ex_months = $this->input->post("ex_months");
			$ex_marks = $this->input->post("ex_marks");

			$this->form_validation->set_rules('adv_no', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('expr_name', 'Exp Category', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('expr_type', 'Exp Type', 'trim|required|alpha');
			$this->form_validation->set_rules('expr_retn', 'Exp Relation', 'trim|required|alpha');
			$this->form_validation->set_rules('expr_min_month', 'Minimum Month', 'trim|required|is_natural');
			$this->form_validation->set_rules('expr_fullmark', 'Total Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('expr_category', 'Distribution Category', 'trim|required|alpha');
			if ($expr_category == "Slab") {
				$this->form_validation->set_rules('ex_section', 'Section', 'trim|required');
				$this->form_validation->set_rules('ex_months', 'Month', 'trim|required');
				$this->form_validation->set_rules('ex_marks', 'Marks', 'trim|required');
			}
			if ($this->form_validation->run()) {

				if ($this->admin_m->check_Existing_Experience_inDB($adv_no, $expr_name) == TRUE) {


					$row_arr = array(
						'aexpr_adv_master' => $adv_no,
						'aexpr_name' => $expr_name,
						'aexpr_type' => $expr_type,
						'aexpr_relation' => $expr_retn,
						'aexpr_marks' => $expr_fullmark,
						'aexpr_min_month' => $expr_min_month,
						'aexpr_category' => $expr_category,
						'aexpr_createdate' => date('Y-m-d H:i:s')
					);
					if ($expr_category == "Slab") {
						$exp_section_arr = explode(",", $ex_section);
						$exp_months_arr = explode(",", $ex_months);
						$exp_marks_arr = explode(",", $ex_marks);
					}

					$resultset = $this->admin_m->addupdate_Experience_inDB($row_arr);
					if ($resultset != FALSE) {

						$detail_counter = 0;
						if ($expr_category == "Slab") {
							for ($i = 0; $i < count($exp_months_arr); $i++) {
								$row1 = array(
									'ae_experience_ms' => $resultset,
									'ae_range_words' => $exp_section_arr[$i],
									'ae_detail_month' => $exp_months_arr[$i],
									'ae_detail_mark' => $exp_marks_arr[$i],
									'ae_detail_cr_date' => date('Y-m-d H:i:s')
								);
								if ($this->admin_m->addupdate_Experience_details_inDB($row1) == FALSE) {
									$detail_counter++;
								}
							}
						}
						if ($detail_counter == 0) {
							$resultbunch = $this->admin_m->getDetails_Expr_of_Advertisement($resultset);
							if ($expr_category == "Slab") {
								$resultdetail_slav = $this->admin_m->get_Experience_slav_details_fromDB($resultset);
								echo json_encode(array('msg' => 1, 'cat_set' => $resultbunch, 'detail_set' => $resultdetail_slav));
							} else {
								echo json_encode(array('msg' => 1, 'cat_set' => $resultbunch));
							}
						} else {
							$this->db->delete('advertisement_experience', array('aexpr_id' => $resultset));
							$this->db->delete('advertisement_exp_details', array('ae_experience_ms' => $resultset));
							echo json_encode(array('msg' => 0, 'e_msg' => 'DB Details insertion Problem, check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Experience already inserted in the section, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function new_advertisement_submission()
	{
		if ($_POST) {

			//$exam_gen = $this->input->post("exam_gen");
			$adv_no = $this->input->post("adv_no");
			$adv_category = $this->input->post("adv_category");
			$adv_qualification = $this->input->post("adv_qualification");
			$adv_experience = $this->input->post("adv_experience");
			$r_for = $this->input->post("r_for");
			$adv_name = $this->input->post("adv_name");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			$adv_dicta = $this->input->post("adv_dicta");
			$adv_typeset = $this->input->post("adv_typeset");
			$old_startdate = $this->input->post('old_startdate');
			$old_enddate = $this->input->post('old_enddate');
			$old_starttime = $this->input->post('old_starttime');
			$old_endtime = $this->input->post('old_endtime');

			$scale_pay = $this->input->post('scale_pay');
			$total_vacency = $this->input->post('total_vacency');
			$minimum_age = $this->input->post('minimum_age');
			$total_age = $this->input->post('total_age');
			$age_relax_yr = $this->input->post('age_relax_yr');
			$age_writeup = $this->input->post('age_writeup');
			
			//$has_examted = $this->input->post('has_examted');
			//$has_ex_service = $this->input->post('has_ex_service');
			//$has_ews = $this->input->post('has_ews');
			$has_exp = $this->input->post('has_exp');
			$total_fees = $this->input->post('total_fees');
			$u_pwd_percent = $this->input->post('u_pwd_percent');
			//$u_paymode = $this->input->post('u_paymode');
			$academic_marks = $this->input->post('academic_marks');
			$experience_marks = $this->input->post('experience_marks');
			$interview_marks = $this->input->post('interview_marks');
			$written_marks = $this->input->post('written_marks');
			$marks_writeup = $this->input->post('marks_writeup');
			$miscellenius_writeup = $this->input->post('miscellenius_writeup');
			$disabality_writeup = $this->input->post('disabality_writeup');
			$essen_writeup = $this->input->post('essen_writeup');
			$desir_writeup = $this->input->post('desir_writeup');

			//$this->form_validation->set_rules('exam_gen', 'Qualification', 'trim|required');
			$this->form_validation->set_rules('adv_no', 'Advertisement ID', 'trim|required');
			$this->form_validation->set_rules('r_for', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('adv_category', 'Discipline', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('adv_qualification', 'Qualification', 'trim|is_natural');
			$this->form_validation->set_rules('adv_experience', 'Experience', 'trim|is_natural');
			$this->form_validation->set_rules('adv_name', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');
			$this->form_validation->set_rules('adv_dicta', 'Adv. Dictation', 'trim|required');
			$this->form_validation->set_rules('adv_typeset', 'Advertisement Type', 'trim|required');

			$this->form_validation->set_rules('scale_pay', 'Scale of Pay', 'trim|required');
			$this->form_validation->set_rules('total_vacency', 'Total Vacency', 'trim|required|is_natural_no_zero');
			//$this->form_validation->set_rules('has_examted', 'Has Examted', 'trim|required');
			
			//$this->form_validation->set_rules('has_ex_service', 'Has Ex-Service', 'trim|required');
			//$this->form_validation->set_rules('has_ews', 'Has EWS', 'trim|required');
			$this->form_validation->set_rules('has_exp', 'Has Experience', 'trim|required');
			$this->form_validation->set_rules('minimum_age', 'Minimum DOB', 'trim|required');
			$this->form_validation->set_rules('total_age', 'Maximum DOB', 'trim|required');
			$this->form_validation->set_rules('age_relax_yr', 'Age Relaxation', 'trim|required|is_natural');
			$this->form_validation->set_rules('age_writeup', 'Writeup about Age', 'trim');
			$this->form_validation->set_rules('total_fees', 'Total Fees', 'trim|required|is_natural');
			$this->form_validation->set_rules('u_pwd_percent', 'PWD Percentage', 'trim|required|is_natural');
			//$this->form_validation->set_rules('u_paymode', 'Payment Mode', 'trim|required');
			$this->form_validation->set_rules('academic_marks', 'Academic Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('experience_marks', 'Experience Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('interview_marks', 'Interview Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('written_marks', 'Written Marks', 'trim|required|numeric');
			$this->form_validation->set_rules('marks_writeup', 'Writeup about Experience', 'trim');
			$this->form_validation->set_rules('miscellenius_writeup', 'Writeup Miscellenius', 'trim');
			$this->form_validation->set_rules('disabality_writeup', 'Writeup About Disabilities', 'trim');
			$this->form_validation->set_rules('essen_writeup', 'Writeup Essential Qualification', 'trim');
			$this->form_validation->set_rules('desir_writeup', 'Writeup Desirable Qualification', 'trim');

			if($adv_typeset == "Old"){
				$this->form_validation->set_rules('old_startdate', 'Old Start Date', 'trim|required');
				$this->form_validation->set_rules('old_enddate', 'Old End Date', 'trim|required');
				$this->form_validation->set_rules('old_starttime', 'Old Start Time', 'trim|required');
				$this->form_validation->set_rules('old_endtime', 'Old End Time', 'trim|required');
			}

			if ($this->form_validation->run()) {

				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					if (!empty($filename)) {
						$this->load->library('upload');
						$this->load->library('image_lib');

						$config['upload_path'] = realpath('upload_file/adv_doc/');
						$config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '11000';
						$config['file_name'] = $filename;

						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						if ($this->upload->do_upload('files')) {

							$upload_data = $this->upload->data();

							////////////////
							$ss_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_starttime));
							$ee_datetime = date('Y-m-d H:i:s', strtotime($u_enddate . ' ' . $u_endtime));
							if($adv_typeset == "Old"){
								$old_ss_datetime = date('Y-m-d H:i:s', strtotime($old_startdate . ' ' . $old_starttime));
								$old_ee_datetime = date('Y-m-d H:i:s', strtotime($old_enddate . ' ' . $old_endtime));
							}else{
								$old_ss_datetime = $old_ee_datetime = NULL;
							}
							$row_arr = array(
								'adv_auto_genno' => $adv_no,
								'adv_no' => $adv_name,
								'adv_type' => $adv_typeset,
								'adv_dictation_set' => $adv_dicta,
								'adv_old_starttime' => $old_ss_datetime,
								'adv_old_endtime' => $old_ee_datetime,
								'adv_recruit_master' => $r_for,
								'adv_start_time' => $ss_datetime,
								'adv_end_time' => $ee_datetime,
								'adv_scale_pay' => $scale_pay,
								'adv_total_recruit' => $total_vacency,
								'adv_category_no' => $adv_category,
								'adv_min_age_limit' => date('Y-m-d',strtotime($minimum_age)),
								'adv_age_limit' => date('Y-m-d',strtotime($total_age)),
								'adv_age_updown' => $age_relax_yr,
								'adv_age_writeup' => $age_writeup,
								//'adv_gender_set' => $gender_set,
								//'adv_marital_set' => $marital_set,
								//'adv_has_exampted' => $has_examted,
								//'adv_has_exservice' => $has_ex_service,
								//'adv_has_ews' => $has_ews,
								'adv_has_experience' => $has_exp,
								'adv_fees' => $total_fees,
								'adv_pwd_percent' => $u_pwd_percent,
								//'adv_payment_mode' => $u_paymode,
								'adv_marks_writeup' => $marks_writeup,
								'adv_qualification_no' => $adv_qualification,
								'adv_experience_no' => $adv_experience,
								'adv_essen_qualification' => $essen_writeup,
								'adv_desir_qualification' => $desir_writeup,
								'adv_miscellenius' => $miscellenius_writeup,
								'adv_disability' => $disabality_writeup,
								'adv_source_doc' => $upload_data['file_name'],
								'adv_createdate' => date('Y-m-d H:i:s'),
								'adv_createby' => $this->session->userdata['uid']
							);
							$row_arr2 = array(
								'amark_adv_master' => $adv_no,
								'amark_academic' => $academic_marks,
								'amark_experience' => $experience_marks,
								'amark_interview' => $interview_marks,
								'amark_written' => $written_marks,
								'amrk_createdate' => date('Y-m-d H:i:s')
							);

							if ($this->admin_m->addform_against_Advertisement_inDB($row_arr, $row_arr2) == TRUE) {
								mkdir("upload_file/" . $adv_no,0755,TRUE);
								mkdir("upload_file/" . $adv_no . "/candidates",0755,TRUE);
								echo json_encode(array('msg' => 1));
							} else {
								$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
								echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
							}
							//////////////////////////
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Advertisement Document is missing, Try again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function getcat_update()
	{
		if ($_POST) {
			$r_for = $this->input->post("r_for");
			if ($r_for != "") {
				$ret_string = "";
				$examset_string = "";
				$results = $this->db->order_by('catm_name', 'ASC')->where('catm_master', $r_for)->where('catm_status', 1)->get('category_master')->result();
				$exm_results = $this->db->order_by('qm_name', 'ASC')->where('(qm_r_master = ', $r_for)->or_where('qm_r_master is NULL)')->where('qm_status', 1)->get('qualification_master')->result();
				if(count((array)$exm_results) > 0){
					foreach ($exm_results as $exres) {
						$examset_string = $examset_string . '<option value="' . $exres->qm_id . '">' . $exres->qm_name . '</option>';
					}
				}
				if (count((array)$results) > 0) {
					foreach ($results as $res) {
						$ret_string = $ret_string . '<option value="' . $res->catm_id . '">' . $res->catm_name . '</option>';
					}
					echo json_encode(array('msg' => 1, 'option_set' => $ret_string, 'ex_set' => $examset_string));
				} else {
					$results = $this->db->order_by('catm_name', 'ASC')->where('catm_master', NULL)->where('catm_status', 1)->get('category_master')->result();
					if (count((array)$results) > 0) {
						foreach ($results as $res) {
							$ret_string = $ret_string . '<option value="' . $res->catm_id . '">' . $res->catm_name . '</option>';
						}
						echo json_encode(array('msg' => 1, 'option_set' => $ret_string, 'ex_set' => $examset_string));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Available'));
					}
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => 'Field is blank, check again.'));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function add_category_update()
	{
		if ($_POST) {
			$adv_no = $this->input->post("adv_no");
			$cat_for = $this->input->post("cat_for");
			$un_no = $this->input->post("un_no");
			$sc_no = $this->input->post("sc_no");
			$st_no = $this->input->post("st_no");
			$obc_no = $this->input->post("obc_no");
			$obca_no = $this->input->post("obca_no");
			$obcb_no = $this->input->post("obcb_no");
			$pwd_no = $this->input->post("pwd_no");
			//$exc_no = $this->input->post("exc_no");
			//$exs_no = $this->input->post("exs_no");
			//$ews_no = $this->input->post("ews_no");
			$gender_set = $this->input->post('gender_set');
			$marital_set = $this->input->post('marital_set');

			$un_no2 = $this->input->post("un_no2");
			$un_no3 = $this->input->post("un_no3");
			$un_no4 = $this->input->post("un_no4");
			$un_no5 = $this->input->post("un_no5");
			$sc_no2 = $this->input->post("sc_no2");
			$sc_no3 = $this->input->post("sc_no3");
			$sc_no4 = $this->input->post("sc_no4");
			$st_no2 = $this->input->post("st_no2");
			$st_no3 = $this->input->post("st_no3");
			$obca_no2 = $this->input->post("obca_no2");
			$obca_no3 = $this->input->post("obca_no3");
			$obcb_no2 = $this->input->post("obcb_no2");
			$obcb_no3 = $this->input->post("obcb_no3");

			$this->form_validation->set_rules('adv_no', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('cat_for', 'Post', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('un_no', 'Unreserved', 'trim|required|is_natural');
			$this->form_validation->set_rules('sc_no', 'Scheduled Caste', 'trim|required|is_natural');
			$this->form_validation->set_rules('st_no', 'Scheduled Tribe', 'trim|required|is_natural');
			$this->form_validation->set_rules('obc_no', 'OBC', 'trim|required|is_natural');
			$this->form_validation->set_rules('obca_no', 'OBC-A', 'trim|required|is_natural');
			$this->form_validation->set_rules('obcb_no', 'OBC-B', 'trim|required|is_natural');
			$this->form_validation->set_rules('pwd_no', 'PWD', 'trim|required|is_natural');
			//$this->form_validation->set_rules('exc_no', 'Exempted', 'trim|required|is_natural');
			//$this->form_validation->set_rules('exs_no', 'Ex Service', 'trim|required|is_natural');
			//$this->form_validation->set_rules('ews_no', 'EWS', 'trim|required|is_natural');
			$this->form_validation->set_rules('gender_set', 'Gender', 'trim|required');
			$this->form_validation->set_rules('marital_set', 'Marital Status', 'trim|required');

			$this->form_validation->set_rules('un_no2', 'Unreserved (E.C.)', 'trim|required|is_natural');
			$this->form_validation->set_rules('un_no3', 'Unreserved (Ex-Serviceman in Group-C Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('un_no4', 'Unreserved (Ex-Serviceman in Group-D Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('un_no5', 'Unreserved (Meritorious Sports Person)', 'trim|required|is_natural');
			$this->form_validation->set_rules('sc_no2', 'Scheduled Caste (E.C.)', 'trim|required|is_natural');
			$this->form_validation->set_rules('sc_no3', 'Scheduled Caste (Ex-Serviceman in Group-C Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('sc_no4', 'Scheduled Caste (Ex-Serviceman in Group-D Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('st_no2', 'Schedule Tribe (E.C.)', 'trim|required|is_natural');
			$this->form_validation->set_rules('st_no3', 'Schedule Tribe (Ex-Serviceman in Group-D Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('obca_no2', 'OBC Category-A (E.C.)', 'trim|required|is_natural');
			$this->form_validation->set_rules('obca_no3', 'OBC Category-A (Ex-Serviceman in Group-D Post)', 'trim|required|is_natural');
			$this->form_validation->set_rules('obcb_no2', 'OBC Category-B (E.C.)', 'trim|required|is_natural');
			$this->form_validation->set_rules('obcb_no3', 'OBC Category-B (Ex-Serviceman in Group-D Post)', 'trim|required|is_natural');

			if ($this->form_validation->run()) {

				if ($this->admin_m->check_category_exist_inDB($adv_no, $cat_for) == TRUE) {

					$totalall = $un_no + $sc_no + $st_no + $obc_no + $obca_no + $obcb_no + $pwd_no + $un_no2 + $un_no3 + $un_no4 + $un_no5 + $sc_no2 + $sc_no3 + $sc_no4 + $st_no2 + $st_no3 + $obca_no2 + $obca_no3 + $obcb_no2 + $obcb_no3;
					$row_arr = array(
						'acat_adv_master' => $adv_no,
						'acat_name' => $cat_for,
						'acat_gender_set' => $gender_set,
						'acat_marital_set' => $marital_set,
						'acat_ur' => $un_no,
						'acat_sc' => $sc_no,
						'acat_st' => $st_no,
						'acat_obc' => $obc_no,
						'acat_obc_a' => $obca_no,
						'acat_obc_b' => $obcb_no,
						'acat_pwd' => $pwd_no,
						//'acat_exc' => $exc_no,
						//'acat_exs' => $exs_no,
						//'acat_ews' => $ews_no,
						'acat_ur_ec' => $un_no2,
						'acat_ur_g_c' => $un_no3,
						'acat_ur_g_d' => $un_no4,
						'acat_ur_sp' => $un_no5,
						'acat_sc_ec' => $sc_no2,
						'acat_sc_g_c' => $sc_no3,
						'acat_sc_g_d' => $sc_no4,
						'acat_st_ec' => $st_no2,
						'acat_st_g_d' => $st_no3,
						'acat_obc_a_ec' => $obca_no2,
						'acat_obc_a_g_d' => $obca_no3,
						'acat_obc_b_ec' => $obcb_no2,
						'acat_obc_b_g_d' => $obcb_no3,
						'acat_total' => $totalall,
						'acat_createdate' => date('Y-m-d H:i:s')
					);
					$resultset = $this->admin_m->addupdate_category_inDB($row_arr);
					if (count((array)$resultset) > 0) {
						echo json_encode(array('msg' => 1, 'cat_set' => $resultset));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Post already insrted in the Section, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_expr_update()
	{
		if ($_POST) {
			$qid = $this->input->post("qid");
			$this->form_validation->set_rules('qid', 'Experience ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('advertisement_experience', array('aexpr_id' => $qid))->row();
				if (count((array)$resultrow) > 0) {

					if($this->admin_m->checkUpperdata_Exist_forExperience($qid, $resultrow->aexpr_adv_master) == TRUE){

						if ($this->db->delete('advertisement_experience', array('aexpr_id' => $qid))) {
							$prev_result = $this->admin_m->getAll_prevRecord_forExperience($resultrow->aexpr_adv_master);
							if ($resultrow->aexpr_category == "Slab") {
								$this->db->delete('advertisement_exp_details', array('ae_experience_ms' => $qid));
							}
							echo json_encode(array('msg' => 1, 'expmarks' => $resultrow, 'prev_pos' => $prev_result));
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
						}

					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => 'Please Maintain the Line and Delete from Last Row.'));
					}

				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_quali_update()
	{
		if ($_POST) {
			$qid = $this->input->post("qid");
			$this->form_validation->set_rules('qid', 'Qualification ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('advertisement_qualification', array('aquali_id' => $qid))->row();
				if (count((array)$resultrow) > 0) {
					if($this->admin_m->checkUpperdata_Exist_forQualification($qid, $resultrow->aquali_adv_master) == TRUE){
						if ($this->db->delete('advertisement_qualification', array('aquali_id' => $qid))) {
							$prev_result = $this->admin_m->getAll_prevRecord_forQualification($resultrow->aquali_adv_master);
							//print_r($prev_result);
							if ($resultrow->aquali_category == "Slab") {
								$this->db->delete('advertisement_quali_details', array('aq_qualification_ms' => $qid));
							}
							if ($resultrow->aquali_attempt == "Slab") {
								$this->db->delete('advertisement_deduct_details', array('aq_deduction_ms' => $qid));
							}
							echo json_encode(array('msg' => 1, 'qualimark' => $resultrow, 'prev_pos' => $prev_result));
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
						}
					}else{
						echo json_encode(array('msg' => 0, 'e_msg' => 'Please Maintain the Line and Delete from Last Row.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_category_update()
	{
		if ($_POST) {
			$catid = $this->input->post("catid");
			$this->form_validation->set_rules('catid', 'Discipline ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('advertisement_categoty', array('acat_id' => $catid))->row();
				if (count((array)$resultrow) > 0) {
					if ($this->db->delete('advertisement_categoty', array('acat_id' => $catid))) {
						echo json_encode(array('msg' => 1, 'cat_set' => $resultrow));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function add_ageset_update()
	{
		if ($_POST) {
			$adv_no = $this->input->post("adv_no");
			$age_for = $this->input->post("age_for");
			$age_type = $this->input->post("age_type");
			$age_no = $this->input->post("age_no");
			$fee_for = $this->input->post("fee_for");
			$partfee_amt = $this->input->post("partfee_amt");
			
			$this->form_validation->set_rules('adv_no', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('age_for', 'Section', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('age_type', 'Relation Type', 'trim|required');
			$this->form_validation->set_rules('age_no', 'Number of Year', 'trim|required|is_natural');
			$this->form_validation->set_rules('fee_for', 'Fee Type', 'trim|required');
			if ($fee_for == "Part") {
				$this->form_validation->set_rules('partfee_amt', 'Part Fee Amount', 'trim|required|is_natural');
			}

			if ($this->form_validation->run()) {

				if ($this->admin_m->check_Ageset_exist_inDB($adv_no, $age_for) == TRUE) {

					$row_arr = array(
						'advage_adv_master' => $adv_no,
						'advage_section' => $age_for,
						'advage_type' => $age_type,
						'advage_up' => $age_no,
						'advage_feetype' => $fee_for,
						'advage_createdate' => date('Y-m-d H:i:s')
					);
					if ($fee_for == "Part") {
						$row_arr['advage_partfee'] = $partfee_amt;
					}
					$resultset = $this->admin_m->addupdate_AgeSet_inDB($row_arr);
					if (count((array)$resultset) > 0) {
						echo json_encode(array('msg' => 1, 'cat_set' => $resultset));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'Section already insrted in the Advertisement, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function delete_ageset_update()
	{
		if ($_POST) {
			$ageid = $this->input->post("ageid");
			$this->form_validation->set_rules('ageid', 'Section ID', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$resultrow = $this->db->get_where('advertisement_age_set', array('advage_id' => $ageid))->row();
				if (count((array)$resultrow) > 0) {
					if ($this->db->delete('advertisement_age_set', array('advage_id' => $ageid))) {
						$prev_result = $this->admin_m->getAll_prevRecord_forAge_FeeSet($resultrow->advage_adv_master);
						echo json_encode(array('msg' => 1, 'cat_set' => $resultrow, 'prev_pos' => $prev_result));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'Data not Deleted from DB, check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'DB Data not found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function approve_the_event34534534545435435($ev_no = NULL)
	{
		if ($ev_no == NULL) {
			redirect('admincontrol/advertisement_set/all_event_list');
		}
		$row_array = array(
			'event_approval' => 1,
			'event_approve_by' => $this->session->userdata('uid')
		);
		if ($this->main_m->addform_against_user_Event_set($row_array, $ev_no) == TRUE) {
			$this->session->set_flashdata("success", "Event is Approved successfully.");
			redirect('admincontrol/advertisement_set/all_event_list');
		} else {
			$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
			redirect('admincontrol/advertisement_set/all_event_list');
		}
	}

	public function reject_the_event34534534756756776($ev_no = NULL)
	{
		if ($ev_no == NULL) {
			redirect('admincontrol/advertisement_set/all_event_list');
		}
		$row_array = array(
			'event_approval' => 2,
			'event_approve_by' => $this->session->userdata('uid')
		);
		if ($this->main_m->addform_against_user_Event_set($row_array, $ev_no) == TRUE) {
			$this->session->set_flashdata("success", "Event is Rejected successfully.");
			redirect('admincontrol/advertisement_set/all_event_list');
		} else {
			$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
			redirect('admincontrol/advertisement_set/all_event_list');
		}
	}

	public function get_advisement_against_recruitment()
	{
		if ($_POST) {
			$rf_set = $this->input->post("rf_set");

			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');

			if ($this->form_validation->run()) {

				$result_details = $this->db->order_by('adv_no', 'ASC')->where('adv_status', 1)->where('adv_recruit_master', $rf_set)->get('advertisement_master')->result();
				if (count((array)$result_details) > 0) {

					$totalall = '<option value="">---Select---</option>';
					foreach ($result_details as $results) {
						$totalall = $totalall . '<option value="' . $results->adv_auto_genno . '">' . $results->adv_no . '</option>';
					}
					echo json_encode(array('msg' => 1, 'op_set' => $totalall));
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'No Data Found, check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	protected function generateRandomString($length = 4)
	{
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function generate_and_print_advertisement($advise_no = NULL)
	{
		error_reporting(0);
		if($this->data["u_details"]->u_type != 1){
			if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
				redirect('admincontrol/dashboard');
			}
		}
		if ($advise_no == "" || $advise_no == NULL) {
			redirect('default404');
		}

		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advise_no);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advise_no);
		if (count((array)$cat_details) == 0) {
			redirect('default404');
		}
		$q_list = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($advise_no);
		$qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($advise_no);
		$qdeduct_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($advise_no);
		$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($advise_no);
		$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($advise_no);
		$age_details = $this->admin_m->getAll_AgeFee_detaillist_of_Advertisement($advise_no);
		//echo "<pre>";
		//print_r($age_details);
		/*$copy_arr = explode(",", $app_details->appli_copy_fwd);
		$copy_set = $this->main_m->get_all_conditions_copys_DB($app_details->appli_copy_fwd);
		if(count((array)$copy_set) == 0){
			redirect('default404');
		}*/
		//echo "hi";exit;
		$amt_in_word = $this->convertTo_Text($app_details->adv_fees);

		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $advise_no;
		$obj_pdf->SetTitle('Advertisement');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Advertisement Notice');

		$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
		//$obj_pdf->setFooterData(array(0,64,0), array(0,64,128));

		//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//$obj_pdf->SetFont('helvetica', '', 9);
		//$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		</head>
		<body>
		<div class=\"header\">";
		$my_html = $my_html . "<table style=\"width: 100%\" style=\"font-size: 22px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 22px;\">
				<tr>
				<td style=\"width:20%;\">
				<div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /></div>
				</td>
				<td style=\"width:60%;\">
					<div align=\"center\">
					<span style=\"font-size:28px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:24px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor)</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\">GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\"><u>www.wbhrb.in</u>, Phone : 2357-0085</span></div>
					<div align=\"center\" style=\"font-size:22px;font-weight:bold;\"><i>Advertisement No.: " . $app_details->adv_no . "</i><br/>
					<u>Recruitment for " . $app_details->rm_name . "</u></div>
				</td>
				<td style=\"width:20%;\">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan=\"2\"><div><p align=\"justify\"><strong>Online applications are invited from Indian Citizen for recruitment to the Post of " . $app_details->rm_name . " under Health & Family Welfare Department, Government of West Bengal.</strong></p>
		<p align=\"justify\">Only online registration & submission of Application will be allowed on the website <b>(www.wbhrb.in)</b> between <b>" . date('d.m.Y', strtotime($app_details->adv_start_time)) . " to " . date('d.m.Y', strtotime($app_details->adv_end_time)) . " (Till " . date('h:i A', strtotime($app_details->adv_end_time)) . ")</b>.</p>
		<p align=\"justify\">Appointments are temporary but likely to be permanent.</p>
		<p align=\"justify\"><b>The relevant rules and necessary particulars are stated in the following paragraph:</b></p>
		<p align=\"justify\">A candidate should verify from the notified eligibility criteria to ascertain whether he/ she is eligible for submission of application. The condition prescribed cannot be relaxed. The recruitment will be made by selection, but where if a large number of applications are received, as a result of Advertisement, the Board may, for the purpose of short-listing, hold a preliminary examination.</p>
		<p align=\"justify\"><b>Scale of Pay:</b> " . $app_details->adv_scale_pay . "</p>
		<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Anticipated Vacancies:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 15px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
				
				$rowcounter = 2 + count((array)$cat_details);
				$total_ur = 0;
				$total_sc = 0;
				$total_st = 0;
				$total_o = 0;
				$total_oa = 0;
				$total_ob = 0;
				$total_pwd = 0;
				//$total_exc = 0;
				//$total_exs = 0;
				//$total_ews = 0;
				$total_of_total = 0;
				$total_ur2 = 0;
				$total_ur3 = 0;
				$total_ur4 = 0;
				$total_ur5 = 0;
				$total_sc2 = 0;
				$total_sc3 = 0;
				$total_sc4 = 0;
				$total_st2 = 0;
				$total_st3 = 0;
				$total_oa2 = 0;
				$total_oa3 = 0;
				$total_ob2 = 0;
				$total_ob3 = 0;
				$my_html = $my_html . "<tr><td colspan=\"".$rowcounter."\"><b>Name of the Post - </b>" . $app_details->rm_name . "</td></tr>
				<tr>
					<td><b>Post</b></td>";
					foreach ($cat_details as $discips) {
						$my_html = $my_html . "<td><b>".$discips->catm_name."</b></td>";
					}
					$my_html = $my_html . "<td rowspan=\"3\"><b>Total</b></td>
				</tr>
				<tr>
					<td><b>Gender</b></td>";
					foreach ($cat_details as $discips) {
						$gset_arr = explode(",",$discips->acat_gender_set);
						if(count($gset_arr) != 3){
							$gset = str_replace(",",", ", $discips->acat_gender_set);
						}else{
							$gset = "ALL";
						}
						$my_html = $my_html . "<td>".$gset."</td>";
					}
					$my_html = $my_html . "</tr>
				<tr>
					<td><b>Marital Status</b></td>";
					foreach ($cat_details as $discips) {
						$mset_arr = explode(",",$discips->acat_marital_set);
						if(count($mset_arr) != 5){
							$mset = str_replace(",",", ", $discips->acat_marital_set);
						}else{
							$mset = "ALL";
						}
						$my_html = $my_html . "<td>".$mset."</td>";
					}
					$my_html = $my_html . "</tr>
				<tr>
					<td><b>UR</b></td>";
					foreach ($cat_details as $discips) {
						$total_ur = $total_ur + $discips->acat_ur;
						$my_html = $my_html . "<td>" . $discips->acat_ur . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ur . "</i></td>
				</tr>
				<tr>	
					<td><b>UR (E.C.)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ur2 = $total_ur2 + $discips->acat_ur_ec;
						$my_html = $my_html . "<td>" . $discips->acat_ur_ec . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ur2 . "</i></td>
				</tr>
				<tr>	
					<td><b>UR (Ex-Serviceman in Group-C Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ur3 = $total_ur3 + $discips->acat_ur_g_c;
						$my_html = $my_html . "<td>" . $discips->acat_ur_g_c . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ur3 . "</i></td>
				</tr>
				<tr>
					<td><b>UR (Ex-Serviceman in Group-D Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ur4 = $total_ur4 + $discips->acat_ur_g_d;
						$my_html = $my_html . "<td>" . $discips->acat_ur_g_d . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ur4 . "</i></td>
				</tr>
				<tr>
					<td><b>UR (Meritorious Sports Person)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ur5 = $total_ur5 + $discips->acat_ur_sp;
						$my_html = $my_html . "<td>" . $discips->acat_ur_sp . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ur5 . "</i></td>
				</tr>
				<tr>
					<td><b>SC</b></td>";
					foreach ($cat_details as $discips) {
						$total_sc = $total_sc + $discips->acat_sc;
						$my_html = $my_html . "<td>" . $discips->acat_sc . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_sc . "</i></td>
				</tr>
				<tr>
					<td><b>SC (E.C.)</b></td>";
					foreach ($cat_details as $discips) {
						$total_sc2 = $total_sc2 + $discips->acat_sc_ec;
						$my_html = $my_html . "<td>" . $discips->acat_sc_ec . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_sc2 . "</i></td>
				</tr>
				<tr>
					<td><b>SC (Ex-Serviceman in Group-C Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_sc3 = $total_sc3 + $discips->acat_sc_g_c;
						$my_html = $my_html . "<td>" . $discips->acat_sc_g_c . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_sc3 . "</i></td>
				</tr>
				<tr>
					<td><b>SC (Ex-Serviceman in Group-D Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_sc4 = $total_sc4 + $discips->acat_sc_g_d;
						$my_html = $my_html . "<td>" . $discips->acat_sc_g_d . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_sc4 . "</i></td>
				</tr>
				<tr>
					<td><b>ST</b></td>";
					foreach ($cat_details as $discips) {
						$total_st = $total_st + $discips->acat_st;
						$my_html = $my_html . "<td>" . $discips->acat_st . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_st . "</i></td>
				</tr>
				<tr>
					<td><b>ST (E.C.)</b></td>";
					foreach ($cat_details as $discips) {
						$total_st2 = $total_st2 + $discips->acat_st_ec;
						$my_html = $my_html . "<td>" . $discips->acat_st_ec . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_st2 . "</i></td>
				</tr>
				<tr>
					<td><b>ST (Ex-Serviceman in Group-D Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_st3 = $total_st3 + $discips->acat_st_g_d;
						$my_html = $my_html . "<td>" . $discips->acat_st_g_d . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_st3 . "</i></td>
				</tr>
				<tr>
					<td><b>OBC</b></td>";
					foreach ($cat_details as $discips) {
						$total_o = $total_o + $discips->acat_obc;
						$my_html = $my_html . "<td>" . $discips->acat_obc . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_o . "</i></td>
				</tr>
				<tr>
					<td><b>OBC-A</b></td>";
					foreach ($cat_details as $discips) {
						$total_oa = $total_oa + $discips->acat_obc_a;
						$my_html = $my_html . "<td>" . $discips->acat_obc_a . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_oa . "</i></td>
				</tr>
				<tr>
					<td><b>OBC Category-A (E.C.)</b></td>";
					foreach ($cat_details as $discips) {
						$total_oa2 = $total_oa2 + $discips->acat_obc_a_ec;
						$my_html = $my_html . "<td>" . $discips->acat_obc_a_ec . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_oa2 . "</i></td>
				</tr>
				<tr>
					<td><b>OBC Category-A (Ex-Serviceman in Group-D Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_oa3 = $total_oa3 + $discips->acat_obc_a_g_d;
						$my_html = $my_html . "<td>" . $discips->acat_obc_a_g_d . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_oa3 . "</i></td>
				</tr>
				<tr>
					<td><b>OBC-B</b></td>";
					foreach ($cat_details as $discips) {
						$total_ob = $total_ob + $discips->acat_obc_b;
						$my_html = $my_html . "<td>" . $discips->acat_obc_b . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ob . "</i></td>
				</tr>
				<tr>
					<td><b>OBC Category-B (E.C.)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ob2 = $total_ob2 + $discips->acat_obc_b_ec;
						$my_html = $my_html . "<td>" . $discips->acat_obc_b_ec . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ob2 . "</i></td>
				</tr>
				<tr>
					<td><b>OBC Category-B (Ex-Serviceman in Group-D Post)</b></td>";
					foreach ($cat_details as $discips) {
						$total_ob3 = $total_ob3 + $discips->acat_obc_b_g_d;
						$my_html = $my_html . "<td>" . $discips->acat_obc_b_g_d . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_ob3 . "</i></td>
				</tr>
				<tr>
					<td><b>PWD</b></td>";
					foreach ($cat_details as $discips) {
						$total_pwd = $total_pwd + $discips->acat_pwd;
						$my_html = $my_html . "<td>" . $discips->acat_pwd . "</td>";
					}
					$my_html = $my_html . "<td><i>" . $total_pwd . "</i></td>
				</tr>";
				/*if($app_details->adv_has_exampted == "Yes"){
					$my_html = $my_html . "<tr>
						<td><b>EXEMPTED</b></td>";
						foreach ($cat_details as $discips) {
							$total_exc = $total_exc + $discips->acat_exc;
							$my_html = $my_html . "<td>" . $discips->acat_exc . "</td>";
						}
						$my_html = $my_html . "<td><i>" . $total_exc . "</i></td>
					</tr>";
				}
				if($app_details->adv_has_exservice == "Yes"){
					$my_html = $my_html . "<tr>
						<td><b>EX-SERVICE MAN</b></td>";
						foreach ($cat_details as $discips) {
							$total_exs = $total_exs + $discips->acat_exs;
							$my_html = $my_html . "<td>" . $discips->acat_exs . "</td>";
						}
						$my_html = $my_html . "<td><i>" . $total_exs . "</i></td>
					</tr>";
				}
				if($app_details->adv_has_ews == "Yes"){
					$my_html = $my_html . "<tr>
						<td><b>EWS</b></td>";
						foreach ($cat_details as $discips) {
							$total_ews = $total_ews + $discips->acat_ews;
							$my_html = $my_html . "<td>" . $discips->acat_ews . "</td>";
						}
						$my_html = $my_html . "<td><i>" . $total_ews . "</i></td>
					</tr>";
				}*/
				$my_html = $my_html . "<tr>
					<td><b>TOTAL</b></td>";
					foreach ($cat_details as $discips) {
						$total_of_total = $total_of_total + $discips->acat_total;
						$my_html = $my_html . "<td><b>" . $discips->acat_total . "</b></td>";
					}
					$my_html = $my_html . "<td><b>" . $total_of_total . "</b></td>
				</tr>";
			$my_html = $my_html . "</table>
		</p>
		<p align=\"justify\"><u><b>Qualification:</b></u><br/>
		<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Sl No.</b></td>
				<td><b>Qualification</b></td>
				<td><b>Type</b></td>
				<td><b>Total Marks</b></td>
				<td><b>Distribution Category</b></td>
				<td><b>Segregation</b></td>
				<td><b>Additional Attempt</b></td>
				<td><b>Marks deduction per additional attempt</b></td>
			</tr>";
			//$qrtype = "";
			foreach($q_list as $keys=>$qips){
				$my_html = $my_html . "<tr>
					<td>".($keys+1)."</td>";
				/*if($qrtype != ""){
					$my_html = $my_html . "<td>".$qrtype."</td><td>".$qips->qm_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$qips->qm_name."</td>";
				}*/
				$my_html = $my_html . "<td>".$qips->qm_name."</td>";
				$my_html = $my_html . "<td>".$qips->aquali_examtype."</td>";
				$my_html = $my_html . "<td>".$qips->aquali_marks."</td>";
				$my_html = $my_html . "<td>".$qips->aquali_category."</td>";
				if($qips->aquali_category == "Slab"){
					$my_html = $my_html . "<td>
					<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
						<tr>
							<td><b>Upto Section</b></td>
							<td><b>Marks</b></td>
						</tr>";
						foreach ($qdetail_list as $qd_sets) {
							if ($qips->aquali_id == $qd_sets->aq_qualification_ms) {
								$my_html = $my_html . "<tr>
									<td>".$qd_sets->aq_detail_score_lvl."</td>
									<td>".$qd_sets->aq_detail_score_mark."</td>
								</tr>";
							}
						}
					$my_html = $my_html . "</table>
					</td>";
				}elseif($qips->aquali_category == "Percent"){
					$my_html = $my_html . "<td>".$qips->aquali_fullpercent."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td>";
				}
				$my_html = $my_html . "<td>";
				if($qips->aquali_attempt == "No"){
					$my_html = $my_html ."Will not be evaluated</td>";
				}elseif($qips->aquali_attempt == "Full"){
					$my_html = $my_html ."To be evaluated</td>";
				}elseif($qips->aquali_attempt == "Percent"){
					$my_html = $my_html ."To be evaluated</td>";
				}elseif($qips->aquali_attempt == "Slab"){
					$my_html = $my_html ."To be evaluated</td>";
				}
				if($qips->aquali_attempt == "Slab"){
					$my_html = $my_html . "<td>
					<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
						<tr>
							<td><b>Upto Section</b></td>
							<td><b>Marks</b></td>
						</tr>";
						foreach ($qdeduct_list as $qd_sets) {
							if ($qips->aquali_id == $qd_sets->aq_deduction_ms) {
								$my_html = $my_html . "<tr>
									<td>".$qd_sets->aq_deduct_lvl."</td>
									<td>".$qd_sets->aq_deduct_mark."</td>
								</tr>";
							}
						}
					$my_html = $my_html . "</table>
					</td>";
				}elseif($qips->aquali_attempt == "Full" || $qips->aquali_attempt == "Percent"){
					$my_html = $my_html . "<td>".$qips->aquali_fullpercent."</td>";
				}else{
					$my_html = $my_html . "<td>Not Applicable</td>";
				}
				$my_html = $my_html . "</tr>";
				//$qrtype = $qips->aquali_relation;
			}
			$my_html = $my_html . "</table>";
			if($app_details->adv_essen_qualification != ""){
				$my_html = $my_html . "<p align=\"justify\">Essential: " . $app_details->adv_essen_qualification. "</p>";
			}
			if($app_details->adv_desir_qualification != ""){
				$my_html = $my_html . "<p align=\"justify\">Desirable: " . $app_details->adv_desir_qualification . "</p>";
			}	 
			$my_html = $my_html . "</p>
		<p align=\"justify\"><b>Age:</b> Date of birth should be between " . date('d-M-Y',strtotime($app_details->adv_age_limit)) . " and " . date('d-M-Y',strtotime($app_details->adv_min_age_limit)) . " for all candidates; ";
		if($app_details->adv_age_updown != 0){
			$my_html = $my_html . "Maximum Relaxation is ".$app_details->adv_age_updown." Years";
		}
		$my_html = $my_html . "</p>";
		if(!empty($age_details)){
			$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Fee & Age Relaxation:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Section</b></td>
				<td><b>Relaxation Year</b></td>
				<td><b>Fee Type</b></td>
				<td><b>Part Fee</b></td>
			</tr>";
			//$rtype = "";
			foreach($age_details as $agesss){
				$my_html = $my_html . "<tr>";
				/*if($rtype != ""){
					$my_html = $my_html . "<td>".$rtype."</td><td>".$agesss->caste_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$agesss->caste_name."</td>";
				}*/
				$my_html = $my_html . "<td>".$agesss->caste_name."</td>";
				$my_html = $my_html . "<td>".$agesss->advage_up." Years</td>";
				if($agesss->advage_feetype == "Full"){
					$my_html = $my_html . "<td>Not Exempted</td><td>&nbsp;</td>";
				}elseif($agesss->advage_feetype == "Part"){
					$my_html = $my_html . "<td>Partly Exempted</td><td>".$agesss->advage_partfee."</td>";
				}elseif($agesss->advage_feetype == "No"){
					$my_html = $my_html . "<td>Exempted</td><td>&nbsp;</td>";
				}elseif($agesss->advage_feetype == "NA"){
					$my_html = $my_html . "<td>Not Applicable</td><td>&nbsp;</td>";
				}
				$my_html = $my_html . "</tr>";
				//$rtype = $agesss->advage_type;
			}
			$my_html = $my_html . "</table>
			</p>";
		}
		if($app_details->adv_age_writeup != ""){
			$my_html = $my_html . "<p align=\"justify\">Age: " . $app_details->adv_age_writeup . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\"><b>Fee:</b> Candidates must submit the online application fee amounting Rs. " . (int)$app_details->adv_fees . "/- (".$amt_in_word.") only through Banks participating in the GRPS (Govt. Receipt Portal System).</p>
		<p align=\"justify\"><b>Money order, Cheque, Bank Draft, and Cash etc. shall not be accepted.</b></p>
		<p align=\"justify\">No application shall be considered unless accompanied by the requisite application fee excepting Candidates belonging to SC/ST category of West Bengal and persons with disabilities specified under Disabilities Rule, 1999 (certificates obtained before the Advertisement date) who do not require to pay any fee. Such exemption of fee is, however, not applicable to any OBC candidate.</p>
		<p align=\"justify\"><b>No claim for refund of the fee shall be entertained nor shall it be held in reserved for any other examination.</b></p>
		<p align=\"justify\"><b>In case, any of the statement made in the application subsequently found to be false within the knowledge of the candidates- his/her candidature shall be liable to be cancelled, and even if appointed to a post on the results of this examination his/her appointment shall be liable to be terminated. Willful suppression of any material fact shall also be similarly dealt with.</b></p>
		<p align=\"justify\">Candidates should take particular note that entries in their application submitted to the Board must be made correctly against all the items which shall be treated as final and <b><u>no alteration , addition or deletion in this regard shall be allowed after full submission of the application</u>.</b> Application not duly filled in or found incomplete or defective in any respect or without fee shall be liable to rejection.</p>
		<p align=\"justify\"><b><u>Candidates must fulfill the essential qualification at the time of submission of application. No degree or experience certificate issued after the last date of submission of application will be considered.</u></b></p>
		<p align=\"justify\"><b>Particulars and Certificates required:</b><br/>
		(a) A candidate claiming to be S.C./S.T./O.B.C. must have a certificate in support of his/her claim from a competent authority of West Bengal as specified below [vide the west Bengal SCs and STs (Identification) Act, 1994 and SCs /STs Welfare Department order No. 261-TW/EC/MR-103/94 dated with B.C.W. Deptt. Order No. 6320-BCH/MR-84/10 dated 24.09.20l0]:
		<ul>
			<li>In the District, the Sub-Divisional Officer of the Sub-Division concerned, and</li>
			<li>In Kolkata, District Welfare Officer, Kolkata & ex-officio Jt. Director, Backward Classes Welfare Deptt., Govt. of West Bengal [No.2420-BCW/MR-61/2012 (Pt.) dated 12.07.13.</li>
		</ul><br/>
		<b>No claim for being a member of the SC, ST and OBC, or a Person with Disability shall be entertained after submission of the application</b></p>
		<p align=\"justify\">(b) Persons with Disabilities (physically handicapped) must have a certificate from an appropriate Medical Board [vide West Bengal Persons with Disabilities (Equal Opportunities, Protection of Rights and Full Participation) Rules, 1999]</p>
		<p align=\"justify\">(c) The West Bengal Health Recruitment Board (WBHRB) may require such further proof or particulars from the candidates as it may consider necessary and may make enquiries regarding eligibility. Original Certificates relating to citizenship (by registration), age, qualifications, caste (SC/ST/BC), Physical disability shall have to be submitted when the WBHRB asks for them. If any candidate fails to furnish any certificate or any other relevant document or information relating to his/her candidature within the time specified by the Board, his/her claim for allotment may be passed over without further reference to him/her.</p>";
		if($app_details->adv_disability != ""){
			$my_html = $my_html . "<p align=\"justify\">" . $app_details->adv_disability . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\">Submission of more than one application is strictly forbiddened.</p>
		<p align=\"justify\"><b>A candidate should note that his/her participation in the examination & interview process shall be deemed provisional subject to determination of his/her eligibility in all respects. If at any stage even after issuance of the letter of appointment a candidate is found in-eligible for admission to this Examination, his/her Candidature shall be cancelled without further reference to him/her.</b></p>
		<p align=\"justify\"><b>Canvassing:</b> Any attempt on the part of candidate to enlist support for his/her application shall disqualify him/her for appointment.</p>
		<p align=\"justify\"><b>Applicants need to take print-out of the application form. Two copies have to be submitted at the time of the recruitment Process.</b></p>
		<p align=\"justify\">Note:- Candidates are advised in their own interest to apply using Online Application Form, much before the closing date and not to wait till the last date to avoid congestion on Web-Server on account of heavy load on website.</p>";
		if($app_details->adv_has_experience == "Yes"){
			$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Experience:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Category</b></td>
				<td><b>Type</b></td>
				<td><b>Total Marks</b></td>
				<td><b>Minimum Month</b></td>
				<td><b>Distribution Category</b></td>
				<td><b>Segregation</b></td>
			</tr>";
			//$extype = "";
			foreach ($exp_list as $exps) {
				$my_html = $my_html."<tr>";
				/*if($extype != ""){
					$my_html = $my_html . "<td>".$extype."</td><td>".$exps->expset_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$exps->expset_name."</td>";
				}*/
				$my_html = $my_html . "<td>".$exps->expset_name."</td>";
				$my_html = $my_html . "<td>".$exps->aexpr_type."</td>
				<td>".$exps->aexpr_marks."</td>
				<td>".$exps->aexpr_min_month."</td>
				<td>".$exps->aexpr_category."</td>";
				$my_html = $my_html . "<td>";
				if ($exps->aexpr_category == "Slab") {
					$my_html = $my_html . "<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
					<tr>
						<td><b>Section</b></td>
						<td><b>Months</b></td>
						<td><b>Marks</b></td>
					</tr>";
						
						foreach ($expdetail_list as $exp_sets) {
							if ($exps->aexpr_id == $exp_sets->ae_experience_ms) {
								$my_html = $my_html . "<tr>";
								if ($exp_sets->ae_range_words == "GT") {
									$my_html = $my_html . "<td>Greater Than Equal</td>";
								} else {
									$my_html = $my_html . "<td>Less Than</td>";
								}
								$my_html = $my_html . "<td>".$exp_sets->ae_detail_month."</td>
									<td>".$exp_sets->ae_detail_mark."</td>
								</tr>";
							}
						}
						$my_html = $my_html . "</table>";
				}else{
					$my_html = $my_html . "&nbsp;";
				}
				$my_html = $my_html . "</td></tr>";
				//$extype = $exps->aexpr_relation;
			}
			$my_html = $my_html . "</table>
			</p>";
		}
		if($app_details->adv_marks_writeup != ""){
			$my_html = $my_html . "<p align=\"justify\">Experience: " . $app_details->adv_marks_writeup . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Marks Distribution:</b><br/>
		<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
		<tr>
			<td><b>Academic Marks</b></td>
			<td><b>Experience Marks</b></td>
			<td><b>Interview Marks</b></td>
			<td><b>Written Marks</b></td>
		</tr>
		<tr>
			<td>".$app_details->amark_academic."</td>
			<td>".$app_details->amark_experience."</td>
			<td>".$app_details->amark_interview."</td>
			<td>".$app_details->amark_written."</td>
		</tr>";
		$my_html = $my_html . "</table>
		</p>";
		if($app_details->adv_miscellenius != ""){
			$my_html = $my_html . "<p align=\"justify\">" . $app_details->adv_miscellenius . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\"><b>Applications received after the scheduled date and time for submission of application will be rejected.</b></p>
		</div>
		</td></tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr>
			<td style=\"width:50%;\"><div><b>Date: " . date('d-m-Y',strtotime($app_details->adv_start_time . ' -1 day')) . "</b></div></td>
			<td style=\"width:50%;\">
			<div align=\"center\" style=\"overflow:hidden;\">
			<b>Sd/-</b>
			<hr style=\"width:76%;\" />
			<b>Secretary & Controller of Examinations<br/>
			West Bengal Health Recruitment Board</b>
			</div>
			</td>
		</tr>
		</table>
		</div>
		</body>
		</html>";

		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($title . '.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');

		//$this->session->set_flashdata("success","Report is Generated Successfully");

		/*<tr>
		<td><div><b>Date: " . date('d-m-Y') . "</b></div></td>
		<td><div align=\"center\" style=\"border-top:2px #000 solid\">
		<b>Secretary & Controller of Examinations<br/>
		West Bengal Health Recruitment Board</b>
		</div></td>
		</tr>*/
	}

	public function generate412555564575678_and_print_advertisement($advise_no = NULL)
	{
		if ($advise_no == "" || $advise_no == NULL) {
			redirect('default404');
		}

		$app_details = $this->admin_m->getAll_detaillist_of_Avvertisement($advise_no);
		if (count((array)$app_details) == 0) {
			redirect('default404');
		}
		$cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advise_no);
		if (count((array)$cat_details) == 0) {
			redirect('default404');
		}
		$q_list = $this->admin_m->getAll_Quali_detaillist_of_Advertisement($advise_no);
		$qdetail_list = $this->admin_m->getAll_DetailsQuali_of_Advertisement($advise_no);
		$qdeduct_list = $this->admin_m->getAll_DeductionDetailsQuali_of_Advertisement($advise_no);
		$exp_list = $this->admin_m->getAll_Expr_detaillist_of_Advertisement($advise_no);
		$expdetail_list = $this->admin_m->getAll_DetailsExpr_of_Advertisement($advise_no);
		$age_details = $this->admin_m->getAll_AgeFee_detaillist_of_Advertisement($advise_no);
		//echo "<pre>";
		//print_r($age_details);
		/*$copy_arr = explode(",", $app_details->appli_copy_fwd);
		$copy_set = $this->main_m->get_all_conditions_copys_DB($app_details->appli_copy_fwd);
		if(count((array)$copy_set) == 0){
			redirect('default404');
		}*/
		//echo "hi";exit;
		$amt_in_word = $this->convertTo_Text($app_details->adv_fees);

		$this->load->helper("tcpdf_helper");
		tcpdf();
		//$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $advise_no;
		$obj_pdf->SetTitle('Advertisement');
		$obj_pdf->SetAuthor('WB-HRB');
		$obj_pdf->SetSubject('Advertisement Notice');

		$obj_pdf->SetPrintHeader(false);
		//$obj_pdf->SetPrintFooter(false);
		//$obj_pdf->setFooterData(array(0,64,0), array(0,64,128));

		//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
		//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		//$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//$obj_pdf->SetFont('helvetica', '', 9);
		//$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		</head>
		<body>
		<div class=\"header\">";
		$my_html = $my_html . "<table style=\"width: 100%\" style=\"font-size: 22px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\">
				<table style=\"width: 100%\" style=\"font-size: 22px;\">
				<tr>
				<td style=\"width:20%;\">
				<div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:200px;\" /></div>
				</td>
				<td style=\"width:60%;\">
					<div align=\"center\">
					<span style=\"font-size:28px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
					<span align=\"center\" style=\"font-size:24px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor)</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\">GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
					<span align=\"center\" style=\"font-size:20px;font-weight:normal;\"><u>www.wbhrb.in</u>, Phone : 2357-0085</span></div>
					<div align=\"center\" style=\"font-size:22px;font-weight:bold;\"><i>Advertisement No.: " . $app_details->adv_no . "</i><br/>
					<u>Recruitment for " . $app_details->rm_name . "</u></div>
				</td>
				<td style=\"width:20%;\">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td colspan=\"2\"><div><p align=\"justify\"><strong>Online applications are invited from Indian Citizen for recruitment to the Post of " . $app_details->rm_name . " under Health & Family Welfare Department, Government of West Bengal.</strong></p>
		<p align=\"justify\">Only online registration & submission of Application will be allowed on the website <b>(www.wbhrb.in)</b> between <b>" . date('d.m.Y', strtotime($app_details->adv_start_time)) . " to " . date('d.m.Y', strtotime($app_details->adv_end_time)) . " (Before " . date('h A', strtotime($app_details->adv_end_time)) . ")</b>.</p>
		<p align=\"justify\">Appointments are temporary but likely to be permanent.</p>
		<p align=\"justify\"><b>The relevant rules and necessary particulars are stated in the following paragraph:</b></p>
		<p align=\"justify\">A candidate should verify from the notified eligibility criteria to ascertain whether he/ she is eligible for submission of application. The condition prescribed cannot be relaxed. The recruitment will be made by selection, but where a large number of applications are received, as a result of Advertisement, the Board may, for the purpose of short-listing, hold a preliminary examination.</p>
		<p align=\"justify\"><b>Scale of Pay:</b> " . $app_details->adv_scale_pay . "</p>
		<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Anticipated Vacancies:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">";
				/*$total_exc = 0;
				$total_exs = 0;
				foreach($cat_details as $discips){
					$total_exc = $total_exc + $discips->acat_exc;
					$total_exs = $total_exs + $discips->acat_exs;
				}*/
				$rowcounter = 9;
				if($app_details->adv_has_exampted == "Yes"){
					$rowcounter++;
				}
				if($app_details->adv_has_exservice == "Yes"){
					$rowcounter++;
				}
				if($app_details->adv_has_ews == "Yes"){
					$rowcounter++;
				}
				$my_html = $my_html . "<tr><td colspan=\"".$rowcounter."\"><b>Name of the Post - </b>" . $app_details->rm_name . "</td></tr>
				<tr>
				<td><b>Post</b></td>
				<td><b>UR</b></td>
				<td><b>SC</b></td>
				<td><b>ST</b></td>
				<td><b>OBC</b></td>
				<td><b>OBC-A</b></td>
				<td><b>OBC-B</b></td>
				<td><b>PWD</b></td>";
				if($app_details->adv_has_exampted == "Yes"){
					$my_html = $my_html . "<td><b>EXEMPTED</b></td>";
				}
				if($app_details->adv_has_exservice == "Yes"){
					$my_html = $my_html . "<td><b>EX-SERVICE MAN</b></td>";
				}
				if($app_details->adv_has_ews == "Yes"){
					$my_html = $my_html . "<td><b>EWS</b></td>";
				}
				$my_html = $my_html . "<td><b>TOTAL</b></td>
				</tr>";
				$total_ur = 0;
				$total_sc = 0;
				$total_st = 0;
				$total_o = 0;
				$total_oa = 0;
				$total_ob = 0;
				$total_pwd = 0;
				$total_exc = 0;
				$total_exs = 0;
				$total_ews = 0;
				$total_of_total = 0;
				foreach ($cat_details as $discips) {
					$total_ur = $total_ur + $discips->acat_ur;
					$total_sc = $total_sc + $discips->acat_sc;
					$total_st = $total_st + $discips->acat_st;
					$total_o = $total_o + $discips->acat_obc;
					$total_oa = $total_oa + $discips->acat_obc_a;
					$total_ob = $total_ob + $discips->acat_obc_b;
					$total_pwd = $total_pwd + $discips->acat_pwd;
					$total_exc = $total_exc + $discips->acat_exc;
					$total_exs = $total_exs + $discips->acat_exs;
					$total_ews = $total_ews + $discips->acat_ews;
					$total_of_total = $total_of_total + $discips->acat_total;
					$my_html = $my_html . "<tr>
					<td>" . $discips->catm_name . "</td>
					<td>" . $discips->acat_ur . "</td>
					<td>" . $discips->acat_sc . "</td>
					<td>" . $discips->acat_st . "</td>
					<td>" . $discips->acat_obc . "</td>
					<td>" . $discips->acat_obc_a . "</td>
					<td>" . $discips->acat_obc_b . "</td>
					<td>" . $discips->acat_pwd . "</td>";
					if($app_details->adv_has_exampted == "Yes"){
						$my_html = $my_html . "<td>" . $discips->acat_exc . "</td>";
					}
					if($app_details->adv_has_exservice == "Yes"){
						$my_html = $my_html . "<td>" . $discips->acat_exs . "</td>";
					}
					if($app_details->adv_has_ews == "Yes"){
						$my_html = $my_html . "<td>" . $discips->acat_ews . "</td>";
					}
					$my_html = $my_html . "<td><b>" . $discips->acat_total . "</b></td>
					</tr>";
				}
				$my_html = $my_html . "<tr>
					<td><i>Total</i></td>
					<td><i>" . $total_ur . "</i></td>
					<td><i>" . $total_sc . "</i></td>
					<td><i>" . $total_st . "</i></td>
					<td><i>" . $total_o . "</i></td>
					<td><i>" . $total_oa . "</i></td>
					<td><i>" . $total_ob . "</i></td>
					<td><i>" . $total_pwd . "</i></td>";
					if($app_details->adv_has_exampted == "Yes"){
						$my_html = $my_html . "<td><i>" . $total_exc . "</i></td>";
					}
					if($app_details->adv_has_exservice == "Yes"){
						$my_html = $my_html . "<td><i>" . $total_exs . "</i></td>";
					}
					if($app_details->adv_has_ews == "Yes"){
						$my_html = $my_html . "<td><i>" . $total_ews . "</i></td>";
					}
					$my_html = $my_html . "<td><i><b>" . $total_of_total . "</b></i></td>
					</tr>";
			$my_html = $my_html . "</table>
		</p>
		<p align=\"justify\"><u><b>Qualification:</b></u><br/>
		<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Sl No.</b></td>
				<td><b>Relation</b></td>
				<td><b>Qualification</b></td>
				<td><b>Type</b></td>
				<td><b>Total Marks</b></td>
				<td><b>Distribution Category</b></td>
				<td><b>Segregation</b></td>
				<td><b>Additional Attempt</b></td>
				<td><b>Marks deduction per additional attempt</b></td>
			</tr>";
			$qrtype = "";
			foreach($q_list as $keys=>$qips){
				$my_html = $my_html . "<tr>
					<td>".($keys+1)."</td>";
				if($qrtype != ""){
					$my_html = $my_html . "<td>".$qrtype."</td><td>".$qips->qm_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$qips->qm_name."</td>";
				}
				$my_html = $my_html . "<td>".$qips->aquali_examtype."</td>";
				$my_html = $my_html . "<td>".$qips->aquali_marks."</td>";
				$my_html = $my_html . "<td>".$qips->aquali_category."</td>";
				if($qips->aquali_category == "Slab"){
					$my_html = $my_html . "<td>
					<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
						<tr>
							<td><b>Upto Section</b></td>
							<td><b>Marks</b></td>
						</tr>";
						foreach ($qdetail_list as $qd_sets) {
							if ($qips->aquali_id == $qd_sets->aq_qualification_ms) {
								$my_html = $my_html . "<tr>
									<td>".$qd_sets->aq_detail_score_lvl."</td>
									<td>".$qd_sets->aq_detail_score_mark."</td>
								</tr>";
							}
						}
					$my_html = $my_html . "</table>
					</td>";
				}elseif($qips->aquali_category == "Percent"){
					$my_html = $my_html . "<td>".$qips->aquali_fullpercent."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td>";
				}
				$my_html = $my_html . "<td>";
				if($qips->aquali_attempt == "No"){
					$my_html = $my_html ."Will not be evaluated</td>";
				}elseif($qips->aquali_attempt == "Full"){
					$my_html = $my_html ."To be evaluated</td>";
				}elseif($qips->aquali_attempt == "Percent"){
					$my_html = $my_html ."To be evaluated</td>";
				}elseif($qips->aquali_attempt == "Slab"){
					$my_html = $my_html ."To be evaluated</td>";
				}
				if($qips->aquali_attempt == "Slab"){
					$my_html = $my_html . "<td>
					<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
						<tr>
							<td><b>Upto Section</b></td>
							<td><b>Marks</b></td>
						</tr>";
						foreach ($qdeduct_list as $qd_sets) {
							if ($qips->aquali_id == $qd_sets->aq_deduction_ms) {
								$my_html = $my_html . "<tr>
									<td>".$qd_sets->aq_deduct_lvl."</td>
									<td>".$qd_sets->aq_deduct_mark."</td>
								</tr>";
							}
						}
					$my_html = $my_html . "</table>
					</td>";
				}elseif($qips->aquali_attempt == "Full" || $qips->aquali_attempt == "Percent"){
					$my_html = $my_html . "<td>".$qips->aquali_fullpercent."</td>";
				}else{
					$my_html = $my_html . "<td>Not Applicable</td>";
				}
				$my_html = $my_html . "</tr>";
				$qrtype = $qips->aquali_relation;
			}
			$my_html = $my_html . "</table>";
			if($app_details->adv_essen_qualification != ""){
				$my_html = $my_html . "<p align=\"justify\">Essential: " . $app_details->adv_essen_qualification. "</p>";
			}
			if($app_details->adv_desir_qualification != ""){
				$my_html = $my_html . "<p align=\"justify\">Desirable: " . $app_details->adv_desir_qualification . "</p>";
			}	 
			$my_html = $my_html . "</p>
		<p align=\"justify\"><b>Age:</b> Date of birth should be between " . date('d-M-Y',strtotime($app_details->adv_age_limit)) . " and " . date('d-M-Y',strtotime($app_details->adv_min_age_limit)) . " for all candidates; ";
		if($app_details->adv_age_updown != 0){
			$my_html = $my_html . "Maximum Relaxation is ".$app_details->adv_age_updown." Years";
		}
		$my_html = $my_html . "</p>";
		if(!empty($age_details)){
			$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Fee & Age Relaxation:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Relation</b></td>
				<td><b>Section</b></td>
				<td><b>Relaxation Year</b></td>
				<td><b>Fee Type</b></td>
				<td><b>Part Fee</b></td>
			</tr>";
			$rtype = "";
			foreach($age_details as $agesss){
				$my_html = $my_html . "<tr>";
				if($rtype != ""){
					$my_html = $my_html . "<td>".$rtype."</td><td>".$agesss->caste_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$agesss->caste_name."</td>";
				}
				$my_html = $my_html . "<td>".$agesss->advage_up." Years</td>";
				if($agesss->advage_feetype == "Full"){
					$my_html = $my_html . "<td>Not Exempted</td><td>&nbsp;</td>";
				}elseif($agesss->advage_feetype == "Part"){
					$my_html = $my_html . "<td>Partly Exempted</td><td>".$agesss->advage_partfee."</td>";
				}elseif($agesss->advage_feetype == "No"){
					$my_html = $my_html . "<td>Exempted</td><td>&nbsp;</td>";
				}elseif($agesss->advage_feetype == "NA"){
					$my_html = $my_html . "<td>Not Applicable</td><td>&nbsp;</td>";
				}
				$my_html = $my_html . "</tr>";
				$rtype = $agesss->advage_type;
			}
			$my_html = $my_html . "</table>
			</p>";
		}
		if($app_details->adv_age_writeup != ""){
			$my_html = $my_html . "<p align=\"justify\">" . $app_details->adv_age_writeup . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\"><b>Fee:</b> Candidates must submit the online application fee amounting Rs. " . $app_details->adv_fees . "/- (".$amt_in_word.") only through Banks participating in the GRPS (Govt. Receipt Portal System).</p>
		<p align=\"justify\"><b>Money order, Cheque, Bank Draft, and Cash etc. shall not be accepted.</b></p>
		<p align=\"justify\">No application shall be considered unless accompanied by the requisite application fee excepting Candidates belonging to SC/ST category of West Bengal and persons with disabilities specified under Disabilities Rule, 1999 (certificates obtained before the Advertisement date) who do not require to pay any fee. Such exemption of fee is, however, not applicable to any OBC candidate.</p>
		<p align=\"justify\"><b>No claim for refund of the fee shall be entertained nor shall it be held in reserved for any other examination.</b></p>
		<p align=\"justify\"><b>In case, any of the statement made in the application subsequently found to be false within the knowledge of the candidates- his/her candidature shall be liable to cancellation, and even if appointed toa post on the results of this examination his/her appointment shall be liable to be terminated. Willful suppression of any material fact shall also be similarly dealt with.</b></p>
		<p align=\"justify\">Candidates should take particular note that entries in their application submitted to the Board must be made correctly against all the items which shall be treated as final and <b><u>no alteration , addition or deletion in this regard shall be allowed after full submission of the application</u>.</b> Application not duly filled in or found incomplete or defective in any respect or without fee shall be liable to rejection.</p>
		<p align=\"justify\"><b><u>Candidates must fulfill the essential qualification at the time of submission of application. No degree or experience certificate issued after the last date of submission of application will be considered.</u></b></p>
		<p align=\"justify\"><b>Particulars and Certificates required:</b><br/>
		(a) A candidate claiming to be S.C./S.T./O.B.C. must have a certificate in support of his/her claim from a competent authority of West Bengal as specified below [vide the west Bengal SCs and STs (Identification) Act, 1994 and SCs /STs Welfare Department order No. 261-TW/EC/MR-103/94 dated with B.C.W. Deptt. Order No. 6320-BCH/MR-84/10 dated 24.09.20l0]:
		<ul>
			<li>In the District, the Sub-Divisional Officer of the Sub-Division concerned, and</li>
			<li>In Kolkata, District Welfare Officer, Kolkata & ex-officio Jt. Director, Backward Classes Welfare Deptt., Govt. of West Bengal [No.2420-BCW/MR-61/2012 (Pt.) dated 12.07.13.</li>
		</ul><br/>
		<b>No claim for being a member of the SC, ST and OBC, or a Person with Disability shall be entertained after submission of the application</b></p>
		<p align=\"justify\">(b) Persons with Disabilities (physically handicapped) [40% and above] must have a certificate from an appropriate Medical Board [vide West Bengal Persons with Disabilities (Equal Opportunities, Protection of Rights and Full Participation) Rules, 1999]</p>
		<p align=\"justify\">(c) The West Bengal Health Recruitment Board (WBHRB) may require such further proof or particulars from the candidates as it may consider necessary and may make enquiries regarding eligibility. Original Certificates relating to citizenship (by registration), age, qualifications, caste (SC/ST/BC), Physical disability (40% and above) shall have to be submitted when the WBHRB asks for them. If any candidate fails to furnish any certificate or any other relevant document or information relating to his/her candidature within the time specified by the Board, his/her claim for Page 3 of 3 allotment may be passed over without further reference to him/her.</p>
		<p align=\"justify\">Submission of more than one application is strictly forbidden.</p>
		<p align=\"justify\"><b>A candidate should note that his/her participation in the examination & interview process shall be deemed provisional subject to determination of his/her eligibility in all respects. If at any stage even after issuance of the letter of appointment a candidate is found in-eligible for admission to this Examination, his/her Candidature shall be cancelled without further reference to him/her.</b></p>
		<p align=\"justify\"><b>Canvassing:</b> Any attempt on the part of candidate to enlist support for his/her application shall disqualify him/her for appointment.</p>
		<p align=\"justify\"><b>Applicants need to take print-out of the application form. Two copies have to be submitted at the time of recruitment Process.</b></p>
		<p align=\"justify\">Note:- Candidates are advised in their own interest to apply using Online Application Form, much before the closing date and not to wait till the last date to avoid congestion on Web-Server on account of heavy load on internet/website.</p>";
		if($app_details->adv_has_experience == "Yes"){
			$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Experience:</b><br/>
			<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
			<tr>
				<td><b>Relation</b></td>
				<td><b>Category</b></td>
				<td><b>Type</b></td>
				<td><b>Total Marks</b></td>
				<td><b>Minimum Month</b></td>
				<td><b>Distribution Category</b></td>
				<td><b>Segregation</b></td>
			</tr>";
			$extype = "";
			foreach ($exp_list as $exps) {
				$my_html = $my_html."<tr>";
				if($extype != ""){
					$my_html = $my_html . "<td>".$extype."</td><td>".$exps->expset_name."</td>";
				}else{
					$my_html = $my_html . "<td>&nbsp;</td><td>".$exps->expset_name."</td>";
				}
				$my_html = $my_html . "<td>".$exps->aexpr_type."</td>
				<td>".$exps->aexpr_marks."</td>
				<td>".$exps->aexpr_min_month."</td>
				<td>".$exps->aexpr_category."</td>";
				$my_html = $my_html . "<td>";
				if ($exps->aexpr_category == "Slab") {
					$my_html = $my_html . "<table align=\"center\" width=\"100%\" style=\"font-size: 14px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">
					<tr>
						<td><b>Section</b></td>
						<td><b>Months</b></td>
						<td><b>Marks</b></td>
					</tr>";
						
						foreach ($expdetail_list as $exp_sets) {
							if ($exps->aexpr_id == $exp_sets->ae_experience_ms) {
								$my_html = $my_html . "<tr>
									<td>".$exp_sets->ae_range_words."</td>
									<td>".$exp_sets->ae_detail_month."</td>
									<td>".$exp_sets->ae_detail_mark."</td>
								</tr>";
							}
						}
						$my_html = $my_html . "</table>";
				}else{
					$my_html = $my_html . "&nbsp;";
				}
				$my_html = $my_html . "</td></tr>";
				$extype = $exps->aexpr_relation;
			}
			$my_html = $my_html . "</table>
			</p>";
		}
		if($app_details->adv_marks_writeup != ""){
			$my_html = $my_html . "<p align=\"justify\">" . $app_details->adv_marks_writeup . "</p>";
		}
		$my_html = $my_html . "<p align=\"justify\" style=\"margin-bottom:0px !important;padding-bottom:0px !important;\"><b>Marks Distribution:</b><br/>
		<table align=\"center\" width=\"100%\" style=\"font-size: 16px;\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
		<tr>
			<td><b>Academic Marks</b></td>
			<td><b>Experience Marks</b></td>
			<td><b>Interview Marks</b></td>
			<td><b>Written Marks</b></td>
		</tr>
		<tr>
			<td>".$app_details->amark_academic."</td>
			<td>".$app_details->amark_experience."</td>
			<td>".$app_details->amark_interview."</td>
			<td>".$app_details->amark_written."</td>
		</tr>";
		$my_html = $my_html . "</table>
		</p>";
		$my_html = $my_html . "<p align=\"justify\"><b>Applications received after the scheduled date and time for submission of application will be rejected.</b></p>
		</div>
		</td></tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr><td colspan=\"2\">&nbsp;</td></tr>
		<tr>
		<td><div><b>Date: " . date('d-m-Y') . "</b></div></td>
		<td><div align=\"center\" style=\"border-top:2px #000 solid\">
		<b>Secretary & Controller of Examinations<br/>
		West Bengal Health Recruitment Board</b>
		</div></td>
		</tr>
		</table>
		</div>
		</body>
		</html>";

		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($title . '.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');

		//$this->session->set_flashdata("success","Report is Generated Successfully");

	}

	protected function convertTo_Text($number){
		//$number = 794175472345.08;
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		
		if(strlen($no) > 9){
				$no1 = floor($no / 10000000);
				$no2 = floor($no - ($no1 * 10000000));
				$result1 = $this->double_convert_string($no1, $no1);
				$result2 = $this->double_convert_string($no2, $no2);
				$result = $result1 . 'crore ' . $result2;
				//return $result;
		}else{
				$result = $this->double_convert_string($number, $no);
		}
		
	   
	   
	   $points = $this->double_convert_string($point, $point);
	   if($points != ""){
		   $final_result = "Rupees " . trim($result) . " and " . $points . " Paise";
	   }else{
		   $final_result = "Rupees " . trim($result);
	   }
	   return $final_result;
	   /*$points = ($point) ?
			   $words[$point / 10] . " " . 
			   $words[$point = $point % 10] : '';*/
	   
	}
	 
	protected function double_convert_string($number, $no){
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
		 '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
		 '7' => 'seven', '8' => 'eight', '9' => 'nine',
		 '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
		 '13' => 'thirteen', '14' => 'fourteen',
		 '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
		 '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
		 '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
		 '60' => 'sixty', '70' => 'seventy',
		 '80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
		  $divider = ($i == 2) ? 10 : 100;
		  $number = floor($no % $divider);
		  $no = floor($no / $divider);
		  $i += ($divider == 10) ? 1 : 2;
		  if ($number) {
			 $plural = (($counter = count($str)) && $number > 9) ? '' : null;
			 $hundred = ($counter == 1 && $str[0]) ? '' : null;
			 $str [] = ($number < 21) ? $words[$number] .
				 " " . $digits[$counter] . $plural . " " . $hundred
				 :
				 $words[floor($number / 10) * 10]
				 . " " . $words[$number % 10] . " "
				 . $digits[$counter] . $plural . " " . $hundred;
		  } else $str[] = null;
	   }
	   $str = array_reverse($str);
	   $result = implode('', $str);
	   return $result;
	}

	public function resubmit_process_list(){
		if($this->data["u_details"]->u_type != 1){
			//if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
				redirect('admincontrol/dashboard');
			//}
		}
		if ($_POST) {
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");

			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			if ($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid' => $rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				$this->data['adv_list'] = $this->admin_m->getAll_ResubmitList_Advertisementwise($advno);
			}
		} else {
			$this->data['adv_list'] = array();
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name', 'ASC')->where('rm_status', 1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/adv/resubmit_process_list_view', $this->data);
	}

	public function resubmit_process_for_advertisement(){
		if($this->data["u_details"]->u_type != 1){
			//if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"])){
				redirect('admincontrol/dashboard');
			//}
		}
		if($_POST){
			$rf_set = $this->input->post("rf_set");
			$advno = $this->input->post("advno");
			$reson_set = $this->input->post("reson_set");
			$u_startdate = $this->input->post('u_startdate');
			$u_enddate = $this->input->post('u_enddate');
			$u_starttime = $this->input->post('u_starttime');
			$u_endtime = $this->input->post('u_endtime');
			
			$this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
			$this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('reson_set', 'Reason of Resubmission', 'trim');
			$this->form_validation->set_rules('u_startdate', 'Start Date', 'trim|required');
			$this->form_validation->set_rules('u_enddate', 'End Date', 'trim|required');
			$this->form_validation->set_rules('u_starttime', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('u_endtime', 'End Time', 'trim|required');

			if($this->form_validation->run() == TRUE) {
				$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno);
				$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
				if(strtotime($u_enddate.' '.$u_endtime) > strtotime($u_startdate.' '.$u_starttime)){
					$ss_datetime = date('Y-m-d H:i:s',strtotime($u_startdate.' '.$u_starttime));
					$ee_datetime = date('Y-m-d H:i:s',strtotime($u_enddate.' '.$u_endtime));
					if($reson_set == ""){$reson_set = NULL;}
					$row_array = array(
						'adv_resub_master' => $advno,
						'adv_resub_starttime' => $ss_datetime,
						'adv_resub_endtime' => $ee_datetime,
						'adv_resub_reasons' => $reson_set,
						'adv_resub_createdate' => date('Y-m-d H:i:s'),
						'adv_resub_createby' => $this->session->userdata['uid']
					);
					if($this->admin_m->addmodify_ResubmitAdvertisement_Sets($row_array) == TRUE && $this->admin_m->shiftto_history_allthe_RejectCandidate_asper_Advertisement($advno) == TRUE){
						$this->session->set_flashdata('success','New Resubmission for Advertisement is added successfully');
						redirect('admincontrol/advertisement_set/resubmit_process_list','refresh');
					}else{
						$this->data['error'] = "There have some problem to Insert in DB, Try Again.";
					}
				}else{
					$this->data["error"] = "Start Date/Time is bigger than End Date/Time, Check it again.";
				}
			}
		}
		$this->data['rec_list'] = $this->db->order_by('rm_name', 'ASC')->where('rm_status', 1)->get('recruitment_master_tab')->result();
		$this->load->view('admin/adv/resubmit_advertisement_view', $this->data);
	}

	public function processall_the_resubmit_data_of_adv($advresub_id, $advno){
		if($advresub_id == NULL || $advno == NULL){
			redirect('admincontrol/advertisement_set/resubmit_process_list');
		}
		$curtime_set = date('Y-m-d H:i:s');
		$resub_detail = $this->db->where('adv_resub_id', $advresub_id)->where('adv_resub_master', $advno)->where('adv_resub_endtime < ', $curtime_set)->where('adv_resub_chk_stat', 0)->get('advertisement_resubmit_tab')->row();
		if(count((array)$resub_detail) == 0){
			redirect('admincontrol/advertisement_set/resubmit_process_list');
		}
		$row_array = array(
			'adv_resub_chk_stat' => 1,
			'adv_resub_chk_start' => date('Y-m-d H:i:s'),
			'adv_resub_modifydate' => date('Y-m-d H:i:s'),
			'adv_resub_modifyby' => $this->session->userdata['uid']
		);
		if($this->admin_m->allprocess_forChecking_and_delete_asper_Advertisement($advno) == TRUE){
			$this->admin_m->addmodify_ResubmitAdvertisement_Sets($row_array, $advresub_id);
			$this->session->set_flashdata('success','Advertisement Resubmission Processs is Done Successfully');
			redirect('admincontrol/advertisement_set/resubmit_process_list','refresh');
		}else{
			$this->session->set_flashdata('e_error','Advertisement Resubmission Processs Problem to Update, Try Again.');
			redirect('admincontrol/advertisement_set/resubmit_process_list','refresh');
		}
	}




	//================= new_scheme_submission =================================================================================================================

	public function modify_scheme_details($scm_no)
	{
		
		$this->data['scheme_master_data'] = $this->scheme_m->get_scheme_master($scm_no);

		if (count((array)$this->data['scheme_master_data']) == 0) 
		{
			redirect('admincontrol/scheme_set/all_scheme_list');
			
		}
		// else
		// {
		// 	redirect('admincontrol/scheme_set/all_scheme_list', 'refresh');
		// }
		$this->data['scheme_details_data'] = $this->scheme_m->get_scheme_details($scm_no);
		// echo '<pre>';
		// print_r($this->data['scheme_details_data']);
		// exit;
		$this->load->view('admin/scheme/edit_scheme_view', $this->data);
	}
	
	public function lock_scheme_set($scm_no = NULL)
	{
		// if($this->data["u_details"]->u_type != 1)
		// {
		// 	if(!in_array($this->data["u_details"]->u_id, $this->data["userlists"]))
		// 	{
		// 		redirect('admincontrol/dashboard');
		// 	}
		// }

		if ($scm_no == "" || $scm_no == NULL) 
		{
			redirect('admincontrol/scheme_set/all_scheme_list');
		}

		$row_arr = array(
			'scm_status' => 0
		);

		if ($this->scheme_m->update_scheme_status_to_lock_deactivated($row_arr, NULL, $scm_no) == TRUE) 
		{
			$this->session->set_flashdata("success", "Scheme is Locked & Deactivated successfully.");
			redirect('admincontrol/scheme_set/all_scheme_list', 'refresh');
		} 
		else 
		{
			$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
			redirect('admincontrol/scheme_set/all_scheme_list', 'refresh');
		}
	}

	public function unlock_scheme_set($scm_no = NULL)
	{
		if ($scm_no == "" || $scm_no == NULL) 
		{
			redirect('admincontrol/scheme_set/all_scheme_list');
		}

		$row_arr = array(
			'scm_status' => 1
		);

		if ($this->scheme_m->update_scheme_status_to_unlock_activated($row_arr, NULL, $scm_no) == TRUE) 
		{
			$this->session->set_flashdata("success", "Scheme is Unlocked & Activated successfully.");
			redirect('admincontrol/scheme_set/all_scheme_list', 'refresh');
		} 
		else 
		{
			$this->session->set_flashdata("e_error", "There have some problem to Update DB, Try Again.");
			redirect('admincontrol/scheme_set/all_scheme_list', 'refresh');
		}
	}

	public function new_scheme_submission()
	{
		if($_POST)
		{
			$sc_name = $this->input->post('sc_name');
			$sc_detail = $this->input->post('sc_detail');
			// $sc_amount = $this->input->post('sc_amount');
			// $sc_installment_no = $this->input->post('sc_installment_no');
			// $sc_ref_no = $this->input->post('sc_ref_no');
			// $sc_date = $this->input->post('sc_date');
			// $q_slnum = $this->input->post('q_slnum');
			// $q_slap = $this->input->post('q_slap');
			// $q_mark = $this->input->post('q_mark');
			$msg = 0;
			$err = 0;
			// $err_msg = '';

			//=============== Validation ===========================
			if(empty($sc_name) || $sc_name === NULL)
			{
				$err = 1;
				// $err_msg = 'Scheme Name Error.';
			}
			else if(empty($sc_detail) || $sc_detail === NULL)
			{
				$err = 1;
			}
			// else if(empty($sc_amount) || $sc_amount === NULL || is_nan($sc_amount))
			// {
			// 	$err = 1;
			// }
			// else if(empty($sc_installment_no) || $sc_installment_no === NULL || is_nan($sc_installment_no))
			// {
			// 	$err = 1;
			// }
			// else if(empty($sc_ref_no) || $sc_ref_no === NULL || is_nan($sc_ref_no))
			// {
			// 	$err = 1;
			// }
			// else if(empty($sc_date) || $sc_date === NULL)
			// {
			// 	$err = 1;
			// }
			// else if(count($q_slnum) == 0 || $q_slnum === NULL)  // array length 0 check.
			// {
			// 	$err = 1;
			// }
			// else if(count($q_slap) == 0 || $q_slap === NULL)   // array length 0 check.
			// {
			// 	$err = 1;
			// }
			// else if(count($q_mark) == 0 || $q_mark === NULL)   // array length 0 check.
			// {
			// 	$err = 1;
			// }


			if(!$err)
			{
				
				$row_array = array(
					'scm_name' => $sc_name,
					'scm_details' => $sc_detail,
					// 'scm_ref_no' => $sc_ref_no,
					// 'scm_amount' => $sc_amount,
					// 'scm_installment_no' => $sc_installment_no,
					// 'scm_date' => $sc_date,
					'scm_createdate' => date('Y-m-d H:i:s'),
					'scm_createby' => $this->session->userdata('uid'),
					// 'scm_modifydate' => date('Y-m-d H:i:s'),
					// 'scm_modifyby' => $gen_Set,
					'scm_status' => 1
				);

				if($scheme_id = $this->scheme_m->scheme_creation_add_form_submit($row_array))
				{
					// for($i=0; $i<count($q_slnum); $i++)
					// {
					// 	$installment_row_array = array(
					// 		'scd_master_scm' => $scheme_id,
					// 		'scd_inst_no' => $q_slnum[$i],
					// 		'scd_percent_work' => $q_slap[$i],
					// 		'scd_percent_amount' => $q_mark[$i],
					// 		'scd_datetime' => date('Y-m-d H:i:s'),
					// 	);
						
					// 	if($this->scheme_m->scheme_creation_installment_allotment_add($installment_row_array) == TRUE){
							$msg = 1;
					// 	}
					// 	else
					// 	{
					// 		$msg = 0;
					// 		break;
					// 	}
					// }

					// if($msg)
					// {
						echo json_encode(array('msg'=>$msg));
					// }
					// else
					// {
					// 	echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some probelm to Update DB, Try Again'));
					// }
				}
				else
				{
					echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some probelm to Update DB, Try Again'));
				}
			}



		// 	if(count((array)$copy_set)>0 && $gen_id != "" && $w_number != "")
		// 	{
		// 		$copystring = implode(",",$copy_set);
		// 		$result_no = $this->main_m->get_highest_memono_application();
		// 		if($result_no->appli_m_no != ""){
		// 			$gennumber = $result_no->appli_m_no + 1;
		// 		}else{
		// 			$gennumber = 1;
		// 		}
		// 		$gen_Set = str_pad($gennumber, 4, '0', STR_PAD_LEFT).'/ZP/'.date('Y');
		// 		$ap_detail = $this->db->get_where('full_application',array('app_id'=>$gen_id))->row();
		// 		$mailarray = array();
		// 		$mailarray[] = $ap_detail->sub_div_email;
		// 		$mailarray[] = $ap_detail->block_email;
		// 		$mailarray[] = $ap_detail->ps_email;
		// 		$mailarray[] = $ap_detail->gp_email;
		// 		$row_array = array(
		// 			'appli_worker' => $w_number,
		// 			'appli_modifydate' => date('Y-m-d H:i:s'),
		// 			'appli_m_no' => $gennumber,
		// 			'appli_memo_no' => $gen_Set,
		// 			'appli_memo_date' => date('Y-m-d'),
		// 			'appli_copy_fwd' => $copystring,
		// 			'appli_status' => 3
		// 		);
		// 		if($this->main_m->addform_against_epass_covid($row_array, $gen_id) == TRUE){
		// 			$profile_email = $ap_detail->appli_email;
		// 			$e_sub = "Permission Approval - Bankura";
		// 			$e_msg = '<h2>Welcome to Portal for Permission to resume works in Bankura District<br/>(During Lockdown period of COVID-19)</h2><p style="font-size:18px;">Dear '.$ap_detail->appli_name.',<br/>Your Permission is Approved Successfully.<br/>Your Application Number :- <strong>'.$ap_detail->app_ucode.'</strong></p><br/><br/>
		// 			<p style="font-size:18px;">Please check the Below Link for your Approval Document -<br/>
		// 			http://bankuradistrict.in/main/print_final_permission_sheet/'.$ap_detail->app_ucode.'</p>
		// 			<br/><br/><br/>
		// 			<p style="font-size:16px;">*For any queries please contact the District Admin.</p>';
		// 			$this->sendSMTPEmail($profile_email, $e_sub, $e_msg, $mailarray);

		// 			echo json_encode(array('msg'=>1));
		// 		}else{
		// 			echo json_encode(array('msg'=>$msg, 'e_msg'=>'There have some probelm to Update DB, Try Again'));
		// 		}
		// 	}else{
		// 		echo json_encode(array('msg'=>$msg, 'e_msg'=>'Check all fields properly, Try Again'));
		// 	}
		// 	exit;
		// }else{
		// 	redirect('admincontrol/panel/application_list');


		}

	}


}
