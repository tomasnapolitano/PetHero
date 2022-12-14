<?php
    namespace Controllers;

    use Models\Pet as Pet;
    use DAO\PetDAO as PetDAO;
    use DAO\DB_PetDAO as DB_PetDAO;
    use Controllers\OwnerController as OwnerController;
    use Controllers\ValidationController as ValidationController;
    use Models\Owner;
    class PetController{
        private $petDAO;
    
        function __construct()
        {
            $this->petDAO = new DB_PetDAO();
        }

        public function SearchById($id)
        {
            $pet = $this->petDAO->SearchById($id);

            return $pet;
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
            require_once(VIEWS_PATH."validate-session.php");
            try {
                $petList = $this->petDAO->getAll();
                require_once(VIEWS_PATH."owner-pet-list.php");
            }
            catch(\PDOException $e)
            {
                $ownerController = new OwnerController();
                $ownerController->ShowHomeView("Error de Conexión: " . $e->getMessage());
            }
        }

        public function Add($name,$petSpecies,$breed,$size,$vacObs = "",$vacPlan,$picture,$video)
        {
            require_once(VIEWS_PATH."validate-session.php");
            try {
                $validation = new ValidationController();
                $ownerController = new OwnerController();
                $owner = new Owner();
                $owner = $_SESSION['loggedUser'];

                if($validation->validateName($name))
                {
                    $pet = new Pet();
                    $pet->setOwnerId($owner->getId());
                    $pet->setName($name);

                    if ($validation->validateName($breed))
                    {
                        $pet->setPetSpecies($petSpecies); //debería recibir lo elegido en el form
                                                        // y buscarlo por name en un json de petSpecies
                        $pet->setBreed($breed);
                        $pet->setSize($size);
                        $pet->setVacObs($vacObs);
                        
                        $message = $this->UploadFiles($owner,$pet);
                        //$dog->setVacPlan($vacPlan);
                        //$dog->setPicture($picture);
                        //$dog->setVideo($video);
                        $this->petDAO->Add($pet);

                    } else { $this->ShowAddView("Breed not valid. Try Again."); }

                } else { $this->ShowAddView("Name not valid. Try Again."); }
                

                $ownerController->ShowHomeView($message);
            }
            catch(\PDOException $e)
            {
                $this->ShowAddView("Error de Conexión: " . $e->getMessage());
            }
        }


        private function UploadFiles(Owner $owner,Pet $pet){ 
            
            $message = "";

            if (isset($_FILES['picture'])){
                if($_FILES['picture']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . ".jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['picture']['tmp_name'], $fileToAdd)){
                        $message = $message . $_FILES['picture']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setPicture($filename);
                    }else{$message = $message . 'ERROR: Could not move Picture file. ';}
                }else{$message = $message .  'ERROR: Could not upload Picture file. ';}
            }else{$message = $message .  'ERROR: Could not find Picture file. ';}

            if (isset($_FILES['vacPlan'])){
                if($_FILES['vacPlan']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . "-VAC.jpg"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['vacPlan']['tmp_name'], $fileToAdd)){
                        $message = $message .  $_FILES['vacPlan']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setVacPlan($filename);
                    }else{$message = $message .  'ERROR: Could not move VacPlan file. ';}
                }else{$message = $message .  'ERROR: Could not upload VacPlan file. ';}
            }else{$message = $message .  'ERROR: Could not find VacPlan file. ';}

            if (isset($_FILES['video'])){
                if($_FILES['video']['error']==0){
                    $dir = IMG_PATH;
                    $filename = $owner->getUserName() . $pet->getName() . "-VID.gif"; // debería ser por Id de pet, no nombre

                    $fileToAdd = $dir . $filename;

                    if(move_uploaded_file($_FILES['video']['tmp_name'], $fileToAdd)){
                        $message = $message .  $_FILES['video']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                        $pet->setVideo($filename);
                    }else{$message = $message .  'ERROR: Could not move video file. ';}
                }else{$message = $message .  'ERROR: Could not upload video file. ';}
            }else{$message = $message .  'ERROR: Could not find video file. ';}
            
            return $message;
        }
    }
?>