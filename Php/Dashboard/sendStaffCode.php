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

$StaffID=$_POST["StaffID"];
$StaffID=test_input($StaffID); 

$Date=$_POST["Date"];
$Date=test_input($Date); 

$time=$_POST["time"];
$time=test_input($time); 

$msg=$_POST["msg"];
$msg=test_input($msg); 

foreach($_POST['check_list'] as $selected){
echo $selected."</br>";

   $user = $db->assignPin($StaffID,$selected,$Date,$time,$msg,$User,$IP);
}


        if ($user) {   
        $response["error"] = false;
        require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        $result =$conn->query("SELECT PhoneNo FROM  admin_login_data WHERE ID='$StaffID'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $ID=$row["PhoneNo"];
        }
         }
        header('Location: http://139.59.38.160/Ecosense/Dashboard/updateFCM.php?id='.$ID.'&msg='.$msg);
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