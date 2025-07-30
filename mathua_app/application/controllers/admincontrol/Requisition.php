<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Requisition extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);
		$this->load->model('admin_m');
        $this->load->model('scheme_m');
		$this->load->model('requisition_m');
	}

    public function add_new_requisition(){
        $this->data['all_active_scheme'] = $this->scheme_m->get_all_active_scheme();
        $this->data['all_active_district'] = $this->requisition_m->get_all_active_district();
        $this->load->view('admin/requisition/requisition_creation', $this->data);
    }

	public function get_scheme_amount(){
        $flag = 0;
        if($_POST){
			$scheme_id = $this->input->post('scheme_id');
            $scheme_amount = $this->requisition_m->get_scheme_amount_by_district_id($scheme_id);

            if(count((array)$scheme_amount) > 0){
                $flag = 1;
            }
        }
        echo json_encode(array('flag'=>$flag, 'scheme_amount'=>$scheme_amount));
    }

	public function get_block_list_by_district_id(){
        $flag = 0;
        if($_POST){
			$dist_code = $this->input->post('dist_id');
            $block_div_arr = $this->requisition_m->get_all_block_by_district_code($dist_code);
            if(count((array)$block_div_arr) > 0){
                $flag = 1;
            }
        }
        echo json_encode(array('flag'=>$flag, 'block_arr'=>$block_div_arr));
    }

    public function get_subdivision_list(){
        $flag = 0;
        if($_POST){
			$dist_id = $this->input->post('dist_id');
            $sub_div_arr = $this->requisition_m->get_all_subdivision_by_district_id($dist_id);
            if(count($sub_div_arr) > 0){
                $flag = 1;
            }
        }
        echo json_encode(array('flag'=>$flag, 'subdivision_arr'=>$sub_div_arr));
    }

    public function get_block_list(){
        $flag = 0;
        if($_POST){
			$subdiv_id = $this->input->post('subdiv_id');
            $block_arr = $this->requisition_m->get_all_block_by_subdiv_id($subdiv_id);
            if(count($block_arr) > 0){
                $flag = 1;
            }
        }
        echo json_encode(array('flag'=>$flag, 'block_arr'=>$block_arr));
    }

    public function requisition_entry_form_submit(){
        $flag = 0;
        if($_POST){
            $schm_id = $this->input->post('schm_id');
            $req_board_memo_no = $this->input->post('req_board_memo_no');
            $req_board_memo_date = $this->input->post('req_board_memo_date');
            $req_approx_amount = $this->input->post('req_approx_amount');
            $district_select = $this->input->post('district_select');
            $block_select = $this->input->post('block_select');
            $req_gram_panchayat_name = $this->input->post('req_gram_panchayat_name');
			$req_scheme_memo_no = $this->input->post('req_scheme_memo_no');
			$req_scheme_memo_date = $this->input->post('req_scheme_memo_date');
            $req_scheme_details = $this->input->post('req_scheme_details');
            $this->form_validation->set_rules('schm_id', 'Choose Scheme', 'trim|required|numeric');
            $this->form_validation->set_rules('req_board_memo_no', 'Requisition Details', 'trim|required');
            $this->form_validation->set_rules('req_board_memo_date', 'Quantity', 'trim|required');
            $this->form_validation->set_rules('req_approx_amount', 'Unit of Measurment', 'trim|required|numeric');
            $this->form_validation->set_rules('district_select', 'District', 'trim|required|numeric');
            $this->form_validation->set_rules('block_select', 'Block', 'trim|required|numeric');
            // $this->form_validation->set_rules('req_gram_panchayat_name', 'Gram Panchayat', 'trim|required');
            $this->form_validation->set_rules('req_scheme_memo_no', 'Scheme Memo No.', 'trim|required');
			$this->form_validation->set_rules('req_scheme_memo_date', 'Scheme Memo Date', 'trim|required');
			$this->form_validation->set_rules('req_scheme_details', 'Scheme Details', 'trim|required');
            if ($this->form_validation->run()) {
				if (count($_FILES) > 0) {
					$filename = $_FILES['files']['name'];
					$filename2 = $_FILES['files2']['name'];
					if (!empty($filename) && !empty($filename2)) {
						//========================================================================
						$previous_req_number = $this->requisition_m->get_previous_req_number();
						if($previous_req_number){
							$req_num_arr = explode("-",$previous_req_number);
							$req_sl_num_str = $req_num_arr[1];
							$req_sl_num_int = (int)$req_sl_num_str;
							$req_next_sl_num_int = $req_sl_num_int + 1;
							$req_next_sl_num_int_str_pad = str_pad($req_next_sl_num_int, 5, "0", STR_PAD_LEFT); 
							$req_number = 'REQ-'.$req_next_sl_num_int_str_pad;
						}else{
							$req_number = 'REQ-00001';
						}
						//=============================================
						mkdir('uploads/'.$req_number, 0755, true);
						$this->load->library('upload');
						// $this->load->library('image_lib');
						$config['upload_path'] = realpath('uploads/'.$req_number);
						$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
						$config['overwrite'] = FALSE;
						$config['remove_spaces'] = TRUE;
						$config['max_size'] = '11000';
						$config['file_name'] = $filename;
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if ($this->upload->do_upload('files')){
							$upload_data = $this->upload->data();
							$file1 = $upload_data['file_name'];
							$config['upload_path'] = realpath('uploads/'.$req_number);
							$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '11000';
							$config['file_name'] = $filename2;
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('files2')) {
								$upload_data = $this->upload->data();
								$file2 = $upload_data['file_name'];
								$row_arr = array(
									'req_scheme' => $schm_id,
									'req_number' => $req_number,
									'req_b_memo_no' => $req_board_memo_no,
									'req_b_memo_date' => $req_board_memo_date,
									'req_approx_amount' => $req_approx_amount,
									'req_recommendation_letter_doc' => $file1,
									'req_district' => $district_select,
									'req_block' => $block_select,
									'req_gram_panchayat_name' => $req_gram_panchayat_name,
									'req_s_memo_no' => $req_scheme_memo_no,
									'req_s_memo_date' => $req_scheme_memo_date,
									'req_details' => $req_scheme_details,
									'req_implementation_letter_doc' => $file2,
									'req_createby' => $this->session->userdata('uid'),
									'req_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->requisition_m->insert_requisition_data($row_arr) == TRUE) {
									// unlink('upload_file/adv_doc/' . $get_existdoc);
									echo json_encode(array('msg' => 1));
								} else {
									//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
									echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
								}
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		}
		else  {
			redirect('dafault404');
		}
    }

	public function requisition_list_dm_modal_form_submit(){
		$flag = 0;
		$is_err = 0;
		$err_msg = "";
		function date_valid($date){
			$date_arr = explode("-",$date);
			$day = (int) $date_arr[2];
			$month = (int) $date_arr[1];
			$year = (int) $date_arr[0];
			return checkdate($month, $day, $year);
		}
        if($_POST){
            $req_id = $this->input->post('dm_mod_req_id');
            $ini_memo_no = $this->input->post('dm_mod_ini_memo_no');
            $ini_memo_date = $this->input->post('dm_mod_ini_memo_date');
            $estimated_cost = $this->input->post('dm_mod_estimated_cost');
            $this->form_validation->set_rules('dm_mod_req_id', 'Requisition Id', 'trim|required|numeric');
            $this->form_validation->set_rules('dm_mod_ini_memo_no', 'Initiation Memo No.', 'trim|required');
			$this->form_validation->set_rules('dm_mod_ini_memo_date', 'Initiation Memo Date', 'trim|required|date_valid');
            $this->form_validation->set_rules('dm_mod_estimated_cost', 'Estimated Cost', 'trim|required|numeric');
            if ($this->form_validation->run()) {
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				if ($estimated_cost > $this->data['requisition_details']->req_approx_amount){
					$is_err = 1;
					$err_msg = "Estimated Cost should be less than or equals to Approx. Cost.";
				}
				if ($ini_memo_date < $this->data['requisition_details']->req_s_memo_date){  //====15.11.2022
					$is_err = 1;
					$err_msg = "Initiation Memo Date shound not be less than Scheme Memo Date";
				}
				if (!$is_err) {
					if (count($_FILES) > 0) {
						$estimate_doc = $_FILES['dm_mod_estimate_doc']['name'];
						$ini_letter_doc = $_FILES['dm_mod_ini_letter_doc']['name'];
						$bank_passbook_doc = $_FILES['dm_mod_bank_passbook_doc']['name'];
						if (!empty($estimate_doc) && !empty($ini_letter_doc) && !empty($bank_passbook_doc)) {
							$this->load->library('upload');
							// $this->load->library('image_lib');
							$req_num = $this->requisition_m->get_requisition_number_by_req_id($req_id);
							$config['upload_path'] = realpath('uploads/'.$req_num);
							$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '11000';
							$config['file_name'] = $estimate_doc;
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('dm_mod_estimate_doc')) {
								$upload_data = $this->upload->data();
								$estimate_doc_file_name = $upload_data['file_name'];
								$config['upload_path'] = realpath('uploads/'.$req_num);
								$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
								$config['overwrite'] = FALSE;
								$config['remove_spaces'] = TRUE;
								$config['max_size'] = '11000';
								$config['file_name'] = $ini_letter_doc;
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if ($this->upload->do_upload('dm_mod_ini_letter_doc')) {
									$upload_data = $this->upload->data();
									$ini_letter_doc_file_name = $upload_data['file_name'];
									$config['upload_path'] = realpath('uploads/'.$req_num);
									$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
									$config['overwrite'] = FALSE;
									$config['remove_spaces'] = TRUE;
									$config['max_size'] = '11000';
									$config['file_name'] = $bank_passbook_doc;
									$this->load->library('upload', $config);
									$this->upload->initialize($config);
									if ($this->upload->do_upload('dm_mod_bank_passbook_doc')) {
										$upload_data = $this->upload->data();
										$bank_passbook_doc_file_name = $upload_data['file_name'];
										//============================================================
										$row_arr = array(
											'req_initiate_memo_no' => $ini_memo_no,
											'req_initiate_memo_date' => $ini_memo_date,
											'req_final_amount' => $estimated_cost,
											'req_estimate_doc' => $estimate_doc_file_name,
											'req_initiate_letter_doc' => $ini_letter_doc_file_name,
											'req_bank_passbook_doc' => $bank_passbook_doc_file_name,
											'req_initiate_date' => date('Y-m-d H:i:s'),
											'req_initiate' => 1
										);
										if ($this->requisition_m->dm_initiate_data_update($row_arr, $req_id) == TRUE) {
											// unlink('upload_file/adv_doc/' . $get_existdoc);
											echo json_encode(array('msg' => 1));
										} else {
											//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
											echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
										}
										//===============================================================
									} else {
										echo json_encode(array('msg' => 0, 'upl' => 3, 'e_msg' => $this->upload->display_errors()));
									}
								} else {
									echo json_encode(array('msg' => 0, 'upl' => 2, 'e_msg' => $this->upload->display_errors()));
								}
							} else {
								echo json_encode(array('msg' => 0, 'upl' => 1, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} 
					else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => $err_msg));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function requisition_list(){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			$this->data['requisition_data_arr'] = $this->requisition_m->get_all_from_requisition_master();
		}elseif($user_type == 3){
			$this->data['requisition_data_arr'] = $this->requisition_m->get_all_from_requisition_master_by_user_id($user_id);
		}
        $this->load->view('admin/requisition/requisition_list', $this->data);
    }

	public function requisition_report(){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			if ($_POST){
				function date_valid($date){
					$date_arr = explode("-",$date);
					$day = (int) $date_arr[2];
					$month = (int) $date_arr[1];
					$year = (int) $date_arr[0];
					return checkdate($month, $day, $year);
				}
				$rpot_from_date = $this->input->post('rpot_from_date');
				$rpot_to_date = $this->input->post('rpot_to_date');
				$rpot_schm_id = $this->input->post('rpot_schm_id');
				$rpot_dist = $this->input->post('rpot_dist');
				$this->form_validation->set_rules('rpot_from_date', 'From Date', 'trim|required|date_valid');
				$this->form_validation->set_rules('rpot_to_date', 'To Date', 'trim|required|date_valid');
				$this->form_validation->set_rules('rpot_schm_id', 'Scheme', 'trim|required');
				$this->form_validation->set_rules('rpot_dist', 'District', 'trim|required');
				if($rpot_schm_id == 'ALL'){
					$rpot_schm_id = NULL;
				}
				if($rpot_dist == 'ALL'){
					$rpot_dist = NULL;
				}
				if ($this->form_validation->run()) {
					$requisition_data_arr = $this->requisition_m->get_all_from_requisition_master_with_condition($rpot_from_date, $rpot_to_date, $rpot_schm_id, $rpot_dist);
					$requisition_report_data_arr = $this->requisition_m->get_all_from_requisition_master_with_payment_tab_with_condition($rpot_from_date, $rpot_to_date, $rpot_schm_id, $rpot_dist);
					$final_req_data_arr = array();
					
					$final_total_pay_1_amount = 0;
					$final_total_pay_2_amount = 0;
					$final_total_pay_3_amount = 0;

					if(!empty($requisition_data_arr)){
						foreach($requisition_data_arr as $req_data){
							$slno = 1;
							$req_data_arr = array();
							$pay_1_amount = '';
							$pay_1_chq_no = '';
							$pay_1_chq_dt = '';
							$pay_2_amount = '';
							$pay_2_chq_no = '';
							$pay_2_chq_dt = '';
							$pay_3_amount = '';
							$pay_3_chq_no = '';
							$pay_3_chq_dt = '';

							$total_pay_1_amount = 0;
							$total_pay_2_amount = 0;
							$total_pay_3_amount = 0;

							foreach($requisition_report_data_arr as $report_data){
								if($req_data->req_id == $report_data->wpay_master_req && $report_data->wpay_installment_no == 1){
									$pay_1_amount = $report_data->wpay_amount;
									$pay_1_chq_no = $report_data->wpay_cheq_no;
									$pay_1_chq_dt = $report_data->wpay_cheq_date;
									$total_pay_1_amount = $pay_1_amount;
								}elseif($req_data->req_id == $report_data->wpay_master_req && $report_data->wpay_installment_no == 2){
									$pay_2_amount = $report_data->wpay_amount;
									$pay_2_chq_no = $report_data->wpay_cheq_no;
									$pay_2_chq_dt = $report_data->wpay_cheq_date;
									$total_pay_2_amount = $pay_2_amount;
								}elseif($req_data->req_id == $report_data->wpay_master_req && $report_data->wpay_installment_no == 3){
									$pay_3_amount = $report_data->wpay_amount;
									$pay_3_chq_no = $report_data->wpay_cheq_no;
									$pay_3_chq_dt = $report_data->wpay_cheq_date;
									$total_pay_3_amount = $pay_3_amount;
								}
							}
							$req_data_arr = array(
								'slno' => $slno++,
								'req_id' => $req_data->req_id,
								'req_initiate' => $req_data->req_initiate,
								'req_approval' => $req_data->req_approval,
								'req_progress_flag' => $req_data->req_progress_flag,
								'req_number' => $req_data->req_number,
								'req_s_memo_no' => $req_data->req_s_memo_no,
								'req_s_memo_date' => $req_data->req_s_memo_date,
								'scm_name' => $req_data->scm_name,
								'block_name' => $req_data->block_name,
								'district_name' => $req_data->district_name,
								'req_approx_amount' => $req_data->req_approx_amount,
								'req_final_amount' => $req_data->req_final_amount,
								'pay_1_amount' => $pay_1_amount,
								'pay_1_chq_no' => $pay_1_chq_no,
								'pay_1_chq_dt' => $pay_1_chq_dt,
								'pay_2_amount' => $pay_2_amount,
								'pay_2_chq_no' => $pay_2_chq_no,
								'pay_2_chq_dt' => $pay_2_chq_dt,
								'pay_3_amount' => $pay_3_amount,
								'pay_3_chq_no' => $pay_3_chq_no,
								'pay_3_chq_dt' => $pay_3_chq_dt
							);
		
							$final_req_data_arr[] = $req_data_arr;

							$final_total_pay_1_amount = $final_total_pay_1_amount + $total_pay_1_amount;
							$final_total_pay_2_amount = $final_total_pay_2_amount + $total_pay_2_amount;
							$final_total_pay_3_amount = $final_total_pay_3_amount + $total_pay_3_amount;
						}
					}
					$table_row_total = '';
					if(!empty($final_req_data_arr)){
						foreach($final_req_data_arr as $requisition_data){
							if($requisition_data["req_approval"] > 0){ 
								$req_approval = "Yes"; 
							}else{ 
								$req_approval = "No"; 
							}
							$table_row = '';
							$table_row = '<tr class="report_table_row">
							<td>'.$requisition_data["slno"].'</td>
							<td>'.$requisition_data["req_number"].'</td>
							<td>'.$requisition_data["req_s_memo_no"] .'<br>'.$requisition_data["req_s_memo_date"].'</td>
							<td>'.$requisition_data["scm_name"].'</td>
							<td>'.$requisition_data["block_name"].'<br>'.$requisition_data["district_name"].'</td>
							<td>'.$req_approval.'</td>
							<td>'.$requisition_data["req_approx_amount"].'</td>
							<td>'.$requisition_data["req_final_amount"].'</td>
							<td>'.$requisition_data["pay_1_amount"].'</td>
							<td>'.$requisition_data["block_name"].'<br>'.$requisition_data["district_name"].'</td>
							<td>'.$requisition_data["pay_1_chq_no"].'<br>'.$requisition_data["pay_1_chq_dt"].'</td>
							<td>'.intval(($requisition_data["req_final_amount"]) - intval($requisition_data["pay_1_amount"])).'</td>
							<td>'.$requisition_data["pay_2_amount"].'</td>
							<td>'.$requisition_data["pay_2_chq_no"].'<br>'.$requisition_data["pay_2_chq_dt"].'</td>
							<td>'.$requisition_data["pay_3_amount"].'</td>
							<td>'.$requisition_data["pay_3_chq_no"].'<br>'.$requisition_data["pay_3_chq_dt"].'</td>
							<td><a href="'.base_url("admincontrol/requisition/installment_payment_details").'/'.$requisition_data["req_id"].'" class="btn btn-info" type="button" target="_blank">Details</a></td>
							</tr>';
							$table_row_total = $table_row_total.$table_row;
						}

						$table_row_sum = '<tr class="report_table_row">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b>'.sprintf("%0.2f", $final_total_pay_1_amount).'<b></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b>'.sprintf("%0.2f", $final_total_pay_2_amount).'<b></td>
						<td></td>
						<td><b>'.sprintf("%0.2f", $final_total_pay_3_amount).'<b></td>
						<td></td>
						<td></td>
						</tr>';
						$table_row_total = $table_row_total.$table_row_sum;

						echo json_encode(array('msg' => 1, 'data_arr' => $table_row_total));
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'No Records!!'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
				}
				exit;
			}
			$this->data['all_active_scheme'] = $this->scheme_m->get_all_active_scheme();
			$this->data['dist_list'] = $this->db->order_by('district_name ASC')->where('district_status = 1')->get("district_master")->result();
			//print_r(data['all_active_scheme']);
			$this->load->view('admin/requisition/requisition_report', $this->data);
		}else{
			redirect('http://localhost/mathua_app/admincontrol/dashboard');
			exit();
		}
    }

	public function get_requisition_modal_data(){
		$requisition_id = $this->input->post('requisition_id');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'required|numeric');
		if ($this->form_validation->run()) {
			$req_data = $this->requisition_m->get_data_by_id_from_requisition_table($requisition_id);
			echo json_encode(array('msg' => 1, 'req_data' => $req_data));
		} else {
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function get_dm_modal_data(){
		$requisition_id = $this->input->post('requisition_id');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'required|numeric');
		if ($this->form_validation->run()) {
			$req_data = $this->requisition_m->get_data_by_id_from_requisition_table($requisition_id);
			echo json_encode(array('msg' => 1, 'req_data' => $req_data));
		} else {
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function initiate_btn_on_click(){
		$requisition_id = $this->input->post('requisition_id');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'required|numeric');
		if ($this->form_validation->run()) {
			$req_data = $this->requisition_m->update_initiate_status($requisition_id);
			if($req_data){
				echo json_encode(array('msg' => 1, 'req_data' => $req_data));
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Unable to update.'));
			}
		} else {
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function requisition_approve(){
		$requisition_id = $this->input->post('requisition_id');
		$req_approval = 1;
		$requi_remarks = $this->input->post('requi_remarks');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'trim|required|numeric');
		if ($this->form_validation->run()) {
			$res = $this->requisition_m->update_requisition_approval($requisition_id, $req_approval, $requi_remarks);
			if($res){
				echo json_encode(array('msg' => 1));
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Unable to update.'));
			}
		} else {
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function requisition_reject(){
		$requisition_id = $this->input->post('requisition_id');
		$req_approval = 2;
		$requi_remarks = $this->input->post('requi_remarks');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'trim|required|numeric');
		$this->form_validation->set_rules('requi_remarks', 'Remarks', 'trim|required');
		if ($this->form_validation->run()) {
			$res = $this->requisition_m->update_requisition_approval($requisition_id, $req_approval, $requi_remarks);
			if($res){
				echo json_encode(array('msg' => 1));
			}else{
				echo json_encode(array('msg' => 0, 'e_msg' => 'Unable to update.'));
			}
		} else {
			echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function get_rejection_reason(){
		$requisition_id = $this->input->post('requisition_id');
		$this->form_validation->set_rules('requisition_id', 'requisition Id', 'trim|required|numeric');
		if ($this->form_validation->run()) {
			$rejection_reason = $this->requisition_m->select_rejection_reason($requisition_id);
			if($rejection_reason){
				echo json_encode(array('flag' => 1, 'rejection_reason' => $rejection_reason));
			}else{
				echo json_encode(array('flag' => 0, 'e_msg' => 'Rejection Reason Not Available'));
			}
		} else {
			echo json_encode(array('flag' => 0, 'e_msg' => validation_errors()));
		}
	}

	public function installment_list(){
		$this->load->view('admin/requisition/installment_list');
	}

	public function installment_payment_details($req_id){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			if($this->requisition_m->check_for_valid_scheme($req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
				$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
				$this->data['first_payment_details'] = $this->requisition_m->get_1st_payment_details($req_id);
				$this->data['second_payment_details'] = $this->requisition_m->get_2nd_payment_details($req_id);
				$this->data['final_payment_details'] = $this->requisition_m->get_final_payment_details($req_id);
				$this->data['progress_details'] = $this->requisition_m->get_requisition_progress_details($req_id);
				$this->load->view('admin/requisition/requisition_details', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}elseif($user_type == 3){
			if($this->requisition_m->check_userdistcode_schemedistcode_isequal($user_id, $req_id) == TRUE && $this->requisition_m->check_userblockcode_schemeblockcode_isequal($user_id, $req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
				$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
				$this->data['first_payment_details'] = $this->requisition_m->get_1st_payment_details($req_id);
				$this->data['second_payment_details'] = $this->requisition_m->get_2nd_payment_details($req_id);
				$this->data['final_payment_details'] = $this->requisition_m->get_final_payment_details($req_id);
				$this->data['progress_details'] = $this->requisition_m->get_requisition_progress_details($req_id);
				$this->load->view('admin/requisition/requisition_details', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}
	}

	public function installment_payment_details_gallery1($req_id){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			if($this->requisition_m->check_for_valid_scheme($req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos1'] = $this->requisition_m->get_photos1_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery1', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}elseif($user_type == 3){
			if($this->requisition_m->check_userdistcode_schemedistcode_isequal($user_id, $req_id) == TRUE && $this->requisition_m->check_userblockcode_schemeblockcode_isequal($user_id, $req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos1'] = $this->requisition_m->get_photos1_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery1', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}
	}

	public function installment_payment_details_gallery2($req_id){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			if($this->requisition_m->check_for_valid_scheme($req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos2'] = $this->requisition_m->get_photos2_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery2', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}elseif($user_type == 3){
			if($this->requisition_m->check_userdistcode_schemedistcode_isequal($user_id, $req_id) == TRUE && $this->requisition_m->check_userblockcode_schemeblockcode_isequal($user_id, $req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos2'] = $this->requisition_m->get_photos2_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery2', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}
	}

	public function installment_payment_details_gallery3($req_id){
		$user_id = $this->session->userdata('uid');
		$user_type = $this->session->userdata('utype');
		if($user_type == 1 || $user_type == 2){
			if($this->requisition_m->check_for_valid_scheme($req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos3'] = $this->requisition_m->get_photos3_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery3', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}elseif($user_type == 3){
			if($this->requisition_m->check_userdistcode_schemedistcode_isequal($user_id, $req_id) == TRUE && $this->requisition_m->check_userblockcode_schemeblockcode_isequal($user_id, $req_id) == TRUE){
				$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
				$this->data['progress_photos3'] = $this->requisition_m->get_photos3_by_id_from_work_progress_table($req_id);
				$this->load->view('admin/requisition/requisition_details_gallery3', $this->data);
			}else{
				redirect('http://localhost/mathua_app/admincontrol/dashboard');
				exit();
			}
		}
	}

	public function pay_installment($req_id){
		$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
		$this->data['requisition_progress_details'] = $this->requisition_m->get_last_row_by_id_from_requisition_progress_table($req_id);
		$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
		$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
		$this->load->view('admin/requisition/installment_payment', $this->data);
	}

	public function installment_payment($req_id){
		$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
		$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
		$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
		// echo $this->db->last_query();
		// die;
		$this->load->view('admin/requisition/installment_payment', $this->data);
	}

	public function requisition_installment_payment(){
		$flag = 0;
        if($_POST){
            $installment_no = $this->input->post('paymnt_installment_no');
            $paymnt_amount = $this->input->post('paymnt_amount');
            $paymnt_memo_no = $this->input->post('paymnt_memo_no');
            $paymnt_memo_date = $this->input->post('paymnt_memo_date');
			$paymnt_cheque_no = $this->input->post('paymnt_cheque_no');
            $paymnt_cheque_date = $this->input->post('paymnt_cheque_date');
            $req_id = $this->input->post('paymnt_req_id');
			//========================================================================
			$is_err = 0;
			$err_msg = "";
			$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
			$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
			$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
			$total_paid = 0;
			for($i=0; $i<count($this->data['payment_details']); $i++){
				$total_paid = $total_paid + $this->data['payment_details'][$i]->wpay_amount;
			}
			$approv_amunt = number_format($this->data['requisition_details']->req_final_amount, 2, '.', '');
			$paid_amunt = number_format($total_paid, 2, '.', '');
			$balanc_amunt = number_format(($this->data['requisition_details']->req_final_amount - $total_paid), 2, '.', '');
			if(count($this->data['payment_details']) > 0) { 
				$work_done_perce = $this->data['payment_details'][count($this->data['payment_details'])-1]->wpay_percent_work; 
			} else { 
				$work_done_perce = 0; 
			}
			if((float)$paymnt_amount > (float)$balanc_amunt){
				$is_err = 1;
				$err_msg = "Amount should not more than ".(float)$balanc_amunt;
			}
			if ($paymnt_memo_date < $this->data['requisition_details']->req_initiate_memo_date){  //====15.11.2022
				$is_err = 1;
				$err_msg = "Payment Memo Date shound not be less than Initiation Memo Date";
			}
            $this->form_validation->set_rules('paymnt_installment_no', 'Installment No', 'trim|required|numeric');
            $this->form_validation->set_rules('paymnt_amount', 'Payment Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('paymnt_memo_no', 'Memo Number', 'trim|required');
            $this->form_validation->set_rules('paymnt_memo_date', 'Memo Date', 'trim|required');
			$this->form_validation->set_rules('paymnt_cheque_no', 'Cheque Number', 'trim|required');
            $this->form_validation->set_rules('paymnt_cheque_date', 'Cheque Date', 'trim|required');
            $this->form_validation->set_rules('paymnt_req_id', 'Requisition Id', 'trim|required|numeric');
            if(!$is_err){
				if ($this->form_validation->run()) {
					if (count($_FILES) > 0) {
						$filename = $_FILES['files']['name'];
						if (!empty($filename)) {
							$this->load->library('upload');
							// $this->load->library('image_lib');
							$req_num = $this->requisition_m->get_requisition_number_by_req_id($req_id);
							$config['upload_path'] = realpath('uploads/'.$req_num);
							$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '11000';
							$config['file_name'] = $filename;
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('files')) {
								$upload_data = $this->upload->data();
								$row_arr = array(
									'wpay_installment_no' => $installment_no,
									'wpay_amount' => $paymnt_amount,
									'wpay_memo_no' => $paymnt_memo_no,
									'wpay_memo_date' => $paymnt_memo_date,
									'wpay_cheq_no' => $paymnt_cheque_no,
									'wpay_cheq_date' => $paymnt_cheque_date,
									'wpay_master_req' => $req_id,
									'wpay_createby' => $this->session->userdata('uid'),
									'wpay_san_ord_doc' => $upload_data['file_name'],
									'wpay_createdate' => date('Y-m-d H:i:s')
								);

								if ($this->requisition_m->installment_payment_insert($row_arr) == TRUE) {
									// unlink('upload_file/adv_doc/' . $get_existdoc);
									$approval_status = count($this->data['payment_details']) + 1;
									if($this->requisition_m->update_payment_approval_flag($approval_status, $req_id) == TRUE){
										echo json_encode(array('msg' => 1));
									} else {
										echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
									}
								} else {
									//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
									echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
								}
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => $err_msg));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function work_order_details($req_id){
		$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
		$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
		$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
		$this->load->view('admin/requisition/work_order_upload', $this->data);
	}

	public function work_order_submit(){
		$flag = 0;
        if($_POST){
            $work_order_no = $this->input->post('wo_no');
            $work_order_date = $this->input->post('wo_date');
            $agency_name = $this->input->post('wo_agency_name');
            $work_start_date = $this->input->post('wo_work_start_date');
			$balance_amount_payment_request = $this->input->post('wo_balance_amount');
            $req_id = $this->input->post('wo_req_id');
			//========================================================================
			$is_err = 0;
			$err_msg = "";
			$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
			$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
			$total_paid = 0;
			for($i=0; $i<count($this->data['payment_details']); $i++){
				$total_paid = $total_paid + $this->data['payment_details'][$i]->wpay_amount;
			}
			$balanc_amunt = number_format(($this->data['requisition_details']->req_final_amount - $total_paid), 2, '.', '');
			if((float)$balance_amount_payment_request > (float)$balanc_amunt){
				$is_err = 1;
				$err_msg = "Balance Amount should not more than ".(float)$balanc_amunt;
			}
			if ($work_order_date < $this->data['requisition_details']->req_initiate_memo_date){  //====15.11.2022
				$is_err = 1;
				$err_msg = "Work Order Date shound not be less than Initiation Memo Date";
			}
            $this->form_validation->set_rules('wo_no', 'Work Order No', 'trim|required');
			$this->form_validation->set_rules('wo_date', 'Work Order Date', 'trim|required');
			$this->form_validation->set_rules('wo_agency_name', 'Agency Name', 'trim|required');
			$this->form_validation->set_rules('wo_work_start_date', 'Work Start Date', 'trim|required');
            $this->form_validation->set_rules('wo_balance_amount', 'Balance Amount', 'trim|required|numeric');
            if(!$is_err){
				if ($this->form_validation->run()){
					if (count($_FILES) > 0){
						$wo_doc_name = $_FILES['wo_doc']['name'];
						$wo_uc_doc_name = $_FILES['wo_utilization_certificate_doc']['name'];
						if (!empty($wo_doc_name) && !empty($wo_uc_doc_name)) {
							$this->load->library('upload');
							// $this->load->library('image_lib');
							$req_num = $this->requisition_m->get_requisition_number_by_req_id($req_id);
							$config['upload_path'] = realpath('uploads/'.$req_num);
							$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '11000';
							$config['file_name'] = $wo_doc_name;
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('wo_doc')) {
								$wo_doc_upload_data = $this->upload->data();
								$config['file_name'] = $wo_uc_doc_name;
								$this->load->library('upload', $config);
								$this->upload->initialize($config);
								if ($this->upload->do_upload('wo_utilization_certificate_doc')) {
									$wo_uc_doc_upload_data = $this->upload->data();
									$row_arr = array(
										'reqp_master_req' => $req_id,
										'reqp_wo_no' => $work_order_no,
										'reqp_wo_date' => $work_order_date,
										'reqp_wo_doc' => $wo_doc_upload_data['file_name'],
										'reqp_vendor_name' => $agency_name,
										'reqp_work_start_date' => $work_start_date,
										'reqp_start_uc_doc' => $wo_uc_doc_upload_data['file_name'],
										'reqp_balance_amount_request' => $balance_amount_payment_request,
										'reqp_createby' => $this->session->userdata('uid'),
										'reqp_createdate' => date('Y-m-d H:i:s')
									);
									if ($this->requisition_m->work_order_submit_insert($row_arr) == TRUE) {
										// unlink('upload_file/adv_doc/' . $get_existdoc);
										$progress_flag = 1;
										if($this->requisition_m->update_progress_flag($progress_flag, $req_id) == TRUE){
											echo json_encode(array('msg' => 1));
										} else {
											echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
										}
									} else {
										//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
										echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
									}
								} else {
									echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
								}
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => $err_msg));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}

	public function work_completion_details($req_id){
		$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
		$this->data['installment_details'] = $this->requisition_m->get_installment_details($req_id);
		$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
		$this->load->view('admin/requisition/work_completion_upload', $this->data);
	}

	public function work_completion_details_submit(){
		$flag = 0;
        if($_POST){
            $compli_memo_no = $this->input->post('compli_memo_no');
            $compli_memo_date = $this->input->post('compli_memo_date');
            $compli_work_end_date = $this->input->post('compli_work_end_date');
			$balance_amount_payment_request = $this->input->post('compli_balance_amount');
            $req_id = $this->input->post('compli_req_id');
			//========================================================================
			$is_err = 0;
			$err_msg = "";
			$this->data['requisition_details'] = $this->requisition_m->get_data_by_id_from_requisition_table($req_id);
			$this->data['payment_details'] = $this->requisition_m->get_payment_details($req_id);
			$total_paid = 0;
			for($i=0; $i<count($this->data['payment_details']); $i++){
				$total_paid = $total_paid + $this->data['payment_details'][$i]->wpay_amount;
			}
			$balanc_amunt = number_format(($this->data['requisition_details']->req_final_amount - $total_paid), 2, '.', '');
			if((float)$balance_amount_payment_request > (float)$balanc_amunt){
				$is_err = 1;
				$err_msg = "Balance Amount should not more than ".(float)$balanc_amunt;
			}
            $this->form_validation->set_rules('compli_memo_no', 'Memo No', 'trim|required');
			$this->form_validation->set_rules('compli_memo_date', 'Memo Date', 'trim|required');
			$this->form_validation->set_rules('compli_work_end_date', 'Work End Date', 'trim|required');
            $this->form_validation->set_rules('compli_balance_amount', 'Balance Amount', 'trim|required|numeric');
            if(!$is_err){
				if ($this->form_validation->run()){
					if (count($_FILES) > 0){
						$uc_doc_name = $_FILES['compli_utilization_certificate_doc']['name'];
						if (!empty($uc_doc_name)) {
							$this->load->library('upload');
							// $this->load->library('image_lib');
							$req_num = $this->requisition_m->get_requisition_number_by_req_id($req_id);
							$config['upload_path'] = realpath('uploads/'.$req_num);
							$config['allowed_types'] = 'pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG';
							$config['overwrite'] = FALSE;
							$config['remove_spaces'] = TRUE;
							$config['max_size'] = '11000';
							$config['file_name'] = $uc_doc_name;
							$this->load->library('upload', $config);
							$this->upload->initialize($config);
							if ($this->upload->do_upload('compli_utilization_certificate_doc')) {
								$uc_doc_upload_data = $this->upload->data();
								$row_arr = array(
									'reqp_comp_memo_no' => $compli_memo_no,
									'reqp_comp_memo_date' => $compli_memo_date,
									'reqp_work_end_date' => $compli_work_end_date,
									'reqp_final_uc_doc' => $uc_doc_upload_data['file_name'],
									'reqp_final_amount_request' => $balance_amount_payment_request,
									'reqp_comp_createby' => $this->session->userdata('uid'),
									'reqp_comp_createdate' => date('Y-m-d H:i:s')
								);
								if ($this->requisition_m->work_completion_submit_update($row_arr, $req_id) == TRUE) {
									// unlink('upload_file/adv_doc/' . $get_existdoc);
									$progress_flag = 3;
									if($this->requisition_m->update_progress_flag($progress_flag, $req_id) == TRUE){
										echo json_encode(array('msg' => 1));
									} else {
										echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
									}
								} else {
									//$this->db->delete('advertisement_master', array('adv_auto_genno' => $adv_no));
									echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
								}
							} else {
								echo json_encode(array('msg' => 0, 'e_msg' => $this->upload->display_errors()));
							}
						} else {
							echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
						}
					} else {
						echo json_encode(array('msg' => 0, 'e_msg' => 'File Not Upload properly, Check again.'));
					}
				} else {
					echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
				}
			} else {
				echo json_encode(array('msg' => 0, 'e_msg' => $err_msg));
			}
			exit;
		} else {
			redirect('dafault404');
		}
	}









}

