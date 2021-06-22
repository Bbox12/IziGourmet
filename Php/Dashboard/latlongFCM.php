<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script type="text/javascript">
 $(document).ready(function(){
  var damt=0;
    var unique ='<?php echo $_GET["unique"];?>';
        var name ='<?php echo $_GET["name"];?>';
            var mobile ='<?php echo $_GET["mobile"];?>';
                var vehicle ='<?php echo $_GET["vehicle"];?>';
                            var ETR ='<?php echo $_GET["ETR"];?>';
                               var Photo ='<?php echo $_GET["Photo"];?>';
                                       damt ='<?php echo $_GET["damt"];?>';

                       

    var res = unique.split(".");
    var unique=res[0]+res[1];

   // alert(unique);



  var config = {
      apiKey: "AIzaSyCPVGAxyBB6-auiKFI2DU2R3po-J55OhVM",
    databaseURL: "https://fourth-caster-305809-default-rtdb.firebaseio.com/",
    projectId: "izigourmet",
  };
  firebase.initializeApp(config);


    if(damt>0){
  
                           var databaseFire1 = firebase.database().ref('IziGourmet').child(unique);
      databaseFire1.update({
      "ask": "4",
       "driverName": name,
        "DriverMobile": mobile,
                 "ETR": ETR,
                      "image": Photo,
         "driverVehicle": vehicle,
            "pchanged": "1",
          "Cost": damt
                           }).then(function(){
     var databaseFire1 = firebase.database().ref('Driver_Online').child(mobile);
      databaseFire1.update({
      "Ride": unique
                           }).then(function(){
   window.location.href = "http://139.59.38.160/IziGourmet/Dashboard/admin.php";
}).catch(function(error) {
  alert("Data could not be saved." + error);
});
     
}).catch(function(error) {
  alert("Data could not be saved." + error);
});
    }else{

                           var databaseFire1 = firebase.database().ref('IziGourmet').child(unique);
      databaseFire1.update({
      "ask": "4",
       "driverName": name,
        "DriverMobile": mobile,
                 "ETR": ETR,
                      "image": Photo,
         "driverVehicle": vehicle
           
                           }).then(function(){
     var databaseFire1 = firebase.database().ref('Driver_Online').child(mobile);
      databaseFire1.update({
      "Ride": unique
                           }).then(function(){
   window.location.href = "http://139.59.38.160/IziGourmet/Dashboard/admin.php";
}).catch(function(error) {
  alert("Data could not be saved." + error);
});
     
}).catch(function(error) {
  alert("Data could not be saved." + error);
});
    }
              

     
  
  });
      
                        
  

 
</script>



</head>

</html>
