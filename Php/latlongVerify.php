<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script type="text/javascript">
 $(document).ready(function(){
    var unique ='<?php echo $_GET["id"];?>';

     
   

   //alert(unique);



  var config = {
    apiKey: "AIzaSyB3LNwYau-s-oGS8wzNgnIuDT4EqimGWEo",
    databaseURL: "https://liteafrcia.firebaseio.com/",
    projectId: "liteafrcia",
  };
  firebase.initializeApp(config);



              

                           var databaseFire1 = firebase.database().ref('Meat').child(unique);
      databaseFire1.update({
      "Verify": "3"
                           }).then(function(){
   window.location.href = "http://139.59.38.160/Meat/Dashboard/admin.php";
}).catch(function(error) {
  alert("Data could not be saved." + error);
});
          
  });
      

 
</script>



</head>

</html>
