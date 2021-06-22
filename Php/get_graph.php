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

	$month= $_POST['month'];
   
    $month=test_input($month);

  


try{

  $response = array("graph"=>array());

     $result =$conn->query("SELECT ID FROM  driver_details WHERE Phone_No=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }


  $_students_attendence_record=$conn->query( "SELECT b.Is_Paid
    , b.Driver_Accepted_Date
    , b.Driver_Accepted_Time

FROM book_ride b
INNER JOIN driver_details d
    on b.Driver_ID = d.ID
 WHERE d.ID=$uID AND  MONTH(b.Driver_Accepted_Date)=$month " );

while ($user1 = mysqli_fetch_assoc($_students_attendence_record)) {

$jsonRow_201=array(
             
                          
                             "Driver_Accepted_Date"=>$user1["Driver_Accepted_Date"],
                              "Driver_Accepted_Time"=>$user1["Driver_Accepted_Time"],
                               "Is_Paid"=>$user1["Is_Paid"],
                            
                                 
 );

array_push($response["graph"], $jsonRow_201);
  
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