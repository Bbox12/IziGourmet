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

   $result =$conn->query("SELECT ID FROM  driver_details WHERE Phone_No='$mobile'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }

            $ride=$conn->query( "SELECT 
            r.From_Address
    ,r.To_Address
         ,r.Cost
         , r.Start_Date
            , r.Map_Snapshot
              ,r.Unique_Ride_Code
              ,r.User_Review
    ,r.Start_time
         ,r.End_Date
    ,r.End_time
         ,r.End_Date
          ,r.Ride_Cancelled_by
     ,dd.Name
    ,dd.Photo
     , dd.Phone_No
     , dd.Rating
  
FROM   book_ride r
    INNER JOIN  driver_details dd
    on r.Driver_ID = dd.ID
WHERE  dd.ID='$uID' ");




while ($user1 = mysqli_fetch_assoc($ride)) {

$jsonRow_201=array(

 "Map_Snapshot"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Snapshots'. '/' .$user1["Map_Snapshot"] ,
    "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
  "From_Address"=>$user1["From_Address"],
   "To_Address"=>$user1["To_Address" ],         
  "Cost"=>$user1["Cost"],
  "Cost"=>$user1["Cost"],
  "Start_Date"=>$user1["Start_Date"],
   "Start_time"=>$user1["Start_time" ],
  "End_Date"=>$user1["End_Date" ],
  "End_time"=>$user1["End_time"],
   "Name"=>$user1["Name"],
  "Phone_No"=>$user1["Phone_No" ],
  "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Profile'. '/' .'DRIVER'. '/' .$user1["Photo"],
  "Driver_Rating_By_User"=>$user1["Rating" ],
  "User_Review"=>$user1["User_Review"],
  "Ride_Cancelled_by"=>$user1["Ride_Cancelled_by"],
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