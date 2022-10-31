<?php 
    namespace DAO;

    use DAO\IPetDAO as IPetDAO;
    use Models\Pet as Pet;

    class PetDAO implements IPetDAO
    {
        private $petList = array();
        private $filename = ROOT.'Data/pets.json';

        public function add(Pet $pet){
           
            $this->RetrieveData();

            $pet->setId($this->getNextId());

            array_push($this->petList, $pet);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->petList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->petList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                    $newPet = new Pet();
                    $newPet->setId($value['id']);
                    $newPet->setName($value['name']);
                    $newPet->setPicture($value['picture']);
                    $newPet->setPetSpecies($value['petSpecies']);
                    $newPet->setVideo($value['video']);
                    $newPet->setBreed($value['breed']);
                    $newPet->setSize($value['size']);
                    $newPet->setVacPlan($value['vacPlan']);
                    $newPet->setVacObs($value['vacObs']);
                    $newPet->setOwnerId($value['ownerId']);
                    
                    

                    // if ($value['petSpecies'] == 1){ //checkeo que sea Dog

                    //  $newDog = new Dog();
                    //  $newDog->setId($value['id']);
                    //  $newDog->setName($value['name']);
                    //  $newDog->setPicture($value['picture']);
                    //  $newDog->setPetSpecies($value['petSpecies']);
                    //  $newDog->setVideo($value['video']);
                    //  $newDog->setBreed($value['breed']);
                    //  $newDog->setSize($value['size']);
                    //  $newDog->setVacPlan($value['vacPlan']);
                    //  $newDog->setVacObs($value['vacObs']);
                    //  $newDog->setOwnerId($value['ownerId']);

 
                      array_push($this->petList,$newPet);
                    // }
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->petList as $pet)
            {
                $value = array();
                $value['id'] = $pet->getId();
                $value['name'] = $pet->getName();
                $value['picture'] = $pet->getPicture();
                $value['petSpecies'] = $pet->getPetSpecies();
                $value['video'] = $pet->getVideo();
                $value['ownerId'] = $pet->getOwnerId();
                $value['breed'] = $pet->getBreed();
                $value['size'] = $pet->getSize();
                $value['vacPlan'] = $pet->getVacPlan();
                $value['vacObs'] = $pet->getVacObs();

                
                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }

        private function getNextId()
        {
            $id = 0;
            
            foreach($this->petList as $pet)
            {
                $id = ($pet->getId() > $id) ? $pet->getId() : $id;
    
            }   
            
            return $id+1;
        }

    }

?>