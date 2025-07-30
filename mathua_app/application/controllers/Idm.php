<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idm extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
    }
	
	public function index()
	{
	    redirect('idm/idm_form_submission');
	}
	
	public function idm_form_submission()
	{
		
		if($_POST){
			
			$idm_declar = $this->input->post('idm_declar');
			$ap_name = $this->input->post('ap_name');
			$ap_email = $this->input->post('ap_email');
			$ap_mobile = $this->input->post('ap_mobile');
			
			$ap_village = $this->input->post('ap_village');
			$ap_gp = $this->input->post('ap_gp');
			$ap_block = $this->input->post('ap_block');
			$ap_district = $this->input->post('ap_district');
			$ap_village_dest = $this->input->post('ap_village_dest');
			$ap_gp_dest = $this->input->post('ap_gp_dest');
			$ap_block_dest = $this->input->post('ap_block_dest');
			$ap_district_dest = $this->input->post('ap_district_dest');
			
			$ap_pep_move = $this->input->post('ap_pep_move');
			$ap_movedate = $this->input->post('ap_movedate');
			$ap_idcard = $this->input->post('ap_idcard');
			$ap_idtype = $this->input->post('ap_idtype');
			$ap_vno = $this->input->post('ap_vno');
			$ap_vtype = $this->input->post('ap_vtype');
			$ap_move_reason = $this->input->post('ap_move_reason');
			
			$this->form_validation->set_rules('idm_declar', 'Declaration', 'trim|required|is_natural');
			$this->form_validation->set_rules('ap_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('ap_email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('ap_mobile', 'Mobile', 'trim|required|exact_length[10]|is_natural');
			
			$this->form_validation->set_rules('ap_village', 'Villege/Street', 'trim|required');
			$this->form_validation->set_rules('ap_gp', 'GP Name', 'trim|required');
			$this->form_validation->set_rules('ap_block', 'Block', 'trim|required');
            $this->form_validation->set_rules('ap_district', 'District', 'trim|required|is_natural');
            $this->form_validation->set_rules('ap_village_dest', 'Villege/Street', 'trim|required');
            $this->form_validation->set_rules('ap_gp_dest', 'GP Name', 'trim|required');
			$this->form_validation->set_rules('ap_block_dest', 'Block', 'trim|required');
            $this->form_validation->set_rules('ap_district_dest', 'District', 'trim|required|is_natural');
			
			$this->form_validation->set_rules('ap_pep_move', 'No. of People', 'trim|required|is_natural');
            $this->form_validation->set_rules('ap_movedate', 'Travel Date', 'trim|required');
            $this->form_validation->set_rules('ap_idcard', 'ID Card No', 'trim|required');
            $this->form_validation->set_rules('ap_idtype', 'ID Card Type', 'trim|required');
            $this->form_validation->set_rules('ap_vno', 'Vehicle No', 'trim|required');
            $this->form_validation->set_rules('ap_vtype', 'Vehicle Type', 'trim|required');
            $this->form_validation->set_rules('ap_move_reason', 'Reason', 'trim|required');
            
			if($this->form_validation->run() == TRUE)
            {	
				if($_FILES["useridentity"]["name"] != '' && $_FILES["medicaldoc"]["name"] != ''){

					$config["upload_path"] =  'upload_file/idcard/';
					$config["allowed_types"] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
					$config['remove_spaces'] = TRUE;
					$config['overwrite'] = FALSE;
					$config['max_size'] = '20000';
					
					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					$_FILES["file"]["name"] = $_FILES["useridentity"]["name"];
					$_FILES["file"]["type"] = $_FILES["useridentity"]["type"];
					$_FILES["file"]["tmp_name"] = $_FILES["useridentity"]["tmp_name"];
					$_FILES["file"]["error"] = $_FILES["useridentity"]["error"];
					$_FILES["file"]["size"] = $_FILES["useridentity"]["size"];

					if($this->upload->do_upload('file'))
					{
						$upload_data = $this->upload->data();
						$up_useridentity = $upload_data['file_name'];

						$config["upload_path"] =  'upload_file/medical/';
						$config["allowed_types"] = 'jpg|jpeg|png|JPG|JPEG|PNG|pdf|PDF';
						$config['remove_spaces'] = TRUE;
						$config['overwrite'] = FALSE;
						$config['max_size'] = '20000';
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						$_FILES["file"]["name"] = $_FILES["medicaldoc"]["name"];
						$_FILES["file"]["type"] = $_FILES["medicaldoc"]["type"];
						$_FILES["file"]["tmp_name"] = $_FILES["medicaldoc"]["tmp_name"];
						$_FILES["file"]["error"] = $_FILES["medicaldoc"]["error"];
						$_FILES["file"]["size"] = $_FILES["medicaldoc"]["size"];

						if($this->upload->do_upload('file'))
						{
							$upload_data = $this->upload->data();
							$up_medical = $upload_data['file_name'];

							$random_keys = date('dmYHis') . $this->generateRandomString();
							if($idm_declar == 1){
								$idm_declar = "We shall not travel to or from a red zone/containment zone or any prohibited zone as per government orders.";
							}
							$row_array = array(
								'idm_ucode' => $random_keys,
								'idm_name' => ucfirst(trim($ap_name)),
								'idm_email' => $ap_email,
								'idm_mobile' => $ap_mobile,
								'idm_s_villege' => ucfirst(trim($ap_village)),
								'idm_s_gp' => ucfirst(trim($ap_gp)),
								'idm_s_block' => ucfirst(trim($ap_block)),
								'idm_s_district' => $ap_district,
								'idm_d_villege' => ucfirst(trim($ap_village_dest)),
								'idm_d_gp' => ucfirst(trim($ap_gp_dest)),
								'idm_d_block' => ucfirst(trim($ap_block_dest)),
								'idm_d_district' => $ap_district_dest,
								'idm_people' => $ap_pep_move,
								'idm_traveldate' => date('Y-m-d',strtotime($ap_movedate)),
								'idm_id_cardno' => trim($ap_idcard),
								'idm_id_cardtype' => ucfirst(trim($ap_idtype)),
								'idm_vehicle_no' => ucfirst(trim($ap_vno)),
								'idm_vehicle_type' => trim($ap_vtype),
								'idm_reason' => ucfirst(trim($ap_move_reason)),
								'idm_declaration' => $idm_declar,
								'idm_identity_doc' => $up_useridentity,
								'idm_medical_doc' => $up_medical,
								'idm_createdate' => date('Y-m-d H:i:s')
							);

							if($this->main_m->addUpdate_against_movement_Incovid($row_array) == TRUE){
								$profile_email = $ap_email;
								$e_sub = "Permission Application - Bankura";
								$e_msg = '<h2>Welcome to Portal for Permission for Inter District Movement<br/>(During Lockdown period of COVID-19)</h2><p style="font-size:18px;">Dear '.$row_array['idm_name'].',<br/>Your Application Form is submitted Successfully.<br/>Your Application Number :- <strong>'.$random_keys.'</strong></p><br/><br/>
								<p style="font-size:18px;">Check your Application Status by given link below -<br/>
								http://bankuradistrict.in/idm/idm_application_status</p>';
								$this->sendSMTPEmail($profile_email, $e_sub, $e_msg);
								
								$generate_otp_string1 = "Bankura - IDM Application is Submitted Successfully. Your Application No. is ".$random_keys.". Check Your Email for your Application Status.";
								$generate_otp_string = preg_replace("/ /", "%20", $generate_otp_string1);
								$URL = "http://www.smslive.in/Push/default.aspx?user=AL-BNK_DIS&pws=BNK2020&Receipent=".$row_array['idm_mobile']."&sms=".$generate_otp_string;
								$sms_feed_recv = file_get_contents($URL);
								
								$this->session->set_flashdata("success","Application Form successfully submitted.<br/>Your Application Number is - <strong>".$random_keys."</strong>");
		    					redirect('idm/idm_application_receipt/'.$random_keys,'refresh');
							}else{
								$this->data['error'] = "There have some problem to Update DB, Try Again.";
							}

						}else{
							$this->data['error'] = "Worker Details File not Upload Properly, Try Again.";
						}

					}else{
						$this->data['error'] = "Workorder File not Upload Properly, Try Again.";
					}
				}else{
					$this->data['error'] = "Upload Files not found, Check Again.";
				}
			}
            //exit;
		}
		$this->data['dist_list'] = $this->db->order_by('dist_name','ASC')->get_where('district_tab',array('dist_status'=>1))->result();
		$this->load->view('main/idm/idm_registration_view', $this->data);
		
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

	public function idm_application_status(){
		if($_POST){
			$ap_no = $this->input->post('ap_no');
			$this->form_validation->set_rules('ap_no', 'Application No', 'trim|required|is_natural');
			if($this->form_validation->run() == TRUE)
            {
				$a_detail = $this->db->get_where('movement_appliaction',array('idm_ucode'=>$ap_no))->row();
				if(count((array)$a_detail) > 0){
					$this->data['doc_detail'] = $a_detail;
				}else{
					$this->data['error'] = "Application Not Found, Check again.";
				}
			}
		}
		$this->load->view('main/idm/idm_status_view', $this->data);
	}

	public function idm_application_receipt($ap_no = NULL){
		$a_detail = $this->db->get_where('movement_appliaction',array('idm_ucode'=>$ap_no))->row();
		if(count((array)$a_detail) > 0){
			if($a_detail->idm_status != 1){
				redirect(default404);
			}
			$this->data['doc_detail'] = $a_detail;
		}else{
			redirect(default404);
		}
		$this->load->view('main/idm/idm_receipt_view', $this->data);
	}

	public function print_final_idm_permission_sheet($app_no = NULL)
	{
		//print_r($this->session->userdata('uid'));exit;
		if($app_no == "" || $app_no == NULL){
			redirect('default404');
		}
		
		$app_details = $this->db->get_where('movement_appliaction',array('idm_ucode'=>$app_no))->row();
		
		if(count((array)$app_details) == 0){
			redirect('default404');
		}
		if($app_details->idm_status != 3){
			redirect('default404');
		}
		/*$copy_arr = explode(",", $app_details->appli_copy_fwd);
		$copy_set = $this->main_m->get_all_conditions_copys_DB($app_details->appli_copy_fwd);
		if(count((array)$copy_set) == 0){
			redirect('default404');
		}*/
		//echo "hi";exit;
		$this->load->helper("tcpdf_helper");
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = $app_no;
		$obj_pdf->SetTitle($title);
		
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		
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
		//ob_start();
		    // we can have any view part here like HTML, PHP etc


		$my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>".$title."</title>
</head>
<body>
<div class=\"header\">";	
$my_html = $my_html."<table style=\"width: 100%\" style=\"font-size: 20px;\">
		<tr>
			<td colspan=\"2\" style=\"width:100%;\"><div align=\"center\" style=\"font-size:22px;\"><img src=\"".base_url()."images/wb_logo.png\" /><br/>GOVERNMENT OF WEST BENGAL<br/>
			OFFICE OF THE DISTRICT MAGISTRATE<br/>
			BANKURA</div></td>
		</tr>
  <tr><td colspan=\"2\">&nbsp;</td></tr>
  <tr><td colspan=\"2\">&nbsp;</td></tr>
	<tr>
    <td align=\"left\"><b>Memo No.</b> ".$app_details->idm_memo_no."</td>
    <td align=\"right\">Dated:- <strong>".date('d/m/Y',strtotime($app_details->idm_memo_date))."</strong></td>
  </tr>
  <tr>
    <td colspan=\"2\"><br/><br/>
	<table width=\"100%\" style=\"font-size: 20px;\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
		<tr>
			<td colspan=\"4\" align=\"center\"><u><b>EMERGENCY MOVEMENT</b></u><br/></td>
		</tr>
		<tr>
			<td colspan=\"4\">
			<p align=\"justify\">In terms of guidelines issued by the State Government vide Memo No. 103-CS/2020 dated 04-05-2020 movement is allowed as follows-</p><br/><br/>
			</td>
		</tr>
    	<tr>
			<td width=\"10%\">&nbsp;</td>
			<td width=\"25%\"><b>Name</b></td>
			<td width=\"5%\"><b>:</b></td>
			<td width=\"50%\">".$app_details->idm_name."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Identity card No.</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_id_cardno."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Identity type</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_id_cardtype."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>From</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_s_villege.", ".$app_details->idm_s_gp.", ".$app_details->idm_s_block.", ".$app_details->s_dist_name."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>To</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_d_villege.", ".$app_details->idm_d_gp.", ".$app_details->idm_d_block.", ".$app_details->d_dist_name."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Type of Emergency</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_reason."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Vehicle No.</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_vehicle_no."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Vehicle Type</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_vehicle_type."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>No. of person</b></td>
			<td><b>:</b></td>
			<td>".$app_details->idm_people."</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><b>Date of Travel</b></td>
			<td><b>:</b></td>
			<td>".date('d/m/Y',strtotime($app_details->idm_traveldate))."</td>
		</tr>
		</table><br/><br/>
    </td>
  </tr>
  <tr>
    <td colspan=\"2\" align=\"left\">Movement using this pass is not allowed for red zone/containment zone or any other zone where movement is restricted by government orders.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<td align=\"center\"><table>
	<tr>
		<td>&nbsp;</td>
		<td><div align=\"center\"><img src=\"".base_url()."images/signature2.jpg\" />
		<br/>District Magistrate<br/>Bankura</div></td>
	</tr>
  </table></td>
  </tr>
  <tr>
	<td colspan=\"2\">&nbsp;<br/><br/></td>
  </tr>
  <tr>
    <td align=\"left\"><b>Memo No.</b> ".$app_details->idm_memo_no."</td>
	<td align=\"right\">Dated:- <strong>".date('d/m/Y',strtotime($app_details->idm_memo_date))."</strong></td>
  </tr>
  <tr>
	<td colspan=\"2\">&nbsp;</td>
  </tr>
  <tr>
	<td colspan=\"2\"><p>Copy forwarded for kind information to the -</p></td>
  </tr>
  <tr>
	<td colspan=\"2\">";
	if($app_details->s_dist_name != "Bankura"){
		if($app_details->s_dist_name != "Kolkata"){
			$my_html = $my_html."<p>1. District Magistrate, ".$app_details->s_dist_name."<br/>
			2. Superintendent of Police, ".$app_details->s_dist_name."<br/>
			3. Superintendent of Police, Bankura</p>";
		}else{
			$my_html = $my_html."<p>1. Commissioner of Police, ".$app_details->s_dist_name."<br/>
			2. Municipal Commissioner, ".$app_details->s_dist_name."<br/>
			3. Superintendent of Police, Bankura</p>";
		}
	}elseif($app_details->d_dist_name != "Bankura"){
		if($app_details->d_dist_name != "Kolkata"){
			$my_html = $my_html."<p>1. District Magistrate, ".$app_details->d_dist_name."<br/>
			2. Superintendent of Police, ".$app_details->d_dist_name."<br/>
			3. Superintendent of Police, Bankura</p>";
		}else{
			$my_html = $my_html."<p>1. Commissioner of Police, ".$app_details->d_dist_name."<br/>
			2. Municipal Commissioner, ".$app_details->d_dist_name."<br/>
			3. Superintendent of Police, Bankura</p>";
		}
	}
	$my_html = $my_html."</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td align=\"center\"><table>
	  <tr>
		  <td>&nbsp;</td>
		  <td><div align=\"center\"><img src=\"".base_url()."images/signature2.jpg\" />
		  <br/>District Magistrate<br/>Bankura</div></td>
	  </tr>
	</table></td>
  </tr>
</table>
</div>
</body>
</html>";
		
		$content = $my_html; //ob_get_contents();
		//ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output($app_no.'.pdf', 'I');
		//$obj_pdf->Output(FCPATH.'/pdf/'.$advice_detail->advice_id.'.pdf', 'D');
		
		//$this->session->set_flashdata("success","Report is Generated Successfully");
		
	}
	
	
}