<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);



if (isset($_GET['id'])){


$ID=$_GET["id"];
$ID=test_input($ID);
 

$cb=$_GET["cb"];
$cb=test_input($cb);


$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);



  $user = $db->out_of_stock($ID,$cb);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/AllProducts.php');
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/AllProducts.php');
    }

 
 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/AllProducts.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>