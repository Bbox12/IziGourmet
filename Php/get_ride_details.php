<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 

if (isset($_POST['Unique_Ride_Code'])){
 
        $Unique_Ride_Code= $_POST['Unique_Ride_Code'];
   

       $Unique_Ride_Code=test_input($Unique_Ride_Code);



try{
$server_ip="139.59.38.160";
  $response = array("ride"=>array(),"rating_remarks"=>array());

   $result =$conn->query("SELECT ID FROM  book_ride WHERE Unique_Ride_Code='$Unique_Ride_Code'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }

            $ride=$conn->query( "SELECT 
              d.Photo AS userPic
              ,d.Name AS userName
              ,d.Phone_No AS userMobile
              
    ,r.OTP
    ,r.Distance_Travel
    ,r.Unique_Ride_Code
    ,r.From_Address
    ,r.To_Address
    ,r.From_Latitude
     , r.From_Longitude
         ,r.To_Latitude
         ,r.Cost
    ,r.To_Longitude
    ,r.To_Address
    ,r.From_Latitude
     , r.From_Longitude
     ,dd.Name
    ,dd.Photo
     , dd.Phone_No
     , dd.Rating
       ,v.Vehicle_No
    ,v.Vehicle_Photo_1
  
FROM user_details d
INNER JOIN  book_ride r
    on d.ID = r.User_ID
    INNER JOIN  driver_details dd
    on r.Driver_ID = dd.ID
    INNER JOIN  vehicle_detail v
    on v.Driver_ID = dd.ID
WHERE  r.ID='$uID' GROUP BY r.ID");


$rating=$conn->query( "SELECT `ID`, `Rating_limit`, `Rating_comments`, `Date`, `Time`, `User`, `IP` FROM `rating_remarks`");


while ($user1 = mysqli_fetch_assoc($rating)) {
 $jsonRow_201=array(


 "ID"=>$user1["ID"],
    "Rating_limit"=>$user1["Rating_limit"],
    "Rating_comments"=>$user1["Rating_comments"],
    );
array_push($response["rating_remarks"], $jsonRow_201);
  
}

while ($user1 = mysqli_fetch_assoc($ride)) {

$jsonRow_201=array(

  "userPic"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'USER'. '/' .$user1["userPic"],
  "userMobile"=>$user1["userMobile"],
   "userName"=>$user1["userName" ],         
  "OTP"=>$user1["OTP"],
  "Cost"=>$user1["Cost"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
   "From_Address"=>$user1["From_Address" ],
  "To_Address"=>$user1["To_Address" ],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude" ],
  "Distance_Travel"=>$user1["Distance_Travel" ],
  "Name"=>$user1["Name"],
  "Phone_No"=>$user1["Phone_No" ],
  "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'DRIVER'. '/' .$user1["Photo"] ,
  "Rating"=>$user1["Rating" ],
  "Vehicle_No"=>$user1["Vehicle_No"],
  "Vehicle_Photo_1"=>'http://' . $server_ip . '/' . 'eTez' .'/'.'Profile'. '/' .'VEHICLE'. '/' .$user1["Vehicle_Photo_1"] ,
   
 );

array_push($response["ride"], $jsonRow_201);
  
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