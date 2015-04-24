/**
* allows sending an async request to the server and getting the result of search in positive case
*
* @param {string} q - suggestions
*  
*/
var searchBanner = function(q) {
    if (q == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", "index.php?op=search&q=" + q + "&usrId=<?php echo $id?>", true);
        xmlhttp.send();
    }
}