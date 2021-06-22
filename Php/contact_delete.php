<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) ){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $name= isset($_POST['name']) ? $_POST['name'] : '';
    $contact= isset($_POST['contact']) ? $_POST['contact'] : '';
    
    $mobile=test_input($mobile);
    $name=test_input($name);
        $contact=test_input($contact);
   
        $user = $db->contact_delete($mobile,$name,$contact);

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