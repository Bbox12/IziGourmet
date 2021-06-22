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



   

 
$sql="SELECT `ID`, `IDMenu`, `IDSubmenu`,`IDSubsubmenu`, `Name`, `Weight`, `Unit`, `Description`, `MRP`, `JalpanPrice`, `Discount`, `Photo`, `Recomended`, `Popular`, `Rating`, `Available`, `User`, `Date`, `Time` FROM `foods` WHERE `ID`='$ID'";
  	


$result = $con->query($sql);


  while ($user = mysqli_fetch_assoc($result)) {

$jsonRow_201=array(
               "ID"=>$user['ID'],
                     "IDMenu"=>$user['IDMenu'],
                "IDSubsubmenu"=>$user['IDSubsubmenu'],
                   "IDSubmenu"=>$user['IDSubmenu'],
                "Name"=>$user['Name'],
                     
                "Weight"=>$user['Weight'],
                           "Unit"=>$user['Unit'],
          
                "Description"=>$user['Description'],  
                       
                "MRP"=>$user['MRP'],
                           "JalpanPrice"=>$user['JalpanPrice'],
                                   "Recomended"=>$user['Recomended'],
                "Discount"=>$user['Discount'],
                         
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