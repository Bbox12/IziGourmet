
 $(document).ready(function(){
   var driverLat=0,driverLong=0,Vehicle,Driver_Photo,tSeat,d2,d3,Driver_ride=null,Driver_ride_text,dataString;
  var myLat = "<?php echo $_GET["lat"];?>";
    var myLong ='<?php echo $_GET["long"];?>';
    var unique ='<?php echo $_GET["unique"];?>';
    var Seat ='<?php echo $_GET["Seat"];?>';
    Seat=parseInt(Seat);


  var config = {
    apiKey: "AIzaSyAFi5peP0Rmq7W08TB5xLUFB5ITrsQIwHE",
    databaseURL: "https://etez-319f0.firebaseio.com",
    projectId: "etez-319f0",
  };
  firebase.initializeApp(config);


  var databaseFire = firebase.database().ref('Driver_Online');
  databaseFire.once('value', function(childSnapshot) {
  childSnapshot.forEach(function(snapshot) {
      
          driverLat=parseFloat(snapshot.val().First_Latitude);
          driverLong=parseFloat(snapshot.val().First_Longitude);
            
           
          if(driverLat != '' && driverLong != '')
          {

      
            var dist=distance(driverLat,driverLong,myLat,myLong,"K");
              alert(dist);
            if(dist<10){


              Driver_Seat=parseInt(snapshot.val().Seat);
             

   
              tSeat=Driver_Seat+Seat;
           
             
             if( tSeat<=4){
              
           Driver_Photo=snapshot.val().Driver_Photo;
           Driver_mobile=snapshot.val().Driver_Phone_no;
    
              var long=driverLat + "|" + driverLong;
            
              Driver_ride=snapshot.val().Ride;
              

                     if( Driver_ride === undefined ){
                           var databaseFire1 = firebase.database().ref('Driver_Online').child(Driver_mobile);
      databaseFire1.update({
      "Ride": unique
                           });
         dataString =  'title='+ "Request for ride" +'&message='+long+
                  '&push_type='+ "individual" +'&regId='+ snapshot.val().regID+
                  '&include_image='+ "FALSE" +'&image='+ Driver_Photo+'&unique='+ unique;
    }else{
        var databaseFire1 = firebase.database().ref('Driver_Online').child(Driver_mobile);
      databaseFire1.update({
   "Ride": Driver_ride+"|"+unique
}); 
       dataString =  'title='+ "Request for ride" +'&message='+long+
                  '&push_type='+ "individual" +'&regId='+ snapshot.val().regID+
                  '&include_image='+ "FALSE" +'&image='+ Driver_Photo+'&unique='+ Driver_ride+"|"+unique;
    }
  
                  if (window.XMLHttpRequest) {
 
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
  }
}
  xmlhttp.open("POST","fcm_sent.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send(dataString);
            } 
          }
      }
          });
        });
 
});

 function distance(lat1, lon1, lat2, lon2, unit) {
        var radlat1 = Math.PI * lat1/180
        var radlat2 = Math.PI * lat2/180
        var radlon1 = Math.PI * lon1/180
        var radlon2 = Math.PI * lon2/180
        var theta = lon1-lon2
        var radtheta = Math.PI * theta/180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180/Math.PI
        dist = dist * 60 * 1.1515
        if (unit=="K") { dist = dist * 1.609344 }
        if (unit=="N") { dist = dist * 0.8684 }
        return dist
}

