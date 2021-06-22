<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['giver_mobile'])){
    $lat=$_POST['my_lat'];
    $long=$_POST['my_long'];
    $name= $_POST['giver_name'];
    $email = $_POST['giver_email'];
    $mobile = $_POST['giver_mobile'];
 $refer=generateRandomString();
    echo $refer;
    $id=$_POST['idfacebook'];
  
    $email=test_input($email);
    $mobile=test_input($mobile);
    $name=test_input($name);
    $id=test_input($id);
      $lat=test_input($lat);
    $long=test_input($long);
    $refer=test_input($refer);


            $res = $db->createUserMobile($id,$name,$email,$mobile,$lat,$long,$refer);

         if ($res) {
       
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
        $response["message"] = "Mobile number already existed!";
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