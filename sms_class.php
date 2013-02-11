<?php
class SMS_Fullon {

public function SMS($mob_no, $content = 'No Content ...') {
	if($mob_no > 999999999 AND $mob_no < 10000000000) {
		
		$FullOn = array(
			'L A' => 'MobileNoLogin=9037223519&LoginPassword=SUITHG',
			'L B' => 'MobileNoLogin=9037223519&LoginPassword=SUITHG'
			);//'Tejas A' => 'MobileNoLogin=8089324091&LoginPassword=4344',	'V A' => 'MobileNoLogin=7736476946&LoginPassword=84763'
		
		$account = array_rand($FullOn);
		$out=$this->post("http://www.fullonsms.com/login.php", $FullOn[$account]);
		$out=$this->post("http://www.fullonsms.com/home.php", "MobileNos=".$mob_no."&Message=".urlencode(substr($content, 0, 140)));
		//$out=$this->post("http://hedcet.com/sujith/sms/send.php?m_num=9037223519&msg=test_msg", 1==1);
		///$out=$this->post("http://www.fullonsms.com/home.php", "MobileNos=".$mob_no."&Message=".urlencode(substr($content, 0, 140)));
		
		//$this->db->insert('sms_log', array('account' => $account, 'mob_no' => $mob_no, 'content' => $content));
		
		sleep(8);
		
	}
}

public function post($url, $data, $r=false) {
	$this->sms_handle=curl_init($url);
	if( ! file_exists("cookie.txt")) {
		$file=fopen("cookie.txt", 'w');
		fclose($file);
	}
	curl_setopt($this->sms_handle, CURLOPT_COOKIEFILE, "cookie.txt");
	curl_setopt($this->sms_handle, CURLOPT_COOKIEJAR, "cookie.txt");
	curl_setopt($this->sms_handle, CURLOPT_ENCODING, "gzip");
	curl_setopt($this->sms_handle, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($this->sms_handle, CURLOPT_HEADER, true);
	curl_setopt($this->sms_handle, CURLOPT_HTTPHEADER, array("Connection: Keep-Alive", "Content-type: application/x-www-form-urlencoded", "Keep-Alive: 300"));
	curl_setopt($this->sms_handle, CURLOPT_POST, true);
	curl_setopt($this->sms_handle, CURLOPT_POSTFIELDS, $data);
	if($r)
		curl_setopt($this->sms_handle, CURLOPT_REFERER, $r);
	curl_setopt($this->sms_handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($this->sms_handle, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($this->sms_handle, CURLOPT_USERAGENT, "iPhone 4.0");
	$return = curl_exec($this->sms_handle);
	curl_close($this->sms_handle);
	return $return;
}

}