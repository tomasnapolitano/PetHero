<?php
    namespace Controllers;

    use Models\Keeper as Keeper;
    use DAO\KeeperDAO as KeeperDAO;

    class KeeperController{
        private $KeeperDAO;
        
        function __construct()
        {
            $this->KeeperDAO = new KeeperDAO();
        }

        public function AddKeeper($petSize,$price,$availability)
        {
            $keeper = new Keeper();
            $keeper->setPetSize($petSize);
            $keeper->setPrice($price);
            $keeper->setAvailability($availability);
            
            $this->KeeperDAO->Add($keeper);

            //$this->ShowAddView();

        }
    }
?>