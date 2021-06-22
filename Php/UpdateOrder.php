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

if (isset($_POST['CDNo'])){

 
$ID=$_POST["ID"];
$ID=test_input($ID);
$CDNo=$_POST["CDNo"];
$CDNo=test_input($CDNo);

 
$Order=$_POST["Order"];
$Order=test_input($Order);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);


     $user = $db->updateOrder($Order,$ID,$CDNo,$User,$IP);

        if ($user) {   
        $response["error"] = false;
        $unique=$user["ID"];
        header('Location: http://139.59.38.160/Meat/Dashboard/latlongChanged.php?id='.$unique.'&Order='.$Order);
    } else  {
       
        $response["error"] = true;
        $response["message"] = "error";
    }

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
?>