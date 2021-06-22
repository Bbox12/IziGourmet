<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['mobile']) &&isset($_POST['from_'] ) &&isset($_POST['to_'] )){
 
    // receiving the post params
    $mobile =isset($_POST['mobile']) ? $_POST['mobile'] : '';
    
    $from_ = isset($_POST['from_']) ? $_POST['from_'] : '';
    $to_=isset($_POST['to_']) ? $_POST['to_'] : '';
     $dist=isset($_POST['dist']) ? $_POST['dist'] : '';
       $hour=isset($_POST['hour']) ? $_POST['hour'] : '';
     $minute=isset($_POST['minute']) ? $_POST['minute'] : '';
        $from_lat=$_POST['from_lat'];
    $from_long=$_POST['from_long'];
           $to_lat=$_POST['to_lat'];
    $to_long=$_POST['to_long'];
     $day_1=$_POST['day_1'];
   $day_2=$_POST['day_2'];
    $day_3=$_POST['day_3'];
    $day_4=$_POST['day_4'];
     $day_5=$_POST['day_5'];
      $day_6=$_POST['day_6'];
       $day_7=$_POST['day_7'];
    $mobile=test_input($mobile);
    $from_=test_input($from_);
    $to_=test_input($to_);
    $hour=test_input($hour);
    $minute=test_input($minute);
       $from_lat=test_input($from_lat);
    $from_long=test_input($from_long);
         $to_lat=test_input($to_lat);
    $to_long=test_input($to_long);
       $dist=test_input($dist);
   $day_1=test_input($day_1);
     $day_2=test_input($day_2);
       $day_3=test_input($day_3);
         $day_4=test_input($day_4);
           $day_5=test_input($day_5);
             $day_6=test_input($day_6);
               $day_7=test_input($day_7);
        $user = $db->book_ride($mobile,$from_, $to_,$hour,$minute,$dist,$from_lat,$from_long,$to_lat,$to_long,$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7);

        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["user"]["unique_id"]=$user["unique_id"];
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