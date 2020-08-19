function reserveDevice() {
    var x = document.getElementById("devices");
    var tr = x.getElementsByTagName("tr");
    var c = x.getElementsByTagName("input");
    var tab = document.getElementById("res_tab");
    var post = "";
    const table = [];
    for(var i=0;i<c.length;i++){
        if(c[i].checked===true) {
            table.push(i);
            if(i===0){
                post+=c[i].value+"="+c[i].value;
            }
            else{
                post+="&"+c[i].value+"="+c[i].value;
            }
            //div.insertAdjacentHTML("beforeend", tr[i+1].innerHTML);
        }
    }
    if(table.length>0){
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
              if(ajaxRequest.responseText === "1"){
                  for(var i=0;i<table.length;i++){
                    tab.insertAdjacentHTML("beforeend", "<tr>"+tr[table[i]+1].innerHTML+"</tr>");
                  }
                  document.getElementById("typ").onchange();
              }
              else{
                  tab.innerHTML = ajaxRequest.responseText;
              }
           }
        }

        // Now get the value from user and pass it to
        // server script.
        ajaxRequest.open("POST", "../actions/reserve.php", true);
        ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
        ajaxRequest.send(post); 
    }
 }

function removeReservation(){
    var tab = document.getElementById("res_tab");
    var tr = tab.getElementsByTagName("tr");
    var c = tab.getElementsByTagName("input");
    var post = "";
    const table = [];
    for(var i=0;i<c.length;i++){
        if(c[i].checked===true) {
            table.push(i);
            if(i===0){
                post+=c[i].value+"="+c[i].value;
            }
            else{
                post+="&"+c[i].value+"="+c[i].value;
            }
            //div.insertAdjacentHTML("beforeend", tr[i+1].innerHTML);
        }
    }
    if(table.length>0){
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
              if(ajaxRequest.responseText === "1"){ //japierws usuwa tbody, potem pierwszego tr -> dodano +1
                  for(var i=0;i<table.length;i++){
                    tab.removeChild(tab.childNodes[table[i]+1]);
                    for(var j=i;j<table.length;j++){
                        table[j]-=1;
                    }
                  }
                  document.getElementById("typ").onchange();
              }
              else{
                  tab.innerHTML = ajaxRequest.responseText;
              }
           }
        }

        // Now get the value from user and pass it to
        // server script.
        ajaxRequest.open("POST", "../actions/removereserve.php", true);
        ajaxRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
        ajaxRequest.send(post); 
    }
}
