<?php
    namespace Controllers;

    use Models\Pet as Pet;
    use Models\Dog as Dog;
    //use DAO\PetDAO as PetDAO;
    use DAO\DogDAO as DogDAO;
use Models\Owner;

    class PetController{
        private $PetDAO;
        
        function __construct()
        {
            $this->PetDAO = new PetDAO();
        }

        public function AddPet($name,$petSpecies,$picture,$video)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];
            
            $pet = new Pet();
            $pet->setOwnerId($owner->getId());
            $pet->setName($name);
            $pet->setPetSpecies($petSpecies);
            $pet->setPicture($picture);
            $pet->setVideo($video);
            
            $this->PetDAO->Add($pet);

            //$this->ShowAddView();

        }
    }
?>