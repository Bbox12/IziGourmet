<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Location</title>
    <meta name="description" content="IziGourmet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link href="css/style.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>



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


 <div id="main-wrapper">

           <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="admin.php">
                    <b class="logo-abbr"><img src="images/logo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
                    <span class="brand-title">
                        <img src="images/logo-text.png" alt="">
                    </span>
                </a>
            </div>
        </div>

 


                <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
          
                <div class="header-right">
                    <ul class="clearfix">
                     
                        <li class="icons dropdown"><a href="./getComments.php" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2 badge-primary"><?php  
                        
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
                            </a>
                           
                        </li>
                      
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="images/l-dark.png.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <li>
                                            <a href="getComments.php"><i class="icon-envelope-open"></i> <span>Inbox</span> <div class="badge gradient-3 badge-pill badge-primary"><?php  
                        
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
        ?></div></a>
                                        </li>
                                        
                                        <hr class="my-2">
                                       
                                        <li><a href="page-login.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


   <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                     <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-check menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                     
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-check menu-icon"></i><span class="nav-text">Seetings</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./DefaultSettings.php">App Settings</a></li>
                            <li><a href="./AddImages.php">Images</a></li>
                          
                        </ul>
                    </li>
                   
                    <li>
                        <a class="has-arrow" href="./PushNotification.php" aria-expanded="false">
                            <i class="icon-envelope menu-icon"></i> <span class="nav-text">Notification</span>
                        </a>
                       
                    </li>
                          
                    <li>
                        <a class="has-arrow" href="./StoreLocation.php" aria-expanded="false">
                            <i class="icon-check menu-icon"></i> <span class="nav-text">Location</span>
                        </a>
                       
                    </li>


                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-check menu-icon"></i> <span class="nav-text">Category</span>
                        </a>
                        <ul aria-expanded="false">
                          
                            <li><a href="./AddPrimaryService.php">Primary Category</a></li>
                            <li><a href="./AddNewSecondaryService.php">Secondary Category</a></li>
                            <li><a href="./AddSecondaryService.php">Third Category</a></li>
                         
                        </ul>
                    </li>
                      <li>
                       <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-check menu-icon"></i> <span class="nav-text">Products</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./AllProducts.php"> All Products</a></li>
                     
                            <li><a href="./AddFinalService.php">Add Products</a></li>
                        </ul>
                    </li>
                       <li>
                 <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-check menu-icon"></i><span class="nav-text">Orders</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./CurrentOrders.php">Current</a></li>
                            <li><a href="./History.php">History</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Geofence</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
         

                <div class="row">
          
                                                  

                  
                                              <div class="col-lg-12">
                                                 <div class="card">
                                                    <div class="card-header">
                                                        <strong>New Working Sites</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                        <form action="addStoreLocation.php" method="post"  target="_self" class="form-horizontal">
                                                            
                                              
                                       

                                                    <div class="card-body card-block">
                                                    
                                           
                                                  <div class="row input-group">                   
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Name</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Name" name="Name" placeholder="Enter the name" class="form-control"  required></div></div>

                                <div class="row input-group" style="margin-top: 20px;">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Phone No</label></div>
                              <div class="col-9 col-md-9"><input type="text" id="Phone" name="Phone" placeholder="Mobile No"  class="form-control"  ></div>
                           
                                                            </div>

     						 <div class="row input-group" style="margin-top: 20px;">     
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Address</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="address1" name="address1" placeholder="address" class="form-control"  required></div>
                             </div>
                             
                      
                                                     
                                                          
                                                                      <div class="row input-group" style="margin-top: 20px;">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Latitude</label></div>
                              <div class="col-9 col-md-9"><input type="text" id="Latitude" name="Latitude" placeholder="0.000000" value="0.000000" class="form-control"  ></div>
                           
                                                            </div>
                                                             
                                                    
                                                                      
                                                                      <div class="row input-group" style="margin-top: 20px;">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Longitude</label></div>
                                 <div class="col-9 col-md-9"><input type="text" id="Longitude" name="Longitude" class="form-control"   placeholder="0.000000" value="0.000000"></div>
                       
              
                                                          </div>

                                                           <div class="row input-group" style="margin-top: 20px;">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class="form-control-label">Distance </label></div>
                              <div class="col-9 col-md-9"><input type="text" id="distance" name="distance" placeholder="Radius in KM  " value="0" class="form-control"  ></div>
                           
                                                            </div>
                                                     

                                               
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-dot-circle-o"></i> Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-ban"></i> Reset
                                                        </button>
                                                  
                                                          </form>
                                                            </div>
                                                </div>
                                             </div>
                    
                                        </div><!-- .animated -->

                                                                      <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Shops with radius</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
          
                                                            <div class="col-lg-6" >
                        <div class="card">
                         
                              
                                             
                                                     
                                                    <div class="card-body card-block">
                            
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl/No</th>
                                                <th>Name(Edit)</th>
                                                         <th>Mobile No</th>
                                                               <th>Radius</th>               
                                                 <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                  <?php
                      require_once 'DB_Connect.php';
              
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                         $server_ip="139.59.38.160";
                       $users =$conn->query("SELECT `ID`, `Name`, `Phone_No`, `Email`, `Aboutus`, `Address`, `State`, `City`, `Pin_No`, `Latitude`, `Longitude`, `Distance`, `isActive`, `Date`, `Time` FROM `tez_Canteen` WHERE `isActive`=1");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
           <td><a href="EditShops.php?id=<?php echo $user['ID']; ?>" style="display:block;color: blue;"><u><?php echo $user['Name']; ?></u></a></td>
                               <td><?php echo $user['Phone_No']; ?></td>
                  <td><?php echo $user['Distance']; ?>KM</td>
                          
                        <td><a href="SiteDeleteShop.php?id=<?php echo $user['ID']; ?>" style="color: red;"><?php echo "DEL"; ?></td>
              
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No user(s) found......</td></tr>
                    <?php endif; ?>
                                    </tbody>
                                </table>                              
                                                
                        </div>
               

</div>
</div>
                        <div class="col-lg-6" >
                      <div class="card">
                                               
                            <div class="card-header">
                                <strong class="card-title">Not Active Shops</strong>
                            </div>
                              
                                             
                                                     
                                                    <div class="card-body card-block">
                            
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl/No</th>
                                                <th>Name(Edit)</th>
                                                         <th>Mobile No</th>
                                                               <th>Radius</th>            
                                                       
                                                 <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                                  <?php
                      require_once 'DB_Connect.php';
              
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                         $server_ip="139.59.38.160";
                       $users =$conn->query("SELECT `ID`, `Name`, `Phone_No`, `Email`, `Aboutus`, `Address`, `State`, `City`, `Pin_No`, `Latitude`, `Longitude`, `Distance`, `isActive`, `Date`, `Time` FROM `tez_Canteen` WHERE `isActive`=0");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $user['Name']; ?></td>
                         <td><?php echo $user['Phone_No']; ?></td>
                  <td><?php echo $user['Distance']; ?>KM</td>

                        <td><a href="SiteActiveShop.php?id=<?php echo $user['ID']; ?>" style="color: green;"><?php echo "Activate"; ?></td>
              
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No user(s) found......</td></tr>
                    <?php endif; ?>
                                    </tbody>
                                </table>                              
                                                
                        </div>
                    </div>

</div>
                                      
                                    </div><!-- .content -->
                                </div>
                                 
  </div><!-- /#right-panel -->
                                <!-- Right Panel -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy;  <a href="#">IziGourmet</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
        </div> 
    <script>

/*var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('address1'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component', 'geometry']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
 var lat;
 var lng;
  var place = autocomplete.getPlace();

  if(!place.geometry){
    alert("Could not reach Google Server!Please try again.")
  }else{
 lat = place.geometry.location.lat();
   lng = place.geometry.location.lng();
  }
  

    document.getElementById('Latitude').value=lat;

    document.getElementById('Longitude').value=lng;
  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
  
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
 
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }

}*/
    </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSgfQvCrB2dVjQgNYSdsjnP6cis-l4rQw&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>
