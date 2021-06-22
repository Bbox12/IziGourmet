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
    <title>Add Products</title>
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
         //alert(this.responseText);  
         var i;
             if(arr.length!=0){
                           
                               for( i=0;i<arr.length;i++){

                                      document.getElementById('ID').value=arr[i].ID;
                                  document.getElementById('IDShop').value=arr[i].IDMenu;
                                 document.getElementById('IDSubsubmenu').value=arr[i].IDSubsubmenu;
                  
                                 document.getElementById('Name').value=arr[i].Name;
                                 
                                 document.getElementById('Weight').value=arr[i].Weight;
                                    document.getElementById('Unit').value=arr[i].Unit;
                               
                                 document.getElementById('Description').value=arr[i].Description;

                                            document.getElementById('IDsubmenu').value=arr[i].IDSubmenu;
                            
                                 document.getElementById('MRP').value=arr[i].MRP;
                                   document.getElementById('JalpanPrice').value=arr[i].JalpanPrice;
                                    document.getElementById('Discount').value=arr[i].Discount;
                                    if(arr[i].Recomended==1){

                              
                                      document.getElementById('vehicle1').checked = true;
                                    }else{
                                      
                                      document.getElementById('vehicle1').checked = false;
                                    }
                              
                               }
             }
  }
}
 xmlhttp.open("POST","getProductsToEdit.php",true);
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Product</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                                                  

                  
                                              <div class="col-lg-12">
                                                 <div class="card">
                                                    <div class="card-header">
                                                        <strong>Products</strong>
                                                    </div>

                                                    <div class="card-body card-block">



                                                        <form id="uploadImageForm"  action="editFinalWorkingSite.php" method="post" enctype="multipart/form-data" target="_self" class="form-horizontal">
                                                            
                                              
                                       

                                                    <div class="card-body card-block">
                                                    
                                                 <div class="row input-group">
                                                   <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">ID</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="ID" name="ID" placeholder="Enter the name" class="input-sm form-control-sm form-control"  ></div></div>
                                <div class="row input-group">
                                                       <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Primary category</label></div>
                             <div class="col-8 col-md-8">  <select  id="IDShop" name="IDShop" class="input-sm form-control-sm form-control"   >
   <option value="0">--Select--</option>

                                                                             <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  $sql =$conn->query("SELECT `ID`, Name  FROM `menu_type`  ");
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

                                                                        </select></div></div>
    <div class="row input-group">
                                                                                  <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Secondary Category</label></div>
                             <div class="col-8 col-md-8">             <select id="IDsubmenu" name="IDsubmenu" class="input-sm form-control-sm form-control" required>
                                                                             <option value="">--Select--</option>

                                                                             <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  $sql =$conn->query("SELECT `ID`, Name  FROM `subsubmenu`  ");
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
                                                                        </select></div></div>


                                                              
                                                                           <div class="row input-group">
                                                                         <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Third Category</label></div>
                             <div class="col-8 col-md-8">  <select  id="IDSubsubmenu" name="IDSubsubmenu" class="input-sm form-control-sm form-control"   >
   <option value="0">--Select--</option>

                                                                             <?php  
                        
                                 require_once 'DB_Connect.php';
        $db = new Db_Connect();
        $conn = $db->connect();
        if(!$conn){
        echo "Could not connect to DBMS"; 
         }else {  $sql =$conn->query("SELECT `ID`, Category  FROM `submenu` WHERE isActive=1 ");
        foreach($sql as $row) {
    ?>

 <option value="<?php echo $row['ID']; ?>">  
                                         <?php 
                                      
                                         echo $row['Category'];?>  
   </option>  
                      <?php
}
}
?>

                                                                        </select></div></div>

                                                                
                                                                <div class="row input-group">
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Name</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Name" name="Name" placeholder="Enter the name" class="input-sm form-control-sm form-control"  ></div></div>
                                <div class="row input-group">
                            
                            <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label"> Weight</label></div>
                             <div class="col-9 col-md-9"><input type="number" step="0.1" id="Weight" name="Weight" placeholder="Weight in Kg" class="input-sm form-control-sm form-control"  ></div></div>
                                <div class="row input-group">
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Stock</label></div>
                             <div class="col-9 col-md-9"><input type="number" step="0.1" id="Unit" name="Unit" placeholder="Stock " class="input-sm form-control-sm form-control"  ></div></div>
                                                                      
                              
                
                               
                           <div class="row input-group">
                                <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Description </label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Description" name="Description" placeholder="Description" class="input-sm form-control-sm form-control"  ></div></div>
                            
                                  <div class="row input-group">
                              <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Cost Price</label></div>
                             <div class="col-9 col-md-9"><input type="text" id="MRP" name="MRP" placeholder="MRP" class="input-sm form-control-sm form-control"  ></div></div>
                                <div class="row input-group">
                                <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">IziGourmet Selling Price</label></div>
                             <div class="col-9 col-md-9"><input type="number" id="JalpanPrice" name="JalpanPrice" placeholder="IziGourmet Express Price" class="input-sm form-control-sm form-control"  ></div></div>
                                <div class="row input-group">
                                <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Discount </label></div>
                             <div class="col-9 col-md-9"><input type="text" id="Discount" name="Discount" placeholder="Discount" class="input-sm form-control-sm form-control"  ></div></div>
                           
           
                         </div>
                          
                      
                                                    <div class="row input-group">    
                                                       <div class="col col-md-3" ><label for="vehicle1" class=" input-sm form-control-sm form-control-label">Deal of the day</label></div>  
                                                       <div class="col-8 col-md-8" > <input type="checkbox" name="vehicle1" id="vehicle1" value="1">
 </div></div>  
                                                     
        <div class="row form-group">
                                 <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Browse Image</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo" name="photo" class="form-control-file"></div></div>
                                   <div class="row form-group">
                                 <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Browse Image1</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo1" name="photo1" class="form-control-file"></div></div>
                                   <div class="row form-group">
                                 <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Browse Image2</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo2" name="photo2" class="form-control-file"></div></div>
                                   <div class="row form-group">
                                 <div class="col col-md-3" style="margin: 10; padding: 10px;"><label for="text-input" class=" form-control-label">Browse Image3</label></div>
                              <div class="col-8 col-md-8"><input type="file" id="photo3" name="photo3" class="form-control-file"></div></div>
                              
                                               
                                                       <button type="submit" class="btn btn-primary btn-sm" id="submit">
                                                            <i class="fa fa-dot-circle-o"></i> Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-danger btn-sm" id="cancel">
                                                            <i class="fa fa-ban"></i> Reset
                                                        </button>
                                                      
                                                  
                                                          </form>

                                                         

                                                                  
                                                     
                                                            </div>
                                                </div>
                                             </div>
                                           </div>
                           
                                      
                                    </div><!-- .content -->
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

          

<script type="text/javascript">
  function uploadPhotos(url) {

    document.getElementById('submit').display = "none";
      document.getElementById('cancel').display = "none";

    var file = event.target.files[0];

    // Ensure it's an image
    if(file.type.match(/image.*/)) {
      
        // Load the image
        var reader = new FileReader();
        reader.onload = function (readerEvent) {
            var image = new Image();
            image.onload = function (imageEvent) {

                // Resize the image
                var canvas = document.createElement('canvas'),
                    max_size = 544,// TODO : pull max size from a site config
                    width = image.width,
                    height = image.height;
                if (width > height) {
                    if (width > max_size) {
                        height *= max_size / width;
                        width = max_size;
                    }
                } else {
                    if (height > max_size) {
                        width *= max_size / height;
                        height = max_size;
                    }
                }
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                var dataUrl = canvas.toDataURL('image/jpeg');
                var resizedImage = dataURLToBlob(dataUrl);
                $.event.trigger({
                    type: "imageResized",
                    blob: resizedImage,
                    url: dataUrl
                });
            }
            image.src = readerEvent.target.result;
        }
        reader.readAsDataURL(file);
    }
};
</script>
<script type="text/javascript">
  var dataURLToBlob = function(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;

    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
}
</script>
<script type="text/javascript">
  $(document).on("imageResized", function (event) {

var vehicle1=0;
 var ID=document.getElementById('ID').value;
                         var IDShop=document.getElementById('IDShop').value;
                                 var IDSubsubmenu=document.getElementById('IDSubsubmenu').value;
                  
                                 var Name=document.getElementById('Name').value;
                                 
                                 var Weight=document.getElementById('Weight').value;
                                var Unit=document.getElementById('Unit').value;
                               
                               var Description=document.getElementById('Description').value;

                                    var IDsubmenu=document.getElementById('IDsubmenu').value;
                            
                                var MRP= document.getElementById('MRP').value;
                                  var JalpanPrice= document.getElementById('JalpanPrice').value;
                                  var Discount=  document.getElementById('Discount').value;
                                    if(document.getElementById('vehicle1').checked==true){
                                         vehicle1=1;
                                    }else{
                                      
                                      vehicle1=0;
                                    }
                              







    var data = new FormData($("form[id*='uploadImageForm']")[0]);
    if (event.blob && event.url) {
        data.append('photo', event.blob);
      data.append('ID', ID);
            data.append('IDShop', IDShop);
                  data.append('IDSubsubmenu', IDSubsubmenu);
                  data.append('Name', Name);
            data.append('Weight', Weight);
                  data.append('Unit', Unit);
                  data.append('Description', Description);
            data.append('IDsubmenu', IDsubmenu);
                  data.append('MRP', MRP);
                      data.append('JalpanPrice', JalpanPrice);
            data.append('Discount', Discount);
                  data.append('vehicle1', vehicle1);
        $.ajax({
            url: '/IziGourmet/Dashboard/editFinalWorkingSite.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
              location.reload(true); 
            },
    error: function (request, status, error) {
       location.reload(true); 
    }
        });
    }
});
</script>
          
                          <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>
