<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['identity']) &&  isset($_POST['giver_mobile'])){
 
    $identity= $_POST['identity'];
    $mobile = $_POST['giver_mobile'];
   

  
    $identity=test_input($identity);
    $mobile=test_input($mobile);

     $res = $db->validDriver($identity,$mobile,$file_path);

         if ($res) {
    
        
        $response["error"] = false;
      
    } else {
       
        $response["error"] = true;
        $response["message"] = "Sorry! Error occurred in updating.";
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