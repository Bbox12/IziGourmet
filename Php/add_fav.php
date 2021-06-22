<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['fav'] ) &&isset($_POST['address'] )){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
    $fav = isset($_POST['fav']) ? $_POST['fav'] : '';
    $address=isset($_POST['address']) ? $_POST['address'] : '';
  
    $mobile=test_input($mobile);
    $fav=test_input($fav);
    $address=test_input($address);
    
        $user = $db->add_fav($mobile,$fav,$address);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["mobile"]=$user["Mobile"];
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