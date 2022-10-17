<?php 
    namespace DAO;

    use DAO\IKeeperDAO as IKeeperDAO;
    use Models\Keeper as Keeper;
    
    
    class KeeperDAO implements IKeeperDAO
    {
        private $keeperList = array();
        private $filename = ROOT.'Data/keepers.json';

        public function add(Keeper $keeper){

            $this->RetrieveData();

            array_push($this->keeperList, $keeper);
            
            $this->SaveData();
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->keeperList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->keeperList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                     $newKeeper = new Keeper();
                     $newKeeper->setUserName($value['userName']);
                     $newKeeper->setEmail($value['email']);
                     $newKeeper->setPassword($value['password']);
                     $newKeeper->setName($value['name']);
                     $newKeeper->setAvatar($value['avatar']);
                     $newKeeper->setLastName($value['lastName']);
                     $newKeeper->setUserRole($value['userRole']);

                     // Keeper specific:
                     $newKeeper->setPetSize($value['petSize']);
                     $newKeeper->setPrice($value['price']);
                     $newKeeper->setAvailability($value['availability']);

 
                     array_push($this->keeperList,$newKeeper);
                     
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->keeperList as $keeper)
            {
                $value = array();
                $value['userName'] = $keeper->getUsername();
                $value['email'] = $keeper->getEmail();
                $value['password'] = $keeper->getPassword();
                $value['name'] = $keeper->getName();
                $value['lastName'] = $keeper->getLastName();
                $value['avatar'] = $keeper->getAvatar();
                $value['userRole'] = $keeper->getUserRole();
                $value['petSize'] = $keeper->getPetSize();
                $value['price'] = $keeper->getPrice();
                $value['availability'] = $keeper->getAvailability();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }

    }



?>