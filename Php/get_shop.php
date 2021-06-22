<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 






try{
$server_ip="139.59.38.160";
  $response = array("shop"=>array());

 
          $Recomended=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`, `Discount`, `Packaging`, `Photo`, `Veg`, `NonVeg`, `CURL`, `NoofPerson`, `Recomended`, `Rating`, `isDelivery`, `Delivery_charge`, `isActive`, `Less`, `More`, `Date`, `Time` FROM `tez_Canteen`");

            
          

           


while ($user1 = mysqli_fetch_assoc($Recomended)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],

            "Name"=>$user1['Name'],
              "Address"=>$user1['Address'],
              "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                  
                             "Discount"=>$user1['Discount'],
                                "Photo"=>$user1['Photo'],
                              "Monimum_orders"=>$user1['Monimum_orders'],
                               "Rating"=>$user1['Rating'],
                            "NoofPerson"=>$user1['NoofPerson'],
                  
                         
 );

array_push($response["shop"], $jsonRow_201);
  
}




   echo json_encode($response);    

} catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}


}
 
    
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>