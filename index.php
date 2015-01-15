<?php

require_once 'oauth.php';

Authentification\Oauth::validate_token("25-24Q%NA?HMVHC7!7-20151111000000-ba890a83314a113ef1f451c2c8001ce9df727f21", function($token) {
	echo $token;
});
