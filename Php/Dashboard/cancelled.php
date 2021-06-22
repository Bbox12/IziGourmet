<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
<script type="text/javascript">
 function myFunction(){
    var unique ='<?php echo $_GET["id"];?>';

  

   alert(unique);



  var config = {
         apiKey: "AIzaSyCPVGAxyBB6-auiKFI2DU2R3po-J55OhVM",
    databaseURL: "https://fourth-caster-305809-default-rtdb.firebaseio.com/",
    projectId: "izigourmet",
  };
  firebase.initializeApp(config);



              

                           var databaseFire1 = firebase.database().ref('Payment').child(unique);
      databaseFire1.update({
      "Paid": "2"
                           }).catch(function(error) {
  alert("Data could not be saved." + error);
});
          
  };
      

 
</script>

</head>

<body onload="myFunction()" >

   
    <div id="main-wrapper">


        <div class="content-body">

        

            <div class="container-fluid">
             
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                    
                                <div class="card-content">
                                    <div class="alert alert-dark">
                                        <h4 class="alert-heading">Payment Cancelled</h4>
                                         <hr>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
            <!-- #/ container -->
        </div>
       
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

</body>

</html>