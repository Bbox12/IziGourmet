<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();


$response = array();
$response = array("error" => FALSE);

if (isset($_POST['otp']) && $_POST['otp'] != '' &&  isset($_POST['giver_mobile'])) {
    $otp = $_POST['otp'];
    $mobile = $_POST['giver_mobile'];
    $lat=$_POST['my_lat'];
    $long=$_POST['my_long'];
    $name= $_POST['giver_name'];
    $refer=generateRandomString();
     $IP= $_POST['IP'];

    $mobile=test_input($mobile);
    $name=test_input($name);
    $lat=test_input($lat);
    $long=test_input($long);
    $refer=test_input($refer);
    $IP=test_input($IP);
    $otp=test_input($otp);

    $res = $db->activateUser($otp,$mobile,$name,$lat,$long,$refer,$IP);
         if ($res) {
  
        $response["error"] = false;
      
    } else  {
       
        $response["error"] = true;

    }
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