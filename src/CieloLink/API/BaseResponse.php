<?php
namespace CieloLink\API;

/**
 * Class BaseResponse
 *
 * @package CieloLink\API
 */
class BaseResponse {

    private $body;

    private $statusCode;

    private $generated;

    /**
     * Token constructor.
     *
     * @param mixed $body
     * @param mixed $statusCode
     */
    public function __construct($body, $statusCode) {
        $this->setBody($body);
        $this->setStatusCode($statusCode);
        $this->setGenerated(microtime(true));
    }
    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param mixed $generated
     */
    public function setGenerated($generated) {
        $this->generated = $generated;
        
        return $this;
    }

    public function decodeBody($assoc = true){
        
        if ($this->getBody()) {
            return json_decode($this->getBody(), $assoc);
        }
        
        return null;
    }

 
}