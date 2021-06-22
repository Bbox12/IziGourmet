<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['unique_id'])){
 
    // receiving the post params
    $driver_mobile =isset($_POST['driver_mobile']) ? $_POST['driver_mobile'] : '';
    $unique_id =isset($_POST['unique_id']) ? $_POST['unique_id'] : '';
    $user_mobile = isset($_POST['user_mobile']) ? $_POST['user_mobile'] : '';
    $user_rating=isset($_POST['user_rating']) ? $_POST['user_rating'] : '';
    $distance=isset($_POST['distance']) ? $_POST['distance'] : '';
        $paid=isset($_POST['paid']) ? $_POST['paid'] : '';
           $IP=isset($_POST['IP']) ? $_POST['IP'] : '';
           $OTP=isset($_POST['OTP']) ? $_POST['OTP'] : '';
  
    $driver_mobile=test_input($driver_mobile);
    $user_mobile=test_input($user_mobile);
    $Unique_id=test_input($unique_id);
     $user_rating=test_input($user_rating);
    $distance=test_input($distance);
       $paid=test_input($paid);
         $IP=test_input($IP);
         $OTP=test_input($OTP);
    
         $user = $db->stop_ride_finish($driver_mobile,$unique_id,$user_rating,$distance,$paid,$IP,$OTP);
     

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
             $response["user"]["unique_id"]=$user["Unique_Ride_Code"];
                $response["user"]["Cost"]=$user["Cost"];
                  $response["user"]["No_of_seats"]=$user["No_of_Seats"];
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