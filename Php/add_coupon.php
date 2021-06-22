<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile'])){
    $coupon= $_POST['coupon'];
    $mobile = $_POST['mobile'];
    
    $mobile=test_input($mobile);
    $coupon=test_input($coupon);


     $amt = $_POST['amt'];
    
    $amt=test_input($amt);

    $unique = $_POST['unique'];
    
    $unique=test_input($unique);



            $res = $db->add_coupon($coupon,$mobile,$amt,$unique);

         if ($res) {
               
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
    
    }
 echo json_encode($response);
} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
}
     echo json_encode($response); 
       





function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>