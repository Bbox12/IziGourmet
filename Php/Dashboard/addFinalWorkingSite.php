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

$filepath1=$filePath2=$filePath3=$filePath4=0;

if (isset($_POST['IDSubsubmenu'])){



$IDsubmenu=$_POST["IDsubmenu"];
$IDsubmenu=test_input($IDsubmenu);
 
$IDSubsubmenu=$_POST["IDSubsubmenu"];
$IDSubsubmenu=test_input($IDSubsubmenu);

 
$Brand=$_POST["Brand"];
$Brand=test_input($Brand);
 
$Name=$_POST["Name"];
$Name=test_input($Name);



 
$Weight=$_POST["Weight"];
$Weight=test_input($Weight);

 
$Unit=$_POST["Unit"];
$Unit=test_input($Unit);
 

 
$Description=$_POST["Description"];
$Description=test_input($Description);



 
$MRP=$_POST["MRP"];
$MRP=test_input($MRP);
 
$Price=$_POST["Price"];
$Price=test_input($Price);

 
$Discount=$_POST["Discount"];
$Discount=test_input($Discount);
 



$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);


 if (isset($_POST['vehicle1'])){
$vehicle1=$_POST["vehicle1"];
$vehicle1=test_input($vehicle1);
}else{
  $vehicle1='0';
$vehicle1=test_input($vehicle1);
}
 


  $Photo= $_FILES['photo']['name'];
  $Photo= test_input($Photo);

    $Photo1= $_FILES['photo1']['name'];
  $Photo1= test_input($Photo1);

    $Photo2= $_FILES['photo2']['name'];
  $Photo2= test_input($Photo2);

    $Photo3= $_FILES['photo3']['name'];
  $Photo3= test_input($Photo3);

$target_path = "products/";
        $target_path1 = $target_path . basename($_FILES['photo']['name']);

        $filepath1 = $target_path1;

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
      $target_path2 = $target_path . basename($_FILES['photo1']['name']);
          $filepath2 = "http://139.59.38.160/IziGourmet/Dashboard/".$target_path2;

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo1']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
      }  catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
      $target_path3 = $target_path . basename($_FILES['photo2']['name']);
          $filepath3 = "http://139.59.38.160/IziGourmet/Dashboard/".$target_path3;

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo2']['tmp_name'], $target_path3)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
      }  catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
      $target_path4 = $target_path . basename($_FILES['photo3']['name']);
          $filepath4 = "http://139.59.38.160/IziGourmet/Dashboard/".$target_path4;

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo3']['tmp_name'], $target_path4)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
      }  catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }


  $user = $db->addWorkingSiteFinal($vehicle1,$IDsubmenu,$IDSubsubmenu,$Brand,$Name,$Weight,$Unit,$Description,$MRP,$Price,$Discount,$filepath1,$filepath2,$filepath3,$filepath4,$User,$IP);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddFinalService.php');
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
          header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddFinalService.php');
    }

 
 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
       // header('Location: http://139.59.38.160/IziGourmet/Dashboard/AddFinalService.php');
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>