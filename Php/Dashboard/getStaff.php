<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://mypostman.in');
        require_once 'DB_Connect.php';
  
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 

if (isset($_POST['id'])){
 
    $pin= $_POST['id'];
   
    $pin=test_input($pin);


try{

       $date=date("Y-m-d");
  $response = array();


   $result =$conn->query("SELECT `ID`, `FirstName`, `LastName`, `WorkingSite`, `StaffID`, `Email`, `Photo`, `PhoneNo` FROM `admin_login_data` WHERE `isStaff`=1 AND ID='$pin'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $FirstName=$row["FirstName"];
                 $LastName=$row["LastName"];
                    $WorkingSite=$row["WorkingSite"];
                 $PhoneNo=$row["PhoneNo"];
                    $Email=$row["Email"];
                 $Photo=$row["Photo"];
            
        }
         }
         

$jsonRow_201=array(

              "FirstName"=>$FirstName,
                 "LastName"=>$LastName,
                    "WorkingSite"=>$WorkingSite,
                 "PhoneNo"=>$PhoneNo,
                    "Email"=>$Email,
                 "Photo"=>$Photo,
                                 
 );

array_push($response, $jsonRow_201);
  

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