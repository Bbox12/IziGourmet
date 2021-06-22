<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();


$response = array();
$response = array("error" => FALSE);



if (isset($_POST['_mId']) &&  isset($_POST['msg'])) {
    $_mId = $_POST['_mId'];
    $_mId = test_input($_mId);



        $msg = $_POST['msg'];
    $msg = test_input($msg);

    


    $res = $db->storeComment($_mId,$msg);
         if ($res) {
                $response["error"] = FALSE;
      
    } else  {
       
        $response["error"] = true;

    }
   echo json_encode($response); 
     
    }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>