<?php
class Member_Controller extends MY_Controller {

	public $sessmembersessionid = NULL;
	public $sessmemberaccessip = NULL;
	public $sessmemberid = NULL;
	public $sessmemberuname = NULL;
	function __construct() {
		parent::__construct();
		
		$this->load->model('member_m');
		//$this->load->model('cms_m');
		
		$exception_uris = array(
				'member/logout'
		);
		
		if (isset($this->session->userdata['member_id'])) {
			//$this->sessmembersessionid = $this->session->userdata('member_uniquedevice_ip');
			$this->sessmemberid = $this->session->userdata('member_id');
			$this->sessmemberuname = $this->session->userdata('member_uname');
			//$this->sessmemberaccessip = $this->session->userdata('member_loginip');
		}
		if (in_array(uri_string(), $exception_uris) == FALSE) {
			if ($this->member_m->member_loggedin() == FALSE) {
				
				//redirect('admin/user/login');
				//$this->member_m->logout();
				redirect('login');
			}			

		}

	}
	
	protected function sendSMS_via_thirdParty($mobile_no, $sms_content){
		
		$generate_otp_string = preg_replace("/ /", "%20", $sms_content);
		$URL = "https://sms.albatrossoft.com/api/api_http.php?username=adda&password=ADD@sms2021&senderid=ALADDA&to=".$mobile_no."&text=".$generate_otp_string."&route=Informative&type=text";
		$sms_feed_string = file_get_contents($URL);
		$sms_array = explode(" ",$sms_feed_string);
		//$sms_array[0] = "OK";
		if(!empty($sms_array)){
			$sms_feed_recv = $sms_array[0];
		}else{
			$sms_feed_recv = "NULL";
		}
		return $sms_feed_recv;
		
	}
	
    protected function sendSMTPEmail($toEmail, $subject, $template, $data = NULL){
        
        require_once 'PHPMailer/class.phpmailer.php';
		require_once 'PHPMailer/class.smtp.php';
		
		$mail = new PHPMailer;
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'sg2plcpnl0242.prod.sin2.secureserver.net';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication

		$mail->Username = 'noreply@coochbehargmch.org';                 // SMTP username
		$mail->Password = 's1b1VzY[%I]@';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		$mail->Priority = 1;                                    // TCP port to connect to
		
		$mail->From = 'wbhrb@nic.in';
		$mail->FromName = 'WB-HRB Admin';
		$mail->addAddress($toEmail, '');     // Add a recipient               // Name is optional
        if(!empty($data)){
           for($i=0;$i<count($data);$i++){
                $mail->addCC($data[$i]);
           }
        }
        //$mail->addBCC("amit@albatrossoft.com");
		$mail->addReplyTo('wbhrb@nic.in', 'WB-HRB Support');
		
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $subject;
		/*if($data == NULL){
			$mail->Body = $template;
		}else{
			$mail->Body = $this->load->view($template, $data, true);
        }*/
        $mail->Body = $template;
		 
		
		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			return FALSE;
		}
		else
		{	return TRUE;  }
		
        /*$config = array(
            'protocol' => 'smtp',
            'smtp_host' => "p3plcpnl0125.prod.phx3.secureserver.net",
            'smtp_port' => 465,
            'smtp_user' => "info@email.shopsnob.com",
            'smtp_pass' => "Albatross123",
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'priority' => 1
        );
        $this->email->initialize($config);
        $this->email->from("info@email.shopsnob.com", 'The Snob Shop');
        $this->email->to($toEmail);
        $this->email->subject($subject);
        $this->email->message($this->load->view($template, $data, true));
        if($this->email->send()){
            return true;
        }else{
            return false;
        }
        echo $this->email->print_debugger();*/
        
    }
    
	protected function sendALLSMTPEmail($toEmail, $subject, $template, $data = NULL){

        require_once('PHPMailer222/class.phpmailer.php');
		require_once('PHPMailer222/class.smtp.php');
		
		$mail = new PHPMailer();
		$mail->IsSMTP(); //Definimos que usaremos o protocolo SMTP para envio.
		$mail->SMTPDebug = 0;
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth = true; //Habilitamos a autenticaçăo do SMTP. (true ou false)
		$mail->SMTPSecure = "tls"; //Estabelecemos qual protocolo de segurança será usado.
		$mail->Host = "bulk.emaillive.in"; //Podemos usar o servidor do gMail para enviar.
		$mail->Port = 2525; //Estabelecemos a porta utilizada pelo servidor do gMail.
		$mail->Username = "admin@wbhrb.email"; //Usuário do gMail
		$mail->Password = "C9D7CB640B10EDF08571C24B20FB401933BE"; //Senha do gMail

		$mail->SetFrom('admin@wbhrb.email', 'WBHRB Support'); //Quem está enviando o e-mail.
		$mail->Subject =  $subject;
		$mail->IsHTML(true); 
		$mail->Body = $template;
		//$mail->AltBody = "Plain text.";
		$mail->AddAddress($toEmail);
		
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
        );

		if(!$mail->Send()) {
			// error occur - user your show method to show error
			//echo $mail->ErrorInfo;
			return false;
		} else {
			// success occur - user your show method to show success
			//echo "Mail Sent";
			return true;
		}

    }

	//Function to send otp sms
	protected function sendALLSMS($message,$mobileno,$msgtype,$tempid){
		$username = 'WBHRBSECRETARY';
		$password = 'S@7059457070';
		$senderid = 'HRBEXM';
		$templateid = $tempid; //'1207163455580746477';
		$deptSecureKey = '9c6e2544-d2ab-430d-9370-ebff7b2ddb4a';
		$encryp_password=sha1(trim($password));
		$key=hash('sha512',trim($username).trim($senderid).trim($message).trim($deptSecureKey));
		 
		$data = array(
			"username" => trim($username),
			"password" => trim($encryp_password),
			"senderid" => trim($senderid),
			"content" => trim($message),
			"smsservicetype" => $msgtype,
			"mobileno" =>trim($mobileno),
			"key" => trim($key),
			"templateid" => trim($templateid)
		);
		return $this->post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT",$data); //calling post_to_url to send otp sms
	 
		/*$url = 'https://msdgweb.mgov.gov.in/esms/sendsmsrequest';
		$options = array(
				'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			)
		);

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);*/
		//$this->post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data);
		//var_dump($result);exit;
		//post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequest",$data); //calling post_to_url to send otp sms
	}  

	protected function post_to_url($url, $data) {
		$fields = '';
		foreach($data as $key => $value) {
		$fields .= $key . '=' . urlencode($value) . '&';
		}
		rtrim($fields, '&');
		$post = curl_init();
		//curl_setopt($post, CURLOPT_SSLVERSION, 5); // uncomment for systems supporting TLSv1.1 only
		curl_setopt($post, CURLOPT_SSLVERSION, 6); // use for systems supporting TLSv1.2 or comment the line
		curl_setopt($post,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, count($data));
		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($post); //result from mobile seva server
		//echo $result; //output from server displayed
		curl_close($post);
		return $result;
	}

    

}