<?php
namespace Models;

use Models\Availability as Avalability;
class Keeper extends Owner
{
    private $petSize;
    private $price;
    private Availability $availability;

    public function _construct($petSize = NULL, $price = NULL, $availability = NULL)
    {
        $this->petSize = $petSize;
        $this->price = $price;
        $this->availability = $availability;
    }

    public function getPetSize(){return $this->petSize;}
    public function setPetSize($petSize){$this->petSize = $petSize;}

    public function getPrice(){return $this->price;}
    public function setPrice($price){$this->price = $price;} 

    

    /**
     * Get the value of availability
     */ 
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set the value of availability
     *
     * @return  self
     */ 
    public function setAvailability(Availability $availability)
    {
        $this->availability = $availability;

        return $this;
    }
}
?>