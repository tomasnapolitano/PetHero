<?php 
    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use DAO\DateDAO as DateDAO;
    use Models\Date;
    use Models\Keeper;
    use Models\Availability;
    use Models\Owner as Owner;
    use DAO\Connection as Connection;
    use \Exception as Exception;
    
    
    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();
        private $filename = ROOT.'Data/owners.json';
        private $dateDAO;
        //private $connection;
        //private $tableName = "owner";

        function __construct()
        {
            $this->dateDAO = new DateDAO();
        }

        public function add(Owner $owner){
           
            $this->RetrieveData();

            $owner->setId($this->getNextId());

            array_push($this->ownerList, $owner);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->ownerList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->ownerList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();

                 //populate array of all dates:
                 $dateArray = $this->dateDAO->getAll();
 
                 foreach($jsonArray as $value)
                 {
                    if($value['userRole'] == 1){ //Owner Role

                     $newOwner = new Owner();
                     $newOwner->setId($value['id']);
                     $newOwner->setUserName($value['userName']);
                     $newOwner->setEmail($value['email']);
                     $newOwner->setPassword($value['password']);
                     $newOwner->setName($value['name']);
                     $newOwner->setLastName($value['lastName']);
                     $newOwner->setAvatar($value['avatar']);
                     $newOwner->setUserRole($value['userRole']);
                    }
                    if ($value['userRole'] == 2) //Keeper Role
                     {
                        $newOwner = new Keeper();
                        $newOwner->setId($value['id']);
                        $newOwner->setUserName($value['userName']);
                        $newOwner->setEmail($value['email']);
                        $newOwner->setPassword($value['password']);
                        $newOwner->setName($value['name']);
                        $newOwner->setLastName($value['lastName']);
                        $newOwner->setAvatar($value['avatar']);
                        $newOwner->setPetSize($value['petSize']);
                        $newOwner->setPrice($value['price']);
                        $newOwner->setUserRole($value['userRole']);
                        // building Availability:
                        $availability = new Availability();
                        $availability->setStartDate($value['startDate']);
                        $availability->setEndDate($value['endDate']);
                        $availability->setDaysOfWeek($value['daysOfWeek']);

                        $newOwner->setAvailability($availability);

                        $auxId = $newOwner->getId();
                        $keeperDateArray = array_filter($dateArray,function ($date) use($auxId){
                            return $date->getKeeperId() == $auxId;
                        });
                        $newOwner->setDateArray($keeperDateArray);
                    }
                     array_push($this->ownerList,$newOwner);
                     
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->ownerList as $owner)
            {
                $value = array();
                $value['id'] = $owner->getId();
                $value['userName'] = $owner->getUsername();
                $value['email'] = $owner->getEmail();
                $value['password'] = $owner->getPassword();
                $value['name'] = $owner->getName();
                $value['lastName'] = $owner->getLastName();
                $value['avatar'] = $owner->getAvatar();
                $value['userRole'] = $owner->getUserRole();

                if($owner->getUserRole() == 2)
                {
                    $value['petSize'] = $owner->getPetSize();
                    $value['price'] = $owner->getPrice();

                    // Availability:
                    $availability = $owner->getAvailability();
                    $value['startDate'] = $availability->getStartDate();
                    $value['endDate'] = $availability->getEndDate();
                    $value['daysOfWeek'] = $availability->getDaysOfWeek();
                }

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


        private function getNextId()
        {
            $id = 0;
            
            foreach($this->ownerList as $owner)
            {
                $id = ($owner->getId() > $id) ? $owner->getId() : $id;

            }   
            
            return $id+1;
        }

        public function GetByUserName($userName){
            
            $this->RetrieveData();

            $owner = null;

            $owners = array_filter($this->ownerList, function($owner) use($userName){
                return $owner->getUserName() == $userName;
            });

            $owners = array_values($owners);

            return (count($owners) > 0) ? $owners[0] : null;
        }


                /*public function add(Owner $owner)
        {
            try
                {
                    $query = "INSERT INTO ".$this->tableName." (email, userName, password, name, lastName, avatar, userRole) VALUES (:userName, :email, :password, :name, :lastName :avatar :userRole);";
                    
                    $parameters["email"] = $owner->getEmail();
                    $parameters["userName"] = $owner->getUserName();
                    $parameters["password"] = $owner->getPassword();
                    $parameters["name"] = $owner->getname();
                    $parameters["lastname"] = $owner->getLastName();
                    $parameters["avatar"] = $owner->getAvatar();
                    $parameters["userRole"] = $owner->getUserRole();
                    
    
                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($query, $parameters);
                }
                catch(Exception $ex)
                {
                    throw $ex;
                }
        }
    
            public function getAll()
        {
            try
            {
                $ownerList = array();
                $query = "SELECT * FROM ".$this->tableName;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $owner = new Owner();
                    $owner->setId($row["ownerId"]);
                    $owner->setUserName($row["userName"]);
                    $owner->setEmail($row["email"]);
                    $owner->setPassword($row["password"]);
                    $owner->setName($row["name"]);
                    $owner->setLastName($row["lastName"]);
                    $owner->setAvatar($row["avatar"]);
                    $owner->setUserRole($row["userRole"]);
    
                    array_push($ownerList, $owner);
                }
    
                return $ownerList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }   */


    }

?>