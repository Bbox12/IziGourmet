<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 


if (isset($_POST['mobile'])){
 
    $mobile= $_POST['mobile'];
    $mobile=test_input($mobile);


    $from= $_POST['from'];
    $from=test_input($from);



date_default_timezone_set("Asia/Kolkata");
$hour=date("H");
$date=date("Y-m-d");


try{
$server_ip="139.59.38.160";
  $response = array("saved"=>array());
    
    
if($from==1){
  $saved=$conn->query("SELECT  `isHome`, `HomeAddress`, `HomeHouseNo`, `HomeLandMark`, `HomeZip` FROM `user_details` WHERE `ID`='$mobile' ");


  while ($user1 = mysqli_fetch_assoc($saved)) {
 $jsonRow_201=array(
   "Address"=>$user1["HomeAddress"], 
  "HouseNo"=>$user1["HomeHouseNo"],  
       "LandMark"=>$user1["HomeLandMark"],      
   "Zip"=>$user1["HomeZip"],

             );
array_push($response["saved"], $jsonRow_201);
  
}
}else {
  $saved=$conn->query("SELECT  `isWork`, `WorkAddress`, `WorkHouseNo`, `WorkLandMark`, `WorkZip` FROM `user_details` WHERE `ID`='$mobile' ");


  while ($user1 = mysqli_fetch_assoc($saved)) {
 $jsonRow_201=array(
   "Address"=>$user1["WorkAddress"], 
  "HouseNo"=>$user1["WorkHouseNo"],  
       "LandMark"=>$user1["WorkLandMark"],      
   "Zip"=>$user1["WorkZip"],

             );
array_push($response["saved"], $jsonRow_201);
  
}
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