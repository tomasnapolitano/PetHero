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

        public function Add($userName,$email,$password,$name,$lastName,$avatar)
        {
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
    }
?>