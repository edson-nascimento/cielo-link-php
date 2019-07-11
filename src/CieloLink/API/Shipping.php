<?php
namespace CieloLink\API;

/**
 * Class Shipping
 *
 * @package CieloLink\API
 */
class Shipping implements \JsonSerializable {

    const TYPE_CORREIOS                 = "Correios";
    const TYPE_FIXED_AMOUNT             = "FixedAmount";
    const TYPE_FREE                     = "Free";
    const TYPE_WITHOUT_SHIPPING_PICKUP  = "WithoutShippingPickUp";
    const TYPE_WITHOUT_SHIPPING         = "WithoutShipping";

    private $name;

    private $price;

    private $originZipCode;

    private $type;
    
    
    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    public function populateByArray(array $response) {
        
        foreach ($response as $prop => $value){
            if (!is_array($value) && property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
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
     * @return integer|null
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
     * @return string|null
     */
    public function getOriginZipCode() {
        return $this->originZipCode;
    }

    /**
     * @param string $originZipCode
     */
    public function setOriginZipCode($originZipCode) {
        $this->originZipCode = $originZipCode;
        
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


    
    
}