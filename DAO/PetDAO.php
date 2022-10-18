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
                     $newPet->setSpecies($value['species']);
                     $newPet->setVacPlan($value['vacPlan']);
                     $newPet->setVacObs($value['VacObs']);
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
                $value['Species'] = $pet->getSpecies();
                $value['VacPlan'] = $pet->getVacPlan();
                $value['VacObs'] = $pet->getVacObs();
                $value['Video'] = $pet->getVideo();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


    }

?>