<?php
    namespace DAO;

use Models\Pet;

    class DB_PetDAO implements IPetDAO{

        private $connection;
        private $tableName = "pet";

        public function add(Pet $pet)
        {
            $sql = "INSERT INTO " . $this->tableName . " (ownerId,name,picture,petSpecies,video,breed,size,vacPlan,vacObs) VALUES (:ownerId,:name,:picture,:petSpecies,:video,:breed,:size,:vacPlan,:vacObs)";

            $parameters['ownerId'] = $pet->getOwnerId();
            $parameters['name'] = $pet->getName();
            $parameters['picture'] = $pet->getPicture();
            $parameters['petSpecies'] = $pet->getPetSpecies();
            $parameters['video'] = $pet->getVideo();
            $parameters['breed'] = $pet->getBreed();
            $parameters['size'] = $pet->getSize();
            $parameters['vacPlan'] = $pet->getVacPlan();
            $parameters['vacObs'] = $pet->getVacObs();

            echo "bindie los parameters";
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

        public function SearchById($id){

            $sql = "SELECT * FROM pet where petId = :id";
            $parameters['id'] = $id;

            try{
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);
                return $this->map($result);
            }
            catch(\PDOException $e)
            {
                throw $e;
            }
        }

        protected function map($value)      
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $pet = new Pet();
                $pet->setId($p['petId']);
                $pet->setOwnerId($p['ownerId']);
                $pet->setName($p['name']);
                $pet->setPicture($p['picture']);
                $pet->setPetSpecies($p['petSpecies']);
                $pet->setVideo($p['video']);
                $pet->setBreed($p['breed']);
                $pet->setSize($p['size']);
                $pet->setVacPlan($p['vacPlan']);
                $pet->setVacObs($p['vacObs']);

                return $pet;
            },$value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>