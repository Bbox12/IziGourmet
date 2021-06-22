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
 
    $mID= $_POST['_mId'];
   
    $mID=test_input($mID);

   

try{
$server_ip="139.59.38.160";
  $response = array("foods"=>array());

  
        
    
            $eats=mysqli_query($conn, "SELECT tc.Name, mt.Name,fd.ID AS ID,mt.Name AS Menu_type , fd.Menu_Name, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price, fd.Discount, fd.Photo,fd.Veg As Veg FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mID AND fd.Veg=1");


           


while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Menu_type"=>$user1['Menu_type'],
                          "Menu_Name"=>$user1['Menu_Name'],
                          "Price"=>$user1['Price'],
                         "eTEZ_Perchantage"=>$user1['eTEZ_Perchantage'],
                          "eTEZ_Price"=>$user1['eTEZ_Price'],
                             "Discount"=>$user1['Discount'],
                               "Veg"=>$user1['Veg'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'WebApp'. '/'.'Menu'. '/'.$user1['Photo'],
 );

array_push($response["foods"], $jsonRow_201);
  
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