<?php
    namespace Controllers;

    use Models\Date as Date;
    use DAO\DateDAO as DateDAO;
    // use Controllers\ValidationController as ValidationController;
    class DateController{
        private $dateDAO;
        //private $validation;
        
        function __construct()
        {
            $this->dateDAO = new DateDAO();
            //$this->validation = new ValidationController();
        }

        public function Add($date, $status, $keeperId) {

            $newDate = new Date();
            $newDate->setDate($date);
            $newDate->setStatus($status);
            $newDate->setKeeperId($keeperId);

            $this->dateDAO->Add($newDate);
        }

    }
?>