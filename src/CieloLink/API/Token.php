<?php
namespace CieloLink\API;

/**
 * Class Token
 *
 * @package CieloLink\API
 */
class Token {

    private $access_token;

    private $token_type;

    private $expires_in;

    private $generated_in;

    /**
     * Token constructor.
     *
     * @param string $access_token
     * @param string $token_type
     * @param string $expires_in
     */
    public function __construct($access_token, $token_type, $expires_in) {
        $this->setAccessToken($access_token);
        $this->setTokenType($token_type);
        $this->setExpiresIn($expires_in);
        $this->setGeneratedIn(microtime(true));

        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getAccessToken() {
        return $this->access_token;
    }

    /**
     * 
     * @param string $access_token
     */
    public function setAccessToken($access_token) {
        $this->access_token = $access_token;
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTokenType() {
        return $this->token_type;
    }

    /**
     *
     * @param string $access_token
     */
    public function setTokenType($token_type) {
        $this->token_type = $token_type;
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getExpiresIn() {
        return $this->expires_in;
    }

    /**
     *
     * @param string $access_token
     */
    public function setExpiresIn($expires_in) {
        $this->expires_in = $expires_in;
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getGeneratedIn() {
        return $this->generated_in;
    }

    /**
     *
     * @param string $access_token
     */
    public function setGeneratedIn($generated_in) {
        $this->generated_in = $generated_in;
        
        return $this;
    }
 
}