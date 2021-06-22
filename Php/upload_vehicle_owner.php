<?php
 header('Content-Type: application/json');


require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['mobile']) &&isset($_POST['vNo'])){


   $mobile=$_POST['mobile'];
  
             $IP= $_POST['IP'];
   
      $image_1 = $_FILES['image_1']['name'];
      $image_2 = $_FILES['image_2']['name'];
    
    

    $mobile=test_input($mobile);

       $IP=test_input($IP);

    $vehicle_no= $_POST['vNo'];
    $vehicle_no=test_input($vehicle_no);

       $dNo= $_POST['dNo'];
    $dNo=test_input($dNo);

       $rcNo= $_POST['rcNo'];
    $rcNo=test_input($rcNo);



       $month= $_POST['month'];
    $month=test_input($month);

       $year= $_POST['year'];
    $year=test_input($year);

   
      
    $target_path = "Profile/DRIVER/DrivingLicense/";
    $target_path2 = $target_path . basename($_FILES['image_1']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image_1']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

    $target_path = "Profile/VEHICLE/RC/";
    $target_path2 = $target_path . basename($_FILES['image_2']['name']);

        try {
        // Throws exception incase file is not being moved
        if (!move_uploaded_file($_FILES['image_2']['tmp_name'], $target_path2)) {
            // make error flag true
            $response['error'] = true;
            $response['message'] = 'Could not move the file!';
        }else{

        $response['error'] = "Suucess";
        }
 
       
    }
      catch (Exception $e) {
        // Exception occurred. Make error flag true
        $response['error'] = true;
        $response['message'] = $e->getMessage();
    }

 
 
            $user = $db->uploadVehicleOwner($mobile,$vehicle_no,$image_1,$image_2,$dNo,$rcNo,$month,$year,$IP);

            if ($user) {
            // user stored successfully
            $response["error"] = "false";
            

                
        } else {
            // user failed to store
            $response["error"] = "true";
           
        }
    
      

        
}else {
    // File parameter is missing
    $response['error'] = true;
    $response['message'] = 'Error !';
}
 echo json_encode($response);
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>