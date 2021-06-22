<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
     
if (isset($_POST['mobile']) && isset($_POST['owner_name'])&& isset($_POST['owner_phone'])&& isset($_POST['owner_email'])&& isset($_POST['owner_address'])){
 
    $Owner_image= $_FILES['owner_image']['name'];
        $Firstname= $_POST['owner_name'];
          $mobile= $_POST['mobile'];
             $Phoneno= $_POST['owner_phone'];
    $Email = $_POST['owner_email'];
        $Birthdate = $_POST['owner_birth_date'];
                $Street_address1 = $_POST['owner_address'];
                        
                                $City = $_POST['owner_city'];
  $State = $_POST['owner_state'];
                        $Country = $_POST['owner_country'];
                                $Pin = $_POST['owner_pin'];

                                $IP=$_POST['IP'];
                               

$Identification=$_POST['Identification'];
$Firebase_Token=$_POST['Firebase_Token'];

    $Owner_image=test_input($Owner_image);
    $Firstname=test_input($Firstname);
    $Phoneno=test_input($Phoneno);
    $Email=test_input($Email);
    $Birthdate=test_input($Birthdate);
    $Street_address1=test_input($Street_address1);
    $City=test_input($City);
    $Country=test_input($Country);
    $Pin=test_input($Pin);
    $IP=test_input($IP);
    $Identification=test_input($Identification);
    $Firebase_Token=test_input($Firebase_Token);

        $target_path = "Profile/DRIVER/";
        $target_path1 = $target_path . basename($_FILES['owner_image']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['owner_image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Success";
          $user = $db->uploadOwnerAsDriver($mobile,$Phoneno,$Owner_image,$Firstname,$Email,$Birthdate,$Street_address1,$City,$State,$Country,$Pin,$IP,$Identification,$Firebase_Token);

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
    $response['message'] = 'Some thing wrong!';
}
 echo json_encode($response);
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>