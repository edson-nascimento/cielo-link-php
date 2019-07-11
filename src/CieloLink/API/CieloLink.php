<?php
namespace CieloLink\API;

/**
 * Class LinkPayment
 *
 * @package CieloLink\API
 */
class CieloLink {
    
    private $clientId;

    private $clientSecret;
    
    private $environment;
    
    private $token;
    
    
    /**
     * Token constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param Environment|null $environment
     */
    public function __construct($clientId, $clientSecret, $environment = null) {
        
        if (!$environment) {
            $environment = Environment::production();
        }
        
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
        $this->setEnvironment($environment);
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
        
        return $this;
    }
    
    
    /**
     * @return Environment|null
     */
    public function getEnvironment() {
        return $this->environment;
    }
    
    /**
     * @param string $environment
     */
    public function setEnvironment(Environment $environment) {
        $this->environment = $environment;
        
        return $this;
    }

    /**
     * @return Token|null
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param Token $token
     */
    public function setToken(Token $token) {
        $this->token = $token;
        
        return $this;
    }

    /**
     * 
     * @param Payment $payment
     * @return Payment|boolean
     */
    public function create(Payment $payment) {
        
        $request = new Request($this);
        $response = $request->post($this, "/api/public/v1/products/", json_encode($payment));
        
        if ($response && $response->getStatusCode() == 201) {
            $paymentResponse = new Payment();
            
            $paymentResponse->populateByArray($response->decodeBody());
            
            $paymentResponse->setJsonResponse($response->getBody());
            
            return $paymentResponse;
        }
        
        return false;
        
    }

    /**
     * 
     * @param string $id
     * @return Payment|boolean
     */
    public function get($id) {
        
        $request = new Request($this);
        $response = $request->get($this, "/api/public/v1/products/".$id);

        if ($response && $response->getStatusCode() == 200) {
            $paymentResponse = new Payment();
            
            $paymentResponse->populateByArray($response->decodeBody());
            
            $paymentResponse->setJsonResponse($response->getBody());
            
            return $paymentResponse;
        }
        
        return false;
        
    }

    /**
     * 
     * @param Payment $payment
     * @return Payment|boolean
     */
    public function update(Payment $payment) {
        
        $request = new Request($this);
        $response = $request->put($this, "/api/public/v1/products/".$payment->getId(), json_encode($payment));

        if ($response && $response->getStatusCode() == 200) {
            $paymentResponse = new Payment();
            
            $paymentResponse->populateByArray($response->decodeBody());
            
            $paymentResponse->setJsonResponse($response->getBody());
            
            return $paymentResponse;
        }
        
        return false;
        
    }

    /**
     * 
     * @param string $id
     * @return boolean
     */
    public function delete($id) {
        
        $request = new Request($this);
        $response = $request->delete($this, "/api/public/v1/products/".$id);

        if ($response && $response->getStatusCode() == 204) {
            return true;
        }
        
        return false;
        
    }
    
}