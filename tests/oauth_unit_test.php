<?php

require_once("oauth.php");

class OauthTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test if the token is generated
	 * @return void
	 */
	public function testTokenGenerator() {
		$id = 35;
		$valid_to = "20321211000000";
		$token = Authentification\Oauth::generate_token($id, $valid_to);
		$this->assertNotEmpty($token);	
	}
	
	/**
	 * Tests the functionality of the expiration validator
	 * @return void
	 */
	public function testExpirationValidator() {
		$valid_to = "20131111000000";
		$this->assertEquals(TRUE, Authentification\Oauth::is_expired($valid_to));
	}
	
	/**
	 * Tests the token validator functionality
	 * @return void
	 */
    public function testTokenValidator() {
    	$token = "25-24Q%NA?HMVHC7!7-20151111000000-ba890a83314a113ef1f451c2c8001ce9df727f21";
    	$this->assertEquals(TRUE, Authentification\Oauth::validate_token($token));
    }
    
    /**
     * Test if the success callback is executed
     * @return void
     */
    public function testSuccessCallback() {
    	$token = "25-24Q%NA?HMVHC7!7-20151111000000-ba890a83314a113ef1f451c2c8001ce9df727f21";
    	$validated = Authentification\Oauth::validate_token($token, function($token) {
    		return $token;
    	});
    	$this->assertEquals($token, $validated);
    }
    
    /**
     * Tests if the error callback is executed
     * @return void
     */
    public function testErrorCallback() {
    	$token = "25-24Q%NA?HMVHC7!7-20121111000000-ba890a83314a113ef1f451c2c8001ce9df727f21";
    	$validated = Authentification\Oauth::validate_token($token, '', function($token) {
    		return $token;
    	});
    	$this->assertEquals($token, $validated);
    }
    
}