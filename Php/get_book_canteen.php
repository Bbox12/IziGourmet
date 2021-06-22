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
  $response = array("eats"=>array(),"ads"=>array(),"tezads"=>array());
    
    
            $eats=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`,`Discount`,`Packaging`, `Photo`, `Veg`, `NonVeg`,`CURL`,`Less`,`More`, `Date`, `Time` FROM `tez_Canteen` WHERE ID=$mobile");


 $ads=mysqli_query($conn, "SELECT `Photo` FROM `canteen_AD` ");


     $tezads=mysqli_query($conn, "SELECT `ID`, `Photo` FROM `eTez_AD` ");       


while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
   "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Address"=>$user1['Address'],
                          "Packaging"=>$user1['Packaging'],
                          "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Open_time"=>$user1['Open_time'],
                          "Close_time"=>$user1['Close_time'],
 "Monimum_orders"=>$user1['Monimum_orders'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Photo'],
                               "Discount"=>$user1['Discount'],
                          "Veg"=>$user1['Veg'],
                          "NonVeg"=>$user1['NonVeg'],
                             "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                              "CURL"=>$user1['CURL'],
                                    "Less"=>$user1['Less'],
                             "More"=>$user1['More'],
 );

array_push($response["eats"], $jsonRow_201);
  
}


while ($user1 = mysqli_fetch_assoc($ads)) {

$jsonRow_201=array(
            
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Photo'],
 );

array_push($response["ads"], $jsonRow_201);
  
}

while ($user1 = mysqli_fetch_assoc($tezads)) {

$jsonRow_201=array(
            
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'ad'. '/'.$user1['Photo'],
 );

array_push($response["tezads"], $jsonRow_201);
  
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