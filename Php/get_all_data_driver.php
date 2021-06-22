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
$response = array("add_partner"=>array(),"app_version"=>array(),"driver_comment"=>array(),"driver_details"=>array(),"owner_details"=>array(),"vehicle_details"=>array(),"user_details"=>array(),"owner_login"=>array(),"driver_login"=>array(),"book_ride"=>array(),"ride_later"=>array(),"marks"=>array(),"stop_ride"=>array());
 
  $ride_later=mysqli_query($conn, "SELECT * FROM ride_later ");

  $add_partner=mysqli_query($conn, "SELECT * FROM add_partner ");

  $app_version=mysqli_query($conn, "SELECT * FROM app_version ");

  $driver_comment=mysqli_query($conn, "SELECT * FROM driver_comment  ");

  $driver_details=mysqli_query($conn, "SELECT *FROM driver_details  ");

  $owner_details=mysqli_query($conn, "SELECT * FROM owner_details ");

  $vehicle_details=mysqli_query($conn, "SELECT * FROM vehicle_detail ");

  $user_details=mysqli_query($conn, "SELECT * FROM user_details ");

  $owner_login=mysqli_query($conn, "SELECT * FROM owner_login ");

  $driver_login=mysqli_query($conn, "SELECT * FROM driver_login ");

   $book_ride=mysqli_query($conn, "SELECT * FROM book_ride WHERE Paid=0");

    $stop_ride=mysqli_query($conn, "SELECT * FROM book_ride WHERE Paid=1");

  $marks=mysqli_query($conn, "SELECT * FROM add_marks ");
 

 while ($user1 = mysqli_fetch_assoc($stop_ride)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "Unique_id"=>$user1["Unique_ride"],
              "drivermobile"=>$user1["Driver_mobile"] ,
               "mobile"=>$user1["User_mobile"] ,
               "User_from"=>$user1["User_from"],
               "User_to"=>$user1["User_to"],
                    "vehicle"=>$user1["Vehicle_choosen"],
                    "User_mobile"=>$user1["User_mobile"],
 );

array_push($response["stop_ride"], $jsonRow_20);
  
}
 while ($user1 = mysqli_fetch_assoc($marks)) {

$jsonRow_20=array(
             
             
               "email"=>$user1["Email"],
              "mode"=>$user1["Mode"],
               "stage"=>$user1["Stage"],
                  "marks"=>$user1["Marks"],
                   "topic"=>$user1["Topic"],
             
              
               );



array_push($response["marks"], $jsonRow_20);
  
}

 while ($user1 = mysqli_fetch_assoc($book_ride)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "Unique_id"=>$user1["Unique_ride"],
              "drivermobile"=>$user1["Driver_mobile"] ,
               "mobile"=>$user1["User_mobile"] ,
               "User_from"=>$user1["User_from"],
               "User_to"=>$user1["User_to"],
                    "vehicle"=>$user1["Vehicle_choosen"],
                    "User_mobile"=>$user1["User_mobile"],
 );

array_push($response["book_ride"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($ride_later)) {

$jsonRow_20=array(
             
             
               "otp"=>$user1["OTP"],
               "mobile"=>$user1["Mobile"],
              "from"=>$user1["From_address"] ,
               "to"=>$user1["To_address"] ,
   "to_lat"=>$user1["To_lat"],
              "to_long"=>$user1["To_long"] ,
               "date"=>$user1["Atdate"] ,
"time"=>$user1["Attime"] ,
);

array_push($response["ride_later"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($owner_login)) {

$jsonRow_20=array(
             
             
               "mobile"=>$user1["Owner_mobile"],
               "name"=>$user1["Owner_name"],

               "image"=>'http://' . $server_ip . '/' . 'OHO' . '/'.'OWNER'.'/'.'images'. '/' . 'Owner'. '/' .$user1["Owner_image"],
              
               );



array_push($response["owner_login"], $jsonRow_20);
  
}



while ($user1 = mysqli_fetch_assoc($driver_login)) {

$jsonRow_20=array(
             
             
               "mobile"=>$user1["Driver_mobile"],
               "name"=>$user1["Driver_name"],

               "image"=>'http://' . $server_ip . '/' . 'OHO' . '/'.'DRIVER'.'/'.'images'. '/' . 'Driver'. '/' .$user1["Driver_image"],
              
               );



array_push($response["driver_login"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($user_details)) {

$jsonRow_20=array(
             
             
               "mobile"=>$user1["Mobile"],
              "fcm"=>$user1["fcm_token"],
               "name"=>$user1["Name"],
                  "home"=>$user1["Home"],
              "work"=>$user1["Work"],
               "other"=>$user1["Other"],
              "remarks"=>$user1["Rating"],
               "image"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'APP'.'/'.'Profile'. '/' .$user1["Image"],
              
               );



array_push($response["user_details"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($add_partner)) {

$jsonRow_20=array(
             
               "partner_name"=>$user1["Name"],
               "partner_mobile"=>$user1["Mobile"],
                "partner_location"=>$user1["Location"],
                "partner_date"=>$user1["Created_date"],
                "partner_time"=>$user1["Created_time"],
               );



array_push($response["add_partner"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($app_version)) {

$jsonRow_20=array(
              
               "version"=>$user1["Version"],
             
   );
array_push($response["app_version"], $jsonRow_20);
  
}
while ($user1 = mysqli_fetch_assoc($driver_comment)) {

$jsonRow_20=array(
              
               "Mobile"=>$user1["Mobile"],
               "Comment"=>$user1["Comment"],
   );
array_push($response["driver_comment"], $jsonRow_20);
  
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
       "remarks"=>$user1["Rating"],
             );


array_push($response["driver_details"], array_unique($jsonRow_201));
  
}     
while ($user1 = mysqli_fetch_assoc($owner_details)) {

$jsonRow_201=array(
           
  "Unique_id"=>$user1["Unique_id"],
  "identity"=>$user1["Identification"],
  "Owner_first_name"=>$user1["Owner_first_name"],
  "Owner_last_name"=>$user1["Owner_last_name"],
  "Owner_birthdate"=>$user1["Owner_birthdate"],
  "Owner_phone"=>$user1["Owner_phone"],
    "Owner_fcm"=>$user1["fcm_token"],
  "Owner_email"=>$user1["Owner_email"],
  "Owner_image"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'OWNER'.'/'.'images'. '/' .'Owner'. '/' .$user1["Owner_image"],
  "Owner_address_1"=>$user1["Owner_address_1"],
  "Owner_address_2"=>$user1["Owner_address_2"],
  "Owner_city"=>$user1["Owner_city"],
  "Owner_state"=>$user1["Owner_state"],
  "Owner_country"=>$user1["Owner_country"],
  "Owner_zip"=>$user1["Owner_zip"],
  "Owner_pancard"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'OWNER'.'/'.'images'. '/' .'Pancard'. '/' .$user1["Owner_pancard"],
  "Owner_addressproof"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'OWNER'.'/'.'images'. '/' .'Addressproof'. '/' .$user1["Owner_addressproof"],
  "Owner_aadhar"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'OWNER'.'/'.'images'. '/' .'Aadharcard'. '/' .$user1["Owner_aadhar"],
  "Owner_check"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'OWNER'.'/'.'images'. '/' .'Cancelcheck'. '/' .$user1["Owner_check"],
    "Created_date"=>$user1["Created_date"],
    "Created_time"=>$user1["Created_time"],
              
              
             );


array_push($response["owner_details"], array_unique($jsonRow_201));
  
}                                           

while ($user1 = mysqli_fetch_assoc($vehicle_details)) {

$jsonRow_20=array(
              
                     "Unique_id"=>$user1["Unique_id"],

      "Vehicle_no"=>$user1["Vehicle_no"],
      "Vehicle_company"=>$user1["Vehicle_company"],
      "Vehicle_model"=>$user1["Vehicle_model"],
      "Vehicle_type"=>$user1["Vehicle_type"],
      "Vehicle_image_1"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'VEHICLE'.'/'.'images'. '/' .'Vehicle'. '/' .$user1["Vehicle_image_1"],
     
      "Vehicle_rc"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'VEHICLE'.'/'.'images'. '/' .'Rc'. '/' .$user1["Vehicle_rc"],
      "Vehicle_insurance"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'VEHICLE'.'/'.'images'. '/' .'Insurance'. '/' .$user1["Vehicle_insurance"],
      "Vehicle_permit"=>'http://' . $server_ip . '/' . 'OHO' . '/' .'VEHICLE'.'/'.'images'. '/' .'Permit'. '/' .$user1["Vehicle_permit"],
      "Created_date"=>$user1["Created_date"],
      "Created_time"=>$user1["Created_time"],
       "identity"=>$user1["Unique_driver"], 
             
   );
array_push($response["vehicle_details"], $jsonRow_20);
  
}

 
echo json_encode($response);


} 
catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}
}

?>