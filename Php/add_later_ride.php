<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

 var_dump($_POST);
if (isset($_POST['mobile']) &&isset($_POST['time'] )&&isset($_POST['day'] )){
 
    // receiving the post params
   $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
   $time = isset($_POST['time']) ? $_POST['time'] : '';
   $return = isset($_POST['return']) ? $_POST['return'] : '';
   $day=isset($_POST['day']) ? $_POST['day'] : '';
   $IP=isset($_POST['IP']) ? $_POST['IP'] : '';
   $otp=isset($_POST['otp']) ? $_POST['otp'] : '';
   $pager=isset($_POST['pager']) ? $_POST['pager'] : '';

    $vehicle=isset($_POST['vehicle']) ? $_POST['vehicle'] : '';
    $out =isset($_POST['outstation']) ? $_POST['outstation'] : '';
    $from = isset($_POST['from']) ? $_POST['from'] : '';
    $to=isset($_POST['to']) ? $_POST['to'] : '';
    $to_lat=isset($_POST['to_lat']) ? $_POST['to_lat'] : '';
    $to_long=isset($_POST['to_long']) ? $_POST['to_long'] : '';
    $from_lat=isset($_POST['from_lat']) ? $_POST['from_lat'] : '';
    $from_long=isset($_POST['from_long']) ? $_POST['from_long'] : '';

        $distance=isset($_POST['distance']) ? $_POST['distance'] : '';
  
    $mobile=test_input($mobile);
    $time=test_input($time);
    $day=test_input($day);
    $return=test_input($return);
    $IP=test_input($IP);
    $vehicle=test_input($vehicle);
    $out=test_input($out);
    $from=test_input($from);
    $to=test_input($to);
    $to_lat=test_input($to_lat);
    $to_long=test_input($to_long);
    $from_lat=test_input($from_lat);
    $from_long=test_input($from_long);
       $otp=test_input($otp);
        $pager=test_input($pager);
         $distance=test_input($distance);
     
      
         $user = $db-> add_later_ride($mobile,$time,$day,$return,$IP,$vehicle,$out,$from,$to,$to_lat,$to_long,$from_lat,$from_long,$otp,$pager,$distance);
      

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["Unique_Ride_Code"] = $user["Unique_Ride_Code"];
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