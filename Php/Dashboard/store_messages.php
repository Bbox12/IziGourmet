db<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);



if (isset($_POST['message'])){


 
 
$message=$_POST["message"];
$message=test_input($message);

$mobile=$_POST["mobile"];
$mobile=test_input($mobile);

$email=$_POST["email"];
$email=test_input($email);


$phone=$_POST["phone"];
$phone=test_input($phone);

 $user = $db->postMessage($phone,$message,$mobile,$email);
             if ($user) {  


$admin_email = "info@IziGourmet.co.za";

  $result =mail($admin_email,"Query From:". $phone, $message, "IziGourmet Express Mobile App query From:" . $email);

 if(!$result) {   
    $response["error"] = true; 
} else {
       $response["error"] = false;
}

        $response["error"] = false;

    } else  {
      
        $response["error"] = true;
    }


  


} else {
    $response['error'] = true;
    
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>