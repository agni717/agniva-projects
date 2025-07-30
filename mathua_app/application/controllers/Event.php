<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
    }
	
	public function index()
	{
		redirect('main/home');
	}
	
	public function registration(){
		if($_POST){
			$ev_name = $this->input->post('ev_name');
			$ev_person = $this->input->post('ev_person');
			$ev_mobile = $this->input->post('ev_mobile');
			$ev_address = $this->input->post('ev_address');
			$ev_start_date = $this->input->post('ev_start_date');
			$ev_end_date = $this->input->post('ev_end_date');
			$ev_start_time = $this->input->post('ev_start_time');
			$ev_end_time = $this->input->post('ev_end_time');
			
			$this->form_validation->set_rules('ev_name', 'Event Name', 'trim|required');
			$this->form_validation->set_rules('ev_person', 'Contact Person Name', 'trim|required');
            $this->form_validation->set_rules('ev_mobile', 'Contact Person Mobile', 'trim|required|exact_length[10]|is_natural');
			$this->form_validation->set_rules('ev_address', 'Contact Person Address', 'trim');
            $this->form_validation->set_rules('ev_start_date', 'Start Date', 'trim|required');
            $this->form_validation->set_rules('ev_end_date', 'End Date', 'trim|required');
			$this->form_validation->set_rules('ev_start_time', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('ev_end_time', 'End Time', 'trim|required');
			
			if($this->form_validation->run() == TRUE)
            {
				$chk_no = 0;
				$chk_msg = '';

				$ev_start_date = date('Y-m-d',strtotime($ev_start_date));
				if('1970-01-01' == $ev_start_date)
				{
					$chk_no++;
					$chk_msg = $chk_msg . 'Start Date not match proper format, Check Again.<br/>';
				}else{
					if($this->validateDate($ev_start_date) == FALSE){
						$chk_no++;
						$chk_msg = $chk_msg . 'Start Date not match proper format, Check Again.<br/>';
					}
				}
				$ev_end_date = date('Y-m-d',strtotime($ev_end_date));
				if('1970-01-01' == $ev_end_date)
				{
					$chk_no++;
					$chk_msg = $chk_msg . 'End Date not match proper format, Check Again.<br/>';
				}else{
					if($this->validateDate($ev_end_date) == FALSE){
						$chk_no++;
						$chk_msg = $chk_msg . 'End Date not match proper format, Check Again.<br/>';
					}
				}
				
				//print_r($_POST);
				
				if($chk_no != 0){
					$this->data['error'] = $chk_msg;
				}else{
					$todaydate = date('Y-m-d');
					if(($todaydate > $ev_start_date) || ($todaydate > $ev_end_date)){
						$this->data['error'] = 'End Date OR Start Date never Lower than Current Date, Check again.';
					}else{
						if($ev_start_date > $ev_end_date){
							$this->data['error'] = 'End Date Always same or greter than Start Date, Check again.';
						}else{
							
							if($ev_start_date == $ev_end_date){
								if($todaydate == $ev_start_date || $todaydate == $ev_end_date){
									$st_time = strtotime($ev_start_time);
									//$end_time = strtotime($ev_end_time);
									$cur_time = strtotime(date('H:i')) + (60*60);
									if($cur_time > $st_time){
										$chk_no++;
										$this->data['error'] = 'Event Start Time always Greater than 1 hour from Today Time, Check again.';
									}
								}else{
									$st_time = strtotime($ev_start_time) + (60*60);
									$end_time = strtotime($ev_end_time);
									if($st_time > $end_time){
										$chk_no++;
										$this->data['error'] = 'Event End Time always Greater than Event Start Time and Minimun 1 Hour Difference, Check again.';
									}
								}
							}else{
								if($todaydate == $ev_start_date){
									$st_time = strtotime($ev_start_time);
									//$end_time = strtotime($ev_end_time);
									$cur_time = strtotime(date('H:i')) + (60*60);
									if($cur_time > $st_time){
										$chk_no++;
										$this->data['error'] = 'Event Start Time always Greater than 1 hour from Today Time, Check again.';
									}
								}
							}
							
							if($chk_no == 0){
								$ev_start_date_update = $ev_start_date." ".$ev_start_time.":00";
								$ev_end_date_update = $ev_end_date." ".$ev_end_time.":00";
								if($this->main_m->check_Existing_Event_On_SameDate($ev_start_date_update,$ev_end_date_update) == TRUE){
									$random_keys = "E". date('dmyHi') . $this->generateRandomString();
									$row_array = array(
										'event_no' => $random_keys,
										'event_name' => trim($ev_name),
										'event_startdate' => $ev_start_date_update,
										//'event_starttime' => $ev_start_time.":00",
										'event_enddate' => $ev_end_date_update,
										//'event_endtime' => $ev_end_time.":00",
										'event_contact_person' => trim($ev_person),
										'event_cp_mobile' => $ev_mobile,
										'event_cp_address' => trim($ev_address),
										'event_createdate' => date('Y-m-d H:i:s')
									);
									if($this->main_m->addform_against_user_Event_set($row_array) == TRUE){
										$this->session->set_flashdata("success","Event Registration submitted successfully. Your Registration No is - ".$random_keys);
										redirect('event/registration','refresh');
									}else{
										$this->data['error'] = "There have some problem to Insert DB, Try Again.";
									}
								}else{
									$this->data['error'] = "An Event already occupied on that Date Time, Check Again.";
								}
							}
						}
					}
					
				}
			
			}
		}
		$this->load->view('main/event_register_view', $this->data);
	}
	
	public function status_details(){
		$this->load->view('main/event_status_view', $this->data);
	}
	
	public function get_event_status_from_back(){
		if($_POST){
			$ev_no = $this->input->post('ev_no');
			$msg = 0;
			if($ev_no != ""){
				$gt_ev_detail = $this->db->get_where('event_tab',array('event_no'=>$ev_no))->row();
				if(count((array)$gt_ev_detail) > 0){
					echo json_encode(array('msg'=>1, 'ev_set' => $gt_ev_detail));
				}else{
					echo json_encode(array('msg'=>$msg,'e_msg'=>'Event Number not found, Check again.'));
				}
			}else{
				echo json_encode(array('msg'=>$msg,'e_msg'=>'Event Number is required, Check again.'));
			}
			exit;
		}else{
			redirect('default404');
		}
	}
	
	protected function validateDate($date, $format = 'Y-m-d'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
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