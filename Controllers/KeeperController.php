<?php
    namespace Controllers;

    use Models\Owner as Owner;
    use Models\Keeper as Keeper;
    use DAO\KeeperDAO as KeeperDAO;

    class KeeperController{
        private $KeeperDAO;
        
        function __construct()
        {
            $this->KeeperDAO = new KeeperDAO();
        }

        public function Add($petSize,$price,$availability)
        {
            require_once(VIEWS_PATH."validate-session.php");
            $keeper = new Keeper();
            $keeper->setPetSize($petSize);
            $keeper->setPrice($price);
            $keeper->setAvailability($availability);
            
            $this->KeeperDAO->Add($keeper);

            //$this->ShowAddView();

        }
    }
?>