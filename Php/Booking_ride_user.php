<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
 
 //var_dump($_POST);
if (isset($_POST['mobile']) &&isset($_POST['address'] )
 ){
 
    // receiving the post params
    $mobile =$_POST['mobile'];
    $address =$_POST['address'];
    $houseno=$_POST['houseno'];
    $from_lat=$_POST['from_lat'];
    $from_long=$_POST['from_long'];
    $landmark=$_POST['landmark'];
    $zip=$_POST['zip'];
    $checked=$_POST['checked'];
    $IP=$_POST['IP'];
    $total=$_POST['total'];
    $distance=$_POST['distance'];
      $area=isset($_POST['area']) ? $_POST['area'] : '';
   
    $area=test_input($area);


    $total=test_input($total);
    $distance=test_input($distance);
    $mobile=test_input($mobile);
    $address=test_input($address);
    $houseno=test_input($houseno);
    $checked=test_input($checked);
    $from_lat=test_input($from_lat);
    $from_long=test_input($from_long);
    $landmark=test_input($landmark);
    $zip=test_input($zip);
    $IP=test_input($IP);
     

            
       
        $user = $db->book_ride($mobile,$address,$houseno,$from_lat,$from_long,$landmark,$zip,$checked,$IP,$distance,$total,$area);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["unique_id"]=$user["Unique_Ride_Code"];
              $response["user"]["OTP"]=$user["OTP"];
                   $response["user"]["ID"]=$user["ID"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
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