<?php

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "9954059912aA";
$dbname = "eTez";

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
$response = array("Settings"=>array(),"Book_Ride_Now_User"=>array(),"Version"=>array(),"User"=>array(),
  "Contacts"=>array(),"Vehicle_Rate"=>array(),"Book_Ride_Later"=>array(),"Master_Vehicle_Type"=>array()
  ,"TAXES"=>array(),"Owner_Details"=>array(),"Driver_Details"=>array(),"Version_driver"=>array(),
  "Vehicle_detail"=>array(),"Vehicle_Type"=>array(),"Vehicle_Model"=>array(),"Book_Ride_Now"=>array(),"Vehicle_Company"=>array(),"Emergency_contacts"=>array(),"Promo_codes"=>array(),"hellocab_elite_plans"=>array(),
   "Book_Ride_past_driver"=>array(),"address_proof_documents"=>array(),"Book_Ride_Past"=>array(),"Book_Ride_Past_To_address"=>array(),"Book_Ride_Past_From_address"=>array(),"rating_remarks"=>array());
 
$settings=mysqli_query($conn, "SELECT `ID`, `Service_Online`, `Tracking_Interval_Seconds_for_Rides`, `Tracking_Interval_Seconds_for_Driver`, `Tracking_Interval_Seconds_for_User`, `Minimum_Distance_in_Meter_for_Tracking`, `Default_Auto_Ride_Promo`, `Minimum_Rides_for_Auto_Promo`, `Minimum_KM_Distance_for_Outstation`, `Outstation_Driver_Allowance_Per_Day`, `Ride_Later_Booking_Advance_Amount`,`User_refernce_code_coupon_Amt` FROM `setting_defaults` ORDER BY `ID` DESC LIMIT 1");

$rating_remarks=mysqli_query($conn, "SELECT `ID`, `Rating_limit`, `Rating_comments`, `Date`, `Time`, `User`, `IP` FROM `rating_remarks`");

$Version=mysqli_query($conn, "SELECT `ID`, `Version`, `Importance`, `Date`, `Time`, `User`, `IP` FROM `app_version` ORDER BY `ID` DESC LIMIT 1");

$Version_driver=mysqli_query($conn, "SELECT `ID`, `Version`, `Importance`, `Date`, `Time`, `User`, `IP` FROM `app_version_driver` ORDER BY `ID` DESC LIMIT 1");

$User=mysqli_query($conn, "SELECT `ID`, `Name`, `Email`, `Photo`, `Phone_No`, `Address`, `Country`, `State`, `City`, `Pin`, `Latitude`, `Longitude`, `Favorite_Home_Address`, `Favourite_Work_Address`, `Favourite_Other_Address`, `Rating`, `Reference_Code`,`User_Referrence_Code`, `Firebase_Token`, `Date`, `Time`, `User`, `IP` FROM `user_details`");

$contacts=mysqli_query($conn, "SELECT User_ID,Contact_Name,Contact_Phone_No,`Date`,`Time` FROM users_emergency_contacts");


$Promo_codes=mysqli_query($conn, "SELECT `Promo_Code`, `Promo_Type`, `Discount_Type`, `Discount_Value`, `Start_Date`, `End_Date`, `Drop_Location`, `App_Invitation`, `Applicable_Place`, `Remarks`, `Status`, `Date`, `Time`, `User`, `IP` FROM `promo_codes`  WHERE '$date' BETWEEN `Start_Date` AND `End_Date` AND Status=1");

$field=$hour."-".date('H', strtotime('+1 hour'))."_hr" ;



$Vehicle_normal_Rate=mysqli_query($conn, "SELECT master.`ID`, master.`Vehicle_Type`,  

  CASE WHEN IFNULL(daily.`Minimum_Fare`, master.`Minimum_Fare`)<=0 THEN master.`Minimum_Fare` else IFNULL(daily.`Minimum_Fare`, master.`Minimum_Fare`) END AS Minimum_Rate ,

 CASE WHEN IFNULL(daily.`$field`, master.`$field`)<=0 THEN master.`$field` else IFNULL(daily.`$field`, master.`$field`) END AS Hourly_Rate FROM vehicle_daily_rates as daily


  RIGHT JOIN `vehicle_type_rate_master` AS master  ON master.`Vehicle_Type` = daily.`Vehicle_Type` WHERE daily.Date_of_Rate = '$date'  

  UNION 

  SELECT master.`ID`, master.`Vehicle_Type`, master.`Minimum_Fare` AS Minimum_Rate ,master.`$field` AS Hourly_Rate FROM `vehicle_type_rate_master` AS master WHERE master.Vehicle_Type NOT IN (SELECT Vehicle_Type FROM vehicle_daily_rates AS daily WHERE daily.Date_of_Rate ='$date' )");



$Book_Ride_Later=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=1 ORDER BY `Start_Date` ASC");

$Book_Ride_Now=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`,`Cost`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0 AND Is_Paid=0 AND 
  Ride_Cancelled_by IS NULL ");

$Book_Ride_Now_User=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0  AND 
  Ride_Cancelled_by IS NULL AND User_Review IS NULL AND Is_Paid=1 ");

$Book_Ride_past_driver=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0 AND 
  Ride_Cancelled_by IS NULL ");

$Book_Ride_Past=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Ride_Cancelled_by`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0 ");

$Book_Ride_Past_To_address=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0 AND Is_Paid=1 GROUP BY `To_Address`");

$Book_Ride_Past_From_address=mysqli_query($conn, "SELECT `ID`, `Is_Running`, `OTP`, `Unique_Ride_Code`, `User_ID`, `Driver_ID`, `Vehicle_ID`, `From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude`, `Booking_Date`, `Booking_Time`, `Driver_Accepted_Date`, `Driver_Accepted_Time`, `Start_Date`, `Start_time`, `End_Date`, `End_time`, `Map_Snapshot`, `Distance_Travel`, `Cost`, `User_Rating_By_Driver`, `Driver_Rating_By_User`, `User_Review`, `Driver_Review`, `is_Ride_Later`, `Is_Roudtrip`, `Return_date`, `Return_time`, `Is_Paid`, `Date`, `Time`, `User`, `IP` FROM `book_ride` WHERE is_Ride_Later=0 AND Is_Paid=1 GROUP BY `From_Address`");

$Master_Vehicle_Type=mysqli_query($conn, "SELECT  `Vehicle_Type`, `Minimum_Fare` FROM `vehicle_type_rate_master`");

$TAXES=mysqli_query($conn, "SELECT `ID`, `Tax_Name`, `Tax_Percentage`, `Applicable`, `Sort_Order`, `date`, `time`, `user`, `IP` FROM `tax_definations` WHERE `Applicable`=1");


$Owner_Details=mysqli_query($conn, "SELECT `ID`, `Owner_OTP`, `Name`, `Date_Of_Birth`, `Phone_No`, `Email`, `Photo`, `Address`, `Country`, `State`, `City`, `Pin`, `Pancard_No`, `Pancard_Photo`, `Addressproof_Document`, `Addressproof_No`, `Addressproof_Photo`, `Aadhar_Card_No`, `Aadhar_Card_Photo`, `Cancel_Cheque_No`, `Cancel_Cheque_Photo`, `Bank_Name`, `Branch_Name`, `Bank_Account_Number`, `IFSC_Code`, `Verified_By`, `Verified_Date`, `Verified_Remarks`, `App_Install_Date`, `App_Install_Time`, `Firebase_Token`, `Date`, `Time`, `User`, `IP` FROM `owner_details`");


$Driver_Details=mysqli_query($conn, "SELECT `ID`, `Driver_OTP`, `Owner_ID`, `Name`, `Date_Of_Birth`, `Phone_No`, `Email`, `Identification_Mark`, `Photo`, `Address`, `Country`, `State`, `City`, `Pin`, `Pancard_No`, `Pancard_Photo`, `Addressproof_Document`, `Addressproof_No`, `Addressproof_Photo`, `Driving_License_No`, `Driving_License_Photo`, `Aadhar_Card_No`, `Aadhar_Card_Photo`, `Cancel_Cheque_No`, `Cancel_Cheque_Photo`, `Bank_Name`, `Branch_Name`, `Bank_Account_Number`, `IFSC_Code`, `Verified_By`, `Verified_Date`, `Verified_Remarks`, `Rating`, `Is_Blocked`, `App_Install_Date`, `App_Install_Time`, `Firebase_Token`, `Date`, `Time`, `User`, `IP` FROM `driver_details`");

$Vehicle_detail=mysqli_query($conn, "SELECT `ID`,`Minimum_Balance_Status`, `Driver_ID`, `Vehicle_No`, `Vehicle_Photo_1`, `Vehicle_Photo_2`, `Registration_Certificate_No`, `Registration_Certificate_Photo`, `Date`, `Time`, `User`, `IP` FROM `vehicle_detail`");

$Vehicle_Type=mysqli_query($conn, "SELECT  `ID`,`Vehicle_Type` FROM `vehicle_type_rate_master`");

$Vehicle_Model=mysqli_query($conn, "SELECT  `ID`,`Vehicle_Company`, `Vehicle_Model`, `Vehicle_Type` FROM `vehicle_models`");

$Vehicle_Company=mysqli_query($conn, "SELECT  `ID`, `Vehicle_Company` FROM vehicle_manufacturer
");

$Emergency_contacts=mysqli_query($conn, "SELECT `ID`, `User_ID`, `Contact_Name`, `Contact_Phone_No`, `Date`, `Time`, `User`, `IP` FROM `users_emergency_contacts` 
");

$hellocab_elite_plans=mysqli_query($conn, " SELECT`ID`, `Plan_Name`, `Amount`, `Validity_in_Days`, `Description`, `Sort_Order`, `Title`, `Meta_Tag_Keywords`, `Meta_Tag_Description`, `Facebook_OG_Tag`, `Twitter_Tag`, `Google_Analytics`, `Custom_Code`, `UD1`, `UD2`, `UD3`, `UD4`, `UD5`, `publish`, `date`, `time`, `user`, `IP` FROM `hellocab_elite_plans`
");

$address_proof_documents=mysqli_query($conn, " SELECT `ID`, `Document_Name`, `Sort_Order`, `Active` FROM `address_proof_documents` WHERE Active=1");


while ($user1 = mysqli_fetch_assoc($rating_remarks)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "Rating_limit"=>$user1["Rating_limit"],
    "Rating_comments"=>$user1["Rating_comments"],
    );
array_push($response["rating_remarks"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($address_proof_documents)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "Document_Name"=>$user1["Document_Name"],
    
   
             );
array_push($response["address_proof_documents"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($hellocab_elite_plans)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "Plan_Name"=>$user1["Plan_Name"],
     "Amount"=>$user1["Amount"],
    "Validity_in_Days"=>$user1["Validity_in_Days"],
     "Description"=>$user1["Description"],
  
   
             );
array_push($response["hellocab_elite_plans"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($Promo_codes)) {
 $jsonRow_201=array(


 "Promo_Code"=>$user1["Promo_Code"],
    "Promo_Type"=>$user1["Promo_Type"],
     "Discount_Type"=>$user1["Discount_Type"],
    "Discount_Value"=>$user1["Discount_Value"],
     "Start_Date"=>$user1["Start_Date"],
    "End_Date"=>$user1["End_Date"],
     "Drop_Location"=>$user1["Drop_Location"],
    "App_Invitation"=>$user1["App_Invitation"],
   "Applicable_Place"=>$user1["Applicable_Place"],
     "Remarks"=>$user1["Remarks"],
    "Status"=>$user1["Status"],
   
             );
array_push($response["Promo_codes"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($Emergency_contacts)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "User_ID"=>$user1["User_ID"],
     "Contact_Name"=>$user1["Contact_Name"],
    "Contact_Phone_No"=>$user1["Contact_Phone_No"],
  
             );
array_push($response["Emergency_contacts"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($Vehicle_Company)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "Vehicle_Company"=>$user1["Vehicle_Company"],
  
             );
array_push($response["Vehicle_Company"], $jsonRow_201);
  
} 
 while ($user1 = mysqli_fetch_assoc($Vehicle_Model)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
  "Vehicle_Type"=>$user1["Vehicle_Type"],
   "Vehicle_Model"=>$user1["Vehicle_Model"],
    "Vehicle_Company"=>$user1["Vehicle_Company"],
  
             );
array_push($response["Vehicle_Model"], $jsonRow_201);
  
} 



 while ($user1 = mysqli_fetch_assoc($Vehicle_Type)) {
 $jsonRow_201=array(

 "ID"=>$user1["ID"],
  "Vehicle_Type"=>$user1["Vehicle_Type"],
  
             );
array_push($response["Vehicle_Type"], $jsonRow_201);
  
} 


 while ($user1 = mysqli_fetch_assoc($Vehicle_detail)) {
 $jsonRow_201=array(

   "ID"=>$user1["ID" ],
      "Minimum_Balance_Status"=>$user1["Minimum_Balance_Status"],
   "Driver_ID"=>$user1["Driver_ID"],
  "Vehicle_No"=>$user1["Vehicle_No"],
  "Vehicle_Photo_1"=>'http://' . $server_ip . '/' . 'eTez' .'/'.'Profile'. '/' .'VEHICLE'. '/' .$user1["Vehicle_Photo_1"] ,
    "Vehicle_Photo_2"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'VEHICLE'. '/' .$user1["Vehicle_Photo_2"] ,
    
  "Registration_Certificate_No"=>$user1["Registration_Certificate_No"],
   "Registration_Certificate_Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'VEHICLE'. '/' .'RC'. '/' .$user1["Registration_Certificate_Photo" ],

   );
  
array_push($response["Vehicle_detail"], $jsonRow_201);
  
} 


 while ($user1 = mysqli_fetch_assoc($Driver_Details)) {
 $jsonRow_201=array(

   "ID"=>$user1["ID" ],
  "Driver_OTP"=>$user1["Driver_OTP"],
   "Owner_ID"=>$user1["Owner_ID"],
  "Name"=>$user1["Name"],
   "Date_Of_Birth"=>$user1["Date_Of_Birth" ],
  "Phone_No"=>$user1["Phone_No" ],
  "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'DRIVER'. '/' .$user1["Photo"] ,
  "Email"=>$user1["Email"],
   "Identification_Mark"=>$user1["Identification_Mark" ],
    "Address"=>$user1["Address"],
   "Country"=>$user1["Country" ],
     "State"=>$user1["State" ],
  "City"=>$user1["City"],
  "State"=>$user1["State"],
   "Pin"=>$user1["Pin" ],
    "Driving_License_No"=>$user1["Driving_License_No" ],
    "Driving_License_Photo"=>$user1["Driving_License_Photo" ],
  "Pancard_No"=>$user1["Pancard_No" ],
    "Pancard_Photo"=>$user1["Pancard_Photo" ],
    "Addressproof_Document"=>$user1["Addressproof_Document" ],
     "Addressproof_No"=>$user1["Addressproof_No" ],
    "Addressproof_Photo"=>$user1["Addressproof_Photo" ],
     "Aadhar_Card_No"=>$user1["Aadhar_Card_No" ],
     "Aadhar_Card_Photo"=>$user1["Aadhar_Card_Photo" ],
    "Cancel_Cheque_No"=>$user1["Cancel_Cheque_No" ],
    "Cancel_Cheque_Photo"=>$user1["Cancel_Cheque_Photo" ],
     "Bank_Name"=>$user1["Bank_Name" ],
    "Branch_Name"=>$user1["Branch_Name" ],
     "Bank_Account_Number"=>$user1["Bank_Account_Number" ],
 "IFSC_Code"=>$user1["IFSC_Code" ],
  "Rating"=>$user1["Rating" ],
    "Verified_By"=>$user1["Verified_By" ],
    "Firebase_Token"=>$user1["Firebase_Token" ],);
  
array_push($response["Driver_Details"], $jsonRow_201);
  
} 

 while ($user1 = mysqli_fetch_assoc($Owner_Details)) {
 $jsonRow_201=array(

  "ID"=>$user1["ID" ],
  "Owner_OTP"=>$user1["Owner_OTP"],
  "Name"=>$user1["Name"],
  "Date_Of_Birth"=>$user1["Date_Of_Birth"],
  "Phone_No"=>$user1["Phone_No" ],
  "Email"=>$user1["Email"],
  "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'OWNER'. '/' .$user1["Photo"] ,
  "Address"=>$user1["Address"],
  "Country"=>$user1["Country" ],
  "State"=>$user1["State" ],
  "City"=>$user1["City"],
  "State"=>$user1["State"],
  "Pin"=>$user1["Pin" ],
  "Pancard_No"=>$user1["Pancard_No" ],
    "Pancard_Photo"=>$user1["Pancard_Photo" ],
    "Addressproof_Document"=>$user1["Addressproof_Document" ],
    "Addressproof_No"=>$user1["Addressproof_No" ],
    "Addressproof_Photo"=>$user1["Addressproof_Photo" ],
    "Aadhar_Card_No"=>$user1["Aadhar_Card_No" ],
    "Aadhar_Card_Photo"=>$user1["Aadhar_Card_Photo" ],
    "Cancel_Cheque_No"=>$user1["Cancel_Cheque_No" ],
    "Cancel_Cheque_Photo"=>$user1["Cancel_Cheque_Photo" ],
    "Bank_Name"=>$user1["Bank_Name" ],
    "Branch_Name"=>$user1["Branch_Name" ],
    "Bank_Account_Number"=>$user1["Bank_Account_Number" ],
    "IFSC_Code"=>$user1["IFSC_Code" ],
    "Verified_By"=>$user1["Verified_By" ],
  
    "Firebase_Token"=>$user1["Firebase_Token" ],
    );
  
array_push($response["Owner_Details"], $jsonRow_201);
  
} 


 while ($user1 = mysqli_fetch_assoc($TAXES)) {
 $jsonRow_201=array(

  "Tax_Name"=>$user1["Tax_Name"],
  "Tax_Percentage"=>$user1["Tax_Percentage"],
  
  
             );
array_push($response["TAXES"], $jsonRow_201);
  
} 






 while ($user1 = mysqli_fetch_assoc($Master_Vehicle_Type)) {
 $jsonRow_201=array(

  "Vehicle_Type"=>$user1["Vehicle_Type"],
  "Minimum_Fare"=>$user1["Minimum_Fare"],
  
  
             );
array_push($response["Master_Vehicle_Type"], $jsonRow_201);
  
} 

  while ($user1 = mysqli_fetch_assoc($Book_Ride_Past)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
    "Ride_Cancelled_by"=>$user1["Ride_Cancelled_by" ],
  
             );
array_push($response["Book_Ride_Past"], $jsonRow_201);
  
}


  while ($user1 = mysqli_fetch_assoc($Book_Ride_Past_From_address)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_Past_From_address"], $jsonRow_201);
  
}


  while ($user1 = mysqli_fetch_assoc($Book_Ride_Past_To_address)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_Past_To_address"], $jsonRow_201);
  
}
  while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_Now"], $jsonRow_201);
  
}

 while ($user1 = mysqli_fetch_assoc($Book_Ride_Now_User)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_Now_User"], $jsonRow_201);
  
}


  while ($user1 = mysqli_fetch_assoc($Book_Ride_past_driver)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_past_driver"], $jsonRow_201);
  
}


  while ($user1 = mysqli_fetch_assoc($Book_Ride_Later)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
   "User_ID"=>$user1["User_ID"],
    "Driver_ID"=>$user1["Driver_ID"],
      "Vehicle_ID"=>$user1["Vehicle_ID"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Booking_Date"=>$user1["Booking_Date"],
  "Booking_Time"=>$user1["Booking_Time"],
   "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
  "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
   "Start_Date"=>$user1["Start_Date" ],
  "Start_time"=>$user1["Start_time" ],
   "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time" ],
   "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
   "Cost"=>$user1["Cost" ],
  "User_Rating_By_Driver"=>$user1["User_Rating_By_Driver" ],
    "Driver_Rating_By_User"=>$user1["Driver_Rating_By_User" ],
   "User_Review"=>$user1["User_Review" ],
  "Driver_Review"=>$user1["Driver_Review" ],
   "Cost"=>$user1["Cost" ],
    "is_Ride_Later"=>$user1["is_Ride_Later" ],
    "Is_Roudtrip"=>$user1["Is_Roudtrip" ],
     "Return_date"=>$user1["Return_date" ],
    "Return_time"=>$user1["Return_time" ],
  
             );
array_push($response["Book_Ride_Later"], $jsonRow_201);
  
}

  while ($user1 = mysqli_fetch_assoc($Vehicle_normal_Rate)) {
   $jsonRow_201=array(


  "ID"=>$user1["ID" ],
  "Vehicle_Type"=>$user1["Vehicle_Type"],
  "Minimum_Rate"=>$user1["Minimum_Rate"],
   "Hourly_Rate"=>$user1["Hourly_Rate" ],

 
             );
array_push($response["Vehicle_Rate"], $jsonRow_201);
  
} 


while ($user1 = mysqli_fetch_assoc($contacts)) {
$jsonRow_201=array(
               
  "ID"=>$user1["User_ID" ],
  "Contact_Name"=>$user1["Contact_Name"],
  "Contact_Phone_No"=>$user1["Contact_Phone_No"],
 
             );
array_push($response["Contacts"], $jsonRow_201);
  
} 

while ($user1 = mysqli_fetch_assoc($User)) {

$jsonRow_20=array(
             
           "ID"=>$user1["ID"],
               "Name"=>$user1["Name"],
               "Email"=>$user1["Email"] ,
               "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Menu'. '/' .$user1["Photo"] ,
                "Phone_No"=>$user1['Phone_No'],
               "Address"=>$user1['Address'],
               "Country"=>$user1['Country'],
                 "State"=>$user1['State'],
               "City"=>$user1['City'],
                    "Pin"=>$user1['Pin'],
                         "Latitude"=>$user1['Latitude'],
                           "Longitude"=>$user1['Longitude'],
                    "Favourite_Other_Address"=>$user1['Favourite_Other_Address'],
                         "Favourite_Work_Address"=>$user1['Favourite_Work_Address'],
                          "Favorite_Home_Address"=>$user1['Favorite_Home_Address'],
                         "Rating"=>$user1['Rating'],
                         "Reference_Code"=>$user1['Reference_Code'],
                 "Firebase_Token"=>$user1['Firebase_Token'],
                "User_Referrence_Code"=>$user1['User_Referrence_Code'],
              
              
 );

array_push($response["User"], $jsonRow_20);
  
}



while ($user1 = mysqli_fetch_assoc($settings)) {

$jsonRow_20=array(
             
          
               "Service_Online"=>$user1["Service_Online"],
               "Tracking_Interval_Seconds_for_User"=>$user1["Tracking_Interval_Seconds_for_User"] ,
               "Tracking_Interval_Seconds_for_Driver"=>$user1["Tracking_Interval_Seconds_for_Driver"] ,
                "Tracking_Interval_Seconds_for_Rides"=>$user1['Tracking_Interval_Seconds_for_Rides'],
               "Minimum_Distance_in_Meter_for_Tracking"=>$user1['Minimum_Distance_in_Meter_for_Tracking'],
               "Minimum_Rides_for_Auto_Promo"=>$user1['Minimum_Rides_for_Auto_Promo'],
                 "Minimum_KM_Distance_for_Outstation"=>$user1['Minimum_KM_Distance_for_Outstation'],
               "Outstation_Driver_Allowance_Per_Day"=>$user1['Outstation_Driver_Allowance_Per_Day'],
                    "Ride_Later_Booking_Advance_Amount"=>$user1['Ride_Later_Booking_Advance_Amount'],
                         "Default_Auto_Ride_Promo"=>$user1['Default_Auto_Ride_Promo'],
                       "User_refernce_code_coupon_Amt"=>$user1['User_refernce_code_coupon_Amt'],
              
 );

array_push($response["Settings"], $jsonRow_20);
  
}


while ($user1 = mysqli_fetch_assoc($Version)) {

$jsonRow_20=array(
               "Version"=>$user1["Version"],
               "Importance"=>$user1["Importance"] ,
              
             );

array_push($response["Version"], $jsonRow_20);
  
}


while ($user1 = mysqli_fetch_assoc($Version_driver)) {

$jsonRow_20=array(
               "Version"=>$user1["Version"],
               "Importance"=>$user1["Importance"] ,
              
             );

array_push($response["Version_driver"], $jsonRow_20);
  
}
echo json_encode($response);


} 

catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}
}



?>