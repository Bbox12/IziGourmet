<?php session_start();


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
  $response = array();


 $result =$conn->query("SELECT `Phone_No` FROM `driver_details` ");
          
       

          while ($user1 = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
             
                              "Phone_No"=>$user1["Phone_No"],
                             
                                 
 );

array_push($response, $jsonRow_201);
  
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