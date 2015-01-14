# PHP oauth
PHP oauth token validator/generator library

#Usage:

Download the oauth.php file and place it anywhere to your project.

Open the oauth.php file and change the $secret_keys property (line 17) - add up to 5 keys for higher security:
  ````php
  private static $secret_keys = array(
      "&201m*am#$19aAmnes@%&W",
      "%^a)3#@jmnAOukt2&nB@!9",
      "nVG$%!987)Ajsh76!@#&89"
  );
  ````

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
