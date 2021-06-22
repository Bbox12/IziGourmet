<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();


$response = array();
$response = array("error" => FALSE);
var_dump($_POST);
if (isset($_POST['otp']) && $_POST['otp'] != '' &&  isset($_POST['giver_mobile'])) {
    $otp = $_POST['otp'];
    $mobile = $_POST['giver_mobile'];
     $server_ip="139.59.38.160";
    $target_path = "Profile/DRIVER/";
   

    if (empty($_FILES['image']['name'])) {
       $image = "profile_image.png";
          }else{
      $image = $_FILES['image']['name'];
  }

        $image=test_input($image);
    

    $mobile=test_input($mobile);
    $target_path = $target_path . basename($_FILES['image']['name']);
       $file_path=$_FILES['image']['name'];
        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{
 
        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;
        $res = $db->activateDriver($otp,$mobile,$image);
         if ($res) {
  
        $response["error"] = false;
      
    } else  {
       
        $response["error"] = null;

    }
    
} 
       
        echo json_encode($response);
         
       }

        catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

     } else {
    $response["error"] = TRUE;
    $response["message"] = "Sorry! OTP is missing.";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>