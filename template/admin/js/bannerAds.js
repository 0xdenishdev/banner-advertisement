/**
* allows sending an async request to the server and getting the iframe params in positive case for setting banners
*
* @param {string} author - author of the banner
*  
*/
var showBanner = function(author) {
    var hr = new XMLHttpRequest(); 
    //var url = "admin/index.php?op=getBanner";
    var url = "admin/bannerHandler.php?op=getBanner";
    var request_page = location.pathname.split('/')[2].split('.')[0];
    var vars = "user_id=" + author + "&page=" + request_page; 

    hr.open("POST", url, true); 
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
            return_data = hr.responseText;
            // alert(return_data);

            var data = JSON.parse(return_data);
            // document.getElementsByTagName("iframe")[0].setAttribute("src", "admin/index.php?op=showBanner&banner_id=" + data.banner_id);
            if (data.display != null) {
                document.getElementsByTagName("iframe")[0].setAttribute("src", "admin/bannerHandler.php?op=showBanner&bannerId=" + data.banner_id);
                document.getElementsByTagName("iframe")[0].setAttribute("width", data.width);
                document.getElementsByTagName("iframe")[0].setAttribute("height", data.height);
                document.getElementsByTagName("iframe")[0].setAttribute("style", "display: " + data.display + ";");
            }
        } 
    } 
    hr.send(vars); 
}