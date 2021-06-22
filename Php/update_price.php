<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 var_dump($_POST);
if (isset($_POST['ID']) ) {
 
    // receiving the post params
    $available = $_POST['available'];
    $Price = $_POST['Price'];
    $Discount = $_POST['Discount'];
    $NewPrice = $_POST['NewPrice'];
    $ID = $_POST['ID'];
    $ID=test_input($ID);
    $available=test_input($available);
    $Price=test_input($Price);
    $Discount=test_input($Discount);
    $NewPrice=test_input($NewPrice);
 
 
        // create a new user
        $user = $db->Update_food_hotel($ID,$available,$Price,$Discount,$NewPrice);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            echo json_encode($response);
        }
    }
 else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters is missing!";
    echo json_encode($response);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>ID