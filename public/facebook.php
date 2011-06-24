<?php
define('FACEBOOK_APP_ID', '175385569152277');
define('FACEBOOK_SECRET', '355bb35d0ba65daf4503b462fce4c8cc');

function get_facebook_cookie($app_id, $application_secret) {
    $args = array();
    parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
    ksort($args);
    $payload = '';
    foreach ($args as $key => $value) {
        if ($key != 'sig') {
            $payload .= $key . '=' . $value;
        }
    }
    if (md5($payload . $application_secret) != $args['sig']) {
        return null;
    }
    return $args;
}

$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' .$cookie['access_token']));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="http://connect.facebook.net/es_CL/all.js" type="text/javascript"></script>
        <script src="js/facebook.js" type="text/javascript"></script>
    </head>
    <body>
    <?php if ($cookie) { ?>
      Your user ID is <?= print_r($user) ?>
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>

    <div id="fb-root"></div>
    <script>
      FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,
               cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>
    </body>
</html>