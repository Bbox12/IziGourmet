<?php session_start();
header('Content-Type: application/json');
require_once 'DB_Functions.php';
$db = new DB_Functions();

 session_start();

        require_once 'DB_Connect.php';
  
        $db1 = new Db_Connect();
        $conn = $db1->connect();
$response = array("error" => FALSE);

var_dump($_POST);
 
if (isset($_POST['email']) && isset($_POST['password'])){
 
    $mobile= $_POST['email'];
    $password = $_POST['password'];

    
  
    $mobile=test_input($mobile);
    $password=test_input($password);
  

     $user = $db->loginAdmin($mobile,$password);
   
         if ($user==3) {
        
      $_SESSION['email'] = $mobile;

       $result =$conn->query("SELECT isAdmin,isOffice,FirstName FROM `admin_login_data` WHERE isVerified=1 AND StaffID='$mobile'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
             $AdminID=$row["isAdmin"];
                 $MasterID=$row["isOffice"];
                 $Name=$row["FirstName"];   
        }
      }

              printf("User: %d.\n", $user);

            $_SESSION['name'] = $Name;

             if($AdminID==1){
                $_SESSION['admin'] = 1;
                header('Location: http://139.59.38.160/IziGourmet/Dashboard/admin.php');
              }else{
                 if($MasterID==1){
                header('Location: http://139.59.38.160/IziGourmet/Dashboard/index.php');
              }
              }
       

         
     
    } else  if ($user==2)   {
       
      echo "MOBILE";
      $_SESSION["error"]=1;
         header('Location: http://139.59.38.160/IziGourmet/Dashboard/page-login.php');
       
    }else  if ($user==1)   {
       
      echo "PASSWORD ERROR";
           $_SESSION["error"]=2;
             header('Location: http://139.59.38.160/IziGourmet/Dashboard/page-login.php');
    }

} else {
     echo "ERROR";

}
   
 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>