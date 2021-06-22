<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

var_dump($_POST);

if (isset($_POST['CDNo'])){

 
$ID=$_POST["ID"];
$ID=test_input($ID);
$CDNo=$_POST["CDNo"];
$CDNo=test_input($CDNo);

 
$Order=$_POST["Order"];
$Order=test_input($Order);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);

$Cost=0;


     $user = $db->updateOrder($Order,$ID,$CDNo,$User,$IP);

        if ($user) {   
        $response["error"] = false;
            $unique=$user["Unique_Ride_Code"];
              $usrID=$user["User_ID"];

        require_once 'DB_Connect.php';
        // connecting to database
        $dbs = new Db_Connect();
        $conn = $dbs->connect();
        $server_ip="139.59.38.160";
              $result =$conn->query("SELECT SUM(s.NoofItems*(f.JalpanPrice-f.Discount)) AS Cost FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID WHERE s.OrderID='$Order' AND UserID='$usrID' ORDER BY s.ID DESC");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $Cost=$row["Cost"];
            
        }
         }


          $result =$conn->query("UPDATE book_ride SET Cost='$Cost' WHERE Unique_Ride_Code='$unique'");
           $result =$conn->query("UPDATE update_user_order SET Gross='$Cost' WHERE OrderID='$Order' ORDER BY ID DESC LIMIT 1");



    
       header('Location: http://139.59.38.160/IziGourmet/Dashboard/latlongChanged.php?id='.$unique.'&Order='.$Order.'&Cost='.$Cost);
    } else  {
       
        $response["error"] = true;
        $response["message"] = "error";
    }

} else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Not received any file!';
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>