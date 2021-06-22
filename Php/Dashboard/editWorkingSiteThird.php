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

 $ID=$_POST["ID"];
$ID=test_input($ID);
 
 $role=$_POST["role"];
$role=test_input($role);
 
$Name=$_POST["Name"];
$Name=test_input($Name);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);





     $user = $db->editWorkingSiteThird($ID,$role,$Name,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddThirdService.php');
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddThirdService.php');
    }

 
 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddThirdService.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>