function getDevToFV() {
    var ajaxRequest;  // The variable that makes Ajax possible!

    try {        
       // Opera 8.0+, Firefox, Safari
       ajaxRequest = new XMLHttpRequest();
    } catch (e) {

       // Internet Explorer Browsers
       try {
          ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {

          try {
             ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {
             // Something went wrong
             alert("Your browser broke!");
             return false;
          }
       }
    }

    // Create a function that will receive data
    // sent from the server and will update
    // div section in the same page.
    ajaxRequest.onreadystatechange = function() {

       if(ajaxRequest.readyState == 4) {
          var ajaxDisplay = document.getElementById('devices');
          ajaxDisplay.innerHTML = ajaxRequest.responseText;
       }
    }

    // Now get the value from user and pass it to
    // server script.
    var typ = document.getElementById("typ").value;
    ajaxRequest.open("POST", "../actions/getDevToFv.php", true);
    ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
    ajaxRequest.send("typ="+typ); 
 }
