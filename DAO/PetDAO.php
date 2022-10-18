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
                     $newPet->setName($value['name']);
                     $newPet->setPicture($value['Picture']);
                     $newPet->setPetSpecies($value['petSpecies']);
                     $newPet->setVideo($value['video']);

 
                     array_push($this->petList,$newPet);
                     
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
                $value['Picture'] = $pet->getPicture();
                $value['petSpecies'] = $pet->getPetSpecies();
                $value['Video'] = $pet->getVideo();

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