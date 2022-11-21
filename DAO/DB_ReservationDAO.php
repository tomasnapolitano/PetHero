<?php
    namespace DAO;

use Models\Reservation;

    class DB_ReservationDAO implements IReservationDAO { 

        private $connection;
        private $tableName = "reservation";

        public function add(Reservation $reservation)
        {
            $sql = "INSERT INTO " . $this->tableName . " (ownerId,keeperId,petId,dateId,amount,isAccepted) VALUES (:ownerId,:keeperId,:petId,:dateId,:amount,:isAccepted)";

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
                }
            }
            catch (\PDOException $ex) {
                throw $ex;
            }

        }

        public function getAll()
        {
            
        }
    }
?>