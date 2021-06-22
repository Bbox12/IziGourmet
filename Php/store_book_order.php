<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);


if (isset($_POST['mobile']) && isset($_POST['data'] )&& isset($_POST['total'] )){
 
    // receiving the post params
   $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
   $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
   $total = isset($_POST['total']) ? $_POST['total'] : '';
   $gross=isset($_POST['gross']) ? $_POST['gross'] : '';
   $data=isset($_POST['data']) ? $_POST['data'] : '';
   $del=isset($_POST['del']) ? $_POST['del'] : '';
   $package=isset($_POST['package']) ? $_POST['package'] : '';
   $discount=isset($_POST['discount']) ? $_POST['discount'] : '';

   
    $mobile=test_input($mobile);
    $gross=test_input($gross);
    $total=test_input($total);
    $ID=test_input($ID);
    $data=test_input($data);
    $del=test_input($del);
    $package=test_input($package);
       $discount=test_input($discount);
     
      
         $user = $db-> add_order($mobile,$ID,$data,$total,$gross,$del,$package,$discount);
      

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