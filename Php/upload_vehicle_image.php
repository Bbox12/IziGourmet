<?php
error_reporting(E_ALL);
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
if (isset($_POST['mobile'])&& isset($_FILES['image'])){


   $mobile=$_POST['mobile'];
  $no=$_POST['no'];
    $vimage = $_FILES['image']["name"];
               $Vehicle_no=$_POST['Vehicle_no'];

    $mobile=test_input($mobile);
        $no=test_input($no);
            $Vehicle_no=test_input($Vehicle_no);
    $vimage=test_input($vimage);


        $target_path = "Profile/VEHICLE/RC";
        $target_path1 = $target_path . basename($_FILES['image']['name']);
       
        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move image_1!';
        }else{
    $user = $db->uploadVehicleImage($mobile,$vimage,$no,$Vehicle_no);

            if ($user) {
            // user stored successfully
            $response["error"] = "false";
                
        } else {
            // user failed to store
            $response["error"] = "true";
           
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
    $response['message'] = 'No file received !';
}
 echo json_encode($response);
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>