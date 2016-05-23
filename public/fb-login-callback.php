<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    session_start();
    
    $fb = new Facebook\Facebook([
      'app_id' => '225185651170692',
      'app_secret' => 'd11f7bf2bd5ab9f96f4064e673d45365',
      'default_graph_version' => 'v2.5',
    ]);
    
    $helper = $fb->getRedirectLoginHelper();
    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    
    if (isset($accessToken)) {
      // Logged in!
      $_SESSION['facebook_access_token'] = (string) $accessToken;
      
      echo $accessToken . '<br>';
      echo "<pre>";
      
      try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/me?fields=id,name,email,picture', (string) $accessToken);
        $user = $response->getGraphUser();
        print_r($user);
        echo "<img src='".$user['picture']['url']."'>";
        echo 'Name: ' . $user['name'] . '<br>';
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      
      
      
      try {
        $request = $fb->get("/me/video.watches", (string) $accessToken);
        $movies = $request->getGraphEdge();
        $allMovies = $movies->asArray();
        print_r($allMovies);
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      
      echo "</pre>";
    }
?>