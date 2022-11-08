<?php 
    namespace DAO;

    use DAO\IReservationDAO as IReservationDAO;
    //use DAO\ReservationDAO as ReservationDAO;
    use Models\Reservation as Reservation;
    
    
    class ReservationDAO implements IReservationDAO {
        private $reservationList = array();
        private $filename = ROOT.'Data/Reservations.json';
        


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
                    $newReservation->setOwnerId($value['ownerId']);
                    $newReservation->setKeeperId($value['keeperId']);
                    $newReservation->setPetId($value['petId']);
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
                $value['ownerId'] = $reservation->getOwnerId();
                $value['keeperId'] = $reservation->getKeeperId();
                $value['petId'] = $reservation->getPetId();
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