<?php 
    namespace DAO;

    use DAO\IDogDAO as IDogDAO;
    use Models\Pet as Pet;
    use Models\Dog as Dog;

    class DogDAO implements IDogDAO
    {
        private $petList = array();
        private $filename = ROOT.'Data/pets.json';

        public function add(Dog $dog){
           
            $this->RetrieveData();

            $dog->setId($this->getNextId());

            array_push($this->petList, $dog);
            
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
                    if ($value['petSpecies'] == 1){ //checkeo que sea Dog

                     $newDog = new Dog();
                     $newDog->setName($value['name']);
                     $newDog->setPicture($value['picture']);
                     $newDog->setPetSpecies($value['petSpecies']);
                     $newDog->setVideo($value['video']);
                     $newDog->setBreed($value['breed']);
                     $newDog->setSize($value['size']);
                     $newDog->setVacPlan($value['vacPlan']);
                     $newDog->setVacObs($value['vacObs']);
                     $newDog->setOwnerId($value['ownerId']);

 
                     array_push($this->petList,$newDog);
                    }
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->petList as $pet)
            {
                $value = array();
                $value['name'] = $pet->getName();
                $value['picture'] = $pet->getPicture();
                $value['petSpecies'] = $pet->getPetSpecies();
                $value['video'] = $pet->getVideo();
                $value['ownerId'] = $pet->getOwnerId();
                if($pet->getPetSpecies() == 1){ // checkeo que sea de tipo Dog
                    $value['breed'] = $pet->getBreed();
                    $value['size'] = $pet->getSize();
                    $value['vacPlan'] = $pet->getVacPlan();
                    $value['vacObs'] = $pet->getVacObs();

                }
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