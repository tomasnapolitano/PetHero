<?php 
    namespace Controllers;

    use Models\Reservation;
    use Models\Pet;
    use DAO\ReservationDAO;

    class ReservationController {
        private $reservationDAO;

        public function __construct()
		{
			$this->reservationDAO= new ReservationDAO();
		}

        public function add($keeper, $pet, $dateList)
		{
			require_once(VIEWS_PATH . "validate-session.php");
			$reservation = new Reservation();
            $owner = $_SESSION['loggedUser'];
            $isAccepted = null;

			$reservation->setOwner($owner->getId());
			$reservation->setKeeper($keeper);
			
			$reservation->setPet($pet);
			$reservation->setAmount($keeper->getPrice());
			$reservation->setIsAccepted($isAccepted);	

            $this->ReservationDAO->Add($reservation);
		}
    }
 ?>