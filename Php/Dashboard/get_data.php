<?php


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


        $date=date("Y-m-d");
      
      
          $clockin=mysqli_query($conn, "SELECT SUM(c.Duration) As Duration,(SELECT Name FROM new_site WHERE ID=w.SiteID) AS StaffID FROM `clockout` c INNER JOIN workingsites w ON w.ID=c.WorkingID WHERE c.clockoutTime!='00:00:00' GROUP BY  w.SiteID  ");

            

       while ($user1 = mysqli_fetch_assoc($clockin)) {  
$jsonRow_20=array(
                "Date"=>$user1["StaffID"]."|".$user1["Duration"],
               
            
               
             );

array_push($response, $jsonRow_20);
  
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