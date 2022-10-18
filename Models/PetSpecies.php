<?php
    namespace Models;

    class UserRole {
        
        private $speciesId;
        private $speciesName;
        private $description;
        

        

        /**
         * Get the value of speciesId
         */ 
        public function getSpeciesId()
        {
                return $this->speciesId;
        }

        /**
         * Set the value of speciesId
         *
         * @return  self
         */ 
        public function setSpeciesId($speciesId)
        {
                $this->speciesId = $speciesId;

                return $this;
        }

        /**
         * Get the value of speciesName
         */ 
        public function getSpeciesName()
        {
                return $this->speciesName;
        }

        /**
         * Set the value of speciesName
         *
         * @return  self
         */ 
        public function setSpeciesName($speciesName)
        {
                $this->speciesName = $speciesName;

                return $this;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }
    }
?>