<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
echo $_POST['mobile'];
if (isset($_POST['mobile']) ){

    $WHO=$_POST['WHO'];
    $mobile=$_POST['mobile'];
    $Cam= $_POST['Cam'];

    $Driver_doc = $_FILES['driver_doc']['name'];
            
         
    $WHO=test_input($WHO);
    $mobile=test_input($mobile);
    $Cam=test_input($Cam);

   
    
    if(strpos($Cam,"Pancard")!==FALSE){
       $target_path = "Profile/DRIVER/Pancard/";
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
     $target_path = "Profile/DRIVER/DrivingLicense/";
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
     $target_path = "Profile/DRIVER/Addressproof/";
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
     $target_path = "Profile/DRIVER/Aadharcard/";
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
    $target_path = "Profile/DRIVER/Cancelcheck/";
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
              $user = $db->uploadOwnerAsDriverDocument($Cam,$WHO,$mobile,$Driver_doc);
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