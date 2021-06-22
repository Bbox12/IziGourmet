<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
var_dump($_POST);
$response = array("error" => FALSE);
if (isset($_POST['User'])){
   
    $mobile = $_POST['mobile'];
       $User=$_POST['User'];
    $OTP = $_POST['OTP'];

                   $IP=$_POST['IP'];
   
    $mobile=test_input($mobile);
 

       $User=test_input($User);
    $OTP=test_input($OTP);
  
                  $IP=test_input($IP);
   


            $res = $db->start_ride_image($mobile,$User,$OTP,$IP);

         if ($res) {
       
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
    
    }
 echo json_encode($response);
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>