<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 

if (isset($_FILES['driver_doc'])){


    $Driver_Phone= $_POST['driver_phone'];
    $Driver_doc = $_FILES['driver_doc']['name'];
            
  
    $Driver_Phone=test_input($Driver_Phone);
   
  
     $target_path = "Profile/DRIVER/DrivingLicense/";
        $target_path3 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path3)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

         $user = $db->uploadDocument($Driver_Phone,$Driver_doc);
             
            if ($user) {
      
                 $response["error"] = FALSE;
        
           
        } else {
            // user failed to store
            $response["error"] = true;
           
        }
        }
  }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
  
        
}else {
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