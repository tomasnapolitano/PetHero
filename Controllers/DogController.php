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

        public function ShowPetList()
        {
            $dogList = $this->dogDAO->getAll();
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."owner-pet-list.php");
        }

        public function Add($name,$petSpecies,$breed,$size,$vacObs = NULL, $video = NULL)
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
            $dog->setVacObs($vacObs);
            
            $this->UploadFiles($owner,$dog);
            //$dog->setVacPlan($vacPlan);
            //$dog->setPicture($picture);
            $dog->setVideo($video);
            
            $this->dogDAO->Add($dog);

            $this->ownerController->ShowHomeView();

        }

        private function UploadFiles(Owner $owner,Dog $dog){  
            if (isset($_FILES['picture'])){
                if($_FILES['picture']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $dog->getName() . ".jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['picture']['tmp_name'], $fileToAdd)){
                        echo $_FILES['picture']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $dog->setPicture($filename);
                    }else{echo 'ERROR: Could not move Picture file. ';}
                }else{echo 'ERROR: Could not upload Picture file. ';}
            }else{echo 'ERROR: Could not find Picture file. ';}

            if (isset($_FILES['vacPlan'])){
                if($_FILES['vacPlan']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $dog->getName() . "-VAC.jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['vacPlan']['tmp_name'], $fileToAdd)){
                        echo $_FILES['vacPlan']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $dog->setVacPlan($filename);
                    }else{echo 'ERROR: Could not move VacPlan file. ';}
                }else{echo 'ERROR: Could not upload VacPlan file. ';}
            }else{echo 'ERROR: Could not find VacPlan file. ';}
        }
    }
?>