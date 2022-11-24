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
        
        function __construct()
        {
            $this->dateDAO = new DB_DateDAO();
        }

        public function Add($date, $status, $keeperId, $petSpecies = null) {

            $newDate = new Date();
            $newDate->setDate($date);
            $newDate->setStatus($status);
            $newDate->setKeeperId($keeperId);
            $newDate->setPetSpecies($petSpecies);

            $this->dateDAO->Add($newDate);
        }


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

        public function checkDateForPet($dateId,$petId)
        {
            return $this->dateDAO->checkDateForPet($dateId,$petId);
        }

        public function GetByKeeperIdAndDate($keeperId,$dateStringArray)
        {
            return $this->dateDAO->GetByKeeperIdAndDate($keeperId,$dateStringArray);
        }
    }
?>