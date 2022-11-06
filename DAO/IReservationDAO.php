<?php 
    namespace DAO;

    use Models\Reservation as Reservation;

    interface IReservationDAO
    {
        function add(Reservation $reservation);
        function getAll();
    }

?>