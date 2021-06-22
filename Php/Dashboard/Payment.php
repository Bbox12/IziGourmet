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
    <title>Payment</title>
    <meta name="description" content="IziGourmet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link href="css/style.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>



</head>

<body >


 <div id="main-wrapper">

           <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>





    <div class="content-body">



            <div class="container-fluid">
                <div class="row">
                      <div class="col-lg-12">
            <div class="animated fadeIn">
                 <form action="https://www.payfast.co.za/eng/process" method="post" enctype="multipart/form-data" target="_self" >
                <div class="row" id="taken">
                                 <div class="col-lg-12">
                                 <div class="card" >
                          
<input type="hidden" name="m_payment_id" value="<?php echo $_GET["orderid"]?>" >
                               <input type="hidden" name="merchant_id" value="15936606">
                              <input type="hidden" name="merchant_key" value="tm9g6fb7rqoly">
                             <input type="hidden" name="name_first" value="<?php echo $_GET["name"]?>">

                              <input type="hidden" name="return_url" value="http://139.59.38.160/IziGourmet/Dashboard/success.php">
<input type="hidden" name="cancel_url" value="http://139.59.38.160/IziGourmet/Dashboard/cancelled.php?id=<?php echo $_GET["ID"]?>">
<input type="hidden" name="notify_url" value="http://139.59.38.160/IziGourmet/Dashboard/notify.php?amount=<?php echo $_GET["amount"]?>&ID=<?php echo $_GET["ID"]?>">
 


                            <div class="card-body" >

                                      <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">Payable</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">R<?php echo $_GET["amount"]?></h2>
                                    <p class="text-white mb-0">Order ID <?php echo $_GET["orderid"]?></p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                            </div>
                        </div>
                    </div>
                           <div class="row input-group" style="display: none" >
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Order ID</label></div>
                              <div class="col-9 col-md-9"><input type="text" id="item_name" name="item_name" value="<?php echo $_GET["orderid"]?>" class="input-sm form-control-sm form-control-file"></div>
                           
                                                            </div>
                                                                      
                                                                      <div class="row input-group" style="display: none" >
                                                                    
                             <div class="col col-md-3"><label for="text-input" class=" input-sm form-control-sm form-control-label">Amount to pay</label></div>
                              <div class="col-8 col-md-8"><input type="text" id="amount" name="amount" value="<?php echo $_GET["amount"]?>" class="input-sm form-control-sm form-control-file"></div>
                       
                           
                        
                                                          
                                                            
                                                          </div> 
                                                      </div>
                                                         <button type="submit" class="btn btn-primary btn-lg btn-block" style="height: 56px;">
                                                            <i class="fa fa-angle-double-right">Pay Now</i>
                                                        </button>
                                                    
                                                  </div>
                                              </div>
                                              </div>

          
              </form>
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
