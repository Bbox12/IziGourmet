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

if (isset($_POST['firstName'])&& isset($_POST['PhoneNo'])){


$id=0;

 
 
$firstName=$_POST["firstName"];
$firstName=test_input($firstName);
$lastName=$_POST["lastName"];
$lastName=test_input($lastName);
$email=$_POST["email"];
$email=test_input($email);
$PhoneNo=$_POST["PhoneNo"];
$PhoneNo=test_input($PhoneNo);
$role=$_POST["role"];
$role=test_input($role);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);
$Photo= $_FILES['photo']['name'];
$Photo= test_input($Photo);



$target_path = "staffpic/";
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

     if (isset($_POST['id'])){
    $id=$_POST["id"];
     $user = $db->UpdateStaff($id,$firstName,$lastName,$email,$PhoneNo,$User,$IP,$Photo,$role);
        if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
        if($_SESSION["admin"]!=1){
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/EditStaff.php');
        }else{
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/admin.php');
        }
      
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
         if($_SESSION["admin"]!=1){
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/EditStaff.php');
        }else{
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/admin.php');
        }
    }
  }else{
     $user = $db->addStaff($firstName,$lastName,$email,$PhoneNo,$User,$IP,$Photo,$role);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
      if($_SESSION["admin"]!=1){
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/EditStaff.php');
        }else{
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/admin.php');
        }
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
     if($_SESSION["admin"]!=1){
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/EditStaff.php');
        }else{
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/admin.php');
        }
    }

  }

 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/staff_registration.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>