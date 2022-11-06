<?php
    namespace Models;

    class Date {

        private $id;
        private $date;
        private $status;
        private $keeperId;
        private $petSpecies;


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of date
         */ 
        public function getDate()
        {
                return $this->date;
        }

        /**
         * Set the value of date
         *
         * @return  self
         */ 
        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }

        /**
         * Get the value of status
         */ 
        public function getStatus()
        {
                return $this->status;
        }

        /**
         * Set the value of status
         *
         * @return  self
         */ 
        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        /**
         * Get the value of keeperId
         */ 
        public function getKeeperId()
        {
                return $this->keeperId;
        }

        /**
         * Set the value of keeperId
         *
         * @return  self
         */ 
        public function setKeeperId($keeperId)
        {
                $this->keeperId = $keeperId;

                return $this;
        }

        /**
         * Get the value of petSpecies
         */ 
        public function getPetSpecies()
        {
                return $this->petSpecies;
        }

        /**
         * Set the value of petSpecies
         *
         * @return  self
         */ 
        public function setPetSpecies($petSpecies)
        {
                $this->petSpecies = $petSpecies;

                return $this;
        }
    }
?>