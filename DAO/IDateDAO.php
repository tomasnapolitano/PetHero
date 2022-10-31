<?php 
    namespace DAO;

    use Models\Date as Date;

    interface IDateDAO
    {
        function add(Date $keeper);
        function getAll();
    }

?>