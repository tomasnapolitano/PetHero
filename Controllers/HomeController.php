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
            require_once(VIEWS_PATH."login.php");
        }        


        public function ShowHomeView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

        public function Login($userName, $password)
        {
            $user = $this->ownerDAO->GetByUserName($userName);

            if(($user != null) && ($user->getPassword() === $password))
            {
                $_SESSION["loggedUser"] = $user;
                $this->ShowHomeView();
            }
            else{
                $this->Index("Usuario y/o Contraseña incorrectos");
            }
        }

        public function Logout()
        {
            require_once(VIEWS_PATH."validate-session.php");
            
            session_destroy();
            
            require_once(VIEWS_PATH."login.php");
        }
    }
?>