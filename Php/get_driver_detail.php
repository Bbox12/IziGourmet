<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 


if (isset($_POST['_mId'])){
 
    $mobile= $_POST['_mId'];
   
    $mobile=test_input($mobile);

 $date=date("Y-m-d");

try{
$server_ip="139.59.38.160";
  $response = array("login"=>array(),"Book_Ride_Now"=>array(),"vehicle"=>array(),"version"=>array());
    
      $result =$conn->query("SELECT ID FROM  driver_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }

           $version=mysqli_query($conn, "SELECT `ID`, `Version`, `Importance`, `Date`, `Time`, `User`, `IP` FROM `app_version_driver`");

          while ($user1 = mysqli_fetch_assoc($version)) {
   $jsonRow_201=array(
  "Version"=>$user1["Version"],
  "Importance"=>$user1["Importance"],

             );
array_push($response["version"], $jsonRow_201);
  
} 


            $login=$conn->query( "SELECT `ID`, `Driver_OTP`, `Owner_ID`, `Name`, `Date_Of_Birth`, `Phone_No`, `Email`, `Identification_Mark`, `Photo`, `Address`, `Country`, `State`, `City`, `Pin`, `Pancard_No`, `Pancard_Photo`, `Addressproof_Document`, `Addressproof_No`, `Addressproof_Photo`, `Driving_License_No`, `Driving_License_Photo`, `Valid_month`, `Valid_year`, `Aadhar_Card_No`, `Aadhar_Card_Photo`, `Cancel_Cheque_No`, `Cancel_Cheque_Photo`, `Bank_Name`, `Branch_Name`, `Bank_Account_Number`, `IFSC_Code`, `Verified_By`, `Verified_Date`, `Verified_Remarks`, `Rating`, `Is_Blocked`, `App_Install_Date`, `App_Install_Time`, `Firebase_Token`, `Date`, `Time`, `User`, `IP` FROM `driver_details` WHERE Phone_No=$mobile ");

  $vehicle=$conn->query( "SELECT `ID`, `Minimum_Balance_Status`, `Type`,`Driver_ID`, `Vehicle_No`, `Vehicle_Photo_1`, `Vehicle_Photo_2`, `Registration_Certificate_No`, `Registration_Certificate_Photo`, `Date`, `Time`, `User`, `IP` FROM `vehicle_detail` WHERE Driver_ID='$uID' ");

$Book_Ride_Now=$conn->query("SELECT `No_of_seats`, `Unique_Ride_Code`,`From_Address`, `To_Address`, `From_Latitude`, `From_Longitude`, `To_Latitude`, `To_Longitude` FROM `book_ride` WHERE Driver_ID=$uID  AND Is_Paid=0  AND 
  
  Ride_Cancelled_by IS NULL  ");


while ($user1 = mysqli_fetch_assoc($login)) {

$jsonRow_201=array(
             "ID"=>$user1["ID" ],
  "Name"=>$user1["Name"],
  "Phone_No"=>$mobile,
  "Photo"=>'http://' . $server_ip . '/' . 'eTez' . '/' .'Profile'. '/' .'DRIVER'. '/' .$user1["Photo"] ,
    "Driving_License_Photo"=>$user1["Driving_License_Photo" ],
  "Rating"=>$user1["Rating" ],
    "Verified_By"=>$user1["Verified_By" ],
     "Date"=>$date,
      "Identification_Mark"=>$user1["Identification_Mark"],
                        
                                "Email"=>$user1["Email"],
                                "Address"=>$user1["Address"],
                                "City"=>$user1["City"],
                                "Pin"=>$user1["Pin"],
                                "Date_Of_Birth"=>$user1["Date_Of_Birth"],
                                   
 );

array_push($response["login"], $jsonRow_201);
  
}

while ($user1 = mysqli_fetch_assoc($vehicle)) {

$jsonRow_201=array(
            
     "Minimum_Balance_Status"=>$user1['Minimum_Balance_Status'],
         "Vehicle_No"=>$user1['Vehicle_No'],
         "Type"=>$user1['Type'],
          "Registration_Certificate_Photo"=>$user1["Registration_Certificate_Photo" ],
           "Vehicle_Photo_1"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'.'/' .'VEHICLE'. '/' .$user1["Vehicle_Photo_1" ],
          
 );

array_push($response["vehicle"], $jsonRow_201);
  
}

  while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {
 $jsonRow_201=array(
           
 
  "No_of_seats"=>$user1["No_of_seats"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],

  
             );
array_push($response["Book_Ride_Now"], $jsonRow_201);
  
}

   echo json_encode($response);    

} catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}

}
}
 
    
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>