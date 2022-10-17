<?php 
    namespace DAO;

    use Models\Keeper as Keeper;

    interface IKeeperDAO
    {
        function add(Keeper $keeper);
        function getAll();
    }

?>