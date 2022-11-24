<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Keeper as Keeper;
    use Models\Date as Date;
    use DAO\KeeperDAO as KeeperDAO;
    use DAO\DB_KeeperDAO as DB_KeeperDAO;
    use Controllers\OwnerController as OwnerController;
    use Controllers\DateController as DateController;
use Models\Availability;

    class KeeperController{
        private $KeeperDAO;


        function __construct()
        {
            $this->KeeperDAO = new DB_KeeperDAO();
        }

        public function ShowRegisterView($message = ""){
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

        public function Add($petSize,$price, $startDate, $endDate, $daysOfWeek)
        {
            require_once(VIEWS_PATH."validate-session.php");
            try{
                $dateController = new DateController();
                $owner = new Owner();
                $owner = $_SESSION['loggedUser'];
                
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
                if($keeper->setAvailability($this->BuildAvailability($startDate,$endDate,$daysOfWeek)) !== null) 
                {
                    if($dateController->AddFromAvailability($keeper->getAvailability(),$keeper->getId()) !== false)
                    {
                        // $this->KeeperDAO->RemoveByUserName($owner->getUserName());

                        // saving keeper to DAO and setting them to active user:


                        $this->KeeperDAO->Add($keeper);
                        $_SESSION['loggedUser'] = $keeper;
                    } else {$this->ShowRegisterView("Selected Weekdays are not included in date range.");}
                }

                $this->ShowKeeperHomeView();
            }
            catch(\PDOException $e)
            {
                $this->ShowRegisterView("Error de Conexión: " . $e->getMessage());
            }
        }

        private function BuildAvailability($startDate,$endDate,$daysOfWeek) // no buscar las variables al POST, recibirlas por parametro
        {
            $availability = new Availability();
            
            if(isset($startDate)){
                $availability->setStartDate($startDate);
            } else {$this->ShowRegisterView("Please select a Starting Date!"); return null;}
            if(isset($endDate)){
                $availability->setEndDate($endDate);
            } else {$this->ShowRegisterView("Please select an End Date!"); return null;}
            if(isset($daysOfWeek)){
                $availability->setDaysOfWeek($daysOfWeek);
            } else {$this->ShowRegisterView("Please select at least one Day of the Week!"); return null;}
            

            return $availability;
        }

        public function GetById($id){
            return $this->KeeperDAO->GetById($id);
        }
        
        public function ShowHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

    }
?>