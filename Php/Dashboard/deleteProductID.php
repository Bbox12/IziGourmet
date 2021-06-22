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



 $pd=$_GET["pd"];
$pd=test_input($pd);



 
$id=$_GET["id"];
$id=test_input($id);

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);





     $user = $db->DeleterProductFromOrder($id,$pd);
             if ($user) {  

              $Cost=0;

            $response["error"] = false;
            $unique=$user["Unique_Ride_Code"];
              $usrID=$user["User_ID"];

        require_once 'DB_Connect.php';
     
        $dbs = new Db_Connect();
        $conn = $dbs->connect();
        $server_ip="139.59.38.160";
              $result =$conn->query("SELECT SUM(s.NoofItems*(f.JalpanPrice-f.Discount)) AS Cost FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID WHERE s.OrderID='$id' AND UserID='$usrID' ORDER BY s.ID DESC");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $Cost=$row["Cost"];
            
        }
         }

      printf("user: %d.\n", $usrID);
            printf("unique: %d.\n", $unique);
                  printf("cost: %d.\n", $Cost);



  echo $usrID;
       echo $unique;
       echo $Cost;
          $result =$conn->query("UPDATE book_ride SET Cost='$Cost' WHERE Unique_Ride_Code='$unique'");
          $result =$conn->query("UPDATE update_user_order SET Gross='$Cost' WHERE OrderID='$id' ORDER BY ID DESC LIMIT 1");

          if($Cost!=0){
            header('Location: http://139.59.38.160/IziGourmet/Dashboard/latlongChanged.php?id='.$unique.'&Order='.$id.'&Cost='.$Cost);
          }else{
                 $reason="Item on the cart not avaialble";
              header('Location: http://139.59.38.160/IziGourmet/Dashboard/deleteFCM.php?unique='.$unique.'&reason='.$reason);
          }

       //
    } else  {
            $_SESSION["error"]=2;
        $response["error"] = true;
         // header('Location: http://139.59.38.160/IziGourmet/Dashboard/Profile.php?id='.$id);
    }



} else {
     $_SESSION["error"]=2;
    $response['error'] = true;
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/Profile.php?id='.$id);
}
     echo json_encode($response); 
       


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>