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
$response = array("book_ride"=>array(),"driver_details"=>array(),"ride_detail"=>array(),"user_details"=>array(),"pick_place"=>array(),"drop_place"=>array());


  $pick_place=mysqli_query($conn, "SELECT DISTINCT User_from,User_mobile FROM stop_ride");
    $drop_place=mysqli_query($conn, "SELECT DISTINCT User_to,User_mobile FROM stop_ride");
    $book_ride=mysqli_query($conn, "SELECT * FROM stop_ride");
      $ride=mysqli_query($conn, "SELECT * FROM book_ride");
 $driver_details=mysqli_query($conn, "SELECT *FROM driver_details  ");
  $user_details=mysqli_query($conn, "SELECT * FROM user_details ");


 while ($user1 = mysqli_fetch_assoc($pick_place)) {

$jsonRow_20=array(
             
              "mobile"=>$user1['User_mobile'],
               "User_from"=>$user1['User_from'],
                      
 );

array_push($response["pick_place"], $jsonRow_20);
  
}


 while ($user1 = mysqli_fetch_assoc($drop_place)) {

$jsonRow_20=array(
             
              "mobile"=>$user1['User_mobile'],
               "User_to"=>$user1['User_to'],
                      
 );

array_push($response["drop_place"], $jsonRow_20);
  
}
 while ($user1 = mysqli_fetch_assoc($book_ride)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "Vehicle"=>$user1["Vehicle_choosen"],
               "Unique_id"=>$user1["Unique_ride"],
               "User_from"=>$user1['User_from'],
               "User_to"=>$user1['User_to'],
                  "mobile"=>$user1['User_mobile'],
                  "Stopped"=>$user1['Stopped'],
             "Snapshot"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'APP'.'/'.'Snapshots'. '/'  .$user1['Snapshot'],
                  "Date_"=>$user1['Created_date'],
                  "Time_"=>$user1["Created_time"],
                      "drivermobile"=>$user1["Driver_mobile"] ,
                         "User_mobile"=>$user1["User_mobile"],
                           "start_time"=>$user1["Start_time"] ,
                         "end_time"=>$user1["End_time"],
                           "driver_rating"=>$user1["Driver_rating"] ,
                                      "cost"=>$user1["Cost"] ,
                                           "review"=>$user1["Review"] ,

                      
             
 );

array_push($response["book_ride"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($ride)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "Vehicle"=>$user1["Vehicle_choosen"],
               "Unique_id"=>$user1["Unique_ride"],
               "User_from"=>$user1['User_from'],
               "User_to"=>$user1['User_to'],
                  "mobile"=>$user1['User_mobile'],
                  "Stopped"=>$user1['Stopped'],
                  "Snapshot"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'APP'.'/'.'Snapshots'. '/'  .$user1['Snapshot'],
                  "Date_"=>$user1['Created_date'],
                  "Time_"=>$user1["Created_time"],
                      "drivermobile"=>$user1["Driver_mobile"] ,
                         "User_mobile"=>$user1["User_mobile"],
                           "start_time"=>$user1["Start_time"] ,
                         "end_time"=>$user1["End_time"],
                           "driver_rating"=>$user1["Driver_rating"] ,
                              "cost"=>$user1["Cost"] ,
                                  "review"=>$user1["Review"] ,
             
 );

array_push($response["ride_detail"], $jsonRow_20);
  
}
 while ($user1 = mysqli_fetch_assoc($driver_details)) {

$jsonRow_201=array(
               
    "Driver_long"=>$user1["Driver_long" ],
  "Driver_lat"=>$user1["Driver_lat"],
    "Unique_id" =>$user1["Unique_id" ],
  "Driver_first_name"=>$user1["Driver_first_name" ],
  "Driver_last_name"=>$user1["Driver_last_name" ],
  "Driver_birthdate"=>$user1["Driver_birthdate" ],
  "Driver_phone"=>$user1["Driver_phone" ],
  "Driver_fcm"=>$user1["fcm_token"],
  "Driver_email"=>$user1["Driver_email" ],
  "Driver_cut"=>$user1["Driver_cut" ],
  "Driver_image"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Driver'. '/' .$user1["Driver_image" ],
  "Driver_address_1"=>$user1["Driver_address_1" ],
  "Driver_address_2"=>$user1["Driver_address_2" ],
  "Driver_city"=>$user1["Driver_city" ],
  "Driver_state"=>$user1["Driver_state" ],
  "Driver_country"=>$user1["Driver_country" ],
  "Driver_zip"=>$user1["Driver_zip" ],
  "Driver_pancard"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Pancard'. '/' .$user1["Driver_pancard" ],
  "Driver_addressproof"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Addressproof'. '/' .$user1["Driver_addressproof" ],
  "Driver_dl"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Dl'. '/' .$user1["Driver_dl" ],
  "Driver_aadhar"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Aadharcard'. '/' .$user1["Driver_aadhar" ],
  "Driver_check"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'DRIVER'.'/'.'images'. '/' .'Cancelcheck'. '/' .$user1["Driver_check" ],
    "Created_date"=>$user1["Created_date" ],
    "Created_time"=>$user1["Created_time" ],
     "Blocked"=>$user1["Blocked" ],
        "Imei_no"=>$user1["Imei_no" ],   
     "identity"=>$user1["Identification"], 
     
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
               "rating"=>$user1["Rating"],
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