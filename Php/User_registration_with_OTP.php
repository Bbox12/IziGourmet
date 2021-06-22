<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['giver_mobile'])){
      $name= $_POST['giver_name'];
    $mobile = $_POST['giver_mobile'];
    $IP= $_POST['IP'];
    $mobile=test_input($mobile);
    $name=test_input($name);
        $IP=test_input($IP);
        $refer=generateRandomString();
        $refer=test_input($refer);


            $res = $db->User_OTP($name,$mobile,$refer,$IP);

         if ($res) {
            
        $response["error"] = false;
        $response["user"]["Name"]=$res["Name"];
              $response["user"]["Phone"]=$res["Phone_No"];
                 $response["user"]["role"]=$res["role"];
    
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