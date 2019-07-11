<?php
namespace CieloLink\API;

/**
 * Class Recurrent
 *
 * @package CieloLink\API
 */
class Recurrent implements \JsonSerializable {

    const TYPE_MONTHLY      = "Monthly";
    const TYPE_BIMONTHLY    = "Bimonthly";
    const TYPE_QUARTERLY    = "Quarterly";
    const TYPE_SEMIANNUAL   = "SemiAnnual";
    const TYPE_ANNUAL       = "Annual";
    
    private $interval;

    private $endDate;

    
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
     * 
     * @return string
     */
    public function getInterval() {
        return $this->interval;
    }

    /**
     * 
     * @param string $interval
     */
    public function setInterval($interval) {
        $this->interval = $interval;
        
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getEndDate() {
        return $this->endDate;
    }

    /**
     * 
     * @param string $endDate
     */
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        
        return $this;
    }
    
}