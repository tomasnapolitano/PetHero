<?php 
namespace Models;

class Pet
{
    private $name;
    private $picture;
    private $species;
    private $vacPlan;
    private $vacObs;
    private $video;

    public function __construct($name=NULL,$picture = NULL,$species = NULL,  $vacPlan=NULL, $vacObs=NULL, $video=NULL)
    {
        $this->name = $name;
        $this->species = $species;
        $this->vacPlan = $vacPlan;
        $this->lastNmae = $vacObs;
        $this->picture = $picture;
        $this->video = $video;
    }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name;}

    public function getPicture(){ return $this->picture; }
    public function setPicture($picture){ $this->picture = $picture;}

    public function getSpecies(){ return $this->species; }
    public function setSpecies($species){ $this->species = $species;}

    public function getVacPlan(){ return $this->vacPlan; }
    public function setVacPlan($vacPlan){ $this->vacPlan = $vacPlan;}

    public function getVacObs(){ return $this->vacObs; }
    public function setVacObs($vacObs){ $this->vacObs = $vacObs;}

    public function getVideo(){ return $this->video; }
    public function setVideo($video){ $this->video = $video;}
}
?>