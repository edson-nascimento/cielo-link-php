<?php
namespace CieloLink\API;

/**
 * Class Environment
 * 
 * @package CieloLink\API
 */
class Environment {

    private $api;

   /**
    * 
    * @param $api
    */
    public function __construct($api) {
        $this->api = $api;
    }

    /**
     * 
     * @return Environment
     */
    public static function sandbox() {
        throw  new \Exception("Não existe modo sandbox use ClientId: dc9d6efa-b582-4ac8-ac59-12c57245df2a e ClientSecret: d4bAh9FeILpJvntoVceFhJ8ETdqVJetYpu4kZlZXeuA8r9dS1PPdZXmS5egN6a9n para testar");
    }
    
    /**
     *
     * @return Environment
     */
    public static function production() {
        return new Environment('https://cieloecommerce.cielo.com.br');
    }

    /**
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiUrl() {
        return $this->api;
    }

}