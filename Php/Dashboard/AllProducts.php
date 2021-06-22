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
    <title>All Products</title>
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
                            <li><a href="./AddNewSecondaryService.php">Add Falovour</a></li>
                            <li><a href="./AddSecondaryService.php">Add Side Category</a></li>
                            <li><a href="./AddFinalService.php">Add Products</a></li>
                          
                        </ul>
                    </li>
               
                </ul>
            </div>
        </div>
     

           <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">All Product Lists</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Table</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration">
                                         <thead>
                                        <tr>
                                                     <th>Sl No</th>
                                                          <th>Primary Category</th>
                                                              <th>Flavour</th>
                                       <th>Side</th>
                                            <th>Name</th>
                                        
                                            <th>Weight</th>
                                              <th>Stock</th>
                                               <th>Description</th>
                                             
                                         
                                            <th>Price</th>
                                            <th>Discount</th>
                                    
                                              <th>Image</th>
                                                    <th>Deal of the day</th>
                                                      <th>Out of stock</th>
 <th></th>
  <th></th>
 <th></th>

                                        </tr>
                                    </thead>
                                 <tbody>
                                               <?php
                      require_once 'DB_Connect.php';
                        $id=$_GET['id'];
                        $dept=$_GET['dept'];
                      $db = new Db_Connect();
                      $conn = $db->connect();
                        $date=date("Y-m-d");
                         $server_ip="139.59.38.160";
                       $users =$conn->query("SELECT `ID`,(SELECT `Name` FROM `subsubmenu` WHERE ID=f.IDSubmenu)AS `IDsubMenu`,(SELECT `Name` FROM `menu_type` WHERE ID=f.IDMenu)AS `IDMenu`,(SELECT `Category` FROM `submenu` WHERE  ID=f.IDSubsubmenu) AS  `IDSubsubmenu`, `Name`, `Weight`,`Unit`, `Description`,`MRP`, `JalpanPrice`, `Discount`,isOutOfStock, `Photo`,Recomended FROM `foods` f WHERE `Available`=1");
                        if(!empty($users)): $count = 0; foreach($users as $user): $count++;
                    ?>
                    <tr>
                
                          <td><?php echo $count; ?></td>
                                            <td><?php echo $user['IDMenu']; ?></td>
                                               <td><?php echo $user['IDsubMenu']; ?></td>
                        <td><?php echo $user['IDSubsubmenu']; ?></td>
                        <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Weight']."Kg"; ?></td>
                             <td><?php echo $user['Unit']; ?></td>
                                        <td><?php echo $user['Description']; ?></td>
                     
                             <td><?php echo $user['JalpanPrice']; ?></td>
                        <td><?php echo $user['Discount']; ?></td>

                          <td><img src="<?php echo 'http://' . $server_ip .'/' .'IziGourmet' .'/'.'Dashboard'.'/'.'products'.'/'.$user["Photo"];?>" width='48' height='48'></td>
                 <td><?php if($user['Recomended']==1){
                  echo "YES";
                 }else{
                        echo "NO";
                 }
                  ?></td>
          <td><?php if($user['isOutOfStock']==1){?>
                  <input type='checkbox' id="out" onclick='handleClick(this,<?php echo $user['ID']; ?>);' checked><?php
                 }else{?>
                       <input type='checkbox' id="out" onclick='handleClick(this,<?php echo $user['ID']; ?>);' ><?php
                 }
                  ?></td>



<td><a href="edit_products.php?id=<?php echo $user['ID']; ?>" style="display:block; width: 60px;">Edit</a></td>
<td>   <button type="button" class="btn btn-primary btn-sm" onclick="myDeactivate(<?php echo $user['ID']; ?>)" >Deactivate
                            
                        </button></td>
                        <td>   <button type="button" class="btn btn-danger btn-sm" onclick="myDelete(<?php echo $user['ID']; ?>)" >
                            Delete
                        </button></td>

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
                </div>
            </div>
            <!-- #/ container -->
        </div>
            <!-- row -->
                    
                      
                   

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
function myDeactivate(id) {

   var txt;
  if (confirm("Deactivate product! Are you sure?")) {
  window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/del_products.php?id="+id);
  } 
}
</script>

         <script>
function myDelete(id) {

   var txt;
  if (confirm("Delete product! Are you sure?")) {
  window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/del_products_complete.php?id="+id);
  } 
}

</script>

         <script>
function handleClick(cb,id) {

  if(cb.checked){
     if (confirm("Please confirm if the selected item is out of stock")) {
  window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/out_of_stock.php?id="+id+"&cb="+1);
  } 
  }else{
     if (confirm("Please confirm if the selected item is out of stock")) {
  window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/out_of_stock.php?id="+id+"&cb="+0);
  } 
  }

 
}
</script>

   <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
</body>
</html>
