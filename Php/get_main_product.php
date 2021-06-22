<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();


 date_default_timezone_set('Africa/Johannesburg');
        $hour=date("H:i:s");
        $date=date("d-m-Y");
         $server_ip="139.59.38.160";

if(!$con){
   echo "Could not connect to DBMS";       
 }else {
   if (isset($_POST['ID'])){


 
    $otp= $_POST['ID'];
   
    $otp=test_input($otp);



  $response = array("foods"=>array(),"bookingservices"=>array());


$sql="SELECT `ID`, `Name`, `Photo`, `Specification`, `Description`, `isActive`, `User`, `Date`, `Time` FROM `menu_type` WHERE  `ID`='$otp'";
    


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow=array(
               "ID"=>$user['ID'],
                  
                "Name"=>$user['Name'],
                     
                "Photo"=>$user['Photo'],
          
                "Description"=>$user['Description'],  
                       
                "Specification"=>$user['Specification'],
           
                         
             );


array_push($response["bookingservices"], $jsonRow);


}



  $eats=mysqli_query($con, "SELECT f.ID,f.IDMenu,f.IDSubsubmenu,f.isOutOfStock,sm.Category AS Submenu,m.Name AS Menu,f.Name,f.Weight,f.Unit,f.Description,f.MRP,f.JalpanPrice,f.Discount,f.Photo FROM `foods` f  INNER JOIN submenu sm ON sm.ID=f.IDSubsubmenu INNER JOIN menu_type m ON m.ID=f.IDMenu WHERE f.Available=1  AND f.IDMenu='$otp'");

while ($user1 = mysqli_fetch_assoc($eats)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
                 "IDSubsubmenu"=>$user1['IDSubsubmenu'],
                         "Name"=>$user1['Name'],
                          "Weight"=>$user1['Weight'],
                          "Unit"=>$user1['Unit'],
                         "MRP"=>$user1['MRP'],
                          "MeatExpressPrice"=>$user1['JalpanPrice'],
                             "Discount"=>$user1['Discount'],
                          "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Dashboard'.'/'.'products'. '/'.$user1['Photo'],
                                "Menu"=>$user1['Menu'],
          
                         "Submenu"=>$user1['Submenu'],
      "Description"=>$user1['Description'],
       "isOutOfStock"=>$user1['isOutOfStock'],
                            
 );

array_push($response["foods"], $jsonRow_201);
  
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