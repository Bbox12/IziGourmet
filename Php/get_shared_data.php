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
date_default_timezone_set("Asia/Kolkata");
$hour=date("H");
$date=date("Y-m-d");


try{
$server_ip="139.59.38.160";
  $response = array("Book_Ride_Now"=>array());
    
      $result =$conn->query("SELECT ID FROM  driver_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }



$Book_Ride_Now=$conn->query("SELECT b.Is_Running,b.No_of_seats,b.OTP,b.Unique_Ride_Code,b.From_Address,u.Name,b.From_Latitude,b.From_Longitude,b.To_Latitude,b.To_Longitude,b.To_Address
   FROM book_ride b INNER JOIN user_details u WHERE b.User_ID=u.ID AND b.Driver_ID=$uID AND b.Is_Paid=0  AND 
  b.Ride_Cancelled_by IS NULL  ");


 



  while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {
 $jsonRow_201=array(
   "Is_Running"=>$user1["Is_Running"], 
  "OTP"=>$user1["OTP"],  
       "No_of_seats"=>$user1["No_of_seats"],      
   "Name"=>$user1["Name"],
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