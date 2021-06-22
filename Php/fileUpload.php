<?php
 
// Path to move uploaded files

require_once 'DB_Functions.php';
$db = new DB_Functions();



// array for final json respone
$response = array();

 $response = array("error" => FALSE);
 
// getting server ip address
 $server_ip=gethostbyname(gethostname());

 var_dump($_POST);
if (isset($_FILES['image']['name'])) {
   
    $mobile = isset($_POST['user']) ? $_POST['user'] : '';
    $mobile=test_input($mobile);
   
    $file_path=$_FILES['image']['name'];

        $id = isset($_POST['id']) ? $_POST['id'] : '';
    $id=test_input($id);
  
    $target_path = "checks/";
    $target_path2 = $target_path . basename($_FILES['image']['name']);
    try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['errors'] = true;
            $response['message'] = 'Could not move the file!';
        }else{
 
        // File successfully uploaded
        $response['message'] = 'File uploaded successfully!';
        $response['errors'] = false;
        $result = $db->storeCheck($id,$mobile,$file_path);
  if ($result) {
            $response["error"] = FALSE;
        } else {
            $response["error"] = TRUE;
        }
      }
    }catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['errors'] = true;
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
  $data=strtoupper($data);
  return $data;
}

function test_($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>