<?php
namespace CieloLink\API;

/**
 * Class Request
 *
 * @package CieloLink\API
 */
class Request {

    /**
     * Base url from api
     *
     * @var string
     */
    private $baseUrl = '';
    
    const CURL_TYPE_AUTH = "AUTH";
    const CURL_TYPE_POST = "POST";
    const CURL_TYPE_PUT  = "PUT";
    const CURL_TYPE_GET  = "GET";
    const CURL_TYPE_DEL  = "DELETE";

    /**
     * Request constructor.
     *
     * @param CieloLink $credentials
     */
    public function __construct(CieloLink $credentials) {
        $this->baseUrl = $credentials->getEnvironment()->getApiUrl();
        
        $this->auth($credentials);
    }

    /**
     *
     * @param CieloLink $credentials
     * @return CieloLink
     * @throws \Exception
     */
    public function auth(CieloLink $credentials) {
        
        $urlPath = "/api/public/v2/token";

        $response = $this->send($credentials, $urlPath, self::CURL_TYPE_AUTH);
        
        $auth = $response->decodeBody();
        
        if ($response->getStatusCode() != "201" || $response->getBody() == null || !$auth['access_token']) {
            throw new \Exception($response);
        }
        
        $token = new Token($auth['access_token'], $auth['token_type'], $auth['expires_in']);
        
        $credentials->setToken($token);
        
        return $credentials;
    }
    
    /**
     * start session for use
     * 
     * @param CieloLink $credentials
     * @return boolean
     */
    private function verifyAuthSession(CieloLink $credentials){
        
        if ($credentials->getKeySession() && isset($_SESSION[$credentials->getKeySession()]) && $_SESSION[$credentials->getKeySession()]["access_token"]) {
            
            $auth = $_SESSION[$credentials->getKeySession()];
            $now  = microtime(true);
            $init = $auth["generated"];
            
            if (($now - $init) < $auth["expires_in"]) {
                $credentials->setAuthorizationToken($auth["access_token"]);
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * 
     * @param CieloLink $credentials
     * @param mixed $urlPath
     * @param mixed $method
     * @param mixed $json
     * @throws \Exception
     * @return BaseResponse|NULL
     * @throws \Exception
     */
    private function send(CieloLink $credentials, $urlPath, $method, $json = null) {
        
        $curl = curl_init($this->getFullUrl($urlPath));

        if (!defined('CURL_SSLVERSION_TLSv1_2')) {
            define('CURL_SSLVERSION_TLSv1_2', 6);
        }
        
        $defaultCurlOptions = array(
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json; charset=utf-8'
            ),
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYPEER => false
        );
        
        if (!$json) {
            $defaultCurlOptions[CURLOPT_HTTPHEADER][] = 'Content-Length: 0';
        }
        
        if ($method != self::CURL_TYPE_AUTH) {
            $defaultCurlOptions[CURLOPT_HTTPHEADER][] = 'Authorization: Bearer ' . $credentials->getToken()->getAccessToken();
        }

        if ($method == self::CURL_TYPE_POST) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            
        } elseif ($method == self::CURL_TYPE_PUT) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::CURL_TYPE_PUT);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            
        } elseif ($method == self::CURL_TYPE_DEL) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::CURL_TYPE_DEL);
            
        } elseif ($method == self::CURL_TYPE_AUTH) {
            curl_setopt($curl, CURLOPT_USERPWD, $credentials->getClientId() . ":" . $credentials->getClientSecret());
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt_array($curl, $defaultCurlOptions);

        $response = curl_exec($curl);
        
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if ($statusCode < 200 || $statusCode > 204) {
            throw new \Exception($response, $statusCode);
        }

        curl_close($curl);

        return new BaseResponse($response, $statusCode);
    }

    /**
     * Get request full url
     *
     * @param string $urlPath
     * @return string $url(config) + $urlPath
     */
    private function getFullUrl($urlPath) {
        if (stripos($urlPath, $this->baseUrl, 0) === 0) {
            return $urlPath;
        }

        return $this->baseUrl . $urlPath;
    }

    /**
     *
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     *
     * @param CieloLink $credentials
     * @param mixed $urlPath
     * @return mixed
     * @throws \Exception
     */
    public function get(CieloLink $credentials, $urlPath) {
        return $this->send($credentials, $urlPath, self::CURL_TYPE_GET);
    }

    /**
     *
     * @param CieloLink $credentials
     * @param mixed $urlPath
     * @param mixed $params
     * @return mixed
     * @throws \Exception
     */
    public function post(CieloLink $credentials, $urlPath, $params) {
        return $this->send($credentials, $urlPath, self::CURL_TYPE_POST, $params);
    }

    /**
     * 
     * @param CieloLink $credentials
     * @param mixed $urlPath
     * @param mixed $params
     * @return mixed
     * @throws \Exception
     */
    public function put(CieloLink $credentials, $urlPath, $params) {
        return $this->send($credentials, $urlPath, self::CURL_TYPE_PUT, $params);
    }
    
    /**
     *
     * @param CieloLink $credentials
     * @param mixed $urlPath
     * @return mixed
     * @throws \Exception
     */
    public function delete(CieloLink $credentials, $urlPath) {
        return $this->send($credentials, $urlPath, self::CURL_TYPE_DEL);
    }
    
}