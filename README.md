# PHP oauth
PHP oauth token validator/generator library

#Usage:

Download the oauth.php file and place it anywhere to your project.

Generate token:
  ````php
  <?php
  
  require_once("../somepath/oauth.php");
  
  $id = 0; // eg. user id
  $expirationDate = '20151215160000'; // Format YMdHis
  $token = Authentification\Oauth::generate_token($id, $expirationDate);
  ````
  
Validate token:

  ````php
  <?php
  
  require_once("../somepath/oauth.php");
  
  Authentification\Oauth::validate_token('sometoken', function successCallback($token) {
    // do something if valid
  }, function errorCallback($token) {
    // do something if not valid
  });
  ````
