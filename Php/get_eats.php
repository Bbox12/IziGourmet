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
  $response = array("eats"=>array(),"ads"=>array(),"tezads"=>array(),"popular"=>array(),"Recomended"=>array());

   $result =$conn->query("SELECT ID FROM  user_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }
    
    
            $eats=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`,`Discount`,`Packaging`, `Photo`, `Veg`, `NonVeg`,`NoofPerson`, `Rating`,`CURL`,`Less`,`More`, `Date`, `Time` FROM `tez_Canteen` ");

              $Recomended=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`,`Discount`,`Packaging`, `Photo`, `Veg`, `NonVeg`,`NoofPerson`, `Rating`,`CURL`,`Less`,`More`, `Date`, `Time` FROM `tez_Canteen` WHERE Recomended=1");


    $popular=mysqli_query($conn, "SELECT tc.ID,tc.Name,tc.Phone_No,tc.Address,tc.Pin_No,tc.Latitude,tc.Longitude,tc.Open_time,tc.Close_time,tc.Sunday_close,tc.Monimum_orders,tc.Minimum_person,tc.Minimum_time,tc.Discount,tc.Packaging,tc.Photo,tc.Veg,tc.NonVeg,tc.NoofPerson,tc.Rating,tc.CURL,tc.Less,tc.More,tc.Date,tc.Time FROM dinner_booking dd INNER JOIN tez_Canteen tc ON dd.ID=tc.ID WHERE dd.UserID=$uID");


 $ads=mysqli_query($conn, "SELECT `Photo` FROM `canteen_AD` ");


     $tezads=mysqli_query($conn, "SELECT `ID`, `Photo` FROM `eTez_AD` ");    

     while ($user1 = mysqli_fetch_assoc($popular)) {

$jsonRow_201=array(
     "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Address"=>$user1['Address'],
                                "Packaging"=>$user1['Packaging'],
                          "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Open_time"=>$user1['Open_time'],
                            "NoofPerson"=>$user1['NoofPerson'],
                         "Rating"=>$user1['Rating'],
                          "Close_time"=>$user1['Close_time'],
 "Monimum_orders"=>$user1['Monimum_orders'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Photo'],
                               "Discount"=>$user1['Discount'],
                          "Veg"=>$user1['Veg'],
                          "NonVeg"=>$user1['NonVeg'],
                             "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                             "Less"=>$user1['Less'],
                             "More"=>$user1['More'],
                              "CURL"=>$user1['CURL'],
 );

array_push($response["popular"], $jsonRow_201);
  
}   


while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
   "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Address"=>$user1['Address'],
                                "Packaging"=>$user1['Packaging'],
                          "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Open_time"=>$user1['Open_time'],
                            "NoofPerson"=>$user1['NoofPerson'],
                         "Rating"=>$user1['Rating'],
                          "Close_time"=>$user1['Close_time'],
 "Monimum_orders"=>$user1['Monimum_orders'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Photo'],
                               "Discount"=>$user1['Discount'],
                          "Veg"=>$user1['Veg'],
                          "NonVeg"=>$user1['NonVeg'],
                             "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                             "Less"=>$user1['Less'],
                             "More"=>$user1['More'],
                              "CURL"=>$user1['CURL'],
 );

array_push($response["eats"], $jsonRow_201);
  
}

while ($user1 = mysqli_fetch_assoc($Recomended)) {

$jsonRow_201=array(
   "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Address"=>$user1['Address'],
                                "Packaging"=>$user1['Packaging'],
                          "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Open_time"=>$user1['Open_time'],
                            "NoofPerson"=>$user1['NoofPerson'],
                         "Rating"=>$user1['Rating'],
                          "Close_time"=>$user1['Close_time'],
 "Monimum_orders"=>$user1['Monimum_orders'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Photo'],
                               "Discount"=>$user1['Discount'],
                          "Veg"=>$user1['Veg'],
                          "NonVeg"=>$user1['NonVeg'],
                             "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                             "Less"=>$user1['Less'],
                             "More"=>$user1['More'],
                              "CURL"=>$user1['CURL'],
 );

array_push($response["Recomended"], $jsonRow_201);
  
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