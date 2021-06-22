<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['email'])){
 
    // receiving the post params
    $email =isset($_POST['email']) ? $_POST['email'] : '';
      $topic =isset($_POST['topic']) ? $_POST['topic'] : '';
    $mode = isset($_POST['mode']) ? $_POST['mode'] : '';
    $stage=isset($_POST['stage']) ? $_POST['stage'] : '';
     $marks=isset($_POST['marks']) ? $_POST['marks'] : '';
  
    $email=test_input($email);
     $topic=test_input($topic);
    $mode=test_input($mode);
    $stage=test_input($stage);
       $marks=test_input($marks);
    
        $user = $db->add_marks($email,$topic,$mode,$stage,$marks);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Failed!";
            echo json_encode($response);
        }
    
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters missing!";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>