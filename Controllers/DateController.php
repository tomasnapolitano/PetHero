<?php
    namespace Controllers;

    use Models\Date as Date;
    use DAO\DateDAO as DateDAO;
    use DAO\DB_DateDAO as DB_DateDAO;
use DateInterval;
use DatePeriod;
use DateTime;
use Models\Availability as Availability;

    // use Controllers\ValidationController as ValidationController;
    class DateController{
        private $dateDAO;
        //private $validation;
        
        function __construct()
        {
            $this->dateDAO = new DB_DateDAO();
            //$this->validation = new ValidationController();
        }

        public function Add($date, $status, $keeperId, $petSpecies = null) {

            $newDate = new Date();
            $newDate->setDate($date);
            $newDate->setStatus($status);
            $newDate->setKeeperId($keeperId);
            $newDate->setPetSpecies($petSpecies);

            $this->dateDAO->Add($newDate);
        }

        // public function AddFromAvailability(Availability $availability,$keeperId)
        // {
        //     $auxDate = date_create($availability->getStartDate());
        //     $auxEndDate = date_create($availability->getEndDate());

        //     while ($auxDate <= $auxEndDate)
        //     {
        //         if(!empty($availability->getDaysOfWeek()) && in_array(date('l',date_format($auxDate,'Y-m-d')),$availability->getDaysOfWeek()))
        //         {
        //             $newDate = new Date();
        //             $newDate->setDate(date('Y-m-d'), $auxDate);
        //             $newDate->setStatus("Available");
        //             $newDate->setKeeperId($keeperId);

        //             $this->dateDAO->Add($newDate);
        //         }
        //         date_add($auxDate,date_interval_create_from_date_string("1 days"));
        //     }
        // }

        public function AddFromAvailability(Availability $availability, $keeperId){

            $beginDate = new DateTime($availability->getStartDate());
            $endDate = new DateTime($availability->getEndDate());
            date_add($endDate, date_interval_create_from_date_string("1 day")); // adding 1 day to correctly include last day as a date.

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($beginDate,$interval,$endDate);

            $counter = 0;
            foreach ($period as $day)
            {
                if(!empty($availability->getDaysOfWeek()) && in_array(date_format($day,'l'),$availability->getDaysOfWeek()))
                {
                    $counter++;
                    $newDate = new Date();
                    $newDate->setDate(date_format($day,'Y-m-d'));
                    $newDate->setStatus(0);
                    $newDate->setKeeperId($keeperId);
                    $newDate->setPetSpecies(null);

                    $this->dateDAO->Add($newDate);
                }
            }

            if ($counter==0)
            {
                return false;
            }
            return true;
        }
    }
?>