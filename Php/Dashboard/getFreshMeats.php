<?php


header('Content-Type: application/json');
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $con = $db->connect();





if(!$con){
   echo "Could not connect to DBMS";       
 }else {
   if (isset($_POST['id'])){


 
    $ID= $_POST['id'];
   
    $ID=test_input($ID);



  $response = array();



   
 $server_ip="139.59.38.160";
 
$sql="SELECT `ID`, `Name`, `Photo`, `isActive`, `Date`, `Time` FROM `subsubmenu` WHERE ID='$ID' AND `isActive`=1 ";
    


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                     "Photo"=>'http://' . $server_ip . '/' . 'IziGourmet' . '/' .'Dashboard'.'/'.'products'. '/' .$user["Photo"],
                "Name"=>$user['Name'],
         
             );


array_push($response, $jsonRow_201);

}




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