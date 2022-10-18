<?php
    namespace Controllers;

    use Models\Pet as Pet;  
    use Models\Dog as Dog;
    use Controllers\OwnerController as OwnerController;
    use DAO\DogDAO as DogDAO;
use Models\Owner;

    class DogController{
        private $dogDAO;
        private $ownerController;
        
        function __construct()
        {
            $this->dogDAO = new DogDAO();
            $this->ownerController = new OwnerController();
        }

        public function Add($name,$petSpecies,$picture,$video)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $user = $_SESSION['loggedUser']; // no funca esto -------------------------------------
            
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