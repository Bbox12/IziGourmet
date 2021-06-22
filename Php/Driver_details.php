<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

 
if (isset($_POST['session_no']) &&isset($_FILES['driver_image']) && isset($_POST['driver_first_name'])&& isset($_POST['driver_phone'])&& isset($_POST['driver_cut_mark'])&& isset($_POST['driver_address_1'])&& isset($_POST['driver_zip'])&& isset($_FILES['driver_pancard'])&& isset($_FILES['driver_addressproof'])&& isset($_FILES['driver_dl'])&& isset($_FILES['driver_cc'])){


    $session_no=$_POST['session_no'];
    $Driver_FirstName= $_POST['driver_first_name'];
        $Driver_LastName= $_POST['driver_last_name'];
            $Driver_Phone= $_POST['driver_phone'];
             $Driver_email= $_POST['driver_email'];
        $Driver_Cut = $_POST['driver_cut_mark'];
                $Driver_birth_date = $_POST['driver_birth_date'];
                        $Driver_address_1 = $_POST['driver_address_1'];
                              $Driver_address_2 = $_POST['driver_address_2'];
         
 $Driver_state= $_POST['driver_state'];
  $Driver_city = $_POST['driver_city'];
        $Driver_country= $_POST['driver_country'];
            $Driver_zip= $_POST['driver_zip'];
              $Driver_image = $_FILES['driver_image']['name'];
             $Driver_pancard= $_FILES['driver_pancard']['name'];
    $Driver_addressproof = $_FILES['driver_addressproof']['name'];
        $Driver_dl = $_FILES['driver_dl']['name'];
                $Driver_check = $_FILES['driver_cc']['name'];
                $Driver_aadhar = $_FILES['driver_aadhar_card']['name'];
         

    $session_no=test_input($session_no);
    $Driver_first_name=test_input($Driver_FirstName);
    $Driver_LastName=test_input($Driver_LastName);
    $Driver_Phone=test_input($Driver_Phone);
    $Driver_email=test_input($Driver_email);
      $Driver_birth_date=test_input($Driver_birth_date);
    $Driver_address_1=test_input($Driver_address_1);
    $Driver_address_2=test_input($Driver_address_2);
        $Driver_city=test_input($Driver_city);
    $Driver_state=test_input($Driver_state);
    $Driver_country=test_input($Driver_country);
    $Driver_zip=test_input($Driver_zip);
    $Driver_pancard=test_input($Driver_pancard);
    $Driver_addressproof=test_input($Driver_addressproof);
    $Driver_dl=test_input($Driver_dl);
    $Driver_check=test_input($Driver_check);
    $Driver_aadhar=test_input($Driver_aadhar);
    
   $target_path = "/OHO/DRIVER/images/Driver/";
        $target_path1 = $target_path . basename($_FILES['driver_image']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
       $target_path = "OHO/DRIVER/images/Pancard/";
       $target_path2 = $target_path . basename($_FILES['driver_pancard']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_pancard']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
     $target_path = "OHO/DRIVER/images/Dl/";
        $target_path3 = $target_path . basename($_FILES['driver_dl']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_dl']['tmp_name'], $target_path3)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
  }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
     $target_path = "OHO/DRIVER/images/Addressproof/";
        $target_path4 = $target_path . basename($_FILES['driver_addressproof']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_addressproof']['tmp_name'], $target_path4)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
  }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
     $target_path = "OHO/DRIVER/images/Aadharcard/";
       $target_path5 = $target_path . basename($_FILES['driver_aadhar_card']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_aadhar_card']['tmp_name'], $target_path5)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
    $target_path = "OHO/DRIVER/images/Cancelcheck/";
      $target_path6 = $target_path . basename($_FILES['driver_cc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_cc']['tmp_name'], $target_path6)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
              $user = $db->uploadDriver($session_no,$Driver_first_name,$Driver_LastName,$Driver_Phone,$Driver_email,$Driver_Cut,$Driver_birth_date,$Driver_image,$Driver_address_1,$Driver_address_2,$Driver_city,$Driver_state,$Driver_country,$Driver_zip,$Driver_pancard,$Driver_addressproof,$Driver_aadhar,$Driver_dl,$Driver_check);

            if ($user) {
            // user stored successfully
       $response["error"] = "Database update failed";
             
        } else {
            // user failed to store
            $response["error"] = "Database update failed";
           
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