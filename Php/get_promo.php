<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();
        
    
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 
if (isset($_POST['ref'])){
 
    $_ref= $_POST['ref'];
    $_ref=test_input($_ref);

   
try{

  $server_ip="139.59.38.160";

  $response = array("_ref_code"=>array());

    $result =$conn->query("SELECT ID FROM user_details WHERE Reference_Code=$_ref");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
      
        }
         }


   if(strlen($_ref)!=0){
  
     $_ref_code=$conn->query( "SELECT `User_refernce_code_coupon_Amt` FROM `setting_defaults` LIMIT 1 ");
   }

while ($user1 = mysqli_fetch_assoc($_ref_code)) {

$jsonRow_201=array(
            
           "User_refernce_code_coupon_Amt"=>$user1["User_refernce_code_coupon_Amt"],
                            
                                 
 );



array_push($response["_ref_code"], $jsonRow_201);
  
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