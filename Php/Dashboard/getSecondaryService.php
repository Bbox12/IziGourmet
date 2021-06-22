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
 
$sql="SELECT `ID`, `Category`, `Photo`, `Specification`, `Description`, `isActive`, `Date`, `Time` FROM `submenu` WHERE ID='$ID'";
    


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                     "Photo"=>'http://' . $server_ip . '/' . 'IziGourmet' . '/' .'Dashboard'.'/'.'products'. '/' .$user["Photo"],
                "Service"=>$user['Category'],
                   "Specification"=>$user['Specification'],
                    "Description"=>$user['Description'],
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