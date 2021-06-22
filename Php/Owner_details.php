<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_FILES['owner_image']) && isset($_POST['name_first'])&& isset($_POST['owner_phone'])&& isset($_POST['owner_email'])&& isset($_POST['street_address'])&& isset($_POST['address_zip'])&& isset($_FILES['owner_pancard'])&& isset($_FILES['owner_addressproof'])&& isset($_FILES['owner_cancelled_check'])){
 
    $Owner_image= $_FILES['owner_image']['name'];
        $Firstname= $_POST['name_first'];
            $Lastname= $_POST['name_last'];
             $Phoneno= $_POST['owner_phone'];
    $Email = $_POST['owner_email'];
        $Birthdate = $_POST['birth_date'];
                $Street_address1 = $_POST['street_address'];
                        $Street_address2 = $_POST['street_address_2'];
                                $City = $_POST['address_city'];
  $State = $_POST['address_state'];
                        $Country = $_POST['address_country'];
                                $Pin = $_POST['address_zip'];
                                $Owner_pancard = $_FILES['owner_pancard']['name'];
                        $Owner_addressproof = $_FILES['owner_addressproof']['name'];
                                $Owner_aadhar = $_FILES['owner_aadhar_card']['name'];
                                    $Owner_check = $_FILES['owner_cancelled_check']['name'];


      $session_no=$_POST['session_no'];
       


    $session_no=test_input($session_no);
    $Owner_image=test_input($Owner_image);
    $Firstname=test_input($Firstname);
    $Lastname=test_input($Lastname);
      $Phoneno=test_input($Phoneno);
    $Email=test_input($Email);
    $Birthdate=test_input($Birthdate);
    $Street_address1=test_input($Street_address1);
    $Street_address2=test_input($Street_address2);
    $City=test_input($City);
    $Country=test_input($Country);
    $Pin=test_input($Pin);
    $Owner_pancard=test_input($Owner_pancard);
    $Owner_addressproof=test_input($Owner_addressproof);
     $Owner_aadhar=test_input($Owner_aadhar);
    $Owner_check=test_input($Owner_check);
        $target_path = "images/Owner/";
        $target_path1 = $target_path . basename($_FILES['owner_image']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Success";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
        $target_path = "images/Pancard/";
       $target_path2 = $target_path . basename($_FILES['owner_pancard']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_pancard']['tmp_name'], $target_path2)) {
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
      $target_path = "images/Addressproof/";
        $target_path3 = $target_path . basename($_FILES['owner_addressproof']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_addressproof']['tmp_name'], $target_path3)) {
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
  $target_path = "images/Cancelcheck/";
        $target_path4 = $target_path . basename($_FILES['owner_cancelled_check']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_cancelled_check']['tmp_name'], $target_path4)) {
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
  $target_path = "images/Aadharcard/";
       $target_path5= $target_path . basename($_FILES['owner_aadhar_card']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_aadhar_card']['tmp_name'], $target_path5)) {
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

 
            $user = $db->uploadOwner($session_no,$Owner_image,$Firstname,$Lastname,$Phoneno,$Email,$Birthdate,$Street_address1,$Street_address2,$City,$State,$Country,$Pin,$Owner_pancard,$Owner_addressproof,$Owner_check,$Owner_aadhar);

            if ($user) {
            // user stored successfully
            $response["error"] = "Suucessfully updated database";
              header( 'Location: http://139.59.38.160/OHO/DRIVER/form2.html' );

                
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