<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 $response = array("error" => FALSE);
if(isset($_POST["user_mobile"])){
  $User_Mobile = ($_POST["user_mobile"]);
  $Lattitude = ($_POST["lattitude"]);
  $Longitude = ($_POST["longitude"]);
    $Tracking_type = ($_POST["Tracking_type"]);

                $user = $db->storeLatUser($User_Mobile,$Lattitude,$Longitude,$Tracking_type);
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
?>