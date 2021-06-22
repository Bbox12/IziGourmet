<?php

//if "email" variable is filled out, send email
  if (isset($_POST['email']))  {
  
  //Email information
  $admin_email = "info@meatexpress.co.za";
  $email = $_POST['email'];
  $name = $_POST['name'];
  $comment = $_POST['msg'];
  

  $result =mail($admin_email,"Query From:". $name, $comment, "Meat Express Mobile App query From:" . $email);

 if(!$result) {   
     echo "Error";   
} else {
   echo "Thank you for contacting us!";
}
 
  }


