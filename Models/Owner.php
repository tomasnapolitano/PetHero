<?php 
namespace Models;

class Owner
{
    private $userName;
    private $email;
    private $password;
    private $name;
    private $lastName;
    private $avatar;
    private $petList;
    private $userRole;

    public function __construct($userName = NULL,$password = NULL, $name=NULL, $lastName=NULL, $email=NULL, $avatar=NULL, $petList = NULL)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->name = $name;
        $this->lastNmae = $lastName;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->petList = $petList; // no se guarda en el json ni bd. Se guarda un array con los id de las pets, y se recuperan los objects desde el DAO
    }


    public function getUserName(){ return $this->userName; }
    public function setUserName($userName){ $this->userName = $userName;}

    public function getPassword(){ return $this->password; }
    public function setPassword($password){ $this->password = $password;}

    public function getname(){ return $this->name; }
    public function setName($name){ $this->name = $name;}

    public function getLastName(){ return $this->lastName; }
    public function setLastName($lastName){ $this->lastname = $lastName;}

    public function getEmail(){ return $this->email; }
    public function setEmail($email){ $this->email = $email;}

    
    public function getAvatar(){ return $this->avatar; }
    public function setAvatar($avatar){ $this->avatar = $avatar;}

    public function getPetList(){return $this->petList;}
    public function setPetList($petList){$this->petList = $petList;}


    /**
     * Get the value of userRole
     */ 
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * Set the value of userRole
     *
     * @return  self
     */ 
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;

        return $this;
    }
}

?>