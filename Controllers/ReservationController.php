<?php 
    namespace Controllers;

    use Models\Reservation;
    use Models\Pet;
    use Models\Keeper;
    use Models\Owner;
    use Controllers\KeeperController;
    use Controllers\PetController;
    use Controllers\OwnerController;
    use DAO\ReservationDAO;

    class ReservationController {
        private $reservationDAO;
        private $keeperController;
        private $ownerController;
        private $petController;

        public function __construct()
		{
			$this->reservationDAO= new ReservationDAO();
            $this->keeperController = new KeeperController();
            $this->petController = new PetController();
            $this->ownerController = new OwnerController();
		}

        public function add($keeper, $pet, $dateList)
		{
			require_once(VIEWS_PATH . "validate-session.php");
			$reservation = new Reservation();
            $owner = $_SESSION['loggedUser'];
            $isAccepted = null;
            $amount = calculateTotalPrice($keeper, $dateList)

			$reservation->setOwner($owner->getId());
			$reservation->setKeeper($keeper);
			
			$reservation->setPet($pet);
			$reservation->setAmount($amount);
			$reservation->setIsAccepted($isAccepted);	

            $this->ReservationDAO->Add($reservation);
		}

        public function ShowCreateReservationView($message = "")
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
    }
 ?>