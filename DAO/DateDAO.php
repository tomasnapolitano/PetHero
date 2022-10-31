<?php 
    namespace DAO;

    use DAO\IDateDAO as IDateDAO;
    use Models\Date as Date;

    class DateDAO implements IDateDAO
    {
        private $dateList = array();
        private $filename = ROOT.'Data/dates.json';

        public function add(Date $date){
           
            $this->RetrieveData();

            $date->setId($this->getNextId());

            array_push($this->dateList, $date);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->dateList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->dateList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                    $newDate = new Date();
                    $newDate->setId($value['id']);
                    $newDate->setDate($value['date']);
                    $newDate->setStatus($value['status']);
                    $newDate->setKeeperId($value['keeperId']);

 
                      array_push($this->dateList,$newDate);
                 }
             }
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->dateList as $date)
            {
                $value = array();
                $value['id'] = $date->getId();
                $value['date'] = $date->getDate();
                $value['status'] = $date->getStatus();
                $value['keeperId'] = $date->getKeeperId();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }

        private function getNextId()
        {
            $id = 0;
            
            foreach($this->dateList as $date)
            {
                $id = ($date->getId() > $id) ? $date->getId() : $id;
    
            }   
            
            return $id+1;
        }

    }

?>