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
    <link href="jquery.datepicker2.css" rel="stylesheet">
      <link href="css/timepicki.css" rel="stylesheet">
 
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>


      <link href="./plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="./plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="./plugins/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="./plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Daterange picker plugins css -->
    <link href="./plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="./plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">


 <script type="text/javascript">
function myFunction() {
     
    document.getElementById('confirm').style.display="none";
      document.getElementById('deliverydetails').style.display="none";
           document.getElementById('update').style.display="none";
 document.getElementById('ontheway').style.display="none";
  document.getElementById('delivered').style.display="none";
    var orderid = '<?php echo $_GET["id"] ?>';
  //  alert(orderid);
    document.getElementById("orderid").value=orderid;
  var myVarFromPhp = '<?php session_start();echo $_SESSION["email"] ?>';
    var admin = '<?php echo $_SESSION["admin"] ?>';
  if(admin!=1){
    window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }
  if(myVarFromPhp==''){
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }else{
    var id='id='+<?php echo $_GET["id"] ?>;
      //  alert(id);  
 var xmlhttp;
    if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.onreadystatechange=function() {
 
    if (this.readyState==4 && this.status==200) {
          
         var arr = JSON.parse(this.responseText);
       //  alert(this.responseText);  
         var i;
             if(arr.length!=0){

            
                           
                               for( i=0;i<arr.length;i++){

                               // alert(arr[i].Name);

                                      document.getElementById('Name').innerHTML=arr[i].Name;
                                    document.getElementById('Address').innerHTML=arr[i].Address;

                                  if(arr[i].Delivered==1){
                                       document.getElementById('accept').style.display="none";
                                       document.getElementById('confirm').style.display="block";
                                   
                                  }
                                    if(arr[i].Delivered==2 ){
                                       document.getElementById('accept').style.display="none";
                                       document.getElementById('confirm').style.display="none";
                             if(arr[i].Type==0 ){
                                    
                                      document.getElementById('deliverydetails').style.display="block";
                                  }else{
                                     document.getElementById('delivered').style.display="block";
                                  }
                                }
                                if(arr[i].Delivered==3 && arr[i].Type==0 ){
                              document.getElementById('accept').style.display="none";
                                      document.getElementById('deliverydetails').style.display="block";
                                           document.getElementById('ontheway').style.display="block";
                                      //document.getElementById('accepted').style.display="none";
                                  }

 if(arr[i].Delivered==4 && arr[i].Type==0 ){
                              document.getElementById('accept').style.display="none";
                                      document.getElementById('deliverydetails').style.display="block";
                                       document.getElementById('delivered').style.display="block";
                                         document.getElementById('accepted').style.display="none";
                                     
  document.getElementById('ontheway').style.display="none";
                                  }

 document.getElementById('Driver').value=arr[i].Driver_ID;
                                  document.getElementById('Vehicle').value=arr[i].Vehicle_ID;
                                    if(arr[i].ETR.length!=0){
               
                            document.getElementById('mdate').value=arr[i].ETR;
                     
                                    }
                                   if(arr[i].pCost>1){
                document.getElementById('damt').value=arr[i].Cost;
                        document.getElementById('damt').readOnly=true;


                                   }

                                  
                               }
             }
  }
}
 xmlhttp.open("POST","getOrders.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send(id);
  }
};
</script>





                                                     
<script type="text/javascript">
  function myDelivered(id) {
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/OrderDelivered.php?id="+id);
  
};
</script>
<script type="text/javascript">
  function myOrderReject(id) {
        var empty=document.getElementById("reason").value;
        if(empty==''){
          alert("Please mention reason for cancel")
        }else{
         window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/OrderReject.php?id="+id+"&reason="+empty); 
        }

  
};
</script>

<script type="text/javascript">
  function IziGourmetVerify(id) {
   // alert(unique);
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/OrderVerify.php?id="+id);
  
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
                                <span class="badge badge-pill gradient-2 badge-primary"></span>
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
                                            <a href="getComments.php"><i class="icon-envelope-open"></i> <span>Inbox</span> <div class="badge gradient-3 badge-pill badge-primary"></div></a>
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
                        <a class="has-arrow" href="./admin.php" aria-expanded="false">
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
            $server_ip="139.59.38.160";
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  
             $sql =$conn->query("SELECT b.Type,s.ID,(SELECT Name FROM user_details WHERE ID=s.UserID) AS `UserID`,(SELECT Phone_No FROM user_details WHERE ID=s.UserID) AS `Mobile`,(SELECT Logout FROM user_details WHERE ID=s.UserID) AS `Logout`,s.OrderID,s.OrderID,s.Date, s.Time,d.Delivered FROM `store_order` s INNER JOIN delievered d ON s.OrderID=d.OrderID INNER JOIN book_ride b ON b.OTP=d.OrderID WHERE d.Delivered<5 AND s.OrderID='$id' GROUP BY d.ID");
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
                                        <a href="#"> <i ></i>Type<span class="badge badge-danger pull-right"><?php if($row["Type"]==0){
                                          echo "Home delivery";
                                          }elseif($row["Type"]==1){
                                           echo "Store Pickup";
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

          ?>         <div class="col-md-3"  id="c1">
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

                                            <button  id="verify" class="btn btn-primary btn-sm" onclick="IziGourmetVerify(<?php echo $row['ID'];?>)">
                                                            <i class="fa fa-dot-circle-o"></i> Verify
                                                        </button><?php
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

                        <div class="col-md-3" >
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
             <div class="col-md-3" >
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i><strong class="card-title pl-2">Shop Address</strong>
                         
                            </div>
                            <div class="card-body">
                         
                                    <h5 class="text-sm-center mt-2 mb-1" id="Name"></h5>
                                        <h5 class="text-sm-center mt-2 mb-1" id="Address"></h5>
                                </div>
                          
                                
                            </div>
                        </div>
</div>
     
</div>

<!-- .content -->
              



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
                                            <th style="color: red;">Stock</th>
                                                 <th style="color: green;">Quantity required</th>
                                            <th>Cost</th>
                                        
                                            <th>IziGourmet Price</th>
                                               <th>Discount</th>
                                         
                                               <th>Total Price</th>
                                                <th>Total Discount</th>
                                                     <th>Stock Available</th>
                                                       <th>Accept</th>
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                               <?php
                      require_once 'DB_Connect.php';
                        $id=$_GET['id'];
                 
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                       $users =$conn->query("SELECT s.ID,f.Name,f.Weight,f.MRP,f.JalpanPrice,s.NoofItems, f.Unit,f.Discount FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID   WHERE s.OrderID='$id'");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                   <td><?php echo $count; ?></td>
                                            <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Weight']; ?></td>
                        <td><?php 
                          echo $user['Unit'];
                        ?></td>
                              <td><?php echo $user['NoofItems']; ?></td>
                        <td><?php echo $user['MRP']; ?></td>
                        <td><?php echo $user['JalpanPrice']; ?></td>
                      
                       
                                    <td><?php echo ($user['Discount']); ?></td>

                                    <td><?php echo ($user['NoofItems']*$user['JalpanPrice']); ?></td>

                                          <td><?php echo ($user['NoofItems']*$user['Discount']); ?></td>

                                          <?php if($user["Unit"]-$user['NoofItems']>0){?>
                                              <td style="color: green;"><?php echo "YES"; ?></td>
                                          <?php }else{?>
                                          <td style="color: red; font-weight: bolder;"><?php echo "NO"; ?></td>
                                          <?php }?>
                                         <td> <input type='checkbox' id="out" onclick='handleClick(this,<?php echo $_GET['id']; ?>,<?php echo $user['ID']; ?>);' checked></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5">No user(s) found......</td></tr>
                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                       
                        </div>
                             
                    </div>


                    <div class="col-lg-12" id='accept' style="margin-top: 30px;">
                                                 <div class="card" >
                                                    <div class="card-header" style="background-color: green; color: white;">
                                                        <strong>Accept Order</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                             <div class="col-lg-12">


                                             

                                                    <div class="card-body card-block">

                                                              <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Message to customer</label></div>
                             <div class="col-9 col-md-9"><textarea type="text" lines=4 id="acceptmessage" name="acceptmessage"  class="input-sm form-control-sm form-control" ></textarea></div>
                           
                            
                                                            </div>
                                     
                                                      </div>



                                               
                                                        <button type="submit" class="btn btn-primary btn-sm" onclick="AcceptOrder(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-dot-circle-o"></i> Accept
                                                        </button>
                                                      
                                                   
                                                            </div>
                                                </div>
                                              
                                          
                                            </div>
                                        </div>

                                                                <div class="col-lg-12" id="confirm" style="margin-top: 30px;">
                                                 <div class="card" >
                                                    <div class="card-header" style="background-color: green; color: white;">
                                                        <strong>Confirm Order</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                             <div class="col-lg-12">


                                             

                                                    <div class="card-body card-block">

                                                              <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Message to customer</label></div>
                             <div class="col-9 col-md-9"><textarea type="text" lines=4 id="confirmmessage" name="confirmmessage"  class="input-sm form-control-sm form-control" ></textarea></div>
                           
                            
                                                            </div>
                                     
                                                      </div>



                                               
                                                        <button type="submit" class="btn btn-primary btn-sm" onclick="ConfirmOrder(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-dot-circle-o"></i> Accept
                                                        </button>
                                                      
                                                   
                                                            </div>
                                                </div>
                                              
                                          
                                            </div>
                                        </div>


                                        <div class="col-lg-12" id="update" >
                                                 <div class="card" >
                                                    <div class="card-header">
                                                        <strong>Update Order</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                        <form action="UpdateOrder.php" method="post" enctype="multipart/form-data" target="_self" class="form-horizontal">
                                                            <div class="col-lg-12">


                                              
                                       

                                                    <div class="card-body card-block">

                                                              <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Order ID</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Order" name="Order"  class="input-sm form-control-sm form-control" value="<?php echo $_GET["id"] ?>"></div>
                           
                            
                                                            </div>
                                                    
                                                                    <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="select" class="input-sm form-control-sm form-control-label">Product </label></div>
                                                                    <div class="col-6 col-md-6">
                                                                        <select id="ID" name="ID" class="input-sm form-control-sm form-control" required>
                                                                          <option value="">--Select--</option>

                                                                            <?php
                      require_once 'DB_Connect.php';
                        $id=$_GET['id'];
                 
                      $db = new Db_Connect();
                      $conn = $db->connect();
                    
      
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {                   $users =$conn->query("SELECT s.ID,f.Name,f.Weight,f.MRP,f.JalpanPrice,s.NoofItems, f.Unit,f.Discount FROM `store_order` s INNER JOIN foods f ON f.ID=s.FoodID  WHERE s.OrderID='$id'");
        foreach($users as $row) {
    ?>

 <option value="<?php echo $row['ID']; ?>">  
                                         <?php 
                                      
                                         echo $row['Name'];?>  
   </option>  
                      <?php
}
}
?>
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">New Quantity</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="CDNo" name="CDNo" placeholder="0 to delete the product" class="input-sm form-control-sm form-control" required></div>
                           
                            
                                                            </div>
                                                     
                                        
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
                                          
 </div>

                               
                                
                                   

                                              <div class="col-lg-12" id="deliverydetails" style="margin-top: 30px;">
                                                 <div class="card">
                                               <div class="card-header" style="background-color: brown; color: white;">
                                                        <strong>Delivery Details</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                      

                                                    <div class="card-body card-block" >
                                                    
                                                 <div class="row input-group">

                                                     <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Order ID</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="orderid" name="orderid"  class="input-sm form-control-sm form-control"  ></div></div>
                                                                    
                                      <div class="row input-group" style="margin-top: 5px;">
                                                                    <div class="col col-md-3"><label for="select" class=" input-sm form-control-sm form-control-label">Delivery agent</label></div>
                                                                
                                                                     <div class="col-9 col-md-9">
                                                                        <select id="Driver" name="Driver" class="input-sm form-control-sm form-control">
                                                                          <option value="0">Select--</option>

                                                                             <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  $sql =$conn->query("SELECT `ID`, Name  FROM `user_details` WHERE role=2");
        foreach($sql as $row) {
    ?>

 <option value="<?php echo $row['ID']; ?>">  
                                         <?php 
                                      
                                         echo $row['Name'];?>  
   </option>  
                      <?php
}
}
?>
                                                                        </select>
                                                                    </div></div>
                                                               
                                        <div class="row input-group" style="margin-top: 5px;">                        
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Vehicle No</label></div>
                          
                                         <div class="col-9 col-md-9">
                                                                        <select id="Vehicle" name="Vehicle"  class="input-sm form-control-sm form-control">
                                                                          <option value="0">Select--</option>

                                                                             <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  $sql =$conn->query("SELECT ID,`Vehicle_No` FROM `vehicle_detail`");
        foreach($sql as $row) {
    ?>

 <option value="<?php echo $row['Vehicle_No']; ?>">  
                                         <?php 
                                      
                                         echo $row['Vehicle_No'];?>  
   </option>  
                      <?php
}
}
?>
                                                                        </select>
                                                                    </div></div>
                                                                       <div class="col-12">
                                                                     <div class="card">
                            <div class="card-body">
                          
                          
                                <div class="row form-material">
                                    <div class="col-md-6">
                                        <label class="m-t-20">Estimated date</label>
                                        <input type="text" class="form-control" placeholder="0000-00-00" id="mdate" name="date">
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label class="m-t-20">Time </label>
                                        <input class="form-control" id="timepicker" name="time" placeholder="Check time">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                          <div class="col-12">
                                                                          <div class="card">
                            <div class="card-body">
                          
                          
                                <div class="row form-material">


                                       <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Enter the new TOTAL AMOUNT due by the customer</label></div>
                             <div class="col col-md-9"><input type="number" id="damt" name="damt" placeholder="Enter 0 if no discount" class="input-sm form-control-sm form-control"  ></div>
                               </div>
                            </div>
                        </div>
                         </div>

                     </div>
                       </div>
                             


                                                        
                                                     
                                              <button  id="accepted" class="btn btn-primary btn-sm" onclick="IziGourmetAccept(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-dot-circle-o"></i> Accept
                                                        </button>
                                                        
                                                        
                                                      
                                                 
                                                            </div>
                                                </div>
                                             </div>
       
          <div class="col-lg-12" id="delivered" style="margin-top: 30px;">
                                                 <div class="card">
                                               <div class="card-header" style="background-color: brown; color: white;">
                                                        <strong>Delivered?</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                    
                                                        
                                                         <button  id="delivered" class="btn btn-info btn-sm"onclick="myDelivered(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-handshake-o"></i> Delivered
                                                        </button>

                                                 
                                                            </div>
                                                </div>
                                             </div>
       
                                        

              <div class="col-lg-12" id="ontheway" style="margin-top: 30px;">
                                                 <div class="card" >
                                                    <div class="card-header" style="background-color: violet; color: white;">
                                                        <strong>On the way</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                            <div class="col-lg-12">


                                             

                                                    <div class="card-body card-block">

                                                              <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Message to customer</label></div>
                             <div class="col-9 col-md-9"><TEXTAREA type="text" lines=3 id="onreason" name="onreason"  class="input-sm form-control-sm form-control"></TEXTAREA></div>
                           
                            
                                                            </div>
                                     
                                                      </div>



                                               
                                                    <button   class="btn btn-warning btn-sm"onclick="myOntheway(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-handshake-o"></i> On the way
                                                        </button>
                                              
                                                            </div>
                                                </div>
                                              
                                          
                                            </div>
                                           </div>
                                  
                                                    <div class="col-lg-12" id="rejectreason" style="margin-top: 30px;">
                                                 <div class="card" >
                                                    <div class="card-header" style="background-color: red; color: white;">
                                                        <strong>Reject Order</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                            <div class="col-lg-12">


                                             

                                                    <div class="card-body card-block">

                                                              <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Message to customer</label></div>
                             <div class="col-9 col-md-9"><TEXTAREA type="text" lines=3 id="reason" name="reason"  class="input-sm form-control-sm form-control"></TEXTAREA></div>
                           
                            
                                                            </div>
                                     
                                                      </div>



                                               
                                                       <button  id="reject" class="btn btn-danger btn-sm"onclick="myOrderReject(<?php echo $_GET['id']?>)">
                                                            <i class="fa fa-ban"></i> Reject
                                                        </button>
                                                      
                                                            </div>
                                                </div>
                                              
                                          </div>
                                            </div>
                                     </div>
                                            </div>

                  
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
    <script src="jquery.datepicker2.js"></script>
    <script src="js/timepicki.js"></script>
 <script src="./plugins/moment/moment.js"></script>
    <script src="./plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="./plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="./plugins/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="./plugins/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="./plugins/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="./plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="./plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="./plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

    <script src="./js/plugins-init/form-pickers-init.js"></script>


  <script>
  $('#time').timepicki();
    </script>

<script type="text/javascript">
  function IziGourmetAccept(id) {

    var name=document.getElementById("Driver").value;

            var vehicle=document.getElementById("Vehicle").value;
               var date=document.getElementById("mdate").value;
                 var time=document.getElementById("timepicker").value;
        var damt=parseFloat(document.getElementById("damt").value).toFixed(2);

       //   alert(damt);
            if(name.length!=0 && vehicle.length!=0 ){
                if(!isNaN(damt)){
              window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/OrderAccpet.php?id="+id+"&name="+name+"&vehicle="+vehicle
                +"&date="+date+"&time="+time+"&damt="+damt);
            }else{
   window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/OrderAccpet.php?id="+id+"&name="+name+"&vehicle="+vehicle
                +"&date="+date+"&time="+time);
            }
            }else{
              alert("Please fill the from");
            }

  
};
</script>

<script type="text/javascript">
  function AcceptOrder(id) {
        var message=document.getElementById("acceptmessage").value;
        if(message==''){
         if (confirm("Empty message! Default message will show to customer")) {
         	 window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/AcceptOrder.php?id="+id+"&message="+message+"&role="+1); 
         }
        }else{
         window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/AcceptOrder.php?id="+id+"&message="+message+"&role="+1); 
        }

  
};
</script>

<script type="text/javascript">
  function ConfirmOrder(id) {
        var message=document.getElementById("confirmmessage").value;
        if(message==''){
         if (confirm("Empty message! Default message will show to customer")) {
         	 window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/AcceptOrder.php?id="+id+"&message="+message+"&role="+2); 
         }
        }else{
         window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/AcceptOrder.php?id="+id+"&message="+message+"&role="+2); 
        }

  
};
</script>

         <script>
function handleClick(cb,id,pd) {
	//alert("Clicked, new value = " + cb.checked);

  if(!cb.checked){
     if (confirm("Delete product! Are you sure?")) {
  window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/deleteProductID.php?id="+id+"&pd="+pd);
  } 
  }
}
</script>

<script type="text/javascript">

  function myOntheway(id) {

       var message=document.getElementById("onreason").value;
           //alert(message);
           var link="http://139.59.38.160/IziGourmet/Dashboard/OntheWay.php?id="+id+"&message="+message;
           //alert(link);
window.location.replace(link);
  
};
</script>


</body>

</html>
