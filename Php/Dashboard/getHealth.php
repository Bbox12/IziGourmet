<?php
header('Content-Type: application/json');
        require_once 'DB_Connect.php';
  
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 



try{

       $date=date("Y-m-d");
  $response = array();

  
   $result =$conn->query("SELECT COUNT(s.ID) AS Total,s.Date,(SELECT COUNT(ID)FROM delievered WHERE `Date`=s.Date AND Delivered=5) AS Count FROM delievered s  GROUP BY s.Date ");
          
            while ($user1 = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
             
                          "Count"=>$user1["Count"],
                              "symDate"=>$user1["Date"],
                                        "Total"=>$user1["Total"],
                               
                                 
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