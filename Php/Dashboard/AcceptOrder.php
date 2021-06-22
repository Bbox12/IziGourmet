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



$message=$_GET["message"];
$message=test_input($message);

$role=$_GET["role"];
$role=test_input($role);


 
$id=$_GET["id"];
$id=test_input($id);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);




     $user = $db->NewacceptedOrder($id,$message,$role);
             if ($user) {  

          $_SESSION["error"]=1;
          $response["error"] = false;
                $unique=$user["Unique_Ride_Code"];

                 
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/latlongAcceptOrder.php?unique='.$unique.'&message='.$message.'&role='.$role);
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/Profile.php?id='.$id);
    }

 
 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/Profile.php?id='.$id);
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>