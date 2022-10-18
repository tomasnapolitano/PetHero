<?php
    namespace Controllers;

    use Models\Pet as Pet;
    use DAO\PetDAO as PetDAO;

    class PetController{
        private $PetDAO;
        
        function __construct()
        {
            $this->PetDAO = new PetDAO();
        }

        public function AddPet($name,$petSpecies,$picture,$video)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $pet = new Pet();
            $pet->setName($name);
            $pet->setPetSpecies($petSpecies);
            $pet->setPicture($picture);
            $pet->setVideo($video);
            
            $this->PetDAO->Add($pet);

            //$this->ShowAddView();

        }
    }
?>