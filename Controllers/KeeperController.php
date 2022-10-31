<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Keeper as Keeper;
    use Models\Date as Date;
    use DAO\KeeperDAO as KeeperDAO;
    use Controllers\OwnerController as OwnerController;
    use Controllers\DateController as DateController;
use Models\Availability;

    class KeeperController{
        private $KeeperDAO;
        private $ownerController;


        function __construct()
        {
            $this->KeeperDAO = new KeeperDAO();
            $this->ownerController = new OwnerController();
            $this->dateController = new DateController();
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

        public function Add($petSize,$price)
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
            
            // building Availability:
            $keeper->setAvailability($this->BuildAvailability());
            // building Dates:
            
            
            $this->KeeperDAO->Add($keeper);
            $_SESSION['loggedUser'] = $keeper;

            $this->ShowKeeperHomeView();

        }

        private function BuildAvailability()
        {
            if ($_POST){
                $availability = new Availability();
                
                if(isset($_POST['startDate'])){
                    $availability->setStartDate($_POST['startDate']);
                }
                if(isset($_POST['endDate'])){
                    $availability->setEndDate($_POST['endDate']);
                }
                if(($_POST['daysOfWeek'])){
                    $availability->setDaysOfWeek($_POST['daysOfWeek']);
                }
            }

            return $availability;
        }

        public function ShowHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

    }
?>