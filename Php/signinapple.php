<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("user"=> array());

$target_path = "Menu/";

error_reporting(-1);
ini_set('display_errors', 'On');


$server_ip="139.59.38.160";
 //var_dump($_POST);
if ( isset($_POST['mobile']) && isset($_POST['password'])){


  $change=0;
 

    $mobile=$_POST['mobile'];
    $password=strtoupper($_POST['password']);
  
    $mobile=test_input($mobile);
    $password=test_input($password);

    if ( isset($_POST['change'])){

        $change=$_POST['change'];
  $change=test_input($change);
    }


   
        $user = $db->signin($mobile,$password,$change);
        if ($user) {
        	$jsonRow_201=array(
  "ID"=>$user["ID"],   
                 "role"=>$user['role'],
                         "Name"=>$user['Name'],
                          "Photo"=>'http://' . $server_ip . '/' . 'Meat' . '/' .'Menu'.'/'.$user['Photo'],
                
 );

array_push($response["user"], $jsonRow_201);
 
        }else{
            $response["user"]["role"] =0;
            $response["user"]["error"]=true;
    
        }

} else {
      $response["user"]["error"]=true;
  
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