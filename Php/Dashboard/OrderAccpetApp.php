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



 $Name=$_GET["name"];
$Name=test_input($Name);



$Vehicle=$_GET["vehicle"];
$Vehicle=test_input($Vehicle);

$datas=$_GET["date"];
$datas=test_input($datas);
 


if(isset($_GET['time'])){

$times=$_GET["time"];
$times=test_input($times);

}else{
  $times="";
$times=test_input($times);
}


 $ETR=$datas.$times;
$ETR=test_input($ETR);
 
$id=$_GET["id"];
$id=test_input($id);

$User= "";
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);


if (isset($_GET['damt'])){
$damt=$_GET["damt"];
$damt=test_input($damt);
}else{
  $damt="0";
$damt=test_input($damt);
}

  



     $user = $db->acceptedOrderApp($id,$Name,$Vehicle,$ETR,$datas,$times,$User,$IP,$damt);
             if ($user) {  
          $_SESSION["error"]=1;
        $response["error"] = false;


    } else  {
            $_SESSION["error"]=2;
            $response["error"] = true;

    }

 
 

    



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;

}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>