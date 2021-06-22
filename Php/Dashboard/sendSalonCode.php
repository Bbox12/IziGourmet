<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);



if (!empty($_POST['check_list'])){

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);


foreach($_POST['check_list'] as $selected){
echo $selected."</br>";

   $user = $db->assignSalon($selected,$User,$IP);
}


        if ($user) {   
        $response["error"] = false;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/AssignPopularSalon.php');
    } else  {
       
        $response["error"] = true;
        $response["message"] = "error";
    }

} else {
    // File parameter is missing
    $response['error'] = true;
           header('Location: http://139.59.38.160/IziGourmet/Dashboard/AssignPopularSalon.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>