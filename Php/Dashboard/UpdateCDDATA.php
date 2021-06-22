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

if (isset($_POST['DispatchedNo'])&& isset($_POST['CDNo'])){

 
$DispatchedNo=$_POST["DispatchedNo"];
$DispatchedNo=test_input($DispatchedNo);
$CDNo=$_POST["CDNo"];
$CDNo=test_input($CDNo);
$pmtMode=$_POST["pmtMode"];
$pmtMode=test_input($pmtMode);
$ChargeableWeight=$_POST["ChargeableWeight"];
$ChargeableWeight=test_input($ChargeableWeight);
$Mobile=$_POST["Mobile"];
$Mobile=test_input($Mobile);


$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);
$Photo= $_FILES['photo']['name'];
$Photo= test_input($Photo);

$target_path = "CdPic/";
        $target_path1 = $target_path . basename($_FILES['photo']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
      }  catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

     $user = $db->add_CDNo($DispatchedNo,$CDNo,$pmtMode,$ChargeableWeight,$Mobile,$User,$IP,$Photo);

        if ($user) {   
        $response["error"] = false;
        header('Location: http://139.59.38.160/Avenger/Dashboard/UpdateCDNo.php');
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