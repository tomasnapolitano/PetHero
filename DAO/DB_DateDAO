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
                return $this->connection->ExecuteNonQuery($sql,$parameters,true);
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

        protected function map($value)
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


    }
?>