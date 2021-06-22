<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ecosense Dashboard</title>
    <meta name="description" content="Ecosense">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="vendors/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" type="text/css" href="css/dncalendar-skin.min.css">

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
   var admin = '<?php session_start();echo $_SESSION["admin"] ?>';
  if(admin!=1){
    window.location.replace("http://139.59.38.160/Ecosense/Dashboard/page-login.php");
  }
  if(myVarFromPhp==''){
window.location.replace("http://139.59.38.160/Ecosense/Dashboard/page-login.php");
  }
};
</script>

<style>
ul#menu li {
  display:inline;
}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>


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

                     
 <h3 class="menu-title">WorkOrder</h3>
                     <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Add Task</a>
                        <ul class="sub-menu children dropdown-menu">
                             <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="AssignWorkingSiteToStaff.php">Assign Sites</a></li>
                               <li><i class="menu-icon fa fa-sign-in"></i><a href="PushNotification.php">Push Notification</a></li>
                                 <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="stafftracker.html">Google Map Track</a></li>
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

 
                      <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Handbook</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="NewHandBook.php">New</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="UpdateHandBook.php">Update</a></li>
                        
                        </ul>
                    </li>

            
                      <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-medkit"></i>Hailth & Safety</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="HealthSafety.php">New</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="UpdateHealthSafety.php">Update</a></li>
                        
                        </ul>
                    </li>

                 
    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Staff training</a>
                        <ul class="sub-menu children dropdown-menu">
                              <li><i class="menu-icon fa fa-th"></i><a href="StaffTraining.php">New</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="UpdateStaffTraining.php">Update</a></li>
                           
                        </ul>
                    </li>

                     <h3 class="menu-title">Working Site</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="BookingReport.php" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-folder-open"></i>Edit Sites</a>
                        <ul class="sub-menu children dropdown-menu">
                        <li><i class="menu-icon fa fa-sign-in"></i><a href="WorkingSites.php">New Sites</a></li>
                    
                     <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="AssignWorkingSiteToStaff.php">Assign Sites</a></li>
                    
                        
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
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"onclick="location.href = 'http://139.59.38.160/Ecosense/Dashboard/getComments.php';">
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
                        <h1>Work Details</h1>
                    </div>
                </div>
            </div>
     
        </div>

        <div class="content mt-3">

         
              <div class="col-sm-12 mb-4">
        <div class="card-group">
          <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
           $id=$_GET["id"];
            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT c.message,c.Duration,a.ID AS PID,w.ID as MAPID,w.WorkDate,w.WorkTime,c.ID as WorkID,c.Lauch_start,c.Launch_end,w.ID,(SELECT Name FROM new_site WHERE ID=w.SiteID) AS SiteName,a.FirstName AS   StaffID,a.Photo, c.clockinTime,c.clockoutTime,c.message,c.image1,c.image2,c.image3,c.image4 FROM `clockout` c INNER JOIN workingsites w ON w.ID=c.WorkingID   INNER JOIN admin_login_data a ON a.ID=w.StaffID WHERE   c.ID='$id'");
        foreach($sql as $row) {
          ?>                 <div class="col-md-4">
                        <aside class="profile-nav alt">
                            <section class="card">
                                <div class="card-header user-header alt bg-dark">
                                    <div class="media">
                                   
                                        <div class="media-body">
                                            <h2 class="text-light display-6"><?php echo $row["WorkDate"];?></h2>
                                       
                                          <p><?php echo $row["StaffID"];?></p>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                   
                                    <li class="list-group-item">
                                        <a href="#"> <i ></i>Assign Time <span class="badge badge-success pull-right"><?php echo $row["WorkTime"];?></span></a>
                                    </li>
                                   <li class="list-group-item">
                                        <a href="#"> <i ></i>Clock In Time<span class="badge badge-danger pull-right"><?php echo $row["clockinTime"];?></span></a>
                                    </li>
                                     <li class="list-group-item">
                                        <a href="#"> <i ></i>Launch Start Time<span class="badge badge-danger pull-right"><?php if(strcmp($row["Lauch_start"], "00:00:00")==0){echo "Not Taken";}else{echo $row["Lauch_start"];}
                                          ?></span></a>
                                    </li>
                                     <li class="list-group-item">
                                        <a href="#"> <i ></i>Launch End Time<span class="badge badge-danger pull-right"><?php if(strcmp($row["Launch_end"], "00:00:00")==0){echo "Not Taken";}else{echo $row["Launch_end"];}
                                          ?></span></a>
                                    </li>
                                      <li class="list-group-item">
                                        <a href="#"> <i ></i>Clock out Time<span class="badge badge-danger pull-right"><?php if(strcmp($row["clockoutTime"], "00:00:00")==0){echo "Still Working";}else{echo $row["clockoutTime"];}
                                          ?></span></a>
                                    </li>
                                <li class="list-group-item">
                                        <a href="#"> <i ></i>Duration of work<span class="badge badge-warning pull-right"><?php echo $row["Duration"];?></span></a>
                                    </li>
                                      <li class="list-group-item">
                                        <a href="#"> <i ></i>Comment<span class="badge badge-warning pull-right"><?php echo $row["message"];?></span></a>
                                    </li>
                                 
                                </ul>

                            </section>
                        </aside>
                    </div><?php
         }
     }
        ?>

      

  <div class="col-md-4">
                        <div class="card">
                          
                         
                                <div id="map" class="map"></div>
                       
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
    databaseURL: "https://ecosense.firebaseio.com/",
    projectId: "ecosense",
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
               var image = 'http://139.59.38.160/Ecosense/human.png';
            function initMap() { // Google Map Initialization... 
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: new google.maps.LatLng(52.8090871, -6.4622224),
                    mapTypeId: 'terrain'
                });
                 marker = new google.maps.Marker({
                    position: new google.maps.LatLng(52.8090871, -6.4622224),
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
                 map.panTo( new google.maps.LatLng(data.val().MyLat, data.val().MyLong) );


              
                markers[data.key] = marker; // add marker in the markers array...
                document.getElementById("staff").innerHTML = staffcount;
                 marker.addListener('click', function() {
          infowindow.open(map, marker);
      
        });
             
            
        }
            // get firebase database reference...
            var staff_ref =  firebase.database().ref('Staff').child(myVarFromPhp);
  staff_ref.on('value', function(childSnapshot) {

      
                  AddStaff(childSnapshot);

        
      
        });

  function changeMarkerPosition(marker,Lat,Long) {
    var latlng = new google.maps.LatLng(Lat, Long);
    marker.setPosition(latlng);
}
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBakiaDFinDdeu7GGk0S4dU03dQ7_H9-gA&callback=initMap">
        </script>
                 
      </div>

                <?php
                           require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        $id=$_GET["id"];
       date_default_timezone_set(TIMEZONE);
        $date=date("Y-m-d");

            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT n.ID, n.Name, n.ContactName, n.ContactNo, n.Address, n.Latitude, n.Longitude,w.WorkDate,w.WorkTime FROM `new_site` n INNER JOIN workingsites w ON w.SiteID=n.ID INNER JOIN clockout c ON w.ID=c.WorkingID WHERE  c.ID='$id'");
        foreach($sql as $row) {

          ?>             <div class="col-md-4">
                        <aside class="profile-nav alt">
                            <section class="card">
                                  <div class="card-header user-header alt bg-dark">
                                    <div class="media">
                                   
                                        <div class="media-body">
                                           <p> Site Details</p>
                                            <h2 class="text-light display-6"><?php echo $row["Name"];?></h2>
                                          
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                  
                                 
                                    <li class="list-group-item">
                                        <a href="#"> <i ></i>Contact Name<span class="badge badge-success pull-right"><?php echo $row["ContactName"];?></span></a>
                                    </li>
                                   <li class="list-group-item">
                                        <a href="#"> <i ></i>Contact No<span class="badge badge-danger pull-right"><?php echo $row["ContactNo"];?></span></a>
                                    </li>
                                <li class="list-group-item">
                                        <a href="#"> <i ></i>Address<span class="badge badge-success pull-right"><?php echo $row["Address"];?></span></a>
                                    </li>
                                
                            
                                </ul>

                            </section>
                        </aside>
                    </div><?php
         }
     }
        ?>
    </div>

          
        </div> <!-- .content -->
              
        <div class="content mt-3" >
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card" >
                         <div class="card-header">
                                <strong class="card-title">Photos</strong>
                                   <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
           $id=$_GET["id"];
            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT c.image1,c.image2,c.image3,c.image4 FROM `clockout` c INNER JOIN workingsites w ON w.ID=c.WorkingID   INNER JOIN admin_login_data a ON a.ID=w.StaffID WHERE   c.ID='$id'");
        foreach($sql as $row) {
          ?>                 <div class="col-md-12">
                        <aside class="profile-nav alt">
                            <section class="card">
                              <ul id="menu">
                                 <li><img id="myImg1" class="align-self-center " style="width:200px; height:200px;" alt="" src="<?php echo 'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$row["image1"];?>" width='200' height='200'></li>
                                <li><img  id="myImg2"class="align-self-center " style="width:200px; height:200px;" alt="" src="<?php echo 'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$row["image2"];?>" width='200' height='200'></li>
                                 <li><img id="myImg3" class="align-self-center " style="width:200px; height:200px;" alt="" src="<?php echo 'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$row["image3"];?>" width='200' height='200'></li>
                                <li><img id="myImg4" class="align-self-center " style="width:200px; height:200px;" alt="" src="<?php echo 'http://' . $server_ip . '/' .'Ecosense' .'/'.'Dashboard'.'/'.'worksite'. '/' .$row["image4"];?>" width='200' height='200'></li></ul>
                            </section>
                        </aside>
                    </div><?php
         }
     }
        ?>
                            </div>
                        
                        </div>
                 </div>
                         
                   </div>
                       </div>
                        </div>
                   <div id="myModal1" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<script>
// Get the modal
var modal = document.getElementById("myModal1");


// Get the image and insert it inside the modal - use its "alt" text as a caption
var img1 = document.getElementById("myImg1");
var modalImg = document.getElementById("img01");
img1.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}
var img2 = document.getElementById("myImg2");
var modalImg2 = document.getElementById("img02");
img2.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}
var img3 = document.getElementById("myImg3");
var modalImg3 = document.getElementById("img03");
img3.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}
var img4 = document.getElementById("myImg4");
var modalImg4 = document.getElementById("img04");
img4.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}

var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
  modal.style.display = "none";
   
}
</script>
    
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
