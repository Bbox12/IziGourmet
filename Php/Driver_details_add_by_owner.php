<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 

if (isset($_POST['mobile']) &&isset($_FILES['driver_image']) && isset($_POST['driver_first_name'])&& isset($_POST['driver_phone'])&& isset($_POST['driver_cut_mark'])&& isset($_POST['driver_address_1'])&& isset($_POST['driver_zip'])){

    $mobile=$_POST['mobile'];
    $Driver_FirstName= $_POST['driver_first_name'];
            $Driver_Phone= $_POST['driver_phone'];
             $Driver_email= $_POST['driver_email'];
        $Driver_Cut = $_POST['driver_cut_mark'];
                $Driver_birth_date = $_POST['driver_birth_date'];
                        $Driver_address_1 = $_POST['driver_address_1'];
                    
          $Driver_city = $_POST['driver_city'];

 $Driver_state= $_POST['driver_state'];
        $Driver_country= $_POST['driver_country'];
            $Driver_zip= $_POST['driver_zip'];
              $Driver_image = $_FILES['driver_image']['name'];
              $lat=$_POST['driver_lat'];
              $long=$_POST['driver_long'];
                $IP=$_POST['IP'];
      
        
         

    $mobile=test_input($mobile);
    $Driver_first_name=test_input($Driver_FirstName);
    $Driver_Phone=test_input($Driver_Phone);
    $Driver_email=test_input($Driver_email);
    $Driver_birth_date=test_input($Driver_birth_date);
    $Driver_address_1=test_input($Driver_address_1);
    $Driver_city=test_input($Driver_city);
    $Driver_state=test_input($Driver_state);
    $Driver_country=test_input($Driver_country);
    $Driver_zip=test_input($Driver_zip);
    $lat=test_input($lat);
    $long=test_input($long);
    $Driver_image=test_input($Driver_image);
    $IP=test_input($IP);

   
 
   $target_path = "Profile/DRIVER/";
        $target_path1 = $target_path . basename($_FILES['driver_image']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

          
           
        }
 
       $user = $db->uploadDriverHimself($mobile,$Driver_first_name,$Driver_Phone,$Driver_email,$Driver_Cut,$Driver_birth_date,$Driver_image,$Driver_address_1,$Driver_city,$Driver_state,$Driver_country,$Driver_zip,$lat,$long,$IP); 
         

            if ($user) {
            // user stored successfully
                 $response["error"] = FALSE;
      
             
                
        } else {
            // user failed to store
            $response["error"] = true;
           
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