<?php
namespace Models;

class Dog extends Pet
{
    private $race;
    private $size;
    private $vacPlan;
    private $vacObs;

    public function _construct($race = NULL, $size = NULL)
    {
        $this->race = $race;
        $this->size = $size;
    }

    public function getRace(){return $this->race;}
    public function setRace($race){$this->race = $race;}

    public function getSize(){return $this->size;}
    public function setSize($size){$this->size = $size;}

    public function getVacPlan(){ return $this->vacPlan; }
    public function setVacPlan($vacPlan){ $this->vacPlan = $vacPlan;}

    public function getVacObs(){ return $this->vacObs; }
    public function setVacObs($vacObs){ $this->vacObs = $vacObs;}
}
?>