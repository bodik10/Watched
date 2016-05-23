<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    session_start();
    
    $fb = new Facebook\Facebook(array(
      'app_id' => '225185651170692',
      'app_secret' => 'd11f7bf2bd5ab9f96f4064e673d45365',
      'default_graph_version' => 'v2.5',
    ));
    
    $helper = $fb->getRedirectLoginHelper();
    $permissions = array('email', 'user_likes'); // optional
    $loginUrl = $helper->getLoginUrl('https://ide50-bodik10.cs50.io/fb-login-callback.php', $permissions);
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    
    <a href="<?php echo $loginUrl; ?>">Log in with Facebook!</a>

  </body>
</html>