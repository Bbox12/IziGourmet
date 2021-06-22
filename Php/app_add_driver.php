<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['mobile']) && isset($_POST['imei']) ){

    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
    $imei = isset($_POST['imei']) ? $_POST['imei'] : '';
       $driver_lat = $_POST['driver_lat'];
      $driver_long = $_POST['driver_long'];
    $driver_lat=test_input($driver_lat);
       $driver_long=test_input($driver_long);
 
   
    $mobile=test_input($mobile);
    $imei=test_input($imei);

     
    

        $user = $db->Add_Imei($mobile,$imei,$driver_lat,$driver_long);
        if ($user) {
            // user stored successfully
              $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            echo json_encode($response);
        }
    


}else {
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