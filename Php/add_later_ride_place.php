<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['otp'] ) &&isset($_POST['from'] ) &&isset($_POST['to'] )){
    $vehicle=isset($_POST['vehicle']) ? $_POST['vehicle'] : '';
    $IP=isset($_POST['IP']) ? $_POST['IP'] : '';
    $out =isset($_POST['outstation']) ? $_POST['outstation'] : '';
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $otp =isset($_POST['otp']) ? $_POST['otp'] : '';
    $from = isset($_POST['from']) ? $_POST['from'] : '';
    $to=isset($_POST['to']) ? $_POST['to'] : '';
    $to_lat=isset($_POST['to_lat']) ? $_POST['to_lat'] : '';
    $to_long=isset($_POST['to_long']) ? $_POST['to_long'] : '';
       $date =isset($_POST['date']) ? $_POST['date'] : '';
          $time =isset($_POST['time']) ? $_POST['time'] : '';
    $mobile=test_input($mobile);
    $to=test_input($to);
    $from=test_input($from);
    $to_lat=test_input($to_lat);
    $to_long=test_input($to_long);
     $otp=test_input($otp);
       $out=test_input($out);
          $date=test_input($date);
       $time=test_input($time);
            $vehicle=test_input($vehicle);
                 $IP=test_input($IP);
    
        $user = $db->add_later_ride_place($otp,$mobile,$from,$to,$to_lat,$to_long,$out,$date,$time,$vehicle,$IP);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["OTP"] = $user["OTP"];
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