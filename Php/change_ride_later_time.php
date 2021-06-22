<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['otp'] )){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $otp = isset($_POST['otp']) ? $_POST['otp'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
   

    $mobile=test_input($mobile);
    $date=test_input($date);
     $otp=test_input($otp);
       $time=test_input($time);
         $user = $db-> add_change_time($mobile,$otp,$date,$time);
      

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Failed!";
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