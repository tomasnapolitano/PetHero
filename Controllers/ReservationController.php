<?php 
    namespace Controllers;

    use Models\Reservation;
    use Models\Pet;
    use Models\Keeper;
    use Models\Owner;
    use Controllers\KeeperController;
    use Controllers\PetController;
    use Controllers\OwnerController;
    use Controllers\homeController;
    use DAO\ReservationDAO;
    use DAO\DB_ReservationDAO;

    class ReservationController {
        private $reservationDAO;
        private $keeperController;
        private $ownerController;
        private $petController;
        private $homeController;

        public function __construct()
		{
			$this->reservationDAO= new DB_ReservationDAO();
            $this->keeperController = new KeeperController();
            $this->petController = new PetController();
            $this->ownerController = new OwnerController();
            $this->homeController = new homeController();
		}

        public function add($keeperId, $petId, $dateString)
		{
			require_once(VIEWS_PATH . "validate-session.php");
			$reservation = new Reservation();
            $owner = $_SESSION['loggedUser'];
            $isAccepted = null;

            $keeper = $this->keeperController->GetById($keeperId);
            $pet = $this->petController->SearchById($petId);
            $dateStringArray = explode(",",$dateString);

			$reservation->setOwner($owner);
			$reservation->setKeeper($keeper);
			$reservation->setPet($pet);
			$reservation->setAmount($keeper->getPrice()*count($dateStringArray));

			$reservation->setIsAccepted($isAccepted);	

            $this->reservationDAO->Add($reservation);

            $this->homeController->ShowHomeView("Reservation placed succesfully! Remember: Reservation must be confirmed by keeper.");
		}

        public function ShowCreateReservationView($keeperId, $petId, $reservationDate, $message = "")
        {
            require_once(VIEWS_PATH . "validate-session.php");


            if (isset($_POST['keeperId']) && isset($_POST['petId']) && isset($_POST['reservationDate'])){
          
                $keeperId = $_POST['keeperId'];
                $keeper = $this->keeperController->GetById($keeperId);
                $petId = $_POST['petId'];
                $pet = $this->petController->SearchById($petId);
                $reservationDate = $_POST['reservationDate'];
                $dateStringArray = explode(",",$reservationDate);
                require_once(VIEWS_PATH . "create-reservation.php");
                
            }
            else{
                $this->ownerController->ShowKeeperListView("Error en el envio de datos!");
            }

        }

        public function ShowReservationListView()
        {
            $reservationList = $this->reservationDAO->getAll();
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."reservation-list.php");
        }

        // ambos metodos debajo deben ser correjidos, para que la logica la haga el dao.

        public function ConfirmReservation($petId)
        {

            $reservationList = $this->reservationDAO->getAll();
            foreach($reservationList as $reservation){

            if ($_SESSION['loggedUser']->getId() == $reservation->getKeeper()->GetId() && $petId == $reservation->getPet()->getId())
            {              
                $reservation->setIsAccepted(1);
                $this->reservationDAO->SaveData();   
                require_once(VIEWS_PATH."reservation-list.php");          
            }
            }
            
           
        }

        public function RejectReservation($petId)
        {
        
            $reservationList = $this->reservationDAO->getAll();
            foreach($reservationList as $reservation){

            if ($_SESSION['loggedUser']->getId() == $reservation->getKeeper()->GetId() && $petId == $reservation->getPet()->getId())
            {
                
                $reservation->setIsAccepted(0);
                $this->reservationDAO->SaveData();
                
            }
            }
            

        }
    }
 ?>