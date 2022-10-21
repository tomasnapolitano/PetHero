<?php 
    namespace Models;

    class Availability{

        //private $id;
        //private $keeperId;
        private $startDate;
        private $endDate;
        private $daysOfWeek = array();



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
         * Get the value of startDate
         */ 
        public function getStartDate()
        {
                return $this->startDate;
        }

        /**
         * Set the value of startDate
         *
         * @return  self
         */ 
        public function setStartDate($startDate)
        {
                $this->startDate = $startDate;

                return $this;
        }

        /**
         * Get the value of endDate
         */ 
        public function getEndDate()
        {
                return $this->endDate;
        }

        /**
         * Set the value of endDate
         *
         * @return  self
         */ 
        public function setEndDate($endDate)
        {
                $this->endDate = $endDate;

                return $this;
        }

        /**
         * Get the value of daysOfWeek
         */ 
        public function getDaysOfWeek()
        {
                return $this->daysOfWeek;
        }

        /**
         * Set the value of daysOfWeek
         *
         * @return  self
         */ 
        public function setDaysOfWeek($daysOfWeek)
        {
                $this->daysOfWeek = $daysOfWeek;

                return $this;
        }
    }
?>