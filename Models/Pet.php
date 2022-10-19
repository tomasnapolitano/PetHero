<?php 
namespace Models;

abstract class Pet
{
    private $id;
    private $ownerId;
    private $name;
    private $picture;
    private $petSpecies;
    private $video;

    public function __construct($name=NULL,$picture = NULL,$petSpecies = NULL, $video=NULL)
    {
        $this->name = $name;
        $this->petSpecies = $petSpecies;
    
        
        $this->picture = $picture;
        $this->video = $video;
    }

    public function getName(){ return $this->name; }
    public function setName($name){ $this->name = $name;}

    public function getPicture(){ return $this->picture; }
    public function setPicture($picture){ $this->picture = $picture;}

    public function getVideo(){ return $this->video; }
    public function setVideo($video){ $this->video = $video;}

    /**
     * Get the value of petSpecies
     */ 
    public function getPetSpecies()
    {
        return $this->petSpecies;
    }

    /**
     * Set the value of petSpecies
     *
     * @return  self
     */ 
    public function setPetSpecies($petSpecies)
    {
        $this->petSpecies = $petSpecies;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of ownerId
     */ 
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Set the value of ownerId
     *
     * @return  self
     */ 
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }
}
?>