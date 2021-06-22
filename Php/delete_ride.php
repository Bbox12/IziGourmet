<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['unique_id'] )  ){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $unique_id= isset($_POST['unique_id']) ? $_POST['unique_id'] : '';
 $cID= isset($_POST['cID']) ? $_POST['cID'] : '';
  $cID=test_input($cID);
    $mobile=test_input($mobile);
    $unique_id=test_input($unique_id);
     
   
        $user = $db->ride_delete($mobile,$unique_id,$cID);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
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