<?php 
namespace Models;

class Reservation
{
    private $id;
    private $owner;
    private $keeper;
    private $pet;
    private $dateIdList;
    private $amount;
    private $isAccepted;

    public function _construct($owner = NULL, $keeper = NULL, $pet = NULL, $dateIdList = NULL, $amount = NULL, $isAccepted = null)
    {
        $this->owner = $owner;
        $this->keeper = $keeper;
        $this->pet = $pet;
        $this->dateIdList = $dateIdList;
        $this->amount = $amount;
        $this->isAccepted = $isAccepted;
    }

    public function getId(){ return $this->id; }
    public function setId($id): self { $this->id = $id; return $this; }

    public function getOwner(){ return $this->owner; }
    public function setOwner($owner): self { $this->owner = $owner; return $this; }

    public function getKeeper(){ return $this->keeper; }
    public function setKeeper($keeper): self { $this->keeper = $keeper; return $this; }

    public function getPet(){ return $this->pet; }
    public function setPet($pet): self { $this->pet = $pet; return $this; }

    public function getDateIdList(){ return $this->dateIdList; }
    public function setDateIdList($dateIdList): self { $this->dateIdList = $dateIdList; return $this; }

    public function getAmount(){ return $this->amount; }
    public function setAmount($amount): self { $this->amount = $amount; return $this; }

    public function getIsAccepted(){ return $this->isAccepted; }
    public function setIsAccepted($isAccepted): self { $this->isAccepted = $isAccepted; return $this; }
}
?>