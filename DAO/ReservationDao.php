<?php 
    namespace DAO;

    use DAO\IReservationDAO as IReservationDAO;
    //use DAO\ReservationDAO as ReservationDAO;
    use Models\Reservation as Reservation;
    
    
    class ReservationDAO implements IReservationDAO {
        private $reservationList = array();
        private $filename = ROOT.'Data/Reservations.json';
        private $ReservationDAO;

        function __construct()
        {
            $this->ReservationDAO = new ReservationDAO();
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
                    $newReservation->setOwner($value['Owner']);
                    $newReservation->setKeeper($value['Keeper']);
                    $newReservation->setPet($value['Pet']);
                    $newReservation->setDateList($value['DateList']);
                    $newReservation->setAmount($value['Amount']);
                    $newReservation->setIsAccepted($value['IsAccepted']);
                
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
                $value['Owner'] = $reservation->getOwner();
                $value['Keeper'] = $reservation->getKeeper();
                $value['Pet'] = $reservation->getPet();
                $value['DateList'] = $reservation->getDateList();
                $value['Amount'] = $reservation->getAmount();
                $value['IsAccepted'] = $reservation->getIsAccepted();

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