<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments extends Frontend_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model('main_m');
    }
	
	public function index()
	{
		redirect('default404');
	}

	public function response_from_grips(){
		if($_POST){
			/*print_r($_REQUEST);
			echo "<br/><br/>GET----<br/>";
			print_r($_GET);
			echo "<br/><br/>POST----<br/>";
			print_r($_POST);
			echo "<br/><br/>";*/
			$key = '6314263687426345';
			$iv = 'jbsfkhuhjgsdgasd';
			$algo = 'aes-128-cbc';
			if(!empty($_POST['ENCDATA'])){
				$decryptstring_updates = $this->decrypt($_POST['ENCDATA'], $algo, $key, $iv);
				$decryptstring_updates = strstr($decryptstring_updates, '|', true);
				//echo htmlentities($decryptstring_updates);
				$xmlstring = simplexml_load_string($decryptstring_updates);
				$xmlarray = json_decode(json_encode((array) $xmlstring), true);
				if(count($xmlarray) > 0){
					if($xmlarray['BANKTRANSACTIONSTATUS'] == "Success"){
						$getcandidateid = $this->db->get_where('frontend_users', array('f_application_no'=>$xmlarray['DEPT_REF_NO']))->row();
						$row_arr = array(
							'fu_challan_no' => $xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $xmlarray['BANKTRANSACTIONID'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 1
						);
						if($this->main_m->updateSuccess_Payment_candidateSet($row_arr, $xmlarray['IDENTIFICATION_NO'], $getcandidateid->f_uid) == TRUE){
							$htmldataset = '<html><body><h1>Thank you for Apply in WBHRB Application portal.</h1>
							<br/>
							<p>Your Application Registration Number is - <strong>'.$getcandidateid->f_application_no.'</strong></p>
							<p>For Any Further Queries, Please use this number.</p>
							</body></html>';
							$this->sendALLSMTPEmail($getcandidateid->f_email,'WBHRB - Application Submission', $htmldataset);
							$this->session->set_flashdata("success","Payment Successfully completed and Application submitted Successfully, Thank you.");
							//redirect('member/finalcheck_up','refresh');
							redirect('payments/payment_checking_response','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Database Updation Error. Please Contact Technical Team.");
							redirect('payments/payment_checking_response','refresh');
						}

					}else{
						$row_arr = array(
							'fu_challan_no' => $xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $xmlarray['BANKTRANSACTIONMESSAGE'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 2
						);
						if($this->main_m->insertUpdate_Payment_candidateSet($row_arr, $xmlarray['IDENTIFICATION_NO']) == TRUE){
							$this->session->set_flashdata("e_error","Payment Unsuccessful. Please Login and Try Again.");
							redirect('payments/payment_checking_response','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Failure Updation Error. Please Contact Technical Team.");
							redirect('payments/payment_checking_response','refresh');
						}
					}
				}else{
					$this->session->set_flashdata("e_error","Payment Data not Received Properly, Check Again.");
					redirect('payments/payment_checking_response','refresh');
				}
				/*echo $xmlarray['IDENTIFICATION_NO'];
				echo $xmlarray['DEPT_REF_NO'];
				echo "<pre>";
				//print_r(htmlentities($decryptstring_updates));
				print_r($xmlarray);*/
			}else{
				$this->session->set_flashdata("e_error","Payment Post Data not Received Properly, Check Again.");
				redirect('payments/payment_checking_response','refresh');
			}
		}else{
			redirect('default404');
		}
	}

	public function payment_checking_response(){
		$this->load->view("main/member/payment_response_privew", $this->data);
	}
	
	/*public function testmail(){
		$profile_email = 'completesaha@gmail.com';
		$e_sub = "E-Pass - Permission Application";
		$e_msg = '<h2>Welcome to Portal for Permission to resume works in Bankura District<br/>(During Lockdown period of COVID-19)</h2>
		<p style="font-size:18px;">Dear AMIT,<br/>Your Permission is Approved Successfully.<br/>Your Application Number :- <strong>234352354356345</strong></p><br/><br/>
					<p style="font-size:18px;">Please check the Below Link for your Approval Document -<br/>
					http://test-dev.albatrossoft.com/epass/main/print_final_permission_sheet/010520201348201487</p>
					<br/><br/><br/>
					<p style="font-size:16px;">*For any queries please contact the District Admin.</p>';

		$this->sendSMTPEmail($profile_email, $e_sub, $e_msg);
	}*/

	public function verify2342342342342342_payment_submission(){
		
		/*$paidamount = 1.00;
		$key = '1234567890123456';
		$iv = 'abcdefghijklmnop';
		$algo = 'aes-128-cbc';
		$identifiaction_No = date('dmYhis').$this->generateRandomString(6);
		//$ENCDATA = encrypt("I Love My India!", $algo, $key, $iv);
		//$chksum_value = 'asdasdasd2342342sdfsdfsdf';
		$responseurl = base_url().'payments/response_from_grips';
		$xmlstring_set = '<GRIPS_DEPT_DV_REQ>
		<DEPT_CD>033</DEPT_CD>
		<SERVICE_CD>303</SERVICE_CD>
		<DEPT_REF_NO>C180820210528383175</DEPT_REF_NO>
		<IDENTIFICATION_NO>05112021102146766093</IDENTIFICATION_NO>
		<FIN_YEAR>2021</FIN_YEAR>
		</GRIPS_DEPT_DV_REQ>'; //|CHECKSUM='.$chksum_value;
		$chksumvalue_set = $this->hash256($xmlstring_set);
		$udated_with_chksum = $xmlstring_set.'|CHECKSUM='.$chksumvalue_set;
		$ENCDATA = $this->encrypt($udated_with_chksum, $algo, $key, $iv);
		$this->data['senddata'] = $ENCDATA;
		$this->data['senddpt'] = '033';*/
		
		//echo htmlentities($xmlstring_set)."<br/><br/>";
		//echo $chksumvalue_set."<br/><br/>";
		//echo $ENCDATA;
		/*$decryptstring = 'oQsWrr3LpxpxxuRGXktj9fAR6s+jvSwYW5wSQZ9bJ/tP/rNtcb01R7mLLxHzrFW2rk+XFfH4m7LO
		oAhUeVbET731PoocwcHt9fZguGtsYY4dp4nk5Qt8G8iWZX/Q7IC9aDINjdDTP3WDU6x1P8CqpVJ7
		CQhJkqkBkP/Gz+mwRFlCsTHNEr5R/Txy8zQL+bhWCy+JuS38rKtNqf6LrYfP9PpN5MpYuo++tws9
		RW5NSJDDTItFPyiYYxWyXWdN28NWGVLn3WDhXTWfcTzCtXia/DgN8QuhHFT77pu1COAlA++Gd/UA
		rQNGmGynK4j6yMsPh8ObRTZioaghLdyky0r9yaOju4tGYdqy676W/TGqb6CSfUZwneiLFoJ3jgeH
		dIZDLURGJBoHod6+Vlsiz1JUgULbRzs5euiQ2JIcv3Rxn18888wtpsA06hfLQnDqSsQNY4Ta42fE
		gVlMW37McqE+BM466mFBhFJk7uRZ9cy2klSxfgeI+ql4v4tRHzt7WNdLR2nCg4IorKU0AteNL8tS
		uHuNyvPc8nEO7SpWl5efk4BTxScrzmdqa5X5z5caV0KHlRVCB8XgPDo9RRd+Zg7qfHtFvYxYCeei
		nb+J6BsFTpZ8zMPrGHmMCtE+WQvID7v8Lqiv/oMppr7MwC/L9ajuq+RZ/ChYDJT1dqP47wGXNhjA
		GOU+nSIkFLhXkPMZ+ayqQ3Wps8fY+r2bGWGAEdq6Z5mWopYAi4ZYzjUoOgGt3FMgNO9UZos7hznE
		5snf2LnQWrpafYiEDdfpkXGPuE6/Wx49bB3mCUcppj2JPcxthhqsN44VNxcVD+2sHc+9c+H4f53v
		ZNwxlEg15TItPVZjjz8EYfTSwn3PUsURN/9sqlCrNNgEDPWUkpeTu5mACJFFOrbe3pGj0+apE3jH
		Pl+zuSXgHAF9hlLmhAdvompoyBUFP4A05DUAY5PVQs6wCyjLaRpm4YF6adGqIGVeMMf5CoX+n39/
		6VCfdmSbgpDXrLkaiNF345ki0Rs1Qig70xCDp8N0Wh01BCJ+VPIOjBBH5Zoyz4+1sal9552P6kSl
		IQv3unWCGRXXfIANsF7dEpxTe5S8mgO3hvOQArcQONUEZpwRnchHFu+oIc6sAcw4Uz1u8EflkMQM
		Qpf7lfjBqe7B8mWXNuibPei4yNPEozfagw==';
		$decryptstring_updates = $this->decrypt($decryptstring, $algo, $key, $iv);
		$decryptstring_updates = strstr($decryptstring_updates, '|', true);
		$xmlstring = simplexml_load_string($decryptstring_updates);
		$xmlarray = json_decode(json_encode((array) $xmlstring), true);
		//echo $xmlarray['IDENTIFICATION_NO'];
		echo "<pre>";
		//print_r(htmlentities($decryptstring_updates));
		print_r($xmlarray);
		exit;*/

		/*$postdata = http_build_query(
			array(
				'ENCDATA' => $ENCDATA,
				'DEPT_CD' => '033'
			)
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		
		$result = file_get_contents('http://202.61.117.90/GRIPS/dept/dv/rest/WBHealth.do', false, $context);
		print_r(htmlentities($result));
		$xmlstring = simplexml_load_string($result);
		$xmlarray = json_decode(json_encode((array) $xmlstring), true);
		if(count($xmlarray) > 0){
			if(!empty($xmlarray['ENCDATA'])){
				$decryptstring_updates = $this->decrypt($xmlarray['ENCDATA'], $algo, $key, $iv);
				$decryptstring_updates = strstr($decryptstring_updates, '|', true);
				$v_xmlstring = simplexml_load_string($decryptstring_updates);
				$v_xmlarray = json_decode(json_encode((array) $v_xmlstring), true);
				if(count($v_xmlarray) > 0){
					if($v_xmlarray['BANKTRANSACTIONSTATUS'] == "S"){
						$getcandidateid = $this->db->get_where('frontend_users', array('f_application_no'=>$v_xmlarray['DEPT_REF_NO']))->row();
						$row_arr = array(
							'fu_challan_no' => $v_xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $v_xmlarray['BANKTRANSACTIONID'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 1
						);
						if($this->main_m->updateSuccess_Payment_candidateSet($row_arr, $v_xmlarray['IDENTIFICATION_NO'], $getcandidateid->f_uid) == TRUE){
							$htmldataset = '<html><body><h1>Thank you for Apply in WBHRB Application portal.</h1>
							<br/>
							<p>Your Application Registration Number is - <strong>'.$getcandidateid->f_application_no.'</strong></p>
							<p>For Any Further Queries, Please use this number.</p>
							</body></html>';
							$this->sendSMTPEmail($getcandidateid->f_email,'WBHRB - Application Submission', $htmldataset);
							$this->session->set_flashdata("success","Payment Successfully completed and Application submitted Successfully, Thank you.");
							redirect('member/finalcheck_up','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Database Updation Error. Please Contact Technical Team.");
							redirect('member/finalcheck_up','refresh');
						}

					}elseif($v_xmlarray['BANKTRANSACTIONSTATUS'] == "F"){
						$row_arr = array(
							'fu_challan_no' => $v_xmlarray['CHALLANREFID'],
							'fu_pay_ref_info' => $v_xmlarray['BANKTRANSACTIONMESSAGE'],
							'fu_trans_update' => date('Y-m-d H:i:s'),
							'fu_pay_approval' => 2
						);
						if($this->main_m->insertUpdate_Payment_candidateSet($row_arr, $v_xmlarray['IDENTIFICATION_NO']) == TRUE){
							$this->session->set_flashdata("e_error","Payment Transaction Failure. Need to Pay for Submission properly.");
							redirect('member/finalcheck_up','refresh');
						}else{
							$this->session->set_flashdata("e_error","Payment Failure Updation Error. Please Contact Technical Team.");
							redirect('member/finalcheck_up','refresh');
						}
					}
				}
			}else{
				redirect('member/');
			}
		}else{
			redirect('member/');
		}
		echo "<pre>";
		//print_r(htmlentities($decryptstring_updates));
		print_r($v_xmlarray);
		exit;*/
		//$this->load->view("main/member/verify_payment_privew", $this->data);	

	}


	public function final234234234234651_payment_submission(){
		
			/*$paidamount = 1.00;
			$key = '6314263687426345';
			$iv = 'jbsfkhuhjgsdgasd';
			$algo = 'aes-128-cbc';
			$identifiaction_No = date('dmYhis').$this->generateRandomString(6);
			//$ENCDATA = encrypt("I Love My India!", $algo, $key, $iv);
			//$chksum_value = 'asdasdasd2342342sdfsdfsdf';
			$responseurl = base_url().'payments/response_from_grips';
			$xmlstring_set = '<GRIPS_DEPT_EPAYMENT_REQ>
			<DEPT_CD>033</DEPT_CD>
			<SERVICE_CD>303</SERVICE_CD>
			<DEPT_REF_NO>C180820210528383175</DEPT_REF_NO>
			<IDENTIFICATION_NO>'.$identifiaction_No.'</IDENTIFICATION_NO>
			<DEPOSITED_BY>A K SAHA</DEPOSITED_BY>
			<DEPOSITOR_MOBILE_NO>9830260404</DEPOSITOR_MOBILE_NO>
			<DEPOSITOR_EMIL_ID>amit@albatrossoft.com</DEPOSITOR_EMIL_ID>
			<DEPOSITOR_ADDRESS>Goriahat Road, Kol - 68</DEPOSITOR_ADDRESS>
			<IN_FAVOR_OF>WBHRB</IN_FAVOR_OF>
			<RTN_PRD_FRM>'.date("dmY").'</RTN_PRD_FRM>
			<RTN_PRD_TO>'.date("dmY").'</RTN_PRD_TO>
			<TOTAL_AMOUNT>'.$paidamount.'</TOTAL_AMOUNT>
			<REMARKS>RECRUITMENT PAYMENT</REMARKS>
			<RESPONSE_URL>'.$responseurl.'</RESPONSE_URL>
			<REPEATED_HEAD ROW="1">
				<HEAD_OF_ACCOUNT>0051-00-104-002-16</HEAD_OF_ACCOUNT>
				<AMOUNT>'.$paidamount.'</AMOUNT>
			</REPEATED_HEAD>
			</GRIPS_DEPT_EPAYMENT_REQ>'; //|CHECKSUM='.$chksum_value;
			$chksumvalue_set = $this->hash256($xmlstring_set);
			$udated_with_chksum = $xmlstring_set.'|CHECKSUM='.$chksumvalue_set;
			$ENCDATA = $this->encrypt($udated_with_chksum, $algo, $key, $iv);
			$this->data['senddata'] = $ENCDATA;
			$this->data['senddpt'] = '033';*/
			
			//echo htmlentities($xmlstring_set)."<br/><br/>";
			//echo $chksumvalue_set."<br/><br/>";
			//echo $ENCDATA;
			/*$decryptstring = 'r0RZH3JtOxxDh3IXog9Joc2mJweZj+gmmNxg4CJ2ERHj2mg873ePqdIByZgS05ikwJE47rnTN3wW RYNk6Qud+Ws0x/lEdHyOSdwJ5l54ZyJJhJJW2alvLmHveCNZfSqlBFuraTF6OI4/u2711QNK0/xS 8dyrUcUvK2rR3HJWN1PpRpDJk53eiOG/+eDRNkx8ppnD3GD1EwUlOw/M9P8LF9XV6pav/jHgADD9 FpT+B2Kqy8I+ijZclBqM2r1eLkWOgchbQG7jCZC2fOC3SKl4vWKq/M/OwFIbyEsE41jnUJMymDhe R0fDZIg+PAEd777oMnbJqQKlGfSxXVWhgIKGC/pMn/ESHhG12Zza31SA+VqAtrBv7OwoLRzabJdn HtR7v2D4KjNhv1e6BXPrRhHrdvB0Mbq38jQGJwtgQgDm7FA3A6QZisTI3TJt0WfyByWYhZJBI87l ZoriFOEmICnjHss6tpYBZxA4OkUJ0fs68acQCeJmspALAg07bYFVsLmYX9oq+tSBZOb/A0vuI8Me ZraMYLsq5TaYrgmSkYfn8b350VzcQbUjos0ophjCzBZiVQk9pRRU/lVWUaLYDgI34/cShkqsL+Xc TodxIpLVFV75Y+NRmww3eORDqISEbhAhO+5AIVbIdXNdZyyCmX3j28JPopH9E0HAVHyGZ1fF6v6K MP1/eHDhxDApeEnuHJ3BODvJIwHLE27QEtXcgqtqQcm8r4C/OlkwBEewqHT9C/U8eOTLFWJtha+X 5ioe2e33hYDJGJ6X2/1S2Lb9ppZhtXhQvM00g30DNHYYeoSnvUuYHYtv+sJS411Lp0CHHWCnmgHs twFJ6fpZKUo3yLCmZMKoiPoqJQ1LezRWEgyNrzoUlyuoxKray5iq0PT10VSsj8hiiYe4euSyPS9s eBs7bsGdKmMs/3lzMdbUuDwowP7eIuD+rtCBdYz9gA32bz09gfvZel4CpCPUz+YIAihUzDWq+QEM ZYMNOgaBv/7kIEFsV5NQlDkbmSjft9BmOE0uxVSuYXK9i+rtfgJS5NbDVHHBFUcTa3/mbSGv/3wX pRIvAVGppecoOO393CVoOL/VEuQk1Tcfs/QOPp8HAXAAY8J6ZoO1Y8JJAxJdchp2r4jZgxN0zDkI QhEzCjdXgtx0';
			$decryptstring_updates = $this->decrypt($decryptstring, $algo, $key, $iv);
			$decryptstring_updates = strstr($decryptstring_updates, '|', true);
			$xmlstring = simplexml_load_string($decryptstring_updates);
			$xmlarray = json_decode(json_encode((array) $xmlstring), true);
			echo $xmlarray['IDENTIFICATION_NO'];
			echo "<pre>";
			//print_r(htmlentities($decryptstring_updates));
			print_r($xmlarray);
			exit;*/


			//$this->load->view("main/member/pay_finalset_privew", $this->data);

		

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

	public function getset_verification($transid = NULL, $appliction_no = NULL){
		if($transid == NULL || $appliction_no == NULL){
			redirect('default404');
		}
		
		$key = '6314263687426345';
		$iv = 'jbsfkhuhjgsdgasd';
		$algo = 'aes-128-cbc';

		$c_year = date('Y');
		$current_month = date("m");
		$p_yr = date('Y', strtotime('-1 year'));
		if($current_month > 0 && $current_month < 4){
			$f_year = $p_yr;
		}else{
			$f_year = $c_year;
		}
		$xmlstring_set = '<GRIPS_DEPT_DV_REQ>
		<DEPT_CD>033</DEPT_CD>
		<SERVICE_CD>303</SERVICE_CD>
		<DEPT_REF_NO>'.$appliction_no.'</DEPT_REF_NO>
		<IDENTIFICATION_NO>'.$transid.'</IDENTIFICATION_NO>
		<FIN_YEAR>'.$f_year.'</FIN_YEAR>
		</GRIPS_DEPT_DV_REQ>'; //|CHECKSUM='.$chksum_value;
		//print_r(htmlentities($xmlstring_set));
		$chksumvalue_set = $this->hash256($xmlstring_set);
		$udated_with_chksum = $xmlstring_set.'|CHECKSUM='.$chksumvalue_set;
		$ENCDATA = $this->encrypt($udated_with_chksum, $algo, $key, $iv);
		//print_r('<br/><br/>'.$chksumvalue_set);
		//print_r('<br/><br/>'.$ENCDATA);
		//exit;
		$postdata = http_build_query(
			array(
				'ENCDATA' => $ENCDATA,
				'DEPT_CD' => '033'
			)
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		
		//$result = file_get_contents('http://202.61.117.90/GRIPS/dept/dv/rest/WBHealth.do', false, $context);
		$result = file_get_contents('https://www.wbifms.gov.in/GRIPS/dept/dv/rest/WBHealth.do', false, $context);
		//print_r(htmlentities($result));
		$xmlstring = simplexml_load_string($result);
		$xmlarray = json_decode(json_encode((array) $xmlstring), true);
		if(count($xmlarray) > 0){
			if(!empty($xmlarray['ENCDATA'])){
				$decryptstring_updates = $this->decrypt($xmlarray['ENCDATA'], $algo, $key, $iv);
				$decryptstring_updates = strstr($decryptstring_updates, '|', true);
				$v_xmlstring = simplexml_load_string($decryptstring_updates);
				$v_xmlarray = json_decode(json_encode((array) $v_xmlstring), true);
				echo "<pre>";
				print_r($v_xmlarray);
			}
		}
		exit;
		
	}

	protected function hash256($input) 
	{
		$hash = hash("sha256", utf8_encode($input));
		$output = "";
		foreach(str_split($hash, 2) as $key => $value) {
			if (strpos($value, "0") === 0) {
				$output .= str_replace("0", "", $value);
			} else {
				$output .= $value;
			}
		}
		return $output;
	}
	protected function encrypt($data, $algo, $key, $iv)
	{
		$cipherText = openssl_encrypt(
				$data,
				$algo,
				$key,
				OPENSSL_RAW_DATA,
				$iv
			);
		$cipherText = base64_encode($cipherText);
		return $cipherText;
		//$this->printData("ENCDATA : $cipherText");
	}
	protected function decrypt($data, $algo, $key, $iv)
    {
        $cipherText = base64_decode($data);
        $plaintext = openssl_decrypt(
                    $cipherText,
                    $algo,
                    $key,
                    OPENSSL_RAW_DATA,
                    $iv
                );
		return $plaintext;
		//$this->printData("PLAINTEXT  : $plaintext");
    }
    protected function printData($obj)
    {
		print_r($obj);
	}

}