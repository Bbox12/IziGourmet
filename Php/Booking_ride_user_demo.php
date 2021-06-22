<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
 
 var_dump($_POST);
if (isset($_POST['mobile']) &&isset($_POST['from_'] )
 &&isset($_POST['to_'])  ){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
    $from_ = isset($_POST['from_']) ? $_POST['from_'] : '';
    $to_=isset($_POST['to_']) ? $_POST['to_'] : '';
  
        $from_lat=$_POST['from_lat'];
    $from_long=$_POST['from_long'];
           $to_lat=$_POST['to_lat'];
    $to_long=$_POST['to_long'];
      $vehicle=$_POST['vehicle'];
     $IP=$_POST['IP'];
       $Cost=$_POST['Cost'];
  $Cost=test_input($Cost);


    $mobile=test_input($mobile);
    $from_=test_input($from_);
    $to_=test_input($to_);
    $vehicle=test_input($vehicle);
       $from_lat=test_input($from_lat);
    $from_long=test_input($from_long);
         $to_lat=test_input($to_lat);
    $to_long=test_input($to_long);
       $IP=test_input($IP);
        $distance=$_POST['distance'];
        $distance=test_input($distance);

         $_seats=$_POST['_seats'];
        $_seats=test_input($_seats);
            
       
        $user = $db->book_ride_demo($Cost,$mobile,$from_, $to_,$from_lat,$from_long,$to_lat,$to_long,$vehicle,$IP,$distance,$_seats);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["unique_id"]=$user["Unique_Ride_Code"];
              $response["user"]["OTP"]=$user["OTP"];
                   $response["user"]["ID"]=$user["ID"];
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