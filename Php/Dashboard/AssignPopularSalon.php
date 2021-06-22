<!doctype html>

<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assign Popular Shops</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="assets/css/style.css">

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

                      <h3 class="menu-title">Jalpan Page</h3>
                     <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Add </a>
                        <ul class="sub-menu children dropdown-menu">
                           <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="AddCategory.php">Shop Category</a></li>
                             <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="VerifyShop.php">Verify Shop</a></li>
                               <li><i class="menu-icon fa fa-sign-in"></i><a href="PushNotification.php">Push Notification</a></li>
                                 <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="stafftracker.html">Google Map </a></li>
                                   <li><i class="menu-icon fa fa-pencil-square-o"></i><a href="AssignPopularShop.php">Popular Shop</a></li>
                        </ul>
                    </li>


                      <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Category</a>
                        <ul class="sub-menu children dropdown-menu">
                              <li><i class="menu-icon fa fa-th"></i><a href="AddBrands.php">Brands</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="AddPrimaryService.php">Primary Category</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="AddSecondaryService.php">Secondary Category</a></li>
                                 <li><i class="menu-icon fa fa-th"></i><a href="AddThirdService.php">Third Category</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="AddFinalService.php">Products</a></li>
            
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
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
   <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                            
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
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="index.php">Dashboard</a></li>
                            <li><a href="#">Shop</a></li>
                            <li class="active">Assign Popular Shop</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    

                                          <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row" id="taken">
                   
          <div class="col-lg-6">
                              <form action="sendShopCode.php" method="post" enctype="multipart/form-data" target="_self" >
                        <div class="card" >
                            <div class="card-header">
                                <strong class="card-title">Available Shop</strong>
                            </div>  
                            <div class="card-body" >
                                           

          
                                                       
                                                              
                       <div class="col col-md-6">
                        
                                                                        <div class="form-check">
                                   <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        session_start();
        $email=$_SESSION["email"];
        if(!$conn){
        echo "Put manually"; 
         }else {  
      $sql =$conn->query("SELECT ID,parlour_name AS Name FROM Shop_registration WHERE  isDeleted=0 AND isHold=0 AND PopularShop=0 ");
        foreach($sql as $row1) {
            ?> <div class="checkbox">
                                    <label for="checkbox" class="form-check-label "><input type="checkbox" id="IssueToH" name="check_list[]"  class="form-check-input"  value="<?php echo $row1['ID'];?>" ></label> </div><?php
                    echo $row1['Name'];
                                     }

                
}
?>
                        
                           </div>
                                                            </div>
                                                        </div>
                                                   
                                                    </div>
                      
             
                
                                                         <button type="submit" class="btn btn-primary btn-lg btn-block" style="height: 56px;">
                                                            <i class="fa fa-angle-double-right"></i>
                                                        </button>
                                                                 </form>
                    </div>


                      <div class="col-lg-6" >
                      
                                                          
                        <div class="card"  id="given">
                            <div class="card-header">
                                <strong class="card-title">Assigned Popular Shop</strong>
                            </div>
                                <form action="deAssignShop.php" method="post" enctype="multipart/form-data" target="_self" >
                                 
                                             
                                             
             <div class="col-lg-6">
                         
                                                    <div class="form-check">
                                <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        session_start();
        $email=$_SESSION["email"];
        if(!$conn){
        echo "Put manually"; 
         }else {  
             $sql =$conn->query("SELECT ID,parlour_name AS Name FROM Shop_registration WHERE  isDeleted=0 AND isHold=0 AND PopularShop=1 ");
        foreach($sql as $row1) {
            ?>    <div class="checkbox">
                                                                                <label for="checkbox" class="form-check-label "><input type="checkbox" id="IssueToH" name="check_list[]"  class="form-check-input"  value="<?php echo $row1['ID'];?>"></label> </div><?php
                    echo $row1['Name'];
                                     }

               
}
?>
                        
                           </div>  
                       
              </div>
                <button type="submit" class="btn btn-danger btn-lg btn-block" style="height: 56px; margin-top: 50px;">
                                                            <i class="fa fa-angle-double-left"></i> 
                                                        </button>
                                                    </form>

</div>


                </div>
            </div>
      </div>
            </div>
 

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="assets/js/init-scripts/data-table/datatables-init.js"></script>
    <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>

</body>
</html>
