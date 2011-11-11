
FB.Event.subscribe('auth.login', function(response) {
//    console.log("login event");
    console.log(response);
//    setSession(response);
});
FB.Event.subscribe('auth.logout', function(response) {
    console.log("logout event");
});
FB.Event.subscribe('auth.authResponseChange', function(response) {
//    console.log("authResponseChange");
    console.log(response);
});

var invitar = function() {
    FB.ui({
        method: 'apprequests', 
        title: 'Invita a tus amigos',
        filters: ['app_non_users'],
        message: 'Controla tus ingresos y gastos con Me lo Gasté!'
    });
    return false;
}

function conecta() {
//    FB.login(function(response) {
//        if (response.session) {
//            if (response.perms) {
//                window.location = "save";
//            } else {
//                // user is logged in, but did not grant any permissions
////                alert("ok maso");
//            }
//        } else {
//            // user is not logged in
////            alert("fail");
//        }
//    }, {
//        scope:'email,publish_stream,offline_access'
//    });
}

function handleSessionResponse(response) {
    // if we dont have a session, just hide the user info
    if (!response.session) {
        alert("no logeado");
        return;
    }
}
var $invitar;
$(document).ready(function() {
    FB.init({
        appId : 175385569152277,
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml : true, // parse XFBML
        oauth: true
    });
//    $invitar = $("#invitar").click(invitar());
});