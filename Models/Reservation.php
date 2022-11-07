<?php 
namespace Models;

class Reservation
{
    private $id;
    private $ownerId;
    private $keeperId;
    private $petId;
    private $dateIdList;
    private $amount;
    private $isAccepted;

    public function _construct($ownerId = NULL, $keeperId = NULL, $petId = NULL, $dateIdList = NULL, $amount = NULL, $isAccepted = null)
    {
        $this->ownerId = $ownerId;
        $this->keeperId = $keeperId;
        $this->petId = $petId;
        $this->dateIdList = $dateIdList;
        $this->amount = $amount;
        $this->isAccepted = $isAccepted;
    }

    public function getId(){ return $this->id; }
    public function setId($id): self { $this->id = $id; return $this; }

    public function getOwnerId(){ return $this->ownerId; }
    public function setOwnerId($ownerId): self { $this->ownerId = $ownerId; return $this; }

    public function getKeeperId(){ return $this->keeperId; }
    public function setKeeperId($keeperId): self { $this->keeperId = $keeperId; return $this; }

    public function getPetId(){ return $this->petId; }
    public function setPetId($petId): self { $this->petId = $petId; return $this; }

    public function getDateIdList(){ return $this->dateIdList; }
    public function setDateIdList($dateIdList): self { $this->dateIdList = $dateIdList; return $this; }

    public function getAmount(){ return $this->amount; }
    public function setAmount($amount): self { $this->amount = $amount; return $this; }

    public function getIsAccepted(){ return $this->isAccepted; }
    public function setIsAccepted($isAccepted): self { $this->isAccepted = $isAccepted; return $this; }
}
?>