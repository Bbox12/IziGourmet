<!DOCTYPE html>
<html lang="en">
<head>

<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.9.3/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script type="text/javascript">
 $(document).ready(function(){

    var unique ='<?php echo $_GET["unique"];?>';
        var reason ='<?php echo $_GET["reason"];?>';
   
    var res = unique.split(".");
    var unique=res[0]+res[1];

    //alert(unique);

  var config = {
      apiKey: "AIzaSyCPVGAxyBB6-auiKFI2DU2R3po-J55OhVM",
    databaseURL: "https://fourth-caster-305809-default-rtdb.firebaseio.com/",
    projectId: "izigourmet",
  };
  firebase.initializeApp(config);


                           var databaseFire1 = firebase.database().ref('IziGourmet').child(unique);
      databaseFire1.update({
      "ask": "7",
       "reason": reason,
                           }).then(function(){
                              alert("Success");
   window.location.href = "http://139.59.38.160/IziGourmet/Dashboard/admin.php";
}).catch(function(error) {
  alert("Data could not be saved." + error);
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
