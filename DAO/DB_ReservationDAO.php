<?php
    namespace DAO;

use Models\Reservation;

    class DB_ReservationDAO implements IReservationDAO { 

        private $connection;
        private $tableName = "reservation";

        public function add(Reservation $reservation)
        {
            $sql = "INSERT INTO " . $this->tableName . " (ownerId,keeperId,petId,amount,isAccepted) VALUES (:ownerId,:keeperId,:petId,:amount,:isAccepted)";

            $parameters['ownerId'] = $reservation->getOwner()->getId();
            $parameters['keeperId'] = $reservation->getKeeper()->getId();
            $parameters['petId'] = $reservation->getPet()->getId();
            
            $parameters['amount'] = $reservation->getAmount();
            $parameters['isAccepted'] = $reservation->getIsAccepted();
echo "antes del try del add del DAO - ";

            try {
                $this->connection = Connection::GetInstance();
echo "antes del execunoncueri - ";
$lastId = $this->connection->ExecuteNonQuery($sql,$parameters,true);
echo "despues del execunoncueri - ";
                
                $sql_resXdates = "INSERT INTO reservationxdates (reservationId,dateId) VALUES (:reservationId,:dateId)";
                $parameters_resXdates['reservationId'] = $lastId;

                foreach($reservation->getDateList() as $date)
                {
                    $parameters_resXdates['dateId'] = $date->getId();
                    $this->connection->ExecuteNonQuery($sql_resXdates,$parameters_resXdates);
                }
            }
            catch (\PDOException $ex) {
                throw $ex;
            }

        }

        public function getAll()
        {
            $sql = "SELECT * FROM " . $this->tableName;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql);

            }
            catch(\PDOException $e){
                throw $e;
            }

            if(!empty($result)){
                return $this->mapReservation($result);
            }
            else{
                return false;
            }
        }

        protected function mapReservation($value){

            $value = is_array($value) ? $value : [];



            $resp = array_map(function($p){
                $ownerDAO = new DB_OwnerDAO();
                $keeperDAO = new DB_KeeperDAO(); // no deberían definirse en cada iteracion, pero si no se crean dentro del Function, no toma las variables.
                $petDAO = new DB_PetDAO();

                $reservation = new Reservation();
                $reservation->setId($p['reservationId']);
                $reservation->setOwner($ownerDAO->getById($p['ownerId']));
                $reservation->setKeeper($keeperDAO->GetById($p['keeperId']));
                $reservation->setPet($petDAO->SearchById($p['petId']));
                //$reservation->setId($p['dateId']);
                $reservation->setAmount($p['amount']);
                $reservation->setIsAccepted($p['isAccepted']);

                return $reservation;
            },$value);

            //return count($resp) > 1 ? $resp : $resp['0'];
            return $resp;
        }
    }
?>