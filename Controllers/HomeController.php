<?php
    namespace Controllers;

    use DAO\OwnerDAO as OwnerDAO;
    class HomeController
    {

        private $ownerDAO;

        public function __construct()
        {
            $this->ownerDAO = new OwnerDAO();
        }

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }        


        public function Login($userName, $password)
        {
            $user = $this->ownerDAO->GetByUserName($userName);

            if(($user != null) && ($user->getPassword() === $password))
            {
                $_SESSION["loggedUser"] = $user;
                //$this->ShowAddView();
            }
            else{
                $this->Index("Usuario y/o Contraseña incorrectos");
            }
        }
    }
?>