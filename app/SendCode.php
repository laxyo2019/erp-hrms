<?php 
namespace App;

class SendCode 
{
	public static function sendCode($phone)
	{
		// $code = rand(1111,9999);
		// $nexmo = app('Nexmo\Client');
		// $nexmo->message()->send([
		// 	'to' => '+91'.(int)$phone,
		// 	'from' => '+918815218315',
		// 	'text' => 'Verify Code: '.$code
		// ]);
		$code = rand(1111,9999);

		$username="ritesh845";
        $password ="ritesh@100";

        $number = (int)$phone;
        $sender = "TESTID";
        $message = 'Verify Code: '.$code;

        //$url="login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($number)."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3'); 

        $url = "http://login.yourbulksms.com/api/sendhttp.php?authkey=11456AxEiTIeN5ca87c66&mobiles=".$number."&message=".$message." & new&mobile&sender=ADLAWS&route=4";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curl_scraped_page = curl_exec($ch);

        curl_close($ch);

        return $code;
	}
}