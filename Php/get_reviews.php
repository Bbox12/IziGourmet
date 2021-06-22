<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $conn = $db->connect();

 
if(!$conn){
   echo "Could not connect to DBMS"; 
    }else { 


if (isset($_POST['_mId'])){
 
    $mobile= $_POST['_mId'];
   
    $mobile=test_input($mobile);



try{
$server_ip="139.59.38.160";
  $response = array("reviews"=>array());

   


              $reviews=mysqli_query($conn, "SELECT ud.Name,ud.Photo, fr.Review, fr.Rating FROM `food_review` fr INNER JOIN user_details ud ON ud.ID=fr.UserID 
             WHERE fr.FoodID=$mobile ");


while ($user1 = mysqli_fetch_assoc($reviews)) {

$jsonRow_201=array(
  "Review"=>$user1['Review'],
            "Rating"=>$user1['Rating'],
            "Name"=>$user1["Name"],
      "Photo"=>'http://' . $server_ip . '/' . 'eTez' .'/'.'Profile'. '/' .'USER'. '/' .$user1["Photo"] ,
                        
 );

array_push($response["reviews"], $jsonRow_201);
  
}



   echo json_encode($response);    

} catch(Error $e) {
    $trace = $e->getTrace();
    echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
}

}
}
 
    
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>