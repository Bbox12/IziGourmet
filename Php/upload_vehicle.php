<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
    
if (isset($_POST['session_no']) &&isset($_POST['vehicle_no']) && isset($_FILES['vehicle_image_1'])&& isset($_FILES['vehicle_rc'])&& isset($_FILES['vehicle_insurance'])){

 $driver=$_POST['driver'];
   $session_no=$_POST['session_no'];
    $vehicle_no= $_POST['vehicle_no'];
        $vehicle_company= $_POST['vehicle_company'];
            $vehicle_type= $_POST['vehicle_type'];
             $vehicle_model= $_POST['vehicle_model'];
    $vehicle_image_1 = $_FILES['vehicle_image_1']["name"];
        $vehicle_image_2 = $_FILES['vehicle_image_2']["name"];
                $vehicle_rc = $_FILES['vehicle_rc']["name"];
                        $vehicle_insurance = $_FILES['vehicle_insurance']["name"];
                             


    

    $session_no=test_input($session_no);
    $vehicle_no=test_input($vehicle_no);
    $vehicle_company=test_input($vehicle_company);
    $vehicle_type=test_input($vehicle_type);
    $vehicle_model=test_input($vehicle_model);
    $vehicle_image_1=test_input($vehicle_image_1);
    $vehicle_image_2=test_input($vehicle_image_2);
    $vehicle_rc=test_input($vehicle_rc);
    $vehicle_insurance=test_input($vehicle_insurance);
  
        $target_path = "images/Vehicle/";
        $target_path = $target_path . basename($_FILES['vehicle_image_1']['name']);
       
        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['vehicle_image_1']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move image_1!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
       $target_path = "images/Vehicle/";
       $target_path = $target_path . basename($_FILES['vehicle_image_2']['name']);
       
        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['vehicle_image_2']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
                 $response['message'] = 'Could not move image_2!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
            $target_path = "images/Rc/";
            $target_path1 = $target_path . basename($_FILES['vehicle_rc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['vehicle_rc']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
                $response['message'] = 'Could not move image_3!';
        }else{

        $response['error'] = "Suucess";
        }
 }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
           $target_path = "images/Insurance/";
        $target_path2 = $target_path . basename($_FILES['vehicle_insurance']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['vehicle_insurance']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['error'] = true;
              $response['message'] = 'Could not move image_4!';
        }else{

        $response['error'] = "Suucess";
        }
 }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
 
            $user = $db->uploadVehicle($driver,$session_no,$vehicle_no,$vehicle_company,$vehicle_type,$vehicle_model,$vehicle_image_1,$vehicle_image_2,$vehicle_rc,$vehicle_insurance);

            if ($user) {
            // user stored successfully
            $response["error"] = "false";
            

                
        } else {
            // user failed to store
            $response["error"] = "true";
           
        }
    
      

        
}else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Error !';
}
 echo json_encode($response);
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>