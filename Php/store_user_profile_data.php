<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();


$response = array();
$response = array("error" => FALSE);

if (isset($_POST['mobile']) ) {


    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $lat=$_POST['my_lat'];
    $long=$_POST['my_long'];
    $email= $_POST['email'];
    $address= $_POST['address'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $pin= $_POST['pin'];
    $country= $_POST['country'];

    $server_ip="139.59.38.160";
    $target_path = "Menu/";
   

    


    $mobile=test_input($mobile);
    $name=test_input($name);
    $lat=test_input($lat);
    $long=test_input($long);
    $email=test_input($email);
    $address=test_input($address);
    $state=test_input($state);
    $city=test_input($city);
    $pin=test_input($pin);
    $country=test_input($country);

   
  //  $file_upload_url = 'http://' . $server_ip . '/' . 'Meat' . '/'. 'Dashboard'.'/'.$target_path;
    
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
        $res = $db->User_profile_Update($name,$mobile,$email,$address,$state,$city,$country,$pin,$lat,$long,$file_path);
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

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>