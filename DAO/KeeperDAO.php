<?php 
    namespace DAO;

    use DAO\IKeeperDAO as IKeeperDAO;
    use Models\Keeper as Keeper;
    use Models\Owner as Owner;
    
    
    class KeeperDAO implements IKeeperDAO
    {
        private $keeperList = array();
        private $filename = ROOT.'Data/owners.json';

        public function add(Keeper $keeper){

            $this->RetrieveData();

            array_push($this->keeperList, $keeper);
            
            $this->SaveData();
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->keeperList;
        }


       /* public function RetrieveData()
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
             
        }*/

        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->keeperList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
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

                    else if ($value['userRole'] == 2) //Keeper Role
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
                         $newOwner->setAvailability($value['availability']);
                         $newOwner->setUserRole($value['userRole']);
                    }
                     array_push($this->keeperList,$newOwner);
                     
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->keeperList as $owner)
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

                if ($owner->getUserRole() == 2){ // checkeo si es keeper
                    $value['petSize'] = $owner->getPetSize();
                    $value['price'] = $owner->getPrice();
                    $value['availability'] = $owner->getAvailability();
                }
                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


        public function RemoveByUserName($userName){

            $this->RetrieveData();

            $this->keeperList = array_filter($this->keeperList, function($keeper) use($userName){
                return $keeper->getUserName() != $userName;});

            $this->SaveData();
        }
    }



?>