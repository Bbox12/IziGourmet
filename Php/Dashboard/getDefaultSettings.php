<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();





if(!$con){
   echo "Could not connect to DBMS";       
 }else {




  $response = array();



   

 
$sql="SELECT `ID`, `Discounts`, `MinimumOrderPrice`, `MinimumOrderWeight`, `MinimumDistance`, `MaximumDistance`, `StartTime`, `EndTime`, `FreeDistance`, `PricePerKM`,`CancellationCharge`,`FacebookPage`, `InstagramPage`, `YoutubePlaylis`, `WhatsApp`, `Date`, `Time`, `User`, `IP` FROM `setting_defaults` ORDER BY ID DESC LIMIT 1";
    


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                     "Discounts"=>$user['Discounts'],
                "MinimumOrderPrice"=>$user['MinimumOrderPrice'],
                
                "MinimumOrderWeight"=>$user['MinimumOrderWeight'],
                     
                "MinimumDistance"=>$user['MinimumDistance'],
                "MaximumDistance"=>$user['MaximumDistance'],
          
                "StartTime"=>$user['StartTime'],  
                       
                "EndTime"=>$user['EndTime'],
                "FreeDistance"=>$user['FreeDistance'],
                       "CancellationCharge"=>$user['CancellationCharge'],
                "PricePerKM"=>$user['PricePerKM'],

                  "FacebookPage"=>$user['FacebookPage'],
                "InstagramPage"=>$user['InstagramPage'],
                       "YoutubePlaylis"=>$user['YoutubePlaylis'],
                "WhatsApp"=>$user['WhatsApp'],
                         
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