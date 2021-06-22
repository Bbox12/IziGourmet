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

$User= $_SESSION["email"];
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

  



     $user = $db->acceptedOrder($id,$Name,$Vehicle,$ETR,$datas,$times,$User,$IP,$damt);
             if ($user) {  
  require_once 'DB_Connect.php';
        // connecting to database
        $dbs = new Db_Connect();
        $conn = $dbs->connect();
        $server_ip="139.59.38.160";
              $result =$conn->query("SELECT Name,Phone_No,Photo FROM  user_details WHERE ID=$Name");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $Names=$row["Name"];
               $PhoneNo=$row["Phone_No"];
                 $Photo='http://' . $server_ip . '/' . 'IziGourmet'.'/'.'Menu'. '/' .$row["Photo"];
        }
         }
          $_SESSION["error"]=1;
        $response["error"] = false;
                $unique=$user["Unique_Ride_Code"];

                 
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/latlongFCM.php?unique='.$unique.'&name='.$Names.'&mobile='.$PhoneNo.'&vehicle='.$Vehicle.'&ETR='.$ETR.'&Photo='.$Photo.'&damt='.$damt);
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