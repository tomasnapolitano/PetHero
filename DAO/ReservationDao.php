<?php 
    namespace DAO;

    use DAO\IReservationDAO as IReservationDAO;
    //use DAO\ReservationDAO as ReservationDAO;
    use DAO\PetDAO as PetDAO;
    use DAO\OwnerDAO as OwnerDAO;
    use DAO\KeeperDAO as KeeperDAO;
    use Models\Reservation as Reservation;
    
    
    class ReservationDAO implements IReservationDAO {
        private $reservationList = array();
        private $filename = ROOT.'Data/Reservations.json';
        private $petDAO;
        private $ownerDAO;
        private $keeperDAO;
        
        function __construct()
        {
            $this->petDAO = new PetDAO();
            $this->ownerDAO = new OwnerDAO();
            $this->keeperDAO = new KeeperDAO();
        }

        public function add(Reservation $reservation){
           
            $this->RetrieveData();

            $reservation->setId($this->getNextId());

            array_push($this->reservationList, $reservation);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->reservationList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->reservationList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                    $newReservation = new Reservation();
                    $newReservation->setOwner($this->keeperDAO->GetById($value['ownerId']));
                    $newReservation->setKeeper($this->keeperDAO->GetById($value['keeperId']));
                    $newReservation->setPet($this->petDAO->searchById($value['petId']));
                    $newReservation->setDateIdList($value['dateIdList']);
                    $newReservation->setAmount($value['amount']);
                    $newReservation->setIsAccepted($value['isAccepted']);
                
                    array_push($this->reservationList,$newReservation);
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->reservationList as $reservation)
            {
                $value = array();
                $value['ownerId'] = $reservation->getOwner()->getId();
                $value['keeperId'] = $reservation->getKeeper()->getId();
                $value['petId'] = $reservation->getPet()->getId();
                $value['dateIdList'] = $reservation->getDateIdList();
                $value['amount'] = $reservation->getAmount();
                $value['isAccepted'] = $reservation->getIsAccepted();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }

        private function getNextId()
        {
            $id = 0;
            
            foreach($this->reservationList as $reservation)
            {
                $id = ($reservation->getId() > $id) ? $reservation->getId() : $id;

            }   
            
            return $id+1;
        }
    }

?>