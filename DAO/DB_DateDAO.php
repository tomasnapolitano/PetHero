<?php
    namespace DAO;

use Models\Date;

    class DB_DateDAO implements IDateDAO{

        private $connection;
        private $tableName = "date";

        public function add(Date $newDate)
        {
            $sql = "INSERT INTO " . $this->tableName . " (date,status,keeperId,petSpecies) VALUES (:date,:status,:keeperId,:petSpecies)";

            $parameters['date'] = $newDate->getDate();
            $parameters['status'] = $newDate->getStatus();
            $parameters['keeperId'] = $newDate->getKeeperId();
            $parameters['petSpecies'] = $newDate->getPetSpecies();

            try {
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($sql,$parameters);
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
                return $this->map($result);
            }
            else{
                return false;
            }
        }

        public function getByKeeperId($id)
        {
            $sql = "SELECT * FROM " . $this->tableName . " where keeperId = :id";

            $parameters["id"] = $id;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);

            }
            catch(\PDOException $e){
                throw $e;
            }

            if(!empty($result)){
                return $this->map($result);
            }
            else{
                return false;
            }
        }

        public function getById($id)
        {
            $sql = "SELECT * FROM " . $this->tableName . " where dateId = :id";

            $parameters["id"] = $id;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);

            }
            catch(\PDOException $e){
                throw $e;
            }

            if(!empty($result)){
                return $this->map($result);
            }
            else{
                return false;
            }
        }

        public function GetByKeeperIdAndDate($keeperId,$dateStringArray)
        {
            // $sql = "SELECT * FROM " . $this->tableName . " where keeperId = :id AND date = :date";

            // $parameters["id"] = $keeperId;

            // try{
            //     $this->connection = Connection::GetInstance();
            //     $result = $this->connection->Execute($sql,$parameters);

            // }
            // catch(\PDOException $e){
            //     throw $e;
            // }

            // if(!empty($result)){
            //     return $this->map($result);
            // }
            // else{
            //     return false;
            // }

            $allKeeperDates = $this->getByKeeperId($keeperId);
            $result = array();

            if ($allKeeperDates)
            {
                foreach ($dateStringArray as $date)
                {
                    $auxResult = array_filter($allKeeperDates, function ($d) use($date)
                    {
                        return $d->getdate() === $date;
                    });

                    foreach($auxResult as $selectedDate)
                    {
                        array_push($result,$selectedDate);
                    }
                }
            }
            return $result;

        }

        public function Update(Date $date)
        {
            $sql = "UPDATE " . $this->tableName . " SET 
            date = :date,
            status = :status,
            keeperId = :keeperId,
            petSpecies = :petSpecies WHERE dateId = :dateId";

            $parameters['date'] = $date->getDate();
            $parameters['status'] = $date->getStatus();
            $parameters['keeperId'] = $date->getKeeperId();
            $parameters['petSpecies'] = $date->getPetSpecies();
            $parameters['dateId'] = $date->getId();

            try{
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($sql,$parameters);
                return true;
            }
            catch(\PDOException $e)
            {
                throw $e;
                return false;
            }
        }

        public function map($value)
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $newDate = new Date();
                $newDate->setId($p['dateId']);
                $newDate->setDate($p['date']);
                $newDate->setStatus($p['status']);
                $newDate->setKeeperId($p['keeperId']);
                $newDate->setPetSpecies($p['petSpecies']);

                return $newDate;
            },$value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }

        // checks if a particular Date is assigned to a particular Pet by any reservation.
        public function checkDateForPet($dateId,$petId)
        {
            $sql = "SELECT r.*, rxd.*, d.* FROM reservationxdates rxd 
            join date d on rxd.dateId = d.dateId
            join reservation r on r.reservationId = rxd.reservationId WHERE rxd.dateId = :dateId";

            $parameters['dateId'] = $dateId;

            try {
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);

                foreach ($result as $resXdate)
                {
                    if ($resXdate['petId'] == $petId && ($resXdate['isAccepted']==1 || $resXdate['isAccepted']===null))
                    {
                        return true;
                    }
                }
            }
            catch(\PDOException $e)
            {
                throw $e;
            }
            return false;
        }

    }
?>