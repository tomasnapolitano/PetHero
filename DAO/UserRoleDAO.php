<?php 
    namespace DAO;

    use DAO\IUserRoleDAO as IUserRoleDAO;
    use Models\UserRole as UserRole;
    
    
    class UserRoleDAO implements IUserRoleDAO
    {
        private $userRoleList = array();
        private $filename = ROOT.'Data/userRoles.json';

        public function add(UserRole $userRole){
           
            $this->RetrieveData();

            array_push($this->userRoleList, $userRole);
            
            $this->SaveData();
            
        }

        public function getAll(){
            $this->RetrieveData();
            return $this->userRoleList;
        }


        public function RetrieveData()
        {
             if(file_exists($this->filename))
             {
                 $this->userRoleList = array();
                 $jsonToDecode = file_get_contents($this->filename);
 
                 $jsonArray = ($jsonToDecode) ? json_decode($jsonToDecode,true) : array();
 
                 foreach($jsonArray as $value)
                 {
                     $newUserRole = new UserRole();
                     $newUserRole->setRoleId($value['roleId']);
                     $newUserRole->setRoleName($value['roleName']);
                     $newUserRole->setDescription($value['description']);

 
                     array_push($this->userRoleList,$newUserRole);
                     
                 }
             }
             
        }

        public function SaveData()
        {
            $jsonArray = array();
            foreach($this->userRoleList as $userRole)
            {
                $value = array();
                $value['roleId'] = $userRole->getRoleId();
                $value['roleName'] = $userRole->getRoleName();
                $value['description'] = $userRole->getDescription();

                array_push($jsonArray,$value);
            }

            $content = json_encode($jsonArray,JSON_PRETTY_PRINT);
            file_put_contents($this->filename,$content);
        }


    }

    


?>