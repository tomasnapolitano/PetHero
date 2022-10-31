<?php
    namespace Controllers;

    use Models\Date as Date;
    use DAO\DateDAO as DateDAO;
use Models\Availability as Availability;

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

        public function AddFromAvailability(Availability $availability,$keeperId)
        {
            $auxDate = $availability->getStartDate();

            while ($auxDate <= $availability->getEndDate())
            {
                if(in_array(date('l',strtotime($auxDate)),$availability->getDaysOfWeek()))
                {
                    $newDate = new Date();
                    $newDate->setDate($auxDate);
                    $newDate->setStatus("Available");
                    $newDate->setKeeperId($keeperId);

                    $this->dateDAO->Add($newDate);
                }
                date_add($auxDate,date_interval_create_from_date_string("1 days"));
            }
        }
    }
?>