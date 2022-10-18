<?php
    namespace Controllers;

    use Models\Pet as Pet;
    use Models\Dog as Dog;
    use DAO\DogDAO as DogDAO;
    use Controllers\OwnerController as OwnerController;
use Models\Owner;

    class DogController{
        private $dogDAO;
        private $ownerController;
        
        function __construct()
        {
            $this->dogDAO = new DogDAO();
            $this->ownerController = new OwnerController();
        }

        public function ShowAddView(){
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-pet.php");
        }

        public function Add($name,$petSpecies,$breed,$size,$vacPlan,$vacObs = NULL,$picture = NULL, $video = NULL)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];
            
            $dog = new Dog();
            $dog->setOwnerId($owner->getId());
            $dog->setName($name);
            $dog->setPetSpecies($petSpecies); //debería recibir lo elegido en el form
                                         // y buscarlo por name en un json de petSpecies
            $dog->setBreed($breed);
            $dog->setSize($size);
            $dog->setVacPlan($vacPlan);
            $dog->setVacObs($vacObs);
            $dog->setPicture($picture);
            $dog->setVideo($video);
            
            $this->dogDAO->Add($dog);

            $this->ownerController->ShowHomeView();

        }
    }
?>