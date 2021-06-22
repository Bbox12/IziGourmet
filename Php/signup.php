<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

$target_path = "Menu/";

error_reporting(-1);
ini_set('display_errors', 'On');



 
if ( isset($_POST['mobile']) && isset($_POST['password'])){
 
    // receiving the post params
    $name = $_POST['username'];
    $mobile=$_POST['mobile'];
    $password=strtoupper($_POST['password']);
   
    $name=test_input($name);
    $mobile=test_input($mobile);
    $password=test_input($password);
   
      $file_path=$_FILES['image']['name'];
       $target_path0 = $target_path . basename($_FILES["image"]["name"]);
 
      if(strlen($file_path)!=0){


       
      try {
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path0)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }
}

        catch (Exception $e) {
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }
  }else{
       $file_path="Profile.png";
         $file_path=test_input($file_path);
  }
        $user = $db->signup($name,$mobile,$password,$file_path);
        if ($user) {
        
            $response["error"] = FALSE;
            $response["user"]["role"] =$user["role"];
        
                $response["user"]["Name"]=$user["Name"];
                      $response["user"]["ID"]=$user["ID"];
            
            echo json_encode($response);
        } else {
            // user failed to store
           $response["user"]["role"] =0;
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function test_c($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data=strtoupper($data);
  return $data;
}
?>