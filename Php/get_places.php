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
  $response = array("login"=>array(),"Book_Ride_Now"=>array(),"Book_Ride_from"=>array());
    
     $result =$conn->query("SELECT ID FROM  user_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }


            $login=mysqli_query($conn, "SELECT  `Favorite_Home_Address`, `Favourite_Work_Address`, `Favourite_Other_Address` FROM `user_details`WHERE Phone_No=$mobile ");


           
$Book_Ride_Now=$conn->query("SELECT `To_Address`,`To_Latitude`,`To_Longitude` FROM `book_ride` WHERE User_ID='$uID'  AND Is_Paid=1  GROUP BY `To_Address` ");


$Book_Ride_from=$conn->query("SELECT From_Address,From_Latitude,From_Longitude FROM `book_ride` WHERE User_ID='$uID'  AND Is_Paid=1  GROUP BY `From_Address` ");



while ($user1 = mysqli_fetch_assoc($login)) {

$jsonRow_201=array(
            "Favourite_Other_Address"=>$user1['Favourite_Other_Address'],
                         "Favourite_Work_Address"=>$user1['Favourite_Work_Address'],
                          "Favorite_Home_Address"=>$user1['Favorite_Home_Address'],
 );

array_push($response["login"], $jsonRow_201);
  
}

  while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {
 $jsonRow_201=array(
           

  "To_Address"=>$user1["To_Address" ],

  "To_Latitude"=>$user1["To_Latitude" ],

  "To_Longitude"=>$user1["To_Longitude" ],
  
  
             );
array_push($response["Book_Ride_Now"], $jsonRow_201);
  
}

  while ($user1 = mysqli_fetch_assoc($Book_Ride_from)) {
 $jsonRow_201=array(
           

  "From_Address"=>$user1["From_Address" ],

  "From_Latitude"=>$user1["From_Latitude" ],

  "From_Longitude"=>$user1["From_Longitude" ],
  
  
             );
array_push($response["Book_Ride_from"], $jsonRow_201);
  
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