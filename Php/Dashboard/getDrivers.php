<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();





if(!$con){
   echo "Could not connect to DBMS";       
 }else {


   $id=$_POST["id"];
   $id=test_input($id);

  $response = array();


 
$sql="SELECT `ID`, `Name`, `Email`, `Photo`, `Phone_No`,`role`, `Address`, `Country`, `State`, `City`, `Pin` FROM `user_details` WHERE `ID`='$id'";
  	


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                     "Name"=>$user['Name'],
                "Phone_No"=>$user['Phone_No'],
                
                "Address"=>$user['Address'],
                     
                "Country"=>$user['Country'],
                "State"=>$user['State'],
          
                "City"=>$user['City'],  
                       
                "Pin"=>$user['Pin'],
            
                         
             );


array_push($response, $jsonRow_201);

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