<?php
    namespace DAO;

use Models\Keeper;
use DAO\DB_OwnerDAO;

    class DB_KeeperDAO implements IKeeperDAO{

        private $tableName = "keeperInfo";
        private $connection;

        public function add(Keeper $keeper)
        {
            $sql_keeperInfo = "INSERT INTO " . $this->tableName . " (ownerId,petSize,price,startDate,endDate) VALUES (:ownerId,:petSize,:price,:startDate,:endDate)";

            $parameters['ownerId'] = $keeper->getId();
            $parameters['petSize'] = $keeper->getPetSize();
            $parameters['price'] = $keeper->getPrice();
            $parameters['startDate'] = $keeper->getAvailability()->getStartDate();
            $parameters['endDate'] = $keeper->getAvailability()->getEndDate();

            try{
                $this->connection = Connection::GetInstance();
                $keeperInfoId = $this->connection->ExecuteNonQuery($sql_keeperInfo,$parameters,true);

                foreach ($keeper->getAvailability()->getDaysOfWeek() as $weekDay)
                {
                    // getting weekday Id from daysOfWeek Table
                    $sql_daysOfWeek = "SELECT dayOfWeekId from daysOfWeek where dayName = :weekDay";
                    $parametersDOW['weekDay'] = $weekDay;
                    $result = $this->connection->Execute($sql_daysOfWeek,$parametersDOW);
                    $dayOfWeekId = $this->mapDayOfWeek($result);

                    $sql_insertKIXDOW = "INSERT INTO keeperInfoXdaysOfWeek (keeperInfoId,dayOfWeekId) VALUES (:keeperInfoId,:dayOfWeekId)";
                    $parametersKIXDOW['keeperInfoId'] = $keeperInfoId;
                    $parametersKIXDOW['dayOfWeekId'] = $dayOfWeekId;

                    $this->connection->ExecuteNonQuery($sql_insertKIXDOW,$parametersKIXDOW);
                }
            }
            catch (\PDOException $e)
            {
                throw $e;
            }

            try { 
                $sql_isKeeper = "UPDATE TABLE owner SET is_keeper = 1 where ownerId = :ownerId";

                $parametersIsKeeper['ownerId'] = $keeper->getId();
                $this->connection->ExecuteNonQuery($sql_isKeeper,$parametersIsKeeper);
            }
            catch (\PDOException $e)
            {
                throw $e;
            }

        }

        public function getAll()
        {
            
        }

        public function GetById($id)
        {
            $DB_ownerDAO = new DB_OwnerDAO();
            return $DB_ownerDAO->GetById($id);
        }

        protected function mapDayOfWeek($value)      
        {
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $weekDayId = $p['dayOfWeekId'];
                return $weekDayId;
            },$value);

            return count($resp) > 1 ? $resp : $resp['0'];
        }
    }
?>