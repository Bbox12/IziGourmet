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

$address=$_POST["address"];
$address=test_input($address);

$phone=$_POST["phone"];
$phone=test_input($phone);


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


$Photo= $_FILES['photo']['name'];
$Photo= test_input($Photo);


    printf("bbb: %s.\n", $Photo);


        if(strlen($Photo)!=0){
        $target_path1 = $_SERVER['DOCUMENT_ROOT'] . "/IziGourmet/" ."/Menu/" . basename($_FILES['photo']['name']);
         

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_path1)) {
        
          $_SESSION["error"]=1;
         $response["error"] = true;
         // header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php');
        }else{
           $user = $db->postDeriver($Photo,$Name,$phone,$address,$state,$City,$Pin,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
        $ID=$user["error"]["ID"];
     header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php?id='.$ID);
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php');
    }
        }
      }  catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
  }else{
      $Photo="Driver.png";
  $Photo=test_input($Photo);
             $user = $db->postDeriver($Photo,$Name,$phone,$address,$state,$City,$Pin,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
  
    // header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php?id='.$ID);
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
         // header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php');
    }
  }



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
        header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddDrivers.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>