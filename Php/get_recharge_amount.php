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

	   $hour=date("H:i:sa");
        $date=date("Y-m-d");
 $result =$conn->query("SELECT ID FROM  driver_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }


  $response = array("rechargeamount"=>array(),"rechargehistory"=>array());


            $rechargeamount=$conn->query( "SELECT 
           v.Total_balance,
           v.Minimum_Balance_Status

   
  
FROM   vehicle_detail v
    INNER JOIN  driver_details d
    on v.Driver_ID = d.ID
WHERE  d.ID=$uID ");




while ($user1 = mysqli_fetch_assoc($rechargeamount)) {

$jsonRow_201=array(

    "Total_balance"=>$user1["Total_balance"],
  "Minimum_Balance_Status"=>$user1["Minimum_Balance_Status"],
  "Date"=>$date,
   "Time"=>$hour,
  
 );

array_push($response["rechargeamount"], $jsonRow_201);
  
}


  $rechargehistory=$conn->query( "SELECT 
           rp.Name,
           vr.Ammount,
           vr.Date,
           vr.Time


   
  
FROM   vehicle_recharged vr
    INNER JOIN  vehicle_detail v
    on vr.Vehicle_ID = v.ID
     INNER JOIN  driver_details d
    on d.ID = v.Driver_ID
         INNER JOIN  recharge_point rp
    on rp.ID = vr.Rechargepoint_ID
WHERE  d.ID=$uID ");




while ($user1 = mysqli_fetch_assoc($rechargehistory)) {

$jsonRow_201=array(

    "Name"=>$user1["Name"],
  "Ammount"=>$user1["Ammount"],
  
 );

array_push($response["rechargehistory"], $jsonRow_201);
  
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