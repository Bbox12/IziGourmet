<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();





if(!$con){
   echo "Could not connect to DBMS";       
 }else {
   if (isset($_POST['id'])){


 
    $ID= $_POST['id'];
   
    $ID=test_input($ID);



  $response = array();



   

 
$sql="SELECT `ID`, `Name`, `Phone_No`, `Email`, `Aboutus`, `Address`, `State`, `City`, `Pin_No`, `Latitude`, `Longitude`, `Distance`, `isActive`, `Date`, `Time` FROM `tez_Canteen` WHERE `isActive`=1 AND  ID='$ID'";
  	


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                "Name"=>$user['Name'],
                      "Phone_No"=>$user['Phone_No'],
                "Address"=>$user['Address'],
                  "Latitude"=>$user['Latitude'],
                      "Longitude"=>$user['Longitude'],
                             "Distance"=>$user['Distance'],
             );


array_push($response, $jsonRow_201);

}




}


 echo json_encode($response);


}


 

 
 function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}     



?>