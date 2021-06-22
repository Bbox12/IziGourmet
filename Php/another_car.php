<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
if (isset($_POST['unique_id'])){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $unique_id =isset($_POST['unique_id']) ? $_POST['unique_id'] : '';
    $vehicle = isset($_POST['vehicle']) ? $_POST['vehicle'] : '';

    $mobile=test_input($mobile);
    $unique_id=test_input($unique_id);
    $vehicle=test_input($vehicle);

 
        $user = $db->another_car($mobile,$unique_id,$vehicle);
         

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