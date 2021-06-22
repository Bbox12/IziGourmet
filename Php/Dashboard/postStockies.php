db<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

var_dump($_POST);

if (isset($_POST['Name'])){


 
 
$Name=$_POST["Name"];
$Name=test_input($Name);

$address=$_POST["address"];
$address=test_input($address);



$about=$_POST["about"];
$about=test_input($about);

$phone=$_POST["phone"];
$phone=test_input($phone);

$email=$_POST["email"];
$email=test_input($email);


$state=$_POST["state"];
$state=test_input($state);

$City=$_POST["City"];
$City=test_input($City);

$Pin=$_POST["Pin"];
$Pin=test_input($Pin);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);

$Latitide=$_POST["Latitude"];
$Latitide=test_input($Latitide);

$Longitude=$_POST["Longitude"];
$Longitude=test_input($Longitude);


 $user = $db->postStockies($about,$email,$Latitide,$Longitude,$Name,$phone,$address,$state,$City,$Pin,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
  
     header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddStockies.php?id='.$ID);
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
       header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddStockies.php');
    }


  


} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddStockies.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>