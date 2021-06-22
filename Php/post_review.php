<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();


$response = array();
$response = array("error" => FALSE);


var_dump($_POST);
if (isset($_POST['mobile']) &&  isset($_POST['ID'])) {
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $mobile = $_POST['mobile'];
    $ID = $_POST['ID'];
   
    $ID=test_input($ID);
   
    $rating=test_input($rating);
    $mobile=test_input($mobile);
    $title=test_input($title);

    $res = $db->postreview($title,$rating,$ID,$mobile);
         if ($res) {
  
        $response["error"] = false;
      
    } else  {
       
        $response["error"] = true;

    }
   
    }
       echo json_encode($response); 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>