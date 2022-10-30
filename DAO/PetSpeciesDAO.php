<?php 
    namespace DAO;

    use DAO\IPetSpeciesDAO as IPetSpeciesDAO;
    use Models\PetSpecies as PetSpecies;
    
    
    class PetSpeciesDAO implements IPetSpeciesDAO
    {
        private $petSpeciesList = array();
        private $filename = ROOT.'Data/petSpecies.json';

        public function add(PetSpecies $petSpecies){
           
            $this->RetrieveData();

            array_push($this->petSpeciesList, $petSpecies);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->petSpeciesList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->petSpeciesList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                     $newPetSpecies = new PetSpecies();
                     $newPetSpecies->setSpeciesId($value['speciesId']);
                     $newPetSpecies->setSpeciesName($value['speciesName']);
                     $newPetSpecies->setDescription($value['description']);

 
                     array_push($this->petSpeciesList,$newPetSpecies);
                     
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->petSpeciesList as $petSpecies)
            {
                $value = array();
                $value['speciesId'] = $petSpecies->getSpeciesId();
                $value['speciesName'] = $petSpecies->getSpeciesName();
                $value['description'] = $petSpecies->getDescription();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


    }

    


?>