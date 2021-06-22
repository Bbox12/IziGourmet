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
$response = array("driver_details"=>array(),"user_details"=>array(),"book_ride"=>array());
 
$driver_details=mysqli_query($conn, "SELECT Driver_phone,Driver_lat,Driver_long,Rating FROM driver_details WHERE Identification>0 AND Unique_id!=''  ");

 $user_details=mysqli_query($conn, "SELECT * FROM user_details ");

 $book_ride=mysqli_query($conn, "SELECT User_mobile,Driver_mobile,Unique_ride,User_from,User_to ,User_from_lat,User_from_long,User_to_lat,User_to_long,Vehicle_choosen FROM book_ride WHERE Stopped=0 ");


 while ($user1 = mysqli_fetch_assoc($book_ride)) {

$jsonRow_20=array(
             
          
               "Unique_id"=>$user1["Unique_ride"],
               "drivermobile"=>$user1["Driver_mobile"] ,
               "usermobile"=>$user1["User_mobile"] ,
                "User_from"=>$user1['User_from'],
               "User_to"=>$user1['User_to'],
               "User_from_lat"=>$user1['User_from_lat'],
                 "User_from_long"=>$user1['User_from_long'],
               "User_to"=>$user1['User_to'],
                    "User_to_lat"=>$user1['User_to_lat'],
                         "User_to_long"=>$user1['User_to_long'],
                 "Vehicle"=>$user1['Vehicle_choosen'],         
              
 );

array_push($response["book_ride"], $jsonRow_20);
  
}

 while ($user1 = mysqli_fetch_assoc($driver_details)) {

$jsonRow_201=array(
               
  
  "Driver_phone"=>$user1["Driver_phone" ],
  "Driver_lat"=>$user1["Driver_lat"],
  "Driver_long"=>$user1["Driver_long"],
       "remarks"=>$user1["Rating"],
 
             );


array_push($response["driver_details"], array_unique($jsonRow_201));
  
}   

while ($user1 = mysqli_fetch_assoc($user_details)) {

$jsonRow_20=array(
             
             
               "mobile"=>$user1["Mobile"],
              "fcm"=>$user1["fcm_token"],
               "name"=>$user1["Name"],
                  "home"=>$user1["Home"],
              "work"=>$user1["Work"],
               "other"=>$user1["Other"],
               "remarks"=>$user1['Rating'],
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