<?php
    namespace DAO;

use Models\Reservation;
use DAO\DB_DateDAO;
use Models\Date;

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


            try {
                $this->connection = Connection::GetInstance();
                $lastId = $this->connection->ExecuteNonQuery($sql,$parameters,true);
                
                $sql_resXdates = "INSERT INTO reservationxdates (reservationId,dateId) VALUES (:reservationId,:dateId)";
                $parameters_resXdates['reservationId'] = $lastId;

                foreach($reservation->getDateList() as $date)
                {
                    $parameters_resXdates['dateId'] = $date->getId();
                    $this->connection->ExecuteNonQuery($sql_resXdates,$parameters_resXdates);

                    //updating each date status and petSpecies
                    $dateDAO = new DB_DateDAO();
                    $date->setPetSpecies($reservation->getPet()->getPetSpecies());
                    // $date->setStatus(???); not yet in use.
                    $dateDAO->Update($date);
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

        public function updateReservation(Reservation $reservation){

            $sql = "UPDATE " . $this->tableName . " SET 
            ownerId = :ownerId,
            keeperId = :keeperId,
            petId = :petId,
            amount = :amount,
            isAccepted = :isAccepted where reservationId = :reservationId";

            $parameters['ownerId'] = $reservation->getOwner()->getId();
            $parameters['keeperId'] = $reservation->getKeeper()->getId();
            $parameters['petId'] = $reservation->getPet()->getId();
            $parameters['amount'] = $reservation->getAmount();
            $parameters['isAccepted'] = $reservation->getIsAccepted();
            $parameters['reservationId'] = $reservation->getId();

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($sql,$parameters);
            }
            catch(\PDOException $e)
            {
                throw $e;
            }
        }

        public function Delete($id)
        {
            $reservation = $this->getById($id);

            $sql_resXdates = "DELETE FROM reservationxdates rxd WHERE reservationId = :id";
            $sql = "DELETE FROM " . $this->tableName . " WHERE reservationId = :id";
            
            $parameters['id'] = $id;

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($sql_resXdates,$parameters);
                $this->connection->ExecuteNonQuery($sql,$parameters);

                // checking: if after deleting reservation from resXdates, those dates
                // are still present in table, that means other reservations are 
                // connected to them. If that is not the case, modifying petSpecies from dates
                // back to NULL.
                foreach ($reservation->getDateList() as $date)
                {
                    $sql_dates = "SELECT * FROM reservationxdates WHERE dateId = :dateId";
                    $parameters_dates['dateId'] = $date->getId();

                    try {
                        $result = $this->connection->Execute($sql_dates,$parameters_dates);
                    }
                    catch(\PDOException $e)
                    {
                        throw $e;
                    }

                    if(empty($result))
                    {
                        $date->setPetSpecies(NULL);
                        $dateDAO = new DB_DateDAO();
                        $dateDAO->Update($date);
                    }
                }
                return true;
            }
            catch (\PDOException $e)
            {
                throw $e;
                return false;
            }
        }


        public function getById($id){
            $sql = "SELECT * FROM " . $this->tableName .  " WHERE reservationId = :id";

            $parameters['id'] = $id;

            try {
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);

            }
            catch(\PDOException $e)
            {
                throw $e;
            }

            if(!empty($result)){
                $result = $this->mapReservation($result);
                return $result['0'];
            }
            else{
                return null;
            }
        }

        protected function mapReservation($value){

            $value = is_array($value) ? $value : [];



            $resp = array_map(function($p){
                $ownerDAO = new DB_OwnerDAO();
                $keeperDAO = new DB_KeeperDAO(); // no deberían definirse en cada iteracion, pero si no se crean dentro del Function, no toma las variables.
                $petDAO = new DB_PetDAO();
                $dateDAO = new DB_DateDAO();

                $reservation = new Reservation();
                $reservation->setId($p['reservationId']);
                $reservation->setOwner($ownerDAO->getById($p['ownerId']));
                $reservation->setKeeper($keeperDAO->GetById($p['keeperId']));
                $reservation->setPet($petDAO->SearchById($p['petId']));
                $reservation->setDateList($this->getReservationDates($reservation->getId()));
                //$reservation->setId($p['dateId']);
                $reservation->setAmount($p['amount']);
                $reservation->setIsAccepted($p['isAccepted']);

                return $reservation;
            },$value);

            //return count($resp) > 1 ? $resp : $resp['0'];
            return $resp;
        }

        public function getReservationDates($reservationId)
        {
            $sql = "SELECT rxd.*, d.* from reservationxdates rxd 
            join date d on rxd.dateId = d.dateId where rxd.reservationId = :reservationId";

            $parameters['reservationId'] = $reservationId;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);
            }
            catch(\PDOException $e)
            {
                throw $e;
            }

            if(!empty($result)){
                return $this->mapReservationDates($result);
            }
            else{
                return array();
            }
        }

        protected function mapReservationDates($value)
        {
            $dateDAO = new DB_DateDAO();
            return $dateDAO->map($value);
        }
    }
?>