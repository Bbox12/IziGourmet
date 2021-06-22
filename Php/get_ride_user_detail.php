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
 
    $mobile= $_POST['_mId'];
   
    $mobile=test_input($mobile);

     $unique= $_POST['Unique_Ride_Code'];
   
    $unique=test_input($unique);


date_default_timezone_set(TIMEZONE);
$hour=date("H");
$date=date("Y-m-d");
$field=$hour."-".date('H', strtotime('+1 hour'))."_hr" ;

try{
$server_ip="139.59.38.160";
  $response = array("Book_Ride_Now"=>array());
    
     $result =$conn->query("SELECT ID FROM  user_details WHERE ID=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }

     

$Book_Ride_Now=$conn->query("SELECT b.Cost,b.pCost,b.PaymentMode  
    FROM book_ride b 
    WHERE   b.Unique_Ride_Code='$unique' GROUP BY b.ID");





while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {

$jsonRow_201=array(
  "Cost"=>$user1["Cost"],
    "pCost"=>$user1["pCost"],
        "PaymentMode"=>$user1["PaymentMode"],
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