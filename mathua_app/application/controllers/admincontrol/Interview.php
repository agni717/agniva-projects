<?php
  
  class Interview extends Admin_Controller{

    function __construct(){

        parent::__construct();
        $this->data["u_details"] = $this->admin_m->GetDetailsofUsers($this->session->userdata['uid']);

        $this->load->model('candidates_m');
    }

    public function index(){
      redirect('admincontrol/dashboard');
    }

    public function panelcandidate_beforecall_list(){
        if($_POST){

        }
        $this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
		    $this->load->view('admin/interview/complete_application_list', $this->data);
    }

    public function interview_panelcandidate_segrigation(){
      if($this->session->userdata['utype'] > 1){
        redirect('admincontrol/dashboard');
      }
      $querysets = $this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
      $this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      $this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->load->view('admin/interview/add_candidate_for_interview', $this->data);
    }

    public function new_interviewsets_submission()
    {
      if ($_POST) {

        //$exam_gen = $this->input->post("exam_gen");
        $advno = $this->input->post("advno");
        $has_cand_main = $this->input->post("has_cand_main");
        $intcand_sec = $this->input->post("intcand_sec");
        $cand_selection_no = $this->input->post("cand_selection_no");
        $rf_set = $this->input->post("rf_set");
        $adv_temp_intvno = $this->input->post("adv_temp_intvno");
        $u_startdate = $this->input->post('u_startdate');
        $u_endtime = $this->input->post('u_endtime');
        $u_starttime = $this->input->post('u_starttime');
        $catg_counter = $this->input->post('catg_counter');

        $table_stn = $this->input->post('table_stn');
        $venueno = $this->input->post('venueno');

        $this->form_validation->set_rules('advno', 'Advertisement ID', 'trim|required');
        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('catg_counter', 'Advertisement Posts', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('has_cand_main', 'Candidate', 'trim|required');
        $this->form_validation->set_rules('intcand_sec', 'Interview Candidate', 'trim|required');

        
        
        $this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
        $this->form_validation->set_rules('u_endtime', 'Shift End Time', 'trim|required');
        $this->form_validation->set_rules('u_starttime', 'Shift Start Time', 'trim|required');
        $this->form_validation->set_rules('adv_temp_intvno', 'Autogen ID', 'trim|required');

        $this->form_validation->set_rules('table_stn', 'Each Table Strength', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('venueno', 'Address', 'trim|required|is_natural_no_zero');
        if($intcand_sec == "MM" || $intcand_sec == "MV"){
          $this->form_validation->set_rules('cand_selection_no', 'Number', 'trim|required');
        }
        if ($this->form_validation->run()) {

                ////////////////
                $ss_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_starttime));
                $ee_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_endtime));
                $report_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ss_datetime)));
                $get_posts = $this->candidates_m->getAllResult_ofIndividual_POSTS_ofADV($advno, $adv_temp_intvno);
                if(count((array)$get_posts) > 0){
                  $parray_set = array();
                  $tabarray_set = array();
                  $totaltab = 0;
                  $errorcounter = 0;
                  $errorstring = '';
                  foreach($get_posts as $keys=>$p_item){
                    $tab_start = 1;
                    $parray_set[] = array(
                      'postid'=>$p_item->idm_adv_category,
                      'tabno'=>$p_item->idm_cat_tableno
                    );
                    if($totaltab != 0){
                      $tab_start = $tab_start + $totaltab;
                    }
                    $totaltab = $totaltab + $p_item->idm_cat_tableno;
                    for($i=$tab_start;$i<=$totaltab;$i++){
                      $tabarray_set[$p_item->idm_adv_category][] = $i;
                    }
                    if($intcand_sec == "MV"){
                      $cand_selection_no = (int)$cand_selection_no * (int)$p_item->acat_total;
                    }elseif($intcand_sec == "MM"){
                      $cand_selection_no = (float)$cand_selection_no;
                    }
                    $taotal_cand_strenth_per_category = (int)$p_item->idm_cat_tableno * (int)$table_stn;
                    $get_cand_results = $this->candidates_m->getAll_interview_Segrigation_search_candidate($taotal_cand_strenth_per_category, $advno, $p_item->idm_adv_category, $has_cand_main, $intcand_sec, $cand_selection_no);

                    $countertable = 0;
                    foreach($get_cand_results as $cand_items){
                      if($countertable >= $p_item->idm_cat_tableno){
                        $countertable = 0;
                      }
                      $row_arr = array(
                        'invw_cand_regno' => $cand_items->cr_application_master,
                        'invw_cand_marks' => $cand_items->t_marks,
                        'invw_venuemaster' => $venueno,
                        'invw_reporting_time' => $report_datetime,
                        'invw_shift_starttime' => $ss_datetime,
                        'invw_shift_endtime' => $ee_datetime,
                        'invw_tableno' => $tabarray_set[$p_item->idm_adv_category][$countertable],
                        'invw_createdate' => date('Y-m-d H:i:s'),
                        'invw_createby' => $this->session->userdata['uid']
                      );
                      $countertable++;
                      if ($this->candidates_m->addupdate_FinalInterview_categorywise_inDB($row_arr) == FALSE) {
                        $errorcounter++;
                        $errorstring = $errorstring.$errorcounter.'. '.$cand_items->cr_application_master.' - Problem Arrived<br/>';
                      }
                    }

                  }
                  if ($errorcounter == 0) {
                    $row_arrsets = array(
                      'idm_status'=>2
                    );
                    $this->candidates_m->addupdate_tempInterview_category_inDB($row_arrsets,$adv_temp_intvno);
                    echo json_encode(array('msg' => 1));
                  } else {
                    echo json_encode(array('msg' => 0, 'e_msg' => $errorstring));
                  }
                }else{
                  echo json_encode(array('msg' => 0, 'e_msg' => 'Please select a Post for Interview, Try again.'));
                }
                

                /*$row_arr = array(
                  'invw_cand_regno' => $adv_no,
                  'invw_cand_marks' => $adv_name,
                  'invw_venuemaster' => $r_for,
                  'invw_reporting_time' => $ss_datetime,
                  'invw_shift_starttime' => $ss_datetime,
                  'invw_shift_endtime' => $ee_datetime,
                  'invw_tableno' => $scale_pay,
                  'invw_createdate' => date('Y-m-d H:i:s'),
                  'invw_createby' => $this->session->userdata['uid']
                );
                $row_arr2 = array(
                  'amark_adv_master' => $adv_no,
                  'amark_academic' => $academic_marks,
                  'amark_experience' => $experience_marks,
                  'amark_interview' => $interview_marks,
                  'amark_written' => $written_marks,
                  'amrk_createdate' => date('Y-m-d H:i:s')
                );

                if ($this->admin_m->ASASDASDASDSD_addform_against_Advertisement_inDB($row_arr) == TRUE) {
                  echo json_encode(array('msg' => 1));
                } else {
                  echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
                }*/
                //////////////////////////
        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }

    public function get_allcandidate_forpanel_setup(){
      if($_POST){
        $rf_set = $this->input->post("rf_set");
        $advno = $this->input->post("advno");

        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');

        if($this->form_validation->run()){
          $cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
          $cat_details_sets = '';
          $cat_item_sets = '';
          $category_arr = array();
          foreach($cat_details as $catg){
            $cat_details_sets = $cat_details_sets . '<option value="'.$catg->acat_id.'">' .$catg->catm_name. '</option>';
            $item_cat_count = $this->candidates_m->checkCandidate_forInterview_sectionset($advno, $catg->acat_id);
            $cat_item_sets = $cat_item_sets."<br/>".$item_cat_count." - Record Found For ".$catg->catm_name;
            $category_arr[$catg->acat_id] = $item_cat_count;
          }
          $result_details = $this->candidates_m->checkCandidate_forInterview_sectionset($advno);
          echo json_encode(array('msg' => 1, 'category_array' => $category_arr, 'category_set' => $cat_details_sets, 'op_set' => $result_details, 'item_set' => $cat_item_sets));
        }else{
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      }else{
        redirect('default404');
      }

    }

    public function new_category_submission_adv(){
      if ($_POST) {
        $advno = $this->input->post("advno");
        $adv_temp_intvno = $this->input->post("adv_temp_intvno");
        $advcat_name = $this->input->post("advcat_name");
        $advcat_table = $this->input->post("advcat_table");
  
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        $this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advcat_table', 'Table No.', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('adv_temp_intvno', 'AUTOGEN ID', 'trim|required');

        if ($this->form_validation->run()) {
  
          if ($this->candidates_m->check_Existing_CategoryAdv_asperAUTOGEN_inDB($advno, $advcat_name, $adv_temp_intvno) == TRUE) {

            $row_arr = array(
              'idm_adv_no' => $advno,
              'idm_autogen_code' => $adv_temp_intvno,
              'idm_adv_category' => $advcat_name,
              'idm_cat_tableno' => $advcat_table,
              'idm_createdate' => date('Y-m-d H:i:s'),
              'idm_createby' => $this->session->userdata('uid')
            );

            $resultset = $this->candidates_m->addupdate_tempInterview_category_inDB($row_arr);
            if ($resultset != FALSE) {
                $resultbunch = $this->candidates_m->getDetails_ADV_Category_forInterview($resultset);
                echo json_encode(array('msg' => 1, 'cat_set' => $resultbunch));
            } else {
              echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
            }
          } else {
            echo json_encode(array('msg' => 0, 'e_msg' => 'Category already inserted, check again.'));
          }
        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }

    public function delete_catset_update()
    {
      if ($_POST) {
        $qid = $this->input->post("qid");
        $this->form_validation->set_rules('qid', 'CAT ID', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run()) {

          $resultrow = $this->db->get_where('intv_data_manipulate', array('idm_id' => $qid))->row();
          if (count((array)$resultrow) > 0) {
              $getafter_shift = $this->db->where('idm_shift_no',$resultrow->idm_shift_no)->where('idm_autogen_code',$resultrow->idm_autogen_code)->where('idm_id >', $qid)->get('intv_data_manipulate')->result();
              if ($this->db->delete('intv_data_manipulate', array('idm_id' => $qid))) {
                if(count((array)$getafter_shift) > 0){
                  $shiftarray = array();
                  foreach($getafter_shift as $aftersft_item){
                    $shiftarray[] = $aftersft_item->idm_id;
                  }
                  $this->candidates_m->shiftdown_AllSection_MasterShift_TableStart($shiftarray, $resultrow->idm_cat_tableno);
                }
                echo json_encode(array('msg' => 1, 'expmarks' => $resultrow));
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

    public function interview_panelcandidate_tablewise_list(){
      if($this->session->userdata['utype'] > 1){
        redirect('admincontrol/dashboard');
      }
      if($_POST){
        //print_r($_POST);exit;
        $advno = $this->input->post("advno");
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
        }
        
      }
      $this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      $this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->load->view('admin/interview/table_wise_list', $this->data);
    }

    public function interview_panelcandidate_table_modify($intv_id = NULL){
      if($this->session->userdata['utype'] > 1){
        redirect('admincontrol/dashboard');
      }
      if($intv_id == NULL){
        redirect('admincontrol/dashboard');
      }
      if($_POST){
        $advno = $this->input->post("advno");
        $advcat_name = $this->input->post("advcat_name");
        $u_startdate = $this->input->post('u_startdate');
        $venueno = $this->input->post("venueno");
        $shift_name = $this->input->post("shift_name");
        $table_exactno = $this->input->post("table_exactno");

        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        $this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advcat_name', 'Candidate Category', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
        $this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
        
        if($this->form_validation->run() == TRUE) {
          $this->data['searchlist'] = array('venueno'=>$venueno, 'advcat_name'=>$advcat_name, 'shift_name'=>$shift_name, 'table_exactno'=>$table_exactno);

          if(date('Y-m-d',strtotime($u_startdate)) >= date('Y-m-d')){

            $p_item = $this->db->where('shift_id',$shift_name)->get('shift_master_tab')->row();
            $ss_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_start_time));
            $ee_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_end_time));
            $report_s_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ss_datetime)));
            $report_e_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ee_datetime)));

            $row_arr = array(
              'invw_venuemaster' => $shift_name,
              'invw_reporting_time' => $report_s_datetime,
              'invw_reporting_endtime' => $report_e_datetime,
              'invw_shift_starttime' => date('Y-m-d H:i:s'),
              'invw_shift_endtime' => date('Y-m-d H:i:s'),
              'invw_tableno' => $table_exactno,
              'invw_modifydate' => date('Y-m-d H:i:s'),
              'invw_modifyby' => $this->session->userdata['uid']
            );
            if ($this->candidates_m->addupdate_FinalInterview_categorywise_inDB($row_arr, $intv_id) == TRUE) {
              $this->session->set_flashdata("success","Candidate Table is Updated successfully");
              redirect('admincontrol/interview/interview_panelcandidate_tablewise_list','refresh');
            }else{
              $this->session->set_flashdata("e_error","There is some Problem to update Table. Please try again.");
              redirect('admincontrol/interview/interview_panelcandidate_tablewise_list','refresh');
            }

          }else{
            $this->data['error'] = 'Previous Date Not Allowed for Interview. Check Again.';
          }
        }
      }
      //$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      $this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->data['intv_detl'] = $intvdtl = $this->db->where('invw_id',$intv_id)->where('invw_reporting_endtime > ', date('Y-m-d H:i:s'))->get('interview_tab')->row();
      if(count((array)$intvdtl) == 0){
          $this->session->set_flashdata("e_error","Candidate Shift Reporting Time Over.");
          redirect('admincontrol/interview/interview_panelcandidate_tablewise_list','refresh');
      }
      $this->data['cand_detl'] = $this->db->where('f_application_no',$intvdtl->invw_cand_regno)->get('f_user_views')->row();
      $this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($intvdtl->invw_cand_regno);
		  $this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
      $this->data['sft_detl'] = $this->db->where('shift_id',$intvdtl->invw_venuemaster)->get('shift_master_tab')->row();
      $this->data['shifttab_details'] = $this->candidates_m->getDetails_forAllTable_shiftwise_check($appdetail->f_applied_for, $appdetail->fu_category, $intvdtl->invw_venuemaster);
      //print_r($this->data['shifttab_details']);exit;
      $this->load->view('admin/interview/modify_table_candidate_wise', $this->data);
    }

    public function holdsss_interview_panelcandidate_table_modify($intv_id = NULL){
      if($this->session->userdata['utype'] > 1){
        redirect('admincontrol/dashboard');
      }
      if($intv_id == NULL){
        redirect('admincontrol/dashboard');
      }
      if($_POST){
        $table_exactno = $this->input->post("table_exactno");
        $this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
        
        if($this->form_validation->run() == TRUE) {
          $row_arr = array(
            'invw_tableno' => $table_exactno,
            'invw_modifydate' => date('Y-m-d H:i:s'),
            'invw_modifyby' => $this->session->userdata['uid']
          );
          if ($this->candidates_m->addupdate_FinalInterview_categorywise_inDB($row_arr, $intv_id) == TRUE) {
            $this->session->set_flashdata("success","Candidate Table is Updated successfully");
		        redirect('admincontrol/interview/interview_panelcandidate_tablewise_list','refresh');
          }else{
            $this->session->set_flashdata("e_error","There is some Problem to update Table. Please try again.");
            redirect('admincontrol/interview/interview_panelcandidate_tablewise_list','refresh');
          }
        }
      }
      //$this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      //$this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->data['intv_detl'] = $intvdtl = $this->db->where('invw_id',$intv_id)->where('invw_reporting_endtime > ', date('Y-m-d H:i:s'))->get('interview_tab')->row();
      $this->data['cand_detl'] = $this->db->where('f_application_no',$intvdtl->invw_cand_regno)->get('f_user_views')->row();
      $this->data['appli_details'] = $appdetail = $this->candidates_m->GetDetailsofCandidate_Application($intvdtl->invw_cand_regno);
		  $this->data['discip_details'] = $this->candidates_m->GetDetail_Discipline_for_Application($appdetail->fu_category);
      $this->data['sft_detl'] = $this->db->where('shift_id',$intvdtl->invw_venuemaster)->get('shift_master_tab')->row();
      $this->data['shifttab_details'] = $this->candidates_m->getDetails_forAllTable_shiftwise_check($appdetail->f_applied_for, $appdetail->fu_category, $intvdtl->invw_venuemaster);
      //print_r($this->data['shifttab_details']);exit;
      $this->load->view('admin/interview/modify_table_candidate_wise', $this->data);
    }

    public function get_alltableno_fromadv_section(){
      if($_POST){
        $rf_set = $this->input->post("rf_set");
        $advno = $this->input->post("advno");
        /*$u_startdate = $this->input->post('u_startdate');
        $u_endtime = $this->input->post('u_endtime');
        $u_starttime = $this->input->post('u_starttime');
        $venueno = $this->input->post('venueno');*/

        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        /*$this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
			  $this->form_validation->set_rules('u_endtime', 'Shift End Time', 'trim|required');
			  $this->form_validation->set_rules('u_starttime', 'Shift Start Time', 'trim|required');
			  $this->form_validation->set_rules('venueno', 'Address', 'trim|required|is_natural_no_zero');*/

        if($this->form_validation->run()){
          //$this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'u_startdate'=>$u_startdate, 'u_endtime'=>$u_endtime, 'u_starttime'=>$u_starttime, 'venueno'=>$venueno);
				  //$this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
          
          //$ss_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_starttime));
					//$ee_datetime = date('Y-m-d H:i:s', strtotime($u_startdate . ' ' . $u_endtime));
          $cat_details = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
          $cat_details_sets = '';
         
          foreach($cat_details as $catg){
            $cat_details_sets = $cat_details_sets . '<option value="'.$catg->acat_id.'">' .$catg->catm_name. '</option>';
          }
          echo json_encode(array('msg' => 1, 'category_set' => $cat_details_sets));
          
        
        }else{
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      }else{
        redirect('default404');
      }

    }

    public function get_venue_details(){
      if($_POST){
        $venueno = $this->input->post("venueno");
        $this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
        if($this->form_validation->run()){
          
          $result_details = $this->db->where('address_status',1)->where('address_id',$venueno)->get('address_tab')->row();
          if(count((array)$result_details) > 0){
            echo json_encode(array('msg' => 1, 'op_set' => $result_details->address_tableno));
          }else{
            echo json_encode(array('msg' => 0, 'e_msg' => 'Venue Not Found'));
          }
          
        }else{
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      }else{
        redirect('default404');
      }
    }

    public function get_venue_details_v2(){
      if($_POST){
        $venueno = $this->input->post("venueno");
        $u_startdate = $this->input->post('u_startdate');

        $this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
        
        if($this->form_validation->run()){
          
          $result_details = $this->candidates_m->getAll_FindShift_Interview_list($venueno, $u_startdate);
          if(count((array)$result_details) > 0){
            $returnstring = '';
            foreach($result_details as $res_item){
              $returnstring = $returnstring.'<option value="'.$res_item->shift_id.'">'.$res_item->shift_name.' ('.date('h:i A',strtotime($res_item->shift_start_time)).' To '.date('h:i A',strtotime($res_item->shift_end_time)).')</option>';
            }
            echo json_encode(array('msg' => 1, 'op_set' => $returnstring));
          }else{
            echo json_encode(array('msg' => 0, 'e_msg' => 'Shift Not Found against Date and Venue'));
          }
          
        }else{
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      }else{
        redirect('default404');
      }
    }

    public function new_category_submission_adv_v2(){
      if ($_POST) {
        $advno = $this->input->post("advno");
        $adv_temp_intvno = $this->input->post("adv_temp_intvno");
        $venueno = $this->input->post("venueno");
        $shift_name = $this->input->post("shift_name");
        $advcat_name = $this->input->post("advcat_name");
        $advcat_table = $this->input->post("advcat_table");
        $table_stn = $this->input->post("table_stn");
  
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        $this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advcat_table', 'Table No.', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('table_stn', 'Table Strength', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('adv_temp_intvno', 'AUTOGEN ID', 'trim|required');

        if ($this->form_validation->run()) {
  
          if ($this->candidates_m->check_Existing_CategoryAdv_asperAUTOGEN_inDB($advno, $advcat_name, $adv_temp_intvno) == TRUE) {

            $shiftdetails = $this->candidates_m->getDetails_with_shift_Interview_segrigation_check($shift_name, $adv_temp_intvno);
            $error_counter = 0;
            $error_string = '';
            if(count((array)$shiftdetails) > 0){
              $total_used_tab = 0;
              $total_shift_table = 0;

              foreach($shiftdetails as $shifitems){
                $total_shift_table = $shifitems->shift_table_no;
                $total_used_tab = $total_used_tab + $shifitems->idm_cat_tableno;
              }
              $starttab_counter = $total_used_tab + 1;
              if(($total_used_tab + $advcat_table) > $total_shift_table){
                $error_counter++;
                $error_string = "Shift Table Exceeded, Please check once.";
              }
              //print_r(($total_used_tab + $advcat_table));exit;
            }else{
              $starttab_counter = 1;
              $single_shiftdetl = $this->db->get_where('shift_master_tab',array('shift_id'=>$shift_name))->row();
              if($advcat_table > $single_shiftdetl->shift_table_no){
                $error_counter++;
                $error_string = "Shift Table Exceeded, Please check once.";
              }
            }
            
            if($error_counter == 0){
            
              $row_arr = array(
                'idm_adv_no' => $advno,
                'idm_autogen_code' => $adv_temp_intvno,
                'idm_adv_category' => $advcat_name,
                'idm_cat_tableno' => $advcat_table,
                'idm_shift_no' => $shift_name,
                'idm_shift_tab_each' => $table_stn,
                'idm_tab_start_count' => $starttab_counter,
                'idm_createdate' => date('Y-m-d H:i:s'),
                'idm_createby' => $this->session->userdata('uid')
              );

              $resultset = $this->candidates_m->addupdate_tempInterview_category_inDB($row_arr);
              if ($resultset != FALSE) {
                  $resultbunch = $this->candidates_m->getDetails_ADV_Category_with_shift_venueforInterview($resultset);
                  echo json_encode(array('msg' => 1, 'cat_set' => $resultbunch));
              } else {
                echo json_encode(array('msg' => 0, 'e_msg' => 'DB insertion Problem, check again.'));
              }

            }else{
              echo json_encode(array('msg' => 0, 'e_msg' => $error_string));
            }

          } else {
            echo json_encode(array('msg' => 0, 'e_msg' => 'Category already inserted, check again.'));
          }
        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }

    public function new_interviewsets_submission_v2()
    {
      if ($_POST) {

        //$exam_gen = $this->input->post("exam_gen");
        $advno = $this->input->post("advno");
        $has_cand_main = $this->input->post("has_cand_main");
        $intcand_sec = $this->input->post("intcand_sec");
        $cand_selection_no = $this->input->post("cand_selection_no");
        $rf_set = $this->input->post("rf_set");
        $adv_temp_intvno = $this->input->post("adv_temp_intvno");
        $u_startdate = $this->input->post('u_startdate');
        $catg_counter = $this->input->post('catg_counter');
        
        $this->form_validation->set_rules('advno', 'Advertisement ID', 'trim|required');
        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('catg_counter', 'Advertisement Posts', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('has_cand_main', 'Candidate', 'trim|required');
        $this->form_validation->set_rules('intcand_sec', 'Interview Candidate', 'trim|required');

        $this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
        $this->form_validation->set_rules('adv_temp_intvno', 'Autogen ID', 'trim|required');

        if($intcand_sec == "MM" || $intcand_sec == "MV"){
          $this->form_validation->set_rules('cand_selection_no', 'Number', 'trim|required');
        }
        if ($this->form_validation->run()) {

                ////////////////
                $get_posts = $this->candidates_m->getAllResult_ofIndividual_POSTS_shift_ofADV($advno, $adv_temp_intvno);
                //print_r($get_posts);exit;

                if(count((array)$get_posts) > 0){
                  $parray_set = array();
                  $tabarray_set = array();
                  $totaltab = 0;
                  $errorcounter = 0;
                  $errorstring = '';
                  foreach($get_posts as $keys=>$p_item){
                    //$tab_start = 1;
                    $parray_set[] = array(
                      'postid'=>$p_item->idm_adv_category,
                      'tabno'=>$p_item->idm_cat_tableno
                    );
                    /*if($totaltab != 0){
                      $tab_start = $tab_start + $totaltab;
                    }*/
                    $totaltab = $p_item->idm_tab_start_count + $p_item->idm_cat_tableno;
                    for($i=$p_item->idm_tab_start_count;$i<$totaltab;$i++){
                      $tabarray_set[$p_item->idm_adv_category][] = $i;
                    }
                    if($intcand_sec == "MV"){
                      $cand_selection_no = (int)$cand_selection_no * (int)$p_item->acat_total;
                    }elseif($intcand_sec == "MM"){
                      $cand_selection_no = (float)$cand_selection_no;
                    }
                    $taotal_cand_strenth_per_category = (int)$p_item->idm_cat_tableno * (int)$p_item->idm_shift_tab_each;
                    $get_cand_results = $this->candidates_m->getAll_interview_Segrigation_search_candidate($taotal_cand_strenth_per_category, $advno, $p_item->idm_adv_category, $has_cand_main, $intcand_sec, $cand_selection_no);

                    $ss_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_start_time));
                    $ee_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_end_time));
                    $report_s_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ss_datetime)));
                    $report_e_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ee_datetime)));

                    $countertable = 0;
                    foreach($get_cand_results as $cand_items){
                      if($countertable >= $p_item->idm_cat_tableno){
                        $countertable = 0;
                      }
                      $row_arr = array(
                        'invw_cand_regno' => $cand_items->cr_application_master,
                        'invw_cand_marks' => $cand_items->t_marks,
                        'invw_venuemaster' => $p_item->idm_shift_no,
                        'invw_reporting_time' => $report_s_datetime,
                        'invw_reporting_endtime' => $report_e_datetime,
                        'invw_shift_starttime' => date('Y-m-d H:i:s'),
                        'invw_shift_endtime' => date('Y-m-d H:i:s'),
                        'invw_tableno' => $tabarray_set[$p_item->idm_adv_category][$countertable],
                        'invw_createdate' => date('Y-m-d H:i:s'),
                        'invw_createby' => $this->session->userdata['uid']
                      );
                      $countertable++;
                      if ($this->candidates_m->addupdate_FinalInterview_categorywise_inDB($row_arr) == FALSE) {
                        $errorcounter++;
                        $errorstring = $errorstring.$errorcounter.'. '.$cand_items->cr_application_master.' - Problem Arrived<br/>';
                      }
                    }

                  }
                  if ($errorcounter == 0) {
                    $row_arrsets = array(
                      'idm_status'=>2
                    );
                    $this->candidates_m->addupdate_tempInterview_category_inDB($row_arrsets,$adv_temp_intvno);
                    echo json_encode(array('msg' => 1));
                  } else {
                    echo json_encode(array('msg' => 0, 'e_msg' => $errorstring));
                  }
                }else{
                  echo json_encode(array('msg' => 0, 'e_msg' => 'Please select a Post for Interview, Try again.'));
                }
                

                /*$row_arr = array(
                  'invw_cand_regno' => $adv_no,
                  'invw_cand_marks' => $adv_name,
                  'invw_venuemaster' => $r_for,
                  'invw_reporting_time' => $ss_datetime,
                  'invw_shift_starttime' => $ss_datetime,
                  'invw_shift_endtime' => $ee_datetime,
                  'invw_tableno' => $scale_pay,
                  'invw_createdate' => date('Y-m-d H:i:s'),
                  'invw_createby' => $this->session->userdata['uid']
                );
                $row_arr2 = array(
                  'amark_adv_master' => $adv_no,
                  'amark_academic' => $academic_marks,
                  'amark_experience' => $experience_marks,
                  'amark_interview' => $interview_marks,
                  'amark_written' => $written_marks,
                  'amrk_createdate' => date('Y-m-d H:i:s')
                );

                if ($this->admin_m->ASASDASDASDSD_addform_against_Advertisement_inDB($row_arr) == TRUE) {
                  echo json_encode(array('msg' => 1));
                } else {
                  echo json_encode(array('msg' => 0, 'e_msg' => 'There have some DB insertion Problem, Try again.'));
                }*/
                //////////////////////////
        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }

    public function candidate_tablewise_printdata_set($advno = NULL, $advcat_name = NULL, $shift_name = NULL, $table_exactno = NULL){
      if($advno == NULL || $advcat_name == NULL || $shift_name == NULL || $table_exactno == NULL){
        redirect('admincontrol/interview/interview_panelcandidate_tablewise_list');
      }
      $total_checkinglist = $this->candidates_m->getDetails_forInterviewPanel_Candidate_tablewise($advno, $advcat_name, $shift_name, $table_exactno);
      if(count($total_checkinglist) == 0){
        redirect('admincontrol/interview/interview_panelcandidate_tablewise_list');
      }

      $detail_advdetail = $this->candidates_m->GetDetail_CategorywiseAdvertisement_for_Application($advno, $advcat_name);
      $shift_detail = $this->candidates_m->getAllDetails_forShift($shift_name);
      $ss_datetime = date('Y-m-d H:i:s', strtotime($shift_detail->shift_date . ' ' . $shift_detail->shift_start_time));
      $sft_s_time = date('h:i A', strtotime($shift_detail->shift_start_time));
      $sft_e_time = date('h:i A', strtotime($shift_detail->shift_end_time));
      $report_s_datetime = date('h:i A', strtotime("-60 minutes", strtotime($ss_datetime)));
      //print_r($detail_advdetail);exit;
      error_reporting(0);
      $this->load->helper("tcpdf_helper");
      tcpdf();
      //$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $title = $advno;
      $obj_pdf->SetTitle('Interview');
      $obj_pdf->SetAuthor('WB-HRB');
      $obj_pdf->SetSubject('Interview CallLetter');

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
      $my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table style=\"width: 100%;font-size: 22px;\">
          <tr>
          <td style=\"width:10%;\">&nbsp;</td>
          <td align=\"center\" style=\"width:80%;\">
            <span style=\"font-size:22px;font-weight:bold;\">WEST BENGAL HEALTH RECRUITMENT BOARD</span><br/>
            <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span>
          </td>
          <td style=\"width:10%;\">&nbsp;</td>
          </tr>
          <tr>
            <td colspan=\"3\">
            <table border=\"1\" style=\"width: 100%;font-size: 16px;\">
            <tr>
            <td align=\"center\"><strong>POST NAME :</strong> ".$detail_advdetail->rm_name." | ".$detail_advdetail->adv_no."<br/>
            (<strong>Discipline :</strong> ".$detail_advdetail->catm_name.")<br/>
            <strong>VENUE :</strong> ".$shift_detail->address_name." | <strong>SHIFT :-</strong> ".$sft_s_time." To ".$sft_e_time."</td>
            </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td align=\"center\" colspan=\"3\" style=\"font-size: 16px;\">
            <br/><br/>
            <strong>INTERVIEW SCORE SHEET<br/></strong>
            </td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" border=\"0\" style=\"width: 100%;font-size: 16px;\">
            <tr>
              <td colspan=\"2\" style=\"font-size: 18px;\">
                <table border=\"1\" cellpadding=\"10\" style=\"width: 100%;font-size: 16px;\">";

                if($detail_advdetail->adv_dictation_set == "Yes"){
                  $my_html = $my_html . "<tr>
                    <td colspan=\"3\" style=\"width:45%;\" align=\"center\"><strong>DATE OF INTERVIEW : ".date('d-M-Y',strtotime($shift_detail->shift_date))."</strong></td>
                    <td colspan=\"2\" align=\"center\" style=\"width:40%;\"><strong>REPORTING TIME : ".$report_s_datetime."</strong></td>
                    <td align=\"center\" style=\"width:15%;\"><strong>TABLE NO : ".$table_exactno."</strong></td>
                  </tr>
                  <tr>
                    <td colspan=\"6\" align=\"center\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\" style=\"width:5%;\"><strong>SL NO.</strong></td>
                    <td align=\"center\" style=\"width:18%;\"><strong>REGN NO.</strong></td>
                    <td align=\"center\" style=\"width:22%;\"><strong>PARTICULARS OF THE CANDIDATE:</strong></td>
                    <td align=\"center\" style=\"width:25%;\"><strong>KNOWLEDGE OF (BENGALI/ NEPALI):<br/>(YES/NO)</strong></td>
                    <td align=\"center\" style=\"width:15%;\"><strong>APTITUDE COMMUNICATION SKILL (10):</strong></td>
                    <td align=\"center\" style=\"width:15%;\"><strong>DOMAIN KNOWLEDGE & INTELLIGENCE (05):</strong></td>
                  </tr>";
                }else{
                  $my_html = $my_html . "<tr>
                    <td colspan=\"2\" style=\"width:27%;\" align=\"center\"><strong>DATE OF INTERVIEW : ".date('d-M-Y',strtotime($shift_detail->shift_date))."</strong></td>
                    <td colspan=\"2\" align=\"center\" style=\"width:53%;\"><strong>REPORTING TIME : ".$report_s_datetime."</strong></td>
                    <td align=\"center\" style=\"width:20%;\"><strong>TABLE NO : ".$table_exactno."</strong></td>
                  </tr>
                  <tr>
                    <td colspan=\"5\" align=\"center\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\" style=\"width:7%;\"><strong>SL NO.</strong></td>
                    <td align=\"center\" style=\"width:20%;\"><strong>REGN NO.</strong></td>
                    <td align=\"center\" style=\"width:33%;\"><strong>PARTICULARS OF THE CANDIDATE:</strong></td>
                    <td align=\"center\" style=\"width:20%;\"><strong>APTITUDE COMMUNICATION SKILL (10):</strong></td>
                    <td align=\"center\" style=\"width:20%;\"><strong>DOMAIN KNOWLEDGE & INTELLIGENCE (05):</strong></td>
                  </tr>";
                }

                  foreach($total_checkinglist as $keys=>$qualiss){
                    $my_html = $my_html . "<tr>
                    <td>".($keys+1)."</td>
                    <td>".$qualiss->f_application_no."</td>
                    <td>".$qualiss->f_full_name."</td>";
                    if($detail_advdetail->adv_dictation_set == "Yes"){
                      $my_html = $my_html . "<td>&nbsp;</td>";
                    }
                    $my_html = $my_html . "<td>&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>";
                  }
                  $my_html = $my_html . "</table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><br/><br/>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" style=\"width: 100%;font-size: 16px;\">
            <tr>
              <td style=\"width:2%;\">&nbsp;</td>
              <td style=\"width:45%;border-top:2px #000 solid\">Signature of the Member<br/>Name(Block Letter) :<br/>Date :
              </td>
              <td style=\"width:6%;\">&nbsp;</td>
              <td style=\"width:45%;border-top:2px #000 solid\">Signature of the Domain Expert<br/>Name(Block Letter) :<br/>Date :
              </td>
              <td style=\"width:2%;\">&nbsp;</td>
            </tr>
          </table>
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

    }

    public function interview_attendance_shiftwise_list(){
      if($this->session->userdata['utype'] > 1){
        redirect('admincontrol/dashboard');
      }
      if($_POST){
        //print_r($_POST);exit;
        $advno = $this->input->post("advno");
        $rf_set = $this->input->post("rf_set");
        //$advcat_name = $this->input->post("advcat_name");
        $u_startdate = $this->input->post('u_startdate');
        $venueno = $this->input->post("venueno");
        $shift_name = $this->input->post("shift_name");
        //$table_exactno = $this->input->post("table_exactno");
        
        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        $this->form_validation->set_rules('venueno', 'Venue', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
        //$this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('u_startdate', 'Interview Date', 'trim|required');
        //$this->form_validation->set_rules('table_exactno', 'Table no.', 'trim|required|is_natural_no_zero');
        
        if($this->form_validation->run() == TRUE) {
          $this->data['searchlist'] = array('rf_setid'=>$rf_set, 'advno'=>$advno, 'venueno'=>$venueno, 'shift_name'=>$shift_name);
				  $this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
          //$this->data['cat_details'] = $this->admin_m->getAll_Cat_detaillist_of_Avvertisement($advno);
          $this->data['shift_details'] = $this->candidates_m->getAll_FindShift_Interview_list($venueno, $u_startdate);
          //$this->data['shifttab_details'] = $this->candidates_m->getDetails_forAllTable_shiftwise_check($advno, $advcat_name, $shift_name);
          $this->data['total_checkinglist'] = $this->candidates_m->getDetails_forInterviewPanel_Candidate_shiftwise_forADV($advno, $shift_name);
          if(count($this->data['total_checkinglist']) == 0){
            $this->data['error'] = "No Candidate Found as per Searching. Check Again.";
          }
        }
        
      }
      $this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      $this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->load->view('admin/interview/shift_wise_list', $this->data);
    }

    public function candidate_attendancce_shiftwise_printdata_set($advno = NULL,$shift_name = NULL){
      if($advno == NULL || $shift_name == NULL){
        redirect('admincontrol/interview/interview_attendance_shiftwise_list');
      }
      $total_checkinglist = $this->candidates_m->getDetails_forInterviewPanel_Candidate_shiftwise_forADV($advno, $shift_name);
      if(count($total_checkinglist) == 0){
        redirect('admincontrol/interview/interview_attendance_shiftwise_list');
      }

      $detail_advdetail = $this->admin_m->getAlllist_ofActive_Advertisement($advno);
      $shift_detail = $this->candidates_m->getAllDetails_forShift($shift_name);
      //$ss_datetime = date('Y-m-d H:i:s', strtotime($shift_detail->shift_date . ' ' . $shift_detail->shift_start_time));
      $sft_s_time = date('h:i A', strtotime($shift_detail->shift_start_time));
      $sft_e_time = date('h:i A', strtotime($shift_detail->shift_end_time));
      //$report_s_datetime = date('h:i A', strtotime("-60 minutes", strtotime($ss_datetime)));
      //print_r($detail_advdetail);exit;
      error_reporting(0);
      $this->load->helper("tcpdf_helper");
      tcpdf();
      //$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $title = $advno;
      $obj_pdf->SetTitle('Interview');
      $obj_pdf->SetAuthor('WB-HRB');
      $obj_pdf->SetSubject('Interview Attendance');

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
      $my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table style=\"width: 100%;font-size: 22px;\">
          <tr>
          <td style=\"width:10%;\">&nbsp;</td>
          <td align=\"center\" style=\"width:80%;\">
            <span style=\"font-size:22px;font-weight:bold;\">WEST BENGAL HEALTH RECRUITMENT BOARD</span><br/>
            <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span>
          </td>
          <td style=\"width:10%;\">&nbsp;</td>
          </tr>
          <tr>
            <td colspan=\"3\">
            <table border=\"1\" style=\"width: 100%;font-size: 16px;\">
            <tr>
            <td align=\"center\"><strong>POST NAME :</strong> ".$detail_advdetail->rm_name." | ".$detail_advdetail->adv_no."<br/>
            <strong>VENUE :</strong> ".$shift_detail->address_name."</td>
            </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td align=\"center\" colspan=\"3\" style=\"font-size: 20px;\">
            <br/><br/>
            <strong>ATTENDANCE SHEET<br/></strong>
            </td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" border=\"0\" style=\"width: 100%;font-size: 16px;\">
            <tr>
              <td colspan=\"2\" style=\"font-size: 18px;\">
                <table border=\"1\" cellpadding=\"15\" style=\"width: 100%;font-size: 16px;\">
                  <tr>
                    <td colspan=\"3\" style=\"width:60%;\" align=\"center\"><strong>DATE OF INTERVIEW : ".date('d-M-Y',strtotime($shift_detail->shift_date))."</strong></td>
                    <td align=\"center\" style=\"width:40%;\"><strong>SHIFT TIME : ".$sft_s_time." To ".$sft_e_time."</strong></td>
                  </tr>
                  <tr>
                    <td colspan=\"4\" align=\"center\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\" style=\"width:8%;\"><strong>SL NO.</strong></td>
                    <td align=\"center\" style=\"width:20%;\"><strong>REGN NO.</strong></td>
                    <td align=\"center\" style=\"width:32%;\"><strong>NAME OF THE CANDIDATE:</strong></td>
                    <td align=\"center\" style=\"width:40%;\"><strong>SIGNATURE OF THE CANDIDATE:</strong></td>
                  </tr>";
                  foreach($total_checkinglist as $keys=>$qualiss){
                    $my_html = $my_html . "<tr>
                    <td align=\"center\">".($keys+1)."</td>
                    <td>".$qualiss->f_application_no."</td>
                    <td>".$qualiss->f_full_name."</td>
                    <td>&nbsp;</td>
                    </tr>";
                  }
                  $my_html = $my_html . "</table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><br/><br/>&nbsp;</td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" style=\"width: 100%;font-size: 16px;\">
            <tr>
              <td style=\"width:2%;\">&nbsp;</td>
              <td style=\"width:45%;\">&nbsp;</td>
              <td style=\"width:6%;\">&nbsp;</td>
              <td style=\"width:45%;border-top:2px #000 solid\">Signature of the Employee<br/>Name(Block Letter) :<br/>Date :
              </td>
              <td style=\"width:2%;\">&nbsp;</td>
            </tr>
          </table>
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

    }

    public function candidate_shiftwise_printdataset($advno = NULL,$shift_name = NULL){
      if($advno == NULL || $shift_name == NULL){
        redirect('admincontrol/interview/interview_attendance_shiftwise_list');
      }
      $total_checkinglist = $this->candidates_m->getDetails_forInterviewPanel_Candidate_shiftwise_forADV($advno, $shift_name);
      if(count($total_checkinglist) == 0){
        redirect('admincontrol/interview/interview_attendance_shiftwise_list');
      }

      $detail_advdetail = $this->admin_m->getAlllist_ofActive_Advertisement($advno);
      $shift_detail = $this->candidates_m->getAllDetails_forShift($shift_name);
      //$ss_datetime = date('Y-m-d H:i:s', strtotime($shift_detail->shift_date . ' ' . $shift_detail->shift_start_time));
      $sft_s_time = date('h:i A', strtotime($shift_detail->shift_start_time));
      $sft_e_time = date('h:i A', strtotime($shift_detail->shift_end_time));
      //$report_s_datetime = date('h:i A', strtotime("-60 minutes", strtotime($ss_datetime)));
      //print_r($detail_advdetail);exit;
      error_reporting(0);
      $this->load->helper("tcpdf_helper");
      tcpdf();
      //$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $title = $advno;
      $obj_pdf->SetTitle('Interview');
      $obj_pdf->SetAuthor('WB-HRB');
      $obj_pdf->SetSubject('Interview Attendance');

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
      $my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table style=\"width: 100%;font-size: 22px;\">
          <tr>
          <td style=\"width:10%;\">&nbsp;</td>
          <td align=\"center\" style=\"width:80%;\">
            <span style=\"font-size:22px;font-weight:bold;\">WEST BENGAL HEALTH RECRUITMENT BOARD</span><br/>
            <span align=\"center\" style=\"font-size:16px;font-weight:normal;\">BENFISH TOWER, (1st, 2nd & 3rd Floor), GN-31, Sector-V, Salt Lake, Kolkata - 700091</span>
          </td>
          <td style=\"width:10%;\">&nbsp;</td>
          </tr>
          <tr>
            <td colspan=\"3\">
            <table border=\"1\" style=\"width: 100%;font-size: 16px;\">
            <tr>
            <td align=\"center\"><strong>POST NAME :</strong> ".$detail_advdetail->rm_name." | ".$detail_advdetail->adv_no."<br/>
            <strong>VENUE :</strong> ".$shift_detail->address_name."</td>
            </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td align=\"center\" colspan=\"3\" style=\"font-size: 20px;\">
            <br/><br/>
            <strong>CANDIDATE LIST<br/></strong>
            </td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" border=\"0\" style=\"width: 100%;font-size: 16px;\">
            <tr>
              <td colspan=\"2\" style=\"font-size: 18px;\">
                <table border=\"1\" cellpadding=\"5\" style=\"width: 100%;font-size: 16px;\">
                  <tr>
                    <td colspan=\"2\" style=\"width:50%;\" align=\"center\"><strong>DATE OF INTERVIEW : ".date('d-M-Y',strtotime($shift_detail->shift_date))."</strong></td>
                    <td align=\"center\" style=\"width:50%;\"><strong>SHIFT TIME : ".$sft_s_time." To ".$sft_e_time."</strong></td>
                  </tr>
                  <tr>
                    <td colspan=\"3\" align=\"center\">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align=\"center\" style=\"width:10%;\"><strong>SL NO.</strong></td>
                    <td align=\"center\" style=\"width:40%;\"><strong>REGN NO.</strong></td>
                    <td align=\"center\" style=\"width:50%;\"><strong>NAME OF THE CANDIDATE:</strong></td>
                  </tr>";
                  foreach($total_checkinglist as $keys=>$qualiss){
                    $my_html = $my_html . "<tr>
                    <td align=\"center\">".($keys+1)."</td>
                    <td>".$qualiss->f_application_no."</td>
                    <td>".$qualiss->f_full_name."</td>
                    </tr>";
                  }
                  $my_html = $my_html . "</table>
              </td>
            </tr>
          </table>
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

    }

    public function get_allexact_tabledetails(){
      if ($_POST) {
        $advno = $this->input->post("advno");
        $shift_name = $this->input->post("shift_name");
        $advcat_name = $this->input->post("advcat_name");
  
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        $this->form_validation->set_rules('shift_name', 'Shift', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advcat_name', 'Adv. Category', 'trim|required|is_natural_no_zero');
        
        if ($this->form_validation->run()) {
  
          $shifttab_details = $this->candidates_m->getDetails_forAllTable_shiftwise_check($advno, $advcat_name, $shift_name);
            
          $cat_details_sets = '';
         
          foreach($shifttab_details as $catg){
            $cat_details_sets = $cat_details_sets . '<option value="'.$catg->utable_name.'">' .$catg->utable_name. ' No. Table</option>';
          }
          echo json_encode(array('msg' => 1, 'untab_set' => $cat_details_sets));
          
        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }

    function dsfsdfffffff_upload_pic(){

      // echo "<pre>";
      // print_r($this->data);

      $this->load->view('admin/application_interview',$this->data);


    }

    function uploadwebcam_shot(){

      

      if(!isset($_POST) || empty($_POST)){

        redirect('default404');
        exit;
      }
      
      $img = $_POST['base64image'];
      $application_id = $_POST['application_id'];
      
      if($application_id == ''){
        echo json_encode(array('msg'=>0,'e_msg'=>'Application ID not found'));
        return;
        exit;
      }
      if($img == ''){
        echo json_encode(array('msg'=>0,'e_msg'=>'picture not found'));
        return;
        exit;
      }
      $this->load->model('member_m');
      $adv = $this->member_m->get_candidate_applied_for($application_id);
      // SET UPLOAD PATH
      // ---------------
      define('UPLOAD_DIR', 'upload_file/'.$adv->f_applied_for.'/candidates/'.$application_id.'/');
      // ---------------
      
      /* File Uploads */
      //$new_attach_name = date("YmdHis").'-'.$this->generateRandomString().'.jpg';
      //$this->base64_to_jpeg($d_pic_64, $out_pic);
      //file_put_contents('upload_file/ticket_pic/'.$new_attach_name, base64_decode($griv_pic));
      /* File Uploads */
      
      //$img = str_replace('data:image/jpeg;base64,', '', $img);
      //$img = str_replace(' ', '+', $img);
      $dataarr = explode(',', trim($img));
      $dataimg = base64_decode($dataarr[1]);
      //echo $dataimg;exit;
      $fileName = 'WEBCAM-'.date("YmdHis") . '.jpg';
      $filepathset = UPLOAD_DIR.$fileName;
      $success = file_put_contents($filepathset, $dataimg);
      //print_r($success);
      //exit;
      
      if($success){
        $curtimeset = date('Y-m-d H:i:s');
        // Add fileName to the Table
        // ------------------------------
        $sql = "UPDATE candidate_result_tab SET cr_interview_pic = '$fileName', cr_interview_pic_datetime = '$curtimeset' WHERE cr_application_master = '$application_id'";
        $query = $this->db->query($sql);
        // ------------------------------

        echo json_encode(array('msg'=>1,'e_msg'=>'Picture is Saved Successfully.'));
        return;
      }

      else{
        
        echo json_encode(array('msg'=>0,'e_msg'=>'Failed to save picture'));
        return;
      }
      exit;
    }
  
		function uploadwebcam_with_cancelapplication_shot(){

      if(!isset($_POST) || empty($_POST)){

        redirect('default404');
        exit;
      }
      
      $img = $_POST['base64image'];
      $application_id = $_POST['application_id'];
      
      if($application_id == ''){
        echo json_encode(array('msg'=>0,'e_msg'=>'Application ID not found'));
        return;
        exit;
      }
      if($img == ''){
        echo json_encode(array('msg'=>0,'e_msg'=>'picture not found'));
        return;
        exit;
      }
      $this->load->model('member_m');
      $adv = $this->member_m->get_candidate_applied_for($application_id);
      // SET UPLOAD PATH
      // ---------------
      define('UPLOAD_DIR2', 'upload_file/'.$adv->f_applied_for.'/candidates/'.$application_id.'/');
      // ---------------
      
      /* File Uploads */
      //$new_attach_name = date("YmdHis").'-'.$this->generateRandomString().'.jpg';
      //$this->base64_to_jpeg($d_pic_64, $out_pic);
      //file_put_contents('upload_file/ticket_pic/'.$new_attach_name, base64_decode($griv_pic));
      /* File Uploads */
      
      //$img = str_replace('data:image/jpeg;base64,', '', $img);
      //$img = str_replace(' ', '+', $img);
      $dataarr = explode(',', trim($img));
      $dataimg = base64_decode($dataarr[1]);
      //echo $dataimg;exit;
      $fileName = 'WEBCAM-'.date("YmdHis") . '.jpg';
      $filepathset = UPLOAD_DIR2.$fileName;
      $success = file_put_contents($filepathset, $dataimg);
      //print_r($success);
      //exit;
      
      if($success){
        //$curtimeset = date('Y-m-d H:i:s');
        // Add fileName to the Table
        // ------------------------------
				$check_arr = array(
					'cr_approval'=>'Rejected',
					'cr_reject_comments'=>'Image not Matched at the time of Interview',
					'fu_photo_check'=>'Rejected'
				);
        $check_arr2 = array(
					'chk2_approve'=>'Rejected',
					'chk2_comments'=>'Image not Matched at the time of Interview',
					'chkadm_approve'=>'Rejected',
					'chkadm_comments'=>'Image not Matched at the time of Interview - '.$filepathset,
					'chkadm_appro_date'=>date('Y-m-d H:i:s'),
					'chkadm_appro_by'=>$this->session->userdata('uid'),
					'chk_final_state'=>'Rejected'
				);
        //$sql = "UPDATE candidate_result_tab SET cr_interview_pic = '$fileName', cr_interview_pic_datetime = '$curtimeset' WHERE cr_application_master = '$application_id'";
        //$query = $this->db->query($sql);
        // ------------------------------
				if($this->member_m->update_rejectApplication_timeofInterview($check_arr, $check_arr2, $application_id) == TRUE){
          $this->db->delete('fuser_interview_attachments', array('fattach_application' => $application_id));
					echo json_encode(array('msg'=>1,'e_msg'=>'Application is Rejected Successfully.'));
        	return;
				}else{
					echo json_encode(array('msg'=>0,'e_msg'=>'There Have Some problem to Update DB, Try Again.'));
					return;
				}
      }else{ 
        echo json_encode(array('msg'=>0,'e_msg'=>'Failed to save picture'));
        return;
      }
      exit;
    }

    public function print_callletter_cand($mmmm_id){
      $this->load->model('main_m');
      $this->load->model('member_m');
      $userdetails = $this->db->get_where('f_user_views', array('f_application_no' => $mmmm_id))->row();
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
      $obj_pdf = new CANDPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $title = $userdetails->f_application_no;
      $obj_pdf->SetTitle('Interview');
      $obj_pdf->SetAuthor('WB-HRB');
      $obj_pdf->SetSubject('Interview CallLetter');
  
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
      $style = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => false,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255),
        'text' => false,
        'font' => 'helvetica',
        'fontsize' => 12,
        'stretchtext' => 10
      );
  
      $my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
      <html xmlns=\"http://www.w3.org/1999/xhtml\">
      <head>
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
      </head>
      <body>
      <div class=\"header\">";
      $obj_pdf->write1DBarcode($userdetails->f_application_no, 'C93', 250, 20, '', 35, 0.7, $style, 'Y').$obj_pdf->Ln();
      //$obj_pdf->write2DBarcode($userdetails->f_application_no, 'QRCODE,H', 15, 15, 25, 25, NULL, '');
      $my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
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
            <span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter</u></span>
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
      <tr>
        <td colspan=\"2\"><br/><br/>
        <table style=\"width: 100%;font-size: 20px;\" border=\"0\" cellpadding=\"5\">";
          if ($adv_detail->adv_qualification_no > 0) {
            $my_html = $my_html . "<tr>
              <td><strong>Essential Qualification</strong><br/>
              <table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
              <tr>
                <td width=\"25%\"><strong>Examination Name</strong></td>
                <td width=\"13%\"><strong>Board/ Council/ University/ Journal</strong></td>
                <td width=\"12%\"><strong>State Name</strong></td>
                <td width=\"10%\"><strong>Marks Obtained</strong></td>
                <td width=\"10%\"><strong>Full Marks</strong></td>
                <td width=\"11%\"><strong>Percentage(%) of Marks</strong></td>
                <td width=\"10%\"><strong>Additional Attempt</strong></td>
                <td width=\"9%\"><strong>No. of Attempt</strong></td>
              </tr>";
              foreach($quali_list as $qualiss){
                $my_html = $my_html . "<tr>
                <td>".$qualiss->qm_name."</td>
                <td>".$qualiss->fu_council_board."</td>
                <td>".$qualiss->state_name."</td>
                <td>".$qualiss->fu_marks_obtained."</td>
                <td>".$qualiss->fu_full_marks."</td>
                <td>".$qualiss->fu_percent_of_marks."</td>
                <td>".$qualiss->fu_is_attempt."</td>
                <td>".$qualiss->fu_attempt_no."</td>
                </tr>";
              }
              $my_html = $my_html . "</table></td>
              </tr>";
          }
        if(count((array)$desquali_list) > 0){
          $my_html = $my_html . "<tr>
            <td><strong>Desirable Qualification</strong><br/>
            <table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
            <tr>
              <td width=\"25%\"><strong>Examination Name</strong></td>
              <td width=\"13%\"><strong>Board/ Council/ University/ Journal</strong></td>
              <td width=\"12%\"><strong>State Name</strong></td>
              <td width=\"10%\"><strong>Marks Obtained</strong></td>
              <td width=\"10%\"><strong>Full Marks</strong></td>
              <td width=\"11%\"><strong>Percentage(%) of Marks</strong></td>
              <td width=\"10%\"><strong>Additional Attempt</strong></td>
              <td width=\"9%\"><strong>No. of Attempt</strong></td>
            </tr>";
            foreach($desquali_list as $qualiss){
              $my_html = $my_html . "<tr>
              <td>".$qualiss->qm_name."</td>
              <td>".$qualiss->fud_council_board."</td>
              <td>".$qualiss->state_name."</td>
              <td>".$qualiss->fud_marks_obtained."</td>
              <td>".$qualiss->fud_full_marks."</td>
              <td>".$qualiss->fud_percent_of_marks."</td>
              <td>".$qualiss->fud_is_attempt."</td>
              <td>".$qualiss->fud_attempt_no."</td>
              </tr>";
            }
            $my_html = $my_html . "</table></td>
            </tr>";
        }
        if ($adv_detail->adv_has_experience == "Yes") {
          $my_html = $my_html . "<tr>
          <td>
          <label><strong>Experience in concerned field :</strong></label>".$userdetails->fu_has_service."<br/>";
          if ($userdetails->fu_has_service == "Yes") {
            if(count((array)$essenexp_list) > 0){
              $my_html = $my_html . "<strong>Essential Experience</strong><br/>
              <table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
                <tr>
                <td width=\"45%\"><strong>Experience Category</strong></td>
                <td width=\"35%\"><strong>Organization</strong></td>
                <td width=\"20%\"><strong>Time Period</strong></td>
                </tr>";
                foreach($essenexp_list as $expss){
                  $my_html = $my_html . "<tr>
                  <td>".$expss->expset_name."</td>
                  <td>".$expss->fues_exp_org_name."</td>
                  <td>".$expss->fues_exp_year." Year & ".$expss->fues_exp_month." Month</td>
                  </tr>";
                }
              $my_html = $my_html . "</table><br/>";
            }
            if(count((array)$exp_list) > 0){
              $my_html = $my_html . "<strong>Desirable Experience</strong><br/>
              <table style=\"width:100%;\" border=\"1\" cellpadding=\"5\">
              <tr>
              <td width=\"45%\"><strong>Experience Category</strong></td>
              <td width=\"35%\"><strong>Organization</strong></td>
              <td width=\"20%\"><strong>Time Period</strong></td>
              </tr>";
              foreach($exp_list as $expss){
                $my_html = $my_html . "<tr>
                <td>".$expss->expset_name."</td>
                <td>".$expss->fu_exp_org_name."</td>
                <td>".$expss->fu_exp_year." Year & ".$expss->fu_exp_month." Month</td>
                </tr>";
              }
              $my_html = $my_html . "</table>";
            }
          }
          $my_html = $my_html . "</td>
          </tr>";
        } 
        $my_html = $my_html . "</table>
        </td>
      </tr>
      <tr>
        <td colspan=\"2\" style=\"width:100%;\">
          <table cellpadding=\"5\" border=\"0\" style=\"width: 100%;font-size: 20px;\">
            <tr>
              <td colspan=\"2\"><p align=\"justify\">Dear Candidate,<br/>
              With reference to the advertisement mentioned above for recruitment to the posts as mentioned above under Health & Family Welfare Department, Government of West Bengal, you are being called for interview on the venue, date, time and shift scheduled below. You are allowed to appear at the interview in West Bengal Health Recruitment Board.</p>
              </td>
            </tr>
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
                <br/><br/><br/>
                <strong style=\"padding:10px;\">";
                foreach($rules_list as $ruleitem){
                  $my_html = $my_html . "*" . $ruleitem->rm_details . "<br/>";
                }
                $my_html = $my_html . "</strong>
              </td>
            </tr>
            <tr>
              <td style=\"width:50%;\">&nbsp;</td>
              <td style=\"width:50%;font-size: 18px;\">
              <div align=\"center\" style=\"overflow:hidden;\">
              <b>Sd/-</b>
              <hr  style=\"width:63%;\" />
              <b>Secretary & Controller of Examinations<br/>
              West Bengal Health Recruitment Board</b>
              </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>";
      $content = $my_html; //ob_get_contents();
      //ob_end_clean();
      $obj_pdf->writeHTML($content, true, false, true, false, '');
      $obj_pdf->AddPage();
      
      $my_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
      <html xmlns=\"http://www.w3.org/1999/xhtml\">
      <head>
      <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
      </head>
      <body>
      <div class=\"header\">";
      $obj_pdf->write1DBarcode($userdetails->f_application_no, 'C93', 250, 30, '', 35, 0.7, $style, 'Y').$obj_pdf->Ln();
      $my_html = $my_html . "<table style=\"width: 100%;font-size: 20px;\">
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
            <span style=\"font-size:18px;font-weight:bold;\"><u>Interview Call Letter</u></span>
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
      <tr><td colspan=\"2\">&nbsp;</td></tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;font-size: 22px;\">
        <strong>SPACE FOR DICTATION WHERE APPLICABLE<br/>
        (ON THE SCHEDULED VENUE & DATE)</strong><br/>
        </td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><hr /></td>
      </tr>
      <tr>
        <td align=\"center\" colspan=\"2\" style=\"width:100%;\"><br/><br/><br/>&nbsp;</td>
      </tr>
      <tr>
        <td style=\"width:65%;\">
        Signature of the lnterviewer<br/><br/>
        Date :
        </td>
        <td align=\"left\" style=\"width:35%;\">
        Signature of the candidate after dictation<br/><br/>
        Date :
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
  
    }

    public function addmore_candidates_forexisting(){
      if($_POST){
        $advno = $this->input->post("advno");
        $rf_set = $this->input->post("rf_set");
        
        $this->form_validation->set_rules('rf_set', 'Recruitment For', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('advno', 'Advertisement No.', 'trim|required');
        
        if($this->form_validation->run() == TRUE) {
          $this->data['searchlist'] = array('advno' => $advno, 'rf_setid'=>$rf_set);
          $this->data['adv_catg'] = $this->db->order_by('adv_no','ASC')->where('adv_recruit_master',$rf_set)->where('adv_status',1)->get('advertisement_master')->result();
          
          
          
          
          $chksets = $this->candidates_m->getall_existing_Candidates_forShiftTable_advwise($advno);
          if(count((array)$chksets) > 0){
            $this->data['sectionlist'] = $chksets;
          }else{
            $this->data['sectionlist'] = array();
            $this->data['error'] = "No Record Found for your search Criteria.";
          }
        }
      }
      $this->data['rec_list'] = $this->db->order_by('rm_name','ASC')->where('rm_status',1)->get('recruitment_master_tab')->result();
      $this->data['vn_list'] = $this->db->order_by('address_name','ASC')->where('address_status',1)->get('address_tab')->result();
      $this->load->view('admin/interview/addmore_candidate_list', $this->data);
    }

    public function check_addmore_section_candidates($advno, $section_id){
      if($advno == "" || $advno == NULL || $section_id == "" || $section_id == NULL){
        redirect('admincontrol/interview/addmore_candidates_forexisting');
      }
      $this->data['section_details'] = $getdetails = $this->candidates_m->getall_existing_Candidates_forShiftTable_advwise($advno, $section_id);
      if(count((array)$getdetails) == 0){
        $this->session->set_flashdata("e_error","Existing Table Not Found Properly. Please try again.");
        redirect('admincontrol/interview/addmore_candidates_forexisting');
      }
      if(date('Y-m-d') >= $getdetails->shift_date){
        $this->session->set_flashdata("e_error","Shift Date is Over. Please Check again.");
        redirect('admincontrol/interview/addmore_candidates_forexisting');
      }

      $totalexistance = ($getdetails->idm_cat_tableno * $getdetails->idm_shift_tab_each);
      $this->data['cand_exist'] = $gettotal_candidate_existance = $this->candidates_m->getcurrent_existing_Candidates_shiftwise($getdetails->shift_id, $getdetails->idm_tab_start_count);
      if($gettotal_candidate_existance >= $totalexistance){
        $this->session->set_flashdata("e_error","Already Table is full with Candidate. Please Check again.");
        redirect('admincontrol/interview/addmore_candidates_forexisting');
      }
      
      $this->data['addcand_no'] = $item_cat_count = $this->candidates_m->checkCandidate_forInterview_sectionset($advno, $getdetails->idm_adv_category);
      if($item_cat_count == 0){
        $this->session->set_flashdata("e_error","Candidate Not Found for the Advertisement Category. Please Check again.");
        redirect('admincontrol/interview/addmore_candidates_forexisting');
      }
      //$this->data[''] = ggggg;
      //print_r($gettotal_candidate_existance);
      //exit;
      $this->load->view('admin/interview/addmore_candidate_section_view', $this->data);

    }

    public function addmore_interviewsets_submission()
    {
      if ($_POST) {

        //$exam_gen = $this->input->post("exam_gen");
        $advno = $this->input->post("advno");
        $section_id = $this->input->post("section_id");
        $table_candidate = $this->input->post('table_candidate');
        
        $this->form_validation->set_rules('advno', 'Advertisement ID', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Table ID', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('table_candidate', 'Interview Candidate', 'trim|required|is_natural_no_zero');

        if ($this->form_validation->run()) {

                ////////////////
                $get_posts = $this->candidates_m->getall_existing_Candidates_forShiftTable_advwise_v2($advno, $section_id);
                //print_r($get_posts);exit;

                if(count((array)$get_posts) > 0){
                  $parray_set = array();
                  $tabarray_set = array();
                  $totaltab = 0;
                  $errorcounter = 0;
                  $errorstring = '';
                  foreach($get_posts as $keys=>$p_item){
                    //$tab_start = 1;
                    $parray_set[] = array(
                      'postid'=>$p_item->idm_adv_category,
                      'tabno'=>$p_item->idm_cat_tableno
                    );
                    
                    $totaltab = $p_item->idm_tab_start_count + $p_item->idm_cat_tableno;
                    for($i=$p_item->idm_tab_start_count;$i<$totaltab;$i++){
                      $tabarray_set[$p_item->idm_adv_category][] = $i;
                    }
                    $intcand_sec = $has_cand_main = "ALL";
                    $cand_selection_no = "";
                    
                    $taotal_cand_strenth_per_category = (int)$p_item->idm_cat_tableno * (int)$p_item->idm_shift_tab_each;
                    $get_cand_results = $this->candidates_m->getAll_interview_Segrigation_search_candidate($taotal_cand_strenth_per_category, $advno, $p_item->idm_adv_category, $has_cand_main, $intcand_sec, $cand_selection_no);

                    $ss_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_start_time));
                    $ee_datetime = date('Y-m-d H:i:s', strtotime($p_item->shift_date . ' ' . $p_item->shift_end_time));
                    $report_s_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ss_datetime)));
                    $report_e_datetime = date('Y-m-d H:i:s', strtotime("-60 minutes", strtotime($ee_datetime)));

                    $countertable = 0;
                    foreach($get_cand_results as $cand_items){
                      if($countertable >= $p_item->idm_cat_tableno){
                        $countertable = 0;
                      }
                      $row_arr = array(
                        'invw_cand_regno' => $cand_items->cr_application_master,
                        'invw_cand_marks' => $cand_items->t_marks,
                        'invw_venuemaster' => $p_item->idm_shift_no,
                        'invw_reporting_time' => $report_s_datetime,
                        'invw_reporting_endtime' => $report_e_datetime,
                        'invw_shift_starttime' => date('Y-m-d H:i:s'),
                        'invw_shift_endtime' => date('Y-m-d H:i:s'),
                        'invw_tableno' => $tabarray_set[$p_item->idm_adv_category][$countertable],
                        'invw_createdate' => date('Y-m-d H:i:s'),
                        'invw_createby' => $this->session->userdata['uid']
                      );
                      $countertable++;
                      if ($this->candidates_m->addupdate_FinalInterview_categorywise_inDB($row_arr) == FALSE) {
                        $errorcounter++;
                        $errorstring = $errorstring.$errorcounter.'. '.$cand_items->cr_application_master.' - Problem Arrived<br/>';
                      }
                    }

                  }
                  if ($errorcounter == 0) {
                    echo json_encode(array('msg' => 1));
                  } else {
                    echo json_encode(array('msg' => 0, 'e_msg' => $errorstring));
                  }
                }else{
                  echo json_encode(array('msg' => 0, 'e_msg' => 'Advertisement Category not found, Check again.'));
                }

        } else {
          echo json_encode(array('msg' => 0, 'e_msg' => validation_errors()));
        }
        exit;
      } else {
        redirect('dafault404');
      }
    }



  }

?>
