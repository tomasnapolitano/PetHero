<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Pet as Pet;
    use DAO\OwnerDAO as OwnerDAO;
    use DAO\PetDAO as PetDAO;
    
    use Controllers\ValidationController as ValidationController;
    use Controllers\PetController as PetController;
    class OwnerController{
        private $ownerDAO;
        private $petDAO;
        private $validation;
        //private $petController;
        
        function __construct()
        {
            $this->ownerDAO = new OwnerDAO();
            $this->petDAO = new PetDAO();
            //$this->petController = new PetController(); creates a Loop because of constructors in PetController and OwnerController.
            $this->validation = new ValidationController();
        }

        public function Add($email,$userName,$password,$name,$lastName,$avatar)
        {
            //require_once(VIEWS_PATH."validate-session.php");

           // if ($this->GetByUserName($userName) !== null)
            // {
            if ($this->validation->validateUserName($userName))
                {
                    $owner = new Owner();
                    $owner->setUserName($userName);

                    if($this->validation->validatePassword($password))
                        {
                            $owner->setPassword($password);
                            
                            if($this->validation->validateName($name) && $this->validation->validateName($lastName))
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

           // } else { $this->ShowRegisterView("Username is already taken. Try a different one."); }

            $this->ShowLoginView();

        }

        public function GetByUserName ($userName){
            $this->ownerDAO->GetByUserName($userName);
        }

        public function ShowRegisterView($message = ""){
            //require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."register-owner.php");
        }

        public function ShowLoginView(){
            require_once(VIEWS_PATH."login.php");
        }

        public function ShowHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

        public function ShowKeeperListView(){
            require_once(VIEWS_PATH."validate-session.php");

            $keepersList = $this->ownerDAO->getAll();
            $keepersList = array_filter($keepersList, function($keeper){
                return $keeper->getUserRole() == 2;
            });
            $petList = $this->petDAO->getAll();
            require_once(VIEWS_PATH."keeper-list.php");
        }
    }
?>