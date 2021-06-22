<!DOCTYPE html>
<html lang="en">
<head>

<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script type="text/javascript">
 $(document).ready(function(){

    var mobile ='<?php  echo $_GET['id'];?>';

    var msg ='<?php  echo $_GET['msg'];?>';

   


  var config = {
                    apiKey: "AIzaSyAcGFoFMNeRuyykA_LypQBifSLM93KZBBw",
    databaseURL: "https://ecosense.firebaseio.com/",
    projectId: "ecosense",
  };
  firebase.initializeApp(config);


  var databaseFire = firebase.database().ref("Sites");

  databaseFire.child(mobile).set("1");
  

 var databaseFire1 = firebase.database().ref('RegID').child(mobile);

  databaseFire1.once('value', function(snapshot) {

   
      var dataString =  'title='+ "Update on your request" +'&message='+msg+
                  '&push_type='+ "individual" +'&regId='+snapshot.val()+
                  '&include_image='+ "FALSE";
        var xmlhttp;
             
                  if (window.XMLHttpRequest) {
 
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.overrideMimeType("application/json");
 xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
          alert("Suucess");
          window.location.replace("http://139.59.38.160/Ecosense/Dashboard/index.php");
  }
}
 xmlhttp.open("POST","fcm_sent.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send(dataString);
});
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
