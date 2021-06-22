<?php

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "9954059912aA";
$dbname = "OHO";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
date_default_timezone_set("Asia/Kolkata");
$hour=date("H");
$date=date("Y-m-d");

$jsonRow_20=array();

if(!$conn){
   echo "Could not connect to DBMS";       
 }else {

 $server_ip="139.59.38.160";

try{
$response = array("user_details"=>array());
 


  $user_details=mysqli_query($conn, "SELECT * FROM user_details ");

 

while ($user1 = mysqli_fetch_assoc($user_details)) {

$jsonRow_20=array(
             
             
               "mobile"=>$user1["Mobile"],
              "fcm"=>$user1["fcm_token"],
               "name"=>$user1["Name"],
                  "home"=>$user1["Home"],
              "work"=>$user1["Work"],
               "other"=>$user1["Other"],
              "remarks"=>$user1["Rating"],
              "refer"=>$user1['Refer'],
               "image"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'APP'.'/'.'Profile'. '/' .$user1["Image"],
              
               );



array_push($response["user_details"], $jsonRow_20);
  
}

 
echo json_encode($response);


} 
catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}
}

?>