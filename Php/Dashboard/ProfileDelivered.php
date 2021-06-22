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
 <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




    <link href="css/style.css" rel="stylesheet">

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
    var orderid = '<?php echo $_GET["id"] ?>';
    document.getElementById("orderid").value=orderid;
  var myVarFromPhp = '<?php session_start();echo $_SESSION["email"] ?>';
    var admin = '<?php session_start();echo $_SESSION["admin"] ?>';
  if(admin!=1){
    window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }
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
                            <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                     
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Seetings</span>
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
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Orders</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./CurrentOrders.php">Current</a></li>
                            <li><a href="./History.php">History</a></li>
                        </ul>
                    </li>
                     <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-screen-tablet menu-icon"></i> <span class="nav-text">Category</span>
                        </a>
                        <ul aria-expanded="false">
                                    <li><a href="./AllProducts.php">Products</a></li>
                            <li><a href="./AddPrimaryService.php">Primary Category</a></li>
                            <li><a href="./AddNewSecondaryService.php">Secondary Category</a></li>
                            <li><a href="./AddSecondaryService.php">Third Category</a></li>
                            <li><a href="./AddFinalService.php">Add Products</a></li>
                          
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order Details</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">

         
              <div class="col-sm-12 mb-4">
        <div class="card-group">
          <?php  
                        
                                  require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
           $id=$_GET["id"];
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
             $sql =$conn->query("SELECT s.ID,(SELECT Name FROM user_details WHERE ID=s.UserID) AS `UserID`,(SELECT Phone_No FROM user_details WHERE ID=s.UserID) AS `Mobile`,s.OrderID,s.CanteenID,s.Date, s.Time,d.Delivered,d.Reason FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID WHERE  s.OrderID='$id' GROUP BY d.ID");
        foreach($sql as $row) {
          ?>                 <div class="col-md-3">
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
                                        <a href="#"> <i ></i>Reason for Cancellation<span class="badge badge-danger pull-right"><?php if($row["Reason"]==''){
                                          echo "Not cancelled";
                                          }else{
                                           echo $row["Reason"];
                                           }
                                      ;?></span></a>
                                    </li>
                                </ul>

                            </section>
                        </aside>
                    </div><?php
         }
     }
        ?>

 
                        

  <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        $id=$_GET["id"];

            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  

           $result =$conn->query("SELECT ID,UserID,OrderID FROM  store_order WHERE OrderID='$id'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
                  $UserID=$row["UserID"];
                       $CanteenID=$row["OrderID"];
        }
         }
          $result =$conn->query("SELECT ID FROM  delievered WHERE OrderID='$id'");
          
         if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
          $uID=$row["ID"];
            
        }
         }

           $sql =$conn->query("SELECT `ID`,Unique_Ride_Code, `From_Address`, `From_Latitude`, `From_Longitude`, `Cost`,pCost,Driver_ID,Vehicle_ID, PaymentMode, PaymentVerified FROM `book_ride` b  WHERE ID='$uID' AND User_ID='$UserID'");
        foreach($sql as $row) {

          ?>         <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Payment Mode</strong>
                         
                            </div>
                            <div class="card-body">
                                  <h2 class="text-sm-center mt-2 mb-1" style="color: red;"><strong class="card-title pl-2">Total:- R </strong><?php echo $row["Cost"];?></h2>

                                     <div class="location text-sm-center" style="color: green;">Old Total <h2><?php if($row["pCost"]==0){
                                           echo "NA";
                                           }else{
                                                echo $row["pCost"];
                                          } 
    ?></h2></div>
                          
   <div class="location text-sm-center">Payment Mode <h2><?php if($row["PaymentMode"]==0){
                                          echo "Not Choosen";
                                          }elseif($row["PaymentMode"]==1){
                                           echo "COD";
                                           }elseif($row["PaymentMode"]==2){
                                                echo "EFT";
                                          } 
    ?><?php if($row["PaymentMode"]==2){ if($row["PaymentVerified"]==0){?>
                                           <a href="#"><br>Status: Payment Pending<br></a>

                                         <?php
                                          }else{?>
                                           <a href="#"><br>Status: Payment Paid</a>

                                           <?php

                                          } 
                                        }

    ?>
    
    </h2>
     </div>
    
                                </div>
                          
                                
                            </div>
                        </div>

                        <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Address</strong>
                         
                            </div>
                            <div class="card-body">
                         
                                    <h5 class="text-sm-center mt-2 mb-1"><?php echo $row["From_Address"];?></h5>
                                    <div class="location text-sm-center"><?php echo $row["From_Longitude"];?></div>
                                      <div class="location text-sm-center"> <?php echo $row["From_Latitude"];?></div>
   <div class="location text-sm-center">Delivery agent <h2><?php if($row["Driver_ID"]!=0){
    $dID= $row["Driver_ID"];
     $sql =$conn->query("SELECT Name FROM `user_details` WHERE ID='$dID'");
        foreach($sql as $user) {
          echo $user["Name"];
        }
   }
    ?></h2></div>
      <div class="location text-sm-center">Vehicle No <br><?php if($row["Vehicle_ID"]!=0){
                echo $row["Vehicle_ID"];
      }
        ?></div>
                                </div>
                          
                                
                            </div>
                        </div>
                  <?php
         }
     }
        ?>

<!-- .content -->
              </div></div>



        
                    <div class="col-md-12">
                        <div class="card" >
                         <div class="card-header">
                                <strong class="card-title">Products</strong>
                            </div>
                            <div class="card-body" >
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                                     <th>Sl No</th>
                                                          <th>Item Name</th>
                                                              <th>Weight</th>
                                            <th>Unit</th>
                                            <th>Cost</th>
                                        
                                            <th>IziGourmet Price</th>
                                               <th>Discount</th>
                                              <th>Quantity required</th>
                                               <th>Total Price</th>
                                                <th>Total Discount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                               <?php
                      require_once 'DB_Connect.php';
                        $id=$_GET['id'];
                 
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                       $users =$conn->query("SELECT f.Name,f.Weight,f.MRP,f.JalpanPrice,s.NoofItems, f.Unit,f.Discount FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID  WHERE s.OrderID='$id'");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                   <td><?php echo $count; ?></td>
                                            <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Weight']; ?></td>
                        <td><?php echo $user['Unit']; ?></td>
                        <td><?php echo $user['MRP']; ?></td>
                        <td><?php echo $user['JalpanPrice']; ?></td>
                           <td><?php echo $user['Discount']; ?></td>
                             <td><?php echo $user['NoofItems']; ?></td>
                                    <td><?php echo ($user['NoofItems']*$user['JalpanPrice']); ?></td>
                                          <td><?php echo ($user['NoofItems']*$user['Discount']); ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No user(s) found......</td></tr>
                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                       
                        </div>
                             
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

          
                      <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>




   

</body>

</html>
