<?php
    namespace Controllers;

    use Models\Pet as Pet;  
    use Models\Dog as Dog;
    use DAO\DogDAO as DogDAO;
use Models\Owner;

    class DogController{
        private $dogDAO;
        
        function __construct()
        {
            $this->dogDAO = new DogDAO();
        }

        public function Add($name,$petSpecies,$picture,$video)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];
            
            $pet = new Dog();
            $pet->setOwnerId($owner->getId());
            $pet->setName($name);
            $pet->setPetSpecies($petSpecies);
            $pet->setPicture($picture);
            $pet->setVideo($video);
            
            $this->dogDAO->Add($pet);

            //$this->ShowAddView();

        }
    }
?>