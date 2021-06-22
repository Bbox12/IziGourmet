<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) && isset($_POST['driver_lat']) && isset($_POST['driver_long']) ) {
 
    // receiving the post params
    $mobile = $_POST['mobile'];
    $driver_lat = $_POST['driver_lat'];
      $driver_long = $_POST['driver_long'];
    

    $mobile=test_input($mobile);
    $driver_lat=test_input($driver_lat);
       $driver_long=test_input($driver_long);
 
 
        // create a new user
        $user = $db->storeDriverLatLng($mobile,$driver_lat,$driver_long);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            echo json_encode($response);
        }
    }
 else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters is missing!";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>