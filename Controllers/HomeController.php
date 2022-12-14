<?php
    namespace Controllers;

    use DAO\OwnerDAO as OwnerDAO;
    use DAO\DB_OwnerDAO as DB_OwnerDAO;
    class HomeController
    {

        private $ownerDAO;

        public function __construct()
        {
            $this->ownerDAO = new DB_OwnerDAO();
        }

        public function Index($message = "")
        {
            require_once(VIEWS_PATH."login.php");
        }        


        public function ShowHomeView($message = "")
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."home.php");
        }

        public function Login($userName, $password)
        {
            try {
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
            catch (\mysqli_sql_exception $sql)
            {
                $this->Index("Error de SQL: " . $sql->GetMessage());
            }
            catch (\PDOException $e)
            {
                $this->Index("Error de Conexión: " . $e->GetMessage());
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