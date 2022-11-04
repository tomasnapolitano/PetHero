<?php
    namespace Controllers;

    use Models\Pet as Pet;
    use DAO\PetDAO as PetDAO;
    use Controllers\OwnerController as OwnerController;
    use Controllers\ValidationController as ValidationController;
use Models\Owner;

    class PetController{
        private $petDAO;
        private $ownerController;
        private $validation;
        
        function __construct()
        {
            $this->petDAO = new PetDAO();
            $this->ownerController = new OwnerController();
            $this->validation = new ValidationController();
        }

        public function ShowAddView($message = ""){
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-pet.php");
        }

        public function GetPetList()
        {
            return $this->petDAO->getAll();
        }
        
        public function ShowPetList()
        {
            $petList = $this->petDAO->getAll();
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."owner-pet-list.php");
        }

        public function Add($name,$petSpecies,$breed,$size,$vacObs = NULL)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];

            if($this->validation->validateName($name))
            {
                $pet = new Pet();
                $pet->setOwnerId($owner->getId());
                $pet->setName($name);

                if ($this->validation->validateName($breed))
                {
                    $pet->setPetSpecies($petSpecies); //debería recibir lo elegido en el form
                                                    // y buscarlo por name en un json de petSpecies
                    $pet->setBreed($breed);
                    $pet->setSize($size);
                    $pet->setVacObs($vacObs);
                    
                    $this->UploadFiles($owner,$pet);
                    //$dog->setVacPlan($vacPlan);
                    //$dog->setPicture($picture);
                    //$dog->setVideo($video);
                    
                    $this->petDAO->Add($pet);

                } else { $this->ShowAddView("Breed not valid. Try Again."); }

            } else { $this->ShowAddView("Name not valid. Try Again."); }
            

            $this->ownerController->ShowHomeView();

        }


        // todos los mensajes con ECHO hay que cambiarlos, para que se pasen por parámetro a la vista
        // para no romper con el modelo de capas.
        private function UploadFiles(Owner $owner,Pet $pet){  
            if (isset($_FILES['picture'])){
                if($_FILES['picture']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . ".jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['picture']['tmp_name'], $fileToAdd)){
                        echo $_FILES['picture']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setPicture($filename);
                    }else{echo 'ERROR: Could not move Picture file. ';}
                }else{echo 'ERROR: Could not upload Picture file. ';}
            }else{echo 'ERROR: Could not find Picture file. ';}

            if (isset($_FILES['vacPlan'])){
                if($_FILES['vacPlan']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . "-VAC.jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['vacPlan']['tmp_name'], $fileToAdd)){
                        echo $_FILES['vacPlan']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setVacPlan($filename);
                    }else{echo 'ERROR: Could not move VacPlan file. ';}
                }else{echo 'ERROR: Could not upload VacPlan file. ';}
            }else{echo 'ERROR: Could not find VacPlan file. ';}

            if (isset($_FILES['video'])){
                if($_FILES['video']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . "-VID.gif"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['video']['tmp_name'], $fileToAdd)){
                        echo $_FILES['video']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setVideo($filename);
                    }else{echo 'ERROR: Could not move video file. ';}
                }else{echo 'ERROR: Could not upload video file. ';}
            }else{echo 'ERROR: Could not find video file. ';}
        }
    }
?>