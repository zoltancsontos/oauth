# PHP oauth
PHP oauth token validator/generator library

#Usage:

Generate token:
  ````php
  <?php
  
  require_once("oauth.php");
  
  $id = 0;
  $expirationDate = '20151215160000'; // Format YMdHis
  $token = Authentification\Oauth::generate_token($id, $expirationDate);
  ````
  
Validate token:

  ````php
  <?php
  
  require_once("oauth.php");
  
  Authentification\Oauth::validate_token('sometoken', function() {
    // do something if valid
  });
  ````
