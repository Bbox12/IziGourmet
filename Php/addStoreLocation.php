<?php
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

$address1=$_POST["address1"];
$address1=test_input($address1);

$Phone=$_POST["Phone"];
$Phone=test_input($Phone);

$Latitude=$_POST["Latitude"];
$Latitude=test_input($Latitude);


$Longitude=$_POST["Longitude"];
$Longitude=test_input($Longitude);

$distance=$_POST["distance"];
$distance=test_input($distance);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);



     $user = $db->addLocation($Name,$address1,$Phone,$Latitude,$Longitude,$distance,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/StoreLocation.php');
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/StoreLocation.php');
    }


} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/StoreLocation.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>