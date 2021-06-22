<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['otp'] )&&isset($_POST['vehicle'] )){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
    $vehicle = isset($_POST['vehicle']) ? $_POST['vehicle'] : '';

      $otp = isset($_POST['otp']) ? $_POST['otp'] : '';

       $cost = isset($_POST['cost']) ? $_POST['cost'] : '';
   
  $return = isset($_POST['return']) ? $_POST['return'] : '';

    $mobile=test_input($mobile);
    $cost=test_input($cost);
    $otp=test_input($otp);
    $vehicle=test_input($vehicle);
        $return=test_input($return);
      
         $user = $db-> add_later_outstation($mobile,$otp,$vehicle,$cost,$return);
      

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
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