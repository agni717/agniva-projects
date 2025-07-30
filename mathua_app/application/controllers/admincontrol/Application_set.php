<?php
  class Application_set extends Admin_Controller {

      public function __construct() {

        parent::__construct();

        date_default_timezone_set("Asia/Kolkata");
        $this->load->model('member_m');
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);

      }

      public function index(){

         $this->load->view('admin/application_search', $this->data);
      }

      public function add_document($application_id){
        if($application_id == NULL){
          redirect('admincontrol/dashboard');
        }
        $this->data['canddata'] = $canddata = $this->member_m->get_candidate_details($application_id);
        $this->data['intvw_data'] = $intvw_data = $this->member_m->get_interViewuploaded_details($application_id);
        if(count((array)$canddata) == 0){
          redirect('admincontrol/dashboard');
        }
        if(count((array)$intvw_data) > 0){
          redirect('admincontrol/application_set/upload_webcam_picture/'.$application_id);
        }
        $this->data['application_id'] = $application_id; 
        $this->load->view('admin/add_document', $this->data);
      }

      /*public function interview_marks(){
        $this->load->view('admin/interview_marks', $this->data);  
      }*/

      public function upload_webcam_picture($application_id){
        if($application_id == NULL){
          redirect('admincontrol/dashboard');
        }
        $this->data['canddata'] = $canddata = $this->member_m->get_candidate_details($application_id);
        $this->data['intvw_data'] = $intvw_data = $this->member_m->get_interViewuploaded_details($application_id);
        if(count((array)$canddata) == 0){
          redirect('admincontrol/dashboard');
        }
        if(count((array)$intvw_data) == 0){
          redirect('admincontrol/application_set/add_document/'.$application_id);
        }
        if(!empty($canddata->cr_interview_pic)){
          redirect('admincontrol/application_set');
        }
        $this->data['application_id'] = $application_id; 
        $this->load->view('admin/application_webcam_pic', $this->data);
      }

      public function get_application_data(){

        if(isset($_POST) && !empty($_POST)){

          $key = $this->input->post('key');

          
          if($key != ""){
          $data = $this->member_m->get_candidate_details($key);
          $intvw_data = $this->member_m->get_interViewuploaded_details($key);
          
          if(count((array)$data) > 0){
          echo json_encode(array('msg'=> 1, 'resdata_set'=>$data, 'intv_data'=>$intvw_data));  
          }else{
          echo json_encode(array('msg'=> 0, 'e_msg'=>'Candidate Not Found. Check Again.'));  
          }
          }else{
          echo json_encode(array('msg'=> 0, 'e_msg'=>'Enter Registration No. Properly, Check Again.'));  
          }
          exit;
        }else{
          redirect('default404');
        }
        /*if(isset($_POST) && !empty($_POST)){

          $key = $this->input->post('key');

          $this->load->model('member_m');
          $data = $this->member_m->get_candidate_details($key);

          echo json_encode($data);
        }

        else redirect('default404');*/
      }

      public function upload_doc(){

        $this->load->model('member_m');
        date_default_timezone_set('Asia/Kolkata');

        if(isset($_POST) && !empty($_POST)){

          $this->load->model('member_m');

          $titles = $this->input->post('doc_title');
          $reg_no = $this->input->post('reg_no');
          $adv = $this->member_m->get_candidate_applied_for($reg_no);

          $files = $_FILES['doc_file'];

          // SET UPLOAD PATH
          // ---------------
          define('UPLOAD_DIR', 'upload_file/'.$adv->f_applied_for.'/candidates/'.$reg_no.'/');
          // ---------------
          
          for($i=0;$i<count($files['name']);$i++){

            if(!$files['error'][$i]){

              $file_type = strtolower(pathinfo($files['name'][$i],PATHINFO_EXTENSION));
              $file_name = uniqid(). uniqid().'.'.$file_type;
              $file = UPLOAD_DIR.$file_name;

              if($titles[$i] != '') $file_title = $titles[$i];
              else $file_title = 'Doc_'.uniqid();

              if(move_uploaded_file($files['tmp_name'][$i], $file)){
                
               $interview_doc = array(
                    'fattach_application'=>$reg_no,
                    'fattach_doc_title'=>$file_title,
                    'fattach_doc_source'=>$file_name,
                    'fattach_datetime'=>date('Y-m-d H:i:s'),
                    'dattach_createby'=>$_SESSION['uid'] 
                );

                $this->member_m->insert_into_interview_attachment($interview_doc);

              }

              else{

                echo json_encode(array('msg'=>0,'e_msg'=>'Failed to upload document','doc_no'=>$i));
                return;

              }

            }
            else{

              echo json_encode(array('msg'=>0,'e_msg'=>'Failed to upload document'));
              return;
            }
          }

          echo json_encode(array('msg'=>1,'e_msg'=>'Document(s) uploaded successfully!'));
          
        }

        else redirect('default404');

      }

      public function printwatermark_withinterview_callletter($candid){

        if($candid == NULL){
          redirect('default404');
        }
        $resdetails = $this->db->get_where('candidate_result_tab', array('cr_application_master'=>$candid, 'cr_approval'=>'Approved'))->row();
        if(count((array)$resdetails) == 0){
          redirect('default404');
        }elseif(empty($resdetails->cr_interview_pic)){
          redirect('default404');
        }
        $this->load->model('main_m');
        $this->load->model('member_m');
        $userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $candid))->row();
        $mid = $userdetails->f_uid;
        //$userdetails = $this->db->get_where('f_user_views', array('f_uid' => $mid))->row();
        //print_r($userdetails->f_application_no);exit;
        if ($userdetails->fu_step_4 != 1) {
          redirect('admincontrol/dashboard');
        }
        if ($userdetails->fu_final_submit != 1) {
          redirect('admincontrol/dashboard');
        }
    
        if ($userdetails->fu_payment_stat != 1) {
          redirect('admincontrol/dashboard');
        }
        $adv_detail = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($userdetails->f_applied_for);
        $getdetails_interview = $this->member_m->gotoDetails_SearchforInterview_Set($userdetails->f_application_no);
        $caste_tab = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
      
        if(count((array)$getdetails_interview) == 0){
          redirect('admincontrol/dashboard');
        }
    
        if ($userdetails->fu_step_1 == 1) {
    
          $adv_category = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
        }
    
        if ($userdetails->fu_step_2 == 1) {
    
          $dist_list = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();
    
          if ($userdetails->fu_district != NULL) {
    
            $sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district))->result();
            $police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district))->result();
          }
          if ($userdetails->fu_perma_dist != NULL) {
    
            $per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist))->result();
            $per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist))->result();
          }
          if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
      
            $per_mb_type = $userdetails->fu_perma_mb_type;
            $per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type))->result();
          }else{
            $per_mb_type = NULL;
            $per_block_municipality = array();
          }
      
          if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
      
            $mb_type = $userdetails->fu_mb_type;
            $block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type))->result();
          }else{
            $mb_type = NULL;
            $block_municipality = array();
          }
          //$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
        }
    
        $exp_list = $this->member_m->gotoDesire_Experience_listSet($mid);
        $essenexp_list = $this->member_m->gotoEssential_Experience_listSet($mid);
        $desquali_list = $this->member_m->gotoDesire_Qualification_listSet($mid);
        $quali_list = $this->member_m->get_fuser_qualification_v2($mid);
    
        $state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
    
        $dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();
    
        $rules_list = $this->db->order_by('rm_order ASC, rm_id ASC')->get_where('rules_master', array('rm_status' => 1))->result();
    
        $pathurl = 'upload_file/'. $userdetails->f_applied_for .'/candidates/' . $userdetails->f_application_no . '/';
        error_reporting(0);
          
          $this->load->helper("tcpdf_helper");
          tcpdf();
          //$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          //$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          $obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          
          $obj_pdf->SetCreator(PDF_CREATOR);
          $title = $userdetails->f_application_no;
          $obj_pdf->SetTitle('Interview');
          $obj_pdf->SetAuthor('WB-HRB');
          $obj_pdf->SetSubject('Interview CallLetter');
      
          //$obj_pdf->SetPrintHeader(false);
          $obj_pdf->SetPrintFooter(false);
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
        <div class=\"header\">
        <table style=\"width: 100%;font-size: 20px;\">
        <tr>
          <td colspan=\"2\" style=\"width:100%;\">
            <table style=\"width: 100%;font-size: 22px;\">
            <tr>
            <td style=\"width:10%;\">&nbsp;</td>
            <td style=\"width:80%;\">
              <div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:100px;\" /><br/>
              <span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">Tele Fax No 23570085 & Tele. no. (033)-2340-5200</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\"><i>Email: wbhealthrecruitmentboard@gmail.com</i></span><br/>
              <span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter Check</u></span>
              </div>
            </td>
            <td style=\"width:10%;\">&nbsp;</td>
            </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan=\"2\" style=\"width:100%;\">
            <table style=\"width: 100%;font-size: 22px;\">
            <tr>
              <td style=\"width:80%;\" colspan=\"3\">
                <table style=\"width: 100%;font-size: 20px;\">
                  <tr>
                    <td colspan=\"2\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\">Advt. No. : ".$adv_detail->adv_no."</td>
                    <td align=\"center\">Dated : ".date('d/m/Y',strtotime($adv_detail->adv_start_time))."</td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" style=\"width:100%;\"><br/><br/>
                      <table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 20px;\">
                        <tr>
                          <td colspan=\"2\">NAME : ".$userdetails->f_full_name."</td>
                        </tr>
                        <tr>
                          <td colspan=\"2\">ADDRESS : "; 
                          
                          foreach ($state_list as $states) {
                            if ($states->state_id == $userdetails->fu_state) { $my_html = $my_html . "State : " .$states->state_name;break; }
                          }
                          if($userdetails->fu_state == 28){  
                            foreach ($dist_list as $dists) { 
                              if ($dists->district_code == $userdetails->fu_district) { $my_html = $my_html . ", District : " . $dists->district_name; }
                            }
                          }else{
                            $my_html = $my_html . ", District : ".$userdetails->fu_other_district;
                          }
                
                          if($userdetails->fu_state == 28){
                            foreach ($sub_division as $sd) {
                              if ($userdetails->fu_sub_division == $sd->subdiv_id){ $my_html = $my_html . ", Sub-Division :" . $sd->subdiv_name; }
                            }
                            $bmset = '';
                            foreach ($block_municipality as $bm) { 
                              if ($bm->block_id == $userdetails->fu_block_municipality) {$bmset = $bm->block_name;}
                            }
                            $my_html = $my_html . ", Block/ Municipality : " . $userdetails->fu_mb_type.' ('.$bmset.')';
                          }else{
                            $my_html = $my_html . ", Sub-Division : ".$userdetails->fu_other_sdiv;
                            $my_html = $my_html . ", Block/ Municipality : ".$userdetails->fu_other_blockm;
                          }
                
                          if($userdetails->fu_state == 28){
                            foreach ($police_station as $ps) {
                              if ($userdetails->fu_police_station == $ps->ps_id) {$my_html = $my_html .", Police Station : ". $ps->ps_name;}
                            }
                          }else{
                            $my_html = $my_html . ", Police Station : ".$userdetails->fu_other_ps;
                          }
                          $my_html = $my_html . ", Ward/GP : ".$userdetails->fu_ward_gp.", Vill / Para / House No / Road : ".$userdetails->fu_house_road.", Post Office : ".$userdetails->fu_post_office.", Pin : ".$userdetails->fu_pincode;
                          $my_html = $my_html."</td>
                        </tr>
                        <tr>
                          <td colspan=\"2\">POST : ".$adv_detail->rm_name."</td>
                        </tr>
                        <tr>
                          <td>CATEGORY : ";
              foreach ($caste_tab as $caste){
                if($userdetails->fu_caste_type == $caste->caste_id){ 
                  $my_html = $my_html . $caste->caste_name;break;
                }
              }
              $my_html = $my_html . "</td>
                          <td>PH STATUS : ".$userdetails->fu_pwd."</td>
                        </tr>
                        <tr>
                          <td colspan=\"2\">REGISTRATION NO : ".$userdetails->f_application_no."</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td style=\"width:20%;\" valign=\"top\">
                <table border=\"1\" style=\"width: 100%;padding:5px;\">
                  <tr>
                    <td>
                    <img src=\"".base_url().$pathurl.$userdetails->fu_photo_doc."\" style=\"max-width:150px;\" />
                    </td>
                  </tr>
                </table>
                <br>
                <table border=\"1\" style=\"width: 100%;padding:5px;\">
                  <tr>
                    <td>
                    <img src=\"".base_url().$pathurl.$userdetails->fu_signature_doc."\" style=\"max-width:180px;\" />
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <tr><td colspan=\"2\">&nbsp;</td></tr>
        <tr>
          <td colspan=\"2\" style=\"font-size: 18px;\">
            <table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 18px;\">
              <tr>
                <td align=\"center\" style=\"width:50%;\"><strong>PLACE OF REPORTING</strong></td>
                <td align=\"center\" style=\"width:13%;\"><strong>DATE OF INTERVIEW</strong></td>
                <td align=\"center\" style=\"width:13%;\"><strong>REPORTING TIME</strong></td>
                <td align=\"center\" style=\"width:24%;\"><strong>SHIFT</strong></td>
              </tr>
              <tr>
                <td>".$getdetails_interview->address_name."</td>
                <td>".date('d-m-Y',strtotime($getdetails_interview->shift_date))."</td>
                <td>".date('h:i A',strtotime($getdetails_interview->invw_reporting_time))."</td>
                <td>".date('h:i A',strtotime($getdetails_interview->shift_start_time))." to ".date('h:i A',strtotime($getdetails_interview->shift_end_time))."</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align=\"center\" colspan=\"2\" style=\"width:100%;\">&nbsp;</td>
        </tr>
        <tr>
          <td align=\"center\" colspan=\"2\" style=\"font-size:70px;width:100%;\"><strong>ATTENDED</strong></td>
        </tr>
        <tr>
          <td align=\"center\" colspan=\"2\" style=\"font-size:50px;width:100%;\"><strong>ALLOTTED TABLE NO. ".$getdetails_interview->invw_tableno."</strong></td>
        </tr>
        </table>
        </div>
        </body>
        </html>";
    
        $content = $my_html; //ob_get_contents();
        //ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->IncludeJS("print();");
        $obj_pdf->Output($title . '.pdf', 'I');

      }
    
      public function printwatermark_withinterview_callletter321($candid){

        $resdetails = $this->db->get_where('candidate_result_tab', array('cr_application_master'=>$candid, 'cr_approval'=>'Approved'))->row();
        $this->load->model('main_m');
        $this->load->model('member_m');
        $userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $candid))->row();
        $mid = $userdetails->f_uid;
        //$userdetails = $this->db->get_where('f_user_views', array('f_uid' => $mid))->row();
        //print_r($userdetails->f_application_no);exit;
        $adv_detail = $this->main_m->getAll_list_of_ActiveforLogin_Advertisement($userdetails->f_applied_for);
        $getdetails_interview = $this->member_m->gotoDetails_SearchforInterview_Set($userdetails->f_application_no);
        $caste_tab = $this->db->where('caste_status',1)->where_in('caste_cat',array(1,2))->get('caste_tab')->result();
      
        if ($userdetails->fu_step_1 == 1) {
    
          $adv_category = $this->member_m->getAll_list_Advertisement_Category($userdetails->f_applied_for, $userdetails->fu_category);
        }
    
        if ($userdetails->fu_step_2 == 1) {
    
          $dist_list = $this->db->get_where('district_master', array('district_id' => $userdetails->fu_district, 'district_status' => 1))->row();
    
          if ($userdetails->fu_district != NULL) {
    
            $sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_district))->result();
            $police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_district))->result();
          }
          if ($userdetails->fu_perma_dist != NULL) {
    
            $per_sub_division = $this->db->get_where('subdivision_tab', array('subdiv_district' => $userdetails->fu_perma_dist))->result();
            $per_police_station = $this->db->get_where('police_station_tab', array('ps_dist_master' => $userdetails->fu_perma_dist))->result();
          }
          if ($userdetails->fu_perma_sub_division != NULL && $userdetails->fu_perma_mb_type != NULL) {
      
            $per_mb_type = $userdetails->fu_perma_mb_type;
            $per_block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_perma_sub_division, 'block_type' => $userdetails->fu_perma_mb_type))->result();
          }else{
            $per_mb_type = NULL;
            $per_block_municipality = array();
          }
      
          if ($userdetails->fu_sub_division != NULL && $userdetails->fu_mb_type != NULL) {
      
            $mb_type = $userdetails->fu_mb_type;
            $block_municipality = $this->db->get_where('block_master', array('subd_id' => $userdetails->fu_sub_division, 'block_type' => $userdetails->fu_mb_type))->result();
          }else{
            $mb_type = NULL;
            $block_municipality = array();
          }
          //$this->data['state_list'] = $this->db->get_where('state_master', array('state_id' => $userdetails->fu_domicile_state, 'state_status' => 1))->result();
        }
    
        $exp_list = $this->member_m->gotoDesire_Experience_listSet($mid);
        $essenexp_list = $this->member_m->gotoEssential_Experience_listSet($mid);
        $desquali_list = $this->member_m->gotoDesire_Qualification_listSet($mid);
        $quali_list = $this->member_m->get_fuser_qualification_v2($mid);
    
        $state_list = $this->db->order_by('state_name ASC')->get_where('state_master', array('state_status' => 1))->result();
    
        $dist_list = $this->db->order_by('district_name ASC')->get_where('district_master', array('district_status' => 1))->result();
    
        $rules_list = $this->db->order_by('rm_order ASC, rm_id ASC')->get_where('rules_master', array('rm_status' => 1))->result();
    
        $pathurl = 'upload_file/'. $userdetails->f_applied_for .'/candidates/' . $userdetails->f_application_no . '/';
        error_reporting(0);
          
          $this->load->helper("tcpdf_helper");
          tcpdf();
          //$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          //$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          $obj_pdf = new MyCustomPDFWithWatermark('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
          
          $obj_pdf->SetCreator(PDF_CREATOR);
          $title = $userdetails->f_application_no;
          $obj_pdf->SetTitle('Interview');
          $obj_pdf->SetAuthor('WB-HRB');
          $obj_pdf->SetSubject('Interview CallLetter');
      
          //$obj_pdf->SetPrintHeader(false);
          $obj_pdf->SetPrintFooter(false);
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
        <div class=\"header\">
        <table style=\"width: 100%;font-size: 20px;\">
        <tr>
          <td colspan=\"2\" style=\"width:100%;\">
            <table style=\"width: 100%;font-size: 22px;\">
            <tr>
            <td style=\"width:10%;\">&nbsp;</td>
            <td style=\"width:80%;\">
              <div align=\"center\"><img src=\"".base_url()."images/WBHRB_Logo.jpg\" style=\"width:100px;\" /><br/>
              <span style=\"font-size:22px;font-weight:bold;\">West Bengal Health Recruitment Board</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">Tele Fax No 23570085 & Tele. no. (033)-2340-5200</span><br/>
              <span align=\"center\" style=\"font-size:16px;font-weight:normal;\"><i>Email: wbhealthrecruitmentboard@gmail.com</i></span><br/>
              <span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter Check</u></span>
              </div>
            </td>
            <td style=\"width:10%;\">&nbsp;</td>
            </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan=\"2\" style=\"width:100%;\">
            <table style=\"width: 100%;font-size: 22px;\">
            <tr>
              <td style=\"width:80%;\" colspan=\"3\">
                <table style=\"width: 100%;font-size: 20px;\">
                  <tr>
                    <td colspan=\"2\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\">Advt. No. : ".$adv_detail->adv_no."</td>
                    <td align=\"center\">Dated : ".date('d/m/Y',strtotime($adv_detail->adv_start_time))."</td>
                  </tr>
                  <tr>
                    <td colspan=\"2\" style=\"width:100%;\"><br/><br/>
                      <table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 20px;\">
                        <tr>
                          <td colspan=\"2\">NAME : ".$userdetails->f_full_name."</td>
                        </tr>
                        <tr>
                          <td colspan=\"2\">POST : ".$adv_detail->rm_name."</td>
                        </tr>
                        <tr>
                          <td>CATEGORY : </td>
                          <td>PH STATUS : ".$userdetails->fu_pwd."</td>
                        </tr>
                        <tr>
                          <td colspan=\"2\">REGISTRATION NO : ".$userdetails->f_application_no."</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td style=\"width:20%;\" valign=\"top\">
                <table border=\"1\" style=\"width: 100%;padding:5px;\">
                  <tr>
                    <td>
                    <img src=\"".base_url().$pathurl.$userdetails->fu_photo_doc."\" style=\"max-width:150px;\" />
                    </td>
                  </tr>
                </table>
                <br>
                <table border=\"1\" style=\"width: 100%;padding:5px;\">
                  <tr>
                    <td>
                    <img src=\"".base_url().$pathurl.$userdetails->fu_signature_doc."\" style=\"max-width:180px;\" />
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <tr><td colspan=\"2\">&nbsp;</td></tr>
        <tr>
          <td colspan=\"2\" style=\"font-size: 18px;\">
            <table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 18px;\">
              <tr>
                <td align=\"center\" style=\"width:50%;\"><strong>PLACE OF REPORTING</strong></td>
                <td align=\"center\" style=\"width:13%;\"><strong>DATE OF INTERVIEW</strong></td>
                <td align=\"center\" style=\"width:13%;\"><strong>REPORTING TIME</strong></td>
                <td align=\"center\" style=\"width:24%;\"><strong>SHIFT</strong></td>
              </tr>
              <tr>
                <td>".$getdetails_interview->address_name."</td>
                <td>".date('d-m-Y',strtotime($getdetails_interview->shift_date))."</td>
                <td>".date('h:i A',strtotime($getdetails_interview->invw_reporting_time))."</td>
                <td>".date('h:i A',strtotime($getdetails_interview->shift_start_time))." to ".date('h:i A',strtotime($getdetails_interview->shift_end_time))."</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align=\"center\" colspan=\"2\" style=\"width:100%;\">&nbsp;</td>
        </tr>
        </table>
        </div>
        </body>
        </html>";
    
        $content = $my_html; //ob_get_contents();
        //ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->IncludeJS("print();");
        $obj_pdf->Output($title . '.pdf', 'I');

      }


      public function interview_details_candidate(){
        if($this->session->userdata['utype'] != 1){
          redirect('admincontrol/dashboard');
        }
        $this->load->view('admin/profile/interview_details_search', $this->data);
      }
  
      public function get_application_data_v2(){

        if(isset($_POST) && !empty($_POST)){

          $key = $this->input->post('key');
          
          if($key != ""){
            $data = $this->admin_m->get_interviewcandidate_details($key);
            $intvw_data = $this->member_m->get_interViewuploaded_details($key);
            
            if(count((array)$data) > 0){
              echo json_encode(array('msg'=> 1, 'resdata_set'=>$data, 'intv_data'=>$intvw_data));  
            }else{
              echo json_encode(array('msg'=> 0, 'e_msg'=>'Candidate Not Found. Check Again.'));  
            }
          }else{
            echo json_encode(array('msg'=> 0, 'e_msg'=>'Enter Registration No. Properly, Check Again.'));  
          }
          exit;
        }else{
          redirect('default404');
        }
      }
  
  }
?>
