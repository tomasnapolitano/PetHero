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

        public function AddPet($name,$species,$vacPlan,$vacObs,$picture,$video)
        {
            $pet = new Pet();
            $pet->setName($name);
            $pet->setSpecies($species);
            $pet->setVacPlan($vacPlan);
            $pet->setVacObs($vacObs);
            $pet->setPicture($picture);
            $pet->setVideo($video);
            
            $this->PetDAO->Add($pet);

            //$this->ShowAddView();

        }
    }
?>