<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile'])){
    $ID=$_POST['ID'];
    $persons=$_POST['persons'];
    $date= $_POST['date'];
    $time = $_POST['time'];
    $mobile = $_POST['mobile'];
  

  
    $time=test_input($time);
    $mobile=test_input($mobile);
    $date=test_input($date);
    $ID=test_input($ID);
    $persons=test_input($persons);
   
    $res = $db->createBooking($ID,$mobile,$persons,$date,$time);

         if ($res) {
       
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
     
    }
 echo json_encode($response);
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