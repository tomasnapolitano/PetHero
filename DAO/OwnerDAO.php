<?php 
    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    
    
    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();
        private $filename = ROOT.'Data/owners.json';

        public function add(Owner $owner){
           
            $this->RetrieveData();

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
 
                 foreach($jsonArray as $value)
                 {
                     $newOwner = new Owner();
                     $newOwner->setUserName($value['userName']);
                     $newOwner->setEmail($value['email']);
                     $newOwner->setPassword($value['password']);
                     $newOwner->setName($value['name']);
                     $newOwner->setLastName($value['lastName']);
                     $newOwner->setAvatar($value['avatar']);
                     $newOwner->setUserRole($value['userRole']);

 
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
                $value['userName'] = $owner->getUsername();
                $value['email'] = $owner->getEmail();
                $value['password'] = $owner->getPassword();
                $value['name'] = $owner->getName();
                $value['lastName'] = $owner->getLastName();
                $value['avatar'] = $owner->getAvatar();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


    }

    


?>