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

    $_last= $_POST['_last'];
   
    $_last=test_input($_last);

     $total= $_POST['total'];
   
    $total=test_input($total);

    if($total==0){
      $total=12;
    }



try{
$server_ip="139.59.38.160";
  $response = array("foods"=>array());

   

    
    
            $eats=mysqli_query($conn, "SELECT tc.Name AS Canteen, mt.Name,fd.ID AS ID, fd.Menu_Name, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price, fd.Discount, fd.Photo AS Photo,fd.Veg AS Veg ,mt.Name As Menu_type, tc.Rating AS Rating ,tc.Minimum_time AS Minimum_time,tc.Photo AS Image
            , tc.CURL AS CURL ,tc.Minimum_person AS Minimum_person,tc.NoofPerson AS NoofPerson
            , tc.Open_time AS  Open_time ,tc.Close_time AS Close_time,tc.Monimum_orders AS Monimum_orders,tc.NonVeg AS NonVeg  

            FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile AND fd.ID>$_last LIMIT 12");

              $filters=mysqli_query($conn, "SELECT tc.Name, mt.Name,fd.ID AS ID, fd.Menu_Name, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price,fd.Discount, fd.Photo,fd.Veg AS Veg FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile ");


 $ads=mysqli_query($conn, "SELECT `Photo` FROM `canteen_AD` ");


           


while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
            "Name"=>$user1['Name'],
                         "Menu_type"=>$user1['Menu_type'],
                          "Menu_Name"=>$user1['Menu_Name'],
                    
                          "NonVeg"=>$user1['NonVeg'],
              
                          "eTEZ_Price"=>$user1['eTEZ_Price'],
                             "Discount"=>$user1['Discount'],
                        
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'WebApp'. '/'.'Menu'. '/'.$user1['Photo'],
                          "Veg"=>$user1['Veg'],
                
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