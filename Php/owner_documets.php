<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 

if (isset($_POST['mobile']) &&isset($_POST['Cam'])&&isset($_POST['WHO'])){

    $WHO=$_POST['WHO'];
    $mobile=$_POST['mobile'];
    $Cam= $_POST['Cam'];
        $proof= $_POST['proof'];
    $Driver_Phone= $_POST['driver_phone'];
    $Driver_doc = $_FILES['driver_doc']['name'];
            
        $proof=test_input($proof);  
    $WHO=test_input($WHO);
    $mobile=test_input($mobile);
    $Cam=test_input($Cam);
    $Driver_Phone=test_input($Driver_Phone);
   
    
    if(strpos($Cam,"Pancard")!==FALSE){
       $target_path = "Profile/OWNER/Pancard/";
       $target_path2 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path2)) {
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
  }

    if(strpos($Cam, "DL")!==FALSE){
     $target_path = "Profile/OWNER/DrivingLicense/";
        $target_path3 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path3)) {
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
  }
    if(strpos($Cam, "Addressproof")!==FALSE){
     $target_path = "Profile/OWNER/Addressproof/";
        $target_path4 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path4)) {
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
  }
    if(strpos($Cam, "Aadharcard")!==FALSE){
     $target_path = "Profile/OWNER/Aadharcard/";
       $target_path5 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path5)) {
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
  }
    if(strpos($Cam, "Cancelcheck")!==FALSE){
    $target_path = "Profile/OWNER/Cancelcheck/";
      $target_path6 = $target_path . basename($_FILES['driver_doc']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['driver_doc']['tmp_name'], $target_path6)) {
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
  }
              $user = $db->uploadOwnerDocument($Cam,$WHO,$mobile,$Driver_Phone,$Driver_doc,$proof);
              echo $user;

            if ($user) {
            // user stored successfully
                 $response["error"] = FALSE;
              echo "Suucessfully updated database";
              //header( 'Location: http://139.59.38.160/OHO/index.html' );

                
        } else {
            // user failed to store
            $response["error"] = true;
           
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