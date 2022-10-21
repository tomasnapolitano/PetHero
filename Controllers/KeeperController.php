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

        public function ShowKeeperHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."keeper-home.php");
        }

        public function ShowKeeperSetAvailability()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."keeper-availability.php");
        }

        public function Add($petSize,$price,$availability = NULL)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $owner = new Owner();
            $owner = $_SESSION['loggedUser'];

            $this->KeeperDAO->RemoveByUserName($owner->getUserName());
            $keeper = new Keeper();
            
            $keeper->setId($owner->getId());
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

            $this->ShowKeeperHomeView();

        }

        public function ShowHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

    }
?>