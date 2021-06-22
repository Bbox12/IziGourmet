<?php

header('Content-Type: application/json');
     require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();


if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 

 $server_ip="139.59.38.160";

try{
$response = array("rechargepoint"=>array());
 


$rechargepoint=mysqli_query($conn, "SELECT `ID`, `Name`, `Address`, `Phone_No`, `Latitude`, `Longitude` FROM recharge_point WHERE Verified_by!='' AND Verified_by IS NOT NULL  ");


 while ($user1 = mysqli_fetch_assoc($rechargepoint)) {
 $jsonRow_201=array(

   "ID"=>$user1["ID"],
  "Phone_No"=>$user1["Phone_No"],
  "Name"=>$user1["Name"],
   "Address"=>$user1["Address"],
  "Latitude"=>$user1["Latitude"],
   "Longitude"=>$user1["Longitude"],
  
  );
  
array_push($response["rechargepoint"], $jsonRow_201);
  
} 



echo json_encode($response);


} 

catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}
}



?>