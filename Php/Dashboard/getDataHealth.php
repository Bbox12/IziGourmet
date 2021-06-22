<?php
header('Content-Type: application/json');
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

  
   $result =$conn->query("SELECT `ID`, `Title`, `Details`, `Links`, `uploadToServer`, `isActive`, `D_Date`, `D_Time`, `D_User`, `D_IP`, `Date`, `Time`, `User`, `IP` FROM `health` WHERE ID='$pin' AND isActive=1");
          
            while ($user1 = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
             
                             "Title"=>$user1["Title"],
                             "Details"=>$user1["Details"],
                             "Links"=>$user1["Links"],
                             "uploadToServer"=>$user1["uploadToServer"],
                      
                                 
 );

array_push($response, $jsonRow_201);
  
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