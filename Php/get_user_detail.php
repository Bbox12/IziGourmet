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

date_default_timezone_set('Africa/Johannesburg');
$hour=date("H");
$date=date("Y-m-d");
$uID=0;


try{
$server_ip="139.59.38.160";
  $response = array("settings"=>array(),"login"=>array(),"Book_Ride_Now"=>array(),"cancel"=>array(),"version"=>array(),"shops"=>array(),"shop"=>array(),"text"=>array(),"order"=>array(),"notification"=>array());



  $notification=mysqli_query($conn, "SELECT `ID`, `StaffID`, `Message`, `Photo`, `Date`, `Time`, `User`, `IP` FROM `push_message` ORDER BY ID DESC");

          while ($user1 = mysqli_fetch_assoc($notification)) {
   $jsonRow_201=array(
  "Message"=>$user1["Message"],
  "Photo"=>$user1["Photo"],
    "Date"=>$user1["Date"],
      "Time"=>$user1["Time"],

             );
array_push($response["notification"], $jsonRow_201);
  
} 




 $settings=mysqli_query($conn, "SELECT  `FacebookPage`, `InstagramPage`, `YoutubePlaylis`, `WhatsApp` FROM `setting_defaults` ORDER BY ID DESC LIMIT 1");

          while ($user1 = mysqli_fetch_assoc($settings)) {
   $jsonRow_201=array(
  "WhatsApp"=>$user1["WhatsApp"],
  "FacebookPage"=>$user1["FacebookPage"],
    "InstagramPage"=>$user1["InstagramPage"],

             );
array_push($response["settings"], $jsonRow_201);
  
} 

 $text=mysqli_query($conn, "SELECT `ID`, `MainText` FROM `splashtext`");

          while ($user1 = mysqli_fetch_assoc($text)) {
   $jsonRow_201=array(
  "MainText"=>$user1["MainText"],


             );
array_push($response["text"], $jsonRow_201);
  
} 




 
          $Recomended=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`, `Address`, `Pin_No`, `Latitude`, `Longitude`, `Open_time`, `Close_time`, `Sunday_close`, `Monimum_orders`, `Minimum_person`, `Minimum_time`, `Discount`, `Packaging`, `Photo`, `Veg`, `NonVeg`, `CURL`, `NoofPerson`, `Recomended`, `Rating`, `isDelivery`, `Delivery_charge`, `isActive`, `Less`, `More`, `Date`, `Time` FROM `tez_Canteen`");

            
          

           


while ($user1 = mysqli_fetch_assoc($Recomended)) {

$jsonRow_201=array(
  "ID"=>$user1['ID'],

            "Name"=>$user1['Name'],
              "Address"=>$user1['Address'],
              "Latitude"=>$user1['Latitude'],
                          "Longitude"=>$user1['Longitude'],
                  
                             "Discount"=>$user1['Discount'],
                                "Photo"=>$user1['Photo'],
                              "Monimum_orders"=>$user1['Monimum_orders'],
                               "Rating"=>$user1['Rating'],
                            "NoofPerson"=>$user1['NoofPerson'],
                  
                         
 );

array_push($response["shop"], $jsonRow_201);
  
}

     $result =$conn->query("SELECT ID FROM  user_details WHERE ID=$mobile");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
        }
         }



           $shops=mysqli_query($conn, "SELECT `ID`, `Name`, `Phone_No`,`Email`,`Aboutus`, `Address`, `State`, `City`, `Pin_No`, `Latitude`, `Longitude`, `isActive`, `Date`, `Time` FROM `tez_Canteen` WHERE `isActive`=1");

          while ($user1 = mysqli_fetch_assoc($shops)) {
   $jsonRow_201=array(
  "Name"=>$user1["Name"],
    "ID"=>$user1["ID"],
  "Phone_No"=>$user1["Phone_No"],
    "Email"=>$user1["Email"],
    "Address"=>$user1["Address"],
      "Latitude"=>$user1["Latitude"],
       "State"=>$user1["State"],
      "City"=>$user1["City"],
    "Longitude"=>$user1["Longitude"],
        "Aboutus"=>$user1["Aboutus"],
           "Pin_No"=>$user1["Pin_No"],
             );
array_push($response["shops"], $jsonRow_201);
  
} 
    

  $version=mysqli_query($conn, "SELECT `ID`, `Version`, `Importance`, `Date`, `Time`, `User`, `IP` FROM `app_version`");

          while ($user1 = mysqli_fetch_assoc($version)) {
   $jsonRow_201=array(
  "Version"=>$user1["Version"],
  "Importance"=>$user1["Importance"],
    
             );
array_push($response["version"], $jsonRow_201);
  
} 
         
          $cancel=mysqli_query($conn, "SELECT `ID`, `first`, `second`, `third`, `fourth`, `fifth` FROM `reason_cancel` ");

          
            $login=mysqli_query($conn, "SELECT `ID`, `Name`, `Email`, `Photo`, `Phone_No`, `Address`, `Country`, `State`, `City`, `Pin`, `Latitude`, `Longitude`, `Favorite_Home_Address`, `Favourite_Work_Address`, `Favourite_Other_Address`, `Rating`, `Reference_Code`,`User_Referrence_Code`, `Firebase_Token`, `Date`, `Time`, `User`, `IP`,`Charge` FROM `user_details`WHERE ID=$mobile ");


            






while ($user1 = mysqli_fetch_assoc($cancel)) {
   $jsonRow_201=array(


  "ID"=>$user1["ID" ],
  "first"=>$user1["first"],
  "second"=>$user1["second"],
   "third"=>$user1["third" ],
"fourth"=>$user1["fourth"],
   "fifth"=>$user1["fifth" ],
 
             );
array_push($response["cancel"], $jsonRow_201);
  
} 

 



while ($user1 = mysqli_fetch_assoc($login)) {

$jsonRow_201=array(
   "ID"=>$user1["ID"],
               "Name"=>$user1["Name"],
               "Email"=>$user1["Email"] ,
               "Photo"=>'http://' . $server_ip . '/' . 'Meat'.'/'.'Menu'. '/' .$user1["Photo"] ,
                "Phone_No"=>$user1['Phone_No'],
               "Address"=>$user1['Address'],
               "Country"=>$user1['Country'],
                 "State"=>$user1['State'],
               "City"=>$user1['City'],
                    "Pin"=>$user1['Pin'],
                         "Latitude"=>$user1['Latitude'],
                           "Longitude"=>$user1['Longitude'],
                    "Favourite_Other_Address"=>$user1['Favourite_Other_Address'],
                         "Favourite_Work_Address"=>$user1['Favourite_Work_Address'],
                          "Favorite_Home_Address"=>$user1['Favorite_Home_Address'],
                         "Rating"=>$user1['Rating'],
                         "Reference_Code"=>$user1['Reference_Code'],
                 "Firebase_Token"=>$user1['Firebase_Token'],
                "User_Referrence_Code"=>$user1['User_Referrence_Code'],
 );

array_push($response["login"], $jsonRow_201);
  
}

$Book_Ride_Now=$conn->query("SELECT b.PaymentMode,b.ID, b.OTP, b.Unique_Ride_Code,b.Cost, b.From_Latitude, b.From_Longitude,COUNT(s.NoofItems) AS CountNoofItems,NoofItems,f.Name,b.To_Latitude,b.To_Longitude,b.Is_Running FROM `book_ride` b INNER JOIN store_order s ON s.UserID=b.User_ID AND s.OrderID=b.OTP INNER JOIN foods f ON f.ID=s.FoodID WHERE User_ID='$uID' AND Is_Paid!=1 AND Ride_Cancelled_by=0 ");

  while ($user1 = mysqli_fetch_assoc($Book_Ride_Now)) {
 $jsonRow_201=array(
           
  "ID"=>$user1["ID" ],
  "OTP"=>$user1["OTP"],
  "Unique_Ride_Code"=>$user1["Unique_Ride_Code"],
  "From_Latitude"=>$user1["From_Latitude"],
  "From_Longitude"=>$user1["From_Longitude"],
   "To_Latitude"=>$user1["To_Latitude" ],
     "To_Longitude"=>$user1["To_Longitude"],
     "Is_Running"=>$user1["Is_Running"],
   "Cost"=>$user1["Cost"],
      "CountNoofItems"=>$user1["CountNoofItems"],
          "PaymentMode"=>$user1["PaymentMode"],
   
             );
array_push($response["Book_Ride_Now"], $jsonRow_201);
  
}

if (isset($_POST['order'])){
 
    $order= $_POST['order'];
   
    $order=test_input($order);

$order=$conn->query("SELECT f.ID,f.JalpanPrice,f.Discount,f.Name,s.NoofItems FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID WHERE s.UserID='$uID' AND s.OrderID='$order'");

  while ($user1 = mysqli_fetch_assoc($order)) {
 $jsonRow_201=array(
           
  "order"=>$user1["ID"]."_".$user1["NoofItems"]."_".$user1["NoofItems"]*($user1["JalpanPrice"]-$user1["Discount"])."_".$user1["Name"]."_"."1",


             );
array_push($response["order"], $jsonRow_201);
  
}
}


if (isset($_POST['token'])){
 
    $token= $_POST['token'];
   
    $token=test_input($token);
 require_once 'DB_Connect.php';
        $db1 = new Db_Connect();
        $conn = $db1->connect();
        $result =$conn->query("UPDATE  user_details SET Firebase_Token='$token',Logout=0  WHERE ID='$mobile'");
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