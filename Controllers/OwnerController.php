<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Pet as Pet;
    use DAO\OwnerDAO as OwnerDAO;
    use DAO\DB_PetDAO as DB_PetDAO;
    use DAO\DB_OwnerDAO as DB_OwnerDAO;
    use DAO\PetDAO as PetDAO;
    
    use Controllers\ValidationController as ValidationController;
    use Controllers\PetController as PetController;
    use Controllers\DateController as DateController;
    class OwnerController{

        private $ownerDAO;

        function __construct()
        {
            $this->ownerDAO = new DB_OwnerDAO();
        }

        public function Add($email,$userName,$password,$name,$lastName,$avatar = null)
        {
            //require_once(VIEWS_PATH."validate-session.php");

            $validation = new ValidationController();
          if (!$this->validateEmailExists($email))
          {
           if ($this->GetByUserName($userName) == null)
            {
              if ($validation->validateUserName($userName))
                  {
                      $owner = new Owner();
                      $owner->setUserName($userName);

                      if($validation->validatePassword($password))
                          {
                              $owner->setPassword($password);

                              if($validation->validateName($name) && $validation->validateName($lastName))
                                  {
                                      $owner->setName($name);
                                      $owner->setLastName($lastName);
                                      $owner->setEmail($email);
                                      $owner->setAvatar($avatar);
                                      $owner->setPetList(array());
                                      $owner->setUserRole(1);

                                      $this->ownerDAO->Add($owner);
                                    
                                 } else { $this->ShowRegisterView("Name or Lastname not valid. Try again."); }
                                
                         } else { $this->ShowRegisterView("Password not valid. Try again."); }

                  } else { $this->ShowRegisterView("Username is not valid. Try again.");}

            } else { $this->ShowRegisterView("Username is already taken. Try a different one."); }
          } else { $this->ShowRegisterView("Email already registered.");}
            $this->ShowLoginView();

        }

        public function GetByUserName ($userName){
            return $this->ownerDAO->GetByUserName($userName);
        }

        public function RemoveByUserName ($userName){
          return $this->ownerDAO->RemoveByUserName($userName);
        }

        public function ShowRegisterView($message = ""){
            //require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."register-owner.php");
        }

        public function ShowLoginView(){
            require_once(VIEWS_PATH."login.php");
        }

        public function ShowHomeView($message = "")
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

        public function GetAll()
        {
          return $this->ownerDAO->getAll();
        }

        public function ShowKeeperListView($postDate=NULL,$pets=NULL,$message = ""){
            require_once(VIEWS_PATH."validate-session.php");


         // ---------------------------------------- If a date and pet are entered: (filters keepers by date)
          $keepersToShow = array();
          $keepersList = $this->ownerDAO->getAll();
          $petDAO = new DB_PetDAO();

          if (isset($postDate) && isset($pets) && $pets!=="0")
          {

            $pet = $petDAO->searchById($pets);
            $string = $postDate;

            $dateStringArray = explode(',',$string);
            $dateController = new DateController();

            foreach ($keepersList as $keeper) {
              if($keeper->getUserRole() == 2 && $keeper->getId() !== $_SESSION['loggedUser']->GetId()){
                $counterAux=0;
                foreach ($dateStringArray as $dateString) // cycling through the chosen dates to search
                {
                  $flag = 0;
                  foreach ($keeper->getDateArray() as $date)
                  {
                    if ($date->getDate() === $dateString && $date->getStatus() === '0' 
                    && ($date->getPetSpecies() == $pet->getPetSpecies() || $date->getPetSpecies() == null)
                    && $dateController->checkDateForPet($date->getId(),$pet->getId()) == false)
                    {
                      $flag = 1;
                      $counterAux++;
                      break;
                    }
                  }
                  if ($flag=0)
                  {
                    break;
                  }
                }
                if ($counterAux == count($dateStringArray)){
                  array_push($keepersToShow,$keeper);
          
              }}
            }

          }else{ // ---------------------------------------- if no date or pet is entered: (shows all keepers)

            $keepersToShow = array_filter($keepersList,function($keeperToShow) {
                return ($keeperToShow->getUserRole() == 2 && $keeperToShow->GetId() !== $_SESSION['loggedUser']->GetId());
            });
            
        }

            $petList = $petDAO->getAll();

            require_once(VIEWS_PATH."keeper-list.php");
        }

        public function validateEmailExists($email){
          $ownerList = $this->GetAll();

          foreach($ownerList as $owner){
              if($email === $owner->getEmail()){
                  return true;
              }
          }
          return false;
      }
    }
?>