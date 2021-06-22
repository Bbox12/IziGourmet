<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 var_dump($_POST);
if (isset($_POST['giver_mobile'])){
 
    $name= $_POST['giver_name'];
     $IP= $_POST['IP'];
    $mobile = $_POST['giver_mobile'];
      
    $otp = rand(100000, 999999);
  
    $mobile=test_input($mobile);
    $name=test_input($name);
    $IP=test_input($IP);

    

        $res = $db->createOTPDriver($IP,$name,$mobile,$otp);

         if ($res) {
        
        // send sms
        //sendSms($mobile, $otp);
        
        $response["error"] = false;
        $response["message"] = "SMS request is initiated! You will receive it shortly.";
    } else  {
       
        $response["error"] = null;
        $response["message"] = "Sorry! Error occurred in registration.";
    }
           
        
 
    

} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
}
     echo json_encode($response); 
       
   function sendSms($mobile, $otp) {
    
    $otp_prefix = ':';

    //Your message to send, Add URL encoding here.
    $message = urlencode("Hello! Welcome to eTez. Your OTP is '$otp_prefix $otp'. Please do not share the OTP with anyone for security reason");

    $response_type = 'json';

    //Define route 
    $route = "4";
    
    //Prepare you post parameters
    $postData = array(
        'authkey' => MSG91_AUTH_KEY,
        'mobiles' => $mobile,
        'message' => $message,
        'sender' => MSG91_SENDER_ID,
        'route' => $route,
        'response' => $response_type
    );

//API URL
    $url = "https://control.msg91.com/sendhttp.php";

// init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
    ));


    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    //get response
    $output = curl_exec($ch);

    //Print error if any
    if (curl_errno($ch)) {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>