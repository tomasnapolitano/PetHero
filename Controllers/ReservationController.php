<?php 
    namespace Controllers;

    use Models\Reservation;
    use Models\Pet;
    use Models\Keeper;
    use Models\Owner;
    use Controllers\KeeperController;
    use Controllers\DateController;
    use Controllers\PetController;
    use Controllers\OwnerController;
    use Controllers\homeController;
    use DAO\ReservationDAO;
    use DAO\DB_ReservationDAO;

    class ReservationController {
        private $reservationDAO;

        public function __construct()
		{
			$this->reservationDAO= new DB_ReservationDAO();
		}

        public function add($keeperId, $petId, $dateString)
		{
			require_once(VIEWS_PATH . "validate-session.php");
            $owner = $_SESSION['loggedUser'];
            $isAccepted = null;
            $dateController = new DateController();
            $keeperController = new KeeperController();
            $petController = new PetController();
            $homeController = new HomeController();
            
            $keeper = $keeperController->GetById($keeperId);
            $pet = $petController->SearchById($petId);
            $dateStringArray = explode(",",$dateString);
            
			$reservation = new Reservation();
            $reservation->setDateList($dateController->GetByKeeperIdAndDate($keeperId,$dateStringArray));
			$reservation->setOwner($owner);
			$reservation->setKeeper($keeper);
			$reservation->setPet($pet);
			$reservation->setAmount($keeper->getPrice()*count($dateStringArray));
            $reservation->setIsAccepted($isAccepted);	

            $this->reservationDAO->Add($reservation);

            $homeController->ShowHomeView("Reservation placed succesfully! Remember: Reservation must be confirmed by keeper.");
		}

        public function ShowCreateReservationView($keeperId, $petId, $reservationDate, $message = "")
        {
            require_once(VIEWS_PATH . "validate-session.php");
            $keeperController = new KeeperController();
            $ownerController = new OwnerController();
            $petController = new PetController();


            if (isset($_POST['keeperId']) && isset($_POST['petId']) && isset($_POST['reservationDate'])){
          
                $keeperId = $_POST['keeperId'];
                $keeper = $keeperController->GetById($keeperId);
                $petId = $_POST['petId'];
                $pet = $petController->SearchById($petId);
                $reservationDate = $_POST['reservationDate'];
                $dateStringArray = explode(",",$reservationDate);
                require_once(VIEWS_PATH . "create-reservation.php");
                
            }
            else{
                $ownerController->ShowKeeperListView("Error en el envio de datos!");
            }

        }

        public function ShowReservationListView()
        {
            $reservationList = $this->reservationDAO->getAll();
            $reservationList = ($reservationList == false) ? array() : $reservationList;
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."reservation-list.php");
        }


        public function ConfirmReservation($reservationId)
        {
            require_once(VIEWS_PATH."validate-session.php");

            $reservation = $this->reservationDAO->getById($reservationId);
            if ($_SESSION['loggedUser']->getId() == $reservation->getKeeper()->getId())
            {
                $reservation->setIsAccepted(true);
                $this->reservationDAO->updateReservation($reservation);
                $this->ShowReservationListView("Reservation was Confirmed successfully.");
            }
            $this->ShowReservationListView("Error in operation.");
            
            
        }
        
        public function RejectReservation($reservationId)
        {
            require_once(VIEWS_PATH."validate-session.php");
            
            $reservation = $this->reservationDAO->getById($reservationId);
            
            if ($_SESSION['loggedUser']->getId() == $reservation->getKeeper()->getId())
            {
                $reservation->setIsAccepted(0);
                $this->reservationDAO->updateReservation($reservation);
                $this->ShowReservationListView("Reservation was Rejected successfully.");
            }
            
            $this->ShowReservationListView("Error in operation.");
        }

        //Solamente disponible para Owners:
        public function CancelReservation($reservationId)
        {
            require_once(VIEWS_PATH."validate-session.php");
            
            $reservation = $this->reservationDAO->getById($reservationId);

            if ($_SESSION['loggedUser']->getId() == $reservation->getOwner()->getId())
            {
                $this->reservationDAO->delete($reservation->getId());
                $this->ShowReservationListView("Reservation was Cancelled successfully.");
            }
            
            $this->ShowReservationListView("Error in operation.");
        }
    }
 ?>