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

    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

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
      var error = '<?php session_start();echo $_SESSION["error"] ?>';
  if(admin!=1){
  	window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }
  if(myVarFromPhp==''){
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }else{
 
      if(error==1){
alert("Successfully stored information.");
  }else{
    if(error==2){
alert("Error in Storing information");
  }
  }
  }
    //alert("this.responseText");  
       myFunc();

};
</script>
  <script type="text/javascript">
function myFunc() {


 // alert("this.responseText");  

 var i;
    var data =[];
    var labels =[];
  var data1 =[];
  var xmlhttp;
    if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.onreadystatechange=function() {

 
    if (this.readyState==4 && this.status==200) {
          
         var arr = JSON.parse(this.responseText);
        //alert(this.responseText);  
         var i;
             if(arr.length!=0){
                     data1.push('');
                                 data.push('');
                                    labels.push("");
                               for( i=0;i<arr.length;i++){

                                          data.push(arr[i].Count);

                                          labels.push(arr[i].symDate);
                            
                                 data1.push(arr[i].Total);
                      
                    
                               }

                               var ctx = document.getElementById( "mem-cha" );
    ctx.height = 100;
    var myChart = new Chart( ctx, {
        type: 'bar',
        data: {
        labels: labels,
            datasets: [
                {
                    label: "total Orders",
                    data: data1,
                    borderColor: "rgba(0, 123, 255, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(31, 252, 0, 0.5)"
                            },
                            {
                    label: "Delivered",
                    data: data,
                    borderColor: "rgba(0, 123, 255, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "rgba(255, 0, 0, 0.5)"
                            }
                     
                        ]

        },
       
    } );

  }else{
      document.getElementById( "graphs" ).style.display="none";     
  }
}
}
 xmlhttp.open("POST","getHealth.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send("");
 
};
</script>



</head>

<body onload="myFunction()">

    <?php session_start();
       $_SESSION["error"]='';?>

   



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
                             
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                      
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
                                       
                                        <li><a href="page-login.html"><i class="icon-key"></i> <span>Logout</span></a></li>
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
                            <i class="icon-screen-tablet menu-icon"></i> <span class="nav-text">Category</span>
                        </a>
                       <ul aria-expanded="false">
                                    <li><a href="./AllProducts.php">Products</a></li>
                            <li><a href="./AddPrimaryService.php">Primary Category</a></li>
                            <li><a href="./AddNewSecondaryService.php">Add Falovour</a></li>
                            <li><a href="./AddSecondaryService.php">Add Side Category</a></li>
                            <li><a href="./AddFinalService.php">Add Products</a></li>
                          
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

          <div class="content mt-3" >

         
              <div class="col-sm-12 ">
                <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Orders</strong>
                                </div>
                                <div class="card-body">
                                
        <div class="card-group">   

          <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT b.Type,s.ID,(SELECT Name FROM user_details WHERE ID=s.UserID) AS `UserID`,(SELECT Phone_No FROM user_details WHERE ID=s.UserID) AS `Mobile`,s.OrderID,s.CanteenID,s.Date, s.Time,d.Delivered FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID INNER JOIN book_ride b ON b.OTP=d.OrderID WHERE d.Delivered<5  GROUP BY d.ID");
        foreach($sql as $row) {

          ?>     
                       
          <div class="col-md-3">
                        <aside class="profile-nav alt">
                            <section class="card">
                        
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <a href="#"> <i ></i>Customer Name<span class="badge  pull-right"><?php echo $row["UserID"];?></span></a>
                                    </li>

                                      <li class="list-group-item">
                                        <a href="#"> <i ></i>Mobile No<span class="badge badge-success pull-right"><?php echo $row["Mobile"];?></span></a>
                                    </li>
                                 
                                    <li class="list-group-item">
                                        <a href="#"> <i ></i>Order ID<span class="badge badge-success pull-right"><?php echo $row["OrderID"];?></span></a>
                                    </li>
                                  
                                     <li class="list-group-item">
                                        <a href="#"> <i ></i>Date<span class="badge badge-danger pull-right"><?php echo $row["Date"];?></span></a>
                                    </li>
                                      <li class="list-group-item">
                                        <a href="#"> <i ></i>Status<span class="badge badge-danger pull-right"><?php if($row["Delivered"]==0){
                                          echo "Pending";
                                          }elseif($row["Delivered"]==1){
                                           echo "Accepted";
                                           }elseif($row["Delivered"]==2){
                                                echo "Accepted";
                                          } elseif($row["Delivered"]==3){
                                                echo "Driver Assigned";
                                          }elseif($row["Delivered"]==4){
                                                echo "On the way";
                                          }elseif($row["Delivered"]==5){
                                                echo "Delivered";
                                          }elseif($row["Delivered"]==6){
                                                echo "Cancelled";
                                          }    
                                      ;?></span></a>
                                    </li>
                                      <li class="list-group-item">
                                        <a href="#"> <i ></i>Type<span class="badge badge-danger pull-right"><?php if($row["Type"]==0){
                                          echo "Home delivery";
                                          }elseif($row["Type"]==1){
                                           echo "Store Pickup";
                                           }   
                                      ;?></span></a>
                                    </li>
                                          
                                   <li class="list-group-item">
                                        <a href="Profile.php?id=<?php echo $row["OrderID"];?>" style="color: blue;">Details</a>
                                    </li> 
                                  
                                </ul>

                            </section>
                        </aside>
                    </div>  <?php
         }
     }
        ?>
    
</div>
    </div>
  </div>
    </div>      </div>
          
   <!-- .content -->


<div class="content mt-3" id="graphs" >
            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Order request</strong>
                                </div>
                                <div class="card-body" >
                                
  
                               
                                <canvas id="mem-cha"></canvas>
                 
                        </div>
                    </div><!-- /# column -->

               
                 
                </div>

                 <div class="content mt-3">

         
              <div class="col-sm-12 mb-4">
        <div class="card-group">
                      <div class="card col-md-6 no-padding ">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="h4 mb-0">
                        <span class="count" ><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
          $sql =$conn->query("SELECT COUNT(ID) FROM delievered   ");
        foreach($sql as $row) {
echo $row['COUNT(ID)'] ;
         }
     }
        ?></span>
                    </div>
                    <small class="text-muted text-uppercase font-weight-bold">Total Order</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-2" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-md-6 no-padding ">
                <div class="card-body" >
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-stack-exchange "></i>
                    </div>

                    <div class="h4 mb-0">
                        <span class="count" ><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
          $sql =$conn->query("SELECT COUNT(ID) FROM delievered WHERE Delivered=5  ");
        foreach($sql as $row) {
echo $row['COUNT(ID)'] ;
         }
     }
        ?></span>
                    </div>

                    <small class="text-muted text-uppercase font-weight-bold">Total Delivered</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-1" style="width: 40%; height: 5px;"></div>
                </div>
            </div>

            <div class="card col-md-6 no-padding ">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-clock-o "></i>
                    </div>
                    <div class="h4 mb-0">
                     <span class="count" ><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
          $sql =$conn->query("SELECT COUNT(ID) FROM delievered WHERE Delivered!=5 && Delivered!=6 ");
        foreach($sql as $row) {
echo $row['COUNT(ID)'] ;
         }
     }
        ?></span>
                    </div>
                    <small class="text-muted text-uppercase font-weight-bold">Pending Delivery</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-3" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
                   <div class="card col-md-6 no-padding ">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="h4 mb-0" ><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
           $sql =$conn->query("SELECT SUM(Cost) AS Cost FROM book_ride WHERE Is_Paid=1");
        foreach($sql as $row) {
echo "R".$row['Cost'] ;
         }
     }
        ?></div>
                  <small class="text-muted text-uppercase font-weight-bold">Total Earning</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-5" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-md-6 no-padding ">
              <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                        <i class="fa fa-sticky-note-o "></i>
                    </div>
                    <div class="h4 mb-0">
                        <span class="count" ><?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
          $sql =$conn->query("SELECT COUNT(ID) FROM foods WHERE Unit<10 ");
        foreach($sql as $row) {
echo $row['COUNT(ID)'] ;
         }
     }
        ?></span>
                    </div>
                    <small class="text-muted text-uppercase font-weight-bold">No of items in Critical Stock</small>
                    <div class="progress progress-xs mt-3 mb-0 bg-flat-color-4" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
     
          
        </div>
    </div>
        </div> 
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
        </div> 
   

    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="./js/dashboard/dashboard-1.js"></script>
</body>

</html>
