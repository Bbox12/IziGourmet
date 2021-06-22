<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 


if (isset($_POST['id'])){
 
    $ID= $_POST['id'];
   
    $ID=test_input($ID);





try{
$server_ip="139.59.38.160";
  $response = array();


        $date=date("Y-m-d");
      
       

          $clockin=mysqli_query($conn, "SELECT w.WorkDate,w.WorkTime,c.ID as WorkID,c.Duration,c.clockoutTime,c.Lauch_start,c.Launch_end,w.ID,(SELECT Name FROM new_site WHERE ID=w.SiteID) AS SiteName, (SELECT FirstName FROM admin_login_data WHERE ID=w.StaffID) AS StaffID, c.clockinTime,c.clockoutTime,c.message,c.image1,c.image2,c.image3,c.image4 FROM `clockout` c INNER JOIN workingsites w ON w.ID=c.WorkingID WHERE w.StaffID='$ID' ");


  
            

       while ($user1 = mysqli_fetch_assoc($clockin)) {  
$jsonRow_201=array(
                "WorkDate"=>$user1["WorkDate"],
                "WorkTime"=>$user1["WorkTime"],
               "SiteName"=>$user1["SiteName"],
               "SiteID"=>$user1["ID"] ,
              "comment"=>$user1["message"] ,
               "clockinTime"=>$user1["clockinTime"],
                "WorkID"=>$user1["WorkID"],
                  "Launch_start"=>$user1["Lauch_start"],
                   "Launch_end"=>$user1["Launch_end"],
                    "Duration"=>$user1["Duration"],
                      "clockoutTime"=>$user1["clockoutTime"],
                        
     "image1"=>'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$user1["image1"] ,
                       "image2"=>'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$user1["image2"] ,
                            "image3"=>'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$user1["image3"] ,
                                 "image4"=>'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$user1["image4"] ,
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