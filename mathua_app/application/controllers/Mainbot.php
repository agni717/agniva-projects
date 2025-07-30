<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainbot extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
    }
	
	public function index()
	{
		redirect('mainbot/home');
	}
	
	public function home(){
		
		$this->load->view('main/bot_view', $this->data);
	}
	
	public function get_all_chatdata(){
		if($_POST){
			$parentid = $this->input->post('u_chat_parent');
			if($parentid != ""){
				$get_chats = $this->db->get_where('chatbot_tab',array('cb_parent'=>$parentid))->result();
				if(count($get_chats) > 0){
					$send_string = '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"> <span class="direct-chat-name pull-right">Health Bot</span> <span class="direct-chat-timestamp pull-left">'.date('d M h:i a').'</span> </div> <img class="direct-chat-img" src="https://img.icons8.com/office/36/000000/person-female.png" alt="message user image"><div class="direct-chat-text">';
					foreach($get_chats as $chats){
						if($chats->cb_click == 1){
							$send_string = $send_string.'<button onclick="goto_check_botdata('.$chats->cb_id.', \''.$chats->cb_name.'\')" class="btn btn-danger">'.$chats->cb_name.'</button><br/>';
						}else{
							$send_string = $send_string.$chats->cb_name.'<br/>';
						}
						
					}
					if($parentid != 0){
						$send_string = $send_string.'<button onclick="goto_check_botdata(\'0\', \'Main Menu\')" class="btn btn-danger"><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span> Main Menu</button>';
					}	
					$send_string = $send_string.'</div></div>';
					echo json_encode(array('msg'=>1, 'e_string'=>$send_string));
				}else{
					echo json_encode(array('msg'=>0, 'e_error'=>'Data not Found'));
				}
			}
			exit;
		}
	}
	
	public function sendsms(){
		$gencode = 234234;
		$smstype = "otpmsg"; //"singlemsg"
		$msg = 'Thank you for login in WBHRB website. Your OTP is '.$gencode.'.';
		//$this->sendALLSMS($msg,'9830260404',$smstype);
		$smsreplyset = $this->sendALLSMS($msg,'9830260404',$smstype, '1207163455580746477');
		print_r($smsreplyset);
		$smsarray = explode(',', $smsreplyset);
		if($smsarray[0] == 402){
			echo "SMS Send";
		}else{
			print_r($smsarray);
		}
	}
	

}