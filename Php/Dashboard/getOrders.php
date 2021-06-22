<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();





if(!$con){
   echo "Could not connect to DBMS";       
 }else {
   if (isset($_POST['id'])){


 
    $ID= $_POST['id'];
   
    $ID=test_input($ID);



  $response = array();



   

 
$sql="SELECT t.Name,t.Address,b.Type,b.pCost,b.Cost,b.Driver_ID,b.Vehicle_ID,b.ETR,d.Delivered FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID INNER JOIN book_ride b  ON b.User_ID=s.UserID INNER JOIN tez_Canteen t  ON t.ID=s.CanteenID WHERE d.Delivered<5 AND s.OrderID='$ID' AND b.OTP='$ID'  AND b.Is_Paid!=1 GROUP BY d.ID";
  	


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "Delivered"=>$user['Delivered'],
                   "Driver_ID"=>$user['Driver_ID'],
                      "Vehicle_ID"=>$user['Vehicle_ID'],
                         "ETR"=>$user['ETR'],
                          "pCost"=>$user['pCost'],
                                   "Cost"=>$user['Cost'],
                                         "Type"=>$user['Type'],
                                               "Name"=>$user['Name'],
                                         "Address"=>$user['Address'],
             );


array_push($response, $jsonRow_201);

}




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