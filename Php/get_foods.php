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

   $z=0;



try{
$server_ip="139.59.38.160";
  $response = array("foods"=>array(),"filters"=>array(),"Recomended"=>array(),"Popular"=>array());

         if($total==0){
         	 $z=mysqli_num_rows(mysqli_query($conn, "SELECT fd.ID 

             FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile "));
    
         }

 
          $Recomended=mysqli_query($conn, "SELECT tc.Name AS Canteen, mt.Name,fd.ID AS ID, fd.Menu_Name, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price, fd.Discount, fd.Photo AS Photo ,mt.Name As Menu_type, tc.Rating AS Rating ,tc.Minimum_time AS Minimum_time,tc.Photo AS Image, tc.CURL AS CURL ,tc.Minimum_person AS Minimum_person,tc.NoofPerson AS NoofPerson, tc.Open_time AS  Open_time ,tc.Close_time AS Close_time,tc.Monimum_orders AS Monimum_orders,tc.NonVeg AS NonVeg,tc.Discount AS Dis  ,tc.Address,tc.Latitude,tc.Longitude,tc.Less,tc.More,fd.Veg AS Veg

             FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile AND fd.Recomended=1 AND fd.Available=1 ");

              $Popular=mysqli_query($conn, "SELECT fd.Menu_Name,fd.Photo AS Photo

             FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile AND fd.Popular=1 AND fd.Available=1");
   	     
          
            	$eats=mysqli_query($conn, "SELECT tc.Name AS Canteen, mt.Name,fd.ID AS ID,fd.Recomended,fd.Popular, fd.Menu_Name,fd.Photo, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price,fd.Details, fd.Discount, mt.Name As Menu_type, tc.Rating AS Rating ,tc.Minimum_time AS Minimum_time,tc.Photo AS Image, tc.CURL AS CURL ,tc.Minimum_person AS Minimum_person,tc.NoofPerson AS NoofPerson, tc.Open_time AS  Open_time ,tc.Close_time AS Close_time,tc.Monimum_orders AS Monimum_orders,tc.NonVeg AS NonVeg,tc.Discount AS Dis  ,tc.Address,tc.Latitude,tc.Longitude,tc.Less,tc.More,fd.Veg AS Veg,tc.isDelivery,tc.Delivery_charge,fd.NoofPerson AS Fperson,fd.Rating AS FRating

             FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile AND fd.Available=1 ");
           
            

              $filters=mysqli_query($conn, "SELECT tc.Name, mt.Name,fd.ID AS ID, fd.Menu_Name, fd.Price, fd.eTEZ_Perchantage, fd.eTEZ_Price,fd.Discount, fd.Photo,fd.Veg AS Veg FROM `foods` fd INNER join 
             tez_Canteen tc ON fd.Canteen_ID=tc.ID INNER JOIN menu_type mt ON mt.ID=fd.Menu_type
             WHERE tc.ID=$mobile AND fd.Available=1 ");


 $ads=mysqli_query($conn, "SELECT `Photo` FROM `canteen_AD` ");


while ($user1 = mysqli_fetch_assoc($Popular)) {

$jsonRow_201=array(
 
                            "Canteen"=>$user1['Menu_Name'],
                                   "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'WebApp'. '/'.'Menu'. '/'.$user1['Photo'],
                         
 );

array_push($response["Popular"], $jsonRow_201);
  
}
           


while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
      "total"=>$z,
            "Name"=>$user1['Name'],
              "Details"=>$user1['Details'],
              "Address"=>$user1['Address'],
                "Less"=>$user1['Less'],
                          "More"=>$user1['More'],
              "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Menu_type"=>$user1['Menu_type'],
                          "Menu_Name"=>$user1['Menu_Name'],
                          "Price"=>$user1['Price'],
                            "Canteen"=>$user1['Canteen'],
                          "NonVeg"=>$user1['NonVeg'],
                         "eTEZ_Perchantage"=>$user1['eTEZ_Perchantage'],
                          "eTEZ_Price"=>$user1['eTEZ_Price'],
                             "Discount"=>$user1['Discount'],
                             "Dis"=>$user1['Dis'],
                              "Monimum_orders"=>$user1['Monimum_orders'],
                            "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'WebApp'. '/'.'Menu'. '/'.$user1['Photo'],
                          "Veg"=>$user1['Veg'],
                           "Image"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Image'],
                          "Open_time"=>$user1['Open_time'],
                            "NoofPerson"=>$user1['NoofPerson'],
                         "Rating"=>$user1['Rating'],
                          "Close_time"=>$user1['Close_time'],
                            "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                              "CURL"=>$user1['CURL'],
                                     "isDelivery"=>$user1['isDelivery'],
                              "Delivery_charge"=>$user1['Delivery_charge'],
                                   "Fperson"=>$user1['Fperson'],
                              "FRating"=>$user1['FRating'],
                                "Recomended"=>$user1['Recomended'],
                              "Popular"=>$user1['Popular'],
 );

array_push($response["foods"], $jsonRow_201);
  
}
while ($user1 = mysqli_fetch_assoc($Recomended)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
      "total"=>$z,
            "Name"=>$user1['Name'],
              "Address"=>$user1['Address'],
                "Less"=>$user1['Less'],
                          "More"=>$user1['More'],
              "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                         "Menu_type"=>$user1['Menu_type'],
                          "Menu_Name"=>$user1['Menu_Name'],
                          "Price"=>$user1['Price'],
                            "Canteen"=>$user1['Canteen'],
                          "NonVeg"=>$user1['NonVeg'],
                         "eTEZ_Perchantage"=>$user1['eTEZ_Perchantage'],
                          "eTEZ_Price"=>$user1['eTEZ_Price'],
                             "Discount"=>$user1['Discount'],
                             "Dis"=>$user1['Dis'],
                              "Monimum_orders"=>$user1['Monimum_orders'],
                          "Photo"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'WebApp'. '/'.'Menu'. '/'.$user1['Photo'],
                          "Veg"=>$user1['Veg'],
                           "Image"=>'http://' . $server_ip . '/' . 'eTez'.'/'.'Canteen'. '/'.$user1['Image'],
                          "Open_time"=>$user1['Open_time'],
                            "NoofPerson"=>$user1['NoofPerson'],
                         "Rating"=>$user1['Rating'],
                          "Close_time"=>$user1['Close_time'],
                            "Minimum_person"=>$user1['Minimum_person'],
                             "Minimum_time"=>$user1['Minimum_time'],
                              "CURL"=>$user1['CURL'],
 );

array_push($response["Recomended"], $jsonRow_201);
  
}

while ($user1 = mysqli_fetch_assoc($filters)) {

$jsonRow_201=array(
            "Name"=>$user1['Name'],
                         
 );

array_push($response["filters"], $jsonRow_201);
  
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