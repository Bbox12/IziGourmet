<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['giver_mobile'])){
    $phone=$_POST['phone'];
    $name=$_POST['names'];
    $mobile = $_POST['giver_mobile'];
    $IP = $_POST['IP'];

 
    $phone=test_input($phone);
    $name=test_input($name);
    $mobile=test_input($mobile);
    $IP=test_input($IP);
   


            $res = $db->Add_emergency_contacts($mobile,$phone,$name,$IP);

         if ($res) {
       
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
    
    }
 echo json_encode($response);
} else {
    // File parameter is missing
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