<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("user" => array());

$target_path = "Menu/";

error_reporting(-1);
ini_set('display_errors', 'On');



 
if ( isset($_POST['mobile']) && isset($_POST['password'])){
 
    // receiving the post params
    $name = $_POST['username'];
    $mobile=$_POST['mobile'];
    $password=strtoupper($_POST['password']);
   
    $name=test_input($name);
    $mobile=test_input($mobile);
    $password=test_input($password);
   
    $file_path="Profile.png";
 
     
         $file_path=test_input($file_path);

        $user = $db->signup($name,$mobile,$password,$file_path);
        if ($user) {


                    $jsonRow_201=array(
                 "ID"=>$user["ID"],   
                 "role"=>$user['role'],
                 "Name"=>$user['Name'],
                
 );

array_push($response["user"], $jsonRow_201);
        
           
        } else {
            // user failed to store
           $response["user"]["role"] =0;
        
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

    echo json_encode($response);


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_c($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data=strtoupper($data);
  return $data;
}
?>