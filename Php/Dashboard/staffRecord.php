<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IziGourmet Dashboard</title>
    <meta name="description" content="IziGourmet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/jqvmap/dist/jqvmap.min.css">


    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://cdn.anychart.com/js/latest/anychart.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style type="text/css">
        #graph {
  width: 100%;
  height: 128px;
}
    </style>
 <script type="text/javascript">
function myFunction() {
  var myVarFromPhp = '<?php session_start();echo $_SESSION["email"] ?>';
  
  if(myVarFromPhp==''){
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }
};
</script>



</head>

<body onload="myFunction()">


    <!-- Left Panel -->

 <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img src="images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="images/logo.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="admin.php"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>

                      <h3 class="menu-title">Salon Page</h3>
                     <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Add </a>
                        <ul class="sub-menu children dropdown-menu">
                             <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="VerifySalon.php">Verify Salon</a></li>
                               <li><i class="menu-icon fa fa-sign-in"></i><a href="PushNotification.php">Push Notification</a></li>
                                 <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="stafftracker.html">Google Map </a></li>
                        </ul>
                    </li>

                   
                   <h3 class="menu-title">Operation</h3>
                     <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Staff</a>
                        <ul class="sub-menu children dropdown-menu">
                             <li><i class="menu-icon fa fa-th"></i><a href="staff_registration_admin.php">Registration</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="VerifyStaff.php">Verify</a></li>
                               <li><i class="menu-icon fa fa-th"></i><a href="DeleteStaff.php">Delete</a></li>
                        </ul>
                    </li>
         
                      <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Policy</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="NewPolicy.php">New</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="UpdatePolicy.php">Update</a></li>
                        </ul>
                    </li>

 
    
                  
                                   
                    
  <h3 class="menu-title">Extras</h3><!-- /.menu-title -->
                    <li class="menu ">
                        <a href="page-login.php" ><i class="menu-icon fa fa-sign-out"></i> LOGOUT</a>
                       
                    </li>      
                </ul>
            </div>
        </nav>
    </aside>
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                       
       <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"onclick="location.href = 'http://139.59.38.160/IziGourmet/Dashboard/getComments.php';">
                                <i class="fa fa-bell"></i>
                                <span class="count bg-danger"><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
           $date=date("Y-m-d");
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT COUNT(ID) FROM comments WHERE  `Date`='$date'");
        foreach($sql as $row) {
echo $row['COUNT(ID)'] ;
         }
     }
        ?></span>
                            </button>
                     
                        </div>

                        <div class="dropdown for-message">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="message"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-email"></i>
                            
                            </button>
                            <div class="dropdown-menu" aria-labelledby="message">
                                <p class="red">You have no Mails</p>
                               
                           
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                           <a href="page-login.php" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php  session_start(); echo $_SESSION["email"]."|".$_SESSION["name"];?></a>
                        </a>
                    </div>
                </div>
          </div>

        </header>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
     
        </div>



   
        <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="alerts">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Application status today</strong>
                                 
                                </div>
                                <div class="card-body" id="MyDivName" onMouseOver="scrollDiv_init()"  onMouseOut="pauseDiv()" >
                                	        <?php  
                        
                                 require_once 'DB_Connect.php';
                                       date_default_timezone_set(TIMEZONE);
        $date=date("Y-m-d");
        $db = new Db_Connect();
        $conn = $db->connect();
           $id=$_GET["id"];
            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT `ID`, `FirstName`, `LastName`, `Role`,  `StaffID`, `Email`, `Photo` FROM `admin_login_data` WHERE `loginDate`='$date' AND isStaff=1 ");
        foreach($sql as $row) {
          ?>                
                                    <div class="alert alert-primary" role="alert">
                                       
                                      <h5 class="text-sm-center mt-1 mb-1"><?php echo $row["FirstName"]." ".$row["LastName"]."   "."has login the mobile app";?></h5>
                                
                                    </div><?php
         }
              $sql =$conn->query("SELECT `ID`, `FirstName`, `LastName`, `Role`, `StaffID`, `Email`, `Photo` FROM `admin_login_data` WHERE `loginDate`='$date' AND isStaff=0 ");
        foreach($sql as $row) {
          ?>                
                                    <div class="alert alert-primary" role="alert">
                                       
                                      <h5 class="text-sm-center mt-1 mb-1"><?php echo $row["FirstName"]." ".$row["LastName"]."   "."has login the desktop app";?></h5>
                                
                                    </div><?php
         }
             
          ?>                
                                </div>
                            </div>



                        </div>


                        <div class="col-md-6">

                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Map Tracking</strong>
                                </div>
                                <div class="card-body">
                                    <div id="map" class="map"></div>


                                </div>
                            </div>

                         
 <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Firebase -->

        <script>
            var myVarFromPhp = '<?php echo $_GET["id"] ?>';

            var config = {
                apiKey: "AIzaSyAcGFoFMNeRuyykA_LypQBifSLM93KZBBw",
    databaseURL: "https://IziGourmet.firebaseio.com/",
    projectId: "IziGourmet",
            };
            firebase.initializeApp(config);
        </script>

        <script>
            // counter for online cars...
            var staffcount = 0;
            // markers array to store all the markers, so that we could remove marker when any car goes offline and its data will be remove from realtime database...
            var markers = [];
            var map;
             var marker;
               var image = 'http://139.59.38.160/IziGourmet/human.png';
            function initMap() { // Google Map Initialization... 
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: new google.maps.LatLng(26.094040, 91.791473),
                    mapTypeId: 'terrain'
                });
                 marker = new google.maps.Marker({
                    position: new google.maps.LatLng(26.094040, 91.791473),
                    icon: image,
                    map: map
                });
            }
              
            // This Function will create a car icon with angle and add/display that marker on the map
            function AddStaff(data) {
               
             
                  
      
                    var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Staff Name</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Name </b>'+ data.val().Name
      '</div>'+
      '</div>';

 var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

 var center1 = new google.maps.LatLng(data.val().pLatitude, data.val().pLongitude);  
      var circle = new google.maps.Circle({
            center: center1,
            map: map,
            radius: 200,          // IN METERS.
            fillColor: '#FF6600',
            fillOpacity: 0.3,
            strokeColor: "#FF6347",
            strokeWeight: 2         // DON'T SHOW CIRCLE BORDER.
        });


          
           changeMarkerPosition(marker,data.val().MyLat, data.val().MyLong);
              
              
                markers[data.key] = marker; // add marker in the markers array...
                document.getElementById("staff").innerHTML = staffcount;
                 marker.addListener('click', function() {
          infowindow.open(map, marker);
      
        });
             
            
        }
            // get firebase database reference...
            var staff_ref =  firebase.database().ref('login').child(myVarFromPhp);
  staff_ref.on('value', function(childSnapshot) {

  childSnapshot.forEach(function(snapshot) {

     
                  AddStaff(snapshot);

        
          });
        });

  function changeMarkerPosition(marker,Lat,Long) {
    var latlng = new google.maps.LatLng(Lat, Long);
    marker.setPosition(latlng);
}
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBakiaDFinDdeu7GGk0S4dU03dQ7_H9-gA&callback=initMap">
        </script>

                        </div>
                    </div>
                </div> <!-- .alerts -->


            </div><!-- .animated -->
        </div><!-- .content -->


             
 

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/init-scripts/chart-js/chartjs-init.js"></script>
  <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/widgets.js"></script>
   
</body>

</html>
