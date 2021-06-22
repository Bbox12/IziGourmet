<!DOCTYPE html>
<html>
  <head>
    <title>Online Drivers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.1/firebase-database.js"></script>
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

 <link href="css/forms.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/new.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 
<script type="text/javascript">
 $(document).ready(function(){
   var driverLat=0,driverLong=0,Vehicle,Driver_Photo,tSeat,d2,d3,Driver_ride=null,Driver_ride_text,dataString,Driver_off,Driver_car;
   var i=0;
  

  var config = {
    apiKey: "AIzaSyCaA96LCZ-wollSh7hjcMs80FjK_gRKJBs",
    databaseURL: "https://etez-67949.firebaseio.com/",
    projectId: "etez-67949",
  };
  firebase.initializeApp(config);


  var databaseFire = firebase.database().ref('Driver_Online');
  databaseFire.once('value', function(childSnapshot) {
  childSnapshot.forEach(function(snapshot) {

          
          driverLat=parseFloat(snapshot.val().First_Latitude);
          driverLong=parseFloat(snapshot.val().First_Longitude);
          Driver_off=snapshot.val().Offline;
          Driver_Ride=snapshot.val().OnRide;
          Driver_mobile=String(snapshot.val().Driver_Phone_no);
          var Driver_date=snapshot.val().Driver_Online_Date;
           var Driver_Vehicle=snapshot.val().Name;
           var Version=snapshot.val().Version;
          var d1 = new Date();
          d1.setHours(0,0,0,0);
         
          var table = document.getElementById("myTable");
          var row = table.insertRow(1);
        
          var cell0 = row.insertCell(0);
           var cell1 = row.insertCell(1);
          var cell2 = row.insertCell(2);
          var cell3 = row.insertCell(3);
          var cell4 = row.insertCell(4);
          var cell5 = row.insertCell(5);
          var cell6 = row.insertCell(6);
          var cell7 = row.insertCell(7);
          cell0.innerHTML=i++;
         
          if(Driver_date!== undefined){
             var parts =Driver_date.split('-');
         var d2 = new Date(parts[2], parts[1] - 1, parts[0]); 
         alert(d2.getTime().toString());
          cell2.innerHTML = Driver_mobile; 
         if(d1.getTime()!== d2.getTime()) {
             cell3.innerHTML = "Offline"; 
             cell3.style.backgroundColor = "#ff0000";
          }else{
             cell3.innerHTML = "Online"; 
             cell3.style.backgroundColor = "#4CAF50";
          }
          cell4.innerHTML=Driver_date;
           cell5.innerHTML=Driver_Ride;
          if(Driver_off.includes("YES")){
                cell6.style.backgroundColor = "#ff0000"; 
          }
          cell6.innerHTML=Driver_off;
          
        }else{
        	     cell2.innerHTML = Driver_mobile; 
          cell3.innerHTML = "Need to call"; 
          cell4.innerHTML="Need to call"; 
             cell3.style.backgroundColor = "#ff0000";
              cell5.innerHTML=Driver_Ride;
          if(Driver_off.includes("YES")){
                cell6.style.backgroundColor = "#ff0000"; 
          }
          cell6.innerHTML=Driver_off;
          
        }

        if(Driver_Vehicle!== undefined){
            cell1.innerHTML=Driver_Vehicle;
        }
         if(Version!== undefined){
            cell7.innerHTML="Update";
        }else{
          cell7.innerHTML="App need to update";
           cell7.style.backgroundColor = "#ff0000"; 
        }
         
          
         
        
      
          });
        });
 
});


</script>
  </head>
  <body >
 <div id="main">
    <div id="header"  >
      <div id="logo" onclick="openNav()">
        <div id="logo_text" >
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a > <span class="logo_colour">Online Driver Reports</span></a></h1>
          </div>
          </div>
          </div>
 
    <div class="page-content">
          <div class="row">
     
</div>
          
            <div class="content-box-large">
              
                <div class="panel-body">
              
                <table  id="myTable" class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Status</th>
                        <th>Last Online Date</th>
                        <th>On Ride</th>
                        <th>Manual Offline</th>
                        <th>Version</th>
                    </tr>
            </table>
        </div>
    </div>
            <br/>

            <button onclick="exportToExcel()">Export</button>
   
</div>



 <div id="footer">
     <p ><a href="login_as_admin.html">Admin</a> | <a href="http://www.shillongcab.com/">HOME</a>
      | </p>
      <p>Copyright &copy; Shillongcab | <a href="http://www.shillongcab.com/"></a></p>
    </div>

   </div>
   <script>
function exportToExcel(){
var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };

            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };

            htmls = "YOUR HTML AS TABLE"

            var ctx = {
                worksheet : 'Worksheet',
                table : htmls
            }


            var link = document.createElement("a");
            link.download = "export.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
}
</script>
     <script type="text/javascript">
  function print() {
  t = document.getElementById('time').value
  var [h,m] = t.split(":");
  console.log((h%12+12*(h%12==0))+":"+m, h >= 12 ? 'PM' : 'AM');
}
     </script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
      <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>

    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

     <!-- bootstrap-datetimepicker -->
     <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
     <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> 



    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>
  </body>
</html>