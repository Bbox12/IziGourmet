<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

var_dump($_POST);

if (isset($_POST['mobile'])){
 
    $name= $_POST['name'];
    $bday= $_POST['bday'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $email= $_POST['email'];
    $password= $_POST['password'];
     $last = $_POST['last'];
       $lsat=test_input($lsat);
   
    $mobile=test_input($mobile);
    $name=test_input($name);
    $gender=test_input($gender);
    $email=test_input($email);
    $password=test_input($password);
    $bday=test_input($bday);


        $image = $_FILES['image']['name'];
        $image=test_input($image);

       
       $target_path = "staffpic/";
        $target_path1 = $target_path . basename($_FILES['image']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path1)) {
            // make error flag true
            $response['error'] = true;
            $response["message"] = "error!Failed";
        }else{

            $res = $db->upadateUser($name,$email,$mobile,$password,$gender,$bday,$image,$last);

        if ($res) {   
        $response["error"] = false;
        $response["message"] = "Success";
    } else  {
       
        $response["error"] = true;
        $response["message"] = "error";
    }
          
                
        } 
        }
 
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

   

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
?>