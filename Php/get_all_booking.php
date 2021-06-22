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
$response = array("book_ride"=>array());
 
    $book_ride=mysqli_query($conn, "SELECT OTP,Vehicle_choosen,Unique_ride,User_from,User_to,User_from_lat,User_from_long,User_to_lat,User_to_long,User_mobile,Stopped,Snapshot,Created_date,Created_time FROM book_ride WHERE Stopped=0");


 while ($user1 = mysqli_fetch_assoc($book_ride)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "Vehicle"=>$user1["Vehicle_choosen"],
               "Unique_id"=>$user1["Unique_ride"],
               "User_from"=>$user1['User_from'],
                "User_from_lat"=>$user1['User_from_lat'],
                 "User_from_long"=>$user1['User_from_long'],
               "User_to"=>$user1['User_to'],
                    "User_to_lat"=>$user1['User_to_lat'],
                         "User_to_long"=>$user1['User_to_long'],
                  "User_mobile"=>$user1['User_mobile'],
                  "Stopped"=>$user1['Stopped'],
                  "Snapshot"=>$user1['Snapshot'],
                  "Date_"=>$user1['Created_date'],
                  "Time_"=>$user1["Created_time"],
             
 );

array_push($response["book_ride"], $jsonRow_20);
  
}

echo json_encode($response);

} 
catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}
}



?>