<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 header('Content-Type: application/json');
 session_start();

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

  $phone = array();
    $token = array();

var_dump($_POST);

if (!empty($_POST['msg'])){

$User= $_SESSION["email"];
$IP= $_SERVER['REMOTE_ADDR'];
$User= test_input($User);
$IP= test_input($IP);


$msg= $_POST['msg'];
$msg= test_input($msg);


 if(!empty($_FILES['photo']['name'])){
  $Photo= $_FILES['photo']['name'];
}else{
  $Photo="";
}





$Photo= test_input($Photo);

$target_path = "push/";
        $target_path1 = $target_path . basename($_FILES['photo']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_path1)) {
            // make error flag true
            //$response['message'] = 'Could not move the file!';
        }
      }  catch (Exception $e) {
   
        $response['message'] = $e->getMessage();
    }


    


   $user = $db->sentPushMessage($msg,$Photo,$User,$IP);
         if ($user) {   
        $response["error"] = "correct";
        require_once 'DB_Connect.php';
        $db1 = new Db_Connect();
        $conn = $db1->connect();
        $result =$conn->query("SELECT Firebase_Token  FROM  user_details WHERE Firebase_Token IS NOT NULL");




          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
                 $FirebaseToken=$row["Firebase_Token"];
                    array_push($token, $FirebaseToken);
        }
         }
       

       

     
    } else  {
       
        $response["error"] = true;
        $response["message"] = "error";
    }


     echo implode("|",$token);
 if(!empty($_FILES['photo']['name'])){
   header('Location: http://139.59.38.160/IziGourmet/Dashboard/sendPush.php?FirebaseToken='.implode("|",$token).'&msg='.$msg.'&photo='.'http://139.59.38.160/IziGourmet/Dashboard/'.$target_path1); 
}else{
      header('Location: http://139.59.38.160/IziGourmet/Dashboard/sendPush.php?FirebaseToken='.implode("|",$token).'&msg='.$msg); 
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