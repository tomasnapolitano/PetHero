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
            $owner = $_SESSION['loggedUser'];
            $isAccepted = null;
            $dateController = new DateController();
            
            $keeper = $this->keeperController->GetById($keeperId);
            $pet = $this->petController->SearchById($petId);
            $dateStringArray = explode(",",$dateString);
            
			$reservation = new Reservation();
            $reservation->setDateList($dateController->GetByKeeperIdAndDate($keeperId,$dateStringArray));
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
            }
            
           
        }

        public function RejectReservation($reservationId)
        {
            require_once(VIEWS_PATH."validate-session.php");

            $reservation = $this->reservationDAO->getById($reservationId);
            if ($_SESSION['loggedUser']->getId() == $reservation->getKeeper()->getId())
            {
                $reservation->setIsAccepted(false);
                $this->reservationDAO->updateReservation($reservation);
            }

        }

        //Solamente disponible para Owners:
        public function CancelReservation($reservationId)
        {
            require_once(VIEWS_PATH."validate-session.php");

            $reservation = $this->reservationDAO->getById($reservationId);
            if ($_SESSION['loggedUser']->getId() == $reservation->getOwner()->getId())
            {
                $this->reservationDAO->delete($reservation->getId());
            }

        }
    }
 ?>