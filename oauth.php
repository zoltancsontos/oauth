<?php

namespace Authentification;
use \DateTime;
/**
 * ====================================================
 * Oauth token generator / validator library
 * @version 1.0.0
 * @author Zoltan Csontos
 * @license MIT
 * ====================================================
 */
class Oauth {
    
    // Constants
    const SEED_CHAR_LIST = "abcdefghijklmnopqrstuvwzxABCDEFGHIJKLMNOPQRSTUVWZX123456789!@#$%^&*()+}{:?";
    const SEED_LENGTH = 15;
    
    /**
     * ==========================
     * Class properties
     * ==========================
     */
    private static $secret_keys = array(
        "&201m*am#$19aAmnes@%&W",
        "%^a)3#@jmnAOukt2&nB@!9",
        "nVG$%!987)Ajsh76!@#&89"
    );
         
    /**
     * Validates token
     * @param string $token
     * @param string $sCallback - success callback
     * @param string $eCallback - error callback
     * @param array $secret_keys
     * @return boolean
     */
    public static function validate_token($token, $sCallback = '', $eCallback = '', $secret_keys = array()) {
        
        $secret_keys = !empty($secret_keys) ? $secret_keys : self::$secret_keys;
        
        list($id, $seed, $timestamp, $hash) = explode('-', $token);
        
        $i = 0;
        $is_valid = FALSE;
        $keys_length = count($secret_keys);
        
        // Main validation loop
        while ($i < $keys_length) {
            $validation_string = sha1($id . $seed . $timestamp . $secret_keys[$i]);
            if ($validation_string == $hash) {
                $is_valid = TRUE;
                break;
            }
            $i++;
        }
        
        // Check if is the token isn't expired
        if (self::is_expired($timestamp)) {
            $is_valid = FALSE;    
        }
        
        if ($is_valid) {
            // Success callback
            if (!empty($sCallback)) {
                return call_user_func($sCallback, $token);
            }
        } else {
            // Error callback
            if (!empty($eCallback)) {
                return call_user_func($eCallback, $token);
            } 
        }
        return $is_valid;
    }
    
    /**
     * Checks if a token is expired
     * @param string datetime
     * @return boolean
     */
    public static function is_expired($datetime) {
        
        $current_date = new DateTime();
        $expiration_date = new DateTime($datetime);
        
        if ($current_date < $expiration_date) {
            return FALSE;   
        }
        return TRUE;
        
    }
    
    /**
     * Generates an oath token
     * @return string
     */
    public static function generate_token($id=0, $valid_to) {
        
        $seed = self::get_seed();
        $secret_keys = self::$secret_keys;
        $keys_length = count($secret_keys) - 1;
        $rand_index = rand(0, $keys_length);
        $expiration = self::set_expiration_time($valid_to);
        
        $token_data = $id . $seed . $expiration . $secret_keys[$rand_index];
        $token = $id . "-" . $seed . "-" . $expiration . "-" . sha1($token_data);
        
        return $token;
        
    }
    
    /**
     * Sets expiration time
     * @return string
     */
    private static function set_expiration_time($valid_to = "") {
        $expiration_obj = new DateTime($valid_to);
        $formated = $expiration_obj->format('YmdHis'); 
        return $formated;
    }
    
    /**
     * Renders a random seed string
     * @param length
     * @return string
     */
    public static function get_seed() {
        
        $chars = self::SEED_CHAR_LIST;
        $chars_length = strlen($chars) - 1;
        $i = 0;
        $hash = "";
        
        while ($i < self::SEED_LENGTH) {
            $rand_index = rand(0, $chars_length);
            $hash .= $chars[$rand_index];
            $i++;
        }
        
        return $hash;
        
    }
    
}