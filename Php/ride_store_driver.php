<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
 var_dump($_POST);
if (isset($_POST['drivermobile']) &&isset($_POST['usermobile'] ) &&isset($_POST['otp'] )){
 
    // receiving the post params
    $driver_mobile =isset($_POST['drivermobile']) ? $_POST['drivermobile'] : '';
    
    $user_mobile = isset($_POST['usermobile']) ? $_POST['usermobile'] : '';
    $otp=isset($_POST['otp']) ? $_POST['otp'] : '';
  
    $driver_mobile=test_input($driver_mobile);
    $user_mobile=test_input($user_mobile);
    $otp=test_input($otp);
    
        $user = $db->book_ride_update($driver_mobile,$user_mobile,$otp);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["unique_id"]=$user["Unique_ride_code"];
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