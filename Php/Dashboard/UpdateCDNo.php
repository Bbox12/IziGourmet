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
    <title>Update CDNo</title>
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
window.location.replace("http://mypostman.in/Dashboard/page-login.php");
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
                        <a href="index.php"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>

                     

                   
                 
                     <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Operation</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="book_shipment.php">Shipment Booking </a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="AWBAcknowledgement.php">Existing AWB Acknowledgement</a></li>
                             <li><i class="menu-icon fa fa-th"></i><a href="ManifestEntry.php">Manifest Entry </a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="DeleteAwbNo.php">Existing Delete Awb No</a></li>
                             <li><i class="menu-icon fa fa-th"></i><a href="BagLocking.php">Bag Locking </a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="DispatchEntry.php">Dispatch Entry</a></li>
                             <li><i class="menu-icon fa fa-th"></i><a href="UpdateCDNo.php">Update CDNo </a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="ArrivalEntry.php">Arrival Entry</a></li>
                           
                        </ul>
                    </li>

                   
                 
                    <h3 class="menu-title">Login</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Client</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="ClientMaster.php">Client Master</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="ClientRateEntry.php">Client Rate Entry</a></li>
                            <li><i class="menu-icon fa fa-paper-plane"></i><a href="GenerateRegularClientBill.php">Generate Regular Client Bill</a></li>
                              <li><i class="menu-icon fa fa-sign-in"></i><a href="ClientBillPrint.php">Client Bill Print</a></li>
                           
                        </ul>
                    </li>
                        <h3 class="menu-title">Query</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Awb No Query</a>
                        <ul class="sub-menu children dropdown-menu">
                                 <li><i class="menu-icon fa fa-sign-in"></i><a href="AwbNoQuery.php">Awb No Query</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="ReportQuery.php">Report Query</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="RouteDashboard.php">Route Dashboard</a></li>
                        
                        </ul>
                    </li>
                    <h3 class="menu-title">Reports</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="BookingReport.php" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i> Booking Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="ManifestBaggingReport.php"> Manifest Bagging Report</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="DispatchReport.php">Dispatch Report</a></li>
                          <li><i class="menu-icon fa fa-sign-in"></i><a href="ManifestBaggingInScanReport.php"> Manifest Bagging InScan</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="BoxInScanReport.php">Box InScan Report</a></li>
                             <li><i class="menu-icon fa fa-sign-in"></i><a href="RunsheetReport.php"> Runsheet Report</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="DeliveryStatusReport.php">Delivery Status Report</a></li>
            
                         
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </aside>
    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        
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
            
                            <a class="nav-link" ><?php  session_start(); echo $_SESSION["email"];?></a>
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>

                           
                            <a class="nav-link" href="#"><i class="fa fa-cog"></i> Settings</a>

                            <a class="nav-link" href="#"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>

                  
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

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
                            <li><a href="#">Operation</a></li>
                            <li class="active">Update CDNo</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="row">
          
                                                  

                  
                                            <div class="col-lg-12">
                                                 <div class="card">
                                                    <div class="card-header">
                                                        <strong>Update CDNo</strong>
                                                    </div>
                                                    <div class="card-body card-block">
                                                        <form action="UpdateCDDATA.php" method="post" enctype="multipart/form-data" target="_self" class="form-horizontal">
                                                            <div class="col-lg-12">


                                              
                                       

                                                    <div class="card-body card-block">
                                                    
                                                          <div class="row input-group">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Dispatch No</label></div>
                             <div class="col-8 col-md-8"><input list="m8-datalist" id="DispatchedNo" name="DispatchedNo"  class="input-sm form-control-sm form-control" autocomplete="off"  onkeyup ="myHint1(this.value)" required style="font-size: 14px;" >
                             <datalist id="m8-datalist" >
                             </datalist> </div>
                           
                                                            </div>
                                                            <div class="row input-group">
                                                                    
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">CD No</label></div>
                             <div class="col-8 col-md-8"><input type="text" id="CDNo" name="CDNo"  class="input-sm form-control-sm form-control"></div>
                           
                            
                                                            </div>
                                                     
                                                          
                                                                      <div class="row input-group">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Payment Mode</label></div>
                             <div class="col-8 col-md-8"><select name="pmtMode" id="pmtMode" class="input-sm form-control-sm form-control" onchange="myHide(this.value);">
                                                                            <option value="0">Please select</option>
                                                                            <option value="1">CASH</option>
                                                                            <option value="2">TO PAY</option>
                                                                              <option value="3">CREDIT</option>
                                                                        </select></div>
                           
                                                            </div>
                                                             
                                                                <div class="row input-group">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Chargeable Weight</label></div>
                              <div class="col-8 col-md-8"><input type="text" id="ChargeableWeight" name="ChargeableWeight"  class="input-sm form-control-sm form-control"></div>
                           
                                                            </div>
                                                                       <div class="row input-group">
                                                                    
                            <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Mobile No.</label></div>
                              <div class="col-8 col-md-8"><input type="number" id="Mobile" name="Mobile"  class="input-sm form-control-sm form-control"></div>
                           
                                                            </div>
                                                                      <div class="row input-group">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Browse Image</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo" name="photo" class="input-sm form-control-sm form-control-file"></div>
                       
                           
                        
                                                          
                                                            
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
                                        </div><!-- .animated -->
                                    </div><!-- .content -->
                                </div><!-- /#right-panel -->
                                <!-- Right Panel -->
  <script type="text/javascript">
function myHint1(value) {

var options = "";
var id='id='+ value;
var dataList8 = document.getElementById('m8-datalist');

var options = '';
var request = new XMLHttpRequest();

request.onreadystatechange = function(response) {
  if (request.readyState === 4) {
    if (request.status === 200) {
  
var jsonOptions = JSON.parse(request.responseText, (key, value) => {
  
  console.log(key); 
console.log(value);  
   var option = document.createElement('option'); 
        if(value.length!=="" && value.length>4){
  options += '<option value="'+value+'" />';
  dataList8.innerHTML = options;   
}
 
});
  

    } 
  }
};
request.open('POST', 'getDisPatchedForCDNo.php', true);
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
request.send(id);
    

};
 </script>

                            <script src="vendors/jquery/dist/jquery.min.js"></script>
                            <script src="vendors/popper.js/dist/umd/popper.min.js"></script>

                            <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
                            <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script>

                            <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                            <script src="assets/js/main.js"></script>
                               <script src="main.js"></script>
</body>
</html>
