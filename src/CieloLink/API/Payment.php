<?php
namespace CieloLink\API;

/**
 * Class Payment
 *
 * @package CieloLink\API
 */
class Payment implements \JsonSerializable {
    
    const TYPE_ASSET        = "Asset";
    const TYPE_DIGITAL      = "Digital";
    const TYPE_SERVICE      = "Service";
    const TYPE_PAYMENT      = "Payment";
    const TYPE_RECURRENT    = "Recurrent";
    
    private $id;
    
    private $name;
    
    private $description;
    
    private $showDescription;
    
    private $price;
    
    private $expirationDate;
    
    private $weight;
    
    private $softDescriptor;

    private $type;

    private $shipping;
    
    private $recurrent;

    private $shortUrl;

    private $links;
    
    private $jsonResponse;
    
    public function jsonSerialize() {
        
        return array_filter(get_object_vars($this), function($item, $key){
            return !is_null($item) && !in_array($key, ['id', 'shortUrl', 'links', 'jsonResponse']);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function populateByArray(array $response) {
        
        foreach ($response as $prop => $value){
            if (!is_array($value) && property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
        
        if ($response['shipping'] && is_array($response['shipping'])) {
            $this->shipping()->populateByArray($response['shipping']);
        }

        if ($response['recurrent'] && is_array($response['recurrent'])) {
            $this->recurrent()->populateByArray($response['recurrent']);
        }

        if ($response['links']) {
            $this->links = $response['links'];
        }
    }
    
    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShowDescription() {
        return $this->showDescription;
    }

    /**
     * @param mixed $showDescription
     */
    public function setShowDescription($showDescription) {
        $this->showDescription = $showDescription;
        
        return $this;
    }

    /**
     * @return integer
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price) {
        $this->price = (int)($price * 100);
        
        return $this;
    }

    /**
     * @return string
     */
    public function getExpirationDate() {
        return $this->expirationDate;
    }

    /**
     * @param string $expirationDate
     */
    public function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight) {
        $this->weight = $weight;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getSoftDescriptor() {
        return $this->softDescriptor;
    }

    /**
     * @param string $softDescriptor
     */
    public function setSoftDescriptor($softDescriptor) {
        $this->softDescriptor = $softDescriptor;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
        
        return $this;
    }

    /**
     * @return Shipping|null
     */
    public function getShipping() {
        return $this->shipping;
    }

    /**
     * @param Shipping $shipping
     */
    public function setShipping(Shipping $shipping) {
        $this->shipping = $shipping;
        
        return $this;
    }
    
    /**
     * @return Shipping $shipping
     */
    public function shipping() {
        $shipping = new Shipping();
        $this->setShipping($shipping);
        
        return $shipping;
    }

    /**
     * @return Recurrent
     */
    public function getRecurrent() {
        return $this->recurrent;
    }

    /**
     * @param Recurrent $recurrent
     */
    public function setRecurrent(Recurrent $recurrent) {
        $this->recurrent = $recurrent;
        
        return $this;
    }

    /**
     * @return Recurrent $shipping
     */
    public function recurrent() {
        $recurrent = new Recurrent();
        $this->setRecurrent($recurrent);
        
        return $recurrent;
    }
    /**
     * @return string
     */
    public function getShortUrl() {
        return $this->shortUrl;
    }

    /**
     * @param string $shortUrl
     */
    public function setShortUrl($shortUrl) {
        $this->shortUrl = $shortUrl;
    }

    /**
     * @return mixed
     */
    public function getLinks() {
        return $this->links;
    }

    /**
     * @param mixed $links
     */
    public function setLinks($links) {
        $this->links = $links;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getJsonResponse() {
        return $this->jsonResponse;
    }

    /**
     * @param string $jsonResponse
     */
    public function setJsonResponse($jsonResponse) {
        $this->jsonResponse = $jsonResponse;
        
        return $this;
    }


    
}