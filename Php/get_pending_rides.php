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
     
try{
$server_ip="139.59.38.160";
  $response = array("ride"=>array());


            $ride=$conn->query( "SELECT 
            r.From_Address
    ,r.To_Address
      ,r.No_of_seats
      ,r.From_Latitude
      ,r.From_Longitude
      ,r.To_Latitude
      ,r.To_Longitude
      ,r.OTP
              ,r.Unique_Ride_Code
      
     ,ud.Phone_No
     ,r.uMobile
   
  
FROM   book_ride r
    INNER JOIN  user_details ud
    on r.User_ID = ud.ID
WHERE  r.is_Ride_Later=0 AND r.Is_Paid=0 AND 
  r.Ride_Cancelled_by IS NULL AND r.Driver_Accepted_Date IS NULL ");




while ($user1 = mysqli_fetch_assoc($ride)) {

$jsonRow_201=array(

    "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
  "From_Address"=>$user1["From_Address"],
   "To_Address"=>$user1["To_Address"],         
  "UserMobile"=>$user1["Phone_No"],
  "OTP"=>$user1["OTP"],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
    "To_Latitude"=>$user1["To_Latitude"],
  "To_Longitude"=>$user1["To_Longitude"],
    "No_of_seats"=>$user1["No_of_seats"],
    "uMobile"=>$user1["uMobile"],
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