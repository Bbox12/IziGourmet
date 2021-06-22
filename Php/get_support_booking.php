<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) ){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
   
    $mobile=test_input($mobile);
   
       
        $user1 = $db->support_booking($mobile);

        if ($user1) {
            // user stored successfully
            $response["error"] = FALSE;

             $response["user"][ "otp"]=$user1["OTP"];
               $response["user"]["Vehicle"]=$user1["Vehicle_choosen"];
               $response["user"]["Unique_id"]=$user1["Unique_ride"];
               $response["user"]["User_from"]=$user1['User_from'];
               $response["user"]["User_to"]=$user1['User_to'];
                  $response["user"]["mobile"]=$user1['User_mobile'];
                  $response["user"]["Stopped"]=$user1['Stopped'];
             $response["user"]["Snapshot"]='http://' . $server_ip . '/' . 'OHO' . '/' .'APP'.'/'.'Snapshots'. '/'  .$user1['Snapshot'];
                  $response["user"]["Date_"]=$user1['Created_date'];
                  $response["user"]["Time_"]=$user1["Created_time"];
                      $response["user"]["drivermobile"]=$user1["Driver_mobile"];
                         $response["user"]["User_mobile"]=$user1["User_mobile"];
                           $response["user"]["start_time"]=$user1["Start_time"];
                         $response["user"]["end_time"]=$user1["End_time"];
                           $response["user"]["driver_rating"]=$user1["Driver_rating"];
                                      $response["user"]["cost"]=$user1["Cost"];
                                           $response["user"]["review"]=$user1["Review"];
         
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