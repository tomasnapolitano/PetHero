<?php
namespace Models;

use Models\Availability as Avalability;
class Keeper extends Owner
{
    private $petSize;
    private $price;
    private Availability $availability;
    private $dateArray;

    public function _construct($petSize = NULL, $price = NULL, $availability = NULL)
    {
        $this->petSize = $petSize;
        $this->price = $price;
        $this->availability = $availability;
        $this->dateArray = array();
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

    /**
     * Get the value of dateArray
     */ 
    public function getDateArray()
    {
        return $this->dateArray;
    }

    /**
     * Set the value of dateArray
     *
     * @return  self
     */ 
    public function setDateArray($dateArray)
    {
        $this->dateArray = $dateArray;

        return $this;
    }
}
?>