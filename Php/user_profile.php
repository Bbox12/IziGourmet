<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['giver_mobile'])){
    $lat=$_POST['my_lat'];
    $long=$_POST['my_long'];
    $name= $_POST['giver_name'];
    $email = $_POST['giver_email'];
    $mobile = $_POST['giver_mobile'];
    $refer=generateRandomString();
    echo $refer;
    $id=$_POST['idfacebook'];
    $target_path = "Profile/";
    $server_ip="139.59.38.160";
  
// final file url that is being uploaded
   $file_upload_url = 'http://' . $server_ip . '/' . 'OHO' . '/'.'APP' . '/'. $target_path;
    
   
  
    $email=test_input($email);
    $mobile=test_input($mobile);
    $name=test_input($name);
    $id=test_input($id);
      $lat=test_input($lat);
    $long=test_input($long);
    $refer=test_input($refer);
    $target_path = $target_path . basename($_FILES['image']['name']);
       $file_path=$_FILES['image']['name'];
        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{
 
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        $response['error'] = false;

} 
       
       
         
       }

        catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

            $res = $db->createUser($id,$name,$email,$mobile,$file_path,$lat,$long,$refer);

         if ($res) {
       
        $response["error"] = false;
      
    
    } else  {
        $response["error"] = true;
        $response["message"] = "Mobile number already existed!";
    }
 echo json_encode($response);
} else {
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

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>