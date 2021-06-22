<!DOCTYPE html>
<html lang="en">
<head>

<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script type="text/javascript">
 $(document).ready(function(){



    var regID ='<?php  echo $_GET['FirebaseToken'];?>';

          var msg ='<?php  echo $_GET['msg'];?>';

         var photo ='<?php  echo $_GET['photo'];?>';



    var arr=regID.split("|");

   // alert(arr);


       if(arr.length!=0){
            for(i = 0; i < arr.length; i++) {
              if(photo.length==0){
                  var dataString =  'title='+ "Message from IziGourmet" +'&message='+msg+
                  '&push_type='+ "individual" +'&regId='+arr[i]+
                  '&include_image='+ "FALSE" ;
                }else{
                    var dataString =  'title='+ "Message from IziGourmet" +'&message='+msg+
                  '&push_type='+ "individual" +'&regId='+arr[i]+
                  '&include_image='+ "TRUE" +'&image='+photo;
                }
                  
        var xmlhttp;
             
                  if (window.XMLHttpRequest) {
 
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

 xmlhttp.overrideMimeType("application/json");
 xmlhttp.open("POST","fcm_sent1.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send(dataString);
            }
       }


     alert("Success");

window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/PushNotification.php");


});





</script>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
                            <script src="vendors/popper.js/dist/umd/popper.min.js"></script>

                            <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
                            <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script>

                            <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                            <script src="assets/js/main.js"></script>
                               <script src="main.js"></script>

</head>

</html>
