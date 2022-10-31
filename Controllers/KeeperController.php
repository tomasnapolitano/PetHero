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
        private $dateController;


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
            $keeper->setPetList(array()); // Hacer que busque sus Pets actuales y no las pise con un array vacio (guarda con el nuevo ID)
            $keeper->setUserRole(2);

            
            $keeper->setPetSize($petSize);
            $keeper->setPrice($price);
            
            // building Availability:
            $keeper->setAvailability($this->BuildAvailability());

            // saving keeper to and searching in DAO to get new ID correctly.
            $this->KeeperDAO->Add($keeper);
            $_SESSION['loggedUser'] = $this->KeeperDAO->GetByUserName($keeper->getUserName());
            
            // building Dates:
            $this->dateController->AddFromAvailability($keeper->getAvailability(),$keeper->getId());


            // Deberíamos recibir lo elegido en el POST de Keeper-register 
            // y comparar cada fecha a partir (inclusive) de la fecha startDate y hasta
            // (inclusive) la fecha endDate con los días de la semana elegidos en DaysOfWeek.
            // con cada dia que coincida, crear un objeto Date y sumarlo con el DateDAO, con
            // su respectivo keeperId para identificar cada Date con un keeper.



            

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