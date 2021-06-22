<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);



if (isset($_GET['id'])){



 
 
$id=$_GET["id"];
$id=test_input($id);

     $user = $db->verifyPayment($id);
             if ($user) {  

 $_SESSION["error"]=1;
        $response["error"] = false;


 require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();


  $result =$conn->query("SELECT Unique_Ride_Code FROM  book_ride WHERE ID=$id");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["Unique_Ride_Code"];
        }
         }

      header('Location: http://139.59.38.160/IziGourmet/Dashboard/latlongVerify.php?id='.$uID);
    }else{
           $_SESSION["error"]=2;
    $response['error'] = true;
    }

} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
  
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>