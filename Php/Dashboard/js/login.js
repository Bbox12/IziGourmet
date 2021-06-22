$(document).ready(function(){
$("#submit").click(function(){
var mobile1 = $("#email").val();
var password1 = $("#password").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'email='+ mobile1 +'&password='+ password1;
if(mobile1==''||password1=='')
{
alert("Please Fill All Fields");
}
else
{
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
    	if(this.responseText.indexOf("ERROR") >= 0){
      alert("No data received");
    }else if(this.responseText.indexOf("PASSWORD") >= 0){
      alert("Wrong password");
    }else
    if(this.responseText.indexOf("email") >= 0){
      alert("Please check mobile no");
    }else{
    	window.location.replace("http://139.59.38.160/MDF/Dashboard/after_admin_login.html");
    }
    
  }
}
  xmlhttp.open("POST","login.php",true);
 xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send(dataString);
}
return false;
});
});