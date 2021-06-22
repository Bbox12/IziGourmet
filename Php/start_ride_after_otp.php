<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
 var_dump($_POST);
if (isset($_POST['unique_id'])){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $unique_id =isset($_POST['unique_id']) ? $_POST['unique_id'] : '';
    $OTP = isset($_POST['OTP']) ? $_POST['OTP'] : '';

    $mobile=test_input($mobile);
    $OTP=test_input($OTP);
    $Unique_id=test_input($unique_id);
  
     
         $user = $db->start_ride_after_otp($mobile,$unique_id,$OTP);
     

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters missing!";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>