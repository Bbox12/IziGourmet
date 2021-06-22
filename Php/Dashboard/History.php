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
    <title>History</title>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order History</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
          
                                                  

                    <div class="col-md-12">
                        <div class="card" >
                         <div class="card-header">
                                <strong class="card-title">Orders</strong>
                            </div>
                            <div class="card-body" >
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                                     <th>Sl No</th>
                                                          <th>Customer Name</th>
                                                              <th>Mobile No</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                         <th>Cost of Items</th>
                                            <th>ME Price</th>
                                            <th>Profit</th>
                                        
                                            <th>Status</th>

                                            <th>Payment</th>
                                            <th>Paid</th>
         <th>Rating</th>
                                              <th>Details</th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>
                                               <?php
                      require_once 'DB_Connect.php';
                
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                         $server_ip="139.59.38.160";
                        $users =$conn->query("SELECT s.ID,b.Driver_Rating_By_User,b.PaymentMode,b.PaymentVerified,b.Is_Paid,(SELECT Name FROM user_details WHERE ID=s.UserID) AS `UserID`,(SELECT Phone_No FROM user_details WHERE ID=s.UserID) AS `Mobile`,s.OrderID,s.CanteenID,s.Date, s.Time,d.Delivered,(SELECT SUM(MRP) FROM foods f INNER JOIN store_order s ON s.FoodID=f.ID WHERE s.OrderID=d.OrderID) AS `MRP`,(SELECT SUM(JalpanPrice) FROM foods f INNER JOIN store_order s ON s.FoodID=f.ID WHERE s.OrderID=d.OrderID) AS `ME` FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID INNER JOIN book_ride b ON b.OTP=d.OrderID WHERE b.User_ID=s.UserID  GROUP BY d.ID ORDER BY b.ID DESC");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                
                          <td><?php echo $count; ?></td>
                                            <td><?php echo $user['UserID']; ?></td>
                        <td><?php echo $user['Mobile']; ?></td>
                        <td><?php echo $user['OrderID']; ?></td>
                        <td><?php echo $user['Date']; ?></td>
                             <td><?php echo $user['MRP']; ?></td>
                        <td><?php echo $user['ME']; ?></td>
                          <td><?php echo ($user['MRP']-$user['ME']); ?></td>
                        <td><?php if($user["Delivered"]==0){
                                          echo "Pending";
                                          }elseif($user["Delivered"]==1){
                                           echo "Accepted";
                                           }elseif($user["Delivered"]==2){
                                                echo "Accepted";
                                          } elseif($user["Delivered"]==3){
                                                echo "Driver Assigned";
                                          }elseif($user["Delivered"]==4){
                                                echo "On the way";
                                          }elseif($user["Delivered"]==5){
                                                echo "Delivered";
                                          }elseif($user["Delivered"]==6){
                                                echo "Cancelled";
                                          }  
                                      ;?></td>
                                                <td><?php if($user["PaymentMode"]==0){
                                          echo "Pending";
                                          }elseif($user["PaymentMode"]==1){
                                           echo "COD";
                                           }elseif($user["PaymentMode"]==2){
                                                echo "EFT";
                                          } 
                                      ;?></td>
                                       <td><?php 
                                       if($user["PaymentMode"]==1){
                                       	if($user["Is_Paid"]==0){
                                          echo "Pending";
                                          }elseif($user["Is_Paid"]==1){
                                           echo "PAID";
                                           }
                                       }else  if($user["PaymentMode"]==2){
                                            if($user["PaymentVerified"]==0){
                                          echo "Pending";
                                          }elseif($user["PaymentVerified"]==1){
                                           echo "PAID";
                                           }
                                          } 
                                      ;?></td>
                                          <td><?php if($user["Driver_Rating_By_User"]==0){
                                          echo "Not Rated";
                                          }else{
                                           echo $user["Driver_Rating_By_User"];
                                           }
                                      ;?></td>
<td> <a href="ProfileDelivered.php?id=<?php echo $user["OrderID"];?>" style="color:blue;">Details</a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No user(s) found......</td></tr>
                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                       
                        </div>
                    </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
   
                  
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
