<?php
    namespace Models;

    class UserRole {
        
        private $roleId;
        private $roleName;
        private $description;
        

        /**
         * Get the value of roleId
         */ 
        public function getRoleId()
        {
                return $this->roleId;
        }

        /**
         * Set the value of roleId
         *
         * @return  self
         */ 
        public function setRoleId($roleId)
        {
                $this->roleId = $roleId;

                return $this;
        }

        /**
         * Get the value of roleName
         */ 
        public function getRoleName()
        {
                return $this->roleName;
        }

        /**
         * Set the value of roleName
         *
         * @return  self
         */ 
        public function setRoleName($roleName)
        {
                $this->roleName = $roleName;

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