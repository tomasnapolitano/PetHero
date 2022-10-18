<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use DAO\OwnerDAO as OwnerDAO;
    class OwnerController{
        private $ownerDAO;
        
        function __construct()
        {
            $this->ownerDAO = new OwnerDAO();
        }

        public function Add($email,$userName,$password,$name,$lastName,$avatar)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner->setUserName($userName);
            $owner->setEmail($email);
            $owner->setPassword($password);
            $owner->setName($name);
            $owner->setLastName($lastName);
            $owner->setAvatar($avatar);
            $owner->setPetList(array());
            $owner->setUserRole(1);
            
            $this->ownerDAO->Add($owner);

            //$this->ShowAddView();

        }

        public function ShowAddView(){
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-owner.php");
        }

        public function addPet(){


        }
    }
?>