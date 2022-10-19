<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Keeper as Keeper;
    use DAO\KeeperDAO as KeeperDAO;
    use Controllers\OwnerController as OwnerController;

    class KeeperController{
        private $KeeperDAO;
        private $ownerController;


        function __construct()
        {
            $this->KeeperDAO = new KeeperDAO();
            $this->ownerController = new OwnerController();
        }

        public function ShowRegisterView(){
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."register-keeper.php");
        }

        public function Add($petSize,$price,$availability)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];
            $keeper = new Keeper();
            
            $keeper->setUserName($owner->getUserName());
            $keeper->setEmail($owner->getEmail());
            $keeper->setPassword($owner->getPassword());
            $keeper->setName($owner->getName());
            $keeper->setLastName($owner->getLastName());
            $keeper->setAvatar($owner->getAvatar());
            $keeper->setPetList(array());
            $keeper->setUserRole(2);

            
            $keeper->setPetSize($petSize);
            $keeper->setPrice($price);
            $keeper->setAvailability($availability);
            
            $this->KeeperDAO->Add($keeper);

            $this->ShowRegisterView();

        }

    }
?>