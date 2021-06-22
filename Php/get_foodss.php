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
  }


if (isset($_POST['menu'])){
 
    $menu= $_POST['menu'];
   
    $menu=test_input($menu);

}else{
     $menu="";
}


if (isset($_POST['food'])){
 
    $food= $_POST['food'];
   
    $food=test_input($food);

}else{
      $food="";
}


if (isset($_POST['submenu'])){
 
    $submenu= $_POST['submenu'];
   
    $submenu=test_input($submenu);

}else{
     $submenu="";
}



try{
$server_ip="139.59.38.160";
  $response = array("foods"=>array(),"shop"=>array(),"second"=>array(),"bookings"=>array(),"timings"=>array(),"drivers"=>array(),"vehicle"=>array());


    $timings=mysqli_query($conn, "SELECT b.Unique_Ride_Code,b.From_Address,b.pCost,b.ID,b.Cost,b.PaymentMode,b.PaymentVerified,b.Is_Paid,b.ETR,(SELECT Name FROM user_details WHERE ID=b.Driver_ID) AS `Driver`,(SELECT Photo FROM user_details WHERE ID=b.Driver_ID) AS `Photo`,b.Vehicle_ID,b.Booking_Date,b.Booking_Time,d.Delivered,b.End_Date,b.End_Time FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID INNER JOIN book_ride b ON b.OTP=d.OrderID WHERE  s.OrderID='$submenu' AND b.User_ID='$mobile' GROUP BY d.ID");

while ($user1 = mysqli_fetch_assoc($timings)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
                 "Driver"=>$user1['Driver'],
                         "Vehicle_ID"=>$user1['Vehicle_ID'],
                          "Booking_Date"=>$user1['Booking_Date'],
                          "Booking_Time"=>$user1['Booking_Time'],
                         "End_Date"=>$user1['End_Date'],
                          "End_Time"=>$user1['End_Time'],
                                "From_Address"=>$user1['From_Address'],
                             "Delivered"=>$user1['Delivered'],
                                 "Cost"=>$user1['Cost'],
                                      "pCost"=>$user1['pCost'],
                                    "ETR"=>$user1['ETR'],
                                            "PaymentMode"=>$user1['PaymentMode'],
                                                "PaymentVerified"=>$user1['PaymentVerified'],
                                                            "Is_Paid"=>$user1['Is_Paid'],
                                                                      "Unique_Ride_Code"=>$user1['Unique_Ride_Code'],
                          "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Menu'.'/'.$user1['Photo'],
                
 );

array_push($response["timings"], $jsonRow_201);
  
}

if($menu==1){
            $eats=mysqli_query($conn, "SELECT f.ID,f.IDMenu,f.IDSubsubmenu,sm.Category AS Submenu,m.Name AS Menu,f.Name,f.Weight,f.Unit,f.Description,f.MRP,f.JalpanPrice,f.Discount,f.Photo FROM `foods` f  INNER JOIN submenu sm ON sm.ID=f.IDSubsubmenu INNER JOIN menu_type m ON m.ID=f.IDMenu WHERE f.Available=1  AND f.IDMenu='$food'");

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
                            
 );

array_push($response["foods"], $jsonRow_201);
  
}

     
     $second=mysqli_query($conn, "SELECT f.ID,f.IDMenu,f.IDSubsubmenu,f.isOutOfStock,sm.Category AS Submenu,m.Name AS Menu,m.Colors,f.Name,f.Weight,f.Unit,f.Description,f.MRP,f.JalpanPrice,f.Discount,f.Photo,smsm.Name AS PrimaryCategory FROM `foods` f  INNER JOIN submenu sm ON sm.ID=f.IDSubsubmenu INNER JOIN menu_type m ON m.ID=f.IDMenu INNER JOIN subsubmenu smsm ON smsm.ID=f.IDSubmenu WHERE f.Available=1  AND f.IDMenu='$food' AND sm.Category='$submenu' ");

     while ($user1 = mysqli_fetch_assoc($second)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
              "Brand"=>$user1['Brand'],
                 "IDSubsubmenu"=>$user1['IDSubsubmenu'],
                         "Name"=>$user1['Name'],
                          "Weight"=>$user1['Weight'],
                          "Unit"=>$user1['Unit'],
                            "Colors"=>$user1['Colors'],
                                  "PrimaryCategory"=>"",
                         "MRP"=>$user1['MRP'],
                          "MeatExpressPrice"=>$user1['JalpanPrice'],
                             "Discount"=>$user1['Discount'],
                          "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Dashboard'.'/'.'products'. '/'.$user1['Photo'],
                                "Menu"=>$user1['Menu'],
                          "Subsubmenu"=>$user1['Subsubmenu'],
                         "Submenu"=>$user1['Submenu'],
                         "Description"=>$user1['Description'],
                            "isOutOfStock"=>$user1['isOutOfStock'],

                            
 );

array_push($response["second"], $jsonRow_201);
  
}

}else{

 
             $eats=mysqli_query($conn, "SELECT f.ID,f.IDMenu,f.IDSubsubmenu,sm.Category AS Submenu,m.Name AS Menu,f.Name,f.Weight,f.Unit,f.Description,f.MRP,f.JalpanPrice,f.Discount,f.Photo FROM `foods` f  INNER JOIN submenu sm ON sm.ID=f.IDSubsubmenu INNER JOIN menu_type m ON m.ID=f.IDMenu  WHERE f.Available=1  AND f.IDSubmenu='$food'");

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
              "Description"=>$user1['Description'],
                         "Submenu"=>$user1['Submenu'],

                            
 );

array_push($response["foods"], $jsonRow_201);
  
}

     $second=mysqli_query($conn, "SELECT f.ID,f.IDMenu,f.IDSubsubmenu,f.isOutOfStock,sm.Category AS Submenu,m.Name AS Menu,m.Colors,f.Name,f.Weight,f.Unit,f.Description,f.MRP,f.JalpanPrice,f.Discount,f.Photo,smsm.Name AS PrimaryCategory FROM `foods` f  INNER JOIN submenu sm ON sm.ID=f.IDSubsubmenu INNER JOIN menu_type m ON m.ID=f.IDMenu INNER JOIN subsubmenu smsm ON smsm.ID=f.IDSubmenu WHERE f.Available=1  AND f.IDSubmenu='$food' AND m.Name='$submenu'");

     while ($user1 = mysqli_fetch_assoc($second)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
              "Brand"=>$user1['Brand'],
                 "IDSubsubmenu"=>$user1['IDSubsubmenu'],
                         "Name"=>$user1['Name'],
                          "Weight"=>$user1['Weight'],
                          "Unit"=>$user1['Unit'],
                              "Colors"=>$user1['Colors'],
                                       "PrimaryCategory"=>"",            
                         "MRP"=>$user1['MRP'],
                          "MeatExpressPrice"=>$user1['JalpanPrice'],
                             "Discount"=>$user1['Discount'],
                          "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Dashboard'.'/'.'products'. '/'.$user1['Photo'],
                                "Menu"=>$user1['Menu'],
                          "Subsubmenu"=>$user1['Subsubmenu'],
                         "Submenu"=>$user1['Submenu'],
                         "Description"=>$user1['Description'],
                            "isOutOfStock"=>$user1['isOutOfStock'],

                            
 );

array_push($response["second"], $jsonRow_201);
  
}
}


   $bookings=mysqli_query($conn, "SELECT `ID`, `UserID`, `OrderID`, `CanteenID`,(SELECT Name FROM foods WHERE ID=s.FoodID) AS `FoodID`,(SELECT JalpanPrice FROM foods WHERE ID=s.FoodID) AS `Price`,(SELECT Discount FROM foods WHERE ID=s.FoodID) AS `Discount`, `NoofItems`, `Date`, `Time`,(SELECT Packaging FROM update_user_order WHERE OrderID=s.OrderID) AS `Packaging`,(SELECT Delievery FROM update_user_order WHERE OrderID=s.OrderID) AS `Delievery` FROM `store_order`s WHERE `OrderID`='$submenu'");


     while ($user1 = mysqli_fetch_assoc($bookings)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
              "Name"=>$user1['FoodID'],
                 "Price"=>$user1['Price'],
                         "NoofItems"=>$user1['NoofItems'],
                           "Packaging"=>$user1['Packaging'],
                                 "Delievery"=>$user1['Delievery'],   
        "Discount"=>$user1['Discount'],   
                            
 );

array_push($response["bookings"], $jsonRow_201);
  
}

     
          
    
           
                    $shop=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`, `Discount`, `Packaging`, `Photo`, `Veg`, `NonVeg`, `CURL`, `NoofPerson`, `Recomended`, `Rating`, `isDelivery`, `Delivery_charge`, `isActive`, `Less`, `More`, `Date`, `Time` FROM `tez_Canteen` WHERE `ID`='$mobile'");
        



while ($user1 = mysqli_fetch_assoc($shop)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
              "Name"=>$user1['Name'],
                 "Phone_No"=>$user1['Phone_No'],
                         "Open_time"=>$user1['Open_time'],
                          "Close_time"=>$user1['Close_time'],
                          "Monimum_orders"=>$user1['Monimum_orders'],
                         "Minimum_time"=>$user1['Minimum_time'],
                          "Discount"=>$user1['Discount'],
                             "Rating"=>$user1['Rating'],
                         "Address"=>$user1['Address'],
        "Latitude"=>$user1['Latitude'],
                             "Longitude"=>$user1['Longitude'],
                            
 );

array_push($response["shop"], $jsonRow_201);
  
}


 $drivers=mysqli_query($conn, "SELECT `ID`, Name  FROM `user_details` WHERE role=2");

while ($user1 = mysqli_fetch_assoc($drivers)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
    
                         "Name"=>$user1['Name'],
                
                            
 );

array_push($response["drivers"], $jsonRow_201);
  
}

$vehicle=mysqli_query($conn, "SELECT ID,`Vehicle_No` FROM `vehicle_detail`");

while ($user1 = mysqli_fetch_assoc($vehicle)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],
                         "Name"=>$user1['Vehicle_No'],
                
                            
 );

array_push($response["vehicle"], $jsonRow_201);
  
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