<?php
    namespace DAO;

use Models\Owner;
use DAO\Connection;
use DAO\DB_DateDAO;
use Models\Availability;
use Models\Keeper;

    class DB_OwnerDAO implements IOwnerDAO {

        private $connection;
        private $tableName = "owner";

        public function add(Owner $owner)
        {
            $sql = "INSERT INTO " . $this->tableName . " (email,userName,password,name,lastName,avatar,userRole) VALUES (:email,:userName,:password,:name,:lastName,:avatar,:userRole)";
            //$sql = "INSERT INTO " . $this->tableName . " (email,userName,password,name,lastName,avatar,userRole) VALUES ('".$owner->getEmail()."','".$owner->getUserName()."','".$owner->getPassword()."','".$owner->getname()."','".$owner->getLastName()."','...',".$owner->getUserRole().")";

            $parameters['email'] = $owner->getEmail();
            $parameters['userName'] = $owner->getUserName();
            $parameters['password'] = $owner->getPassword();
            $parameters['name'] = $owner->getname();
            $parameters['lastName'] = $owner->getLastName();
            $parameters['avatar'] = $owner->getAvatar();
            $parameters['userRole'] = $owner->getUserRole();

            var_dump($parameters);

            echo " - creo el parameters";
            // agregar checkeo si es keeper o no, y completar la db como corresponda

            try {
                $this->connection = Connection::GetInstance();
                echo " - traigo la instance";
                return $this->connection->ExecuteNonQuery($sql,$parameters);
            }
            catch (\PDOException $ex) {
                throw $ex;
            }
        }

        public function getAll()
        {
            $sql = "SELECT owner.*, keeperInfo.* FROM owner LEFT JOIN keeperInfo on owner.ownerId = keeperInfo.ownerId";

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
                return array(); // previously returned: false
            }
        }

        protected function map($value)
        {
            $value = is_array($value) ? $value : [];

            echo "entre al map"; // ---------------------------------------------------------------------- BORRAR

            $resp = array_map(function($p){
                if ($p['is_keeper']==0){
                    $owner = new Owner();
                    $owner->setId($p['ownerId']);
                    $owner->setEmail($p['email']);
                    $owner->setUserName($p['userName']);
                    $owner->setPassword($p['password']);
                    $owner->setName($p['name']);
                    $owner->setLastName($p['lastName']);
                    $owner->setAvatar($p['avatar']);
                    $owner->setUserRole($p['userRole']);
                }
                else if ($p['is_keeper']==1)
                {
                    $owner = new Keeper();
                    $owner->setId($p['ownerId']);
                    $owner->setEmail($p['email']);
                    $owner->setUserName($p['userName']);
                    $owner->setPassword($p['password']);
                    $owner->setName($p['name']);
                    $owner->setLastName($p['lastName']);
                    $owner->setAvatar($p['avatar']);
                    $owner->setUserRole($p['userRole']);

                    //keeper info
                    $owner->setPetSize($p['petSize']);
                    $owner->setPrice($p['price']);

                    $availability = new Availability();
                    $availability->setStartDate($p['startDate']);
                    $availability->setEndDate($p['endDate']);

                    // building days of week in keeper's availability:
                    $sql = "SELECT kixdow.*, dow.dayName FROM keeperInfoXdaysOfWeek kixdow join daysOfWeek dow on kixdow.dayOfWeekId = dow.dayOfWeekId where kixdow.keeperInfoId = :keeperInfoId";

                    $parameters['keeperInfoId'] = $p['keeperInfoId'];
                    try{
                        $this->connection = Connection::GetInstance();
                        $result = $this->connection->Execute($sql,$parameters);

                        $arrayOfDays = array_map(function($d){return $d['dayName'];},$result);
                        $availability->setDaysOfWeek($arrayOfDays);
                    }
                    catch(\PDOException $e){
                        throw $e;
                    }

                    $owner->setAvailability($availability);

                    // building Date array of all keeper dates
                    $db_dateDAO = new DB_DateDAO();
                    $owner->setDateArray($db_dateDAO->getByKeeperId($owner->getId()));

                }
                return $owner;
            },$value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }


        public function GetByUserName($username)
        {
            $sql = "SELECT owner.*, keeperInfo.* FROM owner left join keeperInfo on owner.ownerId = keeperInfo.ownerId where owner.userName = :username";

            $parameters['username'] = $username;


            try {
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($sql,$parameters);

            }
            catch(\PDOException $e)
            {
                throw $e;
            }

            if(!empty($result)){
                return $this->map($result);
            }
            else{
                return null;
            }
        }
    }

?>