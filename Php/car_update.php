<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile'])&& isset($_POST['driver'])&& isset($_POST['vehicle']) ) {
 
    // receiving the post params
    $mobile = $_POST['mobile'];
     $driver = $_POST['driver'];
   $vehicle=$_POST['vehicle'];
    

    $mobile=test_input($mobile);
    $driver=test_input($driver);
     $vehicle=test_input($vehicle);
   
 
 
        // create a new user
        $user = $db->update_vehicle($mobile,$driver,$vehicle);
        if ($user) {
            // user stored successfully
            $response["user"]["Vehicle_Type"]=$user["Vehicle_Type"];
            $response["user"]["Vehicle_No"]=$user["Vehicle_No"];
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