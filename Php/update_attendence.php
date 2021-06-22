<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

var_dump($_POST);
 
if (isset($_POST['absent'])){
 
    $absent= $_POST['absent'];
    $section = $_POST['section'];
    $faculty = $_POST['faculty'];
        $IP = $_POST['IP'];
    
  
    $absent=test_input($absent);
    $section=test_input($section);
    $faculty=test_input($faculty);
    $IP=test_input($IP); 
  

     $user = $db->update_attendence($faculty,$section,$absent,$IP);

         if ($user) {
        
        $response["error"] = false;
         $response["user"]["ID"] = $user["ID"];
                $response["user"]["holder"] = $user["_holders"];
     
    } else  {
       
        $response["error"] = true;
       
    }

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