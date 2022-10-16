<?php
namespace Models;

class Keeper extends Owner
{
    private $petSize;
    private $price;
    private $availability;

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

    public function getAvailability(){return $this->availability;}
    public function setAvailability($availability){$this->availability = $availability;} 
}
?>