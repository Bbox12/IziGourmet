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
    <title>Primary Service</title>
       <meta name="description" content="IziGourmet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

   <link href="css/style.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
      #locationField, #controls {
        position: relative;
        width: 200px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
        font-family: "Roboto";
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f9ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>

<script type="text/javascript">
function myFunction() {
  var myVarFromPhp = '<?php session_start();echo $_SESSION["email"] ?>';
    var error = '<?php session_start();echo $_SESSION["error"] ?>';
  if(myVarFromPhp==''){
window.location.replace("http://139.59.38.160/IziGourmet/Dashboard/page-login.php");
  }else{
     if(error!=''){
      if(error==1){
alert("Successfully stored information.");
  }else{
    if(error==2){
alert("Error in Storing information");
  }else{
    alert("Please check the information");
  }
  }
}
var id='id='+<?php echo $_GET["id"] ?>;


 var xmlhttp;
    if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.onreadystatechange=function() {
 
    if (this.readyState==4 && this.status==200) {
          
         var arr = JSON.parse(this.responseText);
         console.log(this.responseText);  
         var i;
             if(arr.length!=0){
                           
                               for( i=0;i<arr.length;i++){

                                      document.getElementById('ID').value=arr[i].ID;
                            
                                  document.getElementById('Name').value=arr[i].Name;
                      
                       document.getElementById('special').value=arr[i].Specification;
                            
                                  document.getElementById('Description').value=arr[i].Description;

                                    document.getElementById('color').value=arr[i].Colors;
                               }
             }
  }
}
 xmlhttp.open("POST","getPrimaryService.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xmlhttp.send(id);
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

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Primary Category</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                                                  

                  
                                              <div class="col-lg-12">
                                                 <div class="card">
                                                    <div class="card-header">
                                                        <strong>Edit Primary Category</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                        <form action="editPrimaryServices.php" method="post" enctype="multipart/form-data" target="_self" class="form-horizontal">
                                                            
                                              
                                       

                                                    <div class="card-body card-block">
                                                    
                                                 <div class="row input-group">
                                        <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">ID</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="ID" name="ID"  class="input-sm form-control-sm form-control" readonly  ></div>                                 
                             <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Primary Category&nbspName</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Name" name="Name" placeholder="Enter the name" class="input-sm form-control-sm form-control"  ></div>
                          
                          <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Specification</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="special" name="special" placeholder="Enter the specification" class="input-sm form-control-sm form-control"></div>

                               <div class="col col-md-3"><label for="text-input" class=" form-control-label">Description </label></div>
                             <div class="col-9 col-md-9" style="margin: 10; padding: 10px;"><textarea id="Description" name="Description" rows="4" placeholder="Description..." class="form-control"></textarea></div>

                                        <div class="row input-group" style="display: none;">
                                <div class="col col-md-3" style="display: none;"><label for="text-input" class=" form-control-label">App color </label></div>
                             <div class="col-6 col-md-6" style="margin: 10;"><textarea id="color" name="color" rows="1" placeholder="Select a color to show in app..." class="form-control" value="#FFFFFF"></textarea> </div>
                              <button type="submit" class="btn btn-primary btn-sm" onclick=" window.open('https://material-ui.com/customization/color/','_blank')">
                                                            <i class="fa fa-dot-circle-o"></i> Colors
                                                        </button>  </div>


                                
                               <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Browse Image</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo" name="photo" class="form-control-file"></div></div>
                     
                        
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
